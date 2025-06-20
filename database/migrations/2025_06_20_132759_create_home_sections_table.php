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
        Schema::create('home_sections', function (Blueprint $table) {
            $table->id();
            $table->string('main_title');            // Título principal
            $table->text('main_description');        // Descrição principal
            $table->string('feature_one_title');
            $table->text('feature_one_description');
            $table->string('feature_two_title');
            $table->text('feature_two_description');
            $table->string('feature_three_title');
            $table->text('feature_three_description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_sections');
    }
};
