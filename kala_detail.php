<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="kala_detail.php";
$TableName="kala_detail";
$logtime=date('H:i:s');
$right_ins=0;$right_edt=0;$right_del=0;
if (right(45)) $right_ins=1;
if (right(46)) $right_edt=1;
if (right(47)) $right_del=1;
// خواندن اطلاعات جدول کالا
$res=$db->query("SELECT * FROM kala WHERE code_kala='$code_kala_'");
$row_kala=$db->fetch_array($res);
$titr='جزئیات کالا'; 
echo'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" />
<html xmlns="http://www.w3.org/1999/xhtml" dir=rtl>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>'.$titr.' &nbsp'.$row_kala['name_kala'].'</title>
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
$message='';
if(!(isset($Mode))) $Mode='';
/*************SEARCH BUTTON******/// جستجوي اطلاعات
if(isset($open_filter))
{ $open_filter="";
  $_SESSION['mt_search_kala_det']="";
} 
if(isset($Search_x))
{
 $Mode='';
 $Search_x=""; 
 $temp="";
 if($code_kala)  $temp.=" and code_kala LIKE '$code_kala'";
 if($code_kala_detail)      $temp.=" and code_kala_detail LIKE '%$code_kala_detail%'";
 if($name_kala_detail)      $temp.=" and name_kala_detail LIKE '%$name_kala_detail%'";
 if($temp) {
 $PageNo_detail=1;
 $_SESSION['mt_search_kala_det']=$temp;} else $_SESSION['mt_search_kala_det']="";
}
/********************PAGING***********************/
if(isset($_POST['wRowPerPage'])) $RowPerPage=$_POST['wRowPerPage'];
if(!isset($RowPerPage)) $RowPerPage=8;
$res = $db->query("SELECT COUNT(*) FROM $TableName WHERE code_kala='$code_kala_' ".$_SESSION['mt_search_kala_det']."");
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
// if (isset($Delete_x))
// {
 // $Mode=''; 
 // $del_q = "UPDATE $TableName SET deleted=1 WHERE id_kala_detail=$id_kala_detail_ AND
          // ($code_kala_ NOT IN (SELECT code_kala FROM resid_detail WHERE code_kala=$code_kala_ AND id_gheymat_this=$code_kala_))";
 // $del_res = $db->query($del_q,'مشکلي در حذف به وجود آمده است');
 // if(mysql_affected_rows()==0)
  // echo"<script>alert('این عنوان در سایر فرم ها استفاده شده است،شما مجاز به حذف آن نیستید!')</script>";
 // else if($del_res)
  // $log_d=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_','حذف',".($yymmdd).",'$logtime')");
// }
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.code_kala_detail.focus();">
<form method="post" name="myform" onkeydown="enterIE();">
<div align="center">
<table width="85%" height="100%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr>
  <td class="title">
   <div style="position:absolute;top:5px;left:35%;">  '.$titr.' &nbsp'.$row_kala['name_kala'].'</div>
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
if(!isset($order))    $order='id_kala_detail DESC';
if(!isset($sortcode)) $sortcode='1';
if(!isset($show_img)) $show_img='';
	echo'
	 <td width="20%">کد</td>
	 <td width="60%">نام</td>';
	 if(($right_del)and($Mode==NULL)) echo'<td width="20%">حذف</td>';
     else if($Mode!=NULL) echo'<td width="20%">دستورات</td>';
	 echo'
	</tr>';
	if($Mode=='Insert' or $Mode=='Search')
	{
	 if ($Mode=='Insert') {$button_value="ايجاد"; $button_name="Insert_x";} 
	 else {$button_value="جستجو"; $button_name="Search_x";}
	  echo'
	  <tr class="table-odd">
	   <td><input type="text" class="textboxme2" name="code_kala_detail" value="'.$code_kala_detail.'" onkeypress="return isNumber(event)"/></td>
	   <td><input type="text" class="textboxme" name="name_kala_detail" value="'.$name_kala_detail.'" /></td>
	   <td><input type="submit" class="buttonme" name="'.$button_name.'" id="sabt" value="'.$button_value.'">
		   <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?code_kala_='.$code_kala_.'&PageNo_detail='.$PageNo_detail.'&RowPerPage='.$RowPerPage.'&PageNo='.$PageNo.'&order='.$order.'\'">
	   </td>
	  </tr>';
	}
	$i=0; 
	$q1="SELECT *,(SELECT name_kala FROM kala WHERE kala.code_kala=T.code_kala) nameKala 	
	     From $TableName T WHERE code_kala='$code_kala_' ".$_SESSION['mt_search_kala_det']." order by $order $Limit";	
	$all = $db->query($q1);
    while($row1=$db->fetch_assoc($all))
	{
     if($right_edt){$edtClick='onClick="window.location=\''.$FileName.'?Mode=Edit&id_kala_detail_='.$row1['id_kala_detail'].'&code_kala_='.$row1['code_kala'].'&PageNo_detail='.$PageNo_detail.'&RowPerPage='.$RowPerPage.'&PageNo='.$PageNo.'&order='.$order.'\'"';}	 
	 if($i++%2)
     echo'
     <tr class="table-odd"/>';
     else echo '
     <tr class="table-even"/>';
	 if($Mode=='Edit' and $row1['id_kala_detail']==$id_kala_detail_)
	 {
	  $exist_resid_detail=$db->get_from_where("count(code_kala_detail)","resid_kala_detail","code_kala_detail=".$row1['code_kala_detail']."");
	  //if((!SuperUser())and($exist_resid))//اگر سوپریوزر نبود و در رسید وجود داشت 	  
	  if(($exist_resid_detail))//اگر سوپریوزر نبود و در رسید وجود داشت 	  
	  {
	   echo'
	   <td><input type="text" class="textboxme2" readonly name="code_kala_detail" value="'.$row1['code_kala_detail'].'" title="غیر قابل تغییر"/></td>
	   <td><input type="text" class="textboxme" readonly name="name_kala_detail" value="'.$row1['name_kala_detail'].'" title="غیر قابل تغییر" style:width:100%/></td>';
	  }
	  else 
	  {echo'
	  <td><input type="text" class="textboxme2" name="code_kala_detail" value="'.$row1['code_kala_detail'].'" onkeypress="return isNumber(event)"/></td>
	  <td><input type="text" class="textboxme" name="name_kala_detail" value="'.$row1['name_kala_detail'].'" /></td>';
	  }
	  echo'
	  <td>
	    <input class="buttonme" type="submit" name="Edit_x" id="sabt" value="ثبت تغييرات" >
	    <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?code_kala_='.$code_kala_.'&PageNo_detail='.$PageNo_detail.'&RowPerPage='.$RowPerPage.'&PageNo='.$PageNo.'&order='.$order.'\'">
	  </td>';
	 }
     else
     {echo'
	  <td '.$edtClick.'>'.$row1['code_kala_detail'].'</td>
	  <td '.$edtClick.'>'.$row1['name_kala_detail'].'</td>';
	  if($right_del)
	  {echo'<td><img border="0" class="1" src="images/trash.png" width="20" height="20" 
	       onmouseOver="this.src=\'images/trash_hover.png\'" 
		   onmouseOut="this.src=\'images/trash.png\'" 
		   onClick="iconfirm(\''.$FileName.'?Delete_x=1&id_kala_detail_='.$row1['id_kala_detail'].'&code_kala_='.$code_kala_.'&PageNo_detail='.$PageNo_detail.'&RowPerPage='.$RowPerPage.'&PageNo='.$PageNo.'&order='.$order.'\',\'برای حذف قیمت '.$row1['nameKala'].'\')" /></td>';
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
	 <td width="10">&nbsp;</td>
	 <td width="24"><div onClick="window.open(\'print_gheymat_detail.php?code_kala_='.$code_kala_.'\',\'_blank\',\'width=720px,scrollbars=1\')" id="printer" title="چاپ"><a href="#"></a></div></td>
     <td width="10">&nbsp;</td>';
	 if($right_ins){
	 echo'<td width="70"><div onClick="window.location=\''.$FileName.'?Mode=Insert&code_kala_='.$code_kala_.'&PageNo_detail='.$PageNo_detail.'&RowPerPage='.$RowPerPage.'&PageNo='.$PageNo.'&order='.$order.'\'" id="btn-new" title="افزودن رکورد جديد" ><a href="#"></a></div></td>
 	 <td width="10">&nbsp;</td>';}
	 echo'<td width="70"><div onClick="window.location=\''.$FileName.'?Mode=Search&code_kala_='.$code_kala_.'&PageNo_detail='.$PageNo_detail.'&RowPerPage='.$RowPerPage.'&PageNo='.$PageNo.'&order='.$order.'\'" id="btn-search" title="جستجو" ><a href="#"></a></div></td>
	 <td width="10">&nbsp;</td>
	 <td width="70"><div onClick="window.location=\'kala.php?PageNo='.$PageNo.'\'" id="btn-back"  title="بازگشت به منوي اصلي"  ><a href="#"></a></div></td> 
	 <td width="20">&nbsp;</td>	   
	 <td width="22"><div '.$En_Prev.' onClick="window.location=\''.$FileName.'?code_kala_='.$code_kala_.'&PageNo_detail=1&RowPerPage='.$RowPerPage.'&PageNo='.$PageNo.'&order='.$order.'\'" id="btn-pageone" title="رويت اولين صفحه"><a href="#"></a></div></td>
	 <td width="2">&nbsp;</td>
	 <td width="22"><div '.$En_Prev.' onClick="window.location=\''.$FileName.'?code_kala_='.$code_kala_.'&PageNo_detail='.$PrevPage.'&RowPerPage='.$RowPerPage.'&PageNo='.$PageNo.'&order='.$order.'\'" id="btn-perevius" title="رفتن به صفحه قبلي"><a href="#"></a></div></td>
     <td width="2">&nbsp;</td>
	 <td width="40" align="center"><input type="text" name="PageNo_detail" value="'.$PageNo_detail.'" size="2" onChange="myform.submit()" onkeypress="return isNumber(event)" style="direction:ltr;text-align:center;"></td>		   
	 <td width="2">&nbsp;</td>		   
	 <td width="22"><div '.$En_Next.' onClick="window.location=\''.$FileName.'?code_kala_='.$code_kala_.'&PageNo_detail='.$NextPage.'&RowPerPage='.$RowPerPage.'&PageNo='.$PageNo.'&order='.$order.'\'" id="btn-forward" title="رفتن به صفحه بعدي"><a href="#"></a></div></td>
     <td width="2">&nbsp;</td>		   
	 <td width="22"><div '.$En_Next.' onClick="window.location=\''.$FileName.'?code_kala_='.$code_kala_.'&PageNo_detail='.$MaxPage.'&RowPerPage='.$RowPerPage.'&PageNo='.$PageNo.'&order='.$order.'\'" id="btn-pageend" title="رويت آخرين صفحه"><a href="#" ></a></div></td>
	 <td width="2">&nbsp;</td>
	 <td width="65" align="left"><span class="text1">تعداد خط :</span></td>
	 <td align="right"><input type="text" name="wRowPerPage" value="'.$RowPerPage.'" size="2" onChange="myform.submit()" onkeypress="return isNumber(event)" style="direction:ltr;text-align:center;"></td>	 
	 <td width="10">&nbsp;</td>';
     if ($_SESSION['mt_search_kala_det']) 
	 echo '
	 <td width="70"><input type="Button" class=buttonme  value="نمايش همه" onClick="window.location=\''.$FileName.'?code_kala_='.$code_kala_.'&PageNo_detail='.$PageNo_detail.'&RowPerPage='.$RowPerPage.'&PageNo='.$PageNo.'&order='.$order.'&open_filter=1\'"></td>';	 
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
</div>';
/************اجازه براي ذخيره اطلاعات************/
function isPermitSave($c_kala,$c_kala_d,$n_kala_d)
{
 $flag=false;
 if(!($c_kala and $c_kala_d and $n_kala_d))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script> alert('لطفا تمام فيلد ها را تکميل نماييد')</script>";
   return $flag;
 } 
 else $flag=true;
 if(!empty($c_kala_d))//تکراری نبودن این کد کالا 
 { 
    $q8="SELECT code_kala_detail FROM kala_detail WHERE code_kala_detail='$c_kala_d'";
    $res8=mysql_query($q8);
    if(mysql_num_rows($res8)>0){
    echo"<script>alert('اين کد کالا قبلاً ثبت شده است !')</script>";
    $flag=false;
    return $flag;
   }
  else $flag=true;
 }
 else $flag=true;
 if(!empty($n_kala_d))//تکراری نبودن نام  
 { 
    $q8="SELECT name_kala_detail FROM kala_detail WHERE name_kala_detail='$n_kala_d'";
    $res8=mysql_query($q8);
    if(mysql_num_rows($res8)>0){
    echo"<script>alert('اين نام کالا قبلا ثبت شده است')</script>";
    $flag=false;
    return $flag;
   }
  else $flag=true;
 }
 else $flag=true;  
return $flag;
}
/**********اجازه براي ويرايش اطلاعات********/
function isPermitEdit($c_kala,$c_kala_d,$n_kala_d,$this_id)
{
  $flag=false;
  if(!($c_kala and $c_kala_d and $n_kala_d))//پر بودن فيلدها
  {
   $flag=false;
   echo"<script>window.alert('لطفا تمام فيلد ها را تکميل نماييد');</script>";
   return $flag;
  } 
  else $flag=true;
  if(!empty($c_kala_d))//تکراری نبودن این کد کالا 
  {  
    $q10="SELECT * FROM kala_detail WHERE code_kala_detail='$c_kala_d' AND id_kala_detail!=$this_id";
    $res10=mysql_query($q10);
    $row10=mysql_fetch_assoc($res10);
    if(mysql_num_rows($res10)>0){
    echo"<script>alert('اين کد کالا قبلاً ثبت شده است !')</script>";
    $flag=false;
    return $flag;
    }
   else $flag=true;
  }
  else $flag=true;
  if(!empty($n_kala_d))//تکراری نبودن نام  
  {  
    $q10="SELECT * FROM kala_detail WHERE name_kala_detail='$n_kala_d' AND id_kala_detail!=$this_id";
    $res10=mysql_query($q10);
    $row10=mysql_fetch_assoc($res10);
    if(mysql_num_rows($res10)>0){
    echo"<script>alert('اين نام کالا قبلا ثبت شده است')</script>";
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
 if(isPermitSave($code_kala_,$code_kala_detail,$name_kala_detail))
 { 
  $Mode='';
  $insert_q=("INSERT INTO $TableName(code_kala,code_kala_detail,name_kala_detail)VALUES('$code_kala_','$code_kala_detail','$name_kala_detail')");  
  $insert_res=mysql_query($insert_q);
  if($insert_res)
  {
   $max_id=$db->get_from_where("Max(id_kala_detail)","$TableName","");  
   $log_i=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$max_id','ثبت',".($yymmdd).",'$logtime')");  
   echo '<script>window.location=\''.$FileName.'?code_kala_='.$code_kala_.'&PageNo_detail='.$PageNo_detail.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\' </script>';
  }
  else  $message ='<span style="color:red;font: bold 12px tahoma;"> * مشکلی در ثبت به وجود آمده است ! *</span>';
 }
}
/************EDIT BUTTON********/// اصلاح اطلاعات
if (isset($Edit_x))
{
 if(isPermitEdit($code_kala_,$code_kala_detail,$name_kala_detail,$id_kala_detail_))
 {
  $Mode=''; 
  $edit_q=("UPDATE $TableName SET code_kala='$code_kala_',code_kala_detail='$code_kala_detail',name_kala_detail='$name_kala_detail' WHERE `id_kala_detail`='$id_kala_detail_';");	
  $edit_res=mysql_query($edit_q);
  if(($edit_res) and (mysql_affected_rows()!=0))
  {
   $log_e=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_kala_detail_','ویرایش',".($yymmdd).",'$logtime')");  
   echo '<script>window.location=\''.$FileName.'?code_kala_='.$code_kala_.'&PageNo_detail='.$PageNo_detail.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\' </script>';
  }
  else if(mysql_affected_rows()==0)   echo '<script>window.location=\''.$FileName.'?code_kala_='.$code_kala_.'&PageNo_detail='.$PageNo_detail.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\' </script>';
  else $message ='<span style=" color:red;font: bold 12px tahoma;"> * مشکلی در ویرایش مشخصات به وجود آمده است ! *</span>'; 
 } 
}
/********************END********************/	
echo'
'.$message.'
</form>
</body>
</html>';	
?>