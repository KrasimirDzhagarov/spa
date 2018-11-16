<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsumersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consumers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->index();
            $table->smallInteger("age")->index();
            $table->string("city" , 7)->index();
            $table->timestamps();
        });

        // Add the constraint
        DB::statement('ALTER TABLE consumers ADD CONSTRAINT chk_city CHECK  (city IN ("Sofia", "Plovdiv", "Varna"));');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consumers');
    }
}
