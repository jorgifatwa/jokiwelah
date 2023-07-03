<section class="content-header">
  <h1>
    Aktivitas
  </h1>
  <ol class="breadcrumb">
    <li><a href="#">Aktivitas</a></li>
    <li class="active">Tambah Aktivitas Baru</li>
  </ol>
</section>
<section class="content">
  <div class="box box-default color-palette-box">
    <div class="box-header with-border">
    <h3 class="box-title">Tambah Aktivitas Baru</h3>
    </div>
    <form id="form" method="post">
    <div class="box-body">
      <div class="form-group row">
        <label class="form-label col-sm-3" for="">Tanggal</label>
        <div class="col-sm-4">
          <input type="hidden" name="breakdown_id" id="breakdown_id" value="<?php echo $breakdown_id ?>">
          <input class="form-control" type="text" id="tanggal" name="tanggal" autocomplete="off" required placeholder="Tanggal">
        </div>
      </div>
      <div class="form-group row">
        <label class="form-label col-sm-3" for="">Start</label>
        <div class="col-sm-4">
          <input class="form-control" type="text" id="start" name="start" autocomplete="off" required placeholder="Start">
        </div>
      </div>
      <div class="form-group row">
        <label class="form-label col-sm-3" for="">Stop</label>
        <div class="col-sm-4">
          <input class="form-control" type="text" id="stop" name="stop" autocomplete="off" required placeholder="Stop">
        </div>
      </div>
      <div class="form-group row">
        <label class="form-label col-sm-3" for="">Waktu Habis</label>
        <div class="col-sm-4">
          <input class="form-control" type="text" id="time_down" name="time_down" autocomplete="off" required placeholder="Waktu Habis">
        </div>
      </div>
      <div class="form-group row">
        <label class="form-label col-sm-3" for="">HM</label>
        <div class="col-sm-4">
          <input class="form-control" type="text" id="hm" name="hm" autocomplete="off" required placeholder="HM">
        </div>
      </div>
      <div class="form-group row">
        <label class="form-label col-sm-3" for="">Deskripsi Masalah</label>
        <div class="col-sm-4">
          <textarea class="form-control" id="trouble_description" name="trouble_description" autocomplete="off" placeholder="Trouble Description"></textarea>
        </div>
      </div>
      <div class="form-group row">
        <label class="form-label col-sm-3" for="">Aktivitas</label>
        <div class="col-sm-4">
          <textarea class="form-control" id="activity" name="activity" autocomplete="off" placeholder="Aktivitas"></textarea>
        </div>
      </div>
      <div class="form-group row">
        <label class="form-label col-sm-3" for="">Status</label>
        <div class="col-sm-4">
          <select name="status" id="status" class="form-control">
            <option value="">Pilih Status</option>
            <option value="Continue">Continue</option>
            <option value="Finish">Finish</option>
          </select>
        </div>
      </div>
      <div class="form-group row">
        <label class="form-label col-sm-3" for="">Komponen Frekuensi</label>
        <div class="col-sm-4">
          <input type="text" class="form-control" name="component_freq" id="component_freq" placeholder="Komponen Frekuensi">
        </div>
      </div>
      <div class="form-group row">
        <label class="form-label col-sm-3" for="">Komponen Durasi</label>
        <div class="col-sm-4">
          <input type="text" class="form-control" name="component_dura" id="component_dura" placeholder="Komponen Durasi">
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
