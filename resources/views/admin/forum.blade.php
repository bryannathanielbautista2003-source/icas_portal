@extends('layouts.admin')

@section('title', 'Forum')
@section('pageDescription', 'Discuss system updates and announcements.')

@section('content')
    <div class="grid gap-6">
        @foreach($threads as $thread)
            <div class="rounded-3xl bg-white p-6 shadow-sm border border-slate-200">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <h2 class="text-lg font-semibold text-slate-900">{{ $thread['title'] }}</h2>
                        <p class="mt-2 text-sm text-slate-500">{{ $thread['activity'] }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection