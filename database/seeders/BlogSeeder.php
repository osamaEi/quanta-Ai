<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Blog;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $blog1 = Blog::create([
            'title' => 'The Future of AI in Business',
            'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
        ]);
        $this->storeImage($blog1, 'https://picsum.photos/800/600');


        $blog2 = Blog::create([
            'title' => 'Top 5 CRM Integration Tips',
            'content' => 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
        ]);
        $this->storeImage($blog2, 'https://picsum.photos/800/601');


        $blog3 = Blog::create([
            'title' => 'Automating Customer Support with Quanta AI',
            'content' => 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.',
        ]);
        $this->storeImage($blog3, 'https://picsum.photos/800/602');
    }

    private function storeImage(Blog $blog, $url)
    {
        $contents = Http::get($url)->body();
        $filename = Str::random(40) . '.jpg';
        $path = 'blogs/' . $filename;
        Storage::disk('public')->put($path, $contents);
        $blog->photos()->create(['path' => $path]);
    }
}
