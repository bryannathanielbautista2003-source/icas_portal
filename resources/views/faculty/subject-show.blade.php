@extends('layouts.faculty')

@section('title', $subject['name'])
@section('pageDescription', $subject['code'] . ' — ' . $subject['units'] . ' Units')

@section('content')
@php
    $palette = match($subject['color']) {
        'emerald' => ['gradient' => 'from-emerald-500 to-green-600',    'icon_bg' => 'bg-emerald-100', 'icon_text' => 'text-emerald-700', 'badge' => 'bg-emerald-200/60 text-emerald-900'],
        'sky'     => ['gradient' => 'from-sky-500 to-blue-600',         'icon_bg' => 'bg-sky-100',     'icon_text' => 'text-sky-700',     'badge' => 'bg-sky-200/60 text-sky-900'],
        'amber'   => ['gradient' => 'from-amber-500 to-orange-500',     'icon_bg' => 'bg-amber-100',   'icon_text' => 'text-amber-700',   'badge' => 'bg-amber-200/60 text-amber-900'],
        'violet'  => ['gradient' => 'from-violet-500 to-purple-600',    'icon_bg' => 'bg-violet-100',  'icon_text' => 'text-violet-700',  'badge' => 'bg-violet-200/60 text-violet-900'],
        default   => ['gradient' => 'from-green-500 to-emerald-600',    'icon_bg' => 'bg-green-100',   'icon_text' => 'text-green-700',   'badge' => 'bg-green-200/60 text-green-900'],
    };

    $postIcons = [
        'doc'    => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>',
        'video'  => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
        'assign' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>',
        'quiz'   => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
    ];

    $typeBadge = [
        'material'   => 'bg-slate-100 text-slate-600',
        'assignment' => 'bg-amber-100 text-amber-700',
        'quiz'       => 'bg-rose-100 text-rose-700',
    ];

    $typeLabel = [
        'material'   => 'Material',
        'assignment' => 'Assignment',
        'quiz'       => 'Quiz',
    ];

    $iconBg = [
        'material'   => 'bg-slate-100 text-slate-600',
        'assignment' => 'bg-amber-100 text-amber-700',
        'quiz'       => 'bg-rose-100 text-rose-700',
        'video'      => 'bg-sky-100 text-sky-700',
    ];
@endphp

<div class="space-y-6">
    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-sm">
        <a href="{{ route('faculty.students') }}" class="inline-flex items-center gap-1.5 rounded-xl border border-slate-200 bg-white px-3 py-2 text-slate-600 hover:bg-slate-50 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            My Subjects
        </a>
        <span class="text-slate-300">/</span>
        <span class="text-sm font-semibold text-slate-700 truncate">{{ $subject['name'] }}</span>
    </div>

    {{-- Subject Header Banner --}}
    <section class="rounded-3xl bg-gradient-to-r {{ $palette['gradient'] }} p-7 shadow-md text-white">
        <div class="flex flex-wrap items-start justify-between gap-4">
            <div>
                <div class="flex items-center gap-3 mb-3">
                    <span class="rounded-xl {{ $palette['badge'] }} px-3 py-1 text-sm font-bold font-mono">{{ $subject['code'] }}</span>
                    <span class="rounded-full bg-white/25 px-3 py-1 text-xs font-bold">
                        {{ $subject['units'] }} {{ $subject['units'] === 1 ? 'Unit' : 'Units' }}
                    </span>
                </div>
                <h2 class="text-3xl font-black">{{ $subject['name'] }}</h2>
                <p class="mt-2 text-white/80 text-sm max-w-xl">{{ $subject['description'] }}</p>
                <div class="mt-3 flex flex-wrap gap-4 text-sm text-white/80">
                    <span class="flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ $subject['schedule'] }}
                    </span>
                    <span class="flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197"/></svg>
                        {{ $subject['enrolled'] }} students enrolled
                    </span>
                </div>
            </div>
        </div>
    </section>

    {{-- Quick stats --}}
    @php
        $totalPosts = 0;
        $materialCount = 0;
        $assignmentCount = 0;
        $quizCount = 0;
        foreach ($subject['topics'] as $topic) {
            foreach ($topic['posts'] as $post) {
                $totalPosts++;
                if ($post['type'] === 'material')   $materialCount++;
                if ($post['type'] === 'assignment') $assignmentCount++;
                if ($post['type'] === 'quiz')       $quizCount++;
            }
        }
    @endphp
    <div class="grid gap-4 sm:grid-cols-4">
        <div class="rounded-3xl bg-white border border-slate-200 shadow-sm p-5 text-center">
            <p class="text-3xl font-black text-slate-900">{{ count($subject['topics']) }}</p>
            <p class="text-xs font-semibold text-slate-500 mt-1 uppercase tracking-widest">Topics</p>
        </div>
        <div class="rounded-3xl bg-white border border-slate-200 shadow-sm p-5 text-center">
            <p class="text-3xl font-black text-slate-700">{{ $materialCount }}</p>
            <p class="text-xs font-semibold text-slate-500 mt-1 uppercase tracking-widest">Materials</p>
        </div>
        <div class="rounded-3xl bg-white border border-slate-200 shadow-sm p-5 text-center">
            <p class="text-3xl font-black text-amber-600">{{ $assignmentCount }}</p>
            <p class="text-xs font-semibold text-slate-500 mt-1 uppercase tracking-widest">Assignments</p>
        </div>
        <div class="rounded-3xl bg-white border border-slate-200 shadow-sm p-5 text-center">
            <p class="text-3xl font-black text-rose-500">{{ $quizCount }}</p>
            <p class="text-xs font-semibold text-slate-500 mt-1 uppercase tracking-widest">Quizzes</p>
        </div>
    </div>

    {{-- Topics & Posts (Google Classroom style) --}}
    <div class="space-y-8">
        @foreach($subject['topics'] as $topicIndex => $topic)
            <section>
                {{-- Topic header --}}
                <div class="flex items-center gap-3 mb-4">
                    <div class="h-8 w-8 rounded-full bg-green-600 text-white grid place-items-center text-sm font-black flex-shrink-0">
                        {{ $topicIndex + 1 }}
                    </div>
                    <h3 class="text-lg font-bold text-slate-900">{{ $topic['title'] }}</h3>
                    <div class="flex-1 h-px bg-slate-200"></div>
                    <span class="text-xs font-semibold text-slate-400 flex-shrink-0">{{ count($topic['posts']) }} item{{ count($topic['posts']) !== 1 ? 's' : '' }}</span>
                </div>

                {{-- Posts list --}}
                <div class="space-y-2 pl-11">
                    @foreach($topic['posts'] as $post)
                        @php
                            $iconKey = $post['icon'] ?? $post['type'];
                            $iBg = match($iconKey) {
                                'video'  => 'bg-sky-100 text-sky-600',
                                'assign' => 'bg-amber-100 text-amber-700',
                                'quiz'   => 'bg-rose-100 text-rose-600',
                                default  => 'bg-slate-100 text-slate-600',
                            };
                            $tBadge  = $typeBadge[$post['type']] ?? 'bg-slate-100 text-slate-600';
                            $tLabel  = $typeLabel[$post['type']] ?? ucfirst($post['type']);
                        @endphp
                        <div class="group flex items-start gap-4 rounded-2xl border border-slate-200 bg-white px-5 py-4 hover:border-green-300 hover:bg-green-50/20 transition-all cursor-pointer">
                            {{-- Type icon --}}
                            <div class="h-10 w-10 flex-shrink-0 rounded-xl {{ $iBg }} grid place-items-center mt-0.5">
                                {!! $postIcons[$iconKey] ?? $postIcons['doc'] !!}
                            </div>

                            {{-- Content --}}
                            <div class="flex-1 min-w-0">
                                <div class="flex flex-wrap items-center gap-2 mb-1">
                                    <p class="font-semibold text-slate-900 group-hover:text-green-700 transition-colors">{{ $post['title'] }}</p>
                                    <span class="inline-flex rounded-full {{ $tBadge }} px-2.5 py-0.5 text-xs font-semibold">{{ $tLabel }}</span>
                                </div>
                                <p class="text-sm text-slate-500 leading-relaxed">{{ $post['body'] }}</p>
                            </div>

                            {{-- Date --}}
                            <div class="flex-shrink-0 text-right">
                                <p class="text-xs text-slate-400 font-medium whitespace-nowrap">{{ $post['date'] }}</p>
                                <svg class="w-4 h-4 text-slate-300 group-hover:text-green-500 transition-colors ml-auto mt-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endforeach
    </div>

    {{-- Enrolled Students Section --}}
    <section class="mt-12">
        <div class="flex items-center gap-3 mb-6">
            <div class="h-10 w-10 rounded-full bg-slate-900 text-white grid place-items-center flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-slate-900">Enrolled Students</h3>
        </div>
        
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($enrolledStudents as $student)
                <a href="{{ route('faculty.student.details', $student['id']) }}" class="group rounded-3xl bg-white border border-slate-200 shadow-sm p-5 hover:border-green-400 hover:shadow-md transition-all flex items-center gap-4 cursor-pointer">
                    <div class="h-12 w-12 rounded-full bg-slate-100 text-slate-600 font-bold grid place-items-center flex-shrink-0 group-hover:bg-green-100 group-hover:text-green-700 transition-colors">
                        {{ $student['initials'] }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-bold text-slate-900 truncate group-hover:text-green-700 transition-colors">{{ $student['name'] }}</p>
                        <p class="text-xs text-slate-500 truncate">{{ $student['email'] }}</p>
                    </div>
                    <div class="flex flex-col items-end flex-shrink-0">
                        <span class="text-lg font-black text-slate-700">{{ $student['grade'] }}</span>
                        <svg class="w-4 h-4 text-slate-300 group-hover:text-green-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </div>
                </a>
            @endforeach
        </div>
    </section>
</div>
@endsection

