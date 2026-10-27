<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="bedehkar_bestankar.php";
$TableName="bedehkar_bestankar";
$logtime=date('H:i:s'); 
$right_ins=0;$right_edt=0;$right_del=0;
if (right(338)) $right_ins=1;
if (right(339)) $right_edt=1;
if (right(340)) $right_del=1;
echo'
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>جدول کد بدهکار و بستانکار</title>
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
  $_SESSION['mt_search_bed_bes']="";
} 
if(isset($Search_x))
{
 $Mode='';
 $Search_x=""; 
 $temp='';
 if($noe_sanad)        $temp.=" and noe_sanad LIKE '$noe_sanad'";
 //if($noe_malekiyat)    $temp.=" and noe_malekiyat LIKE '$noe_malekiyat'";
 if($status_peymankar) $temp.=" and status_peymankar LIKE '$status_peymankar'";
 if($noe_mabda)        $temp.=" and noe_mabda LIKE '$noe_mabda'";
 if($code_bedehkar)    $temp.=" and code_bedehkar LIKE '%$code_bedehkar%'";
 if($sharh_bedehkar)   $temp.=" and sharh_bedehkar LIKE '%$sharh_bedehkar%'";
 if($code_bestankar)   $temp.=" and code_bestankar LIKE '%$code_bestankar%'";
 if($sharh_bestankar)  $temp.=" and sharh_bestankar LIKE '%$sharh_bestankar%'";
 if($temp) {$PageNo=1;$_SESSION['mt_search_bed_bes']=$temp;} else $_SESSION['mt_search_bed_bes']="";
}
/********************PAGING***********************/
if(isset($_POST['wRowPerPage'])) $RowPerPage=$_POST['wRowPerPage'];
if(!isset($RowPerPage)) $RowPerPage=8;
$res = mysql_query("SELECT COUNT(*) FROM $TableName where 1=1 ".$_SESSION['mt_search_bed_bes']."");
$row = mysql_fetch_array($res);
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
function isPermitSave($noe_s,$n_malek,$n_ma,$c_bede,$c_bes)
{
 $flag=false;
 if(!($noe_s))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script> alert('لطفاً فیلدهای ستاره دار را تکمیل نمایید');</script>";
   return $flag;
 } 
 else $flag=true;
 // if(!empty($c_bede))
 // {
  // if((strlen($c_bede)>6)or(strlen($c_bede)<6))//شش رقمی بودن کد بدهکار
  // {   
    // $flag=false;
    // echo"<script> alert('برای کد بدهکار شش رقم وارد نمایید');</script>";
    // return $flag;
  // }
 // } 
 // else $flag=true;
 // if(!empty($c_bes))
 // {
  // if(($n_ma==1)and((strlen($c_bes)>6)or(strlen($c_bes)<6)))//شش رقمی بودن کد بستانکار
  // {   
    // $flag=false;
    // echo"<script> alert('برای کد بستانکار شش رقم وارد نمایید');</script>";
    // return $flag;
  // } 
  // else $flag=true;
 // } 
return $flag;
}
/**********اجازه براي ويرايش اطلاعات********/
function isPermitEdit($noe_s,$n_malek,$n_ma,$c_bede,$c_bes)
{
  $flag=false;
  if(!($noe_s))//پر بودن فيلدها
  {
   $flag=false;
   echo"<script> alert('لطفاً فیلدهای ستاره دار را تکمیل نمایید');</script>";
   return $flag;
  } 
  else $flag=true;
  // if(!empty($c_bede))
  // {
    // if((strlen($c_bede)>6)or(strlen($c_bede)<6))//شش رقمی بودن کد بدهکار
    // {   
     // $flag=false;
     // echo"<script> alert('برای کد بدهکار شش رقم وارد نمایید');</script>";
     // return $flag;
    // } 
    // else $flag=true;
  // }
  // if(!empty($c_bes))
  // {  
    // if(($n_ma==1)and((strlen($c_bes)>6)or(strlen($c_bes)<6)))//شش رقمی بودن کد بستانکار
    // {   
     // $flag=false;
     // echo"<script> alert('برای کد بستانکار شش رقم وارد نمایید');</script>";
     // return $flag;
    // } 
    // else $flag=true;
  // }	
 return $flag;
}
/************EDIT BUTTON********/// اصلاح اطلاعات
if (isset($Edit_x))
{
 //if(isPermitEdit($noe_sanad,$noe_malekiyat,$noe_mabda,$code_bedehkar,$code_bestankar))
 if(isPermitEdit($noe_sanad))
 {
  $Mode='';
  $edit_q=("UPDATE $TableName SET noe_sanad='$noe_sanad',status_peymankar='$status_peymankar',noe_mabda='$noe_mabda',
            code_bedehkar=TRIM('$code_bedehkar'),sharh_bedehkar=TRIM('$sharh_bedehkar'),code_bestankar=TRIM('$code_bestankar'),sharh_bestankar=TRIM('$sharh_bestankar') WHERE id='$id_';");
  $edit_res=mysql_query($edit_q);
  if(($edit_res) and (mysql_affected_rows()!=0)){
   $log_e=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_','ویرایش',".($yymmdd).",'$logtime')");  
   //echo '<script>window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\' </script>';
  }
  else if(mysql_affected_rows()==0) echo '';
  else $message ='<span style=" color:red;font: bold 12px tahoma;"> * مشکلی در ویرایش مشخصات به وجود آمده است ! *</span>';
 } 
}	
/************DELETE BUTTON********/// حذف اطلاعات
if (isset($Delete_x))
{
 $Mode='';
 $del_q="DELETE FROM $TableName WHERE id=$id_";
 $del_res = mysql_query($del_q);
 if($del_res) $log_d=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_','حذف',".($yymmdd).",'$logtime')");//کوئری لاگ 
 else $message ='<span style=" color:red;font: bold 12px tahoma;"> * مشکلی در حذف به وجود آمده است ! *</span>';   
}
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.noe_sanad.focus();">
<form method="post" name="myform" onkeydown="enterIE()">
<div align="center">
<table width="100%" height="90%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr>
  <td class="title"><div style="position:absolute;top:5px;left:45%;">جدول کد بدهکار و بستانکار</div>
  <div class="pagecover">[صفحه:&nbsp'.$PageNo.' از '.$MaxPage.']</div></td>   
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
	 <td width="13%">نوع سند</td>
	 <td width="8%">وضعیت پیمانکار</td>
	 <td width="8%">مبدأ</td>
	 <td width="11%">کد بدهکار</td>
	 <td width="19%">شرح بدهکار</td>	 
	 <td width="11%">کد بستانکار</td>
	 <td width="19%">شرح بستانکار</td>';
	 if($Mode==NULL)echo'<td width="11%">حذف</td>';
	 else echo'<td width="11%">دستورات</td>';
    echo'
	</tr>';
	if($Mode=='Insert' or $Mode=='Search')
	{
	 if ($Mode=='Insert') {$button_value="ثبت"; $button_name="Insert_x";} 
	 else {$button_value="جستجو"; $button_name="Search_x";}
	  echo'
	  <tr class="table-odd">';
	   if ($Mode=='Insert') echo'<td><span class="star">*</span> '.static_listbox("noe_sanad",$noe_sanad,"sanadArr",1,"class='text4'").'</td>';    
	   if ($Mode=='Search')echo'<td> '.static_listbox("noe_sanad",$noe_sanad,"sanadArr",1,"class='text4'").'</td>';  
	  echo'
	   <td>'.static_listbox("status_peymankar",$status_peymankar,"status_peymankarArr",1,"class='text4'").'</td>
	   <td>'.static_listbox("noe_mabda",$noe_mabda,"noe_mabdaArr",1,"class='text4'").'</td>
	   <td><input type="text" class="textboxme2" name="code_bedehkar" value="'.$code_bedehkar.'" maxlength="6" onkeypress="return isNumber(event)"/>
	   	   <img border="0" src="images/Info1.png" title="برای کد بدهکار شش رقم وارد نمایید " onmouseOver="this.src=\'images/Info_h.png\'" onmouseOut="this.src=\'images/Info1.png\'" style="width:16px;height:16px;cursor:pointer"/>
	   </td>
	   <td><input type="text" class="textboxme" name="sharh_bedehkar" value="'.$sharh_bedehkar.'"/></td>
	   <td><input type="text" class="textboxme2" name="code_bestankar" value="'.$code_bestankar.'" maxlength="6"  onkeypress="return isNumber(event)"/>
	   	   <img border="0" src="images/Info1.png" title="برای کد بستانکار شش رقم وارد نمایید" onmouseOver="this.src=\'images/Info_h.png\'" onmouseOut="this.src=\'images/Info1.png\'" style="width:16px;height:16px;cursor:pointer"/>
	   </td>
       <td><input type="text" class="textboxme" name="sharh_bestankar" value="'.$sharh_bestankar.'"/></td>
	   <td><input type="submit" class="buttonme" name="'.$button_name.'" id="sabt" value="'.$button_value.'"/>
		   <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'">
	   </td>
	  </tr>';
	}
	$i=0;
    $q1="SELECT * From $TableName WHERE 1=1 ".$_SESSION['mt_search_bed_bes']." order by $order $Limit ";
	$all= $db->query($q1);
    while($row1=$db->fetch_assoc($all))
	{
     if($right_edt){$edtClick='onClick="window.location=\''.$FileName.'?Mode=Edit&id_='.$row1['id'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'"';}	 
     if($i++%2)
     echo'
     <tr class="table-odd"/>';
     else echo '
     <tr class="table-even"/>';
	 if($Mode=='Edit' and $row1['id']==$id_)
	 {
	  //$exist_resid=$db->get_from_where("count(sharh)","resid","sharh=".$row1['sharh']." AND deleted=0");
	  //if($exist_resid) echo'<td><input type="text" class="textboxme" title="غیر قابل تغییر" name="sharh" readonly value="'.$row1['sharh'].'" /> <img border="0" src="images/readonly.png" title="غیر قابل تغییر" class="dontchange"/></td>';
	 // else
	  echo'
	  <td><span class="star">*</span> '.static_listbox("noe_sanad",$row1['noe_sanad'],"sanadArr",1,"class='text4'").'</td>
	  <td>'.static_listbox("status_peymankar",$row1['status_peymankar'],"status_peymankarArr",1,"class='text4'").'</td>
	  <td>'.static_listbox("noe_mabda",$row1['noe_mabda'],"noe_mabdaArr",1,"class='text4'").'</td>
	  <td><input type="text" class="textboxme2" name="code_bedehkar" value="'.$row1['code_bedehkar'].'" maxlength="6"  onkeypress="return isNumber(event)"/>
	  	  <img border="0" src="images/Info1.png" title="برای کد بدهکار شش رقم وارد نمایید " onmouseOver="this.src=\'images/Info_h.png\'" onmouseOut="this.src=\'images/Info1.png\'" style="width:16px;height:16px;cursor:pointer"/>
	  </td>
	  <td><input type="text" class="textboxme" name="sharh_bedehkar" value="'.$row1['sharh_bedehkar'].'"/></td>
	  <td><input type="text" class="textboxme2" name="code_bestankar" value="'.$row1['code_bestankar'].'" maxlength="6" onkeypress="return isNumber(event)"/>
	  	  <img border="0" src="images/Info1.png" title="برای کد بستانکار شش رقم وارد نمایید" onmouseOver="this.src=\'images/Info_h.png\'" onmouseOut="this.src=\'images/Info1.png\'" style="width:16px;height:16px;cursor:pointer"/>
	  </td>
	  <td><input type="text" class="textboxme" name="sharh_bestankar" value="'.$row1['sharh_bestankar'].'"/></td>
	  <td>   
	   <input class="buttonme" type="submit" name="Edit_x" id="sabt" value="ثبت تغييرات" />
	   <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'">
	  </td>';
	 }
     else
     {echo'
	  <td '.$edtClick.'>'.$sanadArr[$row1['noe_sanad']].'</td>
	  <td '.$edtClick.'>'.$status_peymankarArr[$row1['status_peymankar']].'</td>
	  <td '.$edtClick.'>'.$noe_mabdaArr[$row1['noe_mabda']].'</td>
	  <td '.$edtClick.'>'.$row1['code_bedehkar'].'</td>
	  <td '.$edtClick.'>'.$row1['sharh_bedehkar'].'</td>
	  <td '.$edtClick.'>'.$row1['code_bestankar'].'</td>
	  <td '.$edtClick.'>'.$row1['sharh_bestankar'].'</td>
	  <td>';
	  if($right_del)
	  {echo'<img border="0" src="images/trash.png" width="20" height="20" title="حذف"
	  	   onmouseOver="this.src=\'images/trash_hover.png\'" 
		   onmouseOut="this.src=\'images/trash.png\'" 
	       onClick="iconfirm(\''.$FileName.'?Delete_x=1&id_='.$row1['id'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\',\'برای حذف کد سند '.$sanadArr[$row1['noe_sanad']].' با کدبدهکار '.$row1['code_bedehkar'].' و کد بستانکار '.$row1['code_bestankar'].' \')" />';
	  }
	  echo'</td>';
	 }
	echo'
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
	 if($right_ins){
	 echo'<td width="70"><div onClick="window.location=\''.$FileName.'?Mode=Insert&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-new" title="افزودن رکورد جديد" ><a href="#"></a></div></td>
 	 <td width="10">&nbsp;</td>';}
	 echo'<td width="70"><div onClick="window.location=\''.$FileName.'?Mode=Search&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-search" title="جستجو" ><a href="#"></a></div></td>
	 <td width="10">&nbsp;</td>
	 <td width="70"><div onClick="window.location=\'my_frame.php\'" id="btn-back"  title="بازگشت به منوي اصلي"  ><a href="#"></a></div></td> 
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
     if ($_SESSION['mt_search_bed_bes']) 
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
 <!-- پايان فوتر-->';
echo'	
</table>
</div>';
/*************INSERT BUTTON******/// ثبت اطلاعات    
if(isset($Insert_x))
{
 //if(isPermitSave($noe_sanad,$status_peymankar,$noe_mabda,$code_bedehkar,$code_bestankar))
 if(isPermitSave($noe_sanad))
 { 
   $Mode='';
   $insert_q=("INSERT INTO $TableName(noe_sanad,status_peymankar,noe_mabda,code_bedehkar,sharh_bedehkar,code_bestankar,sharh_bestankar)
               VALUES('$noe_sanad','$status_peymankar','$noe_mabda',TRIM('$code_bedehkar'),TRIM('$sharh_bedehkar'),TRIM('$code_bestankar'),TRIM('$sharh_bestankar'))");
   $insert_res=mysql_query($insert_q);
   if($insert_res){
    $max_id=$db->get_from_where("Max(id)","$TableName",""); 
    $log_i=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$max_id','ثبت',".($yymmdd).",'$logtime')");
    echo '<script>window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\' </script>';
   }  
   else  $message ='<span style="color:red;font: bold 12px tahoma;"> * مشکلی در ثبت به وجود آمده است ! *</span>';
 }
}
/********************END********************/
echo'
'.$message.'
</form>
</body>
</html>';	
?>