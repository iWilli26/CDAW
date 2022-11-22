<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function Ramsey\Uuid\v1;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pokemon', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('back');
            $table->string('front');
            $table->bigInteger('pv_max');
            $table->timestamps();
            $table->integer('energy');
            $table->bigInteger('normal_attack');
            $table->bigInteger('special_attack');
            $table->bigInteger('special_defense');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pokemon');
    }
};