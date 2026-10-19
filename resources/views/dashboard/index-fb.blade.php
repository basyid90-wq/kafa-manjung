@extends('layout-fb.layout')

@section('title', 'Dashboard')

@section('content')

@php $authRole = auth()->user()->getRoleNames()->first(); @endphp

<div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
    <div>
        <p class="ek-page-sub">{{ now()->locale('ms')->isoFormat('dddd, D MMMM YYYY') }}</p>
        <h1 class="ek-page-title">Assalamualaikum, {{ auth()->user()->name }}</h1>
    </div>
    @if(in_array($authRole, ['Guru Besar', 'Guru KAFA']) && auth()->user()->canUse('kehadiran'))
    <a href="{{ route('attendances.index') }}" class="ek-btn-primary">
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
        Tanda Kehadiran
    </a>
    @endif
</div>

@if($authRole === 'Super Admin')
    @include('dashboard.fb.superadmin')
@elseif($authRole === 'Guru Besar')
    @include('dashboard.fb.gurubesar')
@elseif($authRole === 'Guru KAFA')
    @include('dashboard.fb.guru')
@endif

@endsection
