<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title; ?></title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #444; padding-bottom: 10px; }
        .header h2 { margin: 0; text-transform: uppercase; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table th, table td { border: 1px solid #666; padding: 8px; text-align: left; }
        table th { background-color: #f2f2f2; font-weight: bold; text-align: center; }
        .text-center { text-align: center; }
        .footer { margin-top: 30px; text-align: right; font-style: italic; font-size: 10px; }
        @media print {
            .no-print { display: none; }
            @page { margin: 1cm; }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="header">
        <h2>Dadan Library</h2>
        <p>Laporan Data Koleksi Buku Perpustakaan</p>
        <small>Dicetak pada: <?= date('d/m/Y H:i'); ?> WIB</small>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>Judul Buku</th>
                <th>Penulis</th>
                <th>ISBN</th>
                <th>Kategori</th>
                <th width="10%">Tahun</th>
                <th width="8%">Stok</th>
            </tr>
        </thead>
       <tbody>
    <?php if (!empty($buku)) : ?>
        <?php $no = 1; foreach ($buku as $b) : ?>
            <tr>
                <td style="text-align:center;"><?= $no++; ?></td>
                <td><strong><?= $b['judul']; ?></strong></td>
                <td><?= $b['nama_penulis'] ?? 'Tidak ada penulis'; ?></td>
                <td style="text-align:center;"><?= $b['isbn']; ?></td>
                <td><?= $b['nama_kategori'] ?? 'Tanpa kategori'; ?></td>
                <td style="text-align:center;"><?= $b['tahun_terbit']; ?></td>
                <td style="text-align:center;"><?= $b['jumlah']; ?></td>
            </tr>
        <?php endforeach; ?>
    <?php else : ?>
        <tr>
            <td colspan="7" style="text-align:center;">Data buku belum ada di database.</td>
        </tr>
    <?php endif; ?>
</tbody>
    </table>

    <div class="footer">
        Dokumen ini dihasilkan secara otomatis oleh Sistem Dadan Library.
    </div>

    <div class="no-print" style="margin-top: 20px; text-align: center;">
        <button onclick="window.print()" style="padding: 10px 20px; cursor: pointer;">Klik Cetak Lagi</button>
        <a href="<?= base_url('buku'); ?>" style="padding: 10px 20px; text-decoration: none; background: #eee; color: #000; border: 1px solid #ccc; margin-left: 10px;">Kembali</a>
    </div>

</body>
</html>