<?php

namespace Database\Seeders;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $organizations = Organization::isRoot()->get();

        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'username' => 'superadmin',
            'password' => 'password'
        ]);

        $superAdmin->organization()->attach($organizations->pluck('id')->toArray());

        foreach ($organizations as $key => $value) {
            $user = User::create([
                'name' => 'Imam ' . $value->name,
                'email' => 'imam.' . $value->slug . '@gmail.com',
                'username' => 'imam-' . $value->slug,
                'password' => 'password'
            ]);

            if ($key % 2 == 0) {
                $user->organization()->attach([$value->id, $organizations[$key + 1]->id]);
            } else {
                $user->organization()->attach($value->id);
            }
        }
    }
}
