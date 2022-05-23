<?php

class Brands_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getBrands()
    {
        $result = $this->db->get('brands');
        return $result->result_array();
    }
	
	public function getAllBrands()
    {
		$this->db->order_by('page_position', 'ASC');
        $result = $this->db->get('brands');
        return $result->result_array();
    }
	public function getBrands1()
    {
		$this->db->order_by('position', 'ASC');
		$this->db->limit(6);
        $result = $this->db->get('brands');
        return $result->result_array();
    }
	public function getbrand($id)
    {
        $this->db->select('*');
        $this->db->where('id', $id);
        $result = $this->db->get('brands');
        return $result->row_array();
    }

    public function setBrand($post)
    {
        if (!$this->db->insert('brands', array(
		'name' => $post['name'],
		'image1' => $post['image1'],
		'image2' => $post['image2'],
		'position' => $post['position'],
		'type' => $post['type'],
		
		))) {
            log_message('error', print_r($this->db->error(), true));
            show_error(lang('database_error'));
        }
    }
	
	public function updateBrand($post, $id)
    {
       if (!$this->db->where('id', $id)->update('brands', array(
		'name' => $post['name'],
		'image1' => $post['image1'] != null ? $_POST['image1'] : $_POST['old_image1'],
		'image2' => $post['image2'] != null ? $_POST['image2'] : $_POST['old_image2'],
		'position' => $post['position'],
		'type' => $post['type'],
		
		))) {
            log_message('error', print_r($this->db->error(), true));
            show_error(lang('database_error'));
        }
    }

    public function deleteBrand($id)
    {
        if (!$this->db->where('id', $id)->delete('brands')) {
            log_message('error', print_r($this->db->error(), true));
            show_error(lang('database_error'));
        }
    }

}
