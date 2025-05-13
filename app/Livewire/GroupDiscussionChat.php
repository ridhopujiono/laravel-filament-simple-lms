<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Discussion;
use Illuminate\Support\Facades\Auth;

class GroupDiscussionChat extends Component
{
    public $group;
    public $message = '';

    public function mount($group)
    {
        $this->group = $group;
    }

    public function send()
    {
        if (trim($this->message) === '') return;

        Discussion::create([
            'group_id' => $this->group->id,
            'user_id' => Auth::id(),
            'message' => $this->message,
        ]);

        $this->reset('message');
    }

    public function render()
    {
        return view('livewire.group-discussion-chat', [
            'discussions' => $this->group->discussions()->latest()->take(50)->get()->reverse(),
        ]);
    }
}

