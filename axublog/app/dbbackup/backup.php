<?php

require_once 'conn.php';




@$g=$_GET['g'];
@$z=$_GET['z'];


if($g='d'&&$z!=''){force_download($z);die();}



if(!mysql_connect($host,$user,$password))  //连接mysql数据库
{
 echo '数据库连接失败，请核对后再试';
 exit;
}
if(!mysql_select_db($dbname))  //是否存在该数据库
{
 echo '不存在数据库:'.$dbname.',请核对后再试';
 exit;
}
mysql_query("set names 'utf8'");
$mysql= "set charset utf8;\r\n";  
$q1=mysql_query("show tables");
while($t=mysql_fetch_array($q1)){
    $table=$t[0];
    $q2=mysql_query("show create table `$table`");
    $sql=mysql_fetch_array($q2);
    $mysql.=$sql['Create Table'].";\r\n";
    $q3=mysql_query("select * from `$table`");
    while($data=mysql_fetch_assoc($q3)){
        $keys=array_keys($data);
        #$keys=array_map('addslashes',$keys);
        $keys=join('`,`',$keys);
        $keys="`".$keys."`";
        $vals=array_values($data);
        #$vals=array_map('addslashes',$vals);
        $vals=join("','",$vals);
        $vals="'".$vals."'";
        $mysql.="insert into `$table`($keys) values($vals);\r\n";
    }
}
date_default_timezone_set( "Asia/Shanghai" );
$date=$dbname.date('Ymd-His');
$filename=$date.".sql";  //存放路径，默认存放到项目最外层
$zipname=$date.".zip";
$fp = fopen($filename,'w');
fputs($fp,$mysql);
fclose($fp);
$files=array($filename);
$z = new PHPZip(); 
$z->Zip($files,$zipname);
unlink($filename); 
#echo $filename."数据备份成功<br> <a target=_blank href='backup.php?g=d&z=".$zipname."'>下载</a> - <a target=_blank href='sendmail.php?a=".$zipname."&d=".$dbname."'>发送邮件</a><br>";
echo '<script>alert("数据备份成功！");location.href="index.php"</script>';





/********************
*@file - path to file
*/
function force_download($file)
{
if ((isset($file))&&(file_exists($file))) {
header("Content-length: ".filesize($file));
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . $file . '"');
readfile("$file");
} else {
echo "No file selected";
}
} 



?>
