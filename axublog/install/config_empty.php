<?php
ini_set("error_reporting","E_ALL & ~E_NOTICE");
#error_reporting(0);
#session_start();
#header("Content-type:text/html; charset=utf-8");


$root="@root@";                   #MySQL服务器 
$dbuser="@dbuser@";           #MySQL用户名 
$dbpsw="@dbpsw@";           #MySQL密码 
$dbname="@dbname@";               #数据库名
$tabhead="@tabhead@";               #表前缀



$webname="@webname@";             #网站名称
$webkeywords="@webkeywords@";             #网站关键字
$webinfo="@webinfo@";             #网站简介
$weburl= "@weburl@";             #网站链接,根目录可填写/，便于移动网站
$webauthor="@webauthor@";             #网站编辑，前台显示
$webbegindate="2017-05-30";             #网站建立日期

$pagenum="20";                       #每页显示文章数 
$cachepath="cache/";

date_default_timezone_set('PRC');
$date=date('Y-m-d H:i:s');
$starttime=microtime(true);   

$configfile="cmsconfig.php"; 
$themepath="theme/default/";
$themeshu="1";  
$apppath="app/";
$appshu="1";      
$artpath="post/";        
$tagpath="tags/";   

$con=mysql_connect($root,$dbuser,$dbpsw);
if(!$con){echo "<font color=red>(连接到MYSQL失败,请检查MYSQL信息!)</font>";return false;}
mysql_select_db($dbname);
mysql_query("SET NAMES 'utf8'");

#global $root,$dbuser,$dbpsw,$dbname,$tabhead,$webname,$webkeywords,$webinfo,$weburl,$webauthor,$webbegindate,$pagenum,$cachepath,$date,$starttime,$artpath,$tagpath,$themepath,$themeshu,$apppath,$appshu,$configfile;
?>