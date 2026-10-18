@extends('layout-fb.layout')

@section('title', 'Dashboard')

@section('content')

@php $authRole = auth()->user()->getRoleNames()->first(); @endphp

<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Dashboard</h1>
    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
        Selamat datang, <strong>{{ auth()->user()->name }}</strong> — {{ auth()->user()->roleLabel() }}
    </p>
</div>

@if($authRole === 'Super Admin')
    @include('dashboard.fb.superadmin')
@elseif($authRole === 'Guru Besar')
    @include('dashboard.fb.gurubesar')
@elseif($authRole === 'Guru KAFA')
    @include('dashboard.fb.guru')
@endif

@endsection
