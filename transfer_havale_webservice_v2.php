<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="transfer_havale_webservice_v2.php";
echo'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" />
<html xmlns="http://www.w3.org/1999/xhtml" dir=rtl>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>انتقال حواله های ارسال نشده به وب سرویس-نسخه 2</title>
<link href="styles.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="functions.js"></script>
<link type="text/css" href="styles/jquery-ui-1.8.14.css" rel="stylesheet" />
<script type="text/javascript" src="scripts/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="scripts/jquery.ui.datepicker-cc.all.min.js"></script>
<script type="text/javascript">
$(function(){	    
    $(".datepicker6").datepicker({
        defaultDate:"'.$today.'",
		showOn: "button",
        buttonImage: "styles/images/calendar5.png",
        buttonImageOnly: true,
		showButtonPanel: true,
	    changeMonth: true,
	    changeYear: true,
    });
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
	<tr><td colspan="4" class="title">انتقال حواله های ارسال نشده به وب سرویس-نسخه 2</td></tr>
    <tr><td colspan="4" class="tr1">تاریخ : <input class="datepicker6" type="text" name="tarikh_havale_anbar"/></td></tr>
	<tr class="tr1"><td colspan="4" height="60px"><input class="buttonme" type="submit" name="transfer" value="transfer havale"></td></tr> 
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
  // $q_havale="SELECT * From havale h INNER JOIN list_sardkhane l_s ON h.code_ostan=l_s.code_ostan AND h.code_anbar=l_s.code_anbar
	          // WHERE h.code_ostan=1 and h.code_anbar=102 and h.shomare_havale_anbar='00754' and h.tarikh_havale_anbar>='1397/07/01' AND sabt_nahayi=1 and year=$mtActiveYear AND status=0 AND h.code_anbar!=301 AND situation_type=1 AND l_s.activate=1 AND chkwebservice=1 AND warehouse_id IS NOT NULL AND(webservice_error_code_s IS NULL or webservice_error_code_s!='0') ";
  
  $q_havale="SELECT * From havale h INNER JOIN list_sardkhane l_s ON h.code_ostan=l_s.code_ostan AND h.code_anbar=l_s.code_anbar
	          WHERE h.tarikh_havale_anbar<='$tarikh_havale_anbar' AND sabt_nahayi=1 and year=$mtActiveYear AND status=0 AND h.code_anbar!=301 AND situation_type=1 AND l_s.activate=1 AND chkwebservice=1 AND warehouse_id IS NOT NULL AND register_error_code=0 AND(webservice_error_code_s IS NULL or webservice_error_code_s!='0') ";

  echo $q_havale;	          
  $res_havale = mysql_query($q_havale);
  while($row_havale=$db->fetch_assoc($res_havale))
  {
	$warehouse_id=$db->get_from_where("warehouse_id","list_sardkhane","code_ostan=".$row_havale['code_ostan']." AND code_anbar=".$row_havale['code_anbar']."");     
	if(strlen($row_havale['code_ostan'])==1) $code_a=make_pattern($row_havale['code_ostan'],2);
    else $code_a=$row_havale['code_ostan'];
    $shomareGhabz=$mtActiveYear.$code_a.$row_havale['code_anbar'].$row_havale['shomare_havale_anbar'];

	if($row_havale['plak4']=='')$plak4=null;
	else $plak4=$row_havale['plak4'];
	if($row_havale['plak3']=='')$plak3=null;
	else $plak3=$row_havale['plak3'];
	if($row_havale['plak2']=='')$plak2=null;
	else $plak2=$row_havale['plak2'];
	if($row_havale['plak1']=='')$plak1=null;
	else $plak1=$row_havale['plak1'];
	$plak=$plak1.$plak2.$plak3.$plak4;

	//تبدیل تاریخ شمسی به میلادی
	$sql_tarikh=$row_havale['tarikh_havale_anbar'];
    $d=substr($sql_tarikh,8,2);$m=substr($sql_tarikh,5,2);$y=substr($sql_tarikh,0,4);
    $milady=jalali_to_gregorian($y,$m,$d);
    $sal=$milady[0];$mah=$milady[1];$rouz=$milady[2];
    $tarikh_havale_MI=$sal.'-'.$mah.'-'.$rouz;
   
	//$wsdl_url='http://10.7.234.33/warehouse/warehouse.asmx?wsdl';
	$wsdl_url='http://10.7.234.33/anbar/warehouse.asmx?wsdl';
	header('Content-Type: text/html; charset=utf-8');
    try
	{
	  $client=new SoapClient($wsdl_url);
	  $listitemsinfo=array();   
	  $q_havale_d="SELECT h_d.*,kala.good_id From havale_detail h_d INNER JOIN kala ON kala.code_kala=h_d.code_kala WHERE h_d.code_ostan=".$row_havale['code_ostan']." AND h_d.code_anbar=".$row_havale['code_anbar']." AND h_d.year=$mtActiveYear AND h_d.shomare_havale_anbar='".$row_havale['shomare_havale_anbar']."'";
	  $res_havale_d = mysql_query($q_havale_d);
	  while($row_havale_d=mysql_fetch_assoc($res_havale_d))//جزئیات کالا
	  {
	      $nameKala=$db->get_from_where("name_kala","kala","code_kala=".$row_havale_d['code_kala']."");     
	      $vahedKala=$db->get_from_where("sharh_vahedkala","kala INNER JOIN vahed_kala ON kala.code_vahedkala=vahed_kala.code_vahedkala","code_kala=".$row_havale_d['code_kala']."");     
          //if($vahedKala=='کیلوگرم')$UnitMeasurement='Kilogram';
	      $bastebandyKala=$db->get_from_where("sharh_bastebandy","kala INNER JOIN bastebandy ON kala.code_bastebandy=bastebandy.code_bastebandy","code_kala=".$row_havale_d['code_kala']."");     
          
		  if(strlen($row_havale_d['mah_tolid_shamsi'])==1) $mah2raghami=make_pattern($row_havale_d['mah_tolid_shamsi'],2);
          else $mah2raghami=$row_havale_d['mah_tolid_shamsi'];
          if(strlen($row_havale_d['rouz_tolid_shamsi'])==1) $rouz2raghami=make_pattern($row_resid_k_d['rouz_tolid_shamsi'],2);
          else $rouz2raghami=$row_havale_d['rouz_tolid_shamsi'];
			
		  $ProductionDate=$row_havale_d['sal_tolid_shamsi'].'/'.$mah2raghami.'/'.$rouz2raghami;
		  //تبدیل تاریخ شمسی به میلادی
	      
          $d=substr($ProductionDate,8,2);$m=substr($ProductionDate,5,2);$y=substr($ProductionDate,0,4);
          $milady1=jalali_to_gregorian($y,$m,$d);
          $sal1=$milady1[0];$mah1=$milady1[1];$rouz1=$milady1[2];
          $ProductionDate_MI=$sal1.'-'.$mah1.'-'.$rouz1;
	      $vazn_khales_h_d=round($row_havale_d['vazn_khales_h_d'],3); 
		  
		  if(($row_havale_d['good_id']==null)OR($row_havale_d['good_id']=='')OR($row_havale_d['good_id']=='0')) $goodId=$row_havale_d['code_kala'];
	      else $goodId=$row_havale_d['good_id'];
		  
		  $itemsinfo=array(
	       'category_id'=>'',
	       'taxonomy_id'=>'',
	       'good_id'=>$goodId,
	       'good_name'=>$nameKala,
	       'total_weight'=>$vazn_khales_h_d,
	       'measurement_unit'=>$vahedKala,
	       'count'=>$vazn_khales_h_d,
	       'package_type'=>$bastebandyKala,
	       'package_count'=>$row_havale_d['tedad_karton_h_d'],
	       'item_value'=>'',
	       'production_date'=>$ProductionDate_MI,
	       'expire_date'=>$ProductionDate_MI,
	       'description'=>'',
	       'location'=>''
	       );
	      array_push($listitemsinfo,$itemsinfo);  
	  }
	  $otherinfo=array(
		 'owner_phone'=>'82971',
		 'good_owneragent'=>'',
		 'bol_date'=>$tarikh_havale_MI,
		 'bol_tid'=>'',
		 'bol_series'=>'',
		 'bol_serial'=>''
	  );
	  $docinfo=array(
		 'warehouse_id'=>$warehouse_id,
		 'contractor_co_national_id'=>'14002771736',
		 'number'=>$shomareGhabz,
		 'type'=>'out',
		 'issue_date'=>$tarikh_havale_MI,
		 'owner'=>'14002771736',
		 'owner_name'=>'شرکت پشتیبانی امور دام کشور',
		 'vehicle_number'=>$plak,
		 'driver_national_id'=>'',
		 'driver'=>'',
		 'insurance_name'=>'',
		 'insurance_date'=>$tarikh_havale_MI,
		 'insurance_number'=>'',
		 'Commodity'=>$listitemsinfo,
		 'details'=>$otherinfo
	   );
	   $params=array(
          'username'=>'02',
          'password'=>'HJ78mnGD',
          'type'=>'out',
          'doc'=>$docinfo
		); 
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
	   
	$update_track=("UPDATE havale SET webservice_error_code_s='$webservice_error_code',webservice_error_message_s='$webservice_error_message',webservice_status_s='$webservice_status',webservice_number_s='$webservice_number' WHERE code_ostan=".$row_havale['code_ostan']." AND code_anbar=".$row_havale['code_anbar']." AND shomare_havale_anbar='".$row_havale['shomare_havale_anbar']."' AND year=$mtActiveYear");
	$update_res=mysql_query($update_track);
     
  }
  if($update_res)
  {
   	 mysql_query("COMMIT");
     echo "<script>alert('success')</script>"; 
     echo "<script>window.location='$FileName'</script>";
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