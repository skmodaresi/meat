<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
//error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="transfer_resid_webservice.php";
echo'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" />
<html xmlns="http://www.w3.org/1999/xhtml" dir=rtl>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>انتقال رسیدهای ارسال نشده به وب سرویس</title>
<link href="styles.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="functions.js"></script>
<link type="text/css" href="styles/jquery-ui-1.8.14.css" rel="stylesheet" />
<script type="text/javascript" src="scripts/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="scripts/jquery.ui.datepicker-cc.all.min.js"></script>
<script type="text/javascript">
$(function(){	    
    $("#datepickerfrom").datepicker({
		showOn: "button",
        buttonImage: "styles/images/calendar5.png",
        buttonImageOnly: true,
		showButtonPanel: true,
		changeMonth: true,
	    changeYear: true,
	  onSelect: function(dateText, inst){
	  $("#datepickerto").datepicker("option", "minDate", new JalaliDate(inst["selectedYear"], inst["selectedMonth"], inst["selectedDay"]));
	   }
	  });
	  $("#datepickerto").datepicker(
	  { 
		showOn: "button",
        buttonImage: "styles/images/calendar5.png",
        buttonImageOnly: true,
		showButtonPanel: true,
		changeMonth: true,
	    changeYear: true
		}
	  );
 });
</script> 
</head>';
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.sal_mabda.focus();">
<form method="POST" name="myform">
<div align="center">
<table width="100%" height="100%" align="center" cellpadding="0" cellspacing="0">
 <tr>
  <td height="100%">
   <div style="float:right;width:100%;margin:0px;height:100%;overflow:auto;overflow-x:hidden;">
   <table width="600px" border="0" align="center" cellpadding="0" cellspacing="0" >
    <tr><td colspan="4" height="20px">&nbsp;</td></tr>
	<tr><td colspan="4" class="title">انتقال رسیدهای ارسال نشده به وب سرویس</td></tr>
    <tr><td colspan="4" class="tr1">از تاریخ : <input id="datepickerfrom" type="text" name="date1"/></td></tr>
    <tr><td colspan="4" class="tr1">تا تاریخ : <input id="datepickerto" type="text" name="date2"/></td></tr>
	<tr class="tr1"><td colspan="4" height="60px"><input class="buttonme" type="submit" name="transfer" value="transfer resid"></td></tr> 
    <!--<tr class="tr1"><td colspan="4" height="60px"><input class="buttonme" type="submit" name="transfer_update" value="transfer update resid"></td></tr>-->
    <tr class="footer"><td colspan="4">&nbsp;</td></tr>
   </table>
   </div>
  </td>
 </tr>	
</table>
</div>';
/********************WEB SERVICE NEW***********************/
if((isset($transfer))OR(isset($transfer_update)))
{
    mysql_query('SET AUTOCOMMIT=0');//TRANSACTIONشروع 
    mysql_query('START TRANSACTION');

	$q_resid35435="SELECT * From resid r INNER JOIN list_sardkhane l_s ON r.code_ostan=l_s.code_ostan AND r.code_anbar=l_s.code_anbar
	          WHERE r.code_ostan=4 and r.code_anbar=101 and r.shomare_resid='00002' and r.tarikh_resid BETWEEN '$date1' AND '$date2' and year=$mtActiveYear AND sabt_nahayi=1 AND r.status=0 AND r.deleted=0 AND r.code_anbar!=301 AND chkwebservice=1 AND situation_type=1 AND l_s.activate=1 AND warehouse_id IS NOT NULL AND register_error_code=0 AND (webservice_JahadTracking IS NULL OR webservice_JahadTracking=0)";
	$q_resid="SELECT * From resid r INNER JOIN list_sardkhane l_s ON r.code_ostan=l_s.code_ostan AND r.code_anbar=l_s.code_anbar
	          WHERE r.tarikh_resid BETWEEN '$date1' AND '$date2' and year=$mtActiveYear AND sabt_nahayi=1 AND r.status=0 AND r.deleted=0 AND r.code_anbar!=301 AND chkwebservice=1 AND situation_type=1 AND l_s.activate=1 AND warehouse_id IS NOT NULL AND register_error_code=0 AND (webservice_JahadTracking IS NULL OR webservice_JahadTracking=0)";

	$res_resid = mysql_query($q_resid);	
	while($row_resid=$db->fetch_assoc($res_resid))
    {
	   if(strlen($row_resid['code_ostan'])==1) $code_a=make_pattern($row_resid['code_ostan'],2);
       else $code_a=$row_resid['code_ostan'];
	   $shenaseAnbar=$code_a.$row_resid['code_anbar'];
       //$shomareGhabz='0'.$bzActiveYear.$row_resid['shomare_resid'];
       $shomareGhabz=$mtActiveYear.$row_resid['shomare_resid'];
       //تبدیل تاریخ شمسی به میلادی
       $sql_tarikh=$row_resid['tarikh_resid'];
       $d=substr($sql_tarikh,8,2);$m=substr($sql_tarikh,5,2);$y=substr($sql_tarikh,0,4);
       $milady=jalali_to_gregorian($y,$m,$d);
       $sal=$milady[0];$mah=$milady[1];$rouz=$milady[2];
       $tarikh_resid_MI=$sal.'-'.$mah.'-'.$rouz;
	   if($row_resid['barname_no']=='')$BillLadingNo=null;
	   else $BillLadingNo=$row_resid['barname_no'];
	   if($row_resid['plak4']=='')$plak4=null;
	   else $plak4=$row_resid['plak4'];
	   if($row_resid['plak3']=='')$plak3=null;
	   else $plak3=$row_resid['plak3'];
	   if($row_resid['plak2']=='')$plak2=null;
	   else $plak2=$row_resid['plak2'];
	   if($row_resid['plak1']=='')$plak1=null;
	   else $plak1=$row_resid['plak1'];
	   $plak=$plak1.$plak2.$plak3.$plak4;

	   //جابه جایی
	   if(($row_resid['noe_tahvil_bar']==4)OR($row_resid['noe_tahvil_bar']==5))$processSequence=80;
       //جابه جایی نباشد و کالا داخلی
	   //else if((($row_resid['noe_tahvil_bar']!=4)and($row_resid['noe_tahvil_bar']!=5))and(($row_resid['code_kala']==17)or($row_resid['code_kala']==21)or($row_resid['code_kala']==20)))$processSequence=71;
	   //else $processSequence=107;
	   //else $processSequence=0;
	   else $processSequence=71;
	   $wsdl_url='http://10.7.234.33/anbar/warehouse.asmx?wsdl';
	   header('Content-Type: text/html; charset=utf-8');
       try
	   {
	     $client=new SoapClient($wsdl_url);
         $WarehouseDocumentDetails=array();
	     $q_resid_k_d="SELECT * From resid_kala_detail r_k_d INNER JOIN kala ON kala.code_kala=r_k_d.code_kala  WHERE r_k_d.code_ostan=".$row_resid['code_ostan']." AND r_k_d.code_anbar=".$row_resid['code_anbar']." AND r_k_d.year=$mtActiveYear AND r_k_d.shomare_resid='".$row_resid['shomare_resid']."'";
	     $res_Resid_k_d = mysql_query($q_resid_k_d);
	     while($row_resid_k_d=mysql_fetch_assoc($res_Resid_k_d))//جزئیات کالا
	     {
		   // if(($row_resid_k_d['good_id']==null)OR($row_resid_k_d['good_id']=='')OR($row_resid_k_d['good_id']=='0')) $goodId=$row_resid_k_d['code_kala'];
	       // else $goodId=$row_resid_k_d['good_id'];
		   $goodId=$row_resid_k_d['code_kala'];
		   IF($row_resid_k_d['code_vahedkala']==1)//کیلوگرم
	       {
		      $measurement_unit=1;
	          $amount=$row_resid_k_d['vazn_khales_r_d_sub'];
	       }
           ELSE IF($row_resid_k_d['code_vahedkala']==2)//تعداد
	       {
		      $measurement_unit=6;
		      $amount=$row_resid_k_d['tedad_karton_r_d_sub'];   
	       } 
		   $billStuff1=array(
		   'good_id'=>$goodId,
		   'measurement_unit'=>$measurement_unit,
           'amount'=>$amount,
           'production_type'=>$row_resid_k_d['mahmule_type']
           );
           array_push($WarehouseDocumentDetails,$billStuff1);
		 }

		 $WarehouseDocument =array(
		 'warehouse_id'=>$row_resid['warehouse_id'],
		 'gov_warehouse_number'=>$shenaseAnbar,
		 'number'=>$shomareGhabz,
         'issue_date'=>$tarikh_resid_MI,
         'owner'=>'14002771736',
         'owner_birth_date'=>null,
	     'driver_national_id'=>$row_resid['ranande_melicode'],
         'driver_birth_date'=>null,
		 'vehicle_number'=>$plak,
		 'bol_date'=>$row_resid['barname_tarikh'],
		 'bol_serial'=>$BillLadingNo,
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

		 if(isset($transfer))
		 {
		  $result=$client->SendWarehouseDocument($params); 
		  $response=$result->SendWarehouseDocumentResult;
		  $webservice_error_code =$response->error_code;
	      $webservice_error_message =$response->error_message;
	      $webservice_status =$response->status;
	      $webservice_number =$response->number;
	      $webservice_JahadTracking =$response->JahadTracking;
		 }	 
		 // else if(isset($transfer_update))
		 // {
		  // $result=$client->UpdateBill($params); 
		  // $response=$result->UpdateBillResult;
		 // }
	     // echo 'webservice_error_code: ';print_r($webservice_error_code);echo'<br>';
	     // echo 'webservice_error_message: ';print_r($webservice_error_message);echo'<br>';
	     // echo 'webservice_status: ';print_r($webservice_status);echo'<br>';
	     // echo 'webservice_number: ';print_r($webservice_number);echo'<br>';
	     echo 'webservice_JahadTracking: ';print_r($webservice_JahadTracking);echo'<br>';
	   }
	   catch(SoapFault $client)
	   {
		 echo "<script>alert('وب سرویس فعال نمی باشد')</script>";
		 echo  $e->getMessage();
	   }
	   $update_track=("UPDATE resid SET webservice_error_code='$webservice_error_code',webservice_error_message='$webservice_error_message',webservice_status='$webservice_status',webservice_number='$webservice_number',webservice_JahadTracking='$webservice_JahadTracking' WHERE code_ostan=".$row_resid['code_ostan']." AND code_anbar=".$row_resid['code_anbar']." AND shomare_resid='".$row_resid['shomare_resid']."' AND year=$mtActiveYear");
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
// if((isset($transfer))OR(isset($transfer_update)))
// {
    // mysql_query('SET AUTOCOMMIT=0');//TRANSACTIONشروع 
    // mysql_query('START TRANSACTION');  

	// $q_resid="SELECT * From resid r INNER JOIN list_sardkhane l_s ON r.code_ostan=l_s.code_ostan AND r.code_anbar=l_s.code_anbar
	          // WHERE year=$mtActiveYear AND chkwebservice=1 AND sabt_nahayi=1 AND status=0 AND r.code_anbar!=301 AND (webservice_trackcode IS NULL OR webservice_trackcode=0 OR webservice_trackcode like '1%' OR webservice_trackcode like '9%')";
	// $res_resid = mysql_query($q_resid);	
	// while($row_resid=$db->fetch_assoc($res_resid))
    // {  
	   // $shenaseSazman="02";
	   // if(strlen($row_resid['code_ostan'])==1) $code_a=make_pattern($row_resid['code_ostan'],2);
       // else $code_a=$row_resid['code_ostan'];
	   // $shenaseAnbar=$code_a.$row_resid['code_anbar'];
       // $shomareGhabz='0'.$mtActiveYear.$row_resid['shomare_resid'];

	   // $IssuedTime=substr($row_resid['IssuedTime'],0,5);	   
	   // if($row_resid['barname_no']=='')$BillLadingNo=null;
	   // else $BillLadingNo=$row_resid['barname_no']; 
	   // if($row_resid['plak4']=='')$plak4=null;
	   // else $plak4=$row_resid['plak4'];
	   // if($row_resid['plak3']=='')$plak3=null;
	   // else $plak3=$row_resid['plak3'];
	   // if($row_resid['plak2']=='')$plak2=null;
	   // else $plak2=$row_resid['plak2'];
	   // if($row_resid['plak1']=='')$Plak1=null;
	   // else $plak1=$row_resid['plak1'];
	   // $plak=$plak1.$plak2.$plak3.$plak4;
	   // //جابه جایی
	   // if(($row_resid['noe_tahvil_bar']==4)OR($row_resid['noe_tahvil_bar']==5))$processSequence=80;
	   // else $processSequence=107;
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
         // 'IssuedDate'=>$row_resid['tarikh_resid'],
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
		 // 'VehicalPlaque'=>$plak,
		 // 'BillLadingNo'=>$BillLadingNo,
		 // 'processSequence'=>$processSequence
         // );
	     // $listBillStuff=array();
	     // $q_resid_k_d="SELECT * From resid_kala_detail r_k_d  WHERE code_ostan=".$row_resid['code_ostan']." AND code_anbar=".$row_resid['code_anbar']." AND year=$mtActiveYear AND shomare_resid='".$row_resid['shomare_resid']."'";
	     // $res_Resid_k_d = mysql_query($q_resid_k_d);
	     // while($row_resid_k_d=mysql_fetch_assoc($res_Resid_k_d))//جزئیات کالا
	     // {
	        // $nameKala=$db->get_from_where("name_kala","kala","code_kala=".$row_resid_k_d['code_kala']."");     
	        // //$vahedKala=$db->get_from_where("sharh_vahedkala","kala INNER JOIN vahed_kala ON kala.code_vahedkala=vahed_kala.code_vahedkala","code_kala=".$row_resid_k_d['code_kala']."");     
            // //if($vahedKala=='کیلوگرم')$UnitMeasurement='Kilogram';
	        // $bastebandyKala=$db->get_from_where("sharh_bastebandy","kala INNER JOIN bastebandy ON kala.code_bastebandy=bastebandy.code_bastebandy","code_kala=".$row_resid_k_d['code_kala']."");     
	        // $noe_zir_Anbar=$db->get_from_where("noe_ziranbar","list_sardkhane_detail","code_ostan=".$row_resid['code_ostan']." AND code_anbar=".$row_resid['code_anbar']." AND code_ziranbar=".$row_resid_k_d['code_ziranbar']."");     
		    // $noeZirAnbar=$ziranbarArr[$noe_zir_Anbar];
		    // $nameZirAnbar=$db->get_from_where("name_ziranbar","list_sardkhane_detail","code_ostan=".$row_resid['code_ostan']." AND code_anbar=".$row_resid['code_anbar']." AND code_ziranbar=".$row_resid_k_d['code_ziranbar']."");     

            // if(strlen($row_resid_k_d['mah_tolid_shamsi'])==1) $mah2raghami=make_pattern($row_resid_k_d['mah_tolid_shamsi'],2);
            // else $mah2raghami=$row_resid_k_d['mah_tolid_shamsi'];
            // if(strlen($row_resid_k_d['rouz_tolid_shamsi'])==1) $rouz2raghami=make_pattern($row_resid_k_d['rouz_tolid_shamsi'],2);
            // else $rouz2raghami=$row_resid_k_d['rouz_tolid_shamsi'];
			
			// $ProductionDate=$row_resid_k_d['sal_tolid_shamsi'].'/'.$mah2raghami.'/'.$rouz2raghami;
		    
			// $billStuff1=array(
            // 'Id'=>'',
		    // 'WareHouseNo'=>$shenaseAnbar,
			// 'BillNo'=>$shomareGhabz,
            // 'StuffName'=>$nameKala,
            // 'StuffCode'=>$row_resid_k_d['code_kala'],
            // 'StuffNameFromService'=>$nameKala,
            // 'StuffCodeFromService'=>$row_resid_k_d['code_kala'],
            // 'UnitMeasurement'=>$UnitMeasurement,
            // 'Count'=>$row_resid_k_d['vazn_khales_r_d_sub'],
            // 'ProductionDate'=>$ProductionDate,
            // 'ExpirationDate'=>null,
	        // 'PackingTypeName'=>$bastebandyKala,
            // 'PackingCount'=>$row_resid_k_d['tedad_karton_r_d_sub'],
            // 'SalonNo'=>$nameZirAnbar,
            // 'MaintenancePlaceName'=>$noeZirAnbar
             // );    
	     	// array_push($listBillStuff,$billStuff1);  
	       // }

           // $params=array(
            // 'OrganNo_'=>$shenaseSazman,
			// 'processSequence'=>$processSequence,
            // 'WareHouseNo_'=>$shenaseAnbar,
            // 'Bill_'=>$bill,
            // 'BillStuff_'=>$listBillStuff,
		    // 'Username'=>'warehouseuser',
            // 'Password'=>'AqWsXz@8246'
            // );
		 // if(isset($transfer))
		 // {
		  // $result=$client->SendBill($params); 
		  // $response=$result->SendBillResult; 
		 // }	 
		 // else if(isset($transfer_update))
		 // {
		  // $result=$client->UpdateBill($params); 
		  // $response=$result->UpdateBillResult;
		 // }
		    // //echo "<script>alert('کد پیگیری وب سرویس\\n$response')</script>";  
	   // }
	   // catch(SoapFault $client)
	   // {
	     // $response=0;
		 // echo "<script>alert('وب سرویس فعال نمی باشد')</script>";
	   // }
	   // $update_track=("UPDATE resid SET webservice_trackcode='$response' WHERE code_ostan=".$row_resid['code_ostan']." AND code_anbar=".$row_resid['code_anbar']." AND shomare_resid='".$row_resid['shomare_resid']."' AND year=$mtActiveYear");
	   // $update_res=mysql_query($update_track);
     
    // }
    // if($update_res)
    // {
   	 // mysql_query("COMMIT");
       // echo "<script>alert('success')</script>"; 
       // //echo "<script>window.location='resid.php'</script>";
   	// }
   	// else  
    // {
       // mysql_query('ROLLBACK');
       // echo "<script>alert('error!')</script>";  
    // }
    // mysql_query('SET AUTOCOMMIT=1'); 	  
// }
////////////////////////////////////////////////////////////////////////////////////////////////
echo'
</form>
</body>
</html>';	
?>