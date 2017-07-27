<?php require_once('all.php');chkadcookie();?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>dobcms后台管理</title>
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" type="text/css" href="css/right.css">
  </head>
<body> 
<div id=rightmenu>
<div id=rightmenu_top>
<ul>
<li><a  target="main" href='setconfig.php'><b>您的位置：基本设置</b></a></li>
</ul>
</div>
<ul id=setconfig>
<?php
@$g=$_GET["g"];
    switch ($g)
    {
	default:index();break; 
    case "index":index();break; 
    case "save":save();break; 
    }
?>


</ul></div> 
  </body>
</html>

<?
function index(){
	global $root,$dbuser,$dbpsw,$dbname,$tabhead,$webname,$webkeywords,$webinfo,$weburl,$webauthor,$webbegindate,$pagenum,$cachepath,$date,$starttime,$themepath,$artpath,$tagpath;
?>


<form id="frm" name="frm" method="post" action="?g=save">
<p>网站地址<input maxlength="200" style="" value="<?=$weburl?>" name="1" /> 如http://localhost/</p>
<p>建立日期<input maxlength="200" style="" value="<?=$webbegindate?>" name="2" /> 如2017-05-20</p>
<p>网站标题<input maxlength="200" style="" value="<?=$webname?>" name="3" /></p>
<p>关 键 字<input maxlength="200" value="<?=$webkeywords?>" name="4" /> 网站关键字keywords,字数50以内</p>
<p>网站描述<textarea name="5" cols="" rows="3" style="color:#333"><?=$webinfo?></textarea> 网站描述description,字数150以内</p>
<p>默认编辑<input maxlength="200"  value="<?=$webauthor?>" name="6" /> 在编辑文章时默认显示的编辑</p>
<p>文章路径<input maxlength="200" style="" value="<?=$artpath?>" name="7" /> 
文章生成html页面的存放路径，如post/</p>
<!--
<p>文章链接<input maxlength="200" style="" value="{$weburl}{$artpath}{$htmlname}" name="artpathtype" id="artpathtype" /> </p>
<p ><label><input  type="radio" name="radio_artpathtype" value="{$weburl}{$artpath}{$htmlname}" onclick="document.getElementById('artpathtype').value=this.value" />&nbsp;{$weburl}{$artpath}{$htmlname}</label><br><br>
<label><input  type="radio" name="radio_artpathtype" value="{%host%}index.php/tags-{%id%}_{%page%}.html" onclick="document.getElementById('artpathtype').value=this.value" />&nbsp;{%host%}index.php/tags-{%id%}_{%page%}.html</label><br><br>
<label><input  type="radio" name="radio_artpathtype" value="{%host%}tags-{%id%}_{%page%}.html" onclick="document.getElementById('artpathtype').value=this.value" />&nbsp;{%host%}tags-{%id%}_{%page%}.html</label><br><br>
<label><input  name="radio_artpathtype" type="radio" value="{%host%}tags-{%alias%}_{%page%}.html" onclick="document.getElementById('artpathtype').value=this.value" />&nbsp;{%host%}tags-{%alias%}_{%page%}.html</label></p>
$path=$_REQUEST['path'];
//-->
<p>标签路径<input maxlength="200" style="" value="<?=$tagpath?>" name="8" /> tags生成html页面的存放路径，如tags/</p>
<!--
<p>标签链接<select name=tagpathtype  id=select><option>文件形式，如http://www.axublog.com/tags/别名.html</option><option>文件夹形式，如http://www.axublog.com/tags/别名/</option></select></p>
//-->
<p>缓存路径<input maxlength="200" style="" value="<?=$cachepath?>" name="9" /> 网站生成临时文件路径，如cache/</p>
<br><span id=setconfig_blank> </span><a  id=btn_yellow onclick="frm.submit()">保存设置</a><br><br>
</form>
<?	
}
?>

<?function save(){
global $root,$dbuser,$dbpsw,$dbname,$tabhead,$webname,$webkeywords,$webinfo,$weburl,$webauthor,$webbegindate,$pagenum,$cachepath,$date,$starttime,$themepath,$artpath,$tagpath;
$file="../cmsconfig.php";
$text = file_get_contents($file);
$text2=$text;
$text2=str_replace('"'.$weburl.'"','"'.$_POST[1].'"',$text2);
$text2=str_replace('"'.$webbegindate.'"','"'.$_POST[2].'"',$text2);
$text2=str_replace('"'.$webname.'"','"'.$_POST[3].'"',$text2);
$text2=str_replace('"'.$webkeywords.'"','"'.$_POST[4].'"',$text2);
$text2=str_replace('"'.$webinfo.'"','"'.$_POST[5].'"',$text2);
$text2=str_replace('"'.$webauthor.'"','"'.$_POST[6].'"',$text2);
$text2=str_replace('"'.$artpath.'"','"'.$_POST[7].'"',$text2);
$text2=str_replace('"'.$tagpath.'"','"'.$_POST[8].'"',$text2);
$text2=str_replace('"'.$cachepath.'"','"'.$_POST[9].'"',$text2);
?>

<div id=setconfig_ok><?
if(file_put_contents ($file, $text2)){echo"保存设置成功！";} 
else{echo"保存设置失败！";}
?></div>
<form id="frm" name="frm" method="post" action="?g=save">
<p>网站地址<input maxlength="200" style="" value="<?=$_POST[1]?>" name="1" /> 如http://localhost/</p>
<p>建立日期<input maxlength="200" style="" value="<?=$_POST[2]?>" name="2" /> 如2017-05-20</p>
<p>网站标题<input maxlength="200" style="" value="<?=$_POST[3]?>" name="3" /></p>
<p>关 键 字<input maxlength="200" value="<?=$_POST[4]?>" name="4" /> 网站关键字keywords,字数50以内</p>
<p>网站描述<textarea name="5" cols="" rows="3" style="color:#333"><?=$_POST[5]?></textarea> 网站描述description,字数150以内</p>
<p>默认编辑<input maxlength="200"  value="<?=$_POST[6]?>" name="6" /> 在编辑文章时默认显示的编辑</p>
<p>文章路径<input maxlength="200" style="" value="<?=$_POST[7]?>" name="7" /> 
文章生成html页面的存放路径，如post/</p>
<p>标签路径<input maxlength="200" style="" value="<?=$_POST[8]?>" name="8" /> tags生成html页面的存放路径，如tags/</p>
<!--
<p>标签链接<select name=tagpathtype  id=select><option>文件形式，如http://www.axublog.com/tags/别名.html</option><option>文件夹形式，如http://www.axublog.com/tags/别名/</option></select></p>
//-->
<p>缓存路径<input maxlength="200" style="" value="<?=$_POST[9]?>" name="9" /> 网站生成临时文件路径，如cache/</p>
<br><span id=setconfig_blank> </span><a  id=btn_yellow onclick="frm.submit()">保存设置</a><br><br>
</form>
<?}?>
