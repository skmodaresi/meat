<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="transfer_aval_webservice.php";
echo'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" />
<html xmlns="http://www.w3.org/1999/xhtml" dir=rtl>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>انتقال موجودی اول دوره</title>
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
	<tr><td colspan="4" class="title">انتقال موجودی اول دوره</td></tr>
    <tr class="tr1"><td colspan="4" height="60px"><input class="buttonme" type="submit" name="transfer" value="transfer mojody aval"></td></tr> 
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
	$q54545="SELECT lpad((concat(code_ostan,code_anbar)),5,0) AS shenase_anbar,lpad(code_ostan,2,0)as code_ostan,code_anbar,code_kala,SUM(tedad_karton_aval) AS TedadAval,ROUND(SUM(mojody_nakhales_aval),3) AS MojodyNakhalesAval,ROUND(SUM(mojody_khales_aval),3) AS MojodyKhalesAval 
	    FROM mojody_kala WHERE year=$mtActiveYear AND deleted=0 AND code_anbar!=301 group by code_ostan,code_anbar,code_kala  having (TedadAval>0 OR MojodyNakhalesAval>0 AND MojodyKhalesAval>0) order by code_ostan,code_anbar,code_kala";

	$q="SELECT lpad((concat(code_ostan,code_anbar)),5,0) AS shenase_anbar,lpad(code_ostan,2,0)as code_ostan,code_anbar,code_kala,SUM(tedad_karton_aval) AS TedadAval,ROUND(SUM(mojody_nakhales_aval),3) AS MojodyNakhalesAval,ROUND(SUM(mojody_khales_aval),3) AS MojodyKhalesAval 
	    FROM mojody_kala WHERE year=$mtActiveYear AND deleted=0 AND code_anbar!=301 group by code_ostan,code_anbar,code_kala  order by code_ostan,code_anbar,code_kala";


	$res = mysql_query($q);
	while($row=$db->fetch_assoc($res))
    {
       $shenaseSazman="02";
	   $shenaseAnbar=$row['shenase_anbar'];
	   $nameKala=$db->get_from_where("name_kala","kala","code_kala=".$row['code_kala']."");     
	   IF(($row['code_kala']==113)OR($row['code_kala']==173)OR($row['code_kala']==174)OR($row['code_kala']==55))$Value=$row['TedadAval'];
	   ELSE $Value=$row['MojodyKhalesAval'];
	   $wsdl_url='http://10.7.234.33/warehouse/warehouse.asmx?wsdl';
	   header('Content-Type: text/html; charset=utf-8');
       try
	   {
	   $client=new SoapClient($wsdl_url);
	   $params=array(
         'OrganNo_'=>$shenaseSazman,
         'Year'=>$mtActiveYear,
         'WareHouseNo'=>$shenaseAnbar,
         'ProductCode'=>$row['code_kala'],
         'Value'=>$Value,
		 'Username'=>'warehouseuser',
         'Password'=>'AqWsXz@8246'
         );
        if(isset($transfer))
        {
		 $result=$client->SendInitialInventory($params);
		 $response=$result->SendInitialInventoryResult;
		}
		echo '<pre>';print_r($response);echo '</pre>';
	   }
	   catch(SoapFault $client)
	   {
	     $response=-1;
		 echo "<script>alert('وب سرویس فعال نمی باشد')</script>";
	   }
	   $update_track=("UPDATE mojody_kala SET webservice_trackcode='$response' WHERE code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']." AND code_kala='".$row['code_kala']."' AND year=$mtActiveYear");
	   $insert_res=mysql_query($update_track);
    }
    if($insert_res)
    {
   	   mysql_query("COMMIT");
       echo "<script>alert('success')</script>"; 
       //echo "<script>window.location='transfer_aval_webservice.php'</script>";
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