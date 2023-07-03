<section class="content-header">
  <h1>
    Fleet Event
  </h1>
  <ol class="breadcrumb">
    <li><a href="#">Fleet Event</a></li>
    <li class="active">Add New</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <!-- Table -->
  <div class="box">
    <form id="form" method="post">
      <div class="box-body">
        <div class="form-group row">
          <label class="form-label col-sm-3">Tanggal</label>
          <div class="col-sm-4">
            <input type="hidden" id="id">
            <input class="form-control form-control" type="text" id="tanggal" name="tanggal" autocomplete="off" placeholder="Tanggal">
          </div>
        </div>
        <div class="form-group row">
          <label class="form-label col-sm-3">Shift</label>
          <div class="col-sm-4">
            <select name="shift" id="shift" class="form-control">
              <option value="">Pilih Shift</option>
              <option value="DS">Day Shift</option>
              <option value="NS">Night Shift</option>
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label class="form-label col-sm-3">Kategori</label>
          <div class="col-sm-4">
            <select name="kategori" id="kategori" class="form-control">
              <option value="">Pilih Kategori</option>
              <option value="OB">OB</option>
              <option value="Coal Getting">Coal Getting</option>
              <option value="Coal Hauling">Coal Hauling</option>
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label class="form-label col-sm-3">Site</label>
          <div class="col-sm-4">
            <select name="location_id" id="location_id" class="form-control">
              <option value="">Pilih Site</option>
              <?php foreach ($locations as $location) { ?>
                <option value="<?php echo $location->id ?>"><?php echo $location->name ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
      </div>
      <div class="box-body">
        <div class="row" id="isi">
          <div class="col-md-3 border-responsive">  
            <label class="form-label">Loading Unit</label>
            <select class="js-example-basic" name="loading_unit_id" id="loading_unit_id">
              <option value="">Pilih Unit</option>
            </select>   
          </div>      
          <div class="col-md-4">  
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label class="form-label">Waktu Mulai</label>
                  <input type="text" class="form-control" name="start_time" id="start_time">
                </div>
                <div class="form-group">
                  <label class="form-label">Waktu Berakhir</label>
                  <input type="text" class="form-control" name="end_time" id="end_time">
                </div>
                <div class="form-group">
                  <label class="form-label">Status</label>
                  <select class="form-control" name="fleet_status_id" id="fleet_status_id">
                    <option selected hidden disabled>Pilih Status</option>
                    <?php foreach($fleet_status as $status){?>
                      <option value="<?php echo $status->id;?>"><?php echo $status->name;?></option>
                    <?php }?>
                  </select>
                </div>
                <div class="form-group">
                  <label class="form-label">Alasan</label>
                  <select class="js-example-basic" name="fleet_reason_id" id="fleet_reason_id">
                  </select>
                </div>
                <div class="form-group">
                  <label class="form-label">Catatan</label>
                  <textarea name="catatan" id="catatan" placeholder="Catatan" class="form-control" cols="30" rows="5"></textarea>
                </div>
              </div>                
            </div>
            <!-- /.box-body -->
          </div> 
        </div>
      </div>
      <div class="box-footer">
        <div class="row">
          <div class="col-sm-12 text-right">
            <a href="<?php echo base_url() ?>fleet_event">
                <button type="button" class="btn btn-secondary text-black">Batal</button> 
            </a>
            <button type="submit" class="btn btn-primary" id="btn-submit">Simpan</button>
          </div>
        </div>
      </div>
    </form>
  </div>
  <!-- Table -->

</section>
<script data-main="<?php echo base_url()?>assets/js/main/main-fleet-event" src="<?php echo base_url()?>assets/js/require.js"></script>
<!-- /.content -->