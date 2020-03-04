<?php

use Illuminate\Database\Seeder;
use App\User;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Julio Franco',
            'email' => 'jucfra23@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('jcf3458435'), // password
            'ci' =>'3458435',
            'address'=>'Laurelty 4565',
            'phone'=> '0981574711',
            'role'=> 'admin',
            ]);
            
            factory(User::class, 50)->create();
        
    }
}
