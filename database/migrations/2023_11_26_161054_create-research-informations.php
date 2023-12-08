<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  
    public function up(): void
    {
        Schema::create("research_informations", function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('form_id');
            $table->foreign('form_id')->references('id')->on('forms')->onDelete('cascade');
            $table->string("research_title",100);//Araştırma başlığı
            $table->string("research_subject_purpose",255);//Konu ve amaç
            $table->string("research_unique_value",255);//Özgün değer
            $table->string("research_hypothesis",255);//Hipotezler
            $table->string("research_method",255);//Yöntem
            $table->string("research_universe",255);//Evren ve örneklem
            $table->string("research_forms",255);//Ölçek ve formlar
            $table->string("research_data_collection",255);//Verilerin toplanması ve analizi
            $table->string("research_restrictions",255);//Sınırlar ve kısıtlar
            $table->string("research_place_date",255);//Araştırma tarih ve yeri
            $table->string("research_literature_review",255);//Faydalanıcak kaynaklar
            $table->timestamps();

        });
    }


};
