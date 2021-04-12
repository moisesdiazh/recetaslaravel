<?php

namespace App\Http\Controllers;

use App\CategoriaReceta;
use App\Receta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Redirect;

class RecetaController extends Controller
{
    public function __construct() //para proteger la url
    {                             //el except es para que haga el show publico
        $this->middleware('auth', ['except' => ['show', 'search']] );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //es lo mismo que Auth::user()->recetas
        // $recetas = auth()->user()->recetas;

        //extraemos el id de la bd
        $usuario = auth()->user();

        //Recetas con paginacion
        $recetas = Receta::where('user_id', $usuario->id)->paginate(8);
        //luego vamos al index a colocar el links en la parte final de la tabla

        return view('recetas.index')
            ->with('recetas', $recetas)
            ->with('usuario', $usuario);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   //obtener las categorias sin modelo //pluck es para señalar que queremos de la bd
        // $categorias = DB::table('categoria_recetas')->get()->pluck('nombre', 'id');;

        //obtener las categorias con modelo
        $categorias = CategoriaReceta::all(['id', 'nombre']);

        return view('recetas.create')->with('categorias', $categorias);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) //DONDE GUARDAMOS EL TITULO DE LA RECETA
    {

        //validacion
        $data = request()->validate([

            'titulo' => 'required|min:6',
            'preparacion' => 'required',
            'ingredientes' => 'required',
            'imagen' => 'required|image',
            'categoria' => 'required'

        ]); //LO QUE REQUERIMOS

        $ruta_imagen = $request['imagen']->store('upload-recetas', 'public');
        //obtener ruta de la imagen

        //resize de la imagen
        $img = Image::make(public_path("storage/{$ruta_imagen}"))->fit(1000, 550);
        $img->save();
        

        //almacenar en la bd (sin modelo)
        // DB::table('recetas')->insert([ //EL GUARDADO EN LA BD

    //            'titulo' => $data['titulo'],
    //         'preparacion' => $data['preparacion'],
    //        'ingredientes' => $data['ingredientes'],
    //         'imagen' => $ruta_imagen,
    //         'user_id' => Auth::user()->id,
    //         'categoria_id' => $data['categoria']

    //    ]);

        //almacenar en la bd con modelo

        auth()->user()->recetas()->create([

            'titulo' => $data['titulo'],
            'preparacion' => $data['preparacion'],
            'ingredientes' => $data['ingredientes'],
            'imagen' => $ruta_imagen,
            'categoria_id' => $data['categoria']
        ]);

        //redireccion
        return redirect()->action('RecetaController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function show(Receta $receta)
    {
        //Obtener si el usuario actual le gusta la receta y esta autenticado 
        $like = ( auth()->user() ) ? auth()->user()->meGusta->contains($receta->id) : false;
        //si el usuario esta autenticado que es la primera condicion
        //luego vemos mediante el contains si tiene algun me gusta, si dice que no retorna false

        //pasa la cantidad de likes a la vista
        $likes = $receta->likes->count();

        return view('recetas.show', compact('receta', 'like', 'likes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function edit(Receta $receta)
    {
        // Ejecutar el policy
        $this->authorize('view', $receta);

        //con modelo
        $categorias = CategoriaReceta::all(['id', 'nombre']);

                                    //debe ser el mismo nombre de la variable
        return view('recetas.edit', compact('categorias', 'receta'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Receta $receta)
    {
        //revisar el policy
        $this->authorize('update', $receta);

                //validacion
                $data = request()->validate([

                    'titulo' => 'required|min:6',
                    'preparacion' => 'required',
                    'ingredientes' => 'required',
                    'categoria' => 'required'
                ]);
        
        //asignamos valores
        $receta->titulo = $data['titulo'];
        $receta->preparacion = $data['preparacion'];
        $receta->ingredientes = $data['ingredientes'];
        $receta->categoria_id = $data['categoria'];

        //si el usuario sube una nueva imagen
        if(request('imagen')){

            $ruta_imagen = $request['imagen']->store('upload-recetas', 'public');
            //obtener ruta de la imagen
    
            //resize de la imagen
            $img = Image::make(public_path("storage/{$ruta_imagen}"))->fit(1000, 550);

            $img->save();

            //asignamos al objeto
            $receta->imagen = $ruta_imagen;
        }

        //guardamos los datos
        $receta->save();

        return redirect()->action('RecetaController@index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Receta $receta)
    {
        
        //ejecutar el policy
        $this->authorize('delete', $receta);

        //eliminar la receta
        $receta->delete();

        //redireccion
        return redirect()->action('RecetaController@index');


    }

    public function search(Request $request){

        $busqueda = $request['buscar']; //buscar es el name que le damos en el input
        // $busqueda = $request->get('buscar'); es lo mismo de lo de arruba

        $recetas = Receta::where('titulo', 'like', '%' . $busqueda . '%')->paginate(10);
        $recetas->appends(['buscar' => $busqueda]); 
        //el appends te ayuda en la busqueda con la paginacion

        return view('busquedas.show', compact('recetas', 'busqueda'));
    }
}
