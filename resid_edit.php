<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="resid_edit.php";
$TableName="resid";
$today=AsLDate($yymmdd);
$right_edt=0;$right_ebtal=0;$right_free_ebtal=0;
if (right(157)) $right_edt=1;
if (right(160)) $right_ebtal=1;
if (right(601)) $right_free_ebtal=1;
$titr='ویرایش رسید';
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
    $(".datepicker6,#datepicker5").datepicker({
        showOn: "button",
        buttonImage: "styles/images/calendar5.png",
        buttonImageOnly: true,
		showButtonPanel: true
    });
 });
function enterIE()
{
   if(window.event.keyCode == 13 && window.event.srcElement.id !=\'sabt\')
   window.event.keyCode = 9;
}
function getDetailKala2(code_kala)<!--اطلاعات کالا-->
{ 
    $("#loading").fadeIn("fast");
    $.post("ajax_resid.php",{codeKALA2:code_kala},function(data){			 		 
			  var splKala = data.split("^");
			  $("#name_kala").val(splKala[0]);
			  $("#sharh_bastebandy").val(splKala[2]);
			  $("#mojody").val(splKala[3]);
			  $("#id_gheymat_this").val(splKala[4]);
			  $("#fee_this").val(splKala[5]);
			  $("#zarib_this").val(splKala[6]);
			  $("#nerkh_takhlie_this").val(splKala[7]);
		 });
    $("#loading").fadeOut("fast");
}
<!-- نوع پرداخت-->
 $( document ).ready(function() {
 $("[name=noe_pardakht]").bind("change", function () {
    if($(this).val() == 2) {
       $("#paskeraye").slideDown("slow");
    } else {
       $("#paskeraye").slideUp("slow");
    }
 });

  $("#show_detail").bind("click", function () {
       $("#detail").slideDown("slow");});
 }); 
<!--با انتخاب نوع تحویل اطلاعات عوض شود--><!--در حالت ویرایش-->
function getInfo(noe_tahvil)
{
  $("#loading").fadeIn("fast");  
  $.post("ajax_resid.php",{noeTAHVIL:noe_tahvil},function(data){$("#info").html(data);});
  $("#loading").fadeOut("fast");		
}
<!-- تعویض اطلاعات شماره سفر با انتخاب کشتی--><!--همراه با نام کشتی-->
function getShomareSafar(code_skk)
{
  $("#loading").fadeIn("fast");  
  $.post("ajax_resid.php",{codeKESHTY:code_skk},function(data)
  {
   var spl = data.split("^");
   $("#name_skk").val(spl[0]);
   $("[name=id_safar]").html(spl[1]);
  });
  $("#loading").fadeOut("fast");		
}
<!-- پیمانکار حمل-->
function getNamePeymankar(code_peyman)
{
  $("#loading").fadeIn("fast");  
  $.post("ajax_resid.php",{codePEYMAN:code_peyman},function(data)
  {
   $("[name=name_peymankar_haml]").val(data);
  });
  $("#loading").fadeOut("fast");		
}
<!-- مبادی ورودی-->
function getNameBargiry(code_mabda_vorudy)
{
  $("#loading").fadeIn("fast");  
  $.post("ajax_resid.php",{codeMABDA_V:code_mabda_vorudy},function(data)
  {
   $("[name=name_mabda]").val(data);
  });
  $("#loading").fadeOut("fast");		
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
<!-- تعویض انبار با انتخاب استان-->
function getAnbareOstan(code_ostan)
{
  $("#loading").fadeIn("fast");  
  $.post("ajax_resid.php",{codeOSTAN1:code_ostan},function(data){$("[name=code_anbar_mabda]").html(data);});
  $("#loading").fadeOut("fast");		
}
<!--محاسبه کسری مجاز-->
function mojaz()
{
 var natije_mojaz;
 natije_mojaz=parseFloat((document.myform.vazn_mabda_r.value)*((document.myform.zarib_this.value)/1000)).toFixed(2);                                       
 document.myform.kasry_mojaz_r.value=natije_mojaz;
 return natije_mojaz;
}
function vazn()<!--وزن خالص و مبلغ تخلیه-->
{
 var natije_vazn,natije_mablaghT;
 document.myform.vazn_khales_r.value=Number(document.myform.vazn_kamiyon_bar.value)-Number(document.myform.vazn_kamiyon.value);                                       
 natije_vazn=document.myform.vazn_khales_r.value;
 document.myform.mablagh_takhlie.value=(natije_vazn)*(Number(document.myform.nerkh_takhlie_this.value));                                       
 natije_mablaghT=document.myform.mablagh_takhlie.value;
 return natije_vazn,natije_mablaghT;
} 
function baskul(vazn_khales_r)<!--نرخ باسکول--><!--dont use-->
{
	$("#loading").fadeIn("fast");
    $.post("ajax.php",{vaznKHALES:vazn_khales_r},function(data){$("#nerkh_baskul_this").val(data);});
    $("#loading").fadeOut("fast");
}
function mablaghbaskul()<!--محاسبه مبلغ باسکول-->
{
 var natije_vazn,natije_mablaghB;
 document.myform.vazn_khales_r.value=Number(document.myform.vazn_kamiyon_bar.value)-Number(document.myform.vazn_kamiyon.value);                                        
 natije_vazn=document.myform.vazn_khales_r.value;
 document.myform.mablagh_baskul.value=(natije_vazn)*Number(document.myform.nerkh_baskul_this.value);                                       
 natije_mablaghB=document.myform.mablagh_baskul.value;
 return natije_mablaghB;
}
function maghadir()
{
 var natije_kasry_kol,natije_vazn_ezafe,natije_kasry_gheyrmojaz,natije_jarime,natije_mablagh_ezafe;
 document.myform.kasry_kol.value=Number(document.myform.vazn_mabda_r.value)-Number(document.myform.vazn_khales_r.value);                                      							
 if(document.myform.kasry_kol.value<0){document.myform.kasry_kol.value=0;}
 document.myform.vazn_ezafe.value=Number(document.myform.vazn_khales_r.value)-Number(document.myform.vazn_mabda_r.value);                                      							
 if(document.myform.vazn_ezafe.value<0){document.myform.vazn_ezafe.value=0;}
 document.myform.kasry_gheyremojaz.value=Number(document.myform.kasry_kol.value)-Number(document.myform.kasry_mojaz_r.value);                                      							
 if(document.myform.kasry_gheyremojaz.value<0){document.myform.kasry_gheyremojaz.value=0;}
 document.myform.mablagh_jarimekasry.value=Number(document.myform.kasry_gheyremojaz.value)*Number(document.myform.fee_this.value);                                      							
 natije_kasry_kol=document.myform.kasry_kol.value;
 natije_vazn_ezafe=document.myform.vazn_ezafe.value;
 natije_kasry_gheyrmojaz=document.myform.kasry_gheyremojaz.value;
 natije_jarime=document.myform.kasry_gheyremojaz.value;
 return natije_kasry_kol,natije_vazn_ezafe,natije_kasry_gheyrmojaz,natije_jarime,natije_mablagh_ezafe;
}
function pardakhty()<!--محسابه مقدار پرداختی--><!--change-->
{
 var natije_mablagh;
 natije_mablagh=Number(document.myform.mablagh_kerayemabda.value)+Number(document.myform.mablagh_haghetavaghof.value);
 if(natije_mablagh<0) natije_mablagh=0;
 document.myform.mablagh_pardakhty.value=natije_mablagh;
}
</script>
</head>';
if(!(isset($Mode))) $Mode='';
/************FREE BUTTON********/// آزادکردن 
if (isset($free_x))
{
 	$free_q ="UPDATE $TableName SET set_sanad=0 WHERE id=$id_"; 
    $free_res = mysql_query($free_q);
    /*log*/$log_d=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_','آزاد کردن رسید جهت ابطال',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')");
 	if($free_res and $log_d) 
	 echo "<script>window.location='resid.php?PageNo=".$PageNo."&RowPerPage=".$RowPerPage."&order=".$order."';</script>";   
   	
}
/****************************************/
function isPermitEbtal($sh_r,$gl_c_o,$gl_c_s,$gl_year,$PageNo,$RowPerPage,$order,$id_safar_,$sum_meghdar_pardakhti,$after_ebtal,$noe_tahvil_bar_) 
{
  $flag=false;
  $q="SELECT count(*) FROM resid_kala_detail WHERE shomare_resid='".$sh_r."' AND code_ostan='$gl_c_o' AND code_anbar='$gl_c_s' AND year='$gl_year'";
  $res=mysql_query($q);
  $row=mysql_fetch_array($res);
  $exist_kala_detail=$row[0];
  if($exist_kala_detail)
  {
   //بررسی موجودی کالا برای تک تک کالاهای این رسید درresid_kala_detail
   $q_kala_detail="SELECT * from resid_kala_detail WHERE shomare_resid='$sh_r' AND code_ostan=$gl_c_o AND code_anbar=$gl_c_s AND year=$gl_year";       
   $res_kala_detail=mysql_query($q_kala_detail);
   while($row_k_d=mysql_fetch_assoc($res_kala_detail))
   {
	 //خواندن موجودی با استفاده از تابع 
      IF($noe_tahvil_bar_==9)
	  {
	   $tedad_again=mojodyKarton($gl_c_o,$gl_c_s,$gl_year,$row_k_d['code_ziranbar'],$row_k_d['code_kala'],$row_k_d['code_keshvar'],$row_k_d['code_tolidkonande'],$row_k_d['sal_tolid_shamsi'],$row_k_d['mah_tolid_shamsi'],$row_k_d['rouz_tolid_shamsi'],$row_k_d['code_karton'],$row_k_d['code_mandegari'],2);
       $mojody_nakhales_again=mojodyNakhales($gl_c_o,$gl_c_s,$gl_year,$row_k_d['code_ziranbar'],$row_k_d['code_kala'],$row_k_d['code_keshvar'],$row_k_d['code_tolidkonande'],$row_k_d['sal_tolid_shamsi'],$row_k_d['mah_tolid_shamsi'],$row_k_d['rouz_tolid_shamsi'],$row_k_d['code_karton'],$row_k_d['code_mandegari'],2);
       $mojody_khales_again=mojodyKhales($gl_c_o,$gl_c_s,$gl_year,$row_k_d['code_ziranbar'],$row_k_d['code_kala'],$row_k_d['code_keshvar'],$row_k_d['code_tolidkonande'],$row_k_d['sal_tolid_shamsi'],$row_k_d['mah_tolid_shamsi'],$row_k_d['rouz_tolid_shamsi'],$row_k_d['code_karton'],$row_k_d['code_mandegari'],2);
	  }
      ELSE	
	  {		  
	   $tedad_again=mojodyKarton($gl_c_o,$gl_c_s,$gl_year,$row_k_d['code_ziranbar'],$row_k_d['code_kala'],$row_k_d['code_keshvar'],$row_k_d['code_tolidkonande'],$row_k_d['sal_tolid_shamsi'],$row_k_d['mah_tolid_shamsi'],$row_k_d['rouz_tolid_shamsi'],$row_k_d['code_karton'],$row_k_d['code_mandegari']);
       $mojody_nakhales_again=mojodyNakhales($gl_c_o,$gl_c_s,$gl_year,$row_k_d['code_ziranbar'],$row_k_d['code_kala'],$row_k_d['code_keshvar'],$row_k_d['code_tolidkonande'],$row_k_d['sal_tolid_shamsi'],$row_k_d['mah_tolid_shamsi'],$row_k_d['rouz_tolid_shamsi'],$row_k_d['code_karton'],$row_k_d['code_mandegari']);
       $mojody_khales_again=mojodyKhales($gl_c_o,$gl_c_s,$gl_year,$row_k_d['code_ziranbar'],$row_k_d['code_kala'],$row_k_d['code_keshvar'],$row_k_d['code_tolidkonande'],$row_k_d['sal_tolid_shamsi'],$row_k_d['mah_tolid_shamsi'],$row_k_d['rouz_tolid_shamsi'],$row_k_d['code_karton'],$row_k_d['code_mandegari']);
	  }
	  $mojody_nakhales_again=round($mojody_nakhales_again,3);
	  $mojody_khales_again=round($mojody_khales_again,3);
	  $tedad_after_ebtal=$tedad_again-$row_k_d['tedad_karton_r_d_sub'];
	  $nakhales_after_ebtal=$mojody_nakhales_again-$row_k_d['vazn_nakhales_r_d_sub'];
	  $khales_after_ebtal=$mojody_khales_again-$row_k_d['vazn_khales_r_d_sub'];
	  
	  //if(($tedad_again<$row_k_d['tedad_karton_r_d_sub'])or($mojody_nakhales_again<$row_k_d['vazn_nakhales_r_d_sub'])or($mojody_khales_again<$row_k_d['vazn_khales_r_d_sub']))//کافی نبودن موجودی   
	  if(($tedad_after_ebtal<0)or($nakhales_after_ebtal<0)or($khales_after_ebtal<0))//کافی نبودن موجودی   
      {
	    echo "<script>alert('* موجودی کالا در صورت ابطال رسید منفی می شود ، امکان ابطال وجود ندارد ! *')</script>";
 	    echo "<script>window.location='resid.php?PageNo=".$PageNo."&RowPerPage=".$RowPerPage."&order=".$order."';</script>";   
        $flag=false;
		return $flag;
	  }
	  else $flag=true;
   }
   return $flag;
 }
 else $flag=true;
 // IF(($after_ebtal<$sum_meghdar_pardakhti))
 // {
	// echo "<script>alert('* امکان حذف رسید وجود ندارد! برای شماره قرارداد مندرج در این رسید پرداختی به مشتر ی ثبت شده است *')</script>";
 	// echo "<script>window.location='resid.php?PageNo=".$PageNo."&RowPerPage=".$RowPerPage."&order=".$order."';</script>";   
    // $flag=false;
    // return $flag;
 // }
 // ELSE $flag=true;	 
 return $flag;
}
/************EBTAL BUTTON********/// ابطال 
if (isset($ebtal_x))
{
  //انتخاب جدول موجودی
   IF($noe_tahvil_bar_==9)$TableMojody='mojody_kala_gomrok';
   ELSE                   $TableMojody='mojody_kala';
	
  IF($id_safar_>0)
  {   
    $shomare_gharardad=$db->get_from_where("shomare_safar","shomare_safar","id_safar=".$id_safar_." AND code_ostan=".$mt_gl_code_ostan."");     
    $id_gharardad=$db->get_from_where("id_gharardad","gharardad_kharid","shomare_gharardad='".$shomare_gharardad."' AND code_ostan=".$mt_gl_code_ostan." AND deleted=0");     
    $sum_meghdar_pardakhti=$db->get_from_where("SUM(meghdar)","pardakht_gharardad","id_gharardad='".$id_gharardad."' AND pardakht_type=1 AND deleted=0");     
    $sum_tahvily_resid=$db->get_from_where("SUM(vazn_khales_r)","resid","id_safar=".$id_safar_." AND deleted=0 AND status=0 AND sabt_nahayi=1");     
    $after_ebtal=$sum_tahvily_resid-$vazn_khales_r_;
	IF(($after_ebtal<$sum_meghdar_pardakhti))
    {
	 //echo "<script>alert('$sum_meghdar_pardakhti')</script>";
     //echo "<script>alert('$after_ebtal')</script>";
	 echo "<script>alert('* امکان حذف رسید وجود ندارد! برای شماره قرارداد مندرج در این رسید پرداختی به مشتر ی ثبت شده است *')</script>";
 	 echo "<script>window.location='resid.php?PageNo=".$PageNo."&RowPerPage=".$RowPerPage."&order=".$order."';</script>";    
    }
  }  
  if(isPermitEbtal($shomare_resid_,$mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear,$PageNo,$RowPerPage,$order,$id_safar_,$sum_meghdar_pardakhti,$after_ebtal,$noe_tahvil_bar_))
  {  
   // $ebtal_r_q="UPDATE $TableName T,resid_detail r_d,resid_kala_detail r_k_d SET T.status=1,r_d.status=1,r_k_d.status=1
               // WHERE 
	           // T.shomare_resid=r_d.shomare_resid AND T.shomare_resid=r_k_d.shomare_resid AND
	           // T.code_ostan=r_d.code_ostan AND T.code_ostan=r_k_d.code_ostan AND
	           // T.code_anbar=r_d.code_anbar AND T.code_anbar=r_k_d.code_anbar AND
	           // T.year=r_d.year AND T.year=r_k_d.year AND
	           // T.shomare_resid='$shomare_resid_' AND T.code_ostan='$mt_gl_code_ostan' AND T.code_anbar='$mt_gl_code_anbar' AND T.year='$mtActiveYear'";
   mysql_query('SET AUTOCOMMIT=0');//TRANSACTIONشروع 
   mysql_query('START TRANSACTION');
   $register_error_code=$db->get_from_where("register_error_code","list_sardkhane","code_ostan=".$mt_gl_code_ostan." AND code_anbar=".$mt_gl_code_anbar."");     
   //$webservice_JahadTracking=$db->get_from_where("webservice_JahadTracking","resid","id=$id_");
   $wb_id=$db->get_from_where("wb_id","$TableName","id=$id_ AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar'");    
   $revokeTime = date('H:i');
   $ebtal_r_q ="UPDATE $TableName SET status=1,revokeDate='$today',revokeTime='$revokeTime' WHERE id=$id_";
   $ebtal_res=mysql_query($ebtal_r_q);
   /*log*/$log_d=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_','ابطال رسید',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')");
   $exist_detail=$db->get_from_where("count(*)","resid_detail","shomare_resid='".$shomare_resid_."' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear'");
   if($exist_detail)
   {$ebtal_q_d ="UPDATE resid_detail SET status=1 WHERE shomare_resid='".$shomare_resid_."' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear'";
    $ebtal_res_d=mysql_query($ebtal_q_d);}
   $exist_kala_detail=$db->get_from_where("count(*)","resid_kala_detail","shomare_resid='".$shomare_resid_."' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear'");
   if($exist_kala_detail)
   {$ebtal_q_d2 ="UPDATE resid_kala_detail SET status=1 WHERE shomare_resid='".$shomare_resid_."' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear'";
    $ebtal_res_d2=mysql_query($ebtal_q_d2);	  

	     /*resid_detail_kala خواندن اطلاعات*/
	     $q="SELECT * from resid_kala_detail WHERE shomare_resid='$shomare_resid_' AND code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND year=$mtActiveYear";       
	     $res=mysql_query($q);
         while($row=mysql_fetch_assoc($res))
	     {
	      /*resid_detail خواندن*/
           //$q_detail="SELECT vazn_karton_this FROM resid_detail WHERE shomare_resid='$shomare_resid_' AND code_kala=".$row['code_kala']." AND code_keshvar=".$row['code_keshvar']." AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear'";	
	   	   //$all_detail = $db->query($q_detail);
           //$row_detail=$db->fetch_assoc($all_detail);
	       //خواندن موجودی با استفاده از تابع 
           IF($noe_tahvil_bar_==9)
	       {
		    $update_tedad_karton=mojodyKarton($row['code_ostan'],$row['code_anbar'],$row['year'],$row['code_ziranbar'],$row['code_kala'],$row['code_keshvar'],$row['code_tolidkonande'],$row['sal_tolid_shamsi'],$row['mah_tolid_shamsi'],$row['rouz_tolid_shamsi'],$row['code_karton'],$row['code_mandegari'],2);
            $update_mojody_nakhales=mojodyNakhales($row['code_ostan'],$row['code_anbar'],$row['year'],$row['code_ziranbar'],$row['code_kala'],$row['code_keshvar'],$row['code_tolidkonande'],$row['sal_tolid_shamsi'],$row['mah_tolid_shamsi'],$row['rouz_tolid_shamsi'],$row['code_karton'],$row['code_mandegari'],2);
            $update_mojody_khales=mojodyKhales($row['code_ostan'],$row['code_anbar'],$row['year'],$row['code_ziranbar'],$row['code_kala'],$row['code_keshvar'],$row['code_tolidkonande'],$row['sal_tolid_shamsi'],$row['mah_tolid_shamsi'],$row['rouz_tolid_shamsi'],$row['code_karton'],$row['code_mandegari'],2);	 
	       }
		   ELSE
		   {
		   	$update_tedad_karton=mojodyKarton($row['code_ostan'],$row['code_anbar'],$row['year'],$row['code_ziranbar'],$row['code_kala'],$row['code_keshvar'],$row['code_tolidkonande'],$row['sal_tolid_shamsi'],$row['mah_tolid_shamsi'],$row['rouz_tolid_shamsi'],$row['code_karton'],$row['code_mandegari']);
            $update_mojody_nakhales=mojodyNakhales($row['code_ostan'],$row['code_anbar'],$row['year'],$row['code_ziranbar'],$row['code_kala'],$row['code_keshvar'],$row['code_tolidkonande'],$row['sal_tolid_shamsi'],$row['mah_tolid_shamsi'],$row['rouz_tolid_shamsi'],$row['code_karton'],$row['code_mandegari']);
            $update_mojody_khales=mojodyKhales($row['code_ostan'],$row['code_anbar'],$row['year'],$row['code_ziranbar'],$row['code_kala'],$row['code_keshvar'],$row['code_tolidkonande'],$row['sal_tolid_shamsi'],$row['mah_tolid_shamsi'],$row['rouz_tolid_shamsi'],$row['code_karton'],$row['code_mandegari']);	 
	       }
		   IF ($row['code_kala']==50)$update_tedad_shane=$update_tedad_karton*$_SESSION["mtShane"]; 
	       ELSE IF ($row['code_kala']==54)$update_tedad_shane=$update_tedad_karton*$_SESSION["mtShane_dakheli"];
		   ELSE $update_tedad_shane=0; 
		  //خواندن موجودی  
	   	   // $q_m="SELECT id from mojody_kala WHERE code_ziranbar=".$row['code_ziranbar']." AND code_kala=".$row['code_kala']." AND code_keshvar=".$row['code_keshvar']." AND code_tolidkonande=".$row['code_tolidkonande']." AND sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND code_karton=".$row['code_karton']." AND code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND year=$mtActiveYear AND deleted=0";       
	   	   // $res_m=mysql_query($q_m);
           // $row_m=mysql_fetch_assoc($res_m);   
	     //آپدیت موجودی کالا در جدول موجودی کالا
           // $update_mojody_nakhales=$row_m['mojody_nakhales']-$row['vazn_nakhales_r_d_sub'];//آپدیت موجودی ناخالص کالا در جدول موجودی کالا   
	   	   // $update_mojody_khales=$row_m['mojody_khales']-$row['vazn_khales_r_d_sub'];//آپدیت موجودی خالص کالا در جدول موجودی کالا
       	   // $update_tedad_karton=$row_m['tedad_karton']-$row['tedad_karton_r_d_sub'];//آپدیت تعداد کارتن های موجود در انبار
		   $update_mojody_res=$db->query("UPDATE $TableMojody SET mojody_khales=$update_mojody_khales,mojody_nakhales=$update_mojody_nakhales,tedad_karton=$update_tedad_karton,tedad_shane=$update_tedad_shane WHERE code_ziranbar=".$row['code_ziranbar']." AND code_kala=".$row['code_kala']." AND code_keshvar=".$row['code_keshvar']." AND code_tolidkonande=".$row['code_tolidkonande']." AND sal_tolid_shamsi=".$row['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row['rouz_tolid_shamsi']." AND code_karton=".$row['code_karton']." AND code_mandegari='".$row['code_mandegari']."' AND code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND year=$mtActiveYear AND deleted=0");      	 
	    /*لاگ موجودی*/$log_m_d=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','mojody_kala',".$row_m['id'].",'ابطال رسید انبار و برگشت موجودی',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')");
	    }
	}
   //if($ebtal_res and $log_d and $ebtal_res_d and $ebtal_res_d2 and $update_mojody_res and $log_m_d)
   if($ebtal_res and $log_d)
   {
	 /********************WEB SERVICE NEW***********************/
	 if(($_SESSION['mt_webservice']==1)AND($register_error_code==0)AND($wb_id>0)AND($exist_kala_detail))//اتصال به وب سرویس
     {
	  $params=array('id'=>$wb_id);
	  $encodedData = json_encode($params);
	  $curl = curl_init();
      curl_setopt_array($curl, array(
       CURLOPT_URL => 'http://10.7.234.33/warehouse/api/warehouse/ReceiptRevoke',
       CURLOPT_USERPWD => 'ajix_agridam:3rt67HM',
	   CURLOPT_RETURNTRANSFER => true,
       CURLOPT_ENCODING => '',
       CURLOPT_MAXREDIRS => 10,
       CURLOPT_TIMEOUT => 0,
       CURLOPT_FOLLOWLOCATION => true,
       CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
       CURLOPT_CUSTOMREQUEST => 'POST',
       CURLOPT_POSTFIELDS =>$encodedData,
	   // CURLOPT_POSTFIELDS =>'{
       // "id":24878897516399
       // }',
       CURLOPT_HTTPHEADER => array(
        'Authorization: Basic YWppeF9hZ3JpZGFtOjNydDY3SE0=',
        'Content-Type: application/json'
       ),
      ));

      $response = curl_exec($curl);
	  $response = str_replace(array("\"{\"","\"}\""),array("'{\"","\"}'")
		             ,str_replace(array('\"',"\\\\","'"),array('"',"\\")
			 	     ,preg_replace("/\\\\u([a-f0-9]{4})/e", "iconv('UCS-4LE','UTF-8',pack('V', hexdec('U$1')))",json_decode($response))));

	  $object=json_decode($response);      # آبجکت
	  $wb_revoke_error_code =$object->error_code;
	  $wb_revoke_error_message =$object->error_message;
	  if(curl_exec($ch) === false)
      {
           //echo 'Curl error: ' . curl_error($ch);
		    echo "<script>alert('Curl error: ' . curl_error($ch)')</script>";
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
		     echo "<script>alert('ابطال رسید در وب سرویس به ثبت رسید')</script>";
           }
	       $update_track=("UPDATE resid SET wb_revoke_error_code='$wb_revoke_error_code',wb_revoke_error_message='$wb_revoke_error_message' WHERE id=$id_");
	       $update_res=mysql_query($update_track);
	   }
	   curl_close($curl);
	 }
	 //////////////////////////////////SECONDE TIME version//////////////////////////////////////////////
	 // if(($_SESSION['mt_webservice']==1)AND($register_error_code==0)AND($webservice_JahadTracking>0)AND($exist_kala_detail))//اتصال به وب سرویس
	 // {
	   // $wsdl_url='http://10.7.234.33/anbar/warehouse.asmx?wsdl';
	   // header('Content-Type: text/html; charset=utf-8');
       // try
	   // {
	    // $client=new SoapClient($wsdl_url);
        // $params=array(
		  // 'username'=>'02',
          // 'password'=>'HJ78mnGD',
		  // 'co_national_id'=>'14002771736',
          // 'JahadTracking'=>$webservice_JahadTracking
        // );
        // $result=$client->RevokeWarehouseDocument($params);
	    // $response=$result->RevokeWarehouseDocumentResult;
	    // $webservice_error_code =$response->error_code;
	    // $webservice_error_message =$response->error_message;
	    // $webservice_status =$response->status;
	    // $webservice_number =$response->number;
	    // $webservice_JahadTracking =$response->JahadTracking;
      // }//END try
	  // catch(SoapFault $client)
	  // {
		 // echo "<script>alert('وب سرویس فعال نمی باشد')</script>";
		 // echo  $e->getMessage();
	  // }
	   // $update_track=("UPDATE resid SET webservice_error_code='$webservice_error_code',webservice_error_message='$webservice_error_message',webservice_status='$webservice_status' WHERE code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND shomare_resid='$shomare_resid_' AND year=$mtActiveYear");
	   // $update_res=mysql_query($update_track);
     // }
	 //////////////////////////////////FIRST TIME version//////////////////////////////////////////////
	 // if(($_SESSION['mt_webservice']==1)and($exist_kala_detail))//اتصال به وب سرویس
     // {
       // $shenaseSazman="02";
	   // if(strlen($mt_gl_code_ostan)==1) $code_a=make_pattern($mt_gl_code_ostan,2);
       // else $code_a=$mt_gl_code_ostan;
	   // $shenaseAnbar=$code_a.$mt_gl_code_anbar;
	   // $webservice_trackcode=$db->get_from_where("webservice_trackcode","resid","id=$id_");
	   // $c_ostan=substr($webservice_trackcode,4,2);
	   // $c_anbar=substr($webservice_trackcode,6,3);
	   // if(($c_ostan==$code_a)AND($c_anbar==$mt_gl_code_anbar))$shomareGhabz=$code_a.$mt_gl_code_anbar.$shomare_resid_;
       // else $shomareGhabz='0'.$mtActiveYear.$shomare_resid_;

	   // $wsdl_url='http://10.7.234.33/warehouse/warehouse.asmx?wsdl';
	   // header('Content-Type: text/html; charset=utf-8');
       // try
	   // {
	     // $client=new SoapClient($wsdl_url);
	     // $revokeDate=date("Y-m-d");
		 // $params=array(
          // 'OrganNo_'=>$shenaseSazman,
          // 'WareHouseNo'=>$shenaseAnbar,
          // 'BillNo'=>$shomareGhabz,
          // 'RevokeDate'=>$revokeDate,
          // 'RevokeTime'=>$revokeTime,
	      // 'Username'=>'warehouseuser',
          // 'Password'=>'AqWsXz@8246'
          // );
          // $result=$client->RevokBill($params);
	      // $response=$result->RevokBillResult;
	      // echo "<script>alert('کد پیگیری وب سرویس\\n$response')</script>"; 
          // //$sendebtal=1;
       // }
	   // catch(SoapFault $client)
	   // {
	     // $response=0;
		 // echo "<script>alert('وب سرویس فعال نمی باشد')</script>";
	   // }
       // $update_sendebtal=("UPDATE resid SET webservice_sendebtal='$response' WHERE code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND shomare_resid='$shomare_resid_' AND year=$mtActiveYear");
	   // $insert_res=mysql_query($update_sendebtal);	   
      // }
	  mysql_query("COMMIT");
	  echo "<script>window.location='resid.php?PageNo=".$PageNo."&RowPerPage=".$RowPerPage."&order=".$order."';</script>";   
   }
   else
   {
	  mysql_query('ROLLBACK');//nothing will be done, I assume it's for testing
	  echo"<script>alert('* مشکلی در ابطال رسید به وجود آمده است ! *')</script>";
	  echo"<script>window.location='resid.php?PageNo=".$PageNo."&RowPerPage=".$RowPerPage."&order=".$order."';</script>"; 
   }
   mysql_query('SET AUTOCOMMIT=1');  	
 }//END isPermitEbtal	   
}//END EBTAL 
/***************************************** MAIN*****************************************/
  // $q1="SELECT *,
     // (SELECT SUM(vazn_mabda_r_d) FROM resid_detail r_d WHERE r_d.shomare_resid=T.shomare_resid AND r_d.code_ostan=T.code_ostan AND r_d.code_anbar=T.code_anbar AND r_d.year=T.year) vazn_mabda_r,
     // (SELECT SUM(kasry_mojaz_r_d) FROM resid_detail r_d WHERE r_d.shomare_resid=T.shomare_resid AND r_d.code_ostan=T.code_ostan AND r_d.code_anbar=T.code_anbar AND r_d.year=T.year) kasry_mojaz_r,
     // (SELECT SUM(vazn_nakhales_r_d_sub) FROM resid_kala_detail r_k_d WHERE r_k_d.shomare_resid=T.shomare_resid AND r_k_d.code_ostan=T.code_ostan AND r_k_d.code_anbar=T.code_anbar AND r_k_d.year=T.year) vazn_nakhales_r,
     // (SELECT SUM(tedad_karton_r_d_sub) FROM resid_kala_detail r_k_d WHERE r_k_d.shomare_resid=T.shomare_resid AND r_k_d.code_ostan=T.code_ostan AND r_k_d.code_anbar=T.code_anbar AND r_k_d.year=T.year) tedad_karton_r
      // FROM $TableName T WHERE T.shomare_resid='$shomare_resid_' AND T.code_ostan='$mt_gl_code_ostan' AND T.code_anbar='$mt_gl_code_anbar' AND T.year='$mtActiveYear' AND T.deleted=0"; 

 $q1="SELECT T.*,mt_skk.name_skk,peymankar_haml.name_peymankar_haml,mabady_vorudy.name_mabda,ostan.name_ostan AS name_ostan_mabda,list_sardkhane.name_anbar AS name_anbar_mabda 
	  FROM $TableName T
	  LEFT JOIN mt_skk ON T.code_skk=mt_skk.code_skk  	  
	  LEFT JOIN mabady_vorudy ON T.code_mabda=mabady_vorudy.code_mabda  	  
	  LEFT JOIN peymankar_haml ON T.code_peymankar_haml=peymankar_haml.code_peymankar_haml  	  
	  LEFT JOIN ostan ON T.code_ostan_mabda=ostan.code_ostan  	  
	  LEFT JOIN list_sardkhane ON T.code_ostan_mabda=list_sardkhane.code_ostan AND T.code_anbar_mabda=list_sardkhane.code_anbar 	  
	  WHERE T.shomare_resid='$shomare_resid_' AND T.code_ostan='$mt_gl_code_ostan' AND T.code_anbar='$mt_gl_code_anbar' AND T.year='$mtActiveYear' AND T.deleted=0"; 
 //echo $q1;
 $res1=$db->query($q1);
 $row1=$db->fetch_assoc($res1);	
	//resid_detail اطلاعات از
	 // $q_d="SELECT *,
        // (SELECT SUM(vazn_nakhales_r_d_sub) FROM resid_kala_detail r_k_d WHERE r_k_d.code_kala=r_d.code_kala AND r_k_d.code_keshvar=r_d.code_keshvar AND r_k_d.shomare_resid=r_d.shomare_resid AND r_k_d.code_ostan=r_d.code_ostan AND r_k_d.code_anbar=r_d.code_anbar AND r_k_d.year=r_d.year) vazn_nakhales_r_d,				  
        // (SELECT SUM(tedad_karton_r_d_sub) FROM resid_kala_detail r_k_d WHERE r_k_d.code_kala=r_d.code_kala AND r_k_d.code_keshvar=r_d.code_keshvar AND r_k_d.shomare_resid=r_d.shomare_resid AND r_k_d.code_ostan=r_d.code_ostan AND r_k_d.code_anbar=r_d.code_anbar AND r_k_d.year=r_d.year) tedad_karton_r_d		
	     // From resid_detail r_d WHERE r_d.shomare_resid='$shomare_resid_' AND r_d.code_ostan=$mt_gl_code_ostan AND r_d.code_anbar=$mt_gl_code_anbar AND r_d.year=$mtActiveYear";	
	// $res_d = $db->query($q_d);
    // while($row_d=$db->fetch_assoc($res_d))
	// {
	 // $sum_karton_r_d=$row_d['tedad_karton_r_d']*$row_d['vazn_karton_this'];//مجموع وزن کارتن ها
     // $sum_karton_r+=$sum_karton_r_d;
	 // $vazn_khales_r_d=$row_d['vazn_nakhales_r_d']-$sum_karton_r_d;//وزن خالص
	 // $vazn_khales_r+=$vazn_khales_r_d;
	// }
    //$kasry_kol_r=$row1['vazn_mabda_r']-$row1['vazn_nakhales_r'];//کل کسری این رسید
  	//$kasry_gheyremojaz_r=$kasry_kol_r-$row1['kasry_mojaz_r'];//کسری غیرمجاز این رسید
///////////////////////////اطلاعات قرارداد//////////////////////////
if(($row1['noe_tahvil_bar']!=4)and($row1['noe_tahvil_bar']!=5)and($row1['noe_tahvil_bar']!=10))//به غیر از جابه جایی  و انبارگردانی
{	 
 $id_safar=$db->get_from_where("id_safar","resid","shomare_resid='$shomare_resid_' AND code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND year=$mtActiveYear");
 $shomare_safar=$db->get_from_where("shomare_safar","shomare_safar","id_safar=$id_safar");
 $exist_gharardad=$db->get_from_where("COUNT(*)","gharardad_kharid","shomare_gharardad='$shomare_safar'");
 if($exist_gharardad>0)//اگر قرارداد وجود دارد
 {   
     $meghdar_gharardad=$db->get_from_where("meghdar_gharardad","gharardad_kharid","shomare_gharardad='$shomare_safar'");
     $code_kala_eblagh=$db->get_from_where("code_kala","resid LEFT JOIN shomare_safar s_f ON s_f.id_safar=resid.id_safar LEFT JOIN gharardad_kharid g_kh ON g_kh.shomare_gharardad=s_f.shomare_safar INNER JOIN sahmiebandy_kharid s_kh ON s_kh.id_sahmiebandy=g_kh.id_sahmiebandy INNER JOIN eblagh_kharid e_kh ON e_kh.id_eblagh=s_kh.id_eblagh","resid.year='$mtActiveYear' AND resid.code_ostan='$mt_gl_code_ostan' AND resid.code_anbar='$mt_gl_code_anbar' AND resid.shomare_resid='".$shomare_resid_."'");
     //کارتن یا لاشه یا کیسه
	 if(($row1['code_bastebandy']==1)or($row1['code_bastebandy']==3)or($row1['code_bastebandy']==4))
		 $sum_tahvily_gharardad=$db->get_from_where("SUM(vazn_khales_r_d_sub)","meat.resid_kala_detail r_k_d INNER JOIN meat.resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","r.id_safar=$id_safar AND r.noe_tahvil_bar!=4 AND r.noe_tahvil_bar!=5 AND r.noe_tahvil_bar!=6 AND r_k_d.year='$mtActiveYear' AND r_k_d.code_ostan=".$mt_gl_code_ostan." AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.status=0 AND noe_tahvil_bar!=8");
     //قوطی یا دست یا عدد
	 if(($row1['code_bastebandy']==2)OR($row1['code_bastebandy']==5)OR($row1['code_bastebandy']==6))
	     $sum_tahvily_gharardad=$db->get_from_where("SUM(tedad_karton_r_d_sub)","meat.resid_kala_detail r_k_d INNER JOIN meat.resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","r.id_safar=$id_safar AND r.noe_tahvil_bar!=4 AND r.noe_tahvil_bar!=5 AND r.noe_tahvil_bar!=6 AND r_k_d.year='$mtActiveYear'  AND r_k_d.code_ostan=".$mt_gl_code_ostan." AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.status=0 AND noe_tahvil_bar!=8");
	 if($sum_tahvily_gharardad=='')$sum_tahvily_gharardad=0;
	 //مانده قرارداد
	 $mande_tahvily_gharardad=$meghdar_gharardad-$sum_tahvily_gharardad;
 }
}
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<form method="post" name="myform" onkeydown="enterIE()">
<div align="center">
<table width="99%" height="100%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr>
  <td class="title">
   <table border="0" width="100%">
    <tr>';
	if(strlen($row1['code_ostan'])==1) $code_a=make_pattern($row1['code_ostan'],2);
    else $code_a=$row1['code_ostan'];
	 echo'
	 <td width="">رسيد شماره '.$code_a.$row1['code_anbar'].$row1['shomare_resid'].'</td>
 	 <!--<td width="30px" align="left"><div onClick="window.open(\'print_resid_one.php?id__='.$id_.'\',\'\',\'\')" id="printer" title="چاپ"><a href="#"></a></div></td>-->
    </tr>
   </table>
  </td>
 </tr>';
  if($exist_gharardad>0)//اگر قرارداد وجود دارد
  {echo'
   <div style="position:absolute;top:2px;left:10px;">
   <a class="tooltips" href="#"><img class="help" border="0" src="images/button-round-question-icon.png" style="cursor:pointer" onmouseOver="this.src=\'images/button-round-dark-question-icon.png\'" onmouseOut="this.src=\'images/button-round-question-icon.png\'"/>
	<span>';
	  echo'تحویلی از قرارداد: '.round($sum_tahvily_gharardad,3).' - ';echo'مانده از قرارداد: '.round($mande_tahvily_gharardad,3).'';
	 echo' 
	</span>
   </a>
  </div>';
  }
 echo'
 <!--پايان هدر-->
 <!-- مرکز صفحه--> 
 <tr>
  <td height="100%">
   <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
    <img src="images/loading.gif" id="loading" class="loading_img"/>
	<tr class="tr1">
	 <td colspan="3">
      <table border="0" width="100%">
	   <tr>
	   '.$ebtal_message.'
	    <td align="left" width="150px">';
		if(SuperUser())echo 'id: '.$row1['id'].'&nbsp;&nbsp;';
		echo' شماره رسيد : </td> 
		<td align="right" width="200px"><input type="text" readonly class="textboxme" value="'.$row1['shomare_resid'].'" name="shomare_resid" style="width:50px;"/>&nbsp;/&nbsp;
		                  <input readonly type="text" class="textboxme" value="'.$code_a.$row1['code_anbar'].'" name="ostan_anbar" style="width:50px;"/></td>
	    <td align="left" width="150px"><span class="star">*</span> تاريخ رسيد : </td><td align="right"><input type="text" name="tarikh_resid" value="'.$row1['tarikh_resid'].'" class="textboxme2" maxlength="10"'; IF(((SuperUser())AND($_SESSION["mtActiveYear"]==$yy))OR(($right_edt)AND($_SESSION["mtActiveYear"]==$yy))) echo'id="datepicker5"'; else echo'readonly'; echo'/></td>	 
		   <!--<td align="left" width="20%">توضیحات ابطال : </td><td align="right"><input type="text" class="textboxme" name="tozih_ebtal_resid"  style="width:220px;"/></td>-->
	    ';
		//محاسبه پرداختی قرارداد
		$shomare_gharardad=$db->get_from_where("shomare_safar","shomare_safar","id_safar=".$row1['id_safar']." AND code_ostan=".$mt_gl_code_ostan."");     
        $id_gharardad=$db->get_from_where("id_gharardad","gharardad_kharid","shomare_gharardad='".$shomare_gharardad."' AND code_ostan=".$mt_gl_code_ostan." AND deleted=0");     
        $sum_meghdar_pardakhti=$db->get_from_where("SUM(meghdar)","pardakht_gharardad","id_gharardad='".$id_gharardad."' AND pardakht_type=1 AND deleted=0");     
        $sum_tahvily_resid=$db->get_from_where("SUM(vazn_khales_r)","resid","id_safar=".$row1['id_safar']." AND deleted=0 AND status=0");     
        $after_ebtal=$sum_tahvily_resid-$row1['vazn_khales_r'];
		
	    //اگر اجازه ابطال داشته و این رسید هنوز ابطال نشده وسال فعال است وسند حسابداری ثبت نشده
	    IF(($right_ebtal)and($row1['status']==0)and($_SESSION['mtStatusYear']==0)and($row1['set_sanad']==0)and($row1['noe_tahvil_bar']!=10)and($row1['javaz_ebtal']==1))
	    //IF(($after_ebtal>=$sum_meghdar_pardakhti)and($right_ebtal)and($row1['status']==0)and($_SESSION['mtStatusYear']==0)and($row1['set_sanad']==0)and($row1['noe_tahvil_bar']!=10))
		{
		  IF(($row1['id_safar']>0)AND($after_ebtal<$sum_meghdar_pardakhti))echo'<td style="font-weight:bold;color:red;">وضعیت این رسید : غیر قابل ابطال (ثبت مبلغ پرداختی در سیستم خرید)</td>';	
		  ELSE {
			   echo'<td align="left" width="40px"><input type="button" class="buttonme" name="ebtal_x" value="ابطال رسید" onClick="iconfirm(\''.$FileName.'?ebtal_x=1&id_='.$row1['id'].'&shomare_resid_='.$row1['shomare_resid'].'&id_safar_='.$row1['id_safar'].'&vazn_khales_r_='.$row1['vazn_khales_r'].'&noe_tahvil_bar_='.$row1['noe_tahvil_bar'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\',\'براي ابطال رسید '.$code_a.$row1['code_anbar'].$row1['shomare_resid'].' \')"/></td>      
		            <td width="20px"><img border="0" src="images/button-cross_basic.png" width="20" height="20" /></td>';
		
		  }
		}
		ELSE IF($row1['status']==1) echo'<td style="font-weight:bold;color:red;">وضعیت این رسید : ابطالی</td>';	
	    ELSE IF($row1['set_sanad']!=0)
		{
		  if($right_free_ebtal) echo'<td  width="40px"><input type="button" class="buttonme" name="free_x" value="آزادکردن رسید" onClick="iconfirm(\''.$FileName.'?free_x=1&id_='.$row1['id'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\',\'رسید در سیستم مالی ثبت شده برای آزاد کردن رسید '.$code_a.$row1['code_anbar'].$row1['shomare_resid'].' \')"/></td>';      
		  else echo'<td  align="left" style="font-weight:bold;color:red;">رسید در سیستم مالی ثبت شده است اجازه ابطال وجود ندارد</td>';		   
		}
	    echo'
	   </tr>	
	  </table>
	 </td>
	</tr>';
	echo'
    <tr class="tr1">
     <td colspan="3">
	  <fieldset>
	   <legend>اطلاعات</legend>
	   <table width="100%">
	   	<tr>
		 <td align="left"><span class="star">*</span> نوع بسته بندی :&nbsp;</td><td align="right">'.listbox("code_bastebandy",$row1['code_bastebandy'],"code_bastebandy","sharh_bastebandy","bastebandy","1=1 ORDER BY sharh_bastebandy ASC","class='text4' disabled","").'</td>
		 <td align="left"><span class="star">*</span> نوع تحویل بار : </td><td align="right" colspan="3">'.static_listbox("noe_tahvil_bar",$row1['noe_tahvil_bar'],"tahvilbarArr",1,"class='text4' disabled").'</td>
		  <input type="hidden" name="code_bastebandy" value="'.$row1['code_bastebandy'].'"/>
		  <input type="hidden" name="noe_tahvil_bar" value="'.$row1['noe_tahvil_bar'].'"/>
		</tr>';
		IF(($row1['noe_tahvil_bar']==4)or($row1['noe_tahvil_bar']==5))//اگر نوع تحویل  بار جابجایی باشد
		{
		 if(strlen($row1['code_ostan_mabda'])==1) $code_os=make_pattern($row1['code_ostan_mabda'],2);
         else $code_os=$row1['code_ostan_mabda'];
		 echo'
		 <tr id="info">
             <td align="left"><span class="star">*</span> نام استان مبدأ : </td>
			 <td align="right">
			  <input type="hidden" name="code_ostan_mabda" value="'.$row1['code_ostan_mabda'].'"/>
			  <input type="text" class="textboxme2" name="name_ostan_mabda" value="'.$row1['name_ostan_mabda'].'" readonly/>
			 </td>
		     <td align="left"><span class="star">*</span> نام انبار مبدأ  :</td>
			 <td align="right">
			  <input type="hidden" name="code_anbar_mabda" value="'.$row1['code_anbar_mabda'].'"/>
			  <input type="text" class="textboxme2" name="name_anbar_mabda" value="'.$row1['name_anbar_mabda'].'" readonly/>
			 </td>	    
			 <td align="left"><span class="star">*</span> شماره حواله انبار  :</td>
			 <td align="right">
			  <input type="text" class="textboxme2" name="shomare_havale_anbar" readonly value="'.$row1['shomare_havale_anbar'].'" style="width:50px;"/>&nbsp;/&nbsp;<input readonly type="text" class="textboxme" value="'.$code_os.$row1['code_anbar_mabda'].'" name="ostan_anbar" style="width:50px;"/>
			 </td>
			 <td align="left"><span class="star">*</span> شماره مجوز جابه جایی  :</td>
			 <td align="right">
			  <input type="text" class="textboxme2" name="shomare_jabejae" readonly value="'.$row1['shomare_jabejae'].'" />
			 </td> 			 
		 </tr>
		 <!--<tr id="info">
          <td align="left"><span class="star">*</span> نام استان مبدأ : </td><td align="right">'.listbox("code_ostan_mabda",$row1['code_ostan_mabda'],"code_ostan","name_ostan","ostan","1=1 ORDER BY name_ostan ASC","onchange=getAnbareOstan(this.value) class='text4'","").'</td>
		  <td align="left"><span class="star">*</span> نام سردخانه مبدأ : </td><td align="right" colspan="2">'.listbox("code_anbar_mabda",$row1['code_anbar_mabda'],"code_anbar","name_anbar","list_sardkhane","code_ostan=".$row1['code_ostan_mabda']." ORDER BY name_anbar","class='text4'").'</td>
         </tr>-->';
		}
		ELSE IF($row1['noe_tahvil_bar']!=10)
		{echo'
		 <tr id="info">
	      <!--<td align="left"><span class="star">*</span> نام فروشنده/ کشتی : </td><td align="right">'.listbox("code_skk",$row1['code_skk'],"code_skk","name_skk","mt_skk","1=1","onchange=getShomareSafar(this.value) class='text4'").'</td>-->
		  <td align="left"><span class="star">*</span> کدفروشنده/ کشتی : </td>
	      <td align="right">
		   <input type="text" class="textboxme2" name="code_skk" readonly value="'.$row1['code_skk'].'" onfocus="getShomareSafar(this.value)" onchange="getShomareSafar(this.value)" onkeypress="return isNumber(event)"  style="width:50px;"/>';
		   //include('img_helpskk.php');
		  echo'
		   <!--<img border="0" src="images/help.png" onClick="OpenWindowDialog(\'help_skk.php?parent_page=resid\',600,600)" title="جدول کد کشتی / فروشنده" style="width:20px;height:20px;cursor:pointer" onmouseOver="this.src=\'images/help_hover.png\'" onmouseOut="this.src=\'images/help.png\'"/>-->
		  </td>
		  <td align="left" width="150px"> نام فروشنده/ کشتی : </td>
		  <td align="right"><input type="text" class="textboxme2" name="name_skk" id="name_skk" readonly value="'.$row1['name_skk'].'"/></td>';
	      IF(($row1['noe_tahvil_bar']==1)OR($row1['noe_tahvil_bar']==2)OR($row1['noe_tahvil_bar']==3)OR($row1['noe_tahvil_bar']==8))echo'<td align="left"><span class="star">*</span> شماره قرارداد/ سفر : </td><td align="right">'.listbox("id_safar",$row1['id_safar'],"id_safar","shomare_safar","shomare_safar","code_skk=".$row1['code_skk']." AND id_safar=".$row1['id_safar']." ","class='text4' disabled").'</td>';
		  echo'
		  <!--<td align="left"><span class="star">*</span> مبدأ بارگيری : </td><td align="right">'.listbox("code_mabda",$row1['code_mabda'],"code_mabda","name_mabda","mabady_vorudy","1=1 ORDER BY name_mabda ASC","class='text4'").'</td>-->	 
		  <td align="left"><span class="star">*</span> مبدأ بارگيری : </td>
		  <td align="right">
	        <input type="hidden" class="textboxme2" name="code_mabda" value="'.$row1['code_mabda'].'" style="width:50px;"/>
	        <input type="text" class="textboxme2" name="name_mabda" id="name_mabda" readonly value="'.$row1['name_mabda'].'" onfocus="getNameBargiry(document.myform.code_mabda.value)" onchange="getNameBargiry(document.myform.code_mabda.value)""/>';
	        include('img_mabady_vorudy.php');
		    echo'
	      </td>
		 </tr>';
		}
	    echo'
	    <tr>';
		//اگر نوع تحویل بار روباری یا جابه جایی روباری نباشد   
	    if(($row1['noe_tahvil_bar']!=2)and($row1['noe_tahvil_bar']!=5)) {echo'<td align="left">';if(($row1['noe_tahvil_bar']!=3)and($row1['code_bastebandy']!=2))echo'<span class="star">*</span>';echo' شماره باسکول : </td><td align="right"><input type="text" class="textboxme2" value="'.$row1['bsk_no'].'" name="bsk_no" onkeypress="return isNumber(event)"/></td>';}
	    echo'
		 <td align="left"> شماره بارنامه : </td><td align="right"><input type="text" class="textboxme2" value="'.$row1['barname_no'].'" name="barname_no"/></td>
	     <td align="left"> تاريخ بارنامه : </td><td align="right"><input type="text" class="textboxme2 datepicker6" name="barname_tarikh" maxlength="10" value="'.$row1['barname_tarikh'].'"/></td>
	     <td align="left">';if(($row1['noe_tahvil_bar']!=3)and($row1['code_bastebandy']!=2))echo'<span class="star">*</span>';
		 echo' پلاک خودرو : </td><td align="right">
		   <sup>ایران</sup>
		   <input ';if(($row1['noe_tahvil_bar']==4)or($row1['noe_tahvil_bar']==5)) echo 'readonly';echo' type="text" class="textboxme2" name="plak1" value="'.$row1['plak1'].'" onkeypress="return isNumber(event);" maxlength="2" style="width:20px;"/> |
		   <input ';if(($row1['noe_tahvil_bar']==4)or($row1['noe_tahvil_bar']==5)) echo 'readonly';echo' type="text" class="textboxme2" name="plak2" value="'.$row1['plak2'].'" onkeypress="return isNumber(event);" maxlength="3" style="width:30px;"/>
		   <input ';if(($row1['noe_tahvil_bar']==4)or($row1['noe_tahvil_bar']==5)) echo 'readonly';echo' type="text" class="textboxme2" name="plak3" value="'.$row1['plak3'].'" maxlength="1" style="width:20px;"/>
		   <input ';if(($row1['noe_tahvil_bar']==4)or($row1['noe_tahvil_bar']==5)) echo 'readonly';echo' type="text" class="textboxme2" name="plak4" value="'.$row1['plak4'].'" onkeypress="return isNumber(event);" maxlength="2" style="width:20px;"/>';
		   if($row1['kamion_no'])echo'<input type="text" class="textboxme2" value="'.$row1['kamion_no'].'" readonly name="kamion_no" style="width:70px"/>';	 
		  echo'
		 </td>
	    </tr>';
		if($row1['noe_tahvil_bar']!=3)//حمل با راه آهن نباشد
		{echo'
		 <tr>
		  <td align="left">';if($row1['code_bastebandy']!=2)echo'<span class="star">*</span>';echo' نام راننده : </td><td align="right"><input type="text" class="textboxme2" name="ranande_name" value="'.$row1['ranande_name'].'"/></td>
		  <td align="left">';if($row1['code_bastebandy']!=2)echo'<span class="star">*</span>';echo' کد ملی راننده : </td><td align="right"><input type="text" class="textboxme2" name="ranande_melicode" maxlength="10" value="'.$row1['ranande_melicode'].'" onkeypress="return isNumber(event)"/>
		   <img border="0" src="images/Info1.png" title="کد ملی را در 10 رقم وارد نمایید" onmouseOver="this.src=\'images/Info_h.png\'" onmouseOut="this.src=\'images/Info1.png\'" style="width:16px;height:16px;cursor:pointer"/>
		  </td>
		  <td align="left">شماره حساب راننده : </td><td align="right"><input type="text" class="textboxme2" name="shomare_hesab_ranande" value="'.$row1['shomare_hesab_ranande'].'" onkeypress="return isNumber(event);"/></</td>
		  <td align="left">بانک راننده : </td><td align="right">';
            echo''.listbox("bank_ranande",$row1['bank_ranande'],"id","nb_noe_bank","payroll.pay_c_noe_bank","nb_del=0 ORDER BY nb_noe_bank ASC","class='text4' ","").'';
			echo'
	      </td>
		 </tr>';
		}
		echo'
	    <tr>';
		 if($row1['noe_tahvil_bar']!=3)echo'<td align="left">تلفن همراه راننده : </td><td align="right"><input type="text" class="textboxme2" name="ranande_mobile" value="'.$row1['ranande_mobile'].'" onkeypress="return isNumber(event);"/></</td>';
		 //echo'<td align="left"><span class="star">*</span> شرکت حمل کننده : </td><td align="right" colspan="3">'.listbox("code_peymankar_haml",$row1['code_peymankar_haml'],"code_peymankar_haml","name_peymankar_haml","peymankar_haml","1=1 ORDER BY name_peymankar_haml ASC","class='text4'").'</td>';
		 echo'
		 <td align="left" width="120px"><span class="star">*</span> شرکت حمل کننده : </td>
		 <td align="right">
	      <input type="hidden" class="textboxme2" name="code_peymankar_haml" value="'.$row1['code_peymankar_haml'].'" style="width:50px;"/>
	      <input type="text" class="textboxme2" name="name_peymankar_haml" id="name_peymankar_haml" readonly value="'.$row1['name_peymankar_haml'].'" onfocus="getNamePeymankar(document.myform.code_peymankar_haml.value)" onchange="getNamePeymankar(document.myform.code_peymankar_haml.value)""/>';
	      include('img_peymankar_haml.php');
		  echo'
	     </td>';
		 //اگر نوع تحویل بار روباری یا جابه جایی روباری باشد
	     if(($row1['noe_tahvil_bar']==2)or($row1['noe_tahvil_bar']==5)) echo'';
		 else echo'<td align="left"><span class="star">*</span> نوع تخليه : </td><td align="right">'.listbox("code_takhlie",$row1['code_takhlie'],"code_takhlie","sharh_takhlie","takhlie","","class='text4'").'</td>';
		
		 IF($row1['noe_tahvil_bar']==9)echo'<td align="left"><span class="star">*</span> شماره کوتاژ : </td><td align="right"><input type="text" class="textboxme2" name="shomare_kotazh" value="'.$row1['shomare_kotazh'].'"/></td>';
		 ELSE   echo'<td align="left"> شماره کانتینر : </td><td align="right"><input type="text" class="textboxme2" name="shomare_container" value="'.$row1['shomare_container'].'"/></td>';
		echo'
		</tr>
		<tr>';
		IF($row1['noe_tahvil_bar']==9)
	    {
		 echo'
		   <td align="left"><span class="star">*</span>شماره ثبت سفارش : </td><td align="right"><input type="text" class="textboxme2" name="shomare_sabt_sefaresh" value="'.$row1['shomare_sabt_sefaresh'].'"/></td>
		   <td align="left">تاريخ ورود به کشور : </td><td align="right"><input tabindex="-1" type="text" class="textboxme2 datepicker6"  name="tarikh_vorud" maxlength="10" value="'.$row1['tarikh_vorud'].'"/></td>
		   <td align="left">توضیحات علت عدم ترخیص :</td><td align="right"><input type="text" class="textboxme" name="tozihat" value="'.$row1['tozihat'].'"/></td>';
		}
		ELSE
		{	
		 echo'
		   <td align="left"> شماره پلمپ : </td><td align="right"><input type="text" class="textboxme2" name="shomare_polomp" value="'.$row1['shomare_polomp'].'"/></td>
		   <td align="left"> وضعیت پلمپ : </td><td align="right">'.static_listbox("vaziyat_polomp",$row1['vaziyat_polomp'],"polompArr",1,"class='text4'").'</td>
		   <td align="left">شماره گواهی بهداشتی :</td><td align="right"><input type="text" class="textboxme2" name="shomare_govahi_behdashti" value="'.$row1['shomare_govahi_behdashti'].'"/></td>
		   <td align="left">توضیحات :</td><td align="right"><input type="text" class="textboxme" name="tozihat" value="'.$row1['tozihat'].'"/></td>';
		}
		echo'
		<tr>
		</tr>
	   </table>
	  </fieldset>
     </td>
	</tr>
	<tr class="tr1">
	 <td colspan="3">
	  <fieldset>
	  <legend>اطلاعات کالا</legend>
	  <table width="99%" style="border:1px solid #000">
	  <tr style="background-color:#A1dFF6;">
	   <td class="borderbottom" width="%">کد کالا</td>
	   <td class="borderbottom" width="%">نام کالا</td>
	   <td class="borderbottom" width="%">کشور</td>
	   <td class="borderbottom" width="%">تولیدکننده</td>
	   <td class="borderbottom" width="%">فی</td>
	   <td class="borderbottom" width="%">ضریب</td>';
	   if(($row1['noe_tahvil_bar']!=2)and($row1['noe_tahvil_bar']!=5))echo'<td class="borderbottom" width="%">وزن مبدأ</td>';
	   if($row1['code_bastebandy']==1)echo'<td class="borderbottom" width="%">وزن ناخالص</td>';
	   echo'<td class="borderbottom" width="%">تعداد</td>';
	   if($row1['code_bastebandy']==1)echo'<td class="borderbottom" width="%">مجموع وزن کارتن ها</td>';
	   if(($row1['code_bastebandy']!=5)AND($row1['code_bastebandy']!=6))echo'<td class="borderbottom" width="%">وزن خالص</td>';
	   //اگر نوع تحویل بار روباری نباشد
	   if(($row1['noe_tahvil_bar']!=2)and($row1['noe_tahvil_bar']!=5))
	   {echo'
	    <td class="borderbottom" width="%">کل کسری</td>
	    <td class="borderbottom" width="%">کسری مجاز</td>
	    <td class="borderbottom" width="%">کسری غیر مجاز</td>
	    <td class="borderbottom" width="%">وزن اضافه</td>';
		if($row1['noe_pardakht']==2)//اگر نوع پرداخت کرایه در مقصد بود
		{echo'
	     <td class="borderbottom" width="%">مبلغ جریمه کسری</td>
	     <td class="borderbottom" width="%">مبلغ تخلیه</td>
	     <!--<td class="borderbottom" width="%">مبلغ باسکول</td>-->';
		 }
		}
	  echo'
	  </tr>';
	  $q_d="SELECT *,
	    (SELECT code_bastebandy FROM kala WHERE code_kala=r_d.code_kala) code_bastebandy, 
		(SELECT name_kala FROM kala WHERE kala.code_kala=r_d.code_kala) nameKala,
	    (SELECT name_keshvar FROM keshvar WHERE keshvar.code_keshvar=r_d.code_keshvar) nameKeshvar,
	    (SELECT name_tolidkonande FROM tolidkonande WHERE tolidkonande.code_tolidkonande=r_d.code_tolidkonande) nameTolidkonande,
        (SELECT SUM(vazn_nakhales_r_d_sub) FROM resid_kala_detail r_k_d WHERE r_k_d.code_kala=r_d.code_kala AND r_k_d.code_keshvar=r_d.code_keshvar AND r_k_d.code_tolidkonande=r_d.code_tolidkonande AND r_k_d.shomare_resid=r_d.shomare_resid AND r_k_d.code_ostan=r_d.code_ostan AND r_k_d.code_anbar=r_d.code_anbar AND r_k_d.year=r_d.year) vazn_nakhales_r_d,				  
        (SELECT SUM(vazn_khales_r_d_sub) FROM resid_kala_detail r_k_d WHERE r_k_d.code_kala=r_d.code_kala AND r_k_d.code_keshvar=r_d.code_keshvar AND r_k_d.code_tolidkonande=r_d.code_tolidkonande AND r_k_d.shomare_resid=r_d.shomare_resid AND r_k_d.code_ostan=r_d.code_ostan AND r_k_d.code_anbar=r_d.code_anbar AND r_k_d.year=r_d.year) vazn_khales_r_d,				  
        (SELECT SUM(tedad_karton_r_d_sub) FROM resid_kala_detail r_k_d WHERE r_k_d.code_kala=r_d.code_kala AND r_k_d.code_keshvar=r_d.code_keshvar AND r_k_d.code_tolidkonande=r_d.code_tolidkonande AND r_k_d.shomare_resid=r_d.shomare_resid AND r_k_d.code_ostan=r_d.code_ostan AND r_k_d.code_anbar=r_d.code_anbar AND r_k_d.year=r_d.year) tedad_karton_r_d,		
        (SELECT SUM(sum_karton_r_d_sub) FROM resid_kala_detail r_k_d WHERE r_k_d.code_kala=r_d.code_kala AND r_k_d.code_keshvar=r_d.code_keshvar AND r_k_d.code_tolidkonande=r_d.code_tolidkonande AND r_k_d.shomare_resid=r_d.shomare_resid AND r_k_d.code_ostan=r_d.code_ostan AND r_k_d.code_anbar=r_d.code_anbar AND r_k_d.year=r_d.year) sum_karton_r_d		
	     From resid_detail r_d WHERE r_d.shomare_resid='$shomare_resid_' AND r_d.code_ostan=$mt_gl_code_ostan AND r_d.code_anbar=$mt_gl_code_anbar AND r_d.year=$mtActiveYear";	
	  
	  $res_d =$db->query($q_d);
      $i=0;
	  if(mysql_num_rows($res_d)>0)//اگر جزئیات کالا را پر کرده است
	  {
	     while($row_d=$db->fetch_assoc($res_d))
	     {
	       if(($row_d['code_bastebandy']==2)or($row_d['code_bastebandy']==3))$kasry_kol_r_d = $row_d['vazn_mabda_r_d'] - $row_d['vazn_khales_r_d'];//کل کسری این کالا
		   else $kasry_kol_r_d=$row_d['vazn_mabda_r_d']-$row_d['vazn_nakhales_r_d'];//کل کسری این کالا
		   if($kasry_kol_r_d<0) $kasry_kol_r_d=0;//اگر جواب منفی شد
	       if($kasry_kol_r_d==$row_d['vazn_mabda_r_d'])//اگر هنوز وزن ناخالص را ثبت نکرده ایم
	       { 
	    	 $kasry_kol_r_d=0;
	         $kasry_gheyremojaz_r_d=0;
 	       }
	      $kasry_gheyremojaz_r_d=$kasry_kol_r_d-$row_d['kasry_mojaz_r_d'];//کسری غیرمجاز این کالا
	       if($kasry_gheyremojaz_r_d<0) $kasry_gheyremojaz_r_d=0;//اگر جواب منفی شد
	       if($row_d['code_bastebandy']==2)$vazn_ezafe_r_d=$row_d['vazn_khales_r_d']-$row_d['vazn_mabda_r_d'];//وزن اضافه
	       else $vazn_ezafe_r_d=$row_d['vazn_nakhales_r_d']-$row_d['vazn_mabda_r_d'];//وزن اضافه
		   if($vazn_ezafe_r_d<0) $vazn_ezafe_r_d=0;//اگر جواب منفی شد
	      
		  $mablagh_jarimekasry_r_d=$kasry_gheyremojaz_r_d*$row_d['fee_this'];//مبلغ جریمه کسری
	      $mablagh_takhlie_r_d=$row_d['nerkh_takhlie_this'];//مبلغ تخلیه
	      /**///$mablagh_takhlie_r_d=$vazn_khales_r_d*$row_d['nerkh_takhlie_this'];//مبلغ تخلیه
		  /**/// $nerkh_baskul=$db->get_from_where("nerkh_baskul","hazine_baskul","az_vazn<='$vazn_khales_r_d' AND ta_vazn>='$vazn_khales_r_d'");
             // //bef//$mablagh_baskul_r_d=$vazn_khales_r_d*$nerkh_baskul;//مبلغ باسکول	   
             // $mablagh_baskul_r_d=$nerkh_baskul;//مبلغ باسکول	   
	      if($i++%2)echo'<tr style="background:#D0EAFF;">';
	      else echo'<tr style="background:#f6f9da;">';
		  //$gheymat=compute_resid_price($row1['tarikh_resid'],$id_gharardad,$db);
		  echo'
	       <td '.$edtClick.'>'.$row_d['code_kala'].'</td>
	       <td '.$edtClick.'>'.$row_d['nameKala'].'</td>
	       <td '.$edtClick.'>'.$row_d['nameKeshvar'].'</td>
		   <td '.$edtClick.'>'.$row_d['nameTolidkonande'].'</td>
	       <td '.$edtClick.'>'.virgul($row_d['fee_this']).'</td>
	       <!--<td '.$edtClick.'>'.virgul($gheymat).'</td>-->
	       <td '.$edtClick.'>'.$row_d['zarib_this'].'</td>';
		   if(($row1['noe_tahvil_bar']!=2)and($row1['noe_tahvil_bar']!=5))echo'<td '.$edtClick.'>'.$row_d['vazn_mabda_r_d'].'</td>';
		   if($row1['code_bastebandy']==1)echo'<td '.$edtClick.'>'.round($row_d['vazn_nakhales_r_d'],3).'</td>';
	       echo'<td '.$edtClick.'>'.$row_d['tedad_karton_r_d'].'</td>';
		   if($row1['code_bastebandy']==1)echo'<td '.$edtClick.'>'.round($row_d['sum_karton_r_d'],3).'</td>';
	       if(($row1['code_bastebandy']!=5)AND($row1['code_bastebandy']!=6)) echo'<td '.$edtClick.'>'.round($row_d['vazn_khales_r_d'],3).'</td>';
		   //اگر نوع تحویل بار روباری نباشد
		   if(($row1['noe_tahvil_bar']!=2)and($row1['noe_tahvil_bar']!=5))
		   {
		    echo'
	        <td '.$edtClick.'>'.round($kasry_kol_r_d,3).'</td>
	        <td '.$edtClick.'>'.round($row_d['kasry_mojaz_r_d'],3).'</td>
	        <td '.$edtClick.'>'.round($kasry_gheyremojaz_r_d,3).'</td>
	        <td '.$edtClick.'>'.round($vazn_ezafe_r_d,3).'</td>';
			if($row1['noe_pardakht']==2)//اگر نوع پرداخت کرایه در مقصد بود
            {
			 echo'
	         <td '.$edtClick.'>'.virgul($mablagh_jarimekasry_r_d).'</td>
	         <td '.$edtClick.'>'.virgul($mablagh_takhlie_r_d).'</td>
	         <!--<td '.$edtClick.'>'.$mablagh_baskul_r_d.'</td>-->';
			 }
		   }
		  echo' 
	      </tr>';
	      $vazn_mabda_r+=$row_d['vazn_mabda_r_d'];
	      $vazn_nakhales_r+=$row_d['vazn_nakhales_r_d'];
	      $tedad_karton_r+=$row_d['tedad_karton_r_d'];
	      $sum_karton_r+=$row_d['sum_karton_r_d'];
	      $vazn_khales_r+=$row_d['vazn_khales_r_d'];
		  //اگر نوع تحویل بار روباری نباشد
		  if(($row1['noe_tahvil_bar']!=2)and($row1['noe_tahvil_bar']!=5))
		  {
	        $kasry_kol_r+=$kasry_kol_r_d;
	        $kasry_mojaz_r+=$row_d['kasry_mojaz_r_d'];
	        $kasry_gheyremojaz_r+=$kasry_gheyremojaz_r_d;
	        $vazn_ezafe_r+=$vazn_ezafe_r_d;
	        $mablagh_jarimekasry_r+=$mablagh_jarimekasry_r_d;
	        $mablagh_takhlie_r+=$mablagh_takhlie_r_d;
	        //مبلغ باسکول
			//$mablagh_baskul_r=$db->get_from_where("nerkh_baskul","hazine_baskul","az_vazn<='$vazn_khales_r' AND ta_vazn>='$vazn_khales_r'");
			//if($vazn_khales_r==0) $mablagh_baskul_r=0;
			/**///$mablagh_baskul_r+=$mablagh_baskul_r_d;
		  }
	      // $mablagh_pardakhty=$row1['mablagh_kerayemabda']-$mablagh_jarimekasry_r+$row1['mablagh_haghetavaghof']-$mablagh_baskul_r-$mablagh_takhlie_r;
	      // if($mablagh_pardakhty<0) $mablagh_pardakhty=0;
		 }
	     echo'
	      <tr style="background-color:#A1dFF6">
	      <td class="bordertop" colspan="6">مجموع مقادیر</td>';
		  if(($row1['noe_tahvil_bar']!=2)and($row1['noe_tahvil_bar']!=5)) echo'<td class="bordertop">'.$vazn_mabda_r.'</td>';
	      if($row1['code_bastebandy']==1)echo'<td class="bordertop">'.round($vazn_nakhales_r,3).'</td>';
		  echo'<td class="bordertop">'.$tedad_karton_r.'</td>';
	      if($row1['code_bastebandy']==1)echo'<td class="bordertop">'.round($sum_karton_r,3).'</td>';
	      if(($row1['code_bastebandy']!=5)AND($row1['code_bastebandy']!=6))echo'<td class="bordertop">'.round($vazn_khales_r,3).'</td>';
		  //اگر نوع تحویل بار روباری نباشد
		  if(($row1['noe_tahvil_bar']!=2)and($row1['noe_tahvil_bar']!=5)) 
		  {
		   echo'
	       <td class="bordertop">'.round($kasry_kol_r,3).'</td>
	       <td class="bordertop">'.round($kasry_mojaz_r,3).'</td>
	       <td class="bordertop">'.round($kasry_gheyremojaz_r,3).'</td>
	       <td class="bordertop">'.round($vazn_ezafe_r,3).'</td>';
		   if($row1['noe_pardakht']==2)//اگر نوع پرداخت کرایه در مقصد بود
	       {
		    echo'
		    <td class="bordertop">'.virgul($mablagh_jarimekasry_r).'</td>
	        <td class="bordertop">'.virgul($mablagh_takhlie_r).'</td>
	        <!--<td class="bordertop">'.virgul($mablagh_baskul_r).'</td>-->';
		   }
		  }
		  echo'
	     </tr>';
      }
      else if($row1['status']==1){echo'<tr style="background:#f6f9da;"><td colspan="16" style="color:red">رسید ابطال شد</td></tr>';}	  
	  else {echo'<tr style="background:#f6f9da;"><td><img border="0" src="images/info.gif"/></td><td colspan="15">لطفاً برای تکمیل رسید جزئیات رسید را تکمیل نمایید!</td></tr>';}	   	  
	  //محاسبه مبلغ پرداختی
	  //$mablagh_pardakhty=$row1['mablagh_kerayemabda']-$mablagh_jarimekasry_r+$row1['mablagh_haghetavaghof']-$mablagh_baskul_r-$mablagh_takhlie_r;
	  $mablagh_pardakhty=$row1['mablagh_kerayemabda']-$mablagh_jarimekasry_r+$row1['mablagh_haghetavaghof']-$mablagh_takhlie_r;
	  if($mablagh_pardakhty<0) $mablagh_pardakhty=0;
	   echo'
      </table>
	  </fieldset>	   	 
     </td> 	  
	</tr> 
	<tr class="tr1" >
	 <td colspan="" valign="top" width="33%">
	  <fieldset>
	   <legend>وزن</legend>
	   <table width="100%"  height="200px">';
	   	//اگر نوع تحویل بار روباری یا جابه جایی روباری باشد
	    if(($row1['noe_tahvil_bar']==2)or($row1['noe_tahvil_bar']==5))
        {
		 if($row1['code_bastebandy']==1)echo'<tr><td align="left"> وزن ناخالص : </td><td align="right"><input type="text" readonly class="textboxme2" name="vazn_khales_r" value="'.round($row1['vazn_nakhales_r'],3).'"/></td></tr>';
	     echo'<tr><td align="left">';if($row1['code_bastebandy']==1)echo' تعداد کارتن ها : ';if($row1['code_bastebandy']==2)echo' تعداد قوطی ها : '; else echo'تعداد : ';echo'</td><td align="right"><input type="text" readonly class="textboxme2" name="tedad_karton_r" value="'.$row1['tedad_karton_r'].'"/></td></tr>';
	     if($row1['code_bastebandy']==1)echo'<tr><td align="left"> وزن کارتن ها : </td><td align="right"><input type="text" readonly class="textboxme2" name="vazn_khales_r" value="'.round($sum_karton_r,3).'"/></td></tr>';
	     echo'<tr><td align="left"> وزن خالص : </td><td align="right"><input type="text" readonly class="textboxme2" name="vazn_khales_r" value="'.round($row1['vazn_khales_r'],3).'"/></td></tr>';
		}
	   	//اگر نوع تحویل بار تخلیه یا جابه جایی تخلیه یاحمل باراه آهن باشد		
		else
        {
		 echo'
	     <tr><td align="left"> وزن مبدأ : </td><td align="right"><input type="text" readonly class="textboxme2" name="vazn_mabda_r" value="'.round($vazn_mabda_r,3).'"/></td></tr>';
	     //تخلیه یا جابه جایی تخلیه باشد
		 if($row1['noe_tahvil_bar']!=3)
		 {
		  if($row1['sabt_nahayi']==1)
		   {echo'<tr><td align="left"> وزن کاميون با بار : </td><td align="right"><input type="text" readonly class="textboxme2" name="vazn_kamiyon_bar" value="'.($row1['vazn_kamiyon_bar']).'"/></td></tr>
	             <tr><td align="left"> وزن کاميون : </td><td align="right"><input type="text" readonly class="textboxme2" name="vazn_kamiyon" value="'.($row1['vazn_kamiyon']).'"/></td></tr>';
           }
		  else 
		   {echo'<tr><td align="left">';if($row1['code_bastebandy']!=2)echo'<span class="star">*</span>';echo' وزن کاميون با بار : </td><td align="right"><input type="text" class="textboxme2" name="vazn_kamiyon_bar" value="'.($row1['vazn_kamiyon_bar']).'" onKeydown="return PressfloatOnly(event,this)"/></td></tr>
	             <tr><td align="left">';if($row1['code_bastebandy']!=2)echo'<span class="star">*</span>';echo' وزن کاميون : </td><td align="right"><input type="text" class="textboxme2" name="vazn_kamiyon" value="'.($row1['vazn_kamiyon']).'" onkeypress="return isNumber(event)"/></td></tr>';
           }		 
		 }
		 if($row1['code_bastebandy']==1)echo'<tr><td align="left"> وزن ناخالص : </td><td align="right"><input type="text" readonly class="textboxme2" name="vazn_khales_r" value="'.round($row1['vazn_nakhales_r'],3).'"/></td></tr>';
	     echo'<tr><td align="left"> تعداد : </td><td align="right"><input type="text" readonly class="textboxme2" name="tedad_karton_r" value="'.$row1['tedad_karton_r'].'"/></td></tr>';
	     if($row1['code_bastebandy']==1)echo'<tr><td align="left"> وزن کارتن ها : </td><td align="right"><input type="text" readonly class="textboxme2" name="vazn_khales_r" value="'.round($sum_karton_r,3).'"/></td></tr>';
	     if(($row1['code_bastebandy']!=5)AND($row1['code_bastebandy']!=6))echo'<tr><td align="left"> وزن خالص : </td><td align="right"><input type="text" readonly class="textboxme2" name="vazn_khales_r" value="'.round($row1['vazn_khales_r'],3).'"/></td></tr>';
	   	 if($row1['noe_tahvil_bar']!=3)//حمل با راه آهن نباشد
		 { 
		   if(($row1['sabt_nahayi']==1)or($row1['noe_tahvil_bar']==4)or($row1['noe_tahvil_bar']==5))echo'<tr><td align="left"> نوع خودرو : </td><td align="right">'.static_listbox("noe_khodro",$row1['noe_khodro'],"khodroArr",1,"class='text4' disabled").'<input type="hidden" name="noe_khodro" value="'.$row1['noe_khodro'].'"/></td></tr>';
		   else {echo'<tr><td align="left">';if($row1['code_bastebandy']!=2)echo'<span class="star">*</span>';echo' نوع خودرو : </td><td align="right">'.static_listbox("noe_khodro",$row1['noe_khodro'],"khodroArr",1,"class='text4' onchange=getNerkhBaskul(this.value)").'</td></tr>';}
         }
		}		
		echo'
	   </table>
	  </fieldset>
     </td>';
	 //اگر نوع تحویل بار روباری یا جابه جایی روباری باشد
	 if(($row1['noe_tahvil_bar']==2)or($row1['noe_tahvil_bar']==5)) echo '<td width="30%">&nbsp;</td>';
     else
	 {
	  echo'
	  <td valign="top" width="30%">
	   <fieldset>
	    <legend>کسری</legend>
	    <table width="100%"  height="200px">
	     <tr><td align="left">کل کسری : </td><td align="right"><input type="text" readonly class="textboxme2" name="kasry_kol" value="'.round($kasry_kol_r,3).'"/></td></tr>
	 	 <tr><td align="left">کسری مجاز : </td><td align="right"><input type="text" readonly class="textboxme2" name="kasry_mojaz_r" value="'.round($kasry_mojaz_r,3).'"/></td></tr>
	     <tr><td align="left">کسری غیر مجاز : </td><td align="right"><input type="text" readonly class="textboxme2" name="kasry_gheyremojaz_r" value="'.round($kasry_gheyremojaz_r,3).'"/></td></tr>
	     <tr><td align="left">وزن اضافه : </td><td align="right"><input type="text" readonly class="textboxme2" name="vazn_ezafe" value="'.round($vazn_ezafe_r,3).'"/></td></tr>
	     <tr><td rowspan="10">&nbsp;</td></tr>
		</table>
	   </fieldset>
      </td>';
	 }
	 if($row1['noe_tahvil_bar']!=3)//حمل با راه آهن نباشد
	 {echo'
	 <td width="37%" valign="top">
	  <fieldset>
	   <legend>مبالغ</legend>
	   <table width="100%" height="200px">
	     <tr><td align="left"> نوع پرداخت پسکرایه : </td><td align="right">'.static_listbox("noe_pardakht",$row1['noe_pardakht'],"pardakhtArr",1,"class='text4' disabled").'<input type="hidden" name="noe_pardakht" value="'.$row1['noe_pardakht'].'"/></td></tr>
	     <tr><td align="left"> مبلغ ریالی رسید : </td><td align="right"><input type="text" class="textboxme2" readonly name="mablagh_riali" value="'.$mablagh_riali.'"/></td></tr> 
		 <tr>
		 <td colspan="2">';
		 if($row1['noe_pardakht']==2)//اگر نوع پرداخت کرایه در مقصد ثبت شده بود
		 {
 		  echo'
		  <span id="paskeraye">
		   <table width="100%" border="0">';
		   //اگر نوع تحویل بار روباری یا جابه جایی روباری باشد
	       if(($row1['noe_tahvil_bar']==2)or($row1['noe_tahvil_bar']==5))
	       {echo'
	         <tr><td align="left"><span class="star">*</span> مبلغ کرايه مبدأ : </td><td align="right"><input type="text" class="textboxme2" name="mablagh_kerayemabda" value="'.virgul($row1['mablagh_kerayemabda']).'" readonly onblur="return pardakhty()" onkeypress="return isNumber(event)"/></td></tr>
	         <tr><td align="left">مبلغ حق توقف : </td><td align="right"><input type="text" class="textboxme2" name="mablagh_haghetavaghof" readonly value="'.virgul($row1['mablagh_haghetavaghof']).'"/></td></tr>
             <!--برای اینکه تابع پرداختی کار کند این 3 تا را گذاشتم-->		
	         <input type="hidden" readonly class="textboxme2" name="mablagh_jarimekasry"/>
	         <input type="hidden" readonly class="textboxme2" id="mablagh_baskul" name="mablagh_baskul" />
	         <input type="hidden" class="textboxme2" name="mablagh_takhlie"/>';
	       }
		   else 
	       {echo'
		     <tr><td align="left"><span class="star">*</span> مبلغ کرايه مبدأ : </td><td align="right"><input type="text" class="textboxme2" readonly name="mablagh_kerayemabda" value="'.virgul($row1['mablagh_kerayemabda']).'" onblur="return pardakhty()" onkeypress="return isNumber(event)"/></td></tr>
		     <tr><td align="left">مبلغ جريمه کسری : </td><td align="right"><input type="text" readonly class="textboxme2" name="mablagh_jarimekasry" value="'.virgul($mablagh_jarimekasry_r).'"/></td></tr>
	         <tr><td align="left">مبلغ حق توقف : </td><td align="right"><input type="text" class="textboxme2" readonly name="mablagh_haghetavaghof" value="'.virgul($row1['mablagh_haghetavaghof']).'"/></td></tr>
			 <tr><td align="left">مبلغ باسکول : </td><td align="right" ><input type="text" readonly class="textboxme2" name="mablagh_baskul" value="'.virgul($row1['mablagh_baskul']).'"/> <img border="0" src="images/Info1.png" title="مبلغ باسکول از مبلغ پرداختی کسر نمی شود" onmouseOver="this.src=\'images/Info_h.png\'" onmouseOut="this.src=\'images/Info1.png\'" style="width:16px;height:16px;cursor:pointer"/></td></tr>
	         <tr><td align="left">مبلغ تخليه : </td><td align="right"><input type="text" readonly class="textboxme2" name="mablagh_takhlie" value="'.virgul($mablagh_takhlie_r).'"/></td></tr>
	          <!--<tr><td align="left">مبلغ اضافه بار : </td><td align="right"><input type="text" readonly class="textboxme2" readonly name="mablagh_ezafebar" value="'.virgul($row1['mablagh_ezafebar']).'"/></td></tr>-->';
	        }
			echo'
		    <tr><td colspan="2"><hr/></td></tr>
		    <tr><td align="left"> مبلغ پرداختی : </td><td align="right"><input type="text" class="textboxme2" readonly name="mablagh_pardakhty" value="'.virgul($mablagh_pardakhty).'"/></td></tr>
	   	    <tr><td align="left"><span class="star">*</span> عامل پرداخت پسکرایه : </td><td align="right">'.listboxMe("amel_p_accnting_code",$row1['amel_p_accnting_code'],"amel_p_accnting_code","concat(amel_p_name,'&nbsp',amel_p_lastname)","amel_pardakht","code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' order by amel_p_name,amel_p_lastname ASC","class='text4'","").'</td></tr>
		  </table>
		  </span>';
		  }
		 else
		 {
 		  echo'
		  <span id="paskeraye" style="display:none;">
		   <table width="100%" border="0">
		    <tr><td align="left"><span class="star">*</span> مبلغ کرايه مبدأ : </td><td align="right"><input type="text" readonly class="textboxme2" name="mablagh_kerayemabda" value="'.virgul($row1['mablagh_kerayemabda']).'" onblur="return pardakhty()" onkeypress="return isNumber(event)"/></td></tr>';
		    //اگر نوع تحویل بار روباری نباشد
		    if($row1['noe_tahvil_bar']!=2) echo'<tr><td align="left">مبلغ جريمه کسری : </td><td align="right"><input type="text" readonly class="textboxme2" name="mablagh_jarimekasry" value="'.virgul($mablagh_jarimekasry_r).'"/></td></tr>';
	        echo'<tr><td align="left">مبلغ حق توقف : </td><td align="right"><input type="text" class="textboxme2" readonly name="mablagh_haghetavaghof" value="'.virgul($row1['mablagh_haghetavaghof']).'"/></td></tr>';
		    //اگر نوع تحویل بار روباری نباشد
		    if($row1['noe_tahvil_bar']!=2)
			{echo'<tr><td align="left">مبلغ باسکول : </td><td align="right" ><input type="text" readonly class="textboxme2" name="mablagh_baskul" value="'.virgul($row1['mablagh_baskul']).'"/> <img border="0" src="images/Info1.png" title="مبلغ باسکول از مبلغ پرداختی کسر نمی شود" onmouseOver="this.src=\'images/Info_h.png\'" onmouseOut="this.src=\'images/Info1.png\'" style="width:16px;height:16px;cursor:pointer"/></td></tr>
	        <tr><td align="left">مبلغ تخليه : </td><td align="right"><input type="text" readonly class="textboxme2" name="mablagh_takhlie" value="'.virgul($mablagh_takhlie_r).'"/></td></tr>
	          <!--<tr><td align="left">مبلغ اضافه بار : </td><td align="right"><input type="text" readonly class="textboxme2" readonly name="mablagh_ezafebar" value="'.virgul($row1['mablagh_ezafebar']).'"/></td></tr>-->';
			}
			echo'
		    <tr><td colspan="2"><hr/></td></tr>
		    <tr><td align="left"> مبلغ پرداختی : </td><td align="right"><input type="text" class="textboxme2" readonly name="mablagh_pardakhty" value="'.virgul($mablagh_pardakhty).'"/></td></tr>
	   	    <tr><td align="left"><span class="star">*</span> عامل پرداخت پسکرایه : </td><td align="right">'.listboxMe("amel_p_accnting_code",$row1['amel_p_accnting_code'],"amel_p_accnting_code","concat(amel_p_name,'&nbsp',amel_p_lastname)","amel_pardakht","code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' order by amel_p_name,amel_p_lastname ASC","class='text4'","").'</td></tr>	   
		   </table>
		  </span>';
		  }
		 echo'		 
		 </td>
		</tr>';
		$mablagh_riali=mablaghRiali($row1['shomare_resid'],$row1['code_ostan'],$row1['code_anbar'],$row1['year']);
		echo'
	    <tr><td align="left">مبلغ ریالی کالا : </td><td align="right"><input type="text" class="textboxme2" readonly name="mablagh_riali" value="'.virgul($mablagh_riali).'"/></td></tr>
	   </table>
      </fieldset>
	 </td>';
	 }
	 echo'
	</tr>
   </table>
  </td>
 </tr>
<!--پايان مرکز صفحه -->
</div>
</table>
<!-- فوتر-->
<table style="position:fixed;bottom:-2px;left:0.5%" width="99%"> 
  <tr class="footer">';
   //اگر اجازه ویرایش دارد و رسید ابطالی نیست و وضعیت سال فعال است و ثبت نهایی نشده است
   //یا سوپریوزر است و رسید ابطالی نیست و ثبت نهایی نشده است
   //یا سوپریوزر است و رسید ابطالی نیست و ثبت نهایی شده ولی در وب سرویس ثبت نشده است 
   if((($_SESSION['mt_user_id']==74)and($right_edt)and($row1['status']==0)and($row1['noe_tahvil_bar']!=10))OR(($right_edt)and($row1['status']==0)and($_SESSION['mtStatusYear']==0)and($row1['sabt_nahayi']==0)and($row1['set_sanad']==0)and($row1['noe_tahvil_bar']!=10))or((SuperUser())and($row1['status']==0) and($row1['sabt_nahayi']==0)and($row1['set_sanad']==0)and($row1['noe_tahvil_bar']!=10))or((SuperUser())and($row1['status']==0)and($row1['sabt_nahayi']==1)and(strlen($row1['webservice_trackcode'])!=25)and($row1['set_sanad']==0)and($row1['noe_tahvil_bar']!=10)))
   { echo'
	  <td align="center">
	   <input type="submit" class="buttonme" name="Edit_x" id="sabt" value="ثبت تغييرات">
   	   <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\'resid.php?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'">
	  </td>';
   }
   else echo'<td><div onClick="window.location=\'resid.php?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-back"  title="بازگشت" style="float:left;width:55%"><a href="#"></a></div></td> ';
  echo'   
  </tr>
</table>
<!-- پايان فوتر-->';
/**********اجازه براي ويرايش اطلاعات********/
function isPermitEdit($today,$mtStartDateSh,$code_baste,$n_tahvil,$c_keshty,$safar,$c_mabda,$c_o_mabda,$c_a_mabda,$date_resid,$sh_baskul,$sh_barname,$date_barname,$pl1,$pl2,$pl3,$pl4,$n_ranande,$c_meli,$c_takhlie,$c_peyman_h,$v_k_b,$v_k,$n_pardakht,$m_k_mabda,$a_p_acc_code,$befor_a_p_acc_code,$khodro,$gl_c_o,$gl_c_s,$gl_year,$this_id,$sh_havale,$sh_container,$sh_sabt_sefaresh,$sho_kotazh,$tarikh_vorud)   
{
 $flag=false;
 if(!($gl_c_o and $gl_c_s and $gl_year) or $gl_c_o==-1 or $gl_c_s==-1)//اگر سشن استان و انبار وسال خالی بود
 {   
   $flag=false;
   echo"<script> alert('لطفاً استان و انبار و سال مورد نظر خود را انتخاب نمایید!')</script>";
   return $flag;
 }
 else $flag=true;
 if((!$code_baste)or(!$n_tahvil)or(!$date_resid)or(!$c_peyman_h))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
   return $flag;
 } 
 else $flag=true;
 //بسته بندی کارتن و نوع تحویل به غیراز حمل با راه آهن
 if(($code_baste!=2) and ($n_tahvil!=3) and((!$pl1) or (!$pl2) or (!$pl3) or (!$pl4) or (!$n_ranande) or (!$c_meli)))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
   return $flag;
 } 
 else $flag=true; 
 //نوع تحویل جا به جایی نباشد
 if(($n_tahvil!=4)and($n_tahvil!=5)and(!($c_keshty and $c_mabda)))//پر بودن فروشنده یا کشتی و مبدا بارگیری
 {
   $flag=false;
   echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
   return $flag;
 } 
 else $flag=true;
 //نوع تحویل تخلیه در سردخانه تحویل روباری حمل باراه آهن
 if((($n_tahvil==1)or($n_tahvil==2)or($n_tahvil==3)or($n_tahvil==8))and(!($safar)))//پر بودن شماره قرارداد یا سفر
 {
   $flag=false;
   echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
   return $flag;
 } 
 else $flag=true;
 //نوع تحویل جا به جایی باشد
 if((($n_tahvil==4)or($n_tahvil==5))and(!($c_o_mabda and $c_a_mabda)))//پر بودن استان و انبار مبدأ
 {
   $flag=false;
   echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
   return $flag;
 } 
 else $flag=true;
 //نوع تحویل روباری یا جابه جایی روباری نباشد
 if(($n_tahvil!=2)and($n_tahvil!=5)and(!($c_takhlie)))//نوع تخلیه
 {
   $flag=false;
   echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
   return $flag;
 } 
 else $flag=true;
 //نوع تحویل روباری یا جابه جایی روباری یا حمل باراه آهن نباشد و بسته بندی کارتنی
 if(($code_baste!=2)and($n_tahvil!=2)and($n_tahvil!=3)and($n_tahvil!=5)and(!($v_k_b and $v_k and $khodro)))//نوع تخلیه و وزن کامیون بار ووزن کامیون و خودرو
 {
	$flag=false;
	echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
    return $flag;
 } 
 else $flag=true;
 if($sh_baskul!='0')
 { 
  if(($code_baste!=2)and($n_tahvil!=2)and($n_tahvil!=3)and($n_tahvil!=5)and(!($sh_baskul)))//شماره باسکول
  {
	$flag=false;
	echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
    return $flag;
  } 
  else $flag=true;
 }
 else $falg=true;
 //نوع تحویل تحت کلید گمرک
 if(($n_tahvil==9)and(!($sh_sabt_sefaresh and $sho_kotazh)))
 {
   $flag=false;
   echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
   return $flag;
 } 
 else $flag=true;
 //نوع تحویل جا به جایی نباشد //شرطهای پایین دچار مشکل می شود
 // if(($n_tahvil!=4)and($n_tahvil!=5)and($c_keshty))//وجود کدمالی کشتی
 // {
   // $flag=false;
   // $q_coding="SELECT code_skk FROM coding_mali_keshty WHERE code_skk='$c_keshty'";
   // $res_coding=mysql_query($q_coding);
   // if(mysql_num_rows($res_coding)==0)echo"<script>window.alert('برای این کشتی/فروشنده کد مالی تعریف نشده است!');</script>";
   // else $flag=true;
   // return $flag;
 // } 
 // else $flag=true;
 if((checkdatejalali($date_resid)==false)or($date_resid>$today)or($date_resid<$mtStartDateSh))//صحت فرمت تاریخ
 {
	$flag=false;
	echo"<script>window.alert('لطفا تاریخ را صحیح وارد نمایید!');</script>";
    return $flag;
 }
 else $flag=true;
 if(($date_barname)and((checkdatejalali($date_barname)==false) or ($date_barname>$date_resid)))//صحت فرمت تاریخ
 {
	$flag=false;
	echo"<script>window.alert('لطفا تاریخ بارنامه را صحیح وارد نمایید!');</script>";
    return $flag;
 }
 else $flag=true; 
 if(($code_baste!=2)and($sh_baskul!='0')and($n_tahvil!=2)and($n_tahvil!=3)and($n_tahvil!=5))//تکراری نبودن شماره باسکول هم در رسید و هم در حواله به ازای هر انبار و هر سال 
 { 
   $q_baskul_r="SELECT bsk_no FROM resid WHERE bsk_no='$sh_baskul' AND code_ostan='$gl_c_o' AND code_anbar='$gl_c_a' AND year='$gl_year' AND id!=$this_id";
   $q_baskul_h="SELECT bsk_no FROM havale WHERE bsk_no='$sh_baskul' AND code_ostan='$gl_c_o' AND code_anbar='$gl_c_a' AND year='$gl_year'";
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
 if(($n_pardakht==2)and(!($m_k_mabda and $a_p_acc_code)))//اگر پرداخت از نوع کرایه در مقصد ، پر بودن مبلغ کرایه مبدأ وعامل پرداخت
 {
   $flag=false;
   echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
   return $flag;
 }
  //پلاک خودرو 
 if((($pl1!=NULL)and(($pl2==NULL)or($pl3==NULL)or($pl4==NULL)))or(($pl2!=NULL)and(($pl1==NULL)or($pl3==NULL)or($pl4==NULL)))or(($pl3!=NULL)and(($pl1==NULL)or($pl2==NULL)or($pl4==NULL)))or(($pl4!=NULL)and(($pl1==NULL)or($pl2==NULL)or($pl3==NULL))))
  {
   $flag=false;
   echo"<script>alert('پلاک خودرو نامعتبر است!')</script>";
   return $flag;
 }
 else $flag=true;
 // if(($pl1!=NULL)and($pl2!=NULL)and($pl4!=NULL)and((((!justNumber($pl1))or(strlen($pl1)>2)or(strlen($pl1)<2)))or((((!justNumber($pl2)) or (strlen($pl2)>3) or (strlen($pl2)<3))))or((((!justNumber($pl4))or(strlen($pl4)>2)or(strlen($pl4)<2))))))
 // {
   // $flag=false;
   // echo"<script>alert('پلاک خودرو نامعتبر است!')</script>";
   // return $flag;
 // }
 // else $flag=true;
 // if(($pl3!=NULL)and((!validFarsi($pl3))))
 // {
   // $flag=false;
   // echo"<script>alert('پلاک خودرو نامعتبر است!')</script>";
   // return $flag;
 // }
 //نوع تحویل حمل با راه آهن نباشد
 if(($code_baste!=2)and(($n_tahvil!=3))and((!justNumber($c_meli)) or (strlen($c_meli)>10) or (strlen($c_meli)<10)))//بررسی کد ملی
 {
   $flag=false;
   echo"<script>alert('فیلد کد ملی نادرست است!')</script>";
   return $flag;
 }
 else $flag=true;
 if(($n_pardakht==2)and($a_p_acc_code!=$befor_a_p_acc_code))//با عامل پرداختی که قبلاً برای این رسید ثبت شده کاری نداریم
 {
  $q10="SELECT status_amel_p FROM amel_pardakht WHERE amel_p_accnting_code='$a_p_acc_code' AND code_ostan='$gl_c_o'";
  $res10=mysql_query($q10);
  $row10=mysql_fetch_array($res10);
  if($row10['status_amel_p']==2)//اگر عامل پرداخت غیرجاری است
  { echo"<script>alert('وضعیت عامل پرداخت پسکرایه انتخاب شده غیرجاری است !')</script>";
    $flag=false;
    return $flag;	
  }
  else $flag=true;
 }
 else $flag=true;
 if(($n_tahvil==4)or($n_tahvil==5))//شماره و تاریخ بارنامه
 {
   $q11="SELECT shomare_barname_h,tarikh_barname_h,barname_from_resid FROM havale WHERE shomare_havale_anbar='$sh_havale' AND code_ostan='$c_o_mabda' AND code_anbar='$c_a_mabda' AND year='$gl_year'";
   $res11=mysql_query($q11);
   $row11=mysql_fetch_assoc($res11);
   if(($row11['shomare_barname_h']!='')and($sh_barname!=$row11['shomare_barname_h'])and($row11['barname_from_resid']==0))
   {
    echo"<script>window.alert('شماره بارنامه با حواله متناظر مغایرت دارد!');</script>";
    $flag=false;
    return $flag;
    } 
    else $flag=true;
	if(($row11['tarikh_barname_h']!='')and($date_barname!=$row11['tarikh_barname_h'])and($row11['barname_from_resid']==0))
   {
    echo"<script>window.alert('تاریخ بارنامه با حواله متناظر مغایرت دارد!');</script>";
    $flag=false;
    return $flag;
    } 
    else $flag=true;
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
 if(isPermitEdit($today,$mtStartDateSh,$code_bastebandy,$noe_tahvil_bar,$code_skk,$id_safar,$code_mabda,$code_ostan_mabda,$code_anbar_mabda,$tarikh_resid,$bsk_no,$barname_no,$barname_tarikh,$plak1,$plak2,$plak3,$plak4,$ranande_name,
                 $ranande_melicode,$code_takhlie,$code_peymankar_haml,$vazn_kamiyon_bar,$vazn_kamiyon,$noe_pardakht,$mablagh_kerayemabda,$amel_p_accnting_code,$row1['amel_p_accnting_code'],$noe_khodro,$mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear,$id_,$shomare_havale_anbar,$shomare_sabt_sefaresh,$shomare_kotazh,$tarikh_vorud))				  
 {
  //if($noe_pardakht==2)$mablagh_pardakhty=$mablagh_kerayemabda+$mablagh_haghetavaghof;
  $ranande_name=str_replace("ي","ی",$ranande_name);
  $ranande_name=str_replace("ك","ک",$ranande_name);
  $mablagh_kerayemabda=str_replace(",","",$mablagh_kerayemabda);
  $mablagh_haghetavaghof=str_replace(",","",$mablagh_haghetavaghof);
  $mablagh_baskul=str_replace(",","",$mablagh_baskul);
  $edit_q=("UPDATE $TableName SET 
           tarikh_resid='$tarikh_resid',noe_tahvil_bar='$noe_tahvil_bar',code_skk='$code_skk',
		   id_safar='$id_safar',code_mabda='$code_mabda',code_ostan_mabda='$code_ostan_mabda',code_anbar_mabda='$code_anbar_mabda',
		   code_takhlie='$code_takhlie',shomare_container='$shomare_container',bsk_no='$bsk_no',barname_no='$barname_no',barname_tarikh='$barname_tarikh',
		   plak1='$plak1',plak2='$plak2',plak3='$plak3',plak4='$plak4',ranande_name='$ranande_name',ranande_melicode='$ranande_melicode',shomare_hesab_ranande='$shomare_hesab_ranande',bank_ranande='$bank_ranande',ranande_mobile='$ranande_mobile',
		   code_peymankar_haml='$code_peymankar_haml',shomare_polomp='$shomare_polomp',vaziyat_polomp='$vaziyat_polomp',vazn_kamiyon_bar='$vazn_kamiyon_bar',vazn_kamiyon='$vazn_kamiyon',noe_khodro='$noe_khodro',
		   noe_pardakht='$noe_pardakht',mablagh_kerayemabda='$mablagh_kerayemabda',mablagh_haghetavaghof='$mablagh_haghetavaghof',mablagh_baskul='$mablagh_baskul',amel_p_accnting_code='$amel_p_accnting_code',shomare_govahi_behdashti='$shomare_govahi_behdashti',
		   shomare_sabt_sefaresh='$shomare_sabt_sefaresh',shomare_kotazh='$shomare_kotazh',tarikh_vorud='$tarikh_vorud',tozihat='$tozihat',tozih_ebtal_resid='$tozih_ebtal_resid'
           WHERE id='$id_';");
  //$vazn_khales_r=$vazn_kamiyon_bar-$vazn_kamiyon;
  //$kasry_kol=$vazn_mabda_r-$vazn_khales_r;if($kasry_kol<0){$kasry_kol=0;}
  //$kasry_gheyremojaz=$kasry_kol-$kasry_mojaz_r;if($kasry_gheyremojaz<0){$kasry_gheyremojaz=0;}
  //$vazn_ezafe=$vazn_khales_r-$vazn_mabda_r;if($vazn_ezafe<0){$vazn_ezafe=0;}
  //$mablagh_jarimekasry=$kasry_gheyremojaz*$fee_this;
  //$mablagh_ezafebar=$vazn_ezafe*$fee_this;
  //$mablagh_pardakhty=$mablagh_kerayemabda-$mablagh_jarimekasry+$mablagh_haghetavaghof-$mablagh_baskul-$mablagh_takhlie+$mablagh_ezafebar;		   
  //$update_mojody=$mojody+$vazn_khales_r;//آپدیت موجودی کالا در جدول موجودی کالا
  //$res_update_mojody=$db->query("UPDATE mojody_kala SET mojody='$update_mojody' WHERE code_kala='$code_kala' AND code_ostan='".$_SESSION['code_ostan']."' AND code_anbar='".$_SESSION['code_anbar']."';");	   
  $edit_res=mysql_query($edit_q);
  if(($edit_res) and (mysql_affected_rows()!=0))
  { 
    if(($noe_tahvil_bar==4)or($noe_tahvil_bar==5))//جابه جایی
	{
	  $q11="SELECT barname_from_resid FROM havale WHERE shomare_havale_anbar='$shomare_havale_anbar' AND code_ostan='$code_ostan_mabda' AND code_anbar='$code_anbar_mabda' AND year='$mtActiveYear'";
	  $res11=mysql_query($q11);
      $row11=mysql_fetch_assoc($res11);
	  if($row11['barname_from_resid']==1)$update_havale=$db->query("UPDATE havale SET shomare_barname_h='$barname_no',tarikh_barname_h='$barname_tarikh',barname_from_resid=1 WHERE code_ostan='$code_ostan_mabda' AND code_anbar='$code_anbar_mabda' AND year='$mtActiveYear' AND shomare_havale_anbar='$shomare_havale_anbar'");
	}
	$log_e=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_','ویرایش',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')"); /*کوئری لاگ*/  
    echo "<script>window.location='resid.php?PageNo=".$PageNo."&RowPerPage=".$RowPerPage."&order=".$order."';</script>";   
  }
  else if(mysql_affected_rows()==0)  $message ='';
  else $message ='<span style=" color:red;font: bold 12px tahoma;"> * مشکلی در ویرایش مشخصات به وجود آمده است ! *</span>';   
 }
}
/*************END*****************/
echo'	
'.$message.'
<br/>
<br/>
</form>
</body>
</html>';	
?>