<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeekDaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('week_days', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->boolean('sat')->default(false);
            $table->boolean('sun')->default(false);
            $table->boolean('mon')->default(false);
            $table->boolean('tues')->default(false);
            $table->boolean('wed')->default(false);
            $table->boolean('thurs')->default(false);
            $table->boolean('fri')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('week_days');
    }
}
