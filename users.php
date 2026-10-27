<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="users.php";
$TableName="users";
$titr='کاربران سیستم ';
$right_ins=0;$right_edt=0;$right_del=0;$right_ostan=0;$right_anbar=0;$right_role=0;
if (right(313)) $right_ins=1;
if (right(314)) $right_edt=1;
if (right(315)) $right_del=1;
if (right(316)) $right_ostan=1;
if (right(317)) $right_anbar=1;
if (right(318)) $right_role=1;
//اطلاعات کاربرلاگین کرده
$condition='';
if(!SuperUser())
{
 $res_user=$db->query("SELECT * FROM $TableName WHERE user_id=".$_SESSION['mt_user_id']."");
 $row_user=$db->fetch_assoc($res_user);
 $user_role_des=$db->get_from_where("role_description","roles","role_id=".$row_user['role_id']."");
 if($user_role_des=='ادمین استان') $condition='AND code_ostan='.$row_user['code_ostan'].' AND role_id!='.$row_user['role_id'].'';
} 
echo'
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>'.$titr.'</title>
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
 function popupwindow(url, title, w, h) {
  var left = (screen.width/2)-(w/2);
  var top = (screen.height/2)-(h/2);
  return window.open(url, title, "toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width="+w+", height="+h+", top="+top+", left="+left);
 }
<!--چک کردن نام کاربری در صفحه کاربران در حالت کاربر جدید-->
function validateUsernameIns(username_ins)
{   
  $("#loading").fadeIn("fast"); 
       $.ajax({
        url: "ajax_users.php",
        type: "post",
        data:{userNameForValidateIns:username_ins},
        success: function(data){$("#usernameError").html(data);}
    });
  $("#loading").fadeOut("fast");				
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
        function showUpload()
        {           
            $("#lightBox").fadeToggle("slow");            
        }
function getAnbareOstan(code_ostan)
{
  $("#loading").fadeIn("fast");  
  $.post("ajax.php",{codeOSTAN1:code_ostan},function(data){$("#code_anbar").html(data);});
  $("#loading").fadeOut("fast");		
}
function AnbarehayeOstan(code_ostan,user_id,PageNo)
{
  $("#loading").fadeIn("fast");  
  $.post("ajax_users.php",{codeOSTAN:code_ostan,userID:user_id,PageNum:PageNo},function(data){$("#button_anbar").html(data);});
  $("#loading").fadeOut("fast");		
}
</script>
</head>';
if(!(isset($Mode))) $Mode='';
/*************SEARCH BUTTON******/// جستجوي اطلاعات
if(isset($open_filter))
{ $open_filter="";
  $_SESSION['mt_search_users']="";
} 
if(isset($Search_x))
{
 $Mode='';
 $Search_x=""; 
 $temp="";
 if($user_id)     $temp.=" AND user_id LIKE '%$user_id%'";
 if($first_name)  $temp.=" AND first_name LIKE '%$first_name%'";
 if($last_name)   $temp.=" AND last_name LIKE '%$last_name%'";
 if($national_id) $temp.=" AND national_id LIKE '%$national_id%'";
 if($user_name)   $temp.=" AND user_name LIKE '%$user_name%'";
 if($password)    $temp.=" AND password LIKE '%$password%'";
 if($code_ostan)  $temp.=" AND code_ostan LIKE '$code_ostan'";
 //if($code_anbar)  $temp.=" AND code_anbar LIKE '%$code_anbar%'";
 if($role_id_search)     $temp.=" AND role_id='$role_id_search'";
 if($email)       $temp.=" AND email LIKE '%$email%'";
 if($tel)         $temp.=" AND tel LIKE '%$tel%'";
 if($mobile)      $temp.=" AND mobile LIKE '%$mobile%'";
 if($temp) {$PageNo=1;$_SESSION['mt_search_users']=$temp;} else $_SESSION['mt_search_users']="";
}
/********************PAGING***********************/
if(isset($_POST['wRowPerPage'])) $RowPerPage=$_POST['wRowPerPage'];
if(!isset($RowPerPage)) $RowPerPage=8;
$res = $db->query("SELECT COUNT(*) FROM $TableName WHERE 1=1 $condition ".$_SESSION['mt_search_users']."");
$row = $db->fetch_array($res);
$cnt = $row[0];
$MaxPage=intval($cnt/$RowPerPage);
if ($cnt%$RowPerPage) $MaxPage++;
if (!$MaxPage) $MaxPage=1;
if (!isset($PageNo)) $PageNo=1; //$PageNo=$MaxPage;  
$NextPage=$PageNo+1;
$PrevPage=$PageNo-1;
if (!$cnt)
 {$En_Prev="Disabled";$En_Next="Disabled";}
else
 {$En_Prev="";$En_Next="";}
if ($PageNo==$MaxPage) $En_Next="onclick=\'return false;\'";
if ($PageNo==1) $En_Prev="onclick=\'return false;\'";
$FirstRow=$PrevPage*$RowPerPage;
if ($FirstRow<0) $FirstRow=0;
$Limit="Limit ".$FirstRow.",".$RowPerPage; 
/******************** Insert- Edit- Delete ************/
/************اجازه براي ذخيره اطلاعات************/
function isPermitSave($u_id,$f_name,$l_name,$c_meli,$u_name,$pass,$ro_id,$c_ostan,$mail,$mob)
{
 $flag=false;
 if(!($u_id and $f_name and $l_name and $c_meli and $u_name and $pass and $ro_id and $mob))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>"; 
   return $flag;
 } 
 else $flag=true;
 if(($ro_id!=1)and(!$c_ostan))//اگر کاربر مدیر نباشد فیلد استان انتخاب شده باشد
 {
   $flag=false;
   echo"<script>window.alert('لطفاً استانی را برای کاربر انتخاب نمایید!');</script>"; 
   return $flag;
 } 
 else $flag=true;
 //dont use
 // if(($ro_id!=1)and(!empty($u_id)))//انتخاب انبار برای استان اگر کاربر مدیر نباشد
 // {
   // $q8="SELECT * FROM user_ostan_anbar WHERE user_id='$u_id'";
   // $res9=mysql_query($q8);
   // if(mysql_num_rows($res9)==0){
     // echo"<script>alert('لطفاً انبار استان مورد نظر را ثبت نمایید!')</script>";
     // $flag=false;
     // return $flag;
  // }
 // else $flag=true;
 // }
 // else $flag=true;
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
 if(!empty($u_name))//تکرای نبودن نام کاربری
 {
   $q9="SELECT * FROM users WHERE user_name='$u_name'";
   $res9=mysql_query($q9);
   if(mysql_num_rows($res9)>0){
     echo"<script>alert('اين نام کاربری قبلاً ثبت شده است!')</script>";
     $flag=false;
     return $flag;
  }
 else $flag=true;
 }
 else $flag=true;
 if(($c_meli!=NULL)and((!justNumber($c_meli)) or (strlen($c_meli)>10) or (strlen($c_meli)<10)))//بررسی کد ملی
 {
    $flag=false;
    echo"<script>alert('فیلد کد ملی نادرست است!')</script>";
    return $flag;
 }
 else $flag=true;
 if((!empty($mail)) and (!filter_var($mail,FILTER_VALIDATE_EMAIL)))
 {
  $flag=false;
  echo"<script>alert('آدرس ایمیل نامعتبر است !')</script>";
  return $flag;
 }
 else $flag=true;
return $flag;
}
/**********اجازه براي ويرايش اطلاعات********/
function isPermitEdit($u_id,$f_name,$l_name,$c_meli,$u_name,$pass,$ro_id,$c_ostan,$mail,$mob,$this_id)
{
  $flag=false;
  if(!($u_name and $f_name and $l_name and $c_meli and $pass and $ro_id and $mob))//پر بودن فيلدها
  {
   $flag=false;
   echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
   return $flag;
  } 
  else $flag=true;
  if(($ro_id!=1)and(!$c_ostan))//اگر کاربر مدیر نباشد فیلد استان انتخاب شده باشد
  {
   $flag=false;
   echo"<script>window.alert('لطفاً استانی را برای کاربر انتخاب نمایید!');</script>"; 
   return $flag;
  } 
  else $flag=true;
  //dont use
  // if(($ro_id!=1)and(!empty($u_id)))//انتخاب انبار برای استان اگر کاربر مدیر نباشد
  // {
   // $q8="SELECT * FROM user_ostan_anbar WHERE user_id='$u_id' AND code_ostan='$c_ostan'";
   // $res9=mysql_query($q8);
   // if(mysql_num_rows($res9)==0){
     // echo"<script>alert('لطفاً انبار استان مورد نظر را ثبت نمایید!')</script>";
     // $flag=false;
     // return $flag;
   // }
  // else $flag=true;
  // }
  // else $flag=true;
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
    $q10="SELECT * FROM users WHERE user_name='$u_name'";
    $res10=mysql_query($q10);
	$row10=mysql_fetch_assoc($res10);
	$idU=$row10['id'];
    if((mysql_num_rows($res10)>0) and ($idU!=$this_id)){
      echo"<script>alert('اين نام کاربری قبلاً ثبت شده است!')</script>";
      $flag=false;
      return $flag;
    }
    else $flag=true;
  }
  else $flag=true;
  if(($c_meli!=NULL)and((!justNumber($c_meli)) or (strlen($c_meli)>10) or (strlen($c_meli)<10)))//بررسی کد ملی
  {
    $flag=false;
    echo"<script>alert('فیلد کد ملی نادرست است!')</script>";
    return $flag;
  }
  else $flag=true;
  if((!empty($mail)) and (!filter_var($mail,FILTER_VALIDATE_EMAIL)))
  {
   $flag=false;
   echo"<script>alert('آدرس ایمیل نامعتبر است !')</script>";
   return $flag;
  }
  else $flag=true;
 return $flag;
}
/*************INSERT BUTTON******/// ثبت اطلاعات    
if(isset($Insert_x))
{
 if(isPermitSave($user_id,$first_name,$last_name,$national_id,$user_name,$password,$role_id,$code_ostan,$email,$mobile))
 {
   $Mode='';     
   $password=trim($password);
   //$hashPass = base64_encode($password);
   $hashPass = encodePassword($password,$user_name);
   if(!$code_ostan) $code_ostan='-1';
   if ($chkallostan=='on') $chkallostan=1; else $chkallostan=0;
   if($chkshowanbar=='on') $chkshowanbar=1; else $chkshowanbar=0;
   $first_name=str_replace("ي","ی",$first_name);
   $first_name=str_replace("ك","ک",$first_name);
   $last_name=str_replace("ي","ی",$last_name);
   $last_name=str_replace("ك","ک",$last_name);
   $insert_q=("INSERT INTO $TableName(user_id,user_name,password,first_name,last_name,national_id,register_date,email,tel,mobile,role_id,code_ostan,chkallostan,chkshowanbar,first_login)
             VALUES('$user_id',TRIM('$user_name'),'$hashPass',TRIM('$first_name'),TRIM('$last_name'),TRIM('$national_id'),".($yymmdd).",TRIM('$email'),TRIM('$tel'),TRIM('$mobile'),'$role_id','$code_ostan','$chkallostan','$chkshowanbar','1')");
   //$insert_q=("INSERT INTO $TableName(user_id,user_name,password,first_name,last_name,date,email,tel,role_id,code_ostan,chkforush)
      //       VALUES('$user_id','$user_name',ENCODE('$password','xlsdj'),'$first_name','$last_name',".($yymmdd).",'$email','$tel','$role_id','$code_ostan','$chkforush')"); 
   //$insert_q=("INSERT INTO $TableName(user_id,user_name,password,first_name,last_name,date,email,tel,role_id,code_ostan,code_anbar,chkforush)
        //      VALUES('$user_id','$user_name','$password','$first_name','$last_name',".($yymmdd).",'$email','$tel','$role_id','$code_ostan','$code_anbar','$chkforush')");         
   $insert_res=mysql_query($insert_q);
   if($insert_res){
     $res_id = $db->query("SELECT Max(id) FROM $TableName");
     $row_id = $db->fetch_array($res_id);
     $max_id=$row_id[0];
     $log_i=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$max_id','ثبت',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')"); /*کوئری لاگ*/
   }
   else {$message ='<span style=" color:red;font: bold 12px tahoma;"> * مشکلی در ثبت کاربر به وجود آمده است ! *</span>';}  
 }
}
/************EDIT BUTTON********/// اصلاح اطلاعات
if (isset($Edit_x))
{
 if(isPermitEdit($user_id,$first_name,$last_name,$national_id,$user_name,$password,$role_id,$code_ostan,$email,$mobile,$id_))
 {
  $Mode='';
  $password=trim($password);
  $hashPass = encodePassword($password,$user_name);
  if(($role_id==1)and(!$code_ostan)) {$code_ostan='-1';}
  if ($chkallostan=='on') {$chkallostan=1; $_SESSION['mt_all_ostan']=1;} 
  else                 {$chkallostan=0; $_SESSION['mt_all_ostan']=0;}
  if($chkshowanbar=='on') $chkshowanbar=1; else $chkshowanbar=0;
   $first_name=str_replace("ي","ی",$first_name);
   $first_name=str_replace("ك","ک",$first_name);
   $last_name=str_replace("ي","ی",$last_name);
   $last_name=str_replace("ك","ک",$last_name);
  $edit_q=("UPDATE $TableName SET user_id='$user_id',user_name=TRIM('$user_name'),password='$hashPass',first_name=TRIM('$first_name'),
			last_name=TRIM('$last_name'),national_id=TRIM('$national_id'),email=TRIM('$email'),tel=TRIM('$tel'),mobile=TRIM('$mobile'),role_id='$role_id',code_ostan='$code_ostan',chkallostan='$chkallostan',chkshowanbar='$chkshowanbar',first_login=1 WHERE id='$id_';");
             //$edit_q=("UPDATE $TableName SET user_id='$user_id',user_name='$user_name',password=ENCODE('$password','xlsdj'),first_name='$first_name',
			//last_name='$last_name',email='$email',role_id='$role_id',code_ostan='$code_ostan',chkforush='$chkforush' WHERE id='$id_';");
            // $edit_q=("UPDATE $TableName SET user_id='$user_id',user_name='$user_name',password='$password',first_name='$first_name',
			//last_name='$last_name',email='$email',role_id='$role_id',code_ostan='$code_ostan',chkforush='$chkforush' WHERE id='$id_';");
  $edit_res=mysql_query($edit_q);
  if(($edit_res) and (mysql_affected_rows()!=0)) {$log_e=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_','ویرایش',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')");} /*کوئری لاگ*/    
  if(!$edit_res)  {$message ='<span style=" color:red;font: bold 12px tahoma;"> * مشکلی در ویرایش مشخصات به وجود آمده است ! *</span>';}
 } 
}
/************DELETE BUTTON********/// حذف اطلاعات
if (isset($Delete_x))
{
 $Mode='';
 $del_q = "DELETE FROM $TableName WHERE id=$id_";
 $del_q2 = "DELETE FROM user_ostan_anbar WHERE user_id=$user_id_";
 $del_res = mysql_query($del_q);
 $del_res2 = mysql_query($del_q2);
 if($del_res && $del_res2){ $log_d=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_','حذف',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')");}//کوئری لاگ
 else { $message ='<span style=" color:red;font: bold 12px tahoma;"> * مشکلی در حذف به وجود آمده است ! *</span>';}
 }
/***************************************** MAIN*****************************************/
//قرار گرفتن فوکوس 
if ($Mode=="Insert") $load="document.myform.first_name.focus();";
if ($Mode=="Edit")   $load="document.myform.first_name.focus();";
if ($Mode=="Search") $load="document.myform.user_id.focus();";
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="'.$load.'">
<form method="post" name="myform" onkeydown="enterIE();">
<div align="center">
<table width="99%" height="100%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr>
  <td class="title">
   <div style="position:absolute;top:5px;left:47%;">کاربران سیستم</div>
   <div class="pagecover">[صفحه:&nbsp'.$PageNo.' از '.$MaxPage.']</div>
  </td>	 
 </tr>
 <!--پايان هدر-->
 <!-- مرکز صفحه--> 
 <tr>
  <td height="100%">
   <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
	<img src="images/loading.gif" id="loading" class="loading_img"/>
	<tr class="table-title">';
/********************sort field***********************/
if(!isset($order))    $order='id DESC';
if(!isset($sortcode)) $sortcode='1';
if(!isset($sortname)) $sortname='1';
if(!isset($sortLname)) $sortLname='1';
if(!isset($sortUsername)) $sortUsername='1';
if(!isset($sortRole)) $sortRole='1';
if(!isset($sortOstan)) $sortOstan='1';
if(!isset($show_img)) $show_img='';
	if($sortcode=='1')
	{echo'<td width="5%" title="مرتب سازی صعودی کد کاربر" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=user_id ASC&sortcode=2&show_img=1\'"/> کد کاربر ';
	  if($show_img=='1')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sortcode=='2')
	{echo'<td width="5%" title="مرتب سازی نزولی کد کاربر" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=user_id DESC&sortcode=1&show_img=1\'"/> کد کاربر ';
	  if($show_img=='1')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sortname=='1')
	{echo'<td width="8%" title="مرتب سازی صعودی نام" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=first_name ASC&sortname=2&show_img=2\'"/> نام  '; 
	  if($show_img=='2')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sortname=='2')
	{echo'<td width="8%" title="مرتب سازی نزولی نام " style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=first_name DESC&sortname=1&show_img=2\'"/> نام  '; 
	  if($show_img=='2')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sortLname=='1')
	{echo'<td width="17%" title="مرتب سازی صعودی نام خانوادگی" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=last_name ASC&sortLname=2&show_img=3\'"/> نام خانوادگی ';
	  if($show_img=='3')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sortLname=='2')
	{echo'<td width="17%" title="مرتب سازی نزولی نام خانوادگی" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=last_name DESC&sortLname=1&show_img=3\'"/> نام خانوادگی ';
	  if($show_img=='3')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sortUsername=='1')
	{echo'<td width="18%" title="مرتب سازی صعودی نام کاربری" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=user_name ASC&sortUsername=2&show_img=4\'"/> نام کاربری  ';
	  if($show_img=='4')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sortUsername=='2')
	{echo'<td width="18%" title="مرتب سازی نزولی نام کاربری" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=user_name DESC&sortUsername=1&show_img=4\'"/> نام کاربری  ';
	  if($show_img=='4')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
    if($sortRole=='1')
	{echo'<td width="10%" title="مرتب سازی صعودی گروه کاربر" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=role_id ASC&sortRole=2&show_img=5\'"/> نقش / گروه کاربر  ';
	  if($show_img=='5')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sortRole=='2')
	{echo'<td width="10%" title="مرتب سازی نزولی گروه کاربر" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=role_id DESC&sortRole=1&show_img=5\'"/> نقش / گروه کاربر  ';
	  if($show_img=='5')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sortOstan=='1')
	{echo'<td width="10%" title="مرتب سازی صعودی استان کاربر" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=nameOstan ASC&sortOstan=2&show_img=6\'"/> استان کاربر  ';
	  if($show_img=='6')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sortOstan=='2')
	{echo'<td width="10%" title="مرتب سازی نزولی استان کاربر" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=nameOstan DESC&sortOstan=1&show_img=6\'"/> استان کاربر  ';
	  if($show_img=='6')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	echo'
    <td width="6%">دسترسی به تمام استان ها</td>
	<td width="15%">سردخانه های قابل دسترسی</td>
	<td width="7%">تلفن همراه</td>';
	if($right_del) echo'<td width="3%">حذف</td>
	</tr>';
	$i=0;
	$q1="SELECT *,
		(SELECT count(*) FROM user_ostan_anbar u_o_a WHERE u_o_a.user_id=T.user_id AND u_o_a.code_ostan=T.code_ostan) detailcount,
	    (SELECT name_ostan FROM ostan WHERE ostan.code_ostan=T.code_ostan)nameOstan, 
	    (SELECT role_description FROM roles WHERE roles.role_id=T.role_id)roleDescription 
		From $TableName T WHERE 1=1 $condition ".$_SESSION['mt_search_users']." order by $order $Limit";
	$allUsers = $db->query($q1);
    //echo $q1;
	echo'
	<script>
	        screenWidth = screen.availWidth;
            //alert(screenWidth);
            elementLeft = (screenWidth - 500) /2 +"px";				
            elementLeft = (screen.availWidth - 500) /2 +"px";				
			//alert(elementLeft);
			var le =(screen.width-500)-/2;
			</script>';
	while($row1=$db->fetch_assoc($allUsers))
	{
     if ($right_edt){$edtClick='onClick="window.location=\''.$FileName.'?Mode=Edit&id_='.$row1['id'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'"';}	 
     if($i++%2)
     echo'
     <tr class="table-odd"/>';
     else echo '
     <tr class="table-even"/>';
     echo'
	  <td '.$edtClick.'>'.$row1['user_id'].'</td>
	  <td '.$edtClick.'>'.$row1['first_name'].'</td>
	  <td '.$edtClick.'>'.$row1['last_name'].'</td>
	  <td '.$edtClick.'>'.$row1['user_name'].'</td>
	  <td '.$edtClick.'>'.$row1['roleDescription'].'</td>
	  <td '.$edtClick.'>'.$row1['nameOstan'].'</td>
	  <td '.$edtClick.'>';if($row1['chkallostan'] == 1)echo $Confirm_icon;else echo $DontConfirm_icon; echo'</td>';
	  echo'
	  <td>';
       if($right_anbar)
	   {
	    echo'<input type="button"'; IF(($row1['detailcount']==0)and($row1['chkallostan'] == 0)) echo' class="button-inline buttonme-empty"'; else echo' class="button-inline"'; echo' value="سردخانه ها ['.$row1['detailcount'].']" onClick="window.popupwindow(\'user_list_anbar.php?c_ostan_='.$row1['code_ostan'].'&u_id_='.$row1['user_id'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\',\'_blank\',\'500\',\'500\')" >';
	   }
	  echo
	  '</td>
	  <td '.$edtClick.'>'.$row1['mobile'].'</td>';
	  if($right_del)
	  {
	  echo'<td><img border="0"  src="images/trash.png" width="20" height="20" title="حذف"
	       onmouseOver="this.src=\'images/trash_hover.png\'" 
		   onmouseOut="this.src=\'images/trash.png\'" 
		   onClick="iconfirm(\''.$FileName.'?Delete_x=1&id_='.$row1['id'].'&user_id_='.$row1['user_id'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\',\'برای حذف کاربر '.$row1['user_name'].' \')" /></td>';
	  }
	 echo '
	 </tr>';
	}
    for ($r=$i+1; $r<=$RowPerPage; $r++)
    {if($r%2) echo '
     <tr class="table-even">';
     else echo '
     <tr class="table-odd">';
     echo '
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>';
	  if($right_del) echo'<td>&nbsp;</td>';
	 echo'
	 </tr>';
	}
	echo'
   </table>
  </td>
 </tr> 
 <!--پايان مرکز صفحه -->';
 echo'
 <!-- فوتر-->
 <tr class="footer">
  <td>
   <table width="100%"  border="0" cellspacing="0" cellpadding="0" height=100%  style="margin-bottom:20px;">';
   if (!$Mode)
   {echo '	  			
	<tr>
     <td width="10">&nbsp;</td>';
	 IF(SuperUser())
	 {
	  echo'
	  <td width="24"><div onClick="window.open(\'print_users.php\',\'\',\'scrollbars=1\')" id="printer" title="چاپ"><a href="#"></a></div></td>
      <td width="10">&nbsp;</td>'; 
	 }
	 if($right_ins){
	 echo'<td width="70px"><div onClick="window.location=\''.$FileName.'?Mode=Insert&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-new" title="افزودن رکورد جديد" ><a href="#"></a></div></td>
 	 <td width="10px">&nbsp;</td>';}
	 echo'<td width="70px"><div onClick="window.location=\''.$FileName.'?Mode=Search&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-search" title="جستجو" ><a href="#"></a></div></td>
	 <td width="10px">&nbsp;</td>
	 <td width="70px"><div onClick="window.location=\'my_frame.php\'" id="btn-back" title="بازگشت به منوي اصلي"><a href="#"></a></div></td>
	 <td width="20px">&nbsp;</td>	   
	 <td width="22px"><div '.$En_Prev.' onClick="window.location=\''.$FileName.'?PageNo=1&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-pageone" title="رويت اولين صفحه"><a href="#"></a></div></td>
	 <td width="2px">&nbsp;</td>
	 <td width="22px"><div '.$En_Prev.' onClick="window.location=\''.$FileName.'?PageNo='.$PrevPage.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-perevius" title="رفتن به صفحه قبلي"><a href="#"></a></div></td>
	 <td width="2">&nbsp;</td>
	 <td width="40" align="center"><input type="text" name="PageNo" value="'.$PageNo.'" size="2" onChange="myform.submit()" onkeypress="return isNumber(event)" style="direction:ltr;text-align:center;"></td>		   
	 <td width="2">&nbsp;</td>
	 <td width="22px"><div '.$En_Next.' onClick="window.location=\''.$FileName.'?PageNo='.$NextPage.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-forward" title="رفتن به صفحه بعدي"><a href="#"></a></div></td>
     <td width="2px">&nbsp;</td>		   
	 <td width="22px"><div '.$En_Next.' onClick="window.location=\''.$FileName.'?PageNo='.$MaxPage.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-pageend" title="رويت آخرين صفحه"><a href="#" ></a></div></td>
	 <td width="2">&nbsp;</td>
	 <td width="65" align="left"><span class="text1">تعداد خط :</span></td>
	 <td align="right"><input type="text" name="wRowPerPage" value="'.$RowPerPage.'" size="2" onChange="myform.submit()"  onkeypress="return isNumber(event)" style="direction:ltr;text-align:center;"></td>	 
	 <td width="10">&nbsp;</td>';
     if ($_SESSION['mt_search_users']) 
	 echo '
	 <td width="70px"><input type="Button" class=buttonme  value="نمايش همه" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&open_filter=1\'"></td>';	 
	 echo'
     <td width="100px" style="color:#fff;" align="left"> تعداد ['.$cnt.']</td>
     <td width="10">&nbsp;</td> 	 
	</tr>';
    }
    if ($Mode=="Insert")  //Insert Mode
    {
	 $res_userID = $db->query("SELECT Max(user_id) FROM $TableName");
	 $row_userID= $db->fetch_array($res_userID);
	 $user_id=$row_userID[0];
	 $user_id++;
	echo '
    <tr> 
	 <td> 	 
	  <table class="footer-panel" width="99%" cellpadding="0" cellspacing="0" style="position:absolute;bottom:20px;">
       <tr class="title" ><td colspan="10" align="center">ايجاد کاربر جدید</td></tr>
       <tr><td colspan="10">&nbsp;</td></tr>	   
	   <tr>
	    <td align="left" width="10%"><span class="star">*</span> کد کاربر :&nbsp;</td><td align="right" width="20%"><input type="text" class="textboxme2" readonly name="user_id" value="'.$user_id.'" style="width:50px;"/></td>
		<td align="left" width="10%"><span class="star">*</span> نام :&nbsp;</td><td align="right"  width="10%"><input class="textboxme2" type="text" name="first_name" value="'.$first_name.'"/></td>
        <td align="left" width="10%"><span class="star">*</span>  نام خانوادگی :&nbsp;</td><td align="right" width="10%"><input class="textboxme" type="text" name="last_name" value="'.$last_name.'"/></td>
	    <td align="left"><span class="star">*</span> کد ملی : &nbsp;</td><td align="right" ><input type="text" class="textboxme2" name="national_id" value="'.$national_id.'"  maxlength="10"  onkeypress="return isNumber(event)" placeholder="0071234567"/></td>
	   </tr>
       <tr>	   
		<td align="left"><span class="star">*</span> نام کاربری :&nbsp;</td>
		<td align="right" colspan="3"><input class="textboxme2" type="text" name="user_name" value="'.$user_name.'" placeholder="حداقل 6 کاراکتر" onblur="validateUsernameIns(this.value)"/>
		 <span id="usernameError">&nbsp;</span>
		 <span style="font-style: italic;color:green">*(نام کاربری حداقل 6 کاراکتر - شامل حروف لاتین ، اعداد و کاراکترهای @ _ -)</span>
		</td>
       	<td align="left"><span class="star">*</span> رمز عبور :&nbsp;</td>
		<td align="right" colspan="3" width="10%"><input class="textboxme2" type="password" name="password" value="'.$password.'" placeholder="حداقل 8 کاراکتر" onblur="validatePass(this.value,document.myform.user_id.value)"/>
		 <span width="50px" id="passError">&nbsp;</span>
	     <span style="font-style: italic;color:green">*(رمز عبور حداقل 8 کاراکتر -شامل حروف بزرگ و کوچک لاتین و اعداد)</span>
		</td>
	   </tr>
	   <tr>
	    <td align="left" height=20px> پست الکترونیک  :&nbsp;</td><td align="right"><input class="textboxme" type="text" name="email" value="'.$email.'" placeholder="name@example.com"/></td>       
        <td align="left"> تلفن تماس :&nbsp;</td><td align="right"><input class="textboxme" type="text" name="tel" value="'.$tel.'" onkeypress="return isNumber(event)" placeholder="02188776655"/></td>
        <td align="left"><span class="star">*</span> تلفن همراه :&nbsp;</td><td align="right"><input class="textboxme" type="text" name="mobile" value="'.$mobile.'" onkeypress="return isNumber(event)" placeholder="09121234567"/></td>';	   
	    if($user_role_des=='ادمین استان')echo'<td align="left"><span class="star">*</span> نقش یا گروه کاربر :&nbsp;</td><td align="right" colspan="2">'.listbox("role_id",$role_id,"role_id","role_description","roles","1=1 and chk_adminsee=1 ORDER BY role_description","class='text4'").'</td>';	
	    else echo'<td align="left"><span class="star">*</span> نقش یا گروه کاربر :&nbsp;</td><td align="right" colspan="2">'.listbox("role_id",$role_id,"role_id","role_description","roles","1=1 ORDER BY role_description","class='text4'").'</td>';	
	   echo'
	   </tr>
       <tr>';
	   if($user_role_des!='ادمین استان') 
	   {echo'
		<td></td><td align="right" colspan="5">آیا این کاربر به تمام استان ها دسترسی داشته باشد ؟<input type="checkbox" name="chkallostan"/></td>
	    <td align="left" height=20px><span class="star">*</span> استان کاربر :&nbsp;</td><td colspan="3" align="right">'.listbox("code_ostan",$code_ostan,"code_ostan","name_ostan","ostan","1=1 ORDER BY ostan.name_ostan ASC","class='text4'","").'&nbsp;</td>';
		}
	  else echo'<input type="hidden" name="code_ostan" value='.$mt_gl_code_ostan.'/>';
	  //else echo'<td align="left" height=20px><span class="star">*</span> استان کاربر :&nbsp;</td><td colspan="3" align="right">'.listbox("code_ostan",$code_ostan,"code_ostan","name_ostan","ostan","1=1 $condition ORDER BY ostan.name_ostan ASC","class='text4'","").'&nbsp;</td>';
	  // echo' 
		// <!--dont use
		 // <td align="left" height=20px><span class="star">*</span> استان کاربر :&nbsp;</td><td colspan="3" align="right">'.listbox("code_ostan",$code_ostan,"code_ostan","name_ostan","ostan","1=1 ORDER BY ostan.name_ostan ASC","onchange=AnbarehayeOstan(this.value,$user_id,$PageNo) class='text4'","").'&nbsp;<span id="button_anbar"></span></td>	  
        // -->
// <!--<td align="left"><span class="star">*</span> استان کاربر :&nbsp;</td><td colspan="3" align="right">'.listbox("code_ostan",$code_ostan,"code_ostan","name_ostan","ostan","1=1","onchange=AnbarehayeOstan(this.value,$user_id,$PageNo) class='text4'","").'&nbsp;<span id="button_anbar"></span></td> -->
// <!--<td colspan="2" align="left"><input type="button" class="buttonme" id="button_anbar" name="button_anbar" value="انبارهای قابل دسترسی" onClick="window.open(\'user_list_anbar.php?pageMaster='.$PageNo.'&c_ostan_='.$row1['code_ostan'].'\',\'_blank\',\'width=400px\')"/></td>-->	  
// <!--<td align="left"><span class="star">*</span> کد انبار :&nbsp;</td><td align="right"><select name="code_anbar" id="code_anbar" class="text4"><option value="0">انتخاب کنيد</option></select></td>';
	  
	  echo'
       <tr>
	    <td align="left"><input type="checkbox" name="chkshowanbar" /></td><td align="right">&nbsp;  نمایش سردخانه های غیرفعال</td>
       </tr>	   
	   </tr>
	   <tr class="footer">
        <td colspan="10" align="center">
		 <input class="buttonme" type="submit" name="Insert_x" id="sabt" value="ثبت">
         <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'">
        </td>
       </tr>
      </table>
	 </td>
    </tr>';
    }
    if ($Mode=="Edit")//Edit Mode
    {
	 $q2="SELECT *,
	     (SELECT count(*) FROM user_ostan_anbar u_o_a WHERE u_o_a.user_id=T.user_id AND u_o_a.code_ostan=T.code_ostan) existAnbar
	      FROM $TableName T WHERE id='$id_'";
	 //$q2="SELECT *,DECODE(password,'xlsdj') password  FROM $TableName WHERE id='$id_'";
	 $res2=$db->query($q2);
	 $row2=$db->fetch_assoc($res2);
	 if($row2['chkallostan'] == 1) $checked = 'checked = "checked"';
     else $checked = '';
	 if($row2['chkshowanbar'] == 1) $anbar_checked = 'checked';
     else $anbar_checked = '';
	 /*اطلاعات انبارهای استان*/
	 // $q3="SELECT * FROM list_anbar WHERE code_anbar=".$row2['code_anbar']."";
     // $res3=$db->query($q3);
     // $row3=$db->fetch_assoc($res3);
	  $pass=decodePassword($row2['password']);
      $Segment1 = substr($pass, 0, 2);
      $Segment2 = substr($pass, 2, 2);
	  $Segment3 = substr($row2['user_name'], 2, 2);
	  $Segment4 = substr($pass, 4);
      $pass_string=$Segment1.$row2['user_id'].$Segment2.$Segment3.$Segment4;
	 echo'
     <tr> 
	  <td> 	 
	   <table class="footer-panel" width="99%" cellpadding="0" cellspacing="0" style="position:absolute;bottom:20px;">
        <tr class="title"><td colspan="10" align="center">ويرايش '.$row2['user_name'].'</td></tr>
        <tr><td>&nbsp;</td></tr>	   
		<tr>
	     <td align="left" width="10%"><span class="star">*</span> کد کاربر  :&nbsp;</td><td align="right" width="20%"><input class="textboxme2" type="text" readonly name="user_id" value="'.$row2['user_id'].'" style="width:50px;"/></td>
		 <td align="left" width="10%"><span class="star">*</span> نام :&nbsp;</td><td align="right" width="10%"><input class="textboxme2" type="text" name="first_name" value="'.$row2['first_name'].'" /></td>
         <td align="left" width="10%"><span class="star">*</span> نام خانوادگی :&nbsp;</td><td align="right" width="10%"><input class="textboxme" type="text" name="last_name" value="'.$row2['last_name'].'"/></td>
         <td align="left"><span class="star">*</span> کد ملی : &nbsp;</td><td align="right"><input type="text" class="textboxme2" name="national_id" value="'.$row2['national_id'].'"  maxlength="10"  onkeypress="return isNumber(event)" placeholder="0071234567"/></td>
		</tr>
        <tr>		
		 <td align="left"><span class="star">*</span> نام کاربری :&nbsp;</td>
		 <td align="right" colspan="3"><input class="textboxme2" type="text" name="user_name" value="'.$row2['user_name'].'" onblur="validateUsernameEdt(this.value,document.myform.user_id.value)"/>
		 <span id="usernameError">&nbsp;</span>
		  <span style="font-style: italic;color:green">*(نام کاربری حداقل 6 کاراکتر - شامل حروف لاتین ، اعداد و کاراکترهای @ _ -)</span>
		 </td>';
		 IF(SuperUser())
		 {
		  echo'
		  <td align="left" ><span class="star">*</span> رمز عبور :&nbsp;</td>
		  <td align="right" colspan="3"><input class="textboxme2" type="password" name="password" value="'.decodePassword($row2['password']).'" onblur="validatePass(this.value,document.myform.user_id.value)"/>
		   <span width="50px" id="passError">&nbsp;</span>
	       <span style="font-style: italic;color:green" title="'.($pass_string).'" >*(رمز عبور حداقل 8 کاراکتر -شامل حروف بزرگ و کوچک لاتین و اعداد)</span>	
		  </td>';
		 }
		 ELSE 
			 echo'<input class="textboxme2" type="hidden" name="password" value="'.decodePassword($row2['password']).'" onblur="validatePass(this.value,document.myform.user_id.value)"/>';
		 echo'
		</tr>
		<tr>
		 <td align="left"';  echo' > پست الکترونیک  :&nbsp;</td><td align="right"><input class="textboxme" type="text" name="email" value="'.$row2['email'].'" placeholder="name@example.com"/></td>       
         <td align="left"> تلفن تماس :&nbsp;</td><td align="right"><input class="textboxme" type="text" name="tel" value="'.$row2['tel'].'" onkeypress="return isNumber(event)" placeholder="02188776655"/></td>
	     <td align="left"><span class="star">*</span> تلفن همراه :&nbsp;</td><td align="right"><input class="textboxme" type="text" name="mobile" value="'.$row2['mobile'].'" onkeypress="return isNumber(event)" placeholder="09121234567"/></td>';	   		
		 if($right_role)
		 {
		  if($user_role_des=='ادمین استان')
		   echo'<td align="left"><span class="star">*</span> نقش یا گروه کاربر :&nbsp;</td><td align="right" colspan="2">'.listbox("role_id",$row2['role_id'],"role_id","role_description","roles","1=1 and chk_adminsee=1 ORDER BY role_description","class='text4'").'</td>';
		  else
		  echo'<td align="left"><span class="star">*</span> نقش یا گروه کاربر :&nbsp;</td><td align="right" colspan="2">'.listbox("role_id",$row2['role_id'],"role_id","role_description","roles","1=1 ORDER BY role_description","class='text4'").'</td>';	
         }
		 else  echo'<input type="hidden" name="role_id" value="'.$row2['role_id'].'"/>';	
		echo'
		</tr>		
		<tr>';
		if($user_role_des!='ادمین استان') echo'<td></td><td align="right" colspan="5">آیا این کاربر به تمام استان ها دسترسی داشته باشد ؟<input type="checkbox" name="chkallostan" '.$checked.'/></td>';
		if(($right_ostan)and($user_role_des!='ادمین استان'))
		{
		 if($row2['existAnbar']) {echo'<td align="left"><span class="star">*</span> استان کاربر :&nbsp;</td><td colspan="3" align="right"><input type="hidden" name="code_ostan" value="'.$row2['code_ostan'].'"/>'.listbox("code_ostan",$row2['code_ostan'],"code_ostan","name_ostan","ostan","1=1 ORDER BY ostan.name_ostan ASC","disabled class='text4'","").'&nbsp;</td>';}
		 else echo'<td align="left" height=20px><span class="star">*</span> استان کاربر :&nbsp;</td><td colspan="3" align="right">'.listbox("code_ostan",$row2['code_ostan'],"code_ostan","name_ostan","ostan","1=1 ORDER BY ostan.name_ostan ASC","class='text4'","").'&nbsp;</td>';
		 //dont use
		 //<td align="left"><span class="star">*</span> کد استان :&nbsp;</td><td colspan="3" align="right">'.listbox("code_ostan",$row2['code_ostan'],"code_ostan","name_ostan","ostan","1=1 ORDER BY ostan.name_ostan ASC","onchange=AnbarehayeOstan(this.value,".$row2['user_id'].",$PageNo) class='text4'","").'&nbsp;
		 //$nameOstan=$db->get_from_where("name_ostan","ostan","code_ostan=".$row2['code_ostan']."");
         //if($right_anbar) echo'<span id="button_anbar"><input type="button" class="buttonme" name="button_anbar" value="انبارهای استان '.$nameOstan.'" onClick="window.open(\'user_list_anbar.php?pageMaster='.$PageNo.'&c_ostan_='.$row2['code_ostan'].'&u_id_='.$row2['user_id'].'\',\'_blank\',\'width=500px\')"/></span>';
		}
		else
		{echo'<input type="hidden" name="code_ostan" value="'.$row2['code_ostan'].'"/>';}
		echo'
		</tr>
		<tr>
		 <td align="left"><input type="checkbox" name="chkshowanbar" '.$anbar_checked.' /></td><td align="right">&nbsp; نمایش سردخانه های غیرفعال</td>
        </tr> 
	    <tr class="footer">
         <td colspan="10" align="center">
		  <input class="buttonme" type="submit" name="Edit_x" id="sabt" value="ثبت تغييرات">
          <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'">
         </td>
        </tr>
       </table>
	  </td>
     </tr>';
    }
	if ($Mode=="Search") //Search Mode
    {echo '
    <tr> 
	 <td> 	 
	  <table class="footer-panel" width="99%" cellpadding="0" cellspacing="0" style="position:absolute;bottom:20px;">
       <tr class="title"><td colspan="10" align="center">جستجوی کاربر</td></tr>
       <tr><td>&nbsp;</td></tr>	   
	   <tr>
	    <td align="left"> کد کاربر :&nbsp;</td><td align="right"><input type="text" class="textboxme2" name="user_id" value="'.$user_id.'" style="width:50px;"/></td>
		<td align="left"> نام :&nbsp;</td><td align="right"><input class="textboxme2" type="text" name="first_name" value="'.$first_name.'"/></td>
        <td align="left"> نام خانوادگی :&nbsp;</td><td align="right"><input class="textboxme" type="text" name="last_name" value="'.$last_name.'"/></td>
	    <td align="left"> نام کاربری :&nbsp;</td><td align="right"><input class="textboxme2" type="text" name="user_name" value="'.$user_name.'"/></td>
       	<!--<td align="left"> رمز عبور :&nbsp;</td><td align="right"><input class="textboxme2" type="text" name="password" value="'.$password.'"/></td>-->
	   </tr>
       <tr>
        <td align="left"> پست الکترونیک  :&nbsp;</td><td align="right"><input class="textboxme" type="text" name="email" value="'.$email.'"/></td>       
        <td align="left"> تلفن تماس :&nbsp;</td><td align="right"><input class="textboxme" type="text" name="tel" value="'.$tel.'" onkeypress="return isNumber(event)"/></td>
        <td align="left"> تلفن همراه :&nbsp;</td><td align="right"><input class="textboxme" type="text" name="mobile" value="'.$mobile.'" onkeypress="return isNumber(event)"/></td>
	   </tr>
       <tr>';	   
	   if($user_role_des=='ادمین استان')
		echo'<td align="left"><span class="star">*</span> نقش یا گروه کاربر :&nbsp;</td><td align="right" colspan="2">'.listbox("role_id_search",$role_id_search,"role_id","role_description","roles","1=1 and chk_adminsee=1 ORDER BY role_description","class='text4'").'</td>';
	   else
	   {echo'
	   	<td align="left"> استان :&nbsp;</td><td colspan="3" align="right">'.listbox("code_ostan",$code_ostan,"code_ostan","name_ostan","ostan","1=1 ORDER BY ostan.name_ostan ASC","onchange=AnbarehayeOstan(this.value,$user_id,$PageNo) class='text4'","").'&nbsp;<span id="button_anbar"></span></td>
	    <td align="left"> نقش یا گروه کاربر :&nbsp;</td><td align="right" colspan="2">'.listbox("role_id_search",$role_id_search,"role_id","role_description","roles","1=1 ORDER BY role_description","class='text4'").'</td>';
	   }
	   echo'
	   </tr>
	   <tr class="footer"> 
        <td colspan="10" align="center">
		 <input class="buttonme" type="submit" name="Search_x" id="sabt" value="جستجو" >
         <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'">
        </td>
       </tr>
      </table>
	 </td>
    </tr>';
    }	
   echo'
   </table>
  </td>
 </tr>
 <!-- پايان فوتر-->';
echo'	
</table>
</div>
 '.$message.'
</form>
</body>
</html>';	
?>