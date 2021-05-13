<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('department');
            $table->string('stime');
            $table->string('ftime');
            $table->string('rate');
            $table->string('cv');
            $table->boolean('requested')->default(false);
            $table->boolean('active')->default(false);
            $table->boolean('completed')->default(false);
            $table->string('link')->nullable();
            $table->string('code')->nullable();
            $table->string('pw')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('doctors');
    }
}
