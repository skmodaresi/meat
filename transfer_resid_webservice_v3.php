<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="transfer_resid_webservice_v3.php";
$titr='سرویس اظهار ورود کالا رسیدهای سردخانه';
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
$q_check="SELECT distinct(tarikh_resid),r_k_d.code_kala,webservice_resultcode,webservice_resultmessage
          From resid T
	      INNER JOIN resid_detail AS r_d ON r_d.shomare_resid=T.shomare_resid AND r_d.code_ostan=T.code_ostan AND r_d.code_anbar=T.code_anbar AND r_d.year=T.year
	      INNER JOIN resid_kala_detail AS r_k_d ON r_d.shomare_resid=r_k_d.shomare_resid AND r_d.code_ostan=r_k_d.code_ostan AND r_d.code_anbar=r_k_d.code_anbar AND r_d.year=r_k_d.year AND r_d.code_kala=r_k_d.code_kala AND r_d.code_keshvar=r_k_d.code_keshvar AND r_d.code_tolidkonande=r_k_d.code_tolidkonande 
		  WHERE (noe_tahvil_bar=1 OR noe_tahvil_bar=2 OR noe_tahvil_bar=3) and (r_k_d.code_kala=75 or r_k_d.code_kala=76 or r_k_d.code_kala=78 or r_k_d.code_kala=410 or r_k_d.code_kala=411 or r_k_d.code_kala=91 or r_k_d.code_kala=154) AND T.year=$mtActiveYear AND T.deleted=0 AND T.status=0 AND T.sabt_nahayi=1  
          AND (webservice_resultcode IS NULL OR webservice_resultcode='' OR webservice_resultcode!=0)
          GROUP BY T.shomare_resid,T.code_ostan,T.code_anbar,T.year,r_k_d.code_kala
          ORDER BY r_k_d.code_kala,tarikh_resid asc ";
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
	<tr><td colspan="4" class="tr1">تاریخ : <input class="datepicker6"  type="text" name="tarikh_resid" /></td></tr>
	<tr><td colspan="4" class="tr1">کد کالا : <input   type="text" name="code_kala"/></td></tr>
	<tr class="tr1"><td colspan="4" height="60px"><input class="buttonme" type="submit" name="transfer" value="transfer resid"></td></tr> 
	
	<tr><td colspan="4" class="tr1">اطلاعات ثبت نشده:</td></tr>';
	$res_check = mysql_query($q_check);
    while($rowcheck=$db->fetch_assoc($res_check))
	{
	 echo'
     <tr>
	  <td colspan="4" class="tr1">';
		  echo'   تاریخ : '.$rowcheck['tarikh_resid'].' کالای '.$rowcheck['code_kala'].'';
		  IF($rowcheck['webservice_resultcode']=='614') echo'('.$rowcheck['webservice_resultmessage'].')';
	  echo'
	  </td>
	 </tr>';
	}
	echo'
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
  $q_check="SELECT T.* From resid T
	     INNER JOIN resid_detail AS r_d ON r_d.shomare_resid=T.shomare_resid AND r_d.code_ostan=T.code_ostan AND r_d.code_anbar=T.code_anbar AND r_d.year=T.year
	     INNER JOIN resid_kala_detail AS r_k_d ON r_d.shomare_resid=r_k_d.shomare_resid AND r_d.code_ostan=r_k_d.code_ostan AND r_d.code_anbar=r_k_d.code_anbar AND r_d.year=r_k_d.year AND r_d.code_kala=r_k_d.code_kala AND r_d.code_keshvar=r_k_d.code_keshvar AND r_d.code_tolidkonande=r_k_d.code_tolidkonande 
		 WHERE (noe_tahvil_bar=1 OR noe_tahvil_bar=2 OR noe_tahvil_bar=3) and (r_k_d.code_kala=75 or r_k_d.code_kala=76 or r_k_d.code_kala=78) AND T.year=$mtActiveYear AND T.deleted=0 AND T.status=0
		 AND (webservice_resultcode IS NULL  OR webservice_resultcode='' OR webservice_resultcode!=0)
		 GROUP BY T.shomare_resid,T.code_ostan,T.code_anbar,T.year ORDER BY tarikh_resid asc ";
	

  $q="SELECT lpad(r.code_ostan,2,0)as code_ostan,r.code_anbar,shomare_resid,tarikh_resid,
      r_k_d.code_kala,SUM(tedad_karton_r_d_sub) AS Tedad,ROUND(SUM(vazn_nakhales_r_d_sub),3) AS MojodyNakhales,
      ROUND(SUM(vazn_khales_r_d_sub),3) AS MojodyKhales
	  From meat.resid AS r
      INNER JOIN meat.list_sardkhane l_s ON r.code_ostan=l_s.code_ostan AND r.code_anbar=l_s.code_anbar
      INNER JOIN resid_kala_detail AS r_k_d ON r.shomare_resid=r_k_d.shomare_resid AND r.code_ostan=r_k_d.code_ostan AND r.code_anbar=r_k_d.code_anbar AND r.year=r_k_d.year
      WHERE r.tarikh_resid='$tarikh_resid' AND r.sabt_nahayi=1 AND r.status=0 AND r.deleted=0 AND r.code_anbar!=301 AND l_s.situation_type=1 AND l_s.activate=1 AND chkwebservice=1 AND
      (noe_tahvil_bar=1 OR noe_tahvil_bar=2 OR noe_tahvil_bar=3) AND (code_kala=75 OR code_kala=76 OR code_kala=77)
	  group by r_k_d.code_ostan,r_k_d.code_anbar,r_k_d.code_kala";
  
  $q="SELECT tarikh_resid,r_k_d.code_kala,SUM(tedad_karton_r_d_sub) AS Tedad,ROUND(SUM(vazn_nakhales_r_d_sub),3) AS MojodyNakhales,
      ROUND(SUM(vazn_khales_r_d_sub),3) AS MojodyKhales
	  From meat.resid AS r
      INNER JOIN meat.list_sardkhane l_s ON r.code_ostan=l_s.code_ostan AND r.code_anbar=l_s.code_anbar
      INNER JOIN resid_kala_detail AS r_k_d ON r.shomare_resid=r_k_d.shomare_resid AND r.code_ostan=r_k_d.code_ostan AND r.code_anbar=r_k_d.code_anbar AND r.year=r_k_d.year
      WHERE r.tarikh_resid='$tarikh_resid' AND r.year=$mtActiveYear AND r.sabt_nahayi=1 AND r.status=0 AND r.deleted=0 AND r.code_anbar!=301 AND l_s.situation_type=1 AND l_s.activate=1  AND
      (noe_tahvil_bar=1 OR noe_tahvil_bar=2 OR noe_tahvil_bar=3) AND r_k_d.code_kala=$code_kala AND (webservice_resultcode IS NULL OR webservice_resultcode='' OR webservice_resultcode!=0) 
	  group by r_k_d.code_kala";

  //echo $q;	          
  $res = mysql_query($q);
  while($row=$db->fetch_assoc($res))
  {
    
	$d1=substr($tarikh_resid,8,2);
    $m1=substr($tarikh_resid,5,2);
    $y1=substr($tarikh_resid,0,4);
    $DocNumber=$y1.$m1.$d1.$row['code_kala'];
	if($row['code_kala']==75)$code=2002569721932;
	else if($row['code_kala']==76)$code=2004464168139;
	else if($row['code_kala']==78)$code=2002135692949;
    else if($row['code_kala']==410)$code=2720000160198;
	else if($row['code_kala']==411)$code=2720000160198;
	else if($row['code_kala']==91)$code=2004816604278;
	else if($row['code_kala']==154)$code=2004816604278;
	//تبدیل تاریخ شمسی به میلادی
	$sql_tarikh=$tarikh_resid;
    $d=substr($sql_tarikh,8,2);$m=substr($sql_tarikh,5,2);$y=substr($sql_tarikh,0,4);
    $milady=jalali_to_gregorian($y,$m,$d);
    $sal=$milady[0];$mah=$milady[1];$rouz=$milady[2];
    $tarikh_resid_MI=$sal.'-'.$mah.'-'.$rouz;

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
	       'stuffCount'=>$row['MojodyKhales']
	   );   
	   array_push($listitemsinfo,$ProductInfo); 
	   
	   $params=array(
          'username'=>"Iranslal_user",
          'srvPass'=>"KcQh#diO@74JdSsd5D6%23pY5%nl#hR9P^78t!a4UE",
          'password_otpCode'=>'',
		  'PersonNationalCode'=>'14002771736',
          'UserRoleIDstr'=>27805,
		  'userRoleExtraFields'=>$userRoleExtraFields,
		  'userSellType'=>16,
          'documentDate'=>$tarikh_resid_MI,
		  'documentDescription'=>NULL,
		  'warehousePostalCode'=>'2222222222',
		  'stuffs_In'=>$listitemsinfo,
		  'importsDeclareInfo'=>$importsDeclareInfo,
		  'seller'=>$SellerInfo,
		  'returnOfSell_Info'=>$ReturnOfSell,
          'statusAppointment'=>2,
          'DocNumber'=>$DocNumber
		); 
		
	  //echo '<pre>'; print_r($params); echo '</pre>';
	   
	  $result=$client->StockProductDeclare_SI($params); 
	  $response=$result->StockProductDeclare_SIResult;
	  
	  $webservice_ResultCode =$response->ResultCode;
	  $webservice_ResultMessage =$response->ResultMessage;
	  $webservice_RolesList =$response->ObjList->StockProductDeclare->RolesList;
	  $webservice_SellID =$response->ObjList->StockProductDeclare->SellID;
	  $webservice_SellStatusId =$response->ObjList->StockProductDeclare->SellStatusId;
	  
	  echo '<br>';
	  echo 'ResultCode: ';print_r($webservice_ResultCode);echo'<br>';
      echo 'ResultMessage: ';print_r($webservice_ResultMessage);echo'<br>';
      // echo 'webservice_RolesList: ';print_r($webservice_RolesList);echo'<br>';
      // echo 'webservice_SellID: ';print_r($webservice_SellID);echo'<br>';
      // echo 'webservice_SellStatusId: ';print_r($webservice_SellStatusId);echo'<br>';

	  //echo '<pre>';print_r($response);echo '</pre>';
	  //echo "<script>alert('کد پیگیری وب سرویس\\n$response')</script>"; 
	}
	// catch(SoapFault $client)
	catch(Exception $e)
	{
		 echo "<script>alert('وب سرویس فعال نمی باشد')</script>";
		 echo  $e->getMessage();
	}
	   
	$update_track=("UPDATE resid_kala_detail r_k_d INNER JOIN resid r ON r.shomare_resid=r_k_d.shomare_resid AND r.code_ostan=r_k_d.code_ostan AND r.code_anbar=r_k_d.code_anbar AND r.year=r_k_d.year SET webservice_resultcode='$webservice_ResultCode',webservice_resultmessage='$webservice_ResultMessage',webservice_sellid='$webservice_SellID' WHERE code_kala='".$row['code_kala']."' AND r_k_d.year=$mtActiveYear AND tarikh_resid='".$row['tarikh_resid']."' AND (noe_tahvil_bar=1 OR noe_tahvil_bar=2 OR noe_tahvil_bar=3) AND r.sabt_nahayi=1 AND r.status=0 AND r.deleted=0 AND r.code_anbar!=301");	
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
////////////////////////////////////////////////////////////////////////////////////////////////
echo'
</form>
</body>
</html>';	
?>