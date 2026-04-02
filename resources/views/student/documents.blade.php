@extends('layouts.student')

@section('title', 'Documents')
@section('pageDescription', 'Request and track your academic documents.')

@section('content')
    <div class="space-y-6">
        <div class="grid gap-4 md:grid-cols-4">
            @foreach($summary as $item)
                <div class="rounded-3xl bg-white p-6 shadow-sm border border-slate-200 text-center">
                    <p class="text-sm uppercase tracking-[0.3em] text-slate-400">{{ $item['label'] }}</p>
                    <p class="mt-4 text-3xl font-semibold text-slate-900">{{ $item['value'] }}</p>
                </div>
            @endforeach
        </div>

        <div class="rounded-3xl bg-white p-6 shadow-sm border border-slate-200">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-xl font-semibold text-slate-900">Document Requests</h2>
                    <p class="mt-2 text-sm text-slate-500">Request and track your academic documents.</p>
                </div>
                <button class="inline-flex items-center justify-center rounded-3xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white hover:bg-slate-800 transition">New Request</button>
            </div>

            <div class="mt-6 space-y-4">
                @foreach($requests as $request)
                    <article class="rounded-3xl bg-slate-50 p-6 border border-slate-200">
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <h3 class="text-lg font-semibold text-slate-900">{{ $request['title'] }}</h3>
                                <p class="mt-1 text-sm text-slate-500">Purpose: {{ $request['purpose'] }}</p>
                            </div>
                            <span class="rounded-full {{ $request['status'] === 'Approved' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }} px-3 py-1 text-sm font-semibold">{{ $request['status'] }}</span>
                        </div>
                        <p class="mt-4 text-sm text-slate-500">Requested on {{ $request['requested'] }}</p>
                        @if($request['note'])
                            <p class="mt-3 rounded-3xl bg-white p-4 text-sm text-slate-600 border border-slate-200">Note: {{ $request['note'] }}</p>
                        @endif
                    </article>
                @endforeach
            </div>
        </div>
    </div>
@endsection