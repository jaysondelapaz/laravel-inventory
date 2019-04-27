<?php
use App\User; 	
use Illuminate\Database\Seeder;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::create(['name'=>"Super user",'gender'=>"male",'position'=>"administrator",'contact'=>"09263266748",'email'=>"jayson_delapaz@rocketmail.com",'username'=>"renz",'password'=>bcrypt("renzdelapaz"),'type'=>"superuser"]);

         
    }
}
