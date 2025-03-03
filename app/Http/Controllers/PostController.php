<?php

namespace App\Http\Controllers;


use App\Models\Post;
use App\Models\Tag;
use App\Models\Comment;
use Illuminate\Http\Request;
class PostController extends Controller
{
    public function index(Request $request) {
        $sort_order = $request->query("sort");

        $posts = Post::when($sort_order === 'oldest', function ($query) {
            return $query->orderBy('created_at','asc');
        })->when($sort_order === 'latest', function ($query) {
            return $query->orderBy('created_at','desc');
        })->when($sort_order === 'views', function ($query) {
            return $query->orderBy('views','desc');
        })->paginate(12);
        return view('posts.index', compact('posts','sort_order'));
    }

    public function store(Request $request) {
        $request->validate([
            'title' =>'required|min:3',
            'description' =>'required|min:100',
            'tag' =>'required|min:3|string',
        ]);
        
        $post = Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => $request->user()->id,
            'slug' => fake()->slug(),
        ]);
    
        $tagNames = explode(',', $request->tag);
        $tagNames = array_map('trim', $tagNames);
        
        $tagIds = [];
        foreach ($tagNames as $tagName) {
            $tag = Tag::create(['name' => $tagName]);
            $tagIds[] = $tag-> id;
        }
        $post->tags()->sync($tagIds);
        return redirect('/posts?sort=views');
    }
    public function create() {
        return view('posts.create');
    }

    public function show(Post $post) {
        if( !auth()->check() || auth()->id() != $post->user_id ) {
            $post->increment('views');
        }
        return view('posts.show', ['post' => Post::with('user','comments')->findOrFail( $post->id ) ]);
    }



    public function edit(Post $post) {
        return view('posts.edit', ['post' => $post]);
    }

    public function update(Request $request ,Post $post) {
        $request->validate([
            'title' =>'required|min:3',
            'description' =>'required|string',
        ]);
        $postToEdit = $post;
        $postToEdit->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);
    
        $tagNames = explode(',', $request->tag);
        $tagNames = array_map('trim', $tagNames);
    
        $tagIds = [];
        foreach ($tagNames as $tagName) {
            $tag = Tag::firstOrCreate(['name' => $tagName]);
            $tagIds[] = $tag->id;
        }
        $postToEdit->tags()->sync($tagIds);
        return redirect('/posts/'.$post->slug);
    }

    public function destroy(Post $post) {
        $post->delete();
        return redirect('/posts?sort=views');
    }

    public function storeComment(Request $request ,Post $post) {
        $request ->validate([
            'comment_text' =>'required|min:3',
        ]);
        $post->comments()->create([
            'comment_text' => $request->comment_text,
            'user_id' => $request->user()->id
        ]);
        return back();
    }

    public function destroyComment(Comment $comment) {
        $comment->delete();
    return back();
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $posts = Post::where('title', 'LIKE', "%{$query}%")
                    ->orWhere('content', 'LIKE', "%{$query}%")
                    ->paginate(10);

        return view('posts.index', compact('posts'));
    }
}