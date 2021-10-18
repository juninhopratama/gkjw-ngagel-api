<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->string('uuid', 36);
            $table->string('nama_jemaat');
            $table->string('nik');
            $table->integer('id_ibadah');
            $table->datetime('date_registered');
            $table->integer('wilayah');
            $table->integer('kelompok');
            $table->string('gereja_asal');
            $table->boolean('isScanned');
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
        Schema::dropIfExists('registrations');
    }
}
