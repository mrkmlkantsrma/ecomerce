<?php

class DefaultRelatedProducts_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getRelatedproducts()
    {
        $result = $this->db->get('defaultRelated_products');
        return $result->result_array();
    }

    public function getCategoryRelatedproducts()
    {
        $query = $this->db->query('SELECT * FROM related_product_new WHERE sub_category_id IS NULL');
        $result = $query->result_array();      
        return $result;
    }

	public function getProductsAll()
    {
        $firstResult = $this->db->get('products_lighting');
        $secondResult = $this->db->get('products');
        $result = $firstResult;
        $result = $secondResult;
        return $result->result_array();
    }

    public function getFurLightProductsTitle()
    {
        $firstResult = $this->db->get('products_lighting_translations');
        $secondResult = $this->db->get('products_translations');
        $result = $firstResult;
        $result = $secondResult;
        return $result->result_array();
        //echo '<pre>'; print_r($result->result_array()); echo '<pre>'; die;
    }

	public function getProCategory($cat_id)
    {
        $this->db->select('name');
        $this->db->where('for_id', $cat_id);
        $result = $this->db->get('shop_categories_translations');
        return $result->row_array();
    }

    public function getSubCategories($main_cat_id)
    {

        if($main_cat_id == 7){
            $this->db->select('id');
            $this->db->where('sub_for', $main_cat_id);
            $result = $this->db->get('shop_categories');
            $forArray = $result->result_array();
            $ids = [];
            foreach($forArray as  $id){
                $ids[] = $id['id'];
            }
            $this->db->select('for_id, Name');
            $this->db->where_in('for_id', $ids);
            $results = $this->db->get('shop_categories_translations');
            return $results->result();
        }

        if($main_cat_id == 15){
            $this->db->select('id');
            $this->db->where('sub_for', $main_cat_id);
            $result = $this->db->get('shop_categories');
            $forArray = $result->result_array();
            $ids = [];
            foreach($forArray as  $id){
                $ids[] = $id['id'];
            }
            $this->db->select('for_id, Name');
            $this->db->where_in('for_id', $ids);
            $results = $this->db->get('shop_categories_translations');
            return $results->result();
        }  
        if($main_cat_id == 51){
            $this->db->select('for_id, Name');
            $this->db->where_in('for_id', $main_cat_id);
            $results = $this->db->get('shop_categories_translations');
            return $results->result();
        }
    }

    public function getProductsOptions($main_cat_id)
    {
        if($main_cat_id <= 14){
            $this->db->select('id');
            $result = $this->db->get('products');
            $forArray = $result->result_array();
            $ids = [];
            foreach($forArray as  $id){
                $ids[] = $id['id'];
            }
            $this->db->select('for_id, title');
            $this->db->where_in('for_id', $ids);
            $results = $this->db->get('products_translations');
            return $results->result_array();
        }
        
        if($main_cat_id >= 15){
            $this->db->select('id');
            $result = $this->db->get('products_lighting');
            $forArray = $result->result_array();
            $ids = [];
            foreach($forArray as  $id){
                $ids[] = $id['id'];
            }
            $this->db->select('for_id, title');
            $this->db->where_in('for_id', $ids);
            $results = $this->db->get('products_lighting_translations');
            return $results->result_array();
        }  

    }

    public function setCategoryRelatedRelProducts($post)
    { 
        if (!$this->db->insert('related_product_new', array(
		'category_id' => $post['main_category'],
        'related_product' =>$post['relatedProductId'],
        'product_type' => $post['productType'],
		))) {
            log_message('error', print_r($this->db->error(), true));
            show_error(lang('database_error'));
        }
    }

    public function deleteCategoryRelatedProducts($categoryId)
    {
        $query = $this->db->query("DELETE FROM related_product_new where category_id = $categoryId and sub_category_id IS NULL ");
    }
}
