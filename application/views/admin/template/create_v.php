<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Template Baru</h1>
        <p class="m-0">Template</p>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo base_url() ?>template"></i>Template</a></li>
          <li class="breadcrumb-item active">Template Baru</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</section>

<!-- Icon For Alert -->
<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
  <symbol id="check-circle-fill" viewBox="0 0 16 16">
    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
  </symbol>
  <symbol id="info-fill" viewBox="0 0 16 16">
    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
  </symbol>
  <symbol id="exclamation-triangle-fill" viewBox="0 0 16 16" style="fill: white; opacity: 70%">
    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
  </symbol>
</svg>
<!-- End Icon For Alert -->

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <form id="form" method="post">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-info text-white d-flex align-items-center alert-dismissible fade show" role="alert" style=" border-radius: 8px; flex-wrap: wrap;">
                                <svg class="" aria-label="Warning:" width="25" height="25"><use xlink:href="#exclamation-triangle-fill"/></svg>&nbsp;
                                <h5 class="mt-1" style="opacity: 70%">&nbsp;Penjelasan</h5>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&minus;</span>
                                </button>
                                <div class="content">
                                    <div style="width: 100%"></div>
                                    <hr style="flex-grow: 1; border: 1px solid; opacity: 70%; width: 100%">
                                    <div style="opacity: 70%; width: 100%">
                                        <p>Peraturan dibawah adalah cara kita memunculkan data dinamis yang akan di buat sesuai dengan pesanan yang ada. Mohon mengikuti peraturan karena jika tidak pesan yang akan disampaikan tidak akan sesuai</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-info text-white d-flex align-items-center alert-dismissible fade show" role="alert" style=" border-radius: 8px; flex-wrap: wrap;">
                                <svg class="" aria-label="Warning:" width="25" height="25"><use xlink:href="#exclamation-triangle-fill"/></svg>&nbsp;
                                <h5 class="mt-1" style="opacity: 70%">&nbsp;Rules</h5>
                                <button type="button" class="minimize-rules" aria-label="Close">
                                    <span aria-hidden="true">&minus;</span>
                                </button>
                                <div class="content-rules">
                                    <div style="width: 100%"></div>
                                    <hr style="flex-grow: 1; border: 1px solid; opacity: 70%; width: 100%">
                                    <div style="opacity: 70%; width: 100%">
                                        <table>
                                            <tr>
                                                <td>1.</td>
                                                <td>Nama Pelayanan</td>
                                                <td>=</td>
                                                <td>nama_pelayanan</td>
                                                <td>2.</td>
                                                <td>Nama Paket</td>
                                                <td>=</td>
                                                <td>nama_paket ( hanya berlaku untuk pelayanan selain Joki Bintang )</td>
                                            </tr>
                                            <tr>
                                                <td>3.</td>
                                                <td>Dari Rank</td>
                                                <td>=</td>
                                                <td>dari_rank ( hanya berlaku untuk pelayanan Joki Bintang )</td>
                                                <td>4.</td>
                                                <td>Sampai Rank</td>
                                                <td>=</td>
                                                <td>sampai_rank ( hanya berlaku untuk pelayanan Joki Bintang )</td>
                                            </tr>
                                            <tr>
                                                <td>5.</td>
                                                <td>Dari Point</td>
                                                <td>=</td>
                                                <td>dari_point ( hanya berlaku untuk pelayanan Joki Bintang )</td>
                                                <td>6.</td>
                                                <td>Sampai Point</td>
                                                <td>=</td>
                                                <td>sampai_point ( hanya berlaku untuk pelayanan Joki Bintang )</td>
                                            </tr>
                                            <tr>
                                                <td>7.</td>
                                                <td>Dari Bintang</td>
                                                <td>=</td>
                                                <td>dari_bintang ( hanya berlaku untuk pelayanan Joki Bintang )</td>
                                                <td>8.</td>
                                                <td>Sampai Point</td>
                                                <td>=</td>
                                                <td>sampai_bintang ( hanya berlaku untuk pelayanan Joki Bintang )</td>
                                            </tr>
                                            <tr>
                                                <td>9.</td>
                                                <td>Tanggal Order</td>
                                                <td>=</td>
                                                <td>tanggal_order</td>
                                                <td>10.</td>
                                                <td>Total Order</td>
                                                <td>=</td>
                                                <td>total_order</td>
                                            </tr>
                                            <tr>
                                                <td>11.</td>
                                                <td>Nama Joki</td>
                                                <td>=</td>
                                                <td>nama_joki</td>
                                                <td>12.</td>
                                                <td>No. Handphone Joki</td>
                                                <td>=</td>
                                                <td>no_hp_joki</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="form-label col-sm-4" for="">Jenis Pesan</label>
                                <div class="col-sm-8">
                                    <select name="jenis_pesan" id="jenis_pesan" class="form-control">
                                        <option value="">Pilih Jenis Pesan</option>
                                        <option value="0">Saat Pemesanan</option>
                                        <option value="1">Setelah Pemesanan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="form-label col-sm-4" for="">Pelayanan</label>
                                <div class="col-sm-8">
                                    <select name="id_pelayanan" id="id_pelayanan" class="form-control">
                                        <option value="">Pilih Pelayanan</option>
                                        <?php foreach ($pelayanans as $pelayanan) {?>
                                        <option value="<?php echo $pelayanan->id ?>"><?php echo $pelayanan->name ?></option>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row paket" style="display: none;">
                                <label class="form-label col-sm-4" for="">Paket</label>
                                <div class="col-sm-8">
                                    <select name="id_paket" id="id_paket" class="form-control">
                                        <option value="">Pilih Paket</option>
                                        <?php foreach ($pakets as $paket) {?>
                                        <option value="<?php echo $paket->id ?>"><?php echo $paket->name ?></option>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="form-label col-sm-4" for="">Pesan</label>
                                <div class="col-sm-8">
                                    <textarea name="pesan" id="pesan" class="form-control" cols="30" rows="5" placeholder="Pesan"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-12 text-right">
                            <a href="<?php echo base_url() ?>template" class="btn btn-danger">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>


<script data-main="<?php echo base_url() ?>assets/js/main/main-template" src="<?php echo base_url() ?>assets/js/require.js"></script>