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
        Schema::create("application_informations", function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('form_id');
            $table->foreign('form_id')->references('id')->on('forms')->onDelete('cascade');
            $table->enum('application_semester', ["güz", "bahar"]); //başvuru dönemi
            $table->text('temel_alan_bilgisi'); //Temel alan bilgisi /Basic domain knowledge
            $table->smallInteger('academic_year'); //akademik yıl
            $table->text('application_type'); //başvuru türü
            $table->text('work_qualification'); //çalışma_niteliği
            $table->text('research_type'); //araştırma türü
            $table->text('institution_permission'); //kurum izinleri
            $table->date('research_start_date'); //araştırma başlangıç tarihi
            $table->date('research_end_date'); //araştırma bitiş tarihi
            $table->timestamps();
        });
    }
};