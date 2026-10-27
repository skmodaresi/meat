<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="cardex_forush.php";
$today=AsLDate($yymmdd);
$logtime=date('H:i');
echo'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" />
<html xmlns="http://www.w3.org/1999/xhtml" dir=rtl>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>چاپ کاردکس جابه جایی</title>
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
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<br/>
 <!--هدر-->
<table width="99%" height="100%" align="center" cellpadding="0" border="1" cellspacing="0">
 <tr><td class="print_title_2">'.$mt_gl_owner.'</td></tr>
 <tr><td class="print_title_2"> سردخانه : '.$mt_gl_name_anbar.'&nbsp;&nbsp; استان : '.$mt_gl_name_ostan.'</td></tr>
 <tr><td class="print_title_2"> کنترل کاردکس  مجوز جابه جایی شماره '.$shomare_jabejae_.'&nbsp&nbsp(صفحه : 1)
	   <span style="float:right"><a href="javascript:window.print();"><img src="images/PrinterText.png" onmouseOver="this.src=\'images/PrinterText--hover.png\'" onmouseOut="this.src=\'images/PrinterText.png\'" title="چاپ" id="IMG1" class="hideatprint"/></a></span>
	  </td>
 </tr>
</table>
 <!--پايان هدر-->';
   	 $q1="SELECT *,
	       (SELECT name_kala FROM kala WHERE code_kala=m_j.code_kala)nameKala,
		   (SELECT code_bastebandy FROM kala WHERE code_kala=m_j.code_kala)codeBastebandy, 
	       (SELECT name_customer FROM moshtary WHERE code_customer=m_j.code_customer)nameCustomer, 		   
	       (SELECT name_ostan FROM ostan WHERE code_ostan=m_j.code_ostan)ostanMabda, 
	       (SELECT name_anbar FROM list_sardkhane WHERE code_anbar=m_j.code_anbar AND code_ostan='$mt_gl_code_ostan')anbarMabda,
           (SELECT name_ostan FROM ostan WHERE code_ostan=m_j.code_ostan_maghsad_j)ostanMaghsad,
	       (SELECT name_anbar FROM list_sardkhane WHERE code_anbar=m_j.code_anbar_maghsad_j AND code_ostan=m_j.code_ostan_maghsad_j)anbarMaghsad,		   
           (SELECT SUM(meghdar_batele_j) FROM ebtal_jabejae WHERE shomare_jabejae=m_j.shomare_jabejae AND code_ostan=m_j.code_ostan AND code_anbar=m_j.code_anbar AND year=m_j.year AND deleted=0)meghdar_batele_j 
	       FROM mojavez_jabejae as m_j WHERE shomare_jabejae='$shomare_jabejae_' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0";	
	 $res1 = $db->query($q1);
	 $row1=$db->fetch_assoc($res1);
     //محاسبه مقدار تحویلی از مجوز جابه جایی با استفاده از تابع
   	 $meghdar_tahvily_j=tahvily_az_jabejae($row1['shomare_jabejae'],$row1['code_ostan'],$row1['code_anbar'],$row1['year'],$row1['codeBastebandy'],$row1['code_kala']);

   echo'
   <!-- مرکز صفحه-->
   <table width="99%" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr class="tr1">
     <td align="right" colspan="4"> شماره مجوز جابه جایی : '.$shomare_jabejae_.'&nbsp;</td>
	</tr>
    <tr class="tr1">
	 <td align="right"> کد کالا : '.$row1['code_kala'].'</td>
     <td align="right" colspan="3"> نام کالا : '.$row1['nameKala'].'</td>
	</tr>
    <tr class="tr1">
	 <td align="right"> کد مشتری : '.$row1['code_customer'].'</td>
     <td align="right" colspan="3"> نام مشتری : '.$row1['nameCustomer'].'</td>
	</tr>
	<tr class="tr1">
     <td align="right"> استان مبدأ : '.$row1['ostanMabda'].'</td>
     <td align="right"> سردخانه مبدأ : '.$row1['anbarMabda'].'</td>
	 <td align="right"> استان مقصد : '.$row1['ostanMaghsad'].'</td>
     <td align="right"> سردخانه مقصد : '.$row1['anbarMaghsad'].'</td>
	</tr>
    <tr class="tr1">
     <td align="right">مقدار مجوز جابه جایی  : '.($row1['meghdar_jabejae']).'</td>
	 <td align="right">مقدار تحویلی  : '.round($meghdar_tahvily_j,3).'</td>
	 <td align="right">مقدار باطله : '.($row1['meghdar_batele_j']).'</td>
	 <td align="right">مقدار مانده از مجوز : '.($row1['mande_az_jabejae']).'</td>
	</tr>
   </table>
   <table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">   
	<tr class="print_table-title">
	   <td width="5%">ردیف</td>
	   <td width="20%">تاریخ حواله سردخانه</td>
	   <td width="20%">شماره حواله سردخانه</td>
	   <td width="20%">مقدار ابطالی حواله سردخانه</td>
	   <td width="20%">مقدار تحویلی</td>
	   <td width="15%">مانده</td>
	</tr>';
	$page=1;
    $line=0;
    $i=0;$cntr=0;
    $MaxLines=20;
	$radif=1;	
	  $q2="SELECT * FROM havale WHERE shomare_jabejae='$shomare_jabejae_' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0 order by tarikh_havale_anbar";
	  $res2=$db->query($q2);
	  $cntr =mysql_num_rows($res2);
	  $mande=$row1['meghdar_jabejae'];
	  $mande-=$row1['meghdar_batele_j'];//مقدار باطله را نیز همینجا از مجوز کم می کنیم 
	  $mande=round($mande,3);
	  //$mande=$row1['meghdar_tahvily_j']+$row1['mande_az_jabejae']; 
	  
  
	  //$mande=$row1['meghdar_tahvily']+$row1['mande_az_jabejae']; 
	  while($row2=$db->fetch_assoc($res2))
	  {
       $line++;
	   if($i++%2)echo'<tr class="print_table-odd"/>';
       else echo'<tr class="print_table-even"/>';
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
            <tr><td class="print_title_2"> کنترل کاردکس  حواله فروش شماره '.$shomare_jabejae_.'&nbsp&nbsp(صفحه : '.$page.')
	        	</td>
	        </tr>
           </table>
		   <table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
	        <tr class="print_table-title">
	         <td width="5%">ردیف</td>
	         <td width="20%">تاریخ حواله سردخانه</td>
	         <td width="20%">شماره حواله سردخانه</td>
	         <td width="20%">مقدار ابطالی حواله سردخانه</td>
	         <td width="20%">مقدار تحویلی</td>
	         <td width="15%">مانده</td>
	        </tr>';
	   }	 
	  }//END while
	echo'
	</table>';  
 echo'
 <!-- چاپ زیرنویس-->
 <table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
  <tr class="print_footer">
   <td colspan="3">&nbsp;&nbsp;نام کاربر :&nbsp;&nbsp;'.$mtuserNAME.' &nbsp;&nbsp;&nbsp; تاریخ چاپ : '.$today.' &nbsp;&nbsp;&nbsp; ساعت چاپ : '.$logtime.'</td>
  </tr>	
 </table>
</body>
</html>';	
?>