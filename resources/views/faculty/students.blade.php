@extends('layouts.faculty')

@section('title', 'My Subjects')
@section('pageDescription', 'Browse your assigned subjects and access class materials.')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <section class="rounded-3xl bg-gradient-to-r from-green-500 to-emerald-600 p-6 shadow-md text-white">
        <h2 class="text-2xl font-bold">My Subjects</h2>
        <p class="mt-1 text-green-100 text-sm">{{ count($subjects) }} subjects assigned this term. Click a subject to view lessons and materials.</p>
    </section>

    {{-- Subject Cards --}}
    <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-2">
        @foreach($subjects as $subject)
            @php
                $palette = match($subject['color']) {
                    'emerald' => ['icon_bg' => 'bg-emerald-100', 'icon_text' => 'text-emerald-700', 'badge' => 'bg-emerald-100 text-emerald-700', 'border_hover' => 'hover:border-emerald-400'],
                    'sky'     => ['icon_bg' => 'bg-sky-100',     'icon_text' => 'text-sky-700',     'badge' => 'bg-sky-100 text-sky-700',         'border_hover' => 'hover:border-sky-400'],
                    'amber'   => ['icon_bg' => 'bg-amber-100',   'icon_text' => 'text-amber-700',   'badge' => 'bg-amber-100 text-amber-700',     'border_hover' => 'hover:border-amber-400'],
                    'violet'  => ['icon_bg' => 'bg-violet-100',  'icon_text' => 'text-violet-700',  'badge' => 'bg-violet-100 text-violet-700',   'border_hover' => 'hover:border-violet-400'],
                    default   => ['icon_bg' => 'bg-green-100',   'icon_text' => 'text-green-700',   'badge' => 'bg-green-100 text-green-700',     'border_hover' => 'hover:border-green-400'],
                };
            @endphp
            <a href="{{ route('faculty.students.show', $subject['slug']) }}"
               class="group rounded-3xl bg-white border border-slate-200 shadow-sm {{ $palette['border_hover'] }} hover:shadow-md transition-all flex flex-col">
                <div class="p-6 flex-1">
                    <div class="flex items-start justify-between gap-3 mb-5">
                        {{-- Subject icon --}}
                        <div class="h-14 w-14 rounded-2xl {{ $palette['icon_bg'] }} {{ $palette['icon_text'] }} grid place-items-center flex-shrink-0">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        {{-- Units badge --}}
                        <span class="inline-flex items-center rounded-full {{ $palette['badge'] }} px-3 py-1 text-xs font-bold flex-shrink-0">
                            {{ $subject['units'] }} {{ $subject['units'] === 1 ? 'Unit' : 'Units' }}
                        </span>
                    </div>

                    <h3 class="text-xl font-bold text-slate-900 group-hover:text-green-700 transition-colors">{{ $subject['name'] }}</h3>
                    <p class="text-xs font-mono text-slate-400 mt-0.5">{{ $subject['code'] }}</p>
                    <p class="mt-3 text-sm text-slate-500 leading-relaxed">{{ $subject['description'] }}</p>

                    <div class="mt-4 space-y-1.5 text-xs text-slate-500">
                        <p class="flex items-center gap-2">
                            <svg class="w-3.5 h-3.5 text-slate-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ $subject['schedule'] }}
                        </p>
                        <p class="flex items-center gap-2">
                            <svg class="w-3.5 h-3.5 text-slate-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197"/>
                            </svg>
                            {{ $subject['enrolled'] }} students enrolled
                        </p>
                    </div>
                </div>

                <div class="border-t border-slate-100 px-6 py-3 flex items-center justify-between">
                    <span class="text-xs font-semibold text-green-600 group-hover:text-green-700 transition-colors flex items-center gap-1.5">
                        View Lessons & Materials
                        <svg class="w-3.5 h-3.5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </span>
                    <span class="text-xs text-slate-400">{{ $subject['code'] }}</span>
                </div>
            </a>
        @endforeach
    </div>
</div>
@endsection