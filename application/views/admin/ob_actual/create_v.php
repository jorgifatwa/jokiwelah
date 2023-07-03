<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">OB Aktual Baru</h1>
        <p class="m-0">OB Aktual</p>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo base_url() ?>ob_aktual"></i>OB Aktual</a></li>
          <li class="breadcrumb-item active">OB Aktual Baru</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</section>

<section class="content">
    <div class="container-fluid">
        <div class="card">
        <form id="form-actual-create" method="post">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Tanggal</label>
                            <input type="hidden" id="id">
                            <input type="text" class="form-control tanggal" name="tanggal" id="tanggal" placeholder="Tanggal" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Shift</label>
                            <select name="shift" id="shift" class="form-control">
                                <option value="">Pilih Shift</option>
                                <option value="DS">Day Shift</option>
                                <option value="NS">Night Shift</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Supervisor</label>
                            <select name="supervisor_id" id="supervisor_id">
                                <option value="">Pilih Supervisor</option>
                                    <?php
if (!empty($user_location)) {
	foreach ($user_location as $key => $value) {
		?>
                                        <option value="<?php echo $value->id; ?>"><?php echo $value->nik . " - " . $value->first_name . " (" . $value->role_name . ")"; ?></option>
                                    <?php }}?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Site</label>
                            <input type="text" class="form-control" name="location" id="location" placeholder="Site" value="<?php echo $location->name; ?>" readonly>
                            <input type="hidden" name="location_id" id="location_id" value="<?php echo $location->id ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="">PIT</label>
                            <select name="pit_id" id="pit_id" class="form-control">
                                <option value="">Pilih PIT</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Seam</label>
                            <select class="form-control" name="seam_id" id="seam_id">
                                <option value="">Pilih Seam</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Blok</label>
                            <select class="form-control" name="blok_id" id="blok_id">
                                <option value="">Pilih Blok</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-primary card-tabs d-none" id="tabs-container">
                <div class="card-header py-2 pt-1">
                    <input type="hidden" name="jam" id="jam">
                    <ul class="nav nav-tabs d-none" id="day" role="tablist">
                        <li class="nav-item tab-jam" data-id="06:00:00">
                            <a class="nav-link active"  href="#">06-07</a>
                        </li>
                        <li class="nav-item tab-jam" data-id="07:00:00">
                            <a class="nav-link"  href="#">07-08</a>
                        </li>
                        <li class="nav-item tab-jam" data-id="08:00:00">
                            <a class="nav-link"  href="#">08-09</a>
                        </li>
                        <li class="nav-item tab-jam" data-id="09:00:00">
                            <a class="nav-link"  href="#">09-10</a>
                        </li>
                        <li class="nav-item tab-jam" data-id="10:00:00">
                            <a class="nav-link"  href="#">10-11</a>
                        </li>
                        <li class="nav-item tab-jam" data-id="11:00:00">
                            <a class="nav-link"  href="#">11-12</a>
                        </li>
                        <li class="nav-item tab-jam" data-id="12:00:00">
                            <a class="nav-link" href="#">12-13</a>
                        </li>
                        <li class="nav-item tab-jam" data-id="13:00:00">
                            <a class="nav-link" href="#">13-14</a>
                        </li>
                        <li class="nav-item tab-jam" data-id="14:00:00">
                            <a class="nav-link" href="#">14-15</a>
                        </li>
                        <li class="nav-item tab-jam" data-id="15:00:00">
                            <a class="nav-link" href="#">15-16</a>
                        </li>
                        <li class="nav-item tab-jam" data-id="16:00:00">
                            <a class="nav-link" href="#">16-17</a>
                        </li>
                        <li class="nav-item tab-jam" data-id="17:00:00">
                            <a class="nav-link" href="#">17-18</a>
                        </li>
                    </ul>
                    <ul class="nav nav-tabs d-none" id="night" role="tablist">
                        <li class="nav-item tab-jam" data-id="18:00:00" >
                            <a class="nav-link active">18-19</a>
                        </li>
                        <li class="nav-item tab-jam" data-id="19:00:00">
                            <a class="nav-link"  href="#">19-20</a>
                        </li>
                        <li class="nav-item tab-jam" data-id="20:00:00">
                            <a class="nav-link"  href="#">20-21</a>
                        </li>
                        <li class="nav-item tab-jam" data-id="21:00:00">
                            <a class="nav-link"  href="#">21-22</a>
                        </li>
                        <li class="nav-item tab-jam" data-id="22:00:00">
                            <a class="nav-link"  href="#">22-23</a>
                        </li>
                        <li class="nav-item tab-jam" data-id="23:00:00">
                            <a class="nav-link"  href="#">23-24</a>
                        </li>
                        <li class="nav-item tab-jam" data-id="00:00:00">
                            <a class="nav-link" href="#">24-01</a>
                        </li>
                        <li class="nav-item tab-jam" data-id="01:00:00" href="#">
                            <a class="nav-link" href="#">01-02</a>
                        </li>
                        <li class="nav-item tab-jam" data-id="02:00:00" href="#">
                            <a class="nav-link" href="#">02-03</a>
                        </li>
                        <li class="nav-item tab-jam" data-id="03:00:00" href="#">
                            <a class="nav-link" href="#">03-04</a>
                        </li>
                        <li class="nav-item tab-jam" data-id="04:00:00" href="#">
                            <a class="nav-link" href="#">04-05</a>
                        </li>
                        <li class="nav-item tab-jam" data-id="05:00:00" href="#">
                            <a class="nav-link" href="#">05-06</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body active-days d-none">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Loading Unit</label>
                                <select name="loading_unit_id" id="loading_unit_id">
                                    <option selected hidden disabled>Pilih Loading Unit</option>
                                    <?php
if (!empty($loading_unit)) {
	foreach ($loading_unit as $key => $value) {
		?>
                                    <option value="<?php echo $value->id; ?>"><?php echo $value->kode . "--" . $value->brand_name . "--" . $value->unit_model_name; ?></option>
                                    <?php }}?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Loader Name</label>
                                <select name="loader_id" id="loader_id">
                                    <option selected hidden disabled>Pilih Loader Name</option>
                                    <?php
if (!empty($user_location)) {
	foreach ($user_location as $key => $value) {
		?>
                                        <option value="<?php echo $value->id; ?>"><?php echo $value->nik . " - " . $value->first_name . " (" . $value->role_name . ")"; ?></option>
                                    <?php }}?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Hauling Unit</label>
                                <select name="hauling_unit_id" id="hauling_unit_id">
                                    <option selected hidden disabled>Pilih Hauling Unit</option>
                                    <?php
if (!empty($hauling_unit)) {
	foreach ($hauling_unit as $key => $value) {
		?>
                                    <option value="<?php echo $value->id; ?>"><?php echo $value->kode . "--" . $value->brand_name . "--" . $value->unit_model_name; ?></option>
                                    <?php }}?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Hauler Name</label>
                                <select name="hauler_id" id="hauler_id">
                                    <option selected hidden disabled>Pilih Hauler Name</option>
                                    <?php
if (!empty($user_location)) {
	foreach ($user_location as $key => $value) {
		?>
                                        <option value="<?php echo $value->id; ?>"><?php echo $value->nik . " - " . $value->first_name . " (" . $value->role_name . ")"; ?></option>
                                    <?php }}?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Material</label>
                                <select class="form-control" name="material_id" id="material_id">
                                    <option selected hidden disabled>Pilih Material</option>
                                    <?php
if (!empty($material)) {
	foreach ($material as $key => $value) {
		?>
                                    <option value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                                    <?php }}?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Material 2</label>
                                <select class="form-control" name="material2_id" id="material2_id">
                                    <option selected hidden disabled>Pilih Material</option>
                                    <?php
if (!empty($material)) {
	foreach ($material as $key => $value) {
		?>
                                    <option value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                                    <?php }}?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Disposal</label>
                                <select class="form-control" name="disposal_id" id="disposal_id">
                                    <option selected hidden disabled>Pilih Disposal</option>
                                    <?php
if (!empty($disposal)) {
	foreach ($disposal as $key => $value) {
		?>
                                    <option value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                                    <?php }}?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Distance</label>
                                <div class="input-group">
                                    <input type="text" class="form-control number" placeholder="Distance"name="distance" id="distance" aria-label="Username" aria-describedby="basic-addon1">
                                    <div class="input-group-append">
                                        <span class="input-group-text">meter</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Total Ritase</label>
                                <input type="text" class="form-control number" name="total_ritase" id="total_ritase" placeholder="Total Ritaase">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Kapasitas</label>
                                <div class="input-group">
                                    <input type="text" class="form-control number" name="capacity" id="capacity" placeholder="Kapasitas">
                                    <div class="input-group-append">
                                        <span class="input-group-text">bcm</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Total Production</label>
                                <input type="text" readonly="" class="form-control number" name="total_production" id="total_production" placeholder="Total Production">
                                <input type="hidden" id="page" value="create">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body box-data">
                <div class="table-responsive">
                    <table class="table table-data table-striped table-bordered" id="table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Jam</th>
                                <th>Shift</th>
                                <th>Loading Unit</th>
                                <th>Hauling Unit</th>
                                <th>Loader Name</th>
                                <th>Supervisor</th>
                                <th>Total Ritase</th>
                                <th>Capacity</th>
                                <th>Total Production</th>
                                <th width="15%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-sm-12 text-right">
                        <a href="<?php echo base_url() ?>ob_actual" class="btn btn-danger">Batal
                        </a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- Table -->
</section>
<script data-main="<?php echo base_url() ?>assets/js/main/main-ob-actual" src="<?php echo base_url() ?>assets/js/require.js"></script>