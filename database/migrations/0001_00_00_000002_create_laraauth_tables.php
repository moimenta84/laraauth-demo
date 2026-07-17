<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::create('laraauth_otp_logs', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained()->cascadeOnDelete();
      $table->string('action'); // send, verify, resend
      $table->string('ip', 45)->nullable();
      $table->boolean('success')->default(true);
      $table->timestamps();
    });

    Schema::create('laraauth_social_links', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained()->cascadeOnDelete();
      $table->string('provider'); // google, facebook, github, linkedin
      $table->string('provider_id');
      $table->text('avatar_url')->nullable();
      $table->json('metadata')->nullable();
      $table->timestamps();
      $table->unique(['provider', 'provider_id']);
    });

    Schema::create('laraauth_trusted_devices', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained()->cascadeOnDelete();
      $table->string('device_identifier');
      $table->string('ip', 45)->nullable();
      $table->text('user_agent')->nullable();
      $table->timestamp('last_used_at');
      $table->timestamps();
      $table->index(['user_id', 'device_identifier']);
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('laraauth_trusted_devices');
    Schema::dropIfExists('laraauth_social_links');
    Schema::dropIfExists('laraauth_otp_logs');
  }
};
