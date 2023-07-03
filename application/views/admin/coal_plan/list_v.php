<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Coal Plan</h1>
        <p class="m-0">Coal Production Plan</p>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo base_url() ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="breadcrumb-item active">Coal Plan</li>
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
					<div class="col-sm-8">
						<div class="row">
							<div class="col-sm-4">
								<select class="form-control" name="location_id_filter" id="location_id_filter">
									<option value="">Pilih Lokasi</option>
									<?php if (!empty($locations)) {
	foreach ($locations as $key => $value) {
		?>
									<option value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
									<?php }}?>
								</select>
							</div>
							<div class="col-sm-4">
								<select class="form-control form-control" id="bulan">
									<?php foreach ($bulan as $key => $bln) {?>
										<option value="<?php echo $key ?>" <?php if ($key == date('n')) {echo "selected";}?>><?php echo $bln ?></option>
									<?php }?>
								</select>
							</div>
							<div class="col-sm-4">
								<input type="text" class="form-control form-control" name="tahun" id="tahun" placeholder="Pilih Tahun" value="<?php echo date("Y"); ?>">
							</div>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="text-right">
							<!-- <a href="<?php echo base_url() ?>coal_plan/exportExcel" class="btn btn-info btn-sm btn-export">Export</a>
							<a href="<?php echo base_url() ?>coal_plan/import" class="btn btn-info btn-sm">Import</a> -->
							<?php if ($is_can_create) {?>
							<a href="<?php echo base_url() ?>coal_plan/create" class="btn btn-primary"><i class="fa fa-plus"></i> Coal Plan</a>
							<?php }?>
						</div>
					</div>
				</div>
			</div>
			<div class="card-body">
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
	</div>
</section>

<script data-main="<?php echo base_url() ?>assets/js/main/main-coal-plan" src="<?php echo base_url() ?>assets/js/require.js"></script>
