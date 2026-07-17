@extends('laraauth::layouts.guest')

@section('title', 'Crear cuenta — LaraAuth')

@section('left-panel')
  <h2 class="text-4xl xl:text-5xl font-black text-white leading-tight tracking-tight text-balance">
    Crea tu cuenta<br>
    <span class="text-indigo-400 font-black">en segundos.</span>
  </h2>
  <p class="text-gray-400 mt-5 text-lg leading-relaxed max-w-sm">
    Regístrate con email, verifica tu identidad con OTP y empieza a usar la plataforma.
  </p>
@stop

@section('auth-content')
  @include('laraauth::components._tabs', ['active' => 'register'])

  <div class="card p-8 shadow-premium fade-in">
    <form method="POST" action="{{ route('laraauth.register') }}" id="register-form">
      @csrf

      @if ($errors->any())
        <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg text-sm text-red-600">
          <ul class="list-disc list-inside">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <div class="mb-4">
        <label class="block font-medium text-sm text-gray-700">Nombre</label>
        <input type="text" name="name" value="{{ old('name') }}" required
               class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm px-3 py-2 border text-sm"
               placeholder="Tu nombre">
      </div>

      <div class="mb-4">
        <label class="block font-medium text-sm text-gray-700">Email</label>
        <input type="email" name="email" value="{{ old('email') }}" required
               class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm px-3 py-2 border text-sm"
               placeholder="tu@email.com">
      </div>

      <div class="mb-4">
        <label class="block font-medium text-sm text-gray-700">Teléfono</label>
        <div class="flex gap-2 mt-1">
          <select name="phone_country_code"
                  class="w-28 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm px-2 py-2 border text-sm bg-white">
            @foreach ($countryCodes as $c)
              <option value="{{ $c['code'] }}" @selected(old('phone_country_code') === $c['code'])>
                {{ $c['country'] }} {{ $c['code'] }}
              </option>
            @endforeach
          </select>
          <input type="text" name="phone" value="{{ old('phone') }}" required
                 class="flex-1 block border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm px-3 py-2 border text-sm"
                 placeholder="600 000 000">
        </div>
        <p class="text-xs text-gray-400 mt-1">Te enviaremos un código SMS para verificar</p>
      </div>

      <div class="mb-4">
        <label class="block font-medium text-sm text-gray-700">Contraseña</label>
        <input type="password" name="password" id="reg-password" required
               oninput="checkStrength(this.value)"
               class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm px-3 py-2 border text-sm"
               placeholder="••••••••">
        <div class="mt-2 flex gap-1" id="strength-bar">
          <div class="h-1 flex-1 rounded-full bg-gray-200"></div>
          <div class="h-1 flex-1 rounded-full bg-gray-200"></div>
          <div class="h-1 flex-1 rounded-full bg-gray-200"></div>
          <div class="h-1 flex-1 rounded-full bg-gray-200"></div>
        </div>
        <p class="text-xs text-gray-400 mt-1" id="strength-text">Mín. 8 caracteres, mayúscula, número y símbolo</p>
      </div>

      <div class="mb-6">
        <label class="block font-medium text-sm text-gray-700">Confirmar contraseña</label>
        <input type="password" name="password_confirmation" required
               class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm px-3 py-2 border text-sm"
               placeholder="••••••••">
      </div>

      <button type="submit"
              class="w-full inline-flex items-center justify-center px-4 py-2.5 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
        Crear cuenta
      </button>
    </form>

    @include('laraauth::components._social-buttons')
  </div>
@stop

@push('scripts')
<script>
  let debounceTimer;

  function checkStrength(val) {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(async () => {
      try {
        const res = await fetch('{{ route('laraauth.password.strength') }}', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
          },
          body: JSON.stringify({ password: val })
        });
        const data = await res.json();
        updateBar(data.score, data.max, data.label);
      } catch {
        updateBar(0, 4, '');
      }
    }, 300);
  }

  function updateBar(score, max, label) {
    const bar = document.getElementById('strength-bar');
    const text = document.getElementById('strength-text');
    const bars = bar.querySelectorAll('div');
    const colors = ['bg-gray-200', 'bg-red-400', 'bg-orange-400', 'bg-yellow-400', 'bg-green-400'];

    bars.forEach((b, i) => {
      b.className = 'h-1 flex-1 rounded-full ' + (i < score ? colors[score] : 'bg-gray-200');
    });

    text.textContent = label || 'Mín. 8 caracteres, mayúscula, número y símbolo';
  }
</script>
@endpush
