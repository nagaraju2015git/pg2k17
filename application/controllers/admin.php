<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('admin_model');
		$this->load->model('home_model');
	}
	function access($data=array()){
		if($this->session->userdata('role') != $this->config->item('role_admin')){
			redirect('home/signin');
		}
	}
	
	public function index()
	{		
		$this->access();
		$pageData['page'] = 'DASHBOARD';
		$pageData['pageTitle'] = 'Dashboard';
		$data['head'] = $this->load->view('admin/templates/head',$pageData,true);
		$data['header'] = $this->load->view('admin/templates/header',$pageData,true);
		$data['footer'] = $this->load->view('admin/templates/footer',$pageData,true);
		$data['reports'] = $this->admin_model->get_report(array('type'=>'DASHBOARD'));
		$data['chart'] = $this->admin_model->get_report(array('type'=>'CHART_TODAY'));
		$data['users'] = $this->admin_model->get_user(array('type'=>'DL'));
		$data['products'] = $this->admin_model->get_product(array('type'=>'DL'));
		//var_dump($data['chart']);exit();
		$this->load->view('admin/index',$data);
	}
	function get_report(){
		$type = $this->input->post('type');
		if($type == 'TODAY')
			$data = $this->admin_model->get_report(array('type'=>'CHART_TODAY'));
		if($type == 'WEEK')
			$data = $this->admin_model->get_report(array('type'=>'CHART_WEEK'));
		if($type == 'MONTH')
			$data = $this->admin_model->get_report(array('type'=>'CHART_MONTH'));
		if($type == 'YEAR')
			$data = $this->admin_model->get_report(array('type'=>'CHART_YEAR'));
		
		echo json_encode($data);
		
	}
	public function categories()
	{
		$this->access();
		$pageData['page'] = 'CATALOG';
		$pageData['pageTitle'] = 'Categories';
		$data['head'] = $this->load->view('admin/templates/head',$pageData,true);
		$data['header'] = $this->load->view('admin/templates/header',$pageData,true);
		$data['footer'] = $this->load->view('admin/templates/footer',$pageData,true);
		$data['categories'] = $this->admin_model->get_category(array('type'=>'L'));
		//var_dump($data['categories']);exit();
		$this->load->view('admin/categories',$data);
	}
	public function category($id=0)
	{
		$this->access();
		$pageData['page'] = 'CATALOG';
		$pageData['pageTitle'] = 'Categories';
		$data['head'] = $this->load->view('admin/templates/head',$pageData,true);
		$data['header'] = $this->load->view('admin/templates/header',$pageData,true);
		$data['footer'] = $this->load->view('admin/templates/footer',$pageData,true);
		$data['category'] = $this->admin_model->get_category(array('type'=>'S','id'=>$id));
		//$data['api_categories'] = $this->admin_model->get_category(array('type'=>'AL','id'=>$id));
		//var_dump($data['api_categories']);exit();
		$this->load->view('admin/category',$data);
	}
	public function products()
	{
		$this->access();
		$pageData['page'] = 'CATALOG';
		$pageData['pageTitle'] = 'Products';
		$data['head'] = $this->load->view('admin/templates/head',$pageData,true);
		$data['header'] = $this->load->view('admin/templates/header',$pageData,true);
		$data['footer'] = $this->load->view('admin/templates/footer',$pageData,true);
		$data['products'] = $this->admin_model->get_product(array('type'=>'L'));
		//var_dump($data['products']);exit();
		$this->load->view('admin/products',$data);
	}
	public function product($id=0)
	{
		$this->access();
		$pageData['page'] = 'CATALOG';
		$pageData['pageTitle'] = 'Products';
		$data['head'] = $this->load->view('admin/templates/head',$pageData,true);
		$data['header'] = $this->load->view('admin/templates/header',$pageData,true);
		$data['footer'] = $this->load->view('admin/templates/footer',$pageData,true);
		$data['product'] = $this->admin_model->get_product(array('type'=>'S','id'=>$id));
		$data['categories'] = $this->admin_model->get_category(array('type'=>'L'));
		$data['navigation'] = $this->admin_model->get_navigation(array('type'=>'L'));
		$qry = $this->admin_model->get_product(array('type'=>'NS','id'=>$id));
		$selectedNavigation = array();
		foreach($qry as $q)array_push($selectedNavigation,$q->navigation_id);
		$data['selectedNavigation'] = $selectedNavigation;
		//var_dump($data['selectedNavigation']);exit();
		$this->load->view('admin/product',$data);
	}
	public function update_api_products()
	{
		$this->access();
		$pageData['page'] = 'CATALOG';
		$pageData['pageTitle'] = 'Products';
		$data['head'] = $this->load->view('admin/templates/head',$pageData,true);
		$data['header'] = $this->load->view('admin/templates/header',$pageData,true);
		$data['footer'] = $this->load->view('admin/templates/footer',$pageData,true);
		$data['api'] = $this->admin_model->get_api(array('type'=>'L'));
		//var_dump($data['products']);exit();
		$this->load->view('admin/update_api_products',$data);
	}
	function updating_api_products(){
		echo json_encode($this->admin_model->updating_api_products());
	}
	public function api_products()
	{
		$this->access();
		$pageData['page'] = 'CATALOG';
		$pageData['pageTitle'] = 'Products';
		$data['head'] = $this->load->view('admin/templates/head',$pageData,true);
		$data['header'] = $this->load->view('admin/templates/header',$pageData,true);
		$data['footer'] = $this->load->view('admin/templates/footer',$pageData,true);
		$data['api'] = $this->admin_model->get_api(array('type'=>'L'));
		//var_dump($data['products']);exit();
		$this->load->view('admin/api_products',$data);
	}
	public function api()
	{
		$this->access();
		$pageData['page'] = 'API';
		$pageData['pageTitle'] = 'API List';
		$data['head'] = $this->load->view('admin/templates/head',$pageData,true);
		$data['header'] = $this->load->view('admin/templates/header',$pageData,true);
		$data['footer'] = $this->load->view('admin/templates/footer',$pageData,true);
		$data['api'] = $this->admin_model->get_api(array('type'=>'L'));
		$this->load->view('admin/api_list',$data);
	}
	public function api_config($id=0)
	{
		$this->access();
		$pageData['page'] = 'API';
		$pageData['pageTitle'] = 'API List';
		$data['head'] = $this->load->view('admin/templates/head',$pageData,true);
		$data['header'] = $this->load->view('admin/templates/header',$pageData,true);
		$data['footer'] = $this->load->view('admin/templates/footer',$pageData,true);
		$data['api'] = $this->admin_model->get_api(array('type'=>'S','id'=>$id));
		$data['api_url'] = $this->admin_model->get_api(array('type'=>'URL_S','id'=>$id));
		//var_dump($data['api_url']);exit();
		$this->load->view('admin/api',$data);
	}
	public function slides()
	{
		$this->access();
		$pageData['page'] = 'SLIDE';
		$pageData['pageTitle'] = 'Slides List';
		$data['head'] = $this->load->view('admin/templates/head',$pageData,true);
		$data['header'] = $this->load->view('admin/templates/header',$pageData,true);
		$data['footer'] = $this->load->view('admin/templates/footer',$pageData,true);
		$data['slides'] = $this->admin_model->get_slide(array('type'=>'L'));
		$this->load->view('admin/slides',$data);
	}
	public function slide_config($id=0)
	{
		$this->access();
		$pageData['page'] = 'SLIDE';
		$pageData['pageTitle'] = 'Slides List';
		$data['head'] = $this->load->view('admin/templates/head',$pageData,true);
		$data['header'] = $this->load->view('admin/templates/header',$pageData,true);
		$data['footer'] = $this->load->view('admin/templates/footer',$pageData,true);
		$data['slide'] = $this->admin_model->get_slide(array('type'=>'S','id'=>$id));
		$this->load->view('admin/slide_config',$data);
	}
	public function reviews()
	{
		$this->access();
		$pageData['page'] = 'REVIEW';
		$pageData['pageTitle'] = 'Reviews List';
		$data['head'] = $this->load->view('admin/templates/head',$pageData,true);
		$data['header'] = $this->load->view('admin/templates/header',$pageData,true);
		$data['footer'] = $this->load->view('admin/templates/footer',$pageData,true);
		$data['reviews'] = $this->admin_model->get_review(array('type'=>'L'));
		$this->load->view('admin/reviews',$data);
	}
	public function review_config($id=0)
	{
		$this->access();
		$pageData['page'] = 'REVIEW';
		$pageData['pageTitle'] = 'Posts List';
		$data['head'] = $this->load->view('admin/templates/head',$pageData,true);
		$data['header'] = $this->load->view('admin/templates/header',$pageData,true);
		$data['footer'] = $this->load->view('admin/templates/footer',$pageData,true);
		$data['review'] = $this->admin_model->get_review(array('type'=>'S','id'=>$id));
		$this->load->view('admin/review_config',$data);
	}
	public function posts()
	{
		$this->access();
		$pageData['page'] = 'POST';
		$pageData['pageTitle'] = 'Posts List';
		$data['head'] = $this->load->view('admin/templates/head',$pageData,true);
		$data['header'] = $this->load->view('admin/templates/header',$pageData,true);
		$data['footer'] = $this->load->view('admin/templates/footer',$pageData,true);
		$data['posts'] = $this->admin_model->get_post(array('type'=>'L'));
		$this->load->view('admin/posts',$data);
	}
	public function post_config($id=0)
	{
		$this->access();
		$pageData['page'] = 'POST';
		$pageData['pageTitle'] = 'Posts List';
		$data['head'] = $this->load->view('admin/templates/head',$pageData,true);
		$data['header'] = $this->load->view('admin/templates/header',$pageData,true);
		$data['footer'] = $this->load->view('admin/templates/footer',$pageData,true);
		$data['post'] = $this->admin_model->get_post(array('type'=>'S','id'=>$id));
		$this->load->view('admin/post_config',$data);
	}
	public function sections()
	{
		$this->access();
		$pageData['page'] = 'HOME';
		$pageData['pageTitle'] = 'Home Page Sections List';
		$data['head'] = $this->load->view('admin/templates/head',$pageData,true);
		$data['header'] = $this->load->view('admin/templates/header',$pageData,true);
		$data['footer'] = $this->load->view('admin/templates/footer',$pageData,true);
		$data['sections'] = $this->admin_model->get_section(array('type'=>'L'));
		
		$this->load->view('admin/sections',$data);
	}
	public function section_config($id=0)
	{
		$this->access();
		$pageData['page'] = 'HOME';
		$pageData['pageTitle'] = 'Home Page Section Configuration';
		$data['head'] = $this->load->view('admin/templates/head',$pageData,true);
		$data['header'] = $this->load->view('admin/templates/header',$pageData,true);
		$data['footer'] = $this->load->view('admin/templates/footer',$pageData,true);
		$data['section'] = $this->admin_model->get_section(array('type'=>'S','id'=>$id));
		$qry= $this->admin_model->get_section(array('type'=>'PRODUCTS','id'=>$id));
		$sproducts = array();
		foreach($qry as $r)
			array_push($sproducts,$r->product_id);
			
		$data['sproducts'] = $sproducts;
		$data['products'] = $this->admin_model->get_product(array('type'=>'L'));
		$this->load->view('admin/section_config',$data);
	}
	public function navigations()
	{
		$this->access();
		$pageData['page'] = 'NAVIGATION';
		$pageData['pageTitle'] = 'Navigation List';
		$data['head'] = $this->load->view('admin/templates/head',$pageData,true);
		$data['header'] = $this->load->view('admin/templates/header',$pageData,true);
		$data['footer'] = $this->load->view('admin/templates/footer',$pageData,true);
		$data['navigations'] = $this->admin_model->get_navigation(array('type'=>'L'));
		$this->load->view('admin/navigations',$data);
	}
	public function navigation_config($id=0)
	{
		$this->access();
		$pageData['page'] = 'SLIDE';
		$pageData['pageTitle'] = 'Slides List';
		$data['head'] = $this->load->view('admin/templates/head',$pageData,true);
		$data['header'] = $this->load->view('admin/templates/header',$pageData,true);
		$data['footer'] = $this->load->view('admin/templates/footer',$pageData,true);
		$data['navigation'] = $this->admin_model->get_navigation(array('type'=>'S','id'=>$id));
		$data['navigations'] = $this->admin_model->get_navigation(array('type'=>'P'));
		$data['pages'] = $this->admin_model->get_page(array('type'=>'L'));
		$this->load->view('admin/navigation_config',$data);
	}
	
	public function filters()
	{
		$this->access();
		$pageData['page'] = 'FILTER';
		$pageData['pageTitle'] = 'Filter List';
		$data['head'] = $this->load->view('admin/templates/head',$pageData,true);
		$data['header'] = $this->load->view('admin/templates/header',$pageData,true);
		$data['footer'] = $this->load->view('admin/templates/footer',$pageData,true);
		$data['filters'] = $this->admin_model->get_filter(array('type'=>'L'));
		$this->load->view('admin/filters',$data);
	}
	public function filter_config($id=0)
	{
		$this->access();
		$pageData['page'] = 'FILTER';
		$pageData['pageTitle'] = 'Filter Configuration';
		$data['head'] = $this->load->view('admin/templates/head',$pageData,true);
		$data['header'] = $this->load->view('admin/templates/header',$pageData,true);
		$data['footer'] = $this->load->view('admin/templates/footer',$pageData,true);
		$data['filter'] = $this->admin_model->get_filter(array('type'=>'S','id'=>$id));
		//$data['filter_keys'] = $this->admin_model->get_filter(array('type'=>'FK','id'=>$id));
		$this->load->view('admin/filter_config',$data);
	}
	
	public function users()
	{
		$this->access();
		$pageData['page'] = 'USER';
		$pageData['pageTitle'] = 'User List';
		$data['head'] = $this->load->view('admin/templates/head',$pageData,true);
		$data['header'] = $this->load->view('admin/templates/header',$pageData,true);
		$data['footer'] = $this->load->view('admin/templates/footer',$pageData,true);
		$data['users'] = $this->admin_model->get_user(array('type'=>'L'));
		$this->load->view('admin/users',$data);
	}
	public function user_config($id=0)
	{
		$this->access();
		$pageData['page'] = 'USER';
		$pageData['pageTitle'] = 'User Configuration';
		$data['head'] = $this->load->view('admin/templates/head',$pageData,true);
		$data['header'] = $this->load->view('admin/templates/header',$pageData,true);
		$data['footer'] = $this->load->view('admin/templates/footer',$pageData,true);
		$data['user'] = $this->admin_model->get_user(array('type'=>'S','id'=>$id));
		$this->load->view('admin/user_config',$data);
	}
	public function pages()
	{
		$this->access();
		$pageData['page'] = 'CMS';
		$pageData['pageTitle'] = 'Pages List';
		$data['head'] = $this->load->view('admin/templates/head',$pageData,true);
		$data['header'] = $this->load->view('admin/templates/header',$pageData,true);
		$data['footer'] = $this->load->view('admin/templates/footer',$pageData,true);
		$data['pages'] = $this->admin_model->get_page(array('type'=>'L'));
		$this->load->view('admin/pages',$data);
	}
	public function page_config($id=0)
	{
		$this->access();
		$pageData['page'] = 'CMS';
		$pageData['pageTitle'] = 'Page Configuration';
		$data['head'] = $this->load->view('admin/templates/head',$pageData,true);
		$data['header'] = $this->load->view('admin/templates/header',$pageData,true);
		$data['footer'] = $this->load->view('admin/templates/footer',$pageData,true);
		$data['page'] = $this->admin_model->get_page(array('type'=>'S','id'=>$id));
		$this->load->view('admin/page_config',$data);
	}
	
	public function shopping_assistant_page()
	{
		$this->access();
		$pageData['page'] = 'SA';
		$pageData['pageTitle'] = 'Page Configuration';
		$data['head'] = $this->load->view('admin/templates/head',$pageData,true);
		$data['header'] = $this->load->view('admin/templates/header',$pageData,true);
		$data['footer'] = $this->load->view('admin/templates/footer',$pageData,true);
		$data['page'] = $this->admin_model->get_page(array('type'=>'SA'));
		$this->load->view('admin/shopping_assistant',$data);
	}
	public function shopper_page()
	{
		$this->access();
		$pageData['page'] = 'SP';
		$pageData['pageTitle'] = 'Page Configuration';
		$data['head'] = $this->load->view('admin/templates/head',$pageData,true);
		$data['header'] = $this->load->view('admin/templates/header',$pageData,true);
		$data['footer'] = $this->load->view('admin/templates/footer',$pageData,true);
		$data['page'] = $this->admin_model->get_page(array('type'=>'SP'));
		$this->load->view('admin/shopper_page',$data);
	}
	
	public function user_products()
	{
		$this->access();
		$pageData['page'] = 'CMS';
		$pageData['pageTitle'] = 'Page Configuration';
		$data['head'] = $this->load->view('admin/templates/head',$pageData,true);
		$data['header'] = $this->load->view('admin/templates/header',$pageData,true);
		$data['footer'] = $this->load->view('admin/templates/footer',$pageData,true);
		$data['products'] = $this->home_model->get_user_products(array('type'=>'ALL'));
		$this->load->view('admin/user_products',$data);
	}
	public function questionaire()
	{
		$this->access();
		$pageData['page'] = 'CMS';
		$pageData['pageTitle'] = 'Pages List';
		$data['head'] = $this->load->view('admin/templates/head',$pageData,true);
		$data['header'] = $this->load->view('admin/templates/header',$pageData,true);
		$data['footer'] = $this->load->view('admin/templates/footer',$pageData,true);
		$data['questions'] = $this->admin_model->get_questions(array('type'=>'L'));
		$this->load->view('admin/questionaire',$data);
	}
		public function questionaire_config($id=0)
	{
		$this->access();
		$pageData['page'] = 'CMS';
		$pageData['pageTitle'] = 'Page Configuration';
		$data['head'] = $this->load->view('admin/templates/head',$pageData,true);
		$data['header'] = $this->load->view('admin/templates/header',$pageData,true);
		$data['footer'] = $this->load->view('admin/templates/footer',$pageData,true);
		$data['question'] = $this->admin_model->get_questions(array('type'=>'S','id'=>$id));
		$data['options'] = $this->admin_model->get_questions(array('type'=>'O','id'=>$id));
		$this->load->view('admin/questionaire_config',$data);
	}
	public function shopper_requests()
	{
		$this->access();
		$pageData['page'] = 'SHOPPER_REQUESTS';
		$pageData['pageTitle'] = 'Pages List';
		$data['head'] = $this->load->view('admin/templates/head',$pageData,true);
		$data['header'] = $this->load->view('admin/templates/header',$pageData,true);
		$data['footer'] = $this->load->view('admin/templates/footer',$pageData,true);
		$data['shoppers'] = $this->admin_model->get_shoppers(array('type'=>'L'));
		$this->load->view('admin/shopper_requests',$data);
	}
	public function user_requests()
	{
		$this->access();
		$pageData['page'] = 'USER_REQUESTS';
		$pageData['pageTitle'] = 'Pages List';
		$data['head'] = $this->load->view('admin/templates/head',$pageData,true);
		$data['header'] = $this->load->view('admin/templates/header',$pageData,true);
		$data['footer'] = $this->load->view('admin/templates/footer',$pageData,true);
		$data['requests'] = $this->admin_model->get_user_requests(array('type'=>'ALL'));
		$data['shoppers'] = $this->admin_model->get_user(array('type'=>'SHOPPERS'));
		$this->load->view('admin/user_requests',$data);
	}
	
	function request_details($id=0){
		$this->access();
		$pageData['page'] = 'USER_REQUESTS';
		$pageData['pageTitle'] = 'Pages List';
		$data['head'] = $this->load->view('admin/templates/head',$pageData,true);
		$data['header'] = $this->load->view('admin/templates/header',$pageData,true);
		$data['footer'] = $this->load->view('admin/templates/footer',$pageData,true);
		$data['request'] = $request = $this->admin_model->get_user_requests(array('type'=>'S','id'=>$id));
		$data['products'] = $this->admin_model->get_user_requests(array('type'=>'PRODUCTS','id'=>$id));
		$data['shoppers'] = $this->admin_model->get_user(array('type'=>'SHOPPERS'));
		if($request){
			//Chat
			$chat['sendToUserID'] = $request->userID;
			$chat['sendToImage'] = base_url($this->config->item('default_image_user'));
			$chat['sendToName'] = $request->first_name.' '.$request->last_name;
			$data['chat'] = $this->load->view('chat',$chat,true);
			
			$this->load->view('admin/request_details',$data);
		}else{
			echo 'Invalid URL';
		}
	}
	
	
	function ins_upd_page(){
		echo json_encode($this->admin_model->ins_upd_page());
	}
	function ins_upd_user(){
		echo json_encode($this->admin_model->ins_upd_user());
	}
	function ins_upd_filter(){
		echo json_encode($this->admin_model->ins_upd_filter());
	}
	function ins_upd_slide(){
		echo json_encode($this->admin_model->ins_upd_slide());
	}
	function ins_upd_post(){
		echo json_encode($this->admin_model->ins_upd_post());
	}
	function ins_upd_review(){
		echo json_encode($this->admin_model->ins_upd_review());
	}
	function ins_upd_navigation(){
		echo json_encode($this->admin_model->ins_upd_navigation());
	}
	function ins_upd_api(){
		echo json_encode($this->admin_model->ins_upd_api());
	}
	function ins_upd_category(){
		echo json_encode($this->admin_model->ins_upd_category());
	}
	function ins_upd_product(){
		echo json_encode($this->admin_model->ins_upd_product());
	}
	function get_product_from_api(){
		$apiID = (int)$this->input->post('apiID');
		$url = $this->input->post('url');
		$data['products'] = $this->admin_model->get_products_url($apiID,$url);
		$data['categories'] = $this->admin_model->get_category(array('type'=>'L'));
		$data['navigations'] = $this->admin_model->get_navigation(array('type'=>'NL'));
		//var_dump($data['products']);exit();
		echo $this->load->view("admin/api_product_template",$data,true);
	}
	function get_api(){
		$data = array(
			'type'=>$this->input->post('type'),
			'id'=>$this->input->post('id')
		);
		echo json_encode($this->admin_model->get_api($data));
	}
	function get_user_requests(){
		$data = array(
			'type'=>$this->input->post('type'),
			'id'=>$this->input->post('id'),
			'key'=>$this->input->post('key'),
			'shopperID'=>$this->input->post('shopper'),
			'status'=>$this->input->post('status')
		);
		echo json_encode($this->admin_model->get_user_requests($data));
	}
	function add_products(){
		var_dump($this->input->post('products'));
	}
	function validate_url(){
		echo json_encode($this->admin_model->validate_url());
	}
	function test_api(){
		echo json_encode($this->admin_model->validate_url());
	}
	function ins_upd_section(){
		echo json_encode($this->admin_model->ins_upd_section());
	}
	function get_api_response(){
		echo json_encode($this->admin_model->get_api_response());
	}
	function ins_upd_questions(){
		echo json_encode($this->admin_model->ins_upd_questions());
	}
	function ins_upd_shopper(){
		echo json_encode($this->admin_model->ins_upd_shopper());
	}
	function ins_upd_shopping_page(){
		echo json_encode($this->admin_model->ins_upd_shopping_page());
	}
	
	function profile_remainder(){
		$this->access();
		$pageData['page'] = 'PROFILE_REMAINDER';
		$pageData['pageTitle'] = 'Profile Remainder';
		$data['head'] = $this->load->view('admin/templates/head',$pageData,true);
		$data['header'] = $this->load->view('admin/templates/header',$pageData,true);
		$data['footer'] = $this->load->view('admin/templates/footer',$pageData,true);
		$this->load->view('admin/profile_remainder',$data);
	}
	function remainder(){
		echo json_encode($this->admin_model->remainder());
	}
	
}