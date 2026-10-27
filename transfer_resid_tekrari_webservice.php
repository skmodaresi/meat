<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="transfer_resid_tekrari_webservice.php";
echo'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" />
<html xmlns="http://www.w3.org/1999/xhtml" dir=rtl>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>transfer_resid_tekrari_webservice</title>
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
	<tr><td colspan="4" class="title">transfer resid</td></tr>

    <tr class="tr1"><td colspan="4" height="40px"><input class="buttonme" type="submit" name="transfer" value="transfer resid"></td></tr> 
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
	//SELECT resid.*,name_ostan,name_anbar From resid join ostan on ostan.code_ostan=resid.code_ostan join list_sardkhane on list_sardkhane.code_ostan=resid.code_ostan and list_sardkhane.code_anbar=resid.code_anbar WHERE year=1395 AND sabt_nahayi=1 AND status=0 AND resid.code_anbar!=301 AND (webservice_trackcode='' OR webservice_trackcode=0 OR webservice_trackcode like '1%' OR webservice_trackcode like '9%');

	//$q_resid="SELECT * From resid WHERE  year=$mtActiveYear AND sabt_nahayi=1 AND status=0 AND code_anbar!=301 AND (webservice_trackcode like '1%')";
	//$q_resid="SELECT * From resid WHERE code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND year=$mtActiveYear AND sabt_nahayi=1 AND status=0 AND code_anbar!=301 AND (webservice_trackcode like '1%')";
	//$q_resid="SELECT * From resid WHERE code_ostan='33' AND code_anbar='101' AND shomare_resid='00003' AND year=$mtActiveYear AND sabt_nahayi=1 AND status=0 AND code_anbar!=301";
    $q_resid="SELECT * From resid WHERE year=$mtActiveYear AND sabt_nahayi=1 AND status=0 AND code_anbar!=301 AND (webservice_trackcode='' OR webservice_trackcode=0 OR webservice_trackcode like '1%' OR webservice_trackcode like '9%')";
	$res_resid = mysql_query($q_resid);	
	while($row_resid=$db->fetch_assoc($res_resid))
    {  
	   $shenaseSazman="02";
	   if(strlen($row_resid['code_ostan'])==1) $code_a=make_pattern($row_resid['code_ostan'],2);
       else $code_a=$row_resid['code_ostan'];
	   $shenaseAnbar=$code_a.$row_resid['code_anbar'];
       $shomareGhabz='0'.$mtActiveYear.$row_resid['shomare_resid'];

	   $IssuedTime=substr($row_resid['IssuedTime'],0,5);	   
	   if($row_resid['barname_no']=='')$BillLadingNo=null;
	   else $BillLadingNo=$row_resid['barname_no']; 
	   if($row_resid['plak4']=='')$plak4=null;
	   else $plak4=$row_resid['plak4'];
	   if($row_resid['plak3']=='')$plak3=null;
	   else $plak3=$row_resid['plak3'];
	   if($row_resid['plak2']=='')$plak2=null;
	   else $plak2=$row_resid['plak2'];
	   if($row_resid['plak1']=='')$Plak1=null;
	   else $plak1=$row_resid['plak1'];
	   $plak=$plak1.$plak2.$plak3.$plak4;
	   $wsdl_url='http://10.7.234.33/warehouse/warehouse.asmx?wsdl';
	   header('Content-Type: text/html; charset=utf-8');
       try
	   {
	     $client=new SoapClient($wsdl_url);
         $bill =array(
		 'id'=>'',
		 'OrganNo'=>$shenaseSazman,
		 'WareHouseNo'=>$shenaseAnbar,
         'BillNo'=>$shomareGhabz,
         'IssuedDate'=>$row_resid['tarikh_resid'],
         'IssuedTime'=>$IssuedTime,
         'InsuranceNo'=>null,
         'OwnerTypeId'=>'LagalPerson',
	     'RealOwnerFirstName'=>null,
         'RealOwnerLastName'=>null,
         'RealOwnerNationalCode'=>null,
         'RealOwnerAddress'=>null,
         'RealOwnerZipCode'=>null,
         'RealOwnerMobile'=>null,
         'RealOwnerPhone'=>null,
         'LegalOwnerName'=>'شرکت پشتیبانی امور دام کشور',
         'LegalOwnerPhone'=>'82971',
         'LegalOwnerNationalCode'=>14002771736,
         'LegalOwnerAgentFirstName'=>'شرکت پشتیبانی امور دام کشور',
         'LegalOwnerAgentLastName'=>'شرکت پشتیبانی امور دام کشور',
         'LegalOwnerAgentNationalCode'=>14002771736,
         'LegalOwnerAgentMobile'=>'82971',
		 'VehicalPlaque'=>$plak,
		 'BillLadingNo'=>$BillLadingNo
         );
	     $listBillStuff=array();
	     $q_resid_k_d="SELECT * From resid_kala_detail r_k_d  WHERE code_ostan=".$row_resid['code_ostan']." AND code_anbar=".$row_resid['code_anbar']." AND year=$mtActiveYear AND shomare_resid='".$row_resid['shomare_resid']."'";
	     $res_Resid_k_d = mysql_query($q_resid_k_d);
	     while($row_resid_k_d=mysql_fetch_assoc($res_Resid_k_d))//جزئیات کالا
	     {
	        $nameKala=$db->get_from_where("name_kala","kala","code_kala=".$row_resid_k_d['code_kala']."");     
	        //$vahedKala=$db->get_from_where("sharh_vahedkala","kala INNER JOIN vahed_kala ON kala.code_vahedkala=vahed_kala.code_vahedkala","code_kala=".$row_resid_k_d['code_kala']."");     
            //if($vahedKala=='کیلوگرم')$UnitMeasurement='Kilogram';
	        $bastebandyKala=$db->get_from_where("sharh_bastebandy","kala INNER JOIN bastebandy ON kala.code_bastebandy=bastebandy.code_bastebandy","code_kala=".$row_resid_k_d['code_kala']."");     
	        $noe_zir_Anbar=$db->get_from_where("noe_ziranbar","list_sardkhane_detail","code_ostan=".$row_resid['code_ostan']." AND code_anbar=".$row_resid['code_anbar']." AND code_ziranbar=".$row_resid_k_d['code_ziranbar']."");     
		    $noeZirAnbar=$ziranbarArr[$noe_zir_Anbar];
		    $nameZirAnbar=$db->get_from_where("name_ziranbar","list_sardkhane_detail","code_ostan=".$row_resid['code_ostan']." AND code_anbar=".$row_resid['code_anbar']." AND code_ziranbar=".$row_resid_k_d['code_ziranbar']."");     

            if(strlen($row_resid_k_d['mah_tolid_shamsi'])==1) $mah2raghami=make_pattern($row_resid_k_d['mah_tolid_shamsi'],2);
            else $mah2raghami=$row_resid_k_d['mah_tolid_shamsi'];
            if(strlen($row_resid_k_d['rouz_tolid_shamsi'])==1) $rouz2raghami=make_pattern($row_resid_k_d['rouz_tolid_shamsi'],2);
            else $rouz2raghami=$row_resid_k_d['rouz_tolid_shamsi'];
			
			$ProductionDate=$row_resid_k_d['sal_tolid_shamsi'].'/'.$mah2raghami.'/'.$rouz2raghami;
		    
			$billStuff1=array(
            'Id'=>'',
		    'WareHouseNo'=>$shenaseAnbar,
			'BillNo'=>$shomareGhabz,
            'StuffName'=>$nameKala,
            'StuffCode'=>$row_resid_k_d['code_kala'],
            'StuffNameFromService'=>$nameKala,
            'StuffCodeFromService'=>$row_resid_k_d['code_kala'],
            'UnitMeasurement'=>$UnitMeasurement,
            'Count'=>$row_resid_k_d['vazn_khales_r_d_sub'],
            'ProductionDate'=>$ProductionDate,
            'ExpirationDate'=>null,
	        'PackingTypeName'=>$bastebandyKala,
            'PackingCount'=>$row_resid_k_d['tedad_karton_r_d_sub'],
            'SalonNo'=>$nameZirAnbar,
            'MaintenancePlaceName'=>$noeZirAnbar
             );    
	     	array_push($listBillStuff,$billStuff1);  
	       }
           $params=array(
            'OrganNo_'=>$shenaseSazman,
            'WareHouseNo_'=>$shenaseAnbar,
            'Bill_'=>$bill,
            'BillStuff_'=>$listBillStuff,
		    'Username'=>'warehouseuser',
            'Password'=>'AqWsXz@8246'
            );
			$result=$client->UpdateBill($params); 
		    $response=$result->UpdateBillResult;
		    //echo "<script>alert('کد پیگیری وب سرویس\\n$response')</script>";  
	   }
	   catch(SoapFault $client)
	   {
	     $response=0;
		 echo "<script>alert('وب سرویس فعال نمی باشد')</script>";
	   }
	   $update_track=("UPDATE resid SET webservice_trackcode='$response' WHERE code_ostan=".$row_resid['code_ostan']." AND code_anbar=".$row_resid['code_anbar']." AND shomare_resid='".$row_resid['shomare_resid']."' AND year=$mtActiveYear");
	   $update_res=mysql_query($update_track);
     
    }
    if($update_res)
    {
   	 mysql_query("COMMIT");
       echo "<script>alert('success')</script>"; 
       echo "<script>window.location='transfer_resid_tekrari_webservice.php'</script>";
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