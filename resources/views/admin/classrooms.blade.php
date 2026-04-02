@extends('layouts.admin')

@section('title', 'Classrooms')
@section('pageDescription', 'Review classroom assignments and academic programs.')

@section('content')
    <div class="grid gap-6">
        <div class="rounded-3xl bg-white p-6 shadow-sm border border-slate-200 overflow-x-auto">
            <table class="min-w-full text-left text-sm text-slate-700">
                <thead>
                    <tr>
                        <th class="px-4 py-4 font-semibold text-slate-500">Classroom</th>
                        <th class="px-4 py-4 font-semibold text-slate-500">Teacher</th>
                        <th class="px-4 py-4 font-semibold text-slate-500">Students</th>
                        <th class="px-4 py-4 font-semibold text-slate-500">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @foreach($classrooms as $classroom)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-4 font-medium text-slate-900">{{ $classroom['name'] }}</td>
                            <td class="px-4 py-4">{{ $classroom['teacher'] }}</td>
                            <td class="px-4 py-4">{{ $classroom['students'] }}</td>
                            <td class="px-4 py-4">{{ $classroom['status'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection