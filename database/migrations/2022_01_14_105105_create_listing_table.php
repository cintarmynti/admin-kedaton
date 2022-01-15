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
            $table->integer('no_rumah');
            $table->integer('RT');
            $table->integer('RW');
            $table->string('lantai');
            $table->integer('jumlah kamar');
            $table->string('luas_tanah');
            $table->string('luas_bangunan');
            $table->integer('user_id_penghuni');
            $table->integer('user_id_pemilik');
            $table->string('status');
            $table->integer('harga')->nullable();
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
