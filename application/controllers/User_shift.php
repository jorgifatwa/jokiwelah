<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'core/Admin_Controller.php';
class User_shift extends Admin_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('user_shift_model');
		$this->load->model('user_model');
		$this->load->model('enum_shift_model');
	}

	public function index() {

		$this->load->helper('url');
		if ($this->data['is_can_read']) {
			$this->data['content'] = 'admin/user_shift/list_v';
		} else {
			$this->data['content'] = 'errors/html/restrict';
		}

		$this->load->view('admin/layouts/page', $this->data);
	}

	public function create() {
		$this->form_validation->set_rules('shift_id', "Shift Harus Diisi", 'trim|required');

		if ($this->form_validation->run() === TRUE) {
			$user_id = implode(',', $this->input->post('user_id'));
			$data = array(
				'shift_id' => $this->input->post('shift_id'),
				'user_id' => $user_id,
				'description' => "",
			);
			if ($this->user_shift_model->insert($data)) {
				$this->session->set_flashdata('message', "Shift Kerja Baru Berhasil Disimpan");
				redirect("user_shift");
			} else {
				$this->session->set_flashdata('message_error', "Shift Kerja Baru Gagal Disimpan");
				redirect("user_shift");
			}
		} else {
			$this->data['shift'] = $this->enum_shift_model->getAllById();
			$this->data['user'] = $this->user_model->getAllById();
			$this->data['content'] = 'admin/user_shift/create_v';
			$this->load->view('admin/layouts/page', $this->data);
		}
	}

	public function edit() {
		$this->form_validation->set_rules('shift_id', "Shift Harus Diisi", 'trim|required');

		if ($this->form_validation->run() === TRUE) {
			$user_id = implode(',', $this->input->post('user_id'));
			$data = array(
				'shift_id' => $this->input->post('shift_id'),
				'user_id' => $user_id,
				'description' => "",
			);
			$update = $this->user_shift_model->update($data, array("user_shift.id" => $this->input->post('id')));
			if ($update) {
				$this->session->set_flashdata('message', "Shift Kerja Berhasil Diubah");
				redirect("user_shift", "refresh");
			} else {
				$this->session->set_flashdata('message_error', "Shift Kerja Gagal Diubah");
				redirect("user_shift", "refresh");
			}
		} else {
			if (!empty($_POST)) {
				$id = $this->input->post('id');
				$this->session->set_flashdata('message_error', validation_errors());
				return redirect("user_shift/edit/" . $id);
			} else {
				$this->data['id'] = $this->uri->segment(3);
				$user_shift = $this->user_shift_model->getAllById(array("user_shift.id" => $this->data['id']));
				$this->data['description'] = (!empty($user_shift)) ? $user_shift[0]->description : "";
				$this->data['shift_id'] = (!empty($user_shift)) ? $user_shift[0]->shift_id : "";
				$user_id = (!empty($user_shift)) ? $user_shift[0]->user_id : "";
				$this->data['user_id'] = explode(',', $user_id);
				$this->data['shift'] = $this->enum_shift_model->getAllById();
				$this->data['user'] = $this->user_model->getAllById();

				$this->data['content'] = 'admin/user_shift/edit_v';
				$this->load->view('admin/layouts/page', $this->data);
			}
		}

	}

	public function dataList() {

		$columns = array(
			0 => 'id',
			1 => 'shift_name',
			2 => 'user_name',
			3 => 'description',
			4 => '',
		);

		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];
		$search = array();
		$limit = 0;
		$start = 0;
		$totalData = $this->user_shift_model->getCountAllBy($limit, $start, $search, $order, $dir);

		if (!empty($this->input->post('search')['value'])) {
			$search_value = $this->input->post('search')['value'];
			$search = array(
				"shift.name" => $search_value,
				"user.name" => $search_value,
				"user_shift.description" => $search_value,
			);
			$totalFiltered = $this->user_shift_model->getCountAllBy($limit, $start, $search, $order, $dir);
		} else {
			$totalFiltered = $totalData;
		}

		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$datas = $this->user_shift_model->getAllBy($limit, $start, $search, $order, $dir);

		$new_data = array();
		if (!empty($datas)) {

			foreach ($datas as $key => $data) {

				$edit_url = "";
				$delete_url = "";

				if ($this->data['is_can_edit'] && $data->is_deleted == 0) {
					$edit_url = "<a href='" . base_url() . "user_shift/edit/" . $data->id . "' class='btn btn-sm btn-info white'> Ubah</a>";
				}
				if ($this->data['is_can_delete']) {
					$delete_url = "<a href='#'
						url='" . base_url() . "user_shift/destroy/" . $data->id . "/" . $data->is_deleted . "'
						class='btn btn-sm btn-danger white remove'> Hapus
						</a>";
				}

				$nestedData['id'] = $start + $key + 1;
				$nestedData['shift_name'] = $data->shift_name;

				$user_data = explode(',', $data->user_id);
				$data_user = [];
				for ($i = 0; $i < count($user_data); $i++) {
					$users = $this->user_model->getOneBy(array('users.id' => $user_data[$i]));
					$data_user[$i] = $users->first_name;
				}

				$user_name = implode(',', $data_user);

				$nestedData['user_name'] = $user_name;
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
			$this->load->model("user_shift_model");
			$data = array(
				'is_deleted' => ($is_deleted == 1) ? 0 : 1,
			);
			$update = $this->user_shift_model->update($data, array("id" => $id));

			$response_data['data'] = $data;
			$response_data['msg'] = "Shift Kerja Berhasil di Hapus";
			$response_data['status'] = true;
		} else {
			$response_data['msg'] = "ID Harus Diisi";
		}

		echo json_encode($response_data);
	}
}
