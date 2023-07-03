<section class="content-header">
    <h1>
        Coal Inventory
        <small>Tambah Baru</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url() ?>location"></i>Coal Inventory</a></li>
        <li class="active">Tambah Baru</li>
    </ol>
</section>
<section class="content">
    <div class="box box-default color-palette-box">
        <div class="box-header with-border">
        </div>
        <form id="form" method="post">
            <div class="box-body">
                <div class="form-group row">
                    <label class="form-label col-sm-3" for="">Site</label>
                    <div class="col-sm-4">
                        <select name="location_id" id="location_id" class="form-control">
                            <option value="">Pilih Site</option>
                            <?php foreach ($locations as $location) { ?>
                                <option value="<?php echo $location->id ?>"><?php echo $location->name ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="form-label col-sm-3" for="">PIT</label>
                    <div class="col-sm-4">
                        <select name="pit_id" id="pit_id" class="form-control">
                            <option value="">Pilih PIT</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="form-label col-sm-3" for="">Tanggal</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="tanggal" name="tanggal" autocomplete="off" placeholder="Tanggal">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="form-label col-sm-3" for="">Tonase</label>
                    <div class="col-sm-4">
                        <div class="input-group">
                            <input type="text" class="form-control number" name="tonase" id="tonase" placeholder="Tonase">
                            <span class="input-group-addon" id="basic-addon2">Mt</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <div class="row">
                    <div class="col-sm-12 text-right">
                        <a href="<?php echo base_url() ?>coal_inventory" class="btn btn-danger">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>


<script data-main="<?php echo base_url() ?>assets/js/main/main-coal-inventory" src="<?php echo base_url() ?>assets/js/require.js"></script>
