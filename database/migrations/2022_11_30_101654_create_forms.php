<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use PharIo\Manifest\Email;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('forms', function (Blueprint $table) {
            $table->id();
            $table->string('document_number'); //evrak no
            $table->string('stage')->default('sekreterlik'); // durum
            $table->text('decide_reason')->nullable()->default(null);



            $table->timestamps();
        });
    }
};
