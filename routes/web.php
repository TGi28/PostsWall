<?php


use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TagController;
use App\Models\User;
use App\Models\Tag;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\MessagesController;
use Illuminate\Support\Facades\Route;
use App\Models\Post;

// Auth
Route::get('/register', [RegisteredUserController::class,'create']);
Route::post('/register', [RegisteredUserController::class,'store']);

Route::get('/login', [SessionController::class,'create'])->name('login');
Route::post('/login', [SessionController::class,'store']);

Route::get('/settings', [SessionController::class,'settings'])->middleware('auth');
Route::patch('/settings', [SessionController::class,'update'])->middleware('auth');


Route::get('/', function () {
    return view('home', ['posts' => Post::take(9)->orderBy('views','DESC')->get(),'users' => User::withSum('posts', 'views')
    ->orderByDesc('posts_sum_views')
    ->limit(9)
    ->get(), 'tags' => Tag::take(9)->get()]);
});
Route::get('/logout', [SessionController::class,'destroy'])->middleware('auth');

Route::get('/profile', [SessionController::class,'index'])->middleware('auth')->name('profile.index');


Route::get('posts', [PostController::class,'index'])->name('posts.index');
Route::get('/posts/create', [PostController::class,'create'])->middleware('auth');
Route::post('posts/create', [PostController::class,'store'])->middleware('auth')->name('posts.store');
Route::get('/search', [PostController::class, 'search'])->name('posts.search');
Route::get('posts/{post:id}/edit', [PostController::class, 'edit'])->middleware('auth');
Route::patch('/posts/{post:id}', [PostController::class,'update'])->middleware('auth')->name('posts.update');
Route::delete('/posts/{post:id}', [PostController::class,'destroy'])->middleware('auth')->name('posts.destroy');
Route::get('/posts/{post:id}', [PostController::class,'show']);


Route::get('/tags', [TagController::class,'index']);
Route::get('/tags/{tag:id}', [TagController::class,'show']);

Route::get('/authors', [UserController::class,'index']);
Route::get('/authors/{user:id}', [UserController::class,'show']);

Route::get('/chats', [MessagesController::class,'index'])->middleware('auth');
