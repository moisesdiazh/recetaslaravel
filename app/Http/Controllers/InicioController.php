<?php

namespace App\Http\Controllers;

use App\Receta;
use App\CategoriaReceta;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class InicioController extends Controller
{


    public function index(){

    //Mostrar las recetas por cantidad de votos
    // $votadas = Receta::has('likes', '>', 0)->get(); 
    //tipo para una bienes y raices que sean detalles o algo asi

    //para que sea mas dinamica
     $votadas = Receta::withCount('likes')->orderBy('likes_count', 'desc')->take(3)->get();


        //Obtener las recetas mas nuevas
        $nuevas = Receta::latest()->take(5)->get();
        //agarra de receta las ultimas de forma desc, toma solo 5

        //obtener todas las categorias
        $categorias = CategoriaReceta::all();

        //agrupar las recetas por categoria
        $recetas = [];

        foreach($categorias as $categoria){

            $recetas[ Str::slug( $categoria->nombre ) ][] = Receta::where('categoria_id', $categoria->id)->take(4)->get();
        }


        return view('inicio.index', compact('nuevas', 'recetas', 'votadas'));
    }
}
