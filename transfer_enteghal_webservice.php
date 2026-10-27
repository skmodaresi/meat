<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="transfer_enteghal_webservice.php";
$titr='سرویس اظهار انتقال مالکیت و مکان';
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
    <tr height="40px"><td colspan="4" class="tr1" > انتقال اطلاعات کد کالا : 75 و 76 و 78 و 410 و 411 و 91 و 154</td></tr>
    <tr height="40px"><td colspan="4" class="tr1">تاریخ حواله : <input class="datepicker6"  type="text" name="tarikh_havale_anbar"/></td></tr>
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
	          // WHERE h.code_ostan=1 and h.code_anbar=102 and h.shomare_havale_anbar='00754' and h.tarikh_havale_anbar>='1397/07/01' AND sabt_nahayi=1 and year=$mtActiveYear AND status=0 AND h.code_anbar!=301 AND situation_type=1 AND l_s.activate=1 AND chkwebservice=1 AND warehouse_id IS NOT NULL AND(webservice_error_code IS NULL or webservice_error_code!='0') ";
  
  $q_havale="SELECT h.code_ostan,lpad(h.code_ostan,2,0)as codeOstan,h.code_anbar,shomare_havale_anbar,tarikh_havale_anbar,
             h.code_kala,h.vazn_khales_h,postal_code,
             customer_national_tax,customer_gl_code,dm_customer_asli.name_customer,dm_customer_det.customer_tel,dm_customer_det.code_postal_costumer,
             shomare_barname_h,tarikh_barname_h,code_kala,tedad_karton_h,vazn_nakhales_h,vazn_khales_h,h.h_code,h_p_priceh
             From meat.havale AS h
             INNER JOIN meat.list_sardkhane l_s ON h.code_ostan=l_s.code_ostan AND h.code_anbar=l_s.code_anbar
             INNER JOIN sell.dm_customer_asli ON h.code_customer=dm_customer_asli.code_customer
             INNER JOIN sell.dm_customer_det ON dm_customer_asli.code_customer=dm_customer_det.code_customer AND dm_customer_det.customer_code_org=h.code_ostan
             INNER JOIN sell.dm_havale ON h.h_id=dm_havale.h_id
			 WHERE h.tarikh_havale_anbar='$tarikh_havale_anbar' AND year=$mtActiveYear AND h.sabt_nahayi=1 AND h.status=0 AND h.deleted=0 AND h.code_anbar!=301 AND l_s.situation_type=1 AND l_s.activate=1  AND
             (noe_tahvil_bar=1 OR noe_tahvil_bar=2 OR noe_tahvil_bar=3) AND (code_kala=75 OR code_kala=76 OR code_kala=78 OR code_kala=410 OR code_kala=411 OR code_kala=91 OR code_kala=154 ) AND (webservice_resultcode IS NULL OR webservice_resultcode!=0) 
			 ";
  
  // $q_havale="SELECT h.code_ostan,lpad(h.code_ostan,2,0)as codeOstan,h.code_anbar,shomare_havale_anbar,tarikh_havale_anbar,
             // h.code_kala,h.vazn_khales_h,postal_code,
             // customer_national_tax,customer_gl_code,dm_customer_asli.name_customer,
             // shomare_barname_h,tarikh_barname_h,code_kala,tedad_karton_h,vazn_nakhales_h,vazn_khales_h,h_code
             // From meat.havale AS h
             // INNER JOIN meat.list_sardkhane l_s ON h.code_ostan=l_s.code_ostan AND h.code_anbar=l_s.code_anbar
             // INNER JOIN sell.dm_customer_asli ON h.code_customer=dm_customer_asli.code_customer
             // WHERE h.tarikh_havale_anbar='$tarikh_havale_anbar' AND year=$mtActiveYear AND h.sabt_nahayi=1 AND h.status=0 AND h.deleted=0 AND h.code_anbar!=301 AND l_s.situation_type=1 AND l_s.activate=1 AND chkwebservice=1 AND
             // (noe_tahvil_bar=1 OR noe_tahvil_bar=2 OR noe_tahvil_bar=3) AND (code_kala=75 OR code_kala=76 OR code_kala=78) AND (webservice_resultcode IS NULL OR webservice_resultcode!=0) 
			 // AND h.code_ostan=1 and h.code_anbar=102";

  //echo $q_havale;	          
  $res_havale = mysql_query($q_havale);
  if(mysql_num_rows($res_havale)==0)
  {
	echo"<script>alert('حواله ارسال نشده یافت نشد')</script>";  
  }
  else
  {

    while($row_havale=$db->fetch_assoc($res_havale))
    {
	  $shomareGhabz=$mtActiveYear.$row_havale['codeOstan'].$row_havale['code_anbar'].$row_havale['shomare_havale_anbar'];
	  if($row_havale['code_kala']==75)$code=2002569721932;
	  else if($row_havale['code_kala']==76)$code=2004464168139;
	  else if($row_havale['code_kala']==78)$code=2002135692949;
      else if($row_havale['code_kala']==410)$code=2720000160198;
	  else if($row_havale['code_kala']==411)$code=2720000160198;
	  else if($row_havale['code_kala']==91)$code=2004816604278;
	  else if($row_havale['code_kala']==154)$code=2004816604278;
	  //تبدیل تاریخ شمسی به میلادی
	  $sql_tarikh=$row_havale['tarikh_havale_anbar'];
      $d=substr($sql_tarikh,8,2);$m=substr($sql_tarikh,5,2);$y=substr($sql_tarikh,0,4);
      $milady=jalali_to_gregorian($y,$m,$d);
      $sal=$milady[0];$mah=$milady[1];$rouz=$milady[2];
      $tarikh_havale_MI=$sal.'-'.$mah.'-'.$rouz;
      IF($row_havale['customer_national_tax']>0){$buyerNationalID=$row_havale['customer_national_tax'];$buyerNationalID=substr($buyerNationalID,0,11);}
	  ELSE $buyerNationalID=$row_havale['customer_gl_code'];
	  //IF($row_havale['shomare_barname_h']>0){$wayBillHas=1; $wayBillNumber=$row_havale['shomare_barname_h']; $wayBillDate=$row_havale['tarikh_barname_h'];}
	  //ELSE {$wayBillHas=2; $wayBillNumber=null; $wayBillDate=null;}
	  
	  $vazn_khales_h=round($row_havale['vazn_khales_h'],3);
	  //$Price=$vazn_khales_h*$row_havale['h_p_priceh'];//از 1402/02/10 قیمت رو هم ارسال کردیم
	  $Price=$row_havale['h_p_priceh'];//از 1402/03/07 فقط قیمت رو ارسال کردیم
      $mob=substr($row_havale['customer_tel'],0,2);	
	  IF(((strlen($row_havale['customer_tel']))==11)AND($mob=='09')) $buyerMobile=$row_havale['customer_tel'];
      ELSE $buyerMobile='09121111111';	
	  $wsdl_url='https://pub-cix.ntsw.ir/services/InternalTradeServices?wsdl';
      $listitemsinfo=array();
	  header('Content-Type: text/html; charset=utf-8');
      try
	  {
	     //$client=new SoapClient($wsdl_url);
	     $client = new SoapClient($wsdl_url, array('login'=> "internalservice",'password'=>"ESBesb12?"));
	     $client->__setLocation($wsdl_url);
	     // $seller_UserRoleExtraFields=array(
	     	 // 'PostalCode'=>$row_havale['postal_code'],
	     	 // 'LicenseNumber'=>'',
	     	 // 'ActivityType'=>10
	     // );
	     $seller_UserRoleExtraFields=array(
	     	 'PostalCode'=>null,
	     	 'LicenseNumber'=>null,
	     	 'ActivityType'=>null
	     );
	     // $buyer_UserRoleExtraFields=array(
	     	 // 'PostalCode'=>$row_havale['code_postal_costumer'],
	     	 // 'LicenseNumber'=>'',
	     	 // 'ActivityType'=>10
	     // );
	     $buyer_UserRoleExtraFields=array(
	     	 'PostalCode'=>null,
	     	 'LicenseNumber'=>null,
	     	 'ActivityType'=>null
	     );
	     $ownershipTransfer=array(
	     	 'buyerNationalID'=>$buyerNationalID,
	  	 'buyerUserRoleIDStr'=>NULL,
	  	 'buyerName'=>$row_havale['name_customer'],
	  	 'buyerMobile'=>$buyerMobile
	     );
	     $PlaceTransfer=array(
	     	 //'ToPostalCode'=>$row_havale['code_postal_costumer'],
	     	 'ToPostalCode'=>'2222222222',
	  	 'wayBillHas'=>2,
	  	 'wayBillNumber'=>null,
	  	 'wayBillSerial'=>null,
	  	 'wayBillDate'=>null
	     );
	     $Stuff_Code_Count_Pair=array(
	         'Code'=>$code,
	         'Count'=>$vazn_khales_h,
	         'Price'=>$Price
	         );
	     array_push($listitemsinfo,$Stuff_Code_Count_Pair); 
	     $params=array(
            'username'=>"Iranslal_user",
            'srvPass'=>"KcQh#diO@74JdSsd5D6%23pY5%nl#hR9P^78t!a4UE",
            'PersonNationalCode'=>'14002771736',
	  	  'password_otpCode'=>'',
            'UserRoleIDstr'=>27805,
	  	  'userSellType'=>3,
            'documentDate'=>$tarikh_havale_MI,
	  	  'fromPostalCode'=>'4444444444',
	  	  'ownershipTransfer'=>$ownershipTransfer,
	  	  'placeTransfer'=>$PlaceTransfer,
	  	  'seller_UserRoleExtraFields'=>$seller_UserRoleExtraFields,
            'buyer_UserRoleExtraFields'=>$buyer_UserRoleExtraFields,
            'stuffs_In'=>$listitemsinfo,
            'documentDescription'=>NULL,
            'statusAppointment'=>0,
            'DocNumber'=>$shomareGhabz
	  	); 
	  	
	    //echo '<pre>'; print_r($params); echo '</pre>';
	     
	    $result=$client->TransferOwnershipPlace_SI($params); 
	    $response=$result->TransferOwnershipPlace_SIResult;
	    
	    $webservice_ResultCode =$response->ResultCode;
	    $webservice_ResultMessage =$response->ResultMessage;
	    $webservice_SellID =$response->ObjList->TransferOwnershipPlace->SellID;
	    
	    //echo '<br>';
	    //echo 'ResultCode: ';print_r($response->ResultCode);echo'<br>';
        echo 'ResultMessage: ';print_r($response->ResultMessage);echo'<br>';
	    echo 'SellID: ';print_r($webservice_SellID);echo'<br>';
	    
        //echo '<pre>';print_r($response);echo '</pre>';
	  }
	  catch(Exception $e)
	  {
	  	 echo "<script>alert('وب سرویس فعال نمی باشد')</script>";
	  	 echo  $e->getMessage();
	  }
	     
	  $update_track=("UPDATE havale SET webservice_resultcode='$webservice_ResultCode',webservice_resultmessage='$webservice_ResultMessage',webservice_selid='$webservice_SellID' WHERE code_ostan=".$row_havale['code_ostan']." AND code_anbar=".$row_havale['code_anbar']." AND shomare_havale_anbar='".$row_havale['shomare_havale_anbar']."' AND year=$mtActiveYear");
	  $update_res=mysql_query($update_track);    
    }
    if($update_res)
    {
     	 mysql_query("COMMIT");
       echo "<script>alert('success')</script>"; 
       //echo "<script>window.location='$FileName'</script>";
    }
    else  
    {
         mysql_query('ROLLBACK');
         echo "<script>alert('error!')</script>";  
    }
    mysql_query('SET AUTOCOMMIT=1');
  }  
}
////////////////////////////////////////////////////////////////////////////////////////////////
echo'
</form>
</body>
</html>';	
?>