<section class="content-header">
    <h1>
        RNS
    </h1>
    <ol class="breadcrumb">
        <li><a href="#">RNS</a></li>
        <li><a href="#">Plan</a></li>
        <li class="active">Add New Plan</li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="row">
            <div class="col-md-12 border-responsive">
                <div class="box-body">
                    <form id="form-create" name="form">
                        <div class="row">
                            <div class="col-md-3">
                                <input type="hidden" name="total_data" id="total_data" value="<?php count($location)?>">
                                <label class="form-label">Lokasi</label>
                                <select class="form-control location_id" name="location_id" id="location_id">
                                    <option value="">Pilih Lokasi</option>
                                    <?php if (!empty($location)) {
                                        foreach ($location as $key => $value) {
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

                            <div class="col-md-2">
                                <label class="form-label">RNS</label>
                                <input type="text" class="form-control rns_input number" name="rns_input" id="rns_input" placeholder="Masukan RNS">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Rainfall</label>
                                <div class="input-group">
                                    <input type="text" class="form-control rainfall_input number" name="rainfall_input" id="rainfall_input" placeholder="Masukan Rainfall">
                                    <span class="input-group-addon" id="basic-addon2">mm</span>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-top:1%">
                            <div class="col-md-12 text-right">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-plus mr-2"></i> Plan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-md-12">
                <div class="box-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
        <div class="box-footer text-right">
            <a href="<?php echo base_url() ?>rns_plan"><button class="btn btn-light text-black">Batal</button>  </a>
        </div>
    </div>
</section>

<?php if ($is_can_edit) {?>
    <div class="modal" data-backdrop="false" id="modalEditPlan">
        <div class="modal-dialog">
            <form id="form-edit" method="post">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Data RNS Plan</h4>
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
                                <div class="form-group">
                                    <label for="">RNS</label>
                                    <input class="form-control number" type="text" placeholder="Masukan RNS" name="rns_edit" id="rns_edit">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">Rainfall</label>
                                    <div class="input-group">
                                        <input class="form-control number" type="text" placeholder="Masukan Rainfall" name="rainfall_edit" id="rainfall_edit">
                                        <span class="input-group-addon" id="basic-addon2">mm</span>
                                    </div>
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
<script data-main="<?php echo base_url() ?>assets/js/main/main-rns-plan" src="<?php echo base_url() ?>assets/js/require.js"></script>