<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TtsController extends Controller
{
    public function index()
    {
        $generations = auth()->user()->ttsGenerations()->latest()->get();

        // Dynamically fetch models from OpenRouter caching for 24 hours (86400 seconds)
        $models = Cache::remember('openrouter_tts_models', 86400, function () {
            $apiKey = config('services.openrouter.key');
            $baseUrl = config('services.openrouter.base_url');

            try {
                $response = Http::withHeaders([
                    'Authorization' => "Bearer $apiKey",
                    'HTTP-Referer' => config('app.url'),
                    'X-OpenRouter-Title' => 'AssistAI Dashboard',
                ])->get("$baseUrl/models", [
                    'output_modalities' => 'speech'
                ]);

                if ($response->successful()) {
                    $speechModels = $response->json('data') ?? [];
                    
                    // Fallback if none found
                    if (empty($speechModels)) {
                        return [
                            ['id' => 'openai/gpt-4o-mini-tts-2025-12-15', 'name' => 'OpenAI GPT-4o Mini TTS'],
                            ['id' => 'google/gemini-3.1-flash-tts-preview', 'name' => 'Gemini 3.1 TTS Preview'],
                        ];
                    }

                    return array_values($speechModels);
                }
            } catch (\Throwable $e) {
                // Ignore exception and use fallback below
            }

            return [
                ['id' => 'openai/tts-1', 'name' => 'OpenAI TTS-1'],
                ['id' => 'openai/tts-1-hd', 'name' => 'OpenAI TTS-1 HD'],
            ];
        });

        // We map standard voices if they are not dynamically provided
        $voices = [
            'alloy' => 'Alloy (OpenAI - Neutral)',
            'echo' => 'Echo (OpenAI - Male)',
            'fable' => 'Fable (OpenAI - British Male)',
            'onyx' => 'Onyx (OpenAI - Deep Male)',
            'nova' => 'Nova (OpenAI - Female)',
            'shimmer' => 'Shimmer (OpenAI - Soft Female)',
            'Puck' => 'Puck (Gemini)',
            'Charon' => 'Charon (Gemini)',
            'Kore' => 'Kore (Gemini)',
            'Fenrir' => 'Fenrir (Gemini)',
            'Aoede' => 'Aoede (Gemini)',
        ];

        return view('pwa.tts', compact('generations', 'models', 'voices'));
    }

    public function generate(Request $request)
    {
        $request->validate([
            'input_text' => 'required|string|max:4096',
            'model' => 'required|string',
            'voice' => 'nullable|string',
            'response_format' => 'nullable|string|in:mp3,pcm',
            'speed' => 'nullable|numeric|min:0.25|max:4.0',
        ]);

        $user = auth()->user();
        $cost = 5.0; // Fixed cost for TTS generation

        if ($user->credits < $cost) {
            return response()->json([
                'success' => false,
                'error' => "Insufficient credits. Each generation costs $cost credits.",
            ], 403);
        }

        $apiKey = config('services.openrouter.key');
        $baseUrl = config('services.openrouter.base_url');
        $format = $request->response_format ?: 'mp3';
        $voice = $request->voice ?: 'alloy';
        $fileExtension = $format;

        // Compatibility fallbacks for Gemini models
        if (str_contains(strtolower($request->model), 'gemini')) {
            $openaiVoices = ['alloy', 'echo', 'fable', 'onyx', 'nova', 'shimmer'];
            if (in_array(strtolower($voice), $openaiVoices)) {
                $voice = 'Puck'; // Default Gemini voice
            }
            // Gemini only supports pcm via OpenRouter, which returns a WAV file
            $format = 'pcm';
            $fileExtension = 'wav';
        } else if (str_contains(strtolower($request->model), 'openai')) {
            $geminiVoices = ['puck', 'charon', 'kore', 'fenrir', 'aoede'];
            if (in_array(strtolower($voice), $geminiVoices)) {
                $voice = 'alloy'; // Default OpenAI voice
            }
        }

        if ($format === 'pcm') {
            $fileExtension = 'wav';
        }

        try {
            $payload = [
                'model' => $request->model,
                'input' => $request->input_text,
                'voice' => $voice,
                'response_format' => $format,
                'speed' => (float) ($request->speed ?: 1.0),
            ];

            $fileName = Str::uuid() . '.' . $fileExtension;
            $filePath = 'tts/' . $fileName;
            
            // Create directory if not exists
            Storage::disk('public')->makeDirectory('tts');
            
            $absolutePath = Storage::disk('public')->path($filePath);

            $response = Http::withHeaders([
                'Authorization' => "Bearer $apiKey",
                'Content-Type' => 'application/json',
                'HTTP-Referer' => config('app.url'),
                'X-OpenRouter-Title' => 'AssistAI Dashboard',
            ])->timeout(120)->sink($absolutePath)->post("$baseUrl/audio/speech", $payload);

            if ($response->successful()) {
                
                // If format is pcm, OpenRouter returns raw headerless PCM bytes. 
                // We must wrap it in a proper WAV header so HTML5 <audio> can play it.
                if ($format === 'pcm') {
                    $pcmData = file_get_contents($absolutePath);
                    $wavData = $this->addWavHeader($pcmData, 24000, 1, 16);
                    file_put_contents($absolutePath, $wavData);
                }

                $generationId = $response->header('X-Generation-Id') ?: null;

                $generation = $user->ttsGenerations()->create([
                    'input_text' => $request->input_text,
                    'model' => $request->model,
                    'voice' => $payload['voice'],
                    'response_format' => $format,
                    'speed' => $payload['speed'],
                    'audio_file_path' => $filePath,
                    'generation_id' => $generationId,
                    'credits_spent' => $cost,
                ]);

                // Deduct credits
                $user->decrement('credits', $cost);

                // Log transaction
                $user->creditTransactions()->create([
                    'amount' => $cost,
                    'type' => 'subtract',
                    'description' => "AI Text-to-Speech ({$request->model})",
                ]);

                return response()->json([
                    'success' => true,
                    'audio_url' => $generation->audio_url,
                    'generation' => $generation
                ]);
            }

            // Cleanup failed sink file
            if (file_exists($absolutePath)) {
                @unlink($absolutePath);
            }

            // Attempt to parse json error from response body
            // Since we used sink, the response body might be empty or in the file. 
            // We should read the file before deleting it if it was created, to get the error payload.
            $errorMsg = 'Unknown API error occurred.';
            
            if ($response->status() !== 200) {
                // If it failed, let's just make a normal request without sink to get the error cleanly
                $errResp = Http::withHeaders([
                    'Authorization' => "Bearer $apiKey",
                    'Content-Type' => 'application/json',
                    'HTTP-Referer' => config('app.url'),
                    'X-OpenRouter-Title' => 'AssistAI Dashboard',
                ])->post("$baseUrl/audio/speech", $payload);
                
                $errorMsg = $errResp->json('error.message') ?? $errResp->body();
            }

            return response()->json([
                'success' => false,
                'error' => "API Error: $errorMsg",
            ], $response->status());

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Connection to AI service failed: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function generateScript(Request $request)
    {
        $request->validate([
            'prompt' => 'required|string|max:1000'
        ]);
        
        $apiKey = config('services.openrouter.key');
        $baseUrl = config('services.openrouter.base_url');

        try {
            $response = Http::withHeaders([
                'Authorization' => "Bearer $apiKey",
                'Content-Type' => 'application/json',
                'HTTP-Referer' => config('app.url'),
                'X-OpenRouter-Title' => 'AssistAI Dashboard',
            ])->post("$baseUrl/chat/completions", [
                'model' => 'google/gemini-2.5-flash',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are an AI script writer. Write a short, engaging script suitable for Text-to-Speech based on the user\'s prompt. Output only the text to be spoken, without any actions or annotations.'
                    ],
                    [
                        'role' => 'user',
                        'content' => $request->prompt
                    ]
                ]
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $text = $data['choices'][0]['message']['content'] ?? '';
                
                return response()->json([
                    'success' => true,
                    'text' => trim($text)
                ]);
            }
            
            $errorMsg = $response->json('error.message') ?? 'Failed to generate script.';
            return response()->json([
                'success' => false,
                'error' => "API Error: $errorMsg"
            ], $response->status());

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Exception occurred: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Wrap raw PCM bytes in a standard WAV header for HTML5 <audio> compatibility
     */
    private function addWavHeader($pcmData, $sampleRate, $numChannels, $bitsPerSample)
    {
        $byteRate = $sampleRate * $numChannels * ($bitsPerSample / 8);
        $blockAlign = $numChannels * ($bitsPerSample / 8);
        $dataSize = strlen($pcmData);
        $chunkSize = 36 + $dataSize;

        $header = pack('a4V', 'RIFF', $chunkSize);
        $header .= pack('a4', 'WAVE');
        $header .= pack('a4VvvVVvv', 'fmt ', 16, 1, $numChannels, $sampleRate, $byteRate, $blockAlign, $bitsPerSample);
        $header .= pack('a4V', 'data', $dataSize);

        return $header . $pcmData;
    }
}
