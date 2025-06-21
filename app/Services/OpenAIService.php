<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use OpenAI;
use App\Models\User;
use App\Models\Customer;

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

    /**
     * Generates WhatsApp customer service response with company context
     *
     * @param string $customerMessage
     * @param User $company
     * @param Customer $customer
     * @param array $conversationHistory
     * @return array
     */
    public function generateWhatsAppResponse(
        string $customerMessage, 
        User $company, 
        Customer $customer, 
        array $conversationHistory = []
    ): array {
        try {
            // Build company context
            $companyContext = $this->buildCompanyContext($company);
            $customerContext = $this->buildCustomerContext($customer);
            
            // Build conversation history for context
            $historyMessages = $this->buildHistoryMessages($conversationHistory);
            
            $systemPrompt = $this->buildSystemPrompt($companyContext, $customerContext);
            
            $messages = [
                [
                    'role' => 'system',
                    'content' => $systemPrompt
                ],
                ...$historyMessages,
                [
                    'role' => 'user',
                    'content' => $customerMessage
                ]
            ];

            $response = $this->client->chat()->create([
                'model' => 'gpt-3.5-turbo',
                'messages' => $messages,
                'temperature' => 0.7,
                'max_tokens' => 500,
            ]);

            $aiResponse = $response->choices[0]->message->content ?? '';
            
            // Calculate confidence based on response length and content
            $confidence = $this->calculateConfidence($aiResponse, $customerMessage);

            return [
                'response' => $aiResponse,
                'confidence' => $confidence,
                'is_ai_response' => true,
                'metadata' => [
                    'model_used' => 'gpt-3.5-turbo',
                    'tokens_used' => $response->usage->totalTokens ?? 0,
                    'company_context_used' => true,
                ]
            ];

        } catch (\Exception $e) {
            report($e);
            return [
                'response' => 'عذراً، حدث خطأ في النظام. سيتم التواصل معك قريباً.',
                'confidence' => 0.0,
                'is_ai_response' => false,
                'metadata' => [
                    'error' => $e->getMessage()
                ]
            ];
        }
    }

    /**
     * Build company context for AI
     */
    private function buildCompanyContext(User $company): string
    {
        $context = "أنت مساعد خدمة عملاء للشركة: {$company->company_name}\n";
        
        if ($company->ai_settings) {
            $settings = $company->ai_settings;
            if (isset($settings['tone'])) {
                $context .= "نبرة الرد: {$settings['tone']}\n";
            }
            if (isset($settings['language'])) {
                $context .= "لغة الرد: {$settings['language']}\n";
            }
            if (isset($settings['special_instructions'])) {
                $context .= "تعليمات خاصة: {$settings['special_instructions']}\n";
            }
        }
        
        return $context;
    }

    /**
     * Build customer context for AI
     */
    private function buildCustomerContext(Customer $customer): string
    {
        $context = "معلومات العميل:\n";
        $context .= "- الاسم: {$customer->name}\n";
        $context .= "- رقم الواتساب: {$customer->whatsapp_number}\n";
        $context .= "- الحالة: {$customer->status}\n";
        
        if ($customer->preferences) {
            $context .= "- التفضيلات: " . json_encode($customer->preferences, JSON_UNESCAPED_UNICODE) . "\n";
        }
        
        return $context;
    }

    /**
     * Build conversation history messages
     */
    private function buildHistoryMessages(array $conversationHistory): array
    {
        $messages = [];
        
        foreach ($conversationHistory as $conversation) {
            if ($conversation['direction'] === 'incoming') {
                $messages[] = [
                    'role' => 'user',
                    'content' => $conversation['message']
                ];
            } else {
                $messages[] = [
                    'role' => 'assistant',
                    'content' => $conversation['response']
                ];
            }
        }
        
        return $messages;
    }

    /**
     * Build system prompt for WhatsApp customer service
     */
    private function buildSystemPrompt(string $companyContext, string $customerContext): string
    {
        return "أنت مساعد ذكي لخدمة عملاء الشركة عبر الواتساب. 

{$companyContext}

{$customerContext}

تعليمات مهمة:
1. رد باللغة العربية دائماً
2. كن مهذباً ومهنياً
3. اطرح أسئلة توضيحية إذا لزم الأمر
4. إذا لم تستطع الإجابة، اطلب من العميل الانتظار وسيتم التواصل معه من قبل فريق العمل
5. لا تعطِ معلومات شخصية أو سرية
6. حافظ على نبرة ودية ومفيدة

الرد يجب أن يكون مختصراً ومفيداً ومناسباً للواتساب.";
    }

    /**
     * Calculate AI response confidence
     */
    private function calculateConfidence(string $response, string $customerMessage): float
    {
        // Simple confidence calculation based on response quality
        $confidence = 0.8; // Base confidence
        
        // Reduce confidence for very short responses
        if (strlen($response) < 20) {
            $confidence -= 0.2;
        }
        
        // Reduce confidence for responses that seem uncertain
        $uncertainWords = ['ربما', 'قد', 'أعتقد', 'لا أعرف', 'غير متأكد'];
        foreach ($uncertainWords as $word) {
            if (strpos($response, $word) !== false) {
                $confidence -= 0.1;
            }
        }
        
        return max(0.0, min(1.0, $confidence));
    }
} 