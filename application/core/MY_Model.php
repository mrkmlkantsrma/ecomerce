<?php

class MY_Model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	    $this->load->library('session');
	}

	public function add($table, $data){
		if ( empty( $table ) || empty( $data ) ) {
			return false;
		}
		$this->db->insert($table, $data);
		if ( $this->db->insert_id() > 0 ) {
			return $this->db->insert_id();
		}
		else{
			return false;
		}

	}
	
	public function get_Details($table)
	{
	    if(empty($table))
	    {
	        return false;
	    }
	    return $this->db->get($table)->result_array();
	}
	
	public function delete($table, $id){
	    if(empty($table) || empty($id))
	    {
	        return false;
	    }
	    $this->db->select('*');
	    $this->db->where($id);
	    $this->db->delete($table);
	}
	
	public function column_Exist($column, $table , $data)
	{
	    if(empty( $column ) || empty( $table ) || empty($data) )
	    {
	        return false;
	    }
	    $this->db->where($column, $data);
	    $query = $this->db->get($table);
	    if ($query->num_rows() > 0){
    	    return true;
    	}
    	else{
        	return false;
    	}
	}
	
	public function check_Login_User($table, $email,  $password, $data)
    {
        if(empty($table) || empty($email) || empty($password) || empty($data))
        {
            return false;
        }
  
        $this->db->select('*');
        $this->db->from($table);
        $this->db->group_start();
       // $this->db->where($email, $data[$email])->or_where($email, $data[$email]);
        $this->db->where($email, $data[$email]);
        $this->db->group_end();
        $this->db->where($password, $data[$password]);
        $this->db->limit(1);
        $query = $this->db->get();
        $this->db->last_query();

        if ($query->num_rows() > 0) {
            return $query->result();
            return true;
        } else {
            return false;
        }
    }
	
	// Second way to perform this 
	
	public function login_User_Data($table, $email, $username, $password, $data)
    {
        if(empty($table) || empty($username) || empty($password) || empty($data))
        {
            return false;
        }
        $this->db->select(''.
            $username.','.
            $password.'')
          ->from($table)
          ->where("($username  = '".$data[$username]."' and $password = '".$data[$password]."')")->or_where($email, $data[$username]);
          $query = $this->db->get();
          if ($query->num_rows() > 0){
            return $query->result();    
            return true;
           } 
           else{
              return false;
           }
    }
	
	public function read_User_Information_For_Session($column_Name, $table, $data) {

        $condition = "".$column_Name." =" . "'" . $data . "'";
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($condition);
        $this->db->limit(1);
        $query = $this->db->get();
        
        if ($query->num_rows() == 1) {
        return $query->result();
        } 
        else 
        {
        return false;
        }
    }

/*		public function getRow($table,$where){
		$data = $this->db->get_where($table,$where);
		return $data->row_array();
	}

	//get activities from get_activites_log
	function getActivity($module,$module_id)
	{
        $this->db->select('activity.*, user.username, user.id as user_id');
		$this->db->from('ace_activity_log activity');
		$this->db->join('users user', 'user.id = activity.modified_by');
		$this->db->where('activity.module', $module);
        $this->db->where('activity.module_id', $module_id);
        $this->db->order_by('activity.activity_id', 'DESC');
        $result = $this->db->get();

    	//echo $this->ci->db->last_query(); echo '<br>';die();
		return $result->result();
	}

	// get single activity log
	public function getLog($id){
		$data = $this->db->get_where('ace_activity_log',array( 'activity_id' => $id ));
		return $data->row_array();
	} */
}
?>