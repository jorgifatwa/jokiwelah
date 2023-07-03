<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Plan Activity</h1>
        <p class="m-0">Tambah Data</p>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo base_url() ?>pit"></i>Plan Activity</a></li>
          <li class="breadcrumb-item active">Tambah Data</li>
        </ol>
      </div>
    </div>
  </div>
</section>

<section class="content">
  <div class="container-fluid">
    <div class="card">
      <form id="form" method="post">
        <div class="card-body">
          <div class="row">
            <div class="col-sm-4">
              <div class="form-group">
                <label class="form-label" for="">Site</label>
                <select name="location_id" id="location_id" class="form-control">
                  <option value="">Pilih Site</option>
                  <?php foreach ($locations as $location) {?>
                      <option value="<?php echo $location->id ?>"><?php echo $location->name ?></option>
                  <?php }?>
                </select>
              </div>
            </div>

            <div class="col-sm-4">
              <div class="form-group">
                <label class="form-label" for="">Shift</label>
                <select name="shift" id="shift" class="form-control">
                  <option value="">Pilih Shift</option>
                  <option value="DS">DS</option>
                  <option value="NS">NS</option>
                </select>
              </div>
            </div>

            <div class="col-sm-4">
              <div class="form-group">
                <label class="form-label" for="">Tanggal</label>
                <input type="text" name="tanggal" id="tanggal" placeholder="Pilih Tanggal" class="form-control" autocomplete="off">
              </div>
            </div>
            
            <div class="col-sm-12">
              <hr>
            </div>
          </div>

          <!-- fleet ob  -->
          <div class="row">
            <div class="col-sm-6">
              <h5>Fleet OB</h5>
            </div>
            <div class="col-sm-6 text-right">
              <button type="button" class="btn btn-primary" onClick="App.tambahFleetOb();"><i class="fa fa-plus"></i> Fleet OB</button>
            </div>
          </div> 

          <div class="col-sm-12 mt-3">
            <table class="table">
                <thead>
                    <th>PIT</th>
                    <th>Seam</th>
                    <th>Blok</th>
                    <th>Loading Unit</th>
                    <th>Hauling Unit</th>
                    <th width="50px">Aksi</th>
                </thead>
                <tbody id="container-fleet-ob">
                </tbody>
            </table>
          </div>
          <!-- end fleet ob -->
        </div>
        <div class="card-footer">
          <div class="row">
            <div class="col-sm-12 text-right">
              <a href="<?php echo base_url() ?>plan_activity" class="btn btn-danger">Batal</a>
              <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</section>


<script data-main="<?php echo base_url() ?>assets/js/main/main-plan-activity" src="<?php echo base_url() ?>assets/js/require.js"></script>
