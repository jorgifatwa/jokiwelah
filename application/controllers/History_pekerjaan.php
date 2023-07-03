<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'core/Admin_Controller.php';
class History_pekerjaan extends Admin_Controller 
{
	public function __construct() 
	{
		parent::__construct();
		$this->load->model('history_pekerjaan_model');
		$this->load->model('joki_model');
	}
	
	public function index() 
	{
		$this->load->helper('url');
		if ($this->data['is_can_read']) {
			$this->data['content'] = 'admin/history_pekerjaan/list_v';
		} else {
			$this->data['content'] = 'errors/html/restrict';
		}

		$this->load->view('admin/layouts/page', $this->data);
	}

	public function dataList() 
	{
		$columns = array(
			0 => 'no_faktur',
			1 => 'joki',
			2 => 'tanggal',
			3 => 'paket_name',
			4 => '',
		);

		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];
		$search = array();
		$where = array();
		$limit = 0;
		$start = 0;

		if($this->data['users_groups']->id == 3){
			$where = array(
				'joki.id_user' => $this->data['users']->id
			);
		}

		$totalData = $this->history_pekerjaan_model->getCountAllBy($limit, $start, $search, $order, $dir, $where);

		if (!empty($this->input->post('search')['value'])) {
			$search_value = $this->input->post('search')['value'];
			$search = array(
				"joki.name" => $search_value,
				"order.no_faktur" => $search_value,
				"paket.name" => $search_value,
				"order.tanggal" => $search_value,
			);
			$totalFiltered = $this->history_pekerjaan_model->getCountAllBy($limit, $start, $search, $order, $dir, $where);
		} else {
			$totalFiltered = $totalData;
		}

		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$datas = $this->history_pekerjaan_model->getAllBy($limit, $start, $search, $order, $dir, $where);

		$new_data = array();
		if (!empty($datas)) {

			foreach ($datas as $key => $data) {

				$nestedData['id'] = $start + $key + 1;
				$nestedData['no_faktur'] = $data->no_faktur;
				$nestedData['joki_name'] = $data->joki_name;
				$nestedData['tanggal'] = $data->tanggal;
				$nestedData['paket_name'] = $data->pelayanan_name." - ".$data->paket_name;
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
