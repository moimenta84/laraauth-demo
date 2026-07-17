<?php

namespace Moimenta84\LaraAuth\Models;

use Illuminate\Database\Eloquent\Model;

class SocialLink extends Model
{
  protected $fillable = [
    'user_id',
    'provider',
    'provider_id',
    'avatar_url',
    'metadata',
  ];

  protected function casts(): array
  {
    return [
      'metadata' => 'json',
    ];
  }

  public function user()
  {
    return $this->belongsTo(config('laraauth.user_model'));
  }
}
