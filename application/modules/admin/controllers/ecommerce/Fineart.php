<?php

/*
 * @Author:    Kiril Kirkov
 *  Gitgub:    https://github.com/kirilkirkov
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Fineart extends ADMIN_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array(
			'Fineart_model',
            'Products_model',
            'Languages_model',
            'Brands_model',
            'Categories_model'
        ));
    }

    public function index($id = 0)
    {
		 $this->login_check();
        $is_update = false;
        $trans_load = null;
         
        if (isset($_POST['submit'])) {
            //if (isset($_GET['to_lang'])) {
                $id = 0;
            //}
			$_POST['image'] = $this->uploadImage();
			 $_POST['artist_image'] = $this->uploadArtist();
            $this->Fineart_model->setFineArt($_POST, $id);
            $this->session->set_flashdata('result_publish', 'Product is published!');
            if ($id == 0) {
                $this->saveHistory('Success published product');
            } else {
                $this->saveHistory('Success updated product');
            }
            if (isset($_SESSION['filter']) && $id > 0) {
                $get = '';
                foreach ($_SESSION['filter'] as $key => $value) {
                    $get .= trim($key) . '=' . trim($value) . '&';
                }
                redirect(base_url('admin/finearts?' . $get));
            } else {
                redirect('admin/finearts');
            }
        }
       
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Publish Product';
        $head['description'] = '!';
        $head['keywords'] = '';
        $data['id'] = $id;			
		$data['designers'] = $this->Products_model->getDesigners();	
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/fine_art', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to publish product');
        
    }
	
	public function edit($id)
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Finearts';
        $head['description'] = '!';
        $head['keywords'] = ''; 

        if (isset($_POST['submit'])) {

            if(sizeof($this->input->post("relatedProductArr")) > 1){
                $selctPro = $_POST['relatedProductArr'];
                $countPro = count($selctPro);

                if($countPro === 4 ){
                       
                    $this->Fineart_model->deleteCustomerRelatedProductByProductId($id);
                
                    foreach ($selctPro as $expData){
                    
                        $productDetail = $expData['selectedProductsnew'];

                        $exData = explode("-", $productDetail);
                        
                        $productType = $exData[0];
                        
                        $relProductId = $exData[1];
                        
                        $_POST['productType'] = $productType;
                        $_POST['relatedProductId'] = $relProductId;
                        $_POST['Related_position'] = $expData['Related_position'];
                        

                        $this->Fineart_model->setCustomerRelatedProductsForProduct($_POST, $id);
                        
                    } 
                }
                else
                {
                    $this->session->set_flashdata('message', '<p style="color:red">*Please select only 4 Shop Products</p>');
                    $id = $this->uri->segment('3');
                    redirect('admin/furniture_publish/'.$id);
                }    

            } 
			$_POST['image'] = $this->uploadImage();
			$_POST['artist_image'] = $this->uploadArtist();
            $this->Fineart_model->updateFineArt($_POST, $id);
            redirect('admin/finearts');
        }

        
		$data['designers'] = $this->Products_model->getDesigners();	
        $data['fineart'] = $this->Fineart_model->getOneFineArt($id);
        $data['RelProducts'] = $this->Fineart_model->getEditRelProducts($id);

        $data['catIdRelatedProduct']= $this->Fineart_model->getcatForRelatedProduct($id);
        $data['RelatedCustomerProducts'] = $this->Fineart_model->getCustomerRelProducts($id);

        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/edit_fine_art', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to Finearts page');
    }

    private function uploadImage()
    {
        $config['upload_path'] = './attachments/fineart_images/';
        $config['allowed_types'] = $this->allowed_img_types;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('userfile')) {
            log_message('error', 'Image Upload Error: ' . $this->upload->display_errors());
        }
        $img = $this->upload->data();
        return $img['file_name'];
    }
	
	 private function uploadArtist()
    {
        $config['upload_path'] = './attachments/fineart_images/artists';
        $config['allowed_types'] = $this->allowed_img_types;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('userfile1')) {
            log_message('error', 'Image Upload Error: ' . $this->upload->display_errors());
        }
        $img = $this->upload->data();
        return $img['file_name'];
    }

    public function getSubCategory(){
        $shop_categorie = $this->input->post('main_category');
        $sub_category = $this->input->post('sub_category');
        $main_cat_id = $shop_categorie;
        $result = $this->Fineart_model->getSubCategories($main_cat_id);
        echo json_encode($result);

        if($result)
        {
            $option = "";
            foreach ($result as $row){
                if($sub_category != ''){
                    if($row->for_id == $sub_category){
                         $option .= "<option value='".$row->for_id."' selected>".$row->Name."</option>";
                    }else{

                        $option .= "<option value='".$row->for_id."'>".$row->Name."</option>";             
                    }
                }else{

                    $option .= "<option value='".$row->for_id."'>".$row->Name."</option>";             

                }
            }
            echo $option;
        }
        else
        {
            echo $option = "<option value=''>*Select an Option*</option>";
        }
    }

    public function getProductOnCategory(){
        $main_cat_id = $this->input->post('main_category');
        $sub_category = $this->input->post('shop_categorie');
        $relatedproduct = $this->input->post('relatedproduct');
        $sub_cat_id = $sub_category;
        $result = $this->Fineart_model->getProductsOptions($main_cat_id ,$sub_cat_id);
        if($relatedproduct != 'No'){
            $relatedproducts = trim($relatedproduct, '[]');
            $res = preg_replace('/[\@\.\;\" "]+/', '', $relatedproducts);
            $relatedPRO = explode(',', $res);
        }

        if($result)
        {
            $option = "";
            foreach ($result as $row){
                if($relatedproduct != 'No'){
                    if (in_array($row['id'], $relatedPRO)) {
                        $option .= "<option value='".$row['id']."' selected>".$row['title']."</option>";  
                    } 
                    else {
                        $option .= "<option value='".$row['id']."'>".$row['title']."</option>";  
                    }
                }
                else {
                    $option .= "<option value='".$row['id']."'>".$row['title']."</option>";  
                }
            }
            echo $option;
        }
        else
        {
            echo $option = "<option value=''>*Select an Option*</option>";
        }
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

    public function getParentSubCategories($mainCat){

        // $mainCat = $this->input->post('main_category'); 
        return $results = getSubCats('7');

    }

    function deleteCustomerRelatedProduct(){
        $productId = $this->input->post('product_id');
        $list = $this->Fineart_model->deleteCustomerRelatedProductByProductId($productId);
        echo $list;
    }

}
