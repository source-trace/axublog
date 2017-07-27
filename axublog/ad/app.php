<?php require_once('all.php');chkadcookie();?>
<html>
<head>
<title>app管理</title>
<link rel="stylesheet" href="css/right.css" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script src="jspost.js"></script> 
</head>
<body>
<?php
@$g=$_GET["g"];
    switch ($g)
    {
	default:index();break; 
    case "power":power();break; 
    case "edit":edit();break; 
	case "edit2":edit2();break; 
	case "edit2save":edit2save();break; 
    }
?>

<?php 
function index(){
global $apppath;
@$msg=$_GET["msg"];
?>
<div class="yj_green" id=full>
<b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b>
<div class="boxcontent">
<h2><a href="?">插件管理</a></h2>
</div>
<div class="t1"><div class="t2">
<div id=app>
<?if($msg!=''){?>
<script> 
window.onload=function(){ setTimeout("doit()",1300);}
function doit(){ document.getElementById('appmsg').style.display='none'; } 
 </script>
<div id=appmsg><?=$msg?></div>
<?}?>
<ul id=top>
<li id=ico>图标</li>
<li id=name>名称</li>
<li id=author>作者</li>
<li id=date>更新日期</li>
<li id=set>设置</li>
</ul>
<?php
$file2=$apppath;
$file='../'.$file2;
$path_pattern = "../".$apppath."*";
$shu=0;$qiyong=0;$applinks='';
		foreach(glob($path_pattern) as $file)      
				{
					$infopath=$file.'/info.txt';
						if(is_dir($file)&&file_exists($infopath)){ 
						$file=iconv( "GB2312","UTF-8", $file);
						#$file2=str_replace('../','',$file.'/');
						@$text = file_get_contents($infopath);
						preg_match("/<name>(.*)<\/name>/i", $text, $name);$name=$name[1];
					preg_match("/<version>(.*)<\/version>/i", $text, $version);$version=$version[1];
preg_match("/<info>(.*)<\/info>/i", $text, $info);$info=$info[1];
preg_match("/<url>(.*)<\/url>/i", $text, $url);$url=$url[1];
preg_match("/<author>(.*)<\/author>/i", $text, $author);$author=$author[1];
preg_match("/<lastdate>(.*)<\/lastdate>/i", $text, $lastdate);$lastdate=$lastdate[1];
preg_match("/<type>(.*)<\/type>/i", $text, $type);$type=$type[1];
preg_match("/<switch>(.*)<\/switch>/i", $text, $switch);$switch=$switch[1];	
if($type=='back'){$link=$file.'/index.php';}else{$link='#';}
if($switch=='on'){$applinks=str_replace('<p><a  target="main" href="'.$link.'">'.$switch.'</a></p>','',$applinks);$applinks=$applinks.'<p><a  target="main" href="'.$link.'">'.$name.'</a></p>';}else{$applinks=$applinks;}

						echo "<ul>";  
						echo"<li id=ico><img style='opacity:1.0' src='".$file."/logo.png'></li>";
						echo"<li id=name><a title='简介：&#13;".$info."&#10;_' >".$name."</a> ".$version."</li>";
						echo"<li id=author>".$author." <a href='".$url."' target=_blank >访问网站</a> </li>";
						echo"<li id=date>".$lastdate."</li>";
						if($switch=='on'){$qiyong=$qiyong+1;echo"<li id=set><a href='?g=power&path=".$file."' title=点击停用 ><img width=16 src='images/poweron.png' alt=点击停用 ></a> <a href='".$link."' title=设置 ><img alt=设置  width=16 src='images/set.png'></a></li>";}else{echo"<li id=set><a href='?g=power&path=".$file."' title=点击启用 ><img width=16 src='images/poweroff.png' alt=点击启用 ></a> <a href='#' title=删除 ><img  width=16 src='images/delete.png'></a></li>";}
						echo "</ul>"; 
						$shu=$shu+1;
						#define($file,serialize(array('name'=>$name,'version'=>$version,'info'=>$info,'url'=>$url,'author'=>$author,'lastdate'=>$lastdate,'type'=>$type,'switch'=>$switch,'path'=>$file)));
										  }
				}
setcookie("applinks",$applinks, time()+999999,"/; HttpOnly" , "",'');
?>
<div id=app_shu><?=$qiyong?>个已启用/共有<?=$shu?>个app</div>
</div>
</div></div>
<b class="b4b"></b><b class="b3b"></b><b class="b2b"></b><b class="b1b"></b>
</div>
<?php
}
?>


<?php 
function power(){
@$path=$_GET["path"];if($path==''){header("Location: app.php");}
$infopath=$path.'/info.txt';if(!is_file($infopath)){header("Location: app.php");}
@$text = file_get_contents($infopath);
preg_match("/<switch>(.*)<\/switch>/i", $text, $switch);$switch=$switch[1];	
if($switch=='on'){setcookie("applinks",'', time()+999999,"/; HttpOnly" , "",'');$text=str_replace('<switch>on</switch>','<switch>off</switch>',$text);header("Location: app.php?msg=已停用");}else{$text=str_replace('<switch>off</switch>','<switch>on</switch>',$text);header("Location: app.php?msg=已启用");}
file_put_contents($infopath,$text);
}
?>




<?php 
function edit(){
global $themepath;
$path=$_REQUEST['path'];
if($path==''){echo'主题路径错误！';exit;}
?>
<div class="yj_green" id=full>
<b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b>
<div class="boxcontent">
<h2><a href="?">主题管理</a> > 编辑主题<?=$path?> > <a href="javascript:history.back()">返回</a></h2>
</div>
<div class="t1"><div class="t2">
<p>当前已使用主题：<?=$themepath?></p>

<p>编辑主题：<?=$path?> 
<a id=abtn_blue href='?g=savechoose&path=<?=$path?>' >使用此主题</a> </p>
<?php
$path_pattern = "../".$path.'*';
foreach(glob($path_pattern) as $file){
						$file=iconv( "GB2312","UTF-8", $file);
						$houzui=substr(strrchr($file, '.'), 1); 
			if($houzui=='mb'|$houzui=='htm'|$houzui=='html'|$houzui=='css'|$houzui=='js'|$houzui=='txt'){
			echo "<p><a title=编辑此文件 href='?g=edit2&path=".$file."'>编辑 ";
			echo $file."</a></p>";
			}
}
?>
</div></div>
<b class="b4b"></b><b class="b3b"></b><b class="b2b"></b><b class="b1b"></b>
</div>
<?php
}
?>




<?php 
function edit2(){
global $themepath;
$path=$_REQUEST['path'];
?>
<div class="yj_green" id=full>
<b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b>
<div class="boxcontent">
<h2><a href="?">主题管理</a> > <a href="javascript:history.go(-1)">编辑主题</a> > 编辑文件 > <a href="javascript:history.go(-1)">返回</a></h2>
</div>
<div class="t1"><div class="t2">
<p>编辑文件：<?=$path?>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;   &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<button onclick="javascript:frm.submit()" >保存编辑</button></p>
<?php
if($path==''){echo'文件路径错误！';exit;}


$text2 = file_get_contents($path);
#$text2=addslashes($text2);
#echo $text2;
#die();
$encode = mb_detect_encoding($text2 , array('UTF-8','GBK')) ;
if( $encode!= 'UTF-8'){
$text2 = mb_convert_encoding($text2 ,'utf-8' , $encode);
}
?>
<p>编码：<?=$encode?>  （本编辑器只支持GBK和UTF-8编码，如果文件内容不能显示中文为乱码时，请勿修改！）</p>
<form id="frm" name="frm" method="post" action="?g=edit2save" onSubmit="return false;" >
<input  name=path type=hidden size=50 value="<?=$path?>" >
<textarea name=content cols=110 rows=30><?=$text2?></textarea>
</div></div>
<b class="b4b"></b><b class="b3b"></b><b class="b2b"></b><b class="b1b"></b>
</div>
<?php
}
?>


<?php 
function edit2save(){
global $themepath;
?>
<div class="yj_green" id=full>
<b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b>
<div class="boxcontent">
<h2><a href="?">主题管理</a> > <a href="javascript:history.go(-2)">编辑主题</a> > 编辑文件 > <a href="javascript:history.back()">返回</a></h2>
</div>
<div class="t1"><div class="t2">
<?php
$path=$_REQUEST['path'];
$content=stripslashes($_REQUEST['content']);
?>
<p>编辑文件：<?=$path?></p>
<?php
if($path==''){echo'文件路径错误！';exit;}

if(file_put_contents ($path, $content)){echo"保存文件成功！";} 
else{echo"保存文件失败！";}
?>

</div></div>
<b class="b4b"></b><b class="b3b"></b><b class="b2b"></b><b class="b1b"></b>
</div>
<?php
}
?>


<?php
mysql_close($con);
echo runtime();
?>
</body>
</html>