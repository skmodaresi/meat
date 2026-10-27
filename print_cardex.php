<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$today=AsLDate($yymmdd);
$logtime=date('H:i');
echo'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" />
<html xmlns="http://www.w3.org/1999/xhtml" dir=rtl>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>چاپ کنترل کاردکس</title>
<link href="styles.css" rel="stylesheet" type="text/css"/>
<style>
       @media screen
       {
           .hideatprint
           {
           }
       }
       @media print
       {
           .hideatprint
           {
               display: none;
           }
       }
</style>
<script type="text/javascript" src="functions.js"></script>
</head>';
/***************************************** MAIN*****************************************/
//اطلاعات کلی قسمت بالا
if($code_ziranbar_) $Condition.=" AND code_ziranbar='$code_ziranbar_'";
if($code_ziranbar_==0) $nameZirAnbar='همه زیرانبارها';
else $nameZirAnbar=$db->get_from_where("name_ziranbar","list_sardkhane_detail","code_ziranbar='$code_ziranbar_'");
   IF($namayesh_info==2){$table_mojody='mojody_kala_gomrok'; $Condition_info=" AND noe_tahvil_bar=9";}
   ELSE {$table_mojody='mojody_kala'; $Condition_info=" AND noe_tahvil_bar!=9";}

	    if($code_keshvar_) 
		{
		 $Condition.=" AND code_keshvar='$code_keshvar_'";
		 $Condition2.=" AND r_k_d.code_keshvar='$code_keshvar_'";
		 $Condition3.=" AND h_d.code_keshvar='$code_keshvar_'";
		}
	    if($code_tolidkonande_) 
		{
		 $Condition.=" AND code_tolidkonande='$code_tolidkonande_'";
		 $Condition2.=" AND r_k_d.code_tolidkonande='$code_tolidkonande_'";
		 $Condition3.=" AND h_d.code_tolidkonande='$code_tolidkonande_'";
		}
	    if($code_karton_) 
		{
		 $Condition.=" AND code_karton='$code_karton_'";
		 $Condition2.=" AND r_k_d.code_karton='$code_karton_'";
		 $Condition3.=" AND h_d.code_karton='$code_karton_'";
		}
	    if($sal_tolid_shamsi_) 
		{
		 $Condition.=" AND sal_tolid_shamsi='$sal_tolid_shamsi_'";
		 $Condition2.=" AND r_k_d.sal_tolid_shamsi='$sal_tolid_shamsi_'";
		 $Condition3.=" AND h_d.sal_tolid_shamsi='$sal_tolid_shamsi_'";
		}
	    if($mah_tolid_shamsi_) 
		{
		 $Condition.=" AND mah_tolid_shamsi='$mah_tolid_shamsi_'";
		 $Condition2.=" AND r_k_d.mah_tolid_shamsi='$mah_tolid_shamsi_'";
		 $Condition3.=" AND h_d.mah_tolid_shamsi='$mah_tolid_shamsi_'";
		}
	    if($rouz_tolid_shamsi_) 
		{
		 $Condition.=" AND rouz_tolid_shamsi='$rouz_tolid_shamsi_'";
		 $Condition2.=" AND r_k_d.rouz_tolid_shamsi='$rouz_tolid_shamsi_'";
		 $Condition3.=" AND h_d.rouz_tolid_shamsi='$rouz_tolid_shamsi_'";
		}
	    if($code_ziranbar_) 
		{
		 $Condition.=" AND code_ziranbar='$code_ziranbar_'";
		 $Condition2.=" AND r_k_d.code_ziranbar='$code_ziranbar_'";
		 $Condition3.=" AND h_d.code_ziranbar='$code_ziranbar_'";
		}
		if($code_mandegari_) 
		{
		 $Condition.=" AND code_mandegari='$code_mandegari_'";
		 $Condition2.=" AND r_k_d.code_mandegari='$code_mandegari_'";
		 $Condition3.=" AND h_d.code_mandegari='$code_mandegari_'";
		}
        $nameKala=$db->get_from_where("name_kala","kala","code_kala='$code_kala_'");     
        $tedadKartonAval=$db->get_from_where("SUM(tedad_karton_aval)","$table_mojody","code_kala='$code_kala_' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' $Condition AND deleted=0");     
		$tedadShaneAval=$db->get_from_where("SUM(tedad_shane_aval)","$table_mojody","code_kala='$code_kala_' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' $Condition AND deleted=0");     
		$mojodyNakhalesAval=$db->get_from_where("SUM(mojody_nakhales_aval)","$table_mojody","code_kala='$code_kala_' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' $Condition AND deleted=0");     
        $mojodyKhalesAval=$db->get_from_where("SUM(mojody_khales_aval)","$table_mojody","code_kala='$code_kala_' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' $Condition AND deleted=0");     
		$tedadKarton=$db->get_from_where("SUM(tedad_karton)","$table_mojody","code_kala='$code_kala_' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' $Condition AND deleted=0");     
	    $tedadShane=$tedadKarton*$_SESSION["mtShane"];
		$mojodyNakhales=$db->get_from_where("SUM(mojody_nakhales)","$table_mojody","code_kala='$code_kala_' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' $Condition AND deleted=0");     
	    $mojodyKhales=$db->get_from_where("SUM(mojody_khales)","$table_mojody","code_kala='$code_kala_' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' $Condition AND deleted=0");     
		//مجموع تعداد کارتن و وزن ناخالص و وزن خالص  وارده
		 $q_varede="SELECT SUM(tedad_karton_r_d_sub),SUM(vazn_nakhales_r_d_sub),SUM(vazn_khales_r_d_sub),SUM(tedad_shane_r_d_sub) FROM resid_kala_detail r_k_d 
		            INNER JOIN resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year
		            WHERE r_k_d.code_kala='$code_kala_' AND r_k_d.code_ostan='$mt_gl_code_ostan' AND r_k_d.code_anbar='$mt_gl_code_anbar' AND r_k_d.year='$mtActiveYear' $Condition $Condition_info AND resid_deleted=0 AND r_k_d.status=0";
		 $res_varede=$db->query($q_varede);
		 $row_varede=$db->fetch_array($res_varede);
		 $jameKartonVarede=$row_varede[0];$jameNaKhalesVarede=$row_varede[1];$jameKhalesVadere=$row_varede[2];
		//مجموع تعداد کارتن و وزن ناخالص و وزن خالص  وارده جابه جایی
         $q_varede_j="SELECT SUM(tedad_karton_r_d_sub),SUM(vazn_nakhales_r_d_sub),SUM(vazn_khales_r_d_sub),SUM(tedad_shane_r_d_sub) FROM resid_kala_detail r_k_d 
		              INNER JOIN resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year
		              WHERE (r.noe_tahvil_bar=4 OR r.noe_tahvil_bar=5) AND r_k_d.code_kala='$code_kala_' AND r_k_d.code_ostan='$mt_gl_code_ostan' AND r_k_d.code_anbar='$mt_gl_code_anbar' AND r_k_d.year='$mtActiveYear' $Condition2 AND r_k_d.resid_deleted=0 AND r_k_d.status=0";
		 $res_varede_j=$db->query($q_varede_j);
		 $row_varede_j=$db->fetch_array($res_varede_j);
		 $varedeKarton_jabejae=$row_varede_j[0];$varedeNaKhales_jabejae=$row_varede_j[1];$varedeKhales_jabejae=$row_varede_j[2];//$jameKhalesSadere=$row_varede[2];
	    //مجموع تعداد کارتن و وزن ناخالص و وزن خالص  وارده خرید قطعی
         $q_varede_kh="SELECT SUM(tedad_karton_r_d_sub),SUM(vazn_nakhales_r_d_sub),SUM(vazn_khales_r_d_sub),SUM(tedad_shane_r_d_sub) FROM resid_kala_detail r_k_d 
		              INNER JOIN resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year
		              WHERE (r.noe_tahvil_bar=1 OR r.noe_tahvil_bar=2 OR r.noe_tahvil_bar=3) AND r_k_d.code_kala='$code_kala_' AND r_k_d.code_ostan='$mt_gl_code_ostan' AND r_k_d.code_anbar='$mt_gl_code_anbar' AND r_k_d.year='$mtActiveYear' $Condition2 AND r_k_d.resid_deleted=0 AND r_k_d.status=0";
		 $res_varede_kh=$db->query($q_varede_kh);
		 $row_varede_kh=$db->fetch_array($res_varede_kh);
		 $varedeKarton_kharid=$row_varede_kh[0];$varedeNaKhales_kharid=$row_varede_kh[1];$varedeKhales_kharid=$row_varede_kh[2];$varedeShane_kharid=$row_varede_kh[3];//
		//مجموع تعداد کارتن و وزن ناخالص و وزن خالص صادره
         $q_sadere="SELECT SUM(tedad_karton_h_d),SUM(vazn_nakhales_h_d),SUM(vazn_khales_h_d),SUM(tedad_shane_h_d) FROM havale_detail h_d INNER JOIN havale h 
		 		    ON h_d.shomare_havale_anbar=h.shomare_havale_anbar AND h_d.code_ostan=h.code_ostan AND h_d.code_anbar=h.code_anbar AND h_d.year=h.year  WHERE h_d.code_kala='$code_kala_' AND h_d.code_ostan='$mt_gl_code_ostan' AND h_d.code_anbar='$mt_gl_code_anbar' AND h_d.year='$mtActiveYear' $Condition $Condition_info AND havale_deleted=0 AND h_d.status=0";
 		 $res_sadere=$db->query($q_sadere);
		 $row_sadere=$db->fetch_array($res_sadere);
		 $jameKartonSadere=$row_sadere[0];$jameNaKhalesSadere=$row_sadere[1];$jameKhalesSadere=$row_sadere[2];
		//مجموع تعداد کارتن و وزن ناخالص و وزن خالص صادره در حالت جابه جایی
		 $q_sadere_j="SELECT SUM(tedad_karton_h_d),SUM(vazn_nakhales_h_d),SUM(vazn_khales_h_d),SUM(tedad_shane_h_d) FROM havale_detail h_d INNER JOIN havale h
		              ON h_d.shomare_havale_anbar=h.shomare_havale_anbar AND h_d.code_ostan=h.code_ostan AND h_d.code_anbar=h.code_anbar AND h_d.year=h.year 
		 	          WHERE (h.noe_tahvil_bar=4 OR h.noe_tahvil_bar=5) AND h_d.code_kala='$code_kala_' AND h_d.code_ostan='$mt_gl_code_ostan' AND h_d.code_anbar='$mt_gl_code_anbar' AND h_d.year='$mtActiveYear' $Condition3 $Condition_info AND h_d.havale_deleted=0 AND h_d.status=0";
		 $res_sadere_j=$db->query($q_sadere_j);
		 $row_sadere_j=$db->fetch_array($res_sadere_j);
		 $sadereKarton_jabejae=$row_sadere_j[0];$sadereNaKhales_jabejae=$row_sadere_j[1];$sadereKhales_jabejae=$row_sadere_j[2];
		//مجموع تعداد کارتن و وزن ناخالص و وزن خالص تعدیل اضافه	 		
		 $q_tadil_ezafe="SELECT SUM(tedad_karton_tadil),SUM(meghdar_nakhales_tadil),SUM(meghdar_khales_tadil),SUM(tedad_shane_tadil) FROM tadil_mojody WHERE noe_tadil=1 AND code_kala='$code_kala_' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' $Condition $Condition_info AND status=0 AND deleted=0";
	     $res_tadil_ezafe=$db->query($q_tadil_ezafe);
		 $row_tadil_ezafe=$db->fetch_array($res_tadil_ezafe);
		 $kartonTadilEzafe=$row_tadil_ezafe[0];$nakhalesTadilEzafe=$row_tadil_ezafe[1];$khalesTadilEzafe=$row_tadil_ezafe[2];
		//مجموع تعداد کارتن و وزن ناخالص و وزن خالص تعدیل کسری	
		 $q_tadil_kasry="SELECT SUM(tedad_karton_tadil),SUM(meghdar_nakhales_tadil),SUM(meghdar_khales_tadil),SUM(tedad_shane_tadil) FROM tadil_mojody WHERE noe_tadil=2 AND code_kala='$code_kala_' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' $Condition $Condition_info AND status=0 AND deleted=0";
	     $res_tadil_kasry=$db->query($q_tadil_kasry);
		 $row_tadil_kasry=$db->fetch_array($res_tadil_kasry);
		 $kartonTadilKasry=$row_tadil_kasry[0];$nakhalesTadilKasry=$row_tadil_kasry[1];$khalesTadilKasry=$row_tadil_kasry[2];	

echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
 <!--هدر-->
 <br/>
 <table width="99%" border="1" align="center">
  <tr><td class="print_title_2">'.$mt_gl_owner.'</td></tr>
  <tr><td class="print_title_2"> سردخانه : '.$mt_gl_name_anbar.'&nbsp;&nbsp; استان : '.$mt_gl_name_ostan.'</td></tr>
   <tr><td class="print_title_2"> کنترل کاردکس  کالای '.$nameKala.'&nbsp&nbsp(صفحه : 1)
	    <span style="float:right"><a href="javascript:window.print();"><img src="images/PrinterText.png" onmouseOver="this.src=\'images/PrinterText--hover.png\'" onmouseOut="this.src=\'images/PrinterText.png\'" title="چاپ" id="IMG1" class="hideatprint"/></a></span>
       </td>
   </tr>
 </table>
 <!--پايان هدر-->
 <!-- مرکز صفحه-->
 <table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
  <tr class="tr1" width="100%">
   <td align="right" width="40%"> کد کالا : '.$code_kala_.' -  نام کالا : '.$nameKala.'</td>
   <td align="right" width="20%"> کد کشور : ';if($code_keshvar_) echo $code_keshvar_; else echo '-'; echo'</td>
   <td align="right" width="20%"> کد تولیدکننده : ';if($code_tolidkonande_) echo $code_tolidkonande_; else echo '-'; echo'</td>
   <td align="right" width="20%"> کد کارتن/ قوطی : ';if($code_karton_) echo $code_karton_;  else echo '-'; echo'</td>
  </tr>
  <tr class="tr1" width="100%">
  	<td align="right"> تاریخ تولید شمسی :&nbsp;
                  	   سال تولید : ';if($sal_tolid_shamsi_) echo $sal_tolid_shamsi_;else echo '-'; echo'
	                   ماه تولید : ';if($mah_tolid_shamsi_) echo $mahshamsiArr["$mah_tolid_shamsi_"];else echo '-'; echo'
					   روز تولید : ';if($rouz_tolid_shamsi_) echo $rouz_tolid_shamsi_;else echo '-'; echo'
	</td>
    <td align="right">نام زیرانبار : '.$nameZirAnbar.'</td>
    <td align="right"> کد تاریخ ماندگاری : ';if($code_mandegari_) echo $code_mandegari_;  else echo '-'; echo'</td>
	<td align="right" colspan="3"> نمایش اطلاعات : '.$namayeshArr["$noe_namayesh_"].'</td>
   </tr>
  </table>
  <table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
   <tr class="tr1" width="100%"> 
    <td align="right"> تعداد اول دوره : '.virgul($tedadKartonAval).'</td>';
    IF($code_kala_==50)echo'<td align="right"> شانه اول دوره : '.virgul($tedadShaneAval).'</td>';
	echo'
    <td align="right"> موجودی ناخالص اول دوره : '.round($mojodyNakhalesAval,3).'</td>
    <td align="right"> موجودی خالص اول دوره : '.round($mojodyKhalesAval,3).'</td>
   </tr>
   <tr class="tr1" width="100%">
    <td align="right"> تعداد فعلی : '.virgul($tedadKarton).'</td>';
    IF($code_kala_==50)echo'<td align="right"> شانه فعلی : '.virgul($tedadShane).'</td>';
    echo'
	<td align="right"> موجودی ناخالص فعلی : '.round($mojodyNakhales,3).'</td>
	<td align="right"> موجودی خالص فعلی : '.round($mojodyKhales,3).'</td>   
   </tr>
   <tr class="tr1" width="100%">
    <td align="right"> جمع تعداد وارده : '.virgul($jameKartonVarede).'</td>';
    IF($code_kala_==50)echo'<td align="right"> جمع شانه وارده : '.virgul($jameShaneVarede).'</td>';
    echo'
	<td align="right"> جمع مقدار ناخالص وارده : '.round($jameNaKhalesVarede,3).'</td>
    <td align="right"> جمع مقدار خالص وارده : '.round($jameKhalesVadere,3).'</td>    
   </tr>';
   IF($namayesh_info==1)
   {
    echo'
    <tr class="tr1" width="100%">
      <td align="right"> تعداد وارده (خرید) : '.virgul($varedeKarton_kharid).'</td>';
      IF($code_kala_==50)echo'<td align="right"> شانه وارده (خرید) : '.virgul($varedeKarton_kharid).'</td>';
	   echo'<td align="right"> مقدار ناخالص وارده (خرید) : '.round($varedeNaKhales_kharid,3).'</td>
	   <td align="right"> مقدار خالص وارده (خرید) : '.round($varedeKhales_kharid,3).'</td>
     </tr>
    <tr class="tr1" width="100%">
     <td align="right"> تعداد وارده (جابه جایی) : '.virgul($varedeKarton_jabejae).'</td>';
	  IF($code_kala_==50)echo'<td align="right"> شانه وارده (جابه جایی) : '.round($varedeShane_jabejae,3).'</td>';
	  echo'
	  <td align="right"> مقدار ناخالص وارده (جابه جایی) : '.round($varedeNaKhales_jabejae,3).'</td>
	  <td align="right"> مقدار خالص وارده (جابه جایی) : '.round($varedeKhales_jabejae,3).'</td>
    </tr>';
   }
   echo'
   <tr class="tr1" width="100%">
    <td align="right"> جمع تعداد صادره : '.virgul($jameKartonSadere).'</td>';
    IF($code_kala_==50)echo'<td align="right"> جمع شانه صادره : '.virgul($jameShaneSadere).'</td>';
    echo'
	<td align="right"> جمع مقدار ناخالص صادره : '.round($jameNaKhalesSadere,3).'</td>
    <td align="right"> جمع مقدار خالص صادره : '.round($jameKhalesSadere,3).'</td>
   </tr>
   <tr class="tr1" width="100%">
    <td align="right"> تعداد صادره (جابه جایی) : '.virgul($sadereKarton_jabejae).'</td>';
    IF($code_kala_==50)echo'<td align="right"> شانه صادره (جابه جایی) : '.virgul($sadereShane_jabejae).'</td>';
	echo'
	<td align="right"> مقدار ناخالص صادره (جابه جایی) : '.round($sadereNaKhales_jabejae,3).'</td>
	<td align="right"> مقدار خالص صادره (جابه جایی) : '.round($sadereKhales_jabejae,3).'</td>
   </tr>';
   if(($row2['type']==4)AND($namayesh_info!=2)){
     echo'
     <tr class="tr1" width="100%">
	  <td align="right"> تعداد تعدیل (اضافه) : '.virgul($kartonTadilEzafe).'</td>';
	  IF($code_kala_==50)echo'<td align="right"> شانه تعدیل (اضافه) : '.virgul($shaneTadilEzafe).'</td>';
	  echo'
	  <td align="right"> مقدار ناخالص تعدیل (اضافه) : '.round($nakhalesTadilEzafe,3).'</td>
	  <td align="right"> مقدارخالص تعدیل (اضافه) : '.round($khalesTadilEzafe,3).'</td>
     </tr>
     <tr class="tr1" width="100%">
	  <td align="right"> تعداد تعدی (کسری) : '.virgul($kartonTadilKasry).'</td>';
	  IF($code_kala_==50)echo'<td align="right"> شانه تعدیل (کسری) : '.virgul($shaneTadilKasry).'</td>';
	  echo'
	  <td align="right"> مقدار ناخالص تعدیل (کسری) : '.round($nakhalesTadilKasry,3).'</td>
	  <td align="right"> مقدارخالص تعدیل (کسری) : '.round($khalesTadilKasry,3).'</td>
     </tr>';
   }
   echo'
  </table>
  <table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">   
	<tr class="table-title">
	 <td width="5%">ردیف</td>
	 <td width="12%">تاریخ</td>
	 <td width="12%">شماره</td>
	 <td width="13%">نوع فرم</td>
	 <td width="10%">وضعیت</td>';
	 if($noe_namayesh_==1)//درحالت خالص
	 {
	    echo'<td width="15%">وارده خالص</td>
	         <td width="15%">صادره خالص</td>
	         <td width="18%">مانده موجودی خالص کالا</td>';
	 }
	 else if($noe_namayesh_==2)//درحالت ناخالص
	 {
	    echo'<td width="15%">وارده ناخالص</td>
	         <td width="15%">صادره ناخالص</td>
	         <td width="18%">مانده موجودی ناخالص کالا</td>';
	 }
     else if($noe_namayesh_==3)//درحالت تعداد کارتن
	 {
	    echo'<td width="15%">تعداد وارده</td>
	         <td width="15%">تعداد صادره</td>
	         <td width="18%">تعداد مانده</td>';
	 }
	 else if($noe_namayesh_==4)//درحالت تعداد شانه
	 {
	  echo'
	    <td width="15%">شانه وارده</td>
	    <td width="15%">شانه صادره</td>
	    <td width="18%">شانه مانده</td>';
	 }	
	echo'
	</tr>';
	//تعیین فیلدها براساس نوع نمایش
    IF($noe_namayesh_==1){$avalField='mojody_khales_aval';$residField='vazn_khales_r_d_sub';$havaleField='vazn_khales_h_d';$tadilField='meghdar_khales_tadil';}
    ELSE IF($noe_namayesh_==2){$avalField='mojody_nakhales_aval';$residField='vazn_nakhales_r_d_sub';$havaleField='vazn_nakhales_h_d';$tadilField='meghdar_nakhales_tadil';}
    ELSE IF($noe_namayesh_==3){$avalField='tedad_karton_aval';$residField='tedad_karton_r_d_sub';$havaleField='tedad_karton_h_d';$tadilField='tedad_karton_tadil';}
    ELSE IF($noe_namayesh_==4){$avalField='tedad_shane_aval';$residField='tedad_shane_r_d_sub';$havaleField='tedad_shane_h_d';$tadilField='tedad_shane_tadil';} 
      $page=1;
      $line=0;
      $i=0;$cntr=0;
      $MaxLines=20;
      $radif=1;	
	  $q2="(SELECT r_d.code_ostan as code_ostan,r_d.code_anbar as code_anbar,r_d.year as year,r_d.shomare_resid as shomare,r.tarikh_resid as tarikh,SUM(r_k_d.$residField) as vazn,r.status,1 as type FROM resid_detail as r_d
             INNER JOIN resid as r ON r.shomare_resid=r_d.shomare_resid AND r.code_ostan=r_d.code_ostan AND r.code_anbar=r_d.code_anbar AND r.year=r_d.year
             INNER JOIN resid_kala_detail as r_k_d ON r_k_d.shomare_resid=r_d.shomare_resid AND r_k_d.code_ostan=r_d.code_ostan AND r_k_d.code_anbar=r_d.code_anbar AND r_k_d.year=r_d.year AND r_k_d.code_kala=r_d.code_kala AND r_k_d.code_keshvar=r_d.code_keshvar AND r_k_d.code_tolidkonande=r_d.code_tolidkonande 
			 WHERE r_d.code_kala='$code_kala_' AND r_d.code_ostan='$mt_gl_code_ostan' AND r_d.code_anbar='$mt_gl_code_anbar' AND r_d.year='$mtActiveYear' $Condition2 $Condition_info AND r_d.resid_deleted=0 AND r_k_d.resid_deleted=0 AND r.deleted=0 group by code_ostan,code_anbar,shomare,year)
	        UNION
		   (SELECT code_ostan,code_anbar,year,shomare_barge_tadil,tarikh_barge_tadil,$tadilField,status,2 as type FROM tadil_mojody
             WHERE noe_tadil=1 AND code_kala='$code_kala_' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' $Condition $Condition_info AND deleted=0)
			UNION
	       (SELECT h_d.code_ostan as code_ostan,h_d.code_anbar as code_anbar,h_d.year as year,h_d.shomare_havale_anbar as shomare,h.tarikh_havale_anbar as tarikh,SUM(h_d.$havaleField) as vazn,h.status,3 as type FROM havale_detail h_d 
             INNER JOIN havale as h ON h.shomare_havale_anbar=h_d.shomare_havale_anbar AND h.code_ostan=h_d.code_ostan AND h.code_anbar=h_d.code_anbar AND h.year=h_d.year
			 WHERE h_d.code_kala='$code_kala_' AND h_d.code_ostan='$mt_gl_code_ostan' AND h_d.code_anbar='$mt_gl_code_anbar' AND h_d.year='$mtActiveYear' $Condition3 $Condition_info AND h_d.havale_deleted=0 AND h.deleted=0 group by code_ostan,code_anbar,shomare,year)
		    UNION
		   (SELECT code_ostan,code_anbar,year,shomare_barge_tadil,tarikh_barge_tadil,$tadilField,status,4 as type FROM tadil_mojody
             WHERE noe_tadil=2 AND code_kala='$code_kala_' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' $Condition $Condition_info AND deleted=0) 
			 order by tarikh,type,shomare";    	 
	  $res2=$db->query($q2);
	  if($noe_namayesh_==1) $mande=$mojodyKhalesAval;
	  else if($noe_namayesh_==2) $mande=$mojodyNakhalesAval;
	  else if($noe_namayesh_==3) $mande=$tedadKartonAval;
	  else if($noe_namayesh_==4) $mande=$tedadShaneAval;
	  while($row2=$db->fetch_assoc($res2))
	  {
	   if($row2['status']==0) $vaziyat='جاری';
	   if($row2['status']==1) $vaziyat='ابطالی';
       if($i++%2)echo'<tr class="table-odd"/>';
       else echo'<tr class="table-even"/>';
	   //اضافه کردن صفر پشت کد استان
	   	if(strlen($row2['code_ostan'])==1) $code_a=make_pattern($row2['code_ostan'],2);
        else $code_a=$row2['code_ostan'];
	   echo'
	   	<td>'.$radif++.'</td>
	    <td>'.$row2['tarikh'].'</td>
	    <td>'.$code_a.$row2['code_anbar'].$row2['shomare'].'</td>';
		if($row2['type']==1){
		 echo'<td>رسید</td>
		 	  <td>'.$vaziyat.'</td>
		      <td>'.round($row2['vazn'],3).'</td>
			  <td>-</td>';
			  if($row2['status']==0)$mande+=$row2['vazn'];
		echo'<td>'.round($mande,3).'</td>';
	    }
		if(($row2['type']==2)AND($namayesh_info_!=2)){
		 echo'<td> تعدیل</td>
		 	  <td>'.$vaziyat.'</td>
			  <td>'.round($row2['vazn'],3).'</td>
			  <td>-</td>'; 
			  if($row2['status']==0)$mande+=$row2['vazn'];
	      echo'<td>'.round($mande,3).'</td>';
		}
	    if($row2['type']==3){
		 echo'<td>حواله</td>
		 	  <td>'.$vaziyat.'</td>
		      <td>-</td>
              <td>'.round($row2['vazn'],3).'</td>'; 
			  if($row2['status']==0)$mande-=$row2['vazn'];
	     echo'<td>'.round($mande,3).'</td>';
		}
		if(($row2['type']==4)AND($namayesh_info_!=2)){
		 echo'<td>تعدیل</td>
		 	  <td>'.$vaziyat.'</td>
			  <td>-</td>
			  <td>'.round($row2['vazn'],3).'</td>'; 
			  if($row2['status']==0)$mande-=$row2['vazn'];
	     echo'<td>'.round($mande,3).'</td>';
		 }
		}
	   echo'
	   </tr>';
	   if($line>=$MaxLines && $i <$cntr) 
	   {
	     $line=0;
         $page++;
	     echo'
		 </table>
		   <br class="pbreak">
           <table width="99%" border="1" align="center">
            <tr><td class="print_title_2">'.$mt_gl_owner.'</td></tr>
            <tr><td class="print_title_2"> سردخانه : '.$mt_gl_name_anbar.'&nbsp;&nbsp; استان : '.$mt_gl_name_ostan.'</td></tr>
            <tr><td class="print_title_2">کنترل کاردکس  کالای '.$nameKala.'&nbsp&nbsp(صفحه : '.$page.')
	        	</td>
	        </tr>
           </table>
		   <table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
	        <tr class="print_table-title">
	         <td width="5%">ردیف</td>
	         <td width="12%">تاریخ</td>
	         <td width="12%">شماره</td>
	         <td width="13%">نوع فرم</td>
	         <td width="10%">وضعیت</td>';
	         if($noe_namayesh_==1)//درحالت خالص
	         {
	            echo'<td width="15%">وارده خالص</td>
	                 <td width="15%">صادره خالص</td>
	                 <td width="18%">مانده موجودی خالص کالا</td>';
	         }
	         else if($noe_namayesh_==2)//درحالت ناخالص
	         {
	            echo'<td width="15%">وارده ناخالص</td>
	                 <td width="15%">صادره ناخالص</td>
	                 <td width="18%">مانده موجودی ناخالص کالا</td>';
	         }
             else if($noe_namayesh_==3)//درحالت تعداد کارتن
	         {
	            echo'<td width="15%">تعداد وارده</td>
	                 <td width="15%">تعداد صادره</td>
	                 <td width="18%">تعداد مانده</td>';
	         }
	         else if($noe_namayesh_==4)//درحالت تعداد شانه
	         {
	            echo'
	             <td width="15%">شانه وارده</td>
	             <td width="15%">شانه صادره</td>
	             <td width="18%">شانه مانده</td>';
	        }
           echo'	 
	        </tr>';
	   }	    
	  echo'
	 </table>'; 
echo'
<!--پايان مرکز صفحه -->
<!-- فوتر-->
 <!-- چاپ زیرنویس-->
 <table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
  <tr class="print_footer">
   <td colspan="3">&nbsp;&nbsp;نام کاربر :&nbsp;&nbsp;'.$mtuserNAME.' &nbsp;&nbsp;&nbsp; تاریخ چاپ : '.$today.' &nbsp;&nbsp;&nbsp; ساعت چاپ : '.$logtime.'</td>
  </tr>	
 </table>
</body>
</html>';	
?>