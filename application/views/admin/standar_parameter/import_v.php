<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Import Standar Parameter</h1>
        <p class="m-0">Standar Parameter</p>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo base_url() ?>standar_parameter"></i>Standar Parameter</a></li>
          <li class="breadcrumb-item active">Import Standar Parameter</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</section>

<section class="content">
  <div class="container-fluid">
    <div class="card">
      <form id="form" method="post" enctype="multipart/form-data">
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group row">
                <label class="form-label col-sm-3" for="">Bulan</label>
                <div class="col-sm-4">
                  <select class="form-control" id="bulan" name="bulan">
                    <?php foreach ($bulan as $key => $bln) {
	?>
                          <option value="<?php echo $key ?>" <?php if ($key == date('n')) {
		echo "selected";
		$template = $bln;}?>><?php echo $bln ?></option>
                      <?php }?>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="form-label col-sm-3" for="">Template</label>
                  <div class="col-sm-4">
                    <button type="button" class="btn btn-success btn-sm" id="btn-export">Download Template Excel</a>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="form-label col-sm-3" for="">Upload File</label>
                  <div class="col-sm-4">
                    <input type="file" class="form-control" name="file" id="file">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer">
            <div class="row">
              <div class="col-sm-12 text-right">
                <a href="<?php echo base_url() ?>standar_parameter" class="btn btn-danger">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
              </div>
            </div>
        </div>
      </form>
    </div>
  </div>
</section>


<script data-main="<?php echo base_url() ?>assets/js/main/main-standar-parameter" src="<?php echo base_url() ?>assets/js/require.js"></script>
