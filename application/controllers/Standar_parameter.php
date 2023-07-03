<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'core/Admin_Controller.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class Standar_parameter extends Admin_Controller {
 	public function __construct()
	{
		parent::__construct(); 
	 	$this->load->model('standar_parameter_model');
		$this->load->model('enum_fleet_reason_model');
	}

	public function index()
	{

		$this->load->helper('url');
		if($this->data['is_can_read']){
			$this->data['content'] = 'admin/standar_parameter/list_v'; 	
		}else{
			$this->data['content'] = 'errors/html/restrict'; 
		}
		
		$this->load->view('admin/layouts/page',$this->data);  
	}

	public function import()
	{   
		 
		if (!empty($_FILES))
		{ 
				$location_path = "./uploads/standar_parameter/";
				if(!is_dir($location_path)){
					mkdir($location_path, 0777, TRUE);
				}
				$uploaded      = ("file", $location_path,"template",4);
				$arr_file = [];
				
				if($uploaded['status']==1){
					$nama_template = str_replace(' ', '_', $uploaded['message']);
					
					$path = $location_path . $nama_template.'.xlsx'; 
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
					$spreadsheet = $reader->load($path); 
					$sheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
				}

				$datas = [];
				$start_row = 3;
				$datas_contoh = [];
				$batas = "AI";
				$bulan = $this->input->post('bulan');
				$tahun = date('Y');
                if(!empty($sheet)){
					foreach ($sheet as $key => $value) {
						if($key < 73){
							if($key >= $start_row){
								$tanggal = 1;
								for($i = 'D'; $i <= 'Z'; $i++) {
									$lower = strtolower($value['C']);
									$lower = str_replace(" ", "_", $lower);
									$data_contoh[$tanggal][$lower] = $value[$i];
									$data_contoh[$tanggal]['tanggal'] = $tahun."-".$bulan."-".$tanggal;
									$tanggal++;
									
									if($batas == $i){
										break;
									}
								}
							}
						}
                    }
                }
				if(!empty($data_contoh)){
					if ($this->standar_parameter_model->insert_batch($data_contoh))
					{ 
						$this->session->set_flashdata('message', "standar_parameter Baru Berhasil Disimpan");
						redirect("standar_parameter");
					}
					else
					{
						$this->session->set_flashdata('message_error',"standar_parameter Baru Gagal Disimpan");
						redirect("standar_parameter/create");
					}
				}
		}else{    
			$this->data['content'] = 'admin/standar_parameter/import_v'; 
			$this->data['bulan'] = array(
				1 => 'Januari',
				2 => 'Februari',
				3 => 'Maret',
				4 => 'April',
				5 => 'Mei',
				6 => 'Juni',
				7 => 'Juli',
				8 => 'Agustus',
				9 => 'September',
				10 => 'Oktober',
				11 => 'November',
				12 => 'Desember'
			);
			$this->load->view('admin/layouts/page',$this->data); 
		}
	} 

	public function create()
	{
		if ($this->data['is_can_read']) {
			$this->form_validation->set_rules('tahun',"Tahun Harus Diisi", 'trim|required'); 
			$this->form_validation->set_rules('bulan',"Bulan Harus Diisi", 'trim|required'); 
	
			if ($this->form_validation->run() === TRUE)
			{
				$this->db->trans_begin();
	
				$data  = $this->input->post('data');
				$tahun = $this->input->post('tahun');
				$bulan = $this->input->post('bulan');

				//delete data lama
				$where = [
					"YEAR(standar_parameter.tanggal) = " => $tahun,
					"MONTH(standar_parameter.tanggal) = " => sprintf('%02d', $bulan),
				];
				$delete = $this->standar_parameter_model->delete($where);

				//get id reason
				$reason = $this->enum_fleet_reason_model->getAllById([]);
				$reason_id = [];
				if(!empty($reason)){
					foreach ($reason as $key => $value) {
						$reason_id[$value->status_name][$value->name] = $value->id;
					}
				}

				$data_batch = [];
				if(!empty($data)){
					foreach ($data as $key => $value) {
						if(!empty($value[0])){
							foreach ($value as $k => $v) {
								if($k > 1){
									if(empty($v)){
										$v = 0;
									}
									$tanggal = $k - 1;
									$data_batch[] = [
										"tanggal" => date("Y-m-d", strtotime($tahun."-".$bulan."-".$tanggal)),
										"fleet_reason_id" => $reason_id[$value[0]][$value[1]],
										"nilai" => $v
									];
								}
							}
						}
					}
				}
				$data_insert = [];
				$maksimal = count($data_batch);
				$batas = 500;
				if($maksimal > $batas){
					$jml_request = intVal(ceil($maksimal/$batas));
					for($i=0; $i < $jml_request; $i++){
						$awal = $i*$batas;
						$data_insert[$i] = array_slice($data_batch, $awal, $batas); 
					}
				}else{
					$jml_request = 1;
					$data_insert[0] =  $data_batch;
				}

				$data_sukses = 0;
				for ($i=0; $i < $jml_request; $i++) { 
					if(!empty($data_insert[$i])){
						$insert_batch = $this->standar_parameter_model->insert_batch($data_insert[$i]);
						$data_sukses += $insert_batch;
					}
				}

				if ($this->db->trans_status() === FALSE){
					$this->db->trans_rollback();
					
					$return_data = [
						"status"  => false,
						"message" => "Gagal Menambahkan Standar Parameter",
						"data" => $data_sukses
					];
				}else{
					$this->db->trans_commit();
					
					$return_data = [
						"status"=>true,
						"message"=> "Berhasil Menambahkan Standar Parameter",
						"data"=>array()
					];
				}

				echo json_encode($return_data);
			}else{
				$this->data['bulan'] = getBulan();
				$this->data['content'] = 'admin/standar_parameter/create_v'; 	
				$this->load->view('admin/layouts/page',$this->data);  
			}
		}else{
			$this->data['content'] = 'errors/html/restrict'; 
			$this->load->view('admin/layouts/page',$this->data);  
		}
	}

	public function edit($tahun = null, $bulan = null)
	{  
		if ($this->data['is_can_edit']) {
			$this->form_validation->set_rules('tahun',"Tahun Harus Diisi", 'trim|required'); 
			$this->form_validation->set_rules('bulan',"Bulan Harus Diisi", 'trim|required'); 
	
			if ($this->form_validation->run() === TRUE)
			{
				$this->db->trans_begin();
	
				$data  = $this->input->post('data');
				$tahun = $this->input->post('tahun');
				$bulan = $this->input->post('bulan');

				//delete data lama
				$where = [
					"YEAR(standar_parameter.tanggal) = " => $tahun,
					"MONTH(standar_parameter.tanggal) = " => sprintf('%02d', $bulan),
				];
				$delete = $this->standar_parameter_model->delete($where);

				//get id reason
				$reason = $this->enum_fleet_reason_model->getAllById([]);
				$reason_id = [];
				if(!empty($reason)){
					foreach ($reason as $key => $value) {
						$reason_id[$value->status_name][$value->name] = $value->id;
					}
				}

				$data_batch = [];
				if(!empty($data)){
					foreach ($data as $key => $value) {
						if(!empty($value[0])){
							foreach ($value as $k => $v) {
								if($k > 1){
									if(empty($v)){
										$v = 0;
									}
									$tanggal = $k - 1;
									$data_batch[] = [
										"tanggal" => date("Y-m-d", strtotime($tahun."-".$bulan."-".$tanggal)),
										"fleet_reason_id" => $reason_id[$value[0]][$value[1]],
										"nilai" => $v
									];
								}
							}
						}
					}
				}
				$data_insert = [];
				$maksimal = count($data_batch);
				$batas = 500;
				if($maksimal > $batas){
					$jml_request = intVal(ceil($maksimal/$batas));
					for($i=0; $i < $jml_request; $i++){
						$awal = $i*$batas;
						$data_insert[$i] = array_slice($data_batch, $awal, $batas); 
					}
				}else{
					$jml_request = 1;
					$data_insert[0] =  $data_batch;
				}

				$data_sukses = 0;
				for ($i=0; $i < $jml_request; $i++) { 
					if(!empty($data_insert[$i])){
						$insert_batch = $this->standar_parameter_model->insert_batch($data_insert[$i]);
						$data_sukses += $insert_batch;
					}
				}

				if ($this->db->trans_status() === FALSE){
					$this->db->trans_rollback();
					
					$return_data = [
						"status"  => false,
						"message" => "Gagal Menambahkan Standar Parameter",
						"data" => $data_sukses
					];
				}else{
					$this->db->trans_commit();
					
					$return_data = [
						"status"=>true,
						"message"=> "Berhasil Menambahkan Standar Parameter",
						"data"=>array()
					];
				}

				echo json_encode($return_data);
			}else{
				if(!empty($tahun) && !empty($bulan)){
					$where = [
						"YEAR(tanggal)" => $tahun,
						"MONTH(tanggal)" => $bulan,
					];
					$check = $this->standar_parameter_model->getOneBy($where);
					if(!empty($check)){
						$this->data['tahun_selected'] = $tahun;
						$this->data['bulan_selected'] = $bulan;
						$this->data['bulan'] = getBulan();
						$this->data['content'] = 'admin/standar_parameter/edit_v'; 	
						$this->load->view('admin/layouts/page',$this->data);  
					}else{
						$this->session->set_flashdata('message_error',"Standar Parameter Belum Tersedia");
						redirect("standar_parameter");
					}
				}else{
					$this->data['content'] = 'errors/html/restrict'; 
					$this->load->view('admin/layouts/page',$this->data);  
				}
			}
		}else{
			$this->data['content'] = 'errors/html/restrict'; 
			$this->load->view('admin/layouts/page',$this->data);  
		}
		
	} 

	public function dataList()
	{
		$columns = array( 
            0 =>'id',  
            1 =>'tahun', 
            2 =>'bulan', 
            3 => ''
        );

		
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
  		$search = array();
  		$limit = 0;
  		$start = 0;
        $totalData = $this->standar_parameter_model->getCountAllBy($limit,$start,$search,$order,$dir); 
        

        if(!empty($this->input->post('search')['value'])){
        	$search_value = $this->input->post('search')['value'];
           	$search = array(
           		"standar_parameter.MONTH(tanggal)"=>$search_value,
           	); 
           	$totalFiltered = $this->standar_parameter_model->getCountAllBy($limit,$start,$search,$order,$dir); 
        }else{
        	$totalFiltered = $totalData;
        } 
       
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
     	$datas = $this->standar_parameter_model->getAllBy($limit,$start,$search,$order,$dir);
     	
        $new_data = array();
        if(!empty($datas))
        {
        	 
            foreach ($datas as $key=>$data)
            {  

            	$edit_url = "";
     			$delete_url = "";

            	if($this->data['is_can_edit']){
            		$edit_url = "<a href='".base_url()."standar_parameter/edit/".$data->tahun."/".$data->bulan."' class='btn btn-sm btn-info white'><i class='fa fa-pencil'></i> Ubah</a>";
            	}  
				
            	if($this->data['is_can_delete']){
					$delete_url = "<a href='#' 
						url='".base_url()."standar_parameter/destroy/".$data->tahun."/".$data->bulan."'
						class='btn btn-sm btn-danger white delete'>Hapus
						</a>";
        		}
            	
                $nestedData['id'] = $start+$key+1; 
                $nestedData['tahun'] = $data->tahun; 
                $nestedData['bulan'] = bulan($data->bulan); 
           		$nestedData['action'] = $edit_url." ".$delete_url;   
                $new_data[] = $nestedData; 
            }
        }
          
        $json_data = array(
                    "draw"            => intval($this->input->post('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $new_data   
                    );
            
        echo json_encode($json_data); 
	}
 

	public function destroy($tahun, $bulan)
	{
		$response_data = array();
        $response_data['status'] = false;
        $response_data['msg'] = "";
        $response_data['data'] = array();   

 		if(!empty($bulan)){
 			$this->load->model("standar_parameter_model");

			$where = array(
				'YEAR(tanggal)' => $tahun,
				'MONTH(tanggal)' => $bulan,
			);

			$this->standar_parameter_model->delete($where);

        	$response_data['data'] = $data; 
         	$response_data['status'] = true;
 		}else{
 		 	$response_data['msg'] = "Bulan Harus Diisi";
 		}
		
        echo json_encode($response_data); 
	}

	public function getTanggalAkhir()
	{
		$tahun = $this->input->post('tahun');
		$bulan = $this->input->post('bulan');
		$parameter_form = $this->input->post('parameter_form');
		
		$datas = [];
		$header = ["", ""];
		$body   = [];

		$where = [
			"YEAR(standar_parameter.tanggal)" => $tahun,
			"MONTH(standar_parameter.tanggal)" => $bulan,
		];
		$standar_parameter = $this->standar_parameter_model->getAllById($where);
		$tmp_data = [];
		if(!empty($standar_parameter)){
			foreach ($standar_parameter as $key => $value)
			{
				$tanggal = date('j', strtotime($value->tanggal));
				$tmp_data[$value->fleet_reason_id][$tanggal] = $value->nilai;
			}
		}
		$reason = $this->enum_fleet_reason_model->getAllById([]);
		$max_tanggal = date("t", strtotime($tahun."-".$bulan."-01"));
		
		for ($i=1; $i <= $max_tanggal ; $i++) { 
			$header[] = $i;
		}
		$datas[] = $header;

		foreach ($reason as $key => $val) {
			$data = [
				$val->status_name,
				$val->name,
			];
			for ($i=1; $i <= $max_tanggal ; $i++) { 
				if(isset($tmp_data[$val->id][$i])){
					$data[] = floatVal($tmp_data[$val->id][$i]);
				}
			}
			$datas[] = $data;
		}

		if(!empty($datas)){
			$return_data['datas'] = $datas;
			$return_data['status'] = true;
			$return_data['message'] = "Berhasil mengambil data!";
		}else{
			$return_data['status'] = false;
			$return_data['message'] = "Gagal mengambil data!";
		}
		echo json_encode($return_data);
	}

	public function export(){
			//set widht kolom
			$bulan = $this->input->get('bulan');
			if($bulan <=9){
				$bulan = "0".$bulan;
			}
			$max_tanggal = date("t", strtotime(date('Y')."-".$bulan."-01"));
			$char = range('AA', 'ZZ');
			$no = 1;
			
			$spreadsheet = new Spreadsheet();
            \PhpOffice\PhpSpreadsheet\Cell\Cell::setValueBinder( new \PhpOffice\PhpSpreadsheet\Cell\AdvancedValueBinder() );
                
            $sheet = $spreadsheet->getActiveSheet();

            $sheet->getColumnDimension('C')->setWidth(30);
			for($i = 'D'; $i <= 'Z'; $i++) {
				if($no <= $max_tanggal){
					$sheet->setCellValue($i.'2', $no);
					$akhir = $i;
					$no++;
					$sheet->getColumnDimension($i)->setWidth(20);
				}
			}

            //set header tingkat 1
            $sheet->setCellValue('C3', "Calendar Time");
            $sheet->setCellValue('C4', "Holiday");
            $sheet->setCellValue('C5', "Rostered Hours");
            $sheet->setCellValue('C6', "Rain");
            $sheet->setCellValue('C7', "Slippery");
            $sheet->setCellValue('C8', "Fog");
            $sheet->setCellValue('C9', "Total EOD");
            $sheet->setCellValue('C10', "Rest Time");
            $sheet->setCellValue('C11', "Refueling");
            $sheet->setCellValue('C12', "Safety Talk");
            $sheet->setCellValue('C13', "Blasting");
            $sheet->setCellValue('C14', "Change Shift");
            $sheet->setCellValue('C15', "Friday Pray");
            $sheet->setCellValue('C16', "Moving Equipment");
            $sheet->setCellValue('C17', "Survey");
            $sheet->setCellValue('C18', "Commissioning");
            $sheet->setCellValue('C19', "Demo");
            $sheet->setCellValue('C20', "Due To Safety");
            $sheet->setCellValue('C21', "Electric");
            $sheet->setCellValue('C22', "Fatigue");
            $sheet->setCellValue('C23', "Front Repair");
            $sheet->setCellValue('C24', "Front Preparation");
            $sheet->setCellValue('C25', "Ibadah");
            $sheet->setCellValue('C26', "Internal Problem");
            $sheet->setCellValue('C27', "Lube and Grease");
            $sheet->setCellValue('C28', "Meal");
            $sheet->setCellValue('C29', "Mobilisasi");
            $sheet->setCellValue('C30', "No Dump");
            $sheet->setCellValue('C31', "No Fuel");
            $sheet->setCellValue('C32', "No Job");
            $sheet->setCellValue('C33', "No Location");
            $sheet->setCellValue('C34', "No Material");
            $sheet->setCellValue('C35', "No Operator");
            $sheet->setCellValue('C36', "No Support Equipment");
            $sheet->setCellValue('C37', "No Truck");
            $sheet->setCellValue('C38', "No Waiting Job");
            $sheet->setCellValue('C39', "Out of fuel");
            $sheet->setCellValue('C40', "P2h");
            $sheet->setCellValue('C41', "P5M");
            $sheet->setCellValue('C42', "Praying");
            $sheet->setCellValue('C43', "Road Repair");
            $sheet->setCellValue('C44', "Schedule Change Shift");
            $sheet->setCellValue('C45', "Set Up Work Area");
            $sheet->setCellValue('C46', "Stop Lebih Awal");
            $sheet->setCellValue('C47', "Travel");
            $sheet->setCellValue('C48', "Unit Belum Dialokasikan");
            $sheet->setCellValue('C49', "Wait Coal Cleaning");
            $sheet->setCellValue('C50', "Wait Coal Stocking");
            $sheet->setCellValue('C51', "Waiting Hauler");
            $sheet->setCellValue('C52', "Waiting Instruction");
            $sheet->setCellValue('C53', "Waiting Operator");
            $sheet->setCellValue('C54', "Waiting Unit Trouble");
            $sheet->setCellValue('C55', "Total IOD");
            $sheet->setCellValue('C56', "Available Time");
            $sheet->setCellValue('C57', "Schedule Maintenance");
            $sheet->setCellValue('C58', "Unschedule Maintenance");
            $sheet->setCellValue('C59', "Maintenance Delay");
            $sheet->setCellValue('C60', "Overburden");
            $sheet->setCellValue('C61', "Coal Getting");
            $sheet->setCellValue('C62', "Coal Cleaning");
            $sheet->setCellValue('C63', "Coal Stocking");
            $sheet->setCellValue('C64', "Clearing");
            $sheet->setCellValue('C65', "General");
            $sheet->setCellValue('C66', "Working Time");
            $sheet->setCellValue('C67', "Production OB");
            $sheet->setCellValue('C68', "Production Coal");
            $sheet->setCellValue('C69', "Productivity OB");
            $sheet->setCellValue('C70', "Productivity Coal");

            //set fill warna kuning
            $sheet->getStyle('D2:'.$akhir.'2')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('D3D3D3');
			$sheet->getStyle('C3:C70')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('D3D3D3');

            
            $x = 2;

            //set border
            $batas_akhir = intval($x) - 1;
            $styleArray = [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '00000000'],
                    ],
                ],
            ];
            $sheet->getStyle('C2:'.$akhir.'70')->applyFromArray($styleArray);
			
            $writer = new Xlsx($spreadsheet);

			$time = time();
            
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="template-'.$time.'.xlsx"'); 
            header('Cache-Control: max-age=0');
    
            $writer->save('php://output');
	}
}
