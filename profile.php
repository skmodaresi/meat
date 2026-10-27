<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="profile.php";
$TableName="users";
//$logtime=date('H:i:s');
$title='پروفایل کاربر';
echo'
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>'.$title.'</title>
<link href="styles.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="functions.js"></script>
<link type="text/css" href="styles/jquery-ui-1.8.14.css" rel="stylesheet"/>
<script type="text/javascript" src="scripts/jquery-1.11.1.min.js"></script>
<script type="text/javascript">
 function enterIE()
 {
   if(window.event.keyCode == 13 && window.event.srcElement.id != \'sabt\')
   window.event.keyCode = 9;
 }
<!--چک کردن نام کاربری در صفحه کاربران در حالت ویرایش کاربر--> 
function validateUsernameEdt(username_edt,userid)
{   
  $("#loading").fadeIn("fast"); 
       $.ajax({
        url: "ajax_users.php",
        type: "post",
        data:{userNameForValidateEdt:username_edt,userIDForValidate:userid},
        success: function(data){$("#usernameError").html(data);}
    });
  $("#loading").fadeOut("fast");				
}
<!--چک کردن رمز عبور--> 
function validatePass(password)
{   
  $("#loading").fadeIn("fast"); 
       $.ajax({
        url: "ajax_users.php",
        type: "post",
        data:{passForValidate:password},
        success: function(data){$("#passError").html(data);}
    });
  $("#loading").fadeOut("fast");				
}
</script>
</head>';
/***************************************** MAIN*****************************************/
$_SESSION['mt_user_id'];
if(!SuperUser())
{	 
$q="SELECT * FROM $TableName T WHERE user_id=".$_SESSION['mt_user_id']."";
$res=$db->query($q);
$row=$db->fetch_assoc($res);
if($row['chkshowanbar'] == 1) $anbar_checked = 'checked';
else $anbar_checked = '';}
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<form method="post" name="myform" onkeydown="enterIE();">
<div align="center">
<table width="99%" height="100%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr><td class="title">پروفایل کاربر  '.$mtuserNAME.'</td></tr>
 <!--پايان هدر-->
 <!-- مرکز صفحه--> 
 <tr class="tr1" style="line-height:40px;">
  <td height="100%">
   <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
	<img src="images/loading.gif" id="loading" class="loading_img"/>';
	 IF($_SESSION['mt_first_login']==1)echo'<tr><td colspan="6" style="color:red"><img border="0" src="images/Info1.png" "onmouseOver="this.src=\'images/Info_h.png\'" onmouseOut="this.src=\'images/Info1.png\'" style="width:16px;height:16px;"/>برای امنیت بیشتر لطفاً رمز عبور خود را تغییر دهید و دوباره وارد سیستم شوید .</td></tr>';
	 echo'
	 <tr><td colspan="6" style="color:red"><img border="0" src="images/Info1.png" "onmouseOver="this.src=\'images/Info_h.png\'" onmouseOut="this.src=\'images/Info1.png\'" style="width:16px;height:16px;"/>دقت کنید هنگام تغییر نام کاربری و رمز عبور زبان کیبورد روی انگلیسی باشد  .</td></tr>
	 <tr>
	  <input type="hidden" name="id" value="'.$row['id'].'"/>
	  <td align="left" width="100px"><span class="star">*</span> کد کاربر  :&nbsp;</td><td align="right" width="250px"><input class="textboxme2" type="text" readonly name="user_id" value="'.$row['user_id'].'" style="width:50px;"/></td>
	  <td align="left" width="100px"> نام :&nbsp;</td><td align="right" width="250px"><input class="textboxme" type="text" name="first_name" value="'.$row['first_name'].'" /></td>
      <td align="left" width="100px"> نام خانوادگی :&nbsp;</td><td align="right" width="250px"><input class="textboxme" type="text" name="last_name" value="'.$row['last_name'].'"/></td>
	 </tr>
     <tr>	 
	  <td align="left"><span class="star">*</span> نام کاربری :&nbsp;</td><td align="right"><input class="textboxme" type="text" name="user_name" value="'.$row['user_name'].'" placeholder="حداقل 6 کاراکتر" onblur="validateUsernameEdt(this.value,document.myform.user_id.value)"/>
	   <span width="50px" id="usernameError">&nbsp;</span>  
	  </td>
      <td align="left"><span class="star">*</span> رمز عبور  :&nbsp;</td><td align="right"><input class="textboxme" type="password" name="password" value="'.decodePassword($row['password']).'" placeholder="حداقل 8 کاراکتر" onblur="validatePass(this.value,document.myform.user_id.value)"/>
	   <span width="50px" id="passError">&nbsp;</span>
	  </td>
	  <td align="left"><input type="checkbox" name="chkshowanbar" '.$anbar_checked.' /></td><td align="right">&nbsp;  نمایش سردخانه های غیرفعال</td>
	 </tr>
	 <tr>
	  <td align="left" colspan="2" style="font-style: italic;color:green">*(نام کاربری حداقل 6 کاراکتر - شامل حروف لاتین ، اعداد و کاراکترهای @ _ -)</td>
	  <td align="left" colspan="2" style="font-style: italic;color:green"">*(رمز عبور حداقل 8 کاراکتر -شامل حروف بزرگ و کوچک لاتین و اعداد)</td>
	 </tr>
     <!--<tr>	 
	  <td align="left"> رمز عبور جدید :&nbsp;</td><td align="right"><input class="textboxme" type="text" name="new_password"/></td>
	  <td align="left"> تکرار رمز عبور :&nbsp;</td><td align="right"><input class="textboxme" type="text" name="re_new_password"/></td>
	 </tr>-->
	 <tr>
	  <td align="left"> پست الکترونیک  :&nbsp;</td><td align="right"><input class="textboxme" type="text" name="email" value="'.$row['email'].'" placeholder="name@example.com"/></td>       
      <td align="left"> تلفن تماس :&nbsp;</td><td align="right"><input class="textboxme" type="text" name="tel" value="'.$row['tel'].'" onkeypress="return isNumber(event)" placeholder="02188776655"/></td>
	  <td align="left"><span class="star">*</span> تلفن همراه :&nbsp;</td><td align="right"><input class="textboxme" type="text" name="mobile" value="'.$row['mobile'].'" onkeypress="return isNumber(event)" placeholder="09121234567"/></td>
	 </tr>
	 <tr><td>&nbsp;</td></tr>
    </table>
   </td>
  </tr>
 <!-- فوتر-->
 <tr class="footer">
  <td>
   <table width="100%"  border="0" cellspacing="0" cellpadding="0" height=100%  style="margin-bottom:20px;">
   	 <tr>
      <td colspan="10" align="center">
		  <input class="buttonme" type="submit" name="Edit_x" id="sabt" value="ثبت تغييرات">
          <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\'my_frame.php\'">
      </td>
     </tr>
   </table>
  </td>
 </tr>
 <!-- پايان فوتر-->
</table>
</div>';
/**********اجازه براي ويرايش اطلاعات********/
function isPermitEdit($u_id,$u_name,$pass,$hpass,$mail,$mob,$this_id)
{
  $flag=false;
  if(!($u_name and $pass and $mob))//پر بودن فيلدها
  {
   $flag=false;
   echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
   return $flag;
  } 
  else $flag=true;
  if(!fnValidateUsername($u_name))//صحت نام کاربری
  {
   $flag=false;
   echo"<script>alert('نام کاربری حداقل 6 کاراکتر و شامل حروف لاتین و اعداد می باشد!')</script>";
   return $flag;
  }
  else $flag=true;
  if(!fnValidatePassword($pass))//صحت رمز عبور
  {
   $flag=false;
   echo"<script>alert('رمز عبور حداقل 8 کاراکتر و شامل حروف بزرگ و کوچک لاتین و عدد می باشد!')</script>";
   return $flag;
  }
  else $flag=true;
  if(!empty($u_name))//تکراری نبودن نام کاربری
  {
    $q10="SELECT * FROM users WHERE user_name='$u_name' AND id!='$this_id'";
	$res10=mysql_query($q10);
	$row10=mysql_fetch_assoc($res10);
    if(mysql_num_rows($res10)>0){
      echo"<script>alert('اين نام کاربری قبلاً ثبت شده است!')</script>";
      $flag=false;
      return $flag;
    }
    else $flag=true;
  }
  else $flag=true;
  if(($_SESSION['mt_first_login']==1)AND($hpass))//تغییر پسورد
  {
    $q1="SELECT password FROM users WHERE user_name='$u_name' AND id='$this_id'";
	$res1=mysql_query($q1);
	$row1=mysql_fetch_assoc($res1);
    if($row1['password']==$hpass)
	{
      echo"<script>alert('لطفاً رمز عبور را خود را تغییر دهید!')</script>";
      $flag=false;
      return $flag;
    }
    else $flag=true;
  }
  else $flag=true;
  if(($mob)AND(!fnValidateMobile($mob)))//صحت موبایل
  {
   $flag=false;
   echo"<script>alert('تلفن همراه را به صورت صحیح وارد نمایید!')</script>";
   return $flag;
  }
  else $flag=true;   
  // if((!empty($n_pass))and($n_pass!=$r_n_pass))
  // {
	 // $flag=false;
	 // echo "<script>alert('رمز عبور جديد با تکرار آن مغايرت دارد!');</script>";
	 // return $flag;
  // }
  // else $flag=true;
  // if (!$n_pass or !$r_n_pass)
  // { 
   // $flag=false;
   // echo "<script>alert('رمز عبور خالي قابل قبول نيست!');</script>";
   // return $flag;
  // }
  // else $flag=true;
  if((!empty($mail)) and (!filter_var($mail,FILTER_VALIDATE_EMAIL)))
  {
   $flag=false;
   echo"<script>alert('آدرس ایمیل نامعتبر است !')</script>";
   return $flag;
  }
  else $flag=true;
 return $flag;
}
/************EDIT BUTTON********/// اصلاح اطلاعات
if ((isset($Edit_x))and(!SuperUser()))
{
 $password = trim($password);
 //$hashPass = base64_encode($password);
 $hashPass = encodePassword($password,$user_name);
 if($chkshowanbar=='on') $chkshowanbar=1; else $chkshowanbar=0;
 if(isPermitEdit($user_id,$user_name,$password,$hashPass,$email,$mobile,$id))
 {
  $Mode='';
  $first_name=str_replace("ي","ی",$first_name);
  $first_name=str_replace("ك","ک",$first_name);
  $last_name=str_replace("ي","ی",$last_name);
  $last_name=str_replace("ك","ک",$last_name);
  $edit_q=("UPDATE $TableName SET user_id='$user_id',user_name=TRIM('$user_name'),password='$hashPass',first_name=TRIM('$first_name'),
			last_name=TRIM('$last_name'),email=TRIM('$email'),tel=TRIM('$tel'),mobile=TRIM('$mobile'),first_login=0,chkshowanbar=$chkshowanbar WHERE id='$id';");
  $edit_res=mysql_query($edit_q);
  if(($edit_res) and (mysql_affected_rows()!=0))
  {
   $log_e=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id','ویرایش پروفایل',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')");/*کوئری لاگ*/
   echo "<script>alert('تغییرات ثبت شد')</script>"; 
   //IF($mysql_affected_fields)
   echo "<script>parent.location='logout.php'</script>";
  } 
  if(!$edit_res) {$message ='<span style=" color:red;font: bold 12px tahoma;"> * مشکلی در ویرایش مشخصات به وجود آمده است ! *</span>';}
 }
}
echo'
'.$message.'
</form>
</body>
</html>';	
?>