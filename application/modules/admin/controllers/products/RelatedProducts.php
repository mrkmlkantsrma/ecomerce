<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class RelatedProducts extends ADMIN_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('RelatedProducts_model', 'Categories_model'));
    }

    public function index()
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Related Products';
        $head['description'] = '!';
        $head['keywords'] = '';

        if (isset($_GET['delete'])) {
            $this->RelatedProducts_model->deleteRelProduct($_GET['delete']);
            redirect('admin/relatedproducts');
        }

        $data['proCategory'] = $this->RelatedProducts_model->getRelatedproducts();
        // echo '<pre>';print_r($data['proCategory']);echo '</pre>';
    //     foreach($data['proCategory'] as $dataD){
    //         $relatedproduct = $dataD['related_products'];
        
    //     $relatedproducts = trim($relatedproduct, '[]');
    //     $res = preg_replace('/[\@\.\;\" "]+/', '', $relatedproducts);
    //     $relatedPRO = explode(',', $res);
    //     echo '<pre>';print_r($relatedPRO);echo '</pre>';
    // }
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/related_products', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to Related Products page');
    }

    public function addRelatedPro($id = 0)
    {
        $this->login_check();
        $data = array();
        $is_update = false;
        $trans_load = null;
        
        if ($id > 0 && $_POST == null) { 
            $_POST = $this->RelatedProducts_model->getOneProduct($id);
        }
        if (isset($_POST['submit'])) {
            // print_r($_POST);die('ddd');
            $selctPro = $_POST['selectedProducts'];
            $countPro = count($selctPro);

            if($countPro === 4 ){
                if (isset($_GET['to_lang'])) {
                    $id = 0;
                }

                $main_category = $_POST['main_category'];
                $sub_category = $_POST['sub_category'];
                $MainCat = $this->RelatedProducts_model->getProCategory($main_category);
                $SubCat = $this->RelatedProducts_model->getProCategory($sub_category);
                $_POST['main_category_name'] = $MainCat['name'];
                $_POST['sub_category_name'] = $SubCat['name'];

                $productList = $this->RelatedProducts_model->getOneRelatedproducts($sub_category);

                if($productList != ''){
                    $id = $productList[0]['id']; 
                    $subCategory =  $productList[0]['sub_category']; 
                }
                if($subCategory != ''){
                    $this->RelatedProducts_model->updateRelProducts($_POST, $id);
                }else{
                    $this->RelatedProducts_model->setRelProducts($_POST, $id);
                }

                $this->session->set_flashdata('result_publish', 'Related Product is published!');
                if ($id == 0) {
                    $this->saveHistory('Success published Related product');
                } else {
                    $this->saveHistory('Success updated Related product');
                }
            }
            else{
                $data['errorSelected'] = "<p style='color:red'>Please select only 4 Shop Products</p>";
            }
        }
        
        $head = array();
        $head['title'] = 'Administration - Related Publish Product';
        $head['description'] = '!';
        $head['keywords'] = '';
        $data['id'] = $id;
        $data['trans_load'] = $trans_load;    
        $data['allLightingProducts'] = $this->RelatedProducts_model->allLightingProducts();
        $data['allFurnitureProducts'] = $this->RelatedProducts_model->allFurnitureProducts();
        // echo '<pre>'; print_r($data['allFurnitureProducts']); echo '</pre>';
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/relatedproduct_publish', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to Related product');
    }

    public function getSubCategory(){
        $shop_categorie = $this->input->post('main_category');
        $main_cat_id = $shop_categorie;
        $result = $this->RelatedProducts_model->getSubCategories($main_cat_id);
        if($result)
        {
            $option = "";
            foreach ($result as $row){
                $option .= "<option value='".$row->for_id."'>".$row->Name."</option>";             
            }
            echo $option;
        }
        else
        {
            echo $option = "<option value=''>--Select an Option--</option>";
        }
    }

    public function getProductOnCategory(){
   
        $main_cat_id = $this->input->post('main_category');
        $sub_category = $this->input->post('sub_category');
        $relatedproduct = $this->input->post('relatedproduct');
        $sub_cat_id = $sub_category;
        $result = $this->RelatedProducts_model->getProductsOptions($main_cat_id ,$sub_cat_id);

        $relatedproducts = trim($relatedproduct, '[]');
        $res = preg_replace('/[\@\.\;\" "]+/', '', $relatedproducts);
        $relatedPRO = explode(',', $res);

        if($result)
        {
            $option = "";
            foreach ($result as $row){
                if (in_array($row['for_id'], $relatedPRO)) {
                    $option .= "<option value='".$row['for_id']."' selected>".$row['title']."</option>";  
                } 
                else {
                    $option .= "<option value='".$row['for_id']."'>".$row['title']."</option>";  
                }
            }
            echo $option;
        }
        else
        {
            echo $option = "<option value=''>--Select an Option--</option>";
        }
    }

	public function edit($id)
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Related Products';
        $head['description'] = '!';
        $head['keywords'] = '';

        if (isset($_POST['selectedProducts'])) {
            $selctPro = $_POST['selectedProducts'];
            $countPro = count($selctPro);

            if($countPro === 4 ){
                $main_category = $_POST['main_category'];
                $sub_category = $_POST['sub_category'];
                $MainCat = $this->RelatedProducts_model->getProCategory($main_category);
                $SubCat = $this->RelatedProducts_model->getProCategory($sub_category);
                $_POST['main_category_name'] = $MainCat['name'];
                $_POST['sub_category_name'] = $SubCat['name'];
                $this->RelatedProducts_model->updateRelProducts($_POST, $id);
                redirect('admin/relatedproducts');
            }else{
                $data['errorSelected'] = "<p style='color:red'>Please select only 4 Shop Products</p>";
            }    
        }   

        if (isset($_GET['delete'])) {
            $this->RelatedProducts_model->deleteRelProduct($_GET['delete']);
            redirect('admin/relatedproducts');
        }

        $data['RelData'] = $this->RelatedProducts_model->getEditRelProducts($id);

        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/edit_RelProducts', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to Related Products page');
    }
	
}
