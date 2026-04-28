<!DOCTYPE html>
<html lang="ms">
<head>
<meta charset="UTF-8">
<style>
* { margin: 0; padding: 0; box-sizing: border-box; }

body {
    font-family: dejavusans, Arial;
    font-size: 10pt;
    color: #111;
}

.header {
    text-align: center;
    margin-bottom: 12px;
    border-bottom: 1.5pt solid #333;
    padding-bottom: 8px;
}

.header h2 {
    font-size: 13pt;
    font-weight: 700;
    margin-bottom: 3px;
}

.header h3 {
    font-size: 10pt;
    font-weight: 400;
    color: #555;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 8px;
}

thead th {
    background: #e8eaf0;
    border: 0.5pt solid #777;
    padding: 5px 8px;
    font-size: 9.5pt;
    font-weight: 700;
}

tbody td {
    border: 0.5pt solid #aaa;
    padding: 4px 8px;
    font-size: 9pt;
    vertical-align: middle;
}

tfoot td {
    border: 0.5pt solid #777;
    padding: 5px 8px;
    font-size: 9.5pt;
    font-weight: 700;
    background: #f0f0f0;
}

.text-center { text-align: center; }
.text-right  { text-align: right; }

.footer {
    margin-top: 10px;
    font-size: 7.5pt;
    color: #888;
    text-align: right;
}
</style>
</head>
<body>

<div class="header">
    <h2>Rumusan Tempahan Buku KAFA untuk Pembekal</h2>
    <h3>Tempoh: {{ $filterLabel }}</h3>
</div>

<table>
    <thead>
        <tr>
            <th style="width:40pt;" class="text-center">Bil.</th>
            <th>Nama Buku</th>
            <th style="width:80pt;" class="text-center">Kuantiti (unit)</th>
        </tr>
    </thead>
    <tbody>
        @php $grandTotal = 0; @endphp
        @forelse($summary as $i => $row)
        <tr>
            <td class="text-center">{{ $i + 1 }}</td>
            <td>{{ $row->book->name ?? '-' }}</td>
            <td class="text-center">{{ $row->total_quantity }}</td>
        </tr>
        @php $grandTotal += $row->total_quantity; @endphp
        @empty
        <tr>
            <td colspan="3" class="text-center">Tiada data untuk tempoh yang dipilih.</td>
        </tr>
        @endforelse
    </tbody>
    @if($summary->isNotEmpty())
    <tfoot>
        <tr>
            <td colspan="2" class="text-right">Jumlah Keseluruhan Unit</td>
            <td class="text-center">{{ $grandTotal }}</td>
        </tr>
    </tfoot>
    @endif
</table>

<div class="footer">
    Dijana: {{ now()->format('d/m/Y H:i') }}
</div>

</body>
</html>
