<!DOCTYPE html>
<html lang="ms">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Demo eKafa Online — Cuba Tanpa Daftar</title>
<meta name="description" content="Cuba demo interaktif eKafa Online — sistem pengurusan sekolah KAFA. Tiada pendaftaran diperlukan.">
<meta name="robots" content="noindex">
<meta name="theme-color" content="#2563EB">

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet">
@vite(['resources/css/app.css', 'resources/js/app.js'])

<style>
    /* ===== Asas ===== */
    @font-face { font-family: 'LateefLocal'; src: url('{{ asset('fonts/Lateef-Regular.ttf') }}') format('truetype'); font-display: swap; }
    :root { --demo-h: 92px; --brand: #2563EB; --ink: #0F172A; }
    @media (min-width: 768px) { :root { --demo-h: 52px; } }
    body { font-family: 'Inter', ui-sans-serif, system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif; color: var(--ink); -webkit-font-smoothing: antialiased; }
    [x-cloak] { display: none !important; }
    .jawi { font-family: 'LateefLocal', 'Lateef', serif; line-height: 1.8; }
    .top-demo { top: var(--demo-h); }
    .pt-demo { padding-top: var(--demo-h); }
    .h-demo { height: var(--demo-h); }
    a:focus-visible, button:focus-visible, select:focus-visible, [tabindex]:focus-visible { outline: 2px solid var(--brand); outline-offset: 2px; }

    /* ===== Borang (setara kelas input standard projek) ===== */
    .f-input { width: 100%; padding: .5rem .75rem; font-size: .875rem; line-height: 1.25rem; border: 1px solid #D1D5DB; border-radius: .5rem; background: #fff; color: #111827; }
    .f-input:focus { outline: none; border-color: transparent; box-shadow: 0 0 0 2px #3B82F6; }
    .f-label { display: block; margin-bottom: .375rem; font-size: .875rem; font-weight: 500; color: #374151; }
    .f-mark { width: 3.25rem; padding: .3rem .25rem; text-align: center; font-size: .8125rem; border: 1px solid #E5E7EB; border-radius: .375rem; background: #fff; }
    .f-mark:focus { outline: none; border-color: transparent; box-shadow: 0 0 0 2px #3B82F6; }

    /* ===== Corak geometri Islamik (bintang 8 bucu) ===== */
    .pattern-star { background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='80' height='80' viewBox='0 0 80 80'%3E%3Cg fill='none' stroke='%232563EB' stroke-width='1'%3E%3Cpath d='M60 40L54.14 45.86L54.14 54.14L45.86 54.14L40 60L34.14 54.14L25.86 54.14L25.86 45.86L20 40L25.86 34.14L25.86 25.86L34.14 25.86L40 20L45.86 25.86L54.14 25.86L54.14 34.14Z'/%3E%3Ccircle cx='40' cy='40' r='6'/%3E%3C/g%3E%3C/svg%3E"); background-size: 80px 80px; }
    .pattern-star-light { background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='80' height='80' viewBox='0 0 80 80'%3E%3Cg fill='none' stroke='%23FFFFFF' stroke-width='1'%3E%3Cpath d='M60 40L54.14 45.86L54.14 54.14L45.86 54.14L40 60L34.14 54.14L25.86 54.14L25.86 45.86L20 40L25.86 34.14L25.86 25.86L34.14 25.86L40 20L45.86 25.86L54.14 25.86L54.14 34.14Z'/%3E%3Ccircle cx='40' cy='40' r='6'/%3E%3C/g%3E%3C/svg%3E"); background-size: 80px 80px; }
    .cert-frame { background:
        linear-gradient(#fff, #fff) padding-box,
        repeating-linear-gradient(45deg, #B45309 0 6px, #F59E0B 6px 12px) border-box;
        border: 10px solid transparent; }

    /* ===== Animasi ===== */
    @keyframes scanLine { 0% { top: 10%; } 50% { top: 86%; } 100% { top: 10%; } }
    @keyframes popIn { 0% { opacity: 0; transform: scale(.85); } 60% { opacity: 1; transform: scale(1.04); } 100% { opacity: 1; transform: scale(1); } }
    @keyframes ringDraw { from { stroke-dashoffset: 213.6; } }
    @keyframes dotBounce { 0%, 80%, 100% { transform: translateY(0); opacity: .4; } 40% { transform: translateY(-4px); opacity: 1; } }
    .scan-line { animation: scanLine 2.6s ease-in-out infinite; }
    .pop-in { animation: popIn .45s cubic-bezier(.2,.7,.2,1) both; }
    .ring-draw { animation: ringDraw 1.2s cubic-bezier(.2,.7,.2,1) both; }
    .dot { animation: dotBounce 1.2s infinite; }
    .dot:nth-child(2) { animation-delay: .15s; } .dot:nth-child(3) { animation-delay: .3s; }
    .bar-grow { transition: height .7s cubic-bezier(.2,.7,.2,1), width .7s cubic-bezier(.2,.7,.2,1); }
    .thin-scroll { scrollbar-width: thin; }

    @media (prefers-reduced-motion: reduce) {
        *, *::before, *::after { animation-duration: .01ms !important; animation-iteration-count: 1 !important; transition-duration: .01ms !important; }
    }
    @media print { .no-print { display: none !important; } }
</style>
</head>
<body class="bg-gray-50" x-data="demoApp()" x-init="boot()" x-on:resize.window.debounce.150ms="tourPlace()" x-on:keydown.escape.window="if(tour.on){endTour()} else if(kiosk.open){closeKiosk()} else {modal=null}">

<!-- ===== Ikon (Heroicons outline) ===== -->
<svg xmlns="http://www.w3.org/2000/svg" style="display:none">
    <symbol id="i-check" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m4.5 12.75 6 6 9-13.5"/></symbol>
    <symbol id="i-x" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M6 18 18 6M6 6l12 12"/></symbol>
    <symbol id="i-menu" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/></symbol>
    <symbol id="i-arrow-right" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/></symbol>
    <symbol id="i-arrow-left" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/></symbol>
    <symbol id="i-plus" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 4.5v15m7.5-7.5h-15"/></symbol>
    <symbol id="i-grid" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z"/></symbol>
    <symbol id="i-school" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75Z"/></symbol>
    <symbol id="i-users" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/></symbol>
    <symbol id="i-check-circle" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></symbol>
    <symbol id="i-calendar" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/></symbol>
    <symbol id="i-clipboard" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0 1 18 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3 1.5 1.5 3-3.75"/></symbol>
    <symbol id="i-qr" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 3.75 9.375v-4.5ZM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 0 1-1.125-1.125v-4.5ZM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 13.5 9.375v-4.5Z"/><path d="M6.75 6.75h.75v.75h-.75v-.75ZM6.75 16.5h.75v.75h-.75v-.75ZM16.5 6.75h.75v.75h-.75v-.75ZM13.5 13.5h.75v.75h-.75v-.75ZM13.5 19.5h.75v.75h-.75v-.75ZM19.5 13.5h.75v.75h-.75v-.75ZM19.5 19.5h.75v.75h-.75v-.75ZM16.5 16.5h.75v.75h-.75v-.75Z"/></symbol>
    <symbol id="i-upload" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5"/></symbol>
    <symbol id="i-download" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3"/></symbol>
    <symbol id="i-doc" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/></symbol>
    <symbol id="i-doc-check" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M10.125 2.25h-4.5c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125v-9M10.125 2.25h.375a9 9 0 0 1 9 9v.375M10.125 2.25A3.375 3.375 0 0 1 13.5 5.625v1.5c0 .621.504 1.125 1.125 1.125h1.5a3.375 3.375 0 0 1 3.375 3.375M9 15l2.25 2.25L15 12"/></symbol>
    <symbol id="i-trophy" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M16.5 18.75h-9m9 0a3 3 0 0 1 3 3h-15a3 3 0 0 1 3-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 0 1-.982-3.172M9.497 14.25a7.454 7.454 0 0 0 .981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 0 0 7.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M7.73 9.728a6.726 6.726 0 0 0 2.748 1.35m8.272-6.842V4.5c0 2.108-.966 3.99-2.48 5.228m2.48-5.492a46.32 46.32 0 0 1 2.916.52 6.003 6.003 0 0 1-5.395 4.972m0 0a6.726 6.726 0 0 1-2.749 1.35m0 0a6.772 6.772 0 0 1-3.044 0"/></symbol>
    <symbol id="i-flag" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v1.5M3 21v-6m0 0 2.77-.693a9 9 0 0 1 6.208.682l.108.054a9 9 0 0 0 6.086.71l3.114-.732a48.524 48.524 0 0 1-.005-10.499l-3.11.732a9 9 0 0 1-6.085-.711l-.108-.054a9 9 0 0 0-6.208-.682L3 4.5M3 15V4.5"/></symbol>
    <symbol id="i-star" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z"/></symbol>
    <symbol id="i-academic" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5"/></symbol>
    <symbol id="i-printer" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z"/></symbol>
    <symbol id="i-sparkles" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09ZM18.259 8.715 18 9.75l-.259-1.035a3.375 3.375 0 0 0-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 0 0 2.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 0 0 2.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 0 0-2.456 2.456Z"/></symbol>
    <symbol id="i-user-plus" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z"/></symbol>
    <symbol id="i-presentation" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3.75 3v11.25A2.25 2.25 0 0 0 6 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0 1 18 16.5h-2.25m-7.5 0h7.5m-7.5 0-1 3m8.5-3 1 3m0 0 .5 1.5m-.5-1.5h-9.5m0 0-.5 1.5m.75-9 3-3 2.148 2.148A12.061 12.061 0 0 1 16.5 7.605"/></symbol>
    <symbol id="i-banknotes" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z"/></symbol>
    <symbol id="i-megaphone" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 1 1 0-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 0 1-1.44-4.282m3.102.069a18.03 18.03 0 0 1-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 0 1 8.835 2.535M10.34 6.66a23.847 23.847 0 0 0 8.835-2.535m0 0A23.74 23.74 0 0 0 18.795 3m.38 1.125a23.91 23.91 0 0 1 1.014 5.395m-1.014 8.855c-.118.38-.245.754-.38 1.125m.38-1.125a23.91 23.91 0 0 0 1.014-5.395m0-3.46c.495.413.811 1.035.811 1.73 0 .695-.316 1.317-.811 1.73m0-3.46a24.347 24.347 0 0 1 0 3.46"/></symbol>
    <symbol id="i-phone" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M10.5 1.5H8.25A2.25 2.25 0 0 0 6 3.75v16.5a2.25 2.25 0 0 0 2.25 2.25h7.5A2.25 2.25 0 0 0 18 20.25V3.75a2.25 2.25 0 0 0-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3"/></symbol>
    <symbol id="i-arrows" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M7.5 21 3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5"/></symbol>
    <symbol id="i-card" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z"/></symbol>
    <symbol id="i-home" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/></symbol>
    <symbol id="i-lock" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"/></symbol>
    <symbol id="i-eye" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/><path d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></symbol>
    <symbol id="i-pencil" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"/></symbol>
    <symbol id="i-trash" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/></symbol>
    <symbol id="i-search" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/></symbol>
    <symbol id="i-reset" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99"/></symbol>
    <symbol id="i-info" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z"/></symbol>
    <symbol id="i-warn" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/></symbol>
    <symbol id="i-send" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5"/></symbol>
    <symbol id="i-trend" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941"/></symbol>
    <symbol id="i-heart" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z"/></symbol>
    <symbol id="i-clock" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></symbol>
</svg>

<!-- =====================================================================
     BAR DEMO (tetap di atas)
     ===================================================================== -->
<div class="no-print fixed inset-x-0 top-0 z-[60] h-demo border-b border-amber-300 bg-amber-100 text-amber-950">
    <div class="flex h-full flex-col justify-center gap-1.5 px-3 md:flex-row md:items-center md:justify-between md:gap-4 md:px-4">
        <div class="flex items-center justify-between gap-2">
            <p class="flex min-w-0 items-center gap-2 text-xs font-semibold sm:text-sm">
                <span class="shrink-0 rounded bg-amber-400 px-1.5 py-0.5 text-[10px] font-bold uppercase tracking-wider text-amber-950">Demo</span>
                <span class="hidden truncate sm:inline">Mod Demo — data contoh sahaja, tiada apa disimpan.</span>
                <span class="truncate sm:hidden">Data contoh sahaja</span>
            </p>
            <div class="flex shrink-0 items-center gap-1.5 md:hidden">
                <button type="button" x-on:click="resetDemo()" class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-amber-300 bg-white/70 text-amber-900 hover:bg-white" aria-label="Set Semula Demo"><svg class="h-4 w-4" aria-hidden="true"><use href="#i-reset"/></svg></button>
                <a href="{{ route('register') }}" data-tour="daftar" class="inline-flex h-8 items-center rounded-lg bg-blue-600 px-3 text-xs font-semibold text-white hover:bg-blue-700">Daftar Percuma</a>
            </div>
        </div>
        <div class="flex items-center gap-2 overflow-x-auto thin-scroll" data-tour="role">
            <label class="flex shrink-0 items-center gap-1.5 text-xs font-semibold">
                <span class="hidden lg:inline">Peranan:</span>
                <span class="sr-only lg:hidden">Peranan</span>
                <select x-model="role" x-on:change="switchRole()" class="rounded-lg border border-amber-300 bg-white py-1 pl-2 pr-7 text-xs font-semibold text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="gb">Guru Besar</option>
                    <option value="guru">Guru KAFA</option>
                    <option value="parent">Ibu Bapa</option>
                </select>
            </label>
            <div class="inline-flex shrink-0 rounded-lg bg-white/70 p-0.5 ring-1 ring-amber-300" role="group" aria-label="Pelan langganan">
                <template x-for="p in ['free','personal','sekolah']" :key="p">
                    <button type="button" x-on:click="setPlan(p)" :aria-pressed="(plan === p).toString()"
                            class="whitespace-nowrap rounded-md px-2.5 py-1 text-xs font-semibold transition-colors"
                            :class="plan === p ? 'bg-blue-600 text-white shadow-sm' : 'text-amber-950 hover:bg-white'">
                        <span x-text="PLANS[p].label"></span><span class="hidden xl:inline" x-show="PLANS[p].price > 0" x-text="' (RM' + PLANS[p].price + '/bln)'"></span>
                    </button>
                </template>
            </div>
            <div class="hidden shrink-0 items-center gap-2 md:flex">
                <button type="button" x-on:click="resetDemo()" class="inline-flex items-center gap-1.5 rounded-lg border border-amber-300 bg-white/70 px-3 py-1.5 text-xs font-semibold text-amber-900 hover:bg-white"><svg class="h-4 w-4" aria-hidden="true"><use href="#i-reset"/></svg>Set Semula Demo</button>
                <a href="{{ route('register') }}" data-tour="daftar" class="inline-flex items-center gap-1.5 rounded-lg bg-blue-600 px-3.5 py-1.5 text-xs font-semibold text-white shadow-sm hover:bg-blue-700">Daftar Percuma <svg class="h-3.5 w-3.5" aria-hidden="true"><use href="#i-arrow-right"/></svg></a>
            </div>
        </div>
    </div>
</div>

<!-- =====================================================================
     SIDEBAR (drawer di mudah alih)
     ===================================================================== -->
<div x-show="drawer" x-cloak x-transition.opacity class="no-print fixed inset-0 z-40 bg-gray-900/50 lg:hidden" x-on:click="drawer = false" aria-hidden="true"></div>
<aside class="no-print fixed bottom-0 left-0 z-50 flex w-64 flex-col border-r border-gray-200 bg-white top-demo transition-transform duration-300 lg:z-30"
       :class="drawer ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'" aria-label="Menu sisi">
    <div class="flex items-center gap-2.5 border-b border-gray-100 px-5 py-4">
        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-blue-600 text-sm font-extrabold text-white shadow-md shadow-blue-600/30">eK</span>
        <div class="min-w-0 leading-tight">
            <p class="text-[15px] font-bold tracking-tight text-gray-900">eKafa <span class="text-blue-600">Online</span></p>
            <p class="flex items-center gap-1.5 text-[11px] text-gray-500">Pengurusan KAFA <span class="jawi text-[13px]" dir="rtl" lang="ms-Arab">ڤڠوروسن کفا</span></p>
        </div>
        <button type="button" class="ml-auto inline-flex h-8 w-8 items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100 lg:hidden" x-on:click="drawer = false" aria-label="Tutup menu"><svg class="h-5 w-5" aria-hidden="true"><use href="#i-x"/></svg></button>
    </div>

    <nav class="thin-scroll flex-1 overflow-y-auto px-3 py-4">
        <template x-for="g in navGroups" :key="g.title">
            <div class="mb-5">
                <p class="mb-1.5 px-3 text-[11px] font-semibold uppercase tracking-wider text-gray-500" x-text="g.title"></p>
                <template x-for="m in g.items" :key="m.key">
                    <button type="button" :id="'nav-' + m.key" x-on:click="go(m.key)"
                            class="group mb-0.5 flex w-full items-center gap-3 rounded-lg px-3 py-2 text-left text-sm font-medium transition-colors"
                            :class="activeNav === m.key ? 'bg-blue-50 text-blue-700' : (locked(m.key) ? 'text-gray-500 hover:bg-gray-50' : 'text-gray-700 hover:bg-gray-100')">
                        <svg class="h-5 w-5 shrink-0" :class="activeNav === m.key ? 'text-blue-600' : 'text-gray-500'" aria-hidden="true"><use :href="'#i-' + m.icon"/></svg>
                        <span class="min-w-0 flex-1 truncate" x-text="m.label"></span>
                        <template x-if="locked(m.key)">
                            <span class="inline-flex shrink-0 items-center gap-0.5 rounded-full px-1.5 py-0.5 text-[10px] font-semibold"
                                  :class="m.plan === 'sekolah' ? 'bg-blue-100 text-blue-700' : 'bg-indigo-100 text-indigo-700'">
                                <svg class="h-3 w-3" aria-hidden="true"><use href="#i-lock"/></svg><span x-text="PLANS[m.plan].label"></span>
                            </span>
                        </template>
                    </button>
                </template>
            </div>
        </template>
    </nav>

    <div class="border-t border-gray-100 p-4">
        <div class="rounded-xl bg-gradient-to-br from-blue-50 to-teal-50 p-4 ring-1 ring-blue-100">
            <p class="text-xs text-gray-600">Pelan semasa</p>
            <p class="text-sm font-bold text-gray-900"><span x-text="PLANS[plan].label"></span> <span class="font-medium text-gray-600" x-text="PLANS[plan].price ? '· RM' + PLANS[plan].price + '/bulan' : '· RM0'"></span></p>
            <button type="button" x-show="plan !== 'sekolah' && role === 'gb'" x-on:click="go('langganan')" class="mt-3 inline-flex w-full items-center justify-center gap-1.5 rounded-lg bg-blue-600 px-3 py-2 text-xs font-semibold text-white hover:bg-blue-700">Naik Taraf</button>
            <a href="{{ route('register') }}" x-show="plan === 'sekolah' || role !== 'gb'" class="mt-3 inline-flex w-full items-center justify-center gap-1.5 rounded-lg bg-blue-600 px-3 py-2 text-xs font-semibold text-white hover:bg-blue-700">Daftar Percuma</a>
        </div>
    </div>
</aside>

<!-- =====================================================================
     KANDUNGAN UTAMA
     ===================================================================== -->
<div class="pt-demo lg:pl-64">
    <header class="no-print sticky top-demo z-20 flex h-16 items-center gap-3 border-b border-gray-200 bg-white/90 px-4 backdrop-blur sm:px-6 lg:px-8">
        <button type="button" class="inline-flex h-9 w-9 items-center justify-center rounded-lg text-gray-600 hover:bg-gray-100 lg:hidden" x-on:click="drawer = true" aria-label="Buka menu"><svg class="h-6 w-6" aria-hidden="true"><use href="#i-menu"/></svg></button>
        <div class="min-w-0 flex-1">
            <p class="truncate text-sm font-semibold text-gray-900 sm:text-base" x-text="pageTitle"></p>
            <p class="hidden truncate text-xs text-gray-500 sm:block">KAFA Al-Hidayah, Seri Manjung, Perak · Sesi 2026</p>
        </div>
        <span class="hidden rounded-full px-2.5 py-0.5 text-xs font-semibold sm:inline-flex"
              :class="role === 'gb' ? 'bg-blue-100 text-blue-700' : (role === 'guru' ? 'bg-indigo-100 text-indigo-700' : 'bg-teal-100 text-teal-700')" x-text="roleLabel"></span>
        <div class="flex items-center gap-2.5">
            <span class="flex h-9 w-9 items-center justify-center rounded-full bg-gray-900 text-xs font-bold text-white" x-text="user.initials" aria-hidden="true"></span>
            <div class="hidden leading-tight md:block">
                <p class="text-sm font-semibold text-gray-900" x-text="user.name"></p>
                <p class="text-xs text-gray-500" x-text="roleLabel"></p>
            </div>
        </div>
    </header>

    <main class="px-4 py-6 sm:px-6 lg:px-8">

<!-- =====================================================================
     DASHBOARD (semua peranan staf)
     ===================================================================== -->
<template x-if="page === 'dashboard'">
<section>
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-sm text-gray-500" x-text="fmtLong(TODAY)"></p>
            <h1 class="text-2xl font-bold tracking-tight text-gray-900" x-text="'Assalamualaikum, ' + user.name"></h1>
        </div>
        <div class="flex flex-wrap gap-2">
            <button type="button" x-on:click="go('kehadiran')" class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-5 py-2 text-sm font-medium text-white transition-colors hover:bg-blue-700"><svg class="h-4 w-4" aria-hidden="true"><use href="#i-check-circle"/></svg>Tanda Kehadiran</button>
        </div>
    </div>

    <div id="tour-stats" class="grid grid-cols-2 gap-4 xl:grid-cols-4">
        <div class="rounded-xl border border-gray-200 bg-white p-5">
            <div class="flex items-center justify-between"><p class="text-sm font-medium text-gray-500">Jumlah Murid</p><span class="flex h-9 w-9 items-center justify-center rounded-lg bg-blue-50 text-blue-600"><svg class="h-5 w-5" aria-hidden="true"><use href="#i-users"/></svg></span></div>
            <p class="mt-2 text-3xl font-bold text-gray-900" x-text="studentsAvail.length"></p>
            <p class="mt-1 text-xs text-gray-500" x-text="studentsAvail.filter(s => s.gender === 'L').length + ' lelaki · ' + studentsAvail.filter(s => s.gender === 'P').length + ' perempuan'"></p>
        </div>
        <div class="rounded-xl border border-blue-200 bg-blue-50/60 p-5">
            <div class="flex items-center justify-between"><p class="text-sm font-medium text-blue-700">Kehadiran Hari Ini</p><span class="flex h-9 w-9 items-center justify-center rounded-lg bg-blue-600 text-white"><svg class="h-5 w-5" aria-hidden="true"><use href="#i-check-circle"/></svg></span></div>
            <p class="mt-2 text-3xl font-bold text-blue-700" x-text="todayStats.pct + '%'"></p>
            <p class="mt-1 text-xs text-gray-600" x-text="(todayStats.h + todayStats.l) + ' / ' + todayStats.tot + ' hadir · ' + todayStats.t + ' tidak hadir'"></p>
        </div>
        <div class="rounded-xl border border-gray-200 bg-white p-5">
            <div class="flex items-center justify-between"><p class="text-sm font-medium text-gray-500">Kelas</p><span class="flex h-9 w-9 items-center justify-center rounded-lg bg-teal-50 text-teal-600"><svg class="h-5 w-5" aria-hidden="true"><use href="#i-school"/></svg></span></div>
            <p class="mt-2 text-3xl font-bold text-gray-900" x-text="classesAvail.length"></p>
            <p class="mt-1 text-xs text-gray-500" x-text="role === 'guru' ? 'Kelas yang anda ajar' : 'Tahun 1 – Tahun 5'"></p>
        </div>
        <div class="rounded-xl border border-gray-200 bg-white p-5">
            <template x-if="role === 'gb'">
                <div>
                    <div class="flex items-center justify-between"><p class="text-sm font-medium text-gray-500">Guru</p><span class="flex h-9 w-9 items-center justify-center rounded-lg bg-indigo-50 text-indigo-600"><svg class="h-5 w-5" aria-hidden="true"><use href="#i-user-plus"/></svg></span></div>
                    <p class="mt-2 text-3xl font-bold text-gray-900" x-text="teachers.filter(t => t.status === 'Aktif').length"></p>
                    <p class="mt-1 text-xs text-gray-500" x-text="rphPending.length + ' RPH menunggu semakan'"></p>
                </div>
            </template>
            <template x-if="role === 'guru'">
                <div>
                    <div class="flex items-center justify-between"><p class="text-sm font-medium text-gray-500">RPH Saya</p><span class="flex h-9 w-9 items-center justify-center rounded-lg bg-indigo-50 text-indigo-600"><svg class="h-5 w-5" aria-hidden="true"><use href="#i-doc"/></svg></span></div>
                    <p class="mt-2 text-3xl font-bold text-gray-900" x-text="rphs.filter(r => r.teacherId === 2).length"></p>
                    <p class="mt-1 text-xs text-gray-500" x-text="rphs.filter(r => r.teacherId === 2 && r.status === 'Diluluskan').length + ' diluluskan'"></p>
                </div>
            </template>
        </div>
    </div>

    <div class="mt-6 grid gap-6 xl:grid-cols-3">
        <div class="rounded-xl border border-gray-200 bg-white p-5 xl:col-span-2">
            <div class="flex items-center justify-between">
                <div><h2 class="font-semibold text-gray-900">Kehadiran 7 Hari Terakhir</h2><p class="text-xs text-gray-500">Peratus murid hadir (termasuk lewat)</p></div>
                <span class="rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-700" x-text="'Purata ' + Math.round(week7.reduce((a, d) => a + d.pct, 0) / 7) + '%'"></span>
            </div>
            <div class="mt-6 flex items-end gap-2 sm:gap-4" style="height:210px">
                <template x-for="d in week7" :key="d.iso">
                    <div class="flex h-full flex-1 flex-col items-center justify-end gap-2">
                        <span class="text-xs font-semibold text-gray-700" x-text="d.pct + '%'"></span>
                        <div class="flex w-full flex-1 items-end justify-center">
                            <div class="bar-grow w-full rounded-t-lg" style="max-width:52px" :class="d.iso === TODAY ? 'bg-blue-600' : 'bg-blue-200'" :style="'height:' + d.pct + '%'"></div>
                        </div>
                        <span class="text-xs" :class="d.iso === TODAY ? 'font-semibold text-blue-700' : 'text-gray-500'" x-text="d.label"></span>
                    </div>
                </template>
            </div>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-5">
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-gray-900">Hebahan Terkini</h2>
                <button type="button" x-show="!locked('hebahan')" x-on:click="go('hebahan')" class="text-xs font-semibold text-blue-700 hover:text-blue-800">Lihat semua</button>
            </div>
            <template x-if="!locked('hebahan')">
                <ul class="mt-4 space-y-3">
                    <template x-for="h in hebList.slice(0, 3)" :key="h.id">
                        <li class="rounded-lg border border-gray-100 p-3">
                            <div class="flex items-center justify-between gap-2">
                                <p class="truncate text-sm font-semibold text-gray-900" x-text="h.title"></p>
                                <span class="shrink-0 rounded-full bg-gray-100 px-2 py-0.5 text-[10px] font-semibold text-gray-600" x-text="TARGET[h.target]"></span>
                            </div>
                            <p class="mt-1 line-clamp-2 text-xs text-gray-600" x-text="h.body"></p>
                            <p class="mt-1.5 text-[11px] text-gray-500" x-text="fmtDate(h.date)"></p>
                        </li>
                    </template>
                </ul>
            </template>
            <template x-if="locked('hebahan')">
                <div class="mt-4 flex flex-col items-center rounded-lg border border-dashed border-gray-300 p-6 text-center">
                    <span class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-50 text-blue-600"><svg class="h-5 w-5" aria-hidden="true"><use href="#i-lock"/></svg></span>
                    <p class="mt-3 text-sm font-semibold text-gray-900">Hebahan Sekolah</p>
                    <p class="mt-1 text-xs text-gray-600">Hantar notis kepada guru dan ibu bapa — tersedia pada pelan Sekolah.</p>
                    <button type="button" x-on:click="openUpsell('hebahan')" class="mt-3 text-xs font-semibold text-blue-700 hover:text-blue-800">Ketahui lebih lanjut</button>
                </div>
            </template>
        </div>
    </div>

    <div class="mt-6 grid gap-6 xl:grid-cols-3">
        <div class="rounded-xl border border-gray-200 bg-white p-5 xl:col-span-2">
            <div><h2 class="font-semibold text-gray-900">Purata Markah Ikut Subjek</h2><p class="text-xs text-gray-500">Peperiksaan Akhir Tahun (PAT) 2026</p></div>
            <ul class="mt-5 space-y-3">
                <template x-for="(a, j) in subjAvg" :key="a.n">
                    <li class="flex items-center gap-3">
                        <span class="w-28 shrink-0 truncate text-sm text-gray-700 sm:w-36" x-text="a.n"></span>
                        <span class="h-2.5 flex-1 rounded-full bg-gray-100"><span class="bar-grow block h-2.5 rounded-full" :style="'width:' + a.avg + '%;background:' + SUBJ_COLORS[j].fg"></span></span>
                        <span class="w-10 shrink-0 text-right text-sm font-semibold text-gray-900" x-text="a.avg"></span>
                        <span class="w-7 shrink-0 rounded-full py-0.5 text-center text-[10px] font-bold" :class="gradeCls(grade(a.avg))" x-text="grade(a.avg)"></span>
                    </li>
                </template>
            </ul>
        </div>
        <div class="rounded-xl border border-gray-200 bg-white p-5">
            <h2 class="font-semibold text-gray-900">Tindakan Pantas</h2>
            <div class="mt-4 grid grid-cols-2 gap-3">
                <template x-for="qa in [
                    { k: 'kehadiran', l: 'Tanda Kehadiran', i: 'check-circle' },
                    { k: 'peperiksaan', l: 'Isi Markah', i: 'clipboard' },
                    { k: 'rph', l: 'Tulis RPH', i: 'doc' },
                    { k: role === 'gb' ? 'pengguna' : 'chatbot', l: role === 'gb' ? 'Jemput Guru' : 'Tanya AI', i: role === 'gb' ? 'user-plus' : 'sparkles' }
                ]" :key="qa.k">
                    <button type="button" x-on:click="go(qa.k)" class="relative flex flex-col items-center gap-2 rounded-xl border border-gray-200 p-4 text-center transition-colors hover:border-blue-300 hover:bg-blue-50/50">
                        <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-50 text-blue-600"><svg class="h-5 w-5" aria-hidden="true"><use :href="'#i-' + qa.i"/></svg></span>
                        <span class="text-xs font-semibold text-gray-800" x-text="qa.l"></span>
                        <svg x-show="locked(qa.k)" class="absolute right-2 top-2 h-3.5 w-3.5 text-gray-500" aria-hidden="true"><use href="#i-lock"/></svg>
                    </button>
                </template>
            </div>
        </div>
    </div>
</section>
</template>

<!-- =====================================================================
     KELAS (Percuma)
     ===================================================================== -->
<template x-if="page === 'kelas'">
<section>
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div><h1 class="text-2xl font-bold tracking-tight text-gray-900">Kelas</h1><p class="mt-1 text-sm text-gray-600">Senarai kelas sesi 2026 dan guru kelas masing-masing.</p></div>
        <button type="button" x-show="role === 'gb'" x-on:click="openKelas()" class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-5 py-2 text-sm font-medium text-white transition-colors hover:bg-blue-700"><svg class="h-4 w-4" aria-hidden="true"><use href="#i-plus"/></svg>Tambah Kelas</button>
    </div>

    <div x-show="plan === 'free'" class="mb-5 flex flex-col gap-3 rounded-xl border border-amber-200 bg-amber-50 p-4 text-sm text-amber-900 sm:flex-row sm:items-center">
        <svg class="h-5 w-5 shrink-0 text-amber-600" aria-hidden="true"><use href="#i-warn"/></svg>
        <p class="flex-1"><span class="font-semibold">Had pelan Percuma:</span> 3 kelas × 40 murid sekelas. Kelas ke-4 dan seterusnya dikunci sehingga anda naik taraf.</p>
        <button type="button" x-on:click="go('langganan')" class="shrink-0 font-semibold text-amber-900 underline underline-offset-2">Naik Taraf</button>
    </div>

    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-left text-xs uppercase text-gray-500">
                    <tr><th class="px-4 py-3">No</th><th class="px-4 py-3">Nama Kelas</th><th class="px-4 py-3">Tahun</th><th class="px-4 py-3">Guru Kelas</th><th class="px-4 py-3">Bil. Murid</th><th class="px-4 py-3">Status</th><th class="px-4 py-3">Tindakan</th></tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <template x-for="(c, i) in classes.filter(c => myClassIds.includes(c.id))" :key="c.id">
                        <tr class="hover:bg-gray-50" :class="overLimit(c) ? 'opacity-60' : ''" :id="'row-' + c.id">
                            <td class="px-4 py-3 text-gray-500" x-text="i + 1"></td>
                            <td class="px-4 py-3 font-medium text-gray-900" x-text="c.name"></td>
                            <td class="px-4 py-3 text-gray-700" x-text="'Tahun ' + c.year"></td>
                            <td class="px-4 py-3 text-gray-700" x-text="tName(c.teacherId)"></td>
                            <td class="px-4 py-3 text-gray-700"><span x-text="classCount(c.id)"></span><span class="text-gray-500" x-show="plan === 'free'"> / 40</span></td>
                            <td class="px-4 py-3">
                                <span x-show="!overLimit(c)" class="rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-700">Aktif</span>
                                <span x-show="overLimit(c)" class="inline-flex items-center gap-1 rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-700"><svg class="h-3 w-3" aria-hidden="true"><use href="#i-lock"/></svg>Melebihi had</span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-1">
                                    <button type="button" title="Lihat murid" aria-label="Lihat murid" x-on:click="overLimit(c) ? openUpsell(null, limitUpsell) : (fClass = c.id, q = '', pg.murid = 1, go('murid'))" class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-gray-500 hover:bg-blue-50 hover:text-blue-600"><svg class="h-4 w-4" aria-hidden="true"><use href="#i-eye"/></svg></button>
                                    <button type="button" x-show="role === 'gb'" title="Edit" aria-label="Edit" x-on:click="openKelas(c)" class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-gray-500 hover:bg-amber-50 hover:text-amber-600"><svg class="h-4 w-4" aria-hidden="true"><use href="#i-pencil"/></svg></button>
                                    <button type="button" x-show="role === 'gb'" title="Padam" aria-label="Padam" x-on:click="askDelete('kelas', c.id, c.name)" class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-gray-500 hover:bg-red-50 hover:text-red-600"><svg class="h-4 w-4" aria-hidden="true"><use href="#i-trash"/></svg></button>
                                </div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>
</section>
</template>

<!-- =====================================================================
     MURID (Percuma)
     ===================================================================== -->
<template x-if="page === 'murid'">
<section>
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div><h1 class="text-2xl font-bold tracking-tight text-gray-900">Murid</h1><p class="mt-1 text-sm text-gray-600">Cari, tapis dan lihat profil setiap murid.</p></div>
        <div class="flex flex-wrap gap-2">
            <button type="button" x-on:click="go('import_murid')" class="inline-flex items-center gap-2 rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-600 transition-colors hover:bg-gray-50"><svg class="h-4 w-4" aria-hidden="true"><use href="#i-upload"/></svg>Import Excel<svg x-show="locked('import_murid')" class="h-3.5 w-3.5 text-gray-500" aria-hidden="true"><use href="#i-lock"/></svg></button>
            <button type="button" x-on:click="openMurid()" class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-5 py-2 text-sm font-medium text-white transition-colors hover:bg-blue-700"><svg class="h-4 w-4" aria-hidden="true"><use href="#i-plus"/></svg>Tambah Murid</button>
        </div>
    </div>

    <div class="mb-4 flex flex-col gap-3 sm:flex-row">
        <div class="relative flex-1">
            <svg class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-500" aria-hidden="true"><use href="#i-search"/></svg>
            <input type="search" x-model="q" x-on:input="pg.murid = 1" placeholder="Cari nama, No. MyKid atau penjaga…" class="f-input" style="padding-left:2.25rem" aria-label="Cari murid">
        </div>
        <select x-model.number="fClass" x-on:change="pg.murid = 1" class="f-input sm:w-60" aria-label="Tapis kelas">
            <option value="0">Semua kelas</option>
            <template x-for="c in classesAvail" :key="c.id"><option :value="c.id" x-text="c.name"></option></template>
        </select>
    </div>

    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-left text-xs uppercase text-gray-500">
                    <tr><th class="px-4 py-3">No</th><th class="px-4 py-3">Nama Murid</th><th class="px-4 py-3">No. MyKid</th><th class="px-4 py-3">Jantina</th><th class="px-4 py-3">Kelas</th><th class="px-4 py-3">Penjaga</th><th class="px-4 py-3">Tindakan</th></tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <template x-for="(s, i) in paged(muridList, 'murid')" :key="s.id">
                        <tr class="hover:bg-gray-50" :id="'row-' + s.id">
                            <td class="px-4 py-3 text-gray-500" x-text="rowNo('murid', i)"></td>
                            <td class="px-4 py-3">
                                <button type="button" x-on:click="openProfil(s.id)" class="flex items-center gap-3 text-left">
                                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full text-[11px] font-bold" :class="s.gender === 'L' ? 'bg-blue-100 text-blue-700' : 'bg-pink-100 text-pink-700'" x-text="initials(s.name)"></span>
                                    <span class="font-medium text-gray-900 hover:text-blue-700" x-text="s.name"></span>
                                </button>
                            </td>
                            <td class="whitespace-nowrap px-4 py-3 font-mono text-xs text-gray-700" x-text="s.mykid"></td>
                            <td class="px-4 py-3 text-gray-700" x-text="s.gender === 'L' ? 'Lelaki' : 'Perempuan'"></td>
                            <td class="whitespace-nowrap px-4 py-3 text-gray-700" x-text="cls(s.classId).name"></td>
                            <td class="whitespace-nowrap px-4 py-3 text-gray-700" x-text="s.guardian"></td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-1">
                                    <button type="button" title="Lihat" aria-label="Lihat profil" x-on:click="openProfil(s.id)" class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-gray-500 hover:bg-blue-50 hover:text-blue-600"><svg class="h-4 w-4" aria-hidden="true"><use href="#i-eye"/></svg></button>
                                    <button type="button" title="Edit" aria-label="Edit" x-on:click="openMurid(s)" class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-gray-500 hover:bg-amber-50 hover:text-amber-600"><svg class="h-4 w-4" aria-hidden="true"><use href="#i-pencil"/></svg></button>
                                    <button type="button" title="Padam" aria-label="Padam" x-on:click="askDelete('murid', s.id, s.name)" class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-gray-500 hover:bg-red-50 hover:text-red-600"><svg class="h-4 w-4" aria-hidden="true"><use href="#i-trash"/></svg></button>
                                </div>
                            </td>
                        </tr>
                    </template>
                    <tr x-show="muridList.length === 0"><td colspan="7" class="px-4 py-10 text-center text-sm text-gray-500">Tiada murid ditemui.</td></tr>
                </tbody>
            </table>
        </div>
        <!-- Paginasi (gaya Flowbite) -->
        <div class="flex flex-col items-center justify-between gap-3 border-t border-gray-200 px-4 py-3 sm:flex-row">
            <p class="text-sm text-gray-600">Paparan <span class="font-semibold text-gray-900" x-text="pgFrom(muridList, 'murid')"></span>–<span class="font-semibold text-gray-900" x-text="pgTo(muridList, 'murid')"></span> daripada <span class="font-semibold text-gray-900" x-text="muridList.length"></span></p>
            <nav aria-label="Navigasi halaman"><ul class="inline-flex -space-x-px text-sm">
                <li><button type="button" x-on:click="pg.murid = Math.max(1, pg.murid - 1)" :disabled="pg.murid <= 1" class="flex h-8 items-center justify-center rounded-s-lg border border-gray-300 bg-white px-3 text-gray-500 hover:bg-gray-100 hover:text-gray-700 disabled:opacity-50">Sebelum</button></li>
                <template x-for="n in pageNums(muridList, 'murid')" :key="n"><li><button type="button" x-on:click="pg.murid = n" class="flex h-8 items-center justify-center border border-gray-300 px-3" :class="pg.murid === n ? 'bg-blue-50 font-semibold text-blue-600' : 'bg-white text-gray-500 hover:bg-gray-100 hover:text-gray-700'" x-text="n"></button></li></template>
                <li><button type="button" x-on:click="pg.murid = Math.min(pageCount(muridList), pg.murid + 1)" :disabled="pg.murid >= pageCount(muridList)" class="flex h-8 items-center justify-center rounded-e-lg border border-gray-300 bg-white px-3 text-gray-500 hover:bg-gray-100 hover:text-gray-700 disabled:opacity-50">Seterusnya</button></li>
            </ul></nav>
        </div>
    </div>
</section>
</template>

<!-- =====================================================================
     PROFIL MURID
     ===================================================================== -->
<template x-if="page === 'profil' && profil">
<section>
    <button type="button" x-on:click="go('murid')" class="mb-5 inline-flex items-center gap-2 rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-600 transition-colors hover:bg-gray-50"><svg class="h-4 w-4" aria-hidden="true"><use href="#i-arrow-left"/></svg>Kembali</button>

    <div class="rounded-xl border border-gray-200 bg-white p-5 sm:p-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
            <span class="flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl text-xl font-bold" :class="profil.gender === 'L' ? 'bg-blue-100 text-blue-700' : 'bg-pink-100 text-pink-700'" x-text="initials(profil.name)"></span>
            <div class="flex-1">
                <h1 class="text-xl font-bold text-gray-900" x-text="profil.name"></h1>
                <p class="text-sm text-gray-600" x-text="cls(profil.classId).name + ' · No. MyKid ' + profil.mykid"></p>
            </div>
            <div class="flex gap-2">
                <button type="button" x-on:click="openMurid(profil)" class="inline-flex items-center gap-2 rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50"><svg class="h-4 w-4" aria-hidden="true"><use href="#i-pencil"/></svg>Edit</button>
                <button type="button" x-on:click="lm.classId = profil.classId; lm.sid = profil.id; go('laporan_murid')" class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700"><svg class="h-4 w-4" aria-hidden="true"><use href="#i-printer"/></svg>Laporan</button>
            </div>
        </div>
    </div>

    <div class="mt-6 grid gap-6 lg:grid-cols-3">
        <div class="rounded-xl border border-gray-200 bg-white p-5">
            <h2 class="font-semibold text-gray-900">Maklumat Murid</h2>
            <dl class="mt-4 space-y-3 text-sm">
                <div class="flex justify-between gap-3"><dt class="text-gray-500">Jantina</dt><dd class="font-medium text-gray-900" x-text="profil.gender === 'L' ? 'Lelaki' : 'Perempuan'"></dd></div>
                <div class="flex justify-between gap-3"><dt class="text-gray-500">Tarikh Lahir</dt><dd class="font-medium text-gray-900" x-text="dob(profil.mykid)"></dd></div>
                <div class="flex justify-between gap-3"><dt class="text-gray-500">Kelas</dt><dd class="text-right font-medium text-gray-900" x-text="cls(profil.classId).name"></dd></div>
                <div class="flex justify-between gap-3"><dt class="text-gray-500">Guru Kelas</dt><dd class="text-right font-medium text-gray-900" x-text="tName(cls(profil.classId).teacherId)"></dd></div>
            </dl>
            <h2 class="mt-6 font-semibold text-gray-900">Penjaga</h2>
            <dl class="mt-4 space-y-3 text-sm">
                <div class="flex justify-between gap-3"><dt class="text-gray-500">Nama</dt><dd class="text-right font-medium text-gray-900" x-text="profil.guardian"></dd></div>
                <div class="flex justify-between gap-3"><dt class="text-gray-500">No. Telefon</dt><dd class="font-medium text-gray-900" x-text="profil.phone"></dd></div>
            </dl>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-5">
            <h2 class="font-semibold text-gray-900">Kehadiran (20 hari terakhir)</h2>
            <div class="mt-4 flex items-center gap-5" x-data="{ a: null }" x-effect="a = stuAtt(profil, 20)">
                <svg viewBox="0 0 80 80" class="h-24 w-24 shrink-0 -rotate-90" aria-hidden="true">
                    <circle cx="40" cy="40" r="34" fill="none" stroke="#E5E7EB" stroke-width="8"/>
                    <circle class="ring-draw" cx="40" cy="40" r="34" fill="none" stroke="#10B981" stroke-width="8" stroke-linecap="round" stroke-dasharray="213.6" :stroke-dashoffset="213.6 - 213.6 * (a ? a.pct : 0) / 100"/>
                </svg>
                <div>
                    <p class="text-3xl font-bold text-gray-900" x-text="(a ? a.pct : 0) + '%'"></p>
                    <ul class="mt-2 space-y-1 text-xs text-gray-600">
                        <li x-text="'Hadir: ' + (a ? a.h : 0)"></li><li x-text="'Lewat: ' + (a ? a.l : 0)"></li><li x-text="'Tidak hadir: ' + (a ? a.t : 0)"></li><li x-text="'Cuti: ' + (a ? a.c : 0)"></li>
                    </ul>
                </div>
            </div>
            <h2 class="mt-6 font-semibold text-gray-900">Pencapaian</h2>
            <dl class="mt-3 space-y-2 text-sm" x-show="achv[profil.id]">
                <div class="flex justify-between gap-3"><dt class="text-gray-500">Hafazan terkini</dt><dd class="text-right font-medium text-gray-900" x-text="achv[profil.id] ? 'Surah ' + SURAH[achv[profil.id].haf] : ''"></dd></div>
                <div class="flex justify-between gap-3"><dt class="text-gray-500">Bacaan</dt><dd class="font-medium text-gray-900" x-text="achv[profil.id] ? BACAAN[achv[profil.id].bac] : ''"></dd></div>
                <div class="flex justify-between gap-3"><dt class="text-gray-500">Tahap Jawi</dt><dd class="font-medium text-gray-900" x-text="achv[profil.id] ? JAWI_LV[achv[profil.id].jawi] : ''"></dd></div>
            </dl>
        </div>

        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white">
            <div class="border-b border-gray-100 p-5"><h2 class="font-semibold text-gray-900">Markah Peperiksaan</h2></div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-left text-xs uppercase text-gray-500"><tr><th class="px-4 py-2.5">No</th><th class="px-4 py-2.5">Subjek</th><th class="px-3 py-2.5">PPT</th><th class="px-3 py-2.5">PAT</th><th class="px-3 py-2.5">Gred</th></tr></thead>
                    <tbody class="divide-y divide-gray-100">
                        <template x-for="(n, j) in SUBJECTS" :key="n">
                            <tr>
                                <td class="px-4 py-2.5 text-gray-500" x-text="j + 1"></td>
                                <td class="px-4 py-2.5 text-gray-900" x-text="n"></td>
                                <td class="px-3 py-2.5 text-gray-700" x-text="markOf('ppt', profilId, j)"></td>
                                <td class="px-3 py-2.5 font-semibold text-gray-900" x-text="markOf('pat', profilId, j)"></td>
                                <td class="px-3 py-2.5"><span class="rounded-full px-2 py-0.5 text-xs font-semibold" :class="gradeCls(gradeOf('pat', profilId, j))" x-text="gradeOf('pat', profilId, j)"></span></td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
</template>

<!-- =====================================================================
     KEHADIRAN HARIAN (Percuma)
     ===================================================================== -->
<template x-if="page === 'kehadiran'">
<section x-effect="ensureAtt(attClass, attDate)">
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div><h1 class="text-2xl font-bold tracking-tight text-gray-900">Kehadiran Harian</h1><p class="mt-1 text-sm text-gray-600">Pilih kelas dan tarikh, kemudian tanda status setiap murid.</p></div>
        <div class="flex flex-wrap gap-2">
            <button type="button" x-on:click="go('kehadiran_qr')" class="inline-flex items-center gap-2 rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-600 transition-colors hover:bg-gray-50"><svg class="h-4 w-4" aria-hidden="true"><use href="#i-qr"/></svg>Mod Kiosk QR<svg x-show="locked('kehadiran_qr')" class="h-3.5 w-3.5 text-gray-500" aria-hidden="true"><use href="#i-lock"/></svg></button>
            <button type="button" x-on:click="markAllPresent()" class="inline-flex items-center gap-2 rounded-lg border border-green-200 bg-green-50 px-4 py-2 text-sm font-medium text-green-700 transition-colors hover:bg-green-100"><svg class="h-4 w-4" aria-hidden="true"><use href="#i-check"/></svg>Tanda Semua Hadir</button>
            <button type="button" x-on:click="saved()" class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-5 py-2 text-sm font-medium text-white transition-colors hover:bg-blue-700">Simpan</button>
        </div>
    </div>

    <div class="mb-5 grid gap-4 lg:grid-cols-3">
        <div class="grid grid-cols-2 gap-3 rounded-xl border border-gray-200 bg-white p-4 lg:col-span-1">
            <div><label class="f-label" for="att-class">Kelas</label>
                <select id="att-class" x-model.number="attClass" class="f-input"><template x-for="c in classesAvail" :key="c.id"><option :value="c.id" x-text="c.name"></option></template></select></div>
            <div><label class="f-label" for="att-date">Tarikh</label>
                <input id="att-date" type="date" x-model="attDate" :max="TODAY" x-on:change="if(!attDate) attDate = TODAY" class="f-input"></div>
        </div>
        <div class="grid grid-cols-2 gap-3 sm:grid-cols-5 lg:col-span-2">
            <div class="rounded-xl border border-blue-200 bg-blue-50 p-4"><p class="text-xs font-medium text-blue-700">Kehadiran</p><p class="mt-1 text-2xl font-bold text-blue-700" x-text="attSummary.pct + '%'"></p></div>
            <div class="rounded-xl border border-gray-200 bg-white p-4"><p class="text-xs font-medium text-gray-500">Hadir</p><p class="mt-1 text-2xl font-bold text-green-700" x-text="attSummary.h"></p></div>
            <div class="rounded-xl border border-gray-200 bg-white p-4"><p class="text-xs font-medium text-gray-500">Lewat</p><p class="mt-1 text-2xl font-bold text-amber-600" x-text="attSummary.l"></p></div>
            <div class="rounded-xl border border-gray-200 bg-white p-4"><p class="text-xs font-medium text-gray-500">Tidak Hadir</p><p class="mt-1 text-2xl font-bold text-red-600" x-text="attSummary.t"></p></div>
            <div class="rounded-xl border border-gray-200 bg-white p-4"><p class="text-xs font-medium text-gray-500">Cuti</p><p class="mt-1 text-2xl font-bold text-gray-700" x-text="attSummary.c"></p></div>
        </div>
    </div>

    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-left text-xs uppercase text-gray-500"><tr><th class="px-4 py-3">No</th><th class="px-4 py-3">Nama Murid</th><th class="px-4 py-3">Status</th></tr></thead>
                <tbody class="divide-y divide-gray-100">
                    <template x-for="(s, i) in attRows" :key="s.id">
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2.5 text-gray-500" x-text="i + 1"></td>
                            <td class="whitespace-nowrap px-4 py-2.5 font-medium text-gray-900" x-text="s.name"></td>
                            <td class="px-4 py-2.5">
                                <div class="flex flex-wrap gap-1.5" role="radiogroup" :aria-label="'Status ' + s.name">
                                    <template x-for="st in STATUS" :key="st.k">
                                        <label class="cursor-pointer">
                                            <input type="radio" class="peer sr-only" :name="'att-' + s.id" :value="st.k" x-model="att[attKey][s.id]">
                                            <span class="flex h-8 items-center justify-center rounded-lg border px-2.5 text-xs font-semibold transition-colors peer-focus-visible:ring-2 peer-focus-visible:ring-blue-500"
                                                  :class="att[attKey] && att[attKey][s.id] === st.k ? st.on : 'border-gray-300 text-gray-600 hover:bg-gray-50'" x-text="st.label"></span>
                                        </label>
                                    </template>
                                </div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>
</section>
</template>

<!-- =====================================================================
     JADUAL WAKTU (Percuma)
     ===================================================================== -->
<template x-if="page === 'jadual_waktu'">
<section>
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div><h1 class="text-2xl font-bold tracking-tight text-gray-900">Jadual Waktu</h1><p class="mt-1 text-sm text-gray-600">Klik mana-mana slot untuk tukar subjek.</p></div>
        <select x-model.number="ttClass" class="f-input sm:w-64" aria-label="Pilih kelas"><template x-for="c in classesAvail" :key="c.id"><option :value="c.id" x-text="c.name"></option></template></select>
    </div>
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white">
        <div class="overflow-x-auto">
            <table class="w-full text-sm" style="min-width:720px">
                <thead class="bg-gray-50 text-left text-xs uppercase text-gray-500">
                    <tr><th class="w-32 px-4 py-3">Masa</th><template x-for="d in DAYS" :key="d"><th class="px-3 py-3" x-text="d"></th></template></tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <template x-for="sl in SLOTS" :key="sl.t">
                        <tr>
                            <td class="whitespace-nowrap px-4 py-3 text-xs font-semibold text-gray-600" x-text="sl.t"></td>
                            <template x-if="sl.i < 0">
                                <td colspan="5" class="bg-gray-50 px-3 py-2 text-center text-xs font-semibold uppercase tracking-widest text-gray-500">Rehat</td>
                            </template>
                            <template x-for="(d, di) in (sl.i < 0 ? [] : DAYS)" :key="d">
                                <td class="p-1.5">
                                    <button type="button" x-on:click="openSlot(di, sl.i)" class="w-full rounded-lg px-3 py-2.5 text-left transition-transform hover:-translate-y-0.5"
                                            :style="'background:' + SUBJ_COLORS[ttSubj(ttClass, di, sl.i)].bg + ';color:' + SUBJ_COLORS[ttSubj(ttClass, di, sl.i)].fg">
                                        <span class="block text-xs font-bold" x-text="SUBJECTS[ttSubj(ttClass, di, sl.i)]"></span>
                                        <span class="block text-[11px] opacity-80" x-text="tName(cls(ttClass).teacherId)"></span>
                                    </button>
                                </td>
                            </template>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4 flex flex-wrap gap-2">
        <template x-for="(n, j) in SUBJECTS" :key="n"><span class="rounded-full px-2.5 py-0.5 text-xs font-semibold" :style="'background:' + SUBJ_COLORS[j].bg + ';color:' + SUBJ_COLORS[j].fg" x-text="n"></span></template>
    </div>
</section>
</template>

<!-- =====================================================================
     PEPERIKSAAN & MARKAH (Percuma)
     ===================================================================== -->
<template x-if="page === 'peperiksaan'">
<section>
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div><h1 class="text-2xl font-bold tracking-tight text-gray-900">Peperiksaan &amp; Markah</h1><p class="mt-1 text-sm text-gray-600">Isi markah — jumlah, purata, gred dan kedudukan dikira automatik.</p></div>
        <button type="button" x-on:click="saved()" class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-5 py-2 text-sm font-medium text-white transition-colors hover:bg-blue-700">Simpan Markah</button>
    </div>

    <div class="mb-5 grid gap-4 lg:grid-cols-3">
        <div class="lg:col-span-2">
            <div class="grid gap-3 sm:grid-cols-2">
                <template x-for="e in exams" :key="e.id">
                    <button type="button" x-on:click="examId = e.id" class="rounded-xl border p-4 text-left transition-colors" :class="examId === e.id ? 'border-blue-600 bg-blue-50 ring-1 ring-blue-600' : 'border-gray-200 bg-white hover:bg-gray-50'">
                        <p class="text-sm font-semibold text-gray-900" x-text="e.name"></p>
                        <p class="mt-0.5 text-xs text-gray-500" x-text="'Tarikh: ' + fmtDate(e.date)"></p>
                    </button>
                </template>
            </div>
        </div>
        <div class="rounded-xl border border-gray-200 bg-white p-4">
            <label class="f-label" for="ex-class">Kelas</label>
            <select id="ex-class" x-model.number="examClass" class="f-input"><template x-for="c in classesAvail" :key="c.id"><option :value="c.id" x-text="c.name"></option></template></select>
            <p class="mt-3 text-xs text-gray-500">Gred: A ≥ 80 · B ≥ 65 · C ≥ 50 · D ≥ 40 · E &lt; 40</p>
        </div>
    </div>

    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-left text-xs uppercase text-gray-500">
                    <tr>
                        <th class="px-3 py-3">No</th><th class="px-3 py-3">Nama Murid</th>
                        <template x-for="(sh, j) in SUBJ_SHORT" :key="sh"><th class="px-1.5 py-3 text-center" :title="SUBJECTS[j]" x-text="sh"></th></template>
                        <th class="px-3 py-3 text-center">Jumlah</th><th class="px-3 py-3 text-center">Purata</th><th class="px-3 py-3 text-center">Gred</th><th class="px-3 py-3 text-center">Kedudukan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <template x-for="(row, i) in examRows" :key="row.s.id">
                        <tr class="hover:bg-gray-50">
                            <td class="px-3 py-2 text-gray-500" x-text="i + 1"></td>
                            <td class="whitespace-nowrap px-3 py-2 font-medium text-gray-900" x-text="row.s.name"></td>
                            <template x-for="(sh, j) in SUBJ_SHORT" :key="sh">
                                <td class="px-1.5 py-2 text-center">
                                    <input type="number" min="0" max="100" inputmode="numeric" class="f-mark" :aria-label="SUBJECTS[j] + ' — ' + row.s.name"
                                           x-model.number="marks[examId][row.s.id][j]" x-on:blur="clampMark(row.s.id, j)">
                                </td>
                            </template>
                            <td class="px-3 py-2 text-center font-semibold text-gray-900" x-text="row.total"></td>
                            <td class="px-3 py-2 text-center text-gray-700" x-text="row.complete ? row.avg.toFixed(1) : '—'"></td>
                            <td class="px-3 py-2 text-center"><span class="rounded-full px-2.5 py-0.5 text-xs font-bold" :class="row.complete ? gradeCls(grade(row.avg)) : 'bg-gray-100 text-gray-500'" x-text="row.complete ? grade(row.avg) : '—'"></span></td>
                            <td class="px-3 py-2 text-center">
                                <span class="inline-flex h-7 min-w-[1.75rem] items-center justify-center rounded-full px-1.5 text-xs font-bold" :class="row.rank <= 3 ? 'bg-amber-100 text-amber-800' : 'text-gray-700'" x-text="row.rank"></span>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>
</section>
</template>

<!-- =====================================================================
     KEHADIRAN QR / KIOSK (Personal)
     ===================================================================== -->
<template x-if="page === 'kehadiran_qr'">
<section>
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div><h1 class="text-2xl font-bold tracking-tight text-gray-900">Kehadiran QR / Kiosk</h1><p class="mt-1 text-sm text-gray-600">Murid imbas kad QR sendiri — kehadiran direkod automatik dengan masa tiba.</p></div>
        <button type="button" x-on:click="openKiosk()" class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-5 py-2 text-sm font-medium text-white transition-colors hover:bg-blue-700"><svg class="h-4 w-4" aria-hidden="true"><use href="#i-qr"/></svg>Buka Mod Kiosk</button>
    </div>

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="relative overflow-hidden rounded-xl bg-slate-900 p-6 text-white lg:col-span-1">
            <div class="pattern-star-light pointer-events-none absolute inset-0" style="opacity:.06" aria-hidden="true"></div>
            <div class="relative">
                <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-white/10 text-teal-300"><svg class="h-6 w-6" aria-hidden="true"><use href="#i-qr"/></svg></span>
                <h2 class="mt-4 text-lg font-bold">Jadikan tablet sebagai kiosk</h2>
                <p class="mt-2 text-sm text-slate-300">Letak telefon atau tablet di pintu kelas. Murid halakan kad QR ke kamera — nama terus ditanda hadir.</p>
                <label class="mt-5 block text-xs font-semibold text-slate-300" for="kiosk-class">Kelas kiosk</label>
                <select id="kiosk-class" x-model.number="kiosk.classId" class="mt-1.5 w-full rounded-lg border border-white/20 bg-white/10 px-3 py-2 text-sm text-white focus:outline-none focus:ring-2 focus:ring-teal-400">
                    <template x-for="c in classesAvail" :key="c.id"><option class="text-gray-900" :value="c.id" x-text="c.name"></option></template>
                </select>
                <button type="button" x-on:click="openKiosk()" class="mt-4 inline-flex w-full items-center justify-center gap-2 rounded-lg bg-teal-500 px-4 py-2.5 text-sm font-semibold text-slate-950 hover:bg-teal-400">Mula Kiosk Skrin Penuh</button>
            </div>
        </div>
        <div class="rounded-xl border border-gray-200 bg-white p-5 lg:col-span-2">
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-gray-900">Kad QR Murid</h2>
                <button type="button" x-on:click="toast('Kad QR dijana sebagai PDF — pratonton sahaja dalam demo', 'info')" class="inline-flex items-center gap-2 rounded-lg border border-gray-200 bg-white px-3 py-1.5 text-xs font-medium text-gray-600 hover:bg-gray-50"><svg class="h-4 w-4" aria-hidden="true"><use href="#i-printer"/></svg>Cetak Kad QR</button>
            </div>
            <div class="mt-4 grid grid-cols-2 gap-3 sm:grid-cols-3">
                <template x-for="s in students.filter(s => s.classId === kiosk.classId).slice(0, 6)" :key="s.id">
                    <div class="rounded-xl border border-gray-200 p-3 text-center">
                        <div class="mx-auto h-24 w-24" x-html="qrSvg('murid-' + s.id)"></div>
                        <p class="mt-2 truncate text-xs font-semibold text-gray-900" x-text="s.name"></p>
                        <p class="text-[10px] text-gray-500" x-text="cls(s.classId).name"></p>
                    </div>
                </template>
            </div>
        </div>
    </div>
</section>
</template>

<!-- =====================================================================
     IMPORT MURID — EXCEL (Personal)
     ===================================================================== -->
<template x-if="page === 'import_murid'">
<section>
    <div class="mb-6"><h1 class="text-2xl font-bold tracking-tight text-gray-900">Import Murid (Excel)</h1><p class="mt-1 text-sm text-gray-600">Muat naik senarai murid dalam fail .xlsx — termasuk eksport dari SIMPENI.</p></div>

    <ol class="mb-6 flex items-center gap-2 text-xs font-semibold sm:gap-4">
        <template x-for="(lbl, k) in ['Muat naik fail', 'Semak pratonton', 'Selesai']" :key="k">
            <li class="flex items-center gap-2">
                <span class="flex h-7 w-7 items-center justify-center rounded-full" :class="imp.step >= k ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-600'" x-text="k + 1"></span>
                <span class="hidden sm:inline" :class="imp.step >= k ? 'text-gray-900' : 'text-gray-500'" x-text="lbl"></span>
                <span x-show="k < 2" class="h-px w-6 bg-gray-300 sm:w-10"></span>
            </li>
        </template>
    </ol>

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="rounded-xl border border-gray-200 bg-white p-5 lg:col-span-2">
            <template x-if="imp.step === 0">
                <div x-data="{ over: false }">
                    <label class="flex cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-dashed px-6 py-12 text-center transition-colors"
                           :class="over ? 'border-blue-500 bg-blue-50' : 'border-gray-300 bg-gray-50 hover:bg-gray-100'"
                           x-on:dragover.prevent="over = true" x-on:dragleave.prevent="over = false" x-on:drop.prevent="over = false; impFile($event.dataTransfer.files[0])">
                        <span class="flex h-12 w-12 items-center justify-center rounded-full bg-white text-blue-600 shadow-sm"><svg class="h-6 w-6" aria-hidden="true"><use href="#i-upload"/></svg></span>
                        <p class="mt-4 text-sm font-semibold text-gray-900">Seret &amp; lepas fail di sini, atau <span class="text-blue-700 underline">pilih fail</span></p>
                        <p class="mt-1 text-xs text-gray-500">Format .xlsx sahaja · maksimum 2MB</p>
                        <input type="file" accept=".xlsx,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" class="sr-only" x-on:change="impFile($event.target.files[0])">
                    </label>
                    <div class="mt-4 flex flex-wrap items-center justify-between gap-3">
                        <p class="text-xs text-gray-500">Tiada fail? Cuba dengan fail contoh.</p>
                        <button type="button" x-on:click="impSample()" class="inline-flex items-center gap-2 rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50">Guna Fail Contoh</button>
                    </div>
                </div>
            </template>
            <template x-if="imp.step === 1">
                <div>
                    <div class="flex flex-wrap items-center justify-between gap-3">
                        <p class="flex items-center gap-2 text-sm font-semibold text-gray-900"><svg class="h-5 w-5 text-green-600" aria-hidden="true"><use href="#i-doc-check"/></svg><span x-text="imp.file"></span></p>
                        <span class="rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-700">5 baris sah</span>
                    </div>
                    <div class="mt-4 overflow-hidden rounded-xl border border-gray-200">
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead class="bg-gray-50 text-left text-xs uppercase text-gray-500"><tr><th class="px-4 py-2.5">No</th><th class="px-4 py-2.5">Nama Murid</th><th class="px-4 py-2.5">No. MyKid</th><th class="px-4 py-2.5">Jantina</th><th class="px-4 py-2.5">Penjaga</th></tr></thead>
                                <tbody class="divide-y divide-gray-100">
                                    <template x-for="(r, i) in IMP_ROWS" :key="r.mykid">
                                        <tr><td class="px-4 py-2.5 text-gray-500" x-text="i + 1"></td><td class="whitespace-nowrap px-4 py-2.5 font-medium text-gray-900" x-text="r.name"></td><td class="px-4 py-2.5 font-mono text-xs text-gray-700" x-text="r.mykid"></td><td class="px-4 py-2.5 text-gray-700" x-text="r.gender === 'L' ? 'Lelaki' : 'Perempuan'"></td><td class="whitespace-nowrap px-4 py-2.5 text-gray-700" x-text="r.guardian"></td></tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="mt-4 grid gap-3 sm:grid-cols-2 sm:items-end">
                        <div><label class="f-label" for="imp-class">Masukkan ke kelas</label>
                            <select id="imp-class" x-model.number="imp.classId" class="f-input"><template x-for="c in classesAvail" :key="c.id"><option :value="c.id" x-text="c.name"></option></template></select></div>
                        <div class="flex gap-2 sm:justify-end">
                            <button type="button" x-on:click="imp.step = 0" class="inline-flex items-center gap-2 rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50">Batal</button>
                            <button type="button" x-on:click="doImport()" class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-5 py-2 text-sm font-medium text-white hover:bg-blue-700"><svg class="h-4 w-4" aria-hidden="true"><use href="#i-upload"/></svg>Import 5 Murid</button>
                        </div>
                    </div>
                </div>
            </template>
            <template x-if="imp.step === 2">
                <div class="flex flex-col items-center py-10 text-center">
                    <span class="pop-in flex h-16 w-16 items-center justify-center rounded-full bg-green-100 text-green-600"><svg class="h-8 w-8" aria-hidden="true"><use href="#i-check"/></svg></span>
                    <p class="mt-4 text-lg font-bold text-gray-900">5 murid berjaya diimport</p>
                    <p class="mt-1 text-sm text-gray-600" x-text="'Dimasukkan ke ' + cls(imp.classId).name + ' (demo).'"></p>
                    <div class="mt-5 flex gap-2">
                        <button type="button" x-on:click="imp.step = 0" class="inline-flex items-center gap-2 rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50">Import Lagi</button>
                        <button type="button" x-on:click="fClass = imp.classId; q = ''; pg.murid = 1; go('murid')" class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-5 py-2 text-sm font-medium text-white hover:bg-blue-700">Lihat Senarai Murid</button>
                    </div>
                </div>
            </template>
        </div>
        <div class="rounded-xl border border-gray-200 bg-white p-5">
            <h2 class="font-semibold text-gray-900">Format lajur</h2>
            <ul class="mt-3 space-y-2 text-sm text-gray-700">
                <li class="flex gap-2"><span class="font-mono text-xs text-blue-700">A</span>Nama murid</li>
                <li class="flex gap-2"><span class="font-mono text-xs text-blue-700">B</span>No. MyKid (12 digit)</li>
                <li class="flex gap-2"><span class="font-mono text-xs text-blue-700">C</span>Jantina (L / P)</li>
                <li class="flex gap-2"><span class="font-mono text-xs text-blue-700">D</span>Nama penjaga</li>
                <li class="flex gap-2"><span class="font-mono text-xs text-blue-700">E</span>No. telefon penjaga</li>
            </ul>
            <button type="button" x-on:click="toast('Templat Excel dimuat turun (demo)', 'info')" class="mt-5 inline-flex items-center gap-2 text-sm font-semibold text-blue-700 hover:text-blue-800"><svg class="h-4 w-4" aria-hidden="true"><use href="#i-download"/></svg>Muat turun templat</button>
        </div>
    </div>
</section>
</template>

<!-- =====================================================================
     REKOD RPH (Personal)
     ===================================================================== -->
<template x-if="page === 'rph'">
<section>
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div><h1 class="text-2xl font-bold tracking-tight text-gray-900">Rekod RPH</h1><p class="mt-1 text-sm text-gray-600">Rancangan Pengajaran Harian — sokong tulisan Jawi dan cetak PDF.</p></div>
        <button type="button" x-on:click="openRph()" class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-5 py-2 text-sm font-medium text-white transition-colors hover:bg-blue-700"><svg class="h-4 w-4" aria-hidden="true"><use href="#i-plus"/></svg>Tambah RPH</button>
    </div>
    <div class="mb-4 flex flex-wrap gap-2">
        <template x-for="st in ['', 'Draf', 'Dihantar', 'Diluluskan', 'Dikembalikan']" :key="st">
            <button type="button" x-on:click="rphStatus = st; pg.rph = 1" class="rounded-full border px-3 py-1 text-xs font-semibold transition-colors" :class="rphStatus === st ? 'border-blue-600 bg-blue-600 text-white' : 'border-gray-300 bg-white text-gray-600 hover:bg-gray-50'" x-text="st || 'Semua'"></button>
        </template>
    </div>
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-left text-xs uppercase text-gray-500"><tr><th class="px-4 py-3">No</th><th class="px-4 py-3">Tarikh</th><th class="px-4 py-3">Kelas</th><th class="px-4 py-3">Subjek</th><th class="px-4 py-3">Guru</th><th class="px-4 py-3">Status</th><th class="px-4 py-3">Tindakan</th></tr></thead>
                <tbody class="divide-y divide-gray-100">
                    <template x-for="(r, i) in paged(rphList, 'rph')" :key="r.id">
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-gray-500" x-text="rowNo('rph', i)"></td>
                            <td class="whitespace-nowrap px-4 py-3 text-gray-700" x-text="fmtDate(r.date)"></td>
                            <td class="whitespace-nowrap px-4 py-3 text-gray-700" x-text="cls(r.classId).name"></td>
                            <td class="whitespace-nowrap px-4 py-3 font-medium text-gray-900" x-text="r.subject"></td>
                            <td class="whitespace-nowrap px-4 py-3 text-gray-700" x-text="tName(r.teacherId)"></td>
                            <td class="px-4 py-3"><span class="rounded-full px-2.5 py-0.5 text-xs font-medium" :class="statusCls(r.status)" x-text="r.status"></span></td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-1">
                                    <button type="button" title="Lihat" aria-label="Lihat" x-on:click="viewRph(r)" class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-gray-500 hover:bg-blue-50 hover:text-blue-600"><svg class="h-4 w-4" aria-hidden="true"><use href="#i-eye"/></svg></button>
                                    <button type="button" title="Edit" aria-label="Edit" x-show="r.status !== 'Diluluskan'" x-on:click="openRph(r)" class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-gray-500 hover:bg-amber-50 hover:text-amber-600"><svg class="h-4 w-4" aria-hidden="true"><use href="#i-pencil"/></svg></button>
                                    <button type="button" title="Padam" aria-label="Padam" x-on:click="askDelete('rph', r.id, 'RPH ' + r.subject + ' (' + fmtDate(r.date) + ')')" class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-gray-500 hover:bg-red-50 hover:text-red-600"><svg class="h-4 w-4" aria-hidden="true"><use href="#i-trash"/></svg></button>
                                </div>
                            </td>
                        </tr>
                    </template>
                    <tr x-show="rphList.length === 0"><td colspan="7" class="px-4 py-10 text-center text-sm text-gray-500">Tiada RPH untuk status ini.</td></tr>
                </tbody>
            </table>
        </div>
        <div class="flex flex-col items-center justify-between gap-3 border-t border-gray-200 px-4 py-3 sm:flex-row">
            <p class="text-sm text-gray-600">Paparan <span class="font-semibold text-gray-900" x-text="pgFrom(rphList, 'rph')"></span>–<span class="font-semibold text-gray-900" x-text="pgTo(rphList, 'rph')"></span> daripada <span class="font-semibold text-gray-900" x-text="rphList.length"></span></p>
            <nav aria-label="Navigasi halaman"><ul class="inline-flex -space-x-px text-sm">
                <li><button type="button" x-on:click="pg.rph = Math.max(1, pg.rph - 1)" :disabled="pg.rph <= 1" class="flex h-8 items-center justify-center rounded-s-lg border border-gray-300 bg-white px-3 text-gray-500 hover:bg-gray-100 disabled:opacity-50">Sebelum</button></li>
                <template x-for="n in pageNums(rphList, 'rph')" :key="n"><li><button type="button" x-on:click="pg.rph = n" class="flex h-8 items-center justify-center border border-gray-300 px-3" :class="pg.rph === n ? 'bg-blue-50 font-semibold text-blue-600' : 'bg-white text-gray-500 hover:bg-gray-100'" x-text="n"></button></li></template>
                <li><button type="button" x-on:click="pg.rph = Math.min(pageCount(rphList), pg.rph + 1)" :disabled="pg.rph >= pageCount(rphList)" class="flex h-8 items-center justify-center rounded-e-lg border border-gray-300 bg-white px-3 text-gray-500 hover:bg-gray-100 disabled:opacity-50">Seterusnya</button></li>
            </ul></nav>
        </div>
    </div>
</section>
</template>

<!-- =====================================================================
     REKOD PENCAPAIAN MURID (Personal)
     ===================================================================== -->
<template x-if="page === 'pencapaian'">
<section>
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div><h1 class="text-2xl font-bold tracking-tight text-gray-900">Rekod Pencapaian Murid</h1><p class="mt-1 text-sm text-gray-600">Hafazan surah Juz Amma, tahap bacaan dan penguasaan Jawi.</p></div>
        <select x-model.number="pcClass" class="f-input sm:w-64" aria-label="Pilih kelas"><template x-for="c in classesAvail" :key="c.id"><option :value="c.id" x-text="c.name"></option></template></select>
    </div>
    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
        <template x-for="s in pcRows" :key="s.id">
            <article class="rounded-xl border border-gray-200 bg-white p-5 transition-shadow hover:shadow-md">
                <div class="flex items-center gap-3">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full text-xs font-bold" :class="s.gender === 'L' ? 'bg-blue-100 text-blue-700' : 'bg-pink-100 text-pink-700'" x-text="initials(s.name)"></span>
                    <div class="min-w-0 flex-1"><p class="truncate text-sm font-semibold text-gray-900" x-text="s.name"></p><p class="text-xs text-gray-500" x-text="cls(s.classId).name"></p></div>
                    <button type="button" title="Kemas kini" aria-label="Kemas kini pencapaian" x-on:click="openAchv(s)" class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-gray-500 hover:bg-amber-50 hover:text-amber-600"><svg class="h-4 w-4" aria-hidden="true"><use href="#i-pencil"/></svg></button>
                </div>
                <div class="mt-4 space-y-3 text-sm">
                    <div>
                        <div class="flex justify-between text-xs"><span class="text-gray-500">Hafazan</span><span class="font-semibold text-gray-900" x-text="'Surah ' + SURAH[achv[s.id].haf]"></span></div>
                        <div class="mt-1.5 h-2 rounded-full bg-gray-100"><div class="bar-grow h-2 rounded-full bg-teal-500" :style="'width:' + Math.round((achv[s.id].haf + 1) / SURAH.length * 100) + '%'"></div></div>
                        <p class="mt-1 text-[11px] text-gray-500" x-text="(achv[s.id].haf + 1) + ' / ' + SURAH.length + ' surah Juz Amma'"></p>
                    </div>
                    <div class="flex items-center justify-between"><span class="text-xs text-gray-500">Bacaan</span><span class="rounded-full bg-blue-50 px-2.5 py-0.5 text-xs font-semibold text-blue-700" x-text="BACAAN[achv[s.id].bac]"></span></div>
                    <div class="flex items-center justify-between"><span class="text-xs text-gray-500">Tahap Jawi</span><span class="rounded-full px-2.5 py-0.5 text-xs font-semibold" :class="['bg-red-100 text-red-700','bg-amber-100 text-amber-700','bg-blue-100 text-blue-700','bg-green-100 text-green-700'][achv[s.id].jawi]" x-text="JAWI_LV[achv[s.id].jawi]"></span></div>
                </div>
            </article>
        </template>
    </div>
</section>
</template>

<!-- =====================================================================
     DISIPLIN MURID (Personal)
     ===================================================================== -->
<template x-if="page === 'disiplin'">
<section>
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div><h1 class="text-2xl font-bold tracking-tight text-gray-900">Disiplin Murid</h1><p class="mt-1 text-sm text-gray-600">Rekod kes, tindakan dan mata merit / demerit.</p></div>
        <button type="button" x-on:click="openDis()" class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-5 py-2 text-sm font-medium text-white transition-colors hover:bg-blue-700"><svg class="h-4 w-4" aria-hidden="true"><use href="#i-plus"/></svg>Tambah Rekod</button>
    </div>
    <div class="mb-5 grid gap-4 sm:grid-cols-3">
        <div class="rounded-xl border border-gray-200 bg-white p-5"><p class="text-sm text-gray-500">Kes demerit</p><p class="mt-1 text-3xl font-bold text-gray-900" x-text="disSum.kes"></p></div>
        <div class="rounded-xl border border-green-200 bg-green-50 p-5"><p class="text-sm text-green-700">Jumlah mata merit</p><p class="mt-1 text-3xl font-bold text-green-700" x-text="'+' + disSum.merit"></p></div>
        <div class="rounded-xl border border-red-200 bg-red-50 p-5"><p class="text-sm text-red-700">Jumlah mata demerit</p><p class="mt-1 text-3xl font-bold text-red-700" x-text="disSum.demerit"></p></div>
    </div>
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-left text-xs uppercase text-gray-500"><tr><th class="px-4 py-3">No</th><th class="px-4 py-3">Tarikh</th><th class="px-4 py-3">Murid</th><th class="px-4 py-3">Kategori</th><th class="px-4 py-3">Tindakan</th><th class="px-4 py-3">Mata</th><th class="px-4 py-3">Tindakan</th></tr></thead>
                <tbody class="divide-y divide-gray-100">
                    <template x-for="(d, i) in paged(disList, 'disiplin')" :key="d.id">
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-gray-500" x-text="rowNo('disiplin', i)"></td>
                            <td class="whitespace-nowrap px-4 py-3 text-gray-700" x-text="fmtDate(d.date)"></td>
                            <td class="px-4 py-3"><p class="whitespace-nowrap font-medium text-gray-900" x-text="stuName(d.sid)"></p><p class="text-xs text-gray-500" x-text="stu(d.sid) ? cls(stu(d.sid).classId).name : ''"></p></td>
                            <td class="whitespace-nowrap px-4 py-3 text-gray-700" x-text="d.kategori"></td>
                            <td class="whitespace-nowrap px-4 py-3 text-gray-700" x-text="d.tindakan"></td>
                            <td class="px-4 py-3"><span class="rounded-full px-2.5 py-0.5 text-xs font-bold" :class="d.mata > 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'" x-text="(d.mata > 0 ? '+' : '') + d.mata"></span></td>
                            <td class="px-4 py-3"><button type="button" title="Padam" aria-label="Padam" x-on:click="askDelete('disiplin', d.id, d.kategori + ' — ' + stuName(d.sid))" class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-gray-500 hover:bg-red-50 hover:text-red-600"><svg class="h-4 w-4" aria-hidden="true"><use href="#i-trash"/></svg></button></td>
                        </tr>
                    </template>
                    <tr x-show="disList.length === 0"><td colspan="7" class="px-4 py-10 text-center text-sm text-gray-500">Tiada rekod disiplin.</td></tr>
                </tbody>
            </table>
        </div>
        <div class="flex flex-col items-center justify-between gap-3 border-t border-gray-200 px-4 py-3 sm:flex-row">
            <p class="text-sm text-gray-600">Paparan <span class="font-semibold text-gray-900" x-text="pgFrom(disList, 'disiplin')"></span>–<span class="font-semibold text-gray-900" x-text="pgTo(disList, 'disiplin')"></span> daripada <span class="font-semibold text-gray-900" x-text="disList.length"></span></p>
            <nav aria-label="Navigasi halaman"><ul class="inline-flex -space-x-px text-sm">
                <li><button type="button" x-on:click="pg.disiplin = Math.max(1, pg.disiplin - 1)" :disabled="pg.disiplin <= 1" class="flex h-8 items-center justify-center rounded-s-lg border border-gray-300 bg-white px-3 text-gray-500 hover:bg-gray-100 disabled:opacity-50">Sebelum</button></li>
                <template x-for="n in pageNums(disList, 'disiplin')" :key="n"><li><button type="button" x-on:click="pg.disiplin = n" class="flex h-8 items-center justify-center border border-gray-300 px-3" :class="pg.disiplin === n ? 'bg-blue-50 font-semibold text-blue-600' : 'bg-white text-gray-500 hover:bg-gray-100'" x-text="n"></button></li></template>
                <li><button type="button" x-on:click="pg.disiplin = Math.min(pageCount(disList), pg.disiplin + 1)" :disabled="pg.disiplin >= pageCount(disList)" class="flex h-8 items-center justify-center rounded-e-lg border border-gray-300 bg-white px-3 text-gray-500 hover:bg-gray-100 disabled:opacity-50">Seterusnya</button></li>
            </ul></nav>
        </div>
    </div>
</section>
</template>

<!-- =====================================================================
     AKTIVITI (Personal)
     ===================================================================== -->
<template x-if="page === 'aktiviti'">
<section>
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div><h1 class="text-2xl font-bold tracking-tight text-gray-900">Aktiviti</h1><p class="mt-1 text-sm text-gray-600">Program sekolah dan senarai murid yang menyertai.</p></div>
        <button type="button" x-on:click="openAkt()" class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-5 py-2 text-sm font-medium text-white transition-colors hover:bg-blue-700"><svg class="h-4 w-4" aria-hidden="true"><use href="#i-plus"/></svg>Tambah Aktiviti</button>
    </div>
    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
        <template x-for="a in [...aktiviti].sort((x, y) => y.date.localeCompare(x.date))" :key="a.id">
            <article class="flex flex-col rounded-xl border border-gray-200 bg-white p-5 transition-shadow hover:shadow-md">
                <div class="flex items-start justify-between gap-3">
                    <span class="flex h-11 w-11 shrink-0 flex-col items-center justify-center rounded-xl bg-blue-600 text-white">
                        <span class="text-sm font-bold leading-none" x-text="new Date(a.date + 'T00:00:00').getDate()"></span>
                        <span class="text-[9px] font-semibold uppercase" x-text="BULAN_S[new Date(a.date + 'T00:00:00').getMonth()]"></span>
                    </span>
                    <span class="rounded-full px-2.5 py-0.5 text-xs font-medium" :class="a.date >= TODAY ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-700'" x-text="a.date >= TODAY ? 'Akan datang' : 'Selesai'"></span>
                </div>
                <h3 class="mt-4 font-semibold text-gray-900" x-text="a.name"></h3>
                <p class="mt-1 text-sm text-gray-600" x-text="a.tempat + ' · ' + fmtDate(a.date)"></p>
                <div class="mt-4 flex items-center gap-2">
                    <div class="flex -space-x-2">
                        <template x-for="sid in a.peserta.slice(0, 4)" :key="sid"><span class="flex h-7 w-7 items-center justify-center rounded-full bg-gray-200 text-[9px] font-bold text-gray-700 ring-2 ring-white" x-text="initials(stuName(sid))"></span></template>
                    </div>
                    <span class="text-xs text-gray-600" x-text="a.peserta.length + ' peserta'"></span>
                </div>
                <div class="mt-5 flex gap-2 border-t border-gray-100 pt-4">
                    <button type="button" x-on:click="openPeserta(a)" class="inline-flex flex-1 items-center justify-center gap-1.5 rounded-lg border border-gray-200 bg-white px-3 py-2 text-xs font-semibold text-gray-700 hover:bg-gray-50"><svg class="h-4 w-4" aria-hidden="true"><use href="#i-users"/></svg>Urus Peserta</button>
                    <button type="button" x-on:click="cert.act = a.id; cert.sid = a.peserta[0] || cert.sid; go('sijil')" class="inline-flex flex-1 items-center justify-center gap-1.5 rounded-lg border border-gray-200 bg-white px-3 py-2 text-xs font-semibold text-gray-700 hover:bg-gray-50"><svg class="h-4 w-4" aria-hidden="true"><use href="#i-academic"/></svg>Jana Sijil</button>
                </div>
            </article>
        </template>
    </div>
</section>
</template>

<!-- =====================================================================
     SIJIL DIGITAL (Personal)
     ===================================================================== -->
<template x-if="page === 'sijil'">
<section>
    <div class="mb-6"><h1 class="text-2xl font-bold tracking-tight text-gray-900">Sijil Digital</h1><p class="mt-1 text-sm text-gray-600">Pilih murid dan templat — sijil dijana lengkap dengan kod QR pengesahan.</p></div>
    <div class="grid gap-6 lg:grid-cols-3">
        <div class="space-y-4 rounded-xl border border-gray-200 bg-white p-5">
            <div><label class="f-label" for="c-act">Aktiviti</label>
                <select id="c-act" x-model.number="cert.act" class="f-input"><template x-for="a in aktiviti" :key="a.id"><option :value="a.id" x-text="a.name"></option></template></select></div>
            <div><label class="f-label" for="c-stu">Murid</label>
                <select id="c-stu" x-model.number="cert.sid" class="f-input">
                    <template x-for="c in classesAvail" :key="c.id">
                        <optgroup :label="c.name"><template x-for="s in students.filter(s => s.classId === c.id)" :key="s.id"><option :value="s.id" x-text="s.name"></option></template></optgroup>
                    </template>
                </select></div>
            <div>
                <p class="f-label">Templat</p>
                <div class="grid gap-2">
                    <template x-for="(t, k) in CERT_TPL" :key="k">
                        <label class="flex cursor-pointer items-center gap-3 rounded-lg border p-3 transition-colors" :class="cert.tpl === k ? 'border-blue-600 bg-blue-50' : 'border-gray-200 hover:bg-gray-50'">
                            <input type="radio" name="cert-tpl" :value="k" x-model="cert.tpl" class="h-4 w-4" style="accent-color:#2563EB">
                            <span class="text-sm font-medium text-gray-900" x-text="t.t"></span>
                        </label>
                    </template>
                </div>
            </div>
            <div class="flex gap-2 pt-2">
                <button type="button" x-on:click="toast('Sijil PDF dijana — pratonton sahaja dalam demo', 'info')" class="inline-flex flex-1 items-center justify-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700"><svg class="h-4 w-4" aria-hidden="true"><use href="#i-download"/></svg>Muat Turun PDF</button>
                <button type="button" x-on:click="toast('Sijil untuk semua ' + (certAct ? certAct.peserta.length : 0) + ' peserta dijana (demo)')" class="inline-flex items-center justify-center rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50">Jana Pukal</button>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="overflow-x-auto rounded-xl border border-gray-200 bg-gray-100 p-4 sm:p-6">
                <div class="cert-frame relative mx-auto rounded-lg shadow-lg" style="max-width:720px;min-width:520px;aspect-ratio:1.414/1">
                    <div class="pattern-star pointer-events-none absolute inset-0" style="opacity:.06" aria-hidden="true"></div>
                    <div class="absolute inset-3 rounded border-2 border-amber-600/40" aria-hidden="true"></div>
                    <div class="relative flex h-full flex-col items-center justify-center px-10 py-8 text-center">
                        <p class="jawi text-xl text-amber-800" dir="rtl" lang="ar">بسم الله الرحمن الرحيم</p>
                        <p class="mt-1 text-[11px] font-semibold uppercase tracking-[0.3em] text-gray-500">KAFA Al-Hidayah, Seri Manjung</p>
                        <p class="jawi mt-3 text-4xl font-bold text-blue-800" dir="rtl" lang="ms-Arab" x-text="CERT_TPL[cert.tpl].j"></p>
                        <p class="text-sm font-bold uppercase tracking-[0.2em] text-gray-800" x-text="CERT_TPL[cert.tpl].t"></p>
                        <p class="mt-4 text-xs text-gray-600">Dengan ini disahkan bahawa</p>
                        <p class="mt-1 border-b border-amber-600/40 px-6 pb-1 text-2xl font-bold text-gray-900" x-text="certStu ? certStu.name : '—'"></p>
                        <p class="mt-1 text-xs text-gray-600" x-text="certStu ? cls(certStu.classId).name : ''"></p>
                        <p class="mt-3 max-w-md text-sm text-gray-700"><span x-text="CERT_TPL[cert.tpl].line"></span> <span class="font-semibold" x-text="certAct ? certAct.name : ''"></span> <span x-text="certAct ? 'pada ' + fmtDate(certAct.date) + '.' : ''"></span></p>
                        <div class="mt-5 flex w-full items-end justify-between px-4">
                            <div class="text-left"><p class="font-serif text-lg italic text-blue-900">N. Aisyah</p><p class="border-t border-gray-400 pt-1 text-[10px] font-semibold text-gray-700">Ustazah Nur Aisyah<br>Guru Besar</p></div>
                            <div class="text-center"><div class="mx-auto h-14 w-14" x-html="qrSvg('sijil-' + cert.sid + '-' + cert.act + cert.tpl)"></div><p class="mt-1 font-mono text-[9px] text-gray-600" x-text="'EKF-2026-' + String(cert.sid).padStart(4, '0') + '-' + cert.act"></p></div>
                        </div>
                    </div>
                </div>
            </div>
            <p class="mt-2 text-center text-xs text-gray-500">Imbas kod QR untuk mengesahkan sijil secara dalam talian.</p>
        </div>
    </div>
</section>
</template>

<!-- =====================================================================
     LAPORAN MURID (Personal)
     ===================================================================== -->
<template x-if="page === 'laporan_murid'">
<section>
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div><h1 class="text-2xl font-bold tracking-tight text-gray-900">Laporan Murid</h1><p class="mt-1 text-sm text-gray-600">Slip keputusan lengkap dengan gred, kehadiran dan ulasan guru.</p></div>
        <button type="button" x-on:click="toast('Pratonton sahaja dalam demo — sistem sebenar menjana PDF dengan fon Jawi', 'info')" class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-5 py-2 text-sm font-medium text-white transition-colors hover:bg-blue-700"><svg class="h-4 w-4" aria-hidden="true"><use href="#i-printer"/></svg>Cetak PDF</button>
    </div>
    <div class="mb-5 grid gap-3 rounded-xl border border-gray-200 bg-white p-4 sm:grid-cols-3">
        <div><label class="f-label" for="lm-class">Kelas</label><select id="lm-class" x-model.number="lm.classId" x-on:change="lm.sid = firstStudent(lm.classId)" class="f-input"><template x-for="c in classesAvail" :key="c.id"><option :value="c.id" x-text="c.name"></option></template></select></div>
        <div><label class="f-label" for="lm-stu">Murid</label><select id="lm-stu" x-model.number="lm.sid" class="f-input"><template x-for="s in students.filter(s => s.classId === lm.classId)" :key="s.id"><option :value="s.id" x-text="s.name"></option></template></select></div>
        <div><label class="f-label" for="lm-exam">Peperiksaan</label><select id="lm-exam" x-model="lm.exam" class="f-input"><template x-for="e in exams" :key="e.id"><option :value="e.id" x-text="e.name"></option></template></select></div>
    </div>

    <template x-if="lmStu">
        <div class="mx-auto max-w-3xl rounded-xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8">
            <div class="flex items-center justify-between gap-4 border-b-2 border-blue-600 pb-4">
                <div class="flex items-center gap-3">
                    <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-600 text-sm font-extrabold text-white">eK</span>
                    <div><p class="font-bold text-gray-900">KAFA Al-Hidayah</p><p class="text-xs text-gray-500">Seri Manjung, Perak</p></div>
                </div>
                <div class="text-right"><p class="text-xs font-semibold uppercase tracking-wider text-blue-700">Slip Keputusan</p><p class="text-xs text-gray-600" x-text="exams.find(e => e.id === lm.exam).name"></p></div>
            </div>
            <dl class="mt-5 grid grid-cols-2 gap-x-6 gap-y-2 text-sm sm:grid-cols-4">
                <div class="col-span-2"><dt class="text-xs text-gray-500">Nama</dt><dd class="font-semibold text-gray-900" x-text="lmStu.name"></dd></div>
                <div><dt class="text-xs text-gray-500">Kelas</dt><dd class="font-semibold text-gray-900" x-text="cls(lmStu.classId).name"></dd></div>
                <div><dt class="text-xs text-gray-500">No. MyKid</dt><dd class="font-mono text-xs font-semibold text-gray-900" x-text="lmStu.mykid"></dd></div>
            </dl>
            <div class="mt-5 overflow-hidden rounded-lg border border-gray-200">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-left text-xs uppercase text-gray-500"><tr><th class="px-4 py-2.5">No</th><th class="px-4 py-2.5">Subjek</th><th class="px-4 py-2.5 text-center">Markah</th><th class="px-4 py-2.5 text-center">Gred</th></tr></thead>
                    <tbody class="divide-y divide-gray-100">
                        <template x-for="(r, j) in lmRows" :key="r.n">
                            <tr><td class="px-4 py-2 text-gray-500" x-text="j + 1"></td><td class="px-4 py-2 text-gray-900" x-text="r.n"></td><td class="px-4 py-2 text-center font-semibold" x-text="r.m === null || r.m === '' ? '—' : r.m"></td><td class="px-4 py-2 text-center"><span class="rounded-full px-2 py-0.5 text-xs font-bold" :class="gradeCls(r.m === null || r.m === '' ? '' : grade(r.m))" x-text="r.m === null || r.m === '' ? '—' : grade(r.m)"></span></td></tr>
                        </template>
                    </tbody>
                </table>
            </div>
            <div class="mt-5 grid grid-cols-2 gap-3 sm:grid-cols-4">
                <div class="rounded-lg bg-gray-50 p-3 text-center"><p class="text-xs text-gray-500">Jumlah</p><p class="text-lg font-bold text-gray-900" x-text="lmSummary.total"></p></div>
                <div class="rounded-lg bg-gray-50 p-3 text-center"><p class="text-xs text-gray-500">Purata</p><p class="text-lg font-bold text-gray-900" x-text="lmSummary.avg.toFixed(1)"></p></div>
                <div class="rounded-lg bg-gray-50 p-3 text-center"><p class="text-xs text-gray-500">Kedudukan</p><p class="text-lg font-bold text-gray-900" x-text="lmSummary.rank + ' / ' + lmSummary.of"></p></div>
                <div class="rounded-lg bg-gray-50 p-3 text-center"><p class="text-xs text-gray-500">Kehadiran</p><p class="text-lg font-bold text-gray-900" x-text="stuAtt(lmStu, 30).pct + '%'"></p></div>
            </div>
            <div class="mt-5 rounded-lg border border-blue-100 bg-blue-50/60 p-4">
                <p class="text-xs font-semibold uppercase tracking-wider text-blue-700">Ulasan Guru</p>
                <p class="mt-1 text-sm text-gray-800" x-text="ulasan(lmSummary.avg)"></p>
            </div>
            <div class="mt-8 grid grid-cols-2 gap-8 text-xs text-gray-600">
                <div><div class="h-10 border-b border-gray-400"></div><p class="mt-1" x-text="tName(cls(lmStu.classId).teacherId) + ' (Guru Kelas)'"></p></div>
                <div><div class="h-10 border-b border-gray-400"></div><p class="mt-1">Tandatangan Ibu Bapa / Penjaga</p></div>
            </div>
        </div>
    </template>
</section>
</template>

<!-- =====================================================================
     PEMBANTU AI (Personal)
     ===================================================================== -->
<template x-if="page === 'chatbot'">
<section>
    <div class="mb-6"><h1 class="text-2xl font-bold tracking-tight text-gray-900">Pembantu AI</h1><p class="mt-1 text-sm text-gray-600">Tanya tentang data sekolah atau minta idea RPH. (Jawapan demo dijana daripada data contoh.)</p></div>
    <div class="mx-auto flex max-w-3xl flex-col overflow-hidden rounded-xl border border-gray-200 bg-white" style="height:min(640px, calc(100vh - var(--demo-h) - 220px));min-height:420px">
        <div class="flex items-center gap-3 border-b border-gray-100 px-5 py-3">
            <span class="flex h-9 w-9 items-center justify-center rounded-full bg-gradient-to-br from-blue-600 to-teal-500 text-white"><svg class="h-5 w-5" aria-hidden="true"><use href="#i-sparkles"/></svg></span>
            <div><p class="text-sm font-semibold text-gray-900">Pembantu eKafa</p><p class="flex items-center gap-1.5 text-xs text-green-700"><span class="h-1.5 w-1.5 rounded-full bg-green-500"></span>Dalam talian</p></div>
        </div>
        <div id="chat-box" class="thin-scroll flex-1 space-y-4 overflow-y-auto bg-gray-50 p-5" aria-live="polite">
            <div class="flex gap-3">
                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-blue-600 text-white"><svg class="h-4 w-4" aria-hidden="true"><use href="#i-sparkles"/></svg></span>
                <div class="max-w-[80%] rounded-2xl rounded-tl-sm bg-white px-4 py-2.5 text-sm text-gray-800 shadow-sm ring-1 ring-gray-100">Assalamualaikum! Saya Pembantu eKafa. Saya boleh semak kehadiran, markah dan bantu rangka RPH. Apa yang boleh saya bantu hari ini?</div>
            </div>
            <template x-for="(m, i) in chat" :key="i">
                <div class="flex gap-3" :class="m.me ? 'flex-row-reverse' : ''">
                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full text-[11px] font-bold" :class="m.me ? 'bg-gray-900 text-white' : 'bg-blue-600 text-white'">
                        <template x-if="m.me"><span x-text="user.initials"></span></template>
                        <template x-if="!m.me"><svg class="h-4 w-4" aria-hidden="true"><use href="#i-sparkles"/></svg></template>
                    </span>
                    <div class="max-w-[80%] whitespace-pre-line rounded-2xl px-4 py-2.5 text-sm shadow-sm" :class="m.me ? 'rounded-tr-sm bg-blue-600 text-white' : 'rounded-tl-sm bg-white text-gray-800 ring-1 ring-gray-100'" x-text="m.text"></div>
                </div>
            </template>
            <div x-show="typing" class="flex gap-3">
                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-blue-600 text-white"><svg class="h-4 w-4" aria-hidden="true"><use href="#i-sparkles"/></svg></span>
                <div class="flex items-center gap-1 rounded-2xl rounded-tl-sm bg-white px-4 py-3 shadow-sm ring-1 ring-gray-100"><span class="dot h-1.5 w-1.5 rounded-full bg-gray-500"></span><span class="dot h-1.5 w-1.5 rounded-full bg-gray-500"></span><span class="dot h-1.5 w-1.5 rounded-full bg-gray-500"></span></div>
            </div>
        </div>
        <div class="border-t border-gray-100 p-3">
            <div class="mb-2 flex gap-2 overflow-x-auto thin-scroll pb-1">
                <template x-for="sg in CHAT_SUGGEST" :key="sg"><button type="button" x-on:click="ask(sg)" class="shrink-0 rounded-full border border-blue-200 bg-blue-50 px-3 py-1 text-xs font-medium text-blue-700 hover:bg-blue-100" x-text="sg"></button></template>
            </div>
            <form class="flex gap-2" x-on:submit.prevent="ask()">
                <input type="text" x-model="chatInput" placeholder="Taip soalan anda…" class="f-input" aria-label="Soalan">
                <button type="submit" class="inline-flex shrink-0 items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700" aria-label="Hantar"><svg class="h-4 w-4" aria-hidden="true"><use href="#i-send"/></svg></button>
            </form>
        </div>
    </div>
</section>
</template>

<!-- =====================================================================
     URUS GURU & PENGGUNA (Sekolah)
     ===================================================================== -->
<template x-if="page === 'pengguna'">
<section>
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div><h1 class="text-2xl font-bold tracking-tight text-gray-900">Urus Guru &amp; Pengguna</h1><p class="mt-1 text-sm text-gray-600">Jemput guru melalui e-mel — mereka sertai sekolah dengan satu klik.</p></div>
        <button type="button" x-on:click="openJemput()" class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-5 py-2 text-sm font-medium text-white transition-colors hover:bg-blue-700"><svg class="h-4 w-4" aria-hidden="true"><use href="#i-user-plus"/></svg>Jemput Guru</button>
    </div>
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-left text-xs uppercase text-gray-500"><tr><th class="px-4 py-3">No</th><th class="px-4 py-3">Nama</th><th class="px-4 py-3">E-mel</th><th class="px-4 py-3">Peranan</th><th class="px-4 py-3">Kelas</th><th class="px-4 py-3">Status</th><th class="px-4 py-3">Tindakan</th></tr></thead>
                <tbody class="divide-y divide-gray-100">
                    <template x-for="(t, i) in userRows" :key="t.id">
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-gray-500" x-text="i + 1"></td>
                            <td class="px-4 py-3"><div class="flex items-center gap-3"><span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-indigo-100 text-[11px] font-bold text-indigo-700" x-text="initials(t.name)"></span><span class="whitespace-nowrap font-medium text-gray-900" x-text="t.name"></span></div></td>
                            <td class="px-4 py-3 text-gray-700" x-text="t.email"></td>
                            <td class="px-4 py-3"><span class="rounded-full px-2.5 py-0.5 text-xs font-medium" :class="t.role === 'Guru Besar' ? 'bg-blue-100 text-blue-700' : 'bg-indigo-100 text-indigo-700'" x-text="t.role"></span></td>
                            <td class="px-4 py-3 text-gray-700" x-text="t.kelas"></td>
                            <td class="px-4 py-3"><span class="rounded-full px-2.5 py-0.5 text-xs font-medium" :class="t.status === 'Aktif' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700'" x-text="t.status"></span></td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-1">
                                    <button type="button" x-show="t.status === 'Dijemput'" title="Hantar semula jemputan" aria-label="Hantar semula jemputan" x-on:click="toast('Jemputan dihantar semula ke ' + t.email)" class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-gray-500 hover:bg-blue-50 hover:text-blue-600"><svg class="h-4 w-4" aria-hidden="true"><use href="#i-send"/></svg></button>
                                    <button type="button" x-show="t.role !== 'Guru Besar'" title="Padam" aria-label="Padam" x-on:click="askDelete('guru', t.id, t.name)" class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-gray-500 hover:bg-red-50 hover:text-red-600"><svg class="h-4 w-4" aria-hidden="true"><use href="#i-trash"/></svg></button>
                                </div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>
</section>
</template>

<!-- =====================================================================
     SEMAKAN & KELULUSAN RPH (Sekolah)
     ===================================================================== -->
<template x-if="page === 'kelulusan_rph'">
<section>
    <div class="mb-6"><h1 class="text-2xl font-bold tracking-tight text-gray-900">Semakan &amp; Kelulusan RPH</h1><p class="mt-1 text-sm text-gray-600">RPH yang dihantar guru untuk semakan Guru Besar.</p></div>
    <div class="grid gap-6 lg:grid-cols-3">
        <div class="space-y-3 lg:col-span-2">
            <template x-for="r in rphPending" :key="r.id">
                <article class="flex flex-col gap-4 rounded-xl border border-gray-200 bg-white p-5 sm:flex-row sm:items-center">
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-amber-50 text-amber-600"><svg class="h-6 w-6" aria-hidden="true"><use href="#i-doc"/></svg></span>
                    <div class="min-w-0 flex-1">
                        <p class="font-semibold text-gray-900" x-text="r.subject + ' · ' + cls(r.classId).name"></p>
                        <p class="text-sm text-gray-600" x-text="tName(r.teacherId) + ' · ' + fmtDate(r.date)"></p>
                        <p class="mt-1 truncate text-xs text-gray-500" :class="r.jawi ? 'jawi text-base' : ''" :dir="r.jawi ? 'rtl' : 'ltr'" x-text="r.objektif"></p>
                    </div>
                    <button type="button" x-on:click="openReview(r)" class="inline-flex shrink-0 items-center justify-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">Semak</button>
                </article>
            </template>
            <div x-show="rphPending.length === 0" class="flex flex-col items-center rounded-xl border border-dashed border-gray-300 bg-white p-10 text-center">
                <span class="flex h-12 w-12 items-center justify-center rounded-full bg-green-100 text-green-600"><svg class="h-6 w-6" aria-hidden="true"><use href="#i-check"/></svg></span>
                <p class="mt-3 font-semibold text-gray-900">Semua RPH telah disemak</p>
                <p class="mt-1 text-sm text-gray-600">Tiada RPH menunggu semakan buat masa ini.</p>
            </div>
        </div>
        <div class="rounded-xl border border-gray-200 bg-white p-5">
            <h2 class="font-semibold text-gray-900">Ringkasan</h2>
            <ul class="mt-4 space-y-3 text-sm">
                <template x-for="st in ['Dihantar', 'Diluluskan', 'Dikembalikan', 'Draf']" :key="st">
                    <li class="flex items-center justify-between"><span class="rounded-full px-2.5 py-0.5 text-xs font-medium" :class="statusCls(st)" x-text="st"></span><span class="font-semibold text-gray-900" x-text="rphs.filter(r => r.status === st).length"></span></li>
                </template>
            </ul>
        </div>
    </div>
</section>
</template>

<!-- =====================================================================
     LAPORAN & KPI SEKOLAH (Sekolah)
     ===================================================================== -->
<template x-if="page === 'laporan_sekolah'">
<section>
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div><h1 class="text-2xl font-bold tracking-tight text-gray-900">Laporan &amp; KPI Sekolah</h1><p class="mt-1 text-sm text-gray-600">Prestasi sekolah berbanding sasaran sesi 2026.</p></div>
        <button type="button" x-on:click="toast('Laporan PDF dijana — pratonton sahaja dalam demo', 'info')" class="inline-flex items-center gap-2 rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50"><svg class="h-4 w-4" aria-hidden="true"><use href="#i-printer"/></svg>Cetak Laporan</button>
    </div>
    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <template x-for="k in kpis" :key="k.n">
            <div class="rounded-xl border border-gray-200 bg-white p-5">
                <p class="text-sm text-gray-600" x-text="k.n"></p>
                <div class="mt-2 flex items-baseline gap-2"><p class="text-3xl font-bold text-gray-900" x-text="k.v + '%'"></p><span class="text-xs font-semibold" :class="k.v >= k.t ? 'text-green-700' : 'text-amber-700'" x-text="k.v >= k.t ? 'Capai sasaran' : 'Bawah sasaran'"></span></div>
                <div class="relative mt-3 h-2 rounded-full bg-gray-100">
                    <div class="bar-grow h-2 rounded-full" :class="k.v >= k.t ? 'bg-green-500' : 'bg-amber-500'" :style="'width:' + Math.min(100, k.v) + '%'"></div>
                    <span class="absolute -top-1 h-4 w-0.5 bg-gray-900" :style="'left:' + k.t + '%'" aria-hidden="true"></span>
                </div>
                <p class="mt-2 text-xs text-gray-500" x-text="'Sasaran: ' + k.t + '%'"></p>
            </div>
        </template>
    </div>
    <div class="mt-6 grid gap-6 xl:grid-cols-5">
        <div class="rounded-xl border border-gray-200 bg-white p-5 xl:col-span-3">
            <h2 class="font-semibold text-gray-900">Trend Kehadiran Bulanan 2026</h2>
            <p class="text-xs text-gray-500">Paksi menegak: 80% – 100%</p>
            <!-- SVG dijana dalam JS (trendSvg) — <template> tidak berfungsi di dalam <svg> -->
            <svg viewBox="0 0 600 240" class="mt-4 w-full" role="img" aria-label="Graf trend kehadiran bulanan" x-html="trendSvg"></svg>
            <p class="mt-1 text-xs text-gray-500">Garis putus-putus: sasaran 90%.</p>
        </div>
        <div class="rounded-xl border border-gray-200 bg-white p-5 xl:col-span-2">
            <h2 class="font-semibold text-gray-900">Purata Markah PAT Ikut Kelas</h2>
            <ul class="mt-5 space-y-4">
                <template x-for="c in classAvgs" :key="c.name">
                    <li>
                        <div class="flex justify-between text-sm"><span class="text-gray-700" x-text="c.name"></span><span class="font-semibold text-gray-900" x-text="c.avg"></span></div>
                        <div class="mt-1.5 h-2.5 rounded-full bg-gray-100"><div class="bar-grow h-2.5 rounded-full bg-blue-600" :style="'width:' + c.avg + '%'"></div></div>
                    </li>
                </template>
            </ul>
        </div>
    </div>
</section>
</template>

<!-- =====================================================================
     KEWANGAN (Sekolah)
     ===================================================================== -->
<template x-if="page === 'kewangan'">
<section>
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div><h1 class="text-2xl font-bold tracking-tight text-gray-900">Kewangan</h1><p class="mt-1 text-sm text-gray-600">Rekod wang masuk dan keluar sekolah mengikut kategori.</p></div>
        <button type="button" x-on:click="openTrans()" class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-5 py-2 text-sm font-medium text-white transition-colors hover:bg-blue-700"><svg class="h-4 w-4" aria-hidden="true"><use href="#i-plus"/></svg>Tambah Rekod</button>
    </div>
    <div class="grid gap-4 sm:grid-cols-3">
        <div class="rounded-xl border border-green-200 bg-green-50 p-5"><p class="text-sm text-green-700">Jumlah Masuk</p><p class="mt-1 text-2xl font-bold text-green-700" x-text="rm(finSum.masuk)"></p></div>
        <div class="rounded-xl border border-red-200 bg-red-50 p-5"><p class="text-sm text-red-700">Jumlah Keluar</p><p class="mt-1 text-2xl font-bold text-red-700" x-text="rm(finSum.keluar)"></p></div>
        <div class="rounded-xl border border-blue-200 bg-blue-50 p-5"><p class="text-sm text-blue-700">Baki Semasa</p><p class="mt-1 text-2xl font-bold text-blue-700" x-text="rm(finSum.masuk - finSum.keluar)"></p></div>
    </div>
    <div class="mt-6 rounded-xl border border-gray-200 bg-white p-5">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <h2 class="font-semibold text-gray-900">Ringkasan Bulanan</h2>
            <div class="flex gap-4 text-xs text-gray-600"><span class="flex items-center gap-1.5"><span class="h-2.5 w-2.5 rounded-sm bg-green-500"></span>Masuk</span><span class="flex items-center gap-1.5"><span class="h-2.5 w-2.5 rounded-sm bg-red-400"></span>Keluar</span></div>
        </div>
        <div class="mt-5 flex items-end gap-3 sm:gap-6" style="height:200px">
            <template x-for="m in finMonths" :key="m.key">
                <div class="flex h-full flex-1 flex-col items-center justify-end gap-2">
                    <div class="flex w-full flex-1 items-end justify-center gap-1">
                        <div class="bar-grow w-1/2 rounded-t-md bg-green-500" style="max-width:26px" :style="'height:' + (m.masuk / finMax * 100) + '%'" :title="'Masuk ' + rm(m.masuk)"></div>
                        <div class="bar-grow w-1/2 rounded-t-md bg-red-400" style="max-width:26px" :style="'height:' + (m.keluar / finMax * 100) + '%'" :title="'Keluar ' + rm(m.keluar)"></div>
                    </div>
                    <span class="text-xs text-gray-500" x-text="m.label"></span>
                </div>
            </template>
        </div>
    </div>
    <div class="mt-6 overflow-hidden rounded-xl border border-gray-200 bg-white">
        <div class="flex flex-wrap gap-2 border-b border-gray-100 p-4">
            <template x-for="f in [{ k: '', l: 'Semua' }, { k: 'masuk', l: 'Masuk' }, { k: 'keluar', l: 'Keluar' }]" :key="f.k">
                <button type="button" x-on:click="finFilter = f.k; pg.kewangan = 1" class="rounded-full border px-3 py-1 text-xs font-semibold" :class="finFilter === f.k ? 'border-blue-600 bg-blue-600 text-white' : 'border-gray-300 bg-white text-gray-600 hover:bg-gray-50'" x-text="f.l"></button>
            </template>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-left text-xs uppercase text-gray-500"><tr><th class="px-4 py-3">No</th><th class="px-4 py-3">Tarikh</th><th class="px-4 py-3">Kategori</th><th class="px-4 py-3">Keterangan</th><th class="px-4 py-3">Jenis</th><th class="px-4 py-3 text-right">Amaun</th><th class="px-4 py-3">Tindakan</th></tr></thead>
                <tbody class="divide-y divide-gray-100">
                    <template x-for="(t, i) in paged(finList, 'kewangan')" :key="t.id">
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-gray-500" x-text="rowNo('kewangan', i)"></td>
                            <td class="whitespace-nowrap px-4 py-3 text-gray-700" x-text="fmtDate(t.date)"></td>
                            <td class="whitespace-nowrap px-4 py-3 font-medium text-gray-900" x-text="t.kategori"></td>
                            <td class="px-4 py-3 text-gray-700" x-text="t.ket"></td>
                            <td class="px-4 py-3"><span class="rounded-full px-2.5 py-0.5 text-xs font-medium" :class="t.type === 'masuk' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'" x-text="t.type === 'masuk' ? 'Masuk' : 'Keluar'"></span></td>
                            <td class="whitespace-nowrap px-4 py-3 text-right font-semibold" :class="t.type === 'masuk' ? 'text-green-700' : 'text-red-700'" x-text="(t.type === 'masuk' ? '+' : '−') + rm(t.amaun)"></td>
                            <td class="px-4 py-3"><button type="button" title="Padam" aria-label="Padam" x-on:click="askDelete('trans', t.id, t.kategori + ' ' + rm(t.amaun))" class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-gray-500 hover:bg-red-50 hover:text-red-600"><svg class="h-4 w-4" aria-hidden="true"><use href="#i-trash"/></svg></button></td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
        <div class="flex flex-col items-center justify-between gap-3 border-t border-gray-200 px-4 py-3 sm:flex-row">
            <p class="text-sm text-gray-600">Paparan <span class="font-semibold text-gray-900" x-text="pgFrom(finList, 'kewangan')"></span>–<span class="font-semibold text-gray-900" x-text="pgTo(finList, 'kewangan')"></span> daripada <span class="font-semibold text-gray-900" x-text="finList.length"></span></p>
            <nav aria-label="Navigasi halaman"><ul class="inline-flex -space-x-px text-sm">
                <li><button type="button" x-on:click="pg.kewangan = Math.max(1, pg.kewangan - 1)" :disabled="pg.kewangan <= 1" class="flex h-8 items-center justify-center rounded-s-lg border border-gray-300 bg-white px-3 text-gray-500 hover:bg-gray-100 disabled:opacity-50">Sebelum</button></li>
                <template x-for="n in pageNums(finList, 'kewangan')" :key="n"><li><button type="button" x-on:click="pg.kewangan = n" class="flex h-8 items-center justify-center border border-gray-300 px-3" :class="pg.kewangan === n ? 'bg-blue-50 font-semibold text-blue-600' : 'bg-white text-gray-500 hover:bg-gray-100'" x-text="n"></button></li></template>
                <li><button type="button" x-on:click="pg.kewangan = Math.min(pageCount(finList), pg.kewangan + 1)" :disabled="pg.kewangan >= pageCount(finList)" class="flex h-8 items-center justify-center rounded-e-lg border border-gray-300 bg-white px-3 text-gray-500 hover:bg-gray-100 disabled:opacity-50">Seterusnya</button></li>
            </ul></nav>
        </div>
    </div>
</section>
</template>

<!-- =====================================================================
     HEBAHAN SEKOLAH (Sekolah)
     ===================================================================== -->
<template x-if="page === 'hebahan'">
<section>
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div><h1 class="text-2xl font-bold tracking-tight text-gray-900">Hebahan Sekolah</h1><p class="mt-1 text-sm text-gray-600">Notis untuk guru, ibu bapa atau semua.</p></div>
        <button type="button" x-show="role === 'gb'" x-on:click="openHeb()" class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-5 py-2 text-sm font-medium text-white transition-colors hover:bg-blue-700"><svg class="h-4 w-4" aria-hidden="true"><use href="#i-plus"/></svg>Cipta Hebahan</button>
    </div>
    <div class="space-y-3">
        <template x-for="h in hebList" :key="h.id">
            <article class="rounded-xl border border-gray-200 bg-white p-5">
                <div class="flex items-start gap-4">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600"><svg class="h-5 w-5" aria-hidden="true"><use href="#i-megaphone"/></svg></span>
                    <div class="min-w-0 flex-1">
                        <div class="flex flex-wrap items-center gap-2"><h3 class="font-semibold text-gray-900" x-text="h.title"></h3><span class="rounded-full bg-gray-100 px-2 py-0.5 text-[11px] font-semibold text-gray-700" x-text="'Kepada: ' + TARGET[h.target]"></span></div>
                        <p class="mt-1.5 text-sm text-gray-700" x-text="h.body"></p>
                        <p class="mt-2 text-xs text-gray-500" x-text="h.by + ' · ' + fmtDate(h.date)"></p>
                    </div>
                    <button type="button" x-show="role === 'gb'" title="Padam" aria-label="Padam" x-on:click="askDelete('hebahan', h.id, h.title)" class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-lg text-gray-500 hover:bg-red-50 hover:text-red-600"><svg class="h-4 w-4" aria-hidden="true"><use href="#i-trash"/></svg></button>
                </div>
            </article>
        </template>
    </div>
</section>
</template>

<!-- =====================================================================
     PORTAL IBU BAPA — pratonton untuk Guru Besar (Sekolah)
     ===================================================================== -->
<template x-if="page === 'portal_ibu_bapa'">
<section>
    <div class="mb-6"><h1 class="text-2xl font-bold tracking-tight text-gray-900">Portal Ibu Bapa</h1><p class="mt-1 text-sm text-gray-600">Ibu bapa log masuk dengan No. Kad Pengenalan dan hanya nampak data anak sendiri.</p></div>
    <div class="grid items-center gap-8 lg:grid-cols-2">
        <div class="space-y-4">
            <div class="rounded-xl border border-gray-200 bg-white p-5">
                <h2 class="font-semibold text-gray-900">Apa yang ibu bapa nampak</h2>
                <ul class="mt-3 space-y-2.5 text-sm text-gray-700">
                    <li class="flex gap-2.5"><svg class="mt-0.5 h-4 w-4 shrink-0 text-teal-600" aria-hidden="true"><use href="#i-check"/></svg>Kehadiran harian anak dan peratus bulan ini</li>
                    <li class="flex gap-2.5"><svg class="mt-0.5 h-4 w-4 shrink-0 text-teal-600" aria-hidden="true"><use href="#i-check"/></svg>Keputusan peperiksaan terkini mengikut subjek</li>
                    <li class="flex gap-2.5"><svg class="mt-0.5 h-4 w-4 shrink-0 text-teal-600" aria-hidden="true"><use href="#i-check"/></svg>Hebahan sekolah dan yuran tertunggak</li>
                    <li class="flex gap-2.5"><svg class="mt-0.5 h-4 w-4 shrink-0 text-teal-600" aria-hidden="true"><use href="#i-check"/></svg>Muat turun sijil digital anak</li>
                </ul>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="rounded-xl border border-gray-200 bg-white p-5"><p class="text-sm text-gray-500">Akaun ibu bapa aktif</p><p class="mt-1 text-2xl font-bold text-gray-900">96</p></div>
                <div class="rounded-xl border border-gray-200 bg-white p-5"><p class="text-sm text-gray-500">Log masuk minggu ini</p><p class="mt-1 text-2xl font-bold text-gray-900">71</p></div>
            </div>
            <button type="button" x-on:click="role = 'parent'; switchRole()" class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-blue-700"><svg class="h-4 w-4" aria-hidden="true"><use href="#i-eye"/></svg>Lihat sebagai Ibu Bapa</button>
        </div>
        <div class="flex justify-center" aria-hidden="true">
            <div class="w-72 rounded-[2.2rem] border-[10px] border-gray-900 bg-gray-900 shadow-2xl">
                <div class="overflow-hidden rounded-[1.6rem] bg-gray-50">
                    <div class="bg-blue-600 px-4 pb-5 pt-4 text-white">
                        <p class="text-[10px] text-blue-100">Portal Ibu Bapa</p>
                        <p class="text-sm font-bold">Kamal bin Hassan</p>
                        <p class="text-[10px] text-blue-100">2 anak · KAFA Al-Hidayah</p>
                    </div>
                    <div class="-mt-3 space-y-2.5 px-3 pb-5">
                        <template x-for="k in children" :key="k.id">
                            <div class="flex items-center gap-3 rounded-xl bg-white p-3 shadow-sm">
                                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full text-[10px] font-bold" :class="k.gender === 'L' ? 'bg-blue-100 text-blue-700' : 'bg-pink-100 text-pink-700'" x-text="initials(k.name)"></span>
                                <div class="min-w-0 flex-1"><p class="truncate text-[11px] font-semibold text-gray-900" x-text="k.name"></p><p class="text-[10px] text-gray-500" x-text="cls(k.classId).name"></p></div>
                                <span class="text-xs font-bold text-green-700" x-text="stuAtt(k, monthDays).pct + '%'"></span>
                            </div>
                        </template>
                        <div class="rounded-xl bg-white p-3 shadow-sm"><p class="text-[10px] font-semibold text-gray-800">Hebahan terkini</p><p class="mt-1 text-[10px] text-gray-600" x-text="hebahan.filter(h => h.target !== 'guru')[0] ? hebahan.filter(h => h.target !== 'guru')[0].title : ''"></p></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</template>

<!-- =====================================================================
     PINDAH MURID (Sekolah)
     ===================================================================== -->
<template x-if="page === 'pindah_murid'">
<section>
    <div class="mb-6"><h1 class="text-2xl font-bold tracking-tight text-gray-900">Pindah Murid</h1><p class="mt-1 text-sm text-gray-600">Pindahkan rekod murid ke sekolah KAFA lain yang menggunakan eKafa.</p></div>
    <div class="grid gap-6 lg:grid-cols-3">
        <form class="space-y-4 rounded-xl border border-gray-200 bg-white p-5" x-on:submit.prevent="submitPindah()">
            <h2 class="font-semibold text-gray-900">Permohonan Baharu</h2>
            <div><label class="f-label" for="pd-class">Kelas</label><select id="pd-class" x-model.number="pf.cid" x-on:change="pf.sid = firstStudent(pf.cid)" class="f-input"><template x-for="c in classesAvail" :key="c.id"><option :value="c.id" x-text="c.name"></option></template></select></div>
            <div><label class="f-label" for="pd-stu">Murid</label><select id="pd-stu" x-model.number="pf.sid" class="f-input"><template x-for="s in students.filter(s => s.classId === pf.cid)" :key="s.id"><option :value="s.id" x-text="s.name"></option></template></select></div>
            <div><label class="f-label" for="pd-dest">Sekolah destinasi</label><select id="pd-dest" x-model="pf.dest" class="f-input"><template x-for="sc in SCHOOLS" :key="sc"><option :value="sc" x-text="sc"></option></template></select></div>
            <div><label class="f-label" for="pd-reason">Sebab</label><select id="pd-reason" x-model="pf.reason" class="f-input"><option>Berpindah rumah</option><option>Pertukaran tempat kerja ibu bapa</option><option>Permintaan ibu bapa</option><option>Lain-lain</option></select></div>
            <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-blue-600 px-5 py-2 text-sm font-medium text-white hover:bg-blue-700"><svg class="h-4 w-4" aria-hidden="true"><use href="#i-arrows"/></svg>Hantar Permohonan</button>
        </form>
        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white lg:col-span-2">
            <div class="border-b border-gray-100 p-5"><h2 class="font-semibold text-gray-900">Status Permohonan</h2></div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-left text-xs uppercase text-gray-500"><tr><th class="px-4 py-3">No</th><th class="px-4 py-3">Murid</th><th class="px-4 py-3">Destinasi</th><th class="px-4 py-3">Tarikh</th><th class="px-4 py-3">Status</th></tr></thead>
                    <tbody class="divide-y divide-gray-100">
                        <template x-for="(p, i) in [...pindah].reverse()" :key="p.id">
                            <tr>
                                <td class="px-4 py-3 text-gray-500" x-text="i + 1"></td>
                                <td class="px-4 py-3"><p class="whitespace-nowrap font-medium text-gray-900" x-text="p.name"></p><p class="text-xs text-gray-500" x-text="p.reason"></p></td>
                                <td class="whitespace-nowrap px-4 py-3 text-gray-700" x-text="p.dest"></td>
                                <td class="whitespace-nowrap px-4 py-3 text-gray-700" x-text="fmtDate(p.date)"></td>
                                <td class="px-4 py-3"><span class="inline-flex items-center gap-1.5 whitespace-nowrap rounded-full px-2.5 py-0.5 text-xs font-medium" :class="p.status === 'Diluluskan' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700'"><span x-show="p.status !== 'Diluluskan'" class="h-1.5 w-1.5 animate-pulse rounded-full bg-amber-500"></span><span x-text="p.status"></span></span></td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
</template>

<!-- =====================================================================
     LANGGANAN — perbandingan pelan
     ===================================================================== -->
<template x-if="page === 'langganan'">
<section>
    <div class="mb-8 text-center"><h1 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">Pilih pelan yang sesuai</h1><p class="mt-2 text-sm text-gray-600">Bayaran bulanan melalui FPX. Tiada kontrak — batal bila-bila masa.</p></div>
    <div class="mx-auto grid max-w-5xl gap-5 md:grid-cols-3">
        <template x-for="p in ['free', 'personal', 'sekolah']" :key="p">
            <div class="relative flex flex-col rounded-2xl bg-white p-6" :class="p === 'sekolah' ? 'ring-2 ring-blue-600 shadow-xl shadow-blue-600/10' : 'border border-gray-200'">
                <span x-show="p === 'sekolah'" class="absolute -top-3 left-1/2 -translate-x-1/2 whitespace-nowrap rounded-full bg-blue-600 px-3 py-1 text-xs font-semibold text-white">Paling Popular</span>
                <div class="flex items-center justify-between"><h2 class="text-lg font-semibold text-gray-900" x-text="PLANS[p].label"></h2><span x-show="plan === p" class="rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-semibold text-green-700">Pelan semasa</span></div>
                <p class="mt-1 text-sm text-gray-600" x-text="{ free: '3 kelas, 40 murid sekelas', personal: 'Guru individu — kelas sendiri, tanpa had', sekolah: 'Guru Besar, guru & ibu bapa' }[p]"></p>
                <p class="mt-5 flex items-baseline gap-1"><span class="text-4xl font-extrabold tracking-tight text-gray-900" x-text="'RM' + PLANS[p].price"></span><span class="text-sm text-gray-500">/bulan</span></p>
                <button type="button" x-on:click="setPlan(p)" :disabled="plan === p" class="mt-5 inline-flex items-center justify-center rounded-lg px-4 py-2.5 text-sm font-semibold transition-colors disabled:cursor-default disabled:opacity-60" :class="p === 'sekolah' ? 'bg-blue-600 text-white hover:bg-blue-700' : 'border border-gray-300 text-gray-800 hover:bg-gray-50'" x-text="plan === p ? 'Sedang digunakan' : 'Cuba pelan ini (demo)'"></button>
            </div>
        </template>
    </div>
    <div class="mx-auto mt-8 max-w-5xl overflow-hidden rounded-xl border border-gray-200 bg-white">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-xs uppercase text-gray-500"><tr><th class="px-4 py-3 text-left">No</th><th class="px-4 py-3 text-left">Modul</th><th class="px-4 py-3 text-center">Percuma</th><th class="px-4 py-3 text-center">Personal</th><th class="px-4 py-3 text-center">Sekolah</th></tr></thead>
                <tbody class="divide-y divide-gray-100">
                    <tr class="bg-blue-50/40"><td class="px-4 py-3 text-gray-500">—</td><td class="px-4 py-3 font-medium text-gray-900">Had kelas &amp; murid</td><td class="px-4 py-3 text-center text-gray-700">3 × 40</td><td class="px-4 py-3 text-center text-gray-700">Tanpa had</td><td class="px-4 py-3 text-center text-gray-700">Tanpa had</td></tr>
                    <template x-for="(m, i) in planModules" :key="m.key">
                        <tr>
                            <td class="px-4 py-3 text-gray-500" x-text="i + 1"></td>
                            <td class="px-4 py-3 text-gray-900" x-text="m.label"></td>
                            <template x-for="p in ['free', 'personal', 'sekolah']" :key="p">
                                <td class="px-4 py-3 text-center">
                                    <svg x-show="PLANS[p].rank >= PLANS[m.plan].rank" class="mx-auto h-5 w-5 text-green-600" aria-label="Ada"><use href="#i-check"/></svg>
                                    <svg x-show="PLANS[p].rank < PLANS[m.plan].rank" class="mx-auto h-5 w-5 text-gray-400" aria-label="Tiada"><use href="#i-x"/></svg>
                                </td>
                            </template>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>
    <div class="mx-auto mt-8 flex max-w-5xl flex-col items-center gap-3 rounded-2xl bg-blue-600 p-8 text-center text-white sm:flex-row sm:text-left">
        <div class="flex-1"><p class="text-lg font-bold">Suka apa yang anda lihat?</p><p class="text-sm text-blue-100">Daftar percuma sekarang — 3 kelas tanpa had masa, tiada kad kredit.</p></div>
        <a href="{{ route('register') }}" class="inline-flex items-center gap-2 rounded-lg bg-white px-5 py-2.5 text-sm font-semibold text-blue-700 hover:bg-blue-50">Daftar Percuma <svg class="h-4 w-4" aria-hidden="true"><use href="#i-arrow-right"/></svg></a>
    </div>
</section>
</template>

<!-- =====================================================================
     PAPARAN IBU BAPA (peranan Ibu Bapa) — mesra mudah alih
     ===================================================================== -->
<template x-if="page === 'parent_home'">
<section class="mx-auto max-w-lg">
    <template x-if="locked('parent_home')">
        <div class="flex flex-col items-center rounded-2xl border border-gray-200 bg-white p-8 text-center">
            <span class="flex h-14 w-14 items-center justify-center rounded-full bg-blue-50 text-blue-600"><svg class="h-7 w-7" aria-hidden="true"><use href="#i-lock"/></svg></span>
            <h1 class="mt-4 text-lg font-bold text-gray-900">Portal Ibu Bapa belum diaktifkan</h1>
            <p class="mt-2 text-sm text-gray-600">Portal Ibu Bapa tersedia untuk sekolah yang melanggan pelan Sekolah (RM49/bulan).</p>
            <button type="button" x-on:click="setPlan('sekolah')" class="mt-5 inline-flex items-center gap-2 rounded-lg bg-blue-600 px-5 py-2 text-sm font-medium text-white hover:bg-blue-700">Tukar demo ke pelan Sekolah</button>
        </div>
    </template>
    <template x-if="!locked('parent_home') && child">
        <div class="space-y-4">
            <div class="relative overflow-hidden rounded-2xl bg-blue-600 p-5 text-white">
                <div class="pattern-star-light pointer-events-none absolute inset-0" style="opacity:.08" aria-hidden="true"></div>
                <div class="relative">
                    <p class="text-sm text-blue-100">Assalamualaikum,</p>
                    <p class="text-lg font-bold">Kamal bin Hassan</p>
                    <div class="mt-4 flex gap-2">
                        <template x-for="(k, i) in children" :key="k.id">
                            <button type="button" x-on:click="pChild = i" class="flex flex-1 items-center gap-2 rounded-xl p-2.5 text-left transition-colors" :class="pChild === i ? 'bg-white text-gray-900' : 'bg-white/10 text-white hover:bg-white/20'">
                                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full text-[10px] font-bold" :class="k.gender === 'L' ? 'bg-blue-100 text-blue-700' : 'bg-pink-100 text-pink-700'" x-text="initials(k.name)"></span>
                                <span class="min-w-0"><span class="block truncate text-xs font-semibold" x-text="k.name.split(/ bin | binti /)[0]"></span><span class="block truncate text-[10px] opacity-80" x-text="cls(k.classId).name"></span></span>
                            </button>
                        </template>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white p-5" x-data="{ a: null }" x-effect="a = stuAtt(child, monthDays)">
                <h2 class="font-semibold text-gray-900">Kehadiran Bulan Ini</h2>
                <div class="mt-4 flex items-center gap-5">
                    <svg viewBox="0 0 80 80" class="h-24 w-24 shrink-0 -rotate-90" aria-hidden="true">
                        <circle cx="40" cy="40" r="34" fill="none" stroke="#E5E7EB" stroke-width="8"/>
                        <circle class="ring-draw" cx="40" cy="40" r="34" fill="none" stroke="#10B981" stroke-width="8" stroke-linecap="round" stroke-dasharray="213.6" :stroke-dashoffset="213.6 - 213.6 * (a ? a.pct : 0) / 100"/>
                    </svg>
                    <div>
                        <p class="text-3xl font-bold text-gray-900" x-text="(a ? a.pct : 0) + '%'"></p>
                        <p class="text-sm text-gray-600" x-text="a ? (a.h + a.l) + ' daripada ' + a.tot + ' hari hadir' : ''"></p>
                        <p class="mt-1 text-xs text-gray-500" x-text="a ? 'Lewat ' + a.l + ' · Tidak hadir ' + a.t + ' · Cuti ' + a.c : ''"></p>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white p-5">
                <div class="flex items-center justify-between">
                    <h2 class="font-semibold text-gray-900">Keputusan Terkini</h2>
                    <span class="rounded-full px-2.5 py-0.5 text-xs font-bold" :class="gradeCls(grade(childAvg))" x-text="'Gred ' + grade(childAvg)"></span>
                </div>
                <p class="text-xs text-gray-500" x-text="'Peperiksaan Akhir Tahun · Purata ' + childAvg.toFixed(1)"></p>
                <ul class="mt-4 divide-y divide-gray-100">
                    <template x-for="(n, j) in SUBJECTS" :key="n">
                        <li class="flex items-center justify-between py-2 text-sm"><span class="text-gray-700" x-text="n"></span><span class="flex items-center gap-2"><span class="font-semibold text-gray-900" x-text="markOf('pat', child.id, j)"></span><span class="w-6 rounded-full py-0.5 text-center text-[10px] font-bold" :class="gradeCls(gradeOf('pat', child.id, j))" x-text="gradeOf('pat', child.id, j)"></span></span></li>
                    </template>
                </ul>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white p-5">
                <h2 class="font-semibold text-gray-900">Yuran Tertunggak</h2>
                <ul class="mt-3 space-y-2">
                    <template x-for="f in fees.filter(f => f.sid === child.id)" :key="f.id">
                        <li class="flex items-center justify-between gap-3 rounded-xl border border-gray-100 p-3">
                            <div><p class="text-sm font-medium text-gray-900" x-text="'Yuran Bulanan — ' + f.month"></p><p class="text-xs text-gray-500" x-text="rm(f.amount)"></p></div>
                            <button type="button" x-show="!f.paid" x-on:click="payFee(f)" class="rounded-lg bg-blue-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-blue-700">Bayar (FPX)</button>
                            <span x-show="f.paid" class="rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-semibold text-green-700">Dibayar</span>
                        </li>
                    </template>
                    <li x-show="fees.filter(f => f.sid === child.id).length === 0" class="text-sm text-gray-500">Tiada yuran tertunggak.</li>
                </ul>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white p-5">
                <h2 class="font-semibold text-gray-900">Hebahan Sekolah</h2>
                <ul class="mt-3 space-y-3">
                    <template x-for="h in hebList.slice(0, 3)" :key="h.id">
                        <li class="flex gap-3"><svg class="mt-0.5 h-5 w-5 shrink-0 text-blue-600" aria-hidden="true"><use href="#i-megaphone"/></svg><div><p class="text-sm font-semibold text-gray-900" x-text="h.title"></p><p class="mt-0.5 text-xs text-gray-600" x-text="h.body"></p><p class="mt-1 text-[11px] text-gray-500" x-text="fmtDate(h.date)"></p></div></li>
                    </template>
                </ul>
            </div>
        </div>
    </template>
</section>
</template>

    </main>
</div>

<!-- =====================================================================
     MODAL (satu bekas, kandungan ikut jenis)
     ===================================================================== -->
<div x-show="modal" x-cloak x-transition.opacity class="no-print fixed inset-0 z-[65] flex items-end justify-center bg-gray-900/50 sm:items-center sm:p-4" x-on:click.self="modal = null">
    <div class="thin-scroll max-h-[92vh] w-full overflow-y-auto rounded-t-2xl bg-white shadow-xl sm:rounded-xl" :class="['rphView', 'review', 'peserta'].includes(modal) ? 'sm:max-w-2xl' : 'sm:max-w-lg'" role="dialog" aria-modal="true">

        <!-- Kelas -->
        <template x-if="modal === 'kelas'">
            <form x-on:submit.prevent="saveKelas()">
                <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4"><h3 class="text-base font-semibold text-gray-900" x-text="form.id ? 'Edit Kelas' : 'Tambah Kelas'"></h3><button type="button" x-on:click="modal = null" class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100" aria-label="Tutup"><svg class="h-5 w-5" aria-hidden="true"><use href="#i-x"/></svg></button></div>
                <div class="space-y-4 px-5 py-5">
                    <div><label class="f-label" for="k-name">Nama Kelas</label><input id="k-name" type="text" x-model="form.name" placeholder="cth: Tahun 6 Ibnu Rusyd" class="f-input"></div>
                    <div class="grid grid-cols-2 gap-3">
                        <div><label class="f-label" for="k-year">Tahun</label><select id="k-year" x-model.number="form.year" class="f-input"><template x-for="y in [1, 2, 3, 4, 5, 6]" :key="y"><option :value="y" x-text="'Tahun ' + y"></option></template></select></div>
                        <div><label class="f-label" for="k-teacher">Guru Kelas</label><select id="k-teacher" x-model.number="form.teacherId" class="f-input"><template x-for="t in teachers.filter(t => t.status === 'Aktif')" :key="t.id"><option :value="t.id" x-text="t.name"></option></template></select></div>
                    </div>
                </div>
                <div class="flex justify-end gap-2 border-t border-gray-100 px-5 py-4"><button type="button" x-on:click="modal = null" class="inline-flex items-center gap-2 rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50">Batal</button><button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-5 py-2 text-sm font-medium text-white hover:bg-blue-700">Simpan</button></div>
            </form>
        </template>

        <!-- Murid -->
        <template x-if="modal === 'murid'">
            <form x-on:submit.prevent="saveMurid()">
                <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4"><h3 class="text-base font-semibold text-gray-900" x-text="form.id ? 'Edit Murid' : 'Tambah Murid'"></h3><button type="button" x-on:click="modal = null" class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100" aria-label="Tutup"><svg class="h-5 w-5" aria-hidden="true"><use href="#i-x"/></svg></button></div>
                <div class="space-y-4 px-5 py-5">
                    <div><label class="f-label" for="m-name">Nama Penuh</label><input id="m-name" type="text" x-model="form.name" placeholder="cth: Ahmad Zayyad bin Rahman" class="f-input"></div>
                    <div class="grid gap-3 sm:grid-cols-2">
                        <div><label class="f-label" for="m-kid">No. MyKid</label><input id="m-kid" type="text" inputmode="numeric" maxlength="12" x-model="form.mykid" placeholder="12 digit tanpa sengkang" class="f-input"></div>
                        <div><span class="f-label">Jantina</span>
                            <div class="flex gap-2">
                                <template x-for="g in [{ k: 'L', l: 'Lelaki' }, { k: 'P', l: 'Perempuan' }]" :key="g.k">
                                    <label class="flex-1 cursor-pointer"><input type="radio" class="peer sr-only" name="m-gender" :value="g.k" x-model="form.gender"><span class="flex items-center justify-center rounded-lg border border-gray-300 px-2 py-2 text-xs font-medium transition-colors peer-checked:border-blue-600 peer-checked:bg-blue-600 peer-checked:text-white peer-focus-visible:ring-2 peer-focus-visible:ring-blue-500" x-text="g.l"></span></label>
                                </template>
                            </div>
                        </div>
                    </div>
                    <div><label class="f-label" for="m-class">Kelas</label><select id="m-class" x-model.number="form.classId" class="f-input"><template x-for="c in classesAvail" :key="c.id"><option :value="c.id" x-text="c.name"></option></template></select></div>
                    <div class="grid gap-3 sm:grid-cols-2">
                        <div><label class="f-label" for="m-guard">Nama Penjaga</label><input id="m-guard" type="text" x-model="form.guardian" class="f-input"></div>
                        <div><label class="f-label" for="m-phone">No. Telefon Penjaga</label><input id="m-phone" type="tel" x-model="form.phone" placeholder="cth: 012-3456789" class="f-input"></div>
                    </div>
                    <p x-show="plan === 'free'" class="rounded-lg bg-amber-50 px-3 py-2 text-xs text-amber-900">Pelan Percuma: maksimum 40 murid sekelas.</p>
                </div>
                <div class="flex justify-end gap-2 border-t border-gray-100 px-5 py-4"><button type="button" x-on:click="modal = null" class="inline-flex items-center gap-2 rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50">Batal</button><button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-5 py-2 text-sm font-medium text-white hover:bg-blue-700">Simpan</button></div>
            </form>
        </template>

        <!-- Slot jadual -->
        <template x-if="modal === 'slot'">
            <form x-on:submit.prevent="saveSlot()">
                <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4"><h3 class="text-base font-semibold text-gray-900">Tukar Subjek</h3><button type="button" x-on:click="modal = null" class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100" aria-label="Tutup"><svg class="h-5 w-5" aria-hidden="true"><use href="#i-x"/></svg></button></div>
                <div class="space-y-4 px-5 py-5">
                    <p class="text-sm text-gray-600" x-text="cls(ttClass).name + ' · ' + DAYS[form.d] + ' · ' + SLOTS.find(s => s.i === form.s).t"></p>
                    <div class="grid grid-cols-2 gap-2">
                        <template x-for="(n, j) in SUBJECTS" :key="n">
                            <label class="cursor-pointer"><input type="radio" class="peer sr-only" name="slot-subj" :value="j" x-model.number="form.subj"><span class="flex items-center gap-2 rounded-lg border-2 px-3 py-2 text-sm font-semibold transition-colors peer-focus-visible:ring-2 peer-focus-visible:ring-blue-500" :class="form.subj === j ? 'border-gray-900' : 'border-transparent'" :style="'background:' + SUBJ_COLORS[j].bg + ';color:' + SUBJ_COLORS[j].fg" x-text="n"></span></label>
                        </template>
                    </div>
                </div>
                <div class="flex justify-end gap-2 border-t border-gray-100 px-5 py-4"><button type="button" x-on:click="modal = null" class="inline-flex items-center gap-2 rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50">Batal</button><button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-5 py-2 text-sm font-medium text-white hover:bg-blue-700">Simpan</button></div>
            </form>
        </template>

        <!-- RPH: borang -->
        <template x-if="modal === 'rph'">
            <form x-on:submit.prevent="saveRph(plan === 'sekolah' ? 'Dihantar' : 'Draf')">
                <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4"><h3 class="text-base font-semibold text-gray-900" x-text="form.id ? 'Edit RPH' : 'RPH Baharu'"></h3><button type="button" x-on:click="modal = null" class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100" aria-label="Tutup"><svg class="h-5 w-5" aria-hidden="true"><use href="#i-x"/></svg></button></div>
                <div class="space-y-4 px-5 py-5">
                    <div class="grid gap-3 sm:grid-cols-3">
                        <div><label class="f-label" for="r-date">Tarikh</label><input id="r-date" type="date" x-model="form.date" class="f-input"></div>
                        <div><label class="f-label" for="r-class">Kelas</label><select id="r-class" x-model.number="form.classId" class="f-input"><template x-for="c in classesAvail" :key="c.id"><option :value="c.id" x-text="c.name"></option></template></select></div>
                        <div><label class="f-label" for="r-subj">Subjek</label><select id="r-subj" x-model="form.subject" class="f-input"><template x-for="n in SUBJECTS" :key="n"><option :value="n" x-text="n"></option></template></select></div>
                    </div>
                    <label class="inline-flex cursor-pointer items-center gap-3">
                        <input type="checkbox" x-model="form.jawi" class="peer sr-only">
                        <span class="relative h-6 w-11 rounded-full bg-gray-200 transition-colors after:absolute after:left-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:bg-white after:transition-all peer-checked:bg-blue-600 peer-checked:after:translate-x-5 peer-focus-visible:ring-2 peer-focus-visible:ring-blue-500"></span>
                        <span class="text-sm font-medium text-gray-700">Tulis dalam Jawi (kanan ke kiri)</span>
                    </label>
                    <div><label class="f-label" for="r-obj">Objektif Pembelajaran</label><textarea id="r-obj" rows="2" x-model="form.objektif" :dir="form.jawi ? 'rtl' : 'ltr'" :class="form.jawi ? 'jawi text-lg' : ''" class="f-input" :placeholder="form.jawi ? 'موريد داڤت…' : 'Pada akhir PdP, murid dapat…'"></textarea></div>
                    <div><label class="f-label" for="r-akt">Aktiviti</label><textarea id="r-akt" rows="3" x-model="form.aktiviti" :dir="form.jawi ? 'rtl' : 'ltr'" :class="form.jawi ? 'jawi text-lg' : ''" class="f-input"></textarea></div>
                    <div><label class="f-label" for="r-ref">Refleksi</label><textarea id="r-ref" rows="2" x-model="form.refleksi" :dir="form.jawi ? 'rtl' : 'ltr'" :class="form.jawi ? 'jawi text-lg' : ''" class="f-input"></textarea></div>
                    <p x-show="plan !== 'sekolah'" class="rounded-lg bg-blue-50 px-3 py-2 text-xs text-blue-800">Hantar RPH untuk semakan Guru Besar tersedia pada pelan Sekolah.</p>
                </div>
                <div class="flex flex-wrap justify-end gap-2 border-t border-gray-100 px-5 py-4">
                    <button type="button" x-on:click="modal = null" class="inline-flex items-center gap-2 rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50">Batal</button>
                    <button type="button" x-show="plan === 'sekolah'" x-on:click="saveRph('Draf')" class="inline-flex items-center gap-2 rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Simpan Draf</button>
                    <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-5 py-2 text-sm font-medium text-white hover:bg-blue-700" x-text="plan === 'sekolah' ? 'Hantar untuk Semakan' : 'Simpan'"></button>
                </div>
            </form>
        </template>

        <!-- RPH: paparan dokumen -->
        <template x-if="modal === 'rphView'">
            <div>
                <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4"><h3 class="text-base font-semibold text-gray-900">Rancangan Pengajaran Harian</h3><button type="button" x-on:click="modal = null" class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100" aria-label="Tutup"><svg class="h-5 w-5" aria-hidden="true"><use href="#i-x"/></svg></button></div>
                <div class="px-5 py-5">
                    <div class="flex flex-wrap items-center justify-between gap-2"><p class="text-lg font-bold text-gray-900" x-text="form.subject"></p><span class="rounded-full px-2.5 py-0.5 text-xs font-medium" :class="statusCls(form.status)" x-text="form.status"></span></div>
                    <dl class="mt-3 grid grid-cols-2 gap-3 text-sm sm:grid-cols-3">
                        <div><dt class="text-xs text-gray-500">Kelas</dt><dd class="font-medium text-gray-900" x-text="cls(form.classId).name"></dd></div>
                        <div><dt class="text-xs text-gray-500">Tarikh</dt><dd class="font-medium text-gray-900" x-text="fmtDate(form.date)"></dd></div>
                        <div><dt class="text-xs text-gray-500">Guru</dt><dd class="font-medium text-gray-900" x-text="tName(form.teacherId)"></dd></div>
                    </dl>
                    <div class="mt-5 space-y-4 rounded-xl bg-gray-50 p-4" :dir="form.jawi ? 'rtl' : 'ltr'" :class="form.jawi ? 'jawi' : ''">
                        <div><p class="font-semibold text-blue-700" :class="form.jawi ? 'text-xl' : 'text-xs uppercase tracking-wider'" x-text="form.jawi ? 'اوبجيکتيف ڤمبلاجرن' : 'Objektif Pembelajaran'"></p><p class="mt-1 text-gray-800" :class="form.jawi ? 'text-lg' : 'text-sm'" x-text="form.objektif"></p></div>
                        <div><p class="font-semibold text-blue-700" :class="form.jawi ? 'text-xl' : 'text-xs uppercase tracking-wider'" x-text="form.jawi ? 'اکتيۏيتي' : 'Aktiviti'"></p><p class="mt-1 text-gray-800" :class="form.jawi ? 'text-lg' : 'text-sm'" x-text="form.aktiviti || '—'"></p></div>
                        <div><p class="font-semibold text-blue-700" :class="form.jawi ? 'text-xl' : 'text-xs uppercase tracking-wider'" x-text="form.jawi ? 'ريفليکسي' : 'Refleksi'"></p><p class="mt-1 text-gray-800" :class="form.jawi ? 'text-lg' : 'text-sm'" x-text="form.refleksi || '—'"></p></div>
                    </div>
                    <div x-show="form.ulasan" class="mt-4 rounded-lg border px-4 py-3 text-sm" :class="form.status === 'Dikembalikan' ? 'border-red-200 bg-red-50 text-red-800' : 'border-green-200 bg-green-50 text-green-800'"><span class="font-semibold">Ulasan Guru Besar:</span> <span x-text="form.ulasan"></span></div>
                </div>
                <div class="flex flex-wrap justify-end gap-2 border-t border-gray-100 px-5 py-4">
                    <button type="button" x-on:click="toast('Pratonton sahaja dalam demo — sistem sebenar menjana PDF dengan fon Jawi', 'info')" class="inline-flex items-center gap-2 rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50"><svg class="h-4 w-4" aria-hidden="true"><use href="#i-printer"/></svg>Cetak PDF</button>
                    <button type="button" x-show="role === 'gb' && form.status === 'Dihantar' && !locked('kelulusan_rph')" x-on:click="openReview(form)" class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-5 py-2 text-sm font-medium text-white hover:bg-blue-700">Semak RPH</button>
                </div>
            </div>
        </template>

        <!-- RPH: semakan Guru Besar -->
        <template x-if="modal === 'review'">
            <div>
                <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4"><h3 class="text-base font-semibold text-gray-900">Semakan RPH</h3><button type="button" x-on:click="modal = null" class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100" aria-label="Tutup"><svg class="h-5 w-5" aria-hidden="true"><use href="#i-x"/></svg></button></div>
                <div class="space-y-4 px-5 py-5">
                    <p class="text-sm text-gray-600" x-text="form.subject + ' · ' + cls(form.classId).name + ' · ' + tName(form.teacherId) + ' · ' + fmtDate(form.date)"></p>
                    <div class="space-y-3 rounded-xl bg-gray-50 p-4" :dir="form.jawi ? 'rtl' : 'ltr'" :class="form.jawi ? 'jawi text-lg' : 'text-sm'">
                        <p class="text-gray-800"><span class="font-semibold text-blue-700" x-text="form.jawi ? 'اوبجيکتيف: ' : 'Objektif: '"></span><span x-text="form.objektif"></span></p>
                        <p class="text-gray-800"><span class="font-semibold text-blue-700" x-text="form.jawi ? 'اکتيۏيتي: ' : 'Aktiviti: '"></span><span x-text="form.aktiviti"></span></p>
                        <p class="text-gray-800"><span class="font-semibold text-blue-700" x-text="form.jawi ? 'ريفليکسي: ' : 'Refleksi: '"></span><span x-text="form.refleksi"></span></p>
                    </div>
                    <div><label class="f-label" for="rv-ulasan">Ulasan</label><textarea id="rv-ulasan" rows="3" x-model="form.ulasan" placeholder="Wajib jika RPH dikembalikan" class="f-input"></textarea></div>
                </div>
                <div class="flex flex-wrap justify-end gap-2 border-t border-gray-100 px-5 py-4">
                    <button type="button" x-on:click="decideRph(false)" class="inline-flex items-center gap-2 rounded-lg border border-red-200 bg-white px-4 py-2 text-sm font-medium text-red-700 hover:bg-red-50">Kembalikan</button>
                    <button type="button" x-on:click="decideRph(true)" class="inline-flex items-center gap-2 rounded-lg bg-green-700 px-5 py-2 text-sm font-medium text-white hover:bg-green-800"><svg class="h-4 w-4" aria-hidden="true"><use href="#i-check"/></svg>Luluskan</button>
                </div>
            </div>
        </template>

        <!-- Pencapaian -->
        <template x-if="modal === 'achv'">
            <form x-on:submit.prevent="saveAchv()">
                <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4"><h3 class="text-base font-semibold text-gray-900">Kemas Kini Pencapaian</h3><button type="button" x-on:click="modal = null" class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100" aria-label="Tutup"><svg class="h-5 w-5" aria-hidden="true"><use href="#i-x"/></svg></button></div>
                <div class="space-y-4 px-5 py-5">
                    <p class="text-sm font-semibold text-gray-900" x-text="stuName(form.sid)"></p>
                    <div><label class="f-label" for="a-haf">Hafazan terkini</label><select id="a-haf" x-model.number="form.haf" class="f-input"><template x-for="(sr, i) in SURAH" :key="sr"><option :value="i" x-text="(i + 1) + '. Surah ' + sr"></option></template></select></div>
                    <div><label class="f-label" for="a-bac">Tahap bacaan</label><select id="a-bac" x-model.number="form.bac" class="f-input"><template x-for="(b, i) in BACAAN" :key="b"><option :value="i" x-text="b"></option></template></select></div>
                    <div><label class="f-label" for="a-jawi">Tahap Jawi</label><select id="a-jawi" x-model.number="form.jawi" class="f-input"><template x-for="(j, i) in JAWI_LV" :key="j"><option :value="i" x-text="j"></option></template></select></div>
                </div>
                <div class="flex justify-end gap-2 border-t border-gray-100 px-5 py-4"><button type="button" x-on:click="modal = null" class="inline-flex items-center gap-2 rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50">Batal</button><button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-5 py-2 text-sm font-medium text-white hover:bg-blue-700">Simpan</button></div>
            </form>
        </template>

        <!-- Disiplin -->
        <template x-if="modal === 'dis'">
            <form x-on:submit.prevent="saveDis()">
                <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4"><h3 class="text-base font-semibold text-gray-900">Rekod Disiplin / Merit</h3><button type="button" x-on:click="modal = null" class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100" aria-label="Tutup"><svg class="h-5 w-5" aria-hidden="true"><use href="#i-x"/></svg></button></div>
                <div class="space-y-4 px-5 py-5">
                    <div><label class="f-label" for="d-stu">Murid</label>
                        <select id="d-stu" x-model.number="form.sid" class="f-input">
                            <template x-for="c in classesAvail" :key="c.id"><optgroup :label="c.name"><template x-for="s in students.filter(s => s.classId === c.id)" :key="s.id"><option :value="s.id" x-text="s.name"></option></template></optgroup></template>
                        </select></div>
                    <div class="flex gap-2">
                        <template x-for="ty in [{ k: 'demerit', l: 'Demerit' }, { k: 'merit', l: 'Merit' }]" :key="ty.k">
                            <label class="flex-1 cursor-pointer"><input type="radio" class="peer sr-only" name="d-type" :value="ty.k" x-model="form.type" x-on:change="form.cat = 0; form.tindakan = ty.k === 'merit' ? 'Penghargaan' : 'Nasihat'"><span class="flex items-center justify-center rounded-lg border border-gray-300 px-2 py-2 text-sm font-medium transition-colors peer-focus-visible:ring-2 peer-focus-visible:ring-blue-500" :class="form.type === ty.k ? (ty.k === 'merit' ? 'border-green-700 bg-green-700 text-white' : 'border-red-600 bg-red-600 text-white') : ''" x-text="ty.l"></span></label>
                        </template>
                    </div>
                    <div class="grid gap-3 sm:grid-cols-2">
                        <div><label class="f-label" for="d-cat">Kategori</label><select id="d-cat" x-model.number="form.cat" class="f-input"><template x-for="(c, i) in DIS_CAT[form.type]" :key="form.type + i"><option :value="i" x-text="c.n + ' (' + (c.p > 0 ? '+' : '') + c.p + ')'"></option></template></select></div>
                        <div><label class="f-label" for="d-act">Tindakan</label><select id="d-act" x-model="form.tindakan" class="f-input"><template x-for="a in DIS_ACT" :key="a"><option :value="a" x-text="a"></option></template></select></div>
                    </div>
                    <div><label class="f-label" for="d-date">Tarikh</label><input id="d-date" type="date" x-model="form.date" :max="TODAY" class="f-input"></div>
                </div>
                <div class="flex justify-end gap-2 border-t border-gray-100 px-5 py-4"><button type="button" x-on:click="modal = null" class="inline-flex items-center gap-2 rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50">Batal</button><button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-5 py-2 text-sm font-medium text-white hover:bg-blue-700">Simpan</button></div>
            </form>
        </template>

        <!-- Aktiviti baharu -->
        <template x-if="modal === 'akt'">
            <form x-on:submit.prevent="saveAkt()">
                <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4"><h3 class="text-base font-semibold text-gray-900">Aktiviti Baharu</h3><button type="button" x-on:click="modal = null" class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100" aria-label="Tutup"><svg class="h-5 w-5" aria-hidden="true"><use href="#i-x"/></svg></button></div>
                <div class="space-y-4 px-5 py-5">
                    <div><label class="f-label" for="ak-name">Nama Aktiviti</label><input id="ak-name" type="text" x-model="form.name" placeholder="cth: Pertandingan Hafazan Juz Amma" class="f-input"></div>
                    <div class="grid gap-3 sm:grid-cols-2">
                        <div><label class="f-label" for="ak-date">Tarikh</label><input id="ak-date" type="date" x-model="form.date" class="f-input"></div>
                        <div><label class="f-label" for="ak-place">Tempat</label><input id="ak-place" type="text" x-model="form.tempat" placeholder="cth: Surau KAFA" class="f-input"></div>
                    </div>
                </div>
                <div class="flex justify-end gap-2 border-t border-gray-100 px-5 py-4"><button type="button" x-on:click="modal = null" class="inline-flex items-center gap-2 rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50">Batal</button><button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-5 py-2 text-sm font-medium text-white hover:bg-blue-700">Simpan</button></div>
            </form>
        </template>

        <!-- Peserta aktiviti -->
        <template x-if="modal === 'peserta' && pesertaAkt">
            <div>
                <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4"><div><h3 class="text-base font-semibold text-gray-900">Urus Peserta</h3><p class="text-xs text-gray-500" x-text="pesertaAkt ? pesertaAkt.name + ' · ' + pesertaAkt.peserta.length + ' peserta' : ''"></p></div><button type="button" x-on:click="modal = null" class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100" aria-label="Tutup"><svg class="h-5 w-5" aria-hidden="true"><use href="#i-x"/></svg></button></div>
                <div class="px-5 py-4">
                    <select x-model.number="form.cid" class="f-input" aria-label="Tapis kelas"><template x-for="c in classesAvail" :key="c.id"><option :value="c.id" x-text="c.name"></option></template></select>
                    <ul class="thin-scroll mt-3 max-h-80 divide-y divide-gray-100 overflow-y-auto rounded-lg border border-gray-200">
                        <template x-for="s in students.filter(s => s.classId === form.cid)" :key="s.id">
                            <li><label class="flex cursor-pointer items-center gap-3 px-3 py-2.5 hover:bg-gray-50"><input type="checkbox" :checked="pesertaAkt && pesertaAkt.peserta.includes(s.id)" x-on:change="togglePeserta(s.id)" class="h-4 w-4 rounded border-gray-300" style="accent-color:#2563EB"><span class="text-sm text-gray-800" x-text="s.name"></span></label></li>
                        </template>
                    </ul>
                </div>
                <div class="flex justify-end gap-2 border-t border-gray-100 px-5 py-4"><button type="button" x-on:click="modal = null; saved()" class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-5 py-2 text-sm font-medium text-white hover:bg-blue-700">Selesai</button></div>
            </div>
        </template>

        <!-- Jemput guru -->
        <template x-if="modal === 'jemput'">
            <form x-on:submit.prevent="sendInvite()">
                <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4"><h3 class="text-base font-semibold text-gray-900">Jemput Guru</h3><button type="button" x-on:click="modal = null" class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100" aria-label="Tutup"><svg class="h-5 w-5" aria-hidden="true"><use href="#i-x"/></svg></button></div>
                <div class="space-y-4 px-5 py-5">
                    <div><label class="f-label" for="j-name">Nama Guru</label><input id="j-name" type="text" x-model="form.name" placeholder="cth: Ustazah Nur Hidayah" class="f-input"></div>
                    <div><label class="f-label" for="j-email">E-mel</label><input id="j-email" type="email" x-model="form.email" placeholder="guru@contoh.com" class="f-input"></div>
                    <p class="rounded-lg bg-blue-50 px-3 py-2 text-xs text-blue-800">Guru akan menerima pautan jemputan. Jika mereka sudah ada akaun Personal, kelas dan murid mereka dibawa bersama.</p>
                </div>
                <div class="flex justify-end gap-2 border-t border-gray-100 px-5 py-4"><button type="button" x-on:click="modal = null" class="inline-flex items-center gap-2 rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50">Batal</button><button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-5 py-2 text-sm font-medium text-white hover:bg-blue-700"><svg class="h-4 w-4" aria-hidden="true"><use href="#i-send"/></svg>Hantar Jemputan</button></div>
            </form>
        </template>

        <!-- Kewangan -->
        <template x-if="modal === 'trans'">
            <form x-on:submit.prevent="saveTrans()">
                <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4"><h3 class="text-base font-semibold text-gray-900">Rekod Kewangan</h3><button type="button" x-on:click="modal = null" class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100" aria-label="Tutup"><svg class="h-5 w-5" aria-hidden="true"><use href="#i-x"/></svg></button></div>
                <div class="space-y-4 px-5 py-5">
                    <div class="flex gap-2">
                        <template x-for="ty in [{ k: 'masuk', l: 'Wang Masuk' }, { k: 'keluar', l: 'Wang Keluar' }]" :key="ty.k">
                            <label class="flex-1 cursor-pointer"><input type="radio" class="peer sr-only" name="t-type" :value="ty.k" x-model="form.type" x-on:change="form.kategori = FIN_CAT[ty.k][0]"><span class="flex items-center justify-center rounded-lg border border-gray-300 px-2 py-2 text-sm font-medium transition-colors peer-focus-visible:ring-2 peer-focus-visible:ring-blue-500" :class="form.type === ty.k ? (ty.k === 'masuk' ? 'border-green-700 bg-green-700 text-white' : 'border-red-600 bg-red-600 text-white') : ''" x-text="ty.l"></span></label>
                        </template>
                    </div>
                    <div class="grid gap-3 sm:grid-cols-2">
                        <div><label class="f-label" for="t-cat">Kategori</label><select id="t-cat" x-model="form.kategori" class="f-input"><template x-for="c in FIN_CAT[form.type]" :key="form.type + c"><option :value="c" x-text="c"></option></template></select></div>
                        <div><label class="f-label" for="t-amt">Amaun (RM)</label><input id="t-amt" type="number" min="0" step="0.01" x-model.number="form.amaun" placeholder="0.00" class="f-input"></div>
                    </div>
                    <div class="grid gap-3 sm:grid-cols-2">
                        <div><label class="f-label" for="t-date">Tarikh</label><input id="t-date" type="date" x-model="form.date" :max="TODAY" class="f-input"></div>
                        <div><label class="f-label" for="t-ket">Keterangan</label><input id="t-ket" type="text" x-model="form.ket" class="f-input"></div>
                    </div>
                </div>
                <div class="flex justify-end gap-2 border-t border-gray-100 px-5 py-4"><button type="button" x-on:click="modal = null" class="inline-flex items-center gap-2 rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50">Batal</button><button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-5 py-2 text-sm font-medium text-white hover:bg-blue-700">Simpan</button></div>
            </form>
        </template>

        <!-- Hebahan -->
        <template x-if="modal === 'heb'">
            <form x-on:submit.prevent="saveHeb()">
                <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4"><h3 class="text-base font-semibold text-gray-900">Cipta Hebahan</h3><button type="button" x-on:click="modal = null" class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100" aria-label="Tutup"><svg class="h-5 w-5" aria-hidden="true"><use href="#i-x"/></svg></button></div>
                <div class="space-y-4 px-5 py-5">
                    <div><label class="f-label" for="h-title">Tajuk</label><input id="h-title" type="text" x-model="form.title" class="f-input"></div>
                    <div><label class="f-label" for="h-body">Kandungan</label><textarea id="h-body" rows="4" x-model="form.body" class="f-input"></textarea></div>
                    <div><span class="f-label">Sasaran</span>
                        <div class="flex gap-2">
                            <template x-for="(lbl, k) in TARGET" :key="k">
                                <label class="flex-1 cursor-pointer"><input type="radio" class="peer sr-only" name="h-target" :value="k" x-model="form.target"><span class="flex items-center justify-center rounded-lg border border-gray-300 px-2 py-2 text-xs font-medium transition-colors peer-checked:border-blue-600 peer-checked:bg-blue-600 peer-checked:text-white peer-focus-visible:ring-2 peer-focus-visible:ring-blue-500" x-text="lbl"></span></label>
                            </template>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end gap-2 border-t border-gray-100 px-5 py-4"><button type="button" x-on:click="modal = null" class="inline-flex items-center gap-2 rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50">Batal</button><button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-5 py-2 text-sm font-medium text-white hover:bg-blue-700"><svg class="h-4 w-4" aria-hidden="true"><use href="#i-send"/></svg>Terbitkan</button></div>
            </form>
        </template>

        <!-- Padam -->
        <template x-if="modal === 'padam' && delTarget">
            <div class="px-6 py-6 text-center">
                <span class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-red-100 text-red-600"><svg class="h-6 w-6" aria-hidden="true"><use href="#i-trash"/></svg></span>
                <h3 class="mt-4 text-base font-semibold text-gray-900">Padam rekod ini?</h3>
                <p class="mt-1 text-sm text-gray-600" x-text="delTarget.name"></p>
                <p x-show="delTarget.kind === 'kelas'" class="mt-2 text-xs text-red-700">Semua murid dalam kelas ini akan turut dipadam.</p>
                <div class="mt-6 flex justify-center gap-2"><button type="button" x-on:click="modal = null" class="inline-flex items-center gap-2 rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50">Batal</button><button type="button" x-on:click="doDelete()" class="inline-flex items-center gap-2 rounded-lg bg-red-600 px-5 py-2 text-sm font-medium text-white hover:bg-red-700">Ya, Padam</button></div>
            </div>
        </template>

        <!-- Upsell -->
        <template x-if="modal === 'upsell' && upsell">
            <div>
                <div class="relative overflow-hidden rounded-t-2xl bg-blue-600 px-6 pb-6 pt-7 text-white sm:rounded-t-xl">
                    <div class="pattern-star-light pointer-events-none absolute inset-0" style="opacity:.1" aria-hidden="true"></div>
                    <button type="button" x-on:click="modal = null" class="absolute right-3 top-3 inline-flex h-8 w-8 items-center justify-center rounded-lg text-blue-100 hover:bg-white/10" aria-label="Tutup"><svg class="h-5 w-5" aria-hidden="true"><use href="#i-x"/></svg></button>
                    <div class="relative">
                        <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-white/15"><svg class="h-6 w-6" aria-hidden="true"><use href="#i-lock"/></svg></span>
                        <h3 class="mt-4 text-lg font-bold" x-text="upsell.title"></h3>
                        <p class="mt-1 text-sm text-blue-100" x-text="upsell.text"></p>
                    </div>
                </div>
                <div class="px-6 py-5">
                    <div class="flex items-baseline justify-between">
                        <p class="text-sm font-semibold text-gray-900" x-text="'Pelan ' + PLANS[upsell.plan].label"></p>
                        <p><span class="text-2xl font-extrabold text-gray-900" x-text="'RM' + PLANS[upsell.plan].price"></span><span class="text-sm text-gray-500">/bulan</span></p>
                    </div>
                    <p class="mt-3 text-xs font-semibold uppercase tracking-wide text-gray-500" x-text="upsell.plan === 'sekolah' ? 'Semua dalam Personal, serta:' : 'Semua dalam Percuma, serta:'"></p>
                    <ul class="mt-2 grid gap-1.5 text-sm text-gray-700 sm:grid-cols-2">
                        <template x-for="f in planFeatures(upsell.plan)" :key="f"><li class="flex gap-2"><svg class="mt-0.5 h-4 w-4 shrink-0 text-blue-600" aria-hidden="true"><use href="#i-check"/></svg><span x-text="f"></span></li></template>
                    </ul>
                </div>
                <div class="flex flex-col-reverse gap-2 border-t border-gray-100 px-6 py-4 sm:flex-row sm:justify-end">
                    <button type="button" x-on:click="upgradeDemo()" class="inline-flex items-center justify-center gap-2 rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50">Cuba dalam demo</button>
                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-5 py-2 text-sm font-medium text-white hover:bg-blue-700">Naik Taraf — Daftar Percuma <svg class="h-4 w-4" aria-hidden="true"><use href="#i-arrow-right"/></svg></a>
                </div>
            </div>
        </template>
    </div>
</div>

<!-- =====================================================================
     MOD KIOSK QR (skrin penuh)
     ===================================================================== -->
<div x-show="kiosk.open" x-cloak x-transition.opacity class="no-print fixed inset-0 z-[70] flex flex-col overflow-y-auto bg-slate-950 text-white" role="dialog" aria-modal="true" aria-label="Mod Kiosk QR">
    <div class="pattern-star-light pointer-events-none fixed inset-0" style="opacity:.05" aria-hidden="true"></div>
    <div class="relative flex items-center justify-between gap-3 border-b border-white/10 px-5 py-4">
        <div class="flex items-center gap-3">
            <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-blue-600 text-sm font-extrabold">eK</span>
            <div><p class="text-sm font-bold">Kiosk Kehadiran</p><p class="text-xs text-slate-400" x-text="cls(kiosk.classId).name + ' · ' + fmtLong(TODAY)"></p></div>
        </div>
        <button type="button" x-on:click="closeKiosk()" class="inline-flex items-center gap-2 rounded-lg border border-white/20 px-3 py-2 text-sm font-semibold text-white hover:bg-white/10"><svg class="h-4 w-4" aria-hidden="true"><use href="#i-x"/></svg>Tutup Kiosk</button>
    </div>
    <div class="relative grid flex-1 gap-8 p-5 sm:p-8 lg:grid-cols-2 lg:items-center">
        <div class="flex flex-col items-center">
            <p class="text-xl font-bold sm:text-2xl">Imbas kad QR anda</p>
            <p class="mt-1 text-sm text-slate-400">Halakan kad ke kamera</p>
            <div class="relative mt-6 aspect-square w-full overflow-hidden rounded-3xl bg-slate-900 ring-1 ring-white/10" style="max-width:360px">
                <span class="absolute left-8 top-8 h-10 w-10 rounded-tl-xl border-l-4 border-t-4 border-teal-400"></span>
                <span class="absolute right-8 top-8 h-10 w-10 rounded-tr-xl border-r-4 border-t-4 border-teal-400"></span>
                <span class="absolute bottom-8 left-8 h-10 w-10 rounded-bl-xl border-b-4 border-l-4 border-teal-400"></span>
                <span class="absolute bottom-8 right-8 h-10 w-10 rounded-br-xl border-b-4 border-r-4 border-teal-400"></span>
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="rounded-xl bg-white p-3 shadow-2xl" style="width:52%">
                        <div class="aspect-square w-full" x-html="kioskNext ? qrSvg('murid-' + kioskNext.id) : ''"></div>
                        <p class="mt-1.5 truncate text-center text-[10px] font-semibold text-gray-800" x-text="kioskNext ? kioskNext.name : 'Semua telah diimbas'"></p>
                    </div>
                </div>
                <span class="scan-line absolute left-8 right-8 h-0.5 rounded-full bg-teal-400" style="box-shadow:0 0 16px 3px rgba(45,212,191,.7)"></span>
            </div>
            <button type="button" x-on:click="kioskScan()" :disabled="!kioskNext" class="mt-6 inline-flex items-center gap-2 rounded-xl bg-teal-500 px-6 py-3 text-base font-bold text-slate-950 shadow-lg shadow-teal-500/30 hover:bg-teal-400 disabled:opacity-50"><svg class="h-5 w-5" aria-hidden="true"><use href="#i-qr"/></svg>Simulasi Imbasan</button>
        </div>
        <div class="rounded-2xl border border-white/10 bg-white/5 p-5">
            <div class="flex items-end justify-between">
                <div><p class="text-sm text-slate-400">Sudah diimbas hari ini</p><p class="text-4xl font-extrabold"><span x-text="kiosk.scanned.length"></span><span class="text-xl text-slate-400" x-text="' / ' + kioskStudents.length"></span></p></div>
                <p class="text-3xl font-bold tabular-nums text-teal-300" x-text="clock"></p>
            </div>
            <div class="mt-4 h-2 rounded-full bg-white/10"><div class="bar-grow h-2 rounded-full bg-teal-400" :style="'width:' + (kioskStudents.length ? kiosk.scanned.length / kioskStudents.length * 100 : 0) + '%'"></div></div>
            <ul class="thin-scroll mt-5 max-h-80 space-y-2 overflow-y-auto">
                <template x-for="sc in kiosk.scanned" :key="sc.id">
                    <li class="pop-in flex items-center justify-between rounded-xl bg-white/5 px-4 py-3"><span class="flex items-center gap-3"><span class="flex h-7 w-7 items-center justify-center rounded-full bg-green-500 text-white"><svg class="h-4 w-4" aria-hidden="true"><use href="#i-check"/></svg></span><span class="text-sm font-medium" x-text="sc.name"></span></span><span class="text-sm font-semibold text-green-300" x-text="'Hadir ' + sc.time"></span></li>
                </template>
                <li x-show="kiosk.scanned.length === 0" class="rounded-xl border border-dashed border-white/15 px-4 py-6 text-center text-sm text-slate-400">Belum ada imbasan. Tekan “Simulasi Imbasan”.</li>
            </ul>
        </div>
    </div>
    <!-- Animasi imbasan berjaya -->
    <div x-show="kiosk.show" x-transition.opacity class="fixed inset-0 z-10 flex items-center justify-center bg-slate-950/80" aria-live="assertive">
        <template x-if="kiosk.show && kiosk.last">
            <div class="pop-in flex flex-col items-center text-center">
                <span class="flex h-28 w-28 items-center justify-center rounded-full bg-green-500 text-white shadow-2xl shadow-green-500/40"><svg class="h-16 w-16" aria-hidden="true"><use href="#i-check"/></svg></span>
                <p class="mt-6 text-sm font-semibold uppercase tracking-[0.3em] text-green-300">Imbasan berjaya</p>
                <p class="mt-2 text-3xl font-extrabold" x-text="kiosk.last.name"></p>
                <p class="mt-1 text-lg text-slate-300" x-text="'Hadir · ' + kiosk.last.time"></p>
            </div>
        </template>
    </div>
</div>

<!-- =====================================================================
     TOAST
     ===================================================================== -->
<div class="no-print fixed bottom-4 right-4 z-[90] flex flex-col gap-2" style="width:min(380px, calc(100% - 2rem))" aria-live="polite">
    <template x-for="t in toasts" :key="t.id">
        <div class="pop-in flex items-start gap-3 rounded-xl border p-4 shadow-lg" :class="{ success: 'border-green-200 bg-green-50 text-green-800', error: 'border-red-200 bg-red-50 text-red-800', info: 'border-blue-200 bg-blue-50 text-blue-800' }[t.type]" role="status">
            <svg class="mt-0.5 h-5 w-5 shrink-0" aria-hidden="true"><use :href="t.type === 'success' ? '#i-check-circle' : (t.type === 'error' ? '#i-warn' : '#i-info')"/></svg>
            <p class="flex-1 text-sm font-medium" x-text="t.msg"></p>
            <button type="button" x-on:click="toasts = toasts.filter(x => x.id !== t.id)" class="shrink-0 opacity-70 hover:opacity-100" aria-label="Tutup"><svg class="h-4 w-4" aria-hidden="true"><use href="#i-x"/></svg></button>
        </div>
    </template>
</div>

<!-- =====================================================================
     LAWATAN BERPANDU (5 langkah)
     ===================================================================== -->
<div x-show="tour.on" x-cloak class="no-print fixed inset-0 z-[80]">
    <div x-show="!tour.box" class="absolute inset-0" style="background:rgba(15,23,42,.55)"></div>
    <div x-show="tour.box" class="pointer-events-none absolute rounded-xl ring-2 ring-blue-400 transition-all duration-300"
         :style="tour.box ? 'top:' + tour.box.top + 'px;left:' + tour.box.left + 'px;width:' + tour.box.width + 'px;height:' + tour.box.height + 'px;box-shadow:0 0 0 9999px rgba(15,23,42,.55)' : ''"></div>
    <div class="absolute rounded-xl bg-white p-5 shadow-2xl transition-all duration-300" :style="'top:' + tour.pop.top + 'px;left:' + tour.pop.left + 'px;width:' + tour.pop.w + 'px'" role="dialog" aria-modal="true" aria-labelledby="tour-title">
        <p class="text-xs font-semibold text-blue-700" x-text="'Langkah ' + (tour.step + 1) + ' daripada ' + TOUR.length"></p>
        <h3 id="tour-title" class="mt-1 text-base font-bold text-gray-900" x-text="TOUR[tour.step].t"></h3>
        <p class="mt-1.5 text-sm text-gray-600" x-text="TOUR[tour.step].d"></p>
        <div class="mt-4 flex items-center justify-between gap-2">
            <div class="flex gap-1.5" aria-hidden="true"><template x-for="(s, i) in TOUR" :key="i"><span class="h-1.5 rounded-full transition-all" :class="i === tour.step ? 'w-5 bg-blue-600' : 'w-1.5 bg-gray-300'"></span></template></div>
            <div class="flex items-center gap-2">
                <button type="button" x-on:click="endTour()" class="rounded-lg px-3 py-1.5 text-sm font-medium text-gray-600 hover:bg-gray-100">Langkau</button>
                <button type="button" x-show="tour.step < TOUR.length - 1" x-on:click="tourGo(tour.step + 1)" class="rounded-lg bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700">Seterusnya</button>
                <button type="button" x-show="tour.step === TOUR.length - 1" x-on:click="endTour()" class="rounded-lg bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700">Mula Meneroka</button>
            </div>
        </div>
    </div>
</div>

<script>
/* =====================================================================
   eKafa Online — DEMO
   Semua data di bawah ialah data contoh. Tiada backend; perubahan hanya
   dalam memori dan hilang bila "Set Semula Demo" atau muat semula halaman.
   ===================================================================== */

/* ---------- Utiliti ---------- */
function rng(seed) { return function () { seed |= 0; seed = seed + 0x6D2B79F5 | 0; var t = Math.imul(seed ^ seed >>> 15, 1 | seed); t = t + Math.imul(t ^ t >>> 7, 61 | t) ^ t; return ((t ^ t >>> 14) >>> 0) / 4294967296; }; }
function hashStr(s) { var h = 2166136261; for (var i = 0; i < s.length; i++) { h ^= s.charCodeAt(i); h = Math.imul(h, 16777619); } return h >>> 0; }
function pad(n, l) { return String(n).padStart(l || 2, '0'); }
function isoDate(d) { return d.getFullYear() + '-' + pad(d.getMonth() + 1) + '-' + pad(d.getDate()); }
function addDays(iso, n) { var d = new Date(iso + 'T00:00:00'); d.setDate(d.getDate() + n); return isoDate(d); }
function clamp(v, a, b) { return Math.max(a, Math.min(b, v)); }

var TODAY = isoDate(new Date());
var HARI = ['Ahad', 'Isnin', 'Selasa', 'Rabu', 'Khamis', 'Jumaat', 'Sabtu'];
var HARI_S = ['Ahd', 'Isn', 'Sel', 'Rab', 'Kha', 'Jum', 'Sab'];
var BULAN = ['Januari', 'Februari', 'Mac', 'April', 'Mei', 'Jun', 'Julai', 'Ogos', 'September', 'Oktober', 'November', 'Disember'];
var BULAN_S = ['Jan', 'Feb', 'Mac', 'Apr', 'Mei', 'Jun', 'Jul', 'Ogo', 'Sep', 'Okt', 'Nov', 'Dis'];

/* ---------- Pelan & modul (sepadan config/plans.php) ---------- */
var PLANS = {
    free:     { label: 'Percuma',  price: 0,  rank: 0 },
    personal: { label: 'Personal', price: 19, rank: 1 },
    sekolah:  { label: 'Sekolah',  price: 49, rank: 2 }
};
var STAFF = ['gb', 'guru'];
var MODULES = [
    { key: 'dashboard',       label: 'Dashboard',               icon: 'grid',         plan: 'free',     group: 'Utama',          roles: STAFF },
    { key: 'kelas',           label: 'Kelas',                   icon: 'school',       plan: 'free',     group: 'Modul Asas',     roles: STAFF },
    { key: 'murid',           label: 'Murid',                   icon: 'users',        plan: 'free',     group: 'Modul Asas',     roles: STAFF },
    { key: 'kehadiran',       label: 'Kehadiran Harian',        icon: 'check-circle', plan: 'free',     group: 'Modul Asas',     roles: STAFF },
    { key: 'jadual_waktu',    label: 'Jadual Waktu',            icon: 'calendar',     plan: 'free',     group: 'Modul Asas',     roles: STAFF },
    { key: 'peperiksaan',     label: 'Peperiksaan & Markah',    icon: 'clipboard',    plan: 'free',     group: 'Modul Asas',     roles: STAFF },
    { key: 'kehadiran_qr',    label: 'Kehadiran QR / Kiosk',    icon: 'qr',           plan: 'personal', group: 'Modul Personal', roles: STAFF },
    { key: 'import_murid',    label: 'Import Murid (Excel)',    icon: 'upload',       plan: 'personal', group: 'Modul Personal', roles: STAFF },
    { key: 'rph',             label: 'Rekod RPH',               icon: 'doc',          plan: 'personal', group: 'Modul Personal', roles: STAFF },
    { key: 'pencapaian',      label: 'Rekod Pencapaian Murid',  icon: 'trophy',       plan: 'personal', group: 'Modul Personal', roles: STAFF },
    { key: 'disiplin',        label: 'Disiplin Murid',          icon: 'flag',         plan: 'personal', group: 'Modul Personal', roles: STAFF },
    { key: 'aktiviti',        label: 'Aktiviti',                icon: 'star',         plan: 'personal', group: 'Modul Personal', roles: STAFF },
    { key: 'sijil',           label: 'Sijil Digital',           icon: 'academic',     plan: 'personal', group: 'Modul Personal', roles: STAFF },
    { key: 'laporan_murid',   label: 'Laporan Murid',           icon: 'printer',      plan: 'personal', group: 'Modul Personal', roles: STAFF },
    { key: 'chatbot',         label: 'Pembantu AI',             icon: 'sparkles',     plan: 'personal', group: 'Modul Personal', roles: STAFF },
    { key: 'pengguna',        label: 'Urus Guru & Pengguna',    icon: 'user-plus',    plan: 'sekolah',  group: 'Modul Sekolah',  roles: ['gb'] },
    { key: 'kelulusan_rph',   label: 'Semakan & Kelulusan RPH', icon: 'doc-check',    plan: 'sekolah',  group: 'Modul Sekolah',  roles: ['gb'] },
    { key: 'laporan_sekolah', label: 'Laporan & KPI Sekolah',   icon: 'presentation', plan: 'sekolah',  group: 'Modul Sekolah',  roles: ['gb'] },
    { key: 'kewangan',        label: 'Kewangan',                icon: 'banknotes',    plan: 'sekolah',  group: 'Modul Sekolah',  roles: ['gb'] },
    { key: 'hebahan',         label: 'Hebahan Sekolah',         icon: 'megaphone',    plan: 'sekolah',  group: 'Modul Sekolah',  roles: STAFF },
    { key: 'portal_ibu_bapa', label: 'Portal Ibu Bapa',         icon: 'phone',        plan: 'sekolah',  group: 'Modul Sekolah',  roles: ['gb'] },
    { key: 'pindah_murid',    label: 'Pindah Murid',            icon: 'arrows',       plan: 'sekolah',  group: 'Modul Sekolah',  roles: ['gb'] },
    { key: 'langganan',       label: 'Langganan',               icon: 'card',         plan: 'free',     group: 'Akaun',          roles: ['gb'] },
    { key: 'parent_home',     label: 'Laman Anak Saya',         icon: 'home',         plan: 'sekolah',  group: 'Portal Ibu Bapa', roles: ['parent'] }
];

/* ---------- Data rujukan ---------- */
var SUBJECTS = ['Al-Quran', 'Lughatul Quran', 'Ibadat', 'Akidah', 'Sirah', 'Adab', 'Jawi dan Khat'];
var SUBJ_SHORT = ['QURAN', 'LQ', 'IBADAT', 'AKIDAH', 'SIRAH', 'ADAB', 'JAWI'];
var SUBJ_COLORS = [
    { bg: '#DBEAFE', fg: '#1E40AF' }, { bg: '#E0E7FF', fg: '#3730A3' }, { bg: '#CCFBF1', fg: '#115E59' },
    { bg: '#FEF3C7', fg: '#92400E' }, { bg: '#FCE7F3', fg: '#9D174D' }, { bg: '#DCFCE7', fg: '#166534' }, { bg: '#F3E8FF', fg: '#6B21A8' }
];
var STATUS = [
    { k: 'H', label: 'Hadir',       on: 'border-green-700 bg-green-700 text-white' },
    { k: 'L', label: 'Lewat',       on: 'border-amber-500 bg-amber-100 text-amber-900' },
    { k: 'T', label: 'Tidak Hadir', on: 'border-red-600 bg-red-600 text-white' },
    { k: 'C', label: 'Cuti',        on: 'border-gray-600 bg-gray-600 text-white' }
];
var SURAH = ['An-Nas', 'Al-Falaq', 'Al-Ikhlas', 'Al-Masad', 'An-Nasr', 'Al-Kafirun', 'Al-Kauthar', 'Al-Maun', 'Quraisy', 'Al-Fil', 'Al-Humazah', 'Al-Asr', 'At-Takathur', 'Al-Qariah', 'Al-Adiyat', 'Az-Zalzalah', 'Al-Bayyinah', 'Al-Qadr', 'Al-Alaq', 'At-Tin', 'Asy-Syarh', 'Ad-Duha', 'Al-Lail', 'Asy-Syams', 'Al-Balad', 'Al-Fajr', 'Al-Ghasyiyah', 'Al-Ala', 'At-Tariq', 'Al-Buruj', 'Al-Insyiqaq', 'Al-Mutaffifin', 'Al-Infitar', 'At-Takwir', 'Abasa', 'An-Naziat', 'An-Naba'];
var BACAAN = ['Iqra 1', 'Iqra 2', 'Iqra 3', 'Iqra 4', 'Iqra 5', 'Iqra 6', 'Al-Quran Juz 1', 'Al-Quran Juz 2', 'Al-Quran Juz 3', 'Al-Quran Juz 4', 'Al-Quran Juz 5'];
var JAWI_LV = ['Perlu Bimbingan', 'Sederhana', 'Baik', 'Cemerlang'];
var DIS_CAT = {
    demerit: [{ n: 'Lewat hadir', p: -2 }, { n: 'Tidak siap kerja rumah', p: -3 }, { n: 'Tidak berpakaian kemas', p: -2 }, { n: 'Ponteng kelas', p: -5 }, { n: 'Bergaduh', p: -10 }],
    merit:   [{ n: 'Membantu guru', p: 3 }, { n: 'Murid contoh mingguan', p: 5 }, { n: 'Johan pertandingan', p: 10 }]
};
var DIS_ACT = ['Nasihat', 'Amaran lisan', 'Amaran bertulis', 'Panggil ibu bapa', 'Penghargaan'];
var FIN_CAT = { masuk: ['Yuran Bulanan', 'Bantuan Kerajaan', 'Sumbangan PIBG'], keluar: ['Bil Utiliti', 'Penyelenggaraan', 'Gaji Guru Tambahan', 'Program Sekolah'] };
var TARGET = { semua: 'Semua', guru: 'Guru', ibubapa: 'Ibu Bapa' };
var SCHOOLS = ['KAFA An-Nur, Sitiawan', 'KAFA Al-Ikhlas, Lumut', 'KAFA Ar-Rahman, Ayer Tawar', 'KAFA Darul Ehsan, Pantai Remis', 'KAFA Al-Falah, Ipoh'];
var DAYS = ['Isnin', 'Selasa', 'Rabu', 'Khamis', 'Jumaat'];
var SLOTS = [{ t: '14:30 – 15:15', i: 0 }, { t: '15:15 – 16:00', i: 1 }, { t: '16:00 – 16:15', i: -1 }, { t: '16:15 – 17:00', i: 2 }, { t: '17:00 – 17:30', i: 3 }];
var CERT_TPL = {
    penghargaan: { t: 'Sijil Penghargaan',     j: 'سيجيل ڤڠهرڬاءن', line: 'atas penglibatan cemerlang dalam' },
    penyertaan:  { t: 'Sijil Penyertaan',      j: 'سيجيل ڤڽرتاءن',  line: 'atas penyertaan dalam' },
    khatam:      { t: 'Sijil Khatam Al-Quran', j: 'سيجيل خاتم القرءان', line: 'kerana telah berjaya mengkhatamkan Al-Quran sempena' }
};
var IMP_ROWS = [
    { name: 'Aqil Hakimi bin Rosli',       mykid: '170512081233', gender: 'L', guardian: 'Rosli bin Ahmad' },
    { name: 'Nur Raihana binti Shamsul',   mykid: '170823080456', gender: 'P', guardian: 'Shamsul bin Daud' },
    { name: 'Muhammad Khalish bin Azlan',  mykid: '170204081517', gender: 'L', guardian: 'Azlan bin Musa' },
    { name: 'Aleya Sumayyah binti Hakim',  mykid: '171109080782', gender: 'P', guardian: 'Hakim bin Othman' },
    { name: 'Umar Al-Fateh bin Firdaus',   mykid: '170630081919', gender: 'L', guardian: 'Firdaus bin Salleh' }
];
var CHAT_SUGGEST = ['Berapa murid tidak hadir hari ini?', 'Apakah purata markah PAT ikut subjek?', 'Cadangkan aktiviti RPH untuk subjek Adab', 'Berapa jumlah murid lelaki dan perempuan?'];
var TOUR = [
    { sel: '#tour-stats', t: 'Dashboard', d: 'Ringkasan sekolah anda — jumlah murid, kehadiran hari ini, kelas dan guru — dalam satu pandangan.' },
    { sel: '#nav-kehadiran', nav: true, t: 'Kehadiran Harian', d: 'Tanda kehadiran setiap kelas dengan satu klik. Cuba butang “Tanda Semua Hadir”.' },
    { sel: '#nav-peperiksaan', nav: true, t: 'Peperiksaan & Markah', d: 'Masukkan markah — jumlah, gred dan kedudukan dalam kelas dikira secara automatik.' },
    { sel: '[data-tour="role"]', t: 'Tukar Peranan & Pelan', d: 'Lihat sistem sebagai Guru Besar, Guru KAFA atau Ibu Bapa, dan bandingkan modul setiap pelan.' },
    { sel: '[data-tour="daftar"]', t: 'Sedia bermula?', d: 'Daftar percuma — 3 kelas tanpa had masa, tiada kad kredit diperlukan.' }
];

var MALE = ['Ahmad Zayyad', 'Muhammad Haziq', 'Adam Rayyan', 'Muhammad Aqil', 'Umar Firdaus', 'Muhammad Danish', 'Harith Iskandar', 'Muhammad Irfan', 'Aiman Hakimi', 'Muhammad Faris', 'Luqman Hakim', 'Muhammad Rifqi', 'Ilham Mukhriz', 'Muhammad Syafiq', 'Hafiy Uwais', 'Muhammad Naufal', 'Ariff Zikri', 'Muhammad Aidil', 'Zafran Hadi', 'Muhammad Amsyar'];
var FEMALE = ['Aisyah Humaira', 'Nur Aleesya', 'Nur Qaisara', 'Siti Hajar', 'Nur Damia', 'Alya Natasha', 'Nur Insyirah', 'Sofea Maisarah', 'Nur Iman', 'Hannah Sumayyah', 'Nur Aqilah', 'Fatimah Az-Zahra', 'Nur Hidayah', 'Balqis Safiyya', 'Nur Syuhada', 'Irdina Sofea', 'Nur Adlina', 'Khadijah Raudhah', 'Nur Batrisyia', 'Nur Arissa'];
var FATHERS = ['Rahman', 'Ismail', 'Azman', 'Hafizuddin', 'Roslan', 'Zulkifli', 'Faizal', 'Shahrul', 'Nizam', 'Hisyam', 'Kamarul', 'Anuar', 'Rizal', 'Syukri', 'Zainal', 'Fadzil', 'Hairul', 'Mazlan', 'Saiful', 'Rosli'];
var GRAND = ['Hassan', 'Ibrahim', 'Yusof', 'Abdullah', 'Othman', 'Ahmad', 'Salleh', 'Daud', 'Mohd Noor', 'Jaafar', 'Ali', 'Musa'];

/* ---------- QR palsu (corak rawak + 3 penanda sudut) ---------- */
var QR_CACHE = {};
function qrSvg(seedStr) {
    if (QR_CACHE[seedStr]) return QR_CACHE[seedStr];
    var n = 25, r = rng(hashStr(seedStr)), cells = '';
    function inFinder(x, y) { return (x < 8 && y < 8) || (x >= n - 8 && y < 8) || (x < 8 && y >= n - 8); }
    for (var y = 0; y < n; y++) for (var x = 0; x < n; x++) { if (!inFinder(x, y) && r() < 0.5) cells += '<rect x="' + x + '" y="' + y + '" width="1" height="1"/>'; }
    function finder(x, y) { return '<rect x="' + x + '" y="' + y + '" width="7" height="7"/><rect x="' + (x + 1) + '" y="' + (y + 1) + '" width="5" height="5" fill="#fff"/><rect x="' + (x + 2) + '" y="' + (y + 2) + '" width="3" height="3"/>'; }
    var svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="-1 -1 ' + (n + 2) + ' ' + (n + 2) + '" shape-rendering="crispEdges" style="width:100%;height:100%;display:block" aria-hidden="true"><rect x="-1" y="-1" width="' + (n + 2) + '" height="' + (n + 2) + '" fill="#fff"/><g fill="#0F172A">' + cells + finder(0, 0) + finder(n - 7, 0) + finder(0, n - 7) + '</g></svg>';
    QR_CACHE[seedStr] = svg;
    return svg;
}

/* ---------- Jana data contoh ---------- */
function genAtt(students, cid, date) {
    var r = rng(hashStr(cid + '|' + date)), o = {};
    students.filter(function (s) { return s.classId === cid; }).forEach(function (s) {
        var x = r(); o[s.id] = x < 0.9 ? 'H' : x < 0.94 ? 'L' : x < 0.98 ? 'T' : 'C';
    });
    return o;
}

function buildSeed() {
    var r = rng(20261019);
    function pick(a) { return a[Math.floor(r() * a.length)]; }
    function shuffle(a) { for (var i = a.length - 1; i > 0; i--) { var j = Math.floor(r() * (i + 1)); var t = a[i]; a[i] = a[j]; a[j] = t; } return a; }

    var teachers = [
        { id: 1, name: 'Ustazah Nur Aisyah',    email: 'nuraisyah@alhidayah.edu.my',   role: 'Guru Besar', status: 'Aktif' },
        { id: 2, name: 'Ustaz Hafiz',           email: 'hafiz@alhidayah.edu.my',       role: 'Guru KAFA',  status: 'Aktif' },
        { id: 3, name: 'Ustazah Siti Khadijah', email: 'sitikhadijah@alhidayah.edu.my', role: 'Guru KAFA',  status: 'Aktif' },
        { id: 4, name: 'Ustaz Amirul',          email: 'amirul@alhidayah.edu.my',      role: 'Guru KAFA',  status: 'Aktif' }
    ];
    var classes = [
        { id: 1, name: 'Tahun 1 Al-Farabi',     year: 1, teacherId: 3 },
        { id: 2, name: 'Tahun 2 Ibnu Sina',     year: 2, teacherId: 4 },
        { id: 3, name: 'Tahun 3 Al-Ghazali',    year: 3, teacherId: 2 },
        { id: 4, name: 'Tahun 4 Ibnu Khaldun',  year: 4, teacherId: 2 },
        { id: 5, name: 'Tahun 5 Al-Khawarizmi', year: 5, teacherId: 1 }
    ];

    // Murid: 25 sekelas, nama tersusun ikut abjad
    var students = [], id = 1, kids = [];
    classes.forEach(function (c) {
        var males = shuffle(MALE.slice()), females = shuffle(FEMALE.slice()), mi = 0, fi = 0, arr = [];
        for (var i = 0; i < 25; i++) {
            var g = i % 2 === 0 ? 'L' : 'P';
            var first = g === 'L' ? males[mi++] : females[fi++];
            var fa = pick(FATHERS), gf = pick(GRAND);
            var by = 2026 - (6 + c.year), mm = 1 + Math.floor(r() * 12), dd = 1 + Math.floor(r() * 28);
            var last = 1000 + Math.floor(r() * 9000);
            if ((last % 2 === 1) !== (g === 'L')) last += (last < 9999 ? 1 : -1);
            arr.push({ name: first + (g === 'L' ? ' bin ' : ' binti ') + fa, gender: g, mykid: String(by).slice(2) + pad(mm) + pad(dd) + '08' + last, classId: c.id, guardian: fa + ' bin ' + gf, phone: '01' + pick(['1', '2', '3', '7', '9']) + '-' + (1000000 + Math.floor(r() * 8999999)) });
        }
        // Anak-anak akaun Ibu Bapa demo (Kamal bin Hassan)
        if (c.id === 2) { var f = arr.find(function (s) { return s.gender === 'P'; }); f.name = 'Nur Imanina binti Kamal'; f.guardian = 'Kamal bin Hassan'; f.phone = '012-4567890'; f.kid = true; }
        if (c.id === 5) { var m = arr.find(function (s) { return s.gender === 'L'; }); m.name = 'Muhammad Ammar bin Kamal'; m.guardian = 'Kamal bin Hassan'; m.phone = '012-4567890'; m.kid = true; }
        arr.sort(function (a, b) { return a.name.localeCompare(b.name); });
        arr.forEach(function (s) { s.id = id++; if (s.kid) { kids.push(s.id); } delete s.kid; students.push(s); });
    });

    // Kehadiran 45 hari terakhir
    var att = {};
    classes.forEach(function (c) { for (var i = 0; i < 45; i++) { var d = addDays(TODAY, -i); att[c.id + '|' + d] = genAtt(students, c.id, d); } });

    // Markah PPT & PAT + pencapaian
    var marks = { ppt: {}, pat: {} }, achv = {};
    students.forEach(function (s) {
        var c = classes.find(function (x) { return x.id === s.classId; });
        var ab = kids.indexOf(s.id) >= 0 ? 86 : 52 + r() * 42;
        ['ppt', 'pat'].forEach(function (e, ei) { marks[e][s.id] = SUBJECTS.map(function () { return clamp(Math.round(ab + (r() - 0.5) * 22 + (ei ? 3 : 0)), 28, 100); }); });
        achv[s.id] = { haf: clamp(c.year * 6 + Math.floor(r() * 8) - 4, 0, 36), bac: clamp([0, 2, 4, 6, 7][c.year - 1] + Math.floor(r() * 3), 0, 10), jawi: clamp(Math.floor(ab / 100 * 4 + r() * 1.2 - 0.3), 0, 3) };
    });

    function S(i) { return students[i].id; }
    var rphs = [
        { id: 1, date: addDays(TODAY, -3), classId: 4, subject: 'Jawi dan Khat', teacherId: 2, jawi: true, status: 'Dihantar', ulasan: '',
          objektif: 'موريد داڤت مڽبوت دان منوليس حروف جاوي برسمبوڠ دڠن بتول.', aktiviti: 'ڬورو منونجوقکن چارا منوليس د ڤاڤن ڤوتيه، موريد ممبوات لاتيهن دالم بوکو.', refleksi: '٢٢ درڤد ٢٥ موريد منچاڤاي اوبجيکتيف.' },
        { id: 2, date: addDays(TODAY, -2), classId: 3, subject: 'Al-Quran', teacherId: 2, jawi: false, status: 'Diluluskan', ulasan: 'Bagus. Teruskan kaedah talaqqi berpasangan.',
          objektif: 'Murid dapat membaca Surah Al-Kafirun dengan tajwid yang betul.', aktiviti: 'Talaqqi musyafahah ayat 1–6, bacaan berpasangan dan latih tubi hukum mad asli.', refleksi: '20 daripada 25 murid menguasai bacaan dengan baik.' },
        { id: 3, date: addDays(TODAY, -1), classId: 1, subject: 'Akidah', teacherId: 3, jawi: false, status: 'Dihantar', ulasan: '',
          objektif: 'Murid dapat menyebut enam Rukun Iman dengan betul dan tertib.', aktiviti: 'Nyanyian Rukun Iman, kad imbasan dan permainan susun kad mengikut tertib.', refleksi: 'Semua murid dapat menyebut Rukun Iman; 4 murid perlu bimbingan tertib.' },
        { id: 4, date: addDays(TODAY, -1), classId: 2, subject: 'Adab', teacherId: 4, jawi: false, status: 'Dihantar', ulasan: '',
          objektif: 'Murid dapat mengamalkan adab makan dan minum mengikut sunnah.', aktiviti: 'Tayangan video pendek, main peranan adab makan bersama keluarga.', refleksi: 'Murid seronok dengan aktiviti main peranan.' },
        { id: 5, date: addDays(TODAY, -4), classId: 5, subject: 'Sirah', teacherId: 1, jawi: false, status: 'Diluluskan', ulasan: 'Diluluskan.',
          objektif: 'Murid dapat menceritakan peristiwa hijrah Rasulullah ﷺ ke Madinah.', aktiviti: 'Bercerita dengan peta, kuiz berkumpulan dan lukisan garis masa.', refleksi: 'Murid dapat menyusun peristiwa mengikut urutan.' },
        { id: 6, date: TODAY, classId: 4, subject: 'Ibadat', teacherId: 2, jawi: false, status: 'Draf', ulasan: '',
          objektif: 'Murid dapat menunjukkan cara berwuduk dengan tertib.', aktiviti: 'Demonstrasi guru, amali berwuduk secara berkumpulan.', refleksi: '' },
        { id: 7, date: addDays(TODAY, -5), classId: 3, subject: 'Lughatul Quran', teacherId: 2, jawi: false, status: 'Dikembalikan', ulasan: 'Sila lengkapkan bahagian refleksi dan nyatakan bilangan murid yang menguasai.',
          objektif: 'Murid dapat memahami maksud 10 perkataan Al-Quran yang lazim.', aktiviti: 'Padanan kad perkataan dan maksud.', refleksi: '' },
        { id: 8, date: addDays(TODAY, -6), classId: 1, subject: 'Al-Quran', teacherId: 3, jawi: false, status: 'Diluluskan', ulasan: 'Baik.',
          objektif: 'Murid dapat mengenal huruf hijaiyah ba hingga kha.', aktiviti: 'Lagu huruf hijaiyah dan latihan menyentuh huruf timbul.', refleksi: '23 daripada 25 murid mengenal huruf dengan baik.' }
    ];

    var disiplin = [
        [-1, 30, 'demerit', 0, 'Nasihat'], [-2, 57, 'demerit', 1, 'Amaran lisan'], [-3, 80, 'demerit', 3, 'Panggil ibu bapa'], [-5, 101, 'demerit', 4, 'Amaran bertulis'],
        [-6, 12, 'demerit', 2, 'Nasihat'], [-2, 64, 'merit', 0, 'Penghargaan'], [-4, 110, 'merit', 2, 'Penghargaan'], [-7, 40, 'merit', 1, 'Penghargaan'],
        [-8, 95, 'demerit', 0, 'Nasihat'], [-9, 18, 'merit', 0, 'Penghargaan'], [-10, 77, 'demerit', 1, 'Nasihat'], [-12, 3, 'merit', 1, 'Penghargaan']
    ].map(function (d, i) { var c = DIS_CAT[d[2]][d[3]]; return { id: i + 1, date: addDays(TODAY, d[0]), sid: S(d[1]), type: d[2], kategori: c.n, tindakan: d[4], mata: c.p }; });

    function ids(cid, n) { return students.filter(function (s) { return s.classId === cid; }).slice(0, n).map(function (s) { return s.id; }); }
    var aktiviti = [
        { id: 1, name: 'Majlis Khatam Al-Quran 2026', date: '2026-11-14', tempat: 'Dewan Serbaguna KAFA', peserta: ids(5, 12) },
        { id: 2, name: 'Pertandingan Tilawah Peringkat Sekolah', date: '2026-08-22', tempat: 'Surau KAFA Al-Hidayah', peserta: ids(3, 3).concat(ids(4, 4), ids(5, 3)) },
        { id: 3, name: 'Hari Sukan KAFA', date: '2026-07-11', tempat: 'Padang Taman Seri Manjung', peserta: ids(3, 14).concat(ids(4, 13), ids(5, 13)) },
        { id: 4, name: 'Kem Bestari Solat', date: '2026-06-20', tempat: 'Surau KAFA Al-Hidayah', peserta: ids(1, 25).concat(ids(2, 25)) },
        { id: 5, name: 'Gotong-royong Ceria Kelas', date: '2026-09-26', tempat: 'Kawasan Sekolah', peserta: ids(4, 25) }
    ];

    // Kewangan: 6 bulan terakhir
    var trans = [], tid = 1, now = new Date();
    for (var k = 5; k >= 0; k--) {
        var md = new Date(now.getFullYear(), now.getMonth() - k, 1), ym = md.getFullYear() + '-' + pad(md.getMonth() + 1), idx = 5 - k;
        var add = function (day, type, kat, amt, ket) { var dt = ym + '-' + pad(day); if (dt <= TODAY) trans.push({ id: tid++, date: dt, type: type, kategori: kat, amaun: amt, ket: ket }); };
        add(5, 'masuk', 'Yuran Bulanan', 1050 + Math.round(r() * 20) * 10, 'Kutipan yuran ' + BULAN[md.getMonth()]);
        add(15, 'keluar', 'Bil Utiliti', 160 + Math.round(r() * 8) * 10, 'Bil elektrik & air');
        add(28, 'keluar', 'Gaji Guru Tambahan', 800, 'Elaun guru ganti');
        if (idx === 1 || idx === 4) add(10, 'masuk', 'Bantuan Kerajaan', 3000, 'Geran per kapita murid');
        if (idx === 2) { add(18, 'masuk', 'Sumbangan PIBG', 850, 'Sumbangan PIBG untuk Hari Sukan'); add(12, 'keluar', 'Program Sekolah', 1200, 'Hari Sukan KAFA'); }
        if (idx === 3) add(20, 'keluar', 'Penyelenggaraan', 650, 'Baiki kipas & lampu kelas');
        if (idx === 4) add(22, 'keluar', 'Program Sekolah', 480, 'Pertandingan Tilawah');
    }

    var hebahan = [
        { id: 1, title: 'Mesyuarat Agung PIBG 2026', target: 'semua', date: addDays(TODAY, -2), by: 'Ustazah Nur Aisyah', body: 'Semua ibu bapa dijemput hadir ke Mesyuarat Agung PIBG pada hari Sabtu ini jam 9:00 pagi di Dewan Serbaguna KAFA.' },
        { id: 2, title: 'Mesyuarat Guru Mingguan', target: 'guru', date: addDays(TODAY, -1), by: 'Ustazah Nur Aisyah', body: 'Mesyuarat guru pada hari Khamis jam 2:00 petang. Kelas bermula jam 3:00 petang pada hari tersebut.' },
        { id: 3, title: 'Peperiksaan Akhir Tahun (PAT)', target: 'ibubapa', date: addDays(TODAY, -8), by: 'Ustazah Nur Aisyah', body: 'Keputusan PAT boleh disemak di Portal Ibu Bapa. Terima kasih atas sokongan ibu bapa sepanjang tahun.' },
        { id: 4, title: 'Majlis Khatam Al-Quran', target: 'semua', date: addDays(TODAY, -10), by: 'Ustazah Nur Aisyah', body: 'Majlis Khatam Al-Quran murid Tahun 5 akan diadakan pada 14 November 2026. Ibu bapa dijemput hadir.' }
    ];

    var pindah = [{ id: 1, name: students[50].name, dest: 'KAFA An-Nur, Sitiawan', reason: 'Berpindah rumah', status: 'Diluluskan', date: addDays(TODAY, -12) }];
    var fees = [
        { id: 1, sid: kids[0], month: BULAN[now.getMonth()] + ' ' + now.getFullYear(), amount: 10, paid: false },
        { id: 2, sid: kids[1], month: BULAN[(now.getMonth() + 11) % 12] + ' ' + (now.getMonth() === 0 ? now.getFullYear() - 1 : now.getFullYear()), amount: 10, paid: false },
        { id: 3, sid: kids[1], month: BULAN[now.getMonth()] + ' ' + now.getFullYear(), amount: 10, paid: false }
    ];

    return { teachers: teachers, classes: classes, students: students, kids: kids, att: att, marks: marks, achv: achv, rphs: rphs, disiplin: disiplin, aktiviti: aktiviti, trans: trans, hebahan: hebahan, pindah: pindah, fees: fees, ttOverride: {},
             exams: [{ id: 'ppt', name: 'Peperiksaan Pertengahan Tahun (PPT)', date: '2026-05-20' }, { id: 'pat', name: 'Peperiksaan Akhir Tahun (PAT)', date: '2026-10-12' }] };
}

/* =====================================================================
   KOMPONEN ALPINE
   ===================================================================== */
function demoApp() {
    return {
        // pemalar untuk templat
        PLANS: PLANS, MODULES: MODULES, SUBJECTS: SUBJECTS, SUBJ_SHORT: SUBJ_SHORT, SUBJ_COLORS: SUBJ_COLORS, STATUS: STATUS, SURAH: SURAH, BACAAN: BACAAN, JAWI_LV: JAWI_LV,
        DIS_CAT: DIS_CAT, DIS_ACT: DIS_ACT, FIN_CAT: FIN_CAT, TARGET: TARGET, SCHOOLS: SCHOOLS, DAYS: DAYS, SLOTS: SLOTS, CERT_TPL: CERT_TPL, IMP_ROWS: IMP_ROWS,
        CHAT_SUGGEST: CHAT_SUGGEST, TOUR: TOUR, TODAY: TODAY, BULAN_S: BULAN_S,

        // keadaan UI
        role: 'gb', plan: 'sekolah', page: 'dashboard', drawer: false, modal: null, form: {}, toasts: [], upsell: null, delTarget: null,
        profilId: null, q: '', fClass: 0, pg: { murid: 1, rph: 1, kewangan: 1, disiplin: 1 },
        attClass: 1, attDate: TODAY, ttClass: 1, examId: 'pat', examClass: 1, rphStatus: '', pcClass: 1, finFilter: '',
        cert: { sid: 1, tpl: 'penghargaan', act: 1 }, lm: { classId: 1, sid: 1, exam: 'pat' }, pf: { cid: 1, sid: 1, dest: SCHOOLS[0], reason: 'Berpindah rumah' },
        chat: [], chatInput: '', typing: false, clock: '',
        kiosk: { open: false, classId: 1, scanned: [], last: null, show: false },
        imp: { step: 0, file: '', classId: 1 }, pChild: 0,
        tour: { on: false, step: 0, box: null, pop: { top: 0, left: 0, w: 300 } },

        // data (diisi oleh seed)
        teachers: [], classes: [], students: [], kids: [], att: {}, marks: {}, achv: {}, rphs: [], disiplin: [], aktiviti: [], trans: [], hebahan: [], pindah: [], fees: [], exams: [], ttOverride: {},

        boot() {
            this.seed();
            var self = this;
            this.tick(); setInterval(function () { self.tick(); }, 15000);
            setTimeout(function () { self.startTour(); }, 700);
        },
        seed() {
            var d = buildSeed(), self = this;
            Object.keys(d).forEach(function (k) { self[k] = d[k]; });
            this.fixSelections();
        },
        tick() { var n = new Date(); this.clock = pad(n.getHours()) + ':' + pad(n.getMinutes()); },
        resetDemo() {
            this.role = 'gb'; this.plan = 'sekolah'; this.page = 'dashboard'; this.modal = null; this.drawer = false;
            this.q = ''; this.fClass = 0; this.pg = { murid: 1, rph: 1, kewangan: 1, disiplin: 1 }; this.rphStatus = ''; this.finFilter = '';
            this.chat = []; this.imp = { step: 0, file: '', classId: 1 }; this.pChild = 0; this.attDate = TODAY;
            this.seed();
            window.scrollTo({ top: 0 });
            this.toast('Demo telah ditetapkan semula', 'info');
        },

        /* ---------- Peranan, pelan & navigasi ---------- */
        get planRank() { return PLANS[this.plan].rank; },
        get user() {
            if (this.role === 'gb') return { name: 'Ustazah Nur Aisyah', initials: 'NA' };
            if (this.role === 'guru') return { name: 'Ustaz Hafiz', initials: 'UH' };
            return { name: 'Kamal bin Hassan', initials: 'KH' };
        },
        get roleLabel() {
            if (this.role === 'gb') return this.plan === 'personal' ? 'Guru (Personal)' : 'Guru Besar';
            return this.role === 'guru' ? 'Guru KAFA' : 'Ibu Bapa';
        },
        get navGroups() {
            var groups = [], role = this.role;
            MODULES.filter(function (m) { return m.roles.indexOf(role) >= 0; }).forEach(function (m) {
                var g = groups.find(function (x) { return x.title === m.group; });
                if (!g) { g = { title: m.group, items: [] }; groups.push(g); }
                g.items.push(m);
            });
            return groups;
        },
        get activeNav() { return this.page === 'profil' ? 'murid' : this.page; },
        get pageTitle() { if (this.page === 'profil') return 'Profil Murid'; var p = this.page, m = MODULES.find(function (x) { return x.key === p; }); return m ? m.label : ''; },
        locked(key) { var m = MODULES.find(function (x) { return x.key === key; }); return m ? PLANS[m.plan].rank > this.planRank : false; },
        go(key) {
            if (this.locked(key)) { this.openUpsell(key); this.drawer = false; return; }
            this.page = key; this.drawer = false; this.fixSelections();
            window.scrollTo({ top: 0 });
        },
        setPlan(p) {
            this.plan = p;
            if (this.page !== 'parent_home' && this.locked(this.page)) this.page = 'dashboard';
            this.fixSelections();
            this.toast('Pelan demo kini: ' + PLANS[p].label, 'info');
        },
        switchRole() {
            this.page = this.role === 'parent' ? 'parent_home' : 'dashboard';
            this.drawer = false; this.modal = null; this.fixSelections();
            window.scrollTo({ top: 0 });
        },
        openUpsell(key, custom) {
            var m = MODULES.find(function (x) { return x.key === key; });
            this.upsell = custom || { title: m.label, plan: m.plan, text: 'Modul ' + m.label + ' tersedia mulai pelan ' + PLANS[m.plan].label + ' (RM' + PLANS[m.plan].price + '/bulan).' };
            this.modal = 'upsell';
        },
        get limitUpsell() { return { title: 'Had 3 kelas pelan Percuma', plan: 'personal', text: 'Pelan Percuma membenarkan sehingga 3 kelas dan 40 murid sekelas. Naik taraf untuk kelas dan murid tanpa had.' }; },
        upgradeDemo() { var p = this.upsell.plan; this.modal = null; this.setPlan(p); },
        planFeatures(p) { return MODULES.filter(function (m) { return m.plan === p && ['dashboard', 'langganan', 'parent_home'].indexOf(m.key) < 0; }).map(function (m) { return m.label; }); },
        get planModules() { return MODULES.filter(function (m) { return ['dashboard', 'langganan', 'parent_home'].indexOf(m.key) < 0; }); },

        /* ---------- Skop data ikut peranan & had pelan ---------- */
        get myClassIds() { return this.role === 'guru' ? this.classes.filter(function (c) { return c.teacherId === 2; }).map(function (c) { return c.id; }) : this.classes.map(function (c) { return c.id; }); },
        overLimit(c) { return this.plan === 'free' && this.classes.findIndex(function (x) { return x.id === c.id; }) >= 3; },
        get classesAvail() { var self = this, mine = this.myClassIds; return this.classes.filter(function (c) { return mine.indexOf(c.id) >= 0 && !self.overLimit(c); }); },
        get studentsAvail() { var ids = this.classesAvail.map(function (c) { return c.id; }); return this.students.filter(function (s) { return ids.indexOf(s.classId) >= 0; }); },
        firstStudent(cid) { var s = this.students.find(function (x) { return x.classId === cid; }); return s ? s.id : null; },
        fixSelections() {
            var av = this.classesAvail.map(function (c) { return c.id; }), first = av[0] || null, self = this;
            ['attClass', 'ttClass', 'examClass', 'pcClass'].forEach(function (k) { if (av.indexOf(self[k]) < 0) self[k] = first; });
            if (av.indexOf(this.lm.classId) < 0) this.lm.classId = first;
            if (!this.students.some(function (s) { return s.id === self.lm.sid && s.classId === self.lm.classId; })) this.lm.sid = this.firstStudent(this.lm.classId);
            if (av.indexOf(this.kiosk.classId) < 0) this.kiosk.classId = first;
            if (av.indexOf(this.imp.classId) < 0) this.imp.classId = first;
            if (av.indexOf(this.pf.cid) < 0) this.pf.cid = first;
            if (!this.students.some(function (s) { return s.id === self.pf.sid && s.classId === self.pf.cid; })) this.pf.sid = this.firstStudent(this.pf.cid);
            if (!this.studentsAvail.some(function (s) { return s.id === self.cert.sid; })) this.cert.sid = this.studentsAvail[0] ? this.studentsAvail[0].id : null;
            if (!this.aktiviti.some(function (a) { return a.id === self.cert.act; })) this.cert.act = this.aktiviti[0] ? this.aktiviti[0].id : null;
            if (this.fClass && av.indexOf(this.fClass) < 0) this.fClass = 0;
            if (this.pChild >= this.children.length) this.pChild = 0;
        },

        /* ---------- Helper paparan ---------- */
        cls(id) { return this.classes.find(function (c) { return c.id === id; }) || { name: '—', teacherId: null }; },
        stu(id) { return this.students.find(function (s) { return s.id === id; }); },
        stuName(id) { var s = this.stu(id); return s ? s.name : '(dipadam)'; },
        tName(id) { var t = this.teachers.find(function (x) { return x.id === id; }); return t ? t.name : '—'; },
        classCount(id) { return this.students.filter(function (s) { return s.classId === id; }).length; },
        fmtDate(iso) { if (!iso) return '—'; var d = new Date(iso + 'T00:00:00'); return d.getDate() + ' ' + BULAN_S[d.getMonth()] + ' ' + d.getFullYear(); },
        fmtLong(iso) { var d = new Date(iso + 'T00:00:00'); return HARI[d.getDay()] + ', ' + d.getDate() + ' ' + BULAN[d.getMonth()] + ' ' + d.getFullYear(); },
        rm(n) { return 'RM' + Number(n || 0).toLocaleString('en-MY', { minimumFractionDigits: 2, maximumFractionDigits: 2 }); },
        initials(name) { return String(name || '').replace(/^(Ustazah|Ustaz)\s+/, '').split(' ').filter(function (w) { return w && ['bin', 'binti', '(dipadam)'].indexOf(w) < 0; }).slice(0, 2).map(function (w) { return w[0]; }).join('').toUpperCase(); },
        dob(k) { return parseInt(k.slice(4, 6), 10) + ' ' + BULAN[parseInt(k.slice(2, 4), 10) - 1] + ' ' + (2000 + parseInt(k.slice(0, 2), 10)); },
        // Same scale as config/grading.php (via ExamService), highest grade first.
        gradeScale: @json(app(\App\Services\ExamService::class)->gradeScale()),
        grade(m) { var s = this.gradeScale; for (var i = 0; i < s.length; i++) { if (m >= s[i].min) return s[i].grade; } return s[s.length - 1].grade; },
        gradeCls(g) { return { A: 'bg-green-100 text-green-700', B: 'bg-blue-100 text-blue-700', C: 'bg-amber-100 text-amber-800', D: 'bg-red-100 text-red-700' }[g] || 'bg-gray-100 text-gray-500'; },
        statusCls(st) { return { Draf: 'bg-gray-100 text-gray-700', Dihantar: 'bg-amber-100 text-amber-800', Diluluskan: 'bg-green-100 text-green-700', Dikembalikan: 'bg-red-100 text-red-700' }[st]; },
        toast(msg, type) {
            var id = Date.now() + Math.random(), self = this;
            this.toasts.push({ id: id, msg: msg, type: type || 'success' });
            setTimeout(function () { self.toasts = self.toasts.filter(function (t) { return t.id !== id; }); }, 3800);
        },
        saved(prefix) { this.toast((prefix ? prefix + ' — ' : '') + 'Berjaya disimpan (demo — data tidak disimpan kekal)'); },

        /* ---------- Paginasi ---------- */
        pageCount(list) { return Math.max(1, Math.ceil(list.length / 10)); },
        paged(list, k) { var p = Math.min(this.pg[k], this.pageCount(list)); return list.slice((p - 1) * 10, p * 10); },
        pageNums(list, k) { var n = this.pageCount(list), cur = this.pg[k], s = Math.max(1, cur - 2), e = Math.min(n, s + 4), a = []; s = Math.max(1, e - 4); for (var i = s; i <= e; i++) a.push(i); return a; },
        rowNo(k, i) { return (this.pg[k] - 1) * 10 + i + 1; },
        pgFrom(list, k) { return list.length ? (Math.min(this.pg[k], this.pageCount(list)) - 1) * 10 + 1 : 0; },
        pgTo(list, k) { return Math.min(list.length, Math.min(this.pg[k], this.pageCount(list)) * 10); },

        /* ---------- Kehadiran ---------- */
        ensureAtt(cid, date) { if (!cid || !date) return; var k = cid + '|' + date; if (!this.att[k]) this.att[k] = genAtt(this.students, cid, date); },
        attStats(cids, date) {
            var h = 0, l = 0, t = 0, c = 0, self = this;
            cids.forEach(function (cid) { var rec = self.att[cid + '|' + date]; if (!rec) return; Object.keys(rec).forEach(function (sid) { var v = rec[sid]; if (v === 'H') h++; else if (v === 'L') l++; else if (v === 'T') t++; else if (v === 'C') c++; }); });
            var tot = h + l + t + c;
            return { h: h, l: l, t: t, c: c, tot: tot, pct: tot ? Math.round((h + l) / tot * 100) : 0 };
        },
        get todayStats() { return this.attStats(this.classesAvail.map(function (c) { return c.id; }), TODAY); },
        get week7() {
            var ids = this.classesAvail.map(function (c) { return c.id; }), out = [];
            for (var i = 6; i >= 0; i--) { var iso = addDays(TODAY, -i), d = new Date(iso + 'T00:00:00'); out.push({ iso: iso, label: HARI_S[d.getDay()], pct: this.attStats(ids, iso).pct }); }
            return out;
        },
        get attKey() { return this.attClass + '|' + this.attDate; },
        get attRows() { var cid = this.attClass; return this.students.filter(function (s) { return s.classId === cid; }); },
        get attSummary() { return this.attStats([this.attClass], this.attDate); },
        markAllPresent() { var rec = this.att[this.attKey]; if (!rec) return; this.attRows.forEach(function (s) { rec[s.id] = 'H'; }); this.toast('Semua murid ditanda Hadir', 'info'); },
        stuAtt(s, days) {
            var h = 0, l = 0, t = 0, c = 0;
            if (s) for (var i = 0; i < days; i++) { var rec = this.att[s.classId + '|' + addDays(TODAY, -i)], v = rec && rec[s.id]; if (v === 'H') h++; else if (v === 'L') l++; else if (v === 'T') t++; else if (v === 'C') c++; }
            var tot = h + l + t + c;
            return { h: h, l: l, t: t, c: c, tot: tot, pct: tot ? Math.round((h + l) / tot * 100) : 0 };
        },
        get monthDays() { return new Date().getDate(); },
        get avg30() { var ids = this.classes.map(function (c) { return c.id; }), sum = 0, n = 0; for (var i = 0; i < 30; i++) { var s = this.attStats(ids, addDays(TODAY, -i)); if (s.tot) { sum += s.pct; n++; } } return n ? Math.round(sum / n) : 0; },

        /* ---------- Jadual waktu ---------- */
        ttSubj(cid, d, s) { var k = cid + '|' + d + '|' + s; if (this.ttOverride[k] !== undefined) return this.ttOverride[k]; return s === 0 ? 0 : ((cid + d * 3 + s) % 6) + 1; },
        openSlot(d, s) { this.form = { d: d, s: s, subj: this.ttSubj(this.ttClass, d, s) }; this.modal = 'slot'; },
        saveSlot() { this.ttOverride[this.ttClass + '|' + this.form.d + '|' + this.form.s] = Number(this.form.subj); this.modal = null; this.saved(); },

        /* ---------- Markah ---------- */
        markOf(e, sid, j) { var a = this.marks[e] && this.marks[e][sid]; var v = a ? a[j] : null; return v === null || v === '' || v === undefined ? '—' : v; },
        gradeOf(e, sid, j) { var v = this.markOf(e, sid, j); return v === '—' ? '—' : this.grade(v); },
        clampMark(sid, j) { var a = this.marks[this.examId][sid], v = a[j]; if (v === '' || v === null) { a[j] = null; return; } a[j] = clamp(Math.round(Number(v) || 0), 0, 100); },
        get examRows() {
            var m = this.marks[this.examId] || {}, cid = this.examClass;
            var rows = this.students.filter(function (s) { return s.classId === cid; }).map(function (s) {
                var arr = m[s.id] || [], vals = arr.filter(function (v) { return typeof v === 'number'; }), total = vals.reduce(function (a, b) { return a + b; }, 0);
                return { s: s, total: total, avg: vals.length ? total / vals.length : 0, complete: vals.length === SUBJECTS.length };
            });
            var sorted = rows.slice().sort(function (a, b) { return b.total - a.total; });
            rows.forEach(function (r) { r.rank = sorted.indexOf(r) + 1; });
            return rows;
        },
        avgOf(sid, e) { var a = (this.marks[e || 'pat'] || {})[sid] || [], v = a.filter(function (x) { return typeof x === 'number'; }); return v.length ? v.reduce(function (p, q) { return p + q; }, 0) / v.length : 0; },
        get subjAvg() {
            var ids = this.studentsAvail.map(function (s) { return s.id; }), pat = this.marks.pat || {};
            return SUBJECTS.map(function (n, j) { var sum = 0, c = 0; ids.forEach(function (id) { var v = pat[id] && pat[id][j]; if (typeof v === 'number') { sum += v; c++; } }); return { n: n, avg: c ? Math.round(sum / c) : 0 }; });
        },

        /* ---------- Kelas ---------- */
        openKelas(c) {
            if (!c && this.plan === 'free' && this.classes.length >= 3) { this.openUpsell(null, this.limitUpsell); return; }
            this.form = c ? { id: c.id, name: c.name, year: c.year, teacherId: c.teacherId } : { id: null, name: '', year: 1, teacherId: 2 };
            this.modal = 'kelas';
        },
        saveKelas() {
            var f = this.form;
            if (!String(f.name).trim()) { this.toast('Sila isi nama kelas', 'error'); return; }
            if (f.id) { Object.assign(this.cls(f.id), { name: f.name.trim(), year: Number(f.year), teacherId: Number(f.teacherId) }); }
            else { var id = Math.max.apply(null, [0].concat(this.classes.map(function (c) { return c.id; }))) + 1; this.classes.push({ id: id, name: f.name.trim(), year: Number(f.year), teacherId: Number(f.teacherId) }); }
            this.modal = null; this.fixSelections(); this.saved();
        },

        /* ---------- Murid ---------- */
        get muridList() {
            var q = this.q.trim().toLowerCase(), fc = this.fClass;
            return this.studentsAvail.filter(function (s) { return (!fc || s.classId === fc) && (!q || s.name.toLowerCase().indexOf(q) >= 0 || s.mykid.indexOf(q) >= 0 || s.guardian.toLowerCase().indexOf(q) >= 0); });
        },
        openProfil(id) { this.profilId = id; this.page = 'profil'; window.scrollTo({ top: 0 }); },
        get profil() { return this.stu(this.profilId); },
        openMurid(s) {
            this.form = s ? { id: s.id, name: s.name, gender: s.gender, mykid: s.mykid, classId: s.classId, guardian: s.guardian, phone: s.phone } : { id: null, name: '', gender: 'L', mykid: '', classId: this.fClass || (this.classesAvail[0] ? this.classesAvail[0].id : null), guardian: '', phone: '' };
            this.modal = 'murid';
        },
        saveMurid() {
            var f = this.form;
            if (!String(f.name).trim() || !/^\d{12}$/.test(f.mykid)) { this.toast('Sila isi nama dan No. MyKid 12 digit', 'error'); return; }
            if (!f.id && this.plan === 'free' && this.classCount(f.classId) >= 40) { this.openUpsell(null, this.limitUpsell); return; }
            if (f.id) { Object.assign(this.stu(f.id), { name: f.name.trim(), gender: f.gender, mykid: f.mykid, classId: Number(f.classId), guardian: f.guardian || '—', phone: f.phone || '—' }); }
            else { this.addStudent(f); }
            this.modal = null; this.saved();
        },
        addStudent(o) {
            var id = Math.max.apply(null, [0].concat(this.students.map(function (s) { return s.id; }))) + 1, cid = Number(o.classId), self = this;
            this.students.push({ id: id, name: String(o.name).trim(), gender: o.gender, mykid: o.mykid, classId: cid, guardian: o.guardian || '—', phone: o.phone || '—' });
            this.exams.forEach(function (e) { self.marks[e.id][id] = SUBJECTS.map(function () { return null; }); });
            Object.keys(this.att).forEach(function (k) { if (k.indexOf(cid + '|') === 0) self.att[k][id] = 'H'; });
            this.achv[id] = { haf: 0, bac: 0, jawi: 1 };
            return id;
        },

        /* ---------- Padam ---------- */
        askDelete(kind, id, name) { this.delTarget = { kind: kind, id: id, name: name }; this.modal = 'padam'; },
        doDelete() {
            var t = this.delTarget, map = { murid: 'students', kelas: 'classes', rph: 'rphs', trans: 'trans', hebahan: 'hebahan', disiplin: 'disiplin', guru: 'teachers' };
            this[map[t.kind]] = this[map[t.kind]].filter(function (x) { return x.id !== t.id; });
            if (t.kind === 'kelas') this.students = this.students.filter(function (s) { return s.classId !== t.id; });
            if (t.kind === 'murid' && this.page === 'profil') this.page = 'murid';
            this.modal = null; this.fixSelections();
            this.toast('Rekod dipadam (demo)');
        },

        /* ---------- RPH ---------- */
        get rphList() {
            var role = this.role, st = this.rphStatus;
            return this.rphs.filter(function (r) { return (role === 'gb' || r.teacherId === 2) && (!st || r.status === st); }).slice().sort(function (a, b) { return b.date.localeCompare(a.date); });
        },
        get rphPending() { return this.rphs.filter(function (r) { return r.status === 'Dihantar'; }); },
        openRph(r) {
            this.form = r ? Object.assign({}, r) : { id: null, date: TODAY, classId: this.classesAvail[0] ? this.classesAvail[0].id : null, subject: SUBJECTS[0], objektif: '', aktiviti: '', refleksi: '', jawi: false, teacherId: this.role === 'guru' ? 2 : 1, status: 'Draf', ulasan: '' };
            this.modal = 'rph';
        },
        saveRph(status) {
            var f = this.form;
            if (!String(f.objektif).trim()) { this.toast('Sila isi objektif pembelajaran', 'error'); return; }
            f.status = status; f.classId = Number(f.classId);
            if (f.id) { Object.assign(this.rphs.find(function (x) { return x.id === f.id; }), f); }
            else { f.id = Math.max.apply(null, [0].concat(this.rphs.map(function (x) { return x.id; }))) + 1; this.rphs.push(Object.assign({}, f)); }
            this.modal = null;
            this.saved(status === 'Dihantar' ? 'RPH dihantar untuk semakan' : null);
        },
        viewRph(r) { this.form = Object.assign({}, r); this.modal = 'rphView'; },
        openReview(r) { this.form = Object.assign({}, r, { ulasan: '' }); this.modal = 'review'; },
        decideRph(ok) {
            var id = this.form.id, r = this.rphs.find(function (x) { return x.id === id; });
            if (!ok && !String(this.form.ulasan).trim()) { this.toast('Sila tulis ulasan sebelum mengembalikan RPH', 'error'); return; }
            r.status = ok ? 'Diluluskan' : 'Dikembalikan';
            r.ulasan = String(this.form.ulasan).trim() || (ok ? 'Diluluskan.' : '');
            this.modal = null;
            this.toast(ok ? 'RPH diluluskan' : 'RPH dikembalikan kepada guru');
        },

        /* ---------- Pencapaian ---------- */
        get pcRows() { var cid = this.pcClass, self = this; return this.students.filter(function (s) { return s.classId === cid && self.achv[s.id]; }); },
        openAchv(s) { var a = this.achv[s.id]; this.form = { sid: s.id, haf: a.haf, bac: a.bac, jawi: a.jawi }; this.modal = 'achv'; },
        saveAchv() { this.achv[this.form.sid] = { haf: Number(this.form.haf), bac: Number(this.form.bac), jawi: Number(this.form.jawi) }; this.modal = null; this.saved(); },

        /* ---------- Disiplin ---------- */
        get disList() { var ids = this.studentsAvail.map(function (s) { return s.id; }); return this.disiplin.filter(function (d) { return ids.indexOf(d.sid) >= 0; }).slice().sort(function (a, b) { return b.date.localeCompare(a.date); }); },
        get disSum() {
            var L = this.disList;
            return { kes: L.filter(function (d) { return d.type === 'demerit'; }).length,
                     merit: L.filter(function (d) { return d.type === 'merit'; }).reduce(function (a, d) { return a + d.mata; }, 0),
                     demerit: L.filter(function (d) { return d.type === 'demerit'; }).reduce(function (a, d) { return a + d.mata; }, 0) };
        },
        openDis() { this.form = { sid: this.studentsAvail[0] ? this.studentsAvail[0].id : null, type: 'demerit', cat: 0, tindakan: 'Nasihat', date: TODAY }; this.modal = 'dis'; },
        saveDis() {
            var f = this.form, c = DIS_CAT[f.type][Number(f.cat)];
            this.disiplin.push({ id: Math.max.apply(null, [0].concat(this.disiplin.map(function (d) { return d.id; }))) + 1, date: f.date || TODAY, sid: Number(f.sid), type: f.type, kategori: c.n, tindakan: f.tindakan, mata: c.p });
            this.modal = null; this.pg.disiplin = 1; this.saved();
        },

        /* ---------- Aktiviti & sijil ---------- */
        openAkt() { this.form = { name: '', date: TODAY, tempat: '' }; this.modal = 'akt'; },
        saveAkt() {
            var f = this.form;
            if (!String(f.name).trim()) { this.toast('Sila isi nama aktiviti', 'error'); return; }
            this.aktiviti.push({ id: Math.max.apply(null, [0].concat(this.aktiviti.map(function (a) { return a.id; }))) + 1, name: f.name.trim(), date: f.date || TODAY, tempat: f.tempat || '—', peserta: [] });
            this.modal = null; this.saved();
        },
        openPeserta(a) { this.form = { aid: a.id, cid: this.classesAvail[0] ? this.classesAvail[0].id : null }; this.modal = 'peserta'; },
        get pesertaAkt() { var id = this.form.aid; return this.aktiviti.find(function (a) { return a.id === id; }); },
        togglePeserta(sid) { var a = this.pesertaAkt, i = a.peserta.indexOf(sid); if (i >= 0) a.peserta.splice(i, 1); else a.peserta.push(sid); },
        get certStu() { return this.stu(this.cert.sid); },
        get certAct() { var id = this.cert.act; return this.aktiviti.find(function (a) { return a.id === id; }); },

        /* ---------- Laporan murid ---------- */
        get lmStu() { return this.stu(this.lm.sid); },
        get lmRows() { var arr = ((this.marks[this.lm.exam] || {})[this.lm.sid]) || []; return SUBJECTS.map(function (n, j) { var v = arr[j]; return { n: n, m: v === undefined ? null : v }; }); },
        get lmSummary() {
            var e = this.lm.exam, s = this.lmStu, self = this;
            if (!s) return { total: 0, avg: 0, rank: '—', of: 0 };
            var mates = this.students.filter(function (x) { return x.classId === s.classId; });
            var tot = function (id) { return ((self.marks[e] || {})[id] || []).reduce(function (a, b) { return a + (typeof b === 'number' ? b : 0); }, 0); };
            var mine = tot(s.id), rank = mates.filter(function (x) { return tot(x.id) > mine; }).length + 1;
            return { total: mine, avg: this.avgOf(s.id, e), rank: rank, of: mates.length };
        },
        ulasan(avg) {
            var g = this.grade(avg);
            if (g === 'A') return 'Tahniah! Prestasi cemerlang dalam semua subjek. Teruskan usaha dan kekalkan disiplin yang baik.';
            if (g === 'B') return 'Prestasi baik. Tingkatkan lagi latihan bacaan dan hafazan di rumah untuk mencapai gred A.';
            if (g === 'C') return 'Prestasi sederhana. Perlu lebih fokus semasa PdP dan buat ulang kaji bersama ibu bapa.';
            return 'Memerlukan bimbingan tambahan. Guru akan mengadakan kelas pemulihan — mohon kerjasama ibu bapa.';
        },

        /* ---------- Pembantu AI (jawapan dibuat-buat dari data contoh) ---------- */
        ask(text) {
            text = String(text || this.chatInput).trim(); if (!text) return;
            var self = this;
            this.chat.push({ me: true, text: text }); this.chatInput = ''; this.typing = true; this.scrollChat();
            setTimeout(function () { self.typing = false; self.chat.push({ me: false, text: self.botReply(text) }); self.scrollChat(); }, 900);
        },
        scrollChat() { window.Alpine.nextTick(function () { var el = document.getElementById('chat-box'); if (el) el.scrollTop = el.scrollHeight; }); },
        botReply(q) {
            q = q.toLowerCase();
            var ids = this.classesAvail.map(function (c) { return c.id; }), self = this;
            if (q.indexOf('tidak hadir') >= 0 || q.indexOf('ponteng') >= 0 || q.indexOf('absen') >= 0) {
                var abs = [];
                ids.forEach(function (cid) { var rec = self.att[cid + '|' + TODAY] || {}; Object.keys(rec).forEach(function (sid) { if (rec[sid] === 'T') { var s = self.stu(Number(sid)); if (s) abs.push(s.name.split(/ bin | binti /)[0] + ' (' + self.cls(cid).name + ')'); } }); });
                return abs.length ? 'Hari ini ' + abs.length + ' murid tidak hadir: ' + abs.slice(0, 6).join(', ') + (abs.length > 6 ? ' dan lain-lain.' : '.') + '\nSenarai penuh ada di modul Kehadiran Harian.' : 'Alhamdulillah, tiada murid yang tidak hadir hari ini.';
            }
            if (q.indexOf('kehadiran') >= 0 || q.indexOf('hadir') >= 0) { var t = this.todayStats; return 'Kehadiran hari ini ialah ' + t.pct + '% — ' + (t.h + t.l) + ' daripada ' + t.tot + ' murid hadir (termasuk ' + t.l + ' lewat).'; }
            if (q.indexOf('purata') >= 0 || q.indexOf('markah') >= 0 || q.indexOf('pat') >= 0) {
                var a = this.subjAvg.slice().sort(function (x, y) { return y.avg - x.avg; });
                return 'Purata markah PAT ikut subjek:\n' + this.subjAvg.map(function (x) { return '• ' + x.n + ': ' + x.avg; }).join('\n') + '\n\nSubjek terkuat ialah ' + a[0].n + ', manakala ' + a[a.length - 1].n + ' memerlukan lebih perhatian.';
            }
            if (q.indexOf('rph') >= 0 || q.indexOf('aktiviti') >= 0 || q.indexOf('adab') >= 0) {
                return 'Cadangan RPH Adab (40 minit) — Adab Makan dan Minum:\n1. Set induksi (5 min): tunjuk gambar hidangan, tanya murid apa yang dibaca sebelum makan.\n2. Penerangan (10 min): doa sebelum dan selepas makan, makan dengan tangan kanan.\n3. Main peranan (15 min): murid berlakon makan bersama keluarga.\n4. Refleksi (10 min): murid tulis satu adab yang akan diamalkan di rumah.';
            }
            if (q.indexOf('lelaki') >= 0 || q.indexOf('perempuan') >= 0 || q.indexOf('jumlah murid') >= 0 || q.indexOf('berapa murid') >= 0) {
                var L = this.studentsAvail, m = L.filter(function (s) { return s.gender === 'L'; }).length;
                return 'Jumlah murid: ' + L.length + ' orang — ' + m + ' lelaki dan ' + (L.length - m) + ' perempuan, dalam ' + ids.length + ' kelas.';
            }
            if (q.indexOf('yuran') >= 0) { var unpaid = this.fees.filter(function (f) { return !f.paid; }); return 'Terdapat ' + unpaid.length + ' rekod yuran tertunggak berjumlah ' + this.rm(unpaid.reduce(function (a, f) { return a + f.amount; }, 0)) + '.'; }
            return 'Saya boleh bantu tentang kehadiran, markah, jumlah murid dan idea RPH. Cuba tanya: “Berapa murid tidak hadir hari ini?”\n(Dalam demo, jawapan dijana daripada data contoh.)';
        },

        /* ---------- Pengguna ---------- */
        get userRows() { var self = this; return this.teachers.map(function (t) { return Object.assign({}, t, { kelas: self.classes.filter(function (c) { return c.teacherId === t.id; }).map(function (c) { return c.name; }).join(', ') || '—' }); }); },
        openJemput() { this.form = { name: '', email: '' }; this.modal = 'jemput'; },
        sendInvite() {
            var f = this.form;
            if (!String(f.name).trim() || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(f.email)) { this.toast('Sila isi nama dan e-mel yang sah', 'error'); return; }
            this.teachers.push({ id: Math.max.apply(null, this.teachers.map(function (t) { return t.id; })) + 1, name: f.name.trim(), email: f.email.trim(), role: 'Guru KAFA', status: 'Dijemput' });
            this.modal = null; this.toast('Jemputan dihantar ke ' + f.email.trim());
        },

        /* ---------- Laporan & KPI sekolah ---------- */
        get trendData() {
            var base = [91, 93, 92, 94, 90, 93, 95, 94, 93, 94, 92, 93], m = new Date().getMonth(), out = [];
            for (var i = 0; i <= m; i++) out.push({ m: BULAN_S[i], v: i === m ? this.avg30 : base[i] });
            return out;
        },
        tx(i) { var n = this.trendData.length; return n < 2 ? 315 : 50 + i * (530 / (n - 1)); },
        ty(v) { return 20 + (100 - clamp(v, 80, 100)) / 20 * 190; },
        get trendSvg() {
            var self = this, d = this.trendData, s = '';
            [80, 85, 90, 95, 100].forEach(function (v) { s += '<line x1="40" x2="590" y1="' + self.ty(v) + '" y2="' + self.ty(v) + '" stroke="#E5E7EB"/><text x="2" y="' + (self.ty(v) + 4) + '" fill="#6B7280" font-size="11">' + v + '%</text>'; });
            s += '<line x1="40" x2="590" y1="' + this.ty(90) + '" y2="' + this.ty(90) + '" stroke="#0F172A" stroke-dasharray="4 4"/>';
            var pts = d.map(function (p, i) { return self.tx(i) + ',' + self.ty(p.v); });
            if (d.length > 1) s += '<path d="M' + pts.join(' L') + ' L' + this.tx(d.length - 1) + ',210 L' + this.tx(0) + ',210 Z" fill="#2563EB" fill-opacity=".1"/>';
            s += '<polyline points="' + pts.join(' ') + '" fill="none" stroke="#2563EB" stroke-width="3" stroke-linejoin="round" stroke-linecap="round"/>';
            d.forEach(function (p, i) {
                s += '<circle cx="' + self.tx(i) + '" cy="' + self.ty(p.v) + '" r="4.5" fill="#fff" stroke="#2563EB" stroke-width="2.5"/>';
                s += '<text x="' + self.tx(i) + '" y="' + (self.ty(p.v) - 10) + '" text-anchor="middle" fill="#0F172A" font-size="10" font-weight="600">' + p.v + '</text>';
                s += '<text x="' + self.tx(i) + '" y="234" text-anchor="middle" fill="#6B7280" font-size="11">' + p.m + '</text>';
            });
            return s;
        },
        get classAvgs() {
            var self = this;
            return this.classes.map(function (c) { var L = self.students.filter(function (s) { return s.classId === c.id; }), sum = 0; L.forEach(function (s) { sum += self.avgOf(s.id, 'pat'); }); return { name: c.name, avg: L.length ? Math.round(sum / L.length) : 0 }; });
        },
        get kpis() {
            var self = this, all = this.students;
            var pass = all.length ? Math.round(all.filter(function (s) { return self.avgOf(s.id, 'pat') >= 50; }).length / all.length * 100) : 0;
            var sub = this.rphs.filter(function (r) { return r.status !== 'Draf'; }), appr = sub.length ? Math.round(sub.filter(function (r) { return r.status === 'Diluluskan'; }).length / sub.length * 100) : 0;
            var t5 = all.filter(function (s) { return s.classId === 5 && self.achv[s.id]; }), haf = t5.length ? Math.round(t5.filter(function (s) { return self.achv[s.id].haf >= 29; }).length / t5.length * 100) : 0;
            return [
                { n: 'Kehadiran purata (30 hari)', v: this.avg30, t: 90 },
                { n: 'Murid lulus PAT (purata ≥ 50)', v: pass, t: 85 },
                { n: 'RPH diluluskan', v: appr, t: 90 },
                { n: 'Tahun 5 hafaz ≥ 30 surah', v: haf, t: 60 }
            ];
        },

        /* ---------- Kewangan ---------- */
        get finList() { var f = this.finFilter; return this.trans.filter(function (t) { return !f || t.type === f; }).slice().sort(function (a, b) { return b.date.localeCompare(a.date) || b.id - a.id; }); },
        get finSum() { var m = 0, k = 0; this.trans.forEach(function (t) { if (t.type === 'masuk') m += t.amaun; else k += t.amaun; }); return { masuk: m, keluar: k }; },
        get finMonths() {
            var out = [], now = new Date(), self = this;
            for (var i = 5; i >= 0; i--) {
                var d = new Date(now.getFullYear(), now.getMonth() - i, 1), key = d.getFullYear() + '-' + pad(d.getMonth() + 1), m = 0, k = 0;
                self.trans.forEach(function (t) { if (t.date.indexOf(key) === 0) { if (t.type === 'masuk') m += t.amaun; else k += t.amaun; } });
                out.push({ key: key, label: BULAN_S[d.getMonth()], masuk: m, keluar: k });
            }
            return out;
        },
        get finMax() { return Math.max.apply(null, [1].concat(this.finMonths.map(function (m) { return Math.max(m.masuk, m.keluar); }))); },
        openTrans() { this.form = { type: 'masuk', kategori: FIN_CAT.masuk[0], amaun: '', date: TODAY, ket: '' }; this.modal = 'trans'; },
        saveTrans() {
            var f = this.form, amt = Number(f.amaun);
            if (!(amt > 0)) { this.toast('Sila masukkan amaun yang sah', 'error'); return; }
            this.trans.push({ id: Math.max.apply(null, [0].concat(this.trans.map(function (t) { return t.id; }))) + 1, date: f.date || TODAY, type: f.type, kategori: f.kategori, amaun: Math.round(amt * 100) / 100, ket: f.ket || '—' });
            this.modal = null; this.pg.kewangan = 1; this.saved();
        },

        /* ---------- Hebahan ---------- */
        get hebList() {
            var role = this.role;
            return this.hebahan.filter(function (h) { return role === 'gb' || (role === 'guru' ? h.target !== 'ibubapa' : h.target !== 'guru'); }).slice().sort(function (a, b) { return b.date.localeCompare(a.date) || b.id - a.id; });
        },
        openHeb() { this.form = { title: '', body: '', target: 'semua' }; this.modal = 'heb'; },
        saveHeb() {
            var f = this.form;
            if (!String(f.title).trim() || !String(f.body).trim()) { this.toast('Sila isi tajuk dan kandungan', 'error'); return; }
            this.hebahan.push({ id: Math.max.apply(null, [0].concat(this.hebahan.map(function (h) { return h.id; }))) + 1, title: f.title.trim(), body: f.body.trim(), target: f.target, date: TODAY, by: this.user.name });
            this.modal = null; this.toast('Hebahan diterbitkan kepada ' + TARGET[f.target]);
        },

        /* ---------- Pindah murid ---------- */
        submitPindah() {
            var s = this.stu(this.pf.sid), self = this;
            if (!s) { this.toast('Sila pilih murid', 'error'); return; }
            var id = Math.max.apply(null, [0].concat(this.pindah.map(function (p) { return p.id; }))) + 1;
            this.pindah.push({ id: id, name: s.name, dest: this.pf.dest, reason: this.pf.reason, status: 'Menunggu Pengesahan', date: TODAY });
            this.toast('Permohonan pindah dihantar ke ' + this.pf.dest);
            setTimeout(function () { var p = self.pindah.find(function (x) { return x.id === id; }); if (p) { p.status = 'Diluluskan'; self.toast('Sekolah destinasi meluluskan pindahan ' + s.name.split(/ bin | binti /)[0], 'info'); } }, 4000);
        },

        /* ---------- Ibu bapa ---------- */
        get children() { var self = this; return this.kids.map(function (id) { return self.stu(id); }).filter(Boolean); },
        get child() { return this.children[this.pChild] || this.children[0]; },
        get childAvg() { return this.child ? this.avgOf(this.child.id, 'pat') : 0; },
        payFee(f) { f.paid = true; this.toast('Bayaran FPX ' + this.rm(f.amount) + ' berjaya (demo)'); },

        /* ---------- Import Excel ---------- */
        impFile(file) {
            if (!file) return;
            if (!/\.xlsx$/i.test(file.name)) { this.toast('Hanya fail .xlsx diterima', 'error'); return; }
            this.imp.file = file.name; this.imp.step = 1;
        },
        impSample() { this.imp.file = 'senarai_murid_contoh.xlsx'; this.imp.step = 1; },
        doImport() { var self = this; IMP_ROWS.forEach(function (r) { self.addStudent(Object.assign({}, r, { classId: self.imp.classId, phone: '—' })); }); this.imp.step = 2; this.toast('5 murid berjaya diimport (demo)'); },

        /* ---------- Kiosk QR ---------- */
        openKiosk() { this.kiosk.scanned = []; this.kiosk.last = null; this.kiosk.show = false; this.kiosk.open = true; this.ensureAtt(this.kiosk.classId, TODAY); document.body.style.overflow = 'hidden'; },
        closeKiosk() { this.kiosk.open = false; this.kiosk.show = false; document.body.style.overflow = ''; },
        get kioskStudents() { var cid = this.kiosk.classId; return this.students.filter(function (s) { return s.classId === cid; }); },
        get kioskNext() { var done = this.kiosk.scanned.map(function (x) { return x.id; }); return this.kioskStudents.find(function (s) { return done.indexOf(s.id) < 0; }); },
        kioskScan() {
            var s = this.kioskNext, self = this;
            if (!s) { this.toast('Semua murid kelas ini telah diimbas', 'info'); return; }
            this.tick();
            this.kiosk.scanned.unshift({ id: s.id, name: s.name, time: this.clock });
            this.kiosk.last = { name: s.name, time: this.clock }; this.kiosk.show = true;
            var rec = this.att[this.kiosk.classId + '|' + TODAY]; if (rec) rec[s.id] = 'H';
            clearTimeout(this._kt); this._kt = setTimeout(function () { self.kiosk.show = false; }, 1700);
        },

        /* ---------- Lawatan berpandu ---------- */
        startTour() { if (this.role === 'parent') return; this.page = 'dashboard'; this.tour.on = true; this.tour.step = 0; var self = this; window.Alpine.nextTick(function () { self.tourPlace(); }); },
        tourGo(i) {
            if (i >= TOUR.length) { this.endTour(); return; }
            var st = TOUR[i], mobile = window.innerWidth < 1024, self = this;
            this.tour.step = i; this.drawer = !!(st.nav && mobile);
            setTimeout(function () { self.tourPlace(); }, st.nav && mobile ? 330 : 40);
        },
        endTour() { this.tour.on = false; this.tour.box = null; this.drawer = false; },
        tourPlace() {
            if (!this.tour.on) return;
            var st = TOUR[this.tour.step], W = window.innerWidth, H = window.innerHeight, pw = Math.min(320, W - 24), popH = 200;
            var el = Array.prototype.slice.call(document.querySelectorAll(st.sel)).find(function (e) { return e.getClientRects().length > 0; });
            if (!el) { this.tour.box = null; this.tour.pop = { top: Math.max(12, H / 2 - popH / 2), left: (W - pw) / 2, w: pw }; return; }
            var r = el.getBoundingClientRect();
            if (r.top < 0 || r.bottom > H) { el.scrollIntoView({ block: 'center' }); r = el.getBoundingClientRect(); }
            var p = 6;
            this.tour.box = { top: r.top - p, left: r.left - p, width: r.width + p * 2, height: r.height + p * 2 };
            var top = r.bottom + 14; if (top + popH > H) top = Math.max(12, r.top - 14 - popH);
            var left = clamp(r.left, 12, W - pw - 12);
            this.tour.pop = { top: top, left: left, w: pw };
        }
    };
}
</script>
</body>
</html>
