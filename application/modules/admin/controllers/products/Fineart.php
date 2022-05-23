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
			$_POST['image'] = $this->uploadImage();
			 $_POST['artist_image'] = $this->uploadArtist();
            $this->Fineart_model->updateFineArt($_POST, $id);
            redirect('admin/finearts');
        }

        
		$data['designers'] = $this->Products_model->getDesigners();	
        $data['fineart'] = $this->Fineart_model->getOneFineArt($id);

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

    

}
