<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'core/Admin_Controller.php';
class Rns_plan extends Admin_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('rns_plan_model');
		$this->load->model('unit_model');
		$this->load->model('location_model');
	}

	public function index() {

		$this->load->helper('url');
		if ($this->data['is_can_read']) {
			$this->data['content'] = 'admin/rns_plan/list_v';
		} else {
			$this->data['content'] = 'errors/html/restrict';
		}

		$this->data['bulan'] = getBulan();
		$where_location = [
			"location.is_deleted" => 0,
			"location.id != " => 1
		];
		$this->data['location'] = $this->location_model->getAllById($where_location);
		$this->load->view('admin/layouts/page', $this->data);
	}

	public function create() 
	{
		if ($this->data['is_can_create']) {
			$this->data['bulan'] = getBulan();
			$this->data['content'] = 'admin/rns_plan/create_v';
		} else {
			$this->data['content'] = 'errors/html/restrict';
		}
		$where_location = [
			"location.is_deleted" => 0,
			"location.id != " => 1
		];
		$this->data['location'] = $this->location_model->getAllById($where_location);
		$this->load->view('admin/layouts/page', $this->data);
	}

	public function dataList()
	{
		$bulan = $this->input->post('bulan');
		$tahun = $this->input->post('tahun');
		$searching = $this->input->post('searching');
		
		$where =[
			"YEAR(rns_plan.tanggal)" => $tahun,
			"MONTH(rns_plan.tanggal)" => $bulan,
			"location.is_deleted" => 0,
			"location.id != " => 1
		];

		$plan = $this->rns_plan_model->getAllGroupBy($where);
		$arr_data = [];
		$arr_total_produksi = [];
		if(!empty($plan)){
			foreach ($plan as $data) {
				$arr_data[$data->id]["rns"][$data->tanggal] = $data->total_rns;
				if(!empty($arr_total_produksi["rns"][$data->tanggal])){
					$arr_total_produksi["rns"][$data->tanggal] += $data->total_rns;
				}else{
					$arr_total_produksi["rns"][$data->tanggal] = $data->total_rns;
				}
				$arr_data[$data->id]["rainfall"][$data->tanggal] = $data->total_rainfall;
				if(!empty($arr_total_produksi["rainfall"][$data->tanggal])){
					$arr_total_produksi["rainfall"][$data->tanggal] += $data->total_rainfall;
				}else{
					$arr_total_produksi["rainfall"][$data->tanggal] = $data->total_rainfall;
				}
			}
		}

		$akhir_bulan = date("t", strtotime($tahun."-".$bulan));
		$datas = [];
		$where_location  = [
			'location.is_deleted' => 0,
			'location.id != ' => 1
		];

		$location = $this->location_model->getAllById($where_location);
		if(!empty($location)){
			foreach ($location as $value) {
				$x = new stdClass();
				$x->name  = $value->name;
				$x->total_rns = 0;
				$x->total_rainfall = 0;
				$x->data_date_rns = [];
				$x->data_date_rainfall = [];
				for ($i=1; $i <= $akhir_bulan ; $i++) { 
					if(!empty($arr_data[$value->id]["rns"][$i])){
						$x->data_date_rns[] = number_format((float)$arr_data[$value->id]["rns"][$i], 2, '.', ',');
						$x->total_rns += $arr_data[$value->id]["rns"][$i];
					}else{
						$x->data_date_rns[] = 0;
					}

					if(!empty($arr_data[$value->id]["rainfall"][$i])){
						$x->data_date_rainfall[] = number_format((float)$arr_data[$value->id]["rainfall"][$i], 2, '.', ',');
						$x->total_rainfall += $arr_data[$value->id]["rainfall"][$i];
					}else{
						$x->data_date_rainfall[] = 0;
					}
				}
				$x->total_rns = number_format((float)$x->total_rns, 2, '.', ',');
				$x->total_rainfall = number_format((float)$x->total_rainfall, 2, '.', ',');

				array_push($datas, $x);
			}			
		}

		//total produksi
		$data_total = [];
		$x = new stdClass();
		$x->name  = "Total Produksi";
		$x->total_rns = 0;
		$x->total_rainfall = 0;
		$x->data_date_rns = [];
		$x->data_date_rainfall = [];
		for ($i=1; $i <= $akhir_bulan ; $i++) { 
			if(!empty($arr_total_produksi["rns"][$i])){
				$x->data_date_rns[] = number_format((float)$arr_total_produksi["rns"][$i], 2, '.', ',');
				$x->total_rns += $arr_total_produksi["rns"][$i];
			}else{
				$x->data_date_rns[] = 0;
			}

			if(!empty($arr_total_produksi["rainfall"][$i])){
				$x->data_date_rainfall[] = number_format((float)$arr_total_produksi["rainfall"][$i], 2, '.', ',');
				$x->total_rainfall += $arr_total_produksi["rainfall"][$i];
			}else{
				$x->data_date_rainfall[] = 0;
			}
		}
		$x->total_rns = number_format((float)$x->total_rns, 2, '.', ',');
		$x->total_rainfall = number_format((float)$x->total_rainfall, 2, '.', ',');
		array_push($data_total, $x);
		
		$return_data = array(
			"status"=>false,
			"message"=>"",
			"data"=>array()
		);

        if($datas){
			$return_data['data'] = $datas;
			$return_data['data_total'] = $data_total;
			$return_data['akhir_bulan'] = $akhir_bulan;
			$return_data['status'] = true;
			$return_data['message'] = "Berhasil mengambil data!";
		}else{
			$return_data['message'] = "Gagal mengambil data!";
		}

        echo json_encode($return_data); 
	}

	public function input_data()
	{
		if ($this->data['is_can_read']) {
			$this->form_validation->set_rules('rns',"RNS Harus Diisi", 'trim|required'); 
			$this->form_validation->set_rules('rainfall',"Rainfall Harus Diisi", 'trim|required'); 
			$this->form_validation->set_rules('tahun',"Tahun Harus Diisi", 'trim|required'); 
			$this->form_validation->set_rules('bulan',"Bulan Harus Diisi", 'trim|required'); 
			$this->form_validation->set_rules('location_id',"Lokasi Harus Diisi", 'trim|required'); 
	
			if ($this->form_validation->run() === TRUE)
			{
				$this->db->trans_begin();
	
				$rns = $this->input->post('rns');
				$rainfall = $this->input->post('rainfall');
				$tahun = $this->input->post('tahun');
				$bulan = $this->input->post('bulan');
				$location_id = $this->input->post('location_id');
	
				//delete data lama
				$where = [
					"YEAR(rns_plan.tanggal) = " => $tahun,
					"MONTH(rns_plan.tanggal) = " => sprintf('%02d', $bulan),
					"rns_plan.location_id" => $location_id
				];
				$delete = $this->rns_plan_model->delete($where);
	
				//make batch data
				$data_batch = [];
				$max_date = date("t", strtotime($tahun."-".$bulan."-01"));
				for ($i=1; $i <= $max_date ; $i++) { 
					$data_batch[] = [
						"rns" => number_format((float)$rns, 2, '.', ','),
						"rainfall" => number_format((float)$rainfall, 2, '.', ','),
						"tanggal" => date("Y-m-d", strtotime($tahun."-".$bulan."-".$i)),
						"location_id" => $location_id,
						"created_at" => date("Y-m-d H:i:s"),
						"is_deleted" => 0
					];
				}
				if(!empty($data_batch)){
					$this->rns_plan_model->insert_batch($data_batch);
				}
				$tanggal = date("Y-m-d", strtotime($tahun."-".$bulan."-01"));
				if ($this->db->trans_status() === FALSE){
					$this->db->trans_rollback();
					
					$return_data = [
						"status"  => false,
						"message" => "Gagal Menambahkan Data Plan",
						"tanggal" =>  $tanggal,
						"data" => array()
					];
				}else{
					$this->db->trans_commit();
					
					$return_data = [
						"status"=>true,
						"message"=> "Berhasil Menambahkan Data Plan",
						"tanggal" =>  $tanggal,
						"data"=>array()
					];
				}
			}else{
				$return_data = [
					"status"=>false,
					"message"=> "Harap Isi Data Dengan Benar",
					"data"=>array()
				];
			}
		}else{
			$return_data = [
				"status"=>false,
				"message"=> "Anda Tidak Memiliki Akses",
				"data"=>array()
			];
		}
		echo json_encode($return_data);
	}

	public function edit_data()
	{
		if ($this->data['is_can_edit']) {
			$this->form_validation->set_rules('rns',"RNS Harus Diisi", 'trim|required'); 
			$this->form_validation->set_rules('rainfall',"Rainfall Harus Diisi", 'trim|required'); 
			$this->form_validation->set_rules('tanggal',"Tanggal Harus Diisi", 'trim|required'); 
			$this->form_validation->set_rules('location_id',"Lokasi Harus Diisi", 'trim|required'); 

			if ($this->form_validation->run() === TRUE)
			{
				$this->db->trans_begin();

				$rns = $this->input->post('rns');
				$rainfall = $this->input->post('rainfall');
				$tanggal  = $this->input->post('tanggal');
				$location_id = $this->input->post('location_id');

				//delete data lama
				$where = [
					"rns_plan.tanggal" => date("Y-m-d", strtotime($tanggal)),
					"rns_plan.location_id" => $location_id
				];
				$delete = $this->rns_plan_model->delete($where);

				//insert data
				$data = [
					"rns" => number_format((float)$rns, 2, '.', ','),
					"rainfall" => number_format((float)$rainfall, 2, '.', ','),
					"tanggal" => date("Y-m-d", strtotime($tanggal)),
					"location_id" => $location_id,
					"created_at" => date("Y-m-d H:i:s"),
					"is_deleted" => 0
				];

				$this->rns_plan_model->insert($data);

				$tanggal = date("Y-m-d", strtotime($tanggal));

				if ($this->db->trans_status() === FALSE){
					$this->db->trans_rollback();
					
					$return_data = [
						"status"  => false,
						"message" => "Gagal Menambahkan Data Plan",
						"tanggal" =>  $tanggal,
						"data" => array()
					];
				}else{
					$this->db->trans_commit();
					
					$return_data = [
						"status"=>true,
						"message"=> "Berhasil Menambahkan Data Plan",
						"tanggal" =>  $tanggal,
						"data"=>array()
					];
				}
			}else{
				$return_data = [
					"status"=>false,
					"message"=> "Harap Isi Data Dengan Benar",
					"data"=>array()
				];
			}
		}else{
			$return_data = [
				"status"=>false,
				"message"=> "Anda Tidak Memiliki Akses",
				"data"=>array()
			];
		}
		echo json_encode($return_data);
	}

	public function get_data(){
		$tahun = $this->input->post('tahun');
		$bulan = $this->input->post('bulan');
		$location_id = $this->input->post('location_id');
		$tanggal = date("Y-m-d", strtotime($tahun."-".$bulan."-01"));
		$return_data = array(
			"status"=>false,
			"message"=>"",
			"tanggal"=> $tanggal,
			"data"=>array()
		);
		$where = [
			"YEAR(rns_plan.tanggal) = " => $tahun,
			"MONTH(rns_plan.tanggal) = " => sprintf('%02d', $bulan),
			"rns_plan.location_id" => $location_id
		];
		$data = $this->rns_plan_model->getAllById($where);
		
		$result_data = [];
		$tmp_cum_rainfall = 0;
		$tmp_cum_rns = 0;
		if(!empty($data)){
			foreach ($data as $key => $value) {
				$w = new stdClass();
				$w->title = "Rainfall : ".floatVal($value->rainfall);
				$w->start = $value->tanggal;
				$w->borderColor = '#007BFF';
				$w->backgroundColor = '#007BFF';
				array_push($result_data, $w);

				$x = new stdClass();
				$x->title = "RNS : ".floatVal($value->rns);
				$x->start = $value->tanggal;
				$x->borderColor = '#3c763d';
				$x->backgroundColor = '#3c763d';
				array_push($result_data, $x);

				$cum_rainfall = floatVal($value->rainfall) + floatval($tmp_cum_rainfall); 
				$y = new stdClass();
				$y->title = "Cum Rainfall : ".$cum_rainfall;
				$y->start = $value->tanggal;
				$y->borderColor = '#007BFF';
				$y->backgroundColor = '#007BFF';
				array_push($result_data, $y);
				
				$cum_rns = floatVal($value->rns) + floatval($tmp_cum_rns); 
				$z = new stdClass();
				$z->title = "Cum RNS : ".$cum_rns;
				$z->start = $value->tanggal;
				$z->borderColor = '#3c763d';
				$z->backgroundColor = '#3c763d';
				array_push($result_data, $z);

				$tmp_cum_rainfall = $cum_rainfall;
				$tmp_cum_rns = $cum_rns;
			}
		}
		
		if($data){
			$return_data['data'] = $result_data;
			$return_data['status'] = true;
			$return_data['message'] = "Berhasil mengambil data!";
		}else{
			$return_data['message'] = "Gagal mengambil data!";
		}

		echo json_encode($return_data);
	}

	public function cek_data() {
		$tanggal = date("Y-m-d", strtotime($this->input->post('tanggal')));
		$location_id = $this->input->post('location_id');
		
		$return_data = array(
			"status" => false,
			"message" => "",
			"data" => array(),
		);
		$where = [
			"rns_plan.tanggal" => $tanggal,
			"rns_plan.location_id" => $location_id
		];

		$data = $this->rns_plan_model->getOneBy($where);

		if ($data) {
			$return_data['data'] = $data;
			$return_data['status'] = true;
			$return_data['message'] = "Berhasil mengambil data!";
		} else {
			$return_data['message'] = "Gagal mengambil data!";
		}

		echo json_encode($return_data);
	}

}
