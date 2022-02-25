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
            $table->string('alamat')->nullable();
            $table->integer('RT')->nullable();
            $table->integer('RW')->nullable();
            $table->integer('lantai')->nullable();
            $table->integer('jumlah_kamar')->nullable();
            $table->string('luas_tanah')->nullable();
            $table->string('luas_bangunan')->nullable();
            $table->bigInteger('tarif_ipkl')->nullable();
            $table->bigInteger('kamar_mandi')->nullable();
            $table->bigInteger('carport')->nullable();
            $table->string('status')->nullable();
            $table->string('harga')->nullable();
            $table->string('provinsi_id')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('kabupaten_id')->nullable();
            $table->string('kabupaten')->nullable();
            $table->string('kecamatan_id')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('kelurahan_id')->nullable();
            $table->string('kelurahan')->nullable();
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
