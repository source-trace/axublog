<html>
<head>
<title>后台管理</title>
<style>
*{margin:0;padding:0;}
body {text-align:center;margin:0 auto;background:white;font:13px arial;} 
p{margin:5px;}
#top{width:100%;line-height:36px;border-top:1px solid #ddd;background:#f0f0f0;color:#888;}
#top a{color:#111;}
#left{float:left;padding-left:10px;}
#right{float:right;padding-right:10px;}
</style>
<meta http-equiv=Content-Type content=text/html;charset=utf-8>
</head>

<?
include_once("c_login.php");
?>
<div id="top">
<div id="left">感谢使用 <a target=_blank href="<?=$codeurl?>"><?=$codename?> <?=$codeversion?></a> 建设网站，<?=$codename?>努力成为最优秀国产博客系统！  官方文档 | <a target=_blank href="<?=$codeurl?>">意见建议</a> </div>
<div id="right">Powered by <?=$codename?> </div>
</div>



</html>