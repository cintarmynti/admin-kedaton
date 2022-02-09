<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properti', function (Blueprint $table) {
            $table->id();
            $table->integer('pemilik_id')->nullable();
            $table->integer('cluster_id')->nullable();
            $table->string('no_rumah')->nullable();
            $table->string('no_listrik')->nullable();
            $table->string('no_pam_bsd')->nullable();
            $table->integer('penghuni_id')->nullable();
            $table->string('alamat')->nullable();;
            $table->integer('RT')->nullable();;
            $table->integer('RW')->nullable();;
            $table->string('lantai')->nullable();;
            $table->integer('jumlah_kamar')->nullable();
            $table->string('luas_tanah')->nullable();;
            $table->string('luas_bangunan')->nullable();
            $table->integer('tarif_ipkl')->nullable();
            $table->string('status')->nullable();
            $table->string('harga')->nullable();
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
        Schema::dropIfExists('properti');
    }
}
