<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Notification as notifi;
use Livewire\Component;

class Notification extends Component
{
    // public $id;
    public function render()
    {
        return view('livewire.notification');
    }

    public function mark_as_read()
    {
        $read = auth()->user()->unreadNotifications;
        if ($read) {
            $read->markAsRead();
        }
    }

}
