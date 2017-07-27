<?php 
include_once("all.php");
header("Content-type:text/html;charset=utf-8");

@$user=$_POST["user"];
@$psw=$_POST["psw"];
@$loginlong=$_POST["loginlong"];

@$g=$_GET["g"];
    switch ($g)
    {
    case "jsloginpost":jsloginpost();break; 
    case "exit":loginexit();break; 
	default:index();break; 
    }

function index(){
global $codename,$codeversion,$codeurl;
?>
<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8'>
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
<title><?=$codename?>后台管理</title>
<link rel="stylesheet" href="css/login.css" type="text/css" />
<script type="text/javascript" src="jquery-1.8.2.min.js"></script>
<script type="text/javascript">  
 $(document).keyup(function(event){  
  if(event.keyCode ==13){$("#send").click(); }  
});  

$(function(){
	$("#send").click(function(){
				var cont = $("input,select").serialize();$.ajax({url:'login.php?g=jsloginpost',type:'post',dataType:'json',data:cont,success:function(data){var str = data.jieguo;$("#jieguo").html(str);}});
			});  
 });
</script>
</head>
<body>


<h1 align=center><a href='index.php'><img title='<?=$codename?>' src='images/logo.gif' width=120></a></h1>
<div id=login>
 <form id="frm" action="?g=999" method="post">
 <div id="jieguo">请填写登录信息</div>
<p>帐号：<input id=text type="text" name="user" size=16 value=""></p>
<p>密码：<input id=text type="password" name="psw" size=18 value=""></p>
<p align=center>
<select name="loginlong" >
<option value="86400">保持登录1天</option>
<option value="3600">保持登录1小时</option>
<option value="604800">保持登录1周</option>
</select>
</p>
</form>
<p align=center>
<button id="send" >登录</button>
</p>
</div>


<div id=copy>
Powered by <a target=_blank href="<?=$codeurl?>"><?=$codename?></a>
</div>
</body>
</html>
<?}?>


<?php
function jsloginexit(){
setcookie("chkad",'', time()+9999999,"/; HttpOnly" , "",'');
setcookie("tagshu",'', time()+9999999,"/; HttpOnly" , "",'');
setcookie("lggqsj",'', time()+999999,"/; HttpOnly" , "",'');
 unset($_SESSION["chkad"]);
$jieguo= '<script>alert("exit succes!");location.href="login.php";</script>';
$json_arr = array("jieguo"=>$jieguo);
$json_obj = json_encode($json_arr);
echo $json_obj;
}


function jsloginpost(){
global $tabhead;
global $txtchk;
@$user=$_POST["user"];
@$psw=$_POST["psw"];$psw = authcode(@$psw, 'ENCODE', 'key',0); 
@$loginlong=$_POST["loginlong"];

setcookie("lggqsj",date('Y-m-d H:i:s',time()+$loginlong), time()+60*60*24,"/; HttpOnly" , "",'');

$tab=$tabhead."adusers";
$chk=" where adnaa='".$user."' and adpss='".$psw."' ";
mysql_select_db($tab);
$sql = mysql_query("select * from ".$tab.$chk);
if(!$sql){$jieguo="<div id=redmsg>(数据库查询失败!)</div>";}else{
	$num=mysql_num_rows($sql);
				if($num==0){$jieguo='<div id=redmsg>登录失败：账户或密码错误！</div>';}
				else{
loginpass($loginlong);
				$jieguo='<div id=bluemsg>登录成功！正在前往<a href="index.php">后台</a>。。。</div><meta http-equiv="refresh" content="1;url=index.php">';
				@$chkmoblie=isMobile();
				if($chkmoblie==1){$jieguo='<div id=bluemsg>登录成功！正在前往<a href="wap.php">后台</a>。。。</div><meta http-equiv="refresh" content="1;url=wap.php">';}
				}

}
$json_arr = array("jieguo"=>$jieguo);
$json_obj = json_encode($json_arr);
echo $json_obj;
}


?>
