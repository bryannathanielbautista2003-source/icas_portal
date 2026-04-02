@extends('layouts.faculty')

@section('title', 'Dashboard')
@section('pageDescription', 'Faculty Dashboard Overview')

@section('content')
    <div class="space-y-6">
        <!-- Stats Grid -->
        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            @foreach($stats as $stat)
                <div class="rounded-3xl bg-white p-6 shadow-sm border border-slate-200 hover:shadow-md transition-shadow">
                    <p class="text-xs uppercase tracking-[0.2em] font-semibold text-slate-500">{{ $stat['label'] }}</p>
                    <div class="mt-4 flex items-center justify-between gap-4">
                        <p class="text-4xl font-bold text-slate-900">{{ $stat['value'] }}</p>
                        <span class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-green-50 text-green-600 shadow-sm border border-green-100">
                            {!! $stat['icon'] !!}
                        </span>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Main Content Area -->
        <div class="grid gap-6">
            <!-- Teaching Schedule -->
            <section class="rounded-3xl bg-white p-6 shadow-sm border border-slate-200">
                <div class="flex items-center justify-between gap-4 mb-6">
                    <div>
                        <h2 class="text-xl font-bold text-slate-900">My Teaching Schedule</h2>
                        <p class="text-sm text-slate-500 mt-1">Your current classes and enrolled students.</p>
                    </div>
                </div>

                <div class="space-y-4">
                    @foreach($courses as $course)
                        <article class="group rounded-3xl bg-slate-50 p-5 border border-slate-100 hover:border-green-400 hover:bg-green-50/30 transition-all">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <h4 class="text-lg font-bold text-slate-900 group-hover:text-green-700 transition-colors">{{ $course['name'] }}</h4>
                                    <p class="text-sm text-slate-500 mt-1">Grade: {{ $course['grade'] }} • {{ $course['students'] }} Students Enrolled</p>
                                </div>
                                <span class="inline-flex items-center justify-center rounded-full bg-slate-200 px-3 py-1 font-semibold text-slate-700 text-xs">
                                    {{ $course['code'] }}
                                </span>
                            </div>
                            <div class="mt-4 flex items-center gap-2 text-sm text-slate-600 border-t border-slate-200 pt-3">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Schedule: {{ $course['schedule'] }}
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>
        </div>
    </div>
@endsection
