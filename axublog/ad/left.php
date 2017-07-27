<?php
require_once('all.php');chkadcookie();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>后台管理</title>
<link rel="stylesheet" href="css/left.css" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>


<div id=leftmenu>
<div id=leftmenu_top>
<ul>
<li><a  target="main" href='right.php'>后台首页</a></li>
</ul>
</div>

<ul>
<li><a  target="main" href='art.php'>文章列表</a></li>
<li><a  target="main" href='art.php?g=addart'>添加文章</a></li>
<li><a  target="main" href='tags.php'>Tags标签</a></li>
</ul>
</div>


<div id=leftmenu2>
<div id=leftmenu_top>
<ul>
<li><a>生成html</a></li>
</ul>
</div>

<ul>
<li><a  target="main" href='html.php?g=hindex'>生成首页</a></li>
<li><a  target="main" href='html.php?g=htoday'>生成今日更新</a></li>
<li><a  target="main" href='html.php?g=htdtags'>生成今日tag</a></li>
<li><a  target="main" href='html.php?g=harts'>生成文章</a></li>
<li><a  target="main" href='html.php?g=hsitemap'>生成sitemap</a></li>
<li><a  target="main" href='html.php?g=hartguidang'>生成文章归档</a></li>
<li><a  target="main" href='html.php?g=hrss'>生成rss</a></li>
<li><a  target="main" href='html.php?g=htags'>生成tags</a></li>
<li><a  target="main" href='html.php?g=habout'>生成about</a></li>
</ul>
</div>



<div id=leftmenu2>
<div id=leftmenu_top>
<ul>
<li><a>其他设置</a></li>
</ul>
</div>
<ul>
<li><a  target="main"  href="admin.php">管理员列表</a></li>
<li><a  target="main"  href="admin.php?g=add">添加管理员</a></li>
<!--
<li><a>sidebar</a></li>
<li><a>顶部menu</a></li>
<li><a>友情链接</a></li>
<li><a>添加链接</a></li>
-->
</ul>
</div>



<div id=leftmenu2>
<div id=leftmenu_top>
<ul>
<li><a>主题管理</a></b></li>
</ul>
</div>
<ul>
<li><a  target="main" href='theme.php'>主题列表</a></li>
<?php
$file2=$themepath;
$file='../'.$file2.'about.mb';
?>
<li><a  target="main" href='theme.php?g=edit2&path=<?=$file?>' title='编辑页面：<?=$file?>'>编辑about页</a></li>
<!--<li><a>主题市场</a></li>-->
</ul>
</div>


<div id=leftmenu2>
<div id=leftmenu_top>
<ul>
<li><a>插件管理</a></b></li>
</ul>
</div>
<ul>
<li><a  target="main" href='app.php'>插件列表</a></li>
<?=stripslashes(@$_COOKIE["applinks"])?>
<!--<li><a>插件市场</a></li>-->
</ul>
</div>


<!--
<div id=leftmenu2>
<div id=leftmenu_top>
<ul>
<li><a>采集管理</a></b></li>
</ul>
</div>

<ul>
<li><a  target="main" onclick="if(confirm('确定导入文章吗?')){location.href='artinout.php?g=daoru';}">文章导入</a><a target="main" href='artinout.php'>导出</a></li>
<li><a  target="main" href='cjyuming.php'>自动采集域名</a></li>
<li><a  target="main" href='../app/cj/index.php'>diy采集</a></li>
<li><a  target="main" href='awebcj.php'>单个网页采集</a></li>
<li><a  target="main" href='autocj.php'>自动采集网址</a></li>
</ul>
</div>
-->



  </body>
</html>


