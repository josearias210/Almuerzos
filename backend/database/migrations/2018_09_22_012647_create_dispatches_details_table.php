<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDispatchesDetailsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('dispatches_details', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('dispatch_id');
            $table->unsignedInteger('ingredient_id');
            $table->unsignedInteger('quantity');
            $table->foreign('dispatch_id')->references('id')->on('dispatches');
            $table->foreign('ingredient_id')->references('id')->on('ingredients');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('dispatches_details');
    }

}
