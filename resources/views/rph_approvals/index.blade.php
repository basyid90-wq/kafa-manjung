@extends('layout-fb.layout')

@section('content')
<div class="p-4 md:p-6">

    {{-- ── Header ── --}}
    <div class="flex items-center justify-between mb-5">
        <div>
            @role('Guru Besar')
            <h1 class="text-xl font-bold text-gray-900 dark:text-white">Semakan RPH Guru KAFA</h1>
            @elserole('Penyelia KAFA')
            <h1 class="text-xl font-bold text-gray-900 dark:text-white">Semakan RPH Guru Besar</h1>
            @else
            <h1 class="text-xl font-bold text-gray-900 dark:text-white">Kelulusan RPH</h1>
            @endrole
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">RPH menunggu tindakan semakan / kelulusan</p>
        </div>
        <a href="{{ route('rph_approvals.history') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-lg border border-gray-300 dark:border-gray-600 transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Sejarah Kelulusan
        </a>
    </div>

    @if($records->isEmpty())
    {{-- ── Empty State ── --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-12 text-center">
        <div class="flex flex-col items-center gap-3 text-gray-400">
            <div class="w-16 h-16 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h3 class="text-base font-semibold text-gray-700 dark:text-gray-300">Tiada RPH Menunggu Semakan</h3>
            @role('Guru Besar')
            <p class="text-sm text-gray-500">Tiada RPH dari Guru KAFA yang perlu disemak.</p>
            <p class="text-xs text-gray-400 mt-1">RPH yang anda hantar sendiri akan disemak oleh Penyelia KAFA.</p>
            @else
            <p class="text-sm text-gray-500">Semua RPH guru telah disemak.</p>
            @endrole
        </div>
    </div>

    @else
    {{-- ── RPH Cards ── --}}
    <div class="space-y-4">
        @foreach($records as $rph)
        @php $p1 = $rph->periods->firstWhere('period_no', 1); @endphp
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">

            {{-- Card Header (dark) --}}
            <div class="bg-gradient-to-r from-gray-900 to-gray-800 px-5 py-4">
                {{-- Status + period count --}}
                <div class="flex items-center justify-between mb-3">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-400/20 text-yellow-300 border border-yellow-400/30">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Menunggu Semakan
                    </span>
                    <span class="text-xs text-gray-400">{{ $rph->periods->count() }} waktu</span>
                </div>

                {{-- Tajuk & Mata Pelajaran (Jawi) --}}
                @if($p1?->topic_jawi)
                <p class="text-white mb-1" style="font-family:'Lateef',serif; font-size:1.4em; direction:rtl; text-align:right; line-height:1.5;">{{ $p1->topic_jawi }}</p>
                @else
                <p class="text-gray-500 text-sm mb-1">— tiada tajuk —</p>
                @endif
                @if($p1?->mata_pelajaran_jawi)
                <p class="text-gray-300 mb-3" style="font-family:'Lateef',serif; font-size:1em; direction:rtl; text-align:right;">{{ $p1->mata_pelajaran_jawi }}</p>
                @endif

                {{-- Info chips ── --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 mb-3">
                    <div class="bg-white/10 rounded-lg px-3 py-2">
                        <p class="text-[10px] text-gray-400 uppercase tracking-wide mb-0.5">Guru</p>
                        <p class="text-white font-semibold text-sm">{{ $rph->user->name ?? '—' }}</p>
                    </div>
                    @hasanyrole('Penyelia KAFA|Super Admin|Pentadbir|Guru Besar')
                    <div class="bg-white/10 rounded-lg px-3 py-2">
                        <p class="text-[10px] text-gray-400 uppercase tracking-wide mb-0.5">Sekolah</p>
                        <p class="text-white font-medium text-sm leading-tight">{{ $rph->school->name ?? '—' }}</p>
                    </div>
                    @endhasanyrole
                </div>

                {{-- Meta tags --}}
                <div class="flex flex-wrap gap-2 text-xs">
                    <span class="bg-white/15 text-white px-2.5 py-1 rounded-full">
                        {{ $p1?->kafaClass?->name ?? $rph->kafaClass?->name ?? '—' }}
                    </span>
                    <span class="bg-white/15 text-white px-2.5 py-1 rounded-full">
                        {{ $rph->hari ?? '' }} {{ \Carbon\Carbon::parse($rph->date)->format('d/m/Y') }}
                    </span>
                    <span class="bg-white/15 text-white px-2.5 py-1 rounded-full">
                        Minggu {{ $rph->week }}
                    </span>
                    @if($p1?->masa)
                    <span class="bg-white/15 text-white px-2.5 py-1 rounded-full">{{ $p1->masa }}</span>
                    @endif
                </div>
            </div>

            {{-- Preview Body --}}
            <div class="px-5 py-4">
                @if($p1)
                <p class="text-xs font-bold uppercase tracking-wide text-blue-600 dark:text-blue-400 mb-3">Waktu 1 — Pratonton</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-4">
                    @foreach([
                        ['كماهيرن', $p1->kemahiran_jawi],
                        ['اوبجيكتيف', $p1->objective_jawi],
                        ['اكتيۏيتي', $p1->aktiviti_jawi],
                        ['ايمڤک', $p1->reflection_jawi],
                    ] as [$lbl, $val])
                    @if($val)
                    <div>
                        <p class="text-xs text-blue-600 dark:text-blue-400 mb-1" style="font-family:'Lateef',serif; direction:rtl; text-align:right;">{{ $lbl }}</p>
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3" style="font-family:'Lateef',serif; font-size:1.05em; direction:rtl; text-align:right; white-space:pre-wrap;">{{ $val }}</div>
                    </div>
                    @endif
                    @endforeach
                </div>
                @endif

                <a href="{{ route('rph.show', $rph) }}"
                   class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    Lihat Semua Waktu
                </a>

                {{-- Approval Form --}}
                @hasanyrole('Penyelia KAFA|Super Admin|Pentadbir|Guru Besar')
                <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                    <form action="{{ route('rph_approvals.update', $rph) }}" method="POST">
                        @csrf @method('PUT')
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 items-end">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">
                                    Keputusan <span class="text-red-500">*</span>
                                </label>
                                <select name="status" required
                                        class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                                    <option value="">— Pilih —</option>
                                    <option value="approved">✅ Luluskan</option>
                                    <option value="revision_needed">🔄 Perlu Pembaikan</option>
                                    <option value="rejected">❌ Tolak</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Ulasan (jika ada)</label>
                                <textarea name="review_comment" rows="2"
                                          class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none resize-none"></textarea>
                            </div>
                            <div>
                                <button type="submit"
                                        class="w-full flex items-center justify-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                    </svg>
                                    Hantar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                @else
                <div class="mt-4 flex items-start gap-2 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800 text-sm text-blue-700 dark:text-blue-400">
                    <svg class="w-4 h-4 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Anda dalam mod <strong class="ml-1">baca sahaja</strong>. Kelulusan RPH dilakukan oleh Penyelia KAFA.
                </div>
                @endhasanyrole
            </div>
        </div>
        @endforeach
    </div>

    @if($records->hasPages())
    <div class="mt-4">{{ $records->links() }}</div>
    @endif
    @endif

</div>

<style>
    @font-face { font-family: 'Lateef'; src: url('/fonts/Lateef-Regular.ttf') format('truetype'); }
</style>
@endsection
