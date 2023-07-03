 <section class="content-header">
  <h1>
    <?php echo ucwords(str_replace("_"," ",$this->uri->segment(1)))?>
    <small></small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active"><?php echo ucwords(str_replace("_"," ",$this->uri->segment(1)))?></li>
  </ol>
</section>

<section class="content">
  <div class="box mb-3">
  <div class="box-header">
    <div class="row">
      <div class="col-sm-6">
        Data Aktivitas
      </div>
      <div class="col-sm-6 text-right">
        <?php if($is_can_create){ ?>
          <input type="hidden" id="id" name="id" value="<?php echo $this->uri->segment(3) ?>">
          <a href="<?php echo base_url('activity/create/'.$this->uri->segment(3))?>" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Aktivitas</a>
        <?php } ?>
      </div>
    </div>
  </div>
  <div class="box-body">
    <div class="table-responsive">
      <table class="table table-striped table-bordered" id="table" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>No Urut</th>
            <th>Tanggal</th>  
            <th>Mulai</th>  
            <th>Berhenti</th>  
            <th>Waktu Habis</th>  
            <th>HM</th>  
            <th>Deskripsi Masalah</th>  
            <th>Aktvitas</th>  
            <th>Status</th>  
            <th>Komponen Frekuensi</th>  
            <th>Komponen Durasi</th>  
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
 <script data-main="<?php echo base_url()?>assets/js/main/main-activity" src="<?php echo base_url()?>assets/js/require.js"></script>