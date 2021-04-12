@extends('layouts.app')


@section('botones')

<!--todo lo traemos del index.blade y quitamos la table-->
<a href="{{ route('recetas.index') }}" class="btn btn-outline-primary mr-2 text-uppercase font-weight-bold">
    <svg class="icono" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"></path></svg>
    Pagina principal</a>

@endsection

@section('content')

{{-- <h1>{{ $receta }}</h1>--}}

<article class="contenido-receta bg-white p-2 shadow">

    <h1 class="text-center mb-4"> {{ $receta->titulo}}</h1>

    <div class="imagen-receta">

        <img src="/storage/{{ $receta->imagen }}" class="w-100" >
    </div>

    <div class="receta-meta mt-4">

        <p>

            <span class="font-weight-bold text-primary">Escrito en:</span>
            
            <a class="text-dark" href="{{ route('categorias.show', ['categoriaReceta' => $receta->categoria->id ]) }}">
                {{ $receta->categoria->nombre}}
            </a>

        </p>

        <p>

            <span class="font-weight-bold text-primary">Autor:</span>
            {{-- Todo: mostrar el usuario--}}
            <a class="text-dark" href="{{ route('perfiles.show', ['perfil' => $receta->autor->id ]) }}">

            {{ $receta->autor->name }}
        </p>

        <p>

            <span class="font-weight-bold text-primary">Creada:</span>

            @php
                $fecha = $receta->created_at
            @endphp

            <fecha-receta fecha="{{ $fecha }}" ></fecha-receta> 
            {{-- PARTE DE VUE.JS CON MOMENTJS --}}

        </p>



        <div class="ingredientes">

            <h2 class="my-3 text-primary">Ingredientes</h2>

             {!! $receta->ingredientes !!} {{-- se coloca asi para que no aparezca el html --}}

        </div>

        <div class="preparacion">

            <h2 class="my-3 text-primary">Preparación</h2>

             {!! $receta->preparacion !!} {{-- se coloca asi para que no aparezca el html --}}
             
        </div>

        <div class="justify-content-center row text-center">

            <like-button receta-id="{{$receta->id}}}" like="{{$like}}" likes="{{$likes}}">
            
                
            </like-button>
        </div>
    </div>
</article>

@endsection