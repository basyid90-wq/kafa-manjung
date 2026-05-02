@extends('layout-fb.layout')

@section('content')
<div class="p-4 md:p-6">

    <div class="mb-5">
        <h1 class="text-xl font-bold text-gray-900 dark:text-white">Aduan Masalah Pengguna</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Semua aduan dan maklum balas yang diterima daripada pengguna sistem.</p>
    </div>

    {{-- Filter --}}
    <form method="GET" class="flex flex-wrap items-center gap-2 mb-4">
        <select name="status"
                class="text-sm border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            <option value="">Semua Status</option>
            @foreach($statuses as $key => $s)
                <option value="{{ $key }}" {{ request('status') === $key ? 'selected' : '' }}>{{ $s['label'] }}</option>
            @endforeach
        </select>
        <select name="module"
                class="text-sm border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            <option value="">Semua Modul</option>
            @foreach($modules as $m)
                <option value="{{ $m }}" {{ request('module') === $m ? 'selected' : '' }}>{{ $m }}</option>
            @endforeach
        </select>
        <button type="submit"
                class="inline-flex items-center gap-1.5 px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
            </svg>
            Tapis
        </button>
        @if(request('status') || request('module'))
        <a href="{{ route('feedback.index') }}"
           class="inline-flex items-center gap-1.5 px-3 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-300 text-sm font-medium rounded-lg transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
            Set Semula
        </a>
        @endif
    </form>

    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th class="px-5 py-3 w-12">No</th>
                        <th class="px-5 py-3">Pengguna</th>
                        <th class="px-5 py-3">Modul</th>
                        <th class="px-5 py-3">Tarikh</th>
                        <th class="px-5 py-3 text-center">Status</th>
                        <th class="px-5 py-3 text-center w-20">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($feedbacks as $i => $fb)
                    <tr id="row-{{ $fb->id }}" class="bg-white hover:bg-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700">
                        <td class="px-5 py-3 text-gray-400 text-xs">{{ $feedbacks->firstItem() + $i }}</td>
                        <td class="px-5 py-3">
                            <p class="font-medium text-gray-900 dark:text-white text-sm">{{ $fb->user->name ?? '—' }}</p>
                            <p class="text-xs text-gray-400">{{ $fb->user->getRoleNames()->first() ?? '' }}</p>
                        </td>
                        <td class="px-5 py-3">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400">
                                {{ $fb->module }}
                            </span>
                        </td>
                        <td class="px-5 py-3 text-xs text-gray-500 dark:text-gray-400">
                            {{ $fb->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-5 py-3 text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $fb->status_class }}">
                                {{ $fb->status_label }}
                            </span>
                        </td>
                        <td class="px-5 py-3 text-center">
                            <a href="{{ route('feedback.show', $fb->id) }}"
                               class="p-1.5 text-blue-600 hover:bg-blue-50 dark:text-blue-400 dark:hover:bg-blue-900/20 rounded-lg transition-colors inline-flex"
                               title="Lihat">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-5 py-12 text-center text-gray-400 text-sm">
                            Tiada aduan ditemui.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($feedbacks->hasPages())
        <div class="px-5 py-4 border-t border-gray-200 dark:border-gray-700">
            {{ $feedbacks->withQueryString()->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
