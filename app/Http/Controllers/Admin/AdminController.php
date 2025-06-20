<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $usersCount = User::count();
        $blogsCount = Blog::count();
        $settingsCount = Setting::count();

        return view('admin.dashboard', compact('usersCount', 'blogsCount', 'settingsCount'));
    }
}
