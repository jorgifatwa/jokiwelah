<section class="content-header">
	<h1>
		RNS
		<small>Aktual</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url() ?>dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
		<li class="active">Aktual</li>
	</ol>
</section>

<section class="content">
	<div class="box mb-3">
		<div class="box-header">
			<div class="row">
				<div class="col-sm-12 text-right">
					<?php if ($is_can_create) {?>
						<a href="<?php echo base_url() ?>rns_actual/create" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Aktual</a>
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
							<th>Type</th>
							<th>Site</th>
							<th>PIT</th>
							<th>Seam</th>
							<th>Blok</th>
							<th>Shift</th>
							<th>Start</th>
							<th>Stop</th>
							<th>Rainfall<br>(mm)</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</section>
 <script data-main="<?php echo base_url() ?>assets/js/main/main-rns-actual" src="<?php echo base_url() ?>assets/js/require.js"></script>