<?php

/*
 * @Author:    Kiril Kirkov
 *  Gitgub:    https://github.com/kirilkirkov
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Product extends ADMIN_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array(
			'Product_model',
            'Languages_model',
            'Brands_model',
            'Categories_model'
        ));
    }

    public function index($id = 0)
    {
		//  $this->login_check();
        // $is_update = false;
        // $trans_load = null;
         
        if (isset($_POST['submit'])) {
            //if (isset($_GET['to_lang'])) {
                $id = 0;
            //}
                // echo "<pre>";
                // print_r($_POST);
                // echo "</pre>";
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
                $_FILES['gallery']['name']       = $time.'_Furniture.'.$ext;
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
            
            // $_POST['gallery_images'] = json_encode($imgNames);

            $this->Product_model->setProduct($_POST, $id);
            $this->session->set_flashdata('result_publish', 'product is published!');
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
                redirect(base_url('admin/products?' . $get));
            } else {
                redirect('admin/products');
            }
        }
       
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Publish Product';
        $head['description'] = '!';
        $head['keywords'] = '';
        $data['id'] = $id;				
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/product', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to publish product');
        
    }
	
	public function edit($id)
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Product';
        $head['description'] = '!';
        $head['keywords'] = ''; 

        if (isset($_POST['submit'])) {
			$_POST['image'] = $this->uploadImage();
			$_POST['image1'] = $this->uploadImage1();
            $this->Product_model->updateDesigner($_POST, $id);
            redirect('admin/products');
        }

        

        $data['product'] = $this->Product_model->getOneDesigner($id);

        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/edit_product', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to Product page');
    }

    private function uploadImage()
    {
        $config['upload_path'] = './assets/admin/shop_images/';
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
	
    function deleteCat($mCatID, $productID){
        $this->Products_model->row_cat($mCatID , $productID);
        redirect('admin/furniture_publish/'.$productID);
    }

	function row_delete($product_id){
       
        $this->Products_model->row_delete($product_id);
        redirect('admin/furniture_publish/'.$product_id);
    }
    
    function deleteRelatedProduct(){
        $productId = $this->input->post('product_id');
        $list = $this->Products_model->deleteRelatedProductByProductId($productId);
        echo $list;
    }

    function deleteMCat(){
        $mCatId = $this->input->post('mCatId');
        $productId = $this->input->post('productId');
        $list = $this->Products_model->deleteMCatId($productId,$mCatId);
        echo $list;
    }

  
    function deleteCustomerRelatedProduct(){
        $productId = $this->input->post('product_id');
        $list = $this->Products_model->deleteCustomerRelatedProductByProductId($productId);
        echo $list;
    }
}
