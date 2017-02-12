<?php
require "./MediaHander.class.php";
require "../file.class.php";
// test();
//debug the function get_diery_info,yaohuan @20170210
function test(){
	$temp_str="pic_url:68396160\n";
	$Id=str_replace("pic_url:", '',$temp_str);
	$Id=str_replace("\n", '',$Id);
	$open_url=fromIdtoUrl($Id);    
	echo $open_url;
	}

function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}
function get_diery_info($mydir){
	$usr_info=null;
	$show_tile=TRUE;	
	$filehander=new clsFile($mydir);
	$fp_res=$filehander->open();
	while (!feof($fp_res)) {
		$temp_str=$filehander->read_line($fp_res);
		$show_tile=($show_tile && preg_match('/^mid_url/',$temp_str))?FALSE:$show_tile;
		$temp_str=(!$show_tile && preg_match('/^usrname/',$temp_str))? "":$temp_str;
		if(preg_match('/^pic_url:[0-9]{2,}/',$temp_str)){
			$MediaId=str_replace("pic_url:", '',$temp_str);
			$MediaId=str_replace("\n","",$MediaId);
			//$open_url=fromIdtoUrl($MediaId);
			$temp_str="pic_url: <a href=serverroot.'/showOpenMedia/index.php?MediaId=".$MediaId."'>click to see your picture🐴</a>"."\n";
			//debug by yaohuan at 20170210;
			$temp_str=(defined("APPLICATION"))?"<li>".$temp_str."</li>":$temp_str;
		}
		$usr_info .= $temp_str;
		if(!defined("APPLICATION") && strlen(utf8_decode($usr_info))>2048){
	                $filehander->close($fp_res);
			return NULL;			
			//$usr_info .= "<a href=serverroot.'/mydiery/addiery.php?debug=yes&recordtime='".$msg_content."'>You seemed to have more diary here</a>";
			//break;
			}		
	}
	$filehander->close($fp_res);	
	return $usr_info;
}


function fromIdtoUrl($mediaId){
	$mediaHander=new MediaHander();
	return $mediaHander->getOpenMdUrl($mediaId);

}


function get_all_diery($base_dir,$usr){
$info="Time:%s
msgcontent:%s
pic_url:%s
vedio_url:%s
";	
	$mydir=$base_dir."log";
	$temp_fp_res=addtemp(SAE_TMP_PATH.$usr);	
	$filehander=new clsFile($mydir);
	$fp_res=$filehander->open();
	$record_count=1;
	while (!feof($fp_res)&&$record_count>=1) {
	$diery_record=$filehander->read_line($fp_res);
	$total_str=get_diery_info($base_dir.$diery_record);
	$diery_info=sprintf($info,get_element(1,$total_str),get_element(2,$total_str),get_element(3,$total_str),get_element(4,$total_str));
	$filehander->write($temp_fp_res,$diery_info);
	$record_count++;		
	}
	$filehander->close($fp_res);
	$filehander->close($temp_fp_res);	
	return SAE_TMP_PATH.$usr;
}
function check_log($mydir){
	$filehander=new clsFile($mydir);
	return $filehander->is_exists($mydir);
}

function addiery($my_filecontent,$mydir){
	$opmethod="readWriteAndAdd";
	$filehander=new clsFile($mydir,$opmethod);
	$fp_res=$filehander->open();
	$filehander->write($fp_res,$my_filecontent);
	$filehander->close($fp_res);
}
function addusr($usr,$mydir){
	$opmethod="readWriteAndAdd";
	$filehander=new clsFile($mydir,$opmethod);
	$fp_res=$filehander->open();
	$filehander->write($fp_res,$usr);
	$filehander->close($fp_res);
}
function addlog($log,$mydir){
	$opmethod="readWriteAndAdd";
	$filehander=new clsFile($mydir,$opmethod);
	$fp_res=$filehander->open();
	$filehander->write($fp_res,$log);
	$filehander->close($fp_res);
}
function addtemp($mydir){
	$opmethod="readWriteAndAdd";
	$filehander=new clsFile($mydir,$opmethod);
	$fp_res=$filehander->open();
	return $fp_res;
}
function get_cordfile_name($cordtime){
$file_name=date("Ymd",$cordtime);
return $file_name;
}
function get_element($line_num,$info_str){
$temp_arr= explode("\n",$info_str);
$reslt_arr=explode(":",$temp_arr[$line_num-1]);
return str_replace(' ', '',$reslt_arr[1]);
}
function get_num($str){
   $re=preg_match('/[0-9]*/',$str,$arry);
   return $arry[0];
}
function add_my_diery($usrname,$time,$msg_content,$picurl="",$mid_url=""){

   $info="usrname:%s
time:%s
msg_content:%s
pic_url:%s
mid_url:%s
";
//echo $msg_content;
$my_filecontent=sprintf($info,$usrname,$time,$msg_content,$picurl,$mid_url);
$base_dir="saekv://mydiery/";
$usr_base_dir=$base_dir.str_replace(' ', '',$usrname)."/";
$my_diery_dir=$usr_base_dir.get_cordfile_name($time);
$my_log_dir=$usr_base_dir."log";
if(time()-$time>5){
echo "illegal invest";        
exit();	  	
}
else{	
	addiery($my_filecontent."\n",$my_diery_dir);
	addlog(get_cordfile_name($time)."\n",$my_log_dir);
	//echo get_all_diery($usr_base_dir,$usrname);
	return 200;
}
}

function get_my_diery($usrname,$time,$record_name){
$base_dir="saekv://mydiery/";
$usr_base_dir=$base_dir.str_replace(' ', '',$usrname)."/";
$my_diery_dir=$usr_base_dir.$record_name;
if(abs(time()-$time)>5){
return "NULL";        
exit();	  	
}
else{	
	if(check_log($my_diery_dir)){
	return get_diery_info($my_diery_dir);
}
	else{return "no diery in ".$record_name;}
}
}

?>

