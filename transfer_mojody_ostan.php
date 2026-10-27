<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="transfer_mojody.php";
echo'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" />
<html xmlns="http://www.w3.org/1999/xhtml" dir=rtl>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>انتقال موجودی به سال بعد</title>
<link href="styles.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="functions.js"></script>
<link type="text/css" href="styles/jquery-ui-1.8.14.css" rel="stylesheet" />
<script type="text/javascript" src="scripts/jquery-1.6.2.min.js"></script>
</head>';
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.sal_mabda.focus();">
<form method="POST" name="myform">
<div align="center">
<table width="100%" height="100%" align="center" cellpadding="0" cellspacing="0">
 <tr>
  <td height="100%">
   <div style="float:right;width:100%;margin:0px;height:100%;overflow:auto;overflow-x:hidden;">
   <table width="600px" border="0" align="center" cellpadding="0" cellspacing="0" >
    <tr><td colspan="4" height="20px">&nbsp;</td></tr>
	<tr><td colspan="4" class="title">انتقال موجودی به سال بعد استان '.$mt_gl_name_ostan.'</td></tr>
	<tr class="tr1">	
     <td align="left"> از سال :&nbsp;</td><td align="right"><input type="text" class="textboxme2 textbox50" maxlength="4" name="sal_mabda" placeholder=" 1402" onkeypress="return isNumber(event)"/></td>
     <td align="left"> به سال :&nbsp;</td><td align="right"><input type="text" class="textboxme2 textbox50" maxlength="4" name="sal_maghsad" placeholder=" 1403" onkeypress="return isNumber(event)"/></td>
	</tr>
    <tr class="tr1"><td colspan="4" height="40px"><input class="buttonme" type="submit" name="transfer" value="انتقال موجودی استان"></td></tr> 
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
 if ((!justNumber($sal1)) or (strlen($sal1)<4) or (strlen($sal1)>4) or($sal1<1401))//بررسی از سال
 {
   $flag=false;
   echo"<script>alert('فیلد از سال نامعتبر است')</script>";
   return $flag;
 }
 else $flag=true;
 if ((!justNumber($sal2)) or (strlen($sal2)<4) or (strlen($sal2)>4) or($sal2<1401))//بررسی تا سال
 {
   $flag=false;
   echo"<script>alert('فیلد تا سال نامعتبر است')</script>";
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
    $sum_karton_this_new=0;
	while($row=$db->fetch_assoc($allMojody))
    {
	 $tedad_karton=mojodyKarton($row['code_ostan'],$row['code_anbar'],$row['year'],$row['code_ziranbar'],$row['code_kala'],$row['code_keshvar'],$row['code_tolidkonande'],$row['sal_tolid_shamsi'],$row['mah_tolid_shamsi'],$row['rouz_tolid_shamsi'],$row['code_karton'],$row['code_mandegari']);
     $mojody_nakhales=mojodyNakhales($row['code_ostan'],$row['code_anbar'],$row['year'],$row['code_ziranbar'],$row['code_kala'],$row['code_keshvar'],$row['code_tolidkonande'],$row['sal_tolid_shamsi'],$row['mah_tolid_shamsi'],$row['rouz_tolid_shamsi'],$row['code_karton'],$row['code_mandegari']);
     $mojody_khales=mojodyKhales($row['code_ostan'],$row['code_anbar'],$row['year'],$row['code_ziranbar'],$row['code_kala'],$row['code_keshvar'],$row['code_tolidkonande'],$row['sal_tolid_shamsi'],$row['mah_tolid_shamsi'],$row['rouz_tolid_shamsi'],$row['code_karton'],$row['code_mandegari']);	 
	 $sum_karton_this_new=round(floatval($row['vazn_karton_this']*$tedad_karton),3);
	 IF($row['code_kala']==50) $tedad_shane=$tedad_karton*$_SESSION["mtShane"];
	 ELSE IF($row['code_kala']==54)$tedad_shane=$tedad_karton*$_SESSION["mtShane_dakheli"];
	 ELSE $tedad_shane=0;
	 //$sum_karton_this_new=round(floatval($row['vazn_karton_this']*$row['tedad_karton']),3);
	 //$insert_q=("INSERT INTO mojody_kala(code_ostan,code_anbar,year,code_ziranbar,code_kala,code_keshvar,code_tolidkonande,sal_tolid_shamsi,mah_tolid_shamsi,rouz_tolid_shamsi,sal_tolid_milady,mah_tolid_milady,rouz_tolid_milady,code_karton,vazn_karton_this,sum_karton_this,tedad_karton_aval,mojody_nakhales_aval,mojody_khales_aval,tedad_karton,mojody_nakhales,mojody_khales,deleted) VALUES (".$row['code_ostan'].",".$row['code_anbar'].",'$sal_maghsad',".$row['code_ziranbar'].",".$row['code_kala'].",".$row['code_keshvar'].",".$row['code_tolidkonande'].",".$row['sal_tolid_shamsi'].",".$row['mah_tolid_shamsi'].",".$row['rouz_tolid_shamsi'].",".$row['sal_tolid_milady'].",".$row['mah_tolid_milady'].",".$row['rouz_tolid_milady'].",".$row['code_karton'].",".$row['vazn_karton_this'].",'$sum_karton_this_new',".$row['tedad_karton'].",".$row['mojody_nakhales'].",".$row['mojody_khales'].",".$row['tedad_karton'].",".$row['mojody_nakhales'].",".$row['mojody_khales'].",".$row['deleted'].")");
	 if(($tedad_karton>0)or($mojody_nakhales>0)or($mojody_khales>0))$insert_q=("INSERT INTO mojody_kala(code_ostan,code_anbar,year,code_ziranbar,code_kala,code_keshvar,code_tolidkonande,sal_tolid_shamsi,mah_tolid_shamsi,rouz_tolid_shamsi,sal_tolid_milady,mah_tolid_milady,rouz_tolid_milady,code_bastebandy,code_karton,vazn_karton_this,code_mandegari,sum_karton_this,tedad_karton_aval,mojody_nakhales_aval,mojody_khales_aval,tedad_shane_aval,tedad_karton,mojody_nakhales,mojody_khales,tedad_shane,deleted) VALUES (".$row['code_ostan'].",".$row['code_anbar'].",'$sal_maghsad',".$row['code_ziranbar'].",".$row['code_kala'].",".$row['code_keshvar'].",".$row['code_tolidkonande'].",".$row['sal_tolid_shamsi'].",".$row['mah_tolid_shamsi'].",".$row['rouz_tolid_shamsi'].",".$row['sal_tolid_milady'].",".$row['mah_tolid_milady'].",".$row['rouz_tolid_milady'].",".$row['code_bastebandy'].",".$row['code_karton'].",".$row['vazn_karton_this'].",'".$row['code_mandegari']."','$sum_karton_this_new',".$tedad_karton.",".$mojody_nakhales.",".$mojody_khales.",".$tedad_shane.",".$tedad_karton.",".$mojody_nakhales.",".$mojody_khales.",".$tedad_shane.",".$row['deleted'].")");
	 $insert_res=mysql_query($insert_q);
    }
    if($insert_res)
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
////////////////////////////////////////////////////////////////////////////////////////////////
echo'
</form>
</body>
</html>';	
?>