<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'core/Admin_Controller.php';
class Location extends Admin_Controller 
{
	public function __construct() 
	{
		parent::__construct();
		$this->load->model('location_model');
	}

	public function index() 
	{
		$this->load->helper('url');
		if ($this->data['is_can_read']) {
			$this->data['content'] = 'admin/location/list_v';
		} else {
			$this->data['content'] = 'errors/html/restrict';
		}

		$this->load->view('admin/layouts/page', $this->data);
	}

	public function create() 
	{
		$this->form_validation->set_rules('name', "Nama Harus Diisi", 'trim|required');

		if ($this->form_validation->run() === TRUE) {
			$data = array(
				'name' => $this->input->post('name'),
				'description' => "",
			);
			if ($this->location_model->insert($data)) {
				$this->session->set_flashdata('message', "Site Baru Berhasil Disimpan");
				redirect("location");
			} else {
				$this->session->set_flashdata('message_error', "Site Baru Gagal Disimpan");
				redirect("location");
			}
		} else {
			$this->data['content'] = 'admin/location/create_v';
			$this->load->view('admin/layouts/page', $this->data);
		}
	}

	public function edit($id) 
	{
		$this->form_validation->set_rules('name', "Name Harus Diisi", 'trim|required');

		if ($this->form_validation->run() === TRUE) {
			$data = array(
				'name' => $this->input->post('name'),
				'description' => "",
			);
			$update = $this->location_model->update($data, array("location.id" => $id));
			if ($update) {
				$this->session->set_flashdata('message', "Site Berhasil Diubah");
				redirect("location", "refresh");
			} else {
				$this->session->set_flashdata('message_error', "Site Gagal Diubah");
				redirect("location", "refresh");
			}
		} else {
			if (!empty($_POST)) {
				$id = $this->input->post('id');
				$this->session->set_flashdata('message_error', validation_errors());
				return redirect("location/edit/" . $id);
			} else {
				$this->data['id'] = $this->uri->segment(3);
				if ($this->data['id'] != 1) {
					$where_location = [
						"location.id" => $this->data['id'],
					];
					$location = $this->location_model->getAllById($where_location);
					$this->data['name'] = (!empty($location)) ? $location[0]->name : "";
					$this->data['description'] = (!empty($location)) ? $location[0]->description : "";

					$this->data['content'] = 'admin/location/edit_v';
				} else {
					$this->data['content'] = 'errors/html/restrict';
				}
				$this->load->view('admin/layouts/page', $this->data);
			}
		}

	}

	public function dataList() 
	{
		$columns = array(
			0 => 'name',
			1 => '',
		);

		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];
		$search = array();
		$limit = 0;
		$start = 0;
		$totalData = $this->location_model->getCountAllBy($limit, $start, $search, $order, $dir);

		if (!empty($this->input->post('search')['value'])) {
			$search_value = $this->input->post('search')['value'];
			$search = array(
				"location.name" => $search_value,
			);
			$totalFiltered = $this->location_model->getCountAllBy($limit, $start, $search, $order, $dir);
		} else {
			$totalFiltered = $totalData;
		}

		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$datas = $this->location_model->getAllBy($limit, $start, $search, $order, $dir);

		$new_data = array();
		if (!empty($datas)) {

			foreach ($datas as $key => $data) {
				$edit_url = "";
				$delete_url = "";

				if ($this->data['is_can_edit'] && $data->is_deleted == 0 && $data->id != 1) {
					$edit_url = "<a href='" . base_url() . "location/edit/" . $data->id . "' class='btn btn-sm btn-info white'> Ubah</a>";
				}
				if ($this->data['is_can_delete'] && $data->id != 1) {
					$delete_url = "<a href='#'
						url='" . base_url() . "location/destroy/" . $data->id . "/" . $data->is_deleted . "'
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

	public function destroy() 
	{
		$response_data = array();
		$response_data['status'] = false;
		$response_data['msg'] = "";
		$response_data['data'] = array();

		$id = $this->uri->segment(3);
		$is_deleted = $this->uri->segment(4);
		if (!empty($id)) {
			$this->load->model("location_model");
			$data = array(
				'is_deleted' => ($is_deleted == 1) ? 0 : 1,
			);
			$update = $this->location_model->update($data, array("id" => $id));

			$response_data['data'] = $data;
			$response_data['msg'] = "Lokasi Berhasil di Hapus";
			$response_data['status'] = true;
		} else {
			$response_data['msg'] = "ID Harus Diisi";
		}

		echo json_encode($response_data);
	}
}
