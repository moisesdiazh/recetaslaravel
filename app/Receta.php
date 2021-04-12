<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receta extends Model
{
    //campos que se agregaran
    protected $fillable = [
        'titulo', 'preparacion', 'ingredientes', 'imagen', 'categoria_id'
    ];

    //Obtiene la categoria mediante Foreign key
    public function categoria()
    {

        return $this->belongsTo(CategoriaReceta::class);
    }

    //obtiene la informacion del usuario via Foreign key

    public function autor(){
                                             //user_id es el fk de esta tabla
        return $this->belongsTo(User::class, 'user_id');
    }

    //likes que ha recibido una receta
    public function likes(){

        return $this->belongsToMany(User::class, 'likes_receta');
    }
}
