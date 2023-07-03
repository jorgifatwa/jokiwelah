<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Import OB Plan</h1>
        <p class="m-0">OB Plan</p>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo base_url() ?>ob_plan"></i>OB Plan</a></li>
          <li class="breadcrumb-item active">Import OB Plan</li>
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
            <label class="form-label col-sm-3" for="">Template</label>
            <div class="col-sm-4">
               <a download href="<?php echo base_url('uploads/template.xlsx') ?>" class="btn btn-info btn-sm">Download Template</a>
            </div>
          </div>
          <div class="form-group row">
            <label class="form-label col-sm-3" for="">Import File</label>
            <div class="col-sm-4">
              <input type="file" class="form-control" name="file" id="file">
            </div>
          </div>
        </div>
        <div class="card-footer text-right">
          <a href="<?php echo base_url() ?>plan"><button class="btn btn-danger">Batal</button></a>
        </div>
      </form>
    </div>
  </div>
</section>
<script data-main="<?php echo base_url() ?>assets/js/main/main-ob-plan" src="<?php echo base_url() ?>assets/js/require.js"></script>