<div class="flex gap-6 mb-6 border-b border-gray-200">
  <a href="{{ route('laraauth.login') }}"
     class="pb-3 text-sm font-semibold transition-colors {{ $active === 'login' ? 'tab-active' : 'text-gray-400 hover:text-gray-600' }}">
    Iniciar sesión
  </a>
  <a href="{{ route('laraauth.register') }}"
     class="pb-3 text-sm font-semibold transition-colors {{ $active === 'register' ? 'tab-active' : 'text-gray-400 hover:text-gray-600' }}">
    Crear cuenta
  </a>
</div>
