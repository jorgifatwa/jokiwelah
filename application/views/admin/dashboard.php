<section class="content-header">
  <div class="container-fluid">
	<div class="row mb-2">
	  <div class="col-sm-6">
		<h1 class="m-0">Dashboard</h1>
		<p class="m-0">Daily Report Jokiwelah</p>
	  </div><!-- /.col -->
	  <div class="col-sm-6">
		<ol class="breadcrumb float-sm-right">
		  <li class="breadcrumb-item"><a href="<?php echo base_url() ?>dashboard"></i>Dashboard</a></li>
		  <!-- <li class="breadcrumb-item active">Unit Baru</li> -->
		</ol>
	  </div><!-- /.col -->
	</div><!-- /.row -->
  </div><!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content for-dashboard">
	<div class="row">
		<div class="col-lg-6 col-6">
			<div class="small-box bg-success">
			  <div class="inner">
				<h3><?php echo "Rp.".number_format($pendapatan_kotor); ?></h3>
				<p>Pendapatan Kotor Saat Ini</p>
			  </div>
			  <div class="icon">
				<i class="fa fa-coins "></i>
			  </div>
			  <p class="small-box-footer">
				<br>
			  </p>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<div class="row">
						<h4>Grafik Pendapatan Perbulan</h4>
					</div>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-md-12">
							<div class="graph-section" id="container-grafik-pendapatan">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<script data-main="<?php echo base_url() ?>assets/js/main/main-dashboard" src="<?php echo base_url() ?>assets/js/require.js"></script>