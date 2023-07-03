<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Laporan</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo base_url() ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="breadcrumb-item active">Laporan</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</section>

<section class="content">
    <div class="container-fluid">
        <div class="card mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h4>Hours Meter</h4>
                        <ul>
                            <li><a href="<?php echo base_url('report/hm_monthly'); ?>">Data Per Bulan</a></li>
                            <li><a href="<?php echo base_url('report/hm_location'); ?>">Grafik Per Bulan Berdasarkan Lokasi</a></li>
                            <li><a href="<?php echo base_url('report/hm_operator'); ?>">Grafik Per Bulan Berdasarkan Operator </a></li>
                            <li><a href="<?php echo base_url('report/hm_unit_duration'); ?>">Grafik Per Bulan Berdasarkan Unit Durasi, Breakdown, Standby</a></li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h4>Fleet Event</h4>
                        <ul>
                            <li><a href="<?php echo base_url('report/fe_monthly'); ?>">Data Per Bulan</a></li>
                            <li><a href="<?php echo base_url('report/fe_location'); ?>">Grafik Per Bulan Berdasarkan Lokasi</a></li>
                            <li><a href="<?php echo base_url('report/fe_operator'); ?>">Grafik Per Bulan Berdasarkan Operator </a></li>
                            <li><a href="<?php echo base_url('report/fe_unit_duration'); ?>">Grafik Per Bulan Berdasarkan Unit Durasi, Breakdown, Standby</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
 <script data-main="<?php echo base_url() ?>assets/js/main/main-report" src="<?php echo base_url() ?>assets/js/require.js"></script>