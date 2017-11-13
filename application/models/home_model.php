<?php 
/**
*	Name: Home Model
*	Author: Axinovate Technologies LLP
*			info@axinovate.com
*
*	Created: 10 May 2017
*
*
*/

class Home_model extends CI_Model{
	public function __Construct(){
		parent:: __Construct();
		$this->load->model("admin_model");
		$this->user_id = (int)$this->session->userdata("userID");
	}
	
	/**
 * Method randStrGen for generating random string
 * @param int
 * @return string
 **/
	function randStrGen($len=5){
		$result = "";
		$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
		$charArray = str_split($chars);
		for($i = 0; $i < $len; $i++){
			$randItem = array_rand($charArray);
			$result .= "".$charArray[$randItem];
		}
		return 'r'.$result;
	}
	function getHeader(){
		$data['navigations'] = $this->db->query("select *,(SELECT COUNT(*) FROM tbl_navigation WHERE parent_id = n.id) AS childs from tbl_navigation n ORDER BY n.sortin_order")->result();
		$data['questions'] = $this->db->query("select *,(SELECT COUNT(*) FROM tbl_question_options WHERE qid = q.id) AS oCount from tbl_questionaire q ORDER BY q.sorting_order ASC")->result();
		$data['options'] = $this->db->query("select * from tbl_question_options")->result();
		//$data['notifications'] = $this->db->query("SELECT * FROM tbl_notification WHERE ((user_id = $this->user_id  OR (type = 'S_GLOBAL' && '".$this->session->userdata('role')."' = '".$this->config->item('role_shopper')."')) ORDER BY created_date DESC LIMIT 5")->result();
		$data['notifications'] = $this->db->query("SELECT * FROM tbl_notification WHERE user_id = $this->user_id AND type = 'INDIVIDUAL' ORDER BY created_date DESC LIMIT 5")->result();
		$data['shopper_page'] = $this->admin_model->get_page(array('type'=>'SA'));
		return $data;
	}
	
	function login()
	{
		 $retvalue = array();
		 $retvalue['status'] = false;
		 $email = $this->input->post('email');
		 $password = $this->input->post('password');
		
		 $user = $this->db->query("select * from tbl_user where email = '$email'")->row();
		 if($user){
			if(password_verify($password,$user->password)){			
				$userdata = array(
					 'userID' => $user->id,
					 'email' => $user->email,
					 'role' => $user->role,
					 'image' => $user->image,
					 'name' => $user->first_name.' '.$user->last_name,
					 'logged_in' => TRUE
				);
				$this->session->set_userdata($userdata);
				
				if($user->role == 'ADMIN')
					$url = base_url('admin');
				else
					$url = base_url('home');
				
				//Saving push notification ID
				$push_id = $this->session->userdata("push_id");
				$email = $user->email;
				if($push_id != '' && $push_id != null && $push_id){
					$this->db->query("UPDATE tbl_user SET appRegistationID = '' WHERE appRegistationID = '$push_id'");
					$this->db->query("UPDATE tbl_user SET appRegistationID = '$push_id' WHERE email = '$email'");
				}
				
				
				$retvalue['url'] = $url;
				$retvalue['message'] = "Success";
				$retvalue['status'] = true;
			}else{
				$retvalue['message'] = "Wrong password";
			}
		 }else{
			 $retvalue['message'] = "This email is not registered with us";
		 }
		 return $retvalue;
	}
	
	function register()
	{
		$retvalue = array();
		$retvalue['status'] = false;
		$name = $this->input->post('name');
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$private = $this->input->post('private') ? (int)$this->input->post('private') : 0;
		
		$password = password_hash($password, PASSWORD_DEFAULT);
				
		$image = base_url($this->config->item('default_image_user'));
		$user = $this->db->query("select * from tbl_user where email = '$email'")->row();
		if($user){
			$retvalue['message'] = "This email already exists.";
			return $retvalue;
		}
		$this->db->query("INSERT INTO tbl_user (email, password, role, image, private, created_date, modified_date, status) VALUES ( '$email', '$password', 'USER', '$image', $private, NOW(), NOW(), 'Active')");
		
		$user = $this->db->query("select * from tbl_user where email = '$email'")->row();
		if($user){
			
			$this->db->query("INSERT INTO tbl_custom_profiles (user_id, name, created_date, updated_date, date_for_gift, relation, reason, status) VALUES ('".$user->id."', 'me', NOW(), NOW(), NOW(), 'My Self', 'Painlessgift','Active')");			
			
			$userdata = array(
				'userID' => $user->id,
				'email' => $user->email,
				'image' => $user->image,
				'name' => $user->first_name.' '.$user->last_name,
				'logged_in' => TRUE
			);
			$this->session->set_userdata($userdata);
			$retvalue['message'] = "Success";
			$retvalue['status'] = true;
		}else{
			$retvalue['message'] = "Please try again later";
		}
		return $retvalue;
	}
	function facebook($user)
	{
		//var_dump($user);exit();
		$id = isset($user['id']) ? $user['id'] : 0;
		$first_name = isset($user['first_name']) ? $user['first_name'] : '';
		$last_name = isset($user['last_name']) ? $user['last_name'] : '';
		$gender = isset($user['gender']) ? $user['gender'] : '';
		$email = isset($user['email']) ? $user['email'] : '';
		if($email == '' || $email == NULL)return false;
		
		$image = base_url($this->config->item("default_image_user"));
		
		$user = $this->db->query("select * from tbl_user where email = '$email'")->row();
		if(!$user){
			$this->db->query("INSERT INTO tbl_user (first_name, last_name, email, role, image, provider, provider_id, created_date, modified_date, status) VALUES ('$first_name', '$last_name', '$email', 'USER', '$image', 'facebook', '$id', NOW(), NOW(), 'Active')");
		}
		$user = $this->db->query("select * from tbl_user where email = '$email'")->row();
		if($user){
			$userdata = array(
				'userID' => $user->id,
				'email' => $user->email,
				'image' => $user->image,
				'name' => $user->first_name.' '.$user->last_name,
				'logged_in' => TRUE
			);
			$this->session->set_userdata($userdata);
			return true;
		}
		return false;
	}
	function get_user($data){
		$type = isset($data['type']) ? $data['type'] : '';
		$userID = isset($data['userID']) ? (int)$data['userID'] : 0;
		$auth_id = isset($data['auth_id']) ? $data['auth_id'] : '';
		if($type == 'S'){
			return $this->db->query("SELECT * FROM tbl_user WHERE id=$userID")->row();
		}
		if($type == 'CHECH_AUTH'){
			return $this->db->query("SELECT * FROM tbl_user WHERE auth_id='$auth_id' AND modified_date > (NOW() - interval 60 minute)")->row();
		}		
	}
	function update_user(){
		$retvalue = array();
		$retvalue['status'] = false;
		$first_name = $this->input->post('first_name');
		$last_name = $this->input->post('last_name');
		$email = $this->input->post('email');
		$phone = $this->input->post('phone');
		$private = $this->input->post('private') ? (int)$this->input->post('private') : 0;
		$push_enabled = $this->input->post('push_enabled') ? (int)$this->input->post('push_enabled') : 0;
		$userID = $this->session->userdata("userID");
		
		//var_dump($_FILES['image']);
		
		if($_FILES['image']['name'] != ''){		
			$iu=$this->admin_model->image_upload($_FILES['image'],'assets/images/users/','user');
			if($iu['status'] == true)
				$image = $iu['path'];
			else
				return $iu;
		}else{
			$image = $this->input->post('uploaded_img');
		}
		if(@getimagesize($image) === false)
			$image = base_url($this->config->item('default_image_user'));
		
		$row = $this->db->query("SELECT * FROM tbl_user WHERE email='$email' AND id != $userID")->row();
		if($row){
			$retvalue['message'] = 'This email already exists';
			return $retvalue;
		}
		$this->db->query("UPDATE tbl_user SET first_name = '$first_name',last_name = '$last_name', email = '$email', phone = '$phone', image = '$image', private = '$private', push_enabled = '$push_enabled' WHERE id  = $userID");
		
		$userdata = array(
			'email' => $email,
			'image' => $image,
			'name' => $first_name.' '.$last_name,
		);
		$this->session->set_userdata($userdata);
		
		$retvalue['message'] = 'Profile updated successfully';
		$retvalue['status'] = true;
		return $retvalue;
		
	}
	function change_password(){
		$password = $this->input->post('password');
		$userID = $this->session->userdata("userID");
		$password = password_hash($password, PASSWORD_DEFAULT);
		$this->db->query("UPDATE tbl_user SET password = '$password' WHERE id  = $userID");
		$retvalue['message'] = 'Password changed successfully';
		$retvalue['status'] = true;
		return $retvalue;
	}
	function password_change(){
		$password = $this->input->post('password');
		$auth_id = $this->input->post('auth_id');
		$password = password_hash($password, PASSWORD_DEFAULT);
		$this->db->query("UPDATE tbl_user SET password = '$password',auth_id = NULL WHERE auth_id  = '$auth_id'");
		$retvalue['message'] = 'Password changed successfully';
		$retvalue['status'] = true;
		return $retvalue;
	}
	
	function get_likes($data){
		$type = isset($data['type']) ? $data['type'] : '';
		$userID = isset($data['userID']) ? (int)$data['userID'] : 0;
		$sessionUserID = (int)$this->session->userdata("userID");
		if($type == 'L'){
			return $this->db->query("SELECT p.*,(SELECT COUNT(*) FROM tbl_likes WHERE user_id = '$sessionUserID' AND product_id = p.id) AS liked  FROM tbl_likes l INNER JOIN tbl_product p ON p.id = l.product_id WHERE l.user_id=$userID")->result();
		}
	}
	
	function get_profile($data){
		$type = isset($data['type']) ? $data['type'] : '';
		$id = isset($data['id']) ? (int)$data['id'] : 0;
		$userID = isset($data['userID']) ? (int)$data['userID'] : 0;
		$key = isset($data['key']) ? $data['key'] : NULL;
		$sessionUserID = (int)$this->session->userdata("userID");
		if($type == 'S'){
			return $this->db->query("SELECT * FROM tbl_custom_profiles WHERE id=$id")->row();
		}
		if($type == 'L'){
			return $this->db->query("SELECT * FROM tbl_custom_profiles WHERE user_id=$userID")->result();
		}
		if($type == 'REMAINDER'){
			return $this->db->query("SELECT u.id,IF(u.first_name = 'NULL' OR IFNULL(first_name,'') = '','No Name',CONCAT(u.first_name,' ',u.last_name)) as name,u.email,u.appRegistationID,u.push_enabled, p.name AS profile_name,p.reason,p.relation,p.date_for_gift FROM tbl_custom_profiles p INNER JOIN tbl_user u ON u.id = p.user_id WHERE p.date_for_gift <= (NOW() + interval 3 day) AND p.date_for_gift >= NOW() AND IFNULL(p.remainder_mail,0) != 1")->result();
		}
		if($type == 'PRODUCTS'){
			return $this->db->query("SELECT pr.profile_id,pd.*,(SELECT COUNT(*) FROM tbl_likes WHERE user_id = '$sessionUserID' AND product_id = pd.id) AS liked FROM tbl_custom_profiles_products pr INNER JOIN tbl_custom_profiles p ON p.id = pr.profile_id INNER JOIN tbl_product pd ON pd.id = pr.product_id WHERE p.user_id=$userID")->result();
		}
		if($type == 'USERS'){
			$str = "SELECT DISTINCT u.id,IF(u.first_name = 'NULL' OR IFNULL(first_name,'') = '','No Name',CONCAT(u.first_name,' ',u.last_name)) as name,u.image FROM tbl_user u INNER JOIN tbl_custom_profiles p ON p.user_id AND u.id WHERE role = 'USER' AND private = 0 AND u.first_name != 'NULL' AND IFNULL(first_name,'') != '' ";
			if($key != NULL && $key != '')
				$str.=" AND (u.first_name LIKE '%$key%' OR u.last_name LIKE '%$key%') ";
			$str.=" ";
			return $this->db->query($str)->result();
		}
	}
	function ins_upd_shopper_request(){
		$type = $this->input->post('type');
		$first_name = $this->input->post('first_name');
		$last_name = $this->input->post('last_name');
		$email = $this->input->post('email');
		$phone = $this->input->post('phone');
		$gender = $this->input->post('gender');
		$address = $this->input->post('address');
		$city = $this->input->post('city');
		$country = $this->input->post('country');
		
		if($type =='INSERT'){
			$chk=$this->db->query("select *  from tbl_shopper_requests where email='$email'")->row();
			if(!$chk){
				$this->db->query("INSERT INTO tbl_shopper_requests(first_name,last_name,email,phone,gender,city,country,address,created_date,status) VALUES('$first_name','$last_name','$email','$phone','$gender','$city','$country','$address',now(),'New');");
				$retvalue['message'] = 'Request sent successfully';
				$retvalue['status'] = true;
			}else{
				$retvalue['message'] = 'Email already exists, choose a different email.';
				$retvalue['status'] = False;
		
			}
			return $retvalue;
		}
		
	}
	function ins_upd_profile(){
		$retvalue = array();
		$retvalue['status'] = false;
		$type = $this->input->post("type");
		$id = (int)$this->input->post("id");
		$name = $this->input->post("name");
		$reason = $this->input->post("reason");
		$date = date('Y-m-d',strtotime($this->input->post("date")));
		$relation = $this->input->post("relation");
		$userID = (int)$this->session->userdata("userID");
		
		if($type == 'INSERT'){
			$this->db->query("INSERT INTO tbl_custom_profiles (user_id, name, created_date, updated_date, date_for_gift, relation, reason, status) VALUES ($userID, '$name', NOW(), NOW(), '$date', '$relation', '$reason','Active'); ");
			$retvalue['message'] = 'Profile created successfully';
			$retvalue['status'] = true;
		}
		
		if($type == 'UPDATE'){
			$this->db->query("UPDATE tbl_custom_profiles SET name = '$name', updated_date = NOW(), date_for_gift = '$date', relation = '$relation', reason = '$reason', status = 'Active' WHERE id = $id");
			$retvalue['message'] = 'Profile updated successfully';
			$retvalue['status'] = true;
		}
		
		if($type == 'DELETE'){
			$this->db->query("DELETE FROM tbl_custom_profiles WHERE id = $id");
			$retvalue['message'] = 'Profile deleted successfully';
			$retvalue['status'] = true;
		}
		
		return $retvalue;
	}
	function get_user_products($data){
		$type = isset($data['type']) ? $data['type'] : '';
		$id = isset($data['id']) ? (int)$data['id'] : 0;
		$userID = isset($data['userID']) ? (int)$data['userID'] : 0;
		$sessionUserID = (int)$this->session->userdata("userID");
		if($type == 'L'){
			return $this->db->query("SELECT * FROM tbl_product WHERE created_by=$userID")->result();
		}
		if($type == 'ALL'){
			return $this->db->query("SELECT p.*,CONCAT(u.first_name,' ',u.last_name) AS username,u.email FROM tbl_product p INNER JOIN tbl_user u ON u.id = p.created_by")->result();
		}
		
	}
	function ins_upd_user_gift(){
		$retvalue = array();
		$retvalue['status'] = false;
		$type = $this->input->post("type");
		$id = (int)$this->input->post("id");
		$name = $this->input->post("name");
		$price = $this->input->post("price");
		$link = $this->input->post("link");
		$userID = (int)$this->session->userdata("userID");
		
		if($_FILES['image']['name'] != ''){		
			$iu=$this->admin_model->image_upload($_FILES['image'],'assets/images/products/','product');
			if($iu['status'] == true)
				$image = $iu['path'];
			else
				return $iu;
		}else{
			$image = $this->input->post('uploaded_img');
		}
		if(@getimagesize($image) === false)
			$image = base_url($this->config->item('default_image'));
		
		if($type == 'INSERT'){
			$this->db->query("INSERT INTO tbl_user_products (user_id, name, price, link, image, created_date, status) VALUES ($userID, '$name', '$price', '$link', '$image', NOW(), 'Active')");
			$retvalue['message'] = 'Gift created successfully';
			$retvalue['status'] = true;
		}
		
		if($type == 'UPDATE'){
			$this->db->query("UPDATE tbl_user_products SET name = '$name', price = '$price', link = '$link', image = '$image', status = 'Active' WHERE id = $id");
			$retvalue['message'] = 'Gift updated successfully';
			$retvalue['status'] = true;
		}
		
		if($type == 'DELETE'){
			$this->db->query("DELETE FROM tbl_user_products WHERE id = $id");
			$retvalue['message'] = 'Gift deleted successfully';
			$retvalue['status'] = true;
		}
		
		return $retvalue;
	}
	function ins_upd_like(){
		$id = (int)$this->input->post("id");
		$userID = (int)$this->session->userdata("userID");
		$row = $this->db->query("SELECT * FROM tbl_likes WHERE user_id = $userID AND product_id = $id")->row();
		if($row){
			$this->db->query("DELETE FROM tbl_likes WHERE user_id = $userID AND product_id = $id");
			return false;
		}else{
			$this->db->query("INSERT INTO tbl_likes (user_id, product_id) VALUES ($userID, $id)");
			return true;
		}
	}
	
	function get_product($data){
		$type = isset($data['type']) ? $data['type'] : '';
		$id = isset($data['id']) ? (int)$data['id'] : 0;
		$userID = $this->session->userdata("userID");
		if($type == 'S'){
			return $this->db->query("SELECT * FROM tbl_product WHERE id=$id")->row();
		}
		if($type == 'L'){
			return $this->db->query("SELECT * FROM tbl_product")->result();
		}
		if($type == 'GIFT'){
			$retvalue['product'] = $this->db->query("SELECT * FROM tbl_product WHERE id=$id")->row();
			$retvalue['profiles'] = $this->db->query("SELECT p.*,(SELECT COUNT(pr.product_id) FROM tbl_custom_profiles_products pr WHERE pr.product_id = $id AND pr.profile_id = p.id) AS selected FROM tbl_custom_profiles p WHERE p.user_id=$userID")->result();
			return $retvalue;
		}
	}
	
	function ins_upd_gift(){
		$id = $this->input->post('id');
		$productID = $this->input->post('productID');
		$row = $this->db->query("SELECT * FROM tbl_custom_profiles_products WHERE profile_id = $id AND product_id = $productID")->row();
		if($row){
			$this->db->query("DELETE FROM tbl_custom_profiles_products WHERE profile_id = $id AND product_id = $productID");
			return 0;
		}else{
			$this->db->query("INSERT INTO tbl_custom_profiles_products (profile_id, product_id) VALUES ($id, $productID)");
			return 1;
		}
	}
	
	function forgot_password(){
		$retvalue = array();
		$retvalue['status'] = false;
		$email = $this->input->post("email");
		$user = $this->db->query("SELECT * FROM tbl_user WHERE email = '$email'")->row();
		if($user){
			$auth_id = $this->db->query("SELECT UUID() AS auth_id")->row()->auth_id;
			$this->db->query("UPDATE tbl_user SET auth_id = '$auth_id',modified_date = NOW() WHERE id = ".$user->id);
			
			$to = $user->email;
			$subject = 'Password reset link';
			$url = base_url('home/password_reset/'.$auth_id);
			$message="Hi ".$user->first_name.' '.$user->last_name.",<br><br>";
			$message.="To reset your password, click on the link below (or copy and paste the URL into your browser):<br><a href=".$url.">".$url."</a><br><br>";
			$message.="Thanks,<br>Painlessgift Team."; 
			$this->send_email($to,$subject,$message);
			
			$retvalue['status'] = true;
			$retvalue['message'] = 'Reset password link has been sent successfully';
		}else{
			$retvalue['message'] = 'Email does not exist';
		}
		return $retvalue;
	}
	
	function getSlides()
	{
		 $query = $this->db->query("select id,image from tbl_slide WHERE slideType='slide'")->result();
		 mysqli_next_result($this->db->conn_id);
		 return $query;
	}
	function getMenu()
	 {
		 $query = $this->db->query("select * from tbl_navigation")->result();
		 mysqli_next_result($this->db->conn_id);
		 return $query;
	 }
	 function getBanners()
	 {
		 $query = $this->db->query("select * from tbl_slide  WHERE slideType='banner' LIMIT 2")->result();
		 mysqli_next_result($this->db->conn_id);
		 return $query;
	 }
	 function getSections(){
		$retvalue = array();
		$userID = $this->session->userdata("userID");
		$qry = $this->db->query("select * from tbl_section ORDER BY sortingOrder ASC")->result();
		foreach($qry as $r){
			$section = array();
			$section['id'] = $r->id;
			$section['name'] = $r->name;
			$section['products'] = $this->db->query("select p.*,(SELECT COUNT(*) FROM tbl_likes WHERE user_id = '$userID' AND product_id = p.id) AS liked from tbl_section_products s INNER JOIN tbl_product p ON p.id = s.product_id WHERE s.section_id = ".$r->id." LIMIT 20")->result();
			array_push($retvalue,$section);
		}
		return $retvalue;
	 }
	function get_section($data){
		$type = isset($data['type']) ? $data['type'] : '';
		$id = isset($data['id']) ? (int)$data['id'] : 0;
		$slug = isset($data['slug']) ? $data['slug'] : 0;
		$page = isset($data['page']) ? $data['page'] : 1;
		$userID = $this->session->userdata("userID");
		
		if($type == 'S'){
			return $this->db->query("SELECT * from tbl_section WHERE id = $id")->row();
		}
		if($type == 'SP'){
			if($page <= 0)
			$page = 1;
			$start = (int)((int)($page-1) * $this->config->item("default_items"));	
			return $this->db->query("SELECT p.*,(SELECT COUNT(*) FROM tbl_likes WHERE user_id = '$userID' AND product_id = p.id) AS liked from tbl_section_products s INNER JOIN tbl_product p ON p.id = s.product_id WHERE s.section_id = $id LIMIT ".$start.",".$this->config->item("default_items"))->result();
		}
		if($type == 'COUNT'){
			return $this->db->query("SELECT COUNT(*) as pCount FROM tbl_section_products s WHERE s.section_id = $id")->row()->pCount;
		}
	}
	 function getTopRated()
	 {
		 $query = $this->db->query("select * from tbl_product")->result();
		 mysqli_next_result($this->db->conn_id);
		 return $query;
	 }
	 function getTopSellers()
	 {
		 $query = $this->db->query("select * from tbl_product LIMIT 4")->result();
		 mysqli_next_result($this->db->conn_id);
		 return $query;
	 } 
	 function getNewProducts()
	 {
		 $query = $this->db->query("select * from tbl_product order by name asc limit 4")->result();
		 mysqli_next_result($this->db->conn_id);
		 return $query;
	 }
	 function getFeaturedProducts()
	 {
		 $query = $this->db->query("select * from tbl_product LIMIT 4")->result();
		 mysqli_next_result($this->db->conn_id);
		 return $query;
	 } 
	 function getCategories()
	 {
		 $query = $this->db->query("select * from tbl_category")->result();
		 mysqli_next_result($this->db->conn_id);
		 return $query;
	 }
	 function getFilters()
	 {
		 $query = $this->db->query("select * from tbl_filter")->result();
		 mysqli_next_result($this->db->conn_id);
		 return $query;
	 }
	 function getFilterKey()
	 {
		 $query = $this->db->query("select f.filterKey from tbl_filter f group by f.filterKey")->result();
		 mysqli_next_result($this->db->conn_id);
		 return $query;
	 }
	 function getProducts($data)
	 {
		$type = isset($data['type']) ? $data['type'] : '';
		$navigationSlug = isset($data['navigationSlug']) ? $data['navigationSlug'] : '';
		$category = isset($data['category']) ? $data['category'] : NULL;
		$age = isset($data['age']) ? $data['age'] : NULL;
		$price = isset($data['price']) ? $data['price'] : NULL;
		$key = isset($data['key']) ? $data['key'] : NULL;
		$page = isset($data['page']) ? (int)$data['page'] : 1;
		$userID = (int)$this->session->userdata("userID");
		
		$str = "SELECT *,(SELECT COUNT(*) FROM tbl_likes WHERE user_id = '$userID' AND product_id = p.id) AS liked FROM tbl_product p WHERE p.status = 'Active' AND p.source != 'User' ";
		if($type == 'PRODUCTS_COUNT'){
			$str = "SELECT COUNT(*) AS count FROM tbl_product p WHERE p.status = 'Active' AND p.source != 'User' ";
		}
		
		if($navigationSlug != NULL && $navigationSlug !=''){
			$query = $this->db->query("SELECT id FROM tbl_navigation n WHERE n.slug = '$navigationSlug' OR n.parent_id IN (SELECT id FROM tbl_navigation WHERE slug = '$navigationSlug')")->result();
			$ids = array();
			foreach($query as $r)array_push($ids,$r->id);
			$ids = implode(",",$ids);
			$str.=" AND p.id IN (SELECT product_id FROM tbl_navigation_products WHERE navigation_id IN ($ids)) ";
		}
		if($category != NULL && $category !=''){
			$str.=" AND p.category IN ($category) ";
		}
		if($age != NULL && $age !=''){
			$query = $this->db->query("SELECT * FROM tbl_filter WHERE id = $age")->row();
			if($query)
				$str.=" AND ((".$query->min_value." BETWEEN  p.min_age AND p.max_age) OR (".$query->max_value." BETWEEN  p.min_age AND p.max_age))";
		}
		if($price != NULL && $price !=''){
			$query = $this->db->query("SELECT * FROM tbl_filter WHERE id = $price")->row();
			if($query)
			$str.=" AND (p.price >= ".$query->min_value." AND p.price <= ".$query->max_value.")";
		}
		if($key != NULL && $key !=''){
			$str.=" AND p.name LIKE '%$key%'";
		}
		
		if($type == 'PRODUCTS_COUNT'){
			return $this->db->query($str)->row()->count;
		}
		if($page <= 0)
			$page = 1;
		$start = (int)((int)($page-1) * $this->config->item("default_items"));		
		$str.=" ORDER BY rand() LIMIT ".$start.",".$this->config->item("default_items");
		//echo $str;exit();
		return $this->db->query($str)->result();
		
		 
	 }
	function getNavigationBySlug($slug)
	{
		$query = $this->db->query("select * from tbl_navigation where slug='$slug'")->row();
		mysqli_next_result($this->db->conn_id);
		return $query;
	}
	
	 function getMyAccountDet()
	 {
		 $id = $this->session->userdata("userID");
		 $query = $this->db->query("select id,first_name,last_name,email,phone from tbl_user where id='".$id."'")->row();
		 mysqli_next_result($this->db->conn_id);
		 return $query;
	 }
	 function updMyAccountDet()
	 {
		 $id = $this->session->userdata('userID');
		 $first_name = $this->input->post('firstName');
		 $last_name = $this->input->post('lastName');
		 $email = $this->input->post('email');
		 $phone = $this->input->post('phone');
		 $query = $this->db->query("update tbl_user set first_name='".$first_name."',last_name='".$last_name."',email='".$email."',phone='".$phone."' where id='".$id."'");
		 $data = $this->db->query("select * from tbl_user where id='".$id."'")->row();
		 $userdata = array(
					'userID'=>$data->id,
					'firstName'=>$data->first_name,
					'lastName'=>$data->last_name,
					'email'=>$data->email
		 );
		 $this->session->set_userdata($userdata);
		 mysqli_next_result($this->db->conn_id);
		 return $query;
	 }
	 function updatePassword()
	 {
		 $id = $this->session->userdata('userID');
		 $psw = $this->input->post('password');
		 $query = $this->db->query("update users set encrypted_password='".$psw."' where id='".$id."'");
		 mysqli_next_result($this->db->conn_id);
		 return $query;
	 }
	 function insGiftDet()
	 {
		 $userID = $this->session->userdata("userID");
		 $name = $this->input->post("giftname");
		 $price = $this->input->post("giftprice");
		 $link = $this->input->post("giftlink");
		 $file_name = $_FILES["giftimage"]["name"];
		 $file_tmp = $_FILES["giftimage"]["tmp_name"];
		 $path = 'assets/uploads/gift/image/';
		 $location = $path.$file_name;
		 move_uploaded_file($file_tmp, $location);
		 $query = $this->db->query("insert into tbl_gifts(name,price,link,image,created_at,updated_at,user_id)values('".$name."','".$price."','".$link."','".$location."',NOW(),NOW(),'".$userID."')");
		 mysqli_next_result($this->db->conn_id);
		 return $query;
	 }
	 function getGifts()
	 {
		 $id = $this->session->userdata("userID");
		 $query = $this->db->query("select * from tbl_gifts where user_id='".$id."'")->result();
		 mysqli_next_result($this->db->conn_id);
		 return $query;
	 }
	 function insProfile()
	 {
		 $id = $this->session->userdata("userID");
		 $name = $this->input->post("name");
		 $reason = $this->input->post("reason");
		 $datetimepicker = $this->input->post("datetimepicker");
		 $relation = $this->input->post("relation");
		 $query = $this->db->query("insert into tbl_custom_profiles(user_id,name,created_at,date_for_gift,relation,reason,updated_at,status)values('".$id."','".$name."',NOW(),'".$datetimepicker."','".$relation."','".$reason."',NOW(),'P')");
		 mysqli_next_result($this->db->conn_id);
		 return $query;
	 }
	 function getProfileDet()
	 {
		 $id = $this->session->userdata("userID");
		 $query = $this->db->query("select * from tbl_custom_profiles where user_id='".$id."' and status='P'")->result();
		 mysqli_next_result($this->db->conn_id);
		 return $query;
	 }
	 function updateProfile()
	 {
		 $userID = $this->session->userdata("userID");
		 $id = $this->input->post("id");
		 $query = $this->db->query("select * from tbl_custom_profiles where id='".$id."' and user_id='".$userID."'")->row();
		 mysqli_next_result($this->db->conn_id);
		 return $query;
	 }
	 function editProfile($id)
	 {
		 $userID = $this->session->userdata("userID");
		 //$id = $this->input->post("id");
		 $name = $this->input->post("name");
		 $reason = $this->input->post("reason");
		 $datetime = $this->input->post("datetime");
		 $relation = $this->input->post("relation");
		 //echo $id;exit;
		 $query = $this->db->query("update tbl_custom_profiles set name='".$name."',date_for_gift='".$datetime."',relation='".$relation."',reason='".$reason."' where id='$id' and user_id='".$userID."'");
		 mysqli_next_result($this->db->conn_id);
		 return $query;
	 }
	 function removeProfile()
	 {
		 $userID = $this->session->userdata("userID");
		 $id = $this->input->post("id");
		 $query = $this->db->query("update tbl_custom_profiles set status='F' where id='".$id."' and user_id='".$userID."' and status = 'P' ");
		 mysqli_next_result($this->db->conn_id);
		 return $query;
	 }
	 function getGiftDet()
	 {
		 $id = $this->input->post("id");
		 $userID = $this->session->userdata("userID");
		 $data['product'] = $this->db->query("select * from tbl_product where id='".$id."'")->row();
		 $data['profiles'] = $this->db->query("select *,(select count(*) from tbl_custom_profiles_products where custom_profile_id = p.id AND product_id = $id AND userID = '$userID') AS selected from tbl_custom_profiles p where p.user_id='".$userID."'")->result();
		 return $data;
	 }
	 function getProfileGifts()
	 {
		 $userID = $this->session->userdata("userID");
		 $query = $this->db->query("select * from tbl_product p inner join tbl_custom_profiles_products cpp on p.id=cpp.product_id where cpp.userID = '".$userID."' ")->result();
		 return $query;
	 }
	 function insCustomProfileProducts()
	 {
		 $userID = $this->session->userdata("userID");
		 $profileID = $this->input->post("profileID");
		 $productID = $this->input->post("productID");
		 $this->db->query("DELETE FROM tbl_custom_profiles_products WHERE custom_profile_id = $profileID AND product_id = $productID AND userID = $userID");
		 $query = $this->db->query("insert into tbl_custom_profiles_products(custom_profile_id,product_id,userID)values('".$profileID."','".$productID."','".$userID."')");
		 return $query;
	 }
	 function removeProfileProduct()
	 {
		 $userID = $this->session->userdata("userID");
		 $profileID = $this->input->post("profileID");
		 $productID = $this->input->post("productID");
		 $query = $this->db->query("delete from tbl_custom_profiles_products where custom_profile_id = $profileID");
		 return $query;
	 }
	 function insertLikedProducts()
	 {
		 $userID = $this->session->userdata("userID");
		 $productID = $this->input->post("product_id");
		 $qry  = $this->db->query("SELECT * FROM tbl_likes where user_id = '$userID' and product_id = '$productID'")->row();
		 if($qry){
			  $this->db->query("DELETE FROM tbl_likes WHERE user_id='$userID' and product_id='$productID'");
			  return false;
		 }else{
			  $this->db->query("insert into tbl_likes(user_id,product_id)values('$userID','$productID')");
			  return true;
		 }
	}
	function searchProducts()
	{
		 echo "ok"; exit();
		 $search = $this->input->post("searchkey");
		 echo $search;
		 $data['search'] = $this->db->query("select * from tbl_product where name LIKE '".$search."'%")->result();
		 return $data;
	}
	function ins_upd_user_answers(){
		$answers = (array)$this->input->post('answers');
		$title = (string)$this->input->post('title');
		$userID = $this->session->userdata('userID');
		
		$this->db->query("INSERT INTO tbl_user_requests(title, userID, created_date, updated_date, status) VALUES('$title', $userID,NOW(),NOW(),'New')");
		$id = $this->db->query("SELECT MAX(id) AS id FROM tbl_user_requests")->row()->id;
		foreach($answers as $a){
			if(is_array($a[1]))$a[1] = json_encode($a[1]);
			$this->db->query("INSERT INTO tbl_user_answers(userID,questionID,answer,requestID) VALUES($userID,".$a[0].",'".$a[1]."',$id)");
		}
		
		$content = $this->session->userdata('name').' has been submitted new request.';
		$this->db->query("INSERT INTO tbl_notification (user_id, subject, content, image, type, created_date, created_by, status) VALUES ($userID, '$content', '$content', '".$this->session->userdata('image')."', 'S_GLOBAL', NOW(), $userID, 'Active')");
		
		$user = $this->db->query("SELECT * FROM tbl_user WHERE id = $userID")->row();
		if($user){
			$to = $user->email;
			$subject = "Request has been submitted successfully";
			$message="Hi ".$user->first_name.' '.$user->last_name.",<br><br>";
			$message.="Your request for shopping assistance has been submitted successsfully. Our shopping assistent will contact you soon.<br><br>";
			$message.="Thanks,<br>Painlessgift Team."; 
			$this->send_email($to,$subject,$message);
		}		
		
		$retvalue['message'] = $content;
		$retvalue['status'] = true;
		return $retvalue;
	}
	function ins_upd_product_views(){
		$id = $this->input->post('id');
		$userID = $this->session->userdata("userID");
		$ip = $this->input->ip_address();
		$this->db->query("INSERT INTO tbl_product_views (ip, dateTime, userID, productID) VALUES ('$ip', NOW(), '$userID', '$id'); ");
		return true;
	}
	
	public function send_email($to,$subject,$message){
		$this->load->library('email');
		$this->email->from($this->config->item('admin_email'),'Painlessgift');
		$this->email->to($to);
		$this->email->subject($subject);
		$this->email->message($message);
		$status = $this->email->send();
		//echo $this->email->print_debugger();exit();
		return $status;
	}
	function push_notification($registrationIds,$message){
		#API access key from Google API's Console
		define( 'API_ACCESS_KEY', $this->config->item('fcm_key'));
		
		//$registrationIds = "cR4oVhcjSd8:APA91bFEX9wNBQjynAskLR2HAZvc8PCPEnwqGSkn6h2TbeMPnVEklcpotjDxwhAedcscSozRH2cB3_Mj9Kmc72lc9p8c2pfhVNHQu0z9ZstISO0w6VhxZcElIGroKGPVnUsxFuw4k-3o";
		
		#prep the bundle
		$msg = array(
			'body' 	=> $message,
			'title'	=> 'Painlessgift','icon' => base_url('assets/images/app_icon.png'),'sound' => 'default'
			);
		$fields = array(
			'registration_ids' => (array)$registrationIds,
			'notification'	=> $msg
		);
		
		$headers = array(
			'Authorization: key=' . API_ACCESS_KEY,
			'Content-Type: application/json'
		);
		
		#Send Reponse To FireBase Server	
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);	
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
		$result = curl_exec($ch);				
		if ($result === FALSE) {
		die('Curl failed: ' . curl_error($ch));
		}
		curl_close($ch);

		#Echo Result Of FireBase Server
		//echo $result;exit();
		return $result;
	}
	
}

?>