<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class)->create([
            'name' => 'Test User',
            'email' => 'test@gmail.com'
        ]);

        factory(User::class, 5)->create();
    }
}
