<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'core/Admin_Controller.php';
class Plan_activity extends Admin_Controller 
{
	public function __construct() 
	{
		parent::__construct();
		$this->load->model('blok_model');
		$this->load->model('general_activity_model');
		$this->load->model('fleet_coal_getting_model');
		$this->load->model('fleet_ob_model');
		$this->load->model('location_model');
		$this->load->model('mine_pump_model');
		$this->load->model('seam_model');
		$this->load->model('user_mutation_model');
		$this->load->model('unit_model');
		$this->load->model('pit_model');
		$this->load->model('plan_activity_model');
		$this->load->model('plan_unit_support_model');
	}

	public function index() 
	{
		$this->load->helper('url');
		if ($this->data['is_can_read']) {
			$this->data['content'] = 'admin/plan_activity/list_v';
		} else {
			$this->data['content'] = 'errors/html/restrict';
		}

		$this->load->view('admin/layouts/page', $this->data);
	}

	public function create() 
	{
        if ($this->data['is_can_create']) {
            $this->form_validation->set_rules('tanggal', "Tanggal Harus Diisi", 'trim|required');
            $this->form_validation->set_rules('location_id', "Site Harus Diisi", 'trim|required');
            $this->form_validation->set_rules('shift', "Shift Harus Diisi", 'trim|required');
    
            if ($this->form_validation->run() === TRUE) 
            {
                $this->db->trans_begin();
    
                $tanggal        = $this->input->post("tanggal");
                $location_id    = $this->input->post("location_id");
                $shift          = $this->input->post("shift");
    
                $data = [
                    "tanggal"       => date("Y-m-d", strtotime($tanggal)),
                    "location_id"   => $location_id,
                    "shift"         => $shift,
                    "created_by"    => $this->data["users"]->id,
                    "updated_by"    => $this->data["users"]->id,
                    "is_deleted"    => 0
                ];
                $insert_plan = $this->plan_activity_model->insert($data);

                //insert fleet ob
                $pit_id  = $this->input->post("pit_id");
                $seam_id = $this->input->post("seam_id");
                $blok_id = $this->input->post("blok_id");
                $loading_unit_id = $this->input->post("loading_unit_id");
                $hauling_unit_id = $this->input->post("hauling_unit_id");
                $data_fleet_ob = [];
                if(!empty($hauling_unit_id)){
                    foreach ($hauling_unit_id as $key => $value) {
                        foreach ($value as $k => $v) {
                            $data_fleet_ob[] = [
                                "plan_activity_id" => $insert_plan,
                                "pit_id"  => $pit_id[$key],
                                "seam_id" => $seam_id[$key],
                                "blok_id" => $blok_id[$key],
                                "loading_id" => $loading_unit_id[$key],
                                "hauling_id" => $v,
                            ];
                        }
                    }
                }
                if(!empty($data_fleet_ob)){
                    $insert_batch_fleet_ob = $this->fleet_ob_model->insert_batch($data_fleet_ob);
                }
                
                if ($this->db->trans_status() === FALSE){
                    $this->db->trans_rollback();
                    
                    $this->session->set_flashdata('message_error', "Plan Activity Baru Gagal Disimpan");
                    redirect("plan_activity");
                }else{
                    $this->db->trans_commit();
    
                    $this->session->set_flashdata('message', "Plan Activity Baru Berhasil Disimpan");
                    redirect("plan_activity");
                }
            } else {
                $where_location = [
                    "location.id !=" => 1,
                    "location.is_deleted" => 0
                ];
                $location_id = $this->user_mutation_model->getLastLocation($this->data['users']->id);
                if(!empty($location_id)){
                    $where_location["location.id"] = $location_id;
                }
                $this->data['locations'] = $this->location_model->getAllById($where_location);
    
                $this->data['content'] = 'admin/plan_activity/create_v';
                $this->load->view('admin/layouts/page', $this->data);
            }
        }else{
            $this->data['content'] = 'errors/html/restrict';
            $this->load->view('admin/layouts/page', $this->data);
        }
	}

	public function edit($id) 
	{
        if ($this->data['is_can_edit']) {
            $this->form_validation->set_rules('tanggal', "Tanggal Harus Diisi", 'trim|required');
            $this->form_validation->set_rules('location_id', "Site Harus Diisi", 'trim|required');
            $this->form_validation->set_rules('shift', "Shift Harus Diisi", 'trim|required');
    
            if ($this->form_validation->run() === TRUE) {
                $this->db->trans_begin();
    
                $id             = $this->input->post("id");
                $tanggal        = $this->input->post("tanggal");
                $location_id    = $this->input->post("location_id");
                $shift          = $this->input->post("shift");
    
                $data = [
                    "tanggal"       => date("Y-m-d", strtotime($tanggal)),
                    "location_id"   => $location_id,
                    "shift"         => $shift,
                    "created_by"    => $this->data["users"]->id,
                    "updated_by"    => $this->data["users"]->id,
                    "is_deleted"    => 0
                ];
    
                $update_plan = $this->plan_activity_model->update($data, ["id" => $id]);
    
                if ($this->db->trans_status() === FALSE){
                    $this->db->trans_rollback();
                    
                    $this->session->set_flashdata('message_error', "Plan Activity Baru Gagal Diubah");
                    redirect("plan_activity");
                }else{
                    $this->db->trans_commit();
    
                    $this->session->set_flashdata('message', "Plan Activity Baru Berhasil Diubah");
                    redirect("plan_activity");
                }
            } else {
                if (!empty($_POST)) {
                    $id = $this->input->post('id');
                    $this->session->set_flashdata('message_error', validation_errors());
                    return redirect("location/edit/" . $id);
                } else {
                    $this->data["id"] = $id;
                    $where_plan = ["plan_activity.id" => $id];
                    $plan = $this->plan_activity_model->getOneBy($where_plan);
                    if(!empty($plan)){
                        $this->data["plan"] = $plan;

                        $where_location = [
                            "location.id !=" => 1,
                            "location.is_deleted" => 0
                        ];
                        $location_id = $this->user_mutation_model->getLastLocation($this->data['users']->id);
                        if(!empty($location_id)){
                            $where_location["location.id"] = $location_id;
                        }
                        $this->data['locations'] = $this->location_model->getAllById($where_location);

                        $this->data['content'] = 'admin/plan_activity/edit_v';
                    }else{
                        $this->data['content'] = 'errors/html/restrict';
                    }

                    $this->load->view('admin/layouts/page', $this->data);
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
			0 => 'plan_activity.tanggal',
			1 => 'location.name',
			2 => 'plan_activity.shift',
			3 => '',
		);

		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];
		$search = array();
		$limit = 0;
		$start = 0;
		$totalData = $this->plan_activity_model->getCountAllBy($limit, $start, $search, $order, $dir);

		if (!empty($this->input->post('search')['value'])) {
			$search_value = $this->input->post('search')['value'];
			$search = array(
				"location.name" => $search_value,
				"plan_activity.tanggal" => $search_value,
			);
			$totalFiltered = $this->plan_activity_model->getCountAllBy($limit, $start, $search, $order, $dir);
		} else {
			$totalFiltered = $totalData;
		}

		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$datas = $this->plan_activity_model->getAllBy($limit, $start, $search, $order, $dir);

		$new_data = array();
		if (!empty($datas)) {

			foreach ($datas as $key => $data) {
				$edit_url = "";
				$delete_url = "";

				if ($this->data['is_can_edit'] && $data->is_deleted == 0) {
					$edit_url = "<a href='" . base_url() . "plan_activity/edit/" . $data->id . "' class='btn btn-sm btn-info white'> Ubah</a>";
				}

                if ($this->data['is_can_delete']) {
					if ($data->is_deleted == 0) {
						$delete_url = "<a href='#'
	        				url='" . base_url() . "plan_activity/destroy/" . $data->id . "/" . $data->is_deleted . "'
	        				class='btn btn-sm btn-danger white delete'>Non Aktifkan
	        				</a>";
					} else {
						$delete_url = "<a href='#'
	        				url='" . base_url() . "plan_activity/destroy/" . $data->id . "/" . $data->is_deleted . "'
	        				class='btn btn-sm btn-danger white delete'>Aktifkan
	        				</a>";
					}
				}

				$nestedData['id'] = $start + $key + 1;
				$nestedData['tanggal'] = date("d-m-Y", strtotime($data->tanggal));
				$nestedData['location_name'] = $data->location_name;
				$nestedData['shift'] = $data->shift;
				$nestedData['action'] = $edit_url . " " . $delete_url;
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

	public function destroy($id, $status)
    {
        $response_data = array();
        $response_data['status'] = false;
        $response_data['msg'] = "";
        $response_data['data'] = array();

        if(!empty($id)){
            $where = ['plan_activity.id' => $id];
            if($status == 0){
                $data = ['is_deleted' => 1];
                $update = $this->plan_activity_model->update($data,$where);
                $response_data['data'] = $data;
                $response_data['msg'] = "Sukses Menonaktifkan Data";
                $response_data['status'] = true;
            }elseif ($status == 1) {
                $data = ['is_deleted' => 0];
                $update = $this->plan_activity_model->update($data,$where);
                $response_data['data'] = $data;
                $response_data['msg'] = "Sukses Mengaktifkan Data";
                $response_data['status'] = true;
            }elseif ($status == 2) {
                $destory = $this->plan_activity_model->destory($where);
                $response_data['data'] = $data;
                $response_data['msg'] = "Sukses Menghapus Data";
                $response_data['status'] = true;
            }
        }else{
            $response_data['msg'] = "ID Kosong";
        }

        echo json_encode($response_data); 
    }

    public function getDataByLokasi()
    {
        $id = $this->input->post("id");
        
        $pit = $this->pit_model->getAllById(['pit.location_id' => $id]);
        if(empty($pit)){
            $pit = [];
        }
        
        $where_unit = [
            'unit_transfer.to_location' => $id,
			'unit.operasi_sebagai' => 0,
		];
		$loading_unit = $this->unit_model->getAllByLocation($where_unit);
        if(empty($loading_unit)){
            $loading_unit = [];
        }

        $where_hauling_unit = [
            'unit_transfer.to_location' => $id,
			'unit.operasi_sebagai' => 1,
		];
		$hauling_unit = $this->unit_model->getAllByLocation($where_hauling_unit);
        if(empty($hauling_unit)){
            $hauling_unit = [];
        }


        $response_data['status'] = true;
        $response_data['pit'] = $pit;
        $response_data['loading_unit'] = $loading_unit;
        $response_data['hauling_unit'] = $hauling_unit;
        $response_data['message'] = 'Berhasil Mengambil Data';

        echo json_encode($response_data);
    }

    public function getSeam()
	{
		$id = $this->input->post("id");
		$seam = $this->seam_model->getAllById(['seam.pit_id' => $id]);

		if(!empty($seam)){
            $response_data['status'] = true;
            $response_data['data'] = $seam;
            $response_data['message'] = 'Berhasil Mengambil Data';
        }else{
            $response_data['status'] = false;
            $response_data['data'] = [];
            $response_data['message'] = 'Gagal Mengambil Data';
        }

        echo json_encode($response_data);
	}

    public function getBlok()
	{
		$id = $this->input->post("id");
		$blok = $this->blok_model->getAllById(['blok.seam_id' => $id]);

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
