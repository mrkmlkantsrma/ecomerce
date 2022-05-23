<?php

class Entries_model extends CI_Model
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
	
	public function getContactEntries()
    {
		 $this->db->where('entry_type', 'contact');
        $result = $this->db->get('contacts');
        return $result->result_array();
    }
	public function getInfoEntries()
    {
		 $this->db->where('entry_type', 'price_quote');
        $result = $this->db->get('contacts');
        return $result->result_array();
    }
    public function getMoreInfoEntries()
    {
		 $this->db->where('entry_type', 'more_info');
        $result = $this->db->get('contacts');
        return $result->result_array();
    }
    public function getTradeInfoEntries()
    {
        $result = $this->db->get('trade_contacts');
        return $result->result_array();
    }
    public function getMaterialInfoEntries()
    {
        $result = $this->db->get('orders_fur');
        return $result->result_array();
    }

    public function viewMaterial($id)
    {
        $this->db->select('*');
        $this->db->where('id', $id);
        $result = $this->db->get('orders_fur');
        return $result->row_array();
    }

    public function viewTrade($id)
    {
        $this->db->select('*');
        $this->db->where('id', $id);
        $result = $this->db->get('trade_contacts');
        return $result->row_array();
    }
	public function viewContact($id)
    {
        $this->db->select('*');
        $this->db->where('id', $id);
        $result = $this->db->get('contacts');
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

    public function deleteContact($id)
    {
        if (!$this->db->where('id', $id)->delete('contacts')) {
            log_message('error', print_r($this->db->error(), true));
            show_error(lang('database_error'));
        }
    }

    public function deleteMaterial($id)
    {
        if (!$this->db->where('id', $id)->delete('orders_fur')) {
            log_message('error', print_r($this->db->error(), true));
            show_error(lang('database_error'));
        }
    }

    public function deleteTrade($id)
    {
        if (!$this->db->where('id', $id)->delete('trade_contacts')) {
            log_message('error', print_r($this->db->error(), true));
            show_error(lang('database_error'));
        }
    }

    public function productInfo($id)
    {
        $this->db->select('*');
        $this->db->where('for_id', $id);
        $result = $this->db->get('products_lighting');
        return $result->row();
    }

    public function productfurInfo($id)
    {
        $this->db->select('*');
        $this->db->where('for_id', $id);
        $result = $this->db->get('products_translations');
        return $result->row();
    }

    public function productlightInfo($id)
    {
        $this->db->select('*');
        $this->db->where('for_id', $id);
        $result = $this->db->get('products_lighting_translations');
        return $result->row();
    }

    public function getFurOrders($pId)
    {   
        $this->db->select('*');
		$this->db->where('for_id', $pId);
        $result = $this->db->get('products_translations');
        return $result->row();
    }

    public function productfineInfo($id)
    {
        $this->db->select('*');
        $this->db->where('id', $id);
        $result = $this->db->get('fine_art_products');
        return $result->row();
    }

}
