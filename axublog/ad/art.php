<?php 
require_once('all.php');
require_once('pinyin.php');
global $date;
#echo pinyin("榻榻米儿童房装修效果图");
#die();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>dobcms后台管理</title>
    <link rel="stylesheet" type="text/css" href="css/right.css"> 
		<script type="text/javascript" src="jquery-1.8.2.min.js"></script>
			<script>
	jQuery(function($){ 
//全选 
$("#chooseall").click(function(){ 
$("input[name='checkbox']").attr("checked","true"); 
}) 
//取消全选 
$("#unchooseall").click(function(){ 
$("input[name='checkbox']").removeAttr("checked"); 
}) 
//或许选择项的值 
$("#delchoose").click(function(){ 
var aa=""; 
$("input[name='checkbox']:checkbox:checked").each(function(){ aa=aa+$(this).val()+',' }) 
if(aa==''){alert("请选择要操作的文章！");}
else{if(confirm('确定删除选中项吗?')){htmlobj=$.ajax({url:"ajax.php?g=delchooseart&ids="+aa,async:false});$("#jieguo").html(htmlobj.responseText);location.href="?";}}
}) 
}) 


</script>
<?php
@$g=$_GET["g"];
if($g=='addart'|$g=='edit'){
?>
	<script src="jspost.js"></script> 
	<link rel="stylesheet" href="../ke4/themes/default/default.css" />
	<link rel="stylesheet" href="../ke4/plugins/code/prettify.css" />
	<script charset="utf-8" src="../ke4/kindeditor.js"></script>
	<script charset="utf-8" src="../ke4/lang/zh_CN.js"></script>
	<script charset="utf-8" src="../ke4/plugins/code/prettify.js"></script>
	<script>
var editor;
		KindEditor.ready(function(K) {
			editor = K.create('textarea[name="content"]', {
				cssPath : '../ke4/plugins/code/prettify.css',
				uploadJson : '../ke4/php/upload_json.php',
				fileManagerJson : '../ke4/php/file_manager_json.php',
				allowFileManager : true,
				afterCreate : function() {
					var self = this;
					K.ctrl(document, 13, function(){
					chk();
					});
					K.ctrl(self.edit.doc, 13, function() {
					chk();
});

				}
			});
			prettyPrint();
		});

	function chk(){
	addtag(document.getElementById('tags2').value);
	if(frm.title.value==''){alert("请填写文章标题！");frm.title.focus();return false;}
	else if(frm.title.value=='在此键入标题'){alert("请填写文章标题！");frm.title.focus();return false;}
	else if(editor.html()==''){alert("请填写文章内容！");editor.focus();return false;}
	else if(frm.tags.value==''){alert("请至少填写一个tag！");frm.tags2.focus();return false;}
	else if(frm.author.value==''){alert("请填写作者信息！");frm.author.focus();return false;}
	else{editor.sync();frm.submit();}	
					}
					
function savedraft(){
	if(editor.html()==''){document.getElementById("daojishi").innerText='请填写文章内容！'; editor.focus();return false;}
	if(frm.title.value=='在此键入标题'){frm.title.value='';}
	editor.sync();
var cont = $("input,select,textarea").serialize();
$.ajax({url:'ajax.php?g=savedraft',type:'post',dataType:'json',data:cont,success:function(data){var str = data.jieguo;$("#jieguo").html(str);}});
setTimeout('$("#jieguo").html("");',3000); 
}

var secs = 60; 
function daojishi() {
	for(var i=1;i<=secs;i++) {  window.setTimeout("update(" + i + ")", i * 1000);} 
}	

function update(num) { 
jishi=secs-num;
document.getElementById("daojishi").innerText=jishi+"秒后自动保存草稿";
    if(num == secs) {savedraft();document.getElementById("daojishi").innerText='已保存草稿';daojishi();} 
} 
daojishi();

	</script>
<?php
}
?>
</head>
<body> 
<?php
    switch ($g)
    {
    case "addart":addart();break; 
    case "addsave":addsave();break; 
    case "del":del();break; 
    case "edit":edit();break; 
    case "editsave":editsave();break; 
    case "delall":delall();break; 
    case "chkall":chkall();break; 
    default:artlist();break; 
    }	
?>


<?php 
function artlist(){
?>
<?php
global $tabhead;
$tab=$tabhead."arts";
#$nav="未分类";
#$chk=" where type='art'";
$chk="";
mysql_select_db($tab);
$sql = mysql_query("select * from ".$tab.$chk."");
$artshu=mysql_num_rows($sql);

$options = array(
	'total_rows' => $artshu, //总行数
	'list_rows'  => '10',  //每页显示量
);
$page = new page($options);
$sql =  mysql_query("select * from ".$tab.$chk." order by id desc limit $page->first_row , $page->list_rows");
?>
<div id=rightmenu>
<div id=rightmenu_top><ul><li><b>您的位置：文章列表 < <a href="right.php">后台首页</a></b></li></ul></div>
<ul>
<span id="jieguo"></span>

<div id=artlist>
<div id=id>id</div>
<div id=title>标题(文章【<?=$artshu?>】篇)</div>
<div id=tag>Tags标签</div>
<div id=author>作者</div>
<div id=thedate>日期</div>
</div>    
<?php
global $artpath;
if(!$sql){echo "<font color=red>(打开数据库时遇到错误!)</font>";return false;}
while($row=mysql_fetch_array($sql))
{
$p_id=$row['id'];
$p_type=$row['type'];
$p_author=$row['author'];
$p_title=mb_substr($row['title'],0,20,'utf-8');
$p_htmlname=$row['htmlname'];
$p_arturl=arttourl($p_htmlname);
$p_date=$row['cdate'];
$chkhn='';$showchkhn='';
if(!file_exists('../'.$artpath.$p_htmlname)){$chkhn='<font color=red>X</font>';$showchkhn='<font color=red>未</font>';}else{$chkhn='√';$showchkhn='已';}
$p_nav='';
$p_tag='';
$chktype='';
$a=artidgettagids($p_id);
$shu=count($a);
    for($i=1;$i<=$shu;$i++){
    $navid=$a[$i-1];
    $b=navidgetnav($navid);
    $navtype=$b['type'];
    $navname=$b['name'];
    if($navtype=='tag'){$p_tag=$p_tag.$navname.',';}
    if($navtype=='nav'){$p_nav=$navname;}
    }
if($p_type=='draft'){$chktype="[草稿] ";$p_tag=$row['tags'];}
echo <<<EOF
        <div id=artlist>
          <div id=id><input type="checkbox" name="checkbox" value='{$p_id}'>{$p_id}<a href='?g=edit&id={$p_id}'>编辑</a>|<a onclick="if(confirm('确定删除吗?')){location.href='?g=del&id={$p_id}';}">删除</a>|<a href='html.php?g=haart&p={$p_htmlname}'>{$showchkhn}生成{$chkhn}</a>|<a href='{$p_arturl}' target=_blank>查看</a></div>
          <div id=title>{$chktype}{$p_title}</div>
          <div id=tag>{$p_tag}</div>          
          <div id=author>{$p_author}</div>
          <div id=thedate>{$p_date}</div>
        </div>
EOF;
}
?>

<div id=page>
     <?=$page->show(1)?>
</div>
<br>
<span id="artlist_btn">
<a  id=chooseall  >全选</a>
<a  id=unchooseall  >取消全选</a>
<a  id=delchoose  onclick="delchoose()">删除</a>
<a  id=btn_blue  onclick="location.href='art.php?g=addart';">发布文章</a>
<a  id=btn_yellow onclick="if(confirm('确定删除所有吗?')){location.href='?g=delall';}">删除所有</a>
<a  id=btn_blue href="?g=chkall">修复错误</a>
</span>
<br><br>

</ul></div>
</body></html>
<?php 
}
?>


<?php 
function addart(){
$_SESSION['jdate']='';$_SESSION['jid']='';
global $webauthor,$date;
global $tabhead;
@$title=$_GET['title'];
@$content=$_GET['content'];
?>
<?php script()?>
<div id=rightmenu>
<div id=rightmenu_top><ul><li><b>您的位置：发布文章 < <a href="art.php">文章列表</a> < <a href="right.php">后台首页</a></b></li></ul></div>
<ul>
<span id="jieguo"></span>
<div id=addart_left>
<form id="frm" name="frm" method="post" action="?g=addsave" onSubmit="return false;" >
<?php
if($title==''){$title='在此键入标题';}
?>
<p><input  style="width:400px"  type=text name=title id=title_txt value="<?=$title?>" onfocus="if(this.value=='在此键入标题'){this.value=''}" onblur="if(this.value==''){this.value='在此键入标题'}">文章标题，严禁特殊符号</p>
<p><input  style="width:400px"  name=htmlname type=text value="默认自动转为拼音" onfocus="if(this.value=='默认自动转为拼音'){this.value=''}" onblur="if(this.value==''){this.value='默认自动转为拼音'}">html别名，静态目录，严禁特殊符号</p>
<p><textarea id="content" name="content" style="width:670px;height:380px;visibility:hidden;"><?=$content?></textarea></p>
</div>
<!------------left---------------->

<div id=addart_right>
<input type=hidden size=20 name=oldtags id=oldtags type=text value="<?=$tags?>" >
<input  type=hidden size=20 name=tags id=tags type=text value="<?=$tags?>" >
 <div>已加入tags：<div id=js_showtags><?=@$p_tag?></div></div>
<input size=18 name=tags2 id=tags2 type=text >
  <a id=btn_green onclick="addtag(document.getElementById('tags2').value);">添加</a><br>
 多个标签请用英文逗号,分开<br>
<p><a onclick="showhidediv('hidetagsdiv')">[从常用标签中选择：]</a></p>
<p id=hidetagsdiv>
<?php
$a=getalltag();
$shu=count($a);
for($i=1;$i<=$shu;$i++){
$b=$a[$i-1];
$id=$b['id'];
$name=$b['name'];
echo '<a title="加入此标签" onclick="addtag(\''.$name.'\');">'.$name.'</a>  ';
}
?>
</p>
<p>日期：<?=$date?><input size=20 name=date type=hidden value="<?=$date?>" ></p>
<p>作者：<input size=12 name=author type=text value="<?=$webauthor?>" ></p>
<div id=addart_left_savebtn><a onclick="chk()">发布文章 快捷键:Ctrl+Enter</a>
<hr><a id=daojishi onclick="savedraft()">保存草稿</a></div>

</div>
</form>
<!------------right---------------->
</ul></div></body></html>
<?php 
}
?>


<?php 
function addsave(){
global $tabhead,$webname,$webinfo,$weburl,$webauthor,$themepath,$artpath,$tagpath,$title;
$title=$_POST['title'];if($title==''){$title=$_SESSION['title'];}
if(strlen($title)>70){$title=substr($title,0,70);}

$htmlname=$_POST['htmlname'];if($htmlname==''){$htmlname=$_SESSION['htmlname'];}
$htmlname=htmlnameguolv($htmlname);
if($htmlname=='默认自动转为拼音'|$htmlname==''){$htmlname=pinyin($title);}
$content=$_POST['content'];if($content==''){$content=$_SESSION['content'];}
#$content=gethttpimg($content);

$date=$_POST['date'];if($date==''){$date=$_SESSION['date'];}
$author=htmlnameguolv($_POST['author']);if($author==''){$author=$_SESSION['author'];}


$tags=$_POST['tags'];if($tags==''){$tags=$_SESSION['tags'];}
$tags=htmlnameguolv($tags);

$title=addslashes($title);
$content=addslashes($content);
$htmlname=addslashes($htmlname);
$author=addslashes($author);
$tags=addslashes($tags);

#$content=httptomyurl($content);

if(strlen($content)<5){die('内容为空');}
if($title==''){die('标题为空');}

$tab=$tabhead."arts";
mysql_select_db($tab);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>后台管理</title>
    <link rel="stylesheet" type="text/css" href="css/right.css">
  </head>
  <body> 
<div id=rightmenu>
<div id=rightmenu_top><ul><li><b>您的位置：发布文章 < <a href="art.php">文章列表</a> < <a href="right.php">后台首页</a></b></li></ul></div>
<ul>

<?
$chk=" where htmlname='".$htmlname."'";
$sql = mysql_query("select * from ".$tab.$chk);
if(!$sql){echo "(数据库查询失败!)<br>";}
$num=mysql_num_rows($sql);
    if($num==0){
$sql="INSERT INTO ".$tab." (id,author,title,content,htmlname,type,hit,cdate,edate) VALUES (null,'".$author."','".$title."','".$content."','".$htmlname."','art',1,'".$date."','".$date."')";
if(mysql_query($sql)){echo"发布文章成功<br>";
}

else{echo"发布文章 [".$title."] <font color=red>失败1</font><br>".$sql;return;}
$artid = mysql_insert_id();
addtags($tags,$artid);
echo'<iframe src="html.php?g=haart&p='.$htmlname.'" scrolling="no" frameborder="0" height="300" width="600"></iframe>';
    }
    else{echo'html别名已存在！';}
?>
</ul></div></body></html>
<?php 
}
?>




<?php 
function edit(){
$id=$_GET['id'];
if($id==''){echo"<div id=err>文章id为空，请检查！</div>";jump('?',1);}

$a=artidgetart($id);
$author=$a['author'];
$title=$a['title'];
$content=$a['content'];
$content=stripslashes($content);
$htmlname=$a['htmlname'];
$type=$a['type'];
$edate=$a['edate'];
@$tags2=$a['tags'];
global $date;
$edate=$date;
$tags='';
$p_tag='';
$artnavid='';
$a=artidgettagids($id);
$shu=count($a);
    for($i=1;$i<=$shu;$i++){
    $navid=$a[$i-1];
    $b=navidgetnav($navid);
    $navname=$b['name'];
$p_tag=$p_tag.' <li id="tag_'.$navname.'" ><a href="#" onclick="hidetag(\''.$navname.'\');" >'.$navname.'</a></li>';$tags=$tags.$navname.',';
    }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>后台管理</title>
    <link rel="stylesheet" type="text/css" href="css/right.css">
<?php script()?>
  </head>
  <body> 
<div id=rightmenu>
<div id=rightmenu_top><ul><li><b>您的位置：修改文章<?=$id?> < <a href="art.php">文章列表</a> < <a href="right.php">后台首页</a></b></li></ul></div>
<ul>

<div id=addart_left>

<form id="frm" name="frm" method="post" action="?g=editsave" >
<input name=id type=hidden value="<?=$id?>" >
<p><input  style="width:400px" type=text name=title value="<?=$title?>" >文章标题，严禁特殊符号</p>
<p><input  style="width:400px"  name=htmlname type=text value="<?=$htmlname?>" >html别名，静态目录，严禁特殊符号</p>
<p><textarea id="content" name="content" style="width:670px;height:380px;visibility:hidden;"><?=htmlspecialchars($content);?></textarea></p>
</div>
<!------------left---------------->

<div id=addart_right>
<input type=hidden size=20 name=oldtags id=oldtags type=text value="<?=$tags?>" >
<input  type=hidden size=20 name=tags id=tags type=text value="<?=$tags?>" >
 <div>已选tags：<div id=js_showtags><?=$p_tag?></div></div>
<input size=18 name=tags2 id=tags2 type=text value="<?=$tags?>" > 
<script>addtag('<?=$tags?>');</script>
<a id=btn_green onclick="addtag(document.getElementById('tags2').value);">添加</a><br>
 多个标签请用英文逗号,分开 <br>
<p><a onclick="showhidediv('hidetagsdiv')">[从常用标签中选择]</a></p>
<p id=hidetagsdiv>
<?php
$a=getalltag();
$shu=count($a);
for($i=1;$i<=$shu;$i++){
$b=$a[$i-1];
$id=$b['id'];
$name=$b['name'];
echo '<a onclick="addtag(\''.$name.'\');">'.$name.'</a>  ';
}
?>
</p>
<p>日期：<?=$edate?><input size=20 name=date type=hidden value="<?=$edate?>" ></p>
<p>作者：<input size=12 name=author type=text value="<?=$author?>" ></p>
<div id=addart_left_savebtn><a onclick="chk()">发布文章 快捷键:Ctrl+Enter</a></div>
</form>
</div>
<!--------------------------->

</ul></div></body></html>
<?php 
}
?>


<?php 
function editsave(){
chkoutpost();
global $tabhead,$webname,$webinfo,$weburl,$webauthor,$themepath,$artpath,$tagpath,$title;
$id=$_POST['id'];
$title=$_POST['title'];
$htmlname=htmlnameguolv($_POST['htmlname']);
if($htmlname=='默认自动转为拼音'|$htmlname==''){$htmlname=pinyin($title);}
$content=$_POST['content'];
#$content=gethttpimg($content);

$edate=$_POST['date'];
$author=htmlnameguolv($_POST['author']);
$tags=htmlnameguolv($_POST['tags']);
$oldtags=htmlnameguolv($_POST['oldtags']);

$title=addslashes($title);
$content=addslashes($content);
$htmlname=addslashes($htmlname);
$author=addslashes($author);
$tags=addslashes($tags);

#$content=httptomyurl($content);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>后台管理</title>
    <link rel="stylesheet" type="text/css" href="css/right.css">
<?php script()?>
  </head>
  <body> 
<div id=rightmenu>
<div id=rightmenu_top><ul><li><b>您的位置：修改文章<?=$id?> < <a href="art.php">文章列表</a> < <a href="right.php">后台首页</a></b></li></ul></div>
<ul>
<?
delarttags($oldtags,$id);
addtags($tags,$id);

$tab=$tabhead."arts";
mysql_select_db($tab);
$sql="UPDATE ".$tab." SET author='".$author."',title='".$title."',type='art',content='".$content."',htmlname='".$htmlname."',edate='".$edate."' where id=".$id;
if(mysql_query($sql)){echo"文章修改成功<br>";
echo'<iframe src="html.php?g=haart&p='.$htmlname.'" scrolling="no" frameborder="0" height="300" width="600"></iframe>';
}

else{echo"修改文章<font color=red>失败</font><br>";return;}
?>
</ul></div></body></html>
<?php 
}
?>


<?php
function script(){
echo <<<EOF
<script>
function showhidediv(id){
var sbtitle=document.getElementById(id);
if(sbtitle){
   if(sbtitle.style.display=='block'){
   sbtitle.style.display='none';
   }else{
   sbtitle.style.display='block';
   }
}
}

function choosenavs(str,str2){
if(document.getElementById("nav"+str).checked==true){frm.navs.value=frm.navs.value.replace("["+str+"]","");frm.navs.value=frm.navs.value+"["+str+"]";jspost('ajax.php?g=savesessionnav&q='+str2,'showjspost');}
else{frm.navs.value=frm.navs.value.replace("["+str+"]","");jspost('ajax.php?g=savesessionnav&q=','showjspost');}
}


function chksubmit(){
	addtag(document.getElementById('tags2').value);
	if(frm.title.value==''){alert("请填写文章标题！");frm.title.focus();return false;}
	else if(frm.title.value=='在此键入标题'){alert("请填写文章标题！");frm.title.focus();return false;}
	else if(editor.html()==''){alert("请填写文章内容！");return false;}
	else if(frm.tags.value==''){alert("请至少填写一个tag！");frm.tags.focus();return false;}
	else if(frm.author.value==''){alert("请填写作者信息！");frm.author.focus();return false;}
else{self.sync();frm.submit();}
}

function addnewnav(){
if(addnav.name.value==''){alert("请填写分类名称！");addnav.name.focus();return false;}
jspost('navs.php?g=addsave&name='+addnav.name.value+'&htmlname='+addnav.htmlname.value+'&fuid='+addnav.fuid.value,'showaddnav');
jspost('ajax.php?g=js_getallnav','js_getallnav');
}

function chkhideaddnav2(){
  aa=document.getElementById('addart_hideaddnav2')
if(aa.style.display =="inline"){aa.style.display="none";}
else{aa.style.display="inline";}
}

function hidetag(str){
if(str==''){return;}
var strs= new Array(); //定义一数组
strs=document.getElementById('tags').value.split(","); //字符分割   

instr='';   
instr2='';

for (i=0;i<strs.length-1;i++ )    
    {    
    if(strs[i]!=str){instr=instr+'<li id="tag_'+strs[i]+'" ><a href="#" onclick="hidetag(\''+strs[i]+'\');" >'+strs[i]+'</a></li>';instr2=instr2+strs[i]+',';}
    }
if(strs.length-1==1){instr='';instr2='';}

    js_showtags.innerHTML=instr;
    document.getElementById('tags').value=instr2;
}

function addtag(str){
if(str==''){return;}
str=str+',';
str=str.replace("，，",",");
str=str.replace("，",",");
str=str.replace(",,",",");

document.getElementById('tags2').value='';
var strs= new Array(); //定义一数组
strs=str.split(","); //字符分割      
for (i=0;i<strs.length-1;i++ )    
    {
str=','+document.getElementById('tags').value;
if(str.replace(','+strs[i],'')==','+document.getElementById('tags').value){
js_showtags.innerHTML = js_showtags.innerHTML.replace('<li id="tag_'+strs[i]+'" ><a href="#" onclick="hidetag(\''+strs[i]+'\');" >'+strs[i]+'</a></li>','');
js_showtags.innerHTML = js_showtags.innerHTML+'<li id="tag_'+strs[i]+'" ><a href="#" onclick="hidetag(\''+strs[i]+'\');" >'+strs[i]+'</a></li>';
document.getElementById('tags').value=document.getElementById('tags').value.replace()+strs[i]+',';}
    } 
}

</script>
EOF;
}
?>


<?php 
function del(){
chkoutpost();
$id=$_GET['id'];

global $tabhead;
$tab=$tabhead."arts";

$sql="DELETE FROM ".$tab." WHERE id=".$id;
if(mysql_query($sql)){echo"<div id=ok>文章删除成功</div>";}
else{echo"<div id=err>文章删除失败,请检查分类是否存在，请检查数据库！</div>";jump('javascript:history.back()',1);}

global $tabhead;
$tab=$tabhead."nav_art";
$sql="DELETE FROM ".$tab." WHERE artid=".$id;
if(mysql_query($sql)){echo"<div id=ok>后续处理成功</div>";jump('javascript:history.back()',1);}
else{echo"<div id=err>文章删除失败,请检查数据库！</div>";jump('javascript:history.back()',1);}
}
?>


<?php 
function delall(){
chkoutpost();
global $tabhead;
$tab=$tabhead."arts";
$sql="DELETE FROM ".$tab." WHERE id>0";
if(mysql_query($sql)){echo"<div id=ok>文章删除成功</div>";jump('javascript:history.back()',1);}
else{echo"<div id=err>文章删除失败,请检查数据库！</div>";jump('javascript:history.back()',1);}

global $tabhead;
$tab=$tabhead."nav_art";
$sql="DELETE FROM ".$tab." WHERE artid>0";
if(mysql_query($sql)){echo"<div id=ok>后续处理成功</div>";jump('javascript:history.back()',1);}
else{echo"<div id=err>文章删除失败,请检查数据库！</div>";jump('javascript:history.back()',1);}
}
?>


<?php 
function chkall(){
chkoutpost();

global $tabhead;
$tab=$tabhead."arts";
mysql_select_db($tab);
$sql = "ALTER TABLE ".$tab." ADD tags varchar(100) NOT NULL";
if (mysql_query($sql)){echo "添加tags字段成功<br>";}
else{echo "<font color=red>添加tags字段失败</font><br>";}


$sql = mysql_query("select * from ".$tab." ");
if(!$sql){echo "<font color=red>(getallart打开数据库时遇到错误!)</font>";return false;}
while($row=mysql_fetch_array($sql))
{
$artids=$artids.'['.$row['id'].']';
}
echo $artids.'<br>';

$tab=$tabhead."nav_art";
$sql = mysql_query("select * from ".$tab." ");
    if(!$sql){echo "<div id=err>(chkall打开数据库时遇到错误!)</div>";return ;}
    while($row=mysql_fetch_array($sql))
    {
        $artid2=$row['artid'];
    $artid='['.$artid2.']';
   if(str_replace($artid,'',$artids)==$artids){$artids2=str_replace($artid2.',','',$artids2).$artid2.',';}
    }

echo $artids2.'<br>';
$a=explode(',',$artids2);
$shu=count($a)-1;
echo '需要处理：'.$shu.'个<br>';
for($i=1;$i<=$shu;$i++){
$sql="DELETE FROM ".$tab." WHERE artid=".$a[$i-1];
if(mysql_query($sql)){echo"<div id=ok>后续处理成功</div>";}
else{echo"<div id=err>后续处理失败,请检查数据库！</div>";}

}

}
?>


<?php
mysql_close($con);
echo runtime();
?>
