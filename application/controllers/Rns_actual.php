<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'core/Admin_Controller.php';
class Rns_actual extends Admin_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('rns_actual_model');
		$this->load->model('unit_model');
		$this->load->model('ob_actual_model');
		$this->load->model('location_model');
		$this->load->model('pit_model');
		$this->load->model('blok_model');
		$this->load->model('seam_model');
		$this->load->model('user_mutation_model');
	}

	public function index() {

		$this->load->helper('url');
		if ($this->data['is_can_read']) {
			$this->data['content'] = 'admin/rns_actual/list_v';
		} else {
			$this->data['content'] = 'errors/html/restrict';
		}
		$this->load->view('admin/layouts/page', $this->data);
	}

	public function create() 
	{
		$this->form_validation->set_rules('tanggal', "Tanggal Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('type', "Type Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('location_id', "Site Harus Dipilih", 'trim|required');
		$this->form_validation->set_rules('pit_id', "PIT Harus Dipilih", 'trim|required');
		$this->form_validation->set_rules('seam_id', "Seam Harus Dipilih", 'trim|required');
		$this->form_validation->set_rules('blok_id', "Blok Harus Dipilih", 'trim|required');
		$this->form_validation->set_rules('shift', "Shift Harus Dipilih", 'trim|required');

		if ($this->form_validation->run() === TRUE) {
			$tanggal = date("Y-m-d", strtotime($this->input->post("tanggal")));	
			$shift 	= $this->input->post('shift');
			$start 	= $this->input->post('start');
			$stop 	= $this->input->post('stop');
			if($shift == "NS"){
				$cek_jam_start = date("H", strtotime($start));
				if((int)$cek_jam_start >= 0 && (int)$cek_jam_start <= 6 ){
					$start =  date("Y-m-d H:i:s", strtotime($tanggal." ".$start. "+1 days"));
				}else{
					$start = date("Y-m-d H:i:s", strtotime($tanggal." ".$start));
				}

				$cek_jam_stop = date("H", strtotime($stop));
				if((int)$cek_jam_stop >= 0 && (int)$cek_jam_stop <= 6 ){
					$stop =  date("Y-m-d H:i:s", strtotime($tanggal." ".$stop. "+1 days"));
				}else{
					$stop = date("Y-m-d H:i:s", strtotime($tanggal." ".$stop));
				}
			}else{
				$start 	= date("Y-m-d H:i:s", strtotime($tanggal." ".$start));
				$stop 	= date("Y-m-d H:i:s", strtotime($tanggal." ".$stop));
			}

			$data = array(
				'tanggal' => $tanggal,
				'type' => $this->input->post('type'),
				'location_id' => $this->input->post('location_id'),
				'pit_id' => $this->input->post('pit_id'),
				'seam_id' => $this->input->post('seam_id'),
				'blok_id' => $this->input->post('blok_id'),
				'shift' 	=> $shift,
				'rainfall' => $this->input->post('rainfall'),
				'created_by' => $this->data['users']->user_id,
			);

			if ($this->input->post('stop')) {
				$data_stop = array(
					'stop' => $stop,
					'rainfall' => $this->input->post('rainfall'),
				);

				$id = $this->input->post('id');

				if ($this->rns_actual_model->update($data_stop, array("rns_actual.id" => $id))) {
					$this->session->set_flashdata('message', "Stop RNS Berhasil Disimpan");
					redirect("rns_actual");
				} else {
					$this->session->set_flashdata('message_error', "Stop RNS Gagal Disimpan");
					redirect("rns_actual");
				}
			} else {
				$data['iterasi'] = $this->input->post('iterasi');
				$data['start'] = $start;
				if ($this->rns_actual_model->insert($data)) {
					$this->session->set_flashdata('message', "Start RNS Berhasil Disimpan");
					redirect("rns_actual");
				} else {
					$this->session->set_flashdata('message_error', "Start RNS Gagal Disimpan");
					redirect("rns_actual");
				}
			}

		} else {
			$this->data['content'] = 'admin/rns_actual/create_v';
			$location_id = $this->user_mutation_model->getLastLocation($this->data['users']->id);
		
			$where_location = [
				"location.is_deleted" => 0,
			];
			if(!empty($location_id)){
				$where_location["location.id"] = $location_id;
			}
			$location = $this->location_model->getAllById($where_location);
			if (!empty($location)) {
				$this->data['locations'] = $location;
			} else {
				$this->data['locations'] = [];
			}

			$this->data['pits'] = $this->pit_model->getAllById();
			$this->data['seams'] = $this->seam_model->getAllById();
			$this->data['bloks'] = $this->blok_model->getAllById();
			$this->load->view('admin/layouts/page', $this->data);
		}
	}

	public function edit($id) 
	{
		$this->form_validation->set_rules('stop', "Stop Harus Diisi", 'trim|required');

		if ($this->form_validation->run() === TRUE) 
		{
			$id = $this->input->post('id');
			$stop = $this->input->post('stop');
			$rns = $this->rns_actual_model->getOneBy(['rns_actual.id' => $id]);
			$shift = $rns->shift;
			$tanggal = date("Y-m-d", strtotime($rns->tanggal));

			if($shift == "NS"){
				$cek_jam_stop = date("H", strtotime($stop));
				if((int)$cek_jam_stop >= 0 && (int)$cek_jam_stop <= 6 ){
					$tanggal =  date("Y-m-d", strtotime($tanggal. "+1 days"));
				}
			}

			$data = array(
				'stop' => $tanggal . " " . $stop,
			);

			$update = $this->rns_actual_model->update($data, ["rns_actual.id" => $id]); 
			if ($update) {
				$this->session->set_flashdata('message', "Stop RNS Berhasil Disimpan");
				redirect("rns_actual");
			} else {
				$this->session->set_flashdata('message_error', "Stop RNS Gagal Disimpan");
				redirect("rns_actual");
			}

		} else {
			$this->data['content'] = 'admin/rns_actual/edit_v';
			$this->data['id'] = $id;
			if ($this->data['users']->id == "1") {
				$location_id = "1";
			} else {
				$location_id = $this->user_mutation_model->getLastLocation($this->data['users']->id);
			}
			$where_location = [
				"location.id" => $location_id,
				"location.is_deleted" => 0,
			];
			$location = $this->location_model->getOneBy($where_location);
			if (!empty($location)) {
				$this->data['locations'] = $location;
			} else {
				$this->data['locations'] = [];
			}

			$this->load->view('admin/layouts/page', $this->data);
		}
	}

	public function dataList() {

		$columns = array(
			0 => 'tanggal',
			1 => 'type',
			2 => 'site_name',
			3 => 'pit_name',
			4 => 'seam_name',
			5 => 'blok_name',
			6 => 'shift',
			7 => 'start',
			8 => 'stop',
			9 => 'rainfall',
			10 => '',
		);

		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];
		$search = array();
		$where = array();
		$limit = 0;
		$start = 0;

		$totalData = $this->rns_actual_model->getCountAllBy($limit, $start, $search, $order, $dir, $where);
		$searchColumn = $this->input->post('columns');
		$filtered = false;

		if (!empty($this->input->post('search')['value'])) {
			$search_value = $this->input->post('search')['value'];
			$search = array(
				"rns_actual.tanggal" => $search_value,
				"rns_actual.type" => $search_value,
				"location.name" => $search_value,
				"seam.name" => $search_value,
				"pit.name" => $search_value,
				"blok.name" => $search_value,
				"rns_actual.shift" => $search_value,
				"rns_actual.start" => $search_value,
				"rns_actual.stop" => $search_value,
				"rns_actual.rainfall" => $search_value,
			);
			$filtered = true;
		}

		if ($filtered) {
			$totalFiltered = $this->rns_actual_model->getCountAllBy($limit, $start, $search, $order, $dir, $where);

		} else {
			$totalFiltered = $totalData;
		}

		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$datas = $this->rns_actual_model->getAllBy($limit, $start, $search, $order, $dir, $where);

		$new_data = array();
		if (!empty($datas)) {

			foreach ($datas as $key => $data) {
				$edit_url = "";

				if ($this->data['is_can_edit'] && $data->stop == null) {
					$edit_url = "<a href='" . base_url() . "rns_actual/edit/" . $data->id . "' class='btn btn-sm btn-danger'> Stop RNS</a>";
				}

				if ($data->type == 0) {
					$nestedData['type'] = "Rain";
				} else if ($data->type == 1) {
					$nestedData['type'] = "Slippery";
				} else if ($data->type == 2) {
					$nestedData['type'] = "Fog";
				}

				$nestedData['id'] = $start + $key + 1;
				$nestedData['tanggal'] = $data->tanggal;
				$nestedData['site_name'] = $data->site_name;
				$nestedData['pit_name'] = $data->pit_name;
				$nestedData['seam_name'] = $data->seam_name;
				$nestedData['blok_name'] = $data->blok_name;
				$nestedData['shift'] = $data->shift;
				$nestedData['start'] = $data->start;
				$nestedData['stop'] = $data->stop;
				$nestedData['rainfall'] = $data->rainfall;

				if ($this->data['users']->id == "1") {
					$location_id = "1";
				} else {
					$location_id = $this->user_mutation_model->getLastLocation($this->data['users']->id);
				}
				if ($data->location_id == $location_id) {
					$nestedData['action'] = $edit_url;
				} else {
					$nestedData['action'] = "";
				}
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

	public function getBlok() {
		$id = $this->input->post("id");
		$blok = $this->blok_model->getAllById(['blok.seam_id' => $id]);

		if (!empty($blok)) {
			$response_data['status'] = true;
			$response_data['data'] = $blok;
			$response_data['message'] = 'Berhasil Mengambil Data';
		} else {
			$response_data['status'] = false;
			$response_data['data'] = [];
			$response_data['message'] = 'Gagal Mengambil Data';
		}

		echo json_encode($response_data);
	}

	public function cekData() {
		$where = array(
			'type' => $this->input->post('type'),
			'location_id' => $this->input->post('location_id'),
			'pit_id' => $this->input->post('pit_id'),
			'seam_id' => $this->input->post('seam_id'),
			'blok_id' => $this->input->post('blok_id'),
			'stop' => NULL
		);

		$cek = $this->rns_actual_model->getOneBy($where);

		if ($cek) {
			if ($cek->stop == null) {
				$status = true;
			} else {
				$status = false;
			}
			$response_data['status'] = $status;
			$response_data['data'] = $cek;
			$response_data['message'] = 'Berhasil';
		} else {
			$status = false;
			$response_data['status'] = $status;
			$response_data['data'] = 'Kosong';
			$response_data['message'] = 'Gagal';
		}

		echo json_encode($response_data);
	}

}
