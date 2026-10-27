<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="transfer_resid_webservice_v2.php";
echo'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" />
<html xmlns="http://www.w3.org/1999/xhtml" dir=rtl>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>انتقال رسیدهای ارسال نشده به وب سرویس-نسخه 2</title>
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
	<tr><td colspan="4" class="title">انتقال رسیدهای ارسال نشده به وب سرویس-نسخه 2</td></tr>
    <tr><td colspan="4" class="tr1">تاریخ : <input class="datepicker6" type="text" name="tarikh_resid"/></td></tr>
	<tr class="tr1"><td colspan="4" height="60px"><input class="buttonme" type="submit" name="transfer" value="transfer resid"></td></tr> 
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
 $q_resid="SELECT * From resid r INNER JOIN list_sardkhane l_s ON r.code_ostan=l_s.code_ostan AND r.code_anbar=l_s.code_anbar
	       WHERE r.tarikh_resid<='$tarikh_resid' and r.year=$mtActiveYear AND r.sabt_nahayi=1 AND r.status=0 AND r.deleted=0 AND r.code_anbar!=301 AND situation_type=1 AND l_s.activate=1 AND chkwebservice=1 AND warehouse_id IS NOT NULL AND register_error_code=0 AND(webservice_error_code IS NULL or webservice_error_code!='0')  ";

 //echo $q_resid;
 $res_resid = mysql_query($q_resid);	
 while($row_resid=$db->fetch_assoc($res_resid))
 {   
  $warehouse_id=$db->get_from_where("warehouse_id","list_sardkhane","code_ostan=".$row_resid['code_ostan']." AND code_anbar=".$row_resid['code_anbar']."");     
  if(strlen($row_resid['code_ostan'])==1) $code_a=make_pattern($row_resid['code_ostan'],2);
  else $code_a=$row_resid['code_ostan'];
  $shomareGhabz=$mtActiveYear.$code_a.$row_resid['code_anbar'].$row_resid['shomare_resid'];
  //$shomareGhabz=$mtActiveYear.$row_resid['shomare_resid'];

  if($row_resid['plak4']=='')$plak4=null;
  else $plak4=$row_resid['plak4'];
  if($row_resid['plak3']=='')$plak3=null;
  else $plak3=$row_resid['plak3'];
  if($row_resid['plak2']=='')$plak2=null;
  else $plak2=$row_resid['plak2'];
  if($row_resid['plak1']=='')$plak1=null;
  else $plak1=$row_resid['plak1'];
  $plak=$plak1.$plak2.$plak3.$plak4;

  //تبدیل تاریخ شمسی به میلادی
  $sql_tarikh=$row_resid['tarikh_resid'];
  $d=substr($sql_tarikh,8,2);$m=substr($sql_tarikh,5,2);$y=substr($sql_tarikh,0,4);
  $milady=jalali_to_gregorian($y,$m,$d);
  $sal=$milady[0];$mah=$milady[1];$rouz=$milady[2];
  $tarikh_resid_MI=$sal.'-'.$mah.'-'.$rouz;

  $wsdl_url='http://10.7.234.33/anbar/warehouse.asmx?wsdl';
  header('Content-Type: text/html; charset=utf-8');
  $ranande_melicode=$row_resid['ranande_melicode'];
  $ranande_name=$row_resid['ranande_name'];
  try
	{
	  $client=new SoapClient($wsdl_url);
	  $listitemsinfo=array();   
	  $q_resid_k_d="SELECT r_k_d.*,kala.good_id From resid_kala_detail r_k_d INNER JOIN kala ON kala.code_kala=r_k_d.code_kala  WHERE r_k_d.code_ostan=".$row_resid['code_ostan']." AND r_k_d.code_anbar=".$row_resid['code_anbar']." AND r_k_d.year=$mtActiveYear AND r_k_d.shomare_resid='".$row_resid['shomare_resid']."'";
	  $res_Resid_k_d = mysql_query($q_resid_k_d);
	  while($row_resid_k_d=mysql_fetch_assoc($res_Resid_k_d))//جزئیات کالا
	  {
	        $nameKala=$db->get_from_where("name_kala","kala","code_kala=".$row_resid_k_d['code_kala']."");     
	        $vahedKala=$db->get_from_where("sharh_vahedkala","kala INNER JOIN vahed_kala ON kala.code_vahedkala=vahed_kala.code_vahedkala","code_kala=".$row_resid_k_d['code_kala']."");     
            //if($vahedKala=='کیلوگرم')$UnitMeasurement='Kilogram';
	        $bastebandyKala=$db->get_from_where("sharh_bastebandy","kala INNER JOIN bastebandy ON kala.code_bastebandy=bastebandy.code_bastebandy","code_kala=".$row_resid_k_d['code_kala']."");     

            if(strlen($row_resid_k_d['mah_tolid_shamsi'])==1) $mah2raghami=make_pattern($row_resid_k_d['mah_tolid_shamsi'],2);
            else $mah2raghami=$row_resid_k_d['mah_tolid_shamsi'];
            if(strlen($row_resid_k_d['rouz_tolid_shamsi'])==1) $rouz2raghami=make_pattern($row_resid_k_d['rouz_tolid_shamsi'],2);
            else $rouz2raghami=$row_resid_k_d['rouz_tolid_shamsi'];
			
			$ProductionDate=$row_resid_k_d['sal_tolid_shamsi'].'/'.$mah2raghami.'/'.$rouz2raghami;
		    //تبدیل تاریخ شمسی به میلادی
	      
            $d=substr($ProductionDate,8,2);$m=substr($ProductionDate,5,2);$y=substr($ProductionDate,0,4);
            $milady1=jalali_to_gregorian($y,$m,$d);
            $sal1=$milady1[0];$mah1=$milady1[1];$rouz1=$milady1[2];
            $ProductionDate_MI=$sal1.'-'.$mah1.'-'.$rouz1;
		    $vazn_khales_r_d_sub=round($row_resid_k_d['vazn_khales_r_d_sub'],3); 
			
		    if(($row_resid_k_d['good_id']==null)OR($row_resid_k_d['good_id']=='')OR($row_resid_k_d['good_id']=='0')) $goodId=$row_resid_k_d['code_kala'];
	        else $goodId=$row_resid_k_d['good_id'];
			
			$itemsinfo=array(
	         'category_id'=>'',
	         'taxonomy_id'=>'',
	         'good_id'=>$goodId,
	         'good_name'=>$nameKala,
	         'total_weight'=>$vazn_khales_r_d_sub,
	         'measurement_unit'=>$vahedKala,
	         'count'=>$vazn_khales_r_d_sub,
	         'package_type'=>$bastebandyKala,
	         'package_count'=>$row_resid_k_d['tedad_karton_r_d_sub'],
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
		 'bol_date'=>$tarikh_resid_MI,
		 'bol_tid'=>'',
		 'bol_series'=>'',
		 'bol_serial'=>''
	  );
	  $docinfo=array(
		 'warehouse_id'=>$warehouse_id,
		 'contractor_co_national_id'=>'14002771736',
		 'number'=>$shomareGhabz,
		 'type'=>'in',
		 'issue_date'=>$tarikh_resid_MI,
		 'owner'=>'14002771736',
		 'owner_name'=>'شرکت پشتیبانی امور دام کشور',
		 'vehicle_number'=>$plak,
		 'driver_national_id'=>$ranande_melicode,
		 'driver'=>$ranande_name,
		 'insurance_name'=>'',
		 'insurance_date'=>$tarikh_resid_MI,
		 'insurance_number'=>'',
		 'Commodity'=>$listitemsinfo,
		 'details'=>$otherinfo
	   );
	   $params=array(
          'username'=>'02',
          'password'=>'HJ78mnGD',
          'type'=>'in',
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
	$update_track=("UPDATE resid SET webservice_error_code='$webservice_error_code',webservice_error_message='$webservice_error_message',webservice_status='$webservice_status',webservice_number='$webservice_number' WHERE code_ostan=".$row_resid['code_ostan']." AND code_anbar=".$row_resid['code_anbar']." AND shomare_resid='".$row_resid['shomare_resid']."' AND year=$mtActiveYear");
	$update_res=mysql_query($update_track);
     
 }
 //end while
	 	 
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