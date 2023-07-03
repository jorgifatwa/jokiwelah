<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'core/Admin_Controller.php';
class Set_joki extends Admin_Controller 
{
	public function __construct() 
	{
		parent::__construct();
		$this->load->model('set_joki_model');
		$this->load->model('joki_model');
	}

	public function index() 
	{
		$this->load->helper('url');
		$this->data['jokis'] = $this->joki_model->getAllById();
		if ($this->data['is_can_read']) {
			$this->data['content'] = 'admin/set_joki/list_v';
		} else {
			$this->data['content'] = 'errors/html/restrict';
		}


		$this->load->view('admin/layouts/page', $this->data);
	}

	public function dataList() 
	{
		$columns = array(
			0 => 'no_faktur',
			1 => 'paket_name',
			2 => 'nickname',
			3 => '',
		);

		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];
		$search = array();
		$limit = 0;
		$start = 0;
		$totalData = $this->set_joki_model->getCountAllBy($limit, $start, $search, $order, $dir);

		if (!empty($this->input->post('search')['value'])) {
			$search_value = $this->input->post('search')['value'];
			$search = array(
				"order.no_faktur" => $search_value,
				"paket.name" => $search_value,
				"order.nickname" => $search_value,
			);
			$totalFiltered = $this->set_joki_model->getCountAllBy($limit, $start, $search, $order, $dir);
		} else {
			$totalFiltered = $totalData;
		}

		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$datas = $this->set_joki_model->getAllBy($limit, $start, $search, $order, $dir);

		$new_data = array();
		if (!empty($datas)) {

			foreach ($datas as $key => $data) {
				$accept_url = "";

				if ($this->data['is_can_edit']) {
					$accept_url = "<a href='#' url='" . base_url() . "set_joki/set/" . $data->id . "' data-id='". $data->id . "' class='btn btn-sm btn-info white joki'> Pilih Joki</a>";
				}

				$nestedData['id'] = $start + $key + 1;
				$nestedData['no_faktur'] = $data->no_faktur;
				$nestedData['paket_name'] = $data->pelayanan_name;
				$nestedData['nickname'] = $data->nickname;
				$nestedData['action'] =  $accept_url;
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

	public function set() 
	{
		$response_data = array();
		$response_data['status'] = false;
		$response_data['msg'] = "";
		$response_data['data'] = array();

		$id = $this->uri->segment(3);
		if (!empty($id)) {
			$this->load->model("set_joki_model");
			$data = array(
				'id_joki' => $this->input->post('id_joki'),
			);
			$update = $this->set_joki_model->update($data, array("id" => $id));

			$response_data['data'] = $data;
			$response_data['msg'] = "Pekerjaan Berhasil Di Tambahkan";
			$response_data['status'] = true;
		} else {
			$response_data['msg'] = "ID Harus Diisi";
		}

		echo json_encode($response_data);
	}
}
