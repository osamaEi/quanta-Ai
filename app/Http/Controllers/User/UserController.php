<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('user.dashboard');
    }

    public function dashboard()
    {
        return view('company.dashboard');
    }

    public function updateSettings(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'company_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'whatsapp_number' => 'required|string|max:20',
            'business_type' => 'required|string|in:retail,wholesale,services,manufacturing,restaurant,healthcare,education,other',
        ]);
        $user->company_name = $request->company_name;
        $user->phone_number = $request->phone_number;
        $user->whatsapp_number = $request->whatsapp_number;
        $ai_settings = $user->ai_settings ?? [];
        $ai_settings['business_type'] = $request->business_type;
        $user->ai_settings = $ai_settings;
        $user->save();
        return redirect()->route('company.dashboard')->with('success', 'Settings updated successfully.');
    }

    public function showChat()
    {
        return view('company.chat');
    }

    public function sendChat(Request $request)
    {
        $user = auth()->user();
        $message = $request->input('message');
        $allowed = $user->ai_settings['ai_categories'] ?? [];
        $matched = false;
        $fieldKeywords = [
            'orders' => ['order', 'purchase', 'buy', 'track', 'shipping'],
            'support' => ['support', 'help', 'issue', 'problem', 'technical'],
            'pricing' => ['price', 'cost', 'quote', 'how much', 'fee'],
            'general' => ['business', 'company', 'about', 'info', 'information'],
        ];
        foreach ($allowed as $field) {
            foreach ($fieldKeywords[$field] ?? [] as $keyword) {
                if (stripos($message, $keyword) !== false) {
                    $matched = true;
                    break 2;
                }
            }
        }
        if (!$matched) {
            $fields = $allowed ? implode(', ', array_map('ucfirst', $allowed)) : 'no topics';
            return response()->json(['response' => "Sorry, I can only assist with: $fields."]);
        }
        // Here you would call your AI service, for now just echo a fake response
        $aiResponse = "[AI] This is a sample response for your question: '$message'";
        return response()->json(['response' => $aiResponse]);
    }

    public function updateAISettings(Request $request)
    {
        $user = auth()->user();
        $ai_settings = $user->ai_settings ?? [];
        $ai_settings['ai_categories'] = $request->input('ai_categories', []);
        $user->ai_settings = $ai_settings;
        $user->save();
        return response()->json(['success' => true]);
    }
}
