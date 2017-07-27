<?php

function gettodayart(){
global $tabhead;
$tab=$tabhead."arts";
mysql_select_db($tab);
$sql = mysql_query("select * from ".$tab." where edate like '%".date('Y-m-d')."%'");
if(!$sql){echo "<font color=red>(gettodayart打开数据库时遇到错误!)</font>";return false;}
$b=array();
while($row=mysql_fetch_array($sql))
{
$a=array("id"=>$row['id'],"author"=>$row['author'],"title"=>$row['title'],"content"=>$row['content'], "htmlname"=>$row['htmlname'],"type"=>$row['type'],"edate"=>$row['edate'],"hit"=>$row['hit']);
array_push($b,$a);
}
	if(count($b)==0){echo '<p id=err>今日无更新</p>';exit;}
return $b;
}


function upart($p_id){
global $tabhead;
$tab=$tabhead."arts";
$chk=" where id<".$p_id." order by id desc limit 0,1";
mysql_select_db($tab);
$sql = mysql_query("select * from ".$tab.$chk." ");
if(!$sql){echo "<font color=red>(artidgetart打开数据库时遇到错误!)</font>";return false;}
while($row=mysql_fetch_array($sql))
{
$atitle=$row["title"];
$aurl=arttourl($row["htmlname"]);
}
if($atitle==''){$atitle='暂无上一篇文章';}
if($aurl==''){$aurl='#';}
$str='<a title="上一篇文章:'.$atitle.'" href="'.$aurl.'">'.$atitle.'</a>';
return $str;
}
#上一篇文章

function nextart($p_id){
global $tabhead;
$tab=$tabhead."arts";
$chk=" where id>".$p_id." order by id limit 0,1";
mysql_select_db($tab);
$sql = mysql_query("select * from ".$tab.$chk." ");
if(!$sql){echo "<font color=red>(artidgetart打开数据库时遇到错误!)</font>";return false;}
while($row=mysql_fetch_array($sql))
{
$atitle=$row["title"];
$aurl=arttourl($row["htmlname"]);
}
if($atitle==''){$atitle='暂无下一篇文章';}
if($aurl==''){$aurl='#';}
$str='<a title="下一篇文章:'.$atitle.'" href="'.$aurl.'">'.$atitle.'</a>';
return $str;
}
#下一篇文章



function getalltag(){
global $tabhead;
$tab=$tabhead."navs";
$chk="";
mysql_select_db($tab);

$sql = mysql_query("select * from ".$tab.$chk." order by id desc");
if(!$sql){echo "<font color=red>(getallnav打开数据库时遇到错误!)</font>";return false;}
#$_COOKIE['tagshu']= mysql_num_rows($sql);
setcookie("tagshu",mysql_num_rows($sql), time()+8640000);
$b=array();
while($row=mysql_fetch_array($sql))
{
$a=array("id"=>$row['id'],"name"=>$row['name'],"htmlname"=>$row['htmlname'],"type"=>$row['type'],"info"=>$row['info']);
array_push($b,$a);
}
return $b;
}
#得到所有tag

function showalltag(){
global $weburl;
global $tagpath;
$a=getalltag();
$shu=count($a);
for($i=1;$i<=$shu;$i++){
$b=$a[$i-1];
$id=$b['id'];
$name=$b['name'];
$htmlname=$b['htmlname'];
$info=$b['info'];
$url=tagtourl($htmlname);
$atagshu=navidgetartids($id);
$tagshu=count($atagshu);
@$str=$str.'<li><a title="'.$info.' 文章【'.$tagshu.'】篇" href="'.$url.'" >'.$name.'</a></li>';
}
return @$str;
}
#显示所有tag

function suiji7(){
$s1=rand(1,7);
if($s1==1){return" id=green ";}
elseif($s1==2){return" id=blue ";}
elseif($s1==3){return" id=orange ";}
elseif($s1==4){return" id=red ";}
elseif($s1==5){return" id=purple ";}
elseif($s1==6){return" id=yellow ";}
else{return" id=gray ";}
}

function showhottag(){
global $weburl;
global $tagpath;
$a=getalltag();
$shu=count($a);
for($i=1;$i<=$shu;$i++){
$b=$a[$i-1];
$id=$b['id'];
$name=$b['name'];
$htmlname=$b['htmlname'];
$info=$b['info'];
$url=tagtourl($htmlname);
$atagshu=navidgetartids($id);
$tagshu=count($atagshu);
$sj=suiji7();
if($tagshu>3){@$str=$str.'<li '.$sj.'><a title="'.$info.' " href="'.$url.'" >'.$name.' ['.$tagshu.']</a></li>';}
if(@$i<3){@$str2=$str2.'<li '.$sj.'><a title="'.$info.' " href="'.$url.'" >'.$name.' ['.$tagshu.']</a></li>';}
}
if(@$str==''){@$str=$str2;}
return $str;
}
#显示热门tag

function showallnav(){
global $weburl;
global $tagpath;
$a=getallnav();
$shu=count($a);
for($i=1;$i<=$shu;$i++){
$b=$a[$i-1];
$id=$b['id'];
$name=$b['name'];
$htmlname=$b['htmlname'];
$info=$b['info'];
$url=tagtourl($htmlname);
$atagshu=navidgetartids($id);
$tagshu=count($atagshu);
$str=$str.'<li><a title="'.$info.' 文章【'.$tagshu.'】篇" href="'.$url.'" >'.$name.'</a></li>';
}
return $str;
}
#得到所有分类

function topmenu(){
global $weburl;
global $tagpath;
$a=getallnav();
$shu=count($a);
for($i=1;$i<=$shu;$i++){
$b=$a[$i-1];
$id=$b['id'];
$name=$b['name'];
$htmlname=$b['htmlname'];
$info=$b['info'];
$url=tagtourl($htmlname);
$atagshu=navidgetartids($id);
$tagshu=count($atagshu);
$str=$str.'<li><a title="'.$info.' 文章【'.$tagshu.'】篇" href="'.$url.'" >'.$name.'</a></li>';
}
return @$str;
}
#头部菜单

function tagtourl($str){
global $weburl;
global $tagpath;
$url=$weburl.$tagpath.$str.'/';
return $url;
}

function arttourl($str){
global $weburl;
global $artpath;
$url=$weburl.$artpath.$str.'/';
return $url;
}


function addtags($tags,$artid){
if($tags==''){}
else{
$tags=str_replace('，',',',$tags);
$tags=str_replace(' ','',$tags);
    $a = split ('[,.-]', $tags);
    for($i=1;$i<=count($a);$i++){
    $nav=$a[$i-1];
    if(!$nav==''){addtags2($nav,$artid);}
    }
    }
}

function addtags2($navname,$artid){
global $tabhead,$weburl;
$name=trim($navname);
$htmlname=pinyin($navname);
$tab=$tabhead."navs";
$chk=" where name='".$navname."'";
mysql_select_db($tab);
$sql = mysql_query("select * from ".$tab.$chk." ");
    if($sql){$row=mysql_fetch_array($sql);$navid=$row['id'];}
    else{echo "<div id=err>(addtags2-1打开数据库时遇到错误!)</div>";return ;}
$shu=mysql_num_rows($sql);
    if($shu==0){
    $sql="INSERT INTO ".$tab." (id,name,htmlname,info,type,fuid) VALUES (null,'".$name."','".$htmlname."','','tag','0')";
    if(mysql_query($sql)){$navid = mysql_insert_id();}
    else{echo"<div id=err>添加tag失败</div>";return;}
    }
$tab=$tabhead."nav_art";
mysql_select_db($tab);
$sql=mysql_query("select * from ".$tab." where navid='".$navid."' and artid='".$artid."' ");
    if(!$sql){echo"<div id=err>(addtags2-2打开数据库时遇到错误!)</div>";return;}
    $shu=mysql_num_rows($sql);
    if($shu==0){
    $sql="INSERT INTO ".$tab." (navid,artid) VALUES ('".$navid."','".$artid."')";
        if(!mysql_query($sql)){echo"<div id=err>(addtags2-3打开数据库时遇到错误!)</div>";return;}
        else{echo '<iframe src="'.$weburl.'tags.php?t='.$htmlname.'&update=yes" width=0 height=0 frameborder=0></iframe><iframe src="'.$weburl.'tags.php?update=yes" width=0 height=0 frameborder=0></iframe>';}
    }
}


function artidgettagids($str){
global $tabhead;
$tab=$tabhead."nav_art";
$chk=" where artid='".$str."'";
mysql_select_db($tab);
$sql = mysql_query("select * from ".$tab.$chk." ");
    if(!$sql){echo "<div id=err>(artidgettagids打开数据库时遇到错误!)</div>";return ;}
        $a2=array();
    while($row=mysql_fetch_array($sql))
    {
    array_push($a2,$row['navid']);
    }
return $a2;
}


function navidgetnav($navid){
global $tabhead;
$tab=$tabhead."navs";
$chk=" where id=".$navid." ";
mysql_select_db($tab);

$sql = mysql_query("select * from ".$tab.$chk." ");
if(!$sql){echo "<font color=red>(navidgetnav打开数据库时遇到错误!)</font>";return false;}

while($row=mysql_fetch_array($sql))
{
$a=array("name"=>$row['name'], "htmlname"=>$row['htmlname'],"type"=>$row['type'],"info"=>$row['info']);
}

return $a;
}



function taghtmlnamegettag($str){
global $tabhead;
$tab=$tabhead."navs";
$chk=" where htmlname='".$str."' ";
mysql_select_db($tab);
$sql = mysql_query("select * from ".$tab.$chk." ");
if(!$sql){echo "<font color=red>(taghtmlnamegettag打开数据库时遇到错误!)</font>";return false;}
while($row=mysql_fetch_array($sql))
{
$a=array("id"=>$row['id'],"name"=>$row['name'],"type"=>$row['type'],"info"=>$row['info']);
}
return $a;
}


function getallnav(){
global $tabhead;
$tab=$tabhead."navs";
$chk=" where type='nav' ";
mysql_select_db($tab);

$sql = mysql_query("select * from ".$tab.$chk." ");
if(!$sql){echo "<font color=red>(getallnav打开数据库时遇到错误!)</font>";return false;}
$b=array();
while($row=mysql_fetch_array($sql))
{
$a=array("id"=>$row['id'],"name"=>$row['name'],"htmlname"=>$row['htmlname'],"type"=>$row['type'],"info"=>$row['info']);
array_push($b,$a);
}
return $b;
}


function getallart(){
global $tabhead;
$tab=$tabhead."arts";
mysql_select_db($tab);

$sql = mysql_query("select * from ".$tab." ");
if(!$sql){echo "<font color=red>(getallart打开数据库时遇到错误!)</font>";return false;}
#$_COOKIE['artshu']= mysql_num_rows($sql);
setcookie("artshu",mysql_num_rows($sql), time()+8640000,"/; HttpOnly" , "",'');
$b=array();
while($row=mysql_fetch_array($sql))
{
$a=array("id"=>$row['id'],"author"=>$row['author'],"title"=>$row['title'],"content"=>$row['content'], "htmlname"=>$row['htmlname'],"type"=>$row['type'],"edate"=>$row['edate'],"hit"=>$row['hit']);
array_push($b,$a);
}
return $b;
}


function getallartbydate(){
global $tabhead;
$tab=$tabhead."arts";
mysql_select_db($tab);

$sql = mysql_query("select * from ".$tab." order by edate desc");
if(!$sql){echo "<font color=red>(getallartbydate打开数据库时遇到错误!)</font>";return false;}
$b=array();
while($row=mysql_fetch_array($sql))
{
$a=array("id"=>$row['id'],"author"=>$row['author'],"title"=>$row['title'],"content"=>$row['content'], "htmlname"=>$row['htmlname'],"type"=>$row['type'],"edate"=>$row['edate'],"hit"=>$row['hit']);
array_push($b,$a);
}
return $b;
}


function get15artbydate(){
global $tabhead;
$tab=$tabhead."arts";
mysql_select_db($tab);

$sql = mysql_query("select * from ".$tab." order by edate desc limit 0,15");
if(!$sql){echo "<font color=red>(get15artbydate打开数据库时遇到错误!)</font>";return false;}
$b=array();
while($row=mysql_fetch_array($sql))
{
$a=array("id"=>$row['id'],"author"=>$row['author'],"title"=>$row['title'],"content"=>$row['content'], "htmlname"=>$row['htmlname'],"type"=>$row['type'],"edate"=>$row['edate'],"hit"=>$row['hit']);
array_push($b,$a);
}
return $b;
}



function gethotart(){
global $tabhead;
$tab=$tabhead."arts";
mysql_select_db($tab);

$sql = mysql_query("select * from ".$tab." order by hit desc limit 0,10");
if(!$sql){echo "<font color=red>(gethotart打开数据库时遇到错误!)</font>";return false;}
		while($row=mysql_fetch_array($sql))
		{
			$p_title=$row['title'];
			$p_arturl=arttourl($row['htmlname']);
			$p_hit=$row['hit'];
				$p_date=$row['edate'];
			echo'<li><a target=_blank href="'.$p_arturl.'" 日期：'.$p_date.'">'.$p_title.'</a></li><div id=line></div>';
		}
}


function showhotart(){
global $tabhead;
$tab=$tabhead."arts";
mysql_select_db($tab);
$str="";
$sql = mysql_query("select * from ".$tab." order by hit desc limit 0,10");
if(!$sql){echo "<font color=red>(gethotart打开数据库时遇到错误!)</font>";return false;}
		while($row=mysql_fetch_array($sql))
		{
			$p_title=$row['title'];
			$p_arturl=arttourl($row['htmlname']);
			$p_hit=$row['hit'];
				$p_date=$row['edate'];
			$str=$str.'<p><a target=_blank href="'.$p_arturl.'" title=" 日期：'.$p_date.'">'.$p_title.'</a></p>';
		}
return $str;
}
#显示所有tag


function getnewart(){
global $tabhead;
$tab=$tabhead."arts";
mysql_select_db($tab);

$sql = mysql_query("select * from ".$tab." order by edate desc limit 0,10");
if(!$sql){echo "<font color=red>(getnewart打开数据库时遇到错误!)</font>";return false;}
		while($row=mysql_fetch_array($sql))
		{
			$p_title=$row['title'];
			$p_arturl=arttourl($row['htmlname']);
			$p_hit=$row['hit'];
				$p_date=$row['edate'];
			echo'<li><a target=_blank href="'.$p_arturl.'" title=" 日期：'.$p_date.'">'.$p_title.'</a></li><div id=line></div>';
		}
}





function getrelatedart($p_id){
$a=artidgettagids($p_id);
$shu=count($a);
if($shu<1){return;}
$p_tagid=$a[0];
$arr=navidgetartids($p_tagid);
$artshu=count($arr);
    if($artshu<2){return;}
    else if($artshu>10){$artshu=10;}
		for($i=1;$i<=$artshu;$i++){
		$p_id=$arr[$i-1];
		$a=artidgetart($p_id);
		$p_title=$a['title'];
		$p_arturl=arttourl($a['htmlname']);
		$p_date=$a['edate'];
		$p_hit=$a['hit'];
		echo'<p><a target=_blank href="'.$p_arturl.'" title=" 日期：'.$p_date.'">'.$p_title.'</a></p><div id=line></div>';
		}
}
#相关文章



function randomart(){
global $tabhead;
$tab=$tabhead."arts";
mysql_select_db($tab);

$sql = mysql_query("select * from ".$tab." order by rand() limit 0,10");
if(!$sql){echo "<font color=red>(randomart打开数据库时遇到错误!)</font>";return false;}
		while($row=mysql_fetch_array($sql))
		{
			$p_title=$row['title'];
			$p_arturl=arttourl($row['htmlname']);
			$p_hit=$row['hit'];
				$p_date=$row['edate'];
			echo'<li><a target=_blank href="'.$p_arturl.'" title=" 日期：'.$p_date.'">'.$p_title.'</a></li><div id=line></div>';
		}
}
#随机文章


function showrandomart(){
global $tabhead;
$tab=$tabhead."arts";
mysql_select_db($tab);
$str="";
$sql = mysql_query("select * from ".$tab." order by rand() limit 0,10");
if(!$sql){echo "<font color=red>(gethotart打开数据库时遇到错误!)</font>";return false;}
		while($row=mysql_fetch_array($sql))
		{
			$p_title=$row['title'];
			$p_arturl=arttourl($row['htmlname']);
			$p_hit=$row['hit'];
				$p_date=$row['edate'];
			$str=$str.'<p><a target=_blank href="'.$p_arturl.'" title=" 日期：'.$p_date.'">'.$p_title.'</a></p>';
		}
return $str;
}
#显示随机文章



function artidgetart($artid){
global $tabhead;
$tab=$tabhead."arts";
$chk=" where id=".$artid." ";
mysql_select_db($tab);
$sql = mysql_query("select * from ".$tab.$chk." ");
if(!$sql){echo "<font color=red>(artidgetart打开数据库时遇到错误!)</font>";return false;}
while($row=mysql_fetch_array($sql))
{
@$a=array("author"=>$row['author'],"title"=>$row['title'],"content"=>stripslashes($row['content']), "htmlname"=>$row['htmlname'],"type"=>$row['type'],"edate"=>$row['edate'],"hit"=>$row['hit'],"tags"=>$row['tags']);
}
return @$a;
}


function arturlgetart($str){
global $tabhead;
$tab=$tabhead."arts";
$chk=" where htmlname='".$str."' ";
mysql_select_db($tab);
$sql = mysql_query("select * from ".$tab.$chk." ");
if(!$sql){echo "<font color=red>(arturlgetart打开数据库时遇到错误!)</font>";return false;}
while($row=mysql_fetch_array($sql))
{
$a=array("id"=>$row['id'],"author"=>$row['author'],"title"=>$row['title'],"content"=>$row['content'], "htmlname"=>$row['htmlname'],"type"=>$row['type'],"edate"=>$row['edate']);
}
return $a;
}



function navidgetartids($str){
global $tabhead;
$tab=$tabhead."nav_art";
$chk=" where navid='".$str."' order by artid desc";
mysql_select_db($tab);
$sql = mysql_query("select * from ".$tab.$chk." ");
    if(!$sql){return ;}
        $a2=array();
    while($row=mysql_fetch_array($sql))
    {
    array_push($a2,$row['artid']);
    }
return $a2;
}


function delarttags($tags,$artid){
if($tags==''){}
else{
    $a = split ('[,.-]', $tags);
    for($i=1;$i<=count($a);$i++){
    $nav=$a[$i-1];
    #echo "[".$nav."]";
    if(!$nav==''){delarttags2($nav,$artid);}
    }
    }
}

function delarttags2($navname,$artid){
global $tabhead;
$name=$navname;
$tab=$tabhead."navs";
$chk=" where name='".$navname."'";
mysql_select_db($tab);
$sql = mysql_query("select * from ".$tab.$chk." ");
    if($sql){$row=mysql_fetch_array($sql);$navid=$row['id'];}
    else{echo "<div id=err>(delarttags-1打开数据库时遇到错误!)</div>";return ;}

$tab=$tabhead."nav_art";
mysql_select_db($tab);
$sql="DELETE FROM ".$tab." where navid=".$navid." and artid=".$artid;
    if (mysql_query($sql)){}
    else{echo"<div id=err>(delarttags-2打开数据库时遇到错误!)</div>";}

}





?>