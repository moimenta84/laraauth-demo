<?php

namespace Moimenta84\LaraAuth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ForgotPasswordRequest extends FormRequest
{
  public function authorize(): bool
  {
    return true;
  }

  public function rules(): array
  {
    return [
      'email' => ['required', 'string', 'email', 'max:255', 'exists:users,email'],
    ];
  }

  public function messages(): array
  {
    return [
      'email.exists' => __('laraauth::auth.email_not_found'),
    ];
  }
}
