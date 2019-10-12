<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home_model extends CI_Model {

    function logindata($un,$pw)
    {
        $this->db->where('username',$un);               
        $this->db->where('password',$pw);
        $qry=$this->db->get("login_tbl");
        if($qry->num_rows()>0)
        {
            $result=$qry->result_array();
            return $result;
        }
    }

    function insert_login($data)
    {
        $this->db->insert("login_tbl",$data);
        return $this->db->insert_id();
    }

    function update_rooms($data,$id)
    {
        $this->db->where('id', $id);
        $this->db->update('room_tbl',$data);
    }

    function select_reservation()
    {
        $this->db->order_by('reservation_tbl.id','DESC');
        $this->db->select("reservation_tbl.*,room_tbl.roomname,booking_tbl.name,booking_tbl.email,booking_tbl.phno");
        $this->db->from("reservation_tbl");
        $this->db->join("room_tbl",'room_tbl.id=reservation_tbl.room');
        $this->db->join("booking_tbl",'booking_tbl.id=reservation_tbl.booking_id');
        $qry=$this->db->get();
        if($qry->num_rows()>0)
        {
            $result=$qry->result_array();
            return $result;
        }
    }

    function select_countries()
    {
        $qry=$this->db->get('country_tbl');
        if($qry->num_rows()>0)
        {
            $result=$qry->result_array();
            return $result;
        }
    }
    function select_rooms_byID($id)
    {

        $this->db->where('id',$id);
        $qry=$this->db->get('room_tbl');
        if($qry->num_rows()>0)
        {
            $result=$qry->result_array();
            return $result;
        }
    }

    function delete_login_byID($id)
    {
        $this->db->where('id', $id);
        $this->db->delete("login_tbl");
        $this->db->affected_rows();
    }




}
