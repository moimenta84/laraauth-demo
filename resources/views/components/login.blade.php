@extends('laraauth::layouts.guest')

@section('title', 'Iniciar sesión — LaraAuth')

@section('left-panel')
  <h2 class="text-4xl xl:text-5xl font-black text-white leading-tight tracking-tight text-balance">
    Sistema de autenticación<br>
    <span class="text-indigo-400 font-black">premium para Laravel.</span>
  </h2>
  <p class="text-gray-400 mt-5 text-lg leading-relaxed max-w-sm">
    Diseño moderno, split layout, formularios optimizados y componentes reutilizables.
  </p>
  <div class="flex flex-col gap-3 mt-8">
    <div class="flex items-center gap-3 text-gray-400 text-sm">
      <div class="w-5 h-5 rounded-full bg-indigo-400 flex items-center justify-center shrink-0">
        <svg class="h-3 w-3 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
        </svg>
      </div>
      6 vistas auth completas
    </div>
    <div class="flex items-center gap-3 text-gray-400 text-sm">
      <div class="w-5 h-5 rounded-full bg-indigo-400 flex items-center justify-center shrink-0">
        <svg class="h-3 w-3 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
        </svg>
      </div>
      18 componentes Blade
    </div>
    <div class="flex items-center gap-3 text-gray-400 text-sm">
      <div class="w-5 h-5 rounded-full bg-indigo-400 flex items-center justify-center shrink-0">
        <svg class="h-3 w-3 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
        </svg>
      </div>
      Rate limiting + validación OTP
    </div>
  </div>
@stop

@section('auth-content')
  @include('laraauth::components._tabs', ['active' => 'login'])

  <div class="card p-8 shadow-premium fade-in">
    <form method="POST" action="{{ route('laraauth.login') }}">
      @csrf

      @if ($errors->any())
        <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg text-sm text-red-600">
          {{ $errors->first() }}
        </div>
      @endif

      @if (session('status'))
        <div class="mb-4 p-3 bg-green-50 border border-green-200 rounded-lg text-sm text-green-600">
          {{ session('status') }}
        </div>
      @endif

      <div class="mb-4">
        <label class="block font-medium text-sm text-gray-700">Email</label>
        <input type="email" name="email" value="{{ old('email', 'demo@laraauth.dev') }}" required autofocus
               class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm px-3 py-2 border text-sm"
               placeholder="tu@email.com">
      </div>

      <div class="mb-6">
        <label class="block font-medium text-sm text-gray-700">Contraseña</label>
        <input type="password" name="password" required
               class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm px-3 py-2 border text-sm"
               placeholder="••••••••">
      </div>

      <div class="flex items-center justify-between mb-6">
        <label class="inline-flex items-center">
          <input type="checkbox" name="remember" checked
                 class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
          <span class="ms-2 text-sm text-gray-600">Recordar</span>
        </label>
        <a href="{{ route('laraauth.password.request') }}" class="text-sm text-indigo-600 hover:text-indigo-500">
          ¿Olvidaste tu contraseña?
        </a>
      </div>

      <button type="submit"
              class="w-full inline-flex items-center justify-center px-4 py-2.5 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
        Entrar
      </button>
    </form>

    @include('laraauth::components._social-buttons')
  </div>
@stop
