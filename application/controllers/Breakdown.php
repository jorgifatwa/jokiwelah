<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'core/Admin_Controller.php';
class Breakdown extends Admin_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('breakdown_model');
		$this->load->model('unit_model');
		$this->load->model('ob_actual_model');
		$this->load->model('user_mutation_model');
	}

	public function index() {

		$this->load->helper('url');
		if ($this->data['is_can_read']) {
			$this->data['content'] = 'admin/breakdown/list_v';
		} else {
			$this->data['content'] = 'errors/html/restrict';
		}
		$location_id = $this->user_mutation_model->getLastLocation($this->data['users']->id);

		$where_unit = [
			'unit_transfer.to_location' => $location_id,
		];
		$this->data['loading_unit'] = $this->unit_model->getAllByLocation($where_unit);

		$this->data['job_status'] = $this->ob_actual_model->select_box_data('enum_breakdown_job_status');
		$this->data['locations'] = $this->ob_actual_model->select_box_data('location');
		$this->load->view('admin/layouts/page', $this->data);
	}

	public function create() {
		$this->form_validation->set_rules('tanggal_bd', "Tanggal Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('loading_unit_id', "Loading Unit Harus Dipilih", 'trim|required');
		$this->form_validation->set_rules('job_status_id', "Status Pekerjaan Harus Dipilih", 'trim|required');
		$this->form_validation->set_rules('trouble_description', "Deskripsi Masalah Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('location_id', "Lokasi Harus Diisi", 'trim|required');

		if ($this->form_validation->run() === TRUE) {
			$tanggal = date("Y-m-d", strtotime($this->input->post("tanggal_bd")));

			$data = array(
				'tanggal_bd' => $tanggal,
				'unit_id' => $this->input->post('loading_unit_id'),
				'job_status_id' => $this->input->post('job_status_id'),
				'trouble' => $this->input->post('trouble_description'),
				'location_id' => $this->input->post('location_id'),
			);
			if ($this->breakdown_model->insert($data)) {
				$this->session->set_flashdata('message', "Breakdown Baru Berhasil Disimpan");
				redirect("breakdown");
			} else {
				$this->session->set_flashdata('message_error', "Breakdown Baru Gagal Disimpan");
				redirect("breakdown");
			}
		} else {
			$this->data['content'] = 'admin/breakdown/create_v';
			$this->data['loading_unit'] = $this->unit_model->getAll();
			$this->data['job_status'] = $this->ob_actual_model->select_box_data('enum_breakdown_job_status');
			$this->data['locations'] = $this->ob_actual_model->select_box_data('location');
			$this->load->view('admin/layouts/page', $this->data);
		}
	}

	public function edit($id) {
		$this->form_validation->set_rules('tanggal_bd', "Tanggal Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('loading_unit_id', "Loading Unit Harus Dipilih", 'trim|required');
		$this->form_validation->set_rules('job_status_id', "Status Pekerjaan Harus Dipilih", 'trim|required');
		$this->form_validation->set_rules('trouble_description', "Deskripsi Masalah Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('location_id', "Lokasi Harus Diisi", 'trim|required');

		if ($this->form_validation->run() === TRUE) {
			$tanggal = date("Y-m-d", strtotime($this->input->post("tanggal_bd")));

			$data = array(
				'tanggal_bd' => $tanggal,
				'unit_id' => $this->input->post('loading_unit_id'),
				'job_status_id' => $this->input->post('job_status_id'),
				'trouble' => $this->input->post('trouble_description'),
				'location_id' => $this->input->post('location_id'),
			);
			$update = $this->breakdown_model->update($data, array("breakdown.id" => $id));
			if ($update) {
				$this->session->set_flashdata('message', "Breakdown Berhasil Diubah");
				redirect("breakdown", "refresh");
			} else {
				$this->session->set_flashdata('message_error', "Breakdown Gagal Diubah");
				redirect("breakdown", "refresh");
			}
		} else {
			if (!empty($_POST)) {
				$id = $this->input->post('id');
				$this->session->set_flashdata('message_error', validation_errors());
				return redirect("breakdown/edit/" . $id);
			} else {
				$this->data['id'] = $this->uri->segment(3);
				$breakdown = $this->breakdown_model->getAllById(array("breakdown.id" => $this->data['id']));
				$this->data['tanggal_bd'] = (!empty($breakdown)) ? $breakdown[0]->tanggal_bd : "";
				$this->data['unit_id'] = (!empty($breakdown)) ? $breakdown[0]->unit_id : "";
				$this->data['job_status_id'] = (!empty($breakdown)) ? $breakdown[0]->job_status_id : "";
				$this->data['trouble'] = (!empty($breakdown)) ? $breakdown[0]->trouble : "";
				$this->data['location_id'] = (!empty($breakdown)) ? $breakdown[0]->location_id : "";
				$where_unit = [
					'unit_transfer.to_location' => $this->data['location_id'],
				];
				$this->data['loading_unit'] = $this->unit_model->getAllByLocation($where_unit);
				$this->data['job_status'] = $this->ob_actual_model->select_box_data('enum_breakdown_job_status');
				$this->data['locations'] = $this->ob_actual_model->select_box_data('location');
				$this->data['content'] = 'admin/breakdown/edit_v';
				$this->load->view('admin/layouts/page', $this->data);
			}
		}

	}

	public function activity($id) {
		$this->data['id'] = $this->uri->segment(3);
		$this->data['content'] = 'admin/activity/list_v';
		$this->load->view('admin/layouts/page', $this->data);
	}

	public function dataList() {

		$columns = array(
			0 => 'tanggal_bd',
			1 => 'loading_unit_name',
			2 => 'job_status_name',
			3 => 'trouble_description',
			4 => 'location_name',
			5 => 'action',
			6 => '',
		);

		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];
		$search = array();
		$limit = 0;
		$start = 0;
		$totalData = $this->breakdown_model->getCountAllBy($limit, $start, $search, $order, $dir);

		if (!empty($this->input->post('search')['value'])) {
			$search_value = $this->input->post('search')['value'];
			$search = array(
				"breakdown.tanggal_bd" => $search_value,
				"loading_unit.name" => $search_value,
				"enum_job_status.name" => $search_value,
				"breakdown.trouble_description" => $search_value,
				"location.name" => $search_value,
			);
			$totalFiltered = $this->breakdown_model->getCountAllBy($limit, $start, $search, $order, $dir);
		} else {
			$totalFiltered = $totalData;
		}

		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$datas = $this->breakdown_model->getAllBy($limit, $start, $search, $order, $dir);

		$new_data = array();
		if (!empty($datas)) {

			foreach ($datas as $key => $data) {

				$edit_url = "";
				$delete_url = "";

				if ($this->data['is_can_edit'] && $data->is_deleted == 0) {
					$edit_url = "<a href='" . base_url() . "breakdown/edit/" . $data->id . "' class='btn btn-sm btn-info white'><i class='fa fa-pencil'></i> Ubah</a>";
				}
				if ($this->data['is_can_delete']) {
					$delete_url = "<a href='#'
						url='" . base_url() . "breakdown/destroy/" . $data->id . "/" . $data->is_deleted . "'
						class='btn btn-sm btn-danger white delete'><span class='fa fa-trash'></span> Hapus
						</a>";
				}

				$activity_url = "<a href='" . base_url() . "breakdown/activity/" . $data->id . "' class='btn btn-sm btn-primary white'>Aktivitas</a>";

				$nestedData['id'] = $start + $key + 1;
				$nestedData['tanggal'] = $data->tanggal_bd;
				$nestedData['loading_unit_name'] = $data->loading_unit_name;
				$nestedData['job_status_name'] = $data->job_status_name . "-" . $data->job_description;
				$nestedData['trouble'] = $data->trouble;
				$nestedData['location_name'] = $data->location_name;
				$nestedData['action'] = $activity_url . " " . $edit_url . " " . $delete_url;
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
			$this->load->model("breakdown_model");
			$data = array(
				'is_deleted' => ($is_deleted == 1) ? 0 : 1,
			);
			$update = $this->breakdown_model->update($data, array("id" => $id));

			$response_data['data'] = $data;
			$response_data['msg'] = "Breakdown Berhasil di Hapus";
			$response_data['status'] = true;
		} else {
			$response_data['msg'] = "ID Harus Diisi";
		}

		echo json_encode($response_data);
	}

	public function get_data_fleet_reason() {
		$response_data = array();
		$response_data['status'] = false;
		$response_data['msg'] = "";
		$response_data['data'] = array();
		$id = $this->input->post('id');

		$data = $this->breakdown_model->getReasonData(array("enum_fleet_reason.fleet_status_id" => $id));

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
