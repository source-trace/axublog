<?

require_once 'conn.php';
require("class.phpmailer.php");

$attach=$_GET['a'];
$db='备份数据库：'.$_GET['d'].'<br>';
$title='来自：'.$_SERVER['SERVER_NAME'].'<br>';


$mail = new PHPMailer();

$mail->IsSMTP();					// 启用SMTP
$mail->Host = "smtp.qq.com";			//SMTP服务器
$mail->SMTPAuth = true;					//开启SMTP认证
$mail->Username = "huhucms";			// SMTP用户名
$mail->Password = "gu-58192119";				// SMTP密码

$mail->From = "huhucms@qq.com";			//发件人地址
$mail->FromName = "PHP备份MYSQL";				//发件人
$mail->AddAddress("donghuigu@qq.com", "PHP备份恢复MYSQL数据库程序-by huhunet");		//添加收件人
$mail->AddReplyTo("huhucms@qq.com", "Information");	//回复地址
$mail->WordWrap = 50;					//设置每行字符长度
/** 附件设置
$mail->AddAttachment("/var/tmp/file.tar.gz");		// 添加附件
$mail->AddAttachment("/tmp/image.jpg", "new.jpg");	// 添加附件,并指定名称
*/
$mail->AddAttachment($attach);		// 添加附件
$mail->IsHTML(true);					// 是否HTML格式邮件
$mail->CharSet = "utf-8";				// 这里指定字符集！
$mail->Encoding = "base64"; 

$mail->Subject = $db;			//邮件主题
$mail->Body    = $db.$title;		//邮件内容
$mail->AltBody = $db.$title;	//邮件正文不支持HTML的备用显示

if(!$mail->Send())
{
   echo "Message could not be sent. <p>";
   echo "Mailer Error: " . $mail->ErrorInfo;
   exit;
}

echo "Message has been sent";
?>