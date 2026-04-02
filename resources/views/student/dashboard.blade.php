@extends('layouts.student')

@section('title', 'Welcome, ' . Auth::user()->name . '!')
@section('pageDescription', 'Here\'s your academic overview')

@section('content')
    <div class="space-y-6">
        @if(session('status'))
            <div class="rounded-2xl border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-800">
                {{ session('status') }}
            </div>
        @endif

        <!-- Stats Grid -->
        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            @foreach($stats as $stat)
                <div class="rounded-3xl bg-white p-6 shadow-sm border border-slate-200 hover:shadow-md transition-shadow">
                    <p class="text-xs uppercase tracking-[0.2em] font-semibold text-slate-500">{{ $stat['label'] }}</p>
                    <div class="mt-4 flex items-center justify-between gap-4">
                        <p class="text-4xl font-bold text-slate-900">{{ $stat['value'] }}</p>
                        <span class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-{{ $stat['color'] ?? 'green' }}-50 text-{{ $stat['color'] ?? 'green' }}-600 shadow-sm border border-{{ $stat['color'] ?? 'green' }}-100">
                            {!! $stat['icon'] !!}
                        </span>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Main Content Area -->
        <div class="grid gap-6 xl:grid-cols-[1.3fr_1fr]">
            <!-- My Courses -->
            <section class="rounded-3xl bg-white p-6 shadow-sm border border-slate-200">
                <div class="flex items-center justify-between gap-4 mb-6">
                    <div>
                        <h2 class="text-xl font-bold text-slate-900">My Courses</h2>
                        <p class="text-sm text-slate-500 mt-1">Your current schedule and instructors.</p>
                    </div>
                </div>

                <div class="space-y-4">
                    @foreach($courses as $course)
                        @php($isSaved = in_array($course['code'], $savedModuleCodes, true))
                        <article class="group rounded-3xl bg-slate-50 p-5 border border-slate-100 hover:border-green-400 hover:bg-green-50/30 transition-all">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <h4 class="text-lg font-bold text-slate-900 group-hover:text-green-700 transition-colors">{{ $course['name'] }}</h4>
                                    <p class="text-sm text-slate-500 mt-1">{{ $course['instructor'] }}</p>
                                </div>
                                <span class="inline-flex items-center justify-center rounded-full bg-slate-200 px-3 py-1 font-semibold text-slate-700 text-xs">
                                    {{ $course['code'] }}
                                </span>
                            </div>
                            <div class="mt-4 flex items-center gap-2 text-sm text-slate-600">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                {{ $course['schedule'] }}
                            </div>

                            <form method="POST" action="{{ route('student.modules.records.store') }}" class="mt-4">
                                @csrf
                                <input type="hidden" name="module_name" value="{{ $course['name'] }}">
                                <input type="hidden" name="module_code" value="{{ $course['code'] }}">
                                <input type="hidden" name="instructor" value="{{ $course['instructor'] }}">
                                <input type="hidden" name="schedule" value="{{ $course['schedule'] }}">
                                <input type="hidden" name="description" value="{{ $course['description'] }}">
                                <button
                                    type="submit"
                                    class="w-full rounded-2xl px-4 py-2.5 text-sm font-semibold transition {{ $isSaved ? 'bg-green-600 text-white hover:bg-green-700' : 'bg-slate-900 text-white hover:bg-slate-800' }}"
                                >
                                    {{ $isSaved ? 'Saved' : 'Save Record' }}
                                </button>
                            </form>
                        </article>
                    @endforeach
                </div>
            </section>

            <!-- Upcoming Assessments -->
            <section class="rounded-3xl bg-white p-6 shadow-sm border border-slate-200">
                <div class="flex items-center justify-between gap-4 mb-6">
                    <div>
                        <h2 class="text-xl font-bold text-slate-900">Upcoming Assessments</h2>
                        <p class="text-sm text-slate-500 mt-1">Plan ahead for your next quizzes.</p>
                    </div>
                </div>

                <div class="space-y-4">
                    @foreach($assessments as $assessment)
                        <article class="group rounded-3xl bg-slate-50 p-5 border border-slate-100 hover:border-green-400 hover:bg-green-50/30 transition-all">
                            <div class="flex items-start justify-between gap-2">
                                <div>
                                    <h4 class="text-lg font-bold text-slate-900 group-hover:text-green-700 transition-colors">{{ $assessment['title'] }}</h4>
                                    <p class="text-sm text-slate-500 mt-1">{{ $assessment['course'] }}</p>
                                </div>
                                <span class="inline-flex items-center justify-center whitespace-nowrap rounded-full bg-green-100 px-3 py-1 text-xs font-bold text-green-700">
                                    {{ $assessment['points'] }}
                                </span>
                            </div>
                            <div class="mt-4 flex flex-wrap items-center justify-between gap-3 text-sm text-slate-600 border-t border-slate-200 pt-3">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    Due: {{ $assessment['due'] }}
                                </div>
                                <div class="flex items-center gap-2 font-medium">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    {{ $assessment['duration'] }}
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>
        </div>
    </div>
@endsection
