<?php
require_once('all.php');chkadcookie();
?>
<!DOCTYPE HTML>
<html>
<head>
<?php 
require_once('pinyin.php');
?>


<title>管理</title>
<link rel="stylesheet" href="css/right.css" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>



<?php

@$g=$_GET["g"];
    switch ($g)
    {
    case "addsave":addsave();break; 
    case "edit":edit();break; 
    case "editsave":editsave();break; 
    case "del":del();break; 
    case "addtagssave":addtagssave();break; 
    default:navlist();break; 
    }

?>




<?php 
function navlist(){

?>


<script>
function chksubmit(){
var name=frm.name.value.replace(/^\s+|\s+$/g,"");
var htmlname=frm.htmlname.value.replace(/^\s+|\s+$/g,"");
var info=frm.info.value.replace(/^\s+|\s+$/g,"");
var reg= /^[A-Za-z0-9-_]+$/;
if (reg.test(htmlname)) {}
else{alert("不能含有中文或特殊符号");frm.htmlname.focus();return false;}
if(name=='填写tag名称'){alert('请输入tag名称！');frm.name.focus();return false;}
else if(name==''){alert('请输入tag名称！');frm.name.focus();return false;}
else{frm.submit();}
}

function chksubmit2(){
var name=frm2.tags.value.replace(/^\s+|\s+$/g,"");
if(name==''){alert('请输入tag名称！');frm2.tags.focus();return false;}
else{frm2.submit();}
}
</script>
<div id=navlist_left>
<div class="yj_green">
<b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b>
<div class="boxcontent">
<h2>添加新tag</h2>
</div>
<div class="t1"><div class="t2">
<form id="frm" name="frm" method="post" action="?g=addsave">
<p><input  size=30 type=text name=name value="填写tag名称" onfocus="if(this.value=='填写tag名称'){this.value=''}" onblur="if(this.value==''){this.value='填写tag名称'}"></p>
<p><input size=30 name=htmlname type=text value="填写html别名" onfocus="if(this.value=='填写html别名'){this.value=''}" onblur="if(this.value==''){this.value='填写html别名'}">.html<br>留空则自动转为拼音,它通常为小写并且只能包含字母，数字和下划线，不要用特殊符号</p>

<p>简介，对tag做简单的描述：<br><textarea name="info" rows=5 cols=28></textarea></p>
<br><a id=abtn_green onclick="chksubmit()">确认提交</a>

<br><br>
</form>
</div></div>
<b class="b4b"></b><b class="b3b"></b><b class="b2b"></b><b class="b1b"></b></div>
<div id=br5></div>

<div class="yj_green">
<b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b>
<div class="boxcontent">
<h2>添加多个tag</h2>
</div>
<div class="t1"><div class="t2">
<form id="frm2" name="frm2" method="post" action="?g=addtagssave">
多个标签请用英文逗号,分开 <br>
<p><input size=36 name=tags id=tags type=text ></p>
</form>
<br><a id=abtn_green onclick="chksubmit2()">添加</a><br><br>

</div></div>
<b class="b4b"></b><b class="b3b"></b><b class="b2b"></b><b class="b1b"></b></div>
<div id=br></div>

</div>



<?php
global $tabhead;
$tab=$tabhead."navs";
mysql_select_db($tab);
$sql = mysql_query("select * from ".$tab."");
$shu=mysql_num_rows($sql);
?>

<div id=navlist_right>
<div class="yj_green">
<b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b>
<div class="boxcontent"><h2>
<div id=navlist_name><input type="checkbox" >tag(数量：[<?=$shu?>]个)</div>
<div id=navlist_htmlname>html别名</div>
<div id=navlist_shu>文章数</div>
</h2></div>
<div class="t1"><div class="t2">

<?php
if(!$sql){echo "<font color=red>(打开数据库时遇到错误!)</font>";return false;}
$options = array(
	'total_rows' => $shu, //总行数
	'list_rows'  => '10',  //每页显示量
);
$page = new page($options);
$sql = mysql_query("select * from ".$tab." order by id desc limit $page->first_row , $page->list_rows");
?>


<div id=page><?=$page->show(1)?></div>
<?php

while($row=mysql_fetch_array($sql))
{
$p_id=$row['id'];
$p_name=$row['name'];
$p_htmlname=$row['htmlname'];
$p_url=tagtourl($p_htmlname);
$p_fuid=$row['fuid'];
$p_info=$row['info'];

$tab2=$tabhead."nav_art";
$sql2=mysql_query('select * from '.$tab2.' where navid='.$p_id);
$myrow=mysql_fetch_row($sql2);
$p_shu=mysql_numrows($sql2);

echo <<<EOF

<div id=navlist_row>
<div id=navlist_name><input type="checkbox" >
<a href="?g=edit&id={$p_id}">编辑</a>|<a onclick="if(confirm('确定删除吗?')){location.href='?g=del&id={$p_id}';}">删除</a>|<a href="html.php?g=hatag&t={$p_htmlname}">生成</a>|<a target=_blank href="{$p_url}">查看</a>
  {$p_name}
</div>
<div id=navlist_htmlname>{$p_htmlname}</div>
<div id=navlist_shu>{$p_shu}</div>
</div>
<div id=br></div>
EOF;
}

?>

<div id=page><?=$page->show(3)?></div>


</div></div>
<b class="b4b"></b><b class="b3b"></b><b class="b2b"></b><b class="b1b"></b></div>
<div id=br></div>
<p><b>注意：</b><br>
删除tag不会把该tag下的文章一并删除，取而代之，文章会被归入 第一个 tag。</p>

</div>


<?php 
}
?>










<?php 
function addsave(){
chkoutpost();

$name=trim($_POST['name']);
$htmlname=trim($_POST['htmlname']);
$fuid=$_GET['fuid'];
$info=$_GET['info'];

if($name==''){
$name=trim($_POST['name']);
$htmlname=trim($_POST['htmlname']);
$fuid=0;
$info=$_POST['info'];
}
/*
echo $name.'<br>';
echo $htmlname.'<br>';
echo $fuid.'<br>';
echo $info.'<br>';
*/

if($name==''){echo"<div id=err>信息提交错误，请检查！</div>";return false;}
if($htmlname=='填写html别名'|$htmlname==''){$htmlname=pinyin($name);}




global $tabhead;
$tab=$tabhead."navs";

mysql_select_db($tab);
$sql = mysql_query("select * from ".$tab." where name='".$name."'");
if(!$sql){echo "<font color=red>(打开数据库时遇到错误!)</font>";return false;}
$num=mysql_num_rows($sql);
if(!$num==0){echo '<script>alert("tag名称 '.$name.' 已存在，请修改！");history.back();</script>';die();}

$sql = mysql_query("select * from ".$tab." where htmlname='".$htmlname."'");
if(!$sql){echo "<font color=red>(打开数据库时遇到错误!)</font>";return false;}
$num=mysql_num_rows($sql);
if(!$num==0){echo '<script>alert("tag别名 '.$htmlname.' 已存在，请修改！");history.back();</script>';die();}

$sql="INSERT INTO ".$tab." (id,name,htmlname,info,type,fuid) VALUES (null,'".$name."','".$htmlname."','".$info."','tag','".$fuid."')";
if(mysql_query($sql)){echo"<div id=ok>tag【".$name."】添加成功</div>";jump('javascript:history.back()',1);}
else{echo"<div id=err>tag【".$name."】添加失败，请检查数据库！</div>";jump('javascript:history.back()',1);}
 
}
?>









<?php 
function addtagssave(){
chkoutpost();

$tags=trim($_REQUEST['tags']);
$tags=$tags.',';
$tags=str_replace(',,',',',$tags);
$tags=str_replace(' ','',$tags);
$a=explode(',',$tags);
$shu=count($a)-1;
echo '添加tags：'.$tags.'<br>数量：'.$shu.'<br>';

for($i=1;$i<=$shu;$i++){
$name=$a[$i-1];
$htmlname=pinyin($name);
$fuid=0;
$info='';
global $tabhead;
$tab=$tabhead."navs";
mysql_select_db($tab);
$sql = mysql_query("select * from ".$tab." where name='".$name."' or htmlname='".$htmlname."'");
		if(!$sql){echo "<font color=red>(打开数据库时遇到错误!)</font><br>";return false;}
		$num=mysql_num_rows($sql);
		if(!$num==0){echo '['.$name.']:tag名称或别名已存在，请修改！<br>';}
		else{
		$sql="INSERT INTO ".$tab." (id,name,htmlname,info,type,fuid) VALUES (null,'".$name."','".$htmlname."','".$info."','tag','".$fuid."')";
		if(mysql_query($sql)){echo"<div id=ok>tag【".$name."】添加成功</div>";}
		else{echo"<div id=err>tag【".$name."】添加失败，请检查数据库！</div>";}
		}
}



}
?>




<?php 
function edit(){
$id=$_GET['id'];
$a=navidgetnav($id);
$name=$a["name"];
$_SESSION['name']=$name;
$htmlname=$a["htmlname"];
$_SESSION['htmlname']=$htmlname;
$info=$a["info"];
$fuid=$a["fuid"];
?>
<script>
function chksubmit(){
var htmlname=frm.htmlname.value.replace(/^\s+|\s+$/g,"");
var name=frm.name.value.replace(/^\s+|\s+$/g,"");
var info=frm.info.value.replace(/^\s+|\s+$/g,"");
var reg= /^[A-Za-z0-9-_]+$/;
if (reg.test(htmlname)) {}
else{alert("不能含有中文或特殊符号");frm.htmlname.focus();return false;}
if(name==''){alert('请输入tag名称！');frm.name.focus();return false;}
else{frm.submit();}
}
</script>
<div id=navlist_left>
<div class="yj_green">
<b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b>
<div class="boxcontent">
<h2>修改tag</h2>
</div>
<div class="t1"><div class="t2">
<form id="frm" name="frm" method="post" action="?g=editsave">
<input type=hidden name=id value="<?=$id?>">
<p>tag名称<br><input type=text name=name value="<?=$name?>"></p><br>
<p>别名<br><input size=20 name=htmlname type=text value="<?=$htmlname?>">.html<br>它通常为小写并且只能包含字母，数字和连字符-</p><br>

<p>简介<br><textarea name="info" rows=5 cols=28><?=$info?></textarea><br>对tag做简单的描述</p>
</form>
<br><a id=abtn_yellow onclick="chksubmit()">确认提交</a><br><br>

</div></div>
<b class="b4b"></b><b class="b3b"></b><b class="b2b"></b><b class="b1b"></b></div>
</div>

<div id=navlist_right>
</div>
<?php 
}
?>




<?php 
function editsave(){
chkoutpost();
$id=$_POST['id'];
$name=trim($_POST['name']);
$htmlname=trim($_POST['htmlname']);
$fuid=0;
$info=$_POST['info'];

if($htmlname=='默认自动转为拼音'|$htmlname==''){$htmlname=pinyin($name);}

global $tabhead;
$tab=$tabhead."navs";

mysql_select_db($tab);
if($name!=$_SESSION['name']){
	$sql = mysql_query("select * from ".$tab." where name='".$name."'");
	if(!$sql){echo "<font color=red>(打开数据库时遇到错误!)</font>";return false;}
	$num=mysql_num_rows($sql);
	if(!$num==0){echo '<script>alert("tag名称 '.$name.' 已存在，请修改！");history.back();</script>';die();}
}
if($htmlname!=$_SESSION['htmlname']){
	$sql = mysql_query("select * from ".$tab." where htmlname='".$htmlname."'");
	if(!$sql){echo "<font color=red>(打开数据库时遇到错误!)</font>";return false;}
	$num=mysql_num_rows($sql);
	if(!$num==0){echo '<script>alert("tag别名 '.$htmlname.' 已存在，请修改！");history.back();</script>';die();}
}


$sql="UPDATE ".$tab." SET name='".$name."',htmlname='".$htmlname."',fuid='".$fuid."',info='".$info."' where id=".$id;

if(mysql_query($sql)){echo"<div id=ok>tag【".$name."】修改成功</div>";jump('?',1);}
else{echo"<div id=err>tag【".$name."】修改失败，请检查tag是否存在，请检查数据库！</div>";jump('?',1);}
 
}
?>





<?php 
function del(){
chkoutpost();
$id=$_GET['id'];

global $tabhead;
$tab=$tabhead."navs";

$sql="DELETE FROM ".$tab." WHERE id=".$id;
if(mysql_query($sql)){
echo"<div id=ok>tag删除成功</div>";jump('javascript:history.back()',1);
$tab=$tabhead."nav_art";
$sql="DELETE FROM ".$tab." WHERE navid=".$id;
mysql_query($sql);
}
else{echo"<div id=err>tag删除失败,请检查tag是否存在，请检查数据库！</div>";}

}
?>






<?php
mysql_close($con);
echo runtime();
?>
</body>
</html>