<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="gheymat_jarime_detail.php";
$TableName="gheymat_detail";
$logtime=date('H:i:s');
$right_ins=0;$right_edt=0;$right_del=0;
if (right(61)) $right_ins=1;
if (right(62)) $right_edt=1;
if (right(63)) $right_del=1;
$titr='جزئیات جدول قیمت ها'; 
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
// خواندن اطلاعات جدول قيمت ها
$c=$db->query("SELECT * FROM gheymat WHERE id_gheymat='$cid'");
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
 if($code_kala)  $temp.=" and code_kala LIKE '$code_kala'";
 if($fee)        $temp.=" and fee LIKE '%$fee%'";
 if($zarib)      $temp.=" and zarib LIKE '%$zarib%'";
 if($temp) {
 $PageNo_detail=1;
 $_SESSION['mt_search_gheymat_det']=$temp;} else $_SESSION['mt_search_gheymat_det']="";
}
/********************PAGING***********************/
if(isset($_POST['wRowPerPage'])) $RowPerPage=$_POST['wRowPerPage'];
if(!isset($RowPerPage)) $RowPerPage=8;
$res = $db->query("SELECT COUNT(*) FROM $TableName WHERE id_gheymat='$cid' ".$_SESSION['mt_search_gheymat_det']." and deleted=0");
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
 $del_q = "UPDATE $TableName SET deleted=1 WHERE id=$id_ AND
          ($code_kala_ NOT IN (SELECT code_kala FROM resid_detail WHERE code_kala=$code_kala_ AND id_gheymat_this=$cid AND deleted=0))";
 $del_res = $db->query($del_q,'مشکلي در حذف به وجود آمده است');
 if(mysql_affected_rows()==0)
  echo"<script>alert('این عنوان در سایر فرم ها استفاده شده است،شما مجاز به حذف آن نیستید!')</script>";
 else if($del_res)
  $log_d=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_','حذف',".($yymmdd).",'$logtime')");
}
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.code_kala.focus();">
<form method="post" name="myform" onkeydown="enterIE();">
<div align="center">
<table width="95%" height="100%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr>
  <td class="title">
   <div style="position:absolute;top:5px;left:30%;">  جزئيات جدول قيمت جریمه &nbsp'.$r['id_gheymat'].' با تاريخ اعتبار &nbsp'.$r['tarikh_etebar'].'</div>
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
if(!isset($show_img)) $show_img='';
	if($sortcode=='1')
	{echo'<td width="40%" title="مرتب سازی صعودی نام کالا" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?cid='.$cid.'&PageNo_detail='.$PageNo_detail.'&RowPerPage='.$RowPerPage.'&PageNo='.$PageNo.'&order=nameKala ASC&sortcode=2&show_img=1\'"/> نام کالا ';
	  if($show_img=='1')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sortcode=='2')
	{echo'<td width="40%" title="مرتب سازی نزولی نام کالا" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?cid='.$cid.'&PageNo_detail='.$PageNo_detail.'&RowPerPage='.$RowPerPage.'&PageNo='.$PageNo.'&order=nameKala DESC&sortcode=1&show_img=1\'"/> نام کالا ';
	  if($show_img=='1')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	echo'
	 <td width="20%">فی</td>
	 <td width="20%">ضريب</td>';
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
	   <td>'.listbox("code_kala",$code_kala,"code_kala","name_kala","kala","1=1 ORDER BY name_kala","class='text4'").'</td>
	   <td><input type="text" class="textboxme2" name="fee" value="'.$fee.'" onkeypress="return isNumber(event)"/></td>
	   <td><input type="text" class="textboxme2" name="zarib" value="'.$zarib.'" onkeypress="return isNumber(event)"/></td>
	   <td><input type="submit" class="buttonme" name="'.$button_name.'" id="sabt" value="'.$button_value.'">
		   <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?cid='.$cid.'&PageNo_detail='.$PageNo_detail.'&RowPerPage='.$RowPerPage.'&PageNo='.$PageNo.'&order='.$order.'\'">
	   </td>
	  </tr>';
	}
	$i=0; 
	$q1="SELECT *,(SELECT name_kala FROM kala WHERE kala.code_kala=T.code_kala) nameKala 	
	     From $TableName T WHERE id_gheymat='$cid' ".$_SESSION['mt_search_gheymat_det']." and deleted=0 order by $order $Limit";	
	$all = $db->query($q1);
    while($row1=$db->fetch_assoc($all))
	{
     if($right_edt){$edtClick='onClick="window.location=\''.$FileName.'?Mode=Edit&id_='.$row1['id'].'&cid='.$row1['id_gheymat'].'&PageNo_detail='.$PageNo_detail.'&RowPerPage='.$RowPerPage.'&PageNo='.$PageNo.'&order='.$order.'\'"';}	 
	 if($i++%2)
     echo'
     <tr class="table-odd"/>';
     else echo '
     <tr class="table-even"/>';
	 if($Mode=='Edit' and $row1['id']==$id_)
	 {
	  $exist_resid_detail=$db->get_from_where("count(code_kala)","resid_detail","code_kala=".$row1['code_kala']." AND id_gheymat_this=".$row1['id_gheymat']."");
	  //if((!SuperUser())and($exist_resid))//اگر سوپریوزر نبود و در رسید وجود داشت 	  
	  if(($exist_resid_detail))//اگر سوپریوزر نبود و در رسید وجود داشت 	  
	  {
	   echo'<td><input type="hidden" name="code_kala" value="'.$row1['code_kala'].'"/>'.listboxMe("code_kala",$row1['code_kala'],"code_kala","name_kala","kala","1=1 ORDER BY name_kala","class='text4' disabled").'</td>	  
	   <td><input type="text" class="textboxme2" readonly name="fee" value="'.$row1['fee'].'" title="غیر قابل تغییر"/></td>
	   <td><input type="text" class="textboxme2" readonly name="zarib" value="'.$row1['zarib'].'" title="غیر قابل تغییر" style:width:100%/></td>';
	  }
	  else 
	  {echo'
	  <td>'.listboxMe("code_kala",$row1['code_kala'],"code_kala","name_kala","kala","1=1 ORDER BY name_kala","class='text4'").'</td>	  
	  <td><input type="text" class="textboxme2" name="fee" value="'.$row1['fee'].'" onkeypress="return isNumber(event)"/></td>
	  <td><input type="text" class="textboxme2" name="zarib" value="'.$row1['zarib'].'" onkeypress="return isNumber(event)" style:width:100%/></td>';
	  }
	  echo'
	  <td>
	    <input class="buttonme" type="submit" name="Edit_x" id="sabt" value="ثبت تغييرات" >
	    <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?cid='.$cid.'&PageNo_detail='.$PageNo_detail.'&RowPerPage='.$RowPerPage.'&PageNo='.$PageNo.'&order='.$order.'\'">
	  </td>';
	 }
     else
     {echo'
	  <td '.$edtClick.'>'.$row1['nameKala'].'</td>
	  <td '.$edtClick.'>'.virgul($row1['fee']).'</td>
	  <td '.$edtClick.'>'.$row1['zarib'].'</td>';
	  if($right_del)
	  {echo'<td><img border="0" class="1" src="images/trash.png" width="20" height="20" 
	       onmouseOver="this.src=\'images/trash_hover.png\'" 
		   onmouseOut="this.src=\'images/trash.png\'" 
		   onClick="iconfirm(\''.$FileName.'?Delete_x=1&id_='.$row1['id'].'&cid='.$cid.'&code_kala_='.$row1['code_kala'].'&PageNo_detail='.$PageNo_detail.'&RowPerPage='.$RowPerPage.'&PageNo='.$PageNo.'&order='.$order.'\',\'برای حذف قیمت '.$row1['nameKala'].'\')" /></td>';
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
	 <td width="24"><div onClick="window.open(\'print_gheymat_detail.php?cid='.$cid.'\',\'_blank\',\'width=720px,scrollbars=1\')" id="printer" title="چاپ"><a href="#"></a></div></td>
     <td width="10">&nbsp;</td>';
	 if($right_ins){
	 echo'<td width="70"><div onClick="window.location=\''.$FileName.'?Mode=Insert&cid='.$cid.'&PageNo_detail='.$PageNo_detail.'&RowPerPage='.$RowPerPage.'&PageNo='.$PageNo.'&order='.$order.'\'" id="btn-new" title="افزودن رکورد جديد" ><a href="#"></a></div></td>
 	 <td width="10">&nbsp;</td>';}
	 echo'<td width="70"><div onClick="window.location=\''.$FileName.'?Mode=Search&cid='.$cid.'&PageNo_detail='.$PageNo_detail.'&RowPerPage='.$RowPerPage.'&PageNo='.$PageNo.'&order='.$order.'\'" id="btn-search" title="جستجو" ><a href="#"></a></div></td>
	 <td width="10">&nbsp;</td>
	 <td width="70"><div onClick="window.location=\'gheymat_jarime.php?PageNo='.$PageNo.'\'" id="btn-back"  title="بازگشت به منوي اصلي"  ><a href="#"></a></div></td> 
	 <td width="20">&nbsp;</td>	   
	 <td width="22"><div '.$En_Prev.' onClick="window.location=\''.$FileName.'?cid='.$cid.'&PageNo_detail=1&RowPerPage='.$RowPerPage.'&PageNo='.$PageNo.'&order='.$order.'\'" id="btn-pageone" title="رويت اولين صفحه"><a href="#"></a></div></td>
	 <td width="2">&nbsp;</td>
	 <td width="22"><div '.$En_Prev.' onClick="window.location=\''.$FileName.'?cid='.$cid.'&PageNo_detail='.$PrevPage.'&RowPerPage='.$RowPerPage.'&PageNo='.$PageNo.'&order='.$order.'\'" id="btn-perevius" title="رفتن به صفحه قبلي"><a href="#"></a></div></td>
     <td width="2">&nbsp;</td>
	 <td width="40" align="center"><input type="text" name="PageNo_detail" value="'.$PageNo_detail.'" size="2" onChange="myform.submit()" onkeypress="return isNumber(event)" style="direction:ltr;text-align:center;"></td>		   
	 <td width="2">&nbsp;</td>		   
	 <td width="22"><div '.$En_Next.' onClick="window.location=\''.$FileName.'?cid='.$cid.'&PageNo_detail='.$NextPage.'&RowPerPage='.$RowPerPage.'&PageNo='.$PageNo.'&order='.$order.'\'" id="btn-forward" title="رفتن به صفحه بعدي"><a href="#"></a></div></td>
     <td width="2">&nbsp;</td>		   
	 <td width="22"><div '.$En_Next.' onClick="window.location=\''.$FileName.'?cid='.$cid.'&PageNo_detail='.$MaxPage.'&RowPerPage='.$RowPerPage.'&PageNo='.$PageNo.'&order='.$order.'\'" id="btn-pageend" title="رويت آخرين صفحه"><a href="#" ></a></div></td>
	 <td width="2">&nbsp;</td>
	 <td width="65" align="left"><span class="text1">تعداد خط :</span></td>
	 <td align="right"><input type="text" name="wRowPerPage" value="'.$RowPerPage.'" size="2" onChange="myform.submit()" onkeypress="return isNumber(event)" style="direction:ltr;text-align:center;"></td>	 
	 <td width="10">&nbsp;</td>';
     if ($_SESSION['mt_search_gheymat_det']) 
	 echo '
	 <td width="70"><input type="Button" class=buttonme  value="نمايش همه" onClick="window.location=\''.$FileName.'?cid='.$cid.'&PageNo_detail='.$PageNo_detail.'&RowPerPage='.$RowPerPage.'&PageNo='.$PageNo.'&order='.$order.'&open_filter=1\'"></td>';	 
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
function isPermitSave($a,$b,$c,$d)
{
 $flag=false;
 if(!($a and $b and $c))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script> alert('لطفا تمام فيلد ها را تکميل نماييد')</script>";
   return $flag;
 } 
 else $flag=true;
 if(!empty($a))//تکراری نبودن این کد کالا در جدول جزئیات قیمت
 { 
    $q8="SELECT code_kala FROM gheymat_detail WHERE code_kala='$a' AND id_gheymat='$d'";
    $res8=mysql_query($q8);
    if(mysql_num_rows($res8)>0){
    echo"<script>alert('برای این کالا در این جدول قبلاً قیمت ثبت شده است')</script>";
    $flag=false;
    return $flag;
   }
  else $flag=true;
 }
 else $flag=true; 
 if(!justNumber($b))//عدد بودن في 
 {
   $flag=false;
   echo"<script>alert('فيلد فی نامعتبر است!')</script>";
   return $flag;
 }
 else $flag=true;
 //else if((!empty($zarib)) and (preg_match('/^[0-9]+$/', $zarib) === 0))//عدد بودن ضريب
 //echo"<script>alert('فيلد ضريب نامعتبر است')</script>"; 
return $flag;
}
/**********اجازه براي ويرايش اطلاعات********/
function isPermitEdit($a,$b,$c,$this_id,$e)
{
  $flag=false;
  if(!($a and $b and $c))//پر بودن فيلدها
  {
   $flag=false;
   echo"<script>window.alert('لطفا تمام فيلد ها را تکميل نماييد');</script>";
   return $flag;
  } 
  else $flag=true;
  if(!empty($a))//تکراری نبودن این کد کالا در جدول جزئیات قیمت
  {  
    $q10="SELECT * FROM gheymat_detail WHERE code_kala='$a' AND id_gheymat='$e' AND id!=$this_id";
    $res10=mysql_query($q10);
    $row10=mysql_fetch_assoc($res10);
    if(mysql_num_rows($res10)>0){
    echo"<script>alert('برای این کالا در این جدول قبلاً قیمت ثبت شده است')</script>";
    $flag=false;
    return $flag;
    }
   else $flag=true;
  }
  else $flag=true;
  if (!justNumber($b))//عدد بودن في 
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
 if(isPermitSave($code_kala,$fee,$zarib,$cid))
 { 
  $Mode='';
  $insert_q=("INSERT INTO $TableName(id_gheymat,code_kala,fee,zarib,deleted)VALUES('$cid','$code_kala','$fee','$zarib',0)");  
  $insert_res=mysql_query($insert_q);
  if($insert_res)
  {
   $max_id=$db->get_from_where("Max(id)","$TableName","");  
   $log_i=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$max_id','ثبت',".($yymmdd).",'$logtime')");  
   echo '<script>window.location=\''.$FileName.'?cid='.$cid.'&PageNo_detail='.$PageNo_detail.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\' </script>';
  }
  else  $message ='<span style="color:red;font: bold 12px tahoma;"> * مشکلی در ثبت قیمت به وجود آمده است ! *</span>';
 }
}
/************EDIT BUTTON********/// اصلاح اطلاعات
if (isset($Edit_x))
{
 if(isPermitEdit($code_kala,$fee,$zarib,$id_,$cid))
 {
  $Mode=''; 
  $edit_q=("UPDATE $TableName SET id_gheymat='$cid',code_kala='$code_kala',fee='$fee',zarib='$zarib' WHERE `id`='$id_';");	
  $edit_res=mysql_query($edit_q);
  if(($edit_res) and (mysql_affected_rows()!=0))
  {
   $log_e=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_','ویرایش',".($yymmdd).",'$logtime')");  
   echo '<script>window.location=\''.$FileName.'?cid='.$cid.'&PageNo_detail='.$PageNo_detail.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\' </script>';
  }
  else if(mysql_affected_rows()==0)   echo '<script>window.location=\''.$FileName.'?cid='.$cid.'&PageNo_detail='.$PageNo_detail.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\' </script>';
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