<?php
@include_once("./functions.php");
//@include_once();

/*
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
*/




class WechatResponse{

//private const $base_session_dir="saekv://we/session/";
//private $lenAvailable=0;
function sendDiary($usrname,$time,$msg_content){
         $totalStr=get_my_diery($usrname,$time,$msg_content);
	 $res_status=getStatus($totalStr)
	 saveResStatus($res_status);
	 $menue=($res_status==0)?"","<a href=rootserver.'/mydiery/addiery.php?debug=yes&recordtime='".$msg_content."'>You seemed to have more diary here</a>";
	 return substr($totalStr,);
}


private function getStatus($totalStr){
	$status=(strlen(utf8_decode($totalStr))<=2048)?0:$status+1;
	return $status;
}

function saveResStatus($status){
file_put_contents(RESST_BASEDIR.$usrname.".txt",$status);
}


}


?>
