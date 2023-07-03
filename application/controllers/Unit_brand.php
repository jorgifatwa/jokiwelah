<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'core/Admin_Controller.php';
class Unit_brand extends Admin_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('unit_brand_model');
	}

	public function index() {

		$this->load->helper('url');
		if ($this->data['is_can_read']) {
			$this->data['content'] = 'admin/unit_brand/list_v';
		} else {
			$this->data['content'] = 'errors/html/restrict';
		}

		$this->load->view('admin/layouts/page', $this->data);
	}

	public function create() {
		$this->form_validation->set_rules('name', "Nama Harus Diisi", 'trim|required');

		if ($this->form_validation->run() === TRUE) {
			$data = array(
				'name' => $this->input->post('name'),
				'description' => "",
			);
			if ($this->unit_brand_model->insert($data)) {
				$this->session->set_flashdata('message', "Brand Baru Berhasil Disimpan");
				redirect("unit_brand");
			} else {
				$this->session->set_flashdata('message_error', "Brand Baru Gagal Disimpan");
				redirect("unit_brand");
			}
		} else {
			$this->data['content'] = 'admin/unit_brand/create_v';
			$this->load->view('admin/layouts/page', $this->data);
		}
	}

	public function edit($id) {
		$this->form_validation->set_rules('name', "Name Harus Diisi", 'trim|required');

		if ($this->form_validation->run() === TRUE) {
			$data = array(
				'name' => $this->input->post('name'),
				'description' => "",
			);
			$update = $this->unit_brand_model->update($data, array("unit_brand.id" => $id));
			if ($update) {
				$this->session->set_flashdata('message', "Brand Berhasil Diubah");
				redirect("unit_brand", "refresh");
			} else {
				$this->session->set_flashdata('message_error', "Brand Gagal Diubah");
				redirect("unit_brand", "refresh");
			}
		} else {
			if (!empty($_POST)) {
				$id = $this->input->post('id');
				$this->session->set_flashdata('message_error', validation_errors());
				return redirect("unit_brand/edit/" . $id);
			} else {
				$this->data['id'] = $this->uri->segment(3);
				$unit_brand = $this->unit_brand_model->getAllById(array("unit_brand.id" => $this->data['id']));
				$this->data['name'] = (!empty($unit_brand)) ? $unit_brand[0]->name : "";
				$this->data['description'] = (!empty($unit_brand)) ? $unit_brand[0]->description : "";

				$this->data['content'] = 'admin/unit_brand/edit_v';
				$this->load->view('admin/layouts/page', $this->data);
			}
		}

	}

	public function dataList() {

		$columns = array(
			0 => 'name',
			1 => '',
		);

		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];
		$search = array();
		$limit = 0;
		$start = 0;
		$totalData = $this->unit_brand_model->getCountAllBy($limit, $start, $search, $order, $dir);

		if (!empty($this->input->post('search')['value'])) {
			$search_value = $this->input->post('search')['value'];
			$search = array(
				"unit_brand.name" => $search_value,
				"unit_brand.description" => $search_value,
			);
			$totalFiltered = $this->unit_brand_model->getCountAllBy($limit, $start, $search, $order, $dir);
		} else {
			$totalFiltered = $totalData;
		}

		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$datas = $this->unit_brand_model->getAllBy($limit, $start, $search, $order, $dir);

		$new_data = array();
		if (!empty($datas)) {

			foreach ($datas as $key => $data) {

				$edit_url = "";
				$delete_url = "";

				if ($this->data['is_can_edit'] && $data->is_deleted == 0) {
					$edit_url = "<a href='" . base_url() . "unit_brand/edit/" . $data->id . "' class='btn btn-sm btn-info white'> Ubah</a>";
				}
				if ($this->data['is_can_delete']) {
					$delete_url = "<a href='#'
						url='" . base_url() . "unit_brand/destroy/" . $data->id . "/" . $data->is_deleted . "'
						class='btn btn-sm btn-danger white delete'> Hapus
						</a>";
				}

				$nestedData['id'] = $start + $key + 1;
				$nestedData['name'] = $data->name;
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
			$this->load->model("unit_brand_model");
			$data = array(
				'is_deleted' => ($is_deleted == 1) ? 0 : 1,
			);
			$update = $this->unit_brand_model->update($data, array("id" => $id));

			$response_data['data'] = $data;
			$response_data['msg'] = "Brand Berhasil di Hapus";
			$response_data['status'] = true;
		} else {
			$response_data['msg'] = "ID Harus Diisi";
		}

		echo json_encode($response_data);
	}
}
