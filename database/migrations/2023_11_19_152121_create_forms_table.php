<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use PharIo\Manifest\Email;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('forms', function (Blueprint $table) {
            $table->id();
            $table->string("name", 32);
            $table->string('email')->unique();
            $table->string("lastname", 32);
            $table->string("ogrenci_no", 11)->unique();
            $table->string("path_basvuru_form", 120);
            $table->string("path_gonullu_onam_form", 120);
            $table->string("path_anket_form", 120);
            $table->string("path_olcek_izinleri_form", 120);
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
