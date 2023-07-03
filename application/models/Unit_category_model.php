<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Unit_category_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}
	public function getOneBy($where = array()) {
		$this->db->select("unit_category.*")->from("unit_category");
		$this->db->where($where);
		$this->db->where("unit_category.is_deleted", 0);

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->row();
		}
		return FALSE;
	}
	public function getAllById($where = array()) {
		$this->db->select("unit_category.*")->from("unit_category");

		$this->db->where($where);
		$this->db->where("unit_category.is_deleted", 0);
		$this->db->order_by("unit_category.name", "ASC");

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return FALSE;
	}
	public function insert($data) {
		$this->db->insert("unit_category", $data);
		return $this->db->insert_id();
	}

	public function update($data, $where) {
		$this->db->update("unit_category", $data, $where);
		return $this->db->affected_rows();
	}

	public function delete($where) {
		$this->db->where($where);
		$this->db->delete("unit_category");
		if ($this->db->affected_rows()) {
			return TRUE;
		}
		return FALSE;
	}

	function getAllBy($limit, $start, $search, $col, $dir, $where = []) {
		$this->db->select("unit_category.*")->from("unit_category");
		$this->db->limit($limit, $start)->order_by($col, $dir);
		$this->db->where("unit_category.is_deleted", 0);
		$this->db->where($where);
		if (!empty($search)) {
			$this->db->group_start();
			foreach ($search as $key => $value) {
				$this->db->or_like($key, $value);
			}
			$this->db->group_end();
		}

		$result = $this->db->get();
		if ($result->num_rows() > 0) {
			return $result->result();
		} else {
			return null;
		}
	}

	function getCountAllBy($limit, $start, $search, $order, $dir, $where = []) {
		$this->db->select("unit_category.*")->from("unit_category");
		$this->db->where("unit_category.is_deleted", 0);
		$this->db->where($where);
		if (!empty($search)) {
			$this->db->group_start();
			foreach ($search as $key => $value) {
				$this->db->or_like($key, $value);
			}
			$this->db->group_end();
		}

		$result = $this->db->get();

		return $result->num_rows();
	}
}
