<section class="content-header">
  <h1>
    <?php echo ucwords(str_replace("_", " ", $this->uri->segment(1))) ?>
    <small></small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active"><?php echo ucwords(str_replace("_", " ", $this->uri->segment(1))) ?></li>
  </ol>
</section>

<section class="content">
<div class="box mb-3">
    <div class="box-header">
      <div class="row">
        <div class="col-sm-6">
          Filter RNS
        </div>
        <div class="col-sm-6 text-right">
        </div>
      </div>
    </div>
    <div class="box-body">
      <div class="row">
        <div class="col-md-4">
          <div class="form-group">
            <label for="">Tanggal Mulai</label>
            <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control">
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label for="">Tanggal Akhir</label>
            <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control">
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label for="">Lokasi</label>
            <select name="lokasi" id="lokasi" class="form-control">
              <option value="">Pilih Lokasi</option>
              <option value="pad">PAD</option>
              <option value="ljm">LJM</option>
            </select>
          </div>
        </div>
      </div>
    </div>
    <div class="box-footer">
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
          <button type="button" class="btn btn-secondary text-black" id="reset">Reset</button> 
          <button type="button" class="btn btn-primary pull-right" id="btn-filter">Filter</button>
        </div>
      </div>
    </div>
  </div>
  <div class="box mb-3">
    <div class="box-header">
      <div class="row">
        <div class="col-sm-6">
          Data RNS
        </div>
      </div>
    </div>
    <div class="box-body">
      <div class="table-responsive">
        <table class="table table-striped table-bordered" id="table" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>Tanggal</th>
              <th>Lokasi</th>
              <th>Rain<br>(hrs)</th>
              <th>Slipper<br>(hrs)</th>
              <th>Frekuensi Hujan</th>
              <th>Rainfall<br>mm</th>
              <th>Total RNS<br>(hrs)</th>
              <th width="20%">Action</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>
 <script data-main="<?php echo base_url() ?>assets/js/main/main-rns" src="<?php echo base_url() ?>assets/js/require.js"></script>