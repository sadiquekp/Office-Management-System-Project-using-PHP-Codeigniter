<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Salary extends CI_Controller {

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
        $data['departments']=$this->Department_model->select_departments();
        $this->load->view('admin/header');
        $this->load->view('admin/add-salary',$data);
        $this->load->view('admin/footer');
    }

    public function invoice($id)
    {
        $data['content']=$this->Salary_model->select_salary_byID($id);
        $this->load->view('admin/header');
        $this->load->view('admin/salary-invoice',$data);
        $this->load->view('admin/footer');
    }

    public function invoice_print($id)
    {
        $data['content']=$this->Salary_model->select_salary_byID($id);
        $this->load->view('admin/invoice-print',$data);
    }

    public function manage()
    {
        $data['content']=$this->Salary_model->select_salary();
        $this->load->view('admin/header');
        $this->load->view('admin/manage-salary',$data);
        $this->load->view('admin/footer');
    }

    public function view()
    {
        $staff=$this->session->userdata('userid');
        $data['content']=$this->Salary_model->select_salary_byStaffID($staff);
        $this->load->view('staff/header');
        $this->load->view('staff/view-salary',$data);
        $this->load->view('staff/footer');
    }

    public function insert()
    {
        $id=$this->input->post('txtid');
        $basic=$this->input->post('txtbasic');
        $allowance=$this->input->post('txtallowance');
        $total=$this->input->post('txttotal');
        $added=$this->session->userdata('userid');

        $salary=array();
        for ($i=0; $i < count($id); $i++)
        { 
            if($total[$i]>0)
            {
                $data=$this->Salary_model->insert_salary(array('staff_id' => $id[$i],
                    'basic_salary' => $basic[$i],
                    'allowance' => $allowance[$i],
                    'total' => $total[$i],
                    'added_by' => $added)
                );
            }
        }
        
        if($this->db->affected_rows() > 0)
        {
            $this->session->set_flashdata('success', "Salary Added Succesfully"); 
        }else{
            $this->session->set_flashdata('error', "Sorry, Salary Adding Failed.");
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
            $this->session->set_flashdata('success', "Salary Updated Succesfully"); 
        }else{
            $this->session->set_flashdata('error', "Sorry, Salary Update Failed.");
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
        $data=$this->Salary_model->delete_salary($id);
        if($this->db->affected_rows() > 0)
        {
            $this->session->set_flashdata('success', "Salary Deleted Succesfully"); 
        }else{
            $this->session->set_flashdata('error', "Sorry, Salary Delete Failed.");
        }
        redirect($_SERVER['HTTP_REFERER']);
    }


    public function get_salary_list()
    {
        $dept = $_POST['dept'];
        $data=$this->Staff_model->select_staff_byDept($dept);
        if(isset($data)){
            print '<div class="box-body">
            <div class="col-md-12">
            <div class="table-responsive">
            <table class="table table-bordered table-striped">
            <thead>
                  <tr>
                    <th>Staff</th>
                    <th>Basic Salary</th>
                    <th>Allowance</th>
                    <th>Total</th>
                  </tr>
                  </thead>
                  <tbody>';

            foreach($data as $d)
            {
                print '<tr>
                <td>'.$d["staff_name"].'</td>
                <td><input type="hidden" name="txtid[]" value="'.$d["id"].'">
                    <input type="text" name="txtbasic[]" class="form-control expenses">
                </td>
                <td><input type="text" name="txtallowance[]" class="form-control expenses"></td>
                <td><input type="text" id="total" name="txttotal[]" class="form-control"></td>
                </tr>';
            }
            print '</tbody>
            </table>
            </div>
            </div>
            </div>

            <div class="box-footer">
                <button type="submit" class="btn btn-info pull-right">Submit</button>
              </div>';
            // print '<div class="col-md-12">
            //       <div class="form-group">
            //         <label for="exampleInputPassword1">Department Name</label>
            //         <select class="form-control" name="slcdepartment" onchange="getstaff(this.value)">
            //           <option value="">Select</option>
                        
            //         </select>
            //       </div>
            //     </div>';
        }
        
        

    }



}
