<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Setting;
use App\Models\User;
use App\Models\Customer;
use App\Models\Conversation;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        $company = Auth::user();
        
        $usersCount = User::count();
        $blogsCount = Blog::count();
        $settingsCount = Setting::count();
        
        // Testimonial statistics
        $testimonialsCount = Testimonial::count();
        $publishedTestimonialsCount = Testimonial::where('is_published', true)->count();
        $pendingTestimonialsCount = Testimonial::where('is_published', false)->count();
        
        // Customer statistics
        $customersCount = $company->customers()->count();
        $unreadMessagesCount = $company->conversations()
            ->where('direction', 'incoming')
            ->where('is_read', false)
            ->count();
        $aiResponsesCount = $company->conversations()
            ->where('is_ai_response', true)
            ->whereDate('created_at', today())
            ->count();
        
        // Recent conversations
        $recentConversations = $company->conversations()
            ->with('customer')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Pending service requests
        $pendingServiceRequests = User::whereHas('roles', function ($query) {
            $query->where('name', 'company');
        })
        ->whereJsonContains('ai_settings->status', 'pending')
        ->orderBy('created_at', 'desc')
        ->limit(5)
        ->get();

        return view('admin.dashboard', compact(
            'usersCount', 
            'blogsCount', 
            'settingsCount',
            'testimonialsCount',
            'publishedTestimonialsCount',
            'pendingTestimonialsCount',
            'customersCount',
            'unreadMessagesCount',
            'aiResponsesCount',
            'recentConversations',
            'pendingServiceRequests'
        ));
    }
}
