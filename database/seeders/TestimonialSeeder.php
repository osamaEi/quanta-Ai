<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Testimonial;
use App\Models\User;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get company users to assign testimonials to
        $companyUsers = User::whereHas('roles', function ($query) {
            $query->where('name', 'company');
        })->get();

        if ($companyUsers->isEmpty()) {
            // If no company users exist, create some sample users first
            $this->createSampleCompanyUsers();
            $companyUsers = User::whereHas('roles', function ($query) {
                $query->where('name', 'company');
            })->get();
        }

        $testimonials = [
            [
                'content' => 'QuantaMinds AI has completely transformed our customer service. The WhatsApp integration is seamless, and our response time has improved by 80%. Our customers love the instant, helpful responses they get 24/7. The AI understands our business context perfectly and provides accurate information about our products and services.',
                'rating' => 5,
                'is_published' => true,
            ],
            [
                'content' => 'As a retail business, we were struggling with handling customer inquiries efficiently. Since implementing QuantaMinds AI, we\'ve seen a 150% increase in customer satisfaction scores. The system handles everything from product inquiries to order status updates automatically. It\'s like having a knowledgeable team member available round the clock.',
                'rating' => 5,
                'is_published' => true,
            ],
            [
                'content' => 'The implementation process was incredibly smooth. The team provided excellent support during setup, and the AI was learning our business processes within days. We\'ve reduced our customer service workload by 60% while improving response quality. Highly recommended for any business looking to scale their customer support.',
                'rating' => 5,
                'is_published' => true,
            ],
            [
                'content' => 'We\'re a healthcare provider, and the accuracy of medical information provided by the AI is impressive. It correctly handles appointment scheduling, insurance queries, and general health information while maintaining patient confidentiality. The integration with our existing systems was flawless.',
                'rating' => 4,
                'is_published' => true,
            ],
            [
                'content' => 'Running a restaurant, we needed a solution that could handle menu inquiries, reservations, and delivery orders. QuantaMinds AI does all of this and more. Our customers appreciate the quick responses, and we\'ve seen a 40% increase in online orders since implementation.',
                'rating' => 5,
                'is_published' => true,
            ],
            [
                'content' => 'The AI\'s ability to understand context and provide personalized responses is remarkable. It remembers customer preferences and previous interactions, making each conversation feel personal. Our customer retention rate has improved significantly since we started using this system.',
                'rating' => 5,
                'is_published' => true,
            ],
            [
                'content' => 'As a manufacturing company, we have complex product specifications and technical requirements. The AI handles technical queries with impressive accuracy and can even help with troubleshooting. It\'s become an invaluable tool for our technical support team.',
                'rating' => 4,
                'is_published' => true,
            ],
            [
                'content' => 'The multilingual support is fantastic. We serve customers from different regions, and the AI communicates fluently in multiple languages. This has helped us expand our market reach and serve international customers effectively.',
                'rating' => 5,
                'is_published' => true,
            ],
            [
                'content' => 'We were skeptical about AI customer service at first, but QuantaMinds exceeded our expectations. The system is intelligent, reliable, and constantly learning. Our customer satisfaction scores have never been higher, and our support team can focus on complex cases that require human intervention.',
                'rating' => 5,
                'is_published' => true,
            ],
            [
                'content' => 'The analytics and reporting features provide valuable insights into customer behavior and common queries. This data has helped us improve our products and services. The ROI on this investment was achieved within the first three months.',
                'rating' => 4,
                'is_published' => true,
            ],
            [
                'content' => 'For an educational institution, maintaining consistent communication with students and parents is crucial. QuantaMinds AI handles admissions queries, course information, and general inquiries professionally. It\'s like having a knowledgeable admissions officer available 24/7.',
                'rating' => 5,
                'is_published' => true,
            ],
            [
                'content' => 'The customization options are extensive. We were able to train the AI on our specific business processes and terminology. The system now speaks our language and understands our industry-specific requirements perfectly.',
                'rating' => 5,
                'is_published' => true,
            ],
            [
                'content' => 'We\'ve been using QuantaMinds AI for six months now, and the results are outstanding. Our response time has improved from hours to seconds, and our customers appreciate the immediate assistance. The system has paid for itself many times over.',
                'rating' => 5,
                'is_published' => true,
            ],
            [
                'content' => 'The integration with our existing CRM and e-commerce platforms was straightforward. The AI seamlessly pulls customer data and order information to provide personalized responses. This level of integration has significantly improved our customer experience.',
                'rating' => 4,
                'is_published' => true,
            ],
            [
                'content' => 'As a wholesale business, we deal with large orders and complex pricing structures. The AI handles pricing inquiries, bulk order processing, and delivery scheduling with remarkable accuracy. It\'s become an essential part of our sales process.',
                'rating' => 5,
                'is_published' => true,
            ],
            // Some pending testimonials for admin review
            [
                'content' => 'We recently started using QuantaMinds AI and are still in the evaluation phase. Initial results look promising, especially in handling basic customer inquiries. Looking forward to seeing how it performs as we scale up our operations.',
                'rating' => 4,
                'is_published' => false,
            ],
            [
                'content' => 'The AI system is quite impressive in terms of understanding customer intent. However, we\'re still fine-tuning it for our specific use cases. The support team has been very helpful in this process.',
                'rating' => 4,
                'is_published' => false,
            ],
            [
                'content' => 'We\'re a small business and were concerned about the cost, but the value we\'re getting is incredible. The AI handles customer service tasks that would require multiple staff members. It\'s definitely worth the investment.',
                'rating' => 5,
                'is_published' => false,
            ],
        ];

        foreach ($testimonials as $index => $testimonialData) {
            // Assign testimonials to company users in a round-robin fashion
            $user = $companyUsers[$index % $companyUsers->count()];
            
            Testimonial::create([
                'user_id' => $user->id,
                'content' => $testimonialData['content'],
                'rating' => $testimonialData['rating'],
                'is_published' => $testimonialData['is_published'],
                'created_at' => now()->subDays(rand(1, 90)), // Random dates within last 90 days
                'updated_at' => now()->subDays(rand(1, 90)),
            ]);
        }

        $this->command->info('Testimonials seeded successfully!');
    }

    /**
     * Create sample company users if none exist
     */
    private function createSampleCompanyUsers(): void
    {
        $companies = [
            [
                'name' => 'Tech Solutions Inc.',
                'email' => 'contact@techsolutions.com',
                'company_name' => 'Tech Solutions Inc.',
                'phone_number' => '+1234567890',
                'whatsapp_number' => '+1234567890',
                'ai_settings' => [
                    'business_type' => 'services',
                    'status' => 'approved',
                    'approved_at' => now(),
                ],
            ],
            [
                'name' => 'Green Retail Store',
                'email' => 'info@greenretail.com',
                'company_name' => 'Green Retail Store',
                'phone_number' => '+1234567891',
                'whatsapp_number' => '+1234567891',
                'ai_settings' => [
                    'business_type' => 'retail',
                    'status' => 'approved',
                    'approved_at' => now(),
                ],
            ],
            [
                'name' => 'HealthCare Plus',
                'email' => 'admin@healthcareplus.com',
                'company_name' => 'HealthCare Plus',
                'phone_number' => '+1234567892',
                'whatsapp_number' => '+1234567892',
                'ai_settings' => [
                    'business_type' => 'healthcare',
                    'status' => 'approved',
                    'approved_at' => now(),
                ],
            ],
            [
                'name' => 'Global Manufacturing',
                'email' => 'sales@globalmanufacturing.com',
                'company_name' => 'Global Manufacturing',
                'phone_number' => '+1234567893',
                'whatsapp_number' => '+1234567893',
                'ai_settings' => [
                    'business_type' => 'manufacturing',
                    'status' => 'approved',
                    'approved_at' => now(),
                ],
            ],
            [
                'name' => 'EduTech Academy',
                'email' => 'info@edutechacademy.com',
                'company_name' => 'EduTech Academy',
                'phone_number' => '+1234567894',
                'whatsapp_number' => '+1234567894',
                'ai_settings' => [
                    'business_type' => 'education',
                    'status' => 'approved',
                    'approved_at' => now(),
                ],
            ],
        ];

        foreach ($companies as $companyData) {
            $user = User::create([
                'name' => $companyData['name'],
                'email' => $companyData['email'],
                'password' => bcrypt('password123'),
                'company_name' => $companyData['company_name'],
                'phone_number' => $companyData['phone_number'],
                'whatsapp_number' => $companyData['whatsapp_number'],
                'ai_settings' => $companyData['ai_settings'],
                'email_verified_at' => now(),
            ]);

            // Assign company role
            $companyRole = \App\Models\Role::where('name', 'company')->first();
            if ($companyRole) {
                $user->roles()->attach($companyRole->id);
            }
        }

        $this->command->info('Sample company users created successfully!');
    }
} 