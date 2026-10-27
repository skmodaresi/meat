<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="transfer_tadil_webservice.php";
echo'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" />
<html xmlns="http://www.w3.org/1999/xhtml" dir=rtl>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>انتقال تعدیل های ارسال نشده به وب سرویس</title>
<link href="styles.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="functions.js"></script>
<link type="text/css" href="styles/jquery-ui-1.8.14.css" rel="stylesheet" />
<script type="text/javascript" src="scripts/jquery-1.6.2.min.js"></script>
</head>';
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.sal_mabda.focus();">
<form method="POST" name="myform">
<div align="center">
<table width="100%" height="100%" align="center" cellpadding="0" cellspacing="0">
 <tr>
  <td height="100%">
   <table width="600px" border="0" align="center" cellpadding="0" cellspacing="0" >
    <tr><td colspan="4" height="20px">&nbsp;</td></tr>
	<tr><td colspan="4" class="title">انتقال تعدیل های ارسال نشده به وب سرویس</td></tr>
    <tr class="tr1">
	 <td  height="60px">تعدیل اضافه : <input class="buttonme" type="submit" name="transfer_ezafe" value="انتقال تعدیل های اضافه ارسال نشده"></td> 
    <tr class="tr1">
	 <td  height="60px">تعدیل کسری : <input class="buttonme" type="submit" name="transfer_kasry" value="انتقال تعدیل های کسری ارسال نشده"></td>
    <tr class="tr1">
	 <td  height="60px">ابطال : <input class="buttonme" type="submit" name="transfer_ebtal" value="انتقال تعدیل های ابطال شده"></td>
	</tr>
	<!--<tr class="tr1">
	 <td  height="60px">ابطال : <input class="buttonme" type="submit" name="transfer_ebtal_ezafe" value="transfer ebtal ezafe"></td>
     <td  height="60px"><input class="buttonme" type="submit" name="transfer_ebtal_kasry" value="transfer ebtal kasry"></td></tr>-->
	<tr class="footer"><td colspan="4">&nbsp;</td></tr>
   </table>
  </td>
 </tr>	
</table>
</div>';
/********************WEB SERVICE NEW***********************/
if(isset($transfer_ezafe))
{
    mysql_query('SET AUTOCOMMIT=0');//TRANSACTIONشروع 
    mysql_query('START TRANSACTION');  
	$q="SELECT * From tadil_mojody t INNER JOIN list_sardkhane l_s ON t.code_ostan=l_s.code_ostan AND t.code_anbar=l_s.code_anbar INNER JOIN kala ON t.code_kala=kala.code_kala
	          WHERE noe_tadil=1 AND year=$mtActiveYear AND t.status=0 AND t.deleted=0 AND t.code_anbar!=301 AND chkwebservice=1 AND situation_type=1 AND l_s.activate=1 AND warehouse_id IS NOT NULL AND register_error_code=0 AND (webservice_JahadTracking IS NULL OR webservice_JahadTracking=0)";
	$res = mysql_query($q);	
	while($row=$db->fetch_assoc($res))
    {  
	   if(strlen($row['code_ostan'])==1) $code_a=make_pattern($row['code_ostan'],2);
       else $code_a=$row['code_ostan'];
	   $shenaseAnbar=$code_a.$row['code_anbar'];
       $shomareGhabz='t'.$mtActiveYear.$row['shomare_barge_tadil'];
	   //تبدیل تاریخ شمسی به میلادی
       $sql_tarikh=$row['tarikh_barge_tadil'];
       $d=substr($sql_tarikh,8,2);$m=substr($sql_tarikh,5,2);$y=substr($sql_tarikh,0,4);
       $milady=jalali_to_gregorian($y,$m,$d);
       $sal=$milady[0];$mah=$milady[1];$rouz=$milady[2];
       $tarikh_tadil_MI=$sal.'-'.$mah.'-'.$rouz;
	   $goodId=$row['code_kala'];
	   $processSequence=115;
	   IF($row['code_vahedkala']==1)//کیلوگرم
	   {
		  $measurement_unit=1;
	      $amount=$row['meghdar_khales_tadil'];
	   }
       ELSE IF($row['code_vahedkala']==2)//تعداد
	   {
		  $measurement_unit=6;
		  $amount=$row['tedad_karton_tadil'];   
	   }
	   $wsdl_url='http://10.7.234.33/anbar/warehouse.asmx?wsdl';
	   header('Content-Type: text/html; charset=utf-8');
       try
	   {
	     $client=new SoapClient($wsdl_url);
		 $billStuff1=array(
		   'good_id'=>$goodId,
		   'measurement_unit'=>$measurement_unit,
           'amount'=>$amount,
           'production_type'=>$row['mahmule_type']
         );
         $WarehouseDocumentDetails=array($billStuff1);
		 $WarehouseDocument =array(
		  'warehouse_id'=>$row['warehouse_id'],
		  'gov_warehouse_number'=>$shenaseAnbar,
		  'number'=>$shomareGhabz,
          'issue_date'=>$tarikh_tadil_MI,
          'owner'=>'14002771736',
          'owner_birth_date'=>null,
	      'driver_national_id'=>null,
          'driver_birth_date'=>null,
		  'vehicle_number'=>null,
		  'bol_date'=>null,
		  'bol_serial'=>null,
		  'bol_series'=>null,	 
		  'bol_tid'=>null,	 
		  'Commodities'=>$WarehouseDocumentDetails	 
         );
         $params=array(
		  'username'=>'02',
          'password'=>'HJ78mnGD',
		  'co_national_id'=>'14002771736',
          'type'=>'in',
          'process_code'=>$processSequence,
          'doc'=>$WarehouseDocument
         );
		 //echo '<pre>'; print_r($params); echo '</pre>';

		  $result=$client->SendWarehouseDocument($params); 
		  $response=$result->SendWarehouseDocumentResult;
		  $webservice_error_code =$response->error_code;
	      $webservice_error_message =$response->error_message;
	      $webservice_status =$response->status;
	      $webservice_number =$response->number;
	      $webservice_JahadTracking =$response->JahadTracking;

	     echo 'webservice_JahadTracking: ';print_r($webservice_JahadTracking);echo'<br>';		 
	   }
	   catch(SoapFault $client)
	   {
		 echo "<script>alert('وب سرویس فعال نمی باشد')</script>";
		 echo  $e->getMessage();
	   }
	   $update_track=("UPDATE tadil_mojody SET webservice_error_code='$webservice_error_code',webservice_error_message='$webservice_error_message',webservice_status='$webservice_status',webservice_number='$webservice_number',webservice_JahadTracking='$webservice_JahadTracking' WHERE code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']." AND shomare_barge_tadil='".$row['shomare_barge_tadil']."' AND year=$mtActiveYear");
	   $update_res=mysql_query($update_track);     
    }
    if($update_res)
    {
   	 mysql_query("COMMIT");
       echo "<script>alert('success')</script>"; 
       //echo "<script>window.location='$FileName'</script>";
   	}
   	else  
    {
       mysql_query('ROLLBACK');
       echo "<script>alert('error!')</script>";  
    }
    mysql_query('SET AUTOCOMMIT=1'); 	  
}
//////////////////////////////////////////////////////////////////////////////////////////////
if(isset($transfer_kasry))
{
    mysql_query('SET AUTOCOMMIT=0');//TRANSACTIONشروع 
    mysql_query('START TRANSACTION');  
	$q="SELECT * From tadil_mojody t INNER JOIN list_sardkhane l_s ON t.code_ostan=l_s.code_ostan AND t.code_anbar=l_s.code_anbar INNER JOIN kala ON t.code_kala=kala.code_kala
	          WHERE noe_tadil=2 AND year=$mtActiveYear AND t.status=0 AND t.deleted=0 AND t.code_anbar!=301 AND chkwebservice=1 AND situation_type=1 AND l_s.activate=1 AND warehouse_id IS NOT NULL AND register_error_code=0 AND (webservice_JahadTracking IS NULL OR webservice_JahadTracking=0)";
	$res = mysql_query($q);	
	while($row=$db->fetch_assoc($res))
    {  
	   if(strlen($row['code_ostan'])==1) $code_a=make_pattern($row['code_ostan'],2);
       else $code_a=$row['code_ostan'];
	   $shenaseAnbar=$code_a.$row['code_anbar'];
       $shomareGhabz='t'.$mtActiveYear.$row['shomare_barge_tadil'];
	   //تبدیل تاریخ شمسی به میلادی
       $sql_tarikh=$row['tarikh_barge_tadil'];
       $d=substr($sql_tarikh,8,2);$m=substr($sql_tarikh,5,2);$y=substr($sql_tarikh,0,4);
       $milady=jalali_to_gregorian($y,$m,$d);
       $sal=$milady[0];$mah=$milady[1];$rouz=$milady[2];
       $tarikh_tadil_MI=$sal.'-'.$mah.'-'.$rouz;
	   $goodId=$row['code_kala'];
	   $processSequence=117;
	   IF($row['code_vahedkala']==1)//کیلوگرم
	   {
		  $measurement_unit=1;
	      $amount=$row['meghdar_khales_tadil'];
	   }
       ELSE IF($row['code_vahedkala']==2)//تعداد
	   {
		  $measurement_unit=6;
		  $amount=$row['tedad_karton_tadil'];   
	   }
	   $wsdl_url='http://10.7.234.33/anbar/warehouse.asmx?wsdl';
	   header('Content-Type: text/html; charset=utf-8');
       try
	   {
	     $client=new SoapClient($wsdl_url);
		 $billStuff1=array(
		   'good_id'=>$goodId,
		   'measurement_unit'=>$measurement_unit,
           'amount'=>$amount,
           'production_type'=>$row['mahmule_type']
         );
         $WarehouseDocumentDetails=array($billStuff1);
		 $WarehouseDocument =array(
		  'warehouse_id'=>$row['warehouse_id'],
		  'gov_warehouse_number'=>$shenaseAnbar,
		  'number'=>$shomareGhabz,
          'issue_date'=>$tarikh_tadil_MI,
          'owner'=>'14002771736',
          'owner_birth_date'=>null,
	      'driver_national_id'=>null,
          'driver_birth_date'=>null,
		  'vehicle_number'=>null,
		  'bol_date'=>null,
		  'bol_serial'=>null,
		  'bol_series'=>null,	 
		  'bol_tid'=>null,	 
		  'Commodities'=>$WarehouseDocumentDetails	 
         );
         $params=array(
		  'username'=>'02',
          'password'=>'HJ78mnGD',
		  'co_national_id'=>'14002771736',
          'type'=>'out',
          'process_code'=>$processSequence,
          'doc'=>$WarehouseDocument
         );
		 //echo '<pre>'; print_r($params); echo '</pre>';

		  $result=$client->SendWarehouseDocument($params); 
		  $response=$result->SendWarehouseDocumentResult;
		  $webservice_error_code =$response->error_code;
	      $webservice_error_message =$response->error_message;
	      $webservice_status =$response->status;
	      $webservice_number =$response->number;
	      $webservice_JahadTracking =$response->JahadTracking;

	     echo 'webservice_JahadTracking: ';print_r($webservice_JahadTracking);echo'<br>';		 
	   }
       catch(SoapFault $client)
	   {
		 echo "<script>alert('وب سرویس فعال نمی باشد')</script>";
		 echo  $e->getMessage();
	   }
	   $update_track=("UPDATE tadil_mojody SET webservice_error_code='$webservice_error_code',webservice_error_message='$webservice_error_message',webservice_status='$webservice_status',webservice_number='$webservice_number',webservice_JahadTracking='$webservice_JahadTracking' WHERE code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']." AND shomare_barge_tadil='".$row['shomare_barge_tadil']."' AND year=$mtActiveYear");
	   $update_res=mysql_query($update_track);     
    }
    if($update_res)
    {
   	 mysql_query("COMMIT");
       echo "<script>alert('success')</script>"; 
       //echo "<script>window.location='$FileName'</script>";
   	}
   	else  
    {
       mysql_query('ROLLBACK');
       echo "<script>alert('error!')</script>";  
    }
    mysql_query('SET AUTOCOMMIT=1'); 	  
}
/********************WEB SERVICE NEW EBTAL***********************/
if(isset($transfer_ebtal))
{
    mysql_query('SET AUTOCOMMIT=0');//TRANSACTIONشروع 
    mysql_query('START TRANSACTION');
	$q="SELECT * From tadil_mojody t INNER JOIN list_sardkhane l_s ON t.code_ostan=l_s.code_ostan AND t.code_anbar=l_s.code_anbar INNER JOIN kala ON t.code_kala=kala.code_kala
	          WHERE year=$mtActiveYear AND t.status=1 AND t.deleted=0 AND t.code_anbar!=301 AND chkwebservice=1 AND situation_type=1 AND l_s.activate=1 AND warehouse_id IS NOT NULL AND register_error_code=0 AND webservice_JahadTracking>0 and (webservice_status='Insert' OR webservice_status='Update')";
	$res = mysql_query($q);	
	while($row=$db->fetch_assoc($res))
    {
	   $wsdl_url='http://10.7.234.33/anbar/warehouse.asmx?wsdl';
	   header('Content-Type: text/html; charset=utf-8');
       try
	   {
	     $client=new SoapClient($wsdl_url);
         $params=array(
		  'username'=>'02',
          'password'=>'HJ78mnGD',
		  'co_national_id'=>'14002771736',
          'JahadTracking'=>$row['webservice_JahadTracking']
         );
         $result=$client->RevokeWarehouseDocument($params);
	     $response=$result->RevokeWarehouseDocumentResult;
	     $webservice_error_code =$response->error_code;
	     $webservice_error_message =$response->error_message;
	     $webservice_status =$response->status;
	   }
	   catch(SoapFault $client)
	   {
		 echo "<script>alert('وب سرویس فعال نمی باشد')</script>";
		 echo  $e->getMessage();
	   }
	   $update_track=("UPDATE tadil_mojody SET webservice_error_code='$webservice_error_code',webservice_error_message='$webservice_error_message',webservice_status='$webservice_status' WHERE code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']." AND shomare_barge_tadil='".$row['shomare_barge_tadil']."' AND year=$mtActiveYear");
	   $update_res=mysql_query($update_track);
    }
    if($update_res)
    {
   	 mysql_query("COMMIT");
       echo "<script>alert('success')</script>"; 
   	}
   	else  
    {
       mysql_query('ROLLBACK');
       echo "<script>alert('error!')</script>";  
    }
    mysql_query('SET AUTOCOMMIT=1'); 	  
}
//////////////////////////////////////////////////////////////////////////////////////////////
// if((isset($transfer_ezafe))OR(isset($transfer_update_ezafe)))
// {
    // mysql_query('SET AUTOCOMMIT=0');//TRANSACTIONشروع 
    // mysql_query('START TRANSACTION');  
	// $q="SELECT * From tadil_mojody t INNER JOIN list_sardkhane l_s ON t.code_ostan=l_s.code_ostan AND t.code_anbar=l_s.code_anbar
	          // WHERE noe_tadil=1 AND year=$mtActiveYear AND chkwebservice=1 AND status=0 AND deleted=0 AND t.code_anbar!=301 AND (webservice_trackcode IS NULL OR webservice_trackcode=0 OR webservice_trackcode like '1%' OR webservice_trackcode like '9%')";
	// $res = mysql_query($q);	
	// while($row=$db->fetch_assoc($res))
    // {  
	   // $shenaseSazman="02";
	   // if(strlen($row['code_ostan'])==1) $code_a=make_pattern($row['code_ostan'],2);
       // else $code_a=$row['code_ostan'];
	   // $shenaseAnbar=$code_a.$row['code_anbar'];
       // $shomareGhabz='t'.$mtActiveYear.$row['shomare_barge_tadil'];
       // $noe_ziranbar=$db->get_from_where("noe_ziranbar","list_sardkhane_detail","code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']." AND code_ziranbar=".$row['code_ziranbar']."");     
	   // $noeZirAnbar=$ziranbarArr[$noe_ziranbar];
	   // $nameZirAnbar=$db->get_from_where("name_ziranbar","list_sardkhane_detail","code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']."");     
	   // $nameKala=$db->get_from_where("name_kala","kala","code_kala=".$row['code_kala']."");     
	   // $vahedKala=$db->get_from_where("sharh_vahedkala","kala INNER JOIN vahed_kala ON kala.code_vahedkala=vahed_kala.code_vahedkala","code_kala=".$row['code_kala']."");     
       // if($vahedKala=='کیلوگرم')$UnitMeasurement='Kilogram';
	   // else if($vahedKala=='عدد')$UnitMeasurement='adad';
	   // $bastebandyKala=$db->get_from_where("sharh_bastebandy","kala INNER JOIN bastebandy ON kala.code_bastebandy=bastebandy.code_bastebandy","code_kala=".$row['code_kala']."");     
       // if(strlen($row['mah_tolid_shamsi'])==1) $mah2raghami=make_pattern($row['mah_tolid_shamsi'],2);
       // else $mah2raghami=$row['mah_tolid_shamsi'];
       // if(strlen($row['rouz_tolid_shamsi'])==1) $rouz2raghami=make_pattern($row['rouz_tolid_shamsi'],2);
       // else $rouz2raghami=$row['rouz_tolid_shamsi'];	
	   // $ProductionDate=$row['sal_tolid_shamsi'].'/'.$mah2raghami.'/'.$rouz2raghami;
		    
	   // $IssuedTime=substr($logtime,0,5);
	   // $processSequence=115;
	   // $wsdl_url='http://10.7.234.33/warehouse/warehouse.asmx?wsdl';
	   // header('Content-Type: text/html; charset=utf-8');
       // try
	   // {
	     // $client=new SoapClient($wsdl_url);
         // $bill =array(
		 // 'id'=>'',
		 // 'OrganNo'=>$shenaseSazman,
		 // 'WareHouseNo'=>$shenaseAnbar,
         // 'BillNo'=>$shomareGhabz,
         // 'IssuedDate'=>$row['tarikh_barge_tadil'],
         // 'IssuedTime'=>$IssuedTime,
         // 'InsuranceNo'=>null,
         // 'OwnerTypeId'=>'LagalPerson',
	     // 'RealOwnerFirstName'=>null,
         // 'RealOwnerLastName'=>null,
         // 'RealOwnerNationalCode'=>null,
         // 'RealOwnerAddress'=>null,
         // 'RealOwnerZipCode'=>null,
         // 'RealOwnerMobile'=>null,
         // 'RealOwnerPhone'=>null,
         // 'LegalOwnerName'=>'شرکت پشتیبانی امور دام کشور',
         // 'LegalOwnerPhone'=>'82971',
         // 'LegalOwnerNationalCode'=>14002771736,
         // 'LegalOwnerAgentFirstName'=>'شرکت پشتیبانی امور دام کشور',
         // 'LegalOwnerAgentLastName'=>'شرکت پشتیبانی امور دام کشور',
         // 'LegalOwnerAgentNationalCode'=>14002771736,
         // 'LegalOwnerAgentMobile'=>'82971',
		 // 'VehicalPlaque'=>null,
		 // 'BillLadingNo'=>null,
		 // 'processSequence'=>$processSequence
         // );
		 // $billStuff1=array(
            // 'Id'=>'',
		    // 'WareHouseNo'=>$shenaseAnbar,
			// 'BillNo'=>$shomareGhabz,
            // 'StuffName'=>$nameKala,
            // 'StuffCode'=>$row['code_kala'],
            // 'StuffNameFromService'=>$nameKala,
            // 'StuffCodeFromService'=>$row['code_kala'],
            // 'UnitMeasurement'=>$UnitMeasurement,
            // 'Count'=>$row['meghdar_khales_tadil'],
            // 'ProductionDate'=>$ProductionDate,
            // 'ExpirationDate'=>null,
	        // 'PackingTypeName'=>$bastebandyKala,
            // 'PackingCount'=>$row['tedad_karton_tadil'],
            // 'SalonNo'=>$nameZirAnbar,
            // 'MaintenancePlaceName'=>$noeZirAnbar
             // );    
	       // $listBillStuff=array(
           // $billStuff1
           // );
           // $params=array(
            // 'OrganNo_'=>$shenaseSazman,
			// 'processSequence'=>$processSequence,
            // 'WareHouseNo_'=>$shenaseAnbar,
            // 'Bill_'=>$bill,
            // 'BillStuff_'=>$listBillStuff,
		    // 'Username'=>'warehouseuser',
            // 'Password'=>'AqWsXz@8246'
            // );
		 // if(isset($transfer_ezafe))
		 // {
		  // $result=$client->SendBill($params); 
		  // $response=$result->SendBillResult; 
		 // }	 
		 // else if(isset($transfer_update_ezafe))
		 // {
		  // $result=$client->UpdateBill($params); 
		  // $response=$result->UpdateBillResult;
		 // }
	   // }
	   // catch(SoapFault $client)
	   // {
	     // $response=0;
		 // echo "<script>alert('وب سرویس فعال نمی باشد')</script>";
	   // }
	   // $update_track=("UPDATE tadil_mojody SET webservice_trackcode='$response' WHERE code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']." AND shomare_barge_tadil='".$row['shomare_barge_tadil']."' AND year=$mtActiveYear");
	   // $update_res=mysql_query($update_track);
     
    // }
    // if($update_res)
    // {
   	 // mysql_query("COMMIT");
       // echo "<script>alert('success')</script>"; 
       // //echo "<script>window.location='tadil_mojody.php'</script>";
   	// }
   	// else  
    // {
       // mysql_query('ROLLBACK');
       // echo "<script>alert('error!')</script>";  
    // }
    // mysql_query('SET AUTOCOMMIT=1'); 	  
// }
//////////////////////////////////////////////////////////////////////////////////////////////
// if((isset($transfer_kasry))OR(isset($transfer_update_kasry)))
// {
    // mysql_query('SET AUTOCOMMIT=0');//TRANSACTIONشروع 
    // mysql_query('START TRANSACTION');  
	// $q="SELECT * From tadil_mojody t INNER JOIN list_sardkhane l_s ON t.code_ostan=l_s.code_ostan AND t.code_anbar=l_s.code_anbar
		// WHERE noe_tadil=2 AND year=$mtActiveYear AND chkwebservice=1 AND status=0 AND deleted=0 AND t.code_anbar!=301 AND (webservice_trackcode IS NULL OR webservice_trackcode=0 OR webservice_trackcode like '1%' OR webservice_trackcode like '9%')";

	// $res = mysql_query($q);	
	// while($row=$db->fetch_assoc($res))
    // {  
	   // $shenaseSazman="02";
	   // if(strlen($row['code_ostan'])==1) $code_a=make_pattern($row['code_ostan'],2);
       // else $code_a=$row['code_ostan'];
	   // $shenaseAnbar=$code_a.$row['code_anbar'];
       // $shomareBijak='t'.$mtActiveYear.$row['shomare_barge_tadil'];
       // $noe_ziranbar=$db->get_from_where("noe_ziranbar","list_sardkhane_detail","code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']." AND code_ziranbar=".$row['code_ziranbar']."");     
	   // $noeZirAnbar=$ziranbarArr[$noe_ziranbar];
	   // $nameZirAnbar=$db->get_from_where("name_ziranbar","list_sardkhane_detail","code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']."");     
	   // $nameKala=$db->get_from_where("name_kala","kala","code_kala=".$row['code_kala']."");     
	   // $vahedKala=$db->get_from_where("sharh_vahedkala","kala INNER JOIN vahed_kala ON kala.code_vahedkala=vahed_kala.code_vahedkala","code_kala=".$row['code_kala']."");     
       // if($vahedKala=='کیلوگرم')$UnitMeasurement='Kilogram';
	   // else if($vahedKala=='عدد')$UnitMeasurement='adad';
	   // $bastebandyKala=$db->get_from_where("sharh_bastebandy","kala INNER JOIN bastebandy ON kala.code_bastebandy=bastebandy.code_bastebandy","code_kala=".$row['code_kala']."");     
       // if(strlen($row['mah_tolid_shamsi'])==1) $mah2raghami=make_pattern($row['mah_tolid_shamsi'],2);
       // else $mah2raghami=$row['mah_tolid_shamsi'];
       // if(strlen($row['rouz_tolid_shamsi'])==1) $rouz2raghami=make_pattern($row['rouz_tolid_shamsi'],2);
       // else $rouz2raghami=$row['rouz_tolid_shamsi'];	
	   // $ProductionDate=$row['sal_tolid_shamsi'].'/'.$mah2raghami.'/'.$rouz2raghami;
		    
	   // $IssuedTime=substr($logtime,0,5);
	   // $processSequence=117;
	   // $wsdl_url='http://10.7.234.33/warehouse/warehouse.asmx?wsdl';
	   // header('Content-Type: text/html; charset=utf-8');
       // try
	   // {
	     // $client=new SoapClient($wsdl_url);
	     // $bijak =array(
         // 'id'=>'',
	     // 'OrganNo'=>$shenaseSazman,
	     // 'WareHouseNo'=>$shenaseAnbar,
	     // 'BijakNo'=>$shomareBijak,
         // 'DraftNo'=>$shomareMojavez,
         // 'IssuedDate'=>$row['tarikh_barge_tadil'],
         // 'Issuedtime'=>$IssuedTime,
         // 'VehicalPlaque'=>null,
         // 'NetWeight'=>$row['meghdar_khales_tadil'],
		 // 'GrossWeight'=>$row['meghdar_nakhales_tadil'],
	     // 'processSequence'=>$processSequence
	     // // 'GrossWeight'=>'',
	     // // 'revokeDate'=>'',
	     // // 'revokeTime '=>'',
	     // // 'status'=>'',
	     // // 'codeyear'=>'',
	     // // 'CodePeigiri'=>'',
	     // // 'CodePeigiri1'=>'',
	     // // 'CheckListNumber'=>'',
	     // // 'CoutageNo'=>'',
	     // // 'CoutageDate'=>'',
	     // // 'CustomCode'=>''
         // );
         // $bijakStuff1=array(
          // 'id'=>'',
	      // 'WareHouseNo'=>$shenaseAnbar,
		  // 'BijakNo'=>$shomareBijak,
          // 'StuffName'=>$nameKala,
          // 'StuffCode'=>$row['code_kala'],
          // 'StuffNameFromService'=>$nameKala,
          // 'StuffCodeFromService'=>$row['code_kala'],
          // //'LoadingCount'=>$row_havale_d['vazn_khales_h_d'],
          // 'loadingCount'=>$row['tedad_karton_tadil'],
          // 'PackingTypeName'=>$bastebandyKala,
          // //'PackingCount'=>$row_havale_d['tedad_karton_h_d'],
          // 'UnitCount'=>null,
		  // 'TotalPrice'=>null,
          // 'LoadingNetWeight'=>$row['meghdar_khales_tadil'],
          // 'LoadingGrossWeight'=>$row['meghdar_nakhales_tadil'],
          // 'BillNo'=>null
         // );
         // $listBijakStuff=array($bijakStuff1);
		 // $params=array(
         // 'OrganNo_'=>$shenaseSazman,
		 // 'processSequence'=>$processSequence,
         // 'WareHouseNo_'=>$shenaseAnbar,
         // 'Bijak_'=>$bijak,
         // 'BijakStuff_'=>$listBijakStuff,
		 // 'Username'=>'warehouseuser',
         // 'Password'=>'AqWsXz@8246'
         // );
        // if(isset($transfer_kasry))
        // {
		 // $result=$client->SendBijak($params);
		 // $response=$result->SendBijakResult;
		// }
		// else if(isset($transfer_update_kasry))
		// {
		 // $result=$client->UpdateBijak($params);
	     // $response=$result->UpdateBijakResult;
		// }
	   // }
	   // catch(SoapFault $client)
	   // {
	     // $response=0;
		 // echo "<script>alert('وب سرویس فعال نمی باشد')</script>";
	   // }
	   // //echo '<pre>'; print_r($params); echo '</pre>'; 
	   // $update_track=("UPDATE tadil_mojody SET webservice_trackcode='$response' WHERE code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']." AND shomare_barge_tadil='".$row['shomare_barge_tadil']."' AND year=$mtActiveYear");
	   // $update_res=mysql_query($update_track);
     
    // }
    // if($update_res)
    // {
   	 // mysql_query("COMMIT");
       // echo "<script>alert('success')</script>"; 
       // //echo "<script>window.location='tadil_mojody.php'</script>";
   	// }
   	// else  
    // {
       // mysql_query('ROLLBACK');
       // echo "<script>alert('error!')</script>";  
    // }
    // mysql_query('SET AUTOCOMMIT=1'); 	  
// }
// //////////////////////////////////////////////////////////////////////////////////////////////
// if(isset($transfer_ebtal_ezafe))
// {
    // mysql_query('SET AUTOCOMMIT=0');//TRANSACTIONشروع 
    // mysql_query('START TRANSACTION');  
	// $q="SELECT * From tadil_mojody t INNER JOIN list_sardkhane l_s ON t.code_ostan=l_s.code_ostan AND t.code_anbar=l_s.code_anbar
	          // WHERE noe_tadil=1 AND year=$mtActiveYear AND chkwebservice=1 AND status=1 AND deleted=0 AND t.code_anbar!=301 AND (webservice_trackcode IS NOT NULL)";
    // $res = mysql_query($q);	
	// while($row=$db->fetch_assoc($res))
    // {  
	   // $shenaseSazman="02";
	   // if(strlen($row['code_ostan'])==1) $code_a=make_pattern($row['code_ostan'],2);
       // else $code_a=$row['code_ostan'];
	   // $shenaseAnbar=$code_a.$row['code_anbar'];
       // $shomareGhabz='t'.$mtActiveYear.$row['shomare_barge_tadil'];
   
	   // $wsdl_url='http://10.7.234.33/warehouse/warehouse.asmx?wsdl';
	   // header('Content-Type: text/html; charset=utf-8');
       // try
	   // {
  	     // $client=new SoapClient($wsdl_url);
	     // $revokeDate=date("Y-m-d");
	     // //$revokeDate=$yy.'-'.$mm.'-'.$dd;
		 // $params=array(
          // 'OrganNo_'=>$shenaseSazman,
          // 'WareHouseNo'=>$shenaseAnbar,
          // 'BillNo'=>$shomareGhabz,
          // 'RevokeDate'=>$revokeDate,
          // 'RevokeTime'=>$revokeTime,
	      // 'Username'=>'warehouseuser',
          // 'Password'=>'AqWsXz@8246'
          // );
          // $result=$client->RevokBill($params);
	      // $response=$result->RevokBillResult;
	   // }
	   // catch(SoapFault $client)
	   // {
	     // $response=0;
		 // echo "<script>alert('وب سرویس فعال نمی باشد')</script>";
	   // }
	   // $update_track=("UPDATE tadil_mojody SET webservice_sendebtal='$response' WHERE code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']." AND shomare_barge_tadil='".$row['shomare_barge_tadil']."' AND year=$mtActiveYear");
	   // $update_res=mysql_query($update_track);
     
    // }
    // if($update_res)
    // {
   	 // mysql_query("COMMIT");
       // echo "<script>alert('success')</script>"; 
       // //echo "<script>window.location='tadil_mojody.php'</script>";
   	// }
   	// else  
    // {
       // mysql_query('ROLLBACK');
       // echo "<script>alert('error!')</script>";  
    // }
    // mysql_query('SET AUTOCOMMIT=1'); 	  
// }
// //////////////////////////////////////////////////////////////////////////////////////////////
// if(isset($transfer_ebtal_kasry))
// {
    // mysql_query('SET AUTOCOMMIT=0');//TRANSACTIONشروع 
    // mysql_query('START TRANSACTION');  
	// $q="SELECT * From tadil_mojody t INNER JOIN list_sardkhane l_s ON t.code_ostan=l_s.code_ostan AND t.code_anbar=l_s.code_anbar
	          // WHERE noe_tadil=2 AND year=$mtActiveYear AND chkwebservice=1 AND status=1 AND deleted=0 AND t.code_anbar!=301 AND (webservice_trackcode IS NOT NULL)";
    // $res = mysql_query($q);	
	// while($row=$db->fetch_assoc($res))
    // {  
	   // $shenaseSazman="02";
	   // if(strlen($row['code_ostan'])==1) $code_a=make_pattern($row['code_ostan'],2);
       // else $code_a=$row['code_ostan'];
	   // $shenaseAnbar=$code_a.$row['code_anbar'];
       // $shomareBijak='t'.$mtActiveYear.$row['shomare_barge_tadil'];
   
	   // $wsdl_url='http://10.7.234.33/warehouse/warehouse.asmx?wsdl';
	   // header('Content-Type: text/html; charset=utf-8');
       // try
	   // {
  	     // $client=new SoapClient($wsdl_url);
	     // $revokeDate=date("Y-m-d");
	     // //$revokeDate=$yy.'-'.$mm.'-'.$dd;
		  // $params=array(
          // 'OrganNo_'=>$shenaseSazman,
          // 'WareHouseNo'=>$shenaseAnbar,
          // 'BijakNo'=>$shomareBijak,
          // 'RevokeDate'=>$revokeDate,
          // 'RevokeTime'=>$revokeTime,
	      // 'Username'=>'warehouseuser',
          // 'Password'=>'AqWsXz@8246'
          // );
         // $result=$client->RevokBijak($params);
	     // $response=$result->RevokBijakResult;
	   // }
	   // catch(SoapFault $client)
	   // {
	     // $response=0;
		 // echo "<script>alert('وب سرویس فعال نمی باشد')</script>";
	   // }
	   // $update_track=("UPDATE tadil_mojody SET webservice_sendebtal='$response' WHERE code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']." AND shomare_barge_tadil='".$row['shomare_barge_tadil']."' AND year=$mtActiveYear");
	   // $update_res=mysql_query($update_track);
     
    // }
    // if($update_res)
    // {
   	 // mysql_query("COMMIT");
       // echo "<script>alert('success')</script>"; 
       // //echo "<script>window.location='tadil_mojody.php'</script>";
   	// }
   	// else  
    // {
       // mysql_query('ROLLBACK');
       // echo "<script>alert('error!')</script>";  
    // }
    // mysql_query('SET AUTOCOMMIT=1'); 	  
// }
echo'
</form>
</body>
</html>';	
?>