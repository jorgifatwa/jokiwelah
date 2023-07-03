<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'core/Admin_Controller.php';
class Situasi_air_plan extends Admin_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('situasi_air_plan_model');
		$this->load->model('location_model');
		$this->load->model('user_mutation_model');
	}

	public function index() {

		$this->load->helper('url');
		if ($this->data['is_can_read']) {
			$where_location = [
				"location.id !=" => 1,
				"location.is_deleted" => 0,
			];
			$location_id = $this->user_mutation_model->getLastLocation($this->data['users']->id);
			if (!empty($location_id)) {
				$where_location["location.id"] = $location_id;
			}
			$this->data['locations'] = $this->location_model->getAllById($where_location);

			$this->data['bulan'] = getBulan();

			$this->data['content'] = 'admin/situasi_air_plan/list_v';
		} else {
			$this->data['content'] = 'errors/html/restrict';
		}
		$this->load->view('admin/layouts/page', $this->data);
	}

	public function create() {
		if ($this->data['is_can_read']) {
			$this->data['bulan'] = getBulan();

			$where_location = [
				"location.id !=" => 1,
				"location.is_deleted" => 0,
			];
			$location_id = $this->user_mutation_model->getLastLocation($this->data['users']->id);
			if (!empty($location_id)) {
				$where_location["location.id"] = $location_id;
			}
			$this->data['locations'] = $this->location_model->getAllById($where_location);

			$this->data['content'] = 'admin/situasi_air_plan/create_v';
		} else {
			$this->data['content'] = 'errors/html/restrict';
		}
		$this->load->view('admin/layouts/page', $this->data);
	}

	public function dataList() {
		$bulan = $this->input->post('bulan');
		$tahun = $this->input->post('tahun');
		$searching = $this->input->post('searching');

		$where = [
			"YEAR(situasi_air_plan.tanggal)" => $tahun,
			"MONTH(situasi_air_plan.tanggal)" => $bulan,
			"location.is_deleted" => 0,
			"location.id != " => 1,
		];

		$plan = $this->situasi_air_plan_model->getAllGroupBy($where);
		$arr_data = [];
		$arr_total_plan = [];
		if (!empty($plan)) {
			foreach ($plan as $data) {
				$arr_data[$data->id][$data->tanggal] = $data->total;
				if (!empty($arr_total_plan[$data->tanggal])) {
					$arr_total_plan[$data->tanggal] += $data->total;
				} else {
					$arr_total_plan[$data->tanggal] = $data->total;
				}
			}
		}

		$akhir_bulan = date("t", strtotime($tahun . "-" . $bulan));
		$datas = [];
		$where_location = [
			'location.is_deleted' => 0,
			'location.id != ' => 1,
		];

		$location = $this->location_model->getAllById($where_location);
		if (!empty($location)) {
			foreach ($location as $value) {
				$x = new stdClass();
				$x->name = $value->name;
				$x->total = 0;
				$x->data_date = [];
				for ($i = 1; $i <= $akhir_bulan; $i++) {
					if (!empty($arr_data[$value->id][$i])) {
						$x->data_date[] = number_format((float) $arr_data[$value->id][$i], 2, '.', ',');
						$x->total += $arr_data[$value->id][$i];
					} else {
						$x->data_date[] = 0;
					}
				}
				$x->total = number_format((float) $x->total / $akhir_bulan, 2, '.', ',');

				array_push($datas, $x);
			}
		}

		$return_data = array(
			"status" => false,
			"message" => "",
			"data" => array(),
		);

		if ($datas) {
			$return_data['data'] = $datas;
			$return_data['akhir_bulan'] = $akhir_bulan;
			$return_data['status'] = true;
			$return_data['message'] = "Berhasil mengambil data!";
		} else {
			$return_data['message'] = "Gagal mengambil data!";
		}

		echo json_encode($return_data);
	}

	public function input_data() {
		if ($this->data['is_can_read']) {
			$this->form_validation->set_rules('nilai', "Nilai Elevasi Harus Diisi", 'trim|required');
			$this->form_validation->set_rules('tahun', "Tahun Harus Diisi", 'trim|required');
			$this->form_validation->set_rules('bulan', "Bulan Harus Diisi", 'trim|required');
			$this->form_validation->set_rules('location_id', "Lokasi Harus Diisi", 'trim|required');

			if ($this->form_validation->run() === TRUE) {
				$this->db->trans_begin();

				$nilai = $this->input->post('nilai');
				$tahun = $this->input->post('tahun');
				$bulan = $this->input->post('bulan');
				$location_id = $this->input->post('location_id');

				//delete data lama
				$where = [
					"YEAR(situasi_air_plan.tanggal) = " => $tahun,
					"MONTH(situasi_air_plan.tanggal) = " => sprintf('%02d', $bulan),
					"situasi_air_plan.location_id" => $location_id,
				];
				$delete = $this->situasi_air_plan_model->delete($where);

				//make batch data
				$data_batch = [];
				$max_date = date("t", strtotime($tahun . "-" . $bulan . "-01"));
				for ($i = 1; $i <= $max_date; $i++) {
					$data_batch[] = [
						"nilai" => number_format((float) $nilai, 2, '.', ','),
						"tanggal" => date("Y-m-d", strtotime($tahun . "-" . $bulan . "-" . $i)),
						"location_id" => $location_id,
						"created_at" => date("Y-m-d H:i:s"),
						"is_deleted" => 0,
					];
				}
				if (!empty($data_batch)) {
					$this->situasi_air_plan_model->insert_batch($data_batch);
				}
				$tanggal = date("Y-m-d", strtotime($tahun . "-" . $bulan . "-01"));
				if ($this->db->trans_status() === FALSE) {
					$this->db->trans_rollback();

					$return_data = [
						"status" => false,
						"message" => "Gagal Menambahkan Data Plan",
						"tanggal" => $tanggal,
						"data" => array(),
					];
				} else {
					$this->db->trans_commit();

					$return_data = [
						"status" => true,
						"message" => "Berhasil Menambahkan Data Plan",
						"tanggal" => $tanggal,
						"data" => array(),
					];
				}
			} else {
				$return_data = [
					"status" => false,
					"message" => "Harap Isi Data Dengan Benar",
					"data" => array(),
				];
			}
		} else {
			$return_data = [
				"status" => false,
				"message" => "Anda Tidak Memiliki Akses",
				"data" => array(),
			];
		}
		echo json_encode($return_data);
	}

	public function edit_data() {
		if ($this->data['is_can_edit']) {
			$this->form_validation->set_rules('nilai', "Nilai Elevasi Harus Diisi", 'trim|required');
			$this->form_validation->set_rules('tanggal', "Tanggal Harus Diisi", 'trim|required');
			$this->form_validation->set_rules('location_id', "Lokasi Harus Diisi", 'trim|required');

			if ($this->form_validation->run() === TRUE) {
				$this->db->trans_begin();

				$nilai = $this->input->post('nilai');
				$tanggal = $this->input->post('tanggal');
				$location_id = $this->input->post('location_id');

				//delete data lama
				$where = [
					"situasi_air_plan.tanggal" => date("Y-m-d", strtotime($tanggal)),
					"situasi_air_plan.location_id" => $location_id,
				];
				$delete = $this->situasi_air_plan_model->delete($where);

				//insert data
				$data = [
					"nilai" => number_format((float) $nilai, 2, '.', ','),
					"tanggal" => date("Y-m-d", strtotime($tanggal)),
					"location_id" => $location_id,
					"created_at" => date("Y-m-d H:i:s"),
					"is_deleted" => 0,
				];

				$this->situasi_air_plan_model->insert($data);

				$tanggal = date("Y-m-d", strtotime($tanggal));

				if ($this->db->trans_status() === FALSE) {
					$this->db->trans_rollback();

					$return_data = [
						"status" => false,
						"message" => "Gagal Menambahkan Data Plan",
						"tanggal" => $tanggal,
						"data" => array(),
					];
				} else {
					$this->db->trans_commit();

					$return_data = [
						"status" => true,
						"message" => "Berhasil Menambahkan Data Plan",
						"tanggal" => $tanggal,
						"data" => array(),
					];
				}
			} else {
				$return_data = [
					"status" => false,
					"message" => "Harap Isi Data Dengan Benar",
					"data" => array(),
				];
			}
		} else {
			$return_data = [
				"status" => false,
				"message" => "Anda Tidak Memiliki Akses",
				"data" => array(),
			];
		}
		echo json_encode($return_data);
	}

	public function get_data() {
		$tahun = $this->input->post('tahun');
		$bulan = $this->input->post('bulan');
		$location_id = $this->input->post('location_id');
		$tanggal = date("Y-m-d", strtotime($tahun . "-" . $bulan . "-01"));
		$return_data = array(
			"status" => false,
			"message" => "",
			"tanggal" => $tanggal,
			"data" => array(),
		);
		$where = [
			"YEAR(situasi_air_plan.tanggal) = " => $tahun,
			"MONTH(situasi_air_plan.tanggal) = " => sprintf('%02d', $bulan),
			"situasi_air_plan.location_id" => $location_id,
		];
		$data = $this->situasi_air_plan_model->getAllById($where);

		$result_data = [];
		if (!empty($data)) {
			foreach ($data as $key => $value) {
				$x = new stdClass();
				$x->title = number_format((float) $value->nilai, 2, '.', ',');
				$x->start = $value->tanggal;
				$x->borderColor = '#007BFF';
				$x->backgroundColor = '#007BFF';

				array_push($result_data, $x);
			}
		}

		if ($data) {
			$return_data['data'] = $result_data;
			$return_data['status'] = true;
			$return_data['message'] = "Berhasil mengambil data!";
		} else {
			$return_data['message'] = "Gagal mengambil data!";
		}

		echo json_encode($return_data);
	}

	public function cek_data() {
		$tanggal = date("Y-m-d", strtotime($this->input->post('tanggal')));
		$location_id = $this->input->post('location_id');

		$return_data = array(
			"status" => false,
			"message" => "",
			"data" => array(),
		);
		$where = [
			"situasi_air_plan.tanggal" => $tanggal,
			"situasi_air_plan.location_id" => $location_id,
		];

		$data = $this->situasi_air_plan_model->getOneBy($where);

		if ($data) {
			$return_data['data'] = $data;
			$return_data['status'] = true;
			$return_data['message'] = "Berhasil mengambil data!";
		} else {
			$return_data['message'] = "Gagal mengambil data!";
		}

		echo json_encode($return_data);
	}

}
