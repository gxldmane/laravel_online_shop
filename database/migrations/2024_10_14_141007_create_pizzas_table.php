<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePizzasTable extends Migration
{
    public function up()
    {
        Schema::create('pizzas', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->decimal('price', 8, 2);
            $table->string('image')->nullable(); // Поле для изображения пиццы
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pizzas');
    }
}