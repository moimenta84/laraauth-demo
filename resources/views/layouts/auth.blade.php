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
    .hero-gradient {
      background: linear-gradient(160deg, #0D1117 0%, #111827 50%, #1a1f2e 100%);
    }
    .card {
      background: #fff;
      border-radius: 1rem;
      box-shadow: 0 2px 8px 0 rgba(0,0,0,0.08), 0 0 0 1px rgba(0,0,0,0.06);
      transition: all 0.3s;
    }
    .shadow-premium {
      box-shadow: 0 20px 60px -12px rgba(0,0,0,0.3);
    }
    body { font-family: 'Figtree', sans-serif; }
    .tab-active {
      color: #4F46E5;
      border-bottom: 2px solid #4F46E5;
    }
    .otp-input {
      width: 48px;
      height: 56px;
      text-align: center;
      font-size: 1.5rem;
      font-weight: 700;
      border: 2px solid #d1d5db;
      border-radius: 0.75rem;
      outline: none;
      transition: all 0.15s;
      caret-color: #4F46E5;
    }
    .otp-input:focus {
      border-color: #4F46E5;
      box-shadow: 0 0 0 3px rgba(79,70,229,0.15);
    }
    .otp-input.filled {
      border-color: #4F46E5;
      background: #f5f3ff;
    }
    .fade-in {
      animation: fadeIn 0.25s ease-out;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(8px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .shimmer {
      background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
      background-size: 200% 100%;
      animation: shimmer 1.5s infinite;
    }
    @keyframes shimmer {
      0% { background-position: -200% 0; }
      100% { background-position: 200% 0; }
    }
  </style>
</head>
<body class="font-sans antialiased flex min-h-screen">
  @yield('content')
  @stack('scripts')
</body>
</html>
