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
        Schema::create('people', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('cycle_id')->nullable()->constrained();
            // $table->foreignId('gol_id')->nullable()->constrained();
            $table->foreignId('type_id')->constrained();
            $table->string('names', 100);
            $table->string('last_names', 100);
            $table->integer('code', false, true)->unique();
            $table->string('email', 100)->unique();
            $table->integer('phone', false, true)->unique();
            $table->string('gender', 10);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('people');
    }
};
