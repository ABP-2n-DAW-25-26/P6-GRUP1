<?php

namespace App\Http\Controllers;

use App\Models\ActivityImage;
use App\Models\Exchange;
use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PostController extends Controller
{
    public function index() {}

    public function create(Exchange $exchange)
    {
        $post = Post::all();

        return Inertia::render('teacher/CreatePost', [
            'post' => $post,
            'exchangeId' => $exchange->id,
        ]);
    }

    public function store(Request $request, Exchange $exchange)
    {
        $validated = $request->validate([
            // ''
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'files' => ['nullable', 'array'],
            'files.*' => ['image', 'max:5120'],
        ]);

        $post = new Post;
        $post->title = $validated['title'];
        $post->description = $validated['description'] ?? null;
        $post->start_date = $validated['start_date'];
        $post->end_date = $validated['end_date'] ?? null;
        $post->type = 'post';
        $post->exchange_id = $exchange->id;
        $post->save();

        if ($request->hasFile('files')) {
            $savedImages = [];

            foreach ($request->file('files') as $file) {
                $filePath = $file->store('files', 'public');

                ActivityImage::create([
                    'activity_id' => $post->id,
                    'image_path' => $filePath,
                ]);

                $savedImages[] = $filePath;
            }

            $post->file = $savedImages[0] ?? null;
            $post->save();
        }

        Inertia::flash(['message' => 'Post creat correctament']);

        return to_route('exchange.show', ['exchange' => $exchange->id]);
    }

    public function edit(Exchange $exchange, Post $post)
    {
        dd('edit post TODO');
    }

    public function show(Exchange $exchange, Post $post)
    {
        if ((int) $post->exchange_id !== (int) $exchange->id) {
            abort(404);
        }

        return Inertia::render('Activities/PostView', [
            'post' => $post->load('images'),
        ]);
    }

    public function destroy(Exchange $exchange, Post $post)
    {
        $deleted = $post->delete();
        if ($deleted) {
            Inertia::flash(['message' => 'Post eliminat correctament']);
        }

        return to_route('exchange.show', ['exchange' => $post->exchange_id]);
    }
}
