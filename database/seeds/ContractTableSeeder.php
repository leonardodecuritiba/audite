<?php

use App\Models\Moviments\Contract;
use Illuminate\Database\Seeder;

class ContractTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    //php artisan db:seed --class=ContractTableSeeder
	    factory( Contract::class, 50 )->create();
	    $this->command->info( 'Contract complete ...' );
    }
}
