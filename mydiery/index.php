<?php
require "functions.php";
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["authen"])) {
   $authen=test_input($_GET["authen"]);
   $authenstr=base64_decode($authen);
   $usrname=test_input($_GET["username"]);
   $time=get_num(test_input($_GET["time"]));
if(get_num($authenstr)!=$time){exit;}
   $msg_content = test_input($_GET["msg_content"]);
   $pic_url= test_input($_GET["pic_url"]);
   $mid_url= test_input($_GET["mid_url"]);
   $diery_method= test_input($_GET["type"]);
	if ($diery_method=="1"){
	add_my_diery($usrname,$time,$msg_content,$picurl,$mid_url);
	}
	elseif($diery_method=="0"){
	get_my_diery($usrname,$time);	
	}
}

?>

