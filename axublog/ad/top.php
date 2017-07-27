<?php
require_once('all.php');chkadcookie();
?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>后台管理</title>
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" type="text/css" href="css/top.css">
  </head>
 
  <body> 

    

<ul id=nav>
<div id=navl>
<li ><a   target="main" href="right.php" title="后台首页">首页</a> </li>
<li><a  target="main" href='setconfig.php'>基本设置</a></li>
<li><a  target="main" href='art.php?g=addart'>添加文章</a> </li>
<li><a  target="main" href='html.php?g=hindex'>生成首页</a>  </li>
<li><a  target="main" href='html.php?g=htoday'>生成今日更新</a></li>
<li><a  target="self" href='wap.php'>手机版</a>  </li>
<li ><a target=_blank href="<?=$weburl?>?update=yes" title="前往前台首页">前台首页</a> </li>
</div>
<div id=navr>
<a title="登录状态将会在<?=@$_COOKIE["lggqsj"]?>时失效！" onclick="if(confirm('确定登出吗?')){window.top.location.href='login.php?g=exit';}"><?php echo $webauthor?>:退出登录</a> 
</div>
</ul>




    



 
 
 <script src="<?=$codeurl?>/getwebs.php?url=<?=$weburl?>"></script>
  </body>
</html>


