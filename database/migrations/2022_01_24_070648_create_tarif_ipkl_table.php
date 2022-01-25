<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTarifIpklTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tarif_ipkl', function (Blueprint $table) {
            $table->id();
            $table->string('luas_kavling_awal')->nullable();
            $table->string('luas_kavling_akhir')->nullable();
            $table->string('tarif');
            // $table->string('total');
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
        Schema::dropIfExists('tarif_ipkl');
    }
}
