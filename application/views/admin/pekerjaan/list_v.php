<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Pekerjaan</h1>
        <p class="m-0">Transaksi</p>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo base_url() ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="breadcrumb-item active">Pekerjaan</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</section>

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-6 col-6">
        <div class="small-box bg-info">
          <div class="inner">
            <h3>Rp.<?php echo number_format($salary); ?></h3>
            <p>Pendapatan Saat Ini</p>
          </div>
          <div class="icon">
            <i class="fa fa-coins"></i>
          </div>
          <?php if($this->data['users']->id == 1){ ?>
            <a href="<?php echo base_url() ?>history_pekerjaan" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          <?php }else{ ?>
            <a href="<?php echo base_url('history_pekerjaan'.$this->data['users']->id) ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          <?php } ?>
        </div>
      </div>
      <div class="col-lg-6 col-6">
        <div class="small-box bg-danger">
          <div class="inner">
            <h3><?php echo $uncompleted_job ?></h3>
            <p>Pekerjaan Yang Belum Selesai</p>
          </div>
          <div class="icon">
            <i class="fa fa-exclamation-triangle "></i>
          </div>
          <p class="small-box-footer">
            <br>
          </p>
        </div>
      </div>
    </div>
    <div class="card mb-3">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-12 text-right">
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nomor Faktur</th>
                            <th>Nomor Whatsapp</th>
                            <th>Paket</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<script data-main="<?php echo base_url() ?>assets/js/main/main-pekerjaan" src="<?php echo base_url() ?>assets/js/require.js"></script>