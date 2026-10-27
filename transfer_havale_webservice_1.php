<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="transfer_havale_webservice_1.php";
echo'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" />
<html xmlns="http://www.w3.org/1999/xhtml" dir=rtl>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>transfer havale</title>
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
	<tr><td colspan="4" class="title">transfer havale</td></tr>

    <tr class="tr1"><td colspan="4" height="40px"><input class="buttonme" type="submit" name="transfer" value="transfer havale"></td></tr> 
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
	//SELECT havale.*,name_ostan,name_anbar From havale join ostan on ostan.code_ostan=havale.code_ostan join list_sardkhane on list_sardkhane.code_ostan=havale.code_ostan and list_sardkhane.code_anbar=havale.code_anbar WHERE year=1395 AND sabt_nahayi=1 AND status=0 AND havale.code_anbar!=301 AND (webservice_trackcode='' OR webservice_trackcode=0 OR webservice_trackcode like '1%' OR webservice_trackcode like '9%');

	//$q_havale="SELECT * From havale h WHERE code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND year=$mtActiveYear AND sabt_nahayi=1 AND status=0 AND (webservice_trackcode='' OR webservice_trackcode=0 OR webservice_trackcode like '1%' OR webservice_trackcode like '9%')";
	$q_havale="SELECT * From havale h WHERE year=$mtActiveYear AND sabt_nahayi=1 AND status=0 AND ((code_ostan=14 AND code_anbar=102 AND shomare_havale_anbar='00126')OR (code_ostan=16 AND code_anbar=102 AND shomare_havale_anbar='00279'))";
	$res_havale = mysql_query($q_havale);
	
	while($row_havale=$db->fetch_assoc($res_havale))
    {
       $shenaseSazman="02";
	   if(strlen($row_havale['code_ostan'])==1) $code_a=make_pattern($row_havale['code_ostan'],2);
       else $code_a=$row_havale['code_ostan'];
	   $shenaseAnbar=$code_a.$row_havale['code_anbar'];
	   $shomareBijak='0'.$mtActiveYear.$row_havale['shomare_havale_anbar'];

	   if(($row_havale['noe_tahvil_bar']==4)or($row_havale['noe_tahvil_bar']==5)) $shomareMojavez=$row_havale['shomare_jabejae'];
       else $shomareMojavez=$row_havale['h_code'];
	   $IssuedTime=substr($row_havale['IssuedTime'],0,5);
	   if($row_havale['plak4']=='')$plak4=null;
	   else $plak4=$row_havale['plak4'];
	   if($row_havale['plak3']=='')$plak3=null;
	   else $plak3=$row_havale['plak3'];
	   if($row_havale['plak2']=='')$plak2=null;
	   else $plak2=$row_havale['plak2'];
	   if($row_havale['plak1']=='')$Plak1=null;
	   else $plak1=$row_havale['plak1'];
	   $plak=$plak1.$plak2.$plak3.$plak4;
	   $wsdl_url='http://10.7.234.33/warehouse/warehouse.asmx?wsdl';
	   header('Content-Type: text/html; charset=utf-8');
       try
	   {
	     $client=new SoapClient($wsdl_url);
         $bijak =array(
         'id'=>'',
	     'OrganNo'=>$shenaseSazman,
	     'WareHouseNo'=>$shenaseAnbar,
	     'BijakNo'=>$shomareBijak,
         'DraftNo'=>$shomareMojavez,
         'IssuedDate'=>$row_havale['tarikh_havale_anbar'],
         'Issuedtime'=>$IssuedTime,
         'VehicalPlaque'=>$plak,
         'NetWeight'=>$row_havale['vazn_khales_h'],
	     'GrossWeight'=>$row_havale['vazn_nakhales_h']
	     // 'revokeDate'=>'',
	     // 'revokeTime '=>'',
	     // 'status'=>'',
	     // 'codeyear'=>'',
	     // 'CodePeigiri'=>'',
	     // 'CodePeigiri1'=>'',
	     // 'CheckListNumber'=>'',
	     // 'CoutageNo'=>'',
	     // 'CoutageDate'=>'',
	     // 'CustomCode'=>''
         );
	     $listBijakStuff=array();   
	     $q_havale_d="SELECT * From havale_detail h_d  WHERE code_ostan=".$row_havale['code_ostan']." AND code_anbar=".$row_havale['code_anbar']." AND year=$mtActiveYear AND shomare_havale_anbar='".$row_havale['shomare_havale_anbar']."'";
	     $res_havale_d = mysql_query($q_havale_d);
	     while($row_havale_d=mysql_fetch_assoc($res_havale_d))//جزئیات کالا
	     {
	      $nameKala=$db->get_from_where("name_kala","kala","code_kala=".$row_havale_d['code_kala']."");     
	      //$vahedKala=$db->get_from_where("sharh_vahedkala","kala INNER JOIN vahed_kala ON kala.code_vahedkala=vahed_kala.code_vahedkala","code_kala=".$row_havale_d['code_kala']."");     
          //if($vahedKala=='کیلوگرم')$UnitMeasurement='Kilogram';
	      $bastebandyKala=$db->get_from_where("sharh_bastebandy","kala INNER JOIN bastebandy ON kala.code_bastebandy=bastebandy.code_bastebandy","code_kala=".$row_havale_d['code_kala']."");     
	      //$codeZirAnbar=$db->get_from_where("noe_ziranbar","list_sardkhane_detail","code_ostan=".$row_havale['code_ostan']." AND code_anbar=".$row_havale['code_anbar']." AND code_ziranbar=".$row_havale_d['code_ziranbar']."");     
		  //$noeZirAnbar=$ziranbarArr[$codeZirAnbar];
		  //$nameZirAnbar=$db->get_from_where("name_ziranbar","list_sardkhane_detail","code_ostan=".$row_havale['code_ostan']." AND code_anbar=".$row_havale['code_anbar']." AND code_ziranbar=".$row_havale_d['code_ziranbar']."");     
          $bijakStuff1=array(
          'id'=>'',
	      'WareHouseNo'=>$shenaseAnbar,
		  'BijakNo'=>$shomareBijak,
          'StuffName'=>$nameKala,
          'StuffCode'=>$row_havale_d['code_kala'],
          'StuffNameFromService'=>$nameKala,
          'StuffCodeFromService'=>$row_havale_d['code_kala'],
          //'LoadingCount'=>$row_havale_d['vazn_khales_h_d'],
          'loadingCount'=>$row_havale_d['tedad_karton_h_d'],
          'PackingTypeName'=>$bastebandyKala,
          //'PackingCount'=>$row_havale_d['tedad_karton_h_d'],
          'UnitCount'=>null,
		  'TotalPrice'=>null,
          'LoadingNetWeight'=>$row_havale_d['vazn_khales_h_d'],
          'LoadingGrossWeight'=>$row_havale_d['vazn_nakhales_h_d'],
          'BillNo'=>null
          );   
	      array_push($listBijakStuff,$bijakStuff1);  
	     }
	     $params=array(
          'OrganNo_'=>$shenaseSazman,
          'WareHouseNo_'=>$shenaseAnbar,
          'Bijak_'=>$bijak,
          'BijakStuff_'=>$listBijakStuff,
		  'Username'=>'warehouseuser',
          'Password'=>'AqWsXz@8246'
          );
         //$result=$client->SendBijak($params);
	     //$response=$result->SendBijakResult;
		 $result=$client->UpdateBijak($params);
	     $response=$result->UpdateBijakResult;
		 //echo "<script>alert('کد پیگیری وب سرویس\\n$response')</script>"; 
	   }
	   catch(SoapFault $client)
	   {
	     $response=0;
		 echo "<script>alert('وب سرویس فعال نمی باشد')</script>";
	   }
	   $update_track=("UPDATE havale SET webservice_trackcode='$response' WHERE code_ostan=".$row_havale['code_ostan']." AND code_anbar=".$row_havale['code_anbar']." AND shomare_havale_anbar='".$row_havale['shomare_havale_anbar']."' AND year=$mtActiveYear");
	   $insert_res=mysql_query($update_track);
    }
    if($insert_res)
    {
   	   mysql_query("COMMIT");
       echo "<script>alert('success')</script>"; 
       //echo "<script>window.location='havale.php'</script>";
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