<?php 
require_once('all.php');chkadcookie();
require_once('pinyin.php');
?>
<!DOCTYPE html>
<html>
<head>
<title>管理</title>
<link rel="stylesheet" href="css/right.css" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>

<?php

global $tabhead,$webname,$webinfo,$weburl,$webauthor,$themepath,$artpath,$tagpath,$title;
$title=$_REQUEST['title'];if($title==''){$title=$_SESSION['title'];}
if(strlen($title)>70){$title=substr($title,0,70);}
$htmlname=$_REQUEST['htmlname'];if($htmlname==''){$htmlname=$_SESSION['htmlname'];}
$htmlname=htmlnameguolv($htmlname);
if($htmlname=='默认自动转为拼音'|$htmlname==''){$htmlname=pinyin($title);}
$content=$_REQUEST['content'];if($content==''){$content=$_SESSION['content'];}
$content=gethttpimg($content);

$date=$_REQUEST['date'];if($date==''){$date=$_SESSION['date'];}
$author=htmlnameguolv($_REQUEST['author']);if($author==''){$author=$_SESSION['author'];}


$tags=$_REQUEST['tags'];if($tags==''){$tags=$_SESSION['tags'];}
$tags=htmlnameguolv($tags);

$title=addslashes($title);
$content=addslashes($content);
$htmlname=addslashes($htmlname);
$author=addslashes($author);
$tags=addslashes($tags);

$content=httptomyurl($content);

if(strlen($content)<5){die('内容为空');}
if($title==''){die('标题为空');}

$tab=$tabhead."arts";
mysql_select_db($tab);
$chk=" where htmlname='".$htmlname."'";
$sql = mysql_query("select * from ".$tab.$chk);
        if(!$sql){echo "(数据库查询失败!)<br>";}
$num=mysql_num_rows($sql);
if($num==0)
{
$sql="INSERT INTO ".$tab." (id,author,title,content,htmlname,type,hit,cdate,edate) VALUES (null,'".$author."','".$title."','".$content."','".$htmlname."','art',0,'".$date."','".$date."')";
		if(mysql_query($sql)){echo"添加文章成功,<a href='".$weburl.$artpath.$htmlname."' target=_blank>查看》</a>，<a href='javascript:history.back()' >返回《</a><br>正在生成页面,请稍等片刻。。。<br>";
		$artid = mysql_insert_id();
		addtags($tags,$artid);
		echo'<iframe src="html.php?g=haart&p='.$htmlname.'" height=200 width=800></iframe>';
		}
		else{echo"添加文章 [".$title."] <font color=red>失败1</font><br>".$sql;return;}
}
else{echo'html别名已存在:'.$htmlname.'<br>';return;}







mysql_close($con);
?>
</body>
</html>