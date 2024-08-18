<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Proyek</title>
</head>
<body>
    <h1>Edit Proyek</h1>
    <form action="<?= base_url('proyek/update_proyek/' . $proyek['id']); ?>" method="post">
        <label for="nama_proyek">Nama Proyek:</label>
        <input type="text" name="nama_proyek" value="<?= $proyek['nama_proyek']; ?>" required>
        <br>
        <label for="client">Client:</label>
        <input type="text" name="client" value="<?= $proyek['client']; ?>" required>
        <br>
        <label for="tgl_mulai">Tanggal Mulai:</label>
        <input type="datetime-local" name="tgl_mulai" value="<?= date('Y-m-d\TH:i', strtotime($proyek['tgl_mulai'])); ?>" required>
        <br>
        <label for="tgl_selesai">Tanggal Selesai:</label>
        <input type="datetime-local" name="tgl_selesai" value="<?= date('Y-m-d\TH:i', strtotime($proyek['tgl_selesai'])); ?>" required>
        <br>
        <label for="pimpinan_proyek">Pimpinan Proyek:</label>
        <input type="text" name="pimpinan_proyek" value="<?= $proyek['pimpinan_proyek']; ?>" required>
        <br>
        <label for="keterangan">Keterangan:</label>
        <textarea name="keterangan" required><?= $proyek['keterangan']; ?></textarea>
        <br>
        <button type="submit">Update Proyek</button>
    </form>
    <a href="<?= base_url('proyek'); ?>">Kembali ke Daftar Proyek</a>
</body>
</html>
