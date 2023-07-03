<section class="content-header">
    <h1>
        Situasi Air
        <small>Ubah Baru</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url() ?>seam"></i>Seam</a></li>
        <li>Situasi Air</li>
        <li class="active">Ubah Baru</li>
    </ol>
</section>
<section class="content">
    <form id="form-edit" method="post">
        <input type="hidden" name="id" id="id" value="<?php echo $situasi_air->id; ?>">
        <div class="box box-default color-palette-box">
            <div class="box-header with-border">
            </div>
            <div class="box-body">
                <div class="form-group row">
                    <label class="form-label col-sm-3" for="">Waktu</label>
                    <div class="col-sm-4">
                        <input required class="form-control" type="text" id="waktu" name="waktu" autocomplete="off" placeholder="Waktu" value="<?php echo date("d-m-Y H:i", strtotime($situasi_air->waktu)); ?>">
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-sm-6">
                                <h4>Est.Volume</h4>
                            </div>
                            <div class="col-sm-6 text-right">
                                <button type="button" class="btn btn-primary btn-sm" onClick="App.tambahVolume();"><i class="fa fa-plus"></i> Est.Volume</button>
                            </div>

                            <div class="col-sm-12">
                                <table class="table" id="container-volume">
                                    <thead>
                                        <th>Seam</th>
                                        <th>Dari Blok</th>
                                        <th>Ke Blok</th>
                                        <th>Ketinggian Air (mdpl)</th>
                                        <th>Estimasi Total Air</th>
                                        <th>Estimasi Total Lumpur</th>
                                        <th width="50px">Aksi</th>
                                    </thead>
                                    <?php if (!empty($volume)) {
                                        foreach ($volume as $key => $value) {
                                    ?>
                                        <tr>
                                            <td>
                                                <select name="seam_id[]" id="seam_id_<?php echo $key; ?>" class="form-control seam_id" onChange="App.onChangeSeam(this)">
                                                    <option value="">Pilih Seam</option>
                                                    <?php if (!empty($seam)) {
			                                            foreach ($seam as $k => $v) {
                                                    ?>
                                                        <option <?php if ($v->id == $value->seam_id) {echo "selected";}?> value="<?php echo $v->id; ?>"><?php echo $v->name; ?></option>
                                                    <?php }}?>
                                                </select>
                                            </td>

                                            <td>
                                                <input type="hidden" class="blok_start_selected" value="<?php echo $value->blok_start; ?>">
                                                <select name="blok_start[]" id="blok_start_<?php echo $key; ?>" class="form-control blok_start">
                                                    <option value="">Dari Blok</option>
                                                </select>
                                            </td>
                                            
                                            <td>
                                                <input type="hidden" class="blok_end_selected" value="<?php echo $value->blok_end; ?>">
                                                <select name="blok_end[]" id="blok_end_<?php echo $key; ?>" class="form-control blok_end">
                                                    <option value="">Ke Blok</option>
                                                </select>
                                            </td>

                                            <td>
                                                <input class="form-control number" type="text" id="ketinggian_air_<?php echo $key; ?>" name="ketinggian_air[]" autocomplete="off" placeholder="Ketinggian Air (mdpl)" value="<?php echo floatval($value->ketinggian_air); ?>">
                                            </td>

                                            <td>
                                                <input class="form-control number" type="text" id="estimasi_total_air_<?php echo $key; ?>" name="estimasi_total_air[]" autocomplete="off" placeholder="Estimasi Total Air" value="<?php echo floatval($value->estimasi_total_air); ?>">
                                            </td>

                                            <td>
                                                <input class="form-control number" type="text" id="estimasi_total_lumpur_<?php echo $key; ?>" name="estimasi_total_lumpur[]" autocomplete="off" placeholder="Estimasi Total Lumpur" value="<?php echo floatval($value->estimasi_total_lumpur); ?>">
                                            </td>

                                            <td width="50px" align="center"><button type="button" class="btn btn-danger btn-sm" onClick="App.hapusRow(this);"><i class="fas fa-times"></i></button></td>
                                        </tr>
                                    <?php }}?>
                                </table>
                            </div>
                        </div>
                        <hr>
                    </div>
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-sm-6">
                                <h4>Status Pompa</h4>
                            </div>

                            <div class="col-sm-6 text-right">
                                <button type="button" class="btn btn-primary btn-sm" onClick="App.tambahPompa();"><i class="fa fa-plus"></i> Status Pompa</button>
                            </div>

                            <div class="col-sm-12">
                                <table class="table" id="container-pompa">
                                    <thead>
                                        <th width="30%">Unit Support</th>
                                        <th>Status Unit(Catatan)</th>
                                        <th width="50px">Aksi</th>
                                    </thead>
                                    <?php if (!empty($pompa)) {
	foreach ($pompa as $key => $value) {
		?>
                                        <tr>
                                            <td>
                                                <select name="unit_id[]" id="unit_id_<?php echo $key; ?>" class="form-control unit_id">
                                                    <option value="">Pilih Unit</option>
                                                    <?php if (!empty($unit)) {
			foreach ($unit as $k => $v) {
				?>
                                                        <option <?php if ($v->id == $value->unit_id) {echo "selected";}?> value="<?php echo $v->id; ?>"><?php echo $v->kode; ?></option>
                                                    <?php }}?>
                                                </select>
                                            </td>

                                            <td>
                                                <input class="form-control" type="text" id="status_unit_<?php echo $key; ?>" name="status_unit[]" autocomplete="off" placeholder="Status Unit" value="<?php echo $value->status_unit; ?>">
                                            </td>

                                            <td width="50px" align="center"><button type="button" class="btn btn-danger btn-sm" onClick="App.hapusRow(this);"><i class="fas fa-times"></i></button></td>
                                        </tr>
                                    <?php }}?>
                                </table>
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <div class="row">
                    <div class="col-sm-12 text-right">
                        <a href="<?php echo base_url() ?>situasi_air" class="btn btn-danger">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>

<script>
    var seam = <?php echo json_encode($seam); ?>;
    var unit = <?php echo json_encode($unit); ?>;
</script>

<script data-main="<?php echo base_url() ?>assets/js/main/main-situasi-air" src="<?php echo base_url() ?>assets/js/require.js"></script>
