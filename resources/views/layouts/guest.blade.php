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
  <style>
    *,*::before,*::after{margin:0;padding:0;box-sizing:border-box}
    html{font-family:'Figtree',system-ui,sans-serif;-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}
    body{display:flex;min-height:100svh;background:#f9fafb;color:#111827}
    ::selection{background:rgba(99,102,241,0.15);color:#111827}
    .hero-gradient{background:linear-gradient(160deg,#0D1117 0%,#111827 50%,#1a1f2e 100%)}
    .card{background:#fff;border-radius:1rem;box-shadow:0 1px 3px rgba(0,0,0,0.04),0 8px 32px rgba(0,0,0,0.08)}
    .tab-active{color:#4F46E5;border-bottom:2px solid #4F46E5;margin-bottom:-1px}
    .otp-input{width:48px;height:56px;text-align:center;font-size:1.5rem;font-weight:700;border:2px solid #d1d5db;border-radius:0.75rem;outline:none;transition:border-color 0.15s,box-shadow 0.15s;caret-color:#4F46E5}
    .otp-input:focus{border-color:#4F46E5;box-shadow:0 0 0 3px rgba(79,70,229,0.15)}
    .otp-input.filled{border-color:#4F46E5;background:#f5f3ff}
    .fade-in{animation:fadeIn 0.25s ease-out}
    @keyframes fadeIn{from{opacity:0;transform:translateY(8px)}to{opacity:1;transform:translateY(0)}}
    .shimmer{background:linear-gradient(90deg,#f0f0f0 25%,#e0e0e0 50%,#f0f0f0 75%);background-size:200% 100%;animation:shimmer 1.5s infinite}
    @keyframes shimmer{0%{background-position:-200% 0}100%{background-position:200% 0}}
    .lg\\:flex{display:none}@media(min-width:1024px){.lg\\:flex{display:flex}}
    .lg\\:w-1\\/2{width:50%}
    .flex-1{flex:1}
    .w-full{width:100%}
    .max-w-md{max-width:28rem}
    .min-h-screen{min-height:100svh}
    .flex{display:flex}
    .inline-flex{display:inline-flex}
    .items-center{align-items:center}
    .justify-center{justify-content:center}
    .justify-between{justify-content:space-between}
    .flex-col{flex-direction:column}
    .gap-1{gap:0.25rem}
    .gap-1\\.5{gap:0.375rem}
    .gap-2{gap:0.5rem}
    .gap-3{gap:0.75rem}
    .gap-4{gap:1rem}
    .gap-6{gap:1.5rem}
    .p-8{padding:2rem}
    .p-12{padding:3rem}
    .px-5{padding-left:1.25rem;padding-right:1.25rem}
    .px-8{padding-left:2rem;padding-right:2rem}
    .px-3{padding-left:0.75rem;padding-right:0.75rem}
    .py-3{padding-top:0.75rem;padding-bottom:0.75rem}
    .py-12{padding-top:3rem;padding-bottom:3rem}
    .py-\\[10px\\]{padding-top:10px;padding-bottom:10px}
    .pb-2\\.5{padding-bottom:0.625rem}
    .mb-2{margin-bottom:0.5rem}
    .mb-4{margin-bottom:1rem}
    .mb-6{margin-bottom:1.5rem}
    .mb-8{margin-bottom:2rem}
    .mb-10{margin-bottom:2.5rem}
    .mt-1{margin-top:0.25rem}
    .mt-2{margin-top:0.5rem}
    .mt-3{margin-top:0.75rem}
    .mt-4{margin-top:1rem}
    .mt-6{margin-top:1.5rem}
    .mt-8{margin-top:2rem}
    .-mb-px{margin-bottom:-1px}
    .mx-auto{margin-left:auto;margin-right:auto}
    .text-white{color:#fff}
    .text-gray-400{color:#9ca3af}
    .text-gray-500{color:#6b7280}
    .text-gray-600{color:#4b5563}
    .text-gray-700{color:#374151}
    .text-gray-900{color:#111827}
    .text-indigo-400{color:#818cf8}
    .text-indigo-500{color:#6366f1}
    .text-indigo-600{color:#4f46e5}
    .bg-gray-50{background-color:#f9fafb}
    .bg-gray-100{background-color:#f3f4f6}
    .bg-indigo-500{background-color:#6366f1}
    .bg-white\\/5{background-color:rgba(255,255,255,0.05)}
    .rounded-lg{border-radius:0.5rem}
    .rounded-full{border-radius:9999px}
    .text-xs{font-size:0.75rem;line-height:1rem}
    .text-sm{font-size:0.875rem;line-height:1.25rem}
    .text-lg{font-size:1.125rem;line-height:1.75rem}
    .text-3xl{font-size:1.875rem;line-height:2.25rem}
    .text-4xl{font-size:2.25rem;line-height:2.5rem}
    .font-medium{font-weight:500}
    .font-semibold{font-weight:600}
    .font-bold{font-weight:700}
    .font-black{font-weight:900}
    .tracking-tight{letter-spacing:-0.025em}
    .leading-tight{line-height:1.25}
    .leading-relaxed{line-height:1.625}
    .text-balance{text-wrap:balance}
    .overflow-hidden{overflow:hidden}
    .relative{position:relative}
    .absolute{position:absolute}
    .inset-0{top:0;right:0;bottom:0;left:0}
    .top-0{top:0}
    .right-0{right:0}
    .bottom-0{bottom:0}
    .left-0{left:0}
    .pointer-events-none{pointer-events:none}
    .hidden{display:none}
    .block{display:block}
    .border{border:1px solid #e5e7eb}
    .border-b{border-bottom:1px solid #e5e7eb}
    .border-t{border-top:1px solid #e5e7eb}
    .border-white\\/10{border-color:rgba(255,255,255,0.1)}
    a{color:inherit;text-decoration:none}
    .shrink-0{flex-shrink:0}
    .text-center{text-align:center}
    button{cursor:pointer}
    .transition-colors{transition:color 0.15s,background-color 0.15s,border-color 0.15s}
    .transition-all{transition:all 0.15s}
    .duration-200{transition-duration:0.2s}
    @media(min-width:768px){.md\\:px-8{padding-left:2rem;padding-right:2rem}}
  </style>
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

    <div class="relative flex flex-col justify-center flex-1">
      @yield('left-panel')

      <div class="mt-6 inline-flex items-center gap-1.5 px-3 py-1 bg-white/5 text-gray-400 rounded-full text-xs border border-white/10">
        <span>OTP</span>
        <span class="text-white/20">·</span>
        <span>Social Login</span>
        <span class="text-white/20">·</span>
        <span>Rate Limiting</span>
      </div>
    </div>

    <p class="relative text-xs text-gray-500">&copy; {{ date('Y') }} LaraAuth</p>
  </div>

  <!-- Right panel -->
  <div class="flex-1 bg-gray-50 flex flex-col items-center justify-center px-5 md:px-8 py-12">
    <div class="lg:hidden flex items-center gap-2 mb-10">
      <div class="h-8 w-8 bg-indigo-500 rounded-lg flex items-center justify-center text-white font-bold text-sm">L</div>
      <span class="text-gray-900 font-bold text-lg">Lara<span class="text-indigo-500">Auth</span></span>
    </div>

    <div class="w-full max-w-md">
      @yield('auth-content')
    </div>

    <p class="text-center text-xs text-gray-400 mt-8">&copy; {{ date('Y') }} LaraAuth &middot; Starter Kit</p>
  </div>

  @stack('scripts')
</body>
</html>
