<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listing', function (Blueprint $table) {
            $table->id();
            $table->string('alamat');
            $table->string('no_rumah');
            $table->integer('RT');
            $table->integer('RW');
            $table->string('lantai');
            $table->integer('jumlah_kamar');
            $table->string('luas_tanah');
            $table->string('luas_bangunan');
            $table->integer('user_id_penghuni')->nullable();
            $table->integer('user_id_pemilik')->nullable();
            $table->integer('tarif_ipkl')->nullable();
            // $table->integer('listing_id');
            $table->string('status');
            $table->integer('cluster_id');
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
        Schema::dropIfExists('listing');
    }
}
