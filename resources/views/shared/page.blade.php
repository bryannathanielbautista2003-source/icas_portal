@extends('layouts.' . Auth::user()->role)

@section('title', $pageTitle)
@section('pageDescription', $pageDescription)

@section('content')
    <div class="grid gap-6">
        <div class="rounded-3xl bg-white p-6 shadow-sm border border-slate-200">
            <h2 class="text-2xl font-semibold text-slate-900">{{ $pageTitle }}</h2>
            <p class="mt-3 text-slate-600">This section is ready for {{ ucfirst(Auth::user()->role) }} users. Add your real data, documents, or discussions here.</p>
        </div>

        @if($pageTitle === 'My Grades')
            <div class="grid gap-4 md:grid-cols-3">
                <div class="rounded-3xl bg-emerald-50 p-6 border border-emerald-100">
                    <p class="text-sm font-semibold text-slate-900">Current GPA</p>
                    <p class="mt-4 text-4xl font-bold text-slate-900">3.8</p>
                </div>
                <div class="rounded-3xl bg-sky-50 p-6 border border-sky-100">
                    <p class="text-sm font-semibold text-slate-900">Completed Courses</p>
                    <p class="mt-4 text-4xl font-bold text-slate-900">8</p>
                </div>
                <div class="rounded-3xl bg-violet-50 p-6 border border-violet-100">
                    <p class="text-sm font-semibold text-slate-900">Latest Assessment</p>
                    <p class="mt-4 text-xl font-semibold text-slate-900">Algebra Quiz</p>
                </div>
            </div>
        @elseif($pageTitle === 'Classrooms')
            <div class="grid gap-4 md:grid-cols-2">
                <div class="rounded-3xl bg-white p-6 border border-slate-200 shadow-sm">
                    <h3 class="text-lg font-semibold text-slate-900">Advanced Mathematics</h3>
                    <p class="mt-2 text-sm text-slate-600">Mon, Wed, Fri • 9:00 AM</p>
                </div>
                <div class="rounded-3xl bg-white p-6 border border-slate-200 shadow-sm">
                    <h3 class="text-lg font-semibold text-slate-900">Physics I</h3>
                    <p class="mt-2 text-sm text-slate-600">Tue, Thu • 10:00 AM</p>
                </div>
            </div>
        @elseif($pageTitle === 'Documents')
            <div class="grid gap-4">
                <a href="#" class="rounded-3xl bg-white p-5 border border-slate-200 shadow-sm hover:border-slate-300 transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm uppercase tracking-[0.3em] text-slate-400">Report</p>
                            <h3 class="text-lg font-semibold text-slate-900">Semester Transcript</h3>
                        </div>
                        <span class="text-sm text-slate-500">PDF</span>
                    </div>
                </a>
                <a href="#" class="rounded-3xl bg-white p-5 border border-slate-200 shadow-sm hover:border-slate-300 transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm uppercase tracking-[0.3em] text-slate-400">Submission</p>
                            <h3 class="text-lg font-semibold text-slate-900">Assignment Notes</h3>
                        </div>
                        <span class="text-sm text-slate-500">DOCX</span>
                    </div>
                </a>
            </div>
        @elseif($pageTitle === 'Forum')
            <div class="grid gap-4">
                <article class="rounded-3xl bg-white p-6 border border-slate-200 shadow-sm">
                    <h3 class="text-lg font-semibold text-slate-900">Upcoming exam tips</h3>
                    <p class="mt-2 text-sm text-slate-600">Join the discussion on how to prepare for next week's assessment.</p>
                </article>
                <article class="rounded-3xl bg-white p-6 border border-slate-200 shadow-sm">
                    <h3 class="text-lg font-semibold text-slate-900">Project collaboration</h3>
                    <p class="mt-2 text-sm text-slate-600">Share ideas and coordinate with classmates for group work.</p>
                </article>
            </div>
        @endif
    </div>
@endsection
