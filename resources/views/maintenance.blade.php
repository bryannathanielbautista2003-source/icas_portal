<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Under Maintenance — ICAS Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        @keyframes float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-12px)} }
        @keyframes pulse-ring { 0%{opacity:.6;transform:scale(1)} 100%{opacity:0;transform:scale(1.6)} }
        .float { animation: float 4s ease-in-out infinite; }
        .pulse-ring { animation: pulse-ring 2.5s ease-out infinite; }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 flex items-center justify-center p-6">

    {{-- Background orbs --}}
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-48 -left-48 w-96 h-96 rounded-full bg-green-600/10 blur-3xl"></div>
        <div class="absolute -bottom-48 -right-48 w-96 h-96 rounded-full bg-emerald-500/10 blur-3xl"></div>
    </div>

    <div class="relative max-w-lg w-full text-center">
        {{-- Pulsing icon --}}
        <div class="relative inline-flex items-center justify-center mb-8">
            <span class="pulse-ring absolute h-32 w-32 rounded-full bg-amber-500/20"></span>
            <span class="pulse-ring absolute h-32 w-32 rounded-full bg-amber-500/10" style="animation-delay:.6s"></span>
            <div class="relative h-28 w-28 rounded-full bg-gradient-to-br from-amber-400 to-orange-500 shadow-2xl flex items-center justify-center float">
                <svg class="w-14 h-14 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
            </div>
        </div>

        {{-- Text --}}
        <h1 class="text-4xl font-extrabold text-white mb-3 tracking-tight">System Under Maintenance</h1>
        <p class="text-slate-400 text-lg font-medium mb-2">We're currently performing scheduled maintenance.</p>

        @php $reason = \App\Models\SystemSetting::where('setting_key','maintenance_reason')->value('setting_value'); @endphp
        @if($reason)
            <div class="mt-4 rounded-2xl border border-amber-500/30 bg-amber-500/10 px-6 py-4 inline-block">
                <p class="text-amber-300 text-sm font-semibold">{{ $reason }}</p>
            </div>
        @endif

        <p class="mt-6 text-slate-500 text-sm">We'll be back shortly. Thank you for your patience.</p>

        <div class="mt-8 rounded-2xl bg-white/5 border border-white/10 p-4 inline-flex items-center gap-3">
            <div class="h-2.5 w-2.5 rounded-full bg-amber-400 animate-pulse"></div>
            <p class="text-slate-300 text-sm font-semibold">Maintenance in progress</p>
        </div>

        <p class="mt-6 text-slate-600 text-xs">
            Are you an administrator?
            <a href="{{ url('/login') }}" class="text-green-400 hover:text-green-300 underline underline-offset-4 transition">Log in here</a>
        </p>
    </div>
</body>
</html>
