<?php

/*
 * @Author:    Kiril Kirkov
 *  Gitgub:    https://github.com/kirilkirkov
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Finearts extends ADMIN_Controller
{

    private $num_rows = 10;

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Fineart_model', 'Languages_model', 'Categories_model'));
    }

    public function index($page = 0)
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - View Fineart products';
        $head['description'] = '!';
        $head['keywords'] = '';
		
		 unset($_SESSION['filter']);
        $search_title = null;
        if ($this->input->get('search_title') !== NULL) {
            $search_title = $this->input->get('search_title');
            $_SESSION['filter']['search_title'] = $search_title;
            $this->saveHistory('Search for Fineart product title - ' . $search_title);
        }
        
        $category = null;
        if ($this->input->get('category') !== NULL) {
            $category = $this->input->get('category');
            $_SESSION['filter']['category '] = $category;
            $this->saveHistory('Search for Fineart code - ' . $category);
        }

        if (isset($_GET['delete'])) {
            $this->Fineart_model->deleteFineArt($_GET['delete']);
            $this->session->set_flashdata('result_delete', 'Material is deleted!');
            $this->saveHistory('Delete Fineart product id - ' . $_GET['delete']);
            redirect('admin/finearts');
        }

       
        
        
       // $rowscount = $this->Products_model->productsCount($search_title, $category);
        //$data['materials'] = $this->Material_model->getMaterial();
       // $data['links_pagination'] = pagination('admin/materials', $rowscount, $this->num_rows, 3);

        $data['finearts'] = $this->Fineart_model->getFineArt();
       
        $this->saveHistory('Go to Fine Arts');
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/fine_arts', $data);
        $this->load->view('_parts/footer');
    }
   

}
