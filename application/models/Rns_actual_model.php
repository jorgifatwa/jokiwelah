<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Rns_actual_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}
	public function getOneBy($where = array()) {
		$this->db->select("rns_actual.*")->from("rns_actual");
		$this->db->where($where);
		$this->db->limit(1);
		$this->db->order_by('rns_actual.id', 'DESC');

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->row();
		}
		return FALSE;
	}
	public function getAllById($where = array()) {
		$this->db->select("rns_actual.*")->from("rns_actual");

		$this->db->where($where);
		$this->db->where("rns_actual.is_deleted", 0);

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return FALSE;
	}
	public function insert($data) {
		$this->db->insert("rns_actual", $data);
		return $this->db->insert_id();
	}

	public function update($data, $where) {
		$this->db->update("rns_actual", $data, $where);
		return $this->db->affected_rows();
	}

	public function delete($where) {
		$this->db->where($where);
		$this->db->delete("rns_actual");
		if ($this->db->affected_rows()) {
			return TRUE;
		}
		return FALSE;
	}

	function getAllBy($limit, $start, $search, $col, $dir, $where) {
		$this->db->select("rns_actual.*, location.name as site_name, pit.name as pit_name, seam.name as seam_name, blok.name as blok_name")->from("rns_actual");
		$this->db->join("location", "location.id = rns_actual.location_id");
		$this->db->join("pit", "pit.id = rns_actual.pit_id");
		$this->db->join("seam", "seam.id = rns_actual.seam_id");
		$this->db->join("blok", "blok.id = rns_actual.blok_id");
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
		$this->db->select("rns_actual.*, location.name as site_name, pit.name as pit_name, seam.name as seam_name, blok.name as blok_name")->from("rns_actual");
		$this->db->join("location", "location.id = rns_actual.location_id");
		$this->db->join("pit", "pit.id = rns_actual.pit_id");
		$this->db->join("seam", "seam.id = rns_actual.seam_id");
		$this->db->join("blok", "blok.id = rns_actual.blok_id");
	
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

	public function getAllForDashboard($where = [])
	{
		$this->db->select("rns_actual.type, rns_actual.shift, rns_actual.tanggal, rns_actual.start, rns_actual.stop, rns_actual.pit_id, pit.name as pit_name")->from("rns_actual");
		$this->db->join("pit", "pit.id = rns_actual.pit_id");
		if(!empty($where)){
            $this->db->where($where);
        }

		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		return FALSE;
	}
}
