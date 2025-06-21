<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $testimonials = Auth::user()->testimonials()->latest()->paginate(10);
        return view('company.testimonials.index', compact('testimonials'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('company.testimonials.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|min:50|max:1000',
            'rating' => 'required|integer|min:1|max:5',
        ], [
            'content.required' => 'Please provide your review.',
            'content.min' => 'Your review must be at least 50 characters long.',
            'content.max' => 'Your review cannot exceed 1000 characters.',
            'rating.required' => 'Please provide a rating.',
            'rating.integer' => 'Rating must be a whole number.',
            'rating.min' => 'Rating must be at least 1 star.',
            'rating.max' => 'Rating cannot exceed 5 stars.',
        ]);

        Auth::user()->testimonials()->create([
            'content' => $request->input('content'),
            'rating' => $request->input('rating'),
            'is_published' => false, // Default to unpublished for admin review
        ]);

        return redirect()->route('company.testimonials.index')->with('success', 'Thank you for your review! It has been submitted and will be reviewed by our team.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Testimonial $testimonial)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Testimonial $testimonial)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Testimonial $testimonial)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Testimonial $testimonial)
    {
        //
    }
}
