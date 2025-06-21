<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index()
    {
        $blogs = Blog::latest()->take(3)->get();
        $testimonials = Testimonial::where('is_published', true)->latest()->get();
        return view('quanta-frontend', compact('blogs', 'testimonials'));
    }
} 