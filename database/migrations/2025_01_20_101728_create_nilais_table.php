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
        Schema::create('nilais', function (Blueprint $table) {
            $table->id();
            $table->decimal('sem_1', 3, 2)->nullable();
            $table->decimal('sem_2', 3, 2)->nullable();
            $table->decimal('sem_3', 3, 2)->nullable();
            $table->foreignId('mahasiswa_id')->unique()->constrained();
            // $table->foreignId('mahasiswa_id')->unique()->constrained()
            // ->onDelete('cascade');
            // $table->foreignId('mahasiswa_id')->unique()->constrained()
            //       ->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilais');
    }
};
