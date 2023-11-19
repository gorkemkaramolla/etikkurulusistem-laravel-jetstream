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
            $table->string("name");
            $table->string("tc_kimlik_no");
            $table->string("calisma_basligi");
            $table->string("calisma_programı");
            $table->string("path_gonullu_onam_form");
            $table->string("path_anket_form");
            $table->string("path_olcek_izinleri_form");
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
