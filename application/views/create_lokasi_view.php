<!DOCTYPE html>
<html>
<head>
    <title>Tambah Lokasi</title>
</head>
<body>

    <h1>Tambah Lokasi Baru</h1>

    <?php if ($this->session->flashdata('message')): ?>
        <p><?php echo $this->session->flashdata('message'); ?></p>
    <?php endif; ?>

    <?php echo form_open('proyek/store_lokasi'); ?>

    <p>
        <label for="nama_lokasi">Nama Lokasi:</label>
        <input type="text" name="nama_lokasi" value="<?php echo set_value('nama_lokasi'); ?>">
        <?php echo form_error('nama_lokasi'); ?>
    </p>

    <p>
        <label for="negara">Negara:</label>
        <input type="text" name="negara" value="<?php echo set_value('negara'); ?>">
        <?php echo form_error('negara'); ?>
    </p>

    <p>
        <label for="provinsi">Provinsi:</label>
        <input type="text" name="provinsi" value="<?php echo set_value('provinsi'); ?>">
        <?php echo form_error('provinsi'); ?>
    </p>

    <p>
        <label for="kota">Kota:</label>
        <input type="text" name="kota" value="<?php echo set_value('kota'); ?>">
        <?php echo form_error('kota'); ?>
    </p>

    <p>
        <input type="submit" value="Simpan">
    </p>

    <?php echo form_close(); ?>

</body>
</html>
