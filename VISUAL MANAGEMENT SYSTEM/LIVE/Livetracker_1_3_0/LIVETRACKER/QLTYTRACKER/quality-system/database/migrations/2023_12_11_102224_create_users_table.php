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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->integer('EmployeeId')->unique();
            $table->string('Login', 50);
            $table->string('Password', 50);
            $table->string('Description', 255);
            $table->string('FirstName', 255);
            $table->string('LastName', 255);
            $table->boolean('IsActive');
            $table->boolean('IsAdmin');
            $table->boolean('IsQA');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
