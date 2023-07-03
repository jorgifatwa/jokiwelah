<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'core/Admin_Controller.php';
class Joki extends Admin_Controller 
{
	public function __construct() 
	{
		parent::__construct();
		$this->load->model('joki_model');
	}

	public function index() 
	{
		$this->load->helper('url');
		if ($this->data['is_can_read']) {
			$this->data['content'] = 'admin/joki/list_v';
		} else {
			$this->data['content'] = 'errors/html/restrict';
		}

		$this->load->view('admin/layouts/page', $this->data);
	}

	public function create() 
	{
		$this->form_validation->set_rules('name', "Nama Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('nomor_whatsapp', "Nomor Whatsapp Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('email',"Email", 'trim|required');  
		$this->form_validation->set_rules('name',"Nama", 'trim|required'); 
		$this->form_validation->set_rules('password',"Password", 'trim|required');
		
		if ($this->form_validation->run() === TRUE) {
			$data = array(
				'name' => $this->input->post('name'),
				'nomor_whatsapp' => $this->input->post('nomor_whatsapp'),
			);

			$data2 = array(
				'first_name' => $this->input->post('name'),
				'address' => $this->input->post('address'),
				'active' => 1,
				'email' => $this->input->post('email'),
				'phone' => $this->input->post('phone'),
				'is_deleted' => 0
			); 
			$role = array(3);  
 			$username = '';
 			$password = $this->input->post('password');
 			$email = $this->input->post('email');

			$id = $this->ion_auth->register($username, $password, $email, $data2,$role);

			$data['id_user'] = $id;

			if ($this->joki_model->insert($data)) {
				$this->session->set_flashdata('message', "joki Baru Berhasil Disimpan");
				redirect("joki");
			} else {
				$this->session->set_flashdata('message_error', "joki Baru Gagal Disimpan");
				redirect("joki");
			}
		} else {
			$this->data['content'] = 'admin/joki/create_v';
			$this->load->view('admin/layouts/page', $this->data);
		}
	}

	public function edit($id) 
	{
		$this->form_validation->set_rules('name', "Name Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('nomor_whatsapp', "Nomor Whatsapp Harus Diisi", 'trim|required');

		if ($this->form_validation->run() === TRUE) {
			$data = array(
				'name' => $this->input->post('name'),
				'nomor_whatsapp' => $this->input->post('nomor_whatsapp'),
			);
			$update = $this->joki_model->update($data, array("joki.id" => $id));
			if ($update) {
				$this->session->set_flashdata('message', "joki Berhasil Diubah");
				redirect("joki", "refresh");
			} else {
				$this->session->set_flashdata('message_error', "joki Gagal Diubah");
				redirect("joki", "refresh");
			}
		} else {
			if (!empty($_POST)) {
				$id = $this->input->post('id');
				$this->session->set_flashdata('message_error', validation_errors());
				return redirect("joki/edit/" . $id);
			} else {
				$this->data['id'] = $this->uri->segment(3);
				$where_joki = [
					"joki.id" => $this->data['id'],
				];
				$joki = $this->joki_model->getAllById($where_joki);
				$this->data['name'] = (!empty($joki)) ? $joki[0]->name : "";
				$this->data['nomor_whatsapp'] = (!empty($joki)) ? $joki[0]->nomor_whatsapp : "";

				$this->data['content'] = 'admin/joki/edit_v';
				$this->load->view('admin/layouts/page', $this->data);
			}
		}

	}

	public function dataList() 
	{
		$columns = array(
			0 => 'name',
			1 => 'nomor_whatsapp',
			2 => '',
		);

		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];
		$search = array();
		$limit = 0;
		$start = 0;
		$totalData = $this->joki_model->getCountAllBy($limit, $start, $search, $order, $dir);

		if (!empty($this->input->post('search')['value'])) {
			$search_value = $this->input->post('search')['value'];
			$search = array(
				"joki.name" => $search_value,
				"joki.nomor_whatsapp" => $search_value,
			);
			$totalFiltered = $this->joki_model->getCountAllBy($limit, $start, $search, $order, $dir);
		} else {
			$totalFiltered = $totalData;
		}

		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$datas = $this->joki_model->getAllBy($limit, $start, $search, $order, $dir);

		$new_data = array();
		if (!empty($datas)) {

			foreach ($datas as $key => $data) {
				$edit_url = "";
				$delete_url = "";

				if ($this->data['is_can_edit'] && $data->is_deleted == 0) {
					$edit_url = "<a href='" . base_url() . "joki/edit/" . $data->id . "' class='btn btn-sm btn-info white'> Ubah</a>";
				}
				if ($this->data['is_can_delete']) {
					$delete_url = "<a href='#'
						url='" . base_url() . "joki/destroy/" . $data->id . "/" . $data->is_deleted . "'
						class='btn btn-sm btn-danger white delete'> Hapus
						</a>";
				}

				$nestedData['id'] = $start + $key + 1;
				$nestedData['name'] = $data->name;
				$nestedData['nomor_whatsapp'] = $data->nomor_whatsapp;
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
			$this->load->model("joki_model");
			$data = array(
				'is_deleted' => ($is_deleted == 1) ? 0 : 1,
			);
			$update = $this->joki_model->update($data, array("id" => $id));

			$response_data['data'] = $data;
			$response_data['msg'] = "joki Berhasil di Hapus";
			$response_data['status'] = true;
		} else {
			$response_data['msg'] = "ID Harus Diisi";
		}

		echo json_encode($response_data);
	}
}
