<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'core/Admin_Controller.php';
class Pencairan extends Admin_Controller 
{
	public function __construct() 
	{
		parent::__construct();
		$this->load->model('pencairan_model');
		$this->load->model('joki_model');
	}

	public function index() 
	{
		$this->load->helper('url');
		if ($this->data['is_can_read']) {
			$this->data['content'] = 'admin/pencairan/list_v';
		} else {
			$this->data['content'] = 'errors/html/restrict';
		}

		$this->load->view('admin/layouts/page', $this->data);
	}

	public function dataList() 
	{
		$columns = array(
			0 => 'joki_name',
			1 => 'total_pendapatan',
			2 => '',
		);

		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];
		$search = array();
		$where = array();
		$limit = 0;
		$start = 0;

		$totalData = $this->pencairan_model->getCountAllBy($limit, $start, $search, $order, $dir);

		if (!empty($this->input->post('search')['value'])) {
			$search_value = $this->input->post('search')['value'];
			$search = array(
				"joki.name" => $search_value,
			);
			$totalFiltered = $this->pencairan_model->getCountAllBy($limit, $start, $search, $order, $dir);
		} else {
			$totalFiltered = $totalData;
		}

		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$datas = $this->pencairan_model->getAllBy($limit, $start, $search, $order, $dir);

		$new_data = array();
		if (!empty($datas)) {

			foreach ($datas as $key => $data) {

				$accept_url = "";

				if ($this->data['is_can_edit']) {
					$accept_url = "<a href='#'
						url='" . base_url() . "pencairan/accept/" . $data->id_user . "/" . $data->is_deleted . "'
						class='btn btn-sm btn-info white accept' total_pendapatan='".$data->total_pendapatan."'> Cairkan
						</a>";
				}

				$nestedData['id'] = $start + $key + 1;
				$nestedData['joki'] = $data->joki_name;
				$nestedData['pendapatan'] = "Rp.".number_format($data->total_pendapatan);
				$nestedData['action'] = $accept_url;
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

	public function accept() 
	{
		$response_data = array();
		$response_data['status'] = false;
		$response_data['msg'] = "";
		$response_data['data'] = array();

		$id = $this->uri->segment(3);

		$jokis = $this->joki_model->getOneBy(array('joki.id' => $id));
		$id_joki = $jokis->id;

		if (!empty($id)) {
			$this->load->model("pencairan_model");
			$data = array(
				'status_orderan' => 4,
			);
			$update = $this->pencairan_model->update($data, array("order.id_joki" => $id_joki));

			$data_pencairan = array(
				'tanggal' => date('Y-m-d H:i:s'),
				'id_joki' => $id_joki,
				'total_pencairan' => $this->input->post('total_pendapatan')
			);

			$this->pencairan_model->insert($data_pencairan);

			$data_pendapatan = array(
				'status' => 1
			);

			$pendapatan = $this->pencairan_model->update_pendapatan($data_pendapatan, array('pendapatan.id_user' => $id));

			$response_data['data'] = $data;
			$response_data['msg'] = "Order Berhasil di Terima";
			$response_data['status'] = true;
		} else {
			$response_data['msg'] = "ID Harus Diisi";
		}

		echo json_encode($response_data);
	}
}
