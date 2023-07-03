<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Order</h1>
        <p class="m-0">Master Data</p>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo base_url() ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="breadcrumb-item active">Order</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</section>

<section class="content">
  <div class="container-fluid">
  	<div class="card mb-3">
      <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
        <div class="panel panel-default">
          <div class="panel-heading active" role="tab" id="headingOne">
            <div class="card-header">
              <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                  Filter Data
                </a>
              </h4>
            </div>
          </div>
          <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
            <div class="card-body">
              <div class="panel-body"> 
                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label class="label-form">Tanggal</label>
                      <input type="text" name="tanggal" class="form-control" id="tanggal">
                    </div>
                  </div>
                  <div class="col-sm-6">
                      <label class="label-form">Status</label>
                      <select class="form-control" name="status" id="status">
                        <option value="">Pilih Status</option>
                        <option value="0">Review</option>
                        <option value="1">Proses Pengerjaan</option>
                        <option value="2">Ditolak</option>
                        <option value="3">Selesai</option>
                        <option value="4">Sudah Dicairkan</option>
                      </select>
                  </div>
                  <div class="col-sm-12 text-right mt-2">
                    <button class="btn btn-secondary" id="reset">Reset</button>
                    <button class="btn btn-primary" id="btn-filter">Filter</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="card mb-3">
		<div class="card-header">
			<div class="row">
				<div class="col-sm-12 text-right">
					<?php if ($is_can_create) {?>
						<a href="<?php echo base_url() ?>order/create" class="btn btn-primary"><i class="fa fa-plus"></i> Order</a>
					<?php }?>
				</div>
			</div>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-striped table-bordered" id="table" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>Nomor Faktur</th>
							<th>Tanggal</th>
							<th>Paket</th>
							<th>Nomor Whatsapp</th>
							<th>Joki</th>
							<th>Status</th>
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
 <script data-main="<?php echo base_url() ?>assets/js/main/main-order" src="<?php echo base_url() ?>assets/js/require.js"></script>