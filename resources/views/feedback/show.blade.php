@extends('layout-fb.layout')

@section('content')
<div class="p-4 md:p-6">

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-bold text-gray-900 dark:text-white">Butiran Aduan</h1>
        <a href="{{ route('feedback.index') }}"
           class="inline-flex items-center gap-2 px-3 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    @if(session('success'))
    <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg px-4 py-3 mb-4 text-sm text-green-700 dark:text-green-400">
        {{ session('success') }}
    </div>
    @endif

    {{-- Info Aduan --}}
    <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl border border-gray-200 dark:border-gray-700 p-4 mb-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
            <div>
                <p class="text-xs text-gray-500 dark:text-gray-400 mb-0.5">Pengguna</p>
                <div class="flex items-center gap-1.5">
                    <p class="font-semibold text-gray-900 dark:text-white">{{ $feedback->user->name ?? '-' }}</p>
                    <span class="px-1.5 py-0.5 text-xs bg-gray-200 dark:bg-gray-600 text-gray-600 dark:text-gray-300 rounded">{{ $feedback->user->getRoleNames()->first() ?? '' }}</span>
                </div>
            </div>
            <div>
                <p class="text-xs text-gray-500 dark:text-gray-400 mb-0.5">Modul</p>
                <p class="font-semibold text-gray-900 dark:text-white">{{ $feedback->module }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500 dark:text-gray-400 mb-0.5">Tarikh Hantar</p>
                <p class="font-semibold text-gray-900 dark:text-white">{{ $feedback->created_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>
    </div>

    {{-- Penerangan --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 mb-4">
        <h2 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Penerangan Masalah</h2>
        <div class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed prose prose-sm dark:prose-invert max-w-none">
            {!! nl2br(e($feedback->description)) !!}
        </div>
    </div>

    {{-- Tangkapan Skrin --}}
    @if($feedback->image_path)
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 mb-4">
        <h2 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Tangkapan Skrin</h2>
        <img src="{{ Storage::url($feedback->image_path) }}" alt="Screenshot"
             class="max-w-full rounded-lg border border-gray-200 dark:border-gray-700 cursor-pointer transition-all"
             onclick="this.classList.toggle('max-w-lg')">
        <p class="text-xs text-gray-400 mt-2">Klik imej untuk zoom.</p>
    </div>
    @endif

    {{-- Form Status --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5">
        <h2 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-4">Kemaskini Status</h2>
        <form action="{{ route('feedback.update', $feedback->id) }}" method="POST">
            @csrf
            @method('PATCH')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                    <select name="status"
                            class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                        @foreach(\App\Models\Feedback::STATUSES as $key => $s)
                            <option value="{{ $key }}" {{ $feedback->status === $key ? 'selected' : '' }}>
                                {{ $s['label'] }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Balasan / Nota (Dalaman)</label>
                <textarea name="admin_reply" rows="4"
                          placeholder="Tulis nota tindakan atau balasan untuk rekod..."
                          class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">{{ $feedback->admin_reply }}</textarea>
            </div>
            <button type="submit"
                    class="inline-flex items-center gap-2 px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                Simpan Status
            </button>
        </form>
    </div>
</div>
@endsection
