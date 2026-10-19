@extends('layout-fb.auth-card')

@section('title', 'Terma Perkhidmatan')
@section('card_width', '48rem')
@section('card_title', 'Terma Perkhidmatan')
@section('card_subtitle', 'Kemas kini terakhir: 18 Oktober 2026')

@section('card')
<div class="space-y-4 text-sm text-gray-700 leading-relaxed">
    <p>Terma ini mengawal penggunaan platform eKafa Online ("Perkhidmatan"). Dengan mendaftar atau menggunakan Perkhidmatan, anda bersetuju dengan terma ini.</p>

    <h2 class="text-base font-semibold text-gray-900">1. Akaun</h2>
    <p>Anda bertanggungjawab ke atas ketepatan maklumat pendaftaran dan kerahsiaan kata laluan anda. Pemilik akaun (Guru Besar atau guru Personal) bertanggungjawab ke atas pengguna yang ditambah atau dijemput ke dalam akaunnya.</p>

    <h2 class="text-base font-semibold text-gray-900">2. Data murid</h2>
    <p>Anda mesti mendapat kebenaran yang sewajarnya daripada sekolah dan/atau ibu bapa sebelum memasukkan data peribadi murid. Data yang anda masukkan kekal milik sekolah anda; kami memprosesnya hanya untuk menyediakan Perkhidmatan, seperti dinyatakan dalam <a href="{{ route('legal.privacy') }}" class="text-blue-600 hover:underline">Notis Privasi</a>.</p>

    <h2 class="text-base font-semibold text-gray-900">3. Pakej dan bayaran</h2>
    <p>Pakej Percuma boleh digunakan tanpa bayaran tertakluk kepada had yang dipaparkan. Pakej berbayar dibilkan secara bulanan. Jika langganan tamat dan tidak diperbaharui, akaun akan kembali ke pakej Percuma; data anda dikekalkan tetapi modul berbayar akan dikunci.</p>

    <h2 class="text-base font-semibold text-gray-900">4. Penggunaan yang dilarang</h2>
    <p>Anda tidak boleh menggunakan Perkhidmatan untuk tujuan menyalahi undang-undang, cuba mengakses data akaun lain, atau mengganggu operasi sistem.</p>

    <h2 class="text-base font-semibold text-gray-900">5. Ketersediaan</h2>
    <p>Kami berusaha memastikan Perkhidmatan sentiasa tersedia, namun tiada jaminan perkhidmatan tanpa gangguan. Kami boleh mengemas kini ciri Perkhidmatan dari semasa ke semasa.</p>

    <h2 class="text-base font-semibold text-gray-900">6. Penamatan</h2>
    <p>Anda boleh menamatkan akaun pada bila-bila masa dengan menghubungi kami. Kami boleh menggantung akaun yang melanggar terma ini.</p>

    <h2 class="text-base font-semibold text-gray-900">7. Hubungi kami</h2>
    <p>Sebarang pertanyaan: <a href="https://wa.me/60194920559" target="_blank" rel="noopener" class="text-blue-600 hover:underline">WhatsApp</a>.</p>
</div>
@endsection
