<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModesTable extends Migration
{
    public function up()
    {
        Schema::create('modes', function (Blueprint $table) {
            $table->id(); // Create an auto-incrementing primary key
            $table->string('name'); // Column for mode name
            $table->string('description')->nullable(); // Optional description column
            $table->timestamps(); // Created at and updated at columns
        });
    }

    public function down()
    {
        Schema::dropIfExists('modes'); // Drop the modes table
    }
}
