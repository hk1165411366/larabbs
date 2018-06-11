<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class)->times(10)->create();

        $user = User::find(1);
        $user->assignRole('Founder');
        $user->name = 'hk';
        $user->password = bcrypt('123456');
        $user->email = '1165411366@qq.com';
        $user->avatar = 'https://fsdhubcdn.phphub.org/uploads/images/201710/14/1/ZqM7iaP4CR.png?imageView2/1/w/200/h/200';
        $user->save();

        $user = User::find(2);
        $user->assignRole('Maintainer');
    }
}
