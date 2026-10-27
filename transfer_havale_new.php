<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="transfer_havale_new.php";
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
	<tr><td colspan="4" class="title">انتقال حواله های ارسال نشده به وب سرویس (سرویس خوشه های کشاورزی)</td></tr>
    <tr><td colspan="4" class="tr1">از تاریخ : <input id="datepickerfrom" type="text" name="date1"/></td></tr>
    <tr><td colspan="4" class="tr1">تا تاریخ : <input id="datepickerto" type="text" name="date2"/></td></tr>
	<tr class="tr1"><td colspan="4" height="60px"><input class="buttonme" type="submit" name="transfer" value="انتقال حواله ها ثبت نشده"></td></tr> 
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
	$goods_issue_items=array();
	$base_date='1402/11/09';      
    $q_havale="SELECT * From havale h INNER JOIN list_sardkhane l_s ON h.code_ostan=l_s.code_ostan AND h.code_anbar=l_s.code_anbar INNER JOIN kala ON h.code_kala=kala.code_kala 
	           INNER JOIN bastebandy ON kala.code_bastebandy=bastebandy.code_bastebandy
			   WHERE h.tarikh_havale_anbar>='$base_date' AND h.tarikh_havale_anbar BETWEEN '$date1' AND '$date2' and year=$mtActiveYear AND sabt_nahayi=1 AND h.deleted=0 AND h.status=0 AND h.code_anbar!=301 AND chkwebservice=1 AND situation_type=1 AND l_s.activate=1 AND noe_tahvil_bar!=9 AND warehouse_id IS NOT NULL AND register_error_code=0 AND (wb_id IS NULL OR wb_id=0)";
	//echo $q_havale;
	$res_havale = mysql_query($q_havale);
	while($row_havale=$db->fetch_assoc($res_havale))
    {
       $params=array();
       $containers=array();
       $seals=array();
       $packages=array();
       $reference_docs=array();
	   $goods_issue_items=array();
	   $warehouse_id=$db->get_from_where("warehouse_id","list_sardkhane","code_ostan=".$row_havale['code_ostan']." AND code_anbar=".$row_havale['code_anbar']."");     
       //$contractor_national_id=$db->get_from_where("nationalId","list_sardkhane_owner","code_ostan=".$row_havale['code_ostan']." AND code_anbar=".$row_havale['code_anbar']."");     
	   $contractor_national_id='14002771736';
	   if(strlen($row_havale['code_ostan'])==1) $code_a=make_pattern($row_havale['code_ostan'],2);
       else $code_a=$row_havale['code_ostan'];
	   $shenaseAnbar=$code_a.$row_havale['code_anbar'];
       //$shomareBijak=$mtActiveYear.$row_havale['shomare_havale_anbar'];
       //الگو
	   $shomareBijak='1'.$mtActiveYear.$shenaseAnbar.$row_havale['shomare_havale_anbar'];
       IF($row_havale['code_vahedkala']==1)//کیلوگرم
	    {
		      $measurement_unit=1;
	          $count=$row_havale['vazn_khales_h'];
	    }
        ELSE //تعداد//قطعه
	    {
		      $measurement_unit=6;
		      $count=$row_havale['tedad_karton_h'];   
	    }

	   //داخلی یا وارداتی
	    IF($row_havale['mahmule_type']==1)$production_type=1;
	    ELSE $production_type=2;	
	   
	   if($row_havale['shomare_barname_h']=='')$shomare_barname_h=1;
	   else $shomare_barname_h=$row_havale['shomare_barname_h'];
	   
	   if(($row_havale['plak4']=='')or($row_havale['plak4']==0))$plak4=11;
	   else $plak4=$row_havale['plak4'];
	   if(($row_havale['plak3']=='')or($row_havale['plak3']==0))$plak3=ع;
	   else $plak3=$row_havale['plak3'];
	   if(($row_havale['plak2']=='')or($row_havale['plak2']==0))$plak2=111;
	   else $plak2=$row_havale['plak2'];
	   if(($row_havale['plak1']=='')or($row_havale['plak1']==0))$plak1=11;
	   else $plak1=$row_havale['plak1'];
	   //الگو
	   //$plak=$plak1.'|'.$plak4.'|'.$plak2.'|'.$plak3;
	   $plak=$plak1.'|'.$plak2.'|'.$plak3.'|'.$plak4;
       //الگو   
	   $goodId='02'.(make_pattern($row_havale['code_kala'],10));
	 
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
		  'number'=>$shomare_barname_h,
		  'id'=>null,
		  'issue_date'=>$row_havale['tarikh_barname_h']  
		 );	
		 //$reference_docs=array($reference_docs1);
		 array_push($reference_docs,$reference_docs1);

		 $goods_issue_items1=array(
		  //'row_number'=>'1',
		  //'good_id'=>$goodId,
		  'cid_code'=>null,
		  'general_goods_id'=>$row_havale['general_goods_id'],  
		  'hs_code'=>null,  
		  'tracking_code'=>null,  
		  'goods_description'=>$row_havale['name_kala'],  
		  'dangerous_goods_code'=>null,  
		  'measurement_unit'=>$measurement_unit,  
		  'production_type'=>$production_type,  
		  'count'=>$count,  
		  'gross_weight'=>$row_havale['vazn_nakhales_h'],  
		  'net_weight'=>$row_havale['vazn_khales_h'],  
		  'volume'=>null,  
		  'container_id'=>null,  
		  'package_id'=>null,  
		  'package_count'=>$row_havale['tedad_karton_h'], 
		  'package_type'=>$row_havale['package_type'],  
		  'comments'=>null,  
		  'additional_information'=>null 
		 );
		 
		 array_push($goods_issue_items,$goods_issue_items1);
         $params=array(
		  'number'=>$shomareBijak,
          'gov_number'=>$shomareBijak,
		  'goods_issue_date'=>$row_havale['tarikh_havale_anbar'],
          'warehouse_id'=>$warehouse_id,
          'contractor_national_id'=>$contractor_national_id,
          'postal_code'=>$row_havale['postal_code'],
          //'containers'=>$containers,
          //'packages'=>$packages,
		  'load_date'=>$row_havale['tarikh_havale_anbar'],
		  'owner'=>'14002771736',
		  'owner_birth_date'=>null,
		  'consignee_national_id'=>null,
		  'consignee_birth_date'=>null,
		  'carrier_national_id'=>null,
		  'carrier_name'=>null,
		  'vehicle_name'=>null,
		  'vehicle_type'=>1,
		  'vehicle_number'=>$plak,
		  'net_weight'=>$row_havale['vazn_khales_h'],
		  'gross_weight'=>$row_havale['vazn_nakhales_h'],
		  'reference_docs'=>$reference_docs,
		  'description'=>null,
		  'place_description'=>null,
		  'additional_information'=>null,
		  'goods_issue_items'=>$goods_issue_items
         );
		 
		 // $params=array(
		  // 'number'=>$shomareBijak,
          // 'gov_number'=>$shomareBijak,
		  // 'goods_issue_date'=>$row_havale['tarikh_havale_anbar'],
          // 'warehouse_id'=>$warehouse_id,
          // 'contractor_national_id'=>$contractor_national_id,
          // 'postal_code'=>$row_havale['postal_code'],
          // 'containers'=>$containers,
          // 'packages'=>$packages,
		  // 'load_date'=>$row_havale['tarikh_havale_anbar'],
		  // 'owner'=>'14002771736',
		  // 'owner_birth_date'=>null,
		  // 'consignee_national_id'=>null,
		  // 'consignee_birth_date'=>null,
		  // 'carrier_national_id'=>null,
		  // 'carrier_name'=>$row_havale['name_peymankar_haml'],
		  // 'vehicle_name'=>null,
		  // 'vehicle_type'=>1,
		  // 'vehicle_number'=>$plak,
		  // 'net_weight'=>$row_havale['vazn_khales_h'],
		  // 'gross_weight'=>null,
		  // 'reference_docs'=>$reference_docs,
		  // 'description'=>null,
		  // 'place_description'=>null,
		  // 'additional_information'=>null,
		  // 'goods_issue_items'=>$goods_issue_items,
         // );
		 
		 //echo '<pre>'; print_r($params); echo '</pre>';
		 $result=preg_replace("/\\\\u([a-f0-9]{4})/e", "iconv('UCS-4LE','UTF-8',pack('V', hexdec('U$1')))", json_encode($params));
		 //echo '<pre>'; echo($result); echo '</pre>';
		 $encodedData = json_encode($params);

		 $curl = curl_init();
		 curl_setopt_array($curl, array(
          CURLOPT_URL => 'http://10.7.234.33/warehouse/api/warehouse/DraftPermanent',
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
		  
		  //print_r($array);

		  $wb_error_code =$object->error_code;
		  $wb_error_message =$object->error_message;
		  $wb_creator =$object->creator;
		  $wb_create_date =$object->create_date;
		  $wb_id =$object->id;
		  
		  echo $shomareBijak.':'.$wb_error_code.'-'.$wb_error_message.'-'.$wb_id;
		 
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
	   //2014:واحد غیرفعال است، لطفا جهت فعالسازی واحد به اداره صنعت، معدن و تجارت شهرستان مراجعه نمائید.
	   //wb_id:warehouse_id برگشت میخورد 
	   IF($wb_error_code=='2014') $wb_id='';
	   $update_track=("UPDATE havale SET wb_error_code='$wb_error_code',wb_error_message='$wb_error_message',wb_creator='$wb_creator',wb_create_date='$wb_create_date',wb_id='$wb_id' WHERE code_ostan=".$row_havale['code_ostan']." AND code_anbar=".$row_havale['code_anbar']." AND shomare_havale_anbar='".$row_havale['shomare_havale_anbar']."' AND year=$mtActiveYear");
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