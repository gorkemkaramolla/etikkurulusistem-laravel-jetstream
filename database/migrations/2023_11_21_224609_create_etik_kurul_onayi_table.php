<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEtikKurulOnayiTable extends Migration
{
    public function up()
    {
        Schema::create('etik_kurul_onayi', function (Blueprint $table) {
            $table->id();
            $table->uuid('form_id');
            $table->foreign('form_id')->references('id')->on('forms')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->enum('onay_durumu', ["bekleme", "duzeltme", 'onaylandi', 'reddedildi']);
            $table->text('decide_reason')->nullable()->default(null);






            $table->timestamps();
        });
    }
}
