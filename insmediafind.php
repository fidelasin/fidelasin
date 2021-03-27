<?php 


class insbul
{
	private $db;
	private $dbhost=servername;
	private $dbuser=username;
	private $dbpass=password;
	private $dbname=database;
	
	function __construct()
	{ 
		try {
				if (!isset($this->db)) {
			$this->db=new PDO('mysql:host='.$this->dbhost.';dbname'.$this->dbname.';charset=utf8',$this->dbuser,$this->dbpass);
			 $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			// echo "Bağlantı Başarılı";
				} 

		} catch (Exception $e) {
			
			die("Bağlantı başarısız:".$e->getMessage());
		}
	}
	

	public function mediabul($media)
	{

		try {
			$username=$_SESSION["users"]["username"];
			$stmt=$this->db->prepare("SELECT * FROM instagramsite.insuser where username='$username' ");
			$stmt->execute();
			if ($stmt->rowCount()>0) 
{
					$durum="1";
				$row=$stmt->fetch(PDO::FETCH_ASSOC);
			$rawtime=$this->rawtime()["data"];	
			$veriler["authorization"]=$row["authorization"];
			$veriler["blog_version_id"]=$row["blog_version_id"];
			$veriler["guid"]=$row["guid"];				
			$veriler["proxy"]=$row["proxy"];
			$veriler["pass"]=$row["pass"];
			$veriler["agent"]=$row["agent"];
			$veriler["version"]=$row["version"];
			$veriler["agent"]=$row["agent"];
			$veriler["device_id"]=$row["device_id"];
			$veriler["android_id"]=$row["android_id"];
			$veriler["pigeon_id"]=$row["pigeon_id"];
			$cookilerim = dirname(__FILE__)."/../cook/".$username.".txt" ; 
			
			$cookiecek=$this->cookieayikla($cookilerim)["data"];
						$midx=	$cookiecek["midx"];
						$csrf_token=$cookiecek["csrf_token"];
						$rur=$cookiecek["rur"];
						$ds_user_id=$cookiecek["ds_user_id"];
						$sessionid=$cookiecek["sessionid"];
						
						
						
			$header=$this->headers($veriler)['data'];
			$veriler["headerana"]=$header;
			
			$header[]= "X-Pigeon-Rawclienttime: ".$rawtime;
			$header[]= "Content-Type: application/x-www-form-urlencoded; charset=UTF-8";
			$header[]= "Connection: keep-alive";
			$header[]= "X-Pigeon-Session-Id: ".$veriler["pigeon_id"];
			$header[]= "X-IG-App-Startup-Country: TR";
			$header[]= "X-IG-WWW-Claim: 0";
			$header[]= "Authorization: ".$row["authorization"];
			$header[]= "X-MID: $midx";
			$header[]= "IG-U-IG-DIRECT-REGION-HINT: ATN";
			$header[]= "IG-U-DS-USER-ID: $ds_user_id";
			$header[]= "IG-U-RUR: $rur";
                      
                                			
			$post="";
			$ref="";
			$method="GET";
			$http="";
			$url ="https://b.i.instagram.com/api/v1/oembed/?url=".$media;
			 $data=$this->curl($veriler["proxy"],$veriler["pass"],$url,$veriler["agent"],$cookilerim,$header,$post,$ref,$method,$http);
			$body=$data["data"];
			$json=json_decode($body,true);
			$media_id=$json["media_id"];
			
			$url ="https://i.instagram.com/api/v1/media/".$media_id."/info/";
			$data=$this->curl($veriler["proxy"],$veriler["pass"],$url,$veriler["agent"],$cookilerim,$header,$post,$ref,$method,$http);
			$body=$data["data"];
			$json=json_decode($body,true);
			$comment_count=$json["items"][0]["comment_count"];
			$like_count=$json["items"][0]["like_count"];
	
			   } 
		   	return ['status' => TRUE ,'media_id'=> $media_id,'comment_count'=> $comment_count,'like_count'=> $like_count];
			
		} catch (Exception $e) {

			return ['status' => FALSE, 'error' => $e->getMessage()];
			
		}

	}	
	
	
	public function bayihesapbul($hesap)
	{

		try {
			
			$stmt=$this->db->prepare("SELECT * FROM instagramsite.insuser where challange='0'  order by RAND() ");
			$stmt->execute();
			if ($stmt->rowCount()>0) {
					$durum="1";
				$row=$stmt->fetch(PDO::FETCH_ASSOC);
		echo "<br>".	$username=$row["username"];
				
			$rawtime=$this->rawtime()["data"];	
			$veriler["authorization"]=$row["authorization"];
			$veriler["blog_version_id"]=$row["blog_version_id"];
			$veriler["guid"]=$row["guid"];
			$veriler["proxy"]=$row["proxy"];
			$veriler["pass"]=$row["pass"];
			$veriler["agent"]=$row["agent"];
			$veriler["version"]=$row["version"];
			$veriler["agent"]=$row["agent"];
			$veriler["device_id"]=$row["device_id"];
			$veriler["android_id"]=$row["android_id"];
			$veriler["pigeon_id"]=$row["pigeon_id"];
			$cookilerim = dirname(__FILE__)."/../cook/".$username.".txt" ; 
			
			$cookiecek=$this->cookieayikla($cookilerim)["data"];
						$midx=	$cookiecek["midx"];
						$csrf_token=$cookiecek["csrf_token"];
						$rur=$cookiecek["rur"];
						$ds_user_id=$cookiecek["ds_user_id"];
						$sessionid=$cookiecek["sessionid"];
						
						
						
			$header=$this->headers($veriler)['data'];
			$veriler["headerana"]=$header;
			
			$header[]= "X-Pigeon-Rawclienttime: ".$rawtime;
			$header[]= "Content-Type: application/x-www-form-urlencoded; charset=UTF-8";
			$header[]= "Connection: keep-alive";
			$header[]= "X-Pigeon-Session-Id: ".$veriler["pigeon_id"];
			$header[]= "X-Bloks-Version-Id: ".$veriler["blog_version_id"];
			$header[]= "X-IG-App-Startup-Country: TR";
			$header[]= "X-IG-WWW-Claim: 0";
			$header[]= "Authorization: ".$row["authorization"];
			$header[]= "X-MID: $midx";
			$header[]= "IG-U-IG-DIRECT-REGION-HINT: ATN";
			$header[]= "IG-U-DS-USER-ID: $ds_user_id";
			$header[]= "IG-U-RUR: $rur";
                      
                                			
			$post="";
			$ref="";
			$method="GET";
			$http="";
			$url ="https://b.i.instagram.com/api/v1/fbsearch/topsearch_flat/?search_surface=top_search_page&timezone_offset=10800&count=30&query=".$hesap."&context=blended";
			$data=$this->curl($veriler["proxy"],$veriler["pass"],$url,$veriler["agent"],$cookilerim,$header,$post,$ref,$method,$http);
			$body=$data["data"];
			$json=json_decode($body,true);
			print_r($json);
			var_dump($json);
			$pk=$json['list'][0]['user']['pk'];
			$page_token=$json['page_token'];
			$rank_token=$json['rank_token'];
			
			
		echo "<br>".	$url ="https://i.instagram.com/api/v1/tags/".$hesap."/info/?page_token=$page_token&rank_token=$rank_token";
			$data=$this->curl($veriler["proxy"],$veriler["pass"],$url,$veriler["agent"],$cookilerim,$header,$post,$ref,$method,$http);
			$body=$data["data"];
			$json=json_decode($body,true);
			print_r($json);
			var_dump($json);
			die();
			$media_count=$json["user"]["media_count"];
			$follower_count=$json["user"]["follower_count"];
			$following_count=$json["user"]["following_count"];
			$usertags_count=$json["user"]["usertags_count"];
			$account_type=$json["user"]["account_type"];

			
			 
			   } 
			return ['status' => TRUE ,'pk'=> $pk,'media_count'=> $media_count,'follower_count'=> $follower_count,'following_count'=> $following_count,'usertags_count'=> $usertags_count,'account_type'=> $account_type];

		   	
		} catch (Exception $e) {

			return ['status' => FALSE, 'error' => $e->getMessage()];
			
		}

	}	

      
		
	public function hesapbul($hesap)
	{

		try {
			$username=$_SESSION["users"]["username"];
			$stmt=$this->db->prepare("SELECT * FROM instagramsite.insuser where username='$username' ");
			$stmt->execute();
			if ($stmt->rowCount()>0) {
					$durum="1";
				$row=$stmt->fetch(PDO::FETCH_ASSOC);
				
			$rawtime=$this->rawtime()["data"];	
			$veriler["authorization"]=$row["authorization"];
			$veriler["blog_version_id"]=$row["blog_version_id"];
			$veriler["guid"]=$row["guid"];
			$veriler["proxy"]=$row["proxy"];
			$veriler["pass"]=$row["pass"];
			$veriler["agent"]=$row["agent"];
			$veriler["version"]=$row["version"];
			$veriler["agent"]=$row["agent"];
			$veriler["device_id"]=$row["device_id"];
			$veriler["android_id"]=$row["android_id"];
			$veriler["pigeon_id"]=$row["pigeon_id"];
			$cookilerim = dirname(__FILE__)."/../cook/".$username.".txt" ; 
			
			$cookiecek=$this->cookieayikla($cookilerim)["data"];
						$midx=	$cookiecek["midx"];
						$csrf_token=$cookiecek["csrf_token"];
						$rur=$cookiecek["rur"];
						$ds_user_id=$cookiecek["ds_user_id"];
						$sessionid=$cookiecek["sessionid"];
						
						
						
			$header=$this->headers($veriler)['data'];
			$veriler["headerana"]=$header;
			
			$header[]= "X-Pigeon-Rawclienttime: ".$rawtime;
			$header[]= "Content-Type: application/x-www-form-urlencoded; charset=UTF-8";
			$header[]= "Connection: keep-alive";
			$header[]= "X-Pigeon-Session-Id: ".$veriler["pigeon_id"];
			$header[]= "X-Bloks-Version-Id: ".$veriler["blog_version_id"];
			$header[]= "X-IG-App-Startup-Country: TR";
			$header[]= "X-IG-WWW-Claim: 0";
			$header[]= "Authorization: ".$row["authorization"];
			$header[]= "X-MID: $midx";
			$header[]= "IG-U-IG-DIRECT-REGION-HINT: ATN";
			$header[]= "IG-U-DS-USER-ID: $ds_user_id";
			$header[]= "IG-U-RUR: $rur";
                      
                                			
			$post="";
			$ref="";
			$method="GET";
			$http="";
			$url ="https://b.i.instagram.com/api/v1/fbsearch/topsearch_flat/?search_surface=top_search_page&timezone_offset=10800&count=30&query=".$hesap."&context=blended";
			$data=$this->curl($veriler["proxy"],$veriler["pass"],$url,$veriler["agent"],$cookilerim,$header,$post,$ref,$method,$http);
			$body=$data["data"];
			$json=json_decode($body,true);
			var_dump($json);
			$pk=$json['list'][0]['user']['pk'];
			
			
			$url ="https://i.instagram.com/api/v1/users/".$pk."/info/?from_module=feed_contextual_profile";
			$data=$this->curl($veriler["proxy"],$veriler["pass"],$url,$veriler["agent"],$cookilerim,$header,$post,$ref,$method,$http);
			$body=$data["data"];
			$json=json_decode($body,true);
			
			$media_count=$json["user"]["media_count"];
			$follower_count=$json["user"]["follower_count"];
			$following_count=$json["user"]["following_count"];
			$usertags_count=$json["user"]["usertags_count"];
			$account_type=$json["user"]["account_type"];

			
			 
			   } 
			return ['status' => TRUE ,'pk'=> $pk,'media_count'=> $media_count,'follower_count'=> $follower_count,'following_count'=> $following_count,'usertags_count'=> $usertags_count,'account_type'=> $account_type];

		   	
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

		
		
}

?>
