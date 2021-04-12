<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $user = User::create([
            'name' => 'Juan Pablo',
            'email' => 'juan@juan.com',
            'password' => Hash::make('12345678'),
            'url' => 'http://juan.com',
            
        ]);

        $user->perfil()->create();

        $user2 = User::create([
            'name' => 'Jonathan',
            'email' => 'jonathan@jonathan.com',
            'password' => Hash::make('12345678'),
            'url' => 'http://jonathan.com',
            
        ]);

        $user->perfil()->create();




    }
}
