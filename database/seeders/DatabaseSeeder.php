<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Salex\Succinct\Database\Seeders\ServiceCategorySeeder;
use Webkul\Velocity\Database\Seeders\VelocityMetaDataSeeder;
use Webkul\Admin\Database\Seeders\DatabaseSeeder as BagistoDatabaseSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(BagistoDatabaseSeeder::class);
        $this->call(VelocityMetaDataSeeder::class);
        $this->call(ServiceCategorySeeder::class);
    }
}
