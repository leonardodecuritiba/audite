<?php

use Illuminate\Database\Seeder;
use App\Models\Users\Role;

class ZizacoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //php artisan db:seed --class=ZizacoSeeder
        $start = microtime( true );
        $this->command->info( 'Iniciando os Seeders ZizacoSeeder' );
        $this->command->info( 'SETANDO Administrador' );
        $admin               = new Role(); // Gerência = tudo
        $admin->name         = 'root';
        $admin->display_name = 'ADMIN'; // optional
        $admin->description  = 'Usuário Admin com acesso total ao sistema'; // optional
        $admin->save();

        $start = microtime( true );
        $this->command->info( 'Iniciando os Seeders NewChangesSeeder' );
        $this->command->info( 'SETANDO Financeiro' );
        $financial               = new \App\Models\Users\Role(); // Gerência = tudo
        $financial->name         = 'financial';
        $financial->display_name = 'FINANCEIRO'; // optional
        $financial->description  = 'Usuário Financeiro com acesso restrito ao sistema'; // optional
        $financial->save();

        $start = microtime( true );
        $this->command->info( 'Iniciando os Seeders ZizacoSeeder' );
        $this->command->info( 'SETANDO Operacional' );
        $admin               = new Role(); // Gerência = tudo
        $admin->name         = 'operational';
        $admin->display_name = 'OPERACIONAL'; // optional
        $admin->description  = 'Usuário Operacional com acesso parcial ao sistema'; // optional
        $admin->save();


	    echo "\n*** Completo em " . round((microtime(true) - $start), 3) . "s ***";
    }
}
