@extends('layouts.student')

@section('title', 'Classrooms')
@section('pageDescription', 'Access your courses and quizzes.')

@section('content')
    <div class="grid gap-6">
        <div class="grid gap-4 md:grid-cols-3">
            @foreach($classrooms as $classroom)
                <article class="rounded-3xl bg-white p-6 shadow-sm border border-slate-200 flex h-full flex-col">
                    <div>
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <h2 class="text-xl font-semibold text-slate-900">{{ $classroom['name'] }}</h2>
                                <p class="mt-2 text-sm text-slate-500">{{ $classroom['code'] }}</p>
                            </div>
                            <span class="inline-flex rounded-2xl bg-sky-100 px-3 py-1 text-sm font-semibold text-sky-700">{{ $classroom['quizzes'] }} quiz{{ $classroom['quizzes'] !== 1 ? 'zes' : '' }}</span>
                        </div>
                        <div class="mt-6 text-sm text-slate-500 space-y-2">
                            <p><span class="font-semibold text-slate-700">Instructor:</span> {{ $classroom['instructor'] }}</p>
                            <p><span class="font-semibold text-slate-700">Schedule:</span> {{ $classroom['schedule'] }}</p>
                        </div>
                    </div>
                    <button class="mt-auto w-full rounded-3xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white hover:bg-slate-800 transition">Open Classroom</button>
                </article>
            @endforeach
        </div>
    </div>
@endsection