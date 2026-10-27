<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="transfer_havale_webservice_ebtal_v2.php";
echo'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" />
<html xmlns="http://www.w3.org/1999/xhtml" dir=rtl>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>انتقال حواله های ابطالی</title>
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
	<tr><td colspan="4" class="title">انتقال حواله های ابطالی</td></tr>
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
 $q_havale="SELECT * From havale h INNER JOIN list_sardkhane l_s ON h.code_ostan=l_s.code_ostan AND h.code_anbar=l_s.code_anbar
	          WHERE h.tarikh_havale_anbar<='1397/09/30' AND sabt_nahayi=1 and year=$mtActiveYear AND status=1 AND h.code_anbar!=301 AND situation_type=1 AND l_s.activate=1 AND chkwebservice=1 AND warehouse_id IS NOT NULL AND(webservice_status='Insert' OR webservice_status='Update') ";
 
 $res_havale = mysql_query($q_havale);
 while($row_havale=$db->fetch_assoc($res_havale))
 {
  $warehouse_id=$db->get_from_where("warehouse_id","list_sardkhane","code_ostan=".$row_havale['code_ostan']." AND code_anbar=".$row_havale['code_anbar']."");     
  if(strlen($row_havale['code_ostan'])==1) $code_a=make_pattern($row_havale['code_ostan'],2);
  else $code_a=$row_havale['code_ostan'];
  $shomareGhabz=$mtActiveYear.$code_a.$row_havale['code_anbar'].$row_havale['shomare_havale_anbar'];

  $wsdl_url='http://10.7.234.33/anbar/warehouse.asmx?wsdl';
  header('Content-Type: text/html; charset=utf-8');
    try
	{
	   $client=new SoapClient($wsdl_url);
	   $params=array(
          'username'=>'02',
          'password'=>'HJ78mnGD',
          'type'=>'out',
          'company_nationalID'=>'14002771736',
          'warehouse_id'=>$warehouse_id,
          'number'=>$shomareGhabz  
	    );
	    $result=$client->RevokeWarehouseDocument($params); 
	    $response=$result->RevokeWarehouseDocumentResult;
	    $webservice_error_code =$response->ErrorCode;
	    $webservice_error_message =$response->ErrorMessage;
	    $webservice_status =$response->status;
	    $webservice_number =$response->number;
	}
	catch(Exception $e)
	{
	  	 echo "<script>alert('وب سرویس فعال نمی باشد')</script>";
	  	 echo  $e->getMessage();
	}
	$update_track=("UPDATE havale SET webservice_error_code='$webservice_error_code',webservice_error_message='$webservice_error_message',webservice_status='$webservice_status',webservice_number='$webservice_number' WHERE code_ostan=".$row_havale['code_ostan']." AND code_anbar=".$row_havale['code_anbar']." AND shomare_havale_anbar='".$row_havale['shomare_havale_anbar']."' AND year=$mtActiveYear");
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