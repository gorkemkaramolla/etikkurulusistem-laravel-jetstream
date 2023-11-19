<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('forms', function (Blueprint $table) {
            $table->id();
            $table->string("name")->nullable();
            $table->string("tc_kimlik_no")->nullable();
            $table->string("calisma_basligi")->nullable();
            $table->string("calisma_programi")->nullable();
            $table->string("path_gonullu_onam_form")->nullable();
            $table->string("path_anket_form")->nullable();
            $table->string("path_olcek_izinleri_form")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forms');
    }
};
