<?php
//AUTHOUR:yaohuan
// refresh in 2016.5
require "functions.php";
function debug($recordtime="20170210"){
	echo "you are now in debug module";
	echo get_my_diery("oW7P2t4eP91fwGlXRNbjbeGNBHI",time(),$recordtime);	
}
//debug module,created in 2017.02.11 by yaohuan
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["authen"])) {
   $authen=test_input($_GET["authen"]);
   $authenstr=base64_decode($authen); 	
   $usrname=test_input($_GET["username"]);
   $time=get_num(test_input($_GET["time"]));
   $msg_content = $_GET["msg_content"];
   $pic_url= $_GET["pic_url"];
   $mid_url= $_GET["mid_url"];
   $diery_method= test_input($_GET["type"]);
   if(get_num($authenstr)!=$time){
	echo "illegel";	
	exit;
	}
	if ($diery_method=="1"){
	echo add_my_diery($usrname,$time,$msg_content,$pic_url,$mid_url);
	return;
	}
	elseif($diery_method=="0"){
	$res_str=get_my_diery($usrname,$time,$msg_content);	
	$res_str=($res_str==NULL)?"you seemed to write too much today!<a href='http://genedit.sinaapp.com/mydiery/addiery.php?aplication=wechat&username=".$usrname."&recordtime=".$msg_content."'>Click here </a>":$res_str;
	echo $res_str;
	return;	
	}
}
?>
<html>
  <head>
    <title>your diary in</title>	
    <meta name="baidu-site-verification" content="INpOwMsNIy" />
    <meta http-equiv="教育" content="chinaeshu.cn"/>
    <meta http-equiv="义塾" content="自我介绍"/>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <!--<script type="text/javascript">
	alert("OMG!!it seemed that you can't see the picture directly on wechat\nplease open in a browser to check your media\nNOTICE:\nadvertisement here are not harmful to your device, thanks for your surport");
    </script>
    debug by yaohuan 20170211-->
    <link rel="stylesheet" type="text/css" href="http://mobilemooc.sinaapp.com/Mycss/login/login.css"/>
  </head>
  <body>
  <div>
    <a href="http://1.mobilemooc.sinaapp.com">
    <img src="http://mobilemooc.sinaapp.com/Mypictures/login/chinaeshu.png" alt="chinaeshu" border=0 />
    </a>
    <h>每个人都有平等的学习权利</h>
    </div>
<div class="box">
<ol>
<?php
if(isset($_GET["username"]) && isset($_GET["recordtime"]) && $_GET["aplication"]=="wechat"){
	$recordtime=$_GET["recordtime"];
	$usrname=$_GET["username"];
	//debug($recordtime);
	define("APPLICATION",$_GET["application"]);
	$diary=get_my_diery($usrname,time(),$recordtime);
        echo $diary;	
	//return;
}
?>
</ol>
<div>
<style>
	.box { width:100%;top:100px}
	.box ul{ margin: 0 auto; width:100%; list-style:none;}
	.box li {float:left; margin:12px 5px 0 5px; display:inline; width:90px; height:200px; }
</style>

</html>








<?php
if(defined("APPLICATION")){
return;
}
echo "<script type='text/javascript'>alert('you are not supposed to be here!')</script>";
?>




