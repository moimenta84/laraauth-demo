@extends('laraauth::layouts.guest')

@section('title', 'Nueva contraseña — LaraAuth')

@section('left-panel')
  <h2 class="text-4xl xl:text-5xl font-black text-white leading-tight tracking-tight text-balance">
    Establece tu<br>
    <span class="text-indigo-400 font-black">nueva contraseña.</span>
  </h2>
  <p class="text-gray-400 mt-5 text-lg leading-relaxed max-w-sm">
    Elige una contraseña segura. Mínimo 8 caracteres, mayúscula, número y símbolo.
  </p>
@stop

@section('auth-content')
  <div class="card p-8 fade-in">
    <div class="text-center mb-6">
      <div class="w-14 h-14 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4">
        <svg class="w-7 h-7 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
        </svg>
      </div>
      <h3 class="text-lg font-bold text-gray-900">Nueva contraseña</h3>
      <p class="text-sm text-gray-500 mt-1.5">Introduce tu nueva contraseña</p>
    </div>

    @if ($errors->any())
      <div class="mb-6 p-3 bg-red-50 border border-red-200 rounded-lg text-sm text-red-600 text-center">
        {{ $errors->first() }}
      </div>
    @endif

    <form method="POST" action="{{ route('laraauth.password.update') }}">
      @csrf
      <input type="hidden" name="token" value="{{ $token }}">
      <input type="hidden" name="email" value="{{ $email }}">

      <div class="mb-4">
        <label class="block font-medium text-sm text-gray-700 mb-1.5">Nueva contraseña</label>
        <input type="password" name="password" required autofocus
               class="block w-full border-gray-200 hover:border-gray-300 focus:border-indigo-500 focus:ring-[3px] focus:ring-indigo-500/20 rounded-lg px-3 py-[10px] border text-sm transition-colors"
               placeholder="••••••••">
      </div>

      <div class="mb-6">
        <label class="block font-medium text-sm text-gray-700 mb-1.5">Confirmar contraseña</label>
        <input type="password" name="password_confirmation" required
               class="block w-full border-gray-200 hover:border-gray-300 focus:border-indigo-500 focus:ring-[3px] focus:ring-indigo-500/20 rounded-lg px-3 py-[10px] border text-sm transition-colors"
               placeholder="••••••••">
      </div>

      <button type="submit"
              class="w-full inline-flex items-center justify-center px-4 py-[10px] bg-gray-800 border border-transparent rounded-lg font-bold text-sm text-white hover:bg-gray-700 active:bg-gray-900 active:scale-[0.98] focus:outline-none focus:ring-[3px] focus:ring-gray-800/20 transition-all duration-150">
        Restablecer contraseña
      </button>
    </form>
  </div>
@stop
