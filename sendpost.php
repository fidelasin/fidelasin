$useragent="Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.75 Safari/537.36";
$cookilerim=dirname(__FILE__)."/log.txt" ; 

$xiajax="0cf715af355e";
$microtime = round(microtime(true) * 1000);
$ek='fb_uploader_'.$microtime;
$ref='https://www.instagram.com/';

$delimiter = '-------------' . uniqid();
$gidenisim=base64_encode("$ad $soyad");
$resimadi=randstr(15).".jpg";
$resim  ='https://fidelasin.icu/suatresim/'.$gidenisim;
$resimxx = file_get_contents($resim);
file_put_contents('yedekresim3/'.$resimadi, $resimxx);
$resimyol = 'yedekresim3/'.$resimadi;
list($width, $height, $image_type) = getimagesize(realpath($resimyol));
$srcImage = ImageCreateFromJPEG($resimyol);
$resImage = ImageCreateTrueColor($width, $height);
ImageCopyResampled($resImage, $srcImage, 0, 0, 0, 0, $width, $height, $width, $height);
ImageJPEG($srcImage, $resimyol, 100);
ImageDestroy($srcImage);
$data = file_get_contents($resimyol) ;
$headers = array(
'Accept: */*',
'Accept-Encoding: gzip, deflate, br',
'Accept-Language: en-US,en;q=0.9',
"User-Agent: $useragent",
'X-Requested-With: XMLHttpRequest',
'Content-Type: image/jpeg',
'Content-Length: ' . strlen($data),
"Referer: $ref",
'X-CSRFToken: '.$dcsrftoken,
'X-IG-WWW-Claim: 0',
'X-Instagram-AJAX: '.$xiajax	,
'X-Entity-Name: '.$ek,
'X-Entity-Length: '.strlen($data),
'X-Entity-Type: image/jpeg',
'X-IG-App-ID: 1217981644879628',
'Origin: https://www.instagram.com',
'Sec-Fetch-Dest: empty',
'Sec-Fetch-Mode: cors',
'Sec-Fetch-Site: same-origin',
'Connection: keep-alive',
'Offset: 0',
'X-Instagram-Rupload-Params: {"media_type":1,"upload_id":"'.$microtimemicrotime.'","upload_media_height":'.$height.',"upload_media_width":'.$width.'}',
'X-Instagram-Rupload-Params: {"media_type":1,"upload_id":"'.$microtime.'","upload_media_height":'.$height.',"upload_media_width":'.$width.'}',
'Host: www.instagram.com'
	);
	$method='POST';
	$http='';
	$url =  'https://www.instagram.com/rupload_igphoto/'.$ek;
    $ceks=curl($proxy,$pass,$url,$useragent,$cookilerim,$headers,$data,'','POST','HTTP/1.1');

$post = [
'upload_id' => $microtime,
'caption' => '',
'usertags' => '',
'custom_accessibility_caption' => '',
'retry_timeout' => ''
  
];
 $post=http_build_query($post);
$headers = array(
'Accept: */*',
'Accept-Encoding: gzip, deflate, br',
'Accept-Language: en-US,en;q=0.9',
'User-Agent: '.$useragent,
'X-Requested-With: XMLHttpRequest',
'Content-Length: '.strlen($post),
'Content-Type: application/x-www-form-urlencoded',
'Referer: https://www.instagram.com/create/details/',
'X-CSRFToken: '.$dcsrftoken,
'X-IG-App-ID: 936619743392459',
'X-IG-WWW-Claim: 0',
'X-Instagram-AJAX: '.$xiajax	,
'Origin: https://www.instagram.com',
'Connection: keep-alive',
'Host: www.instagram.com'
	);
	$ref='https://www.instagram.com/create/details/';
	$method='POST';
	$http='';
	$url =  'https://www.instagram.com/create/configure/';
	$data=curl($proxy,$pass,$url,$useragent,$cookilerim,$headers,$post,$ref,$method,$http);

function curl($proxy,$pass,$url,$useragent,$cookilerim,$headers,$posts,$ref,$method,$http) {

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
	
	if($useragent != "")
	{
		curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
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
//	preg_match('/name="csrf-token" content="(.*)"/i', $don, $m);
 //	$csrf=$m[1];
return $don;
}



function randstr($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


 function seo($bas)
{
	$bas = str_replace(array('"',"'"), NULL, $bas);
	$bul = array('Ç', 'Ş', 'Ğ', 'Ü', 'İ', 'Ö', 'ç', 'ş', 'ğ', 'ü', 'ö', 'ı', '-');
	$yap = array('c', 's', 'g', 'u', 'i', 'o', 'c', 's', 'g', 'u', 'o', 'i', ' ');
	$perma = strtolower(str_replace($bul, $yap, $bas));
	$perma = preg_replace("@[^A-Za-z0-9\-_]@i", ' ', $perma);
	$perma = trim(preg_replace('/\s+/',' ', $perma));
	$perma = str_replace(' ', '', $perma);
	return $perma;
}
function getMimeType($filePath)
    {
        if (!file_exists($filePath)) {
            throw new InvalidRequest("$filePath: failed to open file.");
        }
        
        $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
        $type = finfo_file($fileInfo, $filePath);
        finfo_close($fileInfo);

        return $type;
    }
