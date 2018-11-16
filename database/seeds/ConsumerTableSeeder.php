<?php

use Illuminate\Database\Seeder;

class ConsumerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Consumer::class, 10)->create();
    }
}
