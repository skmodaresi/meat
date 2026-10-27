<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="help_mojodykalagomrok.php";
$TableName="mojody_kala_gomrok";
$radif=1;
$nameKala=$db->get_from_where("name_kala","kala","code_kala=$code_kala_");
if(!$inputName) $inputName='id_mojody';
echo'
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>جدول موجودی کالای '.$nameKala.'</title>
<link href="styles.css" rel="stylesheet" type="text/css"/>';
echo"
<script type='text/javascript'>
<!--هر کدام از این فیلدها در صفحه مبدأ نباشد این تابع درست کار نمیکند -->
<!--پس اگر لازم نداریم بگذاریم و آن فیلد را پنهان کنیم-->
<!--مجبور شدیم دو بار ماه تولید شمسی را ارسال کنیم در دو فیلد با اسم های مختلف-->
function substitute(id_val,c_zir,n_zir,c_kesh,n_kesh,c_tolid,n_tolid,sal_t_sh,mah_t_sh,rouz_t_sh,sal_t_m,mah_t_m,rouz_t_m,c_karton,vazn_c,c_mandegari,m_khales,m_nakhales,tedad_k,tedad_sh)
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
 window.opener.document.myform.mojody_khales.value=m_khales;
 window.opener.document.myform.mojody_nakhales.value=m_nakhales;
 window.opener.document.myform.tedad_karton.value=tedad_k;
 window.opener.document.myform.tedad_shane.value=tedad_sh;
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
  <td class="title">جدول موجودی کالای '.$nameKala.'</td>	 
 </tr>
 <!--پايان هدر-->
 <!-- مرکز صفحه--> 
 <tr>
  <td height="100%">
   <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
	<tr class="table-title">
	 <td rowspan="2">رديف</td>
	    <!--<td rowspan="2" width=5%>کد کالا</td>-->
	 <td rowspan="2">زیر انبار</td>
	   <!--<td rowspan="2" >کد کشور</td>-->
	 <td rowspan="2">کشور</td>
	 <td rowspan="2">تولیدکننده</td>
	 <td colspan="3">تاریخ تولید</td>
	 <td rowspan="2">تاریخ ماندگاری</td>';
	 if($code_bastebandy_==1)
	 {echo'
	  <td rowspan="2">کد کارتن</td>
	  <td rowspan="2">وزن کارتن</td>';
	 }
	 if($code_bastebandy_==2)
	 {echo'
	  <td rowspan="2">کد قوطی</td>
	  <td rowspan="2">وزن قوطی</td>';
	 }
     echo'<td rowspan="2">تعداد</td>'; 
	 
	 if(($code_kala_==50)OR($code_kala_==54))echo'<td rowspan="2">تعداد شانه</td>'; 
	 echo'<td rowspan="2">موجودی ناخالص</td>'; 
	 echo'<td rowspan="2">موجودی خالص</td>';
	 echo'
	  <tr class="table-title">
	   <td>سال</td>
	   <td>ماه</td>
	   <td>روز</td>
	  </tr>
	</tr>';
   $Cntr=0;
   /*******************************************************/
   //آنهایی که جزئیات کالای فروخته شده در سیستم فروش ندارند
   //بسته بندی دست و کالای تخم مرغ
   if($parent_page=="havale_detail.php")
   $q1="SELECT $TableName.*,kala.name_kala,keshvar.name_keshvar,tolidkonande.name_tolidkonande,l_s_d.noe_ziranbar,l_s_d.name_ziranbar,karton.vazn_karton,sharh_mandegari From $TableName
          INNER JOIN kala ON $TableName.code_kala=kala.code_kala
          INNER JOIN keshvar ON $TableName.code_keshvar=keshvar.code_keshvar
          LEFT JOIN karton ON $TableName.code_karton=karton.code_karton 
          INNER JOIN tolidkonande ON $TableName.code_tolidkonande=tolidkonande.code_tolidkonande
          INNER JOIN list_sardkhane_detail l_s_d ON $TableName.code_ziranbar=l_s_d.code_ziranbar AND $TableName.code_ostan=l_s_d.code_ostan AND $TableName.code_anbar=l_s_d.code_anbar  	  
	      INNER JOIN $mydatabase.tarikh_mandegari ON $TableName.code_mandegari=tarikh_mandegari.code_mandegari
		  WHERE $TableName.code_kala='$code_kala_' AND $TableName.code_ostan='$mt_gl_code_ostan' AND $TableName.code_anbar='$mt_gl_code_anbar' AND $TableName.year='$mtActiveYear' AND $TableName.deleted=0 
		  AND $TableName.id NOT IN(SELECT id_mojody FROM havale_detail WHERE shomare_havale_anbar='$shomare_havale_anbar_' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear')
		  order by sal_tolid_shamsi,mah_tolid_shamsi,rouz_tolid_shamsi asc";
   
   else
   $q1="SELECT $TableName.*,kala.name_kala,keshvar.name_keshvar,tolidkonande.name_tolidkonande,l_s_d.noe_ziranbar,l_s_d.name_ziranbar,karton.vazn_karton,sharh_mandegari From $TableName
          INNER JOIN kala ON $TableName.code_kala=kala.code_kala
          INNER JOIN keshvar ON $TableName.code_keshvar=keshvar.code_keshvar
          LEFT JOIN karton ON $TableName.code_karton=karton.code_karton 
          INNER JOIN tolidkonande ON $TableName.code_tolidkonande=tolidkonande.code_tolidkonande
          INNER JOIN list_sardkhane_detail l_s_d ON $TableName.code_ziranbar=l_s_d.code_ziranbar AND $TableName.code_ostan=l_s_d.code_ostan AND $TableName.code_anbar=l_s_d.code_anbar  	  
	      INNER JOIN $mydatabase.tarikh_mandegari ON $TableName.code_mandegari=tarikh_mandegari.code_mandegari
		  WHERE $TableName.code_kala='$code_kala_' AND $TableName.code_ostan='$mt_gl_code_ostan' AND $TableName.code_anbar='$mt_gl_code_anbar' AND $TableName.year='$mtActiveYear' AND $TableName.deleted=0 
		  order by sal_tolid_shamsi,mah_tolid_shamsi,rouz_tolid_shamsi asc";
   	   
   //IF(SuperUser()) echo $q1;
   $allMojody = $db->query($q1);
   while($row1=$db->fetch_assoc($allMojody))
   {
    //موجودی با توابع
	$tedad_karton=mojodyKarton($row1['code_ostan'],$row1['code_anbar'],$row1['year'],$row1['code_ziranbar'],$row1['code_kala'],$row1['code_keshvar'],$row1['code_tolidkonande'],$row1['sal_tolid_shamsi'],$row1['mah_tolid_shamsi'],$row1['rouz_tolid_shamsi'],$row1['code_karton'],$row1['code_mandegari'],2);
	$mojody_nakhales=mojodyNakhales($row1['code_ostan'],$row1['code_anbar'],$row1['year'],$row1['code_ziranbar'],$row1['code_kala'],$row1['code_keshvar'],$row1['code_tolidkonande'],$row1['sal_tolid_shamsi'],$row1['mah_tolid_shamsi'],$row1['rouz_tolid_shamsi'],$row1['code_karton'],$row1['code_mandegari'],2);
    $mojody_khales=mojodyKhales($row1['code_ostan'],$row1['code_anbar'],$row1['year'],$row1['code_ziranbar'],$row1['code_kala'],$row1['code_keshvar'],$row1['code_tolidkonande'],$row1['sal_tolid_shamsi'],$row1['mah_tolid_shamsi'],$row1['rouz_tolid_shamsi'],$row1['code_karton'],$row1['code_mandegari'],2);
    // //مقدار مانده از فروخته شده را کم میکنیم
	// $sold_this_id_without_ebtal=sold_this_id($row1['id'],$code_bastebandy_,$code_kala_);
	// $ebtal_this_id=$db->get_from_where("SUM(deh_amount)","sell.dm_ebtal_hdet","deh_anbar_id=".$row1['id']."");
	// $sold_this_id=$sold_this_id_without_ebtal-$ebtal_this_id;
	// $tahvily_detail=tahvily_az_forush_detail($row1['id'],$code_bastebandy_,$code_kala_);
	// $mande_az_detail_forush=$sold_this_id-$tahvily_detail;
	IF($code_kala_==50) { $tedad_shane=($tedad_karton*$_SESSION["mtShane"]);}
	ELSE IF($code_kala_==54){$tedad_shane=($tedad_karton*$_SESSION["mtShane_dakheli"]);}
	ELSE $tedad_shane=0;
	
	
	$editclick="onclick='substitute(\"".$row1['id']."\",\"".$row1['code_ziranbar']."\",\"".$row1['name_ziranbar']."\",\"".$row1['code_keshvar']."\",\"".$row1['name_keshvar']."\",\"".$row1['code_tolidkonande']."\",\"".$row1['name_tolidkonande']."\",\"".$row1['sal_tolid_shamsi']."\",\"".$row1['mah_tolid_shamsi']."\",\"".$row1['rouz_tolid_shamsi']."\",\"".$row1['sal_tolid_milady']."\",\"".$row1['mah_tolid_milady']."\",\"".$row1['rouz_tolid_milady']."\",\"".$row1['code_karton']."\",\"".$row1['vazn_karton']."\",\"".$row1['code_mandegari']."\",\"".round($mojody_khales,3)."\",\"".round($mojody_nakhales,3)."\",\"".$tedad_karton."\",\"".$tedad_shane."\")'";
    
	//اونهایی که موجودی صفر دارند نمایش داده نمی شود برای صفحه جزئیات حواله
	//IF((($parent_page=="havale_detail.php")AND(($code_bastebandy_==1 AND $tedad_karton!=0 AND $mojody_nakhales!=0 AND $mojody_khales!=0)OR($code_bastebandy_==2 AND $tedad_karton!=0 AND $mojody_khales!=0)OR($code_bastebandy_==3 AND $tedad_karton!=0 AND $mojody_khales!=0)OR($code_bastebandy_==4 AND $tedad_karton!=0 AND $mojody_khales!=0)OR($code_bastebandy_==5 AND $tedad_karton!=0)OR($code_bastebandy_==6 AND $tedad_karton!=0)))OR($parent_page!="havale_detail.php"))
	//{ 
      if($Cntr++%2) echo'<tr class="table-odd"/>';
      else echo '<tr class="table-even" />';
      echo'
	   <td '.$editclick.'>'.$radif++.'</td>
	   <td '.$editclick.'>'.$row1['name_ziranbar'].'</td>
	   <td '.$editclick.'>'.$row1['name_keshvar'].'</td>
	   <td '.$editclick.'>'.$row1['name_tolidkonande'].'</td>
	   <td '.$editclick.'>'.$row1['sal_tolid_shamsi'].'</td>
	   <td '.$editclick.'>'.$mahshamsiArr[$row1['mah_tolid_shamsi']].'</td>
	   <td '.$editclick.'>'.$row1['rouz_tolid_shamsi'].'</td>
	   <td '.$editclick.'>'.$row1['sharh_mandegari'].'</td>';
	   if(($code_bastebandy_==1)or($code_bastebandy_==2))//کارتن یا قوطی
	   {echo'
	    <td '.$editclick.'>'.$row1['code_karton'].'</td>
	    <td '.$editclick.'>'.$row1['vazn_karton_this'].'</td>';
	   }
	   echo'
	   <td '.$editclick.'>'.$tedad_karton.'</td>';
	   if(($code_kala_==50)or($code_kala_==54))echo'<td '.$editclick.'>'.$tedad_shane.'</td>';
	   echo'<td '.$editclick.'>'.round($mojody_nakhales,3).'</td>';
	   echo'<td '.$editclick.'>'.round($mojody_khales,3).'</td>';
	  echo '
	  </tr>';
	//}
   }
   echo'
   </table>
  </td>
 </tr> 
 <!--پايان مرکز صفحه -->	
</table>
</div>
</body>
</html>';	
?>