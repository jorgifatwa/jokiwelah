<section class="content-header">
    <h1>
        <?php echo ucwords(str_replace("_"," ",$this->uri->segment(1)))?>
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><?php echo ucwords(str_replace("_"," ",$this->uri->segment(1)))?></li>
        <li class="active">Tambah</li>
    </ol>
</section>

<section class="content">
    <div class="box box-default color-palette-box">
        <div class="box-header with-border">
            <h3 class="box-title"></h3>
        </div>
        <form id="form" method="post">
            <input type="hidden" name="id" id="id" value="<?php echo $dwp->id; ?>">
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <div class="form-group">
                            <label class="form-label" for="">Lokasi</label>
                            <input type="hidden" name="location_id" id="location_id" value="<?php echo $location->id ?>">
                            <input type="text" readonly="" name="location_name" id="location_name" class="form-control" value="<?php echo $location->name ?>">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Shift</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input shift" type="radio" name="shift" id="ds" value="DS" <?php if($dwp->shift == "DS"){ echo "checked"; } ?>>
                                        <label class="form-check-label" for="inlineRadio1">Day Shift</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input shift" type="radio" name="shift" id="ns" value="NS" <?php if($dwp->shift == "NS"){ echo "checked"; } ?>>
                                        <label class="form-check-label" for="inlineRadio1">Night Shift</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="">Operator</label>
                            <select name="operator_id[]" id="operator_id" class="form-control" multiple>
                                <option value="">Pilih Operator</option>
                                <?php foreach ($operators as $key => $value) { ?>
                                    <option 
                                    <?php if(in_array($value->user_id, $operator)){ echo "selected"; } ?>
                                    value="<?php echo $value->user_id ?>"><?php echo $value->username ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-8">
                        <div class="row" style="margin-bottom:2%;">
                            <div class="col-sm-6">
                                <h4>Equipment Event</h4>
                            </div>
                            <div class="col-sm-6 text-right">
                                <button type="button" class="btn btn-primary btn-sm" onClick="App.tambahEvent();"><i class="fa fa-plus"></i> Event</button>
                            </div>
                            
                            <div class="col-sm-12">
                                <table class="table">
                                    <thead>
                                        <th>Jam Mulai</th>
                                        <th>Jam Berakhir</th>
                                        <th>Unit</th>
                                        <th>Event</th>
                                        <th width="50px">Aksi</th>
                                    </thead>
                                    <tbody id="container-event">
                                        <?php if(!empty($equipment_event)){
                                            foreach ($equipment_event as $key => $value) {
                                        ?>
                                        <tr>
                                            <td>
                                                <input type="text" name="start[]" id="start_<?php echo $key; ?>" placeholder="Jam Mulai" class="form-control start" value="<?php if(!empty($value->jam_kerja_start)){ echo date('d-m-Y H:i', strtotime($value->jam_kerja_start)); } ?>">
                                            </td>

                                            <td>
                                                <input type="text" name="end[]" id="end_<?php echo $key; ?>" placeholder="Jam Berakhir" class="form-control end" value="<?php if(!empty($value->jam_kerja_end)){ echo date('d-m-Y H:i', strtotime($value->jam_kerja_end)); } ?>">
                                            </td>

                                            <td>
                                                <select name="unit[]" id="unit_<?php echo $key; ?>" class="form-control unit">
                                                    <option value="">Pilih Unit</option>
                                                    <?php if(!empty($units)){
                                                        foreach ($units as $k => $v) {
                                                    ?>
                                                    <option 
                                                    <?php if($value->unit_id == $v->id){ echo "selected"; } ?>
                                                    value="<?php echo $v->id; ?>"><?php echo $v->kode; ?></option>
                                                    <?php } } ?>
                                                </select>
                                            </td>

                                            <td>
                                                <select name="event[]" id="event_<?php echo $key; ?>" class="form-control event">
                                                    <option value="">Pilih Equipment Event</option>
                                                    <?php if(!empty($equipments)){
                                                        foreach ($equipments as $k => $v) {
                                                    ?>
                                                    <option 
                                                    <?php if($value->equipment_id == $v->id){ echo "selected"; } ?>
                                                    value="<?php echo $v->id; ?>"><?php echo $v->name; ?></option>
                                                    <?php } } ?>
                                                </select>
                                            </td>
                                            <td width="50px" align="center"><button type="button" class="btn btn-danger btn-sm" onClick="App.hapusRow(this);"><i class="fas fa-times"></i></button></td>
                                        </tr>
                                        <?php } } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="form-label" for="">Catatan</label>
                            <textarea class="form-control" id="catatan" name="catatan" autocomplete="off" placeholder="Catatan" rows="5"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <div class="row">
                    <div class="col-sm-12 text-right">
                        <a href="<?php echo base_url() ?>dewatering_pump" class="btn btn-secondary text-black">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

<script>
    var equipment_event = <?php echo json_encode($equipments); ?>;
    var units = <?php echo json_encode($units); ?>;
</script>
              
<script data-main="<?php echo base_url()?>assets/js/main/main-dewatering-pump" src="<?php echo base_url()?>assets/js/require.js"></script>
