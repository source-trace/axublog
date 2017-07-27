<?php
header("Content-type:text/html; charset=utf-8");
define("codename","axublog");
define("codeinfo","小巧强大的PHP+MySQL博客系统程序，全站静态生成html页面，努力成为最优秀国产博客系统！");
define("codeversion"," 1.0.4");
define("update","2017 年 7 月 10 日");
define("codeurl","www.axublog.com");
date_default_timezone_set('PRC');
define("date",date('Y-m-d H:i:s'));



require_once("../class/c_md5.php");
require_once("install_fun.php"); 
error_reporting(E_ERROR |  E_PARSE);//报告运行时错误


$title=codename.codeversion."安装";
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<style>
body{margin:10px auto;width:800px;FONT: 14px Verdana,Arial,Tahoma;}
p{margin:2px;padding:2px;}
div{
padding:0;
margin:0;
height:auto;max-height:none;overflow:hidden; zoom:1;
}
h1{text-align:center;padding:6px;margin:0;font-size:26px;}
#toplink{text-align:center;padding:0px;margin-bottom:10px;}
#redbold{color:red;font-weight:bold;}
#redbold a{color:red;}

#content{padding:10px;background:#f7f7f7;border:1px solid #999;}
#btn{padding:5px;padding-top:7px;}
form{margin:0;padding:0;}

#pleft{float:left;width:100px;padding-left:20px;line-height:32px;clear:both;border-bottom:1px dashed #ccc;}
#pright{float:left;width:600px;padding-left:20px;line-height:32px;border-bottom:1px dashed #ccc;font-size:12px;}
#pright input{margin-top:4px;margin-bottom:4px;}
#br{height:10px;width:100%;float:none;}
#step{line-height:25px;float:none;margin-bottom:10px;color:#999999;border:1px solid #ddd;padding:8px;background:#f8f8f8;}
#step a{color:#999999;text-decoration:none;}
#step span{color:red;border-bottom:2px solid red;}

.sp1{}
.b1,.b2,.b3,.b4,.b1b,.b2b,.b3b,.b4b,.b{display:block;overflow:hidden;}
.b1,.b2,.b3,.b1b,.b2b,.b3b{height:1px;}
.b2,.b3,.b4,.b2b,.b3b,.b4b,.b{border-left:1px solid #B2D0EA;border-right:1px solid #B2D0EA;}
.b1,.b1b{margin:0 5px;background:#B2D0EA;}
.b2,.b2b{margin:0 3px;border-width:2px;}
.b3,.b3b{margin:0 2px;}
.b4,.b4b{height:2px;margin:0 1px;}
.d1{font-size:14px;background:#EDF7FF;color:#009193;padding-left:10px;line-height:24px;font-weight:bold;}
.d2{background:#EDF7FF;line-height:3px;}
#sp2{border:1px solid #B2D0EA;border-top:0;border-bottom:0;width:798px;margin:0;background:#EDF7FF;}
#sp3{background:#fff;margin:5px;margin-top:3px;margin-bottom:2px;padding:10px;}
#sp3 b{color:red;}
#tit{font-size:14px;background:#EDF7FF;color:#009193;padding-left:10px;line-height:32px;font-weight:bold;}
#{color:#111}
</style>

<title><?php echo $title?></title>
</head>
<body>
<h1><?php echo $title?></h1>
<div id=toplink><?=codename?>官方网址：<b><a target=_blank href="http://<?=codeurl?>"><?=codeurl?></a></b>
&nbsp;&nbsp;&nbsp;
</div>
<script src="../ad/"></script>


<?php
if (file_exists("../cmsconfig.php"))  
    {echo"<p align=center><br><br><br><font color=red>系统已安装！若要重新安装，请删除文件 cmsconfig.php ! </font></p>";}  
else{
		switch ($_GET["g"])
		{
		case "step2":chkoutpost();step2(); break; 
		case "step3":chkoutpost();step3(); break; 
		case "step4":chkoutpost();step4(); break; 
		default:step1(); break;
		}
}
?>


<div id=br></div>
<p align=center>©2017 自豪地采用<a href="http://<?=codeurl?>" target=_blank title="访问<?=codename?>官网"><b><?=codename?></b></a></p>
</body>
</html>










