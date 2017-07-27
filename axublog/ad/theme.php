<?php 
require_once('all.php');chkadcookie();
?>
<html>
<head>
<title>管理</title>
<link rel="stylesheet" href="css/right.css" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php
@$g=$_GET["g"];
?>
<script src="jspost.js"></script> 
</head>
<body>
<?php
    switch ($g)
    {
	default:index();break; 
    case "index":index();break; 
    case "savechoose":savechoose();break; 
    case "edit":edit();break; 
	    case "edit2":edit2();break; 
		case "edit2save":edit2save();break; 
    }
?>


<?php 
function index(){
global $themepath;
?>
<div class="yj_green" id=full>
<b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b>
<div class="boxcontent">
<h2><a href="?">主题管理</a></h2>
</div>
<div class="t1"><div class="t2">
<div id=theme>
<?php
$file2=$themepath;
$file='../'.$file2;
						echo "<ul>";  
						echo"<img  src='".$file."/jietu.png' ><br><center>";
						echo $file."<br>"; 
						echo" <b>正在使用此主题</b> ";
						echo" <a href='?g=edit&path=".$file2."' >编辑</a> </center><br><br>";
						echo "</ul>"; 
						
$path_pattern = "../theme/*";
		foreach(glob($path_pattern) as $file)      
				{
						if(is_dir($file)){ 
						$file=iconv( "GB2312","UTF-8", $file);
						$file2=str_replace('../','',$file.'/');
						if($file2==$themepath){}
														else{
							echo "<ul>";  
							echo"<a href='?g=savechoose&path=".$file2."' title=使用此主题 ><img alt=使用此主题 src='".$file."/jietu.png' width=100></a><br><center>";
							echo $file."<br>"; 
							echo" <a href='?g=savechoose&path=".$file2."'>使用此主题</a> ";
							echo" <a href='?g=edit&path=".$file2."' >编辑</a> </center><br><br>";
							echo "</ul>"; 
							}

						}
				}
?>

</div>
</div></div>
<b class="b4b"></b><b class="b3b"></b><b class="b2b"></b><b class="b1b"></b>
</div>
<?php
}
?>


<?php 
function savechoose(){
global $themepath;
?>
<div class="yj_green" id=full>
<b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b>
<div class="boxcontent">
<h2><a href="?">主题管理</a> > 保存 > <a href="javascript:history.back()">返回</a></h2>
</div>
<div class="t1"><div class="t2">
<p>当前主题：<?=$themepath?></p>
<?php
$path=$_REQUEST['path'];
                if($path==''){echo'主题路径错误！';exit;}
$file="../cmsconfig.php";
$fp=fopen($file,"r");         //以写入方式打开文件
$text2=fread($fp,4096);         //读取文件内容
$text2=str_replace($themepath,$path,$text2);
$file="../cmsconfig.php";          //定义文件
$fp=fopen($file,"w");         //以写入方式打开文件
fwrite($fp,$text2);  
?>
<p>已使用主题：<?=$path?></p>
</div></div>
<b class="b4b"></b><b class="b3b"></b><b class="b2b"></b><b class="b1b"></b>
</div>
<?php
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
						if($houzui=='mb'){$chkhouzui='';}else{$chkhouzui=' id=eee ';}
			if($houzui=='mb'|$houzui=='htm'|$houzui=='html'|$houzui=='css'|$houzui=='js'|$houzui=='txt'){
			echo "<p".$chkhouzui."><a title=编辑此文件 href='?g=edit2&path=".$file."'>编辑 ";
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