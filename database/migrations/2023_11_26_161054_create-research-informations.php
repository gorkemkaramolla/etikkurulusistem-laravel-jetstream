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
            $table->text("research_title"); //Araştırma başlığı
            $table->text("research_subject_purpose"); //Konu ve amaç
            $table->text("research_unique_value"); //Özgün değer
            $table->text("research_hypothesis"); //Hipotezler
            $table->text("research_method"); //Yöntem
            $table->text("research_universe"); //Evren ve örneklem
            $table->text("research_forms"); //Ölçek ve formlar
            $table->text("research_data_collection"); //Verilerin toplanması ve analizi
            $table->text("research_restrictions"); //Sınırlar ve kısıtlar
            $table->text("research_place_date"); //Araştırma tarih ve yeri
            $table->text("research_literature_review"); //Faydalanıcak kaynaklar
            $table->timestamps();
        });
    }
};
