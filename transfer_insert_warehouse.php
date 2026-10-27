<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="transfer_insert_warehouse.php";
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
	<tr><td colspan="4" class="title">ثبت سردخانه</td></tr>
    <tr><td colspan="4" class="tr1">شناسه سردخانه : <input  type="text" name="id"/></td></tr>
	<tr class="tr1"><td colspan="4" height="60px"><input class="buttonme" type="submit" name="transfer" value="ثبت انبار"></td></tr> 
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
   
	$params=array();
    header('Content-Type: text/html; charset=utf-8');       
    // $q="SELECT * FROM list_anbar_owner WHERE id_anbar=$id_ ORDER BY id_owner desc";
    // $res= mysql_query($q);
    // $row=$db->fetch_assoc($res);
    // $birth_date=AsLDate($row['birthDate']);
    
	$q2="SELECT * FROM list_sardkhane WHERE id='$id'";
    $res2= mysql_query($q2);
    $row2=$db->fetch_assoc($res2);
    echo $q2;
	if(strlen($row2['code_ostan'])==1) $code_a=make_pattern($row2['code_ostan'],2);
    else $code_a=$row2['code_ostan'];
    $shenaseAnbar=$code_a.$row2['code_anbar'];
    $area=($row2['zarfiyat_gharardadi']/1000);//تبدیل تن
  
    IF($row2['noe_malekiyat']==1) $warehouse_usage_type=0;
    ELSE $warehouse_usage_type=1;
    $self_address=$row2['province'].' '.$row2['township'].' '.$row2['zone'].' '.$row2['village'].' '.$row2['localitytype'].' '.$row2['localitycode'].' '.$row2['sublocality'].' '.$row2['street'].' '.$row2['street2'].' '.$row2['housenumber'].' '.$row2['floor'].' '.$row2['sidefloor'].' '.$row2['buildingname'].' '.$row2['description'];
    //ملکی
    IF($row2['noe_malekiyat']==1)$warehouse_owner_type=1;
    ELSE $warehouse_owner_type=2;
    
	
     $co_national_id='14002771736';
     //محسن سلامی
	 //$national_id='0056974701';
     //$birth_date='1351/01/01';
	 //$mobile='09121837587';
	 //حسین شیرزاد
	 $national_id='2141974097';
     $birth_date='1350/12/07';
	 //$mobile='09128110664';
	 $mobile='09912464675';
     $contractor_expire_date='1405/12/29';
     
	
  $params=array(
	      'national_id'=>$national_id,
	      'co_national_id'=>$co_national_id,
	      'birth_date'=>'1350/12/07',
	      'contractor_expire_date'=>'1405/12/29',
	      'mobile'=>$mobile,
	      'postal_code'=>$row2['postal_code'],
	      'self_address'=>$self_address,
	      'name'=>$row2['name_anbar'],
		  'warehouse_owner_type'=>$warehouse_owner_type,
	      'electric_bill_number'=>null,
	      'gas_bill_number'=>null,
	      'type'=>'4',
	      'activity_sector'=>'0150',
	      'supervisor_org'=>'87',
	      'zone_types'=>'1',
	      'zone_economic_types'=>'1',
		  'gov_warehouse_no'=>$shenaseAnbar,
	      'area'=>$area,
	      'area_type'=>'ton',
	      'warehouse_usage_type'=>$warehouse_usage_type,
	      'building_type'=>'0',
	      'goods_type'=>'6',
	      'unit_type'=>'3',
	      'unit_group'=>'3'
		  // ,
	      // 'on_error_data_send_sms_to_user'=>'False'
	   );
	    //چاپ آرایه
	    if(SuperUser())echo '<pre>'; print_r($params); echo '</pre>';	   
        $result=preg_replace("/\\\\u([a-f0-9]{4})/e", "iconv('UCS-4LE','UTF-8',pack('V', hexdec('U$1')))", json_encode($params));
	    $encodedData = json_encode($params);
	    //چاپ جیسون
	    if(SuperUser())echo $result;
	    
		$curl = curl_init();
	    curl_setopt_array($curl, array(
          CURLOPT_URL => 'http://10.7.234.33/warehouse/api/warehouse/RegisterWarehouse',
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
        $response = str_replace(array("\"{\"","\"}\""),array("'{\"","\"}'")
		             ,str_replace(array('\"',"\\\\","'"),array('"',"\\")
			 	     ,preg_replace("/\\\\u([a-f0-9]{4})/e", "iconv('UCS-4LE','UTF-8',pack('V', hexdec('U$1')))",json_decode($response))));

		 	  
        $array =json_decode($response,true); # آرایه
	    $object=json_decode($response);      # آبجکت
        
		print_r($array);
		//اطلاعات دریافتی
        $warehouse_id=$object->warehouse_id;  
        $user_first_name=$object->user_first_name;  
        $user_last_name=$object->user_last_name;  
        $company_name=$object->company_name;
        $province=$object->province;  
        $township=$object->township;  
        $city=$object->city;  
        $full_address=$object->full_address;  
        $error_code=$object->error_code;  
        $error_message=$object->error_message; 
  
        echo "<script>alert('error_message : $error_message')</script>"; 
        echo "<script>alert('شماره یکتا انبار $warehouse_id')</script>"; 
        $update_anbar=("UPDATE list_sardkhane SET warehouse_id='$warehouse_id',user_first_name='$user_first_name',user_last_name='$user_last_name',company_name='$company_name',register_province='$province',register_township='$township',city='$city',register_full_address='$full_address',register_error_code='$error_code',register_error_message='$error_message' WHERE id=$id");
        $update_res=mysql_query($update_anbar); 
		  
}
/********************WEB SERVICE NEW EBTAL***********************/
echo'
</form>
</body>
</html>';	
?>