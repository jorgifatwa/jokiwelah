<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'core/Admin_Controller.php';
class Disposal extends Admin_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('disposal_model');
		$this->load->model('location_model');
	}

	public function index() {

		$this->load->helper('url');
		if ($this->data['is_can_read']) {
			$this->data['content'] = 'admin/disposal/list_v';
		} else {
			$this->data['content'] = 'errors/html/restrict';
		}

		$this->load->view('admin/layouts/page', $this->data);
	}

	public function create() {
		$this->form_validation->set_rules('name', "Nama Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('location_id', "Lokasi Harus Dipilih", 'trim|required');
		$this->form_validation->set_rules('production', "Produk Harus Dipilih", 'trim|required');

		if ($this->form_validation->run() === TRUE) {
			$name = $this->input->post("name");
			$location_id = $this->input->post("location_id");
			$production = $this->input->post("production");
			$data = array(
				'name' => $name,
				'location_id' => $location_id,
				'production' => $production,
				'description' => "",
			);
			if ($this->disposal_model->insert($data)) {
				$this->session->set_flashdata('message', "Disposal Baru Berhasil Disimpan");
				redirect("disposal");
			} else {
				$this->session->set_flashdata('message_error', "Disposal Baru Gagal Disimpan");
				redirect("disposal");
			}
		} else {
			$where_location = [
				"location.id !=" => 1,
				"location.is_deleted" => 0,
			];
			$this->data['locations'] = $this->location_model->getAllById($where_location);
			$this->data['content'] = 'admin/disposal/create_v';
			$this->load->view('admin/layouts/page', $this->data);
		}
	}

	public function edit($id) {
		$this->form_validation->set_rules('name', "Nama Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('location_id', "Lokasi Harus Dipilih", 'trim|required');
		$this->form_validation->set_rules('production', "Produk Harus Dipilih", 'trim|required');

		if ($this->form_validation->run() === TRUE) {
			$name = $this->input->post("name");
			$location_id = $this->input->post("location_id");
			$production = $this->input->post("production");
			$data = array(
				'name' => $name,
				'location_id' => $location_id,
				'production' => $production,
				'description' => "",
			);
			$update = $this->disposal_model->update($data, array("disposal.id" => $id));
			if ($update) {
				$this->session->set_flashdata('message', "Disposal Berhasil Diubah");
				redirect("disposal", "refresh");
			} else {
				$this->session->set_flashdata('message_error', "Disposal Gagal Diubah");
				redirect("disposal", "refresh");
			}
		} else {
			if (!empty($_POST)) {
				$id = $this->input->post('id');
				$this->session->set_flashdata('message_error', validation_errors());
				return redirect("disposal/edit/" . $id);
			} else {
				$this->data['id'] = $this->uri->segment(3);
				$disposal = $this->disposal_model->getOneBy(["disposal.id" => $this->data['id']]);
				$this->data['name'] = (!empty($disposal)) ? $disposal->name : "";
				$this->data['location_id'] = (!empty($disposal)) ? $disposal->location_id : "";
				$this->data['production'] = (!empty($disposal)) ? $disposal->production : "";
				$this->data['description'] = (!empty($disposal)) ? $disposal->description : "";

				$where_location = [
					"location.id !=" => 1,
					"location.is_deleted" => 0,
				];
				$this->data['locations'] = $this->location_model->getAllById($where_location);
				$this->data['content'] = 'admin/disposal/edit_v';
				$this->load->view('admin/layouts/page', $this->data);
			}
		}

	}

	public function dataList() {
		$columns = array(
			0 => 'location.name',
			1 => 'disposal.production',
			2 => 'disposal.name',
			3 => '',
		);

		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];
		$search = array();
		$limit = 0;
		$start = 0;
		$totalData = $this->disposal_model->getCountAllBy($limit, $start, $search, $order, $dir);

		if (!empty($this->input->post('search')['value'])) {
			$search_value = $this->input->post('search')['value'];
			$search = array(
				"location.name" => $search_value,
				"disposal.name" => $search_value,
				"disposal.description" => $search_value,
			);

			$totalFiltered = $this->disposal_model->getCountAllBy($limit, $start, $search, $order, $dir);
		} else {
			$totalFiltered = $totalData;
		}

		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$datas = $this->disposal_model->getAllBy($limit, $start, $search, $order, $dir);

		$new_data = array();
		if (!empty($datas)) {

			foreach ($datas as $key => $data) {
				$edit_url = "";
				$delete_url = "";

				if ($this->data['is_can_edit'] && $data->is_deleted == 0) {
					$edit_url = "<a href='" . base_url() . "disposal/edit/" . $data->id . "' class='btn btn-sm btn-info white'> Ubah</a>";
				}
				if ($this->data['is_can_delete']) {
					$delete_url = "<a href='#'
						url='" . base_url() . "disposal/destroy/" . $data->id . "/" . $data->is_deleted . "'
						class='btn btn-sm btn-danger white delete'> Hapus
						</a>";
				}

				$produksi = "";
				if ($data->production == 1) {
					$produksi = "OB Production";
				} elseif ($data->production == 2) {
					$produksi = "Coal Production";
				} elseif ($data->production == 3) {
					$produksi = "Fuel";
				}

				$nestedData['id'] = $start + $key + 1;
				$nestedData['location_name'] = $data->location_name;
				$nestedData['produksi'] = $produksi;
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
			$this->load->model("disposal_model");
			$data = array(
				'is_deleted' => ($is_deleted == 1) ? 0 : 1,
			);
			$update = $this->disposal_model->update($data, array("id" => $id));

			$response_data['data'] = $data;
			$response_data['msg'] = "Disposal Berhasil di Hapus";
			$response_data['status'] = true;
		} else {
			$response_data['msg'] = "ID Harus Diisi";
		}

		echo json_encode($response_data);
	}
}
