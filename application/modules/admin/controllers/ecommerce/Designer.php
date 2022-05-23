<?php

/*
 * @Author:    Kiril Kirkov
 *  Gitgub:    https://github.com/kirilkirkov
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Designer extends ADMIN_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array(
			'Designer_model',
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
			$_POST['image1'] = $this->uploadImage1();
            $this->Designer_model->setDesigner($_POST, $id);
            $this->session->set_flashdata('result_publish', 'designer is published!');
            if ($id == 0) {
                $this->saveHistory('Success published designer');
            } else {
                $this->saveHistory('Success updated designer');
            }
            if (isset($_SESSION['filter']) && $id > 0) {
                $get = '';
                foreach ($_SESSION['filter'] as $key => $value) {
                    $get .= trim($key) . '=' . trim($value) . '&';
                }
                redirect(base_url('admin/designers?' . $get));
            } else {
                redirect('admin/designers');
            }
        }
       
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Publish Designer';
        $head['description'] = '!';
        $head['keywords'] = '';
        $data['id'] = $id;				
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/designer', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to publish designer');
        
    }
	
	public function edit($id)
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Designers';
        $head['description'] = '!';
        $head['keywords'] = ''; 

        if (isset($_POST['submit'])) {
			$_POST['image'] = $this->uploadImage();
			$_POST['image1'] = $this->uploadImage1();
            $this->Designer_model->updateDesigner($_POST, $id);
            redirect('admin/designers');
        }

        

        $data['designer'] = $this->Designer_model->getOneDesigner($id);

        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/edit_designer', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to Designer page');
    }

    private function uploadImage()
    {
        $config['upload_path'] = './attachments/designer_images/';
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
        $config['upload_path'] = './attachments/designer_images/';
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
