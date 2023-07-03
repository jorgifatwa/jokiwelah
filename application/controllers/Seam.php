<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'core/Admin_Controller.php';
class Seam extends Admin_Controller 
{
	public function __construct() 
	{
		parent::__construct();
		$this->load->model('seam_model');
		$this->load->model('location_model');
		$this->load->model('pit_model');
	}

	public function index() 
	{
		$this->load->helper('url');
		if ($this->data['is_can_read']) {
			$this->data['content'] = 'admin/seam/list_v';
		} else {
			$this->data['content'] = 'errors/html/restrict';
		}

		$this->load->view('admin/layouts/page', $this->data);
	}

	public function create() 
	{
		$this->form_validation->set_rules('name', "Nama Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('location_id', "Lokasi Harus Dipilih", 'trim|required');
		$this->form_validation->set_rules('pit_id', "Lokasi Harus Dipilih", 'trim|required');

		if ($this->form_validation->run() === TRUE) {
			$data = array(
				'name' => $this->input->post('name'),
				'location_id' => $this->input->post('location_id'),
				'pit_id' => $this->input->post('pit_id'),
				'description' => "",
			);
			if ($this->seam_model->insert($data)) {
				$this->session->set_flashdata('message', "Seam Baru Berhasil Disimpan");
				redirect("seam");
			} else {
				$this->session->set_flashdata('message_error', "Seam Baru Gagal Disimpan");
				redirect("seam");
			}
		} else {
			$this->data['content'] = 'admin/seam/create_v';
			$where_location = [
				"location.id !=" => 1,
				"location.is_deleted" => 0
			];
			$this->data['locations'] = $this->location_model->getAllById($where_location);
			$this->load->view('admin/layouts/page', $this->data);
		}
	}

	public function edit($id) 
	{
		$this->form_validation->set_rules('name', "Name Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('location_id', "Lokasi Harus Dipilih", 'trim|required');
		$this->form_validation->set_rules('pit_id', "Lokasi Harus Dipilih", 'trim|required');

		if ($this->form_validation->run() === TRUE) {
			$data = array(
				'name' => $this->input->post('name'),
				'location_id' => $this->input->post('location_id'),
				'pit_id' => $this->input->post('pit_id'),
				'description' => "",
			);
			$update = $this->seam_model->update($data, array("seam.id" => $id));
			if ($update) {
				$this->session->set_flashdata('message', "Seam Berhasil Diubah");
				redirect("seam", "refresh");
			} else {
				$this->session->set_flashdata('message_error', "Seam Gagal Diubah");
				redirect("seam", "refresh");
			}
		} else {
			if (!empty($_POST)) {
				$id = $this->input->post('id');
				$this->session->set_flashdata('message_error', validation_errors());
				return redirect("seam/edit/" . $id);
			} else {
				$this->data['id'] = $this->uri->segment(3);
				$seam = $this->seam_model->getAllById(array("seam.id" => $this->data['id']));
				$this->data['name'] = (!empty($seam)) ? $seam[0]->name : "";
				$this->data['location_id'] = (!empty($seam)) ? $seam[0]->location_id : "";
				$this->data['pit_id'] = (!empty($seam)) ? $seam[0]->pit_id : "";
				$this->data['description'] = (!empty($seam)) ? $seam[0]->description : "";
				$where_location = [
					"location.id !=" => 1,
					"location.is_deleted" => 0
				];
				$this->data['locations'] = $this->location_model->getAllById($where_location);
				$this->data['content'] = 'admin/seam/edit_v';
				$this->load->view('admin/layouts/page', $this->data);
			}
		}

	}

	public function dataList() 
	{
		$columns = array(
			0 => 'location_name',
			1 => 'pit_name',
			2 => 'name',
			3 => '',
		);

		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];
		$search = array();
		$limit = 0;
		$start = 0;
		$totalData = $this->seam_model->getCountAllBy($limit, $start, $search, $order, $dir);

		if (!empty($this->input->post('search')['value'])) {
			$search_value = $this->input->post('search')['value'];
			$search = array(
				"location.name" => $search_value,
				"seam.name" => $search_value,
				"pit.name" => $search_value,
			);
			$totalFiltered = $this->seam_model->getCountAllBy($limit, $start, $search, $order, $dir);
		} else {
			$totalFiltered = $totalData;
		}

		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$datas = $this->seam_model->getAllBy($limit, $start, $search, $order, $dir);

		$new_data = array();
		if (!empty($datas)) {

			foreach ($datas as $key => $data) {

				$edit_url = "";
				$delete_url = "";

				if ($this->data['is_can_edit'] && $data->is_deleted == 0) {
					$edit_url = "<a href='" . base_url() . "seam/edit/" . $data->id . "' class='btn btn-sm btn-info white'> Ubah</a>";
				}
				if ($this->data['is_can_delete']) {
					$delete_url = "<a href='#'
						url='" . base_url() . "seam/destroy/" . $data->id . "/" . $data->is_deleted . "'
						class='btn btn-sm btn-danger white delete'> Hapus
						</a>";
				}

				$nestedData['id'] = $start + $key + 1;
				$nestedData['name'] = $data->name;
				$nestedData['location_name'] = $data->location_name;
				$nestedData['pit_name'] = $data->pit_name;
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
			$this->load->model("seam_model");
			$data = array(
				'is_deleted' => ($is_deleted == 1) ? 0 : 1,
			);
			$update = $this->seam_model->update($data, array("id" => $id));

			$response_data['data'] = $data;
			$response_data['msg'] = "Seam Berhasil di Hapus";
			$response_data['status'] = true;
		} else {
			$response_data['msg'] = "ID Harus Diisi";
		}

		echo json_encode($response_data);
	}

	public function getPit()
	{
		$id = $this->input->post("id");
		$pit = $this->pit_model->getAllById(['pit.location_id' => $id]);

		if(!empty($pit)){
            $response_data['status'] = true;
            $response_data['data'] = $pit;
            $response_data['message'] = 'Berhasil Mengambil Data';
        }else{
            $response_data['status'] = false;
            $response_data['data'] = [];
            $response_data['message'] = 'Gagal Mengambil Data';
        }

        echo json_encode($response_data);
	}
}
