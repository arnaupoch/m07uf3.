<!DOCTYPE html>
<html lang="en">
@extends('layouts.master')
<!-- resources/views (capa 2) vista-->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books List</title>

    <!-- Add Tailwind CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Include any additional stylesheets or scripts here -->
</head>
<body class="container mx-auto">
    @section('content')
    @if(session('error'))
    <div class="bg-red-500 text-white p-4 mb-4">
        {{ session('error') }}
    </div>
    @endif

    <!-- Your existing form goes here -->
    <form action="{{ route('createbook') }}" method="post">
        <!-- Form fields -->
    </form>


    <h2 align="center">Lista de libros</h2  >
    <div class="flex justify-center items-center">
        <ul class="list-disc pl-4">
            <li><a href="/bookout/oldbooks" class="text-blue-500">Libros antiguas</a></li>
            <li><a href="/bookout/newbooks" class="text-blue-500">libros nuevas</a></li>
            <li><a href="/bookout/allbooks" class="text-blue-500">libros</a></li>
        </ul>
    </div>

    <h2 align="center">Lista de autores</h2  >
    <div class="flex justify-center items-center">
        <ul class="list-disc pl-4">
            <li><a href="/bookout/deliteautores" class="text-blue-500">delite autores</a></li>
            <li><a href="/bookout/decadaautores" class="text-blue-500">lista autores por decada</a></li> 
            <li><a href="/bookout/listautores" class="text-blue-500">all autores</a></li>
        </ul>
    </div>




    <form action="{{ route('createbook') }}" method="post" class="mx-auto flex items-center flex-col">
        @csrf <!-- Include CSRF token for security -->
        <label for="name" class="block" align="center">Name:
        <input type="text" id="name" name="name" required class="border mb-2"></label>

        <label for="year" class="block" align="center">Year:
        <input type="number" id="year" name="year" required class="border mb-2"></label>

        <label for="genre" class="block" align="center">Genre:
        <input type="text" id="genre" name="genre" required class="border mb-2"></label>

        <label for="couauthorntry" class="block" align="center">author:
        <input type="text" id="author" name="author" required class="border mb-2"></label>

        <label for="pages" class="block" align="center">pages:
        <input type="number" id="pages" name="pages" required class="border mb-2"></label>

        <label for="url_image" class="block" align="center">URL Image:
        <input type="text" id="url_image" name="url_image" required class="border mb-2"></label>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded mt-4">Register book</button>
    </form>

    <!-- Include any additional HTML or Blade directives here -->
    @endsection
</body>


</html>