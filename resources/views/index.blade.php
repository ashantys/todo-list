@extends('layout')

@section('title')
    <title>ToDo list</title>
@endsection

@section('content')
    <div class="container-fluid p-3">
        <h1 class="text-center">ToDo's</h1>
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Título de la tarea" aria-label="Título de la tarea"
                id="title" aria-describedby="button-addon2">
            <button class="btn btn-success btn-lg" type="button" id="button-addon2" onclick="createTodo()">Agregar</button>
        </div>

        @if ($hasTodo)
            <p>La variable $hasTodo es de la cache.</p>
        @else
            <p>La variable $hasTodo es de la DB.</p>
        @endif

        <div class="container" id="container">
            @foreach ($todo as $todo)
                <div class="card mt-3 animate__animated" id="card{{ $todo->id }}">
                    <div class="card-body">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="{{ $todo->id }}"
                                @if ($todo->check) checked @endif>
                            <label class="form-check-label" for="{{ $todo->id }}">
                                {{ $todo->title }}
                            </label>
                        </div>
                        <p class="me-5">Fecha de creación: {{ $todo->created_at }}</p>
                        <button class="btn btn-danger mt-3" onclick="deleteTodo({{ $todo->id }})">Eliminar
                            Tarea</button>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
@endsection

@section('scripts')
    <script src="js/api.js"></script>
@endsection