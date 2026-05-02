@extends('layout-fb.layout')

@section('content')
<div class="p-4 md:p-6">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold text-gray-900 dark:text-white">Cipta RPH Kelas Cantum</h1>
        </div>
        <a href="{{ route('rph.index') }}"
           class="inline-flex items-center gap-2 px-3 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    {{-- Tab Switcher --}}
    <div class="flex gap-1 mb-5 bg-gray-100 dark:bg-gray-800 rounded-xl p-1">
        <a href="{{ route('rph.create') }}"
           class="flex-1 px-4 py-2 text-xs font-medium text-center text-gray-500 dark:text-gray-400 hover:text-gray-700 rounded-lg transition-colors">
            Kelas Biasa
        </a>
        <span class="flex-1 px-4 py-2 text-xs font-medium text-center bg-white dark:bg-gray-700 text-blue-600 dark:text-blue-400 shadow-sm rounded-lg cursor-default">
            Kelas Cantum
        </span>
    </div>

    <style>
        @font-face { font-family: 'Lateef'; src: url('/fonts/Lateef-Regular.ttf') format('truetype'); }
        .jawi-label { font-family: 'Lateef', serif; font-size: 1.1em; direction: rtl; text-align: right; display: block; margin-bottom: 4px; }
        .jawi-input { font-family: 'Lateef', serif !important; font-size: 1.2em !important; direction: rtl !important; text-align: right !important; line-height: 1.8 !important; }
        .rph-rumi-box { background: #f8f9fa; border: 1px dashed #ccc; margin-bottom: 4px; font-size: 0.85em; }
        .rph-convert-bar { text-align: center; margin: 3px 0 6px; }
    </style>

    <form action="{{ route('rph.store') }}" method="POST" id="form-gabungan">
        @csrf
        <input type="hidden" name="class_type" value="gabungan">

        {{-- BAHAGIAN 1: Pilih Tahun --}}
        <div class="bg-gradient-to-r from-gray-900 to-gray-800 text-white text-sm font-semibold px-4 py-2 rounded-lg mb-3">
            1. Pilih Kumpulan Tahun (Kelas Cantum)
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 mb-5">
            <div class="flex flex-wrap gap-2 mb-3">
                <button type="button" onclick="selectYears([1,2,3])"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium text-blue-700 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 transition-colors">
                    Tahun 1, 2 &amp; 3
                </button>
                <button type="button" onclick="selectYears([4,5,6])"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium text-blue-700 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 transition-colors">
                    Tahun 4, 5 &amp; 6
                </button>
                <button type="button" onclick="toggleCustom()"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium text-gray-600 bg-gray-100 border border-gray-200 rounded-lg hover:bg-gray-200 transition-colors">
                    Pilih Sendiri
                </button>
            </div>
            <div id="custom-years" class="hidden p-3 border border-gray-200 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 mb-3">
                <p class="text-xs font-semibold text-gray-600 dark:text-gray-300 mb-2">Pilih Tahun (Min 2, Maks 3):</p>
                <div class="flex flex-wrap gap-2">
                    @for($i = 1; $i <= 6; $i++)
                    <label class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors">
                        <input type="checkbox" class="year-checkbox" value="{{ $i }}" id="yr{{ $i }}" class="rounded">
                        Tahun {{ $i }}
                    </label>
                    @endfor
                </div>
            </div>
            <div id="selected-years-display" class="hidden p-3 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg text-sm text-blue-800 dark:text-blue-300">
                <strong>Tahun Dipilih:</strong> <span id="selected-years-text"></span>
                <div id="combined-years-inputs"></div>
            </div>
        </div>

        {{-- BAHAGIAN 2: Maklumat Asas --}}
        <div class="bg-gradient-to-r from-gray-900 to-gray-800 text-white text-sm font-semibold px-4 py-2 rounded-lg mb-3">
            2. Maklumat Asas
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 mb-5">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tarikh <span class="text-red-500">*</span></label>
                    <input type="date" name="date" id="rph-date" value="{{ date('Y-m-d') }}" required
                           class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Hari <span class="text-red-500">*</span></label>
                    <select name="hari" id="rph-hari" required
                            class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                        <option value="">-- Pilih --</option>
                        @foreach(['Ahad','Isnin','Selasa','Rabu','Khamis','Jumaat','Sabtu'] as $d)
                        <option value="{{ $d }}">{{ $d }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Minggu <span class="text-red-500">*</span></label>
                    <input name="week" type="number" min="1" max="52" required placeholder="1–52"
                           class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kelas (rekod) <span class="text-red-500">*</span></label>
                    <select name="kafa_class_id" required
                            class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                        <option value="">-- Pilih Kelas --</option>
                        @foreach($classes as $c)
                        <option value="{{ $c->id }}">{{ $c->display_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        {{-- BAHAGIAN 3: Sesi Pengajaran --}}
        <div class="bg-gradient-to-r from-gray-900 to-gray-800 text-white text-sm font-semibold px-4 py-2 rounded-lg mb-3">
            3. Sesi Pengajaran (3 Sesi)
        </div>

        <div id="sessions-container">
            <div class="flex items-start gap-3 p-4 mb-4 bg-yellow-50 dark:bg-yellow-900/20 border-l-4 border-yellow-400 rounded-r-xl text-sm text-yellow-800 dark:text-yellow-300">
                <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Sila pilih kumpulan tahun dahulu untuk memaparkan borang sesi.
            </div>
        </div>

        <div class="hidden flex justify-between items-center mt-5" id="btn-row">
            <a href="{{ route('rph.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-lg transition-colors">
                Batal
            </a>
            <button type="submit"
                    class="inline-flex items-center gap-2 px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                </svg>
                Simpan RPH Cantum
            </button>
        </div>
    </form>
</div>

<x-jawi-keyboard />
<script src="{{ asset('assets/js/jawi-converter.js') }}"></script>
<script>
const KEMAHIRAN = [
    ['menulis','Menulis'],['membaca','Membaca'],['menyanyi','Menyanyi'],
    ['melukis','Melukis'],['melabel','Melabel'],
    ['memilih_mengkategorikan','Memilih/Mengkategorikan'],
    ['mengira_membilang','Mengira/Membilang'],
    ['luar_bilik_darjah','Luar Bilik Darjah'],['simulasi','Simulasi'],
    ['memupuk_menanamkan','Memupuk/Menanamkan'],['menghafaz','Menghafaz'],
];
const STRATEGI = [
    ['berpusatkan_guru','Berpusatkan Guru'],['berpusatkan_murid','Berpusatkan Murid'],
    ['luar_bilik_darjah','Luar Bilik Darjah'],['talqi_musyafahah','Talqi Musyafahah'],
];
const FIELD_ROWS = [
    {key:'tajuk_by_year',         jawi:'تاجوق',          rumi:'Tajuk',             required:true},
    {key:'isi_pelajaran_by_year', jawi:'ايسي ڤلاجرن',    rumi:'Isi Pelajaran',     required:true},
    {key:'objective_by_year',     jawi:'اوبجيكتيف',       rumi:'Objektif Pelajaran',required:true},
    {key:'aktiviti_by_year',      jawi:'اكتيۏيتي',        rumi:'Aktiviti',          required:true},
];
let selectedYears = [];

function selectYears(years) {
    selectedYears = [...years];
    document.querySelectorAll('.year-checkbox').forEach(cb => cb.checked = false);
    years.forEach(y => { const cb = document.getElementById('yr'+y); if(cb) cb.checked=true; });
    document.getElementById('custom-years').classList.add('hidden');
    renderAll();
}
function toggleCustom() {
    const div = document.getElementById('custom-years');
    div.classList.toggle('hidden');
    document.querySelectorAll('.year-checkbox').forEach(cb => {
        cb.onchange = function() {
            const checked = Array.from(document.querySelectorAll('.year-checkbox:checked'))
                .map(c=>parseInt(c.value)).sort((a,b)=>a-b);
            if(checked.length>3){this.checked=false;alert('Maksimum 3 tahun sahaja');return;}
            selectedYears=checked;
            if(checked.length>=2) renderAll();
        };
    });
}
function renderAll() {
    if(selectedYears.length<2) return;
    const inp = document.getElementById('combined-years-inputs');
    inp.innerHTML = selectedYears.map(y=>`<input type="hidden" name="combined_years[]" value="${y}">`).join('');
    document.getElementById('selected-years-display').classList.remove('hidden');
    document.getElementById('selected-years-text').textContent = selectedYears.map(y=>'Tahun '+y).join(', ');
    const container = document.getElementById('sessions-container');
    container.innerHTML = [1,2,3].map(s=>buildSessionCard(s)).join('');
    document.getElementById('btn-row').classList.remove('hidden');
}
function buildSessionCard(s) {
    const yearHeaders = selectedYears.map(y=>`<th class="px-3 py-2 text-center text-xs font-semibold text-gray-600 bg-blue-50">TAHUN ${y}</th>`).join('');
    const fieldRows = FIELD_ROWS.map(f=>{
        const yearCells = selectedYears.map(y=>`
            <td class="px-2 py-2 align-top">
                <textarea id="s${s}_y${y}_${f.key}_rumi" class="rph-rumi-box w-full px-2 py-1 text-xs border border-dashed border-gray-300 rounded bg-gray-50" rows="2" placeholder="Taip Rumi..."></textarea>
                <div class="text-center my-1">
                    <button type="button" onclick="tukarKeJawi('s${s}_y${y}_${f.key}_rumi','s${s}_y${y}_${f.key}_jawi')"
                            class="text-xs px-2 py-0.5 bg-amber-100 hover:bg-amber-200 text-amber-800 rounded border border-amber-300">↓ Jawi</button>
                </div>
                <textarea id="s${s}_y${y}_${f.key}_jawi"
                          name="periods[${s}][${f.key}][${y}]"
                          class="jawi-input w-full px-2 py-1 border border-gray-300 rounded" rows="3" dir="rtl"${f.required?' required':''}></textarea>
            </td>`).join('');
        return `<tr>
            <td class="px-3 py-2 align-top bg-gray-50 text-xs">
                <div class="jawi-label text-blue-600">${f.jawi}</div>
                <span class="text-gray-500">${f.rumi}</span>
            </td>${yearCells}</tr>`;
    }).join('');
    const kemBadges = KEMAHIRAN.map(([v,l])=>`
        <label class="inline-flex items-center gap-1 px-2.5 py-1 text-xs border border-indigo-200 bg-indigo-50 rounded-full cursor-pointer hover:bg-indigo-100 m-0.5">
            <input type="checkbox" name="periods[${s}][kemahiran_selected][]" value="${v}" class="rounded"> ${l}
        </label>`).join('');
    const stratBadges = STRATEGI.map(([v,l])=>`
        <label class="inline-flex items-center gap-1 px-2.5 py-1 text-xs border border-indigo-200 bg-indigo-50 rounded-full cursor-pointer hover:bg-indigo-100 m-0.5">
            <input type="checkbox" name="periods[${s}][strategi_pdc][]" value="${v}" class="rounded"> ${l}
        </label>`).join('');
    return `
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden mb-4">
        <div class="bg-gradient-to-r from-gray-900 to-gray-800 text-white text-sm font-semibold px-4 py-2">SESI ${s}</div>
        <div class="p-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-4">
                <div>
                    <label class="jawi-label text-gray-600">مات ڤلاجرن</label>
                    <span class="text-xs text-gray-500 block mb-1">Mata Pelajaran <span class="text-red-500">*</span></span>
                    <input type="text" id="s${s}_mp_rumi" class="rph-rumi-box w-full px-2 py-1 text-xs border border-dashed border-gray-300 rounded bg-gray-50" placeholder="Taip Rumi...">
                    <div class="text-center my-1">
                        <button type="button" onclick="tukarKeJawi('s${s}_mp_rumi','s${s}_mp_jawi')"
                                class="text-xs px-2 py-0.5 bg-amber-100 hover:bg-amber-200 text-amber-800 rounded border border-amber-300">↓ Jawi</button>
                    </div>
                    <input type="text" id="s${s}_mp_jawi" name="periods[${s}][mata_pelajaran_jawi]"
                           class="jawi-input w-full px-2 py-1 border border-gray-300 rounded" dir="rtl" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Masa <span class="text-red-500">*</span></label>
                    <input type="text" name="periods[${s}][masa]" required placeholder="Cth: 8:00 - 9:00 PG"
                           class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg bg-white focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
            <div class="overflow-x-auto mb-4">
                <table class="w-full text-sm border border-gray-200 rounded-lg overflow-hidden">
                    <thead><tr><th class="px-3 py-2 text-left text-xs font-semibold bg-gray-100 text-gray-600 w-24">Perkara</th>${yearHeaders}</tr></thead>
                    <tbody class="divide-y divide-gray-100">${fieldRows}</tbody>
                </table>
            </div>
            <div class="p-3 bg-gray-50 dark:bg-gray-700/30 rounded-lg mb-3">
                <p class="text-xs font-semibold text-gray-700 mb-2"><span class="jawi-label inline" style="font-size:1em;">كماهيرن</span> Kemahiran:</p>
                <div>${kemBadges}</div>
            </div>
            <div class="p-3 bg-gray-50 dark:bg-gray-700/30 rounded-lg mb-3">
                <p class="text-xs font-semibold text-gray-700 mb-2"><span class="jawi-label inline" style="font-size:1em;">ستراتڬي ڤدڤ</span> Strategi PdP:</p>
                <div>${stratBadges}</div>
            </div>
            <div class="p-3 border border-gray-200 rounded-lg">
                <p class="text-xs font-semibold text-gray-700 mb-2"><span class="jawi-label inline" style="font-size:1em;">ايمڤك ڤمبلاجرن</span> Impak Pembelajaran:</p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                    <div>
                        <label class="text-xs font-medium text-gray-600">Murid berjaya capai objektif (____/____):</label>
                        <input type="text" name="periods[${s}][impak][berjaya]" placeholder="cth: 20/25"
                               class="w-full px-2 py-1 text-xs border border-gray-300 rounded mt-1">
                    </div>
                    <div>
                        <label class="text-xs font-medium text-gray-600">Murid belum berjaya (____/____):</label>
                        <input type="text" name="periods[${s}][impak][belum]" placeholder="cth: 5/25"
                               class="w-full px-2 py-1 text-xs border border-gray-300 rounded mt-1">
                    </div>
                    <div>
                        <label class="text-xs font-medium text-gray-600">Aktiviti P&P ditangguhkan kerana:</label>
                        <input type="text" name="periods[${s}][impak][sebab_ditangguh]" placeholder="(kosong jika tidak ditangguh)"
                               class="w-full px-2 py-1 text-xs border border-gray-300 rounded mt-1">
                    </div>
                    <div>
                        <label class="text-xs font-medium text-gray-600">Aktiviti P&P diteruskan pada:</label>
                        <input type="text" name="periods[${s}][impak][tarikh_teruskan]" placeholder="(kosong jika tidak ditangguh)"
                               class="w-full px-2 py-1 text-xs border border-gray-300 rounded mt-1">
                    </div>
                </div>
            </div>
        </div>
    </div>`;
}

document.getElementById('form-gabungan').addEventListener('submit', function(e) {
    if(selectedYears.length<2){e.preventDefault();alert('Sila pilih sekurang-kurangnya 2 tahun terlebih dahulu.');}
});

// Auto-set hari from date
document.getElementById('rph-date').addEventListener('change', function() {
    const days = ['Ahad','Isnin','Selasa','Rabu','Khamis','Jumaat','Sabtu'];
    const d = new Date(this.value);
    const dayName = days[d.getDay()];
    const sel = document.getElementById('rph-hari');
    for(let i=0;i<sel.options.length;i++){if(sel.options[i].value===dayName){sel.selectedIndex=i;break;}}
});
document.getElementById('rph-date').dispatchEvent(new Event('change'));
</script>
@endsection
