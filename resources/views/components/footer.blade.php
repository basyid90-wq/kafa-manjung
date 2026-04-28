<footer class="rbt-footer footer-style-1 bg-color-white overflow-hidden">
    <div class="footer-top pt--20 pb--50">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <!-- Section 1: Logos -->
                    <div class="footer-logos mb--30 d-flex gap-4 justify-content-center">
                        <img src="{{ url('/template/perak.png') }}" alt="Logo Perak" style="max-height: 160px; object-fit: contain;">
                        <img src="{{ url('/template/kafa.png') }}" alt="Logo KAFA" style="max-height: 160px; object-fit: contain;">
                    </div>


                    <!-- Section 2: Islamic Widget Card -->
                    <div class="islamic-widget-container p-4 rounded-4 shadow-sm mb--40" style="background: #f8f9fa; border: 1px solid #e9ecef;">
                        <div class="row align-items-center">
                            <!-- Flip Clock & Dates -->
                            <div class="col-lg-5 mb_md--30 mb_sm--30 border-end border-md-0">
                                <div class="d-flex flex-column align-items-center">
                                    <div class="flip-clock mb--10" id="flip-clock">
                                        <div class="clock-unit"><span id="hours">00</span><small>Jam</small></div>
                                        <div class="clock-separator">:</div>
                                        <div class="clock-unit"><span id="minutes">00</span><small>Minit</small></div>
                                        <div class="clock-separator">:</div>
                                        <div class="clock-unit"><span id="seconds">00</span><small>Saat</small></div>
                                    </div>
                                    <div class="dates-display text-center">
                                        <h5 class="mb-0 color-primary" id="gregorian-date">-- --- ----</h5>
                                        <p class="text-muted mb-0" id="hijri-date">-- --- ----</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Prayer Times Grid -->
                            <div class="col-lg-7">
                                <div class="prayer-times-grid" id="prayer-times">
                                    <div class="prayer-item" data-prayer="Fajr">
                                        <span class="p-label">Subuh</span>
                                        <span class="p-time">--:--</span>
                                    </div>
                                    <div class="prayer-item" data-prayer="Sunrise">
                                        <span class="p-label">Syuruk</span>
                                        <span class="p-time">--:--</span>
                                    </div>
                                    <div class="prayer-item" data-prayer="Dhuhr">
                                        <span class="p-label">Zohor</span>
                                        <span class="p-time">--:--</span>
                                    </div>
                                    <div class="prayer-item" data-prayer="Asr">
                                        <span class="p-label">Asar</span>
                                        <span class="p-time">--:--</span>
                                    </div>
                                    <div class="prayer-item" data-prayer="Maghrib">
                                        <span class="p-label">Maghrib</span>
                                        <span class="p-time">--:--</span>
                                    </div>
                                    <div class="prayer-item" data-prayer="Isha">
                                        <span class="p-label">Isyak</span>
                                        <span class="p-time">--:--</span>
                                    </div>
                                </div>
                                <div class="text-center mt--10">
                                    <small class="text-muted"><i class="feather-map-pin"></i> Manjung, Perak</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section 3: Copyright -->
                    <div class="copyright-text text-center">
                        <p class="mb-0">Hak Cipta Terpelihara © 2026 Aplikasi Pengurusan KAFA Daerah Manjung (APKM).</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
    /* Flip Clock Styles */
    .flip-clock {
        display: flex;
        gap: 10px;
        align-items: center;
        font-family: 'Outfit', sans-serif;
    }
    .clock-unit {
        background: #2f57ef;
        color: white;
        padding: 10px 15px;
        border-radius: 8px;
        min-width: 70px;
        text-align: center;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
    .clock-unit span {
        display: block;
        font-size: 28px;
        font-weight: 700;
        line-height: 1;
    }
    .clock-unit small {
        font-size: 10px;
        text-transform: uppercase;
        opacity: 0.8;
    }
    .clock-separator {
        font-size: 24px;
        font-weight: 700;
        color: #2f57ef;
    }

    /* Prayer Grid Styles */
    .prayer-times-grid {
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        gap: 10px;
    }
    .prayer-item {
        background: white;
        padding: 15px 10px;
        border-radius: 12px;
        border: 1px solid #eee;
        transition: all 0.3s ease;
    }
    .prayer-item.active {
        background: #2f57ef;
        color: white;
        border-color: #2f57ef;
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(47, 87, 239, 0.3);
    }
    .prayer-item .p-label {
        display: block;
        font-size: 12px;
        font-weight: 600;
        margin-bottom: 5px;
    }
    .prayer-item .p-time {
        display: block;
        font-size: 16px;
        font-weight: 700;
    }

    @media (max-width: 991px) {
        .prayer-times-grid {
            grid-template-columns: repeat(3, 1fr);
        }
        .border-end {
            border-right: none !important;
            padding-bottom: 30px;
        }
    }
    @media (max-width: 575px) {
        .prayer-times-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- Clock Logic ---
        function updateClock() {
            const now = new Date();
            document.getElementById('hours').textContent = String(now.getHours()).padStart(2, '0');
            document.getElementById('minutes').textContent = String(now.getMinutes()).padStart(2, '0');
            document.getElementById('seconds').textContent = String(now.getSeconds()).padStart(2, '0');
        }
        setInterval(updateClock, 1000);
        updateClock();

        // --- Dates Logic ---
        function updateDates() {
            const now = new Date();
            // Gregorian
            const gregOptions = { day: 'numeric', month: 'long', year: 'numeric' };
            document.getElementById('gregorian-date').textContent = now.toLocaleDateString('ms-MY', gregOptions);
            
            // Hijri
            const hijriOptions = { day: 'numeric', month: 'long', year: 'numeric', calendar: 'islamic-uma' };
            const hijriDate = new Intl.DateTimeFormat('ms-MY-u-ca-islamic-uma', hijriOptions).format(now);
            document.getElementById('hijri-date').textContent = hijriDate + ' Hijriah';
        }
        updateDates();

        // --- Prayer Times Logic ---
        async function fetchPrayerTimes() {
            try {
                // Al-Adhan API for Manjung, Perak (Approx coords)
                const response = await fetch('https://api.aladhan.com/v1/timingsByCity?city=Manjung&country=Malaysia&method=11');
                const data = await response.json();
                const timings = data.data.timings;

                const prayerMap = {
                    'Fajr': timings.Fajr,
                    'Sunrise': timings.Sunrise,
                    'Dhuhr': timings.Dhuhr,
                    'Asr': timings.Asr,
                    'Maghrib': timings.Maghrib,
                    'Isha': timings.Isha
                };

                for (const [key, time] of Object.entries(prayerMap)) {
                    const item = document.querySelector(`.prayer-item[data-prayer="${key}"]`);
                    if (item) {
                        item.querySelector('.p-time').textContent = time;
                    }
                }

                highlightCurrentPrayer(prayerMap);

            } catch (error) {
                console.error('Error fetching prayer times:', error);
            }
        }

        function highlightCurrentPrayer(timings) {
            const now = new Date();
            const currentTime = now.getHours() * 60 + now.getMinutes();

            let currentPrayer = '';
            
            // Convert timings to minutes
            const prayerMinutes = {};
            for (const [key, time] of Object.entries(timings)) {
                const [h, m] = time.split(':').map(Number);
                prayerMinutes[key] = h * 60 + m;
            }

            // Simple logic: check range
            if (currentTime >= prayerMinutes.Isha || currentTime < prayerMinutes.Fajr) currentPrayer = 'Isha';
            else if (currentTime >= prayerMinutes.Maghrib) currentPrayer = 'Maghrib';
            else if (currentTime >= prayerMinutes.Asr) currentPrayer = 'Asr';
            else if (currentTime >= prayerMinutes.Dhuhr) currentPrayer = 'Dhuhr';
            else if (currentTime >= prayerMinutes.Sunrise) currentPrayer = 'Sunrise';
            else if (currentTime >= prayerMinutes.Fajr) currentPrayer = 'Fajr';

            document.querySelectorAll('.prayer-item').forEach(el => el.classList.remove('active'));
            const activeItem = document.querySelector(`.prayer-item[data-prayer="${currentPrayer}"]`);
            if (activeItem) activeItem.classList.add('active');
        }

        fetchPrayerTimes();
    });
</script>
