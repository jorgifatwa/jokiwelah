<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Fleet_event_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}
	public function getOneBy($where = array()) {
		$this->db->select("fleet_event.*")->from("fleet_event");
		$this->db->where($where);
		$this->db->where("fleet_event.is_deleted", 0);

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->row();
		}
		return FALSE;
	}
	public function getAllById($where = array()) {
		$this->db->select("fleet_event.*")->from("fleet_event");

		$this->db->where($where);
		$this->db->where("fleet_event.is_deleted", 0);

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return FALSE;
	}
	public function insert($data) {
		$this->db->insert("fleet_event", $data);
		return $this->db->insert_id();
	}

	public function update($data, $where) {
		$this->db->update("fleet_event", $data, $where);
		return $this->db->affected_rows();
	}

	public function delete($where) {
		$this->db->where($where);
		$this->db->delete("fleet_event");
		if ($this->db->affected_rows()) {
			return TRUE;
		}
		return FALSE;
	}

	function getAllBy($limit, $start, $search, $col, $dir, $where) {
		$this->db->select("tanggal, shift, start_time, type_production, end_time, fleet_event.is_deleted, fleet_event.id, duration, unit.kode as unit_kode, unit_model.name as unit_model_name, unit_brand.name as unit_brand_name, enum_fleet_status.name as fleet_status_name, enum_fleet_reason.name as fleet_reason_name")->from("fleet_event");
		$this->db->join("unit", "unit.id = fleet_event.loading_unit_id");
		$this->db->join("unit_model", "unit_model.id = unit.unit_model_id");
		$this->db->join("unit_brand", "unit_brand.id = unit.brand_id");
		$this->db->join("enum_fleet_status", "enum_fleet_status.id = fleet_event.fleet_status_id");
		$this->db->join("enum_fleet_reason", "enum_fleet_reason.id = fleet_event.fleet_reason_id");
		$this->db->where("fleet_event.is_deleted", 0);
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
		$this->db->select("tanggal, shift, start_time, end_time, fleet_event.is_deleted, fleet_event.id, duration, unit.kode as unit_kode, unit_model.name as unit_model_name, unit_brand.name as unit_brand_name, enum_fleet_status.name as fleet_status_name, enum_fleet_reason.name as fleet_reason_name")->from("fleet_event");
		$this->db->join("unit", "unit.id = fleet_event.loading_unit_id");
		$this->db->join("unit_model", "unit_model.id = unit.unit_model_id");
		$this->db->join("unit_brand", "unit_brand.id = unit.brand_id");
		$this->db->join("enum_fleet_status", "enum_fleet_status.id = fleet_event.fleet_status_id");
		$this->db->join("enum_fleet_reason", "enum_fleet_reason.id = fleet_event.fleet_reason_id");
		$this->db->where("fleet_event.is_deleted", 0);

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

	public function getReasonData($where = array()) {
		$this->db->select("enum_fleet_reason.*")->from("enum_fleet_reason");

		$this->db->where($where);
		$this->db->where("enum_fleet_reason.is_deleted", 0);

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return FALSE;
	}

	public function getTotal($where = array()) {
		$this->db->select("count(fleet_event.id) as total")->from("fleet_event");
		$this->db->where($where);
		$this->db->where("fleet_event.is_deleted", 0);

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->row();
		}
		return FALSE;
	}

	public function getDataMonthly($where = array()) {
		// location.name as location_name
		$this->db->select("fleet_event.*, unit.kode as unit_kode, unit_model.name as unit_model_name,
						   unit_brand.name as unit_brand_name,
						   enum_fleet_status.name as status_name,
						   enum_fleet_reason.name as reason_name")->from("fleet_event");
		$this->db->join("enum_fleet_status", "enum_fleet_status.id = fleet_event.fleet_status_id");
		$this->db->join("enum_fleet_reason", "enum_fleet_reason.id = fleet_event.fleet_reason_id");
		$this->db->join("unit", "unit.id = fleet_event.loading_unit_id");
		$this->db->join("unit_model", "unit_model.id = unit.unit_model_id");
		$this->db->join("unit_brand", "unit_brand.id = unit.brand_id");
		// $this->db->join("location", "location.id = fleet_event.location_id");
		$this->db->order_by("fleet_event.tanggal", "ASC");
		$this->db->where($where);
		$this->db->where("fleet_event.is_deleted", 0);

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return FALSE;
	}

	public function getCatatanByUnit($where = []) {
		$this->db->select("fleet_event.loading_unit_id, fleet_event.catatan, sum(fleet_event.duration) as total_duration")->from("fleet_event");

		$this->db->where($where);
		$this->db->group_by(["fleet_event.catatan", "fleet_event.loading_unit_id"]);
		$this->db->where("fleet_event.is_deleted", 0);

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return FALSE;
	}
}
