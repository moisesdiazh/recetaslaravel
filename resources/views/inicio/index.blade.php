@extends('layouts.app')


@section('styles')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g==" crossorigin="anonymous" />

@endsection

@section('hero')
    <div class="hero-categorias">
        <form class="container h-100" action="{{ route('buscar.show') }}">
            <div class="row h-100 align-items-center">
                <div class="col-md-4 texto-buscar">

                    <p class="display-4">Buscar</p>

                    <input 
                        type="search"
                        name="buscar"
                        class="form-control"
                        placeholder="Buscar Receta"
                    />

                </div>
            </div>
        </form>
    </div>
@endsection

@section('content')


    <div class="container nuevas-recetas">
    <h2 class="titulo-categoria text-uppercase mb-4">Últimas Recetas</h2>
        <div class="owl-carousel owl-theme">
            @foreach($nuevas as $nueva)
                    <div class="card">

                        <img src="/storage/{{ $nueva->imagen }}" class="card-img-top" alt="imagen receta">

                        <div class="card-body">
                            <h3>{{ Str::title( $nueva->titulo ) }}</h3>
                            <p>{{ Str::words( strip_tags( $nueva->preparacion ), 20 ) }}</p>
{{--Str::words le quita el codigo html al string y pone un limite de letras (20 en nuestro caso)--}}
                            <a href="{{ route('recetas.show', ['receta' => $nueva->id ]) }}"
                               class="btn btn-primary d-block font-weight-bold text-uppercase"
                               >Ver Receta</a>
                        </div>

                    </div>
            @endforeach
        </div>
    </div>

    <div class="container">
        <h2 class="titulo-categoria text-uppercase mt-5 mb-4"> Recetas más votadas</h2>

        <div class="row">
            @foreach($votadas as $receta)
                    {{-- LAS RECETAS SE ENCUENTRAN EN LA VISTA DE UI --}}
                    @include('ui.receta') 
            @endforeach
        </div>
    </div>

    @foreach($recetas as $key => $grupo)
        <div class="container">
            <h2 class="titulo-categoria text-uppercase mt-5 mb-4">
                {{ str_replace('-', ' ', $key) }}
            </h2>

            <div class="row">
                @foreach($grupo as $recetas)
                    @foreach($recetas as $receta)
                        {{-- LAS RECETAS SE ENCUENTRAN EN LA VISTA DE UI --}}
                        @include('ui.receta') 
                    @endforeach
                @endforeach
            </div>
        </div>
    @endforeach
@endsection