<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'core/Admin_Controller.php';
class History_pencairan extends Admin_Controller 
{
	public function __construct() 
	{
		parent::__construct();
		$this->load->model('history_pencairan_model');
	}

	public function index() 
	{
		$this->load->helper('url');
		if ($this->data['is_can_read']) {
			$this->data['content'] = 'admin/history_pencairan/list_v';
		} else {
			$this->data['content'] = 'errors/html/restrict';
		}

		$this->load->view('admin/layouts/page', $this->data);
	}

	public function dataList() 
	{
		$columns = array(
			0 => 'tanggal',
			1 => 'joki_name',
			2 => 'total_pencairan',
			3 => '',
		);

		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];
		$search = array();
		$where = array();
		$limit = 0;
		$start = 0;

		$totalData = $this->history_pencairan_model->getCountAllBy($limit, $start, $search, $order, $dir);

		if (!empty($this->input->post('search')['value'])) {
			$search_value = $this->input->post('search')['value'];
			$search = array(
				"joki.name" => $search_value,
				"pencairan.tanggal" => $search_value,
				"pencairan.total_pencairan" => $search_value,
			);
			$totalFiltered = $this->history_pencairan_model->getCountAllBy($limit, $start, $search, $order, $dir);
		} else {
			$totalFiltered = $totalData;
		}

		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$datas = $this->history_pencairan_model->getAllBy($limit, $start, $search, $order, $dir);

		$new_data = array();
		if (!empty($datas)) {

			foreach ($datas as $key => $data) {

				$nestedData['id'] = $start + $key + 1;
				$nestedData['tanggal'] = $data->tanggal;
				$nestedData['joki_name'] = $data->joki_name;
				$nestedData['total_pencairan'] = "Rp.".number_format($data->total_pencairan);
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
}
