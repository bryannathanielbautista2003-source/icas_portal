@extends('layouts.admin')
@section('title', 'System Settings')
@section('pageDescription', 'Configure school information, academic term, and platform settings.')
@section('content')
<div class="space-y-6" x-data="{ tab: 'general' }">
    <section class="rounded-3xl bg-white border border-slate-200 shadow-sm p-2 flex gap-2 flex-wrap">
        @foreach(['general'=>'General','academic'=>'Academic Term','grading'=>'Grading','appearance'=>'Appearance'] as $k=>$l)
            <button @click="tab='{{ $k }}'" :class="tab==='{{ $k }}'?'bg-green-600 text-white shadow-sm':'text-slate-600 hover:bg-slate-100'" class="rounded-2xl px-5 py-2.5 text-sm font-semibold transition">{{ $l }}</button>
        @endforeach
    </section>

    {{-- General --}}
    <div x-show="tab==='general'" x-cloak>
        <section class="rounded-3xl bg-white border border-slate-200 shadow-sm p-6">
            <h3 class="text-lg font-bold text-slate-900 mb-5">School Information</h3>
            <form class="space-y-5">
                <div class="grid gap-5 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">School / Institution Name</label>
                        <input type="text" value="{{ $schoolSettings['school_name'] }}" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">School Code</label>
                        <input type="text" value="{{ $schoolSettings['school_code'] }}" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Timezone</label>
                        <select class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
                            <option selected>Asia/Manila (UTC+8)</option>
                            <option>UTC</option>
                        </select>
                    </div>
                </div>
                <button class="rounded-2xl bg-green-600 px-6 py-3 text-sm font-semibold text-white hover:bg-green-700 transition">Save Changes</button>
            </form>
        </section>
    </div>

    {{-- Academic Term --}}
    <div x-show="tab==='academic'" x-cloak>
        <section class="rounded-3xl bg-white border border-slate-200 shadow-sm p-6">
            <h3 class="text-lg font-bold text-slate-900 mb-5">Academic Term Settings</h3>
            <form class="space-y-5">
                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Academic Year</label>
                        <input type="text" value="{{ $schoolSettings['academic_year'] }}" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Current Semester</label>
                        <select class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
                            <option>First Semester</option>
                            <option selected>Second Semester</option>
                            <option>Summer</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Enrollment Start</label>
                        <input type="date" value="2025-01-06" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Enrollment End</label>
                        <input type="date" value="2025-01-31" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Final Exam Start Date</label>
                        <input type="date" value="2025-03-17" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
                    </div>
                </div>
                <button class="rounded-2xl bg-green-600 px-6 py-3 text-sm font-semibold text-white hover:bg-green-700 transition">Save Term Settings</button>
            </form>
        </section>
    </div>

    {{-- Grading --}}
    <div x-show="tab==='grading'" x-cloak>
        <section class="rounded-3xl bg-white border border-slate-200 shadow-sm p-6">
            <h3 class="text-lg font-bold text-slate-900 mb-5">Grading Configuration</h3>
            <form class="space-y-5">
                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Passing Grade (%)</label>
                        <input type="number" value="75" min="0" max="100" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Grading Scale</label>
                        <select class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
                            <option selected>Percentage (0–100%)</option>
                            <option>Letter Grade (A–F)</option>
                            <option>GPA (0.0–4.0)</option>
                        </select>
                    </div>
                </div>
                <div class="rounded-2xl bg-slate-50 border border-slate-200 p-4">
                    <p class="text-sm font-bold text-slate-700 mb-3">Grade Equivalency Table</p>
                    <div class="overflow-x-auto">
                        <table class="text-sm min-w-full">
                            <thead><tr class="text-slate-500 text-xs uppercase"><th class="py-2 pr-6 text-left">Letter</th><th class="py-2 pr-6 text-left">Range</th><th class="py-2 text-left">Description</th></tr></thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach([['A','90–100','Excellent'],['B','80–89','Good'],['C','75–79','Satisfactory'],['D','70–74','Needs Improvement'],['F','Below 70','Failed']] as [$l,$r,$d])
                                    <tr><td class="py-2 pr-6 font-bold text-slate-900">{{ $l }}</td><td class="py-2 pr-6 text-slate-600">{{ $r }}</td><td class="py-2 text-slate-500">{{ $d }}</td></tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <button class="rounded-2xl bg-green-600 px-6 py-3 text-sm font-semibold text-white hover:bg-green-700 transition">Save Grading Settings</button>
            </form>
        </section>
    </div>

    {{-- Appearance --}}
    <div x-show="tab==='appearance'" x-cloak>
        <section class="rounded-3xl bg-white border border-slate-200 shadow-sm p-6">
            <h3 class="text-lg font-bold text-slate-900 mb-5">Appearance</h3>
            <div class="space-y-4">
                <div class="rounded-2xl bg-slate-50 border border-slate-100 p-4">
                    <p class="font-semibold text-slate-900 text-sm mb-1">Portal Color Theme</p>
                    <p class="text-xs text-slate-500 mb-3">Change the primary color for all portals.</p>
                    <div class="flex flex-wrap gap-3">
                        @foreach([['bg-green-600','Green (Default)',true],['bg-blue-600','Blue',false],['bg-violet-600','Purple',false],['bg-slate-900','Dark',false]] as [$bg,$label,$active])
                            <button class="flex items-center gap-2 rounded-2xl border-2 {{ $active ? 'border-green-600' : 'border-transparent' }} bg-white px-3 py-2 hover:border-slate-300 transition">
                                <span class="h-5 w-5 rounded-full {{ $bg }}"></span>
                                <span class="text-xs font-semibold text-slate-700">{{ $label }}</span>
                            </button>
                        @endforeach
                    </div>
                </div>
                <div class="flex items-center justify-between rounded-2xl bg-slate-50 border border-slate-100 px-4 py-3.5">
                    <div>
                        <p class="font-semibold text-slate-900 text-sm">Compact Sidebar</p>
                        <p class="text-xs text-slate-500 mt-0.5">Show only icons in the sidebar for more content space.</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer">
                        <div class="w-11 h-6 bg-slate-200 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:rounded-full after:h-5 after:w-5 after:transition peer-checked:bg-green-600"></div>
                    </label>
                </div>
            </div>
            <div class="mt-5">
                <button class="rounded-2xl bg-green-600 px-6 py-3 text-sm font-semibold text-white hover:bg-green-700 transition">Apply Changes</button>
            </div>
        </section>
    </div>
</div>
@endsection
