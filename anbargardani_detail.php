<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="anbargardani_detail.php";
$TableName="mt_anbargardani_detail";
$radif=1;
$nameKala=$db->get_from_where("name_kala","kala","code_kala=$code_kala_");
$code_bastebandy=$db->get_from_where("code_bastebandy","kala","code_kala=$code_kala_");
$right_ins=0;$right_edt=0;$right_transfer=0;$right_eslah=0;
if (right(202)) $right_ins=1;
if (right(203)) $right_edt=1;
//if (right(204)) $right_eslah=1;
if (right(204)) $right_mojavez=1;
if (right(205)) $right_transfer=1;
$logtime=date('H:i:s');
echo'
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>جدول موجودی کالای '.$nameKala.'</title>
<link rel="stylesheet" type="text/css" href="styles.css" />
<link rel="stylesheet" type="text/css" href="styles/easyui.css">
<link rel="stylesheet" type="text/css" href="styles/easyui-rtl.css"> 
<script type="text/javascript" src="functions.js"></script>
<script type="text/javascript" src="scripts/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="scripts/jquery.easyui.min.js"></script>
<script type="text/javascript" src="scripts/easyui-rtl.js"></script> 
<script type="text/javascript">
 function sumkarton()<!--محاسبه مجموع وزن کارتن ها -->
 {
  var sum_k;
  sum_k=parseFloat((document.myform.vazn_karton_this.value)*(document.myform.tedad_anbargardani.value)).toFixed(3);
  document.myform.sum_karton_anbargardani.value=sum_k;
 }
 function vazn_khales()<!--محاسبه وزن خالص-->
 {
  var natije_vazn;
  natije_vazn=parseFloat((document.myform.nakhales_anbargardani.value)-(document.myform.sum_karton_anbargardani.value)).toFixed(3);                                      
  if(natije_vazn<0) natije_vazn=0;
  document.myform.khales_anbargardani.value=natije_vazn;
 }
 function sumghooti()<!--محاسبه وزن قوطی ها-->
 {
  var sum_k2;
  sum_k2=parseFloat((document.myform.vazn_karton_this.value)*(document.myform.tedad_anbargardani.value)).toFixed(3);
  document.myform.khales_anbargardani.value=sum_k2;
 }

</script>
</head>';
/************اجازه براي ذخيره اطلاعات************/
function isPermitSave($code_baste,$id_anbargar,$id_m,$tedad,$nakhales,$khales,$gl_c_o,$gl_c_s,$gl_year)
{
 echo'<script type="text/javascript">$.messager.alert("My Title","Here is a error message!","error");</script>';
 $flag=false;
 $error_msg='';
 if(!($gl_c_o and $gl_c_s and $gl_year) or $gl_c_o==-1 or $gl_c_s==-1)//اگر سشن استان و انبار وسال خالی بود
 {   
   $flag=false;
   echo"<script> alert('لطفاً استان و انبار و سال مورد نظر خود را انتخاب نمایید!');</script>";
   			
   return $flag;
 }
 else $flag=true;
 //if(!($id_anbargar and $id_m and $tedad and $khales))//پر بودن فيلدها
 if(!($id_anbargar and $id_m))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
   return $flag;
 } 
 else $flag=true;
 // if(($code_baste==1)and(!($nakhales)))//پر بودن فيلدها
 // {
   // $flag=false;
   // echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
   // return $flag;
 // } 
 // else $flag=true;

return $flag;
} 
/*************INSERT BUTTON******/// ثبت اطلاعات    
if(isset($Insert_x))
{
 if(isPermitSave($code_bastebandy,$id_anbargardani_,$id_mojody,$tedad_anbargardani,$nakhales_anbargardani,$khales_anbargardani,$mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear)) 
 {
	mysql_query('SET AUTOCOMMIT=0');//TRANSACTIONشروع 
    mysql_query('START TRANSACTION');
	//$vazn_karton_this=$db->get_from_where("vazn_karton","karton","code_karton='$code_karton' AND code_bastebandy='$code_bastebandy'");     
	//محاسبات برای اطمینان
    if($code_bastebandy==1)//کارتنی
	{
	  IF($code_kala_==51)$sum_karton_anbargardani=0;
	  ELSE $sum_karton_anbargardani=round(floatval($vazn_karton_this*$tedad_anbargardani),3);  
	  $khales_anbargardani=round(floatval($nakhales_anbargardani-$sum_karton_anbargardani),3);
	  if($khales_anbargardani<0) $khales_anbargardani=0;
	  IF($code_kala_==50)$shane_anbargardani=$tedad_anbargardani*$_SESSION["mtShane"];
	  ELSE IF($code_kala_==54)$shane_anbargardani=$tedad_anbargardani*$_SESSION["mtShane_dakheli"];
	  ELSE $shane_anbargardani=0;
	}
    //قوطی	
	if($code_bastebandy==2) $khales_anbargardani=round(floatval($vazn_karton_this*$tedad_anbargardani),3);
	$insert_kala_q=("INSERT INTO $TableName 
                     (id_anbargardani,id_mojody,code_ostan,code_anbar,year,code_kala,code_ziranbar,code_keshvar,code_tolidkonande,sal_tolid_shamsi,mah_tolid_shamsi,rouz_tolid_shamsi,
					  code_karton,vazn_karton_this,code_mandegari,sum_karton_anbargardani,tedad_anbargardani,nakhales_anbargardani,khales_anbargardani,shane_anbargardani)
                     VALUES('$id_anbargardani_','$id_mojody','$mt_gl_code_ostan','$mt_gl_code_anbar','$mtActiveYear','$code_kala_','$code_ziranbar','$code_keshvar','$code_tolidkonande',
					 '$sal_tolid_shamsi','$mah_tolid_shamsi','$rouz_tolid_shamsi','$code_karton','$vazn_karton_this','$code_mandegari','$sum_karton_anbargardani','$tedad_anbargardani','$nakhales_anbargardani','$khales_anbargardani','$shane_anbargardani')");  
	$insert_kala_res=mysql_query($insert_kala_q);
	/*لاگ*/
    $max_id=$db->get_from_where("MAX(id_anbargardani_det)","$TableName","code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear'");   
	$log_i=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$max_id','ثبت',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')");
	if($insert_kala_res and $log_i) 
	{
	   mysql_query("COMMIT");
	   IF(($code_bastebandy!=2)and(($tedad_anbargardani==0)OR($nakhales_anbargardani==0)OR($khales_anbargardani==0)))echo "<script>alert('تعداد یا مقدار ناخالص یا مقدار خالص وارد نشده است')</script>";   
	   echo '<script>window.location=\''.$FileName.'?id_anbargardani_='.$id_anbargardani_.'&code_kala_='.$code_kala_.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\' </script>'; 
	 }
	 else  
     {
       mysql_query('ROLLBACK');//nothing will be done, I assume it's for testing
       echo "<script>alert('مشکلی در ثبت به وجود آمده است')</script>";  
     }
	 mysql_query('SET AUTOCOMMIT=1'); 
 }
}

/*************INSERT BUTTON******/// ثبت اطلاعات    
if(isset($Edit_x))
{
 if(isPermitSave($code_bastebandy,$id_anbargardani_,$id_mojody,$tedad_anbargardani,$nakhales_anbargardani,$khales_anbargardani,$mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear)) 
 {
	mysql_query('SET AUTOCOMMIT=0');//TRANSACTIONشروع 
    mysql_query('START TRANSACTION');
	//محاسبات برای اطمینان
    if($code_bastebandy==1)//کارتنی
	{
	  IF($code_kala_==51)$sum_karton_anbargardani=0;
	  ELSE $sum_karton_anbargardani=round(floatval($vazn_karton_this*$tedad_anbargardani),3);  
	  $khales_anbargardani=round(floatval($nakhales_anbargardani-$sum_karton_anbargardani),3);
	  if($khales_anbargardani<0) $khales_anbargardani=0;
	  IF($code_kala_==50)$shane_anbargardani=$tedad_anbargardani*$_SESSION["mtShane"];
	  ELSE IF($code_kala_==54)$shane_anbargardani=$tedad_anbargardani*$_SESSION["mtShane_dakheli"];
	  ELSE $shane_anbargardani=0;
	}
    //قوطی	
	if($code_bastebandy==2) $khales_anbargardani=round(floatval($vazn_karton_this*$tedad_anbargardani),3);
	$edit_q=("UPDATE $TableName SET tedad_anbargardani='$tedad_anbargardani',sum_karton_anbargardani='$sum_karton_anbargardani',nakhales_anbargardani='$nakhales_anbargardani',khales_anbargardani='$khales_anbargardani',shane_anbargardani='$shane_anbargardani' WHERE id_anbargardani_det='$id_anbargardani_det_';"); 
	$edit_res=mysql_query($edit_q);
	$log_e=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_anbargardani_det_','ویرایش',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')");  /*کوئری لاگ*/ 
	if($edit_res and $log_e) 
	{
	   mysql_query("COMMIT");
	   IF(($code_bastebandy!=2)and(($tedad_anbargardani==0)OR($nakhales_anbargardani==0)OR($khales_anbargardani==0)))
	   {
		echo "<script>alert('تعداد یا مقدار ناخالص یا مقدار خالص وارد نشده است');
             //$.messager.alert('My Title','Here is a error message!','error');
			 </script>";   
	    			
		} 
	   echo '<script>window.location=\''.$FileName.'?id_anbargardani_='.$id_anbargardani_.'&code_kala_='.$code_kala_.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\' </script>'; 
	 }
	 else  
     {
       mysql_query('ROLLBACK');//nothing will be done, I assume it's for testing
       echo "<script>alert('مشکلی در ویرایش به وجود آمده است')</script>";  
     }
	 mysql_query('SET AUTOCOMMIT=1'); 
 }
}
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<form method="post" name="myform" id="myform" >
<div align="center">
<table width="100%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr>
  <td class="title" >
   <span style="float:center">جدول موجودی کالای '.$nameKala.' (کد کالا :'.$code_kala_.')</span>
   <!--<span style="float:right;font-size:10px"><input type="checkbox" name="chkmandedar" value="'.$chkmandedar.'" onChange="myform.submit();"/>&nbsp; نمایش مانده دارها</span>-->
  </td>
  </tr>
 <tr>
  <td class="title">
   <span style="float:right"   onClick="window.open(\'print_anbargardani_det.php?code_kala_='.$code_kala_.'\',\'_blank\',\'scrollbars=yes\')" id="printer" style="display: block;" title="چاپ انبارگردانی"><a href="#"></a></span>
   <span style="float:center">برای ثبت مقادیر انبارگردانی روی سطر مورد نظر کلیک کنید</span>
   <span style="float:left" onClick="window.location=\'anbargardani.php?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-back"  title="بازگشت"  ><a href="#"></a></span> 
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
	 <td rowspan="2" width="4%">زیر انبار</td>
	 <td rowspan="2" width="4%">کشور</td>
	 <td rowspan="2" width="5%">تولیدکننده</td>
	 <td colspan="3" width="15%">تاریخ تولید</td>
	 <td rowspan="2" width="5%">تاریخ ماندگاری</td>';
	 if($code_bastebandy==1)//کارتن
	 {echo'
	   <td rowspan="2" width="5%">وزن کارتن</td>
	   <td colspan="3" width="20%">موجودی سیستم</td>
	   <td colspan="4" width="20%">موجودی انبارگردانی</td>
	   <td colspan="3" width="10%">کسری</td>
	   <td colspan="3" width="10%">اضافه</td>
	   ';
	 }
	 else if($code_bastebandy==2)//قوطی
	 {echo'
	   <td rowspan="2" width="5%">وزن قوطی</td>
	   <td colspan="2" width="15%">موجودی سیستم</td>
	   <td colspan="2" width="15%">موجودی انبارگردانی</td>
	   <td colspan="2" width="7%">کسری</td>
	   <td colspan="2" width="7%">اضافه</td>
	   ';
	 }
	 else if(($code_bastebandy==3)or($code_bastebandy==4)or($code_bastebandy==7))//لاشه یا کیسه یا وکیوم
	 {echo'
	   <td colspan="2" width="15%">موجودی سیستم</td>
	   <td colspan="2" width="15%">موجودی انبارگردانی</td>
	   <td colspan="2" width="7%">کسری</td>
	   <td colspan="2" width="7%">اضافه</td>
	   ';
	 }
	 else if(($code_bastebandy==5)or($code_bastebandy==6))//دست یا عدد
	 {echo'
	   <td  width="15%">موجودی سیستم</td>
	   <td  width="15%">موجودی انبارگردانی</td>
	   <td  width="7%">کسری</td>
	   <td  width="7%">اضافه</td>
	   ';
	 }
	  //IF($Mode!='')
	 echo' <td rowspan="2" width="10%">عملیات</td>';
	 echo'
	 </tr>
	  <tr class="table-title">
	   <td>سال</td>
	   <td>ماه</td>
	   <td>روز</td>
	   <td>تعداد</td>';
	   if($code_bastebandy==1)echo'<td>ناخالص</td>';
	   if(($code_bastebandy!=5)AND($code_bastebandy!=6))echo'<td >خالص</td>';
	   echo'<td>تعداد</td>';
	   if($code_bastebandy==1)echo'<td>وزن کارتنها</td><td>ناخالص</td>';
	   if(($code_bastebandy!=5)AND($code_bastebandy!=6))echo'<td >خالص</td>';
	   echo'<td>تعداد</td>';
	   if($code_bastebandy==1)echo'<td>ناخالص</td>';
	   if(($code_bastebandy!=5)AND($code_bastebandy!=6))echo'<td >خالص</td>';
	   echo'<td>تعداد</td>';
	   if($code_bastebandy==1)echo'<td>ناخالص</td>';
	   if(($code_bastebandy!=5)AND($code_bastebandy!=6))echo'<td >خالص</td>';
	   echo'
	 </tr>';
   $Cntr=0;
   $q1="SELECT $TableName.*,mojody_kala.*,kala.name_kala,keshvar.name_keshvar,tolidkonande.name_tolidkonande,l_s_d.noe_ziranbar,l_s_d.name_ziranbar,karton.vazn_karton,sharh_mandegari 
          From mojody_kala   
          LEFT JOIN  $TableName ON mojody_kala.id=$TableName.id_mojody
          INNER JOIN kala ON mojody_kala.code_kala=kala.code_kala
          INNER JOIN keshvar ON mojody_kala.code_keshvar=keshvar.code_keshvar
          LEFT JOIN karton ON mojody_kala.code_karton=karton.code_karton 
          INNER JOIN tolidkonande ON mojody_kala.code_tolidkonande=tolidkonande.code_tolidkonande
          INNER JOIN list_sardkhane_detail l_s_d ON mojody_kala.code_ziranbar=l_s_d.code_ziranbar AND mojody_kala.code_ostan=l_s_d.code_ostan AND mojody_kala.code_anbar=l_s_d.code_anbar  	  
	      INNER JOIN tarikh_mandegari ON tarikh_mandegari.code_mandegari=mojody_kala.code_mandegari    
		  WHERE mojody_kala.code_kala='$code_kala_' AND mojody_kala.code_ostan='$mt_gl_code_ostan' AND mojody_kala.code_anbar='$mt_gl_code_anbar' AND mojody_kala.year='$mtActiveYear' AND mojody_kala.deleted=0
		  order by mojody_kala.sal_tolid_shamsi,mojody_kala.mah_tolid_shamsi,mojody_kala.rouz_tolid_shamsi asc";
   $allMojody = $db->query($q1);
   $count_mojody =mysql_num_rows($allMojody);
   while($row=$db->fetch_assoc($allMojody))
   {
    //موجودی با توابع
	$tedad_karton=mojodyKarton($row['code_ostan'],$row['code_anbar'],$row['year'],$row['code_ziranbar'],$row['code_kala'],$row['code_keshvar'],$row['code_tolidkonande'],$row['sal_tolid_shamsi'],$row['mah_tolid_shamsi'],$row['rouz_tolid_shamsi'],$row['code_karton'],$row['code_mandegari']);
	$mojody_nakhales=mojodyNakhales($row['code_ostan'],$row['code_anbar'],$row['year'],$row['code_ziranbar'],$row['code_kala'],$row['code_keshvar'],$row['code_tolidkonande'],$row['sal_tolid_shamsi'],$row['mah_tolid_shamsi'],$row['rouz_tolid_shamsi'],$row['code_karton'],$row['code_mandegari']);
    $mojody_khales=mojodyKhales($row['code_ostan'],$row['code_anbar'],$row['year'],$row['code_ziranbar'],$row['code_kala'],$row['code_keshvar'],$row['code_tolidkonande'],$row['sal_tolid_shamsi'],$row['mah_tolid_shamsi'],$row['rouz_tolid_shamsi'],$row['code_karton'],$row['code_mandegari']);
    
	IF(($right_ins)AND($row['id_anbargardani_det']=='')){$editclick='onClick="window.location=\''.$FileName.'?Mode=Insert&id_mojody_='.$row['id'].'&id_anbargardani_='.$id_anbargardani_.'&code_kala_='.$code_kala_.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'"';}	 
	ELSE IF(($right_edt)AND($row['id_anbargardani_det']!='')){$editclick='onClick="window.location=\''.$FileName.'?Mode=Edit&id_anbargardani_det_='.$row['id_anbargardani_det'].'&id_anbargardani_='.$id_anbargardani_.'&code_kala_='.$code_kala_.'&code_bastebandy_='.$code_bastebandy_.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'"';}	 

	//اونهایی که موجودی صفر دارند نمایش داده نمی شود برای صفحه جزئیات حواله
	
	//IF(($chkmandedar==0)or(($chkmandedar==1)and(($code_bastebandy==1 AND $tedad_karton!=0 AND $mojody_nakhales!=0 AND $mojody_khales!=0)OR($code_bastebandy==2 AND $tedad_karton!=0 AND $mojody_khales!=0)OR($code_bastebandy==3 AND $tedad_karton!=0 AND $mojody_khales!=0))))
	//{ 
      if($Cntr++%2) echo'<tr class="table-odd"/>';
      else echo '<tr class="table-even" />';
      if($Mode=='Insert' and $row['id']==$id_mojody_)
      {
	   echo'
	   <td>'.$radif++.'</td>
	   <td ><input class="textboxme" readonly type="text" name="id_mojody" value="'.$row['id'].'" /></td>
	   <td ><input class="textboxme" type="hidden" name="code_ziranbar" value="'.$row['code_ziranbar'].'" /> <input class="textboxme" readonly type="text" name="name_ziranbar" value="'.$row['name_ziranbar'].'" /></td>
	   <td ><input class="textboxme" type="hidden" name="code_keshvar" value="'.$row['code_keshvar'].'" /><input class="textboxme" readonly type="text" name="name_keshvar" value="'.$row['name_keshvar'].'" /></td>
	   <td ><input class="textboxme" type="hidden" name="code_tolidkonande" value="'.$row['code_tolidkonande'].'" /><input class="textboxme" readonly type="text" name="name_tolidkonande" value="'.$row['name_tolidkonande'].'" /></td>
	   <td ><input class="textboxme" readonly type="text" name="sal_tolid_shamsi" value="'.$row['sal_tolid_shamsi'].'" /></td>
	   <td ><input class="textboxme" type="hidden" name="mah_tolid_shamsi" value="'.$row['mah_tolid_shamsi'].'" /><input class="textboxme" readonly type="text" value="'.$mahshamsiArr[$row['mah_tolid_shamsi']].'" /></td>
	   <td ><input class="textboxme" readonly type="text" name="rouz_tolid_shamsi" value="'.$row['rouz_tolid_shamsi'].'" /></td>
	   <td ><input class="textboxme" type="hidden" name="code_mandegari" value="'.$row['code_mandegari'].'" /><input class="textboxme" readonly type="text" name="sharh_mandegari" value="'.$row['sharh_mandegari'].'" /></td>';
	   if(($code_bastebandy==1)OR($code_bastebandy==2))//
	   {echo'
	    <td ><input class="textboxme" type="hidden" name="code_karton" value="'.$row['code_karton'].'" /><input class="textboxme" readonly type="text" name="vazn_karton_this" value="'.$row['vazn_karton_this'].'" /></td>';   
	   }
	   echo'<td >'.$tedad_karton.'</td>';
	   if($code_bastebandy==1)echo'<td '.$editclick.'>'.round($mojody_nakhales,3).'</td>';
	   if(($code_bastebandy!=5)AND($code_bastebandy!=6))echo'<td >'.round($mojody_khales,3).'</td>';
	   if($code_bastebandy==1)//کارتنی
		{
		 echo'
		     <td><input class="textboxme" type="text" name="tedad_anbargardani" value="'.$tedad_anbargardani.'"'; IF($code_kala_!=51) echo'onblur="return sumkarton()"'; echo' onkeypress="return isNumber(event)"/></td>
			 <td><input class="textboxme" readonly type="text" name="sum_karton_anbargardani" value="'.$sum_karton_anbargardani.'"/></td>       		
		     <td><input class="textboxme" type="text" name="nakhales_anbargardani" value="'.$nakhales_anbargardani.'" onblur="return vazn_khales()" onKeydown="return PressfloatOnly(event,this)"/></td>
			 <td><input class="textboxme" type="text" name="khales_anbargardani" value="'.$khales_anbargardani.'"'; IF($code_kala_!=51) {echo' readonly  onfocus="return vazn_khales()"'; } echo' /></td>';
		}
	    if($code_bastebandy==2)//قوطی
		{
		 echo'
		     <td><input class="textboxme" type="text" name="tedad_anbargardani" value="'.$tedad_anbargardani.'" onblur="return sumghooti()" onkeypress="return isNumber(event)"/></td>
			 <td><input class="textboxme" readonly type="text" name="khales_anbargardani" value="'.$khales_anbargardani.'"  onfocus="return sumghooti()"/></td>';
		}
	    else if(($code_bastebandy==3)or($code_bastebandy==4)or($code_bastebandy==7))//لاشه یا کیسه یا وکیوم
		{
		 echo'
		     <td><input class="textboxme" type="text" name="tedad_anbargardani" value="'.$tedad_anbargardani.'"  onkeypress="return isNumber(event)"/></td>
			 <td><input class="textboxme" type="text" name="khales_anbargardani" value="'.$khales_anbargardani.'" /></td>';
		}
	    if(($code_bastebandy==5)OR($code_bastebandy==6))//دست یا عدد
		{
		 echo'
		     <td><input class="textboxme" type="text" name="tedad_anbargardani" value="'.$tedad_anbargardani.'"  onkeypress="return isNumber(event)"/></td>';
		}		
		echo'
		<td colspan="7"><input class="buttonme" type="submit" name="Insert_x" id="sabt" value="ثبت"/>
	   	    <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?id_anbargardani_='.$id_anbargardani_.'&code_kala_='.$code_kala_.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'"/>
        </td>
	   </tr>';
	  }
	  else if($Mode=='Edit' and $row['id_anbargardani_det']==$id_anbargardani_det_)
      {
	   echo'
	   <td>'.$radif++.'</td>
	   <td ><input class="textboxme" readonly type="text" name="id_mojody" value="'.$row['id'].'" /></td>
	   <td ><input class="textboxme" type="hidden" name="code_ziranbar" value="'.$row['code_ziranbar'].'" /> <input class="textboxme" readonly type="text" name="name_ziranbar" value="'.$row['name_ziranbar'].'" /></td>
	   <td ><input class="textboxme" type="hidden" name="code_keshvar" value="'.$row['code_keshvar'].'" /><input class="textboxme" readonly type="text" name="name_keshvar" value="'.$row['name_keshvar'].'" /></td>
	   <td ><input class="textboxme" type="hidden" name="code_tolidkonande" value="'.$row['code_tolidkonande'].'" /><input class="textboxme" readonly type="text" name="name_tolidkonande" value="'.$row['name_tolidkonande'].'" /></td>
	   <td ><input class="textboxme" readonly type="text" name="sal_tolid_shamsi" value="'.$row['sal_tolid_shamsi'].'" /></td>
	   <td ><input class="textboxme" type="hidden" name="mah_tolid_shamsi" value="'.$row['mah_tolid_shamsi'].'" /><input class="textboxme" readonly type="text" value="'.$mahshamsiArr[$row['mah_tolid_shamsi']].'" /></td>
	   <td ><input class="textboxme" readonly type="text" name="rouz_tolid_shamsi" value="'.$row['rouz_tolid_shamsi'].'" /></td>
	   <td ><input class="textboxme" type="hidden" name="code_mandegari" value="'.$row['code_mandegari'].'" /><input class="textboxme" readonly type="text" name="sharh_mandegari" value="'.$row['sharh_mandegari'].'" /></td>';
	   if(($code_bastebandy==1)or($code_bastebandy==2))//
	   {echo'
	    <td ><input class="textboxme" type="hidden" name="code_karton" value="'.$row['code_karton'].'" /><input class="textboxme" readonly type="text" name="vazn_karton_this" value="'.$row['vazn_karton_this'].'" /></td>';   
	   }
	   echo'
	   <td >'.$tedad_karton.'</td>';
	   if($code_bastebandy==1)echo'<td '.$editclick.'>'.round($mojody_nakhales,3).'</td>';
	    if(($code_bastebandy!=5)AND($code_bastebandy!=6))echo'<td >'.round($mojody_khales,3).'</td>';
	   if($code_bastebandy==1)
	   {
		 echo'
		  <td><input class="textboxme" type="text" name="tedad_anbargardani" value="'.$row['tedad_anbargardani'].'"'; IF($code_kala_!=51) echo'onblur="return sumkarton()"'; echo' onkeypress="return isNumber(event)"/></td>
		  <td><input class="textboxme" readonly type="text" name="sum_karton_anbargardani" value="'.$row['sum_karton_anbargardani'].'"/></td>       		
		  <td><input class="textboxme" type="text" name="nakhales_anbargardani" value="'.$row['nakhales_anbargardani'].'" onblur="return vazn_khales()" onKeydown="return PressfloatOnly(event,this)"/></td>
	      <td><input class="textboxme" type="text" name="khales_anbargardani" value="'.$row['khales_anbargardani'].'"'; IF($code_kala_!=51) {echo' readonly  onfocus="return vazn_khales()"'; } echo' /></td>';
	   }
	   if($code_bastebandy==2)
	   {
		 echo'
		  <td><input class="textboxme" type="text" name="tedad_anbargardani" value="'.$row['tedad_anbargardani'].'" onblur="return sumghooti()" onkeypress="return isNumber(event)"/></td>
	      <td><input class="textboxme" readonly type="text" name="khales_anbargardani" value="'.$row['khales_anbargardani'].'"  onfocus="return sumghooti()"/></td>';
	   }
	   if(($code_bastebandy==3)or($code_bastebandy==4)or($code_bastebandy==7))//لاشه یا کیسه یا وکیوم
	   {
		 echo'
		  <td><input class="textboxme" type="text" name="tedad_anbargardani" value="'.$row['tedad_anbargardani'].'" onkeypress="return isNumber(event)"/></td>
	      <td><input class="textboxme" type="text" name="khales_anbargardani" value="'.$row['khales_anbargardani'].'"  /></td>';
	   }
	   if(($code_bastebandy==5)OR($code_bastebandy==6))//دست یا عدد
	   {
		 echo'
		  <td><input class="textboxme" type="text" name="tedad_anbargardani" value="'.$row['tedad_anbargardani'].'" onkeypress="return isNumber(event)"/></td>';		
	   }
		echo'
		<td colspan="7"><input class="buttonme" type="submit" name="Edit_x" id="sabt" value="ویرایش"/>
	   	    <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?id_anbargardani_='.$id_anbargardani_.'&code_kala_='.$code_kala_.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'"/>
        </td>
	   </tr>';
	  }
	  else
	  {
	   $diffrence_tedad=0;$diffrence_t_kasry=0;$diffrence_t_ezafe=0;
	   $diffrence_nakhales=0;$diffrence_na_kasry=0;$diffrence_na_ezafe=0;
	   $diffrence_khales=0;$diffrence_kh_kasry=0;$diffrence_kh_ezafe=0;
	   IF($row['id_anbargardani_det']) 
	   {$diffrence_tedad=$tedad_karton-$row['tedad_anbargardani'];
	    IF($diffrence_tedad>0)$diffrence_t_kasry=($diffrence_tedad);
	    ELSE IF($diffrence_tedad<0)$diffrence_t_ezafe=abs($diffrence_tedad);
		
		$diffrence_nakhales=$mojody_nakhales-$row['nakhales_anbargardani'];
	    IF($diffrence_nakhales>0)$diffrence_na_kasry=($diffrence_nakhales);
	    ELSE IF($diffrence_nakhales<0)$diffrence_na_ezafe=abs($diffrence_nakhales);
		
		$diffrence_khales=$mojody_khales-$row['khales_anbargardani'];
	    IF($diffrence_khales>0)$diffrence_kh_kasry=($diffrence_khales);
	    ELSE IF($diffrence_khales<0)$diffrence_kh_ezafe=abs($diffrence_khales);
	   }
	   echo'
	   <td>'.$radif++.'</td>
	   <td '.$editclick.' '.$InsClick.'>'.$row['id'].'</td>
	   <td '.$editclick.' '.$InsClick.'>'.$row['name_ziranbar'].'</td>
	   <td '.$editclick.' '.$InsClick.'>'.$row['name_keshvar'].'</td>
	   <td '.$editclick.' '.$InsClick.'>'.$row['name_tolidkonande'].'</td>
	   <td '.$editclick.' '.$InsClick.'>'.$row['sal_tolid_shamsi'].'</td>
	   <td '.$editclick.' '.$InsClick.'>'.$mahshamsiArr[$row['mah_tolid_shamsi']].'</td>
	   <td '.$editclick.' '.$InsClick.'>'.$row['rouz_tolid_shamsi'].'</td>
	   <td '.$editclick.' '.$InsClick.'>'.$row['sharh_mandegari'].'</td>';
	   if(($code_bastebandy==1)OR($code_bastebandy==2))//کارتن یا قوطی
	   {echo'
	    <td '.$editclick.' '.$InsClick.'>'.$row['vazn_karton_this'].'</td>';   
	   }
	   echo'<td '.$editclick.' '.$InsClick.'>'.$tedad_karton.'</td>';
	   if($code_bastebandy==1)echo'<td '.$editclick.' '.$InsClick.'>'.round($mojody_nakhales,3).'</td>';
	   if(($code_bastebandy!=5)AND($code_bastebandy!=6))echo'<td '.$editclick.' '.$InsClick.'>'.round($mojody_khales,3).'</td>';
	   IF($row['id_anbargardani_det'])//اطلاعات در فرم انبارگردانی ثبت شده
	   {
	     echo'<td '.$editclick.' '.$InsClick.'>'.$row['tedad_anbargardani'].'</td>';
	     if($code_bastebandy==1){echo'<td '.$editclick.' '.$InsClick.'>'.round($row['sum_karton_anbargardani'],3).'</td><td '.$editclick.' '.$InsClick.'>'.round($row['nakhales_anbargardani'],3).'</td>';}
	     if(($code_bastebandy!=5)AND($code_bastebandy!=6))echo'<td '.$editclick.' '.$InsClick.'>'.round($row['khales_anbargardani'],3).'</td>';
	     
	     echo'<td '.$editclick.'>'.$diffrence_t_kasry.'</td>';
	     if($code_bastebandy==1)echo'<td '.$editclick.'>'.round($diffrence_na_kasry,3).'</td>';
	     if(($code_bastebandy!=5)AND($code_bastebandy!=6))echo'<td '.$editclick.'>'.round($diffrence_kh_kasry,3).'</td>';
	     echo'<td '.$editclick.'>'.$diffrence_t_ezafe.'</td>';
	     if($code_bastebandy==1)echo'<td '.$editclick.'>'.round($diffrence_na_ezafe,3).'</td>';
	     if(($code_bastebandy!=5)AND($code_bastebandy!=6))echo'<td '.$editclick.'>'.round($diffrence_kh_ezafe,3).'</td>';
	   }
	   ELSE //انهایی که اطلاعات ثبت نشده با دش نشان میدهیم
	   {
		 echo'<td '.$editclick.' '.$InsClick.'>-</td>';
	     if($code_bastebandy==1){echo'<td '.$editclick.' '.$InsClick.'>-</td><td '.$editclick.' '.$InsClick.'>-</td>';}
	     if(($code_bastebandy!=5)AND($code_bastebandy!=6))echo'<td '.$editclick.' '.$InsClick.'>-</td>';
	     
	     echo'<td '.$editclick.'>-</td>';
	     if($code_bastebandy==1)echo'<td '.$editclick.'>-</td>';
	     if(($code_bastebandy!=5)AND($code_bastebandy!=6))echo'<td '.$editclick.'>-</td>';
	     echo'<td '.$editclick.'>-</td>';
	     if($code_bastebandy==1)echo'<td '.$editclick.'>-</td>';
	     if(($code_bastebandy!=5)AND($code_bastebandy!=6))echo'<td '.$editclick.'>-</td>';
		   
	   }
	   echo'
	   <td>';
	   IF($row['id_anbargardani_det'])echo'<img src="images/ok2.png" />';
	   echo'
	   </td>
	  </tr>';
	  }
	//}
    $sum_tedad_karton+=$tedad_karton;
    $sum_mojody_nakhales+=$mojody_nakhales;
    $sum_mojody_khales+=$mojody_khales;
	$sum_tedad_anbargardani+=$row['tedad_anbargardani'];
	$sum_nakhales_anbargardani+=$row['nakhales_anbargardani'];
	$sum_mojmo_karton+=$row['sum_karton_anbargardani'];
	$sum_khales_anbargardani+=$row['khales_anbargardani'];
	$sum_diffrence_t_kasry+=$diffrence_t_kasry;
	$sum_diffrence_na_kasry+=$diffrence_na_kasry;
	$sum_diffrence_kh_kasry+=$diffrence_kh_kasry;
	$sum_diffrence_t_ezafe+=$diffrence_t_ezafe;
	$sum_diffrence_na_ezafe+=$diffrence_na_ezafe;
	$sum_diffrence_kh_ezafe+=$diffrence_kh_ezafe;
   }
   $anbargardanicount=$db->get_from_where("COUNT(*)","mt_anbargardani_detail","id_anbargardani='".$id_anbargardani_."'");
    echo'
   	  <tr class="print_table-even sum-row-white-b">';
	   IF(($code_bastebandy==1)or($code_bastebandy==2)) echo'<td id="sum_row" colspan="10">جمع مقادیر</td>';
	   ELSE echo'<td id="sum_row" colspan="9">جمع مقادیر</td>';
	   echo'
	   <td>'.virgul($sum_tedad_karton).'</td>';
	   if($code_bastebandy==1) echo'<td>'.round($sum_mojody_nakhales,3).'</td>';
	   if(($code_bastebandy!=5)AND($code_bastebandy!=6)) echo'<td>'.round($sum_mojody_khales,3).'</td>';
	   echo'<td>'.virgul($sum_tedad_anbargardani).'</td>';
	   if($code_bastebandy==1) echo'<td>'.round($sum_mojmo_karton,3).'</td><td>'.round($sum_nakhales_anbargardani,3).'</td>';
       if(($code_bastebandy!=5)AND($code_bastebandy!=6)) echo'<td>'.round($sum_khales_anbargardani,3).'</td>	   
       <td>'.virgul($sum_diffrence_t_kasry).'</td>';	   
       if($code_bastebandy==1)echo'<td>'.round($sum_diffrence_na_kasry,3).'</td>';
	   echo'
       <td>'.round($sum_diffrence_kh_kasry,3).'</td>
       <td>'.virgul($sum_diffrence_t_ezafe).'</td>';
	   if($code_bastebandy==1)echo'<td>'.round($sum_diffrence_na_ezafe,3).'</td>';
	   if(($code_bastebandy!=5)AND($code_bastebandy!=6))echo'<td>'.round($sum_diffrence_kh_ezafe,3).'</td>';
	   echo'
	   <td></td>
	  </tr>
   </table>
  </td>
 </tr> 
 <!--پايان مرکز صفحه -->
 <!-- فوتر-->
 <tr >
  <td class="title">
    <!--<span style="float:center">';IF(($right_eslah)AND($count_mojody>0)AND($anbargardanicount>0)) {echo'<input type="button" class="buttonme"  value="اصلاح مغایرت ها با ایجاد رسید و حواله" onClick="window.location=\'anbargardani_detail.php?eslah=1&id_anbargardani_='.$id_anbargardani_.'&code_kala_='.$code_kala_.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'">';}echo'</span>-->
	<span style="float:center">';IF(($right_transfer)AND($count_mojody>0)AND($anbargardanicount>0)) {echo'<input type="button" class="buttonme"  value="اصلاح موجودی اول دوره سال بعد" onClick="window.location=\'anbargardani_detail.php?transfer=1&id_anbargardani_='.$id_anbargardani_.'&code_kala_='.$code_kala_.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'">';}echo'</span> 
    <span style="float:center">';IF(($right_mojavez)AND($count_mojody>0)AND($anbargardanicount>0)) {echo'<input type="button" class="buttonme"  value="ایجاد نامه در کمیسون افت و کسری" onClick="window.location=\'anbargardani_detail.php?mojavez=1&id_anbargardani_='.$id_anbargardani_.'&code_kala_='.$code_kala_.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'">';}echo'</span> 
	<!--<span style="float:center">';IF(SuperUser()) {echo'<input type="button" class="buttonme"  value="mandegari" onClick="window.location=\'anbargardani_detail.php?eslah_mandegari=1&id_anbargardani_='.$id_anbargardani_.'&code_kala_='.$code_kala_.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'">';}echo'</span> -->
	<span style="float:left" onClick="window.location=\'anbargardani.php?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-back"  title="بازگشت"  ><a href="#"></a></span> 
  </td>
 </tr> 
 <!-- پايان فوتر--> 
</table>
</div>
</form>
</body>
</html>';
//////////////////////////////////////////////////////////////////////////////////////////////
if(isset($eslah))
{
    mysql_query('SET AUTOCOMMIT=0');//TRANSACTIONشروع 
    mysql_query('START TRANSACTION');
    $q_all="SELECT * From $TableName WHERE id_anbargardani=$id_anbargardani_ AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear'";
	$all = $db->query($q_all);
    while($row=$db->fetch_assoc($all))
    {
	 if($_SESSION["mtActiveYear"]==$yy) $tarikh_form=AsLDate($yymmdd);
	 else $tarikh_form=$mtEndDateSh;
	 $IssuedTime = date('H:i');
	 $noe_tahvil_bar=10;
	 $code_bastebandy=$db->get_from_where("code_bastebandy","kala","code_kala=".$row['code_kala'].""); 
     //امضاکنندگان رسید
	 $signiture ="select sign_id from mt_typesign where activate=1 and type_id=1 and code_ostan=".$row['code_ostan']." and code_anbar=".$row['code_anbar']." ORDER BY turn";
     $allsigniture  = $db->query($signiture);
     $separatesigniture='';
     while($row_id=$db->fetch_assoc($allsigniture)) $separatesigniture = $separatesigniture . $row_id['sign_id'].';' ;
     $separatesigniture=rtrim($separatesigniture, ";");
	 //امضاکنندگان حواله و برگه خروج
	 $signiture_havale ="select sign_id from mt_typesign where activate=1 and type_id=2 and code_ostan=".$row['code_ostan']." and code_anbar=".$row['code_anbar']." ORDER BY turn";
     $allsigniture_havale = $db->query($signiture_havale);
     $separatesigniture_havale='';
     while($row_sign1=$db->fetch_assoc($allsigniture_havale)) $separatesigniture_havale = $separatesigniture_havale . $row_sign1['sign_id'].';' ;
     $separatesigniture_havale=rtrim($separatesigniture_havale, ";");
     $signiture_khorooj ="select sign_id from mt_typesign where activate=1 and type_id=4 and code_ostan=".$row['code_ostan']." and code_anbar=".$row['code_anbar']." ORDER BY turn";
     $allsigniture_khorooj = $db->query($signiture_khorooj);
     $separatesigniture_khorooj='';
     while($row_sign2=$db->fetch_assoc($allsigniture_khorooj)) $separatesigniture_khorooj = $separatesigniture_khorooj . $row_sign2['sign_id'].';' ;
     $separatesigniture_khorooj=rtrim($separatesigniture_khorooj, ";"); 
	 //در صورتیکه ویرایش کرد
	 $tedad_sys_first=mojodyKarton($row['code_ostan'],$row['code_anbar'],$row['year'],$row['code_ziranbar'],$row['code_kala'],$row['code_keshvar'],$row['code_tolidkonande'],$row['sal_tolid_shamsi'],$row['mah_tolid_shamsi'],$row['rouz_tolid_shamsi'],$row['code_karton'],$row['code_mandegari']);
	 $mojody_nakhales_sys_first=mojodyNakhales($row['code_ostan'],$row['code_anbar'],$row['year'],$row['code_ziranbar'],$row['code_kala'],$row['code_keshvar'],$row['code_tolidkonande'],$row['sal_tolid_shamsi'],$row['mah_tolid_shamsi'],$row['rouz_tolid_shamsi'],$row['code_karton'],$row['code_mandegari']);
     $mojody_khales_sys_first=mojodyKhales($row['code_ostan'],$row['code_anbar'],$row['year'],$row['code_ziranbar'],$row['code_kala'],$row['code_keshvar'],$row['code_tolidkonande'],$row['sal_tolid_shamsi'],$row['mah_tolid_shamsi'],$row['rouz_tolid_shamsi'],$row['code_karton'],$row['code_mandegari']);
  
	 $difference_tedad_first=$row['tedad_anbargardani']-$tedad_sys_first;
	 $difference_nakhales_first=$row['nakhales_anbargardani']-$mojody_nakhales_sys_first;
	 $difference_khales_first=$row['khales_anbargardani']-$mojody_khales_sys_first;
	 
	 IF($difference_tedad_first>0)//تعداد
	 {
	  $id_resid=$db->get_from_where("id","resid","id_anbargardani_det=".$row['id_anbargardani_det']." AND create_form=2 AND tedad_karton_r>0  AND deleted=0 AND status=0"); 
	  $sh_resid=$db->get_from_where("shomare_resid","resid","id_anbargardani_det=".$row['id_anbargardani_det']." AND create_form=2 AND tedad_karton_r>0  AND deleted=0 AND status=0"); 
	  $id_resid_detail=$db->get_from_where("id","resid_detail","shomare_resid='".$sh_resid."' AND id_anbargardani_det=".$row['id_anbargardani_det']." AND resid_deleted=0 AND status=0"); 
	  $id_resid_kala_detail=$db->get_from_where("id","resid_kala_detail","shomare_resid='".$sh_resid."' AND id_anbargardani_det=".$row['id_anbargardani_det']." AND resid_deleted=0 AND status=0"); 
	  IF($id_resid>0)  {
		  $del_res=$db->query("UPDATE resid SET status=1 WHERE id=$id_resid AND id_anbargardani_det=".$row['id_anbargardani_det']."");
		  $del_res_det=$db->query("UPDATE resid_detail SET status=1 WHERE id=$id_resid_detail AND id_anbargardani_det=".$row['id_anbargardani_det']."");
		  $del_res_kala_det=$db->query("UPDATE resid_kala_detail SET status=1 WHERE id=$id_resid_kala_detail AND id_anbargardani_det=".$row['id_anbargardani_det']."");
	  }
     }
	 ELSE IF($difference_tedad_first<0)//تعداد
	 {
	  $id_havale=$db->get_from_where("id","havale","id_anbargardani_det=".$row['id_anbargardani_det']." AND create_form=2 AND tedad_karton_h>0 AND deleted=0 AND status=0"); 
	  $sh_havale=$db->get_from_where("shomare_havale_anbar","havale","id_anbargardani_det=".$row['id_anbargardani_det']." AND create_form=2 AND tedad_karton_h>0 AND deleted=0 AND status=0"); 
	  $id_havale_detail=$db->get_from_where("id","havale_detail","shomare_havale_anbar='".$sh_havale."' AND id_anbargardani_det=".$row['id_anbargardani_det']." AND havale_deleted=0 AND status=0"); 
	  IF($id_havale>0)  {
		  $del_res=$db->query("UPDATE havale SET status=1 WHERE id=$id_havale AND id_anbargardani_det=".$row['id_anbargardani_det']."");
		  $del_res_det=$db->query("UPDATE havale SET status=1 WHERE id=$id_havale_detail AND id_anbargardani_det=".$row['id_anbargardani_det']."");
	  }
     }
	 IF($difference_nakhales_first>0)//ناخالص
	 {
	  $id_resid=$db->get_from_where("id","resid","id_anbargardani_det=".$row['id_anbargardani_det']." AND create_form=2 AND vazn_nakhales_r>0  AND deleted=0 AND status=0"); 
	  $sh_resid=$db->get_from_where("shomare_resid","resid","id_anbargardani_det=".$row['id_anbargardani_det']." AND create_form=2 AND vazn_nakhales_r>0  AND deleted=0 AND status=0"); 
	  $id_resid_detail=$db->get_from_where("id","resid_detail","shomare_resid='".$sh_resid."' AND id_anbargardani_det=".$row['id_anbargardani_det']." AND resid_deleted=0 AND status=0"); 
	  $id_resid_kala_detail=$db->get_from_where("id","resid_kala_detail","shomare_resid='".$sh_resid."' AND id_anbargardani_det=".$row['id_anbargardani_det']." AND resid_deleted=0 AND status=0"); 
	  IF($id_resid>0)  {
		  $del_res=$db->query("UPDATE resid SET status=1 WHERE id=$id_resid AND id_anbargardani_det=".$row['id_anbargardani_det']."");
		  $del_res_det=$db->query("UPDATE resid_detail SET status=1 WHERE id=$id_resid_detail AND id_anbargardani_det=".$row['id_anbargardani_det']."");
		  $del_res_kala_det=$db->query("UPDATE resid_kala_detail SET status=1 WHERE id=$id_resid_kala_detail AND id_anbargardani_det=".$row['id_anbargardani_det']."");
	  }
     }
	 ELSE IF($difference_nakhales_first<0)//ناخالص
	 {
	  $id_havale=$db->get_from_where("id","havale","id_anbargardani_det=".$row['id_anbargardani_det']." AND create_form=2 AND vazn_nakhales_h>0 AND deleted=0 AND status=0"); 
	  $sh_havale=$db->get_from_where("shomare_havale_anbar","havale","id_anbargardani_det=".$row['id_anbargardani_det']." AND create_form=2 AND vazn_nakhales_h>0 AND deleted=0 AND status=0"); 
	  $id_havale_detail=$db->get_from_where("id","havale_detail","shomare_havale_anbar='".$sh_havale."' AND id_anbargardani_det=".$row['id_anbargardani_det']." AND havale_deleted=0 AND status=0"); 
	  IF($id_havale>0)  {
		  $del_res=$db->query("UPDATE havale SET status=1 WHERE id=$id_havale AND id_anbargardani_det=".$row['id_anbargardani_det']."");
		  $del_res_det=$db->query("UPDATE havale SET status=1 WHERE id=$id_havale_detail AND id_anbargardani_det=".$row['id_anbargardani_det']."");
	  }
     }
	 IF($difference_khales_first>0)////خالص
	 {
	  $id_resid=$db->get_from_where("id","resid","id_anbargardani_det=".$row['id_anbargardani_det']." AND create_form=2 AND vazn_khales_r>0  AND deleted=0 AND status=0"); 
	  $sh_resid=$db->get_from_where("shomare_resid","resid","id_anbargardani_det=".$row['id_anbargardani_det']." AND create_form=2 AND vazn_khales_r>0  AND deleted=0 AND status=0"); 
	  $id_resid_detail=$db->get_from_where("id","resid_detail","shomare_resid='".$sh_resid."' AND id_anbargardani_det=".$row['id_anbargardani_det']." AND resid_deleted=0 AND status=0"); 
	  $id_resid_kala_detail=$db->get_from_where("id","resid_kala_detail","shomare_resid='".$sh_resid."' AND id_anbargardani_det=".$row['id_anbargardani_det']." AND resid_deleted=0 AND status=0"); 
	  IF($id_resid>0)  {
		  $del_res=$db->query("UPDATE resid SET status=1 WHERE id=$id_resid AND id_anbargardani_det=".$row['id_anbargardani_det']."");
		  $del_res_det=$db->query("UPDATE resid_detail SET status=1 WHERE id=$id_resid_detail AND id_anbargardani_det=".$row['id_anbargardani_det']."");
		  $del_res_kala_det=$db->query("UPDATE resid_kala_detail SET status=1 WHERE id=$id_resid_kala_detail AND id_anbargardani_det=".$row['id_anbargardani_det']."");
	  }
     }
	 ELSE IF($difference_khales_first<0)////خالص
	 {
	  $id_havale=$db->get_from_where("id","havale","id_anbargardani_det=".$row['id_anbargardani_det']." AND create_form=2 AND vazn_khales_h>0 AND deleted=0 AND status=0"); 
	  $sh_havale=$db->get_from_where("shomare_havale_anbar","havale","id_anbargardani_det=".$row['id_anbargardani_det']." AND create_form=2 AND vazn_khales_h>0 AND deleted=0 AND status=0"); 
	  $id_havale_detail=$db->get_from_where("id","havale_detail","shomare_havale_anbar='".$sh_havale."' AND id_anbargardani_det=".$row['id_anbargardani_det']." AND havale_deleted=0 AND status=0"); 
	  IF($id_havale>0)  {
		  $del_res=$db->query("UPDATE havale SET status=1 WHERE id=$id_havale AND id_anbargardani_det=".$row['id_anbargardani_det']."");
		  $del_res_det=$db->query("UPDATE havale SET status=1 WHERE id=$id_havale_detail AND id_anbargardani_det=".$row['id_anbargardani_det']."");
	  }
     }
	 
	 
	 $tedad_sys=mojodyKarton($row['code_ostan'],$row['code_anbar'],$row['year'],$row['code_ziranbar'],$row['code_kala'],$row['code_keshvar'],$row['code_tolidkonande'],$row['sal_tolid_shamsi'],$row['mah_tolid_shamsi'],$row['rouz_tolid_shamsi'],$row['code_karton'],$row['code_mandegari']);
	 $mojody_nakhales_sys=mojodyNakhales($row['code_ostan'],$row['code_anbar'],$row['year'],$row['code_ziranbar'],$row['code_kala'],$row['code_keshvar'],$row['code_tolidkonande'],$row['sal_tolid_shamsi'],$row['mah_tolid_shamsi'],$row['rouz_tolid_shamsi'],$row['code_karton'],$row['code_mandegari']);
     $mojody_khales_sys=mojodyKhales($row['code_ostan'],$row['code_anbar'],$row['year'],$row['code_ziranbar'],$row['code_kala'],$row['code_keshvar'],$row['code_tolidkonande'],$row['sal_tolid_shamsi'],$row['mah_tolid_shamsi'],$row['rouz_tolid_shamsi'],$row['code_karton'],$row['code_mandegari']);
     
	 $difference_tedad=$row['tedad_anbargardani']-$tedad_sys;
	 $difference_nakhales=$row['nakhales_anbargardani']-$mojody_nakhales_sys;
	 $difference_khales=$row['khales_anbargardani']-$mojody_khales_sys;
     /****************تعداد***********************/
	 //انبارگردانی بیشتر از سیستم
	 IF($difference_tedad>0)
	 {
       //ایجاد فرم رسید  
		 $w=$db->get_from_where("shomare_resid","resid","code_ostan=".$row['code_ostan']." and code_anbar=".$row['code_anbar']." AND year=".$row['year']." order by shomare_resid DESC LIMIT 0,1"); 
         if($w) {$shomare_resid=$w; $shomare_resid++;}
         else $shomare_resid=1;
		 $shomare_resid=make_pattern($shomare_resid,5);     
		 $sum_karton_r_d_sub=round($difference_tedad*$row['vazn_karton_this'],3);
		 $insert_q=("INSERT INTO resid
                    (code_ostan,code_anbar,shomare_resid,year,tarikh_resid,IssuedTime,code_bastebandy,noe_tahvil_bar,tedad_karton_r,deleted,status,taeed_nazer,sabt_nahayi,signiture_resid,create_form,id_anbargardani,id_anbargardani_det)
                     VALUES(".$row['code_ostan'].",".$row['code_anbar'].",'".$shomare_resid."',".$row['year'].",'$tarikh_form','$IssuedTime','$code_bastebandy','$noe_tahvil_bar',".$difference_tedad.",0,0,1,1,'$separatesigniture',2,".$row['id_anbargardani'].",".$row['id_anbargardani_det'].")");
	     $insert_res=mysql_query($insert_q);
		 $insert_detail_q=("INSERT INTO resid_detail(code_ostan,code_anbar,shomare_resid,year,code_kala,code_keshvar,code_tolidkonande,status,create_form,id_anbargardani,id_anbargardani_det)
                            VALUES(".$row['code_ostan'].",".$row['code_anbar'].",'".$shomare_resid."',".$row['year'].",".$row['code_kala'].",".$row['code_keshvar'].",".$row['code_tolidkonande'].",0,2,".$row['id_anbargardani'].",".$row['id_anbargardani_det'].")");  
         $insert_detail_res=mysql_query($insert_detail_q);
		 $insert_kala_q=("INSERT INTO resid_kala_detail 
                        (code_ostan,code_anbar,shomare_resid,year,code_ziranbar,code_kala,code_keshvar,code_tolidkonande,sal_tolid_shamsi,mah_tolid_shamsi,rouz_tolid_shamsi,
					     code_karton,vazn_karton_this,code_mandegari,sum_karton_r_d_sub,tedad_karton_r_d_sub,status,create_form,id_anbargardani,id_anbargardani_det)
                        VALUES(".$row['code_ostan'].",".$row['code_anbar'].",'".$shomare_resid."',".$row['year'].",".$row['code_ziranbar'].",".$row['code_kala'].",".$row['code_keshvar'].",".$row['code_tolidkonande'].",
					    ".$row['sal_tolid_shamsi'].",".$row['mah_tolid_shamsi'].",".$row['rouz_tolid_shamsi'].",".$row['code_karton'].",".$row['vazn_karton_this'].",".$row['code_mandegari'].",".$sum_karton_r_d_sub.",".$difference_tedad.",0,2,".$row['id_anbargardani'].",".$row['id_anbargardani_det'].")");  
	     $insert_kala_res=mysql_query($insert_kala_q);
		 // $insert_tadil=("INSERT INTO tadil_mojody(code_ostan,code_anbar,shomare_barge_tadil,year,tarikh_barge_tadil,noe_form_tadil,shomare_mojavez_tadil,code_ziranbar,code_kala,code_keshvar,code_tolidkonande,sal_tolid_shamsi,mah_tolid_shamsi,rouz_tolid_shamsi,code_karton,vazn_karton_this,noe_tadil,noe_kasry,tedad_karton_tadil,sum_karton_tadil,create_form,id_anbargardani,id_anbargardani_det,status,deleted) 
	                     // VALUES (".$row['code_ostan'].",".$row['code_anbar'].",'".$shomare_barge_tadil."',".$row['year'].",'".$tarikh_barge_tadil."',2,'انبارگردانی',".$row['code_ziranbar'].",".$row['code_kala'].",".$row['code_keshvar'].",".$row['code_tolidkonande'].",".$row['sal_tolid_shamsi'].",".$row['mah_tolid_shamsi'].",".$row['rouz_tolid_shamsi'].",".$row['code_karton'].",".$row['vazn_karton_this'].",1,0,".$difference_tedad.",".$sum_karton_tadil.",2,".$row['id_anbargardani'].",".$row['id_anbargardani_det'].",0,0)");
		  
        //update mojody	   
	   	 $update_tedad=mojodyKarton($row['code_ostan'],$row['code_anbar'],$row['year'],$row['code_ziranbar'],$row['code_kala'],$row['code_keshvar'],$row['code_tolidkonande'],$row['sal_tolid_shamsi'],$row['mah_tolid_shamsi'],$row['rouz_tolid_shamsi'],$row['code_karton'],$row['code_mandegari']);
	   	 $res_update_mojody=$db->query("UPDATE mojody_kala SET tedad_karton='$update_tedad' WHERE id=".$row['id_mojody']."");  	

	 }
	 ELSE IF($difference_tedad<0)//انبارگردانی کمتر از سیستم
	 {
	   //ایجاد فرم حواله
	    $difference_tedad=abs($difference_tedad);		
		$w=$db->get_from_where("shomare_havale_anbar","havale","code_ostan=".$row['code_ostan']." and code_anbar=".$row['code_anbar']." AND year=".$row['year']." order by shomare_havale_anbar DESC LIMIT 0,1"); 
        if($w) {$shomare_havale_anbar=$w; $shomare_havale_anbar++;}
        else $shomare_havale_anbar=1;
		$shomare_havale_anbar=make_pattern($shomare_havale_anbar,5); 
		$sum_karton_h_d=round($difference_tedad*$row['vazn_karton_this'],3);
	    $insert_q=("INSERT INTO havale
                   (code_ostan,code_anbar,shomare_havale_anbar,year,tarikh_havale_anbar,IssuedTime,noe_tahvil_bar,code_kala,tedad_karton_h,deleted,status,sabt_nahayi,signiture_havale,signiture_khorooj,create_form,id_anbargardani,id_anbargardani_det)
                    VALUES(".$row['code_ostan'].",".$row['code_anbar'].",'".$shomare_havale_anbar."',".$row['year'].",'$tarikh_form','$IssuedTime','$noe_tahvil_bar',".$row['code_kala'].",".$difference_tedad.",0,0,1,'$separatesigniture_havale','$separatesigniture_khorooj',2,".$row['id_anbargardani'].",".$row['id_anbargardani_det'].")");
	    $insert_res=mysql_query($insert_q);
		$insert_detail_q=("INSERT INTO havale_detail(id_mojody,code_ostan,code_anbar,shomare_havale_anbar,year,code_ziranbar,code_kala,code_keshvar,code_tolidkonande,
                     sal_tolid_shamsi,mah_tolid_shamsi,rouz_tolid_shamsi,code_karton,vazn_karton_this,code_mandegari,tedad_karton_h_d,sum_karton_h_d,status,create_form,id_anbargardani,id_anbargardani_det)
                     VALUES('$id_mojody',".$row['code_ostan'].",".$row['code_anbar'].",'".$shomare_havale_anbar."',".$row['year'].",".$row['code_ziranbar'].",".$row['code_kala'].",".$row['code_keshvar'].",".$row['code_tolidkonande'].",
					 ".$row['sal_tolid_shamsi'].",".$row['mah_tolid_shamsi'].",".$row['rouz_tolid_shamsi'].",".$row['code_karton'].",".$row['vazn_karton_this'].",".$row['code_mandegari'].",".$difference_tedad.",'$sum_karton_h_d',0,2,".$row['id_anbargardani'].",".$row['id_anbargardani_det'].")");  
        $insert_detail_res=mysql_query($insert_detail_q);
  
       //update mojody	   
	   	 $update_tedad=mojodyKarton($row['code_ostan'],$row['code_anbar'],$row['year'],$row['code_ziranbar'],$row['code_kala'],$row['code_keshvar'],$row['code_tolidkonande'],$row['sal_tolid_shamsi'],$row['mah_tolid_shamsi'],$row['rouz_tolid_shamsi'],$row['code_karton'],$row['code_mandegari']);
	   	 $res_update_mojody=$db->query("UPDATE mojody_kala SET tedad_karton='$update_tedad' WHERE id=".$row['id_mojody']."");  	
	  
	  $insert_kala_res=1; 
	 }
	 ELSE IF($difference_tedad==0)  {$insert_res=1;$insert_detail_res=1;$insert_kala_res=1;$res_update_mojody=1;}
	 /****************وزن ناخالص***********************/
	 //انبارگردانی بیشتر از سیستم
	 IF($difference_nakhales>0)
	 {
	   //ایجاد فرم رسید  
		 $w=$db->get_from_where("shomare_resid","resid","code_ostan=".$row['code_ostan']." and code_anbar=".$row['code_anbar']." AND year=".$row['year']." order by shomare_resid DESC LIMIT 0,1"); 
         if($w) {$shomare_resid=$w; $shomare_resid++;}
         else $shomare_resid=1;
		 $shomare_resid=make_pattern($shomare_resid,5);     
		 $insert_q=("INSERT INTO resid
                    (code_ostan,code_anbar,shomare_resid,year,tarikh_resid,IssuedTime,code_bastebandy,noe_tahvil_bar,vazn_nakhales_r,deleted,status,taeed_nazer,sabt_nahayi,signiture_resid,create_form,id_anbargardani,id_anbargardani_det)
                     VALUES(".$row['code_ostan'].",".$row['code_anbar'].",'".$shomare_resid."',".$row['year'].",'$tarikh_form','$IssuedTime','$code_bastebandy','$noe_tahvil_bar',".$difference_nakhales.",0,0,1,1,'$separatesigniture',2,".$row['id_anbargardani'].",".$row['id_anbargardani_det'].")");
	     $insert_res=mysql_query($insert_q);
		 $insert_detail_q=("INSERT INTO resid_detail(code_ostan,code_anbar,shomare_resid,year,code_kala,code_keshvar,code_tolidkonande,status,create_form,id_anbargardani,id_anbargardani_det)
                            VALUES(".$row['code_ostan'].",".$row['code_anbar'].",'".$shomare_resid."',".$row['year'].",".$row['code_kala'].",".$row['code_keshvar'].",".$row['code_tolidkonande'].",0,2,".$row['id_anbargardani'].",".$row['id_anbargardani_det'].")");  
         $insert_detail_res=mysql_query($insert_detail_q);
		 $insert_kala_q=("INSERT INTO resid_kala_detail 
                        (code_ostan,code_anbar,shomare_resid,year,code_ziranbar,code_kala,code_keshvar,code_tolidkonande,sal_tolid_shamsi,mah_tolid_shamsi,rouz_tolid_shamsi,
					     code_karton,vazn_karton_this,code_mandegari,vazn_nakhales_r_d_sub,status,create_form,id_anbargardani,id_anbargardani_det)
                        VALUES(".$row['code_ostan'].",".$row['code_anbar'].",'".$shomare_resid."',".$row['year'].",".$row['code_ziranbar'].",".$row['code_kala'].",".$row['code_keshvar'].",".$row['code_tolidkonande'].",
					    ".$row['sal_tolid_shamsi'].",".$row['mah_tolid_shamsi'].",".$row['rouz_tolid_shamsi'].",".$row['code_karton'].",".$row['vazn_karton_this'].",".$row['code_mandegari'].",".$difference_nakhales.",0,2,".$row['id_anbargardani'].",".$row['id_anbargardani_det'].")");  
	     $insert_kala_res=mysql_query($insert_kala_q);

		//update mojody	   
	     $update_mojody_nakhales=mojodyNakhales($row['code_ostan'],$row['code_anbar'],$row['year'],$row['code_ziranbar'],$row['code_kala'],$row['code_keshvar'],$row['code_tolidkonande'],$row['sal_tolid_shamsi'],$row['mah_tolid_shamsi'],$row['rouz_tolid_shamsi'],$row['code_karton'],$row['code_mandegari']);
	   	 $res_update_mojody=$db->query("UPDATE mojody_kala SET mojody_nakhales='$update_mojody_nakhales' WHERE id=".$row['id_mojody']."");  	
	 }
	 ELSE IF($difference_nakhales<0)//انبارگردانی کمتر از سیستم
	 {
	   //ایجاد فرم حواله
	   $difference_nakhales=abs($difference_nakhales);
       $difference_nakhales=round($difference_nakhales,3);
	   $w=$db->get_from_where("shomare_havale_anbar","havale","code_ostan=".$row['code_ostan']." and code_anbar=".$row['code_anbar']." AND year=".$row['year']." order by shomare_havale_anbar DESC LIMIT 0,1"); 
       if($w) {$shomare_havale_anbar=$w; $shomare_havale_anbar++;}
       else $shomare_havale_anbar=1;
	   $shomare_havale_anbar=make_pattern($shomare_havale_anbar,5); 
	   $insert_q=("INSERT INTO havale
                   (code_ostan,code_anbar,shomare_havale_anbar,year,tarikh_havale_anbar,IssuedTime,noe_tahvil_bar,code_kala,vazn_nakhales_h,deleted,status,sabt_nahayi,signiture_havale,signiture_khorooj,create_form,id_anbargardani,id_anbargardani_det)
                    VALUES(".$row['code_ostan'].",".$row['code_anbar'].",'".$shomare_havale_anbar."',".$row['year'].",'$tarikh_form','$IssuedTime','$noe_tahvil_bar',".$row['code_kala'].",".$difference_nakhales.",0,0,1,'$separatesigniture_havale','$separatesigniture_khorooj',2,".$row['id_anbargardani'].",".$row['id_anbargardani_det'].")");
	   $insert_res=mysql_query($insert_q);
	   $insert_detail_q=("INSERT INTO havale_detail(id_mojody,code_ostan,code_anbar,shomare_havale_anbar,year,code_ziranbar,code_kala,code_keshvar,code_tolidkonande,
                     sal_tolid_shamsi,mah_tolid_shamsi,rouz_tolid_shamsi,code_karton,vazn_karton_this,code_mandegari,vazn_nakhales_h_d,status,create_form,id_anbargardani,id_anbargardani_det)
                     VALUES('$id_mojody',".$row['code_ostan'].",".$row['code_anbar'].",'".$shomare_havale_anbar."',".$row['year'].",".$row['code_ziranbar'].",".$row['code_kala'].",".$row['code_keshvar'].",".$row['code_tolidkonande'].",
					 ".$row['sal_tolid_shamsi'].",".$row['mah_tolid_shamsi'].",".$row['rouz_tolid_shamsi'].",".$row['code_karton'].",".$row['vazn_karton_this'].",".$row['code_mandegari'].",".$difference_nakhales.",0,2,".$row['id_anbargardani'].",".$row['id_anbargardani_det'].")");  
       $insert_detail_res=mysql_query($insert_detail_q);	
		
   
       //update mojody	   
	     $update_mojody_nakhales=mojodyNakhales($row['code_ostan'],$row['code_anbar'],$row['year'],$row['code_ziranbar'],$row['code_kala'],$row['code_keshvar'],$row['code_tolidkonande'],$row['sal_tolid_shamsi'],$row['mah_tolid_shamsi'],$row['rouz_tolid_shamsi'],$row['code_karton'],$row['code_mandegari']);
	   	 $res_update_mojody=$db->query("UPDATE mojody_kala SET mojody_nakhales='$update_mojody_nakhales' WHERE id=".$row['id_mojody']."");  	
	  $insert_kala_res=1; 
	 }
	 ELSE IF($difference_nakhales==0)  {$insert_res=1;$insert_detail_res=1;$insert_kala_res=1;$res_update_mojody=1;}
	 /****************وزن خالص***********************/
	 //انبارگردانی بیشتر از سیستم
	 IF($difference_khales>0)
	 {
	   //ایجاد فرم رسید  
		 $w=$db->get_from_where("shomare_resid","resid","code_ostan=".$row['code_ostan']." and code_anbar=".$row['code_anbar']." AND year=".$row['year']." order by shomare_resid DESC LIMIT 0,1"); 
         if($w) {$shomare_resid=$w; $shomare_resid++;}
         else $shomare_resid=1;
		 $shomare_resid=make_pattern($shomare_resid,5);     
		 $insert_q=("INSERT INTO resid
                    (code_ostan,code_anbar,shomare_resid,year,tarikh_resid,IssuedTime,code_bastebandy,noe_tahvil_bar,vazn_khales_r,deleted,status,taeed_nazer,sabt_nahayi,signiture_resid,create_form,id_anbargardani,id_anbargardani_det)
                     VALUES(".$row['code_ostan'].",".$row['code_anbar'].",'".$shomare_resid."',".$row['year'].",'$tarikh_form','$IssuedTime','$code_bastebandy','$noe_tahvil_bar',".$difference_khales.",0,0,1,1,'$separatesigniture',2,".$row['id_anbargardani'].",".$row['id_anbargardani_det'].")");
	     $insert_res=mysql_query($insert_q);
		 $insert_detail_q=("INSERT INTO resid_detail(code_ostan,code_anbar,shomare_resid,year,code_kala,code_keshvar,code_tolidkonande,vazn_khales_r_d,Re_GheymatDetailID,status,create_form,id_anbargardani,id_anbargardani_det)
                            VALUES(".$row['code_ostan'].",".$row['code_anbar'].",'".$shomare_resid."',".$row['year'].",".$row['code_kala'].",".$row['code_keshvar'].",".$row['code_tolidkonande'].",".$difference_khales.",'$GheymatDetailID',0,2,".$row['id_anbargardani'].",".$row['id_anbargardani_det'].")");  
         $insert_detail_res=mysql_query($insert_detail_q);
		 $insert_kala_q=("INSERT INTO resid_kala_detail 
                        (code_ostan,code_anbar,shomare_resid,year,code_ziranbar,code_kala,code_keshvar,code_tolidkonande,sal_tolid_shamsi,mah_tolid_shamsi,rouz_tolid_shamsi,
					     code_karton,vazn_karton_this,code_mandegari,vazn_khales_r_d_sub,status,create_form,id_anbargardani,id_anbargardani_det)
                        VALUES(".$row['code_ostan'].",".$row['code_anbar'].",'".$shomare_resid."',".$row['year'].",".$row['code_ziranbar'].",".$row['code_kala'].",".$row['code_keshvar'].",".$row['code_tolidkonande'].",
					    ".$row['sal_tolid_shamsi'].",".$row['mah_tolid_shamsi'].",".$row['rouz_tolid_shamsi'].",".$row['code_karton'].",".$row['vazn_karton_this'].",".$row['code_mandegari'].",".$difference_khales.",0,2,".$row['id_anbargardani'].",".$row['id_anbargardani_det'].")");  
	     $insert_kala_res=mysql_query($insert_kala_q);
    
        //update mojody	   
         $update_mojody_khales=mojodyKhales($row['code_ostan'],$row['code_anbar'],$row['year'],$row['code_ziranbar'],$row['code_kala'],$row['code_keshvar'],$row['code_tolidkonande'],$row['sal_tolid_shamsi'],$row['mah_tolid_shamsi'],$row['rouz_tolid_shamsi'],$row['code_karton'],$row['code_mandegari']);
	   	 $res_update_mojody=$db->query("UPDATE mojody_kala SET mojody_khales='$update_mojody_khales' WHERE id=".$row['id_mojody']."");  	
	 }
	 ELSE IF($difference_khales<0)//انبارگردانی کمتر از سیستم
	 {
	   //ایجاد فرم حواله
	   $difference_khales=abs($difference_khales);
       $difference_khales=round($difference_khales,3);
	   $w=$db->get_from_where("shomare_havale_anbar","havale","code_ostan=".$row['code_ostan']." and code_anbar=".$row['code_anbar']." AND year=".$row['year']." order by shomare_havale_anbar DESC LIMIT 0,1"); 
       if($w) {$shomare_havale_anbar=$w; $shomare_havale_anbar++;}
       else $shomare_havale_anbar=1;
	   $shomare_havale_anbar=make_pattern($shomare_havale_anbar,5); 
	   $insert_q=("INSERT INTO havale
                   (code_ostan,code_anbar,shomare_havale_anbar,year,tarikh_havale_anbar,IssuedTime,noe_tahvil_bar,code_kala,vazn_khales_h,deleted,status,sabt_nahayi,signiture_havale,signiture_khorooj,create_form,id_anbargardani,id_anbargardani_det)
                    VALUES(".$row['code_ostan'].",".$row['code_anbar'].",'".$shomare_havale_anbar."',".$row['year'].",'$tarikh_form','$IssuedTime','$noe_tahvil_bar',".$row['code_kala'].",".$difference_khales.",0,0,1,'$separatesigniture_havale','$separatesigniture_khorooj',2,".$row['id_anbargardani'].",".$row['id_anbargardani_det'].")");
	   $insert_res=mysql_query($insert_q);
	   $insert_detail_q=("INSERT INTO havale_detail(id_mojody,code_ostan,code_anbar,shomare_havale_anbar,year,code_ziranbar,code_kala,code_keshvar,code_tolidkonande,
                     sal_tolid_shamsi,mah_tolid_shamsi,rouz_tolid_shamsi,code_karton,vazn_karton_this,code_mandegari,vazn_khales_h_d,status,create_form,id_anbargardani,id_anbargardani_det)
                     VALUES('$id_mojody',".$row['code_ostan'].",".$row['code_anbar'].",'".$shomare_havale_anbar."',".$row['year'].",".$row['code_ziranbar'].",".$row['code_kala'].",".$row['code_keshvar'].",".$row['code_tolidkonande'].",
					 ".$row['sal_tolid_shamsi'].",".$row['mah_tolid_shamsi'].",".$row['rouz_tolid_shamsi'].",".$row['code_karton'].",".$row['vazn_karton_this'].",".$row['code_mandegari'].",".$difference_khales.",0,2,".$row['id_anbargardani'].",".$row['id_anbargardani_det'].")");  
       $insert_detail_res=mysql_query($insert_detail_q);
		
       //update mojody	   
         $update_mojody_khales=mojodyKhales($row['code_ostan'],$row['code_anbar'],$row['year'],$row['code_ziranbar'],$row['code_kala'],$row['code_keshvar'],$row['code_tolidkonande'],$row['sal_tolid_shamsi'],$row['mah_tolid_shamsi'],$row['rouz_tolid_shamsi'],$row['code_karton'],$row['code_mandegari']);
	   	 $res_update_mojody=$db->query("UPDATE mojody_kala SET mojody_khales='$update_mojody_khales' WHERE id=".$row['id_mojody']."");  	
	  $insert_kala_res=1;
	 }
	 ELSE IF($difference_khales==0)  {$insert_res=1;$insert_detail_res=1;$insert_kala_res=1;$res_update_mojody=1;}
	  
    }//END WHILE
    if($insert_res and $insert_detail_res and $insert_kala_res and $res_update_mojody)
    {
   	   mysql_query("COMMIT");
       echo "<script>alert('اصلاح تغییرات با فرم رسید / حواله با موفقیت انجام شد')</script>"; 
       echo '<script>window.location=\''.$FileName.'?id_anbargardani_='.$id_anbargardani_.'&code_kala_='.$code_kala_.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\' </script>'; 
   	}
   	else  
    {
       mysql_query('ROLLBACK');
       echo "<script>alert('مشکلی در اصلاح به وجود آمده است!')</script>";  
    }
    mysql_query('SET AUTOCOMMIT=1');  
}
//////////////////////////////////////////////////////////////////////////////////////////////
if(isset($eslah_tadil))
{
    mysql_query('SET AUTOCOMMIT=0');//TRANSACTIONشروع 
    mysql_query('START TRANSACTION');
    $q_all="SELECT * From $TableName WHERE id_anbargardani=$id_anbargardani_ AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear'";
	$all = $db->query($q_all);
    while($row=$db->fetch_assoc($all))
    {
	 if($_SESSION["mtActiveYear"]==$yy) $tarikh_barge_tadil=AsLDate($yymmdd);
	 else $tarikh_barge_tadil=$mtEndDateSh;
	 $tedad_sys_first=mojodyKarton($row['code_ostan'],$row['code_anbar'],$row['year'],$row['code_ziranbar'],$row['code_kala'],$row['code_keshvar'],$row['code_tolidkonande'],$row['sal_tolid_shamsi'],$row['mah_tolid_shamsi'],$row['rouz_tolid_shamsi'],$row['code_karton'],$row['code_mandegari']);
	 $mojody_nakhales_sys_first=mojodyNakhales($row['code_ostan'],$row['code_anbar'],$row['year'],$row['code_ziranbar'],$row['code_kala'],$row['code_keshvar'],$row['code_tolidkonande'],$row['sal_tolid_shamsi'],$row['mah_tolid_shamsi'],$row['rouz_tolid_shamsi'],$row['code_karton'],$row['code_mandegari']);
     $mojody_khales_sys_first=mojodyKhales($row['code_ostan'],$row['code_anbar'],$row['year'],$row['code_ziranbar'],$row['code_kala'],$row['code_keshvar'],$row['code_tolidkonande'],$row['sal_tolid_shamsi'],$row['mah_tolid_shamsi'],$row['rouz_tolid_shamsi'],$row['code_karton'],$row['code_mandegari']);
  
	 $difference_tedad_first=$row['tedad_anbargardani']-$tedad_sys_first;
	 $difference_nakhales_first=$row['nakhales_anbargardani']-$mojody_nakhales_sys_first;
	 $difference_khales_first=$row['khales_anbargardani']-$mojody_khales_sys_first;
	 
	 IF($difference_tedad_first!=0)//تعداد
	 {
	  $id_tadil_tedad=$db->get_from_where("id","tadil_mojody","id_anbargardani_det=".$row['id_anbargardani_det']." AND create_form=2 AND tedad_karton_tadil>0 AND deleted=0 AND status=0"); 
	  IF($id_tadil_tedad>0)  $del_res=$db->query("UPDATE tadil_mojody SET status=1 WHERE id=$id_tadil_tedad AND id_anbargardani_det=".$row['id_anbargardani_det']."");
     }
	 IF($difference_nakhales_first!=0)//ناخالص
	 {
	  $id_tadil_nakhales=$db->get_from_where("id","tadil_mojody","id_anbargardani_det=".$row['id_anbargardani_det']." AND create_form=2 AND meghdar_nakhales_tadil>0 AND deleted=0 AND status=0"); 
	  IF($id_tadil_nakhales>0)  $del_res=$db->query("UPDATE tadil_mojody SET status=1 WHERE id=$id_tadil_nakhales AND id_anbargardani_det=".$row['id_anbargardani_det']."");
     }
	 IF($difference_khales_first!=0)//خالص
	 {
	  $id_tadil_khales=$db->get_from_where("id","tadil_mojody","id_anbargardani_det=".$row['id_anbargardani_det']." AND create_form=2 AND meghdar_khales_tadil>0 AND deleted=0 AND status=0"); 
	  IF($id_tadil_khales>0)  $del_res=$db->query("UPDATE tadil_mojody SET status=1 WHERE id=$id_tadil_khales AND id_anbargardani_det=".$row['id_anbargardani_det']."");
     }
	 
	 $tedad_sys=mojodyKarton($row['code_ostan'],$row['code_anbar'],$row['year'],$row['code_ziranbar'],$row['code_kala'],$row['code_keshvar'],$row['code_tolidkonande'],$row['sal_tolid_shamsi'],$row['mah_tolid_shamsi'],$row['rouz_tolid_shamsi'],$row['code_karton'],$row['code_mandegari']);
	 $mojody_nakhales_sys=mojodyNakhales($row['code_ostan'],$row['code_anbar'],$row['year'],$row['code_ziranbar'],$row['code_kala'],$row['code_keshvar'],$row['code_tolidkonande'],$row['sal_tolid_shamsi'],$row['mah_tolid_shamsi'],$row['rouz_tolid_shamsi'],$row['code_karton'],$row['code_mandegari']);
     $mojody_khales_sys=mojodyKhales($row['code_ostan'],$row['code_anbar'],$row['year'],$row['code_ziranbar'],$row['code_kala'],$row['code_keshvar'],$row['code_tolidkonande'],$row['sal_tolid_shamsi'],$row['mah_tolid_shamsi'],$row['rouz_tolid_shamsi'],$row['code_karton'],$row['code_mandegari']);
     
	 $difference_tedad=$row['tedad_anbargardani']-$tedad_sys;
	 $difference_nakhales=$row['nakhales_anbargardani']-$mojody_nakhales_sys;
	 $difference_khales=$row['khales_anbargardani']-$mojody_khales_sys;
     /****************تعداد***********************/
	 //انبارگردانی بیشتر از سیستم
	 IF($difference_tedad>0)
	 {
	   //تعدیل اضافه   
         $w=$db->get_from_where("shomare_barge_tadil","tadil_mojody","code_ostan=".$row['code_ostan']." and code_anbar=".$row['code_anbar']." AND year=".$row['year']." order by shomare_barge_tadil DESC LIMIT 0,1"); 
         if($w) {$shomare_barge_tadil=$w; $shomare_barge_tadil++;}
         else $shomare_barge_tadil=1;
		 $shomare_barge_tadil=make_pattern($shomare_barge_tadil,5);     
		 $sum_karton_tadil=round($difference_tedad*$row['vazn_karton_this'],3);
		 $insert_tadil=("INSERT INTO tadil_mojody(code_ostan,code_anbar,shomare_barge_tadil,year,tarikh_barge_tadil,noe_form_tadil,shomare_mojavez_tadil,code_ziranbar,code_kala,code_keshvar,code_tolidkonande,sal_tolid_shamsi,mah_tolid_shamsi,rouz_tolid_shamsi,code_karton,vazn_karton_this,code_mandegari,noe_tadil,noe_kasry,tedad_karton_tadil,sum_karton_tadil,create_form,id_anbargardani,id_anbargardani_det,status,deleted) 
	                     VALUES (".$row['code_ostan'].",".$row['code_anbar'].",'".$shomare_barge_tadil."',".$row['year'].",'".$tarikh_barge_tadil."',2,'انبارگردانی',".$row['code_ziranbar'].",".$row['code_kala'].",".$row['code_keshvar'].",".$row['code_tolidkonande'].",".$row['sal_tolid_shamsi'].",".$row['mah_tolid_shamsi'].",".$row['rouz_tolid_shamsi'].",".$row['code_karton'].",".$row['vazn_karton_this'].",".$row['code_mandegari'].",1,0,".$difference_tedad.",".$sum_karton_tadil.",2,".$row['id_anbargardani'].",".$row['id_anbargardani_det'].",0,0)");
		 $insert_res=mysql_query($insert_tadil);   
        //update mojody	   
	   	 $update_tedad=mojodyKarton($row['code_ostan'],$row['code_anbar'],$row['year'],$row['code_ziranbar'],$row['code_kala'],$row['code_keshvar'],$row['code_tolidkonande'],$row['sal_tolid_shamsi'],$row['mah_tolid_shamsi'],$row['rouz_tolid_shamsi'],$row['code_karton'],$row['code_mandegari']);
	   	 $res_update_mojody=$db->query("UPDATE mojody_kala SET tedad_karton='$update_tedad_karton' WHERE id=".$row['id_mojody']."");  	

	 }
	 ELSE IF($difference_tedad<0)//انبارگردانی کمتر از سیستم
	 {
	   //تعدیل کسری
	   $difference_tedad=abs($difference_tedad);
		$sum_karton_tadil=round($difference_tedad*$row['vazn_karton_this'],3);
		$w=$db->get_from_where("shomare_barge_tadil","tadil_mojody","code_ostan=".$row['code_ostan']." and code_anbar=".$row['code_anbar']." AND year=".$row['year']." order by shomare_barge_tadil DESC LIMIT 0,1"); 
        if($w) {$shomare_barge_tadil=$w; $shomare_barge_tadil++;}
        else $shomare_barge_tadil=1;
        $shomare_barge_tadil=make_pattern($shomare_barge_tadil,5);
	    $insert_tadil=("INSERT INTO tadil_mojody(code_ostan,code_anbar,shomare_barge_tadil,year,tarikh_barge_tadil,noe_form_tadil,shomare_mojavez_tadil,code_ziranbar,code_kala,code_keshvar,code_tolidkonande,sal_tolid_shamsi,mah_tolid_shamsi,rouz_tolid_shamsi,code_karton,vazn_karton_this,code_mandegari,noe_tadil,noe_kasry,tedad_karton_tadil,sum_karton_tadil,create_form,id_anbargardani,id_anbargardani_det,status,deleted) 
	                   VALUES (".$row['code_ostan'].",".$row['code_anbar'].",'".$shomare_barge_tadil."',".$row['year'].",'".$tarikh_barge_tadil."',2,'انبارگردانی',".$row['code_ziranbar'].",".$row['code_kala'].",".$row['code_keshvar'].",".$row['code_tolidkonande'].",".$row['sal_tolid_shamsi'].",".$row['mah_tolid_shamsi'].",".$row['rouz_tolid_shamsi'].",".$row['code_karton'].",".$row['vazn_karton_this'].",".$row['code_mandegari'].",2,1,".$difference_tedad.",".$sum_karton_tadil.",2,".$row['id_anbargardani'].",".$row['id_anbargardani_det'].",0,0)");
	    $insert_res=mysql_query($insert_tadil);	   
       //update mojody	   
	   	 $update_tedad=mojodyKarton($row['code_ostan'],$row['code_anbar'],$row['year'],$row['code_ziranbar'],$row['code_kala'],$row['code_keshvar'],$row['code_tolidkonande'],$row['sal_tolid_shamsi'],$row['mah_tolid_shamsi'],$row['rouz_tolid_shamsi'],$row['code_karton'],$row['code_mandegari']);
	   	 $res_update_mojody=$db->query("UPDATE mojody_kala SET tedad_karton='$update_tedad_karton' WHERE id=".$row['id_mojody']."");  	
	   
	 }
	 ELSE IF($difference_tedad==0)  {$insert_res=1;$res_update_mojody=1;}
	 /****************وزن ناخالص***********************/
	 //انبارگردانی بیشتر از سیستم
	 IF($difference_nakhales>0)
	 {
	   //تعدیل اضافه   
         $difference_nakhales=round($difference_nakhales,3);
		 $w=$db->get_from_where("shomare_barge_tadil","tadil_mojody","code_ostan=".$row['code_ostan']." and code_anbar=".$row['code_anbar']." AND year=".$row['year']." order by shomare_barge_tadil DESC LIMIT 0,1"); 
         if($w) {$shomare_barge_tadil=$w; $shomare_barge_tadil++;}
         else $shomare_barge_tadil=1;
		 $shomare_barge_tadil=make_pattern($shomare_barge_tadil,5);     
		 $insert_tadil=("INSERT INTO tadil_mojody(code_ostan,code_anbar,shomare_barge_tadil,year,tarikh_barge_tadil,noe_form_tadil,shomare_mojavez_tadil,code_ziranbar,code_kala,code_keshvar,code_tolidkonande,sal_tolid_shamsi,mah_tolid_shamsi,rouz_tolid_shamsi,code_karton,vazn_karton_this,code_mandegari,noe_tadil,noe_kasry,meghdar_nakhales_tadil,create_form,id_anbargardani,id_anbargardani_det,status,deleted) 
	                     VALUES (".$row['code_ostan'].",".$row['code_anbar'].",'".$shomare_barge_tadil."',".$row['year'].",'".$tarikh_barge_tadil."',2,'انبارگردانی',".$row['code_ziranbar'].",".$row['code_kala'].",".$row['code_keshvar'].",".$row['code_tolidkonande'].",".$row['sal_tolid_shamsi'].",".$row['mah_tolid_shamsi'].",".$row['rouz_tolid_shamsi'].",".$row['code_karton'].",".$row['vazn_karton_this'].",".$row['code_mandegari'].",1,0,".$difference_nakhales.",2,".$row['id_anbargardani'].",".$row['id_anbargardani_det'].",0,0)");
		 
		 $insert_res=mysql_query($insert_tadil);   
        //update mojody	   
	     $update_mojody_nakhales=mojodyNakhales($row['code_ostan'],$row['code_anbar'],$row['year'],$row['code_ziranbar'],$row['code_kala'],$row['code_keshvar'],$row['code_tolidkonande'],$row['sal_tolid_shamsi'],$row['mah_tolid_shamsi'],$row['rouz_tolid_shamsi'],$row['code_karton'],$row['code_mandegari']);
	   	 $res_update_mojody=$db->query("UPDATE mojody_kala SET mojody_nakhales='$update_mojody_nakhales' WHERE id=".$row['id_mojody']."");  	

	 }
	 ELSE IF($difference_nakhales<0)//انبارگردانی کمتر از سیستم
	 {
	   //تعدیل کسری
	   $difference_nakhales=abs($difference_nakhales);
        $difference_nakhales=round($difference_nakhales,3);
		$w=$db->get_from_where("shomare_barge_tadil","tadil_mojody","code_ostan=".$row['code_ostan']." and code_anbar=".$row['code_anbar']." AND year=".$row['year']." order by shomare_barge_tadil DESC LIMIT 0,1"); 
        if($w) {$shomare_barge_tadil=$w; $shomare_barge_tadil++;}
        else $shomare_barge_tadil=1;
        $shomare_barge_tadil=make_pattern($shomare_barge_tadil,5);
	    $insert_tadil=("INSERT INTO tadil_mojody(code_ostan,code_anbar,shomare_barge_tadil,year,tarikh_barge_tadil,noe_form_tadil,shomare_mojavez_tadil,code_ziranbar,code_kala,code_keshvar,code_tolidkonande,sal_tolid_shamsi,mah_tolid_shamsi,rouz_tolid_shamsi,code_karton,vazn_karton_this,code_mandegari,noe_tadil,noe_kasry,meghdar_nakhales_tadil,create_form,id_anbargardani,id_anbargardani_det,status,deleted) 
	                   VALUES (".$row['code_ostan'].",".$row['code_anbar'].",'".$shomare_barge_tadil."',".$row['year'].",'".$tarikh_barge_tadil."',2,'انبارگردانی',".$row['code_ziranbar'].",".$row['code_kala'].",".$row['code_keshvar'].",".$row['code_tolidkonande'].",".$row['sal_tolid_shamsi'].",".$row['mah_tolid_shamsi'].",".$row['rouz_tolid_shamsi'].",".$row['code_karton'].",".$row['vazn_karton_this'].",".$row['code_mandegari'].",2,1,".$difference_nakhales.",2,".$row['id_anbargardani'].",".$row['id_anbargardani_det'].",0,0)");
	    $insert_res=mysql_query($insert_tadil);	   
       //update mojody	   
	     $update_mojody_nakhales=mojodyNakhales($row['code_ostan'],$row['code_anbar'],$row['year'],$row['code_ziranbar'],$row['code_kala'],$row['code_keshvar'],$row['code_tolidkonande'],$row['sal_tolid_shamsi'],$row['mah_tolid_shamsi'],$row['rouz_tolid_shamsi'],$row['code_karton'],$row['code_mandegari']);
	   	 $res_update_mojody=$db->query("UPDATE mojody_kala SET mojody_nakhales='$update_mojody_nakhales' WHERE id=".$row['id_mojody']."");  	
	   
	 }
	 ELSE IF($difference_nakhales==0)  {$insert_res=1;$res_update_mojody=1;}
	 /****************وزن خالص***********************/
	 //انبارگردانی بیشتر از سیستم
	 IF($difference_khales>0)
	 {
	   //تعدیل اضافه   
         $difference_khales=round($difference_khales,3);
		 $w=$db->get_from_where("shomare_barge_tadil","tadil_mojody","code_ostan=".$row['code_ostan']." and code_anbar=".$row['code_anbar']." AND year=".$row['year']." order by shomare_barge_tadil DESC LIMIT 0,1"); 
         if($w) {$shomare_barge_tadil=$w; $shomare_barge_tadil++;}
         else $shomare_barge_tadil=1;
		 $shomare_barge_tadil=make_pattern($shomare_barge_tadil,5);     
		 $insert_tadil=("INSERT INTO tadil_mojody(code_ostan,code_anbar,shomare_barge_tadil,year,tarikh_barge_tadil,noe_form_tadil,shomare_mojavez_tadil,code_ziranbar,code_kala,code_keshvar,code_tolidkonande,sal_tolid_shamsi,mah_tolid_shamsi,rouz_tolid_shamsi,code_karton,vazn_karton_this,code_mandegari,noe_tadil,noe_kasry,meghdar_khales_tadil,create_form,id_anbargardani,id_anbargardani_det,status,deleted) 
	                     VALUES (".$row['code_ostan'].",".$row['code_anbar'].",'".$shomare_barge_tadil."',".$row['year'].",'".$tarikh_barge_tadil."',2,'انبارگردانی',".$row['code_ziranbar'].",".$row['code_kala'].",".$row['code_keshvar'].",".$row['code_tolidkonande'].",".$row['sal_tolid_shamsi'].",".$row['mah_tolid_shamsi'].",".$row['rouz_tolid_shamsi'].",".$row['code_karton'].",".$row['vazn_karton_this'].",".$row['code_mandegari'].",1,0,".$difference_khales.",2,".$row['id_anbargardani'].",".$row['id_anbargardani_det'].",0,0)");
		 $insert_res=mysql_query($insert_tadil);   
        //update mojody	   
         $update_mojody_khales=mojodyKhales($row['code_ostan'],$row['code_anbar'],$row['year'],$row['code_ziranbar'],$row['code_kala'],$row['code_keshvar'],$row['code_tolidkonande'],$row['sal_tolid_shamsi'],$row['mah_tolid_shamsi'],$row['rouz_tolid_shamsi'],$row['code_karton'],$row['code_mandegari']);
	   	 $res_update_mojody=$db->query("UPDATE mojody_kala SET mojody_khales='$update_mojody_khales' WHERE id=".$row['id_mojody']."");  	
	 }
	 ELSE IF($difference_khales<0)//انبارگردانی کمتر از سیستم
	 {
	   //تعدیل کسری
	   $difference_khales=abs($difference_khales);
        $difference_khales=round($difference_khales,3);
		$w=$db->get_from_where("shomare_barge_tadil","tadil_mojody","code_ostan=".$row['code_ostan']." and code_anbar=".$row['code_anbar']." AND year=".$row['year']." order by shomare_barge_tadil DESC LIMIT 0,1"); 
        if($w) {$shomare_barge_tadil=$w; $shomare_barge_tadil++;}
        else $shomare_barge_tadil=1;
        $shomare_barge_tadil=make_pattern($shomare_barge_tadil,5);
	    $insert_tadil=("INSERT INTO tadil_mojody(code_ostan,code_anbar,shomare_barge_tadil,year,tarikh_barge_tadil,noe_form_tadil,shomare_mojavez_tadil,code_ziranbar,code_kala,code_keshvar,code_tolidkonande,sal_tolid_shamsi,mah_tolid_shamsi,rouz_tolid_shamsi,code_karton,vazn_karton_this,code_mandegari,noe_tadil,noe_kasry,meghdar_khales_tadil,create_form,id_anbargardani,id_anbargardani_det,status,deleted) 
	                   VALUES (".$row['code_ostan'].",".$row['code_anbar'].",'".$shomare_barge_tadil."',".$row['year'].",'".$tarikh_barge_tadil."',2,'انبارگردانی',".$row['code_ziranbar'].",".$row['code_kala'].",".$row['code_keshvar'].",".$row['code_tolidkonande'].",".$row['sal_tolid_shamsi'].",".$row['mah_tolid_shamsi'].",".$row['rouz_tolid_shamsi'].",".$row['code_karton'].",".$row['vazn_karton_this'].",".$row['code_mandegari'].",2,1,".$difference_khales.",2,".$row['id_anbargardani'].",".$row['id_anbargardani_det'].",0,0)");
	    $insert_res=mysql_query($insert_tadil);	   
       //update mojody	   
         $update_mojody_khales=mojodyKhales($row['code_ostan'],$row['code_anbar'],$row['year'],$row['code_ziranbar'],$row['code_kala'],$row['code_keshvar'],$row['code_tolidkonande'],$row['sal_tolid_shamsi'],$row['mah_tolid_shamsi'],$row['rouz_tolid_shamsi'],$row['code_karton'],$row['code_mandegari']);
	   	 $res_update_mojody=$db->query("UPDATE mojody_kala SET mojody_khales='$update_mojody_khales' WHERE id=".$row['id_mojody']."");  	
	 }
	 ELSE IF($difference_khales==0)  {$insert_res=1;$res_update_mojody=1;}
	  
    }//END WHILE
    if($insert_res and $res_update_mojody)
    {
   	   mysql_query("COMMIT");
       echo "<script>alert('اصلاح تغییرات با فرم تعدیل موجودی انجام شد')</script>"; 
       echo '<script>window.location=\''.$FileName.'?id_anbargardani_='.$id_anbargardani_.'&code_kala_='.$code_kala_.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\' </script>'; 
   	}
   	else  
    {
       mysql_query('ROLLBACK');
       echo "<script>alert('مشکلی در اصلاح به وجود آمده است!')</script>";  
    }
    mysql_query('SET AUTOCOMMIT=1');  
}
//////////////////////////////////////////////////////////////////////////////////////////////
if(isset($transfer))
{
    mysql_query('SET AUTOCOMMIT=0');//TRANSACTIONشروع 
    mysql_query('START TRANSACTION');
	$q_all="SELECT * From $TableName WHERE id_anbargardani=$id_anbargardani_ AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear'";
	$all = $db->query($q_all);
	while($row=$db->fetch_assoc($all))
    {
	 $sal_maghsad=$mtActiveYear+1;
	 $exist_mojody=$db->get_from_where("count(*)","mojody_kala","code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']." AND code_ziranbar=".$row['code_ziranbar']." AND year='$sal_maghsad' AND code_kala='".$row['code_kala']."' AND code_keshvar='".$row['code_keshvar']."' AND code_tolidkonande='".$row['code_tolidkonande']."' AND sal_tolid_shamsi='".$row['sal_tolid_shamsi']."' AND mah_tolid_shamsi='".$row['mah_tolid_shamsi']."' AND rouz_tolid_shamsi='".$row['rouz_tolid_shamsi']."' AND code_karton='".$row['code_karton']."' AND code_mandegari='".$row['code_mandegari']."' AND deleted=0");	
	 if($exist_mojody>0)//اگر در جدول موجودی کالا وجود دارد
	 {
	   //محاسبه کارتنها در سال جدید
	   $jameKartonVarede=$db->get_from_where("SUM(tedad_karton_r_d_sub)","resid_kala_detail","code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']." AND code_ziranbar=".$row['code_ziranbar']." AND year='$sal_maghsad' AND code_kala=".$row['code_kala']." AND code_keshvar=".$row['code_keshvar']." AND code_tolidkonande=".$row['code_tolidkonande']." AND sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND code_karton=".$row['code_karton']." AND code_mandegari='".$row['code_mandegari']."' AND resid_deleted=0 AND status=0");     
	   $jameKartonSadere=$db->get_from_where("SUM(tedad_karton_h_d)","havale_detail","code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']." AND code_ziranbar=".$row['code_ziranbar']." AND year='$sal_maghsad' AND code_kala=".$row['code_kala']." AND code_keshvar=".$row['code_keshvar']." AND code_tolidkonande=".$row['code_tolidkonande']." AND sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND code_karton=".$row['code_karton']." AND code_mandegari='".$row['code_mandegari']."' AND havale_deleted=0 AND status=0");     
	   $kartonTadilEzafe=$db->get_from_where("SUM(tedad_karton_tadil)","tadil_mojody","noe_tadil=1 AND code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']." AND code_ziranbar=".$row['code_ziranbar']." AND year='$sal_maghsad' AND code_kala=".$row['code_kala']." AND code_keshvar=".$row['code_keshvar']." AND code_tolidkonande=".$row['code_tolidkonande']." AND sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND code_karton=".$row['code_karton']." AND code_mandegari='".$row['code_mandegari']."' AND deleted=0");     
	   $kartonTadilKasry=$db->get_from_where("SUM(tedad_karton_tadil)","tadil_mojody","noe_tadil=2 AND code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']." AND code_ziranbar=".$row['code_ziranbar']." AND year='$sal_maghsad' AND code_kala=".$row['code_kala']." AND code_keshvar=".$row['code_keshvar']." AND code_tolidkonande=".$row['code_tolidkonande']." AND sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND code_karton=".$row['code_karton']." AND code_mandegari='".$row['code_mandegari']."' AND deleted=0");     
	   $karton_maghsad=$row['tedad_anbargardani']+$jameKartonVarede-$jameKartonSadere+$kartonTadilEzafe-$kartonTadilKasry;
	   IF($row['code_kala']==50) {$tedad_shane_aval=$row['shane_anbargardani']; $shane_maghsad=$karton_maghsad*$_SESSION["mtShane"];}
	   ELSE IF($row['code_kala']==54){$tedad_shane_aval=$row['shane_anbargardani']; $shane_maghsad=$karton_maghsad*$_SESSION["mtShane_dakheli"];}
	   ELSE {$tedad_shane_aval=0; $shane_maghsad=0;}
	   //محاسبه موجودی ناخالص در سال جدید
	   $jameNaKhalesVarede=$db->get_from_where("SUM(vazn_nakhales_r_d_sub)","resid_kala_detail","code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']." AND code_ziranbar=".$row['code_ziranbar']." AND year='$sal_maghsad' AND code_kala=".$row['code_kala']." AND code_keshvar=".$row['code_keshvar']." AND code_tolidkonande=".$row['code_tolidkonande']." AND sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND code_karton=".$row['code_karton']." AND code_mandegari='".$row['code_mandegari']."' AND resid_deleted=0 AND status=0");    
	   $jameNaKhalesSadere=$db->get_from_where("SUM(vazn_nakhales_h_d)","havale_detail","code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']." AND code_ziranbar=".$row['code_ziranbar']." AND year='$sal_maghsad' AND code_kala=".$row['code_kala']." AND code_keshvar=".$row['code_keshvar']." AND code_tolidkonande=".$row['code_tolidkonande']." AND sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND code_karton=".$row['code_karton']." AND code_mandegari='".$row['code_mandegari']."' AND havale_deleted=0 AND status=0");     
	   $nakhalesTadilEzafe=$db->get_from_where("SUM(meghdar_nakhales_tadil)","tadil_mojody","noe_tadil=1 AND code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']." AND code_ziranbar=".$row['code_ziranbar']." AND year='$sal_maghsad' AND code_kala=".$row['code_kala']." AND code_keshvar=".$row['code_keshvar']." AND code_tolidkonande=".$row['code_tolidkonande']." AND sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND code_karton=".$row['code_karton']." AND code_mandegari='".$row['code_mandegari']."' AND deleted=0");     
	   $nakhalesTadilKasry=$db->get_from_where("SUM(meghdar_nakhales_tadil)","tadil_mojody","noe_tadil=2 AND code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']." AND code_ziranbar=".$row['code_ziranbar']." AND year='$sal_maghsad' AND code_kala=".$row['code_kala']." AND code_keshvar=".$row['code_keshvar']." AND code_tolidkonande=".$row['code_tolidkonande']." AND sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND code_karton=".$row['code_karton']." AND code_mandegari='".$row['code_mandegari']."' AND deleted=0");     
	   $nakhales_maghsad=$row['nakhales_anbargardani']+$jameNaKhalesVarede-$jameNaKhalesSadere+$nakhalesTadilEzafe-$nakhalesTadilKasry;
	   //محاسبه موجودی خالص در سال جدید
	   $jameKhalesVadere=$db->get_from_where("SUM(vazn_khales_r_d_sub)","resid_kala_detail","code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']." AND code_ziranbar=".$row['code_ziranbar']." AND year='$sal_maghsad' AND code_kala=".$row['code_kala']." AND code_keshvar=".$row['code_keshvar']." AND code_tolidkonande=".$row['code_tolidkonande']." AND sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND code_karton=".$row['code_karton']." AND code_mandegari='".$row['code_mandegari']."' AND resid_deleted=0 AND status=0");     
	   $jameKhalesSadere=$db->get_from_where("SUM(vazn_khales_h_d)","havale_detail","code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']." AND code_ziranbar=".$row['code_ziranbar']." AND year='$sal_maghsad' AND code_kala=".$row['code_kala']." AND code_keshvar=".$row['code_keshvar']." AND code_tolidkonande=".$row['code_tolidkonande']." AND sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND code_karton=".$row['code_karton']." AND code_mandegari='".$row['code_mandegari']."' AND havale_deleted=0 AND status=0");     
	   $khalesTadilEzafe=$db->get_from_where("SUM(meghdar_khales_tadil)","tadil_mojody","noe_tadil=1 AND code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']." AND code_ziranbar=".$row['code_ziranbar']." AND year='$sal_maghsad' AND code_kala=".$row['code_kala']." AND code_keshvar=".$row['code_keshvar']." AND code_tolidkonande=".$row['code_tolidkonande']." AND sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND code_karton=".$row['code_karton']." AND code_mandegari='".$row['code_mandegari']."' AND deleted=0");     
	   $khalesTadilKasry=$db->get_from_where("SUM(meghdar_khales_tadil)","tadil_mojody","noe_tadil=2 AND code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']." AND code_ziranbar=".$row['code_ziranbar']." AND year='$sal_maghsad' AND code_kala=".$row['code_kala']." AND code_keshvar=".$row['code_keshvar']." AND code_tolidkonande=".$row['code_tolidkonande']." AND sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND code_karton=".$row['code_karton']." AND code_mandegari='".$row['code_mandegari']."' AND deleted=0");     
	   $khales_maghsad=$row['khales_anbargardani']+$jameKhalesVadere-$jameKhalesSadere+$khalesTadilEzafe-$khalesTadilKasry;
	   $update_q=("UPDATE mojody_kala SET sum_karton_this=".$row['sum_karton_anbargardani'].",tedad_karton_aval=".$row['tedad_anbargardani'].",tedad_shane_aval=".$tedad_shane_aval.",mojody_nakhales_aval=".$row['nakhales_anbargardani'].",mojody_khales_aval=".$row['khales_anbargardani'].",tedad_karton=".$karton_maghsad.",tedad_shane=".$shane_maghsad.",mojody_nakhales=".$nakhales_maghsad.",mojody_khales=".$khales_maghsad." WHERE code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']." AND code_ziranbar=".$row['code_ziranbar']." AND year='$sal_maghsad' AND code_kala=".$row['code_kala']." AND code_keshvar=".$row['code_keshvar']." AND code_tolidkonande=".$row['code_tolidkonande']." AND sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND code_karton=".$row['code_karton']." AND code_mandegari='".$row['code_mandegari']."' AND deleted=0");
	   //$update_q=("UPDATE mojody_kala SET sum_karton_this=".$row['sum_karton_anbargardani'].",tedad_karton_aval=".$row['tedad_anbargardani'].",mojody_nakhales_aval=".$row['nakhales_anbargardani'].",mojody_khales_aval=".$row['khales_anbargardani'].",tedad_karton=".$karton_maghsad.",mojody_nakhales=".$nakhales_maghsad.",mojody_khales=".$khales_maghsad." WHERE code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']." AND code_ziranbar=".$row['code_ziranbar']." AND year='$sal_maghsad' AND code_kala=".$row['code_kala']." AND code_keshvar=".$row['code_keshvar']." AND code_tolidkonande=".$row['code_tolidkonande']." AND sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND code_karton=".$row['code_karton']." AND deleted=0");
	   $update_res=mysql_query($update_q);
	 }
	 else if(($row['tedad_anbargardani']!=0)or($row['nakhales_anbargardani']!=0)or($row['khales_anbargardani']!=0))
	 {
	   //تبدیل تاریخ شمسی به میلادی برای نگهداری در دیتابیس
       $milady=jalali_to_gregorian($row['sal_tolid_shamsi'],$row['mah_tolid_shamsi'],$row['rouz_tolid_shamsi']);
       $sal_tolid_milady=$milady[0];$mah_tolid_milady=$milady[1];$rouz_tolid_milady=$milady[2];
	   $code_bastebandy=$db->get_from_where("code_bastebandy","kala","code_kala='".$row['code_kala']."'");
	   $insert_q=("INSERT INTO mojody_kala(code_ostan,code_anbar,year,code_ziranbar,code_kala,code_keshvar,code_tolidkonande,sal_tolid_shamsi,mah_tolid_shamsi,rouz_tolid_shamsi,sal_tolid_milady,mah_tolid_milady,rouz_tolid_milady,code_bastebandy,code_karton,vazn_karton_this,code_mandegari,sum_karton_this,tedad_karton_aval,tedad_shane_aval,mojody_nakhales_aval,mojody_khales_aval,tedad_karton,tedad_shane,mojody_nakhales,mojody_khales,deleted)
                   VALUES (".$row['code_ostan'].",".$row['code_anbar'].",'$sal_maghsad',".$row['code_ziranbar'].",".$row['code_kala'].",".$row['code_keshvar'].",".$row['code_tolidkonande'].",".$row['sal_tolid_shamsi'].",".$row['mah_tolid_shamsi'].",".$row['rouz_tolid_shamsi'].",".$sal_tolid_milady.",".$mah_tolid_milady.",".$rouz_tolid_milady.",".$code_bastebandy.",".$row['code_karton'].",".$row['vazn_karton_this'].",'".$row['code_mandegari']."',".$row['sum_karton_anbargardani'].",".$row['tedad_anbargardani'].",".$row['shane_anbargardani'].",".$row['nakhales_anbargardani'].",".$row['khales_anbargardani'].",".$row['tedad_anbargardani'].",".$row['shane_anbargardani'].",".$row['nakhales_anbargardani'].",".$row['khales_anbargardani'].",0)");
	   $insert_res=mysql_query($insert_q);
	   // $code_bastebandy=$db->get_from_where("code_bastebandy","kala","code_kala='".$row['code_kala']."'");
	   // $insert_q=("INSERT INTO mojody_kala(code_ostan,code_anbar,year,code_ziranbar,code_kala,code_keshvar,code_tolidkonande,sal_tolid_shamsi,mah_tolid_shamsi,rouz_tolid_shamsi,code_bastebandy,code_karton,vazn_karton_this,sum_karton_this,tedad_karton_aval,mojody_nakhales_aval,mojody_khales_aval,tedad_karton,mojody_nakhales,mojody_khales,deleted)
                   // VALUES (".$row['code_ostan'].",".$row['code_anbar'].",'$sal_maghsad',".$row['code_ziranbar'].",".$row['code_kala'].",".$row['code_keshvar'].",".$row['code_tolidkonande'].",".$row['sal_tolid_shamsi'].",".$row['mah_tolid_shamsi'].",".$row['rouz_tolid_shamsi'].",".$code_bastebandy.",".$row['code_karton'].",".$row['vazn_karton_this'].",".$row['sum_karton_anbargardani'].",".$row['tedad_anbargardani'].",".$row['nakhales_anbargardani'].",".$row['khales_anbargardani'].",".$row['tedad_anbargardani'].",".$row['nakhales_anbargardani'].",".$row['khales_anbargardani'].",0)");
	   // $insert_res=mysql_query($insert_q);
	 }
    }
	//log
	$max_id=$db->get_from_where("Max(id_anbargardani_det)","$TableName","id_anbargardani=$id_anbargardani_"); 
    $log_i=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$max_id','اصلاح موجودی اول دوره سال بعد در فرم انبارگردانی',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')");
    if(($insert_res)or($update_res))
    {
   	 mysql_query("COMMIT");
   	 if(strlen($mt_gl_code_ostan)==1) $code_a=make_pattern($mt_gl_code_ostan,2); else $code_a=$mt_gl_code_ostan;
       echo "<script>alert('انتقال موجِودی از سال ".$mtActiveYear." به سال ".$sal_maghsad." با موفقیت انجام شد ')</script>"; 
       echo "<script>window.location='anbargardani.php'</script>";
	   //echo '<script>window.location=\''.$FileName.'?id_anbargardani_='.$id_anbargardani_.'&code_kala_='.$code_kala_.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\' </script>'; 
   	}
   	else  
    {
       mysql_query('ROLLBACK');
       echo "<script>alert('مشکلی در انتقال موجودی به وجود آمده است!')</script>";  
    }
    mysql_query('SET AUTOCOMMIT=1');	  
}
//////////////////////////////////////////////////////////////////////////////////////////////
if(isset($mojavez))
{
    mysql_query('SET AUTOCOMMIT=0');//TRANSACTIONشروع 
    mysql_query('START TRANSACTION');
    $q_all="SELECT * From $TableName WHERE id_anbargardani=$id_anbargardani_ AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear'";
	$all = $db->query($q_all);
    while($row=$db->fetch_assoc($all))
    {
     $sal_maghsad=$mtActiveYear+1;
	 //موجودی کالا با  تابع
     $tedad_karton=mojodyKarton($row['code_ostan'],$row['code_anbar'],$row['year'],$row['code_ziranbar'],$row['code_kala'],$row['code_keshvar'],$row['code_tolidkonande'],$row['sal_tolid_shamsi'],$row['mah_tolid_shamsi'],$row['rouz_tolid_shamsi'],$row['code_karton'],$row['code_mandegari']);
     $mojody_nakhales=mojodyNakhales($row['code_ostan'],$row['code_anbar'],$row['year'],$row['code_ziranbar'],$row['code_kala'],$row['code_keshvar'],$row['code_tolidkonande'],$row['sal_tolid_shamsi'],$row['mah_tolid_shamsi'],$row['rouz_tolid_shamsi'],$row['code_karton'],$row['code_mandegari']);
     $mojody_khales=mojodyKhales($row['code_ostan'],$row['code_anbar'],$row['year'],$row['code_ziranbar'],$row['code_kala'],$row['code_keshvar'],$row['code_tolidkonande'],$row['sal_tolid_shamsi'],$row['mah_tolid_shamsi'],$row['rouz_tolid_shamsi'],$row['code_karton'],$row['code_mandegari']);  
  	 $shomare_anbargardani=$db->get_from_where("shomare_anbargardani","mt_anbargardani","id_anbargardani=$id_anbargardani_"); 
     if(strlen($row['code_ostan'])==1) $code_a=make_pattern($row['code_ostan'],2);
     else $code_a=$row['code_ostan'];
	 $shomare_nameh=$code_a.$row['code_anbar'].$shomare_anbargardani;
	 $tarikh_nameh=$db->get_from_where("start_from","mt_docs","year=$sal_maghsad"); 
	 $id_mojody=$db->get_from_where("id","mojody_kala","code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']."  AND year='$sal_maghsad' AND code_ziranbar=".$row['code_ziranbar']." AND code_kala=".$row['code_kala']." AND code_keshvar=".$row['code_keshvar']." AND code_tolidkonande=".$row['code_tolidkonande']." AND sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND code_karton=".$row['code_karton']." AND code_mandegari='".$row['code_mandegari']."' AND deleted=0");	
	 $exist_mojavez=$db->get_from_where("count(*)","mojavez_oftokasry","code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']."  AND year='$sal_maghsad' AND code_ziranbar=".$row['code_ziranbar']." AND code_kala=".$row['code_kala']." AND code_keshvar=".$row['code_keshvar']." AND code_tolidkonande=".$row['code_tolidkonande']." AND sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND code_karton=".$row['code_karton']." AND code_mandegari='".$row['code_mandegari']."' AND deleted=0");	
     if($exist_mojavez>0)//اگر در جدول مجوز وجود دارد
	 {
	   //کسری
	   IF(($row['tedad_anbargardani']<$tedad_karton)AND($row['nakhales_anbargardani']<$mojody_nakhales)AND($row['khales_anbargardani']<$mojody_khales))
       {  
         $tedad_oftokasry=$tedad_karton-$row['tedad_anbargardani'];
         $sum_karton_oftokasry=$tedad_oftokasry*$row['vazn_karton_this'];
		 $meghdar_nakhales_oftokasry=$mojody_nakhales-$row['nakhales_anbargardani'];
         $meghdar_khales_oftokasry=$mojody_khales-$row['khales_anbargardani'];
	     IF($row['code_kala']==50){$tedad_shane_oftokasry=$tedad_oftokasry*$_SESSION["mtShane"];}
		 ELSE IF($row['code_kala']==54)$tedad_shane_oftokasry=$tedad_oftokasry*$_SESSION["mtShane_dakheli"];
		 ELSE $tedad_shane_oftokasry=0;
		 $update_q_moj=("UPDATE mojavez_oftokasry SET tarikh_nameh='$tarikh_nameh',noe_oftokasry=2,tedad_oftokasry='$tedad_oftokasry',sum_karton_oftokasry='$sum_karton_oftokasry',meghdar_nakhales_oftokasry='$meghdar_nakhales_oftokasry',meghdar_khales_oftokasry='$meghdar_khales_oftokasry',tedad_shane_oftokasry='$tedad_shane_oftokasry'
		  WHERE code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']." AND code_ziranbar=".$row['code_ziranbar']." AND year='$sal_maghsad' AND code_kala=".$row['code_kala']."
		  AND code_keshvar=".$row['code_keshvar']." AND code_tolidkonande=".$row['code_tolidkonande']." AND sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND code_karton=".$row['code_karton']."
		  AND code_mandegari='".$row['code_mandegari']."' AND deleted=0");
	     $update_res_moj=mysql_query($update_q_moj);
	   }	  
	   //اضافه
	   ELSE IF(($tedad_karton<$row['tedad_anbargardani'])AND($mojody_nakhales<$row['nakhales_anbargardani'])AND($mojody_khales<$row['khales_anbargardani']))
	   {  
         $tedad_oftokasry=$row['tedad_anbargardani']-$tedad_karton;
         $sum_karton_oftokasry=$tedad_oftokasry*$row['vazn_karton_this'];
		 $meghdar_nakhales_oftokasry=$row['nakhales_anbargardani']-$mojody_nakhales;
         $meghdar_khales_oftokasry=$row['khales_anbargardani']-$mojody_khales;
	     IF($row['code_kala']==50){$tedad_shane_oftokasry=$tedad_oftokasry*$_SESSION["mtShane"];}
		 ELSE IF($row['code_kala']==54)$tedad_shane_oftokasry=$tedad_oftokasry*$_SESSION["mtShane_dakheli"];
		 ELSE $tedad_shane_oftokasry=0;
	     $update_q_moj=("UPDATE mojavez_oftokasry SET tarikh_nameh='$tarikh_nameh',noe_oftokasry=1,tedad_oftokasry='$tedad_oftokasry',sum_karton_oftokasry='$sum_karton_oftokasry',meghdar_nakhales_oftokasry='$meghdar_nakhales_oftokasry',meghdar_khales_oftokasry='$meghdar_khales_oftokasry',tedad_shane_oftokasry='$tedad_shane_oftokasry'
		  WHERE code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']." AND code_ziranbar=".$row['code_ziranbar']." AND year='$sal_maghsad' AND code_kala=".$row['code_kala']."
		  AND code_keshvar=".$row['code_keshvar']." AND code_tolidkonande=".$row['code_tolidkonande']." AND sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND code_karton=".$row['code_karton']."
		  AND code_mandegari='".$row['code_mandegari']."' AND deleted=0");
	     $update_res_moj=mysql_query($update_q_moj);
	   } 
	 }
	 else
	 {
	  //مراحل ثبت رکورد در طرح در کمیسیون افت و کسری
	   //کسری
	   IF(($row['tedad_anbargardani']<$tedad_karton)AND($row['nakhales_anbargardani']<$mojody_nakhales)AND($row['khales_anbargardani']<$mojody_khales))
       {
         $tedad_oftokasry=$tedad_karton-$row['tedad_anbargardani'];
         $sum_karton_oftokasry=$tedad_oftokasry*$row['vazn_karton_this'];
		 $meghdar_nakhales_oftokasry=$mojody_nakhales-$row['nakhales_anbargardani'];
         $meghdar_khales_oftokasry=$mojody_khales-$row['khales_anbargardani'];
	     IF($row['code_kala']==50){$tedad_shane_oftokasry=$tedad_oftokasry*$_SESSION["mtShane"];}
		 ELSE IF($row['code_kala']==54)$tedad_shane_oftokasry=$tedad_oftokasry*$_SESSION["mtShane_dakheli"];
		 ELSE $tedad_shane_oftokasry=0;
	     $insert_q_moj=("INSERT INTO mojavez_oftokasry
                        (code_ostan,code_anbar,year,shomare_nameh,tarikh_nameh,shomare_mojavez,tarikh_mojavez,id_mojody,code_ziranbar,code_kala,code_keshvar,code_tolidkonande,sal_tolid_shamsi,mah_tolid_shamsi,rouz_tolid_shamsi,code_karton,vazn_karton_this,code_mandegari,noe_oftokasry,tedad_oftokasry,sum_karton_oftokasry,meghdar_nakhales_oftokasry,meghdar_khales_oftokasry,tedad_shane_oftokasry,deleted)
                         VALUES
	   		            (".$row['code_ostan'].",".$row['code_anbar'].",'$sal_maghsad',TRIM('$shomare_nameh'),'$tarikh_nameh','$shomare_mojavez','$tarikh_mojavez','$id_mojody',".$row['code_ziranbar'].",".$row['code_kala'].",".$row['code_keshvar'].",".$row['code_tolidkonande'].",".$row['sal_tolid_shamsi'].",".$row['mah_tolid_shamsi'].",".$row['rouz_tolid_shamsi'].",".$row['code_karton'].",".$row['vazn_karton_this'].",'".$row['code_mandegari']."','2','$tedad_oftokasry','$sum_karton_oftokasry','$meghdar_nakhales_oftokasry','$meghdar_khales_oftokasry','$tedad_shane_oftokasry',0)"); 		 
         $insert_res_moj=mysql_query($insert_q_moj);
	   }	  
	   //اضافه
	   ELSE IF(($tedad_karton<$row['tedad_anbargardani'])AND($mojody_nakhales<$row['nakhales_anbargardani'])AND($mojody_khales<$row['khales_anbargardani']))
	   { 
         $tedad_oftokasry=$row['tedad_anbargardani']-$tedad_karton;
         $sum_karton_oftokasry=$tedad_oftokasry*$row['vazn_karton_this'];
		 $meghdar_nakhales_oftokasry=$row['nakhales_anbargardani']-$mojody_nakhales;
         $meghdar_khales_oftokasry=$row['khales_anbargardani']-$mojody_khales;
	     IF($row['code_kala']==50){$tedad_shane_oftokasry=$tedad_oftokasry*$_SESSION["mtShane"];}
		 ELSE IF($row['code_kala']==54)$tedad_shane_oftokasry=$tedad_oftokasry*$_SESSION["mtShane_dakheli"];
		 ELSE $tedad_shane_oftokasry=0;
	     $insert_q_moj=("INSERT INTO mojavez_oftokasry
                        (code_ostan,code_anbar,year,shomare_nameh,tarikh_nameh,shomare_mojavez,tarikh_mojavez,id_mojody,code_ziranbar,code_kala,code_keshvar,code_tolidkonande,sal_tolid_shamsi,mah_tolid_shamsi,rouz_tolid_shamsi,code_karton,vazn_karton_this,code_mandegari,noe_oftokasry,tedad_oftokasry,sum_karton_oftokasry,meghdar_nakhales_oftokasry,meghdar_khales_oftokasry,tedad_shane_oftokasry,deleted)
                         VALUES
	   		            (".$row['code_ostan'].",".$row['code_anbar'].",'$sal_maghsad',TRIM('$shomare_nameh'),'$tarikh_nameh','$shomare_mojavez','$tarikh_mojavez','$id_mojody',".$row['code_ziranbar'].",".$row['code_kala'].",".$row['code_keshvar'].",".$row['code_tolidkonande'].",".$row['sal_tolid_shamsi'].",".$row['mah_tolid_shamsi'].",".$row['rouz_tolid_shamsi'].",".$row['code_karton'].",".$row['vazn_karton_this'].",'".$row['code_mandegari']."','1','$tedad_oftokasry','$sum_karton_oftokasry','$meghdar_nakhales_oftokasry','$meghdar_khales_oftokasry','$tedad_shane_oftokasry',0)"); 		 
         $insert_res_moj=mysql_query($insert_q_moj);
	   }	 
	 }
    }
	if(($insert_res_moj)or($update_res_moj))
    {
   	 mysql_query("COMMIT");
   	 if(strlen($mt_gl_code_ostan)==1) $code_a=make_pattern($mt_gl_code_ostan,2); else $code_a=$mt_gl_code_ostan;
       echo "<script>alert('عملیات با موفقیت انجام شد')</script>"; 
       echo '<script>window.location=\''.$FileName.'?id_anbargardani_='.$id_anbargardani_.'&code_kala_='.$code_kala_.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\' </script>'; 
   	}
   	else  
    {
       mysql_query('ROLLBACK');
       echo "<script>alert('مشکلی در انتقال به وجود آمده است!')</script>";  
    }
    mysql_query('SET AUTOCOMMIT=1');	  
}
//////////////////////////////////////////////////////////////////////////////////////////////
if(isset($transfer_befor))
{
    mysql_query('SET AUTOCOMMIT=0');//TRANSACTIONشروع 
    mysql_query('START TRANSACTION');
    $q_mojody="SELECT * From mojody_kala WHERE code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0";
	$allMojody = $db->query($q_mojody);
    //$sum_karton_this_new=0;
	while($row=$db->fetch_assoc($allMojody))
    {
	 $sal_maghsad=$mtActiveYear+1;
	 $tedad_karton_sal_ghabl=mojodyKarton($row['code_ostan'],$row['code_anbar'],$row['year'],$row['code_ziranbar'],$row['code_kala'],$row['code_keshvar'],$row['code_tolidkonande'],$row['sal_tolid_shamsi'],$row['mah_tolid_shamsi'],$row['rouz_tolid_shamsi'],$row['code_karton'],$row['code_mandegari']);
     $mojody_nakhales_sal_ghabl=mojodyNakhales($row['code_ostan'],$row['code_anbar'],$row['year'],$row['code_ziranbar'],$row['code_kala'],$row['code_keshvar'],$row['code_tolidkonande'],$row['sal_tolid_shamsi'],$row['mah_tolid_shamsi'],$row['rouz_tolid_shamsi'],$row['code_karton'],$row['code_mandegari']);
     $mojody_khales_sal_ghabl=mojodyKhales($row['code_ostan'],$row['code_anbar'],$row['year'],$row['code_ziranbar'],$row['code_kala'],$row['code_keshvar'],$row['code_tolidkonande'],$row['sal_tolid_shamsi'],$row['mah_tolid_shamsi'],$row['rouz_tolid_shamsi'],$row['code_karton'],$row['code_mandegari']);	 
	 $sum_karton_this_new=round(floatval($row['vazn_karton_this']*$tedad_karton_sal_ghabl),3);
	  
	 $exist_mojody=$db->get_from_where("count(*)","mojody_kala","code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']." AND code_ziranbar=".$row['code_ziranbar']." AND year='$sal_maghsad' AND code_kala=".$row['code_kala']." AND code_keshvar=".$row['code_keshvar']." AND code_tolidkonande=".$row['code_tolidkonande']." AND sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND code_karton=".$row['code_karton']." AND code_mandegari='".$row['code_mandegari']."'  AND deleted=0");	
	 if($exist_mojody>0)//اگر در جدول موجودی کالا وجود دارد
	 {
	   //محاسبه کارتنها در سال جدید
	   $jameKartonVarede=$db->get_from_where("SUM(tedad_karton_r_d_sub)","resid_kala_detail","code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']." AND code_ziranbar=".$row['code_ziranbar']." AND year='$sal_maghsad' AND code_kala=".$row['code_kala']." AND code_keshvar=".$row['code_keshvar']." AND code_tolidkonande=".$row['code_tolidkonande']." AND sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND code_karton=".$row['code_karton']." AND code_mandegari='".$row['code_mandegari']."' AND resid_deleted=0 AND status=0");     
	   $jameKartonSadere=$db->get_from_where("SUM(tedad_karton_h_d)","havale_detail","code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']." AND code_ziranbar=".$row['code_ziranbar']." AND year='$sal_maghsad' AND code_kala=".$row['code_kala']." AND code_keshvar=".$row['code_keshvar']." AND code_tolidkonande=".$row['code_tolidkonande']." AND sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND code_karton=".$row['code_karton']." AND code_mandegari='".$row['code_mandegari']."' AND havale_deleted=0 AND status=0");     
	   $kartonTadilEzafe=$db->get_from_where("SUM(tedad_karton_tadil)","tadil_mojody","noe_tadil=1 AND code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']." AND code_ziranbar=".$row['code_ziranbar']." AND year='$sal_maghsad' AND code_kala=".$row['code_kala']." AND code_keshvar=".$row['code_keshvar']." AND code_tolidkonande=".$row['code_tolidkonande']." AND sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND code_karton=".$row['code_karton']." AND code_mandegari='".$row['code_mandegari']."' AND deleted=0");     
	   $kartonTadilKasry=$db->get_from_where("SUM(tedad_karton_tadil)","tadil_mojody","noe_tadil=2 AND code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']." AND code_ziranbar=".$row['code_ziranbar']." AND year='$sal_maghsad' AND code_kala=".$row['code_kala']." AND code_keshvar=".$row['code_keshvar']." AND code_tolidkonande=".$row['code_tolidkonande']." AND sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND code_karton=".$row['code_karton']." AND code_mandegari='".$row['code_mandegari']."' AND deleted=0");     
	   $karton_maghsad=$tedad_karton_sal_ghabl+$jameKartonVarede-$jameKartonSadere+$kartonTadilEzafe-$kartonTadilKasry;
	   //محاسبه موجودی ناخالص در سال جدید
	   $jameNaKhalesVarede=$db->get_from_where("SUM(vazn_nakhales_r_d_sub)","resid_kala_detail","code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']." AND code_ziranbar=".$row['code_ziranbar']." AND year='$sal_maghsad' AND code_kala=".$row['code_kala']." AND code_keshvar=".$row['code_keshvar']." AND code_tolidkonande=".$row['code_tolidkonande']." AND sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND code_karton=".$row['code_karton']." AND code_mandegari='".$row['code_mandegari']."' AND resid_deleted=0 AND status=0");    
	   $jameNaKhalesSadere=$db->get_from_where("SUM(vazn_nakhales_h_d)","havale_detail","code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']." AND code_ziranbar=".$row['code_ziranbar']." AND year='$sal_maghsad' AND code_kala=".$row['code_kala']." AND code_keshvar=".$row['code_keshvar']." AND code_tolidkonande=".$row['code_tolidkonande']." AND sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND code_karton=".$row['code_karton']." AND code_mandegari='".$row['code_mandegari']."' AND havale_deleted=0 AND status=0");     
	   $nakhalesTadilEzafe=$db->get_from_where("SUM(meghdar_nakhales_tadil)","tadil_mojody","noe_tadil=1 AND code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']." AND code_ziranbar=".$row['code_ziranbar']." AND year='$sal_maghsad' AND code_kala=".$row['code_kala']." AND code_keshvar=".$row['code_keshvar']." AND code_tolidkonande=".$row['code_tolidkonande']." AND sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND code_karton=".$row['code_karton']." AND code_mandegari='".$row['code_mandegari']."' AND deleted=0");     
	   $nakhalesTadilKasry=$db->get_from_where("SUM(meghdar_nakhales_tadil)","tadil_mojody","noe_tadil=2 AND code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']." AND code_ziranbar=".$row['code_ziranbar']." AND year='$sal_maghsad' AND code_kala=".$row['code_kala']." AND code_keshvar=".$row['code_keshvar']." AND code_tolidkonande=".$row['code_tolidkonande']." AND sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND code_karton=".$row['code_karton']." AND code_mandegari='".$row['code_mandegari']."' AND deleted=0");     
	   $nakhales_maghsad=$mojody_nakhales_sal_ghabl+$jameNaKhalesVarede-$jameNaKhalesSadere+$nakhalesTadilEzafe-$nakhalesTadilKasry;
	   //محاسبه موجودی خالص در سال جدید
	   $jameKhalesVadere=$db->get_from_where("SUM(vazn_khales_r_d_sub)","resid_kala_detail","code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']." AND code_ziranbar=".$row['code_ziranbar']." AND year='$sal_maghsad' AND code_kala=".$row['code_kala']." AND code_keshvar=".$row['code_keshvar']." AND code_tolidkonande=".$row['code_tolidkonande']." AND sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND code_karton=".$row['code_karton']." AND code_mandegari='".$row['code_mandegari']."' AND resid_deleted=0 AND status=0");     
	   $jameKhalesSadere=$db->get_from_where("SUM(vazn_khales_h_d)","havale_detail","code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']." AND code_ziranbar=".$row['code_ziranbar']." AND year='$sal_maghsad' AND code_kala=".$row['code_kala']." AND code_keshvar=".$row['code_keshvar']." AND code_tolidkonande=".$row['code_tolidkonande']." AND sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND code_karton=".$row['code_karton']." AND code_mandegari='".$row['code_mandegari']."' AND havale_deleted=0 AND status=0");     
	   $khalesTadilEzafe=$db->get_from_where("SUM(meghdar_khales_tadil)","tadil_mojody","noe_tadil=1 AND code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']." AND code_ziranbar=".$row['code_ziranbar']." AND year='$sal_maghsad' AND code_kala=".$row['code_kala']." AND code_keshvar=".$row['code_keshvar']." AND code_tolidkonande=".$row['code_tolidkonande']." AND sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND code_karton=".$row['code_karton']." AND code_mandegari='".$row['code_mandegari']."' AND deleted=0");     
	   $khalesTadilKasry=$db->get_from_where("SUM(meghdar_khales_tadil)","tadil_mojody","noe_tadil=2 AND code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']." AND code_ziranbar=".$row['code_ziranbar']." AND year='$sal_maghsad' AND code_kala=".$row['code_kala']." AND code_keshvar=".$row['code_keshvar']." AND code_tolidkonande=".$row['code_tolidkonande']." AND sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND code_karton=".$row['code_karton']." AND code_mandegari='".$row['code_mandegari']."' AND deleted=0");     
	   $khales_maghsad=$mojody_khales_sal_ghabl+$jameKhalesVadere-$jameKhalesSadere+$khalesTadilEzafe-$khalesTadilKasry;
	   //$mojody_maghsad=$row['mojody']+$jameVarede-$jameSadere+$meghdarTadil_Ezafe-$meghdarTadil_Kasry;
	   $update_q=("UPDATE mojody_kala SET sum_karton_this=$sum_karton_this_new,tedad_karton_aval=".$tedad_karton_sal_ghabl.",mojody_nakhales_aval=".$mojody_nakhales_sal_ghabl.",mojody_khales_aval=".$mojody_khales_sal_ghabl.",tedad_karton=".$karton_maghsad.",mojody_nakhales=".$nakhales_maghsad.",mojody_khales=".$khales_maghsad." WHERE code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']." AND code_ziranbar=".$row['code_ziranbar']." AND year='$sal_maghsad' AND code_kala=".$row['code_kala']." AND code_keshvar=".$row['code_keshvar']." AND code_tolidkonande=".$row['code_tolidkonande']." AND sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND code_karton=".$row['code_karton']." AND code_mandegari='".$row['code_mandegari']."' AND deleted=0");
	   $update_res=mysql_query($update_q);
	 }
	 else if(($tedad_karton_sal_ghabl!=0)or($mojody_nakhales_sal_ghabl!=0)or($mojody_khales_sal_ghabl!=0))
	 {
	   $insert_q=("INSERT INTO mojody_kala(code_ostan,code_anbar,year,code_ziranbar,code_kala,code_keshvar,code_tolidkonande,sal_tolid_shamsi,mah_tolid_shamsi,rouz_tolid_shamsi,sal_tolid_milady,mah_tolid_milady,rouz_tolid_milady,code_bastebandy,code_karton,vazn_karton_this,code_mandegari,sum_karton_this,tedad_karton_aval,mojody_nakhales_aval,mojody_khales_aval,tedad_karton,mojody_nakhales,mojody_khales,deleted)
                   VALUES (".$row['code_ostan'].",".$row['code_anbar'].",'$sal_maghsad',".$row['code_ziranbar'].",".$row['code_kala'].",".$row['code_keshvar'].",".$row['code_tolidkonande'].",".$row['sal_tolid_shamsi'].",".$row['mah_tolid_shamsi'].",".$row['rouz_tolid_shamsi'].",".$row['sal_tolid_milady'].",".$row['mah_tolid_milady'].",".$row['rouz_tolid_milady'].",".$row['code_bastebandy'].",".$row['code_karton'].",".$row['vazn_karton_this'].",'".$row['code_mandegari']."','$sum_karton_this_new',".$tedad_karton_sal_ghabl.",".$mojody_nakhales_sal_ghabl.",".$mojody_khales_sal_ghabl.",".$tedad_karton_sal_ghabl.",".$mojody_nakhales_sal_ghabl.",".$mojody_khales_sal_ghabl.",".$row['deleted'].")");
	   $insert_res=mysql_query($insert_q);
	 }
    }
    if(($insert_res)or($update_res))
    {
   	 mysql_query("COMMIT");
   	 if(strlen($mt_gl_code_ostan)==1) $code_a=make_pattern($mt_gl_code_ostan,2); else $code_a=$mt_gl_code_ostan;
       echo "<script>alert('انتقال موجِودی از سال ".$sal_mabda." به سال ".$sal_maghsad." با موفقیت انجام شد ')</script>"; 
       echo '<script>window.location=\''.$FileName.'?id_anbargardani_='.$id_anbargardani_.'&code_kala_='.$code_kala_.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\' </script>'; 
   	}
   	else  
    {
       mysql_query('ROLLBACK');
       echo "<script>alert('مشکلی در انتقال موجودی به وجود آمده است!')</script>";  
    }
    mysql_query('SET AUTOCOMMIT=1');	  
}
//////////////////////////////////////////////////////////////////////////////
if(isset($eslah_mandegari))
{
	$q_all="SELECT * From $TableName WHERE id_anbargardani=$id_anbargardani_ AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear'";
	//echo $q_all;
	$all = $db->query($q_all);
	while($row=$db->fetch_assoc($all))
    {
	 $code_mandegari=$db->get_from_where("code_mandegari","mojody_kala","code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']." AND code_ziranbar=".$row['code_ziranbar']." AND year='$mtActiveYear' AND code_kala=".$row['code_kala']." AND code_keshvar=".$row['code_keshvar']." AND code_tolidkonande=".$row['code_tolidkonande']." AND sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND code_karton=".$row['code_karton']." AND deleted=0");	
	 $update_q=("UPDATE $TableName SET code_mandegari='$code_mandegari'  WHERE id_anbargardani_det=".$row['id_anbargardani_det']." AND code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']." AND year='$mtActiveYear' AND code_kala=".$row['code_kala']." AND code_keshvar=".$row['code_keshvar']." AND code_tolidkonande=".$row['code_tolidkonande']." AND sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND code_karton=".$row['code_karton']." ");
	 $update_res=mysql_query($update_q);
    }
    if($update_res)
    {
       echo "<script>alert('success ')</script>"; 
       echo "<script>window.location='anbargardani.php'</script>";
   	}
  
}	
?>