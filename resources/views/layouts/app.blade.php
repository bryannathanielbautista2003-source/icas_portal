<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title','Dashboard') | ICAS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 min-h-screen text-slate-900">
    @php
        $role = Auth::user()->role;
        if ($role === 'faculty') {
            $navItems = [
                ['label' => 'Dashboard', 'routeName' => 'faculty.dashboard', 'route' => route('faculty.dashboard')],
                ['label' => 'My Students', 'routeName' => 'faculty.students', 'route' => route('faculty.students')],
                ['label' => 'Grade Management', 'routeName' => 'faculty.grades', 'route' => route('faculty.grades')],
            ];
        } elseif ($role === 'student') {
            $navItems = [
                ['label' => 'Dashboard', 'routeName' => 'student.dashboard', 'route' => route('student.dashboard')],
                ['label' => 'My Grades', 'routeName' => 'student.grades', 'route' => route('student.grades')],
                ['label' => 'Classrooms', 'routeName' => 'student.classrooms', 'route' => route('student.classrooms')],
                ['label' => 'Documents', 'routeName' => 'student.documents', 'route' => route('student.documents')],
                ['label' => 'Forum', 'routeName' => 'student.forum', 'route' => route('student.forum')],
            ];
        } else {
            $navItems = [
                ['label' => 'Dashboard', 'routeName' => 'admin.dashboard', 'route' => route('admin.dashboard')],
                ['label' => 'My Grades', 'routeName' => 'admin.grades', 'route' => route('admin.grades')],
                ['label' => 'Classrooms', 'routeName' => 'admin.classrooms', 'route' => route('admin.classrooms')],
                ['label' => 'Documents', 'routeName' => 'admin.documents', 'route' => route('admin.documents')],
                ['label' => 'Forum', 'routeName' => 'admin.forum', 'route' => route('admin.forum')],
            ];
        }
        $currentRoute = Route::currentRouteName();
    @endphp

    <div class="min-h-screen">
        <div class="bg-white border-b border-slate-200">
            <div class="max-w-7xl mx-auto px-4 py-5 sm:px-6">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div>
                        <p class="text-sm uppercase tracking-[0.3em] text-slate-500">ICAS</p>
                        <h1 class="text-2xl font-semibold text-slate-900">{{ ucfirst($role) }} Portal</h1>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="inline-flex h-11 w-11 items-center justify-center rounded-full bg-slate-900 text-sm font-semibold text-white">{{ strtoupper(substr(Auth::user()->name,0,1)) }}</span>
                        <div class="text-right">
                            <p class="text-sm font-semibold text-slate-900">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-slate-500">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-8 grid gap-6 lg:grid-cols-[280px_1fr]">
            <aside class="space-y-6">
                <div class="rounded-3xl bg-slate-950 p-6 text-white shadow-sm">
                    <p class="text-xs uppercase tracking-[0.35em] text-slate-400 mb-3">Navigation</p>
                    <h2 class="text-xl font-semibold">{{ ucfirst($role) }} Menu</h2>
                    <p class="mt-2 text-sm text-slate-300">Quick links to your dashboard tools.</p>
                </div>

                <nav class="rounded-3xl bg-white border border-slate-200 p-4 shadow-sm space-y-2">
                    @foreach($navItems as $item)
                        <a href="{{ $item['route'] }}" class="block rounded-2xl px-4 py-3 text-sm font-medium transition {{ $currentRoute === $item['routeName'] ? 'bg-slate-900 text-white shadow' : 'text-slate-700 hover:bg-slate-50' }}">
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                </nav>
            </aside>

            <main class="space-y-6">
                <div class="rounded-3xl bg-white p-6 shadow-sm border border-slate-200">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <p class="text-sm uppercase tracking-[0.35em] text-slate-500">{{ ucfirst($role) }} Dashboard</p>
                            <h1 class="text-3xl font-semibold text-slate-900">@yield('title','Dashboard')</h1>
                            <p class="mt-2 text-slate-600">@yield('pageDescription','Use the menu to navigate through your portal pages.')</p>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="inline-flex items-center justify-center rounded-full bg-slate-900 px-5 py-3 text-sm font-semibold text-white hover:bg-slate-800 transition">Logout</button>
                        </form>
                    </div>
                </div>

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
