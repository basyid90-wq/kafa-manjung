@extends('layout-fb.auth-card')

@section('title', 'Notis Privasi')
@section('card_width', '48rem')
@section('card_title', 'Notis Privasi')
@section('card_subtitle', 'Selaras dengan Akta Perlindungan Data Peribadi 2010 (PDPA). Kemas kini terakhir: 18 Oktober 2026')

@section('card')
<div class="space-y-4 text-sm text-gray-700 leading-relaxed">
    <h2 class="text-base font-semibold text-gray-900">1. Data yang dikumpul</h2>
    <p><strong>Pengguna:</strong> nama, e-mel, nombor telefon dan maklumat log masuk.<br>
       <strong>Murid (dimasukkan oleh sekolah/guru):</strong> nama, MyKid, tarikh lahir, alamat, maklumat ibu bapa/penjaga, kehadiran, markah, rekod disiplin dan pencapaian.</p>

    <h2 class="text-base font-semibold text-gray-900">2. Tujuan</h2>
    <p>Data diproses semata-mata untuk menyediakan fungsi pengurusan KAFA kepada sekolah anda — rekod kehadiran, peperiksaan, RPH, laporan, sijil dan portal ibu bapa. Kami tidak menjual data dan tidak menggunakannya untuk pengiklanan.</p>

    <h2 class="text-base font-semibold text-gray-900">3. Pengasingan data</h2>
    <p>Setiap sekolah mempunyai ruang data tersendiri. Pengguna hanya boleh melihat data sekolah mereka sendiri; ibu bapa hanya melihat data anak mereka.</p>

    <h2 class="text-base font-semibold text-gray-900">4. Pendedahan</h2>
    <p>Data hanya didedahkan kepada pembekal yang perlu untuk operasi (pengehosan pelayan, penghantaran e-mel, gerbang pembayaran) atau apabila dikehendaki oleh undang-undang. Jika ciri Pembantu AI diaktifkan, teks soalan anda dihantar kepada penyedia AI untuk menjana jawapan.</p>

    <h2 class="text-base font-semibold text-gray-900">5. Keselamatan dan penyimpanan</h2>
    <p>Kami mengambil langkah munasabah untuk melindungi data. Data disimpan selagi akaun aktif dan dipadam atas permintaan pemilik akaun, kecuali jika perlu disimpan menurut undang-undang.</p>

    <h2 class="text-base font-semibold text-gray-900">6. Hak anda</h2>
    <p>Anda berhak meminta akses, pembetulan atau pemadaman data peribadi anda. Ibu bapa boleh membuat permintaan berkenaan data anak melalui sekolah atau terus kepada kami.</p>

    <h2 class="text-base font-semibold text-gray-900">7. Hubungi kami</h2>
    <p>Pertanyaan berkaitan privasi: <a href="https://wa.me/60194920559" target="_blank" rel="noopener" class="text-blue-600 hover:underline">WhatsApp</a>.</p>
</div>
@endsection
