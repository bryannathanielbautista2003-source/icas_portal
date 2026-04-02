<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title','Faculty Portal') | ICAS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-slate-50 h-screen overflow-hidden text-slate-900">
    @php
        $currentRoute = Route::currentRouteName();
        $navItems = [
            ['label' => 'Dashboard', 'routeName' => 'faculty.dashboard', 'route' => route('faculty.dashboard'), 'icon' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>'],
            ['label' => 'My Students', 'routeName' => 'faculty.students', 'route' => route('faculty.students'), 'icon' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>'],
            ['label' => 'Grade Management', 'routeName' => 'faculty.grades', 'route' => route('faculty.grades'), 'icon' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>'],
        ];
    @endphp

    <div class="h-screen flex flex-col md:flex-row" x-data="{ sidebarOpen: false }">
        <!-- Mobile Header -->
        <div class="md:hidden flex items-center justify-between bg-green-600 text-white p-4">
            <div class="flex items-center gap-3">
                @php
                    $faculty = auth()->user();
                    $initials = $faculty ? collect(explode(' ', trim($faculty->name)))->map(fn($segment) => strtoupper(substr($segment, 0, 1)))->join('') : 'F';
                @endphp
                <div class="h-10 w-10 rounded-xl bg-white/20 grid place-items-center text-white font-bold">{{ $initials }}</div>
                <span class="font-semibold">Faculty Portal</span>
            </div>
            <button @click="sidebarOpen = !sidebarOpen" class="p-2 bg-white/10 rounded-md focus:outline-none focus:ring-2 focus:ring-white">
                <svg x-show="!sidebarOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                <svg x-cloak x-show="sidebarOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <!-- Sidebar Overlay -->
        <div x-cloak x-show="sidebarOpen" @click="sidebarOpen = false" x-transition.opacity class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-40 md:hidden"></div>

        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-50 w-80 bg-green-600 px-6 py-8 flex flex-col justify-between transform transition-transform duration-300 md:relative md:translate-x-0 overflow-y-auto shadow-xl md:shadow-none">
            <div class="space-y-10">
                <div class="flex items-center gap-3">
                    <div class="h-14 w-14 rounded-3xl bg-white/20 grid place-items-center text-white text-2xl font-bold">{{ $initials }}</div>
                    <div>
                        <p class="text-base font-semibold text-white">Faculty Portal</p>
                        <p class="text-xs text-green-100">ICAS</p>
                    </div>
                </div>

                <nav class="space-y-2">
                    @foreach($navItems as $item)
                        <a href="{{ $item['route'] }}" class="flex items-center gap-3 rounded-3xl px-4 py-3 text-sm font-semibold transition {{ $currentRoute === $item['routeName'] ? 'bg-white/20 text-white shadow-sm' : 'text-green-100 hover:bg-white/10' }}">
                            <span class="text-lg">{!! $item['icon'] !!}</span>
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                </nav>
            </div>

            <div class="rounded-3xl bg-white/10 p-6">
                <div class="flex items-center gap-4">
                    <div class="h-12 w-12 rounded-full bg-white/20 grid place-items-center text-white text-sm font-semibold">{{ $initials }}</div>
                    <div>
                        <p class="text-sm font-semibold text-white">{{ $faculty->name ?? 'Faculty Member' }}</p>
                        <p class="text-xs text-green-100">{{ $faculty->email ?? 'faculty@school.edu' }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="mt-5">
                    @csrf
                    <button type="submit" class="w-full rounded-3xl bg-white px-4 py-3 text-sm font-semibold text-green-700 hover:bg-green-50 transition">Logout</button>
                </form>
            </div>
        </aside>

        <main class="flex-1 p-4 sm:p-6 md:p-8 w-full max-w-full overflow-y-auto">
            <header class="mb-8">
                <h1 class="text-4xl font-bold text-slate-900">Welcome, {{ $faculty->name ?? 'Faculty' }}!</h1>
                <p class="mt-3 text-slate-500">{{ $pageDescription ?? 'Faculty Dashboard Overview' }}</p>
            </header>

            @yield('content')
        </main>
    </div>
</body>
</html>