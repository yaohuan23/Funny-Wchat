<?php
require "file.class.php";
class Diery{
public function setMode($usrname,$stat){
$filehander=new clsFile();
$myusername=preg_replace('/[^0-9,a-z,A-Z]/',"",$usrname);
	try{
	file_put_contents("saekv://mydiery/".$myusername."/stat",$stat);	
}
	catch(Exception $e){
	return "something is wrong in set_mode_function".$e;	
	}
}

public function check_mode($username){
$filehander=new clsFile();
$usrname=preg_replace('/[^0-9,a-z,A-Z]/',"",$username);
if($filehander->is_exists("saekv://mydiery/".$usrname."/stat")){
$mode=file_get_contents("saekv://mydiery/".$usrname."/stat");
	if($mode=="1"){
	return true;
	}	
}
}
public function writediery($msg_content,$username,$pic_url="",$mid_url=""){
$get_query=serverroot."/mydiery/addiery.php?time=%s&username=%s&msg_content=%s&pic_url=%s&mid_url=%s&authen=%s&type=%u";
$my_getQuery=sprintf($get_query,time(),preg_replace('/[^0-9,a-z,A-Z]/',"",$username),urlencode($msg_content),urlencode($pic_url),urlencode($mid_url),$this->get_authonStr(time()),1);
return file_get_contents($my_getQuery);
}
public function getdiery($username,$msg_content){
$get_query=serverroot."/mydiery/addiery.php?time=%s&username=%s&msg_content=%s&authen=%s&type=%u";
$my_getQuery=sprintf($get_query,time(),preg_replace('/[^0-9,a-z,A-Z]/',"",$username),$msg_content,$this->get_authonStr(time()),0);
return file_get_contents($my_getQuery);
}

private  function get_authonStr($pre_str){
return base64_encode($pre_str);
}


}

?>
