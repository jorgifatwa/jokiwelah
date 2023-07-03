<style>
  body{
    margin-top:20px;
    background:#f5f7fa;
  }
  .panel.panel-default {
      border-top-width: 3px;
  }
  .panel {
      box-shadow: 0 3px 1px -2px rgba(0,0,0,.14),0 2px 2px 0 rgba(0,0,0,.098),0 1px 5px 0 rgba(0,0,0,.084);
      border: 0;
      border-radius: 4px;
      margin-bottom: 16px;
  }
  .thumb96 {
      width: 96px!important;
      height: 96px!important;
  }
  .thumb48 {
      width: 48px!important;
      height: 48px!important;
  }
</style>
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Order</h1>
        <p class="m-0">Master Data</p>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo base_url() ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="breadcrumb-item active">Order</li>
          <li class="breadcrumb-item active">Detail</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</section>

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-4 col-4">
        <div class="card">
          <div class="card-body">
            <center>
              <img class="img-responsive img-circle img-thumbnail thumb96" src="https://bootdey.com/img/Content/avatar/avatar1.png" alt="Contact">
              <h5 class="m0 text-bold"><?php echo $nickname ?></h5>
            </center>
          </div>
        </div>
      </div>
      <div class="col-md-8 col-8">
        <div class="small-box <?php echo $background ?>">
          <div class="inner text-white">
            <h3><?php echo $status ?></h3>
            <p>Status</p>
          </div>
          <div class="icon mb-3">
            <i class="fa fa-chart-bar"></i>
          </div>
          <p class="small-box-footer" style="height: 40px;">
            <br>
          </p>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="div col-md-6">
        <div class="card">
          <div class="card-header bg-light">
            <h4>Data Order</h4>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-12">
                <table class="mb-3">
                  <tr>
                    <td>Nomor Faktur</td>
                    <td>:</td>
                    <td><?php echo $no_faktur ?></td>
                  </tr>
                  <tr>
                    <td>Tanggal</td>
                    <td>:</td>
                    <td><?php echo $tanggal ?></td>
                  </tr>
                  <tr>
                    <td>Nomor Whatsapp</td>
                    <td>:</td>
                    <td><?php echo $nomor_whatsapp ?></td>
                  </tr>
                  <tr>
                    <td>Request Hero</td>
                    <td>:</td>
                    <td><?php echo $request_hero ?></td>
                  </tr>
                  <tr>
                    <td>Pelayanan</td>
                    <td>:</td>
                    <td><?php echo $pelayanan_name ?></td>
                  </tr>
                  <?php if($id_pelayanan == 5){ ?>
                    <tr>
                      <td>Dari Rank</td>
                      <td>:</td>
                      <td><?php echo $dari_rank_name; ?>  ( <?php if($dari_rank_id < 6){ echo "Bintang ".$dari_bintang; }else{ echo "Point ".$dari_point; } ?> )</td>
                    </tr>
                    <tr>
                      <td>Sampai Rank</td>
                      <td>:</td>
                      <td><?php echo $sampai_rank_name; ?>  ( <?php if($sampai_rank_id < 6){ echo "Bintang ".$sampai_bintang; }else{ echo "Point ".$sampai_point; } ?> )</td>
                    </tr>
                  <?php } ?>
                  <?php if(isset($paket_name) && $paket_name != ""){ ?>
                    <tr>
                      <td>Paket</td>
                      <td>:</td>
                      <td><?php echo $paket_name ?></td>
                    </tr>
                  <?php } ?>
                  <tr>
                    <td>Catatan</td>
                    <td>:</td>
                    <td><?php echo $catatan ?></td>
                  </tr>
                  <tr>
                    <td>Bukti Pembayaran</td>
                    <td>:</td>
                    <td><a href="<?php echo base_url('uploads/order/'.$bukti_pembayaran) ?>" target="blank" class="btn btn-info"><span class="fa fa-eye"></span> Preview</a> <a href="<?php echo base_url('uploads/order/'.$bukti_pembayaran) ?>" class="btn btn-primary" download><span class="fa fa-download"></span> Download</a></td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row col-md-6">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header bg-light">
              <h4>Data Akun</h4>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-12">
                  <table class="mb-3">
                    <tr>
                      <td>Email</td>
                      <td>:</td>
                      <td><?php echo $email ?></td>
                    </tr>
                    <tr>
                      <td>Password</td>
                      <td>:</td>
                      <td><?php echo $password ?></td>
                    </tr>
                    <tr>
                      <td>Nickname</td>
                      <td>:</td>
                      <td><?php echo $nickname ?></td>
                    </tr>
                    <tr>
                      <td>Login Via</td>
                      <td>:</td>
                      <td><?php echo $login_via ?></td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="small-box bg-success">
            <div class="inner text-white">
              <h3><?php echo "Rp.".number_format($total_harga) ?></h3>
              <p>Total</p>
            </div>
            <div class="icon mb-3">
              <i class="fa fa-coins"></i>
            </div>
            <p class="small-box-footer" style="height: 40px;">
              <br>
            </p>
          </div>
        </div>
      </div>
    </div>
	</div>
</section>
 <script data-main="<?php echo base_url() ?>assets/js/main/main-order" src="<?php echo base_url() ?>assets/js/require.js"></script>