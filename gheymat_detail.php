<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="gheymat_detail.php";
$TableName="mt_gheymat_detail";
//$logtime=date('H:i:s');
$right_ins=0;$right_edt=0;$right_del=0;
if (right(64)) $right_ins=1;
if (right(65)) $right_edt=1;
if (right(66)) $right_del=1; 
echo'
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>جزئیات جدول قیمت خرید</title>
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
// خواندن اطلاعات جدول قيمت جریمه
$c=$db->query("SELECT * FROM mt_gheymat WHERE Gh_ID='$Gh_ID_'");
$r=$db->fetch_array($c);
$message='';
if(!(isset($Mode))) $Mode='';
/*************SEARCH BUTTON******/// جستجوي اطلاعات
if(isset($open_filter))
{ $open_filter="";
  $_SESSION['mt_search_gheymat_det']="";
} 
if(isset($Search_x))
{
 $Mode='';
 $Search_x=""; 
 $temp="";
 if($Gd_CodeKala)   $temp.=" and Gd_CodeKala LIKE '$Gd_CodeKala'";
 if($Gd_Fee)        $temp.=" and Gd_Fee LIKE '%$Gd_Fee%'";
 if($temp) {
 $PageNo_detail=1;
 $_SESSION['mt_search_gheymat_det']=$temp;} else $_SESSION['mt_search_gheymat_det']="";
}
/********************PAGING***********************/
if(isset($_POST['wRowPerPage'])) $RowPerPage=$_POST['wRowPerPage'];
if(!isset($RowPerPage)) $RowPerPage=8;
$res = $db->query("SELECT COUNT(*) FROM $TableName WHERE Gd_GheymatID='$Gh_ID_' ".$_SESSION['mt_search_gheymat_det']." and Gd_Deleted=0");
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
/************DELETE BUTTON********/// حذف اطلاعات
if (isset($Delete_x))
{
 $Mode=''; 
 $del_q = "UPDATE $TableName SET Gd_Deleted=1 WHERE Gd_ID=$Gd_ID_ AND
          ($Gd_ID_ NOT IN (SELECT Mo_GheymatDetailID FROM mojody_kala WHERE Mo_GheymatDetailID=$Gd_ID_ AND deleted=0))AND
          ($Gd_ID_ NOT IN (SELECT Re_GheymatDetailID FROM resid WHERE Re_GheymatDetailID=$Gd_ID_ AND deleted=0))";
 $del_res = $db->query($del_q,'مشکلي در حذف به وجود آمده است');
 if(mysql_affected_rows()==0)
  echo"<script>alert('این عنوان در سایر فرم ها استفاده شده است،شما مجاز به حذف آن نیستید!')</script>";
 else if($del_res)
  $log_d=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$Gd_ID_','حذف',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')");
}
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<form method="post" name="myform" onkeydown="enterIE();">
<div align="center">
<table width="850px" height="100%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr>
  <td class="title">
   <div style="position:absolute;top:5px;left:40%;">  جزئيات جدول قيمت خرید &nbsp'.$r['Gh_Shomare'].' با تاريخ اعتبار &nbsp'.$r['Ja_TarikhEtebar'].'</div>
   <div class="pagecover">[صفحه:&nbsp'.$PageNo_detail.' از '.$MaxPage.']</div>
  </td>	 
 </tr>
 <!--پايان هدر-->
 <!-- مرکز صفحه--> 
 <tr>
  <td height="100%">
   <div style="float:right;width:100%;margin:0px;height:100%;overflow:auto;overflow-x:hidden;">
   <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
	<tr class="table-title">';
/********************sort field***********************/
if(!isset($order))  $order='Gd_ID DESC';
	echo'
	 <td width="50%">نام کالا</td>
	 <td width="20%">فی</td>';
	 if(($right_del)and($Mode==NULL)) echo'<td width="30%">حذف</td>';
     else if($Mode!=NULL) echo'<td width="30%">دستورات</td>';
	 echo'
	</tr>';
	if($Mode=='Insert' or $Mode=='Search')
	{
	 if ($Mode=='Insert') {$button_value="ايجاد"; $button_name="Insert_x";} 
	 else {$button_value="جستجو"; $button_name="Search_x";}
	  echo'
	  <tr class="table-odd">
	   <td>'.listbox("Gd_CodeKala",$Gd_CodeKala,"code_kala","name_kala","kala","1=1 ORDER BY name_kala","class='text4'").'</td>
	   <td><input type="text" class="textboxme2" name="Gd_Fee" value="'.$Gd_Fee.'" onkeypress="return isNumber(event)"/></td>
	   <td><input type="submit" class="buttonme" name="'.$button_name.'" id="sabt" value="'.$button_value.'">
		   <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?Gh_ID_='.$Gh_ID_.'&PageNo_detail='.$PageNo_detail.'&RowPerPage='.$RowPerPage.'&PageNo='.$PageNo.'&order='.$order.'\'">
	   </td>
	  </tr>';
	}
	$i=0; 
	$q1="SELECT *,(SELECT name_kala FROM kala WHERE kala.code_kala=T.Gd_CodeKala) nameKala 	
	     From $TableName T WHERE Gd_GheymatID='$Gh_ID_' ".$_SESSION['mt_search_gheymat_det']." and Gd_Deleted=0 order by $order $Limit";	
	$all = $db->query($q1);
    while($row1=$db->fetch_assoc($all))
	{
     if($right_edt){$edtClick='onClick="window.location=\''.$FileName.'?Mode=Edit&Gd_ID_='.$row1['Gd_ID'].'&Gh_ID_='.$row1['Gd_GheymatID'].'&PageNo_detail='.$PageNo_detail.'&RowPerPage='.$RowPerPage.'&PageNo='.$PageNo.'&order='.$order.'\'"';}	 
	 if($i++%2)
     echo'
     <tr class="table-odd"/>';
     else echo '
     <tr class="table-even"/>';
	 if($Mode=='Edit' and $row1['Gd_ID']==$Gd_ID_)
	 {
	  $exist_mojody=$db->get_from_where("count(Mo_GheymatDetailID)","mojody_kala","Mo_GheymatDetailID=".$row1['Gd_ID']."");
	  $exist_resid=$db->get_from_where("count(Re_GheymatDetailID)","resid","Re_GheymatDetailID=".$row1['Gd_ID']."");
	  if(($exist_mojody>0)OR ($exist_resid>0))// 	  
	  {
	   echo'
	   <td><input type="hidden" name="Gd_CodeKala" value="'.$row1['Gd_CodeKala'].'"/>'.listboxMe("Gd_CodeKala",$row1['Gd_CodeKala'],"Gd_CodeKala","name_kala","kala","1=1","class='text4' disabled").'</td>	  
	   <td><input type="text" class="textboxme2" readonly name="Gd_Fee" value="'.$row1['Gd_Fee'].'" title="غیر قابل تغییر"/></td>';
	  }
	  else 
	  {echo'
	  <td>'.listboxMe("Gd_CodeKala",$row1['Gd_CodeKala'],"code_kala","name_kala","kala","1=1","class='text4' ORDER BY name_kala").'</td>	  
	  <td><input type="text" class="textboxme2" name="Gd_Fee" value="'.$row1['Gd_Fee'].'" onkeypress="return isNumber(event)"/></td>';
	  }
	  echo'
	  <td>
	    <input class="buttonme" type="submit" name="Edit_x" id="sabt" value="ثبت تغييرات" >
	    <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?Gh_ID_='.$Gh_ID_.'&PageNo_detail='.$PageNo_detail.'&RowPerPage='.$RowPerPage.'&PageNo='.$PageNo.'&order='.$order.'\'">
	  </td>';
	 }
     else
     {echo'
	  <td '.$edtClick.'>'.$row1['nameKala'].'</td>
	  <td '.$edtClick.'>'.virgul($row1['Gd_Fee']).'</td>';
	  if($right_del)
	  {echo'<td><img border="0" class="1" src="images/trash.png" width="20" height="20" 
	       onmouseOver="this.src=\'images/trash_hover.png\'" 
		   onmouseOut="this.src=\'images/trash.png\'" 
		   onClick="iconfirm(\''.$FileName.'?Delete_x=1&Gd_ID_='.$row1['Gd_ID'].'&Gh_ID_='.$Gh_ID_.'&Gd_CodeKala_='.$row1['Gd_CodeKala'].'&PageNo_detail='.$PageNo_detail.'&RowPerPage='.$RowPerPage.'&PageNo='.$PageNo.'&order='.$order.'\',\'برای حذف قیمت '.$row1['nameKala'].'\')" /></td>';
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
	 <td width="10">&nbsp;</td>';
	 if($right_ins){
	 echo'<td width="70"><div onClick="window.location=\''.$FileName.'?Mode=Insert&Gh_ID_='.$Gh_ID_.'&PageNo_detail='.$PageNo_detail.'&RowPerPage='.$RowPerPage.'&PageNo='.$PageNo.'&order='.$order.'\'" id="btn-new" title="افزودن رکورد جديد" ><a href="#"></a></div></td>
 	 <td width="10">&nbsp;</td>';}
	 echo'<td width="70"><div onClick="window.location=\''.$FileName.'?Mode=Search&Gh_ID_='.$Gh_ID_.'&PageNo_detail='.$PageNo_detail.'&RowPerPage='.$RowPerPage.'&PageNo='.$PageNo.'&order='.$order.'\'" id="btn-search" title="جستجو" ><a href="#"></a></div></td>
	 <td width="10">&nbsp;</td>
	 <td width="70"><div onClick="window.location=\'gheymat.php?PageNo='.$PageNo.'\'" id="btn-back"  title="بازگشت به منوي اصلي"  ><a href="#"></a></div></td> 
	 <td width="20">&nbsp;</td>	   
	 <td width="22"><div '.$En_Prev.' onClick="window.location=\''.$FileName.'?Gh_ID_='.$Gh_ID_.'&PageNo_detail=1&RowPerPage='.$RowPerPage.'&PageNo='.$PageNo.'&order='.$order.'\'" id="btn-pageone" title="رويت اولين صفحه"><a href="#"></a></div></td>
	 <td width="2">&nbsp;</td>
	 <td width="22"><div '.$En_Prev.' onClick="window.location=\''.$FileName.'?Gh_ID_='.$Gh_ID_.'&PageNo_detail='.$PrevPage.'&RowPerPage='.$RowPerPage.'&PageNo='.$PageNo.'&order='.$order.'\'" id="btn-perevius" title="رفتن به صفحه قبلي"><a href="#"></a></div></td>
     <td width="2">&nbsp;</td>
	 <td width="40" align="center"><input type="text" name="PageNo_detail" value="'.$PageNo_detail.'" size="2" onChange="myform.submit()" onkeypress="return isNumber(event)" style="direction:ltr;text-align:center;"></td>		   
	 <td width="2">&nbsp;</td>		   
	 <td width="22"><div '.$En_Next.' onClick="window.location=\''.$FileName.'?Gh_ID_='.$Gh_ID_.'&PageNo_detail='.$NextPage.'&RowPerPage='.$RowPerPage.'&PageNo='.$PageNo.'&order='.$order.'\'" id="btn-forward" title="رفتن به صفحه بعدي"><a href="#"></a></div></td>
     <td width="2">&nbsp;</td>		   
	 <td width="22"><div '.$En_Next.' onClick="window.location=\''.$FileName.'?Gh_ID_='.$Gh_ID_.'&PageNo_detail='.$MaxPage.'&RowPerPage='.$RowPerPage.'&PageNo='.$PageNo.'&order='.$order.'\'" id="btn-pageend" title="رويت آخرين صفحه"><a href="#" ></a></div></td>
	 <td width="2">&nbsp;</td>
	 <td width="65" align="left"><span class="text1">تعداد خط :</span></td>
	 <td align="right"><input type="text" name="wRowPerPage" value="'.$RowPerPage.'" size="2" onChange="myform.submit()" onkeypress="return isNumber(event)" style="direction:ltr;text-align:center;"></td>	 
	 <td width="10">&nbsp;</td>';
     if ($_SESSION['mt_search_gheymat_det']) 
	 echo '
	 <td width="70"><input type="Button" class=buttonme  value="نمايش همه" onClick="window.location=\''.$FileName.'?Gh_ID_='.$Gh_ID_.'&PageNo_detail='.$PageNo_detail.'&RowPerPage='.$RowPerPage.'&PageNo='.$PageNo.'&order='.$order.'&open_filter=1\'"></td>';	 
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
function isPermitSave($c_kala,$fee,$Gh_ID_)
{
 $flag=false;
 if(!($c_kala and $fee))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script> alert('لطفا تمام فيلد ها را تکميل نماييد')</script>";
   return $flag;
 } 
 else $flag=true;
 // if(!empty($c_kala))//تکراری نبودن این کد کالا در جدول جزئیات قیمت
 // { 
    // $q8="SELECT Gd_CodeKala FROM mt_gheymat_detail WHERE Gd_CodeKala='$c_kala' AND Gd_GheymatID='$Gh_ID_' AND Gd_Deleted=0";
    // $res8=mysql_query($q8);
    // if(mysql_num_rows($res8)>0){
    // echo"<script>alert('برای این کالا در این جدول قبلاً قیمت ثبت شده است')</script>";
    // $flag=false;
    // return $flag;
   // }
  // else $flag=true;
 // }
 // else $flag=true; 
 if (!justNumber($fee))//عدد بودن في 
 {
   $flag=false;
   echo"<script>alert('فيلد فی نامعتبر است!')</script>";
   return $flag;
 }
 else $flag=true;
return $flag;
}
/**********اجازه براي ويرايش اطلاعات********/
function isPermitEdit($c_kala,$fee,$Gh_ID_,$this_id)
{
  $flag=false;
  if(!($c_kala and $fee))//پر بودن فيلدها
  {
   $flag=false;
   echo"<script>window.alert('لطفا تمام فيلد ها را تکميل نماييد');</script>";
   return $flag;
  } 
  else $flag=true;
  // if(!empty($c_kala))//تکراری نبودن این کد کالا در جدول جزئیات قیمت
  // {  
    // $q10="SELECT * FROM mt_gheymat_detail WHERE Gd_CodeKala='$c_kala' AND Gd_GheymatID='$Gh_ID_' AND Gd_ID!=$this_id AND Gd_Deleted=0";
    // $res10=mysql_query($q10);
    // $row10=mysql_fetch_assoc($res10);
    // if(mysql_num_rows($res10)>0){
    // echo"<script>alert('برای این کالا در این جدول قبلاً قیمت ثبت شده است')</script>";
    // $flag=false;
    // return $flag;
    // }
   // else $flag=true;
  // }
  // else $flag=true;
  if (!justNumber($fee))//عدد بودن في 
  {
   $flag=false;
   echo"<script>alert('فيلد فی نامعتبر است!')</script>";
   return $flag;
  }
  else $flag=true;
 return $flag;
}
/*************INSERT BUTTON******/// ثبت اطلاعات    
if(isset($Insert_x))
{
 if(isPermitSave($Gd_CodeKala,$Gd_Fee,$Gh_ID_))
 { 
  $Mode='';
  $insert_q=("INSERT INTO $TableName(Gd_GheymatID,Gd_CodeKala,Gd_Fee,Gd_Deleted)VALUES('$Gh_ID_','$Gd_CodeKala','$Gd_Fee',0)");    
  $insert_res=mysql_query($insert_q);
  if($insert_res)
  {
   $max_id=$db->get_from_where("Max(Gd_ID)","$TableName","");  
   $log_i=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$max_id','ثبت',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')");  
   echo '<script>window.location=\''.$FileName.'?Gh_ID_='.$Gh_ID_.'&PageNo_detail='.$PageNo_detail.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\' </script>';
  }
  else  $message ='<span style="color:red;font: bold 12px tahoma;"> * مشکلی در ثبت قیمت به وجود آمده است ! *</span>';
 }
}
/************EDIT BUTTON********/// اصلاح اطلاعات
if (isset($Edit_x))
{
 if(isPermitEdit($Gd_CodeKala,$Gd_Fee,$Gh_ID_,$Gd_ID_))
 {
  $Mode=''; 
  $edit_q=("UPDATE $TableName SET Gd_CodeKala='$Gd_CodeKala',Gd_Fee='$Gd_Fee' WHERE `Gd_ID`='$Gd_ID_';");	
  $edit_res=mysql_query($edit_q);
  if(($edit_res) and (mysql_affected_rows()!=0))
  {
   $log_e=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$Gd_ID_','ویرایش',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')");  
   echo '<script>window.location=\''.$FileName.'?Gh_ID_='.$Gh_ID_.'&PageNo_detail='.$PageNo_detail.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\' </script>';
  }
  else if(mysql_affected_rows()==0)   echo '<script>window.location=\''.$FileName.'?Gh_ID='.$Gh_ID.'&PageNo_detail='.$PageNo_detail.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\' </script>';
  else $message ='<span style="color:red;font: bold 12px tahoma;"> * مشکلی در ویرایش مشخصات به وجود امده است ! *</span>';                  
 }
}
/********************END********************/	
echo'
'.$message.'
</form>
</body>
</html>';	
?>