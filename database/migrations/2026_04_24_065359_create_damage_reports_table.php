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
        Schema::create('damage_reports', function (Blueprint $table) {
            $table->id();

            // data utama report
            $table->string('equipment_name');
            $table->string('operator_name');

            // tanggal laporan dari mobile
            $table->date('report_date')->nullable();

            // detail kerusakan
            $table->text('description')->nullable();

            // status approval admin (dashboard web)
            $table->enum('status', ['pending', 'approved', 'rejected'])
                  ->default('pending');

            // kalau ada upload foto dari mobile
            $table->string('image')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('damage_reports');
    }
};