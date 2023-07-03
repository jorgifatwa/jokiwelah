<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">OB Plan Baru</h1>
        <p class="m-0">OB Plan</p>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo base_url() ?>ob_plan"></i>OB Plan</a></li>
          <li class="breadcrumb-item active">OB Plan Baru</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</section>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <form id="form-create" name="form">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                            <label class="form-label">Lokasi</label>
                            <select class="js-example-basic location_id" name="location_id" id="location_id">
                                <option value="">Pilih Lokasi</option>
                                <?php if (!empty($locations)) {
	foreach ($locations as $key => $value) {
		?>
                                <option value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                                <?php }}?>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Unit</label>
                            <select class="js-example-basic unit" name="unit" id="unit">
                                <option value="">Pilih Unit</option>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Bulan</label>
                            <select class="form-control bulan_input" name="bulan_input" id="bulan_input">
                                <option value="">Pilih Bulan</option>
                                <?php if (!empty($bulan)) {
	foreach ($bulan as $key => $value) {
		?>
                                    <option <?php if ($key == date("n")) {echo "selected";}?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                <?php }}?>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Tahun</label>
                            <input type="text" class="form-control tahun_input" name="tahun_input" id="tahun_input" placeholder="Pilih Tahun" value="<?php echo date("Y"); ?>">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Nilai</label>
                            <div class="input-group">
                                <input type="text" class="form-control nilai_input" name="nilai_input" id="nilai_input" placeholder="Masukan Nilai" autocomplete="off">
                                <div class="input-group-append">
                                    <span class="input-group-text">bcm</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-top:1%">
                        <div class="col-md-12 text-right">
                            <a href="<?php echo base_url() ?>ob_plan" class="btn btn-danger">Batal</a>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Plan</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div id="calendar"></div>
                </div>
            </form>
        </div>
    </div>
</section>
<script data-main="<?php echo base_url() ?>assets/js/main/main-ob-plan" src="<?php echo base_url() ?>assets/js/require.js"></script>