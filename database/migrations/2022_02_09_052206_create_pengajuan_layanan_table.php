<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengajuanLayananTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengajuan_layanan', function (Blueprint $table) {
            $table->id();
            $table->string('layanan_id');
            $table->string('status');
            $table->integer('user_id');
            $table->date('tanggal');
            $table->time('jam');
            $table->longText('catatan');
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
        Schema::dropIfExists('pengajuan_layanan');
    }
}
