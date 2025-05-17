@extends('layouts.master')
@section('content')

<h1>{{ $title }}</h1>

@if (empty($books))
    <font color="red">No se ha encontrado ningún libro</font>
@else
    <div align="center">
        <table border="1">
            <tr>
                @php
                    $headers = array_keys($books[0]); // primer libro como array
                @endphp
                @foreach($headers as $key)
                    <th>{{ $key }}</th>
                @endforeach
            </tr>

            @foreach($books as $book)
                <tr>
                    <td>{{ $book['name'] }}</td>
                    <td>{{ $book['year'] }}</td>
                    <td>{{ $book['gender'] }}</td>
                    <td>{{ $book['author'] }}</td>
                    <td>{{ $book['pages'] }}</td>
                    <td>
                        <img src="{{ $book['img_url'] }}" style="width: 100px; height: 120px;" />
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@endif

@endsection
