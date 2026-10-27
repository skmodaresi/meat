<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="list_sardkhane_detail.php";
$TableName="list_sardkhane_detail";
//$logtime=date('H:i:s');
$right_ins=0;$right_edt=0;$right_del=0;
if (right(15)) $right_ins=1;
if (right(16)) $right_edt=1;
if (right(17)) $right_del=1;
$titr='جزئیات سردخانه';
echo'
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>'.$titr.'</title>
<link href="styles.css" rel="stylesheet" type="text/css"/>
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
// خواندن اطلاعات جدول سردخانه ها
$q_master=$db->query("SELECT * FROM list_sardkhane WHERE code_ostan='$code_ostan_' AND code_anbar='$code_anbar_'");
$result_master=$db->fetch_array($q_master);
$message='';
if(!(isset($Mode))) $Mode='';
/*************SEARCH BUTTON******/// جستجوي اطلاعات
if(isset($open_filter))
{ $open_filter="";
  $_SESSION['mt_search_anbar_det']="";
} 
if(isset($Search_x))
{
 $Mode='';
 $Search_x=""; 
 $temp="";
 if($code_ziranbar)   $temp.=" AND code_ziranbar LIKE '%$code_ziranbar%'";
 if($name_ziranbar)   $temp.=" AND name_ziranbar LIKE '%$name_ziranbar%'";
 if($noe_ziranbar)    $temp.=" AND noe_ziranbar LIKE '$noe_ziranbar'";
 if($zarfiyat_detail) $temp.=" AND zarfiyat_detail LIKE '%$zarfiyat_detail%'";
 if($temp) {
 $PageNo_detail=1;
 $_SESSION['mt_search_anbar_det']=$temp;} else $_SESSION['mt_search_anbar_det']="";
}
/********************PAGING***********************/
if(isset($_POST['wRowPerPage'])) $RowPerPage=$_POST['wRowPerPage'];
if(!isset($RowPerPage)) $RowPerPage=8;
$res = $db->query("SELECT COUNT(*) FROM $TableName WHERE code_ostan='$code_ostan_' AND code_anbar='$code_anbar_' ".$_SESSION['mt_search_anbar_det']."");
$row = $db->fetch_array($res);
$cnt = $row[0];
$MaxPage=intval($cnt/$RowPerPage);
if ($cnt%$RowPerPage) $MaxPage++;
if (!$MaxPage) $MaxPage=1;
if (!isset($PageNo_detail)) $PageNo_detail=1; //$PageNo_detail=$MaxPage;   
$NextPage=$PageNo_detail+1;
$PrevPage=$PageNo_detail-1;
if (!$cnt)
 {$En_Prev="Disabled";$En_Next="Disabled";}
else
 {$En_Prev="";$En_Next="";}
if ($PageNo_detail==$MaxPage) $En_Next="onclick=\'return false;\'";
if ($PageNo_detail==1) $En_Prev="onclick=\'return false;\'";
$FirstRow=$PrevPage*$RowPerPage;
if ($FirstRow<0) $FirstRow=0;
$Limit="Limit ".$FirstRow.",".$RowPerPage; 
/******************** Insert- Edit- Delete ************/
/************DELETE BUTTON********/// حذف اطلاعات
if (isset($Delete_x))
{
 $Mode=''; 
 $del_q ="DELETE FROM $TableName WHERE id=$id_ AND
          ($code_ziranbar_ NOT IN (SELECT code_ziranbar FROM mojody_kala WHERE code_ziranbar=$code_ziranbar_ AND code_ostan=$code_ostan_ AND code_anbar=$code_anbar_ AND deleted=0))AND
          ($code_ziranbar_ NOT IN (SELECT code_ziranbar FROM resid_kala_detail WHERE code_ziranbar=$code_ziranbar_ AND code_ostan=$code_ostan_ AND code_anbar=$code_anbar_ AND resid_deleted=0))AND
          ($code_ziranbar_ NOT IN (SELECT code_ziranbar FROM havale_detail WHERE code_ziranbar=$code_ziranbar_ AND code_ostan=$code_ostan_ AND code_anbar=$code_anbar_ AND havale_deleted=0))AND
          ($code_ziranbar_ NOT IN (SELECT code_ziranbar FROM tadil_mojody WHERE code_ziranbar=$code_ziranbar_ AND code_ostan=$code_ostan_ AND code_anbar=$code_anbar_ AND deleted=0))";
 $del_res = $db->query($del_q,'مشکلي در حذف به وجود آمده است');
 if(mysql_affected_rows()==0)
  echo"<script>alert('این عنوان در سایر فرم ها استفاده شده است،شما مجاز به حذف آن نیستید!')</script>";
 else if($del_res)
  $log_d=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_','حذف',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')");
}
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.code_ziranbar.focus();">
<form method="post" name="myform" onkeydown="enterIE();">
<div align="center">
<table width="85%" height="100%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr>
  <td class="title">
   <div style="position:absolute;top:5px;left:45%;"> جزئیات  '.$result_master['name_anbar'].'</div>
   <div class="pagecover">[صفحه:&nbsp'.$PageNo_detail.' از '.$MaxPage.']</div>
  </td>	 
 </tr>
 <!--پايان هدر-->
 <!-- مرکز صفحه--> 
 <tr>
  <td height="100%">
   <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
	<tr class="table-title">';
/********************sort field***********************/
if(!isset($order))    $order='id DESC';
if(!isset($sortcode)) $sortcode='1';
if(!isset($sortname)) $sortname='1';
if(!isset($show_img)) $show_img='';
	if($sortcode=='1')
	{echo'<td width="10%" title="مرتب سازی صعودی کد زیرانبار" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?code_ostan_='.$code_ostan_.'&code_anbar_='.$code_anbar_.'&zarfiyat_='.$zarfiyat_.'&PageNo_detail='.$PageNo_detail.'&RowPerPage='.$RowPerPage.'&PageNo='.$PageNo.'&order=code_ziranbar ASC&sortcode=2&show_img=1\'"/> کد زیرانبار ';
	  if($show_img=='1')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sortcode=='2')
	{echo'<td width="10%" title="مرتب سازی نزولی کد زیر انبار" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?code_ostan_='.$code_ostan_.'&code_anbar_='.$code_anbar_.'&zarfiyat_='.$zarfiyat_.'&PageNo_detail='.$PageNo_detail.'&RowPerPage='.$RowPerPage.'&PageNo='.$PageNo.'&order=code_ziranbar DESC&sortcode=1&show_img=1\'"/> کد زیرانبار ';
	  if($show_img=='1')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
    if($sortname=='1')
	{echo'<td width="20%" title="مرتب سازی صعودی نام زیرانبار" style="cursor:pointer;"  onClick="window.location=\''.$FileName.'?code_ostan_='.$code_ostan_.'&code_anbar_='.$code_anbar_.'&zarfiyat_='.$zarfiyat_.'&PageNo_detail='.$PageNo_detail.'&RowPerPage='.$RowPerPage.'&PageNo='.$PageNo.'&order=name_ziranbar ASC&sortname=2&show_img=2\'"/> نام زیرانبار '; 
	   if($show_img=='2')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sortname=='2')
	{echo'<td width="20%" title="مرتب سازی نزولی نام زیرانبار" style="cursor:pointer;"  onClick="window.location=\''.$FileName.'?code_ostan_='.$code_ostan_.'&code_anbar_='.$code_anbar_.'&zarfiyat_='.$zarfiyat_.'&PageNo_detail='.$PageNo_detail.'&RowPerPage='.$RowPerPage.'&PageNo='.$PageNo.'&order=name_ziranbar DESC&sortname=1&show_img=2\'"/> نام زیرانبار '; 
	   if($show_img=='2')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	echo'
	 <td width="20%">نوع زیرانبار</td>
	 <td width="25%">ظرفیت اسمی زیرانبار</td>';
	 if(($right_del)and($Mode==NULL)) echo'<td width="25%">حذف</td>';
     else if($Mode!=NULL) echo'<td width="25%">دستورات</td>';
	 echo'
	</tr>';
	if($Mode=='Insert' or $Mode=='Search')
	{
	 if ($Mode=='Insert') {$button_value="ايجاد"; $button_name="Insert_x";} 
	 else {$button_value="جستجو"; $button_name="Search_x";}
	  echo'
	  <tr class="table-odd">
	   <td><input type="text" class="textboxme2" name="code_ziranbar" value="'.$code_ziranbar.'" onkeypress="return isNumber(event)" style="width:50px"/></td>
	   <td><input type="text" class="textboxme2" name="name_ziranbar" value="'.$name_ziranbar.'"/></td>
	   <td>'.static_listbox("noe_ziranbar",$noe_ziranbar,"ziranbarArr",1,"class='text4'").'</td>
	   <td><input type="text" class="textboxme2" name="zarfiyat_detail" value="'.$zarfiyat_detail.'" onkeypress="return isNumber(event)"/></td>
	   <td><input type="submit" class="buttonme" name="'.$button_name.'" id="sabt" value="'.$button_value.'">
		   <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?code_ostan_='.$code_ostan_.'&code_anbar_='.$code_anbar_.'&zarfiyat_='.$zarfiyat_.'&PageNo_detail='.$PageNo_detail.'&RowPerPage='.$RowPerPage.'&PageNo='.$PageNo.'&order='.$order.'\'">
	   </td>
	  </tr>';
	}
	$i=0; 
	$q1="SELECT * From $TableName T WHERE code_ostan='$code_ostan_' AND code_anbar='$code_anbar_' ".$_SESSION['mt_search_anbar_det']." order by $order $Limit";	
	$all = $db->query($q1);
    while($row1=$db->fetch_assoc($all))
	{
     if($right_edt){$edtClick='onClick="window.location=\''.$FileName.'?Mode=Edit&id_='.$row1['id'].'&code_ostan_='.$row1['code_ostan'].'&code_anbar_='.$code_anbar_.'&zarfiyat_='.$zarfiyat_.'&PageNo_detail='.$PageNo_detail.'&RowPerPage='.$RowPerPage.'&PageNo='.$PageNo.'&order='.$order.'\'"';}	 
	 if($i++%2)
     echo'
     <tr class="table-odd"/>';
     else echo '
     <tr class="table-even"/>';
	 if($Mode=='Edit' and $row1['id']==$id_)
	 {
	  $exist_mojody=$db->get_from_where("count(code_ziranbar)","mojody_kala","code_ziranbar=".$row1['code_ziranbar']." AND code_ostan=".$row1['code_ostan']." AND code_anbar=".$row1['code_anbar']."");
	  $exist_resid_kala_detail=$db->get_from_where("count(code_ziranbar)","resid_kala_detail","code_ziranbar=".$row1['code_ziranbar']." AND code_ostan=".$row1['code_ostan']." AND code_anbar=".$row1['code_anbar']."");
	  $exist_havale_detail=$db->get_from_where("count(code_ziranbar)","havale_detail","code_ziranbar=".$row1['code_ziranbar']." AND code_ostan=".$row1['code_ostan']." AND code_anbar=".$row1['code_anbar']."");
	  $exist_tadil=$db->get_from_where("count(code_ziranbar)","tadil_mojody","code_ziranbar=".$row1['code_ziranbar']." AND code_ostan=".$row1['code_ostan']." AND code_anbar=".$row1['code_anbar']." AND deleted=0");
	  if(($exist_mojody)or($exist_resid_kala_detail)or($exist_havale_detail)or($exist_tadil)) echo'<td><input type="text" class="textboxme2" readonly name="code_ziranbar" value="'.$row1['code_ziranbar'].'" title="غیر قابل تغییر" style="width:50px"/> <img border="0" src="images/readonly.png" title="غیر قابل تغییر" class="dontchange"/></td>';
	  else echo'<td><input type="text" class="textboxme2" name="code_ziranbar" value="'.$row1['code_ziranbar'].'" onkeypress="return isNumber(event)" style="width:50px"/></td>';
      echo'
	  <td><input type="text" class="textboxme2" name="name_ziranbar" value="'.$row1['name_ziranbar'].'"/></td>
	  <td>'.static_listbox("noe_ziranbar",$row1['noe_ziranbar'],"ziranbarArr",1,"class='text4'").'</td>
	  <td><input type="text" class="textboxme2" name="zarfiyat_detail" value="'.$row1['zarfiyat_detail'].'"/></td>
	  <td>
	    <input class="buttonme" type="submit" name="Edit_x" id="sabt" value="ثبت تغييرات" >
	    <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?code_ostan_='.$code_ostan_.'&code_anbar_='.$code_anbar_.'&zarfiyat_='.$zarfiyat_.'&PageNo_detail='.$PageNo_detail.'&RowPerPage='.$RowPerPage.'&PageNo='.$PageNo.'&order='.$order.'\'">
	  </td>';
	 }
     else
     {echo'
	  <td '.$edtClick.'>'.$row1['code_ziranbar'].'</td>
	  <td '.$edtClick.'>'.$row1['name_ziranbar'].'</td>
	  <td '.$edtClick.'>'.$ziranbarArr[$row1['noe_ziranbar']].'</td>
	  <td '.$edtClick.'>'.$row1['zarfiyat_detail'].'</td>';
	  if($right_del)
	  {echo'<td><img border="0" class="1" src="images/trash.png" width="20" height="20" 
	       onmouseOver="this.src=\'images/trash_hover.png\'" 
		   onmouseOut="this.src=\'images/trash.png\'" 
		   onClick="iconfirm(\''.$FileName.'?Delete_x=1&id_='.$row1['id'].'&code_ziranbar_='.$row1['code_ziranbar'].'&code_ostan_='.$code_ostan_.'&code_anbar_='.$code_anbar_.'&PageNo_detail='.$PageNo_detail.'&RowPerPage='.$RowPerPage.'&PageNo='.$PageNo.'&order='.$order.'\',\'برای حذف زیرانبار '.$row1['name_ziranbar'].'\')" /></td>';
	  }
	  else if($Mode!=NULL)echo'<td>&nbsp;</td>';
	  else echo'';
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
      <td>&nbsp;</td>';
	  if($right_del) echo'<td>&nbsp;</td>';
	  else if($Mode!=NULL)echo'<td>&nbsp;</td>';
	  else echo'';
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
	 <td width="10">&nbsp;</td>
	 <td width="24"><div onClick="window.open(\'print_list_sardkhane_detail.php?code_ostan_='.$code_ostan_.'&code_anbar_='.$code_anbar_.'\',\'_blank\',\'width=720px,scrollbars=1\')" id="printer" title="چاپ"><a href="#"></a></div></td>
     <td width="10">&nbsp;</td>';
	 if($right_ins){
	 echo'<td width="70"><div onClick="window.location=\''.$FileName.'?Mode=Insert&code_ostan_='.$code_ostan_.'&code_anbar_='.$code_anbar_.'&zarfiyat_='.$zarfiyat_.'&PageNo_detail='.$PageNo_detail.'&RowPerPage='.$RowPerPage.'&PageNo='.$PageNo.'&order='.$order.'\'" id="btn-new" title="افزودن رکورد جديد" ><a href="#"></a></div></td>
 	 <td width="10">&nbsp;</td>';}
	 echo'<td width="70"><div onClick="window.location=\''.$FileName.'?Mode=Search&code_ostan_='.$code_ostan_.'&code_anbar_='.$code_anbar_.'&zarfiyat_='.$zarfiyat_.'&PageNo_detail='.$PageNo_detail.'&RowPerPage='.$RowPerPage.'&PageNo='.$PageNo.'&order='.$order.'\'" id="btn-search" title="جستجو" ><a href="#"></a></div></td>
	 <td width="10">&nbsp;</td>
	 <td width="70"><div onClick="window.location=\'list_sardkhane.php?PageNo='.$PageNo.'\'" id="btn-back" title="بازگشت به جدول انبارها"  ><a href="#"></a></div></td> 
	 <td width="20">&nbsp;</td>	   
	 <td width="22"><div '.$En_Prev.' onClick="window.location=\''.$FileName.'?code_ostan_='.$code_ostan_.'&code_anbar_='.$code_anbar_.'&zarfiyat_='.$zarfiyat_.'&PageNo_detail=1&RowPerPage='.$RowPerPage.'&PageNo='.$PageNo.'&order='.$order.'\'" id="btn-pageone" title="رويت اولين صفحه"><a href="#"></a></div></td>
	 <td width="2">&nbsp;</td>
	 <td width="22"><div '.$En_Prev.' onClick="window.location=\''.$FileName.'?code_ostan_='.$code_ostan_.'&code_anbar_='.$code_anbar_.'&zarfiyat_='.$zarfiyat_.'&PageNo_detail='.$PrevPage.'&RowPerPage='.$RowPerPage.'&PageNo='.$PageNo.'&order='.$order.'\'" id="btn-perevius" title="رفتن به صفحه قبلي"><a href="#"></a></div></td>
     <td width="2">&nbsp;</td>
	 <td width="40" align="center"><input type="text" name="PageNo_detail" value="'.$PageNo_detail.'" size="2" onChange="myform.submit()" onkeypress="return isNumber(event)" style="direction:ltr;text-align:center;"></td>		   
	 <td width="2">&nbsp;</td>		   
	 <td width="22"><div '.$En_Next.' onClick="window.location=\''.$FileName.'?code_ostan_='.$code_ostan_.'&code_anbar_='.$code_anbar_.'&zarfiyat_='.$zarfiyat_.'&PageNo_detail='.$NextPage.'&RowPerPage='.$RowPerPage.'&PageNo='.$PageNo.'&order='.$order.'\'" id="btn-forward" title="رفتن به صفحه بعدي"><a href="#"></a></div></td>
     <td width="2">&nbsp;</td>		   
	 <td width="22"><div '.$En_Next.' onClick="window.location=\''.$FileName.'?code_ostan_='.$code_ostan_.'&code_anbar_='.$code_anbar_.'&zarfiyat_='.$zarfiyat_.'&PageNo_detail='.$MaxPage.'&RowPerPage='.$RowPerPage.'&PageNo='.$PageNo.'&order='.$order.'\'" id="btn-pageend" title="رويت آخرين صفحه"><a href="#" ></a></div></td>
	 <td width="2">&nbsp;</td>
	 <td width="65" align="left"><span class="text1">تعداد خط :</span></td>
	 <td align="right"><input type="text" name="wRowPerPage" value="'.$RowPerPage.'" size="2" onChange="myform.submit()" onkeypress="return isNumber(event)" style="direction:ltr;text-align:center;"></td>	 
	 <td width="10">&nbsp;</td>';
     if ($_SESSION['mt_search_anbar_det']) 
	 echo '
	 <td width="70"><input type="Button" class=buttonme  value="نمايش همه" onClick="window.location=\''.$FileName.'?code_ostan_='.$code_ostan_.'&code_anbar_='.$code_anbar_.'&zarfiyat_='.$zarfiyat_.'&PageNo_detail='.$PageNo_detail.'&RowPerPage='.$RowPerPage.'&PageNo='.$PageNo.'&order='.$order.'&open_filter=1\'"></td>';	 
	 echo'
     <td width="100px" style="color:#fff;" align="left"> تعداد ['.$cnt.']</td>
     <td width="10">&nbsp;</td>	 
	</tr>';
    }	
   echo'
   </table>
  </td>
 </tr>
 <!-- پايان فوتر-->';
echo'	
</table>
</div>';
/************اجازه براي ذخيره اطلاعات************/
function isPermitSave($code_zir_a,$name_zir_a,$noe_zir_a,$zar_d,$code_o,$code_a,$zar)
{
 $flag=false;
 if((!($code_zir_a and $name_zir_a and $noe_zir_a))and($zar_d==NULL))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script> alert('لطفا تمام فيلد ها را تکميل نماييد')</script>";
   return $flag;
 } 
 else $flag=true;
 if(!empty($code_zir_a))//تکراری نبودن این کد زیرانبار
 { 
    $q8="SELECT code_ziranbar FROM list_sardkhane_detail WHERE code_ziranbar='$code_zir_a' AND code_ostan='$code_o' AND code_anbar='$code_a'";
    $res8=mysql_query($q8);
    if(mysql_num_rows($res8)>0){
    echo"<script>alert('این کد زیر انبار قبلاً برای این انبار ثبت شده است!')</script>";
    $flag=false;
    return $flag;
   }
  else $flag=true;
 }
 else $flag=true;
 if(!empty($name_zir_a))//تکراری نبودن این نام زیرانبار
 { 
    $q9="SELECT name_ziranbar FROM list_sardkhane_detail WHERE name_ziranbar='$name_zir_a' AND code_ostan='$code_o' AND code_anbar='$code_a'";
	$res9=mysql_query($q9);
    if(mysql_num_rows($res9)>0){
    echo"<script>alert('این نام زیر انبار قبلاً برای این انبار ثبت شده است!')</script>";
    $flag=false;
    return $flag;
   }
  else $flag=true;
 }
 else $flag=true;
 if(!empty($zar_d))//چک کردن ظرفیت ها
 { 
    $q_zar="SELECT sum(zarfiyat_detail) from list_sardkhane_detail WHERE code_ostan='$code_o' AND code_anbar='$code_a'";
    $res_zar=mysql_query($q_zar);
    $row_zar=mysql_fetch_array($res_zar);
	//$mande=$zar-($row_zar[0]+$zar_d);
	$mande=$zar-($row_zar[0]);
	if($mande<$zar_d)
	{
      echo"<script>alert('ظرفیت اسمی زیرانبارها از ظرفیت اسمی انبار بیشتر است!')</script>";
      $flag=false;
      return $flag;
    }
    else $flag=true;
 }
 else $flag=true; 
return $flag;
}
/**********اجازه براي ويرايش اطلاعات********/
function isPermitEdit($code_zir_a,$name_zir_a,$noe_zir_a,$zar_d,$code_o,$code_a,$zar,$this_id)
{
  $flag=false;
  if((!($code_zir_a and $name_zir_a and $noe_zir_a))and($zar_d==NULL))//پر بودن فيلدها
  {
   $flag=false;
   echo"<script>window.alert('لطفا تمام فيلد ها را تکميل نماييد');</script>";
   return $flag;
  } 
  else $flag=true;
  if(!empty($code_zir_a))//تکراری نبودن این کد زیرانبار
  {  
   $q10="SELECT code_ziranbar FROM list_sardkhane_detail WHERE code_ziranbar='$code_zir_a' AND code_ostan='$code_o' AND code_anbar='$code_a' AND id!=$this_id";
   $res10=mysql_query($q10);
   $row10=mysql_fetch_assoc($res10);
   if(mysql_num_rows($res10)>0){
    echo"<script>alert('این کد زیر انبار قبلاً برای این انبار ثبت شده است!')</script>";
   $flag=false;
   return $flag;
   }
  else $flag=true;
  }
  else $flag=true;
  if(!empty($name_zir_a))//تکراری نبودن این نام زیرانبار
  { 
    $q11="SELECT name_ziranbar FROM list_sardkhane_detail WHERE name_ziranbar='$name_zir_a' AND code_ostan='$code_o' AND code_anbar='$code_a' AND id!=$this_id";
    $res11=mysql_query($q11);
    if(mysql_num_rows($res11)>0){
    echo"<script>alert('این نام زیر انبار قبلاً برای این انبار ثبت شده است!')</script>";
    $flag=false;
    return $flag;
   }
  else $flag=true;
  }
  else $flag=true;
  if(!empty($zar_d))//چک کردن ظرفیت ها
  { 
    $q_zar="SELECT sum(zarfiyat_detail) from list_sardkhane_detail WHERE code_ostan='$code_o' AND code_anbar='$code_a' AND id!=$this_id";
    $res_zar=mysql_query($q_zar);
    $row_zar=mysql_fetch_array($res_zar);
    //$mande=$zar-($row_zar[0]+$zar_d);
    $mande=$zar-($row_zar[0]);
	// echo "<script>alert($row_zar[0])</script>";
	// echo "<script>alert($zar_d)</script>";
	// echo "<script>alert($row_zar[0]+$zar_d)</script>";
	// echo "<script>alert($mande)</script>";
	if($mande<$zar_d)
	{
      echo"<script>alert('ظرفیت اسمی زیرانبارها از ظرفیت اسمی انبار بیشتر است!')</script>";
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
 if(isPermitSave($code_ziranbar,$name_ziranbar,$noe_ziranbar,$zarfiyat_detail,$code_ostan_,$code_anbar_,$zarfiyat_))
 { 
  $Mode='';
  $name_ziranbar=str_replace("ي","ی",$name_ziranbar);
  $name_ziranbar=str_replace("ك","ک",$name_ziranbar);
  $insert_q=("INSERT INTO $TableName(code_ostan,code_anbar,code_ziranbar,name_ziranbar,noe_ziranbar,zarfiyat_detail)VALUES('$code_ostan_','$code_anbar_','$code_ziranbar','$name_ziranbar','$noe_ziranbar',TRIM('$zarfiyat_detail'))");  
  $insert_res=mysql_query($insert_q);
  if($insert_res)
  {
    $max_id=$db->get_from_where("Max(id)","$TableName",""); 
    $log_i=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$max_id','ثبت',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')");
    echo '<script>window.location=\''.$FileName.'?code_ostan_='.$code_ostan_.'&code_anbar_='.$code_anbar_.'&zarfiyat_='.$zarfiyat_.'&PageNo_detail='.$PageNo_detail.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\' </script>';
  }
  else $message ='<span style="color:red;font: bold 12px tahoma;"> * مشکلی در ثبت به وجود آمده است ! *</span>';
 }
}
/************EDIT BUTTON********/// اصلاح اطلاعات
if (isset($Edit_x))
{
 if(isPermitEdit($code_ziranbar,$name_ziranbar,$noe_ziranbar,$zarfiyat_detail,$code_ostan_,$code_anbar_,$zarfiyat_,$id_))
 {
  $Mode='';
  $name_ziranbar=str_replace("ي","ی",$name_ziranbar);
  $name_ziranbar=str_replace("ك","ک",$name_ziranbar);  
  $edit_q=("UPDATE $TableName SET code_ostan='$code_ostan_',code_anbar='$code_anbar_',code_ziranbar='$code_ziranbar',name_ziranbar='$name_ziranbar',noe_ziranbar='$noe_ziranbar',zarfiyat_detail=TRIM('$zarfiyat_detail') WHERE `id`='$id_';");	
  $edit_res=mysql_query($edit_q);
  if(($edit_res) and (mysql_affected_rows()!=0)) 
  {
   $log_e=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_','ویرایش',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')"); /*کوئری لاگ*/
   echo '<script>window.location=\''.$FileName.'?code_ostan_='.$code_ostan_.'&code_anbar_='.$code_anbar_.'&zarfiyat_='.$zarfiyat_.'&PageNo_detail='.$PageNo_detail.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\' </script>';
  }
  else if(mysql_affected_rows()==0) echo '<script>window.location=\''.$FileName.'?code_ostan_='.$code_ostan_.'&code_anbar_='.$code_anbar_.'&zarfiyat_='.$zarfiyat_.'&PageNo_detail='.$PageNo_detail.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\' </script>';
  else $message ='<span style=" color:red;font: bold 12px tahoma;"> * مشکلی در ویرایش مشخصات به وجود آمده است ! *</span>';
 } 
}
///////////////////////////////////////////////////////////////////
echo'
'.$message.'
</form>
</body>
</html>';	
?>