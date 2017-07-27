<?php 
include_once("all.php");chkadcookie();
header("Content-type:text/html; charset=utf-8");
@$g=$_GET["g"];
$file='../'.$cachepath."update.txt";
$url='http://www.axublog.com/update';
#$url='http://localhost/update';
@$a=filemtime($file);
$a=date('Ymd',$a);
$date=date('Ymd',time());
if(!file_exists($file)|$a!=$date|$g=='g'){@$text=@file_get_contents($url);if($text==''){$text='对不起，暂时无法获取远程信息，请向官网反馈，谢谢';}if(file_put_contents ($file, $text)){} }
else{$text = file_get_contents($file);}
echo $text;
setcookie("latestversion",$text, time()+60*60*240,"/; HttpOnly" , "",'');
?>
