@extends('layouts.admin')

@section('title', 'Grades')
@section('pageDescription', 'Review grade summaries across courses.')

@section('content')
    <div class="space-y-6">
        <div class="grid gap-4 md:grid-cols-2">
            @foreach($grades as $grade)
                <div class="rounded-3xl bg-white p-6 shadow-sm border border-slate-200">
                    <p class="text-sm uppercase tracking-[0.3em] text-slate-400">{{ $grade['course'] }}</p>
                    <p class="mt-4 text-4xl font-semibold text-slate-900">{{ $grade['average'] }}</p>
                    <p class="mt-2 text-sm text-slate-500">{{ $grade['status'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
@endsection