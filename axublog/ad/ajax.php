<?php 
require_once('all.php');
require_once('pinyin.php');
header("Content-type:text/html;charset=utf-8");
chkadcookie();
$g=$_GET["g"];
    switch ($g)
    {
case "savesessionnav":savesessionnav();break; 
case "js_getallnav":js_getallnav();break; 
case "js_unhidetag":js_unhidetag();break; 
case "js_hidetag":js_hidetag();break; 
case "js_addtags":js_addtags();break; 
case "js_chkaddart":js_chkaddart();break; 
case "js_htmlall":js_htmlall();break; 
case "js_loginpost":js_loginpost();break; 
case "clearcache":clearcache();break; 
case "savedraft":savedraft();break; 
case "delchooseart":delchooseart();break; 
case "gotopchooseart":gotopchooseart();break; 
case "untopchooseart":untopchooseart();break; 
    }

	
function untopchooseart(){
global $tabhead;
$tab=$tabhead."arts";
$ids=$_GET['ids'];
$a=explode(',',$ids);
$shu=count($a);
	for($i=0;$i<$shu-1;$i++){
$sql="UPDATE ".$tab." SET top='0'  where id=".$a[$i];
if(mysql_query($sql)){$chk=$chk.$a[$i].',';}
	}
echo '<div id=appmsg>'.$chk.'已取消置顶</div>';
}	
	
function gotopchooseart(){
global $tabhead;
$tab=$tabhead."arts";
$ids=$_GET['ids'];
$a=explode(',',$ids);
$shu=count($a);
	for($i=0;$i<$shu-1;$i++){
$sql="UPDATE ".$tab." SET top='yes'  where id=".$a[$i];
if(mysql_query($sql)){$chk=$chk.$a[$i].',';}
	}
echo '<div id=appmsg>'.$chk.'已置顶</div>';
}	

	
function delchooseart(){
global $tabhead;
$ids=$_GET['ids'];
$a=explode(',',$ids);
$shu=count($a);
	for($i=0;$i<$shu-1;$i++){
		$tab=$tabhead."arts";
		$sql="DELETE FROM ".$tab." WHERE id=".$a[$i];
		if(mysql_query($sql)){$chk=$chk.$a[$i].',';}
		$tab=$tabhead."nav_art";
		$sql="DELETE FROM ".$tab." WHERE artid=".$a[$i];
		if(mysql_query($sql)){}
	}
echo '<div id=appmsg>'.$chk.'已删除</div>';
}
	
function savedraft(){
$type='draft';
global $tabhead,$webname,$webinfo,$weburl,$webauthor,$themepath,$artpath,$tagpath,$title;
$title=$_POST['title'];
if(strlen($title)>70){$title=substr($title,0,70);}
$htmlname=$_POST['htmlname'];
$htmlname=htmlnameguolv($htmlname);
if($htmlname=='默认自动转为拼音'){$htmlname='';}
if($htmlname!=''){$htmlname=pinyin($title);}
$content=$_POST['content'];
#$content=gethttpimg($content);
$date=$_POST['date'];
$author=htmlnameguolv($_POST['author']);
$tags=$_POST['tags'];
$tags=htmlnameguolv($tags);
$title=addslashes($title);
$content=addslashes($content);
$htmlname=addslashes($htmlname);
$author=addslashes($author);
$tags=addslashes($tags);
$tab=$tabhead."arts";
if($_SESSION['jid']==''){
	$sql="INSERT INTO ".$tab." (id,author,title,content,htmlname,type,hit,cdate,edate,tags) VALUES (null,'".$author."','".$title."','".$content."','".$htmlname."','".$type."',1,'".$date."','".$date."','".$tags."')";
	if(mysql_query($sql)){$_SESSION['jid']=mysql_insert_id();$chk="保存草稿".$_SESSION['jid']."成功";}else{$chk="保存草稿失败";}
}
else{
	$sql2="UPDATE ".$tab." SET author='".$author."',title='".$title."',type='".$type."',content='".$content."',htmlname='".$htmlname."',edate='".$date."',tags='".$tags."' where id=".$_SESSION['jid'];
	if(mysql_query($sql2)){$chk="保存草稿".$_SESSION['jid']."成功";}else{$chk="保存草稿".$_SESSION['jid']."失败";}
}
delarttags($oldtags,$_SESSION['jid']);
addtags($tags,$_SESSION['jid']);

$jieguo='<div id=appmsg>'.$chk.'</div>';
$json_arr = array("jieguo"=>$jieguo,"id"=>$_SESSION['jid']);
$json_obj = json_encode($json_arr);
echo $json_obj;
}

function clearcache(){
	global $cachepath;
@deldir('../'.$cachepath);
 foreach ($_COOKIE as $key => $value) {
		setcookie($key,null);
		setcookie($key,null, time()+9999999,"/; HttpOnly" , "",'');
    }
echo '清除缓存成功!';
}
 
function js_chkaddart(){
$title=$_GET['t'];
$htmlname=$_GET['h'];
$htmlname=htmlnameguolv($htmlname);
if($htmlname=='默认自动转为拼音'|$htmlname==''){$htmlname=pinyin($title);}

global $tabhead;
$tab=$tabhead."arts";
mysql_select_db($tab);

$chk=" where htmlname='".$htmlname."' or title='".$title."'";
$sql = mysql_query("select * from ".$tab.$chk);
if(!$sql){echo "<center><br><font color=red>(数据库查询失败!)</font><br></center>";}
$num=mysql_num_rows($sql);
if($num!=0){echo"<center><br><font color=red>文章标题或别名已存在！</font><br></center>";return;}
    }
 
function js_addtags(){
$tags=htmlnameguolv($_GET['tags']);
if($tags!=''){addtags($tags,$id);}
}

function js_unhidetag(){
echo 'ssssss';
}

function js_hidetag(){
echo '';

}

function savesessionnav(){
$_SESSION['s_nav']=$_GET['q'];
echo $_SESSION['s_nav'];
}
 
    function js_getallnav(){
$a=getallnav();
$shu=count($a);

$navselect='';
$navselect2='';
$chk2='';
echo '选择分类:<select name=navid>';
for ($i=1; $i<=$shu; $i++)
{
$b=$a[$i-1];
$name=$b["name"];
$chk='';
$id=$b["id"];
if($i==$shu){$chk='selected';}
$navselect=$navselect.'<option value='.$id.' '.$chk.'>'.$name.'</option>';
}
echo $navselect.'</select>';
    }

function js_htmlall(){
$hall=$_GET["hall"];
if($hall=='yes'){$a=$_SESSION['allnav'];}

echo $div.'<p>生成页面成功，<a target=_blank href="" >查看》</a></p>';
}

function js_loginpost(){
@$g=$_GET["g"];
@$user=$_POST["user"];
@$psw=$_POST["psw"];
@$loginlong=$_POST["loginlong"];
if($user=="1"){$jieguo="<div id=bluemsg>登录成功！正在前往<a href=index.php >后台</a>。。。</div>";}else{$jieguo="<div id=redmsg>登录失败：账户或密码错误！</div>";}
$json_arr = array("jieguo"=>$jieguo);
$json_obj = json_encode($json_arr);
echo $json_obj;
}

mysql_close($con);
?>
