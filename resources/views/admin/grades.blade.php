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
            <div class="flex items-center gap-3">
                <form action="{{ route('admin.grades') }}" method="GET" class="flex items-center gap-2">
                    <select name="subject" class="rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm font-medium text-slate-700 outline-none transition focus:border-slate-300 focus:bg-white" onchange="this.form.submit()">
                        <option value="">All Subjects</option>
                        @foreach($subjectOptions as $option)
                            <option value="{{ $option['code'] }}" @selected($subjectFilter === $option['code'])>
                                {{ $option['name'] }} ({{ $option['code'] }})
                            </option>
                        @endforeach
                    </select>
                </form>
                <a href="{{ route('admin.grades.export', ['subject' => $subjectFilter]) }}" class="inline-flex items-center gap-2 rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white hover:bg-slate-800 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Export CSV
                </a>
            </div>
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
        $gradeColors=['A'=>'bg-emerald-500','B'=>'bg-sky-500','C'=>'bg-amber-400','D'=>'bg-orange-400','F'=>'bg-rose-500'];
        @endphp

        <div class="space-y-6">
            @forelse($courses as $course)
                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5">
                    <div class="flex flex-wrap items-start justify-between gap-4 mb-5">
                        <div class="flex items-start gap-4">
                            <div>
                                <p class="font-bold text-slate-900">{{ $course['name'] }}</p>
                                <p class="text-xs font-mono text-slate-400 mt-0.5">{{ $course['code'] }}</p>
                            </div>
                            <button type="button" onclick="exportSubjectCSV('{{ $course['id'] ?? $course['code'] }}')" class="inline-flex items-center gap-1.5 rounded-xl border border-slate-200 bg-white px-2.5 py-1 text-xs font-semibold text-slate-700 hover:bg-slate-100 transition shadow-sm" title="Export CSV for this subject">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                Export
                            </button>
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
            @empty
                <div class="text-center py-6 text-slate-500">No graded courses found.</div>
            @endforelse
        </div>
    </section>

    {{-- Unverified Grades --}}
    @if($unverifiedGrades->isNotEmpty())
    <section class="rounded-3xl bg-white border border-slate-200 shadow-sm p-6">
        <h3 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
            Unverified Grades
            <span class="bg-amber-100 text-amber-700 text-xs px-2 py-0.5 rounded-full">{{ $unverifiedGrades->count() }} pending</span>
        </h3>
        
        <div class="overflow-x-auto rounded-2xl border border-slate-200">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-5 py-3.5 font-semibold text-slate-500 text-xs uppercase tracking-wide">Student</th>
                        <th class="px-5 py-3.5 font-semibold text-slate-500 text-xs uppercase tracking-wide">Course</th>
                        <th class="px-5 py-3.5 font-semibold text-slate-500 text-xs uppercase tracking-wide">Grade</th>
                        <th class="px-5 py-3.5 font-semibold text-slate-500 text-xs uppercase tracking-wide text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($unverifiedGrades as $grade)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-5 py-3.5 font-semibold text-slate-900">{{ $grade->user->name ?? 'Unknown' }}</td>
                        <td class="px-5 py-3.5 text-slate-700">{{ $grade->module_name }} <span class="text-xs text-slate-400">({{ $grade->module_code }})</span></td>
                        <td class="px-5 py-3.5 text-slate-900 font-bold">{{ $grade->grade_percent }}%</td>
                        <td class="px-5 py-3.5 text-right">
                            <form action="{{ route('admin.grades.verify', $grade->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="text-xs font-semibold bg-emerald-100 text-emerald-700 px-3 py-1.5 rounded-xl hover:bg-emerald-200 transition">Verify</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
    @endif
</div>

<script>
    function exportSubjectCSV(subjectCode) {
        window.location.href = "{{ route('admin.grades.export') }}?subject=" + encodeURIComponent(subjectCode);
    }
</script>
@endsection