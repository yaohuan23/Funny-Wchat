<?php
//$financer=new financer();
//$result=$financer ->getData("");
//echo $result;
class financer{
function getData($list){
$myheader="%s
Host: g.sae.sina.com.cn
x-sae-accesskey: %s
x-sae-timestamp: %s
Authorization: %s
Content-Type: application/csv;charset=utf-8
Connection: close

";
$access_key=SINAAPPEUSER;
$secret_key=SINAAPPKEY;
$TIMESTAMP = time();
$url="/financehq/list=".$list;
$URI = "GET ".$url." HTTP/1.1";
$msgToSign="GET\n".$url."\nx-sae-accesskey:".$access_key."\nx-sae-timestamp:".$TIMESTAMP;
$authon_key=$this->getSignature($msgToSign,$secret_key);
$my_sendheader=sprintf($myheader,$URI,$access_key,$TIMESTAMP,$authon_key);
return $this->geturl_result($my_sendheader); 
}

function geturl_result($http_header){
$result="";
$fp = fsockopen("g.sae.sina.com.cn", 80, $errno, $errstr, 30);
if (!$fp) {
    echo "$errstr ($errno)<br />\n";
} else {
    $out =$http_header;
    fwrite($fp, $out);
    while (!feof($fp)) {
        $result.=iconv("gbk", "UTF-8", fgets($fp, 128));
    }
    fclose($fp);
}
return $result;
}

function getSignature($str, $key) {  
            $signature = base64_encode(hash_hmac("sha256", $str, $key, true));  
            return "SAEV1_HMAC_SHA256 ".$signature;  
       }  
}
?>
