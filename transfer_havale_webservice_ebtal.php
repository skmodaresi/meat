<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="transfer_havale_webservice_ebtal.php";
echo'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" />
<html xmlns="http://www.w3.org/1999/xhtml" dir=rtl>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>transfer_havale_webservice_ebtal</title>
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
	<tr><td colspan="4" class="title">transfer havale ebtal</td></tr>

    <tr class="tr1"><td colspan="4" height="40px"><input class="buttonme" type="submit" name="transfer" value="transfer havale ebtal"></td></tr> 
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
	$q_havale="SELECT * From mt.havale h WHERE year=$bzActiveYear AND shomare_havale_anbar='00001' AND webservice_trackcode>0 AND  (webservice_sendebtal=0 or webservice_sendebtal is null)";
	$res_havale = mysql_query($q_havale);
	while($row_havale=$db->fetch_assoc($res_havale))
    {	   
	   $shenaseSazman="02";
       if(strlen($row_havale['code_ostan'])==1) $code_a=make_pattern($row_havale['code_ostan'],2);
       else $code_a=$row_havale['code_ostan'];
	   $shenaseAnbar=$code_a.$row_havale['code_anbar'];
	   // $webservice_trackcode=$db->get_from_where("webservice_trackcode","havale","id=$id_");
	   // $c_ostan=substr($webservice_trackcode,4,2);
	   // $c_anbar=substr($webservice_trackcode,6,3);
	   // if(($c_ostan==$code_a)AND($c_anbar==$bz_gl_code_anbar))$shomareBijak=$code_a.$bz_gl_code_anbar.$shomare_havale_anbar_;
	   // else $shomareBijak='0'.$bzActiveYear.$shomare_havale_anbar_;
       
	   $shomareBijak='0'.$bzActiveYear.$row_havale['shomare_havale_anbar'];
	   $wsdl_url='http://10.7.234.33/warehouse/warehouse.asmx?wsdl';
	   header('Content-Type: text/html; charset=utf-8');	   
	   try
	   {
	    $client=new SoapClient($wsdl_url);
	    // $sql_tarikh=$row_havale['revokeDate'];
        // $d=substr($sql_tarikh,8,2);
        // $m=substr($sql_tarikh,5,2);
        // $y=substr($sql_tarikh,0,4);
        // $milady=jalali_to_gregorian($y,$m,$d);
        // $sal=$milady[0];
        // $mah=$milady[1];
        // $rouz=$milady[2];
        // $revokeDate=$sal.'-'.$mah.'-'.$rouz;
	    // $revokeTime=$row_havale['revokeTime'];
		$revokeDate=date("Y-m-d");//میلادی
	    $revokeTime = date('H:i');
		$params=array(
        'OrganNo_'=>$shenaseSazman,
        'WareHouseNo'=>$shenaseAnbar,
        'BijakNo'=>$shomareBijak,
        'RevokeDate'=>$revokeDate,
        'RevokeTime'=>$revokeTime,
	    'Username'=>'warehouseuser',
        'Password'=>'AqWsXz@8246'
        );
        $result=$client->RevokBijak($params);
	    $response=$result->RevokBijakResult;  
	   	    echo "<script>alert('کد پیگیری وب سرویس\\n$response')</script>"; 

	   }
	   catch(SoapFault $client)
	   {
		 	    echo "<script>alert('کد پیگیری وب سرویس\\n$response')</script>"; 

		 $response=0;
         echo "<script>alert('وب سرویس فعال نمی باشد')</script>";
	   } 
	   $update_sendebtal=("UPDATE mt.havale SET webservice_sendebtal='$response' WHERE code_ostan=".$row_havale['code_ostan']." AND code_anbar=".$row_havale['code_anbar']." AND shomare_havale_anbar='".$row_havale['shomare_havale_anbar']."' AND year=$bzActiveYear");
	   $insert_res=mysql_query($update_sendebtal);
    }
	print_r($params);
    if($insert_res)
    {
   	   mysql_query("COMMIT");
       echo "<script>alert('success')</script>"; 
       //echo "<script>window.location='transfer_havale_webservice_ebtal.php'</script>";
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