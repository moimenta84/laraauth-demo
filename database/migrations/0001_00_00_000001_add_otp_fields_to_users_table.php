<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::table('users', function (Blueprint $table) {
      $table->string('otp_code', 6)->nullable();
      $table->timestamp('otp_expires_at')->nullable();
      $table->integer('otp_attempts')->default(0);
      $table->timestamp('otp_locked_until')->nullable();
      $table->string('phone')->nullable();
      $table->string('phone_country_code', 5)->nullable();
      $table->timestamp('phone_verified_at')->nullable();
      $table->string('auth_method')->default('email');
      $table->text('social_providers')->nullable();
    });
  }

  public function down(): void
  {
    Schema::table('users', function (Blueprint $table) {
      $table->dropColumn([
        'otp_code', 'otp_expires_at', 'otp_attempts', 'otp_locked_until',
        'phone', 'phone_country_code', 'phone_verified_at',
        'auth_method', 'social_providers',
      ]);
    });
  }
};
