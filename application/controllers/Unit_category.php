
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'core/Admin_Controller.php';
class Unit_category extends Admin_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('unit_category_model');
	}

	public function index() {

		$this->load->helper('url');
		if ($this->data['is_can_read']) {
			$this->data['content'] = 'admin/unit_category/list_v';
		} else {
			$this->data['content'] = 'errors/html/restrict';
		}

		$this->load->view('admin/layouts/page', $this->data);
	}

	public function create() {
		$this->form_validation->set_rules('name', "Nama Harus Diisi", 'trim|required');

		if ($this->form_validation->run() === TRUE) {
			$data = array(
				'name' => $this->input->post('name'),
				'description' => "",
			);
			if ($this->unit_category_model->insert($data)) {
				$this->session->set_flashdata('message', "Kategori Baru Berhasil Disimpan");
				redirect("unit_category");
			} else {
				$this->session->set_flashdata('message_error', "Kategori Baru Gagal Disimpan");
				redirect("unit_category");
			}
		} else {
			$this->data['content'] = 'admin/unit_category/create_v';
			$this->load->view('admin/layouts/page', $this->data);
		}
	}

	public function edit($id) {
		$this->form_validation->set_rules('name', "Name Harus Diisi", 'trim|required');

		if ($this->form_validation->run() === TRUE) {
			$data = array(
				'name' => $this->input->post('name'),
				'description' => "",
			);
			$update = $this->unit_category_model->update($data, array("unit_category.id" => $id));
			if ($update) {
				$this->session->set_flashdata('message', "Kategori Berhasil Diubah");
				redirect("unit_category", "refresh");
			} else {
				$this->session->set_flashdata('message_error', "Kategori Gagal Diubah");
				redirect("unit_category", "refresh");
			}
		} else {
			if (!empty($_POST)) {
				$id = $this->input->post('id');
				$this->session->set_flashdata('message_error', validation_errors());
				return redirect("unit_category/edit/" . $id);
			} else {
				$this->data['id'] = $this->uri->segment(3);
				$unit_category = $this->unit_category_model->getAllById(array("unit_category.id" => $this->data['id']));
				$this->data['name'] = (!empty($unit_category)) ? $unit_category[0]->name : "";
				$this->data['description'] = (!empty($unit_category)) ? $unit_category[0]->description : "";

				$this->data['content'] = 'admin/unit_category/edit_v';
				$this->load->view('admin/layouts/page', $this->data);
			}
		}

	}

	public function dataList() {

		$columns = array(
			0 => 'name',
			1 => '',
		);

		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];
		$search = array();
		$where = array();
		$limit = 0;
		$start = 0;
		$totalData = $this->unit_category_model->getCountAllBy($limit, $start, $search, $order, $dir, $where);

		if (!empty($this->input->post('search')['value'])) {
			$search_value = $this->input->post('search')['value'];
			$search = array(
				"unit_category.name" => $search_value,
				"unit_category.description" => $search_value,
			);
			$totalFiltered = $this->unit_category_model->getCountAllBy($limit, $start, $search, $order, $dir, $where);
		} else {
			$totalFiltered = $totalData;
		}

		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$datas = $this->unit_category_model->getAllBy($limit, $start, $search, $order, $dir, $where);

		$new_data = array();
		if (!empty($datas)) {

			foreach ($datas as $key => $data) {

				$edit_url = "";
				$delete_url = "";

				if ($this->data['is_can_edit'] && $data->is_deleted == 0) {
					$edit_url = "<a href='" . base_url() . "unit_category/edit/" . $data->id . "' class='btn btn-sm btn-info white'> Ubah</a>";
				}
				if ($this->data['is_can_delete']) {
					$delete_url = "<a href='#'
						url='" . base_url() . "unit_category/destroy/" . $data->id . "/" . $data->is_deleted . "'
						class='btn btn-sm btn-danger white delete'> Hapus
						</a>";
				}

				$nestedData['id'] = $start + $key + 1;
				$nestedData['name'] = $data->name;
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
			$this->load->model("unit_category_model");
			$data = array(
				'is_deleted' => ($is_deleted == 1) ? 0 : 1,
			);
			$update = $this->unit_category_model->update($data, array("id" => $id));

			$response_data['data'] = $data;
			$response_data['msg'] = "Kategori Berhasil di Hapus";
			$response_data['status'] = true;
		} else {
			$response_data['msg'] = "ID Harus Diisi";
		}

		echo json_encode($response_data);
	}
}
