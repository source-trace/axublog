<?include_once('../all.php');chkadcookie();?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style>
body{margin:10px;padding:0;font-size:13px;}
p,div{margin:3px;padding:0;}
h1,h1 a{font-size:20px;}
a{font-weight:bold;font-size:15px;color:#0064B1;}
</style>
<?php
header ( "content-Type: text/html; charset=utf-8" );
include('c_zip.php');

$host=$root;
$user=$dbuser;
$password=$dbpsw;
$_SESSION['host']=$host;
$_SESSION['user']=$user;
$_SESSION['password']=$password;
$_SESSION['dbname']=$dbname;

?>

<h1><a target=_blank href='http://www.axublog.com'>PHP备份恢复MYSQL数据库程序1.0_by_DONNY</a></h1>
<p>17:37 2012-1-6 免费原创程序，请尊重作者保留版权信息 <a target=_blank href='http://www.axublog.com'>http://www.axublog.com</a> 
<a target=_blank href='http://www.axublog.com'>BUG和建议</a>
</p>

<a href='index.php'>首页</a>


<br>建议<a onclick='if(confirm("确定清空数据库"+frm.dbname.value+"吗?")){frm.action="delall.php";frm.submit();}'>【清空数据库】</a>之后再进行恢复操作！数据库不会新建数据库，只会恢复数据库中的表和数据。
<br><br>



<form name=frm method=post>
<p>MySQL服务器<input type="text" name="host" value="<?=$host?>">&nbsp;&nbsp;通常为 localhost</p>
<p>MySQL用户名<input type="text" name="user" value="<?=$user?>">&nbsp;&nbsp;通常为 root</p>
<p>MySQL密码<input type="text" name="password" value="<?=$password?>">&nbsp;&nbsp;通常为 123456</p>
<p>数据库名<input type="text" name="dbname" value="<?=$dbname?>">&nbsp;&nbsp;您希望操作哪个数据库？</p>
<p> 
  <input type="button" name="btn3" value="备份数据库" onclick='if(confirm("确定备份数据库"+frm.dbname.value+"吗?")){frm.action="backup.php";frm.submit();}' >
   <input type="button" name="btn4" value="清空数据库" onclick='if(confirm("确定清空数据库"+frm.dbname.value+"吗?")){frm.action="delall.php";frm.submit();}' >
</p>
</form>


<?
if($host==''&&$user==''&&$password==''&&$dbname==''){die(请填写MYSQL数据库相关信息！);}
?>
