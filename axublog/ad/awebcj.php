<?php
require_once('all.php');chkadcookie();





$cjurl=strtolower($_GET["cjurl"]);
if($cjurl==''){$cjurl=$_SESSION['cjurl'];}
if($cjurl==''){$cjurl='http://g.cn';}
if(substr($cjurl,0,7)!='http://'){$cjurl='http://'.$cjurl;}
if(substr($cjurl,-1)=='/'){$cjurl=substr($cjurl,0,-1);}

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>管理</title>
<link rel="stylesheet" href="css/right.css" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>






<div id=position><div id="icon-art"></div><h1>单个网页自动采集</h1></div>
<div id=br></div>



<div class="yj_green" id=full>
<b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b>
<div class="boxcontent"></div>
<div class="t1"><div class="t2">



<?php
$cjtag=$_SESSION['tags'];
echo <<<EOF
<form>
<p>采集网址：<input type=text value='{$cjurl}' name=cjurl size=90></p>
<p>添加tags：<input type=text value='{$cjtag}' name=tags size=50></p>
<p><input type=button value='采集' onclick="location.href='?g=gcj&cjurl='+cjurl.value+'&tags='+tags.value"></p>
<p></p>
</form>
EOF;


$g=$_GET["g"];
    switch ($g)
    {
    case "gcj":gcj();break; 
    #default:artlist();break; 
    }
?>


</div></div>
<b class="b4b"></b><b class="b3b"></b><b class="b2b"></b><b class="b1b"></b>
</div>








<?php
mysql_close($con);
echo runtime();
?>
</body>
</html>

















<?php



function gcj(){
$cjtag=$_GET["tags"];
if($cjtag!=''){if(substr($cjtag,-1)!=','){$cjtag=$cjtag.',';}}
$_SESSION['tags']=$cjtag;


$cjurl=strtolower($_GET["cjurl"]);
echo'<p>正在采集网址：'.$cjurl.'</p>';
echo'<p>tags：'.$cjtag.'</p>';
if(str_replace('apps.hi.baidu.com','',$cjurl)!=$cjurl){die('采集不到数据！');}
cjaweb($cjurl);




}







function TestUtf8($text) 
{ 
if(strlen($text) < 3) return false; 
$lastch = 0; 
$begin = 0; 
$BOM = true; 
$BOMchs = array(0xEF, 0xBB, 0xBF); 
$good = 0; 
$bad = 0; 
$notAscii = 0; 
for($i=0; $i < strlen($text); $i++) 
{ 
$ch = ord($text[$i]); 
if($begin < 3) 
{ 
$BOM = ($BOMchs[$begin]==$ch); 
$begin += 1; 
continue; 
} 

if($begin==4 && $BOM) break; 

if($ch >= 0x80 ) $notAscii++; 

if( ($ch&0xC0) == 0x80 ) 
{ 
if( ($lastch&0xC0) == 0xC0 ) 
{ 
$good += 1; 
} 
else if( ($lastch&0x80) == 0 ) 
{ 
$bad += 1; 
} 
} 
else if( ($lastch&0xC0) == 0xC0 ) 
{ 
$bad += 1; 
} 
$lastch = $ch; 
} 
if($begin == 4 && $BOM) 
{ 
return 2; 
} 
else if($notAscii==0) 
{ 
return 1; 
} 
else if ($good >= $bad ) 
{ 
return 2; 
} 
else 
{ 
return 0; 
} 
}





function curl_get_file_contents($URL){
$c = curl_init();
curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
//curl_setopt($c, CURLOPT_HEADER, 1);//输出远程服务器的header信息
curl_setopt($c, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 2.0.50727;http://www.huhunet.com)');
curl_setopt($c, CURLOPT_URL, $URL);  
$contents = curl_exec($c);  
 curl_close($c); 
 if ($contents) {return $contents;} 
 else {return FALSE;}
 } 



function cjaweb($cjurl){
set_time_limit(20);
$_SESSION['cjurl']=$cjurl;
ini_set('user_agent','Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1;)');
$cjhtml=file_get_contents($cjurl);
if(strlen($cjhtml)<20){die($cjurl.$cset.'采集不到内容数据！');}


$cjhtml2=strtolower(substr($cjhtml,1,500));
$cjhtml2=str_replace('<','',$cjhtml2);
$cjhtml2=str_replace('"','',$cjhtml2);
$cjhtml2=str_replace('\'','',$cjhtml2);
$cjhtml2=str_replace('/','',$cjhtml2);
$cjhtml2=str_replace(' ','',$cjhtml2);
$cjhtml2=str_replace('gbk','gb2312',$cjhtml2);
preg_match('|charset\=(.*)\>|isU',$cjhtml2,$getcset); 
if($getcset[1]=='big5'){$cset='big5';}
else{$cset=$getcset[1];}
$cset=substr(0,6,$cset);


		if($cset==''){
		if(TestUtf8($cjhtml)==0|TestUtf8($cjhtml)==1){$cset='gb2312';}
		else{$cset='utf-8';}
		}


if($cset=='gb2312'){$cjhtml=mb_convert_encoding($cjhtml,"utf-8","gb2312");}
elseif($cset=='big5'){$cjhtml=mb_convert_encoding($cjhtml,"utf-8","big5");}
$cjhtml=strtolower($cjhtml);



$get_c_str = new get_c_str;
$cjtitle = $get_c_str -> get_str($cjhtml,'<title>','</title>');
if(strlen($cjtitle)<1){die('采集不到标题数据！');}
$cjtitle=strip_tags($cjtitle);
$cjtitle=str_replace("\n","",$cjtitle);
$cjtitle=str_replace("\r","",$cjtitle);
$cjtitle=strip_tags($cjtitle);
$dtitle=cut_str($cjtitle,50);
$dtitle=str_replace(' ','',$dtitle);
$dtitle=str_replace('.','',$dtitle);
$durl=str_replace('http://','',$cjurl);
$dtitle=$dtitle.'_'.$durl;
#die($dtitle);

$cjhtml= preg_replace("@<script(.*?)</script>@is","",$cjhtml); 
$cjhtml= preg_replace("@<iframe(.*?)</iframe>@is","",$cjhtml); 
$cjhtml= preg_replace("@<style(.*?)</style>@is","",$cjhtml); 
$cjhtml=strip_tags($cjhtml);

$cjhtml=str_replace('	','',$cjhtml);
$cjhtml=str_replace('  ','',$cjhtml);
$cjhtml=str_replace("\n","<br>",$cjhtml);
$cjhtml=str_replace("\r","<br>",$cjhtml);
$cjhtml=str_replace("<br> <br>","",$cjhtml);
$cjhtml=str_replace("<br>&nbsp;<br>","",$cjhtml);
$cjhtml=str_replace("<br><br><br><br>",'',$cjhtml);
$cjhtml=str_replace("<br><br><br>",'',$cjhtml);
$cjhtml=str_replace("<br><br>","<br>",$cjhtml);
$cd=strlen($cjhtml);
if($cd>1000){$cjhtml=cut_str($cjhtml,500);}
$cjhtml=goneilian($cjhtml);



$dcontent='<b>网站快照</b>：<br>'.$cjhtml.'<br>编码：'.$cset.'<br><p><a href="'.$cjurl.'" target=_blank>本页为网站快照，您可以浏览完整页面》 '.$durl.'</a></p>';
#die($dtitle.'ffff'.$dcontent);
global $date;
$_SESSION['title']=$dtitle;
$_SESSION['content']=$dcontent;
$_SESSION['date']=$date;
$_SESSION['author']=$cjurl;
$_SESSION['htmlname']='';

if($durl!=''&&$dtitle!=''&&$date!=''&&$dcontent!=''){echo'<br><h3>采集成功，开始写入数据库！</h3>';echo"<script>location.href='art.php?g=addsave'</script>";}


}




//$sourcestr 是要处理的字符串

//$cutlength 为截取的长度(即字数)

function cut_str($sourcestr,$cutlength)

{

   $returnstr='';

   $i=0;

   $n=0;

   $str_length=strlen($sourcestr);//字符串的字节数

   while (($n<$cutlength) and ($i<=$str_length))

    {

      $temp_str=substr($sourcestr,$i,1);

      $ascnum=Ord($temp_str);//得到字符串中第$i位字符的ascii码

      if ($ascnum>=224)    //如果ASCII位高与224，

      {

         $returnstr=$returnstr.substr($sourcestr,$i,3); //根据UTF-8编码规范，将3个连续的字符计为单个字符         

         $i=$i+3;            //实际Byte计为3

         $n++;            //字串长度计1

      }

       elseif ($ascnum>=192) //如果ASCII位高与192，

      {

         $returnstr=$returnstr.substr($sourcestr,$i,2); //根据UTF-8编码规范，将2个连续的字符计为单个字符

         $i=$i+2;            //实际Byte计为2

         $n++;            //字串长度计1

      }

       elseif ($ascnum>=65 && $ascnum<=90) //如果是大写字母，

      {

         $returnstr=$returnstr.substr($sourcestr,$i,1);

         $i=$i+1;            //实际的Byte数仍计1个

         $n++;            //但考虑整体美观，大写字母计成一个高位字符

      }

       else                //其他情况下，包括小写字母和半角标点符号，

      {

         $returnstr=$returnstr.substr($sourcestr,$i,1);

         $i=$i+1;            //实际的Byte数计1个

         $n=$n+0.5;        //小写字母和半角标点等与半个高位字符宽...

      }

    }

          if ($str_length>$cutlength){

          $returnstr = $returnstr . "...";//超过长度时在尾处加上省略号

      }

     return $returnstr;

}



function httptocj($u,$c){
global $weburl;
$u=str_replace($weburl,'$weburl$',$u);
$u = preg_replace('/ href="\/(.*?)/',' href="'.$c.'\1',$u); 
$u=str_replace('$weburl$',$weburl,$u);
return $u;
}







class get_c_str {
var $str;
var $start_str;
var $end_str;
var $start_pos;
var $end_pos;
var $c_str_l;
var $contents;
function get_str($str,$start_str,$end_str){
   $this->str = $str;
   $this->start_str = $start_str;
   $this->end_str = $end_str;
   $this->start_pos = strpos($this->str,$this->start_str)+strlen($this->start_str);
     $this->end_pos = strpos($this->str,$this->end_str);
   $this->c_str_l = $this->end_pos - $this->start_pos;
   $this->contents = substr($this->str,$this->start_pos,$this->c_str_l);
   return $this->contents;
}
}







?>