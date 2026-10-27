<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="karton.php";
$TableName="karton";
$logtime=date('H:i:s');
$right_ins=0;$right_edt=0;$right_del=0;
if (right(40)) $right_ins=1;
if (right(41)) $right_edt=1;
if (right(42)) $right_del=1;
echo'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" />
<html xmlns="http://www.w3.org/1999/xhtml" dir=rtl>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>جدول نوع کارتن/قوطی</title>
<link href="styles.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="functions.js"></script>
<script type="text/javascript" src="scripts/jquery-1.6.2.min.js"></script>
<script type="text/javascript">
 function enterIE()
 {
   if(window.event.keyCode == 13 && window.event.srcElement.id != \'sabt\')
   window.event.keyCode = 9;
 }
</script>
</head>';
if(!(isset($Mode))) $Mode='';
/*************SEARCH BUTTON******/// جستجوي اطلاعات
if(isset($open_filter))
{ $open_filter="";
  $_SESSION['search_karton']="";
} 
if(isset($Search_x))
{
 $Mode="";
 $Search_x=""; 
 $temp="";
 if($code_bastebandy)  $temp.=" and code_bastebandy LIKE '%$code_bastebandy%'";
 if($code_karton)      $temp.=" and code_karton LIKE '%$code_karton%'";
 if($sharh_karton)     $temp.=" and sharh_karton LIKE '%$sharh_karton%'";
 if($vazn_karton)      $temp.=" and vazn_karton LIKE '%$vazn_karton%'";
 if ($temp) {$PageNo=1;$_SESSION['search_karton']=$temp;} else $_SESSION['search_karton']="";
}
/********************PAGING***********************/
if(isset($_POST['wRowPerPage'])) $RowPerPage=$_POST['wRowPerPage'];
if(!isset($RowPerPage)) $RowPerPage=8;
$res = $db->query("SELECT COUNT(*) FROM $TableName where 1=1 ".$_SESSION['search_karton']." AND code_ostan=$mt_gl_code_ostan");
$row = $db->fetch_array($res);
$cnt = $row[0];
$MaxPage=intval($cnt/$RowPerPage);
if ($cnt%$RowPerPage) $MaxPage++;
if (!$MaxPage) $MaxPage=1;
if (!isset($PageNo)) $PageNo=1;//$PageNo=$MaxPage; 
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
function isPermitSave($gl_c_o,$c_baste,$c_karton,$sharh,$vazn)
{
 $flag=false;
 if((!$gl_c_o) or ($gl_c_o==-1))//اگر سشن استان خالی بود
 {   
    $flag=false;
    echo"<script> alert('لطفاً استان مورد نظر خود را از پایین صفحه انتخاب کنید!')</script>";
    return $flag;
 }
 else $flag=true; 
 if(!($c_baste and $c_karton and $sharh))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script> alert('لطفا تمام فيلد ها را تکميل نماييد')</script>";
   return $flag;
 } 
 else $flag=true;
 if (!justNumber($c_karton))//عدد بودن کد کارتن
 {
   $flag=false;
   echo"<script>alert('فيلد کد کارتن نامعتبر است!')</script>";
   return $flag;
 }
 else $flag=true; 
 if(!empty($c_karton))//تکراری نبودن کد برای هر استان 
 { 
   $q8="SELECT code_karton FROM karton WHERE code_karton=TRIM($c_karton) AND code_ostan=$gl_c_o";
   $res8=mysql_query($q8);
   if(mysql_num_rows($res8)>0){
   echo"<script>alert('اين کد کارتن قبلاً ثبت شده است !')</script>";
   $flag=false;
   return $flag;
  }
 else $flag=true;
 }
 else $flag=true;
 if(!empty($sharh))//تکراری نبودن شرح کارتن و وزن برای هر استان
 {
   $q9="SELECT * FROM karton WHERE sharh_karton='$sharh' AND CAST(vazn_karton AS decimal(6,3))='$vazn' AND code_ostan='$gl_c_o'";
   $res9=mysql_query($q9);
   if(mysql_num_rows($res9)>0){
     echo"<script>alert('اين شرح کارتن با این وزن قبلاً ثبت شده است !')</script>";
     $flag=false;
     return $flag;
  }
 else $flag=true;
 }
 else $flag=true;
 if(!empty($sharh))//تکراری نبودن وزن کارتن
 {
   $q10="SELECT * FROM karton WHERE CAST(vazn_karton AS decimal(6,3))='$vazn' AND code_ostan='$gl_c_o'";
   $res10=mysql_query($q10);
   if(mysql_num_rows($res10)>0){
     echo"<script>alert('اين وزن کارتن قبلاً ثبت شده است !')</script>";
     $flag=false;
     return $flag;
  }
 else $flag=true;
 }
else $flag=true;
return $flag;
}
/**********اجازه براي ويرايش اطلاعات********/
function isPermitEdit($gl_c_o,$c_baste,$c_karton,$sharh,$vazn,$this_id)
{
  $flag=false;
  if((!$gl_c_o) or ($gl_c_o==-1))//اگر سشن استان خالی بود
  {   
    $flag=false;
    echo"<script> alert('لطفاً استان مورد نظر خود را از پایین صفحه انتخاب کنید!')</script>";
    return $flag;
  }
  else $flag=true; 
  if(!($c_baste and $c_karton and $sharh))//پر بودن فيلدها
  {
   $flag=false;
   echo"<script> alert('لطفا تمام فيلد ها را تکميل نماييد')</script>";
   return $flag;
  } 
  else $flag=true;
  if (!justNumber($c_karton))//عدد بودن کد کارتن
  {
   $flag=false;
   echo"<script>alert('فيلد کد کارتن نامعتبر است !')</script>";
   return $flag;
  }
  else $flag=true;
  if(!empty($c_karton))//تکراری نبودن کد برای هر استان 
  { 
   $q10="SELECT * FROM karton WHERE code_karton=TRIM($c_karton) AND code_ostan=$gl_c_o";
   $res10=mysql_query($q10);
   $row10=mysql_fetch_assoc($res10);
   if((mysql_num_rows($res10)>0) and ($row10['id']!=$this_id)){
   echo"<script>alert('اين کد کارتن قبلاً ثبت شده است !')</script>";
   $flag=false;
   return $flag;
  }
  else $flag=true;
  }
  else $flag=true;
  if(!empty($sharh))//تکراری نبودن شرح کارتن برای هر استان
  {
    $q11="SELECT * FROM karton WHERE sharh_karton=TRIM('$sharh') AND CAST(vazn_karton AS decimal(6,3))=$vazn AND code_ostan=$gl_c_o";
    $res11=mysql_query($q11);
	$row11=mysql_fetch_assoc($res11);	
    if((mysql_num_rows($res11)>0) and ($row11['id']!=$this_id)){
     echo"<script>alert('اين شرح کارتن با این وزن قبلاً ثبت شده است !')</script>";
      $flag=false;
      return $flag;
    }
    else $flag=true;
  }
 else $flag=true;
 if(!empty($sharh))//تکراری نبودن وزن کارتن
 {
    $q12="SELECT * FROM karton WHERE CAST(vazn_karton AS decimal(6,3))=$vazn AND code_ostan=$gl_c_o";
    $res12=mysql_query($q12);
	$row12=mysql_fetch_assoc($res12);	
    if((mysql_num_rows($res12)>0) and ($row12['id']!=$this_id)){
      echo"<script>alert('اين وزن کارتن قبلاً ثبت شده است  !')</script>";
      $flag=false;
      return $flag;
    }
    else $flag=true;
 }
 else $flag=true;
 return $flag;
}
/*************INSERT BUTTON******/// ثبت اطلاعات    
if(isset($Insert_x))
{ 
 if(isPermitSave($mt_gl_code_ostan,$code_bastebandy,$code_karton,$sharh_karton,$vazn_karton)) 
 {
  $Mode='';
  $sharh_karton=str_replace("ي","ی",$sharh_karton);
  $sharh_karton=str_replace("ك","ک",$sharh_karton);
  $insert_q=("INSERT INTO $TableName(code_ostan,code_bastebandy,code_karton,sharh_karton,vazn_karton)VALUES('$mt_gl_code_ostan','$code_bastebandy',TRIM('$code_karton'),TRIM('$sharh_karton'),TRIM($vazn_karton))");
  $insert_res=mysql_query($insert_q);
  if($insert_res){
    $max_id=$db->get_from_where("Max(id)","$TableName","code_ostan='$mt_gl_code_ostan'"); 
    $log_i=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$max_id','ثبت',".($yymmdd).",'$logtime')");
  }
  else  $message ='<span style="color:red;font: bold 12px tahoma;"> *مشکلی در ثبت کارتن به وجود آمده است! *</span>';  
 }
}
/************EDIT BUTTON********/// اصلاح اطلاعات
if (isset($Edit_x))
{
 if(isPermitEdit($mt_gl_code_ostan,$code_bastebandy,$code_karton,$sharh_karton,$vazn_karton,$id_))
 {
  $Mode='';
  $sharh_karton=str_replace("ي","ی",$sharh_karton);
  $sharh_karton=str_replace("ك","ک",$sharh_karton);
  $edit_q=("UPDATE $TableName SET code_bastebandy='$code_bastebandy',code_karton=TRIM('$code_karton'),sharh_karton=TRIM('$sharh_karton'),vazn_karton=TRIM('$vazn_karton') WHERE id='$id_';");
  $edit_res=mysql_query($edit_q);
  if(($edit_res) and (mysql_affected_rows()!=0)) $log_e=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_','ویرایش',".($yymmdd).",'$logtime')");
  else if(mysql_affected_rows()==0) $message='';
  else $message ='<span style=" color:red;font: bold 12px tahoma;"> * مشکلی در ویرایش مشخصات به وجود آمده است ! *</span>';
 } 
}
/************DELETE BUTTON********/// حذف اطلاعات
if (isset($Delete_x))
{
 $Mode='';
 $del_q="DELETE FROM $TableName WHERE id=$id_ AND
		($code_karton_ NOT IN(SELECT code_karton FROM mojody_kala WHERE code_karton=$code_karton_ AND code_ostan=$mt_gl_code_ostan AND deleted=0))AND
		($code_karton_ NOT IN (SELECT code_kala FROM havale_detail WHERE code_karton=$code_karton_ AND code_ostan=$mt_gl_code_ostan AND havale_deleted=0))AND
		($code_karton_ NOT IN (SELECT code_kala FROM resid_kala_detail WHERE code_karton=$code_karton_ AND code_ostan=$mt_gl_code_ostan AND resid_deleted=0))AND
		($code_karton_ NOT IN (SELECT code_kala FROM tadil_mojody WHERE code_karton=$code_karton_ AND code_ostan=$mt_gl_code_ostan AND deleted=0))";
 $del_res = $db->query($del_q,'مشکلي در حذف به وجود آمده است');
 if(mysql_affected_rows()==0)
   echo"<script>alert('این عنوان در سایر فرم ها استفاده شده است،شما مجاز به حذف آن نیستید!')</script>";
 else if($del_res)
  $log_d=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_','حذف',".($yymmdd).",'$logtime')");//کوئری لاگ 
} 
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.code_bastebandy.focus();">
<form method="post" name="myform" id="myform" onkeydown="enterIE()">
<div align="center">
<table width="90%" height="90%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr>
  <td class="title">
   <div style="position:absolute;top:5px;left:48%;">جدول نوع کارتن / قوطی</div>
   <div class="pagecover">[صفحه:&nbsp'.$PageNo.' از '.$MaxPage.']</div>
  </td> 
 </tr>
 <!--پايان هدر-->
 <!-- مرکز صفحه-->
 <tr>
  <td height="100%">
  <div style="float:right;width:100%;margin:0px;height:100%;overflow:auto;overflow-x:hidden;">
  <table  width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
	<tr class="table-title">';
/********************sort field***********************/
if(!isset($order))    $order='id DESC';
if(!isset($sortcode)) $sortcode='1';
if(!isset($sortname)) $sortname='1';
if(!isset($show_img)) $show_img='';
	echo'<td width="20%"> نوع بسته بندی </td>';
	if($sortcode=='1')
	{echo'<td width="10%" title="مرتب سازی صعودی کد" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=code_karton ASC&sortcode=2&show_img=1\'"/> کد ';
	  if($show_img=='1')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sortcode=='2')
	{echo'<td width="10%" title="مرتب سازی نزولی کد" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=code_karton DESC&sortcode=1&show_img=1\'"/> کد ';
	  if($show_img=='1')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sortname=='1')
	{echo'<td width="30%" title="مرتب سازی صعودی شرح" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=sharh_karton ASC&sortname=2&show_img=2\'"/> شرح '; 
	  if($show_img=='2')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sortname=='2')
	{echo'<td width="30%" title="مرتب سازی نزولی شرح " style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=sharh_karton DESC&sortname=1&show_img=2\'"/> شرح '; 
	  if($show_img=='2')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}	
	echo'
	<td width="25%">وزن</td>';
	if(($right_del)and($Mode==NULL)) echo'<td width="15%">حذف</td>';
    else if($Mode!=NULL) echo'<td width="15%">دستورات</td>';
	echo'
	</tr>';
	if($Mode=='Insert' or $Mode=='Search')
	{
	 if ($Mode=='Insert') {$button_value="ايجاد"; $button_name="Insert_x";} 
	 else {$button_value="جستجو"; $button_name="Search_x";}
	  echo'
	  <tr class="table-odd">
       <td>'.listbox("code_bastebandy",$code_bastebandy,"code_bastebandy","sharh_bastebandy","bastebandy","1=1 ORDER BY sharh_bastebandy ASC","class='text4' onchange=myform.submit()","").'</td>
	   <td><input type="text" class="textboxme2" name="code_karton" value="'.$code_karton.'" onkeypress="return isNumber(event)" style="width:50px"/></td>
	   <td><input type="text" class="textboxme" name="sharh_karton" value="'.$sharh_karton.'" /></td>
	   <td><input type="text" class="textboxme2" name="vazn_karton" value="'.$vazn_karton.'" onKeydown="return PressfloatOnly(event,this)" /> (کیلوگرم)</td>
	   <td><input type="submit" class="buttonme" name="'.$button_name.'" id="sabt" value="'.$button_value.'"/>
		   <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" />
	   </td>
	  </tr>';
	}
	$i=0;
	$q1="SELECT *,(SELECT sharh_bastebandy FROM bastebandy WHERE bastebandy.code_bastebandy=$TableName.code_bastebandy)sharhBastebandy
	From $TableName WHERE 1=1 ".$_SESSION['search_karton']." AND code_ostan=$mt_gl_code_ostan order by $order $Limit ";
	$allKeshty = $db->query($q1);
    while($row1=$db->fetch_assoc($allKeshty))
	{
     if($right_edt){$edtClick='onClick="window.location=\''.$FileName.'?Mode=Edit&id_='.$row1['id'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'"';}	 
     if($i++%2)
     echo'
     <tr class="table-odd"/>';
     else echo '
     <tr class="table-even"/>';
	 if($Mode=='Edit' and $row1['id']==$id_)
	 {
	  echo'<td>'.listbox("code_bastebandy",$row1['code_bastebandy'],"code_bastebandy","sharh_bastebandy","bastebandy","1=1 ORDER BY sharh_bastebandy ASC","class='text4' onchange=myform.submit()","").'</td>';
	  $exist_mojody=$db->get_from_where("count(code_karton)","mojody_kala","code_karton='".$row1['code_karton']."' AND code_ostan='$mt_gl_code_ostan' AND deleted=0");
	  $exist_resid_kala_detail=$db->get_from_where("count(code_karton)","resid_kala_detail","code_karton=".$row1['code_karton']." AND code_ostan='$mt_gl_code_ostan' AND resid_deleted=0");
	  $exist_havale_detail=$db->get_from_where("count(code_karton)","havale_detail","code_karton=".$row1['code_karton']." AND code_ostan='$mt_gl_code_ostan' AND havale_deleted=0");
	  $exist_tadil=$db->get_from_where("count(code_karton)","tadil_mojody","code_karton=".$row1['code_karton']." AND code_ostan='$mt_gl_code_ostan' AND deleted=0");
	  if(($exist_mojody)or($exist_resid_kala_detail)or($exist_havale_detail)or($exist_tadil)) echo'<td><input type="text" class="textboxme2" title="غیر قابل تغییر" name="code_karton" readonly value="'.$row1['code_karton'].'" style="width:50px;cursor:pointer;"/> <img border="0" src="images/readonly.png" title="غیر قابل تغییر" class="dontchange"/></td>';
      else echo'<td><input type="text" class="textboxme2" name="code_karton" value="'.$row1['code_karton'].'" maxlength="5" onkeypress="return isNumber(event)" style="width:50px"/></td>';
	  echo'
	  <td><input type="text" class="textboxme" name="sharh_karton" value="'.$row1['sharh_karton'].'"/></td>';
	  if(($exist_mojody)or($exist_resid_kala_detail)or($exist_havale_detail)or($exist_tadil)) echo'<td><input type="text" class="textboxme2" name="vazn_karton" value="'.$row1['vazn_karton'].'" readonly onKeydown="return PressfloatOnly(event,this)"/>  (کیلوگرم)</td>';
	  else echo'<td><input type="text" class="textboxme2" name="vazn_karton" value="'.$row1['vazn_karton'].'" onKeydown="return PressfloatOnly(event,this)"/>  (کیلوگرم)</td>';
	  echo'
	  <td>
	   <input class="buttonme" type="submit" name="Edit_x" id="sabt" value="ثبت تغييرات"/>
	   <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'"/>
	  </td>';
	 }
     else
     {echo'
	  <td '.$edtClick.'>'.$row1['sharhBastebandy'].'</td>
	  <td '.$edtClick.'>'.$row1['code_karton'].'</td>
	  <td '.$edtClick.'>'.$row1['sharh_karton'].'</td>
	  <td '.$edtClick.'>'.$row1['vazn_karton'].'</td>';
	  if($right_del)
	  {echo'<td><img border="0" src="images/trash.png" width="20" height="20" title="حذف"
	       onmouseOver="this.src=\'images/trash_hover.png\'" 
		   onmouseOut="this.src=\'images/trash.png\'" 	  
	       onClick="iconfirm(\''.$FileName.'?Delete_x=1&id_='.$row1['id'].'&code_karton_='.$row1['code_karton'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\',\'براي حذف کارتن  '.$row1['sharh_karton'].' \')"/></td>';
	  }
	  else if($Mode!=NULL)echo'<td>&nbsp;</td>';
	  else echo'';
	 }
	echo '
	</tr>';
	}
    for ($r=$i+1; $r<=$RowPerPage; $r++)
    {if($r%2) echo'
     <tr class="table-even">';
     else echo '
     <tr class="table-odd">';
     echo '
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
	  <td>&nbsp;</td>';
	  if($right_del) echo'<td>&nbsp;</td>';
	  else if($Mode!=NULL)echo'<td>&nbsp;</td>';
	  else echo'';
	  echo'
	 </tr>';
	}
	echo'
   </table>
   </div>
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
	 <td width="10">&nbsp;</td>
	 <td width="24"><div onClick="window.open(\'print_karton.php\',\'_blank\',\'width=820px,scrollbars=1\')" id="printer" title="چاپ"><a href="#"></a></div></td>
     <td width="10">&nbsp;</td>';
	 if($right_ins){
	 echo'<td width="70"><div onClick="window.location=\''.$FileName.'?Mode=Insert&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-new" title="افزودن رکورد جديد" ><a href="#"></a></div></td>
 	 <td width="10">&nbsp;</td>';}
	 echo'<td width="70"><div onClick="window.location=\''.$FileName.'?Mode=Search&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-search" title="جستجو" ><a href="#"></a></div></td>
	 <td width="10">&nbsp;</td>
	 <td width="70"><div onClick="window.location=\'my_frame.php\'" id="btn-back"   title="بازگشت به منوی اصلی"  ><a href="#"></a></div></td> 
	 <td width="20">&nbsp;</td>	   
	 <td width="22"><div '.$En_Prev.' onClick="window.location=\''.$FileName.'?PageNo=1&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-pageone" title="رويت اولين صفحه"><a href="#"></a></div></td>
	 <td width="2">&nbsp;</td>
	 <td width="22"><div '.$En_Prev.' onClick="window.location=\''.$FileName.'?PageNo='.$PrevPage.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-perevius" title="رفتن به صفحه قبلي"><a href="#"></a></div></td>
     <td width="2">&nbsp;</td>
	 <td width="40" align="center"><input type="text" name="PageNo" value="'.$PageNo.'" size="2" onChange="myform.submit()" onkeypress="return isNumber(event)" style="direction:ltr;text-align:center;"></td>		   
	 <td width="2">&nbsp;</td> 		   
	 <td width="22"><div '.$En_Next.' onClick="window.location=\''.$FileName.'?PageNo='.$NextPage.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-forward" title="رفتن به صفحه بعدي"><a href="#"></a></div></td>
     <td width="2">&nbsp;</td>		   
	 <td width="22"><div '.$En_Next.' onClick="window.location=\''.$FileName.'?PageNo='.$MaxPage.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-pageend" title="رويت آخرين صفحه"><a href="#" ></a></div></td>
	 <td width="2">&nbsp;</td>
	 <td width="65" align="left"><span class="text1">تعداد خط :</span></td>
	 <td align="right"><input type="text" name="wRowPerPage" value="'.$RowPerPage.'" size="2" onChange="myform.submit()" onkeypress="return isNumber(event)" style="direction:ltr;text-align:center;"></td>	 
	 <td width="10">&nbsp;</td>';
     if ($_SESSION['search_karton']) 
	 echo '
	 <td width="70"><input type="Button" class=buttonme  value="نمايش همه" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&open_filter=1\'"></td>';	 
	 echo'
     <td width="100px" style="color:#fff;" align="left"> تعداد ['.$cnt.']</td>
     <td width="10">&nbsp;</td>		 
	</tr>';
    }	
   echo'
   </table>
  </td>
 </tr>
 <!-- پايان فوتر-->	
</table>
</div>
'.$message .'
</form>
</body>
</html>';	
?>