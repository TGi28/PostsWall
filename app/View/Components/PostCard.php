<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use App\Models\Post;
use Illuminate\View\Component;

class PostCard extends Component
{
    /**
     * The posts to display.
     *
     * @var array|\Illuminate\Support\Collection
     */
    public $posts;

    /**
     * Create a new component instance.
     */
    public function __construct($posts)
    {
        $this->posts = $posts;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('Components.post-card');
    }
}
