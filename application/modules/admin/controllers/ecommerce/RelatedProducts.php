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
            $this->RelatedProducts_model->deleteSubCategoryRelatedProduct($_GET['delete']);
            redirect('admin/relatedproducts');
        }

        $data['proCategory'] = $this->RelatedProducts_model->getSubCatRelatedproducts();
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

            $selctPro = $_POST['selectedProducts'];
            $countPro = count($selctPro);

            if($countPro === 4 ){
                if (isset($_GET['to_lang'])) {
                    $id = 0;
                }

                $this->RelatedProducts_model->deleteSubCategoryRelatedProduct($_POST['sub_category']);
                
                    foreach ($selctPro as $expData){
                        $exData = explode("-", $expData);
                    
                        $productType = $exData[0];
                        $relProductId = $exData[1];
                        $_POST['productType'] = $productType;
                        $_POST['relatedProductId'] = $relProductId;
   
                        $this->RelatedProducts_model->setSubcategoryRelatedProducts($_POST);
                    } 

                $this->session->set_flashdata('result_publish', 'Related Product is published!');
                if ($id == 0) {
                    $this->saveHistory('Success published Related product');
                } else {
                    $this->saveHistory('Success updated Related product');
                }
                redirect('admin/relatedproducts');
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

        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/relatedproduct_publish', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to Related product');
    }

    public function edit($subCategoryId)   
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

                $this->RelatedProducts_model->deleteSubCategoryRelatedProduct($_POST['sub_category']);
                
                    foreach ($selctPro as $expData){
                        $exData = explode("-", $expData);
                    
                        $productType = $exData[0];
                        $relProductId = $exData[1];
                        $_POST['productType'] = $productType;
                        $_POST['relatedProductId'] = $relProductId;
   
                        $this->RelatedProducts_model->setSubcategoryRelatedProducts($_POST);
                    } 

            redirect('admin/relatedproducts');

            }else{
                $data['errorSelected'] = "<p style='color:red'>Please select only 4 Shop Products</p>";
            }    
        }   

        $data['SubCategoryRelatedData'] = $this->RelatedProducts_model->getEditSubCategoryRelProducts($subCategoryId);

        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/edit_RelProducts', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to Related Products page');
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

}
