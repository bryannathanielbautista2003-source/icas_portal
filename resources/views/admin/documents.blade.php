@extends('layouts.admin')

@section('title', 'Documents')
@section('pageDescription', 'Manage site documents, records, and policies.')

@section('content')
    <div class="grid gap-6">
        @foreach($documents as $document)
            <div class="rounded-3xl bg-white p-6 shadow-sm border border-slate-200">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <h2 class="text-lg font-semibold text-slate-900">{{ $document['title'] }}</h2>
                        <p class="mt-2 text-sm text-slate-500">Requested on {{ $document['requested'] }}</p>
                    </div>
                    <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">{{ $document['status'] }}</span>
                </div>
            </div>
        @endforeach
    </div>
@endsection