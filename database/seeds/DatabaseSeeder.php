<?php

use Illuminate\Database\Seeder;
use App\Companies\Company;
use Illuminate\Support\Facades\Artisan;
use App\Models\HumanResources\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    $this->call(ImportCepTable::class);
	    $this->call(ZizacoSeeder::class);

	    User::flushEventListeners();
	    User::getEventDispatcher();

	    $user = new User([
            'name'          => 'Leonardo ROOT',
            'email'         => 'silva.zanin@gmail.com',
        ]);
        $user->password = bcrypt('123');
        $user->save();
        $user->attachRole(1);

        $user = new User([
            'name'          => 'Misael ROOT',
            'email'         => 'misael.silva@transnac.com.br ',
        ]);
	    $user->password = bcrypt('123');
        $user->save();
        $user->attachRole(1);

//        $this->call(RequestSeederTable::class);

    }
}
