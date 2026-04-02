@extends('layouts.faculty')

@section('title', 'My Students')
@section('pageDescription', 'Manage student information and records')

@section('content')
    <div class="grid gap-6">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <h2 class="text-2xl font-semibold text-slate-900">Students</h2>
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                <div class="relative w-full sm:w-[360px]">
                    <input type="text" placeholder="Search students..." class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-5 py-3 text-sm text-slate-700 focus:border-slate-900 focus:outline-none" />
                </div>
                <button class="rounded-3xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white hover:bg-slate-800 transition">Add Student</button>
            </div>
        </div>

        <div class="rounded-3xl bg-white p-6 shadow-sm border border-slate-200 overflow-x-auto">
            <table class="min-w-full text-left text-sm text-slate-700">
                <thead>
                    <tr>
                        <th class="px-4 py-4 font-semibold text-slate-500">Name</th>
                        <th class="px-4 py-4 font-semibold text-slate-500">Email</th>
                        <th class="px-4 py-4 font-semibold text-slate-500">Grade</th>
                        <th class="px-4 py-4 font-semibold text-slate-500">Class</th>
                        <th class="px-4 py-4 font-semibold text-slate-500">Enrollment Date</th>
                        <th class="px-4 py-4 font-semibold text-slate-500">Status</th>
                        <th class="px-4 py-4 font-semibold text-slate-500">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @foreach($students as $student)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 rounded-full bg-slate-100 grid place-items-center text-sm font-semibold text-slate-700">{{ $student['initials'] }}</div>
                                    <div>
                                        <p class="font-medium text-slate-900">{{ $student['name'] }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4">{{ $student['email'] }}</td>
                            <td class="px-4 py-4">{{ $student['grade'] }}</td>
                            <td class="px-4 py-4">{{ $student['class'] }}</td>
                            <td class="px-4 py-4">{{ $student['enrolled'] }}</td>
                            <td class="px-4 py-4">
                                <span class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700 uppercase">{{ $student['status'] }}</span>
                            </td>
                            <td class="px-4 py-4">
                                <a href="#" class="text-sm font-semibold text-slate-900 hover:text-slate-700">View</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection