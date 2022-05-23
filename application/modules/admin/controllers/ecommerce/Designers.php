<?php

/*
 * @Author:    Kiril Kirkov
 *  Gitgub:    https://github.com/kirilkirkov
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Designers extends ADMIN_Controller
{

    private $num_rows = 10;

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Designer_model', 'Languages_model', 'Categories_model'));
    }

    public function index($page = 0)
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - View Designers';
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
            $this->Designer_model->deleteDesigner($_GET['delete']);
            $this->session->set_flashdata('result_delete', 'Designer is deleted!');
            $this->saveHistory('Delete Designer - ' . $_GET['delete']);
            redirect('admin/designers');
        }

       
        
        
       // $rowscount = $this->Products_model->productsCount($search_title, $category);
        //$data['materials'] = $this->Material_model->getMaterial();
       // $data['links_pagination'] = pagination('admin/materials', $rowscount, $this->num_rows, 3);

        $data['designers'] = $this->Designer_model->getDesigner();
       
        $this->saveHistory('Go to Designers');
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/designers', $data);
        $this->load->view('_parts/footer');
    }
   

}
