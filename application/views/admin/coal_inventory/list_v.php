<section class="content-header">
    <h1>
        Coal Inventory
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url() ?>dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li>Coal Production</li>
        <li class="active">Coal Inventory</li>
    </ol>
</section>

<section class="content">
    <div class="box mb-3">
        <div class="box-header">
            <div class="row">
                <div class="col-sm-12 text-right">
                    <?php if ($is_can_create) {?>
                        <a href="<?php echo base_url() ?>coal_inventory/create" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Coal Inventory</a>
                    <?php }?>
                </div>
            </div>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Lokasi</th>
                            <th>PIT</th>
                            <th>Tanggal</th>
                            <th>Tonase</th>
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
 <script data-main="<?php echo base_url() ?>assets/js/main/main-coal-inventory" src="<?php echo base_url() ?>assets/js/require.js"></script>