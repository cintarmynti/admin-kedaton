<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembayaranMobilePulsasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembayaran_mobile_pulsas', function (Blueprint $table) {
            $table->id();
            $table->integer('type');
            $table->longText('tr_id');
            $table->integer('user_id');
            $table->string('bank');
            $table->string('nominal');
            $table->string('no_pelanggan');
            $table->integer('status')->default(0);
            $table->string('bukti_tf');
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
        Schema::dropIfExists('pembayaran_mobile_pulsas');
    }
}
