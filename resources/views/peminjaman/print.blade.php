<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Peminjaman</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body onload="window.print()" class="p-10 text-gray-800">

    <h1 class="text-2xl font-bold text-center mb-6">
        LAPORAN PEMINJAMAN ALAT
    </h1>

    <div class="mb-6">
        <p><strong>Nama Peminjam:</strong> {{ $peminjaman->user->name }}</p>
        <p><strong>Tanggal Pinjam:</strong> {{ $peminjaman->tanggal_pinjam }}</p>
        <p><strong>Rencana Kembali:</strong> {{ $peminjaman->tanggal_kembali_rencana }}</p>
        <p><strong>Status:</strong> {{ ucfirst($peminjaman->status) }}</p>
        <p><strong>Disetujui Oleh:</strong> {{ $peminjaman->petugas?->name ?? '-' }}</p>
    </div>

    <table class="w-full border border-gray-300">
        <thead class="bg-gray-100">
            <tr>
                <th class="border px-3 py-2">Kode</th>
                <th class="border px-3 py-2">Nama Alat</th>
                <th class="border px-3 py-2">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach($peminjaman->detailPeminjaman as $detail)
                <tr>
                    <td class="border px-3 py-2">{{ $detail->alat->kode_alat }}</td>
                    <td class="border px-3 py-2">{{ $detail->alat->nama_alat }}</td>
                    <td class="border px-3 py-2 text-center">{{ $detail->jumlah }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-10 flex justify-between">
        <div>
            <p>Dicetak pada:</p>
            <p>{{ now()->format('d M Y') }}</p>
        </div>

        <div class="text-center">
            <p>Petugas</p>
            <div class="mt-16">( __________________ )</div>
        </div>
    </div>

</body>
</html>
