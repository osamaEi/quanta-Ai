<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\OpenAIService;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        return view('admin.chat.index');
    }

    public function sendMessage(Request $request, OpenAIService $openAIService)
    {
        $request->validate([
            'message' => 'required|string|max:4000',
            'history' => 'nullable|array'
        ]);

        $response = $openAIService->getChatResponse(
            $request->message,
            $request->history ?? []
        );

        return response()->json(['reply' => $response]);
    }
}
