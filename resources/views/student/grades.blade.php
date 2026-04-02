@extends('layouts.student')

@section('title', 'My Grades')
@section('pageDescription', 'View your academic performance and grade calculations.')

@section('content')
    <div class="space-y-6">
        <div class="grid gap-4 md:grid-cols-3">
            @foreach($summary as $item)
                <div class="rounded-3xl bg-white p-6 shadow-sm border border-slate-200">
                    <p class="text-sm uppercase tracking-[0.3em] text-slate-400">{{ $item['label'] }}</p>
                    <p class="mt-4 text-4xl font-semibold text-slate-900">{{ $item['value'] }}</p>
                </div>
            @endforeach
        </div>

        @foreach($courses as $course)
            <div class="rounded-3xl bg-white p-6 shadow-sm border border-slate-200">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div>
                        <h2 class="text-xl font-semibold text-slate-900">{{ $course['name'] }}</h2>
                        <p class="mt-2 text-sm text-slate-500">{{ $course['description'] }}</p>
                    </div>
                    <span class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-sm font-semibold text-emerald-700">{{ $course['grade'] }}</span>
                </div>

                <div class="mt-6 rounded-3xl bg-slate-100 p-4">
                    <div class="flex items-center justify-between text-sm text-slate-500 mb-3">
                        <span>Progress</span>
                        <span class="font-semibold text-slate-900">{{ $course['progress'] }}%</span>
                    </div>
                    <div class="h-3 w-full overflow-hidden rounded-full bg-slate-200">
                        <div class="h-full rounded-full bg-slate-900" style="width: {{ $course['progress'] }}%"></div>
                    </div>
                </div>

                <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach($course['quizzes'] as $quiz)
                        <div class="rounded-3xl bg-slate-50 p-4 text-center border border-slate-200">
                            <p class="text-sm text-slate-500">{{ $quiz['label'] }}</p>
                            <p class="mt-3 text-xl font-semibold text-slate-900">{{ $quiz['score'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

        <div class="rounded-3xl bg-white p-6 shadow-sm border border-slate-200">
            <h2 class="text-lg font-semibold text-slate-900">Major Examinations</h2>
            <div class="mt-5 grid gap-4 md:grid-cols-3">
                @foreach($majorExams as $exam)
                    <div class="rounded-3xl bg-slate-50 p-5 border border-slate-200">
                        <p class="text-sm text-slate-500">{{ $exam['label'] }}</p>
                        <p class="mt-3 text-2xl font-semibold text-slate-900">{{ $exam['value'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection