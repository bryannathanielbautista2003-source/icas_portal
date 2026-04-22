@extends('layouts.student')
@section('title', 'Forum')
@section('pageDescription', 'Discuss with classmates and instructors. Ask questions, share insights.')
@section('content')
<div class="space-y-6" x-data="{ newPost: false }">
    {{-- Header --}}
    <section class="rounded-3xl bg-gradient-to-r from-green-500 to-emerald-600 p-6 shadow-md text-white">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold">Student Forum</h2>
                <p class="mt-1 text-green-100 text-sm">Ask questions, share insights, and discuss with your peers and faculty.</p>
            </div>
            <button @click="newPost = !newPost"
                    class="inline-flex items-center gap-2 rounded-2xl bg-white px-5 py-2.5 text-sm font-bold text-green-700 hover:bg-green-50 transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                New Post
            </button>
        </div>
    </section>

    {{-- New Post Form --}}
    <div x-show="newPost" x-cloak x-transition class="rounded-3xl bg-white border border-slate-200 shadow-sm p-6">
        <h3 class="text-base font-bold text-slate-900 mb-4">Start a New Discussion</h3>
        <div class="space-y-4">
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1.5">Title</label>
                <input type="text" placeholder="What's your topic?" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
            </div>
            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Course Tag</label>
                    <select class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
                        <option>General</option><option>MATH301 — Advanced Mathematics</option><option>PHY201 — Physics I</option><option>HIST201 — World History</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Category</label>
                    <select class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
                        <option>Question</option><option>Discussion</option><option>Resource</option><option>Announcement</option>
                    </select>
                </div>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1.5">Message</label>
                <textarea rows="4" placeholder="Write your question or discussion post here..." class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-green-400 resize-none"></textarea>
            </div>
            <div class="flex gap-3">
                <button class="rounded-2xl bg-green-600 px-6 py-2.5 text-sm font-bold text-white hover:bg-green-700 transition">Post Discussion</button>
                <button @click="newPost = false" class="rounded-2xl border border-slate-200 px-6 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-50 transition">Cancel</button>
            </div>
        </div>
    </div>

    <div class="grid gap-6 xl:grid-cols-[1fr_280px]">
        {{-- Threads --}}
        <div class="space-y-4">
            @php
            $threads = [
                ['id'=>1,'title'=>'Can someone explain integration by parts?','tag'=>'MATH301','category'=>'Question','author'=>'Ana Reyes','role'=>'Student','time'=>'2 hours ago','content'=>'I\'m having trouble understanding when to use integration by parts vs substitution. Can anyone help?','replies'=>[['author'=>'Dr. Maria Fernandez','role'=>'Faculty','time'=>'1 hour ago','content'=>'Great question! Integration by parts is used when the integrand is a product of two functions...'],['author'=>'Miguel Santos','role'=>'Student','time'=>'45 min ago','content'=>'I found this helpful: IBP is basically the reverse of the product rule.']]],
                ['id'=>2,'title'=>'Physics Lab Report Format','tag'=>'PHY201','category'=>'Resource','author'=>'Mr. Paulo Navarro','role'=>'Faculty','time'=>'Yesterday','content'=>'Please follow the official lab report format attached below. Include: Objectives, Hypothesis, Materials, Procedure, Data, Analysis, Conclusion.','replies'=>[['author'=>'Sofia Cruz','role'=>'Student','time'=>'23 hours ago','content'=>'Thank you! What font size should we use?']]],
                ['id'=>3,'title'=>'Mid-term date confirmed — April 30','tag'=>'General','category'=>'Announcement','author'=>'Admin User','role'=>'Admin','time'=>'2 days ago','content'=>'The mid-term examinations are scheduled for April 30, 2026. Rooms will be posted by April 25.','replies'=>[]],
            ];
            @endphp

            @foreach($threads as $thread)
            <article class="rounded-3xl bg-white border border-slate-200 shadow-sm" x-data="{ open: false }">
                <div class="p-5">
                    <div class="flex flex-wrap items-start justify-between gap-3">
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-wrap items-center gap-2 mb-2">
                                <span class="rounded-full bg-green-100 text-green-700 px-2.5 py-0.5 text-xs font-semibold">{{ $thread['tag'] }}</span>
                                <span class="rounded-full bg-slate-100 text-slate-600 px-2.5 py-0.5 text-xs font-medium">{{ $thread['category'] }}</span>
                            </div>
                            <h4 class="text-base font-bold text-slate-900">{{ $thread['title'] }}</h4>
                            <div class="flex items-center gap-2 mt-1.5 text-xs text-slate-500">
                                @php $roleBadge = match($thread['role']) {'Faculty'=>'bg-sky-100 text-sky-700','Admin'=>'bg-violet-100 text-violet-700',default=>'bg-slate-100 text-slate-600'}; @endphp
                                <span class="h-6 w-6 rounded-full bg-green-600 text-white grid place-items-center font-bold text-xs">{{ strtoupper(substr($thread['author'],0,1)) }}</span>
                                <span class="font-semibold text-slate-700">{{ $thread['author'] }}</span>
                                <span class="inline-flex rounded-full {{ $roleBadge }} px-2 py-0.5 text-xs font-semibold">{{ $thread['role'] }}</span>
                                <span>{{ $thread['time'] }}</span>
                            </div>
                            <p class="mt-3 text-sm text-slate-600">{{ $thread['content'] }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 mt-4 pt-3 border-t border-slate-100">
                        <button @click="open = !open" class="flex items-center gap-1.5 text-xs font-semibold text-slate-600 hover:text-green-600 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                            {{ count($thread['replies']) }} {{ count($thread['replies']) === 1 ? 'Reply' : 'Replies' }}
                        </button>
                        <button @click="open = !open" class="text-xs font-semibold text-green-600 hover:underline">Reply</button>
                    </div>
                </div>

                {{-- Replies --}}
                <div x-show="open" x-cloak x-transition class="border-t border-slate-100 bg-slate-50 rounded-b-3xl px-5 pb-5 pt-4 space-y-3">
                    @foreach($thread['replies'] as $reply)
                        @php $rBadge = match($reply['role']) {'Faculty'=>'bg-sky-100 text-sky-700','Admin'=>'bg-violet-100 text-violet-700',default=>'bg-slate-100 text-slate-600'}; @endphp
                        <div class="flex gap-3">
                            <div class="h-7 w-7 flex-shrink-0 rounded-full bg-slate-400 text-white grid place-items-center text-xs font-bold">{{ strtoupper(substr($reply['author'],0,1)) }}</div>
                            <div class="flex-1 rounded-2xl bg-white border border-slate-200 px-4 py-3">
                                <div class="flex flex-wrap items-center gap-2 text-xs mb-1">
                                    <span class="font-semibold text-slate-900">{{ $reply['author'] }}</span>
                                    <span class="rounded-full {{ $rBadge }} px-2 py-0.5 font-semibold">{{ $reply['role'] }}</span>
                                    <span class="text-slate-400">{{ $reply['time'] }}</span>
                                </div>
                                <p class="text-sm text-slate-600">{{ $reply['content'] }}</p>
                            </div>
                        </div>
                    @endforeach
                    {{-- Reply compose --}}
                    <div class="flex gap-3 pt-2">
                        <div class="h-7 w-7 flex-shrink-0 rounded-full bg-green-600 text-white grid place-items-center text-xs font-bold">{{ strtoupper(substr(auth()->user()->name ?? 'S',0,1)) }}</div>
                        <div class="flex-1 flex gap-2">
                            <input type="text" placeholder="Write a reply…" class="flex-1 rounded-2xl border border-slate-200 bg-white px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
                            <button class="rounded-2xl bg-green-600 px-4 py-2 text-xs font-bold text-white hover:bg-green-700 transition">Send</button>
                        </div>
                    </div>
                </div>
            </article>
            @endforeach
        </div>

        {{-- Sidebar --}}
        <aside class="space-y-4">
            <section class="rounded-3xl bg-white border border-slate-200 shadow-sm p-5">
                <h3 class="text-sm font-bold text-slate-900 mb-3">Forum Guidelines</h3>
                <ul class="space-y-2 text-xs text-slate-500">
                    <li class="flex items-start gap-2"><span class="mt-0.5 text-green-500">✓</span> Be respectful to all members</li>
                    <li class="flex items-start gap-2"><span class="mt-0.5 text-green-500">✓</span> Stay on topic and course-relevant</li>
                    <li class="flex items-start gap-2"><span class="mt-0.5 text-green-500">✓</span> No spam or inappropriate content</li>
                    <li class="flex items-start gap-2"><span class="mt-0.5 text-green-500">✓</span> Help others when you can</li>
                    <li class="flex items-start gap-2"><span class="mt-0.5 text-amber-500">!</span> Flag violations using the report button</li>
                </ul>
            </section>
            <section class="rounded-3xl bg-white border border-slate-200 shadow-sm p-5">
                <h3 class="text-sm font-bold text-slate-900 mb-3">Active Topics</h3>
                <div class="space-y-2">
                    @foreach([['MATH301','Advanced Mathematics',3],['PHY201','Physics I',2],['HIST201','World History',1],['General','General',4]] as [$code,$name,$cnt])
                    <div class="flex items-center justify-between text-xs">
                        <span class="font-medium text-slate-700">{{ $name }}</span>
                        <span class="rounded-full bg-green-100 text-green-700 px-2 py-0.5 font-bold">{{ $cnt }}</span>
                    </div>
                    @endforeach
                </div>
            </section>
        </aside>
    </div>
</div>
@endsection