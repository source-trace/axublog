
<?php
require_once 'conn.php';




mysql_connect($host,$user,$password);
mysql_select_db($dbname);

echo "正在清空数据库...<br>"; 
$result=mysql_query("SHOW tables"); 
while ($currow=mysql_fetch_array($result)) { 
mysql_query("drop TABLE IF EXISTS $currow[0]"); 
echo $currow[0]."<br>"; 
} 
echo "成功<br>"; 


?>
<script>location.href="index.php"</script>
<a href='index.php'>首页</a>

