<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRenovasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('renovasi', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('rumah_id');
            $table->date('tanggal_mulai');
            $table->date('tanggal_akhir');
            $table->string('catatan_renovasi')->nullable();
            $table->string('catatan_biasa')->nullable();
            $table->integer('status_renovasi')->default(0);
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
        Schema::dropIfExists('renovasi');
    }
}
