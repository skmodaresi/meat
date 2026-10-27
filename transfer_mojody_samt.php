<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="transfer_mojody_samt.php";
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

$date1=$db->get_from_where("start_from","bzacc.bz_docs","year='$mtActiveYear'");
//اگر کاربر تاریخ دوم را وارد نکرده بود
if(!$date2)
{
	 $ExcelFileName=str_replace('.php','',$FileName); 
 	 $end_date_session=$db->get_from_where("end_to","bzacc.bz_docs","year='$mtActiveYear'");
	 if($today<$end_date_session) $date2=$today;
     else  $date2=$end_date_session;	 
}
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
	<tr><td colspan="4" class="title">انتقال موجودی فعلی به وب سرویس(سرویس خوشه های کشاورزی)</td></tr>
    <tr><td colspan="4" class="tr1">از تاریخ : <input readonly type="text" name="date1" value="'.$date1.'" /></td></tr>
    <tr><td colspan="4" class="tr1">تا تاریخ : <input id="datepickerto" type="text" name="date2" placeholder="'.$date2.'" /></td></tr>
	<tr class="tr1"><td colspan="4" height="60px"><input class="buttonme" type="submit" name="transfer" value="انتقال موجودی"></td></tr> 
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
	$params=array();
    $warehouse=array();
    $goods=array();
	$stock_taking_items=array();
	
	//AND chkwebservice=1
	//and m.code_anbar=$mt_gl_code_anbar
	//m.code_ostan=$mt_gl_code_ostan  and
	$q="SELECT m.*,warehouse_id From mojody_kala m 
	          INNER JOIN list_sardkhane l_s ON m.code_ostan=l_s.code_ostan AND m.code_anbar=l_s.code_anbar 
	          WHERE m.year=$mtActiveYear  AND m.deleted=0 AND m.code_anbar!=301  AND situation_type=1 AND l_s.activate=1 AND warehouse_id IS NOT NULL AND register_error_code=0 AND (wb_id IS NULL OR wb_id=0)
			  group by m.year,m.code_ostan,m.code_anbar
              order by m.code_ostan,m.code_anbar";
	echo $q;
	$res = mysql_query($q);	
	while($row=$db->fetch_assoc($res))
    {
	   $params=array();
       $warehouse=array();
       $goods=array();
	   $stock_taking_items=array();
       
	   if(strlen($row['code_ostan'])==1) $code_a=make_pattern($row['code_ostan'],2);
       else $code_a=$row['code_ostan'];
	   $shenaseAnbar=$code_a.$row['code_anbar'];
       //تاریخ روز+شناسه انبار خودمان
	   $shomareGhabz=$yymmdd.$shenaseAnbar;
	  
       //کالاهای هر انبار در یک آرایه قرار میگیرد
	   //براساس شناسه عمومی کالا
	   $q_kala="SELECT m.*,SUM(mojody_khales_aval) as mojodyAval,warehouse_id,general_goods_id,mahmule_type From mojody_kala m 
	          INNER JOIN list_sardkhane l_s ON m.code_ostan=l_s.code_ostan AND m.code_anbar=l_s.code_anbar 
	          INNER JOIN kala ON m.code_kala=kala.code_kala
	          WHERE m.code_ostan=".$row['code_ostan']." and m.code_anbar=".$row['code_anbar']." and m.year=".$row['year']."  AND m.deleted=0 AND m.code_anbar!=301  AND situation_type=1 AND l_s.activate=1 
			  group by m.year,m.code_ostan,m.code_anbar,general_goods_id,mahmule_type
              order by m.code_ostan,m.code_anbar,general_goods_id";	
	   
	   //echo $q_kala;
	   $res_kala = mysql_query($q_kala);	
	   while($row_kala=$db->fetch_assoc($res_kala))
	   {   
		//داخلی یا وارداتی
	     IF($row_kala['mahmule_type']==1)$production_type=1;//داخلی
	     ELSE IF($row_kala['mahmule_type']==2) $production_type=2;//وارداتی
		 //تخم مرغ نطفه دار و جوجه یک روزه
	     IF(($code_kala==55)OR($code_kala==70)){$measurement_unit='6';$avalField='tedad_karton_aval';$residField='tedad_karton_r_d_sub';$havaleField='tedad_karton_h_d';$tadilField='tedad_karton_tadil';$anbargardaniField='tedad_anbargardani';$vahed='تعداد';}				 
	     ELSE {$measurement_unit='1';$avalField='mojody_khales_aval';$residField='vazn_khales_r_d_sub';$havaleField='vazn_khales_h_d';$tadilField='meghdar_khales_tadil';$anbargardaniField='khales_anbargardani';$vahed='کیلوگرم';}

		 //ELSE IF($noe_namayesh==4){$avalField='tedad_shane_aval';$residField='tedad_shane_r_d_sub';$havaleField='tedad_shane_h_d';$tadilField='tedad_shane_tadil';$anbargardaniField='shane_anbargardani';$vahed='شانه';}				 
	           

		 //محاسبات موجودی
		 $q_aval = "SELECT SUM($avalField) FROM mojody_kala T INNER JOIN kala ON T.code_kala=kala.code_kala WHERE T.code_ostan=".$row_kala['code_ostan']." AND T.code_anbar=".$row_kala['code_anbar']." AND T.year=".$row_kala['year']." AND general_goods_id=".$row_kala['general_goods_id']." AND mahmule_type=".$row_kala['mahmule_type']." AND T.deleted=0";
		 $res_aval = mysql_query($q_aval);
         $row_aval = mysql_fetch_array($res_aval);
         $mojodyAval = $row_aval[0];

		 //مجموع رسیدها به غیر از تحت کلید گمرک
		 $q_varede = "SELECT SUM($residField) FROM resid_kala_detail T INNER JOIN resid r ON T.shomare_resid=r.shomare_resid AND T.code_ostan=r.code_ostan AND T.code_anbar=r.code_anbar AND T.year=r.year INNER JOIN kala ON T.code_kala=kala.code_kala WHERE T.code_ostan=".$row_kala['code_ostan']." AND T.code_anbar=".$row_kala['code_anbar']." AND T.year=".$row_kala['year']." AND general_goods_id=".$row_kala['general_goods_id']." AND mahmule_type=".$row_kala['mahmule_type']." AND r.deleted=0 AND r.status=0 AND noe_tahvil_bar!=9 AND tarikh_resid BETWEEN '$date1' AND '$date2'";
		 $res_varede = mysql_query($q_varede);
         $row_varede = mysql_fetch_array($res_varede);
         $jameVarede = $row_varede[0];
         //مجموع حواله ها به غیر از تحت کلید گمرک
		 $q_sadere = "SELECT SUM($havaleField) FROM havale_detail T INNER JOIN meat.havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year  INNER JOIN kala ON T.code_kala=kala.code_kala WHERE T.code_ostan=".$row_kala['code_ostan']." AND T.code_anbar=".$row_kala['code_anbar']." AND T.year=".$row_kala['year']." AND general_goods_id=".$row_kala['general_goods_id']." AND mahmule_type=".$row_kala['mahmule_type']." AND h.deleted=0 AND h.status=0 AND noe_tahvil_bar!=9 AND tarikh_havale_anbar BETWEEN '$date1' AND '$date2'";
		 $res_sadere = mysql_query($q_sadere);
         $row_sadere = mysql_fetch_array($res_sadere);
         $jameSadere = $row_sadere[0];
		 $q_tadil_ezafe = "SELECT SUM($tadilField) FROM tadil_mojody INNER JOIN kala ON tadil_mojody.code_kala=kala.code_kala WHERE noe_tadil=1 AND code_ostan=".$row_kala['code_ostan']." AND code_anbar=".$row_kala['code_anbar']." AND year=".$row_kala['year']." AND general_goods_id=".$row_kala['general_goods_id']." AND mahmule_type=".$row_kala['mahmule_type']." AND deleted=0 AND status=0 AND tarikh_barge_tadil BETWEEN '$date1' AND '$date2'";
         $res_tadil_ezafe = mysql_query($q_tadil_ezafe);
         $row_tadil_ezafe = mysql_fetch_array($res_tadil_ezafe);
         $meghdarTadil_Ezafe = $row_tadil_ezafe[0];
         $q_tadil_kasry = "SELECT SUM($tadilField) FROM tadil_mojody INNER JOIN kala ON tadil_mojody.code_kala=kala.code_kala WHERE noe_tadil=2 AND code_ostan=".$row_kala['code_ostan']." AND code_anbar=".$row_kala['code_anbar']." AND year=".$row_kala['year']." AND general_goods_id=".$row_kala['general_goods_id']." AND mahmule_type=".$row_kala['mahmule_type']." AND deleted=0 AND status=0 AND tarikh_barge_tadil BETWEEN '$date1' AND '$date2'";
         $res_tadil_kasry = mysql_query($q_tadil_kasry);
         $row_tadil_kasry = mysql_fetch_array($res_tadil_kasry);
         $meghdarTadil_Kasry = $row_tadil_kasry[0];
		 
	     //موجودی
	     //$removable_count = $row_kala['mojodyAval'] + $jameVarede - $jameSadere + $meghdarTadil_Ezafe - $meghdarTadil_Kasry ;
	     $removable_count = $mojodyAval + $jameVarede - $jameSadere + $meghdarTadil_Ezafe - $meghdarTadil_Kasry ;
     	 $removable_count =round($removable_count,3);
		 //صفر رو قبول نمیکرد
		 IF($removable_count<=0) $removable_count=0.1;
		 
		 $goods1=array(
		  'good_id'=>$row_kala['general_goods_id'],
		  'measurement_unit'=>$measurement_unit,
		  'production_type'=>$production_type,
		  'removable_count'=>$removable_count,
		 );
		 array_push($goods,$goods1);
		   
	   }//END WHILE KALA
	 
	    header('Content-Type: text/html; charset=utf-8');

		 $warehouse=array(
		  'id'=>$row['warehouse_id']
		  //,
		  //'contractor_national_id'=>null,
		  //'postal_code'=>null,
		 );
		 
		 $stock_taking_items1=array(
          'owner'=>'14002771736',
		  //'owner_birth_date'=>null,
		  'goods'=>$goods
		 );
		 array_push($stock_taking_items,$stock_taking_items1);
         
		 $params=array(
		  'number'=>$shomareGhabz,
		  'issue_date'=>$date2,
          'warehouse'=>$warehouse,
          'stock_taking_items'=>$stock_taking_items
         );
		 
		 //چاپ اطلاعات ارسالی ما
		 //echo '<pre>'; print_r($params); echo '</pre>';
		 $result=preg_replace("/\\\\u([a-f0-9]{4})/e", "iconv('UCS-4LE','UTF-8',pack('V', hexdec('U$1')))", json_encode($params));
		 //echo '<pre>'; echo($result); echo '</pre>';
		 $encodedData = json_encode($params);
         //echo "<br>";		  
		 echo '<pre>'; echo($encodedData); echo '</pre>';
		 
		 /////////////////////////CURL شروع کد ///////////////////////////////////
		 $curl = curl_init();
		 curl_setopt_array($curl, array(
          CURLOPT_URL => 'http://10.7.234.33/warehouse/api/warehouse/StockTaking',
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

		  
		  $arr =json_decode($response,true); # آرایه
		  $object=json_decode($response);    # آبجکت
		  
		  //چاپ آرایه نتیجه برگشتی  
		  var_dump($arr);
		  echo "<br>\r\n";		  
          $wb_error_code=$arr['error_code'];
		  $wb_error_message=$arr['error_message'];
		  $wb_creator=$arr['creator'];
		  $wb_create_date=$arr['create_date'];
		  $wb_id=$arr['id'];
		  $wb_number =$arr['number'];
		  $wb_goods_arr =$arr['stock_taking_items']['0']['goods'];//آرایه کالاها
		  
		  
	   curl_close($curl);
	 
	   if($wb_error_code != 0)
       {
	    echo "<script>alert($wb_error_message)</script>";
       }
	   
	   foreach( $wb_goods_arr as $value )
	   {
	     $wb_good_id=$value['good_id'];
	     $wb_good_desc=$value['good_desc'];
	     $wb_production_type=$value['production_type'];
	     //$wb_measurement_unit=$value['measurement_unit'];
	     $wb_removable_count=$value['removable_count'];	
		 $update_track=("UPDATE mojody_kala INNER JOIN kala ON mojody_kala.code_kala=kala.code_kala SET wb_error_code='$wb_error_code',wb_error_message='$wb_error_message',wb_creator='$wb_creator',wb_create_date='$wb_create_date',wb_id='$wb_id',wb_number='$wb_number',wb_good_id='$wb_good_id',wb_good_desc='$wb_good_desc',wb_production_type='$wb_production_type',wb_removable_count='$wb_removable_count' WHERE code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']."  AND year=".$mtActiveYear."  AND kala.general_goods_id=".$wb_good_id." AND kala.mahmule_type=".$wb_production_type." ");
	     $update_res=mysql_query($update_track);   
	   }	   
		
      //$update_track=("UPDATE mojody_kala SET wb_error_code='$wb_error_code',wb_error_message='$wb_error_message',wb_creator='$wb_creator',wb_create_date='$wb_create_date',wb_id='$wb_id',wb_number='$wb_number' WHERE code_ostan=".$row['code_ostan']." AND code_anbar=".$row['code_anbar']."  AND year=".$mtActiveYear." ");
	  //$update_res=mysql_query($update_track);
	 }//END WHILE
    
	if($update_res)
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