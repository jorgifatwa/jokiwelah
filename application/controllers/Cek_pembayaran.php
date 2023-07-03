<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'core/Admin_Controller.php';
class Cek_pembayaran extends Admin_Controller 
{
	public function __construct() 
	{
		parent::__construct();
		$this->load->model('cek_pembayaran_model');
	}

	public function index() 
	{
		$this->load->helper('url');
		if ($this->data['is_can_read']) {
			$this->data['content'] = 'admin/cek_pembayaran/list_v';
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
			2 => 'paket_harga',
			3 => 'bukti_pembayaran',
			4 => '',
		);

		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];
		$search = array();
		$limit = 0;
		$start = 0;
		$totalData = $this->cek_pembayaran_model->getCountAllBy($limit, $start, $search, $order, $dir);

		if (!empty($this->input->post('search')['value'])) {
			$search_value = $this->input->post('search')['value'];
			$search = array(
				"order.no_faktur" => $search_value,
				"paket.name" => $search_value,
				"paket.harga" => $search_value,
				"order.bukti_pembayaran" => $search_value,
			);
			$totalFiltered = $this->cek_pembayaran_model->getCountAllBy($limit, $start, $search, $order, $dir);
		} else {
			$totalFiltered = $totalData;
		}

		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$datas = $this->cek_pembayaran_model->getAllBy($limit, $start, $search, $order, $dir);

		$new_data = array();
		if (!empty($datas)) {

			foreach ($datas as $key => $data) {
				$decline_url = "";
				$accept_url = "";

				if ($this->data['is_can_edit']) {
					$accept_url = "<a href='#'
						url='" . base_url() . "cek_pembayaran/accept/" . $data->id . "/" . $data->is_deleted . "'
						class='btn btn-sm btn-success white accept'> <span class='fa fa-check'></span>
						</a>";
					$decline_url = "<a href='#'
						url='" . base_url() . "cek_pembayaran/decline/" . $data->id . "/" . $data->is_deleted . "'
						class='btn btn-sm btn-danger white decline'> <span class='fa fa-times'></span>
						</a>";
				}

				$nestedData['id'] = $start + $key + 1;
				$nestedData['no_faktur'] = $data->no_faktur;
				$nestedData['paket_harga'] = "Rp.".number_format($data->total_harga);
				$nestedData['paket_name'] = $data->pelayanan_name;
				$nestedData['bukti_pembayaran'] = "<a href='".base_url('uploads/order/'.$data->bukti_pembayaran)."' target='_blank'><img src='".base_url('uploads/order/'.$data->bukti_pembayaran)."' width='50'></a>";
				$nestedData['action'] = $decline_url . " " . $accept_url;
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
		if (!empty($id)) {
			$this->load->model("cek_pembayaran_model");
			$data = array(
				'status_orderan' => 1,
			);
			$update = $this->cek_pembayaran_model->update($data, array("id" => $id));

			$response_data['data'] = $data;
			$response_data['msg'] = "Order Berhasil di Terima";
			$response_data['status'] = true;
		} else {
			$response_data['msg'] = "ID Harus Diisi";
		}

		echo json_encode($response_data);
	}

	public function decline() 
	{
		$response_data = array();
		$response_data['status'] = false;
		$response_data['msg'] = "";
		$response_data['data'] = array();

		$id = $this->uri->segment(3);
		if (!empty($id)) {
			$this->load->model("cek_pembayaran_model");
			$data = array(
				'status_orderan' => 2,
			);
			$update = $this->cek_pembayaran_model->update($data, array("id" => $id));

			$response_data['data'] = $data;
			$response_data['msg'] = "Order Berhasil di Tolak";
			$response_data['status'] = true;
		} else {
			$response_data['msg'] = "ID Harus Diisi";
		}

		echo json_encode($response_data);
	}
}
