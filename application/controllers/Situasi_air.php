<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'core/Admin_Controller.php';
class Situasi_air extends Admin_Controller 
{	
    public function __construct() 
    {
		parent::__construct();
		$this->load->model('blok_model');
		$this->load->model('seam_model');
		$this->load->model('location_model');
		$this->load->model('situasi_air_model');
		$this->load->model('situasi_air_pompa_model');
		$this->load->model('situasi_air_volume_model');
		$this->load->model('user_mutation_model');
		$this->load->model('unit_model');
	}

	public function index() 
    {
		$this->load->helper('url');
		if ($this->data['is_can_read'])
        {
			$this->data['content'] = 'admin/situasi_air/list_v';
		} else {
			$this->data['content'] = 'errors/html/restrict';
		}

		$this->load->view('admin/layouts/page', $this->data);
	}

	public function create() 
    {
        if ($this->data['is_can_read']) 
        {
            $this->form_validation->set_rules('waktu', "Waktu Harus Diisi", 'trim|required');
            if ($this->form_validation->run() === TRUE) 
            {
                $this->db->trans_begin();
                
                $waktu = date("Y-m-d H:i:s", strtotime($this->input->post("waktu")));
                $location_id = $this->user_mutation_model->getLastLocation($this->data['users']->id);
                
                //insert situasi air
                $data = [
                    "waktu" => $waktu,
                    "location_id" => $location_id,
                    "created_at" => date("Y-m-d H:i:s"),
                    "updated_at" => date("Y-m-d H:i:s"),
                    "created_by" => $this->data["users"]->id,
                    "updated_by" => $this->data["users"]->id,
                    "is_deleted" => 0
                ];
                $insert  = $this->situasi_air_model->insert($data);
                
                
                //insert situasi air volume
                $seam_id = $this->input->post("seam_id");
                if(!empty($seam_id)){
                    $blok_start             = $this->input->post("blok_start");
                    $blok_end               = $this->input->post("blok_end");
                    $ketinggian_air         = $this->input->post("ketinggian_air");
                    $estimasi_total_air     = $this->input->post("estimasi_total_air");
                    $estimasi_total_lumpur  = $this->input->post("estimasi_total_lumpur");
                    
                    $batch_volume = [];
                    foreach ($seam_id as $key => $value) {
                        $batch_volume[] = [
                            "situasi_air_id"        => $insert,
                            "seam_id"               => $value,
                            "blok_start"            => $blok_start[$key],
                            "blok_end"              => $blok_end[$key],
                            "ketinggian_air"        => $ketinggian_air[$key],
                            "estimasi_total_air"    => $estimasi_total_air[$key],
                            "estimasi_total_lumpur" => $estimasi_total_lumpur[$key],
                        ];
                    }
                    
                    $insert_volume = $this->situasi_air_volume_model->insert_batch($batch_volume);
                }
                
               
                //insert situasi pompa
                $unit_id = $this->input->post("unit_id");
                if(!empty($unit_id)){
                    $status_unit    = $this->input->post("status_unit");
                    
                    $batch_pompa = [];
                    foreach ($unit_id as $key => $value) {
                        $batch_pompa[] = [
                            "situasi_air_id"        => $insert,
                            "unit_id"               => $value,
                            "status_unit"           => $status_unit[$key]
                        ];
                    }
    
                    $insert_pompa = $this->situasi_air_pompa_model->insert_batch($batch_pompa);
                }
    
                if ($this->db->trans_status() === FALSE){
                    $this->db->trans_rollback();
                    
                    $this->session->set_flashdata('message_error', "Situasi Air Baru Gagal Disimpan");
                    redirect("situasi_air");
                }else{
                    $this->db->trans_commit();
                    
                    $this->session->set_flashdata('message', "Situasi Air Baru Berhasil Disimpan");
                    redirect("situasi_air");
                }
            } else {
                $location_id = $this->user_mutation_model->getLastLocation($this->data['users']->id);
                $where_seam = ["seam.is_deleted" => 0];
                $where_unit = ["unit.is_deleted" => 0];
                if(!empty($location_id)){
                    $where_seam["seam.location_id"] = $location_id; 
                }

                $this->data['seam'] = $this->seam_model->getAllById($where_seam);
                
                if(!empty($location_id)){
                    $where_unit["unit_transfer.to_location"] = $location_id; 
                }
                $this->data['unit'] = $this->unit_model->getAllByLocation($where_unit);
                $this->data['content'] = 'admin/situasi_air/create_v';
                $this->load->view('admin/layouts/page', $this->data);
            }
        }else{
            $this->data['content'] = 'errors/html/restrict';
            $this->load->view('admin/layouts/page', $this->data);
        }
	}

	public function edit($id) 
    {
        if ($this->data['is_can_edit']) 
        {
            $this->form_validation->set_rules('id', "Id Harus Diisi", 'trim|required');
            $this->form_validation->set_rules('waktu', "Waktu Harus Diisi", 'trim|required');
    
            if ($this->form_validation->run() === TRUE) 
            {
                $this->db->trans_begin();
                $id     = $this->input->post("id");
                $waktu  = date("Y-m-d H:i:s", strtotime($this->input->post("waktu")));
                $location_id = $this->user_mutation_model->getLastLocation($this->data['users']->id);
                
                //insert situasi air
                $data = [
                    "waktu" => $waktu,
                    "location_id" => $location_id,
                    "updated_at" => date("Y-m-d H:i:s"),
                    "updated_by" => $this->data["users"]->id,
                ];
                $update  = $this->situasi_air_model->update($data, ["id" => $id]);
                
                //insert situasi air volume
                $seam_id = $this->input->post("seam_id");
                if(!empty($seam_id)){
                    $blok_start             = $this->input->post("blok_start");
                    $blok_end               = $this->input->post("blok_end");
                    $ketinggian_air         = $this->input->post("ketinggian_air");
                    $estimasi_total_air     = $this->input->post("estimasi_total_air");
                    $estimasi_total_lumpur  = $this->input->post("estimasi_total_lumpur");
                    
                    $delete_volume = $this->situasi_air_volume_model->delete(["situasi_air_id" => $id]);
                    $batch_volume = [];
                    foreach ($seam_id as $key => $value) {
                        $batch_volume[] = [
                            "situasi_air_id"        => $id,
                            "seam_id"               => $value,
                            "blok_start"            => $blok_start[$key],
                            "blok_end"              => $blok_end[$key],
                            "ketinggian_air"        => $ketinggian_air[$key],
                            "estimasi_total_air"    => $estimasi_total_air[$key],
                            "estimasi_total_lumpur" => $estimasi_total_lumpur[$key],
                        ];
                    }
                    $insert_volume = $this->situasi_air_volume_model->insert_batch($batch_volume);
                }
                
                //insert situasi pompa
                $unit_id = $this->input->post("unit_id");
                if(!empty($unit_id)){
                    $status_unit    = $this->input->post("status_unit");
                    
                    $delete_pompa = $this->situasi_air_pompa_model->delete(["situasi_air_id" => $id]);
                    $batch_pompa = [];
                    foreach ($unit_id as $key => $value) {
                        $batch_pompa[] = [
                            "situasi_air_id"        => $id,
                            "unit_id"               => $value,
                            "status_unit"           => $status_unit[$key]
                        ];
                    }
                    $insert_pompa = $this->situasi_air_pompa_model->insert_batch($batch_pompa);
                }
    
                if ($this->db->trans_status() === FALSE){
                    $this->db->trans_rollback();
                    
                    $this->session->set_flashdata('message_error', "Situasi Air Baru Gagal Diubah");
                    redirect("situasi_air");
                }else{
                    $this->db->trans_commit();

                    $this->session->set_flashdata('message', "Situasi Air Baru Berhasil Diubah");
                    redirect("situasi_air");
                }
            } else {
                $this->data['id'] = $id;
                $situasi_air = $this->situasi_air_model->getOneBy(["situasi_air.id" => $id]);
                if(!empty($situasi_air)){
                    $this->data['situasi_air']  = $situasi_air;
                    $this->data['volume']       = $this->situasi_air_volume_model->getAllById(["situasi_air_id" => $id]);
                    $this->data['pompa']        = $this->situasi_air_pompa_model->getAllById(["situasi_air_id" => $id]);

                    $location_id = $this->user_mutation_model->getLastLocation($this->data['users']->id);
                    $where_seam = ["seam.is_deleted" => 0];
                    $where_unit = ["unit.is_deleted" => 0];
                    if(!empty($location_id)){
                        $where_seam["seam.location_id"] = $location_id; 
                    }

                    $this->data['seam'] = $this->seam_model->getAllById($where_seam);

                    if(!empty($location_id)){
                        $where_unit["unit_transfer.to_location"] = $location_id; 
                    }
                    $this->data['unit'] = $this->unit_model->getAllByLocation($where_unit);

                    $this->data['content']      = 'admin/situasi_air/edit_v';
                    $this->load->view('admin/layouts/page', $this->data);
                }else{
                    $this->session->set_flashdata('message_error', "Situasi Air Tidak Ditemukan");
                    redirect("situasi_air");
                }
            }
        }else{
            $this->data['content'] = 'errors/html/restrict';
            $this->load->view('admin/layouts/page', $this->data);
        }
	}

	public function dataList() 
    {
		$columns = array(
			0 => 'waktu',
			1 => 'location.name',
			2 => '',
		);

		$order  = $columns[$this->input->post('order')[0]['column']];
		$dir    = $this->input->post('order')[0]['dir'];
		$where  = [];
		$search = [];
		$limit  = 0;
		$start  = 0;
		$totalData = $this->situasi_air_model->getCountAllBy($limit, $start, $search, $order, $dir, $where);

		if (!empty($this->input->post('search')['value'])) {
			$search_value = $this->input->post('search')['value'];
			$search = array(
				"location.name" => $search_value,
				"waktu" => $search_value,
			);
			$totalFiltered = $this->situasi_air_model->getCountAllBy($limit, $start, $search, $order, $dir, $where);
		} else {
			$totalFiltered = $totalData;
		}

		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$datas = $this->situasi_air_model->getAllBy($limit, $start, $search, $order, $dir, $where);

		$new_data = array();
		if (!empty($datas)) 
        {
			foreach ($datas as $key => $data) {

				$edit_url = "";
				$active_url = "";

				if ($this->data['is_can_edit'] && $data->is_deleted == 0) {
					$edit_url = "<a href='" . base_url() . "situasi_air/edit/" . $data->id . "' class='btn btn-sm btn-info white'> Ubah</a>";
				}

                if($this->data['is_can_delete']){
                    if($data->is_deleted == 0){
                        $active_url = "<a href='#'
						url='" . base_url() . "situasi_air/destroy/" . $data->id . "/" . $data->is_deleted . "'
						class='btn btn-sm btn-danger white delete'> Non Aktifkan
						</a>";
                    }elseif ($data->is_deleted == 1) {
                        $active_url = "<a href='#'
						url='" . base_url() . "situasi_air/destroy/" . $data->id . "/" . $data->is_deleted . "'
						class='btn btn-sm btn-danger white delete'> Aktifkan
						</a>";
                    }
                }

				$nestedData['id'] = $start + $key + 1;
				$nestedData['waktu'] = date("d-m-Y H:i", strtotime($data->waktu));
				$nestedData['location_name'] = $data->location_name;
				$nestedData['action'] = $edit_url . " " . $active_url;
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

	public function destroy() 
    {
		$response_data = array();
		$response_data['status'] = false;
		$response_data['msg'] = "";
		$response_data['data'] = array();

		$id = $this->uri->segment(3);
		$is_deleted = $this->uri->segment(4);
		if (!empty($id)) {
			$data = array(
				'is_deleted' => ($is_deleted == 1) ? 0 : 1,
			);
			$update = $this->situasi_air_model->update($data, array("id" => $id));

			$response_data['data'] = $data;
			$response_data['status'] = true;
		} else {
			$response_data['msg'] = "ID Harus Diisi";
		}

		echo json_encode($response_data);
	}

    public function getBlok()
    {
        $seam = $this->input->post("seam");
        $where = [
            "blok.seam_id" => $seam,
            "blok.is_deleted" => 0
        ];
        $blok = $this->blok_model->getAllById($where);
        if(!empty($blok)){
            $response_data['status'] = true;
            $response_data['data'] = $blok;
            $response_data['message'] = 'Berhasil Mengambil Data';
        }else{
            $response_data['status'] = false;
            $response_data['data'] = [];
            $response_data['message'] = 'Gagal Mengambil Data';
        }

        echo json_encode($response_data);
    }
}
