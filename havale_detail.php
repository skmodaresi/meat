<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="havale_detail.php";
$TableName="havale_detail";
$right_ins=0;$right_edt=0;$right_del=0;
if (right(177)) $right_ins=1;
if (right(178)) $right_edt=1;
if (right(179)) $right_del=1;
$today=AsLDate($yymmdd);
if(($noe_tahvil_bar_==4)or($noe_tahvil_bar_==5)or($noe_tahvil_bar_==7)or($noe_tahvil_bar_==9))//اگر نوع تحویل بار جابهجایی  بود
{ 
   $q_jabejae=("SELECT m_j.shomare_jabejae,m_j.meghdar_jabejae,m_j.mande_az_jabejae FROM $mydatabase.mojavez_jabejae m_j WHERE m_j.shomare_jabejae='".$shomare_jabejae_."' AND m_j.code_ostan='$mt_gl_code_ostan' AND m_j.code_anbar='$mt_gl_code_anbar' AND m_j.year='$mtActiveYear' AND m_j.deleted=0");	
   $res_jabejae=$db->query($q_jabejae);
   $row_jabejae=$db->fetch_assoc($res_jabejae);
   $meghdar_jabejae=$row_jabejae['meghdar_jabejae'];
   $mande_az_jabejae=$row_jabejae['mande_az_jabejae'];
}
else
{   
 //اگر سیستم سردخانه
 if($_SESSION['mt_systemforush']==0)
 { 
 //بدست آوردن مقدار اولیه ومانده از حواله فروش
  $q_havale_forush="SELECT meghdar_havale_forush,mande_az_forush FROM $mydatabase.havale_forush WHERE h_code='$h_code_' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear'";
  $res_havale_forush=$db->query($q_havale_forush);
  $row_havale_forush=$db->fetch_assoc($res_havale_forush);
  $meghdar_havale_forush=$row_havale_forush['meghdar_havale_forush'];
  $mande_az_forush=$row_havale_forush['mande_az_forush'];
 }
 //اگر سیستم فروش  
 if($_SESSION['mt_systemforush']==1)
 {  
  //بدست آوردن مقدار اولیه ومانده از حواله فروش
   $q_havale_forush="SELECT h_pre_amount,h_mande_havale FROM sell.dm_havale WHERE h_code='$h_code_' AND h_id_province='$sell_id_ostan' AND h_l_code='$sell_id_anbar' AND h_id_year='$sellYearId'";
   $res_havale_forush=$db->query($q_havale_forush);
   $row_havale_forush=$db->fetch_array($res_havale_forush);
   $meghdar_havale_forush=$row_havale_forush['h_pre_amount'];
   $mande_az_forush=$row_havale_forush['h_mande_havale'];
   $detail_forush=$db->get_from_where("COUNT(*)","sell.dm_havale INNER JOIN sell.dm_pish_havale_det ON h_phd_id=phd_id INNER JOIN sell.dm_anbar_det ON dad_phd_id=phd_id","h_code=$h_code_ AND h_id_province=$sell_id_ostan AND h_l_code=$sell_id_anbar AND h_id_year=$sellYearId");
 } 
}  
/***********************************************************************/    
//بسته بندی این کالا در جدول بسته بندی
$code_bastebandy=$db->get_from_where("code_bastebandy","$mydatabase.kala","code_kala='$code_kala_'");
$nameKALA=$db->get_from_where("name_kala","$mydatabase.kala","code_kala=$code_kala_");
/*havale خواندن اطلاعات جدول*/
$havale_status=$db->get_from_where("status","$mydatabase.havale","shomare_havale_anbar='$shomare_havale_anbar_' AND code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND year=$mtActiveYear");
$havale_tarikh=$db->get_from_where("tarikh_havale_anbar","$mydatabase.havale","shomare_havale_anbar='$shomare_havale_anbar_' AND code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND year=$mtActiveYear");
$sabtNahayi=$db->get_from_where("sabt_nahayi","$mydatabase.havale","shomare_havale_anbar='".$shomare_havale_anbar_."' AND code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND year=$mtActiveYear");     
echo'
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>افزودن جزئیات کالای '.$nameKALA.' به حواله</title>
<link href="styles.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="functions.js"></script>
<script type="text/javascript" src="scripts/jquery-1.6.2.min.js"></script>
<script type="text/javascript">
function PopupCenter(url,w,h)
{
   var left = Number((screen.width/2)-(w/2));
   var tops = Number((screen.height/2)-(h/2));
   window.open(url,"blank","width=" + w + ",height= " + h + ",top=" + tops + ",left=" + left +",scrollbars=1");
}
function enterIE()
{
   if(window.event.keyCode == 13 && window.event.srcElement.id != \'sabt\')
   window.event.keyCode = 9;
} 
function getDetailKala2(code_kala)<!--اطلاعات کالا-->
{ 
    $("#loading").fadeIn("fast");
    $.post("ajax.php",{codeKALA2:code_kala},function(data){			 		 
			  var splKala = data.split("^");
			  $("#name_kala").val(splKala[0]);
			  $("#sharh_bastebandy").val(splKala[2]);
			  $("#id_gheymat_this").val(splKala[3]);
			  $("#fee_this").val(splKala[4]);
			  $("#zarib_this").val(splKala[5]);
			  $("#nerkh_takhlie_this").val(splKala[6]);
		 });
    $("#loading").fadeOut("fast");
}
function getDetailKeshvar(code_keshvar)<!--اطلاعات کشور-->
{ 
    $("#loading").fadeIn("fast");
    $.post("ajax.php",{codeKESHVAR : code_keshvar},function(data){$("#name_keshvar").val(data);});
    $("#loading").fadeOut("fast");
}
function getVaznKarton(c_karton)<!-- اطلاعات کارتن-->
{
   $("#loading").fadeIn("fast");  
   $.post("ajax.php",{codeKARTON: c_karton},function(data){
		   var splKarton = data.split("^");
		   $("#vazn_karton_this").val(splKarton[1]);
		 });
   $("#loading").fadeOut("fast");	
}
function sumkarton()<!--محاسبه مجموع وزن کارتن ها در حواله-->
{
 var sum_k;
 sum_k=parseFloat((document.myform.vazn_karton_this.value)*(document.myform.tedad_karton_h_d.value)).toFixed(3);
 document.myform.sum_karton_h_d.value=sum_k;
}
function sumghooti()<!--محاسبه وزن قوطی ها-->
{
 var sum_k2;
 sum_k2=parseFloat((document.myform.vazn_karton_this.value)*(document.myform.tedad_karton_h_d.value)).toFixed(3);
 document.myform.vazn_khales_h_d.value=sum_k2;
}
function vazn_khales_havale()<!--محاسبه وزن خالص حواله-->
{
 var natije_vazn;
 var natije_mablaghBar;
 natije_vazn=parseFloat((document.myform.vazn_nakhales_h_d.value)-(document.myform.sum_karton_h_d.value)).toFixed(3);                                      
 //natije_mablaghBar=(natije_vazn)*(Number(document.myform.nerkh_bargiry_this.value));                                       
 if(natije_vazn<0) natije_vazn=0;
 document.myform.vazn_khales_h_d.value=natije_vazn;
 //document.myform.mablagh_bargiry.value=natije_mablaghBar;
}
function shane_to_karton()<!--محاسبه تعداد کارتن از تعداد شانه-->
{
 var tedad_k;
 tedad_k=Number((document.myform.tedad_shane_h_d.value)/12).toFixed(0);
 document.myform.tedad_karton_h_d.value=tedad_k;
}
function shane_to_karton_dakheli()<!--محاسبه تعداد کارتن از تعداد شانه-->
{
 var tedad_k;
 tedad_k=Number((document.myform.tedad_shane_h_d.value)/6).toFixed(0);
 document.myform.tedad_karton_h_d.value=tedad_k;
}
</script>
</head>';
if(!(isset($Mode))) $Mode='';
$cnt=$db->get_from_where("COUNT(*)","$mydatabase.$TableName","shomare_havale_anbar='$shomare_havale_anbar_' AND code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND year=$mtActiveYear");
/******************** Insert- Edit- Delete ************/
/************EDIT BUTTON********/// اصلاح اطلاعات
if (isset($Edit_x_detail))
{
 if(isPermitEdit($code_kala,$code_keshvar,$code_karton,$vazn_mabda_r_d,$shomare_havale_anbar_,$id_,$mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear))
 {
  $Mode=''; 
  $edit_q=("UPDATE $mydatabase.$TableName SET code_kala='$code_kala',code_keshvar='$code_keshvar',id_gheymat_this='$id_gheymat_this',
                   fee_this='$fee_this',zarib_this='$zarib_this',nerkh_takhlie_this='$nerkh_takhlie_this',vazn_mabda_r_d='$vazn_mabda_r_d',
                   kasry_mojaz_r_d='$kasry_mojaz_r_d',code_karton='$code_karton',vazn_karton_this='$vazn_karton_this'
                   WHERE `id`='$id_';");	
  $edit_res=$db->query($edit_q,'مشکلي در ويرايش مشخصات به وجود آمده است');
  $log_e=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_','ویرایش',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')");  
 } 
}
/************DELETE BUTTON********/// حذف جزئیات کالا از حواله
if(isset($Delete_x_detail))
{
  $Mode='';
  mysql_query('SET AUTOCOMMIT=0');//TRANSACTIONشروع 
  mysql_query('START TRANSACTION');
  $del_q="DELETE FROM $mydatabase.$TableName WHERE id=$id_";
  $del_res = mysql_query($del_q);
  /*لاگ*/$log_d=$db->query("INSERT INTO $mydatabase.log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_','حذف',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')");	
  //آپدیت تعداد کارتن و وزن ناخالص و وزن خالص حواله 
   $tedad_karton_h=$db->get_from_where("tedad_karton_h","$mydatabase.havale","shomare_havale_anbar='$shomare_havale_anbar_' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0 AND status=0");   
   $vazn_nakhales_h=$db->get_from_where("vazn_nakhales_h","$mydatabase.havale","shomare_havale_anbar='$shomare_havale_anbar_' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0 AND status=0");   
   $vazn_khales_h=$db->get_from_where("vazn_khales_h","$mydatabase.havale","shomare_havale_anbar='$shomare_havale_anbar_' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0 AND status=0");
   $update_tedad_karton_h=$tedad_karton_h-$tedad_karton_h_d_;
   $update_vazn_nakhales_h=round(floatval($vazn_nakhales_h-$vazn_nakhales_h_d_),3);
   $update_vazn_khales_h=round(floatval($vazn_khales_h-$vazn_khales_h_d_),3);
   $res_update_havale=$db->query("UPDATE $mydatabase.havale SET tedad_karton_h='$update_tedad_karton_h',vazn_nakhales_h='$update_vazn_nakhales_h',vazn_khales_h='$update_vazn_khales_h' WHERE shomare_havale_anbar='$shomare_havale_anbar_' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0");       
   //خواندن موجودی با استفاده از تابع 
   IF($noe_tahvil_bar_==9)//تحت کلید
   {
    $update_tedad_karton=mojodyKarton($mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear,$code_ziranbar_,$code_kala_,$code_keshvar_,$code_tolidkonande_,$sal_tolid_shamsi_,$mah_tolid_shamsi_,$rouz_tolid_shamsi_,$code_karton_,$code_mandegari_,2);
    $update_mojody_nakhales=mojodyNakhales($mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear,$code_ziranbar_,$code_kala_,$code_keshvar_,$code_tolidkonande_,$sal_tolid_shamsi_,$mah_tolid_shamsi_,$rouz_tolid_shamsi_,$code_karton_,$code_mandegari_,2);
    $update_mojody_khales=mojodyKhales($mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear,$code_ziranbar_,$code_kala_,$code_keshvar_,$code_tolidkonande_,$sal_tolid_shamsi_,$mah_tolid_shamsi_,$rouz_tolid_shamsi_,$code_karton_,$code_mandegari_,2);
   }
   ELSE //سایر
   {
    $update_tedad_karton=mojodyKarton($mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear,$code_ziranbar_,$code_kala_,$code_keshvar_,$code_tolidkonande_,$sal_tolid_shamsi_,$mah_tolid_shamsi_,$rouz_tolid_shamsi_,$code_karton_,$code_mandegari_);
    $update_mojody_nakhales=mojodyNakhales($mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear,$code_ziranbar_,$code_kala_,$code_keshvar_,$code_tolidkonande_,$sal_tolid_shamsi_,$mah_tolid_shamsi_,$rouz_tolid_shamsi_,$code_karton_,$code_mandegari_);
    $update_mojody_khales=mojodyKhales($mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear,$code_ziranbar_,$code_kala_,$code_keshvar_,$code_tolidkonande_,$sal_tolid_shamsi_,$mah_tolid_shamsi_,$rouz_tolid_shamsi_,$code_karton_,$code_mandegari_);
   }
   $update_tedad_shane=$update_tedad_karton*$_SESSION["mtShane"];
   IF($noe_tahvil_bar_==9)//تحت کلید
	   $table_mojody='mojody_kala_gomrok';//تحت کلید گمرک
   ELSE//سایر
	  $table_mojody='mojody_kala';
   //آپدیت موجودی کالا
   $res_update_mojody=$db->query("UPDATE $mydatabase.$table_mojody SET mojody_khales=$update_mojody_khales,mojody_nakhales=$update_mojody_nakhales,tedad_karton=$update_tedad_karton,tedad_shane=$update_tedad_shane WHERE code_kala=$code_kala_ AND code_keshvar=$code_keshvar_ AND code_tolidkonande='$code_tolidkonande_' AND sal_tolid_shamsi='$sal_tolid_shamsi_' AND mah_tolid_shamsi='$mah_tolid_shamsi_' AND rouz_tolid_shamsi='$rouz_tolid_shamsi_' AND code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND code_ziranbar='$code_ziranbar_' AND code_karton='$code_karton_' AND code_mandegari='$code_mandegari_' AND year=$mtActiveYear AND deleted=0");      	
   /*لاگ موجودی*/
   if($res_update_mojody) {$log_m_e=$db->query("INSERT INTO $mydatabase.log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$table_mojody','$idMojody','حذف جزئیات کالا در حواله و برگشت موجودی',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')"); /*کوئری لاگ*/}	   
   if(($noe_tahvil_bar_==4)or($noe_tahvil_bar_==5)or($noe_tahvil_bar_==7)or($noe_tahvil_bar_==9))//جابه جایی و تحت کلید
   {
    $mande_az_jabejae_again=$db->get_from_where("mande_az_jabejae","$mydatabase.mojavez_jabejae","code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND shomare_jabejae='$shomare_jabejae_'");   
	// بسته بندی قوطی یا دست یا عدد تعداد را اضافه می کنیم
    if(($code_bastebandy==2)or($code_bastebandy==5)or($code_bastebandy==6))$update_mande_j=$mande_az_jabejae_again+$tedad_karton_h_d_;
	//تخم مرغ شانه را اضافه میکنیم
	else if (($code_kala_==50)or($code_kala_==54))$update_mande_j=$mande_az_jabejae_again+$tedad_shane_h_d_;
	//سایر بسته بندی ، وزن را اضافه می کنیم
	else $update_mande_j=round(floatval($mande_az_jabejae_again+$vazn_khales_h_d_),3); 

	$res_update_mande_j=$db->query("UPDATE $mydatabase.mojavez_jabejae SET mande_az_jabejae='$update_mande_j' WHERE shomare_jabejae='$shomare_jabejae_' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0");    
	if($res_update_mande_j){$log_mande_j_e=$db->query("INSERT INTO $mydatabase.log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','mojavez_jabejae','$idJabejae_','حذف جزئیات کالا در حواله و برگشت مانده از مجوز جابه جایی',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')"); /*کوئری لاگ*/}
   }
   else//اگر نوع تحویل جابه جایی نباشد
   {
	    /**اگر به فروش متصل نیستیم**/
	    if($_SESSION['mt_systemforush']==0)
	    {  
          //آپدیت مانده مقدار حواله فروش در جدول حواله فروش سیستم انبار
		  $mande_az_forush_again=$db->get_from_where("mande_az_forush","$mydatabase.havale_forush","code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND h_code='$h_code_'"); 
	      // بسته بندی قوطی یا دست یا عدد تعداد را اضافه می کنیم
		  if(($code_bastebandy==2)or($code_bastebandy==5)or($code_bastebandy==6))$update_mande=round(floatval($mande_az_forush_again+$tedad_karton_h_d_),3); 
		  //تخم مرغ شانه را اضافه میکنیم
		  else if(($code_kala_==50)or($code_kala_==54))$update_mande=round(floatval($mande_az_forush_again+$tedad_shane_h_d_),3); 
		  //سایر بسته بندی ، وزن را اضافه می کنیم
		  else $update_mande=round(floatval($mande_az_forush_again+$vazn_khales_h_d_),3);
		  $res_update_mande=$db->query("UPDATE $mydatabase.havale_forush SET mande_az_forush='$update_mande' WHERE h_code='$h_code_' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0");    
		  $log_mande_e=$db->query("INSERT INTO $mydatabase.log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','havale_forush','$idForush_','حذف جزئیات کالا در حواله و برگشت مانده از فروش در سردخانه',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')"); /*کوئری لاگ*/
		}
	    /**اگر به فروش متصل هستیم**/
	    else if($_SESSION['mt_systemforush']==1)
	    {  
		   $mande_az_forush_again=$db->get_from_where("h_mande_havale","sell.dm_havale","h_id='$idForush_'");
	      //آپدیت مانده مقدار حواله فروش در جدول حواله فروش سیستم فروش
	       	// بسته بندی قوطی یا دست یا عدد تعداد را اضافه می کنیم
		   if(($code_bastebandy==2)or($code_bastebandy==5)or($code_bastebandy==6))$update_mande=round(floatval($mande_az_forush_again+$tedad_karton_h_d_),3); 
           //تخم مرغ شانه را اضافه میکنیم
		   else if(($code_kala_==50)or($code_kala_==54))$update_mande=round(floatval($mande_az_forush_again+$tedad_shane_h_d_),3); 
		   //سایر بسته بندی ، وزن را اضافه می کنیم
		   else $update_mande=round(floatval($mande_az_forush_again+$vazn_khales_h_d_),3); 
           
		   $res_update_mande=$db->query("UPDATE sell.dm_havale SET h_mande_havale='$update_mande' WHERE h_id='$idForush_'");    
		   $log_mande_e=$db->query("INSERT INTO $mydatabase.log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','havale_forush','$idForush_','حذف جزئیات کالا در حواله و برگشت مانده از فروش در فروش',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')"); /*کوئری لاگ*/
	    }
    }
   if(($del_res and $log_d and $res_update_havale and $res_update_mojody and $log_m_e and $res_update_mande_j and $log_mande_j_e)or($del_res and $log_d and $res_update_havale and $res_update_mojody and $log_m_e and $res_update_mande and $log_mande_e))
   {
      mysql_query("COMMIT"); 
   }
   else
   {
	 mysql_query('ROLLBACK');//nothing will be done, I assume it's for testing
	 $message ='<span style=" color:red;font: bold 12px tahoma;"> * مشکلی در حذف به وجود آمده است ! *</span>';
   }
  mysql_query('SET AUTOCOMMIT=1');  
}
/***************************************** MAIN*****************************************/
//قرار گرفتن فوکوس 
if ($Mode=="Insert") $load="document.myform.code_kala.focus();";
if ($Mode=="Edit") $load="document.myform.vazn_nakhales.focus();";
if(strlen($mt_gl_code_ostan)==1) $code_a=make_pattern($mt_gl_code_ostan,2);
else $code_a=$mt_gl_code_ostan;
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="'.$load.'">
<form method="post" name="myform" onkeydown="enterIE();">
<div align="center">
<table width="99%" height="100%" align="center" cellpadding="0" cellspacing="0">
 <img src="images/loading.gif" id="loading" class="loading_img"/>
 <!--هدر-->
 <tr>
  <td class="title">افزودن جزئیات کالای '.$nameKALA.' به حواله ی '.$code_a.$mt_gl_code_anbar.$shomare_havale_anbar_.'</td>
 </tr>
  <div style="position:absolute;top:2px;left:10px;">
   <a class="tooltips" href="#"><img class="help" border="0" src="images/button-round-question-icon.png" style="cursor:pointer" onmouseOver="this.src=\'images/button-round-dark-question-icon.png\'" onmouseOut="this.src=\'images/button-round-question-icon.png\'"/>
	<span>';
	  if(($noe_tahvil_bar_==4)or($noe_tahvil_bar_==5)or($noe_tahvil_bar_==7)){echo'مقدار مانده از مجوز جابه جایی : '.round($mande_az_jabejae,3).'';}
      else {echo'مقدار مانده از حواله فروش : '.round($mande_az_forush,3).'';}
	 echo' 
	</span></a>
	<!--<a href="#" class="tooltip-right" data-tooltip="I’m the tooltip text"><img class="help" border="0" src="images/button-round-question-icon.png" style="cursor:pointer" onmouseOver="this.src=\'images/button-round-dark-question-icon.png\'" onmouseOut="this.src=\'images/button-round-question-icon.png\'"/></a>-->
  </div>
 <!--پايان هدر-->
 <!-- مرکز صفحه--> 
 <tr>
  <td height="100%">
   <table width="100%"  height="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
	<tr class="table-title">	 
	 <td rowspan="2">زیرانبار</td>
	 <td rowspan="2">کشور</td>
	 <td rowspan="2">تولیدکننده</td>
	 <td colspan="3">تاریخ تولید</td>
	 <td rowspan="2">تاریخ ماندگاری</td>';
	 if($code_bastebandy==1)//کارتنی
	 {echo'
	  <td rowspan="2">کد کارتن</td>
	  <td rowspan="2">وزن کارتن</td>
	  <td rowspan="2">تعداد کارتن</td>';
	  if(($code_kala_==50)or($code_kala_==54)) echo'<td rowspan="2">تعداد شانه</td>'; 
	  echo'
	  <td rowspan="2">وزن ناخالص</td>
	  <td rowspan="2">وزن خالص</td>';
	 }
	 else if($code_bastebandy==2)//قوطی
	 {echo'
	  <td rowspan="2">کد قوطی</td>
	  <td rowspan="2">وزن فوطی</td>
	  <td rowspan="2">تعداد قوطی</td>
	  <td rowspan="2">وزن خالص</td>';
	 }
	 else if(($code_bastebandy==5)OR($code_bastebandy==6))// دست یا عدد
	 {echo'
	  <td rowspan="2">تعداد</td>';
	 }
	 else //لاشه و سایر
	 {echo'
	  <td rowspan="2">تعداد</td>
	  <td rowspan="2">وزن خالص</td>';
	 }
	 //اگر اجازه حذف دارد،حواله ابطالی نیست وسال فعال است و ثبت نهایی نشده است
	 if(($right_del)and($havale_status==0)and($_SESSION['mtStatusYear']==0)and($sabtNahayi==0)) echo'<td rowspan="2">حذف</td>';
	 else echo'';
	echo'
	 <tr class="table-title">
	  <td>سال</td>
	  <td>ماه</td>
	  <td>روز</td>
	 </tr>
	</tr>';
	$i=0;
    $majmo_vazn_nakhales=0;	
    $majmo_tedad_karton=0;	
    $majmo_sum_karton_h_d=0;	
    $majmo_vazn_khales_h_d=0;	
    $q1="SELECT $mydatabase.$TableName.*,kala.name_kala,keshvar.code_keshvar,keshvar.name_keshvar,tolidkonande.code_tolidkonande,tolidkonande.name_tolidkonande,l_s_d.noe_ziranbar,l_s_d.name_ziranbar,karton.code_karton,karton.vazn_karton,sharh_mandegari From $TableName
         INNER JOIN $mydatabase.kala ON $TableName.code_kala=kala.code_kala
         INNER JOIN $mydatabase.keshvar ON $TableName.code_keshvar=keshvar.code_keshvar
         LEFT  JOIN  $mydatabase.karton ON $TableName.code_karton=karton.code_karton
         INNER JOIN $mydatabase.tolidkonande ON $TableName.code_tolidkonande=tolidkonande.code_tolidkonande
         INNER JOIN $mydatabase.list_sardkhane_detail l_s_d ON $TableName.code_ziranbar=l_s_d.code_ziranbar AND $TableName.code_ostan=l_s_d.code_ostan AND $TableName.code_anbar=l_s_d.code_anbar  	  
	     INNER JOIN $mydatabase.tarikh_mandegari ON $TableName.code_mandegari=tarikh_mandegari.code_mandegari
		 WHERE $TableName.shomare_havale_anbar='$shomare_havale_anbar_' AND $TableName.code_kala='$code_kala_' AND $TableName.code_ostan='$mt_gl_code_ostan' AND $TableName.code_anbar='$mt_gl_code_anbar' AND $TableName.year='$mtActiveYear' order by id desc";
	
	$all = $db->query($q1);
    while($row1=$db->fetch_assoc($all))
	{
	 if($i++%2){echo'<tr '; if($row1['status']==0) echo' class="table-odd"'; else echo 'class="row-ebtal"';echo' style="cursor:default;">';}	 
	 else{echo'<tr '; if($row1['status']==0) echo' class="table-even"'; else echo 'class="row-ebtal"';echo' style="cursor:default;">';}
	 echo'
	  <td >'.$row1['name_ziranbar'].'</td>
	  <td >'.$row1['name_keshvar'].'</td>
	  <td >'.$row1['name_tolidkonande'].'</td>
	  <td >'.$row1['sal_tolid_shamsi'].'</td>
	  <td >'.$mahshamsiArr[$row1['mah_tolid_shamsi']].'</td>
	  <td >'.$row1['rouz_tolid_shamsi'].'</td>
	  <td >'.$row1['sharh_mandegari'].'</td>';
	  if(($code_bastebandy==1)OR($code_bastebandy==2))
	  {echo'
	   <td >'.$row1['code_karton'].'</td>
	   <td >'.$row1['vazn_karton_this'].'</td>';
	  }
      echo'<td >'.$row1['tedad_karton_h_d'].'</td>';
	  if(($code_kala_==50)or($code_kala_==54)) echo'<td>'.$row1['tedad_shane_h_d'].'</td>'; 
	  if($code_bastebandy==1)echo'<td >'.round($row1['vazn_nakhales_h_d'],3).'</td>';
	  if(($code_bastebandy!=5)AND($code_bastebandy!=6))echo'<td >'.round($row1['vazn_khales_h_d'],3).'</td>';
	  //اطلاعات موجودی برای حذف
	  IF($noe_tahvil_bar_==9)//تحت کلید
	   $table_mojody='mojody_kala_gomrok';//تحت کلید گمرک
	  ELSE//سایر
	   $table_mojody='mojody_kala';
	  $q_mo="SELECT id,tedad_karton,mojody_nakhales,mojody_khales From $mydatabase.$table_mojody m_k WHERE m_k.code_kala=".$row1['code_kala']." AND m_k.code_keshvar=".$row1['code_keshvar']." AND m_k.sal_tolid_shamsi=".$row1['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row1['mah_tolid_shamsi']." AND m_k.code_ostan='$mt_gl_code_ostan' and m_k.code_anbar='$mt_gl_code_anbar' AND m_k.year='$mtActiveYear' AND m_k.deleted=0";
	  $all_mo=$db->query($q_mo);
      $row_mo=$db->fetch_assoc($all_mo);
      if(($right_del)and($row1['status']==0)and($_SESSION['mtStatusYear']==0)and($sabtNahayi==0))	  
	  {echo'<td style="cursor:pointer;"><img border="0" class="1" src="images/trash.png" width="20" height="20" title="حذف" 
	       onmouseOver="this.src=\'images/trash_hover.png\'" onmouseOut="this.src=\'images/trash.png\'" 
		   onClick="iconfirm(\''.$FileName.'?Delete_x_detail=1&id_='.$row1['id'].'&shomare_havale_anbar_='.$shomare_havale_anbar_.'&code_ziranbar_='.$row1['code_ziranbar'].'&code_kala_='.$row1['code_kala'].'&noe_tahvil_bar_='.$noe_tahvil_bar_.'&code_keshvar_='.$row1['code_keshvar'].'&code_tolidkonande_='.$row1['code_tolidkonande'].'&sal_tolid_shamsi_='.$row1['sal_tolid_shamsi'].'&mah_tolid_shamsi_='.$row1['mah_tolid_shamsi'].'&rouz_tolid_shamsi_='.$row1['rouz_tolid_shamsi'].'&code_karton_='.$row1['code_karton'].'&code_mandegari_='.$row1['code_mandegari'].'&tedad_karton_h_d_='.$row1['tedad_karton_h_d'].'&vazn_nakhales_h_d_='.$row1['vazn_nakhales_h_d'].'&vazn_khales_h_d_='.$row1['vazn_khales_h_d'].'&idMojody='.$row_mo['id'].'&idForush_='.$idForush_.'&h_code_='.$h_code_.'&idJabejae_='.$idJabejae_.'&shomare_jabejae_='.$row1['shomare_jabejae'].'&tedad_shane_h_d_='.$row1['tedad_shane_h_d'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\',\'برای حذف کالای '.$row1['name_kala'].' با تاریخ تولید '.$row1['rouz_tolid_shamsi'].' '.$mahshamsiArr[$row1['mah_tolid_shamsi']].' '.$row1['sal_tolid_shamsi'].' از حواله '.$code_a.$row1['code_anbar'].$shomare_havale_anbar_.' \')" /></td>';
	  }
	echo'
	</tr>';
	$majmo_tedad_karton+=$row1['tedad_karton_h_d'];   
	$majmo_tedad_shane+=$row1['tedad_shane_h_d'];   
    if($code_bastebandy==1)$majmo_vazn_nakhales+=$row1['vazn_nakhales_h_d'];
	$majmo_vazn_khales+=$row1['vazn_khales_h_d'];
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
      <td>&nbsp;</td>';
      if(($code_bastebandy!=5)AND($code_bastebandy!=6))echo'<td>&nbsp;</td>';
	  if(($code_bastebandy==1)OR($code_bastebandy==2))echo'<td>&nbsp;</td><td>&nbsp;</td>';
	  if($code_bastebandy==1)echo'<td>&nbsp;</td>';
	  if(($code_kala_==50)or($code_kala_==54))echo'<td>&nbsp;</td>';
	  if(($right_del)and($havale_status==0)and($_SESSION['mtStatusYear']==0)and($sabtNahayi==0))echo'<td>&nbsp;</td>';
	 echo'
	 </tr>';
	}
	echo'
	<tr class="table-title"> 
	 <td';if(($code_bastebandy==1)OR($code_bastebandy==2)) echo' colspan="9" ';else echo' colspan="7" ';echo'>مجموع مقادیر</td>
	 <td>'.$majmo_tedad_karton.'</td>';
	 if(($code_kala_==50)or($code_kala_==54))echo'<td>'.$majmo_tedad_shane.'</td>';
	 if($code_bastebandy==1)echo'<td>'.round($majmo_vazn_nakhales,3).'</td>';
	 if(($code_bastebandy!=5)AND($code_bastebandy!=6))echo'<td>'.round($majmo_vazn_khales,3).'</td>';
	 if(($right_del)and($havale_status==0)and($_SESSION['mtStatusYear']==0)and($sabtNahayi==0))echo'<td>&nbsp;</td>';
	 echo'
	</tr>';
	echo'
   </table>
  </td>
 </tr> 
 <!--پايان مرکز صفحه -->
 <!-- فوتر-->
 <tr class="footer">
  <td>
   <table border="0" cellspacing="0" cellpadding="0" height=100%  style="margin-bottom:20px;">';
   if(!$Mode)
   {echo '	  			
	<tr>
     <td width="10px">&nbsp;</td>';
	 //اگر اجازه ایجاد رسید را دارد و وضعیت سال فعال است و سال فعال سال جاری است
	 //if(($right_ins)and($havale_status==0)and($_SESSION['mtStatusYear']==0)and($havale_tarikh=='1399/12/30')and($sabtNahayi==0))
	 $sal_jari=substr($today,0,4);//سال فعلی 
     IF($sal_jari!=$mtActiveYear)//اگر سال فعلی با سالی که الان درونش هستیم متفاوت است
	   $tarikh_payan=$db->get_from_where("end_to","$mydatabase.mt_docs","year=$mtActiveYear AND status=0");	 
     if(($right_ins)and($havale_status==0)and($havale_tarikh==$tarikh_payan)and($sabtNahayi==0))
     {
	  echo'<td width="70px"><div onClick="window.location=\''.$FileName.'?Mode=Insert&shomare_havale_anbar_='.$shomare_havale_anbar_.'&code_kala_='.$code_kala_.'&noe_tahvil_bar_='.$noe_tahvil_bar_.'&h_code_='.$h_code_.'&idForush_='.$idForush_.'&shomare_jabejae_='.$shomare_jabejae_.'&idJabejae_='.$idJabejae_.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-new" title="افزودن رکورد جديد" ><a href="#"></a></div></td>
 	       <td width="10px">&nbsp;</td>';
	 }
	 if(($right_ins)and($havale_status==0)and($_SESSION['mtStatusYear']==0)and($havale_tarikh==$today)and($sabtNahayi==0))
     {
	  echo'<td width="70px"><div onClick="window.location=\''.$FileName.'?Mode=Insert&shomare_havale_anbar_='.$shomare_havale_anbar_.'&code_kala_='.$code_kala_.'&noe_tahvil_bar_='.$noe_tahvil_bar_.'&h_code_='.$h_code_.'&idForush_='.$idForush_.'&shomare_jabejae_='.$shomare_jabejae_.'&idJabejae_='.$idJabejae_.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-new" title="افزودن رکورد جديد" ><a href="#"></a></div></td>
 	       <td width="10px">&nbsp;</td>';
	 }
     $detailkalacount=$db->get_from_where("count(*)","$mydatabase.havale_detail","shomare_havale_anbar='".$shomare_havale_anbar_."' AND code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND year=$mtActiveYear");
  	 if(($havale_status==0)and($detailkalacount!=0)and($sabtNahayi==0))//اگررسید ابطالی نیست و جزئیات دارد و ثبت نهایی نشده است  
	 {echo'
	  <td width="70px"><div onClick="window.location=\''.$FileName.'?shomare_havale_anbar_='.$shomare_havale_anbar_.'&code_kala_='.$code_kala_.'&noe_tahvil_bar_='.$noe_tahvil_bar_.'&h_code_='.$h_code_.'&idForush_='.$idForush_.'&shomare_jabejae_='.$shomare_jabejae_.'&idJabejae_='.$idJabejae_.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&send_havale=1&sabt_havale=1\'" id="sabt-nahayi" title="ثبت نهایی حواله" ><a href="#"></a></div></td>
	  <td width="10px">&nbsp;</td>';
	 }
	 echo'
	 <td width="70px"><div onClick="window.location=\'havale.php?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-back"  title="بازگشت به حواله"><a href="#"></a></div></td> 
	</tr>
	<span class="tedadcover" align="center" style="height:29px;"> تعداد ['.$cnt.'] </span>';
   }
   if ($Mode=="Insert")//Insert Mode
   {
	echo '
    <tr> 
	 <td width="99%" class="borderall" style="position:absolute;bottom:10px;left:0.5%;">	 
	  <table width="100%" bgcolor="#E9F7FD" align="center" cellpadding="0" cellspacing="0" >
        <tr class="title" ><td colspan="11" align="center">افزودن جزئیات کالای '.$nameKALA.' به حواله شماره '.$code_a.$mt_gl_code_anbar.$shomare_havale_anbar_.'</td></tr>
        <tr><td>&nbsp;</td></tr>';	   
		IF($detail_forush>0)
		{
		 echo'
		 <tr>
	   	   <td align="center" colspan="10"><span class="star">*</span> انتخاب کالا از حواله فروش : &nbsp;
		   <img border="0" src="images/image(7).gif" onClick="PopupCenter(\'help_detail_forush.php?parent_page='.$FileName.'&h_code_='.$h_code_.'&code_bastebandy_='.$code_bastebandy.'\',850,400)" title="جزئیات حواله فروش" style="width:22px;height:22px;cursor:pointer" onmouseOver="this.src=\'images/image(8).gif\'" onmouseOut="this.src=\'images/image(7).gif\'"/></td>
	       <input type="hidden" id="id_mojody" name="id_mojody" value="'.$id_mojody.'"/>
	       <input type="hidden" id="dad_id" name="dad_id" value="'.$dad_id.'"/>
		 </tr>';
		}
		ELSE
		{
		 echo'
		 <tr>
	   	   <td align="center" colspan="10"><span class="star">*</span> انتخاب کالا از جدول موجودی کالا : &nbsp;';
		   IF($noe_tahvil_bar_==9) echo'<img border="0" src="images/image(7).gif" onClick="PopupCenter(\'help_mojodykalagomrok.php?parent_page='.$FileName.'&code_kala_='.$code_kala_.'&code_bastebandy_='.$code_bastebandy.'&shomare_havale_anbar_='.$shomare_havale_anbar_.'\',800,500)" title="جدول موجودی کالا" style="width:22px;height:22px;cursor:pointer" onmouseOver="this.src=\'images/image(8).gif\'" onmouseOut="this.src=\'images/image(7).gif\'"/>';
		   ELSE echo'<img border="0" src="images/image(7).gif" onClick="PopupCenter(\'help_mojodykala.php?parent_page='.$FileName.'&code_kala_='.$code_kala_.'&code_bastebandy_='.$code_bastebandy.'&shomare_havale_anbar_='.$shomare_havale_anbar_.'&idForush_='.$idForush_.'\',800,500)" title="جدول موجودی کالا" style="width:22px;height:22px;cursor:pointer" onmouseOver="this.src=\'images/image(8).gif\'" onmouseOut="this.src=\'images/image(7).gif\'"/>';
		   echo'
		    <input type="hidden" id="id_mojody" name="id_mojody" value="'.$id_mojody.'"/>
		   </td>
		 </tr>';
		}
		echo'
        <tr>		
		 <td align="left"> نام زیرانبار :&nbsp;</td><td align="right"><input type="hidden" name="code_ziranbar" value="'.$code_ziranbar.'"/><input class="textboxme2" type="text" readonly name="name_ziranbar" value="'.$name_ziranbar.'"/>
		 <td align="left"> تاریخ تولید شمسی  :&nbsp;</td>
		 <td align="right" colspan="3">
		        سال : <input class="textboxme2" type="text" name="sal_tolid_shamsi" value="'.$sal_tolid_shamsi.'" maxlength="4" readonly  style="width:40px;"/>
		        ماه : <input type="hidden" name="mah_tolid_shamsi" value="'.$mah_tolid_shamsi.'"/>'.static_listbox("mah_tolid_sh",$mah_tolid_shamsi,"mahshamsiArr",1,"class='text4' disabled").'		
		 	    روز : <input class="textboxme2 textbox50" type="text" name="rouz_tolid_shamsi" value="'.$rouz_tolid_shamsi.'" readonly maxlength="2"/>
		 </td>
		 <td align="left"> تاریخ ماندگاری :&nbsp;</td><td align="right" ><input type="hidden" name="code_mandegari" value="'.$code_mandegari.'" />'.listbox("code_mandegari_show",$code_mandegari,"code_mandegari","sharh_mandegari","tarikh_mandegari","","class='text4' disabled").'</td>';
         IF($detail_forush>0)echo'<td align="left"> مانده فروش :&nbsp;</td><td align="right"><input class="textboxme2" readonly type="text" name="mande_forush_detail" value="'.$mande_forush_detail.'"/>';		 
		echo'
		</tr>
        <tr>
		 <td align="left"> نام کشور :&nbsp;</td><td align="right"><input type="hidden" name="code_keshvar" value="'.$code_keshvar.'"/><input class="textboxme2" type="text" readonly name="name_keshvar" value="'.$name_keshvar.'"/>
		 <td align="left"> نام تولیدکننده :&nbsp;</td><td align="right"><input type="hidden" name="code_tolidkonande" value="'.$code_tolidkonande.'"/><input class="textboxme2" type="text" readonly id="name_tolidkonande" name="name_tolidkonande" value="'.$name_tolidkonande.'"/></td>
		 <td align="left">';if($code_bastebandy==1)echo' کد کارتن : &nbsp;';if($code_bastebandy==2)echo' کد قوطی : &nbsp;';echo' </td><td align="right"><input';if(($code_bastebandy==3)or($code_bastebandy==4)or($code_bastebandy==5)or($code_bastebandy==6)) echo ' type="hidden"'; else  echo' type="text"'; echo' class="textboxme2" readonly name="code_karton"  value="'.$code_karton.'"/></td>
	     <td align="left">';if($code_bastebandy==1)echo' وزن کارتن : &nbsp;';if($code_bastebandy==2)echo' وزن قوطی : &nbsp;';echo'</td><td align="right"><input';if(($code_bastebandy==3)or($code_bastebandy==4)or($code_bastebandy==5)or($code_bastebandy==6)) echo ' type="hidden"'; else  echo' type="text"'; echo' class="textboxme2"  readonly name="vazn_karton_this" value="'.$vazn_karton_this.'"/></td>  
		</tr>
	    <tr>';
		 IF(($code_kala_==50)OR($code_kala_==54)) echo'<td align="left"> موجودی تعداد شانه :&nbsp;</td><td align="right"><input class="textboxme2" readonly type="text" name="tedad_shane" value="'.$tedad_shane.'" "/></td>';
		 ELSE echo'<input type="hidden" name="tedad_shane" value="'.$tedad_shane.'"/>';
		 echo'<td align="left">موجودی تعداد :&nbsp;</td><td align="right"><input class="textboxme2" readonly type="text" name="tedad_karton" value="'.$tedad_karton.'" "/></td><td colspan="2">&nbsp;</td>';
         if($code_bastebandy==1)echo'<td align="left"> موجودی ناخالص : &nbsp;</td><td align="right"><input class="textboxme2" readonly type="text" name="mojody_nakhales" value="'.$mojody_nakhales.'"/></td>';
		 else echo'<input type="hidden" name="mojody_nakhales" value="'.$mojody_nakhales.'"/>';
		 if(($code_bastebandy!=5)AND($code_bastebandy!=6))echo'<td align="left"> موجودی خالص : &nbsp;</td><td align="right"><input class="textboxme2" readonly type="text" readonly name="mojody_khales" value="'.$mojody_khales.'"/></td>';
	     else echo'<input type="hidden" name="mojody_khales" value="'.$mojody_khales.'"/>';
		echo'
		</tr>
		<tr>
		 <td>
		  <input type="hidden" name="sal_tolid_milady" value="'.$sal_tolid_milady.'"/>
		  <input type="hidden" name="mah_tolid_milady" value="'.$mah_tolid_milady.'"/>
	      <input type="hidden" name="rouz_tolid_milady" value="'.$rouz_tolid_milady.'"/>	
		 </td>
		</tr>		
	    <tr>';
		if($code_bastebandy==1)//بسته بندی کارتن
		{
		 if(($code_kala_==50))
		 {echo'<td align="left"><span class="star">*</span> تعداد شانه :&nbsp;</td><td align="right"><input class="textboxme2" type="text" name="tedad_shane_h_d" value="'.$tedad_shane_h_d.'" onblur="return shane_to_karton(),sumkarton(),vazn_khales_havale();" onkeypress="return isNumber(event)"/>(مضربی از 12)</td>';}
		 else if ($code_kala_==54)
		 {echo'<td align="left"><span class="star">*</span> تعداد شانه :&nbsp;</td><td align="right"><input class="textboxme2" type="text" name="tedad_shane_h_d" value="'.$tedad_shane_h_d.'" onblur="return shane_to_karton_dakheli(),sumkarton(),vazn_khales_havale();" onkeypress="return isNumber(event)"/>(مضربی از 6)</td>';}
		 
		 echo'
		 <td align="left"><span class="star">*</span> تعداد کارتن :&nbsp;</td><td align="right"><input '; if(($code_kala_==50)or($code_kala_==54)) echo 'readonly'; echo' class="textboxme2" type="text" name="tedad_karton_h_d" value="'.$tedad_karton_h_d.'" onkeypress="return isNumber(event)"'; IF($code_kala_!=51) echo' onblur="return sumkarton(),vazn_khales_havale();"'; echo' /></td>';
		 echo'<td align="left"> مجموع وزن کارتن ها :&nbsp;</td><td align="right"><input class="textboxme2" readonly type="text" name="sum_karton_h_d" value="0"/></td>';
		 echo'<td align="left"><span class="star">*</span> وزن ناخالص : &nbsp;</td><td align="right"><input class="textboxme2" type="text" name="vazn_nakhales_h_d" value="'.$vazn_nakhales_h_d.'" onblur="return vazn_khales_havale()" onKeydown="return PressfloatOnly(event,this)"/>
		 <td align="left"><span class="star">*</span> وزن خالص : &nbsp;</td><td align="right"><input class="textboxme2" type="text" readonly name="vazn_khales_h_d" value="'.$vazn_khales_h_d.'" onfocus="return vazn_khales_havale()" onkeypress="return isNumber(event)"/>';
	    }
		else if($code_bastebandy==2)//بسته بندی قوطی
		{echo'
		 <td align="left"><span class="star">*</span> تعداد قوطی :&nbsp;</td><td align="right"><input class="textboxme2" type="text" name="tedad_karton_h_d" value="'.$tedad_karton_h_d.'" onblur="return sumghooti()" onkeypress="return isNumber(event)"/></td>       	
		 <td colspan="2">&nbsp;</td>
		 <td align="left"><span class="star">*</span> وزن خالص : &nbsp;</td><td align="right"><input class="textboxme2" type="text" readonly name="vazn_khales_h_d" value="'.$vazn_khales_h_d.'" onfocus="return sumghooti()" onkeypress="return isNumber(event)"/>';
	    }
		else if(($code_bastebandy==5)OR($code_bastebandy==6))//دست یا عدد
		{echo'
		 <td align="left"> تعداد :&nbsp;</td><td align="right"><input class="textboxme2" type="text" name="tedad_karton_h_d" value="'.$tedad_karton_h_d.'" onkeypress="return isNumber(event)"/></td>       	
		 <td colspan="2">&nbsp;</td>
		 <td colspan="2">&nbsp;</td>';
	    }
		else //لاشه و سایر
		{echo'
		 <td align="left"> تعداد :&nbsp;</td><td align="right"><input class="textboxme2" type="text" name="tedad_karton_h_d" value="'.$tedad_karton_h_d.'" onkeypress="return isNumber(event)"/></td>       	
		 <td colspan="2">&nbsp;</td>
		 <td align="left"><span class="star">*</span> وزن خالص : &nbsp;</td><td align="right"><input class="textboxme2" type="text" name="vazn_khales_h_d" value="'.$vazn_khales_h_d.'" onKeydown="return PressfloatOnly(event,this)"/>';
	    }
		echo'
		</tr>
		<tr class="title">
         <td colspan="11" align="center" >
		  <input class="buttonme" type="submit" name="Insert_x_detail" id="sabt" value="ثبت">
          <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?shomare_havale_anbar_='.$shomare_havale_anbar_.'&code_kala_='.$code_kala_.'&noe_tahvil_bar_='.$noe_tahvil_bar_.'&h_code_='.$h_code_.'&idForush_='.$idForush_.'&shomare_jabejae_='.$shomare_jabejae_.'&idJabejae_='.$idJabejae_.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'">
         </td>
        </tr>
      </table>
	 </td>
    </tr>';
    }
	if ($Mode=="Edit")//Edit Mode
    {
	 $q2="SELECT *,(SELECT name_kala FROM $mydatabase.kala WHERE kala.code_kala=T.code_kala) nameKala,
	      (SELECT name_keshvar FROM $mydatabase.keshvar WHERE keshvar.code_keshvar=T.code_keshvar) nameKeshvar
		  FROM $mydatabase.$TableName T WHERE T.id='$id_'";	  
	 $res2=$db->query($q2);
	 $row2=$db->fetch_assoc($res2);             
	 if(strlen($mt_gl_code_ostan)==1) $code_a=make_pattern($mt_gl_code_ostan,2);
     else $code_a=$mt_gl_code_ostan;
	 echo'
     <tr> 
	  <td>  	 
	   <table border="0" bgcolor="#E9F7FD" align="center" width="99%" cellpadding="0" cellspacing="0" style="position:absolute;bottom:20px;">
        <tr class="title"><td colspan="11" align="center">ويرايش '.$row2['nameKala'].' در حواله شماره '.$code_a.$mt_gl_code_anbar.$shomare_havale_anbar_.'</td></tr>		
	    <tr><td>&nbsp;</td></tr>	   	   
	    <tr>
	   	 <span class="star">*</span><td align="left">انتخاب کالا از جدول موجودی کالا : &nbsp;</td><td align="right"><img border="0" src="images/image(7).gif" onClick="window.open(\'help_mojodykala.php?code_kala_='.$code_kala_.'\',\'_blank\',\'width=750px,left=400px,top=100px,scrollbars=yes\')" title="جدول موجودی کالا" style="width:22px;height:22px;cursor:pointer" onmouseOver="this.src=\'images/image(8).gif\'" onmouseOut="this.src=\'images/image(7).gif\'"/></td>
	     <input type="hidden" id="id_mojody" name="id_mojody" value="'.$id_mojody.'"/>
	     <input type=hidden name="code_keshvar" value="'.$row2['code_keshvar'].'"/>
		 <td align="left"><span class="star">*</span> نام کشور : &nbsp;</td><td align="right"><input class="textboxme2" type="text" readonly name="name_keshvar" value="'.$row2['nameKeshvar'].'"/>
 	     <td align="left"><span class="star">*</span> تاریخ تولید شمسی  :&nbsp;</td>
		 <td align="right" >
		       <span class="star">*</span> سال : <input class="textboxme2" type="text" name="sal_tolid_shamsi" value="'.$row2['sal_tolid_shamsi'].'" maxlength="4" readonly onkeypress="return isNumber(event)" style="width:40px;"/>
		       <span class="star">*</span> ماه : '.static_listbox("mah_tolid_sh",$row2['mah_tolid_shamsi'],"mahshamsiArr",1,"class='text4' disabled").'
		 </td>	
		  <input type="hidden" name="mah_tolid_shamsi" value="'.$mah_tolid_shamsi.'"/>
		  <input type="hidden" name="sal_tolid_milady" value="'.$sal_tolid_milady.'"/>
	      <input type="hidden" name="mah_tolid_milady" value="'.$mah_tolid_milady.'"/>
          <input type="hidden" name="tedad_karton" value="'.$tedad_karton.'"/>
	      <input type="hidden" name="mojody_nakhales" value="'.$mojody_nakhales.'"/>
	      <input type="hidden" name="mojody_khales" value="'.$mojody_khales.'"/>
	    </tr>
		<tr>	   
		 <td align="left">کد کارتن : &nbsp;</td><td align="right"><input type="text" class="textboxme2" name="code_karton" value="'.$row2['code_karton'].'" onfocus="return getVaznKarton(this.value);" onblur="return getVaznKarton(this.value);"  onkeypress="return isNumber(event)" style="width:50px;"/>
			 <img border="0" src="images/help.png" onClick="window.open(\'help_karton.php\',\'_blank\',\'width=400px,height=500px,left=500px,top=100px,scrollbars=yes\')" title="جدول نوع کارتن" style="width:20px;height:20px;cursor:pointer" onmouseOver="this.src=\'images/help_hover.png\'" onmouseOut="this.src=\'images/help.png\'"/>
		 </td>
	     <td align="left"> وزن کارتن :&nbsp;</td><td align="right"><input class="textboxme2" type="text" readonly name="vazn_karton_this" id="vazn_karton_this" value="'.$row2['vazn_karton_this'].'"/></td>  
		 <td align="left"> تعداد کارتن :&nbsp;</td><td align="right"><input class="textboxme2" type="text" name="tedad_karton_h_d" value="'.$row2['tedad_karton_h_d'].'" onblur="return sumkarton()" onkeypress="return isNumber(event)"/></td>       	
	    </tr>	
	    <tr>
		 <td align="left"> مجموع وزن کارتن ها :&nbsp;</td><td align="right"><input class="textboxme2" readonly type="text" name="sum_karton_h_d" value="'.$row2['sum_karton_h_d'].'"/></td>		
		 <td align="left"><span class="star">*</span> وزن ناخالص : &nbsp;</td><td align="right"><input class="textboxme2" type="text" name="vazn_nakhales_h_d" value="'.$row2['vazn_nakhales_h_d'].'" onblur="return vazn_khales_havale()" onkeypress="return isNumber(event)"/>
		 <td align="left"><span class="star">*</span> وزن خالص : &nbsp; </td><td align="right"><input class="textboxme2" type="text" readonly name="vazn_khales_h_d" value="'.$row2['vazn_khales_h_d'].'" onfocus="return vazn_khales_havale()" onkeypress="return isNumber(event)"/>
	    <tr>
	    <tr>
         <td colspan="10" align="center">
		  <input class="buttonme" type="submit" name="Edit_x_detail" id="sabt" value="ثبت تغييرات">
          <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?shomare_havale_anbar_='.$shomare_havale_anbar_.'&code_kala_='.$code_kala_.'&noe_tahvil_bar_='.$noe_tahvil_bar_.'&h_code_='.$h_code_.'&idForush_='.$idForush_.'&shomare_jabejae_='.$shomare_jabejae_.'&idJabejae_='.$idJabejae_.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'">
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
</div>';
/************اجازه براي ذخيره اطلاعات************/
function isPermitSave($code_baste,$sh_h,$c_kala,$n_tahvil,$code_zir_a,$c_keshvar,$c_tolid,$sal_t_sh,$mah_t_sh,$rouz_t_sh,$c_karton,$c_mandegari,$tedad_ka,$mojo_ka,$vazn_na,$mojo_nakhales,$vazn_kh,$mojo_khales,$tedad_sh,$mojo_sh,$m_forush,$m_jabejae,$count_detail_forush,$m_forush_detail,$gl_c_o,$gl_c_s,$gl_year)
{
 $flag=false;
 $error_msg='';
 //مجموع وزن خالص برای این حواله
 // $sum_khales=0;
 // $q_sum_khales="SELECT SUM(vazn_khales_h_d) FROM havale_detail WHERE shomare_havale_anbar='$sh_h' AND code_ostan='$gl_c_o' AND code_anbar='$gl_c_s' AND year='$gl_year'";
 // $res_sum_khales=mysql_query($q_sum_khales);
 // $row_sum_khales=mysql_fetch_array($res_sum_khales);
 // $sum_khales=$row_sum_khales[0];
 // //echo "<script>alert(".$sum_khales.")</script>";;
 // $sum_khales+=$vazn_kh;
 //echo "<script>alert(".$sum_khales.")</script>";
 //echo "<script>alert(".$m_forush.")</script>";
 //if(SuperUser())
 //{echo "<script>alert(".$mojo_khales.")</script>";
 // echo "<script>alert(".$vazn_kh.")</script>";}
 
 if(!($gl_c_o and $gl_c_s and $gl_year) or $gl_c_o==-1 or $gl_c_s==-1)//اگر سشن استان و انبار وسال خالی بود
 {   
   $flag=false;
   echo"<script> alert('لطفاً استان و انبار و سال مورد نظر خود را انتخاب نمایید!')</script>";
   return $flag;
 }
 else $flag=true;
 if(!($c_kala and $code_zir_a and $c_keshvar and $c_tolid and $sal_t_sh and $mah_t_sh and $rouz_t_sh and $tedad_ka))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
   return $flag;
 } 
 else $flag=true;
 if((($code_baste==1)or($code_baste==2))and(!($c_karton)))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
   return $flag;
 } 
 else $flag=true;
 if(($code_baste==1)and(!($vazn_na)))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
   return $flag;
 } 
 else $flag=true;
 if((($code_baste==1)or($code_baste==2)or($code_baste==3)or($code_baste==4)or($code_baste==7))and(!($vazn_kh)))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
   return $flag;
 } 
 else $flag=true;
 if(($c_kala)and($code_zir_a)and($c_keshvar)and($c_tolid)and($sal_t_sh)and($mah_t_sh)and($rouz_t_sh)and($c_karton))//تکراری نبودن موردانتخابی برای این حواله
 {
   $flag=false;
   $q10="SELECT count(*) FROM meat.havale_detail WHERE code_kala='$c_kala' AND code_ziranbar='$code_zir_a' AND code_keshvar='$c_keshvar' AND code_tolidkonande='$c_tolid' AND sal_tolid_shamsi='$sal_t_sh' AND mah_tolid_shamsi='$mah_t_sh' AND rouz_tolid_shamsi='$rouz_t_sh' AND code_karton='$c_karton' AND code_mandegari='$c_mandegari' AND shomare_havale_anbar='$sh_h' AND code_ostan='$gl_c_o' AND code_anbar='$gl_c_s' AND year='$gl_year'";
   $res10=mysql_query($q10);
   $row10=mysql_fetch_array($res10);
   if($row10[0]>0){
   echo"<script>alert('اين کالا با این مشخصات قبلاً در این حواله ثبت شده است !')</script>";
   return $flag;
  }
  else $flag=true;
 }
 else $flag=true;
 // echo "<script>alert(".$n_tahvil.")</script>";
 // echo "<script>alert(".$m_forush.")</script>";
 // echo "<script>alert(".$m_jabejae.")</script>";
 // if(SuperUser())
 // {echo "<script>alert(".$vazn_kh.")</script>";
  // echo "<script>alert(".$mojo_khales.")</script>";}
 //if((($n_tahvil==4)or($n_tahvil==5))and($code_baste==1) and ($m_jabejae<$vazn_kh))//بررسی وزن خالص و مانده از جابه جایی
 if(($c_kala==50)and($tedad_sh % 12 !=0))
 {  $flag=false;
    echo"<script>window.alert('تعداد شانه باید مضربی از 12 باشد')</script>";
    return $flag; 
 }
 else $flag=true;
 if(($c_kala==54)and($tedad_sh % 6 !=0))
 {  $flag=false;
    echo"<script>window.alert('تعداد شانه باید مضربی از 6 باشد')</script>";
    return $flag; 
 }
 else $flag=true;
 if((($n_tahvil==4)OR($n_tahvil==5))AND(($code_baste==1)OR($code_baste==3)OR($code_baste==7)))//کارتن و لاشه ووکیوم
 {
  if( (($c_kala==50)OR($c_kala==54)) AND ($m_jabejae<$tedad_sh))//بررسی تعداد شانه و مانده از جابه جایی
  { $flag=false;
    echo"<script>window.alert('تعداد شانه وارد شده از تعداد مانده از جابه جایی بیشتر است ! امکان ثبت این حواله وجود ندارد')</script>";
    return $flag;
  }
  else $flag=true;
  
  if(($c_kala!=50)AND ($c_kala!=54) AND($m_jabejae<$vazn_kh))//بررسی وزن خالص و مانده از جابه جایی
  { $flag=false;
    echo"<script>window.alert('مقدار وزن خالص از مقدار مانده از جابه جایی بیشتر است ! امکان ثبت این حواله وجود ندارد')</script>";
    return $flag;
  }
  else $flag=true;
 }
 if((($n_tahvil==4)OR($n_tahvil==5)OR($n_tahvil==7))AND(($code_baste==2)OR($code_baste==5)OR($code_baste==6))AND($m_jabejae<$tedad_ka))//بررسی تعداد قوطی و مانده از جابه جایی
 {
  $flag=false;
  echo"<script>window.alert('تعداد وارد شده از تعداد مانده از جابه جایی بیشتر است ! امکان ثبت این حواله وجود ندارد')</script>";
  return $flag;
 }
 else $flag=true;
 
 if((($n_tahvil==1)OR($n_tahvil==2)OR($n_tahvil==3))AND(($code_baste==1)OR($code_baste==3)OR($code_baste==7)))//کارتن و لاشه ووکیوم
 {
  if((($c_kala==50)OR($c_kala==54)) AND ($m_forush<$tedad_sh))//تعداد شانه از مقدار مانده از حواله فروش بیشتر نباشد
  { $flag=false;
    echo"<script>window.alert('تعداد شانه وارد شده از تعداد مانده از حواله فروش بیشتر است ! امکان ثبت وجود ندارد')</script>";
    return $flag;
  }
  else $flag=true;
  if(($c_kala!=50) AND ($c_kala!=54) AND($m_forush<$vazn_kh))//وزن خالص از مقدار مانده از حواله فروش بیشتر نباشد
  { $flag=false;
    echo"<script>window.alert('مقدار وزن خالص از مقدار مانده از حواله فروش بیشتر است! امکان ثبت وجود ندارد')</script>";
    return $flag;
  }
  else $flag=true;
 }
 if((($n_tahvil==1)OR($n_tahvil==2)OR($n_tahvil==3))AND(($code_baste==2)OR($code_baste==5)OR($code_baste==6))AND($m_forush<$tedad_ka))//تعداد قوطی از مقدار مانده از حواله فروش بیشتر نباشد
 {
  $flag=false;
  echo"<script>window.alert('تعداد وارد شده از مقدار مانده از حواله فروش بیشتر است ! امکان ثبت این حواله وجود ندارد')</script>";
  return $flag;
 }
 else $flag=true;

 //صفر بودن موجودی
 // if(($mojo_ka<=0)or($mojo_khales<=0)or($mojo_nakhales<=0))
 // {
  // $flag=false;
  // $error_msg.='تعداد کارتن کالای انتخابی صفر است امکان ثبت این کالا در حواله وجود ندارد !';
 // }
 // if($mojo_ka<=0)
 // {
  // $flag=false;
  // $error_msg.='تعداد کارتن کالای انتخابی صفر است امکان ثبت این کالا در حواله وجود ندارد !';
 // }
 // if($mojo_khales<=0)
 // {
  // $flag=false;
  // $error_msg.='\n'.'مقدار موجودی خالص کالای انتخابی صفر است امکان ثبت این کالا در حواله وجود ندارد !';
 // }
 // if($mojo_nakhales<=0)
 // {
  // $flag=false;
  // $error_msg.='\n'.'مقدار موجودی ناخالص کالای انتخابی صفر است امکان ثبت این کالا در حواله وجود ندارد !';
 // }
 // if(($mojo_ka<$tedad_ka)or($mojo_nakhales<$vazn_na)or($mojo_khales<$vazn_kh))
 // {
   // $flag=false;
  // $error_msg.='\n'.'تعداد کارتن از تعداد کارتن موجود در سردخانه بیشتر است !';
 // }
 if($mojo_ka<$tedad_ka)
 {
  $flag=false;
  if($code_baste==1)$error_msg.='تعداد کارتن از تعداد کارتن موجود در سردخانه بیشتر است !';
  if($code_baste==2)$error_msg.='تعداد قوطی از تعداد قوطی موجود در سردخانه بیشتر است !';
  if($code_baste==3)$error_msg.='تعداد لاشه از تعداد لاشه موجود در سردخانه بیشتر است !';
  if($code_baste==4)$error_msg.='تعداد کیسه از تعداد کیسه موجود در سرخانه بیشتر است !';
  if($code_baste==5)$error_msg.='تعداد دست از تعداد دست موجود در سردخانه بیشتر است !';
  if($code_baste==6)$error_msg.='تعداد از تعداد موجود در سردخانه بیشتر است !';
  if($code_baste==7)$error_msg.='تعداد وکیوم از تعداد وکیوم موجود در سردخانه بیشتر است !';
 }
 if($mojo_nakhales<$vazn_na)
 {
  $flag=false;
  $error_msg.='\n'.'مقدار وزن ناخالص از مقدار موجودی ناخالص این کالا در سردخانه بیشتر است !';
 }
 if($mojo_khales<$vazn_kh)
 {
  $flag=false;
  $error_msg.='\n'.'مقدار وزن خالص از مقدار موجودی خالص این کالا در سردخانه بیشتر است !';
 }
 if($mojo_sh<$tedad_sh)
 {
  $flag=false;
  $error_msg.='\n'.'تعداد شانه از تعداد شانه موجود در سردخانه بیشتر است !';
 }
 //اگر حواله فروش جزئیات را تعیین کرده
 //در حالت بسته بندی قوطی
 if(($count_detail_forush>0)AND($code_baste==2)AND($m_forush_detail<$tedad_ka))
 {
  $flag=false;
  $error_msg.='\n'.'تعداد وارد شده از مقدار مانده از حواله فروش مربوط به این کالا بیشتر است !'; 
 }
 if(($count_detail_forush>0)AND(($code_baste==1)OR($code_baste==3)))
 {
  if((($c_kala==50)OR($c_kala==54)) AND($m_forush_detail<$tedad_sh))
  {$flag=false;
   $error_msg.='\n'.'تعداد شانه وارد شده از مقدار مانده از حواله فروش مربوط به این کالا بیشتر است  !'; 
  }
  if(($c_kala!=50)AND ($c_kala!=54) AND($m_forush_detail<$vazn_kh))
  {$flag=false;
   $error_msg.='\n'.'مقدار وزن خالص وارد شده از مقدار مانده از حواله فروش مربوط به این کالا بیشتر است !'; 
  }
 }
 
 if ($flag == false) {echo"<script>window.alert('".$error_msg."');</script>";}
return $flag;
} 
/*************INSERT Detail BUTTON******/// ثبت اطلاعات کالا    
if(isset($Insert_x_detail))
{
    IF($noe_tahvil_bar_==9) //تحت کلید
	{
	 $tedad_again=mojodyKarton($mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear,$code_ziranbar,$code_kala_,$code_keshvar,$code_tolidkonande,$sal_tolid_shamsi,$mah_tolid_shamsi,$rouz_tolid_shamsi,$code_karton,$code_mandegari,2);
     $mojody_nakhales_again=mojodyNakhales($mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear,$code_ziranbar,$code_kala_,$code_keshvar,$code_tolidkonande,$sal_tolid_shamsi,$mah_tolid_shamsi,$rouz_tolid_shamsi,$code_karton,$code_mandegari,2);
     $mojody_khales_again=mojodyKhales($mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear,$code_ziranbar,$code_kala_,$code_keshvar,$code_tolidkonande,$sal_tolid_shamsi,$mah_tolid_shamsi,$rouz_tolid_shamsi,$code_karton,$code_mandegari,2);
	}
	ELSE//سایر موارد
	{
	 $tedad_again=mojodyKarton($mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear,$code_ziranbar,$code_kala_,$code_keshvar,$code_tolidkonande,$sal_tolid_shamsi,$mah_tolid_shamsi,$rouz_tolid_shamsi,$code_karton,$code_mandegari);
     $mojody_nakhales_again=mojodyNakhales($mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear,$code_ziranbar,$code_kala_,$code_keshvar,$code_tolidkonande,$sal_tolid_shamsi,$mah_tolid_shamsi,$rouz_tolid_shamsi,$code_karton,$code_mandegari);
     $mojody_khales_again=mojodyKhales($mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear,$code_ziranbar,$code_kala_,$code_keshvar,$code_tolidkonande,$sal_tolid_shamsi,$mah_tolid_shamsi,$rouz_tolid_shamsi,$code_karton,$code_mandegari);
	}
	//مقدار مانده از فروخته شده را کم میکنیم
	if((($noe_tahvil_bar_==4)or($noe_tahvil_bar_==5)or($noe_tahvil_bar_==7))OR($dad_id==''))//جابه جایی
	{
	  $sold_this_id_without_ebtal=sold_this_id($id_mojody,$code_bastebandy,$code_kala_);
	  $ebtal_this_id=$db->get_from_where("SUM(deh_amount)","sell.dm_ebtal_hdet","deh_anbar_id=$id_mojody");
	  $sold_this_id=$sold_this_id_without_ebtal-$ebtal_this_id;
	  $tahvily_detail=tahvily_az_forush_detail($id_mojody,$code_bastebandy,$code_kala_);
	  $mande_az_detail_forush=$sold_this_id-$tahvily_detail;
	  IF($code_bastebandy==2)  {$tedad_mojaz=$tedad_again-$mande_az_detail_forush;$khales_mojaz=$mojody_khales_again;}
	  ELSE IF($code_kala_==50) {$tedad_mojaz=$tedad_again; $khales_mojaz=$mojody_khales_again; $tedad_shane_mojaz=($tedad_again*$_SESSION["mtShane"])-$mande_az_detail_forush;}
	  ELSE IF($code_kala_==54) {$tedad_mojaz=$tedad_again; $khales_mojaz=$mojody_khales_again; $tedad_shane_mojaz=($tedad_again*$_SESSION["mtShane_dakheli"])-$mande_az_detail_forush;}
	  ELSE {$tedad_mojaz=$tedad_again; $khales_mojaz=$mojody_khales_again-$mande_az_detail_forush;}
	}
	else {$tedad_mojaz=$tedad_again;$khales_mojaz=$mojody_khales_again;IF($code_kala_==50){$tedad_shane_mojaz=($tedad_again*$_SESSION["mtShane"]);}ELSE IF($code_kala_==54){$tedad_shane_mojaz=($tedad_again*$_SESSION["mtShane_dakheli"]);}ELSE $tedad_shane_mojaz=0;}
    $khales_mojaz=round($khales_mojaz,3);
   //}
   if(($noe_tahvil_bar_==4)or($noe_tahvil_bar_==5)or($noe_tahvil_bar_==7)or($noe_tahvil_bar_==9))//جابه جایی و تحت کلید
   { 
	$mande_az_jabejae_again=$db->get_from_where("mande_az_jabejae","$mydatabase.mojavez_jabejae","code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND shomare_jabejae='$shomare_jabejae_'");   
    $meghdar_batele_j_again=batele_jabejae($shomare_jabejae,$mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear);
   }
   else//اگر نوع تحویل جابه جایی نباشد
   {
	    /**اگر به فروش متصل نیستیم**/
	    if($_SESSION['mt_systemforush']==0)
	    {  
          $mande_az_forush_again=$db->get_from_where("mande_az_forush","$mydatabase.havale_forush","code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND h_code='$h_code_'");   
          $mande_az_forush_again=round($mande_az_forush_again,3);
		  $meghdar_batele_again=$db->get_from_where("SUM(meghdar_batele)","$mydatabase.ebtal","code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND h_code='$h_code_' AND deleted=0");   
		}
	    /**اگر به فروش متصل هستیم**/
	    if($_SESSION['mt_systemforush']==1)
	    {  
           $res_sal=mysql_query("SELECT year_id FROM dm_year WHERE year_code='$sellYearCode'");
           $sellYearId=mysql_result($res_sal, 0, 'year_id');
		   $mande_az_forush_again=$db->get_from_where("h_mande_havale","sell.dm_havale","h_id='$idForush_'");   
           $mande_az_forush_again=round($mande_az_forush_again,3);
		   $meghdar_batele_again=$db->get_from_where("SUM(his_eb_amount)","sell.dm_his_havale","his_h_code='$h_code_' AND his_id_province='$sell_id_ostan' AND his_l_code='$sell_id_anbar' And his_id_year='$sellYearId'");  
	    }
  }
 if(isPermitSave($code_bastebandy,$shomare_havale_anbar_,$code_kala_,$noe_tahvil_bar_,$code_ziranbar,$code_keshvar,$code_tolidkonande,$sal_tolid_shamsi,$mah_tolid_shamsi,$rouz_tolid_shamsi,$code_karton,$code_mandegari,$tedad_karton_h_d,$tedad_mojaz,$vazn_nakhales_h_d,$mojody_nakhales_again,$vazn_khales_h_d,$khales_mojaz,$tedad_shane_h_d,$tedad_shane_mojaz,$mande_az_forush_again,$mande_az_jabejae_again,$detail_forush,$mande_forush_detail,$mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear))
 {
   $Mode='';
   mysql_query('SET AUTOCOMMIT=0');//TRANSACTIONشروع 
   mysql_query('START TRANSACTION');
   if((($noe_tahvil_bar_==1)or($noe_tahvil_bar_==2)or($noe_tahvil_bar_==3))and($code_bastebandy==1)and($code_kala_!=50)and($code_kala_!=54)and($mande_az_forush_again<$vazn_khales_h_d))//چک کردن دوباره وزن و مانده از فروش
   {
	 echo"<script>window.alert('مقدار وزن خالص از مقدار مانده از حواله فروش بیشتر است! امکان ثبت این حواله وجود ندارد')</script>";
     mysql_query('ROLLBACK');
   }
   else if((($noe_tahvil_bar_==4)or($noe_tahvil_bar_==5)or($noe_tahvil_bar_==7)or($noe_tahvil_bar_==9))and($code_bastebandy==1)and($code_kala_!=50)and($code_kala_!=54)and($mande_az_jabejae_again<$vazn_khales_h_d))//چک کردن دوباره وزن و مانده 
   {
     echo"<script>window.alert('مقدار وزن خالص از مقدار مانده از جابه جایی بیشتر است ! امکان ثبت این حواله وجود ندارد')</script>";
     mysql_query('ROLLBACK');
   }
   else if((($noe_tahvil_bar_==4)or($noe_tahvil_bar_==5)or($noe_tahvil_bar_==7)or($noe_tahvil_bar_==9))and(($code_bastebandy==2)or($code_bastebandy==5)or($code_bastebandy==6))and($mande_az_jabejae_again<$tedad_karton_h_d))//چک کردن دوباره وزن و مانده 
   {
     echo"<script>window.alert('تعداد وارد شده از تعداد مانده از جابه جایی بیشتر است ! امکان ثبت این حواله وجود ندارد')</script>";
     mysql_query('ROLLBACK');
   }
   //چک کردن دوباره وزن ها وموجودی
   else if(($mojody_khales_again<$vazn_khales_h_d)or($mojody_nakhales_again<$vazn_nakhales_h_d)or($tedad_again<$tedad_karton_h_d))
   {
      echo"<script>window.alert('مقادیر وارد شده از مقادیر موجود در سردخانه بیشتر است!')</script>";
      mysql_query('ROLLBACK');
   }
   else
   {
   //تبدیل تاریخ شمسی به میلادی
	$milady=jalali_to_gregorian($sal_tolid_shamsi,$mah_tolid_shamsi,$rouz_tolid_shamsi);
    $sal_tolid_milady=$milady[0];$mah_tolid_milady=$milady[1];$rouz_tolid_milady=$milady[2];
   //انجام دوباره محاسبات برای اطمینان
	if($code_bastebandy==1)//بسته بندی کارتنی
	{
	 IF($code_kala_==51)$sum_karton_h_d=0;//تخم مرغ صنعتی وزن کارتنها رو صفر می کنیم 
	 ELSE $sum_karton_h_d=round(floatval($vazn_karton_this*$tedad_karton_h_d),3);
     $vazn_khales_h_d=round(floatval($vazn_nakhales_h_d-$sum_karton_h_d),3);
	}
	if($code_bastebandy==2)//بسته بندی قوطی
	{
     $vazn_khales_h_d=round(floatval($vazn_karton_this*$tedad_karton_h_d),3);
	}
    $insert_detail_q=("INSERT INTO $mydatabase.$TableName(id_mojody,dad_id,code_ostan,code_anbar,shomare_havale_anbar,year,code_ziranbar,code_kala,code_keshvar,code_tolidkonande,
                     sal_tolid_shamsi,mah_tolid_shamsi,rouz_tolid_shamsi,sal_tolid_milady,mah_tolid_milady,rouz_tolid_milady,h_code,shomare_jabejae,code_karton,vazn_karton_this,
					 code_mandegari,tedad_karton_h_d,sum_karton_h_d,vazn_nakhales_h_d,vazn_khales_h_d,tedad_shane_h_d,status)
                     VALUES('$id_mojody','$dad_id','$mt_gl_code_ostan','$mt_gl_code_anbar','$shomare_havale_anbar_','$mtActiveYear','$code_ziranbar','$code_kala_','$code_keshvar','$code_tolidkonande',
					 '$sal_tolid_shamsi','$mah_tolid_shamsi','$rouz_tolid_shamsi','$sal_tolid_milady','$mah_tolid_milady','$rouz_tolid_milady','$h_code_','$shomare_jabejae_','$code_karton','$vazn_karton_this',
					 '$code_mandegari','$tedad_karton_h_d','$sum_karton_h_d','$vazn_nakhales_h_d','$vazn_khales_h_d','$tedad_shane_h_d',0)");  
    $insert_detail_res=mysql_query($insert_detail_q);
     /*لاگ*/
     $max_id=$db->get_from_where("MAX(id)","$mydatabase.$TableName","shomare_havale_anbar='$shomare_havale_anbar_' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear'");   
     $log_i=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$max_id','ثبت',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')");   
     //آپدیت تعداد کارتن و وزن ناخالص و وزن خالص حواله 
	 $tedad_karton_h=$db->get_from_where("tedad_karton_h","$mydatabase.havale","shomare_havale_anbar='$shomare_havale_anbar_' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0 AND status=0");   
	 $vazn_nakhales_h=$db->get_from_where("vazn_nakhales_h","$mydatabase.havale","shomare_havale_anbar='$shomare_havale_anbar_' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0 AND status=0");   
	 $vazn_khales_h=$db->get_from_where("vazn_khales_h","$mydatabase.havale","shomare_havale_anbar='$shomare_havale_anbar_' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0 AND status=0");   
	 $update_tedad_karton_h=$tedad_karton_h+$tedad_karton_h_d;
	 $update_vazn_nakhales_h=round(floatval($vazn_nakhales_h+$vazn_nakhales_h_d),3);
	 $update_vazn_khales_h=round(floatval($vazn_khales_h+$vazn_khales_h_d),3);
     $res_update_havale=$db->query("UPDATE $mydatabase.havale SET tedad_karton_h='$update_tedad_karton_h',vazn_nakhales_h='$update_vazn_nakhales_h',vazn_khales_h='$update_vazn_khales_h' WHERE shomare_havale_anbar='$shomare_havale_anbar_' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0");       
	 //آپدیت موجودی کالا
     $update_mojody_nakhales=round(floatval($mojody_nakhales_again-$vazn_nakhales_h_d),3);//آپدیت موجودی ناخالص کالا در جدول موجودی کالا  
     $update_mojody_khales=round(floatval($mojody_khales_again-$vazn_khales_h_d),3);//آپدیت موجودی خالص کالا در جدول موجودی کالا
     $update_tedad_karton=$tedad_again-$tedad_karton_h_d;//آپدیت تعداد کالای موجود در انبار
     IF($code_kala_==50)$update_tedad_shane=($tedad_again*$_SESSION["mtShane"])-$tedad_shane_h_d;//آپدیت تعداد شانه موجود در سردخانه
     ELSE IF($code_kala_==54)$update_tedad_shane=($tedad_again*$_SESSION["mtShane_dakheli"])-$tedad_shane_h_d;//آپدیت تعداد شانه موجود در سردخانه
	 ELSE $update_tedad_shane=0;
	 IF($noe_tahvil_bar_==9)//تحت کلید
	   $table_mojody='mojody_kala_gomrok';//تحت کلید گمرک
	 ELSE//سایر
	  $table_mojody='mojody_kala';
	 $update_mojody_res=$db->query("UPDATE $mydatabase.$table_mojody SET mojody_khales='$update_mojody_khales',mojody_nakhales='$update_mojody_nakhales',tedad_karton='$update_tedad_karton',tedad_shane='$update_tedad_shane' WHERE code_kala='$code_kala_' AND code_keshvar='$code_keshvar' AND code_tolidkonande='$code_tolidkonande' AND sal_tolid_shamsi='$sal_tolid_shamsi' AND mah_tolid_shamsi='$mah_tolid_shamsi' AND rouz_tolid_shamsi='$rouz_tolid_shamsi' AND code_karton='$code_karton' AND code_mandegari='$code_mandegari' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND code_ziranbar='$code_ziranbar' AND year='$mtActiveYear' AND deleted=0");  	
	 /*لاگ موجودی*/
	 if($update_mojody_res) {$log_m_e=$db->query("INSERT INTO $mydatabase.log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$table_mojody',".$id_mojody.",'ایجاد جزئیات کالا در حواله و کاهش موجودی',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')");}
   	 if(($noe_tahvil_bar_==4)or($noe_tahvil_bar_==5)or($noe_tahvil_bar_==7)or($noe_tahvil_bar_==9))//اگر نوع تحویل جابه جایی است
	 {   //آپدیت مانده مقدار مجوز جابه جایی
         // بسته بندی قوطی یا دست یا عدد ، تعداد را کم می کنیم
		 if(($code_bastebandy==2)or($code_bastebandy==5)or($code_bastebandy==6))$update_mande_j=$mande_az_jabejae_again-$tedad_karton_h_d;
		 //تخم مرغ شانه را کم میکنیم
		 else if(($code_kala_==50)or($code_kala_==54)) $update_mande_j=$mande_az_jabejae_again-$tedad_shane_h_d; 
		 //سایر بسته بندی ، وزن را کم میکنیم
		 else $update_mande_j=$mande_az_jabejae_again-$vazn_khales_h_d; 
         
		  $res_update_mande_j=$db->query("UPDATE $mydatabase.mojavez_jabejae SET mande_az_jabejae='$update_mande_j' WHERE shomare_jabejae='$shomare_jabejae_' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0");    
	     if($res_update_mande_j)$log_mande_j_e=$db->query("INSERT INTO $mydatabase.log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','mojavez_jabejae','$idJabejae_','ایجاد حواله وکاهش مانده مجوز جابه جایی',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')"); /*کوئری لاگ*/
	 }     
	 else//اگر نوع تحویل جابه جایی نباشد
	 {
	  //آپدیت مانده مقدار حواله فروش
        // بسته بندی قوطی یا دست یا عدد ، تعداد را کم می کنیم
	    if(($code_bastebandy==2)or($code_bastebandy==5)or($code_bastebandy==6))$update_mande=$mande_az_forush_again-$tedad_karton_h_d;
	  	//تخم مرغ شانه را کم میکنیم
		else if(($code_kala_==50)or($code_kala_==54))   $update_mande=$mande_az_forush_again-$tedad_shane_h_d; 
	    //سایر بسته بندی ، وزن را کم میکنیم
		else $update_mande=round(floatval($mande_az_forush_again-$vazn_khales_h_d),3);
	  
	  /**سردخانه**/
	   if($_SESSION['mt_systemforush']==0)
	   {  
          $res_update_mande=$db->query("UPDATE $mydatabase.havale_forush SET mande_az_forush='$update_mande' WHERE h_code='$h_code_' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0");    
	   	  $log_mande_e=$db->query("INSERT INTO $mydatabase.log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','havale_forush','$idForush_','ایجاد حواله وکاهش مانده حواله فروش در سیستم انبار',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')"); /*کوئری لاگ*/
	   }
	  /**فروش**/
	   if($_SESSION['mt_systemforush']==1)
	   {  
          $res_update_mande=$db->query("UPDATE sell.dm_havale SET h_mande_havale='$update_mande' WHERE h_id='$idForush_'");    
	      $log_mande_e=$db->query("INSERT INTO $mydatabase.log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','havale_forush','$idForush_','ایجاد حواله وکاهش مانده حواله فروش در سیستم فروش',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')"); /*کوئری لاگ*/
	   }
	  }
	 if(($insert_detail_res and $log_i and $res_update_havale and $update_mojody_res and $log_m_e and $res_update_mande_j and $log_mande_j_e)or($insert_detail_res and $log_i and $res_update_havale and $update_mojody_res and $log_m_e and $res_update_mande and $log_mande_e)) 
	 {
	  mysql_query("COMMIT");
	  if(strlen($mt_gl_code_ostan)==1) $code_a=make_pattern($mt_gl_code_ostan,2); else $code_a=$mt_gl_code_ostan;
      echo "<script>window.location='".$FileName."?shomare_havale_anbar_=".$shomare_havale_anbar_."&code_kala_=".$code_kala_."&noe_tahvil_bar_=".$noe_tahvil_bar_."&h_code_=".$h_code_."&idForush_=".$idForush_."&shomare_jabejae_=".$shomare_jabejae_."&idJabejae_=".$idJabejae_."&PageNo=".$PageNo."&RowPerPage=".$RowPerPage."&order=".$order."';</script>";  
	 }
	 else  
     {
      mysql_query('ROLLBACK');
      echo "<script>alert('مشکلی در ثبت به وجود آمده است')</script>";
     }
    }//END else check mande az forush AND mojody	
	mysql_query('SET AUTOCOMMIT=1');
 }//END isPermitSave
}//END INSERT		
/********************WEB SERVICE***********************/
if((isset($send_havale))and(isset($sabt_havale)))//مراحل ثبت در وب سرویس
{
  $base_date='1402/11/09';      
  //ثبت نهایی
  $update_sabt=("UPDATE $mydatabase.havale SET sabt_nahayi=1 WHERE code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND shomare_havale_anbar='$shomare_havale_anbar_' AND year=$mtActiveYear");
  $update_res_sabt=mysql_query($update_sabt);
  $register_error_code=$db->get_from_where("register_error_code","$mydatabase.list_sardkhane","code_ostan=".$mt_gl_code_ostan." AND code_anbar=".$mt_gl_code_anbar."");     
  $tarikh_havale_anbar=$db->get_from_where("tarikh_havale_anbar","havale","code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND shomare_havale_anbar='$shomare_havale_anbar_' AND year=$mtActiveYear");     
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
				  WHERE  h.tarikh_havale_anbar>='$base_date' AND h.code_ostan=$mt_gl_code_ostan AND h.code_anbar=$mt_gl_code_anbar AND h.year=$mtActiveYear AND shomare_havale_anbar='$shomare_havale_anbar_'";
	$res_havale = mysql_query($q_havale);
	$row_havale=mysql_fetch_assoc($res_havale); 
	$warehouse_id=$db->get_from_where("warehouse_id","list_sardkhane","code_ostan=".$row_havale['code_ostan']." AND code_anbar=".$row_havale['code_anbar']."");     
    //$contractor_national_id=$db->get_from_where("nationalId","list_sardkhane_owner","code_ostan=".$row_havale['code_ostan']." AND code_anbar=".$row_havale['code_anbar']."");     
	$contractor_national_id='14002771736';
	if(strlen($row_havale['code_ostan'])==1) $code_a=make_pattern($row_havale['code_ostan'],2);
    else $code_a=$row_havale['code_ostan'];
	$shenaseAnbar=$code_a.$row_havale['code_anbar'];   
	//$shomareBijak=$mtActiveYear.$shomare_havale_anbar_;
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
		  'count'=>$row_havale['vazn_khales_h'],  
		  'gross_weight'=>$row_havale['vazn_nakhales_h'],  
		  'net_weight'=>$row_havale['vazn_khales_h'],  
		  'volume'=>null,  
		  'container_id'=>null,  
		  'package_id'=>null,  
		  'package_count'=>$row_havale['tedad_karton_h'], 
		  'package_type'=>$row_havale['sharh_bastebandy'],  
		  'comments'=>null,  
		  'additional_information'=>null 
		 );
		 
		 array_push($goods_issue_items,$goods_issue_items1);
         $params=array(
		  'number'=>$shomareBijak,
          'gov_number'=>$shomareBijak,
		  'goods_issue_date'=>$row_havale['tarikh_havale_anbar'],
          'warehouse_id'=>$warehouse_id,
          'contractor_national_id'=>$contractor_national_id,
          'postal_code'=>$row_havale['postal_code'],
          //'containers'=>$containers,
          //'packages'=>$packages,
		  'load_date'=>$row_havale['tarikh_havale_anbar'],
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
			//echo "<script>alert('Curl error: ' . curl_error($curl)')</script>";
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
  /********************WEB SERVICE second time***********************/
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
	   // //if(($row_havale['good_id']==null)OR($row_havale['good_id']=='')OR($row_havale['good_id']=='0')) $goodId=$row_havale['code_kala'];
	   // //else $goodId=$row_havale['good_id'];
	   // $goodId=$row_havale['code_kala'];
	   // //جابه جایی
	   // IF(($row_havale['noe_tahvil_bar']==4)OR($row_havale['noe_tahvil_bar']==5)OR($row_havale['noe_tahvil_bar']==7))$processSequence=79;
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
  //////////////////////////////////////////////////////////////////////////////////
  // if($_SESSION['mt_webservice']==1)//اتصال به وب سرویس
  // {
       // $shenaseSazman="02";
	   // if(strlen($mt_gl_code_ostan)==1) $code_a=make_pattern($mt_gl_code_ostan,2);
       // else $code_a=$mt_gl_code_ostan;
	   // $shenaseAnbar=$code_a.$mt_gl_code_anbar;
	   // //$shomareBijak=$code_a.$mt_gl_code_anbar.$shomare_havale_anbar_;  
	   // $shomareBijak='0'.$mtActiveYear.$shomare_havale_anbar_;
	   // $q_havale="SELECT * From havale h WHERE code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND year=$mtActiveYear AND shomare_havale_anbar='$shomare_havale_anbar_'";
	   // $res_havale = mysql_query($q_havale);
	   // $row_havale=mysql_fetch_assoc($res_havale);
	   // if(($row_havale['noe_tahvil_bar']==4)or($row_havale['noe_tahvil_bar']==5)) $shomareMojavez=$row_havale['shomare_jabejae'];
       // else $shomareMojavez=$row_havale['h_code'];
	   // $IssuedTime=substr($row_havale['IssuedTime'],0,5);
	   // if($row_havale['plak4']=='')$plak4=null;
	   // else $plak4=$row_havale['plak4'];
	   // if($row_havale['plak3']=='')$plak3=null;
	   // else $plak3=$row_havale['plak3'];
	   // if($row_havale['plak2']=='')$plak2=null;
	   // else $plak2=$row_havale['plak2'];
	   // if($row_havale['plak1']=='')$Plak1=null;
	   // else $plak1=$row_havale['plak1'];
	   // $plak=$plak1.$plak2.$plak3.$plak4;
	   // //جابه جایی
	   // IF(($row_havale['noe_tahvil_bar']==4)OR($row_havale['noe_tahvil_bar']==5)or($row_havale['noe_tahvil_bar']==7))$processSequence=79;
       // ELSE $processSequence=76;
	   // $wsdl_url='http://10.7.234.33/warehouse/warehouse.asmx?wsdl';
	   // header('Content-Type: text/html; charset=utf-8');
       // try
	   // {
	     // $client=new SoapClient($wsdl_url);
         // $bijak =array(
         // 'id'=>'',
	     // 'OrganNo'=>$shenaseSazman,
	     // 'WareHouseNo'=>$shenaseAnbar,
	     // 'BijakNo'=>$shomareBijak,
         // 'DraftNo'=>$shomareMojavez,
         // 'IssuedDate'=>$row_havale['tarikh_havale_anbar'],
         // 'Issuedtime'=>$IssuedTime,
         // 'VehicalPlaque'=>$plak,
         // 'NetWeight'=>$row_havale['vazn_khales_h'],
	     // 'GrossWeight'=>$row_havale['vazn_nakhales_h'],
		 // 'processSequence'=>$processSequence
         // );
	     // $listBijakStuff=array();   
	     // $q_havale_d="SELECT * From havale_detail h_d  WHERE code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND year=$mtActiveYear AND shomare_havale_anbar='$shomare_havale_anbar_'";
	     // $res_havale_d = mysql_query($q_havale_d);
	     // while($row_havale_d=mysql_fetch_assoc($res_havale_d))//جزئیات کالا
	     // {
	      // $nameKala=$db->get_from_where("name_kala","kala","code_kala=".$row_havale_d['code_kala']."");     
	      // $bastebandyKala=$db->get_from_where("sharh_bastebandy","kala INNER JOIN bastebandy ON kala.code_bastebandy=bastebandy.code_bastebandy","code_kala=".$row_havale_d['code_kala']."");     
	      // //$codeZirAnbar=$db->get_from_where("noe_ziranbar","list_sardkhane_detail","code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND code_ziranbar=".$row_havale_d['code_ziranbar']."");     
		  // //$noeZirAnbar=$ziranbarArr[$codeZirAnbar];
		  // //$nameZirAnbar=$db->get_from_where("name_ziranbar","list_sardkhane_detail","code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND code_ziranbar=".$row_havale_d['code_ziranbar']."");     
          // $bijakStuff1=array(
          // 'id'=>'',
	      // 'WareHouseNo'=>$shenaseAnbar,
		  // 'BijakNo'=>$shomareBijak,
          // 'StuffName'=>$nameKala,
          // 'StuffCode'=>$row_havale_d['code_kala'],
          // 'StuffNameFromService'=>$nameKala,
          // 'StuffCodeFromService'=>$row_havale_d['code_kala'],
          // //'LoadingCount'=>$row_havale_d['vazn_khales_h_d'],
          // 'loadingCount'=>$row_havale_d['tedad_karton_h_d'],
          // 'PackingTypeName'=>$bastebandyKala,
          // //'PackingCount'=>$row_havale_d['tedad_karton_h_d'],
          // 'UnitCount'=>null,
		  // 'TotalPrice'=>null,
          // 'LoadingNetWeight'=>$row_havale_d['vazn_khales_h_d'],
          // 'LoadingGrossWeight'=>$row_havale_d['vazn_nakhales_h_d'],
          // 'BillNo'=>'0'
          // );   
	      // array_push($listBijakStuff,$bijakStuff1);  
	     // }
	     // $params=array(
          // 'OrganNo_'=>$shenaseSazman,
          // 'WareHouseNo_'=>$shenaseAnbar,
          // 'Bijak_'=>$bijak,
          // 'BijakStuff_'=>$listBijakStuff,
		  // 'Username'=>'warehouseuser',
          // 'Password'=>'AqWsXz@8246'
          // );
         // $result=$client->SendBijak($params);
	     // $response=$result->SendBijakResult;
		 // echo "<script>alert('کد پیگیری وب سرویس\\n$response')</script>"; 
	   // }
	   // catch(SoapFault $client)
	   // {
	     // $response=0;
		 // echo "<script>alert('وب سرویس فعال نمی باشد')</script>";
	   // }
	   // $update_track=("UPDATE havale SET webservice_trackcode='$response' WHERE code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND shomare_havale_anbar='$shomare_havale_anbar_' AND year=$mtActiveYear");
	   // $insert_res=mysql_query($update_track);
  // }
  echo "<script>window.location='havale.php?PageNo=".$PageNo."&RowPerPage=".$RowPerPage."&order=".$order."';</script>";     
}  
/********************END********************/	
 echo'
'.$message .'
</form>
</body>
</html>';
?>