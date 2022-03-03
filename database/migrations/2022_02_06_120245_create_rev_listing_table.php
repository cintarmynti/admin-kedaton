<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRevListingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rev_listing', function (Blueprint $table) {
            $table->id();
            $table->string('diskon')->nullable();
            $table->string('status');
            $table->integer('properti_id');
            $table->integer('cluster_id')->nullable();
            $table->string('harga');
            $table->string('name');
            $table->string('periode')->nullable();
            $table->string('image')->nullable();
            $table->string('desc')->nullable();
            $table->string('setelah_diskon')->nullable();
            $table->timestamps();
            //harga, diskon (opsional), status(sewa/dijual), properti_id
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rev_listing');
    }
}
