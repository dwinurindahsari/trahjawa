<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('family_members', function (Blueprint $table) {
            // tabel member
            $table->id();
            $table->string('name');
            $table->date('birth_date')->nullable();
            $table->enum('gender', ['Laki-Laki', 'Perempuan']);
            $table->integer('urutan');
            $table->string('address')->nullable();
            $table->unsignedBigInteger('tree_id');
            $table->unsignedBigInteger('parent_id')->nullable(); 
            $table->timestamps();
            $table->string('photo')->nullable();
            
            // tabel pasangan
            $table->string('partner_name')->nullable();
            $table->date('partner_birth_date')->nullable();
            $table->enum('partner_gender', ['Laki-Laki', 'Perempuan'])->nullable();;
            $table->string('partner_address')->nullable();
            $table->string('partner_photo')->nullable();

            $table->foreign('tree_id')->references('id')->on('trees')->onDelete('cascade');
            $table->foreign('parent_id')->references('id')->on('family_members')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('family_members');
    }
};

