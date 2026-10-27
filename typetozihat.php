<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="typetozihat.php";
$TableName="mt_typetozih";
$logtime=date('H:i:s');
$right_ins=0;$right_edt=0;$right_del=0;
if (right(330)) $right_ins=1;
if (right(331)) $right_edt=1;
if (right(332)) $right_del=1; 
$formName=$db->get_from_where("form_name","mt_type","type_id='".$typeID_."'");     
echo'
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>توضیحات</title>
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
if(!(isset($Mode))) $Mode='';
/********************PAGING***********************/
if(isset($_POST['wRowPerPage'])) $RowPerPage=$_POST['wRowPerPage'];
if(!isset($RowPerPage)) $RowPerPage=8;
$res = mysql_query("SELECT COUNT(*) FROM $TableName WHERE type_id=$typeID_ AND code_ostan=$mt_gl_code_ostan  AND code_anbar=$mt_gl_code_anbar");
$row = mysql_fetch_array($res);
$cnt = $row[0];
$MaxPage=intval($cnt/$RowPerPage);
if ($cnt%$RowPerPage) $MaxPage++;
if (!$MaxPage) $MaxPage=1;
if (!isset($PageNo_detail)) $PageNo_detail=1; 
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
/************اجازه براي ذخيره اطلاعات************/
function isPermitSave($gl_c_o,$gl_c_a,$a,$b)
{
 $flag=false;
 if(!($gl_c_o and $gl_c_a) or $gl_c_o==-1 or $gl_c_a==-1)//اگر سشن استان و انبار خالی بود
 {   
   $flag=false;
   echo"<script> alert('لطفاً استان و انبار مورد نظر خود را از پایین صفحه انتخاب نمایید!')</script>";
   return $flag;
 }
 else $flag=true; 
 if(!($a and $b))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script> alert('لطفا تمام فيلد ها را تکميل نماييد')</script>";
   return $flag;
 } 
 else $flag=true;  
return $flag;
}
/**********اجازه براي ويرايش اطلاعات********/
function isPermitEdit($a,$b,$c)
{
  $flag=false;
  if(!($a and $b))//پر بودن فيلدها
  {
   $flag=false;
   echo"<script> alert('لطفا تمام فيلد ها را تکميل نماييد')</script>";
   return $flag;
  } 
  else $flag=true;
 return $flag;
}	
/*************INSERT BUTTON******/// ثبت اطلاعات    
if(isset($Insert_x))
{ 
 if(isPermitSave($mt_gl_code_ostan,$mt_gl_code_anbar,$code_tozihat,$form_tozihat)) 
 {
  $Mode='';
  $form_tozihat=str_replace("ي","ی",$form_tozihat);
  $form_tozihat=str_replace("ك","ک",$form_tozihat);
  $insert_q=("INSERT INTO $TableName(type_id,code_tozihat,code_ostan,code_anbar,form_tozihat)VALUES('$typeID_','$code_tozihat','$mt_gl_code_ostan','$mt_gl_code_anbar',TRIM('$form_tozihat'))");
  $insert_res=mysql_query($insert_q);
  if($insert_res){
    $max_id=$db->get_from_where("Max(id)","$TableName",""); 
    $log_i=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$max_id','ثبت',".($yymmdd).",'$logtime')");//کوئری لاگ 
  }
  else  $message ='<span style="color:red;font: bold 12px tahoma;"> * مشکلی در ثبت به وجود آمده است ! *</span>';
 }
}
/************EDIT BUTTON********/// اصلاح اطلاعات
if (isset($Edit_x))
{
 if(isPermitEdit($code_tozihat,$form_tozihat,$id_))
 {
  $Mode='';
  $form_tozihat=str_replace("ي","ی",$form_tozihat);
  $form_tozihat=str_replace("ك","ک",$form_tozihat);
  $edit_q=("UPDATE $TableName SET form_tozihat='$form_tozihat' WHERE id='$id_';");
  $edit_res=mysql_query($edit_q);
  if(($edit_res) and (mysql_affected_rows()!=0)) $log_e=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_','ویرایش',".($yymmdd).",'$logtime')");//کوئری لاگ 
  else $message ='<span style=" color:red;font: bold 12px tahoma;"> * مشکلی در ویرایش مشخصات به وجود امده است ! *</span>';
 } 
}
/************DELETE BUTTON********/// حذف اطلاعات
if (isset($Delete_x))
{
 $Mode='';
 $del_q ="DELETE FROM $TableName WHERE id=$id_";
 $del_res = $db->query($del_q);
 if($del_res) $log_d=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_','حذف',".($yymmdd).",'$logtime')");//کوئری لاگ
} 
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.form_tozihat.focus();">
<form method="post" name="myform" onkeydown="enterIE()"
<div align="center">
<table width="80%" height="100%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr>
  <td class="title">
   <div style="position:absolute;top:5px;left:40%;">توضیحات چاپ فرم '.$formName.'</div>
   <div class="pagecover">[صفحه:&nbsp'.$PageNo.' از '.$MaxPage.']</div>
  </td>  
 </tr>
 <!--پايان هدر-->
 <!-- مرکز صفحه-->	
 <tr>
  <td height="100%">
   <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
	<tr class="table-title">';
/********************sort field***********************/
if(!isset($order)) $order='id DESC';
	 echo'
	 <td width="10%">کد</td>
	 <td width="70%">توضیحات</td>';
	 if(($right_del)and($Mode==NULL)) echo'<td width="20%">حذف</td>';
     else if($Mode!=NULL) echo'<td width="20%">دستورات</td>';	
	 echo'
	</tr>';
	if($Mode=='Insert')
	{
	  $code_tozihat=$db->get_from_where("Max(code_tozihat)","$TableName","code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND type_id='$typeID_'");     
	  $code_tozihat++;
	  $button_value="ايجاد"; $button_name="Insert_x"; 
	  echo'
	  <tr class="table-odd">
	   <td><input type="text" class="textboxme" name="code_tozihat" value="'.$code_tozihat.'" readonly/></td>
	   <td><input type="text" class="textboxme" name="form_tozihat" value="'.$form_tozihat.'" /></td>
	   <td><input type="submit" class="buttonme" name="'.$button_name.'" id="sabt" value="'.$button_value.'">
		   <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?typeID_='.$typeID_.'&PageNo_detail='.$PageNo_detail.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'">
	   </td>
	  </tr>';
	}
	$i=0;
    $q1="SELECT * From $TableName T WHERE type_id=$typeID_ AND code_ostan=$mt_gl_code_ostan  AND code_anbar=$mt_gl_code_anbar order by $order $Limit";
	$allVahedkala = $db->query($q1);
    while($row1=$db->fetch_assoc($allVahedkala))
	{
     if($right_edt){$edtClick='onClick="window.location=\''.$FileName.'?Mode=Edit&id_='.$row1['id'].'&typeID_='.$typeID_.'&PageNo_detail='.$PageNo_detail.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'"';}	 
     if($i++%2)
     echo'
     <tr class="table-odd"/>';
     else echo '
     <tr class="table-even"/>';
	 if($Mode=='Edit' and $row1['id']==$id_)
	 {
	  echo '
	  <td><input type="text" class="textboxme2" name="code_tozihat" value="'.$row1['code_tozihat'].'" style="width:50px" readonly></td>
	  <td><input type="text" class="textboxme" name="form_tozihat" value="'.$row1['form_tozihat'].'"></td>
	  <td>
	   <input class="buttonme" type="submit" name="Edit_x" id="sabt" value="ثبت تغييرات" >
	   <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?typeID_='.$typeID_.'&PageNo_detail='.$PageNo_detail.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'">
	  </td>';
	 }
     else
     {echo'
	  <td '.$edtClick.'>'.$row1['code_tozihat'].'</td>
	  <td '.$edtClick.'>'.$row1['form_tozihat'].'</td>';
	  if(($right_del))
	  {echo'<td><img border="0" src="images/trash.png" width="20" height="20" title="حذف" 
	   	  onmouseOver="this.src=\'images/trash_hover.png\'" 
		  onmouseOut="this.src=\'images/trash.png\'" 
	      onClick="iconfirm(\''.$FileName.'?Delete_x=1&id_='.$row1['id'].'&code_tozihat_='.$row1['code_tozihat'].'&form_tozihat_='.$row1['form_tozihat'].'&typeID_='.$typeID_.'&PageNo_detail='.$PageNo_detail.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'\',\'برای حذف توضیحات با کد '.$row1['code_tozihat'].' از فرم '.$formName.'\')" /></td>';
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
  </td>
 </tr> 
 <!--پايان مرکز صفحه -->';
 echo'
 <!-- فوتر-->
 <tr class="footer">
  <td>
   <table width="100%" border="0" cellspacing="0" cellpadding="0" height=100%  style="margin-bottom:20px;">';
   if (!$Mode)
   {echo '	  			
	<tr>
     <td width="10">&nbsp;</td>';
	 if($right_ins){
	 echo'
	 <td width="70"><div onClick="window.location=\''.$FileName.'?Mode=Insert&typeID_='.$typeID_.'&PageNo_detail='.$PageNo_detail.'&RowPerPage='.$RowPerPage.'&PageNo='.$PageNo.'&order='.$order.'\'" id="btn-new" title="افزودن رکورد جديد" ><a href="#"></a></div></td>
 	 <td width="10">&nbsp;</td>';}
	 echo'
	 <!--<td width="70"><div onClick="window.location=\''.$FileName.'?Mode=Search&typeID_='.$typeID_.'&PageNo_detail='.$PageNo_detail.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-search" title="جستجو" ><a href="#"></a></div></td>
	 <td width="10">&nbsp;</td>-->
	 <td width="70"><div onClick="window.location=\'types.php?PageNo='.$PageNo.'\'" id="btn-back"  title="بازگشت"  ><a href="#"></a></div></td> 
	 <td width="20">&nbsp;</td>	   
	 <td width="22"><div '.$En_Prev.' onClick="window.location=\''.$FileName.'?typeID_='.$typeID_.'&PageNo='.$PageNo.'&PageNo_detail=1&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-pageone" title="رويت اولين صفحه"><a href="#"></a></div></td>
	 <td width="2">&nbsp;</td>
	 <td width="22"><div '.$En_Prev.' onClick="window.location=\''.$FileName.'?typeID_='.$typeID_.'&PageNo='.$PageNo.'&PageNo_detail='.$PrevPage.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-perevius" title="رفتن به صفحه قبلي"><a href="#"></a></div></td>
     <td width="2">&nbsp;</td>
	 <td width="40" align="center"><input type="text" name="PageNo_detail" value="'.$PageNo_detail.'" size="2" onChange="myform.submit()" onkeypress="return isNumber(event)" style="direction:ltr;text-align:center;"></td>		   
	 <td width="2">&nbsp;</td> 
	 <td width="22"><div '.$En_Next.' onClick="window.location=\''.$FileName.'?typeID_='.$typeID_.'&PageNo='.$PageNo.'&PageNo_detail='.$NextPage.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-forward" title="رفتن به صفحه بعدي"><a href="#"></a></div></td>
     <td width="2">&nbsp;</td>	   
	 <td width="22"><div '.$En_Next.' onClick="window.location=\''.$FileName.'?typeID_='.$typeID_.'&PageNo='.$PageNo.'&PageNo_detail='.$MaxPage.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-pageend" title="رويت آخرين صفحه"><a href="#" ></a></div></td>
	 <td width="2">&nbsp;</td> 
	 <td width="65" align="left"><span class="text1">تعداد خط :</span></td>
	 <td align="right"><input type="text" name="wRowPerPage" value="'.$RowPerPage.'" size="2" onChange="myform.submit()"  onkeypress="return isNumber(event)" style="direction:ltr;text-align:center;"></td>
	 <td width="10">&nbsp;</td>';
     // if ($_SESSION['mt_search_tozih']) 
	 // echo '
	 // <td width="70"><input type="Button" class=buttonme  value="نمايش همه" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&open_filter=1\'"></td>';	 
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
</div>
'.$message .'
</form>
</body>
</html>';	
?>