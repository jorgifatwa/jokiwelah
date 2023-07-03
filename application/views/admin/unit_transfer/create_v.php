<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Transfer Unit Baru</h1>
        <p class="m-0">Transfer Unit</p>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo base_url() ?>unit_transfer"></i>Transfer Unit</a></li>
          <li class="breadcrumb-item active">Transfer Unit Baru</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</section>

<section class="content">
    <div class="container-fluid">
        <div class="card">
			<form id="form" method="post">
				<div class="card-body">
					<div class="form-group row">
						<label class="form-label col-sm-3" for="">Unit</label>
						<div class="col-sm-4">
							<select name="unit_id" id="unit_id" class="form-control">
								<option value="">Pilih Unit</option>
								<?php foreach ($units as $key => $u) {?>
									<option value="<?php echo $u->id ?>"><?php echo $u->kode . " - " . $u->brand_name . " - " . $u->unit_model_name ?></option>
								<?php }?>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="form-label col-sm-3" for="">Transfer Dari</label>
						<div class="col-sm-4">
							<select name="from_location" id="from_location" class="form-control" readonly="">
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="form-label col-sm-3" for="">Transfer Ke</label>
						<div class="col-sm-4">
							<select name="to_location" id="to_location" class="form-control">
								<option value="">Pilih Lokasi</option>
								<?php foreach ($to_locations as $key => $t) {?>
									<option value="<?php echo $t->id ?>"><?php echo $t->name ?></option>
								<?php }?>
							</select>
						</div>
					</div>
				</div>
				<div class="card-footer">
					<div class="row">
						<div class="col-sm-12 text-right">
							<a href="<?php echo base_url() ?>unit_transfer" class="btn btn-danger">Batal
							</a>
							<button type="submit" class="btn btn-primary">Simpan</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</section>


<script data-main="<?php echo base_url() ?>assets/js/main/main-unit-transfer" src="<?php echo base_url() ?>assets/js/require.js"></script>
