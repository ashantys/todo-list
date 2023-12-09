@extends('layout')

@section('title')
    <title>404</title>
@endsection

@section('content')
    <div class="error-page p-3">
        <h1>Error 404</h1>
        <p>La página que buscas no fue encontrada.</p>
        <a href="javascript:void(0);" onclick="history.back()">Regresar</a>
    </div>
@endsection
