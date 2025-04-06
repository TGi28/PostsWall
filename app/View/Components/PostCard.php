<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use App\Models\Post;
use Illuminate\View\Component;

class PostCard extends Component
{
    
    public function __construct(public $post)
    {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('Components.post-card');
    }
}
