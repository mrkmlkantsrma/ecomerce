<?php

/*
 * @Author:    Kiril Kirkov
 *  Gitgub:    https://github.com/kirilkirkov
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Materials extends ADMIN_Controller
{

    private $num_rows = 10;

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Material_model', 'Languages_model', 'Categories_model'));
    }

    public function index($page = 0)
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - View products';
        $head['description'] = '!';
        $head['keywords'] = '';
		
		 unset($_SESSION['filter']);
        $search_title = null;
        if ($this->input->get('search_title') !== NULL) {
            $search_title = $this->input->get('search_title');
            $_SESSION['filter']['search_title'] = $search_title;
            $this->saveHistory('Search for product title - ' . $search_title);
        }
        
        $category = null;
        if ($this->input->get('category') !== NULL) {
            $category = $this->input->get('category');
            $_SESSION['filter']['category '] = $category;
            $this->saveHistory('Search for product code - ' . $category);
        }

        if (isset($_GET['delete'])) {
            $this->Material_model->deleteMaterial($_GET['delete']);
            $this->session->set_flashdata('result_delete', 'Material is deleted!');
            $this->saveHistory('Delete Material id - ' . $_GET['delete']);
            redirect('admin/materials');
        }

       
        
        
       // $rowscount = $this->Products_model->productsCount($search_title, $category);
        //$data['materials'] = $this->Material_model->getMaterial();
       // $data['links_pagination'] = pagination('admin/materials', $rowscount, $this->num_rows, 3);

        $data['materials'] = $this->Material_model->getMaterial();
        $data['mtc'] = $this->Material_model->getMtc();
        $this->saveHistory('Go to materials');
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/materials', $data);
        $this->load->view('_parts/footer');
    }

    public function getProductInfo($id, $noLoginCheck = false)
    {
        /* 
         * if method is called from public(template) page
         */
        if ($noLoginCheck == false) {
            $this->login_check();
        }
        return $this->Products_model->getOneProduct($id);
    }

    /*
     * called from ajax
     */

    public function productStatusChange()
    {
        $this->login_check();
        $result = $this->Products_model->productStatusChange($_POST['id'], $_POST['to_status']);
        if ($result == true) {
            echo 1;
        } else {
            echo 0;
        }
        $this->saveHistory('Change product id ' . $_POST['id'] . ' to status ' . $_POST['to_status']);
    }
	
	 public function mtc()
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Materials';
        $head['description'] = '!';
        $head['keywords'] = '';

        if (isset($_POST['title'])) {
            $this->Material_model->setMtc($_POST['title']);
            redirect('admin/mtc');
        }

        if (isset($_GET['delete'])) {
            $this->Material_model->deleteMtc($_GET['delete']);
            redirect('admin/mtc');
        }

        $data['mat_cat'] = $this->Material_model->getMtc();

        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/material_cat', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to Material page');
    }

}
