<?php

/*
 * @Author:    Kiril Kirkov
 *  Gitgub:    https://github.com/kirilkirkov
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Brands extends ADMIN_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Brands_model');
    }

    public function index()
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Brands';
        $head['description'] = '!';
        $head['keywords'] = '';

        if (isset($_POST['name'])) {
			 $_POST['image1'] = $this->uploadImage();
			 $_POST['image2'] = $this->uploadImage1();
            $this->Brands_model->setBrand($_POST);
            redirect('admin/brands');
        }

        if (isset($_GET['delete'])) {
            $this->Brands_model->deleteBrand($_GET['delete']);
            redirect('admin/brands');
        }

        $data['brands'] = $this->Brands_model->getBrands();

        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/brands', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to brands page');
    }
	
	
	public function edit($id)
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Brands';
        $head['description'] = '!';
        $head['keywords'] = '';

        if (isset($_POST['name'])) {
			 $_POST['image1'] = $this->uploadImage();
			 $_POST['image2'] = $this->uploadImage1();
            $this->Brands_model->updateBrand($_POST, $id);
            redirect('admin/brands');
        }

        if (isset($_GET['delete'])) {
            $this->Brands_model->deleteBrand($_GET['delete']);
            redirect('admin/brands');
        }

        $data['brand'] = $this->Brands_model->getbrand($id);

        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/edit_brand', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to brands page');
    }
	
	private function uploadImage()
    {
        $config['upload_path'] = './attachments/brand_images/';
        $config['allowed_types'] = $this->allowed_img_types;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('userfile')) {
            log_message('error', 'Image Upload Error: ' . $this->upload->display_errors());
        }
        $img = $this->upload->data();
        return $img['file_name'];
    }
	
	private function uploadImage1()
    {
        $config['upload_path'] = './attachments/brand_images/';
        $config['allowed_types'] = $this->allowed_img_types;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('userfile1')) {
            log_message('error', 'Image Upload Error: ' . $this->upload->display_errors());
        }
        $img = $this->upload->data();
        return $img['file_name'];
    }

}
