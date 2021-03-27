<?php 


class inslogin
{
	private $db;
	private $dbhost=servername;
	private $dbuser=username;
	private $dbpass=password;
	private $dbname=database;
	
	function __construct()
	{ 
		try {
			
			$this->db=new PDO('mysql:host='.$this->dbhost.';dbname'.$this->dbname.';charset=utf8',$this->dbuser,$this->dbpass);
			 $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			} catch (Exception $e) {
			
			die("Bağlantı olmadı be:".$e->getMessage());
		}
	}
	


	public function csrftoken($username)
	{

		try {
			
			$cookilerim = dirname(__FILE__)."/../cook/".$username.".txt" ; 
			$cookilerimbos = dirname(__FILE__)."/../cook/".$username."_".rand(1,100000).".txt" ; 
			
			 $proxy=$this->proxy()['proxy'];
			 $pass=$this->proxy()['pass'];
			 $rawtime=$this->rawtime()['data'];
			 $phone_id=$this->v4()['data'];
			 $adid=$this->v4()['data'];
			 $guid=$this->v4()['data'];
			 $pigeon_id=$this->v4()['data'];
			 $device_id=$this->v4()['data'];
			 $android_id="android-".$this->randv4(16)['data'];
			 $agent=$this->agent()['data'];
			 $blog_version_id=$this->version()['data'];
			 
			$veriler["proxy"]=$proxy;
			$veriler["pass"]=$pass;
			$veriler["phone_id"]=$phone_id;
			$veriler["adid"]=$adid;
			$veriler["guid"]=$guid;
			$veriler["pigeon_id"]=$pigeon_id;
			$veriler["device_id"]=$device_id;
			$veriler["android_id"]=$android_id;
			$veriler["agent"]=$agent;
			$veriler["blog_version_id"]=$blog_version_id;
			
			$header=$this->headers($veriler)['data'];
			$veriler["headerana"]=$header;
			
			
			$header[]= "X-Pigeon-Rawclienttime: ".$rawtime;
			$header[]= "Content-Type: application/x-www-form-urlencoded; charset=UTF-8";
			$header[]= "Connection: keep-alive";
			
			$post="";
			$ref="";
			$method="GET";
			$http="";
			$url ="https://b.i.instagram.com/api/v1/zr/token/result/?device_id=".$android_id."&token_hash=&custom_device_id=".$device_id."&fetch_reason=token_expired";
			$data=$this->curl($proxy,$pass,$url,$agent,$cookilerimbos,$header,$post,$ref,$method,$http);
			
			$dataget=$this->cookieayikla($cookilerimbos)["data"];
			
			$veriler["midx"]=$dataget["midx"];
			$veriler["csrf_token"]=$dataget["csrf_token"];
			$veriler["cookilerim"]=$cookilerim;
			$veriler["cookilerimbos"]=$cookilerimbos;
			
			   
		   	return ['status' => TRUE ,'data'=> $veriler];
			
		} catch (Exception $e) {

			return ['status' => FALSE, 'error' => $e->getMessage()];
			
		}

	}	
	
	public function postala($veriler)
	{

		try {
			
		 	$proxy=$veriler["csrfbilgi"]["proxy"];
		 	$pass=$veriler["csrfbilgi"]["pass"];
		 	$cookilerim=$veriler["csrfbilgi"]["cookilerim"];
			$cookilerimbos=$veriler["csrfbilgi"]["cookilerimbos"];
		 	$agent=$veriler["csrfbilgi"]["agent"];

		 	$header=$veriler["header"];
			$post=$veriler["post"];
			$url=$veriler["url"];
			$ref="";
			$method="POST";
			$http="";
			$data=$this->curl($proxy,$pass,$url,$agent,$cookilerimbos,$header,$post,$ref,$method,$http);
			
			   
		   	return ['status' => TRUE ,'data'=> $data["data"],'header_data'=> $data["header_data"]];
			
		} catch (Exception $e) {

			return ['status' => FALSE, 'error' => $e->getMessage()];
			
		}

	}	


	public function getle($veriler)
	{

		try {
			
		 	$proxy=$veriler["csrfbilgi"]["proxy"];
		 	$pass=$veriler["csrfbilgi"]["pass"];
		 	$cookilerim=$veriler["csrfbilgi"]["cookilerim"];
		 	$agent=$veriler["csrfbilgi"]["agent"];

		 	$header=$veriler["header"];
			$post="";
			$url=$veriler["url"];
			$ref="";
			$method="GET";
			$http="";
			$data=$this->curl($proxy,$pass,$url,$agent,$cookilerim,$header,$post,$ref,$method,$http);
			
			   
		   	return ['status' => TRUE ,'data'=> $data];
			
		} catch (Exception $e) {

			return ['status' => FALSE, 'error' => $e->getMessage()];
			
		}

	}		
	
	public function cookieayikla($cookilerim)
	{

		try {
			
			$array = explode("\n", file_get_contents($cookilerim));
			  for ( $i=0; $i<count($array); $i++ ) {
				$sonuc = strpos($array[$i],"mid");
				  if($sonuc >-1)
				  {
					   $client_ids=$array[$i];
					  $client_idbol=explode("mid",$client_ids);
					  $yclient_id=$client_idbol[1];
					  $yclient_id=preg_replace('/\s+/', '', $yclient_id);
					 $midx=trim($yclient_id);
				  }

				  
					 $sonuc3 = strpos($array[$i],"csrftoken");
				  if($sonuc3 >-1)
				  {
					   $csrftokens=$array[$i];
					  $csrftokenbol=explode("csrftoken",$csrftokens);
					  $ycsrftoken=$csrftokenbol[1];
					  $ycsrftoken=preg_replace('/\s+/', '', $ycsrftoken);
					 $csrf_token=trim($ycsrftoken);
				  }
				  
				  $sonuc3 = strpos($array[$i],"rur");
				  if($sonuc3 >-1)
				  {
					   $csrftokens=$array[$i];
					  $csrftokenbol=explode("rur",$csrftokens);
					  $ycsrftoken=$csrftokenbol[1];
					  $ycsrftoken=preg_replace('/\s+/', '', $ycsrftoken);
					 $rur=trim($ycsrftoken);
				  }
				  
				  $sonuc3 = strpos($array[$i],"ds_user_id");
				  if($sonuc3 >-1)
				  {
					   $csrftokens=$array[$i];
					  $csrftokenbol=explode("ds_user_id",$csrftokens);
					  $ycsrftoken=$csrftokenbol[1];
					  $ycsrftoken=preg_replace('/\s+/', '', $ycsrftoken);
					 $ds_user_id=trim($ycsrftoken);
				  }
				  
				  $sonuc3 = strpos($array[$i],"sessionid");
				  if($sonuc3 >-1)
				  {
					   $csrftokens=$array[$i];
					  $csrftokenbol=explode("sessionid",$csrftokens);
					  $ycsrftoken=$csrftokenbol[1];
					  $ycsrftoken=preg_replace('/\s+/', '', $ycsrftoken);
					 $sessionid=trim($ycsrftoken);
				  }
			   }

			$veriler["midx"]=$midx;
			$veriler["csrf_token"]=$csrf_token;
			$veriler["rur"]=$rur;
			$veriler["ds_user_id"]=$ds_user_id;
			$veriler["sessionid"]=$sessionid;
			
			   
		   	return ['status' => TRUE ,'data'=> $veriler];
			
		} catch (Exception $e) {

			return ['status' => FALSE, 'error' => $e->getMessage()];
			
		}

	}	

	public function headerayikla($header_data)
	{

		try {
			$veriler=[];
			foreach(explode("\r\n", $header_data) as $row) {
				if(preg_match('/(.*?): (.*)/', $row, $matches)) {
					if($matches[1]=="x-ig-set-www-claim") $veriler["claim"]=$matches[2];
					if($matches[1]=="ig-set-authorization") $veriler["authorization"]=$matches[2];
				}
			}
		   	return ['status' => TRUE ,'data'=> $veriler];
			
		} catch (Exception $e) {

			return ['status' => FALSE, 'error' => $e->getMessage()];
			
		}

	}	

	
	public function userkontrol($username,$password)
	{

		try {
				$durum="0";	
			$stmt=$this->db->prepare("SELECT * FROM instagramsite.insuser where username='$username' and password='$password'");
	       $stmt->execute();
			if ($stmt->rowCount()>0) {
					$durum="1";
				$row=$stmt->fetch(PDO::FETCH_ASSOC);
				}	
		   	return ['status' => TRUE,'userid' => $row["id"] ,'durum' => $durum ];
			 
		} catch (Exception $e) {

			return ['status' => FALSE, 'error' => $e->getMessage()];
			
		}

	}


	public function userkaydet( $claim, $authorization,$username, $password,  $pk, $fbuid, $phone_number,$profile_pic_url,$full_name, $proxy, $pass, $pigeon_id, $device_id, $android_id, $agent, $blog_version_id, $phone_id, $adid, $guid)
	{

		try {
			$tarih=date("Y-m-d H:i:s");
			$stmt=$this->db->prepare("INSERT INTO instagramsite.insuser (`claim`, `authorization`,`username`, `password`, `last_login`, `yetki`, `pk`, `fbuid`, `phone_number`, `profile_pic_url`, `full_name`, `proxy`, `pass`, `pigeon_id`, `device_id`, `android_id`, `agent`, `blog_version_id`, `phone_id`, `adid`, `guid`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
	        $result=$stmt->execute(array( $claim, $authorization,$username, $password, $tarih, "1", $pk, $fbuid, $phone_number, $profile_pic_url, $full_name, $proxy, $pass, $pigeon_id, $device_id, $android_id, $agent, $blog_version_id, $phone_id, $adid, $guid));
			 $id = $this->db->lastInsertId();
		   	return ['status' => TRUE,'username' => $username ,'pk' => $pk ];
			 
		} catch (Exception $e) {

			return ['status' => FALSE, 'error' => $e->getMessage()];
			
		}

	}
	public function userguncelle( $claim, $authorization,$username, $password,  $pk, $fbuid, $phone_number, $proxy, $pass, $pigeon_id, $device_id, $android_id, $agent, $blog_version_id, $phone_id, $adid, $guid)
	{

		try {
			$tarih=date("Y-m-d H:i:s");
			$stmt=$this->db->prepare("UPDATE  instagramsite.insuser  SET `claim`='$claim',`authorization`='$authorization',`password`='$password',`last_login`='$tarih',`proxy`='$proxy',`pass`='$pass',`pigeon_id`='$pigeon_id',`device_id`='$device_id',`android_id`='$android_id',`agent`='$agent',`blog_version_id`='$blog_version_id',`phone_id`='$phone_id',`adid`='$adid',`guid`='$guid' WHERE username='$username'");
	        $sonuc=$stmt->execute();
			
		   	return ['status' => TRUE,'username' => $sonuc ];
			 
		} catch (Exception $e) {

			return ['status' => FALSE, 'error' => $e->getMessage()];
			
		}

	}
		
	public function proxy()
	{

		try {
		
			$stmt=$this->db->prepare("SELECT * FROM instagramsite.proxy ");
			$stmt->execute();

			if ($stmt->rowCount()==1) {

				$row=$stmt->fetch(PDO::FETCH_ASSOC);
				$proxyy=$row['proxy'].":".rand(20000,25000);
				
				$proxyy="127.0.0.1:8866";
				$pass="";
				
				
				}				   
								   
		   	return ['status' => TRUE,'proxy' => $proxyy,'pass' => $pass];
			
			
		} catch (Exception $e) {

			return ['status' => FALSE, 'error' => $e->getMessage()];
			
		}

	}
	

	  

	 public function curl($proxy,$pass,$url,$agent,$cookilerim,$headers,$posts,$ref,$method,$http)
	{

		try {
					$ch  = curl_init();
					curl_setopt($ch, CURLOPT_URL, $url);
					
							if($proxy != "")
					{
						
						curl_setopt($ch, CURLOPT_PROXY, "$proxy");
					}
					
					if($pass != "")
					{
						curl_setopt($ch, CURLOPT_PROXYUSERPWD, "$pass");
					}
					if($cookilerim != "")
					{
					curl_setopt($ch, CURLOPT_COOKIEJAR, $cookilerim);
					curl_setopt($ch, CURLOPT_COOKIEFILE, $cookilerim);
					}
					
					if($agent != "")
					{
						curl_setopt($ch, CURLOPT_USERAGENT, $agent);
					}
					else
					{
						curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
					}
					
					if($method != "")
					{
					curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
					}
					if($http != "")
					{
					curl_setopt($ch, CURLOPT_HTTP_VERSION, $http);
					}	
					if($headers != "")
					{
					curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
					}
					curl_setopt($ch, CURLOPT_HEADER, 1);    
					
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
						curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0); 
				   
					curl_setopt($ch, CURLOPT_TIMEOUT, 30);
					curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate, br'); 
						curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
					curl_setopt($ch, CURLOPT_FRESH_CONNECT,true);
					   curl_setopt($ch, CURLOPT_COOKIESESSION, true );
				curl_setopt( $ch, CURLOPT_AUTOREFERER, true );

					curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
						curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
					curl_setopt($ch, CURLOPT_VERBOSE, true);
					
						if($posts != "")
					{
					curl_setopt($ch, CURLOPT_POST, 1);
					curl_setopt($ch, CURLOPT_POSTFIELDS, $posts);

					}
					
				if($ref != "")
					{
					curl_setopt($ch, CURLOPT_REFERER, $ref);

					}


					 $don = curl_exec($ch);
					$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
				$header_data = substr($don, 0, $header_size);
				$body = substr($don, $header_size);
	
								   
		   	return ['status' => TRUE ,'data'=> $body,'header_data'=> $header_data];
			
		} catch (Exception $e) {

			return ['status' => FALSE, 'error' => $e->getMessage()];
			
		}

	}
	
	public function rawtime()
	{

		try {
			
			$sure = round(microtime(true) * 1000);
			$bol1=substr($sure,0,9);
			$bol2=substr($sure,10,2);
			$Rawclienttime=$bol1.".".$bol2;
								   
		   	return ['status' => TRUE ,'data'=> $Rawclienttime];
			
		} catch (Exception $e) {

			return ['status' => FALSE, 'error' => $e->getMessage()];
			
		}

	}  

	public function version()
	{

		try {
			$version="fe808146fcbce04d3a692219680092ef89873fda1e6ef41c09a5b6a9852bed94";
							   
		   	return ['status' => TRUE ,'data'=> $version];
			
		} catch (Exception $e) {

			return ['status' => FALSE, 'error' => $e->getMessage()];
			
		}

	}  

	

	public function signature($data)
	{

		try {

			$data="signed_body=SIGNATURE.".json_encode($data,true);
		   	return ['status' => TRUE ,'data'=> $data];
			
		} catch (Exception $e) {

			return ['status' => FALSE, 'error' => $e->getMessage()];
			
		}

	}  
	public function agent()
	{

		try {

			$data="Android (24/7.0; 320dpi; 720x1280; samsung; SM-J530FM; j5y17lte; samsungexynos7870; tr_TR; 104766893)";
				$data="Instagram 168.0.0.24.350 ".$data;				   
		   	return ['status' => TRUE ,'data'=> $data];
			
		} catch (Exception $e) {

			return ['status' => FALSE, 'error' => $e->getMessage()];
			
		}

	}  
	
	
	public function headers($veriler)
	{

		try {
       

				$header=[
				"X-Bloks-Version-Id: ".$veriler["version"], 				
				"X-IG-App-Locale: tr_TR",
                "X-IG-Device-Locale: tr_TR",
                "X-IG-Mapped-Locale: tr_TR",
                "X-IG-Connection-Speed: -1kbps",
                "X-IG-Bandwidth-Speed-KBPS: -1.000",
                "X-IG-Bandwidth-TotalBytes-B: 0",
                "X-IG-Bandwidth-TotalTime-MS: 0",
                "X-Bloks-Is-Layout-RTL: false",
                "X-Bloks-Is-Panorama-Enabled: false",
                "X-IG-Connection-Type: WIFI",
                "X-IG-Capabilities: 3brTvx8=",
                "X-IG-App-ID: 567067343352427",
                "Accept-Language: tr-TR, en-US",
                "Accept-Encoding: gzip, deflate",
                "Host: b.i.instagram.com",
                "X-FB-HTTP-Engine: Liger",
                "X-FB-Client-IP: True",
				"User-Agent: ".$veriler["agent"],
				"X-IG-Device-ID: ".$veriler["device_id"],
			    "X-IG-Android-ID: ".$veriler["android_id"]
				];
							   
								   
		   	return ['status' => TRUE ,'data'=> $header];
			
		} catch (Exception $e) {

			return ['status' => FALSE, 'error' => $e->getMessage()];
			
		}

	}  

		public function v4()
	{

		try {
			$veri= sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
					mt_rand(0, 0xffff), mt_rand(0, 0xffff),
					mt_rand(0, 0xffff),
					mt_rand(0, 0x0fff) | 0x4000,
					mt_rand(0, 0x3fff) | 0x8000,
					mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
					);
			
			return ['status' => TRUE,'data'=>$veri];
			 
		} catch (Exception $e) {

			return ['status' => FALSE, 'error' => $e->getMessage()];
			
		}

	}
	
	
	public function randv4($length = 16)
	{

		try {
			
			$characters = 'abcdef0123456789';
			$charactersLength = strlen($characters);
			$rndstr = '';
			for ($i = 0; $i < $length; $i++) {
				$rndstr .= $characters[rand(0, $charactersLength - 1)];
			}
			
		   	return ['status' => TRUE ,'data'=> $rndstr];
			
		} catch (Exception $e) {

			return ['status' => FALSE, 'error' => $e->getMessage()];
			
		}

	}


		
}

?>
