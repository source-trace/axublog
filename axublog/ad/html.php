<?php 
require_once('all.php');
chkadcookie();
?>
<!DOCTYPE html>
<html>
<head>
<title>管理</title>
<link rel="stylesheet" href="css/right.css" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php
$g=$_GET["g"];
		if (! file_exists ("../".$tagpath)) {
			chmod ("../".$tagpath, 0777 );
			mkdir ("../".$tagpath, 0777 );
		}

				if (! file_exists ("../".$artpath)) {
			chmod ("../".$artpath, 0777 );
			mkdir ("../".$artpath, 0777 );
		}
?>
<script src="jspost.js"></script> 
</head>
<body>
<?php
    switch ($g)
    {
    case "hindex":hindex();break; 
    case "htags":htags();break; 
    case "halltags":halltags();break; 
    case "hatag":hatag();break; 
    case "harts":harts();break; 
    case "hallarts":hallarts();break; 
    case "haart":haart();break; 
    case "hsitemap":hsitemap();break; 
    case "hartguidang":hartguidang();break; 
    case "hrss":hrss();break; 
    case "htdtags":htdtags();break; 
    case "htdtags2":htdtags2();break; 
    case "habout":habout();break; 
	case "htoday":htoday();break; 
    default:sindex();break; 
    }
?>
</body>
</html>

<?php 
function htoday(){
?>
<div class="yj_green" id=full>
<b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b>
<div class="boxcontent">
<h2>生成今日更新</h2>
</div>
<div class="t1"><div class="t2">
<?php
global $tabhead,$webname,$webinfo,$weburl,$webauthor,$themepath,$artpath,$tagpath,$title;
/***删除文章和tags文件夹***/
#deldir("../".$tagpath); 
#deldir("../".$artpath); 
/***删除文章和tags文件夹***/

$mb='../'.$themepath."index.mb";
$cache="../index.html";
ob_start();
include($mb);
$html = ob_get_contents ();
ob_clean();
$html=mbreplace($html);
file_put_contents ($cache, $html);

$mb='../'.$themepath."tagsindex.mb";
$cache="../".$tagpath."/index.html";
ob_start();
include($mb);
$html = ob_get_contents ();
ob_clean();
$html=mbreplace($html);
file_put_contents ($cache, $html);
?>
<p>生成首页成功，<a href="../index.html" target=_blank>查看》</a>，<a href="javascript:history.back()" >返回《</a></p>
<p>生成tags首页成功，<a href="../<?=$tagpath?>index.html" target=_blank>查看》</a>，<a href="javascript:history.back()" >返回《</a></p>
<?php
echo'<iframe src="html.php?g=hsitemap" height=80 width=100% oresize="noresize" frameborder="NO" name="topFrame" scrolling="no" marginwidth="0" marginheight="0"></iframe>';
echo'<iframe src="html.php?g=hartguidang" height=80 width=100% oresize="noresize" frameborder="NO" name="topFrame" scrolling="no" marginwidth="0" marginheight="0"></iframe>';
echo'<iframe src="html.php?g=hrss" height=80 width=100% oresize="noresize" frameborder="NO" name="topFrame" scrolling="no" marginwidth="0" marginheight="0"></iframe>';
echo'<iframe src="html.php?g=htdtags" height=100 width=100% oresize="noresize" frameborder="NO" name="topFrame" scrolling="no" marginwidth="0" marginheight="0"></iframe>';
?>
</div></div>
<b class="b4b"></b><b class="b3b"></b><b class="b2b"></b><b class="b1b"></b>
</div>
<?php
}
?>


<?php 
function sindex(){
?>
<div class="yj_green" id=full>
<b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b>
<div class="boxcontent">
<h2>生成页面</h2>
</div>
<div class="t1"><div class="t2">
<p>生成页面</p>
</div></div>
<b class="b4b"></b><b class="b3b"></b><b class="b2b"></b><b class="b1b"></b>
</div>
<?php
}
?>


<?php 
function hindex(){
?>
<div class="yj_green" id=full>
<b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b>
<div class="boxcontent">
<h2>生成首页</h2>
</div>
<div class="t1"><div class="t2">
<?php
global $tabhead,$webname,$webinfo,$weburl,$webauthor,$themepath,$artpath,$tagpath,$title;
/***删除文章和tags文件夹***/
#deldir("../".$tagpath); 
#deldir("../".$artpath); 
/***删除文章和tags文件夹***/

$mb='../'.$themepath."index.mb";
$cache="../index.html";
ob_start();
include($mb);
$html = ob_get_contents ();
ob_clean();
$html=mbreplace($html);
file_put_contents ($cache, $html);

$mb='../'.$themepath."tagsindex.mb";
$cache="../".$tagpath."/index.html";
ob_start();
include($mb);
$html = ob_get_contents ();
ob_clean();
$html=mbreplace($html);
file_put_contents ($cache, $html);
?>
<p>生成首页成功，<a href="../index.html" target=_blank>查看》</a>，<a href="javascript:history.back()" >返回《</a></p>
<p>生成tags首页成功，<a href="../<?=$tagpath?>index.html" target=_blank>查看》</a>，<a href="javascript:history.back()" >返回《</a></p>
</div></div>
<b class="b4b"></b><b class="b3b"></b><b class="b2b"></b><b class="b1b"></b>
</div>
<?
}
?>


<?php 
function hatag(){
$t=$_GET["t"];
if($t==''){echo '请选择tag！否则无法生成页面！';die();}
?>
<div class="yj_green" id=full>
<b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b>
<div class="boxcontent">
<h2>生成tag页面<?=$t?></h2>
</div>
<div class="t1"><div class="t2">
<?php
global $tagpath;
$b=taghtmlnamegettag($t);
$id=$b['id'];
$name=$b['name'];
$htmlname=$t;
$info=$b['info'];
$url=tagtourl($htmlname);
echo '<p>分类：'.$name.'</p>';
echo '<span>['.$name.'] 生成页面成功，<a target=_blank href="../'.$tagpath.$htmlname.'" >查看》</a>，<a href="javascript:history.back()" >返回《</a></span><br>';

global $tabhead,$webname,$webinfo,$weburl,$webauthor,$themepath,$artpath,$tagpath,$title;
$mb='../'.$themepath."tags.mb";
$cache="../".$tagpath.$t."/index.html";

				if (! file_exists ("../".$tagpath.$t)) {
			@chmod ("../".$tagpath.$t, 0777 );
			mkdir ("../".$tagpath.$t, 0777 );
		}
ob_start();
include($mb);
$html = ob_get_contents ();
ob_clean();
$html=mbreplace($html);
file_put_contents ($cache, $html);
?>
</div></div>
<b class="b4b"></b><b class="b3b"></b><b class="b2b"></b><b class="b1b"></b>
</div>
<?php
}
?>


<?php 
function htags(){
?>
<div class="yj_green" id=full>
<b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b>
<div class="boxcontent">
<h2>生成tags</h2>
</div>
<div class="t1"><div class="t2">
<?php
global $tagpath,$weburl;
$a=getalltag();
$shu=count($a);
global $tabhead,$webname,$webinfo,$weburl,$webauthor,$themepath,$artpath,$tagpath,$title;

echo '<p>tags数量：'.$shu.'   <a href="?g=halltags">生成所有</a></p>';
for($i=1;$i<=$shu;$i++){
$b=$a[$i-1];
$id=$b['id'];
$name=$b['name'];
$htmlname=$b['htmlname'];
$info=$b['info'];
$url=tagtourl($htmlname);
$atagshu=navidgetartids($id);
$tagshu=count($atagshu);
echo '<span>['.$name.'] <a href="?g=hatag&t='.$htmlname.'" >生成页面》</a></span><br>';
}
?>
</div></div>
<b class="b4b"></b><b class="b3b"></b><b class="b2b"></b><b class="b1b"></b>
</div>
<?php
}
?>


<?php 
function halltags2(){
?>
<script src=jspost.js ></script>
<div class="yj_green" id=full>
<b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b>
<div class="boxcontent">
<h2>生成所有tags页面</h2>
</div>
<div class="t1"><div class="t2">
<?php
$hb=getalltag();
$hbshu=count($hb);
global $tabhead,$webname,$webinfo,$weburl,$webauthor,$themepath,$artpath,$tagpath,$title;
$say='';
for($h=1;$h<=$hbshu;$h++){
$name=$hb[$h-1]['name'];
$htmlname=$hb[$h-1]['htmlname'];
$t=$htmlname;
$info=$hb[$h-1]['info'];
$url=tagtourl($htmlname);
$say=$say.'<span>['.$name.'] 生成页面成功，<a target=_blank href="../'.$tagpath.$htmlname.'" >查看》</a><br>';

$mb='../'.$themepath."tags.mb";
$cache="../".$tagpath.$htmlname."/index.html";
				if (! file_exists ("../".$tagpath.$htmlname)) {
				chmod ("../".$tagpath.$htmlname, 0777 );
				mkdir ("../".$tagpath.$htmlname, 0777 );
				}
ob_start();
include($mb);
$html = ob_get_contents ();
$html=mbreplace($html);
file_put_contents ($cache, $html);
ob_clean();
}
echo $say;
?>
</div></div>
<b class="b4b"></b><b class="b3b"></b><b class="b2b"></b><b class="b1b"></b>
</div>
<?php
}
?>






<?php 
function halltags(){
?>
<div class="yj_green" id=full>
<b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b>
<div class="boxcontent">
<h2>生成所有tags</h2>
</div>
<div class="t1"><div class="t2">

<?php
$nowhtmla=$_SESSION['nowhtmla'];

if($nowhtmla==''){
$a=getalltag();
$_SESSION['alltag']=$a;
}
else{
$a=$_SESSION['alltag'];
}
$shu=count($a);
if($shu==''|$shu==0){echo'<p>tag数目为：0，不需要生成html</p>';}

$_SESSION['nowhtmla']=$nowhtmla+1;
$nowhtmla=$_SESSION['nowhtmla'];

echo '<p>数量：'.$shu.'</p><p>生成页面估计需要一段时间，请稍后！</p>';
if(abs($nowhtmla)>abs($shu)){$_SESSION['alltag']='';$_SESSION['nowhtmla']='';echo '<p><font color=red>所有html完毕</font></p>';}
else{
echo '<p>进度：<b>'.$nowhtmla.'</b>/'.$shu.'</p>';
$name=$a[$nowhtmla-1]['name'];
$htmlname=$a[$nowhtmla-1]['htmlname'];
echo'<iframe src="html.php?g=hatag&t='.$htmlname.'" height=100 width=800></iframe>';

	if(abs($nowhtmla+1)>abs($shu)){$_SESSION['alltag']='';$_SESSION['nowhtmla']='';echo '<p><font color=red>所有html完毕</font></p>';}
	else{echo'<meta http-equiv="refresh" content="1; url=?g=halltags">';}

}
?>
</div></div>
<b class="b4b"></b><b class="b3b"></b><b class="b2b"></b><b class="b1b"></b>
</div>
<?php
}
?>





<?php 
function harts(){
?>
<div class="yj_green" id=full>
<b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b>
<div class="boxcontent">
<h2>生成文章</h2>
</div>
<div class="t1"><div class="t2">
<p><a href="?g=hallarts">生成所有</a></p>
</div></div>
<b class="b4b"></b><b class="b3b"></b><b class="b2b"></b><b class="b1b"></b>
</div>
<?php
}
?>


<?php 
function haart(){
$p=$_GET['p'];
?>
<div class="yj_green" id=full>
<b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b>
<div class="boxcontent">
<h2>生成文章页面</h2>
</div>
<div class="t1"><div class="t2">
<?php
$url=arttourl($p);
global $tabhead,$webname,$webinfo,$weburl,$webauthor,$themepath,$artpath,$tagpath,$title;
$mb="../".$themepath."arts.mb";
$cache="../".$artpath.$p."/index.html";
if (! file_exists ("../".$artpath.$p)) {
			chmod ("../".$artpath.$p, 0777 );
			mkdir ("../".$artpath.$p, 0777 );
}
echo '<span>['.$p.'] 生成页面成功，<a target=_blank href="'.$cache.'" >查看》</a> <a href="javascript:history.back()">《返回</a></span><br>';
ob_start();
include($mb);
$html = ob_get_contents ();
$html=mbreplace($html);
file_put_contents ($cache, $html);
ob_clean();
?>
</div></div>
<b class="b4b"></b><b class="b3b"></b><b class="b2b"></b><b class="b1b"></b>
</div>
<?php
}
?>


<?php 
function hallarts(){
?>
<div class="yj_green" id=full>
<b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b>
<div class="boxcontent">
<h2>生成所有文章</h2>
</div>
<div class="t1"><div class="t2">

<?php
$nowhtmla=$_SESSION['nowhtmla'];

if($nowhtmla==''){
$a=getallart();
$_SESSION['allart']=$a;
}
else{
$a=$_SESSION['allart'];
}
$shu=count($a);
if($shu==''|$shu==0){echo'<p>文章数目为：0，不需要生成html</p>';}

$_SESSION['nowhtmla']=$nowhtmla+1;
$nowhtmla=$_SESSION['nowhtmla'];

echo '<p>文章数量：'.$shu.'</p><p>生成页面估计需要一段时间，请稍后！</p>';
if(abs($nowhtmla)>abs($shu)){$_SESSION['allart']='';$_SESSION['nowhtmla']='';echo '<p><font color=red>所有文章html完毕</font></p>';}
else{
echo '<p>进度：<b>'.$nowhtmla.'</b>/'.$shu.'</p>';
$name=$a[$nowhtmla-1]['title'];
$htmlname=$a[$nowhtmla-1]['htmlname'];
echo'<iframe src="html.php?g=haart&p='.$htmlname.'" height=200 width=800></iframe>';

	if(abs($nowhtmla+1)>abs($shu)){$_SESSION['allart']='';$_SESSION['nowhtmla']='';echo '<p><font color=red>所有文章html完毕</font></p>';}
	else{echo'<meta http-equiv="refresh" content="1; url=?g=hallarts">';}

}
?>
</div></div>
<b class="b4b"></b><b class="b3b"></b><b class="b2b"></b><b class="b1b"></b>
</div>
<?php
}
?>


<?php 
function hartguidang(){
?>
<div class="yj_green" id=full>
<b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b>
<div class="boxcontent">
<h2>生成文章归档</h2>
</div>
<div class="t1"><div class="t2">
<?php
global $tabhead,$webname,$webinfo,$weburl,$webauthor,$themepath,$artpath,$tagpath,$title;
$mb="../".$themepath."allarts.mb";
$cache="../allarts.html";

ob_start();
include($mb);
$html = ob_get_contents ();
ob_clean();
$html=mbreplace($html);
file_put_contents ($cache, $html);

echo '生成文章归档成功: <a target=blank href="'.$cache.'">访问</a>';
?>
</div></div>
<b class="b4b"></b><b class="b3b"></b><b class="b2b"></b><b class="b1b"></b>
</div>
<?php
}
?>


<?php 
function hsitemap(){
?>
<div class="yj_green" id=full>
<b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b>
<div class="boxcontent">
<h2>生成sitemap.xml</h2>
</div>
<div class="t1"><div class="t2">
<?php
global $tabhead,$webname,$webinfo,$weburl,$webauthor,$themepath,$artpath,$tagpath,$title,$date;
$cache="../sitemap.xml";
$www=getweburl();
$a=getallnav();
$shu=count($a);
for($i=1;$i<=$shu;$i++){
$b=$a[$i-1];
$htmlname=$b['htmlname'];
$url=$www.$tagpath.$htmlname.'/';
$navxml=$navxml.'<url>
<loc>'.$url.'</loc>
</url>';
}

$a=getalltag();
$shu=count($a);
for($i=1;$i<=$shu;$i++){
$b=$a[$i-1];
$htmlname=$b['htmlname'];
$url=$www.$tagpath.$htmlname.'/';
@$tagxml=$tagxml.'<url>
<loc>'.@$url.'</loc>
</url>';
}

$a=getallart();
$shu=count($a);
for($i=1;$i<=$shu;$i++){
$b=$a[$i-1];
$htmlname=$b['htmlname'];
$url=$www.$artpath.$htmlname.'/';
@$artxml=$artxml.'<url>
<loc>'.$url.'</loc>
</url>';
}

$html='';
$html=$html.'<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.google.com/schemas/sitemap/0.84">
<url>
<loc>'.$www.'</loc>
</url>
<url>
<loc>'.$www.'tags/</loc>
</url>
';
@$html=$html.$navxml.$tagxml.$artxml;
$html=$html.'</urlset>';
file_put_contents ($cache, $html);
echo '生成sitemap.xml成功: <a target=blank href="'.$cache.'">访问</a>';
?>
</div></div>
<b class="b4b"></b><b class="b3b"></b><b class="b2b"></b><b class="b1b"></b>
</div>
<?php
}
?>


<?php 
function hrss(){
?>
<div class="yj_green" id=full>
<b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b>
<div class="boxcontent">
<h2>生成rss.xml</h2>
</div>
<div class="t1"><div class="t2">
<?php
global $tabhead,$webname,$webinfo,$weburl,$webauthor,$themepath,$artpath,$tagpath,$title,$date;
$cache="../rss.xml";

$www=getweburl();
$www2=str_replace('http://','',$www);

$a=get15artbydate();
$shu=count($a);

for($i=1;$i<=$shu;$i++){
$b=$a[$i-1];
$htmlname=$b['htmlname'];
$url=$www.$artpath.$htmlname.'/';
$title=$b['title'];
$info=$title;
$edate=$b['edate'];
$author=$b['author'];
$id=$b['id'];
		$n=artidgettagids($id);
		$nshu=count($n);
		for($j=1;$j<=$nshu;$j++){
		$tagid=$n[$j-1];
		$b=navidgetnav($tagid);
		$type=$b['type'];
		$name=$b['name'];
		if($type=='nav'){$nav=$name;}
		}
@$artrss=$artrss.'<item><title><![CDATA['.$title.']]></title><description><![CDATA['.$info.']]></description><category><![CDATA['.$nav.']]></category><link>'.$url.'</link><author><![CDATA['.$author.']]></author><pubDate>'.$edate.'</pubDate></item>'."\r\n\r\n";
}

$html='';
$html=$html.'<?xml version="1.0" encoding="utf-8"?>
<rss version="2.0">
<channel>
<title>'.$webname.'</title>
<link>'.$www.'</link>
<description>'.$webinfo.'</description>
<copyright>(c) 2011, '.$www2.'. All rights reserved.</copyright>
<generator>'.$webname.'</generator>
<ttl>30</ttl>
'.$artrss.'
</channel>
</rss>';

file_put_contents ($cache, $html);
echo '生成rss.xml成功: <a target=blank href="'.$cache.'">访问</a>';
?>
</div></div>
<b class="b4b"></b><b class="b3b"></b><b class="b2b"></b><b class="b1b"></b>
</div>
<?php
}
?>


<?php 
function htdtags(){
?>
<div class="yj_green" id=full>
<b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b>
<div class="boxcontent">
<h2>生成今日有更新的tags</h2>
</div>
<div class="t1"><div class="t2">
<?php
global $tabhead,$webname,$webinfo,$weburl,$webauthor,$themepath,$artpath,$tagpath,$title;
$a=gettodayart();
$_SESSION['gettodayart']=$a;
$shu=count($a);
	for($i=1;$i<=$shu;$i++){
	$b=$a[$i-1];
	$artid=$b['id'];
	$c=artidgettagids($artid);
	$cshu=count($c);
		for($j=1;$j<=$cshu;$j++){
		$tagids=str_replace('['.$c[$j-1].'],','',$tagids);
		$tagids=$tagids.'['.$c[$j-1].'],';
		}
	}
$tagids=str_replace('[','',$tagids);
$tagids=str_replace(']','',$tagids);
$_SESSION['tagids']=$tagids;
$d=explode(',',$tagids);
$dshu=count($d)-1;
		for($j=1;$j<=$dshu;$j++){
		$e=navidgetnav($d[$j-1]);
		$taghtmls=$taghtmls.$e['htmlname'].',';
		}
$_SESSION['taghtmls']=$taghtmls;
echo '需要更新的tags id：'.$tagids.'<br>';
echo '需要更新的tags htmlname：'.$taghtmls.'<br>';
echo '2秒后开始html<br>';
echo'<meta http-equiv="refresh" content="1; url=?g=htdtags2">';
?>
</div></div>
<b class="b4b"></b><b class="b3b"></b><b class="b2b"></b><b class="b1b"></b>
</div>
<?php
}
?>


<?php 
function htdtags2(){
?>
<div class="yj_green" id=full>
<b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b>
<div class="boxcontent">
<h2>生成今日有更新的tags</h2>
</div>
<div class="t1"><div class="t2">
<?php
$taghtmls=$_SESSION['taghtmls'];
$d=explode(',',$taghtmls);
$dshu=count($d)-1;
		for($j=1;$j<=$dshu;$j++){
		$htmlname=$d[$j-1];
		echo'<iframe src="html.php?g=hatag&t='.$htmlname.'" height=100 width=100% oresize="noresize" frameborder="NO" name="topFrame" scrolling="no" marginwidth="0" marginheight="0"></iframe>';
		}
?>
</div></div>
<b class="b4b"></b><b class="b3b"></b><b class="b2b"></b><b class="b1b"></b>
</div>
<?php
}
?>


<?php 
function habout(){
?>
<div class="yj_green" id=full>
<b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b>
<div class="boxcontent">
<h2>生成about.html</h2>
</div>
<div class="t1"><div class="t2">
<?php
global $tabhead,$webname,$webinfo,$weburl,$webauthor,$themepath,$artpath,$tagpath,$title;
$mb="../".$themepath."about.mb";
$cache="../about.html";

ob_start();
include($mb);
$html = ob_get_contents ();
ob_clean();
$html=mbreplace($html);
file_put_contents ($cache, $html);

echo '生成about.html成功: <a target=blank href="'.$cache.'">访问</a>';
?>
</div></div>
<b class="b4b"></b><b class="b3b"></b><b class="b2b"></b><b class="b1b"></b>
</div>
<?php
}
?>


<?php
mysql_close($con);
?>
