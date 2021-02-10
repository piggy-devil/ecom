<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAmbooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ambooks', function (Blueprint $table) {
            $table->id();
            $table->integer('ammodel_id');
            $table->string('ambook_name');
            $table->integer('ambook_create');
            $table->integer('ambook_stock');
            $table->integer('ambook_price');
            $table->enum('is_list', ['No', 'Yes'])->default('No');
            $table->enum('is_topic', ['No', 'Yes'])->default('No');
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ambooks');
    }
}
