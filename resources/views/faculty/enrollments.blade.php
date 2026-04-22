@extends('layouts.faculty')

@section('title', 'Enrollments')
@section('pageDescription', 'Review and manage student enrollment requests for your courses.')

@section('content')
    <div class="space-y-6">
        @if(session('status'))
            <div class="flex items-center gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3">
                <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <p class="text-sm font-medium text-emerald-800">{{ session('status') }}</p>
            </div>
        @endif

        {{-- Summary Cards --}}
        <div class="grid gap-4 sm:grid-cols-3">
            @foreach($summary as $item)
                @php
                    $colors = match($item['color']) {
                        'amber'   => ['border' => 'border-amber-200',   'bg' => 'bg-amber-50',   'val' => 'text-amber-700',   'dot' => 'bg-amber-400'],
                        'emerald' => ['border' => 'border-emerald-200', 'bg' => 'bg-emerald-50', 'val' => 'text-emerald-700', 'dot' => 'bg-emerald-500'],
                        'rose'    => ['border' => 'border-rose-200',    'bg' => 'bg-rose-50',    'val' => 'text-rose-700',    'dot' => 'bg-rose-400'],
                        default   => ['border' => 'border-slate-200',   'bg' => 'bg-white',      'val' => 'text-slate-900',   'dot' => 'bg-slate-400'],
                    };
                    $isActive = $tab === $item['tab'];
                @endphp
                <a href="{{ route('faculty.enrollments', ['tab' => $item['tab']]) }}"
                   class="rounded-3xl {{ $colors['bg'] }} border-2 {{ $isActive ? $colors['border'] : 'border-transparent' }} p-6 shadow-sm hover:shadow-md transition-all block group">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="w-2.5 h-2.5 rounded-full {{ $colors['dot'] }}"></span>
                        <p class="text-xs uppercase tracking-[0.2em] font-semibold text-slate-500">{{ $item['label'] }}</p>
                    </div>
                    <p class="text-4xl font-bold {{ $colors['val'] }}">{{ $item['value'] }}</p>
                    @if($isActive)
                        <p class="mt-2 text-xs {{ $colors['val'] }} font-semibold">Currently viewing ↓</p>
                    @endif
                </a>
            @endforeach
        </div>

        {{-- Enrollments Panel --}}
        <section class="rounded-3xl bg-white p-6 shadow-sm border border-slate-200">
            <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
                <div>
                    <h2 class="text-xl font-bold text-slate-900">
                        @if($tab === 'pending') Pending Enrollments
                        @elseif($tab === 'enrolled') Enrolled Students
                        @else Dropped Enrollments
                        @endif
                    </h2>
                    <p class="text-sm text-slate-500 mt-1">
                        @if($tab === 'pending') Review incoming requests — approve enrollment and assign sections.
                        @elseif($tab === 'enrolled') Students who have been confirmed for your courses.
                        @else Students who dropped from your courses.
                        @endif
                    </p>
                </div>

                {{-- Tab Switcher --}}
                <div class="flex rounded-2xl border border-slate-200 overflow-hidden text-sm font-semibold">
                    <a href="{{ route('faculty.enrollments', ['tab' => 'pending']) }}"
                       class="px-4 py-2 transition {{ $tab === 'pending' ? 'bg-amber-500 text-white' : 'bg-white text-slate-600 hover:bg-slate-50' }}">
                        Pending
                    </a>
                    <a href="{{ route('faculty.enrollments', ['tab' => 'enrolled']) }}"
                       class="px-4 py-2 transition {{ $tab === 'enrolled' ? 'bg-emerald-600 text-white' : 'bg-white text-slate-600 hover:bg-slate-50' }}">
                        Enrolled
                    </a>
                    <a href="{{ route('faculty.enrollments', ['tab' => 'dropped']) }}"
                       class="px-4 py-2 transition {{ $tab === 'dropped' ? 'bg-rose-500 text-white' : 'bg-white text-slate-600 hover:bg-slate-50' }}">
                        Dropped
                    </a>
                </div>
            </div>

            {{-- Course Filter --}}
            @if(count($courseOptions) > 0)
                <form method="GET" action="{{ route('faculty.enrollments') }}" class="mb-6 flex flex-wrap gap-3 items-center">
                    <input type="hidden" name="tab" value="{{ $tab }}">
                    <label class="text-xs font-semibold text-slate-500">Filter by Course:</label>
                    <select name="course" class="rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-green-400">
                        <option value="">All Courses</option>
                        @foreach($courseOptions as $opt)
                            <option value="{{ $opt['code'] }}" {{ $courseFilter === $opt['code'] ? 'selected' : '' }}>
                                {{ $opt['name'] }} ({{ $opt['code'] }})
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="rounded-xl bg-green-600 px-4 py-2 text-sm font-semibold text-white hover:bg-green-700 transition">Apply</button>
                    @if($courseFilter)
                        <a href="{{ route('faculty.enrollments', ['tab' => $tab]) }}"
                           class="rounded-xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-50 transition">Clear</a>
                    @endif
                </form>
            @endif

            {{-- Enrollment List --}}
            <div class="space-y-4">
                @forelse($enrollments as $enrollment)
                    @php
                        $st = $enrollment->enrollment_status;
                        $badge = match($st) {
                            'enrolled' => 'bg-emerald-100 text-emerald-700',
                            'dropped'  => 'bg-rose-100 text-rose-700',
                            default    => 'bg-amber-100 text-amber-700',
                        };
                    @endphp
                    <article class="rounded-3xl border border-slate-200 bg-slate-50 p-5 hover:border-green-300 transition-colors">
                        <div class="flex flex-wrap items-start justify-between gap-4">
                            {{-- Student & Course --}}
                            <div class="flex items-start gap-4">
                                <div class="h-10 w-10 flex-shrink-0 rounded-full bg-green-600 grid place-items-center text-white text-sm font-bold">
                                    {{ strtoupper(substr($enrollment->user->name ?? 'U', 0, 1)) }}
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-900">{{ $enrollment->user->name ?? 'Unknown' }}</p>
                                    <p class="text-xs text-slate-500">{{ $enrollment->user->email ?? '' }}</p>
                                    <p class="mt-1 text-xs text-slate-600">
                                        <span class="font-semibold">{{ $enrollment->module_name }}</span>
                                        <span class="text-slate-400 mx-1">·</span>
                                        <span class="font-mono text-slate-500">{{ $enrollment->module_code }}</span>
                                    </p>
                                    @if($enrollment->instructor)
                                        <p class="text-xs text-slate-400 mt-0.5">{{ $enrollment->instructor }}</p>
                                    @endif
                                    @if($enrollment->section)
                                        <span class="mt-1.5 inline-flex rounded-md bg-sky-100 px-2 py-0.5 text-xs text-sky-700 font-semibold">
                                            Section: {{ $enrollment->section }}
                                        </span>
                                    @endif
                                    <p class="text-xs text-slate-400 mt-1">{{ $enrollment->created_at?->diffForHumans() }}</p>
                                </div>
                            </div>

                            {{-- Actions --}}
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="inline-flex rounded-full {{ $badge }} px-3 py-1 text-xs font-bold capitalize">{{ ucfirst($st) }}</span>

                                @if($tab === 'pending')
                                    <form method="POST" action="{{ route('faculty.enrollments.approve', $enrollment) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button class="rounded-xl bg-emerald-600 px-3 py-2 text-xs font-semibold text-white hover:bg-emerald-700 transition flex items-center gap-1.5">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            Approve
                                        </button>
                                    </form>

                                    <form method="POST" action="{{ route('faculty.enrollments.section', ['moduleRecord' => $enrollment, 'tab' => $tab]) }}" class="flex items-center gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <input type="text" name="section" placeholder="e.g. A or B" required
                                               class="w-28 rounded-xl border border-slate-300 bg-white px-3 py-1.5 text-xs focus:outline-none focus:ring-2 focus:ring-green-400">
                                        <button class="rounded-xl bg-slate-700 px-3 py-1.5 text-xs font-semibold text-white hover:bg-slate-800 transition">Assign</button>
                                    </form>
                                @endif

                                @if($tab === 'enrolled' && !$enrollment->section)
                                    <form method="POST" action="{{ route('faculty.enrollments.section', ['moduleRecord' => $enrollment, 'tab' => $tab]) }}" class="flex items-center gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <input type="text" name="section" placeholder="Assign section" required
                                               class="w-32 rounded-xl border border-slate-300 bg-white px-3 py-1.5 text-xs focus:outline-none focus:ring-2 focus:ring-green-400">
                                        <button class="rounded-xl bg-sky-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-sky-700 transition">Assign Section</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="rounded-3xl border border-dashed border-slate-300 bg-slate-50 p-10 text-center">
                        <svg class="mx-auto w-10 h-10 text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        <p class="text-sm font-medium text-slate-700">No {{ $tab }} enrollments found.</p>
                        @if($courseFilter)
                            <p class="mt-1 text-xs text-slate-400">Try clearing the course filter.</p>
                        @endif
                    </div>
                @endforelse

                <div class="mt-4">{{ $enrollments->links() }}</div>
            </div>
        </section>
    </div>
@endsection
