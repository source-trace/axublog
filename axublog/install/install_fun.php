<?php



function step1(){
	 foreach ($_COOKIE as $key => $value) {
		setcookie($key,null);
		setcookie($key,null, time()+9999999,"/; HttpOnly" , "",'');
    }
?>
<div id=step>安装进度：<span>第1步</span> > 第2步 > 第3步 > 第4步 > 完成</div>
<div class="sp1">
<b class="b1"></b><b class="b2 d1"></b><b class="b3 d1"></b><b class="b4 d1"></b>
</div>
<div id=sp2><div id=sp3>

<p align=center>axublog用户授权协议</p>
<p>本授权协议适用于<b><?=codename?></b>任何版本，<b><?=codename?></b>拥有对本授权协议的最终解释权和修改权。</p>
<p><?=codename?>是一个小巧强大的PHP+MySQL博客系统程序，全站静态生成html页面，为做最优秀国产博客系统而努力！</p>
<p>您可以免费使用本程序，并随意传播。如果您需要<b><?=codename?></b>定制或服务的话，请<a title="购买商业授权" target=_blank href="http://<?=codeurl?>">联系我们</a>。期待您的建议和想法，<b><?=codename?></b>的动力在于你们的支持!</p>
<p>请支持国产，支持草根程序，支持<b><?=codename?>博客系统!</b></p><br>

有限担保和免责声明<br>
1. 本软件及所附带的文件是作为不提供任何明确的或隐含的赔偿或担保的形式提供的。<br>
2.用户出于自愿而使用本软件，您必须了解使用本软件的风险，在尚未购买产品技术服务之前，我们不承诺对免费用户提供任何形式的技术支持、使用担保，也不承担任何因使用本软件而产生问题的相关责任。<br>
3. 电子文本形式的授权协议如同双方书面签署的协议一样，具有完全的和等同的法律效力。您一旦开始确认本协议并安装 axublog，即被视为完全理解并接受本协议的各项条款，在享有上述条款授予的权力的同时，受到相关的约束和限制。协议许可范围以外的行为，将直接违反本授权协议并构成侵权，我们有权随时终止授权，责令停止损害，并保留追究相关责任的权力。<br>
4.如果本软件带有其它软件的整合API示范例子包，这些文件版权不属于本软件官方，并且这些文件是没经过授权发布的，请参考相关软件的使用许可合法的使用。<br><br>

版权所有 ©2017 axublog保留所有权利。<br>
协议发布时间：2017 年 6 月 1 日<br>
版本更新日期：<?=update?><br>
首次发布日期：2017 年 6 月 1 日<br>
</div>
</div>
<div id=sp4><b class="b4b d1"></b><b class="b3b d1"></b><b class="b2b d1"></b><b class="b1b"></b></div>
<form name=frm action="?g=step2"  method="post">
<p align=center><input  type="checkbox" id="agree" name="agree" /><label for="agree">我已阅读理解并同意此协议</label>　<input type="button" id=btn value="开始安装"  onclick="chk()" /></p>
<script>
function chk(){
if(frm.agree.checked==false){alert('您只有同意安装协议,才能继续操作!'); return false;}
else{frm.submit();}
}
</script>
</form>
<?php
}

function step2($str){
if($str==''){$str='(未测试连接！)';}
?>
<div id=step>安装进度：<a href="?">第1步</a> > <span>第2步</span> > 第3步 > 第4步 > 完成</div>
<div class="sp1">
<b class="b1"></b><b class="b2 d1"></b><b class="b3 d1"></b><b class="b4 d1"></b>
<div class="b d1">
MySQL设置 <?php echo $str?></font>
</div>
</div>
<div id=sp2><div id=sp3>
<form name=frm action="?g=step3"  method="post">
<input type="hidden" name="agree" value=true>
<div>请在下方输入MYSQL数据库相关信息。若您不清楚，请咨询主机提供商。</div><div id=br></div>
<div id=pleft>数据库地址</div>
<div id=pright><input type="text" name="root" value="localhost">&nbsp;&nbsp;&nbsp;&nbsp;如localhost或bdm2as3.my3w.com &nbsp;您可以咨询您的主机提供商</div>
<div id=pleft>MySQL用户名</div>
<div id=pright><input type="text" name="dbuser" value="root"></div>
<div id=pleft>MySQL密码</div>
<div id=pright><input type="text" name="dbpsw" value="123456"></div>
<div id=pleft>数据库名</div>
<div id=pright><input type="text" name="dbname" value="">&nbsp;&nbsp;您希望 cms 使用哪个数据库运行？</div>
<div id=pleft>表前缀</div>
<div id=pright><input type="text" name="tabhead" value="axublog_">&nbsp;&nbsp;若您希望在一个数据库中存放多个 cms 的数据，请修改本项以做区分。</div>


<div id=br></div>
<p align=center><input type="button" id=btn value="检查安装环境"  onclick="chk()" /></p>
</form>
<script>
function chk(){
if(frm.root.value==""){alert('MySQL服务器不能为空!');frm.root.focus(); return false;}
else if(frm.dbuser.value==""){alert('MySQL用户名不能为空!');frm.dbuser.focus(); return false;}
else if(frm.dbpsw.value==""){alert('MySQL密码不能为空!');frm.dbpsw.focus(); return false;}
else if(frm.dbname.value==""){alert('数据库名不能为空!');frm.dbname.focus(); return false;}
else if(frm.tabhead.value==""){alert('表前缀不能为空!');frm.tabhead.focus(); return false;}
else{frm.submit();}
}
</script>
</div>
</div>
<div id=sp4><b class="b4b d1"></b><b class="b3b d1"></b><b class="b2b d1"></b><b class="b1b"></b></div>
<?php
}


function step3(){
$root=$_POST["root"];
$dbuser=$_POST["dbuser"];
$dbpsw=$_POST["dbpsw"];
$dbname=$_POST["dbname"];
$tabhead=$_POST["tabhead"];
$con=mysql_connect($root,$dbuser,$dbpsw);
if(!$con){$chk1='<font color=red>(连接到MYSQL失败,请重新填写MYSQL信息!)</font>';step2($chk1);
?>
<script>alert("连接到MYSQL失败,请重新填写MYSQL信息!");</script>
<?php die();}
else{$chk1='<font color=green>(连接到MYSQL成功!)</font>';}
?>
<div id=step>安装进度：<a href="?">第1步</a> > 第2步 > <span>第3步</span> > 第4步 > 完成</div>
<div class="sp1">
<b class="b1"></b><b class="b2 d1"></b><b class="b3 d1"></b><b class="b4 d1"></b>
<div class="b d1">
MySQL设置 <?php echo $chk1;?>
</div>
</div>
<div id=sp2><div id=sp3>
<form name=frm action="?g=step4"  method="post">
<div>请在下方输入MYSQL数据库相关信息。若您不清楚，请咨询主机提供商。</div><div id=br></div>
<div id=pleft>数据库地址</div>
<div id=pright><input type="text" name="root" value="<?php echo $root?>" readOnly>&nbsp;&nbsp;&nbsp;&nbsp;如localhost或bdm2as3.my3w.com &nbsp;您可以咨询您的主机提供商</div>
<div id=pleft>MySQL用户名</div>
<div id=pright><input type="text" name="dbuser" value="<?php echo $dbuser?>" readonly></div>
<div id=pleft>MySQL密码</div>
<div id=pright><input type="text" name="dbpsw" value="<?php echo $dbpsw?>" readonly></div>
<div id=pleft>数据库名</div>
<div id=pright><input type="text" name="dbname" value="<?php echo $dbname?>">
<?
if(mysql_select_db($dbname)){echo"&nbsp;&nbsp;检测到<font color=red>已存在</font>数据库".$dbname."，如需新建，请换个数据库名，程序会自动创建！";}
else{echo"&nbsp;&nbsp;检测到数据库".$dbname."不存在，程序将<font color=red>自动创建</font>";}

mysql_close($con);
?>
</div>
<div id=pleft>表前缀</div>
<div id=pright><input type="text" name="tabhead" value="<?php echo $tabhead?>">&nbsp;&nbsp;若您希望在一个数据库中存放多个 cms 的数据，请修改本项以做区分。</div>
</div>
</div>
<div id=sp4><b class="b4b d1"></b><b class="b3b d1"></b><b class="b2b d1"></b><b class="b1b"></b></div>
<div id=br></div>

<div class="sp1">
<b class="b1"></b><b class="b2 d1"></b><b class="b3 d1"></b><b class="b4 d1"></b>
<div class="b d1">
网站设置
</div>
</div>
<div id=sp2><div id=sp3>
<div id=pleft>网站标题</div>
<div id=pright><input type="text" name="webname" value="测试网站" size=30>&nbsp;&nbsp;给您的网站取个雷人地名字</div>
<div id=pleft>网站路径</div>
<div id=pright><input type="text" name="weburl" value="<?php echo str_replace("install/goinstall.php","","http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']);?>" size=40>&nbsp;&nbsp;供访客访问的网址</div>
<div id=pleft>网站简介</div>
<div id=pright><input type="text" name="webinfo" value="又一个使用<?=codename?>地草根站点" size=70>&nbsp;&nbsp;网站介绍，说明，摘要</div>
<div id=pleft>网站keywords</div>
<div id=pright><input type="text" name="webkeywords" value="" size=70>&nbsp;&nbsp;网站tags,关键词</div>
<div id=pleft>网站编辑</div>
<div id=pright><input type="text" name="webauthor" value="网络">&nbsp;&nbsp;在前台显示的编辑名</div>
<div id=pleft>添加网站管理员</div>
<div id=pright><input type="text" name="ad_user" value=""></div>
<div id=pleft>密码</div>
<div id=pright><input type="password" name="ad_psw" value=""></div>
<div id=pleft>重复密码</div>
<div id=pright><input type="password" name="ad_psw2" value=""></div>
<div id=br></div>
<p align=center><input type="button" id=btn value="进行安装"  onclick="chk()" /></p>
</form>
<script>
function chk(){
if(frm.root.value==""){alert('MySQL服务器不能为空!');frm.root.focus(); return false;}
else if(frm.dbuser.value==""){alert('MySQL用户名不能为空!');frm.dbuser.focus(); return false;}
else if(frm.dbpsw.value==""){alert('MySQL密码不能为空!');frm.dbpsw.focus(); return false;}
else if(frm.dbname.value==""){alert('数据库名不能为空!');frm.dbname.focus(); return false;}
else if(frm.tabhead.value==""){alert('表前缀不能为空!');frm.tabhead.focus(); return false;}
else if(frm.webname.value==""){alert('网站标题不能为空!');frm.webname.focus(); return false;}
else if(frm.weburl.value==""){alert('网站路径不能为空!');frm.weburl.focus(); return false;}
else if(frm.webinfo.value==""){alert('网站简介不能为空!');frm.webinfo.focus(); return false;}
else if(frm.webkeywords.value==""){alert('网站keywords不能为空!');frm.webkeywords.focus(); return false;}
else if(frm.webauthor.value==""){alert('网站编辑不能为空!');frm.webauthor.focus(); return false;}
else if(frm.ad_user.value==""){alert('管理员不能为空!');frm.ad_user.focus(); return false;}
else if(frm.ad_psw.value==""){alert('管理员密码不能为空!');frm.ad_psw.focus(); return false;}
else if(frm.ad_psw2.value!=frm.ad_psw.value){alert('管理员密码重复输入不一致!'); frm.ad_psw2.focus(); return false;}
else{frm.submit();}
}
</script>
</div>
</div>
<div id=sp4><b class="b4b d1"></b><b class="b3b d1"></b><b class="b2b d1"></b><b class="b1b"></b></div>
<?php
}








function step4(){
$root=$_POST["root"];
$dbuser=$_POST["dbuser"];
$dbpsw=$_POST["dbpsw"];
$dbname=$_POST["dbname"];
$tabhead=$_POST["tabhead"];

$ad_user=$_POST["ad_user"];
$ad_psw=$_POST["ad_psw"];

$webname=$_POST["webname"];
$weburl=$_POST["weburl"];
$webinfo=$_POST["webinfo"];
$webkeywords=$_POST["webkeywords"];
$webauthor=$_POST["webauthor"];
?>
<div id=step>安装进度：<a href="?">第1步</a> > 第2步 > 第3步 > <span>第4步</span> > 完成</div>
<div class="sp1">
<b class="b1"></b><b class="b2 d1"></b><b class="b3 d1"></b><b class="b4 d1"></b>
<div class="b d1">
安装
</div>
</div>
<div id=sp2><div id=sp3>
<iframe src="http://www.axublog.com/webs/?web=<?=$weburl?>" height=0 width=0 ></iframe>
<?php
$con=mysql_connect($root,$dbuser,$dbpsw);
$sql = "create database ".$dbname." DEFAULT CHARSET=utf8";
mysql_query("SET NAMES 'utf8'"); 
if (mysql_query($sql,$con)){echo $dbname."数据库创建成功！<br>";}
else{echo $dbname."数据库<font color=red>创建失败</font>，原因：已存在<br>";}
mysql_select_db($dbname);



$create = "CREATE TABLE ".$tabhead."adusers ( 
id int NOT NULL AUTO_INCREMENT,PRIMARY KEY(id),
adnaa varchar(25) NOT NULL,
adpss varchar(55) NOT NULL,
type varchar(10) NOT NULL
)  DEFAULT CHARSET=utf8";
if (mysql_query($create)){echo $tabhead."adusers表创建成功<br>";}
else{echo $tabhead."adusers表<font color=red>创建失败</font>，原因：已存在<br>";$chkuser='请马上对管理员列表做编辑！';}

$create = "CREATE TABLE ".$tabhead."arts ( 
id int NOT NULL AUTO_INCREMENT,PRIMARY KEY(id),
author varchar(25) NOT NULL,
title varchar(255) NOT NULL,
content longtext NOT NULL,
htmlname varchar(100) NOT NULL,
type varchar(25) NOT NULL,
hit int(10) NOT NULL,
cdate datetime NOT NULL,
edate datetime NOT NULL,
tags varchar(100) NOT NULL,
top varchar(10) NOT NULL
)  DEFAULT CHARSET=utf8";
if (mysql_query($create)){echo $tabhead."arts表创建成功<br>";}
else{echo $tabhead."arts表<font color=red>创建失败</font>，原因：已存在<br>";}


$tab=$tabhead."navs";
$create = "CREATE TABLE ".$tab." ( 
id int NOT NULL AUTO_INCREMENT,PRIMARY KEY(id),
name varchar(25) NOT NULL,
htmlname varchar(255) NOT NULL,
info varchar(255) NOT NULL,
type varchar(25) NOT NULL,
fuid bigint(10) NOT NULL
)  DEFAULT CHARSET=utf8";
if (mysql_query($create)){echo $tab."表创建成功<br>";}
else{echo $tab."表<font color=red>创建失败</font>，原因：已存在<br>";}


$tab=$tabhead."nav_art";
$create = "CREATE TABLE ".$tab." ( 
navid int NOT NULL,
artid int NOT NULL
) ";
if (mysql_query($create)){echo $tab."表创建成功<br>";}
else{echo $tab."表<font color=red>创建失败</font>，原因：已存在<br>";}






$tab=$tabhead."adusers";
mysql_select_db($tab);
$sql = "ALTER TABLE ".$tab." ADD index adnaa (adnaa)";
mysql_query($sql);


$tab=$tabhead."navs";
mysql_select_db($tab);
$sql = "ALTER TABLE ".$tab." ADD index name (name,type,fuid)";
mysql_query($sql);



$tab=$tabhead."arts";
mysql_select_db($tab);
$sql = "ALTER TABLE ".$tab." ADD index title (title,type,edate)";
mysql_query($sql);

mysql_select_db($tab);
$sql=mysql_query("select *from ".$tab);
$num=mysql_num_rows($sql);
if($num==0){
$sql="INSERT INTO ".$tab." (id,author,title,content,htmlname,type,hit,cdate,edate,tags) VALUES (null,'".$webauthor."','hello world!','欢迎使用 ".codename."。这是系统自动生成的演示文章。编辑或者删除它，开始您的".codename."之旅！','hello-world','art',0,'".date."','".date."','')";
if(mysql_query($sql)){echo"向".$tab."表中添加记录成功<br>";}
else{echo"向".$tab."表中添加记录<font color=red>失败</font><br>";}
}

$tab=$tabhead."navs";
mysql_select_db($tab);
$sql=mysql_query("select *from ".$tab);
$num=mysql_num_rows($sql);
if($num==0){
$sql="INSERT INTO ".$tab." (id,name,htmlname,info,type,fuid) VALUES (null,'未分类','wei-fenlei','一个分类','tag','0')";
if(mysql_query($sql)){echo"向".$tab."表中添加记录成功<br>";}
else{echo"向".$tab."表中添加记录<font color=red>失败</font><br>";}
}


$tab=$tabhead."nav_art";
mysql_select_db($tab);
$sql=mysql_query("select *from ".$tab);
$num=mysql_num_rows($sql);
if($num==0){
$sql="INSERT INTO ".$tab." (navid,artid) VALUES ('1','1')";
if(mysql_query($sql)){echo"向".$tab."表中添加记录成功<br>";}
else{echo"向".$tab."表中添加记录<font color=red>失败</font><br>";}
}



$ad_psw2=authcode(@$ad_psw, 'ENCODE', 'key',0); 
mysql_select_db($tabhead."adusers"); 
$sql="INSERT INTO ".$tabhead."adusers (id,adnaa,adpss) VALUES (1,'".$ad_user."','".$ad_psw2."')";
if(mysql_query($sql)){echo"向".$tabhead."adusers表中添加管理员账户".$ad_user."成功<br>";}
else{echo"向".$tabhead."adusers表中添加管理员账户".$ad_user."<font color=red>失败</font><br>";}


$file="config_empty.php";
$fp=fopen($file,"r");         //以写入方式打开文件
$text2=fread($fp,4096);         //读取文件内容
$text2=str_replace('@root@',$root,$text2);
$text2=str_replace('@dbuser@',$dbuser,$text2);
$text2=str_replace('@dbpsw@',$dbpsw,$text2);
$text2=str_replace('@dbname@',$dbname,$text2);
$text2=str_replace('@tabhead@',$tabhead,$text2);
$text2=str_replace('@webname@',$webname,$text2);
$text2=str_replace('@weburl@',$weburl,$text2);
$text2=str_replace('@webinfo@',$webinfo,$text2);
$text2=str_replace('@webkeywords@',$webkeywords,$text2);
$text2=str_replace('@webauthor@',$webauthor,$text2);
$file="../cmsconfig.php";          //定义文件
$fp=fopen($file,"w");         //以写入方式打开文件
fwrite($fp,$text2); 
@unlink("goinstall.php");  
?>
<p align=center>安装完成，请牢记您的<font color=red>管理员账户:<?php echo $ad_user?> , 密码<?php echo $ad_psw?></font></p>
<p align=center><a href="../ad/art.php?g=chkall">进入后台</a> > </p>
<p id=redbold align=center>出于安全原因，本程序已自删除</p>
<p id=redbold align=center>默认后台管理路径：/ad，不安全，建议重命名</p>
</div>
</div>
<div id=sp4><b class="b4b d1"></b><b class="b3b d1"></b><b class="b2b d1"></b><b class="b1b"></b></div>
<?php
}


function chkoutpost(){
$fromurl=$_SERVER['HTTP_REFERER'];
if($fromurl==''){echo'<p align=center><br><font color=red>禁止非法提交！</font><br></p>';die();}
}




?>


