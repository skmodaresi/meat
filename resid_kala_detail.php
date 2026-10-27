<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="resid_kala_detail.php";
$TableName="resid_kala_detail";
$right_ins=0;$right_edt=0;$right_del=0;
if (right(167)) $right_ins=1;
if (right(168)) $right_edt=1;
if (right(169)) $right_del=1;
/*resid_detail خواندن اطلاعات جدول*/
 $q_detail="SELECT r_d.*,r.id AS resid_id,kala.name_kala FROM $mydatabase.resid_detail r_d INNER JOIN $mydatabase.resid r ON r.shomare_resid=r_d.shomare_resid AND r.code_ostan=r_d.code_ostan AND r.code_anbar=r_d.code_anbar AND r.year=r_d.year INNER JOIN kala ON kala.code_kala=r_d.code_kala WHERE r_d.id='$r_d_id_'";	
 $all_detail = $db->query($q_detail);
 $row_detail=$db->fetch_assoc($all_detail);
 $id_resid_=$row_detail['resid_id'];
 $shomare_resid_=$row_detail['shomare_resid'];
 $code_kala_=$row_detail['code_kala'];
 $code_keshvar_=$row_detail['code_keshvar'];
 $code_tolidkonande_=$row_detail['code_tolidkonande'];
 $resid_status=$db->get_from_where("status","$mydatabase.resid","shomare_resid='".$row_detail['shomare_resid']."' AND code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND year=$mtActiveYear");
 $noe_tahvil_bar_=$db->get_from_where("noe_tahvil_bar","$mydatabase.resid","shomare_resid='".$row_detail['shomare_resid']."' AND code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND year=$mtActiveYear");
 $tarikh_resid=$db->get_from_where("tarikh_resid","$mydatabase.resid","shomare_resid='".$row_detail['shomare_resid']."' AND code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND year=$mtActiveYear");
 //echo $resid_status.'<br/>';
 //echo $noe_tahvil_bar_.'<br/>';
 if(strlen($mt_gl_code_ostan)==1) $code_a=make_pattern($mt_gl_code_ostan,2);
 else $code_a=$mt_gl_code_ostan;
 $sabtNahayi=$db->get_from_where("sabt_nahayi","$mydatabase.resid","shomare_resid='".$shomare_resid_."' AND code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND year=$mtActiveYear");     
 $webserviceTrackcode=$db->get_from_where("webservice_trackcode","$mydatabase.resid","shomare_resid='".$shomare_resid_."' AND code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND year=$mtActiveYear");     
echo'
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>جزئیات کالای '.$row_detail['name_kala'].' در رسید شماره '.$code_a.$mt_gl_code_anbar.$row_detail['shomare_resid'].'</title>
<link href="styles.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="functions.js"></script>
<script type="text/javascript" src="scripts/jquery-1.6.2.min.js"></script>
<script type="text/javascript">
 function getVaznKarton(c_karton)<!-- اطلاعات کارتن-->
 {
   $("#loading").fadeIn("fast");  
   $.post("ajax.php",{codeKARTON: c_karton},function(data){
		   var splKarton = data.split("^");
		   $("#vazn_karton_this").val(splKarton[1]);
		 });
   $("#loading").fadeOut("fast");	
 }
 function sumkarton()<!--محاسبه مجموع وزن کارتن ها -->
 {
  var sum_k;
  sum_k=parseFloat((document.myform.vazn_karton_this.value)*(document.myform.tedad_karton_r_d_sub.value)).toFixed(3);
  document.myform.sum_karton_r_d_sub.value=sum_k;
 }
 function vazn_khales()<!--محاسبه وزن خالص-->
 {
  var natije_vazn;
  natije_vazn=parseFloat((document.myform.vazn_nakhales_r_d_sub.value)-(document.myform.sum_karton_r_d_sub.value)).toFixed(3);                                      
  if(natije_vazn<0) natije_vazn=0;
  document.myform.vazn_khales_r_d_sub.value=natije_vazn;
 } 
 function getVaznGHooti(c_ghooti)<!-- اطلاعات قوطی-->
 {
   $("#loading").fadeIn("fast");  
   $.post("ajax.php",{codeGHOOTI: c_ghooti},function(data){
		   var splGhooti = data.split("^");
		   $("#vazn_karton_this").val(splGhooti[1]);
		 });
   $("#loading").fadeOut("fast");	
 }
 function sumghooti()<!--محاسبه وزن قوطی ها-->
 {
  var sum_k2;
  sum_k2=parseFloat((document.myform.vazn_karton_this.value)*(document.myform.tedad_karton_r_d_sub.value)).toFixed(3);
  document.myform.vazn_khales_r_d_sub.value=sum_k2;
 }
 function NumKeyPress(input,evn){
	var isNS = (navigator.appName=="Netscape")?1:0;
	//if (charCode == 8 || charCode == 9) return true; // backspace , tab	
	if (!isNS){
		if (event.keyCode >= 48 || event.keyCode <= 57 || event.keyCode==8 || event.keyCode==9) 
		    event.returnValue = true;
		else
			event.returnValue = false;
	}
	else{
                  	if(evn.which >= 48 || evn.which <= 57 || evn.which == 8 || evn.which == 9) 
					   return true;
					else
			            return false;
	}	
//	input.value=Comma(filterNum(input.value),0);
}
function NumKeyUp(input,evn){
	var isNS = (navigator.appName=="Netscape")?1:0;
	if (!isNS){
		if ((event.keyCode != 37) && (event.keyCode != 38) && (event.keyCode != 39) && (event.keyCode != 40))	
			input.value=Comma(filterNum(input.value),1);
	    else input.focus();
	}
	else{
		if((evn.which != 37) && (evn.which != 38) && (evn.which != 39) && (evn.which != 40)) 
			input.value=Comma(filterNum(input.value),1);
		else input.focus();
	}
}
function filterNum(str) {
	re = /,/g;
	// remove ","
	return str.replace(re, "");
}
function Comma(myVal,oneFlag) {
	var T="",S=String(myVal),L=S.length-oneFlag, j;
	for (var j=0; j<=L; j++) {
		T+=S.charAt(j);
		if ((j < L) && ((L-j)%3 == 0)) 
			T+=","; 
	}
	return T;
}
</script>
</head>';
if(!(isset($Mode))) $Mode='';
$cnt=$db->get_from_where("COUNT(*)","$TableName","id='$r_d_id_'");
/******************** Insert- Edit- Delete ************/
/********************WEB SERVICE***********************/
// if((isset($send_resid))and(isset($sabt_resid)))//مراحل ثبت در وب سرویس
// {
   // //ثبت نهایی
   // $update_sabt=("UPDATE resid SET sabt_nahayi=1 WHERE code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND shomare_resid='$shomare_resid_' AND year=$mtActiveYear");
   // $update_res_sabt=mysql_query($update_sabt); 
   // if($_SESSION['mt_webservice']==1)//اتصال به وب سرویس
   // {
	    // $shenaseAnbar=$mt_gl_code_ostan.$mt_gl_code_anbar;
        // $shomareGhabz=$mt_gl_code_ostan.$mt_gl_code_anbar.$shomare_resid_;
	    // $noe_malekiyat=$db->get_from_where("noe_malekiyat","list_sardkhane","code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar'");     
        // $malekiyatAnbar=$noe_malekiyatArr[$noe_malekiyat];
	    // if($malekiyatAnbar=='ملکی')$WarehouseOwnershipStatus='Property';
	    // if($malekiyatAnbar=='استیجاری')$WarehouseOwnershipStatus='Leased';
        // $addressAnbar=$db->get_from_where("address_anbar","list_sardkhane","code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar'");     
        // if($addressAnbar=='')$address=null;
	    // else $address=$addressAnbar;
	    // $q_resid="SELECT * From resid r WHERE code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND year=$mtActiveYear AND shomare_resid='$shomare_resid_'";
	    // $res_Resid = mysql_query($q_resid);
	    // $row_resid=mysql_fetch_assoc($res_Resid);
	    // //تبدیل تاریخ شمسی به میلادی
	    // $sql_tarikh=$row_resid['tarikh_resid'];
        // $d=substr($sql_tarikh,8,2);
        // $m=substr($sql_tarikh,5,2);
        // $y=substr($sql_tarikh,0,4);
        // $milady=jalali_to_gregorian($y,$m,$d);
        // $sal=$milady[0];
        // $mah=$milady[1];
        // $rouz=$milady[2];
        // $IssuedDate=$sal.'-'.$mah.'-'.$rouz;
	    // $IssuedTime=substr($row_resid['IssuedTime'],0,5);	   
	    // if($row_resid['barname_no']=='')$BillLadingNo=null;
	    // else $BillLadingNo=$barname_no; 
	    // if($row_resid['plak4']=='')$plak4=null;
	    // else $plak4=$row_resid['plak4'];
	    // if($row_resid['plak3']=='')$plak3=null;
	    // else $plak3=$row_resid['plak3'];
	    // if($row_resid['plak2']=='')$plak2=null;
	    // else $plak2=$row_resid['plak2'];
	    // if($row_resid['plak1']=='')$Plak1=null;
	    // else $plak1=$row_resid['plak1'];
	    // //$wsdl_url='http://94.182.209.120/DataCollectorService.svc?wsdl';
        // //$wsdl_url='http://172.21.55.43/DataCollectorService.svc?wsdl';
	    // $wsdl_url='http://10.7.1.204/DataCollectorService.svc?wsdl';
		// header('Content-Type: text/html; charset=utf-8');
        // try
	    // {
	      // $client=new SOAPClient($wsdl_url);
          // $bill =array(
          // 'BillNo'=>$shomareGhabz,
          // 'IssuedDate'=>$IssuedDate,
          // 'IssuedTime'=>$IssuedTime,
          // 'InsuranceNo'=>null,
          // 'WarehouseOwnershipStatus'=>$WarehouseOwnershipStatus,
          // 'WarehouseUseTypeName'=>null,
          // 'WarehouseState'=>$mt_gl_name_ostan,
          // 'WarehouseBigCity'=>null,
          // 'WarehouseCity'=>null,
          // 'WarehouseAddress'=>$address,
          // 'WarehouseZipCode'=>null,
          // 'WarehousePhone'=>null,
          // 'OwnerTypeID'=>'LagalPerson',
	      // 'RealOwnerFirstName'=>null,
          // 'RealOwnerLastName'=>null,
          // 'RealOwnerNationalCode'=>null,
          // 'RealOwnerAddress'=>null,
          // 'RealOwnerZipCode'=>null,
          // 'RealOwnerMobile'=>null,
          // 'RealOwnerPhone'=>null,
          // 'LegalOwnerName'=>'شرکت پشتیبانی امور دام کشور',
          // 'LegalOwnerPhone'=>'82971',
          // 'LegalOwnerNationalCode'=>14002771736,
          // 'LegalOwnerAgentFirstName'=>'شرکت پشتیبانی امور دام کشور',
          // 'LegalOwnerAgentLastName'=>'شرکت پشتیبانی امور دام کشور',
          // //'LegalOwnerAgentNationalCode'=>14002771736,
          // //'LegalOwnerAgentNationalCode'=>7731689956,
          // 'LegalOwnerAgentMobile'=>'82971'
         // );
	     // $listBillStuff=array();
	     // $q_resid_k_d="SELECT * From resid_kala_detail r_k_d  WHERE code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND year=$mtActiveYear AND shomare_resid='$shomare_resid_'";
	     // $res_Resid_k_d = mysql_query($q_resid_k_d);
	     // while($row_resid_k_d=mysql_fetch_assoc($res_Resid_k_d))//جزئیات کالا
	     // {
	        // $nameKala=$db->get_from_where("name_kala","kala","code_kala=".$row_resid_k_d['code_kala']."");     
	        // $vahedKala=$db->get_from_where("sharh_vahedkala","kala INNER JOIN vahed_kala ON kala.code_vahedkala=vahed_kala.code_vahedkala","code_kala=".$row_resid_k_d['code_kala']."");     
            // if($vahedKala=='کیلوگرم')$UnitMeasurement='Kilogram';
	        // $bastebandyKala=$db->get_from_where("sharh_bastebandy","kala INNER JOIN bastebandy ON kala.code_bastebandy=bastebandy.code_bastebandy","code_kala=".$row_resid_k_d['code_kala']."");     
	        // $codeZirAnbar=$db->get_from_where("noe_ziranbar","list_sardkhane_detail","code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND code_ziranbar=".$row_resid_k_d['code_ziranbar']."");     
		    // $noeZirAnbar=$ziranbarArr[$codeZirAnbar];
		    // $nameZirAnbar=$db->get_from_where("name_ziranbar","list_sardkhane_detail","code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND code_ziranbar=".$row_resid_k_d['code_ziranbar']."");     
            // //تبدیل تاریخ شمسی به میلادی
            // $milady_t=jalali_to_gregorian($row_resid_k_d['sal_tolid_shamsi'],$row_resid_k_d['mah_tolid_shamsi'],$row_resid_k_d['rouz_tolid_shamsi']);
		    // $sal_t=$milady_t[0];
            // $mah_t=$milady_t[1];
            // $rouz_t=$milady_t[2];
            // $ProductionDate=$sal_t.'-'.$mah_t.'-'.$rouz_t;
		    // $billStuff1=array(
            // 'BillNo'=>$shomareGhabz,
            // 'StuffName'=>$nameKala,
            // 'StuffCode'=>$row_resid_k_d['code_kala'],
            // 'StuffNameFromService'=>$nameKala,
            // 'StuffCodeFromService'=>$row_resid_k_d['code_kala'],
            // 'UnitMeasurement'=>$UnitMeasurement,
            // 'Count'=>$row_resid_k_d['vazn_khales_r_d_sub'],
            // 'ProductionDate'=>$ProductionDate,
            // //'ExpirationDate'=>'',
	        // 'PackingTypeName'=>$bastebandyKala,
            // 'PackingCount'=>$row_resid_k_d['tedad_karton_r_d_sub'],
            // 'SalonNo'=>$nameZirAnbar,
            // 'MaintenancePlaceName'=>$noeZirAnbar
             // );    
	     	// array_push($listBillStuff,$billStuff1);  
	       // }
	       // //print_r($listBillStuff);
           // $billLading=array(
           // 'SenderTypeID'=>'LegalSender',
           // //'RealSenderFirstName'=>'',
           // //'RealSenderLastName'=>'',
           // //'RealSenderNationalCode'=>'',
           // //'RealSenderMobile'=>'',
           // 'LegalSenderName'=>'شرکت پشتیبانی امور دام کشور',
           // 'LegalSenderNationalCode'=>14002771736,
           // 'LegalSenderPhone'=>'82971',
           // //'SourceState'=>'',
           // //'SourceBigCity'=>'',
           // //'SourceCity'=>'',
           // //'SourceAddress'=>'',
           // //'SourceZipCode'=>'2524515487',
           // 'Plaque1'=>$plak4,
           // 'Plaque2'=>$plak3,
           // 'Plaque3'=>$plak2,
           // 'Plaque4'=>$plak1,
           // 'BillLadingNo'=>$BillLadingNo,
           // //'EntryLicenseNo'=>'',
           // );
           // $listBillLading=array(
           // $billLading
           // );  
           // $params=array(
           // //'username'=>'admin',
           // 'username'=>'GOV.AGRI.SLAL.02100',
           // 'password'=>'N2KHD2BRL4',
           // //'password'=>'123',
           // 'warehouseNo'=>$shenaseAnbar,
           // 'bill'=>$bill,
           // 'listBillStuff'=>$listBillStuff,
           // 'listBillLading'=>$listBillLading
           // );
	       // //print_r($params);
           // $result=$client->SendBill($params); 
           // $response=$result->SendBillResult; 
	       // $message=$response->Message->Content;
	       // $track=$response->TrackingCode;
	       // echo "<script>alert('$message\\n$track')</script>";
	   // }
	   // catch(SoapFault $client)
	   // {
	     // $track=0;
		 // echo "<script>alert('وب سرویس فعال نمی باشد')</script>";
	   // }
	   // $update_track=("UPDATE resid SET webservice_trackcode=$track WHERE code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND shomare_resid='$shomare_resid_' AND year=$mtActiveYear");
	   // $update_res=mysql_query($update_track);
   // }
   // echo "<script>
         // window.close();
         // window.opener.location='resid.php?PageNo=".$PageNo."&RowPerPage=".$RowPerPage."&order=".$order."';
		// </script>";     
// } 
/************اجازه براي ذخيره اطلاعات************/
function isPermitSave($noe_t_b,$code_baste,$code_zir_a,$sal_t_sh,$mah_t_sh,$rouz_t_sh,$c_karton,$c_mandegari,$tedad_k,$vazn_na,$vazn_kh,$sh_r,$c_kala,$c_keshvar,$c_tolid,$date_resid,$gl_c_o,$gl_c_s,$gl_year)
{
 $flag=false;
 $today=AsLDate($yymmdd);
 //تاریخ تولید به فرمت تاریخ
 if(strlen($rouz_t_sh)==1) $rouz=make_pattern($rouz_t_sh,2);
 else $rouz=$rouz_t_sh; 
 if(strlen($mah_t_sh)==1) $mah=make_pattern($mah_t_sh,2);
 else $mah=$mah_t_sh;
 $tolid=$sal_t_sh.'/'.$mah.'/'.$rouz;
 $sum_resid=0;
 //*az saghfe kharid*//
 //گروه کالا
 // $q_gr="SELECT code_group_kala_top FROM kala WHERE code_kala=$c_kala";
 // $res_gr=mysql_query($q_gr);
 // $row_gr=mysql_fetch_assoc($res_gr);
 //مجموع رسیدهای استان که جابهجایی نباشند و از تاریخ 20 اسفند به بعد 
 //$resid_start_date='1394/12/20';
 // $q1_1="SELECT * FROM saghf_kharid WHERE '$date_resid' BETWEEN az_tarikh_etebar AND ta_tarikh_etebar AND code_ostan='$gl_c_o' AND code_group_kala_top=".$row_gr['code_group_kala_top']." AND deleted=0";
 // $res1_1=mysql_query($q1_1);
 // $row1_1=mysql_fetch_assoc($res1_1);
 // if(($code_baste==1)or($code_baste==3))//کارتن ولاشه
 // {
  // $q_residha="SELECT sum(vazn_khales_r_d_sub)AS SUMRESID FROM resid_kala_detail INNER JOIN kala ON kala.code_kala=resid_kala_detail.code_kala INNER JOIN resid ON resid.shomare_resid=resid_kala_detail.shomare_resid AND resid.code_ostan=resid_kala_detail.code_ostan AND resid.code_anbar=resid_kala_detail.code_anbar AND resid.year=resid_kala_detail.year WHERE resid_kala_detail.code_ostan=$gl_c_o AND resid_kala_detail.resid_deleted=0 AND resid_kala_detail.status=0 AND resid_kala_detail.year=$gl_year AND code_group_kala_top=".$row_gr['code_group_kala_top']." AND tarikh_resid BETWEEN '".$row1_1['az_tarikh_etebar']."' AND '".$row1_1['ta_tarikh_etebar']."' AND noe_tahvil_bar!=4 AND noe_tahvil_bar!=5";
  // $res_residha=mysql_query($q_residha);
  // $row_residha=mysql_fetch_assoc($res_residha);
  // $sum_resid=round($row_residha['SUMRESID']+$vazn_kh,3);
 // }
 // if($code_baste==2)//قوطی
 // {
  // $q_residha="SELECT sum(tedad_karton_r_d_sub)AS SUMRESID FROM resid_kala_detail INNER JOIN kala ON kala.code_kala=resid_kala_detail.code_kala INNER JOIN resid ON resid.shomare_resid=resid_kala_detail.shomare_resid AND resid.code_ostan=resid_kala_detail.code_ostan AND resid.code_anbar=resid_kala_detail.code_anbar AND resid.year=resid_kala_detail.year WHERE resid_kala_detail.code_ostan=$gl_c_o AND resid_kala_detail.resid_deleted=0 AND resid_kala_detail.status=0 AND resid_kala_detail.year=$gl_year AND code_group_kala_top=".$row_gr['code_group_kala_top']." AND tarikh_resid BETWEEN '".$row1_1['az_tarikh_etebar']."' AND '".$row1_1['ta_tarikh_etebar']."' AND noe_tahvil_bar!=4 AND noe_tahvil_bar!=5";
  // $res_residha=mysql_query($q_residha);
  // $row_residha=mysql_fetch_assoc($res_residha);
  // $sum_resid=$row_residha['SUMRESID']+$tedad_k;
 // }
 //*az saghfe kharid*//
 //*az gharardad kharid*//
  $q_resid="SELECT id_safar FROM meat.resid WHERE shomare_resid='$sh_r' AND code_ostan=$gl_c_o AND code_anbar=$gl_c_s AND year=$gl_year";
  $res_resid=mysql_query($q_resid);
  $row_resid=mysql_fetch_assoc($res_resid);
  $q1_1="SELECT * FROM meat.gharardad_kharid WHERE shomare_gharardad=(SELECT shomare_safar FROM meat.shomare_safar WHERE id_safar=".$row_resid['id_safar'].") AND deleted=0";
  $res1_1=mysql_query($q1_1);
  $row1_1=mysql_fetch_assoc($res1_1);
  if(($code_baste==1)or($code_baste==3)or($code_baste==4))//کارتن یا لاشه یا کیسه
 {
  //$q_residha="SELECT SUM(vazn_khales_r_d_sub)AS SUMRESID FROM resid_kala_detail r_k_d INNER JOIN resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year WHERE id_safar=".$row_resid['id_safar']." AND r_k_d.code_ostan=$gl_c_o AND r_k_d.year=$gl_year AND r_k_d.resid_deleted=0 AND r_k_d.status=0";
  $q_residha="SELECT SUM(vazn_khales_r_d_sub)AS SUMRESID FROM meat.resid_kala_detail r_k_d INNER JOIN meat.resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year WHERE id_safar=".$row_resid['id_safar']." AND r_k_d.code_ostan=$gl_c_o AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND noe_tahvil_bar!=8";
  $res_residha=mysql_query($q_residha);
  $row_residha=mysql_fetch_assoc($res_residha);
  		//if(SuperUser())echo"<script>alert(".$row_residha['SUMRESID'].")</script>";
  		//if(SuperUser())echo"<script>alert(".$vazn_kh.")</script>";

  $sum_resid=round($row_residha['SUMRESID']+$vazn_kh,3);
 }
 if(($code_baste==2)OR($code_baste==5)OR($code_baste==6))//قوطی یا دست یا عدد
 {
  //$q_residha="SELECT SUM(tedad_karton_r_d_sub)AS SUMRESID FROM resid_kala_detail r_k_d INNER JOIN resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year WHERE id_safar=".$row_resid['id_safar']." AND r_k_d.code_ostan=$gl_c_o AND r_k_d.year=$gl_year AND r_k_d.resid_deleted=0 AND r_k_d.status=0";
  $q_residha="SELECT SUM(tedad_karton_r_d_sub)AS SUMRESID FROM meat.resid_kala_detail r_k_d INNER JOIN meat.resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year WHERE id_safar=".$row_resid['id_safar']." AND r_k_d.code_ostan=$gl_c_o AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND noe_tahvil_bar!=8";
  $res_residha=mysql_query($q_residha);
  $row_residha=mysql_fetch_assoc($res_residha);
  $sum_resid=$row_residha['SUMRESID']+$tedad_k;
 }
  
 if(!($gl_c_o and $gl_c_s and $gl_year) or $gl_c_o==-1 or $gl_c_s==-1)//اگر سشن استان و انبار وسال خالی بود
 {   
   $flag=false;
   echo"<script> alert('لطفاً استان و انبار و سال مورد نظر خود را انتخاب نمایید!')</script>";
   return $flag;
 }
 else $flag=true;
 if(!($code_zir_a and $sal_t_sh and $mah_t_sh and $rouz_t_sh and $c_mandegari and $tedad_k))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script> alert('لطفا تمام فيلد ها را تکميل نماييد')</script>";
   return $flag;
 } 
 else $flag=true;
 if((($code_baste==1)or($code_baste==2)) and (!$c_karton))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script> alert('لطفا تمام فيلد ها را تکميل نماييد')</script>";
   return $flag;
 } 
 else $flag=true;
 if(($code_baste==1) and (!$vazn_na))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script> alert('لطفا تمام فيلد ها را تکميل نماييد')</script>";
   return $flag;
 } 
 else $flag=true;
  if((!empty($sal_t_sh)) and (!empty($mah_t_sh)) and (!empty($rouz_t_sh)) and (!empty($c_mandegari))) //تکراری نبودن تاریخ
 {
   $q8="SELECT * FROM meat.resid_kala_detail WHERE shomare_resid='$sh_r' AND code_kala='$c_kala' AND code_keshvar='$c_keshvar' AND code_tolidkonande='$c_tolid' AND sal_tolid_shamsi='$sal_t_sh' AND mah_tolid_shamsi='$mah_t_sh' AND rouz_tolid_shamsi='$rouz_t_sh' AND code_karton='$c_karton' AND code_mandegari='$c_mandegari' AND code_ostan='$gl_c_o' AND code_ziranbar='$code_zir_a' AND code_anbar='$gl_c_s' AND year='$gl_year'"; 
   $res8=mysql_query($q8);
   if(mysql_num_rows($res8)>0){
   echo"<script>alert('این تاریخ تولید را قبلاً برای این کالا ثبت کرده اید !')</script>";
   $flag=false;
   return $flag;
  }
  else $flag=true;
  if(($noe_t_b==1)or($noe_t_b==2)or($noe_t_b==3))//خرید
  {
	//*az gharardad kharid*//
    $q1_1="SELECT gharardad_kharid.*,eblagh_kharid.mahmule_type FROM meat.gharardad_kharid INNER JOIN meat.dastorolamal_kharid d_kh ON gharardad_kharid.id_dastorolamal=d_kh.id_dastorolamal
	       INNER JOIN meat.eblagh_kharid ON eblagh_kharid.id_eblagh=d_kh.id_eblagh
           WHERE gharardad_kharid.shomare_gharardad=(SELECT shomare_safar FROM meat.shomare_safar WHERE id_safar=".$row_resid['id_safar'].") AND gharardad_kharid.deleted=0";
	//$q1_1="SELECT * FROM gharardad_kharid WHERE shomare_gharardad=(SELECT shomare_safar FROM shomare_safar WHERE id_safar=".$row_resid['id_safar'].") AND deleted=0";
	$res1_1=mysql_query($q1_1);
    if(mysql_num_rows($res1_1)>0)// اگر قرارداد وجود دارد
    {
      $row1_1=mysql_fetch_assoc($res1_1);
      //$ezafe_gharardad=(($row1_1['meghdar_gharardad']*$row1_1['percentage_changes'])/100);
	  //$max_meghdar_gharardad=$row1_1['meghdar_gharardad']+$ezafe_gharardad;
	  $max_meghdar_gharardad=$row1_1['meghdar_gharardad']+$row1_1['mazad_gharardad'];
	  // IF(SuperUser())echo $max_meghdar_gharardad;
	  // IF(SuperUser())echo $sum_resid;
	  //تبدیل تاریخ قرارداد به میلادی
	     $sql_tarikh=$row1_1['tarikh_gharardad'];
         $d=substr($sql_tarikh,8,2);$m=substr($sql_tarikh,5,2);$y=substr($sql_tarikh,0,4);
         $milady=jalali_to_gregorian($y,$m,$d);
         $sal=$milady[0];$mah=$milady[1];$rouz=$milady[2];
         $date_gharardad_milady=$sal.'-'.$mah.'-'.$rouz;
	     $newdate = strtotime ( '-3 month' , strtotime ( $date_gharardad_milady ) ) ;//3ماه قبل از تاریخ قرارداد
	     $newdate = date ( 'Y-m-j' , $newdate );
	  //تبدیل به شمسی
	     $d=substr($newdate,8,2);$m=substr($newdate,5,2);$y=substr($newdate,0,4);
         $DateF=gregorian_to_jalali($y,$m,$d);
         $salF=$DateF[0];$mahF=$DateF[1];$rouzF=$DateF[2];
      $tarikh_gharardad_varedati=AsLDate($salF.$mahF.$rouzF);	 
	  //disabled in 1395/11/23
	  // if(($row1_1['mahmule_type']==1)and($date_resid>$row1_1['tarikh_etmam']))//تاریخ قرارداد به اتمام رسیده در حالت محموله داخلی
	  // {
       // echo"<script>alert('تاریخ قرارداد خرید به اتمام رسیده است اجازه ثبت رسید وجود ندارد!')</script>";
       // $flag=false;
       // return $flag;
      // }
      // else $flag=true; 
	  //if($sum_resid>$row1_1['meghdar_gharardad'])//مقادیر خرید از مقدار قرارداد بیشتر نباشد

	  if($sum_resid>$max_meghdar_gharardad)//مقادیر خرید از مقدار قرارداد بیشتر نباشد
      {
		//if(SuperUser())echo"<script>alert('$max_meghdar_gharardad')</script>";
		//if(SuperUser())echo"<script>alert('$sum_resid')</script>";
		echo"<script>alert('مقادیر رسید از مقدار قرارداد استان بیشتر است!')</script>";
        $flag=false;
        return $flag;
      }
      else $flag=true;
	  //if(($row1_1['mahmule_type']==1)or($row1_1['mahmule_type']==4)) and(($tolid<$row1_1['tarikh_gharardad'])or($tolid>$date_resid)))//تاریخ تولید بیشتر از تاریخ رسید و کمتر از تاریخ قرارداد نباشد در حالت محموله داخلی
	  //if(($tolid<$row1_1['tarikh_gharardad'])or($tolid>$date_resid))//تاریخ تولید بیشتر از تاریخ رسید و کمتر از تاریخ قرارداد نباشد در همه حالات
	  if(($tolid<$row1_1['tarikh_shoro'])or($tolid>$date_resid))//تاریخ تولید بیشتر از تاریخ رسید و کمتر از تاریخ شروع قرارداد نباشددر همه حالات
	  {
       echo"<script>alert('این تاریخ تولید مورد قبول نیست !')</script>";
       $flag=false;
       return $flag;
      }
      else $flag=true;
	  //if(($row1_1['mahmule_type']==2)and(($tolid<$tarikh_gharardad_varedati)or($tolid>$date_resid)))//تاریخ تولید بیشتر از تاریخ رسید و کمتر از تاریخ قرارداد نباشد در حالت محموله خارجی
	  // if(($row1_1['mahmule_type']==2)and($tolid>$date_resid))//تاریخ تولید بیشتر از تاریخ رسید و کمتر از تاریخ قرارداد نباشد در حالت محموله خارجی
	  // {
       // echo"<script>alert('این تاریخ تولید مورد قبول نیست !')</script>";
       // $flag=false;
       // return $flag;
      // }
      // else $flag=true;
    }
	//comment in 1400/04/19
    // if(mysql_num_rows($res1_1)==0)// اگر قرارداد وجود ندارد
	// {
      // echo"<script>alert('اطلاعات قرارداد برای  استان تعیین نشده است!')</script>";
      // $flag=false;
      // return $flag;
    // }
/////////////////////////////////////////////////////////////////////////////
    //*az saghfe kharid*//
	// $q1_1="SELECT * FROM saghf_kharid WHERE '$date_resid' BETWEEN az_tarikh_etebar AND  ta_tarikh_etebar  AND code_ostan='$gl_c_o' AND code_group_kala_top=".$row_gr['code_group_kala_top']." AND deleted=0";
	// $res1_1=mysql_query($q1_1);
    // if(mysql_num_rows($res1_1)>0)
    // {
      // $row1_1=mysql_fetch_assoc($res1_1);
      // if(($tolid<$row1_1['az_tarikh_tolid'])or($tolid>$row1_1['ta_tarikh_tolid'])){
      // echo"<script>alert('این تاریخ تولید مورد قبول نیست !')</script>";
      // $flag=false;
      // return $flag;
      // }
      // else $flag=true;
	  // if($sum_resid>$row1_1['max_meghdar_kharid'])
      // {
        // echo"<script>alert('مقادیر رسید از سقف خرید استان بیشتر است!')</script>";
        // $flag=false;
        // return $flag;
      // }
      // else $flag=true;
    // }
    // else 
    // {
      // echo"<script>alert('اطلاعات برای سقف خرید تعیین نشده است!')</script>";
      // $flag=false;
      // return $flag;
    // }
  }
 
 }
 else $flag=true;
 if(($code_baste!=2) and (($noe_t_b==1)or($noe_t_b==4)or($noe_t_b==7)))//
 {
   if($code_baste==1)$q1="SELECT SUM(vazn_nakhales_r_d_sub) FROM meat.resid_kala_detail WHERE code_ostan=$gl_c_o AND code_anbar=$gl_c_s AND shomare_resid='$sh_r' AND year=$gl_year";
   if($code_baste==3)$q1="SELECT SUM(vazn_khales_r_d_sub) FROM meat.resid_kala_detail WHERE code_ostan=$gl_c_o AND code_anbar=$gl_c_s AND shomare_resid='$sh_r' AND year=$gl_year";
   $res1=mysql_query($q1);
   $row1=mysql_fetch_array($res1);
   if($code_baste==1) $sum_vazn=$row1[0]+$vazn_na;
   if($code_baste==3) $sum_vazn=$row1[0]+$vazn_kh;
   $sum_vazn=round($sum_vazn,3);
   $q2="SELECT vazn_kamiyon_bar,vazn_kamiyon FROM meat.resid WHERE code_ostan=$gl_c_o AND code_anbar=$gl_c_s AND shomare_resid='$sh_r' AND year=$gl_year";
   $res2=mysql_query($q2);
   $row2=mysql_fetch_assoc($res2);
   $diffrent=$row2['vazn_kamiyon_bar']-$row2['vazn_kamiyon'];
   $diffrent=round($diffrent,3);
   //if(SuperUser())echo"<script>alert(".$diffrent.")</script>";
   //if(SuperUser())echo"<script>alert(".$sum_vazn.")</script>";
   if($diffrent<$sum_vazn)
   {
     if($code_baste==1)echo"<script>alert('این مقدار وزن ناخالص از اختلاف وزن کامیون بیشتر است و قابل ثبت نیست!')</script>";
     if($code_baste==3)echo"<script>alert('این مقدار وزن خالص از اختلاف وزن کامیون بیشتر است و قابل ثبت نیست!')</script>";
     $flag=false;
     return $flag;
   }
   else $flag=true;
 } 
 else $flag=true;
 if((!justNumber($sal_t_sh)) or (strlen($sal_t_sh)<4) or (strlen($sal_t_sh)>4) or($sal_t_sh<1392) or($sal_t_sh>$gl_year))//بررسی سال شمسی
 {
   $flag=false;
   echo"<script>alert('فيلد سال تولید شمسی نامعتبر است!')</script>";
   return $flag;
 }
 else $flag=true;
 if((!justNumber($rouz_t_sh)) or (strlen($rouz_t_sh)<1) or (strlen($rouz_t_sh)>2) or($rouz_t_sh>31))//بررسی روز
 {
   $flag=false;
   echo"<script>alert('فيلد روز تولید نامعتبر است!')</script>";
   return $flag;
 }
 else $flag=true;
 if(!empty($c_karton))//موجود نبودن کد کارتن یا قوطی در جدول کارتن/قوطی
 {
   $q_karton="SELECT code_karton FROM meat.karton WHERE code_karton='$c_karton' AND code_bastebandy='$code_baste'";
   $res_karton=mysql_query($q_karton);
   if(mysql_num_rows($res_karton)==0){
     if($code_baste==1)echo"<script>alert('این کدکارتن در جدول کارتن ها ثبت نشده است!')</script>";
     if($code_baste==2)echo"<script>alert('این کدقوطی در جدول قوطی ها ثبت نشده است!')</script>";
     $flag=false;
     return $flag;
   }
   else $flag=true;
 }
 else $flag=true;
return $flag;
}
/*************INSERT BUTTON******/// ثبت اطلاعات    
if(isset($Insert_x_sublevel))
{
 if(isPermitSave($noe_tahvil_bar_,$code_bastebandy_,$code_ziranbar,$sal_tolid_shamsi,$mah_tolid_shamsi,$rouz_tolid_shamsi,$code_karton,$code_mandegari,$tedad_karton_r_d_sub,$vazn_nakhales_r_d_sub,$vazn_khales_r_d_sub,$shomare_resid_,$code_kala_,$code_keshvar_,$code_tolidkonande_,$tarikh_resid,$mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear)) 
 {
	//انتخاب جدول موجودی
	IF($noe_tahvil_bar_==9)$TableMojody='mojody_kala_gomrok';
	ELSE                   $TableMojody='mojody_kala';
	
	$Mode='';
    mysql_query('SET AUTOCOMMIT=0');//TRANSACTIONشروع 
    mysql_query('START TRANSACTION');
	//تبدیل تاریخ شمسی به میلادی
	$milady=jalali_to_gregorian($sal_tolid_shamsi,$mah_tolid_shamsi,$rouz_tolid_shamsi);
    $sal_tolid_milady=$milady[0];$mah_tolid_milady=$milady[1];$rouz_tolid_milady=$milady[2];
	$vazn_karton_this=$db->get_from_where("vazn_karton","$mydatabase.karton","code_karton='$code_karton' AND code_bastebandy='$code_bastebandy_'");     
	//محاسبات برای اطمینان
    if($code_bastebandy_==1)//کارتنی
	{
	  $sum_karton_r_d_sub=round(floatval($vazn_karton_this*$tedad_karton_r_d_sub),3);  
	  $vazn_khales_r_d_sub=round(floatval($vazn_nakhales_r_d_sub-$sum_karton_r_d_sub),3);
	  if($vazn_khales_r_d_sub<0) $vazn_khales_r_d_sub=0;
	  //محاسبه تعداد شانه 
	  IF($code_kala_==50) $tedad_shane_r_d_sub=$tedad_karton_r_d_sub*$_SESSION["mtShane"];
	  ELSE IF($code_kala_==54) $tedad_shane_r_d_sub=$tedad_karton_r_d_sub*$_SESSION["mtShane_dakheli"];
	  ELSE $tedad_shane_r_d_sub=0;
	}
    //قوطی	
	if($code_bastebandy_==2) $vazn_khales_r_d_sub=round(floatval($vazn_karton_this*$tedad_karton_r_d_sub),3);
	$insert_kala_q=("INSERT INTO $mydatabase.$TableName 
                     (code_ostan,code_anbar,shomare_resid,year,code_ziranbar,code_kala,code_keshvar,code_tolidkonande,sal_tolid_shamsi,mah_tolid_shamsi,rouz_tolid_shamsi,
					  sal_tolid_milady,mah_tolid_milady,rouz_tolid_milady,code_karton,vazn_karton_this,code_mandegari,sum_karton_r_d_sub,tedad_karton_r_d_sub,vazn_nakhales_r_d_sub,vazn_khales_r_d_sub,tedad_shane_r_d_sub,status)
                     VALUES('$mt_gl_code_ostan','$mt_gl_code_anbar','$shomare_resid_','$mtActiveYear','$code_ziranbar','$code_kala_','$code_keshvar_','$code_tolidkonande_',
					 '$sal_tolid_shamsi','$mah_tolid_shamsi','$rouz_tolid_shamsi','$sal_tolid_milady','$mah_tolid_milady','$rouz_tolid_milady','$code_karton','$vazn_karton_this','$code_mandegari','$sum_karton_r_d_sub','$tedad_karton_r_d_sub','$vazn_nakhales_r_d_sub','$vazn_khales_r_d_sub','$tedad_shane_r_d_sub',0)");  
	$insert_kala_res=mysql_query($insert_kala_q);
	/*لاگ*/
    $max_id=$db->get_from_where("MAX(id)","$mydatabase.$TableName","shomare_resid='$shomare_resid_' AND code_kala='$code_kala_' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear'");   
    $log_i=$db->query("INSERT INTO $mydatabase.log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName ','$max_id','ثبت',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')"); 
	/**********************************/ 
	// آپدیت وزن خالص در resid_detail 
	   $vazn_khales_r_d=$db->get_from_where("vazn_khales_r_d","$mydatabase.resid_detail","shomare_resid='$shomare_resid_' AND code_kala='$code_kala_' AND code_keshvar='$code_keshvar_' AND code_tolidkonande='$code_tolidkonande_' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND resid_deleted=0 AND status=0");   
	   $update_vazn_khales_r_d=round(floatval($vazn_khales_r_d+$vazn_khales_r_d_sub),3);
       $res_update_khales_d=$db->query("UPDATE $mydatabase.resid_detail SET vazn_khales_r_d='$update_vazn_khales_r_d' WHERE shomare_resid='$shomare_resid_' AND code_kala='$code_kala_' AND code_keshvar='$code_keshvar_' AND  code_tolidkonande='$code_tolidkonande_' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND resid_deleted=0");          
	// آپدیت تعداد کارتن و وزن ناخالص و وزن خالص در رسید 
	   $tedad_karton_r=$db->get_from_where("tedad_karton_r","$mydatabase.resid","shomare_resid='$shomare_resid_' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0 AND status=0");   
	   $vazn_nakhales_r=$db->get_from_where("vazn_nakhales_r","$mydatabase.resid","shomare_resid='$shomare_resid_' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0 AND status=0");   
	   $vazn_khales_r=$db->get_from_where("vazn_khales_r","$mydatabase.resid","shomare_resid='$shomare_resid_' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0 AND status=0");   
	   $update_tedad_karton_r=$tedad_karton_r+$tedad_karton_r_d_sub;
	   $update_vazn_nakhales_r=round(floatval($vazn_nakhales_r+$vazn_nakhales_r_d_sub),3);
	   $update_vazn_khales_r=round(floatval($vazn_khales_r+$vazn_khales_r_d_sub),3);
       $res_update_khales=$db->query("UPDATE resid SET tedad_karton_r='$update_tedad_karton_r',vazn_nakhales_r='$update_vazn_nakhales_r',vazn_khales_r='$update_vazn_khales_r' WHERE shomare_resid='$shomare_resid_' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0");       
	 /*آپدیت موجودی*/
       $exist_mojody=$db->get_from_where("count(*)","$mydatabase.$TableMojody","code_ziranbar='$code_ziranbar' AND code_kala='$code_kala_' AND code_keshvar='$code_keshvar_' AND code_tolidkonande='$code_tolidkonande_' AND sal_tolid_shamsi='$sal_tolid_shamsi' AND mah_tolid_shamsi='$mah_tolid_shamsi' AND rouz_tolid_shamsi='$rouz_tolid_shamsi' AND code_karton='$code_karton' AND code_mandegari='".$code_mandegari."' AND code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND year=$mtActiveYear AND deleted=0");	
	   if($exist_mojody>0)//اگر در جدول موجودی کالا وجود دارد
      {   
	   //آپدیت موجودی کالا
	   IF($noe_tahvil_bar_==9)
	   {
	    $update_tedad_karton=mojodyKarton($mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear,$code_ziranbar,$code_kala_,$code_keshvar_,$code_tolidkonande_,$sal_tolid_shamsi,$mah_tolid_shamsi,$rouz_tolid_shamsi,$code_karton,$code_mandegari,2);
	    $update_mojody_nakhales=mojodyNakhales($mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear,$code_ziranbar,$code_kala_,$code_keshvar_,$code_tolidkonande_,$sal_tolid_shamsi,$mah_tolid_shamsi,$rouz_tolid_shamsi,$code_karton,$code_mandegari,2);
	    $update_mojody_khales=mojodyKhales($mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear,$code_ziranbar,$code_kala_,$code_keshvar_,$code_tolidkonande_,$sal_tolid_shamsi,$mah_tolid_shamsi,$rouz_tolid_shamsi,$code_karton,$code_mandegari,2);  
       }
	   ELSE
	   {
	    $update_tedad_karton=mojodyKarton($mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear,$code_ziranbar,$code_kala_,$code_keshvar_,$code_tolidkonande_,$sal_tolid_shamsi,$mah_tolid_shamsi,$rouz_tolid_shamsi,$code_karton,$code_mandegari);
	    $update_mojody_nakhales=mojodyNakhales($mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear,$code_ziranbar,$code_kala_,$code_keshvar_,$code_tolidkonande_,$sal_tolid_shamsi,$mah_tolid_shamsi,$rouz_tolid_shamsi,$code_karton,$code_mandegari);
	    $update_mojody_khales=mojodyKhales($mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear,$code_ziranbar,$code_kala_,$code_keshvar_,$code_tolidkonande_,$sal_tolid_shamsi,$mah_tolid_shamsi,$rouz_tolid_shamsi,$code_karton,$code_mandegari);  
       }
	   IF($code_kala_==50) $update_tedad_shane=$update_tedad_karton*$_SESSION["mtShane"];
       IF($code_kala_==54) $update_tedad_shane=$update_tedad_karton*$_SESSION["mtShane_dakheli"];
	   ELSE $update_tedad_shane=0;
	   $update_mojody_res=$db->query("UPDATE $mydatabase.$TableMojody SET mojody_khales='$update_mojody_khales',mojody_nakhales='$update_mojody_nakhales',tedad_karton='$update_tedad_karton',tedad_shane='$update_tedad_shane' WHERE code_ziranbar='$code_ziranbar' AND code_kala='$code_kala_' AND code_keshvar='$code_keshvar_' AND code_tolidkonande='$code_tolidkonande_' AND sal_tolid_shamsi='$sal_tolid_shamsi' AND mah_tolid_shamsi='$mah_tolid_shamsi' AND rouz_tolid_shamsi='$rouz_tolid_shamsi' AND code_karton='$code_karton' AND code_mandegari='".$code_mandegari."' AND code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND year=$mtActiveYear AND deleted=0");  
	   /*لاگ موجودی*/
      }
      else //اگر وجود ندارد
      {
        $insert_mojody_q=("INSERT INTO $mydatabase.$TableMojody(code_ostan,code_anbar,year,code_ziranbar,code_kala,code_keshvar,code_tolidkonande,sal_tolid_shamsi,mah_tolid_shamsi,rouz_tolid_shamsi,sal_tolid_milady,mah_tolid_milady,rouz_tolid_milady,code_bastebandy,code_karton,vazn_karton_this,code_mandegari,sum_karton_this,tedad_karton_aval,mojody_nakhales_aval,mojody_khales_aval,tedad_shane_aval,tedad_karton,mojody_nakhales,mojody_khales,tedad_shane,deleted)
                           VALUES('$mt_gl_code_ostan','$mt_gl_code_anbar','$mtActiveYear','$code_ziranbar','$code_kala_','$code_keshvar_','$code_tolidkonande_','$sal_tolid_shamsi','$mah_tolid_shamsi','$rouz_tolid_shamsi','$sal_tolid_milady','$mah_tolid_milady','$rouz_tolid_milady','$code_bastebandy_','$code_karton','$vazn_karton_this','".$code_mandegari."',0,0,0,0,0,'$tedad_karton_r_d_sub','$vazn_nakhales_r_d_sub','$vazn_khales_r_d_sub','$tedad_shane_r_d_sub','0')");
        $insert_mojody_res=mysql_query($insert_mojody_q);
        /*لاگ موجودی*/
		$max_id_mojody=$db->get_from_where("MAX(id)","$mydatabase.$TableMojody","code_kala='$code_kala_' AND code_keshvar='$code_keshvar_' AND code_tolidkonande='$code_tolidkonande_' AND sal_tolid_shamsi='$sal_tolid_shamsi' AND mah_tolid_shamsi='$mah_tolid_shamsi' AND rouz_tolid_shamsi='$rouz_tolid_shamsi' AND code_karton='$code_karton' AND code_mandegari='$code_mandegari' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND code_ziranbar='$code_ziranbar' AND year='$mtActiveYear'");     
		$log_m_i=$db->query("INSERT INTO $mydatabase.log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','mojody_kala_gomrok','$max_id_mojody','ایجاد جزئیات کالا در رسید وایجاد یک سطر در جدول موجودی',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')");
	  }
	  if(($insert_kala_res and $log_i and $res_update_khales_d and $res_update_khales and $update_mojody_res)or($insert_kala_res and $log_i and $res_update_khales_d and $res_update_khales and $insert_mojody_res and $log_m_i)) 
	  {
	   mysql_query("COMMIT");
	   if(strlen($bz_gl_code_ostan)==1) $code_a=make_pattern($bz_gl_code_ostan,2); else $code_a=$bz_gl_code_ostan;
	   echo"
	   <script>
        //window.close();
	    window.opener.location='resid_detail.php?id_resid_=".$id_resid_."&shomare_resid_=".$shomare_resid_."&noe_tahvil_bar_=".$noe_tahvil_bar_."&code_bastebandy_=".$code_bastebandy_."&PageNo=".$PageNo."&RowPerPage=".$RowPerPage."&order=".$order."';
	   </script>";   
	  }
	  else  
      {
       mysql_query('ROLLBACK');//nothing will be done, I assume it's for testing
       echo "<script>alert('مشکلی در ثبت رسید به وجود آمده است')</script>";  
      }
	  mysql_query('SET AUTOCOMMIT=1'); 
 }
}
/************اجازه براي ذخيره اطلاعات************/
function isPermitEdit($noe_t_b,$code_baste,$code_zir_a,$sal_t_sh,$mah_t_sh,$rouz_t_sh,$c_karton,$tedad_k,$vazn_na,$vazn_kh,$sh_r,$c_kala,$c_keshvar,$c_tolid,$gl_c_o,$gl_c_s,$gl_year)
{
    //echo"<script> alert('$code_zir_a')</script>";
 $flag=false;
 //گروه کالا
 $q_gr="SELECT code_group_kala_top FROM kala WHERE code_kala=$c_kala";
 $res_gr=mysql_query($q_gr);
 $row_gr=mysql_fetch_assoc($res_gr);
 //تاریخ تولید به فرمت تاریخ
 if(strlen($rouz_t_sh)==1) $rouz=make_pattern($rouz_t_sh,2);
 else $rouz=$rouz_t_sh; 
 if(strlen($mah_t_sh)==1) $mah=make_pattern($mah_t_sh,2);
 else $mah=$mah_t_sh;
 $tolid=$sal_t_sh.'/'.$mah.'/'.$rouz;
 $sum_resid=0;
 //مجموع رسیدهای استان که جابهجایی نباشند و از تاریخ 20 اسفند به بعد 
 //$resid_start_date='1394/12/20';
 //$q1_1="SELECT * FROM saghf_kharid WHERE '$date_resid' BETWEEN az_tarikh_etebar AND ta_tarikh_etebar AND code_ostan='$gl_c_o' AND code_group_kala_top=".$row_gr['code_group_kala_top']." AND deleted=0";
 // $res1_1=mysql_query($q1_1);
 // $row1_1=mysql_fetch_assoc($res1_1);
 // if(($code_baste==1)or($code_baste==3))//کارتن ولاشه
 // {
  // $q_residha="SELECT sum(vazn_khales_r_d_sub)AS SUMRESID FROM resid_kala_detail INNER JOIN kala ON kala.code_kala=resid_kala_detail.code_kala INNER JOIN resid ON resid.shomare_resid=resid_kala_detail.shomare_resid AND resid.code_ostan=resid_kala_detail.code_ostan AND resid.code_anbar=resid_kala_detail.code_anbar AND resid.year=resid_kala_detail.year WHERE resid_kala_detail.code_ostan=$gl_c_o AND resid_kala_detail.resid_deleted=0 AND resid_kala_detail.status=0 AND resid_kala_detail.year=$gl_year AND code_group_kala_top=".$row_gr['code_group_kala_top']." AND tarikh_resid BETWEEN '".$row1_1['az_tarikh_etebar']."' AND '".$row1_1['ta_tarikh_etebar']."' AND noe_tahvil_bar!=4 AND noe_tahvil_bar!=5";
  // $res_residha=mysql_query($q_residha);
  // $row_residha=mysql_fetch_assoc($res_residha);
  // $sum_resid=round($row_residha['SUMRESID']+$vazn_kh,3);
 // }
 // if($code_baste==2)//قوطی
 // {
  // $q_residha="SELECT sum(tedad_karton_r_d_sub)AS SUMRESID FROM resid_kala_detail INNER JOIN kala ON kala.code_kala=resid_kala_detail.code_kala INNER JOIN resid ON resid.shomare_resid=resid_kala_detail.shomare_resid AND resid.code_ostan=resid_kala_detail.code_ostan AND resid.code_anbar=resid_kala_detail.code_anbar AND resid.year=resid_kala_detail.year WHERE resid_kala_detail.code_ostan=$gl_c_o AND resid_kala_detail.resid_deleted=0 AND resid_kala_detail.status=0 AND resid_kala_detail.year=$gl_year AND code_group_kala_top=".$row_gr['code_group_kala_top']." AND tarikh_resid BETWEEN '".$row1_1['az_tarikh_etebar']."' AND '".$row1_1['ta_tarikh_etebar']."' AND noe_tahvil_bar!=4 AND noe_tahvil_bar!=5";
  // $res_residha=mysql_query($q_residha);
  // $row_residha=mysql_fetch_assoc($res_residha);
  // $sum_resid=$row_residha['SUMRESID']+$tedad_k;
 // }
 if(!($gl_c_o and $gl_c_s and $gl_year) or $gl_c_o==-1 or $gl_c_s==-1)//اگر سشن استان و انبار وسال خالی بود
 {   
   $flag=false;
   echo"<script> alert('لطفاً استان و انبار و سال مورد نظر خود را انتخاب نمایید!')</script>";
   return $flag;
 }
 else $flag=true;
 if(!($code_zir_a and $sal_t_sh and $mah_t_sh and $rouz_t_sh and $tedad_k))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script> alert('لطفا تمام فيلد ها را تکميل نماييد')</script>";
   return $flag;
 } 
 else $flag=true;
 if((($code_baste==1)or($code_baste==2)) and (!$c_karton))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script> alert('لطفا تمام فيلد ها را تکميل نماييد')</script>";
   return $flag;
 } 
 else $flag=true;
 if(($code_baste==1) and (!$vazn_na))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script> alert('لطفا تمام فيلد ها را تکميل نماييد')</script>";
   return $flag;
 } 
 else $flag=true;
 // if(($code_baste!=2) and (($noe_t_b==1)or($noe_t_b==4)))//
 // {
   // if($code_baste==1)$q1="SELECT SUM(vazn_nakhales_r_d_sub) FROM resid_kala_detail WHERE code_ostan=$gl_c_o AND code_anbar=$gl_c_s AND shomare_resid='$sh_r' AND year=$gl_year";
   // if($code_baste==3)$q1="SELECT SUM(vazn_khales_r_d_sub) FROM resid_kala_detail WHERE code_ostan=$gl_c_o AND code_anbar=$gl_c_s AND shomare_resid='$sh_r' AND year=$gl_year";
   // $res1=mysql_query($q1);
   // $row1=mysql_fetch_array($res1);
   // if($code_baste==1) $sum_vazn=$row1[0]+$vazn_na;
   // if($code_baste==3) $sum_vazn=$row1[0]+$vazn_kh;
   // $sum_vazn=round($sum_vazn,3);
   // $q2="SELECT vazn_kamiyon_bar,vazn_kamiyon FROM resid WHERE code_ostan=$gl_c_o AND code_anbar=$gl_c_s AND shomare_resid='$sh_r' AND year=$gl_year";
   // $res2=mysql_query($q2);
   // $row2=mysql_fetch_assoc($res2);
   // $diffrent=$row2['vazn_kamiyon_bar']-$row2['vazn_kamiyon'];
   // $diffrent=round($diffrent,3);
   // if($diffrent<$sum_vazn)
   // {
     // if($code_baste==1)echo"<script>alert('این مقدار وزن ناخالص از اختلاف وزن کامیون بیشتر است و قابل ثبت نیست!')</script>";
     // if($code_baste==3)echo"<script>alert('این مقدار وزن خالص از اختلاف وزن کامیون بیشتر است و قابل ثبت نیست!')</script>";
     // $flag=false;
     // return $flag;
   // }
   // else $flag=true;
 // } 
 // else $flag=true;
 if((!empty($sal_t_sh)) and (!empty($mah_t_sh)) and (!empty($rouz_t_sh))) //تکراری نبودن تاریخ
 {
   $q8="SELECT * FROM resid_kala_detail WHERE shomare_resid='$sh_r' AND code_kala='$c_kala' AND code_keshvar='$c_keshvar' AND code_tolidkonande='$c_tolid' AND sal_tolid_shamsi='$sal_t_sh' AND mah_tolid_shamsi='$mah_t_sh' AND rouz_tolid_shamsi='$rouz_t_sh' AND code_karton='$c_karton' AND code_ostan='$gl_c_o' AND code_ziranbar='$code_zir_a' AND code_anbar='$gl_c_s' AND year='$gl_year'"; 
   $res8=mysql_query($q8);
   // if(mysql_num_rows($res8)>0){
   // echo"<script>alert('این تاریخ تولید را قبلاً برای این کالا ثبت کرده اید !')</script>";
   // $flag=false;
   // return $flag;
  // }
  // else $flag=true;
  ////
 }
 else $flag=true;
return $flag;
}
/*************EDIT BUTTON******/// ثبت اطلاعات    
if(isset($Edit_x_sublevel))
{
 if(isPermitEdit($noe_tahvil_bar_,$code_bastebandy_,$code_ziranbar,$sal_tolid_shamsi,$mah_tolid_shamsi,$rouz_tolid_shamsi,$code_karton,$tedad_karton_r_d_sub,$vazn_nakhales_r_d_sub,$vazn_khales_r_d_sub,$shomare_resid_,$code_kala_,$code_keshvar_,$code_tolidkonande_,$mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear)) 
 {
    //انتخاب جدول موجودی
	IF($noe_tahvil_bar_==9)$TableMojody='mojody_kala_gomrok';
	ELSE                   $TableMojody='mojody_kala';
	
	$Mode='';
    mysql_query('SET AUTOCOMMIT=0');//TRANSACTIONشروع 
    mysql_query('START TRANSACTION');
	$vazn_karton_this=$db->get_from_where("vazn_karton","karton","code_karton='$code_karton' AND code_bastebandy='$code_bastebandy_'");     
	//محاسبات برای اطمینان
    if($code_bastebandy_==1)//کارتنی
	{
	  IF($code_kala_==50) $tedad_shane_r_d_sub=$sum_karton_r_d_sub*$_SESSION["mtShane"];
	  ELSE IF($code_kala_==54) $tedad_shane_r_d_sub=$sum_karton_r_d_sub*$_SESSION["mtShane_dakheli"];
	  $sum_karton_r_d_sub=round(floatval($vazn_karton_this*$tedad_karton_r_d_sub),3);  
	  $vazn_khales_r_d_sub=round(floatval($vazn_nakhales_r_d_sub-$sum_karton_r_d_sub),3);
	  if($vazn_khales_r_d_sub<0) $vazn_khales_r_d_sub=0;
	}
    //قوطی	
	if($code_bastebandy_==2) $vazn_khales_r_d_sub=round(floatval($vazn_karton_this*$tedad_karton_r_d_sub),3);
	$edit_kala_q=("UPDATE $TableName SET vazn_karton_this='$vazn_karton_this',sum_karton_r_d_sub='$sum_karton_r_d_sub',tedad_karton_r_d_sub='$tedad_karton_r_d_sub',vazn_nakhales_r_d_sub='$vazn_nakhales_r_d_sub',vazn_khales_r_d_sub='$vazn_khales_r_d_sub',tedad_shane_r_d_sub='$tedad_shane_r_d_sub',tedad_joje_r_d_sub='$tedad_joje_r_d_sub' WHERE `id`='$id_';");	
    $edit_kala_res=mysql_query($edit_kala_q);
    $log_e=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_','ویرایش',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')");  
	/**********************************/ 
	// آپدیت وزن خالص در resid_detail 
	   $vazn_khales_r_d=$db->get_from_where("SUM(vazn_khales_r_d_sub)","resid_kala_detail","shomare_resid='$shomare_resid_' AND code_kala=$code_kala_ AND code_keshvar=$code_keshvar_ and code_tolidkonande=$code_tolidkonande_ AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND resid_deleted=0 AND status=0 GROUP BY code_kala,code_keshvar,code_tolidkonande");   
    //echo"<script>alert($vazn_khales_r_d)</script>";
	   $update_vazn_khales_r_d=round(floatval($vazn_khales_r_d),3);
       $res_update_khales_d=$db->query("UPDATE resid_detail SET vazn_khales_r_d='$update_vazn_khales_r_d' WHERE shomare_resid='$shomare_resid_' AND code_kala='$code_kala_' AND code_keshvar='$code_keshvar_' AND  code_tolidkonande='$code_tolidkonande_' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND resid_deleted=0");          
	// آپدیت تعداد کارتن و وزن ناخالص و وزن خالص در رسید 
	   $tedad_karton_r=$db->get_from_where("SUM(tedad_karton_r_d_sub)","resid_kala_detail","shomare_resid='$shomare_resid_' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND resid_deleted=0 AND status=0");   
	   $vazn_nakhales_r=$db->get_from_where("SUM(vazn_nakhales_r_d_sub)","resid_kala_detail","shomare_resid='$shomare_resid_' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND resid_deleted=0 AND status=0");   
	   $vazn_khales_r=$db->get_from_where("SUM(vazn_khales_r_d_sub)","resid_kala_detail","shomare_resid='$shomare_resid_' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND resid_deleted=0 AND status=0");   
	   $update_tedad_karton_r=$tedad_karton_r;
	   $update_vazn_nakhales_r=round(floatval($vazn_nakhales_r),3);
	   $update_vazn_khales_r=round(floatval($vazn_khales_r),3);
       $res_update_khales=$db->query("UPDATE resid SET tedad_karton_r='$update_tedad_karton_r',vazn_nakhales_r='$update_vazn_nakhales_r',vazn_khales_r='$update_vazn_khales_r' WHERE shomare_resid='$shomare_resid_' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0");       
	  /*آپدیت موجودی*/
	   IF($noe_tahvil_bar_==9)
	   {
	    $update_tedad_karton=mojodyKarton($mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear,$code_ziranbar,$code_kala_,$code_keshvar_,$code_tolidkonande_,$sal_tolid_shamsi,$mah_tolid_shamsi,$rouz_tolid_shamsi,$code_karton,$code_mandegari,2);
	    $update_mojody_nakhales=mojodyNakhales($mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear,$code_ziranbar,$code_kala_,$code_keshvar_,$code_tolidkonande_,$sal_tolid_shamsi,$mah_tolid_shamsi,$rouz_tolid_shamsi,$code_karton,$code_mandegari,2);
	    $update_mojody_khales=mojodyKhales($mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear,$code_ziranbar,$code_kala_,$code_keshvar_,$code_tolidkonande_,$sal_tolid_shamsi,$mah_tolid_shamsi,$rouz_tolid_shamsi,$code_karton,$code_mandegari,2);  
       }
	   ELSE
	   {
	   	$update_tedad_karton=mojodyKarton($mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear,$code_ziranbar,$code_kala_,$code_keshvar_,$code_tolidkonande_,$sal_tolid_shamsi,$mah_tolid_shamsi,$rouz_tolid_shamsi,$code_karton,$code_mandegari);
	    $update_mojody_nakhales=mojodyNakhales($mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear,$code_ziranbar,$code_kala_,$code_keshvar_,$code_tolidkonande_,$sal_tolid_shamsi,$mah_tolid_shamsi,$rouz_tolid_shamsi,$code_karton,$code_mandegari);
	    $update_mojody_khales=mojodyKhales($mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear,$code_ziranbar,$code_kala_,$code_keshvar_,$code_tolidkonande_,$sal_tolid_shamsi,$mah_tolid_shamsi,$rouz_tolid_shamsi,$code_karton,$code_mandegari);  
       }
	   
	   $update_tedad_shane=$update_tedad_karton*$_SESSION["mtShane"];
	   $update_tedad_joje=mojodyJoje($mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear,$code_ziranbar,$code_kala_,$code_keshvar_,$code_tolidkonande_,$sal_tolid_shamsi,$mah_tolid_shamsi,$rouz_tolid_shamsi,$code_karton); 
	   //$update_tedad_joje=$update_tedad_joje_befor+$tedad_joje_r_d_sub;
	   $update_mojody_res=$db->query("UPDATE $TableMojody SET mojody_khales='$update_mojody_khales',mojody_nakhales='$update_mojody_nakhales',tedad_karton='$update_tedad_karton',tedad_shane='$update_tedad_shane',tedad_joje='$update_tedad_joje' WHERE code_ziranbar='$code_ziranbar' AND code_kala='$code_kala_' AND code_keshvar='$code_keshvar_' AND code_tolidkonande='$code_tolidkonande_' AND sal_tolid_shamsi='$sal_tolid_shamsi' AND mah_tolid_shamsi='$mah_tolid_shamsi' AND rouz_tolid_shamsi='$rouz_tolid_shamsi' AND code_karton='$code_karton' AND code_mandegari='".$code_mandegari."' AND code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND year=$mtActiveYear AND deleted=0");  
           //echo"<script>alert($update_tedad_joje)</script>";
           //echo"<script>alert($update_mojody_nakhales)</script>";
           //echo"<script>alert($update_mojody_khales)</script>";
      if(($edit_kala_res and $log_e and $res_update_khales_d and $res_update_khales and $update_mojody_res)) 
	  {
	   mysql_query("COMMIT");
	   if(strlen($bz_gl_code_ostan)==1) $code_a=make_pattern($bz_gl_code_ostan,2); else $code_a=$bz_gl_code_ostan;
	   echo"
	   <script>
        //window.close();
	    window.opener.location='resid_detail.php?id_resid_=".$id_resid_."&shomare_resid_=".$shomare_resid_."&noe_tahvil_bar_=".$noe_tahvil_bar_."&code_bastebandy_=".$code_bastebandy_."&PageNo=".$PageNo."&RowPerPage=".$RowPerPage."&order=".$order."';
	   </script>";   
	  }
	  else  
      {
       mysql_query('ROLLBACK');//nothing will be done, I assume it's for testing
       echo "<script>alert('مشکلی در ثبت رسید به وجود آمده است')</script>";  
      }
	  mysql_query('SET AUTOCOMMIT=1'); 
 }
}
/************DELETE BUTTON********/// حذف اطلاعات
if(isset($Delete_x_sublevel))
{
 
  //انتخاب جدول موجودی
  IF($noe_tahvil_bar_==9)$TableMojody='mojody_kala_gomrok';
  ELSE                   $TableMojody='mojody_kala';	
  $Mode='';
 // echo "<script>alert($code_kala__)</script>";
 // echo "<script>alert('$tedad_karton_r_d_sub_')</script>";
  mysql_query('SET AUTOCOMMIT=0');//TRANSACTIONشروع 
  mysql_query('START TRANSACTION');
  $del_q="DELETE FROM $TableName WHERE id=$id_";
  $del_res = mysql_query($del_q);
  /*لاگ*/$log_d=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_','حذف',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')");
  // آپدیت وزن خالص در resid_detail 
	   $vazn_khales_r_d=$db->get_from_where("vazn_khales_r_d","resid_detail","shomare_resid='$shomare_resid__' AND code_kala='$code_kala__' AND code_keshvar='$code_keshvar__' AND code_tolidkonande='$code_tolidkonande__' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND resid_deleted=0 AND status=0");   
       $update_vazn_khales_r_d=round(floatval($vazn_khales_r_d-$vazn_khales_r_d_sub_),3);
       $res_update_khales_d=$db->query("UPDATE resid_detail SET vazn_khales_r_d='$update_vazn_khales_r_d' WHERE shomare_resid='$shomare_resid__' AND code_kala='$code_kala__' AND code_keshvar='$code_keshvar__' AND code_tolidkonande='$code_tolidkonande__' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND resid_deleted=0");
	// آپدیت تعداد کارتن و وزن ناخالص و وزن خالص در رسید 
	   $tedad_karton_r=$db->get_from_where("tedad_karton_r","resid","shomare_resid='$shomare_resid__' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0 AND status=0");   
	   $vazn_nakhales_r=$db->get_from_where("vazn_nakhales_r","resid","shomare_resid='$shomare_resid__' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0 AND status=0");   
	   $vazn_khales_r=$db->get_from_where("vazn_khales_r","resid","shomare_resid='$shomare_resid__' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0 AND status=0");   
	   $update_tedad_karton_r=$tedad_karton_r-$tedad_karton_r_d_sub_;
	   $update_vazn_nakhales_r=round(floatval($vazn_nakhales_r-$vazn_nakhales_r_d_sub_),3);
	   $update_vazn_khales_r=round(floatval($vazn_khales_r-$vazn_khales_r_d_sub_),3);
       $res_update_khales=$db->query("UPDATE resid SET tedad_karton_r='$update_tedad_karton_r',vazn_nakhales_r='$update_vazn_nakhales_r',vazn_khales_r='$update_vazn_khales_r' WHERE shomare_resid='$shomare_resid__' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0");       
      //موجودی با تابع
	   IF($noe_tahvil_bar_==9)
	   {   
	    $update_tedad_karton=mojodyKarton($mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear,$code_ziranbar_,$code_kala__,$code_keshvar__,$code_tolidkonande__,$sal_tolid_shamsi_,$mah_tolid_shamsi_,$rouz_tolid_shamsi_,$code_karton_,$code_mandegari_,2);
	    $update_mojody_nakhales=mojodyNakhales($mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear,$code_ziranbar_,$code_kala__,$code_keshvar__,$code_tolidkonande__,$sal_tolid_shamsi_,$mah_tolid_shamsi_,$rouz_tolid_shamsi_,$code_karton_,$code_mandegari_,2);
	    $update_mojody_khales=mojodyKhales($mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear,$code_ziranbar_,$code_kala__,$code_keshvar__,$code_tolidkonande__,$sal_tolid_shamsi_,$mah_tolid_shamsi_,$rouz_tolid_shamsi_,$code_karton_,$code_mandegari_,2);  
	   }
       ELSE
	   {		   
		$update_tedad_karton=mojodyKarton($mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear,$code_ziranbar_,$code_kala__,$code_keshvar__,$code_tolidkonande__,$sal_tolid_shamsi_,$mah_tolid_shamsi_,$rouz_tolid_shamsi_,$code_karton_,$code_mandegari_,2);
	    $update_mojody_nakhales=mojodyNakhales($mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear,$code_ziranbar_,$code_kala__,$code_keshvar__,$code_tolidkonande__,$sal_tolid_shamsi_,$mah_tolid_shamsi_,$rouz_tolid_shamsi_,$code_karton_,$code_mandegari_,2);
	    $update_mojody_khales=mojodyKhales($mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear,$code_ziranbar_,$code_kala__,$code_keshvar__,$code_tolidkonande__,$sal_tolid_shamsi_,$mah_tolid_shamsi_,$rouz_tolid_shamsi_,$code_karton_,$code_mandegari_,2);  
	   }
	  //آپدیت موجودی کالا
	   $update_mojody_res=$db->query("UPDATE $TableMojody SET mojody_khales=$update_mojody_khales,mojody_nakhales=$update_mojody_nakhales,tedad_karton=$update_tedad_karton WHERE code_ziranbar='$code_ziranbar_' AND code_kala='$code_kala__' AND code_keshvar='$code_keshvar__' AND code_tolidkonande='$code_tolidkonande__' AND sal_tolid_shamsi='$sal_tolid_shamsi_' AND mah_tolid_shamsi='$mah_tolid_shamsi_' AND rouz_tolid_shamsi='$rouz_tolid_shamsi_' AND code_karton='$code_karton_' AND code_mandegari='".$code_mandegari_."' AND code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND year=$mtActiveYear AND deleted=0");      	
	   /*لاگ موجودی*/ //$log_m_d=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','mojody_kala_gomrok',".$row_m['id'].",'حذف جزئیات کالا در رسید و کاهش موجودی',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')");
	    if($del_res and $log_d and $res_update_khales_d and $res_update_khales and $update_mojody_res)
        {
          mysql_query("COMMIT"); 
	      echo"
	      <script>
           window.close();
	       window.opener.location='resid_detail.php?id_resid_=".$id_resid_."&shomare_resid_=".$shomare_resid__."&code_bastebandy_=".$code_bastebandy_."&PageNo=".$PageNo."&RowPerPage=".$RowPerPage."&order=".$order."';
	      </script>";
        }
        else
        {
	      mysql_query('ROLLBACK');//nothing will be done, I assume it's for testing
	      echo "<script>alert(' مشکلی در حذف به وجود آمده است ')</script>";  
        }
  mysql_query('SET AUTOCOMMIT=1');  		
}
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.code_ziranbar.focus();">
<form method="post" name="myform" id="myform" onkeydown="enterIE()">
<div align="center">
<table width="100%" height="100%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr>
  <td class="title">جزئیات کالای '.$row_detail['name_kala'].' در رسید شماره '.$code_a.$mt_gl_code_anbar.$row_detail['shomare_resid'].'
  </td>
  <td class="title">';
   if($Mode=='Insert') echo'<span style="color:white;float:left;font-size:12px;">توجه<img border="0" src="images/Info1.png" title="لطفاً در ثبت مقادیر دقت نمایید ، بعد از کلیک روی گزینه ثبت امکان ویرایش مقادیر وجود ندارد" style="cursor:pointer" onmouseOver="this.src=\'images/Info_h.png\'" onmouseOut="this.src=\'images/Info1.png\'"/></span>';
   echo'
  </td> 
 </tr>
 <!--پايان هدر-->
 <!-- مرکز صفحه-->
 <tr>
  <td height="100%" colspan="2">
  <table  width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
	<tr class="table-title">
	 <td width="8%" rowspan="2">نام زیرانبار</td>
	 <td width="24%" colspan="3">تاریخ تولید شمسی</td>
	 <td width="6%" rowspan="2">تاریخ ماندگاری</td>';
	 if($code_bastebandy_==1)//کارتنی
	 {echo'
	  <td width="10%" rowspan="2">کد کارتن</td>
	  <td width="5%" rowspan="2">وزن کارتن</td>
	  <td width="9%" rowspan="2">تعداد کارتن</td>
	  <td width="10%" rowspan="2">وزن کارتن ها</td>
	  <td width="10%" rowspan="2">وزن ناخالص</td>
	  <td width="8%" rowspan="2">وزن خالص</td>';
	 }
	 else if($code_bastebandy_==2)//قوطی
	 {echo'
	  <td width="15%" rowspan="2">کد قوطی</td>
	  <td width="10%" rowspan="2">وزن قوطی</td>
	  <td width="14%" rowspan="2">تعداد قوطی</td>
	  <td width="13%" rowspan="2">وزن خالص</td>';
	 }
	 else if(($code_bastebandy_==5)OR($code_bastebandy_==6))//دست یا عدد
	 {
	  echo'<td width="%" rowspan="2">تعداد</td>';
	  if($code_kala_==55) echo'<td width="%" rowspan="2">تعداد جوجه</td>';
	 }
	 else //لاشه و سایر
	 {echo'
	  <td width="24%" rowspan="2">تعداد</td>
	  <td width="28%" rowspan="2">وزن خالص</td>';
	 }
	 if($Mode==NULL)
	 {
	   if((($right_del)and($noe_tahvil_bar_!=4)and($noe_tahvil_bar_!=5)and($noe_tahvil_bar_!=10)and($resid_status==0)and($_SESSION['mtStatusYear']==0)and($sabtNahayi==0))or((SuperUser())and($noe_tahvil_bar_!=4)and($noe_tahvil_bar_!=5)and($noe_tahvil_bar_!=10)and($resid_status==0)and($sabtNahayi==1)and(strlen($webserviceTrackcode)!=25)))echo'<td width="10%" rowspan="2">حذف</td>';
	   else echo'';
	 }
	 else if($Mode=='Edit'){if((($right_edt)and(($noe_tahvil_bar_==4)or($noe_tahvil_bar_==5))and($resid_status==0)and($_SESSION['mtStatusYear']==0)and($sabtNahayi==0))or(($right_edt)and($code_kala_==55)and($resid_status==0)and($_SESSION['mtStatusYear']==0))or((SuperUser())and($Mode='Edit')and(($noe_tahvil_bar_==4)or($noe_tahvil_bar_==5))and($resid_status==0)and($sabtNahayi==1)and(strlen($webserviceTrackcode)!=25)))echo'<td width="10%" rowspan="2">دستورات</td>';}

	 else echo'<td width="10%" rowspan="2">دستورات</td>';
	 echo'
	 <tr class="table-title">
	   <td width="%">سال</td>
	   <td width="%">ماه</td>
	   <td width="%">روز</td>
	  </tr>
	 ';
	if($Mode=='Insert' or $Mode=='Search')
	{
	 if ($Mode=='Insert') {$button_value="ايجاد"; $button_name="Insert_x_sublevel";} 
	 else {$button_value="جستجو"; $button_name="Search_x_sublevel";}
	  IF($noe_tahvil_bar_==9) $ziranbar_condition=" AND noe_ziranbar=2";//تحت کلید
	  ELSE $ziranbar_condition=" AND noe_ziranbar!=2";//سالن یا امانی
	  echo'
	  <tr class="table-odd">
		<td>'.listbox("code_ziranbar",$code_ziranbar,"code_ziranbar","name_ziranbar","list_sardkhane_detail","code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar $ziranbar_condition","class='text4'","").'</td>
		<td><input class="textboxme2" type="text" name="sal_tolid_shamsi" value="'.$sal_tolid_shamsi.'" maxlength="4" onkeypress="return isNumber(event)" placeholder=" '.$mtActiveYear.'" style="width:40px;"/>
		    <img border="0" src="images/Info1.png" title="لطفاً سال موردنظر خود را در 4 رقم وارد نمایید" onmouseOver="this.src=\'images/Info_h.png\'" onmouseOut="this.src=\'images/Info1.png\'" style="width:16px;height:16px;cursor:pointer"/></td>
		<td>'.static_listbox("mah_tolid_shamsi",$mah_tolid_shamsi,"mahshamsiArr",1,"class='text4'").'</td>
		<td><input class="textboxme textbox50" type="text" name="rouz_tolid_shamsi" value="'.$rouz_tolid_shamsi.'" maxlength="2" onkeypress="return isNumber(event)"/></td>';
	    //تاریخ ماندگاری مربوط به کالا
		$q_mandegari="SELECT mandegari FROM kala WHERE code_kala='$code_kala_'";
		$res_mandegari=mysql_query($q_mandegari);
		$row_mandegari=mysql_fetch_assoc($res_mandegari);
		$mandegariarray=explode(';',$row_mandegari['mandegari']);
		if ($Mode=='Insert')
		{
		  //echo'<td>'.listboxMe("code_mandegari",$code_mandegari,"code_mandegari","sharh_mandegari","tarikh_mandegari","","class='text4'").'</td>';
	      //echo'<td>'.static_listbox("code_mandegari",$code_mandegari,"mandegariarray",1,"class='text4'").'</td>';
		  echo'		   
		   <td><select name="code_mandegari"  class="text4">';
	        $result_tm = $db->query("SELECT * FROM tarikh_mandegari ");
            while($row_tm=$db->fetch_assoc($result_tm))
		    {			   
			   IF (in_array($row_tm['code_mandegari'], $mandegariarray)) 
			     $tm_options .= "<option value='".$row_tm['code_mandegari']."' > ".$row_tm['sharh_mandegari']." </option>";
	        }
		    echo $tm_options;
	        echo'
	        </select></td>';
		}
		else echo'<td>'.listbox("code_mandegari",$code_mandegari,"code_mandegari","sharh_mandegari","tarikh_mandegari","","class='text4'").'</td>';
		if($code_bastebandy_==1)//کارتنی
		{echo'
		  <td><input type="text" class="textboxme textbox50" name="code_karton" id="code_karton" value="'.$code_karton.'" onfocus="getVaznKarton(this.value)" onblur="getVaznKarton(this.value)" onkeypress="return isNumber(event)"/>';
		   include('img_helpkarton.php');
          echo'		 
	   	  </td>
          <td><input class="textboxme2 textbox50" type="text" readonly name="vazn_karton_this" id="vazn_karton_this" value="'.$vazn_karton_this.'"/></td>
		  <td><input class="textboxme" type="text" name="tedad_karton_r_d_sub" value="'.$tedad_karton_r_d_sub.'" onblur="return sumkarton()" onkeypress="return isNumber(event)"/></td>
		  <td><input class="textboxme" readonly type="text" name="sum_karton_r_d_sub" value="'.$sum_karton_r_d_sub.'"/></td>       		
		  <td><input class="textboxme" type="text" name="vazn_nakhales_r_d_sub" value="'.$vazn_nakhales_r_d_sub.'" onblur="return vazn_khales()" onKeydown="return PressfloatOnly(event,this)"/></td>
		  <td><input class="textboxme" type="text" name="vazn_khales_r_d_sub" value="'.$vazn_khales_r_d_sub.'" readonly onfocus="return vazn_khales()"/></td>';
		}
	    else if($code_bastebandy_==2)//قوطی
		{
		 echo'
		  <td><input type="text" class="textboxme textbox50" name="code_karton" id="code_karton" value="'.$code_karton.'" onfocus="getVaznGHooti(this.value)" onblur="getVaznGHooti(this.value)" onkeypress="return isNumber(event)"/>&nbsp;';
		   include('img_helpghooti.php');
          echo'		 
	   	  </td>
          <td><input class="textboxme2 textbox50" type="text" readonly name="vazn_karton_this" id="vazn_karton_this" value="'.$vazn_karton_this.'"/></td>
		  <td><input class="textboxme" type="text" name="tedad_karton_r_d_sub" value="'.$tedad_karton_r_d_sub.'" onblur="return sumghooti()" onkeypress="return isNumber(event)"/></td>
		  <td><input class="textboxme" type="text" name="vazn_khales_r_d_sub" value="'.$vazn_khales_r_d_sub.'" readonly onfocus="return vazn_khales()"/></td>';
		}
	    else if(($code_bastebandy_==5)OR($code_bastebandy_==6))//دست یا عدد
		{
		 echo'<td><input class="textboxme" type="text" name="tedad_karton_r_d_sub" value="'.$tedad_karton_r_d_sub.'" onkeypress="return isNumber(event)"/></td>';
		 if($code_kala_==55) echo'<td>-</td>';
		}
	    else //لاشه و سایر
		{
		 echo'
		  <td><input class="textboxme" type="text" name="tedad_karton_r_d_sub" value="'.$tedad_karton_r_d_sub.'" onkeypress="return isNumber(event)"/></td>
		  <td><input class="textboxme" type="text" name="vazn_khales_r_d_sub" value="'.$vazn_khales_r_d_sub.'" onKeydown="return PressfloatOnly(event,this)"/></td>';
		}
	   echo'	
	   <td><input type="submit" class="buttonme" name="'.$button_name.'" id="sabt" value="'.$button_value.'"/>
		   <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?r_d_id_='.$r_d_id_.'&code_bastebandy_='.$code_bastebandy_.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" />
	   </td>
	  </tr>';
	}
	$i=0;
	$q_d_kala="SELECT T.*,l_s_d.name_ziranbar,sharh_mandegari From $TableName T INNER JOIN list_sardkhane_detail l_s_d ON l_s_d.code_ziranbar=T.code_ziranbar AND l_s_d.code_ostan=T.code_ostan AND l_s_d.code_anbar=T.code_anbar INNER JOIN tarikh_mandegari ON T.code_mandegari=tarikh_mandegari.code_mandegari WHERE T.shomare_resid='".$row_detail['shomare_resid']."' AND T.code_kala='".$row_detail['code_kala']."' AND T.code_keshvar='".$row_detail['code_keshvar']."' AND T.code_tolidkonande='".$row_detail['code_tolidkonande']."' AND T.code_ostan=$mt_gl_code_ostan AND T.code_anbar=$mt_gl_code_anbar AND T.year=$mtActiveYear order by id DESC";		  		  
	$all_d_kala = $db->query($q_d_kala);
    while($row_d_kala=$db->fetch_assoc($all_d_kala))
	{
     if((($right_edt)and($noe_tahvil_bar_==4 or $noe_tahvil_bar_==5)and($sabtNahayi==0))OR(($right_edt)and($code_kala_==55)))
	 {$edtClick='onClick="window.location=\''.$FileName.'?Mode=Edit&id_='.$row_d_kala['id'].'&shomare_resid_='.$shomare_resid_.'&r_d_id_='.$r_d_id_.'&code_bastebandy_='.$code_bastebandy_.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'"';}	 
	 if($i++%2){echo'<tr '; if($row_d_kala['status']==0) echo' class="print_table-odd"'; else echo 'class="row-ebtal"';echo'>';}	 
	 else{echo'<tr '; if($row_d_kala['status']==0) echo' class="table-even"'; else echo 'class="row-ebtal"';echo'>';}
	 if($Mode=='Edit' and $row_d_kala['id']==$id_)
	 {
	  echo'
	   <td>'.$row_d_kala['name_ziranbar'].'<input type="hidden" name="code_ziranbar" value="'.$row_d_kala['code_ziranbar'].'" /></td> 
	   <td>'.$row_d_kala['sal_tolid_shamsi'].'<input type="hidden" name="sal_tolid_shamsi" value="'.$row_d_kala['sal_tolid_shamsi'].'" /></td> 
	   <td>'.$mahshamsiArr[$row_d_kala['mah_tolid_shamsi']].'<input type="hidden" name="mah_tolid_shamsi" value="'.$row_d_kala['mah_tolid_shamsi'].'" /></td>
	   <td>'.$row_d_kala['rouz_tolid_shamsi'].'<input type="hidden" name="rouz_tolid_shamsi" value="'.$row_d_kala['rouz_tolid_shamsi'].'" /></td>
       <td>'.$row_d_kala['sharh_mandegari'].'<input type="hidden" name="code_mandegari" value="'.$row_d_kala['code_mandegari'].'" /></td>'; 
	   //if($code_bastebandy_!=3)
       if(($code_bastebandy_==1)OR($code_bastebandy_==2))
	   echo'	  
	   <td>'.$row_d_kala['code_karton'].'<input type="hidden" name="code_karton" value="'.$row_d_kala['code_karton'].'" /></td> 
	   <td>'.$row_d_kala['vazn_karton_this'].'<input type="hidden" name="vazn_karton_this" value="'.$row_d_kala['vazn_karton_this'].'" /></td>';
	    if($code_bastebandy_==1)//کارتنی
		{echo'
		  <td><input class="textboxme" type="text" name="tedad_karton_r_d_sub" value="'.$row_d_kala['tedad_karton_r_d_sub'].'" onblur="return sumkarton()" onkeypress="return isNumber(event)"/></td>
		  <td><input class="textboxme" readonly type="text" name="sum_karton_r_d_sub" value="'.$row_d_kala['sum_karton_r_d_sub'].'"/></td>       		
		  <td><input class="textboxme" type="text" name="vazn_nakhales_r_d_sub" value="'.$row_d_kala['vazn_nakhales_r_d_sub'].'" onblur="return vazn_khales()" onKeydown="return PressfloatOnly(event,this)"/></td>
		  <td><input class="textboxme" type="text" name="vazn_khales_r_d_sub" value="'.$row_d_kala['vazn_khales_r_d_sub'].'" readonly onfocus="return vazn_khales()"/></td>';
		}
	    else if($code_bastebandy_==2)//قوطی
		{
		 echo'
		  <td><input class="textboxme" type="text" name="tedad_karton_r_d_sub" value="'.$row_d_kala['tedad_karton_r_d_sub'].'" onblur="return sumghooti()" onkeypress="return isNumber(event)"/></td>
		  <td><input class="textboxme" type="text" name="vazn_khales_r_d_sub" value="'.$row_d_kala['vazn_khales_r_d_sub'].'" readonly onfocus="return vazn_khales()"/></td>';
		}
	    else if(($code_bastebandy_==5)OR($code_bastebandy_==6))//دست یا عدد
		{
		 echo'<td><input class="textboxme" type="text" name="tedad_karton_r_d_sub" value="'.$row_d_kala['tedad_karton_r_d_sub'].'"'; IF(($sabtNahayi==1)AND($code_kala_==55)) echo 'readonly'; echo' onkeypress="return isNumber(event)"/></td>';
		 echo'<td><input class="textboxme" type="text" name="tedad_joje_r_d_sub" value="'.$row_d_kala['tedad_joje_r_d_sub'].'" onkeypress="return isNumber(event)"/></td>';
		}
	    else //لاشه و سایر
		{
		 echo'
		  <td><input class="textboxme" type="text" name="tedad_karton_r_d_sub" value="'.$row_d_kala['tedad_karton_r_d_sub'].'" onkeypress="return isNumber(event)"/></td>
		  <td><input class="textboxme" type="text" name="vazn_khales_r_d_sub" value="'.$row_d_kala['vazn_khales_r_d_sub'].'" onKeydown="return PressfloatOnly(event,this)"/></td>';
		}
	   echo'	
	   <td>
	    <input class="buttonme" type="submit" name="Edit_x_sublevel" id="sabt" value="ثبت تغييرات"/>
	    <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?r_d_id_='.$r_d_id_.'&code_bastebandy_='.$code_bastebandy_.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'"/>
	  </td>';
	 }
     else
     {echo'
	  <td '.$edtClick.'>'.$row_d_kala['name_ziranbar'].'</td> 
	  <td '.$edtClick.'>'.$row_d_kala['sal_tolid_shamsi'].'</td> 
	  <td '.$edtClick.'>'.$mahshamsiArr[$row_d_kala['mah_tolid_shamsi']].'</td>
	  <td '.$edtClick.'>'.$row_d_kala['rouz_tolid_shamsi'].'</td>
	  <td '.$edtClick.'>'.$row_d_kala['sharh_mandegari'].'</td>';
      //if($code_bastebandy_!=3)
	  if(($code_bastebandy_==1)OR($code_bastebandy_==2))  
      {echo'	  
	  <td '.$edtClick.'>'.$row_d_kala['code_karton'].'</td> 
	  <td '.$edtClick.'>'.$row_d_kala['vazn_karton_this'].'</td>';
	  }
	  echo'
	  <td '.$edtClick.'>'.$row_d_kala['tedad_karton_r_d_sub'].'</td>';
      if($code_kala_==55) echo'<td '.$edtClick.'>'.$row_d_kala['tedad_joje_r_d_sub'].'</td>';
	  if($code_bastebandy_==1)//کارتنی
	  {echo'	  
	   <td '.$edtClick.'>'.round($row_d_kala['sum_karton_r_d_sub'],3).'</td>
	   <td '.$edtClick.'>'.round($row_d_kala['vazn_nakhales_r_d_sub'],3).'</td>';
	  }
	  if(($code_bastebandy_!=5)AND($code_bastebandy_!=6))//به غیر از دست یا عدد
	   echo'<td '.$edtClick.'>'.round($row_d_kala['vazn_khales_r_d_sub'],3).'</td>';
	  //اگر اجازه حذف داردو ابطالی نیست و سال فعال است و ثبت نهایی نشده
	  //یاسوپریوزر است و ابطالی نیست و ثبت نهایی شده و در وب سرویس ثبت نشده است
	  if((($right_del)and($noe_tahvil_bar_!=4)and($noe_tahvil_bar_!=5)and($noe_tahvil_bar_!=10)and($row_d_kala['status']==0)and($_SESSION['mtStatusYear']==0)and($sabtNahayi==0))or((SuperUser())and($noe_tahvil_bar_!=4)and($noe_tahvil_bar_!=5)and($noe_tahvil_bar_!=10)and($resid_status==0)and($sabtNahayi==1)and(strlen($webserviceTrackcode)!=25)))
	  {echo'<td><img border="0" src="images/trash.png" width="20" height="20" title="حذف"
	       onmouseOver="this.src=\'images/trash_hover.png\'" 
		   onmouseOut="this.src=\'images/trash.png\'" 	  
	       onClick="iconfirm(\''.$FileName.'?Delete_x_sublevel=1&id_='.$row_d_kala['id'].'&shomare_resid__='.$shomare_resid_.'&code_ziranbar_='.$row_d_kala['code_ziranbar'].'&code_kala__='.$code_kala_.'&code_keshvar__='.$code_keshvar_.'&code_tolidkonande__='.$code_tolidkonande_.'&sal_tolid_shamsi_='.$row_d_kala['sal_tolid_shamsi'].'&mah_tolid_shamsi_='.$row_d_kala['mah_tolid_shamsi'].'&rouz_tolid_shamsi_='.$row_d_kala['rouz_tolid_shamsi'].'&code_karton_='.$row_d_kala['code_karton'].'&code_mandegari_='.$row_d_kala['code_mandegari'].'&vazn_nakhales_r_d_sub_='.$row_d_kala['vazn_nakhales_r_d_sub'].'&tedad_karton_r_d_sub_='.$row_d_kala['tedad_karton_r_d_sub'].'&vazn_karton_this_='.$row_d_kala['vazn_karton_this'].'&vazn_khales_r_d_sub_='.$row_d_kala['vazn_khales_r_d_sub'].'&code_bastebandy_='.$code_bastebandy_.'&noe_tahvil_bar_='.$noe_tahvil_bar_.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\',\'برای حذف جزئیات کالای '.$row_detail['name_kala'].' با تاریخ تولید '.$row_d_kala['rouz_tolid_shamsi'].' - '.$mahshamsiArr[$row_d_kala['mah_tolid_shamsi']].' - '.$row_d_kala['sal_tolid_shamsi'].'  '.$row_d_kala['name'].' \')"/></td>';
	  }

	 }
	echo '
	</tr>';
	}
    for ($r=$i+1; $r<=$RowPerPage; $r++)
    {if($r%2) echo'
     <tr class="table-even">';
     else echo '
     <tr class="table-odd">';
     echo '
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>';
      if(($code_bastebandy_!=5)AND($code_bastebandy_!=6))echo'<td>&nbsp;</td>';
	  if(($code_bastebandy_==1)OR($code_bastebandy_==2)) echo'<td>&nbsp;</td><td>&nbsp;</td>';
	  if($code_bastebandy_==1)//کارتنی
	  {echo'
	   <td>&nbsp;</td>
	   <td>&nbsp;</td>';
	  }
	  if($code_kala_=55)echo'<td>&nbsp;</td>';
	  if((($right_del)and($noe_tahvil_bar_!=4)and($noe_tahvil_bar_!=5)and($noe_tahvil_bar_!=10)and($resid_status==0)and($_SESSION['mtStatusYear']==0)and($sabtNahayi==0))or((SuperUser())and($noe_tahvil_bar_!=4)and($noe_tahvil_bar_!=5)and($noe_tahvil_bar_!=10)and($resid_status==0)and($sabtNahayi==1)and(strlen($webserviceTrackcode)!=25)))echo'<td>&nbsp;</td>';
	  if($Mode=='Edit')
	  {
	 	  if((($right_edt)and(($noe_tahvil_bar_==4)or($noe_tahvil_bar_==5))and($resid_status==0)and($_SESSION['mtStatusYear']==0)and($sabtNahayi==0))or((SuperUser())and($Mode='Edit')and(($noe_tahvil_bar_==4)or($noe_tahvil_bar_==5))and($resid_status==0)and($sabtNahayi==1)and(strlen($webserviceTrackcode)!=25)))echo'<td>&nbsp;</td>';
      }
	  echo'
	 </tr>';
	}
	echo'
   </table>
  </td>
 </tr> 
 <!--پايان مرکز صفحه -->
 <!-- فوتر-->
 <tr class="footer">
  <td colspan="2">
   <table width="100%"  border="0" cellspacing="0" cellpadding="0" height=100%  style="margin-bottom:20px;">';
   if (!$Mode)
   {echo '	  			
	<tr>
	 <td width="10">&nbsp;</td>';
	 //اگر اجازه ایجاد رسید را دارد و رسید ابطالی نیست و وضعیت سال فعال است  و سال فعال سال جاری است و ثبت نهایی نشده است
	 //if(($right_ins)and($resid_status==0)and($_SESSION['mtStatusYear']==0)and($_SESSION["mtActiveYear"]==$yy)and($sabtNahayi==0))
	 if(($right_ins)and($noe_tahvil_bar_!=4)and($noe_tahvil_bar_!=5)and($noe_tahvil_bar_!=10)and($resid_status==0)and($_SESSION['mtStatusYear']==0)and($sabtNahayi==0))
	 {
	  echo'
	  <td width="70"><div onClick="window.location=\''.$FileName.'?Mode=Insert&r_d_id_='.$r_d_id_.'&code_bastebandy_='.$code_bastebandy_.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-new" title="افزودن رکورد جديد" ><a href="#"></a></div></td>
 	  <td width="10">&nbsp;</td>';}
	 $detailkalacount=$db->get_from_where("count(*)","resid_kala_detail","shomare_resid='".$shomare_resid_."' AND code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND year=$mtActiveYear");
	 // if(($resid_status==0)and($detailkalacount!=0)and($sabtNahayi==0))//اگررسید ابطالی نیست و جزئیات دارد و ثبت نهایی نشده است  
	 // {echo'
	  // <td width="70"><div onClick="window.location=\''.$FileName.'?r_d_id_='.$r_d_id_.'&code_bastebandy_='.$code_bastebandy_.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&send_resid=1&sabt_resid=1\'" id="sabt-nahayi" title="ثبت نهایی رسید" ><a href="#"></a></div></td>
	  // <td width="10">&nbsp;</td>';
	 // }
	 echo'
	 <td width="70%">&nbsp;</td>
     <td width="100px" style="color:#fff;" align="left"> تعداد ['.$cnt.']</td>
     <td width="10">&nbsp;</td>		 
	</tr>';
    }	
   echo'
   </table>
  </td>
 </tr>
 <!-- پايان فوتر-->	
</table>
</div>';
/********************END********************/	
echo'
'.$message .'
</form>
</body>
</html>';
?>