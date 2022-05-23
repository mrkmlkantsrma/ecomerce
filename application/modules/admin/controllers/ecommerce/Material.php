<?php

/*
 * @Author:    Kiril Kirkov
 *  Gitgub:    https://github.com/kirilkirkov
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Material extends ADMIN_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array(
			'Material_model',
            // 'FurnitureProducts_model',
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
            $_POST = $this->Material_model->getsingleMaterial($id);

            // $trans_load = $this->FurnitureProducts_model->getTranslations($id);
        }
        if (isset($_POST['submit'])) {
            if (isset($_GET['to_lang'])) {
                $id = 0;
            }
            $_POST['image'] = $this->uploadImage();
            $this->Material_model->setMaterial($_POST, $id);
            $this->session->set_flashdata('result_publish', 'Material is published!');
            if ($id == 0) {
                $this->saveHistory('Success published material');
            } else {
                $this->saveHistory('Success updated material');
            }
            if (isset($_SESSION['filter']) && $id > 0) {
                $get = '';
                foreach ($_SESSION['filter'] as $key => $value) {
                    $get .= trim($key) . '=' . trim($value) . '&';
                }
                redirect(base_url('admin/materials?' . $get));
            } else {
                redirect('admin/materials');
            }
        }
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Publish material';
        $head['description'] = '!';
        $head['keywords'] = '';
        $data['id'] = $id;
        $data['trans_load'] = $trans_load;
        $data['languages'] = $this->Languages_model->getLanguages();
        $data['shop_categories'] = $this->Categories_model->getShopCategories();
        $data['mtc'] = $this->Material_model->getMtc();
       
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/material', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to publish Material');
    }

    private function uploadImage()
    {
        $config['upload_path'] = './attachments/material_images/';
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
            $img = '.' . DIRECTORY_SEPARATOR . 'attachments' . DIRECTORY_SEPARATOR . 'shop_images' . DIRECTORY_SEPARATOR . '' . $_POST['folder'] . DIRECTORY_SEPARATOR . $_POST['image'];
            unlink($img);
        }
    }

}
