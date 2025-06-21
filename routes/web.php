<?php
 
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Admin\ServiceRequestController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\ContactFormController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\WhatsAppController;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [FrontendController::class, 'index'])->name('home');

Route::get('/contact', [ContactFormController::class, 'create'])->name('contact.create');
Route::post('/contact', [ContactFormController::class, 'store'])->name('contact.store');

// WhatsApp Webhook (public route)
Route::post('/whatsapp/webhook', [WhatsAppController::class, 'webhook'])->name('whatsapp.webhook');

Route::middleware(['auth'])->group(function () {
    // User routes
    Route::get('/dashboard', [UserController::class, 'index'])->name('user.dashboard');

    // Company dashboard and settings
    Route::get('/company/dashboard', [UserController::class, 'dashboard'])->name('company.dashboard');
    Route::put('/company/settings', [UserController::class, 'updateSettings'])->name('company.settings.update');
    Route::get('/company/chat', [UserController::class, 'showChat'])->name('company.chat');
    Route::post('/company/chat/send', [UserController::class, 'sendChat'])->name('company.chat.send');
    Route::put('/company/ai-settings', [UserController::class, 'updateAISettings'])->name('company.ai-settings.update');

    // Company testimonial routes
    Route::get('/company/testimonials', [\App\Http\Controllers\TestimonialController::class, 'index'])->name('company.testimonials.index');
    Route::get('/company/testimonials/create', [\App\Http\Controllers\TestimonialController::class, 'create'])->name('company.testimonials.create');
    Route::post('/company/testimonials', [\App\Http\Controllers\TestimonialController::class, 'store'])->name('company.testimonials.store');

    // Admin routes
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        Route::resource('users', AdminUserController::class);
        Route::resource('settings', AdminSettingController::class);
        Route::post('blogs/generate-content', [AdminBlogController::class, 'generateContent'])->name('blogs.generateContent');
        Route::resource('blogs', AdminBlogController::class);
        Route::resource('contacts', AdminContactController::class)->only(['index', 'destroy']);
        
        // Testimonial Management Routes
        Route::resource('testimonials', \App\Http\Controllers\Admin\TestimonialController::class);
        
        // AI Chat Routes
        Route::get('/chat', [\App\Http\Controllers\Admin\ChatController::class, 'index'])->name('chat.index');
        Route::post('/chat', [\App\Http\Controllers\Admin\ChatController::class, 'sendMessage'])->name('chat.sendMessage');
        
        // Customer Management Routes
        Route::resource('customers', CustomerController::class);
        Route::get('/customers/{customer}/conversations', [CustomerController::class, 'show'])->name('admin.customers.conversations');
        Route::get('/customers-statistics', [CustomerController::class, 'statistics'])->name('customers.statistics');
        Route::get('/customers-search', [CustomerController::class, 'search'])->name('customers.search');
        Route::post('/customers-export', [CustomerController::class, 'export'])->name('customers.export');
        Route::post('/customers-bulk-update', [CustomerController::class, 'bulkUpdate'])->name('customers.bulkUpdate');
        
        // WhatsApp Management Routes
        Route::get('/whatsapp/conversations', [WhatsAppController::class, 'getConversations'])->name('whatsapp.conversations');
        Route::get('/whatsapp/customers/{customer}/conversations', [WhatsAppController::class, 'getCustomerConversations'])->name('whatsapp.customerConversations');
        Route::post('/whatsapp/send-response', [WhatsAppController::class, 'sendManualResponse'])->name('whatsapp.sendResponse');
        Route::post('/whatsapp/mark-read/{conversation}', [WhatsAppController::class, 'markAsRead'])->name('whatsapp.markRead');
        
        // Service Requests Management Routes
        Route::get('/service-requests', [ServiceRequestController::class, 'index'])->name('service-requests.index');
        Route::get('/service-requests/{user}', [ServiceRequestController::class, 'show'])->name('service-requests.show');
        Route::post('/service-requests/{user}/approve', [ServiceRequestController::class, 'approve'])->name('service-requests.approve');
        Route::post('/service-requests/{user}/reject', [ServiceRequestController::class, 'reject'])->name('service-requests.reject');
        Route::get('/service-requests-statistics', [ServiceRequestController::class, 'statistics'])->name('service-requests.statistics');
    });

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Change Password routes
    Route::get('/change-password', [ChangePasswordController::class, 'edit'])->name('password.edit');
    Route::post('/change-password', [ChangePasswordController::class, 'update'])->name('password.change');
});

require __DIR__.'/auth.php';
