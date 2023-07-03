<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'core/Admin_Controller.php';
class Pekerjaan extends Admin_Controller 
{
	public function __construct() 
	{
		parent::__construct();
		$this->load->model('pekerjaan_model');
	}

	public function index() 
	{
		$this->load->helper('url');
		if ($this->data['is_can_read']) {
			$this->data['content'] = 'admin/pekerjaan/list_v';
		} else {
			$this->data['content'] = 'errors/html/restrict';
		}

		
		if($this->data['users']->id != 1){
			$this->data['salaries'] = $this->pekerjaan_model->getTotalPendapatan(array('pendapatan.id_user' => $this->data['users']->id));
			$this->data['salary'] = $this->data['salaries']->total_pendapatan; 
			$this->data['jobs'] = $this->pekerjaan_model->getTotalPekerjaanBelumSelesai(array('joki.id_user' => $this->data['users']->id));
			$this->data['uncompleted_job'] = $this->data['jobs']->total_pekerjaan; 
		}else{
			$this->data['salaries'] = $this->pekerjaan_model->getTotalPendapatan(array('pendapatan.id_user' => $this->data['users']->id));
			$this->data['salary'] = $this->data['salaries']->total_pendapatan; 
			$this->data['jobs'] = $this->pekerjaan_model->getTotalPekerjaanBelumSelesai();
			$this->data['uncompleted_job'] = $this->data['jobs']->total_pekerjaan;
		}

		$this->load->view('admin/layouts/page', $this->data);
	}

	public function finish($id) 
	{

		if ($_FILES) {

			$time = time();

			$id = $this->input->post('id');

			$location_path = "./uploads/bukti_pekerjaan/";
			if(!is_dir($location_path))
			{
				mkdir($location_path);
			}

			$tmp = $_FILES["bukti_pekerjaan"]['name'];
			$ext = ".".pathinfo($tmp, PATHINFO_EXTENSION);
			$uploaded_background = uploadFileArray('bukti_pekerjaan', $location_path,$time,1);                    
			if(!empty($uploaded_background[0]['file'])){
				for ($i=0; $i < count($uploaded_background); $i++) { 
					$upload = $uploaded_background[$i];

					if($upload["file"] == "" && $upload["file_thumb"] == ""){
						if(!empty($background_old[$i])){
							$explode = explode(".", $background_old[$i]);
							$arr_content_2[] = $background_old[$i];
							$arr_content_2[] = $explode[0]."_thumb.".$explode[1];

							$uploaded_background[$i]["file"] = $background_old[$i]; 
						}
					}else{
						if($upload["file"] != ""){
							$arr_content_2[] = $upload["file"];
						}

						if($upload["file_thumb"] != ""){
							$arr_content_2[] = $upload["file_thumb"];
						}
					}
					$data_bukti['id_order'] = $this->input->post('id');
					$data_bukti['name'] = $upload["file"];
					$insert = $this->pekerjaan_model->insert_file($data_bukti);
				}
			}

			$data_order = array(
				'status_orderan' => 3,
				'keterangan_pekerjaan' => $this->input->post('keterangan')
			);
			
			$this->pekerjaan_model->update($data_order, array("id" => $id));

			$orders = $this->pekerjaan_model->getPendapatan(array('order.id' => $id));

			//JOKI
			$total_pendapatan = (60 * $orders->paket_harga) / 100; 

			$data_pendapatan = array(
				'tanggal' => date('Y-m-d H:i:s'),
				'id_order' => $id,
				'id_user' => $this->data['users']->id,
				'total_pendapatan' => $total_pendapatan,
				'status' => 0
			);

			$this->pekerjaan_model->insert_pendapatan($data_pendapatan);

			//ADMIN
			$pendapatan_admin = (40 * $orders->paket_harga) / 100; 

			$data_pendapatan_admin = array(
				'tanggal' => date('Y-m-d H:i:s'),
				'id_order' => $id,
				'id_user' => 1,
				'total_pendapatan' => $pendapatan_admin,
				'status' => 0
			);

			$this->pekerjaan_model->insert_pendapatan($data_pendapatan_admin);

			if ($insert) {
				$this->session->set_flashdata('message', "Pekerjaan Berhasil Diselesaikan");
				redirect("pekerjaan");
			} else {
				$this->session->set_flashdata('message_error', "Pekerjaan Gagal Diselesaikan");
				redirect("pekerjaan");
			}
		} else {
			$this->data['id'] = $this->uri->segment(3);
			$this->data['content'] = 'admin/pekerjaan/finish_v';
			$this->load->view('admin/layouts/page', $this->data);
		}
	}

	public function dataList() 
	{
		$columns = array(
			0 => 'no_faktur',
			1 => 'paket_name',
			2 => 'nomor_whatsapp',
			3 => ''
		);

		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];
		$search = array();
		$where = array();
		$limit = 0;
		$start = 0;

		if($this->data['users']->id != 1){
			$where = array('joki.id_user' => $this->data['users']->id);
		}

		$totalData = $this->pekerjaan_model->getCountAllBy($limit, $start, $search, $order, $dir, $where);

		if (!empty($this->input->post('search')['value'])) {
			$search_value = $this->input->post('search')['value'];
			$search = array(
				"order.no_faktur" => $search_value,
				"order.nomor_whatsapp" => $search_value,
				"paket.name" => $search_value,
			);
			$totalFiltered = $this->pekerjaan_model->getCountAllBy($limit, $start, $search, $order, $dir, $where);
		} else {
			$totalFiltered = $totalData;
		}

		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$datas = $this->pekerjaan_model->getAllBy($limit, $start, $search, $order, $dir, $where);

		$new_data = array();
		if (!empty($datas)) {

			foreach ($datas as $key => $data) {
				$finish_url = "";

				if ($this->data['is_can_edit'] && $this->data['users']->id != 1) {
					$finish_url = "<a href='" . base_url() . "pekerjaan/finish/" . $data->id . "' class='btn btn-sm btn-info white'> Selesaikan Pekerjaan</a>";
				}

				$detail_url = "<a href='" . base_url() . "order/detail/" . $data->id . "' class='btn btn-sm btn-primary white'> Detail</a>";

				if($data->status_orderan == 0){
					$status = "Review";
				}else if($data->status_orderan == 1){
					$status = "Proses Pengerjaan";
				}else if($data->status_orderan == 2){
					$status = "Ditolak";
				}else if($data->status_orderan == 3){
					$status = "Selesai";
				}

				$nestedData['id'] = $start + $key + 1;
				$nestedData['no_faktur'] = $data->no_faktur;
				$nestedData['nomor_whatsapp'] = $data->nomor_whatsapp;
				$nestedData['paket_name'] = $data->pelayanan_name;
				$nestedData['status'] = $status;
				$nestedData['action'] = $finish_url." ".$detail_url;
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
