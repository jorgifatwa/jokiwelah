<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Coal_actual_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	public function getOneBy($where = array()) {
		$this->db->select("coal_actual.*")->from("coal_actual");
		$this->db->where($where);
		$this->db->where("coal_actual.is_deleted", 0);

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->row();
		}
		return FALSE;
	}

	public function getAllById($where = array()) {
		$this->db->select("coal_actual.*")->from("coal_actual");

		$this->db->where($where);
		$this->db->where("coal_actual.is_deleted", 0);

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return FALSE;
	}

	function select_box_data($table) {
		return $this->db->get($table)->result();
	}

	public function insert($data) {
		$this->db->insert("coal_actual", $data);
		return $this->db->insert_id();
	}

	public function getAllByDateTime($where = array()) {
		$this->db->select("coal_actual.*")->from("coal_actual");

		$this->db->where($where);
		$this->db->where("coal_actual.is_deleted", 0);

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return FALSE;
	}

	public function update($data, $where) {
		$this->db->update("coal_actual", $data, $where);
		return $this->db->affected_rows();
	}

	function getAllBy($limit, $start, $search, $col, $dir, $where) {
		$this->db->select("coal_actual.*,
			unit.kode as loading_unit_name,
			hauling.kode as hauling_unit_name,
			users.first_name as loader_name,
			hauling_users.first_name as hauler_name,
			unit_model.name as unit_model_name,
			hauling_model.name as hauling_model_name,
			unit_brand.name as unit_brand_name,
			hauling_brand.name as hauling_brand_name,
			location.name as location_name,
			seam.name as seam_name,
			disposal.name as disposal_name")->from("coal_actual");
		$this->db->join("unit", "unit.id = coal_actual.loading_unit_id");
		$this->db->join("unit hauling", "hauling.id = coal_actual.hauling_unit_id");
		$this->db->join("users", "users.id = coal_actual.loader_id");
		$this->db->join("users hauling_users", "hauling_users.id = coal_actual.hauler_id");
		$this->db->join("location", "location.id = coal_actual.location_id");
		$this->db->join("seam", "seam.id = coal_actual.seam_id");
		$this->db->join("disposal", "disposal.id = coal_actual.dumping_id");
		$this->db->join("unit_model", "unit_model.id = unit.unit_model_id");
		$this->db->join("unit_model hauling_model", "hauling_model.id = hauling.unit_model_id");
		$this->db->join("unit_brand", "unit_brand.id = unit.brand_id");
		$this->db->join("unit_brand hauling_brand", "hauling_brand.id = hauling.brand_id");
		$this->db->limit($limit, $start)->order_by($col, $dir);
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
		$this->db->select("coal_actual.id")->from("coal_actual");
		$this->db->join("unit", "unit.id = coal_actual.loading_unit_id");
		$this->db->join("unit hauling", "hauling.id = coal_actual.hauling_unit_id");
		$this->db->join("users", "users.id = coal_actual.loader_id");
		$this->db->join("users hauling_users", "hauling_users.id = coal_actual.hauler_id");
		$this->db->join("location", "location.id = coal_actual.location_id");
		$this->db->join("seam", "seam.id = coal_actual.seam_id");
		$this->db->join("disposal", "disposal.id = coal_actual.dumping_id");
		$this->db->join("unit_model", "unit_model.id = unit.unit_model_id");
		$this->db->join("unit_model hauling_model", "hauling_model.id = hauling.unit_model_id");
		$this->db->join("unit_brand", "unit_brand.id = unit.brand_id");
		$this->db->join("unit_brand hauling_brand", "hauling_brand.id = hauling.brand_id");
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
		$this->db->select("SUM(netto) as total")->from("coal_actual");
		$this->db->where($where);
		$this->db->where("is_deleted", 0);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->row()->total;
		}
		return 0;
	}

	public function getCoalHaulingByDumping($where = []) {
		$this->db->select("SUM(coal_actual.netto) as total_netto, disposal.name as dumping_name, disposal.id as dumping_id")->from("coal_actual");
		$this->db->join("disposal", "disposal.id = coal_actual.dumping_id AND disposal.production = 2");
		$this->db->where("coal_actual.aktivitas", 1);
		$this->db->where($where);
		$this->db->order_by("disposal.name", "ASC");
		$this->db->group_by("disposal.name");

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return FALSE;
	}

	public function getTotalPerTanggal($where) {
		$this->db->select("SUM(coal_actual.netto) as total, DATE_FORMAT(coal_actual.tanggal, '%d') as tanggal")->from("coal_actual");
		$this->db->where($where);
		$this->db->where("is_deleted", 0);
		$this->db->group_by("DATE_FORMAT(coal_actual.tanggal, '%d')");
		$this->db->order_by("coal_actual.tanggal", "asc");

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return FALSE;
	}

	public function getCoalHaulingDumpingPertanggal($where = []) {
		$this->db->select("SUM(coal_actual.netto) as total_netto, disposal.id as dumping_id, DATE_FORMAT(coal_actual.tanggal, '%d') as tanggal")->from("coal_actual");
		$this->db->join("disposal", "disposal.id = coal_actual.dumping_id AND disposal.production = 2");
		$this->db->where("coal_actual.aktivitas", 1);
		$this->db->where($where);
		$this->db->group_by(["disposal.id", "DATE_FORMAT(coal_actual.tanggal, '%d')"]);
		$this->db->order_by("coal_actual.tanggal", "asc");

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return FALSE;
	}

	public function getProductivity($where = []) {
		$this->db->select("coal_actual.loading_unit_id, unit.kode, unit.kode, sum(coal_actual.netto) as total_netto")->from("coal_actual");
		$this->db->join("unit", "unit.id = coal_actual.loading_unit_id");
		$this->db->where($where);
		$this->db->group_by("coal_actual.loading_unit_id");
		$this->db->where("coal_actual.is_deleted", 0);

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return FALSE;
	}
}
