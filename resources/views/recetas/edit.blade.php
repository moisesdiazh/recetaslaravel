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

<h2 class="text-center mb-5">Editar receta {{ $receta->titulo }}</h2>

        <div class="row justify-content-center mt-5">
            <div class="col-md-8">           
                            <!--aqui ejecutamos la accion para guardar en la bd la receta-->
                <form method="POST" action="{{ route('recetas.update', ['receta' => $receta->id]) }}" enctype="multipart/form-data" novalidate> 
                    @csrf

                    {{-- para agregar un metodo extra ya que html solo soporta get y post --}}
                     @method('put') 

                    <!--le añadimos el csrf para darle seguridad al formulario-->
                    <div class="form-group">

                        <label for="titulo">Nombre Receta</label>

                                    <!--el error resaltara el input cuando se coloque mal-->
                        <input type="text" 
                            name="titulo"       
                            class="form-control @error('titulo') is-invalid @enderror"
                            id="titulo"
                            placeholder="Titulo Receta" 
                            value="{{ $receta->titulo }}"
                        /> <!--placeholder es un texto por default en el boton-->

                        @error('titulo')
                         <!--mensaje de error con el titulo--> 
                            <span class="invaid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>    

                        <div class="form-group"> <!--boton donde aparecen las categorias-->

                            <label for="categoria">Categoria</label>

                            <select name="categoria" 
                                    class="form-control @error('titulo') is-invalid @enderror" 
                                    id="categoria"
                                    >
                                <option value="">-- Seleccione --</option>
                                @foreach($categorias as $id => $categoria)
                                        <!--old para que aparezca el ultimo registro colocado-->
                                <option value="{{ $categoria->id }}" 
                                    {{ $receta->categoria_id == $categoria->id ? 'selected' : ''}}
                                    > {{ $categoria->nombre }}</option>

                                @endforeach
                            </select>

                            @error('categoria')
                            <!--mensaje de error con la categoria--> 
                               <span class="invaid-feedback d-block" role="alert">
                                   <strong>{{ $message }}</strong>
                               </span>
                           @enderror

                        </div>
                    

                    <div class="form-group mt-3"> 
                        <!--div de preparacion PARA MODIFICAR EL TAMAÑOS ES EN SASS-->

                        <label for="preparacion">Preparación</label>

                        <input id="preparacion" type="hidden" name="preparacion" 
                        value="{{ $receta->preparacion }}">

                        <trix-editor 
                        class="form-control @error('titulo') is-invalid @enderror"
                        input="preparacion" >

                        </trix-editor>

                        @error('preparacion')
                            <!--mensaje de error con la categoria--> 
                               <span class="invaid-feedback d-block" role="alert">
                                   <strong>{{ $message }}</strong>
                               </span>
                           @enderror

                    </div>

                    <div class="form-group mt-3"> 
                        <!--div de ingredientes PARA MODIFICAR EL TAMAÑOS ES EN SASS-->

                        <label for="ingredientes">Ingredientes</label> 

                        <input id="ingredientes" type="hidden" name="ingredientes" 
                        value="{{ $receta->ingredientes }}">

                        <trix-editor 
                        class="form-control @error('titulo') is-invalid @enderror"
                        input="ingredientes">
                        
                        </trix-editor>

                        @error('ingredientes')
                        <!--mensaje de error con la categoria--> 
                           <span class="invaid-feedback d-block" role="alert">
                               <strong>{{ $message }}</strong>
                           </span>
                       @enderror

                    </div>

                    <div class="form-group mt-3"> 
                        <!--div de ingredientes PARA MODIFICAR EL TAMAÑOS ES EN SASS-->

                        <label for="imagen">Elige la imagen</label> 
                        <input 
                        id="imagen" 
                        type="file" 
                        class="form-control @error('titulo') is-invalid @enderror" }
                        name="imagen"
                        >

                        <div class="mt-4">

                            <p>Imagen</p>

                            <img src="/storage/{{ $receta->imagen }}" style="width: 300px">
                        </div>

                        @error('imagen')
                        <!--mensaje de error con la categoria--> 
                           <span class="invaid-feedback d-block" role="alert">
                               <strong>{{ $message }}</strong>
                           </span>
                       @enderror
                    </div>
 

                    <div class="form-group"> <!--boton de guardado-->

                        <input type="submit" class="btn btn-primary" value="Guardar">
                    </div> 

                </form>
            </div>
        </div>
@endsection

@section('script') <!--trix editor pero con js-->

<script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.js" integrity="sha512-/1nVu72YEESEbcmhE/EvjH/RxTg62EKvYWLG3NdeZibTCuEtW5M4z3aypcvsoZw03FAopi94y04GhuqRU9p+CQ==" crossorigin="anonymous" defer></script>
@endsection