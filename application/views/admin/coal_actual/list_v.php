<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Coal Aktual</h1>
        <p class="m-0">Coal Production Plan</p>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo base_url() ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="breadcrumb-item active">Coal Aktual</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</section>

<section class="content">
    <div class="container-fluid">
        <div class="card mb-3">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-inline">
                            <button class="btn btn-primary mr-2" id="reset">Lihat Semua</button>
                            <input type="text" class="form-control tanggal" name="filter-tanggal" id="filter-tanggal" placeholder="Tanggal" autocomplete="off" value="<?php echo date('d-m-Y') ?>">
                        </div>
                    </div>
                    <div class="col-md-6 text-right">
                        <?php if ($is_can_create) {?>
                            <!-- <button type="button" class="btn btn-primary btn-sm" id="btn-production"><i class="fa fa-plus"></i> Production JS</button> -->
                            <a href="coal_actual/create" class="btn btn-primary"><i class="fa fa-plus"></i> Coal Aktual</a>
                        <?php }?>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-data table-striped table-bordered" id="table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Jam</th>
                                <th>Shift</th>
                                <th>Aktivitas</th>
                                <th>Loading Unit</th>
                                <th>Hauling Unit</th>
                                <th>Site</th>
                                <th>Seam</th>
                                <th>Dumping</th>
                                <th>Gross<br>(ton)</th>
                                <th>Netto<br>(ton)</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<script data-main="<?php echo base_url() ?>assets/js/main/main-coal-actual" src="<?php echo base_url() ?>assets/js/require.js"></script>
<!-- /.content -->