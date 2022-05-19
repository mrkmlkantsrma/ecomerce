<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class HomeController extends MX_Controller {

	public function __construct()
   	{
       parent :: __construct();
        $this->load->helper(array('form', 'url'));
        // $this->load->library('form_validation');
        // $this->load->model('Home_Model');
        // $this->load->library('session');

        // require_once APPPATH.'third_party/google-api/Google_Client.php';
		// require_once APPPATH.'third_party/google-api/contrib/Google_Oauth2Service.php';
   	}
	 
	public function index(){

	 	$this->load->template('homepage');
	}

	public function Aboutus(){

	 	$this->load->template('about-us');
	}
    public function Shop(){

	 	$this->load->template('shop');
	}
	public function Whysugacci(){

		$this->load->template('details');
   	}
	public function Contact(){

	 	$this->load->template('contact-us');
	}
	public function Cart(){

		$this->load->template('cart');
   }
   public function NotFound(){

	$this->load->template('404');
}
	public function Login(){

	 	$this->load->template('login');
	}
	public function Register(){

	 	$this->load->template('register');
	}
// 	public function RegisterUser()
//     {

//       if (!$this->session->userdata('logged_in'))
//       {
//         $this->form_validation->set_rules('firstname','First Name','trim|required');
//         $this->form_validation->set_rules('lastname','Last Name','trim|required');
//         $this->form_validation->set_rules('username','User Name','trim|required|is_unique[user.username]');
//         $this->form_validation->set_rules('email','Email','trim|required|is_unique[user.email]');
//         $this->form_validation->set_rules('password','Password','trim|required|min_length[5]|max_length[10]');
//         $this->form_validation->set_rules('number','number','trim|required|numeric');
//         if($this->input->post())
//         {
//             if($this->form_validation->run() == false)
//             {
//                 echo validation_errors();
//             }
//             else{
//                 $data = array(
//                     'firstname' => $this->input->post('firstname'),
//                     'lastname' => $this->input->post('lastname'),
//                     'username' => $this->input->post('username'),
//                     'email' => $this->input->post('email'),
//                     'password' => $this->input->post('password'),
//                     'number' => $this->input->post('number'),
//                     'user_type' => $this->input->post('user_type'),
//                 );
//                 $this->Home_Model->RegisterUsers($data);
//                    $session_data = array(
//                     'username' => $data['username'],
//                     'email' => $data['email'],
//                     'name' => $data['firstname'],
//                     'usertype' => $data['user_type'],
//                     );
//                  $this->session->set_userdata('logged_in', $session_data['name']);
//                  $this->session->set_userdata('usertype', $session_data['usertype']);
//             $this->session->set_flashdata('success', ' '.$this->session->userdata('logged_in').' You Are successfully registered');
//             }
//         }
//         redirect(base_url());
//       }
//     }
//     public function email_check() {
//         if (array_key_exists('email',$_POST))
//         {
//          if ( $this->Home_Model->mail_exists($this->input->post('email')) == TRUE )
//           {
//             echo 'false';
//             }
//            else
//             {
//                echo 'true';
//             }
//         }
//     }
//     public function username_check() {
//         if (array_key_exists('username',$_POST))
//         {
//          if ( $this->Home_Model->username_exists($this->input->post('username')) == TRUE )
//           {
//             echo 'false';
//             }
//            else
//             {
//                echo 'true';
//             }
//         }
//     }
//     public function login_Email_check() {
//         if (array_key_exists('email',$_POST))
//         {
//          if ( $this->Home_Model->mail_exists($this->input->post('email')) == TRUE )
//           {
//             echo 'true';
//             }
//            else
//             {
//                echo 'false';
//             }
//         }
//     }
    
//     public function LoginUser() {

//         $this->form_validation->set_rules('email', 'Username', 'required');
//         $this->form_validation->set_rules('password', 'Password', 'required');
//         if ($this->form_validation->run() == false) {
              
//         } 
//         else 
//         {
//             $data = array('email' => $this->input->post('username'), 'email' => $this->input->post('email'), 'password' => $this->input->post('password'));           
//             $result = $this->Home_Model->loginUsers($data);
           
//             if ($result != false) {
            
//                 $username = $this->input->post('email');
//                 $result = $this->Home_Model->read_user_information($username);
//                 if ($result != false) {
//                     $session_data = array(
//                     'username' => $result[0]->username,
//                     'email' => $result[0]->email,
//                     'name' => $result[0]->firstname,
//                     'usertype'=> $result[0]->user_type,

//                     );
//                     $this->session->set_userdata('logged_in', $session_data['name']);
//                     $this->session->set_userdata('usertype', $session_data['usertype']);
//                  $this->session->set_flashdata('success', ' '.$this->session->userdata('logged_in').' You Are successfully Login');
//                 }
//             redirect(base_url());
//             } 
//             else
//             {
//                  $this->session->set_flashdata('error_Login', $data);
//                 //$data = array('error_message' => 'Invalid Username or Password');
//               redirect(base_url());
//             }
//         }
//     }
//      public function google_Login(){
        
// // 		$clientId = '568121562085-gjqphhua0eg4topbm7guoop6ahm8klao.apps.googleusercontent.com'; //Google client ID
// // 		$clientSecret = 'y_15xuQJoitEC-w4dMS0sp5N'; //Google client secret

  
// 		$clientId = '796271523450-sn5d2c3o4ko4rrbe0clhp2cj06nds6ct.apps.googleusercontent.com'; //Google client ID
// 		$clientSecret = 'BQS1NODphx3XHv04gq7nRI9w'; //Google client secret
		
// 		$redirectURL = 'https://www.web-xperts.xyz/team/kamal/braincrester/home/HomeController/google_Login';
	
// 		$google_Client = new Google_Client();
// 		$google_Client->setApplicationName('Braincrester');
// 		$google_Client->setClientId($clientId);
// 		$google_Client->setClientSecret($clientSecret);
// 		$google_Client->setRedirectUri($redirectURL);
// 		$google_OauthV2 = new Google_Oauth2Service($google_Client);
		
// 		if(isset($_GET['code']))
// 		{ 
// 			$google_Client->authenticate($_GET['code']);
// 			$_SESSION['token'] = $google_Client->getAccessToken();
// 		}
// 		if (isset($_SESSION['token'])) 
// 		{
// 			$google_Client->setAccessToken($_SESSION['token']);
// 		}
// 		if ($google_Client->getAccessToken()) {
// 		    $data =[];
//             $data = $google_OauthV2->userinfo->get(); 
            
//             $tbl_data['id'] = $this->Home_Model->get_tbl();
            
//             $this->Home_Model->googleLogin($data, $tbl_data);
            
//             $session_data = array(
//                     'username' => $data['name'],
//                     'email' => $data['email'],
//                     'name' => $data['name'],
//                     'usertype'=> 'Customer',

//                     );
//                     $this->session->set_userdata('logged_in', $session_data['name']);
//                     $this->session->set_userdata('usertype', $session_data['usertype']);
//             $this->session->set_flashdata('success', ' '.$this->session->userdata('logged_in').' You Are successfully Login');
//         } 
// 		else 
// 		{
//             $googleURL = $google_Client->createAuthUrl();
// 		    header("Location: $googleURL");
//             exit;
//         }
//         redirect(base_url());
// 	}
    
// 	public function logout() {
//         $sess_array = array('username' => '');
//         $this->session->unset_userdata('logged_in', $sess_array);
//         redirect(base_url());
//     }
//     public function load_style(){
        
//         $this->load->view('load_style');
//     }
//     public function load_script(){
//         $data['js'] =  [
//                 'validate'   =>'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js',
//                 'sweetjslink'   =>'https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.all.min.js',
//                 'validation'  =>'https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js',
//                 'myvalidate' => 'https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/additional-methods.min.js'
                
//             ];
//         $this->load->view('load_script',$data);
//     }
    
   
}