<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="print_dashboard_ostan.php";
$titr=' داشبورد اطلاعات کالاهای گوشتی :('.$name_group_kala_top_.') به تفکیک استان ها ' .$namayeshArr[$noe_namayesh_];
$query_find = $db->query("set session group_concat_max_len=250000");
echo'
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>'.$titr.'</title>
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
</head>';
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
 <!--هدر-->
   <table width="99%" border="1" align="center">
     <tr><td class="print_title_2">'.$mt_gl_owner.'</td></tr>
     <tr><td class="print_title_2">'.$titr.'&nbsp&nbsp(صفحه : 1)
	      <a href="javascript:window.print();"><span style="float:right" id="printerReport" class="hideatprint" title="چاپ"></span></a>
		 </td>
	 </tr>  
    </table>
 <!--پايان هدر-->
 <!-- مرکز صفحه-->	
   <table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
	<tr class="table-title">
	 <td width="5%">ردیف</td>
	 <td width="14%">استان</td>
	 <td width="14%">موجودی اول دوره</td>
	 <td width="13%">خرید قطعی</td>
	 <td width="13%">کالای در راه</td>';
	 IF((($noe_namayesh_==1)AND(($code_group_kala_top_==4)OR($code_group_kala_top_==5)OR($code_group_kala_top_==8)))OR(($noe_namayesh_==3)AND($code_group_kala_top_==6))OR(($noe_namayesh_==4)AND($code_group_kala_top_==7)))
     {echo'<td width="14%">مانده حواله فروش</td>';}
	 echo'<td width="13%">مانده موجودی</td>';
	 IF((($noe_namayesh_==1)AND(($code_group_kala_top_==4)OR($code_group_kala_top_==5)OR($code_group_kala_top_==8)))OR(($noe_namayesh_==3)AND($code_group_kala_top_==6))OR(($noe_namayesh_==4)AND($code_group_kala_top_==7)))
	 {echo'<td width="14%">مانده موجودی پس از کسر حواله فروش</td>';}
	 echo'
	</tr>';
	$page=1;
    $line=0;
    $i=0;$cntr=0;
    $MaxLines=15;
	$q="SELECT * FROM $mydatabase.ostan ORDER BY name_ostan";
	$all = $db->query($q);
	$cntr =mysql_num_rows($all);
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
	 
     $line++;
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
	  if ($line>=$MaxLines && $i <$cntr) 
	  {
		 $line=0;
         $page++;
	     echo'
		   </table>
		   <br class="pbreak">
		   <table width="99%" border="1" align="center">
            <tr><td class="print_title_2">'.$mt_gl_owner.'</td></tr>
            <tr><td class="print_title_2">'.$titr.'&nbsp&nbsp(صفحه : '.$page.')
	        	</td>
	        </tr>
           </table>
		   <table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
	        <tr class="table-title">
	         <td width="5%">ردیف</td>
	         <td width="14%">استان</td>
	         <td width="14%">موجودی اول دوره</td>
	         <td width="13%">خرید قطعی</td>
	         <td width="13%">کالای در راه</td>';
	         IF((($noe_namayesh_==1)AND(($code_group_kala_top_==4)OR($code_group_kala_top_==5)OR($code_group_kala_top_==8)))OR(($noe_namayesh_==3)AND($code_group_kala_top_==6))OR(($noe_namayesh_==4)AND($code_group_kala_top_==7)))
             {echo'<td width="14%">مانده حواله فروش</td>';}
	         echo'<td width="13%">مانده موجودی</td>';
	         IF((($noe_namayesh_==1)AND(($code_group_kala_top_==4)OR($code_group_kala_top_==5)OR($code_group_kala_top_==8)))OR(($noe_namayesh_==3)AND($code_group_kala_top_==6))OR(($noe_namayesh_==4)AND($code_group_kala_top_==7)))
	         {echo'<td width="14%">مانده موجودی پس از کسر حواله فروش</td>';}
	         echo'
	        </tr>
		   ';
	  }
	}
	echo'
   </table>
 <!--پايان مرکز صفحه -->
 <!-- چاپ زیرنویس-->
<table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">   
 <tr class="print_footer">
  <td colspan="3">&nbsp;&nbsp;نام کاربر :&nbsp;&nbsp;'.$bzuserNAME.' &nbsp;&nbsp;&nbsp; تاریخ چاپ : '.$today.' &nbsp;&nbsp;&nbsp; ساعت چاپ : '.$logtime.'</td>
 </tr>	 
</table>
</form>
</body>
</html>
<a href="#" class="elevator-button"></a>';	
?>
<script type="text/javascript" src="scripts/elevator.min.js"></script>
