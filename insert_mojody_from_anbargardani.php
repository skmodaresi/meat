<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="insert_mojody_from_anbargardani.php";
echo'
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>اصلاح موجودی سال بعد سردخانه</title>
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
    <tr><td colspan="4" class="title">اصلاح موجودی استان '.$mt_gl_name_ostan.' و سردخانه '.$mt_gl_name_anbar.'</td></tr>';
	 IF(!($mt_gl_code_ostan and $mt_gl_code_anbar) OR $mt_gl_code_ostan==-1 OR $mt_gl_code_anbar==-1)  
	echo'<tr class="tr1"><td colspan="4">لطفاً استان و سردخانه مورد نظر خود را انتخاب کنید !</td></tr>';
	echo'
	<tr class="tr1">	
     <td align="left"> از سال :&nbsp;</td><td align="right"><input type="text" class="textboxme2 textbox50" maxlength="4" name="sal_mabda" placeholder=" 1399" onkeypress="return isNumber(event)" value="'.$sal_mabda_val.'" /></td>
	</tr>';
	//IF($mtActiveYear==$yy)  echo'<tr class="tr1"><td colspan="4" height="40px">سال بعد هنوز موجود نیست</td></tr> ';
    //ELSE 
		echo'<tr class="tr1"><td colspan="4" height="40px"><input class="buttonme" type="submit" name="transfer" value="اصلاح موجودی سردخانه"></td></tr> ';
    echo'
	<tr class="footer"><td colspan="4">&nbsp;</td></tr>
   </table>
   </div>
  </td>
 </tr> 
</table>
</div>';
/************اجازه براي ذخيره اطلاعات************/
function isPermitSave($gl_c_o,$gl_c_s,$sal1)
{
 $flag=false;
 if(!($gl_c_o and $gl_c_s) or $gl_c_o==-1 or $gl_c_s==-1)//اگر سشن استان و انبار وسال خالی بود
 {   
   $flag=false;
   echo"<script> alert('لطفاً استان و انبار موردنظر خود را انتخاب نمایید!')</script>";
   return $flag;
 }
 else $flag=true;
return $flag;
}
//////////////////////////////////////////////////////////////////////////////////////////////
if(isset($transfer))
{
  if(isPermitSave($mt_gl_code_ostan,$mt_gl_code_anbar,$sal_mabda))				  
  {
    mysql_query('SET AUTOCOMMIT=0');//TRANSACTIONشروع 
    mysql_query('START TRANSACTION');
    $q="SELECT * From mt_anbargardani_detail WHERE code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='1399' AND code_kala='78'";
	$all = $db->query($q);
	while($row=$db->fetch_assoc($all))
    {
	 $exist_mojody=$db->get_from_where("count(*)","mojody_kala","code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']." AND code_ziranbar=".$row['code_ziranbar']." AND year='1400' AND code_kala=".$row['code_kala']." AND code_keshvar=".$row['code_keshvar']." AND code_tolidkonande=".$row['code_tolidkonande']." AND sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND code_karton=".$row['code_karton']." AND code_mandegari='".$row['code_mandegari']."' AND deleted=0");	
	 if($exist_mojody>0)//اگر در جدول موجودی کالا وجود دارد
	 {
	   $update_q=("UPDATE mojody_kala SET sum_karton_this=".$row['sum_karton_anbargardani'].",tedad_karton_aval=".$row['tedad_anbargardani'].",mojody_nakhales_aval=".$row['nakhales_anbargardani'].",mojody_khales_aval=".$row['khales_anbargardani'].",tedad_karton=".$karton_maghsad.",tedad_shane=".$shane_maghsad.",mojody_nakhales=".$nakhales_maghsad.",mojody_khales=".$khales_maghsad." WHERE code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']." AND code_ziranbar=".$row['code_ziranbar']." AND year='1400' AND code_kala=".$row['code_kala']." AND code_keshvar=".$row['code_keshvar']." AND code_tolidkonande=".$row['code_tolidkonande']." AND sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND code_karton=".$row['code_karton']." AND code_mandegari='".$row['code_mandegari']."' AND deleted=0");
	   //echo $update_q;
	   $update_res=mysql_query($update_q);
	 }
	 else 
	 {
	   //تبدیل تاریخ شمسی به میلادی برای نگهداری در دیتابیس
       $milady=jalali_to_gregorian($row['sal_tolid_shamsi'],$row['mah_tolid_shamsi'],$row['rouz_tolid_shamsi']);
       $sal_tolid_milady=$milady[0];$mah_tolid_milady=$milady[1];$rouz_tolid_milady=$milady[2];
	   $code_bastebandy=$db->get_from_where("code_bastebandy","kala","code_kala='".$row['code_kala']."'");
	   $insert_q=("INSERT INTO mojody_kala(code_ostan,code_anbar,year,code_ziranbar,code_kala,code_keshvar,code_tolidkonande,sal_tolid_shamsi,mah_tolid_shamsi,rouz_tolid_shamsi,sal_tolid_milady,mah_tolid_milady,rouz_tolid_milady,code_bastebandy,code_karton,vazn_karton_this,code_mandegari,sum_karton_this,tedad_karton_aval,tedad_shane_aval,mojody_nakhales_aval,mojody_khales_aval,tedad_karton,tedad_shane,mojody_nakhales,mojody_khales,deleted)
                   VALUES (".$row['code_ostan'].",".$row['code_anbar'].",'1400',".$row['code_ziranbar'].",".$row['code_kala'].",".$row['code_keshvar'].",".$row['code_tolidkonande'].",".$row['sal_tolid_shamsi'].",".$row['mah_tolid_shamsi'].",".$row['rouz_tolid_shamsi'].",".$sal_tolid_milady.",".$mah_tolid_milady.",".$rouz_tolid_milady.",".$code_bastebandy.",".$row['code_karton'].",".$row['vazn_karton_this'].",'".$row['code_mandegari']."',".$row['sum_karton_anbargardani'].",".$row['tedad_anbargardani'].",".$row['shane_anbargardani'].",".$row['nakhales_anbargardani'].",".$row['khales_anbargardani'].",".$row['tedad_anbargardani'].",".$row['shane_anbargardani'].",".$row['nakhales_anbargardani'].",".$row['khales_anbargardani'].",0)");
	   $insert_res=mysql_query($insert_q);
	 }
    }
    if(($insert_res)or($update_res))
    {
   	 mysql_query("COMMIT");
   	 if(strlen($mt_gl_code_ostan)==1) $code_a=make_pattern($mt_gl_code_ostan,2); else $code_a=$mt_gl_code_ostan;
       echo "<script>alert('succes')</script>"; 
       //echo "<script>window.location='my_frame.php'</script>";
   	}
   	else  
    {
       mysql_query('ROLLBACK');
       echo "<script>alert('error')</script>";  
    }
    mysql_query('SET AUTOCOMMIT=1');
   }	  
}
//////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////////
echo'
</form>
</body>
</html>';	
?>