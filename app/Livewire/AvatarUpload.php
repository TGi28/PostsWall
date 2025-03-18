<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Intervention\Image\ImageManager;


class AvatarUpload extends Component
{
    use WithFileUploads;

    public $avatar;
    public $previewUrl;

    public function updatedAvatar() {
        $this->previewUrl = $this->avatar->temporaryUrl();
    }

    public function storeAvatar() {
        $this->validate([
            'avatar' => 'required|image|max:1024',
        ]);

        // Resize and crop (300x300 in this case)
        ImageManager::imagick()->read($this->avatar)->cover('300','300')->save('images/avatars/avatar-'.auth()->user()->id.'.jpg');

        auth()->user()->update([
            'avatar' => 'images/avatars/avatar-'.auth()->user()->id.'.jpg'
        ]);
        return redirect()->route('profile.index');
    }
    public function render()
    {
        return view('livewire.avatar-upload');
    }
}
