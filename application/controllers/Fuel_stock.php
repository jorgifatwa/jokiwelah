<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'core/Admin_Controller.php';
class Fuel_stock extends Admin_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('fuel_stock_model');
		$this->load->model('user_mutation_model');
		$this->load->model('fuel_consumtion_model');
		$this->load->model('location_model');
	}

	public function index() {

		$this->load->helper('url');
		if ($this->data['is_can_read']) {
			$this->data['content'] = 'admin/fuel_stock/list_v';
		} else {
			$this->data['content'] = 'errors/html/restrict';
		}

		$this->load->view('admin/layouts/page', $this->data);
	}

	public function create() 
    {
        $this->form_validation->set_rules('nilai', "Nilai Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('waktu', "tanggal Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('location_id', "Lokasi Harus Diisi", 'trim|required');

		if ($this->form_validation->run() === TRUE) {
            $this->db->trans_begin();

            $location_id = $this->input->post("location_id");
            $waktu = date("Y-m-d", strtotime($this->input->post("waktu")));
            $nilai = $this->input->post("nilai");

            $data = [
                "location_id" => $location_id,
                "waktu" => $waktu, 
                "nilai" => $nilai,
                "current_stock" => NULL,
                "created_by" => $this->data["users"]->id,
                "updated_by" => $this->data["users"]->id,
                "is_deleted" => 1
            ];

            $insert = $this->fuel_stock_model->insert($data);

            if ($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                
                $this->session->set_flashdata('message_error', "Fuel Stock Baru Gagal Disimpan");
                redirect("fuel_stock");
            }else{
                $this->db->trans_commit();

                $this->session->set_flashdata('message', "Fuel Stock Baru Berhasil Disimpan");
                redirect("fuel_stock");
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

                $this->data['content'] = 'admin/fuel_stock/create_v';
            } else {
                $this->data['content'] = 'errors/html/restrict';
            }

			$this->load->view('admin/layouts/page', $this->data);
		}
	}

	public function edit($id) {
		$this->form_validation->set_rules('nilai', "Nilai Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('waktu', "tanggal Harus Diisi", 'trim|required');
		$this->form_validation->set_rules('location_id', "Lokasi Harus Diisi", 'trim|required');

		if ($this->form_validation->run() === TRUE) {
			$this->db->trans_begin();

            $id = $this->input->post("id");
            $location_id = $this->input->post("location_id");
            $waktu = date("Y-m-d", strtotime($this->input->post("waktu")));
            $nilai = $this->input->post("nilai");

            $data = [
                "location_id" => $location_id,
                "waktu" => $waktu, 
                "nilai" => $nilai,
                "updated_by" => $this->data["users"]->id
            ];

            $update = $this->fuel_stock_model->update($data, ["id" => $id]);

            if ($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                
                $this->session->set_flashdata('message_error', "Fuel Stock Baru Gagal Diubah");
                redirect("fuel_stock");
            }else{
                $this->db->trans_commit();

                $this->session->set_flashdata('message', "Fuel Stock Baru Berhasil Diubah");
                redirect("fuel_stock");
            }
		} else {
            if ($this->data['is_can_edit']) {
                if (!empty($_POST)) {
                    $id = $this->input->post('id');
                    $this->session->set_flashdata('message_error', validation_errors());
                    return redirect("fuel_stock/edit/" . $id);
                } else {
                    $where = [
                        "fuel_stock.id" => $id,
                        "fuel_stock.is_deleted" => 1 
                    ];
                    $stock = $this->fuel_stock_model->getOneBy($where);
                    $this->data['stock'] = $stock;

                    $where_location = [
                        "location.id !=" => 1,
                        "location.is_deleted" => 0
                    ];
                    $this->data['locations'] = $this->location_model->getAllById($where_location);
                    
                    $this->data['content'] = 'admin/fuel_stock/edit_v';
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
			0 => 'location.name',
			1 => 'fuel_stock.waktu',
			2 => 'fuel_stock.nilai',
			3 => '',
		);

		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];
		$search = [];
		$where = [];
		$limit = 0;
		$start = 0;
		$totalData = $this->fuel_stock_model->getCountAllBy($limit, $start, $search, $order, $dir, $where);

		if (!empty($this->input->post('search')['value'])) {
			$search_value = $this->input->post('search')['value'];
			$search = array(
				"location.name" => $search_value,
				"fuel_stock.waktu" => $search_value,
				"fuel_stock.nilai" => $search_value,
			);
			$totalFiltered = $this->fuel_stock_model->getCountAllBy($limit, $start, $search, $order, $dir, $where);
		} else {
			$totalFiltered = $totalData;
		}

		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$datas = $this->fuel_stock_model->getAllBy($limit, $start, $search, $order, $dir, $where);

		$new_data = array();
		if (!empty($datas)) {

			foreach ($datas as $key => $data) {

				$edit_url = "";
				$delete_url = "";

				if ($this->data['is_can_edit'] && $data->is_deleted == 1) {
					$edit_url = "<a href='" . base_url() . "fuel_stock/edit/" . $data->id . "' class='btn btn-sm btn-info white'>Ubah</a>";
				}

                if ($this->data['is_can_delete']) {
					if ($data->is_deleted == 0) {
						// $delete_url = "<a href='#'
	        			// 	url='" . base_url() . "fuel_stock/destroy/" . $data->id . "/" . $data->is_deleted . "'
	        			// 	class='btn btn-sm btn-danger white delete'>Non Aktifkan
	        			// 	</a>";
					} else {
						$delete_url = "<a href='#'
	        				url='" . base_url() . "fuel_stock/destroy/" . $data->id . "/" . $data->is_deleted . "'
	        				class='btn btn-sm btn-danger white delete'>Aktifkan
	        				</a>";
					}
				}

				$nestedData['id'] = $start + $key + 1;
				$nestedData['location_name'] = $data->location_name;
				$nestedData['waktu'] = date("d-m-Y", strtotime($data->waktu));
				$nestedData['nilai'] = str_replace(",00", "",  number_format($data->nilai, 2, ',', '.'))." <i>Liter<i>";
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
            $where = ['fuel_stock.id' => $id];
            if($status == 0){
                $data = ['is_deleted' => 1];
                $update = $this->fuel_stock_model->update($data,$where);
                $response_data['data'] = $data;
                $response_data['msg'] = "Sukses Menonaktifkan Data";
                $response_data['status'] = true;
            }elseif ($status == 1) {
                $where_stock = [
                    "fuel_stock.id" => $id,
                    "fuel_stock.is_deleted" => 1 
                ];
                $stock = $this->fuel_stock_model->getOneBy($where_stock);

                $where_current =[
                    "fuel_stock.location_id" => $stock->location_id ,
                    "fuel_stock.is_deleted" => 0
                ];
                $current_stock = $this->fuel_stock_model->getStockLatest($where_current);
                if(empty($current_stock) || empty($current_stock->current_stock)){
                    $where_current_consumtion =[
                        "fuel_consumtion.location_id" => $stock->location_id ,
                        "fuel_consumtion.is_deleted" => 0
                    ];
                    $current_stock = $this->fuel_consumtion_model->getStockLatest($where_current_consumtion);
                    if(empty($current_stock)){
                        $current_stock = 0;
                    }else{
                        $current_stock = $current_stock->current_stock;
                    }
                }else{
                    $current_stock = $current_stock->current_stock;
                }
                $current_stock = $current_stock + $stock->nilai;
                //update stock di fuel stock
                $data = [
                    "is_deleted" => 0,
                    "current_stock" => $current_stock
                ];
                $update = $this->fuel_stock_model->update($data,$where);

                //update stock di fuel consumtion
                $where_current_consumtion =[
                    "fuel_consumtion.location_id" => $stock->location_id ,
                    "fuel_consumtion.is_deleted" => 0
                ];
                $consumtion = $this->fuel_consumtion_model->getStockLatest($where_current_consumtion);
                if(!empty($consumtion)){
                    $data_consumtion = [
                        "current_stock" => $current_stock
                    ];
                    $update = $this->fuel_consumtion_model->update($data_consumtion, ["id" => $consumtion->id]);
                }

                $response_data['data'] = $data;
                $response_data['msg'] = "Sukses Mengaktifkan Data";
                $response_data['status'] = true;
            }elseif ($status == 2) {
                $destory = $this->fuel_stock_model->destory($where);
                $response_data['data'] = $data;
                $response_data['msg'] = "Sukses Menghapus Data";
                $response_data['status'] = true;
            }
        }else{
            $response_data['msg'] = "ID Kosong";
        }

        echo json_encode($response_data); 
    }
}
