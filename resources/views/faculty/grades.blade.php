@extends('layouts.faculty')

@section('title', 'Grade Management')
@section('pageDescription', 'Track and manage student attendance')

@section('content')
    <div class="space-y-6">
        <div class="grid gap-4 md:grid-cols-4">
            @foreach($summary as $item)
                <div class="rounded-3xl bg-white p-6 shadow-sm border border-slate-200">
                    <p class="text-sm uppercase tracking-[0.3em] text-slate-400">{{ $item['label'] }}</p>
                    <p class="mt-4 text-4xl font-semibold text-slate-900">{{ $item['value'] }}</p>
                </div>
            @endforeach
        </div>

        <div class="rounded-3xl bg-white p-6 shadow-sm border border-slate-200">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h2 class="text-2xl font-semibold text-slate-900">Attendance Records</h2>
                    <p class="mt-2 text-sm text-slate-500">View recent student attendance updates.</p>
                </div>
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                    <input type="text" placeholder="Search students..." class="rounded-3xl border border-slate-200 bg-slate-50 px-5 py-3 text-sm text-slate-700 focus:border-slate-900 focus:outline-none" />
                    <button class="rounded-3xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white hover:bg-slate-800 transition">Export</button>
                </div>
            </div>

            <div class="mt-6 overflow-x-auto">
                <table class="min-w-full text-left text-sm text-slate-700">
                    <thead>
                        <tr>
                            <th class="px-4 py-4 font-semibold text-slate-500">Student Name</th>
                            <th class="px-4 py-4 font-semibold text-slate-500">Class</th>
                            <th class="px-4 py-4 font-semibold text-slate-500">Date</th>
                            <th class="px-4 py-4 font-semibold text-slate-500">Status</th>
                            <th class="px-4 py-4 font-semibold text-slate-500">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @foreach($records as $record)
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="h-10 w-10 rounded-full bg-slate-100 grid place-items-center text-sm font-semibold text-slate-700">{{ $record['initials'] }}</div>
                                        <span class="font-medium text-slate-900">{{ $record['name'] }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-4">{{ $record['class'] }}</td>
                                <td class="px-4 py-4">{{ $record['date'] }}</td>
                                <td class="px-4 py-4">
                                    <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $record['status'] === 'Present' ? 'bg-emerald-100 text-emerald-700' : ($record['status'] === 'Late' ? 'bg-amber-100 text-amber-700' : 'bg-rose-100 text-rose-700') }}">{{ $record['status'] }}</span>
                                </td>
                                <td class="px-4 py-4">
                                    <button class="text-sm font-semibold text-slate-900 hover:text-slate-700">Update</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection