@extends('layout-fb.layout')

@section('content')
<div>

    <div class="mb-6">
        <h1 class="ek-page-title">Set Waktu Mengajar</h1>
        <p class="ek-page-sub mt-1">Tetapkan slot masa pengajaran untuk jadual waktu kelas</p>
    </div>

    {{-- ── Add Slot Form ── --}}
    <div class="ek-card mb-5">
        <h2 class="text-sm font-semibold text-gray-700 mb-4">Tambah Slot Baru</h2>
        <form action="{{ route('time_slots.store') }}" method="POST">
            @csrf
            <div class="flex flex-wrap items-end gap-3">
                <div class="flex-1 min-w-[160px]">
                    <label class="block text-xs font-medium text-gray-700 mb-1.5">
                        Nama Slot
                    </label>
                    <input type="text" name="name" placeholder="Waktu 1" required
                           class="ek-input">
                </div>
                <div class="flex-1 min-w-[130px]">
                    <label class="block text-xs font-medium text-gray-700 mb-1.5">
                        Masa Mula
                    </label>
                    <input type="time" name="start_time" required
                           class="ek-input">
                </div>
                <div class="flex-1 min-w-[130px]">
                    <label class="block text-xs font-medium text-gray-700 mb-1.5">
                        Masa Tamat
                    </label>
                    <input type="time" name="end_time" required
                           class="ek-input">
                </div>
                <button type="submit"
                        class="ek-btn-primary">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah
                </button>
            </div>
        </form>
    </div>

    {{-- ── Slots Table (inline edit) ── --}}
    <div class="ek-table-wrap">
        <div class="overflow-x-auto">
            <table class="ek-table">
                <thead>
                    <tr>
                        <th class="px-5 py-3 w-12">No</th>
                        <th class="px-5 py-3">Nama Slot</th>
                        <th class="px-5 py-3">Masa Mula</th>
                        <th class="px-5 py-3">Masa Tamat</th>
                        <th class="px-5 py-3 text-center w-24">Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($slots as $slot)
                    <form action="{{ route('time_slots.update', $slot) }}" method="POST">
                        @csrf @method('PUT')
                        <tr>
                            <td class="px-5 py-2 text-gray-400 text-xs">{{ $loop->iteration }}</td>
                            <td class="px-5 py-2">
                                <input type="text" name="name" value="{{ $slot->name }}" required
                                       class="ek-input px-2.5 py-1.5">
                            </td>
                            <td class="px-5 py-2">
                                <input type="time" name="start_time" value="{{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }}" required
                                       class="ek-input px-2.5 py-1.5">
                            </td>
                            <td class="px-5 py-2">
                                <input type="time" name="end_time" value="{{ \Carbon\Carbon::parse($slot->end_time)->format('H:i') }}" required
                                       class="ek-input px-2.5 py-1.5">
                            </td>
                            <td class="px-5 py-2">
                                <div class="flex items-center justify-center gap-1.5">
                                    <button type="submit"
                                            class="p-1.5 text-green-600 hover:bg-green-50 rounded-lg transition-colors"
                                            title="Simpan">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                                        </svg>
                                    </button>
                                    </form>
                                    <form action="{{ route('time_slots.destroy', $slot) }}" method="POST"
                                          data-delete-form data-name="slot {{ $slot->name }}">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                                class="p-1.5 text-red-500 hover:bg-red-50 rounded-lg transition-colors"
                                                title="Padam">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-5 py-12 text-center text-gray-400 text-sm">
                            Tiada slot masa ditetapkan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
    window.onload = function() {
        if (localStorage.getItem('scrollPosition')) {
            window.scrollTo(0, localStorage.getItem('scrollPosition'));
        }
    };
    window.onscroll = function() {
        localStorage.setItem('scrollPosition', window.scrollY);
    };
</script>
@endpush
@endsection
