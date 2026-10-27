<?php
session_start();
//error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="transfer_havale_webservice.php";
echo'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" />
<html xmlns="http://www.w3.org/1999/xhtml" dir=rtl>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>انتقال حواله های ارسال نشده به وب سرویس</title>
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
	<tr><td colspan="4" class="title">انتقال حواله های ارسال نشده به وب سرویس</td></tr>
    <tr><td colspan="4" class="tr1">از تاریخ : <input id="datepickerfrom" type="text" name="date1"/></td></tr>
    <tr><td colspan="4" class="tr1">تا تاریخ : <input id="datepickerto" type="text" name="date2"/></td></tr>
	<tr class="tr1"><td colspan="4" height="60px"><input class="buttonme" type="submit" name="transfer" value="transfer havale"></td></tr> 
    <!--<tr class="tr1"><td colspan="4" height="60px"><input class="buttonme" type="submit" name="transfer_update" value="transfer update havale"></td></tr>-->
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

	$q_havale414="SELECT * From havale h INNER JOIN list_sardkhane l_s ON h.code_ostan=l_s.code_ostan AND h.code_anbar=l_s.code_anbar INNER JOIN kala ON h.code_kala=kala.code_kala
	           WHERE h.code_ostan=1 and h.code_anbar=102 and h.shomare_havale_anbar='00001' and year=$mtActiveYear AND h.deleted=0 AND h.status=0 AND sabt_nahayi=1 AND h.code_anbar!=301 AND chkwebservice=1 AND situation_type=1 AND l_s.activate=1 AND warehouse_id IS NOT NULL AND register_error_code=0 AND (webservice_JahadTracking IS NULL OR webservice_JahadTracking=0)";
	
	$q_havale="SELECT * From havale h INNER JOIN list_sardkhane l_s ON h.code_ostan=l_s.code_ostan AND h.code_anbar=l_s.code_anbar INNER JOIN kala ON h.code_kala=kala.code_kala
	           WHERE h.tarikh_havale_anbar BETWEEN '$date1' AND '$date2' and year=$mtActiveYear AND h.deleted=0 AND h.status=0 AND sabt_nahayi=1 AND h.code_anbar!=301 AND chkwebservice=1 AND situation_type=1 AND l_s.activate=1 AND warehouse_id IS NOT NULL AND register_error_code=0 AND (webservice_JahadTracking IS NULL OR webservice_JahadTracking=0)";
	
	$res_havale = mysql_query($q_havale);
	while($row_havale=$db->fetch_assoc($res_havale))
    {
	   if(strlen($row_havale['code_ostan'])==1) $code_a=make_pattern($row_havale['code_ostan'],2);
       else $code_a=$row_havale['code_ostan'];
	   $shenaseAnbar=$code_a.$row_havale['code_anbar'];
	   //$shomareBijak='0'.$mtActiveYear.$row_havale['shomare_havale_anbar'];
	   $shomareBijak=$mtActiveYear.$row_havale['shomare_havale_anbar'];
	   //تبدیل تاریخ شمسی به میلادی
       $sql_tarikh=$row_havale['tarikh_havale_anbar'];
       $d=substr($sql_tarikh,8,2);$m=substr($sql_tarikh,5,2);$y=substr($sql_tarikh,0,4);
       $milady=jalali_to_gregorian($y,$m,$d);
       $sal=$milady[0];$mah=$milady[1];$rouz=$milady[2];
       $tarikh_havale_MI=$sal.'-'.$mah.'-'.$rouz;
	   if($row_havale['shomare_barname_h']=='')$BillLadingNo=null;
	   else $BillLadingNo=$shomare_barname_h;
	   if($row_havale['plak4']=='')$plak4=null;
	   else $plak4=$row_havale['plak4'];
	   if($row_havale['plak3']=='')$plak3=null;
	   else $plak3=$row_havale['plak3'];
	   if($row_havale['plak2']=='')$plak2=null;
	   else $plak2=$row_havale['plak2'];
	   if($row_havale['plak1']=='')$plak1=null;
	   else $plak1=$row_havale['plak1'];
	   $plak=$plak1.$plak2.$plak3.$plak4;
	   // if(($row_havale['good_id']==null)OR($row_havale['good_id']=='')OR($row_havale['good_id']=='0')) $goodId=$row_havale['code_kala'];
	   // else $goodId=$row_havale['good_id'];
 	   $goodId=$row_havale['code_kala'];
	   //جابه جایی
	   IF(($row_havale['noe_tahvil_bar']==4)OR($row_havale['noe_tahvil_bar']==5)OR($row_havale['noe_tahvil_bar']==7))$processSequence=79;
       ELSE $processSequence=76;
       IF($row_havale['code_vahedkala']==1)//کیلوگرم
	   {
		  $measurement_unit=1;
	      $amount=$row_havale['vazn_khales_h'];
	   }
       ELSE IF($row_havale['code_vahedkala']==2)//تعداد
	   {
		  $measurement_unit=6;
		  $amount=$row_havale['tedad_karton_h'];   
	   }   
	   $wsdl_url='http://10.7.234.33/anbar/warehouse.asmx?wsdl';
	   header('Content-Type: text/html; charset=utf-8');
       try
	   {
	    $client=new SoapClient($wsdl_url);
	    $bijakStuff1=array(
		 'good_id'=>$goodId,
		 'measurement_unit'=>$measurement_unit,
         'amount'=>$amount,
         'production_type'=>$row_havale['mahmule_type']
         );
        $WarehouseDocumentDetails=array($bijakStuff1);	
		$WarehouseDocument =array(
		 'warehouse_id'=>$row_havale['warehouse_id'],
		 'gov_warehouse_number'=>$shenaseAnbar,
		 'number'=>$shomareBijak,
         'issue_date'=>$tarikh_havale_MI,
         'owner'=>'14002771736',
         'owner_birth_date'=>null,
	     'driver_national_id'=>null,
         'driver_birth_date'=>null,
		 'vehicle_number'=>$plak,
		 'bol_date'=>$row_havale['tarikh_barname_h'],
		 'bol_serial'=>$BillLadingNo,
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
		 // $result=$client->UpdateBijak($params);
	     // $response=$result->UpdateBijakResult;
		//}
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
	   $update_track=("UPDATE havale SET webservice_error_code='$webservice_error_code',webservice_error_message='$webservice_error_message',webservice_status='$webservice_status',webservice_number='$webservice_number',webservice_JahadTracking='$webservice_JahadTracking' WHERE code_ostan=".$row_havale['code_ostan']." AND code_anbar=".$row_havale['code_anbar']." AND shomare_havale_anbar='".$row_havale['shomare_havale_anbar']."' AND year=$mtActiveYear");
	   $insert_res=mysql_query($update_track);
    }
    if($insert_res)
    {
   	   mysql_query("COMMIT");
       echo "<script>alert('success')</script>"; 
       //echo "<script>window.location='transfer_havale_webservice.php'</script>";
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
	// $q_havale="SELECT * From havale h INNER JOIN list_sardkhane l_s ON h.code_ostan=l_s.code_ostan AND h.code_anbar=l_s.code_anbar
	           // WHERE year=$mtActiveYear AND chkwebservice=1 AND sabt_nahayi=1 AND status=0 AND h.code_anbar!=301 AND (webservice_trackcode IS NULL  OR webservice_trackcode=0 OR webservice_trackcode like '1%' OR webservice_trackcode like '9%')";
	// $res_havale = mysql_query($q_havale);
	// while($row_havale=$db->fetch_assoc($res_havale))
    // {
       // $shenaseSazman="02";
	   // if(strlen($row_havale['code_ostan'])==1) $code_a=make_pattern($row_havale['code_ostan'],2);
       // else $code_a=$row_havale['code_ostan'];
	   // $shenaseAnbar=$code_a.$row_havale['code_anbar'];
	   // $shomareBijak='0'.$mtActiveYear.$row_havale['shomare_havale_anbar'];
	   // if(($row_havale['noe_tahvil_bar']==4)or($row_havale['noe_tahvil_bar']==5)or($row_havale['noe_tahvil_bar']==7)) $shomareMojavez=$row_havale['shomare_jabejae'];
       // else $shomareMojavez=$row_havale['h_code'];
	   // $IssuedTime=substr($row_havale['IssuedTime'],0,5);
	   // if($row_havale['plak4']=='')$plak4=null;
	   // else $plak4=$row_havale['plak4'];
	   // if($row_havale['plak3']=='')$plak3=null;
	   // else $plak3=$row_havale['plak3'];
	   // if($row_havale['plak2']=='')$plak2=null;
	   // else $plak2=$row_havale['plak2'];
	   // if($row_havale['plak1']=='')$Plak1=null;
	   // else $plak1=$row_havale['plak1'];
	   // $plak=$plak1.$plak2.$plak3.$plak4;
	   // //جابه جایی
	   // IF(($row_havale['noe_tahvil_bar']==4)OR($row_havale['noe_tahvil_bar']==5)OR($row_havale['noe_tahvil_bar']==7))$processSequence=79;
       // ELSE $processSequence=76;
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
         // 'IssuedDate'=>$row_havale['tarikh_havale_anbar'],
         // 'Issuedtime'=>$IssuedTime,
         // 'VehicalPlaque'=>$plak,
         // 'NetWeight'=>$row_havale['vazn_khales_h'],
	     // 'GrossWeight'=>$row_havale['vazn_nakhales_h'],
		 // 'processSequence'=>$processSequence
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
	     // $listBijakStuff=array();   
	     // $q_havale_d="SELECT * From havale_detail h_d  WHERE code_ostan=".$row_havale['code_ostan']." AND code_anbar=".$row_havale['code_anbar']." AND year=$mtActiveYear AND shomare_havale_anbar='".$row_havale['shomare_havale_anbar']."'";
	     // $res_havale_d = mysql_query($q_havale_d);
	     // while($row_havale_d=mysql_fetch_assoc($res_havale_d))//جزئیات کالا
	     // {
	      // $nameKala=$db->get_from_where("name_kala","kala","code_kala=".$row_havale_d['code_kala']."");     
	      // //$vahedKala=$db->get_from_where("sharh_vahedkala","kala INNER JOIN vahed_kala ON kala.code_vahedkala=vahed_kala.code_vahedkala","code_kala=".$row_havale_d['code_kala']."");     
          // //if($vahedKala=='کیلوگرم')$UnitMeasurement='Kilogram';
	      // $bastebandyKala=$db->get_from_where("sharh_bastebandy","kala INNER JOIN bastebandy ON kala.code_bastebandy=bastebandy.code_bastebandy","code_kala=".$row_havale_d['code_kala']."");     
	      // //$codeZirAnbar=$db->get_from_where("noe_ziranbar","list_sardkhane_detail","code_ostan=".$row_havale['code_ostan']." AND code_anbar=".$row_havale['code_anbar']." AND code_ziranbar=".$row_havale_d['code_ziranbar']."");     
		  // //$noeZirAnbar=$ziranbarArr[$codeZirAnbar];
		  // //$nameZirAnbar=$db->get_from_where("name_ziranbar","list_sardkhane_detail","code_ostan=".$row_havale['code_ostan']." AND code_anbar=".$row_havale['code_anbar']." AND code_ziranbar=".$row_havale_d['code_ziranbar']."");     
          // $bijakStuff1=array(
          // 'id'=>'',
	      // 'WareHouseNo'=>$shenaseAnbar,
		  // 'BijakNo'=>$shomareBijak,
          // 'StuffName'=>$nameKala,
          // 'StuffCode'=>$row_havale_d['code_kala'],
          // 'StuffNameFromService'=>$nameKala,
          // 'StuffCodeFromService'=>$row_havale_d['code_kala'],
          // //'LoadingCount'=>$row_havale_d['vazn_khales_h_d'],
          // 'loadingCount'=>$row_havale_d['tedad_karton_h_d'],
          // 'PackingTypeName'=>$bastebandyKala,
          // //'PackingCount'=>$row_havale_d['tedad_karton_h_d'],
          // 'UnitCount'=>null,
		  // 'TotalPrice'=>null,
          // 'LoadingNetWeight'=>$row_havale_d['vazn_khales_h_d'],
          // 'LoadingGrossWeight'=>$row_havale_d['vazn_nakhales_h_d'],
          // 'BillNo'=>null
          // );   
	      // array_push($listBijakStuff,$bijakStuff1);  
	     // }
	     // $params=array(
          // 'OrganNo_'=>$shenaseSazman,
		  // 'processSequence'=>$processSequence,
          // 'WareHouseNo_'=>$shenaseAnbar,
          // 'Bijak_'=>$bijak,
          // 'BijakStuff_'=>$listBijakStuff,
		  // 'Username'=>'warehouseuser',
          // 'Password'=>'AqWsXz@8246'
          // );
         // if(isset($transfer))
         // {
		  // $result=$client->SendBijak($params);
		  // $response=$result->SendBijakResult;
		 // }
		 // else if(isset($transfer_update))
		 // {
		  // $result=$client->UpdateBijak($params);
	     // $response=$result->UpdateBijakResult;
		 // }
		 // //echo "<script>alert('کد پیگیری وب سرویس\\n$response')</script>"; 
	   // }
	   // catch(SoapFault $client)
	   // {
	     // $response=0;
		 // echo "<script>alert('وب سرویس فعال نمی باشد')</script>";
	   // }
	   // $update_track=("UPDATE havale SET webservice_trackcode='$response' WHERE code_ostan=".$row_havale['code_ostan']." AND code_anbar=".$row_havale['code_anbar']." AND shomare_havale_anbar='".$row_havale['shomare_havale_anbar']."' AND year=$mtActiveYear");
	   // $insert_res=mysql_query($update_track);
    // }
    // if($insert_res)
    // {
   	 // mysql_query("COMMIT");
       // echo "<script>alert('success')</script>"; 
       // //echo "<script>window.location='havale.php'</script>";
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