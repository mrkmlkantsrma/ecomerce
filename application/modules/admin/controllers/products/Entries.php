<?php

/*
 * @Author:    Kiril Kirkov
 *  Gitgub:    https://github.com/kirilkirkov
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

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
	
	public function info_entries($page = 0)
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
            redirect('admin/entries/info');
        }
		$data['info'] = $this->Entries_model->getInfoEntries();
        $this->saveHistory('Go to Entries');
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/info', $data);
        $this->load->view('_parts/footer');
    }

    public function moreInfo($page = 0)
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
            redirect('admin/entries/moreInfo');
        }
		$data['Moreinfo'] = $this->Entries_model->getMoreInfoEntries();
        $this->saveHistory('Go to Entries');
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/more_info', $data);
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
		$data['product']=$this->Entries_model->productInfo($p_id);
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/view_contact', $data);
        $this->load->view('_parts/footer');
 
	}

}
