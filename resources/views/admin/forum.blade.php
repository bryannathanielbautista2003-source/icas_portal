@extends('layouts.admin')
@section('title', 'Forum Moderation')
@section('pageDescription', 'Monitor, moderate, and manage all forum posts and replies.')
@section('content')
<div class="space-y-6">
    {{-- Stats --}}
    <div class="grid gap-4 sm:grid-cols-4">
        @foreach([['Total Posts','89','slate'],['Total Replies','247','slate'],['Flagged','3','rose'],['Active Users','28','emerald']] as [$lbl,$val,$clr])
            @php $c = match($clr){'rose'=>['bg-rose-50','border-rose-200','text-rose-700'],'emerald'=>['bg-emerald-50','border-emerald-200','text-emerald-700'],default=>['bg-white','border-slate-200','text-slate-900']}; @endphp
            <div class="rounded-3xl {{ $c[0] }} border {{ $c[1] }} shadow-sm p-6">
                <p class="text-xs uppercase tracking-widest font-semibold text-slate-500">{{ $lbl }}</p>
                <p class="mt-3 text-4xl font-black {{ $c[2] }}">{{ $val }}</p>
            </div>
        @endforeach
    </div>

    <section class="rounded-3xl bg-white border border-slate-200 shadow-sm p-6">
        <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
            <div>
                <h2 class="text-xl font-bold text-slate-900">All Forum Posts</h2>
                <p class="text-sm text-slate-500 mt-1">Review and moderate student and faculty forum activity.</p>
            </div>
            <div class="flex gap-3">
                <select class="rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-green-400">
                    <option>All Roles</option><option>Student</option><option>Faculty</option><option>Admin</option>
                </select>
                <select class="rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-green-400">
                    <option>All Types</option><option>Posts</option><option>Replies</option>
                </select>
                <input type="date" class="rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-green-400">
            </div>
        </div>

        <div class="space-y-3">
            @php
            $posts = [
                ['type'=>'Post',  'author'=>'Ana Reyes',          'role'=>'Student','time'=>'Apr 21 10:30 AM','tag'=>'MATH301','title'=>'Can someone explain integration by parts?','content'=>'I\'m having trouble with this concept...','flagged'=>false],
                ['type'=>'Reply', 'author'=>'Dr. Maria Fernandez','role'=>'Faculty','time'=>'Apr 21 11:00 AM','tag'=>'MATH301','title'=>'Re: Can someone explain integration by parts?','content'=>'Great question! IBP is essentially the reverse of the product rule...','flagged'=>false],
                ['type'=>'Post',  'author'=>'Miguel Santos',       'role'=>'Student','time'=>'Apr 21 12:12 PM','tag'=>'PHY201', 'title'=>'Physics Exam Tips','content'=>'Here are some tips I found useful for the upcoming exam...','flagged'=>false],
                ['type'=>'Post',  'author'=>'Unknown User',        'role'=>'Student','time'=>'Apr 21 01:05 PM','tag'=>'General','title'=>'[Flagged] Spam content detected','content'=>'Click here for free exam answers...','flagged'=>true],
                ['type'=>'Reply', 'author'=>'Sofia Cruz',          'role'=>'Student','time'=>'Apr 21 02:00 PM','tag'=>'PHY201', 'title'=>'Re: Physics Lab Report Format','content'=>'Thank you, what font size should we use?','flagged'=>false],
            ];
            @endphp

            @foreach($posts as $post)
                <article class="rounded-2xl border {{ $post['flagged'] ? 'border-rose-300 bg-rose-50/30' : 'border-slate-200 bg-slate-50' }} p-4">
                    <div class="flex flex-wrap items-start justify-between gap-3">
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-wrap items-center gap-2 mb-1.5">
                                <span class="rounded-full {{ $post['type']==='Reply' ? 'bg-slate-200 text-slate-600' : 'bg-green-100 text-green-700' }} px-2.5 py-0.5 text-xs font-semibold">{{ $post['type'] }}</span>
                                <span class="rounded-full bg-sky-100 text-sky-700 px-2.5 py-0.5 text-xs font-semibold">{{ $post['tag'] }}</span>
                                @if($post['flagged'])
                                    <span class="rounded-full bg-rose-100 text-rose-700 px-2.5 py-0.5 text-xs font-bold">🚩 Flagged</span>
                                @endif
                            </div>
                            <p class="font-semibold text-slate-900 text-sm">{{ $post['title'] }}</p>
                            <p class="text-xs text-slate-500 mt-0.5 truncate max-w-lg">{{ $post['content'] }}</p>
                            <div class="flex items-center gap-2 mt-2 text-xs text-slate-400">
                                <span class="font-semibold text-slate-700">{{ $post['author'] }}</span>
                                @php $rBadge = match($post['role']){'Faculty'=>'bg-sky-100 text-sky-700','Admin'=>'bg-violet-100 text-violet-700',default=>'bg-slate-100 text-slate-600'}; @endphp
                                <span class="rounded-full {{ $rBadge }} px-2 py-0.5 font-semibold">{{ $post['role'] }}</span>
                                <span>{{ $post['time'] }}</span>
                            </div>
                        </div>
                        <div class="flex gap-2 flex-shrink-0">
                            @if($post['flagged'])
                                <button class="rounded-xl bg-rose-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-rose-700 transition">Delete</button>
                            @endif
                            <button class="rounded-xl border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition">Hide</button>
                            @if(!$post['flagged'])
                                <button class="rounded-xl border border-rose-200 bg-white px-3 py-1.5 text-xs font-semibold text-rose-600 hover:bg-rose-50 transition">Remove</button>
                            @endif
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </section>
</div>
@endsection