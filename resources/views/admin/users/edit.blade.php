@extends('layouts.admin')
@section('title', 'Edit Student')

@section('content')
<div class="max-w-2xl mx-auto mt-8">
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-2xl font-semibold mb-4">Edit Student</h2>

        <form method="POST" action="{{ route('admin.users.edit', $user->id) }}">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700">Full Name</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="mt-1 block w-full rounded-md border-gray-300" required>
                @error('name') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700">Academic Level</label>
                <select name="academic_level" class="mt-1 block w-full rounded-md border-gray-300" required>
                    <option value="">Select level</option>
                    @foreach(['Senior High School','1st Year College','2nd Year College','3rd Year College'] as $lvl)
                        <option value="{{ $lvl }}" @selected(old('academic_level', $user->academic_level) === $lvl)>{{ $lvl }}</option>
                    @endforeach
                </select>
                @error('academic_level') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700">Course</label>
                <input type="text" name="course" value="{{ old('course', $user->course) }}" class="mt-1 block w-full rounded-md border-gray-300">
                @error('course') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
            </div>

            <div class="flex justify-end">
                <button type="submit" class="rounded-xl bg-green-600 px-4 py-2 text-sm font-semibold text-white">Save</button>
            </div>
        </form>
    </div>
</div>
@endsection
