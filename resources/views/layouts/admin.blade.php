<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title','Admin Portal') | ICAS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-slate-50 h-screen overflow-hidden text-slate-900">
    @php
        $currentRoute = Route::currentRouteName();
        $navItems = [
            ['label' => 'Dashboard', 'routeName' => 'admin.dashboard', 'route' => route('admin.dashboard'), 'icon' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>'],
            ['label' => 'Grades', 'routeName' => 'admin.grades', 'route' => route('admin.grades'), 'icon' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path></svg>'],
            ['label' => 'Classrooms', 'routeName' => 'admin.classrooms', 'route' => route('admin.classrooms'), 'icon' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1v1H9V7zm5 0h1v1h-1V7zm-5 4h1v1H9v-1zm5 0h1v1h-1v-1zm-5 4h1v1H9v-1zm5 0h1v1h-1v-1z"></path></svg>'],
            ['label' => 'Documents', 'routeName' => 'admin.documents', 'route' => route('admin.documents'), 'icon' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>'],
            ['label' => 'Forum', 'routeName' => 'admin.forum', 'route' => route('admin.forum'), 'icon' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path></svg>'],
        ];
    @endphp

    @php
        $admin = auth()->user();
        $initials = $admin ? collect(explode(' ', trim($admin->name)))->map(fn($segment) => strtoupper(substr($segment, 0, 1)))->join('') : 'AD';
    @endphp

    <div class="h-screen flex flex-col md:flex-row" x-data="{ sidebarOpen: false }">
        <!-- Mobile Header -->
        <div class="md:hidden flex items-center justify-between bg-green-600 text-white p-4">
            <div class="flex items-center gap-3">
                <div class="h-10 w-10 rounded-xl bg-white/20 grid place-items-center text-white font-bold">{{ $initials }}</div>
                <span class="font-semibold">Admin Portal</span>
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
                        <p class="text-base font-semibold text-white">Admin Portal</p>
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
                    <div class="h-12 w-12 rounded-full bg-white/20 grid place-items-center text-white text-sm font-semibold">AD</div>
                    <div>
                        <p class="text-sm font-semibold text-white">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-green-100">{{ Auth::user()->email }}</p>
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
                <h1 class="text-4xl font-bold text-slate-900">Welcome, {{ $admin->name ?? 'Admin' }}!</h1>
                <p class="mt-3 text-slate-500">@yield('pageDescription','Manage system operations, users, and reports.')</p>
            </header>

            @yield('content')
        </main>
    </div>
</body>
</html>