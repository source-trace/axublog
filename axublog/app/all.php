<?php
if (file_exists("../../cmsconfig.php"))  
    {require_once("../../cmsconfig.php");}  
    else{
    echo "<script language='javascript'>";
    echo "location='../../install/goinstall.php';";
    echo "</script>"; 
    } 


include_once("../../cmsconfig.php");
include_once("../../class/c_db.php");
include_once("../../class/c_other.php");
include_once("../../class/c_runtime.php");
include_once("../../class/c_page.php");
include_once("../../class/c_md5.php");


function chkadcookie(){
        if(!file_exists('../../cache')){mkdir('../../cache');}
        @$file="../../cache/txtchkad.txt";          //定义文件
$fp=fopen($file,"r");         //以写入方式打开文件
$txtchkad=fread($fp,4096);         //读取文件内容
$txtchkad2=str_replace(@$_COOKIE["chkad"],'',$txtchkad);
if(@$_SESSION["chkad"]==''&&@$_COOKIE["chkad"]==''){header("Content-type:text/html; charset=utf-8");echo '<div id=redmsg>请登录。。。</div>';exit;}
if($txtchkad==$txtchkad2){header("Content-type:text/html; charset=utf-8");echo '<div id=redmsg>请登录。。。</div>';exit;}
}


?>