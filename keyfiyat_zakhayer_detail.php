<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="keyfiyat_zakhayer_detail.php";
$TableName="keyfiyat_zakhayer_detail";
$radif=1;
$nameOstan=$db->get_from_where("name_ostan","ostan","code_ostan='$code_ostan_'");
$nameAnbar=$db->get_from_where("name_anbar","list_sardkhane","code_ostan='$code_ostan_' AND code_anbar='$code_anbar_'");
$nameZirAnbar=$db->get_from_where("name_ziranbar","list_sardkhane_detail","code_ostan='$code_ostan_' AND code_anbar='$code_anbar_' AND code_ziranbar='$code_ziranbar_'");
$right_ins=0;$right_edt=0;
if (right(517)) $right_ins=1;
if (right(518)) $right_edt=1;
$logtime=date('H:i:s');
$titr='لیست موجودی کالا در استان : '.$nameOstan.' سردخانه : '.$nameAnbar. ' زیرانبار : '.$nameZirAnbar ;
echo'
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>'.$titr.'</title>
<link rel="stylesheet" type="text/css" href="styles.css" />
<link rel="stylesheet" type="text/css" href="styles/easyui.css">
<link rel="stylesheet" type="text/css" href="styles/easyui-rtl.css"> 
<script type="text/javascript" src="functions.js"></script>
<script type="text/javascript" src="scripts/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="scripts/jquery.easyui.min.js"></script>
<script type="text/javascript" src="scripts/easyui-rtl.js"></script> 
</head>';
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<form method="post" name="myform" id="myform" >
<div align="center">
<table width="100%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr>
  <td class="title" >
   <span style="float:center">'.$titr.'</span>
   <!--<span style="float:right;font-size:10px"><input type="checkbox" name="chkmandedar" value="'.$chkmandedar.'" onChange="myform.submit();"/>&nbsp; نمایش مانده دارها</span>-->
  </td>
  </tr>
 <tr>
  <td class="title">
   <!--<span style="float:right" onClick="window.open(\'print_keyfiyat_det.php?code_ostan_='.$code_ostan_.'&code_anbar_='.$code_anbar_.'&code_ziranbar_='.$code_ziranbar_.'\',\'_blank\',\'scrollbars=yes\')" id="printer" style="display: block;" title="چاپ انبارگردانی"><a href="#"></a></span>-->
   <span style="float:center">برای ثبت مقادیر روی سطر موردنظر کلیک کنید</span>
   <span style="float:left" onClick="window.location=\'keyfiyat_zakhayer.php?PageNo='.$PageNo.'\'" id="btn-back"  title="بازگشت"  ><a href="#"></a></span> 
  </td>
 </tr>
 <!--پايان هدر-->
 <!-- مرکز صفحه--> 
 <tr>
  <td height="100%">
   <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
	<tr class="table-title">
	 <td rowspan="2" width="2%">ردیف</td>
	 <td rowspan="2" width="5%">شناسه موجودی</td>
	 <td rowspan="2" width="8%">کالا</td>
	 <td rowspan="2" width="4%">کشور</td>
	 <td rowspan="2" width="8%">تولیدکننده</td>
	 <td colspan="3" width="12%">تاریخ تولید</td>
	 <td rowspan="2" width="5%">وزن کارتن</td>
	 <td colspan="3" width="20%">موجودی سیستم</td>
     <td rowspan="2" width="10%" nowrap>
	   گزارش بارگیری از مبدأ
	   <br>
	   و کلیه مستندات مربوطه
	 </td>
     <td rowspan="2" width="10%" nowrap>
	  مطابقت مشخصات موجودی
       <br>	 
	  با اطلاعات مندرج در سیستم
	 </td>
     <td rowspan="2" width="7%" nowrap>
	  نوع چیدمان
      <br>	  
	  در سالن
	 </td>
     <td rowspan="2" width="9%">عملیات</td>
	 </tr>
	  <tr class="table-title">
	   <td>سال</td>
	   <td>ماه</td>
	   <td>روز</td>
	   <td>تعداد</td>
	   <td>ناخالص</td>
	   <td >خالص</td>
	  </tr>';
   $Cntr=0;
   $q1="SELECT $TableName.*,mojody_kala.*,kala.name_kala,keshvar.name_keshvar,tolidkonande.name_tolidkonande,l_s_d.noe_ziranbar,l_s_d.name_ziranbar,karton.vazn_karton 
          From mojody_kala   
          LEFT JOIN  $TableName ON mojody_kala.id=$TableName.id_mojody
          INNER JOIN kala ON mojody_kala.code_kala=kala.code_kala
          INNER JOIN keshvar ON mojody_kala.code_keshvar=keshvar.code_keshvar
          LEFT JOIN karton ON mojody_kala.code_karton=karton.code_karton 
          INNER JOIN tolidkonande ON mojody_kala.code_tolidkonande=tolidkonande.code_tolidkonande
          INNER JOIN list_sardkhane_detail l_s_d ON mojody_kala.code_ziranbar=l_s_d.code_ziranbar AND mojody_kala.code_ostan=l_s_d.code_ostan AND mojody_kala.code_anbar=l_s_d.code_anbar  	  
	      WHERE mojody_kala.code_ziranbar='$code_ziranbar_' AND mojody_kala.code_ostan='$code_ostan_' AND mojody_kala.code_anbar='$code_anbar_' AND mojody_kala.year='$mtActiveYear'
		  order by mojody_kala.sal_tolid_shamsi,mojody_kala.mah_tolid_shamsi,mojody_kala.rouz_tolid_shamsi asc";
   $allMojody = $db->query($q1);
   $count_mojody =mysql_num_rows($allMojody);
   while($row=$db->fetch_assoc($allMojody))
   {
    //موجودی با توابع
	$tedad_karton=mojodyKarton($row['code_ostan'],$row['code_anbar'],$row['year'],$row['code_ziranbar'],$row['code_kala'],$row['code_keshvar'],$row['code_tolidkonande'],$row['sal_tolid_shamsi'],$row['mah_tolid_shamsi'],$row['rouz_tolid_shamsi'],$row['code_karton']);
	$mojody_nakhales=mojodyNakhales($row['code_ostan'],$row['code_anbar'],$row['year'],$row['code_ziranbar'],$row['code_kala'],$row['code_keshvar'],$row['code_tolidkonande'],$row['sal_tolid_shamsi'],$row['mah_tolid_shamsi'],$row['rouz_tolid_shamsi'],$row['code_karton']);
    $mojody_khales=mojodyKhales($row['code_ostan'],$row['code_anbar'],$row['year'],$row['code_ziranbar'],$row['code_kala'],$row['code_keshvar'],$row['code_tolidkonande'],$row['sal_tolid_shamsi'],$row['mah_tolid_shamsi'],$row['rouz_tolid_shamsi'],$row['code_karton']);
    
	IF(($right_ins)AND($row['id_keyfiyat_det']=='')){$editclick='onClick="window.location=\''.$FileName.'?Mode=Insert&id_mojody_='.$row['id'].'&id_keyfiyat_='.$id_keyfiyat_.'&code_ostan_='.$code_ostan_.'&code_anbar_='.$code_anbar_.'&code_ziranbar_='.$code_ziranbar_.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'"';}	 
	ELSE IF(($right_edt)AND($row['id_keyfiyat_det']!='')){$editclick='onClick="window.location=\''.$FileName.'?Mode=Edit&id_keyfiyat_det_='.$row['id_keyfiyat_det'].'&id_keyfiyat_='.$id_keyfiyat_.'&code_ostan_='.$code_ostan_.'&code_anbar_='.$code_anbar_.'&code_ziranbar_='.$code_ziranbar_.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'"';}	 
    if($Cntr++%2) echo'<tr class="table-odd"/>';
    else echo '<tr class="table-even" />';
    if($Mode=='Insert' and $row['id']==$id_mojody_)
    {
	   echo'
	   <td>'.$radif++.'</td>
	   <td ><input class="textboxme" readonly type="text" name="id_mojody" value="'.$row['id'].'" /></td>
	   <td ><input class="textboxme" type="hidden" name="code_kala" value="'.$row['code_kala'].'" /><input class="textboxme" readonly type="text" name="name_kala" value="'.$row['name_kala'].'" /></td>
	   <td ><input class="textboxme" type="hidden" name="code_keshvar" value="'.$row['code_keshvar'].'" /><input class="textboxme" readonly type="text" name="name_keshvar" value="'.$row['name_keshvar'].'" /></td>
	   <td ><input class="textboxme" type="hidden" name="code_tolidkonande" value="'.$row['code_tolidkonande'].'" /><input class="textboxme" readonly type="text" name="name_tolidkonande" value="'.$row['name_tolidkonande'].'" /></td>
	   <td ><input class="textboxme" readonly type="text" name="sal_tolid_shamsi" value="'.$row['sal_tolid_shamsi'].'" /></td>
	   <td ><input class="textboxme" type="hidden" name="mah_tolid_shamsi" value="'.$row['mah_tolid_shamsi'].'" /><input class="textboxme" readonly type="text" value="'.$mahshamsiArr[$row['mah_tolid_shamsi']].'" /></td>
	   <td ><input class="textboxme" readonly type="text" name="rouz_tolid_shamsi" value="'.$row['rouz_tolid_shamsi'].'" /></td>
	   <td ><input class="textboxme" type="hidden" name="code_karton" value="'.$row['code_karton'].'" /><input class="textboxme" readonly type="text" name="vazn_karton_this" value="'.$row['vazn_karton_this'].'" /></td>
	   
	   <td >'.$tedad_karton.'</td>
	   <td >'.round($mojody_nakhales,3).'</td>
	   <td >'.round($mojody_khales,3).'</td>
	   <td><input type="checkbox" name="chkmostanadat" checked/></td>
	   <td><input type="checkbox" name="chkmotabeghat" checked/></td>
	   <td>'.static_listbox("noe_chideman",1,"noechidemanArr",1,"class='text4'").'</td>
	   ';
	   echo'
		<td colspan="7"><input class="buttonme" type="submit" name="Insert_x" id="sabt" value="ثبت"/>
	   	    <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?id_keyfiyat_='.$id_keyfiyat_.'&code_ostan_='.$code_ostan_.'&code_anbar_='.$code_anbar_.'&code_ziranbar_='.$code_ziranbar_.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'"/>
        </td>
	   </tr>';
	  }
	  else if($Mode=='Edit' and $row['id_keyfiyat_det']==$id_keyfiyat_det_)
      {
	   if($row['chkmostanadat'] == 1) $mostanadat_checked = 'checked = "checked"';
       else $mostanadat_checked = '';
	   if($row['chkmotabeghat'] == 1) $motabeghat_checked = 'checked = "checked"';
       else $motabeghat_checked = '';
	   echo'
	   <td>'.$radif++.'</td>
	   <td ><input class="textboxme" readonly type="text" name="id_mojody" value="'.$row['id'].'" /></td>
	   <td ><input class="textboxme" type="hidden" name="code_kala" value="'.$row['code_kala'].'" /><input class="textboxme" readonly type="text" name="name_kala" value="'.$row['name_kala'].'" /></td>
	   <td ><input class="textboxme" type="hidden" name="code_keshvar" value="'.$row['code_keshvar'].'" /><input class="textboxme" readonly type="text" name="name_keshvar" value="'.$row['name_keshvar'].'" /></td>
	   <td ><input class="textboxme" type="hidden" name="code_tolidkonande" value="'.$row['code_tolidkonande'].'" /><input class="textboxme" readonly type="text" name="name_tolidkonande" value="'.$row['name_tolidkonande'].'" /></td>
	   <td ><input class="textboxme" readonly type="text" name="sal_tolid_shamsi" value="'.$row['sal_tolid_shamsi'].'" /></td>
	   <td ><input class="textboxme" type="hidden" name="mah_tolid_shamsi" value="'.$row['mah_tolid_shamsi'].'" /><input class="textboxme" readonly type="text" value="'.$mahshamsiArr[$row['mah_tolid_shamsi']].'" /></td>
	   <td ><input class="textboxme" readonly type="text" name="rouz_tolid_shamsi" value="'.$row['rouz_tolid_shamsi'].'" /></td>
	   <td ><input class="textboxme" type="hidden" name="code_karton" value="'.$row['code_karton'].'" /><input class="textboxme" readonly type="text" name="vazn_karton_this" value="'.$row['vazn_karton_this'].'" /></td>
	   <td >'.$tedad_karton.'</td>
	   <td >'.round($mojody_nakhales,3).'</td>
	   <td >'.round($mojody_khales,3).'</td>
	   <td><input type="checkbox" name="chkmostanadat" '.$mostanadat_checked.' /></td>
	   <td><input type="checkbox" name="chkmotabeghat" '.$motabeghat_checked.' /></td>
	   <td>'.static_listbox("noe_chideman",$row['noe_chideman'],"noechidemanArr",1,"class='text4'").'</td>';
	   echo'
		<td colspan="7"><input class="buttonme" type="submit" name="Edit_x" id="sabt" value="ویرایش"/>
	   	    <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?id_keyfiyat_='.$id_keyfiyat_.'&code_ostan_='.$code_ostan_.'&code_anbar_='.$code_anbar_.'&code_ziranbar_='.$code_ziranbar_.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'"/>
        </td>
	   </tr>';
	  }
	  else
	  {
	   echo'
	   <td>'.$radif++.'</td>
	   <td '.$editclick.' '.$InsClick.'>'.$row['id'].'</td>
	   <td '.$editclick.' '.$InsClick.'>'.$row['name_kala'].'</td>
	   <td '.$editclick.' '.$InsClick.'>'.$row['name_keshvar'].'</td>
	   <td '.$editclick.' '.$InsClick.'>'.$row['name_tolidkonande'].'</td>
	   <td '.$editclick.' '.$InsClick.'>'.$row['sal_tolid_shamsi'].'</td>
	   <td '.$editclick.' '.$InsClick.'>'.$mahshamsiArr[$row['mah_tolid_shamsi']].'</td>
	   <td '.$editclick.' '.$InsClick.'>'.$row['rouz_tolid_shamsi'].'</td>
	   <td '.$editclick.' '.$InsClick.'>'.$row['vazn_karton_this'].'</td>   
	   <td '.$editclick.' '.$InsClick.'>'.$tedad_karton.'</td>
	   <td '.$editclick.' '.$InsClick.'>'.round($mojody_nakhales,3).'</td>
	   <td '.$editclick.' '.$InsClick.'>'.round($mojody_khales,3).'</td>
	   <td '.$editclick.' >';if(($row['id_keyfiyat_det'])and($row['chkmostanadat'] == 1))echo '<span class="fa fa-check-circle fa-2x" style="color:green"></span>';else IF(($row['id_keyfiyat_det']) and ($row['chkmostanadat'] == 0)) echo '<span class="fa fa-times-circle fa-2x" style="color:red"></span>';else  echo' '; echo'</td>
	   <td '.$editclick.' >';if(($row['id_keyfiyat_det'])and($row['chkmotabeghat'] == 1))echo '<span class="fa fa-check-circle fa-2x" style="color:green"></span>';else IF(($row['id_keyfiyat_det'])and ($row['chkmotabeghat'] == 0)) echo '<span class="fa fa-times-circle fa-2x" style="color:red"></span>';else  echo' '; echo'</td>
	   <td '.$editclick.' >'.$noechidemanArr[$row['noe_chideman']].'</td>
	   <td>'; 
	   IF($row['id_keyfiyat_det'])echo'<img src="images/ok2.png" />';
	   echo'
	   </td>
	  </tr>';
	  }
	//}
    $sum_tedad_karton+=$tedad_karton;
    $sum_mojody_nakhales+=$mojody_nakhales;
    $sum_mojody_khales+=$mojody_khales;
   }
    echo'
   	  <tr class="print_table-even sum-row-white-b">
	   <td id="sum_row" colspan="9">جمع مقادیر</td>
	   <td>'.virgul($sum_tedad_karton).'</td>
	   <td>'.round($sum_mojody_nakhales,3).'</td>
	   <td>'.round($sum_mojody_khales,3).'</td>';
	   echo'
	   <td>-</td><td>-</td><td>-</td><td>-</td>
	  </tr>
   </table>
  </td>
 </tr> 
 <!--پايان مرکز صفحه -->
 <!-- فوتر-->
 <tr >
  <td class="title">
    <span style="float:left" onClick="window.location=\'keyfiyat_zakhayer.php?PageNo='.$PageNo.'\'" id="btn-back"  title="بازگشت"  ><a href="#"></a></span> 
  </td>
 </tr> 
 <!-- پايان فوتر--> 
</table>
</div>';
/**********اجازه براي ثبت اطلاعات********/
function isPermitSave($id_key,$id_mojody,$gl_c_o,$gl_c_a,$gl_year,$code_kala,$code_ziranbar,$code_keshvar,$code_tolidkonande,$sal_tolid_shamsi,$mah_tolid_shamsi,$rouz_tolid_shamsi,$code_karton,$vazn_karton_this,$chkmostanadat,$chkmotabeghat,$noe_chideman)
{ 
 $flag=false;
 if(!($gl_c_o and $gl_c_a and $gl_year) or $gl_c_o==-1 or $gl_c_a==-1)//اگر سشن استان و انبار وسال خالی بود
 {   
   $flag=false;
   echo"<script> alert('لطفاً استان و انبار و سال مورد نظر خود را انتخاب نمایید!')</script>";
   return $flag;
 }
 else $flag=true;  
 if(!($id_key and $id_mojody and $code_kala and $code_ziranbar and $code_keshvar and $code_tolidkonande and $sal_tolid_shamsi and $mah_tolid_shamsi and $rouz_tolid_shamsi and $code_karton and $vazn_karton_this and $noe_chideman))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
   return $flag;
 } 
 else $flag=true;
return $flag;
}
/*************INSERT  BUTTON******/// ثبت اطلاعات    
if(isset($Insert_x))
{
  if ($chkmostanadat=='on') $chkmostanadat=1;
  else $chkmostanadat=0; 
  if ($chkmotabeghat=='on') $chkmotabeghat=1;
  else $chkmotabeghat=0; 
  if(isPermitSave($id_keyfiyat_,$id_mojody,$code_ostan_,$code_anbar_,$mtActiveYear,$code_kala,$code_ziranbar_,$code_keshvar,$code_tolidkonande,$sal_tolid_shamsi,$mah_tolid_shamsi,$rouz_tolid_shamsi,$code_karton,$vazn_karton_this,$chkmostanadat,$chkmotabeghat,$noe_chideman))
  {   
   $Mode='';
   mysql_query('SET AUTOCOMMIT=0');//TRANSACTIONشروع 
   mysql_query('START TRANSACTION');
   $insert_q=("INSERT INTO $TableName(id_keyfiyat,id_mojody,code_ostan,code_anbar,year,code_kala,code_ziranbar,code_keshvar,code_tolidkonande,sal_tolid_shamsi,mah_tolid_shamsi,rouz_tolid_shamsi,code_karton,vazn_karton_this,chkmostanadat,chkmotabeghat,noe_chideman,deleted)
              VALUES('$id_keyfiyat_','$id_mojody','$code_ostan_',$code_anbar_,'$mtActiveYear','$code_kala','$code_ziranbar_','$code_keshvar','$code_tolidkonande','$sal_tolid_shamsi','$mah_tolid_shamsi','$rouz_tolid_shamsi','$code_karton','$vazn_karton_this','$chkmostanadat','$chkmotabeghat','$noe_chideman',0)"); 		 
   $insert_res=mysql_query($insert_q);
   /*لاگ*/
   $max_id=$db->get_from_where("MAX(id_keyfiyat_det)","$TableName","");   
   $log_i=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$max_id','ثبت',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')");
   if($insert_res and $log_i)
   {
	  mysql_query("COMMIT");
      echo '<script>window.location=\''.$FileName.'?PageNo_detail='.$PageNo_detail.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_keyfiyat_='.$id_keyfiyat_.'&code_ostan_='.$code_ostan_.'&code_anbar_='.$code_anbar_.'&code_ziranbar_='.$code_ziranbar_.'\' </script>';
   }
   else  
   {
      mysql_query('ROLLBACK');
      echo "<script>alert('مشکلی در ثبت به وجود آمده است')</script>";
   }
   mysql_query('SET AUTOCOMMIT=1');
 }//END isPermitSave
}//END INSERT
/**********اجازه براي ویرایش اطلاعات********/
function isPermitEdit($id_key,$id_mojody,$gl_c_o,$gl_c_a,$gl_year,$code_kala,$code_ziranbar,$code_keshvar,$code_tolidkonande,$sal_tolid_shamsi,$mah_tolid_shamsi,$rouz_tolid_shamsi,$code_karton,$vazn_karton_this,$chkmostanadat,$chkmotabeghat,$noe_chideman)
{ 
 $flag=false;
 if(!($id_key and $id_mojody and $code_kala and $code_ziranbar and $code_keshvar and $code_tolidkonande and $sal_tolid_shamsi and $mah_tolid_shamsi and $rouz_tolid_shamsi and $code_karton and $vazn_karton_this and $noe_chideman))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
   return $flag;
 } 
 else $flag=true;
return $flag;
}
/*************EDIT  BUTTON******/// ثبت اطلاعات    
if(isset($Edit_x))
{
  if ($chkmostanadat=='on') $chkmostanadat=1;
  else $chkmostanadat=0; 
  if ($chkmotabeghat=='on') $chkmotabeghat=1;
  else $chkmotabeghat=0; 
  if(isPermitEdit($id_keyfiyat_,$id_mojody,$code_ostan_,$code_anbar_,$mtActiveYear,$code_kala,$code_ziranbar_,$code_keshvar,$code_tolidkonande,$sal_tolid_shamsi,$mah_tolid_shamsi,$rouz_tolid_shamsi,$code_karton,$vazn_karton_this,$chkmostanadat,$chkmotabeghat,$noe_chideman))
  {   
   $Mode='';
   mysql_query('SET AUTOCOMMIT=0');//TRANSACTIONشروع 
   mysql_query('START TRANSACTION');
   $edit_q=("UPDATE $TableName SET chkmostanadat='$chkmostanadat',chkmotabeghat='$chkmotabeghat',noe_chideman='$noe_chideman'
			 WHERE id_keyfiyat_det='$id_keyfiyat_det_';");
   $edit_res=mysql_query($edit_q);
   /*لاگ*/
   $log_e=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_keyfiyat_det_','ویرایش',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')");
   if($edit_res and $log_e)
   {
	  mysql_query("COMMIT");
      echo '<script>window.location=\''.$FileName.'?PageNo_detail='.$PageNo_detail.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&id_keyfiyat_='.$id_keyfiyat_.'&code_ostan_='.$code_ostan_.'&code_anbar_='.$code_anbar_.'&code_ziranbar_='.$code_ziranbar_.'\' </script>';
   }
   else  
   {
      mysql_query('ROLLBACK');
      echo "<script>alert('مشکلی در ثبت به وجود آمده است')</script>";
   }
   mysql_query('SET AUTOCOMMIT=1');
 }//END isPermitSave
}//END INSERT	
echo'
</form>
</body>
</html>';
?>