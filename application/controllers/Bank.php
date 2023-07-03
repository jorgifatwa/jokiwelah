<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'core/Admin_Controller.php';
class Bank extends Admin_Controller 
{
	public function __construct() 
	{
		parent::__construct();
		$this->load->model('bank_model');
	}

	public function index() 
	{
		$this->load->helper('url');
		if ($this->data['is_can_read']) {
			$this->data['content'] = 'admin/bank/list_v';
		} else {
			$this->data['content'] = 'errors/html/restrict';
		}

		$this->load->view('admin/layouts/page', $this->data);
	}

	public function create() 
	{
		$this->form_validation->set_rules('name', "Nama Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('no_rekening', "Nomor Rekening Harus Diisi", 'trim|required');

		if ($this->form_validation->run() === TRUE) {
			$data = array(
				'name' => $this->input->post('name'),
				'no_rekening' => $this->input->post('no_rekening'),
			);

			$location_path = "./uploads/bank/";
			if(!is_dir($location_path))
			{
				mkdir($location_path);
			}

			$tmp = $_FILES["qr"]['name'];
			$ext = ".".pathinfo($tmp, PATHINFO_EXTENSION);
			$uploaded      = uploadFile('qr', $location_path, 'gambar', $ext);
			
			if($uploaded['status']==TRUE){
				$data['qr'] = str_replace(' ', '_', $uploaded['message']);	
			}

			if ($this->bank_model->insert($data)) {
				$this->session->set_flashdata('message', "bank Baru Berhasil Disimpan");
				redirect("bank");
			} else {
				$this->session->set_flashdata('message_error', "bank Baru Gagal Disimpan");
				redirect("bank");
			}
		} else {
			$this->data['content'] = 'admin/bank/create_v';
			$this->load->view('admin/layouts/page', $this->data);
		}
	}

	public function edit($id) 
	{
		$this->form_validation->set_rules('name', "Name Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('no_rekening', "Proses Pengerjaan Harus Diisi", 'trim|required');

		if ($this->form_validation->run() === TRUE) {
			$data = array(
				'name' => $this->input->post('name'),
				'no_rekening' => $this->input->post('no_rekening'),
			);

			$location_path = "./uploads/bank/";
			if(!is_dir($location_path))
			{
				mkdir($location_path);
			}

			$tmp = $_FILES["qr"]['name'];
			$ext = ".".pathinfo($tmp, PATHINFO_EXTENSION);
			$uploaded      = uploadFile('qr', $location_path, 'gambar', $ext);
			
			if($uploaded['status']==TRUE){
				$data['qr'] = str_replace(' ', '_', $uploaded['message']);	
			}

			$update = $this->bank_model->update($data, array("bank.id" => $id));
			if ($update) {
				$this->session->set_flashdata('message', "bank Berhasil Diubah");
				redirect("bank", "refresh");
			} else {
				$this->session->set_flashdata('message_error', "bank Gagal Diubah");
				redirect("bank", "refresh");
			}
		} else {
			if (!empty($_POST)) {
				$id = $this->input->post('id');
				$this->session->set_flashdata('message_error', validation_errors());
				return redirect("bank/edit/" . $id);
			} else {
				$this->data['id'] = $this->uri->segment(3);
				$where_bank = [
					"bank.id" => $this->data['id'],
				];
				$bank = $this->bank_model->getAllById($where_bank);
				$this->data['name'] = (!empty($bank)) ? $bank[0]->name : "";
				$this->data['no_rekening'] = (!empty($bank)) ? $bank[0]->no_rekening : "";
				$this->data['qr'] = (!empty($bank)) ? $bank[0]->qr : "";

				$this->data['content'] = 'admin/bank/edit_v';
				$this->load->view('admin/layouts/page', $this->data);
			}
		}

	}

	public function dataList() 
	{
		$columns = array(
			0 => 'name',
			1 => 'no_rekening',
			2 => 'qr',
			3 => '',
		);

		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];
		$search = array();
		$limit = 0;
		$start = 0;
		$totalData = $this->bank_model->getCountAllBy($limit, $start, $search, $order, $dir);

		if (!empty($this->input->post('search')['value'])) {
			$search_value = $this->input->post('search')['value'];
			$search = array(
				"bank.name" => $search_value,
			);
			$totalFiltered = $this->bank_model->getCountAllBy($limit, $start, $search, $order, $dir);
		} else {
			$totalFiltered = $totalData;
		}

		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$datas = $this->bank_model->getAllBy($limit, $start, $search, $order, $dir);

		$new_data = array();
		if (!empty($datas)) {

			foreach ($datas as $key => $data) {
				$edit_url = "";
				$delete_url = "";

				if ($this->data['is_can_edit'] && $data->is_deleted == 0) {
					$edit_url = "<a href='" . base_url() . "bank/edit/" . $data->id . "' class='btn btn-sm btn-info white'> Ubah</a>";
				}
				if ($this->data['is_can_delete']) {
					$delete_url = "<a href='#'
						url='" . base_url() . "bank/destroy/" . $data->id . "/" . $data->is_deleted . "'
						class='btn btn-sm btn-danger white delete'> Hapus
						</a>";
				}

				$nestedData['id'] = $start + $key + 1;
				$nestedData['name'] = $data->name;
				$nestedData['no_rekening'] = $data->no_rekening;
				$nestedData['qr'] = "<a href='".base_url('uploads/bank/'.$data->qr)."' target='_blank'><img width='50' src='".base_url('uploads/bank/'.$data->qr)."'>";
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
			$this->load->model("bank_model");
			$data = array(
				'is_deleted' => ($is_deleted == 1) ? 0 : 1,
			);
			$update = $this->bank_model->update($data, array("id" => $id));

			$response_data['data'] = $data;
			$response_data['msg'] = "bank Berhasil di Hapus";
			$response_data['status'] = true;
		} else {
			$response_data['msg'] = "ID Harus Diisi";
		}

		echo json_encode($response_data);
	}
}
