<?php 

class insislem
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
	
	public function dmgonder($yetki)
	{

		try {
			$stmt=$this->db->prepare("SELECT * FROM instagramsite.dmhesap where tamamlanma='0' and miktar>say order by id asc,yetki desc");
			$stmt->execute();
			if ($stmt->rowCount()>0) {
				$rowx=$stmt->fetch(PDO::FETCH_ASSOC);	
				$pk=$rowx["pk"];
				$hesap=$rowx["hesap"];
				$dmhesapuserid=$rowx["userid"];
				$dmhesapid=$rowx["id"];
					
			$stmt=$this->db->prepare("SELECT * FROM instagramsite.dmmesaj where userid='$dmhesapuserid' order by say asc");
			$stmt->execute();
			$rowxx=$stmt->fetch(PDO::FETCH_ASSOC);
			echo "<br>dmmesaj: ".$dmmesaj=$rowxx["dmmesaj"];		
			echo "<br>dmmesaj: ".$dmmesajid=$rowxx["id"];		
			
			
			$stmt=$this->db->prepare("SELECT * FROM instagramsite.insuser where $yetki>=yetki  and challange='0' and proxy <>'' and id <> '$dmhesapid' order by tarih asc");
			$stmt->execute();
			if ($stmt->rowCount()>0) {
			$row=$stmt->fetch(PDO::FETCH_ASSOC);
			$username=$row["username"];
			echo "<br>gorevid: ".$gorevid=$row["id"];
			$rawtime=$this->rawtime()["data"];	
			$veriler["authorization"]=$row["authorization"];
			$veriler["blog_version_id"]=$row["blog_version_id"];
			$veriler["guid"]=$row["guid"];
			$veriler["proxy"]=$row["proxy"];
			$veriler["proxy"]=$row["proxy"];
			$veriler["pass"]=$row["pass"];
			$veriler["agent"]=$row["agent"];
			$veriler["version"]=$row["version"];
			$veriler["agent"]=$row["agent"];
			$veriler["device_id"]=$row["device_id"];
			$veriler["phone_id"]=$row["phone_id"];
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
			
			$header[]= "X-Bloks-Version-Id: ".$veriler["blog_version_id"];
			
			$header[]= "X-Pigeon-Rawclienttime: ".$rawtime;
			$header[]= "Content-Type: application/x-www-form-urlencoded; charset=UTF-8";
			$header[]= "Connection: keep-alive";
			$header[]= "X-Pigeon-Session-Id: ".$veriler["pigeon_id"];
			$header[]= "X-IG-App-Startup-Country: TR";
			$header[]= "X-IG-WWW-Claim: 0";
			$header[]= "Authorization: ".$veriler["authorization"];
			$header[]= "X-MID: $midx";
			$header[]= "IG-U-IG-DIRECT-REGION-HINT: ATN";
			$header[]= "IG-U-DS-USER-ID: $ds_user_id";
			$header[]= "IG-U-RUR: $rur";
                     
                                			
			$post="";
			$ref="";
			$method="GET";
			$http="";
			$url ="https://b.i.instagram.com/api/v1/direct_v2/threads/get_by_participants/?recipient_users=[" .$pk. "]&seq_id=1&limit=20" ;
			 $data=$this->curl($veriler["proxy"],$veriler["pass"],$url,$veriler["agent"],$cookilerim,$header,$post,$ref,$method,$http);

			$postdata = [
			"recipient_users"=> "[[".$pk."]]",
            "mentioned_user_ids"=>  "[]",
            "action"=> "send_item",
            "is_shh_mode"=>  "0",
            "send_attribution"=>  "message_button",
            "client_context"=>  $rawtime,
            "_csrftoken"=>  $csrf_token,
            "text"=>  $dmmesaj,
            "device_id"=>  $veriler["android_id"],
            "mutation_token"=>  $rawtime,
            "_uuid"=>  $veriler["guid"],
            "offline_threading_id"=>  $rawtime
					];	
	
				    $post=$this->signature($postdata)["data"];
					$header[]="Content-Length: ". strlen($post);
	

			$ref="";
			$method="POST";
			$http="";
			$url ="https://b.i.instagram.com/api/v1/direct_v2/threads/broadcast/text/";
			 $data=$this->curl($veriler["proxy"],$veriler["pass"],$url,$veriler["agent"],$cookilerim,$header,$post,$ref,$method,$http);
			
			$body=$data["data"];
			$json=json_decode($body,true);
			 $status=$json["status_code"];
			 $zaman = time();
			 echo $gorevid;
				if($status=="200")
				{
					
					$stmts=$this->db->prepare("UPDATE instagramsite.dmmesaj SET say=say+1 WHERE id='$dmmesajid'");
					$stmts->execute();
					$stmts=$this->db->prepare("UPDATE instagramsite.insuser SET yapilangorev=yapilangorev+1 WHERE id='$gorevid'");
					$stmts->execute();
					$stmts=$this->db->prepare("UPDATE instagramsite.dmhesap SET say=say+1 WHERE id='$dmhesapid'");
					$stmts->execute();				}
				else
				{
					$stmts=$this->db->prepare("UPDATE instagramsite.insuser SET challange='1' WHERE id='$gorevid'");
					$stmts->execute();
				}
				$stmts=$this->db->prepare("UPDATE instagramsite.insuser SET tarih='$zaman' WHERE id='$gorevid'");
					$stmts->execute();
			   } 
			}
		   	return ['status' => TRUE ,'data'=> $status];
			
		} catch (Exception $e) {

			return ['status' => FALSE, 'error' => $e->getMessage()];
			
		}

	}
	
	public function begenigonder($yetki)
	{

		try {
			
			$stmt=$this->db->prepare("SELECT * FROM instagramsite.begeni where tamamlanma='0' and miktar>say order by id asc,yetki desc");
			$stmt->execute();
			if ($stmt->rowCount()>0) {
				$rowx=$stmt->fetch(PDO::FETCH_ASSOC);	
				$media_id=$rowx["media_id"];
				$hesap=$rowx["hesap"];
			 	$hesapid=$rowx["id"];
			$stmt=$this->db->prepare("SELECT * FROM instagramsite.insuser where $yetki>=yetki and challange='0' and proxy <>''  order by tarih asc");
			$stmt->execute();
			if ($stmt->rowCount()>0) {
			$row=$stmt->fetch(PDO::FETCH_ASSOC);
			$username=$row["username"];
			$gorevid=$row["id"];
			
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
			$veriler["phone_id"]=$row["phone_id"];
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
			$url ="https://b.i.instagram.com/api/v1/media/" .$media_id. "/info/";
			$data=$this->curl($veriler["proxy"],$veriler["pass"],$url,$veriler["agent"],$cookilerim,$header,$post,$ref,$method,$http);
			$postdata = [
			"delivery_class"=>  "organic",
            "media_id"=>  $media_id,
            "carousel_index"=>  "0",
            "_csrftoken"=>   $csrf_token,
            "radio_type"=>  "wifi-none",
            "_uid"=>  $ds_user_id,
            "_uuid"=>   $veriler["phone_id"],
            "is_carousel_bumped_post"=>  "false",
            "container_module"=>  "feed_short_url",
            "feed_position"=>  "0"
					];	

				    $post=$this->signature($postdata)["data"];
					$header[]="Content-Length: ". strlen($post);
	
	
			$ref="";
			$method="POST";
			$http="";
			$url ="https://b.i.instagram.com/api/v1/media/" .$media_id. "/like/";
			$data=$this->curl($veriler["proxy"],$veriler["pass"],$url,$veriler["agent"],$cookilerim,$header,$post,$ref,$method,$http);
			$body=$data["data"];
			$json=json_decode($body,true);
			 $status=$json["status"];
			 $zaman = time();
			 echo $gorevid;
				if($status=="ok")
				{
					
					$stmts=$this->db->prepare("UPDATE instagramsite.begeni SET say=say+1 WHERE id='$hesapid'");
					$stmts->execute();
					$stmts=$this->db->prepare("UPDATE instagramsite.insuser SET yapilangorev=yapilangorev+1 WHERE id='$gorevid'");
					$stmts->execute();
				}
				else
				{
					$stmts=$this->db->prepare("UPDATE instagramsite.insuser SET challange='1' WHERE id='$gorevid'");
					$stmts->execute();
				}
				$stmts=$this->db->prepare("UPDATE instagramsite.insuser SET tarih='$zaman' WHERE id='$gorevid'");
					$stmts->execute();
			   } 
			}
		   	return ['status' => TRUE ,'data'=> $following];
			
		} catch (Exception $e) {

			return ['status' => FALSE, 'error' => $e->getMessage()];
			
		}

	}

	
		public function takipcigonder($yetki)
	{

		try {
			
			$stmt=$this->db->prepare("SELECT * FROM instagramsite.takipci where tamamlanma='0' and miktar>say  order by id asc,yetki desc");
			$stmt->execute();
			if ($stmt->rowCount()>0) {
				$rowx=$stmt->fetch(PDO::FETCH_ASSOC);	
				$pk=$rowx["pk"];
			 	$takipciid=$rowx["id"];
				echo "SELECT * FROM instagramsite.insuser where $yetki>=yetki  and challange='0' and proxy <>'' order by tarih asc";
			$stmt=$this->db->prepare("SELECT * FROM instagramsite.insuser where pass not like '%bommedya%' and $yetki>=yetki  and challange='0' and proxy <>'' order by tarih asc");
			$stmt->execute();
			if ($stmt->rowCount()>0) {
			$row=$stmt->fetch(PDO::FETCH_ASSOC);
			echo "<br>".	$username=$row["username"];
			$gorevid=$row["id"];
			
			$rawtime=$this->rawtime()["data"];	
			$veriler["authorization"]=$row["authorization"];
			$veriler["blog_version_id"]=$row["blog_version_id"];
			$veriler["guid"]=$row["guid"];			
			echo  "<br>".	$veriler["proxy"]=$row["proxy"];
			$veriler["pass"]=$row["pass"];
			$veriler["agent"]=$row["agent"];
			$veriler["version"]=$row["version"];
			$veriler["agent"]=$row["agent"];
			$veriler["device_id"]=$row["device_id"];
			$veriler["phone_id"]=$row["phone_id"];
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
			$url ="https://b.i.instagram.com/api/v1/friendships/show/".$pk."/";
			$data=$this->curl($veriler["proxy"],$veriler["pass"],$url,$veriler["agent"],$cookilerim,$header,$post,$ref,$method,$http);
			var_dump($data);
			 		$postdata = [
						"radio_type"=> "wifi-none",
						"user_id"=>$pk,
						"_csrftoken"=> $csrf_token,
						"_uid"=> $ds_user_id,
						"device_id"=> $veriler["android_id"],
						"_uuid"=>$veriler["device_id"]
					];	

				    $post=$this->signature($postdata)["data"];
					$header[]="Content-Length: ". strlen($post);
	
			$ref="";
			$method="POST";
			$http="";
			$url ="https://b.i.instagram.com/api/v1/friendships/create/".$pk."/";
			$data=$this->curl($veriler["proxy"],$veriler["pass"],$url,$veriler["agent"],$cookilerim,$header,$post,$ref,$method,$http);
			$body=$data["data"];
			$json=json_decode($body,true);
			var_dump($data["data"]);
			 $following=$json["friendship_status"]["following"];
			 $status=$json["status"];
			 $zaman = time();
			// echo $gorevid;
				if($following=="true" or $status=="ok" )
				{
					echo "başarılı";
					$stmts=$this->db->prepare("UPDATE instagramsite.takipci SET say=say+1 WHERE id='$takipciid'");
					$stmts->execute();
					$stmts=$this->db->prepare("UPDATE instagramsite.insuser SET yapilangorev=yapilangorev+1 WHERE id='$gorevid'");
					$stmts->execute();
				}
				else
				{
					if(strpos($body,"challenge_required")>0)
					{echo "challange yedi ";
					$stmts=$this->db->prepare("UPDATE instagramsite.insuser SET challange='1' WHERE id='$gorevid'");
					$stmts->execute();
					}
				}
				$stmts=$this->db->prepare("UPDATE instagramsite.insuser SET tarih='$zaman' WHERE id='$gorevid'");
					$stmts->execute();
			   } 
			}
		   	return ['status' => TRUE ,'data'=> $following];
			
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
			$veriler["blog_version_id"]=$row["blog_version_id"];
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
			echo "mmm".$data=$json['list'][0]['user']['pk'];
			
			   } 
		   	return ['status' => TRUE ,'data'=> $data];
			
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
