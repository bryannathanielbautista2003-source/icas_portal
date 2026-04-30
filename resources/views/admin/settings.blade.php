@extends('layouts.admin')
@section('title', 'System Settings')
@section('pageDescription', 'Configure school information, academic term, and platform settings.')
@section('content')
<div class="space-y-6" x-data="{ 
    tab: 'general',
    criteria: [
        { name: 'Quizzes', weight: 40, term: 'Prelim' },
        { name: 'Exams', weight: 40, term: 'Midterm' },
        { name: 'Assignments', weight: 20, term: 'Final' }
    ],
    get totalWeight() {
        return this.criteria.reduce((sum, item) => sum + Number(item.weight || 0), 0);
    },
    addCriterion() {
        this.criteria.push({ name: '', weight: 0, term: 'Prelim' });
    },
    removeCriterion(index) {
        this.criteria.splice(index, 1);
    }
}">
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
            <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-5">
                @csrf
                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Academic Year</label>
                        <input name="academic_year" type="text" value="{{ $schoolSettings['academic_year'] }}" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Current Semester</label>
                        <select name="current_semester" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
                            <option value="First Semester" @selected($schoolSettings['semester']==='First Semester')>First Semester</option>
                            <option value="Second Semester" @selected($schoolSettings['semester']==='Second Semester')>Second Semester</option>
                            <option value="Third Semester" @selected($schoolSettings['semester']==='Third Semester')>Third Semester</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Enrollment Start</label>
                        <input name="enrollment_start" type="date" value="{{ $schoolSettings['enrollment_start'] }}" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Enrollment End</label>
                        <input name="enrollment_end" type="date" value="{{ $schoolSettings['enrollment_end'] }}" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Final Exam Start Date</label>
                        <input name="final_exam_start" type="date" value="{{ $schoolSettings['exam_start'] }}" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
                    </div>
                </div>
                <button type="submit" class="rounded-2xl bg-green-600 px-6 py-3 text-sm font-semibold text-white hover:bg-green-700 transition">Save Term Settings</button>
            </form>
        </section>
    </div>

    {{-- Grading --}}
    <div x-show="tab==='grading'" x-cloak>
        <section class="rounded-3xl bg-white border border-slate-200 shadow-sm p-6">
            <h3 class="text-lg font-bold text-slate-900 mb-5">Grading Configuration</h3>
            <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-5">
                @csrf
                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Passing Grade (%)</label>
                        <input name="passing_grade" type="number" value="{{ $schoolSettings['default_passing_grade'] }}" min="0" max="100" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Grading Scale</label>
                        <input type="hidden" name="grading_scale" value="gpa">
                        <div class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-600">Static GPA (Primary)</div>
                    </div>
                </div>
                <div class="rounded-2xl bg-slate-50 border border-slate-200 p-4">
                    <p class="text-sm font-bold text-slate-700 mb-3">Grade Equivalency (GPA primary)</p>
                    <div class="overflow-x-auto">
                        <table class="text-sm min-w-full">
                            <thead><tr class="text-slate-500 text-xs uppercase"><th class="py-2 pr-6 text-left">GPA</th><th class="py-2 pr-6 text-left">Percent Range</th></tr></thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($schoolSettings['grade_equivalency'] as $row)
                                    <tr><td class="py-2 pr-6 font-bold text-slate-900">{{ $row['gpa'] }}</td><td class="py-2 pr-6 text-slate-600">{{ $row['range'] }}</td></tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                
                {{-- Grading Criteria Configuration --}}
                <div class="rounded-2xl bg-slate-50 border border-slate-200 p-4">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-sm font-bold text-slate-700">Grading Criteria Configuration</p>
                        <button type="button" @click="addCriterion" class="text-xs font-semibold bg-white border border-slate-200 text-slate-700 px-3 py-1.5 rounded-xl hover:bg-slate-100 transition shadow-sm">
                            + Add Criterion
                        </button>
                    </div>
                    
                    <div class="space-y-3">
                        <template x-for="(item, index) in criteria" :key="index">
                            <div class="flex flex-wrap sm:flex-nowrap items-center gap-3 bg-white p-3 rounded-xl border border-slate-200 shadow-sm">
                                <div class="flex-1 min-w-[150px]">
                                    <input type="text" x-model="item.name" placeholder="Component Name (e.g. Quizzes)" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
                                </div>
                                <div class="w-full sm:w-28">
                                    <div class="relative">
                                        <input type="number" x-model.number="item.weight" min="0" max="100" placeholder="0" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400 pr-8">
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-400 text-sm font-medium">%</div>
                                    </div>
                                </div>
                                <div class="w-full sm:w-36">
                                    <select x-model="item.term" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
                                        <option>Prelim</option>
                                        <option>Midterm</option>
                                        <option>Final</option>
                                    </select>
                                </div>
                                <button type="button" @click="removeCriterion(index)" class="text-rose-500 hover:bg-rose-50 p-2 rounded-xl transition" title="Remove">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        </template>
                    </div>

                    <div class="mt-4 pt-4 border-t border-slate-200 flex items-center justify-between">
                        <p class="text-sm font-semibold text-slate-700">Total Percentage:</p>
                        <div class="text-right">
                            <p class="text-lg font-black transition-colors duration-300" :class="totalWeight === 100 ? 'text-green-600' : 'text-rose-600'">
                                <span x-text="totalWeight"></span>%
                            </p>
                        </div>
                    </div>
                    <p x-show="totalWeight !== 100" x-cloak class="text-xs text-rose-500 mt-1 text-right font-medium">
                        Total weight must equal exactly 100% to save.
                    </p>
                </div>

                <button :disabled="totalWeight !== 100" :class="totalWeight === 100 ? 'bg-green-600 hover:bg-green-700 text-white' : 'bg-slate-300 text-slate-500 cursor-not-allowed'" class="rounded-2xl px-6 py-3 text-sm font-semibold transition">Save Grading Settings</button>
            </form>
        </section>
    </div>

    {{-- Appearance --}}
    <div x-show="tab==='appearance'" x-cloak>
        <section class="rounded-3xl bg-white border border-slate-200 shadow-sm p-6">
            <h3 class="text-lg font-bold text-slate-900 mb-5">Appearance</h3>
            <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-4">
                @csrf
                <div class="rounded-2xl bg-slate-50 border border-slate-100 p-4">
                    <p class="font-semibold text-slate-900 text-sm mb-1">Portal Color Theme</p>
                    <p class="text-xs text-slate-500 mb-3">Change the primary color for each portal.</p>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div>
                            <label class="text-xs font-semibold">Admin Portal Primary</label>
                            <input type="color" name="theme_admin_color" value="{{ $schoolSettings['theme_admin_color'] }}" class="w-full h-10 rounded-md border">
                        </div>
                        <div>
                            <label class="text-xs font-semibold">Faculty Portal Primary</label>
                            <input type="color" name="theme_faculty_color" value="{{ $schoolSettings['theme_faculty_color'] }}" class="w-full h-10 rounded-md border">
                        </div>
                        <div>
                            <label class="text-xs font-semibold">Student Portal Primary</label>
                            <input type="color" name="theme_student_color" value="{{ $schoolSettings['theme_student_color'] }}" class="w-full h-10 rounded-md border">
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-between rounded-2xl bg-slate-50 border border-slate-100 px-4 py-3.5">
                    <div>
                        <p class="font-semibold text-slate-900 text-sm">Compact Sidebar</p>
                        <p class="text-xs text-slate-500 mt-0.5">Show only icons in the sidebar for more content space.</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="compact_sidebar" class="sr-only peer" {{ old('compact_sidebar', false) ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-slate-200 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:rounded-full after:h-5 after:w-5 after:transition peer-checked:bg-green-600"></div>
                    </label>
                </div>
                <div class="mt-5">
                    <button type="submit" class="rounded-2xl bg-green-600 px-6 py-3 text-sm font-semibold text-white hover:bg-green-700 transition">Save Appearance</button>
                </div>
            </form>
        </section>
    </div>
</div>
@endsection
