{{--
    Komponen: Waktu Solat (JAKIM API via Laravel proxy)
    Guna: <x-prayer-times-widget />
    Default zone: PRK09 (Lumut/Sitiawan/Pangkor – Daerah Manjung)
--}}
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden border border-gray-200 dark:border-gray-700">
    <div class="flex flex-col lg:flex-row">

        {{-- ── LEFT: Mosque banner ── --}}
        <div class="relative flex-shrink-0 lg:w-56 min-h-48 lg:min-h-0 flex items-center justify-center overflow-hidden"
             style="background: linear-gradient(160deg, #0c1f3f 0%, #1a3a6e 50%, #1e5fa8 100%);">

            {{-- Mosque silhouette SVG --}}
            <svg class="absolute bottom-0 left-0 w-full pointer-events-none"
                 viewBox="0 0 220 90" fill="white" style="opacity:0.12;" preserveAspectRatio="xMidYMax meet">
                <!-- Left minaret -->
                <rect x="12" y="20" width="14" height="60"/>
                <polygon points="19,5 12,24 26,24"/>
                <circle cx="19" cy="3" r="3.5"/>
                <!-- Right minaret -->
                <rect x="194" y="20" width="14" height="60"/>
                <polygon points="201,5 194,24 208,24"/>
                <circle cx="201" cy="3" r="3.5"/>
                <!-- Main building -->
                <rect x="45" y="45" width="130" height="45"/>
                <!-- Main dome -->
                <path d="M70,45 Q110,5 150,45 Z"/>
                <!-- Side domes -->
                <path d="M45,58 Q62,40 80,58 Z"/>
                <path d="M140,58 Q158,40 175,58 Z"/>
                <!-- Door arch -->
                <path d="M100,90 L100,68 Q110,58 120,68 L120,90 Z"/>
                <!-- Small windows -->
                <ellipse cx="68" cy="62" rx="7" ry="9"/>
                <ellipse cx="152" cy="62" rx="7" ry="9"/>
            </svg>

            {{-- Text overlay --}}
            <div class="relative z-10 text-center px-4 py-6">
                <p class="text-white font-extrabold text-2xl uppercase tracking-widest leading-tight">
                    Waktu<br>Solat
                </p>
                <div class="w-10 h-px bg-white mx-auto my-3" style="opacity:0.5;"></div>
                <p id="pt-location-display"
                   class="text-xs font-medium text-center"
                   style="color:rgba(186,222,255,0.9);">
                    Daerah Manjung
                </p>
            </div>
        </div>

        {{-- ── RIGHT: Clock + Times ── --}}
        <div class="flex-1 p-4 lg:p-5">

            {{-- Top row: Selects + Clock + Date --}}
            <div class="flex flex-wrap items-center justify-between gap-x-4 gap-y-3 mb-4">

                {{-- LEFT: dropdowns + clock --}}
                <div class="flex flex-wrap items-center gap-2">

                    {{-- State select --}}
                    <div class="flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-gray-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <select id="pt-state-select"
                                class="text-xs border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 focus:ring-2 focus:ring-blue-500 py-1.5 px-2"
                                style="max-width:130px;">
                        </select>
                    </div>

                    {{-- Zone select --}}
                    <select id="pt-zone-select"
                            class="text-xs border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 focus:ring-2 focus:ring-blue-500 py-1.5 px-2"
                            style="max-width:200px;">
                    </select>

                    {{-- Flip-style clock: individual digit blocks --}}
                    <div class="flex items-center gap-0.5">
                        {{-- Hours --}}
                        <div id="pt-h1" class="text-white font-mono font-bold text-2xl rounded-md text-center"
                             style="background:#111827; min-width:36px; padding:6px 8px;">0</div>
                        <div id="pt-h2" class="text-white font-mono font-bold text-2xl rounded-md text-center"
                             style="background:#111827; min-width:36px; padding:6px 8px; margin-left:2px;">0</div>
                        <span class="font-bold text-gray-500 dark:text-gray-400 text-xl px-0.5" style="padding-bottom:4px;">:</span>
                        {{-- Minutes --}}
                        <div id="pt-m1" class="text-white font-mono font-bold text-2xl rounded-md text-center"
                             style="background:#111827; min-width:36px; padding:6px 8px;">0</div>
                        <div id="pt-m2" class="text-white font-mono font-bold text-2xl rounded-md text-center"
                             style="background:#111827; min-width:36px; padding:6px 8px; margin-left:2px;">0</div>
                        <span class="font-bold text-gray-500 dark:text-gray-400 text-xl px-0.5" style="padding-bottom:4px;">:</span>
                        {{-- Seconds --}}
                        <div id="pt-s1" class="text-white font-mono font-bold text-2xl rounded-md text-center"
                             style="background:#111827; min-width:36px; padding:6px 8px;">0</div>
                        <div id="pt-s2" class="text-white font-mono font-bold text-2xl rounded-md text-center"
                             style="background:#111827; min-width:36px; padding:6px 8px; margin-left:2px;">0</div>
                    </div>
                </div>

                {{-- RIGHT: Date display --}}
                <div class="text-right">
                    <p id="pt-greg-date" class="text-sm font-semibold text-gray-800 dark:text-white"></p>
                    <p id="pt-hijri-date" class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">— H</p>
                    <p id="pt-api-status" class="text-xs text-green-600 dark:text-green-400 mt-1 font-medium h-4"></p>
                </div>
            </div>

            {{-- Prayer times grid --}}
            <div class="grid grid-cols-3 sm:grid-cols-6 gap-2">
                @php
                $prayers = [
                    ['key' => 'fajr',    'label' => 'Subuh'],
                    ['key' => 'syuruk',  'label' => 'Syuruk'],
                    ['key' => 'dhuhr',   'label' => 'Zohor'],
                    ['key' => 'asr',     'label' => 'Asar'],
                    ['key' => 'maghrib', 'label' => 'Maghrib'],
                    ['key' => 'isha',    'label' => 'Isyak'],
                ];
                @endphp
                @foreach($prayers as $p)
                <div class="prayer-time-box rounded-lg p-2.5 text-center border border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 transition-colors duration-300"
                     data-prayer="{{ $p['key'] }}">
                    <p class="pt-time text-sm font-bold text-gray-900 dark:text-white" id="pt-{{ $p['key'] }}">--:--</p>
                    <p class="pt-label text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ $p['label'] }}</p>
                </div>
                @endforeach
            </div>

        </div>
    </div>
</div>

<script>
(function () {
    // ── Zone data (JAKIM Malaysia) ──────────────────────────────────────────
    var stateZones = {
        'W.P. Kuala Lumpur & Putrajaya': { 'Kuala Lumpur, Putrajaya': 'KUL01' },
        'W.P. Labuan': { 'Labuan': 'LBN01' },
        'Johor': {
            'Pulau Aur, Pulau Pemanggil': 'JHR01',
            'Johor Bahru, Kota Tinggi, Mersing': 'JHR02',
            'Kluang, Pontian': 'JHR03',
            'Muar, Segamat, Gemas, Batu Pahat': 'JHR04'
        },
        'Kedah': {
            'Kota Setar, Kubang Pasu, Pokok Sena': 'KDH01',
            'Kuala Muda, Yan, Pendang': 'KDH02',
            'Padang Terap, Sik': 'KDH03',
            'Baling': 'KDH04',
            'Kulim, Bandar Baharu': 'KDH05',
            'Langkawi': 'KDH06',
            'Gunung Jerai': 'KDH07'
        },
        'Kelantan': {
            'Kota Bharu, Pasir Mas, Bachok, Tumpat, Pasir Puteh, Machang, Kuala Krai, Jeli': 'KTN01',
            'Gua Musang (Ulu Kelantan)': 'KTN03'
        },
        'Melaka': { 'Seluruh Melaka': 'MLK01' },
        'Negeri Sembilan': {
            'Jelebu, Kuala Pilah, Tampin, Rembau, Port Dickson': 'NGS01',
            'Seremban': 'NGS02'
        },
        'Pahang': {
            'Pulau Tioman': 'PHG01',
            'Pekan, Rompin, Muadzam Shah': 'PHG02',
            'Maran, Chenor, Temerloh, Bera, Jengka': 'PHG03',
            'Raub': 'PHG04',
            'Bentong, Cameron Highland, Lipis': 'PHG05',
            'Jerantut': 'PHG06'
        },
        'Pulau Pinang': {
            'Seluruh Pulau Pinang': 'PNG01',
            'Seberang Prai': 'PNG02'
        },
        'Perak': {
            'Pengkalan Hulu, Hulu Perak': 'PRK01',
            'Selama, Larut, Matang': 'PRK02',
            'Gerik': 'PRK03',
            'Lenggong': 'PRK04',
            'Grik, Hulu Perak (utara)': 'PRK05',
            'Kuala Kangsar, Sungai Siput': 'PRK06',
            'Ipoh, Kinta, Kampar, Batu Gajah, Perak Tengah': 'PRK07',
            'Padang Tembak, Sungai Rokam (Manjung Utara)': 'PRK08',
            'Lumut, Sitiawan, Pangkor (Manjung)': 'PRK09'
        },
        'Perlis': { 'Seluruh Perlis': 'PLS01' },
        'Selangor': {
            'Gombak, Petaling, Sepang, Hulu Langat, Hulu Selangor, S.Alam': 'SGR01',
            'Klang, Kuala Langat': 'SGR02',
            'Kuala Selangor': 'SGR03',
            'Sabak Bernam': 'SGR04'
        },
        'Terengganu': {
            'Kuala Terengganu, Marang, Hulu Terengganu': 'TRG01',
            'Besut, Setiu': 'TRG02',
            'Kemaman, Dungun': 'TRG03',
            'Hulu Terengganu (Hulu)': 'TRG04'
        },
        'Sabah': {
            'Kota Kinabalu, Ranau, Tambunan': 'SBH01',
            'Sandakan, Kinabatangan, Telupid': 'SBH02',
            'Lahad Datu': 'SBH03',
            'Tawau': 'SBH04',
            'Kota Belud': 'SBH05',
            'Kudat, Kota Marudu, Pitas': 'SBH06',
            'Papar, Putatan': 'SBH07',
            'Beaufort, Kuala Penyu, Sipitang, Tenom, Nabawan': 'SBH08',
            'Keningau, Tambunan': 'SBH09'
        },
        'Sarawak': {
            'Kuching, Samarahan': 'SWK01',
            'Sri Aman': 'SWK02',
            'Sibu, Mukah': 'SWK03',
            'Miri, Bintulu': 'SWK04',
            'Limbang, Lawas': 'SWK05',
            'Kapit, Belaga': 'SWK06',
            'Betong, Saratok': 'SWK07',
            'Sarikei, Julau': 'SWK08',
            'Marudi, Tutoh, Subis': 'SWK09'
        }
    };

    var DEFAULT_STATE = 'Perak';
    var DEFAULT_ZONE  = 'PRK09';

    var currentTimes = {};

    var stateEl  = document.getElementById('pt-state-select');
    var zoneEl   = document.getElementById('pt-zone-select');
    var proxyUrl = '{{ route("waktu.solat") }}';

    // ── Populate state dropdown ─────────────────────────────────────────────
    function populateStates() {
        Object.keys(stateZones).forEach(function (s) {
            var o = document.createElement('option');
            o.value = s; o.textContent = s;
            stateEl.appendChild(o);
        });
        stateEl.value = DEFAULT_STATE;
        populateZones(DEFAULT_STATE);
    }

    function populateZones(state) {
        zoneEl.innerHTML = '';
        var zones = stateZones[state] || {};
        Object.keys(zones).forEach(function (name) {
            var o = document.createElement('option');
            o.value = zones[name]; o.textContent = name;
            zoneEl.appendChild(o);
        });
        if (state === DEFAULT_STATE) zoneEl.value = DEFAULT_ZONE;
    }

    // ── Clock tick ─────────────────────────────────────────────────────────
    var msMonths = ['Jan','Feb','Mac','Apr','Mei','Jun','Jul','Ogs','Sep','Okt','Nov','Dis'];
    var msDays   = ['Ahad','Isnin','Selasa','Rabu','Khamis','Jumaat','Sabtu'];

    function updateClock() {
        var now = new Date();
        var h = String(now.getHours()).padStart(2,'0');
        var m = String(now.getMinutes()).padStart(2,'0');
        var s = String(now.getSeconds()).padStart(2,'0');

        document.getElementById('pt-h1').textContent = h[0];
        document.getElementById('pt-h2').textContent = h[1];
        document.getElementById('pt-m1').textContent = m[0];
        document.getElementById('pt-m2').textContent = m[1];
        document.getElementById('pt-s1').textContent = s[0];
        document.getElementById('pt-s2').textContent = s[1];

        var gEl = document.getElementById('pt-greg-date');
        if (gEl) {
            gEl.textContent = msDays[now.getDay()] + ', ' +
                now.getDate() + ' ' + msMonths[now.getMonth()] + ' ' + now.getFullYear();
        }

        if (Object.keys(currentTimes).length > 0) updateActivePrayer(now);
    }

    // ── Active prayer highlight ─────────────────────────────────────────────
    function toMins(t) {
        if (!t || t === '--:--') return -1;
        var p = t.split(':');
        return parseInt(p[0]) * 60 + parseInt(p[1] || 0);
    }

    function updateActivePrayer(now) {
        var nowMins = now.getHours() * 60 + now.getMinutes();
        var order   = ['fajr','syuruk','dhuhr','asr','maghrib','isha'];
        var active  = null;

        // Walk backwards: find the latest prayer that has started
        for (var i = order.length - 1; i >= 0; i--) {
            var mins = toMins(currentTimes[order[i]]);
            if (mins >= 0 && mins <= nowMins) { active = order[i]; break; }
        }
        // After midnight before Subuh → Isyak still active
        if (!active && toMins(currentTimes['isha']) > nowMins) active = 'isha';

        document.querySelectorAll('.prayer-time-box').forEach(function (box) {
            var isActive = box.getAttribute('data-prayer') === active;
            // Card bg
            if (isActive) {
                box.style.background = '#2563eb';
                box.style.borderColor = '#2563eb';
            } else {
                box.style.background = '';
                box.style.borderColor = '';
            }
            // Time text
            var timeEl  = box.querySelector('.pt-time');
            var labelEl = box.querySelector('.pt-label');
            if (timeEl)  timeEl.style.color  = isActive ? '#fff' : '';
            if (labelEl) labelEl.style.color = isActive ? 'rgba(186,222,255,0.9)' : '';
        });
    }

    // ── Hijri formatting ───────────────────────────────────────────────────
    var hijriMap = {
        'Muharram':'Muharram','Safar':'Safar',
        'Rabi-ul-Awwal':'Rabiulawal','Rabiulawal':'Rabiulawal',
        'Rabi-ul-Akhir':'Rabiulakhir','Rabiulakhir':'Rabiulakhir',
        'Jamadi-ul-Awwal':'Jamadilawal','Jamadilawal':'Jamadilawal',
        'Jamadi-ul-Akhir':'Jamadilakhir','Jamadilakhir':'Jamadilakhir',
        'Rajab':'Rejab',"Sha'ban":'Syaaban','Syaaban':'Syaaban',
        'Ramadhan':'Ramadan','Ramadan':'Ramadan','Syawal':'Syawal',
        'Zul-Kaedah':'Zulkaedah','Zulkaedah':'Zulkaedah',
        'Zul-Hijjah':'Zulhijjah','Zulhijjah':'Zulhijjah'
    };
    function formatHijri(str) {
        // e.g. "15-Zul-Kaedah-1447"
        var p = str.split('-');
        if (p.length < 3) return str;
        var day  = p[0];
        var year = p[p.length - 1];
        var monthRaw = p.slice(1, p.length - 1).join('-');
        return day + ' ' + (hijriMap[monthRaw] || monthRaw) + ' ' + year + 'H';
    }

    // ── 24h → 12h Malaysian format ─────────────────────────────────────────
    function fmt12(t) {
        if (!t || t === '--:--') return '--:--';
        var p = t.split(':');
        var h = parseInt(p[0]); var m = p[1];
        var ap = h >= 12 ? 'PTG' : 'PGI';
        if (h === 0) h = 12; else if (h > 12) h -= 12;
        return String(h).padStart(2,'0') + ':' + m;
    }

    // ── Fetch prayer times ─────────────────────────────────────────────────
    function fetchPrayer(zone) {
        var status = document.getElementById('pt-api-status');
        if (status) status.textContent = 'Memuatkan...';

        fetch(proxyUrl + '?zone=' + encodeURIComponent(zone), {
            credentials: 'same-origin',
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(function (res) { return res.json(); })
        .then(function (data) {
            if (data.status !== 'OK!' || !data.prayerTime || !data.prayerTime.length) {
                throw new Error(data.message || 'Data tidak tersedia');
            }
            var pt = data.prayerTime[0];
            currentTimes = {
                fajr: pt.fajr, syuruk: pt.syuruk, dhuhr: pt.dhuhr,
                asr:  pt.asr,  maghrib: pt.maghrib, isha: pt.isha
            };

            var ids = { fajr:'pt-fajr', syuruk:'pt-syuruk', dhuhr:'pt-dhuhr',
                        asr:'pt-asr',   maghrib:'pt-maghrib', isha:'pt-isha' };
            Object.keys(ids).forEach(function (k) {
                var el = document.getElementById(ids[k]);
                if (el) el.textContent = fmt12(currentTimes[k]);
            });

            if (pt.hijri) {
                var hEl = document.getElementById('pt-hijri-date');
                if (hEl) hEl.textContent = formatHijri(pt.hijri);
            }

            if (status) {
                status.textContent = '✓ Dikemaskini';
                setTimeout(function () { if (status) status.textContent = ''; }, 3000);
            }
            updateActivePrayer(new Date());
        })
        .catch(function (err) {
            if (status) status.textContent = '⚠ Gagal memuatkan';
        });
    }

    // ── Update left-panel location label ──────────────────────────────────
    function updateLocation() {
        var opt  = zoneEl.options[zoneEl.selectedIndex];
        var name = opt ? opt.textContent : '';
        var el   = document.getElementById('pt-location-display');
        if (el) el.textContent = name.length > 28 ? name.substring(0, 28) + '…' : name;
    }

    // ── Event listeners ────────────────────────────────────────────────────
    stateEl.addEventListener('change', function () {
        populateZones(this.value);
        updateLocation();
        if (zoneEl.value) fetchPrayer(zoneEl.value);
    });
    zoneEl.addEventListener('change', function () {
        if (this.value) { updateLocation(); fetchPrayer(this.value); }
    });

    // ── Boot ───────────────────────────────────────────────────────────────
    populateStates();
    updateClock();
    setInterval(updateClock, 1000);
    fetchPrayer(DEFAULT_ZONE);

})();
</script>
