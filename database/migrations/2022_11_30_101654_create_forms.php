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
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained();
            $table->timestamps();

            //researcher
            $table->string("name", 255); //isim
            $table->string("lastname", 255); //soyisim
            $table->string("gsm", 10); //telefon
            //researcher
            $table->string("advisor", 255); //danışman
            $table->string('email');

            // Change 'ana_bilim_dali' to enum with provided values
            $table->enum('ana_bilim_dali', Config::get('enums'));

            $table->enum('program', ['HAREKET VE ANTRENMAN BİLİMLERİ', 'HAREKET VE ANTRENMAN BİLİMLERİ (DOKTORA)', 'BESLENME VE DİYETETİK', 'BİLGİ TEKNOLOJİLERİ', 'BİLGİSAYAR MÜHENDİSLİĞİ', 'MÜHENDİSLİK YÖNETİMİ', 'FİNANS VE BANKACILIK', 'FİNANS VE BANKACILIK (DOKTORA)', 'FİNANS VE BANKACILIK (UZAKTAN ÖĞRETİM)', 'KAYROPRAKTİK', 'GASTRONOMİ VE MUTFAK SANATLARI', 'BİYOTEKNOLOJİ', 'REKLAMCILIK VE MARKA İLETİŞİMİ', 'STRATEJİK PAZARLAMA VE MARKA YÖNETİMİ', 'İNŞAAT MÜHENDİSLİĞİ', 'İNSAN KAYNAKLARI YÖNETİMİ', 'İŞLETME YÖNETİMİ', 'İŞLETME YÖNETİMİ (DOKTORA)', 'İŞLETME YÖNETİMİ (İNGİLİZCE)', 'İŞLETME YÖNETİMİ (İNGİLİZCE) (DOKTORA)', 'İŞLETME YÖNETİMİ (UZAKTAN ÖĞRETİM)', 'ULUSLARARASI İŞLETMECİLİK', 'MİMARİ TASARIM', 'MUHASEBE VE DENETİM', 'MUHASEBE VE DENETİM (UZAKTAN EĞİTİM)', 'ULUSLARARASI FİNANSAL RAPORLAMA VE DENETİM', 'MÜZİK VE SAHNE SANATLARI', 'KLİNİK PSİKOLOJİ', 'PSİKOLOJİ', 'RADYO TELEVİZYON VE SİNEMA', 'SAĞLIK YÖNETİMİ', 'SİYASET BİLİMİ VE ULUSLARARASI İLİŞKİLER', 'SİYASET BİLİMİ VE ULUSLARARASI İLİŞKİLER (DOKTORA)', 'YEREL YÖNETİMLER (TEZLİ)', 'SPOR YÖNETİCİLİĞİ', 'TEKSTİL VE MODA TASARIMI', 'ULUSLARARASI TİCARET VE FİNANSMAN', 'YAPAY ZEKA MÜHENDİSLİĞİ', 'YENİ MEDYA VE GAZETECİLİK', 'BÜYÜK VERİ ANALİTİĞİ VE YÖNETİMİ']);

            $table->string("student_no", 11); //ogrenci_no

            $table->string('stage')->default('sekreterlik'); // durum
            $table->text('decide_reason')->nullable()->default(null);
            $table->string('anket_path')->nullable()->default(null);
            $table->string('onam_path')->nullable()->default(null);
            $table->string('kurum_izinleri_path')->nullable()->default(null);
            //application
            $table->enum('application_semester', ["güz", "bahar"]); //başvuru dönemi
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
