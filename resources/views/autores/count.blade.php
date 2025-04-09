@extends('layouts.master')

<h1>{{ $title }}</h1>
@section('content')
@if (empty($autores))
<FONT COLOR="red">No se ha encontrado ninguna libro</FONT>
@else
<FONT COLOR="black">Hay un total de {{ $autores }} libros</FONT>
@endif
@endsection