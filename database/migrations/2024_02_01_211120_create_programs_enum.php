<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('programs_enum', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string("name");
            $table->json("fields");
        });

        // Insert default values into the fields column
        $programs = config('program_enums');
        DB::table('programs_enum')->insert([
            "name" => "programs",
            'fields' => json_encode($programs),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programs_enum');
    }
};
