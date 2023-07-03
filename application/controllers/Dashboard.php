<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'core/Admin_Controller.php';
class Dashboard extends Admin_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('pekerjaan_model');
	}
	public function index() {
		$this->load->helper('url');
		if ($this->data['is_can_read']) {
			$this->data['content'] = 'admin/dashboard';
		} else {
			$this->data['content'] = 'errors/html/restrict';
		}

		$totals = $this->pekerjaan_model->getTotalPendapatan();

		$this->data['pendapatan_kotor'] = $totals->total_pendapatan;

		$this->load->view('admin/layouts/page', $this->data);
	}

	public function grafikPendapatan() {

		$bulan = [
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
			12 => 'Desember',
		];

		$datas = $this->pekerjaan_model->getAllGrafik();
		
		$month = [];
		$data_pendapatan = [];
		
		$i = 1;

		if(!empty($datas)){
			foreach ($datas as $key => $data) {
				$month[$i] = (int)date("m",strtotime($data->tanggal));
				$data_pendapatan[] = (int)$data->total_pendapatan;
				$data_bulan[$i] = $bulan[$month[$i]];
				$i++;
			}
		}

		$data_grafik = [
			"tahun" => date('Y'),
			"category" => $data_bulan,
			"pendapatan" => $data_pendapatan,
		];

		if (!empty($datas)) {
			$return_data['data'] = $datas;
			$return_data['grafik'] = $data_grafik;
			$return_data['status'] = true;
			$return_data['message'] = "Berhasil mengambil data!";
		} else {
			$return_data['data'] = [];
			$return_data['grafik'] = [];
			$return_data['status'] = false;
			$return_data['message'] = "Gagal mengambil data!";
		}

		echo json_encode($return_data);
	}
}
