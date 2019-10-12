<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Salary_model extends CI_Model {


    function insert_salary($data)
    {
        $this->db->insert("salary_tbl",$data);
        $this->db->affected_rows();
    }

    function select_salary()
    {
        $this->db->order_by('staff_tbl.id','DESC');
        $this->db->select("salary_tbl.*,staff_tbl.staff_name,staff_tbl.pic,department_tbl.department_name");
        $this->db->from("salary_tbl");
        $this->db->join("staff_tbl",'staff_tbl.id=salary_tbl.staff_id');
        $this->db->join("department_tbl",'department_tbl.id=staff_tbl.department_id');
        $qry=$this->db->get();
        if($qry->num_rows()>0)
        {
            $result=$qry->result_array();
            return $result;
        }
    }

    function select_salary_byID($id)
    {
        $this->db->where('salary_tbl.id',$id);
        $this->db->select("salary_tbl.*,staff_tbl.staff_name,staff_tbl.city,staff_tbl.state,staff_tbl.country,staff_tbl.mobile,staff_tbl.email,department_tbl.department_name");
        $this->db->from("salary_tbl");
        $this->db->join("staff_tbl",'staff_tbl.id=salary_tbl.staff_id');
        $this->db->join("department_tbl",'department_tbl.id=staff_tbl.department_id');
        $qry=$this->db->get();
        if($qry->num_rows()>0)
        {
            $result=$qry->result_array();
            return $result;
        }
    }

    function select_salary_byStaffID($staffid)
    {
        $this->db->where('salary_tbl.staff_id',$staffid);
        $this->db->select("salary_tbl.*,staff_tbl.staff_name,staff_tbl.city,staff_tbl.state,staff_tbl.country,staff_tbl.mobile,staff_tbl.email,department_tbl.department_name");
        $this->db->from("salary_tbl");
        $this->db->join("staff_tbl",'staff_tbl.id=salary_tbl.staff_id');
        $this->db->join("department_tbl",'department_tbl.id=staff_tbl.department_id');
        $qry=$this->db->get();
        if($qry->num_rows()>0)
        {
            $result=$qry->result_array();
            return $result;
        }
    }

    

    function select_staff_byEmail($email)
    {

        $this->db->where('email',$email);
        $qry=$this->db->get('staff_tbl');
        if($qry->num_rows()>0)
        {
            $result=$qry->result_array();
            return $result;
        }
    }

    function sum_salary()
    {
        $this->db->select_sum('total');
        $qry = $this->db->get('salary_tbl');
        if($qry->num_rows()>0)
        {
            $result=$qry->result_array();
            return $result;
        }
    }

    function delete_salary($id)
    {
        $this->db->where('id', $id);
        $this->db->delete("salary_tbl");
        $this->db->affected_rows();
    }

    
    function update_staff($data,$id)
    {
        $this->db->where('id', $id);
        $this->db->update('staff_tbl',$data);
        $this->db->affected_rows();
    }

    

    
    




}
