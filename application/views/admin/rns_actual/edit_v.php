<section class="content-header">
    <h1>
        RNS Actual
        <small>Ubah RNS Actual</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url() ?>rns_actual"></i>RNS Actual</a></li>
        <li class="active">Ubah RNS Actual</li>
    </ol>
</section>
<section class="content">
    <div class="box box-default color-palette-box">
        <div class="box-header with-border">
        </div>
        <form id="form" method="post">
            <input type="hidden" id="location_id_edit" name="location_id_edit" value="<?php echo $locations->id ?>">

            <div class="box-body">
                <div class="form-group row">
                    <label class="form-label col-sm-3" for="">Stop</label>
                    <div class="col-sm-4">
                        <input class="form-control" type="text" id="stop" name="stop" autocomplete="off" required placeholder="Stop">
                        <input type="hidden" name="id" id="id" value="<?php echo $id ?>">
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <div class="row">
                    <div class="col-sm-12 text-right">
                        <a href="<?php echo base_url() ?>rns_actual" class="btn btn-danger">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>


<script data-main="<?php echo base_url() ?>assets/js/main/main-rns-actual" src="<?php echo base_url() ?>assets/js/require.js"></script>


</section>
