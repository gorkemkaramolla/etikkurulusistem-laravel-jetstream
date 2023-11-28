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
            $table->enum('application_semester', ["güz","bahar"]);//başvuru dönemi
            $table->string('temel_alan_bilgisi',50);//Temel alan bilgisi /Basic domain knowledge
            $table->smallInteger('academic_year');//akademik yıl
            $table->string('application_type',50);//başvuru türü
            $table->string('work_qualification',50);//çalışma_niteliği
            $table->string('research_type',50);//araştırma türü
            $table->string('institution_permission',50);//kurum izinleri
            $table->date('research_start_date');//araştırma başlangıç tarihi
            $table->date('research_end_date');//araştırma bitiş tarihi
                        
        });
    }

};
