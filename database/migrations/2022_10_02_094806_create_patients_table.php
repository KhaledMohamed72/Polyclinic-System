<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('clinic_id')->constrained('clinics')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('doctor_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('receptionist_id')->constrained('users')->cascadeOnDelete();
            $table->string('gender')->nullable();
            $table->integer('age')->nullable();
            $table->text('address')->nullable();
            $table->float('height')->nullable();
            $table->float('weight')->nullable();
            $table->text('blood_group')->nullable();
            $table->integer('blood_pressure')->nullable();
            $table->integer('pulse')->nullable();
            $table->text('allergy')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patients');
    }
};
