<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Leave_model extends CI_Model {


    function insert_leave($data)
    {
        $this->db->insert("leave_tbl",$data);
        return $this->db->insert_id();
    }

    function select_leave()
    {
        $this->db->order_by('leave_tbl.id','DESC');
        $this->db->select("leave_tbl.*,staff_tbl.pic,staff_tbl.staff_name,staff_tbl.city,staff_tbl.state,staff_tbl.country,staff_tbl.mobile,staff_tbl.email,department_tbl.department_name");
        $this->db->from("leave_tbl");
        $this->db->join("staff_tbl",'staff_tbl.id=leave_tbl.staff_id');
        $this->db->join("department_tbl",'department_tbl.id=staff_tbl.department_id');
        $qry=$this->db->get();
        if($qry->num_rows()>0)
        {
            $result=$qry->result_array();
            return $result;
        }
    }

    function select_department_byID($id)
    {

        $this->db->where('id',$id);
        $qry=$this->db->get('department_tbl');
        if($qry->num_rows()>0)
        {
            $result=$qry->result_array();
            return $result;
        }
    }

    function select_leave_byStaffID($staffid)
    {
        $this->db->order_by('leave_tbl.id','DESC');
        $this->db->where('leave_tbl.staff_id',$staffid);
        $this->db->select("leave_tbl.*,staff_tbl.staff_name,staff_tbl.city,staff_tbl.state,staff_tbl.country,staff_tbl.mobile,staff_tbl.email,department_tbl.department_name");
        $this->db->from("leave_tbl");
        $this->db->join("staff_tbl",'staff_tbl.id=leave_tbl.staff_id');
        $this->db->join("department_tbl",'department_tbl.id=staff_tbl.department_id');
        $qry=$this->db->get();
        if($qry->num_rows()>0)
        {
            $result=$qry->result_array();
            return $result;
        }
    }

    function select_leave_forApprove()
    {
        $this->db->where('leave_tbl.status',0);
        $this->db->select("leave_tbl.*,staff_tbl.pic,staff_tbl.staff_name,staff_tbl.city,staff_tbl.state,staff_tbl.country,staff_tbl.mobile,staff_tbl.email,department_tbl.department_name");
        $this->db->from("leave_tbl");
        $this->db->join("staff_tbl",'staff_tbl.id=leave_tbl.staff_id');
        $this->db->join("department_tbl",'department_tbl.id=staff_tbl.department_id');
        $qry=$this->db->get();
        if($qry->num_rows()>0)
        {
            $result=$qry->result_array();
            return $result;
        }
    }

    function delete_department($id)
    {
        $this->db->where('id', $id);
        $this->db->delete("department_tbl");
        $this->db->affected_rows();
    }

    

    function update_leave($data,$id)
    {
        $this->db->where('id', $id);
        $this->db->update('leave_tbl',$data);
        $this->db->affected_rows();
    }

    




}
