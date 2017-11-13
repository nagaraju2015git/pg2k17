<?php
/**
* Name:  Data_upload_model
*
* Author: Axinovate
*		  info@axinovate.com
*
* Created:  23 June 2014
*
*/
	class Data_upload_model extends CI_Model{
		/**
		 * @return void
		 **/
		public function __construct(){
			parent::__construct();
			$this->load->model("home_model");
			$this->load->helper('file');
			$this->load->library('Email');
		}
				
		public function upload_user($path)
		{
			
				$retvalue=array();
				$retvalue['status']=false;
				$retvalue['message']='Error';
				$Filepath=$path;
				if(!file_exists($path))
					return $retvalue;
				
				$data = array('type'=>'ROLE_BY_CODE','roleCode'=>$this->config->item("agent_role"));
				$xml = $this->home_model->user_xml($data);
				$role = $this->db->query("CALL sp_getUser('$xml')")->row();
				mysqli_next_result($this->db->conn_id);
				
				if(!$role){
					$retvalue['message']='Default role not found';
					return $retValue;
				}
				$roleID = $role->roleID;
				
				$cqry=$this->db->query("SELECT * FROM tbl_city");
				$cities=array();$ci=0;
				foreach($cqry->result() as $city){
					$cities[$ci]['cityID']=$city->cityID;
					$cities[$ci]['stateID']=$city->stateID;
					$cities[$ci]['cityName']=strtolower($city->cityName);
					$cities[$ci++]['countryID']=$city->countryID;
				}
				$cuqry=$this->db->query("SELECT * FROM tbl_country");
				$countries=array();$cu=0;
				foreach($cuqry->result() as $country){
					$countries[$cu]['countryID']=$country->countryID;
					$countries[$cu++]['countryName']=strtolower($country->countryName);
				}
				
				// Excel reader from http://code.google.com/p/php-excel-reader/
				require(APPPATH.'third_party/excel-reader/php-excel-reader/excel_reader2.php');
				require(APPPATH.'third_party/excel-reader/SpreadsheetReader.php');
				
				date_default_timezone_set('UTC');
				$createdBy=$this->session->userdata('userID');
				//creating log file
				$now = date('d M Y H:i:s');
				$now1 = date('dmyHis');
				$log_path = 'assets/log/user_upload_'.$now1.'.txt';
				$retvalue['log_file'] = base_url($log_path);
				$content = "Users uploading started...".PHP_EOL;
				$content .="User : ".$this->session->userdata('userName').PHP_EOL;
				$content .="User ID : ".$createdBy.PHP_EOL;
				$content .="Date : ".$now.PHP_EOL;
				$content .="===========================================".PHP_EOL;
				write_file($log_path, $content, 'a');
				
				$error=0;
				try
				{
					$Spreadsheet = new SpreadsheetReader($path);
					$content="Status".PHP_EOL;
					$content.="-----------------------------------------".PHP_EOL;
					//[0] => Nar ID [1] => First Name || [2] => Last Name || [3] => Email || [4] => Phone || [5] => Company || [6] => Address || [7] => City || [8] => State || [9] => Member Type
					
					//Validations
					$total=0;$e_a=array();$e_c=0;$emails=array();
					foreach ($Spreadsheet as $key => $row)
					{
						if($key>0 && ($row[0]!='' || $row[1]!='' || $row[2]!='' || $row[3]!='' || $row[4]!='' || $row[5]!='' || $row[6]!='' || $row[7]!='' || $row[8]!='' || $row[9]!='')){
							
							$row[7]=trim(strtolower($row[7])," ");
							
							//City validation
							/* if($row[7] == ''){
								$content.=$e_a[$e_c++]="Empty column for city in line ".($key+1)." \r\n";
								$error++;
							}
							$city_error=0;$checkCountryID2=0;
							foreach($cities as $city){
								if($city['cityName'] == $row[7]){
									$checkCountryID2 = $city['countryID'];
									$city_error++;
								}
							}
							if($city_error == 0 || $city_error >1){
								$content.=$e_a[$e_c++]="Invalid city name found in line ".($key+1)." \r\n";
								$error++;
							} */
							
							if($row[3] == '' || empty($row[3])){
								$content.=$e_a[$e_c++]="Empty email found in ".($key+1)." \r\n";
								$error++;
							}
							if (filter_var($row[3], FILTER_VALIDATE_EMAIL) === false && $row[3] != '' && !empty($row[3])) {
								$content.=$e_a[$e_c++]="Invalid email found in ".($key+1)." \r\n";
								$error++;
							}
							if($row[5] == '' || empty($row[5])){
								$content.=$e_a[$e_c++]="Empty company name found in ".($key+1)." \r\n";
								$error++;
							}
							$emails = array('0');$phones = array('0000000000');
							if($row[3] != '' && !empty($row[3]))
								array_push($emails,"'".$row[3]."'");
							if($row[4] != '' && $row[4] != ' ')
								array_push($phones,"'".$row[4]."'");
							
						$total++;
						}
					}
					/* if($total>200){
						$content.=$e_a[$e_c++]="Excel contains more than 200 sessions.Please reduce to 200 sessions \r\n";
						$error++;
					} */
					
					$checkEmail = array();
					$cqry = $this->db->query("SELECT email FROM tbl_users WHERE email IN (".implode(",",$emails).")")->result();
					foreach($cqry as $ce)array_push($checkEmail,$ce->email);
					
					$checkPhone = array();
					$cqry = $this->db->query("SELECT phone FROM tbl_users WHERE phone IN (".implode(",",$phones).")")->result();
					foreach($cqry as $ce)array_push($checkPhone,$ce->phone);
					//var_dump($checkPhone);exit();
					//$error++;
					$retvalue['total']=$total;
					$retvalue['success']=0;
					$retvalue['failed']=$total;
					if($error==0 ){
						//[0] => Nar ID [1] => First Name || [2] => Last Name || [3] => Email || [4] => Phone || [5] => Company || [6] => Address || [7] => City || [8] => State || [9] => Member Type
						
						$sucess_count=0; $query1="";$query2="";$query3="";
						foreach ($Spreadsheet as $key => $row){
							if($key>0 && ($row[0]!='' || $row[1]!='' || $row[2]!='' || $row[3]!='' || $row[4]!='' || $row[5]!='' || $row[6]!='' || $row[7]!='' || $row[8]!='' || $row[9]!='')){
							
								$row[7]=trim(strtolower($row[7])," ");
								$error = 0;
								if($row[3] == '' || empty($row[3])){
									$content.=$e_a[$e_c++]="Empty email found in ".($key+1)." \r\n";
									$error++;
								}
								if (filter_var($row[3], FILTER_VALIDATE_EMAIL) === false && $row[3] != '' && !empty($row[3])) {
									$content.=$e_a[$e_c++]="Invalid email found in ".($key+1)." \r\n";
									$error++;
								}
								if(in_array($row[3],$checkEmail)){
									$content.=$e_a[$e_c++]="Email already exists in line ".($key+1)." \r\n";
									$error++;
								}
								if(in_array($row[4],$checkPhone) && $row[4] != ''){
									$content.=$e_a[$e_c++]="Phone already exists in line ".($key+1)." \r\n";
									$error++;
								}
								if($row[5] == '' || empty($row[5])){
									$content.=$e_a[$e_c++]="Empty company name found in ".($key+1)." \r\n";
									//$error++;
								}
								
								if($error == 0){
								
									//$userID=uniqid().uniqid();
									$companyID="";
									
									$cityID=0;$stateID=0;
									foreach($cities as $city){
										if($city['cityName'] == $row[1]){
											$cityID = $city['cityID'];
											if($city['stateID'] !='' && !empty($city['stateID']))
												$stateID = $city['stateID'];
										}
									}
									$email = $row[3];
									$phone = '';
									if(!preg_match('/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/', $row[4]))
										$phone = $row[4];
									$password = $this->home_model->encrypt_password($this->config->item("default_password"));
									
									
									//Transaction begins
									$this->db->trans_begin();
									if($row[5] != '' && !empty($row[5])){
										$companyID = $this->db->query("SELECT UUID() as uuid")->row()->uuid;
										$this->db->query("INSERT INTO tbl_company (companyID, name, createdBy, dateTime) VALUES ('".$companyID."','".$row[5]."','".$createdBy."',NOW())");
										
									}
									$userID = $this->db->query("SELECT UUID() as uuid")->row()->uuid;
									$authID = $this->db->query("SELECT UUID() as uuid")->row()->uuid;
									//Inserting users into tbl_users table
									$this->db->query("INSERT INTO tbl_users (userID, email, phone, password, roleID, parentUserID, authID, createdDate, updatedDate, status, appRegistationID, companyID, narID, memberType) VALUES ('".$userID."', '".$email."', '".$phone."', '".$password."', '".$roleID."', '', '".$authID."', NOW(), NOW(), 'ACTIVE', '', '".$companyID."', '".$row[0]."', '".$row[9]."')");
									
									
									//Inserting users into tbl_userProfile table
									$this->db->query("INSERT INTO tbl_userProfile (userID, firstName, lastName, cityID, addressLine1, addressLine2) VALUES ('".$userID."', '".$row[1]."', '".$row[2]."', '".$cityID."', '".$row[6]."', '')");
									
									
									if ($this->db->trans_status() === FALSE)
									{
										$this->db->trans_rollback();
									}
									else
									{
										$this->db->trans_commit();
										
										$data = array(
											'email' => $email,
											'resetlink' => base_url("home/reset_password/".$authID),
											'name' => $row[1].' '.$row[2]
										);
										$email = $this->send_email($data);
										if(!$email){
											$content.=$e_a[$e_c++]="Email not sent for ".$email." \r\n";
										}
										$sucess_count++;
									}
								}
							}
						}
						
						$retvalue['success']=$sucess_count;
						$retvalue['failed']=($total-$sucess_count);
						$stat="Total Users = ".$total.PHP_EOL;
						$stat.="Success = ".$sucess_count.PHP_EOL;
						$stat.="Failed = ".($total-$sucess_count).PHP_EOL;
						$stat.="===========================================".PHP_EOL;
						write_file($log_path, $stat, 'a');
						if($error==0 && $sucess_count==$total){
							$retvalue['status']=true;
							$content.=$retvalue['message']='Users uploaded successfully';
							write_file($log_path, $content, 'a');
						}else{
							$content.=$retvalue['message']='Users are not uploaded successfully';
							write_file($log_path, $content, 'a');
						}
					}else{
						$content.=$retvalue['message']='Users are not uploaded successfully';
						write_file($log_path, $content, 'a');
					}
					
				}
				catch (Exception $E)
				{
					$retvalue['message']= $E -> getMessage();
				}
				$retvalue['errors']=$e_a;
			
			$status='Failed';
			if($retvalue['status'])
				$status='Success';
			
			return $retvalue;
		}	
		function send_email($data){
			$to = $data['email'];
			$resetlink = $data['resetlink'];
			$name = $data['name'];
			$message = $this->load->view("email_template/user_registration",$data,true);
			$subject = 'Nar registration successful';
			
			$this->email->from($this->config->item('admin_email'));
			$this->email->to($to);
			$this->email->subject($subject);
			$this->email->message($message);
			//return $this->email->send();
		}
}
?>