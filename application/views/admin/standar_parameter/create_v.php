<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Standar Parameter Baru</h1>
        <p class="m-0">Standar Parameter</p>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo base_url() ?>standar_parameter"></i>Standar Parameter</a></li>
          <li class="breadcrumb-item active">Standar Parameter Baru</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</section>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <form id="form-create" method="post" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="hidden" name="status-form" id="status-form" value="create">
                                <label class="form-label" for="">Tahun</label>
                                <input type="text" class="form-control tahun" name="tahun" id="tahun" placeholder="Pilih Tahun" value="<?php echo date("Y"); ?>">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="hidden" name="status-form" id="status-form" value="create">
                                <label class="form-label" for="">Bulan</label>
                                <select class="form-control bulan" id="bulan" name="bulan">
                                    <?php foreach ($bulan as $key => $bln) { ?>
                                        <option value="<?php echo $key ?>"
                                        <?php if ($key == date('n')) {echo "selected";
                                            $template = $bln;}?> > <?php echo $bln ?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div id="form-parameter" class="handsontable" name="handsontable">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-12 text-right">
                            <a href="<?php echo base_url() ?>standar_parameter" class="btn btn-danger">Batal</a>
                            <button type="submit" class="btn btn-primary" id="simpan">Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>


<script data-main="<?php echo base_url() ?>assets/js/main/main-standar-parameter" src="<?php echo base_url() ?>assets/js/require.js"></script>
