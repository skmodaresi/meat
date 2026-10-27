<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="dashboard_ostan.php";
$FileName_parent="dashboard.php";
$titr=' داشبورد اطلاعات کالاهای گوشتی :('.$name_group_kala_top_.') به تفکیک استان ها ' .$namayeshArr[$noe_namayesh_];
require_once('head.html');
$query_find = $db->query("set session group_concat_max_len=250000");
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<form method="post" name="myform">
<table border="1" width="98%" bordercolor="#111" align="center" cellpadding="0" cellspacing="0">
 <tr>
  <td class="title">
   <div style="position:absolute;top:5px;left:35%;">'.$titr.'</div>
   <div style="float:right;">
    <span class="fa fa-refresh" style="color:#FFF;cursor:pointer;font-size:20px" title="به روزرسانی" onClick="window.location.reload()">&nbsp;</span>
    <span class="fa fa-print" style="color:#FFF;cursor:pointer;font-size:20px" title="چاپ" onClick="popupwindow(\'print_dashboard_ostan.php?code_group_kala_top_='.$code_group_kala_top_.'&name_group_kala_top_='.$name_group_kala_top_.'&noe_namayesh_='.$noe_namayesh_.'\',\'\',850,600)">&nbsp;</span>
    <span class="fa fa-share" style="color:#FFF;cursor:pointer;font-size:20px" title="بازگشت" onClick="window.location=\'dashboard.php\'">&nbsp;</span>

   </div>
   <!--<div style="float:left;"><button class="buttonme" onClick="window.location=\'dashboard.php\'" >بازگشت</button></div>-->
   
  <!--<span class="fa fa-refresh " style="color:#FFF">&nbsp;</span>
  <span class="fa fa-print " style="color:#FFF">&nbsp;</span>
  <span class="fa fa fa-file-excel-o  " style="color:#FFF">&nbsp;</span>-->
  </td>
 </tr>';
 echo'
 <tr>
  <td height="100%">
   <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
	<tr class="table-title">
	 <td width="5%">ردیف</td>
	 <td width="14%">استان</td>
	 <td width="14%">موجودی اول دوره</td>
	 <td width="13%">خرید قطعی</td>
	 <td width="13%">کالای در راه</td>';
	 //IF($noe_namayesh_!=2) echo'<td width="15%">مانده حواله فروش</td>';
	 IF((($noe_namayesh_==1)AND(($code_group_kala_top_==4)OR($code_group_kala_top_==5)OR($code_group_kala_top_==8)))OR(($noe_namayesh_==3)AND($code_group_kala_top_==6))OR(($noe_namayesh_==4)AND($code_group_kala_top_==7)))
     {echo'<td width="14%">مانده حواله فروش</td>';}
	 echo'<td width="13%">مانده موجودی</td>';
	 //IF($noe_namayesh_!=2) echo'<td width="15%">مانده موجودی پس از کسر حواله فروش</td>';
	 IF((($noe_namayesh_==1)AND(($code_group_kala_top_==4)OR($code_group_kala_top_==5)OR($code_group_kala_top_==8)))OR(($noe_namayesh_==3)AND($code_group_kala_top_==6))OR(($noe_namayesh_==4)AND($code_group_kala_top_==7)))
	 {echo'<td width="14%">مانده موجودی پس از کسر حواله فروش</td>';}
	 echo'
	</tr>';
	$i=0;
	$q="SELECT * FROM $mydatabase.ostan ORDER BY name_ostan";
	$all = $db->query($q);
    $radif=1;
	while($row=$db->fetch_assoc($all))
	{
     //تعیین فیلدها براساس نوع نمایش
	 IF($noe_namayesh_==1){$avalField='mojody_khales_aval';$residField='vazn_khales_r_d_sub';$havaleField='vazn_khales_h_d';$tadilField='meghdar_khales_tadil';}
	 ELSE IF($noe_namayesh_==2){$avalField='mojody_nakhales_aval';$residField='vazn_nakhales_r_d_sub';$havaleField='vazn_nakhales_h_d';$tadilField='meghdar_nakhales_tadil';}
	 ELSE IF($noe_namayesh_==3){$avalField='tedad_karton_aval';$residField='tedad_karton_r_d_sub';$havaleField='tedad_karton_h_d';$tadilField='tedad_karton_tadil';}
	 ELSE IF($noe_namayesh_==4){$avalField='tedad_shane_aval';$residField='tedad_shane_r_d_sub';$havaleField='tedad_shane_h_d';$tadilField='tedad_shane_tadil';}
	 //فیلد اول 
	 $mojodyAval=$db->get_from_where("SUM($avalField)","$mydatabase.mojody_kala T INNER JOIN $mydatabase.kala ON kala.code_kala=T.code_kala INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","code_group_kala_top=".$code_group_kala_top_." AND T.code_ostan=".$row['code_ostan']." AND year='$mtActiveYear' AND list_sardkhane.situation_type=1 AND list_sardkhane.activate=1 AND deleted=0");
	 //فیلد دوم
	 //تخلیه در انبار-تحویل روباری-حمل با راه آهن تخلیه -حمل با راه آهن روباری-خرید داخلی
	 $kharidghatee=$db->get_from_where("SUM($residField)","$mydatabase.resid_kala_detail T INNER JOIN $mydatabase.resid r ON T.shomare_resid=r.shomare_resid AND T.code_ostan=r.code_ostan AND T.code_anbar=r.code_anbar AND T.year=r.year INNER JOIN $mydatabase.kala ON kala.code_kala=T.code_kala INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","code_group_kala_top=".$code_group_kala_top_." AND T.code_ostan=".$row['code_ostan']." AND r.year='$mtActiveYear' AND list_sardkhane.situation_type=1 AND list_sardkhane.activate=1 AND r.deleted=0 AND r.status=0 AND(noe_tahvil_bar=1 OR noe_tahvil_bar=2 OR noe_tahvil_bar=3)");
	 //فیلد سوم
	 $darrah=$db->get_from_where("SUM($havaleField)","$mydatabase.havale_detail T INNER JOIN $mydatabase.havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year INNER JOIN $mydatabase.kala ON kala.code_kala=T.code_kala INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","code_group_kala_top=".$code_group_kala_top_." AND h.noe_tahvil_bar=4 AND T.code_ostan=".$row['code_ostan']." AND T.year=".$mtActiveYear." AND list_sardkhane.situation_type=1 AND list_sardkhane.activate=1 AND T.havale_deleted=0 AND T.status=0 AND not find_in_set(h.id,(SELECT group_concat(id_havale SEPARATOR ',') FROM $mydatabase.resid WHERE deleted=0 AND status=0 AND (noe_tahvil_bar=4 or noe_tahvil_bar=5)))");
	 //فیلد چهارم
	 //IF($noe_namayesh_!=2)
	 IF((($noe_namayesh_==1)AND(($code_group_kala_top_==4)OR($code_group_kala_top_==5)OR($code_group_kala_top_==8)))OR(($noe_namayesh_==3)AND($code_group_kala_top_==6))OR(($noe_namayesh_==4)AND($code_group_kala_top_==7)))
	 {
	  $avaliye_havale_forush=$db->get_from_where("SUM(h_pre_amount)","sell.dm_havale T INNER JOIN $mydatabase.kala ON kala.code_kala=T.h_p_code INNER JOIN sell.dm_location_goods ON h_l_code=l_id INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=dm_location_goods.l_code AND list_sardkhane.code_ostan=dm_location_goods.l_id_province","code_group_kala_top=".$code_group_kala_top_." AND list_sardkhane.code_ostan=".$row['code_ostan']." AND h_id_year='$sellYearId' AND list_sardkhane.situation_type=1 AND list_sardkhane.activate=1");
	  $meghdar_ebtali_forush=$db->get_from_where("SUM(his_eb_amount)","sell.dm_his_havale INNER JOIN sell.dm_havale ON dm_his_havale.his_h_id=dm_havale.h_id INNER JOIN sell.dm_ebtal_h ON dm_his_havale.his_id=dm_ebtal_h.ebh_h_id INNER JOIN sell.dm_location_goods ON h_l_code=l_id INNER JOIN $mydatabase.kala ON kala.code_kala=dm_havale.h_p_code INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=dm_location_goods.l_code AND list_sardkhane.code_ostan=dm_location_goods.l_id_province","code_group_kala_top=".$code_group_kala_top_." AND list_sardkhane.code_ostan=".$row['code_ostan']." AND h_id_year='$sellYearId' AND list_sardkhane.situation_type=1 AND list_sardkhane.activate=1");
	  $tahvilghatee=$db->get_from_where("SUM($havaleField)","$mydatabase.havale_detail T INNER JOIN $mydatabase.havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year INNER JOIN $mydatabase.kala ON kala.code_kala=T.code_kala INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","code_group_kala_top=".$code_group_kala_top_." AND T.code_ostan=".$row['code_ostan']."  AND h.year='$mtActiveYear' AND list_sardkhane.situation_type=1 AND list_sardkhane.activate=1 AND h.deleted=0 AND h.status=0 AND (noe_tahvil_bar=1 OR noe_tahvil_bar=2 OR noe_tahvil_bar=3)");	
	  $mande_forush=round($avaliye_havale_forush,3)-round($meghdar_ebtali_forush,3)-round($tahvilghatee,3); 	 
	 }
	 //فیلد پنجم
	 $jameVarede=$db->get_from_where("SUM($residField)","$mydatabase.resid_kala_detail T INNER JOIN $mydatabase.kala ON kala.code_kala=T.code_kala INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","code_group_kala_top=".$code_group_kala_top_." AND T.code_ostan=".$row['code_ostan']." AND T.year='$mtActiveYear' AND list_sardkhane.situation_type=1 AND list_sardkhane.activate=1 AND T.resid_deleted=0 AND T.status=0");
	 $jameSadere=$db->get_from_where("SUM($havaleField)","$mydatabase.havale_detail T INNER JOIN $mydatabase.kala ON kala.code_kala=T.code_kala INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","code_group_kala_top=".$code_group_kala_top_." AND T.code_ostan=".$row['code_ostan']." AND T.year='$mtActiveYear' AND list_sardkhane.situation_type=1 AND list_sardkhane.activate=1 AND havale_deleted=0 AND T.status=0");
	 $meghdarTadil_Ezafe=$db->get_from_where("SUM($tadilField)","$mydatabase.tadil_mojody T INNER JOIN $mydatabase.kala ON T.code_kala=kala.code_kala INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","code_group_kala_top=".$code_group_kala_top_." AND T.code_ostan=".$row['code_ostan']." AND year='$mtActiveYear' AND list_sardkhane.situation_type=1 AND list_sardkhane.activate=1 AND deleted=0  AND status=0  AND noe_tadil=1");
	 $meghdarTadil_Kasry=$db->get_from_where("SUM($tadilField)","$mydatabase.tadil_mojody T INNER JOIN $mydatabase.kala ON T.code_kala=kala.code_kala INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","code_group_kala_top=".$code_group_kala_top_." AND T.code_ostan=".$row['code_ostan']." AND year='$mtActiveYear' AND list_sardkhane.situation_type=1 AND list_sardkhane.activate=1 AND deleted=0  AND status=0  AND noe_tadil=2");
	 $mande=$mojodyAval+$jameVarede-$jameSadere+$meghdarTadil_Ezafe-$meghdarTadil_Kasry;
	 //فیلد ششم
	 IF($noe_namayesh_!=2)$mande_pas_az_kasr=$mande-$mande_forush;
     if($i++%2){echo'<tr class="print_table-odd">';}
     else{echo'<tr class="print_table-even">';}
	 echo'
	  <td >'.$radif++.'</td>
	  <td >'.$row['name_ostan'].'</td>
	  <td >'.round($mojodyAval,3).'</td>
	  <td >'.round($kharidghatee,3).'</td>
	  <td >'.round($darrah,3).'</td>';
	  IF((($noe_namayesh_==1)AND(($code_group_kala_top_==4)OR($code_group_kala_top_==5)OR($code_group_kala_top_==8)))OR(($noe_namayesh_==3)AND($code_group_kala_top_==6))OR(($noe_namayesh_==4)AND($code_group_kala_top_==7)))
      {echo'<td >'.round($mande_forush,3).'</td>';}
	  echo'<td >'.round($mande,3).'</td>';
	  IF((($noe_namayesh_==1)AND(($code_group_kala_top_==4)OR($code_group_kala_top_==5)OR($code_group_kala_top_==8)))OR(($noe_namayesh_==3)AND($code_group_kala_top_==6))OR(($noe_namayesh_==4)AND($code_group_kala_top_==7)))
	  {echo'<td >'.round($mande_pas_az_kasr,3).'</td>';}
	  echo'
	</tr>';
	}
	echo'
   </table>
  </td>
 </tr>
 <tr class="print_footer noExl" >
    <td colspan="50">&nbsp;&nbsp;نام کاربر :&nbsp;&nbsp;'.$bzuserNAME.' &nbsp;&nbsp;&nbsp; تاریخ چاپ : '.$today.' &nbsp;&nbsp;&nbsp; ساعت چاپ : '.$logtime.'</td>
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