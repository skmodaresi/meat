<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
/***************************ajax شروع**********************************/
if((isset($_POST['shomareBaskul']))and(isset($_POST['noeTahvilBar'])))
{
  $result=mysql_query("SELECT bsk_id,bsk_no,bsk_ranande.ranande_name,bsk_ranande.ranande_melicode,bsk_ranande.ranande_tel,bsk_ranande.shomare_hesab_ranande,bsk_ranande.bank_ranande,nb_noe_bank,
        plak1,plak2,plak3,plak4,bsk_kamion.noe_khodro,cmp_khodro,vazn_khali,vazn_por,mbd_barname.barname_id,mbd_barname.barname_no,mbd_barname.barname_sn,
		mbd_barname.barname_tarikh,mbd_barname.meghdar_b,mbd_barname.paskeraye,bsk_kamion.noe_khodro  
        FROM baskool.bsk_data
        INNER JOIN baskool.bsk_kamion ON bsk_data.kamion_id=bsk_kamion.kamion_id
        INNER JOIN baskool.bsk_ranande ON bsk_data.ranande_id=bsk_ranande.ranande_id
		LEFT JOIN payroll.pay_c_noe_bank ON pay_c_noe_bank.id=bsk_ranande.bank_ranande
		LEFT JOIN mabadi.mbd_barname ON bsk_data.lnk_id=mbd_barname.barname_id
		WHERE anbar_id='$mt_gl_id_anbar' AND bsk_no='$shomareBaskul'");
  
  $row_tozin=mysql_fetch_assoc($result);
  IF($row_tozin['barname_tarikh'])$tarikh_barname=AsLDate($row_tozin['barname_tarikh']);
  //$vazn_khales_h=$row_tozin['vazn_por']-$row_tozin['vazn_khali'];                                       
  //if($vazn_khales_h<0) $vazn_khales_h=0;
  //در سیستم باسکول 0 یعنی دستی 1 یعنی کمپرسی
  //در سیستم انبار 1 دستی 2 کمپرسی
  $cmp_khodro=$row_tozin['cmp_khodro']+1;
  //if(($noeTahvilBar==4)OR($noeTahvilBar==5))echo $row_tozin['bsk_id'].'^'.$row_tozin['bsk_no'].'^'.$row_tozin['noe_ziranbar'].'^'.$row_tozin['code_ziranbar'].'^'.$row_tozin['name_ziranbar'].'^'.$row_tozin['plak1'].'^'.$row_tozin['plak2'].'^'.$row_tozin['plak3'].'^'.$row_tozin['plak4'].'^'.$row_tozin['ranande_name'].'^'.$row_tozin['ranande_melicode'].'^'.$row_tozin['shomare_hesab_ranande'].'^'.$row_tozin['bank_ranande'].'^'.$row_tozin['nb_noe_bank'].'^'.$row_tozin['ranande_tel'].'^'.$cmp_khodro.'^'.$row_tozin['code_kala'].'^'.$row_tozin['vazn_por'].'^'.$row_tozin['vazn_khali'].'^'.$vazn_khales_h;
  //else echo $row_tozin['bsk_id'].'^'.$row_tozin['bsk_no'].'^'.$row_tozin['noe_ziranbar'].'^'.$row_tozin['code_ziranbar'].'^'.$row_tozin['name_ziranbar'].'^'.$row_tozin['plak1'].'^'.$row_tozin['plak2'].'^'.$row_tozin['plak3'].'^'.$row_tozin['plak4'].'^'.$row_tozin['ranande_name'].'^'.$row_tozin['ranande_melicode'].'^'.$row_tozin['shomare_hesab_ranande'].'^'.$row_tozin['bank_ranande'].'^'.$row_tozin['nb_noe_bank'].'^'.$row_tozin['ranande_tel'].'^'.$cmp_khodro.'^'.$row_tozin['code_kala'].'^'.$row_tozin['vazn_por'].'^'.$row_tozin['vazn_khali'].'^'.$vazn_khales_h.'^'.$row_tozin['barname_id'].'^'.$row_tozin['barname_no'].'^'.$row_tozin['barname_sn'].'^'.$tarikh_barname.'^'.$row_tozin['meghdar_b'].'^'.$row_tozin['paskeraye'].'^'.$row_tozin['noe_khodro'];
  echo $row_tozin['bsk_id'].'^'.$row_tozin['bsk_no'].'^'.$row_tozin['plak1'].'^'.$row_tozin['plak2'].'^'.$row_tozin['plak3'].'^'.$row_tozin['plak4'].'^'.$row_tozin['ranande_name'].'^'.$row_tozin['ranande_melicode'].'^'.$row_tozin['shomare_hesab_ranande'].'^'.$row_tozin['bank_ranande'].'^'.$row_tozin['nb_noe_bank'].'^'.$row_tozin['ranande_tel'].'^'.$cmp_khodro.'^'.$row_tozin['vazn_por'].'^'.$row_tozin['vazn_khali'].'^'.$row_tozin['barname_id'].'^'.$row_tozin['barname_no'].'^'.$row_tozin['barname_sn'].'^'.$tarikh_barname.'^'.$row_tozin['noe_khodro'];
  // echo "SELECT bsk_id,bsk_no,bsk_ranande.ranande_name,bsk_ranande.ranande_melicode,bsk_ranande.ranande_tel,bsk_ranande.shomare_hesab_ranande,bsk_ranande.bank_ranande,nb_noe_bank,
        // plak1,plak2,plak3,plak4,bsk_kamion.noe_khodro,cmp_khodro,vazn_khali,vazn_por,mbd_barname.barname_id,mbd_barname.barname_no,mbd_barname.barname_sn,
		// mbd_barname.barname_tarikh,mbd_barname.meghdar_b,mbd_barname.paskeraye,bsk_kamion.noe_khodro  
        // FROM baskool.bsk_data
        // INNER JOIN baskool.bsk_kamion ON bsk_data.kamion_id=bsk_kamion.kamion_id
        // INNER JOIN baskool.bsk_ranande ON bsk_data.ranande_id=bsk_ranande.ranande_id
		// LEFT JOIN payroll.pay_c_noe_bank ON pay_c_noe_bank.id=bsk_ranande.bank_ranande
		// LEFT JOIN mabadi.mbd_barname ON bsk_data.lnk_id=mbd_barname.barname_id
		// WHERE anbar_id='$mt_gl_id_anbar' AND bsk_no='$shomareBaskul'";
}    
?>