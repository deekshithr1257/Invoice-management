<?php

use App\User;
use Illuminate\Database\Seeder;

class RoleUserTableSeeder extends Seeder
{
    public function run()
    {
        User::findOrFail(1)->roles()->sync(1);
        User::whereNotIn('id', [1])->each(function ($user) {
            $user->roles()->sync([2]);
        });
    }
}
