<?php
class TuLingMachine{
  function get_response($request_xml){
$get_str_temp="http://www.tuling123.com/openapi/api?key=2fbfddd9fe2b50b556f653cd6a4cf65f&info=%s";
//$Content=json_decode($request_json)->{'content'};
$Content=$request_xml->Content;
//$Content=$request_xml['content'];//Get测试时使用的。
$get_str= sprintf($get_str_temp,$Content);
$myjson=file_get_contents($get_str);
$res_msg=json_decode($myjson)->{'text'};
//echo $Content.$get_str;
//echo $res_msg;
return $res_msg;
}
}
?>
