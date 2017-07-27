<?php
require_once 'conn.php';

$g=$_GET['g'];
if($g==''){echo'请选择需要恢复的数据库文件！<br>';die();}
else{echo'恢复备份数据：'.$g.'<br>';}

$zipfile=$g;
$unzipfile='unzips';
		if (! file_exists ($unzipfile)) {
			chmod ($unzipfile, 0777 );
			mkdir ($unzipfile, 0777 );
		}

$z = new unZip;
$z->Extract($zipfile,$unzipfile);

$filename=str_replace('.zip','.sql',$unzipfile.'/'.$g);
if($g=="dberr"){$filename="db-error.txt";}

if(!mysql_connect($host,$user,$password)) //连接mysql数据库
{
 echo '数据库连接失败，请核对后再试';
 exit;
}
if(!mysql_select_db($dbname)) //是否存在该数据库
{
 echo '不存在数据库:'.$dbname.',请核对后再试';
 exit;
}


   $cg=0;
   $sb=0;
   $dberr="﻿set charset utf8;\r\n";
ob_start ();
include($filename);
$sql_value = ob_get_contents ();
ob_end_clean ();

$sql_value=str_replace("\\\\\\'","",$sql_value);
   $a=explode(";\n", $sql_value);  //根据";\r\n"条件对数据库中分条执行
   $total=count($a)-1;
   mysql_query("set names 'utf8'");

   #echo "<textarea rows=10 cols=30>"; 
   for ($i=0;$i<$total;$i++){
    //执行命令
$nei=$a[$i];
#echo "<textarea rows=10 cols=30>".$nei."</textarea>"; 
    if(mysql_query($nei)){$cg+=1;}
    else
    {
     $sb+=1;
     $sb_command[$sb]=$a[$i];
	 echo $sb_command[$sb]; 
	 $dberr=$dberr.$sb_command[$sb].";\r\n";
    }
}
	 #echo "</textarea>"; 

if($total>1){$total=$total-1;}
if($cg>1){$cg=$cg-1;}
if($sb>1){$sb=$sb-1;}

   echo "<hr>操作完毕，共处理 $total 条命令，<font color=red>成功 $cg 条，失败 $sb 条</font><br>";
   //显示错误信息 
#echo $ok;
			if ($sb>0){
			echo "<hr>失败命令代码在目录下：db-error.txt<br><a href=?g=db-error.txt >再试试》》》</a>";
			file_put_contents ("db-error.txt", $dberr);
			}
#echo "MySQL备份文件不存在，请检查文件路径是否正确！<br>";

?>