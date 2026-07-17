<?php

namespace Moimenta84\LaraAuth\Models;

use Illuminate\Database\Eloquent\Model;

class OTPLog extends Model
{
  protected $fillable = [
    'user_id',
    'action',
    'ip',
    'success',
  ];

  protected function casts(): array
  {
    return [
      'success' => 'boolean',
    ];
  }

  public function user()
  {
    return $this->belongsTo(config('laraauth.user_model'));
  }
}
