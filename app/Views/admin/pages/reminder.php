<?= $this->extend('admin/layout/template'); ?>

<?= $this->section('content'); ?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>Reminder Akta Cerai</h1>
    </section>

    <section class="content">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Atur Pengingat Akta Cerai</h3>
            </div>
            <div class="box-body">
                <p class="text-muted">
                    Halaman ini memungkinkan Anda untuk mengatur pengingat bagi pihak terkait yang akta cerainya belum terbit. Anda dapat memilih jumlah hari tertentu sebagai interval pengingat, yang dihitung dari tanggal pendaftaran perkara. Sistem akan secara otomatis mengirimkan notifikasi melalui WhatsApp ke nomor yang terdaftar dalam data perkara, sesuai dengan interval yang telah Anda tentukan.<br><br>
                    Tujuan dari pengingat ini adalah memastikan bahwa pihak yang terkait dapat selalu mendapatkan informasi terkini tentang status penerbitan akta cerai mereka, terutama jika waktu penerbitan belum tercapai. Dengan pengingat ini, diharapkan pihak yang bersangkutan dapat melakukan persiapan atau langkah lebih lanjut jika diperlukan, seperti melakukan pengecekan ulang atau mendatangi kantor Pengadilan Agama terkait.<br><br>
                    Silakan tentukan jumlah hari pada form di bawah ini, yang akan digunakan sebagai interval pengingat. Sebagai contoh, jika Anda memilih "3 Hari", maka sistem akan mencari data perkara dengan tanggal pendaftaran yang berselisih 3 hari dari hari ini dan mengirimkan notifikasi kepada pihak yang bersangkutan bahwa akta cerai mereka masih dalam proses atau belum terbit.
                </p>

                <form action="<?= base_url('admin/sendReminder') ?>" method="post">
                    <?= csrf_field(); ?> <!-- Menambahkan CSRF token -->
                    <div class="form-group">
                        <label for="reminder_days">Masukkan Jumlah Hari:</label>
                        <select name="reminder_days" id="reminder_days" class="form-control" required>
                            <option value="3">3 Hari</option>
                            <?php for ($i = 1; $i <= 10; $i++): ?>
                                <?php if ($i != 3): ?>
                                    <option value="<?= $i ?>"><?= $i ?> Hari</option>
                                <?php endif; ?>
                            <?php endfor; ?>
                        </select>
                        <small class="form-text text-muted">Pilih jumlah hari untuk pengingat.</small>
                    </div>
                    <button type="submit" class="btn btn-primary">Kirim Pengingat</button>
                </form>
            </div>
        </div>

        <!-- Card untuk menampung alert, hanya tampil jika ada pesan -->
        <?php if (session()->getFlashdata('success_message') || session()->getFlashdata('error_message')): ?>
            <div class="box box-primary mt-3">
                <div class="box-header with-border">
                    <h3 class="box-title">Pesan</h3>
                </div>
                <div class="box-body">
                    <!-- Alert untuk pesan sukses atau error -->
                    <?php if (session()->getFlashdata('success_message')): ?>
                        <div class="alert alert-success">
                            <?= session()->getFlashdata('success_message') ?>
                        </div>
                    <?php endif; ?>
                    <?php if (session()->getFlashdata('error_message')): ?>
                        <div class="alert alert-danger">
                            <?= session()->getFlashdata('error_message') ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </section>
</div>

<?= $this->endSection(); ?>