<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::all();
        return view('admin.blogs.index', compact('blogs'));
    }

    public function create()
    {
        return view('admin.blogs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $blog = Blog::create($request->only('title', 'content'));

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('blogs', 'public');
            $blog->photos()->create(['path' => $path]);
        }

        return redirect()->route('admin.blogs.index')->with('success', 'Blog post created successfully.');
    }

    public function show(Blog $blog)
    {
        return view('admin.blogs.show', compact('blog'));
    }
}
