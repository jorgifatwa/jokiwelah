<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'core/Admin_Controller.php';
class User_mutation extends Admin_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('user_mutation_model');
		$this->load->model('user_model');
		$this->load->model('location_model');
	}

	public function index() {

		$this->load->helper('url');
		if ($this->data['is_can_read']) {
			$this->data['content'] = 'admin/user_mutation/list_v';
		} else {
			$this->data['content'] = 'errors/html/restrict';
		}

		$this->load->view('admin/layouts/page', $this->data);
	}

	public function create() {
		$this->form_validation->set_rules('user_id', "User Harud Dipilih", 'trim|required');
		$this->form_validation->set_rules('from_location', "Dari Lokasi Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('to_location', "Ke Lokasi Harus Dipilih", 'trim|required');

		if ($this->form_validation->run() === TRUE) {
			$data = array(
				'user_id' => $this->input->post('user_id'),
				'from_location' => $this->input->post('from_location'),
				'to_location' => $this->input->post('to_location'),
				'created_at' => date('Y-m-d H:i:sa'),
				'created_by' => $this->data['users']->user_id,
				'status' => 0,
			);

			if ($this->input->post('from_location') == $this->input->post('to_location')) {
				$this->session->set_flashdata('message_error', "Mutasi Pengguna Baru Gagal Disimpan");
				redirect("user_mutation");
			} else {
				if ($this->user_mutation_model->insert($data)) {
					$this->session->set_flashdata('message', "Mutasi Pengguna Baru Berhasil Disimpan");
					redirect("user_mutation");
				} else {
					$this->session->set_flashdata('message_error', "Mutasi Pengguna Baru Gagal Disimpan");
					redirect("user_mutation");
				}

			}
		} else {
			$this->data['content'] = 'admin/user_mutation/create_v';
			$this->data['data_user'] = $this->user_model->getAllById();
			$this->data['from_locations'] = $this->location_model->getAllById();
			$this->data['to_locations'] = $this->location_model->getAllById();
			$this->load->view('admin/layouts/page', $this->data);
		}
	}

	public function edit($id) {
		$this->form_validation->set_rules('user_id', "User Harud Dipilih", 'trim|required');
		$this->form_validation->set_rules('from_location', "Dari Lokasi Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('to_location', "Ke Lokasi Harus Dipilih", 'trim|required');

		if ($this->form_validation->run() === TRUE) {
			$data = array(
				'user_id' => $this->input->post('user_id'),
				'from_location' => $this->input->post('from_location'),
				'to_location' => $this->input->post('to_location'),
				'created_at' => date('Y-m-d h:i:sa'),
				'created_by' => $this->data['users']->user_id,
			);
			$update = $this->user_mutation_model->update($data, array("user_mutation.id" => $id));
			if ($update) {
				$this->session->set_flashdata('message', "Mutasi Pengguna Berhasil Diubah");
				redirect("user_mutation", "refresh");
			} else {
				$this->session->set_flashdata('message_error', "Mutasi Pengguna Gagal Diubah");
				redirect("user_mutation", "refresh");
			}
		} else {
			if (!empty($_POST)) {
				$id = $this->input->post('id');
				$this->session->set_flashdata('message_error', validation_errors());
				return redirect("user_mutation/edit/" . $id);
			} else {
				$this->data['id'] = $this->uri->segment(3);
				$user_mutation = $this->user_mutation_model->getAllById(array("user_mutation.id" => $this->data['id']));
				$this->data['user_id'] = (!empty($user_mutation)) ? $user_mutation[0]->user_id : "";
				$this->data['from_location'] = (!empty($user_mutation)) ? $user_mutation[0]->from_location : "";
				$this->data['to_location'] = (!empty($user_mutation)) ? $user_mutation[0]->to_location : "";

				$this->data['data_user'] = $this->user_model->getAllById();
				$this->data['from_locations'] = $this->location_model->getAllById();
				$this->data['to_locations'] = $this->location_model->getAllById();
				$this->data['content'] = 'admin/user_mutation/edit_v';
				$this->load->view('admin/layouts/page', $this->data);
			}
		}

	}

	public function dataList() {

		$columns = array(
			0 => 'created_at',
			1 => 'users.first_name',
			2 => 'from_location',
			3 => 'to_location',
			4 => 'status',
			5 => '',
		);

		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];
		$search = array();
		$limit = 0;
		$start = 0;
		$totalData = $this->user_mutation_model->getCountAllBy($limit, $start, $search, $order, $dir);
		if (!empty($this->input->post('search')['value'])) {
			$search_value = $this->input->post('search')['value'];
			$search = array(
				"user_mutation.created_at" => $search_value,
				"users.first_name" => $search_value,
				"users.nik" => $search_value,
				"roles.name" => $search_value,
				"lokasi_awal.name" => $search_value,
				"lokasi_tujuan.name" => $search_value,
			);
			$totalFiltered = $this->user_mutation_model->getCountAllBy($limit, $start, $search, $order, $dir);
		} else {
			$totalFiltered = $totalData;
		}

		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$datas = $this->user_mutation_model->getAllBy($limit, $start, $search, $order, $dir);
		$new_data = array();

		if (!empty($datas)) {

			foreach ($datas as $key => $data) {
				$approval_url = "";
				$reject_url = "";
				if ($this->data['is_can_approval']) {
					if ($data->status == 0) {
						$approval_url = "<a href='#'
	        				url='" . base_url() . "user_mutation/approval/" . $data->id . "/1/" . $data->user_id . "'
	        				class='btn btn-success btn-sm white approval'> Setuju
	        				</a>";
						$reject_url = "<a href='#'
	        				url='" . base_url() . "user_mutation/approval/" . $data->id . "/2/" . $data->user_id . "'
	        				class='btn btn-danger btn-sm white approval'
	        				 > Tolak
	        				</a>";
					}
				}

				if ($data->status == 0) {
					$status = '<span class="badge badge-warning">Menunggu Persetujuan</span>';
				} else if ($data->status == 1) {
					$status = '<span class="badge badge-success">Disetujui</span>';
				} else if ($data->status == 2) {
					$status = '<span class="badge badge-danger">Ditolak</span>';
				} else {
					$status = '<span class="badge badge-secondary">Riwayat Pindahkan</span>';
				}

				$nestedData['created_at'] = $data->created_at;
				$nestedData['user_name'] = $data->nik . " - " . $data->user_name . " (" . $data->roles_name . ")";
				$nestedData['from'] = $data->from;
				$nestedData['to'] = $data->to;
				$nestedData['status'] = $status;
				$nestedData['action'] = $approval_url . " " . $reject_url;
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

	public function approval() {
		$response_data = array();
		$response_data['status'] = false;
		$response_data['msg'] = "";
		$response_data['data'] = array();

		$id = $this->uri->segment(3);
		$is_approved = $this->uri->segment(4);
		$user_id = $this->uri->segment(5);

		if (!empty($id)) {
			$data = array(
				'status' => $is_approved,
			);
			$approval = $this->user_mutation_model->update($data, array("id" => $id));

			if ($is_approved == 1) {
				$data_update = [
					'status' => 3,
				];
				$update_data = $this->user_mutation_model->update($data_update, ["user_id" => $user_id, "id !=" => $id, "status <=" => 1]);
			}
			$response_data['data'] = $data;
			$response_data['status'] = true;
		} else {
			$response_data['msg'] = "ID Harus Diisi";
		}

		echo json_encode($response_data);
	}

	public function get_mutation() {
		$user_id = $this->input->post('user_id');
		$return_data = array(
			"status" => false,
			"message" => "",
			"data" => array(),
		);

		$data = $this->user_mutation_model->getOneBy(array("user_mutation.user_id" => $user_id));

		if ($data) {
			$return_data['data'] = $data;
			$return_data['status'] = true;
			$return_data['message'] = "Berhasil mengambil data!";
		} else {
			$return_data['status'] = false;
			$return_data['message'] = "Gagal mengambil data!";
		}

		echo json_encode($return_data);
	}
}
