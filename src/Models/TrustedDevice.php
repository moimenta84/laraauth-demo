<?php

namespace Moimenta84\LaraAuth\Models;

use Illuminate\Database\Eloquent\Model;

class TrustedDevice extends Model
{
  protected $fillable = [
    'user_id',
    'device_identifier',
    'ip',
    'user_agent',
    'last_used_at',
  ];

  protected function casts(): array
  {
    return [
      'last_used_at' => 'datetime',
    ];
  }

  public function user()
  {
    return $this->belongsTo(config('laraauth.user_model'));
  }
}
