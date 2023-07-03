<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Hours_meter_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}
	public function getOneBy($where = array()) {
		$this->db->select("hours_meter.*")->from("hours_meter");
		$this->db->where($where);
		$this->db->where("hours_meter.is_deleted", 0);

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->row();
		}
		return FALSE;
	}
	public function getAllById($where = array()) {
		$this->db->select("hours_meter.*")->from("hours_meter");

		$this->db->where($where);
		$this->db->where("hours_meter.is_deleted", 0);

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return FALSE;
	}
	public function insert($data) {
		$this->db->insert("hours_meter", $data);
		return $this->db->insert_id();
	}

	public function update($data, $where) {
		$this->db->update("hours_meter", $data, $where);
		return $this->db->affected_rows();
	}

	public function delete($where) {
		$this->db->where($where);
		$this->db->delete("hours_meter");
		if ($this->db->affected_rows()) {
			return TRUE;
		}
		return FALSE;
	}

	function getAllBy($limit, $start, $search, $col, $dir, $where) {
		$this->db->select("hours_meter.*, unit.kode as unit_kode, unit_model.name as unit_model_name, unit_brand.name as unit_brand_name, location.name as location_name, users.first_name as operator_name, enum_shift.name as shift_name")->from("hours_meter");
		$this->db->join("unit", "unit.id = hours_meter.unit_id");
		$this->db->join("unit_model", "unit_model.id = unit.unit_model_id");
		$this->db->join("unit_brand", "unit_brand.id = unit.brand_id");
		$this->db->join("enum_shift", "enum_shift.id = hours_meter.shift_id");
		$this->db->join("location", "location.id = hours_meter.location_id");
		$this->db->join("users", "users.id = hours_meter.operator_id");
		$this->db->where("hours_meter.is_deleted", 0);

		$this->db->limit($limit,$start)->order_by($col,$dir);
        if(!empty($where)){
            $this->db->where($where);
        }

        if(!empty($search)){
            $this->db->group_start();
            foreach($search as $key => $value){
                $this->db->or_like($key,$value);    
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
		$this->db->select("hours_meter.*, unit.kode as unit_kode, unit_model.name as unit_model_name, unit_brand.name as unit_brand_name, location.name as location_name, users.first_name as operator_name, enum_shift.name as shift_name")->from("hours_meter");
		$this->db->join("unit", "unit.id = hours_meter.unit_id");
		$this->db->join("unit_model", "unit_model.id = unit.unit_model_id");
		$this->db->join("unit_brand", "unit_brand.id = unit.brand_id");
		$this->db->join("enum_shift", "enum_shift.id = hours_meter.shift_id");
		$this->db->join("location", "location.id = hours_meter.location_id");
		$this->db->join("users", "users.id = hours_meter.operator_id");
		$this->db->where("hours_meter.is_deleted", 0);
		if(!empty($where)){
            $this->db->where($where);
        }

        if(!empty($search)){
            $this->db->group_start();
            foreach($search as $key => $value){
                $this->db->or_like($key,$value);    
            }   
            $this->db->group_end();
        }

		$result = $this->db->get();

		return $result->num_rows();
	}

	public function getDataMonthly($where = array()) {
		$this->db->select("hours_meter.*, unit.kode as unit_kode, unit_model.name as unit_model_name, 
						   unit_brand.name as unit_brand_name, location.name as location_name, 
						   users.first_name as operator_name, enum_shift.name as shift_name,
						   breakdown.time_down")->from("hours_meter");
		$this->db->join("unit", "unit.id = hours_meter.unit_id");
		$this->db->join("breakdown", "breakdown.unit_id = hours_meter.unit_id AND breakdown.tanggal_bd = hours_meter.tanggal", "left");
		$this->db->join("unit_model", "unit_model.id = unit.unit_model_id");
		$this->db->join("unit_brand", "unit_brand.id = unit.brand_id");
		$this->db->join("enum_shift", "enum_shift.id = hours_meter.shift_id");
		$this->db->join("location", "location.id = hours_meter.location_id");
		$this->db->join("users", "users.id = hours_meter.operator_id");
		$this->db->order_by("hours_meter.tanggal","ASC");
		$this->db->where($where);
		$this->db->where("hours_meter.is_deleted", 0);

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return FALSE;
	}
	
	public function getDataHmByLocation($where = array(), $type = "month") {
		if($type == "day"){
			$tanggal = "DATE(hours_meter.tanggal) as filter_tanggal,";
		}

		if($type == "week"){
			$tanggal = "DATE_FORMAT(hours_meter.tanggal, '%u') AS filter_tanggal,";
		}

		if($type == "month"){
			$tanggal = "MONTH(hours_meter.tanggal) as filter_tanggal,";
		}

		$this->db->select("COUNT(hours_meter.id) as total, location.name as location_name, ".$tanggal)->from("hours_meter");
		$this->db->join("location", "location.id = hours_meter.location_id");
		$this->db->where($where);
		$this->db->group_by(["location.id","filter_tanggal"]);
		$this->db->order_by("hours_meter.tanggal","ASC");
		$this->db->where("hours_meter.is_deleted", 0);
		$this->db->where("location.is_deleted", 0);

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return FALSE;
	}

	public function getDataHmByOperator($where = array(), $type = "month") {
		if($type == "day"){
			$tanggal = "DATE(hours_meter.tanggal) as filter_tanggal,";
		}

		if($type == "week"){
			$tanggal = "DATE_FORMAT(hours_meter.tanggal, '%u') AS filter_tanggal,";
		}

		if($type == "month"){
			$tanggal = "MONTH(hours_meter.tanggal) as filter_tanggal,";
		}

		$this->db->select("COUNT(hours_meter.id) as total, users.first_name as operator_name, ".$tanggal)->from("hours_meter");
		$this->db->join("users", "users.id = hours_meter.operator_id");
		$this->db->where($where);
		$this->db->group_by(["users.id","filter_tanggal"]);
		$this->db->order_by("hours_meter.tanggal","ASC");
		$this->db->where("hours_meter.is_deleted", 0);
		$this->db->where("users.is_deleted", 0);

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return FALSE;
	}

	public function getDataHmByUnit($where = array(), $type = "month") {
		if($type == "day"){
			$tanggal = "DATE(hours_meter.tanggal) as filter_tanggal,";
		}

		if($type == "week"){
			$tanggal = "DATE_FORMAT(hours_meter.tanggal, '%u') AS filter_tanggal,";
		}

		if($type == "month"){
			$tanggal = "MONTH(hours_meter.tanggal) as filter_tanggal,";
		}

		$this->db->select("SUM(hours_meter.duration) as duration, 
						   SUM(DATE_FORMAT(breakdown.time_down, '%h') + (DATE_FORMAT(breakdown.time_down, '%i')/60)) as breakdown, 
						   SUM(12-hours_meter.duration-DATE_FORMAT(breakdown.time_down, '%h') + (DATE_FORMAT(breakdown.time_down, '%i')/60)) as standby, 
						   ".$tanggal)->from("hours_meter");
		$this->db->join("unit", "unit.id = hours_meter.unit_id");
		$this->db->join("breakdown", "breakdown.unit_id = hours_meter.unit_id AND breakdown.tanggal_bd = hours_meter.tanggal", "left");
		$this->db->where($where);
		$this->db->group_by(["filter_tanggal"]);
		$this->db->order_by("hours_meter.tanggal","ASC");
		$this->db->where("hours_meter.is_deleted", 0);

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return FALSE;
	}
}
