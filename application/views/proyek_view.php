<!DOCTYPE html>
<html>
<head>
    <title>Daftar Proyek dan Lokasi</title>
</head>
<body>

    <h1>Daftar Proyek dan Lokasi</h1>

    <!-- Tambahkan Button untuk Mengarah ke Halaman Create Lokasi -->
    <p>
        <a href="<?php echo site_url('create-lokasi'); ?>">
            <button>Tambah Lokasi Baru</button>
        </a>
        <a href="<?php echo site_url('create-proyek'); ?>">
            <button>Tambah Proyek Baru</button>
        </a>
    </p>

    <h2>Data Proyek</h2>
    <?php if (!empty($proyek)): ?>
        <ul>
        <?php foreach ($proyek as $item): ?>
            <li>
                <strong>Nama Proyek:</strong> <?php echo $item['nama_proyek']; ?><br>
                <strong>Client:</strong> <?php echo $item['client']; ?><br>
                <strong>Tanggal Mulai:</strong> <?php echo $item['tgl_mulai']; ?><br>
                <strong>Tanggal Selesai:</strong> <?php echo $item['tgl_selesai']; ?><br>
                <strong>Pimpinan Proyek:</strong> <?php echo $item['pimpinan_proyek']; ?><br>
                <strong>Keterangan:</strong> <?php echo $item['keterangan']; ?><br>
                <strong>Lokasi:</strong>
                <ul>
                    <?php foreach ($item['lokasi'] as $lokasi): ?>
                        <li><?php echo $lokasi['nama_lokasi'] . ', ' . $lokasi['kota'] . ', ' . $lokasi['provinsi'] . ', ' . $lokasi['negara']; ?></li>
                    <?php endforeach; ?>
                </ul>
            </li>
        <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Tidak ada data proyek yang tersedia.</p>
    <?php endif; ?>

    <h2>Data Lokasi</h2>
    <?php if (!empty($lokasi)): ?>
        <ul>
        <?php foreach ($lokasi as $item): ?>
            <li>
                <strong>Nama Lokasi:</strong> <?php echo $item['nama_lokasi']; ?><br>
                <strong>Negara:</strong> <?php echo $item['negara']; ?><br>
                <strong>Provinsi:</strong> <?php echo $item['provinsi']; ?><br>
                <strong>Kota:</strong> <?php echo $item['kota']; ?><br>
                <a href="<?php echo site_url('edit-lokasi/' . $item['id']); ?>">Edit</a>
            </li>
        <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Tidak ada data lokasi yang tersedia.</p>
    <?php endif; ?>

</body>
</html>
