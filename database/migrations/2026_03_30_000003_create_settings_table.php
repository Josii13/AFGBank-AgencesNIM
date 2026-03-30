<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // Valeurs par défaut
        $defaults = [
            'mail_to'           => '',
            'mail_from_address' => '',
            'mail_from_name'    => 'AFG Bank',
            'smtp_host'         => '',
            'smtp_port'         => '587',
            'smtp_username'     => '',
            'smtp_password'     => '',
            'smtp_encryption'   => 'tls',
        ];

        foreach ($defaults as $key => $value) {
            DB::table('settings')->insert([
                'key'        => $key,
                'value'      => $value,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
