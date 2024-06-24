<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSignaturesTable extends Migration
{
    public function up()
    {
        Schema::create('signatures', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->text('reason');
            $table->unsignedBigInteger('mp_id');
            $table->timestamps();

            $table->foreign('mp_id')->references('id')->on('mps')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('signatures');
    }
}
