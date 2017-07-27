<?php

require_once 'conn.php';
@$g=$_REQUEST['g'];


if($g=='saveconfig'){
$host=$_REQUEST['host'];
$user=$_REQUEST['user'];
$password=$_REQUEST['password'];
$dbname=$_REQUEST['dbname'];
$_SESSION['host']=$host;
$_SESSION['user']=$user;
$_SESSION['password']=$password;
$_SESSION['dbname']=$dbname;
}




$dir = '.';	//根目录
$handle = opendir($dir);	//遍历目录
$shu=0;
while (false!==($file = readdir($handle))  ) {	//获取文件
	$hz=pathinfo($file); 	//得到后缀
	if($hz['extension']=='zip'){ 	//判断后缀
	$shu=$shu+1;
	$size='  '.ceil(filesize($file)/1024).'kb  ';
	$file2=str_replace('.zip','.sql',$file);
	echo $file.$size." - <a onclick='frm.action=\"backup.php?g=d&z=".$file."\";frm.submit();'>下载.zip</a> - <a target=_blank href='".$file2."'>下载.sql</a> - <a onclick='if(confirm(\"确定恢复数据库\"+frm.dbname.value+\"吗?\")){frm.action=\"huifu.php?g=".$file."\";frm.submit();}'>恢复</a> - <a onclick='if(confirm(\"确定发送吗?\")){location.href=\"sendmail.php?a=".$file."&d=\"+frm.dbname.value+\"\";}'>发送邮件</a> - <a onclick='if(confirm(\"确定删除吗?\")){location.href=\"?g=del&p=".$file."\"}'>删除</a><br>";	//输出信息
	}
}
closedir($handle);   //关闭句柄
if($shu==''){echo'<p>备份文件'.$shu.'个</p>';}





if($g=='del'){
$p=$_REQUEST['p'];
if($p==''){echo '<script>alert("文件名为空，无法删除！");location.href="?"</script>';}
unlink($p);
unlink(str_replace('.zip','.sql',$p));
echo '<script>alert("删除成功！");location.href="?"</script>';
}





?>
