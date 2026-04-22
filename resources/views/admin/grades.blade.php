@extends('layouts.admin')
@section('title', 'Grade Distribution')
@section('pageDescription', 'Monitor grade distributions and academic performance across all courses.')
@section('content')
<div class="space-y-6">
    {{-- Header + Export --}}
    <section class="rounded-3xl bg-white border border-slate-200 shadow-sm p-6">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Grade Management</p>
                <h2 class="mt-1 text-2xl font-bold text-slate-900">Grade Distribution</h2>
                <p class="mt-1 text-sm text-slate-500">Academic performance overview across all enrolled courses.</p>
            </div>
            <a href="{{ route('admin.grades.export') }}" class="inline-flex items-center gap-2 rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white hover:bg-slate-800 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Export CSV
            </a>
        </div>
    </section>

    {{-- Overall Stats --}}
    <div class="grid gap-4 sm:grid-cols-4">
        @foreach([['Overall Average','84.6%','emerald'],['Passing Rate','91%','sky'],['Students Graded','98','slate'],['Courses Monitored','5','slate']] as [$l,$v,$c])
            @php $cc=match($c){'emerald'=>['bg-emerald-50','border-emerald-200','text-emerald-700'],'sky'=>['bg-sky-50','border-sky-200','text-sky-700'],default=>['bg-white','border-slate-200','text-slate-900']}; @endphp
            <div class="rounded-3xl {{ $cc[0] }} border {{ $cc[1] }} shadow-sm p-6">
                <p class="text-xs uppercase tracking-widest font-semibold text-slate-500">{{ $l }}</p>
                <p class="mt-3 text-4xl font-black {{ $cc[2] }}">{{ $v }}</p>
            </div>
        @endforeach
    </div>

    {{-- Per-Course Distribution --}}
    <section class="rounded-3xl bg-white border border-slate-200 shadow-sm p-6">
        <h3 class="text-lg font-bold text-slate-900 mb-6">Per-Course Grade Distribution</h3>
        @php
        $courses = [
            ['name'=>'Advanced Mathematics','code'=>'MATH301','avg'=>86,'highest'=>98,'lowest'=>62,'passing'=>93,'dist'=>['A'=>8,'B'=>12,'C'=>6,'D'=>1,'F'=>1]],
            ['name'=>'Physics I',           'code'=>'PHY201', 'avg'=>82,'highest'=>95,'lowest'=>58,'passing'=>89,'dist'=>['A'=>6,'B'=>10,'C'=>8,'D'=>2,'F'=>2]],
            ['name'=>'World History',       'code'=>'HIST201','avg'=>88,'highest'=>100,'lowest'=>70,'passing'=>97,'dist'=>['A'=>12,'B'=>11,'C'=>4,'D'=>1,'F'=>0]],
            ['name'=>'English Composition', 'code'=>'ENG101', 'avg'=>79,'highest'=>96,'lowest'=>55,'passing'=>85,'dist'=>['A'=>5,'B'=>9,'C'=>10,'D'=>3,'F'=>3]],
        ];
        $gradeColors=['A'=>'bg-emerald-500','B'=>'bg-sky-500','C'=>'bg-amber-400','D'=>'bg-orange-400','F'=>'bg-rose-500'];
        @endphp

        <div class="space-y-6">
            @foreach($courses as $course)
                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5">
                    <div class="flex flex-wrap items-start justify-between gap-4 mb-5">
                        <div>
                            <p class="font-bold text-slate-900">{{ $course['name'] }}</p>
                            <p class="text-xs font-mono text-slate-400 mt-0.5">{{ $course['code'] }}</p>
                        </div>
                        <div class="flex flex-wrap gap-3 text-xs">
                            <div class="rounded-xl bg-white border border-slate-200 px-3 py-1.5 text-center">
                                <p class="font-black text-emerald-600 text-lg">{{ $course['avg'] }}%</p>
                                <p class="text-slate-400">Average</p>
                            </div>
                            <div class="rounded-xl bg-white border border-slate-200 px-3 py-1.5 text-center">
                                <p class="font-black text-sky-600 text-lg">{{ $course['passing'] }}%</p>
                                <p class="text-slate-400">Passing</p>
                            </div>
                            <div class="rounded-xl bg-white border border-slate-200 px-3 py-1.5 text-center">
                                <p class="font-black text-slate-900 text-lg">{{ $course['highest'] }}</p>
                                <p class="text-slate-400">Highest</p>
                            </div>
                            <div class="rounded-xl bg-white border border-slate-200 px-3 py-1.5 text-center">
                                <p class="font-black text-rose-500 text-lg">{{ $course['lowest'] }}</p>
                                <p class="text-slate-400">Lowest</p>
                            </div>
                        </div>
                    </div>

                    {{-- Grade Distribution Bar --}}
                    @php $total = array_sum($course['dist']); @endphp
                    <div class="space-y-2">
                        @foreach($course['dist'] as $letter => $count)
                            @php $pct = $total > 0 ? round(($count/$total)*100) : 0; @endphp
                            <div class="flex items-center gap-3">
                                <span class="w-5 text-xs font-black text-slate-600 text-center">{{ $letter }}</span>
                                <div class="flex-1 h-5 rounded-full bg-slate-200 overflow-hidden">
                                    <div class="h-full rounded-full {{ $gradeColors[$letter] }} transition-all" style="width: {{ $pct }}%"></div>
                                </div>
                                <div class="flex items-center gap-1.5 w-20 text-xs text-right">
                                    <span class="font-bold text-slate-900">{{ $count }}</span>
                                    <span class="text-slate-400">({{ $pct }}%)</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </section>
</div>
@endsection