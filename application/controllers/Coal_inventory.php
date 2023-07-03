<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'core/Admin_Controller.php';
class Coal_inventory extends Admin_Controller 
{
	public function __construct() 
    {
		parent::__construct();
		$this->load->model('coal_inventory_model');
		$this->load->model('location_model');
		$this->load->model('pit_model');
	}

	public function index() 
    {
		$this->load->helper('url');
		if ($this->data['is_can_read']) {
			$this->data['content'] = 'admin/coal_inventory/list_v';
		} else {
			$this->data['content'] = 'errors/html/restrict';
		}

		$this->load->view('admin/layouts/page', $this->data);
	}

	public function create() 
    {
		$this->form_validation->set_rules('tanggal', "Tanggal Harus Dipilih", 'trim|required');
		$this->form_validation->set_rules('location_id', "Lokasi Harus Dipilih", 'trim|required');
		$this->form_validation->set_rules('pit_id', "PIT Harus Dipilih", 'trim|required');
		$this->form_validation->set_rules('tonase', "Tonase Harus Diisi", 'trim|required');

		if ($this->form_validation->run() === TRUE) {

            $this->db->trans_begin();
            
            $tanggal     = date("Y-m-d", strtotime($this->input->post("tanggal")));
			$location_id = $this->input->post("location_id");
			$pit_id      = $this->input->post("pit_id");
			$tonase      = $this->input->post("tonase");
			$data = [
				"tanggal"       => $tanggal,
				"location_id"   => $location_id,
				"pit_id"        => $pit_id,
				"tonase"        => $tonase,
                "created_by"    => $this->data["users"]->id,
                "updated_by"    => $this->data["users"]->id,
                "is_deleted"    => 0
            ];

            $insert = $this->coal_inventory_model->insert($data);
            if ($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                
                $this->session->set_flashdata('message_error', "Coal Inventory Baru Gagal Disimpan");
				redirect("coal_inventory");
            }else{
                $this->db->trans_commit();
                
                $this->session->set_flashdata('message', "Coal Inventory Baru Berhasil Disimpan");
				redirect("coal_inventory");
            }
		} else {
			$where_location = [
				"location.id !=" => 1,
				"location.is_deleted" => 0,
			];
			$this->data['locations'] = $this->location_model->getAllById($where_location);
			$this->data['content'] = 'admin/coal_inventory/create_v';
			$this->load->view('admin/layouts/page', $this->data);
		}
	}

	public function edit($id) 
    {
		$this->form_validation->set_rules('id', "Id Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('tanggal', "Tanggal Harus Dipilih", 'trim|required');
		$this->form_validation->set_rules('location_id', "Lokasi Harus Dipilih", 'trim|required');
		$this->form_validation->set_rules('pit_id', "PIT Harus Dipilih", 'trim|required');
		$this->form_validation->set_rules('tonase', "Tonase Harus Diisi", 'trim|required');

		if ($this->form_validation->run() === TRUE) {
			$this->db->trans_begin();
            
			$id          = $this->input->post("id");
            $tanggal     = date("Y-m-d", strtotime($this->input->post("tanggal")));
			$location_id = $this->input->post("location_id");
			$pit_id      = $this->input->post("pit_id");
			$tonase      = $this->input->post("tonase");

            $data = [
				"tanggal"       => $tanggal,
				"location_id"   => $location_id,
				"pit_id"        => $pit_id,
				"tonase"        => $tonase,
                "created_by"    => $this->data["users"]->id,
                "updated_by"    => $this->data["users"]->id,
                "is_deleted"    => 0
            ];

            $update = $this->coal_inventory_model->update($data, ["id" => $id]);
            if ($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                
                $this->session->set_flashdata('message_error', "Coal Inventory Baru Gagal Diubah");
				redirect("coal_inventory");
            }else{
                $this->db->trans_commit();
                
                $this->session->set_flashdata('message', "Coal Inventory Baru Berhasil Diubah");
				redirect("coal_inventory");
            }
		} else {
			if (!empty($_POST)) {
				$id = $this->input->post('id');
				$this->session->set_flashdata('message_error', validation_errors());
				return redirect("coal_inventory/edit/" . $id);
			} else {
				$this->data['id'] = $id;
                $coal_inventory = $this->coal_inventory_model->getOneBy(["coal_inventory.id" => $id]);
                $this->data["coal_inventory"] = $coal_inventory;

				$where_location = [
					"location.id !=" => 1,
					"location.is_deleted" => 0,
				];
				$this->data['locations'] = $this->location_model->getAllById($where_location);
				$this->data['content'] = 'admin/coal_inventory/edit_v';
				$this->load->view('admin/layouts/page', $this->data);
			}
		}

	}

	public function dataList() 
    {
		$columns = array(
			0 => 'location.name',
			1 => 'pit.name',
			2 => 'coal_inventory.tanggal',
			3 => 'coal_inventory.tonase',
			4 => '',
		);

		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];
		$search = array();
		$limit = 0;
		$start = 0;
		$totalData = $this->coal_inventory_model->getCountAllBy($limit, $start, $search, $order, $dir);

		if (!empty($this->input->post('search')['value'])) {
			$search_value = $this->input->post('search')['value'];
			$search = array(
				"location.name" => $search_value,
				"pit.name" => $search_value,
				"coal_inventory.tanggal" => $search_value,
				"coal_inventory.tonase" => $search_value,
			);

			$totalFiltered = $this->coal_inventory_model->getCountAllBy($limit, $start, $search, $order, $dir);
		} else {
			$totalFiltered = $totalData;
		}

		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$datas = $this->coal_inventory_model->getAllBy($limit, $start, $search, $order, $dir);

		$new_data = array();
		if (!empty($datas)) {

			foreach ($datas as $key => $data) {
				$edit_url = "";
				$delete_url = "";

				if ($this->data['is_can_edit'] && $data->is_deleted == 0) {
					$edit_url = "<a href='" . base_url() . "coal_inventory/edit/" . $data->id . "' class='btn btn-sm btn-info white'>Ubah</a>";
				}

                if ($this->data['is_can_delete']) {
					if ($data->is_deleted == 0) {
						$delete_url = "<a href='#'
	        				url='" . base_url() . "coal_inventory/destroy/" . $data->id . "/" . $data->is_deleted . "'
	        				class='btn btn-sm btn-danger white delete'>Non Aktifkan
	        				</a>";
					} else {
						$delete_url = "<a href='#'
	        				url='" . base_url() . "coal_inventory/destroy/" . $data->id . "/" . $data->is_deleted . "'
	        				class='btn btn-sm btn-danger white delete'>Aktifkan
	        				</a>";
					}
				}

				$nestedData['id'] = $start + $key + 1;
				$nestedData['location_name'] = $data->location_name;
				$nestedData['pit_name'] = $data->pit_name;
				$nestedData['tanggal'] = date("d-m-Y", strtotime($data->tanggal));
				$nestedData['tonase'] = number_format($data->tonase);
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
            $where = ['coal_inventory.id' => $id];
            if($status == 0){
                $data = ['is_deleted' => 1];
                $update = $this->coal_inventory_model->update($data,$where);
                $response_data['data'] = $data;
                $response_data['msg'] = "Sukses Menonaktifkan Data";
                $response_data['status'] = true;
            }elseif ($status == 1) {
                $data = ['is_deleted' => 0];
                $update = $this->coal_inventory_model->update($data,$where);
                $response_data['data'] = $data;
                $response_data['msg'] = "Sukses Mengaktifkan Data";
                $response_data['status'] = true;
            }elseif ($status == 2) {
                $destory = $this->coal_inventory_model->destory($where);
                $response_data['data'] = $data;
                $response_data['msg'] = "Sukses Menghapus Data";
                $response_data['status'] = true;
            }
        }else{
            $response_data['msg'] = "ID Kosong";
        }

        echo json_encode($response_data); 
    }

    public function getPit()
	{
		$id = $this->input->post("id");
		$pit = $this->pit_model->getAllById(['pit.location_id' => $id]);

		if(!empty($pit)){
            $response_data['status'] = true;
            $response_data['data'] = $pit;
            $response_data['message'] = 'Berhasil Mengambil Data';
        }else{
            $response_data['status'] = false;
            $response_data['data'] = [];
            $response_data['message'] = 'Gagal Mengambil Data';
        }

        echo json_encode($response_data);
	}
}
