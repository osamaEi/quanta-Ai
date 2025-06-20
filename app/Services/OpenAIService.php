<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use OpenAI;

class OpenAIService
{
    protected $client;

    public function __construct()
    {
        // Ensure the API key is set in the config
        if (!config('services.openai.api_key')) {
            throw new \Exception('OpenAI API key is not set.');
        }

        $this->client = OpenAI::client(config('services.openai.api_key'));
    }

    /**
     * Generates blog content based on a given title.
     *
     * @param string $title
     * @return string
     */
    public function generateBlogContent(string $title): string
    {
        try {
            $response = $this->client->chat()->create([
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    [
                        'role' => 'system', 
                        'content' => 'You are a professional blog writer. Your task is to write a comprehensive, engaging, and well-structured blog post based on the title provided. The output should be in HTML format, using headings, paragraphs, and lists where appropriate.'
                    ],
                    [
                        'role' => 'user', 
                        'content' => "Generate a blog post titled: \"{$title}\""
                    ],
                ],
                'temperature' => 0.7,
                'max_tokens' => 1500,
            ]);

            return $response->choices[0]->message->content ?? '';

        } catch (\Exception $e) {
            // You can log the error or handle it as needed
            report($e);
            return '<p>Error: Could not generate content at this time. Please try again later.</p>';
        }
    }

    /**
     * Generates a conversational response.
     *
     * @param string $message
     * @param array $history
     * @return string
     */
    public function getChatResponse(string $message, array $history = []): string
    {
        try {
            $messages = [
                [
                    'role' => 'system',
                    'content' => 'You are a helpful assistant integrated into a Laravel admin panel. Be concise and helpful.'
                ],
                // Add previous conversation history
                ...$history,
                // Add the new user message
                [
                    'role' => 'user',
                    'content' => $message
                ]
            ];

            $response = $this->client->chat()->create([
                'model' => 'gpt-3.5-turbo',
                'messages' => $messages,
                'temperature' => 0.6,
                'max_tokens' => 1000,
            ]);

            return $response->choices[0]->message->content ?? '';

        } catch (\Exception $e) {
            report($e);
            return 'Sorry, I encountered an error. Please try again.';
        }
    }
} 