<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique()->nullable();
            $table->string('nik')->unique()->nullable();
            $table->string('alamat')->nullable();
            // $table->string('listing_id')->nullable();
            $table->string('user_status');
            $table->string('snk')->default(0);
            $table->string('phone')->unique()->nullable();
            $table->string('photo_identitas')->nullable();
            $table->string('photo_ktp')->nullable();
            $table->string('status_penghuni')->nullable();
            $table->timestamp('email_verified_at');
            $table->string('password')->nullable();
            $table->longText('device_token')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
