<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'core/Admin_Controller.php';
class Unit extends Admin_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('unit_model');
		$this->load->model('unit_category_model');
		$this->load->model('unit_brand_model');
		$this->load->model('unit_model_model');
	}

	public function index() {

		$this->load->helper('url');
		if ($this->data['is_can_read']) {
			$this->data['content'] = 'admin/unit/list_v';
		} else {
			$this->data['content'] = 'errors/html/restrict';
		}
		$this->load->view('admin/layouts/page', $this->data);
	}

	public function create() {
		$this->form_validation->set_rules('kode', "Kode Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('brand_id', "Brand Harus Dipilih", 'trim|required');
		$this->form_validation->set_rules('unit_category_id', "Kategori Unit Harus Dipilih", 'trim|required');
		$this->form_validation->set_rules('unit_model_id', "Model Unit Harus Dipilih", 'trim|required');
		$this->form_validation->set_rules('operasi_sebagai', "Operasi Sebagai Harus Dipilih", 'trim|required');
		$this->form_validation->set_rules('kepemilikan', "Kepemilikan Unit Harus Dipilih", 'trim|required');

		if ($this->form_validation->run() === TRUE) {
			$data = array(
				'kode' => $this->input->post('kode'),
				'brand_id' => $this->input->post('brand_id'),
				'unit_category_id' => $this->input->post('unit_category_id'),
				'unit_model_id' => $this->input->post('unit_model_id'),
				'tahun_perakitan' => $this->input->post('tahun_perakitan'),
				'engine_serial_number' => $this->input->post('engine_serial_number'),
				'serial_number' => $this->input->post('serial_number'),
				'operasi_sebagai' => $this->input->post('operasi_sebagai'),
				'kepemilikan' => $this->input->post('kepemilikan'),
				'description' => " ",
			);

			$unit_id = $this->unit_model->insert($data);

			if ($unit_id) {
				$this->session->set_flashdata('message', "Unit Baru Berhasil Disimpan");
				redirect("unit");
			} else {
				$this->session->set_flashdata('message_error', "Unit Baru Gagal Disimpan");
				redirect("unit");
			}
		} else {
			$this->data['content'] = 'admin/unit/create_v';
			$this->data['unit_category'] = $this->unit_category_model->getAllById();
			$this->data['brands'] = $this->unit_brand_model->getAllById();
			$this->data['unit_model'] = $this->unit_model_model->getAllById();
			$this->load->view('admin/layouts/page', $this->data);
		}
	}

	public function edit($id) {
		$this->form_validation->set_rules('kode', "Kode Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('brand_id', "Brand Harus Dipilih", 'trim|required');
		$this->form_validation->set_rules('unit_category_id', "Kategori Unit Harus Dipilih", 'trim|required');
		$this->form_validation->set_rules('unit_model_id', "Model Unit Harus Dipilih", 'trim|required');
		$this->form_validation->set_rules('operasi_sebagai', "Operasi Sebagai Harus Dipilih", 'trim|required');
		$this->form_validation->set_rules('kepemilikan', "Kepemilikan Unit Harus Dipilih", 'trim|required');

		if ($this->form_validation->run() === TRUE) {
			$data = array(
				'kode' => $this->input->post('kode'),
				'brand_id' => $this->input->post('brand_id'),
				'unit_category_id' => $this->input->post('unit_category_id'),
				'unit_model_id' => $this->input->post('unit_model_id'),
				'tahun_perakitan' => $this->input->post('tahun_perakitan'),
				'engine_serial_number' => $this->input->post('engine_serial_number'),
				'serial_number' => $this->input->post('serial_number'),
				'operasi_sebagai' => $this->input->post('operasi_sebagai'),
				'kepemilikan' => $this->input->post('kepemilikan'),
				'description' => " ",
			);
			$update = $this->unit_model->update($data, array("unit.id" => $id));

			if ($update) {
				$this->session->set_flashdata('message', "Unit Berhasil Diubah");
				redirect("unit", "refresh");
			} else {
				$this->session->set_flashdata('message_error', "Unit Gagal Diubah");
				redirect("unit", "refresh");
			}
		} else {
			if (!empty($_POST)) {
				$id = $this->input->post('id');
				$this->session->set_flashdata('message_error', validation_errors());
				return redirect("unit/edit/" . $id);
			} else {
				$this->data['id'] = $this->uri->segment(3);
				$unit = $this->unit_model->getAllById(array("unit.id" => $this->data['id']));
				$this->data['brands'] = $this->unit_brand_model->getAllById();
				$this->data['kode'] = (!empty($unit)) ? $unit[0]->kode : "";
				$this->data['unit_model_id'] = (!empty($unit)) ? $unit[0]->unit_model_id : "";
				$this->data['kepemilikan'] = (!empty($unit)) ? $unit[0]->kepemilikan : "";
				$this->data['unit_category_id'] = (!empty($unit)) ? $unit[0]->unit_category_id : "";
				$this->data['operasi_sebagai'] = (!empty($unit)) ? $unit[0]->operasi_sebagai : "";
				$this->data['tahun_perakitan'] = (!empty($unit)) ? $unit[0]->tahun_perakitan : "";
				$this->data['engine_serial_number'] = (!empty($unit)) ? $unit[0]->engine_serial_number : "";
				$this->data['serial_number'] = (!empty($unit)) ? $unit[0]->serial_number : "";
				$this->data['brand_id'] = (!empty($unit)) ? $unit[0]->brand_id : "";
				$this->data['description'] = (!empty($unit)) ? $unit[0]->description : "";
				$this->data['content'] = 'admin/unit/edit_v';
				$this->load->view('admin/layouts/page', $this->data);
			}
		}

	}

	public function dataList() {

		$columns = array(
			0 => 'kode',
			1 => 'unit_category_id',
			2 => 'brand_id',
			3 => 'unit_model_id',
			4 => 'kepemilikan',
			5 => 'operasi_sebagai',
			6 => '',
		);

		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];
		$search = array();
		$where = array();
		$limit = 0;
		$start = 0;
		$totalData = $this->unit_model->getCountAllBy($limit, $start, $search, $order, $dir, $where);

		if (!empty($this->input->post('search')['value'])) {
			$search_value = $this->input->post('search')['value'];
			$search = array(
				"unit.kode" => $search_value,
				"unit_brand.name" => $search_value,
				"unit_category.name" => $search_value,
				"unit_model.name" => $search_value,
				"unit.operasi_sebagai" => $search_value,
			);
			if (strtolower($search_value) == "bmr") {
				$search["kepemilikan"] = 1;
			} elseif (strtolower($search_value) == "eksternal") {
				$search["kepemilikan"] = 2;
			}

			$totalFiltered = $this->unit_model->getCountAllBy($limit, $start, $search, $order, $dir, $where);
		} else {
			$totalFiltered = $totalData;
		}

		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$datas = $this->unit_model->getAllBy($limit, $start, $search, $order, $dir, $where);

		$new_data = array();
		if (!empty($datas)) {

			foreach ($datas as $key => $data) {

				$edit_url = "";
				$delete_url = "";

				if ($this->data['is_can_edit'] && $data->is_deleted == 0) {
					$edit_url = "<a href='" . base_url() . "unit/edit/" . $data->id . "' class='btn btn-sm btn-info white'><i class='fa fa-pencil'></i> Ubah</a>";
				}
				if ($this->data['is_can_delete']) {
					$delete_url = "<a href='#'
						url='" . base_url() . "unit/destroy/" . $data->id . "/" . $data->is_deleted . "'
						class='btn btn-sm btn-danger white delete'> Hapus
						</a>";
				}

				if ($data->operasi_sebagai == 0) {
					$status_operasional = "Loading Unit";
				} else if ($data->operasi_sebagai == 1) {
					$status_operasional = "Hauling Unit";
				} else if ($data->operasi_sebagai == 2) {
					$status_operasional = "Supporting Unit";
				}

				$kepemilikan = "";
				if ($data->kepemilikan == 1) {
					$kepemilikan = " BMR";
				} elseif ($data->kepemilikan == 2) {
					$kepemilikan = " Eksternal";
				}

				$nestedData['id'] = $start + $key + 1;
				$nestedData['kode'] = $data->kode;
				$nestedData['category_name'] = $data->category_name;
				$nestedData['kepemilikan'] = $kepemilikan;
				$nestedData['brand_name'] = $data->brand_name;
				$nestedData['operasi_sebagai'] = $status_operasional;
				$nestedData['unit_model_name'] = $data->unit_model_name;
				$nestedData['description'] = substr(strip_tags($data->description), 0, 50);
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
			$this->load->model("unit_model");
			$data = array(
				'is_deleted' => ($is_deleted == 1) ? 0 : 1,
			);
			$update = $this->unit_model->update($data, array("id" => $id));

			$response_data['data'] = $data;
			$response_data['msg'] = "Unit Berhasil di Hapus";
			$response_data['status'] = true;
		} else {
			$response_data['msg'] = "ID Harus Diisi";
		}

		echo json_encode($response_data);
	}

}
