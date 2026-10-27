<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="cardex.php";
$titr='کنترل کاردکس';
echo'
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>'.$titr.'</title>
<link href="styles.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" type="text/css" href="styles/easyui.css">
<link rel="stylesheet" type="text/css" href="styles/easyui-rtl.css"> 
<script type="text/javascript" src="functions.js"></script>
<script type="text/javascript" src="scripts/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="scripts/jquery.easyui.min.js"></script>
<script type="text/javascript" src="scripts/easyui-rtl.js"></script> 	
</head>';
/***************************************** MAIN*****************************************/
echo'
<body onload="document.myform.code_kala.focus();">
<form method="post" name="myform">
<div align="center">
<table width="99%" height="100%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr>
  <td class="title">'.$titr.'</td>	 
 </tr>
 <!--پايان هدر-->
 <!-- مرکز صفحه-->
 <tr>
  <td height="100%">
   <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
    <tr class="tr1">
	 <td style="border-bottom:1px solid #333;">
	  <table align="center" width="100%">
	   <tr>
        <td align="left"><span class="star">*</span> کد کالا :&nbsp;</td>
        <td align="right">&nbsp;<input type="text" class="textboxme2" value="'.$code_kala.'" name="code_kala" onkeypress="return isNumber(event)" onKeyUp="F10desc(event)" style="width:50px;"/>&nbsp;';
	     include ("img_helpkala.php");
        echo'
	    </td>
	    <td align="left" > کد کشور :&nbsp;</td>
	    <td align="right"><input class="textboxme2" type="text" name="code_keshvar" value="'.$code_keshvar.'" onkeypress="return isNumber(event)" onfocus="getDetailKeshvar(this.value);" onblur="getDetailKeshvar(this.value);" style="width:50px"/>&nbsp;';
         include ("img_helpkeshvar.php");
	    echo'
	    </td>
	    <td align="left"> کد تولیدکننده :&nbsp;</td><td align="right"><input class="textboxme2 textbox50" type="text" name="code_tolidkonande" value="'.$code_tolidkonande.'" onkeypress="return isNumber(event)" onfocus="getDetailTolid(this.value);" onblur="getDetailTolid(this.value);"/>&nbsp;';
		 include('img_helptolid.php');
		echo'
        </td>
	    <td align="left"> کد کارتن/ قوطی :&nbsp;</td><td align="right"><input type="text" class="textboxme2 textbox50" name="code_karton" id="code_karton" value="'.$code_karton.'" onfocus="getVaznKarton(this.value)" onblur="getVaznKarton(this.value)" onkeypress="return isNumber(event)"/>&nbsp;';
		 include('img_helpkartonghooti.php');
		echo'
		</td>
	    <td align="left">تاریخ ماندگاری :&nbsp;</td><td align="right" >'.listbox("code_mandegari",$code_mandegari,"code_mandegari","sharh_mandegari","tarikh_mandegari","","class='easyui-combobox text4' style=width:100px","").'</td>
       </tr>
       <tr>	   
	    <td align="left"> تاریخ تولید شمسی :&nbsp;</td>
		<td align="right" colspan="3">
		        سال : <input class="textboxme2 textbox50" type="text" name="sal_tolid_shamsi" value="'.$sal_tolid_shamsi.'" maxlength="4" placeholder=" '.$mtActiveYear.'" onkeypress="return isNumber(event)"/>
		       	<img border="0" src="images/Info1.png" title="لطفاً سال موردنظر خود را در 4 رقم وارد نمایید" onmouseOver="this.src=\'images/Info_h.png\'" onmouseOut="this.src=\'images/Info1.png\'" style="width:16px;height:16px;cursor:pointer"/>
			    ماه : '.static_listbox("mah_tolid_shamsi",$mah_tolid_shamsi,"mahshamsiArr",1,"class='easyui-combobox text4' style=width:100px").'
			    روز : <input class="textboxme2 textbox50" type="text" name="rouz_tolid_shamsi" value="'.$rouz_tolid_shamsi.'" maxlength="2" onkeypress="return isNumber(event)"/>
		</td>
		<td align="left"> زیرانبار :&nbsp;</td>
	    <td align="right">'.listbox_ziranbar("code_ziranbar",$code_ziranbar,"code_ziranbar","name_ziranbar","list_sardkhane_detail","1=1 AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' ORDER BY name_ziranbar ASC","class='easyui-combobox text4' style=width:100px","").'</td>
	    <td align="left"><span class="star">*</span>  نمایش اطلاعات :&nbsp;</td>
		<td align="right">'.static_listbox("noe_namayesh",$noe_namayesh,"namayeshArr",1,"class='easyui-combobox text4' style=width:100px data-options=panelHeight:125").'</td>
	    <td align="left"> نمایش :</td><td align="right" >&nbsp;
		'.static_listbox("namayesh_info",$namayesh_info,"namayesh_infoArr",1,"class='easyui-combobox text4' style=width:100px").'
		</td>	
       </tr>  
	   <tr class="tr1" > 
		<td align="center" colspan="10"><input class="buttonme" type="submit" name="ok" value="شروع گزارش"></td>';
	    if($code_kala)echo'<td align="center" width="100px"><div onClick="window.open(\'print_cardex.php?code_kala_='.$code_kala.'&code_keshvar_='.$code_keshvar.'&code_tolidkonande_='.$code_tolidkonande.'&code_karton_='.$code_karton.'&sal_tolid_shamsi_='.$sal_tolid_shamsi.'&mah_tolid_shamsi_='.$mah_tolid_shamsi.'&rouz_tolid_shamsi_='.$rouz_tolid_shamsi.'&code_ziranbar_='.$code_ziranbar.'&noe_namayesh_='.$noe_namayesh.'&code_mandegari_='.$code_mandegari.'&namayesh_info='.$namayesh_info.'\',\'_blank\',\'scrollbars=yes\')" id="printer_T" title="چاپ کاردکس"><a href="#"></a></div></td>';
		else echo '<td width="100px">&nbsp;</td>';
	   echo'
	   </tr>
	  </table>
	 </td>
	</tr>';
    if($ok)
	{	 
        IF($namayesh_info==2){$table_mojody='mojody_kala_gomrok'; $Condition_info=" AND noe_tahvil_bar=9";}
        ELSE {$table_mojody='mojody_kala'; $Condition_info=" AND noe_tahvil_bar!=9";}
		if($code_keshvar) 
		{
		 $Condition.=" AND code_keshvar='$code_keshvar'";
		 $Condition2.=" AND r_k_d.code_keshvar='$code_keshvar'";
		 $Condition3.=" AND h_d.code_keshvar='$code_keshvar'";
		}
	    if($code_tolidkonande) 
		{
		 $Condition.=" AND code_tolidkonande='$code_tolidkonande'";
		 $Condition2.=" AND r_k_d.code_tolidkonande='$code_tolidkonande'";
		 $Condition3.=" AND h_d.code_tolidkonande='$code_tolidkonande'";
		}
	    if($code_karton) 
		{
		 $Condition.=" AND code_karton='$code_karton'";
		 $Condition2.=" AND r_k_d.code_karton='$code_karton'";
		 $Condition3.=" AND h_d.code_karton='$code_karton'";
		}
	    if($sal_tolid_shamsi) 
		{
		 $Condition.=" AND sal_tolid_shamsi='$sal_tolid_shamsi'";
		 $Condition2.=" AND r_k_d.sal_tolid_shamsi='$sal_tolid_shamsi'";
		 $Condition3.=" AND h_d.sal_tolid_shamsi='$sal_tolid_shamsi'";
		}
	    if($mah_tolid_shamsi) 
		{
		 $Condition.=" AND mah_tolid_shamsi='$mah_tolid_shamsi'";
		 $Condition2.=" AND r_k_d.mah_tolid_shamsi='$mah_tolid_shamsi'";
		 $Condition3.=" AND h_d.mah_tolid_shamsi='$mah_tolid_shamsi'";
		}
	    if($rouz_tolid_shamsi) 
		{
		 $Condition.=" AND rouz_tolid_shamsi='$rouz_tolid_shamsi'";
		 $Condition2.=" AND r_k_d.rouz_tolid_shamsi='$rouz_tolid_shamsi'";
		 $Condition3.=" AND h_d.rouz_tolid_shamsi='$rouz_tolid_shamsi'";
		}
	    if($code_ziranbar) 
		{
		 $Condition.=" AND code_ziranbar='$code_ziranbar'";
		 $Condition2.=" AND r_k_d.code_ziranbar='$code_ziranbar'";
		 $Condition3.=" AND h_d.code_ziranbar='$code_ziranbar'";
		}
		if($code_mandegari) 
		{
		 $Condition.=" AND code_mandegari='$code_mandegari'";
		 $Condition2.=" AND r_k_d.code_mandegari='$code_mandegari'";
		 $Condition3.=" AND h_d.code_mandegari='$code_mandegari'";
		}
		$nameKala=$db->get_from_where("name_kala","kala","code_kala='$code_kala'");     
        $tedadKartonAval=$db->get_from_where("SUM(tedad_karton_aval)","$table_mojody","code_kala='$code_kala' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' $Condition AND deleted=0");     
        $tedadShaneAval=$db->get_from_where("SUM(tedad_shane_aval)","$table_mojody","code_kala='$code_kala' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' $Condition AND deleted=0");     
		$mojodyNakhalesAval=$db->get_from_where("SUM(mojody_nakhales_aval)","$table_mojody","code_kala='$code_kala' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' $Condition AND deleted=0");     
        $mojodyKhalesAval=$db->get_from_where("SUM(mojody_khales_aval)","$table_mojody","code_kala='$code_kala' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' $Condition AND deleted=0");     
		$tedadKarton=$db->get_from_where("SUM(tedad_karton)","$table_mojody","code_kala='$code_kala' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' $Condition AND deleted=0");     
	    if($code_kala==50) $tedadShane=$tedadKarton*$_SESSION["mtShane"];
	    if($code_kala==54) $tedadShane=$tedadKarton*$_SESSION["mtShane_dakheli"];
		$mojodyNakhales=$db->get_from_where("SUM(mojody_nakhales)","$table_mojody","code_kala='$code_kala' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' $Condition AND deleted=0");     
	    $mojodyKhales=$db->get_from_where("SUM(mojody_khales)","$table_mojody","code_kala='$code_kala' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' $Condition AND deleted=0");     
	    //echo "select SUM(mojody_khales) from $table_mojody where code_kala='$code_kala' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' $Condition AND deleted=0";     
		//مجموع تعداد کارتن و وزن ناخالص و وزن خالص  وارده
		 $q_varede="SELECT SUM(tedad_karton_r_d_sub),SUM(vazn_nakhales_r_d_sub),SUM(vazn_khales_r_d_sub),SUM(tedad_shane_r_d_sub) FROM resid_kala_detail r_k_d
		            INNER JOIN resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year
		            WHERE r_k_d.code_kala='$code_kala' AND r_k_d.code_ostan='$mt_gl_code_ostan' AND r_k_d.code_anbar='$mt_gl_code_anbar' AND r_k_d.year='$mtActiveYear' $Condition $Condition_info AND resid_deleted=0 AND r_k_d.status=0";
		 $res_varede=$db->query($q_varede);
		 $row_varede=$db->fetch_array($res_varede);
		 $jameKartonVarede=$row_varede[0];$jameNaKhalesVarede=$row_varede[1];$jameKhalesVadere=$row_varede[2];$jameShaneVarede=$row_varede[3];
		//مجموع تعداد کارتن و وزن ناخالص و وزن خالص  وارده جابه جایی
         $q_varede_j="SELECT SUM(tedad_karton_r_d_sub),SUM(vazn_nakhales_r_d_sub),SUM(vazn_khales_r_d_sub),SUM(tedad_shane_r_d_sub) FROM resid_kala_detail r_k_d 
		              INNER JOIN resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year
		              WHERE (r.noe_tahvil_bar=4 OR r.noe_tahvil_bar=5) AND r_k_d.code_kala='$code_kala' AND r_k_d.code_ostan='$mt_gl_code_ostan' AND r_k_d.code_anbar='$mt_gl_code_anbar' AND r_k_d.year='$mtActiveYear' $Condition2  AND r_k_d.resid_deleted=0 AND r_k_d.status=0";
		 $res_varede_j=$db->query($q_varede_j);
		 $row_varede_j=$db->fetch_array($res_varede_j);
		 $varedeKarton_jabejae=$row_varede_j[0];$varedeNaKhales_jabejae=$row_varede_j[1];$varedeKhales_jabejae=$row_varede_j[2];$varedeShane_jabejae=$row_varede_j[3];//$jameKhalesSadere=$row_varede[2];
		//مجموع تعداد کارتن و وزن ناخالص و وزن خالص  وارده خرید قطعی
         $q_varede_kh="SELECT SUM(tedad_karton_r_d_sub),SUM(vazn_nakhales_r_d_sub),SUM(vazn_khales_r_d_sub),SUM(tedad_shane_r_d_sub) FROM resid_kala_detail r_k_d 
		              INNER JOIN resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year
		              WHERE (r.noe_tahvil_bar=1 OR r.noe_tahvil_bar=2 OR r.noe_tahvil_bar=3) AND r_k_d.code_kala='$code_kala' AND r_k_d.code_ostan='$mt_gl_code_ostan' AND r_k_d.code_anbar='$mt_gl_code_anbar' AND r_k_d.year='$mtActiveYear' $Condition2 AND r_k_d.resid_deleted=0 AND r_k_d.status=0";
		 $res_varede_kh=$db->query($q_varede_kh);
		 $row_varede_kh=$db->fetch_array($res_varede_kh);
		 $varedeKarton_kharid=$row_varede_kh[0];$varedeNaKhales_kharid=$row_varede_kh[1];$varedeKhales_kharid=$row_varede_kh[2];$varedeShane_kharid=$row_varede_kh[3];//
		//مجموع تعداد کارتن و وزن ناخالص و وزن خالص صادره
         $q_sadere="SELECT SUM(tedad_karton_h_d),SUM(vazn_nakhales_h_d),SUM(vazn_khales_h_d),SUM(tedad_shane_h_d) FROM havale_detail h_d INNER JOIN havale h
		            ON h_d.shomare_havale_anbar=h.shomare_havale_anbar AND h_d.code_ostan=h.code_ostan AND h_d.code_anbar=h.code_anbar AND h_d.year=h.year  WHERE h_d.code_kala='$code_kala' AND h_d.code_ostan='$mt_gl_code_ostan' AND h_d.code_anbar='$mt_gl_code_anbar' AND h_d.year='$mtActiveYear' $Condition $Condition_info AND havale_deleted=0 AND h_d.status=0";
 		 $res_sadere=$db->query($q_sadere);
		 $row_sadere=$db->fetch_array($res_sadere);
		 $jameKartonSadere=$row_sadere[0];$jameNaKhalesSadere=$row_sadere[1];$jameKhalesSadere=$row_sadere[2];$jameShaneSadere=$row_sadere[3];
		//مجموع تعداد کارتن و وزن ناخالص و وزن خالص صادره در حالت جابه جایی
		 $q_sadere_j="SELECT SUM(tedad_karton_h_d),SUM(vazn_nakhales_h_d),SUM(vazn_khales_h_d),SUM(tedad_shane_h_d) FROM havale_detail h_d INNER JOIN havale h
		              ON h_d.shomare_havale_anbar=h.shomare_havale_anbar AND h_d.code_ostan=h.code_ostan AND h_d.code_anbar=h.code_anbar AND h_d.year=h.year 
		 	          WHERE (h.noe_tahvil_bar=4 OR h.noe_tahvil_bar=5) AND h_d.code_kala='$code_kala' AND h_d.code_ostan='$mt_gl_code_ostan' AND h_d.code_anbar='$mt_gl_code_anbar' AND h_d.year='$mtActiveYear' $Condition3  $Condition_info AND h_d.havale_deleted=0 AND h_d.status=0";
		 $res_sadere_j=$db->query($q_sadere_j);
		 $row_sadere_j=$db->fetch_array($res_sadere_j);
		 $sadereKarton_jabejae=$row_sadere_j[0];$sadereNaKhales_jabejae=$row_sadere_j[1];$sadereKhales_jabejae=$row_sadere_j[2];$sadereShane_jabejae=$row_sadere_j[3];
		IF($namayesh_info!=2)
		{
		 //مجموع تعداد کارتن و وزن ناخالص و وزن خالص تعدیل اضافه	 		
		 $q_tadil_ezafe="SELECT SUM(tedad_karton_tadil),SUM(meghdar_nakhales_tadil),SUM(meghdar_khales_tadil),SUM(tedad_shane_tadil) FROM tadil_mojody WHERE noe_tadil=1 AND code_kala='$code_kala' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' $Condition $Condition_info AND status=0 AND deleted=0";
	     $res_tadil_ezafe=$db->query($q_tadil_ezafe);
		 $row_tadil_ezafe=$db->fetch_array($res_tadil_ezafe);
		 $kartonTadilEzafe=$row_tadil_ezafe[0];$nakhalesTadilEzafe=$row_tadil_ezafe[1];$khalesTadilEzafe=$row_tadil_ezafe[2];$shaneTadilEzafe=$row_tadil_ezafe[3];
		 //مجموع تعداد کارتن و وزن ناخالص و وزن خالص تعدیل کسری	
		 $q_tadil_kasry="SELECT SUM(tedad_karton_tadil),SUM(meghdar_nakhales_tadil),SUM(meghdar_khales_tadil),SUM(tedad_shane_tadil) FROM tadil_mojody WHERE noe_tadil=2 AND code_kala='$code_kala' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' $Condition $Condition_info AND status=0 AND deleted=0";
	     $res_tadil_kasry=$db->query($q_tadil_kasry);
		 $row_tadil_kasry=$db->fetch_array($res_tadil_kasry);
		 $kartonTadilKasry=$row_tadil_kasry[0];$nakhalesTadilKasry=$row_tadil_kasry[1];$khalesTadilKasry=$row_tadil_kasry[2];$shaneTadilKasry=$row_tadil_kasry[3];		
	    }
	//}
	$radif=1;
	echo'
	<tr class="tr1">
	 <td>
	  <table width="100%" border=0>
	   <tr>	
 	    <td align="left"> نام کالا : </td>
        <td align="right" colspan="4">&nbsp;<input type="text" readonly class="textboxme" name="name_kala" value="'.$nameKala.'" style="width:420px"/></td>
	   </tr>
	   <tr> 
        <td align="left"> تعداد اول دوره : </td>
        <td align="right">&nbsp;<input type="text" readonly class="textboxme2" name="tedad_karton_aval" value="'.virgul($tedadKartonAval).'"/></td>';
        IF(($code_kala==50)OR($code_kala==54)){
		 echo'
		 <td align="left"> شانه اول دوره : </td>
         <td align="right">&nbsp;<input type="text" readonly class="textboxme2" name="tedad_shane_aval" value="'.virgul($tedadShaneAval).'"/></td>';
		}
        echo'
		<td align="left"> موجودی ناخالص اول دوره : </td>
        <td align="right">&nbsp;<input type="text" readonly class="textboxme2" name="tedad_karton_aval" value="'.round($mojodyNakhalesAval,3).'"/></td>
        <td align="left"> موجودی خالص اول دوره : </td>
        <td align="right">&nbsp;<input type="text" readonly class="textboxme2" name="mojody_aval" value="'.round($mojodyKhalesAval,3).'"/></td>
	   </tr>
       <tr class="tr1">
        <td align="left"> تعداد فعلی : </td>
        <td align="right">&nbsp;<input type="text" readonly class="textboxme2" name="tedad_karton" value="'.virgul($tedadKarton).'"/></td>';
        IF(($code_kala==50)OR($code_kala==54)){
		echo'
		 <td align="left"> شانه فعلی : </td>
         <td align="right">&nbsp;<input type="text" readonly class="textboxme2" name="tedad_shane" value="'.virgul($tedadShane).'"/></td>';
        }
		echo'
		<td align="left"> موجودی ناخالص فعلی : </td>
        <td align="right">&nbsp;<input type="text" readonly class="textboxme2" name="mojody_nakhales" value="'.round($mojodyNakhales,3).'"/></td>
	    <td align="left"> موجودی خالص فعلی : </td>
        <td align="right">&nbsp;<input type="text" readonly class="textboxme2"  name="mojody_khales" value="'.round($mojodyKhales,3).'"/></td>   
	   </tr>
	   <tr class="tr1">
        <td align="left"> جمع تعداد وارده : </td>
        <td align="right">&nbsp;<input type="text" readonly class="textboxme2" name="jameKhalesVarede" value="'.virgul($jameKartonVarede).'"/></td>';
        IF(($code_kala==50)OR($code_kala==54)){
		 echo'
		 <td align="left"> جمع شانه وارده : </td>
         <td align="right">&nbsp;<input type="text" readonly class="textboxme2" name="jameKhalesVarede" value="'.virgul($jameShaneVarede).'"/></td>';
        }
		echo'
		<td align="left"> جمع مقدار ناخالص وارده : </td>
        <td align="right">&nbsp;<input type="text" readonly class="textboxme2" name="jameKhalesVarede" value="'.round($jameNaKhalesVarede,3).'"/></td>
        <td align="left"> جمع مقدار خالص وارده : </td>
        <td align="right">&nbsp;<input type="text" readonly class="textboxme2" name="jameKhalesVarede" value="'.round($jameKhalesVadere,3).'"/></td>    
	   </tr>';
	   IF($namayesh_info!=2)
	   {
	     echo'   
	      <tr class="tr1">
           <td align="left"> تعداد وارده (خرید) : </td>
           <td align="right">&nbsp;<input type="text" readonly class="textboxme2" name="jameKhalesVarede" value="'.virgul($varedeKarton_kharid).'"/></td>';
           IF(($code_kala==50)OR($code_kala==54)){
	      echo'
	      <td align="left"> شانه وارده (خرید) : </td>
            <td align="right">&nbsp;<input type="text" readonly class="textboxme2" name="jameKhalesVarede" value="'.virgul($varedeShane_kharid).'"/></td>';
           }
	     echo'
	     <td align="left"> مقدار ناخالص وارده (خرید) : </td>
           <td align="right">&nbsp;<input type="text" readonly class="textboxme2" name="jameKhalesVarede" value="'.round($varedeNaKhales_kharid,3).'"/></td>
           <td align="left"> مقدار خالص وارده (خرید) : </td>
           <td align="right">&nbsp;<input type="text" readonly class="textboxme2" name="jameKhalesVarede" value="'.round($varedeKhales_kharid,3).'"/></td>    
	      </tr>
	      <tr class="tr1">
           <td align="left"> تعداد وارده (جابه جایی) : </td>
           <td align="right">&nbsp;<input type="text" readonly class="textboxme2" name="sadere_jabejae" value="'.virgul($varedeKarton_jabejae).'"/></td>';
	       IF(($code_kala==50)OR($code_kala==54)){
	      echo'
	      <td align="left"> شانه وارده (جابه جایی) : </td>
          <td align="right">&nbsp;<input type="text" readonly class="textboxme2" name="sadere_jabejae" value="'.virgul($varedeShane_jabejae).'"/></td>';
	    }
		echo'
		<td align="left"> مقدار ناخالص وارده (جابه جایی) : </td>
        <td align="right">&nbsp;<input type="text" readonly class="textboxme2" name="sadere_jabejae" value="'.round($varedeNaKhales_jabejae,3).'"/></td>
	    <td align="left"> مقدار خالص وارده (جابه جایی) : </td>
        <td align="right">&nbsp;<input type="text" readonly class="textboxme2" name="sadere_jabejae" value="'.round($varedeKhales_jabejae,3).'"/></td>
	   </tr>';
	   }
	   echo'
	   <tr class="tr1">
        <td align="left"> جمع تعداد صادره : </td>
		<td align="right">&nbsp;<input type="text" readonly class="textboxme2" name="jameKhalesSadere" value="'.virgul($jameKartonSadere).'"/></td>';
        IF(($code_kala==50)OR($code_kala==54)){
		 echo'
		 <td align="left"> جمع شانه صادره : </td>
		 <td align="right">&nbsp;<input type="text" readonly class="textboxme2" name="jameKhalesSadere" value="'.virgul($jameShaneSadere).'"/></td>';
        }
		echo'
		<td align="left"> جمع مقدار ناخالص صادره : </td>
		<td align="right">&nbsp;<input type="text" readonly class="textboxme2" name="jameKhalesSadere" value="'.round($jameNaKhalesSadere,3).'"/></td>
        <td align="left"> جمع مقدار خالص صادره : </td>
        <td align="right">&nbsp;<input type="text" readonly class="textboxme2" name="jameKhalesSadere" value="'.round($jameKhalesSadere,3).'"/></td>
       </tr>
	   <tr class="tr1">
        <td align="left"> تعداد صادره (جابه جایی) : </td>
        <td align="right">&nbsp;<input type="text" readonly class="textboxme2" name="sadere_jabejae" value="'.virgul($sadereKarton_jabejae).'"/></td>';
	    IF(($code_kala==50)OR($code_kala==54)){
		 echo'
		 <td align="left"> شانه صادره (جابه جایی) : </td>
         <td align="right">&nbsp;<input type="text" readonly class="textboxme2" name="sadere_jabejae" value="'.virgul($sadereShane_jabejae).'"/></td>';
	    }
		echo'
		<td align="left"> مقدار ناخالص صادره (جابه جایی) : </td>
        <td align="right">&nbsp;<input type="text" readonly class="textboxme2" name="sadere_jabejae" value="'.round($sadereNaKhales_jabejae,3).'"/></td>
	    <td align="left"> مقدار خالص صادره (جابه جایی) : </td>
        <td align="right">&nbsp;<input type="text" readonly class="textboxme2" name="sadere_jabejae" value="'.round($sadereKhales_jabejae,3).'"/></td>
	   </tr>';
	   IF($namayesh_info!=2)
	   {
	    echo'
	    <tr class="tr1">
		  <td align="left"> تعداد تعدیل (اضافه) : </td>
		  <td align="right">&nbsp;<input type="text" readonly class="textboxme2" name="kartonTadilEzafe" value="'.virgul($kartonTadilEzafe).'"/></td>';
	     IF(($code_kala==50)OR($code_kala==54)){
		   echo'	
		   <td align="left"> شانه تعدیل (اضافه) : </td>
		   <td align="right">&nbsp;<input type="text" readonly class="textboxme2" name="kartonTadilEzafe" value="'.virgul($shaneTadilEzafe).'"/></td>';
		  }
		  echo'
		  <td align="left"> مقدار ناخالص تعدیل (اضافه) : </td>
		  <td align="right">&nbsp;<input type="text" readonly class="textboxme2" name="nakhalesTadilEzafe" value="'.round($nakhalesTadilEzafe,3).'"/></td>
		  <td align="left"> مقدارخالص تعدیل (اضافه) : </td>
         <td align="right">&nbsp;<input type="text" readonly class="textboxme2" name="khalesTadilEzafe" value="'.round($khalesTadilEzafe,3).'"/></td>
	    </tr>
	    <tr class="tr1">
		  <td align="left"> تعداد تعدیل (کسری) : </td>
		  <td align="right">&nbsp;<input type="text" readonly class="textboxme2" name="kartonTadilKasry" value="'.virgul($kartonTadilKasry).'"/></td>';
		  IF(($code_kala==50)OR($code_kala==54)){
		   echo'
		   <td align="left"> شانه تعدیل (کسری) : </td>
		   <td align="right">&nbsp;<input type="text" readonly class="textboxme2" name="kartonTadilKasry" value="'.virgul($shaneTadilKasry).'"/></td>';
		  }
		  echo'
		  <td align="left"> مقدار ناخالص تعدیل (کسری) : </td>
		  <td align="right">&nbsp;<input type="text" readonly class="textboxme2" name="nakhalesTadilKasry" value="'.round($nakhalesTadilKasry,3).'"/></td>
		  <td align="left"> مقدارخالص تعدیل (کسری) : </td>
         <td align="right">&nbsp;<input type="text" readonly class="textboxme2" name="khalesTadilKasry" value="'.round($khalesTadilKasry,3).'"/></td>
	    </tr>';
	  }
	  echo'
	  
	  </table>
	 </td>
	</tr>
   </table>
   <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">   
	<tr class="table-title">
	 <td width="5%">ردیف</td>
	 <td width="12%">تاریخ</td>
	 <td width="12%">شماره</td>
	 <td width="13%">نوع فرم</td>
	 <td width="10%">وضعیت</td>';
	 if($noe_namayesh==1)//درحالت خالص
	 {
	    echo'<td width="15%">وارده خالص</td>
	         <td width="15%">صادره خالص</td>
	         <td width="18%">مانده موجودی خالص کالا</td>';
	 }
	 else if($noe_namayesh==2)//درحالت ناخالص
	 {
	    echo'<td width="15%">وارده ناخالص</td>
	         <td width="15%">صادره ناخالص</td>
	         <td width="18%">مانده موجودی ناخالص کالا</td>';
	 }
     else if($noe_namayesh==3)//درحالت تعداد کارتن
	 {
	    echo'<td width="15%">تعداد وارده</td>
	         <td width="15%">تعداد صادره</td>
	         <td width="18%">تعداد مانده</td>';
	 }
	 else if($noe_namayesh==4)//درحالت تعداد شانه
	 {
	  echo'
	    <td width="15%">شانه وارده</td>
	    <td width="15%">شانه صادره</td>
	    <td width="18%">شانه مانده</td>';
	 }	
	echo'
	</tr>';	
	//تعیین فیلدها براساس نوع نمایش
    IF($noe_namayesh==1){$avalField='mojody_khales_aval';$residField='vazn_khales_r_d_sub';$havaleField='vazn_khales_h_d';$tadilField='meghdar_khales_tadil';}
    ELSE IF($noe_namayesh==2){$avalField='mojody_nakhales_aval';$residField='vazn_nakhales_r_d_sub';$havaleField='vazn_nakhales_h_d';$tadilField='meghdar_nakhales_tadil';}
    ELSE IF($noe_namayesh==3){$avalField='tedad_karton_aval';$residField='tedad_karton_r_d_sub';$havaleField='tedad_karton_h_d';$tadilField='tedad_karton_tadil';}
    ELSE IF($noe_namayesh==4){$avalField='tedad_shane_aval';$residField='tedad_shane_r_d_sub';$havaleField='tedad_shane_h_d';$tadilField='tedad_shane_tadil';} 
	  $i=0;	
	  $q2="(SELECT r_d.code_ostan as code_ostan,r_d.code_anbar as code_anbar,r_d.year as year,r_d.shomare_resid as shomare,r.tarikh_resid as tarikh,SUM(r_k_d.$residField) as vazn,r.status,1 as type FROM resid_detail as r_d
             INNER JOIN resid as r ON r.shomare_resid=r_d.shomare_resid AND r.code_ostan=r_d.code_ostan AND r.code_anbar=r_d.code_anbar AND r.year=r_d.year
             INNER JOIN resid_kala_detail as r_k_d ON r_k_d.shomare_resid=r_d.shomare_resid AND r_k_d.code_ostan=r_d.code_ostan AND r_k_d.code_anbar=r_d.code_anbar AND r_k_d.year=r_d.year AND r_k_d.code_kala=r_d.code_kala AND r_k_d.code_keshvar=r_d.code_keshvar AND r_k_d.code_tolidkonande=r_d.code_tolidkonande 
			 WHERE r_d.code_kala='$code_kala' AND r_d.code_ostan='$mt_gl_code_ostan' AND r_d.code_anbar='$mt_gl_code_anbar' AND r_d.year='$mtActiveYear' $Condition2 $Condition_info AND r_d.resid_deleted=0 AND r_k_d.resid_deleted=0 AND r.deleted=0 group by code_ostan,code_anbar,shomare,year)
	        UNION
		   (SELECT code_ostan,code_anbar,year,shomare_barge_tadil,tarikh_barge_tadil,$tadilField,status,2 as type FROM tadil_mojody
             WHERE noe_tadil=1 AND code_kala='$code_kala' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' $Condition $Condition_info AND deleted=0)
			UNION
	       (SELECT h_d.code_ostan as code_ostan,h_d.code_anbar as code_anbar,h_d.year as year,h_d.shomare_havale_anbar as shomare,h.tarikh_havale_anbar as tarikh,SUM(h_d.$havaleField) as vazn,h.status,3 as type FROM havale_detail h_d 
             INNER JOIN havale as h ON h.shomare_havale_anbar=h_d.shomare_havale_anbar AND h.code_ostan=h_d.code_ostan AND h.code_anbar=h_d.code_anbar AND h.year=h_d.year
			 WHERE h_d.code_kala='$code_kala' AND h_d.code_ostan='$mt_gl_code_ostan' AND h_d.code_anbar='$mt_gl_code_anbar' AND h_d.year='$mtActiveYear' $Condition3 $Condition_info AND h_d.havale_deleted=0 AND h.deleted=0 group by code_ostan,code_anbar,shomare,year)
		    UNION
		   (SELECT code_ostan,code_anbar,year,shomare_barge_tadil,tarikh_barge_tadil,$tadilField,status,4 as type FROM tadil_mojody
             WHERE noe_tadil=2 AND code_kala='$code_kala' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' $Condition $Condition_info AND deleted=0) 
			 order by tarikh,type,shomare";    	 
	  $res2=$db->query($q2);
	  if($noe_namayesh==1) $mande=$mojodyKhalesAval;
	  else if($noe_namayesh==2) $mande=$mojodyNakhalesAval;
	  else if($noe_namayesh==3) $mande=$tedadKartonAval;
	  else if($noe_namayesh==4) $mande=$tedadShaneAval;
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
		if(($row2['type']==2)AND($namayesh_info!=2)){
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
		if(($row2['type']==4)AND($namayesh_info!=2)){
		 echo'<td>تعدیل</td>
		 	  <td>'.$vaziyat.'</td>
			  <td>-</td>
			  <td>'.round($row2['vazn'],3).'</td>'; 
			  if($row2['status']==0)$mande-=$row2['vazn'];
	     echo'<td>'.round($mande,3).'</td>';
		 }
		}
	   echo'
	   </tr>
	  </table>
   </div>
  </td>
 </tr> 
<!--پايان مرکز صفحه -->
<!-- فوتر-->
<tr class="footer">
 <td>
  <table width="100%"  border="0" cellspacing="0" cellpadding="0" height=100%  style="margin-bottom:20px;">    			
   <tr><td width="10px">&nbsp;</td></tr>
  </table>
 </td>
</tr>
<!-- پايان فوتر-->';
}//END ok
echo'	
</table>
</div>
</form>
</body>
</html>';	
?>