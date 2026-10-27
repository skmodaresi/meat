<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
/***************************ajax شروع**********************************/
IF((isset($_POST['shomareBaskul']))AND(isset($_POST['noeTahvilBar'])))//آمدن اطلاعات باسکول درحواله
{
  IF(($noeTahvilBar==1)OR($noeTahvilBar==3))//
  {
	// $result=mysql_query("SELECT tzn_id,tzn_no,anbar_mtb,plak1,plak2,plak3,plak4,vazn_khali,vazn_por,tzn_kamion.noe_khodro,l_a_d.noe_ziranbar,l_a_d.code_ziranbar,l_a_d.name_ziranbar,dm_havale.h_code FROM tozin.tzn_data
        // INNER JOIN tozin.tzn_kamion ON tzn_data.kamion_id=tzn_kamion.kamion_id
        // INNER JOIN tozin.tzn_ranande ON tzn_data.ranande_id=tzn_ranande.ranande_id
		// INNER JOIN $mydatabase.list_anbar_detail l_a_d ON tzn_data.anbar_mtb=l_a_d.id
		// INNER JOIN sell.dm_havale ON tzn_data.lnk_id=dm_havale.h_id		
		// WHERE anbar_id='$bz_gl_id_anbar' AND tzn_no='$shomareBaskul'");
  
    $result=mysql_query("SELECT bsk_id,bsk_no,bsk_ranande.ranande_name,bsk_ranande.ranande_melicode,
        plak1,plak2,plak3,plak4,bsk_kamion.noe_khodro,cmp_khodro,vazn_khali,vazn_por,dm_havale.h_code 
        FROM baskool.bsk_data
        INNER JOIN baskool.bsk_kamion ON bsk_data.kamion_id=bsk_kamion.kamion_id
        INNER JOIN baskool.bsk_ranande ON bsk_data.ranande_id=bsk_ranande.ranande_id
		INNER JOIN sell.dm_havale ON bsk_data.lnk_id=dm_havale.h_id		
		WHERE anbar_id='$mt_gl_id_anbar' AND bsk_no='$shomareBaskul'");		
  }
  ELSE//جابه جایی
  {
	$result=mysql_query("SELECT bsk_id,bsk_no,bsk_ranande.ranande_name,bsk_ranande.ranande_melicode,
        plak1,plak2,plak3,plak4,bsk_kamion.noe_khodro,cmp_khodro,vazn_khali,vazn_por,mojavez_jabejae.shomare_jabejae 
        FROM baskool.bsk_data
        INNER JOIN baskool.bsk_kamion ON bsk_data.kamion_id=bsk_kamion.kamion_id
        INNER JOIN baskool.bsk_ranande ON bsk_data.ranande_id=bsk_ranande.ranande_id
		INNER JOIN $mydatabase.mojavez_jabejae ON bsk_data.lnk_id=mojavez_jabejae.id
		WHERE anbar_id='$mt_gl_id_anbar' AND bsk_no='$shomareBaskul'");	
  }

  $row=mysql_fetch_assoc($result);
  echo $row['bsk_id'].'^'.$row['bsk_no'].'^'.$row['plak1'].'^'.$row['plak2'].'^'.$row['plak3'].'^'.$row['plak4'].'^'.$row['ranande_name'].'^'.$row['ranande_melicode'].'^'.$row['vazn_por'].'^'.$row['vazn_khali'].'^'.$row['h_code'].'^'.$row['shomare_jabejae'].'^'.$row['noe_khodro'];

}
?>