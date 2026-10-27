<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="cardex_jabejae.php";
 //$test=12345678.8945;
 // $test=1000;
// // echo ($test).'<br/>';
 // echo virgul($test,0,',').'<br/>';
 // echo virgul(round($test,3),0,',').'<br/>';
// // echo virgul($test,3,',').'<br/>';
 // echo number_format($test,3).'<br/>';
 // echo number_format_clean($test,3);
$titr='کنترل کاردکس مجوز جابه جایی';
echo'
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>'.$titr.'</title>
<link href="styles.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="functions.js"></script>
</head>';
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.shomare_jabejae.focus();">
<form method="post" name="myform">
<div align="center">
<table width="99%" height="100%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr>
  <td class="title">کنترل کاردکس مجوز جابه جایی</td>	 
 </tr>
 <!--پايان هدر-->
<!-- مرکز صفحه-->
 <tr>
  <td height="100%">
   <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
	<tr class="tr1">
     <td align="left" width="150px"> شماره مجوز جابه جایی : </td>
     <td align="right" colspan="2">&nbsp;<input type="text" class="textboxme" name="shomare_jabejae" value="'.$shomare_jabejae.'"/>&nbsp;';
      include ("img_helpjabejae_report.php");
	  echo'
	  </td>
	  <td align="right" colspan="4"><input type="submit" class="buttonme" name="ok" value="شروع گزارش"></td>';
	  if($shomare_jabejae)echo'<td align="center"><div onClick="window.open(\'print_cardex_jabejae.php?shomare_jabejae_='.$shomare_jabejae.'\',\'_blank\',\'scrollbars=yes\')" id="printer_T" title="چاپ کاردکس جابه جایی"><a href="#"></a></div></td>';
	  else echo '<td>&nbsp;</td>';
	echo'
	</tr>'; 
	if($ok)
	{
	 $q1="SELECT *,
	       (SELECT name_kala FROM kala WHERE code_kala=m_j.code_kala)nameKala, 
	       (SELECT code_bastebandy FROM kala WHERE code_kala=m_j.code_kala)codeBastebandy, 
	       (SELECT name_customer FROM moshtary WHERE code_customer=m_j.code_customer)nameCustomer, 
	       (SELECT name_ostan FROM ostan WHERE code_ostan=m_j.code_ostan)ostanMabda, 
	       (SELECT name_anbar FROM list_sardkhane WHERE code_anbar=m_j.code_anbar AND code_ostan='$mt_gl_code_ostan')anbarMabda,
           (SELECT name_ostan FROM ostan WHERE code_ostan=m_j.code_ostan_maghsad_j)ostanMaghsad,
	       (SELECT name_anbar FROM list_sardkhane WHERE code_anbar=m_j.code_anbar_maghsad_j AND code_ostan=m_j.code_ostan_maghsad_j)anbarMaghsad,		   
           (SELECT SUM(meghdar_batele_j) FROM ebtal_jabejae WHERE shomare_jabejae=m_j.shomare_jabejae AND code_ostan=m_j.code_ostan AND code_anbar=m_j.code_anbar AND year=m_j.year AND deleted=0)meghdar_batele_j 
	       FROM mojavez_jabejae as m_j WHERE shomare_jabejae='$shomare_jabejae' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0";	
	   $res1 = $db->query($q1);
	   $row1=$db->fetch_assoc($res1);
	}
    //محاسبه مقدار تحویلی از مجوز جابه جایی با استفاده از تابع
	 $meghdar_tahvily_j=tahvily_az_jabejae($row1['shomare_jabejae'],$row1['code_ostan'],$row1['code_anbar'],$row1['year'],$row1['codeBastebandy'],$row1['code_kala']);
	echo'
	<tr class="tr1">
	 <td align="left"> کد کالا : </td>
     <td align="right">&nbsp;<input type="text" readonly class="textboxme" name="code_kala" value="'.$row1['code_kala'].'"/></td>
	 <td align="left"> نام کالا : </td>
     <td align="right" colspan="3">&nbsp;<input type="text" readonly class="textboxme" name="name_kala" value="'.$row1['nameKala'].'"  style="width:95%"/></td>
     <td colspan="2" align="right">'; 
     if($row1['codeBastebandy']==2)echo'<span class="rahnama">(تعداد قوطی)</span>';
	 else if(($row1['code_kala']==50)or($row1['code_kala']==54))echo'<span class="rahnama">(تعداد شانه)</span>';
	 else echo'<span class="rahnama">(کیلوگرم)</span>';
	 echo'</td>
	</tr>
	<tr class="tr1">
	 <td align="left"> کد مشتری : </td>
     <td align="right">&nbsp;<input type="text" readonly class="textboxme" name="code_customer" value="'.$row1['code_customer'].'"/></td>
     <td align="left"> نام مشتری : </td>
     <td align="right" colspan="3">&nbsp;<input type="text" readonly class="textboxme" name="nameCustomer" value="'.$row1['nameCustomer'].'"  style="width:95%"/></td>
     <td colspan="2">&nbsp;</td>
	</tr>
	<tr class="tr1">
     <td align="left" width="120px"> نام استان مبدأ : </td>
     <td align="right">&nbsp;<input type="text" readonly class="textboxme" name="ostanMabda" value="'.$row1['ostanMabda'].'"/></td>
     <td align="left" colspan="" width="100px"> نام سردخانه مبدأ : </td>
     <td align="right">&nbsp;<input type="text" readonly class="textboxme" name="anbarMabda" value="'.$row1['anbarMabda'].'"/></td>
     <td align="left" width="120px"> نام استان مقصد : </td>
     <td align="right">&nbsp;<input type="text" readonly class="textboxme" name="ostanMaghsad" value="'.$row1['ostanMaghsad'].'"/></td>
     <td align="left" colspan="" width="120px"> نام سردخانه مقصد : </td>
     <td align="right">&nbsp;<input type="text" readonly class="textboxme" name="anbarMaghsad" value="'.$row1['anbarMaghsad'].'"/></td>
	</tr>
	<tr class="tr1">
     <td align="left">مقدار مجوز جابه جایی  : </td>
     <td align="right">&nbsp;<input type="text" readonly class="textboxme" name="meghdar_jabejae" value="'.($row1['meghdar_jabejae']).'"/>
	 </td>
	 <td align="left">مقدار تحویلی  : </td>
	 <td align="right">&nbsp;<input type="text" readonly class="textboxme" name="meghdar_tahvily_j" value="'.round($meghdar_tahvily_j,3).'"/></td>
	 <td align="left">مقدار باطله : </td>
	 <td align="right">&nbsp;<input type="text" readonly class="textboxme" name="meghdar_batele" value="'.($row1['meghdar_batele_j']).'"/></td>
	 <td align="left">مقدار مانده از مجوز : </td>
	 <td align="right">&nbsp;<input type="text" readonly class="textboxme" name="mande_az_jabejae" value="'.($row1['mande_az_jabejae']).'"/></td>
	</tr>
   </table>
   <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">   
	<tr class="table-title">
	 <td width="5%">ردیف</td>
	 <td width="20%">تاریخ حواله سردخانه</td>
	 <td width="20%">شماره حواله سردخانه</td>
	 <td width="20%">مقدار ابطالی حواله سردخانه</td>
	 <td width="20%">مقدار تحویلی</td>
	 <td width="15%">مانده</td>
	</tr>';
	if(($ok)&&($shomare_jabejae))
	{
       $radif=1;	
	   $i=0;	  
	   $q2="SELECT * FROM havale WHERE shomare_jabejae='$shomare_jabejae' AND tarikh_havale_anbar>='$mtStartDateSh' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0 order by tarikh_havale_anbar";
	   $res2=$db->query($q2);
	   $mande=$row1['meghdar_jabejae'];
	   $mande-=$row1['meghdar_batele_j'];//مقدار باطله را نیز همینجا از مجوز کم می کنیم 
	   $mande=round($mande,3);
	   //$mande=$row1['meghdar_tahvily_j']+$row1['mande_az_jabejae']; 
	   while($row2=$db->fetch_assoc($res2))
	   {
        if($i++%2)echo'<tr class="table-odd"/>';
        else echo'<tr class="table-even"/>';
	    //اضافه کردن صفر پشت کد استان
	     if(strlen($row2['code_ostan'])==1) $code_a=make_pattern($row2['code_ostan'],2);
         else $code_a=$row2['code_ostan'];	
	    echo'
	     <td>'.$radif++.'</td>
	     <td>'.$row2['tarikh_havale_anbar'].'</td>
	     <td>'.$code_a.$row2['code_anbar'].$row2['shomare_havale_anbar'].'</td>';
	    if($row1['codeBastebandy']==2)
		{ 
		  if($row2['status']==0)
		  {
		   echo '<td>-</td>
	  	         <td>'.($row2['tedad_karton_h']).'</td>';
		  	     $mande=$mande-$row2['tedad_karton_h'];
	       echo '<td>'.$mande.'</td>';
		  }
		  else
		  {
		   echo'<td>'.($row2['tedad_karton_h']).'</td>
                <td>-</td>';
		   echo'<td>'.$mande.'</td>';
	      }
		}
		else if(($row2['code_kala']==50)or($row2['code_kala']==54))
		{ 
		  if($row2['code_kala']==50) $tedad_shane_h=$row2['tedad_karton_h']*$_SESSION["mtShane"];
		  else if($row2['code_kala']==54) $tedad_shane_h=$row2['tedad_karton_h']*$_SESSION["mtShane_dakheli"];
		  if($row2['status']==0)
		  {
		   echo '<td>-</td>
	  	         <td>'.($tedad_shane_h).'</td>';
	  	  	     $temp=round($tedad_shane_h,3);
		  	     $mande=$mande-$temp;
	       echo '<td>'.round($mande,3).'</td>';
		  }
		  else
		  {
		   echo'<td>'.($tedad_shane_h).'</td>
                <td>-</td>';
		   echo'<td>'.round($mande,3).'</td>';
	      }
		}
	    else
		{ 
		  if($row2['status']==0)
		  {
		   echo '<td>-</td>
	  	         <td>'.($row2['vazn_khales_h']).'</td>';
	  	  	     $temp=round($row2['vazn_khales_h'],3);
		  	     $mande=$mande-$temp;
	       echo '<td>'.round($mande,3).'</td>';
		  }
		  else
		  {
		   echo'<td>'.($row2['vazn_khales_h']).'</td>
                <td>-</td>';
		   echo'<td>'.round($mande,3).'</td>';
	      }
		}
	  echo '
	  </tr>';
	 }
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
   <table width="100%"  border="0" cellspacing="0" cellpadding="0" height=100%  style="margin-bottom:20px;">    			
	<tr>
	 <td width="10px">&nbsp;</td>
	</tr>
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