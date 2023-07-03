<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'core/Admin_Controller.php';
class Order extends Admin_Controller 
{
	public function __construct() 
	{
		parent::__construct();
		$this->load->model('order_model');
		$this->load->model('joki_model');
		$this->load->model('paket_model');
		$this->load->model('pelayanan_model');
		$this->load->model('rank_model');
		$this->load->model('set_poin_model');
		$this->load->model('set_bintang_model');
	}

	public function index() 
	{
		$this->load->helper('url');
		if ($this->data['is_can_read']) {
			$this->data['content'] = 'admin/order/list_v';
		} else {
			$this->data['content'] = 'errors/html/restrict';
		}

		$this->load->view('admin/layouts/page', $this->data);
	}

	public function create() 
	{
		$this->form_validation->set_rules('tanggal', "Tanggah Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('email', "Email Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('password', "Password Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('request_hero', "Request Hero Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('nickname', "Nickname Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('login_via', "Login Via Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('nomor_whatsapp', "Nomor Whatsapp Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('id_pelayanan', "Pelayanan Harus Dipilih", 'trim|required');

		if ($this->form_validation->run() === TRUE) {
			
			$total_harga = str_replace('Rp.','', $this->input->post('total_harga'));
			$total_harga = str_replace(',','',  $total_harga);

			$nofaktur = $this->order_model->make_id();

			$tanggal = date("Y-m-d", strtotime($this->input->post("tanggal")));

			$dari_rank = $this->input->post('rank');

			if($dari_rank == 11){
				$sampai_point = $this->input->post('mythic_point');
				$sampai_rank = 11;
			}else{
				$sampai_point = $this->input->post('sampai_point');
				$sampai_rank = $this->input->post('sampai_rank');
			}

			$data = array(
				'no_faktur' => $nofaktur,
				'id_paket' => $this->input->post('id_paket'),
				'id_pelayanan' => $this->input->post('id_pelayanan'),
				'tanggal' => $tanggal,
				'email' => $this->input->post('email'),
				'password' => $this->input->post('password'),
				'request_hero' => $this->input->post('request_hero'),
				'catatan' => $this->input->post('catatan'),
				'nickname' => $this->input->post('nickname'),
				'login_via' => $this->input->post('login_via'),
				'nomor_whatsapp' => $this->input->post('nomor_whatsapp'),
				'dari_rank' => $this->input->post('rank'),
				'sampai_rank' => $sampai_rank,
				'dari_bintang' => $this->input->post('bintang'),
				'sampai_bintang' => $this->input->post('sampai_bintang'),
				'dari_point' => $this->input->post('point'),
				'sampai_point' => $sampai_point,
				'status_orderan' => 0,
				'total_harga' => $total_harga
			);

			$location_path = "./uploads/order/";
			if(!is_dir($location_path))
			{
				mkdir($location_path);
			}

			$tmp = $_FILES["bukti_pembayaran"]['name'];
			$ext = ".".pathinfo($tmp, PATHINFO_EXTENSION);
			$uploaded      = uploadFile('bukti_pembayaran', $location_path, 'bukti_bayar', $ext);
			
			if($uploaded['status']==TRUE){
				$data['bukti_pembayaran'] = str_replace(' ', '_', $uploaded['message']);	
			}

			if ($this->order_model->insert($data)) {
				$this->session->set_flashdata('message', "Order Baru Berhasil Disimpan");
				redirect("order");
			} else {
				$this->session->set_flashdata('message_error', "Order Baru Gagal Disimpan");
				redirect("order");
			}
		} else {
			$this->data['content'] = 'admin/order/create_v';
			$this->data['jokis'] = $this->joki_model->getAllById();
			$this->data['pakets'] = $this->paket_model->getAllById();
			$this->data['pelayanans'] = $this->pelayanan_model->getAllById();
			$this->data['ranks'] = $this->rank_model->getAllById();
			$this->load->view('admin/layouts/page', $this->data);
		}
	}

	public function edit($id) 
	{
		$this->form_validation->set_rules('tanggal', "Tanggah Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('email', "Email Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('password', "Password Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('request_hero', "Request Hero Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('catatan', "Catatan Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('nickname', "Nickname Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('login_via', "Login Via Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('nomor_whatsapp', "Nomor Whatsapp Harus Diisi", 'trim|required');

		if ($this->form_validation->run() === TRUE) {

			$tanggal = date("Y-m-d", strtotime($this->input->post("tanggal")));

			$data = array(
				'id_paket' => $this->input->post('id_paket'),
				'tanggal' => $tanggal,
				'email' => $this->input->post('email'),
				'password' => $this->input->post('password'),
				'request_hero' => $this->input->post('request_hero'),
				'catatan' => $this->input->post('catatan'),
				'nickname' => $this->input->post('nickname'),
				'login_via' => $this->input->post('login_via'),
				'nomor_whatsapp' => $this->input->post('nomor_whatsapp'),
				'status_orderan' => 0,
			);

			$location_path = "./uploads/order/";
			if(!is_dir($location_path))
			{
				mkdir($location_path);
			}

			$tmp = $_FILES["bukti_pembayaran"]['name'];
			$ext = ".".pathinfo($tmp, PATHINFO_EXTENSION);
			$uploaded      = uploadFile('bukti_pembayaran', $location_path, 'bukti_bayar', $ext);
			
			if($uploaded['status']==TRUE){
				$data['bukti_pembayaran'] = str_replace(' ', '_', $uploaded['message']);	
			}

			$update = $this->order_model->update($data, array("order.id" => $id));
			if ($update) {
				$this->session->set_flashdata('message', "order Berhasil Diubah");
				redirect("order", "refresh");
			} else {
				$this->session->set_flashdata('message_error', "order Gagal Diubah");
				redirect("order", "refresh");
			}
		} else {
			if (!empty($_POST)) {
				$id = $this->input->post('id');
				$this->session->set_flashdata('message_error', validation_errors());
				return redirect("order/edit/" . $id);
			} else {
				$this->data['id'] = $this->uri->segment(3);
				$order = $this->order_model->getAllById(array("order.id" => $this->data['id']));
				$tanggal = date("d-m-Y", strtotime($order[0]->tanggal));
				$this->data['tanggal'] 	= $tanggal;
				$this->data['email'] = (!empty($order)) ? $order[0]->email : "";
				$this->data['password'] = (!empty($order)) ? $order[0]->password : "";
				$this->data['request_hero'] = (!empty($order)) ? $order[0]->request_hero : "";
				$this->data['catatan'] = (!empty($order)) ? $order[0]->catatan : "";
				$this->data['nickname'] = (!empty($order)) ? $order[0]->nickname : "";
				$this->data['login_via'] = (!empty($order)) ? $order[0]->login_via : "";
				$this->data['id_paket'] = (!empty($order)) ? $order[0]->id_paket : "";
				$this->data['nomor_whatsapp'] = (!empty($order)) ? $order[0]->nomor_whatsapp : "";
				$this->data['bukti_pembayaran'] = (!empty($order)) ? $order[0]->bukti_pembayaran : "";
				// $pelayanan = $this->paket_model->getOneBy(array('paket.id' => $this->data['id_paket']));
				// $this->data['id_pelayanan'] = $pelayanan->id_pelayanan;f
				$this->data['id_pelayanan'] = (!empty($order)) ? $order[0]->id_pelayanan : "";
				$this->data['jokis'] = $this->joki_model->getAllById();
				$this->data['pakets'] = $this->paket_model->getAllById();
				$this->data['pelayanans'] = $this->pelayanan_model->getAllById();
				$this->data['content'] = 'admin/order/edit_v';

				

				$this->load->view('admin/layouts/page', $this->data);
			}
		}

	}

	public function detail($id) 
	{
		$this->data['id'] = $this->uri->segment(3);
		$order = $this->order_model->getAllById(array("order.id" => $this->data['id']));
		$tanggal = date("d-m-Y", strtotime($order[0]->tanggal));
		$this->data['tanggal'] 	= $tanggal;
		$this->data['email'] = (!empty($order)) ? $order[0]->email : "";
		$this->data['password'] = (!empty($order)) ? $order[0]->password : "";
		$this->data['request_hero'] = (!empty($order)) ? $order[0]->request_hero : "";
		$this->data['catatan'] = (!empty($order)) ? $order[0]->catatan : "";
		$this->data['nickname'] = (!empty($order)) ? $order[0]->nickname : "";
		$this->data['no_faktur'] = (!empty($order)) ? $order[0]->no_faktur : "";
		// $this->data['paket_name'] = (!empty($order)) ? $order[0]->paket_name : "";
		$this->data['login_via'] = (!empty($order)) ? $order[0]->login_via : "";
		$this->data['id_paket'] = (!empty($order)) ? $order[0]->id_paket : "";
		$this->data['id_pelayanan'] = (!empty($order)) ? $order[0]->id_pelayanan : "";
		$this->data['nomor_whatsapp'] = (!empty($order)) ? $order[0]->nomor_whatsapp : "";
		$this->data['pelayanan_name'] = (!empty($order)) ? $order[0]->pelayanan_name : "";
		$this->data['dari_rank_id'] = (!empty($order)) ? $order[0]->dari_rank : "";
		$this->data['dari_rank_name'] = (!empty($order)) ? $order[0]->dari_rank_name : "";
		$this->data['sampai_rank_name'] = (!empty($order)) ? $order[0]->sampai_rank_name : "";
		$this->data['sampai_rank_id'] = (!empty($order)) ? $order[0]->sampai_rank : "";
		$this->data['dari_bintang'] = (!empty($order)) ? $order[0]->dari_bintang : "";
		$this->data['sampai_bintang'] = (!empty($order)) ? $order[0]->sampai_bintang : "";
		$this->data['dari_point'] = (!empty($order)) ? $order[0]->dari_point : "";
		$this->data['sampai_point'] = (!empty($order)) ? $order[0]->sampai_point : "";
		$this->data['total_harga'] = (!empty($order)) ? $order[0]->total_harga : "";

		$this->data['bukti_pembayaran'] = (!empty($order)) ? $order[0]->bukti_pembayaran : "";
		$pelayanan = $this->paket_model->getOneBy(array('paket.id' => $this->data['id_paket']));
		// $this->data['id_pelayanan'] = $pelayanan->id_pelayanan;

		$paket = $this->paket_model->getOneBy(array('paket.id' => $this->data['id_paket']));
		$this->data['paket_name'] = (!empty($paket)) ? $paket->name : "";

		$this->data['jokis'] = $this->joki_model->getAllById();
		$this->data['pakets'] = $this->paket_model->getAllById();
		$this->data['pelayanans'] = $this->pelayanan_model->getAllById();
		$this->data['content'] = 'admin/order/detail_v';

		if($order[0]->status_orderan == 0){
			$this->data['status'] = "Review";
			$this->data['background'] = "bg-primary";
		}else if($order[0]->status_orderan == 1){
			$this->data['status'] = "Proses Pengerjaan";
			$this->data['background'] = "bg-warning";
		}else if($order[0]->status_orderan == 2){
			$this->data['status'] = "Ditolak";
			$this->data['background'] = "bg-danger";
		}else if($order[0]->status_orderan == 3){
			$this->data['status'] = "Selesai";
			$this->data['background'] = "bg-success";
		}else if($order[0]->status_orderan == 4){
			$this->data['status'] = "Sudah dicairkan";
			$this->data['background'] = "bg-info";
		}

		$this->load->view('admin/layouts/page', $this->data);
	}

	public function dataList() 
	{
		$columns = array(
			0 => 'no_faktur',
			1 => 'tanggal',
			2 => 'email',
			3 => 'password',
			4 => 'request_hero',
			5 => 'catatan',
			6 => 'nickname',
			7 => 'login_via',
			8 => 'nomor_whatsapp',
			9 => 'bukti_pembayaran',
			10 => 'status',
			11 => ''
		);

		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];
		$search = array();
  		$where = array();
		$limit = 0;
		$start = 0;
		$totalData = $this->order_model->getCountAllBy($limit, $start, $search, $order, $dir, $where);
		$searchColumn = $this->input->post('columns');
		$filtered = false;

		if(!empty($searchColumn[1]['search']['value'])){
			$value = $searchColumn[1]['search']['value'];
			$where['order.tanggal'] = $value;

			$filtered = true;
		}


		if(!empty($searchColumn[11]['search']['value'])){
			$value = $searchColumn[11]['search']['value'];
			$where['order.status_orderan'] = $value;

			$filtered = true;
		}

		if (!empty($this->input->post('search')['value'])) {
			$search_value = $this->input->post('search')['value'];
			$search = array(
				"pelayanan.name" => $search_value,
				"order.no_faktur" => $search_value,
				"order.tanggal" => $search_value,
				"order.email" => $search_value,
				"order.password" => $search_value,
				"order.request_hero" => $search_value,
				"order.catatan" => $search_value,
				"order.nickname" => $search_value,
				"order.login_via" => $search_value,
				"order.nomor_whatsapp" => $search_value,
			);

			$filtered = true;
		}

		if($filtered){
			$totalFiltered = $this->order_model->getCountAllBy($limit, $start, $search, $order, $dir, $where);
		}else{
			$totalFiltered = $totalData;
		}

		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$datas = $this->order_model->getAllBy($limit, $start, $search, $order, $dir, $where);

		$new_data = array();
		if (!empty($datas)) {

			foreach ($datas as $key => $data) {

				$edit_url = "";
				$delete_url = "";
				if ($this->data['is_can_delete'] && $data->status_orderan == 0) {
					$delete_url = "<a href='#'
						url='" . base_url() . "order/destroy/" . $data->id . "/" . $data->is_deleted . "'
						class='btn btn-sm btn-danger white delete'> Hapus
						</a>";
				}

				$detail_url = "<a href='" . base_url() . "order/detail/" . $data->id . "' class='btn btn-sm btn-primary white'> Detail</a>";

				$nestedData['id'] = $start + $key + 1;
				$nestedData['tanggal'] = $data->tanggal;
				$nestedData['no_faktur'] = $data->no_faktur;
				$nestedData['email'] = $data->email;
				$nestedData['joki_name'] = "-";

				if($data->id_joki != null){
					$joki = $this->joki_model->getOneBy(array('joki.id' => $data->id_joki));
					$nestedData['joki_name'] = $joki->name;
				}

				$nestedData['password'] = $data->password;
				$nestedData['request_hero'] = $data->request_hero;
				$nestedData['catatan'] = $data->catatan;
				$nestedData['nickname'] = $data->nickname;
				$nestedData['login_via'] = $data->login_via;
				$nestedData['paket_name'] = $data->pelayanan_name;
				$nestedData['nomor_whatsapp'] = $data->nomor_whatsapp;
				$nestedData['bukti_pembayaran'] = "<a href='".base_url('uploads/order/'.$data->bukti_pembayaran)."' target='_blank'><img src='".base_url('uploads/order/'.$data->bukti_pembayaran)."' width='50'></a>";
				
				if($data->status_orderan == 0){
					$status = "Review";
				}else if($data->status_orderan == 1){
					$status = "Proses Pengerjaan";
				}else if($data->status_orderan == 2){
					$status = "Ditolak";
				}else if($data->status_orderan == 3){
					$status = "Selesai";
				}else if($data->status_orderan == 4){
					$status = "Sudah dicairkan";
				}

				$nestedData['status_orderan'] = $status;


				$nestedData['action'] = $detail_url." ".$edit_url . " " . $delete_url;
				$new_data[] = $nestedData;
			}
		}

		$json_data = array(
			"draw" => intval($this->input->post('draw')),
			"recordsTotal" => intval($totalData),
			"recordsFiltered" => intval($totalFiltered),
			"data" => $new_data,
		);

		echo json_encode($json_data);
	}

	public function destroy() 
	{
		$response_data = array();
		$response_data['status'] = false;
		$response_data['msg'] = "";
		$response_data['data'] = array();

		$id = $this->uri->segment(3);
		$is_deleted = $this->uri->segment(4);
		if (!empty($id)) {
			$this->load->model("order_model");
			$data = array(
				'is_deleted' => ($is_deleted == 1) ? 0 : 1,
			);
			$update = $this->order_model->update($data, array("id" => $id));

			$response_data['data'] = $data;
			$response_data['msg'] = "order Berhasil di Hapus";
			$response_data['status'] = true;
		} else {
			$response_data['msg'] = "ID Harus Diisi";
		}

		echo json_encode($response_data);
	}

	public function getPaket() {
		$id = $this->input->post("id");
		$paket = $this->paket_model->getAllById(['pelayanan.id' => $id]);

		if (!empty($paket)) {
			$response_data['status'] = true;
			$response_data['data'] = $paket;
			$response_data['message'] = 'Berhasil Mengambil Data';
		} else {
			$response_data['status'] = false;
			$response_data['data'] = [];
			$response_data['message'] = 'Gagal Mengambil Data';
		}

		echo json_encode($response_data);
	}

	public function getRank() {
		$id = $this->input->post("id");
		$rank = $this->rank_model->getAllById(['rank.id >' => $id]);
		if (!empty($rank)) {
			$response_data['status'] = true;
			$response_data['data'] = $rank;
			$response_data['message'] = 'Berhasil Mengambil Data';
		} else {
			$response_data['status'] = false;
			$response_data['data'] = [];
			$response_data['message'] = 'Gagal Mengambil Data';
		}

		echo json_encode($response_data);
	}

	public function getHargaPaket() {
		$id = $this->input->post("id");
		$paket = $this->paket_model->getAllById(['paket.id' => $id]);
		if (!empty($paket)) {
			$response_data['status'] = true;
			$response_data['data'] = $paket;
			$response_data['message'] = 'Berhasil Mengambil Data';
		} else {
			$response_data['status'] = false;
			$response_data['data'] = [];
			$response_data['message'] = 'Gagal Mengambil Data';
		}

		echo json_encode($response_data);
	}

	public function getHargaMythicGlory() {
		$dari_rank = $this->input->post("dari_rank");
		$dari_point = $this->input->post("dari_point");
		$sampai_point = $this->input->post("mythic_point");
		$sampai_rank = $dari_rank;

		$rank = $this->set_poin_model->getAllById(['point_price.rank_id' => $dari_rank]);

		$total_point = $sampai_point - $dari_point;

		$total_harga = $rank[0]->price * $total_point;
		
		if (!empty($rank) && $total_harga > 0) {
			$response_data['status'] = true;
			$response_data['data'] = $total_harga;
			$response_data['message'] = 'Berhasil Mengambil Data';
		} else {
			$response_data['status'] = false;
			$response_data['data'] = [];
			$response_data['message'] = 'Gagal Mengambil Data';
		}

		echo json_encode($response_data);
	}

	public function getHargaBintang() {
		$dari_rank = $this->input->post("dari_rank");
		$dari_bintang = $this->input->post("dari_bintang");
		$sampai_bintang = $this->input->post("sampai_bintang");
		$sampai_rank = $this->input->post("sampai_rank");

		$ranks = $this->set_bintang_model->getAllById(['star_price.rank_id >= ' => $dari_rank, 'star_price.rank_id <= ' => $sampai_rank]);

		$i = 0;
		foreach ($ranks as $key => $rank) {
			if($rank->rank_id == $dari_rank){
				$total[$i] = (5 - $dari_bintang) * $rank->price;
			}else if($rank->rank_id == $sampai_rank){
				$total[$i] = (5 - $sampai_bintang) * $rank->price;
			}else{
				$total[$i] = $rank->price * 5;
			}
			$i++;
		}

		$total_harga = array_sum($total);

		if (!empty($ranks) && $total_harga > 0) {
			$response_data['status'] = true;
			$response_data['data'] = $total_harga;
			$response_data['message'] = 'Berhasil Mengambil Data';
		} else {
			$response_data['status'] = false;
			$response_data['data'] = [];
			$response_data['message'] = 'Gagal Mengambil Data';
		}

		echo json_encode($response_data);
	}

	public function getHargaPoint() {
		$dari_rank = $this->input->post("dari_rank");
		$dari_point = $this->input->post("dari_point");
		$sampai_point = $this->input->post("sampai_point");
		$sampai_rank = $this->input->post("sampai_rank");

		$ranks = $this->set_poin_model->getAllById(['point_price.rank_id >= ' => $dari_rank, 'point_price.rank_id <= ' => $sampai_rank]);

		$i = 0;
		foreach ($ranks as $key => $rank) {
			if($rank->rank_id == $dari_rank){
				$total[$i] = ($dari_point - $rank->batas_point) * $rank->price;
			}else if($rank->rank_id == $sampai_rank){
				$total[$i] = ($sampai_point - $rank->batas_point) * $rank->price;
			}else{
				$total[$i] = $rank->price * 99;
			}
			$i++;
		}

		$total_harga = array_sum($total);

		if (!empty($ranks) && $total_harga > 0) {
			$response_data['status'] = true;
			$response_data['data'] = $total_harga;
			$response_data['message'] = 'Berhasil Mengambil Data';
		} else {
			$response_data['status'] = false;
			$response_data['data'] = [];
			$response_data['message'] = 'Gagal Mengambil Data';
		}

		echo json_encode($response_data);
	}

	public function getHargaBintangPoint() {
		$dari_rank = $this->input->post("dari_rank");
		$dari_bintang = $this->input->post("dari_bintang");
		$sampai_rank = $this->input->post("sampai_rank");
		$sampai_point = $this->input->post("sampai_point");

		$rank_stars = $this->set_bintang_model->getAllById(['star_price.rank_id >= ' => $dari_rank, 'star_price.rank_id <= ' => 5]);

		$i = 0;
		foreach ($rank_stars as $key => $rank) {
			if($rank->rank_id == $dari_rank){
				$total_bintang[$i] = (5 - $dari_bintang) * $rank->price;
			}else if($rank->rank_id == $sampai_rank){
				$total_bintang[$i] = (5 - $sampai_bintang) * $rank->price;
			}else{
				$total_bintang[$i] = $rank->price * 5;
			}
			$i++;
		}

		$total_harga_bintang = array_sum($total_bintang);

		$rank_points = $this->set_poin_model->getAllById(['point_price.rank_id >= ' => 6, 'point_price.rank_id <= ' => $sampai_rank]);

		$index = 0;

		foreach ($rank_points as $key => $rank_point) {
			if($rank_point->rank_id == 6 && $sampai_point <= 200){
				$total[$index] = $rank_point->price * $sampai_point;
			}else if($rank_point->rank_id == $sampai_rank){
				$total[$index] = ($rank_point->batas_point - $sampai_point) * $rank_point->price;
			}else{
				$total[$index] = $rank_point->price * 99;
			}
			$index++;
		}

		$total_harga_point = array_sum($total);
		
		$total_harga = $total_harga_bintang + $total_harga_point;

		if (!empty($rank_stars) && !empty($rank_points) && $total_harga > 0) {
			$response_data['status'] = true;
			$response_data['data'] = $total_harga;
			$response_data['message'] = 'Berhasil Mengambil Data';
		} else {
			$response_data['status'] = false;
			$response_data['data'] = [];
			$response_data['message'] = 'Gagal Mengambil Data';
		}

		echo json_encode($response_data);
	}


	
}
