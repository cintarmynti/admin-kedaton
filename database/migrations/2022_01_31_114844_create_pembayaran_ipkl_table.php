<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembayaranIpklTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembayaran_ipkl', function (Blueprint $table) {
            $table->id();
            $table->integer('rumah_id');
            $table->date('periode_pembayaran');
            $table->string('metode_pembayaran');
            $table->string('jumlah_pembayaran');
            $table->integer('status')->default(1);
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
        Schema::dropIfExists('pembayaran_ipkl');
    }
}
