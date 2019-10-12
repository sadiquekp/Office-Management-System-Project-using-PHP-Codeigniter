<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Leave extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        if ( ! $this->session->userdata('logged_in'))
        { 
            redirect(base_url().'login');
        }
    }

    public function index()
    {
        $this->load->view('staff/header');
        $this->load->view('staff/apply-leave');
        $this->load->view('staff/footer');
    }

    public function approve()
    {
        $staff=$this->session->userdata('userid');
        $data['content']=$this->Leave_model->select_leave_forApprove();
        $this->load->view('admin/header');
        $this->load->view('admin/approve-leave',$data);
        $this->load->view('admin/footer');
    }

    public function manage()
    {
        $data['content']=$this->Leave_model->select_leave();
        $this->load->view('admin/header');
        $this->load->view('admin/manage-leave',$data);
        $this->load->view('admin/footer');
    }

    public function view()
    {
        $staff=$this->session->userdata('userid');
        $data['content']=$this->Leave_model->select_leave_byStaffID($staff);
        $this->load->view('staff/header');
        $this->load->view('staff/view-leave',$data);
        $this->load->view('staff/footer');
    }

    public function insert_approve($id)
    {
        $data=$this->Leave_model->update_leave(array('status'=>1),$id);
        if($this->db->affected_rows() > 0)
        {
            $this->session->set_flashdata('success', "Leave Approved Succesfully"); 
        }else{
            $this->session->set_flashdata('error', "Sorry, Leave Approve Failed.");
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function insert_reject($id)
    {
        $data=$this->Leave_model->update_leave(array('status'=>2),$id);
        if($this->db->affected_rows() > 0)
        {
            $this->session->set_flashdata('success', "Leave Rejected Succesfully"); 
        }else{
            $this->session->set_flashdata('error', "Sorry, Leave Reject Failed.");
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function insert()
    {
        $this->form_validation->set_rules('txtreason', 'Reasoon', 'required');
        $this->form_validation->set_rules('txtleavefrom', 'Leave From', 'required');
        $this->form_validation->set_rules('txtleaveto', 'Leave To', 'required');

        $staff=$this->session->userdata('userid');
        $reason=$this->input->post('txtreason');
        $lfrom=$this->input->post('txtleavefrom');
        $lto=$this->input->post('txtleaveto');
        $desc=$this->input->post('txtdescription');
        $data=$this->Leave_model->insert_leave(array('staff_id'=>$staff,'leave_reason'=>$reason,'leave_from'=>$lfrom,'leave_to'=>$lto,'description'=>$desc,'applied_on'=>date('Y-m-d')));
        if($data==true)
        {
            $this->session->set_flashdata('success', "New Leave Applied Succesfully"); 
        }else{
            $this->session->set_flashdata('error', "Sorry, New Leave Apply Failed.");
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function update()
    {
        $id=$this->input->post('txtid');
        $department=$this->input->post('txtdepartment');
        $data=$this->Department_model->update_department(array('department_name'=>$department),$id);
        if($this->db->affected_rows() > 0)
        {
            $this->session->set_flashdata('success', "Department Updated Succesfully"); 
        }else{
            $this->session->set_flashdata('error', "Sorry, Department Update Failed.");
        }
        redirect(base_url()."department/manage_department");
    }


    function edit($id)
    {
        $data['content']=$this->Department_model->select_department_byID($id);
        $this->load->view('admin/header');
        $this->load->view('admin/edit-department',$data);
        $this->load->view('admin/footer');
    }


    function delete($id)
    {
        $data=$this->Department_model->delete_department($id);
        if($this->db->affected_rows() > 0)
        {
            $this->session->set_flashdata('success', "Department Deleted Succesfully"); 
        }else{
            $this->session->set_flashdata('error', "Sorry, Department Delete Failed.");
        }
        redirect($_SERVER['HTTP_REFERER']);
    }



}
