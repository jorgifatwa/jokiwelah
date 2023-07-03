<section class="content-header">
    <h1>
        RNS
        <small>Situasi Air Plan</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url() ?>dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Situasi Air Plan</li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header">
            <div class="row">
                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-sm-4">
                            <select class="form-control form-control-sm" id="bulan">
                                <?php foreach ($bulan as $key => $bln) {?>
                                    <option value="<?php echo $key ?>" <?php if ($key == date('n')) {echo "selected";}?>><?php echo $bln ?></option>
                                <?php }?>
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <input type="text" class="form-control form-control-sm" name="tahun" id="tahun" placeholder="Pilih Tahun" value="<?php echo date("Y"); ?>">
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="button-right">
                        <!-- <a href="<?php echo base_url() ?>situasi_air_plan/exportExcel" class="btn btn-info btn-sm btn-export">Export</a>
                        <a href="<?php echo base_url() ?>situasi_air_plan/import" class="btn btn-info btn-sm">Import</a>
                        <?php if ($is_can_create) {?> -->
                        <a href="<?php echo base_url() ?>situasi_air_plan/create" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Situasi Air Plan</a>
                        <?php }?>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-body">
            <div class="table-responsive scrolltable" style="height: calc(100vh - 275px) !important;">
                <table class="table table-data table-striped table-bordered">
                    <thead id="tanggal_head">
                    </thead>
                    <tbody id="nilai_body">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<script data-main="<?php echo base_url() ?>assets/js/main/main-situasi-air-plan" src="<?php echo base_url() ?>assets/js/require.js"></script>
