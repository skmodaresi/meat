<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="havale_edit.php";
$TableName="havale";
//$logtime=date('H:i:s');
$titr='ویرایش حواله سردخانه';
$today=AsLDate($yymmdd);
$right_edt=0;$right_ebtal=0;$right_free_ebtal=0;
if (right(172)) $right_edt=1;
if (right(175)) $right_ebtal=1;
if (right(602)) $right_free_ebtal=1;

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
function enterIE()
{
   if(window.event.keyCode == 13 && window.event.srcElement.id !=\'sabt\')
   window.event.keyCode = 9;
}
function changeFocus(elmnt)
{
  var next;
  if (elmnt.value.length==elmnt.maxLength)
  {
   next=elmnt.tabIndex + 1;
   //look for the fields with the next tabIndex
   var f = elmnt.form;
   for (var i = 0; i < f.elements.length; i++)
  {
   if (next<=f.elements[i].tabIndex)
    {
    f.elements[i].focus();
    break;
    }
   }
  }
}
<!--تغییر براساس نوع تحویل بار-->
$(document).ready(function() {
  $("[name=noe_tahvil_bar]").bind("change", function (){
    if($(this).val() == 2)<!--نوع تحویل بار روباری --> 
	{
	   $("#loading").fadeIn("fast");
	   $("[name=nerkh_bargiry_this]").prop("disabled", true);
	   $(".robaryhide").hide();
	   $("#loading").fadeOut("fast");	
    }
    else <!--در سایر موارد-->
	{
	   $("#loading").fadeIn("fast");
	   $("[name=nerkh_bargiry_this]").prop("disabled", false);
	   $(".robaryhide").show();
	   $("#loading").fadeOut("fast");	   
    }
 });
});
$(document).ready(function() {	
	    $("#tarikh_barname_h,#tarikh_havale_anbar,#tarikh_govahi_behdashti").datepicker({
		showOn: "button",
        buttonImage: "styles/images/calendar5.png",
        buttonImageOnly: true,
		showButtonPanel: true,
		changeMonth: true,
	    changeYear: true,
		});
	   $("#forush_jabejae_date").datepicker({
		showOn: "Off",
		});
	    function customRange(input)//تاریخ حواله و تاریخ بارنامه از تاریخ حواله فروش یا تاریخ مجوز جابه جایی کمتر نباشد
	    {  
	      var x1=$("#forush_jabejae_date").datepicker("getDate"); 
	      $("#tarikh_barname_h").datepicker( "option", "minDate",x1 );
	      $("#tarikh_havale_anbar").datepicker( "option", "minDate",x1 );  	 
	    }
		$("#tarikh_barname_h,#tarikh_havale_anbar").datetimepicker({
            beforeShow: customRange()
        });	
		 
});
function getDetailForush(s_h_f)<!-- اطلاعات حواله فروش-->
{
   $("#loading").fadeIn("fast");  
   $.post("ajax_detail_forush.php",{shomareHAVALEFORUSH: s_h_f},function(data){
		   var splForush = data.split("^");
		   $("#h_reg_date").val(splForush[0]);
		   $("#code_kala").val(splForush[1]);
		   $("#name_kala").val(splForush[2]);
		   $("#sharh_bastebandy").val(splForush[3]);		   
		   $("#code_customer").val(splForush[4]);
		   $("#name_customer").val(splForush[5]);
		   $("#ostan_moshtary").val(splForush[6]);
		   $("#shahr_moshtary").val(splForush[7]);
		   $("#h_deli_name").val(splForush[8]);
		   $("#meghdar_havale_forush").val(splForush[9]);
		   $("#meghdar_tahvily").val(splForush[10]);
		   $("#meghdar_batele").val(splForush[11]);
		   $("#mande_az_forush").val(splForush[12]);
		   $("#nerkh_bargiry_this").val(splForush[13]);
		   $("#mablagh_bargiry").val(splForush[13]);
		   $("#idForush").val(splForush[14]);
		   var x1=$("#h_reg_date").val();
		   $("#tarikh_barname_h").datepicker( "option", "minDate",x1 );  
		   <!--$("#img_mojody").html(splForush[13]);-->
		   $("#loading").fadeOut("fast");	
		 });	
}
function getDetailJabejae(sh_j,noe_tahvil)<!-- اطلاعات مجوز جابه جایی-->
{
   //alert(noe_tahvil);
   $("#loading").fadeIn("fast");  
   $.post("ajax_detail_jabejae.php",{shomareJABEJAE:sh_j,noeTahvilBar:noe_tahvil},function(data){
		   var splJabejae = data.split("^");
		   $("#tarikh_jabejae").val(splJabejae[0]);
		   $("#code_ostan_maghsad_j").val(splJabejae[1]);
		   $("#code_anbar_maghsad_j").val(splJabejae[2]);
		   $("#code_kala").val(splJabejae[3]);
		   $("#name_kala").val(splJabejae[4]);
		   $("#sharh_bastebandy").val(splJabejae[5]);
		   $("#meghdar_jabejae").val(splJabejae[6]);
		   $("#meghdar_tahvily_j").val(splJabejae[7]);
		   $("#meghdar_batele_j").val(splJabejae[8]);
		   $("#mande_az_jabejae").val(splJabejae[9]);
		   $("#nerkh_bargiry_this").val(splJabejae[10]);
		   $("#mablagh_bargiry").val(splJabejae[10]);
		   $("#idJabejae").val(splJabejae[11]);
		   $("#code_customer").val(splJabejae[12]);
		   $("#name_customer").val(splJabejae[13]);
		   $("#rahnama").val(splJabejae[14]);
		   var x1=$("#tarikh_jabejae").val();
		   $("#tarikh_barname_h").datepicker( "option", "minDate",x1 );		   
		 });
    $("#loading").fadeOut("fast");
}
<!-- dont use-->
function getDetailMojody(id_mojody)<!-- اطلاعات موجودی کالا-->
{
   $("#loading").fadeIn("fast");  
   $.post("ajax.php",{idMOJODY: id_mojody},function(data){
		   var splMojody = data.split("^");
		   $("#code_keshvar").val(splMojody[0]);
		   $("#name_keshvar").val(splMojody[1]);
		   $("#tarikh_tolid").val(splMojody[2]);
		   $("#mojody_khales").val(splMojody[3]);
		 });
   $("#loading").fadeOut("fast");	
}
function getVaznKarton(c_karton)<!-- اطلاعات کارتن-->
{
   $("#loading").fadeIn("fast");  
   $.post("ajax.php",{codeKARTON: c_karton},function(data){
		   var splKarton = data.split("^");
		   $("#sharh_karton").val(splKarton[0]);
		   $("#vazn_karton_this").val(splKarton[1]);
		 });
   $("#loading").fadeOut("fast");	
}
function vazn_nakhales()
{
 var natije_vazn_na;
 natije_vazn_na=Number(document.myform.vazn_kamiyon_bar_h.value)-Number(document.myform.vazn_kamiyon_h.value);                                      
 document.myform.vazn_nakhales_h.value=natije_vazn_na;
}
function vazn_khales()
{
 var natije_vazn,natije_mablaghBar;
 natije_vazn=Number(document.myform.vazn_nakhales_h.value)-Number(document.myform.sum_karton_h_this.value);                                      
 natije_mablaghBar=(natije_vazn)*(Number(document.myform.nerkh_bargiry_this.value));                                       
 document.myform.vazn_khales_h.value=natije_vazn;
 document.myform.mablagh_bargiry.value=natije_mablaghBar;
}
function sumkarton()
{
 var sum_k;
 sum_k=Number(document.myform.vazn_karton_this.value)*Number(document.myform.tedad_karton_h.value);
 document.myform.sum_karton_h_this.value=sum_k;
} 
function tahvil_mande()
{
 var natije1,natije2;
 document.myform.meghdar_tahvily.value=Number(document.myform.vazn_kamiyon_bar_h.value)-Number(document.myform.vazn_kamiyon_h.value);                                       
 document.myform.mande_az_forush.value=Number(document.myform.meghdar_havale_forush.value)-Number(document.myform.meghdar_tahvily.value)-Number(document.myform.meghdar_batele.value);
 natije1=document.myform.meghdar_tahvily.value;
 natije2=document.myform.mande_az_forush.value;
 return natije1,natije2;
}
<!-- نرخ باسکول با انتخاب نوع خودرو-->
function getNerkhBaskul(noe_khodro)
{
  $("#loading").fadeIn("fast");  
  $.post("ajax.php",{noeKHODRO:noe_khodro},function(data){
   $("#mablagh_baskul").val(data);
  });
  $("#loading").fadeOut("fast");		
}
</script>
</head>';
if(!(isset($Mode))) $Mode='';
/************FREE BUTTON********/// آزادکردن 
if (isset($free_x))
{
 	$free_q ="UPDATE $TableName SET set_sanad=0 WHERE id=$id_"; 
    $free_res = mysql_query($free_q);
    /*log*/$log_d=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_','آزاد کردن حواله جهت ابطال',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')");
 	if($free_res and $log_d) 
	 echo "<script>window.location='havale.php?PageNo=".$PageNo."&RowPerPage=".$RowPerPage."&order=".$order."';</script>";   
   	
}
/************EBTAL BUTTON********/// ابطال حواله انبار 
if (isset($ebtal_x))
{
  // $mande_az_jabejae_again=$db->get_from_where("mande_az_jabejae","mojavez_jabejae","code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND shomare_jabejae='$shomare_jabejae_'");   
  // echo"<script>window.alert('$mande_az_jabejae_again')</script>";
  // echo"<script>window.alert('$vazn_khales_h_')</script>";
 mysql_query('SET AUTOCOMMIT=0');//TRANSACTIONشروع 
 mysql_query('START TRANSACTION');
 $register_error_code=$db->get_from_where("register_error_code","list_sardkhane","code_ostan=".$mt_gl_code_ostan." AND code_anbar=".$mt_gl_code_anbar."");     
 $webservice_JahadTracking=$db->get_from_where("webservice_JahadTracking","havale","id=$id_");
 $revokeTime = date('H:i');
 $ebtal_q ="UPDATE $TableName SET status=1,revokeDate='$today',revokeTime='$revokeTime' WHERE id=$id_";
 $ebtal_res=mysql_query($ebtal_q);
 /*log*/$log_d=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_','ابطال حواله',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')"); 
   $exist_detail=$db->get_from_where("count(*)","havale_detail","shomare_havale_anbar='".$shomare_havale_anbar_."' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear'");
   if($exist_detail)
   {
    $ebtal_q_d ="UPDATE havale_detail SET status=1 WHERE shomare_havale_anbar='".$shomare_havale_anbar_."' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear'";
    $ebtal_res_d=mysql_query($ebtal_q_d); 
   	$q_detail="SELECT * From havale_detail WHERE shomare_havale_anbar='".$shomare_havale_anbar_."' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear'";	
	$res_detail=mysql_query($q_detail);
	while($row_detail=mysql_fetch_assoc($res_detail))//به ازای هر کدام از جزئیات موجودی ها را برمی گردانیم
	{
	 //خواندن موجودی با استفاده از تابع 
     $update_tedad_karton=mojodyKarton($row_detail['code_ostan'],$row_detail['code_anbar'],$row_detail['year'],$row_detail['code_ziranbar'],$row_detail['code_kala'],$row_detail['code_keshvar'],$row_detail['code_tolidkonande'],$row_detail['sal_tolid_shamsi'],$row_detail['mah_tolid_shamsi'],$row_detail['rouz_tolid_shamsi'],$row_detail['code_karton'],$row_detail['code_mandegari']);
     $update_mojody_nakhales=mojodyNakhales($row_detail['code_ostan'],$row_detail['code_anbar'],$row_detail['year'],$row_detail['code_ziranbar'],$row_detail['code_kala'],$row_detail['code_keshvar'],$row_detail['code_tolidkonande'],$row_detail['sal_tolid_shamsi'],$row_detail['mah_tolid_shamsi'],$row_detail['rouz_tolid_shamsi'],$row_detail['code_karton'],$row_detail['code_mandegari']);
     $update_mojody_khales=mojodyKhales($row_detail['code_ostan'],$row_detail['code_anbar'],$row_detail['year'],$row_detail['code_ziranbar'],$row_detail['code_kala'],$row_detail['code_keshvar'],$row_detail['code_tolidkonande'],$row_detail['sal_tolid_shamsi'],$row_detail['mah_tolid_shamsi'],$row_detail['rouz_tolid_shamsi'],$row_detail['code_karton'],$row_detail['code_mandegari']);	 
	 IF($row_detail['code_kala']==50)$update_tedad_shane=$update_tedad_karton*$_SESSION["mtShane"];
	 ELSE IF($row_detail['code_kala']==54)$update_tedad_shane=$update_tedad_karton*$_SESSION["mtShane_dakheli"];
	 ELSE $update_tedad_shane=0;
	 //خواندن موجودی  
	 $q_m="SELECT id FROM mojody_kala WHERE code_kala=".$row_detail['code_kala']." AND code_keshvar=".$row_detail['code_keshvar']." AND code_tolidkonande=".$row_detail['code_tolidkonande']." AND sal_tolid_shamsi=".$row_detail['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row_detail['mah_tolid_shamsi']."  AND rouz_tolid_shamsi=".$row_detail['rouz_tolid_shamsi']." AND code_karton=".$row_detail['code_karton']." AND code_ostan=".$row_detail['code_ostan']." AND code_anbar=".$row_detail['code_anbar']." AND code_ziranbar=".$row_detail['code_ziranbar']." AND year=".$row_detail['year']." AND deleted=0";       
	 $res_m=mysql_query($q_m);
     $row_m=mysql_fetch_assoc($res_m); 
	 //آپدیت موجودی کالا در جدول موجودی کالا
	 //$update_tedad_karton=$row_m['tedad_karton']+$row_detail['tedad_karton_h_d'];//آپدیت تعداد کارتن های موجود در انبار
     //$update_mojody_nakhales=$row_m['mojody_nakhales']+$row_detail['vazn_nakhales_h_d'];//آپدیت موجودی ناخالص کالا در جدول موجودی کالا  
	 //$update_mojody_khales=$row_m['mojody_khales']+$row_detail['vazn_khales_h_d'];//آپدیت موجودی خالص کالا در جدول موجودی کالا
	 $res_update_mojody=$db->query("UPDATE mojody_kala SET mojody_khales=$update_mojody_khales,mojody_nakhales=$update_mojody_nakhales,tedad_karton=$update_tedad_karton,tedad_shane=$update_tedad_shane WHERE code_kala=".$row_detail['code_kala']." AND code_keshvar=".$row_detail['code_keshvar']." AND code_tolidkonande=".$row_detail['code_tolidkonande']." AND sal_tolid_shamsi=".$row_detail['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row_detail['mah_tolid_shamsi']."  AND rouz_tolid_shamsi=".$row_detail['rouz_tolid_shamsi']." AND code_karton=".$row_detail['code_karton']." AND code_ostan=".$row_detail['code_ostan']." AND code_anbar=".$row_detail['code_anbar']." AND code_ziranbar=".$row_detail['code_ziranbar']." AND year=".$row_detail['year']." AND deleted=0");      	 
	 /*log*/if($res_update_mojody) $log_m_e=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','mojody_kala',".$row_m['id'].",'ابطال حواله انبار و برگشت موجودی کالا',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')");
	}
	if(($noe_tahvil_bar_==4)or($noe_tahvil_bar_==5)or($noe_tahvil_bar_==7))//جابه جایی
    {
     $mande_az_jabejae_again=$db->get_from_where("mande_az_jabejae","mojavez_jabejae","code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND shomare_jabejae='$shomare_jabejae_'");   
     // بسته بندی قوطی , تعدادرا کم میکنیم
     if($code_bastebandy_==2) $update_mande_j=$mande_az_jabejae_again+$tedad_karton_h_;
	 else if($code_kala_==50) $update_mande_j=$mande_az_jabejae_again+($tedad_karton_h_*$_SESSION["mtShane"]);
	 else if($code_kala_==54) $update_mande_j=$mande_az_jabejae_again+($tedad_karton_h_*$_SESSION["mtShane_dakheli"]);
	 //سایر بسته بندی ، وزن را کم میکنیم
	 else $update_mande_j=$mande_az_jabejae_again+$vazn_khales_h_;
    
     $res_update_mande_j=$db->query("UPDATE mojavez_jabejae SET mande_az_jabejae='$update_mande_j' WHERE shomare_jabejae='$shomare_jabejae_' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0");    
	 if($res_update_mande_j){$log_mande_j_e=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','mojavez_jabejae','$idJabejae_','حذف جزئیات کالا در حواله و برگشت مانده از مجوز جابه جایی',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')"); /*کوئری لاگ*/}
    }
	else
	{
	 /**اگر به فروش متصل نیستیم**/
	 if($_SESSION['mt_systemforush']==0)
	 {
	  //آپدیت مانده مقدار حواله فروش در جدول حواله فروش سیستم انبار
	  $mande_az_forush_again=$db->get_from_where("mande_az_forush","havale_forush","code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND h_code='$h_code_'");   
      // بسته بندی قوطی , تعدادرا کم میکنیم
	  if($code_bastebandy_==2) $update_mande1=$mande_az_forush_again+$tedad_karton_h_;
	  else if($code_kala_==50) $update_mande1=$mande_az_forush_again+($tedad_karton_h_*$_SESSION["mtShane"]);
	  else if($code_kala_==54) $update_mande1=$mande_az_forush_again+($tedad_karton_h_*$_SESSION["mtShane_dakheli"]);
	  //سایر بسته بندی ، وزن را کم میکنیم
	  else $update_mande1=$mande_az_forush_again+$vazn_khales_h_;
	  $res_update_mande=$db->query("UPDATE havale_forush SET mande_az_forush='$update_mande1' WHERE h_code='$h_code_' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear'");	  
	  $log_mande_e=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','havale_forush','$idForush_','ابطال حواله انبار و برگشت مانده از فروش در سیستم سردخانه',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')"); /*کوئری لاگ*/
	 }
	 /**اگر به فروش متصل هستیم**/
	 if($_SESSION['mt_systemforush']==1)
	 {
	  //آپدیت مانده مقدار حواله فروش در جدول حواله فروش سیستم فروش
	   mysql_select_db('sell') or die('no Select Db BECAUSE: ' . mysql_error());
	   $mande_az_forush_again=$db->get_from_where("h_mande_havale","dm_havale","h_id='$idForush_'");   
      // بسته بندی قوطی , تعدادرا کم میکنیم
	   if($code_bastebandy_==2) $update_mande2=$mande_az_forush_again+$tedad_karton_h_;
	   else if($code_kala_==50) $update_mande2=$mande_az_forush_again+($tedad_karton_h_*$_SESSION["mtShane"]);
	   else if($code_kala_==54) $update_mande2=$mande_az_forush_again+($tedad_karton_h_*$_SESSION["mtShane_dakheli"]);
	   //سایر بسته بندی ، وزن را کم میکنیم
	   else $update_mande2=$mande_az_forush_again+$vazn_khales_h_; 
       	  
	   $res_update_mande=$db->query("UPDATE dm_havale SET h_mande_havale='$update_mande2' WHERE h_id='$idForush_'");    
	   mysql_select_db($mydatabase) or die('no Select Db BECAUSE: ' . mysql_error());
	   $log_mande_e=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','havale_forush','$idForush_','ابطال حواله انبار و برگشت مانده از فروش در سیستم فروش',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')"); /*کوئری لاگ*/
	 } 
	}
   //}
   }
   //if(($ebtal_res and $log_d and $ebtal_q_d and $res_update_mojody and $log_m_e and $res_update_mande_j and $log_mande_j_e)or($ebtal_res and $log_d and $ebtal_q_d and $res_update_mojody and $log_m_e and $res_update_mande and $log_mande_e))
   if(($ebtal_res and $log_d)or($ebtal_res and $log_d and $ebtal_q_d and $res_update_mojody and $log_m_e and $res_update_mande_j and $log_mande_j_e)or($ebtal_res and $log_d and $ebtal_q_d and $res_update_mojody and $log_m_e and $res_update_mande and $log_mande_e))
   {
	 /********************WEB SERVICE NEW***********************/
	 if(($_SESSION['mt_webservice']==1)AND($register_error_code==0)AND($webservice_JahadTracking>0)AND($exist_kala_detail))//اتصال به وب سرویس
	 {
	   $wsdl_url='http://10.7.234.33/anbar/warehouse.asmx?wsdl';
	   header('Content-Type: text/html; charset=utf-8');
       try
	   {
	    $client=new SoapClient($wsdl_url);
        $params=array(
		  'username'=>'02',
          'password'=>'HJ78mnGD',
		  'co_national_id'=>'14002771736',
          'JahadTracking'=>$webservice_JahadTracking
        );
        $result=$client->RevokeWarehouseDocument($params);
	    $response=$result->RevokeWarehouseDocumentResult;
	    $webservice_error_code =$response->error_code;
	    $webservice_error_message =$response->error_message;
	    $webservice_status =$response->status;
	    $webservice_number =$response->number;
	    $webservice_JahadTracking =$response->JahadTracking;
      }//END try
	  catch(SoapFault $client)
	  {
		 echo "<script>alert('وب سرویس فعال نمی باشد')</script>";
		 echo  $e->getMessage();
	  }
	   $update_track=("UPDATE havale SET webservice_error_code='$webservice_error_code',webservice_error_message='$webservice_error_message',webservice_status='$webservice_status' WHERE code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND shomare_havale_anbar='$shomare_havale_anbar_' AND year=$mtActiveYear");
	   $update_res=mysql_query($update_track);
     }
	 // if(($_SESSION['mt_webservice']==1)and($exist_detail))//اتصال به وب سرویس
     // {
       // $shenaseSazman="02";
	   // if(strlen($mt_gl_code_ostan)==1) $code_a=make_pattern($mt_gl_code_ostan,2);
       // else $code_a=$mt_gl_code_ostan;
	   // $shenaseAnbar=$code_a.$mt_gl_code_anbar;
	   // $webservice_trackcode=$db->get_from_where("webservice_trackcode","havale","id=$id_");
	   // $c_ostan=substr($webservice_trackcode,4,2);
	   // $c_anbar=substr($webservice_trackcode,6,3);
	   // if(($c_ostan==$code_a)AND($c_anbar==$mt_gl_code_anbar))$shomareBijak=$code_a.$mt_gl_code_anbar.$shomare_havale_anbar_;
	   // else $shomareBijak='0'.$mtActiveYear.$shomare_havale_anbar_;      
	   // $wsdl_url='http://10.7.234.33/warehouse/warehouse.asmx?wsdl';
	   // header('Content-Type: text/html; charset=utf-8');
       // try
	   // {
	     // $client=new SoapClient($wsdl_url);
	     // //$revokeDate=$yy.'-'.$mm.'-'.$dd;
	     // $revokeDate=date("Y-m-d");
		 // $params=array(
         // 'OrganNo_'=>$shenaseSazman,
         // 'WareHouseNo'=>$shenaseAnbar,
         // 'BijakNo'=>$shomareBijak,
         // 'RevokeDate'=>$revokeDate,
         // 'RevokeTime'=>$revokeTime,
	     // 'Username'=>'warehouseuser',
         // 'Password'=>'AqWsXz@8246'
         // );
         // $result=$client->RevokBijak($params);
	     // $response=$result->RevokBijakResult;
	     // echo "<script>alert('کد پیگیری وب سرویس\\n$response')</script>"; 
		 // //$sendebtal=1;
	   // }
	   // catch(SoapFault $client)
	   // {
	     // $response=0;
		 // echo "<script>alert('وب سرویس فعال نمی باشد')</script>";
	   // }
	   // $update_sendebtal=("UPDATE havale SET webservice_sendebtal='$response' WHERE code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND shomare_havale_anbar='$shomare_havale_anbar_' AND year=$mtActiveYear");
	   // $insert_res=mysql_query($update_sendebtal);
      // }
	 mysql_query("COMMIT");
	 echo "<script>window.location='havale.php?PageNo=".$PageNo."&RowPerPage=".$RowPerPage."&order=".$order."';</script>";   
   }
   else 
   {
     mysql_query('ROLLBACK');//nothing will be done, I assume it's for testing
	 echo "<script>alert(' * مشکلی در ابطال حواله به وجود آمده است ! *')</script>";
	 echo"<script>window.location='havale.php?PageNo=".$PageNo."&RowPerPage=".$RowPerPage."&order=".$order."';</script>";  
   }
   mysql_query('SET AUTOCOMMIT=1');
}//END EBTAL
/***************************************** MAIN*****************************************/	
//برای هر دو سیستم انبار و فروش   
  $q1=("SELECT $TableName.*,kala.code_kala,kala.name_kala,kala.code_bastebandy,bastebandy.code_bastebandy,bastebandy.sharh_bastebandy	 
       FROM $TableName 
       INNER JOIN kala ON $TableName.code_kala=kala.code_kala	 
       INNER JOIN bastebandy ON bastebandy.code_bastebandy=kala.code_bastebandy 	             
	   WHERE $TableName.id=$id_ AND $TableName.shomare_havale_anbar='$shomare_havale_anbar_' AND $TableName.code_ostan=$mt_gl_code_ostan AND $TableName.code_anbar=$mt_gl_code_anbar AND $TableName.year=$mtActiveYear AND $TableName.deleted=0");	
  $res1=$db->query($q1);
  $row1=$db->fetch_assoc($res1);
  //$code_customer=$row1['code_customer'];
//  echo $q1;
  //نام مشتری
  //$name_customer=customer($row1['code_customer']);//تابع
  $detailcount=$db->get_from_where("count(*)","havale_detail","shomare_havale_anbar=".$row1['shomare_havale_anbar']." AND code_ostan=".$row1['code_ostan']." AND code_anbar=".$row1['code_anbar']." AND year=".$row1['year']."");
  if(($row1['noe_tahvil_bar']==4)or($row1['noe_tahvil_bar']==5)or($row1['noe_tahvil_bar']==6)or($row1['noe_tahvil_bar']==7))//اگر نوع تحویل بار جابه جایی 
  {
     $q_jabejae=("SELECT m_j.*,ostan.name_ostan,list_sardkhane.name_anbar,mt_skk.code_skk,mt_skk.name_skk FROM mojavez_jabejae m_j
                  LEFT JOIN ostan ON ostan.code_ostan=m_j.code_ostan_maghsad_j           
                  LEFT JOIN list_sardkhane ON list_sardkhane.code_anbar=m_j.code_anbar_maghsad_j AND list_sardkhane.code_ostan=m_j.code_ostan_maghsad_j 
				  LEFT JOIN mt_skk ON mt_skk.code_skk=m_j.code_skk           
				  WHERE m_j.shomare_jabejae='".$row1['shomare_jabejae']."' AND m_j.code_ostan='$mt_gl_code_ostan' AND m_j.code_anbar='$mt_gl_code_anbar' AND m_j.year='$mtActiveYear' AND m_j.deleted=0");	
	 $res_jabejae=mysql_query($q_jabejae);
     $row_jabejae=mysql_fetch_assoc($res_jabejae);
     $code_customer=$row_jabejae['code_customer'];
     //محاسبه مقدار تحویلی از مجوز جابه جایی با استفاده از تابع
	 $meghdar_tahvily_j=tahvily_az_jabejae($row_jabejae['shomare_jabejae'],$row_jabejae['code_ostan'],$row_jabejae['code_anbar'],$row_jabejae['year'],$row1['code_bastebandy'],$row1['code_kala']);
     //محاسبه مقادیر باطله مجوز جابه جایی با استفاده از تابع
	 $maghadir_batele_j=batele_jabejae($row_jabejae['shomare_jabejae'],$row_jabejae['code_ostan'],$row_jabejae['code_anbar'],$row_jabejae['year']);
  }
  ///////////////////////////////////////////////////////////////////////////
  else//جابه جایی نباشد
  {
  //محاسبه مقدار تحویلی حواله فروش با استفاده از تابع   
   $meghdar_tahvily=tahvily_az_forush($row1['h_code'],$row1['code_ostan'],$row1['code_anbar'],$row1['year'],$row1['code_bastebandy'],$row1['code_kala']);
   //اگر سیستم سردخانه
   if($_SESSION['mt_systemforush']==0)
  { 
   //بدست آوردن تاریخ ومقدار حواله فروش و مانده از فروش و کد مشتری
   $q_havale_forush="SELECT h_reg_date,meghdar_havale_forush,mande_az_forush,id,code_customer,h_deli_name FROM havale_forush WHERE h_code='".$row1['h_code']."' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear'";
   $res_havale_forush=mysql_query($q_havale_forush);
   $row_havale_forush=mysql_fetch_array($res_havale_forush);
   $meghdar_havale_forush=$row_havale_forush['meghdar_havale_forush'];
   $tarikh_forush=$row_havale_forush['h_reg_date'];
   $mande_az_forush=$row_havale_forush['mande_az_forush'];
   $code_customer=$row_havale_forush['code_customer'];
   $h_deli_name=$row_havale_forush['h_deli_name'];
   // محاسبه مقدار باطله
   $q21="SELECT SUM(meghdar_batele) FROM ebtal WHERE h_code='".$row1['h_code']."' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0";
   $res21=mysql_query($q21);
   $meghdar_bateleha=mysql_fetch_array($res21);
   $meghdar_batele=$meghdar_bateleha[0];
   /**///محاسبه مقدار مانده از حواله فروش $mande_az_forush=$meghdar_havale_forush-$meghdar_tahvily-$meghdar_batele;
  }
//اگر سیستم فروش  
  else
  {  
   mysql_select_db('sell') or die('no Select Db BECAUSE: ' . mysql_error());
  //پیدا کردن آی دی کد استان مربوط به سیتم فروش
   $res_ostan=mysql_query("SELECT province_id FROM dm_province WHERE province_code='$mt_gl_code_ostan'");
   $sell_id_ostan=mysql_result($res_ostan, 0, 'province_id');
  //پیدا کردن آی دی کد انبار مربوط به سیستم فروش
   $res_anbar=mysql_query("SELECT l_id FROM dm_location_goods WHERE l_id_province='$sell_id_ostan' AND l_code='$mt_gl_code_anbar'");
   $sell_id_anbar=mysql_result($res_anbar, 0, 'l_id');
  //پیدا کردن آی دی سال مربوط به سیستم فروش
   IF($mtActiveYear<1400) $sellYearCode=substr($mtActiveYear,2);
   ELSE $sellYearCode=$mtActiveYear;
   $res_sal=mysql_query("SELECT year_id FROM dm_year WHERE year_code='$sellYearCode'");
   $sellYearId=mysql_result($res_sal, 0, 'year_id');
   //بدست آوردن تاریخ ومقدار حواله فروش و مانده از فروش وکد مشتری
	$q_havale_forush="SELECT h_id,h_reg_date,h_pre_amount,h_mande_havale,h_customer_code,h_deli_name FROM dm_havale WHERE h_code='".$row1['h_code']."' AND h_id_province='$sell_id_ostan' AND h_l_code='$sell_id_anbar' AND h_id_year='$sellYearId'";
    $res_havale_forush=mysql_query($q_havale_forush);
    $row_havale_forush=mysql_fetch_array($res_havale_forush);
	$meghdar_havale_forush=$row_havale_forush['h_pre_amount'];
	$mande_az_forush=$row_havale_forush['h_mande_havale'];
	$code_customer=$row_havale_forush['h_customer_code'];
	$h_deli_name=$row_havale_forush['h_deli_name'];
     //تبدیل تاریخ میلادی به شمسی
	   $sql_tarikh=$row_havale_forush['h_reg_date'];
       $d=substr($sql_tarikh,8,2);
       $m=substr($sql_tarikh,5,2);
       $y=substr($sql_tarikh,0,4);
       $shamsi=gregorian_to_jalali($y,$m,$d);
       $sal=$shamsi[0];
       $mah=$shamsi[1];
       $rouz=$shamsi[2];
       $tarikh_forush=$sal.'/'.$mah.'/'.$rouz;
	//مجموع مقدار ابطالی های این حواله فروش در سیستم فروش
	 $q_ebtalha="SELECT SUM(his_eb_amount) FROM dm_his_havale WHERE his_h_code=".$row1['h_code']." AND his_id_province='$sell_id_ostan' AND his_l_code='$sell_id_anbar' And his_id_year='$sellYearId'";	   
	 $res_ebtalha=mysql_query($q_ebtalha);
	 $row_ebtalha=mysql_fetch_array($res_ebtalha);
	 $meghdar_batele=$row_ebtalha[0];
  	 /**///محاسبه مقدار مانده از حواله فروش $mande_az_forush=$meghdar_havale_forush-$meghdar_tahvily-$meghdar_batele;
  }
 }
 //بدست آوردن نام مشتری
 $name_customer=customer($code_customer);//تابع 
 $db->selectDb($mydatabase);
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<form method="post" name="myform" onkeydown="enterIE()">
<div align="center">
<table width="99%" height="100%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr>';
  if(strlen($row1['code_ostan'])==1) $code_a=make_pattern($row1['code_ostan'],2);
  else $code_a=$row1['code_ostan'];
  echo' 
  <td class="title">حواله شماره '.$code_a.$row1['code_anbar'].$row1['shomare_havale_anbar'].'</td>	 
 </tr>
 <!--پايان هدر-->
 <!-- مرکز صفحه--> 
 <tr>
  <td height="100%">
   <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
    <img src="images/loading.gif" id="loading" class="loading_img"/>
	<tr class="tr1">';
	 if(SuperUser())echo '<td align="right">شناسه حواله : '.$row1['id'].'</td>';
     echo' 
	 <td colspan="3">
      <table border="0" width=100%>
	   <tr>
	    <td>'.$ebtal_message.'</td>';
        //اطلاعات لازم برای ابطال        
		$vazn_khales_h_=$db->get_from_where("SUM(vazn_khales_h_d)","havale_detail","shomare_havale_anbar=".$row1['shomare_havale_anbar']." AND code_ostan=".$row1['code_ostan']." AND code_anbar=".$row1['code_anbar']." AND year=".$row1['year']." AND havale_deleted=0 AND status=0");  	    
		$tedad_karton_h_=$db->get_from_where("SUM(tedad_karton_h_d)","havale_detail","shomare_havale_anbar=".$row1['shomare_havale_anbar']." AND code_ostan=".$row1['code_ostan']." AND code_anbar=".$row1['code_anbar']." AND year=".$row1['year']." AND havale_deleted=0 AND status=0");  	    
        if($_SESSION['mt_systemforush']==1) $idForush=$row_havale_forush['h_id'];
	    else $idForush=$row_havale_forush['id'];
		//اگر اجازه ابطال داشته و این حواله هنوز ابطال نشده است و سال فعال است و رسید متناظر ثبت نشده و سند حسابداری ثبت نشده است
	    
		IF(($right_ebtal)and($row1['status']==0)and(($exist_resid_motenazer_==0))and($_SESSION['mtStatusYear']==0)and($row1['set_sanad']==0)and($row1['noe_tahvil_bar']!=10)and($row1['javaz_ebtal']==1))		
		{
		  echo'<td align="left" width="40px"><input class="buttonme" type="button" name="ebtal_x" value="ابطال حواله" onClick="iconfirm(\''.$FileName.'?ebtal_x=1&id_='.$row1['id'].'&shomare_havale_anbar_='.$row1['shomare_havale_anbar'].'&noe_tahvil_bar_='.$row1['noe_tahvil_bar'].'&vazn_khales_h_='.$vazn_khales_h_.'&tedad_karton_h_='.$tedad_karton_h_.'&code_kala_='.$row1['code_kala'].'&code_bastebandy_='.$row1['code_bastebandy'].'&mande_az_forush_='.$row_havale_forush['mande_az_forush'].'&h_code_='.$row1['h_code'].'&idForush_='.$idForush.'&idJabejae_='.$row_jabejae['id'].'&shomare_jabejae_='.$row1['shomare_jabejae'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\',\'براي ابطال حواله '.$code_a.$row1['code_anbar'].$row1['shomare_havale_anbar'].' \')"/></td>
		       <td width="20px"><img border="0" src="images/button-cross_basic.png" width="20" height="20" /></td>';
		}	
	    ELSE IF($row1['status']==1) echo'<td style="font-weight:bold;color:red;">وضعیت این حواله : ابطالی</td>';
       	ELSE IF($row1['set_sanad']!=0)
		{
		  if($right_free_ebtal) echo'<td align="left" width="40px"><input type="button" class="buttonme" name="free_x" value="آزادکردن حواله" onClick="iconfirm(\''.$FileName.'?free_x=1&id_='.$row1['id'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\',\'حواله در سیستم مالی ثبت شده برای آزادکردن حواله '.$code_a.$row1['code_anbar'].$row1['shomare_havale_anbar'].' \')"/></td>';      
		  else echo'<td align="left"><span style="font-weight:bold;color:red;">حواله در سیستم مالی ثبت شده است اجازه ابطال وجود ندارد</span></td>';		   
		}
	   echo'	   
	   </tr>
	  </table>
	 </td>
	</tr>
	<tr class="tr1">
	 <td valign="top" width="30%">
	  <fieldset>
	   <legend> حواله سردخانه</legend>
       <table width=100% border="0" height="85px">
	    <tr>
		 <td align="left" width="150px"> شماره حواله سردخانه : </td>
	     <td align="right" width="160px"><input type="text" class="textboxme" readonly value="'.$row1['shomare_havale_anbar'].'" name="shomare_havale_anbar" style="width:50px;"/>&nbsp;/&nbsp;
		                  <input type="text" class="textboxme" readonly value="'.$code_a.$row1['code_anbar'].'" name="ostan_anbar" style="width:50px;"/>
		 </td>
		</tr>
        <tr>';
		//$detailresid=$db->get_from_where("count(*)","resid INNER JOIN resid_detail","code_ostan=".$row1['code_ostan']." AND code_anbar=".$row1['code_anbar']." AND year=".$row1['year']." AND tarikh_resid>".$row1['tarikh_havale_anbar']." AND code_kala=".$row1['code_kala']." AND code_keshvar=".$row1['code_keshvar']."");
		//اگر جزئیات دارد یا تاریخ حواله با تاریخ امروز یکی باشد
		//if(($detailcount>0)or($row1['tarikh_havale_anbar']==$today))echo'<td align="left" width="150px"><span class="star">*</span> تاريخ حواله سردخانه : </td><td align="right"><input type="text" value="'.$row1['tarikh_havale_anbar'].'" class="textboxme2" name="tarikh_havale_anbar" id="tarikh_havale_anbar"/></td>';
		////////change 1 shahrivar
		//if($detailcount==0)echo'<td align="left" width="150px"><span class="star">*</span> تاريخ حواله سردخانه : </td><td align="right"><input type="text" value="'.$row1['tarikh_havale_anbar'].'" class="textboxme2" name="tarikh_havale_anbar" id="tarikh_havale_anbar"/></td>';
		//else echo'<td align="left" width="150px"><span class="star">*</span> تاريخ حواله سردخانه : </td><td align="right"><input type="text" value="'.$row1['tarikh_havale_anbar'].'" class="textboxme2" name="tarikh_havale_anbar" readonly/></td>';
		echo'<td align="left" width="150px"><span class="star">*</span> تاريخ حواله سردخانه : </td><td align="right"><input type="text" value="'.$row1['tarikh_havale_anbar'].'" class="textboxme2" name="tarikh_havale_anbar"'; IF((SuperUser())AND($_SESSION["mtActiveYear"]==$yy)) echo'id="tarikh_havale_anbar"'; else echo'readonly';  echo'/></td>';
		echo'		
	    </tr>
	   </table>
	  </fieldset>
	 </td>
	 <td valign="top" width="35%">
	  <fieldset>
	  <legend>تحویل بار</legend>
       <table width=100% border="0" height="85px">
	    <tr>
		 <td align="center" colspan="2"><input type="checkbox" name="chk_recieve" disabled '; if($row1['chk_recieve']==1) echo 'checked';  echo' />
		 اصل حواله فروش/ مجوز جابه جایی دریافت شد</td>
		</tr>
		<tr>
		 <td align="left" width="130px"><span class="star">*</span> نوع تحویل بار : </td><td align="right">'.static_listbox("noe_tahvil_bar",$row1['noe_tahvil_bar'],"tahvilbarArr_h",1,"class='text4' disabled").'
		  <input type="hidden" name="noe_tahvil_bar_hide" id="noe_tahvil_bar_hide" value="'.$row1['noe_tahvil_bar'].'"/>
		 </td>
		</tr> 
	   </table>
	  </fieldset>
     </td>
	 <td valign="top" width="35%">
	  <fieldset>
	   <legend>اطلاعات تکمیلی</legend>
 	    <table width=100% border="0" height="85px">
	     <tr><td align="left">نوع بارگیری : </td><td align="right">'.listbox("code_bargiry",$row1['code_bargiry'],"code_takhlie","sharh_takhlie","takhlie","","class='text4'","").'</td>
		 <!--<tr><td align="left" width="90px">تاریخ گواهی بهداشتی :</td><td align="right" width="160px"><input type="text" class="textboxme2" maxlength="10" id="tarikh_govahi_behdashti" name="tarikh_govahi_behdashti" value="'.$row1['tarikh_govahi_behdashti'].'"/></td></tr>-->
	     <tr><td align="left" width="90px">شماره گواهی بهداشتی :</td><td align="right" width="160px"><input type="text" class="textboxme2" name="shomare_govahi_behdashti" value="'.$row1['shomare_govahi_behdashti'].'"/></td></tr>
		 <tr><td align="left">توضیحات :</td><td align="right"><input type="text" class="textboxme" name="tozihat" value="'.$row1['tozihat'].'"/></td></tr>
		</table> 
	  </fieldset>
	 </td>	 
	</tr>
	<tr class="tr1">
     <td valign="top" width="30%">
	  <fieldset>';
	    if(($row1['noe_tahvil_bar']==4)or($row1['noe_tahvil_bar']==5)or($row1['noe_tahvil_bar']==6)or($row1['noe_tahvil_bar']==7))
	    {echo'
	     <legend>مجوز جابه جایی</legend>
          <table width="100%" border="0" height="180px">		
	       <tr>
		    <td align="left"><span class="star">*</span> شماره مجوز جابه جایی  : </td>';
			if(($row1['sabt_nahayi']==0)and($detailcount==0)){$noe_tahvil_bar=$row1['noe_tahvil_bar'];echo'<td align="right"><input type="text" readonly class="textboxme2" name="shomare_jabejae" value="'.$row1['shomare_jabejae'].'" onfocus="getDetailJabejae(this.value,document.myform.noe_tahvil_bar_hide.value)" onchange="getDetailJabejae(this.value,document.myform.noe_tahvil_bar_hide.value)"/>';include ("img_helpjabejae.php");echo'</td>';}
			else echo'<td align="right"><input type="text" readonly class="textboxme2" name="shomare_jabejae" value="'.$row1['shomare_jabejae'].'" onblur="getDetailJabejae(this.value)" onkeypress="return isNumber(event)"/></td>';
		   echo'
		   </tr>
		   <tr><td align="left"> تاريخ مجوز جابه جایی : </td><td align="right"><input type="text" readonly class="textboxme2" name="tarikh_jabejae" value="'.$row_jabejae['tarikh_jabejae'].'" id="forush_jabejae_date"/></td></tr>';
	    }
        else 
	    {echo'
	     <legend>حواله فروش</legend>
          <table width="100%" border="0" height="180px">		
	       <tr>
		    <td align="left"><span class="star">*</span> شماره حواله فروش : </td>';
			if(($row1['sabt_nahayi']==0)and($detailcount==0)){echo'<td align="right"><input type="text" readonly class="textboxme2" name="h_code" value="'.$row1['h_code'].'" onfocus="getDetailForush(this.value)" onchange="getDetailForush(this.value)" onkeypress="return isNumber(event)"/>';include ("img_helphavaleforush.php");echo'</td>';}
			else echo'<td align="right"><input type="text" readonly class="textboxme2" name="h_code" value="'.$row1['h_code'].'" onblur="getDetailForush(this.value)" onkeypress="return isNumber(event)"/></td>';
		   echo'
		   </tr>
		   
		   <tr><td align="left"> تاريخ حواله فروش : </td><td align="right"><input type="text" readonly class="textboxme2" name="h_reg_date" value="'.$tarikh_forush.'" id="forush_jabejae_date"/></td></tr>';
	    }
	   echo'
	   </table>
	  </fieldset>  
	 </td>
	 <td width="35%" valign="top">
	  <fieldset>
	   <legend>اطلاعات</legend>
	   <table width="100%" height="180px">';
		 //اگر نوع تحویل  بار تحویل روباری باشد		
	     if($row1['noe_tahvil_bar']==2)echo'';
	     else echo'<tr><td align="left" class="robaryhide"><span class="star">*</span> شماره باسکول : </td><td align="right" class="robaryhide"><input '; IF($row1['sabt_nahayi']==1) echo'readonly'; echo' type="text" class="textboxme2" name="shomare_baskul_h" value="'.$row1['shomare_baskul_h'].'" onkeypress="return isNumber(event)"/></td></tr>';
		 echo'
		 <tr><td align="left"> شماره بارنامه : </td><td align="right"><input '; IF($row1['sabt_nahayi']==1) echo'readonly'; echo' type="text" class="textboxme2" name="shomare_barname_h" value="'.$row1['shomare_barname_h'].'"/></td></tr>
	     <tr><td align="left"> تاريخ بارنامه : </td><td align="right"><input '; IF($row1['sabt_nahayi']==1) echo'readonly'; ELSE echo' id="tarikh_barname_h"'; echo' type="text" class="textboxme2" maxlength="10" name="tarikh_barname_h" value="'.$row1['tarikh_barname_h'].'"/></td></tr>
	   	 <tr><td align="left">';
		 if($row1['noe_tahvil_bar']!=2)echo'<span class="star">*</span>';
		 echo'
		 پلاک خودرو : </td>
		  <td align="right">
		   <sup>ایران</sup>
		   <input '; IF($row1['sabt_nahayi']==1) echo'readonly'; echo' type="text" class="textboxme2" name="plak1" value="'.$row1['plak1'].'" onkeypress="return isNumber(event);" maxlength="2" style="width:20px;"/> |
		   <input '; IF($row1['sabt_nahayi']==1) echo'readonly'; echo' type="text" class="textboxme2" name="plak2" value="'.$row1['plak2'].'" onkeypress="return isNumber(event);" maxlength="3" style="width:30px;"/>
		   <input '; IF($row1['sabt_nahayi']==1) echo'readonly'; echo' type="text" class="textboxme2" name="plak3" value="'.$row1['plak3'].'" maxlength="1" style="width:20px;"/>
		   <input '; IF($row1['sabt_nahayi']==1) echo'readonly'; echo' type="text" class="textboxme2" name="plak4" value="'.$row1['plak4'].'" onkeypress="return isNumber(event);" maxlength="2" style="width:20px;"/>';		   
		   if($row1['shomare_kamiyon_h']) echo'<input type="text" class="textboxme2" name="shomare_kamiyon_h" value="'.$row1['shomare_kamiyon_h'].'" readonly style="width:70px"/>';
		   echo'
		  </td>
		 </tr> 
		 <tr><td align="left"> شماره پلمپ : </td><td align="right"><input type="text" class="textboxme2" name="shomare_polomp_h" value="'.$row1['shomare_polomp_h'].'"/></td></tr>
	     <tr><td align="left"> وضعیت پلمپ : </td><td align="right">'.static_listbox("vaziyat_polomp_h",$row1['vaziyat_polomp_h'],"polompArr",1,"class='text4'").'</td></tr>
	   </table>
	  </fieldset>
     </td>
	 <td width="35%" valign="top">';
	 if($row1['noe_tahvil_bar']==4)//جابه جایی بین مناطق
	 {echo'
	   <fieldset class="jabejaeshow">
	    <legend>اطلاعات استان مقصد</legend>
	    <table width=100% border="0" height="180px">
		 <tr><td align="left">نام استان مقصد : </td><td align="right"><input type="text" class="textboxme" readonly name="code_ostan_maghsad_j" id="code_ostan_maghsad_j" value="'.$row_jabejae['name_ostan'].'"/></td></tr>
		 <tr><td align="left">نام سردخانه مقصد : </td><td align="right"><input type="text" class="textboxme" readonly name="code_anbar_maghsad_j" id="code_anbar_maghsad_j" value="'.$row_jabejae['name_anbar'].'"/></td></tr>
	    </table>
	   </fieldset>';
	  }
	  else if($row1['noe_tahvil_bar']==6)//برگشت از خرید
	  {echo'
	   <fieldset class="j_show_marjoee">
	   <legend>اطلاعات کشتی / فروشنده</legend>
	   <table width=100% border="0" height="180px">
		<tr><td align="left">کد کشتی / فروشنده : </td><td align="right"><input type="text" class="textboxme" readonly name="code_skk" id="code_skk" value="'.$row_jabejae['code_skk'].'"/></td></tr>
		<tr><td align="left">نام کشتی / فروشنده : </td><td align="right"><input type="text" class="textboxme" readonly name="name_skk" id="name_skk" value="'.$row_jabejae['name_skk'].'"/></td></tr>
	   </table>
	   </fieldset>';
       } 
	   else
	   {
		echo'
	    <fieldset>
	     <legend>مشتری</legend>
	     <table  width="100%" height="180px">
	      <tr><td align="left" width="10%">کد مشتری : </td><td align="right" width="10%"><input type="text" readonly class="textboxme2" name="code_customer_edit" id="code_customer" value="'.$code_customer.'" style="width:50px;"/></td></tr>
	  	  <tr><td align="left" width="7%">نام مشتری : </td><td align="right" width="23%"><input type="text" readonly class="textboxme" name="name_customer" id="name_customer" value="'.$name_customer.'"/></td></tr>';
		  if($row1['noe_tahvil_bar']!=5)echo'<tr><td align="left">نام تحویل گیرنده : </td><td align="right"><input type="text" class="textboxme" readonly name="h_deli_name" id="h_deli_name" value="'.$h_deli_name.'"/></td></tr>';
	      echo'
		 </table>
	    </fieldset>';
	    }
	   echo'
     </td>
	</tr>
    <tr class="tr1">
	 <td colspan="3">
	  <fieldset>
	  <legend>اطلاعات کالا</legend>
	  <table width="99%" border="0">
	   <tr>
		<td align="left" width="140px"><span class="star">*</span> کد کالا : </td><td align="right"><input type="text" class="textboxme2" readonly name="code_kala" id="code_kala" value="'.$row1['code_kala'].'" style="width:50px"/></td>
		<td align="left">نام کالا : </td><td align="right"><input type="text" class="textboxme" readonly name="name_kala" id="name_kala" value="'.$row1['name_kala'].'" style="width:300px"/></td>
	    <td align="left">نوع بسته بندی : </td><td align="right"><input type="text" class="textboxme2" readonly name="sharh_bastebandy" id="sharh_bastebandy" value="'.$row1['sharh_bastebandy'].'"/></td>';
        if($row1['noe_tahvil_bar']==2)echo'';
		else echo'<td align="left" class="robaryhide" >نرخ بارگیری : </td><td align="right"><input type="text" class="textboxme2" readonly id="nerkh_bargiry_this" name="nerkh_bargiry_this" value="'.virgul($row1['nerkh_bargiry_this']).'"/></td>';
	   echo'
	   </tr>
	  </table>
      <table width="99%" style="border:1px solid #000">	  
	   <tr style="background-color:#A1dFF6;">
	    <td class="borderbottom" width="%" rowspan="2">زیرانبار</td>
	    <td class="borderbottom" width="%" rowspan="2">نام کشور</td>
	    <td class="borderbottom" width="%" rowspan="2">تولید کننده</td>
	    <td colspan="3">تاریخ تولید</td>
	    <td class="borderbottom" width="%" rowspan="2">تاریخ ماندگاری</td>';
		if($row1['code_bastebandy']==1)//بسته بندی کارتن
		{echo'
		 <td class="borderbottom" width="%" rowspan="2">کد کارتن</td>
		 <td class="borderbottom" width="%" rowspan="2">وزن کارتن</td>
		 <td class="borderbottom" width="%" rowspan="2">تعداد کارتن</td>';
		 if(($row1['code_kala']==50)or($row1['code_kala']==54))echo'<td class="borderbottom" width="%" rowspan="2">تعداد شانه</td>'; 
		 echo'
		 <td class="borderbottom" width="%" rowspan="2">مجموع وزن کارتن ها</td>
		 <td class="borderbottom" width="%" rowspan="2">وزن ناخالص</td>';
		}
		else if($row1['code_bastebandy']==2)//بسته بندی قوطی
		{echo'
		 <td class="borderbottom" width="%" rowspan="2">کد قوطی</td>
		 <td class="borderbottom" width="%" rowspan="2">وزن قوطی</td>
		 <td class="borderbottom" width="%" rowspan="2">تعداد قوطی</td>';
		}
		else //لاشه و سایر
		{echo'
		 <td class="borderbottom" width="%" rowspan="2">تعداد</td>';
		}
		echo'
	     <td class="borderbottom" width="%" rowspan="2">وزن خالص</td>
		</tr>
	    <tr style="background-color:#A1dFF6;">
		 <td class="borderbottom" width="%" >سال</td>
	     <td class="borderbottom" width="%" >ماه</td>
	     <td class="borderbottom" width="%" >روز</td>
	   </tr>';
	   $q_d="SELECT h_d.*,keshvar.code_keshvar,keshvar.name_keshvar,tolidkonande.code_tolidkonande,tolidkonande.name_tolidkonande,l_s_d.noe_ziranbar,l_s_d.name_ziranbar,karton.code_karton,karton.vazn_karton,sharh_mandegari From havale_detail h_d
         INNER JOIN keshvar ON h_d.code_keshvar=keshvar.code_keshvar
         LEFT JOIN karton ON h_d.code_karton=karton.code_karton
         INNER JOIN tolidkonande ON h_d.code_tolidkonande=tolidkonande.code_tolidkonande
         INNER JOIN list_sardkhane_detail l_s_d ON h_d.code_ziranbar=l_s_d.code_ziranbar AND h_d.code_ostan=l_s_d.code_ostan AND h_d.code_anbar=l_s_d.code_anbar  	  
	     INNER JOIN tarikh_mandegari ON tarikh_mandegari.code_mandegari=h_d.code_mandegari
		 WHERE h_d.shomare_havale_anbar='$shomare_havale_anbar_' AND h_d.code_ostan=$mt_gl_code_ostan AND h_d.code_anbar=$mt_gl_code_anbar AND h_d.year=$mtActiveYear AND havale_deleted=0";	
		$res_d=$db->query($q_d);
        $i=0;
		if(mysql_num_rows($res_d)>0)//اگر جزئیات کالا را پر کرده است
		{
		 while($row_d=$db->fetch_assoc($res_d))
	     {   
	      if($i++%2)echo'<tr style="background:#D0EAFF;">';
	      else echo'<tr style="background:#f6f9da;">';
	      echo'
	       <td>'.$row_d['name_ziranbar'].'</td>
	       <td>'.$row_d['name_keshvar'].'</td>
	       <td>'.$row_d['name_tolidkonande'].'</td>
	       <td>'.$row_d['sal_tolid_shamsi'].'</td>
	       <td>'.$mahshamsiArr[$row_d['mah_tolid_shamsi']].'</td>
		   <td>'.$row_d['rouz_tolid_shamsi'].'</td>
		   <td>'.$row_d['sharh_mandegari'].'</td>';
		   if(($row1['code_bastebandy']==1)OR($row1['code_bastebandy']==2))//
		   {echo'
		    <td>'.$row_d['code_karton'].'</td>
		    <td>'.$row_d['vazn_karton_this'].'</td>';
		   }
		   echo'<td>'.$row_d['tedad_karton_h_d'].'</td>';
		   if(($row1['code_kala']==50)or($row1['code_kala']==54))echo'<td>'.$row_d['tedad_shane_h_d'].'</td>'; 
		   if($row1['code_bastebandy']==1)//بسته بندی کارتن
		   {echo'
		    <td>'.round($row_d['sum_karton_h_d'],3).'</td>
		    <td>'.round($row_d['vazn_nakhales_h_d'],3).'</td>';
		   }
		   echo'<td>'.round($row_d['vazn_khales_h_d'],3).'</td>
	      </tr>';
		  //محاسبه مجموع در سطر آخرو داخل فیلد ها
		   $tedad_karton_h+=$row_d['tedad_karton_h_d'];
		   $tedad_shane_h+=$row_d['tedad_shane_h_d'];
		   //$vazn_karton_h+=$row_d['vazn_karton_this'];
		   $sum_karton_h+=$row_d['sum_karton_h_d'];
		   $vazn_nakhales_h+=$row_d['vazn_nakhales_h_d'];
		   $vazn_khales_h+=$row_d['vazn_khales_h_d'];
	     }
		 echo'
	      <tr style="background-color:#A1dFF6">
	       <td class="bordertop"';if($row1['code_bastebandy']==3) echo 'colspan="7"'; else echo' colspan="9"'; echo' >مجموع مقادیر</td>
	       <!--<td class="bordertop">'.$vazn_karton_h.'</td>-->
		   <td class="bordertop">'.$tedad_karton_h.'</td>';
		   if($row1['code_bastebandy']==1)//بسته بندی کارتن
		   {
			if(($row1['code_kala']==50)or($row1['code_kala']==54)) echo'<td class="bordertop">'.$tedad_shane_h.'</td>';
			echo'
	        <td class="bordertop">'.round($sum_karton_h,3).'</td>
	        <td class="bordertop">'.round($vazn_nakhales_h,3).'</td>';
		   }
		   echo'	
	       <td class="bordertop">'.round($vazn_khales_h,3).'</td>
	      </tr>';
		}
		else if($row1['status']==1){echo'<tr style="background:#f6f9da;"><td colspan="12" style="color:red">حواله ابطال شد</td></tr>';}
		else {echo'<tr style="background:#f6f9da;"><td><img border="0" src="images/info.gif"/></td><td colspan="11">لطفاً برای تکمیل حواله جزئیات کالا را تکمیل نمایید!</td></tr>';}
	   echo'
	  </table>
	  </fieldset>
	 </td>
	</tr>   
	<tr class="tr1">
	 <td colspan="" valign="top">
	  <fieldset>
	   <legend>وزن</legend>
	   <table width="100%"  height="155px">';
		//اگر نوع تحویل  بار تحویل روباری باشد
	    IF($row1['noe_tahvil_bar']==2)
		{
		 if($row1['code_bastebandy']==1)//بسته بندی کارتن
		 {echo'
	      <tr><td align="left"><span class="star">*</span> وزن ناخالص : </td><td align="right"><input type="text" class="textboxme2" readonly name="vazn_nakhales_h"  value="'.round($row1['vazn_nakhales_h'],3).'" onkeypress="return isNumber(event)"/></td></tr>
	      <tr><td align="left"><span class="star">*</span> تعداد کارتن : </td><td align="right"><input type="text" class="textboxme2" readonly name="tedad_karton_h"  value="'.$row1['tedad_karton_h'].'" onblur="return sumkarton(),vazn_khales()" onkeypress="return isNumber(event)"/></td></tr>
	      <tr><td align="left"><span class="star">*</span> مجموع وزن کارتن ها : </td><td align="right"><input type="text" class="textboxme2" readonly name="sum_karton_h" id="sum_karton_h" onblur="return vazn_khales()" value="'.round($sum_karton_h,3).'"/></td></tr>
	      <tr><td align="left"><span class="star">*</span> وزن خالص : </td><td align="right"><input type="text" class="textboxme2" readonly name="vazn_khales_h" value="'.round($row1['vazn_khales_h'],3).'"/></td></tr> 
		   <!--<tr><td align="left"><span class="star">*</span> وزن خالص : </td><td align="right"><input type="text" class="textboxme2" readonly name="vazn_khales_h" value="'.$vazn_khales_h.'"/></td></tr>-->';
	   	 }
		 else if($row1['code_bastebandy']==2)//بسته بندی قوطی
		 {echo'
	      <tr><td align="left"><span class="star">*</span> تعداد قوطی : </td><td align="right"><input type="text" class="textboxme2" readonly name="tedad_karton_h"  value="'.$row1['tedad_karton_h'].'" onblur="return sumkarton(),vazn_khales()" onkeypress="return isNumber(event)"/></td></tr>
	      <tr><td align="left"><span class="star">*</span> وزن خالص : </td><td align="right"><input type="text" class="textboxme2" readonly name="vazn_khales_h" value="'.round($row1['vazn_khales_h'],3).'"/></td></tr>'; 
	   	 }
		 else //لاشه و سایر
		 {echo'
	      <tr><td align="left"><span class="star">*</span> تعداد : </td><td align="right"><input type="text" class="textboxme2" readonly name="tedad_karton_h"  value="'.$row1['tedad_karton_h'].'" onblur="return sumkarton(),vazn_khales()" onkeypress="return isNumber(event)"/></td></tr>
	      <tr><td align="left"><span class="star">*</span> وزن خالص : </td><td align="right"><input type="text" class="textboxme2" readonly name="vazn_khales_h" value="'.round($row1['vazn_khales_h'],3).'"/></td></tr>'; 
	   	 }
		}
		ELSE//روباری نباشد
		{
		 echo'
		  <tr><td align="left"><span class="star">*</span> وزن کاميون با بار : </td><td align="right"><input ';IF($row1['sabt_nahayi']==1) echo 'readonly'; echo' type="text" class="textboxme2" name="vazn_kamiyon_bar_h" value="'.$row1['vazn_kamiyon_bar_h'].'" onkeypress="return isNumber(event)"/></td></tr>
	      <tr><td align="left"><span class="star">*</span> وزن کاميون : </td><td align="right"><input ';IF($row1['sabt_nahayi']==1) echo 'readonly'; echo' type="text" class="textboxme2" name="vazn_kamiyon_h" value="'.$row1['vazn_kamiyon_h'].'" onkeypress="return isNumber(event)"/></td></tr>';
		 IF($row1['code_bastebandy']==1)//بسته بندی کارتن
		 {
		  echo'
		  <tr><td align="left"><span class="star">*</span> وزن ناخالص : </td><td align="right"><input type="text" class="textboxme2" readonly name="vazn_nakhales_h"  value="'.round($row1['vazn_nakhales_h'],3).'" onkeypress="return isNumber(event)"/></td></tr>
	      <tr><td align="left"><span class="star">*</span> تعداد کارتن : </td><td align="right"><input type="text" class="textboxme2" readonly name="tedad_karton_h"  value="'.$row1['tedad_karton_h'].'" onblur="return sumkarton(),vazn_khales()" onkeypress="return isNumber(event)"/></td></tr>
	      <tr><td align="left"><span class="star">*</span> مجموع وزن کارتن ها : </td><td align="right"><input type="text" class="textboxme2" readonly name="sum_karton_h" id="sum_karton_h" onblur="return vazn_khales()" value="'.round($sum_karton_h,3).'"/></td></tr>
	      <tr><td align="left"><span class="star">*</span> وزن خالص : </td><td align="right"><input type="text" class="textboxme2" readonly name="vazn_khales_h" value="'.round($row1['vazn_khales_h'],3).'"/></td></tr>';  
		 }
		 ELSE IF($row1['code_bastebandy']==2)//بسته بندی قوطی
		 {echo'
	      <tr><td align="left"><span class="star">*</span> تعداد قوطی : </td><td align="right"><input type="text" class="textboxme2" readonly name="tedad_karton_h"  value="'.$row1['tedad_karton_h'].'" onblur="return sumkarton(),vazn_khales()" onkeypress="return isNumber(event)"/></td></tr>
	      <tr><td align="left"><span class="star">*</span> وزن خالص : </td><td align="right"><input type="text" class="textboxme2" readonly name="vazn_khales_h" value="'.round($row1['vazn_khales_h'],3).'"/></td></tr>';  
		 }
		 ELSE //لاشه و سایر
		 {
		  echo'
	      <tr><td align="left"><span class="star">*</span> تعداد : </td><td align="right"><input type="text" class="textboxme2" readonly name="tedad_karton_h"  value="'.$row1['tedad_karton_h'].'" onblur="return sumkarton(),vazn_khales()" onkeypress="return isNumber(event)"/></td></tr>
	      <tr><td align="left"><span class="star">*</span> وزن خالص : </td><td align="right"><input type="text" class="textboxme2" readonly name="vazn_khales_h" value="'.round($row1['vazn_khales_h'],3).'"/></td></tr>';  
		 }
		}
	    echo'
	   </table>
	  </fieldset>
     </td>
	 <td colspan="" valign="top">
	  <fieldset>
	   <legend>مقادیر</legend>';
	   if(($row1['noe_tahvil_bar']==4)or($row1['noe_tahvil_bar']==5)or($row1['noe_tahvil_bar']==7))//جابه جایی
	   {
	    
		echo'
	    <table width="100%" border="0"  height="155px" class="jabejaeshow">
	  	  <tr><td align="left" width="200px"><span class="star">*</span> مقدار مجوز جابه جایی : </td><td align="right"><input type="text" class="textboxme2" id="meghdar_jabejae" name="meghdar_jabejae" value="'.($row_jabejae['meghdar_jabejae']).'" readonly/>
		  <span name="rahnama" id="rahnama" class="rahnama">';
	      if($row1['code_bastebandy']==2)echo'(تعداد قوطی)';
		  else if(($row1['code_kala']==50)or($row1['code_kala']==54))echo'(تعداد شانه)';
		  else echo'(کیلوگرم)';
		  echo'
		    </span>
		   </td>
		  </tr>
	      <tr><td align="left">مقدار تحویلی  : </td><td align="right"><input type="text" class="textboxme2" readonly id="meghdar_tahvily_j" name="meghdar_tahvily_j" value="'.round($meghdar_tahvily_j,3).'"/></td></tr>
	  	        <!--<tr><td align="left">مقدار باطله : </td><td align="right"><input type="text" class="textboxme2" readonly id="meghdar_batele_j" name="maghadir_batele_j" value="'.($row1['meghdar_batele_j_this']).'"/></td></tr>
	                <tr><td align="left"> مقدار مانده از مجوز جابه جایی : </td><td align="right"><input type="text" class="textboxme2" id="mande_az_jabejae" name="mande_az_jabejae" value="'.($row1['mande_az_jabejae_this']).'" readonly/></td></tr>-->
	      <tr><td align="left">مقدار باطله : </td><td align="right"><input type="text" class="textboxme2" readonly id="meghdar_batele_j" name="maghadir_batele_j" value="'.round($maghadir_batele_j,3).'"/></td></tr>
		  <tr><td align="left"> مقدار مانده از مجوز جابه جایی : </td><td align="right"><input type="text" class="textboxme2" id="mande_az_jabejae" name="mande_az_jabejae" value="'.round($row_jabejae['mande_az_jabejae'],3).'" readonly/></td></tr>
	      <tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr>
		</table>';
	   }
       else
	   {
	    echo'
	    <table border="0" width="100%" height="155px">
	     <tr><td align="left"  width="200px">مقدار حواله فروش : </td><td align="right"><input type="text" class="textboxme2" readonly name="meghdar_havale_forush" id="meghdar_havale_forush" value="'.($meghdar_havale_forush).'"/>
		  <span name="rahnama" id="rahnama" class="rahnama">';
	      if($row1['code_bastebandy']==2)echo'(تعداد قوطی)';
		  else if(($row1['code_kala']==50)or($row1['code_kala']==54))echo'(تعداد شانه)';
		  else echo'(کیلوگرم)';
		  echo'
		  </span>
		  </td>
		 </tr>
		 <tr><td align="left">مقدار تحویلی از حواله فروش : </td><td align="right"><input type="text" class="textboxme2" readonly name="meghdar_tahvily" id="meghdar_tahvily" value="'.round($meghdar_tahvily,3).'"/></td></tr>
	     <tr><td align="left">مقدار باطله : </td><td align="right"><input type="text" class="textboxme2" readonly name="meghdar_batele" id="meghdar_batele" value="'.round($meghdar_batele,3).'"/></td></tr>
	     <tr><td align="left">مقدار مانده از حواله فروش : </td><td align="right"><input type="text" class="textboxme2" readonly id="mande_az_forush" name="mande_az_forush" value="'.round($mande_az_forush,3).'"/></td></tr>
	    	<tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr>
	    </table>';
	   }
	   echo'
      </fieldset>
	 </td>
	 <td colspan="" valign="top">
	  <fieldset>
	   <legend>هزینه ها</legend>
	   <table width="100%"  height="155px">
	    <tr>
		 <td align="left"><span class="star">*</span> نوع خودرو : </td>';
		 IF($row1['sabt_nahayi']==1)echo'<td align="right">'.static_listbox("noe_khodro",$row1['noe_khodro'],"khodroArr",1,"class='text4' disabled").'<input type="hidden" name="noe_khodro" value='.$row1['noe_khodro'].'></td>';
		 ELSE echo'<td align="right">'.static_listbox("noe_khodro",$row1['noe_khodro'],"khodroArr",1,"class='text4' onchange=getNerkhBaskul(this.value)").'</td>';
		echo'
		</tr>
	    <tr><td align="left">مبلغ باسکول : </td><td align="right"><input type="text" readonly class="textboxme2" id="mablagh_baskul" name="mablagh_baskul" value="'.virgul($row1['mablagh_baskul']).'"/></td></tr>';
	    //اگر نوع تحویل  بار تحویل روباری باشد
	    if($row1['noe_tahvil_bar']==2)echo'';
	    else  echo'<tr class="robaryhide"><td align="left" >هزینه بارگیری :</td><td align="right"><input type="text" readonly class="textboxme2" name="mablagh_bargiry" value="'.virgul($row1['mablagh_bargiry']).'"/></td></tr>';
	    echo'
	    <tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr>
	   </table>
	  </fieldset>
	 </td> 
	</tr>
   </table>
  </td>
 </tr> 
 <!--پايان مرکز صفحه -->
</table>
</div>
<!-- فوتر-->
<table style="position:fixed;bottom:-2px;left:0.5%" width="99%"> 
  <tr class="footer">';
   //اگر اجازه ویرایش دارد وحواله ابطالی نیست ووضعیت سال فعال است و حواله انبارگردانی نیست 
   //یا سوپریوزر است و حواله ابطالی نیست و ثبت نهایی نشده است   
   //یا سوپریوزر است و حواله ابطالی نیست و ثبت نهایی شده  ولی در وب سرویس ثبت نشده   
   //if((($right_edt)and($row1['status']==0)and($_SESSION['mtStatusYear']==0)and($exist_resid_motenazer_==0)and($row1['sabt_nahayi']==0)and($row1['noe_tahvil_bar']!=10))or((SuperUser())and($row1['status']==0)and($row1['sabt_nahayi']==0)and($row1['noe_tahvil_bar']!=10)and($exist_resid_motenazer_==0))or((SuperUser())and($row1['status']==0)and($row1['sabt_nahayi']==1)and($exist_resid_motenazer_==0)and(strlen($row1['webservice_trackcode'])!=25)and($row1['noe_tahvil_bar']!=10)))
   if((($_SESSION['mt_user_id']==74)and($right_edt)and($row1['status']==0)and($row1['noe_tahvil_bar']!=10))or(($right_edt)and($row1['status']==0)and($_SESSION['mtStatusYear']==0)and($row1['noe_tahvil_bar']!=10))or((SuperUser())and($row1['status']==0)and($row1['noe_tahvil_bar']!=10)))
   { echo'
	  <td align="center">
	   <input type="submit" class="buttonme" name="Edit_x" id="sabt" value="ثبت تغييرات">
   	   <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\'havale.php?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'">
	  </td>';
   }
   else echo'<td><div onClick="window.location=\'havale.php?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-back"  title="بازگشت" style="float:left;width:55%"><a href="#"  ></a></div></td> ';
  echo'   
  </tr>
</table>
<!-- پايان فوتر-->'; 
/**********اجازه براي ويرايش اطلاعات********/
function isPermitEdit($today,$mtStartDateSh,$ta_h,$n_tahvil,$h_code,$sh_j,$sh_baskul,$date_barname,$pl1,$pl2,$pl3,$pl4,$ta_forush,$ta_jabejae,$v_k_b,$v_k,$khodro,$gl_c_o,$gl_c_s,$gl_year,$this_id) 
{ 
 $flag=false;
 if(!($gl_c_o and $gl_c_s and $gl_year) or $gl_c_o==-1 or $gl_c_s==-1)//اگر سشن استان و انبار وسال خالی بود
 {   
   $flag=false;
   echo"<script> alert('لطفاً استان و انبار و سال مورد نظر خود را انتخاب نمایید!')</script>";
   return $flag;
 }
 else $flag=true;
 if(!($ta_h and $khodro))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script> alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!')</script>";
   return $flag;
 } 
 else $flag=true;
 if((($n_tahvil==1)or($n_tahvil==2)or($n_tahvil==3))and(!($h_code)))//پر بودن شماره حواله فروش در صورتیکه نوع تحویل جابهجایی نباشد
 {
   $flag=false;
   echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
   return $flag;
 } 
 else $flag=true;
 if((($n_tahvil==4)or($n_tahvil==5)or($n_tahvil==7))and(!($sh_j)))//پر بودن شماره جابه جایی در حالت جابه جایی
 {
   $flag=false;
   echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
   return $flag;
 } 
 else $flag=true;
 // if(($sh_baskul!='') and (!($pl1 and $pl2 and $pl3 and $pl4)))
 // {
   // $flag=false;
   // echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
   // return $flag;
 // } 
 // else $flag=true;
 if(($n_tahvil!=2) and ($sh_baskul!='') and (!($pl1 and $pl2 and $pl3 and $pl4 and $v_k_b and $v_k)))//پر بودن وزن کامیون با بار و وزن کامیون در صورتیکه نوع تحویل بار روباری نباشد
 {
   $flag=false;
   echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
   return $flag;
 } 
 else $flag=true;
 if((checkdatejalali($ta_h)==false)or($ta_h>$today)or($ta_h<$mtStartDateSh))//صحت فرمت تاریخ
 {
	$flag=false;
	echo"<script>window.alert('لطفا تاریخ را صحیح وارد نمایید!');</script>";
    return $flag;
 }
 else $flag=true;
 if(($date_barname)and((checkdatejalali($date_barname)==false) or ($date_barname>$ta_h)))//صحت فرمت تاریخ
 {
	$flag=false;
	echo"<script>window.alert('لطفا تاریخ بارنامه را صحیح وارد نمایید!');</script>";
    return $flag;
 }
 else $flag=true;
 //if((($sh_kamiyon)) and($n_tahvil!=2) and ($sh_baskul==''))//اگر شماره کامیون و یا وزن کامیون ها را زد 
 if((($pl1 and $pl2 and $pl3 and $pl4)) and($n_tahvil!=2) and ($sh_baskul==''))//اگر شماره کامیون و یا وزن کامیون ها را زد 
 {
   $flag=false;
   echo"<script>window.alert('لطفا شماره باسکول را وارد نمایید!');</script>";
   return $flag;
 } 
 else $flag=true;
 // if($sh_baskul!='0') 
 // {
  // if(($n_tahvil!=2) and (!($sh_baskul)))//پر بودن شماره باسکول در صورتیکه نوع تحویل بار روباری نباشد
  // {
   // $flag=false;
   // echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
   // return $flag;
  // } 
  // else $flag=true;
 // }
 // else $falg=true;
 //if(($sh_baskul!='0')and ($n_tahvil!=2))//تکراری نبودن شماره باسکول هم در رسید و هم در حواله به ازای هر انبار و هر سال 
 if(($sh_baskul)and ($n_tahvil!=2))//تکراری نبودن شماره باسکول هم در رسید و هم در حواله به ازای هر انبار و هر سال 
 { 
   $q_baskul_r="SELECT shomare_baskul FROM resid WHERE shomare_baskul='$sh_baskul' AND code_ostan='$gl_c_o' AND code_anbar='$gl_c_a' AND year='$gl_year' AND deleted=0 AND status=0";
   $q_baskul_h="SELECT shomare_baskul_h FROM havale WHERE shomare_baskul_h='$sh_baskul' AND code_ostan='$gl_c_o' AND code_anbar='$gl_c_a' AND year='$gl_year' AND deleted=0 AND status=0 AND id!=$this_id";
   $res_baskul_r=mysql_query($q_baskul_r);   
   $res_baskul_h=mysql_query($q_baskul_h);
   if((mysql_num_rows($res_baskul_r)>0)or(mysql_num_rows($res_baskul_h)>0))
   {
    echo"<script>alert('اين شماره باسکول قبلاً ثبت شده است !')</script>";
    $flag=false;
    return $flag;
   }
   else $flag=true;
 }
 else $flag=true;
 if((!empty($date_barname))and($date_barname<$ta_forush)) //تاریخ بارنامه
 {
   $flag=false;
   echo"<script>window.alert('تاریخ بارنامه نباید زودتر از تاریخ حواله فروش باشد !')</script>";
   return $flag;
 }
 else $flag=true;
 //پلاک خودرو
 //if(($sh_baskul!='')and((($pl1!=NULL)and(($pl2==NULL)or($pl3==NULL)or($pl4==NULL)))or(($pl2!=NULL)and(($pl1==NULL)or($pl3==NULL)or($pl4==NULL)))or(($pl3!=NULL)and(($pl1==NULL)or($pl2==NULL)or($pl4==NULL)))or(($pl4!=NULL)and(($pl1==NULL)or($pl2==NULL)or($pl3==NULL)))))
 if(((($pl1!=NULL)and(($pl2==NULL)or($pl3==NULL)or($pl4==NULL)))or(($pl2!=NULL)and(($pl1==NULL)or($pl3==NULL)or($pl4==NULL)))or(($pl3!=NULL)and(($pl1==NULL)or($pl2==NULL)or($pl4==NULL)))or(($pl4!=NULL)and(($pl1==NULL)or($pl2==NULL)or($pl3==NULL)))))
 {
   $flag=false;
   echo"<script>alert('پلاک خودرو نامعتبر است!')</script>";
   return $flag;
 }
 else $flag=true;  
 //if(($sh_baskul!='')and(($pl1!=NULL)and($pl2!=NULL)and($pl4!=NULL)and((((!justNumber($pl1))or(strlen($pl1)>2)or(strlen($pl1)<2)))or((((!justNumber($pl2)) or (strlen($pl2)>3) or (strlen($pl2)<3))))or((((!justNumber($pl4))or(strlen($pl4)>2)or(strlen($pl4)<2)))))))
 if(($pl1!=NULL)and($pl2!=NULL)and($pl4!=NULL)and((((!justNumber($pl1))or(strlen($pl1)>2)or(strlen($pl1)<2)))or((((!justNumber($pl2)) or (strlen($pl2)>3) or (strlen($pl2)<3))))or((((!justNumber($pl4))or(strlen($pl4)>2)or(strlen($pl4)<2))))))
 {
   $flag=false;
   echo"<script>alert('پلاک خودرو نامعتبر است !')</script>";
   return $flag;
 }
 else $flag=true;
 if(($pl3!=NULL)and((!validFarsi($pl3))))
 {
   $flag=false;
   echo"<script>alert('پلاک خودرو نامعتبر است!')</script>";
   return $flag;
 }
 else $flag=true;
 if($ta_h<$ta_forush)//تاریخ حواله فروش
 {
   $flag=false;
   echo"<script>window.alert('تاریخ حواله انبار قبل از تاریخ حواله فروش است امکان انتخاب این تاریخ نیست !')</script>";
   return $flag;
 }
 else $flag=true;
 if($ta_h<$ta_jabejae)//تاریخ مجوز جابه جایی
 {
   $flag=false;
   echo"<script>window.alert('تاریخ حواله انبار قبل از تاریخ مجوز جابه جایی است امکان انتخاب این تاریخ نیست !')</script>";
   return $flag;
 }
 else $flag=true;
return $flag;
}
/************EDIT BUTTON********/// اصلاح اطلاعات
if (isset($Edit_x))
{
  $plak1 = intval($plak1);//صفر اولش نباشد
  $plak2 = intval($plak2);
  $plak4 = intval($plak4);
  //echo "<script>alert($code_customer_edit)</script>";//چون محاسباتی است نام فیلدش را برای ثبت عوض کردم
  if($shomare_baskul_h==''){$plak1='';$plak2='';$plak3='';$plak4='';$vazn_kamiyon_bar_h='';$vazn_kamiyon_h='';}
  if(isPermitEdit($today,$mtStartDateSh,$tarikh_havale_anbar,$noe_tahvil_bar_hide,$h_code,$shomare_jabejae,$shomare_baskul_h,$tarikh_barname_h,$plak1,$plak2,$plak3,$plak4,$h_reg_date,$tarikh_jabejae,$vazn_kamiyon_bar_h,$vazn_kamiyon_h,$noe_khodro,$mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear,$id_))
  {
  // if(($plak1)and(!$plak2)and(!$plak3)and(!$plak4)) $plak1='';
  // if(($plak2)and(!$plak1)and(!$plak3)and(!$plak4)) $plak2='';
  // if(($plak3)and(!$plak1)and(!$plak2)and(!$plak4)) $plak3='';
  // if(($plak4)and(!$plak1)and(!$plak2)and(!$plak3)) $plak4=''; 
  if($shomare_polomp_h==NULL) $vaziyat_polomp_h='-1';//اگر شماره پلمپ را نزد وضعیت پلمپ هم خالی باشد
  $edit_q=("UPDATE $TableName SET tarikh_havale_anbar='$tarikh_havale_anbar',h_code='$h_code',shomare_jabejae='$shomare_jabejae',shomare_polomp_h='$shomare_polomp_h',vaziyat_polomp_h='$vaziyat_polomp_h',shomare_baskul_h='$shomare_baskul_h',
		   shomare_barname_h='$shomare_barname_h',tarikh_barname_h='$tarikh_barname_h',plak1='$plak1',plak2='$plak2',plak3='$plak3',plak4='$plak4',code_customer='$code_customer_edit',code_kala='$code_kala',vazn_kamiyon_bar_h='$vazn_kamiyon_bar_h',vazn_kamiyon_h='$vazn_kamiyon_h',noe_khodro='$noe_khodro',mablagh_baskul='$mablagh_baskul',shomare_govahi_behdashti='$shomare_govahi_behdashti',tarikh_govahi_behdashti='$tarikh_govahi_behdashti',code_bargiry='$code_bargiry',tozihat='$tozihat' WHERE id='$id_';");
  $edit_res=mysql_query($edit_q);
  if(($edit_res) and (mysql_affected_rows()!=0))
  {   
    $log_e=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_','ویرایش',".($yymmdd).",'$logtime')"); /*کوئری لاگ*/  
    echo "<script>window.location='havale.php?PageNo=".$PageNo."&RowPerPage=".$RowPerPage."&order=".$order."';</script>";
  }
   else if(mysql_affected_rows()==0)  $message ='';
   else $message ='<span style=" color:red;font: bold 12px tahoma;"> * مشکلی در ویرایش مشخصات به وجود آمده است ! *</span>';   
 }
}
/*******************END***************/		
echo'
'.$message.'
<br/>
<br/>
</form>
</body>
</html>';
?>