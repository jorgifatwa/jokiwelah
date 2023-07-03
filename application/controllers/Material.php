<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'core/Admin_Controller.php';
class Material extends Admin_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('material_model');
	}

	public function index() {

		$this->load->helper('url');
		if ($this->data['is_can_read']) {
			$this->data['content'] = 'admin/material/list_v';
		} else {
			$this->data['content'] = 'errors/html/restrict';
		}

		$this->load->view('admin/layouts/page', $this->data);
	}

	public function create() {
		$this->form_validation->set_rules('name', "Nama Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('capacity', "Kapasitas Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('uom', "Satuan Harus Dipilih", 'trim|required');

		if ($this->form_validation->run() === TRUE) {
			$data = array(
				'name' => $this->input->post('name'),
				'capacity' => $this->input->post('capacity'),
				'uom' => $this->input->post('uom'),
				'description' => "",
			);
			if ($this->material_model->insert($data)) {
				$this->session->set_flashdata('message', "material Baru Berhasil Disimpan");
				redirect("material");
			} else {
				$this->session->set_flashdata('message_error', "material Baru Gagal Disimpan");
				redirect("material");
			}
		} else {
			$this->data['content'] = 'admin/material/create_v';
			$this->load->view('admin/layouts/page', $this->data);
		}
	}

	public function edit($id) {
		$this->form_validation->set_rules('name', "Name Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('capacity', "Kapasitas Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('uom', "Satuan Harus Dipilih", 'trim|required');

		if ($this->form_validation->run() === TRUE) {
			$data = array(
				'name' => $this->input->post('name'),
				'capacity' => $this->input->post('capacity'),
				'uom' => $this->input->post('uom'),
				'description' => "",
			);
			$update = $this->material_model->update($data, array("material.id" => $id));
			if ($update) {
				$this->session->set_flashdata('message', "material Berhasil Diubah");
				redirect("material", "refresh");
			} else {
				$this->session->set_flashdata('message_error', "material Gagal Diubah");
				redirect("material", "refresh");
			}
		} else {
			if (!empty($_POST)) {
				$id = $this->input->post('id');
				$this->session->set_flashdata('message_error', validation_errors());
				return redirect("material/edit/" . $id);
			} else {
				$this->data['id'] = $this->uri->segment(3);
				$material = $this->material_model->getAllById(array("material.id" => $this->data['id']));
				$this->data['name'] = (!empty($material)) ? $material[0]->name : "";
				$this->data['capacity'] = (!empty($material)) ? $material[0]->capacity : "";
				$this->data['uom'] = (!empty($material)) ? $material[0]->uom : "";
				$this->data['description'] = (!empty($material)) ? $material[0]->description : "";

				$this->data['content'] = 'admin/material/edit_v';
				$this->load->view('admin/layouts/page', $this->data);
			}
		}

	}

	public function dataList() {

		$columns = array(
			0 => 'name',
			1 => 'capacity',
			2 => 'uom',
			3 => '',
		);

		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];
		$search = array();
		$limit = 0;
		$start = 0;
		$totalData = $this->material_model->getCountAllBy($limit, $start, $search, $order, $dir);

		if (!empty($this->input->post('search')['value'])) {
			$search_value = $this->input->post('search')['value'];
			$search = array(
				"material.name" => $search_value,
				"material.capacity" => $search_value,
				"material.uom" => $search_value,
			);
			$totalFiltered = $this->material_model->getCountAllBy($limit, $start, $search, $order, $dir);
		} else {
			$totalFiltered = $totalData;
		}

		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$datas = $this->material_model->getAllBy($limit, $start, $search, $order, $dir);

		$new_data = array();
		if (!empty($datas)) {

			foreach ($datas as $key => $data) {

				$edit_url = "";
				$delete_url = "";

				if ($this->data['is_can_edit'] && $data->is_deleted == 0) {
					$edit_url = "<a href='" . base_url() . "material/edit/" . $data->id . "' class='btn btn-sm btn-info white'> Ubah</a>";
				}
				if ($this->data['is_can_delete']) {
					$delete_url = "<a href='#'
						url='" . base_url() . "material/destroy/" . $data->id . "/" . $data->is_deleted . "'
						class='btn btn-sm btn-danger white delete'> Hapus
						</a>";
				}

				$nestedData['id'] = $start + $key + 1;
				$nestedData['name'] = $data->name;
				$nestedData['capacity'] = $data->capacity;
				$nestedData['uom'] = $data->uom;
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
			$this->load->model("material_model");
			$data = array(
				'is_deleted' => ($is_deleted == 1) ? 0 : 1,
			);
			$update = $this->material_model->update($data, array("id" => $id));

			$response_data['data'] = $data;
			$response_data['msg'] = "Material Berhasil di Hapus";
			$response_data['status'] = true;
		} else {
			$response_data['msg'] = "ID Harus Diisi";
		}

		echo json_encode($response_data);
	}
}
