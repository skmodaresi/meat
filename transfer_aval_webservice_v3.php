<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="transfer_aval_webservice_v3.php";
$titr='سرویس اظهار ورود کالا موجودی اول دوره';
echo'
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>'.$titr.' </title>
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
	<tr><td colspan="4" class="title">'.$titr.'</td></tr>
    <!--<tr><td colspan="4" class="tr1">تاریخ : <input class="datepicker6"  type="text" name="tarikh_havale_anbar"/></td></tr>-->
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

  $q22="SELECT lpad(h.code_ostan,2,0)as code_ostan,h.code_anbar,shomare_havale_anbar,tarikh_havale_anbar,
             h.code_kala,h.vazn_khales_h,postal_code,
             customer_national_tax,customer_gl_code,dm_customer_asli.name_customer,dm_customer_det.customer_tel,dm_customer_det.code_postal_costumer,
             shomare_barname_h,tarikh_barname_h,code_kala,tedad_karton_h,vazn_nakhales_h,vazn_khales_h,h_code
             From meat.havale AS h
             INNER JOIN meat.list_sardkhane l_s ON h.code_ostan=l_s.code_ostan AND h.code_anbar=l_s.code_anbar
             INNER JOIN sell.dm_customer_asli ON h.code_customer=dm_customer_asli.code_customer
             LEFT OUTER JOIN sell.dm_customer_det ON dm_customer_asli.code_customer=dm_customer_det.code_customer
             WHERE h.tarikh_havale_anbar<='$tarikh_havale_anbar' AND year=$mtActiveYear AND h.sabt_nahayi=1 AND h.status=0 AND h.deleted=0 AND h.code_anbar!=301 AND l_s.situation_type=1 AND l_s.activate=1 AND chkwebservice=1 AND
             (noe_tahvil_bar=1 OR noe_tahvil_bar=2 OR noe_tahvil_bar=3) AND (code_kala=75 OR code_kala=76 OR code_kala=77)
			 AND h.code_ostan=1 and h.code_anbar=102 and h.shomare_havale_anbar='00001'";
  
  $q="SELECT m.code_ostan,lpad(m.code_ostan,2,0)as codeOstan,m.code_anbar,m.code_kala,SUM(tedad_karton_aval) AS TedadAval,ROUND(SUM(mojody_nakhales_aval),3) AS MojodyNakhalesAval,
      ROUND(SUM(mojody_khales_aval),3) AS MojodyKhalesAval,postal_code  
	  FROM mojody_kala m INNER JOIN list_sardkhane l_a ON m.code_ostan=l_a.code_ostan AND m.code_anbar=l_a.code_anbar
	  WHERE m.code_ostan=18 and m.code_anbar=101 AND  (code_kala=75 ) AND year=$mtActiveYear AND deleted=0 AND m.code_anbar!=301 AND situation_type=1 AND l_a.activate=1 AND chkwebservice=1 AND warehouse_id IS NOT NULL AND register_error_code=0 AND(webservice_error_code IS NULL or webservice_error_code!='0') 
	  group by m.code_ostan,m.code_anbar,code_kala having (TedadAval>0 OR MojodyNakhalesAval>0 AND MojodyKhalesAval>0) 
	  order by m.code_ostan,m.code_anbar,code_kala";


  echo $q;	          
  $res = mysql_query($q);
  while($row=$db->fetch_assoc($res))
  {
	//if(strlen($row['code_ostan'])==1) $code_a=make_pattern($row['code_ostan'],2);
    //else $code_a=$row['code_ostan'];
    //$shomareGhabz=$mtActiveYear.$row['codeOstan'].$row['code_anbar'].$row['shomare_havale_anbar'];
    $shomareGhabz=$mtActiveYear.$row['codeOstan'].$row['code_anbar'];
	if($row['code_kala']==75)$code=2002569721932;
	else if($row['code_kala']==76)$code=2004464168139;
	else if($row['code_kala']==78)$code=2002135692949;

    $tarikh_MI='2020-03-20';

	$wsdl_url='https://pub-cix.ntsw.ir/services/InternalTradeServices?wsdl';
    $listitemsinfo=array();
	header('Content-Type: text/html; charset=utf-8');
    try
	{
	   $client = new SoapClient($wsdl_url, array('login'=> "internalservice",'password'=>"ESBesb12?"));
	   $client->__setLocation($wsdl_url);
	   $userRoleExtraFields=array(
	   	 'ActivityType'=>null,
		 'LicenseNumber'=>null,
		 'PostalCode'=>null
	   );
	   $importsDeclareInfo=array(
	       'PrfOrderNumber'=>null,
	       'PreCotagId'=>null,
	       'CotageCode'=>null
	   );
	   $SellerInfo=array(
	       'nationalCode_Identity'=>null,
	       'sellerName'=>null,
	       'mobileNumber'=>null
	   );
	   $ReturnOfSell=array(
	       'SellTRDID'=>null
	   );
		  
	   $ProductInfo=array(
	       'stuffCode'=>$code,
	       'stuffCount'=>$row['MojodyKhalesAval']
	   );   
	   array_push($listitemsinfo,$ProductInfo); 
	   
	   $params=array(
          'username'=>"Iranslal_user",
          'srvPass'=>"KcQh#diO@74JdSsd5D6%23pY5%nl#hR9P^78t!a4UE",
          'password_otpCode'=>'',
		  'PersonNationalCode'=>'14002771736',
          'UserRoleIDstr'=>'',
		  'userRoleExtraFields'=>$userRoleExtraFields,
		  'userSellType'=>11,
          'documentDate'=>$tarikh_MI,
		  'documentDescription'=>NULL,
		  'warehousePostalCode'=>$row['postal_code'],
		  'stuffs_In'=>$listitemsinfo,
		  'importsDeclareInfo'=>$importsDeclareInfo,
		  'seller'=>$SellerInfo,
		  'returnOfSell_Info'=>$ReturnOfSell,
          'statusAppointment'=>1,
          'DocNumber'=>$shomareGhabz
		); 
		
	  echo '<pre>'; print_r($params); echo '</pre>';
	   
	  $result=$client->StockProductDeclare_SI($params); 
	  $response=$result->StockProductDeclare_SIResult;
	  
	  $webservice_ResultCode =$response->ResultCode;
	  $webservice_ResultMessage =$response->ResultMessage;
	  $webservice_RolesList =$response->StockProductDeclare->RolesList;
	  $webservice_SellID =$response->StockProductDeclare->SellID;
	  $webservice_SellStatusId =$response->StockProductDeclare->SellStatusId;
	  
	  echo '<br>';
	  echo 'ResultCode: ';print_r($webservice_ResultCode);echo'<br>';
      echo 'ResultMessage: ';print_r($webservice_ResultMessage);echo'<br>';
      echo 'RolesList: ';print_r($webservice_RolesList);echo'<br>';
      echo 'SellID: ';print_r($webservice_SellID);echo'<br>';
      echo 'SellStatusId: ';print_r($webservice_SellStatusId);echo'<br>';

print_r($result);echo'<br>';
//print_r($result->$Obj);echo'<br>';
echo '<pre>';print_r($response);echo '</pre>';
	  //echo "<script>alert('کد پیگیری وب سرویس\\n$response')</script>"; 
	}
	// catch(SoapFault $client)
	catch(Exception $e)
	{
		 echo "<script>alert('وب سرویس فعال نمی باشد')</script>";
		 echo  $e->getMessage();
	}
	   
	//$update_track=("UPDATE mojody_kala SET webservice_resultcode='$webservice_ResultCode',webservice_resultmessage='$webservice_ResultMessage' WHERE code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']." AND code_kala='".$row['code_kala']."' AND year=$mtActiveYear");
	//$update_res=mysql_query($update_track);    
  }
  // if($update_res)
  // {
   	 // mysql_query("COMMIT");
     // echo "<script>alert('success')</script>"; 
     // echo "<script>window.location='$FileName'</script>";
  // }
  // else  
  // {
       // mysql_query('ROLLBACK');
       // echo "<script>alert('error!')</script>";  
  // }
  mysql_query('SET AUTOCOMMIT=1'); 	  
}
////////////////////////////////////////////////////////////////////////////////////////////////
echo'
</form>
</body>
</html>';	
?>