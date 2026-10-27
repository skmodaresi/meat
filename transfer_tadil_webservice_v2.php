<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="transfer_tadil_webservice_v2.php";
echo'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" />
<html xmlns="http://www.w3.org/1999/xhtml" dir=rtl>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>انتقال تعدیل  ها</title>
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
   <div style="float:right;width:100%;margin:0px;height:100%;overflow:auto;overflow-x:hidden;">
   <table width="600px" border="0" align="center" cellpadding="0" cellspacing="0" >
    <tr><td colspan="4" height="20px">&nbsp;</td></tr>
	<tr><td colspan="4" class="title">انتقال تعدیل های ارسال نشده به وب سرویس-نسخه 2</td></tr>
    <tr class="tr1"><td colspan="4" height="60px"><input class="buttonme" type="submit" name="transfer" value="transfer tadil"></td></tr> 
    <tr class="footer"><td colspan="4">&nbsp;</td></tr>
   </table>
   </div>
  </td>
 </tr>	
</table>
</div>';

//////////////////////////////////////////////////////////////////////////////////////////////
if(isset($transfer))
{
 mysql_query('SET AUTOCOMMIT=0');//TRANSACTIONشروع 
 mysql_query('START TRANSACTION');
 $q="SELECT * From tadil_mojody t INNER JOIN list_sardkhane l_s ON t.code_ostan=l_s.code_ostan AND t.code_anbar=l_s.code_anbar
	 WHERE  t.year=$mtActiveYear AND t.status=0 AND t.deleted=0 AND t.code_anbar!=301 AND situation_type=1 AND l_s.activate=1 AND chkwebservice=1 AND warehouse_id IS NOT NULL AND(webservice_error_code IS NULL or webservice_error_code!='0')  ";
  
 //echo $q;
 $res = mysql_query($q);	
 while($row=$db->fetch_assoc($res))
 {   
  $warehouse_id=$db->get_from_where("warehouse_id","list_sardkhane","code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']."");     
  if(strlen($row['code_ostan'])==1) $code_a=make_pattern($row['code_ostan'],2);
  else $code_a=$row['code_ostan'];
  $shomareGhabz=$mtActiveYear.$code_a.$row['code_anbar'].$row['shomare_barge_tadil'].'t';
  //تعدیل اضافه مثل رسید
  IF($row['noe_tadil']==1) $type_tadil='in'; 
  //تعدیل کسری مثل حواله
  ELSE IF($row['noe_tadil']==2) $type_tadil='out'; 
  $vahedKala=$db->get_from_where("sharh_vahedkala","kala INNER JOIN vahed_kala ON kala.code_vahedkala=vahed_kala.code_vahedkala","code_kala=".$row['code_kala']."");     
  $bastebandyKala=$db->get_from_where("sharh_bastebandy","kala INNER JOIN bastebandy ON kala.code_bastebandy=bastebandy.code_bastebandy","code_kala=".$row['code_kala']."");     
  $nameKala=$db->get_from_where("name_kala","kala","code_kala=".$row['code_kala']."");     
  //شناسه کالا
  $good_id=$db->get_from_where("good_id","kala","code_kala=".$row['code_kala']."");     
  if(($good_id==null)OR($good_id=='')OR($good_id=='0')) $goodId=$row['code_kala'];
  else $goodId=$good_id;
  //تبدیل تاریخ شمسی به میلادی
  $sql_tarikh=$row['tarikh_barge_tadil'];
  $d=substr($sql_tarikh,8,2);$m=substr($sql_tarikh,5,2);$y=substr($sql_tarikh,0,4);
  $milady=jalali_to_gregorian($y,$m,$d);
  $sal=$milady[0];$mah=$milady[1];$rouz=$milady[2];
  $tarikh_tadil_MI=$sal.'-'.$mah.'-'.$rouz;
  if(strlen($row['mah_tolid_shamsi'])==1) $mah2raghami=make_pattern($row['mah_tolid_shamsi'],2);
  else $mah2raghami=$row['mah_tolid_shamsi'];
  if(strlen($row['rouz_tolid_shamsi'])==1) $rouz2raghami=make_pattern($row['rouz_tolid_shamsi'],2);
  else $rouz2raghami=$row['rouz_tolid_shamsi'];		
  $ProductionDate=$row['sal_tolid_shamsi'].'/'.$mah2raghami.'/'.$rouz2raghami;
  //تبدیل تاریخ شمسی به میلادی     
  $d=substr($ProductionDate,8,2);$m=substr($ProductionDate,5,2);$y=substr($ProductionDate,0,4);
  $milady1=jalali_to_gregorian($y,$m,$d);
  $sal1=$milady1[0];$mah1=$milady1[1];$rouz1=$milady1[2];
  $ProductionDate_MI=$sal1.'-'.$mah1.'-'.$rouz1;
  $wsdl_url='http://10.7.234.33/anbar/warehouse.asmx?wsdl';
  header('Content-Type: text/html; charset=utf-8');
	try
	{
	  $client=new SoapClient($wsdl_url);
	  $itemsinfo=array(
	   'category_id'=>'',
	   'taxonomy_id'=>'',
	   'good_id'=>$goodId,
	   'good_name'=>$nameKala,
	   'total_weight'=>$row['meghdar_khales_tadil'],
	   'measurement_unit'=>$vahedKala,
	   'count'=>$row['meghdar_khales_tadil'],
	   'package_type'=>$bastebandyKala,
	   'package_count'=>$row['tedad_karton_tadil'],
	   'item_value'=>'',
	   'production_date'=>$ProductionDate_MI,
	   'expire_date'=>$ProductionDate_MI,
	   'description'=>'',
	   'location'=>''
	  );
	  $listitemsinfo=array(
          $itemsinfo
       );
	  $otherinfo=array(
		 'owner_phone'=>'82971',
		 'good_owneragent'=>'',
		 'bol_date'=>$tarikh_tadil_MI,
		 'bol_tid'=>'',
		 'bol_series'=>'',
		 'bol_serial'=>''
	  );
	  $docinfo=array(
		 'warehouse_id'=>$warehouse_id,
		 'contractor_co_national_id'=>'14002771736',
		 'number'=>$shomareGhabz,
		 'type'=>$type_tadil,
		 'issue_date'=>$tarikh_tadil_MI,
		 'owner'=>'14002771736',
		 'owner_name'=>'شرکت پشتیبانی امور دام کشور',
		 'vehicle_number'=>'',
		 'driver_national_id'=>'',
		 'driver'=>'',
		 'insurance_name'=>'',
		 'insurance_date'=>$tarikh_tadil_MI,
		 'insurance_number'=>'',
		 'Commodity'=>$listitemsinfo,
		 'details'=>$otherinfo
	   );
	   $params=array(
          'username'=>'02',
          'password'=>'HJ78mnGD',
          'type'=>$type_tadil,
          'doc'=>$docinfo
		); 
	   //echo '<pre>'; print_r($itemsInfo); echo '</pre>';//echo '<br>';
	   //echo '<pre>'; print_r($OtherInfo); echo '</pre>';//echo '<br>';
	   //echo '<pre>'; print_r($docInfo); echo '</pre>';//echo '<br>';
	   echo '<pre>'; print_r($params); echo '</pre>';
	   
	   
	  $result=$client->WarehouseInOut($params); 
	  $response=$result->WarehouseInOutResult;
	  $webservice_error_code =$response->ErrorCode;
	  $webservice_error_message =$response->ErrorMessage;
	  $webservice_status =$response->status;
	  $webservice_number =$response->number;
      
	  echo '<br>';
	  echo 'ErrorCode: ';print_r($response->ErrorCode);echo'<br>';
      echo 'ErrorMessage: ';print_r($response->ErrorMessage);echo'<br>';
      echo 'Type: ';print_r($response->Type);echo'<br>';
      echo 'warehouse_id: ';print_r($response->warehouse_id);echo'<br>';
      echo 'number: ';print_r($response->number);echo'<br>';
      echo 'status: ';print_r($response->status);echo'<br>';

		 //echo "<script>alert('کد پیگیری وب سرویس\\n$response')</script>"; 
	}
	// catch(SoapFault $client)
	catch(Exception $e)
	{
		 echo "<script>alert('وب سرویس فعال نمی باشد')</script>";
		 echo  $e->getMessage();
	}
	$update_track=("UPDATE tadil_mojody SET webservice_error_code='$webservice_error_code',webservice_error_message='$webservice_error_message',webservice_status='$webservice_status',webservice_number='$webservice_number' WHERE code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']." AND shomare_barge_tadil='".$row['shomare_barge_tadil']."' AND year=$mtActiveYear");
	$update_res=mysql_query($update_track);
     
 }
 //end while
	 	 
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
////////////////////////////////////////////////////////////////////////////////////////////////
echo'
</form>
</body>
</html>';	
?>