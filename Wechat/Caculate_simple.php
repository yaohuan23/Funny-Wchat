<?php
/*test code
$caculater=new Caculate_simple();
$echo_str=$caculater->caculate("1+3");
echo $echo_str;
*/
Class Caculate_simple{
public function caculate($caculate_str){
  try{  $str_ret=0;
    preg_match('/^[0-9]{1,}(?=[\+,\-,\*,\/,\^])/',$caculate_str,$cat_arr1);
    $cat_num1=implode("|",$cat_arr1);
    preg_match('/[\+,\-,\*,\/,\^]/',$caculate_str,$cat_simbol);
    preg_match('/[0-9]{1,}$/',$caculate_str,$cat_arr2);
    $cat_num2=implode("|",$cat_arr2);
    switch (trim(implode("|",$cat_simbol))){
    case "+":
    $str_ret=$cat_num1+$cat_num2;
    break;
    case "-":
    $str_ret=$cat_num1-$cat_num2;
    break;
    case "×":
    $str_ret=$cat_num1*$cat_num2;
    break;
    case "*":
    $str_ret=$cat_num1*$cat_num2;
    break;
    case "÷":
    if((int)trim($cat_num2)==0){
    throw new Exception("erro type1");
    }
    $str_ret=$cat_num1/$cat_num2;
    break;
    case "/":
    if((int)trim($cat_num2)==0){
    throw new Exception("erro type1");
    }
    $str_ret=$cat_num1/$cat_num2;
    break;
    case "^":
    $str_ret=pow($cat_num1,$cat_num2);
}
}
catch(Exception $e){
    return "error type1：the dividend numble shoud't be zero（被除数不能为零）";
}
return $str_ret; 
}
}
?>
