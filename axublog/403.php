
<?php
header("Content-type:text/html; charset=utf-8");
?>

<html>
<head>
<title>Powered by axublog</title>
<meta http-equiv=Content-Type content=text/html;charset=utf-8>
<link rel="shortcut icon" href="images/favicon.ico" >
<link rel="icon" href="images/favicon.ico" type="image/gif" >
</head>
<?
/****************
echo '端口:'.$_SERVER['REMOTE_PORT'].'<br>'; //端口。 
echo '服务器主机的名称:'.$_SERVER['SERVER_NAME'].'<br>'; //服务器主机的名称。 
echo '正在执行脚本的文件名:'.$_SERVER['PHP_SELF'].'<br>';//正在执行脚本的文件名   
echo 'CGI 规范的版本:'.$_SERVER['GATEWAY_INTERFACE'].'<br>';//CGI 规范的版本。 
echo '服务器标识的字串'.$_SERVER['SERVER_SOFTWARE'].'<br>'; //服务器标识的字串 
echo '请求页面时通信协议的名称和版本 '.$_SERVER['SERVER_PROTOCOL'].'<br>'; //请求页面时通信协议的名称和版本 
echo '访问页面时的请求方法'.$_SERVER['REQUEST_METHOD'].'<br>';//访问页面时的请求方法 
echo '查询(query)的字符串'.$_SERVER['QUERY_STRING'].'<br>'; //查询(query)的字符串。 
echo '当前请求的 Accept-Encoding: 头部的内容'.$_SERVER['HTTP_ACCEPT_ENCODING'].'<br>'; //当前请求的 Accept-Encoding: 头部的内容 
echo '前请求的 Connection: 头部的内容'.$_SERVER['HTTP_CONNECTION'].'<br>'; //当前请求的 Connection: 头部的内容。例如：“Keep-Alive”。 
echo '当前请求的 Host: 头部的内容'.$_SERVER['HTTP_HOST'].'<br>'; //当前请求的 Host: 头部的内容。 
echo '当前请求的 User_Agent: 头部的内容'.$_SERVER['HTTP_USER_AGENT'].'<br>'; //当前请求的 User_Agent: 头部的内容。
echo '当前请求的 Accept: 头部的内容'.$_SERVER['HTTP_ACCEPT'].'<br>'; //当前请求的 Accept: 头部的内容。
echo '当前网址：http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'<br>';
echo '当前运行脚本所在的文档根目录'.$_SERVER['DOCUMENT_ROOT'].'<br>'; //当前运行脚本所在的文档根目录 
echo '当前执行脚本的绝对路径名'.$_SERVER['SCRIPT_FILENAME'].'<br>'; #当前执行脚本的绝对路径名。 
echo '管理员信息 '.$_SERVER['SERVER_ADMIN'].'<br>'; #管理员信息 
echo '服务器所使用的端口 '.$_SERVER['SERVER_PORT'].'<br>'; #服务器所使用的端口 
echo '包含服务器版本和虚拟主机名的字符串'.$_SERVER['SERVER_SIGNATURE'].'<br>'; #包含服务器版本和虚拟主机名的字符串。 
echo '包含当前脚本的路径'.$_SERVER['SCRIPT_NAME'].'<br>'; #包含当前脚本的路径。这在页面需要指向自己时非常有用。
****************/
$configfile=$_SERVER['DOCUMENT_ROOT'].'/cmsconfig.php';
$installfile='http://'.$_SERVER['SERVER_NAME'].'/install/goinstall.php';
if(file_exists($configfile)){}else{echo"<script>location.href='".$installfile."'</script>";}  
?>
<br>403错误，index.php或index.html不存在

</html>
