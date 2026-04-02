@extends('layouts.student')

@section('title', 'Forum')
@section('pageDescription', 'Discuss with classmates and teachers.')

@section('content')
    <div class="grid gap-6">
        <div class="rounded-3xl bg-white p-6 shadow-sm border border-slate-200">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                <div>
                    <h2 class="text-xl font-semibold text-slate-900">Student Forum</h2>
                    <p class="mt-2 text-sm text-slate-500">Discuss with classmates and teachers.</p>
                </div>
                <div class="max-w-2xl w-full">
                    <label class="block text-sm font-medium text-slate-700">New Discussion</label>
                    <textarea rows="3" class="mt-3 w-full rounded-3xl border border-slate-200 bg-slate-50 p-4 text-sm text-slate-700 focus:border-slate-900 focus:outline-none" placeholder="Start a discussion or ask a question..."></textarea>
                    <div class="mt-4 flex items-center justify-between gap-4 flex-wrap">
                        <select class="grow rounded-3xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 focus:border-slate-900 focus:outline-none">
                            <option>All Courses</option>
                            @foreach($courses as $course)
                                <option>{{ $course['name'] }}</option>
                            @endforeach
                        </select>
                        <button class="inline-flex items-center justify-center rounded-3xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white hover:bg-slate-800 transition">Post Message</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid gap-6 xl:grid-cols-[2fr_1fr]">
            <section class="rounded-3xl bg-white p-6 shadow-sm border border-slate-200 space-y-4">
                @foreach($posts as $post)
                    <article class="rounded-3xl bg-slate-50 p-5 border border-slate-200">
                        <div class="flex items-start gap-4">
                            <div class="h-10 w-10 rounded-full bg-slate-900 text-white grid place-items-center font-semibold">{{ strtoupper(substr($post['author'],0,1) . (strpos($post['author'],' ') ? substr($post['author'], strpos($post['author'],' ')+1,1) : '')) }}</div>
                            <div class="grow">
                                <div class="flex flex-wrap items-center gap-2 text-sm text-slate-500">
                                    <span class="font-semibold text-slate-900">{{ $post['author'] }}</span>
                                    <span class="rounded-full bg-slate-200 px-2 py-1">{{ $post['role'] }}</span>
                                    <span>{{ $post['time'] }}</span>
                                </div>
                                <p class="mt-3 text-sm text-slate-600">{{ $post['content'] }}</p>
                            </div>
                        </div>
                    </article>
                @endforeach
            </section>

            <aside class="rounded-3xl bg-white p-6 shadow-sm border border-slate-200 space-y-4">
                <div>
                    <h3 class="text-lg font-semibold text-slate-900">Forum Guidelines</h3>
                    <ul class="mt-4 space-y-2 text-sm text-slate-500">
                        <li>• Be respectful to all members</li>
                        <li>• Stay on topic and relevant to courses</li>
                        <li>• No spam or inappropriate content</li>
                        <li>• Help others when you can</li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-slate-900">Active Topics</h3>
                    <div class="mt-4 space-y-3">
                        @foreach($topics as $topic)
                            <div class="rounded-3xl bg-slate-50 p-4 border border-slate-200">
                                <p class="text-sm font-semibold text-slate-900">{{ $topic['title'] }}</p>
                                <p class="mt-2 text-sm text-slate-500">{{ $topic['count'] }} discussion{{ $topic['count'] !== 1 ? 's' : '' }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </aside>
        </div>
    </div>
@endsection