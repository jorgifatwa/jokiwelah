<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'core/Admin_Controller.php';
class Ob_actual extends Admin_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('ob_actual_model');
		$this->load->model('user_mutation_model');
		$this->load->model('unit_model');
		$this->load->model('location_model');
		$this->load->model('pit_model');
		$this->load->model('material_model');
		$this->load->model('service_model');
		$this->load->model('seam_model');
		$this->load->model('blok_model');
		$this->load->model('disposal_model');
	}

	public function index() {

		$this->load->helper('url');
		if ($this->data['is_can_read']) {
			$this->data['content'] = 'admin/ob_actual/list_v';
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
				'type' => 'OB',
			);

			if ($this->ob_actual_model->insert_production($data)) {
				$this->session->set_flashdata('message', "Production JS Baru Berhasil Disimpan");
				echo json_encode($data);
			} else {
				$this->session->set_flashdata('message_error', "Production JS Baru Gagal Disimpan");
				redirect("actual");
			}
		}
	}

	public function create() {
		$this->form_validation->set_rules('tanggal', "Tanggal Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('shift', "Shift Harus Dipilih", 'trim|required');
		$this->form_validation->set_rules('jam', "Jam Harus Dipilih", 'trim|required');
		$this->form_validation->set_rules('loading_unit_id', "Loading Unit Harus Dipilih", 'trim|required');
		$this->form_validation->set_rules('loader_id', "Loader Harus Dipilih", 'trim|required');
		$this->form_validation->set_rules('hauling_unit_id', "Hauling Unit Harus Dipilih", 'trim|required');
		$this->form_validation->set_rules('hauler_id', "Hauler Harus Dipilih", 'trim|required');
		$this->form_validation->set_rules('material_id', "Material Harus Dipilih", 'trim|required');
		$this->form_validation->set_rules('disposal_id', "Disposal Harus Dipilih", 'trim|required');
		$this->form_validation->set_rules('supervisor_id', "Supervisor Harus Dipilih", 'trim|required');
		$this->form_validation->set_rules('distance', "Distance Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('pit_id', "Pit Harus Dipilih", 'trim|required');
		$this->form_validation->set_rules('seam_id', "Seam Harus Dipilih", 'trim|required');
		$this->form_validation->set_rules('blok_id', "Blok Harus Dipilih", 'trim|required');
		$this->form_validation->set_rules('location_id', "Location Harus Dipilih", 'trim|required');
		$this->form_validation->set_rules('total_ritase', "Total Ritase Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('capacity', "Capacity Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('total_production', "Total Production Harus Diisi", 'trim|required');

		if ($this->form_validation->run() === TRUE) {
			$tanggal = date("Y-m-d", strtotime($this->input->post('tanggal')));
			$data = array(
				'tanggal' => $tanggal,
				'jam' => $this->input->post('jam'),
				'shift' => $this->input->post('shift'),
				'loading_unit_id' => $this->input->post('loading_unit_id'),
				'loader_id' => $this->input->post('loader_id'),
				'hauling_unit_id' => $this->input->post('hauling_unit_id'),
				'hauler_id' => $this->input->post('hauler_id'),
				'material_id' => $this->input->post('material_id'),
				'material2_id' => $this->input->post('material2_id'),
				'disposal_id' => $this->input->post('disposal_id'),
				'supervisor_id' => $this->input->post('supervisor_id'),
				'distance' => $this->input->post('distance'),
				'pit_id' => $this->input->post('pit_id'),
				'seam_id' => $this->input->post('seam_id'),
				'blok_id' => $this->input->post('blok_id'),
				'location_id' => $this->input->post('location_id'),
				'total_ritase' => $this->input->post('total_ritase'),
				'capacity' => $this->input->post('capacity'),
				'total_production' => $this->input->post('total_production'),
			);
			$id = $this->input->post('id');
			if (!empty($id)) {
				$action = $this->ob_actual_model->update($data, array("ob_actual.id" => $id));
			} else {
				$action = $this->ob_actual_model->insert($data);
			}

			if ($action) {
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
			$this->load->helper('url');
			if ($this->data['is_can_read']) {
				$this->data['content'] = 'admin/ob_actual/create_v';
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
			$disposal = $this->disposal_model->getAllById($where_disposal);
			if (!empty($disposal)) {
				$this->data['disposal'] = $disposal;
			} else {
				$this->data['disposal'] = [];
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

	public function dataList() {

		$columns = array(
			0 => 'date',
			1 => 'jam',
			2 => 'shift',
			3 => 'loading_unit_name',
			4 => 'hauling_unit_name',
			5 => 'loader_name',
			6 => 'supervisor_name',
			7 => 'total_ritase',
			8 => 'capacity',
			9 => 'total_production',
			10 => '',
		);

		$valid = true;
		$searchColumn = $this->input->post('columns');
		$new_data = array();
		$totalData = 0;
		$totalFiltered = 0;

		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];
		$search = array();
		$where = array();
		$limit = 0;
		$start = 0;
		$totalData = $this->ob_actual_model->getCountAllBy($limit, $start, $search, $order, $dir, $where);
		$filtered = false;
		if (!empty($searchColumn[0]['search']['value'])) {
			$value = $searchColumn[0]['search']['value'];
			$where['ob_actual.tanggal'] = $value;
			$filtered = true;
		}

		if (!empty($searchColumn[1]['search']['value'])) {
			$value = $searchColumn[1]['search']['value'];
			$where['ob_actual.tanggal'] = date('Y-m-d', strtotime($value));
			$filtered = true;
		}

		if (!empty($searchColumn[2]['search']['value'])) {
			$value = $searchColumn[2]['search']['value'];
			$where['ob_actual.jam'] = $value;
			$filtered = true;
		}

		if (!empty($this->input->post('search')['value'])) {
			$search_value = $this->input->post('search')['value'];
			$search = array(
				"ob_actual.tanggal" => $search_value,
				"ob_actual.shift" => $search_value,
				"unit.kode" => $search_value,
				"hauling.kode" => $search_value,
				"ob_actual.total_ritase" => $search_value,
				"ob_actual.capacity" => $search_value,
				"ob_actual.total_production" => $search_value,
			);
			$filtered = true;
		}

		if ($filtered) {
			$totalFiltered = $this->ob_actual_model->getCountAllBy($limit, $start, $search, $order, $dir, $where);
		} else {
			$totalFiltered = $totalData;
		}

		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$datas = $this->ob_actual_model->getAllBy($limit, $start, $search, $order, $dir, $where);

		if (!empty($datas)) {

			foreach ($datas as $key => $data) {

				$edit_url = "";
				$delete_url = "";

				if ($this->data['is_can_edit'] && $data->is_deleted == 0) {
					$edit_url = "<button type='button' class='btn btn-sm btn-info white' id='btn-edit' data-actual='" . $data->id . "'><i class='fa fa-pencil'></i> Ubah</button>";
				}
				if ($this->data['is_can_delete']) {
					$delete_url = "<a href='#'
						url='" . base_url() . "ob_actual/destroy/" . $data->id . "/" . $data->is_deleted . "'
						class='btn btn-sm btn-danger white delete'><span class='fa fa-trash'></span> Hapus
						</a>";
				}

				$nestedData['tanggal'] = $data->tanggal;
				$nestedData['jam'] = $data->jam;
				$nestedData['shift'] = $data->shift;
				$nestedData['loading_unit_name'] = $data->loading_unit_name;
				$nestedData['hauling_unit_name'] = $data->hauling_unit_name;
				$nestedData['loader_name'] = $data->loader_name;
				$nestedData['supervisor_name'] = $data->supervisor_name;
				$nestedData['total_ritase'] = $data->total_ritase;
				$nestedData['capacity'] = $data->capacity;
				$nestedData['total_production'] = $data->total_production;
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

	public function get_data() {
		$id_actual = $this->input->post('id_actual');

		$return_data = array(
			"status" => false,
			"message" => "",
			"data" => array(),
		);

		$data = $this->ob_actual_model->getAllByDateTime(array("ob_actual.id" => $id_actual));

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

	public function get_kapasitas() {
		$id = $this->input->post('id');

		$return_data = array(
			"status" => false,
			"message" => "",
			"data" => array(),
		);

		$data = $this->material_model->getOneBy(array('material.id' => $id));

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

	public function destroy() {
		$response_data = array();
		$response_data['status'] = false;
		$response_data['msg'] = "";
		$response_data['data'] = array();

		$id = $this->uri->segment(3);
		$is_deleted = $this->uri->segment(4);
		if (!empty($id)) {
			$this->load->model("ob_actual_model");
			$data = array(
				'is_deleted' => ($is_deleted == 1) ? 0 : 1,
			);
			$update = $this->ob_actual_model->update($data, array("id" => $id));

			$response_data['data'] = $data;
			$response_data['status'] = true;
		} else {
			$response_data['msg'] = "ID Harus Diisi";
		}

		echo json_encode($response_data);
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
