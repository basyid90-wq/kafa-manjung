{{-- eKafa Online — laman utama + log masuk (AuthenticatedSessionController@create).
     Dijana daripada draf Claude Design: scratch/ekafa-landing.html. Halaman awam kendiri (bukan layout-fb.auth) kerana ada <head> pemasaran sendiri. --}}
<!DOCTYPE html>
<html lang="ms">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>eKafa Online — Platform Pengurusan KAFA dalam Satu Tempat</title>
<meta name="description" content="eKafa Online membantu Guru Besar, Guru KAFA dan ibu bapa mengurus kehadiran, RPH, peperiksaan dan perkembangan murid KAFA — terus dari telefon. Percuma untuk 3 kelas.">
<meta name="theme-color" content="#2563EB">

<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet">
@vite(['resources/css/app.css', 'resources/js/app.js'])
<script>document.documentElement.classList.add('js');</script>

<style>
    @font-face { font-family: 'LateefLocal'; src: url('/fonts/Lateef-Regular.ttf') format('truetype'); font-display: swap; }
    :root { --brand: #2563EB; --brand-700: #1D4ED8; --ink: #0F172A; }
    html { scroll-padding-top: 84px; -webkit-text-size-adjust: 100%; }
    body { font-family: 'Inter', ui-sans-serif, system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif; color: var(--ink); background: #fff; text-rendering: optimizeLegibility; -webkit-font-smoothing: antialiased; }
    [x-cloak] { display: none !important; }
    .jawi { font-family: 'LateefLocal', 'Lateef', serif; line-height: 1.7; }

    /* Focus states */
    a:focus-visible, button:focus-visible, summary:focus-visible, [role="tab"]:focus-visible {
        outline: 2px solid var(--brand); outline-offset: 3px; border-radius: 10px;
    }
    .on-dark a:focus-visible, .on-dark button:focus-visible { outline-color: #fff; }

    /* Islamic geometric pattern — 8-point star */
    .pattern-star {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='80' height='80' viewBox='0 0 80 80'%3E%3Cg fill='none' stroke='%232563EB' stroke-width='1'%3E%3Cpath d='M60 40L54.14 45.86L54.14 54.14L45.86 54.14L40 60L34.14 54.14L25.86 54.14L25.86 45.86L20 40L25.86 34.14L25.86 25.86L34.14 25.86L40 20L45.86 25.86L54.14 25.86L54.14 34.14Z'/%3E%3Ccircle cx='40' cy='40' r='6'/%3E%3Cpath d='M0 0L20 40M80 0L60 40M0 80L20 40M80 80L60 40M0 0L40 20M80 0L40 20M0 80L40 60M80 80L40 60' stroke-opacity='.5'/%3E%3C/g%3E%3C/svg%3E");
        background-size: 80px 80px;
    }
    .pattern-star-light {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='80' height='80' viewBox='0 0 80 80'%3E%3Cg fill='none' stroke='%23FFFFFF' stroke-width='1'%3E%3Cpath d='M60 40L54.14 45.86L54.14 54.14L45.86 54.14L40 60L34.14 54.14L25.86 54.14L25.86 45.86L20 40L25.86 34.14L25.86 25.86L34.14 25.86L40 20L45.86 25.86L54.14 25.86L54.14 34.14Z'/%3E%3Ccircle cx='40' cy='40' r='6'/%3E%3Cpath d='M0 0L20 40M80 0L60 40M0 80L20 40M80 80L60 40M0 0L40 20M80 0L40 20M0 80L40 60M80 80L40 60' stroke-opacity='.5'/%3E%3C/g%3E%3C/svg%3E");
        background-size: 80px 80px;
    }
    .mask-fade { -webkit-mask-image: radial-gradient(ellipse 70% 60% at 50% 40%, #000 20%, transparent 75%); mask-image: radial-gradient(ellipse 70% 60% at 50% 40%, #000 20%, transparent 75%); }

    /* Keyframes */
    @keyframes fadeUp { from { opacity: 0; transform: translateY(18px); } to { opacity: 1; transform: none; } }
    @keyframes floatY { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
    @keyframes floatYSm { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-6px); } }
    @keyframes growBar { from { transform: scaleY(0); } to { transform: scaleY(1); } }
    @keyframes scanLine { 0% { top: 8%; } 50% { top: 86%; } 100% { top: 8%; } }
    @keyframes ringDraw { from { stroke-dashoffset: 213.6; } }
    @keyframes stampIn { 0% { opacity: 0; transform: rotate(-12deg) scale(1.6); } 60% { opacity: 1; transform: rotate(-12deg) scale(.95); } 100% { opacity: 1; transform: rotate(-12deg) scale(1); } }
    @keyframes pulseDot { 0% { box-shadow: 0 0 0 0 rgba(16,185,129,.45); } 100% { box-shadow: 0 0 0 10px rgba(16,185,129,0); } }

    .anim-up { animation: fadeUp .8s cubic-bezier(.2,.7,.2,1) both; animation-delay: var(--d, 0ms); }
    .float-slow { animation: floatY 7s ease-in-out infinite; }
    .float-a { animation: floatYSm 5s ease-in-out infinite; }
    .float-b { animation: floatYSm 6s ease-in-out 1.2s infinite; }
    .bar { transform-origin: bottom; animation: growBar 1s cubic-bezier(.2,.7,.2,1) both; animation-delay: var(--d, 0ms); }
    .scan-line { animation: scanLine 2.6s ease-in-out infinite; }
    .ring-draw { animation: ringDraw 1.6s cubic-bezier(.2,.7,.2,1) both; }
    .stamp { animation: stampIn .6s cubic-bezier(.2,.7,.2,1) .35s both; }
    .live-dot { animation: pulseDot 1.8s ease-out infinite; }

    /* Scroll reveal */
    .js .reveal { opacity: 0; transform: translateY(24px); transition: opacity .7s ease, transform .7s cubic-bezier(.2,.7,.2,1); transition-delay: var(--d, 0ms); }
    .js .reveal.is-in { opacity: 1; transform: none; }

    /* Hover */
    .lift { transition: transform .25s ease, box-shadow .25s ease, border-color .25s ease; }
    .lift:hover { transform: translateY(-4px); box-shadow: 0 18px 40px -18px rgba(15, 23, 42, .25); }
    .btn-grad { background-image: linear-gradient(110deg, #2563EB 0%, #1D4ED8 50%, #2563EB 100%); background-size: 200% 100%; background-position: 0 0; transition: background-position .5s ease, box-shadow .25s ease, transform .2s ease; box-shadow: 0 8px 20px -8px rgba(37, 99, 235, .55); }
    .btn-grad:hover { background-position: 100% 0; box-shadow: 0 12px 26px -10px rgba(37, 99, 235, .7); }
    .btn-grad:active { transform: translateY(1px); }
    .text-grad { background-image: linear-gradient(90deg, #2563EB, #0D9488); -webkit-background-clip: text; background-clip: text; color: transparent; }

    .tab-scroll { scrollbar-width: none; }
    .tab-scroll::-webkit-scrollbar { display: none; }
    .stack > * { grid-area: 1 / 1; }

    @media (prefers-reduced-motion: reduce) {
        *, *::before, *::after { animation-duration: .01ms !important; animation-iteration-count: 1 !important; animation-delay: 0ms !important; transition-duration: .01ms !important; transition-delay: 0ms !important; }
        .js .reveal { opacity: 1; transform: none; }
        .lift:hover { transform: none; }
    }
</style>
</head>
<body class="antialiased">

<!-- ===== Icon sprite (Heroicons outline) ===== -->
<svg xmlns="http://www.w3.org/2000/svg" style="display:none">
    <symbol id="i-check" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m4.5 12.75 6 6 9-13.5"/></symbol>
    <symbol id="i-x" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M6 18 18 6M6 6l12 12"/></symbol>
    <symbol id="i-menu" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/></symbol>
    <symbol id="i-arrow-right" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/></symbol>
    <symbol id="i-arrow-down" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M19.5 13.5 12 21m0 0-7.5-7.5M12 21V3"/></symbol>
    <symbol id="i-chevron-down" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="m19.5 8.25-7.5 7.5-7.5-7.5"/></symbol>
    <symbol id="i-qr" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 3.75 9.375v-4.5ZM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 0 1-1.125-1.125v-4.5ZM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 13.5 9.375v-4.5Z"/><path d="M6.75 6.75h.75v.75h-.75v-.75ZM6.75 16.5h.75v.75h-.75v-.75ZM16.5 6.75h.75v.75h-.75v-.75ZM13.5 13.5h.75v.75h-.75v-.75ZM13.5 19.5h.75v.75h-.75v-.75ZM19.5 13.5h.75v.75h-.75v-.75ZM19.5 19.5h.75v.75h-.75v-.75ZM16.5 16.5h.75v.75h-.75v-.75Z"/></symbol>
    <symbol id="i-doc" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/></symbol>
    <symbol id="i-doc-check" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M10.125 2.25h-4.5c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125v-9M10.125 2.25h.375a9 9 0 0 1 9 9v.375M10.125 2.25A3.375 3.375 0 0 1 13.5 5.625v1.5c0 .621.504 1.125 1.125 1.125h1.5a3.375 3.375 0 0 1 3.375 3.375M9 15l2.25 2.25L15 12"/></symbol>
    <symbol id="i-clipboard" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0 1 18 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3 1.5 1.5 3-3.75"/></symbol>
    <symbol id="i-trophy" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M16.5 18.75h-9m9 0a3 3 0 0 1 3 3h-15a3 3 0 0 1 3-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 0 1-.982-3.172M9.497 14.25a7.454 7.454 0 0 0 .981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 0 0 7.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M7.73 9.728a6.726 6.726 0 0 0 2.748 1.35m8.272-6.842V4.5c0 2.108-.966 3.99-2.48 5.228m2.48-5.492a46.32 46.32 0 0 1 2.916.52 6.003 6.003 0 0 1-5.395 4.972m0 0a6.726 6.726 0 0 1-2.749 1.35m0 0a6.772 6.772 0 0 1-3.044 0"/></symbol>
    <symbol id="i-flag" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v1.5M3 21v-6m0 0 2.77-.693a9 9 0 0 1 6.208.682l.108.054a9 9 0 0 0 6.086.71l3.114-.732a48.524 48.524 0 0 1-.005-10.499l-3.11.732a9 9 0 0 1-6.085-.711l-.108-.054a9 9 0 0 0-6.208-.682L3 4.5M3 15V4.5"/></symbol>
    <symbol id="i-sparkles" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09ZM18.259 8.715 18 9.75l-.259-1.035a3.375 3.375 0 0 0-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 0 0 2.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 0 0 2.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 0 0-2.456 2.456Z"/></symbol>
    <symbol id="i-calendar" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/></symbol>
    <symbol id="i-chart" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z"/></symbol>
    <symbol id="i-banknotes" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z"/></symbol>
    <symbol id="i-phone" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M10.5 1.5H8.25A2.25 2.25 0 0 0 6 3.75v16.5a2.25 2.25 0 0 0 2.25 2.25h7.5A2.25 2.25 0 0 0 18 20.25V3.75a2.25 2.25 0 0 0-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3"/></symbol>
    <symbol id="i-megaphone" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 1 1 0-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 0 1-1.44-4.282m3.102.069a18.03 18.03 0 0 1-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 0 1 8.835 2.535M10.34 6.66a23.847 23.847 0 0 0 8.835-2.535m0 0A23.74 23.74 0 0 0 18.795 3m.38 1.125a23.91 23.91 0 0 1 1.014 5.395m-1.014 8.855c-.118.38-.245.754-.38 1.125m.38-1.125a23.91 23.91 0 0 0 1.014-5.395m0-3.46c.495.413.811 1.035.811 1.73 0 .695-.316 1.317-.811 1.73m0-3.46a24.347 24.347 0 0 1 0 3.46"/></symbol>
    <symbol id="i-users" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/></symbol>
    <symbol id="i-user" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/></symbol>
    <symbol id="i-user-plus" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z"/></symbol>
    <symbol id="i-school" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75Z"/></symbol>
    <symbol id="i-academic" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5"/></symbol>
    <symbol id="i-heart" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z"/></symbol>
    <symbol id="i-shield" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z"/></symbol>
    <symbol id="i-lock" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"/></symbol>
    <symbol id="i-eye" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/><path d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></symbol>
    <symbol id="i-eye-off" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88"/></symbol>
    <symbol id="i-cloud" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 16.5V9.75m0 0 3 3m-3-3-3 3M6.75 19.5a4.5 4.5 0 0 1-1.41-8.775 5.25 5.25 0 0 1 10.233-2.33 3 3 0 0 1 3.758 3.848A3.752 3.752 0 0 1 18 19.5H6.75Z"/></symbol>
    <symbol id="i-globe" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 0 1 3 12c0-1.605.42-3.113 1.157-4.418"/></symbol>
    <symbol id="i-chat" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 0 1-.825-.242m9.345-8.334a2.126 2.126 0 0 0-.476-.095 48.64 48.64 0 0 0-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0 0 11.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155"/></symbol>
    <symbol id="i-download" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3"/></symbol>
    <symbol id="i-clock" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></symbol>
    <symbol id="i-grid" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z"/></symbol>
    <symbol id="i-book" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25"/></symbol>
    <symbol id="i-plus" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></symbol>
</svg>

<a href="#utama" class="sr-only focus:not-sr-only focus:fixed focus:top-3 focus:left-3 focus:z-[60] focus:px-4 focus:py-2 focus:rounded-lg focus:bg-white focus:text-blue-700 focus:shadow-lg">Langkau ke kandungan</a>

<!-- ========================= 1. NAVBAR ========================= -->
<header x-data="{ scrolled: false, menu: false }"
        x-init="scrolled = window.scrollY > 8"
        x-on:scroll.window="scrolled = window.scrollY > 8"
        x-on:keydown.escape.window="menu = false"
        class="fixed inset-x-0 top-0 z-50 border-b transition-all duration-300"
        :class="(scrolled || menu) ? 'bg-white/85 backdrop-blur-lg border-gray-200/80 shadow-sm' : 'bg-transparent border-transparent'">
    <nav class="mx-auto flex max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8" style="height:68px" aria-label="Navigasi utama">
        <a href="{{ route('home') }}" class="flex items-center gap-2.5" aria-label="eKafa Online — laman utama">
            <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-blue-600 text-sm font-extrabold tracking-tight text-white shadow-md shadow-blue-600/30">eK</span>
            <span class="flex flex-col leading-none">
                <span class="text-[17px] font-bold tracking-tight text-gray-900">eKafa <span class="text-blue-600">Online</span></span>
                <span class="jawi -mt-0.5 text-[15px] text-gray-500" dir="rtl" lang="ms-Arab">ڤڠوروسن کفا</span>
            </span>
        </a>

        <div class="hidden items-center gap-1 md:flex">
            <a href="#ciri" class="rounded-lg px-3 py-2 text-sm font-medium text-gray-600 transition-colors hover:bg-gray-100 hover:text-gray-900">Ciri-ciri</a>
            <a href="#modul" class="rounded-lg px-3 py-2 text-sm font-medium text-gray-600 transition-colors hover:bg-gray-100 hover:text-gray-900">Modul</a>
            <a href="#harga" class="rounded-lg px-3 py-2 text-sm font-medium text-gray-600 transition-colors hover:bg-gray-100 hover:text-gray-900">Harga</a>
            <a href="#soalan" class="rounded-lg px-3 py-2 text-sm font-medium text-gray-600 transition-colors hover:bg-gray-100 hover:text-gray-900">Soalan Lazim</a>
            <a href="{{ route('demo') }}" class="rounded-lg px-3 py-2 text-sm font-semibold text-blue-700 transition-colors hover:bg-blue-50">Cuba Demo</a>
        </div>

        <div class="hidden items-center gap-2 md:flex">
            <a href="#log-masuk" class="rounded-lg px-4 py-2 text-sm font-semibold text-gray-700 transition-colors hover:bg-gray-100 hover:text-gray-900">Log Masuk</a>
            <a href="{{ route('register') }}" class="btn-grad inline-flex items-center gap-2 rounded-lg px-4 py-2 text-sm font-semibold text-white">Daftar Percuma</a>
        </div>

        <button type="button" class="inline-flex h-10 w-10 items-center justify-center rounded-lg text-gray-700 hover:bg-gray-100 md:hidden"
                x-on:click="menu = !menu" :aria-expanded="menu.toString()" aria-controls="menu-mudah-alih" aria-label="Buka menu">
            <svg class="h-6 w-6" aria-hidden="true" x-show="!menu"><use href="#i-menu"/></svg>
            <svg class="h-6 w-6" aria-hidden="true" x-show="menu" x-cloak><use href="#i-x"/></svg>
        </button>
    </nav>

    <div id="menu-mudah-alih" x-show="menu" x-cloak
         x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         class="border-t border-gray-200 bg-white px-4 pb-5 pt-3 md:hidden">
        <div class="flex flex-col gap-1">
            <a href="#ciri" x-on:click="menu = false" class="rounded-lg px-3 py-2.5 text-base font-medium text-gray-700 hover:bg-gray-50">Ciri-ciri</a>
            <a href="#modul" x-on:click="menu = false" class="rounded-lg px-3 py-2.5 text-base font-medium text-gray-700 hover:bg-gray-50">Modul</a>
            <a href="#harga" x-on:click="menu = false" class="rounded-lg px-3 py-2.5 text-base font-medium text-gray-700 hover:bg-gray-50">Harga</a>
            <a href="#soalan" x-on:click="menu = false" class="rounded-lg px-3 py-2.5 text-base font-medium text-gray-700 hover:bg-gray-50">Soalan Lazim</a>
            <a href="{{ route('demo') }}" class="rounded-lg px-3 py-2.5 text-base font-semibold text-blue-700 hover:bg-blue-50">Cuba Demo</a>
        </div>
        <div class="mt-4 grid grid-cols-2 gap-2">
            <a href="#log-masuk" x-on:click="menu = false" class="inline-flex items-center justify-center rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50">Log Masuk</a>
            <a href="{{ route('register') }}" class="btn-grad inline-flex items-center justify-center rounded-lg px-4 py-2.5 text-sm font-semibold text-white">Daftar Percuma</a>
        </div>
    </div>
</header>

<main id="utama">

<!-- ========================= 2. HERO ========================= -->
<section class="relative overflow-hidden" style="padding-top:116px;padding-bottom:88px">
    <div class="pointer-events-none absolute inset-0" aria-hidden="true">
        <div class="absolute rounded-full bg-blue-200/50 blur-3xl" style="width:560px;height:560px;top:-180px;right:-120px"></div>
        <div class="absolute rounded-full bg-teal-100/70 blur-3xl" style="width:420px;height:420px;top:160px;left:-160px"></div>
        <div class="pattern-star mask-fade absolute inset-0" style="opacity:.07"></div>
    </div>

    <div class="relative mx-auto grid max-w-7xl items-center gap-14 px-4 sm:px-6 lg:grid-cols-12 lg:gap-10 lg:px-8">
        <!-- Copy -->
        <div class="lg:col-span-5">
            <span class="anim-up inline-flex items-center gap-2 rounded-full border border-blue-200 bg-white/80 px-3 py-1 text-xs font-semibold text-blue-700 shadow-sm" style="--d:0ms">
                <span class="h-1.5 w-1.5 rounded-full bg-teal-500"></span>
                Dibina khas untuk sekolah KAFA di Malaysia
            </span>
            <h1 class="anim-up mt-5 text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl lg:text-[3.4rem] lg:leading-[1.08]" style="--d:80ms">
                Urus KAFA anda dengan lebih mudah — <span class="text-grad">semuanya dalam satu platform.</span>
            </h1>
            <p class="anim-up mt-5 max-w-xl text-lg leading-relaxed text-gray-600" style="--d:160ms">
                Kehadiran, RPH, peperiksaan dan portal ibu bapa tersusun di satu tempat — boleh guna terus dari telefon. Kurang kerja kertas, lebih masa untuk mengajar.
            </p>
            <div class="anim-up mt-8 flex flex-col gap-3 sm:flex-row" style="--d:240ms">
                <a href="{{ route('register') }}" class="btn-grad inline-flex items-center justify-center gap-2 rounded-xl px-6 py-3.5 text-base font-semibold text-white">
                    Mula Percuma
                    <svg class="h-4 w-4" aria-hidden="true"><use href="#i-arrow-right"/></svg>
                </a>
                <a href="{{ route('register', ['jenis' => 'personal']) }}" class="inline-flex items-center justify-center gap-2 rounded-xl border border-gray-300 bg-white px-6 py-3.5 text-base font-semibold text-gray-800 shadow-sm transition-colors hover:border-gray-400 hover:bg-gray-50">
                    <svg class="h-5 w-5 text-blue-600" aria-hidden="true"><use href="#i-user"/></svg>
                    Saya Guru Individu
                </a>
            </div>
            <a href="{{ route('demo') }}" class="anim-up mt-4 inline-flex items-center gap-1.5 text-sm font-semibold text-blue-700 hover:text-blue-800" style="--d:280ms">
                <svg class="h-4 w-4" aria-hidden="true"><use href="#i-eye"/></svg>
                Cuba demo dahulu — tanpa daftar
                <svg class="h-4 w-4" aria-hidden="true"><use href="#i-arrow-right"/></svg>
            </a>
            <p class="anim-up mt-5 flex flex-wrap items-center gap-x-4 gap-y-1 text-sm text-gray-600" style="--d:320ms">
                <span class="inline-flex items-center gap-1.5"><svg class="h-4 w-4 text-teal-600" aria-hidden="true"><use href="#i-check"/></svg>Percuma selamanya untuk 3 kelas</span>
                <span class="hidden text-gray-300 sm:inline" aria-hidden="true">·</span>
                <span class="inline-flex items-center gap-1.5"><svg class="h-4 w-4 text-teal-600" aria-hidden="true"><use href="#i-check"/></svg>Tiada kad kredit diperlukan</span>
            </p>
        </div>

        <!-- Mock dashboard -->
        <div class="relative lg:col-span-7" aria-hidden="true">
            <div class="anim-up" style="--d:200ms">
                <div class="float-slow">
                    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-2xl shadow-blue-900/10">
                        <!-- window bar -->
                        <div class="flex items-center gap-2 border-b border-gray-100 bg-gray-50/80 px-4 py-2.5">
                            <span class="h-2.5 w-2.5 rounded-full bg-red-300"></span>
                            <span class="h-2.5 w-2.5 rounded-full bg-amber-300"></span>
                            <span class="h-2.5 w-2.5 rounded-full bg-green-300"></span>
                            <span class="ml-3 flex-1 truncate rounded-md bg-white px-3 py-1 text-[11px] text-gray-500 ring-1 ring-gray-200">ekafa.online/dashboard</span>
                        </div>
                        <div class="flex">
                            <!-- sidebar -->
                            <div class="hidden w-44 shrink-0 flex-col gap-1 border-r border-gray-100 bg-gray-50/60 p-3 md:flex">
                                <div class="mb-2 flex items-center gap-2 px-2 py-1">
                                    <span class="flex h-6 w-6 items-center justify-center rounded-md bg-blue-600 text-[10px] font-bold text-white">eK</span>
                                    <span class="text-xs font-bold text-gray-800">KAFA Al-Hidayah</span>
                                </div>
                                <span class="flex items-center gap-2 rounded-lg bg-blue-600 px-2.5 py-2 text-[11px] font-semibold text-white"><svg class="h-4 w-4"><use href="#i-grid"/></svg>Dashboard</span>
                                <span class="flex items-center gap-2 rounded-lg px-2.5 py-2 text-[11px] font-medium text-gray-600"><svg class="h-4 w-4"><use href="#i-qr"/></svg>Kehadiran</span>
                                <span class="flex items-center gap-2 rounded-lg px-2.5 py-2 text-[11px] font-medium text-gray-600"><svg class="h-4 w-4"><use href="#i-doc"/></svg>Rekod RPH</span>
                                <span class="flex items-center gap-2 rounded-lg px-2.5 py-2 text-[11px] font-medium text-gray-600"><svg class="h-4 w-4"><use href="#i-clipboard"/></svg>Peperiksaan</span>
                                <span class="flex items-center gap-2 rounded-lg px-2.5 py-2 text-[11px] font-medium text-gray-600"><svg class="h-4 w-4"><use href="#i-users"/></svg>Murid</span>
                                <span class="flex items-center gap-2 rounded-lg px-2.5 py-2 text-[11px] font-medium text-gray-600"><svg class="h-4 w-4"><use href="#i-chart"/></svg>Laporan</span>
                            </div>
                            <!-- main -->
                            <div class="min-w-0 flex-1 p-4 sm:p-5">
                                <div class="flex items-center justify-between gap-3">
                                    <div class="min-w-0">
                                        <p class="text-[11px] text-gray-500">Isnin, 19 Oktober 2026</p>
                                        <p class="truncate text-sm font-bold text-gray-900 sm:text-base">Assalamualaikum, Ustazah Aminah</p>
                                    </div>
                                    <span class="hidden shrink-0 items-center gap-1.5 rounded-full bg-green-50 px-2.5 py-1 text-[10px] font-semibold text-green-700 sm:inline-flex"><span class="live-dot h-1.5 w-1.5 rounded-full bg-green-500"></span>Sesi petang</span>
                                </div>

                                <div class="mt-4 grid grid-cols-2 gap-2.5 xl:grid-cols-4">
                                    <div class="anim-up rounded-xl border border-gray-100 bg-white p-3 shadow-sm" style="--d:420ms">
                                        <p class="text-[10px] font-medium text-gray-500">Jumlah Murid</p>
                                        <p class="mt-1 text-xl font-bold text-gray-900">120</p>
                                        <p class="text-[10px] font-medium text-teal-700">+8 sesi ini</p>
                                    </div>
                                    <div class="anim-up rounded-xl border border-blue-100 bg-blue-50/60 p-3 shadow-sm" style="--d:500ms">
                                        <p class="text-[10px] font-medium text-blue-700">Kehadiran Hari Ini</p>
                                        <p class="mt-1 text-xl font-bold text-blue-700"><span data-count-to="96">96</span>%</p>
                                        <p class="text-[10px] font-medium text-gray-500">115 / 120 hadir</p>
                                    </div>
                                    <div class="anim-up rounded-xl border border-gray-100 bg-white p-3 shadow-sm" style="--d:580ms">
                                        <p class="text-[10px] font-medium text-gray-500">RPH Menunggu Semakan</p>
                                        <p class="mt-1 text-xl font-bold text-amber-600">3</p>
                                        <p class="text-[10px] font-medium text-gray-500">perlu tindakan</p>
                                    </div>
                                    <div class="anim-up rounded-xl border border-gray-100 bg-white p-3 shadow-sm" style="--d:660ms">
                                        <p class="text-[10px] font-medium text-gray-500">Kelas</p>
                                        <p class="mt-1 text-xl font-bold text-gray-900">6</p>
                                        <p class="text-[10px] font-medium text-gray-500">Tahun 1 – 6</p>
                                    </div>
                                </div>

                                <div class="mt-3 grid gap-3 sm:grid-cols-5">
                                    <!-- bar chart -->
                                    <div class="anim-up rounded-xl border border-gray-100 p-3 sm:col-span-3" style="--d:740ms">
                                        <div class="flex items-center justify-between">
                                            <p class="text-[11px] font-semibold text-gray-800">Kehadiran Mingguan</p>
                                            <span class="text-[10px] text-gray-500">Purata 95%</span>
                                        </div>
                                        <div class="mt-3 flex items-end justify-between gap-2" style="height:96px">
                                            <div class="flex h-full flex-1 flex-col items-center justify-end gap-1"><div class="bar w-full rounded-md bg-blue-200" style="height:76%;--d:800ms"></div><span class="text-[9px] text-gray-500">Isn</span></div>
                                            <div class="flex h-full flex-1 flex-col items-center justify-end gap-1"><div class="bar w-full rounded-md bg-blue-300" style="height:88%;--d:880ms"></div><span class="text-[9px] text-gray-500">Sel</span></div>
                                            <div class="flex h-full flex-1 flex-col items-center justify-end gap-1"><div class="bar w-full rounded-md bg-blue-200" style="height:70%;--d:960ms"></div><span class="text-[9px] text-gray-500">Rab</span></div>
                                            <div class="flex h-full flex-1 flex-col items-center justify-end gap-1"><div class="bar w-full rounded-md bg-blue-300" style="height:84%;--d:1040ms"></div><span class="text-[9px] text-gray-500">Kha</span></div>
                                            <div class="flex h-full flex-1 flex-col items-center justify-end gap-1"><div class="bar w-full rounded-md bg-blue-600" style="height:92%;--d:1120ms"></div><span class="text-[9px] font-semibold text-blue-700">Jum</span></div>
                                        </div>
                                    </div>
                                    <!-- schedule -->
                                    <div class="anim-up rounded-xl border border-gray-100 p-3 sm:col-span-2" style="--d:820ms">
                                        <p class="text-[11px] font-semibold text-gray-800">Jadual Hari Ini</p>
                                        <ul class="mt-2 space-y-2">
                                            <li class="flex items-center gap-2"><span class="w-9 shrink-0 text-[10px] font-semibold text-blue-700">2:30</span><span class="min-w-0"><span class="block truncate text-[11px] font-medium text-gray-800">Al-Quran</span><span class="block truncate text-[9px] text-gray-500">Tahun 4 Abu Bakar</span></span></li>
                                            <li class="flex items-center gap-2"><span class="w-9 shrink-0 text-[10px] font-semibold text-gray-500">3:10</span><span class="min-w-0"><span class="block truncate text-[11px] font-medium text-gray-800">Ibadat</span><span class="block truncate text-[9px] text-gray-500">Tahun 5 Umar</span></span></li>
                                            <li class="flex items-center gap-2"><span class="w-9 shrink-0 text-[10px] font-semibold text-gray-500">3:50</span><span class="min-w-0"><span class="block truncate text-[11px] font-medium text-gray-800">Jawi dan Khat</span><span class="block truncate text-[9px] text-gray-500">Tahun 3 Uthman</span></span></li>
                                            <li class="flex items-center gap-2"><span class="w-9 shrink-0 text-[10px] font-semibold text-gray-500">4:30</span><span class="min-w-0"><span class="block truncate text-[11px] font-medium text-gray-800">Sirah</span><span class="block truncate text-[9px] text-gray-500">Tahun 6 Ali</span></span></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- floating toast: QR -->
            <div class="anim-up absolute hidden sm:block" style="--d:1000ms;left:-28px;top:42%">
                <div class="float-a flex w-64 items-center gap-3 rounded-xl border border-gray-200 bg-white/95 p-3 shadow-xl backdrop-blur">
                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-green-100 text-green-700"><svg class="h-5 w-5"><use href="#i-check"/></svg></span>
                    <div class="min-w-0">
                        <p class="truncate text-xs font-semibold text-gray-900">Ahmad Zayyad — Hadir 2:31 PM</p>
                        <p class="truncate text-[10px] text-gray-500">Imbasan QR · Tahun 4 Abu Bakar</p>
                    </div>
                </div>
            </div>
            <!-- floating toast: RPH -->
            <div class="anim-up absolute" style="--d:1150ms;right:-6px;bottom:-26px">
                <div class="float-b flex w-60 items-center gap-3 rounded-xl border border-gray-200 bg-white/95 p-3 shadow-xl backdrop-blur">
                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-blue-100 text-blue-700"><svg class="h-5 w-5"><use href="#i-doc-check"/></svg></span>
                    <div class="min-w-0">
                        <p class="truncate text-xs font-semibold text-gray-900">RPH Tahun 4 diluluskan</p>
                        <p class="truncate text-[10px] text-gray-500">oleh Guru Besar · baru sahaja</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ========================= 3. MASALAH → PENYELESAIAN ========================= -->
<section id="ciri" class="relative bg-gray-50 py-20 sm:py-24">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="reveal mx-auto max-w-2xl text-center">
            <p class="text-sm font-semibold uppercase tracking-wider text-blue-600">Kenapa eKafa</p>
            <h2 class="mt-3 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Kerja pentadbiran KAFA tak sepatutnya sebanyak ini</h2>
            <p class="mt-4 text-lg text-gray-600">Masa guru lebih baik digunakan untuk mengajar — bukan menyalin, mengira dan mencetak semula.</p>
        </div>

        <div class="mt-14 grid gap-6 md:grid-cols-3" data-stagger>
            <!-- 1 -->
            <article class="reveal lift flex flex-col overflow-hidden rounded-2xl border border-gray-200 bg-white">
                <div class="p-6">
                    <p class="inline-flex items-center gap-1.5 rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-semibold text-gray-600"><svg class="h-3.5 w-3.5" aria-hidden="true"><use href="#i-x"/></svg>Sebelum</p>
                    <h3 class="mt-3 text-lg font-semibold text-gray-900">Buku kedatangan kertas</h3>
                    <p class="mt-2 text-sm leading-relaxed text-gray-600">Kehadiran ditanda dalam buku, dikira manual hujung bulan — senang hilang, susah disemak.</p>
                </div>
                <div class="relative flex-1 border-t border-dashed border-gray-200 bg-gradient-to-b from-blue-50/70 to-white p-6">
                    <span class="absolute -top-4 left-6 flex h-8 w-8 items-center justify-center rounded-full bg-blue-600 text-white shadow-md ring-4 ring-white"><svg class="h-4 w-4" aria-hidden="true"><use href="#i-arrow-down"/></svg></span>
                    <p class="mt-1 inline-flex items-center gap-1.5 text-xs font-semibold text-blue-700"><svg class="h-3.5 w-3.5" aria-hidden="true"><use href="#i-check"/></svg>Dengan eKafa</p>
                    <p class="mt-2 text-sm leading-relaxed text-gray-700">Tanda kehadiran dengan satu klik atau imbasan QR. Peratus dikira automatik dan ibu bapa boleh lihat serta-merta.</p>
                </div>
            </article>
            <!-- 2 -->
            <article class="reveal lift flex flex-col overflow-hidden rounded-2xl border border-gray-200 bg-white">
                <div class="p-6">
                    <p class="inline-flex items-center gap-1.5 rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-semibold text-gray-600"><svg class="h-3.5 w-3.5" aria-hidden="true"><use href="#i-x"/></svg>Sebelum</p>
                    <h3 class="mt-3 text-lg font-semibold text-gray-900">RPH tulis tangan &amp; Jawi</h3>
                    <p class="mt-2 text-sm leading-relaxed text-gray-600">RPH ditulis tangan setiap minggu, susah menaip Jawi di komputer, dan perlu dihantar secara fizikal untuk disemak.</p>
                </div>
                <div class="relative flex-1 border-t border-dashed border-gray-200 bg-gradient-to-b from-blue-50/70 to-white p-6">
                    <span class="absolute -top-4 left-6 flex h-8 w-8 items-center justify-center rounded-full bg-blue-600 text-white shadow-md ring-4 ring-white"><svg class="h-4 w-4" aria-hidden="true"><use href="#i-arrow-down"/></svg></span>
                    <p class="mt-1 inline-flex items-center gap-1.5 text-xs font-semibold text-blue-700"><svg class="h-3.5 w-3.5" aria-hidden="true"><use href="#i-check"/></svg>Dengan eKafa</p>
                    <p class="mt-2 text-sm leading-relaxed text-gray-700">Isi RPH dalam templat yang menyokong tulisan Jawi, hantar untuk semakan Guru Besar dalam talian, dan cetak PDF bila perlu.</p>
                </div>
            </article>
            <!-- 3 -->
            <article class="reveal lift flex flex-col overflow-hidden rounded-2xl border border-gray-200 bg-white">
                <div class="p-6">
                    <p class="inline-flex items-center gap-1.5 rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-semibold text-gray-600"><svg class="h-3.5 w-3.5" aria-hidden="true"><use href="#i-x"/></svg>Sebelum</p>
                    <h3 class="mt-3 text-lg font-semibold text-gray-900">Laporan dan sijil manual</h3>
                    <p class="mt-2 text-sm leading-relaxed text-gray-600">Markah dikumpul dalam fail Excel berasingan, sijil aktiviti disediakan satu persatu.</p>
                </div>
                <div class="relative flex-1 border-t border-dashed border-gray-200 bg-gradient-to-b from-blue-50/70 to-white p-6">
                    <span class="absolute -top-4 left-6 flex h-8 w-8 items-center justify-center rounded-full bg-blue-600 text-white shadow-md ring-4 ring-white"><svg class="h-4 w-4" aria-hidden="true"><use href="#i-arrow-down"/></svg></span>
                    <p class="mt-1 inline-flex items-center gap-1.5 text-xs font-semibold text-blue-700"><svg class="h-3.5 w-3.5" aria-hidden="true"><use href="#i-check"/></svg>Dengan eKafa</p>
                    <p class="mt-2 text-sm leading-relaxed text-gray-700">Markah terus jadi gred dan laporan. Sijil digital dijana serentak, lengkap dengan kod QR pengesahan.</p>
                </div>
            </article>
        </div>
    </div>
</section>

<!-- ========================= 4. MODUL ========================= -->
<section id="modul" class="py-20 sm:py-24">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="reveal flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
            <div class="max-w-2xl">
                <p class="text-sm font-semibold uppercase tracking-wider text-blue-600">Ciri-ciri utama</p>
                <h2 class="mt-3 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Satu platform, semua urusan KAFA</h2>
                <p class="mt-4 text-lg text-gray-600">Mula dengan modul asas secara percuma. Buka modul lanjutan bila anda bersedia.</p>
            </div>
            <div class="flex flex-wrap items-center gap-2 text-xs">
                <span class="text-gray-500">Tersedia dari pakej:</span>
                <span class="rounded-full bg-emerald-50 px-2.5 py-0.5 font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-200">Percuma</span>
                <span class="rounded-full bg-indigo-50 px-2.5 py-0.5 font-semibold text-indigo-700 ring-1 ring-inset ring-indigo-200">Personal</span>
                <span class="rounded-full bg-blue-600 px-2.5 py-0.5 font-semibold text-white">Sekolah</span>
            </div>
        </div>

        <div class="mt-12 grid gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4" data-stagger>
            <!-- card template -->
            <article class="reveal lift relative rounded-2xl border border-gray-200 bg-white p-5">
                <span class="absolute right-4 top-4 rounded-full bg-emerald-50 px-2 py-0.5 text-[11px] font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-200">Percuma</span>
                <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-blue-600"><svg class="h-6 w-6" aria-hidden="true"><use href="#i-qr"/></svg></span>
                <h3 class="mt-4 font-semibold text-gray-900">Kehadiran Harian &amp; Kiosk QR</h3>
                <p class="mt-1.5 text-sm leading-relaxed text-gray-600">Tanda hadir dalam beberapa saat, atau biar murid imbas QR sendiri di kiosk.</p>
                <p class="mt-3 text-[11px] font-medium text-indigo-700">Kiosk QR: pakej Personal</p>
            </article>
            <article class="reveal lift relative rounded-2xl border border-gray-200 bg-white p-5">
                <span class="absolute right-4 top-4 rounded-full bg-indigo-50 px-2 py-0.5 text-[11px] font-semibold text-indigo-700 ring-1 ring-inset ring-indigo-200">Personal</span>
                <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-blue-600"><svg class="h-6 w-6" aria-hidden="true"><use href="#i-doc"/></svg></span>
                <h3 class="mt-4 font-semibold text-gray-900">Rekod RPH</h3>
                <p class="mt-1.5 text-sm leading-relaxed text-gray-600">Templat RPH yang sokong tulisan Jawi, siap dicetak sebagai PDF.</p>
            </article>
            <article class="reveal lift relative rounded-2xl border border-gray-200 bg-white p-5">
                <span class="absolute right-4 top-4 rounded-full bg-emerald-50 px-2 py-0.5 text-[11px] font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-200">Percuma</span>
                <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-blue-600"><svg class="h-6 w-6" aria-hidden="true"><use href="#i-clipboard"/></svg></span>
                <h3 class="mt-4 font-semibold text-gray-900">Peperiksaan &amp; Markah</h3>
                <p class="mt-1.5 text-sm leading-relaxed text-gray-600">Masukkan markah sekali, gred dan purata dikira automatik.</p>
            </article>
            <article class="reveal lift relative rounded-2xl border border-gray-200 bg-white p-5">
                <span class="absolute right-4 top-4 rounded-full bg-indigo-50 px-2 py-0.5 text-[11px] font-semibold text-indigo-700 ring-1 ring-inset ring-indigo-200">Personal</span>
                <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-blue-600"><svg class="h-6 w-6" aria-hidden="true"><use href="#i-trophy"/></svg></span>
                <h3 class="mt-4 font-semibold text-gray-900">Rekod Pencapaian Murid</h3>
                <p class="mt-1.5 text-sm leading-relaxed text-gray-600">Jejak hafazan, bacaan dan kemahiran setiap murid dari semasa ke semasa.</p>
            </article>
            <article class="reveal lift relative rounded-2xl border border-gray-200 bg-white p-5">
                <span class="absolute right-4 top-4 rounded-full bg-indigo-50 px-2 py-0.5 text-[11px] font-semibold text-indigo-700 ring-1 ring-inset ring-indigo-200">Personal</span>
                <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-blue-600"><svg class="h-6 w-6" aria-hidden="true"><use href="#i-flag"/></svg></span>
                <h3 class="mt-4 font-semibold text-gray-900">Disiplin Murid</h3>
                <p class="mt-1.5 text-sm leading-relaxed text-gray-600">Catat kes dan tindakan susulan dengan rekod yang kemas dan sulit.</p>
            </article>
            <article class="reveal lift relative rounded-2xl border border-gray-200 bg-white p-5">
                <span class="absolute right-4 top-4 rounded-full bg-indigo-50 px-2 py-0.5 text-[11px] font-semibold text-indigo-700 ring-1 ring-inset ring-indigo-200">Personal</span>
                <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-blue-600"><svg class="h-6 w-6" aria-hidden="true"><use href="#i-academic"/></svg></span>
                <h3 class="mt-4 font-semibold text-gray-900">Aktiviti &amp; Sijil Digital</h3>
                <p class="mt-1.5 text-sm leading-relaxed text-gray-600">Jana sijil penyertaan serentak, setiap satu dengan QR pengesahan.</p>
            </article>
            <article class="reveal lift relative rounded-2xl border border-gray-200 bg-white p-5">
                <span class="absolute right-4 top-4 rounded-full bg-emerald-50 px-2 py-0.5 text-[11px] font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-200">Percuma</span>
                <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-blue-600"><svg class="h-6 w-6" aria-hidden="true"><use href="#i-calendar"/></svg></span>
                <h3 class="mt-4 font-semibold text-gray-900">Jadual Waktu</h3>
                <p class="mt-1.5 text-sm leading-relaxed text-gray-600">Susun jadual kelas dan guru, terus kelihatan di dashboard setiap hari.</p>
            </article>
            <article class="reveal lift relative rounded-2xl border border-gray-200 bg-white p-5">
                <span class="absolute right-4 top-4 rounded-full bg-blue-600 px-2 py-0.5 text-[11px] font-semibold text-white">Sekolah</span>
                <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-blue-600"><svg class="h-6 w-6" aria-hidden="true"><use href="#i-chart"/></svg></span>
                <h3 class="mt-4 font-semibold text-gray-900">Laporan &amp; KPI Sekolah</h3>
                <p class="mt-1.5 text-sm leading-relaxed text-gray-600">Ringkasan prestasi sekolah, sedia untuk mesyuarat dan audit.</p>
                <p class="mt-3 text-[11px] font-medium text-indigo-700">Laporan Murid: pakej Personal</p>
            </article>
            <article class="reveal lift relative rounded-2xl border border-gray-200 bg-white p-5">
                <span class="absolute right-4 top-4 rounded-full bg-blue-600 px-2 py-0.5 text-[11px] font-semibold text-white">Sekolah</span>
                <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-blue-600"><svg class="h-6 w-6" aria-hidden="true"><use href="#i-banknotes"/></svg></span>
                <h3 class="mt-4 font-semibold text-gray-900">Kewangan Sekolah</h3>
                <p class="mt-1.5 text-sm leading-relaxed text-gray-600">Rekod yuran, kutipan dan perbelanjaan dengan lebih telus.</p>
            </article>
            <article class="reveal lift relative rounded-2xl border border-gray-200 bg-white p-5">
                <span class="absolute right-4 top-4 rounded-full bg-blue-600 px-2 py-0.5 text-[11px] font-semibold text-white">Sekolah</span>
                <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-blue-600"><svg class="h-6 w-6" aria-hidden="true"><use href="#i-phone"/></svg></span>
                <h3 class="mt-4 font-semibold text-gray-900">Portal Ibu Bapa</h3>
                <p class="mt-1.5 text-sm leading-relaxed text-gray-600">Ibu bapa semak kehadiran, keputusan dan sijil anak dari telefon.</p>
            </article>
            <article class="reveal lift relative rounded-2xl border border-gray-200 bg-white p-5">
                <span class="absolute right-4 top-4 rounded-full bg-blue-600 px-2 py-0.5 text-[11px] font-semibold text-white">Sekolah</span>
                <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-blue-600"><svg class="h-6 w-6" aria-hidden="true"><use href="#i-megaphone"/></svg></span>
                <h3 class="mt-4 font-semibold text-gray-900">Hebahan</h3>
                <p class="mt-1.5 text-sm leading-relaxed text-gray-600">Sampaikan notis dan makluman kepada guru serta ibu bapa sekaligus.</p>
            </article>
            <article class="reveal lift relative rounded-2xl border border-gray-200 bg-white p-5">
                <span class="absolute right-4 top-4 rounded-full bg-indigo-50 px-2 py-0.5 text-[11px] font-semibold text-indigo-700 ring-1 ring-inset ring-indigo-200">Personal</span>
                <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-blue-600"><svg class="h-6 w-6" aria-hidden="true"><use href="#i-sparkles"/></svg></span>
                <h3 class="mt-4 font-semibold text-gray-900">Pembantu AI</h3>
                <p class="mt-1.5 text-sm leading-relaxed text-gray-600">Bantuan pantas untuk merangka RPH, aktiviti dan soalan latihan.</p>
            </article>
        </div>
    </div>
</section>

<!-- ========================= 5. LAWATAN PRODUK ========================= -->
<section id="lawatan" class="relative overflow-hidden bg-gray-50 py-20 sm:py-24" x-data="tour()">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="reveal mx-auto max-w-2xl text-center">
            <p class="text-sm font-semibold uppercase tracking-wider text-blue-600">Lawatan produk</p>
            <h2 class="mt-3 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Lihat bagaimana eKafa berfungsi</h2>
            <p class="mt-4 text-lg text-gray-600">Gambaran skrin yang digunakan Guru Besar, guru dan ibu bapa setiap hari.</p>
        </div>

        <!-- Tabs -->
        <div class="reveal mt-10 flex justify-center">
            <div class="tab-scroll max-w-full overflow-x-auto">
                <div x-ref="list" role="tablist" aria-label="Lawatan produk" x-on:keydown="key($event)"
                     class="relative inline-flex gap-1 whitespace-nowrap rounded-xl bg-white p-1.5 shadow-sm ring-1 ring-gray-200">
                    <span class="absolute rounded-lg bg-blue-600 shadow-md shadow-blue-600/25 transition-all duration-300 ease-out" aria-hidden="true"
                          :style="'left:' + ind.left + 'px;width:' + ind.width + 'px;top:6px;bottom:6px'"></span>
                    <template x-for="(t, i) in tabs" :key="i">
                        <button type="button" role="tab" :id="'tab-' + i" :aria-controls="'panel-' + i" :aria-selected="(active === i).toString()" :tabindex="active === i ? 0 : -1"
                                x-on:click="select(i)" class="relative z-10 rounded-lg px-4 py-2 text-sm font-semibold transition-colors duration-300"
                                :class="active === i ? 'text-white' : 'text-gray-600 hover:text-gray-900'" x-text="t"></button>
                    </template>
                </div>
            </div>
        </div>

        <!-- Panels -->
        <div class="reveal stack mt-10 grid">

            <!-- (a) Dashboard Guru Besar -->
            <div x-show="active === 0" role="tabpanel" id="panel-0" aria-labelledby="tab-0"
                 x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                 class="grid items-center gap-10 lg:grid-cols-5">
                <div class="lg:col-span-2">
                    <h3 class="text-2xl font-bold tracking-tight text-gray-900">Seluruh sekolah dalam satu pandangan</h3>
                    <p class="mt-3 text-gray-600">Guru Besar nampak keadaan setiap kelas tanpa perlu kumpul laporan dari guru satu persatu.</p>
                    <ul class="mt-6 space-y-3">
                        <li class="flex gap-3 text-sm text-gray-700"><svg class="mt-0.5 h-5 w-5 shrink-0 text-teal-600" aria-hidden="true"><use href="#i-check"/></svg>Kehadiran setiap kelas dikemas kini secara langsung</li>
                        <li class="flex gap-3 text-sm text-gray-700"><svg class="mt-0.5 h-5 w-5 shrink-0 text-teal-600" aria-hidden="true"><use href="#i-check"/></svg>Senarai RPH yang menunggu semakan, terus boleh diluluskan</li>
                        <li class="flex gap-3 text-sm text-gray-700"><svg class="mt-0.5 h-5 w-5 shrink-0 text-teal-600" aria-hidden="true"><use href="#i-check"/></svg>KPI sekolah sedia untuk mesyuarat — tiada lagi kerja Excel</li>
                    </ul>
                </div>
                <div class="lg:col-span-3" aria-hidden="true">
                    <div class="rounded-2xl border border-gray-200 bg-white p-4 shadow-xl shadow-gray-900/5 sm:p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-[11px] text-gray-500">KAFA Al-Hidayah · Sesi 2026</p>
                                <p class="text-sm font-bold text-gray-900">Dashboard Guru Besar</p>
                            </div>
                            <span class="rounded-lg border border-gray-200 px-2.5 py-1 text-[11px] font-medium text-gray-600">Oktober 2026</span>
                        </div>
                        <div class="mt-4 grid grid-cols-2 gap-2.5 sm:grid-cols-4">
                            <div class="rounded-xl bg-blue-50 p-3"><p class="text-[10px] font-medium text-blue-700">Kehadiran Purata</p><p class="mt-1 text-lg font-bold text-blue-700">94%</p></div>
                            <div class="rounded-xl bg-gray-50 p-3"><p class="text-[10px] font-medium text-gray-500">Murid</p><p class="mt-1 text-lg font-bold text-gray-900">120</p></div>
                            <div class="rounded-xl bg-gray-50 p-3"><p class="text-[10px] font-medium text-gray-500">Guru Aktif</p><p class="mt-1 text-lg font-bold text-gray-900">8</p></div>
                            <div class="rounded-xl bg-gray-50 p-3"><p class="text-[10px] font-medium text-gray-500">RPH Minggu Ini</p><p class="mt-1 text-lg font-bold text-gray-900">22<span class="text-xs font-medium text-gray-500">/24</span></p></div>
                        </div>
                        <div class="mt-3 grid gap-3 sm:grid-cols-2">
                            <div class="rounded-xl border border-gray-100 p-3">
                                <p class="text-[11px] font-semibold text-gray-800">Trend Kehadiran 2026</p>
                                <svg viewBox="0 0 240 90" class="mt-2 w-full" style="height:96px">
                                    <defs><linearGradient id="gArea" x1="0" x2="0" y1="0" y2="1"><stop offset="0" stop-color="#2563EB" stop-opacity=".22"/><stop offset="1" stop-color="#2563EB" stop-opacity="0"/></linearGradient></defs>
                                    <g stroke="#E5E7EB" stroke-width="1"><line x1="0" y1="20" x2="240" y2="20"/><line x1="0" y1="50" x2="240" y2="50"/><line x1="0" y1="80" x2="240" y2="80"/></g>
                                    <path d="M0 52 L26 46 L52 49 L78 38 L104 41 L130 33 L156 36 L182 28 L208 30 L240 22 L240 90 L0 90Z" fill="url(#gArea)"/>
                                    <path d="M0 52 L26 46 L52 49 L78 38 L104 41 L130 33 L156 36 L182 28 L208 30 L240 22" fill="none" stroke="#2563EB" stroke-width="2.5" stroke-linejoin="round" stroke-linecap="round"/>
                                    <circle cx="240" cy="22" r="4" fill="#2563EB" stroke="#fff" stroke-width="2"/>
                                </svg>
                            </div>
                            <div class="rounded-xl border border-gray-100 p-3">
                                <p class="text-[11px] font-semibold text-gray-800">Kehadiran Ikut Kelas (Hari Ini)</p>
                                <ul class="mt-2 space-y-1.5">
                                    <li class="flex items-center gap-2 text-[10px]"><span class="w-24 truncate text-gray-600">Tahun 1 Hasan</span><span class="h-1.5 flex-1 rounded-full bg-gray-100"><span class="block h-1.5 rounded-full bg-blue-600" style="width:97%"></span></span><span class="w-7 text-right font-semibold text-gray-800">97%</span></li>
                                    <li class="flex items-center gap-2 text-[10px]"><span class="w-24 truncate text-gray-600">Tahun 2 Husin</span><span class="h-1.5 flex-1 rounded-full bg-gray-100"><span class="block h-1.5 rounded-full bg-blue-600" style="width:95%"></span></span><span class="w-7 text-right font-semibold text-gray-800">95%</span></li>
                                    <li class="flex items-center gap-2 text-[10px]"><span class="w-24 truncate text-gray-600">Tahun 3 Uthman</span><span class="h-1.5 flex-1 rounded-full bg-gray-100"><span class="block h-1.5 rounded-full bg-blue-600" style="width:93%"></span></span><span class="w-7 text-right font-semibold text-gray-800">93%</span></li>
                                    <li class="flex items-center gap-2 text-[10px]"><span class="w-24 truncate text-gray-600">Tahun 4 Abu Bakar</span><span class="h-1.5 flex-1 rounded-full bg-gray-100"><span class="block h-1.5 rounded-full bg-blue-600" style="width:96%"></span></span><span class="w-7 text-right font-semibold text-gray-800">96%</span></li>
                                    <li class="flex items-center gap-2 text-[10px]"><span class="w-24 truncate text-gray-600">Tahun 5 Umar</span><span class="h-1.5 flex-1 rounded-full bg-gray-100"><span class="block h-1.5 rounded-full bg-amber-500" style="width:88%"></span></span><span class="w-7 text-right font-semibold text-gray-800">88%</span></li>
                                    <li class="flex items-center gap-2 text-[10px]"><span class="w-24 truncate text-gray-600">Tahun 6 Ali</span><span class="h-1.5 flex-1 rounded-full bg-gray-100"><span class="block h-1.5 rounded-full bg-blue-600" style="width:92%"></span></span><span class="w-7 text-right font-semibold text-gray-800">92%</span></li>
                                </ul>
                            </div>
                        </div>
                        <div class="mt-3 rounded-xl border border-gray-100 p-3">
                            <p class="text-[11px] font-semibold text-gray-800">RPH Menunggu Semakan</p>
                            <ul class="mt-2 divide-y divide-gray-100">
                                <li class="flex items-center justify-between gap-2 py-1.5"><span class="min-w-0 truncate text-[11px] text-gray-700">Ustaz Hafiz · Al-Quran · Tahun 6 Ali</span><span class="shrink-0 rounded-md bg-blue-600 px-2 py-0.5 text-[10px] font-semibold text-white">Semak</span></li>
                                <li class="flex items-center justify-between gap-2 py-1.5"><span class="min-w-0 truncate text-[11px] text-gray-700">Ustazah Salmah · Akidah · Tahun 2 Husin</span><span class="shrink-0 rounded-md bg-blue-600 px-2 py-0.5 text-[10px] font-semibold text-white">Semak</span></li>
                                <li class="flex items-center justify-between gap-2 py-1.5"><span class="min-w-0 truncate text-[11px] text-gray-700">Ustazah Nadia · Adab · Tahun 1 Hasan</span><span class="shrink-0 rounded-md bg-blue-600 px-2 py-0.5 text-[10px] font-semibold text-white">Semak</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- (b) Kehadiran QR -->
            <div x-show="active === 1" x-cloak role="tabpanel" id="panel-1" aria-labelledby="tab-1"
                 x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                 class="grid items-center gap-10 lg:grid-cols-5">
                <div class="lg:col-span-2">
                    <h3 class="text-2xl font-bold tracking-tight text-gray-900">Kehadiran siap sebelum loceng berbunyi</h3>
                    <p class="mt-3 text-gray-600">Murid imbas kad QR masing-masing di kiosk atau telefon guru — nama terus bertukar hijau.</p>
                    <ul class="mt-6 space-y-3">
                        <li class="flex gap-3 text-sm text-gray-700"><svg class="mt-0.5 h-5 w-5 shrink-0 text-teal-600" aria-hidden="true"><use href="#i-check"/></svg>Masa tiba direkod automatik untuk setiap murid</li>
                        <li class="flex gap-3 text-sm text-gray-700"><svg class="mt-0.5 h-5 w-5 shrink-0 text-teal-600" aria-hidden="true"><use href="#i-check"/></svg>Guna telefon atau tablet sedia ada sebagai kiosk</li>
                        <li class="flex gap-3 text-sm text-gray-700"><svg class="mt-0.5 h-5 w-5 shrink-0 text-teal-600" aria-hidden="true"><use href="#i-check"/></svg>Senarai tidak hadir terus kelihatan untuk tindakan susulan</li>
                    </ul>
                </div>
                <div class="flex flex-col items-center gap-6 sm:flex-row sm:justify-center lg:col-span-3" aria-hidden="true" x-data="qrDemo()">
                    <!-- phone -->
                    <div class="w-64 shrink-0 rounded-[2.2rem] border-[10px] border-gray-900 bg-gray-900 shadow-2xl">
                        <div class="overflow-hidden rounded-[1.6rem] bg-white">
                            <div class="flex items-center justify-between bg-gray-900 px-4 pb-2 pt-1 text-[9px] text-gray-300"><span>2:31</span><span class="h-1.5 w-12 rounded-full bg-gray-700"></span><span>100%</span></div>
                            <div class="px-4 pt-3">
                                <p class="text-[10px] text-gray-500">Kiosk Kehadiran</p>
                                <p class="text-xs font-bold text-gray-900">Tahun 4 Abu Bakar</p>
                            </div>
                            <div class="relative mx-4 mt-3 overflow-hidden rounded-xl bg-gray-900" style="height:150px">
                                <div class="pattern-star-light absolute inset-0" style="opacity:.08"></div>
                                <!-- frame corners -->
                                <span class="absolute left-6 top-5 h-6 w-6 rounded-tl-lg border-l-[3px] border-t-[3px] border-teal-400"></span>
                                <span class="absolute right-6 top-5 h-6 w-6 rounded-tr-lg border-r-[3px] border-t-[3px] border-teal-400"></span>
                                <span class="absolute bottom-5 left-6 h-6 w-6 rounded-bl-lg border-b-[3px] border-l-[3px] border-teal-400"></span>
                                <span class="absolute bottom-5 right-6 h-6 w-6 rounded-br-lg border-b-[3px] border-r-[3px] border-teal-400"></span>
                                <svg class="absolute left-1/2 top-1/2 h-14 w-14 -translate-x-1/2 -translate-y-1/2 text-white/80"><use href="#i-qr"/></svg>
                                <span class="scan-line absolute left-6 right-6 h-0.5 rounded-full bg-teal-400" style="box-shadow:0 0 12px 2px rgba(45,212,191,.7)"></span>
                            </div>
                            <p class="mt-2 text-center text-[10px] text-gray-500">Halakan kad QR murid ke kamera</p>
                            <ul class="mt-2 space-y-1 px-3 pb-4">
                                <template x-for="(nm, i) in names" :key="nm">
                                    <li class="flex items-center justify-between rounded-lg px-2 py-1.5 transition-colors duration-500" :class="i < n ? 'bg-green-50' : 'bg-gray-50'">
                                        <span class="flex items-center gap-2">
                                            <span class="flex h-4 w-4 items-center justify-center rounded-full transition-colors duration-500" :class="i < n ? 'bg-green-500 text-white' : 'bg-gray-200 text-transparent'"><svg class="h-2.5 w-2.5"><use href="#i-check"/></svg></span>
                                            <span class="text-[10px] font-medium text-gray-800" x-text="nm"></span>
                                        </span>
                                        <span class="text-[9px] font-semibold transition-colors duration-500" :class="i < n ? 'text-green-700' : 'text-gray-500'" x-text="i < n ? 'Hadir ' + times[i] : 'Menunggu'"></span>
                                    </li>
                                </template>
                            </ul>
                        </div>
                    </div>
                    <!-- summary card -->
                    <div class="w-full max-w-xs rounded-2xl border border-gray-200 bg-white p-5 shadow-xl shadow-gray-900/5">
                        <p class="text-[11px] text-gray-500">Ringkasan langsung</p>
                        <p class="text-sm font-bold text-gray-900">Tahun 4 Abu Bakar</p>
                        <div class="mt-4 flex items-end gap-1">
                            <span class="text-4xl font-extrabold tracking-tight text-gray-900" x-text="22 + n"></span>
                            <span class="mb-1 text-sm text-gray-500">/ 30 hadir</span>
                        </div>
                        <div class="mt-3 h-2 rounded-full bg-gray-100"><div class="h-2 rounded-full bg-green-500 transition-all duration-500" :style="'width:' + Math.round((22 + n) / 30 * 100) + '%'"></div></div>
                        <div class="mt-4 grid grid-cols-3 gap-2 text-center">
                            <div class="rounded-lg bg-green-50 py-2"><p class="text-sm font-bold text-green-700" x-text="22 + n"></p><p class="text-[9px] text-gray-600">Hadir</p></div>
                            <div class="rounded-lg bg-amber-50 py-2"><p class="text-sm font-bold text-amber-700">1</p><p class="text-[9px] text-gray-600">Lewat</p></div>
                            <div class="rounded-lg bg-gray-50 py-2"><p class="text-sm font-bold text-gray-700" x-text="8 - n"></p><p class="text-[9px] text-gray-600">Belum</p></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- (c) RPH Jawi -->
            <div x-show="active === 2" x-cloak role="tabpanel" id="panel-2" aria-labelledby="tab-2"
                 x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                 class="grid items-center gap-10 lg:grid-cols-5">
                <div class="lg:col-span-2">
                    <h3 class="text-2xl font-bold tracking-tight text-gray-900">RPH dalam Jawi, tanpa pening menaip</h3>
                    <p class="mt-3 text-gray-600">Isi RPH sekali, hantar untuk semakan dan cetak PDF yang kemas — tulisan Jawi kekal cantik.</p>
                    <ul class="mt-6 space-y-3">
                        <li class="flex gap-3 text-sm text-gray-700"><svg class="mt-0.5 h-5 w-5 shrink-0 text-teal-600" aria-hidden="true"><use href="#i-check"/></svg>Sokongan penuh tulisan Jawi, kanan ke kiri</li>
                        <li class="flex gap-3 text-sm text-gray-700"><svg class="mt-0.5 h-5 w-5 shrink-0 text-teal-600" aria-hidden="true"><use href="#i-check"/></svg>Aliran semakan: Draf → Dihantar → Diluluskan</li>
                        <li class="flex gap-3 text-sm text-gray-700"><svg class="mt-0.5 h-5 w-5 shrink-0 text-teal-600" aria-hidden="true"><use href="#i-check"/></svg>Cetak PDF siap untuk fail meja guru</li>
                    </ul>
                </div>
                <div class="lg:col-span-3" aria-hidden="true">
                    <div class="relative mx-auto max-w-xl rounded-2xl border border-gray-200 bg-white p-5 shadow-xl shadow-gray-900/5 sm:p-7">
                        <div class="flex items-start justify-between gap-4 border-b border-gray-100 pb-4">
                            <div>
                                <p class="text-[11px] font-semibold uppercase tracking-wider text-blue-700">Rancangan Pengajaran Harian</p>
                                <p class="mt-1 text-sm font-bold text-gray-900">Jawi dan Khat · Minggu 41</p>
                            </div>
                            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-blue-50 text-blue-600"><svg class="h-5 w-5"><use href="#i-doc"/></svg></span>
                        </div>
                        <dl class="mt-4 grid grid-cols-2 gap-x-4 gap-y-2 text-[11px] sm:grid-cols-4">
                            <div><dt class="text-gray-500">Kelas</dt><dd class="font-semibold text-gray-800">Tahun 4 Abu Bakar</dd></div>
                            <div><dt class="text-gray-500">Tarikh</dt><dd class="font-semibold text-gray-800">15/10/2026</dd></div>
                            <div><dt class="text-gray-500">Masa</dt><dd class="font-semibold text-gray-800">2:30 – 3:10</dd></div>
                            <div><dt class="text-gray-500">Guru</dt><dd class="font-semibold text-gray-800">Ustazah Aminah</dd></div>
                        </dl>
                        <div class="jawi mt-5 space-y-1 rounded-xl bg-gray-50 p-4 text-gray-800" dir="rtl" lang="ms-Arab">
                            <p class="text-xl font-bold text-blue-700">اوبجيکتيف ڤمبلاجرن</p>
                            <p class="text-lg">موريد داڤت مڽبوت دان منوليس حروف جاوي برسمبوڠ دڠن بتول.</p>
                            <p class="pt-2 text-xl font-bold text-blue-700">اکتيۏيتي</p>
                            <p class="text-lg">ڬورو منونجوقکن چارا منوليس د ڤاڤن ڤوتيه، موريد ممبوات لاتيهن دالم بوکو.</p>
                            <p class="pt-2 text-xl font-bold text-blue-700">ريفليکسي</p>
                            <p class="text-lg">٢٨ درڤد ٣٠ موريد منچاڤاي اوبجيکتيف ڤمبلاجرن.</p>
                        </div>
                        <div class="mt-4 flex flex-wrap items-center gap-2 text-[10px] font-semibold">
                            <span class="rounded-full bg-gray-100 px-2 py-0.5 text-gray-600">Draf</span>
                            <svg class="h-3 w-3 text-gray-400"><use href="#i-arrow-right"/></svg>
                            <span class="rounded-full bg-gray-100 px-2 py-0.5 text-gray-600">Dihantar</span>
                            <svg class="h-3 w-3 text-gray-400"><use href="#i-arrow-right"/></svg>
                            <span class="rounded-full bg-green-100 px-2 py-0.5 text-green-700">Diluluskan</span>
                        </div>
                        <!-- stamp -->
                        <div class="stamp absolute right-5 rounded-lg border-[3px] border-green-600 px-3 py-1.5 text-center text-green-700" style="bottom:56px;background:rgba(255,255,255,.85)">
                                <p class="text-sm font-extrabold tracking-[0.2em]">DILULUSKAN</p>
                                <p class="text-[9px] font-semibold">Guru Besar · 16/10/2026</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- (d) Markah Peperiksaan -->
            <div x-show="active === 3" x-cloak role="tabpanel" id="panel-3" aria-labelledby="tab-3"
                 x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                 class="grid items-center gap-10 lg:grid-cols-5">
                <div class="lg:col-span-2">
                    <h3 class="text-2xl font-bold tracking-tight text-gray-900">Markah masuk, gred keluar sendiri</h3>
                    <p class="mt-3 text-gray-600">Masukkan markah setiap subjek — purata, gred dan kedudukan dikira untuk anda.</p>
                    <ul class="mt-6 space-y-3">
                        <li class="flex gap-3 text-sm text-gray-700"><svg class="mt-0.5 h-5 w-5 shrink-0 text-teal-600" aria-hidden="true"><use href="#i-check"/></svg>Gred automatik mengikut skala sekolah</li>
                        <li class="flex gap-3 text-sm text-gray-700"><svg class="mt-0.5 h-5 w-5 shrink-0 text-teal-600" aria-hidden="true"><use href="#i-check"/></svg>Analisis gred kelas dalam satu pandangan</li>
                        <li class="flex gap-3 text-sm text-gray-700"><svg class="mt-0.5 h-5 w-5 shrink-0 text-teal-600" aria-hidden="true"><use href="#i-check"/></svg>Keputusan terus sampai ke Portal Ibu Bapa</li>
                    </ul>
                </div>
                <div class="min-w-0 lg:col-span-3" aria-hidden="true">
                    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-xl shadow-gray-900/5">
                        <div class="flex flex-wrap items-center justify-between gap-2 border-b border-gray-100 px-5 py-4">
                            <div>
                                <p class="text-[11px] text-gray-500">Peperiksaan Pertengahan Tahun 2026</p>
                                <p class="text-sm font-bold text-gray-900">Tahun 4 Abu Bakar</p>
                            </div>
                            <div class="flex gap-1.5 text-[10px] font-semibold">
                                <span class="rounded-full bg-green-100 px-2 py-0.5 text-green-700">A · 3</span>
                                <span class="rounded-full bg-blue-100 px-2 py-0.5 text-blue-700">B · 2</span>
                                <span class="rounded-full bg-amber-100 px-2 py-0.5 text-amber-700">C · 1</span>
                            </div>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-[11px]">
                                <thead class="bg-gray-50 text-[10px] uppercase text-gray-500">
                                    <tr><th class="px-4 py-2.5 font-semibold">No</th><th class="px-3 py-2.5 font-semibold">Nama Murid</th><th class="px-3 py-2.5 font-semibold">Al-Quran</th><th class="px-3 py-2.5 font-semibold">Ibadat</th><th class="px-3 py-2.5 font-semibold">Akidah</th><th class="px-3 py-2.5 font-semibold">Jawi</th><th class="px-3 py-2.5 font-semibold">Purata</th><th class="px-3 py-2.5 font-semibold">Gred</th></tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 text-gray-700">
                                    <tr><td class="px-4 py-2.5">1</td><td class="whitespace-nowrap px-3 py-2.5 font-medium text-gray-900">Ahmad Zayyad</td><td class="px-3">92</td><td class="px-3">88</td><td class="px-3">90</td><td class="px-3">85</td><td class="px-3 font-semibold">88.8</td><td class="px-3"><span class="rounded-full bg-green-100 px-2 py-0.5 text-[10px] font-semibold text-green-700">A</span></td></tr>
                                    <tr><td class="px-4 py-2.5">2</td><td class="whitespace-nowrap px-3 py-2.5 font-medium text-gray-900">Nur Imanina</td><td class="px-3">95</td><td class="px-3">91</td><td class="px-3">87</td><td class="px-3">90</td><td class="px-3 font-semibold">90.8</td><td class="px-3"><span class="rounded-full bg-green-100 px-2 py-0.5 text-[10px] font-semibold text-green-700">A</span></td></tr>
                                    <tr><td class="px-4 py-2.5">3</td><td class="whitespace-nowrap px-3 py-2.5 font-medium text-gray-900">Muhammad Ammar</td><td class="px-3">78</td><td class="px-3">74</td><td class="px-3">80</td><td class="px-3">69</td><td class="px-3 font-semibold">75.3</td><td class="px-3"><span class="rounded-full bg-blue-100 px-2 py-0.5 text-[10px] font-semibold text-blue-700">B</span></td></tr>
                                    <tr><td class="px-4 py-2.5">4</td><td class="whitespace-nowrap px-3 py-2.5 font-medium text-gray-900">Aisyah Humaira</td><td class="px-3">86</td><td class="px-3">90</td><td class="px-3">84</td><td class="px-3">88</td><td class="px-3 font-semibold">87.0</td><td class="px-3"><span class="rounded-full bg-green-100 px-2 py-0.5 text-[10px] font-semibold text-green-700">A</span></td></tr>
                                    <tr><td class="px-4 py-2.5">5</td><td class="whitespace-nowrap px-3 py-2.5 font-medium text-gray-900">Muhammad Haziq</td><td class="px-3">70</td><td class="px-3">76</td><td class="px-3">72</td><td class="px-3">68</td><td class="px-3 font-semibold">71.5</td><td class="px-3"><span class="rounded-full bg-blue-100 px-2 py-0.5 text-[10px] font-semibold text-blue-700">B</span></td></tr>
                                    <tr><td class="px-4 py-2.5">6</td><td class="whitespace-nowrap px-3 py-2.5 font-medium text-gray-900">Nur Aleesya</td><td class="px-3">62</td><td class="px-3">58</td><td class="px-3">65</td><td class="px-3">60</td><td class="px-3 font-semibold">61.3</td><td class="px-3"><span class="rounded-full bg-amber-100 px-2 py-0.5 text-[10px] font-semibold text-amber-700">C</span></td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- (e) Portal Ibu Bapa -->
            <div x-show="active === 4" x-cloak role="tabpanel" id="panel-4" aria-labelledby="tab-4"
                 x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                 class="grid items-center gap-10 lg:grid-cols-5">
                <div class="lg:col-span-2">
                    <h3 class="text-2xl font-bold tracking-tight text-gray-900">Ibu bapa lebih dekat dengan pembelajaran anak</h3>
                    <p class="mt-3 text-gray-600">Log masuk dengan No. Kad Pengenalan dan lihat perkembangan anak tanpa perlu bertanya guru setiap kali.</p>
                    <ul class="mt-6 space-y-3">
                        <li class="flex gap-3 text-sm text-gray-700"><svg class="mt-0.5 h-5 w-5 shrink-0 text-teal-600" aria-hidden="true"><use href="#i-check"/></svg>Peratus kehadiran anak, dikemas kini setiap hari</li>
                        <li class="flex gap-3 text-sm text-gray-700"><svg class="mt-0.5 h-5 w-5 shrink-0 text-teal-600" aria-hidden="true"><use href="#i-check"/></svg>Keputusan peperiksaan terkini mengikut subjek</li>
                        <li class="flex gap-3 text-sm text-gray-700"><svg class="mt-0.5 h-5 w-5 shrink-0 text-teal-600" aria-hidden="true"><use href="#i-check"/></svg>Muat turun sijil digital bila-bila masa</li>
                    </ul>
                </div>
                <div class="flex justify-center lg:col-span-3" aria-hidden="true">
                    <div class="w-72 rounded-[2.2rem] border-[10px] border-gray-900 bg-gray-900 shadow-2xl">
                        <div class="overflow-hidden rounded-[1.6rem] bg-gray-50">
                            <div class="flex items-center justify-between bg-blue-600 px-4 pb-2 pt-1 text-[9px] text-blue-100"><span>8:15</span><span class="h-1.5 w-12 rounded-full bg-blue-500"></span><span>87%</span></div>
                            <div class="bg-blue-600 px-4 pb-5 pt-2 text-white">
                                <p class="text-[10px] text-blue-100">Portal Ibu Bapa</p>
                                <p class="text-sm font-bold">Nur Imanina</p>
                                <p class="text-[10px] text-blue-100">Tahun 4 Abu Bakar · KAFA Al-Hidayah</p>
                            </div>
                            <div class="-mt-3 space-y-2.5 px-3 pb-4">
                                <div class="flex items-center gap-3 rounded-xl bg-white p-3 shadow-sm">
                                    <svg viewBox="0 0 80 80" class="h-16 w-16 shrink-0 -rotate-90">
                                        <circle cx="40" cy="40" r="34" fill="none" stroke="#E5E7EB" stroke-width="8"/>
                                        <circle class="ring-draw" cx="40" cy="40" r="34" fill="none" stroke="#10B981" stroke-width="8" stroke-linecap="round" stroke-dasharray="213.6" stroke-dashoffset="17.1"/>
                                    </svg>
                                    <div>
                                        <p class="text-[10px] text-gray-500">Kehadiran sesi ini</p>
                                        <p class="text-xl font-extrabold text-gray-900">92%</p>
                                        <p class="text-[10px] text-gray-500">46 / 50 hari</p>
                                    </div>
                                </div>
                                <div class="rounded-xl bg-white p-3 shadow-sm">
                                    <div class="flex items-center justify-between">
                                        <p class="text-[10px] font-semibold text-gray-800">Keputusan Terkini</p>
                                        <span class="rounded-full bg-green-100 px-2 py-0.5 text-[9px] font-bold text-green-700">Gred A</span>
                                    </div>
                                    <p class="text-[9px] text-gray-500">Pertengahan Tahun 2026 · Purata 90.8</p>
                                    <div class="mt-2 grid grid-cols-4 gap-1.5 text-center">
                                        <div class="rounded-md bg-gray-50 py-1"><p class="text-[11px] font-bold text-gray-900">95</p><p class="text-[8px] text-gray-500">Quran</p></div>
                                        <div class="rounded-md bg-gray-50 py-1"><p class="text-[11px] font-bold text-gray-900">91</p><p class="text-[8px] text-gray-500">Ibadat</p></div>
                                        <div class="rounded-md bg-gray-50 py-1"><p class="text-[11px] font-bold text-gray-900">87</p><p class="text-[8px] text-gray-500">Akidah</p></div>
                                        <div class="rounded-md bg-gray-50 py-1"><p class="text-[11px] font-bold text-gray-900">90</p><p class="text-[8px] text-gray-500">Jawi</p></div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3 rounded-xl bg-white p-3 shadow-sm">
                                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-amber-50 text-amber-600"><svg class="h-5 w-5"><use href="#i-academic"/></svg></span>
                                    <div class="min-w-0 flex-1">
                                        <p class="truncate text-[10px] font-semibold text-gray-800">Sijil Majlis Khatam Al-Quran</p>
                                        <p class="text-[9px] text-gray-500">Disahkan dengan kod QR</p>
                                    </div>
                                    <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-blue-600 text-white"><svg class="h-4 w-4"><use href="#i-download"/></svg></span>
                                </div>
                                <div class="flex items-start gap-2 rounded-xl bg-white p-3 shadow-sm">
                                    <svg class="mt-0.5 h-4 w-4 shrink-0 text-blue-600"><use href="#i-megaphone"/></svg>
                                    <p class="text-[10px] leading-snug text-gray-700"><span class="font-semibold">Hebahan:</span> Kelas Khamis ini bermula jam 3:00 petang kerana mesyuarat guru.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ========================= 6. BAGAIMANA IA BERFUNGSI ========================= -->
<section class="py-20 sm:py-24">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="reveal mx-auto max-w-2xl text-center">
            <p class="text-sm font-semibold uppercase tracking-wider text-blue-600">Mula dalam beberapa minit</p>
            <h2 class="mt-3 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Bagaimana ia berfungsi</h2>
            <p class="mt-4 text-lg text-gray-600">Tiada pemasangan, tiada latihan panjang. Hanya tiga langkah.</p>
        </div>

        <div class="relative mt-16">
            <div class="absolute left-0 right-0 hidden md:block" style="top:28px;padding:0 16.66%" aria-hidden="true">
                <div class="h-0.5 w-full rounded-full" style="background:linear-gradient(90deg,#BFDBFE,#2563EB,#5EEAD4)"></div>
            </div>
            <ol class="relative grid gap-12 md:grid-cols-3 md:gap-8" data-stagger>
                <li class="reveal text-center">
                    <span class="relative mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-blue-600 text-xl font-bold text-white shadow-lg shadow-blue-600/30 ring-8 ring-white">1</span>
                    <h3 class="mt-6 text-lg font-semibold text-gray-900">Daftar akaun</h3>
                    <p class="mx-auto mt-2 max-w-xs text-sm leading-relaxed text-gray-600">Isi nama, e-mel dan nama sekolah. Siap dalam 2 minit — terus dapat pakej Percuma.</p>
                </li>
                <li class="reveal text-center">
                    <span class="relative mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-blue-600 text-xl font-bold text-white shadow-lg shadow-blue-600/30 ring-8 ring-white">2</span>
                    <h3 class="mt-6 text-lg font-semibold text-gray-900">Tambah kelas &amp; murid</h3>
                    <p class="mx-auto mt-2 max-w-xs text-sm leading-relaxed text-gray-600">Masukkan murid satu persatu, atau import terus dari fail Excel <span class="whitespace-nowrap">(pakej Personal ke atas)</span>.</p>
                </li>
                <li class="reveal text-center">
                    <span class="relative mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-teal-600 text-xl font-bold text-white shadow-lg shadow-teal-600/30 ring-8 ring-white">3</span>
                    <h3 class="mt-6 text-lg font-semibold text-gray-900">Jemput guru &amp; mula rekod</h3>
                    <p class="mx-auto mt-2 max-w-xs text-sm leading-relaxed text-gray-600">Hantar pautan jemputan kepada guru dan mula rekod kehadiran, RPH serta markah hari ini juga.</p>
                </li>
            </ol>
        </div>
    </div>
</section>

<!-- ========================= 7. UNTUK SIAPA ========================= -->
<section class="bg-gray-50 py-20 sm:py-24">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="reveal mx-auto max-w-2xl text-center">
            <p class="text-sm font-semibold uppercase tracking-wider text-blue-600">Untuk siapa</p>
            <h2 class="mt-3 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Direka untuk semua yang terlibat dengan KAFA</h2>
        </div>

        <div class="mt-14 grid gap-6 lg:grid-cols-3" data-stagger>
            <article class="reveal lift flex flex-col rounded-2xl border border-gray-200 bg-white p-7">
                <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-600 text-white shadow-md shadow-blue-600/25"><svg class="h-6 w-6" aria-hidden="true"><use href="#i-school"/></svg></span>
                <h3 class="mt-5 text-xl font-bold text-gray-900">Guru Besar</h3>
                <p class="mt-1 text-sm text-gray-600">Pandangan menyeluruh untuk seluruh sekolah.</p>
                <ul class="mt-6 flex-1 space-y-3 text-sm text-gray-700">
                    <li class="flex gap-3"><svg class="mt-0.5 h-5 w-5 shrink-0 text-blue-600" aria-hidden="true"><use href="#i-check"/></svg>Pantau kehadiran semua kelas secara langsung</li>
                    <li class="flex gap-3"><svg class="mt-0.5 h-5 w-5 shrink-0 text-blue-600" aria-hidden="true"><use href="#i-check"/></svg>Semak dan luluskan RPH guru dalam talian</li>
                    <li class="flex gap-3"><svg class="mt-0.5 h-5 w-5 shrink-0 text-blue-600" aria-hidden="true"><use href="#i-check"/></svg>Laporan &amp; KPI sekolah sedia dicetak</li>
                    <li class="flex gap-3"><svg class="mt-0.5 h-5 w-5 shrink-0 text-blue-600" aria-hidden="true"><use href="#i-check"/></svg>Jemput guru, urus kewangan dan hebahan</li>
                </ul>
                <a href="{{ route('register') }}" class="mt-7 inline-flex items-center gap-1.5 text-sm font-semibold text-blue-700 hover:text-blue-800">Daftar sekolah anda <svg class="h-4 w-4" aria-hidden="true"><use href="#i-arrow-right"/></svg></a>
            </article>
            <article class="reveal lift flex flex-col rounded-2xl border border-gray-200 bg-white p-7">
                <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-600 text-white shadow-md shadow-indigo-600/25"><svg class="h-6 w-6" aria-hidden="true"><use href="#i-book"/></svg></span>
                <h3 class="mt-5 text-xl font-bold text-gray-900">Guru KAFA (individu)</h3>
                <p class="mt-1 text-sm text-gray-600">Mula sendiri, walaupun sekolah belum melanggan.</p>
                <ul class="mt-6 flex-1 space-y-3 text-sm text-gray-700">
                    <li class="flex gap-3"><svg class="mt-0.5 h-5 w-5 shrink-0 text-indigo-600" aria-hidden="true"><use href="#i-check"/></svg>Urus kelas dan murid anda sendiri</li>
                    <li class="flex gap-3"><svg class="mt-0.5 h-5 w-5 shrink-0 text-indigo-600" aria-hidden="true"><use href="#i-check"/></svg>RPH dengan tulisan Jawi, cetak PDF</li>
                    <li class="flex gap-3"><svg class="mt-0.5 h-5 w-5 shrink-0 text-indigo-600" aria-hidden="true"><use href="#i-check"/></svg>Markah, pencapaian dan sijil murid</li>
                    <li class="flex gap-3"><svg class="mt-0.5 h-5 w-5 shrink-0 text-indigo-600" aria-hidden="true"><use href="#i-check"/></svg>Bila sekolah melanggan, data kelas dibawa bersama</li>
                </ul>
                <a href="{{ route('register', ['jenis' => 'personal']) }}" class="mt-7 inline-flex items-center gap-1.5 text-sm font-semibold text-indigo-700 hover:text-indigo-800">Daftar sebagai guru individu <svg class="h-4 w-4" aria-hidden="true"><use href="#i-arrow-right"/></svg></a>
            </article>
            <article class="reveal lift flex flex-col rounded-2xl border border-gray-200 bg-white p-7">
                <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-teal-600 text-white shadow-md shadow-teal-600/25"><svg class="h-6 w-6" aria-hidden="true"><use href="#i-heart"/></svg></span>
                <h3 class="mt-5 text-xl font-bold text-gray-900">Ibu Bapa</h3>
                <p class="mt-1 text-sm text-gray-600">Ikuti perkembangan anak terus dari telefon.</p>
                <ul class="mt-6 flex-1 space-y-3 text-sm text-gray-700">
                    <li class="flex gap-3"><svg class="mt-0.5 h-5 w-5 shrink-0 text-teal-600" aria-hidden="true"><use href="#i-check"/></svg>Log masuk mudah dengan No. Kad Pengenalan</li>
                    <li class="flex gap-3"><svg class="mt-0.5 h-5 w-5 shrink-0 text-teal-600" aria-hidden="true"><use href="#i-check"/></svg>Semak kehadiran dan keputusan peperiksaan</li>
                    <li class="flex gap-3"><svg class="mt-0.5 h-5 w-5 shrink-0 text-teal-600" aria-hidden="true"><use href="#i-check"/></svg>Muat turun sijil digital anak</li>
                    <li class="flex gap-3"><svg class="mt-0.5 h-5 w-5 shrink-0 text-teal-600" aria-hidden="true"><use href="#i-check"/></svg>Terima hebahan terus dari sekolah</li>
                </ul>
                <p class="mt-7 text-xs text-gray-500">Akaun ibu bapa disediakan oleh sekolah yang melanggan pakej Sekolah.</p>
            </article>
        </div>
    </div>
</section>

<!-- ========================= 8. HARGA ========================= -->
<section id="harga" class="py-20 sm:py-24">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="reveal mx-auto max-w-2xl text-center">
            <p class="text-sm font-semibold uppercase tracking-wider text-blue-600">Harga</p>
            <h2 class="mt-3 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Harga yang jelas, bayar bulanan</h2>
            <p class="mt-4 text-lg text-gray-600">Mula percuma. Naik taraf hanya bila anda perlukan lebih.</p>
        </div>

        <div class="mx-auto mt-14 grid max-w-6xl items-start gap-6 lg:grid-cols-3" data-stagger>
            <!-- Percuma -->
            <article class="reveal lift flex h-full flex-col rounded-2xl border border-gray-200 bg-white p-7">
                <h3 class="text-lg font-semibold text-gray-900">Percuma</h3>
                <p class="mt-1 text-sm text-gray-600">Untuk mula mencuba.</p>
                <p class="mt-6 flex items-baseline gap-1"><span class="text-4xl font-extrabold tracking-tight text-gray-900">RM0</span><span class="text-sm text-gray-500">/bulan</span></p>
                <a href="{{ route('register') }}" class="mt-6 inline-flex items-center justify-center rounded-xl border border-gray-300 px-5 py-3 text-sm font-semibold text-gray-800 transition-colors hover:border-gray-400 hover:bg-gray-50">Mula Percuma</a>
                <ul class="mt-8 space-y-3 text-sm text-gray-700">
                    <li class="flex gap-3 font-semibold text-gray-900"><svg class="mt-0.5 h-5 w-5 shrink-0 text-blue-600" aria-hidden="true"><use href="#i-check"/></svg>3 kelas, 40 murid sekelas</li>
                    <li class="flex gap-3"><svg class="mt-0.5 h-5 w-5 shrink-0 text-blue-600" aria-hidden="true"><use href="#i-check"/></svg>Kelas &amp; Murid</li>
                    <li class="flex gap-3"><svg class="mt-0.5 h-5 w-5 shrink-0 text-blue-600" aria-hidden="true"><use href="#i-check"/></svg>Kehadiran Harian</li>
                    <li class="flex gap-3"><svg class="mt-0.5 h-5 w-5 shrink-0 text-blue-600" aria-hidden="true"><use href="#i-check"/></svg>Jadual Waktu</li>
                    <li class="flex gap-3"><svg class="mt-0.5 h-5 w-5 shrink-0 text-blue-600" aria-hidden="true"><use href="#i-check"/></svg>Peperiksaan &amp; Markah</li>
                </ul>
            </article>

            <!-- Personal -->
            <article class="reveal lift flex h-full flex-col rounded-2xl border border-gray-200 bg-white p-7">
                <h3 class="text-lg font-semibold text-gray-900">Personal</h3>
                <p class="mt-1 text-sm text-gray-600">Untuk guru individu — kelas sendiri sahaja.</p>
                <p class="mt-6 flex items-baseline gap-1"><span class="text-4xl font-extrabold tracking-tight text-gray-900">RM19</span><span class="text-sm text-gray-500">/bulan</span></p>
                <a href="{{ route('register', ['jenis' => 'personal']) }}" class="mt-6 inline-flex items-center justify-center rounded-xl border border-indigo-200 bg-indigo-50 px-5 py-3 text-sm font-semibold text-indigo-700 transition-colors hover:bg-indigo-100">Pilih Personal</a>
                <ul class="mt-8 space-y-3 text-sm text-gray-700">
                    <li class="flex gap-3 font-semibold text-gray-900"><svg class="mt-0.5 h-5 w-5 shrink-0 text-indigo-600" aria-hidden="true"><use href="#i-check"/></svg>Kelas &amp; murid tanpa had</li>
                    <li class="pl-8 text-xs font-semibold uppercase tracking-wide text-gray-500">Semua dalam Percuma, serta:</li>
                    <li class="flex gap-3"><svg class="mt-0.5 h-5 w-5 shrink-0 text-indigo-600" aria-hidden="true"><use href="#i-check"/></svg>Kehadiran QR / Kiosk</li>
                    <li class="flex gap-3"><svg class="mt-0.5 h-5 w-5 shrink-0 text-indigo-600" aria-hidden="true"><use href="#i-check"/></svg>Import Murid (Excel)</li>
                    <li class="flex gap-3"><svg class="mt-0.5 h-5 w-5 shrink-0 text-indigo-600" aria-hidden="true"><use href="#i-check"/></svg>Rekod RPH</li>
                    <li class="flex gap-3"><svg class="mt-0.5 h-5 w-5 shrink-0 text-indigo-600" aria-hidden="true"><use href="#i-check"/></svg>Rekod Pencapaian &amp; Disiplin</li>
                    <li class="flex gap-3"><svg class="mt-0.5 h-5 w-5 shrink-0 text-indigo-600" aria-hidden="true"><use href="#i-check"/></svg>Aktiviti &amp; Sijil Digital</li>
                    <li class="flex gap-3"><svg class="mt-0.5 h-5 w-5 shrink-0 text-indigo-600" aria-hidden="true"><use href="#i-check"/></svg>Laporan Murid</li>
                    <li class="flex gap-3"><svg class="mt-0.5 h-5 w-5 shrink-0 text-indigo-600" aria-hidden="true"><use href="#i-check"/></svg>Pembantu AI</li>
                </ul>
            </article>

            <!-- Sekolah (highlighted) -->
            <article class="reveal relative flex h-full flex-col rounded-2xl bg-white p-7 shadow-2xl shadow-blue-600/15 ring-2 ring-blue-600">
                <span class="absolute -top-3.5 left-1/2 -translate-x-1/2 whitespace-nowrap rounded-full bg-blue-600 px-3 py-1 text-xs font-semibold text-white shadow-md">Paling Popular</span>
                <h3 class="text-lg font-semibold text-blue-700">Sekolah</h3>
                <p class="mt-1 text-sm text-gray-600">Untuk Guru Besar, guru dan ibu bapa.</p>
                <p class="mt-6 flex items-baseline gap-1"><span class="text-4xl font-extrabold tracking-tight text-gray-900">RM49</span><span class="text-sm text-gray-500">/bulan</span></p>
                <a href="{{ route('register') }}" class="btn-grad mt-6 inline-flex items-center justify-center gap-2 rounded-xl px-5 py-3 text-sm font-semibold text-white">Pilih Sekolah <svg class="h-4 w-4" aria-hidden="true"><use href="#i-arrow-right"/></svg></a>
                <ul class="mt-8 space-y-3 text-sm text-gray-700">
                    <li class="flex gap-3 font-semibold text-gray-900"><svg class="mt-0.5 h-5 w-5 shrink-0 text-blue-600" aria-hidden="true"><use href="#i-check"/></svg>Kelas, murid &amp; guru tanpa had</li>
                    <li class="pl-8 text-xs font-semibold uppercase tracking-wide text-gray-500">Semua dalam Personal, serta:</li>
                    <li class="flex gap-3"><svg class="mt-0.5 h-5 w-5 shrink-0 text-blue-600" aria-hidden="true"><use href="#i-check"/></svg>Urus Guru &amp; Pengguna (jemput guru)</li>
                    <li class="flex gap-3"><svg class="mt-0.5 h-5 w-5 shrink-0 text-blue-600" aria-hidden="true"><use href="#i-check"/></svg>Semakan &amp; Kelulusan RPH</li>
                    <li class="flex gap-3"><svg class="mt-0.5 h-5 w-5 shrink-0 text-blue-600" aria-hidden="true"><use href="#i-check"/></svg>Laporan &amp; KPI Sekolah</li>
                    <li class="flex gap-3"><svg class="mt-0.5 h-5 w-5 shrink-0 text-blue-600" aria-hidden="true"><use href="#i-check"/></svg>Kewangan</li>
                    <li class="flex gap-3"><svg class="mt-0.5 h-5 w-5 shrink-0 text-blue-600" aria-hidden="true"><use href="#i-check"/></svg>Hebahan Sekolah</li>
                    <li class="flex gap-3"><svg class="mt-0.5 h-5 w-5 shrink-0 text-blue-600" aria-hidden="true"><use href="#i-check"/></svg>Portal Ibu Bapa</li>
                    <li class="flex gap-3"><svg class="mt-0.5 h-5 w-5 shrink-0 text-blue-600" aria-hidden="true"><use href="#i-check"/></svg>Pindah Murid</li>
                </ul>
            </article>
        </div>

        <p class="reveal mx-auto mt-10 max-w-2xl text-center text-sm leading-relaxed text-gray-600">
            Bayaran bulanan melalui FPX. Tiada kontrak — batal bila-bila masa. Jika langganan tamat, data anda kekal selamat dan akaun kembali ke pakej Percuma.
        </p>
    </div>
</section>

<!-- ========================= 9. KESELAMATAN & PRIVASI ========================= -->
<section class="on-dark relative overflow-hidden bg-slate-900 py-20 text-white sm:py-24">
    <div class="pattern-star-light pointer-events-none absolute inset-0" style="opacity:.05" aria-hidden="true"></div>
    <div class="pointer-events-none absolute rounded-full bg-blue-600/30 blur-3xl" style="width:480px;height:480px;top:-160px;left:-120px" aria-hidden="true"></div>
    <div class="relative mx-auto grid max-w-7xl gap-12 px-4 sm:px-6 lg:grid-cols-5 lg:px-8">
        <div class="reveal lg:col-span-2">
            <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-white/10 text-teal-300 ring-1 ring-white/15"><svg class="h-6 w-6" aria-hidden="true"><use href="#i-shield"/></svg></span>
            <h2 class="mt-5 text-3xl font-bold tracking-tight sm:text-4xl">Data murid anda, dijaga dengan serius</h2>
            <p class="mt-4 text-lg leading-relaxed text-slate-300">Maklumat murid dan keluarga adalah amanah. eKafa dibina dengan perlindungan data sebagai asas, bukan tambahan.</p>
            <div class="mt-8 flex flex-wrap gap-4 text-sm font-semibold">
                <a href="{{ route('legal.terms') }}" class="inline-flex items-center gap-1.5 text-teal-300 hover:text-teal-200">Terma Penggunaan <svg class="h-4 w-4" aria-hidden="true"><use href="#i-arrow-right"/></svg></a>
                <a href="{{ route('legal.privacy') }}" class="inline-flex items-center gap-1.5 text-teal-300 hover:text-teal-200">Dasar Privasi <svg class="h-4 w-4" aria-hidden="true"><use href="#i-arrow-right"/></svg></a>
            </div>
        </div>
        <div class="grid gap-4 sm:grid-cols-2 lg:col-span-3" data-stagger>
            <div class="reveal rounded-2xl border border-white/10 bg-white/5 p-5">
                <svg class="h-6 w-6 text-teal-300" aria-hidden="true"><use href="#i-lock"/></svg>
                <h3 class="mt-3 font-semibold">Data setiap sekolah diasingkan</h3>
                <p class="mt-1 text-sm text-slate-300">Rekod sekolah anda tidak boleh dilihat oleh sekolah lain — diasingkan sepenuhnya.</p>
            </div>
            <div class="reveal rounded-2xl border border-white/10 bg-white/5 p-5">
                <svg class="h-6 w-6 text-teal-300" aria-hidden="true"><use href="#i-doc-check"/></svg>
                <h3 class="mt-3 font-semibold">Patuh PDPA 2010</h3>
                <p class="mt-1 text-sm text-slate-300">Data peribadi diurus selaras dengan Akta Perlindungan Data Peribadi 2010.</p>
            </div>
            <div class="reveal rounded-2xl border border-white/10 bg-white/5 p-5">
                <svg class="h-6 w-6 text-teal-300" aria-hidden="true"><use href="#i-users"/></svg>
                <h3 class="mt-3 font-semibold">Akses ikut peranan</h3>
                <p class="mt-1 text-sm text-slate-300">Ibu bapa hanya nampak data anak sendiri; guru hanya kelas masing-masing.</p>
            </div>
            <div class="reveal rounded-2xl border border-white/10 bg-white/5 p-5">
                <svg class="h-6 w-6 text-teal-300" aria-hidden="true"><use href="#i-cloud"/></svg>
                <h3 class="mt-3 font-semibold">Sandaran berkala</h3>
                <p class="mt-1 text-sm text-slate-300">Data disandarkan secara berkala supaya rekod penting tidak hilang.</p>
            </div>
            <div class="reveal rounded-2xl border border-white/10 bg-white/5 p-5 sm:col-span-2">
                <svg class="h-6 w-6 text-teal-300" aria-hidden="true"><use href="#i-globe"/></svg>
                <h3 class="mt-3 font-semibold">Sambungan HTTPS</h3>
                <p class="mt-1 text-sm text-slate-300">Semua data yang dihantar antara peranti anda dan eKafa disulitkan.</p>
            </div>
        </div>
    </div>
</section>

<!-- ========================= 10. SOALAN LAZIM ========================= -->
<section id="soalan" class="py-20 sm:py-24">
    <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
        <div class="reveal text-center">
            <p class="text-sm font-semibold uppercase tracking-wider text-blue-600">Soalan Lazim</p>
            <h2 class="mt-3 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Ada soalan? Kami ada jawapan</h2>
        </div>

        <div class="reveal mt-12 divide-y divide-gray-200 overflow-hidden rounded-2xl border border-gray-200 bg-white" x-data="{ open: 0 }">
            <template x-for="(f, i) in [
                { q: 'Adakah pakej Percuma benar-benar percuma?', a: 'Ya. Pakej Percuma kekal RM0 tanpa had masa untuk sehingga 3 kelas dan 40 murid sekelas. Tiada kad kredit diperlukan semasa mendaftar.' },
                { q: 'Boleh guna di telefon?', a: 'Boleh. eKafa dibina mesra telefon — guru boleh tanda kehadiran, isi RPH dan masukkan markah terus dari pelayar telefon tanpa perlu memasang aplikasi.' },
                { q: 'Boleh import senarai murid dari SIMPENI atau Excel?', a: 'Boleh. Muat naik fail Excel (.xlsx) senarai murid dan eKafa akan memasukkan murid ke kelas masing-masing. Fungsi Import Murid tersedia dari pakej Personal.' },
                { q: 'Bagaimana guru Personal bergabung bila sekolah melanggan?', a: 'Guru Besar menghantar pautan jemputan. Bila anda terima jemputan itu, kelas, murid dan rekod anda dibawa bersama ke akaun sekolah — tiada apa yang perlu dimasukkan semula.' },
                { q: 'Bagaimana ibu bapa log masuk?', a: 'Ibu bapa log masuk menggunakan No. Kad Pengenalan dan kata laluan yang diberikan oleh sekolah. Mereka hanya boleh melihat data anak sendiri. Portal Ibu Bapa tersedia untuk sekolah yang melanggan pakej Sekolah.' },
                { q: 'Apakah kaedah bayaran?', a: 'Bayaran dibuat secara bulanan melalui FPX (perbankan dalam talian). Tiada kontrak jangka panjang — anda boleh berhenti bila-bila masa.' },
                { q: 'Apa jadi pada data jika saya berhenti melanggan?', a: 'Data anda kekal selamat. Akaun akan kembali ke pakej Percuma dan modul berbayar dikunci, tetapi rekod anda tidak hilang — semuanya boleh diakses semula bila anda melanggan semula.' },
                { q: 'Adakah eKafa menyokong tulisan Jawi?', a: 'Ya. RPH dan dokumen lain menyokong tulisan Jawi sepenuhnya, dan PDF dicetak dengan fon Jawi supaya teks kekal kemas dan mudah dibaca.' }
            ]" :key="i">
                <div>
                    <h3>
                        <button type="button" class="flex w-full items-center justify-between gap-4 px-5 py-5 text-left text-base font-semibold text-gray-900 transition-colors hover:bg-gray-50 sm:px-6"
                                x-on:click="open = (open === i ? null : i)" :aria-expanded="(open === i).toString()" :aria-controls="'faq-' + i" :id="'faq-btn-' + i">
                            <span x-text="f.q"></span>
                            <svg class="h-5 w-5 shrink-0 text-gray-500 transition-transform duration-300" :class="open === i ? 'rotate-180 text-blue-600' : ''" aria-hidden="true"><use href="#i-chevron-down"/></svg>
                        </button>
                    </h3>
                    <div x-show="open === i" x-cloak :id="'faq-' + i" role="region" :aria-labelledby="'faq-btn-' + i"
                         x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-1" x-transition:enter-end="opacity-100 translate-y-0">
                        <p class="px-5 pb-5 text-sm leading-relaxed text-gray-600 sm:px-6" x-text="f.a"></p>
                    </div>
                </div>
            </template>
        </div>
    </div>
</section>

<!-- ========================= 11. LOG MASUK ========================= -->
<section id="log-masuk" class="relative overflow-hidden bg-gray-50 py-20 sm:py-24">
    <div class="pattern-star mask-fade pointer-events-none absolute inset-0" style="opacity:.05" aria-hidden="true"></div>
    <div class="relative mx-auto grid max-w-6xl items-center gap-12 px-4 sm:px-6 lg:grid-cols-2 lg:px-8">
        <div class="reveal">
            <p class="text-sm font-semibold uppercase tracking-wider text-blue-600">Log Masuk</p>
            <h2 class="mt-3 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Selamat kembali</h2>
            <p class="mt-4 text-lg text-gray-600">Satu pintu masuk untuk semua — pilih jenis akaun anda.</p>
            <div class="mt-8 space-y-4">
                <div class="flex gap-4">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-100 text-blue-700"><svg class="h-5 w-5" aria-hidden="true"><use href="#i-school"/></svg></span>
                    <div><p class="font-semibold text-gray-900">Kakitangan</p><p class="text-sm text-gray-600">Guru Besar dan Guru KAFA — guna e-mel, ID pengguna atau No. KP.</p></div>
                </div>
                <div class="flex gap-4">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-teal-100 text-teal-700"><svg class="h-5 w-5" aria-hidden="true"><use href="#i-heart"/></svg></span>
                    <div><p class="font-semibold text-gray-900">Ibu Bapa</p><p class="text-sm text-gray-600">Guna No. Kad Pengenalan dan kata laluan daripada sekolah anak anda.</p></div>
                </div>
            </div>
        </div>

        <div class="reveal" style="--d:120ms">
            <div class="mx-auto w-full max-w-md rounded-2xl border border-gray-200 bg-white p-6 shadow-xl shadow-gray-900/5 sm:p-8">
                <form method="POST" action="{{ route('login') }}" x-data="{ loginType: '{{ old('login_type', 'staff') === 'parent' ? 'parent' : 'staff' }}', showPw: false }" novalidate>
                    @csrf
                    <input type="hidden" name="login_type" value="{{ old('login_type', 'staff') }}" :value="loginType">

                    <div class="grid grid-cols-2 gap-1 rounded-xl bg-gray-100 p-1" role="group" aria-label="Jenis akaun">
                        <button type="button" x-on:click="loginType = 'staff'" :aria-pressed="(loginType === 'staff').toString()"
                                class="rounded-lg px-3 py-2 text-sm font-semibold transition-all duration-200"
                                :class="loginType === 'staff' ? 'bg-white text-blue-700 shadow-sm' : 'text-gray-600 hover:text-gray-900'">Kakitangan</button>
                        <button type="button" x-on:click="loginType = 'parent'" :aria-pressed="(loginType === 'parent').toString()"
                                class="rounded-lg px-3 py-2 text-sm font-semibold transition-all duration-200"
                                :class="loginType === 'parent' ? 'bg-white text-blue-700 shadow-sm' : 'text-gray-600 hover:text-gray-900'">Ibu Bapa</button>
                    </div>

                    <div class="mt-6">
                        <label for="login_id" class="mb-1.5 block text-sm font-medium text-gray-800" x-text="loginType === 'staff' ? 'ID Log Masuk' : 'No. Kad Pengenalan'">ID Log Masuk</label>
                        <input id="login_id" name="login_id" type="text" autocomplete="username" required value="{{ old('login_id') }}"
                               :placeholder="loginType === 'staff' ? 'E-mel / ID pengguna / No. KP' : 'No. Kad Pengenalan (cth: 800101-08-5555)'"
                               placeholder="E-mel / ID pengguna / No. KP"
                               class="w-full rounded-lg border border-gray-300 bg-white px-3.5 py-2.5 text-sm text-gray-900 placeholder-gray-500 focus:border-transparent focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('login_id')
                        <p class="mt-1.5 text-sm font-medium text-red-600" role="alert">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <label for="password" class="mb-1.5 block text-sm font-medium text-gray-800">Kata Laluan</label>
                        <div class="relative">
                            <input id="password" name="password" type="password" :type="showPw ? 'text' : 'password'" autocomplete="current-password" required placeholder="••••••••"
                                   class="w-full rounded-lg border border-gray-300 bg-white py-2.5 pl-3.5 pr-11 text-sm text-gray-900 placeholder-gray-500 focus:border-transparent focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <button type="button" x-on:click="showPw = !showPw" class="absolute inset-y-0 right-0 flex w-11 items-center justify-center rounded-r-lg text-gray-500 hover:text-gray-700"
                                    :aria-label="showPw ? 'Sembunyikan kata laluan' : 'Tunjuk kata laluan'" aria-label="Tunjuk kata laluan">
                                <svg class="h-5 w-5" aria-hidden="true" x-show="!showPw"><use href="#i-eye"/></svg>
                                <svg class="h-5 w-5" aria-hidden="true" x-show="showPw" x-cloak><use href="#i-eye-off"/></svg>
                            </button>
                        </div>
                    </div>

                    <div class="mt-4 flex flex-wrap items-center justify-between gap-2">
                        <label class="inline-flex cursor-pointer items-center gap-2 text-sm text-gray-700">
                            <input type="checkbox" name="remember" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500" style="accent-color:#2563EB">
                            Ingat Saya
                        </label>
                        <a href="{{ route('password.request') }}" x-show="loginType === 'staff'" class="text-sm font-semibold text-blue-700 hover:text-blue-800">Lupa Kata Laluan?</a>
                    </div>
                    <p x-show="loginType === 'parent'" x-cloak class="mt-3 rounded-lg bg-teal-50 px-3 py-2 text-xs text-teal-800">Lupa kata laluan? Hubungi sekolah anak anda.</p>

                    <button type="submit" class="btn-grad mt-6 inline-flex w-full items-center justify-center gap-2 rounded-xl px-5 py-3 text-sm font-semibold text-white">
                        Masuk ke Akaun
                        <svg class="h-4 w-4" aria-hidden="true"><use href="#i-arrow-right"/></svg>
                    </button>

                    <p class="mt-6 text-center text-sm text-gray-600">Belum ada akaun? <a href="{{ route('register') }}" class="font-semibold text-blue-700 hover:text-blue-800">Daftar percuma</a></p>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- ========================= 12. CTA AKHIR ========================= -->
<section class="px-4 py-20 sm:px-6 sm:py-24 lg:px-8">
    <div class="on-dark reveal relative mx-auto max-w-6xl overflow-hidden rounded-3xl px-6 py-16 text-center text-white shadow-2xl shadow-blue-900/20 sm:px-12 sm:py-20"
         style="background:linear-gradient(135deg,#1E40AF 0%,#2563EB 55%,#1D4ED8 100%)">
        <div class="pattern-star-light pointer-events-none absolute inset-0" style="opacity:.1" aria-hidden="true"></div>
        <div class="pointer-events-none absolute rounded-full blur-3xl" style="width:380px;height:380px;right:-100px;bottom:-160px;background:rgba(45,212,191,.35)" aria-hidden="true"></div>
        <div class="relative">
            <h2 class="mx-auto max-w-2xl text-3xl font-extrabold tracking-tight sm:text-5xl">Sedia untuk mendigitalkan KAFA anda?</h2>
            <p class="mx-auto mt-5 max-w-xl text-lg text-blue-100">Daftar hari ini dan mula rekod kehadiran kelas pertama anda dalam masa beberapa minit.</p>
            <div class="mt-9 flex flex-col justify-center gap-3 sm:flex-row">
                <a href="{{ route('register') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-white px-7 py-3.5 text-base font-semibold text-blue-700 shadow-lg transition-transform hover:-translate-y-0.5">
                    Daftar Percuma <svg class="h-4 w-4" aria-hidden="true"><use href="#i-arrow-right"/></svg>
                </a>
                <a href="{{ route('demo') }}" class="inline-flex items-center justify-center gap-2 rounded-xl border border-white/40 bg-white/10 px-7 py-3.5 text-base font-semibold text-white backdrop-blur transition-colors hover:bg-white/20">
                    <svg class="h-5 w-5" aria-hidden="true"><use href="#i-eye"/></svg> Cuba Demo
                </a>
                <a href="https://wa.me/60194920559" target="_blank" rel="noopener" class="inline-flex items-center justify-center gap-2 rounded-xl border border-white/40 bg-white/10 px-7 py-3.5 text-base font-semibold text-white backdrop-blur transition-colors hover:bg-white/20">
                    <svg class="h-5 w-5" aria-hidden="true"><use href="#i-chat"/></svg> Hubungi Kami di WhatsApp
                </a>
            </div>
            <p class="mt-6 text-sm text-blue-100">Percuma selamanya untuk 3 kelas · Tiada kad kredit diperlukan</p>
        </div>
    </div>
</section>

</main>

<!-- ========================= 13. FOOTER ========================= -->
<footer class="border-t border-gray-200 bg-white">
    <div class="mx-auto grid max-w-7xl gap-10 px-4 py-14 sm:px-6 md:grid-cols-3 lg:px-8">
        <div>
            <a href="#" class="flex items-center gap-2.5" aria-label="eKafa Online">
                <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-blue-600 text-sm font-extrabold text-white">eK</span>
                <span class="flex flex-col leading-none">
                    <span class="text-[17px] font-bold tracking-tight text-gray-900">eKafa <span class="text-blue-600">Online</span></span>
                    <span class="jawi -mt-0.5 text-[15px] text-gray-500" dir="rtl" lang="ms-Arab">ڤڠوروسن کفا</span>
                </span>
            </a>
            <p class="mt-4 max-w-xs text-sm leading-relaxed text-gray-600">Platform pengurusan sekolah KAFA — kehadiran, RPH, peperiksaan dan portal ibu bapa dalam satu tempat.</p>
        </div>
        <nav class="grid grid-cols-2 gap-8 md:col-span-2 md:grid-cols-3" aria-label="Pautan footer">
            <div>
                <p class="text-sm font-semibold text-gray-900">Produk</p>
                <ul class="mt-4 space-y-3 text-sm">
                    <li><a href="#ciri" class="text-gray-600 hover:text-blue-700">Ciri-ciri</a></li>
                    <li><a href="#harga" class="text-gray-600 hover:text-blue-700">Harga</a></li>
                    <li><a href="#soalan" class="text-gray-600 hover:text-blue-700">Soalan Lazim</a></li>
                </ul>
            </div>
            <div>
                <p class="text-sm font-semibold text-gray-900">Undang-undang</p>
                <ul class="mt-4 space-y-3 text-sm">
                    <li><a href="{{ route('legal.terms') }}" class="text-gray-600 hover:text-blue-700">Terma</a></li>
                    <li><a href="{{ route('legal.privacy') }}" class="text-gray-600 hover:text-blue-700">Privasi</a></li>
                </ul>
            </div>
            <div>
                <p class="text-sm font-semibold text-gray-900">Sokongan</p>
                <ul class="mt-4 space-y-3 text-sm">
                    <li><a href="https://wa.me/60194920559" target="_blank" rel="noopener" class="text-gray-600 hover:text-blue-700">Hubungi</a></li>
                    <li><a href="#log-masuk" class="text-gray-600 hover:text-blue-700">Log Masuk</a></li>
                </ul>
            </div>
        </nav>
    </div>
    <div class="border-t border-gray-100">
        <div class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-2 px-4 py-6 text-sm text-gray-500 sm:flex-row sm:px-6 lg:px-8">
            <p>© 2026 eKafa Online. Hak cipta terpelihara.</p>
            <p>Dibina untuk sekolah KAFA di Malaysia.</p>
        </div>
    </div>
</footer>

@if(isset($announcements) && $announcements->isNotEmpty())
{{-- Hebahan platform (Super Admin) --}}
<aside x-data="{ show: true, open: null }" x-show="show" x-cloak
       class="fixed bottom-4 left-4 right-4 z-40 sm:left-auto sm:w-96 rounded-2xl border border-gray-200 bg-white shadow-xl" aria-label="Makluman">
    <div class="flex items-center justify-between border-b border-gray-100 px-4 py-3">
        <p class="text-sm font-semibold text-gray-900">Makluman</p>
        <button type="button" x-on:click="show = false" class="rounded-lg p-1 text-gray-400 hover:text-gray-600" aria-label="Tutup makluman">
            <svg class="h-4 w-4" aria-hidden="true"><use href="#i-x"/></svg>
        </button>
    </div>
    <ul class="max-h-72 divide-y divide-gray-100 overflow-y-auto">
        @foreach($announcements as $a)
        <li class="px-4 py-3">
            <button type="button" class="w-full text-left"
                    x-on:click="open = open === {{ $a->id }} ? null : {{ $a->id }}; if (open) fetch('{{ route('announcements.increment-view', $a) }}', {method: 'POST', headers: {'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content}})">
                @if($a->homepage_label)
                <span class="mb-1 inline-block rounded-full bg-blue-100 px-2 py-0.5 text-xs font-medium text-blue-700">{{ $a->homepage_label }}</span>
                @endif
                <span class="block text-sm font-medium text-gray-900">{{ $a->title }}</span>
            </button>
            <div x-show="open === {{ $a->id }}" x-cloak class="mt-2 whitespace-pre-line text-sm text-gray-600">{{ $a->content }}</div>
        </li>
        @endforeach
    </ul>
</aside>
@endif

<script>
    var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    // Product tour tabs (Alpine)
    function tour() {
        return {
            active: 0,
            tabs: ['Dashboard Guru Besar', 'Kehadiran QR', 'RPH Jawi', 'Markah Peperiksaan', 'Portal Ibu Bapa'],
            ind: { left: 0, width: 0 },
            init() {
                var self = this;
                this.$nextTick(function () { self.move(); });
                window.addEventListener('resize', function () { self.move(); });
                window.addEventListener('load', function () { self.move(); });
                if (document.fonts && document.fonts.ready) document.fonts.ready.then(function () { self.move(); });
            },
            buttons() { return this.$refs.list.querySelectorAll('[role="tab"]'); },
            select(i) {
                var self = this;
                this.active = i;
                this.$nextTick(function () {
                    self.move();
                    var b = self.buttons()[i];
                    if (b && b.scrollIntoView) b.scrollIntoView({ block: 'nearest', inline: 'nearest' });
                });
            },
            key(e) {
                var n = this.tabs.length, next = null;
                if (e.key === 'ArrowRight') next = (this.active + 1) % n;
                if (e.key === 'ArrowLeft') next = (this.active + n - 1) % n;
                if (e.key === 'Home') next = 0;
                if (e.key === 'End') next = n - 1;
                if (next === null) return;
                e.preventDefault();
                this.select(next);
                var self = this;
                this.$nextTick(function () { self.buttons()[next].focus(); });
            },
            move() {
                var b = this.buttons()[this.active];
                if (b) this.ind = { left: b.offsetLeft, width: b.offsetWidth };
            }
        };
    }

    // QR attendance demo (Alpine)
    function qrDemo() {
        return {
            n: 0,
            names: ['Ahmad Zayyad', 'Nur Imanina', 'Muhammad Ammar', 'Aisyah Humaira', 'Muhammad Haziq', 'Nur Aleesya'],
            times: ['2:31', '2:31', '2:32', '2:32', '2:33', '2:34'],
            init() {
                var self = this;
                if (reduceMotion) { this.n = this.names.length; return; }
                setInterval(function () {
                    self.n = self.n >= self.names.length + 2 ? 0 : self.n + 1;
                }, 1100);
            }
        };
    }

    // Scroll reveal + stagger
    (function () {
        document.querySelectorAll('[data-stagger]').forEach(function (group) {
            Array.prototype.forEach.call(group.children, function (child, i) {
                child.style.setProperty('--d', (i * 90) + 'ms');
            });
        });
        var items = document.querySelectorAll('.reveal');
        if (reduceMotion || !('IntersectionObserver' in window)) {
            items.forEach(function (el) { el.classList.add('is-in'); });
            return;
        }
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-in');
                    io.unobserve(entry.target);
                }
            });
        }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });
        items.forEach(function (el) { io.observe(el); });
    })();

    // Animated counter (hero)
    (function () {
        document.querySelectorAll('[data-count-to]').forEach(function (el) {
            var target = parseInt(el.getAttribute('data-count-to'), 10);
            if (reduceMotion) { el.textContent = target; return; }
            el.textContent = '0';
            var start = null, duration = 1600, delay = 600;
            function step(ts) {
                if (start === null) start = ts;
                var p = Math.min((ts - start) / duration, 1);
                var eased = 1 - Math.pow(1 - p, 3);
                el.textContent = Math.round(target * eased);
                if (p < 1) requestAnimationFrame(step);
            }
            setTimeout(function () { requestAnimationFrame(step); }, delay);
        });
    })();
</script>
@if($errors->any())
<script>document.getElementById('log-masuk').scrollIntoView();</script>
@endif
</body>
</html>
