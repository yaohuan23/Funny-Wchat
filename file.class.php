<?php
/***************************************************************************************
文件名：File.cls.php
文件简介：类clsFile的定义，对文件操作的封装
版本：2.0  最后修改日期：2011-8-23
****************************************************************************************/
//!defined('INIT_PHPV') && die('No direct script access allowed');
class clsFile
{
   private $fileName_str;         //文件的路径
   private $fileOpenMethod_str;   //文件打开模式
   
   function __construct($fileName_str='',$fileOpenMethod_str='readOnly')//路径，默认为空；模式，默认均为只读
   {
       //构造函数，完成数据成员的初始化
       $this->fileName_str=$fileName_str;
       $this->fileOpenMethod_str=$fileOpenMethod_str;
   }
   
   function __destruct()
   {
       //析构函数
   }
   
   public function __get($valName_val)//欲取得的数据成员名称
   {
       //特殊函数，取得指定名称数据成员的值
          return $this->$valName_val;
   }
   
   private function on_error($errMsg_str='Unkown Error!',$errNo_int=0)//错误信息，错误代码
   {
        echo '程序错误：'.$errMsg_str.'错误代码：'.$errNo_int;//出错处理函数
   }
   
   public function open()
   {
       //打开相应文件，返回文件资源标识
          //根据fileOpenMethod_str选择打开方式
          switch($this->fileOpenMethod_str)
          {
                 case 'readOnly':
                    $openMethod_str='r';      //只读，指针指向文件头  
                  break;
                 case 'readWrite':
                    $openMethod_str='r+';     //读写，指针指向文件头
                    break;
                 case 'writeAndInit':
                    $openMethod_str='w';      //只写，指针指向文件头将大小截为零，不存在则创建
                    break;
                 case 'readWriteAndInit':
                    $openMethod_str='r+';     //读写，指针指向文件头将大小截为零，不存在则创建
                    break;
                 case 'writeAndAdd':
                    $openMethod_str='a';      //只写，指针指向文件末尾，不存在则创建
                    break;
                 case 'readWriteAndAdd':
                    $openMethod_str='a+';     //读写，指针指向文件末尾，不存在则创建
                    break;
                 default:
                    $this->on_error('Open method error!',310);//出错处理
                    exit;
          }

	try{
	$fp_res=fopen($this->fileName_str,$openMethod_str);          
          //打开文件       
          if(!$fp_res)
          {
                 $this->on_error('Can\'t open the file!',301);//出错处理
                 exit;
          }
          
          return $fp_res;
 	  }  
	catch(Exception $e){

				echo $e->getMessage();
				exit;			   
				}
}
   
   public function close($fp_res)//由open返回的资源标识
   {
       //关闭所打开的文件
          if(!fclose($fp_res))
          {
                 $this->on_error('Can\'t close the file!',302);//出错处理
                 exit;
          }
   }
   
   public function write()//$fp_res,$data_str,$length_int:文件资源标识，写入的字符串，长度控制
   {
       //将字符串string_str写入文件fp_res，可控制写入的长度length_int
          //判断参数数量，调用相关函数
          $argNum_int=func_num_args();//参数个数
          
          $fp_res=func_get_arg(0);          //文件资源标识
          $data_str=func_get_arg(1);        //写入的字符串
          
          if($argNum_int==3)
          {
                 $length_int=func_get_arg(2);  //长度控制
              if(!fwrite($fp_res,$data_str,$length_int))
              {
                    $this->on_error('Can\'t write the file!',303);//出错处理
                    exit;
              }
          }
          else
          {
                 if(!fwrite($fp_res,$data_str))
              {
                    $this->on_error('Can\'t write the file!',303);//出错处理
                    exit;
              }
          }
   }
   
   public function read_line()//$fp_res,$length_int:文件资源标识，读入长度
   {
       //从文件fp_res中读入一行字符串，可控制长度
          //判断参数数量
          $argNum_int=func_num_args();
          $fp_res=func_get_arg(0);
          if($argNum_int==2)
          {
              $length_int=func_get_arg(1);
              $string_str=fgets($fp_res,$length_int);
              return $string_str;
       }
       else
       {
              $string_str=fgets($fp_res);
              return $string_str;
	}
   }
   
   public function read($fp_res,$length_int)//文件资源标识，长度控制
   {
          $string_str=fread($fp_res,$length_int);
          return $string_str;
   }
   
   public function is_exists($fileName_str)//文件名
   {
       //检查文件$fileName_str是否存在，存在则返回true，不存在返回false
          return file_exists($fileName_str);
   }

/******************取得文件大小*********************/
/*
取得文件fileName_str的大小
$fileName_str 是文件的路径和名称
返回文件大小的值
*/
   public function get_file_size($fileName_str)//文件名
   {
       return filesize($fileName_str);
   }

/******************转换文件大小的表示方法*********************/
/*
$fileSize_int文件的大小，单位是字节
返回转换后带计量单位的文件大小
*/
   public function change_size_express($fileSize_int)//文件名
   {
       if($fileSize_int>1024)
       {
          $fileSizeNew_int=$fileSize_int/1024;//转换为K
          $unit_str='KB';
            if($fileSizeNew_int>1024)
             {
              $fileSizeNew_int=$fileSizeNew_int/1024;//转换为M
              $unit_str='MB';
             }
          $fileSizeNew_arr=explode('.',$fileSizeNew_int);
          $fileSizeNew_str=$fileSizeNew_arr[0].'.'.substr($fileSizeNew_arr[1],0,2).$unit_str;
       }
       return $fileSizeNew_str;
   }
/******************重命名文件*********************/
/*
将oldname_str指定的文件重命名为newname_str
$oldName_str是文件的原名称
$newName_str是文件的新名称
返回错误信息
*/ 
   public function rename_file($oldName_str,$newName_str)
   {
          if(!rename($oldName_str,$newName_str))
          {
                 $this->on_error('Can\'t rename file!',308);
                 exit;
          }
   }

/******************删除文件*********************/
/*
将filename_str指定的文件删除
$fileName_str要删除文件的路径和名称
返回错误信息
*/
   public function delete_file($fileName_str)//
   {
          if(!unlink($fileName_str))
          {
                 $this->on_error('Can\'t delete file!',309);//出错处理
                 exit;
          }
   }

/******************取文件的扩展名*********************/
/*
取filename_str指定的文件的扩展名
$fileName_str要取类型的文件路径和名称
返回文件的扩展名
*/
   public function get_file_type($fileName_str)
   {
          $fileNamePart_arr=explode('.',$fileName_str);
          while(list(,$fileType_str)=each($fileNamePart_arr))
          {
           $type_str=$fileType_str;
          }
           return $type_str;
   }

/******************判断文件是否是规定的文件类型*********************/
/*
$fileType_str规定的文件类型
$fileName_str要取类型的文件路径和名称
返回false或true
*/
   public function is_the_type($fileName_str,$fileType_arr)
   {
       $cheakFileType_str=$this->get_file_type($fileName_str);
       if(!in_array($cheakFileType_str,$fileType_arr))
       {
        return false;
          }
       else
       {
          return true;
       }
   }

/******************上传文件，并返回上传后的文件信息*********************/
/*
$fileName_str本地文件名
$filePath上传文件的路径，如果$filePath是str则上传到同一目录用一个文件命名，新文件名在其加-1，2，3..，如果是arr则顺序命名
$allowType_arr允许上传的文件类型，留空不限制
$maxSize_int允许文件的最大值，留空不限制
返回的是新文件信息的二维数组：$reFileInfo_arr
*/
   public function upload_file($fileName_str,$filePath,$allowType_arr='',$maxSize_int='')
{      
       $fileName_arr=$_FILES[$fileName_str]['name'];  //文件的名称
       $fileTempName_arr=$_FILES[$fileName_str]['tmp_name'];  //文件的缓存文件
       $fileSize_arr=$_FILES[$fileName_str]['size'];//取得文件大小
       $reFileInfo_arr=array();
       $num=count($fileName_arr)-1;
       for($i=0;$i<=$num;$i++)
      {
           if($fileName_arr[$i]!='') 
        {
          if($allowType_arr!='' and !$this->is_the_type($fileName_arr[$i],$allowType_arr))//判断是否是允许的文件类型
          {
           $this->on_error('The file is not allowed type!',310);//出错处理
           break;
          }

          if($maxSize_int!='' and $fileSize_arr[$i]>$maxSize_int)
          {
           $this->on_error('The file is too big!',311);//出错处理
           break;
          }
  
          $j=$i+1;
          $fileType_str=$this->get_file_type($fileName_arr[$i]);//取得文件类型
          if(!is_array($filePath))
          {
          $fileNewName_str=$filePath.'-'.($j).'.'.$fileType_str;
          }
          else
          {
          $fileNewName_str=$filePath_arr[$i].'.'.$fileType_str;
          }
          copy($fileTempName_arr[$i],$fileNewName_str);//上传文件
          unlink($fileTempName_arr[$i]);//删除缓存文件

          //---------------存储文件信息--------------------//
          $doFile_arr=explode('/',$fileNewName_str);
          $doFile_num_int=count($doFile_arr)-1;
          $reFileInfo_arr[$j]['name']=$doFile_arr[$doFile_num_int];
          $reFileInfo_arr[$j]['type']=$fileType_str;
          $reFileInfo_arr[$j]['size']=$this->change_size_express($fileSize_arr[$i]);
      }
   }
   return $reFileInfo_arr;
}

/******************备份文件夹*********************/
}

?>
