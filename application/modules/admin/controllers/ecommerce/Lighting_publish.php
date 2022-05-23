<?php

// ini_set('display_errors',1);
// error_reporting(E_ALL);

/*
 * @Author:    Kiril Kirkov
 *  Gitgub:    https://github.com/kirilkirkov
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Lighting_publish extends ADMIN_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array(
            'LightingProducts_model',
            'Languages_model',
			'Material_model', 
            'Brands_model',
            'Categories_model'
        ));
    }

    public function index($id = 0)
    {
        $this->login_check();
        $data = array();
        $is_update = false;
        $trans_load = null;
        if ($id > 0 && $_POST == null) {
            $data['productImages'] = $this->LightingProducts_model->getProductImgs($id);

            $_POST = $this->LightingProducts_model->getOneProduct($id);
            $trans_load = $this->LightingProducts_model->getTranslations($id);
			$roll = $this->LightingProducts_model->getRollovers($id);
        }
        if (isset($_POST['submit'])) {
        
            if (isset($_GET['to_lang'])) {
                $id = 0;
            }

            $_POST['image'] = $this->uploadImage();
            
            $cpt = count($_FILES['gallery_image']['name']);
            $imgNames = [];
            
            for($i=0; $i<$cpt; $i++)
            {  
                if(empty( $_FILES['gallery_image']['name'][$i] )){
                    continue;
                }                
                $time = $i.time();
                $ext = pathinfo($_FILES['gallery_image']['name'][$i], PATHINFO_EXTENSION);
                $_FILES['gallery']['name']       = $time.'_Lighting.'.$ext;
                $_FILES['gallery']['type']       = $_FILES['gallery_image']['type'][$i];
                $_FILES['gallery']['tmp_name']   = $_FILES['gallery_image']['tmp_name'][$i];
                $_FILES['gallery']['error']      = $_FILES['gallery_image']['error'][$i];
                $_FILES['gallery']['size']       = $_FILES['gallery_image']['size'][$i]; 
                $config['encrypt_name'] = false;
                $config['upload_path'] = './attachments/shop_images/rollovers';
                $config['allowed_types'] = $this->allowed_img_types;
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if( $img = $this->upload->do_upload('gallery') ){
                    $imgNames[] =  $_FILES['gallery']['name'];                     
                }                
            }
            
            $_POST['gallery_images'] = json_encode($imgNames);
            $_POST['design_Options'] = json_encode($_POST['designAttr']);
            $_POST['color_Options'] = json_encode($_POST['colorAttr']);

            $id = $this->LightingProducts_model->setProduct($_POST, $id);

            if(!empty($this->input->post("multiCategoriesArr"))){
  
                if(sizeof($this->input->post("multiCategoriesArr")) > 0){

                    $selectedCategories= $_POST['multiCategoriesArr'];

                    if($selectedCategories[0]['selectedcategoriesNEW']){

                    $this->LightingProducts_model->deletesMultipleSelectCatID($id);
                    
                        foreach ($selectedCategories as $expData){

                            $_POST['CategoryId'] = $expData['selectedcategoriesNEW'];
                            $_POST['Category_position'] = $expData['Category_position'];
                            
                            $this->LightingProducts_model->setMultipleShopCategories($_POST, $id);
                            
                        } 
                    }
                } 
                else{

                    $this->LightingProducts_model->deletesMultipleSelectCatID($id);
                }
            }

            if(!empty($this->input->post("relatedProductArr"))){
                if(sizeof($this->input->post("relatedProductArr")) > 1){
                    $selctPro = $_POST['relatedProductArr'];
                    $countPro = count($selctPro);

                    if($countPro === 4 ){

                        $this->LightingProducts_model->deleteCustomerRelatedProductByProductId($id);
                    
                        foreach ($selctPro as $expData){
                        
                            $productDetail = $expData['selectedProductsnew'];

                            $exData = explode("-", $productDetail);
                            
                            $productType = $exData[0];
                            
                            $relProductId = $exData[1];
                            
                            $_POST['productType'] = $productType;
                            $_POST['relatedProductId'] = $relProductId;
                            $_POST['Related_position'] = $expData['Related_position'];
                            
    
                            $this->LightingProducts_model->setCustomerRelatedProductsForProduct($_POST, $id);
                            
                        } 
                    }
                    else
                    {
                        $this->session->set_flashdata('message', '<p style="color:red">*Please select only 4 Shop Products</p>');
                        $id = $this->uri->segment('3');
                        redirect('admin/lighting_publish/'.$id);
                    }    

                } 
            }

            if(!empty($this->input->post("selectedProducts"))){
                $selctPro = $_POST['selectedProducts'];
                $countPro = count($selctPro);

                if($countPro === 4 ){

                    $this->LightingProducts_model->deleteRelatedProductByProductId($id);
                
                    foreach ($selctPro as $expData){
                        $exData = explode("-", $expData);
                    
                        $productType = $exData[0];
                        $relProductId = $exData[1];
                        $_POST['productType'] = $productType;
                        $_POST['relatedProductId'] = $relProductId;
   
                        $this->LightingProducts_model->setRelatedProductsForProduct($_POST, $id);
                    } 
                }
                else
                {
                    $this->session->set_flashdata('message', '<p style="color:red">*Please select only 4 Shop Products</p>');
                    $id = $this->uri->segment('3');
                    redirect('admin/lighting_publish/'.$id);
                }    

            } 

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
                redirect(base_url('admin/lighting_products?' . $get));
            } 
            else 
            {   
                $id = $this->uri->segment('3');
                if(isset($id)){
                    redirect('admin/lighting_publish/'.$id);
                }else{
                    redirect('admin/lighting_products');
                }
            }
        }
       
        $head = array();
        $head['title'] = 'Administration - Publish Product';
        $head['description'] = '!';
        $head['keywords'] = '';
        $data['id'] = $id;		
		$data['roll'] = $this->LightingProducts_model->getRollovers($id);
		$data['designs'] = $this->LightingProducts_model->getDesigns($id);
		$data['colors'] = $this->LightingProducts_model->getColors($id);
        $data['trans_load'] = $trans_load;
        $data['languages'] = $this->Languages_model->getLanguages();
		$data['designers'] = $this->LightingProducts_model->getDesigners();
        $data['shop_categories'] = $this->Categories_model->getShopCategories();
        $data['getLightingProducts'] = $this->LightingProducts_model->getLightingProducts();
        $data['RelProducts'] = $this->LightingProducts_model->getEditRelProducts($id);
        
        $data['AllCat'] = $this->LightingProducts_model->getAllSubCategories();
        $data['MultiSelectedCategories'] = $this->LightingProducts_model->getMultipleShopCategories($id);

        
        $data['lightCat'] = $this->LightingProducts_model->getSubCategories('15');
        $data['brands'] = $this->Brands_model->getBrands();
		$data['materials'] = $this->Material_model->getMtc();
        
        $data['lighting_cat'] = $this->LightingProducts_model->getSubCategories(15);
        if($data['RelProducts'] != ''){
            if($data['RelProducts']['sub_category'] != ''){
                $data['sub_cat_product'] = $this->LightingProducts_model->getProductsOptions(15 ,$data['RelProducts']['sub_category']);
            }
        }

        $data['RelatedCustomerProducts'] = $this->LightingProducts_model->getCustomerRelProducts($id);
        $data['catIdRelatedProduct']= $this->LightingProducts_model->getcatForRelatedProduct($id);

        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/lighting_publish', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to publish product');
    }

    private function uploadImage()
    {
        $config['upload_path'] = './attachments/shop_images/';
        $config['allowed_types'] = $this->allowed_img_types;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('userfile')) {
            log_message('error', 'Image Upload Error: ' . $this->upload->display_errors());
        }
        $img = $this->upload->data();
        return $img['file_name'];
    }
	
	 private function uploadImage_designer()
    {
        $config['upload_path'] = './attachments/designer_images/';
        $config['allowed_types'] = $this->allowed_img_types;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('userfile_d')) {
            log_message('error', 'Image Upload Error: ' . $this->upload->display_errors());
        }
        $img = $this->upload->data();
        return $img['file_name'];
    }
	
	private function uploadImage_rollover1()
    {
        $config['upload_path'] = './attachments/shop_images/rollovers/';
        $config['allowed_types'] = $this->allowed_img_types;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('rollover_image1')) {
            log_message('error', 'Image Upload Error: ' . $this->upload->display_errors());
        }
        $img = $this->upload->data();
        return $img['file_name'];
    }
	private function uploadImage_rollover2()
    {
        $config['upload_path'] = './attachments/shop_images/rollovers/';
        $config['allowed_types'] = $this->allowed_img_types;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('rollover_image2')) {
            log_message('error', 'Image Upload Error: ' . $this->upload->display_errors());
        }
        $img = $this->upload->data();
        return $img['file_name'];
    }
	private function uploadImage_rollover3()
    {
        $config['upload_path'] = './attachments/shop_images/rollovers/';
        $config['allowed_types'] = $this->allowed_img_types;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('rollover_image3')) {
            log_message('error', 'Image Upload Error: ' . $this->upload->display_errors());
        }
        $img = $this->upload->data();
        return $img['file_name'];
    }
	private function uploadImage_rollover4()
    {
        $config['upload_path'] = './attachments/shop_images/rollovers/';
        $config['allowed_types'] = $this->allowed_img_types;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('rollover_image4')) {
            log_message('error', 'Image Upload Error: ' . $this->upload->display_errors());
        }
        $img = $this->upload->data();
        return $img['file_name'];
    }
	private function uploadImage_rollover5()
    {
        $config['upload_path'] = './attachments/shop_images/rollovers/';
        $config['allowed_types'] = $this->allowed_img_types;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('rollover_image5')) {
            log_message('error', 'Image Upload Error: ' . $this->upload->display_errors());
        }
        $img = $this->upload->data();
        return $img['file_name'];
    }
	private function uploadImage_rollover6()
    {
        $config['upload_path'] = './attachments/shop_images/rollovers/';
        $config['allowed_types'] = $this->allowed_img_types;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('rollover_image6')) {
            log_message('error', 'Image Upload Error: ' . $this->upload->display_errors());
        }
        $img = $this->upload->data();
        return $img['file_name'];
    }

    /*
     * called from ajax
     */

    public function do_upload_others_images()
    {
        if ($this->input->is_ajax_request()) {
            $upath = '.' . DIRECTORY_SEPARATOR . 'attachments' . DIRECTORY_SEPARATOR . 'shop_images' . DIRECTORY_SEPARATOR . $_POST['folder'] . DIRECTORY_SEPARATOR;
            if (!file_exists($upath)) {
                mkdir($upath, 0777);
            }

            $this->load->library('upload');
            $files = $_FILES;
            $cpt = count($_FILES['others']['name']);
            for ($i = 0; $i < $cpt; $i++) {
                unset($_FILES);
                $_FILES['others']['name'] = $files['others']['name'][$i];
                $_FILES['others']['type'] = $files['others']['type'][$i];
                $_FILES['others']['tmp_name'] = $files['others']['tmp_name'][$i];
                $_FILES['others']['error'] = $files['others']['error'][$i];
                $_FILES['others']['size'] = $files['others']['size'][$i];
                $this->upload->initialize(array(
                    'upload_path' => $upath,
                    'allowed_types' => $this->allowed_img_types
                ));
                $this->upload->do_upload('others');
            }
        }
    }

    public function loadOthersImages()
    {
        $output = '';
        if (isset($_POST['folder']) && $_POST['folder'] != null) {
            $dir = 'attachments' . DIRECTORY_SEPARATOR . 'shop_images' . DIRECTORY_SEPARATOR . $_POST['folder'] . DIRECTORY_SEPARATOR;
            if (is_dir($dir)) {
                if ($dh = opendir($dir)) {
                    $i = 0;
                    while (($file = readdir($dh)) !== false) {
                        if (is_file($dir . $file)) {
                            $output .= '
                                <div class="other-img" id="image-container-' . $i . '">
                                    <img src="' . base_url('attachments/shop_images/' . $_POST['folder'] . '/' . $file) . '" style="width:100px; height: 100px;">
                                    <a href="javascript:void(0);" onclick="removeSecondaryProductImage(\'' . $file . '\', \'' . $_POST['folder'] . '\', ' . $i . ')">
                                        <span class="glyphicon glyphicon-remove"></span>
                                    </a>
                                </div>
                               ';
                        }
                        $i++;
                    }
                    closedir($dh);
                }
            }
        }
        if ($this->input->is_ajax_request()) {
            echo $output;
        } else {
            return $output;
        }
    }

    /*
     * called from ajax
     */

    public function removeSecondaryImage()
    {
        if ($this->input->is_ajax_request()) {
            $img = '.' . DIRECTORY_SEPARATOR . 'attachments' . DIRECTORY_SEPARATOR . 'shop_images' . DIRECTORY_SEPARATOR . '' . $_POST['folder'] . DIRECTORY_SEPARATOR . $_POST['image'];
            unlink($img);
        }
    }
	function design_delete($product_id){
       
        $this->LightingProducts_model->design_delete($product_id);
        redirect('admin/lighting_publish/'.$product_id);
    }
    function design_edit($product_id){
       
        $this->LightingProducts_model->design_delete($product_id);
        redirect('admin/lighting_publish/'.$product_id);
    }
	function color_delete($product_id){
       
        $this->LightingProducts_model->color_delete($product_id);
        redirect('admin/lighting_publish/'.$product_id);
    }

    public function getSubCategory(){
        $shop_categorie = $this->input->post('main_category');
        $sub_category = $this->input->post('sub_category');
        $main_cat_id = $shop_categorie;
        $result = $this->LightingProducts_model->getSubCategories($main_cat_id);
        echo json_encode($result);

        if($result)
        {
            $option = "";
            foreach ($result as $row){
                if($sub_category != ''){
                    if($row->for_id == $sub_category){
                        echo "selected";
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

    function deleteRelatedProduct(){
        $productId = $this->input->post('product_id');
        $list = $this->LightingProducts_model->deleteRelatedProductByProductId($productId);
        echo $list;
    }

    public function getProductOnCategory(){
        $main_cat_id = $this->input->post('main_category');
        $sub_category = $this->input->post('shop_categorie');
        $relatedproduct = $this->input->post('relatedproduct');
        $sub_cat_id = $sub_category;
        $result = $this->LightingProducts_model->getProductsOptions($main_cat_id ,$sub_cat_id);
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
    function deleteCustomerRelatedProduct(){
        $productId = $this->input->post('product_id');
        $list = $this->LightingProducts_model->deleteCustomerRelatedProductByProductId($productId);
        echo $list;
    }
}
