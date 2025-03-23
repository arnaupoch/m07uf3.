@extends('layouts.master')
@section('content')
<h1>{{ $title }}</h1>

@if($autores->isEmpty())
    <font color="red">No se ha encontrado ningún autor</font>
@else
    <div align="center">
        <table border="1">
            <tr>
                @foreach(array_keys(get_object_vars($autores->first())) as $key)
                    <th>{{ $key }}</th>
                @endforeach
            </tr>

            @foreach($autores as $autor)
            <tr>
                <td>{{ $autor->id }}</td>
                <td>{{ $autor->name }}</td>
                <td>{{ $autor->surname }}</td>
                <td>{{ $autor->birthdate }}</td>
                <td>{{ $autor->country }}</td>
                <td><img src="{{ $autor->img_url }}" style="width: 100px; height: 120px;" /></td>
            </tr>
            @endforeach
        </table>
    </div>
@endif
@endsection
