@extends('laraauth::layouts.guest')

@section('title', 'Restablecer contraseña — LaraAuth')

@section('left-panel')
  <h2 class="text-4xl xl:text-5xl font-black text-white leading-tight tracking-tight text-balance">
    ¿Olvidaste tu<br>
    <span class="text-indigo-400 font-black">contraseña?</span>
  </h2>
  <p class="text-gray-400 mt-5 text-lg leading-relaxed max-w-sm">
    Te enviaremos un enlace para restablecerla. Recibirás un email en pocos minutos.
  </p>
@stop

@section('auth-content')
  <div class="card p-8 shadow-premium fade-in">
    <div class="text-center mb-6">
      <div class="w-14 h-14 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-4">
        <svg class="w-7 h-7 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
        </svg>
      </div>
      <h3 class="text-lg font-bold text-gray-900">Restablecer contraseña</h3>
      <p class="text-sm text-gray-500 mt-1">Introduce tu email y te enviaremos un enlace</p>
    </div>

    @if ($errors->any())
      <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg text-sm text-red-600 text-center">
        {{ $errors->first() }}
      </div>
    @endif

    @if (session('status'))
      <div class="mb-4 p-3 bg-green-50 border border-green-200 rounded-lg text-sm text-green-600 text-center">
        {{ session('status') }}
      </div>
    @endif

    <form method="POST" action="{{ route('laraauth.password.email') }}">
      @csrf

      <div class="mb-6">
        <label class="block font-medium text-sm text-gray-700">Email</label>
        <input type="email" name="email" value="{{ old('email') }}" required autofocus
               class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm px-3 py-2 border text-sm"
               placeholder="tu@email.com">
      </div>

      <button type="submit"
              class="w-full inline-flex items-center justify-center px-4 py-2.5 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition ease-in-out duration-150">
        Enviar enlace
      </button>
    </form>

    <a href="{{ route('laraauth.login') }}"
       class="block w-full mt-3 text-sm text-center text-gray-500 hover:text-gray-700 transition-colors">
      &larr; Volver a iniciar sesión
    </a>
  </div>
@stop
