<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAmbookAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ambook_attributes', function (Blueprint $table) {
            $table->id();
            $table->integer('ambook_id');
            $table->string('ambook_name');
            $table->integer('ambook_create');
            $table->integer('ambook_stock');
            $table->integer('ambook_price');
            $table->enum('is_featured', ['No', 'Yes'])->default('No');
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
        Schema::dropIfExists('ambook_attributes');
    }
}
