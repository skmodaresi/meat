<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="havale.php";
$TableName="havale";
$right_ins=0;$right_del=0;$right_prt=0;$right_detail=0;
if (right(171)) $right_ins=1;
// if (right(172)) $right_edt=1;
if (right(173)) $right_del=1;
if (right(174)) $right_prt=1;
if (right(176)) $right_detail=1;
if (right(604)) $right_javaz_ebtal=1;

IF($_SESSION["mtActiveYear"]==$yy)$today=AsLDate($yymmdd);
ELSE $today=$mtEndDateSh;
$titr='حواله سردخانه';
echo'
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>'.$titr.'</title>
<link rel="stylesheet" type="text/css" href="styles.css"/>
<link rel="stylesheet" type="text/css" href="styles/simptip.css" media="screen,projection" />
<script type="text/javascript" src="functions.js"></script>
<script type="text/javascript" src="scripts/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="scripts/jquery.ui.datepicker-cc.all.min.js"></script>
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
	 <!--اطلاعات حواله های ارسالی برای سایر انبارها-->
	 $("#notice").load("notice_havale.php");
}); 
</script>
</head>';
if(!(isset($Mode))) $Mode='';
/*************SEARCH BUTTON******/// جستجوي اطلاعات
if(isset($open_filter))
{ $open_filter="";
  $_SESSION['mt_search_havale']="";
} 
if(isset($Search_x))
{
 $Mode='';
 $Search_x=""; 
 $temp="";
 if($shomare_havale_anbar)  $temp.=" and T.shomare_havale_anbar LIKE '%$shomare_havale_anbar%'";
 if($tarikh_havale_anbar)   $temp.=" and T.tarikh_havale_anbar LIKE '%$tarikh_havale_anbar%'";
 if($code_kala) $temp.=" and T.code_kala LIKE '%$code_kala%'";
 if($code_customer)  $temp.=" and T.code_customer LIKE '%$code_customer%'";
 if($h_code)  $temp.=" and T.h_code LIKE '%$h_code%'";
 if($shomare_jabejae)  $temp.=" and T.shomare_jabejae LIKE '%$shomare_jabejae%'";
 if($code_ziranbar) $temp.=" and h_d.code_ziranbar LIKE '%$code_ziranbar%'";
 if($shomare_kamiyon_h) $temp.=" and T.shomare_kamiyon_h LIKE '%$shomare_kamiyon_h%'";
 if($plak1)         $temp.=" and T.plak1 LIKE '%$plak1%'";
 if($plak2)         $temp.=" and T.plak2 LIKE '%$plak2%'";
 if($plak3)         $temp.=" and T.plak3 LIKE '%$plak3%'";
 if($plak4)         $temp.=" and T.plak4 LIKE '%$plak4%'";
 if($vazn_khales_h) $temp.=" and T.vazn_khales_h LIKE '%$vazn_khales_h%'";
 if($noe_tahvil_bar) $temp.=" and T.noe_tahvil_bar LIKE '$noe_tahvil_bar'";
 if($bsk_no) $temp.=" and T.bsk_no LIKE '%$bsk_no%'";
 if($sabt_nahayi!='-1') $temp.=" and T.sabt_nahayi=$sabt_nahayi";
 if($status==0)      $temp.=" and T.status=0";//وضعیت حواله 	 
 if($status==1)      $temp.=" and T.status=1";//وضعیت حواله 	 
 if($status==-1)     $temp.="";//وضعیت حواله
 //وضعیت رسید متناظر
 if($daryaft_maghsad==1)   $temp.=" AND T.noe_tahvil_bar=4 AND(T.shomare_havale_anbar IN(SELECT shomare_havale_anbar FROM resid WHERE code_ostan_mabda=T.code_ostan AND code_anbar_mabda=T.code_anbar AND shomare_havale_anbar=T.shomare_havale_anbar AND year=T.year AND deleted=0 AND status=0 AND (noe_tahvil_bar=4 or noe_tahvil_bar=5)))";
 if($daryaft_maghsad==2)   $temp.=" AND T.noe_tahvil_bar=4 AND(T.shomare_havale_anbar NOT IN(SELECT shomare_havale_anbar FROM resid WHERE code_ostan_mabda=T.code_ostan AND code_anbar_mabda=T.code_anbar AND shomare_havale_anbar=T.shomare_havale_anbar AND year=T.year AND deleted=0 AND status=0 AND (noe_tahvil_bar=4 or noe_tahvil_bar=5)))";
 
 if($temp) {$PageNo=1;$_SESSION['mt_search_havale']=$temp;} else $_SESSION['mt_search_havale']="";
}
/************DELETE BUTTON********/// حذف اطلاعات
// if (isset($Delete_x))
// {
 // $Mode='';
  // //$del_q ="UPDATE $TableName T,havale_detail h_d SET T.deleted=1,h_d.havale_deleted=1 WHERE
 		  // // T.shomare_havale_anbar=h_d.shomare_havale_anbar AND T.code_ostan=h_d.code_ostan AND T.code_anbar=h_d.code_anbar AND T.year=h_d.year 
		  // // AND T.id=$id_";
 // $del_q ="UPDATE $TableName SET deleted=1 WHERE id=$id_";
 // $del_res = mysql_query($del_q);
 // if($del_res)
 // {
    // //اگر حواله ابطالی است
    // if($status_==1) $log_d=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_','حذف حواله انبار ابطالی',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')");/*کوئری لاگ*/
    // if($status_==0) $log_d=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_','حذف',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')");/*کوئری لاگ*/
	// $del_q_d ="UPDATE havale_detail SET havale_deleted=1 WHERE shomare_havale_anbar='".$shomare_havale_anbar_."' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear'";
    // $del_res_d=mysql_query($del_q_d);
  // if((mysql_affected_rows()!=0)and($status_==0))
  // {
   // //if($status_==0)//اگر ابطال نشده و میخواهیم حذفش کنیم
   // //{
     // $q_detail="SELECT * From havale_detail WHERE shomare_havale_anbar='".$shomare_havale_anbar_."' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear'";	
	 // $res_detail=mysql_query($q_detail);
	 // while($row_detail=mysql_fetch_assoc($res_detail))//به ازای هر کدام از جزئیات موجودی ها را برمی گردانیم
	 // {
	 // //خواندن موجودی  
	 // $q_m="SELECT * from mojody_kala where code_kala=".$row_detail['code_kala']." AND code_keshvar=".$row_detail['code_keshvar']." AND sal_tolid_shamsi=".$row_detail['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row_detail['mah_tolid_shamsi']." AND code_ostan=".$row_detail['code_ostan']." AND code_anbar=".$row_detail['code_anbar']." AND year=".$row_detail['year']." AND deleted=0";       
	 // $res_m=mysql_query($q_m);
     // $row_m=mysql_fetch_assoc($res_m); 
	// //آپدیت موجودی کالا در جدول موجودی کالا
	 // $update_tedad_karton=$row_m['tedad_karton']+$row_detail['tedad_karton_h_d'];//آپدیت تعداد کارتن های موجود در انبار
     // $update_mojody_nakhales=$row_m['mojody_nakhales']+$row_detail['vazn_nakhales_h_d'];//آپدیت موجودی ناخالص کالا در جدول موجودی کالا  
	 // $update_mojody_khales=$row_m['mojody_khales']+$row_detail['vazn_khales_h_d'];//آپدیت موجودی خالص کالا در جدول موجودی کالا
	 // $update_mojody_res=$db->query("UPDATE mojody_kala SET mojody_khales=$update_mojody_khales,mojody_nakhales=$update_mojody_nakhales,tedad_karton=$update_tedad_karton WHERE code_kala=".$row_detail['code_kala']." AND code_keshvar=".$row_detail['code_keshvar']." AND sal_tolid_shamsi=".$row_detail['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row_detail['mah_tolid_shamsi']." AND code_ostan=".$row_detail['code_ostan']." AND code_anbar=".$row_detail['code_anbar']." AND year=".$row_detail['year']." AND deleted=0");      	 
	 // /*log*/if($update_mojody_res) $log_e=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','mojody_kala',".$row_m['id'].",'حذف حواله انبار وبرگشت موجودی کالا',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')");
	 // }
	// /**اگر به فروش متصل نیستیم**/
	 // if($_SESSION['mt_systemforush']==0)
	 // {
	  // //آپدیت مانده مقدار حواله فروش در جدول حواله فروش سیستم انبار
	  // $update_mande1=$mande_az_forush_+$vazn_khales_h_;
      // $res_update_mande=$db->query("UPDATE havale_forush SET mande_az_forush='$update_mande1' WHERE h_code='$h_code_' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear'");	  
	 // }
	 // /**اگر به فروش متصل هستیم**/
	 // if($_SESSION['mt_systemforush']==1)
	 // {
	  // //آپدیت مانده مقدار حواله فروش در جدول حواله فروش سیستم فروش
	   // mysql_select_db('sell') or die('no Select Db BECAUSE: ' . mysql_error());
	   // $update_mande2=$mande_az_forush_+$vazn_khales_h_; 
       // $res_update_mande=$db->query("UPDATE dm_havale SET h_mande_havale='$update_mande2' WHERE h_id='$idForush_'");    
	   // mysql_select_db($mydatabase) or die('no Select Db BECAUSE: ' . mysql_error());
	 // }
	 // /*log*/
	 // if($res_update_mande)
     // {
	 	  // if($_SESSION['mt_systemforush']==0) $log_e=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','havale_forush','$idForush_','حذف حواله و برگشت مقدار مانده از حواله فروش در سیستم سردخانه',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')"); /*کوئری لاگ*/
	 	  // if($_SESSION['mt_systemforush']==1) $log_e=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','havale_forush','$idForush_','حذف حواله و برگشت مقدار مانده از حواله فروش در سیستم فروش',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')"); /*کوئری لاگ*/
     // }	
   // }
 // }
 // else $message ='<span style=" color:red;font: bold 12px tahoma;"> * مشکلی در حذف به وجود آمده است ! *</span>';
// }//END DELETE 

/********************WEB SERVICE***********************/
if(isset($send_havale))//مراحل ثبت در وب سرویس
{
  $base_date='1402/11/09';      
  if($sabt_havale)//ثبت نهایی
  {
	$update_sabt=("UPDATE $mydatabase.havale SET sabt_nahayi=1 WHERE code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND shomare_havale_anbar='$shomare_havale_anbar_' AND year=$mtActiveYear");
	$update_res_sabt=mysql_query($update_sabt);
  }
  $register_error_code=$db->get_from_where("register_error_code","list_sardkhane","code_ostan=".$mt_gl_code_ostan." AND code_anbar=".$mt_gl_code_anbar."");     
  $tarikh_havale_anbar=$db->get_from_where("tarikh_havale_anbar","havale","id=".$id_."");     
  //echo"<script>alert('$tarikh_havale_anbar')</script>";
  //echo"<script>alert('$base_date')</script>";
  //////////////////////////////////NEW version//////////////////////////////////////////////
  //به جز تحت کلید گمرک
  if(($_SESSION['mt_webservice']==1)AND($register_error_code==0)AND($noe_tahvil_bar_!='9')AND($tarikh_havale_anbar>=$base_date))//اتصال به وب سرویس
  {
	   $params=array();
       $containers=array();
       $seals=array();
       $packages=array();
       $reference_docs=array();
	   $goods_issue_items=array();

	   $q_havale="SELECT h.*,warehouse_id,general_goods_id,code_vahedkala,mahmule_type From $mydatabase.havale h 
	              INNER JOIN $mydatabase.list_sardkhane l_s ON h.code_ostan=l_s.code_ostan AND h.code_anbar=l_s.code_anbar
				  INNER JOIN $mydatabase.kala ON h.code_kala=kala.code_kala 
				  INNER JOIN $mydatabase.bastebandy ON kala.code_bastebandy=bastebandy.code_bastebandy
				  WHERE h.tarikh_havale_anbar>='$base_date' AND h.code_ostan=$mt_gl_code_ostan AND h.code_anbar=$mt_gl_code_anbar AND h.year=$mtActiveYear AND shomare_havale_anbar='$shomare_havale_anbar_'";
	   $res_havale = mysql_query($q_havale);
	   $row_havale=mysql_fetch_assoc($res_havale);
	   	  
	   //حالت خاص تاریخ
	   IF(($row_havale['year']=='1403')OR($row_havale['tarikh_havale_anbar']<'1404/12/29')) $tarikh_havale_anbar='1405/01/31';
	   ELSE $tarikh_havale_anbar=$row_havale['tarikh_havale_anbar']; 	
	   
	   $warehouse_id=$db->get_from_where("warehouse_id","list_sardkhane","code_ostan=".$row_havale['code_ostan']." AND code_anbar=".$row_havale['code_anbar']."");     
       //$contractor_national_id=$db->get_from_where("nationalId","list_sardkhane_owner","code_ostan=".$row_havale['code_ostan']." AND code_anbar=".$row_havale['code_anbar']."");     
	   $contractor_national_id='14002771736';
	   if(strlen($row_havale['code_ostan'])==1) $code_a=make_pattern($row_havale['code_ostan'],2);
       else $code_a=$row_havale['code_ostan'];
	   $shenaseAnbar=$code_a.$row_havale['code_anbar'];
       //$shomareBijak=$mtActiveYear.$row_havale['shomare_havale_anbar'];
       //الگو
	   $shomareBijak='1'.$mtActiveYear.$shenaseAnbar.$row_havale['shomare_havale_anbar'];
	    IF($row_havale['code_vahedkala']==1)//کیلوگرم
	    {
		      $measurement_unit=1;
	          $count=$row_havale['vazn_khales_h'];
	    }
        ELSE //تعداد//قطعه
	    {
		      $measurement_unit=6;
		      $count=$row_havale['tedad_karton_h'];   
	    }

	   //داخلی یا وارداتی
	    IF($row_havale['mahmule_type']==1)$production_type=1;
	    ELSE $production_type=2;
	   
	   if($row_havale['shomare_barname_h']=='')$shomare_barname_h=1;
	   else $shomare_barname_h=$row_havale['shomare_barname_h'];
	   
	   if(($row_havale['plak4']=='')or($row_havale['plak4']==0))$plak4=11;
	   else $plak4=$row_havale['plak4'];
	   if(($row_havale['plak3']=='')or($row_havale['plak3']==0))$plak3=ع;
	   else $plak3=$row_havale['plak3'];
	   if(($row_havale['plak2']=='')or($row_havale['plak2']==0))$plak2=111;
	   else $plak2=$row_havale['plak2'];
	   if(($row_havale['plak1']=='')or($row_havale['plak1']==0))$plak1=11;
	   else $plak1=$row_havale['plak1'];
	   //الگو
	   //$plak=$plak1.'|'.$plak4.'|'.$plak2.'|'.$plak3;
	   $plak=$plak1.'|'.$plak2.'|'.$plak3.'|'.$plak4;
       //الگو   
	   $goodId='02'.(make_pattern($row_havale['code_kala'],10));
	   // //جابه جایی
	   // IF(($row_havale['noe_tahvil_bar']==4)OR($row_havale['noe_tahvil_bar']==5)or($row_havale['noe_tahvil_bar']==7))$processSequence=79;
       // ELSE $processSequence=76;

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
		  'number'=>$shomare_barname_h,
		  'id'=>null,
		  'issue_date'=>$row_havale['tarikh_barname_h']  
		 );	
		 //$reference_docs=array($reference_docs1);
		 array_push($reference_docs,$reference_docs1);

		 $goods_issue_items1=array(
		  //'row_number'=>'1',
		  //'good_id'=>$goodId,
		  'cid_code'=>null,
		  'general_goods_id'=>$row_havale['general_goods_id'],  
		  'hs_code'=>null,  
		  'tracking_code'=>null,  
		  'goods_description'=>$row_havale['name_kala'],  
		  'dangerous_goods_code'=>null,  
		  'measurement_unit'=>$measurement_unit,  
		  'production_type'=>$production_type,  
		  'count'=>$count,  
		  'gross_weight'=>$row_havale['vazn_nakhales_h'],  
		  'net_weight'=>$row_havale['vazn_khales_h'],  
		  'volume'=>null,  
		  'container_id'=>null,  
		  'package_id'=>null,  
		  'package_count'=>$row_havale['tedad_karton_h'], 
		  'package_type'=>$row_havale['package_type'],  
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
          'postal_code'=>$row_havale['postal_code'],
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
		  'net_weight'=>$row_havale['vazn_khales_h'],
		  'gross_weight'=>$row_havale['vazn_nakhales_h'],
		  'reference_docs'=>$reference_docs,
		  'description'=>null,
		  'place_description'=>null,
		  'additional_information'=>null,
		  'goods_issue_items'=>$goods_issue_items
         );
         $result=preg_replace("/\\\\u([a-f0-9]{4})/e", "iconv('UCS-4LE','UTF-8',pack('V', hexdec('U$1')))", json_encode($params));
		 $encodedData = json_encode($params);

		 $curl = curl_init();
		 curl_setopt_array($curl, array(
          CURLOPT_URL => 'http://10.7.234.33/warehouse/api/warehouse/DraftPermanent',
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
	       $update_track=("UPDATE havale SET wb_error_code='$wb_error_code',wb_error_message='$wb_error_message',wb_creator='$wb_creator',wb_create_date='$wb_create_date',wb_id='$wb_id' WHERE code_ostan=".$row_havale['code_ostan']." AND code_anbar=".$row_havale['code_anbar']." AND shomare_havale_anbar='".$row_havale['shomare_havale_anbar']."' AND year=$mtActiveYear");
	       $update_res=mysql_query($update_track);
	      }
	      curl_close($curl);	   	   
  }
  echo "<script>window.location='$FileName?PageNo=".$PageNo."&RowPerPage=".$RowPerPage."&order=".$order."';</script>";     
} 		  
/********************WEB SERVICE second time***********************/
// if(isset($send_havale))//مراحل ثبت در وب سرویس
// {
  // if($sabt_havale)//ثبت نهایی
  // {
	// $update_sabt=("UPDATE $mydatabase.havale SET sabt_nahayi=1 WHERE code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND shomare_havale_anbar='$shomare_havale_anbar_' AND year=$mtActiveYear");
	// $update_res_sabt=mysql_query($update_sabt);
  // }
  // $register_error_code=$db->get_from_where("register_error_code","list_sardkhane","code_ostan=".$mt_gl_code_ostan." AND code_anbar=".$mt_gl_code_anbar."");     
  // //////////////////////////////////NEW version//////////////////////////////////////////////
  // if(($_SESSION['mt_webservice']==1)AND($register_error_code==0))//اتصال به وب سرویس
  // {
	   // if(strlen($mt_gl_code_ostan)==1) $code_a=make_pattern($mt_gl_code_ostan,2);
       // else $code_a=$mt_gl_code_ostan;
	   // $shenaseAnbar=$code_a.$mt_gl_code_anbar;
       // $shomareBijak=$mtActiveYear.$shomare_havale_anbar_;
	   // $q_havale="SELECT h.*,warehouse_id,good_id,code_vahedkala,mahmule_type From $mydatabase.havale h INNER JOIN $mydatabase.list_sardkhane l_s ON h.code_ostan=l_s.code_ostan AND h.code_anbar=l_s.code_anbar INNER JOIN $mydatabase.kala ON h.code_kala=kala.code_kala WHERE h.code_ostan=$mt_gl_code_ostan AND h.code_anbar=$mt_gl_code_anbar AND h.year=$mtActiveYear AND shomare_havale_anbar='$shomare_havale_anbar_'";
	   // $res_havale = mysql_query($q_havale);
	   // $row_havale=mysql_fetch_assoc($res_havale);
	   // //تبدیل تاریخ شمسی به میلادی
       // $sql_tarikh=$row_havale['tarikh_havale_anbar'];
       // $d=substr($sql_tarikh,8,2);$m=substr($sql_tarikh,5,2);$y=substr($sql_tarikh,0,4);
       // $milady=jalali_to_gregorian($y,$m,$d);
       // $sal=$milady[0];$mah=$milady[1];$rouz=$milady[2];
       // $tarikh_havale_MI=$sal.'-'.$mah.'-'.$rouz;
	   // if($row_havale['shomare_barname_h']=='')$BillLadingNo=null;
	   // else $BillLadingNo=$shomare_barname_h;
	   // if($row_havale['plak4']=='')$plak4=null;
	   // else $plak4=$row_havale['plak4'];
	   // if($row_havale['plak3']=='')$plak3=null;
	   // else $plak3=$row_havale['plak3'];
	   // if($row_havale['plak2']=='')$plak2=null;
	   // else $plak2=$row_havale['plak2'];
	   // if($row_havale['plak1']=='')$Plak1=null;
	   // else $plak1=$row_havale['plak1'];
	   // $plak=$plak1.$plak2.$plak3.$plak4;
	   // // if(($row_havale['good_id']==null)OR($row_havale['good_id']=='')OR($row_havale['good_id']=='0')) $goodId=$row_havale['code_kala'];
	   // // else $goodId=$row_havale['good_id'];
	   // $goodId=$row_havale['code_kala'];
	   // //جابه جایی
	   // IF(($row_havale['noe_tahvil_bar']==4)OR($row_havale['noe_tahvil_bar']==5)or($row_havale['noe_tahvil_bar']==7))$processSequence=79;
       // ELSE $processSequence=76;
	   // IF($row_havale['code_vahedkala']==1)//کیلوگرم
	   // {
		  // $measurement_unit=1;
	      // $amount=$row_havale['vazn_khales_h'];
	   // }
       // ELSE IF($row_havale['code_vahedkala']==2)//تعداد
	   // {
		  // $measurement_unit=6;
		  // $amount=$row_havale['tedad_karton_h'];   
	   // }
	   // $wsdl_url='http://10.7.234.33/anbar/warehouse.asmx?wsdl';
	   // header('Content-Type: text/html; charset=utf-8');
       // try
	   // {
	    // $client=new SoapClient($wsdl_url);
	    // $bijakStuff1=array(
		 // 'good_id'=>$goodId,
		 // 'measurement_unit'=>$measurement_unit,
         // 'amount'=>$amount,
         // 'production_type'=>$row_havale['mahmule_type']
         // );
        // $WarehouseDocumentDetails=array($bijakStuff1);	
		// $WarehouseDocument =array(
		 // 'warehouse_id'=>$row_havale['warehouse_id'],
		 // 'gov_warehouse_number'=>$shenaseAnbar,
		 // 'number'=>$shomareBijak,
         // 'issue_date'=>$tarikh_havale_MI,
         // 'owner'=>'14002771736',
         // 'owner_birth_date'=>null,
	     // 'driver_national_id'=>null,
         // 'driver_birth_date'=>null,
		 // 'vehicle_number'=>$plak,
		 // 'bol_date'=>$row_havale['tarikh_barname_h'],
		 // 'bol_serial'=>$BillLadingNo,
		 // 'bol_series'=>null,	 
		 // 'bol_tid'=>null,	 
		 // 'Commodities'=>$WarehouseDocumentDetails	 
         // );
         // $params=array(
		  // 'username'=>'02',
          // 'password'=>'HJ78mnGD',
		  // 'co_national_id'=>'14002771736',
          // 'type'=>'out',
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
	   // }
       // catch(SoapFault $client)
	   // {
		 // echo "<script>alert('وب سرویس فعال نمی باشد')</script>";
		 // echo  $e->getMessage();
	   // }
	   // $update_track_new=("UPDATE $mydatabase.havale SET webservice_error_code='$webservice_error_code',webservice_error_message='$webservice_error_message',webservice_status='$webservice_status',webservice_number='$webservice_number',webservice_JahadTracking='$webservice_JahadTracking' WHERE code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND shomare_havale_anbar='$shomare_havale_anbar_' AND year=$mtActiveYear");
	   // $insert_res=mysql_query($update_track_new);
  // }
  // echo "<script>window.location='$FileName?PageNo=".$PageNo."&RowPerPage=".$RowPerPage."&order=".$order."';</script>";     
// } 
/********************PAGING***********************/
if(isset($_POST['wRowPerPage'])) $RowPerPage=$_POST['wRowPerPage'];
if(!isset($RowPerPage)) $RowPerPage=8;
$res=$db->query("SELECT (T.id) From $mydatabase.$TableName AS T INNER JOIN $mydatabase.kala ON kala.code_kala=T.code_kala LEFT OUTER JOIN $mydatabase.havale_detail AS h_d ON h_d.shomare_havale_anbar=T.shomare_havale_anbar AND h_d.code_ostan=T.code_ostan AND h_d.code_anbar=T.code_anbar AND h_d.year=T.year WHERE 1=1 ".$_SESSION['mt_search_havale']." AND T.code_ostan='$mt_gl_code_ostan' AND T.code_anbar='$mt_gl_code_anbar' AND T.year='$mtActiveYear' AND T.deleted=0 GROUP BY T.shomare_havale_anbar,T.code_ostan,T.code_anbar,T.year");
//echo'<br/>'.("SELECT count(T.id) From $TableName AS T INNER JOIN kala ON kala.code_kala=T.code_kala INNER JOIN havale_detail AS h_d ON h_d.shomare_havale_anbar=T.shomare_havale_anbar AND h_d.code_ostan=T.code_ostan AND h_d.code_anbar=T.code_anbar AND h_d.year=T.year WHERE 1=1 ".$_SESSION['mt_search_havale']." AND T.code_ostan='$mt_gl_code_ostan' AND T.code_anbar='$mt_gl_code_anbar' AND T.year='$mtActiveYear' AND T.deleted=0 GROUP BY T.shomare_havale_anbar,T.code_ostan,T.code_anbar,T.year");
//$res=$db->query("SELECT count(T.id) From $TableName AS T INNER JOIN kala ON kala.code_kala=T.code_kala INNER JOIN havale_detail AS h_d ON h_d.shomare_havale_anbar=T.shomare_havale_anbar AND h_d.code_ostan=T.code_ostan AND h_d.code_anbar=T.code_anbar AND h_d.year=T.year WHERE 1=1 ".$_SESSION['mt_search_havale']." AND T.code_ostan='$mt_gl_code_ostan' AND T.code_anbar='$mt_gl_code_anbar' AND T.year='$mtActiveYear' AND T.deleted=0 GROUP BY T.shomare_havale_anbar,T.code_ostan,T.code_anbar,T.year");
//$res = $db->query("SELECT COUNT(*) FROM $TableName T WHERE 1=1 ".$_SESSION['mt_search_havale']." AND T.code_ostan='$mt_gl_code_ostan' AND T.code_anbar='$mt_gl_code_anbar' AND T.year='$mtActiveYear' AND T.deleted=0");
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
$res_jary=$db->query("SELECT (T.id) From $mydatabase.$TableName AS T INNER JOIN $mydatabase.kala ON kala.code_kala=T.code_kala LEFT OUTER JOIN $mydatabase.havale_detail AS h_d ON h_d.shomare_havale_anbar=T.shomare_havale_anbar AND h_d.code_ostan=T.code_ostan AND h_d.code_anbar=T.code_anbar AND h_d.year=T.year WHERE 1=1 ".$_SESSION['mt_search_havale']." AND T.code_ostan='$mt_gl_code_ostan' AND T.code_anbar='$mt_gl_code_anbar' AND T.year='$mtActiveYear' AND T.deleted=0 AND T.status=0 GROUP BY T.shomare_havale_anbar,T.code_ostan,T.code_anbar,T.year");
$tedad_jary = mysql_num_rows($res_jary);
$res_ebtaly=$db->query("SELECT (T.id) From $mydatabase.$TableName AS T INNER JOIN $mydatabase.kala ON kala.code_kala=T.code_kala LEFT OUTER JOIN $mydatabase.havale_detail AS h_d ON h_d.shomare_havale_anbar=T.shomare_havale_anbar AND h_d.code_ostan=T.code_ostan AND h_d.code_anbar=T.code_anbar AND h_d.year=T.year WHERE 1=1 ".$_SESSION['mt_search_havale']." AND T.code_ostan='$mt_gl_code_ostan' AND T.code_anbar='$mt_gl_code_anbar' AND T.year='$mtActiveYear' AND T.deleted=0 AND T.status=1 GROUP BY T.shomare_havale_anbar,T.code_ostan,T.code_anbar,T.year");
$tedad_ebtaly = mysql_num_rows($res_ebtaly); 
//$tedad_jary=$db->get_from_where("COUNT(*)","$TableName","1=1 ".$_SESSION['mt_search_resid']." AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0 AND status=0");
//$tedad_ebtaly=$db->get_from_where("COUNT(*)","$TableName","1=1 ".$_SESSION['mt_search_resid']." AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0 AND status=1");   
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.shomare_havale_anbar.focus();">
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
if(!isset($order))      $order='T.id DESC';
if(!isset($sortcode))   $sortcode='1';
if(!isset($sorttarikh)) $sorttarikh='1';
if(!isset($sortforush)) $sortforush='1';
if(!isset($sortjabejae)) $sortjabejae='1';
if(!isset($sortname))   $sortname='1';
if(!isset($sorttahvil)) $sorttahvil='1';
if(!isset($sortstatus)) $sortstatus='1';
if(!isset($show_img))   $show_img='';
    //echo'<td width="3%">ردیف</td>';
	if($sortcode=='1')
	{echo'<td width="7%" title="مرتب سازی صعودی شماره حواله سردخانه" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=T.code_ostan ASC,T.code_anbar ASC,T.shomare_havale_anbar ASC&sortcode=2&show_img=1\'"/> شماره حواله  ';
	  if($show_img=='1')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sortcode=='2')
	{echo'<td width="7%" title="مرتب سازی نزولی شماره حواله سردخانه" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=T.code_ostan DESC,T.code_anbar DESC,T.shomare_havale_anbar DESC&sortcode=1&show_img=1\'"/> شماره حواله  ';
	  if($show_img=='1')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sorttarikh=='1')
	{echo'<td width="7%" title="مرتب سازی صعودی تاريخ حواله" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=T.tarikh_havale_anbar ASC&sorttarikh=2&show_img=2\'"/> تاريخ '; 
	  if($show_img=='2')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sorttarikh=='2')
	{echo'<td width="7%" title="مرتب سازی نزولی تاريخ حواله" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=T.tarikh_havale_anbar DESC&sorttarikh=1&show_img=2\'"/> تاريخ '; 
	  if($show_img=='2')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sortforush=='1')
	{echo'<td width="8%" title="مرتب سازی صعودی شماره حواله فروش" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=T.h_code ASC&sortforush=2&show_img=3\'"/> حواله فروش '; 
	  if($show_img=='3')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sortforush=='2')
	{echo'<td width="8%" title="مرتب سازی نزولی شماره حواله فروش" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=T.h_code DESC&sortforush=1&show_img=3\'"/>  حواله فروش '; 
	  if($show_img=='3')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sortjabejae=='1')
	{echo'<td width="7%" title="مرتب سازی صعودی مجوز جابه جایی" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=T.shomare_jabejae ASC&sortjabejae=2&show_img=4\'"/> مجوز جابه جایی '; 
	  if($show_img=='4')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sortjabejae=='2')
	{echo'<td width="7%" title="مرتب سازی نزولی مجوز جابه جایی" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=T.shomare_jabejae DESC&sortjabejae=1&show_img=4\'"/> مجوز جابه جایی '; 
	  if($show_img=='4')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sortname=='1')
	{echo'<td width="9%" title="مرتب سازی صعودی نام کالا" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=kala.name_kala ASC&sortname=2&show_img=5\'"/> نام کالا '; 
	  if($show_img=='5')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sortname=='2')
	{echo'<td width="9%" title="مرتب سازی نزولی نام کالا" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=kala.name_kala DESC&sortname=1&show_img=5\'"/> نام کالا '; 
	  if($show_img=='5')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
   if($sorttahvil=='1')
	{echo'<td width="6%" title="مرتب سازی صعودی نوع تحویل" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=T.noe_tahvil_bar ASC&sorttahvil=2&show_img=7\'"/> نوع تحویل '; 
	  if($show_img=='7')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sorttahvil=='2')
	{echo'<td width="6%" title="مرتب سازی نزولی نوع تحویل" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=T.noe_tahvil_bar DESC&sorttahvil=1&show_img=7\'"/> نوع تحویل '; 
	  if($show_img=='7')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	echo'	 
	<td width="6%">تعداد</td>
	<td width="9%">وزن ناخالص</td>
    <td width="9%">وزن خالص</td>';
	if($sortstatus=='1')
	{echo'<td width="3%" title="مرتب سازی صعودی وضعیت" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=T.status ASC&sortstatus=2&show_img=8\'"/> وضعیت ';
	  if($show_img=='8')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sortstatus=='2')
	{echo'<td width="3%" title="مرتب سازی نزولی وضعیت" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=T.status DESC&sortstatus=1&show_img=8\'"/> وضعیت ';
	  if($show_img=='8')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	echo'
	 <td width="7%">جزئیات کالا</td>
	 <td width="4%">ثبت نهایی</td>';
	 if($_SESSION['mt_webservice']==1) echo'<td width="4%">ارسال</td>';
     echo'<td width="4%">دریافت مقصد</td>';
	echo'<td width="3%">جواز ابطال</td>';
	if($right_prt)
	{echo'
	 <td width="4%">چاپ</td>
	 <td width="4%">برگه خروج</td>';}
	 if(($right_del)and($_SESSION['mtStatusYear']==0)) echo'<td width="3%">حذف</td>';
	 echo'
	</tr>';
	$i=0;
	$q1="SELECT T.*,kala.name_kala,h_d.code_ziranbar From $mydatabase.$TableName AS T
		  INNER JOIN $mydatabase.kala ON kala.code_kala=T.code_kala
		  LEFT OUTER JOIN $mydatabase.havale_detail AS h_d ON h_d.shomare_havale_anbar=T.shomare_havale_anbar AND h_d.code_ostan=T.code_ostan AND h_d.code_anbar=T.code_anbar AND h_d.year=T.year
       	  WHERE 1=1 ".$_SESSION['mt_search_havale']." AND T.code_ostan='$mt_gl_code_ostan' AND T.code_anbar='$mt_gl_code_anbar' AND T.year='$mtActiveYear' AND T.deleted=0 GROUP BY T.shomare_havale_anbar,T.code_ostan,T.code_anbar,T.year ORDER BY $order $Limit";
	$allHavale = $db->query($q1);
	while($row1=$db->fetch_assoc($allHavale))
	{
	  $detailcount=$db->get_from_where("count(*)","$mydatabase.havale_detail","shomare_havale_anbar=".$row1['shomare_havale_anbar']." AND code_ostan=".$row1['code_ostan']." AND code_anbar=".$row1['code_anbar']." AND year=".$row1['year']."");
	  if(($row1['noe_tahvil_bar']==4)or($row1['noe_tahvil_bar']==5)or($row1['noe_tahvil_bar']==7)or($row1['noe_tahvil_bar']==9))//اگر نوع تحویل بار جابهجایی  بود
	  { 
	    $q_jabejae=("SELECT m_j.id,m_j.shomare_jabejae,m_j.meghdar_jabejae,m_j.mande_az_jabejae,m_j.noe_mojavez,m_j.code_customer,name_ostan,name_anbar FROM $mydatabase.mojavez_jabejae m_j
				     LEFT JOIN $mydatabase.ostan ON ostan.code_ostan=m_j.code_ostan_maghsad_j           
                     LEFT JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=m_j.code_anbar_maghsad_j AND list_sardkhane.code_ostan=m_j.code_ostan_maghsad_j 
					 WHERE m_j.shomare_jabejae='".$row1['shomare_jabejae']."' AND m_j.code_ostan='$mt_gl_code_ostan' AND m_j.code_anbar='$mt_gl_code_anbar' AND m_j.year='$mtActiveYear' AND m_j.deleted=0");	
	    $res_jabejae=$db->query($q_jabejae);
        $row_jabejae=$db->fetch_assoc($res_jabejae);
		IF(($row_jabejae['noe_mojavez']==2)OR($row_jabejae['noe_mojavez']==4))//  کالای امانی یا جایگزینی با بخش خصوصی
		{
		 $q_customer=("SELECT name_customer FROM sell.dm_customer_asli WHERE code_customer=".$row_jabejae['code_customer']." ");	
	     $res_customer=$db->query($q_customer);
         $row_customer=$db->fetch_assoc($res_customer);
		}
	  }   
      else
	  {
	   //اگر سیستم سردخانه
       if($_SESSION['mt_systemforush']==0)
       { 
       //بدست آوردن تاریخ ومقدار حواله فروش و مانده از فروش
        $q_havale_forush="SELECT meghdar_havale_forush,mande_az_forush,id FROM $mydatabase.havale_forush WHERE h_code=".$row1['h_code']." AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear'";
        $res_havale_forush=$db->query($q_havale_forush);
        $row_havale_forush=$db->fetch_assoc($res_havale_forush);
        $meghdar_havale_forush=$row_havale_forush['meghdar_havale_forush'];
        $mande_az_forush=$row_havale_forush['mande_az_forush'];
        $idForush=$row_havale_forush['id'];
       }
       //اگر سیستم فروش  
       if($_SESSION['mt_systemforush']==1)
       {  
  	     $q_havale_forush="SELECT h_id,h_pre_amount,h_mande_havale FROM sell.dm_havale WHERE h_code=".$row1['h_code']." AND h_id_province='$sell_id_ostan' AND h_l_code='$sell_id_anbar' AND h_id_year='$sellYearId'";
         $res_havale_forush=$db->query($q_havale_forush);
         $row_havale_forush=$db->fetch_assoc($res_havale_forush);
  	     $meghdar_havale_forush=$row_havale_forush['h_pre_amount'];
  	     $mande_az_forush=$row_havale_forush['h_mande_havale'];
  	     $idForush=$row_havale_forush['h_id'];
       }
	  }
	 $exist_resid_motenazer=$db->get_from_where("COUNT(*)","$mydatabase.resid","shomare_havale_anbar=".$row1['shomare_havale_anbar']." AND code_ostan_mabda=".$row1['code_ostan']." AND code_anbar_mabda=".$row1['code_anbar']." AND year=".$row1['year']." AND deleted=0 AND status=0");
	 $exist_resid_motenazer_darsalbad=$db->get_from_where("COUNT(*)","$mydatabase.resid","shomare_havale_anbar=".$row1['shomare_havale_anbar']." AND code_ostan_mabda=".$row1['code_ostan']." AND code_anbar_mabda=".$row1['code_anbar']." AND year='".($row1['year']+1)."' AND deleted=0 AND status=0");
	 
	 $edtClick='onClick="window.location=\'havale_edit.php?id_='.$row1['id'].'&shomare_havale_anbar_='.$row1['shomare_havale_anbar'].'&exist_resid_motenazer_='.$exist_resid_motenazer.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'"';
	 if(strlen($row1['code_ostan'])==1) $code_a=make_pattern($row1['code_ostan'],2);
     else $code_a=$row1['code_ostan'];
	 if($i++%2)
	 {echo'<tr '; if($row1['status']==0) echo' class="table-odd"'; else echo 'class="row-ebtal"';echo'>';}	 
     else
	 {echo'<tr '; if($row1['status']==0) echo' class="table-even"'; else echo 'class="row-ebtal"';echo'>';}
     echo'
	  <!--<td '.$edtClick.'>'.$radif++.'</td>-->
	  <td '.$edtClick.'>'.$code_a.$row1['code_anbar'].$row1['shomare_havale_anbar'].'</td>
	  <td '.$edtClick.'>'.$row1['tarikh_havale_anbar'].'</td>
	  <td '.$edtClick.'>'.$row1['h_code'].'</td>
	  <td '.$edtClick.'><span class="simptip-position-top simptip-multiline simptip-info" data-tooltip="'.$row_jabejae['name_ostan'].' '.$row_jabejae['name_anbar'].''.$row_jabejae['name_customer'].'">'.$row1['shomare_jabejae'].'</span></td>
	  <td '.$edtClick.'>'.$row1['name_kala'].'</td>
	  <td '.$edtClick.'>'.$tahvilbarArr_h[$row1['noe_tahvil_bar']].'</td>';
	  //استفاده از تابع
	  $db->selectDb($mydatabase);
	  $detail_havale=havale_detail($row1['shomare_havale_anbar'],$row1['code_ostan'],$row1['code_anbar'],$row1['year']);
	  $detail_row=mysql_fetch_assoc($detail_havale);
	  echo'
	  <td '.$edtClick.'>'.($detail_row['sum_tedad_karton_h']).'</td>
	  <td '.$edtClick.'>'.round($detail_row['sum_nakhales_h'],3).'</td>
	  <td '.$edtClick.'>'.round($row1['vazn_khales_h'],3).'</td>
	    <!--<td '.$edtClick.'>'.($detail_row['sum_khales_h']).'</td>-->
	  <td '.$edtClick.'>';if($row1['status']==0) echo 'جاری';else echo 'ابطالی </td>';
	 echo'<td>';
	 if($right_detail)
	 {	   
	   //اگر وضعیت حواله جاری است
	   if($row1['status']==0)
	   {
	    //اگر هنوز جزئیات ندارد
		//if($detailcount==0) {echo'<input type="button"'; if($row1['tarikh_havale_anbar']==$today)echo'class="buttonme-empty"'; else echo'class="buttonme"'; echo'value="*جزئیات کالا ['.$detailcount.']" onClick="window.location=\'havale_detail.php?shomare_havale_anbar_='.$row1['shomare_havale_anbar'].'&code_kala_='.$row1['code_kala'].'&noe_tahvil_bar_='.$row1['noe_tahvil_bar'].'&h_code_='.$row1['h_code'].'&meghdar_havale_forush_='.$meghdar_havale_forush.'&mande_az_forush_='.$mande_az_forush.'&idForush_='.$idForush.'&shomare_jabejae_='.$row_jabejae['shomare_jabejae'].'&meghdar_jabejae_='.$row_jabejae['meghdar_jabejae'].'&mande_az_jabejae_='.$row_jabejae['mande_az_jabejae'].'&idJabejae_='.$row_jabejae['id'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'">';}
		if($detailcount==0) {echo'<input type="button"'; if($row1['tarikh_havale_anbar']==$today)echo'class="button-inline buttonme-empty"'; else echo'class="button-inline"'; echo'value="*جزئیات ['.$detailcount.']" onClick="window.location=\'havale_detail.php?shomare_havale_anbar_='.$row1['shomare_havale_anbar'].'&code_kala_='.$row1['code_kala'].'&noe_tahvil_bar_='.$row1['noe_tahvil_bar'].'&h_code_='.$row1['h_code'].'&idForush_='.$idForush.'&shomare_jabejae_='.$row_jabejae['shomare_jabejae'].'&idJabejae_='.$row_jabejae['id'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'">';}
		else echo'<input type="button" class="button-inline" value="جزئیات ['.$detailcount.']" onClick="window.location=\'havale_detail.php?shomare_havale_anbar_='.$row1['shomare_havale_anbar'].'&code_kala_='.$row1['code_kala'].'&noe_tahvil_bar_='.$row1['noe_tahvil_bar'].'&h_code_='.$row1['h_code'].'&idForush_='.$idForush.'&shomare_jabejae_='.$row_jabejae['shomare_jabejae'].'&idJabejae_='.$row_jabejae['id'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'">';
	   }
	   else
	   {
        //اگر هنوز جزئیات ندارد
	    if($detailcount==0) echo'<input type="button" class="buttonme-ebtal"  value="ابطال شد ['.$detailcount.']" style="cursor:default">';//غیر فعال 
	    else echo'<input type="button" class="buttonme-ebtal"  value="ابطال شد ['.$detailcount.']" onClick="window.location=\'havale_detail.php?shomare_havale_anbar_='.$row1['shomare_havale_anbar'].'&code_kala_='.$row1['code_kala'].'&noe_tahvil_bar_='.$row1['noe_tahvil_bar'].'&h_code_='.$row1['h_code'].'&idForush_='.$idForush.'&shomare_jabejae_="'.$row_jabejae['shomare_jabejae'].'"&idJabejae_='.$row_jabejae['id'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'">';
	   }
	   //else echo'<input type="button" class="buttonme-ebtal"  value="اطلاعات کالا ['.$detailcount.']" onClick="window.location=\'havale_detail.php?shomare_havale_anbar_='.$row1['shomare_havale_anbar'].'&code_kala_='.$row1['code_kala'].'&h_code_='.$row1['h_code'].'&meghdar_havale_forush_='.$meghdar_havale_forush.'&mande_az_forush_='.$mande_az_forush.'&idForush_='.$idForush.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'">';
	   //modaldialog
	   //if($row1['status']==0) echo'<input type="button" class="buttonme"  value="اطلاعات کالا ['.$detailcount.']"   onClick="window.showModalDialog(\'havale_detail.php?shomare_havale_anbar_='.$row1['shomare_havale_anbar'].'&code_kala_='.$row1['code_kala'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\',\'_blank\',\'dialogwidth=850px,left=250px,top=100px,scrollbars=yes\')">';
	   //else echo'<input type="button" class="buttonme-ebtal"  value="اطلاعات کالا ['.$detailcount.']"   onClick="window.showModalDialog(\'havale_detail.php?shomare_havale_anbar_='.$row1['shomare_havale_anbar'].'&code_kala_='.$row1['code_kala'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\',\'_blank\',\'dialogwidth=850px,height=390px,left=250px,top=100px,scrollbars=yes\')">';
	 }	 
	 echo'
	 </td>';
	 //ثبت نهایی
	 if($row1['sabt_nahayi']==1)echo'<td style="cursor:text;"><img src="images/save-accept.png" /></td>';
	 else if(($row1['sabt_nahayi']==0)and($detailcount!=0)and($row1['status']==0))
	 {echo'<td><img src="images/save.png" onmouseOver="this.src=\'images/save_hover.png\'" onmouseOut="this.src=\'images/save.png\'" title="ثبت نهایی حواله"
                     onClick="window.location=\''.$FileName.'?id_='.$row1['id'].'&shomare_havale_anbar_='.$row1['shomare_havale_anbar'].'&noe_tahvil_bar_='.$row1['noe_tahvil_bar'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&send_havale=1&sabt_havale=1\'" /></td>';
	 }
	 else echo'<td style="cursor:text;">&nbsp;</td>';
	 if($_SESSION['mt_webservice']==1)//متصل به وب سرویس
	 {
	   if(($row1['wb_id']=='' OR $row1['wb_id']==0)and($row1['sabt_nahayi']==1)and($row1['status']==0)and($detailcount!=0)) 
	     echo'<td><div class="webservise" id="webservise-add" title="شناسه یکتا وزارت صمت : '.$row1['wb_id'].'"  onClick="window.location=\''.$FileName.'?id_='.$row1['id'].'&shomare_havale_anbar_='.$row1['shomare_havale_anbar'].'&noe_tahvil_bar_='.$row1['noe_tahvil_bar'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&send_havale=1\'" ></div></td>';
       else if((strlen($row1['wb_id'])==14))//درست ارسال شده
	   {
		 IF($row1['status']==0)//جاری	
		  echo'<td><div class="webservise" id="webservise-accept-resend" title="شناسه یکتا وزارت صمت : '.$row1['wb_id'].'" onClick="window.location=\''.$FileName.'?id_='.$row1['id'].'&shomare_havale_anbar_='.$row1['shomare_havale_anbar'].'&noe_tahvil_bar_='.$row1['noe_tahvil_bar'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&send_havale=1\'"></div></td>';
		 ELSE //ابطالی	
		  echo'<td><img src="images/accept_database.png" title="شناسه یکتا وزارت صمت : '.$row1['wb_id'].'"/></td>';
	   }
       else echo'<td style="cursor:text;">&nbsp;</td>';
	 }
	 #second time
	 // if($_SESSION['mt_webservice']==1)//متصل به وب سرویس
	 // {
	   // if(($row1['webservice_JahadTracking']=='' OR $row1['webservice_JahadTracking']==0)and($row1['sabt_nahayi']==1)and($row1['status']==0)and($detailcount!=0)) 
	     // echo'<td><div class="webservise" id="webservise-add" title="کد رهگیری وب سرویس : '.$row1['webservice_JahadTracking'].'"  onClick="window.location=\''.$FileName.'?id_='.$row1['id'].'&shomare_havale_anbar_='.$row1['shomare_havale_anbar'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&send_havale=1\'" ></div></td>';
       // else if((strlen($row1['webservice_JahadTracking'])==28))//درست ارسال شده
	   // {
		 // IF($row1['status']==0)//جاری	
		  // echo'<td><div class="webservise" id="webservise-accept-resend" title="کد رهگیری وب سرویس : '.$row1['webservice_JahadTracking'].'" onClick="window.location=\''.$FileName.'?id_='.$row1['id'].'&shomare_havale_anbar_='.$row1['shomare_havale_anbar'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&send_havale=1\'"></div></td>';
		 // ELSE //ابطالی	
		  // echo'<td><img src="images/accept_database.png" title="کد رهگیری وب سرویس : '.$row1['webservice_JahadTracking'].'"/></td>';
	   // }
       // else echo'<td style="cursor:text;">&nbsp;</td>';
	 // }
	#first time
	 // if($_SESSION['mt_webservice']==1)//متصل به وب سرویس
	 // {
       // $first_num=substr($row1['webservice_trackcode'],0,1);//اولین رقم
	   // if(($row1['webservice_trackcode']=='')and($row1['sabt_nahayi']==1)and($row1['status']==0)and($detailcount!=0)) 
	     // echo'<td><div class="webservise" id="webservise-add" title="کد رهگیری وب سرویس : '.$row1['webservice_trackcode'].'"  onClick="window.location=\''.$FileName.'?id_='.$row1['id'].'&shomare_havale_anbar_='.$row1['shomare_havale_anbar'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&send_havale=1\'" ></div></td>';
	   // else if(($row1['webservice_trackcode']==0)and($row1['sabt_nahayi']==1)and($row1['status']==0)and($detailcount!=0)) 
	   	 // echo'<td><div class="webservise" id="webservise-delete-resend" title="کد رهگیری وب سرویس : '.$row1['webservice_trackcode'].'" onClick="window.location=\''.$FileName.'?id_='.$row1['id'].'&shomare_havale_anbar_='.$row1['shomare_havale_anbar'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&send_havale=1&resend_havale=1\'" ></div></td>';   
	   // else if((strlen($row1['webservice_trackcode'])==26)and($first_num!=0)and($row1['status']==0)and($detailcount!=0)) 
	   // { 
         // IF($first_num==1)//تکراری
		    // echo'<td><div class="webservise" id="webservise-delete-resend" title="کد رهگیری وب سرویس : '.$row1['webservice_trackcode'].'" onClick="window.location=\''.$FileName.'?id_='.$row1['id'].'&shomare_havale_anbar_='.$row1['shomare_havale_anbar'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&send_havale=1&resend_havale=1\'" ></div></td>';
		 // ELSE//سایر ایرادها
		    // echo'<td><div class="webservise" id="webservise-delete-add" title="کد رهگیری وب سرویس : '.$row1['webservice_trackcode'].'" onClick="window.location=\''.$FileName.'?id_='.$row1['id'].'&shomare_havale_anbar_='.$row1['shomare_havale_anbar'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&send_havale=1\'" ></div></td>';
	   // }
       // else if((strlen($row1['webservice_trackcode'])==26)and($first_num==0))//درست ارسال شده
	   // {
		 // IF($row1['status']==0)//جاری	
		  // echo'<td><div class="webservise" id="webservise-accept-resend" title="کد رهگیری وب سرویس : '.$row1['webservice_trackcode'].'" onClick="window.location=\''.$FileName.'?id_='.$row1['id'].'&shomare_havale_anbar_='.$row1['shomare_havale_anbar'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&send_havale=1&resend_havale=1\'"></div></td>';
		 // ELSE //ابطالی	
		  // echo'<td><img src="images/accept_database.png" title="کد رهگیری وب سرویس : '.$row1['webservice_trackcode'].'"/></td>';
	   // }
	   // else if((strlen($row1['webservice_trackcode'])==26)and($first_num!=0)and($row1['sabt_nahayi']==1)and($row1['status']==1))echo'<td><img src="images/delete_database.png" title="کد رهگیری وب سرویس : '.$row1['webservice_trackcode'].'"/></td>';
       // else echo'<td style="cursor:text;">&nbsp;</td>';
	 // }

	 echo'<td '.$edtClick.'>';IF($row1['noe_tahvil_bar']==4){if($exist_resid_motenazer==1)echo '<span class="fa fa-check-circle fa-2x" style="color:green"></span>';ELSE IF($exist_resid_motenazer_darsalbad==1)echo '<span class="fa fa-check-circle fa-2x" style="color:yellowgreen"></span>';else echo '<span class="fa fa-times-circle fa-2x" style="color:red"></span>';} echo'</td>';
	 echo'
	  <td>';
	     if($row1['javaz_ebtal'] == 1)     {echo'<div class="fa fa-check-circle fa-2x" style="color:green"  '; IF($right_javaz_ebtal) {echo' title="در صورت کلیک روی این گزینه مجوز ابطال حواله حذف میشود" onClick="window.location=\''.$FileName.'?id_='.$row1['id'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&adam_ebtal=1\'"';} echo' /></div>';}
	     else if($row1['javaz_ebtal'] == 0){echo'<div class="fa fa-times-circle fa-2x" style="color:red"    '; IF($right_javaz_ebtal) {echo' title="در صورت کلیک روی این گزینه مجوز ابطال حواله داده میشود"  onClick="window.location=\''.$FileName.'?id_='.$row1['id'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&emkan_ebtal=1\'"';} echo' /></div>';}
	     echo'
	  </td>';
	 if($right_prt)
	 {
	   if (SuperUser())
	   {
	    $prt_havale_count=$db->get_from_where("prt_havale_count","$TableName","id=".$row1['id']."");     
	    $prt_khorooj_count=$db->get_from_where("prt_khorooj_count","$TableName","id=".$row1['id'].""); 
	    echo'<td align="center"><span style="float:right">'.$prt_havale_count.'</span><div onClick="window.open(\'print_havale_one.php?id_='.$row1['id'].'&clk_p_h=1\',\'_blank\',\'scrollbars=yes\')" id="printer_T" title="چاپ حواله" style="float:center"><a href="#"></a></div></td>';
	    echo'<td align="center"><span style="float:right">'.$prt_khorooj_count.'</span><div onClick="window.open(\'print_khorooj.php?id_='.$row1['id'].'&clk_p_kh=1\',\'_blank\',\'scrollbars=yes\')" id="img_khorooj" title="چاپ برگه خروج" style="float:center"><a href="#"></a></div></td>';
	   }
	   else
	   {
	    if($row1['sabt_nahayi']==1)
		{echo'<td align="center"><div onClick="window.open(\'print_havale_one.php?id_='.$row1['id'].'&clk_p_h=1\',\'_blank\',\'scrollbars=yes\')" id="printer_T" title="چاپ حواله"><a href="#"></a></div></td>';
	     echo'<td align="center"><div onClick="window.open(\'print_khorooj.php?id_='.$row1['id'].'&clk_p_kh=1\',\'_blank\',\'scrollbars=yes\')" id="img_khorooj" title="چاپ برگه خروج"><a href="#"></a></div></td>';
        }
		else echo'<td style="cursor:text;">&nbsp;</td><td style="cursor:text;">&nbsp;</td>';		
  	   }
	 }
	 if(($right_del)and($_SESSION['mtStatusYear']==0))
	 {echo'<td><img border="0" class="1" src="images/trash.png" width="20" height="20" 
	       onmouseOver="this.src=\'images/trash_hover.png\'" 
		   onmouseOut="this.src=\'images/trash.png\'" 
		   onClick="iconfirm(\''.$FileName.'?Delete_x=1&id_='.$row1['id'].'&status_='.$row1['status'].'&shomare_havale_anbar_='.$row1['shomare_havale_anbar'].'&code_kala_='.$row1['code_kala'].'&h_code_='.$row1['h_code'].'&vazn_khales_h_='.$detail_row['sum_khales_h'].'&mande_az_forush_='.$mande_az_forush.'&idForush_='.$idForush.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\',\'براي حذف حواله '.$code_a.$row1['code_anbar'].$row1['shomare_havale_anbar'].' \')" /></td>';
	  }	 
	echo '
	</tr>';
	}
    for ($r=$i+1; $r<=$RowPerPage; $r++)
    {if($r%2) echo '
     <tr class="table-even">';
     else echo '
     <tr class="table-odd">';
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
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>';
	  if($_SESSION['mt_webservice']==1) echo'<td>&nbsp;</td>';
	  if($right_prt)echo'<td>&nbsp;</td><td>&nbsp;</td>';
	  if(($right_del)and($_SESSION['mtStatusYear']==0)) echo'<td>&nbsp;</td>';
	 echo'
	 </tr>';
	}
	echo'
   </table>
  </td>
 </tr> 
 <!--پايان مرکز صفحه -->';
 echo'
 <!-- فوتر-->
 <tr class="footer">
  <td>
   <table width="100%"  border="0" cellspacing="0" cellpadding="0" height=100%  style="margin-bottom:20px;">';
   if (!$Mode)
   {echo '	  			
	<tr>
	 <!--<td width="10px">&nbsp;</td>
	 <td width="24"><div onClick="window.open(\'print_havale.php\',\'\',\'\')" id="printer" title="چاپ"><a href="#"></a></div></td>-->
	 <td width="10px">&nbsp;</td>';
	 //اگر اجازه ایجاد رسید را دارد و وضعیت سال فعال است و سال فعال سال جاری است
	 //و در یک هفته اخیر حواله نهایی نشده نداریم
	 $exist_sabtnahayi_nashode=$db->get_from_where("COUNT(*)","havale","code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND year=$mtActiveYear AND deleted=0 AND status=0 AND sabt_nahayi=0 AND tarikh_havale_anbar<'".$Condition_SabtNashodeDate_sh."'");
	 //if(($right_ins)and($_SESSION['mtStatusYear']==0)and($_SESSION["mtActiveYear"]==$yy))
	 //if(($right_ins)and($_SESSION['mtStatusYear']==0)and($exist_sabtnahayi_nashode==0)and($mt_gl_code_anbar!=301))
	 if((($right_ins)and($_SESSION['mtStatusYear']==0)and($_SESSION['mt_anbar_activate']==1)and($exist_sabtnahayi_nashode==0))OR(($right_ins)and(($mt_gl_code_ostan==4)or($mt_gl_code_ostan==28))and($_SESSION['mt_anbar_activate']==1)and($exist_sabtnahayi_nashode==0)))
	 {echo'<td width="70px"><div onClick="window.location=\'havale_new.php?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&MaxPage='.$MaxPage.'&order='.$order.'\'" id="btn-new" title="افزودن رکورد جديد" ><a href="#"></a></div></td>	                      
	       <td width="10px">&nbsp;</td>';}
     ELSE IF($exist_sabtnahayi_nashode>0)
	 {
	  echo'<td width="20px"><div><span class="simptip-position-left simptip-fade simptip-info" data-tooltip="لطفاً حواله ها را ثبت نهایی کنید">
           <img class="help blinkelement" border="0" src="images/info2.png" style="cursor:pointer"/>
           </span></div>
		   </td>	                      
	       <td width="10px">&nbsp;</td>';
	 }	   
	 echo'
	 <td width="70px"><div onClick="window.location=\''.$FileName.'?Mode=Search&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-search" title="جستجو" ><a href="#"></a></div></td>
	 <td width="10px">&nbsp;</td>
	 <td width="70px"><div onClick="window.location=\'my_frame.php\'" id="btn-back" title="بازگشت به منوی اصلی"><a href="#"></a></div></td> 
	 <td width="20px">&nbsp;</td>	   
	 <td width="22px"><div '.$En_Prev.' onClick="window.location=\''.$FileName.'?PageNo=1&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-pageone" title="رويت اولين صفحه"><a href="#"></a></div></td>
	 <td width="2px">&nbsp;</td>
	 <td width="22px"><div '.$En_Prev.' onClick="window.location=\''.$FileName.'?PageNo='.$PrevPage.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-perevius" title="رفتن به صفحه قبلي"><a href="#"></a></div></td>
     <td width="2">&nbsp;</td>
	 <td width="40" align="center"><input type="text" name="PageNo" value="'.$PageNo.'" size="2" onChange="myform.submit()" onkeypress="return isNumber(event)" style="direction:ltr;text-align:center;"></td>		   
	 <td width="2">&nbsp;</td>		   
	 <td width="22px"><div '.$En_Next.' onClick="window.location=\''.$FileName.'?PageNo='.$NextPage.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-forward" title="رفتن به صفحه بعدي"><a href="#"></a></div></td>
     <td width="2px">&nbsp;</td>		   
	 <td width="22px"><div '.$En_Next.' onClick="window.location=\''.$FileName.'?PageNo='.$MaxPage.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-pageend" title="رويت آخرين صفحه"><a href="#" ></a></div></td>
	 <td width="2">&nbsp;</td>
	 <td width="65" align="left"><span class="text1">تعداد خط :</span></td>
	 <td align="right"><input type="text" name="wRowPerPage" value="'.$RowPerPage.'" size="2" onChange="myform.submit()" onkeypress="return isNumber(event)" style="direction:ltr;text-align:center;"></td>	 
	 <td width="10">&nbsp;</td>';
     if ($_SESSION['mt_search_havale']) 
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
	  <table class="footer-panel" width="100%" cellpadding="0" cellspacing="0" style="position:absolute;bottom:20px;right:0%;">
       <tr class="title"><td colspan="11" align="center">جستجوی حواله سردخانه</td></tr>
       <tr><td>&nbsp;</td></tr>	   
	   <tr>
	    <td align="left">شماره حواله :&nbsp;</td><td align="right"><input class="textboxme2 textbox50 type="text" name="shomare_havale_anbar" onkeypress="return isNumber(event)"/>&nbsp;/&nbsp;';
	  	 if(strlen($mt_gl_code_ostan)==1) $code_a=make_pattern($mt_gl_code_ostan,2);
		 else $code_a=$mt_gl_code_ostan;
		 echo'<input type="text" class="textboxme" readonly value="'.$code_a.$mt_gl_code_anbar.'" name="ostan_anbar" style="width:50px;"/>
		</td>
	    <td align="left"> تاريخ حواله :&nbsp;</td><td align="right"><input type="text" class="textboxme2" id="datepicker5" name="tarikh_havale_anbar" maxlength="10" value="'.$tarikh_havale_anbar.'"/></td>
	    <td align="left"> زیرانبار :&nbsp;</td>
	    <td align="right">'.listbox("code_ziranbar",$code_ziranbar,"code_ziranbar","name_ziranbar","list_sardkhane_detail","1=1 AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' ORDER BY name_ziranbar ASC","class='text4'","").'&nbsp;&nbsp;</td>
	    <td align="left">کد کالا :&nbsp;</td><td align="right"><input type="text" class="textboxme2" name="code_kala" value="'.$code_kala.'" onkeypress="return isNumber(event)" onKeyUp="F10desc(event)" onblur="enterCodeKala(this.value)" style="width:50px;"/>&nbsp;';
		include ("img_helpkala.php");
		echo'
		</td>
	    <td align="left"> کد مشتری :&nbsp;</td><td align="right"><input type="text" class="textboxme2 textbox50" name="code_customer" value="'.$code_customer.'" onkeypress="return isNumber(event)"/>&nbsp;';
	     include ("img_searchmoshtary.php");
		echo'
		</td>
	   </tr>
       <tr>	   
		<td align="left">شماره حواله فروش :&nbsp;</td><td align="right"><input class="textboxme2" type="text" name="h_code" onkeypress="return isNumber(event)"/>&nbsp;';
		include ("img_helphavaleforush.php");echo'
		</td>
		<td align="left"> شماره مجوز جابه جایی :&nbsp;</td><td align="right"><input type="text" class="textboxme2" name="shomare_jabejae" value="'.$shomare_jabejae.'"/>&nbsp;';
        include ("img_helpjabejae_report.php");
        echo' 
	    <td align="left"> شماره کاميون :&nbsp;</td><td align="right"><input type="text" class="textboxme2" name="shomare_kamiyon_h" value="'.$shomare_kamiyon_h.'"/></td>
	    <td align="left"> پلاک خودرو :&nbsp;</td>
		<td align="right">
	 		   <sup>ایران</sup>
			   <input type="text" class="textboxme2" name="plak1" value="'.$plak1.'" onkeypress="return isNumber(event);" maxlength="2" placeholder="11" style="width:20px;"/> |
			   <input type="text" class="textboxme2" name="plak2" value="'.$plak2.'" onkeypress="return isNumber(event);" maxlength="3" placeholder="111" style="width:30px;"/>
			   <input type="text" class="textboxme2" name="plak3" value="'.$plak3.'" maxlength="1" placeholder="ع" style="width:20px;"/>
			   <input type="text" class="textboxme2" name="plak4" value="'.$plak4.'" onkeypress="return isNumber(event);" maxlength="2" placeholder="11" style="width:20px;"/>
	    </td>
		<td align="left"> وزن خالص :&nbsp;</td><td align="right"><input type="text" class="textboxme2" name="vazn_khales_h" value="'.$vazn_khales_h.'" onkeypress="return isNumber(event)"/></td>
	  </tr>
	  <tr>
	   <td align="left"> وضعیت ثبت :&nbsp;</td><td align="right"><select class="text4" name="sabt_nahayi"><option value="-1">انتخاب کنید</option><option value="0">ثبت نشده</option><option value="1">ثبت شده</option></select></td>
	   <td align="left"> وضعیت حواله :&nbsp;</td><td align="right">'.static_listbox("status",-1,"statusFormArr",1,"class='text4'").'</td>
	   <td align="left"> نوع تحویل بار :&nbsp;</td><td align="right">'.static_listbox("noe_tahvil_bar",$noe_tahvil_bar,"tahvilbarArr_h",1,"class='text4'").'</td>
	   <td align="left"> شماره باسکول :&nbsp;</td><td align="right"><input type="text" class="textboxme2" name="bsk_no" value="'.$bsk_no.'" onkeypress="return isNumber(event)"/></td>
	  </tr>
	  <tr class="title">
        <td colspan="10" align="center">
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
 <!-- پايان فوتر-->';
echo'	
</table>
</div>
'.$message.'
</form>
</body>
</html>';
//حواله هایی که رسیدشان را نزده اند
if($Mode=='')echo'<div id="notice" style="position:fixed;top:10px;right:15px;" ></div>';  	
////////////مجوز ابطال حواله//////////////////////
if(isset($emkan_ebtal))
{
 $res_update_javaz=$db->query("UPDATE $mydatabase.havale SET javaz_ebtal='1' WHERE id='$id_'");    
 if($res_update_javaz){$log=$db->query("INSERT INTO $mydatabase.log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','havale','$id_','تیک مجوز ابطال حواله',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')"); /*کوئری لاگ*/}
 echo "<script>window.location='$FileName?PageNo=".$PageNo."&RowPerPage=".$RowPerPage."&order=".$order."';</script>"; 	
}

if(isset($adam_ebtal))
{
  $res_update_javaz=$db->query("UPDATE $mydatabase.havale SET javaz_ebtal='0' WHERE id='$id_'");    
  if($res_update_javaz){$log=$db->query("INSERT INTO $mydatabase.log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','havale','$id_','تیک عدم مجوز ابطال حواله',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')"); /*کوئری لاگ*/}
  echo "<script>window.location='$FileName?PageNo=".$PageNo."&RowPerPage=".$RowPerPage."&order=".$order."';</script>"; 	
}
?>