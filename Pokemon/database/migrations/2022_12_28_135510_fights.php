<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fight', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('winner_id');
            $table->foreign('winner_id')->references('id')->on('users');
            $table->unsignedBigInteger('loser_id');
            $table->foreign('loser_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fight');
    }
};