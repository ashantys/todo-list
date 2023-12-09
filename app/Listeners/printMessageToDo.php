<?php

namespace App\Listeners;

use App\Events\newToDoCreated;

use Illuminate\Support\Facades\View;

class printMessageToDo
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  newToDoCreated  $event
     * @return void
     */
    public function handle(newToDoCreated $event)
    {
        $todo = $event->todo;
        
        // Mensaje que se imprimirá en la vista
        $mensaje = "¡Se ha creado una nueva todo con el título: " . $todo->titulo . "!";

        // Compartir el mensaje con la vista
        View::share('mensajeNuevatodo', $mensaje);
    }
}
