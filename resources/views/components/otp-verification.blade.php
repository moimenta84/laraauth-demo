@extends('laraauth::layouts.guest')

@section('title', 'Verificación OTP — LaraAuth')

@section('left-panel')
  <h2 class="text-4xl xl:text-5xl font-black text-white leading-tight tracking-tight text-balance">
    Verifica tu identidad<br>
    <span class="text-indigo-400 font-black">con OTP.</span>
  </h2>
  <p class="text-gray-400 mt-5 text-lg leading-relaxed max-w-sm">
    Hemos enviado un código de {{ config('laraauth.otp.digits', 6) }} dígitos a tu teléfono.
  </p>
@stop

@section('auth-content')
  <div class="card p-8 fade-in">
    <div class="text-center mb-6">
      <div class="w-14 h-14 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
        <svg class="w-7 h-7 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
        </svg>
      </div>
      <h3 class="text-lg font-bold text-gray-900">Verificación SMS</h3>
      <p class="text-sm text-gray-500 mt-1.5">
        Hemos enviado un código de {{ config('laraauth.otp.digits', 6) }} dígitos al
        <strong class="text-gray-700">{{ $phone }}</strong>
      </p>
    </div>

    @if ($errors->any())
      <div class="mb-6 p-3 bg-red-50 border border-red-200 rounded-lg text-sm text-red-600 text-center">
        {{ $errors->first() }}
      </div>
    @endif

    <form method="POST" action="{{ route('laraauth.otp.verify') }}" id="otp-form">
      @csrf

      <div class="flex justify-center gap-2 mb-6" id="otp-inputs">
        @for ($i = 0; $i < config('laraauth.otp.digits', 6); $i++)
          <input class="otp-input" type="text" name="digits[]" maxlength="1"
                 inputmode="numeric" pattern="[0-9]" {{ $i === 0 ? 'autofocus' : '' }}
                 oninput="otpMove(this, event)">
        @endfor
      </div>

      <input type="hidden" name="code" id="otp-hidden">

      <button type="submit" id="otp-btn"
              class="w-full inline-flex items-center justify-center px-4 py-[10px] bg-indigo-600 border border-transparent rounded-lg font-bold text-sm text-white hover:bg-indigo-700 active:bg-indigo-800 active:scale-[0.98] focus:outline-none focus:ring-[3px] focus:ring-indigo-600/20 transition-all duration-150">
        Verificar código
      </button>
    </form>

    <p class="text-center text-xs text-gray-500 mt-4">
      ¿No recibiste el código?
      <button type="button" onclick="resendOTP(this)" id="resend-btn"
              class="text-indigo-600 hover:text-indigo-500 font-medium transition-colors" @if(!$canResend) disabled @endif>
        @if ($canResend) Reenviar SMS @else Espera... @endif
      </button>
    </p>

    <div class="mt-4 flex justify-center">
      <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-gray-100 text-gray-500 rounded-full text-xs font-medium">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
        </svg>
        <span>{{ $phone }}</span>
      </span>
    </div>
  </div>
@stop

@push('scripts')
<script>
  function otpMove(el, e) {
    el.value = el.value.replace(/\D/g, '');
    el.classList.toggle('filled', el.value !== '');

    if (el.value && el.nextElementSibling) {
      el.nextElementSibling.focus();
    }

    if (e.inputType === 'deleteContentBackward' && !el.value && el.previousElementSibling) {
      el.previousElementSibling.focus();
      el.previousElementSibling.classList.remove('filled');
    }

    const values = Array.from(document.querySelectorAll('#otp-inputs input')).map(i => i.value).join('');
    document.getElementById('otp-hidden').value = values;

    if (values.length === {{ config('laraauth.otp.digits', 6) }}) {
      document.getElementById('otp-btn').focus();
    }
  }

  async function resendOTP(btn) {
    btn.disabled = true;
    btn.textContent = 'Enviando...';

    try {
      const res = await fetch('{{ route('laraauth.otp.send') }}', {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}',
          'Content-Type': 'application/json',
        }
      });

      if (!res.ok) {
        const data = await res.json();
        alert(data.message || 'Error al enviar el código');
        btn.disabled = false;
        btn.textContent = 'Reenviar SMS';
        return;
      }

      btn.textContent = 'Enviado';
      setTimeout(() => {
        btn.disabled = false;
        btn.textContent = 'Reenviar SMS';
      }, {{ $resendSeconds * 1000 }});
    } catch {
      btn.disabled = false;
      btn.textContent = 'Reenviar SMS';
    }
  }
</script>
@endpush
