<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="dashboard.php";
$titr='داشبورد اطلاعات کالاهای گوشتی';
require_once('head.html');
$child_page='dashboard_ostan.php';
$query_find = $db->query("set session group_concat_max_len=250000");
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<form method="post" name="myform">
<img src="images/loading.gif" id="loading" class="loading_img"/>
<table border="1" width="98%" height="90%" bordercolor="#111" align="center" cellpadding="0" cellspacing="0">
 <tr>
  <td class="title">
   <div style="position:absolute;top:5px;left:42%;">'.$titr.'</div>
   <div style="float:right;">
    <span class="fa fa-refresh" style="color:#FFF;cursor:pointer;font-size:20px" title="به روزرسانی" onClick="window.location.reload()">&nbsp;</span>
    <span class="fa fa-print" style="color:#FFF;cursor:pointer;font-size:20px" title="چاپ" onClick="popupwindow(\'print_dashboard.php\',\'\',850,500)">&nbsp;</span>
   </div>
  </td>
 </tr>
 <tr>
  <td class="table-title">
  کالاهای مرغ و گوشت و تخم مرغ صنعتی براساس وزن خالص ،
  کنسرو براساس تعداد و
  تخم مرغ خوراکی براساس شانه فروخته می شود
  </td>
 </tr>
 <!--وزن خالص-->
 <tr>
  <td height="100%">
   <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
	<tr class="table-title" style="background-color:#191970"><td  colspan="7">وزن خالص (واحد کالا : کیلوگرم)</td></tr>
	<tr class="table-title">
	 <td width="10%">گروه کالا</td>
	 <td width="15%">موجودی اول دوره</td>
	 <td width="15%">خرید قطعی</td>
	 <td width="15%">کالای در راه</td>
	 <td width="15%">مانده حواله فروش</td>
	 <td width="15%">مانده موجودی</td>
	 <td width="15%">مانده موجودی پس از کسر حواله فروش</td>
	</tr>';
	$i=0;
	$q="SELECT * FROM bzacc.group_kala_top WHERE group_type_top=2 AND code_group_kala_top!=9";
	$all = $db->query($q);
    while($row=$db->fetch_assoc($all))
	{
     //فیلد اول 
	 $mojodyAvalKhales=$db->get_from_where("SUM(mojody_khales_aval)","$mydatabase.mojody_kala T INNER JOIN $mydatabase.kala ON kala.code_kala=T.code_kala INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","code_group_kala_top=".$row['code_group_kala_top']." AND year='$mtActiveYear' AND list_sardkhane.situation_type=1 AND list_sardkhane.activate=1 AND deleted=0");
	 //فیلد دوم
	 //تخلیه در انبار-تحویل روباری-حمل با راه آهن تخلیه -حمل با راه آهن روباری-خرید داخلی
	 $kharidghateeKhales=$db->get_from_where("SUM(vazn_khales_r_d_sub)","$mydatabase.resid_kala_detail T INNER JOIN $mydatabase.resid r ON T.shomare_resid=r.shomare_resid AND T.code_ostan=r.code_ostan AND T.code_anbar=r.code_anbar AND T.year=r.year INNER JOIN $mydatabase.kala ON kala.code_kala=T.code_kala INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","code_group_kala_top=".$row['code_group_kala_top']." AND r.year='$mtActiveYear' AND list_sardkhane.situation_type=1 AND list_sardkhane.activate=1 AND r.deleted=0 AND r.status=0 AND(noe_tahvil_bar=1 OR noe_tahvil_bar=2 OR noe_tahvil_bar=3)");
	 //فیلد سوم
	 $darrahKhales=$db->get_from_where("SUM(vazn_khales_h_d)","$mydatabase.havale_detail T INNER JOIN $mydatabase.havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year INNER JOIN $mydatabase.kala ON kala.code_kala=T.code_kala INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","code_group_kala_top=".$row['code_group_kala_top']." AND h.noe_tahvil_bar=4 AND T.year=".$mtActiveYear." AND list_sardkhane.situation_type=1 AND list_sardkhane.activate=1 AND T.havale_deleted=0 AND T.status=0 AND not find_in_set(h.id,(SELECT group_concat(id_havale SEPARATOR ',') FROM $mydatabase.resid WHERE deleted=0 AND status=0 AND (noe_tahvil_bar=4 or noe_tahvil_bar=5)))");

	 //فیلد چهارم
	 //مرغ-گوشت-تخم مرغ صنعتی
	 IF(($row['code_group_kala_top']==4)OR($row['code_group_kala_top']==5)OR($row['code_group_kala_top']==8))
	 {
	  $avaliye_havale_forushKhales=$db->get_from_where("SUM(h_pre_amount)","sell.dm_havale T INNER JOIN $mydatabase.kala ON kala.code_kala=T.h_p_code INNER JOIN sell.dm_location_goods ON h_l_code=l_id INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=dm_location_goods.l_code AND list_sardkhane.code_ostan=dm_location_goods.l_id_province","code_group_kala_top=".$row['code_group_kala_top']." AND h_id_year='$sellYearId' AND list_sardkhane.situation_type=1 AND list_sardkhane.activate=1");
	  $meghdar_ebtali_forushKhales=$db->get_from_where("SUM(his_eb_amount)","sell.dm_his_havale INNER JOIN sell.dm_havale ON dm_his_havale.his_h_id=dm_havale.h_id INNER JOIN sell.dm_ebtal_h ON dm_his_havale.his_id=dm_ebtal_h.ebh_h_id INNER JOIN sell.dm_location_goods ON h_l_code=l_id INNER JOIN $mydatabase.kala ON kala.code_kala=dm_havale.h_p_code INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=dm_location_goods.l_code AND list_sardkhane.code_ostan=dm_location_goods.l_id_province","code_group_kala_top=".$row['code_group_kala_top']." AND h_id_year='$sellYearId' AND list_sardkhane.situation_type=1 AND list_sardkhane.activate=1");
	  $tahvilghateeKhales=$db->get_from_where("SUM(vazn_khales_h_d)","$mydatabase.havale_detail T INNER JOIN $mydatabase.havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year INNER JOIN $mydatabase.kala ON kala.code_kala=T.code_kala INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","code_group_kala_top=".$row['code_group_kala_top']."  AND h.year='$mtActiveYear' AND list_sardkhane.situation_type=1 AND list_sardkhane.activate=1 AND h.deleted=0 AND h.status=0 AND (noe_tahvil_bar=1 OR noe_tahvil_bar=2 OR noe_tahvil_bar=3)");	
	  $mande_forushKhales=round($avaliye_havale_forushKhales,3)-round($meghdar_ebtali_forushKhales,3)-round($tahvilghateeKhales,3);
	 }
	 ELSE $mande_forushKhales=0;
	 //فیلد پنجم
	 $jameVaredeKhales=$db->get_from_where("SUM(vazn_khales_r_d_sub)","$mydatabase.resid_kala_detail T INNER JOIN $mydatabase.kala ON kala.code_kala=T.code_kala INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","code_group_kala_top=".$row['code_group_kala_top']." AND T.year='$mtActiveYear' AND list_sardkhane.situation_type=1 AND list_sardkhane.activate=1 AND T.resid_deleted=0 AND T.status=0");
	 $jameSadereKhales=$db->get_from_where("SUM(vazn_khales_h_d)","$mydatabase.havale_detail T INNER JOIN $mydatabase.kala ON kala.code_kala=T.code_kala INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","code_group_kala_top=".$row['code_group_kala_top']." AND T.year='$mtActiveYear' AND list_sardkhane.situation_type=1 AND list_sardkhane.activate=1 AND havale_deleted=0 AND T.status=0");
	 $meghdarTadil_EzafeKhales=$db->get_from_where("SUM(meghdar_khales_tadil)","$mydatabase.tadil_mojody T INNER JOIN $mydatabase.kala ON T.code_kala=kala.code_kala INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","code_group_kala_top=".$row['code_group_kala_top']." AND year='$mtActiveYear' AND list_sardkhane.situation_type=1 AND list_sardkhane.activate=1 AND deleted=0  AND status=0  AND noe_tadil=1");
	 $meghdarTadil_KasryKhales=$db->get_from_where("SUM(meghdar_khales_tadil)","$mydatabase.tadil_mojody T INNER JOIN $mydatabase.kala ON T.code_kala=kala.code_kala INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","code_group_kala_top=".$row['code_group_kala_top']." AND year='$mtActiveYear' AND list_sardkhane.situation_type=1 AND list_sardkhane.activate=1 AND deleted=0  AND status=0  AND noe_tadil=2");
	 $mandeKhales=$mojodyAvalKhales+$jameVaredeKhales-$jameSadereKhales+$meghdarTadil_EzafeKhales-$meghdarTadil_KasryKhales;
	 //فیلد ششم
	 $mande_pas_az_kasrKhales=$mandeKhales-$mande_forushKhales;
	 $edtClick='onClick="window.location=\''.$child_page.'?noe_namayesh_=1&code_group_kala_top_='.$row['code_group_kala_top'].'&name_group_kala_top_='.$row['name_group_kala_top'].'\'"';
     if($i++%2){echo'<tr class="table-odd">';}
     else{echo'<tr class="table-even">';}
	 echo'
	  <td '.$edtClick.'>'.$row['name_group_kala_top'].'</td>
	  <td '.$edtClick.'>'.round($mojodyAvalKhales,3).'</td>
	  <td '.$edtClick.'>'.round($kharidghateeKhales,3).'</td>
	  <td '.$edtClick.'>'.round($darrahKhales,3).'</td>
	  <td '.$edtClick.'>';
	  IF(($row['code_group_kala_top']==4)OR($row['code_group_kala_top']==5)OR($row['code_group_kala_top']==8))echo''.round($mande_forushKhales,3).'';
	  ELSE echo '-'; 
	  echo'
	  </td>
	  <td '.$edtClick.'>'.round($mandeKhales,3).'</td>
	  <td '.$edtClick.'>'.round($mande_pas_az_kasrKhales,3).'</td>
	</tr>';
	}
	echo'
   </table>
  </td>
 </tr>
 <!--وزن ناخالص-->
 <tr>
  <td height="100%">
   <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
	<tr class="table-title" style="background-color:#191970"><td  colspan="7">وزن ناخالص (واحد کالا:کیلوگرم)</td></tr>
	<tr class="table-title">
	 <td width="15%">گروه کالا</td>
	 <td width="20%">موجودی اول دوره</td>
	 <td width="20%">خرید قطعی</td>
	 <td width="15%">کالای در راه</td>
	 <td width="20%">مانده موجودی</td>
	</tr>';
	$i=0;
	$q="SELECT * FROM bzacc.group_kala_top WHERE group_type_top=2 AND code_group_kala_top!=6 AND code_group_kala_top!=9";
	$all = $db->query($q);
    while($row=$db->fetch_assoc($all))
	{
     //فیلد اول 
	 $mojodyAvalNaKhales=$db->get_from_where("SUM(mojody_nakhales_aval)","$mydatabase.mojody_kala T INNER JOIN $mydatabase.kala ON kala.code_kala=T.code_kala INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","code_group_kala_top=".$row['code_group_kala_top']." AND year='$mtActiveYear' AND list_sardkhane.situation_type=1 AND list_sardkhane.activate=1 AND deleted=0");
	 //فیلد دوم
	 //تخلیه در انبار-تحویل روباری-حمل با راه آهن تخلیه -حمل با راه آهن روباری-خرید داخلی
	 $kharidghateeNaKhales=$db->get_from_where("SUM(vazn_nakhales_r_d_sub)","$mydatabase.resid_kala_detail T INNER JOIN $mydatabase.resid r ON T.shomare_resid=r.shomare_resid AND T.code_ostan=r.code_ostan AND T.code_anbar=r.code_anbar AND T.year=r.year INNER JOIN $mydatabase.kala ON kala.code_kala=T.code_kala INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","code_group_kala_top=".$row['code_group_kala_top']." AND r.year='$mtActiveYear' AND list_sardkhane.situation_type=1 AND list_sardkhane.activate=1 AND r.deleted=0 AND r.status=0 AND(noe_tahvil_bar=1 OR noe_tahvil_bar=2 OR noe_tahvil_bar=3)");
	 //فیلد سوم
	 $darrahNaKhales=$db->get_from_where("SUM(vazn_nakhales_h_d)","$mydatabase.havale_detail T INNER JOIN $mydatabase.havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year INNER JOIN $mydatabase.kala ON kala.code_kala=T.code_kala INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","code_group_kala_top=".$row['code_group_kala_top']." AND h.noe_tahvil_bar=4 AND T.year=".$mtActiveYear." AND list_sardkhane.situation_type=1 AND list_sardkhane.activate=1 AND T.havale_deleted=0 AND T.status=0 AND not find_in_set(h.id,(SELECT group_concat(id_havale SEPARATOR ',') FROM $mydatabase.resid WHERE deleted=0 AND status=0 AND (noe_tahvil_bar=4 or noe_tahvil_bar=5)))");
	 //فیلد چهارم
	 $jameVaredeNaKhales=$db->get_from_where("SUM(vazn_nakhales_r_d_sub)","$mydatabase.resid_kala_detail T INNER JOIN $mydatabase.kala ON kala.code_kala=T.code_kala INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","code_group_kala_top=".$row['code_group_kala_top']." AND T.year='$mtActiveYear' AND list_sardkhane.situation_type=1 AND list_sardkhane.activate=1 AND T.resid_deleted=0 AND T.status=0");
	 $jameSadereNaKhales=$db->get_from_where("SUM(vazn_nakhales_h_d)","$mydatabase.havale_detail T INNER JOIN $mydatabase.kala ON kala.code_kala=T.code_kala INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","code_group_kala_top=".$row['code_group_kala_top']." AND T.year='$mtActiveYear' AND list_sardkhane.situation_type=1 AND list_sardkhane.activate=1 AND havale_deleted=0 AND T.status=0");
	 $meghdarTadil_EzafeNaKhales=$db->get_from_where("SUM(meghdar_nakhales_tadil)","$mydatabase.tadil_mojody T INNER JOIN $mydatabase.kala ON T.code_kala=kala.code_kala INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","code_group_kala_top=".$row['code_group_kala_top']." AND year='$mtActiveYear' AND list_sardkhane.situation_type=1 AND list_sardkhane.activate=1 AND deleted=0  AND status=0  AND noe_tadil=1");
	 $meghdarTadil_KasryNaKhales=$db->get_from_where("SUM(meghdar_nakhales_tadil)","$mydatabase.tadil_mojody T INNER JOIN $mydatabase.kala ON T.code_kala=kala.code_kala INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","code_group_kala_top=".$row['code_group_kala_top']." AND year='$mtActiveYear' AND list_sardkhane.situation_type=1 AND list_sardkhane.activate=1 AND deleted=0  AND status=0  AND noe_tadil=2");
	 $mandeNaKhales=$mojodyAvalNaKhales+$jameVaredeNaKhales-$jameSadereNaKhales+$meghdarTadil_EzafeNaKhales-$meghdarTadil_KasryNaKhales;
	 $edtClick='onClick="window.location=\''.$child_page.'?noe_namayesh_=2&code_group_kala_top_='.$row['code_group_kala_top'].'&name_group_kala_top_='.$row['name_group_kala_top'].'\'"';
     if($i++%2){echo'<tr class="table-odd">';}
     else{echo'<tr class="table-even">';}
	 echo'
	  <td '.$edtClick.'>'.$row['name_group_kala_top'].'</td>
	  <td '.$edtClick.'>'.round($mojodyAvalNaKhales,3).'</td>
	  <td '.$edtClick.'>'.round($kharidghateeNaKhales,3).'</td>
	  <td '.$edtClick.'>'.round($darrahNaKhales,3).'</td>
	  <td '.$edtClick.'>'.round($mandeNaKhales,3).'</td>
	</tr>';
	}
	echo'
   </table>
  </td>
 </tr>
 <!--تعداد-->
 <tr>
  <td height="100%">
   <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
	<tr class="table-title" style="background-color:#191970"><td  colspan="7">تعداد کارتن یا قوطی</td></tr>
	<tr class="table-title">
	 <td width="10%">گروه کالا</td>
	 <td width="15%">موجودی اول دوره</td>
	 <td width="15%">خرید قطعی</td>
	 <td width="15%">کالای در راه</td>
	 <td width="15%">مانده حواله فروش</td>
	 <td width="15%">مانده موجودی</td>
	 <td width="15%">مانده موجودی پس از کسر حواله فروش</td>
	</tr>';
	$i=0;
	$q="SELECT * FROM bzacc.group_kala_top WHERE group_type_top=2 AND code_group_kala_top!=9";
	$all = $db->query($q);
    while($row=$db->fetch_assoc($all))
	{
     //فیلد اول 
	 $mojodyAvalTedad=$db->get_from_where("SUM(tedad_karton_aval)","$mydatabase.mojody_kala T INNER JOIN $mydatabase.kala ON kala.code_kala=T.code_kala INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","code_group_kala_top=".$row['code_group_kala_top']." AND year='$mtActiveYear' AND list_sardkhane.situation_type=1 AND list_sardkhane.activate=1 AND deleted=0");
	 //فیلد دوم
	 //تخلیه در انبار-تحویل روباری-حمل با راه آهن تخلیه -حمل با راه آهن روباری-خرید داخلی
	 $kharidghateeTedad=$db->get_from_where("SUM(tedad_karton_r_d_sub)","$mydatabase.resid_kala_detail T INNER JOIN $mydatabase.resid r ON T.shomare_resid=r.shomare_resid AND T.code_ostan=r.code_ostan AND T.code_anbar=r.code_anbar AND T.year=r.year INNER JOIN $mydatabase.kala ON kala.code_kala=T.code_kala INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","code_group_kala_top=".$row['code_group_kala_top']." AND r.year='$mtActiveYear' AND list_sardkhane.situation_type=1 AND list_sardkhane.activate=1 AND r.deleted=0 AND r.status=0 AND(noe_tahvil_bar=1 OR noe_tahvil_bar=2 OR noe_tahvil_bar=3)");
	 //فیلد سوم
	 $darrahTedad=$db->get_from_where("SUM(tedad_karton_h_d)","$mydatabase.havale_detail T INNER JOIN $mydatabase.havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year INNER JOIN $mydatabase.kala ON kala.code_kala=T.code_kala INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","code_group_kala_top=".$row['code_group_kala_top']." AND h.noe_tahvil_bar=4 AND T.year=".$mtActiveYear." AND list_sardkhane.situation_type=1 AND list_sardkhane.activate=1 AND T.havale_deleted=0 AND T.status=0 AND not find_in_set(h.id,(SELECT group_concat(id_havale SEPARATOR ',') FROM $mydatabase.resid WHERE deleted=0 AND status=0 AND (noe_tahvil_bar=4 or noe_tahvil_bar=5)))");
	 //فیلد چهارم
	 //کنسرو
	 IF($row['code_group_kala_top']==6)
	 {
	  $avaliye_havale_forushTedad=$db->get_from_where("SUM(h_pre_amount)","sell.dm_havale T INNER JOIN $mydatabase.kala ON kala.code_kala=T.h_p_code INNER JOIN sell.dm_location_goods ON h_l_code=l_id INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=dm_location_goods.l_code AND list_sardkhane.code_ostan=dm_location_goods.l_id_province","code_group_kala_top=".$row['code_group_kala_top']." AND h_id_year='$sellYearId' AND list_sardkhane.situation_type=1 AND list_sardkhane.activate=1");
	  $meghdar_ebtali_forushTedad=$db->get_from_where("SUM(his_eb_amount)","sell.dm_his_havale INNER JOIN sell.dm_havale ON dm_his_havale.his_h_id=dm_havale.h_id INNER JOIN sell.dm_ebtal_h ON dm_his_havale.his_id=dm_ebtal_h.ebh_h_id INNER JOIN sell.dm_location_goods ON h_l_code=l_id INNER JOIN $mydatabase.kala ON kala.code_kala=dm_havale.h_p_code INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=dm_location_goods.l_code AND list_sardkhane.code_ostan=dm_location_goods.l_id_province","code_group_kala_top=".$row['code_group_kala_top']." AND h_id_year='$sellYearId' AND list_sardkhane.situation_type=1 AND list_sardkhane.activate=1");
	  $tahvilghateeTedad=$db->get_from_where("SUM(tedad_karton_h_d)","$mydatabase.havale_detail T INNER JOIN $mydatabase.havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year INNER JOIN $mydatabase.kala ON kala.code_kala=T.code_kala INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","code_group_kala_top=".$row['code_group_kala_top']."  AND h.year='$mtActiveYear' AND list_sardkhane.situation_type=1 AND list_sardkhane.activate=1 AND h.deleted=0 AND h.status=0 AND (noe_tahvil_bar=1 OR noe_tahvil_bar=2 OR noe_tahvil_bar=3)");	
	  $mande_forushTedad=$avaliye_havale_forushTedad-$meghdar_ebtali_forushTedad-$tahvilghateeTedad;
	 }
	 ELSE $mande_forushTedad=0;
	 //فیلد پنجم
	 $jameVaredeTedad=$db->get_from_where("SUM(tedad_karton_r_d_sub)","$mydatabase.resid_kala_detail T INNER JOIN $mydatabase.kala ON kala.code_kala=T.code_kala INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","code_group_kala_top=".$row['code_group_kala_top']." AND T.year='$mtActiveYear' AND list_sardkhane.situation_type=1 AND list_sardkhane.activate=1 AND T.resid_deleted=0 AND T.status=0");
	 $jameSadereTedad=$db->get_from_where("SUM(tedad_karton_h_d)","$mydatabase.havale_detail T INNER JOIN $mydatabase.kala ON kala.code_kala=T.code_kala INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","code_group_kala_top=".$row['code_group_kala_top']." AND T.year='$mtActiveYear' AND list_sardkhane.situation_type=1 AND list_sardkhane.activate=1 AND havale_deleted=0 AND T.status=0");
	 $meghdarTadil_EzafeTedad=$db->get_from_where("SUM(tedad_karton_tadil)","$mydatabase.tadil_mojody T INNER JOIN $mydatabase.kala ON T.code_kala=kala.code_kala INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","code_group_kala_top=".$row['code_group_kala_top']." AND year='$mtActiveYear' AND list_sardkhane.situation_type=1 AND list_sardkhane.activate=1 AND deleted=0  AND status=0  AND noe_tadil=1");
	 $meghdarTadil_KasryTedad=$db->get_from_where("SUM(tedad_karton_tadil)","$mydatabase.tadil_mojody T INNER JOIN $mydatabase.kala ON T.code_kala=kala.code_kala INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","code_group_kala_top=".$row['code_group_kala_top']." AND year='$mtActiveYear' AND list_sardkhane.situation_type=1 AND list_sardkhane.activate=1 AND deleted=0  AND status=0  AND noe_tadil=2");
	 $mandeTedad=$mojodyAvalTedad+$jameVaredeTedad-$jameSadereTedad+$meghdarTadil_EzafeTedad-$meghdarTadil_KasryTedad;
	 //فیلد ششم
	 $mande_pas_az_kasrTedad=$mandeTedad-$mande_forushTedad;
	 $edtClick='onClick="window.location=\''.$child_page.'?noe_namayesh_=3&code_group_kala_top_='.$row['code_group_kala_top'].'&name_group_kala_top_='.$row['name_group_kala_top'].'\'"';
     if($i++%2){echo'<tr class="table-odd">';}
     else{echo'<tr class="table-even">';}
	 echo'
	  <td '.$edtClick.'>'.$row['name_group_kala_top'].'</td>
	  <td '.$edtClick.'>'.virgul($mojodyAvalTedad).'</td>
	  <td '.$edtClick.'>'.virgul($kharidghateeTedad).'</td>
	  <td '.$edtClick.'>'.virgul($darrahTedad).'</td>
	  <td '.$edtClick.'>';
	  IF($row['code_group_kala_top']==6) echo''.virgul($mande_forushTedad).'';
	  ELSE echo'-';
	  echo'
	  </td>
	  <td '.$edtClick.'>'.virgul($mandeTedad).'</td>
	  <td '.$edtClick.'>'.virgul($mande_pas_az_kasrTedad).'</td>
	</tr>';
	}
	echo'
   </table>
  </td>
 </tr>
 <!--شانه-->
 <tr>
  <td height="100%">
   <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
	<tr class="table-title" style="background-color:#191970"><td  colspan="7">تعداد شانه</td></tr>
	<tr class="table-title">
	 <td width="10%">گروه کالا</td>
	 <td width="15%">موجودی اول دوره</td>
	 <td width="15%">خرید قطعی</td>
	 <td width="15%">کالای در راه</td>
	 <td width="15%">مانده حواله فروش</td>
	 <td width="15%">مانده موجودی</td>
	 <td width="15%">مانده موجودی پس از کسر حواله فروش</td>
	</tr>';
	$i=0;
	$q="SELECT * FROM bzacc.group_kala_top WHERE group_type_top=2 AND code_group_kala_top=7";
	$all = $db->query($q);
    while($row=$db->fetch_assoc($all))
	{
     //فیلد اول 
	 $mojodyAvalShane=$db->get_from_where("SUM(tedad_shane_aval)","$mydatabase.mojody_kala T INNER JOIN $mydatabase.kala ON kala.code_kala=T.code_kala INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","code_group_kala_top=".$row['code_group_kala_top']." AND year='$mtActiveYear' AND list_sardkhane.situation_type=1 AND list_sardkhane.activate=1 AND deleted=0");
	 //فیلد دوم
	 //تخلیه در انبار-تحویل روباری-حمل با راه آهن تخلیه -حمل با راه آهن روباری-خرید داخلی
	 $kharidghateeShane=$db->get_from_where("SUM(tedad_shane_r_d_sub)","$mydatabase.resid_kala_detail T INNER JOIN $mydatabase.resid r ON T.shomare_resid=r.shomare_resid AND T.code_ostan=r.code_ostan AND T.code_anbar=r.code_anbar AND T.year=r.year INNER JOIN $mydatabase.kala ON kala.code_kala=T.code_kala INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","code_group_kala_top=".$row['code_group_kala_top']." AND r.year='$mtActiveYear' AND list_sardkhane.situation_type=1 AND list_sardkhane.activate=1 AND r.deleted=0 AND r.status=0 AND(noe_tahvil_bar=1 OR noe_tahvil_bar=2 OR noe_tahvil_bar=3)");
	 //فیلد سوم
	 $darrahShane=$db->get_from_where("SUM(tedad_shane_h_d)","$mydatabase.havale_detail T INNER JOIN $mydatabase.havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year INNER JOIN $mydatabase.kala ON kala.code_kala=T.code_kala INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","code_group_kala_top=".$row['code_group_kala_top']." AND h.noe_tahvil_bar=4 AND T.year=".$mtActiveYear." AND list_sardkhane.situation_type=1 AND list_sardkhane.activate=1 AND T.havale_deleted=0 AND T.status=0 AND not find_in_set(h.id,(SELECT group_concat(id_havale SEPARATOR ',') FROM $mydatabase.resid WHERE deleted=0 AND status=0 AND (noe_tahvil_bar=4 or noe_tahvil_bar=5)))");
	 //فیلد چهارم
	 $avaliye_havale_forushShane=$db->get_from_where("SUM(h_pre_amount)","sell.dm_havale T INNER JOIN $mydatabase.kala ON kala.code_kala=T.h_p_code INNER JOIN sell.dm_location_goods ON h_l_code=l_id INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=dm_location_goods.l_code AND list_sardkhane.code_ostan=dm_location_goods.l_id_province","code_group_kala_top=".$row['code_group_kala_top']." AND h_id_year='$sellYearId' AND list_sardkhane.situation_type=1 AND list_sardkhane.activate=1");
	 $meghdar_ebtali_forushShane=$db->get_from_where("SUM(his_eb_amount)","sell.dm_his_havale INNER JOIN sell.dm_havale ON dm_his_havale.his_h_id=dm_havale.h_id INNER JOIN sell.dm_ebtal_h ON dm_his_havale.his_id=dm_ebtal_h.ebh_h_id INNER JOIN sell.dm_location_goods ON h_l_code=l_id INNER JOIN $mydatabase.kala ON kala.code_kala=dm_havale.h_p_code INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=dm_location_goods.l_code AND list_sardkhane.code_ostan=dm_location_goods.l_id_province","code_group_kala_top=".$row['code_group_kala_top']." AND h_id_year='$sellYearId' AND list_sardkhane.situation_type=1 AND list_sardkhane.activate=1");
	 $tahvilghateeShane=$db->get_from_where("SUM(tedad_shane_h_d)","$mydatabase.havale_detail T INNER JOIN $mydatabase.havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year INNER JOIN $mydatabase.kala ON kala.code_kala=T.code_kala INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","code_group_kala_top=".$row['code_group_kala_top']."  AND h.year='$mtActiveYear' AND list_sardkhane.situation_type=1 AND list_sardkhane.activate=1 AND h.deleted=0 AND h.status=0 AND (noe_tahvil_bar=1 OR noe_tahvil_bar=2 OR noe_tahvil_bar=3)");	
	 $mande_forushShane=$avaliye_havale_forushShane-$meghdar_ebtali_forushShane-$tahvilghateeShane;
	 //فیلد پنجم
	 $jameVaredeShane=$db->get_from_where("SUM(tedad_shane_r_d_sub)","$mydatabase.resid_kala_detail T INNER JOIN $mydatabase.kala ON kala.code_kala=T.code_kala INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","code_group_kala_top=".$row['code_group_kala_top']." AND T.year='$mtActiveYear' AND list_sardkhane.situation_type=1 AND list_sardkhane.activate=1 AND T.resid_deleted=0 AND T.status=0");
	 $jameSadereShane=$db->get_from_where("SUM(tedad_shane_h_d)","$mydatabase.havale_detail T INNER JOIN $mydatabase.kala ON kala.code_kala=T.code_kala INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","code_group_kala_top=".$row['code_group_kala_top']." AND T.year='$mtActiveYear' AND list_sardkhane.situation_type=1 AND list_sardkhane.activate=1 AND havale_deleted=0 AND T.status=0");
	 $meghdarTadil_EzafeShane=$db->get_from_where("SUM(tedad_shane_tadil)","$mydatabase.tadil_mojody T INNER JOIN $mydatabase.kala ON T.code_kala=kala.code_kala INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","code_group_kala_top=".$row['code_group_kala_top']." AND year='$mtActiveYear' AND list_sardkhane.situation_type=1 AND list_sardkhane.activate=1 AND deleted=0  AND status=0  AND noe_tadil=1");
	 $meghdarTadil_KasryShane=$db->get_from_where("SUM(tedad_shane_tadil)","$mydatabase.tadil_mojody T INNER JOIN $mydatabase.kala ON T.code_kala=kala.code_kala INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","code_group_kala_top=".$row['code_group_kala_top']." AND year='$mtActiveYear' AND list_sardkhane.situation_type=1 AND list_sardkhane.activate=1 AND deleted=0  AND status=0  AND noe_tadil=2");
	 $mandeShane=$mojodyAvalShane+$jameVaredeShane-$jameSadereShane+$meghdarTadil_EzafeShane-$meghdarTadil_KasryShane;
	 //فیلد َششم
	 $mande_pas_az_kasrShane=$mandeShane-$mande_forushShane;
	 $edtClick='onClick="window.location=\''.$child_page.'?noe_namayesh_=4&code_group_kala_top_='.$row['code_group_kala_top'].'&name_group_kala_top_='.$row['name_group_kala_top'].'\'"';
     if($i++%2){echo'<tr class="table-odd">';}
     else{echo'<tr class="table-even">';}
	 echo'
	  <td '.$edtClick.'>'.$row['name_group_kala_top'].'</td>
	  <td '.$edtClick.'>'.virgul($mojodyAvalShane).'</td>
	  <td '.$edtClick.'>'.virgul($kharidghateeShane).'</td>
	  <td '.$edtClick.'>'.virgul($darrahShane).'</td>
	  <td '.$edtClick.'>'.virgul($mande_forushShane).'</td>
	  <td '.$edtClick.'>'.virgul($mandeShane).'</td>
	  <td '.$edtClick.'>'.virgul($mande_pas_az_kasrShane).'</td>
	</tr>';
	}
	echo'
   </table>
  </td>
 </tr>
 <tr class="print_footer noExl" >
    <td colspan="50">&nbsp;&nbsp;نام کاربر :&nbsp;&nbsp;'.$mtuserNAME.' &nbsp;&nbsp;&nbsp; تاریخ چاپ : '.$today.' &nbsp;&nbsp;&nbsp; ساعت چاپ : '.$logtime.'</td>
 </tr> 
 <!--پايان مرکز صفحه -->
</table>
</form>
</body>
</html>
<a href="#" class="elevator-button"></a>';	
?>
<script type="text/javascript" src="scripts/elevator.min.js"></script>
<script type="text/javascript">
function popupwindow(url, title, w, h) {
  var left = (screen.width/2)-(w/2);
  var top = (screen.height/2)-(h/2);
  return window.open(url, title, "toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width="+w+", height="+h+", top="+top+", left="+left);
}
//setTimeout(function(){ location.reload(); }, 10000); 
</script>