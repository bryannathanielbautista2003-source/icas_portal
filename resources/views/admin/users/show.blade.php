@extends('layouts.admin')
@section('title', 'Student Details')

@section('content')
<div class="max-w-3xl mx-auto mt-8">
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-2xl font-semibold mb-4">{{ $user->name }}</h2>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-slate-500">Email</p>
                <p class="font-medium">{{ $user->email }}</p>
            </div>
            <div>
                <p class="text-sm text-slate-500">Academic Level</p>
                <p class="font-medium">{{ $user->academic_level ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-sm text-slate-500">Course</p>
                <p class="font-medium">{{ $user->course ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-sm text-slate-500">Status</p>
                <p class="font-medium">{{ ucfirst($user->status) }}</p>
            </div>
        </div>

        <div class="mt-6">
            <h3 class="text-lg font-semibold">Proof Documents</h3>
            <p class="text-sm text-slate-500 mt-2">Receipt / Enrollment proof:</p>
            @if($user->receipt_proof)
                <a href="{{ asset('storage/'.$user->receipt_proof) }}" target="_blank" class="text-sky-600 underline">View Receipt Proof</a>
            @else
                <p class="text-sm text-slate-400">No receipt uploaded.</p>
            @endif

            <p class="text-sm text-slate-500 mt-3">Student ID proof:</p>
            @if($user->student_id_proof)
                <a href="{{ asset('storage/'.$user->student_id_proof) }}" target="_blank" class="text-sky-600 underline">View Student ID</a>
            @else
                <p class="text-sm text-slate-400">No student ID uploaded.</p>
            @endif
        </div>

        <div class="mt-6 flex gap-2">
            <a href="{{ route('admin.users.edit', $user->id) }}" class="rounded-lg bg-amber-100 px-4 py-2 text-sm font-semibold text-amber-700">Edit</a>
            <form method="POST" action="{{ route('admin.users.toggle-status', $user->id) }}">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" value="{{ $user->status === 'active' ? 'inactive' : 'active' }}">
                <button type="submit" class="rounded-lg bg-emerald-100 px-4 py-2 text-sm font-semibold text-emerald-700">Toggle Status</button>
            </form>
        </div>
    </div>
</div>
@endsection
