<?php

class LightingProducts_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function deleteProduct($id)
    {
        $this->db->trans_begin();
        $this->db->where('for_id', $id);
        if (!$this->db->delete('products_lighting_translations')) {
            log_message('error', print_r($this->db->error(), true));
        }

        $this->db->where('id', $id);
        if (!$this->db->delete('products_lighting')) {
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
            $this->db->where("(products_lighting_translations.title LIKE '%$search_title%')");
        }
        if ($category != null) {
            $this->db->where('shop_categorie', $category);
        }
        $this->db->join('products_lighting_translations', 'products_lighting_translations.for_id = products_lighting.id', 'left');
        $this->db->where('products_lighting_translations.abbr', MY_DEFAULT_LANGUAGE_ABBR);
        return $this->db->count_all_results('products_lighting');
    }

    public function getProducts($limit, $page, $search_title = null, $orderby = null, $category = null, $brand = null, $designer=null)
    {
        if ($search_title != null) {
            $search_title = trim($this->db->escape_like_str($search_title));
            $this->db->where("(products_lighting_translations.title LIKE '%$search_title%')");
        }
        if ($orderby !== null) {
            $ord = explode('=', $orderby);
            if (isset($ord[0]) && isset($ord[1])) {
                $this->db->order_by('products_lighting.' . $ord[0], $ord[1]);
            }
        } else {
            $this->db->order_by('products_lighting.position', 'asc');
        }
        if ($category != null) {
            $this->db->where('shop_categories', $category);
        }
        if ($brand != null) {
            $this->db->where('brand_id', $brand);
        }
		if ($brand != null) {
            $this->db->where('designer_id', $designer);
        }
        $this->db->join('brands', 'brands.id = products_lighting.brand_id', 'left');
		$this->db->join('designers', 'designers.id = products_lighting.designer_id', 'left');
		$this->db->join('shop_categories_translations', 'shop_categories_translations.for_id = products_lighting.shop_categorie', 'left');
        $this->db->join('products_lighting_translations', 'products_lighting_translations.for_id = products_lighting.id', 'left');
        $this->db->where('products_lighting_translations.abbr', MY_DEFAULT_LANGUAGE_ABBR);
        $query = $this->db->select('brands.name as brand_name, brands.id as brand_id, designers.title as designer_name, designers.id as designer_id, shop_categories_translations.name as cat_name, shop_categories_translations.for_id as cat_id, products_lighting.*, products_lighting_translations.title, products_lighting_translations.description, products_lighting_translations.price, products_lighting_translations.old_price, products_lighting_translations.abbr, products_lighting.url, products_lighting_translations.for_id, products_lighting_translations.basic_description')->get('products_lighting', $limit, $page);
        return $query->result();
    }

    public function numShopProducts()
    {
        return $this->db->count_all_results('products_lighting');
    }

    public function getOneProduct($id)
    {
        $this->db->select('brands.name as brand_name, brands.id as brand_id, designers.title as designer_name, designers.id as designer_id,  products_lighting.*, products_lighting_translations.price');
        $this->db->where('products_lighting.id', $id);
        $this->db->join('brands', 'brands.id = products_lighting.brand_id', 'left');
		$this->db->join('designers', 'designers.id = products_lighting.designer_id', 'left');
        $this->db->join('products_lighting_translations', 'products_lighting_translations.for_id = products_lighting.id', 'inner');
        $this->db->where('products_lighting_translations.abbr', MY_DEFAULT_LANGUAGE_ABBR);
        $query = $this->db->get('products_lighting');
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    public function productStatusChange($id, $to_status)
    {
        $this->db->where('id', $id);
        $result = $this->db->update('products_lighting', array('visibility' => $to_status));
        return $result;
    }

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
            if (!$this->db->where('id', $id)->update('products_lighting', array(
                        'image' => $post['image'] != null ? $_POST['image'] : $_POST['old_image'],
                        'rollover_image1' => $post['rollover1'] != null ? $_POST['rollover1'] : $_POST['old_rollover_image1'],
						'rollover_image2' => $post['rollover2'] != null ? $_POST['rollover2'] : $_POST['old_rollover_image2'],
						'rollover_image3' => $post['rollover3'] != null ? $_POST['rollover3'] : $_POST['old_rollover_image3'],
						'rollover_image4' => $post['rollover4'] != null ? $_POST['rollover4'] : $_POST['old_rollover_image4'],
						'rollover_image5' => $post['rollover5'] != null ? $_POST['rollover5'] : $_POST['old_rollover_image5'],
						'rollover_image6' => $post['rollover6'] != null ? $_POST['rollover6'] : $_POST['old_rollover_image6'],
						'shop_categorie' => $post['shop_categorie'],
                        'quantity' => $post['quantity'],
                        'position' => $post['position'],
                        'virtual_products' => $post['virtual_products'],
                        'brand_id' => $post['brand_id'],
						'designer_id' => $post['designer_id'],
						'design_option' => $post['design_option'],
						'color_option' => $post['color_option'],
                        'time_update' => time()
                    ))) {
                log_message('error', print_r($this->db->error(), true));
            }  
			if($post['design']!=""  && $post['price_design']!=""){
				for($i=0;$i<count($_POST['design']);$i++){
						$design = $_POST['design'][$i];
						$price = $_POST['price_design'][$i];
					
					 if (!$this->db->insert('lighting_design_options', array(
								'product_id' =>  $id,
								'design' =>  $design,
								'price' => $price
							))) {
						log_message('error', print_r($this->db->error(), true));
					}
				}	
			}
			
			
			if($post['color']!="" && $post['price_color']!=""){
				for($c=0;$c<count($_POST['color']);$c++){
						$design1 = $_POST['color'][$c];
						$price1 = $_POST['price_color'][$c];
					
					 if (!$this->db->insert('lighting_color_options', array(
								'product_id' =>  $id,
								'color' =>  $design1,
								'price' => $price1
							))) {
						log_message('error', print_r($this->db->error(), true));
					}
				}
			}

			
        } else {
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
            if (!$this->db->insert('products_lighting', array(
                        'image' => $post['image'],
						'rollover_image1' => $post['rollover1'],
						'rollover_image1' => $post['rollover2'],
						'rollover_image3' => $post['rollover3'],
						'rollover_image4' => $post['rollover4'],
						'rollover_image5' => $post['rollover5'],
						'rollover_image6' => $post['rollover6'],
                        'shop_categorie' => $post['shop_categorie'],
                        'quantity' => $post['quantity'],
                        'position' => $post['position'],
                        'virtual_products' => $post['virtual_products'],
                        'folder' => $post['folder'],
                        'brand_id' => $post['brand_id'],
						'designer_id' => $post['designer_id'],
						'design_option' => $post['design_option'],
						'color_option' => $post['color_option'],
                        'time' => time()
                    ))) {
                log_message('error', print_r($this->db->error(), true));
            }
            $id = $this->db->insert_id();
			for($i=0;$i<count($_POST['design']);$i++){
					$design = $_POST['design'][$i];
					$price = $_POST['price_design'][$i];
				
			 if (!$this->db->insert('lighting_design_options', array(
                        'product_id' =>  $id,
						'design' =>  $design,
						'price' => $price
                    ))) {
                log_message('error', print_r($this->db->error(), true));
            }
			}
			
			
			if($post['color_option']==1){
				for($c=0; $c<count($_POST['color']); $c++){
						$design1 = $_POST['color'][$c];
						$price1 = $_POST['price_color'][$c];
					
					 if (!$this->db->insert('lighting_color_options', array(
								'product_id' =>  $id,
								'color' =>  $design1,
								'price' => $price1
							))) {
						log_message('error', print_r($this->db->error(), true));
					}
				}
			}

            $this->db->where('id', $id);
            if (!$this->db->update('products_lighting', array(
                        'url' => except_letters($_POST['title'][$myTranslationNum]) . '_' . $id
                    ))) {
                log_message('error', print_r($this->db->error(), true));
            }
        }
        $this->setProductTranslation($post, $id, $is_update);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            show_error(lang('database_error'));
        } else {
            $this->db->trans_commit();
        }
    }

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
                if (!$this->db->where('abbr', $abbr)->where('for_id', $id)->update('products_lighting_translations', $arr)) {
                    log_message('error', print_r($this->db->error(), true));
                }
            } else {
                if (!$this->db->insert('products_lighting_translations', $arr)) {
                    log_message('error', print_r($this->db->error(), true));
                }
            }
            $i++;
        }
    }

    public function getTranslations($id)
    {
        $this->db->where('for_id', $id);
        $query = $this->db->get('products_lighting_translations');
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
	
	 public function getRollovers($id)
    {
		$this->db->select('*');
        $this->db->where('product_id', $id);
        $result = $this->db->get('lighting_images');
        return $result->row_array();
        
        
    }
	
	public function getDesigns($id)
    {
		$this->db->select('*');
        $this->db->where('product_id', $id);
        $result = $this->db->get('lighting_design_options');
        return $result->result_array();
        
        
    }
	
	public function getColors($id)
    {
		$this->db->select('*');
        $this->db->where('product_id', $id);
        $result = $this->db->get('lighting_color_options');
        return $result->result_array();
        
        
    }
	function design_delete($product_id)
	{
	   
	   $this->db->where('product_id', $product_id);
	   $this->db->delete('lighting_design_options'); 
	}
	function color_delete($product_id)
	{
	   
	   $this->db->where('product_id', $product_id);
	   $this->db->delete('lighting_color_options'); 
	}
	public function getDesigners()
    {
        $this->db->select('*');
		$this->db->order_by('position', 'asc');
        $result = $this->db->get('designers');
        return $result->result_array();
    }
	

}
