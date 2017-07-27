<?php




function chkthemeappshu(){
global $themepath,$themeshu,$apppath,$appshu,$configfile;
$zu=explode('/',$themepath);
$file2=$zu[0].'/';
$file='../'.$file2;
$path_pattern = $file."*";
$shu=0;
		foreach(glob($path_pattern) as $file)      
				{
						if(is_dir($file)){$shu=$shu+1;}
				}
$file="../".$configfile;
$text = file_get_contents($file);
$text2=$text;
$text2=str_replace('"'.$themeshu.'"','"'.$shu.'"',$text2);

$file2=$apppath;
$file='../'.$file2;
$path_pattern = $file."*";
$shu=0;
		foreach(glob($path_pattern) as $file)      
				{
						if(is_dir($file)){$shu=$shu+1;}
				}
$file="../".$configfile;
$text2=str_replace('"'.$appshu.'"','"'.$shu.'"',$text2);
file_put_contents ($file, $text2);
}


/**
     * 删除文件夹
     */
function deldir($dir)
{
   $dh = opendir($dir);
   while ($file = readdir($dh))
   {
      if ($file != "." && $file != "..")
      {
         $fullpath = $dir . "/" . $file;
         if (!is_dir($fullpath))
         {
            unlink($fullpath);
         } else
         {
            deldir($fullpath);
         }
      }
   }
   closedir($dh);
   if (rmdir($dir))
   {
      return true;
   } else
   {
      return false;
   }
}


function themefolder($str)
{ 
$zu=explode('/',$str);
$str2=$zu(0);
return $str2;
}


function mkdirs($dir, $mode = 0777) 
{ 
if (is_dir($dir) || @mkdir($dir, $mode)) return TRUE; 
if (!mkdirs(dirname($dir), $mode)) return FALSE; 
return @mkdir($dir, $mode); 
}


		function mbreplace($html){
global $tabhead,$webname,$webinfo,$weburl,$webauthor,$themepath,$artpath,$tagpath,$title,$info,$url,$webbegindate;
		$html=str_replace('{$webname}',$webname,$html); 
		$html=str_replace('{$webinfo}',$webinfo,$html); 
		$html=str_replace('{$weburl}',$weburl,$html); 
		$html=str_replace('{$webauthor}',$webauthor,$html); 
		$html=str_replace('{$themepath}',$themepath,$html); 
		$html=str_replace('{$artpath}',$artpath,$html); 
		$html=str_replace('{$tagpath}',$tagpath,$html); 
		$html=str_replace('{$topmenu}',topmenu(),$html); 
		$html=str_replace('{$title}',$title,$html); 
		$html=str_replace('{$info}',$info,$html); 
		$html=str_replace('{$showalltag}',showalltag(),$html); 
		$html=str_replace('{$showhottag}',showhottag(),$html); 
		$html=str_replace('{$showhotart}',showhotart(),$html); 
		$html=str_replace('{$showrandomart}',showrandomart(),$html); 
		$html=str_replace('{$webbegindate}',$webbegindate,$html);
		$html=str_replace('{$runtime}',runtime(),$html);
		date_default_timezone_set('PRC');
$date=date('Y-m-d H:i:s');
$html=$html."\r\n<!--saveed at ".$date."-->\r\n"; 
		return $html;
		}
	


//$sourcestr 是要处理的字符串

//$cutlength 为截取的长度(即字数)

function cut_str($sourcestr,$cutlength)

{

   $returnstr='';

   $i=0;

   $n=0;

   $str_length=strlen($sourcestr);//字符串的字节数

   while (($n<$cutlength) and ($i<=$str_length))

    {

      $temp_str=substr($sourcestr,$i,1);

      $ascnum=Ord($temp_str);//得到字符串中第$i位字符的ascii码

      if ($ascnum>=224)    //如果ASCII位高与224，

      {

         $returnstr=$returnstr.substr($sourcestr,$i,3); //根据UTF-8编码规范，将3个连续的字符计为单个字符         

         $i=$i+3;            //实际Byte计为3

         $n++;            //字串长度计1

      }

       elseif ($ascnum>=192) //如果ASCII位高与192，

      {

         $returnstr=$returnstr.substr($sourcestr,$i,2); //根据UTF-8编码规范，将2个连续的字符计为单个字符

         $i=$i+2;            //实际Byte计为2

         $n++;            //字串长度计1

      }

       elseif ($ascnum>=65 && $ascnum<=90) //如果是大写字母，

      {

         $returnstr=$returnstr.substr($sourcestr,$i,1);

         $i=$i+1;            //实际的Byte数仍计1个

         $n++;            //但考虑整体美观，大写字母计成一个高位字符

      }

       else                //其他情况下，包括小写字母和半角标点符号，

      {

         $returnstr=$returnstr.substr($sourcestr,$i,1);

         $i=$i+1;            //实际的Byte数计1个

         $n=$n+0.5;        //小写字母和半角标点等与半个高位字符宽...

      }

    }

          if ($str_length>$cutlength){

          $returnstr = $returnstr;//超过长度时在尾处加上省略号

      }

     return $returnstr;

}




function ht_addart($title,$tags,$content){
global $tabhead,$webname,$webinfo,$weburl,$webauthor,$themepath,$artpath,$tagpath,$date;
if(strlen($title)>60){$title=cut_str($title,30);}
$htmlname=htmlnameguolv($htmlname);
$htmlname=pinyin($title);
#$content=gethttpimg($content);
$tags=htmlnameguolv($tags);

$title=addslashes($title);
$content=addslashes($content);
$htmlname=addslashes($htmlname);
$author=addslashes($author);
$tags=addslashes($tags);
$title=str_replace("\r","",$title);
$title=str_replace("\n","",$title);
$content=httptomyurl($content);

if(strlen($content)<5){die('内容为空');}
if($title==''){die('标题为空');}

$tab=$tabhead."arts";
mysql_select_db($tab);
$chk=" where htmlname='".$htmlname."'";
$sql = mysql_query("select * from ".$tab.$chk);
        if(!$sql){echo "(数据库查询失败!)<br>";}
$num=mysql_num_rows($sql);
if($num==0)
{
$sql="INSERT INTO ".$tab." (id,author,title,content,htmlname,type,hit,cdate,edate) VALUES (null,'".$author."','".$title."','".$content."','".$htmlname."','art',0,'".$date."','".$date."')";
		if(mysql_query($sql)){echo"<p>添加文章成功,<a href='".$weburl.$artpath.$htmlname."' target=_blank>查看》</a>，<a href='javascript:history.back()' >返回《</a><br>正在生成页面,请稍等片刻。。。</p>";
		$artid = mysql_insert_id();
		addtags($tags,$artid);
		echo'<iframe src="html.php?g=haart&p='.$htmlname.'" height=200 width=800></iframe>';
		}
		else{echo"添加文章 [".$title."] <font color=red>失败1</font><br>".$sql;return;}
}
else{echo'html别名已存在:'.$htmlname.'<br>';return;}
}




function rcolor() {
srand((double)microtime()*10000000);
$rand = (rand(15,235));
return sprintf("%02X","$rand");
}


function nofuhao($str)
{
     return str_replace
       (
       array("~","!","@","#","$","%","^","&","*",",","?",";",":","'",'"',"[","]","{","}","！"," ￥","……","…","、","，","。","？","；","：","‘","“","”","’","【","】","～","！","＠","＃","＄","％","＾","＆","＊","，","．","＜","＞","；","：","＇","＂","［","］","｛","｝","／","＼","(",")","<",">","|","-","+","=","/","\\","`"),
       '',
          $str
       );
}
#去除所有标点符号


function httptomyurl($u){
global $weburl;
$u=str_replace($weburl,'$weburl$',$u);
$u = preg_replace('/<a(.*?)href=(.*?)http:\/\/(.*?)<\/a>/','<a target=_blank href=\2'.$weburl.'go/?u=http:\/\/\3<\/a>',$u); 
$u=str_replace('$weburl$',$weburl,$u);
return $u;
}
#替换外部链接，以内链方式链接




function goneilian($str){
$a=getalltag();
$shu=count($a);
	for($i=1;$i<=$shu;$i++){
	$_SESSION['neilian'.$i]='';
	$b=$a[$i-1];
	$name=$b['name'];
	$htmlname=$b['htmlname'];
	$url=tagtourl($htmlname);
	$neilian='<a href="'.$url.'" target=_blank>'.$name.'</a>';
	$count=0;
	$str=preg_replace('/'.$name.'/','$neilian'.$i.'/$neilian',$str, 1,$count);
	if($count==1){$_SESSION['neilian'.$i]=$neilian;}
	}
		for($i=1;$i<=$shu;$i++){
		$str=str_replace('$neilian'.$i.'/$neilian',$_SESSION['neilian'.$i],$str);
		}
return $str;
}


function getweburl(){
global $weburl;
if($weburl=='/'){$w='http://'.$_SERVER['SERVER_NAME'].$weburl;}
else{$w=$weburl;}
return $w;
}


/**********************************
//Big5码转换成GB码
**********************************/
function big52gb($Text) {
        global $BIG5_DATA;
        if(empty($BIG5_DATA)){
                $filename = dirname(__FILE__)."/table/big5-gb.table";
                $fp = fopen($filename, "rb");
                $BIG5_DATA = fread($fp,filesize($filename));
                fclose($fp);
        }
        $max = strlen($Text)-1;
        for($i=0;$i<$max;$i++) {
                $h = ord($Text[$i]);
                if($h>=0x80) {
                        $l = ord($Text[$i+1]);
                        if($h==161 && $l==64) {
                                        $gbstr = "　";
                        }else{
                                        $p = ($h-160)*510+($l-1)*2;
                                        $gbstr = $BIG5_DATA[$p].$BIG5_DATA[$p+1];
                        }
                        $Text[$i] = $gbstr[0];
                        $Text[$i+1] = $gbstr[1];
                        $i++;
                }
        }
        return $Text;
}


function gethttpimg($content){
$content=stripslashes($content);
$reg = "/<img[^>]*src=\"(http:\/\/(.+)\/(.+)\.(jpg|gif|bmp|png))\"/isU"; 
    preg_match_all($reg, $content, $img_array, PREG_PATTERN_ORDER);
    $img_array = array_unique($img_array[1]);
foreach ($img_array as $key => $value) { //使用循环语句把匹配到的数组内容(相片)进行一
 if(file_get_contents($value)) 
   $get_file = file_get_contents($value);//开始获取图像了哦 使用file_get_contents得到文件
        else dir("运程保存图片出错<br>");

   $filepath = "../upfiles/".date("Y").'/'.date("m").'/';;//相片保存的路径目录
   
mkdirs($filepath,0777); 
   $filename =date("dHis") . '_' . rand(10000, 99999) . '.' . substr($value,-3,3);
   global $weburl;
   $saveurl=str_replace('../','',$weburl.$filepath.$filename);
   $fp = @fopen($filepath.$filename,"w"); //以写方式打开文件
   @fwrite($fp,$get_file); //
   fclose($fp);//完工，哈 
   $content = preg_replace("/".addcslashes($value,"/")."/isU",$saveurl, 

$content); //顺便替换一下文章里面的相片地址
   }
#die($content);
return $content;
}



function chkinstall(){
if (file_exists("cmsconfig.php"))  
    {require("cmsconfig.php");}  
    else{
    echo "<script language='javascript'>";
    echo "location='install/goinstall.php';";
    echo "</script>"; 
    die();
    } 
}


function getwebpath(){
$str=$_SERVER['SCRIPT_NAME'];
$str=str_replace('index.php','',$str);
return $str;
}


function chk301(){
$the_host = $_SERVER['HTTP_HOST'];//取得进入所输入的域名
$request_uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';//判断地址后面部分
if($the_host== 'huhunet.com')//这是我要以前的域名地址
{
  header('HTTP/1.1 301 Moved Permanently');//发出301头部 
  header('Location: http://www.huhunet.com'.$request_uri);//跳转到我的新域名地址
}
}


function HtmlEncode($fString)
{
if($fString!="")
{
     $fString = str_replace( '>', '&gt;',$fString);
     $fString = str_replace( '<', '&lt;',$fString);
}
     return $fString;
}



function EncodeHtml($fString)
{
if($fString!="")
{
     $fString = str_replace("&gt;" , ">", $fString);
     $fString = str_replace("&lt;", "<", $fString);

}
     return $fString;
}


function getartinfo($p_info){
$p_info=strtolower($p_info);
$p_info=str_replace('</p>','$br$',$p_info);
$p_info=str_replace('</table>','$br$',$p_info);
$p_info=str_replace('</tr>','$br$',$p_info);
$p_info=str_replace('</div>','$br$',$p_info);
$p_info=str_replace('</h3>','$br$',$p_info);
$p_info=str_replace('</h2>','$br$',$p_info);
$p_info=str_replace('</h1>','$br$',$p_info);
$p_info=str_replace('</h4>','$br$',$p_info);
$p_info=str_replace('<br />','$br$',$p_info);
$p_info=str_replace('<br/>','$br$',$p_info);
$p_info=str_replace('<img','$img$',$p_info);

$p_info=strip_tags($p_info);
$p_info=str_replace('$br$','<br>',$p_info);
$p_info=str_replace('$img$','<img',$p_info);
$p_info=str_replace('\"','"',$p_info);
$a=split('<br>',$p_info);
$p_info='';
@$p_info=$p_info.$a[0].'<br>'.$a[1].'<br>'.$a[2].'<br>';
if(strlen($p_info)>1400){$p_info=substr(strip_tags($p_info),0,600);}
return $p_info;
}
#截取文章简介






class get_c_str {
var $str;
var $start_str;
var $end_str;
var $start_pos;
var $end_pos;
var $c_str_l;
var $contents;
function get_str($str,$start_str,$end_str){
   $this->str = $str;
   $this->start_str = $start_str;
   $this->end_str = $end_str;
   $this->start_pos = strpos($this->str,$this->start_str)+strlen($this->start_str);
     $this->end_pos = strpos($this->str,$this->end_str);
   $this->c_str_l = $this->end_pos - $this->start_pos;
   $this->contents = substr($this->str,$this->start_pos,$this->c_str_l);
   return $this->contents;
}
}

#截取字符串


function htmlnameguolv($str){
$str = str_replace('`', '', $str);
    $str = str_replace('·', '', $str);
    $str = str_replace('~', '', $str);
    $str = str_replace('!', '', $str);
    $str = str_replace('！', '', $str);
    $str = str_replace('@', '', $str);
    $str = str_replace('#', '', $str);
    $str = str_replace('$', '', $str);
    $str = str_replace('￥', '', $str);
    $str = str_replace('%', '', $str);
    $str = str_replace('^', '', $str);
    $str = str_replace('……', '', $str);
    $str = str_replace('&', '', $str);
    $str = str_replace('*', '', $str);
    $str = str_replace('(', '', $str);
    $str = str_replace(')', '', $str);
    $str = str_replace('（', '', $str);
    $str = str_replace('）', '', $str);
    $str = str_replace('——', '', $str);
    $str = str_replace('+', '', $str);
    $str = str_replace('=', '', $str);
    $str = str_replace('|', ',', $str);
    $str = str_replace('\\', '', $str);
    $str = str_replace('[', '', $str);
    $str = str_replace(']', '', $str);
    $str = str_replace('【', '', $str);
    $str = str_replace('】', '', $str);
    $str = str_replace('{', '', $str);
    $str = str_replace('}', '', $str);
    $str = str_replace(';', '', $str);
    $str = str_replace('；', '', $str);
    $str = str_replace(':', '', $str);
    $str = str_replace('：', '', $str);
    $str = str_replace('\'', '', $str);
    $str = str_replace('"', '', $str);
    $str = str_replace('“', '', $str);
    $str = str_replace('”', '', $str);
    $str = str_replace('，', ',', $str);
    $str = str_replace('<', '', $str);
    $str = str_replace('>', '', $str);
    $str = str_replace('《', '', $str);
    $str = str_replace('》', '', $str);
    $str = str_replace('.', '', $str);
    $str = str_replace('。', '', $str);
    $str = str_replace('/', '', $str);
    $str = str_replace('、', '', $str);
    $str = str_replace('?', '', $str);
    $str = str_replace('？', '', $str);
return $str;
}
#html别名过滤字符


function jump($url,$sec){
echo <<<EOF
<script>window.setTimeout("location.href='{$url}'",{$sec}000);</script>
EOF;
}
#跳转页面

function chkoutpost(){
@$fromurl=$_SERVER['HTTP_REFERER'];
if($fromurl==''){echo'<div id=err>禁止非法提交！</div>';die();}
}
#禁止站外提交


?>