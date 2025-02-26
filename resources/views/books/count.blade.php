@extends('layouts.master')

<h1>{{ $title }}</h1>
@section('content')
@if (empty($books))
<FONT COLOR="red">No se ha encontrado ninguna libro</FONT>
@else
<FONT COLOR="black">Hay un total de {{ $books }} libros</FONT>
@endif
@endsection