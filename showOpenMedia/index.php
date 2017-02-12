<?php
require "../mydiery/MediaHander.class.php";
     //$mediaHander=new MediaHander();
     //$open_url=fromIdtoUrl("68398112");

if(isset($_GET["MediaId"])){
     $mediaId=$_GET["MediaId"];
     //$mediaHander=new MediaHander();
     $open_url=fromIdtoUrl($mediaId);
     //echo $mediaId."\n".$open_url;
}
elseif(isset($_GET["openurl"])){
$open_url=$_GET["openurl"];
}

function fromIdtoUrl($mediaId){
	$mediaHander=new MediaHander();
	return $mediaHander->getOpenMdUrl($mediaId);

}

?>
<html>
  <head>
    <title>chinaeshu.cn</title>	
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
    <div>
<iframe src=<?php echo $open_url; ?> scrolling="yes" frameborder="0" width="1080" height="1920" allowfullscreen="true" webkitallowfullscreen="true" mozallowfullscreen="true">
</iframe>
</div>  

</html>
