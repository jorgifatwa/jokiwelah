<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'core/Admin_Controller.php';
class Dewatering_pump extends Admin_Controller {
 	public function __construct()
	{
		parent::__construct(); 
	 	$this->load->model('dewatering_pump_model');
	 	$this->load->model('user_mutation_model');
	 	$this->load->model('unit_model');
	 	$this->load->model('location_model');
	 	$this->load->model('equipment_model');
	 	$this->load->model('equipment_event_model');
	 	$this->load->model('user_model');
	}

	public function index()
	{

		$this->load->helper('url');
		if($this->data['is_can_read']){
			$this->data['content'] = 'admin/dewatering_pump/list_v'; 	
		}else{
			$this->data['content'] = 'errors/html/restrict'; 
		}
		
		$this->load->view('admin/layouts/page',$this->data);  
	}

	public function create()
	{  
		$this->form_validation->set_rules('location_id',"Lokasi Harus Diisi", 'trim|required'); 
		$this->form_validation->set_rules('shift',"Shift Harus Diisi", 'trim|required'); 
		 
		if ($this->form_validation->run() === TRUE)
		{ 
			$this->db->trans_begin();
			$location_id = $this->input->post('location_id');
			
			$shift 			= $this->input->post("shift"); 
			$operator_id 	= implode(",", $this->input->post("operator_id")); 
			$catatan 		= $this->input->post("catatan"); 

			$data = array(
				'location_id' 		=> $location_id, 
				'shift' 			=> $shift, 
				'operator_id' 		=> $operator_id, 
				'catatan' 			=> $catatan,
				'created_at' 		=> date('Y-m-d h:i:s'),
				'created_by' 		=> $this->data['users']->user_id,
				'is_deleted'		=> 0
			);
			$insert = $this->dewatering_pump_model->insert($data);
			
			//insert equipment event
			$unit 	= $this->input->post("unit");
			$event 	= $this->input->post("event");
			$start 	= $this->input->post("start");
			$end 	= $this->input->post("end");
			$data_batch = [];
			foreach ($unit as $key => $value) {
				$jam_start 	= date("Y-m-d H:i:s", strtotime($start[$key]));
				$jam_end 	= date("Y-m-d H:i:s", strtotime($end[$key]));
				$data_batch[] = [ 
					'dewatering_pump_id' => $insert,
					'unit_id' => $value,
					'equipment_id' => $event[$key],
					'jam_kerja_start' => $jam_start,
					'jam_kerja_end' => $jam_end,
				];
			}
			$insert_batch = $this->equipment_event_model->insert_batch($data_batch);

			if ($this->db->trans_status() === FALSE){  
				$this->db->trans_rollback();
				$this->session->set_flashdata('message_error',"Dewatering Pump Baru Gagal Disimpan");
				redirect("dewatering_pump");
			}else{
				$this->db->trans_commit();
				$this->session->set_flashdata('message', "Dewatering Pump Baru Berhasil Disimpan");
				redirect("dewatering_pump");
			}
		}else{    
			$this->data['content'] = 'admin/dewatering_pump/create_v'; 
			$user_id = $this->data['users']->id;
			$location_id = $this->user_mutation_model->getLastLocation($this->data['users']->id);

			if(empty($location_id)){
				$location_id = 1;
			}

			$where_location = [
				"location.id" => $location_id,
				"location.is_deleted" => 0
			];
			$this->data['location'] = $this->location_model->getOneBy($where_location);
		
			$where_operator = [
				'user_mutation.to_location' => $location_id
			];
			$this->data['operators'] = $this->user_mutation_model->getOperator($where_operator);

			$where_unit = [
				// 'unit_transfer.to_location' => $location_id,
				"operasi_sebagai" => 2
			];
			$this->data['units'] = $this->unit_model->getAllByLocation($where_unit);

			$this->data['equipments'] = $this->equipment_model->getAllById();
			$this->load->view('admin/layouts/page',$this->data); 
		}
	} 

	public function edit($id)
	{  
		$this->form_validation->set_rules('location_id',"Lokasi Harus Diisi", 'trim|required'); 
		$this->form_validation->set_rules('shift',"Shift Harus Diisi", 'trim|required'); 
		 
		if ($this->form_validation->run() === TRUE)
		{ 
			$this->db->trans_begin();
			$id = $this->input->post('id');
			$location_id = $this->input->post('location_id');
			
			$shift 			= $this->input->post("shift"); 
			$operator_id 	= implode(",", $this->input->post("operator_id")); 
			$catatan 		= $this->input->post("catatan"); 

			$data = array(
				'location_id' 		=> $location_id, 
				'shift' 			=> $shift, 
				'operator_id' 		=> $operator_id, 
				'catatan' 			=> $catatan,
				'updated_at' 		=> date('Y-m-d h:i:s'),
				'updated_by' 		=> $this->data['users']->user_id
			);
			$update = $this->dewatering_pump_model->update($data, ["id" => $id]);

			//delete equipment event
			$delete = $this->equipment_event_model->delete(['dewatering_pump_id' => $id]);

			//insert equipment event
			$unit 	= $this->input->post("unit");
			$event 	= $this->input->post("event");
			$start 	= $this->input->post("start");
			$end 	= $this->input->post("end");
			$data_batch = [];
			foreach ($unit as $key => $value) {
				$jam_start 	= date("Y-m-d H:i:s", strtotime($start[$key]));
				$jam_end 	= date("Y-m-d H:i:s", strtotime($end[$key]));
				$data_batch[] = [ 
					'dewatering_pump_id' => $id,
					'unit_id' => $value,
					'equipment_id' => $event[$key],
					'jam_kerja_start' => $jam_start,
					'jam_kerja_end' => $jam_end,
				];
			}
			$insert_batch = $this->equipment_event_model->insert_batch($data_batch);

			if ($this->db->trans_status() === FALSE){  
				$this->db->trans_rollback();
				$this->session->set_flashdata('message_error',"Dewatering Pump Baru Gagal Diubah");
				redirect("dewatering_pump");
			}else{
				$this->db->trans_commit();
				$this->session->set_flashdata('message', "Dewatering Pump Baru Berhasil Diubah");
				redirect("dewatering_pump");
			}
		} 
		else
		{
			if(!empty($_POST)){ 
				$id = $this->input->post('id'); 
				$this->session->set_flashdata('message_error',validation_errors());
				return redirect("dewatering_pump/edit/".$id);	
			}else{

				$dewatering_pump = $this->dewatering_pump_model->getOneBy(["dewatering_pump.id"=>$id]);  
				if(!empty($dewatering_pump)){
					$this->data['dwp'] = $dewatering_pump;
					$this->data['equipment_event'] = $this->equipment_event_model->getAllById(["dewatering_pump_id" => $id]);

					if(!empty($dewatering_pump->operator_id)){
						$this->data['operator'] = explode(",", $dewatering_pump->operator_id);
					}else{
						$this->data['operator'] = [];
					}
					$user_id = $this->data['users']->id;
	
					$location_id = $dewatering_pump->location_id;
	
					$where_location = [
						"location.id" => $location_id,
						"location.is_deleted" => 0
					];
					$this->data['location'] = $this->location_model->getOneBy($where_location);
				
					$where_operator = [
						'users_roles.role_id' => 4,
						'user_mutation.to_location' => $location_id
					];
					$this->data['operators'] = $this->user_mutation_model->getOperator($where_operator);
	
					$where_unit = [
						'unit_transfer.to_location' => $location_id,
						"operasi_sebagai" => 2
					];
					$this->data['units'] = $this->unit_model->getAllByLocation($where_unit);
	
					$this->data['equipments'] = $this->equipment_model->getAllById();
					
					$this->data['content'] = 'admin/dewatering_pump/edit_v'; 
				}else{
					$this->session->set_flashdata('message_error', "Dewatering Pump Tidak Tersedia");
					redirect("dewatering_pump","refresh");
				}
				$this->load->view('admin/layouts/page',$this->data); 
			}  
		}    
		
	} 

	public function dataList()
	{
		$columns = array( 
            0 =>'location_name',  
            1 =>'shift', 
            2 =>'operator_id', 
            3 =>'equipment_name',
            4 =>''
        );

		
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
  		$search = array();
  		$limit = 0;
  		$start = 0;
        $totalData = $this->dewatering_pump_model->getCountAllBy($limit,$start,$search,$order,$dir); 
        

        if(!empty($this->input->post('search')['value'])){
        	$search_value = $this->input->post('search')['value'];
           	$search = array(
           		"dewatering_pump.shift"=>$search_value,
           		"location.name"=>$search_value
           	); 
           	$totalFiltered = $this->dewatering_pump_model->getCountAllBy($limit,$start,$search,$order,$dir); 
        }else{
        	$totalFiltered = $totalData;
        } 
       
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
     	$datas = $this->dewatering_pump_model->getAllBy($limit,$start,$search,$order,$dir);
     	
        $new_data = array();
        if(!empty($datas))
        {
        	 
            foreach ($datas as $key=>$data)
            {  

            	$edit_url = "";
     			$delete_url = "";
     		
            	if($this->data['is_can_edit'] && $data->is_deleted == 0){
            		$edit_url = "<a href='".base_url()."dewatering_pump/edit/".$data->id."' class='btn btn-sm btn-info white'><i class='fa fa-pencil'></i> Ubah</a>";
            	}  
            	if($this->data['is_can_delete']){
					$delete_url = "<a href='#' 
						url='".base_url()."dewatering_pump/destroy/".$data->id."/".$data->is_deleted."'
						class='btn btn-sm btn-danger white remove'> Hapus
						</a>";
        		}
				
				if(!empty($data->operator_id)){
					$where_in = explode(",", $data->operator_id);
					$data_operator = $this->user_model->getUserWhereIn($where_in);
					$operator = "";
					if(!empty($data_operator)){
						$tmp_operator = [];
						foreach ($data_operator as $value) {
							$tmp_operator[] = $value->first_name;
						}
						$operator = implode(", ", $tmp_operator);
					}
				}else{
					$operator = "";
				}
				

            	
                $nestedData['id'] = $start+$key+1; 
                $nestedData['location_name'] = $data->location_name; 
                $nestedData['shift'] = $data->shift; 
                $nestedData['operator'] = $operator; 
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
 

	public function destroy(){
		$response_data = array();
        $response_data['status'] = false;
        $response_data['msg'] = "";
        $response_data['data'] = array();   

		$id =$this->uri->segment(3);
		$is_deleted = $this->uri->segment(4);
 		if(!empty($id)){
 			$this->load->model("dewatering_pump_model");
			$data = array(
				'is_deleted' => ($is_deleted == 1)?0:1
			); 
			$update = $this->dewatering_pump_model->update($data,array("id"=>$id));

        	$response_data['data'] = $data; 
			$response_data['msg'] = "Dewatering Pump Berhasil di Hapus";
         	$response_data['status'] = true;
 		}else{
 		 	$response_data['msg'] = "ID Harus Diisi";
 		}
		
        echo json_encode($response_data); 
	}
}
