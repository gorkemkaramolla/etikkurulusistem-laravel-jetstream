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
        Schema::create('researcher_informations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('form_id');
            $table->foreign('form_id')->references('id')->on('forms')->onDelete('cascade');
            $table->string("name", 32);//isim
            $table->string("lastname", 32);//soyisim
            $table->string("advisor", 32);//danışman
            $table->string("gsm",10)->unique();//telefon
            $table->string('email')->unique();
            $table->string('major',100);//anabilim dalı
            $table->string('department',100);//program
            $table->string("student_no", 11)->unique();//ogrenci_no
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('arastirmaci_bilgileri');
    }
};
