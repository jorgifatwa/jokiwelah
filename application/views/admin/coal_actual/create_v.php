<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Coal Aktual Baru</h1>
        <p class="m-0">Coal Aktual</p>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo base_url() ?>coal_aktual"></i>Coal Aktual</a></li>
          <li class="breadcrumb-item active">Coal Aktual Baru</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</section>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <form id="form-actual" method="post">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Nomor Tiket</label>
                                <input type="text" class="form-control" name="no_tiket" id="no_tiket" placeholder="Nomor Tiket" value="" readonly>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Tanggal</label>
                                <input type="hidden" id="id">
                                <input type="text" class="form-control tanggal" name="tanggal" id="tanggal" placeholder="Tanggal" autocomplete="off">
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label">Jam Mulai</label>
                                        <input type="text" class="form-control jam" name="jam_mulai" id="jam_mulai" placeholder="Jam Mulai" autocomplete="off">
                                    </div>

                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label">Jam Berakhir</label>
                                        <input type="text" class="form-control jam" name="jam_akhir" id="jam_akhir" placeholder="Jam Berakhir" autocomplete="off">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Shift</label>
                                <select name="shift" id="shift" class="form-control">
                                    <option value="">Pilih Shift</option>
                                    <option value="DS">Day Shift</option>
                                    <option value="NS">Night Shift</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Aktivitas</label>
                                <select name="aktivitas" id="aktivitas" class="form-control">
                                    <option value="">Pilih Aktivitas</option>
                                    <option value="2">Coal Getting</option>
                                    <option value="1">Coal Hauling</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Site</label>
                                <input type="text" class="form-control" name="location" id="location" placeholder="Site" value="<?php echo $location->name; ?>" readonly>
                                <input type="hidden" name="location_id" id="location_id" value="<?php echo $location->id ?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label">PIT</label>
                                <select name="pit_id" id="pit_id" class="form-control">
                                    <option value="">Pilih PIT</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Seam</label>
                                <select class="form-control" name="seam_id" id="seam_id">
                                    <option value="">Pilih Seam</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Blok</label>
                                <select class="form-control" name="blok_id" id="blok_id">
                                    <option value="">Pilih Blok</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Dumping</label>
                                <select class="form-control" name="dumping_id" id="dumping_id">
                                    <option value="">Pilih Dumping</option>
                                    <?php
if (!empty($dumpings)) {
	foreach ($dumpings as $key => $value) {
		?>
                                    <option value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                                    <?php }}?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Loading Unit</label>
                                <select class="form-control" name="loading_unit_id" id="loading_unit_id">
                                    <option value="">Pilih Loading Unit</option>
                                    <?php
if (!empty($loading_unit)) {
	foreach ($loading_unit as $key => $value) {
		?>
                                        <option value="<?php echo $value->id; ?>"><?php echo $value->kode . " - " . $value->brand_name . " - " . $value->unit_model_name; ?></option>
                                    <?php }}?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Loader Name</label>
                                <select class="form-control" name="loader_id" id="loader_id">
                                    <option value="">Pilih Loader Name</option>
                                    <?php
if (!empty($user_location)) {
	foreach ($user_location as $key => $value) {
		?>
                                        <option value="<?php echo $value->id; ?>"><?php echo $value->nik . " - " . $value->first_name . " (" . $value->role_name . ")"; ?></option>
                                    <?php }}?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Hauling Unit</label>
                                <select class="form-control" name="hauling_unit_id" id="hauling_unit_id">
                                    <option value="">Pilih Hauling Unit</option>
                                    <?php foreach ($hauling_unit as $key => $value) {?>
                                    <option value="<?php echo $value->id; ?>"><?php echo $value->kode . " - " . $value->brand_name . " - " . $value->unit_model_name; ?></option>
                                    <?php }?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Hauler Name</label>
                                <select class="form-control" name="hauler_id" id="hauler_id">
                                    <option value="">Pilih Hauler Name</option>
                                    <?php
if (!empty($user_location)) {
	foreach ($user_location as $key => $value) {
		?>
                                        <option value="<?php echo $value->id; ?>"><?php echo $value->nik . " - " . $value->first_name . " (" . $value->role_name . ")"; ?></option>
                                    <?php }}?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Penimbang</label>
                                <select class="form-control" name="penimbang_id[]" id="penimbang_id" multiple="multiple" >
                                    <option value="">Pilih Penimbang</option>
                                    <?php
if (!empty($user_location)) {
	foreach ($user_location as $key => $value) {
		?>
                                        <option value="<?php echo $value->id; ?>"><?php echo $value->nik . " - " . $value->first_name . " (" . $value->role_name . ")"; ?></option>
                                    <?php }}?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="">Material</label>
                                <select name="material_id" id="material_id" class="form-control">
                                    <option value="">Pilih Material</option>
                                    <?php
if (!empty($material)) {
	foreach ($material as $key => $value) {
		?>
                                        <option value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                                    <?php }}?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Distance</label>
                                <div class="input-group">
                                    <input type="text" class="form-control number" name="distance" id="distance" placeholder="Distance">
                                    <div class="input-group-append">
                                        <span class="input-group-text">meter</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Gross</label>
                                <div class="input-group">
                                    <input type="text" class="form-control number" name="gross" id="gross" placeholder="Gross">
                                    <div class="input-group-append">
                                        <span class="input-group-text">ton</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Tare</label>
                                <div class="input-group">
                                    <input type="text" class="form-control number" name="tare" id="tare" placeholder="Tare">
                                    <div class="input-group-append">
                                        <span class="input-group-text">ton</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Netto</label>
                                <div class="input-group">
                                    <input type="text" class="form-control number" name="netto" id="netto" placeholder="Netto" readonly>
                                    <div class="input-group-append">
                                        <span class="input-group-text">ton</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-12 text-right">
                            <a href="<?php echo base_url() ?>coal_actual" class="btn btn-danger">Batal
                            </a>
                            <button type="submit" class="btn btn-success" id="simpan_kembali">Simpan & Kembali</button>
                            <button type="submit" class="btn btn-primary" id="simpan">Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<script data-main="<?php echo base_url() ?>assets/js/main/main-coal-actual" src="<?php echo base_url() ?>assets/js/require.js"></script>