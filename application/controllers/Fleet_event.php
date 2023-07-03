<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'core/Admin_Controller.php';
class Fleet_event extends Admin_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('fleet_event_model');
		$this->load->model('user_mutation_model');
		$this->load->model('unit_model');
		$this->load->model('location_model');
		$this->load->model('ob_actual_model');
	}

	public function index() {
		$this->load->helper('url');
		if ($this->data['is_can_read']) {
			$this->data['content'] = 'admin/fleet_event/list_v';
		} else {
			$this->data['content'] = 'errors/html/restrict';
		}
		$location_id = $this->user_mutation_model->getLastLocation($this->data['users']->id);

		$where_unit = [
			'unit_transfer.to_location' => $location_id,
		];
		$this->data['loading_unit'] = $this->unit_model->getAllByLocation($where_unit);

		$this->data['loaders'] = $this->ob_actual_model->select_box_data('loader_model');
		$this->data['fleet_status'] = $this->ob_actual_model->select_box_data('enum_fleet_status');
		$this->load->view('admin/layouts/page', $this->data);
	}

	public function create() {
		$this->form_validation->set_rules('tanggal', "Tanggal Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('shift', "Shift Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('kategori', "Kategori Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('start_time', "Waktu Mulai Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('end_time', "Waktu Berakhir Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('fleet_status_id', "Status Harus Dipilih", 'trim|required');
		$this->form_validation->set_rules('fleet_reason_id', "Alasan Harus Dipilih", 'trim|required');
		$this->form_validation->set_rules('location_id', "Lokasi Harus Dipilih", 'trim|required');

		if ($this->form_validation->run() === TRUE) {
			$tanggal = date("Y-m-d", strtotime($this->input->post("tanggal")));
			$shift = $this->input->post('shift');
			$start_time = $this->input->post('start_time');
			$end_time = $this->input->post('end_time');
			if($shift == "NS"){
				$cek_jam_start = date("H", strtotime($start_time));
				if((int)$cek_jam_start >= 0 && (int)$cek_jam_start <= 6 ){
					$start_time =  date("Y-m-d H:i:s", strtotime($tanggal." ".$start_time. "+1 days"));
				}else{
					$start_time = date("Y-m-d H:i:s", strtotime($tanggal." ".$start_time));
				}

				$cek_jam_stop = date("H", strtotime($end_time));
				if((int)$cek_jam_stop >= 0 && (int)$cek_jam_stop <= 6 ){
					$end_time =  date("Y-m-d H:i:s", strtotime($tanggal." ".$end_time. "+1 days"));
				}else{
					$end_time = date("Y-m-d H:i:s", strtotime($tanggal." ".$end_time));
				}
			}else{
				$start_time 	= date("Y-m-d H:i:s", strtotime($tanggal." ".$start_time));
				$end_time 	= date("Y-m-d H:i:s", strtotime($tanggal." ".$end_time));
			}

			$duration = 0;
			$duration = (strtotime($end_time) - strtotime($start_time))/3600;

			$data = array(
				'tanggal' => $tanggal,
				'shift' => $shift,
				'type_production' => $this->input->post('kategori'),
				'loading_unit_id' => $this->input->post('loading_unit_id'),
				'location_id' => $this->input->post('location_id'),
				'start_time' => $start_time,
				'end_time' => $end_time,
				'duration' => $duration,
				'fleet_status_id' => $this->input->post('fleet_status_id'),
				'fleet_reason_id' => $this->input->post('fleet_reason_id'),
				'catatan' => $this->input->post('catatan'),
			);
			if ($this->fleet_event_model->insert($data)) {
				$this->session->set_flashdata('message', "Fleet Event Baru Berhasil Disimpan");
				redirect("fleet_event");
			} else {
				$this->session->set_flashdata('message_error', "Fleet Event Baru Gagal Disimpan");
				redirect("fleet_event");
			}
		} else {
			$this->data['content'] = 'admin/fleet_event/create_v';
			$location_id = $this->user_mutation_model->getLastLocation($this->data['users']->id);

			$where_unit = [
				'unit_transfer.to_location' => $location_id,
			];
			$this->data['loading_unit'] = $this->unit_model->getAllByLocation($where_unit);
			$this->data['locations'] = $this->location_model->getAllById();
			$this->data['loaders'] = $this->ob_actual_model->select_box_data('loader_model');
			$this->data['fleet_status'] = $this->ob_actual_model->select_box_data('enum_fleet_status');
			$this->load->view('admin/layouts/page', $this->data);
		}
	}

	public function edit($id) {
		$this->form_validation->set_rules('tanggal', "Tanggal Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('shift', "Shift Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('kategori', "Kategori Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('start_time', "Waktu Mulai Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('end_time', "Waktu Berakhir Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('fleet_status_id', "Status Harus Dipilih", 'trim|required');
		$this->form_validation->set_rules('fleet_reason_id', "Alasan Harus Dipilih", 'trim|required');
		$this->form_validation->set_rules('location_id', "Lokasi Harus Dipilih", 'trim|required');

		if ($this->form_validation->run() === TRUE) {
			$tanggal = date("Y-m-d", strtotime($this->input->post("tanggal")));
			$shift = $this->input->post('shift');
			$start_time = $this->input->post('start_time');
			$end_time = $this->input->post('end_time');
			if($shift == "NS"){
				$cek_jam_start = date("H", strtotime($start_time));
				if((int)$cek_jam_start >= 0 && (int)$cek_jam_start <= 6 ){
					$start_time =  date("Y-m-d H:i:s", strtotime($tanggal." ".$start_time. "+1 days"));
				}else{
					$start_time = date("Y-m-d H:i:s", strtotime($tanggal." ".$start_time));
				}

				$cek_jam_stop = date("H", strtotime($end_time));
				if((int)$cek_jam_stop >= 0 && (int)$cek_jam_stop <= 6 ){
					$end_time =  date("Y-m-d H:i:s", strtotime($tanggal." ".$end_time. "+1 days"));
				}else{
					$end_time = date("Y-m-d H:i:s", strtotime($tanggal." ".$end_time));
				}
			}else{
				$start_time 	= date("Y-m-d H:i:s", strtotime($tanggal." ".$start_time));
				$end_time 	= date("Y-m-d H:i:s", strtotime($tanggal." ".$end_time));
			}

			$duration = 0;
			$duration = (strtotime($end_time) - strtotime($start_time))/3600;

			$data = array(
				'tanggal' 	=> $tanggal,
				'shift' 	=> $shift,
				'type_production' 	=> $this->input->post('kategori'),
				'loading_unit_id' => $this->input->post('loading_unit_id'),
				'location_id' => $this->input->post('location_id'),
				'start_time' => $start_time,
				'end_time' => $end_time,
				'duration' => $duration,
				'fleet_status_id' => $this->input->post('fleet_status_id'),
				'fleet_reason_id' => $this->input->post('fleet_reason_id'),
				'catatan' => $this->input->post('catatan'),
			);
			$update = $this->fleet_event_model->update($data, array("fleet_event.id" => $id));
			if ($update) {
				$this->session->set_flashdata('message', "Fleet Event Berhasil Diubah");
				redirect("fleet_event", "refresh");
			} else {
				$this->session->set_flashdata('message_error', "Fleet Event Gagal Diubah");
				redirect("fleet_event", "refresh");
			}
		} else {
			if (!empty($_POST)) {
				$id = $this->input->post('id');
				$this->session->set_flashdata('message_error', validation_errors());
				return redirect("fleet_event/edit/" . $id);
			} else {
				$this->data['id'] = $this->uri->segment(3);
				$fleet_event = $this->fleet_event_model->getAllById(array("fleet_event.id" => $this->data['id']));
				$this->data['tanggal'] = (!empty($fleet_event)) ? $fleet_event[0]->tanggal : "";
				$this->data['shift'] = (!empty($fleet_event)) ? $fleet_event[0]->shift : "";
				$this->data['kategori'] = (!empty($fleet_event)) ? $fleet_event[0]->type_production : "";
				$this->data['loading_unit_id'] = (!empty($fleet_event)) ? $fleet_event[0]->loading_unit_id : "";
				$this->data['start_time'] = (!empty($fleet_event)) ? $fleet_event[0]->start_time : "";
				$this->data['end_time'] = (!empty($fleet_event)) ? $fleet_event[0]->end_time : "";
				$this->data['duration'] = (!empty($fleet_event)) ? $fleet_event[0]->duration : "";
				$this->data['fleet_status_id'] = (!empty($fleet_event)) ? $fleet_event[0]->fleet_status_id : "";
				$this->data['fleet_reason_id'] = (!empty($fleet_event)) ? $fleet_event[0]->fleet_reason_id : "";
				$this->data['catatan'] = (!empty($fleet_event)) ? $fleet_event[0]->catatan : "";
				$this->data['location_id'] = (!empty($fleet_event)) ? $fleet_event[0]->location_id : "";

				$where_unit = [
					'unit_transfer.to_location' => $this->data['location_id'],
				];
				$this->data['loading_unit'] = $this->unit_model->getAllByLocation($where_unit);

				$this->data['loaders'] = $this->ob_actual_model->select_box_data('loader_model');
				$this->data['fleet_status'] = $this->ob_actual_model->select_box_data('enum_fleet_status');
				$this->data['locations'] = $this->location_model->getAllById();
				$this->data['content'] = 'admin/fleet_event/edit_v';
				$this->load->view('admin/layouts/page', $this->data);
			}
		}

	}

	public function dataList() {

		$columns = array(
			0 => 'tanggal',
			1 => 'shift',
			2 => 'type_production',
			3 => 'loading_unit_name',
			4 => 'start_time',
			5 => 'end_time',
			6 => 'duration',
			7 => 'fleet_status_name',
			8 => 'fleet_reason_name',
			9 => '',
		);

		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];
		$search = array();
		$where = array();
		$limit = 0;
		$start = 0;

		$totalData = $this->fleet_event_model->getCountAllBy($limit, $start, $search, $order, $dir, $where);
		$searchColumn = $this->input->post('columns');
		$filtered = false;

		if (!empty($searchColumn[1]['search']['value'])) {
			$value = $searchColumn[1]['search']['value'];
			$where['fleet_event.loading_unit_id'] = $value;

			$filtered = true;
		}

		if (!empty($searchColumn[3]['search']['value'])) {
			$value = $searchColumn[3]['search']['value'];
			$where['fleet_event.fleet_status_id'] = $value;

			$filtered = true;
		}

		if (!empty($searchColumn[4]['search']['value'])) {
			$value = $searchColumn[4]['search']['value'];
			$where['fleet_event.fleet_reason_id'] = $value;

			$filtered = true;
		}

		if (!empty($searchColumn[5]['search']['value'])) {
			$value = $searchColumn[5]['search']['value'];
			$where['fleet_event.tanggal >= '] = date("Y-m-d", strtotime($value));

			$filtered = true;
		}

		if (!empty($searchColumn[6]['search']['value'])) {
			$value = $searchColumn[6]['search']['value'];
			$where['fleet_event.tanggal <= '] = date("Y-m-d", strtotime($value));

			$filtered = true;
		}

		if (!empty($this->input->post('search')['value'])) {
			$search_value = $this->input->post('search')['value'];
			$search = array(
				"fleet_event.tanggal" => $search_value,
				"fleet_event.type_production" => $search_value,
				"unit.kode" => $search_value,
				"fleet_event.start_time" => $search_value,
				"fleet_event.end_time" => $search_value,
				"fleet_event.duration" => $search_value,
				"enum_fleet_status.name" => $search_value,
				"enum_fleet_reason.name" => $search_value,
			);
			$filtered = true;
		}

		if ($filtered) {
			$totalFiltered = $this->fleet_event_model->getCountAllBy($limit, $start, $search, $order, $dir, $where);

		} else {
			$totalFiltered = $totalData;
		}

		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$datas = $this->fleet_event_model->getAllBy($limit, $start, $search, $order, $dir, $where);

		$new_data = array();
		if (!empty($datas)) {

			foreach ($datas as $key => $data) {

				$edit_url = "";
				$delete_url = "";

				if ($this->data['is_can_edit'] && $data->is_deleted == 0) {
					$edit_url = "<a href='" . base_url() . "fleet_event/edit/" . $data->id . "' class='btn btn-sm btn-info white'><i class='fa fa-pencil'></i> Ubah</a>";
				}
				if ($this->data['is_can_delete']) {
					$delete_url = "<a href='#'
						url='" . base_url() . "fleet_event/destroy/" . $data->id . "/" . $data->is_deleted . "'
						class='btn btn-sm btn-danger white delete'> Hapus
						</a>";
				}

				$nestedData['id'] = $start + $key + 1;
				$nestedData['tanggal'] = $data->tanggal;
				$nestedData['shift'] = $data->shift;
				$nestedData['kategori'] = $data->type_production;
				$nestedData['loading_unit_name'] = $data->unit_kode . "--" . $data->unit_brand_name . "--" . $data->unit_model_name;
				$nestedData['start_time'] = $data->start_time;
				$nestedData['end_time'] = $data->end_time;
				$nestedData['duration'] = $data->duration;
				$nestedData['fleet_status_name'] = $data->fleet_status_name;
				$nestedData['fleet_reason_name'] = $data->fleet_reason_name;
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
			$this->load->model("fleet_event_model");
			$data = array(
				'is_deleted' => ($is_deleted == 1) ? 0 : 1,
			);
			$update = $this->fleet_event_model->update($data, array("id" => $id));

			$response_data['data'] = $data;
			$response_data['msg'] = "Fleet Event Berhasil di Hapus";
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

		$data = $this->fleet_event_model->getReasonData(array("enum_fleet_reason.fleet_status_id" => $id));

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

	public function getUnit() {
		$id = $this->input->post("id");
		$loading_unit = $this->unit_model->getAllByLocation(['unit_transfer.to_location' => $id]);

		if (!empty($loading_unit)) {
			$response_data['status'] = true;
			$response_data['data'] = $loading_unit;
			$response_data['message'] = 'Berhasil Mengambil Data';
		} else {
			$response_data['status'] = false;
			$response_data['data'] = [];
			$response_data['message'] = 'Gagal Mengambil Data';
		}

		echo json_encode($response_data);
	}
}
