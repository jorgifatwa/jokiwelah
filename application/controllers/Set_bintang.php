<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'core/Admin_Controller.php';
class Set_bintang extends Admin_Controller 
{
	public function __construct() 
	{
		parent::__construct();
		$this->load->model('set_bintang_model');
		$this->load->model('rank_model');
	}

	public function index() 
	{
		$this->load->helper('url');
		if ($this->data['is_can_read']) {
			$this->data['content'] = 'admin/set_bintang/list_v';
		} else {
			$this->data['content'] = 'errors/html/restrict';
		}

		$this->load->view('admin/layouts/page', $this->data);
	}

	public function edit($id) 
	{
		$this->form_validation->set_rules('price', "Harga Harus Diisi", 'trim|required');

		if ($this->form_validation->run() === TRUE) {
			$data = array(
				'price' => $this->input->post('price'),
			);
			$update = $this->set_bintang_model->update($data, array("star_price.id" => $id));
			if ($update) {
				$this->session->set_flashdata('message', "Harga Bintang Berhasil Diubah");
				redirect("set_bintang", "refresh");
			} else {
				$this->session->set_flashdata('message_error', "Harga Bintang Gagal Diubah");
				redirect("set_bintang", "refresh");
			}
		} else {
			if (!empty($_POST)) {
				$id = $this->input->post('id');
				$this->session->set_flashdata('message_error', validation_errors());
				return redirect("set_bintang/edit/" . $id);
			} else {
				$this->data['id'] = $this->uri->segment(3);
				$set_bintang = $this->set_bintang_model->getAllById(array("star_price.id" => $this->data['id']));
				$this->data['price'] 	= (!empty($set_bintang)) ? $set_bintang[0]->price : "";
				$this->data['rank_name'] 	= (!empty($set_bintang)) ? $set_bintang[0]->rank_name : "";
				$this->data['ranks'] = $this->rank_model->getAllById();
				$this->data['content'] = 'admin/set_bintang/edit_v';
				$this->load->view('admin/layouts/page', $this->data);
			}
		}

	}

	public function dataList() 
	{
		$columns = array(
			0 => 'rank_name',
			1 => 'price',
			2 => '',
		);

		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];
		$search = array();
		$limit = 0;
		$start = 0;
		$totalData = $this->set_bintang_model->getCountAllBy($limit, $start, $search, $order, $dir);

		if (!empty($this->input->post('search')['value'])) {
			$search_value = $this->input->post('search')['value'];
			$search = array(
				"rank.name" => $search_value,
				"star_price.price" => $search_value,
			);
			$totalFiltered = $this->set_bintang_model->getCountAllBy($limit, $start, $search, $order, $dir);
		} else {
			$totalFiltered = $totalData;
		}

		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$datas = $this->set_bintang_model->getAllBy($limit, $start, $search, $order, $dir);

		$new_data = array();
		if (!empty($datas)) {

			foreach ($datas as $key => $data) {
				$edit_url = "";
				$delete_url = "";

				if ($this->data['is_can_edit'] && $data->is_deleted == 0) {
					$edit_url = "<a href='" . base_url() . "set_bintang/edit/" . $data->id . "' class='btn btn-sm btn-info white'> Ubah</a>";
				}

				$nestedData['id'] = $start + $key + 1;
				$nestedData['price'] = "Rp.".number_format($data->price);
				$nestedData['rank_name'] = $data->rank_name;
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

}
