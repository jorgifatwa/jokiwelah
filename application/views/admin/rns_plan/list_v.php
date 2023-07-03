<section class="content-header">
    <h1>
        RNS Plan
    </h1>
    <ol class="breadcrumb">
        <li><a href="#">RNS</a></li>
        <li class="active">Plan</li>
    </ol>
</section>

<section class="content">
    <div class="box">
        <div class="box-header">
            <div class="row">
                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-sm-6">
                            <select class="form-control form-control-sm" id="bulan">
                                <?php foreach ($bulan as $key => $bln) { ?>
                                    <option value="<?php echo $key ?>" <?php if($key == date('n')){ echo "selected"; } ?>><?php echo $bln ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <input type="text" class="form-control form-control-sm" name="tahun" id="tahun" placeholder="Pilih Tahun" value="<?php echo date("Y"); ?>">
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="button-right">
                      <?php if($is_can_create){ ?>
                        <a href="<?php echo base_url() ?>rns_plan/create" class="btn btn-success btn-sm <?php if(empty($location)){ echo "disabled"; } ?>"><i class="fa fa-plus"></i> Add New Plan</a>
                      <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-body">
            <div class="table-responsive scrolltable" style="height: calc(100vh - 275px) !important;">
                <h4>Data Plan RNS</h4>
                <table class="table table-data table-striped table-bordered">
                    <thead id="tanggal_head">
                    </thead>
                    <tbody id="nilai_body">
                    </tbody>
                    <thead id="total_head">                
                    </thead>
                    <tbody id="total_body">
                    </tbody>
                </table>

                <h4 style="margin-top:2%">Data Plan Rainfall</h4>
                <table class="table table-data table-striped table-bordered">
                    <thead id="tanggal_head_rainfall">
                    </thead>
                    <tbody id="nilai_body_rainfall">
                    </tbody>
                    <thead id="total_head_rainfall">                
                    </thead>
                    <tbody id="total_body_rainfall">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<script data-main="<?php echo base_url()?>assets/js/main/main-rns-plan" src="<?php echo base_url()?>assets/js/require.js"></script>
