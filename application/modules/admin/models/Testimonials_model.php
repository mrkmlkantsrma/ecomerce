<?php

class Testimonials_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    

    public function getTest()
    {
        $result = $this->db->get('testimonials');
        return $result->result_array();
    }
	
	public function getTestSingle($ctid)
    {
		$this->db->where('id', $ctid);
        $query = $this->db->get('testimonials');

            return $query->row_array();
    }

    public function setTestimonials($title)
    {
        if (!$this->db->insert('testimonials', array(
                        'image' => $post['image'],
                        'name' => $post['name'],
                        'location' => $post['location'],
						'excerpt' => $post['excerpt'],
                        'description' => $post['description']
                    ))) {
                log_message('error', print_r($this->db->error(), true));
            }
    }
	public function updateTestimonial($post, $id)
    {
       if (!$this->db->where('id', $id)->update('testimonials', array(
						'image' 				=> $post['image'] != null ? $_POST['image'] : $_POST['old_image'],
						 'name' => $post['name'],
                        'location' => $post['location'],
						'excerpt' => $post['excerpt'],
                        'description' => $post['description']
		
		))) {
            log_message('error', print_r($this->db->error(), true));
            show_error(lang('database_error'));
        }
    }
	
	 public function getOneTestimonial($id)
    {
        $this->db->select('*');
        $this->db->where('id', $id);
        $query = $this->db->get('testimonials');
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }


    public function deleteTest($id)
    {
        if (!$this->db->where('id', $id)->delete('testimonials')) {
            log_message('error', print_r($this->db->error(), true));
            show_error(lang('database_error'));
        }
    }
	
	public function getTestimonial()
    {
        $result = $this->db->get('testimonials');
        return $result->result_array();
    }
	
	
	

    public function setTestimonial($post, $id = 0)
    {
        
        
        $is_update = false;
        if ($id > 0) {
            $is_update = true;
            if (!$this->db->where('id', $id)->update('testimonials', array(
                        'image' => $post['image'] != null ? $_POST['image'] : $_POST['old_image'],
                        'location' => $post['location'],
                        'excerpt' => $post['excerpt'],
						 'description' => $post['description'],
                        'name' => $post['name']
                        
                    ))) {
                log_message('error', print_r($this->db->error(), true));
            }
        } else {
            
           
            if (!$this->db->insert('testimonials', array(
                       'image' => $post['image'] != null ? $_POST['image'] : $_POST['old_image'],
                        'location' => $post['location'],
                        'excerpt' => $post['excerpt'],
						'description' => $post['description'],
                        'name' => $post['name']
                        
                    ))) {
                log_message('error', print_r($this->db->error(), true));
            }
            $id = $this->db->insert_id();

            
        }
    }

    public function deleteMaterial($id)
    {
        if (!$this->db->where('id', $id)->delete('testimonials')) {
            log_message('error', print_r($this->db->error(), true));
            show_error(lang('database_error'));
        }
    }

}
