<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class AdminAiModelController extends Controller
{
    /**
     * Display the AI model settings page.
     */
    public function index()
    {
        // Text Generation Settings
        $allowedTextModels = json_decode(Setting::get('allowed_text_models', '["openai/gpt-3.5-turbo"]'), true) ?: ['openai/gpt-3.5-turbo'];
        $defaultTextModel = Setting::get('default_text_model', 'openai/gpt-3.5-turbo');

        // Image Generation Settings
        $allowedImageModels = json_decode(Setting::get('allowed_image_models', '["google/gemini-3.1-flash-image-preview"]'), true) ?: ['google/gemini-3.1-flash-image-preview'];
        $defaultImageModel = Setting::get('default_image_model', 'google/gemini-3.1-flash-image-preview');

        // Video Generation Settings
        $allowedVideoModels = json_decode(Setting::get('allowed_video_models', '[]'), true) ?: [];
        $defaultVideoModel = Setting::get('default_video_model', '');

        // All Available Models by Category
        $availableModels = [
            'text' => [
                'openai/gpt-4o-mini' => 'GPT-4o Mini',
                'openai/gpt-5' => 'GPT-5 (Future)',
                'openai/gpt-5-mini' => 'GPT-5 Mini',
                'openai/gpt-5.1' => 'GPT-5.1',
                'google/gemini-2.5-flash' => 'Gemini 2.5 Flash',
                'google/gemini-2.5-flash-lite' => 'Gemini 2.5 Flash Lite',
            ],
            'image' => [
                'google/gemini-3.1-flash-image-preview' => 'Gemini 3.1 Flash Image',
                'google/gemini-3-pro-image-preview' => 'Gemini 3 Pro Image',
                'openai/dall-e-3' => 'DALL-E 3',
                'openai/dall-e-2' => 'DALL-E 2',
                'stabilityai/stable-diffusion-xl' => 'Stable Diffusion XL',
                'midjourney/midjourney' => 'Midjourney v6',
            ],
            'video' => [
                'openai/sora' => 'Sora (Waitlist)',
                'runway/gen-2' => 'Runway Gen-2',
                'pika/pika-1' => 'Pika 1.0',
            ]
        ];

        return view('admin.models', compact(
            'allowedTextModels',
            'defaultTextModel',
            'allowedImageModels',
            'defaultImageModel',
            'allowedVideoModels',
            'defaultVideoModel',
            'availableModels'
        ));
    }

    /**
     * Update the AI model settings.
     */
    public function update(Request $request)
    {
        $request->validate([
            'allowed_text_models' => 'required|array|min:1',
            'default_text_model' => 'required|string',
            'allowed_image_models' => 'nullable|array',
            'default_image_model' => 'nullable|string',
            'allowed_video_models' => 'nullable|array',
            'default_video_model' => 'nullable|string',
        ]);

        // Save Text Models
        Setting::set('allowed_text_models', json_encode($request->allowed_text_models), 'ai_models');
        Setting::set('default_text_model', $request->default_text_model, 'ai_models');

        // Save Image Models
        $allowedImages = $request->allowed_image_models ?? [];
        Setting::set('allowed_image_models', json_encode($allowedImages), 'ai_models');
        Setting::set('default_image_model', $request->default_image_model ?? '', 'ai_models');

        // Save Video Models
        $allowedVideos = $request->allowed_video_models ?? [];
        Setting::set('allowed_video_models', json_encode($allowedVideos), 'ai_models');
        Setting::set('default_video_model', $request->default_video_model ?? '', 'ai_models');

        return redirect()->back()->with('success', 'AI Model categories updated successfully!');
    }
}
