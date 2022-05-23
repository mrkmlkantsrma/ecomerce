<?php

class Designer_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    
	
	public function getDesigner()
    {
        $result = $this->db->get('designers');
        return $result->result_array();
    }
	
	
	
	

    public function setDesigner($post, $id = 0)
    {
        
        
        $is_update = false;
        if ($id > 0) {
            $is_update = true;
            if (!$this->db->where('id', $id)->update('designers', array(
                        'image' 				=> $post['image'] != null ? $_POST['image'] : $_POST['old_image'],
						 'image1' 				=> $post['image1'] != null ? $_POST['image1'] : $_POST['old_image1'],
						'designer_information'	=> $post['designer_information'],
						'position'				=> $post['position'],
						'title' 				=> $post['title']
                        
                    ))) {
                log_message('error', print_r($this->db->error(), true));
            }
        } else {
            
           
            if (!$this->db->insert('designers', array(
                       'image' 				=> $post['image'],
					    'image1' 				=> $post['image1'],
						'designer_information'	=> $post['designer_information'],
						'position'				=> $post['position'],
						'title' 				=> $post['title']
                        
                    ))) {
                log_message('error', print_r($this->db->error(), true));
            }
            $id = $this->db->insert_id();

            
        }
    }
	
	public function updateDesigner($post, $id)
    {
       if (!$this->db->where('id', $id)->update('designers', array(
						'image' 				=> $post['image'] != null ? $_POST['image'] : $_POST['old_image'],
						'image1' 				=> $post['image1'] != null ? $_POST['image1'] : $_POST['old_image1'],
						'designer_information'	=> $post['designer_information'],
						'position'				=> $post['position'],
						'title' 				=> $post['title']
		
		))) {
            log_message('error', print_r($this->db->error(), true));
            show_error(lang('database_error'));
        }
    }
	
	 public function getOneDesigner($id)
    {
        $this->db->select('*');
        $this->db->where('id', $id);
        $query = $this->db->get('designers');
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    public function deleteDesigner($id)
    {
        if (!$this->db->where('id', $id)->delete('designers')) {
            log_message('error', print_r($this->db->error(), true));
            show_error(lang('database_error'));
        }
    }

}