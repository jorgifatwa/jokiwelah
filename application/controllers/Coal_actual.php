<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'core/Admin_Controller.php';
class Coal_actual extends Admin_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('coal_actual_model');
		$this->load->model('disposal_model');
		$this->load->model('user_mutation_model');
		$this->load->model('ob_actual_model');
		$this->load->model('unit_model');
		$this->load->model('location_model');
		$this->load->model('pit_model');
		$this->load->model('seam_model');
		$this->load->model('blok_model');
		$this->load->model('material_model');
	}

	public function index() {

		$this->load->helper('url');
		if ($this->data['is_can_read']) {
			$this->data['content'] = 'admin/coal_actual/list_v';
		} else {
			$this->data['content'] = 'errors/html/restrict';
		}

		$this->data['bulan'] = getBulan();

		$this->load->view('admin/layouts/page', $this->data);
	}

	public function create_production() {
		$this->form_validation->set_rules('bulan', "Bulan Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('tahun', "Tahun Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('total_production', "Total Production Harus Diisi", 'trim|required');

		if ($this->form_validation->run() === TRUE) {
			$data = array(
				'bulan' => $this->input->post('bulan'),
				'tahun' => $this->input->post('tahun'),
				'total_production' => $this->input->post('total_production'),
				'type' => 'Coal',
			);

			if ($this->ob_actual_model->insert_production($data)) {
				$this->session->set_flashdata('message', "Production JS Baru Berhasil Disimpan");
				echo json_encode($data);
			} else {
				$this->session->set_flashdata('message_error', "Production JS Baru Gagal Disimpan");
				redirect("coal_actual");
			}
		}
	}

	public function create() {
		$this->form_validation->set_rules('no_tiket', 'Nomor Tiket Harus Diisi', 'trim|required');
		$this->form_validation->set_rules('tanggal', 'Tanggal Harus Diisi', 'trim|required');
		$this->form_validation->set_rules('jam_mulai', 'Jam Mulai Harus Diisi', 'trim|required');
		$this->form_validation->set_rules('jam_akhir', 'Jam Berakhir Harus Diisi', 'trim|required');
		$this->form_validation->set_rules('shift', 'Shift Harus Diisi', 'trim|required');
		$this->form_validation->set_rules('aktivitas', 'Aktivitas Harus Diisi', 'trim|required');
		$this->form_validation->set_rules('location_id', 'Site Harus Diisi', 'trim|required');
		$this->form_validation->set_rules('pit_id', 'PIT Harus Diisi', 'trim|required');
		$this->form_validation->set_rules('seam_id', 'Seam Harus Diisi', 'trim|required');
		$this->form_validation->set_rules('blok_id', 'Blok Harus Diisi', 'trim|required');
		$this->form_validation->set_rules('dumping_id', 'Dumping Harus Diisi', 'trim|required');
		$this->form_validation->set_rules('loading_unit_id', 'Loading Unit Harus Diisi', 'trim|required');
		$this->form_validation->set_rules('loader_id', 'Loader Name Harus Diisi', 'trim|required');
		$this->form_validation->set_rules('hauling_unit_id', 'Hauling Unit Harus Diisi', 'trim|required');
		$this->form_validation->set_rules('hauler_id', 'Hauler Name Harus Diisi', 'trim|required');
		$this->form_validation->set_rules('material_id', 'Material Harus Diisi', 'trim|required');
		$this->form_validation->set_rules('distance', 'Distance Harus Diisi', 'trim|required');
		$this->form_validation->set_rules('gross', 'Gross Harus Diisi', 'trim|required');
		$this->form_validation->set_rules('tare', 'Tare Harus Diisi', 'trim|required');
		$this->form_validation->set_rules('netto', 'Netto Harus Diisi', 'trim|required');

		if ($this->form_validation->run() === TRUE) {
			$aksi = $this->input->post("aksi");
			$no_tiket = $this->input->post("no_tiket");
			$tanggal = date("Y-m-d", strtotime($this->input->post("tanggal")));
			$jam_mulai = $this->input->post("jam_mulai");
			$jam_akhir = $this->input->post("jam_akhir");
			$shift = $this->input->post("shift");
			$aktivitas = $this->input->post("aktivitas");

			$location_id = $this->input->post("location_id");
			$pit_id = $this->input->post("pit_id");
			$seam_id = $this->input->post("seam_id");
			$blok_id = $this->input->post("blok_id");
			$dumping_id = $this->input->post("dumping_id");

			$loading_unit_id = $this->input->post("loading_unit_id");
			$loader_id = $this->input->post("loader_id");
			$hauling_unit_id = $this->input->post("hauling_unit_id");
			$hauler_id = $this->input->post("hauler_id");

			$penimbang_id = $this->input->post("penimbang_id");

			$material_id = $this->input->post("material_id");
			$distance = $this->input->post("distance");
			$gross = $this->input->post("gross");
			$tare = $this->input->post("tare");
			$netto = $this->input->post("netto");

			if (!empty($penimbang_id)) {
				$penimbang_id = implode(",", $penimbang_id);
			} else {
				$penimbang_id = NULL;
			}


			if($shift == "NS"){
				$cek_jam_start = date("H", strtotime($jam_mulai));
				if((int)$cek_jam_start >= 0 && (int)$cek_jam_start <= 6 ){
					$jam_mulai =  date("Y-m-d H:i:s", strtotime($tanggal." ".$jam_mulai. "+1 days"));
				}else{
					$jam_mulai = date("Y-m-d H:i:s", strtotime($tanggal." ".$jam_mulai));
				}

				$cek_jam_stop = date("H", strtotime($jam_akhir));
				if((int)$cek_jam_stop >= 0 && (int)$cek_jam_stop <= 6 ){
					$jam_akhir =  date("Y-m-d H:i:s", strtotime($tanggal." ".$jam_akhir. "+1 days"));
				}else{
					$jam_akhir = date("Y-m-d H:i:s", strtotime($tanggal." ".$jam_akhir));
				}
			}else{
				$jam_mulai 	= date("Y-m-d H:i:s", strtotime($tanggal." ".$jam_mulai));
				$jam_akhir 	= date("Y-m-d H:i:s", strtotime($tanggal." ".$jam_akhir));
			}

			$data = array(
				'no_tiket' => $no_tiket,
				'tanggal' => $tanggal,
				'jam_mulai' => $jam_mulai,
				'jam_akhir' => $jam_akhir,
				'shift' => $shift,
				'aktivitas' => $aktivitas,

				'location_id' => $location_id,
				'pit_id' => $pit_id,
				'seam_id' => $seam_id,
				'blok_id' => $blok_id,
				'dumping_id' => $dumping_id,

				'loading_unit_id' => $loading_unit_id,
				'loader_id' => $loader_id,
				'hauling_unit_id' => $hauling_unit_id,
				'hauler_id' => $hauler_id,
				'penimbang' => $penimbang_id,

				'material_id' => $material_id,
				'distance' => $distance,
				'gross' => $gross,
				'tare' => $tare,
				'netto' => $netto,
				'created_by' => $this->data['users']->id,
				'updated_by' => $this->data['users']->id,
				'is_deleted' => 0,
			);

			$insert = $this->coal_actual_model->insert($data);
			if (!empty($aksi)) {
				if ($insert) {
					$return_data = array(
						"status" => true,
						"message" => "Data Berhasil di simpan!",
						"data" => $data,
					);

				} else {
					$return_data = array(
						"status" => false,
						"message" => "Data Berhasil di simpan!",
						"data" => $data,
					);
				}
				echo json_encode($return_data);
			} else {
				if ($insert) {
					$this->session->set_flashdata('message', "Data Coal Aktual Berhasil Disimpan");
					redirect("coal_actual");
				} else {
					$this->session->set_flashdata('message_error', "Data Coal Aktual Gagal Disimpan");
					redirect("coal_actual");
				}
			}
		} else {
			$this->load->helper('url');
			if ($this->data['is_can_read']) {
				$this->data['content'] = 'admin/coal_actual/create_v';
			} else {
				$this->data['content'] = 'errors/html/restrict';
			}

			if ($this->data['users']->id == "1") {
				$location_id = "1";
			} else {
				$location_id = $this->user_mutation_model->getLastLocation($this->data['users']->id);
			}

			$location_id = $this->user_mutation_model->getLastLocation($this->data['users']->id);
			if (empty($location_id)) {
				$location_id = 1;
			}
			$where_unit = [
				'unit_transfer.to_location' => $location_id,
				'unit.operasi_sebagai' => 0,
			];
			$loading_unit = $this->unit_model->getAllByLocation($where_unit);
			if (!empty($loading_unit)) {
				$this->data['loading_unit'] = $loading_unit;
			} else {
				$this->data['loading_unit'] = [];
			}

			$where_unit['unit.operasi_sebagai'] = 1;
			$hauling_unit = $this->unit_model->getAllByLocation($where_unit);
			if (!empty($hauling_unit)) {
				$this->data['hauling_unit'] = $hauling_unit;
			} else {
				$this->data['hauling_unit'] = [];
			}

			$where_disposal = [
				"disposal.is_deleted" => 0,
				"disposal.production" => 2,
				"disposal.location_id" => $location_id,
			];
			$dumpings = $this->disposal_model->getAllById($where_disposal);
			if (!empty($dumpings)) {
				$this->data['dumpings'] = $dumpings;
			} else {
				$this->data['dumpings'] = [];
			}

			$where_user = [
				'user_mutation.to_location' => $location_id,
			];
			$user_location = $this->user_mutation_model->getUserByLocation($where_user);
			if (!empty($user_location)) {
				$this->data['user_location'] = $user_location;
			} else {
				$this->data['user_location'] = [];
			}

			$this->data['material'] = $this->material_model->getAllById([]);

			$where_location = [
				"location.id" => $location_id,
				"location.is_deleted" => 0,
			];
			$location = $this->location_model->getOneBy($where_location);
			if (!empty($location_id)) {
				$this->data['location'] = $location;
			} else {
				$this->data['location'] = $this->location_model->getOneBy(['id' => 1]);
			}

			$this->load->view('admin/layouts/page', $this->data);
		}

	}

	public function edit($id) {
		$this->form_validation->set_rules('no_tiket', 'Nomor Tiket Harus Diisi', 'trim|required');
		$this->form_validation->set_rules('tanggal', 'Tanggal Harus Diisi', 'trim|required');
		$this->form_validation->set_rules('jam_mulai', 'Jam Mulai Harus Diisi', 'trim|required');
		$this->form_validation->set_rules('jam_akhir', 'Jam Berakhir Harus Diisi', 'trim|required');
		$this->form_validation->set_rules('shift', 'Shift Harus Diisi', 'trim|required');
		$this->form_validation->set_rules('aktivitas', 'Aktivitas Harus Diisi', 'trim|required');
		$this->form_validation->set_rules('location_id', 'Site Harus Diisi', 'trim|required');
		$this->form_validation->set_rules('pit_id', 'PIT Harus Diisi', 'trim|required');
		$this->form_validation->set_rules('seam_id', 'Seam Harus Diisi', 'trim|required');
		$this->form_validation->set_rules('blok_id', 'Blok Harus Diisi', 'trim|required');
		$this->form_validation->set_rules('dumping_id', 'Dumping Harus Diisi', 'trim|required');
		$this->form_validation->set_rules('loading_unit_id', 'Loading Unit Harus Diisi', 'trim|required');
		$this->form_validation->set_rules('loader_id', 'Loader Name Harus Diisi', 'trim|required');
		$this->form_validation->set_rules('hauling_unit_id', 'Hauling Unit Harus Diisi', 'trim|required');
		$this->form_validation->set_rules('hauler_id', 'Hauler Name Harus Diisi', 'trim|required');
		$this->form_validation->set_rules('material_id', 'Material Harus Diisi', 'trim|required');
		$this->form_validation->set_rules('distance', 'Distance Harus Diisi', 'trim|required');
		$this->form_validation->set_rules('gross', 'Gross Harus Diisi', 'trim|required');
		$this->form_validation->set_rules('tare', 'Tare Harus Diisi', 'trim|required');
		$this->form_validation->set_rules('netto', 'Netto Harus Diisi', 'trim|required');

		if ($this->form_validation->run() === TRUE) {
			$id = $this->input->post("id");
			$no_tiket = $this->input->post("no_tiket");
			$tanggal = date("Y-m-d", strtotime($this->input->post("tanggal")));
			$jam_mulai = $this->input->post("jam_mulai");
			$jam_akhir = $this->input->post("jam_akhir");
			$shift = $this->input->post("shift");
			$aktivitas = $this->input->post("aktivitas");

			$location_id = $this->input->post("location_id");
			$pit_id = $this->input->post("pit_id");
			$seam_id = $this->input->post("seam_id");
			$blok_id = $this->input->post("blok_id");
			$dumping_id = $this->input->post("dumping_id");

			$loading_unit_id = $this->input->post("loading_unit_id");
			$loader_id = $this->input->post("loader_id");
			$hauling_unit_id = $this->input->post("hauling_unit_id");
			$hauler_id = $this->input->post("hauler_id");

			$penimbang_id = $this->input->post("penimbang_id");

			$material_id = $this->input->post("material_id");
			$distance = $this->input->post("distance");
			$gross = $this->input->post("gross");
			$tare = $this->input->post("tare");
			$netto = $this->input->post("netto");

			if (!empty($penimbang_id)) {
				$penimbang_id = implode(",", $penimbang_id);
			} else {
				$penimbang_id = NULL;
			}

			if($shift == "NS"){
				$cek_jam_start = date("H", strtotime($jam_mulai));
				if((int)$cek_jam_start >= 0 && (int)$cek_jam_start <= 6 ){
					$jam_mulai =  date("Y-m-d H:i:s", strtotime($tanggal." ".$jam_mulai. "+1 days"));
				}else{
					$jam_mulai = date("Y-m-d H:i:s", strtotime($tanggal." ".$jam_mulai));
				}

				$cek_jam_stop = date("H", strtotime($jam_akhir));
				if((int)$cek_jam_stop >= 0 && (int)$cek_jam_stop <= 6 ){
					$jam_akhir =  date("Y-m-d H:i:s", strtotime($tanggal." ".$jam_akhir. "+1 days"));
				}else{
					$jam_akhir = date("Y-m-d H:i:s", strtotime($tanggal." ".$jam_akhir));
				}
			}else{
				$jam_mulai 	= date("Y-m-d H:i:s", strtotime($tanggal." ".$jam_mulai));
				$jam_akhir 	= date("Y-m-d H:i:s", strtotime($tanggal." ".$jam_akhir));
			}

			$data = array(
				'no_tiket' => $no_tiket,
				'tanggal' => $tanggal,
				'jam_mulai' => $jam_mulai,
				'jam_akhir' => $jam_akhir,
				'shift' => $shift,
				'aktivitas' => $aktivitas,

				'location_id' => $location_id,
				'pit_id' => $pit_id,
				'seam_id' => $seam_id,
				'blok_id' => $blok_id,
				'dumping_id' => $dumping_id,

				'loading_unit_id' => $loading_unit_id,
				'loader_id' => $loader_id,
				'hauling_unit_id' => $hauling_unit_id,
				'hauler_id' => $hauler_id,
				'penimbang' => $penimbang_id,

				'material_id' => $material_id,
				'distance' => $distance,
				'gross' => $gross,
				'tare' => $tare,
				'netto' => $netto,
				'updated_by' => $this->data['users']->id,
			);

			$update = $this->coal_actual_model->update($data, ['id' => $id]);
			if ($update) {
				$this->session->set_flashdata('message', "Data Coal Aktual Berhasil Diubah");
				redirect("coal_actual");
			} else {
				$this->session->set_flashdata('message_error', "Data Coal Aktual Gagal Diubah");
				redirect("coal_actual");
			}
		} else {
			$this->load->helper('url');
			if ($this->data['is_can_edit']) {
				$coal_actual = $this->coal_actual_model->getOneBy(['coal_actual.id' => $id]);
				if (!empty($coal_actual)) {
					$this->data['coal_actual'] = $coal_actual;
					$this->data['penimbang'] = explode(",", $coal_actual->penimbang);

					if (empty($coal_actual->location_id)) {
						$location_id = $this->user_mutation_model->getLastLocation($this->data['users']->id);
					} else {
						$location_id = $coal_actual->location_id;
					}

					$where_unit = [
						'unit_transfer.to_location' => $location_id,
					];
					$this->data['loading_unit'] = $this->unit_model->getAllByLocation($where_unit);

					$where_unit['unit.operasi_sebagai'] = 1;
					$this->data['hauling_unit'] = $this->unit_model->getAllByLocation($where_unit);
					$where_disposal = [
						"disposal.is_deleted" => 0,
						"disposal.production" => 2,
						"disposal.location_id" => $location_id,
					];
					$this->data['dumpings'] = $this->disposal_model->getAllById($where_disposal);

					$where_user = [
						'user_mutation.to_location' => $location_id,
					];
					$this->data['user_location'] = $this->user_mutation_model->getUserByLocation($where_user);

					$this->data['material'] = $this->material_model->getAllById([]);
					$user_id = $this->data['users']->user_id;

					$where_location = [
						"location.id" => $location_id,
						"location.is_deleted" => 0,
					];
					$this->data['location'] = $this->location_model->getOneBy($where_location);

					$where_disposal = [
						"disposal.is_deleted" => 0,
						"disposal.production" => 2,
						"disposal.location_id" => $location_id,
					];
					$this->data['dumpings'] = $this->disposal_model->getAllById($where_disposal);

					$this->data['content'] = 'admin/coal_actual/edit_v';
				} else {
					$this->session->set_flashdata('message_error', "Data Coal Aktual Tidak Tersedia");
					redirect("coal_actual");
				}
			} else {
				$this->data['content'] = 'errors/html/restrict';
			}

			$this->load->view('admin/layouts/page', $this->data);
		}

	}

	public function dataList() {

		$columns = array(
			0 => 'tanggal',
			1 => 'jam_mulai',
			2 => 'shift',
			3 => 'aktivitas',
			4 => 'unit.kode',
			5 => 'hauling.kode',
			6 => 'location.name',
			7 => 'seam.name',
			8 => 'disposal.name',
			9 => 'gross',
			10 => 'netto',
			11 => '',
		);
		$where = array();
		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];
		$search = array();
		$searchColumn = $this->input->post('columns');
		$limit = 0;
		$start = 0;

		$totalData = $this->coal_actual_model->getCountAllBy($limit, $start, $search, $order, $dir, $where);
		$filtered = false;

		if (!empty($searchColumn[0]['search']['value'])) {
			$value = $searchColumn[0]['search']['value'];
			$where['coal_actual.tanggal'] = $value;
			$totalData = $this->coal_actual_model->getCountAllBy($limit, $start, $search, $order, $dir, $where);
			$filtered = true;
		}

		if (!empty($this->input->post('search')['value'])) {
			$search_value = $this->input->post('search')['value'];
			$search = array(
				"coal_actual.tanggal" => $search_value,
				"coal_actual.jam_mulai" => $search_value,
				"coal_actual.jam_akhir" => $search_value,
				"coal_actual.shift" => $search_value,
				"hauling.kode" => $search_value,
				"unit.kode" => $search_value,
				"location.name" => $search_value,
				"disposal.name" => $search_value,
				"coal_actual.gross" => $search_value,
				"coal_actual.tare" => $search_value,
				"coal_actual.netto" => $search_value,
			);
			if (strtolower($search_value) == "coal hauling") {
				$search["aktivitas"] = 1;
			} elseif (strtolower($search_value) == "coal getting") {
				$search["aktivitas"] = 2;
			}
			$totalFiltered = $this->coal_actual_model->getCountAllBy($limit, $start, $search, $order, $dir, $where);
		} else {
			$totalFiltered = $totalData;
		}

		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$datas = $this->coal_actual_model->getAllBy($limit, $start, $search, $order, $dir, $where);
		$new_data = array();
		if (!empty($datas)) {

			foreach ($datas as $key => $data) {

				$edit_url = "";
				$delete_url = "";

				if ($this->data['is_can_edit'] && $data->is_deleted == 0) {
					$edit_url = "<a href='" . base_url() . "coal_actual/edit/" . $data->id . "' class='btn btn-sm btn-info white'>Ubah</a>";
				}

				if ($this->data['is_can_delete']) {
					if ($data->is_deleted == 0) {
						$delete_url = "<a href='#'
	        				url='" . base_url() . "coal_actual/destroy/" . $data->id . "/" . $data->is_deleted . "'
	        				class='btn btn-sm btn-danger white delete' > Non Aktifkan
	        				</a>";
					} else {
						$delete_url = "<a href='#'
	        				url='" . base_url() . "coal_actual/destroy/" . $data->id . "/" . $data->is_deleted . "'
	        				class='btn btn-sm btn-danger white delete'> Aktifkan
	        				</a>";
					}
				}

				$aktivitas = "";
				if ($data->aktivitas == 1) {
					$aktivitas = "Coal Hauling";
				} elseif ($data->aktivitas == 2) {
					$aktivitas = "Coal Getting";
				}
				$nestedData['tanggal'] = $data->tanggal;
				$nestedData['jam'] = $data->jam_mulai . " - " . $data->jam_akhir;
				$nestedData['shift'] = $data->shift;
				$nestedData['aktivitas'] = $aktivitas;
				$nestedData['loading_unit_name'] = $data->loading_unit_name . ' - ' . $data->unit_brand_name . ' - ' . $data->unit_model_name;
				$nestedData['hauling_unit_name'] = $data->hauling_unit_name . ' - ' . $data->hauling_brand_name . ' - ' . $data->hauling_model_name;
				$nestedData['location_name'] = $data->location_name;
				$nestedData['seam_name'] = $data->seam_name;
				$nestedData['disposal_name'] = $data->disposal_name;
				$nestedData['gross'] = $data->gross;
				$nestedData['netto'] = $data->netto;
				$nestedData['action'] = $edit_url . " " . $delete_url;
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

	public function destroy() {
		$response_data = array();
		$response_data['status'] = false;
		$response_data['msg'] = "";
		$response_data['data'] = array();

		$id = $this->uri->segment(3);
		$is_deleted = $this->uri->segment(4);
		if (!empty($id)) {
			$data = array(
				'is_deleted' => ($is_deleted == 1) ? 0 : 1,
			);
			$update = $this->coal_actual_model->update($data, array("id" => $id));

			$response_data['data'] = $data;
			$response_data['msg'] = "Coal Actual Berhasil di Hapus";
			$response_data['status'] = true;
		} else {
			$response_data['msg'] = "ID Harus Diisi";
		}

		echo json_encode($response_data);
	}

	public function get_data() {
		$jam = $this->input->post('jam');
		$tanggal = $this->input->post('tanggal');

		$return_data = array(
			"status" => false,
			"message" => "",
			"data" => array(),
		);

		$data = $this->coal_actual_model->getAllByDateTime(array("coal_actual.jam" => $jam, "coal_actual.tanggal" => $tanggal));

		if ($data) {
			$return_data['data'] = $data;
			$return_data['status'] = true;
			$return_data['message'] = "Berhasil mengambil data!";
		} else {
			$return_data['status'] = false;
			$return_data['message'] = "Gagal mengambil data!";
		}

		echo json_encode($return_data);
	}

	public function getPit() {
		$id = $this->input->post("id");
		$pit = $this->pit_model->getAllById(['pit.location_id' => $id]);

		if (!empty($pit)) {
			$response_data['status'] = true;
			$response_data['data'] = $pit;
			$response_data['message'] = 'Berhasil Mengambil Data';
		} else {
			$response_data['status'] = false;
			$response_data['data'] = [];
			$response_data['message'] = 'Gagal Mengambil Data';
		}

		echo json_encode($response_data);
	}

	public function getSeam() {
		$id = $this->input->post("id");
		$seam = $this->seam_model->getAllById(['seam.pit_id' => $id]);

		if (!empty($seam)) {
			$response_data['status'] = true;
			$response_data['data'] = $seam;
			$response_data['message'] = 'Berhasil Mengambil Data';
		} else {
			$response_data['status'] = false;
			$response_data['data'] = [];
			$response_data['message'] = 'Gagal Mengambil Data';
		}

		echo json_encode($response_data);
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
}
