<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Plan Activity</h1>
        <p class="m-0">Kelola Aktivitas</p>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo base_url() ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="breadcrumb-item active">Plan Activity</li>
        </ol>
      </div>
    </div>
  </div>
</section>

<section class="content">
  <div class="container-fluid">
    <div class="card mb-3">
      <div class="card-header">
        <div class="row">
          <div class="col-sm-12 text-right">
            <?php if ($is_can_create) {?>
                <a href="<?php echo base_url() ?>plan_activity/create" class="btn btn-primary"><i class="fa fa-plus"></i> Plan Activity</a>
            <?php }?>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered" id="table" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Tanggal</th>
                <th>Site</th>
                <th>Shift</th>
                <th>Aksi</th>
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
<script data-main="<?php echo base_url() ?>assets/js/main/main-plan-activity" src="<?php echo base_url() ?>assets/js/require.js"></script>