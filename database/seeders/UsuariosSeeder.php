<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsuariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $empresa = new \App\Models\Empresa;

        $empresa->nome = 'EMPRESA MODELO';
        $empresa->cnpj = '1111111111/11111';
        $empresa->saveOrFail();
        //
        $user = new \App\Models\User;
        $user->empresa_id = $empresa->id;
        $user->name = 'Mauricio Bassi';
        $user->email = 'maubassi@gmail.com';
        $user->password = Hash::make('teste@123');
        $user->departamento = 'DEPTO PESSOAL';
        $user->admin = 1;
        $user->saveOrFail();
    }
}
