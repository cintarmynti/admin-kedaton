<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMobilePulsaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mobile_pulsa', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('total');
            $table->string('no_telkom'); // no indihome
            $table->integer('status_pembayaran')->default(0);
            $table->string('jenis_pembayaran');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mobile_pulsa');
    }
}
