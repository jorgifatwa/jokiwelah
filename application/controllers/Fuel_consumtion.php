<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'core/Admin_Controller.php';
class Fuel_consumtion extends Admin_Controller 
{
	public function __construct() 
    {
		parent::__construct();
		$this->load->model('fuel_stock_model');
		$this->load->model('fuel_consumtion_model');
		$this->load->model('location_model');
		$this->load->model('disposal_model');
		$this->load->model('user_model');
		$this->load->model('user_mutation_model');
		$this->load->model('unit_model');
		$this->load->model('pit_model');
	}

	public function index() 
    {
		$this->load->helper('url');
		if ($this->data['is_can_read']) {
			$this->data['content'] = 'admin/fuel_consumtion/list_v';
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
        $this->form_validation->set_rules('hour_meter', "Hour Meter Harus Diisi", 'trim|required');
        $this->form_validation->set_rules('pic_id', "PIC Harus Dipilih", 'trim|required');
        $this->form_validation->set_rules('unit_id', "Unit Harus Dipilih", 'trim|required');
        $this->form_validation->set_rules('shift', "Shift Harus Dipilih", 'trim|required');
        $this->form_validation->set_rules('lokasi_pengisian_id', "Lokasi Pengisian Harus Dipilih", 'trim|required');
        $this->form_validation->set_rules('qty_in', "QTY In Harus Diisi", 'trim|required');
        $this->form_validation->set_rules('qty_out', "QTY Out Harus Diisi", 'trim|required');

		if ($this->form_validation->run() === TRUE) {
            $this->db->trans_begin();

            $tanggal        = date("Y-m-d", strtotime($this->input->post("tanggal")));
            $location_id    = $this->input->post("location_id");
            $pit_id         = $this->input->post("pit_id");
            $hour_meter     = $this->input->post("hour_meter");
            $pic_id         = $this->input->post("pic_id");
            $unit_id        = $this->input->post("unit_id");
            $shift          = $this->input->post("shift");
            $lokasi_pengisian_id = $this->input->post("lokasi_pengisian_id");
            $km_pengisian   = $this->input->post("km_pengisian");
            $hm_pengisian   = $this->input->post("hm_pengisian");
            $qty_in         = $this->input->post("qty_in");
            $qty_out        = $this->input->post("qty_out");

            if(empty($km_pengisian)){
                $km_pengisian = NULL;
            }

            if(empty($hm_pengisian)){
                $km_pengisian = NULL;
            }
            
            $data = [
                "tanggal"       => $tanggal,
                "location_id"   => $location_id,
                "pit_id"        => $pit_id,
                "hm"            => $hour_meter,
                "pic_id"        => $pic_id,
                "unit_id"       => $unit_id,
                "shift"         => $shift,
                "lokasi_pengisian" => $lokasi_pengisian_id,
                "km_pengisian"  => $km_pengisian,
                "hm_pengisian"  => $hm_pengisian,
                "qty_in"        => $qty_in,
                "qty_out"       => $qty_out,
                "created_by"    => $this->data["users"]->id,
                "updated_by"    => $this->data["users"]->id,
                "is_deleted"    => 1
            ];

            $insert = $this->fuel_consumtion_model->insert($data);

            if ($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                
                $this->session->set_flashdata('message_error', "Fuel Consumtion Baru Gagal Disimpan");
                redirect("fuel_consumtion");
            }else{
                $this->db->trans_commit();

                $this->session->set_flashdata('message', "Fuel Consumtion Baru Berhasil Disimpan");
                redirect("fuel_consumtion");
            }
		} else {
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

                $this->data['content'] = 'admin/fuel_consumtion/create_v';
            } else {
                $this->data['content'] = 'errors/html/restrict';
            }

			$this->load->view('admin/layouts/page', $this->data);
		}
	}

	public function edit($id) 
    {
		$this->form_validation->set_rules('tanggal', "Tanggal Harus Dipilih", 'trim|required');
		$this->form_validation->set_rules('location_id', "Lokasi Harus Dipilih", 'trim|required');
        $this->form_validation->set_rules('pit_id', "PIT Harus Dipilih", 'trim|required');
        $this->form_validation->set_rules('hour_meter', "Hour Meter Harus Diisi", 'trim|required');
        $this->form_validation->set_rules('pic_id', "PIC Harus Dipilih", 'trim|required');
        $this->form_validation->set_rules('unit_id', "Unit Harus Dipilih", 'trim|required');
        $this->form_validation->set_rules('shift', "Shift Harus Dipilih", 'trim|required');
        $this->form_validation->set_rules('lokasi_pengisian_id', "Lokasi Pengisian Harus Dipilih", 'trim|required');
        $this->form_validation->set_rules('qty_in', "QTY In Harus Diisi", 'trim|required');
        $this->form_validation->set_rules('qty_out', "QTY Out Harus Diisi", 'trim|required');

		if ($this->form_validation->run() === TRUE) {
			$this->db->trans_begin();

            $id = $this->input->post("id");
            $tanggal        = date("Y-m-d", strtotime($this->input->post("tanggal")));
            $location_id    = $this->input->post("location_id");
            $pit_id         = $this->input->post("pit_id");
            $hour_meter     = $this->input->post("hour_meter");
            $pic_id         = $this->input->post("pic_id");
            $unit_id        = $this->input->post("unit_id");
            $shift          = $this->input->post("shift");
            $lokasi_pengisian_id = $this->input->post("lokasi_pengisian_id");
            $km_pengisian   = $this->input->post("km_pengisian");
            $hm_pengisian   = $this->input->post("hm_pengisian");
            $qty_in         = $this->input->post("qty_in");
            $qty_out        = $this->input->post("qty_out");

            if(empty($km_pengisian)){
                $km_pengisian = NULL;
            }

            if(empty($hm_pengisian)){
                $km_pengisian = NULL;
            }

            $data = [
                "tanggal"       => $tanggal,
                "location_id"   => $location_id,
                "pit_id"        => $pit_id,
                "hm"            => $hour_meter,
                "pic_id"        => $pic_id,
                "unit_id"       => $unit_id,
                "shift"         => $shift,
                "lokasi_pengisian" => $lokasi_pengisian_id,
                "km_pengisian"  => $km_pengisian,
                "hm_pengisian"  => $hm_pengisian,
                "qty_in"        => $qty_in,
                "qty_out"       => $qty_out,
                "updated_by"    => $this->data["users"]->id
            ];

            $update = $this->fuel_consumtion_model->update($data, ["id" => $id]);

            if ($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                
                $this->session->set_flashdata('message_error', "Fuel Consumtion Baru Gagal Diubah");
                redirect("fuel_consumtion");
            }else{
                $this->db->trans_commit();

                $this->session->set_flashdata('message', "Fuel Consumtion Baru Berhasil Diubah");
                redirect("fuel_consumtion");
            }
		} else {
            if ($this->data['is_can_edit']) {
                if (!empty($_POST)) {
                    $id = $this->input->post('id');
                    $this->session->set_flashdata('message_error', validation_errors());
                    return redirect("fuel_consumtion/edit/" . $id);
                } else {
                    $where = [
                        "fuel_consumtion.id" => $id,
                        "fuel_consumtion.is_deleted" => 1,
                    ];
                    $fuel = $this->fuel_consumtion_model->getOneBy($where);
                    $this->data['fuel'] = $fuel;

                    $where_location = [
                        "location.id !=" => 1,
                        "location.is_deleted" => 0
                    ];
                    $location_id = $this->user_mutation_model->getLastLocation($this->data['users']->id);
                    if(!empty($location_id)){
                        $where_location["location.id"] = $location_id;
                    }
                    $this->data['locations'] = $this->location_model->getAllById($where_location);
                    
                    $this->data['content'] = 'admin/fuel_consumtion/edit_v';
                }
            } else {
                $this->data['content'] = 'errors/html/restrict';
            }

            $this->load->view('admin/layouts/page', $this->data);
		}
	}

	public function dataList() 
    {
		$columns = array(
			0 => 'fuel_consumtion.tanggal',
			1 => 'location.name',
			2 => 'pit.name',
			3 => 'fuel_consumtion.hm',
			4 => 'pic.first_name',
			5 => 'unit.kode',
			6 => 'fuel_consumtion.shift',
			7 => 'disposal.name',
			8 => '',
		);

		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];
		$search = [];
		$where = [];
		$limit = 0;
		$start = 0;
		$totalData = $this->fuel_consumtion_model->getCountAllBy($limit, $start, $search, $order, $dir, $where);

		if (!empty($this->input->post('search')['value'])) {
			$search_value = $this->input->post('search')['value'];
			$search = [
                "fuel_consumtion.tanggal" => $search_value,
                "pit.name" => $search_value,
                "fuel_consumtion.hm" => $search_value,
                "pic.first_name" => $search_value,
                "unit.kode" => $search_value,
                "unit_model.name" => $search_value,
                "unit_brand.name" => $search_value,
                "fuel_consumtion.shift" => $search_value,
                "disposal.name" => $search_value,
            ];
			$totalFiltered = $this->fuel_consumtion_model->getCountAllBy($limit, $start, $search, $order, $dir, $where);
		} else {
			$totalFiltered = $totalData;
		}

		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$datas = $this->fuel_consumtion_model->getAllBy($limit, $start, $search, $order, $dir, $where);

		$new_data = array();
		if (!empty($datas)) {

			foreach ($datas as $key => $data) {

				$edit_url = "";
				$delete_url = "";

				if ($this->data['is_can_edit'] && $data->is_deleted == 1) {
					$edit_url = "<a href='" . base_url() . "fuel_consumtion/edit/" . $data->id . "' class='btn btn-sm btn-info white'>Ubah</a>";
				}

                if ($this->data['is_can_delete']) {
					if ($data->is_deleted == 0) {
						// $delete_url = "<a href='#'
	        			// 	url='" . base_url() . "fuel_consumtion/destroy/" . $data->id . "/" . $data->is_deleted . "'
	        			// 	class='btn btn-sm btn-danger white delete'>Non Aktifkan
	        			// 	</a>";
					} else {
						$delete_url = "<a href='#'
	        				url='" . base_url() . "fuel_consumtion/destroy/" . $data->id . "/" . $data->is_deleted . "'
	        				class='btn btn-sm btn-danger white delete'>Aktifkan
	        				</a>";
					}
				}

				$nestedData['id'] = $start + $key + 1;
				$nestedData['tanggal'] = $data->tanggal;
				$nestedData['location_name'] = $data->location_name;
				$nestedData['pit_name'] = $data->pit_name;
				$nestedData['hm'] = number_format($data->hm, 0, ',', '.');
				$nestedData['pic_name'] = $data->pic_name;
				$nestedData['unit'] = $data->kode." - ".$data->brand_name." - ".$data->model_name;
				$nestedData['shift'] = $data->shift;
				$nestedData['lokasi_pengisian'] = $data->lokasi_pengisian_name;
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
            $where = ['fuel_consumtion.id' => $id];
            if($status == 0){
                $data = ['is_deleted' => 1];
                $update = $this->fuel_consumtion_model->update($data,$where);
                $response_data['data'] = $data;
                $response_data['msg'] = "Sukses Menonaktifkan Data";
                $response_data['status'] = true;
            }elseif ($status == 1) {
                $where_stock = [
                    "fuel_consumtion.id" => $id,
                    "fuel_consumtion.is_deleted" => 1 
                ];
                $consumtion = $this->fuel_consumtion_model->getOneBy($where_stock);

                $where_current =[
                    "fuel_consumtion.location_id" => $consumtion->location_id ,
                    "fuel_consumtion.is_deleted" => 0
                ];
                $current_stock = $this->fuel_consumtion_model->getStockLatest($where_current);
                if(empty($current_stock) || empty($current_stock->current_stock) ){
                    $where_current_stock =[
                        "fuel_stock.location_id" => $consumtion->location_id ,
                        "fuel_stock.is_deleted" => 0
                    ];
                    $current_stock = $this->fuel_stock_model->getStockLatest($where_current_stock);
                    if(empty($current_stock)){
                        $current_stock = 0;
                    }else{
                        $current_stock = $current_stock->current_stock;
                    }
                }else{
                    $current_stock = $current_stock->current_stock;
                    
                }
                $current_stock = $current_stock - $consumtion->qty_out;
                
                //update stock di fuel consumtion
                $data = [
                    "is_deleted" => 0,
                    "current_stock" => $current_stock
                ];
                $update = $this->fuel_consumtion_model->update($data,$where);


                //update stock di fuel stock
                $where_current_stock =[
                    "fuel_stock.location_id" => $consumtion->location_id ,
                    "fuel_stock.is_deleted" => 0
                ];
                $stock = $this->fuel_stock_model->getStockLatest($where_current_stock);
                if(!empty($stock)){
                    $data_stock = [
                        "current_stock" => $current_stock
                    ];
                    $update = $this->fuel_stock_model->update($data_stock, ["id" => $stock->id]);
                }

                $response_data['data'] = $data;
                $response_data['msg'] = "Sukses Mengaktifkan Data";
                $response_data['status'] = true;
            }elseif ($status == 2) {
                $destory = $this->fuel_consumtion_model->destory($where);
                $response_data['data'] = $data;
                $response_data['msg'] = "Sukses Menghapus Data";
                $response_data['status'] = true;
            }
        }else{
            $response_data['msg'] = "ID Kosong";
        }

        echo json_encode($response_data); 
    }

    public function getDataByLocation()
	{
		$id = $this->input->post("id");
		$pit = $this->pit_model->getAllById(['pit.location_id' => $id]);

        $where_pic = [
            "user_mutation.to_location" => $id
        ];
		$pic = $this->user_mutation_model->getUserByLocation($where_pic);

        //disposal
        $where_disposal = [
            "disposal.is_deleted" => 0,
            "disposal.production" => 3,
            "disposal.location_id" => $id
        ];
        $disposal = $this->disposal_model->getAllById($where_disposal);

        //unit 
        $where_unit = [
            "unit_transfer.to_location" => $id
        ];
        $unit = $this->unit_model->getAllByLocation($where_unit);

		if(!empty($pit)){
            $response_data['status'] = true;
            $response_data['pit'] = $pit;
            $response_data['pic'] = $pic;
            $response_data['unit'] = $unit;
            $response_data['disposal'] = $disposal;
            $response_data['message'] = 'Berhasil Mengambil Data';
        }else{
            $response_data['status'] = false;
            $response_data['data'] = [];
            $response_data['message'] = 'Gagal Mengambil Data';
        }

        echo json_encode($response_data);
	}
}
