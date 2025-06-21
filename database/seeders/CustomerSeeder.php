<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\User;
use App\Models\Conversation;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the first user (company)
        $company = User::first();
        
        if (!$company) {
            $this->command->error('No users found. Please run UserSeeder first.');
            return;
        }

        $customers = [
            [
                'name' => 'أحمد محمد',
                'whatsapp_number' => '0123456789',
                'email' => 'ahmed@example.com',
                'company_name' => 'شركة أحمد للتجارة',
                'status' => 'active',
                'notes' => 'عميل نشط، يهتم بالمنتجات الجديدة',
                'preferences' => ['language' => 'ar', 'contact_time' => 'morning'],
            ],
            [
                'name' => 'فاطمة علي',
                'whatsapp_number' => '0987654321',
                'email' => 'fatima@example.com',
                'company_name' => 'مؤسسة فاطمة',
                'status' => 'active',
                'notes' => 'عميلة محترمة، تفضل التواصل عبر الواتساب',
                'preferences' => ['language' => 'ar', 'contact_time' => 'evening'],
            ],
            [
                'name' => 'محمد حسن',
                'whatsapp_number' => '0555666777',
                'email' => 'mohamed@example.com',
                'company_name' => 'شركة محمد للخدمات',
                'status' => 'inactive',
                'notes' => 'لم يتواصل منذ شهر',
                'preferences' => ['language' => 'ar', 'contact_time' => 'afternoon'],
            ],
            [
                'name' => 'سارة أحمد',
                'whatsapp_number' => '0111222333',
                'email' => 'sara@example.com',
                'company_name' => 'مؤسسة سارة',
                'status' => 'active',
                'notes' => 'عميلة جديدة، تحتاج متابعة',
                'preferences' => ['language' => 'ar', 'contact_time' => 'morning'],
            ],
            [
                'name' => 'علي محمود',
                'whatsapp_number' => '0444555666',
                'email' => 'ali@example.com',
                'company_name' => 'شركة علي للمقاولات',
                'status' => 'active',
                'notes' => 'عميل مهم، يطلب عروض خاصة',
                'preferences' => ['language' => 'ar', 'contact_time' => 'anytime'],
            ],
        ];

        foreach ($customers as $customerData) {
            $customer = Customer::create([
                'user_id' => $company->id,
                'name' => $customerData['name'],
                'whatsapp_number' => $customerData['whatsapp_number'],
                'email' => $customerData['email'],
                'company_name' => $customerData['company_name'],
                'status' => $customerData['status'],
                'notes' => $customerData['notes'],
                'preferences' => $customerData['preferences'],
                'last_contact_at' => now()->subDays(rand(1, 30)),
            ]);

            // Create sample conversations for each customer
            $this->createSampleConversations($customer, $company);
        }

        $this->command->info('Customers seeded successfully!');
    }

    private function createSampleConversations(Customer $customer, User $company): void
    {
        $sampleMessages = [
            [
                'incoming' => 'السلام عليكم، أريد معلومات عن منتجاتكم',
                'outgoing' => 'وعليكم السلام ورحمة الله وبركاته! أهلاً وسهلاً بك. نحن نقدم مجموعة متنوعة من المنتجات عالية الجودة. هل يمكنك إخباري ما نوع المنتجات التي تبحث عنها؟',
                'is_ai' => true,
            ],
            [
                'incoming' => 'أريد معرفة الأسعار',
                'outgoing' => 'بالطبع! أسعارنا تنافسية جداً. يمكنني إرسال كتالوج الأسعار لك عبر الواتساب. هل تريد أن أرسله لك الآن؟',
                'is_ai' => true,
            ],
            [
                'incoming' => 'نعم من فضلك',
                'outgoing' => 'ممتاز! سأرسل لك الكتالوج الآن. هل لديك أي استفسارات أخرى؟',
                'is_ai' => true,
            ],
            [
                'incoming' => 'شكراً لك',
                'outgoing' => 'العفو! نحن هنا لمساعدتك دائماً. إذا احتجت أي شيء آخر، لا تتردد في التواصل معنا. تحياتي!',
                'is_ai' => true,
            ],
        ];

        foreach ($sampleMessages as $index => $message) {
            // Incoming message
            Conversation::create([
                'customer_id' => $customer->id,
                'user_id' => $company->id,
                'message' => $message['incoming'],
                'direction' => 'incoming',
                'message_type' => 'text',
                'is_read' => true,
                'is_ai_response' => false,
                'created_at' => now()->subDays(rand(1, 7))->subHours(rand(1, 24)),
            ]);

            // Outgoing response
            Conversation::create([
                'customer_id' => $customer->id,
                'user_id' => $company->id,
                'message' => '',
                'response' => $message['outgoing'],
                'direction' => 'outgoing',
                'message_type' => 'text',
                'is_read' => true,
                'is_ai_response' => $message['is_ai'],
                'ai_confidence' => $message['is_ai'] ? rand(70, 95) / 100 : null,
                'created_at' => now()->subDays(rand(1, 7))->subHours(rand(1, 24)),
            ]);
        }
    }
}
