@extends('layouts.master')

<h1>{{ $title }}</h1>
@section('content')
@if (empty($autores))
<FONT COLOR="red">No se ha encontrado ninguna autores</FONT>
@else
<FONT COLOR="black">Hay un total de {{ $autores }} autores</FONT>
@endif
@endsection