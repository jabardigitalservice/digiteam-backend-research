<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Organization;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Str;

class ArticleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $organizations = Organization::isRoot()->get();
        $users = User::offset(1)->limit(4)->get();

        foreach ($organizations as $key => $organization) {
            DB::statement("SET search_path TO $organization->schema");
            for ($i = 1; $i < 6; $i++) {
                DB::table('articles')->insert([
                    'id' => Str::uuid(),
                    'title' => 'Artikel ' . $i . ' ' . $organization->name,
                    'description' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book",
                    'image' => 'https://dummyimage.com/720x300/706f70/fff.png&text=Digiteam+V2+' . str_replace(' ', '+', $organization->name),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                    'created_by' => $users[$key]->id
                ]);
            }
        }
    }
}
