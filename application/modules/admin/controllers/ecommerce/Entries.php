<?php

if (!defined('BASEPATH')) { exit('No direct script access allowed');}

class Entries extends ADMIN_Controller
{
    private $num_rows = 10;
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Entries_model', 'Languages_model', 'Categories_model'));
    }

    public function index($page = 0)
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - View Entries';
        $head['description'] = '!';
        $head['keywords'] = '';
        $this->saveHistory('Go to Entries');
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/entries', $data);
        $this->load->view('_parts/footer');
    }
	
	public function contact_entries($page = 0)
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - View Entries';
        $head['description'] = '!';
        $head['keywords'] = '';
		if (isset($_GET['delete'])) {
            $this->Entries_model->deleteContact($_GET['delete']);
            $this->session->set_flashdata('result_delete', 'Contact is deleted!');
            $this->saveHistory('Delete Contact - ' . $_GET['delete']);
            redirect('admin/entries/contacts');
        }
		$data['contacts'] = $this->Entries_model->getContactEntries();
        $this->saveHistory('Go to Entries');
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/contacts', $data);
        $this->load->view('_parts/footer');
    }
	
	public function priceQuotes($page = 0)
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - View Entries';
        $head['description'] = '!';
        $head['keywords'] = '';
		if (isset($_GET['delete'])) {
            $this->Entries_model->deleteContact($_GET['delete']);
            $this->session->set_flashdata('result_delete', 'Contact is deleted!');
            $this->saveHistory('Delete Contact - ' . $_GET['delete']);
            redirect('admin/entries/priceQuotes');
        }
		$data['info'] = $this->Entries_model->getInfoEntries();
        $this->saveHistory('Go to Entries');
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/price_quotes', $data);
        $this->load->view('_parts/footer');
    }

    public function requestMoreContacts($page = 0)
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - View Entries';
        $head['description'] = '!';
        $head['keywords'] = '';
		if (isset($_GET['delete'])) {
            $this->Entries_model->deleteContact($_GET['delete']);
            $this->session->set_flashdata('result_delete', 'Contact is deleted!');
            $this->saveHistory('Delete Contact - ' . $_GET['delete']);
            redirect('admin/entries/requestMoreContacts');
        }
		$data['Moreinfo'] = $this->Entries_model->getMoreInfoEntries();
        $this->saveHistory('Go to Entries');
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/request_more_info_contacts', $data);
        $this->load->view('_parts/footer');
    }

    public function tradeContacts($page = 0)
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - View Entries';
        $head['description'] = '!';
        $head['keywords'] = '';
		if (isset($_GET['delete'])) {
            $this->Entries_model->deleteTrade($_GET['delete']);
            $this->session->set_flashdata('result_delete', 'Trade is deleted!');
            $this->saveHistory('Delete Trade - ' . $_GET['delete']);
            redirect('admin/entries/tradeContacts');
        }
		$data['tradeInfo'] = $this->Entries_model->getTradeInfoEntries();
        $this->saveHistory('Go to Entries');
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/trade_contacts', $data);
        $this->load->view('_parts/footer');
    }

    public function viewTrade($id)
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - View';
        $head['description'] = '!';
        $head['keywords'] = ''; 
        $data['trade']=$this->Entries_model->viewTrade($id);
        // $p_id = $data['contact']['product_id'];
		// $data['product']=$this->Entries_model->productInfo($p_id);
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/view_trade', $data);
        $this->load->view('_parts/footer');
 
	}

    public function materialContacts($page = 0)
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - View Entries';
        $head['description'] = '!';
        $head['keywords'] = '';
		if (isset($_GET['delete'])) {
            $this->Entries_model->deleteMaterial($_GET['delete']);
            $this->session->set_flashdata('result_delete', 'Material is deleted!');
            $this->saveHistory('Delete Material - ' . $_GET['delete']);
            redirect('admin/entries/materialContacts');
        }
		$data['materialInfo'] = $this->Entries_model->getMaterialInfoEntries();
        $this->saveHistory('Go to Entries');
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/material_contacts', $data);
        $this->load->view('_parts/footer');
    }

    public function viewMaterial($id)
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - View';
        $head['description'] = '!';
        $head['keywords'] = ''; 
        $data['material'] = $this->Entries_model->viewMaterial($id);
        $pId = $data['material']['p_id'];
        $data['orders'] = $this->Entries_model->getFurOrders($pId);
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/view_material', $data);
        $this->load->view('_parts/footer');
 
	}

	public function view($id)
    {

        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - View';
        $head['description'] = '!';
        $head['keywords'] = ''; 
        $data['contact']=$this->Entries_model->viewContact($id);    
        $p_id = $data['contact']['product_id'];
        $productDetails = explode("/", $p_id);
        $catName = $productDetails[0];
        $productId = $productDetails[1];
        if($catName == "view_product"){
            $data['product'] = $this->Entries_model->productfurInfo($productId);
        }
        if($catName == "view_product_lighting"){
            $data['product'] = $this->Entries_model->productlightInfo($productId);
        }
        if($catName == "view_fineart"){
            $data['product'] = $this->Entries_model->productfineInfo($productId);
        }
 

        $data['catName']= $catName;
        $data['productUrl']= $p_id;
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/view_contact', $data);
        $this->load->view('_parts/footer');
	}

}
