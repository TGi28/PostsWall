<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;

class Reactions extends Component
{
    public $post;
    public $likes;
    public $dislikes;
    public $hasLiked;
    public $hasDisliked;

    public function mount(Post $post) {
        $this->post = $post;
        $this->likes = $post->likes;
        $this->dislikes = $post->dislikes;
        $this->hasLiked = $post->hasLiked;
        $this->hasDisliked = $post->hasDisliked;
        $this->updatedReactions();
    }

    public function like()
    {
        $user = auth()->user();
        $reactions = $user->reactions ?? [];
        if(!isset($reactions[$this->post->id])) {
            $this->post->increment('likes');
            $reactions[$this->post->id] = 1;
            $this->likes++;
        } elseif($reactions[$this->post->id] === 0) {
            $this->post->increment('likes');
            $this->post->decrement('dislikes');
            $this->likes++;
            $this->dislikes--;
            $reactions[$this->post->id] = 1;        
        }
        $user->reactions = $reactions;
        $user->save();
        $this->updatedReactions();
    }
    
    public function dislike()
    {
        $user = auth()->user();
        $reactions = $user->reactions ?? [];
        if(!isset($reactions[$this->post->id])) {
            $this->post->increment('dislikes');
            $this->dislikes++;
            $reactions[$this->post->id] = 0;
        } elseif($reactions[$this->post->id] === 1) {
            $this->post->increment('dislikes');
            $this->post->decrement('likes');
            $this->dislikes++;
            $this->likes--;
            $reactions[$this->post->id] = 0;        
        }
        $user->reactions = $reactions;
        $user->save();
        $this->updatedReactions();
    }

    public function updatedReactions() {
        if(auth()->check()) {
            $reactions = auth()->user()->reactions ?? [];
            $this->hasLiked = isset($reactions[$this->post->id]) && $reactions[$this->post->id] === 1;
            $this->hasDisliked = isset($reactions[$this->post->id]) && $reactions[$this->post->id] === 0;
        }
    }


    public function render()
    {
        return view('livewire.reactions');
    }
}
