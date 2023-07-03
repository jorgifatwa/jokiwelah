<section class="content-header">
      <h1>
        Breakdown
      </h1>
      <ol class="breadcrumb">
        <li><a href="#">Breakdown</a></li>
        <li class="active">Edit Breakdown</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Table -->
      <div class="box">
        <form id="form" method="post">
          <div id="isi">
            <div class="box-body">
              <div class="form-group row">
                <label class="form-label col-sm-3">Tanggal BD</label>
                <div class="col-sm-4">
                  <input type="hidden" class="form-control" name="id" id="id" value="<?php echo $id ?>">
                  <input type="text" class="form-control" name="tanggal_bd" id="tanggal_bd" value="<?php echo $tanggal_bd ?>">
                </div>
              </div>
              <div class="form-group row">
                <label class="form-label col-sm-3">Lokasi</label>
                <div class="col-sm-4">
                  <select class="form-control" name="location_id" id="location_id">
                    <option selected hidden disabled>Pilih Lokasi</option>
                    <?php foreach($locations as $location){?>
                      <option value="<?php echo $location->id;?>" <?php if ($location->id == $location_id) { echo "selected"; } ?>><?php echo $location->name;?></option>
                    <?php }?>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label class="form-label col-sm-3">Loading Unit</label>
                <div class="col-sm-4">
                  <select class="form-control" name="loading_unit_id" id="loading_unit_id">
                    <option selected hidden disabled>Pilih Loading Unit</option>
                    <?php foreach ($loading_unit as $key => $loading) { ?>
                      <option <?php if($loading->id == $unit_id){ echo "selected"; } ?> 
                      value="<?php echo $loading->id ?>"><?php echo $loading->kode."--".$loading->brand_name." - ".$loading->unit_model_name; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label class="form-label col-sm-3">Job Status</label>
                <div class="col-sm-4">
                  <select class="form-control" name="job_status_id" id="job_status_id">
                    <option selected hidden disabled>Pilih Job Status</option>
                    <?php foreach($job_status as $job){?>
                      <option value="<?php echo $job->id;?>" <?php if ($job->id == $job_status_id) { echo "selected"; } ?>><?php echo $job->name."-".$job->description;?></option>
                    <?php }?>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label class="form-label col-sm-3">Deskripsi Masalah</label>
                <div class="col-sm-4">
                  <textarea name="trouble_description" id="trouble_description" class="form-control" cols="30" rows="3" placeholder="Masukkan Deskripsi Masalah"><?php echo $trouble ?></textarea>
                </div>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <div class="box-footer">
            <div class="row">
              <div class="col-sm-12 text-right">
                <a href="<?php echo base_url() ?>breakdown" class="btn btn-secondary text-black">Batal
                </a>
                <button type="submit" class="btn btn-primary" id="btn-submit">Simpan</button>
              </div>
            </div>
          </div>
        </form>
      </div>
      <!-- Table -->

    </section>
    <script data-main="<?php echo base_url()?>assets/js/main/main-breakdown" src="<?php echo base_url()?>assets/js/require.js"></script>
    <!-- /.content -->