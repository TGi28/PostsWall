<?php

namespace App\Http\Controllers;


use App\Events\NotificationCreated;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
class PostController extends Controller
{
    public function index(Request $request) {
        $sort_order = $request->query("sort");

        $posts = Post::with('user','tags')->when($sort_order === 'oldest', function ($query) {
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
            'poster' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'preview' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'tag' =>'required|min:3|string'
        ]);

        $poster = $request->file('poster')->store('images','public');
        $preview = $request->file('preview')->store('images','public');
        
        $post = Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => $request->user()->id,
            'poster' => $poster,
            'preview' => $preview,
        ]);
    
        $tagNames = explode(',', $request->tag);
        $tagNames = array_map('trim', $tagNames);
        
        $tagIds = [];
        foreach ($tagNames as $tagName) {
            $tag = Tag::create(['name' => $tagName]);
            $tagIds[] = $tag-> id;
        }
        $post->tags()->sync($tagIds);
        
        // Find subscribers using a different approach for SQLite
        $subscribers = User::whereNotNull('subscriptions')->where('subscriptions', 'LIKE', '%"'.$post->user->id.'"%')->get();

            
        foreach ($subscribers as $subscriber) {
            $subscriber->notifications()->create([
                'name' => 'New Post',
                'description' => 'New post from ' . $request->user()->name,
                'user_id' => $subscriber->id,
                'is_read' => 0,
            ]);
            
            broadcast(new NotificationCreated('New Post Available'))->toOthers();
        }
        
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
        return redirect('/posts/'.$post->id);
    }

    public function destroy(Post $post) {
        $post->delete();
        return redirect('/posts?sort=views');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $posts = Post::where('title', 'LIKE', "%{$query}%")
                    ->orWhere('description', 'LIKE', "%{$query}%")
                    ->paginate(12);

        return view('posts.index', compact('posts'));
    }
}
