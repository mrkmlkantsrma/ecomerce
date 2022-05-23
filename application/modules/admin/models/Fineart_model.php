<?php

class Fineart_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    
	
	public function getFineArt()
    {
        $result = $this->db->get('fine_art_products');
        return $result->result_array();
    }
	
	
	
	

    public function setFineArt($post, $id = 0)
    {
        
        
        $is_update = false;
        if ($id > 0) {
            $is_update = true;
            if (!$this->db->where('id', $id)->update('fine_art_products', array(
                        'image' 			=> $post['image'] != null ? $_POST['image'] : $_POST['old_image'],
						 'designer_id' 		=> $post['designer_id'],
						'type' 				=> $post['type'],
						'size' 				=> $post['size'],
						'stock_status' 		=> $post['stock_status'],
						'artist_information'=> $post['artist_information'],
						'position'			=> $post['position'],
						'title' 			=> $post['title']
                        
                    ))) {
                log_message('error', print_r($this->db->error(), true));
            }
        } else {
            
           
            if (!$this->db->insert('fine_art_products', array(
                        'image' 			=> $post['image'],
						 'designer_id' 		=> $post['designer_id'],
						'type' 				=> $post['type'],
						'size' 				=> $post['size'],
						'stock_status' 		=> $post['stock_status'],
						'artist_information'=> $post['artist_information'],
						'position'			=> $post['position'],
						'title' 			=> $post['title']
                        
                    ))) {
                log_message('error', print_r($this->db->error(), true));
            }
            $id = $this->db->insert_id();

            
        }
    }
	
	public function updateFineArt($post, $id)
    {
       if (!$this->db->where('id', $id)->update('fine_art_products', array(
						'image' 			=> $post['image'] != null ? $_POST['image'] : $_POST['old_image'],
                        'designer_id' 		=> $post['designer_id'],
						'type' 				=> $post['type'],
						'size' 				=> $post['size'],
						'stock_status' 		=> $post['stock_status'],
						'artist_information'=> $post['artist_information'],
						'position'			=> $post['position'],
						'title' 			=> $post['title']
		
		))) {
            log_message('error', print_r($this->db->error(), true));
            show_error(lang('database_error'));
        }
    }
	
	 public function getOneFineArt($id)
    {
        $this->db->select('*');
        $this->db->where('id', $id);
        $query = $this->db->get('fine_art_products');
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    public function deleteFineArt($id)
    {
        if (!$this->db->where('id', $id)->delete('fine_art_products')) {
            log_message('error', print_r($this->db->error(), true));
            show_error(lang('database_error'));
        }
    }

    public function getProductsOptions($main_cat_id, $sub_cat_id)
    {
        if($main_cat_id < 14){
            $this->db->select('id');
            $this->db->where_in('shop_categorie', $sub_cat_id);
            $result = $this->db->get('products');
            $forArray = $result->result_array();
            $ids = [];
            foreach($forArray as  $id){
                $ids[] = $id['id'];
            }
            $this->db->select('id, title');
            $this->db->where_in('for_id', $ids);
            $results = $this->db->get('products_translations');
            return $results->result_array();
        }
        
        if($main_cat_id > 14){
            $this->db->select('id');
            $this->db->where_in('shop_categorie', $sub_cat_id);
            $result = $this->db->get('products_lighting');
            $forArray = $result->result_array();
            $ids = [];
            foreach($forArray as  $id){
                $ids[] = $id['id'];
            }
            $this->db->select('id, title');
            $this->db->where_in('for_id', $ids);
            $results = $this->db->get('products_lighting_translations');
            return $results->result_array();
        }  

    }
    public function getcatForRelatedProduct($id){
        $this->db->select('shop_categorie');
        $this->db->where('id', $id);
        $result = $this->db->get('products');
        return $result->row_array();
}

    public function getEditRelProducts($id)
    {
        $this->db->select('*');
        $this->db->where('product_id', $id);
        $result = $this->db->get('related_product_new');
        return $result->result_array();
    }

    public function getSubCategories($main_cat_id)
    {
        
        $this->db->select('for_id, Name');
        $this->db->where_in('for_id', $main_cat_id);
        $results = $this->db->get('shop_categories_translations');
        return $results->result();
        
    }

    public function deleteRelatedProductByProductId($productId)
    {
        $query = $this->db->query("DELETE FROM related_product_new where product_id = $productId");
    }

    public function setRelatedProductsForProduct($post, $productId)
    { 
        if (!$this->db->insert('related_product_new', array(
		'category_id' => $post['main_category'],
		'sub_category_id' => $post['sub_category'],
		'product_id' => $productId,
        'related_product' => $post['relatedProductId'],
        'product_type' => $post['productType'],
		))) {
            log_message('error', print_r($this->db->error(), true));
            show_error(lang('database_error'));
        }
    }

    public function setCustomerRelatedProductsForProduct($post, $productId)
    { 
        if (!$this->db->insert('customer_related_product', array(
		'category_id' => $post['main_category'],
		'sub_category_id' => $post['sub_category'],
		'product_id' => $productId,
        'related_product' => $post['relatedProductId'],
        'product_type' => $post['productType'],
        'position' => $post['Related_position'],
		))) {
            log_message('error', print_r($this->db->error(), true));
            show_error(lang('database_error'));
        }
    }
    public function deleteCustomerRelatedProductByProductId($productId)
    {
        $query = $this->db->query("DELETE FROM customer_related_product where product_id = $productId");
    }

    // public function getCustomerRelProducts($id)
    // {
    //     $this->db->select('*');
    //     $this->db->where('product_id', $id);
    //     $result = $this->db->order_by('position', 'asc')->get('customer_related_product');
    //     return $result->result_array();
    // }
    public function getCustomerRelProducts($id)
    {
        $this->db->select('*');
        $this->db->where('product_id', $id);
        $result = $this->db->order_by('id', 'asc')->get('customer_related_product');
        return $result->result_array();
    }

}