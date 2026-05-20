<?php

namespace App\Http\Controllers;

use App\Models\Activity;
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

    public function edit(Exchange $exchange, string $id)
    {
        $activity = Activity::findOrFail($id);

        return Inertia::render('Activities/EditPost', [
            'post' => $activity->load('images'),
            'exchange' => $exchange,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Exchange $exchange, string $id)
    {
        $activity = Activity::findOrFail($id);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'existing_images' => ['nullable', 'array'],
            'files' => ['nullable', 'array'],
            'files.*' => ['image', 'max:5120'],
        ]);

        $activity->update($data);

        // Handle existing images - delete those not in the list
        $existingImages = $data['existing_images'] ?? [];
        $imagesToDelete = $activity->images()
            ->whereNotIn('image_path', $existingImages)
            ->get();

        foreach ($imagesToDelete as $image) {
            if (file_exists(storage_path("app/public/{$image->image_path}"))) {
                unlink(storage_path("app/public/{$image->image_path}"));
            }
            $image->delete();
        }

        // Handle new files
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $filePath = $file->store('files', 'public');

                ActivityImage::create([
                    'activity_id' => $activity->id,
                    'image_path' => $filePath,
                ]);
            }
        }

        // Update the main file (first image)
        $firstImage = $activity->images()->first();
        $activity->file = $firstImage?->image_path ?? null;
        $activity->save();

        session()->flash('message', 'Post actualitzat correctament');

        return to_route('exchange.show', $exchange->id);
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
