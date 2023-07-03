<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">OB Aktual</h1>
        <p class="m-0">OB Production Aktual</p>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo base_url() ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="breadcrumb-item active">OB Aktual</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</section>

<section class="content">
    <div class="container-fluid">
        <div class="card mb-3">
	        <div class="card-header">
	            <div class="row">
	                <div class="col-md-6">
	                    <div class="form-inline">
	                        <button class="btn btn-primary mr-2" id="reset">Lihat Semua</button>
	                        <input type="text" class="form-control tanggal" name="filter-tanggal" id="filter-tanggal" placeholder="Tanggal" autocomplete="off" value="<?php echo date('d-m-Y') ?>">
	                    </div>
	                </div>
	                <div class="col-md-6 text-right">
	                    <?php if ($is_can_create) {?>
	                        <!-- <button type="button" class="btn btn-primary btn-sm" id="btn-production"><i class="fa fa-plus"></i> Production JS</button> -->
	                        <a href="ob_actual/create" class="btn btn-primary"><i class="fa fa-plus"></i> OB Aktual</a>
	                    <?php }?>
	                </div>
	            </div>
	        </div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-data table-striped table-bordered" id="table" width="100%" cellspacing="0">
						<thead>
							<tr>
								<th>Date</th>
								<th>Jam</th>
								<th>Shift</th>
								<th>Loading Unit</th>
								<th>Hauling Unit</th>
								<th>Loader Name</th>
								<th>Supervisor</th>
								<th>Total Ritase</th>
								<th>Capacity</th>
								<th>Total Production</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>
<script data-main="<?php echo base_url() ?>assets/js/main/main-ob-actual" src="<?php echo base_url() ?>assets/js/require.js"></script>
