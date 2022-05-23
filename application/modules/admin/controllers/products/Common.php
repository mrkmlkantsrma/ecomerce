<?php

/*
 * @Author:    Kiril Kirkov
 *  Gitgub:    https://github.com/kirilkirkov
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Common extends ADMIN_Controller
{

    public function __construct()
    {
        parent::__construct();        
    }



    public function getProductOptions(){
        $main_cat_id = $this->input->post('main_category');
        $sub_category = $this->input->post('shop_categorie');
        $relatedproduct = $this->input->post('relatedproduct');
        $whereData = [
            'mainCategory'  => $main_cat_id
        ];
        $relatedproductArray = [];
        if( !empty($relatedproduct) ){
            $relatedproductArray = json_decode($relatedproduct, true);           
        }
        $results = getProductOptions($whereData);
        
        if($results)
        {
            $option = "";
            foreach ($results as $row){  
                if (in_array($row->id, $relatedproductArray)) {
                    $option .= "<option value='{$row->id}' selected>{$row->title}</option>";  
                } 
                else {                                
                $option .= "<option value='{$row->id}'>{$row->title}</option>";  
                }
            }  
        }                    
        else
        {
            $option = "<option value=''>*Select an Option*</option>";
        }
        echo $option;
    }
}
