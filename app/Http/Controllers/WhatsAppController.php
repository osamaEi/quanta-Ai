<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Conversation;
use App\Models\User;
use App\Services\OpenAIService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class WhatsAppController extends Controller
{
    protected $openAIService;

    public function __construct(OpenAIService $openAIService)
    {
        $this->openAIService = $openAIService;
    }

    /**
     * Handle incoming WhatsApp webhook
     */
    public function webhook(Request $request)
    {
        try {
            Log::info('WhatsApp webhook received', $request->all());

            // Validate webhook data
            $validator = Validator::make($request->all(), [
                'entry.0.changes.0.value.messages.0.from' => 'required|string',
                'entry.0.changes.0.value.messages.0.text.body' => 'required|string',
                'entry.0.changes.0.value.messages.0.timestamp' => 'required|integer',
            ]);

            if ($validator->fails()) {
                Log::error('Invalid webhook data', $validator->errors()->toArray());
                return response()->json(['status' => 'error', 'message' => 'Invalid data'], 400);
            }

            $from = $request->input('entry.0.changes.0.value.messages.0.from');
            $message = $request->input('entry.0.changes.0.value.messages.0.text.body');
            $timestamp = $request->input('entry.0.changes.0.value.messages.0.timestamp');

            // Find or create customer
            $customer = $this->findOrCreateCustomer($from);

            // Find the company (user) this customer belongs to
            $company = $this->findCompanyForCustomer($customer);

            if (!$company) {
                Log::error('No company found for customer', ['customer_id' => $customer->id]);
                return response()->json(['status' => 'error', 'message' => 'Company not found'], 404);
            }

            // Save incoming message
            $conversation = Conversation::create([
                'customer_id' => $customer->id,
                'user_id' => $company->id,
                'message' => $message,
                'direction' => 'incoming',
                'message_type' => 'text',
                'is_read' => false,
                'is_ai_response' => false,
            ]);

            // Get conversation history for context
            $history = $this->getConversationHistory($customer->id, $company->id);

            // Generate AI response
            $aiResponse = $this->openAIService->generateWhatsAppResponse(
                $message,
                $company,
                $customer,
                $history
            );

            // Save AI response
            $aiConversation = Conversation::create([
                'customer_id' => $customer->id,
                'user_id' => $company->id,
                'message' => '', // Empty for outgoing messages
                'response' => $aiResponse['response'],
                'direction' => 'outgoing',
                'message_type' => 'text',
                'is_read' => true,
                'is_ai_response' => $aiResponse['is_ai_response'],
                'ai_confidence' => $aiResponse['confidence'],
                'metadata' => $aiResponse['metadata'],
            ]);

            // Update customer last contact
            $customer->update([
                'last_contact_at' => now(),
            ]);

            // Send response back to WhatsApp (you'll need to implement this)
            $this->sendWhatsAppResponse($from, $aiResponse['response']);

            Log::info('WhatsApp message processed successfully', [
                'customer_id' => $customer->id,
                'company_id' => $company->id,
                'ai_confidence' => $aiResponse['confidence']
            ]);

            return response()->json(['status' => 'success']);

        } catch (\Exception $e) {
            Log::error('Error processing WhatsApp webhook', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json(['status' => 'error', 'message' => 'Internal server error'], 500);
        }
    }

    /**
     * Find or create customer based on WhatsApp number
     */
    private function findOrCreateCustomer(string $whatsappNumber): Customer
    {
        // Remove country code if present (you might need to adjust this logic)
        $cleanNumber = $this->cleanPhoneNumber($whatsappNumber);

        $customer = Customer::where('whatsapp_number', $cleanNumber)->first();

        if (!$customer) {
            // Create new customer
            $customer = Customer::create([
                'whatsapp_number' => $cleanNumber,
                'name' => 'عميل جديد', // Default name
                'status' => 'active',
                'user_id' => 1, // Default company - you might want to change this logic
            ]);

            Log::info('New customer created', ['customer_id' => $customer->id, 'whatsapp_number' => $cleanNumber]);
        }

        return $customer;
    }

    /**
     * Find company for customer
     */
    private function findCompanyForCustomer(Customer $customer): ?User
    {
        // For now, return the first company
        // You might want to implement more sophisticated logic
        // like routing based on customer preferences or company capacity
        return User::whereHas('roles', function ($query) {
            $query->where('name', 'company');
        })->first();
    }

    /**
     * Get conversation history for context
     */
    private function getConversationHistory(int $customerId, int $companyId): array
    {
        return Conversation::where('customer_id', $customerId)
            ->where('user_id', $companyId)
            ->orderBy('created_at', 'desc')
            ->limit(10) // Last 10 messages for context
            ->get()
            ->map(function ($conversation) {
                return [
                    'direction' => $conversation->direction,
                    'message' => $conversation->message,
                    'response' => $conversation->response,
                ];
            })
            ->toArray();
    }

    /**
     * Clean phone number
     */
    private function cleanPhoneNumber(string $number): string
    {
        // Remove common prefixes and clean the number
        $number = preg_replace('/[^0-9]/', '', $number);
        
        // Remove country code if it starts with specific patterns
        if (strlen($number) > 10) {
            // You might need to adjust this based on your country's phone number format
            $number = substr($number, -10);
        }
        
        return $number;
    }

    /**
     * Send WhatsApp response (placeholder - you'll need to implement this)
     */
    private function sendWhatsAppResponse(string $to, string $message): void
    {
        // This is a placeholder. You'll need to implement the actual WhatsApp API call
        // using services like Twilio, MessageBird, or WhatsApp Business API
        
        Log::info('WhatsApp response would be sent', [
            'to' => $to,
            'message' => $message
        ]);

        // Example implementation with Twilio (you'll need to install and configure it):
        /*
        $twilio = new Client(config('services.twilio.sid'), config('services.twilio.token'));
        
        $twilio->messages->create(
            "whatsapp:{$to}",
            [
                'from' => 'whatsapp:' . config('services.twilio.whatsapp_number'),
                'body' => $message
            ]
        );
        */
    }

    /**
     * Get conversations for a company
     */
    public function getConversations(Request $request)
    {
        $company = auth()->user();
        
        $conversations = Conversation::where('user_id', $company->id)
            ->with(['customer'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return response()->json($conversations);
    }

    /**
     * Get conversation history for a specific customer
     */
    public function getCustomerConversations(Request $request, $customerId)
    {
        $company = auth()->user();
        
        $conversations = Conversation::where('user_id', $company->id)
            ->where('customer_id', $customerId)
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($conversations);
    }

    /**
     * Send manual response to customer
     */
    public function sendManualResponse(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'message' => 'required|string|max:1000',
        ]);

        $company = auth()->user();
        $customer = Customer::findOrFail($request->customer_id);

        // Save manual response
        $conversation = Conversation::create([
            'customer_id' => $customer->id,
            'user_id' => $company->id,
            'message' => '',
            'response' => $request->message,
            'direction' => 'outgoing',
            'message_type' => 'text',
            'is_read' => true,
            'is_ai_response' => false,
        ]);

        // Send via WhatsApp
        $this->sendWhatsAppResponse($customer->whatsapp_number, $request->message);

        return response()->json(['status' => 'success', 'conversation' => $conversation]);
    }

    /**
     * Mark conversation as read
     */
    public function markAsRead(Request $request, $conversationId)
    {
        $company = auth()->user();
        
        $conversation = Conversation::where('user_id', $company->id)
            ->where('id', $conversationId)
            ->firstOrFail();

        $conversation->update(['is_read' => true]);

        return response()->json(['status' => 'success']);
    }
}
