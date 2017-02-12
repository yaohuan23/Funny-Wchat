<?php
echo $_GET["echostr"];
//include 'Get_tokenumble.php';
require "TuLIngMachine.class.php";
//require 'RecordMsg.php';
require "MediaHander.class.php";
require "Caculate_simple.php";
require "financer.class.php";
require "Diery.class.php";
$xmlstring_temp1= "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%f</CreateTime>
<MsgType><![CDATA[%s]]></MsgType>
<Content><![CDATA[%s]]></Content>
</xml>";
$xmlstring_temp2="<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%f</CreateTime>
<MsgType><![CDATA[%s]]></MsgType>
<ArticleCount>%d</ArticleCount>
<Articles>
<item>
<Title><![CDATA[%s]]></Title> 
<Description><![CDATA[%s]]></Description>
<PicUrl><![CDATA[%s]]></PicUrl>
<Url><![CDATA[%s]]></Url>
</item>
<item>
<Title><![CDATA[%s]]></Title> 
<Description><![CDATA[%s]]></Description>
<PicUrl><![CDATA[%s]]></PicUrl>
<Url><![CDATA[%s]]></Url>
</item>
</Articles>
</xml> ";
 /*
 微信来的消息数据模式：
 <xml>
 <ToUserName><![CDATA[toUser]]></ToUserName>
 <FromUserName><![CDATA[fromUser]]></FromUserName> 
 <CreateTime>1348831860</CreateTime>
 <MsgType><![CDATA[text]]></MsgType>
 <Content><![CDATA[this is a test]]></Content>
 <MsgId>1234567890123456</MsgId>
 </xml>
 微信来的事件数据模式：
 <xml><ToUserName><![CDATA[toUser]]></ToUserName>
<FromUserName><![CDATA[FromUser]]></FromUserName>
<CreateTime>123456789</CreateTime>
<MsgType><![CDATA[event]]></MsgType>
<Event><![CDATA[subscribe]]></Event>
<EventKey><![CDATA[qrscene_123123]]></EventKey>
<Ticket><![CDATA[TICKET]]></Ticket>
</xml>
 */
//$tuling_obg=new TuLingMachine();
//$tuling_msg=$tuling_obg->get_response($_GET);//Get测试时使用。
//echo $tuling_msg;
//echo "hello i am yaohuan";
$myxml = simplexml_load_string($GLOBALS['HTTP_RAW_POST_DATA']);
$MsgType=$myxml ->MsgType;
$Content=$myxml ->Content;
$send_time=$myxml ->CreateTime;
$username=$myxml ->FromUserName;
switch (trim($MsgType)){
    case "text":
    if (preg_match('/^[0-9]{1,}[\+,\-,\*,\/,\^,×,÷]{1,}[0-9]{1,}$/',$Content)){
        mathResponse($myxml ,$xmlstring_temp1,$Content);
	break;	
	}
	elseif(preg_match('/^sh[0-9]{6}(,sh|sz[0-9]{6}){0,}$|sz[0-9]{6}(,sh|sz[0-9]{6}){0,}$/',$Content)){
	financeResponse($myxml ,$xmlstring_temp1,$Content); 	
	break;
	}
	elseif(preg_match('/^笔记$|^diary$|^machinechat$|^聊天$|^20[0-9]{6}$/',$Content)){
	dieryResponse_two($myxml ,$xmlstring_temp1,$Content,$send_time,$username); 	
	break;
	}
    	dieryResponse_one($myxml,$xmlstring_temp1,$Content,$time,$username);
	//textMsgResponse($myxml,$xmlstring_temp);    
	break;
    case "event":
    eventMsgResponse($myxml ,$xmlstring_temp1);
    break;

    case "image":
	imgMsgResponse($myxml ,$xmlstring_temp1); 	
    break;
    }
/*<xml>
<ToUserName><![CDATA[toUser]]></ToUserName>
<FromUserName><![CDATA[fromUser]]></FromUserName>
<CreateTime>12345678</CreateTime>
<MsgType><![CDATA[image]]></MsgType>
<Image>
<MediaId><![CDATA[media_id]]></MediaId>
</Image>
</xml>*/
function dieryResponse_one($myxml,$xmlstring_temp,$Content,$time,$username){
$diery_hander=new Diery();
if($diery_hander->check_mode($username)){
	$ToUserName=$myxml ->ToUserName;
	$FromUserName=$myxml ->FromUserName;
	$return_code=$diery_hander->writediery($Content,$username);
	$post_str=str_replace("\n", '',"return code:".$return_code);
	$Msg_Type="text";
	$postxml = sprintf($xmlstring_temp,$FromUserName,$ToUserName,time(),$Msg_Type,$post_str);
	echo $postxml;	
}
else{
textMsgResponse($myxml,$xmlstring_temp);
}
}
function dieryResponse_two($myxml ,$xmlstring_temp,$Content,$time,$usrname){
$diery_hander=new Diery();
	switch($Content){
	case "笔记":
	$ToUserName=$myxml ->ToUserName;
	$FromUserName=$myxml ->FromUserName;
	$post_str="you changed to diary mode,enjoy =:)".$diery_hander->setMode($usrname,1);
	$Msg_Type="text";
	$postxml = sprintf($xmlstring_temp,$FromUserName,$ToUserName,time(),$Msg_Type,$post_str);
	echo $postxml;	
	break;

	case "diary":
	$ToUserName=$myxml ->ToUserName;
	$FromUserName=$myxml ->FromUserName;
	$post_str="you changed to diary mode,enjoy =:)".$diery_hander->setMode($usrname,1);
	$Msg_Type="text";
	$postxml = sprintf($xmlstring_temp,$FromUserName,$ToUserName,time(),$Msg_Type,$post_str);
	echo $postxml;	
	break;

	case "machinechat":
	$ToUserName=$myxml ->ToUserName;
	$FromUserName=$myxml ->FromUserName;
	$post_str="you changed to machine_chat mode,enjoy =:)".$diery_hander->setMode($usrname,0);
	$Msg_Type="text";
	$postxml = sprintf($xmlstring_temp,$FromUserName,$ToUserName,time(),$Msg_Type,$post_str);
	echo $postxml;	
	break;
	case "聊天":
	$ToUserName=$myxml ->ToUserName;
	$FromUserName=$myxml ->FromUserName;
	$post_str="you changed to machine_chat mode,enjoy =:)".$diery_hander->setMode($usrname,0);
	$Msg_Type="text";
	$postxml = sprintf($xmlstring_temp,$FromUserName,$ToUserName,time(),$Msg_Type,$post_str);
	echo $postxml;			
	break;
	default:
	$ToUserName=$myxml ->ToUserName;
	$FromUserName=$myxml ->FromUserName;
	$post_str="your diary in".$Content.":".$diery_hander->getdiery($usrname,$Content);
	$Msg_Type="text";
	$postxml = sprintf($xmlstring_temp,$FromUserName,$ToUserName,time(),$Msg_Type,$post_str);
	echo $postxml;
	
	}
}

function financeResponse($myxml ,$xmlstring_temp,$list){
$financer=new financer();
$result=$financer ->getData($list);
$ToUserName=$myxml ->ToUserName;
$FromUserName=$myxml ->FromUserName;
$post_str=$result;
$Msg_Type="text";
$postxml = sprintf($xmlstring_temp,$FromUserName,$ToUserName,time(),$Msg_Type,$post_str);
echo $postxml;
}
function mathResponse($myxml ,$xmlstring_temp,$math_str){
$caculater=new Caculate_simple();
$result=$caculater->caculate($math_str);
/*//$ToUserName=$myxml ->ToUserName;
$FromUserName=$myxml ->FromUserName;
$Msg_Type="text";
$post_str="result:";
$postxml = sprintf($xmlstring_temp,$FromUserName,$ToUserName,time(),$MsgType,$post_str);
echo $postxml;*/
$ToUserName=$myxml ->ToUserName;
$FromUserName=$myxml ->FromUserName;
$post_str=$result;
$Msg_Type="text";
$postxml = sprintf($xmlstring_temp,$FromUserName,$ToUserName,time(),$Msg_Type,$post_str);
echo $postxml;
}
function textMsgResponse($myxml ,$xmlstring_temp)
{
$tuling_obg=new TuLingMachine();
$tuling_msg=$tuling_obg->get_response($myxml );
//$myrecoder=new MsgRecorder();
//$myrecoder-> recordMsg();
$ToUserName=$myxml ->ToUserName;
$FromUserName=$myxml ->FromUserName;
//$CreateTime=$myxml ['CreateTime'];
$MsgType=$myxml ->MsgType;
$Content=$myxml ->Content;
$post_str="machine_response:\n".$tuling_msg;
$postxml = sprintf($xmlstring_temp,$FromUserName,$ToUserName,time(),$MsgType,$post_str);
echo $postxml;
}
function eventMsgResponse($myxml ,$xmlstring_temp)
{
$ToUserName=$myxml ->ToUserName;
$FromUserName=$myxml ->FromUserName;
$post_str="welcome to my wechat ,i am yaohuan23";
$Msg_Type="text";
$postxml = sprintf($xmlstring_temp,$FromUserName,$ToUserName,time(),$Msg_Type,$post_str);
echo $postxml;
}
 function newsMsgResponse($myxml ,$xmlstring_temp)
{
$Title="Thaks for your attention";
$Description="Mywebapplication";
$PicUrl="http://mobilemooc.sinaapp.com/Mypictures/login/chinaeshu.png";
$Url="http://mobilemooc.sinaapp.com";
$ToUserName=$myxml ->ToUserName;
$FromUserName=$myxml ->FromUserName;
$MsgType="news";
$ArticleCount=2;
$postxml = sprintf($xmlstring_temp,$FromUserName,$ToUserName,time(), $MsgType ,$ArticleCount ,$Title,$Description,$PicUrl,$Url,$Title,$Description,$PicUrl,$Url);
    echo $postxml;
}

//function for picture store;


function imgMsgResponse($myxml ,$xmlstring_temp,$username){
$ToUserName=$myxml ->ToUserName;
$FromUserName=$myxml ->FromUserName;
//$send_time=$myxml ->CreateTime;
$username=$myxml ->FromUserName;
$mediaHander=new MediaHander();
$openLoad_status=$mediaHander->addMdToOpeld($myxml->PicUrl);
$mediaId=$mediaHander->getMediaId();
$diery_hander=new Diery();
if($diery_hander->check_mode($username)){
	$return_code=$diery_hander->writediery("you uploaded a picture here.",$username,$mediaId);
	$post_str=str_replace("\n", '',"record status:".$return_code);
	$post_str=$post_str."\nupload status:".$openLoad_status;
	$Msg_Type="text";
	$postxml = sprintf($xmlstring_temp,$FromUserName,$ToUserName,time(),$Msg_Type,$post_str);
	echo $postxml;	
}

}






?>
