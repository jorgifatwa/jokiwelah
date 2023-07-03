<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'core/Admin_Controller.php';
class Activity extends Admin_Controller {
 	public function __construct()
	{
		parent::__construct(); 
	 	$this->load->model('activity_model');
	}

	public function index()
	{

		$this->load->helper('url');
		if($this->data['is_can_read']){
			$this->data['content'] = 'admin/activity/list_v'; 	
		}else{
			$this->data['content'] = 'errors/html/restrict'; 
		}
		
		$this->load->view('admin/layouts/page',$this->data);  
	}

	public function create()
	{  
		$this->form_validation->set_rules('breakdown_id',"Breakdown ID Harus Diisi", 'trim|required'); 
		$this->form_validation->set_rules('tanggal',"Tanggal Harus Diisi", 'trim|required'); 
		$this->form_validation->set_rules('start',"Start Harus Diisi", 'trim|required'); 
		$this->form_validation->set_rules('stop',"Stop Harus Diisi", 'trim|required'); 
		$this->form_validation->set_rules('time_down',"Waktu Habis Harus Diisi", 'trim|required'); 
		$this->form_validation->set_rules('hm',"HM Harus Diisi", 'trim|required'); 
		$this->form_validation->set_rules('trouble_description',"Deskripsi Masalah Harus Diisi", 'trim|required'); 
		$this->form_validation->set_rules('activity',"Aktivitas Harus Diisi", 'trim|required'); 
		$this->form_validation->set_rules('status',"Status Harus Diisi", 'trim|required'); 
		$this->form_validation->set_rules('component_freq',"Komponen Frekuensi Harus Diisi", 'trim|required'); 
		$this->form_validation->set_rules('component_dura',"Komponen Durasi Harus Diisi", 'trim|required'); 
		 
		if ($this->form_validation->run() === TRUE)
		{ 
			$tanggal = date("Y-m-d", strtotime($this->input->post("tanggal")));

			$data = array(
				'breakdown_id' => $this->input->post('breakdown_id'), 
				'tanggal' => $tanggal, 
				'start' => $this->input->post('start'), 
				'stop' => $this->input->post('stop'), 
				'time_down' => $this->input->post('time_down'), 
				'hm' => $this->input->post('hm'), 
				'trouble' => $this->input->post('trouble_description'), 
				'activity' => $this->input->post('activity'), 
				'status' => $this->input->post('status'), 
				'component_freq' => $this->input->post('component_freq'), 
				'component_dura' => $this->input->post('component_dura')
			); 
			if ($this->activity_model->insert($data))
			{ 
				$this->session->set_flashdata('message', "Aktivitas Baru Berhasil Disimpan");
				redirect("breakdown/activity/".$this->input->post('breakdown_id'));
			}
			else
			{
				$this->session->set_flashdata('message_error',"Aktivitas Baru Gagal Disimpan");
				redirect("breakdown/activity/".$this->input->post('breakdown_id'));
			}
		}else{    
			$this->data['content'] = 'admin/activity/create_v';
			$this->data['breakdown_id'] = $this->uri->segment(3);
			$this->load->view('admin/layouts/page',$this->data); 
		}
	} 

	public function edit($id)
	{  
		$this->form_validation->set_rules('breakdown_id',"Breakdown ID Harus Diisi", 'trim|required'); 
		$this->form_validation->set_rules('tanggal',"Tanggal Harus Diisi", 'trim|required'); 
		$this->form_validation->set_rules('start',"Start Harus Diisi", 'trim|required'); 
		$this->form_validation->set_rules('stop',"Stop Harus Diisi", 'trim|required'); 
		$this->form_validation->set_rules('time_down',"Waktu Habis Harus Diisi", 'trim|required'); 
		$this->form_validation->set_rules('hm',"HM Harus Diisi", 'trim|required'); 
		$this->form_validation->set_rules('trouble_description',"Deskripsi Masalah Harus Diisi", 'trim|required'); 
		$this->form_validation->set_rules('activity',"Aktivitas Harus Diisi", 'trim|required'); 
		$this->form_validation->set_rules('status',"Status Harus Diisi", 'trim|required'); 
		$this->form_validation->set_rules('component_freq',"Komponen Frekuensi Harus Diisi", 'trim|required'); 
		$this->form_validation->set_rules('component_dura',"Komponen Durasi Harus Diisi", 'trim|required'); 
		 
		if ($this->form_validation->run() === TRUE)
		{ 
			$tanggal = date("Y-m-d", strtotime($this->input->post("tanggal")));
			
			$data = array(
				'breakdown_id' => $this->input->post('breakdown_id'), 
				'tanggal' => $tanggal, 
				'start' => $this->input->post('start'), 
				'stop' => $this->input->post('stop'), 
				'time_down' => $this->input->post('time_down'), 
				'hm' => $this->input->post('hm'), 
				'trouble' => $this->input->post('trouble_description'), 
				'activity' => $this->input->post('activity'), 
				'status' => $this->input->post('status'), 
				'component_freq' => $this->input->post('component_freq'), 
				'component_dura' => $this->input->post('component_dura')
			); 
			$update = $this->activity_model->update($data,array("breakdown_detail.id"=>$id));
			if ($update)
			{ 
				$this->session->set_flashdata('message', "Aktivitas Berhasil Diubah");
				redirect("breakdown/activity/".$this->input->post('breakdown_id'),"refresh");
			}else{
				$this->session->set_flashdata('message_error', "Aktivitas Gagal Diubah");
				redirect("breakdown/activity/".$this->input->post('breakdown_id'),"refresh");
			}
		} 
		else
		{
			if(!empty($_POST)){ 
				$id = $this->input->post('id'); 
				$this->session->set_flashdata('message_error',validation_errors());
				return redirect("activity/edit/".$id);	
			}else{
				$this->data['id']= $this->uri->segment(3);
				$activity = $this->activity_model->getAllById(array("breakdown_detail.id"=>$this->data['id']));  
				$this->data['breakdown_id'] =   (!empty($activity))?$activity[0]->breakdown_id:"";
				$this->data['tanggal'] =   (!empty($activity))?$activity[0]->tanggal:"";
				$this->data['start'] =   (!empty($activity))?$activity[0]->start:""; 
				$this->data['stop'] =   (!empty($activity))?$activity[0]->stop:""; 
				$this->data['time_down'] =   (!empty($activity))?$activity[0]->time_down:""; 
				$this->data['hm'] =   (!empty($activity))?$activity[0]->hm:""; 
				$this->data['trouble'] =   (!empty($activity))?$activity[0]->trouble:""; 
				$this->data['activity'] =   (!empty($activity))?$activity[0]->activity:""; 
				$this->data['status'] =   (!empty($activity))?$activity[0]->status:""; 
				$this->data['component_freq'] =   (!empty($activity))?$activity[0]->component_freq:""; 
				$this->data['component_dura'] =   (!empty($activity))?$activity[0]->component_dura:""; 
				
				$this->data['content'] = 'admin/activity/edit_v'; 
				$this->load->view('admin/layouts/page',$this->data); 
			}  
		}    
		
	} 

	public function dataList()
	{

		 $columns = array( 
            0 =>'id',  
            1 =>'start', 
            2=> 'stop',
            3=> 'time_down',
            4=> 'hours',
            5=> 'trouble',
            6=> 'activity',
            7=> 'status',
            8=> 'component_freq',
            9=> 'component_dura',
			10=>''
        );

		
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
  		$search = array();
		$where = array('breakdown_id' => $this->uri->segment(3));
  		$limit = 0;
  		$start = 0;
        $totalData = $this->activity_model->getCountAllBy($limit,$start,$search,$order,$dir, $where); 
        

        if(!empty($this->input->post('search')['value'])){
        	$search_value = $this->input->post('search')['value'];
           	$search = array(
           		"breakdown_detail.start"=>$search_value,
           		"breakdown_detail.stop"=>$search_value,
           		"breakdown_detail.time_down"=>$search_value,
           		"breakdown_detail.trouble"=>$search_value,
           		"breakdown_detail.activity"=>$search_value,
           		"breakdown_detail.component_freq"=>$search_value,
           		"breakdown_detail.component_dura"=>$search_value,
           	); 
           	$totalFiltered = $this->activity_model->getCountAllBy($limit,$start,$search,$order,$dir, $where); 
        }else{
        	$totalFiltered = $totalData;
        } 
       
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
     	$datas = $this->activity_model->getAllBy($limit,$start,$search,$order,$dir, $where);
     	
        $new_data = array();
        if(!empty($datas))
        {
        	 
            foreach ($datas as $key=>$data)
            {  

            	$edit_url = "";
     			$delete_url = "";
     		
            	if($this->data['is_can_edit'] && $data->is_deleted == 0){
            		$edit_url = "<a href='".base_url()."activity/edit/".$data->id."' class='btn btn-sm btn-info white'><i class='fa fa-pencil'></i> Ubah</a>";
            	}  
            	if($this->data['is_can_delete']){
					$delete_url = "<a href='#' 
						url='".base_url()."activity/destroy/".$data->id."/".$data->is_deleted."'
						class='btn btn-sm btn-danger white delete'><span class='fa fa-trash'></span> Hapus
						</a>";
        		}
            	
                $nestedData['id'] = $start+$key+1; 
                $nestedData['tanggal'] = $data->tanggal; 
                $nestedData['start'] = $data->start; 
                $nestedData['hm'] = $data->hm; 
                $nestedData['stop'] = $data->stop; 
                $nestedData['time_down'] = $data->time_down; 
                $nestedData['activity'] = $data->activity; 
                $nestedData['status'] = $data->status; 
                $nestedData['component_freq'] = $data->component_freq; 
                $nestedData['component_dura'] = $data->component_dura; 
                $nestedData['trouble'] = substr(strip_tags($data->trouble),0,50);
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
 			$this->load->model("activity_model");
			$data = array(
				'is_deleted' => ($is_deleted == 1)?0:1
			); 
			$update = $this->activity_model->update($data,array("id"=>$id));

        	$response_data['data'] = $data; 
			$response_data['msg'] = "Aktivitas Berhasil di Hapus";
         	$response_data['status'] = true;
 		}else{
 		 	$response_data['msg'] = "ID Harus Diisi";
 		}
		
        echo json_encode($response_data); 
	}
}
