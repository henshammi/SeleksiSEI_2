<!DOCTYPE html>
<html>
<head>
    <title>Tambah Proyek</title>
</head>
<body>

    <h1>Tambah Proyek Baru</h1>

    <?php if ($this->session->flashdata('message')): ?>
        <p><?php echo $this->session->flashdata('message'); ?></p>
    <?php endif; ?>

    <?php echo form_open('proyek/store_proyek'); ?>

    <p>
        <label for="nama_proyek">Nama Proyek:</label>
        <input type="text" name="nama_proyek" value="<?php echo set_value('nama_proyek'); ?>">
        <?php echo form_error('nama_proyek'); ?>
    </p>

    <p>
        <label for="client">Client:</label>
        <input type="text" name="client" value="<?php echo set_value('client'); ?>">
        <?php echo form_error('client'); ?>
    </p>

    <p>
        <label for="tgl_mulai">Tanggal Mulai:</label>
        <input type="date" name="tgl_mulai" value="<?php echo set_value('tgl_mulai'); ?>">
        <?php echo form_error('tgl_mulai'); ?>
    </p>

    <p>
        <label for="tgl_selesai">Tanggal Selesai:</label>
        <input type="date" name="tgl_selesai" value="<?php echo set_value('tgl_selesai'); ?>">
        <?php echo form_error('tgl_selesai'); ?>
    </p>

    <p>
        <label for="pimpinan_proyek">Pimpinan Proyek:</label>
        <input type="text" name="pimpinan_proyek" value="<?php echo set_value('pimpinan_proyek'); ?>">
        <?php echo form_error('pimpinan_proyek'); ?>
    </p>

    <p>
        <label for="keterangan">Keterangan:</label>
        <textarea name="keterangan"><?php echo set_value('keterangan'); ?></textarea>
        <?php echo form_error('keterangan'); ?>
    </p>

    <p>
        <input type="submit" value="Simpan">
    </p>

    <?php echo form_close(); ?>

</body>
</html>
