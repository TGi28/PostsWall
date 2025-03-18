<?php

namespace App\Livewire;

use GuzzleHttp\Psr7\Request;
use Livewire\Component;
use App\Models\Comment;
use App\Models\Post;

class Comments extends Component {

    public $post;
    public $comment;

    public $commentText;
    
    public function mount(Post $post) {
        $this->post = $post;
    }


    public function storeComment() {
        $this->validate([
            'commentText' => 'required|min:3'
        ]);
        Comment::create([
            'post_id' => $this->post->id,
            'comment_text' => $this->commentText,
            'user_id' => auth()->id(),
        ]);
        $this->commentText = '';
    }

    public function destroyComment(Comment $comment) {
        $comment->delete();
    }

    public function render() {
        return view('livewire.comments');
    }
}