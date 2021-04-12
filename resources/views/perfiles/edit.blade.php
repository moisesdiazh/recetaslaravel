@extends('layouts.app')

@section('styles') <!--trix editor con css-->

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.css" integrity="sha512-CWdvnJD7uGtuypLLe5rLU3eUAkbzBR3Bm1SFPEaRfvXXI2v2H5Y0057EMTzNuGGRIznt8+128QIDQ8RqmHbAdg==" crossorigin="anonymous" />
@endsection

@section('botones')

<!--todo lo traemos del index.blade y quitamos la table-->
<a href="{{ route('recetas.index') }}" class="btn btn-outline-primary mr-2 text-uppercase font-weight-bold">
    <svg class="icono" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"></path></svg>
    Pagina principal</a>

@endsection

@section('content')

<h1 class="text-center">Editar Mi Perfil</h1>

<div class="row justify-content-center mt-5">

    <div class="col-md-10 bg-white p-3">

        <form action="{{ route('perfiles.update', ['perfil' => $perfil->id ]) }}"
            method="POST"
            enctype="multipart/form-data"
            >

            @csrf
            @method('put')

             <div class="form-group"> {{-- este div lo sacamos del edit de recetas --}}

                <label for="nombre">Nombre</label>

                            <!--el error resaltara el input cuando se coloque mal-->
                <input type="text" 
                    name="nombre"       
                    class="form-control @error('nombre') is-invalid @enderror"
                    id="nombre"
                    placeholder="Tu nombre" 
                    value="{{ $perfil->usuario->name }}"
                > <!--placeholder es un texto por default en el boton-->

                @error('nombre')
                 <!--mensaje de error con el titulo--> 
                    <span class="invaid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>    

            <div class="form-group"> {{-- este div lo sacamos del edit de recetas --}}

                <label for="url">Sitio Web</label>

                            <!--el error resaltara el input cuando se coloque mal-->
                <input type="text" 
                    name="url"       
                    class="form-control @error('url') is-invalid @enderror"
                    id="url"
                    placeholder="Tu sitio Web" 
                    value="{{ $perfil->usuario->url }}"
                /> <!--placeholder es un texto por default en el boton-->

                @error('url')
                 <!--mensaje de error con el titulo--> 
                    <span class="invaid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>  

             <div class="form-group mt-3"> 
                 <!--div de preparacion PARA MODIFICAR EL TAMAÑOS ES EN SASS-->

                 {{--Este div lo traemos de edit de recetas->preparacion --}}

                <label for="biografia">Biografia</label>

                <input id="biografia" type="hidden" name="biografia" 
                value="{{ $perfil->biografia }}"
                >

                <trix-editor 
                class="form-control @error('biografia') is-invalid @enderror"
                input="biografia" >

                </trix-editor>

                @error('biografia')
                    <!--mensaje de error con la categoria--> 
                       <span class="invaid-feedback d-block" role="alert">
                           <strong>{{ $message }}</strong>
                       </span>
                   @enderror

            </div>

            <div class="form-group mt-3"> 

                {{-- ESTE DIV ES EL DE IMAGEN EN EL EDIT DE RECETAS --}}
                <label for="imagen">Tu Imagen</label> 
                <input 
                id="imagen" 
                type="file" 
                class="form-control @error('titulo') is-invalid @enderror" }
                name="imagen"
                >

                @if( $perfil->imagen )
                <div class="mt-4">

                    <p>Imagen Actual:</p>

                    <img src="/storage/{{ $perfil->imagen }}" style="width: 300px"> 
                </div>

                @error('imagen')
                <!--mensaje de error con la categoria--> 
                   <span class="invaid-feedback d-block" role="alert">
                       <strong>{{ $message }}</strong>
                   </span>
               @enderror

               @endif

            </div>

            <div class="form-group"> <!--boton de guardado-->

                <input type="submit" class="btn btn-primary" value="Actualizar">
            </div> 

        </form>

    </div>

</div>

@endsection

@section('script') <!--trix editor pero con js-->

<script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.js" integrity="sha512-/1nVu72YEESEbcmhE/EvjH/RxTg62EKvYWLG3NdeZibTCuEtW5M4z3aypcvsoZw03FAopi94y04GhuqRU9p+CQ==" crossorigin="anonymous" defer></script>
@endsection