@extends('layouts.student')
@section('title', 'Notifications')
@section('pageDescription', 'Stay updated on grades, announcements, and document requests.')
@section('content')
<div class="space-y-6">
    <section class="rounded-3xl bg-white border border-slate-200 shadow-sm p-6">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h2 class="text-xl font-bold text-slate-900">Notifications</h2>
                <p class="text-sm text-slate-500 mt-1">
                    @if($unreadCount > 0)
                        You have <span class="font-bold text-green-600">{{ $unreadCount }} unread</span> notification{{ $unreadCount !== 1 ? 's' : '' }}.
                    @else
                        All notifications have been read.
                    @endif
                </p>
            </div>
            <button class="rounded-2xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-50 transition">Mark all as read</button>
        </div>
    </section>

    @php
        $typeConfig = [
            'grade'        => ['icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>', 'bg' => 'bg-emerald-100', 'text' => 'text-emerald-600', 'label' => 'Grade'],
            'document'     => ['icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>', 'bg' => 'bg-sky-100', 'text' => 'text-sky-600', 'label' => 'Document'],
            'announcement' => ['icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19a1 1 0 001.447.894L18 17h2a1 1 0 001-1V8a1 1 0 00-1-1h-2l-5.553-2.894A1 1 0 0011 5.882z"></path></svg>', 'bg' => 'bg-amber-100', 'text' => 'text-amber-600', 'label' => 'Announcement'],
            'enrollment'   => ['icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>', 'bg' => 'bg-green-100', 'text' => 'text-green-600', 'label' => 'Enrollment'],
            'forum'        => ['icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path></svg>', 'bg' => 'bg-violet-100', 'text' => 'text-violet-600', 'label' => 'Forum'],
        ];
    @endphp

    <div class="space-y-3">
        @foreach($notifications as $notif)
            @php $cfg = $typeConfig[$notif['type']] ?? $typeConfig['announcement']; @endphp
            <div class="flex items-start gap-4 rounded-3xl border {{ $notif['read'] ? 'bg-white border-slate-200' : 'bg-green-50 border-green-200' }} shadow-sm px-5 py-4 transition-all">
                <div class="h-11 w-11 rounded-2xl {{ $cfg['bg'] }} {{ $cfg['text'] }} grid place-items-center flex-shrink-0 mt-0.5">
                    {!! $cfg['icon'] !!}
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex flex-wrap items-center gap-2 mb-1">
                        <p class="font-bold text-slate-900 {{ $notif['read'] ? '' : 'text-green-900' }}">{{ $notif['title'] }}</p>
                        <span class="inline-flex rounded-full bg-slate-100 px-2 py-0.5 text-xs font-semibold text-slate-600">{{ $cfg['label'] }}</span>
                        @if(!$notif['read'])
                            <span class="inline-flex h-2 w-2 rounded-full bg-green-500"></span>
                        @endif
                    </div>
                    <p class="text-sm text-slate-600 leading-relaxed">{{ $notif['body'] }}</p>
                </div>
                <span class="flex-shrink-0 text-xs text-slate-400 whitespace-nowrap">{{ $notif['time'] }}</span>
            </div>
        @endforeach
    </div>
</div>
@endsection
