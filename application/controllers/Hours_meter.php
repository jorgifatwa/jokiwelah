<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'core/Admin_Controller.php';
class Hours_meter extends Admin_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('hours_meter_model');
		$this->load->model('unit_model');
		$this->load->model('ob_actual_model');
		$this->load->model('location_model');
	}

	public function index() {

		$this->load->helper('url');
		if ($this->data['is_can_read']) {
			$this->data['content'] = 'admin/hours_meter/list_v';
		} else {
			$this->data['content'] = 'errors/html/restrict';
		}

		$this->load->view('admin/layouts/page', $this->data);
	}

	public function create() {
		$this->form_validation->set_rules('tanggal', "Tanggal Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('shift_id', "Shift Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('hm_start', "Waktu Mulai Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('hm_end', "Waktu Berakhir Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('operator_id', "Operator Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('duration', "Durasi Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('location_id', "Lokasi Harus Dipilih", 'trim|required');

		if ($this->form_validation->run() === TRUE) {
			$week = $this->input->post('week');
			if ($week == "on") {
				$week = "Holiday";
			} else {
				$date = $this->input->post('tanggal');
				$week = "Week " . $this->weekOfMonth(strtotime($date));
			}

			$tanggal = date("Y-m-d", strtotime($this->input->post("tanggal")));

			$data = array(
				'tanggal' => $tanggal,
				'shift_id' => $this->input->post('shift_id'),
				'unit_id' => $this->input->post('unit_id'),
				'operator_id' => $this->input->post('operator_id'),
				'hm_start' => $this->input->post('hm_start'),
				'hm_end' => $this->input->post('hm_end'),
				'duration' => $this->input->post('duration'),
				'remarks' => $this->input->post('remarks'),
				'location_id' => $this->input->post('location_id'),
				'week' => $week,
				'created_at' => date('Y-m-d h:i:sa'),
				'created_by' => $this->data['users']->user_id,
			);
			if ($this->hours_meter_model->insert($data)) {
				$this->session->set_flashdata('message', "Hours Meter Baru Berhasil Disimpan");
				redirect("hours_meter");
			} else {
				$this->session->set_flashdata('message_error', "Hours Meter Baru Gagal Disimpan");
				redirect("hours_meter");
			}
		} else {
			$this->data['content'] = 'admin/hours_meter/create_v';
			$this->data['locations'] = $this->location_model->getAllById();
			$this->data['loaders'] = $this->ob_actual_model->select_box_data('loader_model');
			$this->data['shifts'] = $this->ob_actual_model->select_box_data('enum_shift');
			$this->data['operators'] = $this->ob_actual_model->select_box_data('users');
			$this->load->view('admin/layouts/page', $this->data);
		}
	}

	public function edit($id) {
		$this->form_validation->set_rules('tanggal', "Tanggal Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('shift_id', "Shift Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('hm_start', "Waktu Mulai Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('hm_end', "Waktu Berakhir Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('operator_id', "Operator Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('duration', "Durasi Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('location_id', "Lokasi Harus Dipilih", 'trim|required');

		if ($this->form_validation->run() === TRUE) {
			$week = $this->input->post('week');
			if ($week == "on") {
				$week = "Holiday";
			} else {
				$date = $this->input->post('tanggal');
				$week = "Week " . $this->weekOfMonth(strtotime($date));
			}

			$tanggal = date("Y-m-d", strtotime($this->input->post("tanggal")));

			$data = array(
				'tanggal' => $tanggal,
				'shift_id' => $this->input->post('shift_id'),
				'unit_id' => $this->input->post('unit_id'),
				'operator_id' => $this->input->post('operator_id'),
				'hm_start' => $this->input->post('hm_start'),
				'hm_end' => $this->input->post('hm_end'),
				'duration' => $this->input->post('duration'),
				'remarks' => $this->input->post('remarks'),
				'location_id' => $this->input->post('location_id'),
				'week' => $week,
				'created_at' => date('Y-m-d h:i:sa'),
				'created_by' => $this->data['users']->user_id,
			);
			$update = $this->hours_meter_model->update($data, array("hours_meter.id" => $id));
			if ($update) {
				$this->session->set_flashdata('message', "Hours Meter Berhasil Diubah");
				redirect("hours_meter", "refresh");
			} else {
				$this->session->set_flashdata('message_error', "Hours Meter Gagal Diubah");
				redirect("hours_meter", "refresh");
			}
		} else {
			if (!empty($_POST)) {
				$id = $this->input->post('id');
				$this->session->set_flashdata('message_error', validation_errors());
				return redirect("hours_meter/edit/" . $id);
			} else {
				$this->data['id'] = $this->uri->segment(3);
				$hours_meter = $this->hours_meter_model->getAllById(array("hours_meter.id" => $this->data['id']));
				$this->data['tanggal'] = (!empty($hours_meter)) ? $hours_meter[0]->tanggal : "";
				$this->data['shift_id'] = (!empty($hours_meter)) ? $hours_meter[0]->shift_id : "";
				$this->data['unit_id'] = (!empty($hours_meter)) ? $hours_meter[0]->unit_id : "";
				$this->data['operator_id'] = (!empty($hours_meter)) ? $hours_meter[0]->operator_id : "";
				$this->data['hm_start'] = (!empty($hours_meter)) ? $hours_meter[0]->hm_start : "";
				$this->data['hm_end'] = (!empty($hours_meter)) ? $hours_meter[0]->hm_end : "";
				$this->data['duration'] = (!empty($hours_meter)) ? $hours_meter[0]->duration : "";
				$this->data['remarks'] = (!empty($hours_meter)) ? $hours_meter[0]->remarks : "";
				$this->data['location_id'] = (!empty($hours_meter)) ? $hours_meter[0]->location_id : "";
				$where_unit = [
					'unit_transfer.to_location' => $this->data['location_id'],
				];
				$this->data['loading_unit'] = $this->unit_model->getAllByLocation($where_unit);
				$this->data['week'] = (!empty($hours_meter)) ? $hours_meter[0]->week : "";
				$this->data['locations'] = $this->location_model->getAllById();
				$this->data['loaders'] = $this->ob_actual_model->select_box_data('loader_model');
				$this->data['shifts'] = $this->ob_actual_model->select_box_data('enum_shift');
				$this->data['operators'] = $this->ob_actual_model->select_box_data('users');
				$this->data['content'] = 'admin/hours_meter/edit_v';
				$this->load->view('admin/layouts/page', $this->data);
			}
		}

	}

	public function dataList() {

		$columns = array(
			0 => 'tanggal',
			1 => 'shift_name',
			2 => 'unit_name',
			3 => 'operator_name',
			4 => 'hm_start',
			5 => 'hm_end',
			6 => 'duration',
			7 => 'location_name',
			8 => 'week',
			9 => '',
		);

		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];
		$search = array();
		$where = array();
		$limit = 0;
		$start = 0;

		$totalData = $this->hours_meter_model->getCountAllBy($limit, $start, $search, $order, $dir, $where);
		$searchColumn = $this->input->post('columns');
		$filtered = false;

		if (!empty($searchColumn[1]['search']['value'])) {
			$value = $searchColumn[1]['search']['value'];
			$where['hours_meter.unit_id'] = $value;
			$filtered = true;
		}

		if (!empty($searchColumn[3]['search']['value'])) {
			$value = $searchColumn[3]['search']['value'];
			$where['hours_meter.shift_id'] = $value;

			$filtered = true;
		}

		if (!empty($searchColumn[4]['search']['value'])) {
			$value = $searchColumn[4]['search']['value'];
			$where['hours_meter.location_id'] = $value;

			$filtered = true;
		}

		if (!empty($searchColumn[5]['search']['value'])) {
			$value = $searchColumn[5]['search']['value'];
			$where['hours_meter.tanggal >= '] = date("Y-m-d", strtotime($value));

			$filtered = true;
		}

		if (!empty($searchColumn[6]['search']['value'])) {
			$value = $searchColumn[6]['search']['value'];
			$where['hours_meter.tanggal <= '] = date("Y-m-d", strtotime($value));

			$filtered = true;
		}

		if (!empty($this->input->post('search')['value'])) {
			$search_value = $this->input->post('search')['value'];
			$search = array(
				"hours_meter.tanggal" => $search_value,
				"unit.kode" => $search_value,
				"users.first_name" => $search_value,
				"hours_meter.hm_start" => $search_value,
				"hours_meter.hm_end" => $search_value,
				"hours_meter.duration" => $search_value,
				"hours_meter.remarks" => $search_value,
				"location.name" => $search_value,
				"shift.name" => $search_value,
				"hours_meter.week" => $search_value,
			);
			$filtered = true;
		}

		if ($filtered) {
			$totalFiltered = $this->hours_meter_model->getCountAllBy($limit, $start, $search, $order, $dir, $where);

		} else {
			$totalFiltered = $totalData;
		}

		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$datas = $this->hours_meter_model->getAllBy($limit, $start, $search, $order, $dir, $where);

		$new_data = array();
		if (!empty($datas)) {

			foreach ($datas as $key => $data) {

				$edit_url = "";
				$delete_url = "";

				if ($this->data['is_can_edit'] && $data->is_deleted == 0) {
					$edit_url = "<a href='" . base_url() . "hours_meter/edit/" . $data->id . "' class='btn btn-sm btn-info white'><i class='fa fa-pencil'></i> Ubah</a>";
				}
				if ($this->data['is_can_delete']) {
					$delete_url = "<a href='#'
						url='" . base_url() . "hours_meter/destroy/" . $data->id . "/" . $data->is_deleted . "'
						class='btn btn-sm btn-danger white delete'><span class='fa fa-trash'></span> Hapus
						</a>";
				}

				$nestedData['id'] = $start + $key + 1;
				$nestedData['tanggal'] = $data->tanggal;
				$nestedData['shift_name'] = $data->shift_name;
				$nestedData['operator_name'] = $data->operator_name;
				$nestedData['unit_name'] = $data->unit_kode . "--" . $data->unit_brand_name . "--" . $data->unit_model_name;
				$nestedData['hm_start'] = $data->hm_start;
				$nestedData['hm_end'] = $data->hm_end;
				$nestedData['duration'] = $data->duration;
				$nestedData['location_name'] = $data->location_name;
				$nestedData['week'] = $data->week;
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
			$this->load->model("hours_meter_model");
			$data = array(
				'is_deleted' => ($is_deleted == 1) ? 0 : 1,
			);
			$update = $this->hours_meter_model->update($data, array("id" => $id));

			$response_data['data'] = $data;
			$response_data['msg'] = "Hours Meter Berhasil di Hapus";
			$response_data['status'] = true;
		} else {
			$response_data['msg'] = "ID Harus Diisi";
		}

		echo json_encode($response_data);
	}

	function weekOfMonth($date) {
		//Get the first day of the month.
		$firstOfMonth = strtotime(date("Y-m-01", $date));
		//Apply above formula.
		return $this->weekOfYear($date) - $this->weekOfYear($firstOfMonth) + 1;
	}

	function weekOfYear($date) {
		$weekOfYear = intval(date("W", $date));
		if (date('n', $date) == "1" && $weekOfYear > 51) {
			// It's the last week of the previos year.
			return 0;
		} else if (date('n', $date) == "12" && $weekOfYear == 1) {
			// It's the first week of the next year.
			return 53;
		} else {
			// It's a "normal" week.
			return $weekOfYear;
		}
	}
}
