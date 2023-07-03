<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Unit_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}
	public function getOneBy($where = array()) {
		$this->db->select("unit.*")->from("unit");
		$this->db->where($where);
		$this->db->where("unit.is_deleted", 0);

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->row();
		}
		return FALSE;
	}

	public function getTotal($where = array()) {
		$this->db->select("count(unit.id) as total")->from("unit");
		$this->db->where($where);
		$this->db->where("unit.is_deleted", 0);

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->row();
		}
		return FALSE;
	}
	public function getAllById($where = array()) {
		$this->db->select("unit.*, unit_model.name as unit_model_name, unit_brand.name as brand_name")->from("unit");
		$this->db->join("unit_model", "unit_model.id = unit.unit_model_id");
		$this->db->join("unit_brand", "unit_brand.id = unit.brand_id");
		$this->db->where($where);
		$this->db->where("unit.is_deleted", 0);

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return FALSE;
	}

	public function getUnit($where = array()) {
		$this->db->select("unit.*")->from("unit");
		$this->db->where($where);
		$this->db->where("unit.is_deleted", 0);

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return FALSE;
	}

	public function insert($data) {
		$this->db->insert("unit", $data);
		return $this->db->insert_id();
	}

	public function insert_unit_material($data) {
		$this->db->insert("unit_material", $data);
		return $this->db->insert_id();
	}

	public function update($data, $where) {
		$this->db->update("unit", $data, $where);
		return $this->db->affected_rows();
	}

	public function delete($where) {
		$this->db->where($where);
		$this->db->delete("unit");
		if ($this->db->affected_rows()) {
			return TRUE;
		}
		return FALSE;
	}

	function getAllBy($limit, $start, $search, $col, $dir, $where = []) {
		$this->db->select("unit.*, unit_category.name as category_name, unit_brand.name as brand_name, unit_model.name as unit_model_name")->from("unit");
		$this->db->join("unit_category", "unit_category.id = unit.unit_category_id");
		$this->db->join("unit_model", "unit_model.id = unit.unit_model_id");
		$this->db->join("unit_brand", "unit_brand.id = unit.brand_id");
		$this->db->where("unit.is_deleted", 0);

		$this->db->limit($limit, $start)->order_by($col, $dir);

		if (!empty($search)) {
			$this->db->group_start();
			foreach ($search as $key => $value) {
				$this->db->or_like($key, $value);
			}
			$this->db->group_end();
		}
		$this->db->where($where);
		$result = $this->db->get();
		if ($result->num_rows() > 0) {
			return $result->result();
		} else {
			return null;
		}
	}

	function getAll() {
		$this->db->select("unit.*, unit_category.name as category_name, unit_brand.name as brand_name, unit_model.name as unit_model_name")->from("unit");
		$this->db->join("unit_category", "unit_category.id = unit.unit_category_id");
		$this->db->join("unit_model", "unit_model.id = unit.unit_model_id");
		$this->db->join("unit_brand", "unit_brand.id = unit.brand_id");
		$this->db->where("unit.is_deleted", 0);

		$result = $this->db->get();
		if ($result->num_rows() > 0) {
			return $result->result();
		} else {
			return null;
		}
	}

	function getCountAllBy($limit, $start, $search, $order, $dir, $where = []) {
		$this->db->select("unit.*, unit_category.name as category_name, unit_brand.name as brand_name, unit_model.name as unit_model_name")->from("unit");
		$this->db->join("unit_category", "unit_category.id = unit.unit_category_id");
		$this->db->join("unit_model", "unit_model.id = unit.unit_model_id");
		$this->db->join("unit_brand", "unit_brand.id = unit.brand_id");
		$this->db->where("unit.is_deleted", 0);
		if (!empty($search)) {
			$this->db->group_start();
			foreach ($search as $key => $value) {
				$this->db->or_like($key, $value);
			}
			$this->db->group_end();
		}
		$this->db->where($where);
		$result = $this->db->get();

		return $result->num_rows();
	}

	public function getAllByLocation($where = array()) {
		$this->db->select("unit.*, unit_model.name as unit_model_name, unit_brand.name as brand_name")->from("unit_transfer");
		$this->db->join("location lokasi_tujuan", "lokasi_tujuan.id = unit_transfer.to_location");
		$this->db->join("unit", "unit.id = unit_transfer.unit_id");
		$this->db->join("unit_brand", "unit_brand.id = unit.brand_id");
		$this->db->join("unit_model", "unit_model.id = unit.unit_model_id");
		$this->db->where("unit_transfer.is_deleted", 1);
		$this->db->where($where);
		$this->db->group_by('unit_transfer.unit_id');
		$this->db->order_by('unit_transfer.id', 'DESC');

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return FALSE;
	}
}
