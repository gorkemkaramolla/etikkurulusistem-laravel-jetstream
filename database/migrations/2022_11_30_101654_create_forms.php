<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use PharIo\Manifest\Email;
use Illuminate\Support\Facades\Config;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('forms', function (Blueprint $table) {
            $table->uuid('id')->primary(); // Changed this line

            $table->foreignId('user_id')->nullable()->constrained();

            $table->timestamps();
            $table->softDeletes(); // Add this line
            $table->timestamp('conclusion_date')->nullable();
            //researcher
            $table->string("name", 255); //isim
            $table->string("lastname", 255); //soyisim
            $table->string("gsm", 10); //telefon
            //researcher
            $table->string("advisor", 255); //danışman
            $table->string('email');
            // Change 'ana_bilim_dali' to enum with provided values
            $table->text('ana_bilim_dali');

            $table->text('program');

            $table->string("student_no", 11); //ogrenci_no

            $table->string('stage')->default('sekreterlik'); // durum
            $table->text('decide_reason')->nullable()->default(null);
            $table->string('anket_path')->nullable()->default(null);
            $table->string('onam_path')->nullable()->default(null);
            $table->string('kurum_izinleri_path')->nullable()->default(null);
            //application
            $table->text('application_semester'); //başvuru dönemi
            $table->text('temel_alan_bilgisi'); //Temel alan bilgisi /Basic domain knowledge
            $table->smallInteger('academic_year'); //akademik yıl
            $table->text('application_type'); //başvuru türü
            $table->text('work_qualification'); //çalışma_niteliği
            $table->text('research_type'); //araştırma türü
            $table->text('institution_permission'); //kurum izinleri
            $table->date('research_start_date'); //araştırma başlangıç tarihi
            $table->date('research_end_date'); //araştırma bitiş tarihi

            //research
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
            $table->boolean('is_modified')->default(false);
        });
    }
};
