<?php 
include_once("all.php");
require_once('pinyin.php');
chkadcookie();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8'>
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
<link rel="shortcut icon" href="http://192.168.1.106/ad/css/favicon.ico" type="image/x-icon">
<link rel="apple-touch-icon-precomposed" href="http://192.168.1.106/ad/css/logo.gif"/>
<title>Donnycms后台管理</title>
<link rel="stylesheet" href="css/wap.css" type="text/css" />
</head>
<body>


<ul id=nav>
<div id=navl>
<li><a  href='?g=addart'>发布内容</a></li>
<li><a  href='html.php?g=htoday'>html今日更新</a></li>
</div>
</ul>


<?
@$g=$_GET["g"];
    switch ($g)
    {
    case "addart":addart();break; 
    case "addsave":addsave();break; 
    case "edit":edit();break; 
    case "editsave":editsave();break; 
	case "del":del();break; 
    default:artlist();break; 
	
    }
	
	
function addart(){
global $date;
global $webauthor;
global $tabhead;
@$title=$_GET['title'];
@$content=$_GET['content'];
?>
<div id=nav2>
<a href=wap.php >首页</a> > <a  href='?g=addart'>发布内容</a>
</div>

<div id=addart>
<script>
function frmchk(){
if(frm.title.value==''){alert("请填写文章标题！");frm.title.focus();return false;}
	else if(frm.content.value==''){alert("请填写内容！");frm.content.focus();return false;}
	else if(frm.tags.value==''){alert("请至少填写一个tag！");frm.tags.focus();return false;}
	else if(frm.author.value==''){alert("请填写作者信息！");frm.author.focus();return false;}
else{frm.submit();}
}
</script>
<form id="frm" name="frm" method="post" action="?g=addsave" >
<p>文章标题：<input   type=text name=title id=title >
<p>html别名(默认自动转为拼音)：<input  name=htmlname type=text ></p>
<p>内容：<textarea id="content" name="content" ></textarea></p>
<p>tags(多个标签请用逗号,分开)：<input name=tags id=tags type=text ></p>
<p>作者：<input name=author type=text value="<?=$webauthor?>" ></p>
<p>日期：<?=$date?><input name=date type=hidden value="<?=$date?>" ></p>
<p><input name=btn1 id=btn1 onclick="frmchk()" type=button value="发布内容" ></p>
</div>
	<?	
	}


function addsave(){
chkoutpost();
echo "<div id=nav2>
<a href=wap.php >首页</a> > 发布内容
</div>";
global $tabhead,$webname,$webinfo,$weburl,$webauthor,$themepath,$artpath,$tagpath,$title;
$title=$_POST['title'];if($title==''){echo '出现问题，文章标题为空';exit;}
if(strlen($title)>70){$title=substr($title,0,70);}

$htmlname=$_POST['htmlname'];
$htmlname=htmlnameguolv($htmlname);
if($htmlname=='默认自动转为拼音'|$htmlname==''){$htmlname=pinyin($title);}
$content=$_POST['content'];if($content==''){$content=$_SESSION['content'];}
#$content=gethttpimg($content);

$date=$_POST['date'];if($date==''){$date=$_SESSION['date'];}
$author=htmlnameguolv($_POST['author']);if($author==''){$author=$_SESSION['author'];}


$tags=$_POST['tags'];if($tags==''){$tags=$_SESSION['tags'];}
$tags=htmlnameguolv($tags);

$title=addslashes($title);
$content=addslashes($content);
$htmlname=addslashes($htmlname);
$author=addslashes($author);
$tags=addslashes($tags);

#$content=httptomyurl($content);

if(strlen($content)<5){die('内容为空');}
if($title==''){die('标题为空');}
#echo $title."<br>".$htmlname."<br>".$content."<br>".$tags."<br>".$author."<br>".$date."<br>";

$tab=$tabhead."arts";
mysql_select_db($tab);
$chk=" where htmlname='".$htmlname."'";
$sql = mysql_query("select * from ".$tab.$chk);
if(!$sql){echo "(数据库查询失败!)<br>";}
$num=mysql_num_rows($sql);
    if($num==0){
$sql="INSERT INTO ".$tab." (id,author,title,content,htmlname,type,hit,cdate,edate) VALUES (null,'".$author."','".$title."','".$content."','".$htmlname."','art',0,'".$date."','".$date."')";
if(mysql_query($sql)){echo"添加文章成功,<a href='".$weburl.$artpath.$htmlname."' target=_blank>查看》</a>，<a href='javascript:history.back()' >返回《</a><br>正在生成页面,请稍等片刻。。。<br>";
}

else{echo"添加文章 [".$title."] <font color=red>失败1</font><br>".$sql;return;}
$artid = mysql_insert_id();
addtags($tags,$artid);
echo'<iframe src="html.php?g=haart&p='.$htmlname.'" height=0 width=0 frameborder=0></iframe>';
    }
    else{echo'html别名已存在！';}
?>
<div id=addart>

</div>
	<?	
	}
	?>
	

<?php 
function artlist(){
?>
<div id=nav2>
<a href=wap.php >首页</a> > 内容列表
</div>
<?php
global $tabhead;
$tab=$tabhead."arts";
#$nav="未分类";
$chk=" where type='art'";
mysql_select_db($tab);
$sql = mysql_query("select * from ".$tab.$chk."");
$artshu=mysql_num_rows($sql);

$options = array(
	'total_rows' => $artshu, //总行数
	'list_rows'  => '10',  //每页显示量
);
$page = new page($options);
$sql =  mysql_query("select * from ".$tab.$chk." order by id desc limit $page->first_row , $page->list_rows");
?>

      
<?php
global $artpath;
if(!$sql){echo "<font color=red>(打开数据库时遇到错误!)</font>";return false;}
while($row=mysql_fetch_array($sql))
{
$p_id=$row['id'];
$p_author=$row['author'];
$p_title=mb_substr($row['title'],0,20,'utf-8');
$p_htmlname=$row['htmlname'];
$p_arturl=arttourl($p_htmlname);
$p_date=$row['edate'];
$chkhn='';$showchkhn='';
if(!file_exists('../'.$artpath.$p_htmlname)){$chkhn='<font color=red>X</font>';$showchkhn='<font color=red>未</font>';}else{$chkhn='√';$showchkhn='已';}
$p_nav='';
$p_tag='';
$a=artidgettagids($p_id);
$shu=count($a);
    for($i=1;$i<=$shu;$i++){
    $navid=$a[$i-1];
    $b=navidgetnav($navid);
    $navtype=$b['type'];
    $navname=$b['name'];
    if($navtype=='tag'){$p_tag=$p_tag.$navname.',';}
    if($navtype=='nav'){$p_nav=$navname;}
    }

echo <<<EOF


<div id=artlist>
<a href='?g=edit&id={$p_id}'>{$p_id}-{$p_title}</a><br>
{$p_date} <a onclick="if(confirm('确定删除 {$p_id} 吗?')){location.href='?g=del&id={$p_id}';}">删</a>|<a href='html.php?g=haart&p={$p_htmlname}'>{$showchkhn}html</a>|<a href='{$p_arturl}' target=_blank>预览</a><br>
</div>
EOF;
}
?>

<div id=page>
<?=$page->show(2)?>
</div>

<?php 
}
?>



<?php 
function del(){
chkoutpost();
echo"<div id=nav2>
<a href=wap.php >首页</a> > 删除内容
</div>";
$id=$_GET['id'];

global $tabhead;
$tab=$tabhead."arts";

$sql="DELETE FROM ".$tab." WHERE id=".$id;
if(mysql_query($sql)){echo"<div id=ok>文章删除成功</div>";}
else{echo"<div id=err>文章删除失败,请检查分类是否存在，请检查数据库！</div>";jump('javascript:history.back()',1);}

global $tabhead;
$tab=$tabhead."nav_art";
$sql="DELETE FROM ".$tab." WHERE artid=".$id;
if(mysql_query($sql)){echo"<div id=ok>后续处理成功</div>";jump('javascript:history.back()',1);}
else{echo"<div id=err>文章删除失败,请检查数据库！</div>";jump('javascript:history.back()',1);}
}
?>



<?php 
function haart(){
$p=$_GET['p'];
echo"<div id=nav2>
<a href=wap.php >首页</a> > 生成文章页面
</div>";
?>
<?php
$url=arttourl($p);
global $tabhead,$webname,$webinfo,$weburl,$webauthor,$themepath,$artpath,$tagpath,$title;
$mb="../".$themepath."arts.mb";
$cache="../".$artpath.$p."/index.html";
if (! file_exists ("../".$artpath.$p)) {
			@chmod ("../".$artpath.$p, 0777 );
			mkdir ("../".$artpath.$p, 0777 );
}
echo '<div id=ty>'.$p.'<br>生成页面成功<a target=_blank href="'.$cache.'" >查看》</a></div>';
ob_start();
include($mb);
$html = ob_get_contents ();
$html=mbreplace($html);
file_put_contents ($cache, $html);
ob_clean();
?>
<?php
}
?>
	
	
	
<div id=copy>
<p><a href="index.php?g=pc">电脑版</a>-<a href="wap.php">手机版</a>-
<a  target=_blank href="<?=$weburl?>?update=yes" >前台首页</a>
<a onclick="if(confirm('确定登出吗?')){window.top.location.href='login.php?g=exit';}"><?php echo $webauthor?>:退出登录</a>
</p>
<p id=powered>Powered by <a target=_blank href="<?=$codeurl?>"><?=$codename?></a></p>
</div>

</body>
</html>