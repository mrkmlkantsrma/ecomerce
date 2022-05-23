<?php

/*
 * @Author:    Kiril Kirkov
 *  Gitgub:    https://github.com/kirilkirkov
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Furniture_Products extends ADMIN_Controller
{

    private $num_rows = 10;

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('furnitureProducts_model', 'Languages_model', 'Categories_model'));
    }

    public function index($page = 0)
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - View products';
        $head['description'] = '!';
        $head['keywords'] = '';

        if (isset($_GET['delete'])) {
            $this->furnitureProducts_model->deleteProduct($_GET['delete']);
            $this->session->set_flashdata('result_delete', 'product is deleted!');
            $this->saveHistory('Delete product id - ' . $_GET['delete']);
            redirect('admin/furniture_products');
        }

        unset($_SESSION['filter']);
        $search_title = null;
        if ($this->input->get('search_title') !== NULL) {
            $search_title = $this->input->get('search_title');
            $_SESSION['filter']['search_title'] = $search_title;
            $this->saveHistory('Search for product title - ' . $search_title);
        }
        $orderby = null;
        if ($this->input->get('order_by') !== NULL) {
            $orderby = $this->input->get('order_by');
            $_SESSION['filter']['order_by '] = $orderby;
        }
        $category = null;
        if ($this->input->get('category') !== NULL) {
            $category = $this->input->get('category');
            $_SESSION['filter']['category '] = $category;
            $this->saveHistory('Search for product code - ' . $category);
        }
        $brand = null;
        if ($this->input->get('show_brand') !== NULL) {
            $brand = $this->input->get('show_brand');
        }
		$designer = null;
        if ($this->input->get('show_designer') !== NULL) {
            $designer = $this->input->get('show_designer');
        }
        $data['products_lang'] = $products_lang = $this->session->userdata('admin_lang_products');
        $rowscount = $this->furnitureProducts_model->productsCount($search_title, $category);
        $data['products'] = $this->furnitureProducts_model->getproducts($this->num_rows, $page, $search_title, $orderby, $category, $brand, $designer);
        $data['links_pagination'] = pagination('admin/furniture_products', $rowscount, $this->num_rows, 3);
        $data['num_shop_art'] = $this->furnitureProducts_model->numShopproducts();
        $data['languages'] = $this->Languages_model->getLanguages();
        $data['shop_categories'] = $this->Categories_model->getShopCategories(null, null, 2);
        $this->saveHistory('Go to products');
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/furniture_products', $data);
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
        return $this->furnitureProducts_model->getOneProduct($id);
    }

    /*
     * called from ajax
     */

    public function productStatusChange()
    {
        $this->login_check();
        $result = $this->furnitureProducts_model->productStatusChange($_POST['id'], $_POST['to_status']);
        if ($result == true) {
            echo 1;
        } else {
            echo 0;
        }
        $this->saveHistory('Change product id ' . $_POST['id'] . ' to status ' . $_POST['to_status']);
    }

}
