<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="transfer_havale_anbar_anbargardani.php";
echo'
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>'.$titr.'</title>
<link href="styles.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="functions.js"></script>
<link type="text/css" href="styles/jquery-ui-1.8.14.css" rel="stylesheet" />
<script type="text/javascript" src="scripts/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="scripts/jquery.ui.datepicker-cc.all.min.js"></script>
<script type="text/javascript">
$(function(){	    
    $("#datepickerfrom").datepicker({
		showOn: "button",
        buttonImage: "styles/images/calendar5.png",
        buttonImageOnly: true,
		showButtonPanel: true,
		changeMonth: true,
	    changeYear: true,
	  onSelect: function(dateText, inst){
	  $("#datepickerto").datepicker("option", "minDate", new JalaliDate(inst["selectedYear"], inst["selectedMonth"], inst["selectedDay"]));
	   }
	  });
	  $("#datepickerto").datepicker(
	  { 
		showOn: "button",
        buttonImage: "styles/images/calendar5.png",
        buttonImageOnly: true,
		showButtonPanel: true,
		changeMonth: true,
	    changeYear: true
		}
	  );
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
   <table width="600px" border="0" align="center" cellpadding="0" cellspacing="0" >
    <tr><td colspan="4" height="20px">&nbsp;</td></tr>
	<tr><td colspan="4" class="title">انتقال انبارگردانی تحت حواله '.$mt_gl_name_ostan.' '.$mt_gl_name_anbar.'</td></tr>
    <tr><td colspan="4" class="tr1">تاریخ حواله: <input id="datepickerfrom" type="text" name="tarikh_havale_anbar"/></td></tr>
    <tr><td colspan="4" class="tr1">تاریخ بارنامه: <input id="datepickerto" type="text" name="tarikh_barname_h"/></td></tr>
    <tr><td colspan="4" class="tr1">کد کالا: <input  type="text" name="code_kala"/></td></tr>
    <tr><td colspan="4" class="tr1">تعداد: <input  type="text" name="tedad_karton_h"/></td></tr>
    <tr><td colspan="4" class="tr1">وزن ناخالص: <input  type="text" name="vazn_nakhales_h"/></td></tr>
    <tr><td colspan="4" class="tr1">وزن خالص: <input  type="text" name="vazn_khales_h"/></td></tr>
    <tr><td colspan="4" class="tr1">توضیحات: <input  type="text" name="description"/></td></tr>
	<tr class="tr1"><td colspan="4" height="60px"><input class="buttonme" type="submit" name="transfer" value="ارسال"></td></tr> 
    <tr class="footer"><td colspan="4">&nbsp;</td></tr>
   </table>
  </td>
 </tr>	
</table>
</div>';
/********************WEB SERVICE NEW***********************/
$base_date='1402/11/09';
if(isset($transfer))
{
    mysql_query('SET AUTOCOMMIT=0');//TRANSACTIONشروع 
    mysql_query('START TRANSACTION');
    // $q_havale="SELECT * From havale h INNER JOIN list_sardkhane l_s ON h.code_ostan=l_s.code_ostan AND h.code_anbar=l_s.code_anbar INNER JOIN kala ON h.code_kala=kala.code_kala 
	           // INNER JOIN bastebandy ON kala.code_bastebandy=bastebandy.code_bastebandy
			   // WHERE h.tarikh_havale_anbar>='$base_date' AND h.code_ostan='$mt_gl_code_ostan' AND h.code_anbar='$mt_gl_code_anbar' AND h.tarikh_havale_anbar BETWEEN '$date1' AND '$date2' and year=$mtActiveYear AND sabt_nahayi=1 AND h.deleted=0 AND h.status=0 AND h.code_anbar!=301 AND chkwebservice=1 AND situation_type=1 AND l_s.activate=1 AND noe_tahvil_bar!=9 AND warehouse_id IS NOT NULL AND register_error_code=0 AND (wb_id IS NULL OR wb_id=0)";
	// $res_havale = mysql_query($q_havale);
	// while($row_havale=$db->fetch_assoc($res_havale))
    // {
       $params=array();
       $containers=array();
       $seals=array();
       $packages=array();
       $reference_docs=array();
	   $goods_issue_items=array();	   
	   $warehouse_id=$db->get_from_where("warehouse_id","list_sardkhane","code_ostan=".$_SESSION["mt_code_ostan"]." AND code_anbar=".$_SESSION["mt_code_anbar"]."");     
	   $postal_code=$db->get_from_where("postal_code","list_sardkhane","code_ostan=".$_SESSION["mt_code_ostan"]." AND code_anbar=".$_SESSION["mt_code_anbar"]."");     
	   $contractor_national_id='14002771736';
	   $noe_tahvil_bar=1;
	   
	   $q_kala="SELECT kala.*,package_type FROM $mydatabase.kala
	            INNER JOIN $mydatabase.bastebandy ON kala.code_bastebandy=bastebandy.code_bastebandy
	            WHERE code_kala=".$code_kala."";
	   $res_kala=$db->query($q_kala);
       $row_kala=$db->fetch_assoc($res_kala);
       $general_goods_id=$row_kala['general_goods_id'];
       $name_kala=$row_kala['name_kala'];
       $package_type=$row_kala['package_type'];
      
	   
	   if(strlen($_SESSION["mt_code_ostan"])==1) $code_a=make_pattern($_SESSION["mt_code_ostan"],2);
       else $code_a=$_SESSION["mt_code_ostan"];
	   $shenaseAnbar=$code_a.$_SESSION["mt_code_anbar"];
	   
	   //ایجاد شماره حواله - با توجه به استان و انبار وسال 
       $q2="SELECT shomare_havale_anbar FROM $mydatabase.havale_anbargardani WHERE code_ostan=".$_SESSION["mt_code_ostan"]." and code_anbar=".$_SESSION["mt_code_anbar"]."  
            AND year='$mtActiveYear' order by shomare_havale_anbar DESC LIMIT 0,1";
       $res2=$db->query($q2);
       $row2=$db->fetch_assoc($res2);
       $w=$row2['shomare_havale_anbar'];
       if($w){$shomare_havale_anbar=$w; $shomare_havale_anbar++;}
       else $shomare_havale_anbar=1;
       $shomare_havale_anbar=make_pattern($shomare_havale_anbar,5);
       
	   
	   //الگو
       $shomareBijak='2'.$bzActiveYear.$shenaseAnbar.$shomare_havale_anbar;

	   IF($row_kala['code_vahedkala']==1)//کیلوگرم
	    {
		      $measurement_unit=1;
			  $count=$vazn_khales_h;

	    }
        ELSE //تعداد//قطعه
	    {
		      $measurement_unit=6;
			  $count=$tedad_karton_h;   

	    }

	   //داخلی یا وارداتی
	    IF($row_kala['mahmule_type']==1)$production_type=1;
	    ELSE $production_type=2;	
	   
	    $shomare_barname_h=1;
	    
	    $plak4=11;
	    $plak3=ع;
	    $plak2=111;	  
	    $plak1=11;
	 
	   //الگو
	   $plak=$plak1.'|'.$plak2.'|'.$plak3.'|'.$plak4;
	   
	   header('Content-Type: text/html; charset=utf-8');
       //try
	   //{
	     //$client=new SoapClient($wsdl_url);
		 $seals1=array(
		  'marks'=>null,
		  'sealing_party'=>null
		 );
		 array_push($seals,$seals1);
		 $containers1=array(
		  'container_id'=>null,
		  'package_count'=>null,
		  'type'=>null,
		  'load_volume'=>null,
		  'seals'=>$seals,
		  'empty_weight'=>null,
		  'gross_weight'=>null,
		  'min_temp'=>null,
		  'max_temp'=>null,
		  'unit_temp'=>null,
		  'humidity'=>null,
		  'additional_information'=>null
		 );
		 array_push($containers,$containers1);
		 $packages1=array(
		  'container_id'=>null,
		  'package_id'=>null,
		  'marks'=>null,
		  'type'=>null,
		  'additional_information'=>null  
		 );
		 array_push($packages,$packages1);
		 $reference_docs1=array(
		  'type'=>'BL',
		  'number'=>$shomare_barname_h,
		  'id'=>null,
		  'issue_date'=>$tarikh_barname_h  
		 );	
		 //$reference_docs=array($reference_docs1);
		 array_push($reference_docs,$reference_docs1);

		 $goods_issue_items1=array(
		  'cid_code'=>null,
		  'general_goods_id'=>$general_goods_id,  
		  'hs_code'=>null,  
		  'tracking_code'=>null,  
		  'goods_description'=>$name_kala,  
		  'dangerous_goods_code'=>null,  
		  'measurement_unit'=>$measurement_unit,  
		  'production_type'=>$production_type,  
		  'count'=>$vazn_khales_h,  
		  'gross_weight'=>$vazn_nakhales_h,  
		  'net_weight'=>$vazn_khales_h,  
		  'volume'=>null,  
		  'container_id'=>null,  
		  'package_id'=>null,  
		  'package_count'=>$tedad_karton_h, 
		  'package_type'=>$package_type,  
		  'comments'=>null,  
		  'additional_information'=>null 
		 );
		 
		 array_push($goods_issue_items,$goods_issue_items1);
         $params=array(
		  'number'=>$shomareBijak,
          'gov_number'=>$shomareBijak,
		  'goods_issue_date'=>$tarikh_havale_anbar,
          'warehouse_id'=>$warehouse_id,
          'contractor_national_id'=>$contractor_national_id,
          'postal_code'=>$postal_code,
          //'containers'=>$containers,
          //'packages'=>$packages,
		  'load_date'=>$tarikh_havale_anbar,
		  'owner'=>'14002771736',
		  'owner_birth_date'=>null,
		  'consignee_national_id'=>null,
		  'consignee_birth_date'=>null,
		  'carrier_national_id'=>null,
		  'carrier_name'=>null,
		  'vehicle_name'=>null,
		  'vehicle_type'=>1,
		  'vehicle_number'=>$plak,
		  'net_weight'=>$vazn_khales_h,
		  'gross_weight'=>$vazn_nakhales_h,
		  'reference_docs'=>$reference_docs,
		  'description'=>$description,
		  'place_description'=>null,
		  'additional_information'=>null,
		  'goods_issue_items'=>$goods_issue_items
         );
		 
		 echo '<pre>'; print_r($params); echo '</pre>';
		 $result=preg_replace("/\\\\u([a-f0-9]{4})/e", "iconv('UCS-4LE','UTF-8',pack('V', hexdec('U$1')))", json_encode($params));
		 //echo '<pre>'; echo($result); echo '</pre>';
		 $encodedData = json_encode($params);

		 $curl = curl_init();
		 curl_setopt_array($curl, array(
          CURLOPT_URL => 'http://10.7.234.33/warehouse/api/warehouse/DraftPermanent',
          CURLOPT_USERPWD => 'ajix_agridam:3rt67HM',
		  CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>$encodedData,
          CURLOPT_HTTPHEADER => array(
           'Authorization: Basic YWppeF9hZ3JpZGFtOjNydDY3SE0=',
           'Content-Type: application/json'),
          ));
		  
          $response = curl_exec($curl);
		  $response = str_replace(array("\"{\"","\"}\""),array("'{\"","\"}'")
		             ,str_replace(array('\"',"\\\\","'"),array('"',"\\")
			 	     ,preg_replace("/\\\\u([a-f0-9]{4})/e", "iconv('UCS-4LE','UTF-8',pack('V', hexdec('U$1')))",json_decode($response))));


		  echo "<br>\r\n";		  
		  $array =json_decode($response,true); # آرایه
		  $object=json_decode($response);      # آبجکت
		  
		  //print_r($array);

		  $wb_error_code =$object->error_code;
		  $wb_error_message =$object->error_message;
		  $wb_creator =$object->creator;
		  $wb_create_date =$object->create_date;
		  $wb_id =$object->id;
		  
		 $encodedData = str_replace(array("\"{\"","\"}\""),array("'{\"","\"}'")
		             ,str_replace(array('\"',"\\\\","'"),array('"',"\\")
			 	     ,preg_replace("/\\\\u([a-f0-9]{4})/e", "iconv('UCS-4LE','UTF-8',pack('V', hexdec('U$1')))",($encodedData))));

		 		 
		 if(SuperUser()) echo '<br>';
 		 if(SuperUser()) echo '<pre>';echo $encodedData;echo '</pre>';//ورودی ما
 		 if(SuperUser()) echo '<br>';
		 if(SuperUser()) echo 'خروجی:';print_r($array);//خروجی سامانه جامع
		 if(SuperUser()) echo 'خروجی:';print_r($object);//خروجی سامانه جامع
		  
          curl_close($curl);
		 
	   //}
	   // catch(SoapFault $client)
	   // {
		 // echo "<script>alert('وب سرویس فعال نمی باشد')</script>";
		 // echo  $e->getMessage();
	   // }
	   if($object->error_code != 0)
       {
	    echo "<script>alert($object->error_message)</script>";
	    //exit();
       }
	   //2014:واحد غیرفعال است، لطفا جهت فعالسازی واحد به اداره صنعت، معدن و تجارت شهرستان مراجعه نمائید.
	   //wb_id:warehouse_id برگشت میخورد 
	   IF($wb_error_code=='2014') $wb_id='';
	   $IssuedTime = date('H:i');
	   
	   $insert_q=("INSERT INTO $mydatabase.havale_anbargardani
            (code_ostan,code_anbar,shomare_havale_anbar,year,tarikh_havale_anbar,IssuedTime,
			 noe_tahvil_bar,shomare_barname_h,tarikh_barname_h,plak1,plak2,plak3,plak4,code_kala,tedad_karton_h,vazn_nakhales_h,vazn_khales_h,deleted,status,
			 wb_error_code,wb_error_message,wb_creator,wb_create_date,wb_id)
             VALUES
			('$mt_gl_code_ostan','$mt_gl_code_anbar','$shomareBijak','$mtActiveYear','$tarikh_havale_anbar','$IssuedTime',
			 '$noe_tahvil_bar','$shomare_barname_h','$tarikh_barname_h','$plak1','$plak2','$plak3','$plak4','$code_kala','$tedad_karton_h','$vazn_nakhales_h','$vazn_khales_h',0,0,
			 '$wb_error_code','$wb_error_message','$wb_creator','$wb_create_date',$wb_id)");
       $insert_res=mysql_query($insert_q);
	   
	   //$update_track=("UPDATE havale SET wb_error_code='$wb_error_code',wb_error_message='$wb_error_message',wb_creator='$wb_creator',wb_create_date='$wb_create_date',wb_id='$wb_id' WHERE code_ostan=".$row_havale['code_ostan']." AND code_anbar=".$row_havale['code_anbar']." AND shomare_havale_anbar='".$row_havale['shomare_havale_anbar']."' AND year=$mtActiveYear");
	   //$update_res=mysql_query($update_track);
    //}//END while
    if($insert_res)
    {
   	 mysql_query("COMMIT");
       echo "<script>alert('success')</script>"; 
   	}
   	else  
    {
       mysql_query('ROLLBACK');
       echo "<script>alert('error!')</script>";  
    }
    mysql_query('SET AUTOCOMMIT=1'); 	  
}
/********************WEB SERVICE NEW EBTAL***********************/
echo'
</form>
</body>
</html>';	
?>