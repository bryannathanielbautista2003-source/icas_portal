@extends('layouts.faculty')

@section('title', 'Student Details')
@section('pageDescription', 'View student performance, grades, and recent activity.')

@section('content')
<div class="space-y-6">
    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-sm">
        <a href="{{ route('faculty.students') }}" class="inline-flex items-center gap-1.5 rounded-xl border border-slate-200 bg-white px-3 py-2 text-slate-600 hover:bg-slate-50 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            My Subjects
        </a>
        <span class="text-slate-300">/</span>
        <span class="text-sm font-semibold text-slate-700 truncate">{{ $student['name'] }}</span>
    </div>

    <div class="grid gap-6 xl:grid-cols-[1fr_2fr]">
        {{-- Profile Card --}}
        <section class="rounded-3xl bg-white border border-slate-200 shadow-sm overflow-hidden flex flex-col">
            <div class="h-32 bg-slate-900"></div>
            <div class="px-6 pb-6 flex-1 flex flex-col items-center text-center -mt-16">
                <div class="h-32 w-32 rounded-full border-4 border-white bg-slate-100 shadow-md grid place-items-center mb-4">
                    <span class="text-4xl font-bold text-slate-700">{{ strtoupper(substr($student['name'], 0, 1)) }}</span>
                </div>
                <h2 class="text-2xl font-bold text-slate-900">{{ $student['name'] }}</h2>
                <p class="text-sm font-semibold text-green-600 mb-1">{{ $student['student_id'] }}</p>
                
                <div class="mt-4 space-y-2 text-sm text-slate-600">
                    <p class="flex items-center justify-center gap-2">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        {{ $student['email'] }}
                    </p>
                    <p class="flex items-center justify-center gap-2">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        {{ $student['phone'] }}
                    </p>
                </div>

                <div class="mt-6 w-full flex flex-wrap gap-2 justify-center">
                    <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-700">{{ $student['program'] }}</span>
                    <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-700">{{ $student['year_level'] }}</span>
                </div>
            </div>
        </section>

        {{-- Details Sections --}}
        <div class="space-y-6">
            {{-- Quick Stats --}}
            <div class="grid gap-4 sm:grid-cols-3">
                <div class="rounded-3xl bg-white border border-slate-200 shadow-sm p-5 text-center">
                    <p class="text-3xl font-black text-emerald-600">{{ $student['overall_grade'] }}</p>
                    <p class="text-xs font-semibold text-slate-500 mt-1 uppercase tracking-widest">Avg Grade</p>
                </div>
                <div class="rounded-3xl bg-white border border-slate-200 shadow-sm p-5 text-center">
                    <p class="text-3xl font-black text-sky-600">{{ $student['overall_attendance'] }}</p>
                    <p class="text-xs font-semibold text-slate-500 mt-1 uppercase tracking-widest">Attendance</p>
                </div>
                <div class="rounded-3xl bg-white border border-slate-200 shadow-sm p-5 text-center">
                    <p class="text-lg font-bold text-slate-900 mt-1">{{ $student['performance_trend'] }}</p>
                    <p class="text-xs font-semibold text-slate-500 mt-2 uppercase tracking-widest">Trend</p>
                </div>
            </div>

            {{-- Subject Performance --}}
            <section class="rounded-3xl bg-white border border-slate-200 shadow-sm p-6">
                <h3 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    Enrolled Subjects Performance
                </h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-left text-sm text-slate-700">
                        <thead>
                            <tr class="border-b border-slate-200 bg-slate-50">
                                <th class="px-4 py-3 font-semibold text-slate-500 rounded-tl-xl">Subject</th>
                                <th class="px-4 py-3 font-semibold text-slate-500 text-right">Grade</th>
                                <th class="px-4 py-3 font-semibold text-slate-500 text-right rounded-tr-xl">Attendance</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($subjectGrades as $sub)
                                <tr>
                                    <td class="px-4 py-4">
                                        <p class="font-bold text-slate-900">{{ $sub['name'] }}</p>
                                        <p class="text-xs text-slate-400 font-mono">{{ $sub['code'] }}</p>
                                    </td>
                                    <td class="px-4 py-4 text-right font-black text-emerald-600 text-lg">{{ $sub['grade'] }}</td>
                                    <td class="px-4 py-4 text-right text-slate-500">{{ $sub['attendance'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>

            {{-- Recent Activity --}}
            <section class="rounded-3xl bg-white border border-slate-200 shadow-sm p-6">
                <h3 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Recent Activity
                </h3>
                <div class="space-y-3">
                    @foreach($recentActivity as $activity)
                        @php
                            $icons = [
                                'assign' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>',
                                'quiz' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
                                'doc' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>',
                            ];
                            $colorClass = match($activity['color']) {
                                'amber' => 'bg-amber-100 text-amber-600',
                                'rose' => 'bg-rose-100 text-rose-600',
                                default => 'bg-slate-100 text-slate-600',
                            };
                        @endphp
                        <div class="flex items-start gap-4 rounded-2xl bg-slate-50 border border-slate-100 p-4">
                            <div class="h-8 w-8 rounded-full {{ $colorClass }} grid place-items-center flex-shrink-0 mt-0.5">
                                {!! $icons[$activity['icon']] !!}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-bold text-slate-900">{{ $activity['action'] }}</p>
                                <p class="text-sm text-slate-500">{{ $activity['subject'] }}</p>
                            </div>
                            <span class="text-xs font-semibold text-slate-400 whitespace-nowrap">{{ $activity['date'] }}</span>
                        </div>
                    @endforeach
                </div>
            </section>
        </div>
    </div>
</div>
@endsection
