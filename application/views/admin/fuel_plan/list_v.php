<section class="content-header">
    <h1>
        Fuel Plan
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url() ?>dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li>Fuel</li>
        <li class="active">Fuel Plan</li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header">
            <div class="row">
                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-sm-4">
                            <select class="form-control" name="location_id_filter" id="location_id_filter">
                                <option value="">Pilih Lokasi</option>
                                <?php if(!empty($locations)){
                                    foreach ($locations as $key => $value) { 
                                ?>
                                <option value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                                <?php } } ?>
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <select class="form-control form-control-sm" id="bulan">
                                <?php foreach ($bulan as $key => $bln) { ?>
                                    <option value="<?php echo $key ?>" <?php if($key == date('n')){ echo "selected"; } ?>><?php echo $bln ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <input type="text" class="form-control form-control-sm" name="tahun" id="tahun" placeholder="Pilih Tahun" value="<?php echo date("Y"); ?>">
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="button-right">
                        <a href="<?php echo base_url() ?>fuel_plan/exportExcel" class="btn btn-info btn-sm btn-export">Export</a>
                        <a href="<?php echo base_url() ?>fuel_plan/import" class="btn btn-info btn-sm">Import</a>
                        <?php if($is_can_create){ ?>
                        <a href="<?php echo base_url() ?>fuel_plan/create" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Add New Plan</a>
                        <?php } ?>
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
                    <thead id="total_head">                
                    </thead>
                </table>
            </div>
        </div>
    </div>
</section>

<script data-main="<?php echo base_url()?>assets/js/main/main-fuel-plan" src="<?php echo base_url()?>assets/js/require.js"></script>
