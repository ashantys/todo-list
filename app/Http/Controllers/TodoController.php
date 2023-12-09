<?php

namespace App\Http\Controllers;

use App\Models\todo;
use Illuminate\Http\Request;

/*Validaciones personalizadas*/
use App\Http\Rules\CustomRule;
use App\Http\Rules;

/* Cache */
use Illuminate\Support\Facades\Cache;

/* eventos */
use App\Events\newToDoCreated;
use Illuminate\Support\Facades\Event;


class TodoController extends Controller
{
    public function testM(Request $request){

        return response()->json(["message" => "Entraste"]);
    }

    public function tryRule(Request $request){
        $validation = validator($request->all(), [
            'title' => ['required', 'max:3', 'unique:todos,title', new CustomRule()],
        ]);

        if($validation->fails()){
            return response()->json(['errors' => $validation->errors()->all()], 422);
        }

        return response()->json(['message' => 'El título es diferente de "a"']);

    }

    public function redi(){
        return redirect('/a');
    }

    public function act(){
        return view('a');
    }

    private function updateTodoCache()
    {
        Cache::put('todo', todo::all(), $seconds = 60);
    }

    public function index()
    {

        if(Cache::has('todo')){
            $hasTodo = true;
            $todo = Cache::get('todo');
        }
        else{
            $hasTodo = false;
            $todo = todo::all();
            Cache::put('todo', $todo, $seconds = 60); // 1 minutos
        }

        return view('index', compact('todo', 'hasTodo'));
    }

    public function create(Request $request)
    {
        // Validación
        $validation = validator($request->all(), [
            'title' => 'required',
        ]);

        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()->all()], 422);
        }

        $existingTodo = todo::where('title', $request->input('title'))->first();
        if ($existingTodo !== null) {
            return response()->json(['message' => 'La tarea "' . $request->input('title') . '" ya existe']);
        }

        $todo = new Todo();

        $todo->title = $request->input('title');
        $todo->check = false;

        $todo->save();

        $this->updateTodoCache();


        return response()->json(['message' => 'Ok', 'todo' => $todo]);
        /* event(new newToDoCreated($todo)); */
    }

    public function updateStatus(Request $request, $id)
    {
        // Actualizar por ID

        // Buscar la tarea por ID
        $todo = todo::find($id);

        // Si la tarea no existe, enviar una respuesta con código de estado 404
        if (!$todo) {
            return response()->json(['message' => 'La tarea no ha sido encontrada'], 404);
        }

        // Actualizar los campos de la tarea que se proporcionen en la solicitud
        if ($request->has('check')) {
            $todo->check = $request->input('check');
        }

        $todo->save();

        $this->updateTodoCache();

        return response()->json(['message' => 'Ok', 'newTodo' => $todo]);
    }

    public function destroy($id)
    {
        $todo = todo::find($id);

        if (!$todo) {
            return response()->json(['message' => 'La tarea no ha sido encontrada'], 404);
        }

        $todo->delete();
        $this->updateTodoCache();

        return response()->json(['message' => 'Ok']);
    }
}
