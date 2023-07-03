<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'core/Admin_Controller.php';
class Fuel_plan extends Admin_Controller 
{
	public function __construct() 
    {
		parent::__construct();
		$this->load->model('fuel_plan_model');
		$this->load->model('location_model');
		$this->load->model('user_mutation_model');
		$this->load->model('unit_model');
	}

	public function index() 
    {
		$this->load->helper('url');
		if ($this->data['is_can_read']) {
            $where_location = [
                "location.id !=" => 1,
                "location.is_deleted" => 0
            ];
            $location_id = $this->user_mutation_model->getLastLocation($this->data['users']->id);
            if(!empty($location_id)){
                $where_location["location.id"] = $location_id;
            }
            $this->data['locations'] = $this->location_model->getAllById($where_location);

            $this->data['bulan'] = getBulan();

			$this->data['content'] = 'admin/fuel_plan/list_v';
		} else {
			$this->data['content'] = 'errors/html/restrict';
		}

		$this->load->view('admin/layouts/page', $this->data);
	}


	public function create() 
    {
        if ($this->data['is_can_read']) {
            $this->data['bulan'] = getBulan();
            
            $where_location = [
                "location.id !=" => 1,
                "location.is_deleted" => 0
            ];
            $location_id = $this->user_mutation_model->getLastLocation($this->data['users']->id);
            if(!empty($location_id)){
                $where_location["location.id"] = $location_id;
            }
            $this->data['locations'] = $this->location_model->getAllById($where_location);

            $this->data['content'] = 'admin/fuel_plan/create_v';
        } else {
            $this->data['content'] = 'errors/html/restrict';
        }

        $this->load->view('admin/layouts/page', $this->data);
	}

	public function dataList() 
    {
        $location_id = $this->input->post("location_id");
        $bulan = $this->input->post("bulan");
        $tahun = $this->input->post("tahun");
        $where =[
			"YEAR(fuel_plan.tanggal)" => $tahun,
			"MONTH(fuel_plan.tanggal)" => $bulan,
		];

        if(!empty($location_id)){
			$where["fuel_plan.location_id"] = $location_id;
		}

        $fuel_plan = $this->fuel_plan_model->getAllGroupByUnit($where);
        $tmp_datas = [];
        $data_total = ["total" => 0];
        if(!empty($fuel_plan)){
            foreach ($fuel_plan as $key => $value) {
                $tanggal = date("j", strtotime($value->tanggal));
                if(!empty($tmp_datas[$value->unit_id])){
                    $tmp_datas[$value->unit_id]["datas"][$tanggal] = $value->total; 
                    $tmp_datas[$value->unit_id]["total"] += $value->total; 
                }else{
                    $tmp_datas[$value->unit_id] = [
                        "id"    => $value->unit_id,
                        "name"  => $value->kode." - ".$value->brand_name." - ".$value->model_name,
                        "total" => $value->total,
                        "datas" => [
                            $tanggal => $value->total
                        ]
                    ];
                }
                $data_total["total"] += $value->total;
                if(!empty($data_total[$tanggal])){
                    $data_total[$tanggal] += $value->total;
                }else{
                    $data_total[$tanggal] = $value->total;
                }
            }
        }

        //reset indexing
        $datas = [];
        if(!empty($tmp_datas)){
            foreach ($tmp_datas as $key => $value) {
                $x = new stdClass();
                $x->id = $value["id"];
                $x->name = $value["name"];
                $x->total = $value["total"];
                $x->datas = $value["datas"];
                array_push($datas, $x);
            }
        }

        $akhir_bulan = date("t", strtotime($tahun."-".$bulan));

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

    public function getUnit()
	{
		$id = $this->input->post("id");

        $where_unit = [
            "unit_transfer.to_location" => $id,
            "unit.is_deleted" => 0
        ];
		$unit = $this->unit_model->getAllByLocation($where_unit);

		if(!empty($unit)){
            $response_data['status'] = true;
            $response_data['data'] = $unit;
            $response_data['message'] = 'Berhasil Mengambil Data';
        }else{
            $response_data['status'] = false;
            $response_data['data'] = [];
            $response_data['message'] = 'Gagal Mengambil Data';
        }

        echo json_encode($response_data);
	}

    public function get_data()
    {
		$tahun = $this->input->post('tahun');
		$bulan = $this->input->post('bulan');
		$unit  = $this->input->post('unit');
		$tanggal = date("Y-m-d", strtotime($tahun."-".$bulan."-01"));
		$return_data = array(
			"status"=>false,
			"message"=>"",
			"tanggal"=> $tanggal,
			"data"=>array()
		);
		$where = [
			"YEAR(fuel_plan.tanggal) = " => $tahun,
			"MONTH(fuel_plan.tanggal) = " => sprintf('%02d', $bulan),
			"fuel_plan.unit_id" => $unit
		];
		$data = $this->fuel_plan_model->getAllById($where);
		
		$result_data = [];
		if(!empty($data)){
			foreach ($data as $key => $value) {
				$x = new stdClass();
				$x->title = number_format((float)$value->nilai, 2, '.', ',');
				$x->start = $value->tanggal;
				$x->borderColor = '#007BFF';
				$x->backgroundColor = '#007BFF';

				array_push($result_data, $x);
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

    public function input_data()
	{
		if ($this->data['is_can_read']) {
			$this->form_validation->set_rules('location_id',"Lokasi Harus Diisi", 'trim|required'); 
			$this->form_validation->set_rules('nilai',"Nilai Harus Diisi", 'trim|required'); 
			$this->form_validation->set_rules('tahun',"Tahun Harus Diisi", 'trim|required'); 
			$this->form_validation->set_rules('bulan',"Bulan Harus Diisi", 'trim|required'); 
			$this->form_validation->set_rules('unit',"Unit Harus Diisi", 'trim|required'); 
	
			if ($this->form_validation->run() === TRUE)
			{
				$this->db->trans_begin();
	
				$location_id = $this->input->post('location_id');
				$nilai = $this->input->post('nilai');
				$tahun = $this->input->post('tahun');
				$bulan = $this->input->post('bulan');
				$unit  = $this->input->post('unit');
	
				//delete data lama
				$where = [
					"YEAR(fuel_plan.tanggal) = " => $tahun,
					"MONTH(fuel_plan.tanggal) = " => sprintf('%02d', $bulan),
					"fuel_plan.unit_id" => $unit
				];
				$delete = $this->fuel_plan_model->delete($where);
	
				//make batch data
				$data_batch = [];
				$max_date = date("t", strtotime($tahun."-".$bulan."-01"));
				$hasil_bagi = $nilai/$max_date;
				for ($i=1; $i <= $max_date ; $i++) { 
					$data_batch[] = [
						"location_id" => $location_id,
						"nilai" => number_format((float)$hasil_bagi, 2, '.', ','),
						"tanggal" => date("Y-m-d", strtotime($tahun."-".$bulan."-".$i)),
						"unit_id" => $unit,
						"is_deleted" => 0
					];
				}
				if(!empty($data_batch)){
					$this->fuel_plan_model->insert_batch($data_batch);
				}
				$tanggal = date("Y-m-d", strtotime($tahun."-".$bulan."-01"));
				if ($this->db->trans_status() === FALSE){
					$this->db->trans_rollback();
					
					$return_data = [
						"status"  => false,
						"message" => "Gagal Menambahkan Data Fuel Plan",
						"tanggal" =>  $tanggal,
						"data" => array()
					];
				}else{
					$this->db->trans_commit();
					
					$return_data = [
						"status"=>true,
						"message"=> "Berhasil Menambahkan Data Fuel Plan",
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
}
