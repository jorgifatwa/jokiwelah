<section class="content-header">
    <h1>
    Situasi Air Plan
        <small>Situasi Air Plan Baru</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url() ?>situasi_air_plan"></i>Situasi Air Plan</a></li>
        <li class="active">Situasi Air Plan Baru</li>
    </ol>
</section>

<section class="content">
    <div class="box box-default color-palette-box">
        <div class="box-header with-border">
        </div>
        <form id="form-create" name="form">
            <div class="box-body">
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
                        <label class="form-label">Ketinggian Air</label>
                        <div class="input-group">
                            <input type="text" class="form-control nilai_input number" name="nilai_input" id="nilai_input" placeholder="Masukan Nilai" autocomplete="off">
                            <span class="input-group-addon" id="basic-addon2">mdpl</span>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top:1%">
                    <div class="col-sm-12 text-right">
                        <a href="<?php echo base_url() ?>situasi_air_plan" class="btn btn-danger">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
        </form>
        <div class="box-footer">
            <div class="col-md-12">
                    <div id="calendar"></div>
            </div>
        </div>
    </div>
</section>

<?php if ($is_can_edit) {?>
    <div class="modal" data-backdrop="false" id="modalEditPlan">
        <div class="modal-dialog">
            <form id="form-edit" method="post">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Data Elevasi</h4>
                        <button type="button" class="close" id="closeButton" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">Tanggal</label>
                                    <input readonly class="form-control" type="text" placeholder="Tanggal" name="tanggal_edit" id="tanggal_edit">
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <label class="form-label">Ketinggian Air</label>
                                <div class="input-group">
                                    <input type="text" class="form-control number" name="nilai_input_edit" id="nilai_input_edit" placeholder="Masukan Nilai" autocomplete="off">
                                    <span class="input-group-addon" id="basic-addon2">mdpl</span>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="location_id_edit" name="location_id_edit">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" id="cancelButton" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php }?>
<script data-main="<?php echo base_url() ?>assets/js/main/main-situasi-air-plan" src="<?php echo base_url() ?>assets/js/require.js"></script>