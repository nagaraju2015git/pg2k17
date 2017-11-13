<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Shopper extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('admin_model');
		$this->load->model('home_model');
	}
	function access($data=array()){
		if($this->session->userdata('role') != $this->config->item('role_shopper')){
			redirect('home/signin');
		}
	}
	
	public function index()
	{		
		$this->access();
		$pageData['page'] = 'DASHBOARD';
		$pageData['pageTitle'] = 'Dashboard';		
		$pageData['data'] = $this->admin_model->getHeader('SHOPPER');
		$data['head'] = $this->load->view('shopper/templates/head',$pageData,true);
		$data['header'] = $this->load->view('shopper/templates/header',$pageData,true);
		$data['footer'] = $this->load->view('shopper/templates/footer',$pageData,true);		
		$data['reports'] = $this->admin_model->getReports('SHOPPER');
		$this->load->view('shopper/index',$data);
	}
	
	public function requests()
	{		
		$this->access();
		$pageData['page'] = 'NEW';
		$pageData['pageTitle'] = 'New Requests';
		$pageData['data'] = $this->admin_model->getHeader('SHOPPER');
		$data['head'] = $this->load->view('shopper/templates/head',$pageData,true);
		$data['header'] = $this->load->view('shopper/templates/header',$pageData,true);
		$data['footer'] = $this->load->view('shopper/templates/footer',$pageData,true);
		$data['requests'] = $this->admin_model->get_user_requests(array('type'=>'NEW'));
		//var_dump($data['requests']);exit();
		$this->load->view('shopper/requests',$data);
	}
	
	public function ongoing()
	{		
		$this->access();
		$pageData['page'] = 'ONGOING';
		$pageData['pageTitle'] = 'Ongoing Requests';
		$pageData['data'] = $this->admin_model->getHeader('SHOPPER');
		$data['head'] = $this->load->view('shopper/templates/head',$pageData,true);
		$data['header'] = $this->load->view('shopper/templates/header',$pageData,true);
		$data['footer'] = $this->load->view('shopper/templates/footer',$pageData,true);
		$data['requests'] = $this->admin_model->get_user_requests(array('type'=>'ONGOING','userID'=>$this->session->userdata('userID')));
		$this->load->view('shopper/requests_ongoing',$data);
	}
	
	public function completed()
	{		
		$this->access();
		$pageData['page'] = 'COMPLETED';
		$pageData['pageTitle'] = 'Completed Requests';
		$pageData['data'] = $this->admin_model->getHeader('SHOPPER');
		$data['head'] = $this->load->view('shopper/templates/head',$pageData,true);
		$data['header'] = $this->load->view('shopper/templates/header',$pageData,true);
		$data['footer'] = $this->load->view('shopper/templates/footer',$pageData,true);
		$data['requests'] = $this->admin_model->get_user_requests(array('type'=>'COMPLETED','userID'=>$this->session->userdata('userID')));
		$this->load->view('shopper/requests_completed',$data);
	}
	
	function request_details($id=0){
		$this->access();
		$pageData['page'] = 'REQUEST';
		$pageData['pageTitle'] = 'Completed Requests';
		$pageData['data'] = $this->admin_model->getHeader('SHOPPER');
		$data['head'] = $this->load->view('shopper/templates/head',$pageData,true);
		$data['header'] = $this->load->view('shopper/templates/header',$pageData,true);
		$data['footer'] = $this->load->view('shopper/templates/footer',$pageData,true);
		$data['request'] = $request = $this->admin_model->get_user_requests(array('type'=>'S','id'=>$id));
		$data['products'] = $this->admin_model->get_user_requests(array('type'=>'PRODUCTS','id'=>$id));
		$data['products_list'] = $this->admin_model->get_product(array('type'=>'SUGGEST','requestID'=>$id));
		//var_dump($data['request']);exit();	
		
		if($request){
			//Chat
			$chat['sendToUserID'] = $request->userID;
			$chat['sendToImage'] = base_url($this->config->item('default_image_user'));
			$chat['sendToName'] = $request->first_name.' '.$request->last_name;
			$data['chat'] = $this->load->view('chat',$chat,true);
			
			$this->load->view('shopper/requests_details',$data);
		}else{
			echo 'Invalid URL';
		}
	}
	
	function ins_upd_user_requests(){
		echo json_encode($this->admin_model->ins_upd_user_requests());
	}
	function get_user_requests(){
		$data = array(
			'type'=>$this->input->post('type'),
			'id'=>$this->input->post('id'),
			'userID'=>$this->input->post('userID')
		);
		echo json_encode($this->admin_model->get_user_requests($data));
	}
}