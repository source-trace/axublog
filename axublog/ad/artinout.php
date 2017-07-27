<?php 
require_once('all.php');chkadcookie();
require_once('pinyin.php');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
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
    case "daoru":daoru();break; 
    default:daochu();break; 
    }
?>




<?php 
function daochu(){
?>

<div id=position><div id="icon-index"></div><h1>文章导出</h1></div>
<div id=br></div>

<div class="yj_green" id=full>
<b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b>
<div class="boxcontent">
<h2>文章导出</h2>
</div>
<div class="t1"><div class="t2">
<p>文章导出</p>
</div></div>
<b class="b4b"></b><b class="b3b"></b><b class="b2b"></b><b class="b1b"></b>
</div>

<?php
}
?>




<?php 
function daoru(){
?>

<div id=position><div id="icon-index"></div><h1>文章导入</h1></div>
<div id=br></div>

<div class="yj_green" id=full>
<b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b>
<div class="boxcontent">
<h2>文章导入</h2>
</div>
<div class="t1"><div class="t2">
<p>数据文件sj.txt必须放在同路径下</p>
<?
$file="sj.txt";
$fp=fopen($file,"r"); 
$text=fread($fp,4096*30);
$a=explode('[sjlist]',$text);
$shu=count($a)-1;
echo '共'.$shu.'个记录<br>';
for($i=1;$i<=$shu;$i++){
$a2=$a[$i-1];
$b=explode('[sjsplit]',$a2);
$title =$b[0];
$tags =$b[1];
$content =$b[2];
#$_SESSION['title']=$title;
#$_SESSION['content']=$content;
#$_SESSION['date']=$date;
#$_SESSION['tags']=$tags;
#if($tags!=''&&$title!=''&&$date!=''&&$content!=''){echo '<p>'.$i.' ['.$title.'] 导入数据库成功</p>';echo'<iframe src="cjpost.php?tags='.urlencode($tags).'&title='.urlencode($title).'&date='.urlencode($date).'&content='.urlencode($content).'" height=50 width=800></iframe>';}
ht_addart($title,$tags,$content);
}



?>
</div></div>
<b class="b4b"></b><b class="b3b"></b><b class="b2b"></b><b class="b1b"></b>
</div>

<?php
}
?>




<?php
mysql_close($con);
echo runtime();
?>


</body>
</html>