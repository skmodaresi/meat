<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
//error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="register.php";
echo'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" />
<html xmlns="http://www.w3.org/1999/xhtml" dir=rtl>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>register_anbar</title>
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
	<tr><td colspan="4" class="title">register_anbar</td></tr>
	<tr class="tr1"><td colspan="4" height="60px"><input class="buttonme" type="submit" name="transfer" value="check"></td></tr> 
	<tr class="footer"><td colspan="4">&nbsp;</td></tr>
   </table>
   </div>
  </td>
 </tr>	
</table>
</div>';
 $id_=2;
  $national_id=$db->get_from_where("nationalId","list_sardkhane_owner","id_anbar=$id_");     
  $mobile=$db->get_from_where("mobile","list_sardkhane_owner","id_anbar=$id_");     
  $name_anbar=$db->get_from_where("name_anbar","list_sardkhane","id=$id_");     
  $postal_code=$db->get_from_where("postal_code","list_sardkhane","id=$id_");     
  echo $national_id.'<br>';
  echo $mobile.'<br>';
  echo $name_anbar.'<br>';
  echo $postal_code.'<br>';
  
if(isset($transfer))
{
 $wsdl_url='http://10.7.234.33/anbar/warehouse.asmx?wsdl';
 header('Content-Type: text/html; charset=utf-8');
 $client=new SoapClient($wsdl_url);
 $id_=2;
  $national_id=$db->get_from_where("nationalId","list_sardkhane_owner","id_anbar=$id_");     
  $mobile=$db->get_from_where("mobile","list_sardkhane_owner","id_anbar=$id_");     
  $name_anbar=$db->get_from_where("name_anbar","list_sardkhane","id=$id_");     
  $postal_code=$db->get_from_where("postal_code","list_sardkhane","id=$id_");     
  echo $national_id.'<br>';
  echo $mobile.'<br>';
  echo $name_anbar.'<br>';
  echo $postal_code.'<br>';
  
  $params=array(
         'username'=>'02',
         'password'=>'HJ78mnGD',
		 'national_id'=>$national_id,
		 'mobile'=>$mobile,
		 'warehouseName'=>$name_anbar,
		 'warehouse_postalCode'=>$postal_code,
		 'company_nationalID'=>'14002771736'
         );
 
  $result=$client->RegisterWareHouse($params);
  $response=$result->RegisterWareHouseResult;
  //اطلاعات دریافتی
  $warehouse_id=$response->warehouse_id;  
  $user_first_name=$response->user_first_name;  
  $user_last_name=$response->user_last_name;  
  $company_name=$response->company_name;  
  $city=$response->city;  
  $full_address=$response->full_address;  
  $ErrorCode=$response->ErrorCode;  
 //print_r($result);echo'<br>';
 print_r($response);echo'<br>';
 //print_r($response->ExtensionData);echo'<br>';
 echo 'province: ';print_r($response->province);echo'<br>';
 echo 'city: ';print_r($response->city);echo'<br>';
 echo 'full_address: ';print_r($response->full_address);echo'<br>';
 echo 'user_nationalid: ';print_r($response->user_nationalid);echo'<br>';
 echo 'company_name: ';print_r($response->company_name);echo'<br>';
 echo 'postalcode: ';print_r($response->postalcode);echo'<br>';
 echo 'user_first_name: ';print_r($response->user_first_name);echo'<br>';
 echo 'user_last_name: ';print_r($response->user_last_name);echo'<br>';
 echo 'warehouse_id: ';print_r($response->warehouse_id);echo'<br>';
 echo 'ErrorCode: ';print_r($response->ErrorCode);echo'<br>';
 echo 'ErrorMessage: ';print_r($response->ErrorMessage);echo'<br>';
 
 $update_anbar=("UPDATE list_sardkhane SET warehouse_id='$warehouse_id',user_first_name='$user_first_name',user_last_name='$user_last_name',company_name='$company_name',city='$city',full_address='$full_address',register_error_code='$ErrorCode' WHERE id=$id_");
 $update_res=mysql_query($update_anbar); 
}