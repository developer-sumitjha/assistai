<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\ConversationMessage;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatController extends Controller
{
    /**
     * Display the chat history list.
     */
    public function history()
    {
        $conversations = auth()->user()->conversations()->withCount('messages')->latest()->get();
        return view('pwa.chat_history', compact('conversations'));
    }

    /**
     * Start a new conversation and redirect.
     */
    public function startNew()
    {
        $defaultModel = Setting::get('default_text_model', 'openai/gpt-3.5-turbo');

        $conversation = auth()->user()->conversations()->create([
            'title' => 'New Chat',
            'model' => $defaultModel,
        ]);

        return redirect()->route('user.chat.show', $conversation);
    }

    /**
     * Display a specific chat interface.
     */
    public function show(Conversation $conversation)
    {
        if ($conversation->user_id !== auth()->id()) {
            abort(403);
        }

        // Get allowed models to show in selector
        $allowedModelsRaw = Setting::get('allowed_text_models', '["openai/gpt-3.5-turbo"]');
        $allowedModels = json_decode($allowedModelsRaw, true) ?: ['openai/gpt-3.5-turbo'];
        
        // Human readable names for the selector
        $modelNames = [
            'openai/gpt-4o-mini' => 'GPT-4o Mini',
            'openai/gpt-5' => 'GPT-5 (Future)',
            'openai/gpt-5-mini' => 'GPT-5 Mini',
            'openai/gpt-5.1' => 'GPT-5.1',
            'google/gemini-2.5-flash' => 'Gemini 2.5 Flash',
            'google/gemini-2.5-flash-lite' => 'Gemini 2.5 Flash Lite',
        ];

        $messages = $conversation->messages()->orderBy('created_at')->get();
        return view('pwa.chat', compact('conversation', 'messages', 'allowedModels', 'modelNames'));
    }

    /**
     * Update the model for a specific conversation.
     */
    public function updateModel(Request $request, Conversation $conversation)
    {
        if ($conversation->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate(['model' => 'required|string']);

        // Check if model is allowed
        $allowedModelsRaw = Setting::get('allowed_text_models', '["openai/gpt-3.5-turbo"]');
        $allowedModels = json_decode($allowedModelsRaw, true) ?: ['openai/gpt-3.5-turbo'];

        if (!in_array($request->model, $allowedModels)) {
            return response()->json(['success' => false, 'error' => 'Model not allowed'], 403);
        }

        $conversation->update(['model' => $request->model]);

        return response()->json(['success' => true]);
    }

    /**
     * Send a message to OpenRouter and get a response.
     */
    public function sendMessage(Request $request, Conversation $conversation)
    {
        if ($conversation->user_id !== auth()->id()) {
            abort(403);
        }

        $user = auth()->user();
        if ($user->credits <= 0) {
            return response()->json([
                'success' => false,
                'error' => 'Insufficient credits. Please recharge to continue chatting.',
            ], 403);
        }

        $request->validate([
            'message' => 'required|string|max:2000',
        ]);

        $userMessage = $request->input('message');

        // Save User Message
        $conversation->messages()->create([
            'role' => 'user',
            'content' => $userMessage,
        ]);

        // Update conversation title if it's the first actual message
        if ($conversation->messages()->count() === 1) {
            $title = strlen($userMessage) > 30 ? substr($userMessage, 0, 30) . '...' : $userMessage;
            $conversation->update(['title' => $title]);
        }

        // Prepare context for API
        $history = [
            ['role' => 'system', 'content' => 'You are a helpful AI assistant.']
        ];

        foreach ($conversation->messages()->orderBy('created_at')->get() as $msg) {
            $history[] = ['role' => $msg->role, 'content' => $msg->content];
        }

        $apiKey = config('services.openrouter.key');
        $baseUrl = config('services.openrouter.base_url');

        // Use the model stored in the conversation, fallback to system default
        $model = $conversation->model ?: Setting::get('default_text_model', 'openai/gpt-3.5-turbo');

        try {
            $response = Http::withHeaders([
                'Authorization' => "Bearer $apiKey",
                'Content-Type' => 'application/json',
                'HTTP-Referer' => config('app.url'),
                'X-OpenRouter-Title' => 'AssistAI Dashboard',
            ])->timeout(45)->post("$baseUrl/chat/completions", [
                        'model' => $model,
                        'messages' => $history,
                    ]);

            if ($response->successful()) {
                $data = $response->json();
                $botMessage = $data['choices'][0]['message'];
                $usage = $data['usage'] ?? [];
                $cost = ($usage['total_tokens'] ?? 0) / 1000; // Mock cost per 1k tokens

                // Save AI Response
                $conversation->messages()->create([
                    'role' => 'assistant',
                    'content' => $botMessage['content'],
                ]);

                // Deduct credits if cost > 0
                if ($cost > 0) {
                    $user->decrement('credits', $cost);

                    $user->creditTransactions()->create([
                        'amount' => $cost,
                        'type' => 'subtract',
                        'description' => "AI Chat Spend ($model)",
                    ]);
                }

                return response()->json([
                    'success' => true,
                    'response' => $botMessage['content'],
                    'cost' => $cost,
                    'model' => $model
                ]);
            }

            $error = $response->json('error.message') ?? 'Unknown API error occurred.';
            return response()->json([
                'success' => false,
                'error' => $error,
            ], $response->status());

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Connection to AI service failed: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete the conversation.
     */
    public function clearChat(Conversation $conversation)
    {
        if ($conversation->user_id !== auth()->id()) {
            abort(403);
        }

        $conversation->delete();
        return response()->json(['success' => true]);
    }
}
