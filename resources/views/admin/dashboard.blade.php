@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('pageDescription', 'Monitor system health, users, and school analytics.')

@section('content')
    <div class="space-y-6">
        <!-- Welcome Section -->
        <div class="rounded-3xl bg-gradient-to-r from-green-500 to-green-600 p-8 shadow-md text-white">
            <h1 class="text-3xl font-bold mb-2">Welcome back, {{ auth()->user()->name }}! 👋</h1>
            <p class="text-green-50">Here's a summary of your school's performance and system status.</p>
        </div>

        @if($pendingUsersCount > 0)
        <div class="alert alert-warning bg-amber-100 text-amber-800 p-4 rounded-xl border border-amber-200 shadow-sm flex items-center justify-between">
            <div class="flex items-center gap-3">
                <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                <div class="font-semibold text-sm">
                    New Student Account for Verification ({{ $pendingUsersCount }} pending)
                </div>
            </div>
            <a href="{{ route('admin.users', ['status' => 'pending']) }}" class="text-sm font-bold bg-amber-500 text-white px-4 py-2 rounded-lg hover:bg-amber-600 transition">View Users</a>
        </div>
        @endif

        <!-- Stats Grid -->
        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            @foreach($summary as $item)
                <div class="rounded-3xl bg-white p-6 shadow-sm border border-slate-200 hover:shadow-md transition-shadow">
                    <p class="text-xs uppercase tracking-[0.2em] font-semibold text-slate-500">{{ $item['label'] }}</p>
                    <div class="mt-4 flex items-center justify-between gap-4">
                        <p class="text-4xl font-bold text-slate-900">{{ $item['value'] }}</p>
                        <span class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-green-50 text-green-600 shadow-sm border border-green-100">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        </span>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Enrollment Breakdown Widget --}}
        <section class="rounded-3xl bg-white p-6 shadow-sm border border-slate-200">
            <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
                <div>
                    <h2 class="text-xl font-bold text-slate-900">Enrollment Overview</h2>
                    <p class="text-sm text-slate-500 mt-1">Live counts of pending inquiries vs enrolled students.</p>
                </div>
                <a href="{{ route('admin.enrollments') }}" class="rounded-2xl bg-green-600 px-4 py-2 text-sm font-semibold text-white hover:bg-green-700 transition">
                    Manage Enrollments →
                </a>
            </div>

            <div class="grid gap-4 sm:grid-cols-3">
                {{-- Pending --}}
                <a href="{{ route('admin.enrollments', ['tab' => 'pending']) }}"
                   class="group relative overflow-hidden rounded-3xl bg-amber-50 border border-amber-200 p-6 hover:shadow-md transition-all">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-widest text-amber-600">Pending Inquiries</p>
                            <p class="mt-3 text-5xl font-black text-amber-700">{{ $enrollmentPending }}</p>
                            <p class="mt-2 text-xs text-amber-600">Awaiting approval</p>
                        </div>
                        <span class="h-12 w-12 flex items-center justify-center rounded-2xl bg-amber-200 text-amber-700 flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </span>
                    </div>
                    @if($enrollmentPending > 0)
                        <div class="mt-4 flex items-center gap-2">
                            <span class="inline-flex h-2 w-2 rounded-full bg-amber-400 animate-pulse"></span>
                            <span class="text-xs text-amber-600 font-semibold">Action required</span>
                        </div>
                    @endif
                </a>

                {{-- Enrolled --}}
                <a href="{{ route('admin.enrollments', ['tab' => 'enrolled']) }}"
                   class="group relative overflow-hidden rounded-3xl bg-emerald-50 border border-emerald-200 p-6 hover:shadow-md transition-all">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-widest text-emerald-600">Enrolled Students</p>
                            <p class="mt-3 text-5xl font-black text-emerald-700">{{ $enrollmentEnrolled }}</p>
                            <p class="mt-2 text-xs text-emerald-600">Confirmed &amp; approved</p>
                        </div>
                        <span class="h-12 w-12 flex items-center justify-center rounded-2xl bg-emerald-200 text-emerald-700 flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </span>
                    </div>
                </a>

                {{-- Dropped --}}
                <a href="{{ route('admin.enrollments', ['tab' => 'dropped']) }}"
                   class="group relative overflow-hidden rounded-3xl bg-rose-50 border border-rose-200 p-6 hover:shadow-md transition-all">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-widest text-rose-600">Dropped</p>
                            <p class="mt-3 text-5xl font-black text-rose-700">{{ $enrollmentDropped }}</p>
                            <p class="mt-2 text-xs text-rose-600">Courses dropped</p>
                        </div>
                        <span class="h-12 w-12 flex items-center justify-center rounded-2xl bg-rose-200 text-rose-700 flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </span>
                    </div>
                </a>
            </div>

            {{-- Progress Bar --}}
            @php
                $total = $enrollmentPending + $enrollmentEnrolled + $enrollmentDropped;
                $pendingPct  = $total > 0 ? round(($enrollmentPending  / $total) * 100) : 0;
                $enrolledPct = $total > 0 ? round(($enrollmentEnrolled / $total) * 100) : 0;
                $droppedPct  = $total > 0 ? 100 - $pendingPct - $enrolledPct : 0;
            @endphp
            @if($total > 0)
                <div class="mt-6">
                    <div class="flex items-center justify-between text-xs text-slate-500 mb-2">
                        <span class="font-semibold text-slate-700">Enrollment Breakdown</span>
                        <span>{{ $total }} total records</span>
                    </div>
                    <div class="h-3 w-full flex overflow-hidden rounded-full bg-slate-100">
                        <div class="h-full bg-amber-400 transition-all" style="width: {{ $pendingPct }}%"></div>
                        <div class="h-full bg-emerald-500 transition-all" style="width: {{ $enrolledPct }}%"></div>
                        <div class="h-full bg-rose-400 transition-all" style="width: {{ $droppedPct }}%"></div>
                    </div>
                    <div class="flex flex-wrap gap-4 mt-3 text-xs">
                        <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-amber-400"></span> Pending {{ $pendingPct }}%</span>
                        <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span> Enrolled {{ $enrolledPct }}%</span>
                        <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-rose-400"></span> Dropped {{ $droppedPct }}%</span>
                    </div>
                </div>
            @endif
        </section>

        <div class="grid gap-6 xl:grid-cols-[1.4fr_1fr]">
            <!-- System Overview -->
            <section class="rounded-3xl bg-white p-6 shadow-sm border border-slate-200">
                <div class="flex items-center justify-between gap-4 mb-6">
                    <div>
                        <h2 class="text-xl font-bold text-slate-900">Quick Stats</h2>
                        <p class="text-sm text-slate-500 mt-1">Enrollments, classrooms, attendance &amp; announcements.</p>
                    </div>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    @foreach($overview as $item)
                        <article class="group rounded-3xl bg-slate-50 p-5 border border-slate-100 hover:border-green-400 hover:bg-green-50/30 transition-all">
                            <p class="text-sm font-semibold text-slate-500">{{ $item['title'] }}</p>
                            <p class="mt-2 text-3xl font-bold text-slate-900">{{ $item['value'] }}</p>
                        </article>
                    @endforeach
                </div>

                <div class="mt-6 rounded-3xl bg-slate-50 p-5 border border-slate-100">
                    <div class="flex items-center justify-between text-sm text-slate-600 mb-3">
                        <span class="font-semibold">Server Usage</span>
                        <span class="font-bold text-slate-900">68%</span>
                    </div>
                    <div class="h-3 w-full overflow-hidden rounded-full bg-slate-200">
                        <div class="h-full w-2/3 rounded-full bg-green-500"></div>
                    </div>
                </div>
            </section>

            <!-- Recent Actions -->
            <aside class="rounded-3xl bg-white p-6 shadow-sm border border-slate-200">
                <h2 class="text-xl font-bold text-slate-900 mb-6">System Status</h2>
                <div class="space-y-4">
                    @foreach($recentActions as $action)
                        <div class="group rounded-3xl bg-slate-50 p-4 border border-slate-100 hover:border-green-400 hover:bg-green-50/30 transition-all">
                            <div class="flex items-start gap-4">
                                <span class="mt-1 flex-shrink-0 inline-flex h-8 w-8 items-center justify-center rounded-full bg-green-100 text-green-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </span>
                                <div>
                                    <p class="text-sm font-bold text-slate-900 group-hover:text-green-700 transition-colors">{{ $action['title'] }}</p>
                                    <p class="mt-1 text-xs text-slate-500">{{ $action['subtitle'] }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </aside>
        </div>
    </div>
@endsection
