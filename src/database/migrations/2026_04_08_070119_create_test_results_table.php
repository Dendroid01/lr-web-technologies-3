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
        Schema::create('test_results', function (Blueprint $table) {
            $table->id();

            $table->string('fullname');
            $table->string('group_name');

            $table->json('answers');
            $table->json('results');

            $table->unsignedTinyInteger('total');
            $table->unsignedTinyInteger('correct');

            $table->timestamps();

            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('test_results');
    }
};
