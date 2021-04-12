<?php

namespace App\Http\Controllers;

use App\Receta;
use Illuminate\Http\Request;

class LikesController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Receta  $receta
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        
        $this->middleware('auth');
    }

    public function update(Request $request, Receta $receta)
    {

        //Almacena los likes de un usuario a una receta
        return auth()->user()->meGusta()->toggle($receta);
        //toggle se encarga de quitar o poner el like, ve si tiene puesto o no el like
        //tambien sirve para seguir o dejar de seguir
    }
}
