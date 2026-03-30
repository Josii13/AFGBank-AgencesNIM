<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('nom_prenoms');
            $table->string('telephone');
            $table->string('email');
            $table->enum('est_client', ['oui_reactiver', 'non']);
            $table->string('numero_compte')->nullable();
            $table->enum('souhaite_contact', ['oui', 'non']);
            $table->enum('statut', ['nouveau', 'en_cours', 'traite'])->default('nouveau');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
