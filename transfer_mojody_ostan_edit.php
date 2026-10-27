<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="transfer_mojody_ostan_edit.php";
echo'
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>اصلاح موجودی سال بعد استان</title>
<link href="styles.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="functions.js"></script>
<link type="text/css" href="styles/jquery-ui-1.8.14.css" rel="stylesheet" />
<script type="text/javascript" src="scripts/jquery-1.6.2.min.js"></script>
</head>';
/***************************************** MAIN*****************************************/
$sal_mabda_val=$mtActiveYear;
$sal_maghsad_val=$mtActiveYear+1;
echo'
<body onload="document.myform.sal_mabda.focus();">
<form method="POST" name="myform">
<div align="center">
<table width="700px" align="center" cellpadding="0" cellspacing="0">
 <tr>
  <td height="100%">
   <div style="float:right;width:100%;margin:0px;height:100%;overflow:auto;overflow-x:hidden;">
   <table width="600px" border="0" align="center" cellpadding="0" cellspacing="0" >
    <tr><td colspan="4" height="20px">&nbsp;</td></tr>
	<tr><td colspan="4" class="title">اصلاح موجودی استان '.$mt_gl_name_ostan.'</td></tr>';
	IF(!($mt_gl_code_ostan) OR $mt_gl_code_ostan==-1)  
	echo'<tr class="tr1"><td colspan="4">لطفاً استان و سردخانه مورد نظر خود را انتخاب کنید !</td></tr>';
	echo'
	<tr class="tr1">	
     <td align="left"> از سال :&nbsp;</td><td align="right"><input type="text" class="textboxme2 textbox50" maxlength="4" name="sal_mabda" placeholder=" 1401" onkeypress="return isNumber(event)" value="'.$sal_mabda_val.'" /></td>
     <td align="left"> به سال :&nbsp;</td><td align="right"><input type="text" class="textboxme2 textbox50" maxlength="4" name="sal_maghsad" placeholder=" 1402" onkeypress="return isNumber(event)" value="'.$sal_maghsad_val.'" /></td>
	</tr>';
	//IF($mtActiveYear==$yy)  echo'<tr class="tr1"><td colspan="4" height="40px">سال بعد هنوز موجود نیست</td></tr> ';
    //ELSE 
		echo'<tr class="tr1"><td colspan="4" height="40px"><input class="buttonme" type="submit" name="transfer" value="اصلاح موجودی استان"></td></tr> ';
    echo'
	<tr class="footer"><td colspan="4">&nbsp;</td></tr>
   </table>
   </div>
  </td>
 </tr>
 <tr>
  <td height="100%">
   <div style="float:right;width:100%;margin:0px;height:100%;overflow:auto;overflow-x:hidden;">
   <table width="600px" border="0" align="center" cellpadding="0" cellspacing="0" >
    <tr><td colspan="4" height="20px">&nbsp;</td></tr>
	<tr><td colspan="4" class="title">اصلاح موجودی استان '.$mt_gl_name_ostan.' از فرم انبارگردانی</td></tr>';
    IF(!($mt_gl_code_ostan) OR $mt_gl_code_ostan==-1)  
	echo'<tr class="tr1"><td colspan="4">لطفاً استان و سردخانه مورد نظر خود را انتخاب کنید !</td></tr>';
	echo'
	<tr class="tr1">	
     <td align="left"> از سال :&nbsp;</td><td align="right"><input type="text" class="textboxme2 textbox50" maxlength="4" name="sal_mabda" placeholder=" 1401" onkeypress="return isNumber(event)" value="'.$sal_mabda_val.'" /></td>
     <td align="left"> به سال :&nbsp;</td><td align="right"><input type="text" class="textboxme2 textbox50" maxlength="4" name="sal_maghsad" placeholder=" 1402" onkeypress="return isNumber(event)" value="'.$sal_maghsad_val.'" /></td>
	</tr>';
    //IF($mtActiveYear==$yy)  echo'<tr class="tr1"><td colspan="4" height="40px">سال بعد هنوز موجود نیست</td></tr> ';
    //ELSE
		echo'<tr class="tr1"><td colspan="4" height="40px"><input class="buttonme" type="submit" name="transfer_anbargardani" value="اصلاح موجودی استان از فرم انبارگردانی"></td></tr> ';
    echo'
	<tr class="footer"><td colspan="4">&nbsp;</td></tr>
   </table>
   </div>
  </td>
 </tr> 
</table>
</div>';
/************اجازه براي ذخيره اطلاعات************/
function isPermitSave($gl_c_o,$sal1,$sal2)
{
 $flag=false;
 if(!($gl_c_o) or $gl_c_o==-1)//اگر سشن استان خالی باشد
 {   
   $flag=false;
   echo"<script> alert('لطفاً استان مورد نظر خود را انتخاب نمایید!')</script>";
   return $flag;
 }
 else $flag=true;
 if ((!justNumber($sal1)) or (strlen($sal1)<4) or (strlen($sal1)>4) or($sal1<1400))//بررسی از سال
 {
   $flag=false;
   echo"<script>alert('فیلد از سال نامعتبر است')</script>";
   return $flag;
 }
 else $flag=true;
 if ((!justNumber($sal2)) or (strlen($sal2)<4) or (strlen($sal2)>4) or($sal2<1400))//بررسی تا سال
 {
   $flag=false;
   echo"<script>alert('فیلد تا سال نامعتبر است')</script>";
   return $flag;
 }
 else $flag=true;
 if ($sal1==$sal2)//
 {
   $flag=false;
   echo"<script>alert('هر دو سال یکسان وارد شده است')</script>";
   return $flag;
 }
 else $flag=true;
return $flag;
}
//////////////////////////////////////////////////////////////////////////////////////////////
if(isset($transfer))
{
  if(isPermitSave($mt_gl_code_ostan,$sal_mabda,$sal_maghsad))				  
  {
    mysql_query('SET AUTOCOMMIT=0');//TRANSACTIONشروع 
    mysql_query('START TRANSACTION');
    $q_mojody="SELECT * From mojody_kala WHERE code_ostan='$mt_gl_code_ostan' AND year='$sal_mabda' AND deleted=0";
	$allMojody = $db->query($q_mojody);
    //$sum_karton_this_new=0;
	while($row=$db->fetch_assoc($allMojody))
    {
	 $tedad_karton_sal_ghabl=mojodyKarton($row['code_ostan'],$row['code_anbar'],$row['year'],$row['code_ziranbar'],$row['code_kala'],$row['code_keshvar'],$row['code_tolidkonande'],$row['sal_tolid_shamsi'],$row['mah_tolid_shamsi'],$row['rouz_tolid_shamsi'],$row['code_karton'],$row['code_mandegari']);
     $mojody_nakhales_sal_ghabl=mojodyNakhales($row['code_ostan'],$row['code_anbar'],$row['year'],$row['code_ziranbar'],$row['code_kala'],$row['code_keshvar'],$row['code_tolidkonande'],$row['sal_tolid_shamsi'],$row['mah_tolid_shamsi'],$row['rouz_tolid_shamsi'],$row['code_karton'],$row['code_mandegari']);
     $mojody_khales_sal_ghabl=mojodyKhales($row['code_ostan'],$row['code_anbar'],$row['year'],$row['code_ziranbar'],$row['code_kala'],$row['code_keshvar'],$row['code_tolidkonande'],$row['sal_tolid_shamsi'],$row['mah_tolid_shamsi'],$row['rouz_tolid_shamsi'],$row['code_karton'],$row['code_mandegari']);	 
	 $sum_karton_this_new=round(floatval($row['vazn_karton_this']*$tedad_karton_sal_ghabl),3);
	 IF($row['code_kala']==50) $tedad_shane_sal_ghabl=$tedad_karton_sal_ghabl*$_SESSION["mtShane"];
	 ELSE IF($row['code_kala']==54) $tedad_shane_sal_ghabl=$tedad_karton_sal_ghabl*$_SESSION["mtShane_dakheli"];
	 ELSE $tedad_shane_sal_ghabl=0; 
	 $exist_mojody=$db->get_from_where("count(*)","mojody_kala","code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']." AND code_ziranbar=".$row['code_ziranbar']." AND year='$sal_maghsad' AND code_kala=".$row['code_kala']." AND code_keshvar=".$row['code_keshvar']." AND code_tolidkonande=".$row['code_tolidkonande']." AND sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND code_karton=".$row['code_karton']." AND code_mandegari='".$row['code_mandegari']."' AND deleted=0");	
	 if($exist_mojody>0)//اگر در جدول موجودی کالا وجود دارد
	 {
	   //محاسبه کارتنها در سال جدید
	   $jameKartonVarede=$db->get_from_where("SUM(tedad_karton_r_d_sub)","resid_kala_detail","code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']." AND code_ziranbar=".$row['code_ziranbar']." AND year='$sal_maghsad' AND code_kala=".$row['code_kala']." AND code_keshvar=".$row['code_keshvar']." AND code_tolidkonande=".$row['code_tolidkonande']." AND sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND code_karton=".$row['code_karton']." AND code_mandegari='".$row['code_mandegari']."' AND resid_deleted=0 AND status=0");     
	   $jameKartonSadere=$db->get_from_where("SUM(tedad_karton_h_d)","havale_detail","code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']." AND code_ziranbar=".$row['code_ziranbar']." AND year='$sal_maghsad' AND code_kala=".$row['code_kala']." AND code_keshvar=".$row['code_keshvar']." AND code_tolidkonande=".$row['code_tolidkonande']." AND sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND code_karton=".$row['code_karton']." AND code_mandegari='".$row['code_mandegari']."' AND havale_deleted=0 AND status=0");     
	   $kartonTadilEzafe=$db->get_from_where("SUM(tedad_karton_tadil)","tadil_mojody","noe_tadil=1 AND code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']." AND code_ziranbar=".$row['code_ziranbar']." AND year='$sal_maghsad' AND code_kala=".$row['code_kala']." AND code_keshvar=".$row['code_keshvar']." AND code_tolidkonande=".$row['code_tolidkonande']." AND sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND code_karton=".$row['code_karton']." AND code_mandegari='".$row['code_mandegari']."' AND deleted=0");     
	   $kartonTadilKasry=$db->get_from_where("SUM(tedad_karton_tadil)","tadil_mojody","noe_tadil=2 AND code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']." AND code_ziranbar=".$row['code_ziranbar']." AND year='$sal_maghsad' AND code_kala=".$row['code_kala']." AND code_keshvar=".$row['code_keshvar']." AND code_tolidkonande=".$row['code_tolidkonande']." AND sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND code_karton=".$row['code_karton']." AND code_mandegari='".$row['code_mandegari']."' AND deleted=0");     
	   $karton_maghsad=$tedad_karton_sal_ghabl+$jameKartonVarede-$jameKartonSadere+$kartonTadilEzafe-$kartonTadilKasry;
	   IF($row['code_kala']==50) $shane_maghsad=$karton_maghsad*$_SESSION["mtShane"];
	   ELSE IF($row['code_kala']==54) $shane_maghsad=$karton_maghsad*$_SESSION["mtShane_dakheli"];
	   ELSE $shane_maghsad=0;
	   //محاسبه موجودی ناخالص در سال جدید
	   $jameNaKhalesVarede=$db->get_from_where("SUM(vazn_nakhales_r_d_sub)","resid_kala_detail","code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']." AND code_ziranbar=".$row['code_ziranbar']." AND year='$sal_maghsad' AND code_kala=".$row['code_kala']." AND code_keshvar=".$row['code_keshvar']." AND code_tolidkonande=".$row['code_tolidkonande']." AND sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND code_karton=".$row['code_karton']." AND code_mandegari='".$row['code_mandegari']."' AND resid_deleted=0 AND status=0");    
	   $jameNaKhalesSadere=$db->get_from_where("SUM(vazn_nakhales_h_d)","havale_detail","code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']." AND code_ziranbar=".$row['code_ziranbar']." AND year='$sal_maghsad' AND code_kala=".$row['code_kala']." AND code_keshvar=".$row['code_keshvar']." AND code_tolidkonande=".$row['code_tolidkonande']." AND sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND code_karton=".$row['code_karton']." AND code_mandegari='".$row['code_mandegari']."' AND havale_deleted=0 AND status=0");     
	   $nakhalesTadilEzafe=$db->get_from_where("SUM(meghdar_nakhales_tadil)","tadil_mojody","noe_tadil=1 AND code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']." AND code_ziranbar=".$row['code_ziranbar']." AND year='$sal_maghsad' AND code_kala=".$row['code_kala']." AND code_keshvar=".$row['code_keshvar']." AND code_tolidkonande=".$row['code_tolidkonande']." AND sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND code_karton=".$row['code_karton']." AND code_mandegari='".$row['code_mandegari']."' AND deleted=0");     
	   $nakhalesTadilKasry=$db->get_from_where("SUM(meghdar_nakhales_tadil)","tadil_mojody","noe_tadil=2 AND code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']." AND code_ziranbar=".$row['code_ziranbar']." AND year='$sal_maghsad' AND code_kala=".$row['code_kala']." AND code_keshvar=".$row['code_keshvar']." AND code_tolidkonande=".$row['code_tolidkonande']." AND sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND code_karton=".$row['code_karton']." AND code_mandegari='".$row['code_mandegari']."' AND deleted=0");     
	   $nakhales_maghsad=$mojody_nakhales_sal_ghabl+$jameNaKhalesVarede-$jameNaKhalesSadere+$nakhalesTadilEzafe-$nakhalesTadilKasry;
	   //محاسبه موجودی خالص در سال جدید
	   $jameKhalesVadere=$db->get_from_where("SUM(vazn_khales_r_d_sub)","resid_kala_detail","code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']." AND code_ziranbar=".$row['code_ziranbar']." AND year='$sal_maghsad' AND code_kala=".$row['code_kala']." AND code_keshvar=".$row['code_keshvar']." AND code_tolidkonande=".$row['code_tolidkonande']." AND sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND code_karton=".$row['code_karton']."  AND code_mandegari='".$row['code_mandegari']."' AND resid_deleted=0 AND status=0");     
	   $jameKhalesSadere=$db->get_from_where("SUM(vazn_khales_h_d)","havale_detail","code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']." AND code_ziranbar=".$row['code_ziranbar']." AND year='$sal_maghsad' AND code_kala=".$row['code_kala']." AND code_keshvar=".$row['code_keshvar']." AND code_tolidkonande=".$row['code_tolidkonande']." AND sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND code_karton=".$row['code_karton']." AND code_mandegari='".$row['code_mandegari']."' AND havale_deleted=0 AND status=0");     
	   $khalesTadilEzafe=$db->get_from_where("SUM(meghdar_khales_tadil)","tadil_mojody","noe_tadil=1 AND code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']." AND code_ziranbar=".$row['code_ziranbar']." AND year='$sal_maghsad' AND code_kala=".$row['code_kala']." AND code_keshvar=".$row['code_keshvar']." AND code_tolidkonande=".$row['code_tolidkonande']." AND sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND code_karton=".$row['code_karton']." AND code_mandegari='".$row['code_mandegari']."' AND deleted=0");     
	   $khalesTadilKasry=$db->get_from_where("SUM(meghdar_khales_tadil)","tadil_mojody","noe_tadil=2 AND code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']." AND code_ziranbar=".$row['code_ziranbar']." AND year='$sal_maghsad' AND code_kala=".$row['code_kala']." AND code_keshvar=".$row['code_keshvar']." AND code_tolidkonande=".$row['code_tolidkonande']." AND sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND code_karton=".$row['code_karton']." AND code_mandegari='".$row['code_mandegari']."' AND deleted=0");     
	   $khales_maghsad=$mojody_khales_sal_ghabl+$jameKhalesVadere-$jameKhalesSadere+$khalesTadilEzafe-$khalesTadilKasry;
	   //$mojody_maghsad=$row['mojody']+$jameVarede-$jameSadere+$meghdarTadil_Ezafe-$meghdarTadil_Kasry;
	   $update_q=("UPDATE mojody_kala SET sum_karton_this=$sum_karton_this_new,tedad_karton_aval=".$tedad_karton_sal_ghabl.",mojody_nakhales_aval=".$mojody_nakhales_sal_ghabl.",mojody_khales_aval=".$mojody_khales_sal_ghabl.",tedad_shane_aval=".$tedad_shane_sal_ghabl.",tedad_karton=".$karton_maghsad.",mojody_nakhales=".$nakhales_maghsad.",mojody_khales=".$khales_maghsad.",tedad_shane=".$shane_maghsad." WHERE code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']." AND code_ziranbar=".$row['code_ziranbar']." AND year='$sal_maghsad' AND code_kala=".$row['code_kala']." AND code_keshvar=".$row['code_keshvar']." AND code_tolidkonande=".$row['code_tolidkonande']." AND sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND code_karton=".$row['code_karton']." AND code_mandegari='".$row['code_mandegari']."' AND deleted=0");
	   $update_res=mysql_query($update_q);
	 }
	 else if(($tedad_karton_sal_ghabl!=0)or($mojody_nakhales_sal_ghabl!=0)or($mojody_khales_sal_ghabl!=0))
	 {
	   $insert_q=("INSERT INTO mojody_kala(code_ostan,code_anbar,year,code_ziranbar,code_kala,code_keshvar,code_tolidkonande,sal_tolid_shamsi,mah_tolid_shamsi,rouz_tolid_shamsi,sal_tolid_milady,mah_tolid_milady,rouz_tolid_milady,code_bastebandy,code_karton,vazn_karton_this,code_mandegari,sum_karton_this,tedad_karton_aval,mojody_nakhales_aval,mojody_khales_aval,tedad_shane_aval,tedad_karton,mojody_nakhales,mojody_khales,tedad_shane,deleted)
                   VALUES (".$row['code_ostan'].",".$row['code_anbar'].",'$sal_maghsad',".$row['code_ziranbar'].",".$row['code_kala'].",".$row['code_keshvar'].",".$row['code_tolidkonande'].",".$row['sal_tolid_shamsi'].",".$row['mah_tolid_shamsi'].",".$row['rouz_tolid_shamsi'].",".$row['sal_tolid_milady'].",".$row['mah_tolid_milady'].",".$row['rouz_tolid_milady'].",".$row['code_bastebandy'].",".$row['code_karton'].",".$row['vazn_karton_this'].",'".$row['code_mandegari']."','$sum_karton_this_new',".$tedad_karton_sal_ghabl.",".$mojody_nakhales_sal_ghabl.",".$mojody_khales_sal_ghabl.",".$tedad_shane_sal_ghabl.",".$tedad_karton_sal_ghabl.",".$mojody_nakhales_sal_ghabl.",".$mojody_khales_sal_ghabl.",".$tedad_shane_sal_ghabl.",".$row['deleted'].")");
	  
	   $insert_res=mysql_query($insert_q);
	 }
    }
    if(($insert_res)or($update_res))
    {
   	 mysql_query("COMMIT");
   	 if(strlen($mt_gl_code_ostan)==1) $code_a=make_pattern($mt_gl_code_ostan,2); else $code_a=$mt_gl_code_ostan;
       echo "<script>alert('انتقال موجِودی از سال ".$sal_mabda." به سال ".$sal_maghsad." با موفقیت انجام شد ')</script>"; 
       echo "<script>window.location='my_frame.php'</script>";
   	}
   	else  
    {
       mysql_query('ROLLBACK');
       echo "<script>alert('مشکلی در انتقال موجودی به وجود آمده است!')</script>";  
    }
    mysql_query('SET AUTOCOMMIT=1');
   }	  
}
//////////////////////////////////////////////////////////////////////////////////////////////
if(isset($transfer_anbargardani))
{
  if(isPermitSave($mt_gl_code_ostan,$sal_mabda,$sal_maghsad))				  
  {
    mysql_query('SET AUTOCOMMIT=0');//TRANSACTIONشروع 
    mysql_query('START TRANSACTION');
    $q_all="SELECT * From mt_anbargardani_detail WHERE code_ostan='$mt_gl_code_ostan' AND year='$mtActiveYear'";
	$allMojody = $db->query($q_all);
	//$sum_karton_this_new=0;
	while($row=$db->fetch_assoc($allMojody))
    {
	 $tedad_karton_sal_ghabl=$row['tedad_anbargardani'];
     IF(($row['code_kala']==50)OR($row['code_kala']==54)) $shane_sal_ghabl=$row['shane_anbargardani'];
	 ELSE $shane_sal_ghabl=0;
	 $mojody_nakhales_sal_ghabl=$row['nakhales_anbargardani'];
     $mojody_khales_sal_ghabl=$row['khales_anbargardani'];
     $sum_karton_this_new=$row['sum_karton_anbargardani'];	  
	 $exist_mojody=$db->get_from_where("count(*)","mojody_kala","code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']." AND code_ziranbar=".$row['code_ziranbar']." AND year='$sal_maghsad' AND code_kala=".$row['code_kala']." AND code_keshvar=".$row['code_keshvar']." AND code_tolidkonande=".$row['code_tolidkonande']." AND sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND code_karton=".$row['code_karton']." AND code_mandegari='".$row['code_mandegari']."' AND deleted=0");	
	 if($exist_mojody>0)//اگر در جدول موجودی کالا وجود دارد
	 {
	   //محاسبه کارتنها در سال جدید
	   $jameKartonVarede=$db->get_from_where("SUM(tedad_karton_r_d_sub)","resid_kala_detail","code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']." AND code_ziranbar=".$row['code_ziranbar']." AND year='$sal_maghsad' AND code_kala=".$row['code_kala']." AND code_keshvar=".$row['code_keshvar']." AND code_tolidkonande=".$row['code_tolidkonande']." AND sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND code_karton=".$row['code_karton']." AND code_mandegari='".$row['code_mandegari']."' AND resid_deleted=0 AND status=0");     
	   $jameKartonSadere=$db->get_from_where("SUM(tedad_karton_h_d)","havale_detail","code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']." AND code_ziranbar=".$row['code_ziranbar']." AND year='$sal_maghsad' AND code_kala=".$row['code_kala']." AND code_keshvar=".$row['code_keshvar']." AND code_tolidkonande=".$row['code_tolidkonande']." AND sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND code_karton=".$row['code_karton']." AND code_mandegari='".$row['code_mandegari']."' AND havale_deleted=0 AND status=0");     
	   $kartonTadilEzafe=$db->get_from_where("SUM(tedad_karton_tadil)","tadil_mojody","noe_tadil=1 AND code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']." AND code_ziranbar=".$row['code_ziranbar']." AND year='$sal_maghsad' AND code_kala=".$row['code_kala']." AND code_keshvar=".$row['code_keshvar']." AND code_tolidkonande=".$row['code_tolidkonande']." AND sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND code_karton=".$row['code_karton']." AND code_mandegari='".$row['code_mandegari']."' AND deleted=0");     
	   $kartonTadilKasry=$db->get_from_where("SUM(tedad_karton_tadil)","tadil_mojody","noe_tadil=2 AND code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']." AND code_ziranbar=".$row['code_ziranbar']." AND year='$sal_maghsad' AND code_kala=".$row['code_kala']." AND code_keshvar=".$row['code_keshvar']." AND code_tolidkonande=".$row['code_tolidkonande']." AND sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND code_karton=".$row['code_karton']." AND code_mandegari='".$row['code_mandegari']."' AND deleted=0");     
	   $karton_maghsad=$tedad_karton_sal_ghabl+$jameKartonVarede-$jameKartonSadere+$kartonTadilEzafe-$kartonTadilKasry;
	   IF($row['code_kala']==50) $shane_maghsad=$karton_maghsad*$_SESSION["mtShane"];
	   ELSE IF($row['code_kala']==54) $shane_maghsad=$karton_maghsad*$_SESSION["mtShane_dakheli"];
	   ELSE $shane_maghsad=0;
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
	   $update_q=("UPDATE mojody_kala SET sum_karton_this=$sum_karton_this_new,tedad_karton_aval=".$tedad_karton_sal_ghabl.",tedad_shane_aval=".$shane_sal_ghabl.",mojody_nakhales_aval=".$mojody_nakhales_sal_ghabl.",mojody_khales_aval=".$mojody_khales_sal_ghabl.",tedad_karton=".$karton_maghsad.",tedad_shane=".$shane_maghsad.",mojody_nakhales=".$nakhales_maghsad.",mojody_khales=".$khales_maghsad." WHERE code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']." AND code_ziranbar=".$row['code_ziranbar']." AND year='$sal_maghsad' AND code_kala=".$row['code_kala']." AND code_keshvar=".$row['code_keshvar']." AND code_tolidkonande=".$row['code_tolidkonande']." AND sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND code_karton=".$row['code_karton']." AND code_mandegari='".$row['code_mandegari']."' AND deleted=0");
	   $update_res=mysql_query($update_q);
	 }
	 else if(($tedad_karton_sal_ghabl!=0)or($mojody_nakhales_sal_ghabl!=0)or($mojody_khales_sal_ghabl!=0))
	 {
	   //تبدیل تاریخ شمسی به میلادی برای نگهداری در دیتابیس
       $milady=jalali_to_gregorian($row['sal_tolid_shamsi'],$row['mah_tolid_shamsi'],$row['rouz_tolid_shamsi']);
       $sal_tolid_milady=$milady[0];$mah_tolid_milady=$milady[1];$rouz_tolid_milady=$milady[2];
	   $code_bastebandy=$db->get_from_where("code_bastebandy","kala","code_kala='".$row['code_kala']."'");
	   $insert_q=("INSERT INTO mojody_kala(code_ostan,code_anbar,year,code_ziranbar,code_kala,code_keshvar,code_tolidkonande,sal_tolid_shamsi,mah_tolid_shamsi,rouz_tolid_shamsi,sal_tolid_milady,mah_tolid_milady,rouz_tolid_milady,code_bastebandy,code_karton,vazn_karton_this,code_mandegari,sum_karton_this,tedad_karton_aval,tedad_shane_aval,mojody_nakhales_aval,mojody_khales_aval,tedad_karton,tedad_shane,mojody_nakhales,mojody_khales,deleted)
                   VALUES (".$row['code_ostan'].",".$row['code_anbar'].",'$sal_maghsad',".$row['code_ziranbar'].",".$row['code_kala'].",".$row['code_keshvar'].",".$row['code_tolidkonande'].",".$row['sal_tolid_shamsi'].",".$row['mah_tolid_shamsi'].",".$row['rouz_tolid_shamsi'].",".$sal_tolid_milady.",".$mah_tolid_milady.",".$rouz_tolid_milady.",".$code_bastebandy.",".$row['code_karton'].",".$row['vazn_karton_this'].",'".$row['code_mandegari']."','$sum_karton_this_new',".$tedad_karton_sal_ghabl.",".$shane_sal_ghabl.",".$mojody_nakhales_sal_ghabl.",".$mojody_khales_sal_ghabl.",".$tedad_karton_sal_ghabl.",".$shane_sal_ghabl.",".$mojody_nakhales_sal_ghabl.",".$mojody_khales_sal_ghabl.",0)");
	   $insert_res=mysql_query($insert_q);
	 }
    }
    if(($insert_res)or($update_res))
    {
   	 mysql_query("COMMIT");
   	 if(strlen($mt_gl_code_ostan)==1) $code_a=make_pattern($mt_gl_code_ostan,2); else $code_a=$mt_gl_code_ostan;
       echo "<script>alert('انتقال موجِودی از سال ".$sal_mabda." به سال ".$sal_maghsad." با موفقیت انجام شد ')</script>"; 
       //echo "<script>window.location='my_frame.php'</script>";
   	}
   	else  
    {
       mysql_query('ROLLBACK');
       echo "<script>alert('مشکلی در انتقال موجودی به وجود آمده است!')</script>";  
    }
    mysql_query('SET AUTOCOMMIT=1');
   }	  
}
////////////////////////////////////////////////////////////////////////////////////////////////
echo'
</form>
</body>
</html>';	
?>