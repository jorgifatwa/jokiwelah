<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Unit Baru</h1>
        <p class="m-0">Unit</p>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo base_url() ?>unit"></i>Unit</a></li>
          <li class="breadcrumb-item active">Unit Baru</li>
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
					<div class="col-sm-6">
						<div class="form-group row">
							<label class="form-label col-sm-4" for="">Operasional Sebagai</label>
							<div class="col-sm-8">
								<select name="operasi_sebagai" id="operasi_sebagai" class="form-control">
									<option value="">Pilih Operasi Sebagai</option>
									<option value="0">Loading Unit</option>
									<option value="1">Hauling Unit</option>
									<option value="2">Support Unit</option>
								</select>
							</div>
						</div>
						<div class="form-group row">
							<label class="form-label col-sm-4" for="">Kode Unit</label>
							<div class="col-sm-8">
								<input class="form-control" type="text" id="kode" name="kode" autocomplete="off" required placeholder="Kode">
							</div>
						</div>
						<div class="form-group row">
							<label class="form-label col-sm-4" for="">Brand Unit</label>
							<div class="col-sm-8">
								<select name="brand_id" id="brand_id" class="form-control">
									<option value="">Pilih Brand</option>
									<?php foreach ($brands as $key => $b) {?>
										<option value="<?php echo $b->id ?>"><?php echo $b->name ?></option>
									<?php }?>
								</select>
							</div>
						</div>
						<div class="form-group row">
							<label class="form-label col-sm-4" for="">Kategori Unit</label>
							<div class="col-sm-8">
								<select name="unit_category_id" id="unit_category_id" class="form-control">
									<option value="">Pilih Kategori</option>
								</select>
							</div>
						</div>
						<div class="form-group row">
							<label class="form-label col-sm-4" for="">Model Unit</label>
							<div class="col-sm-8">
								<select name="unit_model_id" id="unit_model_id" class="form-control">
									<option value="">Pilih Model</option>
								</select>
							</div>
						</div>
						<div class="form-group row">
							<label class="form-label col-sm-4">Kepemilikan</label>
							<div class="col-sm-8">
								<div class="row">
									<div class="col-md-6">
										<div class="form-check form-check-inline">
											<input class="form-check-input" type="radio" name="kepemilikan" id="milik_sendiri" value="1" checked>
											<label class="form-check-label" for="milik_sendiri">Milik Sendiri</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-check form-check-inline">
											<input class="form-check-input" type="radio" name="kepemilikan" id="pihak_lain" value="2">
											<label class="form-check-label" for="pihak_lain">Pihak Lain</label>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="form-group row">
							<label class="form-label col-sm-4" for="">Tahun Perakitan</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="tahun_perakitan" id="tahun_perakitan" placeholder="Pilih Tahun" value="<?php echo date("Y"); ?>">
							</div>
						</div>
						<div class="form-group row">
							<label class="form-label col-sm-4" for="">Serial Number</label>
							<div class="col-sm-8">
							 <input type="text" class="form-control" id="serial_number" name="serial_number" placeholder="Nomor Serial Number">
							</div>
						</div>
						<div class="form-group row">
							<label class="form-label col-sm-4" for="">Engine Serial Number</label>
							<div class="col-sm-8">
							 <input type="text" class="form-control" id="engine_serial_number" name="engine_serial_number" placeholder="Nomor Serial Mesin">
							</div>
						</div>

					</div>
				</div>
				<div class="card-footer">
					<div class="row">
						<div class="col-sm-12 text-right">
							<a href="<?php echo base_url() ?>unit" class="btn btn-danger">Batal
							</a>
							<button type="submit" class="btn btn-primary">Simpan</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</section>


<script data-main="<?php echo base_url() ?>assets/js/main/main-unit" src="<?php echo base_url() ?>assets/js/require.js"></script>
