<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="transfer_resid_new_ostan.php";
echo'
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>'.$titr.'</title>
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
	<tr><td colspan="4" class="title">انتقال رسیدهای ارسال نشده به وب سرویس (سرویس خوشه های کشاورزی) '.$mt_gl_name_ostan.' </td></tr>
    <tr><td colspan="4" class="tr1">از تاریخ : <input id="datepickerfrom" type="text" name="date1"/></td></tr>
    <tr><td colspan="4" class="tr1">تا تاریخ : <input id="datepickerto" type="text" name="date2"/></td></tr>
	<tr class="tr1"><td colspan="4" height="60px"><input class="buttonme" type="submit" name="transfer" value="انتقال رسیدهای ثبت نشده"></td></tr> 
    <tr class="footer"><td colspan="4">&nbsp;</td></tr>
   </table>
   </div>
  </td>
 </tr>	
</table>
</div>';
/********************WEB SERVICE NEW***********************/
if(isset($transfer))
{
    mysql_query('SET AUTOCOMMIT=0');//TRANSACTIONشروع 
    mysql_query('START TRANSACTION');
	$params=array();
    $containers=array();
    $seals=array();
    $packages=array();
    $reference_docs=array();
	$receipt_items=array();
	$q_resid="SELECT * From resid r INNER JOIN list_sardkhane l_s ON r.code_ostan=l_s.code_ostan AND r.code_anbar=l_s.code_anbar 
	          INNER JOIN peymankar_haml ON r.code_peymankar_haml=peymankar_haml.code_peymankar_haml
	          WHERE r.code_ostan='$mt_gl_code_ostan' AND r.tarikh_resid BETWEEN '$date1' AND '$date2' and year=$mtActiveYear AND sabt_nahayi=1 AND r.status=0 AND r.deleted=0 AND r.code_anbar!=301 AND chkwebservice=1 AND situation_type=1 AND l_s.activate=1 AND warehouse_id IS NOT NULL AND register_error_code=0 AND (wb_id IS NULL OR wb_id=0)";
    //echo $q_resid;
	$res_resid = mysql_query($q_resid);	
	while($row_resid=$db->fetch_assoc($res_resid))
    {
       $params=array();
       $containers=array();
       $seals=array();
       $packages=array();
       $reference_docs=array();
	   $receipt_items=array();
	   $warehouse_id=$db->get_from_where("warehouse_id","list_sardkhane","code_ostan=".$row_resid['code_ostan']." AND code_anbar=".$row_resid['code_anbar']."");     
       $contractor_national_id=$db->get_from_where("nationalId","list_sardkhane_owner","code_ostan=".$row_resid['code_ostan']." AND code_anbar=".$row_resid['code_anbar']."");     
	   if(strlen($row_resid['code_ostan'])==1) $code_a=make_pattern($row_resid['code_ostan'],2);
       else $code_a=$row_resid['code_ostan'];
	   $shenaseAnbar=$code_a.$row_resid['code_anbar'];
       //$shomareGhabz=$mtActiveYear.$row_resid['shomare_resid'];
       $shomareGhabz='0'.$mtActiveYear.$shenaseAnbar.$row_resid['shomare_resid'];
          
	   if($row_resid['barname_no']=='')$barname_no='1';
	   else $barname_no=$row_resid['barname_no'];
	   
	   // if($row_resid['barname_no']=='')$BillLadingNo=null;
	   // else $BillLadingNo=$row_resid['barname_no'];
	   
	   if(($row_resid['plak4']=='')or($row_resid['plak4']==0))$plak4=11;
	   else $plak4=$row_resid['plak4'];
	   if(($row_resid['plak3']=='')or($row_resid['plak3']==0))$plak3=ع;
	   else $plak3=$row_resid['plak3'];
	   if(($row_resid['plak2']=='')or($row_resid['plak2']==0))$plak2=111;
	   else $plak2=$row_resid['plak2'];
	   if(($row_resid['plak1']=='')or($row_resid['plak1']==0))$plak1=11;
	   else $plak1=$row_resid['plak1'];
	   //الگو
	   //$plak=$plak1.'|'.$plak4.'|'.$plak2.'|'.$plak3;
	   $plak=$plak1.'|'.$plak2.'|'.$plak3.'|'.$plak4;
	   
	   if($row_resid['noe_tahvil_bar']==3)$vehicle_type=3;
	   else $vehicle_type=1;
	 
	   // //جابه جایی
	   // if(($row_resid['noe_tahvil_bar']==4)OR($row_resid['noe_tahvil_bar']==5))$processSequence=80;
       // //جابه جایی نباشد و کالا داخلی
	   // else $processSequence=71;
	   //$wsdl_url='http://10.7.234.33/anbar/warehouse.asmx?wsdl';
	   header('Content-Type: text/html; charset=utf-8');
       //try
	   //{
	     //$client=new SoapClient($wsdl_url);
		 $seals1=array(
		  'marks'=>null,
		  'sealing_party'=>null
		 );
		 array_push($seals,$seals1);
		 $containers1=array(
		  'container_id'=>null,
		  'package_count'=>null,
		  'type'=>null,
		  'load_volume'=>null,
		  'seals'=>$seals,
		  'empty_weight'=>null,
		  'gross_weight'=>null,
		  'min_temp'=>null,
		  'max_temp'=>null,
		  'unit_temp'=>null,
		  'humidity'=>null,
		  'additional_information'=>null
		 );
		 array_push($containers,$containers1);
		 $packages1=array(
		  'container_id'=>null,
		  'package_id'=>null,
		  'marks'=>null,
		  'type'=>null,
		  'additional_information'=>null  
		 );
		 array_push($packages,$packages1);
		 $reference_docs1=array(
		  'type'=>'BL',
		  'number'=>$barname_no,
		  'id'=>null,
		  'issue_date'=>$row_resid['barname_tarikh']  
		 );	
		 //$reference_docs=array($reference_docs1);
		 array_push($reference_docs,$reference_docs1);

	     $q_resid_k_d="SELECT r_k_d.*,name_kala,mahmule_type,kala.code_vahedkala,kala.code_bastebandy,sharh_bastebandy From resid_kala_detail r_k_d INNER JOIN kala ON kala.code_kala=r_k_d.code_kala INNER JOIN bastebandy ON kala.code_bastebandy=bastebandy.code_bastebandy  WHERE r_k_d.code_ostan=".$row_resid['code_ostan']." AND r_k_d.code_anbar=".$row_resid['code_anbar']." AND r_k_d.year=$mtActiveYear AND r_k_d.shomare_resid='".$row_resid['shomare_resid']."'";
	     $res_Resid_k_d = mysql_query($q_resid_k_d);
	     while($row_resid_k_d=mysql_fetch_assoc($res_Resid_k_d))//جزئیات کالا
	     {
		  //الگو   
	       $goodId='02'.(make_pattern($row_resid_k_d['code_kala'],10));
		   IF($row_resid_k_d['code_vahedkala']==1)//کیلوگرم
	       {
		      $measurement_unit=1;
	          $count=$row_resid_k_d['vazn_khales_r_d_sub'];
	       }
           ELSE //تعداد//قطعه
	       {
		      $measurement_unit=6;
		      $count=$row_resid_k_d['tedad_karton_r_d_sub'];   
	       }
	       //داخلی یا وارداتی
	       IF($row_resid_k_d['mahmule_type']==1)$production_type=1;
	       ELSE $production_type=2;		   
		   $receipt_items1=array(
		    //'row_number'=>'1',
		    'good_id'=>$goodId,
		    'cid_code'=>null,
		    'general_goods_id'=>null,  
		    'hs_code'=>null,  
		    'tracking_code'=>null,  
		    'goods_description'=>$row_resid_k_d['name_kala'],  
		    'dangerous_goods_code'=>null,  
		    'measurement_unit'=>$measurement_unit,  
		    'production_type'=>$production_type,  
		    'count'=>$count,  
		    'gross_weight'=>$row_resid_k_d['vazn_nakhales_r_d_sub'],  
		    'net_weight'=>$row_resid_k_d['vazn_khales_r_d_sub'],  
		    'volume'=>null,  
		    'container_id'=>null,  
		    'package_id'=>null,  
		    'package_count'=>$row_resid_k_d['tedad_karton_r_d_sub'],  
		    'package_type'=>$row_resid_k_d['sharh_bastebandy'],  
		    'comments'=>null,  
		    'additional_information'=>null 
		   );
		   
		   array_push($receipt_items,$receipt_items1);
		 }
         $params=array(
		  'number'=>$shomareGhabz,
          'gov_number'=>$shomareGhabz,
		  'rcp_date'=>$row_resid['tarikh_resid'],
          'warehouse_id'=>$warehouse_id,
          'contractor_national_id'=>$contractor_national_id,
          'postal_code'=>$row_resid['postal_code'],
          //'containers'=>$containers,
          //'packages'=>$packages,
		  'discharge_date'=>$row_resid['tarikh_resid'],
		  'owner'=>'14002771736',
		  'owner_birth_date'=>null,
		  'driver_national_id'=>$row_resid['ranande_melicode'],
          'driver_birth_date'=>null,
		  'deliverer_national_id'=>null,
		  'deliverer_birth_date'=>null,
		  'reference_docs'=>$reference_docs,
		  'insurance_doc_number'=>null,
		  'insurance_company_code'=>null,
		  'carrier_national_id'=>null,
		  'carrier_name'=>$row_resid['name_peymankar_haml'],
		  'vehicle_name'=>null,
		  'vehicle_type'=>$vehicle_type,
		  'vehicle_number'=>$plak,
		  'net_weight'=>$row_resid['vazn_khales_r'],
		  'gross_weight'=>$row_resid['vazn_nakhales_r'],
		  'description'=>null,
		  'place_description'=>null,
		  'additional_information'=>null,
		  'receipt_items'=>$receipt_items
         );
		 
		 // $params=array(
		  // 'number'=>$shomareGhabz,
          // 'gov_number'=>$shomareGhabz,
		  // 'rcp_date'=>$row_resid['tarikh_resid'],
          // 'warehouse_id'=>$warehouse_id,
          // 'contractor_national_id'=>$contractor_national_id,
          // 'postal_code'=>$row_resid['postal_code'],
          // 'containers'=>$containers,
          // 'packages'=>$packages,
		  // 'discharge_date'=>$row_resid['tarikh_resid'],
		  // 'owner'=>'14002771736',
		  // 'owner_birth_date'=>null,
		  // 'deliverer_national_id'=>null,
		  // 'deliverer_birth_date'=>null,
		  // 'reference_docs'=>$reference_docs,
		  // 'insurance_doc_number'=>null,
		  // 'insurance_company_code'=>null,
		  // 'carrier_national_id'=>null,
		  // 'carrier_name'=>$row_resid['name_peymankar_haml'],
		  // 'vehicle_name'=>null,
		  // 'vehicle_type'=>1,
		  // 'vehicle_number'=>$plak,
		  // 'net_weight'=>$row_resid['vazn_khales'],
		  // 'gross_weight'=>null,
		  // 'description'=>null,
		  // 'place_description'=>null,
		  // 'additional_information'=>null,
		  // 'receipt_items'=>$receipt_items,
         // );
		 
		 //echo '<pre>'; print_r($params); echo '</pre>';
		 $result=preg_replace("/\\\\u([a-f0-9]{4})/e", "iconv('UCS-4LE','UTF-8',pack('V', hexdec('U$1')))", json_encode($params));
		 //echo '<pre>'; echo($result); echo '</pre>';
		 $encodedData = json_encode($params);

		 $curl = curl_init();
		 curl_setopt_array($curl, array(
          CURLOPT_URL => 'http://10.7.234.33/warehouse/api/warehouse/ReceiptPermanent',
          CURLOPT_USERPWD => 'ajix_agridam:3rt67HM',
		  CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>$encodedData,
          CURLOPT_HTTPHEADER => array(
           'Authorization: Basic YWppeF9hZ3JpZGFtOjNydDY3SE0=',
           'Content-Type: application/json'),
          ));
		  
          $response = curl_exec($curl);
          //$response=str_replace("'","\"",$response);
          // var_dump( $response);
		  // echo '<br>';
		  // print_r( $response);
		  // echo '<br>';
		  // echo "hello:".$response->error_code;
		  //echo "<br>\r\n";
		  $response = str_replace(array("\"{\"","\"}\""),array("'{\"","\"}'")
		             ,str_replace(array('\"',"\\\\","'"),array('"',"\\")
			 	     ,preg_replace("/\\\\u([a-f0-9]{4})/e", "iconv('UCS-4LE','UTF-8',pack('V', hexdec('U$1')))",json_decode($response))));

		  echo "<br>\r\n";		  
		  $array =json_decode($response,true); # آرایه
		  $object=json_decode($response);      # آبجکت
		  
		  print_r($array);

		  $wb_error_code =$object->error_code;
		  $wb_error_message =$object->error_message;
		  $wb_creator =$object->creator;
		  $wb_create_date =$object->create_date;
		  $wb_id =$object->id;
		  
		  #$response_obj=preg_replace("/\\\\u([a-f0-9]{4})/e", "iconv('UCS-4LE','UTF-8',pack('V', hexdec('U$1')))",json_decode($response));
          #$response_obj=str_replace("'"," ",$response_obj);
		  #$response_obj=json_decode($response);
		  #print_r ($response_obj);
  		  #echo '<pre>'; var_dump($response_obj); echo '</pre>';
		  #echo '<br>';
          #echo $response_obj->error_detail; 
          curl_close($curl);
		 
	   //}
	   // catch(SoapFault $client)
	   // {
		 // echo "<script>alert('وب سرویس فعال نمی باشد')</script>";
		 // echo  $e->getMessage();
	   // }
	   if($object->error_code != 0)
       {
	    echo "<script>alert($object->error_message)</script>";
	    //exit();
       }
	   $update_track=("UPDATE resid SET wb_error_code='$wb_error_code',wb_error_message='$wb_error_message',wb_creator='$wb_creator',wb_create_date='$wb_create_date',wb_id='$wb_id' WHERE code_ostan=".$row_resid['code_ostan']." AND code_anbar=".$row_resid['code_anbar']." AND shomare_resid='".$row_resid['shomare_resid']."' AND year=$mtActiveYear");
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
echo'
</form>
</body>
</html>';	
?>