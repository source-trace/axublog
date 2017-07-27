<?php require_once('all.php');chkadcookie();?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>dobcms后台管理</title>
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" type="text/css" href="css/right.css">
  </head>
 <body> 
<div id=rightmenu>
<div id=rightmenu_top>

<?
@$g=$_GET["g"];
    switch ($g)
    {
	case "add":add();break; 
	case "addsave":addsave();break; 
    case "edit":edit();break; 
	    case "editsave":editsave();break; 
    case "del":del();break; 
    default:index();break; 
    }
?>

	
<?function index(){?>
<ul>
<li><a  target="main" href='right.php'><b>您的位置：后台首页</b></a> >
<a  target="main" href='admin.php'><b>管理员列表</b></a> > 
<a  target="main" href='admin.php?g=add'><b>添加管理员</b></a>
</li>
</ul>
</div>
<ul>
<?
global $tabhead;
$tab=$tabhead."adusers";
mysql_select_db($tab);
$sql = mysql_query("select * from ".$tab);
if(!$sql){echo "<div id=redmsg>(数据库查询失败!)</div>";return false;}
$num=mysql_num_rows($sql);
$_session['num']=$num;
?>
        <div id=adminlist>
          <div id=id>id </div>
		           <div id=user>账户</div>
		 </div>
<?
while($row=mysql_fetch_array($sql))
{
$id=$row['id'];
$user=$row['adnaa'];$psw=$row['adpss'];$psw=authcode($psw, 'DECODE', 'key',0);
$chk="";
if($_session['num']>1){$chk="|<a onclick=if(confirm('确定删除吗?')){location.href='?g=del&id={$id}';}>删除</a>";}
?>
        <div id=adminlist>
          <div id=id><input type="checkbox" value='<?=$id?>'><?=$id?> <a href='?g=edit&id=<?=$id?>'>编辑</a><?=$chk?></div>
		  <div id=user> <?=$user?> <?=@$psw2?> </div>
		 </div>
<?
}
?>
<p>共有 <?=$num?> 个管理员</p>
</ul>
<?}?>


<?function add(){?>
<ul>
<li><a  target="main" href='right.php'><b>您的位置：后台首页</b></a> >
<a  target="main" href='admin.php'><b>管理员列表</b></a> > 
<a  target="main" href='admin.php?g=add'><b>添加管理员</b></a>
</li>
</ul>
</div>
<div id=adform>
<form id="frm" action="?g=addsave" method="post">
<p><input id=text type="text" name="ad_user" size=20 value="">请输入帐号</p>
<p><input id=text type="password" name="ad_psw" size=20 value="">请输入密码</p> 
<p><input id=text type="password" name="ad_psw2" size=20 value="">重新输入密码</p> 
<p><button id="send" onclick=submit() >添加</button></p>
</form>
</div>
<?}?>

<?function addsave(){?>
<ul>
<li><a  target="main" href='right.php'><b>您的位置：后台首页</b></a> >
<a  target="main" href='admin.php'><b>管理员列表</b></a> > 
<a  target="main" href='admin.php?g=add'><b>添加管理员</b></a>
</li>
</ul>
</div>
<div><p>
<?
chkoutpost();
$ad_user=$_POST["ad_user"];
$ad_psw=$_POST["ad_psw"];$ad_psw = authcode(@$ad_psw, 'ENCODE', 'key',0); 
global $tabhead;
$tab=$tabhead."adusers";
mysql_select_db($tab);
$sql = mysql_query("select * from ".$tab." where adnaa='".$ad_user."'");
	if(!$sql){echo "<font color=red>(打开数据库时遇到错误!)</font>";return false;}
	else{if($row=mysql_fetch_array($sql)){echo "<font color=red>(用户名已存在！!)</font>";}else{		$sql="INSERT INTO ".$tabhead."adusers (id,adnaa,adpss) VALUES (null,'".$ad_user."','".$ad_psw."')";
		if(mysql_query($sql)){echo"添加管理员账户".$ad_user."成功<br>";jump('?',1);}else{echo"添加管理员账户".$ad_user."<font color=red>失败</font><br>";}}}	
	
	

	
	
?>
</p>
</div>
<?}?>

<?function edit(){?>
<ul>
<li><a  target="main" href='right.php'><b>您的位置：后台首页</b></a> >
<a  target="main" href='admin.php'><b>管理员列表</b></a> > 
<a  target="main" href='admin.php?g=add'><b>添加管理员</b></a> > 
修改管理员
</li>
</ul>
</div>
<div id=adform>
<form id="frm" action="?g=editsave" method="post">
<?
chkoutpost();
$id=$_GET['id'];
if($id==''){echo"<div id=err>id为空，请检查！</div>";jump('?',1);}
global $tabhead;
$tab=$tabhead."adusers";
mysql_select_db($tab);
$sql = mysql_query("select * from ".$tab." where id=".$id);
	if(!$sql){echo "<font color=red>(打开数据库时遇到错误!)</font>";return false;}
	else{
	while($row=mysql_fetch_array($sql)){$user=$row['adnaa'];}
	}
?>
<p><input id=text type="hidden" name="id" size=20 value="<?=$id?>">id:<?=$id?></p>
<p><input id=text type="text" name="ad_user" size=20 value="<?=$user?>" >您可以修改帐号</p>
<p><input id=text type="password" name="ad_psw" size=20 value="">请输入旧密码,来验证您的权限</p>
<br> 
<p><input id=text type="password" name="ad_psw1" size=20 value="">您也可以修改新密码</p> 
<p><input id=text type="password" name="ad_psw2" size=20 value="">重新输入新密码</p> 
<p><button id="send" onclick=submit() >保存</button></p>
</form>
</div>
<?}?>

<?function editsave(){?>
<ul>
<li><a  target="main" href='right.php'><b>您的位置：后台首页</b></a> >
<a  target="main" href='admin.php'><b>管理员列表</b></a> > 
<a  target="main" href='admin.php?g=add'><b>添加管理员</b></a> > 
修改管理员
</li>
</ul>
</div>
<div><p>
<?
chkoutpost();
$id=$_POST["id"];
$ad_user=$_POST["ad_user"];
$ad_psw=$_POST["ad_psw"];
$ad_psw1=$_POST["ad_psw1"];
$ad_psw2=$_POST["ad_psw2"];$ad_psw2 = authcode(@$ad_psw2, 'ENCODE', 'key',0); 


global $tabhead;
$tab=$tabhead."adusers";
mysql_select_db($tab);
$sql = mysql_query("select adpss from ".$tab." where id='".$id."'");
if(!$sql){echo "<font color=red>(打开数据库时遇到错误!)</font>";return false;}
$a=mysql_fetch_array($sql); 
$adpss=authcode($a["adpss"], 'DECODE', 'key',0); 
		if($adpss==$ad_psw){
		$sql="UPDATE ".$tab." SET adnaa='".$ad_user."',adpss='".$ad_psw2."' where id=".$id;
	    if(mysql_query($sql)){echo"修改成功 ， <a href='javascript:history.back()' >返回《</a> ";}else{echo '修改失败';}}
		else{echo'旧密码错误';}


?>
</p>
</div>
<?}?>


<?function del(){?>
<ul>
<li><a  target="main" href='right.php'><b>您的位置：后台首页</b></a> >
<a  target="main" href='admin.php'><b>管理员列表</b></a> > 
删除管理员
</li>
</ul>
</div>

<?
chkoutpost();
$id=$_GET['id'];
if($id==''){echo"<div id=err>id为空，请检查！</div>";jump('?',1);}
global $tabhead;
$tab=$tabhead."adusers";

$sql="DELETE FROM ".$tab." WHERE id=".$id;
if(mysql_query($sql)){echo"<div id=ok>删除成功</div>";jump('?',1);}
else{echo"<div id=err>删除失败,请检查id是否存在，请检查数据库！</div>";jump('javascript:history.back()',1);}

?>

<?}?>



</div>   
 </body></html>


