@extends('layouts.faculty')
@section('title', 'Forum')
@section('pageDescription', 'Post announcements, answer student questions, and join discussions.')
@section('content')
<div class="space-y-6" x-data="{ newPost: false }">
    {{-- Header --}}
    <section class="rounded-3xl bg-gradient-to-r from-green-500 to-emerald-600 p-6 shadow-md text-white">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold">Faculty Forum</h2>
                <p class="mt-1 text-green-100 text-sm">Post announcements, answer questions, and engage with your students.</p>
            </div>
            <button @click="newPost = !newPost" class="inline-flex items-center gap-2 rounded-2xl bg-white px-5 py-2.5 text-sm font-bold text-green-700 hover:bg-green-50 transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                New Post
            </button>
        </div>
    </section>

    {{-- Stats --}}
    <div class="grid gap-4 sm:grid-cols-3">
        <div class="rounded-3xl bg-white border border-slate-200 shadow-sm p-5 text-center">
            <p class="text-xs uppercase tracking-widest font-semibold text-slate-500">Total Posts</p>
            <p class="mt-3 text-4xl font-black text-slate-900">{{ $stats['total_posts'] }}</p>
        </div>
        <div class="rounded-3xl bg-white border border-slate-200 shadow-sm p-5 text-center">
            <p class="text-xs uppercase tracking-widest font-semibold text-slate-500">Total Replies</p>
            <p class="mt-3 text-4xl font-black text-green-600">{{ $stats['total_replies'] }}</p>
        </div>
        <div class="rounded-3xl bg-white border border-slate-200 shadow-sm p-5 text-center">
            <p class="text-xs uppercase tracking-widest font-semibold text-slate-500">My Posts</p>
            <p class="mt-3 text-4xl font-black text-sky-600">{{ $stats['my_posts'] }}</p>
        </div>
    </div>

    {{-- New Post Form --}}
    <div x-show="newPost" x-cloak x-transition class="rounded-3xl bg-white border border-slate-200 shadow-sm p-6">
        <h3 class="text-base font-bold text-slate-900 mb-4">Create New Post</h3>
        <div class="space-y-4">
            <div><label class="block text-xs font-semibold text-slate-600 mb-1.5">Title</label>
                <input type="text" placeholder="Post title…" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-green-400"></div>
            <div class="grid gap-4 sm:grid-cols-2">
                <div><label class="block text-xs font-semibold text-slate-600 mb-1.5">Tag</label>
                    <select class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
                        @foreach($tags as $tag)<option>{{ $tag }}</option>@endforeach
                    </select></div>
                <div><label class="block text-xs font-semibold text-slate-600 mb-1.5">Category</label>
                    <select class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
                        <option>Announcement</option><option>Discussion</option><option>Resource</option><option>Q&amp;A</option>
                    </select></div>
            </div>
            <div><label class="block text-xs font-semibold text-slate-600 mb-1.5">Message</label>
                <textarea rows="4" placeholder="Write your message…" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-green-400 resize-none"></textarea></div>
            <div class="flex gap-3">
                <button class="rounded-2xl bg-green-600 px-6 py-2.5 text-sm font-bold text-white hover:bg-green-700 transition">Post</button>
                <button @click="newPost = false" class="rounded-2xl border border-slate-200 px-6 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-50 transition">Cancel</button>
            </div>
        </div>
    </div>

    {{-- Threads --}}
    <div class="space-y-4">
        @foreach($threads as $thread)
        <article class="rounded-3xl bg-white border border-slate-200 shadow-sm" x-data="{ open: false }">
            <div class="p-5">
                <div class="flex flex-wrap items-center gap-2 mb-2">
                    <span class="rounded-full bg-green-100 text-green-700 px-2.5 py-0.5 text-xs font-semibold">{{ $thread['tag'] }}</span>
                </div>
                <h4 class="text-base font-bold text-slate-900">{{ $thread['title'] }}</h4>
                <div class="flex items-center gap-2 mt-1.5 text-xs text-slate-500">
                    <span class="h-6 w-6 rounded-full bg-green-600 text-white grid place-items-center font-bold text-xs">{{ strtoupper(substr($thread['author'],0,1)) }}</span>
                    <span class="font-semibold text-slate-700">{{ $thread['author'] }}</span>
                    <span class="rounded-full bg-sky-100 text-sky-700 px-2 py-0.5 font-semibold text-xs">{{ $thread['role'] }}</span>
                    <span>{{ $thread['time'] }}</span>
                </div>
                <p class="mt-3 text-sm text-slate-600">{{ $thread['content'] }}</p>
                <div class="flex items-center gap-4 mt-4 pt-3 border-t border-slate-100">
                    <button @click="open = !open" class="flex items-center gap-1.5 text-xs font-semibold text-slate-600 hover:text-green-600 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                        {{ $thread['reply_count'] }} {{ $thread['reply_count']===1?'Reply':'Replies' }}
                    </button>
                    <button @click="open = !open" class="text-xs font-semibold text-green-600 hover:underline">Reply</button>
                </div>
            </div>
            <div x-show="open" x-cloak x-transition class="border-t border-slate-100 bg-slate-50 rounded-b-3xl px-5 pb-5 pt-4 space-y-3">
                @foreach($thread['replies'] as $reply)
                    <div class="flex gap-3">
                        <div class="h-7 w-7 flex-shrink-0 rounded-full {{ $reply['role']==='Faculty'?'bg-sky-500':'bg-slate-400' }} text-white grid place-items-center text-xs font-bold">{{ strtoupper(substr($reply['author'],0,1)) }}</div>
                        <div class="flex-1 rounded-2xl bg-white border border-slate-200 px-4 py-3">
                            <div class="flex flex-wrap items-center gap-2 text-xs mb-1">
                                <span class="font-semibold text-slate-900">{{ $reply['author'] }}</span>
                                <span class="rounded-full {{ $reply['role']==='Faculty'?'bg-sky-100 text-sky-700':'bg-slate-100 text-slate-600' }} px-2 py-0.5 font-semibold">{{ $reply['role'] }}</span>
                                <span class="text-slate-400">{{ $reply['time'] }}</span>
                            </div>
                            <p class="text-sm text-slate-600">{{ $reply['content'] }}</p>
                        </div>
                    </div>
                @endforeach
                <div class="flex gap-3 pt-2">
                    <div class="h-7 w-7 flex-shrink-0 rounded-full bg-sky-500 text-white grid place-items-center text-xs font-bold">{{ strtoupper(substr(auth()->user()->name??'F',0,1)) }}</div>
                    <div class="flex-1 flex gap-2">
                        <input type="text" placeholder="Write a reply…" class="flex-1 rounded-2xl border border-slate-200 bg-white px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
                        <button class="rounded-2xl bg-green-600 px-4 py-2 text-xs font-bold text-white hover:bg-green-700 transition">Send</button>
                    </div>
                </div>
            </div>
        </article>
        @endforeach
    </div>
</div>
@endsection
