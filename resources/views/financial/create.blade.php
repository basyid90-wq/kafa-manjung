@extends('layout-fb.layout')

@section('content')
<div>

    <div class="flex items-center justify-between mb-6">
        <h1 class="ek-page-title">Tambah Rekod Kewangan</h1>
        <a href="{{ route('financial.index') }}"
           class="ek-btn-secondary">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    <div class="ek-card">
        <form action="{{ route('financial.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">

                <div>
                    <label class="ek-label">Jenis Transaksi <span class="text-red-500">*</span></label>
                    <select name="transaction_type" required
                            class="ek-input">
                        <option value="in">Wang Masuk (+)</option>
                        <option value="out">Wang Keluar (-)</option>
                    </select>
                </div>

                <div>
                    <label class="ek-label">Kategori Akaun <span class="text-red-500">*</span></label>
                    <select name="account_category_id" required
                            class="ek-input">
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="ek-label">Jumlah (RM) <span class="text-red-500">*</span></label>
                    <input type="number" step="0.01" name="amount" placeholder="0.00" required
                           class="ek-input">
                </div>

                <div>
                    <label class="ek-label">Tarikh Transaksi <span class="text-red-500">*</span></label>
                    <input type="date" name="transaction_date" value="{{ date('Y-m-d') }}" required
                           class="ek-input">
                </div>

                <div class="md:col-span-2">
                    <label class="ek-label">No. Rujukan / Resit</label>
                    <input type="text" name="reference_no" placeholder="Masukkan no rujukan jika ada"
                           class="ek-input">
                </div>

                <div class="md:col-span-2">
                    <label class="ek-label">Keterangan / Catatan</label>
                    <textarea name="description" rows="3" placeholder="Catatan tambahan..."
                              class="ek-input"></textarea>
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit"
                        class="ek-btn-primary">
                    Simpan Rekod
                </button>
                <a href="{{ route('financial.index') }}"
                   class="ek-btn-secondary">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
