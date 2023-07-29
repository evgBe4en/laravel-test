<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\PostTag;
use App\Models\Tag;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();

        return view('post.index', compact('posts'));
    }

    public function create()
    {
        $tags = Tag::all();
        $categories = Category::all();
        return view('post.create', compact('categories', 'tags'));
    }

    public function store()
    {
        $data = \request()->validate([
            'title' => 'string',
            'content' => 'required|string',
            'image' => 'required|string',
            'category_id' => '',
            'tags' => '',
        ]);
        $tags = $data['tags'];
        unset($data['tags']);

        $post = Post::create($data);
        $post->tags()->attach($tags);

        return redirect()->route('post.index');
    }

    public function show(Post $post)
    {
        return view('post.show', compact('post'));
    }

    public function edit(Post $post)
    {
        $tags = Tag::all();
        $categories = Category::all();
        return view('post.edit', compact('post', 'categories', 'tags'));
    }

    public function update(Post $post)
    {
        $data = \request()->validate([
            'title' => 'string',
            'content' => 'string',
            'image' => 'string',
            'category_id' => '',
            'tags' => '',
        ]);

        $tags = $data['tags'];
        unset($data['tags']);

        $post->update($data);
        $post->tags()->sync($tags);
        return redirect()->route('post.show', $post->id);
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('post.index');
    }

    public function delete()
    {
        $post = Post::find(5);
        $post->delete();
        dd('delete');
    }

    public function restore()
    {
        $post = Post::withTrashed()->find(5);
        $post->restore();
        dd('restore');
    }

    public function firstOrCreate()
    {

        $myPost = [
            'title' => 'Super post',
            'content' => 'Hello, I`m Super post',
            'image' => 'Super.img',
            'likes' => 158,
            'is_published' => 1,
        ];

        $post = Post::firstOrCreate([
            'title' => 'New updated another post',
        ], [
            'title' => 'Super post',
            'content' => 'Hello, I`m Super post',
            'image' => 'Super.img',
            'likes' => 158,
            'is_published' => 1,
        ]);
        dump($post->content);
        dd('firstOrCreate');
    }

    public function updateOrCreate()
    {
        $myPost = [
            'title' => 'updateOrCreate post',
            'content' => 'updateOrCreate, I`m Super post',
            'image' => 'updateOrCreate.img',
            'likes' => 58,
            'is_published' => 1,
        ];

        $post = Post::updateOrCreate([
            'title' => 'some post',
        ], [
            'title' => 'some post',
            'content' => 'updateOrCreate, I`m Super post',
            'image' => 'updateOrCreate.img',
            'likes' => 58,
            'is_published' => 1,
        ]);
        dump($post->title);
        dd('updateOrCreate');
    }
}
