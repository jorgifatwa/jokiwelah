<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'core/Admin_Controller.php';
class Unit_model extends Admin_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('unit_model_model');
		$this->load->model('unit_brand_model');
		$this->load->model('unit_category_model');
	}

	public function index() {

		$this->load->helper('url');
		if ($this->data['is_can_read']) {
			$this->data['content'] = 'admin/unit_model/list_v';
		} else {
			$this->data['content'] = 'errors/html/restrict';
		}

		$this->load->view('admin/layouts/page', $this->data);
	}

	public function create() {
		$this->form_validation->set_rules('name', "Nama Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('brand_id', "Unit Brand Harus Dipilih", 'trim|required');
		$this->form_validation->set_rules('unit_category_id', "Unit Kategori Harus Dipilih", 'trim|required');

		if ($this->form_validation->run() === TRUE) {
			$data = array(
				'name' => $this->input->post('name'),
				'brand_id' => $this->input->post('brand_id'),
				'unit_category_id' => $this->input->post('unit_category_id'),
				'description' => "",
			);
			if ($this->unit_model_model->insert($data)) {
				$this->session->set_flashdata('message', "Model Baru Berhasil Disimpan");
				redirect("unit_model");
			} else {
				$this->session->set_flashdata('message_error', "Model Baru Gagal Disimpan");
				redirect("unit_model");
			}
		} else {
			$this->data['content'] = 'admin/unit_model/create_v';
			$this->data['brands'] = $this->unit_brand_model->getAllById();
			$this->data['unit_category'] = $this->unit_category_model->getAllById();
			$this->load->view('admin/layouts/page', $this->data);
		}
	}

	public function edit($id) {
		$this->form_validation->set_rules('name', "Nama Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('brand_id', "Unit Brand Harus Dipilih", 'trim|required');
		$this->form_validation->set_rules('unit_category_id', "Unit Kategori Harus Dipilih", 'trim|required');

		if ($this->form_validation->run() === TRUE) {
			$data = array(
				'name' => $this->input->post('name'),
				'brand_id' => $this->input->post('brand_id'),
				'unit_category_id' => $this->input->post('unit_category_id'),
				'description' => "",
			);
			$update = $this->unit_model_model->update($data, array("unit_model.id" => $id));
			if ($update) {
				$this->session->set_flashdata('message', "Model Berhasil Diubah");
				redirect("unit_model", "refresh");
			} else {
				$this->session->set_flashdata('message_error', "Model Gagal Diubah");
				redirect("unit_model", "refresh");
			}
		} else {
			if (!empty($_POST)) {
				$id = $this->input->post('id');
				$this->session->set_flashdata('message_error', validation_errors());
				return redirect("unit_model/edit/" . $id);
			} else {
				$this->data['id'] = $this->uri->segment(3);
				$unit_model = $this->unit_model_model->getAllById(array("unit_model.id" => $this->data['id']));
				$this->data['name'] = (!empty($unit_model)) ? $unit_model[0]->name : "";
				$this->data['brand_id'] = (!empty($unit_model)) ? $unit_model[0]->brand_id : "";
				$this->data['unit_category_id'] = (!empty($unit_model)) ? $unit_model[0]->unit_category_id : "";
				$this->data['description'] = (!empty($unit_model)) ? $unit_model[0]->description : "";

				$this->data['content'] = 'admin/unit_model/edit_v';
				$this->data['unit_category'] = $this->unit_category_model->getAllById();
				$this->data['brands'] = $this->unit_brand_model->getAllById();
				$this->load->view('admin/layouts/page', $this->data);
			}
		}

	}

	public function dataList() {

		$columns = array(
			0 => 'brand_name',
			1 => 'category_name',
			2 => 'name',
			3 => '',
		);

		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];
		$search = array();
		$where = array();
		$limit = 0;
		$start = 0;
		$totalData = $this->unit_model_model->getCountAllBy($limit, $start, $search, $order, $dir, $where);

		if (!empty($this->input->post('search')['value'])) {
			$search_value = $this->input->post('search')['value'];
			$search = array(
				"unit_model.name" => $search_value,
				"unit_brand.name" => $search_value,
				"unit_category.name" => $search_value,
				"unit_model.description" => $search_value,
			);
			$totalFiltered = $this->unit_model_model->getCountAllBy($limit, $start, $search, $order, $dir, $where);
		} else {
			$totalFiltered = $totalData;
		}

		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$datas = $this->unit_model_model->getAllBy($limit, $start, $search, $order, $dir, $where);

		$new_data = array();
		if (!empty($datas)) {

			foreach ($datas as $key => $data) {

				$edit_url = "";
				$delete_url = "";

				if ($this->data['is_can_edit'] && $data->is_deleted == 0) {
					$edit_url = "<a href='" . base_url() . "unit_model/edit/" . $data->id . "' class='btn btn-sm btn-info white'> Ubah</a>";
				}
				if ($this->data['is_can_delete']) {
					$delete_url = "<a href='#'
						url='" . base_url() . "unit_model/destroy/" . $data->id . "/" . $data->is_deleted . "'
						class='btn btn-sm btn-danger white delete'> Hapus
						</a>";
				}

				$nestedData['id'] = $start + $key + 1;
				$nestedData['name'] = $data->name;
				$nestedData['brand_name'] = $data->brand_name;
				$nestedData['category_name'] = $data->category_name;
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
			$this->load->model("unit_model_model");
			$data = array(
				'is_deleted' => ($is_deleted == 1) ? 0 : 1,
			);
			$update = $this->unit_model_model->update($data, array("id" => $id));

			$response_data['data'] = $data;
			$response_data['msg'] = "Model Berhasil di Hapus";
			$response_data['status'] = true;
		} else {
			$response_data['msg'] = "ID Harus Diisi";
		}

		echo json_encode($response_data);
	}

	public function get_category() {
		$brand_id = $this->input->post('brand_id');

		$return_data = array(
			"status" => false,
			"message" => "",
			"data" => array(),
		);

		$where_brand = [
			"unit_model.brand_id" => $brand_id 
		];
		$data = $this->unit_model_model->getAllByIdBrand($where_brand);

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

	public function get_model() {
		$brand_id = $this->input->post('brand_id');
		$category_id = $this->input->post('unit_category_id');

		$return_data = array(
			"status" => false,
			"message" => "",
			"data" => array(),
		);
		$where = [
			"unit_model.brand_id" => $brand_id, 
			"unit_model.unit_category_id" => $category_id 
		];

		$data = $this->unit_model_model->getAllByIdBrandCategory($where);

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
}
