<?php
require_once('all.php');chkadcookie();



/*********
$file="sj.txt";
$fp=fopen($file,"r"); 
$text=fread($fp,4096*30);
$a=explode('[sjlist]',$text);
$shu=count($a)-1;
echo '[]共'.$shu.'个记录[]<br>';
for($i=1;$i<=$shu;$i++){
$a2=$a[$i-1];
$b=explode('[sjsplit]',$a2);
$title =$b[0];
$tags =$b[1];
$content =$b[2];
echo '[]第'.$i.'个[]<br>';
echo '[]'.$title.'[]<br>';
echo '[]'.$tags.'[]<br>';
echo '[]'.$content.'[]<br>';
}
die();
***********/






$g=$_REQUEST['g'];
if($g=='cj'){cj();}
if($g=='cj2'){cj2();}

$cjtag=$_REQUEST["cjtag"];
if($cjtag==''){$cjtag=$_SESSION['cjtag'];}

$cjjitiao=$_REQUEST["cjjitiao"];
if($cjjitiao==''){$cjjitiao=$_SESSION['cjjitiao'];}
if($cjjitiao==''){$cjjitiao=19;}

$cjurl=strtolower($_REQUEST["cjurl"]);
if($cjurl==''){$cjurl=$_SESSION['cjurl'];}
if($cjurl==''){$cjurl='http://g.cn';}
if(substr($cjurl,0,7)!='http://'){$cjurl='http://'.$cjurl;}
if(substr($cjurl,-1)=='/'){$cjurl=substr($cjurl,0,-1);}
$navid=$_REQUEST["navid"];
if($navid!=''){$_SESSION['s_navid']=$navid;}
?>



<!DOCTYPE html>
<html>
<head>
<title>管理</title>
<link rel="stylesheet" href="css/right.css" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>






<div id=position><div id="icon-art"></div><h1>自动采集域名</h1></div>
<div id=br></div>



<div class="yj_green" id=full>
<b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b>
<div class="boxcontent"></div>
<div class="t1"><div class="t2">



<?php
echo <<<EOF
<form action="?g=gcj" method=post>
<p>根据tag采集：<input type=text value='{$cjtag}' name=cjtag size=50></p>
<p>采集几条：<input type=text value='{$cjjitiao}' name=cjjitiao size=10></p>
<p><input type=submit value='采集' ></p>
<p><a href="?g=cj">继续上次的采集</a></p>
</form>
EOF;


$g=$_REQUEST["g"];
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
?>
</body>
</html>

















<?php



function gcj(){
$cjtag=$_REQUEST["cjtag"];
$cjjitiao=$_REQUEST["cjjitiao"];
$_SESSION['cjtag']=$cjtag;
$_SESSION['cjjitiao']=$cjjitiao;

echo'<p>tags：'.$cjtag.'</p>';
echo'<p>采集：'.$cjjitiao.'条</p>';

echo'<p>网址采集完毕，开始采集数据.</p>';
cjurls($cjtag);
echo'<iframe src="?g=cj" height=200 width=800></iframe>';


}




function cjurls($cjtag){
$cjjitiao=$_SESSION['cjjitiao']-1;
if($cjjitiao==''){$cjjitiao=9;}
ini_set('user_agent','Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.0)');
$cjhtml=file_get_contents('http://www.baidu.com/s?rn=50&wd='.$cjtag);
$cjhtml=mb_convert_encoding($cjhtml,"utf-8","gb2312");
$get_c_str = new get_c_str;
$cjhtml = $get_c_str -> get_str($cjhtml,'<table cellpadding="0" cellspacing="0" class="result" id="5"','<br clear=all>');
$cjhtml2=$cjhtml;
		for($i=1;$i<=$cjjitiao+1;$i++){
		preg_match('|\}\)\" href\=\"http\:\/\/(.*)\"target\=\"\_blank\"\>|isU',$cjhtml2,$url1); 
		$url=$url1[1];
		$urls=$urls.$url.',';
		$cjhtml2=str_replace('})" href="http://'.$url.'"target="_blank">','',$cjhtml2);
		}
$urls=str_replace(',,','',$urls);
if(substr($urls,-1)!=','){$urls=$urls.',';}
if($urls==','){$urls='';}
$_SESSION['urls']=$urls;
$_SESSION['now']=0;
}


function sfyumi($a){
$a=strtolower($a);
$a=str_replace('\\','/',$a);
$a=str_replace('http://','',$a);
$a2=substr($a,0,-1);
if(str_replace('/','',$a)==$a2){return true;}
else{return false;}
}


function cj(){
$urls=$_SESSION['urls'];
$now=$_SESSION['now'];
if($urls==''){die('<p>采集列表为空！</p>');}
if($now==''){$now=0;$_SESSION['sj']='';}
$u=explode(',',$urls);
#$shu=count($u);
$shu=$_SESSION['cjjitiao'];
if($now==$shu){$chkend=1;}
$now=$now+1;
$_SESSION['now']=$now;
$cjurl='http://'.$u[$now-1];
$cjtag=$_SESSION['cjtag'];
$_SESSION['cjurl']=$cjurl;
echo('进度:'.$now.'/'.$shu.'<br>tag:'.$cjtag.'<br>正在采集网址：'.$cjurl);
if($now==$shu){echo('采集完毕！<br>');}
echo'<iframe src="?g=cj2" height=200 width=800></iframe>';
if($now==$shu){die();}
echo'<meta http-equiv="refresh" content="2; url=?g=cj">';        
#采集时间间隔
}

function cj2(){

set_time_limit(15);
$cjurl=$_SESSION['cjurl'];
$cjtag=$_SESSION['cjtag'];

ini_set('user_agent','Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.0)');
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
echo '<p>编码：'.$cset.'</p>';


$get_c_str = new get_c_str;
$cjtitle = $get_c_str -> get_str($cjhtml,'<title>','</title>');
if(strlen($cjtitle)<1){die('采集不到标题数据！');}
$cjtitle=strip_tags($cjtitle);
$cjtitle=str_replace("\n","",$cjtitle);
$cjtitle=str_replace("\r","",$cjtitle);
$cjtitle=strip_tags($cjtitle);
$dtitle=cut_str($cjtitle,30);
$dtitle=str_replace(' ','',$dtitle);
$dtitle=str_replace('.','',$dtitle);
$htmlname='';
$durl=str_replace('http://','',$cjurl);
if(substr($durl,-1)=='/'){$durl=substr($durl,0,-1);}
if(sfyumi($cjurl)==1){$dtitle=$durl.'_'.$dtitle;}
#$dtitle=$dtitle.'_'.$durl;
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
if($cd>2000){$cjhtml=cut_str($cjhtml,1500);}
$cjhtml=goneilian($cjhtml);



$dcontent=$cjhtml.'<br><p><a target=_blank title="'.$dtitle.'" >浏览完整页面》 '.$durl.'</a></p>';
#die($dtitle.'ffff'.$dcontent);
global $date;
$_SESSION['title']=$dtitle;
$_SESSION['content']=$dcontent;
$_SESSION['date']=$date;
$_SESSION['author']=$cjurl;
$_SESSION['htmlname']=$htmlname;
$_SESSION['tags']=$cjtag;





if($_SESSION['cjjitiao']==$_SESSION['now']){
if($durl!=''&&$dtitle!=''&&$date!=''&&$dcontent!=''){echo'<br><h3>采集成功，开始写入数据库！</h3>';echo"<script>location.href='cjpost.php'</script>";}
}








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