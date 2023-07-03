<section class="content-header">
    <h1>
        Fuel Consumtion
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url() ?>dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li>Fuel</li>
        <li class="active">Fuel Consumtion</li>
    </ol>
</section>

<section class="content">
    <div class="box mb-3">
        <div class="box-header">
            <div class="row">
                <div class="col-sm-12 text-right">
                    <?php if ($is_can_create) {?>
                        <a href="<?php echo base_url() ?>fuel_consumtion/create" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Fuel Consumtion</a>
                    <?php }?>
                </div>
            </div>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Lokasi</th>
                            <th>PIT</th>
                            <th>HM</th>
                            <th>PIC</th>
                            <th>Unit</th>
                            <th>Shift</th>
                            <th>Lokasi Pengisian</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
 <script data-main="<?php echo base_url() ?>assets/js/main/main-fuel-consumtion" src="<?php echo base_url() ?>assets/js/require.js"></script>