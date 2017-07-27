<?php require_once('all.php');chkadcookie();?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>后台管理</title>
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" type="text/css" href="css/right.css">
	<script type="text/javascript" src="jquery-1.8.2.min.js"></script>
<script type="text/javascript">  
 $(function(){
        $("#send").click(function(){
			$("#update").html("<img src='images/loading.gif' width=18 height=18 >loading...");
setTimeout('htmlobj=$.ajax({url:"update.php?g=g",async:false});$("#update").html(htmlobj.responseText);', 500);  
         });
    });
 
 $(function(){
        $("#send2").click(function(){
			$("#xiaoxi").html("<img src='images/loading.gif' width=18 height=18 >loading...");
setTimeout('htmlobj=$.ajax({url:"xiaoxi.php?g=g",async:false});$("#xiaoxi").html(htmlobj.responseText);', 500);  
         });
    });
	
 $(function(){
        $("#send3").click(function(){
			$("#get3").html("<img src='images/loading.gif' width=18 height=18 >loading...");
setTimeout('htmlobj=$.ajax({url:"ajax.php?g=clearcache",async:false});$("#get3").html(htmlobj.responseText);', 500);  
         });
    });
	

	
</script>
  </head>
  <body> 
<div id=rightmenu>
<div id=rightmenu_top>
<ul>
<li><a  target="main" href='right.php'><b>网站信息</b></a></li>
</ul>
</div>
<ul id=rightphp>


<p>
<?
@$path=$_SERVER['REQUEST_URI'];
$path=str_replace('/right.php','',$path);
if($path=='/ad'){
	?>
	<span id=red>后台管理路径：/ad，不安全，建议重命名</span>
	<?
	}
	?>
</p>


<?
if(@$_COOKIE['tagshu']==''){getalltag();getallart();chkthemeappshu();}
?>
<p>
<span>tags：<?=@$_COOKIE['tagshu']?>个 </span>
<span>文章：<?=@$_COOKIE['artshu']?>篇 </span>
<span>主题数量：<?=$themeshu?>个</span>
<span>当前主题：<?=$themepath?> </span>
<span>插件数量：<?=$appshu?>个 </span>
</p>


<p>
<span>服务器操作系统： <?PHP echo PHP_OS; ?> </span>
<span>服务器端信息： <?PHP echo $_SERVER ['SERVER_SOFTWARE']; ?> </span>
<span>PHP版本：<?=PHP_VERSION; ?></span>
<span>MYSQL版本：<?=@mysql_get_server_info(); ?></span>
</p>
<?
$sysos = $_SERVER["SERVER_SOFTWARE"];      //获取服务器标识的字串
$sysversion = PHP_VERSION;                   //获取PHP服务器版本

$mysqlinfo = @mysql_get_server_info();
//从服务器中获取GD库的信息
if(function_exists("gd_info")){                  
$gd = gd_info();
$gdinfo = $gd['GD Version'];
}else {
$gdinfo = "未知";
}
//从GD库中查看是否支持FreeType字体
$freetype = $gd["FreeType Support"] ? "支持" : "不支持";
//从PHP配置文件中获得是否可以远程文件获取
$allowurl= ini_get("allow_url_fopen") ? "支持" : "不支持";
//从PHP配置文件中获得最大上传限制
$max_upload = ini_get("file_uploads") ? ini_get("upload_max_filesize") : "Disabled";
echo "<p> ";
#echo "<span> Web服务器：    $sysos        </span> ";
#echo "<span> PHP版本：   $sysversion   </span> ";
#echo "<span> MySQL版本：    $mysqlinfo    </span> ";
echo "<span title='在网站上GD库通常用来生成缩略图，或者用来对图片加水印，或者用来生成汉字验证码'> GD库版本：$gdinfo       </span> ";
echo "<span> FreeType：$freetype     </span> ";
echo "<span> 远程文件获取：$allowurl     </span> ";
echo "<span> 最大上传限制：$max_upload   </span> ";
echo "</p> ";
?>


<p>
<span><?=$codename?>当前版本：<?=$codeversion?> </span>
<span><button id="send" >获取最新版本：</button> <a id="update"><?=@$_COOKIE["latestversion"]?> </a> </span>
<button id="send3" >清除所有缓存</button><span id="get3"></span>
</p>

<p id=xiaoxi2>官网最新消息 <button id="send2" >刷新</button>
</p>
<div id="xiaoxi"><?=@$_COOKIE["xiaoxi"]?></div>


<p>界面设计：Donny</p>
<p><?=$codename?>官方链接：
<a target=_blank href="http://www.axublog.com/tags/geng_xin_221437/">程序下载</a> 
<a  target=_blank href="http://www.axublog.com/tags/cha_jian_181641/">插件中心</a> 
<a  target=_blank href="http://www.axublog.com/tags/zhu_ti_112835/">主题中心</a> 
<a  target=_blank href="http://www.axublog.com/post/axublog_yi_jian_jian_yi_2821/">意见建议</a> 
</p>
</ul></div>








    
  </body>
</html>


