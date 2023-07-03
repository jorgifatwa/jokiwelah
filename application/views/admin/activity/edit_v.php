<section class="content-header">
  <h1>
    Aktivitas
  </h1>
  <ol class="breadcrumb">
    <li><a href="#">Aktivitas</a></li>
    <li class="active">Ubah Aktivitas</li>
  </ol>
</section>
<section class="content">
  <div class="box box-default color-palette-box">
    <div class="box-header with-border">
    <h3 class="box-title">Ubah Aktivitas</h3>
    </div>
    <form id="form" method="post">
    <div class="box-body">
      <div class="form-group row">
        <label class="form-label col-sm-3" for="">Tanggal</label>
        <div class="col-sm-4">
          <input type="hidden" name="breakdown_id" id="breakdown_id" value="<?php echo $breakdown_id ?>">
          <input type="hidden" name="id" id="id" value="<?php echo $id ?>">
          <input class="form-control" type="text" id="tanggal" name="tanggal" autocomplete="off" required placeholder="Tanggal" value="<?php echo $tanggal ?>">
        </div>
      </div>
      <div class="form-group row">
        <label class="form-label col-sm-3" for="">Start</label>
        <div class="col-sm-4">
          <input class="form-control" type="text" id="start" name="start" autocomplete="off" required placeholder="Start" value="<?php echo $start ?>">
        </div>
      </div>
      <div class="form-group row">
        <label class="form-label col-sm-3" for="">Stop</label>
        <div class="col-sm-4">
          <input class="form-control" type="text" id="stop" name="stop" autocomplete="off" required placeholder="Stop" value="<?php echo $stop ?>">
        </div>
      </div>
      <div class="form-group row">
        <label class="form-label col-sm-3" for="">Waktu Habis</label>
        <div class="col-sm-4">
          <input class="form-control" type="text" id="time_down" name="time_down" autocomplete="off" required placeholder="Waktu Habis" value="<?php echo $time_down ?>">
        </div>
      </div>
      <div class="form-group row">
        <label class="form-label col-sm-3" for="">HM</label>
        <div class="col-sm-4">
          <input class="form-control" type="text" id="hm" name="hm" autocomplete="off" required placeholder="HM" value="<?php echo $hm ?>">
        </div>
      </div>
      <div class="form-group row">
        <label class="form-label col-sm-3" for="">Deskripsi Masalah</label>
        <div class="col-sm-4">
          <textarea class="form-control" id="trouble_description" name="trouble_description" autocomplete="off" placeholder="Trouble Description"><?php echo $trouble ?></textarea>
        </div>
      </div>
      <div class="form-group row">
        <label class="form-label col-sm-3" for="">Aktivitas</label>
        <div class="col-sm-4">
          <textarea class="form-control" id="activity" name="activity" autocomplete="off" placeholder="Aktivitas"><?php echo $activity ?></textarea>
        </div>
      </div>
      <div class="form-group row">
        <label class="form-label col-sm-3" for="">Status</label>
        <div class="col-sm-4">
          <select name="status" id="status" class="form-control">
              <option value="">Pilih Status</option>
              <option value="Continue" <?php if($status == "Continue"){ echo "selected"; } ?>>Continue</option>
              <option value="Finish" <?php if($status == "Finish"){ echo "selected"; } ?>>Finish</option>
            </select>
        </div>
      </div>
      <div class="form-group row">
        <label class="form-label col-sm-3" for="">Komponen Frekuensi</label>
        <div class="col-sm-4">
          <input type="text" class="form-control" name="component_freq" id="component_freq" placeholder="Komponen Frekuensi" value="<?php echo $component_freq ?>">
        </div>
      </div>
      <div class="form-group row">
        <label class="form-label col-sm-3" for="">Komponen Durasi</label>
        <div class="col-sm-4">
          <input type="text" class="form-control" name="component_dura" id="component_dura" placeholder="Komponen Durasi" value="<?php echo $component_dura ?>">
        </div>
      </div>
    </div>
    <div class="box-footer">
      <div class="row">
        <div class="col-sm-12 text-right">
          <a href="<?php echo base_url('breakdown/activity/'.$breakdown_id) ?>" class="btn btn-secondary text-black">Batal</a>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </div>
    </div>
    </form>
  </div>
</section>

              
<script data-main="<?php echo base_url()?>assets/js/main/main-activity" src="<?php echo base_url()?>assets/js/require.js"></script>

  
</section>
