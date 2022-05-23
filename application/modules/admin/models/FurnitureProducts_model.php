<?php

class FurnitureProducts_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function deleteProduct($id)
    {
        $this->db->trans_begin();
        $this->db->where('for_id', $id);
        if (!$this->db->delete('products_translations')) {
            log_message('error', print_r($this->db->error(), true));
        }
        $this->db->where('id', $id);
        if (!$this->db->delete('products')) {
            log_message('error', print_r($this->db->error(), true));
        }
        $this->db->where('product_id', $id);
        if (!$this->db->delete('product_shop_Categories')) {
            log_message('error', print_r($this->db->error(), true));
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            show_error(lang('database_error'));
        } else {
            $this->db->trans_commit();
        }
    }
   

    public function productsCount($search_title = null, $category = null)
    {
        if ($search_title != null) {
            $search_title = trim($this->db->escape_like_str($search_title));
            $this->db->where("(products_translations.title LIKE '%$search_title%')");
        }
        if ($category != null) {
            $this->db->where('shop_categorie', $category);
        }
        $this->db->join('products_translations', 'products_translations.for_id = products.id', 'left');
        $this->db->where('products_translations.abbr', MY_DEFAULT_LANGUAGE_ABBR);
        return $this->db->count_all_results('products');
    }

    public function getProducts($limit, $page, $search_title = null, $orderby = null, $category = null, $brand = null, $designer=null)
    {
        if ($search_title != null) {
            $search_title = trim($this->db->escape_like_str($search_title));
            $this->db->where("(products_translations.title LIKE '%$search_title%')");
        }
        if ($orderby !== null) {
            $ord = explode('=', $orderby);
            if (isset($ord[0]) && isset($ord[1])) {
                $this->db->order_by('products.' . $ord[0], $ord[1]);
            }
        } else {
            $this->db->order_by('products.position', 'asc');
        }
        if ($category != null) {
            $this->db->where('shop_categorie', $category);
        }
        if ($brand != null) {
            $this->db->where('brand_id', $brand);
        }
		if ($brand != null) {
            $this->db->where('designer_id', $designer);
        }
        $this->db->join('brands', 'brands.id = products.brand_id', 'left');
		$this->db->join('designers', 'designers.id = products.designer_id', 'left');
		$this->db->join('shop_categories_translations', 'shop_categories_translations.for_id = products.shop_categorie', 'left');
        $this->db->join('products_translations', 'products_translations.for_id = products.id', 'left');
        $this->db->where('products_translations.abbr', MY_DEFAULT_LANGUAGE_ABBR);
        $query = $this->db->select('brands.name as brand_name, brands.id as brand_id, designers.title as designer_name, designers.id as designer_id, shop_categories_translations.name as cat_name, shop_categories_translations.for_id as cat_id,  products.*, products_translations.title, products_translations.description, products_translations.price, products_translations.old_price, products_translations.abbr, products.url, products_translations.for_id, products_translations.basic_description')->get('products', $limit, $page);
        return $query->result();
    }

    public function numShopProducts()
    {
        return $this->db->count_all_results('products');
    }

    public function getOneProduct($id)
    {
        $this->db->select('brands.name as brand_name, brands.id as brand_id, products.*, products_translations.price, products_translations.designer_name');
        $this->db->where('products.id', $id);
        $this->db->join('brands', 'brands.id = products.brand_id', 'left');
        $this->db->join('products_translations', 'products_translations.for_id = products.id', 'inner');
        $this->db->where('products_translations.abbr', MY_DEFAULT_LANGUAGE_ABBR);
        $query = $this->db->get('products');
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    public function productStatusChange($id, $to_status)
    {
        $this->db->where('id', $id);
        $result = $this->db->update('products', array('visibility' => $to_status));
        return $result;
    }
    
    // public function getMcat($productId,$mCatId){ 
    //     $array = array('product_id' => $productId, 'm_cat_id' => $mCatId);
    //     $this->db->where($array); 
    //     $result = $this->db->get('product_material_cat');
    //     return $result->result_array(); 
    // }
    public function setProduct($post, $id = 0)
    {
        if (!isset($post['brand_id'])) {
            $post['brand_id'] = null;
        }
        if (!isset($post['virtual_products'])) {
            $post['virtual_products'] = null;
        }
        $this->db->trans_begin();
        $is_update = false;
        if ($id > 0) {
            $is_update = true;
            if (!$this->db->where('id', $id)->update('products', array(
                        'image' => $post['image'] != null ? $_POST['image'] : $_POST['old_image'],
						// 'shop_categorie' => $post['sub_category'],
						'shop_categorie' => '0',
                        'quantity' => $post['quantity'],
                        // 'position' => $post['position'],
                        'brand_position' => $post['Brand_position'],
                        'position' => '0',
                        'virtual_products' => $post['virtual_products'],
                        'brand_id' => $post['brand_id'],
						'designer_id' => $post['designer_id'],
                        'time_update' => time()
                    ))) {
                log_message('error', print_r($this->db->error(), true));
            }
            // $Mcat = $this->getMcat();
            // if(empty($Mcat)){
                if($_POST['mat']!=""){
                    for($i=0;$i<count($_POST['mat']);$i++){
                        $mat = $_POST['mat'][$i];
                        $CatProdID = $this->getFurtMatCat($id,$mat);
                        // echo '<pre>';
                        // print_r($CatProdID);
                        // echo '</pre>';
                        // die('sss');
                        if(empty($CatProdID)){
                            if (!$this->db->insert('product_material_cat', array(
                                        'product_id' =>  $id,
                                        'm_cat_id' => $mat
                                    ))) {
                                log_message('error', print_r($this->db->error(), true));
                            }
                        }    
                    }
                }
            // }
        } 
        else 
        {
            /*
             * Lets get what is default tranlsation number
             * in titles and convert it to url
             * We want our plaform public ulrs to be in default 
             * language that we use
             */
            $i = 0;
            foreach ($_POST['translations'] as $translation) {
                if ($translation == MY_DEFAULT_LANGUAGE_ABBR) {
                    $myTranslationNum = $i;
                }
                $i++;
            }
            if (!$this->db->insert('products', array(
                        'image' => $post['image'],
                        // 'shop_categorie' => $post['sub_category'],
                        'shop_categorie' => '0',
                        'quantity' => $post['quantity'],
                        // 'position' => $post['position'],
                        'brand_position' => $post['Brand_position'],
                        'position' => '0',
                        'virtual_products' => $post['virtual_products'],
                        'folder' => $post['folder'],
                        'brand_id' => $post['brand_id'],
						'designer_id' => $post['designer_id'],
                        'time' => time()
                    ))) {
                log_message('error', print_r($this->db->error(), true));
            }
            $id = $this->db->insert_id();
				if($_POST['mat']!=""){
					for($i=0;$i<count($_POST['mat']);$i++){
							$mat = $_POST['mat'][$i];
						
					 if (!$this->db->insert('product_material_cat', array(
								'product_id' =>  $id,
								'm_cat_id' => $mat
							))) {
						log_message('error', print_r($this->db->error(), true));
					}
				}
			}

            $this->db->where('id', $id);
            if (!$this->db->update('products', array(
                        'url' => except_letters($_POST['title'][$myTranslationNum]) . '_' . $id
                    ))) {
                log_message('error', print_r($this->db->error(), true));
            }

        }
        // Gallery Images
        if( isset( $post['gallery_images'] ) ){      
            $galleryImg = json_decode($post['gallery_images'], true);
                foreach($galleryImg as  $img){              
                    if (!$this->db->insert('product_gallery', array(
                        'product_id' =>   $id,                
                        // 'shop_category' => $post['sub_category'],
                        'shop_category' => '0',
                        'gallery_type'  => 'Furniture',
                        'image_name' => $img,
                        'time_update' => time()
                    ))) {
                        log_message('error', print_r($this->db->error(), true));
                    }
                }
            }
            $this->setProductTranslation($post, $id, $is_update);
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                show_error(lang('database_error'));
            } else {
                $this->db->trans_commit();
            }
            return $id;
        }
        // End

    private function setProductTranslation($post, $id, $is_update)
    {
        $i = 0;
        $current_trans = $this->getTranslations($id);
        foreach ($post['translations'] as $abbr) {
            $arr = array();
            $emergency_insert = false;
            if (!isset($current_trans[$abbr])) {
                $emergency_insert = true;
            }
            $post['title'][$i] = str_replace('"', "'", $post['title'][$i]);
            $post['price'][$i] = str_replace(' ', '', $post['price'][$i]);
            $post['price'][$i] = str_replace(',', '.', $post['price'][$i]);
            $post['price'][$i] = preg_replace("/[^0-9,.]/", "", $post['price'][$i]);
            $post['old_price'][$i] = str_replace(' ', '', $post['old_price'][$i]);
            $post['old_price'][$i] = str_replace(',', '.', $post['old_price'][$i]);
            $post['old_price'][$i] = preg_replace("/[^0-9,.]/", "", $post['old_price'][$i]);
            $arr = array(
                'title' => $post['title'][$i],
                'basic_description' => 'basic_description',
                'description' => $post['description'][$i],
                'price' => $post['price'][$i],
                'old_price' => $post['old_price'][$i],
                'abbr' => $abbr,
                'for_id' => $id
            );
            if ($is_update === true && $emergency_insert === false) {
                $abbr = $arr['abbr'];
                unset($arr['for_id'], $arr['abbr'], $arr['url']);
                if (!$this->db->where('abbr', $abbr)->where('for_id', $id)->update('products_translations', $arr)) {
                    log_message('error', print_r($this->db->error(), true));
                }
            } else {
                if (!$this->db->insert('products_translations', $arr)) {
                    log_message('error', print_r($this->db->error(), true));
                }
            }
            $i++;
        }
    }

    public function getTranslations($id)
    {
        $this->db->where('for_id', $id);
        $query = $this->db->get('products_translations');
        $arr = array();
        foreach ($query->result() as $row) {
            $arr[$row->abbr]['title'] = $row->title;
            $arr[$row->abbr]['basic_description'] = $row->basic_description;
            $arr[$row->abbr]['description'] = $row->description;
            $arr[$row->abbr]['price'] = $row->price;
            $arr[$row->abbr]['old_price'] = $row->old_price;
        }
        return $arr;
    }
	
	public function getmatcat($id)
    {
        $this->db->select('*');
        $this->db->where('product_id', $id);
        $result = $this->db->get('product_material_cat');
        return $result->result_array();
    }
    
    public function getllgridcat($mt_id12)	{
	    $this->db->select('*');
        $this->db->where('id!=', $mt_id12);
        $result = $this->db->get('material_design_category');
        return $result->result_array();
    }
	
	public function getgridcat($mt_id)
    {
        $this->db->select('*');
        $this->db->where('id', $mt_id);
        $result = $this->db->get('material_design_category');
        return $result->row_array();
    }
	function row_delete($product_id)
	{
	   $this->db->where('product_id', $product_id);
	   $this->db->delete('product_material_cat'); 
	}
	public function getDesigners()
    {
        $this->db->select('*');
		$this->db->order_by('position', 'asc');
        $result = $this->db->get('designers');
        return $result->result_array();
    }
    public function getProductImgs($productID)
    {
        $this->db->select('*');
        $this->db->where(['product_id' => $productID, 'gallery_type' => 'Furniture']);
        $this->db->order_by("order_by asc");
        $result = $this->db->get('product_gallery');
        return $result->result();
    }

    public function deleteMCatId($productId,$mCatId)
    { 
        $whereClause = array('product_id' => $productId, 'm_cat_id' => $mCatId);
        $this->db->where($whereClause); 
	    $this->db->delete('product_material_cat'); 
	}

    public function getFurtMatCat($productID,$m_cat_id)
    {
        $this->db->where(['product_id' => $productID, 'm_cat_id' => $m_cat_id]);
        $result = $this->db->get('product_material_cat');
        return $result->result();
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
    }
    public function getcatForRelatedProduct($id){
            $this->db->select('shop_categorie');
            $this->db->where('id', $id);
            $result = $this->db->get('products');
            return $result->row_array();
    }

    public function getProductsOptions($main_cat_id, $sub_cat_id)
    {
        if($main_cat_id < 14){
            $this->db->select('id');
            //$this->db->where_in('shop_categorie', $sub_cat_id);
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
        
        if($main_cat_id > 14){
            $this->db->select('id');
            //$this->db->where_in('shop_categorie', $sub_cat_id);
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

    public function getEditRelProducts($id)
    {
        $this->db->select('*');
        $this->db->where('product_id', $id);
        $result = $this->db->get('related_product_new');
        return $result->result_array();
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
		'category_id' => '7',
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

    public function getAllSubCategories()
    {

        $query = $this->db->query("SELECT id FROM shop_categories where sub_for != '0' ");  
        $forArray = $query->result_array();
        $ids = [];
        foreach($forArray as  $id){
            $ids[] = $id['id'];
        }
        $this->db->select('for_id, Name');
        $this->db->where_in('for_id', $ids);
        $results = $this->db->get('shop_categories_translations');
        return $results->result();
    }
    
    public function setMultipleShopCategories($post, $productId)
    { 
        if (!$this->db->insert('product_shop_Categories', array(
		'product_id' => $productId,
        'shop_categories_id' => $post['CategoryId'],
        'position' => $post['Category_position'],
        'product_type' => 'FURNITURE',
		))) {
            log_message('error', print_r($this->db->error(), true));
            show_error(lang('database_error'));
        }
    }

    public function getMultipleShopCategories($id)
    {
        $this->db->select('*');
        $this->db->where('product_id', $id);
        $this->db->where('product_type', 'FURNITURE');
        $result = $this->db->order_by('id', 'asc')->get('product_shop_Categories');
        return $result->result_array();
    }

    public function deletesMultipleSelectCatID($productId)
    {
        $query = $this->db->query("DELETE FROM product_shop_Categories where product_id = $productId  AND product_type = 'FURNITURE'");
    }
}
