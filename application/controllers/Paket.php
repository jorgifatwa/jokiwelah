<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'core/Admin_Controller.php';
class Paket extends Admin_Controller 
{
	public function __construct() 
	{
		parent::__construct();
		$this->load->model('paket_model');
		$this->load->model('pelayanan_model');
	}

	public function index() 
	{
		$this->load->helper('url');
		if ($this->data['is_can_read']) {
			$this->data['content'] = 'admin/paket/list_v';
		} else {
			$this->data['content'] = 'errors/html/restrict';
		}

		$this->load->view('admin/layouts/page', $this->data);
	}

	public function create() 
	{
		$this->form_validation->set_rules('id_pelayanan', "Pelayanan Harus Dipilih", 'trim|required');
		$this->form_validation->set_rules('name', "Nama Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('harga', "Harga Harus Diisi", 'trim|required');

		if ($this->form_validation->run() === TRUE) {
			$data = array(
				'id_pelayanan' => $this->input->post('id_pelayanan'),
				'name' => $this->input->post('name'),
				'harga' => $this->input->post('harga'),
				'description' => $this->input->post('description'),
			);
			if ($this->paket_model->insert($data)) {
				$this->session->set_flashdata('message', "Paket Baru Berhasil Disimpan");
				redirect("paket");
			} else {
				$this->session->set_flashdata('message_error', "Paket Baru Gagal Disimpan");
				redirect("paket");
			}
		} else {
			$this->data['content'] = 'admin/paket/create_v';
			$this->data['pelayanans'] = $this->pelayanan_model->getAllById();
			$this->load->view('admin/layouts/page', $this->data);
		}
	}

	public function edit($id) 
	{
		$this->form_validation->set_rules('id_pelayanan', "Pelayanan Harus Dipilih", 'trim|required');
		$this->form_validation->set_rules('name', "Nama Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('harga', "Harga Harus Diisi", 'trim|required');

		if ($this->form_validation->run() === TRUE) {
			$data = array(
				'id_pelayanan' => $this->input->post('id_pelayanan'),
				'name' => $this->input->post('name'),
				'harga' => $this->input->post('harga'),
				'description' => $this->input->post('description'),
			);
			$update = $this->paket_model->update($data, array("paket.id" => $id));
			if ($update) {
				$this->session->set_flashdata('message', "paket Berhasil Diubah");
				redirect("paket", "refresh");
			} else {
				$this->session->set_flashdata('message_error', "paket Gagal Diubah");
				redirect("paket", "refresh");
			}
		} else {
			if (!empty($_POST)) {
				$id = $this->input->post('id');
				$this->session->set_flashdata('message_error', validation_errors());
				return redirect("paket/edit/" . $id);
			} else {
				$this->data['id'] = $this->uri->segment(3);
				$paket = $this->paket_model->getAllById(array("paket.id" => $this->data['id']));
				$this->data['id_pelayanan'] 	= (!empty($paket)) ? $paket[0]->id_pelayanan : "";
				$this->data['name'] 	= (!empty($paket)) ? $paket[0]->name : "";
				$this->data['harga'] = (!empty($paket)) ? $paket[0]->harga : "";
				$this->data['description'] = (!empty($paket)) ? $paket[0]->description : "";
				$this->data['pelayanans'] = $this->pelayanan_model->getAllById();
				$this->data['content'] = 'admin/paket/edit_v';
				$this->load->view('admin/layouts/page', $this->data);
			}
		}

	}

	public function dataList() 
	{
		$columns = array(
			0 => 'pelayanan_name',
			1 => 'name',
			2 => 'harga',
			3 => 'description',
			4 => '',
		);

		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];
		$search = array();
		$limit = 0;
		$start = 0;
		$totalData = $this->paket_model->getCountAllBy($limit, $start, $search, $order, $dir);

		if (!empty($this->input->post('search')['value'])) {
			$search_value = $this->input->post('search')['value'];
			$search = array(
				"paket.name" => $search_value,
				"pelayanan.name" => $search_value,
				"paket.harga" => $search_value,
				"paket.description" => $search_value,
			);
			$totalFiltered = $this->paket_model->getCountAllBy($limit, $start, $search, $order, $dir);
		} else {
			$totalFiltered = $totalData;
		}

		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$datas = $this->paket_model->getAllBy($limit, $start, $search, $order, $dir);

		$new_data = array();
		if (!empty($datas)) {

			foreach ($datas as $key => $data) {

				$edit_url = "";
				$delete_url = "";

				if ($this->data['is_can_edit'] && $data->is_deleted == 0) {
					$edit_url = "<a href='" . base_url() . "paket/edit/" . $data->id . "' class='btn btn-sm btn-info white'> Ubah</a>";
				}
				if ($this->data['is_can_delete']) {
					$delete_url = "<a href='#'
						url='" . base_url() . "paket/destroy/" . $data->id . "/" . $data->is_deleted . "'
						class='btn btn-sm btn-danger white delete'> Hapus
						</a>";
				}

				$nestedData['id'] = $start + $key + 1;
				$nestedData['name'] = $data->name;
				$nestedData['pelayanan_name'] = $data->pelayanan_name;
				$nestedData['harga'] = $data->harga;
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
			$this->load->model("paket_model");
			$data = array(
				'is_deleted' => ($is_deleted == 1) ? 0 : 1,
			);
			$update = $this->paket_model->update($data, array("id" => $id));

			$response_data['data'] = $data;
			$response_data['msg'] = "Paket Berhasil di Hapus";
			$response_data['status'] = true;
		} else {
			$response_data['msg'] = "ID Harus Diisi";
		}

		echo json_encode($response_data);
	}
	
}
