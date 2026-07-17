<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', config('app.name', 'LaraAuth')) — Autenticación</title>
  <meta name="theme-color" content="#111827">
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet"/>
  <script src="https://cdn.tailwindcss.com"></script>
  @stack('styles')
</head>
<body class="font-sans antialiased flex min-h-screen">

  <!-- Left panel -->
  <div class="hidden lg:flex lg:w-1/2 hero-gradient relative overflow-hidden flex-col justify-between p-12">
    <div class="absolute inset-0 pointer-events-none" aria-hidden="true">
      <div class="absolute top-0 right-0 w-80 h-80 rounded-full opacity-10"
           style="background: radial-gradient(circle, #92400E, transparent 70%)"></div>
      <div class="absolute bottom-0 left-0 w-60 h-60 rounded-full opacity-[0.06]"
           style="background: radial-gradient(circle, #4F46E5, transparent 70%)"></div>
      <div class="absolute inset-0 opacity-[0.03]"
           style="background-image: linear-gradient(rgba(255,255,255,0.4) 1px, transparent 1px),
                                    linear-gradient(90deg, rgba(255,255,255,0.4) 1px, transparent 1px);
                   background-size: 48px 48px;"></div>
    </div>

    <div class="relative flex items-center gap-3">
      <div class="h-10 w-10 bg-indigo-500 rounded-lg flex items-center justify-center text-white font-bold text-lg">L</div>
      <span class="text-white font-bold text-xl tracking-tight">Lara<span class="text-indigo-400">Auth</span></span>
    </div>

    <div class="relative">
      @yield('left-panel')
    </div>

    <p class="relative text-xs text-gray-600">&copy; {{ date('Y') }} LaraAuth</p>
  </div>

  <!-- Right panel -->
  <div class="flex-1 bg-gray-50 flex flex-col items-center justify-center px-6 py-12">
    <div class="lg:hidden flex items-center gap-2 mb-10">
      <div class="h-8 w-8 bg-indigo-500 rounded-lg flex items-center justify-center text-white font-bold text-sm">L</div>
      <span class="text-gray-900 font-bold text-lg">Lara<span class="text-indigo-500">Auth</span></span>
    </div>

    <div class="w-full max-w-sm">
      @yield('auth-content')
    </div>

    <p class="text-center text-xs text-gray-400 mt-6">&copy; {{ date('Y') }} LaraAuth &middot; Starter Kit</p>
  </div>

  @stack('scripts')
</body>
</html>
