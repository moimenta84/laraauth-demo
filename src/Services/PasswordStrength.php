<?php

namespace Moimenta84\LaraAuth\Services;

class PasswordStrength
{
  public function validate(string $password): array
  {
    $rules = config('laraauth.password_rules');
    $score = 0;
    $max = 4;
    $errors = [];

    // Length
    if (strlen($password) >= ($rules['min'] ?? 8)) {
      $score++;
    } else {
      $errors[] = "Mínimo {$rules['min']} caracteres";
    }

    // Mixed case
    if (($rules['mixed_case'] ?? true) && preg_match('/[A-Z]/', $password) && preg_match('/[a-z]/', $password)) {
      $score++;
    } elseif ($rules['mixed_case'] ?? true) {
      $errors[] = 'Debe contener mayúsculas y minúsculas';
    }

    // Numbers
    if (($rules['numbers'] ?? true) && preg_match('/[0-9]/', $password)) {
      $score++;
    } elseif ($rules['numbers'] ?? true) {
      $errors[] = 'Debe contener al menos un número';
    }

    // Symbols
    if (($rules['symbols'] ?? true) && preg_match('/[^A-Za-z0-9]/', $password)) {
      $score++;
    } elseif ($rules['symbols'] ?? true) {
      $errors[] = 'Debe contener al menos un símbolo';
    }

    $labels = ['', 'Débil', 'Regular', 'Buena', 'Fuerte'];

    return [
      'score' => $score,
      'max' => $max,
      'label' => $labels[$score] ?? '',
      'percent' => $max > 0 ? round(($score / $max) * 100) : 0,
      'valid' => $score >= 3,
      'errors' => $errors,
    ];
  }

  public function rules(): array
  {
    $rules = config('laraauth.password_rules');
    $validation = ['min:' . ($rules['min'] ?? 8)];

    if ($rules['mixed_case'] ?? true) {
      $validation[] = 'regex:/[A-Z]/';
      $validation[] = 'regex:/[a-z]/';
    }
    if ($rules['numbers'] ?? true) {
      $validation[] = 'regex:/[0-9]/';
    }
    if ($rules['symbols'] ?? true) {
      $validation[] = 'regex:/[^A-Za-z0-9]/';
    }

    return $validation;
  }
}
