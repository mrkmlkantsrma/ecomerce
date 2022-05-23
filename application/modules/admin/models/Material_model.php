<?php

class Material_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getMtc()
    {
        $result = $this->db->get('material_design_category');
        return $result->result_array();
    }
	
	public function getMtcSingle($ctid)
    {
		$this->db->where('id', $ctid);
        $query = $this->db->get('material_design_category');

            return $query->row_array();
    }

    public function setMtc($title)
    {
        if (!$this->db->insert('material_design_category', array('title' => $title))) {
            log_message('error', print_r($this->db->error(), true));
            show_error(lang('database_error'));
        }
    }

    public function deleteMtc($id)
    {
        if (!$this->db->where('id', $id)->delete('material_design_category')) {
            log_message('error', print_r($this->db->error(), true));
            show_error(lang('database_error'));
        }
    }
	
	public function getMaterial()
    {
        $result = $this->db->get('material_design_products');
        return $result->result_array();
    }

    public function getsingleMaterial($mid)
    {
        $this->db->where('id', $mid);
        $result = $this->db->get('material_design_products');
        return $result->result_array();
    }
	
	
	

    public function setMaterial($post, $id = 0)
    {
        
        
        $is_update = false;
        if ($id > 0) {
            $is_update = true;
            if (!$this->db->where('id', $id)->update('material_design_products', array(
                        'image' => $post['image'] != null ? $_POST['image'] : $_POST['old_image'],
                        'm_cat_id' => $post['m_cat_id'],
                        'title' => $post['title']
                        
                    ))) {
                log_message('error', print_r($this->db->error(), true));
            }
        } else {
            
           
            if (!$this->db->insert('material_design_products', array(
                        'image' => $post['image'],
                        'm_cat_id' => $post['m_cat_id'],
                        'title' => $post['title']
                        
                    ))) {
                log_message('error', print_r($this->db->error(), true));
            }
            $id = $this->db->insert_id();

            
        }
    }

    public function deleteMaterial($id)
    {
        if (!$this->db->where('id', $id)->delete('material_design_products')) {
            log_message('error', print_r($this->db->error(), true));
            show_error(lang('database_error'));
        }
    }

}