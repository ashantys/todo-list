<?php

namespace App\Events;
use Illuminate\Contracts\Events\Dispatcher;

class newToDoCreated extends Event
{
    public $todo;

    public function __construct($todo)
    {
        $this->todo = $todo;
    }

}
