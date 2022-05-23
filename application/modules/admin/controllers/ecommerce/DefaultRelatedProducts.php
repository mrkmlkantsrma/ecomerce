<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class DefaultRelatedProducts extends ADMIN_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('DefaultRelatedProducts_model', 'Categories_model'));
    }

    public function index()
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Default Related Products';
        $head['description'] = '!';
        $head['keywords'] = '';
        $data['proCategory'] = $this->DefaultRelatedProducts_model->getCategoryRelatedproducts();

        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/defaultrelated_products', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to Related Products page');
    }

    public function addDefaultRelatedPro($id = 0)
    {   
        
        $this->login_check();
        $data = array();
        $is_update = false;
        $trans_load = null;
        
        if ($id > 0 && $_POST == null) { 
            $_POST = $this->DefaultRelatedProducts_model->getOneProduct($id);
        }
        if (isset($_POST['submit'])) {
            
            $selctPro = $_POST['selectedProducts'];
            $countPro = count($selctPro);

            if($countPro === 4 ){
                if (isset($_GET['to_lang'])) {
                    $id = 0;
                }

                if (isset($_GET['to_lang'])) {
                    $id = 0;
                }
                $this->DefaultRelatedProducts_model->deleteCategoryRelatedProducts($_POST['main_category']);
                
                    foreach ($selctPro as $expData){
                        $exData = explode("-", $expData);
                    
                        $productType = $exData[0];
                        $relProductId = $exData[1];
                        $_POST['productType'] = $productType;
                        $_POST['relatedProductId'] = $relProductId;
   
                        $this->DefaultRelatedProducts_model->setCategoryRelatedRelProducts($_POST);
                    } 
                
                    $this->session->set_flashdata('result_publish', 'Related Product is published!');
                    if ($id == 0) {
                        $this->saveHistory('Success published Related product');
                    } else {
                        $this->saveHistory('Success updated Related product');
                    }            
                redirect('admin/defaultrelatedproducts');
            }else{
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
        $this->load->view('ecommerce/defaultrelated_publish', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to Related product');
    }

    
    public function getSubCategory(){
        $shop_categorie = $this->input->post('main_category');
        $main_cat_id = $shop_categorie;
        $result = $this->DefaultRelatedProducts_model->getSubCategories($main_cat_id);
        echo json_encode($result);
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
        $result = $this->DefaultRelatedProducts_model->getProductsOptions($main_cat_id); 
        if($result)
        {
            $option = "";
            foreach ($result as $row){
                $option .= "<option value='".$row['for_id']."'>".$row['title']."</option>";             
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
        $head['title'] = 'Administration - Default Related Products';
        $head['description'] = '!';
        $head['keywords'] = '';
   
        if (isset($_POST['selectedProducts'])) {
            $selctPro = $_POST['selectedProducts'];
            $countPro = count($selctPro);

            if($countPro === 4 ){
                $main_category = $_POST['main_category'];
                $MainCat = $this->DefaultRelatedProducts_model->getProCategory($main_category);
                $_POST['main_category_name'] = $MainCat['name'];
                $productList = $this->DefaultRelatedProducts_model->getRelatedproducts();
                $mainCategory =  $productList[0]['main_category'];
                $this->DefaultRelatedProducts_model->updateRelProducts($_POST, $mainCategory);
                redirect('admin/ecommerce/DefaultRelatedProducts');
            }
            else
            {
                $data['errorSelected'] = "<p style='color:red'>Please select only 4 Shop Products</p>";
            }    
        }   

        $data['FurLightProducts'] = $this->DefaultRelatedProducts_model->getFurLightProductsTitle();
        $data['proCategory'] = $this->DefaultRelatedProducts_model->getProCategory($id);
        $data['RelData'] = $this->DefaultRelatedProducts_model->getEditDefProducts($id);

        $getMainCat = $data['RelData']['main_category'];
        $data['sub_cat_product'] = $this->DefaultRelatedProducts_model->getSubCategories($getMainCat);

        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/edit_defaultRelPro', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to Related Products page');
    }
	
}
