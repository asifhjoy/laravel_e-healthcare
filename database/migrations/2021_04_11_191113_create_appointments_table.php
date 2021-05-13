<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{



    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('appointment')->nullable();
            $table->string('transaction_doc');
            $table->string('transaction_client');
            $table->string('docmail');
            $table->string('clientmail');
            $table->date('appointed_date');
            $table->string('appointed_time');
            $table->boolean('attended')->default(false);
            $table->boolean('unattended')->default(false);
            $table->boolean('cancelled')->default(false);


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointments');
    }
}
