<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', config('app.name', 'LaraAuth')) — Autenticación</title>
  <meta name="theme-color" content="#111827">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet"/>
  <script src="https://cdn.tailwindcss.com"></script>
  @stack('styles')
  <style>
    *,*::before,*::after{margin:0;padding:0;box-sizing:border-box}
    html{font-family:'Figtree',system-ui,sans-serif;-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}
    body{display:flex;min-height:100svh;background:#f9fafb;color:#111827}
    ::selection{background:rgba(99,102,241,0.15);color:#111827}
    .card{background:#fff;border-radius:1rem;box-shadow:0 1px 3px rgba(0,0,0,0.04),0 8px 32px rgba(0,0,0,0.08)}
    .tab-active{color:#4F46E5;border-bottom:2px solid #4F46E5;margin-bottom:-1px}
    .otp-input{width:48px;height:56px;text-align:center;font-size:1.5rem;font-weight:700;border:2px solid #d1d5db;border-radius:0.75rem;outline:none;transition:border-color 0.15s,box-shadow 0.15s;caret-color:#4F46E5}
    .otp-input:focus{border-color:#4F46E5;box-shadow:0 0 0 3px rgba(79,70,229,0.15)}
    .otp-input.filled{border-color:#4F46E5;background:#f5f3ff}
    .fade-in{animation:fadeIn 0.25s ease-out}
    @keyframes fadeIn{from{opacity:0;transform:translateY(8px)}to{opacity:1;transform:translateY(0)}}
  </style>
</head>
<body class="font-sans antialiased flex min-h-screen">
  @yield('content')
  @stack('scripts')
</body>
</html>
