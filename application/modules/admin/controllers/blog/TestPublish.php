<?php

/*
 * @Author:    Kiril Kirkov
 *  Gitgub:    https://github.com/kirilkirkov
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class TestPublish extends ADMIN_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array(
			'Testimonials_model',
            // 'Products_model',
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
        if ($id > 0 && $_POST == null) {
            //$_POST = $this->Products_model->getOneProduct($id);
            //$trans_load = $this->Products_model->getTranslations($id);
        }
        if (isset($_POST['submit'])) {
            if (isset($_GET['to_lang'])) {
                $id = 0;
            }
            $_POST['image'] = $this->uploadImage();
            $this->Testimonials_model->setTestimonial($_POST, $id);
            $this->session->set_flashdata('result_publish', 'Material is published!');
            if ($id == 0) {
                $this->saveHistory('Success published Testimonial');
            } else {
                $this->saveHistory('Success updated Testimonial');
            }
            if (isset($_SESSION['filter']) && $id > 0) {
                $get = '';
                foreach ($_SESSION['filter'] as $key => $value) {
                    $get .= trim($key) . '=' . trim($value) . '&';
                }
                redirect(base_url('admin/testimonials?' . $get));
            } else {
                redirect('admin/testimonials');
            }
        }
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Publish testimonials';
        $head['description'] = '!';
        $head['keywords'] = '';
        $data['id'] = $id;
        $data['trans_load'] = $trans_load;
        $data['languages'] = $this->Languages_model->getLanguages();
        $data['shop_categories'] = $this->Categories_model->getShopCategories();
        $data['mtc'] = $this->Testimonials_model->getTest();
       
        $this->load->view('_parts/header', $head);
        $this->load->view('blog/testpublish', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to publish testimonials');
    }
	
	public function edit($id)
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Testimonials';
        $head['description'] = '!';
        $head['keywords'] = ''; 

        if (isset($_POST['submit'])) {
			$_POST['image'] = $this->uploadImage();
            $this->Testimonials_model->updateTestimonial($_POST, $id);
            redirect('admin/testimonials');
        }

        
		$data['id']=$id;
        $data['test'] = $this->Testimonials_model->getOneTestimonial($id);

        $this->load->view('_parts/header', $head);
        $this->load->view('blog/edit_test', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to testimonials page');
    }

    private function uploadImage()
    {
        $config['upload_path'] = './attachments/test_images/';
        $config['allowed_types'] = $this->allowed_img_types;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('userfile')) {
            log_message('error', 'Image Upload Error: ' . $this->upload->display_errors());
        }
        $img = $this->upload->data();
        return $img['file_name'];
    }

    
   
    /*
     * called from ajax
     */

    public function removeSecondaryImage()
    {
        if ($this->input->is_ajax_request()) {
            $img = '.' . DIRECTORY_SEPARATOR . 'attachments' . DIRECTORY_SEPARATOR . 'test_images' . DIRECTORY_SEPARATOR . '' . $_POST['folder'] . DIRECTORY_SEPARATOR . $_POST['image'];
            unlink($img);
        }
    }

}
