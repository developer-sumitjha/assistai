<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ImageGeneration;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ImageController extends Controller
{
    /**
     * Display the image generation interface.
     */
    public function index()
    {
        $generations = auth()->user()->imageGenerations()->latest()->get();
        
        $allowedImageModelsRaw = Setting::get('allowed_image_models', '["google/gemini-3.1-flash-image-preview"]');
        $allowedModels = json_decode($allowedImageModelsRaw, true) ?: ['google/gemini-3.1-flash-image-preview'];
        
        $modelNames = [
            'google/gemini-3.1-flash-image-preview' => 'Gemini 3.1 Flash Image',
            'google/gemini-3-pro-image-preview' => 'Gemini 3 Pro Image',
            'openai/dall-e-3' => 'DALL-E 3',
        ];

        return view('pwa.image_gen', compact('generations', 'allowedModels', 'modelNames'));
    }

    /**
     * Handle the image generation request.
     */
    public function generate(Request $request)
    {
        $request->validate([
            'prompt' => 'required|string|max:1000',
            'model' => 'required|string',
            'aspect_ratio' => 'nullable|string',
            'image_size' => 'nullable|string',
        ]);

        $user = auth()->user();
        $cost = 5.0; // Fixed cost for image generation

        if ($user->credits < $cost) {
            return response()->json([
                'success' => false,
                'error' => 'Insufficient credits. Each image costs 5 credits.',
            ], 403);
        }

        $apiKey = config('services.openrouter.key');
        $baseUrl = config('services.openrouter.base_url');

        try {
            $payload = [
                'model' => $request->model,
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => $request->prompt
                    ]
                ],
                'modalities' => ['image', 'text'],
            ];

            // Add image config if provided
            if ($request->aspect_ratio || $request->image_size) {
                $payload['image_config'] = [];
                if ($request->aspect_ratio) {
                    $payload['image_config']['aspect_ratio'] = $request->aspect_ratio;
                }
                if ($request->image_size) {
                    $payload['image_config']['image_size'] = $request->image_size;
                }
            }

            $response = Http::withHeaders([
                'Authorization' => "Bearer $apiKey",
                'Content-Type' => 'application/json',
                'HTTP-Referer' => config('app.url'),
                'X-OpenRouter-Title' => 'AssistAI Dashboard',
            ])->timeout(60)->post("$baseUrl/chat/completions", $payload);

            if ($response->successful()) {
                $data = $response->json();
                $message = $data['choices'][0]['message'] ?? [];
                
                if (isset($message['images']) && count($message['images']) > 0) {
                    $imageDataBase64 = $message['images'][0]['image_url']['url'];
                    
                    // The URL is usually data:image/png;base64,...
                    // Extract the base64 part
                    if (preg_match('/^data:image\/(\w+);base64,/', $imageDataBase64, $type)) {
                        $imageData = substr($imageDataBase64, strpos($imageDataBase64, ',') + 1);
                        $type = strtolower($type[1]); // png, jpg, etc.
                        $imageData = base64_decode($imageData);
                        
                        if ($imageData === false) {
                            throw new \Exception('base64_decode failed');
                        }
                    } else {
                        // Fallback if it's already just base64 or a different format
                        $imageData = base64_decode($imageDataBase64);
                        $type = 'png';
                    }

                    $fileName = \Illuminate\Support\Str::uuid() . '.' . $type;
                    $filePath = 'generated_images/' . $fileName;

                    // Save to filesystem
                    \Illuminate\Support\Facades\Storage::disk('public')->put($filePath, $imageData);

                    // Save to database
                    $generation = $user->imageGenerations()->create([
                        'prompt' => $request->prompt,
                        'image_path' => $filePath,
                        'model' => $request->model,
                        'credits_spent' => $cost,
                    ]);

                    // Deduct credits
                    $user->decrement('credits', $cost);

                    // Log transaction
                    $user->creditTransactions()->create([
                        'amount' => $cost,
                        'type' => 'subtract',
                        'description' => "AI Image Gen ($request->model)",
                    ]);

                    return response()->json([
                        'success' => true,
                        'image_url' => $generation->imageUrl,
                        'generation_id' => $generation->id
                    ]);
                }

                return response()->json([
                    'success' => false, 
                    'error' => 'No image was returned by the AI. Please try a different prompt.'
                ], 500);
            }

            $error = $response->json('error.message') ?? 'Unknown API error occurred.';
            return response()->json([
                'success' => false,
                'error' => "API Error: $error",
            ], $response->status());

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Connection to AI service failed: ' . $e->getMessage(),
            ], 500);
        }
    }
}
