@extends('layouts.student')
@section('title', 'My Attendance')
@section('pageDescription', 'Track your attendance history across all enrolled courses.')
@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <section class="rounded-3xl bg-gradient-to-r from-green-500 to-emerald-600 p-6 shadow-md text-white">
        <h2 class="text-2xl font-bold">My Attendance</h2>
        <p class="mt-1 text-green-100 text-sm">Your personal attendance record across all courses this term.</p>
    </section>

    {{-- Summary Cards --}}
    <div class="grid gap-4 sm:grid-cols-5">
        @foreach($summary as $s)
            @php $colors = match($s['color']) {
                'emerald' => ['bg'=>'bg-emerald-50','border'=>'border-emerald-200','val'=>'text-emerald-700'],
                'rose'    => ['bg'=>'bg-rose-50',   'border'=>'border-rose-200',   'val'=>'text-rose-700'],
                'amber'   => ['bg'=>'bg-amber-50',  'border'=>'border-amber-200',  'val'=>'text-amber-700'],
                'sky'     => ['bg'=>'bg-sky-50',    'border'=>'border-sky-200',    'val'=>'text-sky-700'],
                default   => ['bg'=>'bg-white',     'border'=>'border-slate-200',  'val'=>'text-slate-900'],
            }; @endphp
            <div class="rounded-3xl {{ $colors['bg'] }} border {{ $colors['border'] }} p-5 shadow-sm text-center">
                <p class="text-xs uppercase tracking-widest font-semibold text-slate-500">{{ $s['label'] }}</p>
                <p class="mt-3 text-4xl font-black {{ $colors['val'] }}">{{ $s['value'] }}</p>
            </div>
        @endforeach
    </div>

    {{-- Per-Course Breakdown --}}
    <section class="rounded-3xl bg-white border border-slate-200 shadow-sm p-6">
        <h3 class="text-lg font-bold text-slate-900 mb-4">Attendance by Course</h3>
        <div class="space-y-4">
            @foreach($courseBreakdown as $c)
                @php
                    $rate = $c['total'] > 0 ? round(($c['present'] / $c['total']) * 100) : 0;
                    $barColor = $rate >= 90 ? 'bg-emerald-500' : ($rate >= 75 ? 'bg-amber-400' : 'bg-rose-400');
                @endphp
                <div class="rounded-2xl bg-slate-50 border border-slate-100 p-4">
                    <div class="flex flex-wrap items-center justify-between gap-3 mb-3">
                        <div>
                            <p class="font-bold text-slate-900 text-sm">{{ $c['name'] }}</p>
                            <p class="text-xs font-mono text-slate-400 mt-0.5">{{ $c['code'] }}</p>
                        </div>
                        <div class="flex items-center gap-3 text-xs">
                            <span class="rounded-full bg-emerald-100 text-emerald-700 px-2 py-0.5 font-semibold">{{ $c['present'] }} Present</span>
                            <span class="rounded-full bg-rose-100 text-rose-700 px-2 py-0.5 font-semibold">{{ $c['absent'] }} Absent</span>
                            <span class="rounded-full bg-amber-100 text-amber-700 px-2 py-0.5 font-semibold">{{ $c['late'] }} Late</span>
                            <span class="font-black text-slate-900">{{ $rate }}%</span>
                        </div>
                    </div>
                    <div class="h-2.5 w-full rounded-full bg-slate-200">
                        <div class="h-full rounded-full {{ $barColor }} transition-all" style="width: {{ $rate }}%"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Attendance Log --}}
    <section class="rounded-3xl bg-white border border-slate-200 shadow-sm p-6">
        <h3 class="text-lg font-bold text-slate-900 mb-1">Attendance History</h3>
        <p class="text-sm text-slate-500 mb-5">Recent attendance entries logged by your instructors.</p>
        <div class="overflow-x-auto rounded-2xl border border-slate-200">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-5 py-3.5 font-semibold text-slate-500 text-xs uppercase tracking-wide">Date</th>
                        <th class="px-5 py-3.5 font-semibold text-slate-500 text-xs uppercase tracking-wide">Course</th>
                        <th class="px-5 py-3.5 font-semibold text-slate-500 text-xs uppercase tracking-wide">Instructor</th>
                        <th class="px-5 py-3.5 font-semibold text-slate-500 text-xs uppercase tracking-wide text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($records as $record)
                        @php $badge = match($record['status']) {
                            'Present' => 'bg-emerald-100 text-emerald-700',
                            'Late'    => 'bg-amber-100 text-amber-700',
                            default   => 'bg-rose-100 text-rose-700',
                        }; @endphp
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-5 py-3.5 text-slate-600 whitespace-nowrap">{{ $record['date'] }}</td>
                            <td class="px-5 py-3.5">
                                <p class="font-semibold text-slate-900">{{ $record['course'] }}</p>
                                <p class="text-xs font-mono text-slate-400">{{ $record['class'] }}</p>
                            </td>
                            <td class="px-5 py-3.5 text-slate-600">{{ $record['faculty'] }}</td>
                            <td class="px-5 py-3.5 text-center">
                                <span class="inline-flex rounded-full {{ $badge }} px-3 py-1 text-xs font-bold">{{ $record['status'] }}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection
