@extends('layouts.faculty')
@section('title', 'My Schedule')
@section('pageDescription', 'Your weekly teaching schedule for the current semester.')
@section('content')
<div class="space-y-6">
    <section class="rounded-3xl bg-slate-900 p-6 shadow-md text-white">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold">Teaching Schedule</h2>
                <p class="mt-1 text-slate-400 text-sm">AY 2024–2025 · Second Semester</p>
            </div>
            <div class="flex gap-6">
                <div class="text-center">
                    <p class="text-3xl font-black text-green-400">4</p>
                    <p class="text-xs text-slate-400">Subjects</p>
                </div>
                <div class="text-center">
                    <p class="text-3xl font-black text-green-400">{{ $totalStudents }}</p>
                    <p class="text-xs text-slate-400">Students</p>
                </div>
            </div>
        </div>
    </section>

    @php
        $days = ['Mon','Tue','Wed','Thu','Fri','Sat'];
        $subjectColors = [
            'MATH301' => 'bg-emerald-50 border-emerald-300 text-emerald-900',
            'ENG101'  => 'bg-violet-50 border-violet-300 text-violet-900',
            'PHY201'  => 'bg-sky-50 border-sky-300 text-sky-900',
            'HIST201' => 'bg-amber-50 border-amber-300 text-amber-900',
        ];
        $today = date('D');
    @endphp

    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
        @foreach($days as $day)
            <div class="rounded-3xl bg-white border {{ $today === $day ? 'border-slate-900 shadow-md ring-2 ring-slate-200' : 'border-slate-200 shadow-sm' }} overflow-hidden">
                <div class="px-5 py-3.5 flex items-center justify-between {{ $today === $day ? 'bg-slate-900 text-white' : 'bg-slate-50 border-b border-slate-200' }}">
                    <p class="font-bold text-sm">{{ $day }}{{ $today === $day ? ' — Today' : '' }}</p>
                    <span class="text-xs {{ $today === $day ? 'text-slate-400' : 'text-slate-400' }}">{{ count($schedule[$day]) }} class{{ count($schedule[$day]) !== 1 ? 'es' : '' }}</span>
                </div>
                <div class="p-4 space-y-3">
                    @forelse($schedule[$day] as $cls)
                        @php $clr = $subjectColors[$cls['code']] ?? 'bg-slate-50 border-slate-200 text-slate-900'; @endphp
                        <div class="rounded-2xl border {{ $clr }} p-3">
                            <p class="font-bold text-sm">{{ $cls['subject'] }}</p>
                            <p class="text-xs font-mono mt-0.5 opacity-60">{{ $cls['code'] }}</p>
                            <div class="mt-2 space-y-0.5 text-xs opacity-80">
                                <p>⏰ {{ $cls['time'] }}</p>
                                <p>📍 {{ $cls['room'] }}</p>
                                <p>👥 {{ $cls['students'] }} students</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-sm text-slate-400 py-6">No classes</p>
                    @endforelse
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
