<?= $this->extend('admin/layout/template'); ?>


<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Dashboard
      <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-lg-6 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
          <div class="inner">
            <h3><?= $jumlah_perkara; ?></h3>
            <p>Perkara</p>
          </div>
          <div class="icon">
            <i class="ion ion-document-text"></i>
          </div>
          <a href="/admin/dataperkara" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-6 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
          <div class="inner">
            <h3><?= $jumlah_akta_cerai; ?></h3>
            <p>Akta Cerai</p>
          </div>
          <div class="icon">
            <i class="ion ion-folder"></i>
          </div>
          <a href="/admin/aktacerai/" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
    </div>
    <!-- /.row -->
    <div class="row">
      <div class="col-md-12">
        <!-- PRODUCT LIST -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title"><strong>Si NOPAL</strong> (Sistem Informasi Notifikasi dan Delivery Akta Cerai Langsung)</h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse">
                <i class="fa fa-minus"></i>
              </button>
              <button type="button" class="btn btn-box-tool" data-widget="remove">
                <i class="fa fa-times"></i>
              </button>
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <p>
              <strong>Si NOPAL (Sistem Informasi Notifikasi dan Delivery Akta Cerai Langsung)</strong> adalah aplikasi berbasis web
              yang digunakan di <strong>Pengadilan Agama Tanggamus</strong>. Aplikasi ini dirancang untuk mempermudah
              pengelolaan, notifikasi, dan pengiriman akta cerai secara cepat dan efisien.
            </p>

            <h5>Fitur Utama:</h5>
            <ul>
              <li><strong>Manajemen Data Akta Cerai:</strong> Menyimpan informasi pemohon, termohon, dan status penerbitan akta.</li>
              <li><strong>Notifikasi Otomatis:</strong> Mengirim pemberitahuan melalui <em>WhatsApp</em> dan email terkait status akta cerai.</li>
              <li><strong>Layanan Delivery:</strong> Setelah akta terbit, dokumen dapat dikirim langsung kepada pihak terkait.</li>
              <li><strong>Pengelolaan User:</strong> Admin dapat mengatur data pengguna dan mengontrol akses aplikasi.</li>
            </ul>

            <h5>Manfaat:</h5>
            <ul>
              <li><strong>Efisiensi:</strong> Mempercepat pemberitahuan dan pengiriman akta cerai.</li>
              <li><strong>Transparansi:</strong> Pihak terkait mendapatkan informasi status yang jelas dan tepat waktu.</li>
              <li><strong>Aksesibilitas:</strong> Dapat dikelola dari mana saja secara daring.</li>
              <li><strong>Otomasi:</strong> Notifikasi otomatis mengurangi potensi kesalahan komunikasi.</li>
            </ul>

            <p>
              Dengan implementasi di <strong>Pengadilan Agama Tanggamus</strong>, proses penerbitan dan distribusi akta cerai menjadi lebih
              mudah, cepat, dan nyaman bagi semua pihak. Aplikasi ini memastikan pelayanan yang lebih baik dan transparan.
            </p>
          </div>
          <!-- /.box-body -->
        </div>
      </div>
    </div>
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?= $this->endSection(); ?>