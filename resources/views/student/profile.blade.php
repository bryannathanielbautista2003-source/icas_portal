@extends('layouts.student')

@section('title', 'My Profile')
@section('pageDescription', 'View your personal details, academic status, and contact information.')

@section('content')
<div class="space-y-6">
    <div class="grid gap-6 xl:grid-cols-[1fr_2fr]">
        {{-- Profile Card --}}
        <section class="rounded-3xl bg-white border border-slate-200 shadow-sm overflow-hidden flex flex-col">
            <div class="h-32 bg-gradient-to-r from-green-500 to-emerald-600"></div>
            <div class="px-6 pb-6 flex-1 flex flex-col items-center text-center -mt-16">
                <div class="h-32 w-32 rounded-full border-4 border-white bg-slate-100 shadow-md grid place-items-center mb-4">
                    <span class="text-4xl font-bold text-slate-700">{{ strtoupper(substr($studentDetails['name'], 0, 1)) }}</span>
                </div>
                <h2 class="text-2xl font-bold text-slate-900">{{ $studentDetails['name'] }}</h2>
                <p class="text-sm font-semibold text-green-600 mb-1">{{ $studentDetails['student_id'] }}</p>
                <p class="text-sm text-slate-500">{{ $studentDetails['program'] }}</p>

                <div class="mt-6 w-full flex flex-wrap gap-2 justify-center">
                    <span class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-xs font-bold text-emerald-700">{{ $studentDetails['status'] }}</span>
                    <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-700">{{ $studentDetails['year_level'] }}</span>
                </div>
            </div>
        </section>

        {{-- Details Sections --}}
        <div class="space-y-6">
            {{-- Contact Information --}}
            <section class="rounded-3xl bg-white border border-slate-200 shadow-sm p-6">
                <h3 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    Contact Information
                </h3>
                <div class="grid gap-4 sm:grid-cols-2">
                    <div class="rounded-2xl bg-slate-50 p-4 border border-slate-100">
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Email Address</p>
                        <p class="text-sm font-medium text-slate-900">{{ $studentDetails['email'] }}</p>
                    </div>
                    <div class="rounded-2xl bg-slate-50 p-4 border border-slate-100">
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Phone Number</p>
                        <p class="text-sm font-medium text-slate-900">{{ $studentDetails['phone'] }}</p>
                    </div>
                    <div class="rounded-2xl bg-slate-50 p-4 border border-slate-100 sm:col-span-2">
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Home Address</p>
                        <p class="text-sm font-medium text-slate-900">{{ $studentDetails['address'] }}</p>
                    </div>
                </div>
            </section>

            {{-- Emergency Contact --}}
            <section class="rounded-3xl bg-white border border-slate-200 shadow-sm p-6">
                <h3 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    Emergency Contact
                </h3>
                <div class="flex items-center gap-4 rounded-2xl bg-rose-50 border border-rose-100 p-4">
                    <div class="h-12 w-12 rounded-full bg-white text-rose-600 grid place-items-center shadow-sm font-bold text-lg">
                        {{ strtoupper(substr($studentDetails['emergency_contact']['name'], 0, 1)) }}
                    </div>
                    <div>
                        <p class="font-bold text-slate-900">{{ $studentDetails['emergency_contact']['name'] }}</p>
                        <p class="text-sm text-slate-600">{{ $studentDetails['emergency_contact']['relation'] }} • {{ $studentDetails['emergency_contact']['phone'] }}</p>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection
