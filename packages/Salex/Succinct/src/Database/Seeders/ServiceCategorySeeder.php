<?php

namespace Salex\Succinct\Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/*
 * Category table seeder.
 *
 * Command: php artisan db:seed --class=Salex\\Succinct\\Database\\Seeders\\CategoryTableSeeder
 */
class ServiceCategorySeeder extends Seeder
{
    public function run()
    {
        DB::table('categories')->delete();

        DB::table('category_translations')->delete();

        $now = Carbon::now();

        DB::table('categories')->insert([
            [
                'id'         => '1',
                'position'   => '1',
                'image'      => NULL,
                'status'     => '1',
                '_lft'       => '1',
                '_rgt'       => '14',
                'parent_id'  => NULL,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id'         => '2',
                'position'   => '2',
                'image'      => NULL,
                'status'     => '1',
                '_lft'       => '2',
                '_rgt'       => '15',
                'parent_id'  => NULL,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        DB::table('category_translations')->insert([
            [
                'name'             => 'Root',
                'slug'             => 'root',
                'description'      => 'Root',
                'meta_title'       => '',
                'meta_description' => '',
                'meta_keywords'    => '',
                'category_id'      => '1',
                'locale'           => 'en',
            ],
            [
                'name'             => 'Raíz',
                'slug'             => 'root',
                'description'      => 'Raíz',
                'meta_title'       => '',
                'meta_description' => '',
                'meta_keywords'    => '',
                'category_id'      => '1',
                'locale'           => 'es',
            ],
            [
                'name'             => 'Racine',
                'slug'             => 'root',
                'description'      => 'Racine',
                'meta_title'       => '',
                'meta_description' => '',
                'meta_keywords'    => '',
                'category_id'      => '1',
                'locale'           => 'fr',
            ],
            [
                'name'             => 'Hoofdcategorie',
                'slug'             => 'root',
                'description'      => 'Hoofdcategorie',
                'meta_title'       => '',
                'meta_description' => '',
                'meta_keywords'    => '',
                'category_id'      => '1',
                'locale'           => 'nl',
            ],
            [
                'name'             => 'Kök',
                'slug'             => 'root',
                'description'      => 'Kök',
                'meta_title'       => '',
                'meta_description' => '',
                'meta_keywords'    => '',
                'category_id'      => '1',
                'locale'           => 'tr',
            ],
            

            [
                'name'             => 'Services',
                'slug'             => 'services',
                'description'      => 'Services',
                'meta_title'       => '',
                'meta_description' => '',
                'meta_keywords'    => '',
                'category_id'      => '2',
                'locale'           => 'en',
            ],
            [
                'name'             => 'Servicios',
                'slug'             => 'servicios',
                'description'      => 'Servicios',
                'meta_title'       => '',
                'meta_description' => '',
                'meta_keywords'    => '',
                'category_id'      => '2',
                'locale'           => 'es',
            ],
            [
                'name'             => 'Prestations de service',
                'slug'             => 'service',
                'description'      => 'Prestations de service',
                'meta_title'       => '',
                'meta_description' => '',
                'meta_keywords'    => '',
                'category_id'      => '2',
                'locale'           => 'fr',
            ],


        ]);
    }
}
