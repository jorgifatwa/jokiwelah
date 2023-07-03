<section class="content-header">
    <h1>
        Coal Aktual
        <small>Ubah Coal Aktual</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url() ?>coal_actual"></i>Coal Aktual</a></li>
        <li class="active">Ubah Coal Aktual</li>
    </ol>
</section>
<section class="content">
    <div class="box box-default color-palette-box">
        <div class="box-header with-border">
        </div>
        <form id="form-actual" method="post">
            <input type="hidden" name="id" id="id" value="<?php echo $coal_actual->id; ?>">
            <input type="hidden" name="selected_pit" id="selected_pit" value="<?php echo $coal_actual->pit_id; ?>">
            <input type="hidden" name="selected_seam" id="selected_seam" value="<?php echo $coal_actual->seam_id; ?>">
            <input type="hidden" name="selected_blok" id="selected_blok" value="<?php echo $coal_actual->blok_id; ?>">

            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Nomor Tiket</label>
                            <input type="text" class="form-control" name="no_tiket" id="no_tiket" placeholder="Nomor Tiket" value="<?php echo $coal_actual->no_tiket; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Tanggal</label>
                            <input type="hidden" id="id">
                            <input type="text" class="form-control tanggal" name="tanggal" id="tanggal" placeholder="Tanggal" autocomplete="off" value="<?php echo date("d-m-Y", strtotime($coal_actual->tanggal)); ?>">
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label class="form-label">Jam Mulai</label>
                                    <input type="text" class="form-control jam" name="jam_mulai" id="jam_mulai" placeholder="Jam Mulai" autocomplete="off" value="<?php echo date("H:i", strtotime($coal_actual->jam_mulai)); ?>">
                                </div>

                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label class="form-label">Jam Berakhir</label>
                                    <input type="text" class="form-control jam" name="jam_akhir" id="jam_akhir" placeholder="Jam Berakhir" autocomplete="off" value="<?php echo date("H:i", strtotime($coal_actual->jam_akhir)); ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Shift</label>
                            <select name="shift" id="shift" class="form-control">
                                <option value="">Pilih Shift</option>
                                <option value="DS" <?php if ($coal_actual->shift == "DS") {echo "selected";}?>>Day Shift</option>
                                <option value="NS" <?php if ($coal_actual->shift == "NS") {echo "selected";}?>>Night Shift</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Aktivitas</label>
                            <select name="aktivitas" id="aktivitas" class="form-control">
                                <option value="">Pilih Aktivitas</option>
                                <option value="2" <?php if ($coal_actual->aktivitas == 2) {echo "selected";}?>>Coal Getting</option>
                                <option value="1" <?php if ($coal_actual->aktivitas == 1) {echo "selected";}?>>Coal Hauling</option>
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
                            <label class="form-label" for="">PIT</label>
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
                                <option
                                <?php if ($value->id == $coal_actual->dumping_id) {echo "selected";}?>
                                value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
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
                                    <option
                                    <?php if ($value->id == $coal_actual->loading_unit_id) {echo "selected";}?>
                                    value="<?php echo $value->id; ?>"><?php echo $value->kode . " - " . $value->brand_name . " - " . $value->unit_model_name; ?></option>
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
                                    <option
                                    <?php if ($value->id == $coal_actual->loader_id) {echo "selected";}?>
                                    value="<?php echo $value->id; ?>"><?php echo $value->nik . " - " . $value->first_name . " (" . $value->role_name . ")"; ?></option>
                                <?php }}?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Hauling Unit</label>
                            <select class="form-control" name="hauling_unit_id" id="hauling_unit_id">
                                <option value="">Pilih Hauling Unit</option>
                                <?php foreach ($hauling_unit as $key => $value) {?>
                                    <option
                                    <?php if ($value->id == $coal_actual->hauling_unit_id) {echo "selected";}?>
                                    value="<?php echo $value->id; ?>"><?php echo $value->kode . " - " . $value->brand_name . " - " . $value->unit_model_name; ?></option>
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
                                    <option
                                    <?php if ($value->id == $coal_actual->hauler_id) {echo "selected";}?>
                                    value="<?php echo $value->id; ?>"><?php echo $value->nik . " - " . $value->first_name . " (" . $value->role_name . ")"; ?></option>
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
                                    <option
                                    <?php if (in_array($value->id, $penimbang)) {echo "selected";}?>
                                    value="<?php echo $value->id; ?>"><?php echo $value->nik . " - " . $value->first_name . " (" . $value->role_name . ")"; ?></option>
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
                                    <option
                                    <?php if ($value->id == $coal_actual->material_id) {echo "selected";}?>
                                    value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                                <?php }}?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Distance</label>
                            <div class="input-group">
                                <input type="text" class="form-control number" name="distance" id="distance" placeholder="Distance" value="<?php echo floatval($coal_actual->distance); ?>">
                                <span class="input-group-addon" id="basic-addon2">m</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Gross</label>
                            <div class="input-group">
                                <input type="text" class="form-control number" name="gross" id="gross" placeholder="Gross" value="<?php echo floatval($coal_actual->gross); ?>">
                                <span class="input-group-addon" id="basic-addon2">ton</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Tare</label>
                            <div class="input-group">
                                <input type="text" class="form-control number" name="tare" id="tare" placeholder="Tare" value="<?php echo floatval($coal_actual->tare); ?>">
                                <span class="input-group-addon" id="basic-addon2">ton</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Netto</label>
                            <div class="input-group">
                                <input type="text" class="form-control number" name="netto" id="netto" placeholder="Netto" readonly value="<?php echo floatval($coal_actual->netto); ?>">
                                <span class="input-group-addon" id="basic-addon2">ton</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <div class="row">
                    <div class="col-sm-12 text-right">
                        <a href="<?php echo base_url() ?>coal_actual" class="btn btn-danger">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- Table -->
</section>
<script data-main="<?php echo base_url() ?>assets/js/main/main-coal-actual" src="<?php echo base_url() ?>assets/js/require.js"></script>