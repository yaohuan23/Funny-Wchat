<?php
@include_once "./config_setting.php";

class MediaHander{
	private $mediaId;
	private $fileId;
        private $folderId;	
public function __construct(){
	$this->mediaId = "null";
	$this->fileId="null";
    
    }
function addMdToOpeld($remoteUrl,$authon=OPENLOAD_AUTHON,$authon_key=OPENLOAD_AUTHON_KEY){
	$pre_str="https://api.openload.co/1/remotedl/add?login=%s&key=%s&url=%s";
	$myQuery=sprintf($pre_str,$authon,$authon_key,$remoteUrl);
	$openload_resultJson=file_get_contents($myQuery);
	$total_resultJson=json_decode($openload_resultJson)->{'result'};
	$this->mediaId=$total_resultJson->{'id'};
	$this->folderId=$total_resultJson->{'folderid'};
	return $total_resultJson=json_decode($openload_resultJson)->{'status'};

}

public function getMediaId(){
return $this->mediaId;
}

private function getFileId(){
return $this->fileId;
}
private function getFolderId(){
return $this->folderId;
}
function getOpenMdUrl($mediaId="68381725",$authon=OPENLOAD_AUTHON,$authon_key=OPENLOAD_AUTHON_KEY){
	//$mediaId=$this->getMediaId();
	$pre_str="https://api.openload.co/1/remotedl/status?login=%s&key=%s&id=%s";
        $myQuery= sprintf($pre_str,$authon,$authon_key,$mediaId);
        $resultJson=file_get_contents($myQuery);
	return json_decode($resultJson)->{'result'}->{$mediaId}->{'url'};
	//return $resultJson; for debug by yaohuan
}

function getSplash($mediaId="http://mobilemooc.sinaapp.com",$authon=OPENLOAD_AUTHON,$authon_key=OPENLOAD_AUTHON_KEY){
	$mediaId=$this->getMediaId();
	$pre_str="https://api.openload.co/1/file/getsplash?login=%s&key=%s&file=%s";
        $myQuery= sprintf($pre_str,$authon,$authon_key,$mediaId);
        $resultJson=file_get_contents($myQuery);
        return json_decode($resultJson)->{'result'};
}

}
?>
