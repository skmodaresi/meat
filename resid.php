<?php
session_start();
//error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="resid.php";
$TableName="resid";
$logtime=date('H:i:s');
$right_ins=0;$right_del=0;$right_prt=0;$right_detail=0;
if (right(156)) $right_ins=1;
// if (right(157)) $right_edt=1;
if (right(158)) $right_del=1;
if (right(159)) $right_prt=1;
if (right(161)) $right_taeed_nazer=1;
if (right(162)) $right_detail=1;
if (right(603)) $right_javaz_ebtal=1;

$titr='رسید سردخانه';
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
<link rel="stylesheet" type="text/css" href="styles/simptip.css" media="screen,projection" />
<script type="text/javascript">
$(function(){	    
    $("#datepicker5").datepicker({
	    showOn: "button",
        buttonImage: "styles/images/calendar5.png",
        buttonImageOnly: true,
		showButtonPanel: true,
		changeMonth: true,
	    changeYear: true
	 });
	 <!--اطلاعات حواله های ارسالی برای این انبار-->
	 $("#notice").load("notice_resid.php");	 
}); 
</script>
</head>';
if(!(isset($Mode))) $Mode='';
/*************SEARCH BUTTON******/// جستجوی اطلاعات
if(isset($open_filter))
{ $open_filter="";
  $_SESSION['mt_search_resid']="";
} 
if(isset($Search_x))
{
 $Mode='';
 $Search_x=""; 
 $temp="";
 if($id)             $temp.=" and T.id LIKE '%$id%'";
 if($shomare_resid)  $temp.=" and T.shomare_resid LIKE '%$shomare_resid%'";
 if($tarikh_resid)   $temp.=" and T.tarikh_resid LIKE '%$tarikh_resid%'";
 if($code_kala)      $temp.=" and r_d.code_kala LIKE '$code_kala'";
 if($code_ziranbar)  $temp.=" and r_k_d.code_ziranbar LIKE '$code_ziranbar'";
 if($status==0)      $temp.=" and T.status=0";//وضعیت رسید 	 
 if($status==1)      $temp.=" and T.status=1";//وضعیت رسید 	 
 if($status==-1)     $temp.="";//وضعیت رسید
 if($kamion_no)      $temp.=" and T.kamion_no LIKE '%$kamion_no%'";
 if($plak1)          $temp.=" and plak1 LIKE '%$plak1%'";
 if($plak2)          $temp.=" and plak2 LIKE '%$plak2%'";
 if($plak3)          $temp.=" and plak3 LIKE '%$plak3%'";
 if($plak4)          $temp.=" and plak4 LIKE '%$plak4%'";
 if($vazn_khales_r)  $temp.=" and T.vazn_khales_r LIKE '%$vazn_khales_r%'";
 if($noe_tahvil_bar) $temp.=" and noe_tahvil_bar LIKE '$noe_tahvil_bar'";
 if($code_ostan_mabda) $temp.=" and code_ostan_mabda LIKE '$code_ostan_mabda'";
 if($code_anbar_mabda) $temp.=" and code_anbar_mabda LIKE '$code_anbar_mabda'";
 if($shomare_havale_anbar) $temp.=" and shomare_havale_anbar LIKE '%$shomare_havale_anbar%'";
 if($sabt_nahayi!='-1') $temp.=" and sabt_nahayi=$sabt_nahayi";
 if($temp) {$PageNo=1;$_SESSION['mt_search_resid']=$temp;} else $_SESSION['mt_search_resid']="";
}
/************DELETE BUTTON********/// حذف اطلاعات
if (isset($Delete_x))
{
 $Mode='';
 // $del_q="UPDATE $TableName T,resid_detail r_d,resid_kala_detail r_k_d SET T.deleted=1,r_d.resid_deleted=1,r_k_d.resid_deleted=1
         // WHERE 
	     // T.shomare_resid=r_d.shomare_resid AND T.shomare_resid=r_k_d.shomare_resid AND
	     // T.code_ostan=r_d.code_ostan AND T.code_ostan=r_k_d.code_ostan AND
	     // T.code_anbar=r_d.code_anbar AND T.code_anbar=r_k_d.code_anbar AND
	     // T.year=r_d.year AND T.year=r_k_d.year AND
	     // T.shomare_resid='$shomare_resid_' AND T.code_ostan='$mt_gl_code_ostan' AND T.code_anbar='$mt_gl_code_anbar' AND T.year='$mtActiveYear' ";
 
 $del_q ="UPDATE $TableName SET deleted=1 WHERE id=$id_";
 $del_res =mysql_query($del_q);
 if($del_res)
 {
   //اگر رسید ابطالی باشد
   if($status_==1)$log_d=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_','حذف رسید انبار ابطالی',".($yymmdd).",'$logtime')");/*کوئری لاگ*/
   if($status_==0)$log_d=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_','حذف رسید',".($yymmdd).",'$logtime')");  
   $del_q_d ="UPDATE resid_detail SET resid_deleted=1 WHERE shomare_resid='".$shomare_resid_."' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear'";
   $del_res_d=mysql_query($del_q_d);
   $del_q_d2 ="UPDATE resid_kala_detail SET resid_deleted=1 WHERE shomare_resid='".$shomare_resid_."' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear'";
   $del_res_d2=mysql_query($del_q_d2);
   if((mysql_affected_rows()!=0)and($status_==0))
   { 
	  /*resid_detail_kala خواندن اطلاعات*/
	  $q="SELECT * from resid_kala_detail WHERE shomare_resid='$shomare_resid_' AND code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND year=$mtActiveYear";       
	  $res=mysql_query($q);
      while($row=mysql_fetch_assoc($res))
	  {
	   /*resid_detail خواندن*/
         $q_detail="SELECT vazn_karton_this FROM resid_detail WHERE shomare_resid='$shomare_resid_' AND code_kala=".$row['code_kala']." AND code_keshvar=".$row['code_keshvar']." AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear'";	
		 $all_detail = $db->query($q_detail);
         $row_detail=$db->fetch_assoc($all_detail);
	   //خواندن موجودی  
		 $q_m="SELECT * from mojody_kala where code_kala=".$row['code_kala']." AND code_keshvar=".$row['code_keshvar']." AND sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND year=$mtActiveYear AND deleted=0";       
		 $res_m=mysql_query($q_m);
         $row_m=mysql_fetch_assoc($res_m);   
	  //آپدیت موجودی کالا در جدول موجودی کالا
         $update_mojody_nakhales=$row_m['mojody_nakhales']-$row['vazn_nakhales_r_d_sub'];//آپدیت موجودی ناخالص کالا در جدول موجودی کالا  
         $majmo_karton=$row['tedad_karton_r_d_sub']*$row_detail['vazn_karton_this'];//وزن کارتن ها برای این تاریخ
    	 $vazn_khales=$row['vazn_nakhales_r_d_sub']-$majmo_karton;//وزن خالص این تاریخ
		 $update_mojody_khales=$row_m['mojody_khales']-$vazn_khales;//آپدیت موجودی خالص کالا در جدول موجودی کالا
    	 $update_tedad_karton=$row_m['tedad_karton']-$row['tedad_karton_r_d_sub'];//آپدیت تعداد کارتن های موجود در انبار
		 $update_mojody_res=$db->query("UPDATE mojody_kala SET mojody_khales=$update_mojody_khales,mojody_nakhales=$update_mojody_nakhales,tedad_karton=$update_tedad_karton WHERE code_kala=".$row['code_kala']." AND code_keshvar=".$row['code_keshvar']." AND sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND year=$mtActiveYear AND deleted=0");      	 
	  	 /*لاگ موجودی*/
	     if($update_mojody_res) $log_e=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','mojody_kala',".$row_m['id'].",'حذف رسید انبار و برگشت موجودی',".($yymmdd).",'$logtime')");
	  }
     //echo "<script>window.location='resid.php?PageNo=".$PageNo."&RowPerPage=".$RowPerPage."&order=".$order."';</script>";   
    } 
  }
  else $message ='<span style=" color:red;font: bold 12px tahoma;"> * مشکلی در حذف به وجود آمده است  ! *</span>';
  //else{echo "<script>alert('مشکلی در حذف رسید رخ داده است !')</script>";}
}//END DELETE
/********************TAEED NAZER***********************/
if(isset($taeed_nazer))
{
  $update_sabt=("UPDATE resid SET taeed_nazer=1 WHERE code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND shomare_resid='$shomare_resid_' AND year=$mtActiveYear");
  $update_res_sabt=mysql_query($update_sabt);
  echo "<script>window.location='resid.php?PageNo=".$PageNo."&RowPerPage=".$RowPerPage."&order=".$order."';</script>";     
}

/********************WEB SERVICE***********************/
if(isset($send_resid))//مراحل ثبت در وب سرویس
{
  $base_date='1402/11/09';      
  if($sabt_resid)//ثبت نهایی
  {
  	$update_sabt=("UPDATE resid SET sabt_nahayi=1 WHERE code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND shomare_resid='$shomare_resid_' AND year=$mtActiveYear");
	$update_res_sabt=mysql_query($update_sabt);
    $log_i=$db->query("INSERT INTO $mydatabase.log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName ','$id_','ثبت نهایی رسید',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')"); 
  }
  $register_error_code=$db->get_from_where("register_error_code","list_sardkhane","code_ostan=".$mt_gl_code_ostan." AND code_anbar=".$mt_gl_code_anbar."");     
  $tarikh_resid=$db->get_from_where("tarikh_resid","resid","id=".$id_."");     
  //////////////////////////////////NEW version//////////////////////////////////////////////
  //به جز تحت کلید گمرک
  if(($_SESSION['mt_webservice']==1)AND($register_error_code==0)AND($noe_tahvil_bar_!=9)AND($tarikh_resid>=$base_date))//اتصال به وب سرویس
  {
	  $params=array();
      $containers=array();
      $seals=array();
      $packages=array();
      $reference_docs=array();
	  $receipt_items=array();
	   $q_resid="SELECT * From resid r INNER JOIN list_sardkhane l_s ON r.code_ostan=l_s.code_ostan AND r.code_anbar=l_s.code_anbar
	   	         INNER JOIN peymankar_haml ON r.code_peymankar_haml=peymankar_haml.code_peymankar_haml
	             WHERE r.tarikh_resid>='$base_date' AND r.code_ostan=$mt_gl_code_ostan AND r.code_anbar=$mt_gl_code_anbar AND r.year=$mtActiveYear AND r.shomare_resid='$shomare_resid_'";
	   $res_Resid = mysql_query($q_resid);
	   $row_resid=mysql_fetch_assoc($res_Resid);
	   
	   $warehouse_id=$db->get_from_where("warehouse_id","list_sardkhane","code_ostan=".$row_resid['code_ostan']." AND code_anbar=".$row_resid['code_anbar']."");     
       //$contractor_national_id=$db->get_from_where("nationalId","list_sardkhane_owner","code_ostan=".$row_resid['code_ostan']." AND code_anbar=".$row_resid['code_anbar']."");     
	   $contractor_national_id='14002771736';
	   if(strlen($row_resid['code_ostan'])==1) $code_a=make_pattern($row_resid['code_ostan'],2);
       else $code_a=$row_resid['code_ostan'];
	   $shenaseAnbar=$code_a.$row_resid['code_anbar'];
       //$shomareGhabz=$mtActiveYear.$row_resid['shomare_resid'];
       $shomareGhabz='0'.$mtActiveYear.$shenaseAnbar.$row_resid['shomare_resid'];
          
	   if($row_resid['barname_no']=='')$barname_no='1';
	   else $barname_no=$row_resid['barname_no'];
	   
	   if($row_resid['barname_tarikh']=='')$barname_tarikh=$row_resid['tarikh_resid'];
	   else $barname_tarikh=$row_resid['barname_tarikh'];
	   
	   
	   if(($row_resid['plak4']=='')or($row_resid['plak4']==0))$plak4=11;
	   else $plak4=$row_resid['plak4'];
	   if(($row_resid['plak3']=='')or($row_resid['plak3']==0))$plak3=ع;
	   else $plak3=$row_resid['plak3'];
	   if(($row_resid['plak2']=='')or($row_resid['plak2']==0))$plak2=111;
	   else $plak2=$row_resid['plak2'];
	   if(($row_resid['plak1']=='')or($row_resid['plak1']==0))$plak1=11;
	   else $plak1=$row_resid['plak1'];
	   //الگو
	   //$plak=$plak1.'|'.$plak4.'|'.$plak2.'|'.$plak3;
	   $plak=$plak1.'|'.$plak2.'|'.$plak3.'|'.$plak4;
	   if($noe_tahvil_bar==3)$vehicle_type=3;
	   else $vehicle_type=1;
	   
	   header('Content-Type: text/html; charset=utf-8');
	   //try
	   //{
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
		  'number'=>$barname_no,
		  'id'=>null,
		  'issue_date'=>$barname_tarikh 
		 );	
		 //$reference_docs=array($reference_docs1);
		 array_push($reference_docs,$reference_docs1);

	     $q_resid_k_d="SELECT r_k_d.*,general_goods_id,name_kala,mahmule_type,kala.code_vahedkala,kala.code_bastebandy,sharh_bastebandy,package_type From resid_kala_detail r_k_d INNER JOIN kala ON kala.code_kala=r_k_d.code_kala INNER JOIN bastebandy ON kala.code_bastebandy=bastebandy.code_bastebandy  WHERE r_k_d.code_ostan=".$row_resid['code_ostan']." AND r_k_d.code_anbar=".$row_resid['code_anbar']." AND r_k_d.year=$mtActiveYear AND r_k_d.shomare_resid='".$row_resid['shomare_resid']."'";
	     $res_Resid_k_d = mysql_query($q_resid_k_d);
	     while($row_resid_k_d=mysql_fetch_assoc($res_Resid_k_d))//جزئیات کالا
	     {
		  //الگو   
	       $goodId='02'.(make_pattern($row_resid_k_d['code_kala'],10));
		   IF($row_resid_k_d['code_vahedkala']==1)//کیلوگرم
	       {
		      $measurement_unit=1;
	          $count=$row_resid_k_d['vazn_khales_r_d_sub'];
	       }
           ELSE //تعداد//قطعه
	       {
		      $measurement_unit=6;
		      $count=$row_resid_k_d['tedad_karton_r_d_sub'];   
	       }
	       //داخلی یا وارداتی
	       IF($row_resid_k_d['mahmule_type']==1)$production_type=1;
	       ELSE $production_type=2;		   
		   $receipt_items1=array(
		    //'row_number'=>'1',
		    //'good_id'=>$goodId,
		    'cid_code'=>null,
		    'general_goods_id'=>$row_resid_k_d['general_goods_id'],  
		    'hs_code'=>null,  
		    'tracking_code'=>null,  
		    'goods_description'=>$row_resid_k_d['name_kala'],  
		    'dangerous_goods_code'=>null,  
		    'measurement_unit'=>$measurement_unit,  
		    'production_type'=>$production_type,  
		    'count'=>$count,  
		    'gross_weight'=>$row_resid_k_d['vazn_nakhales_r_d_sub'],  
		    'net_weight'=>$row_resid_k_d['vazn_khales_r_d_sub'],  
		    'volume'=>null,  
		    'container_id'=>null,  
		    'package_id'=>null,  
		    'package_count'=>$row_resid_k_d['tedad_karton_r_d_sub'],  
		    'package_type'=>$row_resid_k_d['package_type'],  
		    'comments'=>null,  
		    'additional_information'=>null 
		   );
		   
		   array_push($receipt_items,$receipt_items1);
		 }
         $params=array(
		  'number'=>$shomareGhabz,
          'gov_number'=>$shomareGhabz,
		  'rcp_date'=>$row_resid['tarikh_resid'],
          'warehouse_id'=>$warehouse_id,
          'contractor_national_id'=>$contractor_national_id,
          'postal_code'=>$row_resid['postal_code'],
          //'containers'=>$containers,
          //'packages'=>$packages,
		  'discharge_date'=>$row_resid['tarikh_resid'],
		  'owner'=>'14002771736',
		  'owner_birth_date'=>null,
		  'driver_national_id'=>$row_resid['ranande_melicode'],
          'driver_birth_date'=>null,
		  'deliverer_national_id'=>null,
		  'deliverer_birth_date'=>null,
		  'reference_docs'=>$reference_docs,
		  'insurance_doc_number'=>null,
		  'insurance_company_code'=>null,
		  'carrier_national_id'=>null,
		  'carrier_name'=>$row_resid['name_peymankar_haml'],
		  'vehicle_name'=>null,
		  'vehicle_type'=>$vehicle_type,
		  'vehicle_number'=>$plak,
		  'net_weight'=>$row_resid['vazn_khales_r'],
		  'gross_weight'=>$row_resid['vazn_nakhales_r'],
		  'description'=>null,
		  'place_description'=>null,
		  'additional_information'=>null,
		  'receipt_items'=>$receipt_items
         );
		 
		 //ورودی ما
		 //چاپ آرایه
		 //if(SuperUser()) echo '<pre>'; print_r($params); echo '</pre>';

		 $result=preg_replace("/\\\\u([a-f0-9]{4})/e", "iconv('UCS-4LE','UTF-8',pack('V', hexdec('U$1')))", json_encode($params));
		 $encodedData = json_encode($params);

		 $curl = curl_init();
		 curl_setopt_array($curl, array(
          CURLOPT_URL => 'http://10.7.234.33/warehouse/api/warehouse/ReceiptPermanent',
          CURLOPT_USERPWD => 'ajix_agridam:3rt67HM',
		  CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
		  CURLOPT_CONNECTTIMEOUT => 60,
          CURLOPT_TIMEOUT => 60,
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

		  $array =json_decode($response,true); # آرایه
		  $object=json_decode($response);      # آبجکت
		  
		  $wb_error_code =$object->error_code;
		  $wb_error_message =$object->error_message;
		  $wb_creator =$object->creator;
		  $wb_create_date =$object->create_date;
		  $wb_id =$object->id;
	   
	   	// $encodedData = str_replace(array("\"{\"","\"}\""),array("'{\"","\"}'")
		             // ,str_replace(array('\"',"\\\\","'"),array('"',"\\")
			 	     // ,preg_replace("/\\\\u([a-f0-9]{4})/e", "iconv('UCS-4LE','UTF-8',pack('V', hexdec('U$1')))",($encodedData))));

		 // if(SuperUser()) echo '<br>';
 		 // if(SuperUser()) echo '<pre>';echo $encodedData;echo '</pre>';//ورودی ما
 		 // if(SuperUser()) echo '<br>';
		 // if(SuperUser()) print_r($array);//خروجی سامانه جامع
	   
	   
	   if(curl_exec($curl) === false)
       {
         echo "<script>alert('خطا در اتصال به صمت')</script>";
	     //echo "<script>alert('Curl error: curl_error($curl))</script>"; 
	   }
	   else
	   {	   
		if($object->error_code != 0)
        {
	     echo "<script>alert('خطا : \\n $object->error_message \\n کد خطا وزارت صمت :  $object->error_code ')</script>";
	     //exit();
        }
		else if($object->error_code == 0)
        {
		  echo "<script>alert('شناسه یکتا وزارت صمت\\n$wb_id')</script>";
        }
	    //2014:واحد غیرفعال است، لطفا جهت فعالسازی واحد به اداره صنعت، معدن و تجارت شهرستان مراجعه نمائید.
	    //wb_id:warehouse_id برگشت میخورد 
	    IF($wb_error_code=='2014') $wb_id='';
	    $update_track=("UPDATE resid SET wb_error_code='$wb_error_code',wb_error_message='$wb_error_message',wb_creator='$wb_creator',wb_create_date='$wb_create_date',wb_id='$wb_id' WHERE code_ostan=".$row_resid['code_ostan']." AND code_anbar=".$row_resid['code_anbar']." AND shomare_resid='".$row_resid['shomare_resid']."' AND year=$mtActiveYear");
	    $update_res=mysql_query($update_track);
	   }
	   curl_close($curl);	   	   
  }
   //echo "<script>window.location='$FileName?PageNo=".$PageNo."&RowPerPage=".$RowPerPage."&order=".$order."';</script>";     
}
/********************WEB SERVICE second time***********************/
// if(isset($send_resid))//مراحل ثبت در وب سرویس
// {
  // if($sabt_resid)//ثبت نهایی
  // {
  	// $update_sabt=("UPDATE resid SET sabt_nahayi=1 WHERE code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND shomare_resid='$shomare_resid_' AND year=$mtActiveYear");
	// $update_res_sabt=mysql_query($update_sabt);
  // }
  // $register_error_code=$db->get_from_where("register_error_code","list_sardkhane","code_ostan=".$mt_gl_code_ostan." AND code_anbar=".$mt_gl_code_anbar."");     
  // //////////////////////////////////NEW version//////////////////////////////////////////////
  // if(($_SESSION['mt_webservice']==1)AND($register_error_code==0))//اتصال به وب سرویس
  // {
	   // if(strlen($mt_gl_code_ostan)==1) $code_a=make_pattern($mt_gl_code_ostan,2);
       // else $code_a=$mt_gl_code_ostan;
	   // $shenaseAnbar=$code_a.$mt_gl_code_anbar;
       // $shomareGhabz=$mtActiveYear.$shomare_resid_;
	   // $q_resid="SELECT * From resid r INNER JOIN list_sardkhane l_s ON r.code_ostan=l_s.code_ostan AND r.code_anbar=l_s.code_anbar WHERE r.code_ostan=$mt_gl_code_ostan AND r.code_anbar=$mt_gl_code_anbar AND r.year=$mtActiveYear AND r.shomare_resid='$shomare_resid_'";
	   // $res_Resid = mysql_query($q_resid);
	   // $row_resid=mysql_fetch_assoc($res_Resid);
	   // //تبدیل تاریخ شمسی به میلادی
       // $sql_tarikh=$row_resid['tarikh_resid'];
       // $d=substr($sql_tarikh,8,2);$m=substr($sql_tarikh,5,2);$y=substr($sql_tarikh,0,4);
       // $milady=jalali_to_gregorian($y,$m,$d);
       // $sal=$milady[0];$mah=$milady[1];$rouz=$milady[2];
       // $tarikh_resid_MI=$sal.'-'.$mah.'-'.$rouz;
	   // if($row_resid['barname_no']=='')$BillLadingNo=null;
	   // else $BillLadingNo=$row_resid['barname_no']; 
	   // if($row_resid['plak4']=='')$plak4=null;
	   // else $plak4=$row_resid['plak4'];
	   // if($row_resid['plak3']=='')$plak3=null;
	   // else $plak3=$row_resid['plak3'];
	   // if($row_resid['plak2']=='')$plak2=null;
	   // else $plak2=$row_resid['plak2'];
	   // if($row_resid['plak1']=='')$Plak1=null;
	   // else $plak1=$row_resid['plak1'];
	   // $plak=$plak1.$plak2.$plak3.$plak4;
	   // //جابه جایی
	   // if(($row_resid['noe_tahvil_bar']==4)OR($row_resid['noe_tahvil_bar']==5))$processSequence=80;
	   // else $processSequence=71;
	   // $wsdl_url='http://10.7.234.33/anbar/warehouse.asmx?wsdl';
	   // header('Content-Type: text/html; charset=utf-8');
	   // try
	   // {
	     // $client=new SoapClient($wsdl_url);
         // $WarehouseDocumentDetails=array();
	     // $q_resid_k_d="SELECT * From resid_kala_detail r_k_d INNER JOIN kala ON kala.code_kala=r_k_d.code_kala  WHERE r_k_d.code_ostan=".$row_resid['code_ostan']." AND r_k_d.code_anbar=".$row_resid['code_anbar']." AND r_k_d.year=$mtActiveYear AND r_k_d.shomare_resid='".$row_resid['shomare_resid']."'";
	     // $res_Resid_k_d = mysql_query($q_resid_k_d);
	     // while($row_resid_k_d=mysql_fetch_assoc($res_Resid_k_d))//جزئیات کالا
	     // {
		   // // if(($row_resid_k_d['good_id']==null)OR($row_resid_k_d['good_id']=='')OR($row_resid_k_d['good_id']=='0')) $goodId=$row_resid_k_d['code_kala'];
	       // // else $goodId=$row_resid_k_d['good_id'];
		   // $goodId=$row_resid_k_d['code_kala'];
		   // IF($row_resid_k_d['code_vahedkala']==1)//کیلوگرم
	       // {
		      // $measurement_unit=1;
	          // $amount=$row_resid_k_d['vazn_khales_r_d_sub'];
	       // }
           // ELSE IF($row_resid_k_d['code_vahedkala']==2)//تعداد
	       // {
		      // $measurement_unit=6;
		      // $amount=$row_resid_k_d['tedad_karton_r_d_sub'];   
	       // } 
		   // $billStuff1=array(
		   // 'good_id'=>$goodId,
		   // 'measurement_unit'=>$measurement_unit,
           // 'amount'=>$amount,
           // 'production_type'=>$row_resid_k_d['mahmule_type']
           // );
           // array_push($WarehouseDocumentDetails,$billStuff1);
		 // }
		 // $WarehouseDocument =array(
		 // 'warehouse_id'=>$row_resid['warehouse_id'],
		 // 'gov_warehouse_number'=>$shenaseAnbar,
		 // 'number'=>$shomareGhabz,
         // 'issue_date'=>$tarikh_resid_MI,
         // 'owner'=>'14002771736',
         // 'owner_birth_date'=>null,
	     // 'driver_national_id'=>$row_resid['ranande_melicode'],
         // 'driver_birth_date'=>null,
		 // 'vehicle_number'=>$plak,
		 // 'bol_date'=>$row_resid['barname_tarikh'],
		 // 'bol_serial'=>$BillLadingNo,
		 // 'bol_series'=>null,	 
		 // 'bol_tid'=>null,	 
		 // 'Commodities'=>$WarehouseDocumentDetails	 
         // );
         // $params=array(
		  // 'username'=>'02',
          // 'password'=>'HJ78mnGD',
		  // 'co_national_id'=>'14002771736',
          // 'type'=>'in',
          // 'process_code'=>$processSequence,
          // 'doc'=>$WarehouseDocument
         // );
		  // $result=$client->SendWarehouseDocument($params); 
		  // $response=$result->SendWarehouseDocumentResult;
		  // $webservice_error_code =$response->error_code;
	      // $webservice_error_message =$response->error_message;
	      // $webservice_status =$response->status;
	      // $webservice_number =$response->number;
	      // $webservice_JahadTracking =$response->JahadTracking;
		 // echo "<script>alert('کد پیگیری وب سرویس نسخه جدید\\n$webservice_JahadTracking')</script>";
		 // //echo '<pre>'; print_r($params); echo '</pre>';
		 
	   // }
       // catch(SoapFault $client)
	   // {
		 // echo "<script>alert('وب سرویس فعال نمی باشد')</script>";
		 // echo  $e->getMessage();
	   // }
	   // $update_track_new=("UPDATE resid SET webservice_error_code='$webservice_error_code',webservice_error_message='$webservice_error_message',webservice_status='$webservice_status',webservice_number='$webservice_number',webservice_JahadTracking='$webservice_JahadTracking' WHERE code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND shomare_resid='$shomare_resid_' AND year=$mtActiveYear");
	   // $update_res=mysql_query($update_track_new);
  // }

   // echo "<script>window.location='$FileName?PageNo=".$PageNo."&RowPerPage=".$RowPerPage."&order=".$order."';</script>";     
// } 
/********************PAGING***********************/
if(isset($_POST['wRowPerPage'])) $RowPerPage=$_POST['wRowPerPage'];
if(!isset($RowPerPage)) $RowPerPage=8;
//نقش ناظر کیفی
//if($_SESSION['mt_role']==8)$res=$db->query("SELECT (T.id) From $TableName AS T INNER JOIN resid_detail AS r_d ON r_d.shomare_resid=T.shomare_resid AND r_d.code_ostan=T.code_ostan AND r_d.code_anbar=T.code_anbar AND r_d.year=T.year INNER JOIN resid_kala_detail AS r_k_d ON r_d.shomare_resid=r_k_d.shomare_resid AND r_d.code_ostan=r_k_d.code_ostan AND r_d.code_anbar=r_k_d.code_anbar AND r_d.year=r_k_d.year AND r_d.code_kala=r_k_d.code_kala AND r_d.code_keshvar=r_k_d.code_keshvar AND r_d.code_tolidkonande=r_k_d.code_tolidkonande WHERE 1=1 ".$_SESSION['mt_search_resid']." AND T.code_ostan='$mt_gl_code_ostan' AND T.code_anbar='$mt_gl_code_anbar' AND T.year='$mtActiveYear' AND T.deleted=0 AND T.status=0 AND T.taeed_nazer=0 GROUP BY T.shomare_resid,T.code_ostan,T.code_anbar,T.year");
//else
	$res=$db->query("SELECT (T.id) From $TableName AS T LEFT OUTER JOIN resid_detail AS r_d ON r_d.shomare_resid=T.shomare_resid AND r_d.code_ostan=T.code_ostan AND r_d.code_anbar=T.code_anbar AND r_d.year=T.year LEFT OUTER JOIN resid_kala_detail AS r_k_d ON r_d.shomare_resid=r_k_d.shomare_resid AND r_d.code_ostan=r_k_d.code_ostan AND r_d.code_anbar=r_k_d.code_anbar AND r_d.year=r_k_d.year AND r_d.code_kala=r_k_d.code_kala AND r_d.code_keshvar=r_k_d.code_keshvar AND r_d.code_tolidkonande=r_k_d.code_tolidkonande WHERE 1=1 ".$_SESSION['mt_search_resid']." AND T.code_ostan='$mt_gl_code_ostan' AND T.code_anbar='$mt_gl_code_anbar' AND T.year='$mtActiveYear' AND T.deleted=0 GROUP BY T.shomare_resid,T.code_ostan,T.code_anbar,T.year");
$row = $db->fetch_array($res);
$cnt = mysql_num_rows($res);
//$cnt = $row[0];
$MaxPage=intval($cnt/$RowPerPage);
if ($cnt%$RowPerPage) $MaxPage++;
if (!$MaxPage) $MaxPage=1;
if (!isset($PageNo)) $PageNo=1; //$PageNo=$MaxPage;  
$NextPage=$PageNo+1;
$PrevPage=$PageNo-1;
if (!$cnt)
 {$En_Prev="Disabled";$En_Next="Disabled";}
else
 {$En_Prev="";$En_Next="";}
if ($PageNo==$MaxPage) $En_Next="onclick=\'return false;\'";
if ($PageNo==1) $En_Prev="onclick=\'return false;\'";
$FirstRow=$PrevPage*$RowPerPage;
if ($FirstRow<0) $FirstRow=0;
$Limit="Limit ".$FirstRow.",".$RowPerPage;
$radif=$FirstRow+1;
//if($_SESSION['mt_role']==8)$res_jary=$db->query("SELECT (T.id) From $TableName AS T INNER JOIN resid_detail AS r_d ON r_d.shomare_resid=T.shomare_resid AND r_d.code_ostan=T.code_ostan AND r_d.code_anbar=T.code_anbar AND r_d.year=T.year INNER JOIN resid_kala_detail AS r_k_d ON r_d.shomare_resid=r_k_d.shomare_resid AND r_d.code_ostan=r_k_d.code_ostan AND r_d.code_anbar=r_k_d.code_anbar AND r_d.year=r_k_d.year AND r_d.code_kala=r_k_d.code_kala AND r_d.code_keshvar=r_k_d.code_keshvar AND r_d.code_tolidkonande=r_k_d.code_tolidkonande WHERE 1=1 ".$_SESSION['mt_search_resid']." AND T.code_ostan='$mt_gl_code_ostan' AND T.code_anbar='$mt_gl_code_anbar' AND T.year='$mtActiveYear' AND T.deleted=0 AND T.status=0 AND T.taeed_nazer=0 GROUP BY T.shomare_resid,T.code_ostan,T.code_anbar,T.year");
//else
	$res_jary=$db->query("SELECT (T.id) From $TableName AS T LEFT OUTER JOIN resid_detail AS r_d ON r_d.shomare_resid=T.shomare_resid AND r_d.code_ostan=T.code_ostan AND r_d.code_anbar=T.code_anbar AND r_d.year=T.year LEFT OUTER JOIN resid_kala_detail AS r_k_d ON r_d.shomare_resid=r_k_d.shomare_resid AND r_d.code_ostan=r_k_d.code_ostan AND r_d.code_anbar=r_k_d.code_anbar AND r_d.year=r_k_d.year AND r_d.code_kala=r_k_d.code_kala AND r_d.code_keshvar=r_k_d.code_keshvar AND r_d.code_tolidkonande=r_k_d.code_tolidkonande WHERE 1=1 ".$_SESSION['mt_search_resid']." AND T.code_ostan='$mt_gl_code_ostan' AND T.code_anbar='$mt_gl_code_anbar' AND T.year='$mtActiveYear' AND T.deleted=0 AND T.status=0 GROUP BY T.shomare_resid,T.code_ostan,T.code_anbar,T.year");
$tedad_jary = mysql_num_rows($res_jary);
//if($_SESSION['mt_role']==8)$res_ebtaly=$db->query("SELECT (T.id) From $TableName AS T INNER JOIN resid_detail AS r_d ON r_d.shomare_resid=T.shomare_resid AND r_d.code_ostan=T.code_ostan AND r_d.code_anbar=T.code_anbar AND r_d.year=T.year INNER JOIN resid_kala_detail AS r_k_d ON r_d.shomare_resid=r_k_d.shomare_resid AND r_d.code_ostan=r_k_d.code_ostan AND r_d.code_anbar=r_k_d.code_anbar AND r_d.year=r_k_d.year AND r_d.code_kala=r_k_d.code_kala AND r_d.code_keshvar=r_k_d.code_keshvar AND r_d.code_tolidkonande=r_k_d.code_tolidkonande WHERE 1=1 ".$_SESSION['mt_search_resid']." AND T.code_ostan='$mt_gl_code_ostan' AND T.code_anbar='$mt_gl_code_anbar' AND T.year='$mtActiveYear' AND T.deleted=0 AND T.status=1 AND T.taeed_nazer=0 GROUP BY T.shomare_resid,T.code_ostan,T.code_anbar,T.year");
//else
	$res_ebtaly=$db->query("SELECT (T.id) From $TableName AS T LEFT OUTER JOIN resid_detail AS r_d ON r_d.shomare_resid=T.shomare_resid AND r_d.code_ostan=T.code_ostan AND r_d.code_anbar=T.code_anbar AND r_d.year=T.year LEFT OUTER JOIN resid_kala_detail AS r_k_d ON r_d.shomare_resid=r_k_d.shomare_resid AND r_d.code_ostan=r_k_d.code_ostan AND r_d.code_anbar=r_k_d.code_anbar AND r_d.year=r_k_d.year AND r_d.code_kala=r_k_d.code_kala AND r_d.code_keshvar=r_k_d.code_keshvar AND r_d.code_tolidkonande=r_k_d.code_tolidkonande WHERE 1=1 ".$_SESSION['mt_search_resid']." AND T.code_ostan='$mt_gl_code_ostan' AND T.code_anbar='$mt_gl_code_anbar' AND T.year='$mtActiveYear' AND T.deleted=0 AND T.status=1 GROUP BY T.shomare_resid,T.code_ostan,T.code_anbar,T.year");
$tedad_ebtaly = mysql_num_rows($res_ebtaly);
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.shomare_resid.focus();">
<form method="post" name="myform">
<div align="center">
<table width="99%" height="100%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr>
  <td class="title">
   <div style="position:absolute;top:5px;left:47%;">'.$titr.'</div>
   <div class="pagecover">[صفحه:&nbsp'.$PageNo.' از '.$MaxPage.']</div>
  </td>	 
 </tr>
 <!--پايان هدر-->
 <!-- مرکز صفحه--> 
 <tr>
  <td height="100%">
   <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
	<tr class="table-title">';
/********************sort field***********************/
if(!isset($order))    $order='id DESC';
if(!isset($sortcode)) $sortcode='1';
if(!isset($sorttarikh)) $sorttarikh='1';
if(!isset($sorttahvil)) $sorttahvil='1';
if(!isset($sortstatus)) $sortstatus='1';
if(!isset($show_img)) $show_img='';
    //echo'<td width="5%">ردیف</td>';
	if($sortcode=='1')
	{echo'<td width="10%" title="مرتب سازی صعودی شماره رسيد" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=code_ostan ASC,code_anbar ASC,shomare_resid ASC&sortcode=2&show_img=1\'"/> شماره رسيد ';
	  if($show_img=='1')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sortcode=='2')
	{echo'<td width="10%" title="مرتب سازی نزولی شماره رسيد" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=code_ostan DESC,code_anbar DESC,shomare_resid DESC&sortcode=1&show_img=1\'"/> شماره رسيد ';
	  if($show_img=='1')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sorttarikh=='1')
	{echo'<td width="10%" title="مرتب سازی صعودی تاریخ رسید" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=tarikh_resid ASC&sorttarikh=2&show_img=2\'"/> تاریخ رسید '; 
	  if($show_img=='2')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sorttarikh=='2')
	{echo'<td width="10%" title="مرتب سازی نزولی تاریخ رسید" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=tarikh_resid DESC&sorttarikh=1&show_img=2\'"/> تاریخ رسید '; 
	  if($show_img=='2')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
    if($sorttahvil=='1')
	{echo'<td width="15%" title="مرتب سازی صعودی نوع تحویل" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=noe_tahvil_bar ASC&sorttahvil=2&show_img=4\'"/> نوع تحویل '; 
	  if($show_img=='4')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sorttahvil=='2')
	{echo'<td width="15%" title="مرتب سازی نزولی نوع تحویل" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=noe_tahvil_bar DESC&sorttahvil=1&show_img=4\'"/> نوع تحویل '; 
	  if($show_img=='4')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	echo'
	<td width="7%">تعداد</td>
	<td width="10%">وزن ناخالص</td>
	<td width="10%">وزن خالص</td>';
	if($sortstatus=='1')
	{echo'<td width="5%" title="مرتب سازی صعودی وضعیت" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=status ASC&sortstatus=2&show_img=5\'"/> وضعیت ';
	  if($show_img=='5')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sortstatus=='2')
	{echo'<td width="5%" title="مرتب سازی نزولی وضعیت" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=status DESC&sortstatus=1&show_img=5\'"/> وضعیت ';
	  if($show_img=='5')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	echo'
	 <td width="10%">اطلاعات کالا</td>
	 <td width="5%">تأیید ناظر</td>
	 <td width="6%">ثبت نهایی</td>';
	 if($_SESSION['mt_webservice']==1) echo'<td width="4%">ارسال</td>';
	 echo'<td width="3%">جواز ابطال</td>';
	 if($right_prt)echo'<td width="4%">چاپ</td>';
	 if(($right_del)and($_SESSION['mtStatusYear']==0))echo'<td width="3%">حذف</td>';
	echo'
	</tr>';
	$i=0;
	//نقش ناظر کیفی
	// if($_SESSION['mt_role']==8)
    // {$q1="SELECT T.* From $TableName T
	     // INNER JOIN resid_detail AS r_d ON r_d.shomare_resid=T.shomare_resid AND r_d.code_ostan=T.code_ostan AND r_d.code_anbar=T.code_anbar AND r_d.year=T.year
	     // INNER JOIN resid_kala_detail AS r_k_d ON r_d.shomare_resid=r_k_d.shomare_resid AND r_d.code_ostan=r_k_d.code_ostan AND r_d.code_anbar=r_k_d.code_anbar AND r_d.year=r_k_d.year AND r_d.code_kala=r_k_d.code_kala AND r_d.code_keshvar=r_k_d.code_keshvar AND r_d.code_tolidkonande=r_k_d.code_tolidkonande 
		 // WHERE 1=1 ".$_SESSION['mt_search_resid']." AND T.code_ostan=$mt_gl_code_ostan AND T.code_anbar=$mt_gl_code_anbar AND T.year=$mtActiveYear AND T.deleted=0 AND T.status=0 AND T.taeed_nazer=0  GROUP BY T.shomare_resid,T.code_ostan,T.code_anbar,T.year ORDER BY $order $Limit";
	// }
	//else //سایر نقش ها
	//{
		$q1="SELECT T.* From $TableName T
	     LEFT OUTER JOIN resid_detail AS r_d ON r_d.shomare_resid=T.shomare_resid AND r_d.code_ostan=T.code_ostan AND r_d.code_anbar=T.code_anbar AND r_d.year=T.year
	     LEFT OUTER JOIN resid_kala_detail AS r_k_d ON r_d.shomare_resid=r_k_d.shomare_resid AND r_d.code_ostan=r_k_d.code_ostan AND r_d.code_anbar=r_k_d.code_anbar AND r_d.year=r_k_d.year AND r_d.code_kala=r_k_d.code_kala AND r_d.code_keshvar=r_k_d.code_keshvar AND r_d.code_tolidkonande=r_k_d.code_tolidkonande 
		 WHERE 1=1 ".$_SESSION['mt_search_resid']." AND T.code_ostan=$mt_gl_code_ostan AND T.code_anbar=$mt_gl_code_anbar AND T.year=$mtActiveYear AND T.deleted=0 GROUP BY T.shomare_resid,T.code_ostan,T.code_anbar,T.year ORDER BY $order $Limit";
	//}				  
	$allResid = $db->query($q1);
    while($row1=$db->fetch_assoc($allResid))
	{
	  $detailcount=$db->get_from_where("count(*)","resid_detail","shomare_resid=".$row1['shomare_resid']." AND code_ostan=".$row1['code_ostan']." AND code_anbar=".$row1['code_anbar']." AND year=".$row1['year']."");
	  $detailkalacount=$db->get_from_where("count(*)","resid_kala_detail","shomare_resid=".$row1['shomare_resid']." AND code_ostan=".$row1['code_ostan']." AND code_anbar=".$row1['code_anbar']." AND year=".$row1['year']."");
	  //وزن خالص به صورت محاسباتی
	  // $sum_karton_r=0;
	  // $vazn_khales_r=0;
	  // //resid_detail اطلاعات از
	  // $q_d="SELECT *,
          // (SELECT SUM(vazn_nakhales_r_d_sub) FROM resid_kala_detail r_k_d WHERE r_k_d.code_kala=r_d.code_kala AND r_k_d.code_keshvar=r_d.code_keshvar AND r_k_d.shomare_resid=r_d.shomare_resid AND r_k_d.code_ostan=r_d.code_ostan AND r_k_d.code_anbar=r_d.code_anbar AND r_k_d.year=r_d.year) vazn_nakhales_r_d,				  
          // (SELECT SUM(tedad_karton_r_d_sub) FROM resid_kala_detail r_k_d WHERE r_k_d.code_kala=r_d.code_kala AND r_k_d.code_keshvar=r_d.code_keshvar AND r_k_d.shomare_resid=r_d.shomare_resid AND r_k_d.code_ostan=r_d.code_ostan AND r_k_d.code_anbar=r_d.code_anbar AND r_k_d.year=r_d.year) tedad_karton_r_d		
	      // From resid_detail r_d WHERE r_d.shomare_resid='".$row1['shomare_resid']."' AND r_d.code_ostan=$mt_gl_code_ostan AND r_d.code_anbar=$mt_gl_code_anbar AND r_d.year=$mtActiveYear";	 
	   // $res_d = $db->query($q_d);
       // while($row_d=$db->fetch_assoc($res_d))
	   // {
	    // $sum_karton_r_d=$row_d['tedad_karton_r_d']*$row_d['vazn_karton_this'];//مجموع وزن کارتن ها
	    // $sum_karton_r+=$sum_karton_r_d;
	    // $vazn_khales_r_d=$row_d['vazn_nakhales_r_d']-$sum_karton_r_d;//وزن خالص
	    // $vazn_khales_r+=$vazn_khales_r_d;
	   // }
	 if($i++%2)
	 {echo'<tr '; if($row1['status']==0) echo' class="table-odd"'; else echo 'class="row-ebtal"';echo'>';}	 
     else
	 {echo'<tr '; if($row1['status']==0) echo' class="table-even"'; else echo 'class="row-ebtal"';echo'>';}
     //if($right_edt)
	  $edtClick='onClick="window.location=\'resid_edit.php?id_='.$row1['id'].'&shomare_resid_='.$row1['shomare_resid'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'"';	 
	 if(strlen($row1['code_ostan'])==1) $code_a=make_pattern($row1['code_ostan'],2);
     else $code_a=$row1['code_ostan'];
	 echo'
	  <!--<td '.$edtClick.'>'.$radif++.'</td>-->
	  <td '.$edtClick.'>'.$code_a.$row1['code_anbar'].$row1['shomare_resid'].'</td>
	  <td '.$edtClick.'>'.$row1['tarikh_resid'].'</td>
	  <td '.$edtClick.'>'.$tahvilbarArr[$row1['noe_tahvil_bar']].'</td>
	  <td '.$edtClick.'>'.($row1['tedad_karton_r']).'</td>
	  <td '.$edtClick.'>'.round($row1['vazn_nakhales_r'],3).'</td>
	        <!--<td '.$edtClick.'>'.($vazn_khales_r).'</td>--><!--محاسباتی-->
	  <td '.$edtClick.'>'.round($row1['vazn_khales_r'],3).'</td>';
      echo'<td '.$edtClick.'>';if($row1['status']==0) echo 'جاری';else echo 'ابطالی </td>';	  
	  echo '<td>';
	  if($right_detail)
	  {
	   if($row1['status']==0)//اگر رسید جاری است
	   {
	    //اگر هنوز جزئیات ندارد
		if($detailcount==0) echo'<input type="button" class="button-inline buttonme-empty" value="*اطلاعات کالا ['.$detailcount.']" onClick="window.location=\'resid_detail.php?id_resid_='.$row1['id'].'&shomare_resid_='.$row1['shomare_resid'].'&noe_tahvil_bar_='.$row1['noe_tahvil_bar'].'&code_bastebandy_='.$row1['code_bastebandy'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'">';
	    else echo'<input type="button" class="button-inline"  value="اطلاعات کالا ['.$detailcount.']" onClick="window.location=\'resid_detail.php?id_resid_='.$row1['id'].'&shomare_resid_='.$row1['shomare_resid'].'&noe_tahvil_bar_='.$row1['noe_tahvil_bar'].'&code_bastebandy_='.$row1['code_bastebandy'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'">';
	   }
	   else //اگر رسید ابطالی است
	   {
	    //اگر هنوز جزئیات ندارد
	    if($detailcount==0)	echo'<input type="button" class="buttonme-ebtal"  value="ابطال شد ['.$detailcount.']" style="cursor:default">';
	    else echo'<input type="button" class="buttonme-ebtal"  value="ابطال شد ['.$detailcount.']" onClick="window.location=\'resid_detail.php?id_resid_='.$row1['id'].'&shomare_resid_='.$row1['shomare_resid'].'&noe_tahvil_bar_='.$row1['noe_tahvil_bar'].'&code_bastebandy_='.$row1['code_bastebandy'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'">';
	   }
	  }
	  echo'
	  </td>';
	  /**** تأیید ناظر به غیر از حالت جابه جایی*****/
	  if(($row1['noe_tahvil_bar']!=4)and($row1['noe_tahvil_bar']!=5))
	  {
	   if($row1['taeed_nazer']==1)echo'<td style="cursor:text;"><img src="images/confirm.png" title="تأیید شده"/></td>';
	   else if(($row1['taeed_nazer']==0)and($detailcount!=0)and($detailkalacount!=0)and($row1['status']==0))
	   {
	    // //نقش ناظر کیفی  و سوپریوزر
		// if(($_SESSION['mt_role']==8)or(SuperUser()))
	    // {echo'<td><img src="images/notconfirm.png" onmouseOver="this.src=\'images/notconfirm_hover.png\'" onmouseOut="this.src=\'images/notconfirm.png\'" title="تأیید"
                 // onClick="window.location=\''.$FileName.'?id_='.$row1['id'].'&shomare_resid_='.$row1['shomare_resid'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&taeed_nazer=1\'" /></td>';
	    // }
	    // //سایر نقش ها
	    // else echo'<td style="cursor:text;"><img src="images/notconfirm.png"/></td>';
	    if(($right_taeed_nazer)or($_SESSION['mt_role']==8))
	    {echo'<td><img src="images/notconfirm.png" onmouseOver="this.src=\'images/notconfirm_hover.png\'" onmouseOut="this.src=\'images/notconfirm.png\'" title="تأیید"
                 onClick="window.location=\''.$FileName.'?id_='.$row1['id'].'&shomare_resid_='.$row1['shomare_resid'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&taeed_nazer=1\'" /></td>';
	    }
		else echo'<td style="cursor:text;"><img src="images/notconfirm.png"/></td>';
	   }
	   else echo'<td style="cursor:text;">&nbsp;</td>';
	  }
	  //جابه جایی تأیید ندارد
	  else echo'<td style="cursor:text;">&nbsp;</td>'; 
	  /****ثبت نهایی*****/
	  if($row1['sabt_nahayi']==1)echo'<td style="cursor:text;"><img src="images/save-accept.png" /></td>';
	  else if(($row1['taeed_nazer']==1)and($row1['sabt_nahayi']==0)and($detailcount!=0)and($detailkalacount!=0)and($row1['status']==0))
	  {
	   //نقش ناظر کیفی 
	   if($_SESSION['mt_role']==8) echo'<td style="cursor:text;"><img src="images/save.png"/></td>';
	   else
	   {
	     if($row1['tarikh_resid']==$today)
		 {
		  echo'<td><img src="images/save.png" onmouseOver="this.src=\'images/save_hover.png\'" onmouseOut="this.src=\'images/save.png\'" title="ثبت نهایی رسید"
                     onClick="window.location=\''.$FileName.'?id_='.$row1['id'].'&shomare_resid_='.$row1['shomare_resid'].'&noe_tahvil_bar_='.$row1['noe_tahvil_bar'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&send_resid=1&sabt_resid=1\'" /></td>';
		 }
		 else 
		 {
		  echo'<td style="cursor:text;"><img src="images/info2.png" title="برای ثبت نهایی کردن رسید تاریخ رسید را به روز نمایید"/></td>';
		 }
	   }
	  }
	  
	  else echo'<td style="cursor:text;">&nbsp;</td>';
	  if($_SESSION['mt_webservice']==1)//متصل به وب سرویس
	  { 
		if(($row1['wb_id']=='' OR $row1['wb_id']==0)and($row1['sabt_nahayi']==1)and($row1['status']==0)and($detailcount!=0)and($detailkalacount!=0)) 
	    { echo'<td><div class="webservise" id="webservise-add"  title="شناسه یکتا وزارت صمت : '.$row1['wb_id'].'"  onClick="window.location=\''.$FileName.'?id_='.$row1['id'].'&shomare_resid_='.$row1['shomare_resid'].'&noe_tahvil_bar_='.$row1['noe_tahvil_bar'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&send_resid=1\'"></div></td>';}
		else if((strlen($row1['wb_id'])==14))//درست ارسال شده	      
	    {
		  IF($row1['status']==0)//جاری	
		   echo'<td><div class="webservise" id="webservise-accept-resend" title="شناسه یکتا وزارت صمت : '.$row1['wb_id'].'"  onClick="window.location=\''.$FileName.'?id_='.$row1['id'].'&shomare_resid_='.$row1['shomare_resid'].'&noe_tahvil_bar_='.$row1['noe_tahvil_bar'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&send_resid=1\'"></div></td>';
		  ELSE //ابطالی	
		  	 echo'<td><img src="images/accept_database.png" title="شناسه یکتا وزارت صمت : '.$row1['wb_id'].'"/></td>';
		}
        else echo'<td style="cursor:text;">&nbsp;</td>';
	  }
	  #seconde time
	  // if($_SESSION['mt_webservice']==1)//متصل به وب سرویس
	  // { 
		// if(($row1['webservice_JahadTracking']=='' OR $row1['webservice_JahadTracking']==0)and($row1['sabt_nahayi']==1)and($row1['status']==0)and($detailcount!=0)and($detailkalacount!=0)) 
	    // { echo'<td><div class="webservise" id="webservise-add"  title="کد رهگیری وب سرویس : '.$row1['webservice_JahadTracking'].'"  onClick="window.location=\''.$FileName.'?id_='.$row1['id'].'&shomare_resid_='.$row1['shomare_resid'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&send_resid=1\'"></div></td>';}
		// else if((strlen($row1['webservice_JahadTracking'])==28))//درست ارسال شده	      
	    // {
		  // IF($row1['status']==0)//جاری	
		   // echo'<td><div class="webservise" id="webservise-accept-resend" title="کد رهگیری وب سرویس : '.$row1['webservice_JahadTracking'].'"  onClick="window.location=\''.$FileName.'?id_='.$row1['id'].'&shomare_resid_='.$row1['shomare_resid'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&send_resid=1\'"></div></td>';
		  // ELSE //ابطالی	
		  	 // echo'<td><img src="images/accept_database.png" title="کد رهگیری وب سرویس : '.$row1['webservice_JahadTracking'].'"/></td>';
		// }
        // else echo'<td style="cursor:text;">&nbsp;</td>';
	  // }
	  #first time
	  // if($_SESSION['mt_webservice']==1)//متصل به وب سرویس
	  // { 
	    // $first_num=substr($row1['webservice_trackcode'],0,1);//اولین رقم
		// if(($row1['webservice_trackcode']=='' OR $row1['webservice_trackcode']==0)and($row1['sabt_nahayi']==1)and($row1['status']==0)and($detailcount!=0)and($detailkalacount!=0)) 
	    // { echo'<td><div class="webservise" id="webservise-add"  title="کد رهگیری وب سرویس : '.$row1['webservice_trackcode'].'"  onClick="window.location=\''.$FileName.'?id_='.$row1['id'].'&shomare_resid_='.$row1['shomare_resid'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&send_resid=1\'"></div></td>';}
		// else if((strlen($row1['webservice_trackcode'])==26)and($first_num!=0)and($row1['status']==0)and($detailcount!=0)and($detailkalacount!=0)) 
	    // { 
	      // IF($first_num==1)//تکراری
		    // echo'<td><div class="webservise" id="webservise-delete-resend" title="کد رهگیری وب سرویس : '.$row1['webservice_trackcode'].'" onClick="window.location=\''.$FileName.'?id_='.$row1['id'].'&shomare_resid_='.$row1['shomare_resid'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&send_resid=1&resend_resid=1\'"></div></td>';
		  // ELSE//سایر ایرادها  
		    // echo'<td><div class="webservise" id="webservise-delete-add" title="کد رهگیری وب سرویس : '.$row1['webservice_trackcode'].'"  onClick="window.location=\''.$FileName.'?id_='.$row1['id'].'&shomare_resid_='.$row1['shomare_resid'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&send_resid=1\'"></div></td>';
		// }
		// else if((strlen($row1['webservice_trackcode'])==26)and($first_num==0))//درست ارسال شده	      
	    // {
		  // IF($row1['status']==0)//جاری	
		   // echo'<td><div class="webservise" id="webservise-accept-resend" title="کد رهگیری وب سرویس : '.$row1['webservice_trackcode'].'"  onClick="window.location=\''.$FileName.'?id_='.$row1['id'].'&shomare_resid_='.$row1['shomare_resid'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&send_resid=1&resend_resid=1\'"></div></td>';
		  // ELSE //ابطالی	
		  	 // echo'<td><img src="images/accept_database.png" title="کد رهگیری وب سرویس : '.$row1['webservice_trackcode'].'"/></td>';
		// }
	    // else if((strlen($row1['webservice_trackcode'])==26)and($first_num!=0)and($row1['sabt_nahayi']==1)and($row1['status']==1))echo'<td><img src="images/delete_database.png" title="کد رهگیری وب سرویس : '.$row1['webservice_trackcode'].'"/></td>';
        // else echo'<td style="cursor:text;">&nbsp;</td>';
	  // }
	  echo'
	  <td>';
	     if($row1['javaz_ebtal'] == 1)     {echo'<div class="fa fa-check-circle fa-2x" style="color:green"  '; IF($right_javaz_ebtal) {echo' title="در صورت کلیک روی این گزینه مجوز ابطال رسید حذف میشود" onClick="window.location=\''.$FileName.'?id_='.$row1['id'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&adam_ebtal=1\'"';} echo' /></div>';}
	     else if($row1['javaz_ebtal'] == 0){echo'<div class="fa fa-times-circle fa-2x" style="color:red"    '; IF($right_javaz_ebtal) {echo' title="در صورت کلیک روی این گزینه مجوز ابطال رسید داده میشود"  onClick="window.location=\''.$FileName.'?id_='.$row1['id'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&emkan_ebtal=1\'"';} echo' /></div>';}
	     echo'
	  </td>';
	  
	  
	  if($right_prt)
	  {
	   if (SuperUser())
	   {
	    $prt_resid_count=$db->get_from_where("prt_resid_count","$TableName","id=".$row1['id']."");     
	   	//if($row1['sabt_nahayi']==1)
		echo'<td align="center"><span style="float:right">'.$prt_resid_count.'</span><div onClick="window.open(\'print_resid_one.php?id_='.$row1['id'].'&clk_p_r=1\',\'_blank\',\'scrollbars=yes\')" id="printer_T" title="چاپ رسید" style="float:center"><a href="#"></a></div></td>';
	   	//else echo'<td style="cursor:text;">&nbsp;</td>';
	   }
	   else
	   {
	    if($row1['sabt_nahayi']==1)echo'<td align="center"><div onClick="window.open(\'print_resid_one.php?id_='.$row1['id'].'&clk_p_r=1\',\'_blank\',\'scrollbars=yes\')" id="printer_T" title="چاپ رسید"><a href="#"></a></div></td>';
	    else echo'<td style="cursor:text;">&nbsp;</td>';
	   }
	  }
	  if(($right_del)and($_SESSION['mtStatusYear']==0))
	  {echo'<td><img border="0" src="images/trash.png" width="20" height="20" 
	       onmouseOver="this.src=\'images/trash_hover.png\'" 
		   onmouseOut="this.src=\'images/trash.png\'" 
		   onClick="iconfirm(\''.$FileName.'?Delete_x=1&id_='.$row1['id'].'&shomare_resid_='.$row1['shomare_resid'].'&status_='.$row1['status'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\',\'براي حذف رسید '.$code_a.$row1['code_anbar'].$row1['shomare_resid'].' \')" /></td>';
	  }	  
	 echo '
	</tr>';
	}
    for ($r=$i+1; $r<=$RowPerPage; $r++)
    {  	  
	 if($r%2) echo'<tr class="table-even">';
     else echo '<tr class="table-odd">';
     echo '
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>';
	  if($_SESSION['mt_webservice']==1) echo'<td>&nbsp;</td>';
	  if($right_prt)echo'<td>&nbsp;</td>';
	  if(($right_del)and($_SESSION['mtStatusYear']==0)) echo'<td>&nbsp;</td>';
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
  <td>
   <table width="100%"  border="0" cellspacing="0" cellpadding="0" height=100%  style="margin-bottom:20px;">';
   if (!$Mode)
   {echo '	  			
	<tr>
	 <td width="10px">&nbsp;</td>';
	 
	 //اگر اجازه ایجاد رسید را دارد و وضعیت سال فعال است و سال فعال سال جاری است
     //و در یک هفته اخیر رسید نهایی نشده نداریم
	 //if(($right_ins)and($_SESSION['mtStatusYear']==0)and($_SESSION["mtActiveYear"]==$yy))
	 $exist_sabtnahayi_nashode=$db->get_from_where("COUNT(*)","resid","code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND year=$mtActiveYear AND deleted=0 AND status=0 AND sabt_nahayi=0 AND tarikh_resid<'".$Condition_SabtNashodeDate_sh."'");	 		    
     //حواله هایی که رسیدشان را نزده ایم و یک هفته از تاریخ حواله گذشته
     $count_havale_for_this_oneweek=$db->get_from_where("COUNT(*)","havale INNER JOIN mojavez_jabejae ON havale.shomare_jabejae = mojavez_jabejae.shomare_jabejae AND havale.code_ostan = mojavez_jabejae.code_ostan AND havale.code_anbar = mojavez_jabejae.code_anbar AND havale.year = mojavez_jabejae.year","code_ostan_maghsad_j=$mt_gl_code_ostan AND code_anbar_maghsad_j=$mt_gl_code_anbar AND mojavez_jabejae.year=$mtActiveYear AND tarikh_havale_anbar<'".$Condition_SabtNashodeDate_sh."' AND havale.status=0 AND havale.deleted=0 AND havale.sabt_nahayi=1 AND havale.tarikh_havale_anbar>='$Condition_JabejaeDate_sh' AND noe_tahvil_bar=4 AND(havale.shomare_havale_anbar NOT IN(SELECT shomare_havale_anbar FROM resid WHERE code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND year=$mtActiveYear AND code_ostan_mabda=havale.code_ostan AND code_anbar_mabda=havale.code_anbar AND shomare_havale_anbar=havale.shomare_havale_anbar AND year=havale.year AND deleted=0 AND status=0 AND (noe_tahvil_bar=4 or noe_tahvil_bar=5)))");

	 IF(($right_ins)and($_SESSION['mtStatusYear']==0)and($exist_sabtnahayi_nashode==0)and($_SESSION['mt_anbar_activate']==1))
	 {
	 echo'<td width="70px"><div onClick="window.location=\'resid_new.php?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-new" title="افزودن رکورد جديد" ><a href="#"></a></div></td>	                      
	       <td width="10px">&nbsp;</td>';}
	 ELSE IF($exist_sabtnahayi_nashode>0)
	 {
	  echo'<td width="20px"><div><span class="simptip-position-left simptip-fade simptip-info" data-tooltip="لطفاً رسیدها را ثبت نهایی کنید">
           <img class="help blinkelement" border="0" src="images/info2.png" style="cursor:pointer"/>
           </span></div>
		   </td>	                      
	       <td width="10px">&nbsp;</td>';
	 }
	 IF($count_havale_for_this_oneweek>0)
	 {
	  echo'<td width="20px"><div><span span class="simptip-position-left simptip-multiline simptip-fade simptip-info" data-tooltip="تعدادی حواله حابه جایی داشته اید که از تاریخ ثبت حواله یک هفته گذشته و هنوز ثبت نکرده اید">
           <img class="help blinkelement" border="0" src="images/info2.png" style="cursor:pointer"/>
           </span></div>
		   </td>	                      
	       <td width="10px">&nbsp;</td>';
	 }
	 
	 echo'<td width="70px"><div onClick="window.location=\''.$FileName.'?Mode=Search&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-search" title="جستجو" ><a href="#"></a></div></td>
	 <td width="10px">&nbsp;</td>
	 <td width="70px"><div onClick="window.location=\'my_frame.php\'" id="btn-back" title="بازگشت به منوی اصلی"><a href="#"></a></div></td> 
	 <td width="20px">&nbsp;</td>	   
	 <td width="22px"><div '.$En_Prev.' onClick="window.location=\''.$FileName.'?PageNo=1&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-pageone" title="رويت اولين صفحه"><a href="#"></a></div></td>
	 <td width="2px">&nbsp;</td>
	 <td width="22px"><div '.$En_Prev.' onClick="window.location=\''.$FileName.'?PageNo='.$PrevPage.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-perevius" title="رفتن به صفحه قبلي"><a href="#"></a></div></td>
     <td width="2">&nbsp;</td>
	 <td width="40" align="center"><input type="text" name="PageNo" value="'.$PageNo.'" size="2" onChange="myform.submit();" onkeypress="return isNumber(event)" style="direction:ltr;text-align:center;"></td>		   
	 <td width="2">&nbsp;</td>		   
	 <td width="22px"><div '.$En_Next.' onClick="window.location=\''.$FileName.'?PageNo='.$NextPage.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-forward" title="رفتن به صفحه بعدي"><a href="#"></a></div></td>
     <td width="2px">&nbsp;</td>		   
	 <td width="22px"><div '.$En_Next.' onClick="window.location=\''.$FileName.'?PageNo='.$MaxPage.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-pageend" title="رويت آخرين صفحه"><a href="#" ></a></div></td>
	 <td width="2">&nbsp;</td>
	 <td width="65" align="left"><span class="text1">تعداد خط :</span></td>
	 <td align="right"><input type="text" name="wRowPerPage" value="'.$RowPerPage.'" size="2" onChange="myform.submit()" onkeypress="return isNumber(event)" style="direction:ltr;text-align:center;"></td>	 
	 <td width="10">&nbsp;</td>';
     if ($_SESSION['mt_search_resid']) 
	 echo '
	 <td width="70px"><input type="Button" class=buttonme  value="نمايش همه" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&open_filter=1\'"></td>';	 
	 echo'
     <td>
	  <span class="tedadcover" align="center" > تعداد کل ['.$cnt.'] <br/>
	  جاری ['.$tedad_jary.']&nbsp; / ابطالی ['.$tedad_ebtaly.']</span>  
	 </td>  
	</tr>';
    }
    if($Mode=="Search")
    {
	echo'
	<tr> 
	 <td>
	  <table class="footer-panel" width="90%" cellpadding="0" cellspacing="0" style="position:absolute;bottom:20px;right:5%;">
 	    <tr class="title"><td colspan="8" align="center">جستجوی رسید</td></tr>
        <tr><td>&nbsp;</td></tr>
	    <tr>
	    <td align="left">شماره رسید :&nbsp;</td>
		<td align="right">
		 <input type="text" class="textboxme2" name="shomare_resid" onkeypress="return isNumber(event)" style="width:50px;"/>&nbsp;/&nbsp;';
		 if(strlen($mt_gl_code_ostan)==1) $code_a=make_pattern($mt_gl_code_ostan,2);
		 else $code_a=$mt_gl_code_ostan;
		 echo'<input type="text" class="textboxme" readonly value="'.$code_a.$mt_gl_code_anbar.'" name="ostan_anbar" style="width:50px;"/>
	    </td>
	    <td align="left"> تاريخ رسید :&nbsp;</td><td align="right"><input type="text" class="textboxme2" id="datepicker5" name="tarikh_resid" maxlength="10" value="'.$tarikh_resid.'"/></td>
	   	<td align="left">کد کالا :&nbsp;</td><td align="right"><input type="text" class="textboxme2" name="code_kala" value="'.$code_kala.'" onkeypress="return isNumber(event)" onKeyUp="F10desc(event)" onblur="enterCodeKala(this.value)" style="width:50px;"/>';
		include ("img_helpkala.php");
		echo'
		</td>
	   	<td align="left"> زیرانبار :&nbsp;</td><td align="right">'.listbox("code_ziranbar",$code_ziranbar,"code_ziranbar","name_ziranbar","list_sardkhane_detail","1=1 AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' ORDER BY name_ziranbar ASC","class='text4'","").'&nbsp;&nbsp;</td>	
	   </tr>
	   <tr>
	   	<td align="left"> وضعیت رسید :&nbsp;</td><td align="right">'.static_listbox("status",-1,"statusFormArr",1,"class='text4'").'</td>
		<td align="left"> شماره کاميون :&nbsp;</td><td align="right"><input type="text" class="textboxme2" name="kamion_no" value="'.$kamion_no.'"/></td>
	    <td align="left"> پلاک خودرو :&nbsp;</td>
	    <td align="right">
	 		   <sup>ایران</sup>
			   <input type="text" class="textboxme2" name="plak1" value="'.$plak1.'" onkeypress="return isNumber(event);" maxlength="2" placeholder="11" style="width:20px;"/> |
			   <input type="text" class="textboxme2" name="plak2" value="'.$plak2.'" onkeypress="return isNumber(event);" maxlength="3" placeholder="111" style="width:30px;"/>
			   <input type="text" class="textboxme2" name="plak3" value="'.$plak3.'" maxlength="1" placeholder="ع" style="width:20px;"/>
			   <input type="text" class="textboxme2" name="plak4" value="'.$plak4.'" onkeypress="return isNumber(event);" maxlength="2" placeholder="11" style="width:20px;"/>
	    </td>
		<td align="left"> وزن خالص :&nbsp;</td><td align="right"><input type="text" class="textboxme2" name="vazn_khales_r" value="'.$vazn_khales_r.'" onKeydown="return PressfloatOnly(event,this)"/></td>
	   </tr>
	   <tr>
	    <td align="left"> وضعیت ثبت :&nbsp;</td><td align="right"><select class="text4" name="sabt_nahayi"><option value="-1">انتخاب کنید</option><option value="0">ثبت نشده</option><option value="1">ثبت شده</option></select></td>
		<td align="left"> نوع تحویل بار :&nbsp;</td><td align="right">'.static_listbox("noe_tahvil_bar",$noe_tahvil_bar,"tahvilbarArr",1,"class='text4'").'</td>   
	    <td align="left"> شماره حواله انبار :&nbsp;</td>
		<td align="right">
		 <input type="text" class="textboxme2" name="shomare_havale_anbar" value="'.$shomare_havale_anbar.'" maxlength="5"  onkeypress="return isNumber(event)" style="width:50px;"/>&nbsp;/&nbsp;
		 <input type="text" class="textboxme" name="code_anbar_mabda" maxlength="3"  onkeypress="return isNumber(event)" style="width:30px;"/>
		 <input type="text" class="textboxme" name="code_ostan_mabda" maxlength="2"  onkeypress="return isNumber(event)" style="width:20px;"/>
		</td>
		<td align="left"> شناسه رسید :&nbsp;</td><td align="right"><input type="text" class="textboxme2" name="id" value="'.$id.'" onkeypress="return isNumber(event)" /></td>
	   </tr>
	   <tr><td>&nbsp;</td></tr>
	   <tr class="title">
        <td colspan="8" align="center">
		 <input class="buttonme" type="submit" name="Search_x" id="sabt" value="جستجو" >
         <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'">
        </td>
       </tr>
	  </table>
	 </td>
    </tr>';
	}	
   echo'
   </table>
  </td>
 </tr>
 <!-- پايان فوتر-->	
</table>
</div>
'.$message.'
</form>
<!--هر 30 ثانیه برای نقش ناظر کیفی-->';
//if(($right_taeed_nazer)or($_SESSION['mt_role']==8))echo'<script> setTimeout(function(){ location.reload(); }, 30000); </script>';
echo'
</body>
</html>';
 if($Mode=='')echo'<div id="notice" style="position:fixed;top:10px;right:15px;" ></div>';  	
 ////////////مجوز ابطال رسید//////////////////////
if(isset($emkan_ebtal))
{
 $res_update_javaz=$db->query("UPDATE $mydatabase.resid SET javaz_ebtal='1' WHERE id='$id_'");    
 if($res_update_javaz){$log=$db->query("INSERT INTO $mydatabase.log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','resid','$id_','تیک مجوز ابطال رسید',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')"); /*کوئری لاگ*/}
 echo "<script>window.location='$FileName?PageNo=".$PageNo."&RowPerPage=".$RowPerPage."&order=".$order."';</script>"; 	
}

if(isset($adam_ebtal))
{
  $res_update_javaz=$db->query("UPDATE $mydatabase.resid SET javaz_ebtal='0' WHERE id='$id_'");    
  if($res_update_javaz){$log=$db->query("INSERT INTO $mydatabase.log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','resid','$id_','تیک عدم مجوز ابطال رسید',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')"); /*کوئری لاگ*/}
  echo "<script>window.location='$FileName?PageNo=".$PageNo."&RowPerPage=".$RowPerPage."&order=".$order."';</script>"; 	
}
?>