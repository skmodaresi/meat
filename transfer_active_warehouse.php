<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="transfer_active_warehouse.php";
$titr='فعال کردن انبار';
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
	<tr><td colspan="4" class="title">'.$titr.'</td></tr>
    <!--<tr><td colspan="4" class="tr1">شناسه انبار : <input  type="text" name="id"/></td></tr>-->
    <tr><td colspan="4" class="tr1">شناسه صمت : <input  type="text" name="warehouse_id"/></td></tr>
	<tr class="tr1"><td colspan="4" height="60px"><input class="buttonme" type="submit" name="transfer" value="ویرایش"></td></tr> 
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
    
	// $q2="SELECT * FROM list_anbar WHERE warehouse_id='$warehouse_id'";
    // $res2= mysql_query($q2);
    // $row2=$db->fetch_assoc($res2);
    $contractor_expire_epoch='1407/12/29';

	$params=array(
	      'warehouse_id'=>$warehouse_id,
		  'account_status'=>'1',
		  'zone_type'=>'1',
		  'zone_economic_type'=>'1',
	      'contractor_expire_epoch'=>$contractor_expire_epoch	  
		  
	   );
	    //چاپ آرایه
	    //if(SuperUser())echo '<pre>'; print_r($params); echo '</pre>';	   
        $result=preg_replace("/\\\\u([a-f0-9]{4})/e", "iconv('UCS-4LE','UTF-8',pack('V', hexdec('U$1')))", json_encode($params));
	    $encodedData = json_encode($params);
	    //چاپ جیسون
	    echo "<br>\r\n";		  
		echo '<pre>'; echo($encodedData); echo '</pre>';
	    
		$curl = curl_init();
	    curl_setopt_array($curl, array(
          CURLOPT_URL => 'http://10.7.234.33/warehouse/api/warehouse/EditWarehouseByID',
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

		 	  
        $arr =json_decode($response,true); # آرایه
	    $object=json_decode($response);      # آبجکت
        
		var_dump($arr);
		// //اطلاعات دریافتی
        // $warehouse_id=$object->warehouse_id;  
        // $user_first_name=$object->user_first_name;  
        // $user_last_name=$object->user_last_name;  
        // $company_name=$object->company_name;
        // $province=$object->province;  
        // $township=$object->township;  
        // $city=$object->city;  
        // $full_address=$object->full_address;  
        // $error_code=$object->error_code;  
        // $error_message=$object->error_message; 
  
        // echo "<script>alert('error_message : $error_message')</script>"; 
        // echo "<script>alert('شماره یکتا انبار $warehouse_id')</script>"; 
        // $update_anbar=("UPDATE list_anbar SET warehouse_id='$warehouse_id',user_first_name='$user_first_name',user_last_name='$user_last_name',company_name='$company_name',register_province='$province',register_township='$township',city='$city',register_full_address='$full_address',register_error_code='$error_code',register_error_message='$error_message' WHERE id=$id");
        // $update_res=mysql_query($update_anbar); 
		  
}
/********************WEB SERVICE NEW EBTAL***********************/
echo'
</form>
</body>
</html>';	
?>