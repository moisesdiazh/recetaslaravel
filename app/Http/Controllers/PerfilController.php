<?php

namespace App\Http\Controllers;

use App\Perfil;
use App\Receta;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class PerfilController extends Controller
{
    public function __construct() //para proteger la url
    {                             //el except es para que haga el show publico
        $this->middleware('auth', ['except' => 'show']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Perfil  $perfil
     * @return \Illuminate\Http\Response
     */
    public function show(Perfil $perfil)
    {
        //Obtener las recetas con paginacion
        $recetas = Receta::where('user_id', $perfil->user_id)->paginate(8);

        //redireccion
        return view('perfiles.show', compact('perfil', 'recetas'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Perfil  $perfil
     * @return \Illuminate\Http\Response
     */
    public function edit(Perfil $perfil)
    {
        //Ejecutando el policy
        $this->authorize('view', $perfil);

        
        return view('perfiles.edit', compact('perfil'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Perfil  $perfil
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Perfil $perfil)
    {
        // Ejecutar el policy
        $this->authorize('update', $perfil);

        //validar
        $data = request()->validate([

            'nombre' => 'required',
            'url' => 'required',
            'biografia' => 'required'
        ]);

        //si el usuario sube una imagen
        if ($request['imagen']) { //este if lo traemos de recetascontroller-update

            $ruta_imagen = $request['imagen']->store('upload-perfiles', 'public');
            //obtener ruta de la imagen

            //resize de la imagen
            $img = Image::make(public_path("storage/{$ruta_imagen}"))->fit(600, 600);

            $img->save();

            //crear arreglo de imagen para poder aplicar en el array_merge
            $array_imagen = ['imagen' => $ruta_imagen];
        }



        //asignar nombre y url 
        auth()->user()->url = $data['url'];
        auth()->user()->name = $data['nombre'];
        auth()->user()->save();

        //eliminar url y name de $data
        unset($data['url']);
        unset($data['nombre']);


        //guardar informacion
        // asignar biografia y imagen
        auth()->user()->perfil()->update(array_merge(
            $data,
            $array_imagen ?? []
        
        ));


        //redireccion
        return redirect()->action('RecetaController@index');

    }


}
