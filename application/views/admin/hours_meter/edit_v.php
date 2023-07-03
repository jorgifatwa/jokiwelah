<section class="content-header">
  <h1>
    Fleet Event
  </h1>
  <ol class="breadcrumb">
    <li><a href="#">Fleet Event</a></li>
    <li class="active">Edit Data</li>
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
            <input type="text" class="form-control" name="tanggal" id="tanggal" value="<?php echo $tanggal ?>">
          </div>
        </div>
        <div class="form-group row">
          <label class="form-label col-sm-3">Shift</label>
          <div class="col-sm-4">
            <?php foreach ($shifts as $shift) { ?>
            <div class="form-check form-check-inline">
              <input class="form-check-input shift" type="radio" name="shift_id" id="shift_id" value="<?php echo $shift->id ?>" <?php if($shift_id == $shift->id){ echo "checked"; } ?>>
              <label class="form-check-label" for="inlineRadio1"><?php echo $shift->description ?></label>
            </div>
            <?php } ?>
          </div>
        </div>
        <div class="form-group row">
          <label class="form-label col-sm-3">Lokasi</label>
          <div class="col-sm-4">
            <select name="location_id" id="location_id" class="form-control">
              <option value="">Pilih Lokasi</option>
              <?php foreach ($locations as $location) { ?>
                <option value="<?php echo $location->id ?>" <?php if($location->id == $location_id){ echo "selected"; } ?>><?php echo $location->name ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
      </div>
      <div class="box-body">
        <div class="row" id="isi">
          <div class="col-md-3 border-responsive">  
            <label class="form-label">Loading Unit</label>
            <select class="js-example-basic" name="unit_id" id="unit_id">
              <?php foreach ($loading_unit as $key => $loading) { ?>
                <option value="<?php echo $loading->id;?>" <?php if($loading->id == $unit_id){ echo "selected"; } ?>><?php echo $loading->kode."--".$loading->brand_name."--".$loading->unit_model_name;?></option>
              <?php } ?>
            </select> 
          </div>      
          <div class="col-md-4">  
            <div class="form-group">
              <label class="form-label">Operator</label>
              <select name="operator_id" id="operator_id" class="form-control">
                <option value="">Pilih Operator</option>
                <?php foreach ($operators as $operator) { ?>
                  <option value="<?php echo $operator->id ?>" <?php if($operator->id == $operator_id){ echo "selected"; }  ?>><?php echo $operator->first_name ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="form-group">
              <label class="form-label">HM Mulai</label>
              <input type="number" class="form-control" name="hm_start" id="start_time" value="<?php echo $hm_start ?>">
            </div>
            <div class="form-group">
              <label class="form-label">HM Terakhir</label>
              <input type="number" class="form-control" name="hm_end" id="end_time" value="<?php echo $hm_end ?>">
            </div>
            <div class="form-group">
              <label class="form-label">Durasi</label>
              <input type="number" readonly="" class="form-control" name="duration" id="duration" placeholder="Durasi" value="<?php echo $duration ?>">
            </div>
            <div class="form-group">
              <label class="form-label">Remarks</label>
              <textarea name="remarks" id="remarks" cols="30" rows="5" class="form-control" placeholder="Remarks"><?php echo $remarks ?></textarea>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="week" id="flexCheckDefault" <?php if($week == "Holiday"){ echo "checked"; } ?>>
              <label class="form-check-label" for="flexCheckDefault">
                Holiday
              </label>
            </div>
          </div>       
        </div>
      </div>
      <div class="box-footer">
        <div class="row">
          <div class="col-sm-12 text-right">
            <a href="<?php echo base_url() ?>hours_meter" class="btn btn-secondary text-black">Batal
            </a>
            <button type="submit" class="btn btn-primary" id="btn-submit">Simpan</button>
          </div>
        </div>
      </div>
    </form>
  </div>
  <!-- Table -->

</section>
<script data-main="<?php echo base_url()?>assets/js/main/main-hours-meter" src="<?php echo base_url()?>assets/js/require.js"></script>
<!-- /.content -->