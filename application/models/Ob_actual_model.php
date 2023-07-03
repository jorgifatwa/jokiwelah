<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Ob_actual_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}

	public function getAllById($where = array()) {
		$this->db->select("ob_actual.*")->from("ob_actual");

		$this->db->where($where);
		$this->db->where("ob_actual.is_deleted", 0);

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return FALSE;
	}

	function select_box_data($table) {
		return $this->db->where('is_deleted', 0)->get($table)->result();
	}

	public function insert($data) {
		$this->db->insert("ob_actual", $data);
		return $this->db->insert_id();
	}

	public function insert_production($data) {
		$this->db->insert("production_js", $data);
		return $this->db->insert_id();
	}

	public function getAllByDateTime($where = array()) {
		$this->db->select("ob_actual.*")->from("ob_actual");

		$this->db->where($where);
		$this->db->where("ob_actual.is_deleted", 0);

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return FALSE;
	}

	public function update($data, $where) {
		$this->db->update("ob_actual", $data, $where);
		return $this->db->affected_rows();
	}

	function getAllBy($limit, $start, $search, $col, $dir, $where) {
		$this->db->select("tanggal, ob_actual.is_deleted, ob_actual.id,
                           jam, shift, total_ritase, total_production, capacity,
                           unit.kode as loading_unit_name, hauling.kode as hauling_unit_name,
                           loader.first_name as loader_name, supervisor.first_name as supervisor_name")->from("ob_actual");
		$this->db->join("unit", "unit.id = ob_actual.loading_unit_id");
		$this->db->join("users loader", "loader.id = ob_actual.loader_id");
		$this->db->join("users supervisor", "supervisor.id = ob_actual.supervisor_id");
		$this->db->join("unit hauling", "hauling.id = ob_actual.hauling_unit_id");
		$this->db->where("ob_actual.is_deleted", 0);

		if (!empty($where)) {
			$this->db->where($where);
		}
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

	function getCountAllBy($limit, $start, $search, $order, $dir, $where) {
		$this->db->select("tanggal, jam, shift, total_ritase, total_production, capacity, unit.kode as loading_unit_name, loader.first_name as loader_name, supervisor.first_name as supervisor_name")->from("ob_actual");
		$this->db->join("unit", "unit.id = ob_actual.loading_unit_id");
		$this->db->join("users loader", "loader.id = ob_actual.loader_id");
		$this->db->join("users supervisor", "supervisor.id = ob_actual.supervisor_id");
		$this->db->join("unit hauling", "hauling.id = ob_actual.hauling_unit_id");
		$this->db->where("ob_actual.is_deleted", 0);

		if (!empty($where)) {
			$this->db->where($where);
		}
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

	public function getTotal($where) {
		$this->db->select("SUM(total_production) as total")->from("ob_actual");
		$this->db->where($where);
		$this->db->where("is_deleted", 0);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->row()->total;
		}
		return 0;
	}

	public function getTotalPerTanggal($where) {
		$this->db->select("SUM(total_production) as total, DATE_FORMAT(ob_actual.tanggal, '%d') as tanggal")->from("ob_actual");
		$this->db->where($where);
		$this->db->where("is_deleted", 0);
		$this->db->group_by("DATE_FORMAT(ob_actual.tanggal, '%d')");
		$this->db->order_by("ob_actual.tanggal", "asc");

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return FALSE;
	}

	public function getProductivity($where = []) {
		$this->db->select("ob_actual.loading_unit_id, unit.kode, SUM(total_production) as total_produksi")->from("ob_actual");
		$this->db->join("unit", "unit.id = ob_actual.loading_unit_id");
		$this->db->where($where);
		$this->db->where("ob_actual.is_deleted", 0);
		$this->db->group_by(["ob_actual.tanggal", "unit.id"]);
		$this->db->order_by("unit.kode", "asc");

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return FALSE;
	}
}
