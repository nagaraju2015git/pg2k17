<?php 
class Admin_model extends CI_Model{
		
	/**
	 * @return void
	 **/
	
	
	public function __construct(){
		//$this->load->model("home_model");
		$this->user_id = (int)$this->session->userdata("userID");
	}
	
	function getHeader($page){
		$data['notifications'] = $this->db->query("SELECT * FROM tbl_notification WHERE (user_id = $this->user_id  OR (type = 'S_GLOBAL' && '".$this->session->userdata('role')."' = '".$this->config->item('role_shopper')."')) ORDER BY created_date DESC LIMIT 5")->result();
		$data['reports'] = $this->getReports($page);
		return $data;
	}
	
	public function get_report($data){		
		$type = isset($data['type']) ? $data['type'] : '';
		
		if($type == 'DASHBOARD'){
			$retvalue['users_count'] = $this->db->query("SELECT COUNT(*) AS ucount FROM tbl_user -- WHERE created_date > (NOW() - interval 1 month)")->row()->ucount;
			$retvalue['products_count'] = $this->db->query("SELECT COUNT(*) AS pcount FROM tbl_product -- WHERE created_date > (NOW() - interval 1 month)")->row()->pcount;
			$retvalue['api_count'] = $this->db->query("SELECT COUNT(*) AS acount FROM tbl_api -- WHERE createdDate > (NOW() - interval 1 month)")->row()->acount;
			$retvalue['views_count'] = $this->db->query("SELECT COUNT(*) AS acount FROM tbl_product_views -- WHERE dateTime > (NOW() - interval 1 month)")->row()->acount;;
			return (object)$retvalue;
		}
		
		if($type == 'CHART_TODAY'){
			$retvalue['users_count'] = $this->db->query("SELECT COUNT(*) AS ucount FROM tbl_user WHERE created_date > (NOW() - interval 1 day)")->row()->ucount;
			$retvalue['products_count'] = $this->db->query("SELECT COUNT(*) AS pcount FROM tbl_product WHERE created_date > (NOW() - interval 1 day)")->row()->pcount;
			$retvalue['views_count'] = $this->db->query("SELECT COUNT(*) AS acount FROM tbl_product_views WHERE dateTime > (NOW() - interval 1 day)")->row()->acount;;
			return (object)$retvalue;
		}
		if($type == 'CHART_WEEK'){
			$retvalue['users_count'] = $this->db->query("SELECT COUNT(*) AS ucount FROM tbl_user WHERE created_date > (NOW() - interval 7 day)")->row()->ucount;
			$retvalue['products_count'] = $this->db->query("SELECT COUNT(*) AS pcount FROM tbl_product WHERE created_date > (NOW() - interval 7 day)")->row()->pcount;
			$retvalue['views_count'] = $this->db->query("SELECT COUNT(*) AS acount FROM tbl_product_views WHERE dateTime > (NOW() - interval 7 day)")->row()->acount;;
			return (object)$retvalue;
		}
		if($type == 'CHART_MONTH'){
			$retvalue['users_count'] = $this->db->query("SELECT COUNT(*) AS ucount FROM tbl_user WHERE created_date > (NOW() - interval 1 month)")->row()->ucount;
			$retvalue['products_count'] = $this->db->query("SELECT COUNT(*) AS pcount FROM tbl_product WHERE created_date > (NOW() - interval 1 month)")->row()->pcount;
			$retvalue['views_count'] = $this->db->query("SELECT COUNT(*) AS acount FROM tbl_product_views WHERE dateTime > (NOW() - interval 1 month)")->row()->acount;;
			return (object)$retvalue;
		}
		if($type == 'CHART_YEAR'){
			$retvalue['users_count'] = $this->db->query("SELECT COUNT(*) AS ucount FROM tbl_user WHERE created_date > (NOW() - interval 1 year)")->row()->ucount;
			$retvalue['products_count'] = $this->db->query("SELECT COUNT(*) AS pcount FROM tbl_product WHERE created_date > (NOW() - interval 1 year)")->row()->pcount;
			$retvalue['views_count'] = $this->db->query("SELECT COUNT(*) AS acount FROM tbl_product_views WHERE dateTime > (NOW() - interval 1 year)")->row()->acount;;
			return (object)$retvalue;
		}
	}
	public function get_user($data){		
		$type = isset($data['type']) ? $data['type'] : '';
		$id = isset($data['id']) ? $data['id'] : '';
		$email = isset($data['email']) ? $data['email'] : '';
		$user_name = isset($data['user_name']) ? $data['user_name'] : '';
		$authID = isset($data['authID']) ? $data['authID'] : '';
		$username = isset($data['username']) ? $data['username'] : '';
		
		if($type == 'EMAIL_CHECK'){
			return $this->db->query("SELECT * FROM tbl_user WHERE email = '$email'")->row();
		}
		if($type == 'USERNAME_CHECK'){
			return $this->db->query("SELECT * FROM tbl_user WHERE username = '$username'")->row();
		}
		if($type == 'CHECK_AUTH'){
			return $this->db->query("SELECT * FROM tbl_user WHERE authID = '$authID' AND modifiedDate > (NOW() - interval 24 hour)")->row();
		}
		if($type == 'S'){
			return $this->db->query("SELECT * FROM tbl_user WHERE id = '$id'")->row();
		}
		if($type == 'L'){
			return $this->db->query("SELECT * FROM tbl_user ORDER BY id DESC")->result();
		}
		if($type == 'DL'){
			return $this->db->query("SELECT * FROM tbl_user WHERE role='USER' ORDER BY id DESC LIMIT 5")->result();
		}
		if($type == 'SHOPPERS'){
			return $this->db->query("SELECT * FROM tbl_user WHERE role='".$this->config->item('role_shopper')."'")->result();
		}
		if($type == 'REQUESTS_L'){
			return $this->db->query("SELECT u.first_name,u.last_name,ur.* FROM tbl_user u INNER JOIN tbl_user_requests ur ON ur.userID = u.id ORDER BY u.created_date DESC")->result();
		}
	}
	
	function get_user_requests($data){
		$type = isset($data['type']) ? $data['type'] : '';
		$id = isset($data['id']) ? (int)$data['id'] : 0;
		$userID = isset($data['userID']) ? (int)$data['userID'] : 0;
		$key = isset($data['key']) ? $data['key'] : '';
		$shopperID = isset($data['shopperID']) ? $data['shopperID'] : 0;
		$status = isset($data['status']) ? $data['status'] : '';
		
		if($type == 'S'){
			return $this->db->query("SELECT u.first_name,u.last_name,ur.*,(SELECT CONCAT(first_name,' ',last_name) FROM tbl_user WHERE id = ur.shopper_id) AS shopperName FROM tbl_user u INNER JOIN tbl_user_requests ur ON ur.userID = u.id WHERE ur.id=$id")->row();
		}
		if($type == 'ALL_OLD'){
			return $this->db->query("SELECT u.first_name,u.last_name,ur.* FROM tbl_user u INNER JOIN tbl_user_requests ur ON ur.userID = u.id ORDER BY u.created_date DESC")->result();
		}
		if($type == 'ALL'){
			return $this->db->query("SELECT CONCAT(u.first_name,' ',u.last_name) AS userName,(SELECT CONCAT(first_name,' ',last_name) FROM tbl_user WHERE id = ur.shopper_id) AS shopperName,ur.*  FROM tbl_user_requests ur INNER JOIN tbl_user u ON u.id = ur.userID  ORDER BY ur.created_date DESC")->result();
		}
		if($type == 'ANSWERS'){
			$qry = $this->db->query("SELECT q.id as qid,q.question,a.answer,q.qtype FROM tbl_user_answers a INNER JOIN tbl_questionaire q ON q.id = a.questionID WHERE a.userID = $userID AND a.requestID = $id")->result();
			$qqry = $this->db->query("SELECT * FROM tbl_question_options")->result();
			foreach($qry as $q){
				if($q->qtype == 'Multiple Choice' || $q->qtype == 'Single Choice'){
					$answer = '';
					$answers = (array)json_decode($q->answer,true);
					foreach($qqry as $o){
						if($o->qid == $q->qid && in_array($o->id,$answers))$answer.=$o->name.',';						
					}
					$q->answer = substr($answer,0,-1);
				}
			} 
			return $qry;
		}
		if($type == 'NEW'){
			return $this->db->query("SELECT u.first_name,u.last_name,ur.* FROM tbl_user u INNER JOIN tbl_user_requests ur ON ur.userID = u.id WHERE ur.status='New' ORDER BY u.created_date DESC")->result();
		}
		if($type == 'ONGOING'){
			return $this->db->query("SELECT u.first_name,u.last_name,ur.* FROM tbl_user u INNER JOIN tbl_user_requests ur ON ur.userID = u.id WHERE ur.status='Ongoing' AND shopper_id = $userID ORDER BY u.created_date DESC")->result();
		}
		if($type == 'COMPLETED'){
			return $this->db->query("SELECT u.first_name,u.last_name,ur.* FROM tbl_user u INNER JOIN tbl_user_requests ur ON ur.userID = u.id WHERE ur.status='Completed' AND shopper_id = $userID ORDER BY u.created_date DESC")->result();
		}
		if($type == 'USER_REQUESTS'){
			return $this->db->query("SELECT *,(SELECT CONCAT(first_name,' ',last_name) FROM tbl_user WHERE id = ur.shopper_id) AS shopperName  FROM tbl_user_requests ur WHERE ur.userID = $userID ORDER BY ur.created_date DESC")->result();
		}
		if($type == 'PRODUCTS'){
			return $this->db->query("SELECT p.id,p.name,p.price,p.image,p.product_link,c.name as categoryName,urp.status,urp.id AS urpID FROM tbl_product p INNER JOIN tbl_category c ON c.id = p.category INNER JOIN tbl_user_request_products urp ON urp.product_id = p.id WHERE urp.request_id = $id ORDER BY urp.date_time DESC")->result();
		}
		if($type == 'SEARCH'){
			$str = "SELECT CONCAT(u.first_name,' ',u.last_name) AS userName,(SELECT CONCAT(first_name,' ',last_name) FROM tbl_user WHERE id = ur.shopper_id) AS shopperName,ur.*  FROM tbl_user_requests ur INNER JOIN tbl_user u ON u.id = ur.userID WHERE ur.status != '' ";
			
			if($key != '' && $key != null)
				$str.=" AND (u.first_name LIKE '%$key%' OR u.last_name LIKE '%$key%' OR u.created_date LIKE '%$key%') ";
			
			if($shopperID)
				$str.=" AND ur.shopper_id = $shopperID ";
			
			if($status)
				$str.=" AND ur.status = '$status' ";
			
			$str .= " ORDER BY ur.created_date DESC limit 50";
			$qry = $this->db->query($str)->result();
			$requests = array();$i=0;
			foreach($qry as $q){
				$requests[$i]['user'] = $q->userName;
				$requests[$i]['shopper'] = $q->shopperName ? $q->shopperName : '--';
				$requests[$i]['date_time'] = date('d M,y h:i A',strtotime($q->created_date));
				$requests[$i]['status'] = $q->status;
				$requests[$i]['id'] = $q->id;
				$i++;
			}
			return $requests;
		}
	}
	function ins_upd_user_requests(){
		$retvalue['status']= false;$retvalue['message']= 'Please try again later';
		
		$type=$this->input->post('type');
		$id=(int)$this->input->post('id');
		$shopperID=(int)$this->input->post('shopperID');
		$productID=(int)$this->input->post('productID');
		$urpID=(int)$this->input->post('urpID');
		
		if($type == 'CONFIRM'){
			$this->db->query("UPDATE tbl_user_requests SET shopper_id = $shopperID, status='Ongoing' WHERE id = $id");
			$retvalue['status'] = true;
			$retvalue['message'] = 'Request accepted successfully';
		}
		
		if($type == 'ASSIGN'){
			$this->db->query("UPDATE tbl_user_requests SET shopper_id = $shopperID, status='Ongoing' WHERE id = $id");
			$retvalue['status'] = true;
			$retvalue['message'] = 'Shopper assigned successfully';
		}
		
		if($type == 'CONFIRM' || $type == 'ASSIGN'){
			$user = $this->db->query("SELECT u.* FROM tbl_user u INNER JOIN tbl_user_requests ur ON ur.userID = u.id WHERE ur.id = $id")->row();
			if($user){
				$to = $user->email;
				$subject = "A Personal Shopper(PS) Assistant has been assigned for your request.";
				$message="Hi ".$user->first_name.' '.$user->last_name.",<br><br>";
				$message.="Thank you for showing interest in shopping assistent. Below are details,<br><br>";
				
				$shopper = $this->db->query("SELECT * FROM tbl_user WHERE id = $shopperID")->row();
				
				$message.="Shopper Name:<b>".$shopper->first_name.' '.$shopper->last_name."</b><br>";
				$message.="Request ID:<b>".$id."</b><br><br>";
				
				$message.="Thanks,<br>Painlessgift Team."; 
				$this->home_model->send_email($to,$subject,$message);				
				
				$content = $shopper->first_name.' '.$shopper->last_name.' assigned to your request.';
				$this->db->query("INSERT INTO tbl_notification (user_id, subject, content, image, type, created_date, created_by, status) VALUES ($user->id, '$content', '$content', '".$this->session->userdata('image')."', 'INDIVIDUAL', NOW(), ".$this->session->userdata('userID').", 'Active')");
				
				//Sending Push Notifications
				$appIds = array();
				if($user->push_enabled == 1)array_push($appIds,$user->appRegistationID);
				if(count($appIds) > 0){
					$this->home_model->push_notification($appIds,'A Personal Shopper(PS) Assistant has been assigned for your request');
				}
				
			}	
		}
		
		if($type == 'COMPLETED'){
			$this->db->query("UPDATE tbl_user_requests SET status='Completed' WHERE id = $id");
			$retvalue['status'] = true;
			$retvalue['message'] = 'Request completed successfully';
		}
		
		if($type == 'SUGGEST'){
			$this->db->query("INSERT INTO tbl_user_request_products (request_id, product_id, suggested_by, date_time, status) VALUES ($id, $productID, $shopperID, NOW(), 'Suggested')");
			
			$users = $this->db->query("SELECT * FROM tbl_user WHERE id = (SELECT userID FROM tbl_user_requests WHERE id = $id LIMIT 1)");
			//Sending Push Notifications
			$appIds = array();
			foreach($users as $u)if($u->push_enabled == 1)array_push($appIds,$u->appRegistationID);
			if(count($appIds) > 0){
				$this->home_model->push_notification($appIds,'Your Personal Shopper has suggested a product');
			}
			
			$retvalue['status'] = true;
			$retvalue['message'] = 'Product suggested successfully';
		}
		
		if($type == 'ACCEPT_REJECT'){
			$status = 'Rejected';
			$retvalue['message'] = 'Product rejected successfully';
			$message = 'rejected';
			if($this->input->post('status') == 'Accept'){
				$status = 'Accepted';
				$message = 'accepted';
				$retvalue['message'] = 'Product accepted successfully';
			}
			$this->db->query("UPDATE tbl_user_request_products SET status = '$status' WHERE id = $urpID");
			
			$user = $this->db->query("SELECT u.*,ur.shopper_id FROM tbl_user u INNER JOIN tbl_user_requests ur ON ur.userID = u.id WHERE ur.id = $id")->row();
			if($user){				
				$shopper = $this->db->query("SELECT * FROM tbl_user WHERE id = $user->shopper_id")->row();				
				if($shopper){
					$content = $user->first_name.' '.$user->last_name.' '.$message.' your product.';
					$this->db->query("INSERT INTO tbl_notification (user_id, subject, content, image, type, created_date, created_by, status) VALUES ($shopper->id, '$content', '$content', '$shopper->image', 'INDIVIDUAL', NOW(), $user->id, 'Active')");
				}
			}	
			
			$retvalue['status'] = true;
		}
		
		return $retvalue;
	}
	
	function updating_api_products(){
		$retValue['status'] = false;
		$retValue['message'] = 'please try again later';
		$today = date('Ymd');
		
		$log_path = 'assets/log/product_update_'.$today.'.txt';
		$retValue['log_file'] = base_url($log_path);
		if(file_exists($log_path))rename($log_path,$log_path.mt_rand().'.txt');
		
		if(file_exists($log_path))
			write_file($log_path, "\n\n\n\n", 'a');
		
		$apiID = (int)$this->input->post("apiID");
		$api = $this->db->query("SELECT * FROM tbl_api WHERE id = $apiID")->row();
		if($api){
			
			$content = "Products updation started...".PHP_EOL;
			$content .="User : ".$this->session->userdata('name').PHP_EOL;
			$content .="User ID : ".$this->session->userdata('userID').PHP_EOL;
			$content .="Date : ".date('d M Y h:i A').PHP_EOL;
			$content .="===========================================".PHP_EOL;
			write_file($log_path, $content, 'a');
			
			$breakCheck = 0;$temp = 0;$successCount = 0;
			
			$products = $this->db->query("SELECT * FROM tbl_product WHERE apiID = $apiID AND modified_date < (NOW() - interval 30 minute)")->result();
			foreach($products as $p){
				
				if($api->aws == 1){
					$url = $this->aws_signed_url($p->api_product_id,$api->apiKey,$api->secret_key);
				}else{
					$url = str_replace("xxxxxx", $p->api_product_id, $api->updateUrl);
				}
				$result = $this->get_products_url($apiID,$url,"UPDATE");
				
				if(isset($result['products'][0]->id)){
					$product = $result['products'][0];
					if($product->id == $p->api_product_id){
						$id = $product->id;
						$name = $product->name;
						$image = $product->image;
						$price = $product->price;
						$offer_price = $product->offer_price;
						$url = $product->url;
						
						$temp = (float)preg_replace("/[^0-9,\.]/", "", $product->price);
						$temp1 = (float)preg_replace("/[^0-9,\.]/", "", $product->offer_price);
						$price = $product->price;
						if($temp1 != 0 && $temp1 < $temp)
							$price = $product->offer_price;
						
						$this->db->query("UPDATE tbl_product SET name='$name', price = '$price', image = '$image', product_link = '$url', modified_date = NOW() WHERE api_product_id = '$id'");
						
						$status ="Product ID : ".$p->id."\n";
						$status .="Product Name : ".$p->name."\n";
						
						$changed = 'No Update';
						if($name != $p->name || $price != $p->price || $image != $p->image){					
							$changed = '';
							$changed.= $name != $p->name ? 'Name,' : '';
							$changed.= $price != $p->price ? ' Price,' : '';
							$changed.= $image != $p->image ? ' Image,' : '';
							$changed= substr($changed,0,-1);
							$changed.=' updated';
							
							$this->sendUpdateNotificationToUser($p->id,$changed);
							
						}
						$status .="Status : ".$changed."\n";
						$status .="===========================================".PHP_EOL;
						write_file($log_path, $status, 'a');
					}else{
						$status ="Product ID : ".$p->id."\n";
						$status .="Product Name : ".$p->name."\n";
						$status .="Status : Invalid Data returned by API or Invalid Update API Configuration\n";
						$status .="===========================================".PHP_EOL;
						write_file($log_path, $status, 'a');
					}
					$breakCheck++;
					$successCount++;
				}else{
					$temp = $breakCheck;
					$status ="Product ID : ".$p->id."\n";
					$status .="Product Name : ".$p->name."\n";
					$status.="No data found or Invalid API configuration".PHP_EOL;
					$status .="===========================================".PHP_EOL;
					write_file($log_path, $status, 'a');
					if($breakCheck == 4 && $successCount == 0){
						$status ="Exit".PHP_EOL;
						write_file($log_path, $status, 'a');
						return $retValue;
						break;
					}
					if($breakCheck == $temp)
						$breakCheck++;
				}
			}
			
			if(count($products) == 0){
				$status ="There are no products to update or all products information is up to date.".PHP_EOL;
				write_file($log_path, $status, 'a');
			}else{
				$status = " ".PHP_EOL;
				$status ="=================== Completed ====================.".PHP_EOL;
				write_file($log_path, $status, 'a');
			}
			
		}else{
			$retValue['message'] = 'Invalid API';
		}
		return $retValue;
	}
	function aws_signed_url($id,$access_key_id,$secret_key){
				
		/* // Your Access Key ID, as taken from the Your Account page
		$access_key_id = "";

		// Your Secret Key corresponding to the above ID, as taken from the Your Account page
		$secret_key = ""; */

		// The region you are interested in
		$endpoint = "webservices.amazon.com";

		$uri = "/onca/xml";

		$params = array(
			"Service" => "AWSECommerceService",
			"Operation" => "ItemLookup",
			"AWSAccessKeyId" => $access_key_id,
			"AssociateTag" => "painlessgift-20",
			"ItemId" => $id,
			"IdType" => "ASIN",
			"ResponseGroup" => "Images,ItemAttributes,Offers"
		);

		// Set current timestamp if not set
		if (!isset($params["Timestamp"])) {
			$params["Timestamp"] = gmdate('Y-m-d\TH:i:s\Z');
		}

		// Sort the parameters by key
		ksort($params);

		$pairs = array();

		foreach ($params as $key => $value) {
			array_push($pairs, rawurlencode($key)."=".rawurlencode($value));
		}

		// Generate the canonical query
		$canonical_query_string = join("&", $pairs);

		// Generate the string to be signed
		$string_to_sign = "GET\n".$endpoint."\n".$uri."\n".$canonical_query_string;

		// Generate the signature required by the Product Advertising API
		$signature = base64_encode(hash_hmac("sha256", $string_to_sign, $secret_key, true));

		// Generate the signed URL
		return $request_url = 'http://'.$endpoint.$uri.'?'.$canonical_query_string.'&Signature='.rawurlencode($signature);
	}
	
	function sendUpdateNotificationToUser($pid,$changed=""){
		$users = $this->db->query("SELECT u.*,p.id AS product_id,p.name AS product_name,p.image AS product_image, p.product_link,p.price FROM tbl_likes l INNER JOIN tbl_user u ON u.id = l.user_id INNER JOIN tbl_product p ON p.id = l.product_id WHERE product_id = $pid")->result();
		foreach($users as $u){
			
			$product = array(
				'id'=>$u->product_id,
				'name'=>$u->product_name,
				'image'=>$u->product_image,
				'price'=>$u->price,
				'link'=>$u->product_link
			);
			
			$data['name'] = $u->first_name.' '.$u->last_name;
			$data['products'][] = (object)$product;
			$message = $this->load->view('email/product_update',$data,true);
			$this->home_model->send_email($u->email,'Products updated',$message);
		}
		
		//Sending Push Notifications
		$appIds = array();
		foreach($users as $u)if($u->push_enabled == 1)array_push($appIds,$u->appRegistationID);
		if(count($appIds) > 0){
			$this->home_model->push_notification($appIds,'Some products are updated in your profile');
		}
		
	}
	
	function reset_password(){
		$userID = $this->session->userdata("userID");
		$password = $this->input->post('password');
		$this->db->query("UPDATE tbl_user SET password = '$password' WHERE id = '$userID'" ); 
		return true;
	}
	public function login($userName,$password){
		$retvalue = array();
		$row = $this->db->query("SELECT * FROM tbl_user WHERE (email = '$userName' OR username = '$userName') AND password = '$password'")->row();
		if($row){
			$this->session->set_userdata('login',true);
			$this->session->set_userdata('userID',$row->id);
			$this->session->set_userdata('name',$row->firstName.' '.$row->lastName);
			$this->session->set_userdata('email',$row->email);
			$this->session->set_userdata('phone',$row->phone);
			$this->session->set_userdata('roleName',$row->role);
			if($row->role == 'ADMIN')
				$retvalue['url'] = base_url('admin');
			else if($this->session->userdata('previous_url'))
				$retvalue['url'] = $this->session->userdata('previous_url');
			else
				$retvalue['url'] = base_url();
			
			$retvalue['message'] = 'Logged in successfully';
			$retvalue['status'] = true;
		}else{
			$retvalue['message'] = 'Invalid Username or Password';
			$retvalue['status'] = false;
		}
		return $retvalue;
	}
	
	public function getDashboard($data){		
		$type="";$roleID="";$userID="";
		if(isset($data['type']))$type=$data['type'];
		
		if($type == 'REQUEST'){
			$data['total'] = $this->db->query("SELECT COUNT(*) as total FROM tbl_messages")->row()->total;
			$data['open'] = $this->db->query("SELECT COUNT(*) as open FROM tbl_messages WHERE status = 'Open'")->row()->open;
			$data['close'] = $this->db->query("SELECT COUNT(*) as close FROM tbl_messages WHERE status = 'Closed'")->row()->close;
			return $data;
		}
		if($type == 'BLOG'){
			$data['posts'] = $this->db->query("SELECT COUNT(*) as total FROM tbl_industries")->row()->total;
			$data['comments'] = $this->db->query("SELECT COUNT(*) as total FROM tbl_comments")->row()->total;
			return $data;
		}
		if($type == 'SUBSCRIBE'){
			$data['total'] = $this->db->query("SELECT COUNT(*) as total FROM tbl_subscriptions")->row()->total;
			return $data;
		}
	}
	
	function ins_upd_user(){
		$retvalue['status']= false;$retvalue['message']= 'Please try again later';
		
		$type=$this->input->post('type');
		$id=(int)$this->input->post('id');
		$first_name=$this->input->post('first_name');
		$last_name=$this->input->post('last_name');
		$email=$this->input->post('email');
		$phone=$this->input->post('phone');
		$gender=$this->input->post('gender');
		$address=$this->input->post('address');
		$country=$this->input->post('country');
		$city=$this->input->post('city');
		$password=$this->input->post('password');
		$password = password_hash($password, PASSWORD_DEFAULT);		
		$username=$this->input->post('username');
		$auth_id=$this->input->post('auth_id');
		$role=$this->input->post('role') ? $this->input->post('role') : 'USER';
		$status=$this->input->post('status') ? $this->input->post('status') : 'Active';
		
		if($type == "INSERT"){
			$user = $this->db->query("SELECT * FROM tbl_user WHERE email='$email'")->row();
			if(!$user){
				$this->db->query("INSERT INTO tbl_user (first_name, last_name, email, password, auth_id, role, phone, gender, city, country, address, created_date, modified_date, status) VALUES ('$first_name', '$last_name', '$email', '$password', '$auth_id', '$role', '$phone', '$gender', '$city', '$country', '$address', NOW(), NOW(), '$status'); ");
				
				$id = $this->db->query("SELECT MAX(id) as id FROM tbl_user")->row()->id;
				$retvalue['status']= true;
				$retvalue['message']= 'User created successfully';
			}else{
				$retvalue['status']= false;
				$retvalue['message']= 'Email already exist';
			}
		}
		
		if($type == "UPDATE"){
			
			$user = $this->db->query("SELECT * FROM tbl_user WHERE email='$email' AND id != $id")->row();
			if(!$user){
				$this->db->query("UPDATE tbl_user SET first_name = '$first_name', last_name = '$last_name', email = '$email',  role = '$role', phone = '$phone', gender = '$gender', city = '$city', country = '$country', address = '$address', modified_date = NOW(), status = '$status' WHERE id = $id ");
				$retvalue['status']= true;
				$retvalue['message']= 'User updated successfully';
			}else{
				$retvalue['status']= false;
				$retvalue['message']= 'Email already exist';
			}
			
		}
		
		if($type == "DELETE"){
			$this->db->query("DELETE FROM tbl_user WHERE id = $id");
			$retvalue['status']= true;
			$retvalue['message']= 'User deleted successfully';
		}
		return $retvalue;
				
		return $retvalue;
	}
	
	function register(){
		$retvalue['status']= false;$retvalue['message']= 'Please try again later';
		
		$fname=$this->input->post('fname');
		$lname=$this->input->post('lname');
		$email=$this->input->post('email');
		$phone=$this->input->post('phone');
		$company=$this->input->post('company');
		$country=$this->input->post('country');
		$newsletter=(int)$this->input->post('newsletter');
		$password=$this->input->post('password');
		$username=$this->input->post('username');
		$status=$this->input->post('status');
		$image = base_url($this->config->item('default_image'));
		$qry = $this->db->query("SELECT * FROM tbl_user WHERE email = '$email'")->row();		
		if(!$qry){
			$this->db->query("INSERT INTO tbl_user (firstName,lastName, email, password, username, phone, image, role, company, country,  newsletter, createdDate, status) VALUES ('$fname', '$lname', '$email', '$password', '$username','$phone', '$image', 'USER', '$company', '$country', '$newsletter', NOW(), 'Active')");
			$this->login($email,$password);
			
			$data['name'] = $fname.' '.$lname;
			$message = $this->load->view('email/register',$data,true);
			//$this->send_email($email,'Welcome to'.$this->config->item('project_title'),$message);
			
			$retvalue['status']= true;
			$retvalue['message']= 'Registered successfully';
		}else{
			$retvalue['status']= false;
			$retvalue['message']= 'Email already exist';
		}
				
		return $retvalue;
	}
	
	function ins_upd_product(){
		$retvalue['status']= false;$retvalue['message']= 'Please try again later';
		
		$type=$this->input->post('type');
		$id=(int) $this->input->post('id');
		$name=$this->input->post('name');
		$description=$this->input->post('description');
		$slug=$this->input->post('slug');
		$price=(float)$this->input->post('price');
		$product_link=$this->input->post('product_link');
		$min_age=(int)$this->input->post('min_age');
		$max_age=(int)$this->input->post('max_age');
		$gender=$this->input->post('gender');
		$category=$this->input->post('category');
		$apiID=(int)$this->input->post('apiID');
		$source=$this->input->post('source') ? $this->input->post('source') : 'Manual';
		$status=$this->input->post('status') ? $this->input->post('status') : 'Active';
		
		$userID = (int)$this->session->userdata("userID");
		
		if(isset($_FILES['image']['name'])){
			if($_FILES['image']['name'] != ''){		
				$iu=$this->admin_model->image_upload($_FILES['image'],'assets/images/products/','product');
				if($iu['status'] == true)
					$image = $iu['path'];
				else
					return $iu;
			}else{
				$image = $this->input->post('uploaded_img');
			}
		}
		if(!@file_get_contents($image))
			$image = base_url($this->config->item('default_image'));
		
		
		if($type == 'INSERT'){
			$this->db->query("INSERT INTO tbl_product (name, description, slug, price, image, product_link, min_age, max_age, gender, category, apiID, source, created_by, modified_by, created_date,modified_date,status) VALUES ('$name', '$description', '$slug', '$price', '$image', '$product_link', '$min_age', '$max_age', '$gender', '$category', $apiID, '$source', $userID, $userID, NOW(), NOW(),'$status')");
			$id = $this->db->query("SELECT MAX(id) as id FROM tbl_product")->row()->id;
			
			if($this->input->post('navigation')){
				$navigation = (array)$this->input->post('navigation');
				$this->db->query("DELETE FROM tbl_navigation_products WHERE product_id = $id");
				foreach($navigation as $n){
					$this->db->query("INSERT INTO tbl_navigation_products(navigation_id,product_id) VALUES($n,$id)");
				}
			}
			
			$retvalue['status']= true;
			$retvalue['message']= 'Product saved successfully';
		}
		
		if($type == 'UPDATE'){			
			
			$p = $this->db->query("SELECT * FROM tbl_product WHERE id = $id ")->row();
			if($name != $p->name || $price != $p->price || $image != $p->image){					
				$this->sendUpdateNotificationToUser($p->id);				
			}
			
			$this->db->query("UPDATE tbl_product SET name = '$name', description = '$description', slug = '$slug', price = '$price', image = '$image', product_link = '$product_link', min_age = '$min_age', max_age = '$max_age', gender = '$gender', category = '$category', modified_by=$userID, modified_date = NOW(), status = '$status' WHERE id = $id ");
			
			if($this->input->post('navigation')){
				$navigation = (array)$this->input->post('navigation');
				$this->db->query("DELETE FROM tbl_navigation_products WHERE product_id = $id");
				foreach($navigation as $n){
					$this->db->query("INSERT INTO tbl_navigation_products(navigation_id,product_id) VALUES($n,$id)");
				}
			}
			
			$retvalue['status']= true;
			$retvalue['message']= 'Product updated successfully';
		}
		
		if($type == 'DELETE'){			
			$this->db->query("DELETE FROM tbl_product WHERE id = $id");
			$retvalue['status']= true;
			$retvalue['message']= 'Product deleted successfully';
		}
		
		
		if($type == 'INSERT_API_PRODUCTS'){
			$error=0;
			$products = json_decode($this->input->post('products'));
			foreach($products as $p){
				$product = json_decode($p[4]);
				if($product){
					$name = str_replace("'","\\'",str_replace("\\","\\\\",($product->name)));
					$api_product_id = $product->id;
					$price = $product->price;
					$image = $product->image;
					$product_link = $product->url;
					$min_age = $p[2];
					$max_age = $p[3];
					$category = $p[0];
					$navigation = (array)$p[1];
					
					$product = $this->db->query("SELECT * FROM tbl_product WHERE api_product_id = '$api_product_id'")->row();
					if($product){
						$id = $product->id;
						$this->db->query("UPDATE tbl_product SET name = '$name', price = '$price', image = '$image', product_link = '$product_link', min_age = '$min_age', max_age = '$max_age', category = '$category', apiID = '$apiID',modified_by = $userID, modified_date = NOW(), status = 'Active' WHERE id = $id ");
					}else{
						$this->db->query("INSERT INTO tbl_product (api_product_id,name, price, image, product_link, min_age, max_age, category, apiID, source, created_by, modified_by, created_date,modified_date,status) VALUES ('$api_product_id','$name', '$price', '$image', '$product_link', '$min_age', '$max_age', '$category', '$apiID', '$source', $userID, $userID, NOW(), NOW(),'Active'); ");
						$id = $this->db->query("SELECT MAX(id) AS id FROM tbl_product")->row()->id;
					}
					$this->db->query("DELETE FROM tbl_navigation_products WHERE product_id = $id");
					foreach($navigation as $n){
						$this->db->query("INSERT INTO tbl_navigation_products(navigation_id,product_id) VALUES($n,$id)");
					}
				}else{
					$error++;
				}
			}
			if($error == 0){
				$retvalue['status']= true;
				$retvalue['message']= 'Product saved successfully';
			}else{
				$retvalue['message']= 'Product is not saved successfully';
			}
		}		
		
		return $retvalue;
	}
	
	function image_upload($file,$uploaddir='assets/images/products/',$id=""){
		$retvalue = array();
		$retvalue['status'] = false;
		$retvalue['path'] = base_url($this->config->item("placeholder.png"));
		$retvalue['message'] = 'Please try again later';
		
		$ext = end(explode(".", $file["name"]));
		$img_ext = $this->config->item("img_ext");
		if(!in_array($ext,$img_ext)){
			$retvalue['message'] = 'Invalid image file.Please upload file with these(jpg,png) extensions';
			return $retvalue;
		}
			
		$path=$uploaddir.$id.date('ymdHis').'.'.$ext;
		if(file_exists($path))
			unlink($path);
		if(move_uploaded_file($file["tmp_name"],$path)){
			$retvalue['status'] = true;
			$retvalue['path'] = base_url($path);
		}
		return $retvalue;
	}
	
	public function get_product($data){		
		
		$type = isset($data['type']) ? $data['type'] : '';
		$id = isset($data['id']) ? (int)$data['id'] : 0;
		$category_id = isset($data['category_id']) ? (int)$data['category_id'] : 0;
		$key = isset($data['key']) ? $data['key'] : '';
		$category = isset($data['category']) ? $data['category'] : '';
		$requestID = isset($data['requestID']) ? (int)$data['requestID'] : 0;
		
		if($type == 'S'){
			return $this->db->query("SELECT * FROM tbl_product WHERE id = '$id'")->row();
		}
		if($type == 'L'){
			return $this->db->query("SELECT *,(select name from tbl_api where id =p.apiID) as apiName FROM tbl_product p ORDER BY id DESC")->result();
		}
		if($type == 'NS'){
			return $this->db->query("SELECT * FROM tbl_navigation_products WHERE product_id = $id")->result();
		}
		
		if($type == 'SUGGEST'){
			return $this->db->query("SELECT p.id,p.name,p.price,p.image,p.product_link,c.name as categoryName FROM tbl_product p INNER JOIN tbl_category c ON c.id = p.category WHERE p.id NOT IN (SELECT product_id FROM tbl_user_request_products WHERE request_id = $requestID) ORDER BY id DESC LIMIT 50")->result();
		}
		
		
	}
	
	function ins_upd_category(){
		$retvalue['status']= false;$retvalue['message']= 'Please try again later';
		
		$type=$this->input->post('type');
		$id=(int)$this->input->post('id');
		$name=$this->input->post('name');
		$sorting=(int)$this->input->post('sorting');
		$description=$this->input->post('description');
		$status=$this->input->post('status') ? $this->input->post('status') : 'Active';
		$count = (int)$this->input->post('count');
		
		if($type == "INSERT"){
			$this->db->query("INSERT INTO tbl_category (name, description, sorting, createdDate, updatedDate, status) VALUES ( '$name', '$description', $sorting, NOW(), NOW(), '$status')");
			
			$id = $this->db->query("SELECT MAX(id) as id FROM tbl_category")->row()->id;
			/* for($i=0;$i<$count;$i++){
				$api_id = $this->input->post('api_'.$i);
				$api_category_id = (array)$this->input->post('category_'.$i);
				foreach($api_category_id as $acID){
				$this->db->query("INSERT INTO tbl_category_api (category_id, api_id, api_category_id) VALUES ($id, $api_id, '$acID')");
				}
			} */
			
			$retvalue['status']= true;
			$retvalue['message']= 'Category created successfully';
		}
		
		if($type == "UPDATE"){
			$this->db->query("UPDATE tbl_category SET name = '$name', description = '$description', sorting = $sorting, status = '$status', updatedDate = NOW() WHERE id = $id");
			/* $this->db->query("DELETE FROM tbl_category_api WHERE category_id = $id");
			for($i=0;$i<$count;$i++){
				$api_id = $this->input->post('api_'.$i);
				$api_category_id = (array)$this->input->post('category_'.$i);
				foreach($api_category_id as $acID){
				$this->db->query("INSERT INTO tbl_category_api (category_id, api_id, api_category_id) VALUES ($id, $api_id, '$acID')");
				}
			} */
			
			$retvalue['status']= true;
			$retvalue['message']= 'Category updated successfully';
		}
		
		if($type == "DELETE"){
			$this->db->query("DELETE FROM tbl_category WHERE id = $id");
			//$this->db->query("DELETE FROM tbl_category_api WHERE category_id = $id");
			$retvalue['status']= true;
			$retvalue['message']= 'Category deleted successfully';
		}
		return $retvalue;
	}
	
	public function get_category($data){		
		
		$type = isset($data['type']) ? $data['type'] : '';
		$id = isset($data['id']) ? $data['id'] : 0;
		
		if($type == 'S'){
			return $this->db->query("SELECT * FROM tbl_category WHERE id = '$id'")->row();
		}
		if($type == 'L'){
			return $this->db->query("SELECT * FROM tbl_category")->result();
		}
		if($type == 'AL'){
			
			$categories = array();
			
			$api = $this->db->query("SELECT * FROM tbl_api")->result();
			foreach($api as $a){
				
				$url = $a->categoryUrl;
								
				/* $cSession = curl_init(); 
				
				curl_setopt($cSession,CURLOPT_URL,$url);
				curl_setopt($cSession,CURLOPT_RETURNTRANSFER,true);
				curl_setopt($cSession,CURLOPT_HEADER, false); 
				
				$result=curl_exec($cSession);
				
				curl_close($cSession);
				
				$result = json_encode($result);
				if(!$result) */
				$result = file_get_contents($url);
				$result = json_decode($result);
				$category = array();
				$category['api_id'] = $a->id;
				$category['api'] = $a->name;
				$category['categories']['api_categoryies'] = $result->categories;
				$qry = $this->db->query("SELECT * FROM tbl_category_api WHERE api_id = ".$a->id." AND category_id = $id")->result(); 
				$sc=array();
				foreach($qry as $q){
					$sc[] = $q->api_category_id;
				}
				$category['categories']['selected_categories'] = $sc;
				$categories[] = $category;
			}
			//var_dump($sc);exit();
			return $categories;
		}
		
	}
	function ins_upd_api(){
		$retvalue['status']= false;$retvalue['message']= 'Please try again later';
		
		$type=$this->input->post('type');
		$id=(int)$this->input->post('id');
		$name=(string)$this->input->post('name');
		$apiKey=(string)$this->input->post('key');
		$productUrl=(string)$this->input->post('productUrl');
		$categoryUrl=(string)$this->input->post('categoryUrl');
		$updateUrl=(string)$this->input->post('updateUrl');
		
		$testUrl=(string)$this->input->post('testURL');
		$rootPath=(string)$this->input->post('rootPath');
		$id_depth=(string)$this->input->post('id_depth');
		$name_depth=(string)$this->input->post('name_depth');
		$image_depth=(string)$this->input->post('image_depth');
		$url_depth=(string)$this->input->post('url_depth');
		$price_depth=(string)$this->input->post('price_depth');
		$offer_price_depth=(string)$this->input->post('offer_price_depth');
		
		$updateTestUrl=(string)$this->input->post('updateTestUrl');
		$updateRootPath=(string)$this->input->post('updateRootPath');
		$update_id_depth=(string)$this->input->post('update_id_depth');
		$update_name_depth=(string)$this->input->post('update_name_depth');
		$update_image_depth=(string)$this->input->post('update_image_depth');
		$update_url_depth=(string)$this->input->post('update_url_depth');
		$update_price_depth=(string)$this->input->post('update_price_depth');
		$update_offer_price_depth=(string)$this->input->post('update_offer_price_depth');
		
		$desc=$this->input->post('desc');
		$aws=(int)$this->input->post('aws');
		$secret_key=(string)$this->input->post('secret_key');
		$status=$this->input->post('status') ? $this->input->post('status') : 'Active';
		$count = (int)$this->input->post('count');
		if($type == "INSERT"){
			$this->db->query("INSERT INTO tbl_api (name, apiKey, categoryUrl, productUrl, updateUrl, testUrl, rootPath, id_depth, name_depth, image_depth, url_depth, price_depth, offer_price_depth, updateTestUrl, updateRootPath, update_id_depth, update_name_depth, update_image_depth, update_url_depth, update_price_depth, update_offer_price_depth, aws, secret_key, createdDate, status) VALUES ('$name', '$apiKey', '$categoryUrl', '$productUrl', '$updateUrl', '$testUrl', '$rootPath', '$id_depth', '$name_depth', '$image_depth', '$url_depth', '$price_depth', '$offer_price_depth', '$updateTestUrl', '$updateRootPath', '$update_id_depth', '$update_name_depth', '$update_image_depth', '$update_url_depth', '$update_price_depth','$update_offer_price_depth', $aws, '$secret_key', NOW(), '$status'); ");
			
			$id = $this->db->query("SELECT MAX(id) as id FROM tbl_api")->row()->id;
			for($i=0;$i<$count;$i++){
				$name = $this->input->post('name_'.$i);
				$url = $this->input->post('url_'.$i);
				$this->db->query("INSERT INTO tbl_api_url (apiID, name, apiUrl) VALUES ($id, '$name', '$url')");
			}
			$retvalue['status']= true;
			$retvalue['message']= 'Api created successfully';
		}
		
		if($type == "UPDATE"){
			$this->db->query("UPDATE tbl_api SET name = '$name', apiKey = '$apiKey', categoryUrl = '$categoryUrl', productUrl = '$productUrl', updateUrl = '$updateUrl', testUrl = '$testUrl', rootPath = '$rootPath', id_depth = '$id_depth', name_depth = '$name_depth', image_depth = '$image_depth', url_depth = '$url_depth', price_depth = '$price_depth', offer_price_depth = '$offer_price_depth', updateTestUrl = '$updateTestUrl', updateRootPath = '$updateRootPath', update_id_depth = '$update_id_depth', update_name_depth = '$update_name_depth', update_image_depth = '$update_image_depth', update_url_depth = '$update_url_depth', update_price_depth = '$update_price_depth', update_offer_price_depth = '$update_offer_price_depth', aws=$aws, secret_key = '$secret_key', status = '$status' WHERE id = $id ");
			
			$this->db->query("DELETE FROM tbl_api_url WHERE apiID = $id");
			for($i=0;$i<$count;$i++){
				$name = $this->input->post('name_'.$i);
				$url = $this->input->post('url_'.$i);
				$this->db->query("INSERT INTO tbl_api_url (apiID, name, apiUrl) VALUES ($id, '$name', '$url')");
			}
			
			$retvalue['status']= true;
			$retvalue['message']= 'Api updated successfully';
		}
		
		if($type == "DELETE"){
			$this->db->query("DELETE FROM tbl_api WHERE id = $id");
			$this->db->query("DELETE FROM tbl_api_url WHERE apiID = $id");
			$retvalue['status']= true;
			$retvalue['message']= 'Api deleted successfully';
		}
		return $retvalue;
	}
	
	public function get_api($data){		
		
		$type = isset($data['type']) ? $data['type'] : '';
		$id = isset($data['id']) ? (int)$data['id'] : 0;
		
		if($type == 'S'){
			return $this->db->query("SELECT * FROM tbl_api WHERE id = '$id'")->row();
		}
		if($type == 'L'){
			return $this->db->query("SELECT * FROM tbl_api ORDER BY id DESC")->result();
		}
		if($type == 'URL_S'){
			return $this->db->query("SELECT * FROM tbl_api_url WHERE apiID = $id")->result();
		}		
	}
	
	function get_product_from_api($url){
		$products = array();
		$result = @file_get_contents($url);
		$result = json_decode($result);
		if(isset($result->products)){
			if(count($result->products) > 0){
				foreach($result->products as $p){
					$product = array();
					$product['id'] = $p->sku;
					$product['name'] = str_replace("'","",str_replace('"','',($p->name)));
					$product['price'] = $p->salePrice;
					if(@file_get_contents($p->image))
						$product['image'] = $p->image;
					else
						$product['image'] = base_url($this->config->item('default_image')); 
					$product['url'] = $p->url;
					$products[] = (object)$product;
				}
				
			}
		}
		//var_dump($products);exit();
		return $products;
	}
	
	function ins_upd_slide(){
		$retvalue['status']= false;$retvalue['message']= 'Please try again later';
		
		$type=$this->input->post('type');
		$id=(int)$this->input->post('id');
		$title=(string)$this->input->post('title');
		$slideType=(string)$this->input->post('slideType');
		$slideUrl=(string)$this->input->post('slideUrl');
		$description=(string)$this->input->post('description');
		$status=$this->input->post('status') ? $this->input->post('status') : 'Active';
		
		if($_FILES['image']['name'] != ''){		
			$iu=$this->admin_model->image_upload($_FILES['image'],'assets/images/slides/','slide');
			if($iu['status'] == true)
				$image = $iu['path'];
			else
				return $iu;
		}else{
			$image = $this->input->post('uploaded_img');
		}
		if(getimagesize($image) === false)
			$image = base_url($this->config->item('default_image'));
		
		if($type == "INSERT"){
			$this->db->query("INSERT INTO tbl_slide (image, title, description,slideType, slideUrl, created_date, updated_date, status) VALUES ('$image', '$title', '$description', '$slideType', '$slideUrl', NOW(), NOW(), '$status')");
			
			$id = $this->db->query("SELECT MAX(id) as id FROM tbl_slide")->row()->id;
			$retvalue['status']= true;
			$retvalue['message']= 'Slide created successfully';
		}
		
		if($type == "UPDATE"){
			$this->db->query("UPDATE tbl_slide SET title = '$title', description = '$description', slideType = '$slideType', slideUrl = '$slideUrl', image = '$image', updated_date = NOW(), status = '$status' WHERE id = $id");
			$retvalue['status']= true;
			$retvalue['message']= 'Slide updated successfully';
		}
		
		if($type == "DELETE"){
			$this->db->query("DELETE FROM tbl_slide WHERE id = $id");
			$retvalue['status']= true;
			$retvalue['message']= 'Slide deleted successfully';
		}
		return $retvalue;
	}
	
	public function get_slide($data){		
		
		$type = isset($data['type']) ? $data['type'] : '';
		$id = isset($data['id']) ? (int)$data['id'] : 0;
		
		if($type == 'S'){
			return $this->db->query("SELECT * FROM tbl_slide WHERE id = '$id'")->row();
		}
		if($type == 'L'){
			return $this->db->query("SELECT * FROM tbl_slide ORDER BY id DESC")->result();
		}	
	}
	function ins_upd_post(){
		$retvalue['status']= false;$retvalue['message']= 'Please try again later';
		
		$type=$this->input->post('type');
		$id=(int)$this->input->post('id');
		$title=(string)$this->input->post('title');
		$url=(string)$this->input->post('postUrl');
		$description=(string)$this->input->post('description');
		$status=$this->input->post('status') ? $this->input->post('status') : 'Active';
		
		if($_FILES['image']['name'] != ''){		
			$iu=$this->admin_model->image_upload($_FILES['image'],'assets/images/posts/','post');
			if($iu['status'] == true)
				$image = $iu['path'];
			else
				return $iu;
		}else{
			$image = $this->input->post('uploaded_img');
		}
		if(@file_get_contents($image) === false)
			$image = base_url($this->config->item('default_image'));
		
		if($type == "INSERT"){
			$this->db->query("INSERT INTO tbl_post (image, title, description,url, created_date, updated_date, status) VALUES ('$image', '$title', '$description', '$url', NOW(), NOW(), '$status')");
			
			$id = $this->db->query("SELECT MAX(id) as id FROM tbl_post")->row()->id;
			$retvalue['status']= true;
			$retvalue['message']= 'Post created successfully';
		}
		
		if($type == "UPDATE"){
			$this->db->query("UPDATE tbl_post SET title = '$title', description = '$description', url = '$url', image = '$image', updated_date = NOW(), status = '$status' WHERE id = $id");
			$retvalue['status']= true;
			$retvalue['message']= 'Post updated successfully';
		}
		
		if($type == "DELETE"){
			$this->db->query("DELETE FROM tbl_post WHERE id = $id");
			$retvalue['status']= true;
			$retvalue['message']= 'Post deleted successfully';
		}
		return $retvalue;
	}
	
	public function get_post($data){		
		
		$type = isset($data['type']) ? $data['type'] : '';
		$id = isset($data['id']) ? (int)$data['id'] : 0;
		
		if($type == 'S'){
			return $this->db->query("SELECT * FROM tbl_post WHERE id = '$id'")->row();
		}
		if($type == 'L'){
			return $this->db->query("SELECT * FROM tbl_post ORDER BY id DESC")->result();
		}	
	}
	function ins_upd_review(){
		$retvalue['status']= false;$retvalue['message']= 'Please try again later';
		
		$type=$this->input->post('type');
		$id=(int)$this->input->post('id');
		$name=(string)$this->input->post('name');
		$review=(string)$this->input->post('review');
		$status=$this->input->post('status') ? $this->input->post('status') : 'Active';
		
		if(isset($_FILES['image']['name'])){		
			$iu=$this->admin_model->image_upload($_FILES['image'],'assets/images/reviews/','review');
			if($iu['status'] == true)
				$image = $iu['path'];
			else
				return $iu;
		}else{
			$image = $this->input->post('uploaded_img');
		}
		if(@file_get_contents($image) === false)
			$image = base_url($this->config->item('default_user_image'));
		
		if($type == "INSERT"){
			$this->db->query("INSERT INTO tbl_review (image, name, review, created_date, updated_date, status) VALUES ('$image', '$name', '$review', NOW(), NOW(), '$status')");
			
			$id = $this->db->query("SELECT MAX(id) as id FROM tbl_review")->row()->id;
			$retvalue['status']= true;
			$retvalue['message']= 'Review created successfully';
		}
		
		if($type == "UPDATE"){
			$this->db->query("UPDATE tbl_review SET name = '$name', review = '$review', image = '$image', updated_date = NOW(), status = '$status' WHERE id = $id");
			$retvalue['status']= true;
			$retvalue['message']= 'Review updated successfully';
		}
		
		if($type == "DELETE"){
			$this->db->query("DELETE FROM tbl_review WHERE id = $id");
			$retvalue['status']= true;
			$retvalue['message']= 'Review deleted successfully';
		}
		return $retvalue;
	}
	
	public function get_review($data){		
		
		$type = isset($data['type']) ? $data['type'] : '';
		$id = isset($data['id']) ? (int)$data['id'] : 0;
		
		if($type == 'S'){
			return $this->db->query("SELECT * FROM tbl_review WHERE id = '$id'")->row();
		}
		if($type == 'L'){
			return $this->db->query("SELECT * FROM tbl_review ORDER BY id DESC")->result();
		}	
	}
	function ins_upd_section(){
		$retvalue['status']= false;$retvalue['message']= 'Please try again later';
		
		$type=$this->input->post('type');
		$id=(int)$this->input->post('id');
		$name=(string)$this->input->post('name');
		$order=(int)$this->input->post('order');
		$description=(string)$this->input->post('description');
		$products=(array)$this->input->post('products');
		$status=$this->input->post('status') ? $this->input->post('status') : 'Active';
		
		
		if($type == "INSERT"){
			$this->db->query("INSERT INTO tbl_section (name, sortingOrder, description, createdDate, status) VALUES ('$name', '$order', '$description', NOW(), '$status')");
			
			$id = $this->db->query("SELECT MAX(id) as id FROM tbl_section")->row()->id;
			$this->db->query("DELETE FROM tbl_section_products WHERE section_id = $id");
			foreach($products as $p){
				$this->db->query("INSERT INTO tbl_section_products (section_id, product_id) VALUES ($id, $p)");
			}
			$retvalue['status']= true;
			$retvalue['message']= 'Section created successfully';
		}
		
		if($type == "UPDATE"){
			$this->db->query("UPDATE tbl_section SET name = '$name', sortingOrder = '$order', description = '$description', status = '$status' WHERE id = $id");
			$this->db->query("DELETE FROM tbl_section_products WHERE section_id=$id");
			foreach($products as $p){
				$this->db->query("INSERT INTO tbl_section_products (section_id, product_id) VALUES ($id, $p)");
			}
			$retvalue['status']= true;
			$retvalue['message']= 'Section updated successfully';
		}
		
		if($type == "DELETE"){
			$this->db->query("DELETE FROM tbl_section WHERE id = $id");
			$this->db->query("DELETE FROM tbl_section_products WHERE section_id = $id");
			$retvalue['status']= true;
			$retvalue['message']= 'Section deleted successfully';
		}
		return $retvalue;
	}
	
	public function get_section($data){		
		
		$type = isset($data['type']) ? $data['type'] : '';
		$id = isset($data['id']) ? (int)$data['id'] : 0;
		
		if($type == 'S'){
			return $this->db->query("SELECT * FROM tbl_section WHERE id = '$id'")->row();
		}
		if($type == 'L'){
			return $this->db->query("SELECT * FROM tbl_section ORDER BY id DESC")->result();
		}
		if($type == 'PRODUCTS'){
			return $this->db->query("SELECT * FROM tbl_section_products WHERE section_id = $id")->result();
		}	
	}
	
	function ins_upd_navigation(){
		$retvalue['status']= false;$retvalue['message']= 'Please try again later';
		
		$type=$this->input->post('type');
		$id=(int)$this->input->post('id');
		$name=(string)$this->input->post('name');
		$slug=(string)$this->input->post('slug');
		$description=(string)$this->input->post('description');
		$parent_id=(int)$this->input->post('parent_id');
		$sortin_order=(int)$this->input->post('sortin_order');
		$page_id=(int)$this->input->post('page_id');
		$navigation_type=$this->input->post('navigation_type');
		$navigation_link=$this->input->post('navigation_link');
		$status=$this->input->post('status') ? $this->input->post('status') : 'Active';
		
		if($type == "INSERT"){
			$this->db->query("INSERT INTO tbl_navigation (name, slug, parent_id, navigation_type, navigation_link, sortin_order, page_id, created_date, modified_date, status) VALUES ('$name', '$slug', '$parent_id', '$navigation_type', '$navigation_link', $sortin_order, $page_id, NOW(), NOW(), '$status')");
			
			$id = $this->db->query("SELECT MAX(id) as id FROM tbl_navigation")->row()->id;
			$retvalue['status']= true;
			$retvalue['message']= 'Navigation created successfully';
		}
		
		if($type == "UPDATE"){
			$this->db->query("UPDATE tbl_navigation SET name = '$name', slug = '$slug', parent_id = '$parent_id', navigation_type = '$navigation_type', navigation_link = '$navigation_link', sortin_order = '$sortin_order', page_id = '$page_id', modified_date = NOW(), status = '$status' WHERE id = $id ");
			$retvalue['status']= true;
			$retvalue['message']= 'Navigation updated successfully';
		}
		
		if($type == "DELETE"){
			$this->db->query("DELETE FROM tbl_navigation WHERE id = $id");
			$retvalue['status']= true;
			$retvalue['message']= 'Navigation deleted successfully';
		}
		return $retvalue;
	}
	
	public function get_navigation($data){		
		
		$type = isset($data['type']) ? $data['type'] : '';
		$id = isset($data['id']) ? (int)$data['id'] : 0;
		
		if($type == 'S'){
			return $this->db->query("SELECT * FROM tbl_navigation WHERE id = '$id'")->row();
		}
		if($type == 'L'){
			return $this->db->query("SELECT * FROM tbl_navigation ORDER BY id DESC")->result();
		}
		if($type == 'NL'){
			return $this->db->query("SELECT * FROM tbl_navigation WHERE navigation_type = 'product' ORDER BY id DESC")->result();
		}
		if($type == 'P'){
			return $this->db->query("SELECT * FROM tbl_navigation WHERE parent_id = 0")->result();
		}
		if($type == 'SL'){
			return $this->db->query("SELECT * FROM tbl_navigation WHERE parent_id = $id")->result();
		}	
	}
	function ins_upd_filter(){
		$retvalue['status']= false;$retvalue['message']= 'Please try again later';
		
		$type=$this->input->post('type');
		$id=(int)$this->input->post('id');
		$name=(string)$this->input->post('name');
		$key=(string)$this->input->post('key');
		$min_value=(int)$this->input->post('min_value');
		$max_value=(int)$this->input->post('max_value');
		$description=(string)$this->input->post('description');
		$status=$this->input->post('status') ? $this->input->post('status') : 'Active';
		$count = $this->input->post("count");
		
		if($type == "INSERT"){
			$this->db->query("INSERT INTO tbl_filter (name,filterKey,min_value,max_value, created_date, modified_date, status) VALUES ('$name','$key','$min_value','$max_value', NOW(), NOW(), '$status')");
			
			$id = $this->db->query("SELECT MAX(id) as id FROM tbl_filter")->row()->id;
			/* for($i=1;$i<=$count;$i++){
				$name = $this->input->post('name_'.$i);
				$this->db->query("INSERT INTO tbl_filter_keys (filter_id, name, status) VALUES ($id, '$name', '$status')");
			} */
			$retvalue['status']= true;
			$retvalue['message']= 'Filter created successfully';
		}
		
		if($type == "UPDATE"){
			
			$this->db->query("UPDATE tbl_filter SET name = '$name', filterKey = '$key',min_value = '$min_value',max_value = '$max_value', modified_date = NOW(), status = '$status' WHERE id = $id ");
			
			/* $this->db->query("UPDATE tbl_filter_keys SET status = 'Delete' WHERE filter_id = $id");
			for($i=1;$i<=$count;$i++){
				$name = $this->input->post('name_'.$i);
				$keyID = (int)$this->input->post('key_id_'.$i);
				$key = $this->db->query("SELECT * FROM tbl_filter_keys WHERE id = $keyID")->row();
				if(!$key)
					$this->db->query("INSERT INTO tbl_filter_keys (filter_id, name) VALUES ($id, '$name')");
				else
					$this->db->query("UPDATE tbl_filter_keys SET status = 'Active' WHERE filter_id = $id");
			}
			$this->db->query("DELETE FROM tbl_filter_keys WHERE status = 'Delete' AND filter_id = $id"); */
			
			$retvalue['status']= true;
			$retvalue['message']= 'Filter updated successfully';
		}
		
		if($type == "DELETE"){
			$this->db->query("DELETE FROM tbl_filter WHERE id = $id");
			$retvalue['status']= true;
			$retvalue['message']= 'Filter deleted successfully';
		}
		return $retvalue;
	}
	
	public function get_filter($data){		
		
		$type = isset($data['type']) ? $data['type'] : '';
		$id = isset($data['id']) ? (int)$data['id'] : 0;
		
		if($type == 'S'){
			return $this->db->query("SELECT * FROM tbl_filter WHERE id = '$id'")->row();
		}
		if($type == 'L'){
			return $this->db->query("SELECT * FROM tbl_filter ORDER BY id DESC")->result();
		}
		if($type == 'P'){
			return $this->db->query("SELECT * FROM tbl_filter WHERE parent_id = 0")->result();
		}
		if($type == 'FK'){
			return $this->db->query("SELECT * FROM tbl_filter_keys WHERE filter_id = '$id'")->result();
		}	
	}
	function ins_upd_page(){
		$retvalue['status']= false;$retvalue['message']= 'Please try again later';
		
		$type=$this->input->post('type');
		$id=(int)$this->input->post('id');
		$name=(string)$this->input->post('name');
		$slug=(string)$this->input->post('slug');
		$content=(string)$this->input->post('content');
		$status=$this->input->post('status') ? $this->input->post('status') : 'Active';
		
		if($type == "INSERT"){
			$this->db->query("INSERT INTO tbl_page (name, slug, content, created_date, modified_date, status) VALUES ('$name', '$slug', '$content', NOW(), NOW(), '$status')");
			
			$id = $this->db->query("SELECT MAX(id) as id FROM tbl_page")->row()->id;
			$retvalue['status']= true;
			$retvalue['message']= 'Page created successfully';
		}
		
		if($type == "UPDATE"){
			$this->db->query("UPDATE tbl_page SET name = '$name', slug = '$slug', content = '$content', modified_date = NOW(), status = '$status' WHERE id = $id ");
			$retvalue['status']= true;
			$retvalue['message']= 'Page updated successfully';
		}
		
		if($type == "DELETE"){
			$this->db->query("DELETE FROM tbl_page WHERE id = $id");
			$retvalue['status']= true;
			$retvalue['message']= 'Navigation deleted successfully';
		}
		return $retvalue;
	}
	
	public function get_page($data){		
		
		$type = isset($data['type']) ? $data['type'] : '';
		$id = isset($data['id']) ? (int)$data['id'] : 0;
		
		if($type == 'S'){
			return $this->db->query("SELECT * FROM tbl_page WHERE id = '$id'")->row();
		}
		if($type == 'L'){
			return $this->db->query("SELECT * FROM tbl_page ORDER BY id DESC")->result();
		}
		if($type == 'SA'){
			return $this->db->query("SELECT * FROM tbl_shopping_assistant_page WHERE page = 'SA'")->row();
		}
		if($type == 'SP'){
			return $this->db->query("SELECT * FROM tbl_shopping_assistant_page WHERE page = 'SP'")->row();
		}
		
	}
	function get_products_url($apiID,$url,$urlType="FETCH"){
		$retvalue['status']=false;
		$api = $this->db->query("SELECT * FROM tbl_api WHERE id = $apiID")->row();
		if($api){
			if($urlType == 'UPDATE'){
				$rootPath = $api->updateRootPath;
				$id_depth = $api->update_id_depth;
				$name_depth = $api->update_name_depth;
				$image_depth = $api->update_image_depth;
				$url_depth = $api->update_url_depth;
				$price_depth = $api->update_price_depth;
				$offer_price_depth = $api->update_offer_price_depth;
			}else{
				$rootPath = $api->rootPath;
				$id_depth = $api->id_depth;
				$name_depth = $api->name_depth;
				$image_depth = $api->image_depth;
				$url_depth = $api->url_depth;
				$price_depth = $api->price_depth;
				$offer_price_depth = $api->offer_price_depth;
			}
		
			if (filter_var($url, FILTER_VALIDATE_URL) === false) {
			
				$retvalue['message']="Test URL is not a valid URL";
				$retvalue['type']='URL';
				return $retvalue;
			}
			
			$result = @file_get_contents($url);
		
			$xmlresult = @simplexml_load_string($result);
			if($xmlresult)$result = json_encode($xmlresult);
			$result = json_decode($result,true);
			
			if(count($result) > 0){
				$products = array();
				$keys = explode("/",$rootPath);
				$result = $this->get_array_value($result,$keys);
				
				if($result){
					if(is_array($result)){
						foreach($result as $r){
							$product = array();
							
							//Id
							$keys = explode("/",$id_depth);
							if(is_array($r))
								$product['id'] = $this->get_array_value($r,$keys);
							else
								$product['id'] = $r;
							
							//Names
							$keys = explode("/",$name_depth);
							if(is_array($r))
								$product['name'] = str_replace("'","",str_replace('"','',($this->get_array_value($r,$keys))));
							else
								$product['name'] = str_replace("'","",str_replace('"','',($r)));
							
							//Image
							$keys = explode("/",$image_depth);
							if(is_array($r))
								$product['image'] = $this->get_array_value($r,$keys);
							else
								$product['image'] = $r;
							
							//Product URL
							$keys = explode("/",$url_depth);
							if(is_array($r))
								$product['url'] = $this->get_array_value($r,$keys);
							else
								$product['url'] = $r;
							
							//Price
							$keys = explode("/",$price_depth);
							if(is_array($r))
								$product['price'] = floatval(str_replace("$","",$this->get_array_value($r,$keys)));
							else
								$product['price'] = floatval(str_replace("$","",$r));
							
							//Offer Price
							$keys = explode("/",$offer_price_depth);
							if(is_array($r))
								$product['offer_price'] = floatval(str_replace("$","",$this->get_array_value($r,$keys)));
							else
								$product['offer_price'] = floatval(str_replace("$","",$r));
							
							if($product['id'] && $product['id'] !='' && $product['name'] && $product['name'] != '' && $product['url'] && $product['url'] != '')							
							array_push($products,(object)$product);
						}
						$retvalue['products'] = $products;
						$retvalue['status']=true;
					}else{
						$retvalue['message']=$rootPath.' is not an array';
						$retvalue['type']='Root Path';
					}
				}else{
					$retvalue['message']='Inavlid Loop'.$rootPath;
					$retvalue['type']='Root Path';
				}
			}else{
				$retvalue['message']='No Data Found';
				$retvalue['type']='URL';
			}
		}else{
			$retvalue['message']='Invalid Api Configuration';
			$retvalue['type']='URL';
		}
		return $retvalue;
	}
	
	function get_api_response(){
		$url = $this->input->post("testURL");
		if (filter_var($url, FILTER_VALIDATE_URL) === false) {		
			$result = "Invalid Url";
			return $result;
		}
		$result = @file_get_contents($url);		
		
		$xmlresult = @simplexml_load_string($result);
		if($xmlresult)
			return $xmlresult;
		else
			return $result;
	}
	function validate_url(){
		$status=false;$message='Failed';
		$url = $this->input->post("testURL");
		$rootPath = $this->input->post("rootPath");
		$id_depth = $this->input->post("id_depth");
		$name_depth = $this->input->post("name_depth");
		$image_depth = $this->input->post("image_depth");
		$url_depth = $this->input->post("url_depth");
		$price_depth = $this->input->post("price_depth");
		$offer_price_depth = $this->input->post("offer_price_depth");
		
		if (filter_var($url, FILTER_VALIDATE_URL) === false) {
		
			$retvalue['message']="Test URL is not a valid URL";
			$retvalue['type']='URL';
			return $retvalue;
		}
		$product = array();
		$result = @file_get_contents($url);
		
		$xmlresult = @simplexml_load_string($result);
		if($xmlresult)$result = json_encode($xmlresult);		
		
		$result = json_decode($result,true);
		
		//var_dump($result['Items']['Item'][0]['ItemAttributes']);exit();
		
		if(count($result) > 0){
			
			$products = array();
			$keys = explode("/",$rootPath);
			$result = $this->get_array_value($result,$keys);
			if($result){
				if(is_array($result)){
					foreach($result as $r){
						
						//Id
						$keys = explode("/",$id_depth);
						
						if(is_array($r))
							$product['id'] = $this->get_array_value($r,$keys) == false ? false : true;
						else
							$product['id'] = true;
						
						//Names
						$keys = explode("/",$name_depth);
						if(is_array($r))
							$product['name'] = $this->get_array_value($r,$keys) == false ? false : true;
						else
							$product['name'] = true;
						
						//Image
						$keys = explode("/",$image_depth);
						if(is_array($r))
							$product['image'] = $this->get_array_value($r,$keys) == false ? false : true;
						else
							$product['image'] = true;
						
						//Product URL
						$keys = explode("/",$url_depth);
						if(is_array($r))
							$product['url'] = $this->get_array_value($r,$keys) == false ? false : true;
						else
							$product['url'] = true;
						
						//Price
						$keys = explode("/",$price_depth);
						if(is_array($r))
							$product['price'] = $this->get_array_value($r,$keys) == false ? false : true;
						else
							$product['price'] = true;	
						
						//Price
						$keys = explode("/",$offer_price_depth);
						if(is_array($r))
							$product['offer_price'] = $this->get_array_value($r,$keys) == false ? false : true;
						else
							$product['offer_price'] = true;										
					}
					if($product['id'] == false || $product['name'] == false || $product['image'] == false || $product['url'] == false || $product['price'] == false){
						$retvalue['status'] = false;
						$retvalue['product'] = $product;
						$retvalue['message'] = 'Failed. Please give JSON depth paths correctly';
					}else{
						$retvalue['status'] = true;
						$retvalue['product'] = $product;
						$retvalue['message'] = 'Api Validated Successfully';
					}
				}else{
					$retvalue['message']=$rootPath.' is not an array';
					$retvalue['type']='Root Path';
				}
			}else{
				$retvalue['message']='Inavlid Loop'.$rootPath;
				$retvalue['type']='Root Path';
			}
		}else{
			$retvalue['message']='Invalid URL. No Data Found';
			$retvalue['type']='URL';
		}		
		return $retvalue;
		
	}
	function get_array_value(array $array, array $indexes)
	{
		if (count($array) == 0 || count($indexes) == 0) {
			return false;
		}

		$index = array_shift($indexes);
		if(!array_key_exists($index, $array)){
			return false;
		}

		$value = $array[$index];
		if (count($indexes) == 0) {
			return $value;
		}

		if(!is_array($value)) {
			return false;
		}

		return $this->get_array_value($value, $indexes);
	}
	
	public function get_shoppers($data){		
		
		$type = isset($data['type']) ? $data['type'] : '';
		$id = isset($data['id']) ? (int)$data['id'] : 0;
		
		if($type == 'S'){
			return $this->db->query("SELECT * FROM tbl_shopper_requests WHERE id = '$id'")->row();
		}
		if($type == 'L'){
			return $this->db->query("SELECT * FROM tbl_shopper_requests where status='New'")->result();
		}
	}
	function ins_upd_shopper(){
		$retvalue['status']= false;$retvalue['message']= 'Please try again later';
		
		$type=$this->input->post('type');
		$id=(int)$this->input->post('id');
		
		//$question=(string)$this->input->post('question');

		//$status=$this->input->post('status') ? $this->input->post('status') : 'Active';
		
		if($type == "CONFIRM"){
			//$password = password_hash(mt_rand(), PASSWORD_DEFAULT);
			
			$check = $this->db->query("SELECT * FROM tbl_user u INNER JOIN tbl_shopper_requests sr ON sr.email = u.email WHERE sr.id = $id")->row();
			if(!$check){
				$pwd = mt_rand();
				$password = password_hash($pwd, PASSWORD_DEFAULT);
				$this->db->query("UPDATE tbl_shopper_requests SET status='Confirmed' WHERE id='".$id."';");
				$this->db->query("INSERT INTO tbl_user (first_name, last_name, email, password, role, phone, gender, city, country, address, created_date, modified_date, status) select first_name, last_name, email, '$password', 'SHOPPER',phone,gender,city,country,address,NOW(),NOW(),'Active' from tbl_shopper_requests where id=".$id.";");
				
				$user = $this->db->query("SELECT * FROM tbl_user u INNER JOIN tbl_shopper_requests sr ON sr.email = u.email WHERE sr.id = $id")->row();
				if($user){
					$auth_id = $this->db->query("SELECT UUID() AS auth_id")->row()->auth_id;
					$this->db->query("UPDATE tbl_user SET auth_id = '$auth_id',modified_date = NOW() WHERE id = ".$user->id);
					
					//Sending Notification
					$to = $user->email;
					$subject = 'Shopper registration successful';
					$url = base_url('home/password_reset/'.$auth_id);
					$message="Hi ".$user->first_name.' '.$user->last_name.",<br><br>";
					$message.="Thank you for registering with us.Below are login details,<br><br>";
					$message.="Username:<b>".$user->email."</b><br>";
					$message.="Password:<b>".$pwd."</b><br><br>";
					$message.="To reset your password, click on the link below (or copy and paste the URL into your browser):<br><a href=".$url.">".$url."</a><br><br>";
					$message.="Thanks,<br>Painlessgift Team."; 
					$this->home_model->send_email($to,$subject,$message);					
					
					$retvalue['status']= true;
					$retvalue['message']= 'Shopper approval: CONFIRMED.';
				}else{
					$retvalue['message']= 'Shopper approval: Failed.';
				}
			}else{
				$retvalue['message']= 'Shopper approval: Already exists.';
			}
		}
		
		if($type == "DENY"){
			$this->db->query("UPDATE tbl_shopper_requests SET status='Denied' WHERE id='".$id."';");
			$retvalue['status']= true;
			$retvalue['message']= 'Shopper approval: DENIED.';
		}
		
		return $retvalue;
	}
	public function get_questions($data){		
		
		$type = isset($data['type']) ? $data['type'] : '';
		$id = isset($data['id']) ? (int)$data['id'] : 0;
		
		if($type == 'S'){
			return $this->db->query("SELECT * FROM tbl_questionaire WHERE id = '$id'")->row();
		}
		if($type == 'L'){
			return $this->db->query("SELECT * FROM tbl_questionaire ORDER BY sorting_order ASC")->result();
		}
		if($type == 'O'){
			return $this->db->query("SELECT * FROM tbl_question_options WHERE qid = $id")->result();
		}
		
	}
	function ins_upd_questions(){
		$retvalue['status']= false;$retvalue['message']= 'Please try again later';
		
		$type=$this->input->post('type');
		$id=(int)$this->input->post('id');
		$question=(string)$this->input->post('question');
		$mandatory=(int)$this->input->post('mandatory');
		$sorting_order=(int)$this->input->post('sorting_order');
		$qtype=(string)$this->input->post('qtype');

		$status=$this->input->post('status') ? $this->input->post('status') : 'Active';
		
		if($type == "INSERT"){
			$this->db->query("INSERT INTO tbl_questionaire (question, mandatory, sorting_order, qtype, created_date, status) VALUES ('$question', $mandatory, $sorting_order, '$qtype' ,NOW(), '$status')");
			
			$id = $this->db->query("SELECT MAX(id) as id FROM tbl_questionaire")->row()->id;
			$retvalue['status']= true;
			$retvalue['message']= 'Question created successfully';
		}
		
		if($type == "UPDATE"){
			$this->db->query("UPDATE tbl_questionaire SET question = '$question', mandatory = $mandatory, sorting_order = $sorting_order, qtype = '$qtype', status = '$status' WHERE id = $id ");
			$retvalue['status']= true;
			$retvalue['message']= 'Question updated successfully';
		}
		
		if($type == "UPDATE" || $type == "INSERT"){
			$this->db->query("UPDATE tbl_question_options SET status = 'R' WHERE qid = $id ");
			$options = (array)json_decode($this->input->post('options'));
			foreach($options as $o){
				$check = $this->db->query("SELECT * FROM tbl_question_options WHERE id = $o[0]")->row();
				if($check)
					$this->db->query("UPDATE tbl_question_options SET status = 'A',name = '$o[1]' WHERE id = $o[0]");
				else
					$this->db->query("INSERT INTO tbl_question_options(qid,name,status) VALUE($id,'$o[1]','A')");
			}
			$this->db->query("DELETE FROM tbl_question_options WHERE status = 'R' AND qid = $id");
		}
		
		if($type == "DELETE"){
			$this->db->query("DELETE FROM tbl_questionaire WHERE id = $id");
			$retvalue['status']= true;
			$retvalue['message']= 'Question deleted successfully';
		}
		return $retvalue;
	}
	
	
	function get_chat($data){
		$type = isset($data['type'])?$data['type']:'';
		$userID = isset($data['userID'])?$data['userID']:'';
		$sendTo = isset($data['sendTo'])?$data['sendTo']:'';
		
		if($type == 'USER_CHAT'){
			
			$retValue = array();
			
			$user = $this->db->query("SELECT * FROM tbl_user WHERE id='$sendTo'")->row();
			if($user){
				if(file_exists($user->image))
					$user_array['image'] = base_url($user->image);
				else
					$user_array['image'] = base_url($this->config->item('default_image_user'));
				
				$user_array['name'] = $user->first_name.' '.$user->last_name;
				$user_array['userID'] = $user->id;
				
				$retValue['user'] = (object) $user_array;	
				
				$chats = array();
				$cqry = $this->db->query("SELECT * FROM tbl_chat WHERE ((userID='$userID' AND sendTo = '$sendTo') OR (userID='$sendTo' AND sendTo = '$userID')) AND status = 'ACTIVE' ORDER BY dateTime ASC")->result();
				foreach($cqry as $c){
					$c = (array) $c;
					if(strtotime(date('y-m-d',strtotime($c['dateTime']))) != strtotime(date('y-m-d')))
						$c['dateTime'] = date('d-m-y h:i A',strtotime($c['dateTime']));
					else
						$c['dateTime'] = date('h:i A',strtotime($c['dateTime']));
						
					$c = (object) $c;
					array_push($chats,$c);
				}
				$retValue['chat'] = $chats;
				return $retValue;
			}
		}
		
		if($type == 'ALL_CHAT'){
			
			$uqry = $this->db->query("SELECT u.id,u.first_name,u.last_name,u.image,(SELECT CONCAT(c.message,'~/date/~',c.dateTime) FROM tbl_chat c WHERE ((c.userID = u.userID AND c.sendTo='$userID') OR (c.userID = '$userID' AND c.sendTo = u.id)) AND c.status = 'ACTIVE' ORDER BY c.dateTime DESC LIMIT 1) AS lastMsg,(SELECT COUNT(*) FROM tbl_chat uc WHERE uc.userID = u.id AND uc.sendTo='$userID' AND uc.status = 'ACTIVE' AND uc.readMsg = 0) AS unRead FROM tbl_user u")->result();
			
			$users = array();
			$i = 0;
			foreach($uqry as $u){
				$users[$i]['userID'] = $u->id;
				$users[$i]['name'] = $u->first_name.' '.$u->last_name;
				if(file_exists($u->image))
					$users[$i]['image'] = base_url($u->image);
				else
					$users[$i]['image'] = base_url($this->config->item('default_image_user'));
				$users[$i]['unread'] = $u->unRead;
				
				$lastMsg = '';$dateTime = '';$dateTime2 = '';
				if($u->lastMsg){
					$lm = explode("~/date/~",$u->lastMsg);
					$dateTime = $this->date_formate2(end($lm));
					$dateTime2 = end($lm);
					$lastMsg = $lm[0];
					
				}
				$users[$i]['lastMsg'] = $lastMsg;
				$users[$i]['dateTime'] = $dateTime;
				$users[$i]['dateTime2'] = $dateTime2;
				$i++;
			}
			if(!empty($users)){
				foreach ($users as $key => $part) {
					$sort[$key] = strtotime($part['dateTime2']);
				}
				array_multisort($sort, SORT_DESC, $users);
			}
			//var_dump($users);exit();
			return $users;
		}
		if($type=='TOTAL_COUNT'){
			$userID = $this->session->userdata('userID');
			return $this->db->query("SELECT COUNT(*) AS count FROM tbl_chat WHERE sendTo='$userID' AND readMsg = 0 AND status = 'ACTIVE'")->row();
		}
		return false;
	}
	
	function ins_upd_chat(){
		$retValue['status'] = false;$retValue['message'] = 'Error';
		$userID = $this->input->post('userID');
		$sendTo = $this->input->post('sendTo');
		$message = str_replace("'","\\'",str_replace("\\","\\\\",($this->input->post('message'))));
		$type = $this->input->post('type');
		
		if($type == 'INSERT'){
			$this->db->query("INSERT INTO tbl_chat (chatID, userID, sendTo, message, dateTime, status) VALUES (UUID(), '$userID', '$sendTo', '$message', NOW(), 'ACTIVE')");
			$retValue['status'] = true;
			$retValue['message'] = 'Success';
		}
		
		if($type == 'UPDATE_READ'){
			$this->db->query("UPDATE tbl_chat SET readMsg = 1 WHERE userID = '$sendTo' AND sendTo='$userID'");
			$retValue['status'] = true;
			$retValue['message'] = 'Success';
		}
		
		return $retValue;
	}
	function getReports($page){
		$data['new'] = $this->db->query("SELECT COUNT(*) AS rCount FROM tbl_user_requests WHERE status = 'New'")->row()->rCount;
		$data['ongoing'] = $this->db->query("SELECT COUNT(*) AS rCount FROM tbl_user_requests WHERE status = 'Ongoing' AND shopper_id = '".$this->session->userdata('userID')."'")->row()->rCount;
		$data['completed'] = $this->db->query("SELECT COUNT(*) AS rCount FROM tbl_user_requests WHERE status = 'Completed' AND shopper_id = '".$this->session->userdata('userID')."'")->row()->rCount;
		$rqry = $this->db->query("SELECT COUNT(*) AS rCount FROM tbl_user_requests WHERE shopper_id = '".$this->session->userdata('userID')."' GROUP BY userID")->row();
		if($rqry)$data['users'] = $rqry->rCount;else $data['users'] =0 ;
		return $data;
	}
	
	function ins_upd_shopping_page(){
		$heading = $this->input->post('heading');
		$content = $this->input->post('content');
		$btext = $this->input->post('btext');
		$pheading = $this->input->post('pheading');
		$pcontent = str_replace("'","",str_replace('"','',($this->input->post('pcontent'))));
		$step1 = $this->input->post('step1');
		$step2 = $this->input->post('step2');
		$step3 = $this->input->post('step3');
		$page = $this->input->post('page');
		$stickytext = $this->input->post('stickytext');
		
		$check = $this->db->query("SELECT * FROM tbl_shopping_assistant_page WHERE page = '$page'")->row();
		if($check){
			$this->db->query("UPDATE tbl_shopping_assistant_page SET stickytext = '$stickytext', heading = '$heading', content = '$content', btext = '$btext', pheading = '$pheading', pcontent = '$pcontent', step1 = '$step1', step2 = '$step2', step3 = '$step3' WHERE id = $check->id");
		}else{
			$this->db->query("INSERT INTO tbl_shopping_assistant_page (page, stickytext, heading, content, btext, pheading, pcontent, step1, step2, step3) VALUES ('$page', '$stickytext', '$heading', '$content', '$btext', '$pheading', '$pcontent', '$step1', '$step2', '$step3')");
		}
		$data['status'] = true;
		$data['message'] = 'Updated successfully';
		return $data;
	}
	
	function remainder(){
		
		$log_path = 'assets/log/profile_remainder_'.date('Ymd').'.txt';
		$content = "Started<br>";
		$content .= "=====================<br>";
		if(file_exists($log_path))rename($log_path,$log_path.mt_rand().'.txt');
		write_file($log_path, $content, 'a');
		
		$users = $this->home_model->get_profile(array('type'=>'REMAINDER'));
		//var_dump($users);exit();
		if(count($users) > 0){
			foreach($users as $u){
				
				$content = "Name : ".$u->name."".PHP_EOL;
				$content .= "Email : ".$u->email."".PHP_EOL;
				$content .= "Profile Name : ".$u->profile_name."".PHP_EOL;
				
				$data['name'] = $u->name;
				$data['profile_name'] = $u->profile_name;
				$data['reason'] = $u->reason;
				$data['relation'] = $u->relation;
				$data['date_for_gift'] = $u->date_for_gift;
				$message = $this->load->view('email/profile_remainder',$data,true);
				$status = $this->home_model->send_email($u->email,'Profile date is comming soon.',$message);
				if($status){
					$content .= "Status : Email sent successfully".PHP_EOL;
					$this->db->query("UPDATE tbl_custom_profiles SET remainder_mail = 1 WHERE user_id = ".(int)$u->id);
				}else{
					$content .= "Status : Email Not Sent".PHP_EOL;
				}
				
				$content .= "------------------------".PHP_EOL;
				write_file($log_path, $content, 'a');
					
			}
			
			//Sending Push Notifications
			$appIds = array();
			foreach($users as $u)if($u->push_enabled == 1)array_push($appIds,$u->appRegistationID);
			if(count($appIds) > 0){
				$this->home_model->push_notification($appIds,'One of your event listed in your profile is coming up soon');
			}
			
			$content = "Completed".PHP_EOL;
			write_file($log_path, $content, 'a');
			
		}else{
			$content = "No users found";
			write_file($log_path, $content, 'a');
		}
		
		return base_url($log_path);
	}
}

?>
