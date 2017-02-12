<?php

//require "Diery.class.php";
//$diery_hander=new Diery();
//echo $diery_hander->writediery("today i make a diary on computer","oW7P2t4eP91fwGIXRNb-jbeGNBHI");
//echo $diery_hander->getdiery("oW7P2t4eP91fwGIXRNbjbeGNBHI","20160917");
require "MediaHander.class.php";
imgMsgResponse("http://mmbiz.qpic.cn/mmbiz/bDODVI7JGQGQoQ708fd1mVmwEzY2Nic1EELZiaE0lic8iczGib8icXhoQd3lLRCbRLX6ytSYHvJRpNjEHleEzcGAXJ5Q/0","123");

function imgMsgResponse($myxml ,$xmlstring_temp){
	$mediaHander=new MediaHander();
	$openLoad_status=$mediaHander->addMdToOpeld($myxml);
	$openload_url=$mediaHander->getOpenMdUrl();
	if(!$openload_url){
            $openload_url="your media is on the way to the permanent server, can you try the temporay url:\n";
          }
	echo $openLoad_status;
	echo $openload_url;
}

?>
