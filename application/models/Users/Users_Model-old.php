<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Users_Model extends CI_Model{
    
    public function __construct()
    {
		parent::__construct();
		$this->load->database();
	}

    public function RegisterUsers($data)
    {   
         $this->db->insert(' user', $data);
        // $this->db->query("insert into product(file,product_name,product_desc) values('$file_name','$product_name','$product_desc')");
        // $this->db->query("insert into product(file,product_name,product_desc) values('$file','$product_name','$product_desc',)");
    }
    public function mail_exists($data)
    {
        $this->db->where('email',$data);
        $query = $this->db->get('user');
        if ($query->num_rows() > 0){
            return true;
        }
        else{
            return false;
        }
    }
     public function username_exists($data)
    {
        $this->db->where('username',$data);
        $query = $this->db->get('user');
        if ($query->num_rows() > 0){
            return true;
        }
        else{
            return false;
        }
    }
     public function loginUsers($data) {        
        $this->db->select('*');
        $this->db->from('user');
        //$this->db->where($condition);
        $this->db->group_start();
        $this->db->where('username', $data['username'])->or_where('email', $data['username']);
        $this->db->group_end();
        $this->db->where('password', $data['password']);
        $this->db->limit(1);
        $query = $this->db->get();
        $this->db->last_query();
        //
        if ($query->num_rows() > 0) {
            return $query->result();
            // print_r($query);
            return true;
        } else {
            return false;
        }
    }
    
    // Read data from database to show data in admin page
    public function read_user_information($username) {
    
        $condition = "username =" . "'" . $username . "'";
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where($condition);
        $this->db->limit(1);
        $query = $this->db->get();
        
        if ($query->num_rows() == 1) {
        return $query->result();
        } else {
        return false;
        }
    }
    
    
}
