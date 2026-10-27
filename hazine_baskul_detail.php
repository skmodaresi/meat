<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="hazine_baskul_detail.php";
$TableName="hazine_baskul_detail";
$logtime=date('H:i:s');
$right_ins=0;$right_edt=0;$right_del=0;
if (right(94)) $right_ins=1;
if (right(95)) $right_edt=1;
if (right(96)) $right_del=1; 
echo'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" />
<html xmlns="http://www.w3.org/1999/xhtml" dir=rtl>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>جزئیات جدول هزینه باسکول</title>
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
// خواندن اطلاعات جدول باسکول
$c=$db->query("SELECT * FROM hazine_baskul WHERE sh_jadval_baskul='$sh_jadval_baskul_' AND code_ostan='$code_ostan_'");
$r=$db->fetch_array($c);
$message='';
if(!(isset($Mode))) $Mode='';
/*************SEARCH BUTTON******/// جستجوي اطلاعات
if(isset($open_filter))
{ $open_filter="";
  $_SESSION['mt_search_baskul_det']="";
} 
if(isset($Search_x))
{
 $Mode='';
 $Search_x=""; 
 $temp="";
 if($noe_khodro)    $temp.=" and noe_khodro LIKE '$noe_khodro'";
 if($nerkh_baskul)  $temp.=" and nerkh_baskul LIKE '%$nerkh_baskul%'";
 if($temp) {
 $PageNo_detail=1;
 $_SESSION['mt_search_baskul_det']=$temp;} else $_SESSION['mt_search_baskul_det']="";
}
/********************PAGING***********************/
if(isset($_POST['wRowPerPage'])) $RowPerPage=$_POST['wRowPerPage'];
if(!isset($RowPerPage)) $RowPerPage=8;
$res = $db->query("SELECT COUNT(*) FROM $TableName WHERE sh_jadval_baskul='$sh_jadval_baskul_' AND code_ostan='$code_ostan_' ".$_SESSION['mt_search_baskul_det']."");
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
/************اجازه براي ذخيره اطلاعات************/
function isPermitSave($noe_k,$nerkh,$sh,$c_o_)
{
 $flag=false;
 if(!($noe_k and $nerkh and $sh))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script> alert('لطفا تمام فيلد ها را تکميل نماييد')</script>";
   return $flag;
 } 
 else $flag=true;
 if(!empty($noe_k))
 { 
    $q8="SELECT noe_khodro FROM hazine_baskul_detail WHERE noe_khodro='$noe_k' AND sh_jadval_baskul='$sh' AND code_ostan='$c_o_'";
    $res8=mysql_query($q8);
    if(mysql_num_rows($res8)>0){
    echo"<script>alert('برای این خودرو قبلا نرخ ثبت شده است!')</script>";
    $flag=false;
    return $flag;
   }
  else $flag=true;
 }
 else $flag=true; 
return $flag;
}
/**********اجازه براي ويرايش اطلاعات********/
function isPermitEdit($noe_k,$nerkh,$this_id,$sh,$c_o_)
{
  $flag=false;
  if(!($noe_k and $nerkh and $sh))//پر بودن فيلدها
  {
   $flag=false;
   echo"<script>window.alert('لطفا تمام فيلد ها را تکميل نماييد');</script>";
   return $flag;
  } 
  else $flag=true;
  if(!empty($noe_k))
  {  
   $q10="SELECT * FROM hazine_baskul_detail WHERE noe_khodro='$noe_k' AND sh_jadval_baskul='$sh' AND code_ostan='$c_o_' AND id!=$this_id";
   $res10=mysql_query($q10);
   if(mysql_num_rows($res10)>0){
   echo"<script>alert('برای این خودرو قبلا نرخ ثبت شده است!')</script>";
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
 if(isPermitSave($noe_khodro,$nerkh_baskul,$sh_jadval_baskul_,$code_ostan_))
 { 
  $Mode='';
  $insert_q=("INSERT INTO $TableName(sh_jadval_baskul,code_ostan,noe_khodro,nerkh_baskul)VALUES('$sh_jadval_baskul_','$code_ostan_','$noe_khodro','$nerkh_baskul')");  
  $insert_res=$db->query($insert_q,'مشکلي در ثبت به وجود امده است');
  $res_id = $db->query("SELECT Max(id) FROM $TableName");
  $row_id = $db->fetch_array($res_id);
  $max_id=$row_id[0];
  $log_i=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$max_id','ثبت',".($yymmdd).",'$logtime')");  
 }
}
/************EDIT BUTTON********/// اصلاح اطلاعات
if (isset($Edit_x))
{
 if(isPermitEdit($noe_khodro,$nerkh_baskul,$id_,$sh_jadval_baskul_,$code_ostan_))
 {
  $Mode=''; 
  $edit_q=("UPDATE $TableName SET sh_jadval_baskul='$sh_jadval_baskul_',noe_khodro='$noe_khodro',nerkh_baskul='$nerkh_baskul' WHERE `id`='$id_';");	
  $edit_res=$db->query($edit_q,'مشکلي در ويرايش مشخصات به وجود آمده است');
  $log_e=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_','ویرایش',".($yymmdd).",'$logtime')");  
 } 
}
/************DELETE BUTTON********/// حذف اطلاعات
if (isset($Delete_x))
{
 $Mode=''; 
 $del_q = "DELETE FROM $TableName WHERE id=$id_ AND
          ($noe_khodro_ NOT IN (SELECT noe_khodro FROM resid WHERE noe_khodro=$noe_khodro_ AND code_ostan=$code_ostan_ AND nerkh_baskul_this=$nerkh_baskul_ AND mablagh_baskul=$nerkh_baskul_ AND deleted=0))AND
          ($noe_khodro_ NOT IN (SELECT noe_khodro FROM havale WHERE noe_khodro=$noe_khodro_ AND code_ostan=$code_ostan_  AND mablagh_baskul=$nerkh_baskul_ AND deleted=0))";
 $del_res = $db->query($del_q,'مشکلي در حذف به وجود آمده است');
 if(mysql_affected_rows()==0)
  echo"<script>alert('این عنوان در سایر فرم ها استفاده شده است،شما مجاز به حذف آن نیستید!')</script>";
 else if($del_res)
  $log_d=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_','حذف',".($yymmdd).",'$logtime')");
}
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<form method="post" name="myform" onkeydown="enterIE();">
<div align="center">
<table width="800px" height="100%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr>
  <td class="title">
   <div style="position:absolute;top:5px;left:30%;">  جزئيات جدول هزینه باسکول &nbsp'.$r['sh_jadval_baskul'].' با تاريخ اعتبار &nbsp'.$r['tarikh_etebar'].'</div>
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
if(!isset($order))    $order='id DESC';
if(!isset($sortcode)) $sortcode='1';
if(!isset($show_img)) $show_img='';
	echo'
	 <td width="30%">نوع خودرو</td>
	 <td width="40%">نرخ باسکول</td>';
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
	   <td>'.static_listbox("noe_khodro",$noe_khodro,"khodroArr",1,"class='text4'").'</td>
	   <td><input type="text" class="textboxme2" name="nerkh_baskul" value="'.$nerkh_baskul.'" onkeypress="return isNumber(event)"/></td>
	   <td><input type="submit" class="buttonme" name="'.$button_name.'" id="sabt" value="'.$button_value.'">
		   <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?sh_jadval_baskul_='.$sh_jadval_baskul_.'&code_ostan_='.$code_ostan_.'&PageNo_detail='.$PageNo_detail.'&RowPerPage='.$RowPerPage.'&PageNo='.$PageNo.'&order='.$order.'\'">
	   </td>
	  </tr>';
	}
	$i=0; 
	$q1="SELECT * From $TableName T WHERE sh_jadval_baskul='$sh_jadval_baskul_' ".$_SESSION['mt_search_baskul_det']." AND code_ostan='$code_ostan_' order by $order $Limit";	
	$all = $db->query($q1);
    while($row1=$db->fetch_assoc($all))
	{
     if($right_edt){$edtClick='onClick="window.location=\''.$FileName.'?Mode=Edit&id_='.$row1['id'].'&sh_jadval_baskul_='.$sh_jadval_baskul_.'&code_ostan_='.$code_ostan_.'&PageNo_detail='.$PageNo_detail.'&RowPerPage='.$RowPerPage.'&PageNo='.$PageNo.'&order='.$order.'\'"';}	 
	 if($i++%2)
     echo'
     <tr class="table-odd"/>';
     else echo '
     <tr class="table-even"/>';
	 if($Mode=='Edit' and $row1['id']==$id_)
	 {
	  $exist_resid=$db->get_from_where("count(noe_khodro)","resid","code_ostan='$code_ostan_' AND noe_khodro=".$row1['noe_khodro']." AND mablagh_baskul=".$row1['nerkh_baskul']." AND deleted=0");
	  $exist_havale=$db->get_from_where("count(noe_khodro)","havale","code_ostan='$code_ostan_' AND noe_khodro=".$row1['noe_khodro']." AND  mablagh_baskul=".$row1['nerkh_baskul']." AND deleted=0");
	  //if((!SuperUser())and($exist_resid))//اگر سوپریوزر نبود و در رسید وجود داشت
      if(($exist_resid)or($exist_havale)) 	  
	  {
	   echo'<td>'.static_listbox("noe_khodro",$row1['noe_khodro'],"khodroArr",1,"class='text4' disabled").'</td>	  
	   <td><input type="text" class="textboxme2" readonly name="nerkh_baskul" value="'.$row1['nerkh_baskul'].'" title="غیر قابل تغییر"/></td>';
	  }
	  else 
	  {echo'
	  <td>'.static_listbox("noe_khodro",$row1['noe_khodro'],"khodroArr",1,"class='text4'").'</td>	  
	  <td><input type="text" class="textboxme2" name="nerkh_baskul" value="'.$row1['nerkh_baskul'].'" onkeypress="return isNumber(event)"/></td>';
	  }
	  echo'
	  <td>
	    <input class="buttonme" type="submit" name="Edit_x" id="sabt" value="ثبت تغييرات" >
	    <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?sh_jadval_baskul_='.$sh_jadval_baskul_.'&code_ostan_='.$code_ostan_.'&PageNo_detail='.$PageNo_detail.'&RowPerPage='.$RowPerPage.'&PageNo='.$PageNo.'&order='.$order.'\'">
	  </td>';
	 }
     else
     {echo'
	  <td '.$edtClick.'>'.$khodroArr[$row1['noe_khodro']].'</td>
	  <td '.$edtClick.'>'.virgul($row1['nerkh_baskul']).'</td>';
	  if($right_del)
	  {echo'<td><img border="0" class="1" src="images/trash.png" width="20" height="20" 
	       onmouseOver="this.src=\'images/trash_hover.png\'" 
		   onmouseOut="this.src=\'images/trash.png\'" 
		   onClick="iconfirm(\''.$FileName.'?Delete_x=1&id_='.$row1['id'].'&sh_jadval_baskul_='.$sh_jadval_baskul_.'&code_ostan_='.$code_ostan_.'&noe_khodro_='.$row1['noe_khodro'].'&nerkh_baskul_='.$row1['nerkh_baskul'].'&PageNo_detail='.$PageNo_detail.'&RowPerPage='.$RowPerPage.'&PageNo='.$PageNo.'&order='.$order.'\',\'برای حذف نرخ باسکول خودرو '.$khodroArr[$row1['noe_khodro']].' از جدول شماره '.$row1['sh_jadval_baskul'].'\')" /></td>';
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
	 <!--<td width="24"><div onClick="window.open(\'print_hazine_baskul_detail.php?sh_jadval_baskul_='.$sh_jadval_baskul_.'&code_ostan_='.$code_ostan_.'\',\'_blank\',\'width=720px,scrollbars=1\')" id="printer" title="چاپ"><a href="#"></a></div></td>-->
     <td width="10">&nbsp;</td>';
	 if($right_ins){
	 echo'<td width="70"><div onClick="window.location=\''.$FileName.'?Mode=Insert&sh_jadval_baskul_='.$sh_jadval_baskul_.'&code_ostan_='.$code_ostan_.'&PageNo_detail='.$PageNo_detail.'&RowPerPage='.$RowPerPage.'&PageNo='.$PageNo.'&order='.$order.'\'" id="btn-new" title="افزودن رکورد جديد" ><a href="#"></a></div></td>
 	 <td width="10">&nbsp;</td>';}
	 echo'<td width="70"><div onClick="window.location=\''.$FileName.'?Mode=Search&sh_jadval_baskul_='.$sh_jadval_baskul_.'&code_ostan_='.$code_ostan_.'&PageNo_detail='.$PageNo_detail.'&RowPerPage='.$RowPerPage.'&PageNo='.$PageNo.'&order='.$order.'\'" id="btn-search" title="جستجو" ><a href="#"></a></div></td>
	 <td width="10">&nbsp;</td>
	 <td width="70"><div onClick="window.location=\'hazine_baskul.php?PageNo='.$PageNo.'\'" id="btn-back"  title="بازگشت به منوي اصلي"  ><a href="#"></a></div></td> 
	 <td width="20">&nbsp;</td>	   
	 <td width="22"><div '.$En_Prev.' onClick="window.location=\''.$FileName.'?sh_jadval_baskul_='.$sh_jadval_baskul_.'&code_ostan_='.$code_ostan_.'&PageNo_detail=1&RowPerPage='.$RowPerPage.'&PageNo='.$PageNo.'&order='.$order.'\'" id="btn-pageone" title="رويت اولين صفحه"><a href="#"></a></div></td>
	 <td width="2">&nbsp;</td>
	 <td width="22"><div '.$En_Prev.' onClick="window.location=\''.$FileName.'?sh_jadval_baskul_='.$sh_jadval_baskul_.'&code_ostan_='.$code_ostan_.'&PageNo_detail='.$PrevPage.'&RowPerPage='.$RowPerPage.'&PageNo='.$PageNo.'&order='.$order.'\'" id="btn-perevius" title="رفتن به صفحه قبلي"><a href="#"></a></div></td>
     <td width="2">&nbsp;</td>
	 <td width="40" align="center"><input type="text" name="PageNo_detail" value="'.$PageNo_detail.'" size="2" onChange="myform.submit()" onkeypress="return isNumber(event)" style="direction:ltr;text-align:center;"></td>		   
	 <td width="2">&nbsp;</td>		   
	 <td width="22"><div '.$En_Next.' onClick="window.location=\''.$FileName.'?sh_jadval_baskul_='.$sh_jadval_baskul_.'&code_ostan_='.$code_ostan_.'&PageNo_detail='.$NextPage.'&RowPerPage='.$RowPerPage.'&PageNo='.$PageNo.'&order='.$order.'\'" id="btn-forward" title="رفتن به صفحه بعدي"><a href="#"></a></div></td>
     <td width="2">&nbsp;</td>		   
	 <td width="22"><div '.$En_Next.' onClick="window.location=\''.$FileName.'?sh_jadval_baskul_='.$sh_jadval_baskul_.'&code_ostan_='.$code_ostan_.'&PageNo_detail='.$MaxPage.'&RowPerPage='.$RowPerPage.'&PageNo='.$PageNo.'&order='.$order.'\'" id="btn-pageend" title="رويت آخرين صفحه"><a href="#" ></a></div></td>
	 <td width="2">&nbsp;</td>
	 <td width="65" align="left"><span class="text1">تعداد خط :</span></td>
	 <td align="right"><input type="text" name="wRowPerPage" value="'.$RowPerPage.'" size="2" onChange="myform.submit()" onkeypress="return isNumber(event)" style="direction:ltr;text-align:center;"></td>	 
	 <td width="10">&nbsp;</td>';
     if ($_SESSION['mt_search_baskul_det']) 
	 echo '
	 <td width="70"><input type="Button" class=buttonme  value="نمايش همه" onClick="window.location=\''.$FileName.'?sh_jadval_baskul_='.$sh_jadval_baskul_.'&code_ostan_='.$code_ostan_.'&PageNo_detail='.$PageNo_detail.'&RowPerPage='.$RowPerPage.'&PageNo='.$PageNo.'&order='.$order.'&open_filter=1\'"></td>';	 
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
</form>
</body>
</html>';	
?>