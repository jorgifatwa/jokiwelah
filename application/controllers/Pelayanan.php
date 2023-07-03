<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'core/Admin_Controller.php';
class Pelayanan extends Admin_Controller 
{
	public function __construct() 
	{
		parent::__construct();
		$this->load->model('pelayanan_model');
	}

	public function index() 
	{
		$this->load->helper('url');
		if ($this->data['is_can_read']) {
			$this->data['content'] = 'admin/pelayanan/list_v';
		} else {
			$this->data['content'] = 'errors/html/restrict';
		}

		$this->load->view('admin/layouts/page', $this->data);
	}

	public function create() 
	{
		$this->form_validation->set_rules('name', "Nama Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('proses_pengerjaan', "Proses Pengerjaan Harus Diisi", 'trim|required');

		if ($this->form_validation->run() === TRUE) {
			$data = array(
				'name' => $this->input->post('name'),
				'proses_pengerjaan' => $this->input->post('proses_pengerjaan'),
			);

			$location_path = "./uploads/pelayanan/";
			if(!is_dir($location_path))
			{
				mkdir($location_path);
			}

			$tmp = $_FILES["gambar"]['name'];
			$ext = ".".pathinfo($tmp, PATHINFO_EXTENSION);
			$uploaded      = uploadFile('gambar', $location_path, 'banner', $ext);
			
			if($uploaded['status']==TRUE){
				$data['gambar'] = str_replace(' ', '_', $uploaded['message']);	
			}

			if ($this->pelayanan_model->insert($data)) {
				$this->session->set_flashdata('message', "Pelayanan Baru Berhasil Disimpan");
				redirect("pelayanan");
			} else {
				$this->session->set_flashdata('message_error', "Pelayanan Baru Gagal Disimpan");
				redirect("pelayanan");
			}
		} else {
			$this->data['content'] = 'admin/pelayanan/create_v';
			$this->load->view('admin/layouts/page', $this->data);
		}
	}

	public function edit($id) 
	{
		$this->form_validation->set_rules('name', "Name Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('proses_pengerjaan', "Proses Pengerjaan Harus Diisi", 'trim|required');

		if ($this->form_validation->run() === TRUE) {
			$data = array(
				'name' => $this->input->post('name'),
				'proses_pengerjaan' => $this->input->post('proses_pengerjaan'),
			);

			$location_path = "./uploads/pelayanan/";
			if(!is_dir($location_path))
			{
				mkdir($location_path);
			}

			$tmp = $_FILES["gambar"]['name'];
			$ext = ".".pathinfo($tmp, PATHINFO_EXTENSION);
			$uploaded      = uploadFile('gambar', $location_path, 'banner', $ext);
			
			if($uploaded['status']==TRUE){
				$data['gambar'] = str_replace(' ', '_', $uploaded['message']);	
			}

			$update = $this->pelayanan_model->update($data, array("pelayanan.id" => $id));
			if ($update) {
				$this->session->set_flashdata('message', "Pelayanan Berhasil Diubah");
				redirect("pelayanan", "refresh");
			} else {
				$this->session->set_flashdata('message_error', "Pelayanan Gagal Diubah");
				redirect("pelayanan", "refresh");
			}
		} else {
			if (!empty($_POST)) {
				$id = $this->input->post('id');
				$this->session->set_flashdata('message_error', validation_errors());
				return redirect("pelayanan/edit/" . $id);
			} else {
				$this->data['id'] = $this->uri->segment(3);
				$where_pelayanan = [
					"pelayanan.id" => $this->data['id'],
				];
				$pelayanan = $this->pelayanan_model->getAllById($where_pelayanan);
				$this->data['name'] = (!empty($pelayanan)) ? $pelayanan[0]->name : "";
				$this->data['gambar'] = (!empty($pelayanan)) ? $pelayanan[0]->gambar : "";
				$this->data['proses_pengerjaan'] = (!empty($pelayanan)) ? $pelayanan[0]->proses_pengerjaan : "";

				$this->data['content'] = 'admin/pelayanan/edit_v';
				$this->load->view('admin/layouts/page', $this->data);
			}
		}

	}

	public function dataList() 
	{
		$columns = array(
			0 => 'gambar',
			1 => 'name',
			2 => 'proses_pengerjaan',
			3 => '',
		);

		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];
		$search = array();
		$limit = 0;
		$start = 0;
		$totalData = $this->pelayanan_model->getCountAllBy($limit, $start, $search, $order, $dir);

		if (!empty($this->input->post('search')['value'])) {
			$search_value = $this->input->post('search')['value'];
			$search = array(
				"pelayanan.name" => $search_value,
				"pelayanan.proses_pengerjaan" => $search_value,
			);
			$totalFiltered = $this->pelayanan_model->getCountAllBy($limit, $start, $search, $order, $dir);
		} else {
			$totalFiltered = $totalData;
		}

		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$datas = $this->pelayanan_model->getAllBy($limit, $start, $search, $order, $dir);

		$new_data = array();
		if (!empty($datas)) {

			foreach ($datas as $key => $data) {
				$edit_url = "";
				$delete_url = "";

				if ($this->data['is_can_edit'] && $data->is_deleted == 0) {
					$edit_url = "<a href='" . base_url() . "pelayanan/edit/" . $data->id . "' class='btn btn-sm btn-info white'> Ubah</a>";
				}
				if ($this->data['is_can_delete']) {
					$delete_url = "<a href='#'
						url='" . base_url() . "pelayanan/destroy/" . $data->id . "/" . $data->is_deleted . "'
						class='btn btn-sm btn-danger white delete'> Hapus
						</a>";
				}

				$nestedData['id'] = $start + $key + 1;
				$nestedData['gambar'] = "<a href='".base_url('uploads/pelayanan/'.$data->gambar)."' target='_blank'><img width='50' src='".base_url('uploads/pelayanan/'.$data->gambar)."'>";
				$nestedData['name'] = $data->name;
				$nestedData['proses_pengerjaan'] = $data->proses_pengerjaan;
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
			$this->load->model("pelayanan_model");
			$data = array(
				'is_deleted' => ($is_deleted == 1) ? 0 : 1,
			);
			$update = $this->pelayanan_model->update($data, array("id" => $id));

			$response_data['data'] = $data;
			$response_data['msg'] = "Pelayanan Berhasil di Hapus";
			$response_data['status'] = true;
		} else {
			$response_data['msg'] = "ID Harus Diisi";
		}

		echo json_encode($response_data);
	}
}
