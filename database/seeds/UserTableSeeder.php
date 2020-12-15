<?php

use Illuminate\Database\Seeder;
use App\User;
use App\UserData;
use App\UserRole;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class, 15)->create()->each(function ($user) {
            $user->userData()->save(factory(App\UserData::class)->make());
            $user->userRole()->save(factory(App\UserRole::class)->make());
            $user->image()->save(factory(App\Image::class)->state('profile_image')->make());;
        });;
    }
}
