<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'core/Admin_Controller.php';
class Unit_transfer extends Admin_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('unit_transfer_model');
		$this->load->model('unit_model');
		$this->load->model('location_model');
	}

	public function index() {

		$this->load->helper('url');
		if ($this->data['is_can_read']) {
			$this->data['content'] = 'admin/unit_transfer/list_v';
		} else {
			$this->data['content'] = 'errors/html/restrict';
		}

		$this->load->view('admin/layouts/page', $this->data);
	}

	public function create() {
		$this->form_validation->set_rules('unit_id', "Unit Harus Dipilih", 'trim|required');
		$this->form_validation->set_rules('from_location', "Dari Lokasi Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('to_location', "Ke Lokasi Harus Dipilih", 'trim|required');

		if ($this->form_validation->run() === TRUE) {
			$data = array(
				'unit_id' => $this->input->post('unit_id'),
				'from_location' => $this->input->post('from_location'),
				'to_location' => $this->input->post('to_location'),
				'created_at' => date('Y-m-d h:i:sa'),
				'created_by' => $this->data['users']->user_id,
				'is_deleted' => 0,
			);
			if ($this->input->post('from_location') == $this->input->post('to_location')) {
				$this->session->set_flashdata('message_error', "Transfer Unit Baru Gagal Disimpan");
				redirect("unit_transfer");
			} else {
				if ($this->unit_transfer_model->insert($data)) {
					$this->session->set_flashdata('message', "Transfer Unit Baru Berhasil Disimpan");
					redirect("unit_transfer");
				} else {
					$this->session->set_flashdata('message_error', "Transfer Unit Baru Gagal Disimpan");
					redirect("unit_transfer");
				}
			}
		} else {
			$this->data['content'] = 'admin/unit_transfer/create_v';
			$this->data['units'] = $this->unit_model->getAllById();
			$this->data['from_locations'] = $this->location_model->getAllById();
			$this->data['to_locations'] = $this->location_model->getAllById();
			$this->load->view('admin/layouts/page', $this->data);
		}
	}

	public function edit($id) {
		$this->form_validation->set_rules('unit_id', "Unit Harus Dipilih", 'trim|required');
		$this->form_validation->set_rules('from_location', "Dari Lokasi Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('to_location', "Ke Lokasi Harus Dipilih", 'trim|required');

		if ($this->form_validation->run() === TRUE) {
			$data = array(
				'unit_id' => $this->input->post('unit_id'),
				'from_location' => $this->input->post('from_location'),
				'to_location' => $this->input->post('to_location'),
				'created_at' => date('Y-m-d h:i:sa'),
				'created_by' => $this->data['users']->user_id,
			);
			$update = $this->unit_transfer_model->update($data, array("unit_transfer.id" => $id));
			if ($update) {
				$this->session->set_flashdata('message', "Transfer Unit Berhasil Diubah");
				redirect("unit_transfer", "refresh");
			} else {
				$this->session->set_flashdata('message_error', "Transfer Unit Gagal Diubah");
				redirect("unit_transfer", "refresh");
			}
		} else {
			if (!empty($_POST)) {
				$id = $this->input->post('id');
				$this->session->set_flashdata('message_error', validation_errors());
				return redirect("unit_transfer/edit/" . $id);
			} else {
				$this->data['id'] = $this->uri->segment(3);
				$unit_transfer = $this->unit_transfer_model->getAllById(array("unit_transfer.id" => $this->data['id']));
				$this->data['unit_id'] = (!empty($unit_transfer)) ? $unit_transfer[0]->unit_id : "";
				$this->data['from_location'] = (!empty($unit_transfer)) ? $unit_transfer[0]->from_location : "";
				$this->data['to_location'] = (!empty($unit_transfer)) ? $unit_transfer[0]->to_location : "";

				$this->data['units'] = $this->unit_model->getAllById();
				$this->data['from_locations'] = $this->location_model->getAllById();
				$this->data['to_locations'] = $this->location_model->getAllById();
				$this->data['content'] = 'admin/unit_transfer/edit_v';
				$this->load->view('admin/layouts/page', $this->data);
			}
		}

	}

	public function dataList() {

		$columns = array(
			0 => 'created_at',
			1 => 'unit.kode',
			2 => 'from_location',
			3 => 'to_location',
			4 => 'is_deleted',
			5 => '',
		);

		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];
		$search = array();
		$limit = 0;
		$start = 0;
		$totalData = $this->unit_transfer_model->getCountAllBy($limit, $start, $search, $order, $dir);

		if (!empty($this->input->post('search')['value'])) {
			$search_value = $this->input->post('search')['value'];
			$search = array(
				"unit_transfer.created_at" => $search_value,
				"unit.kode" => $search_value,
				"lokasi_awal.name" => $search_value,
				"lokasi_tujuan.name" => $search_value,
			);
			$totalFiltered = $this->unit_transfer_model->getCountAllBy($limit, $start, $search, $order, $dir);
		} else {
			$totalFiltered = $totalData;
		}

		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$datas = $this->unit_transfer_model->getAllBy($limit, $start, $search, $order, $dir);
		$new_data = array();
		if (!empty($datas)) {

			foreach ($datas as $key => $data) {

				$approval_url = "";
				$reject_url = "";
				if ($this->data['is_can_approval']) {
					if ($data->is_deleted == 0) {
						$approval_url = "<a href='#'
	        				url='" . base_url() . "unit_transfer/approval/" . $data->id . "/1/" . $data->unit_id . "'
	        				class='btn btn-success btn-sm white approval'> Diterima
	        				</a>";
						$reject_url = "<a href='#'
	        				url='" . base_url() . "unit_transfer/approval/" . $data->id . "/2/" . $data->unit_id . "'
	        				class='btn btn-danger btn-sm white approval'
	        				 > Tidak Diterima
	        				</a>";
					}
				}

				if ($data->is_deleted == 0) {
					$is_deleted = '<span class="badge badge-warning">Menunggu Diterima</span>';
				} else if ($data->is_deleted == 1) {
					$is_deleted = '<span class="badge badge-success">Diterima</span>';
				} else if ($data->is_deleted == 2) {
					$is_deleted = '<span class="badge badge-danger">Tidak Diterima</span>';
				} else {
					$is_deleted = '<span class="badge badge-secondary">Riwayat Pindahkan</span>';
				}

				$nestedData['created_at'] = $data->created_at;
				$nestedData['unit_name'] = $data->unit_name . " - " . $data->unit_brand_name . " - " . $data->unit_model_name;
				$nestedData['from'] = $data->from;
				$nestedData['to'] = $data->to;
				$nestedData['is_deleted'] = $is_deleted;
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
		$unit_id = $this->uri->segment(5);

		if (!empty($id)) {
			$data = array(
				'is_deleted' => $is_approved,
			);
			$approval = $this->unit_transfer_model->update($data, array("id" => $id));

			if ($is_approved == 1) {
				$data_update = [
					'is_deleted' => 3,
				];
				$update_data = $this->unit_transfer_model->update($data_update, ["unit_id" => $unit_id, "id !=" => $id, "is_deleted <=" => 1]);
			}
			$response_data['data'] = $data;
			$response_data['status'] = true;
		} else {
			$response_data['msg'] = "ID Harus Diisi";
		}

		echo json_encode($response_data);
	}

	public function get_transfer() {
		$unit_id = $this->input->post('unit_id');
		$return_data = array(
			"status" => false,
			"message" => "",
			"data" => array(),
		);

		$data = $this->unit_transfer_model->getOneBy(array("unit_transfer.unit_id" => $unit_id));

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
