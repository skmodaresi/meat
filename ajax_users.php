<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
/***************************ajax شروع**********************************/
/*************************************************************/ 
//چک کردن نام کاربری در صفحه کاربران در حالت کاربر جدید
if(isset($_POST['userNameForValidateIns']))
{
 if(empty($_POST['userNameForValidateIns']))  echo'<img border="0" src="images/pen.png" onmouseOver="this.src=\'images/pen_hover.png\'" onmouseOut="this.src=\'images/pen.png\'"  title="نام کاربری را وارد نمایید" style="cursor:pointer"/>';
 else
 { 
  $q_user=("SELECT user_name FROM users WHERE user_name='$userNameForValidateIns'");
  $res_user=mysql_query($q_user);
  if(mysql_num_rows($res_user)>0)
   echo'<img border="0" src="images/dont.png"  title="این نام کاربری قبلاً ثبت شده است" style="cursor:pointer"/>';
   //echo'<img border="0" src="images/mark2.png" onClick="showUpload()" title="این نام کاربری قبلاً ثبت شده است" style="cursor:pointer"/>';
  else if(!fnValidateUsername($userNameForValidateIns))
   echo'<img border="0" src="images/dont.png"  title="نام کاربری مطابق الگو وارد نشده است" style="cursor:pointer"/>';
  else
   echo'<img id="flip" border="0" src="images/ok2.png" title="نام کاربری آزاد است" style="cursor:pointer" onclick="v()"/>';
 }
}
/*************************************************************/ 
//چک کردن نام کاربری در صفحه کاربران در حالت ویرایش کاربر 
if((isset($_POST['userNameForValidateEdt']))and(isset($_POST['userIDForValidate'])))//چک کردن نام کاربری در صفحه کاربران
{
  if(empty($_POST['userNameForValidateEdt'])) echo'<img border="0" src="images/pen.png" onmouseOver="this.src=\'images/pen_hover.png\'" onmouseOut="this.src=\'images/pen.png\'"  title="نام کاربری را وارد نمایید" style="cursor:pointer"/>';
  else
 { 
  $q_user=("SELECT user_name FROM users WHERE user_name='$userNameForValidateEdt' and user_id!='$userIDForValidate'");
  $res_user=mysql_query($q_user);
  if(mysql_num_rows($res_user)>0)
   echo'<img border="0" src="images/dont.png"  title="این نام کاربری قبلاً ثبت شده است" style="cursor:pointer"/>';
  else if(!fnValidateUsername($userNameForValidateEdt))
   echo'<img border="0" src="images/dont.png"  title="نام کاربری مطابق الگو وارد نشده است" style="cursor:pointer"/>';
  else
   echo'<img id="flip" border="0" src="images/ok2.png" title="نام کاربری آزاد است" style="cursor:pointer" onclick="v()"/>';
 }
}
/*************************************************************/
//چک کردن پسورد 
if(isset($_POST['passForValidate']))//چک کردن صحت پسورد
{
  if(empty($_POST['passForValidate'])) echo'<img border="0" src="images/pen.png" onmouseOver="this.src=\'images/pen_hover.png\'" onmouseOut="this.src=\'images/pen.png\'"  title="رمز عبور را وارد نمایید" style="cursor:pointer"/>';
  else
 { 
  if(!fnValidatePassword($passForValidate))
   echo'<img border="0" src="images/dont.png"  title="رمز عبور مطابق الگو وارد نشده است" style="cursor:pointer"/>';
  else
   echo'<img id="flip" border="0" src="images/ok2.png" title="رمز عبور صحیح است" style="cursor:pointer" onclick="v()"/>';
 }
}
/*************************************************************/
// if (isset($_POST['userNameForValidate']))
// {
  // if(empty($_POST['userNameForValidate'])) echo '<span style="color:red">نام کاربری را وارد نمایید</span>';
 // else
 // { 
 // $q_user=("SELECT * FROM users WHERE user_name='$bzuserNAMEForValidate'");
 // $res_user=mysql_query($q_user);
 // if(mysql_num_rows($res_user)>0)
  // echo '<span style="color:red">نام کاربری تکراری است !</span>';
 // else
  // echo '<span style="color:green">  نام کاربری آزاد است</span>'; 
 // }
// }
//dont use/*************************************************************/
if(isset($_POST['codeOSTAN']))//ظاهر شدن دکمه لیست انباردر صفحه کاربران
{
  $nameOstan=$db->get_from_where("name_ostan","ostan","code_ostan='$codeOSTAN'");
  echo $anbar_button='<input type="button" class="buttonme" name="button_anbar" value="انبارهای استان '.$nameOstan.'" onClick="window.open(\'user_list_anbar.php?prev_php=users.php&pageMaster='.$PageNum.'&c_ostan_='.$codeOSTAN.'&u_id_='.$userID.'\',\'_blank\',\'width=600px\')"/>';  
}   
?>