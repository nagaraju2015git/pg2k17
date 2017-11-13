<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller{
	
	function __construct(){
		parent::__construct();
		$this->load->model("home_model");
		$this->load->model("admin_model");
		$this->facebook = $this->fb_init();
	}
	function fb_init(){
		require_once APPPATH . 'libraries/Facebook/autoload.php';
		return new Facebook\Facebook([
			'app_id'     => $this->config->item('fb_app_id'),
			'app_secret' => $this->config->item('fb_secret_id'),
			'default_graph_version' => 'v2.4'
		]);
	}
	
	function facebook(){
		$helper = $this->facebook->getRedirectLoginHelper();
		if (isset($_GET['state'])) {
			$helper->getPersistentDataHandler()->set('state', $_GET['state']);
		}
		try {
		  $accessToken = $helper->getAccessToken();
		} catch(Facebook\Exceptions\FacebookResponseException $e) {
		  // When Graph returns an error
		  echo 'Graph returned an error: ' . $e->getMessage();
		  exit;
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
		  // When validation fails or other local issues
		  echo 'Facebook SDK returned an error: ' . $e->getMessage();
		  exit;
		}

		if (! isset($accessToken)) {
		  if ($helper->getError()) {
			header('HTTP/1.0 401 Unauthorized');
			echo "Error: " . $helper->getError() . "\n";
			echo "Error Code: " . $helper->getErrorCode() . "\n";
			echo "Error Reason: " . $helper->getErrorReason() . "\n";
			echo "Error Description: " . $helper->getErrorDescription() . "\n";
		  } else {
			header('HTTP/1.0 400 Bad Request');
			echo 'Bad request';
		  }
		  exit;
		}
			
		try {
		  // Returns a `Facebook\FacebookResponse` object
		  $response = $this->facebook->get('/me?fields=id,name,link,email,gender,first_name,last_name', $accessToken->getValue());
		} catch(Facebook\Exceptions\FacebookResponseException $e) {
		  echo 'Graph returned an error: ' . $e->getMessage();
		  exit;
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
		  echo 'Facebook SDK returned an error: ' . $e->getMessage();
		  exit;
		}

		$user = $response->getGraphUser();
		if(isset($user['id'])){
			if($user['id'] != '' && $user['id'] != NULL && $user['id'] != 0){
				$status = $this->home_model->facebook($user);
				if($status)redirect(base_url(),'refresh');
			}
		}
		echo 'Please contact administrator';
		exit;
	}
	
	function access($data=array()){
		if($this->session->userdata('role') == $this->config->item('role_admin')){
			redirect('admin');
		}
		if($this->session->userdata('role') == $this->config->item('role_shopper')){
			redirect('shopper');
		}
	}
	
	function save_push_id($id=""){
		$this->session->set_userdata('push_id',$id);
		redirect(base_url(),'refresh');
	}
	
	function index(){
	
		$this->access();
		$pageData['data'] = $this->home_model->getHeader();
		$data['head'] = $this->load->view('templates/head',$pageData,true);
		$data['header'] = $this->load->view('templates/header',$pageData,true);
		$data['footer'] = $this->load->view('templates/footer',$pageData,true);
		
		$data['slides'] = $this->home_model->getSlides();
		$data['banners'] = $this->home_model->getBanners();
		$data['sections'] = $this->home_model->getSections();
		$data['posts'] = $this->admin_model->get_post(array('type'=>'L'));
		$data['reviews'] = $this->admin_model->get_review(array('type'=>'L'));
		$data['fb_login_url'] = $this->facebook->getRedirectLoginHelper()->getLoginUrl(base_url('home/facebook'), array('email'));
		//var_dump($data['posts']);exit();
		$this->load->view('index',$data);
	}
	function signin(){
		$this->access();
		if($this->session->userdata('logged_in') == true)redirect('home');
		$pageData['data'] = $this->home_model->getHeader();
		$data['head'] = $this->load->view('templates/head',$pageData,true);
		$data['header'] = $this->load->view('templates/header',$pageData,true);
		$data['footer'] = $this->load->view('templates/footer',$pageData,true);
		$data['fb_login_url'] = $this->facebook->getRedirectLoginHelper()->getLoginUrl(base_url('home/facebook'), array('email'));
		$data['page'] = $this->admin_model->get_page(array('type'=>'SP'));
		$this->load->view('login',$data);
	}
	function signup(){
		$this->access();
		if($this->session->userdata('logged_in') == true)redirect('home');
		$pageData['data'] = $this->home_model->getHeader();
		$data['head'] = $this->load->view('templates/head',$pageData,true);
		$data['header'] = $this->load->view('templates/header',$pageData,true);
		$data['footer'] = $this->load->view('templates/footer',$pageData,true);
		$this->load->view('register',$data);
	}
	function shopper(){
		$this->access();
		if($this->session->userdata('logged_in') == true)redirect('home');
		$pageData['data'] = $this->home_model->getHeader();
		$data['head'] = $this->load->view('templates/head',$pageData,true);
		$data['header'] = $this->load->view('templates/header',$pageData,true);
		$data['footer'] = $this->load->view('templates/footer',$pageData,true);
		$data['page'] = $this->admin_model->get_page(array('type'=>'SP'));
		$this->load->view('shopper_signup_landing',$data);
	}
	function shopper_signup(){
		$this->access();
		if($this->session->userdata('logged_in') == true)redirect('home');
		$pageData['data'] = $this->home_model->getHeader();
		$data['head'] = $this->load->view('templates/head',$pageData,true);
		$data['header'] = $this->load->view('templates/header',$pageData,true);
		$data['footer'] = $this->load->view('templates/footer',$pageData,true);
		$this->load->view('shopper_signup',$data);
	}
	function shopping_assistant(){
		$this->access();
		$pageData['data'] = $this->home_model->getHeader();
		$data['head'] = $this->load->view('templates/head',$pageData,true);
		$data['header'] = $this->load->view('templates/header',$pageData,true);
		$data['footer'] = $this->load->view('templates/footer',$pageData,true);
		$data['page'] = $this->admin_model->get_page(array('type'=>'SA'));
		$this->load->view('shopping_assistant',$data);
	}
	function ins_upd_shopper_request(){
		echo json_encode($this->home_model->ins_upd_shopper_request());
	}
	function login(){
		echo json_encode($this->home_model->login());
	}
	function register(){
		echo json_encode($this->home_model->register());
	}
	function logout(){
		$this->session->sess_destroy();
		redirect('home');
	}
	function profile(){
		$this->access();
		if($this->session->userdata('logged_in') == false)redirect('home/signin');
		$pageData['data'] = $this->home_model->getHeader();
		$data['head'] = $this->load->view('templates/head',$pageData,true);
		$data['header'] = $this->load->view('templates/header',$pageData,true);
		$data['footer'] = $this->load->view('templates/footer',$pageData,true);
		$data['user'] = $this->home_model->get_user(array('type'=>'S','userID'=>$this->session->userdata('userID')));
		//var_dump($data['user']);exit();
		$this->load->view('profile',$data);
	}
	function update_user(){
		echo json_encode($this->home_model->update_user());
	}
	function reset_password(){
		$this->access();
		if($this->session->userdata('logged_in') == false)redirect('home/signin');
		$pageData['data'] = $this->home_model->getHeader();
		$data['head'] = $this->load->view('templates/head',$pageData,true);
		$data['header'] = $this->load->view('templates/header',$pageData,true);
		$data['footer'] = $this->load->view('templates/footer',$pageData,true);
		$this->load->view('reset_password',$data);
	}
	function change_password(){
		echo json_encode($this->home_model->change_password());
	}
	function password_reset($auth_id = ''){
		
		$pageData['data'] = $this->home_model->getHeader();
		$data['head'] = $this->load->view('templates/head',$pageData,true);
		$data['header'] = $this->load->view('templates/header',$pageData,true);
		$data['footer'] = $this->load->view('templates/footer',$pageData,true);
		$data['user'] = $this->home_model->get_user(array('type'=>'CHECH_AUTH','auth_id'=>$auth_id));
		$data['auth_id'] = $auth_id;
		$this->load->view('forgot_password',$data);
	}
	function password_change(){
		echo json_encode($this->home_model->password_change());
	}
	function likes(){
		$this->access();
		if($this->session->userdata('logged_in') == false)redirect('home/signin');
		$pageData['data'] = $this->home_model->getHeader();
		$data['head'] = $this->load->view('templates/head',$pageData,true);
		$data['header'] = $this->load->view('templates/header',$pageData,true);
		$data['footer'] = $this->load->view('templates/footer',$pageData,true);
		$data['products'] = $this->home_model->get_likes(array('type'=>'L','userID'=>$this->session->userdata('userID')));
		$data['gifts'] = $this->home_model->get_user_products(array('type'=>'L','userID'=>$this->session->userdata('userID')));
		//var_dump($data['gifts']);exit();
		$this->load->view('likes',$data);
	}
	function profiles(){
		$this->access();
		if($this->session->userdata('logged_in') == false)redirect('home/signin');
		$pageData['data'] = $this->home_model->getHeader();
		$data['head'] = $this->load->view('templates/head',$pageData,true);
		$data['header'] = $this->load->view('templates/header',$pageData,true);
		$data['footer'] = $this->load->view('templates/footer',$pageData,true);
		$data['profiles'] = $this->home_model->get_profile(array('type'=>'L','userID'=>$this->session->userdata('userID')));
		$data['products'] = $this->home_model->get_profile(array('type'=>'PRODUCTS','userID'=>$this->session->userdata('userID')));
		//var_dump($data['profiles']);exit();
		$this->load->view('profiles',$data);
	}
	function get_profile(){
		$data = array(
			'type'=>$this->input->post('type'),
			'id'=>$this->input->post('id'),
			'userID'=>$this->input->post('userID')
		);
		echo json_encode($this->home_model->get_profile($data));
	}
	function get_product(){
		$data = array(
			'type'=>$this->input->post('type'),
			'id'=>$this->input->post('id'),
			'userID'=>$this->input->post('userID')
		);
		echo json_encode($this->home_model->get_product($data));
	}
	function get_gift_modal(){
		$data = array(
			'type'=>$this->input->post('type'),
			'id'=>$this->input->post('id'),
			'userID'=>$this->input->post('userID')
		);
		$data = $this->home_model->get_product($data);
		//var_dump($data);exit();
		echo $this->load->view('gift_template',$data);;
	}
	function requests(){
		$this->access();
		if($this->session->userdata('logged_in') == false)redirect('home/signin');
		$pageData['data'] = $this->home_model->getHeader();
		$data['head'] = $this->load->view('templates/head',$pageData,true);
		$data['header'] = $this->load->view('templates/header',$pageData,true);
		$data['footer'] = $this->load->view('templates/footer',$pageData,true);
		$data['requests'] = $this->admin_model->get_user_requests(array('type'=>'USER_REQUESTS','userID'=>$this->session->userdata('userID')));
		//var_dump($data['user']);exit();
		$this->load->view('requests',$data);
	}
	function request_details($id=0){
		$this->access();
		if($this->session->userdata('logged_in') == false)redirect('home/signin');
		$pageData['data'] = $this->home_model->getHeader();
		$data['head'] = $this->load->view('templates/head',$pageData,true);
		$data['header'] = $this->load->view('templates/header',$pageData,true);
		$data['footer'] = $this->load->view('templates/footer',$pageData,true);
		$data['request'] = $request = $this->admin_model->get_user_requests(array('type'=>'S','id'=>$id));
		$data['products'] = $this->admin_model->get_user_requests(array('type'=>'PRODUCTS','id'=>$id));
		//var_dump($data['user']);exit();
		
		if($request){
			//Chat
			$chat['sendToUserID'] = $request->shopper_id;
			$chat['sendToImage'] = base_url($this->config->item('default_image_user'));
			$chat['sendToName'] = $request->shopperName;
			$data['chat'] = $this->load->view('chat',$chat,true);
			
			$this->load->view('request_details',$data);
		}else{
			echo 'Invalid URL';
		}
	}
	
	function ins_upd_profile(){
		echo json_encode($this->home_model->ins_upd_profile());
	}
	function ins_upd_like(){
		echo json_encode($this->home_model->ins_upd_like());
	}
	function ins_upd_gift(){
		echo json_encode($this->home_model->ins_upd_gift());
	}
	function ins_upd_user_gift(){
		echo json_encode($this->admin_model->ins_upd_product());
	}
	function contact()
	{
		$data['menu'] = $this->home_model->getMenu();
		$data['header'] = $this->load->view('header',$data,true);
		$this->load->view('contact',$data);
	}
	function products($navigationSlug = "")
	{
		
		$this->access();
		
		if($navigationSlug == "")
		$navigationSlug = isset($_GET['slug']) ? $_GET['slug'] : NULL;
		$age = isset($_GET['age']) ? $_GET['age'] : NULL;
		$price = isset($_GET['price']) ? $_GET['price'] : NULL;
		$category = isset($_GET['category']) ? $_GET['category'] : NULL;
		$key = isset($_GET['key']) ? $_GET['key'] : NULL;
		$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
		$search = array(
			'type'=>'SEARCH',
			'navigationSlug' => $navigationSlug,
			'age' => $age,
			'price' => $price,
			'category' => $category,
			'key' => $key,
			'page' => $page
		);
		$data['navigationSlug'] = $navigationSlug;
		$data['age'] = $age;
		$data['price'] = $price;
		$data['category'] = $category;
		$data['page'] = $page;
		$pageData['search_key'] = $data['key'] = $key;
		$pageData['search_type'] = 'product';
		
		$pageData['data'] = $this->home_model->getHeader();
		$data['head'] = $this->load->view('templates/head',$pageData,true);
		$data['header'] = $this->load->view('templates/header',$pageData,true);
		$data['footer'] = $this->load->view('templates/footer',$pageData,true);
		
		$data['categories'] = $this->home_model->getCategories();
		$data['filters'] = $this->home_model->getFilters();
		$data['filterKey'] = $this->home_model->getFilterKey();
		$data['products'] = $this->home_model->getProducts($search);
		$search = array(
			'type'=>'PRODUCTS_COUNT',
			'navigationSlug' => $navigationSlug,
			'age' => $age,
			'price' => $price,
			'category' => $category,
			'key' => $key
		);
		$data['count'] = (int)$this->home_model->getProducts($search);
		$data['navigation'] = $this->home_model->getNavigationBySlug($navigationSlug);
		$navigationID = 0;$data['navigationSub'] = array();
		if(isset($data['navigation']->id)){$navigationID = $data['navigation']->id;
			$data['navigationSub'] = $this->admin_model->get_navigation(array('type'=>'SL','id'=>$navigationID));
		}
		//var_dump($data['navigationSub']);exit();
		$this->load->view('products',$data);
	}
	function users()
	{
		
		$this->access();
		if($this->session->userdata('logged_in') == false)redirect('home/signin');
		$key = isset($_GET['key']) ? $_GET['key'] : NULL;
		$pageData['search_key'] = $data['key'] = $key;
		$pageData['search_type'] = 'user';
		
		
		$pageData['data'] = $this->home_model->getHeader();
		$data['head'] = $this->load->view('templates/head',$pageData,true);
		$data['header'] = $this->load->view('templates/header',$pageData,true);
		$data['footer'] = $this->load->view('templates/footer',$pageData,true);
				
		$data['users'] = $this->home_model->get_profile(array('type'=>'USERS','key'=>$key));
		//var_dump($data['users']);exit();
		$this->load->view('users',$data);
	}
	function products_home($id="",$page = 1){
		$this->access();
		$section = $this->home_model->get_section(array("type"=>'S','id'=>$id));
		if($section){
			$pageData['data'] = $this->home_model->getHeader();
			$data['head'] = $this->load->view('templates/head',$pageData,true);
			$data['header'] = $this->load->view('templates/header',$pageData,true);
			$data['footer'] = $this->load->view('templates/footer',$pageData,true);
			$data['section'] = $section;
			$data['products'] = $this->home_model->get_section(array("type"=>"SP","id"=>$section->id,"page"=>$page));
			$data['count'] = (int)$this->home_model->get_section(array("type"=>"COUNT","id"=>$section->id));
			$data['page'] = $page;
			//var_dump($data['count']);exit();
			$this->load->view('products_home',$data);
		}else{
			redirect('home/products');
		}		
	}
	function user_profile($id=0)
	{
		$this->access();
		if($this->session->userdata('logged_in') == false)redirect('home/signin');
		$user = $this->home_model->get_user(array("type"=>'S','userID'=>$id));
		if($user){
			$pageData['data'] = $this->home_model->getHeader();
			$data['head'] = $this->load->view('templates/head',$pageData,true);
			$data['header'] = $this->load->view('templates/header',$pageData,true);
			$data['footer'] = $this->load->view('templates/footer',$pageData,true);
			$data['liked'] = $this->home_model->get_likes(array('type'=>'L','userID'=>$id));
			$data['profiles'] = $this->home_model->get_profile(array('type'=>'L','userID'=>$id));
			$data['products'] = $this->home_model->get_profile(array('type'=>'PRODUCTS','userID'=>$id));
			$data['user'] = $user;
			
			//var_dump($data['users']);exit();
			$this->load->view('user_profile',$data);
		}else{
			echo 'Invalid URL';
		}
	}
	function page($id=0)
	{
		$this->access();
		
		$page = $this->admin_model->get_page(array("type"=>'S','id'=>$id));
		if($page){
			$pageData['data'] = $this->home_model->getHeader();
			$data['head'] = $this->load->view('templates/head',$pageData,true);
			$data['header'] = $this->load->view('templates/header',$pageData,true);
			$data['footer'] = $this->load->view('templates/footer',$pageData,true);
			$data['page'] = $page;
			//var_dump($data['users']);exit();
			$this->load->view('page',$data);
		}else{
			echo 'Invalid URL';
		}
	}
	function test_email($email=""){
		if($email == "")$email = 'k.rajasekhar23@gmail.com';
	       //	echo json_encode($this->home_model->send_email($email,'Test mail','Test mail Content'));	
		$this->load->library('email');
                $this->email->from($this->config->item('admin_email'),'Painlessgift');
                $this->email->to($email);
                $this->email->subject("Test subject");
                $this->email->message("Test email");
                $status = $this->email->send();
                echo $this->email->print_debugger();exit();
	}
	function test_push($regID=""){
		if($regID == "")$regID = "cR4oVhcjSd8:APA91bFEX9wNBQjynAskLR2HAZvc8PCPEnwqGSkn6h2TbeMPnVEklcpotjDxwhAedcscSozRH2cB3_Mj9Kmc72lc9p8c2pfhVNHQu0z9ZstISO0w6VhxZcElIGroKGPVnUsxFuw4k-3o";
		echo json_encode($this->home_model->push_notification($regID,'Test Message'));	
	}
	
	function forgot_password(){
		echo json_encode($this->home_model->forgot_password());	
	}
	function createUser()
	{
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		//var_dump($email);exit();
		echo json_encode($this->home_model->createUser($email,$password));
	}
	
	function updMyAccountDet(){
		echo json_encode($this->home_model->updMyAccountDet());
	}
	function updatePassword(){
		echo json_encode($this->home_model->updatePassword());
	}
	function insGiftDet(){
		echo json_encode($this->home_model->insGiftDet());
	}
	function insProfile(){
		echo json_encode($this->home_model->insProfile());
	}
	function updateProfile(){
		echo json_encode($this->home_model->updateProfile());
	}
	function editProfile($id=""){
		echo json_encode($this->home_model->editProfile($id));
	}
	function removeProfile(){
		echo json_encode($this->home_model->removeProfile());
	}
	function getGiftDet(){
		echo json_encode($this->home_model->getGiftDet());
	}
	function insCustomProfileProducts(){
		echo json_encode($this->home_model->insCustomProfileProducts());
	}
	function removeProfileProduct(){
		echo json_encode($this->home_model->removeProfileProduct());
	}
	function insertLikedProducts(){
		echo json_encode($this->home_model->insertLikedProducts());
	}
	function searchProducts(){
		echo json_encode($this->home_model->searchProducts());
	}
	function ins_upd_user_answers(){
		echo json_encode($this->home_model->ins_upd_user_answers());
	}	
	function ins_upd_product_views(){
		echo json_encode($this->home_model->ins_upd_product_views());
	}	
	
	function get_chat(){
		$data = array(
			'type'=>$this->input->post('type'),
			'userID'=>$this->input->post('userID'),
			'sendTo'=>$this->input->post('sendTo')
		);
		echo json_encode($this->admin_model->get_chat($data));
	}
	function ins_upd_chat(){
		echo json_encode($this->admin_model->ins_upd_chat());
	}
	function send_chat_push(){
		$sendToUserID = $this->input->post('sendTo');
		$myUserID = $this->input->post('userID');
		$user = $this->home_model->get_user(array('type'=>'S','userID'=>$sendToUserID));
		if($user){
			if($user->push_enabled == 1){
				$regID = $user->appRegistationID;
				echo json_encode($this->home_model->push_notification($regID,'New message'));
			}else{
				echo 'Push Not Enabled';
			}
		}else{
			echo 'User not found';
		}
	}
	
}
?>
