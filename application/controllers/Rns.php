<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'core/Admin_Controller.php';
class Rns extends Admin_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('rns_model');
	}

	public function index() {

		$this->load->helper('url');
		if ($this->data['is_can_read']) {
			$this->data['content'] = 'admin/rns/list_v';
		} else {
			$this->data['content'] = 'errors/html/restrict';
		}

		$this->load->view('admin/layouts/page', $this->data);
	}

	public function detail() {

		$this->load->helper('url');
		if ($this->data['is_can_read']) {
			$this->data['content'] = 'admin/rns/detail_v';
		} else {
			$this->data['content'] = 'errors/html/restrict';
		}

		$this->load->view('admin/layouts/page', $this->data);
	}

	public function detailList() {
		$columns = array(
			0 => 'iterasi',
			1 => 'start',
			2 => 'stop',
			3 => '',
		);

		$type = $this->uri->segment(3);

		$tanggal = $this->uri->segment(4);
		
		$lokasi = $this->uri->segment(5);

		$where = array(
			'type' => $type,
			'lokasi' => $lokasi,
			'tanggal' => $tanggal,
		);

		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];
		$search = array();
		$limit = 0;
		$start = 0;
		$totalData = $this->rns_model->detailGetCountAllBy($limit, $start, $search, $order, $dir, $where);
		$totalFiltered = $totalData;

		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$datas = $this->rns_model->detailGetAllBy($limit, $start, $search, $order, $dir, $where);

		$new_data = array();
		if (!empty($datas)) {
			$tmp_data = [];
			foreach ($datas as $key => $data) {
				$nestedData['iterasi'] = $data->iterasi;
				$nestedData['start'] = $data->start;
				$nestedData['stop'] = $data->stop;
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

	public function dataList() {

		$columns = array(
			0 => 'tanggal',
			1 => 'lokasi',
			2 => '',
			3 => '',
			4 => '',
			5 => '',
			6 => '',
			7 => '',
		);

		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];
		$search = array();
		$where = array();
		$limit = 0;
		$start = 0;
		
		$totalData = $this->rns_model->getCountAllBy($limit,$start,$search,$order,$dir, $where); 
        $searchColumn = $this->input->post('columns');
		$filtered = false;

		if(!empty($searchColumn[1]['search']['value'])){
			$value = $searchColumn[1]['search']['value'];
			$where['rns.tanggal >= '] = date("Y-m-d", strtotime($value));

			$filtered = true;
		}

		if(!empty($searchColumn[2]['search']['value'])){
			$value = $searchColumn[2]['search']['value'];
			$where['rns.tanggal <= '] = date("Y-m-d", strtotime($value));

			$filtered = true;
		}

		if(!empty($searchColumn[3]['search']['value'])){
			$value = $searchColumn[3]['search']['value'];
			$where['rns.lokasi'] = $value;

			$filtered = true;
		}

        if(!empty($this->input->post('search')['value'])){
        	$search_value = $this->input->post('search')['value'];
			$search = array(
				"rns.rainfall_mm"=>$search_value,
			); 
			$filtered = true;
        }

		if($filtered){
			$totalFiltered = $this->rns_model->getCountAllBy($limit,$start,$search,$order,$dir, $where); 

		}else{
			$totalFiltered = $totalData;
		}

		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$datas = $this->rns_model->getAllBy($limit, $start, $search, $order, $dir, $where);

		$new_data = array();
		if (!empty($datas)) {
			$tmp_data = [];
			foreach ($datas as $key => $data) {
				$where = ["rns.tanggal" => $data->tanggal, "rns.lokasi" => $data->lokasi];
				$getAllData = $this->rns_model->getAllById($where);

				$tmp_data = [
					"selisih_rain" => 0,
					"selisih_slipper" => 0,
					"frekunsi_rain" => 0,
					"frekunsi_slipper" => 0,
					"rainfall_mm" => 0,
					"total_rns" => 0,
					"lokasi" => $data->lokasi,
				];
				if (!empty($getAllData)) {
					foreach ($getAllData as $k => $value) {
						$start = strtotime($value->start);
						$stop = 0;
						$selisih = 0;
						if (!empty($value->stop)) {
							$stop = strtotime($value->stop);
							$selisih = number_format((float) (($stop - $start) / 60 / 60), 2, '.', '');
						}

						if ($value->type == 0) {
							$tmp_data["selisih_rain"] += $selisih;
							$tmp_data["rainfall_mm"] += $value->rainfall_mm;
							$tmp_data["frekunsi_rain"] += 1;
						} else {
							$tmp_data["selisih_slipper"] += $selisih;
							$tmp_data["frekunsi_slipper"] += 1;
						}

					}
					$tmp_data['rainfall_mm'] = $tmp_data["rainfall_mm"] / $tmp_data["frekunsi_rain"];
					$tmp_data['total_rns'] = $tmp_data["selisih_rain"] + $tmp_data["selisih_slipper"];
				}

				$detail_url = "<a href='" . base_url() . "rns/detail/" . $data->tanggal . "/".$data->lokasi."' class='btn btn-sm btn-info white'><i class='fa fa-info'></i> Detail</a>";

				$nestedData['tanggal'] = $data->tanggal;
				$nestedData['lokasi'] = $data->lokasi;
				$nestedData['total_hours_rain'] = $tmp_data['selisih_rain'];
				$nestedData['total_hours_slipper'] = $tmp_data['selisih_slipper'];
				$nestedData['frekuensi_rain'] = $tmp_data["frekunsi_rain"];
				$nestedData['rainfall_mm'] = number_format((float) $tmp_data["rainfall_mm"], 2, '.', '');
				$nestedData['total_rns'] = number_format((float) $tmp_data["total_rns"], 2, '.', '');
				$nestedData['action'] = $detail_url;
				$new_data[] = $nestedData;
			}

			// foreach ($tmp_data as $key => $tmp) {
			// 	$total = 0;
			// 	$total += $tmp_data[$key]['selisih_rain'] + $tmp_data[$key]['selisih_slipper'];
			// 	$detail_url = "";

			// }

		}

		$json_data = array(
			"draw" => intval($this->input->post('draw')),
			"recordsTotal" => intval($totalData),
			"recordsFiltered" => intval($totalFiltered),
			"data" => $new_data,
		);

		echo json_encode($json_data);
	}
}
