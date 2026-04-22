@extends('layouts.faculty')
@section('title', 'My Profile')
@section('pageDescription', 'View your faculty profile and assigned subjects.')
@section('content')
<div class="space-y-6">
    <div class="grid gap-6 xl:grid-cols-[1fr_2fr]">
        {{-- Profile Card --}}
        <section class="rounded-3xl bg-white border border-slate-200 shadow-sm overflow-hidden flex flex-col">
            <div class="h-32 bg-slate-900"></div>
            <div class="px-6 pb-6 flex-1 flex flex-col items-center text-center -mt-16">
                <div class="h-32 w-32 rounded-full border-4 border-white bg-green-100 shadow-md grid place-items-center mb-4">
                    <span class="text-4xl font-bold text-green-700">{{ strtoupper(substr($faculty['name'], 0, 1)) }}</span>
                </div>
                <h2 class="text-2xl font-bold text-slate-900">{{ $faculty['name'] }}</h2>
                <p class="text-sm font-semibold text-green-600 mb-1">{{ $faculty['faculty_id'] }}</p>
                <p class="text-sm text-slate-500">{{ $faculty['designation'] }}</p>
                <div class="mt-4 flex flex-wrap gap-2 justify-center">
                    <span class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-xs font-bold text-emerald-700">{{ $faculty['status'] }}</span>
                    <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-600">Faculty</span>
                </div>
            </div>
        </section>

        <div class="space-y-6">
            {{-- Contact Info --}}
            <section class="rounded-3xl bg-white border border-slate-200 shadow-sm p-6">
                <h3 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    Contact & Office
                </h3>
                <div class="grid gap-4 sm:grid-cols-2">
                    @foreach([
                        ['label' => 'Email',        'value' => $faculty['email']],
                        ['label' => 'Phone',        'value' => $faculty['phone']],
                        ['label' => 'Department',   'value' => $faculty['department']],
                        ['label' => 'Office',       'value' => $faculty['office']],
                        ['label' => 'Office Hours', 'value' => $faculty['office_hours']],
                    ] as $item)
                        <div class="rounded-2xl bg-slate-50 p-4 border border-slate-100 {{ $loop->last ? 'sm:col-span-2' : '' }}">
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">{{ $item['label'] }}</p>
                            <p class="text-sm font-medium text-slate-900">{{ $item['value'] }}</p>
                        </div>
                    @endforeach
                </div>
            </section>

            {{-- Assigned Subjects --}}
            <section class="rounded-3xl bg-white border border-slate-200 shadow-sm p-6">
                <h3 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    Assigned Subjects
                </h3>
                <div class="space-y-2">
                    @foreach($faculty['subjects'] as $subject)
                        <div class="flex items-center gap-3 rounded-2xl bg-green-50 border border-green-100 px-4 py-3">
                            <div class="h-2 w-2 rounded-full bg-green-500 flex-shrink-0"></div>
                            <p class="text-sm font-semibold text-slate-800">{{ $subject }}</p>
                        </div>
                    @endforeach
                </div>
            </section>
        </div>
    </div>
</div>
@endsection
