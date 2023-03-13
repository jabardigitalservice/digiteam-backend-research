<?php

namespace Database\Seeders;

use App\Models\Organization;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class OrganizationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $organizations = ['Jabar Digital Service', 'Diskominfo Jabar', 'Disdik Jabar', 'Dishub Jabar'];
        foreach ($organizations as $organization) {
            $parent = Organization::create([
                'name' => $organization,
                'slug' => Str::slug($organization),
                'schema' => Str::slug($organization),
            ]);

            for ($i = 1; $i < 6; $i++) {
                $childName = 'Divisi ' . $i . ' ' . $organization;
                Organization::create([
                    'name' => $childName,
                    'slug' => Str::slug($childName),
                    'schema' => Str::slug($childName),
                    'parent_id' => $parent->id,
                ]);

                // Dummy data Jika Ada Sub Divisi
                // for ($j = 1; $j < 6; $j++) {
                //     $subDivName = 'Sub Divisi ' . $j . ' ' . $child->name;
                //     Organization::create([
                //         'name' => $subDivName,
                //         'slug' => Str::slug($subDivName),
                //         'schema' => Str::slug($subDivName),
                //         'parent_id' => $child->id,
                //     ]);
                // }
            }
        }
    }
}
