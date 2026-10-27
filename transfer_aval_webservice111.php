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
/********************WEB SERVICE NEW***********************/
if(isset($transfer))
{
    mysql_query('SET AUTOCOMMIT=0');//TRANSACTIONشروع 
    mysql_query('START TRANSACTION');
	$q87878="SELECT lpad((concat(mojody_kala.code_ostan,mojody_kala.code_anbar)),5,0) AS shenase_anbar,mojody_kala.code_ostan,mojody_kala.code_anbar,mojody_kala.code_kala,good_id,warehouse_id,code_vahedkala,SUM(tedad_karton_aval) AS TedadAval,ROUND(SUM(mojody_nakhales_aval),3) AS MojodyNakhalesAval,ROUND(SUM(mojody_khales_aval),3) AS MojodyKhalesAval 
	    FROM mojody_kala INNER JOIN list_sardkhane l_s ON mojody_kala.code_ostan=l_s.code_ostan AND mojody_kala.code_anbar=l_s.code_anbar INNER JOIN kala ON mojody_kala.code_kala=kala.code_kala WHERE mojody_kala.code_ostan=18  and year=$mtActiveYear AND deleted=0 AND mojody_kala.code_anbar!=301 AND chkwebservice=1 AND situation_type=1 AND l_s.activate=1 AND warehouse_id IS NOT NULL AND register_error_code=0 group by mojody_kala.code_ostan,mojody_kala.code_anbar,mojody_kala.code_kala order by mojody_kala.code_ostan,mojody_kala.code_anbar,mojody_kala.code_kala";
	
	$q="SELECT lpad((concat(mojody_kala.code_ostan,mojody_kala.code_anbar)),5,0) AS shenase_anbar,mojody_kala.code_ostan,mojody_kala.code_anbar,mojody_kala.code_kala,good_id,warehouse_id,code_vahedkala,SUM(tedad_karton_aval) AS TedadAval,ROUND(SUM(mojody_nakhales_aval),3) AS MojodyNakhalesAval,ROUND(SUM(mojody_khales_aval),3) AS MojodyKhalesAval 
	    FROM mojody_kala INNER JOIN list_sardkhane l_s ON mojody_kala.code_ostan=l_s.code_ostan AND mojody_kala.code_anbar=l_s.code_anbar INNER JOIN kala ON mojody_kala.code_kala=kala.code_kala WHERE year=$mtActiveYear AND deleted=0 AND mojody_kala.code_anbar!=301 AND chkwebservice=1 AND situation_type=1 AND l_s.activate=1 AND warehouse_id IS NOT NULL AND register_error_code=0 group by mojody_kala.code_ostan,mojody_kala.code_anbar,mojody_kala.code_kala order by mojody_kala.code_ostan,mojody_kala.code_anbar,mojody_kala.code_kala";


	$res = mysql_query($q);
	while($row=$db->fetch_assoc($res))
    {
	   $shenaseAnbar=$row['shenase_anbar'];
	   // if(($row['good_id']==null)OR($row['good_id']=='')OR($row['good_id']=='0')) $goodId=$row['code_kala'];
	   // else $goodId=$row['good_id'];
	   
	   $goodId=$row['code_kala'];
	   IF($row['code_vahedkala']==1)//کیلوگرم
	   {
	      $amount=$row['MojodyKhalesAval'];
	   }
       ELSE IF($row['code_vahedkala']==2)//تعداد
	   {
		  $amount=$row['TedadAval'];   
	   } 
	   $wsdl_url='http://10.7.234.33/anbar/warehouse.asmx?wsdl';
	   header('Content-Type: text/html; charset=utf-8');
       try
	   {
	     $client=new SoapClient($wsdl_url);
	     $params=array(
         'username'=>'02',
         'password'=>'HJ78mnGD',
         'co_national_id'=>'14002771736',
         'year'=>$mtActiveYear,
         'gov_warehouse_numer'=>$shenaseAnbar,
		 'good_id'=>$goodId,
         'amount'=>$amount
         );
		 //echo 'webservice_error_code: ';print_r($params);echo'<br>';

         if(isset($transfer))
         {
		  $result=$client->SetFirstAmountinYear($params);
		  $response=$result->SetFirstAmountinYearResult;
		  $webservice_error_code =$response->error_code;
	      $webservice_error_message =$response->error_message;
	      $webservice_warehouse_id =$response->warehouse_id;
	      $webservice_gov_warehouse_number =$response->gov_warehouse_number;
	      $webservice_good_ID =$response->good_ID;
	      $webservice_Receipt_Amount =$response->Receipt_Amount;
	      $webservice_Havale_Amount =$response->Havale_Amount;
	      $webservice_SamtReceipt_Amount =$response->SamtReceipt_Amount;
	      $webservice_SamtHavale_Amount =$response->SamtHavale_Amount;
	      $webservice_FirstAmount =$response->FirstAmount;
	      $webservice_year =$response->year;
		  }
	     echo 'webservice_error_code: ';print_r($webservice_error_code);echo'<br>';
	     //echo 'webservice_error_message: ';print_r($webservice_error_message);echo'<br>';
	     // echo 'webservice_warehouse_id: ';print_r($webservice_warehouse_id);echo'<br>';
	     // echo 'webservice_gov_warehouse_number: ';print_r($webservice_gov_warehouse_number);echo'<br>';
	     // echo 'webservice_good_ID: ';print_r($webservice_good_ID);echo'<br>';
	     // echo 'webservice_Receipt_Amount: ';print_r($webservice_Receipt_Amount);echo'<br>';
	     // echo 'webservice_Havale_Amount: ';print_r($webservice_Havale_Amount);echo'<br>';
	     // echo 'webservice_SamtReceipt_Amount: ';print_r($webservice_SamtReceipt_Amount);echo'<br>';
	     // echo 'webservice_SamtHavale_Amount: ';print_r($webservice_SamtHavale_Amount);echo'<br>';
	     // echo 'webservice_year: ';print_r($webservice_year);echo'<br>';
	   }
	   catch(SoapFault $client)
	   {
		 echo "<script>alert('وب سرویس فعال نمی باشد')</script>";
	   }
	   $update_track=("UPDATE mojody_kala SET webservice_error_code='$webservice_error_code',webservice_error_message='$webservice_error_message',amount='$amount' WHERE code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']." AND code_kala='".$row['code_kala']."' AND year=$mtActiveYear");
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
//////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////////
echo'
</form>
</body>
</html>';	
?>