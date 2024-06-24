<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMpsTable extends Migration
{
    public function up()
    {
        Schema::create('mps', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('role');
            $table->unsignedBigInteger('county_id');
            $table->unsignedBigInteger('constituency_id')->nullable();
            $table->boolean('voted_yes')->default(false);
            $table->integer('recall_count')->default(0);
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mps');
    }
}
