<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="help_detail_forush.php";
$radif=1;
if(!$inputName) $inputName='id_mojody';
echo'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" />
<html xmlns="http://www.w3.org/1999/xhtml" dir=rtl>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>جزئیات حواله فروش '.$h_code_.'</title>
<link href="styles.css" rel="stylesheet" type="text/css"/>';
echo"
<script type='text/javascript'>
<!--هر کدام از این فیلدها در صفحه مبدأ نباشد این تابع درست کار نمیکند -->
<!--پس اگر لازم نداریم بگذاریم و آن فیلد را پنهان کنیم-->
<!--مجبور شدیم دو بار ماه تولید شمسی را ارسال کنیم در دو فیلد با اسم های مختلف-->
function substitute(id_val,c_zir,n_zir,c_kesh,n_kesh,c_tolid,n_tolid,sal_t_sh,mah_t_sh,rouz_t_sh,sal_t_m,mah_t_m,rouz_t_m,c_karton,vazn_c,c_mandegari,m_nakhales,m_khales,tedad_k,m_forush_detail,sell_detail_id)
{
 window.opener.document.myform.id_mojody.value=id_val;
 window.opener.document.myform.code_ziranbar.value=c_zir;
 window.opener.document.myform.name_ziranbar.value=n_zir;
 window.opener.document.myform.code_keshvar.value=c_kesh;
 window.opener.document.myform.name_keshvar.value=n_kesh;
 window.opener.document.myform.code_tolidkonande.value=c_tolid;
 window.opener.document.myform.name_tolidkonande.value=n_tolid;
 window.opener.document.myform.sal_tolid_shamsi.value=sal_t_sh;
 window.opener.document.myform.mah_tolid_sh.value=mah_t_sh;
 window.opener.document.myform.mah_tolid_shamsi.value=mah_t_sh;
 window.opener.document.myform.rouz_tolid_shamsi.value=rouz_t_sh;
 window.opener.document.myform.sal_tolid_milady.value=sal_t_m;
 window.opener.document.myform.mah_tolid_milady.value=mah_t_m;
 window.opener.document.myform.rouz_tolid_milady.value=rouz_t_m;
 window.opener.document.myform.code_karton.value=c_karton;
 window.opener.document.myform.vazn_karton_this.value=vazn_c;
 window.opener.document.myform.code_mandegari.value=c_mandegari;
 window.opener.document.myform.code_mandegari_show.value=c_mandegari;
 window.opener.document.myform.tedad_karton.value=tedad_k;
 window.opener.document.myform.mojody_nakhales.value=m_nakhales;
 window.opener.document.myform.mojody_khales.value=m_khales;
 window.opener.document.myform.mande_forush_detail.value=m_forush_detail;
 window.opener.document.myform.dad_id.value=sell_detail_id;
 window.close();
}
</script>
</head>";
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<div align="center">
<table width="100%" height="100%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr>
  <td class="title">جزئیات حواله فروش '.$h_code_.'</td>	 
 </tr>
 <!--پايان هدر-->
 <!-- مرکز صفحه--> 
 <tr>
  <td height="100%">
   <div style="float:right;width:100%;margin:0px;height:100%;overflow:auto;overflow-x:hidden;">
   <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
	<tr class="table-title">
	 <td rowspan="2">رديف</td>
	 <td rowspan="2">کالا</td>
	 <td rowspan="2">زیر انبار</td>
	 <td rowspan="2">کشور</td>
	 <td rowspan="2">تولیدکننده</td>
	 <td colspan="3">تاریخ تولید</td>
	 <td rowspan="2">تاریخ ماندگاری</td>';
	 if($code_bastebandy_==1)echo'<td rowspan="2">وزن کارتن</td>';
	 if($code_bastebandy_==2)echo'<td rowspan="2">وزن قوطی</td>'; 
	 echo'
	 <td colspan="3">موجودی سردخانه</td>
	 <td rowspan="2">مقدار فروش</td>
	 <td rowspan="2">مقدار مانده از فروش</td>
	</tr>
	<tr class="table-title">
	  <td>سال</td>
	  <td>ماه</td>
	  <td>روز</td>	 
	  <td>تعداد</td>
	  <td>ناخالص</td>
	  <td>خالص</td>
	 </tr>';
   $Cntr=0;
   $q1="SELECT dm_anbar_det.*,mojody_kala.*,kala.name_kala,keshvar.name_keshvar,tolidkonande.name_tolidkonande,l_s_d.noe_ziranbar,l_s_d.name_ziranbar,karton.vazn_karton,sharh_mandegari
        FROM sell.dm_havale
		INNER JOIN sell.dm_pish_havale_det ON h_phd_id=phd_id
		INNER JOIN sell.dm_anbar_det ON dad_phd_id=phd_id
		INNER JOIN meat.mojody_kala ON mojody_kala.id=dm_anbar_det.dad_anbar_id
		INNER JOIN meat.kala ON mojody_kala.code_kala=kala.code_kala
        INNER JOIN meat.keshvar ON mojody_kala.code_keshvar=keshvar.code_keshvar
        LEFT JOIN  meat.karton ON mojody_kala.code_karton=karton.code_karton 
        INNER JOIN meat.tolidkonande ON mojody_kala.code_tolidkonande=tolidkonande.code_tolidkonande
        INNER JOIN meat.list_sardkhane_detail l_s_d ON mojody_kala.code_ziranbar=l_s_d.code_ziranbar AND mojody_kala.code_ostan=l_s_d.code_ostan AND mojody_kala.code_anbar=l_s_d.code_anbar  	  
	    LEFT JOIN  meat.tarikh_mandegari ON mojody_kala.code_mandegari=tarikh_mandegari.code_mandegari
		WHERE h_code=$h_code_ AND h_id_province=$sell_id_ostan AND h_l_code=$sell_id_anbar AND h_id_year=$sellYearId AND mojody_kala.year=$mtActiveYear";
						 
   //IF(SuperUser())echo $q1;	
   $allDetail=$db->query($q1);
   while($row1=$db->fetch_assoc($allDetail))
   {	
	//موجودی با توابع
	$tedad_karton=mojodyKarton($row1['code_ostan'],$row1['code_anbar'],$row1['year'],$row1['code_ziranbar'],$row1['code_kala'],$row1['code_keshvar'],$row1['code_tolidkonande'],$row1['sal_tolid_shamsi'],$row1['mah_tolid_shamsi'],$row1['rouz_tolid_shamsi'],$row1['code_karton'],$row1['code_mandegari']);
	$mojody_nakhales=mojodyNakhales($row1['code_ostan'],$row1['code_anbar'],$row1['year'],$row1['code_ziranbar'],$row1['code_kala'],$row1['code_keshvar'],$row1['code_tolidkonande'],$row1['sal_tolid_shamsi'],$row1['mah_tolid_shamsi'],$row1['rouz_tolid_shamsi'],$row1['code_karton'],$row1['code_mandegari']);
    $mojody_khales=mojodyKhales($row1['code_ostan'],$row1['code_anbar'],$row1['year'],$row1['code_ziranbar'],$row1['code_kala'],$row1['code_keshvar'],$row1['code_tolidkonande'],$row1['sal_tolid_shamsi'],$row1['mah_tolid_shamsi'],$row1['rouz_tolid_shamsi'],$row1['code_karton'],$row1['code_mandegari']);
	$tedad_shane=$tedad_karton*$_SESSION["mtShane"];
	//$tedad_tahvily=$db->get_from_where("SUM(tedad_karton_h_d)","meat.havale_detail","dad_id=".$row1['dad_id']." AND status=0");
	//$nakhales_tahvily=$db->get_from_where("SUM(vazn_nakhales_h_d)","meat.havale_detail","dad_id=".$row1['dad_id']." AND status=0");
	//$khales_tahvily=$db->get_from_where("SUM(vazn_khales_h_d)","meat.havale_detail","dad_id=".$row1['dad_id']." AND status=0");
	//$mande_tedad_forush=$row1['dad_tedad_khanbar']-$tedad_tahvily;
	//$mande_nakhales_forush=$row1['dad_vazn_n']-$nakhales_tahvily;
	//$mande_khales_forush=$row1['dad_vazn_khanbar']-$khales_tahvily;
	//مقدار تحویلی این حواله فروش
	//قوطی
	IF($code_bastebandy_==2)$havaleField='tedad_karton_h_d';
	ELSE IF($row1['code_kala']==50)$havaleField='tedad_shane_h_d';
	ELSE $havaleField='vazn_khales_h_d';
	$tahvily_dad_id=$db->get_from_where("SUM($havaleField)","meat.havale_detail","dad_id=".$row1['dad_id']." AND status=0");
    //مقدار ابطال شده از این حواله فروش
    $ebtal_detail=$db->get_from_where("SUM(deh_amount)","sell.dm_ebtal_hdet","deh_anbar_id=".$row1['dad_anbar_id']." AND deh_phd_id=".$row1['dad_phd_id']."");
    //مقدار مانده از این حواله فروش
	IF(($code_bastebandy_==2)OR($row1['code_kala']==50))$mande_forush_detail=$row1['dad_tedad_khanbar']-$tahvily_dad_id-$ebtal_detail;
	ELSE {$mande_forush_detail=$row1['dad_vazn_khanbar']-$tahvily_dad_id-$ebtal_detail; $mande_forush_detail=round($mande_forush_detail,3);}
	//$editclick="onclick='substitute(\"".$row1['id']."\",\"".$row1['code_ziranbar']."\",\"".$row1['name_ziranbar']."\",\"".$row1['code_keshvar']."\",\"".$row1['name_keshvar']."\",\"".$row1['code_tolidkonande']."\",\"".$row1['name_tolidkonande']."\",\"".$row1['sal_tolid_shamsi']."\",\"".$row1['mah_tolid_shamsi']."\",\"".$row1['rouz_tolid_shamsi']."\",\"".$row1['sal_tolid_milady']."\",\"".$row1['mah_tolid_milady']."\",\"".$row1['rouz_tolid_milady']."\",\"".$row1['code_karton']."\",\"".$row1['vazn_karton']."\",\"".round($mande_nakhales_forush,3)."\",\"".round($mande_khales_forush,3)."\",\"".$mande_tedad_forush."\",\"".$row1['dad_id']."\")'";
	$editclick="onclick='substitute(\"".$row1['id']."\",\"".$row1['code_ziranbar']."\",\"".$row1['name_ziranbar']."\",\"".$row1['code_keshvar']."\",\"".$row1['name_keshvar']."\",\"".$row1['code_tolidkonande']."\",\"".$row1['name_tolidkonande']."\",\"".$row1['sal_tolid_shamsi']."\",\"".$row1['mah_tolid_shamsi']."\",\"".$row1['rouz_tolid_shamsi']."\",\"".$row1['sal_tolid_milady']."\",\"".$row1['mah_tolid_milady']."\",\"".$row1['rouz_tolid_milady']."\",\"".$row1['code_karton']."\",\"".$row1['vazn_karton']."\",\"".$row1['code_mandegari']."\",\"".round($mojody_nakhales,3)."\",\"".round($mojody_khales,3)."\",\"".$tedad_karton."\",\"".$mande_forush_detail."\",\"".$row1['dad_id']."\")'";
	IF(($mande_forush_detail>0)AND(($code_bastebandy_==1 AND $tedad_karton!=0 AND $mojody_nakhales!=0 AND $mojody_khales!=0)OR($code_bastebandy_==2 AND $tedad_karton!=0 AND $mojody_khales!=0)OR($code_bastebandy_==3 AND $tedad_karton!=0 AND $mojody_khales!=0)))
	{
	  if($Cntr++%2) echo'<tr class="table-odd"/>';
      else echo '<tr class="table-even" />';
	  echo'
	   <td '.$editclick.'>'.$radif++.'</td>
	   <td '.$editclick.'>'.$row1['name_kala'].'</td>
	   <td '.$editclick.'>'.$row1['name_ziranbar'].'</td>
	   <td '.$editclick.'>'.$row1['name_keshvar'].'</td>
	   <td '.$editclick.'>'.$row1['name_tolidkonande'].'</td>
	   <td '.$editclick.'>'.$row1['sal_tolid_shamsi'].'</td>
	   <td '.$editclick.'>'.$mahshamsiArr[$row1['mah_tolid_shamsi']].'</td>
	   <td '.$editclick.'>'.$row1['rouz_tolid_shamsi'].'</td>
	   <td '.$editclick.'>'.$row1['sharh_mandegari'].'</td>';
	   if($code_bastebandy_!=3)//
	   {echo'<td '.$editclick.'>'.$row1['vazn_karton_this'].'</td>';}
	   echo'
	   <td '.$editclick.'>'.$tedad_karton.'</td>
	   <td '.$editclick.'>'.round($mojody_nakhales,3).'</td>
	   <td '.$editclick.'>'.round($mojody_khales,3).'</td>';
	   IF(($code_bastebandy_==2)OR($row1['code_kala']==50))
	   { echo'
	     <td '.$editclick.'>'.round($row1['dad_tedad_khanbar'],3).'</td>
	     <td '.$editclick.'>'.round($mande_forush_detail,3).'</td>';
	   }
	   ELSE
	   { echo'
	     <td '.$editclick.'>'.round($row1['dad_vazn_khanbar'],3).'</td>
	     <td '.$editclick.'>'.round($mande_forush_detail,3).'</td>';
	   }
	   echo'
	   <!--<td '.$editclick.'>'.$mande_tedad_forush.'</td>
	       <td '.$editclick.'>'.round($mande_nakhales_forush,3).'</td>
	       <td '.$editclick.'>'.round($mande_khales_forush,3).'</td>-->
	  </tr>';
		
	}//END IF	

	}//END WHILE
	
	$db->close();
	echo'
   </table>
   </div>
  </td>
 </tr> 
 <!--پايان مرکز صفحه -->	
</table>
</div>
</body>
</html>';	
?>