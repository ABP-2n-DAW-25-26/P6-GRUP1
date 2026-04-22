<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Inertia\Inertia;

class PostController extends Controller
{
    public function index()
    {
    }

    public function create()
    {
        $post = Post::all();

        return Inertia::render('teacher/CreatePost', ["post" => $post]);
    }

    public function store(Request $request)
    {
        $post = new Post();

        $post->title = $request->title;
        $post->description = $request->description;
        $post->start_date = $request->start_date;
        $post->end_date = $request->end_date;
        $post->type = 'post';
        $post->exchange_id = $request->exchange_id;

        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('public/files');
            $post->file = basename($filePath);
        }

        $post->save();

        Inertia::flash(['message' => 'Post creat correctament']);
        return to_route('exchange.show', ['exchange' => $request->exchange_id]);
    }

        public function show(Post $post)
        {
            return Inertia::render('teacher/ShowPost', ["post" => $post]);
        }
}
