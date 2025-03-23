@extends('layouts.master')
@section('content')
<h1>{{$title}}</h1>

@if(empty($books))
<FONT COLOR="red">No se ha encontrado ningun libro</FONT>
@else
<div align="center">
    <table border="1">
        <tr>
            @foreach($books as $book)
            @foreach(array_keys($book) as $key)
            <th>{{$key}}</th>
            @endforeach
            @break
            @endforeach
        </tr>

        @foreach($books as $book)
        <tr>
            <td>{{$book['name']}}</td>
            <td>{{$book['year']}}</td>
            <td>{{$book['gender']}}</td>
            <td>{{$book['author']}}</td>
            <td>{{$book['pages']}}</td>
            <td><img src={{$book['img_url']}} style="width: 100px; height: 120px;" /></td>

        </tr>
        @endforeach
    </table>
</div>
@endif
@endsection