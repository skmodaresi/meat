<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
$RowPerPage_detail=8;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="resid_detail.php";
$TableName="resid_detail";
//$logtime=date('H:i:s');
//echo"<script>alert(window.screen.availWidth+'px');</script>";
$todaydate=$yy.'/'.$mm.'/'.$dd;
$sabtNahayi=$db->get_from_where("sabt_nahayi","resid","shomare_resid='".$shomare_resid_."' AND code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND year=$mtActiveYear");     
$exist_gheymat=$db->get_from_where("id_gheymat","gheymat","tarikh_etebar>='".$todaydate."' AND deleted=0 order by id_gheymat DESC LIMIT 0,1");   
if($exist_gheymat==0)
{
 echo "<script>alert('لطفاً جدول قیمت جدیدی با تاریخ معتبر ایجاد نمایید !\\n در صورتیکه قیمت های آخرین جدول قیمت هنوز معتبر است کافی است تاریخ اعتبار آخرین جدول را افزایش دهید')</script>";
 echo "<script>window.location='resid.php?PageNo=1&RowPerPage=".$RowPerPage."&order=".$order."';</script>";
}
else
{
 $exist_gheymat_detail=$db->get_from_where("id","gheymat_detail","id_gheymat='$exist_gheymat'");   
 if($exist_gheymat_detail==0)
 {
  echo "<script>alert('لطفاً در آخرین جدول قیمت فی و ضریبی برای کالا وارد نمایید')</script>";
  echo "<script>window.location='resid.php?PageNo=1&RowPerPage=".$RowPerPage."&order=".$order."';</script>";
 }
}
///////////////////////////اطلاعات قرارداد//////////////////////////
if(($noe_tahvil_bar_!=4)and($noe_tahvil_bar_!=5)and($noe_tahvil_bar_!=10))//به غیر از جابه جایی و انبارگردانی
{	 
 $id_safar=$db->get_from_where("id_safar","resid","shomare_resid='$shomare_resid_' AND code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND year=$mtActiveYear");
 $shomare_safar=$db->get_from_where("shomare_safar","shomare_safar","id_safar=$id_safar");
 $exist_gharardad=$db->get_from_where("COUNT(*)","gharardad_kharid","shomare_gharardad='$shomare_safar'");
 if($exist_gharardad>0)//اگر قرارداد وجود دارد
 {   
     $meghdar_gharardad=$db->get_from_where("meghdar_gharardad","gharardad_kharid","shomare_gharardad='$shomare_safar'");
     $code_kala_eblagh=$db->get_from_where("code_kala","resid LEFT JOIN shomare_safar s_f ON s_f.id_safar=resid.id_safar LEFT JOIN gharardad_kharid g_kh ON g_kh.shomare_gharardad=s_f.shomare_safar INNER JOIN sahmiebandy_kharid s_kh ON s_kh.id_sahmiebandy=g_kh.id_sahmiebandy INNER JOIN eblagh_kharid e_kh ON e_kh.id_eblagh=s_kh.id_eblagh","resid.year='$mtActiveYear' AND resid.code_ostan='$mt_gl_code_ostan' AND resid.code_anbar='$mt_gl_code_anbar' AND resid.shomare_resid='".$shomare_resid_."'");
     //کارتن یا لاشه یا کیسه
	 if(($code_bastebandy_==1)or($code_bastebandy_==3)or($code_bastebandy_==4))
		 $sum_tahvily_gharardad=$db->get_from_where("SUM(vazn_khales_r_d_sub)","meat.resid_kala_detail r_k_d INNER JOIN meat.resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","r.id_safar=$id_safar AND r.noe_tahvil_bar!=4 AND r.noe_tahvil_bar!=5 AND r.noe_tahvil_bar!=6 AND r_k_d.year='$mtActiveYear' AND r_k_d.code_ostan=".$mt_gl_code_ostan." AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.status=0 AND noe_tahvil_bar!=8");
     //قوطی یا دست یا عدد
	 if(($code_bastebandy_==2)OR($code_bastebandy_==5)OR($code_bastebandy_==6))
    	 $sum_tahvily_gharardad=$db->get_from_where("SUM(tedad_karton_r_d_sub)","meat.resid_kala_detail r_k_d INNER JOIN meat.resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","r.id_safar=$id_safar AND r.noe_tahvil_bar!=4 AND r.noe_tahvil_bar!=5 AND r.noe_tahvil_bar!=6 AND r_k_d.year='$mtActiveYear' AND r_k_d.code_ostan=".$mt_gl_code_ostan." AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.status=0 AND noe_tahvil_bar!=8");
	 if($sum_tahvily_gharardad=='')$sum_tahvily_gharardad=0;
	 //مانده قرارداد
	 $mande_tahvily_gharardad=$meghdar_gharardad-$sum_tahvily_gharardad;
 }
}
////////////////////////////////////////////////////////////////////
$right_ins=0;$right_edt=0;$right_del=0;$right_detail=0;
if (right(163)) $right_ins=1;
if (right(164)) $right_edt=1;
if (right(165)) $right_del=1;
if (right(166)) $right_detail=1;
$resid_status=$db->get_from_where("status","resid","shomare_resid='$shomare_resid_' AND code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND year=$mtActiveYear");
echo'
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>افزودن کالا به رسید</title>
<link href="styles.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="functions.js"></script>
<script type="text/javascript" src="scripts/jquery-1.6.2.min.js"></script>
<script type="text/javascript">
function OpenWindowDialog(url, w, h)
{
	 var features = "resizable:no;status:yes;dialogwidth:" + w + "px;dialogheight:" + h + "px;help:no";
     features = features + ";dialogtop:" + (window.screen.availHeight - w) /2;
	 features = features + ";dialogleft:" + (window.screen.availWidth - h) /2;	 
	 window.showModalDialog(url, this, features);	 
}
function popupwindow(url, title, w, h) {
  var left = (screen.width/2)-(w/2);
  var top = (screen.height/2)-(h/2);
  return window.open(url, title, "toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width="+w+", height="+h+", top="+top+", left="+left);
}
function enterIE()
{
   if(window.event.keyCode == 13 && window.event.srcElement.id != \'sabt\')
   window.event.keyCode = 9;
}
<!-- تعویض زیرانبار با انتخاب نوع زیر انبار-->
function getZiranbar(noe_zir_anbar)
{
  $("#loading").fadeIn("fast");  
  $.post("ajax.php",{noeZIRANBAR:noe_zir_anbar},function(data){$("[name=code_ziranbar]").html(data);});
  $("#loading").fadeOut("fast");		
} 
function getDetailKala2(code_kala,idresid)<!--اطلاعات کالا-->
{ 
    $("#loading").fadeIn("fast");
    $.post("ajax_resid.php",{codeKALA2:code_kala,IdResid:idresid},function(data){			 		 
			  var splKala = data.split("^");
			  $("#name_kala").val(splKala[0]);
			  $("#sharh_bastebandy").val(splKala[2]);
			  $("#id_gheymat_this").val(splKala[3]);
			  $("#fee_this").val(splKala[4]);
			  $("#zarib_this").val(splKala[5]);
			  $("#nerkh_takhlie_this").val(splKala[6]);
			  //خالی شود
			  $("[name=GheymatDetailID]").val(splKala[105]);
			  $("[name=gd_fee]").val(splKala[105]);
		 });
    $("#loading").fadeOut("fast");
}
function getDetailKeshvar(code_keshvar)<!--اطلاعات کشور-->
{ 
    //alert(code_keshvar);
	$("#loading").fadeIn("fast");
    $.post("ajax.php",{codeKESHVAR : code_keshvar},function(data){$("#name_keshvar").val(data);});
    $("#loading").fadeOut("fast");
}
function getDetailTolid(code_tolid)<!--اطلاعات تولیدکننده-->
{ 
    $("#loading").fadeIn("fast");
    $.post("ajax.php",{codeTOLID : code_tolid},function(data){$("#name_tolidkonande").val(data);});
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
function sumkarton()<!--محاسبه مجموع وزن کارتن ها در رسید-->
{
 var sum_k;
 sum_k=Number(document.myform.vazn_karton_this.value)*Number(document.myform.tedad_karton_r_d.value);
 document.myform.sum_karton_r_d.value=sum_k;
}
function mojaz()<!--محاسبه کسری مجاز-->
{
 var natije_mojaz;
 natije_mojaz=parseFloat((document.myform.vazn_mabda_r_d.value)*((document.myform.zarib_this.value)/1000)).toFixed(2);                                       
 document.myform.kasry_mojaz_r_d.value=natije_mojaz;
 return natije_mojaz;
}
function vazn_khales_resid()<!--محاسبه وزن خالص رسید-->
{
 var natije_vazn;
 natije_vazn=Number(document.myform.vazn_nakhales_r_d.value)-Number(document.myform.sum_karton_r_d.value);                                      
 document.myform.vazn_khales_r_d.value=natije_vazn;
} 
</script>
</head>';
if(!(isset($Mode))) $Mode='';
$cnt=$db->get_from_where("COUNT(*)","$TableName","shomare_resid='$shomare_resid_' AND code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND year=$mtActiveYear");
/******************** Insert- Edit- Delete ************/
/************اجازه براي ذخيره اطلاعات************/
function isPermitSave($code_baste,$n_tahvil,$c_kala,$c_keshvar,$c_tolid,$fee,$zarib,$v_m_r_d,$sh_r,$gl_c_o,$gl_c_s,$gl_year,$t_d,$gheymatID)
{
 $flag=false;
 if(!($gl_c_o and $gl_c_s and $gl_year) or $gl_c_o==-1 or $gl_c_s==-1)//اگر سشن استان و انبار وسال خالی بود
 {   
   $flag=false;
   echo"<script> alert('لطفاً استان و انبار و سال مورد نظر خود را انتخاب نمایید!')</script>";
   return $flag;
 }
 else $flag=true;
 if(!($c_kala and $c_keshvar and $c_tolid))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
   return $flag;
 } 
 else $flag=true;
 //نوع تحویل روباری یا جابه جایی روباری نباشد
 if(($n_tahvil!=2)and($n_tahvil!=5)and(!$v_m_r_d))//وزن مبدأ
 {
	$flag=false;
	echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
    return $flag;
 } 
 else $flag=true;
 if(!empty($c_kala))//موجود نبودن کد کالا در جدول کد کالا
 {
   $q_kala="SELECT code_kala FROM kala WHERE code_kala='$c_kala'";
   $res_kala=mysql_query($q_kala);
   if(mysql_num_rows($res_kala)==0)
   {
     echo"<script>alert('این کد کالا در جدول کالا ثبت نشده است!')</script>";
     $flag=false;
     return $flag;
  }
  else $flag=true;
  $q_baste="SELECT code_bastebandy FROM kala WHERE code_kala='$c_kala'";//بسته بندی
  $res_baste=mysql_query($q_baste);
  $row_baste=mysql_fetch_assoc($res_baste);
  if($row_baste['code_bastebandy']!=$code_baste)
  {
     echo"<script>alert('بسته بندی این کالا با نوع بسته بندی انتخاب شده در رسید مغایرت دارد!\\n امکان انتخاب این کالا وجود ندارد')</script>";
     $flag=false;
     return $flag;
  }
  else $flag=true;
  $q_gheymat="SELECT id_gheymat FROM gheymat WHERE tarikh_etebar>='".$t_d."' AND deleted=0 order by id_gheymat DESC LIMIT 0,1";
  $res_gheymat=mysql_query($q_gheymat);
  $row_gheymat=mysql_fetch_assoc($res_gheymat);
  $q_fee_z="SELECT code_kala FROM gheymat_detail WHERE id_gheymat='".$row_gheymat['id_gheymat']."' AND code_kala='$c_kala'";
  $res_fee_zarib=mysql_query($q_fee_z);
  if(mysql_num_rows($res_fee_zarib)==0){
	 echo"<script>alert('برای این کد کالا در جدول قیمت در این تاریخ فی و ضریبی ثبت نشده است!')</script>";
     $flag=false;
     return $flag;
  }
  else $flag=true;
 }
 else $flag=true;
 if(!empty($c_keshvar))//موجود نبودن کد کشور در جدول کشورها
 {
   $q_kesh="SELECT code_keshvar FROM keshvar WHERE code_keshvar='$c_keshvar'";
   $res_kesh=mysql_query($q_kesh);
   if(mysql_num_rows($res_kesh)==0){
     echo"<script>alert('این کد کشور در جدول کشورها ثبت نشده است!')</script>";
     $flag=false;
     return $flag;
   }
   else $flag=true;
 }
 else $flag=true;
 if(!empty($c_tolid))//موجود نبودن کد تولید کننده در جدول تولید کننده ها
 {
    $q_tolid="SELECT code_tolidkonande FROM tolidkonande WHERE code_tolidkonande='$c_tolid'";
    $res_tolid=mysql_query($q_tolid);
    if(mysql_num_rows($res_tolid)==0){
      echo"<script>alert('این کد تولید کننده در جدول تولید کننده ها وجود ندارد!')</script>";
      $flag=false;
      return $flag;
   }
  else $flag=true;
 }
 else $flag=true;
 if(!empty($c_kala)) //موجود نبودن فی و ضریب
 { 
   if((!$fee)or(!$zarib))
   {
    $flag=false;
    echo"<script>window.alert('فی و ضریبی برای این کالا ثبت نشده است !');</script>";
    return $flag;
   }	
  }
 else $flag=true; 
 if(!empty($c_kala)) //تکراری نبودن کالا
 {
   $q8="SELECT * FROM resid_detail WHERE shomare_resid='$sh_r' AND code_kala='$c_kala' AND code_keshvar='$c_keshvar' AND code_tolidkonande='$c_tolid' AND code_ostan='$gl_c_o' AND code_anbar='$gl_c_s' AND year='$gl_year'"; 
   $res8=mysql_query($q8);
   if(mysql_num_rows($res8)>0){
   echo"<script>alert('این کالا با این کشور و تولیدکننده قبلاً در این رسید ثبت شده است!')</script>";
   $flag=false;
   return $flag;
  }
 else $flag=true;
 }
 else $flag=true;
 if((!empty($v_m_r_d))and($code_baste!=2)and($n_tahvil!=3))//وزن مبدأ بیشتر از وزن کامیون بابار باشد
 {
   $q_kamiyon="SELECT vazn_kamiyon_bar FROM resid WHERE shomare_resid='$sh_r' AND code_ostan='$gl_c_o' AND code_anbar='$gl_c_s' AND year='$gl_year'";
   $res_kamiyon=mysql_query($q_kamiyon);
   $row_kamiyon=mysql_fetch_assoc($res_kamiyon);
   if(($row_kamiyon['vazn_kamiyon_bar'])<$v_m_r_d)
   {
     echo"<script>alert('وزن مبدأ از وزن کامیون بابار وارد شده در رسید بیشتر است!')</script>";
     $flag=false;
     return $flag;
   }
  else $flag=true;
 }  
 else $flag=true;
return $flag;
}
/**********اجازه براي ويرايش اطلاعات********/
function isPermitEdit($code_baste,$n_tahvil,$c_kala,$c_keshvar,$c_tolid,$fee,$zarib,$v_m_r_d,$sh_r,$this_id,$gl_c_o,$gl_c_s,$gl_year,$t_d,$gheymatID)
{
 //echo "<script>alert($c_kala)</script>";
 $flag=false;
 if(!($gl_c_o and $gl_c_s and $gl_year) or $gl_c_o==-1 or $gl_c_s==-1)//اگر سشن استان و انبار وسال خالی بود
 {   
   $flag=false;
   echo"<script> alert('لطفاً استان و انبار و سال مورد نظر خود را انتخاب نمایید!')</script>";
   return $flag;
 }
 else $flag=true;
 if(!($c_kala and $c_keshvar and $c_tolid))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
   return $flag;
 } 
 else $flag=true;
 //نوع تحویل روباری یا جابه جایی روباری نباشد
 if(($n_tahvil!=2)and($n_tahvil!=5)and(!$v_m_r_d))//وزن مبدأ
 {
	$flag=false;
	echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
    return $flag;
 } 
 else $flag=true;
 if(!empty($c_kala))//موجود نبودن کد کالا در جدول کد کالا
 {
   $q_kala="SELECT code_kala FROM kala WHERE code_kala='$c_kala'";
   $res_kala=mysql_query($q_kala);
   if(mysql_num_rows($res_kala)==0)
   {
     echo"<script>alert('این کد کالا در جدول کالا ثبت نشده است!')</script>";
     $flag=false;
     return $flag;
   }
   else $flag=true;
   $q_baste="SELECT code_bastebandy FROM kala WHERE code_kala='$c_kala'";
   $res_baste=mysql_query($q_baste);
   $row_baste=mysql_fetch_assoc($res_baste);
   if($row_baste['code_bastebandy']!=$code_baste)
   {
     echo"<script>alert('بسته بندی این کالا با نوع بسته بندی انتخاب شده در رسید مغایرت دارد!\\n امکان انتخاب این کالا وجود ندارد')</script>";
     $flag=false;
     return $flag;
	}
   else $flag=true;
  }  
  else $flag=true;
 if(!empty($c_keshvar))//موجود نبودن کد کشور در جدول کشورها
 {
   $q_kesh="SELECT code_keshvar FROM keshvar WHERE code_keshvar='$c_keshvar'";
   $res_kesh=mysql_query($q_kesh);
   if(mysql_num_rows($res_kesh)==0){
     echo"<script>alert('این کد کشور در جدول کشورها ثبت نشده است!')</script>";
     $flag=false;
     return $flag;
   }
   else $flag=true;
 }
 else $flag=true;
 if(!empty($c_tolid))//موجود نبودن کد تولید کننده در جدول تولید کننده ها
 {
    $q_tolid="SELECT code_tolidkonande FROM tolidkonande WHERE code_tolidkonande='$c_tolid'";
    $res_tolid=mysql_query($q_tolid);
    if(mysql_num_rows($res_tolid)==0){
      echo"<script>alert('این کد تولید کننده در جدول تولید کننده ها وجود ندارد!')</script>";
      $flag=false;
      return $flag;
   }
  else $flag=true;
 }
 else $flag=true;
 if(!empty($c_kala))//موجود نبودن فی و ضریب
 { 
   if((!$fee)or(!$zarib))
   {
    $flag=false;
    echo"<script>window.alert('فی و ضریبی برای این کالا ثبت نشده است !');</script>";
    return $flag;
   }	
 }
 else $flag=true;  
 if(!empty($c_kala)) //تکراری نبودن کالا
 { 
   $q10="SELECT * FROM resid_detail WHERE shomare_resid='$sh_r' AND code_kala='$c_kala' AND code_keshvar='$c_keshvar' AND code_tolidkonande='$c_tolid' AND code_ostan='$gl_c_o' AND code_anbar='$gl_c_s' AND year='$gl_year'"; 
   $res10=mysql_query($q10);
   $row10=mysql_fetch_assoc($res10);
   if((mysql_num_rows($res10)>0) and ($row10['id']!=$this_id)){
   echo"<script>alert('این کالا با این کشور و تولیدکننده قبلاً در این رسید ثبت شده است!')</script>";
   $flag=false;
   return $flag;
  }
  else $flag=true;
 }
 else $flag=true;
 return $flag;
}
/*************INSERT Detail BUTTON******/// ثبت اطلاعات کالا    
if(isset($Insert_x_detail))
{
  $shomare_safar=$db->get_from_where("shomare_safar","resid INNER JOIN shomare_safar ON resid.id_safar=shomare_safar.id_safar","id=$id_resid_");
  $exist_gharardad=$db->get_from_where("count(*)","gharardad_kharid","shomare_gharardad='".$shomare_safar."'");
  $id_dastorolamal=$db->get_from_where("id_dastorolamal","gharardad_kharid","shomare_gharardad='".$shomare_safar."'");
  if($exist_gharardad>0)//اگر قرارداد دارد
  {
	 $id_gharardad=$db->get_from_where("id_gharardad","gharardad_kharid","shomare_gharardad='".$shomare_safar."' AND deleted=0");
	 $exist_elhaghie=$db->get_from_where("count(*)","elhaghie_kharid","id_gharardad='$id_gharardad' AND deleted=0 AND gheymat_elhaghie>0 AND gheymat_type>0");
	 if($exist_elhaghie>0)//اگر الحاقیه دارد
	 {
	   $gheymat_elhaghie=$db->get_from_where("gheymat_elhaghie","elhaghie_kharid","id_gharardad='$id_gharardad' AND gheymat_elhaghie>0 AND deleted=0 ORDER BY tarikh_elhaghie,id_elhaghie DESC"); 
	   $fee_this=$gheymat_elhaghie;
	 }
	 else//اگر الحاقیه ندارد
	 {
	  
	  $gheymat_har_kilo=$db->get_from_where("gheymat_har_kilo","gharardad_kharid","shomare_gharardad='".$shomare_safar."'");
	  IF($gheymat_har_kilo>0)$fee_this=$gheymat_har_kilo; 
	  ELSE {
		    $gheymat_kharid=$db->get_from_where("gheymat_kharid","gheymat_kharid","id_dastorolamal='".$id_dastorolamal."' AND code_kala=$code_kala ");
	        $fee_this=$gheymat_kharid; 
	  } 
	 }
  }
  
  //{$fee_this=$db->get_from_where("gheymat_har_kilo","gharardad_kharid","shomare_gharardad='".$shomare_safar."'");}

 if(isPermitSave($code_bastebandy_,$noe_tahvil_bar_,$code_kala,$code_keshvar,$code_tolidkonande,$fee_this,$zarib_this,$vazn_mabda_r_d,$shomare_resid_,$mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear,$todaydate,$GheymatDetailID))
 {
  $Mode='';
  //$kasry_kol_r_d=$vazn_mabda_r_d;//در ابتدا کسری را مساوی وزن مبدا می گذاریم 
  //محاسبه برای اطمینان
  $kasry_mojaz_r_d=round(floatval(($vazn_mabda_r_d)*($zarib_this/1000)),2);
  $res1_1=$db->query("SELECT Gh_ID FROM mt_gheymat WHERE Gh_TarikhEtebar>='".$todaydate."' AND Gh_Deleted=0 order by Gh_Shomare DESC LIMIT 0,1");//شماره آخرین جدول قیمت  
  if(mysql_num_rows($res1_1)>0)
  {
   $row1_1=$db->fetch_assoc($res1_1);
   $res1_2=$db->query("SELECT Gd_ID FROM mt_gheymat_detail WHERE Gd_GheymatID=".$row1_1['Gh_ID']." AND Gd_CodeKala='$code_kala' AND Gd_Deleted=0");//بدست آوردن فی 
   $row1_2=$db->fetch_assoc($res1_2);
   $Re_GheymatDetailID=$row1_2['Gd_ID'];
  }
  $insert_detail_q=("INSERT INTO resid_detail(code_ostan,code_anbar,shomare_resid,year,code_kala,code_keshvar,code_tolidkonande,id_gheymat_this,fee_this,zarib_this,nerkh_takhlie_this,vazn_mabda_r_d,kasry_mojaz_r_d,Re_GheymatDetailID,status)
                     VALUES('$mt_gl_code_ostan','$mt_gl_code_anbar','$shomare_resid_','$mtActiveYear','$code_kala','$code_keshvar','$code_tolidkonande','$id_gheymat_this','$fee_this','$zarib_this','$nerkh_takhlie_this','$vazn_mabda_r_d','$kasry_mojaz_r_d','$GheymatDetailID',0)");  
  $insert_detail_res=mysql_query($insert_detail_q);
  if($insert_detail_res)
  {
   /*لاگ*/
   $max_id=$db->get_from_where("MAX(id)","$TableName","shomare_resid='$shomare_resid_' AND code_kala='$code_kala' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear'");   
   $log_i=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$max_id','ثبت',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')");   
   /**********************************/
   // /*خواندن اطلاعات جدول resid*/
    // $q_resid="SELECT vazn_mabda_r,kasry_mojaz_r FROM resid WHERE shomare_resid='$shomare_resid_' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear'";	
	// $resid_res = $db->query($q_resid);
    // $row_resid=$db->fetch_assoc($resid_res);
   // /**محاسبات مربوط به resid**/
    // $vazn_mabda_new=$row_resid['vazn_mabda_r']+$vazn_mabda_r_d;//آپدیت وزن مبدأ
    // $kasry_mojaz_new=$row_resid['kasry_mojaz_r']+$kasry_mojaz_r_d;//آپدیت کسری مجاز
    // $edit_resid_q=("UPDATE resid SET vazn_mabda_r='$vazn_mabda_new',kasry_mojaz_r='$kasry_mojaz_new' WHERE shomare_resid='$shomare_resid_' AND code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND year=$mtActiveYear;");  
    // $edit_resid_res=mysql_query($edit_resid_q);
    
  }
  else $message ='<span style="color:red;font: bold 12px tahoma;"> * مشکلی در ثبت کالا به وجود آمده است ! *</span>';
  //خواندن موجودی  
   // $q_m="SELECT * from mojody_kala where code_kala=$code_kala AND code_keshvar=$code_keshvar AND sal_tolid_shamsi=$sal_tolid_shamsi AND mah_tolid_shamsi=$mah_tolid_shamsi AND code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND year=$mtActiveYear AND deleted=0";       
   // $res_m=mysql_query($q_m);
   // $row_m=mysql_fetch_assoc($res_m);
   // //آپدیت موجودی کالا
   // $update_mojody_nakhales=$row_m['mojody_nakhales']+$vazn_nakhales_r_d;//آپدیت موجودی ناخالص کالا در جدول موجودی کالا  
   // $update_mojody_khales=$row_m['mojody_khales']+$vazn_khales_r_d;//آپدیت موجودی خالص کالا در جدول موجودی کالا
   // $update_tedad_karton=$row_m['tedad_karton']+$tedad_karton_r_d;//آپدیت تعداد کارتن های موجود در انبار
   // $res_update_mojody=$db->query("UPDATE mojody_kala SET mojody_khales='$update_mojody_khales',mojody_nakhales='$update_mojody_nakhales',tedad_karton='$update_tedad_karton' WHERE code_kala='$code_kala' AND code_keshvar='$code_keshvar' AND sal_tolid_shamsi='$sal_tolid_shamsi' AND mah_tolid_shamsi='$mah_tolid_shamsi' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0");   
 }
}
/************EDIT BUTTON********/// اصلاح اطلاعات
if (isset($Edit_x_detail))
{
  $shomare_safar=$db->get_from_where("shomare_safar","resid INNER JOIN shomare_safar ON resid.id_safar=shomare_safar.id_safar","id=$id_resid_");
  $exist_gharardad=$db->get_from_where("count(*)","gharardad_kharid","shomare_gharardad='".$shomare_safar."'");
  $id_dastorolamal=$db->get_from_where("id_dastorolamal","gharardad_kharid","shomare_gharardad='".$shomare_safar."'");
  if($exist_gharardad>0)//اگر قرارداد دارد
  {$fee_this=$db->get_from_where("gheymat_kharid","gheymat_kharid","id_dastorolamal='".$id_dastorolamal."' AND code_kala=$code_kala ");}
 
 if(isPermitEdit($code_bastebandy_,$noe_tahvil_bar_,$code_kala,$code_keshvar,$code_tolidkonande,$fee_this,$zarib_this,$vazn_mabda_r_d,$shomare_resid_,$id_,$mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear,$todaydate,$GheymatDetailID))
 {
  $Mode='';
  //محاسبه برای اطمینان
  $kasry_mojaz_r_d=round(floatval(($vazn_mabda_r_d)*($zarib_this/1000)),2);
  $res1_1=$db->query("SELECT Gh_ID FROM mt_gheymat WHERE Gh_TarikhEtebar>='".$todaydate."' AND Gh_Deleted=0 order by Gh_Shomare DESC LIMIT 0,1");//شماره آخرین جدول قیمت  
  if(mysql_num_rows($res1_1)>0)
  {
   $row1_1=$db->fetch_assoc($res1_1);
   $res1_2=$db->query("SELECT Gd_ID FROM mt_gheymat_detail WHERE Gd_GheymatID=".$row1_1['Gh_ID']." AND Gd_CodeKala='$code_kala' AND Gd_Deleted=0");//بدست آوردن فی 
   $row1_2=$db->fetch_assoc($res1_2);
   $Re_GheymatDetailID=$row1_2['Gd_ID'];
  }
  $edit_q=("UPDATE $TableName SET code_kala='$code_kala',code_keshvar='$code_keshvar',code_tolidkonande='$code_tolidkonande',id_gheymat_this='$id_gheymat_this',fee_this='$fee_this',zarib_this='$zarib_this',nerkh_takhlie_this='$nerkh_takhlie_this',vazn_mabda_r_d='$vazn_mabda_r_d',kasry_mojaz_r_d='$kasry_mojaz_r_d',Re_GheymatDetailID='$GheymatDetailID' WHERE `id`='$id_';");	
  $edit_res=$db->query($edit_q,'مشکلي در ويرايش مشخصات به وجود آمده است');
  $log_e=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_','ویرایش',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')");  
 } 
}
/************DELETE BUTTON********/// حذف کالا از رسید
if (isset($Delete_x_detail))
{
 $Mode=''; 
 $del_detail_q = "DELETE FROM $TableName WHERE id=$id_ 
                  AND($shomare_resid_ NOT IN(SELECT shomare_resid FROM resid_kala_detail WHERE shomare_resid=$shomare_resid_ AND code_kala=$code_kala_ AND code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND year=$mtActiveYear))";
 $del_detail_res = mysql_query($del_detail_q);
 if(mysql_affected_rows()==0)
   echo"<script>alert('برای این کالا جزئیاتی ثبت شده برای حذف ، ابتدا جزئیات را حذف نمایید!')</script>";
 else if($del_detail_res)
   {$log_d=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_','حذف',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')");
   //echo "<script>window.location=resid_detail.php?shomare_resid_=".$shomare_resid."&PageNo=".$PageNo."&RowPerPage=".$RowPerPage."&order=".$order."';</script>";
   }
 else $message ='<span style="color:red;font: bold 12px tahoma;"> *مشکلی در حذف به وجود آمده است ! *</span>';
 }
/***************************************** MAIN*****************************************/
//قرار گرفتن فوکوس 
//if (($Mode=="Insert")or($Mode=="Search")) $load="document.myform.code_kala.focus();";
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
  <td class="title">
   <div style="position:absolute;top:5px;left:40%;">  افزودن کالا به رسید شماره '.$code_a.$mt_gl_code_anbar.$shomare_resid_.'</div>
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
   <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
	<tr class="table-title">';
/********************sort field***********************/
if(!isset($order))    $order='id DESC';
	echo'
	 <td width="5%">کد کالا</td>
	 <td width="15%">نام کالا</td>
	 <td width="5%">کشور</td>
	 <td width="7%">تولید کننده</td>
	 <td width="10%">وزن مبدأ</td>';
	 if($code_bastebandy_==1)//کارتنی
	 {echo'
	  <td width="8%">تعداد کارتن</td>
	  <td width="12%">مجموع وزن کارتن ها</td>
	  <td width="10%">وزن ناخالص</td>
	  <td width="15%">وزن خالص</td>';
	 }
	 else if($code_bastebandy_==2)//قوطی
	 {echo'
	  <td width="13%">تعداد قوطی</td>
	  <td width="20%">وزن خالص</td>';
	 }
	 else if(($code_bastebandy_==5)OR($code_bastebandy_==6))//دست یا عدد
	 {echo'
	  <td width="33%">تعداد</td>';
	 }
	 else //لاشه و سایر
	 {echo'
	  <td width="13%">تعداد</td>
	  <td width="20%">وزن خالص</td>';
	 }
	 echo'
	 <td width="10%">جزئيات</td>'; 
	 if(($right_del)and($noe_tahvil_bar_!=4)and($noe_tahvil_bar_!=5)and($resid_status==0)and($_SESSION['mtStatusYear']==0)and($sabtNahayi==0))echo'<td width="3%">حذف</td>';
	 else echo'';
	 echo'
	</tr>';
	$i=0;
	$majmo_vazn_mabda=0;
    $majmo_vazn_nakhales=0;	
    $majmo_tedad_karton=0;	
    $majmo_sum_karton_r_d=0;	
    $majmo_vazn_khales_r_d=0;	
    $q1="SELECT *,
	    (SELECT name_kala FROM kala WHERE kala.code_kala=T.code_kala) nameKala,
	    (SELECT name_keshvar FROM keshvar WHERE keshvar.code_keshvar=T.code_keshvar) nameKeshvar,
	    (SELECT name_tolidkonande FROM tolidkonande WHERE tolidkonande.code_tolidkonande=T.code_tolidkonande) nameTolidkonande,
        (SELECT count(*) FROM resid_kala_detail r_k_d WHERE r_k_d.code_kala=T.code_kala AND r_k_d.code_keshvar=T.code_keshvar AND r_k_d.code_tolidkonande=T.code_tolidkonande AND r_k_d.shomare_resid=T.shomare_resid AND r_k_d.code_ostan=T.code_ostan AND r_k_d.code_anbar=T.code_anbar AND r_k_d.year=T.year) detailcount,
        (SELECT SUM(vazn_nakhales_r_d_sub) FROM resid_kala_detail r_k_d WHERE r_k_d.code_kala=T.code_kala AND r_k_d.code_keshvar=T.code_keshvar AND r_k_d.code_tolidkonande=T.code_tolidkonande AND r_k_d.shomare_resid=T.shomare_resid AND r_k_d.code_ostan=T.code_ostan AND r_k_d.code_anbar=T.code_anbar AND r_k_d.year=T.year) vazn_nakhales_r_d,				  
        (SELECT SUM(tedad_karton_r_d_sub) FROM resid_kala_detail r_k_d WHERE r_k_d.code_kala=T.code_kala AND r_k_d.code_keshvar=T.code_keshvar AND r_k_d.code_tolidkonande=T.code_tolidkonande AND r_k_d.shomare_resid=T.shomare_resid AND r_k_d.code_ostan=T.code_ostan AND r_k_d.code_anbar=T.code_anbar AND r_k_d.year=T.year) tedad_karton_r_d,		
        (SELECT SUM(sum_karton_r_d_sub) FROM resid_kala_detail r_k_d WHERE r_k_d.code_kala=T.code_kala AND r_k_d.code_keshvar=T.code_keshvar AND r_k_d.code_tolidkonande=T.code_tolidkonande AND r_k_d.shomare_resid=T.shomare_resid AND r_k_d.code_ostan=T.code_ostan AND r_k_d.code_anbar=T.code_anbar AND r_k_d.year=T.year) sum_karton_r_d		
	     From $TableName T WHERE shomare_resid='$shomare_resid_' AND code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND year=$mtActiveYear order by $order";	
	$all = $db->query($q1);
    while($row1=$db->fetch_assoc($all))
	{	 
	 //$sum_karton_r_d=round(floatval(($row1['tedad_karton_r_d'])*($row1['vazn_karton_this'])),2);//مجموع وزن کارتن ها
	 //$kasry_kol_r_d=$re_row_detail['vazn_mabda_r_d']-$re_row_detail['vazn_nakhales_r_d'];//کل کسری این کالا
	 //if($kasry_kol_r_d==$re_row_detail['vazn_mabda_r_d']) $kasry_kol_r_d=0; 
	 if(($right_edt)and($row1['status']==0)){ $edtClick='onClick="window.location=\''.$FileName.'?Mode=Edit&id_='.$row1['id'].'&id_resid_='.$id_resid_.'&shomare_resid_='.$shomare_resid_.'&noe_tahvil_bar_='.$noe_tahvil_bar_.'&code_bastebandy_='.$code_bastebandy_.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'"';}	 
	 if($i++%2){echo'<tr '; if($row1['status']==0) echo' class="table-odd"'; else echo 'class="row-ebtal"';echo'>';}	 
	 else{echo'<tr '; if($row1['status']==0) echo' class="table-even"'; else echo 'class="row-ebtal"';echo'>';}
     echo'
	  <td '.$edtClick.'>'.$row1['code_kala'].'</td>
	  <td '.$edtClick.'>'.$row1['nameKala'].'</td>
	  <td '.$edtClick.'>'.$row1['nameKeshvar'].'</td>
	  <td '.$edtClick.'>'.$row1['nameTolidkonande'].'</td>';
	  if($noe_tahvil_bar_==2)echo'<td '.$edtClick.'>'.round($row1['vazn_nakhales_r_d'],3).'</td>';
	  else echo'<td '.$edtClick.'>'.round($row1['vazn_mabda_r_d'],3).'</td>';
	  echo'
	  <td '.$edtClick.'>'.$row1['tedad_karton_r_d'].'</td>';
	  if($code_bastebandy_==1)//کارتنی
	  {echo'
	   <td '.$edtClick.'>'.round($row1['sum_karton_r_d'],3).'</td>
	   <td '.$edtClick.'>'.round($row1['vazn_nakhales_r_d'],3).'</td>';
	  }
	  if(($code_bastebandy_!=5)AND($code_bastebandy_!=6))echo'<td '.$edtClick.'>'.round($row1['vazn_khales_r_d'],3).'</td>';
	  echo'
	  <td>';
	  if($right_detail)
	  {
	    if($row1['status']==0)//اگر رسید جاری است
	    {
	     //اگر هنوز جزئیات ندارد
	     if($row1['detailcount']==0) echo'<input type="button" class="button-inline buttonme-empty" value="* جزئيات کالا ['.$row1['detailcount'].']" onClick="popupwindow(\'resid_kala_detail.php?r_d_id_='.$row1['id'].'&code_bastebandy_='.$code_bastebandy_.'&noe_tahvil_bar_='.$noe_tahvil_bar_.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\',\'\',\'1000\',\'400\')" >';
	     else echo'<input type="button" class="button-inline" value="جزئيات کالا ['.$row1['detailcount'].']" onClick="popupwindow(\'resid_kala_detail.php?r_d_id_='.$row1['id'].'&code_bastebandy_='.$code_bastebandy_.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\',\'\',\'1000\',\'400\')" >';
	    }
	    else//اگر رسید ابطالی است 
		{
		 //اگر هنوز جزئیات ندارد
	     if($row1['detailcount']==0) echo'<input type="button" class="buttonme-ebtal"  value="جزئيات کالا ['.$row1['detailcount'].']"  style="cursor:default">';
		 else echo'<input type="button" class="buttonme-ebtal"  value="جزئيات کالا ['.$row1['detailcount'].']" onClick="popupwindow(\'resid_kala_detail.php?r_d_id_='.$row1['id'].'&code_bastebandy_='.$code_bastebandy_.'&noe_tahvil_bar_='.$noe_tahvil_bar_.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\',\'\',\'1000\',\'400\')" >';
		 //else echo'<input type="button" class="buttonme-ebtal"  value="جزئيات کالا ['.$row1['detailcount'].']" onClick="window.showModalDialog(\'resid_kala_detail.php?r_d_id_='.$row1['id'].'&code_bastebandy_='.$code_bastebandy_.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\',\'_blank\',\'dialogwidth=1000px,dialogheight=390px,dialogleft=200px,dialogtop=100px,scrollbars=yes\')" >';
	  	}
	     // if($row1['status']==0)
	     // {
		 // //اگر هنوز جزئیات ندارد
	     // if($row1['detailcount']==0) echo'<input type="button" class="buttonme-empty" value="* جزئيات کالا ['.$row1['detailcount'].']" onClick="window.location=\'resid_kala_detail.php?r_d_id_='.$row1['id'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'">';
	     // else echo'<input type="button" class="buttonme" value="جزئيات کالا ['.$row1['detailcount'].']" onClick="window.location=\'resid_kala_detail.php?r_d_id_='.$row1['id'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'">';
	     // }
		 // else echo'<input type="button" class="buttonme-ebtal"  value="جزئيات کالا ['.$row1['detailcount'].']" onClick="window.location=\'resid_kala_detail.php?r_d_id_='.$row1['id'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'">';
	  }
	  echo'
	  </td>';
	  if(($right_del)and($noe_tahvil_bar_!=4)and($noe_tahvil_bar_!=5)and($row1['status']==0)and($_SESSION['mtStatusYear']==0)and($sabtNahayi==0))
	  {
	   echo'<td>
	       <img border="0" class="1" src="images/trash.png" width="20" height="20" 
	       onmouseOver="this.src=\'images/trash_hover.png\'" 
		   onmouseOut="this.src=\'images/trash.png\'" ';
		   if($row1['detailcount']>0)echo'onClick="iconfirm(\''.$FileName.'?Delete_x_detail=1&id_='.$row1['id'].'&id_resid_='.$id_resid_.'&shomare_resid_='.$shomare_resid_.'&noe_tahvil_bar_='.$noe_tahvil_bar_.'&code_bastebandy_='.$code_bastebandy_.'&code_kala_='.$row1['code_kala'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\',\'برای این کالا جزئیاتی ثبت شده است، آیابرای حذف کالای '.$row1['nameKala'].' از رسید\')" ';
		   else echo'onClick="iconfirm(\''.$FileName.'?Delete_x_detail=1&id_='.$row1['id'].'&id_resid_='.$id_resid_.'&shomare_resid_='.$shomare_resid_.'&noe_tahvil_bar_='.$noe_tahvil_bar_.'&code_bastebandy_='.$code_bastebandy_.'&code_kala_='.$row1['code_kala'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\',\'برای حذف کالای '.$row1['nameKala'].' از رسید\')" ';
		   echo'/></td>';
	  }
	echo'
	</tr>';
	if($noe_tahvil_bar_==2)$majmo_vazn_mabda+=$row1['vazn_nakhales_r_d'];
	else $majmo_vazn_mabda+=$row1['vazn_mabda_r_d'];
	$majmo_vazn_nakhales+=$row1['vazn_nakhales_r_d'];
	$majmo_tedad_karton+=$row1['tedad_karton_r_d'];
     if($code_bastebandy_==1)//کارتنی
     { $majmo_sum_karton_r_d+=$row1['sum_karton_r_d'];
	   $majmo_vazn_khales_r_d+=$row1['vazn_khales_r_d'];
     }	
 	}
	for ($r=$i+1; $r<=$RowPerPage_detail; $r++)
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
	  <td>&nbsp;</td>';
	  if(($code_bastebandy_!=5)AND($code_bastebandy_!=6))echo'<td>&nbsp;</td>';
	  if($code_bastebandy_==1)echo'<td>&nbsp;</td><td>&nbsp;</td>';
	  if(($right_del)and($noe_tahvil_bar_!=4)and($noe_tahvil_bar_!=5)and($resid_status==0)and($_SESSION['mtStatusYear']==0)and($sabtNahayi==0)) echo'<td>&nbsp;</td>';
	 echo'
	 </tr>';
	}
	echo'
	<tr class="table-title">
	 <td colspan="4">مجموع مقادیر</td>
      <td>'.round($majmo_vazn_mabda,3).'</td>
	  <td>'.$majmo_tedad_karton.'</td>';
	  if($code_bastebandy_==1)//کارتنی
	  {
	   echo'
	   <td>'.round($majmo_sum_karton_r_d,3).'</td>
	   <td>'.round($majmo_vazn_nakhales,3).'</td>';
	  } 
	  if(($code_bastebandy_!=5)AND($code_bastebandy_!=6))echo'<td>'.round($majmo_vazn_khales_r_d,3).'</td>';
	 echo'
	 <td>&nbsp;</td>';
	 if(($right_del)and($noe_tahvil_bar_!=4)and($noe_tahvil_bar_!=5)and($resid_status==0)and($_SESSION['mtStatusYear']==0)and($sabtNahayi==0)) echo'<td>&nbsp;</td>';
	 echo'
	</tr>
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
     <td width="10">&nbsp;</td>';
	 //اگر اجازه ایجاد رسید را دارد ورسید ابطالی نیست ووضعیت سال فعال است و سال فعال سال جاری است و ثبت نهایی نشده است
	 //if(($right_ins)and($resid_status==0)and($_SESSION['mtStatusYear']==0)and($_SESSION["mtActiveYear"]==$yy))
	 if(($right_ins)and($noe_tahvil_bar_!=4)and($noe_tahvil_bar_!=5)and($noe_tahvil_bar_!=10)and($resid_status==0)and($_SESSION['mtStatusYear']==0)and($sabtNahayi==0))
	 {
	  echo'<td width="70"><div onClick="window.location=\''.$FileName.'?Mode=Insert&id_resid_='.$id_resid_.'&shomare_resid_='.$shomare_resid_.'&noe_tahvil_bar_='.$noe_tahvil_bar_.'&code_bastebandy_='.$code_bastebandy_.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-new" title="افزودن رکورد جديد" ><a href="#"></a></div></td>
 	       <td width="10">&nbsp;</td>';
	 }
	 echo'
	 <td width="70"><div onClick="window.location=\'resid.php?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-back"  title="بازگشت به رسید"  ><a href="#"></a></div></td> 
	 <td width="80%">&nbsp;</td> 
	</tr>
    <span class="tedadcover" align="center" style="height:29px;"> تعداد ['.$cnt.'] </span>';
    }
    if(($Mode=="Insert")and($noe_tahvil_bar_!=4)and($noe_tahvil_bar_!=5))//Insert Mode
    {
	echo '
    <tr> 
	 <td> 	 
	  <table border="0" bgcolor="#E9F7FD" align="center" width="99%" cellpadding="0" cellspacing="0" style="position:absolute;bottom:20px;">
       <tr class="title"><td colspan="11" align="center">افزودن کالای جدید به رسید</td></tr>
       <tr><td>&nbsp;</td></tr>	   
	   <tr>
		<td align="left" width="100px"><span class="star">*</span> کد کالا :&nbsp;</td>
		<td align="right">
		 <input type="hidden" name="id_resid_" value="'.$id_resid_.'" />
         <input class="textboxme2 textbox50" readonly type="text" name="code_kala" value="'.$code_kala.'" maxlength="3" onkeypress="return isNumber(event)" onKeyUp="F10desc(event)" onfocus="getDetailKala2(this.value,document.myform.id_resid_.value);" onchange="getDetailKala2(this.value,document.myform.id_resid_.value);"/>';
		echo' <img border="0" src="images/help.png" onClick="popupwindow(\'help_kala_bastebandy.php?parent_page='.$FileName.'&c_k_e='.$code_kala_eblagh.'&c_baste_='.$code_bastebandy_.'&n_t_b_='.$noe_tahvil_bar_.'&shomare_resid_='.$shomare_resid_.'\',\'\',800,400)" title="جدول کد کالا" style="width:22px;height:22px;cursor:pointer" onmouseOver="this.src=\'images/help_hover.png\'" onmouseOut="this.src=\'images/help.png\'"/>';

		//include('img_helpkalabastebandy.php');
		echo'	
		</td>
		<td align="left" width="">نام کالا :&nbsp;</td><td align="right"><input class="textboxme" readonly type="text" name="name_kala" id="name_kala" value="'.$name_kala.'"/></td>
		  <input type="hidden" id="id_gheymat_this" name="id_gheymat_this" value="'.$id_gheymat_this.'"/></td>
		<td align="left" width="">فی :&nbsp;</td><td align="right"><input type="text" class="textboxme2" readonly name="fee_this" id="fee_this" value="'.$fee_this.'"/></td>
	    <td align="left" width="">ضریب :&nbsp;</td><td align="right"><input type="text" class="textboxme2" readonly id="zarib_this" name="zarib_this" value="'.$zarib_this.'"/></td>';
	    //اگر نوع تحویل بار روباری باشد
		if($noe_tahvil_bar_==2) echo "";
		else echo'<td align="left" width="">نرخ تخلیه :&nbsp;</td><td align="right"><input type="text" class="textboxme2" readonly id="nerkh_takhlie_this" name="nerkh_takhlie_this" value="'.$nerkh_takhlie_this.'"/></td>';
	   echo'
	   </tr>
	   <tr>
	   	<td align="left"><span class="star">*</span> کد کشور :&nbsp;</td>
		<td align="right"><input class="textboxme2 textbox50" type="text" name="code_keshvar" value="'.$code_keshvar.'" onkeypress="return isNumber(event)" onfocus="getDetailKeshvar(this.value);" onblur="getDetailKeshvar(this.value);"/>';
         include('img_helpkeshvar.php');
		echo'
		</td>		
		<td align="left"> نام کشور :&nbsp;</td><td align="right"><input type="text" readonly class="textboxme2" name="name_keshvar" id="name_keshvar" value="'.$name_keshvar.'"/></td>
	    <td align="left"><span class="star">*</span> کد تولیدکننده :&nbsp;</td><td align="right"><input class="textboxme2 textbox50" type="text" name="code_tolidkonande" value="'.$code_tolidkonande.'" onkeypress="return isNumber(event)" onfocus="getDetailTolid(this.value);" onblur="getDetailTolid(this.value);"/>';
		 include('img_helptolid.php');
		echo'
		</td>
        <td align="left"> نام تولیدکننده :&nbsp;</td><td align="right" ><input class="textboxme2" type="text" readonly id="name_tolidkonande" name="name_tolidkonande" value="'.$name_tolidkonande.'" /></td>
       </tr>
	   <tr>';
	    if(($noe_tahvil_bar_==2)or($noe_tahvil_bar_==5))//اگر نوع تحویل بار روباری یا جابه جایی روباری باشد
        echo "";
		else 
		{
	 	  echo'
		  <td align="left"><span class="star">*</span> وزن مبدأ :&nbsp;</td><td align="right"><input type="text" class="textboxme2" name="vazn_mabda_r_d" value="'.($vazn_mabda_r_d).'" onblur="return mojaz()" onKeydown="return PressfloatOnly(event,this)"/></td>
		  <td align="left"> کسری مجاز :&nbsp;</td><td align="right"><input type="text" readonly class="textboxme2" name="kasry_mojaz_r_d" value="'.$kasry_mojaz_r_d.'"/></td>';
	    }
		echo'
		        <!--<td align="left"> تعداد کارتن :&nbsp;</td><td align="right"><input class="textboxme2" type="text" readonly name="tedad_karton_r_d" value="'.$tedad_karton_r_d.'" onblur="return sumkarton()"  onkeypress="return isNumber(event)"/></td>       		
	   	         <td align="left"> مجموع وزن کارتن ها :&nbsp;</td><td align="right"><input class="textboxme2" readonly type="text" name="sum_karton_r_d" value="'.$sum_karton_r_d.'"/></td>-->
	     <td align="left"> انتخاب نرخ :&nbsp;</td><td align="right"> 
	      <input type="hidden" name="GheymatDetailID" value="'.$GheymatDetailID.'"/>
	      <input type="text" readonly class="textboxme" name="gd_fee" value="'.$gd_fee.'" style="width:50px" onfocus="return mablaghRiali(document.myform.mojody_khales_aval.value,this.value);"/>';
		  include("img_helpnerkh.php");
		  echo'
		 </td>
	   </tr>
	   
	         <!--<tr>
	            <td align="left"> وزن ناخالص :&nbsp;</td><td align="right"><input class="textboxme2" readonly type="text" name="vazn_nakhales_r_d" value="'.$vazn_nakhales_r_d.'" onblur="return vazn_khales_resid()" onkeypress="return isNumber(event)"/></td>
		         <td align="left"> وزن خالص :&nbsp;</td><td align="right"><input class="textboxme2" readonly type="text" name="vazn_khales_r_d" value="'.$vazn_khales_r_d.'" onfocus="return vazn_khales_resid()"/></td>
	           </tr>
	           <tr>
	           	<td align="left">کل کسری :&nbsp;</td><td align="right"><input type="text" readonly class="textboxme2" name="kasry_kol" value="'.$kasry_kol.'"/></td>
	           	<td align="left">کسری غیر مجاز :&nbsp;</td><td align="right"><input type="text" readonly class="textboxme2" name="kasry_gheyremojaz" value="'.$kasry_gheyremojaz.'" /></td>
	            <td align="left">وزن اضافه :&nbsp;</td><td align="right"><input type="text" readonly class="textboxme2" name="vazn_ezafe" value="'.$vazn_ezafe.'"/></td>
	           </tr>
	           <tr>
	            <td align="left">مبلغ جریمه کسری :&nbsp;</td><td align="right"><input type="text" readonly class="textboxme2" name="mablagh_jarimekasry_r_d" value="'.$mablagh_jarimekasry_r_d.'"/></td>
	            <td align="left">مبلغ تخلیه :&nbsp;</td><td align="right"><input type="text" readonly class="textboxme2" name="mablagh_takhlie_r_d" value="'.$mablagh_takhlie_r_d.'"/></td>
	           </tr>-->
	   <tr class="title">
         <td colspan="11" align="center">
		 <input class="buttonme" type="submit" name="Insert_x_detail" id="sabt" value="ثبت">
         <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?id_resid_='.$id_resid_.'&shomare_resid_='.$shomare_resid_.'&noe_tahvil_bar_='.$noe_tahvil_bar_.'&code_bastebandy_='.$code_bastebandy_.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'">
        </td>
       </tr>
      </table>
	 </td>
    </tr>';
    }
    if ($Mode=="Edit")//Edit Mode
    {
	$q2="SELECT *,
	      (SELECT sabt_nahayi FROM resid WHERE resid.code_ostan=T.code_ostan AND resid.code_anbar=T.code_anbar AND resid.year=T.year AND resid.shomare_resid=T.shomare_resid) sabtNahayi,
	      (SELECT name_kala FROM kala WHERE kala.code_kala=T.code_kala) nameKala,
	      (SELECT name_keshvar FROM keshvar WHERE keshvar.code_keshvar=T.code_keshvar) nameKeshvar,
		  (SELECT name_tolidkonande FROM tolidkonande WHERE tolidkonande.code_tolidkonande=T.code_tolidkonande) nameTolidkonande,
		  (SELECT SUM(vazn_nakhales_r_d_sub) FROM resid_kala_detail r_k_d WHERE r_k_d.code_kala=T.code_kala AND r_k_d.code_keshvar=T.code_keshvar AND r_k_d.code_tolidkonande=T.code_tolidkonande AND r_k_d.shomare_resid=T.shomare_resid AND r_k_d.code_ostan=T.code_ostan AND r_k_d.code_anbar=T.code_anbar AND r_k_d.year=T.year) vazn_nakhales_r_d,
          (SELECT SUM(tedad_karton_r_d_sub) FROM resid_kala_detail r_k_d WHERE r_k_d.code_kala=T.code_kala AND r_k_d.code_keshvar=T.code_keshvar AND r_k_d.code_tolidkonande=T.code_tolidkonande AND r_k_d.shomare_resid=T.shomare_resid AND r_k_d.code_ostan=T.code_ostan AND r_k_d.code_anbar=T.code_anbar AND r_k_d.year=T.year) tedad_karton_r_d,				  
          (SELECT SUM(sum_karton_r_d_sub) FROM resid_kala_detail r_k_d WHERE r_k_d.code_kala=T.code_kala AND r_k_d.code_keshvar=T.code_keshvar AND r_k_d.code_tolidkonande=T.code_tolidkonande AND r_k_d.shomare_resid=T.shomare_resid AND r_k_d.code_ostan=T.code_ostan AND r_k_d.code_anbar=T.code_anbar AND r_k_d.year=T.year) sum_karton_r_d,		
		  (SELECT count(*) FROM resid_kala_detail r_k_d WHERE r_k_d.code_kala=T.code_kala AND r_k_d.code_keshvar=T.code_keshvar AND r_k_d.shomare_resid=T.shomare_resid AND r_k_d.code_ostan=T.code_ostan AND r_k_d.code_anbar=T.code_anbar AND r_k_d.year=T.year) exist_detail,
		  (SELECT Gd_Fee FROM mt_gheymat_detail WHERE mt_gheymat_detail.Gd_ID=T.Re_GheymatDetailID)Gd_Fee
		  FROM $TableName T WHERE id='$id_'";	  
	 $res2=$db->query($q2);
	 $row2=$db->fetch_assoc($res2);
     //$vazn_khales_r_d_edit=$row2['vazn_nakhales_r_d']-$row2['sum_karton_r_d'];//وزن خالص
	 $kasry_kol_r_d_edit=$row2['vazn_mabda_r_d']-$row2['vazn_nakhales_r_d'];//کل کسری این کالا
	   if($kasry_kol_r_d_edit==$row2['vazn_mabda_r_d'])//اگر هنوز وزن ناخالص را ثبت نکرده ایم
	   { $kasry_kol_r_d_edit=0;
	     $kasry_gheyremojaz_r_d_edit=0;
 	   }
	  if($kasry_kol_r_d_edit<0) $kasry_kol_r_d_edit=0;//اگر جواب منفی شد
	 $kasry_gheyremojaz_r_d_edit=$kasry_kol_r_d_edit-$row2['kasry_mojaz_r_d'];//کسری غیرمجاز این کالا
	  if($kasry_gheyremojaz_r_d_edit<0) $kasry_gheyremojaz_r_d_edit=0;//اگر جواب منفی شد
     $vazn_ezafe_r_d_edit=$row2['vazn_nakhales_r_d']-$row2['vazn_mabda_r_d'];//وزن اضافه
	   if($vazn_ezafe_r_d_edit<0) $vazn_ezafe_r_d_edit=0;//اگر جواب منفی شد
	 /*محاسبه مبلغ جریمه وتخلیه بر اساس هر کالا*/
	 $mablagh_jarimekasry_r_d_edit=$kasry_gheyremojaz_r_d_edit*$row2['fee_this'];//مبلغ جریمه کسری
	 
	 $mablagh_takhlie_r_d_edit=$row2['nerkh_takhlie_this'];//مبلغ تخلیه 
	      /**///$mablagh_takhlie_r_d_edit=$vazn_khales_r_d_edit*$row2['nerkh_takhlie_this'];//مبلغ تخلیه 
		 /**/// $nerkh_baskul=$db->get_from_where("nerkh_baskul","hazine_baskul","az_vazn<='$vazn_khales_r_d_edit' AND ta_vazn>='$vazn_khales_r_d_edit'");
         // //$mablagh_baskul_r_d=$vazn_khales_r_d_edit*$nerkh_baskul;//مبلغ باسکول
         // $mablagh_baskul_r_d=$nerkh_baskul;//مبلغ باسکول
	 if(strlen($mt_gl_code_ostan)==1) $code_a=make_pattern($mt_gl_code_ostan,2);
     else $code_a=$mt_gl_code_ostan;
	 echo'
	 <tr> 
	  <td>  	 
	   <table border="0" bgcolor="#E9F7FD" align="center" width="99%" cellpadding="0" cellspacing="0" style="position:absolute;bottom:20px;">
        <tr class="title"><td colspan="11" align="center">ويرايش '.$row2['nameKala'].' در رسید شماره '.$code_a.$mt_gl_code_anbar.$shomare_resid_.'</td></tr>		
	    <tr><td>&nbsp;</td></tr>
		<tr>
		 <td colspan="3">
		  <table width="100%">
		   <tr>
		   	<td align="left">
			<input type="hidden" name="id_resid_" value="'.$id_resid_.'" />';
		    if(SuperUser())echo 'id: '.$row2['id'].'&nbsp;&nbsp;';
	    	if($row2['exist_detail']){echo'<span class="star">*</span> کد کالا : </td><td align="right"><input class="textboxme2" readonly type="text" title="غیر قابل تغییر" name="code_kala" readonly value="'.$row2['code_kala'].'" style="width:50px;cursor:pointer;"/> <img border="0" src="images/readonly.png" title="غیر قابل تغییر" class="dontchange"/></td>';}
	        else 
	    	{echo'<span class="star">*</span> کد کالا : </td><td align="right"><input class="textboxme2" type="text" name="code_kala" value="'.$row2['code_kala'].'" readonly maxlength="3" onkeypress="return isNumber(event)" onKeyUp="F10desc(event)" onchange="getDetailKala2(this.value);" onfocus="getDetailKala2(this.value);" style="width:50px"/>';
             //include('img_helpkalabastebandy.php');
			 echo'
			 </td>';}
	    	echo'
	    	<td align="left" width="">نام کالا : </td><td align="right"><input class="textboxme" readonly type="text" name="name_kala" id="name_kala" value="'.$row2['nameKala'].'"/>
	    	  <input type="hidden"  id="id_gheymat_this" name="id_gheymat_this" value="'.$id_gheymat_this.'"/></td>
	    	<td align="left" width="">فی : </td><td align="right"><input type="text" class="textboxme2" readonly name="fee_this" id="fee_this" value="'.$row2['fee_this'].'"/></td>
	        <td align="left" width="">ضریب : </td><td align="right"><input type="text" class="textboxme2" readonly id="zarib_this" name="zarib_this" value="'.$row2['zarib_this'].'"/></td>';
	        //اگر نوع تحویل بار روباری باشد
	    	//if($noe_tahvil_bar_==2) echo "";
	    	//else echo'<td align="left" width="">نرخ تخلیه : &nbsp;</td><td align="right"><input type="text" class="textboxme2" readonly id="nerkh_takhlie_this" name="nerkh_takhlie_this" value="'.$row2['nerkh_takhlie_this'].'"/></td>';
		   echo'
	       </tr>
		   <tr>';
		    if($row2['exist_detail']){echo'<td align="left"><span class="star">*</span> کد کشور تولید کننده :</td><td align="right"><input class="textboxme2" type="text" title="غیر قابل تغییر" name="code_keshvar" readonly value="'.$row2['code_keshvar'].'" style="width:50px;cursor:pointer;"/> <img border="0" src="images/readonly.png" title="غیر قابل تغییر" class="dontchange"/></td>';}
	        else
	        {echo'
	         <td align="left"><span class="star">*</span> کد کشور تولید کننده :</td>
		     <td align="right"><input class="textboxme2" type="text" name="code_keshvar" value="'.$row2['code_keshvar'].'" onkeypress="return isNumber(event)" onfocus="getDetailKeshvar(this.value);" onblur="getDetailKeshvar(this.value);" style="width:50px"/>';
              include('img_helpkeshvar.php');
			 echo'
			 </td>';
			 }
            echo'  		
		    <td align="left"> نام کشور : </td><td align="right"><input type="text" readonly class="textboxme" name="name_keshvar" id="name_keshvar" value="'.$row2['nameKeshvar'].'"/></td>';
	        if($row2['exist_detail'])echo'<td align="left"><span class="star">*</span> کد تولیدکننده :</td><td align="right"><input class="textboxme2 textbox50" title="غیر قابل تغییر" type="text" name="code_tolidkonande" value="'.$row2['code_tolidkonande'].'" readonly/> <img border="0" src="images/readonly.png" title="غیر قابل تغییر" class="dontchange"/></td>';
	        else 
		    {echo'<td align="left"><span class="star">*</span> کد تولیدکننده :</td><td align="right"><input class="textboxme2 textbox50" type="text" name="code_tolidkonande" value="'.$row2['code_tolidkonande'].'" onkeypress="return isNumber(event)" onfocus="getDetailTolid(this.value);" onblur="getDetailTolid(this.value);"/>';
		     include('img_helptolid.php');echo'</td>';
		    }
		    echo'	
            <td align="left"> نام تولیدکننده : </td><td align="right" ><input class="textboxme2" type="text" readonly id="name_tolidkonande" name="name_tolidkonande" value="'.$row2['nameTolidkonande'].'" /></td>
	       </tr>
		  </table>
         </td>
        </tr>		 
	   <tr>
	   </tr>
	   <tr>
	    <td colspan="" valign="top" width="">
	     <fieldset>
	      <legend>وزن</legend>
	       <table width="100%">';
		   //اگر نوع تحویل بار روباری یا جابه جایی روباری نباشد
            //if($row2['exist_detail'])
            //if(($noe_tahvil_bar_!=2)and($noe_tahvil_bar_!=5))
            if(($noe_tahvil_bar_!=2))
			{
			 if($row2['sabtNahayi']==1)echo'<td align="left"><span class="star">*</span> وزن مبدأ : </td><td align="right"><input class="textboxme2" type="text" title="غیر قابل تغییر" name="vazn_mabda_r_d" readonly value="'.$row2['vazn_mabda_r_d'].'" style="cursor:pointer;"/></td>';
			 else {echo'<td align="left"><span class="star">*</span> وزن مبدأ : </td><td align="right"><input type="text" class="textboxme2" name="vazn_mabda_r_d" value="'.($row2['vazn_mabda_r_d']).'" onblur="return mojaz()" onKeydown="return PressfloatOnly(event,this)"/></td>';} 
            }
			if($code_bastebandy_==1)
			{echo'
	         <tr><td align="left"> وزن ناخالص : </td><td align="right"><input type="text" readonly class="textboxme2" name="vazn_khales_r" value="'.($row2['vazn_nakhales_r_d']).'"/></td></tr>
	         <tr><td align="left"> تعداد کارتن ها : </td><td align="right"><input type="text" readonly class="textboxme2" name="tedad_karton_r" value="'.$row2['tedad_karton_r_d'].'"/></td></tr>
	         <tr><td align="left"> وزن کارتن ها : </td><td align="right"><input type="text" readonly class="textboxme2" name="vazn_khales_r" value="'.round($row2['sum_karton_r_d'],3).'"/></td></tr>
	         <tr><td align="left"> وزن خالص : </td><td align="right"><input type="text" readonly class="textboxme2" name="vazn_khales_r" value="'.($row2['vazn_khales_r_d']).'"/></td></tr>';
			}
            if($code_bastebandy_==2)
			{echo'
	         <tr><td align="left"> تعداد قوطی : </td><td align="right"><input type="text" readonly class="textboxme2" name="tedad_karton_r" value="'.$row2['tedad_karton_r_d'].'"/></td></tr>
	         <tr><td align="left"> وزن خالص : </td><td align="right"><input type="text" readonly class="textboxme2" name="vazn_khales_r" value="'.($row2['vazn_khales_r_d']).'"/></td></tr>';
			}
			echo'
	       </table>
	      </fieldset>
         </td>';
		// echo'
	    // <td align="left"> تعداد کارتن :&nbsp;</td><td align="right"><input class="textboxme2" type="text" readonly name="tedad_karton_r_d" value="'.$row2['tedad_karton_r_d'].'" onblur="return sumkarton()"  onkeypress="return isNumber(event)"/></td>       		
	   	// <td align="left"> مجموع وزن کارتن ها :&nbsp;</td><td align="right"><input class="textboxme2" readonly type="text" name="sum_karton_r_d" value="'.$sum_karton_r_d_edit.'"/></td>
	   // </tr>
	   // <tr>
	    // <td align="left"> وزن ناخالص :&nbsp;</td><td align="right"><input class="textboxme2" readonly type="text" name="vazn_nakhales_r_d" value="'.$row2['vazn_nakhales_r_d'].'" onblur="return vazn_khales_resid()" onkeypress="return isNumber(event)"/></td>
		// <td align="left"> وزن خالص :&nbsp;</td><td align="right"><input class="textboxme2" readonly type="text" name="vazn_khales_r_d" value="'.$vazn_khales_r_d_edit.'" onfocus="return vazn_khales_resid()"/></td>
	   // </tr>';
	   //اگر نوع تحویل بار روباری باشد
	   if($noe_tahvil_bar_==2) echo "";
	   else 
	   {echo'
	     <td colspan="" valign="top" width="">
	      <fieldset>
	       <legend>کسری</legend>
	        <table width="100%">
	         <tr><td align="left">کل کسری :&nbsp;</td><td align="right"><input type="text" readonly class="textboxme2" name="kasry_kol_r_d" value="'.round($kasry_kol_r_d_edit,3).'"/></td></tr>
	         <tr><td align="left">کسری مجاز :&nbsp;</td><td align="right"><input type="text" readonly class="textboxme2" name="kasry_mojaz_r_d" value="'.$row2['kasry_mojaz_r_d'].'"/></td></tr>
		     <tr><td align="left">کسری غیر مجاز :&nbsp;</td><td align="right"><input type="text" readonly class="textboxme2" name="kasry_gheyremojaz_r_d" value="'.round($kasry_gheyremojaz_r_d_edit,3).'" /></td></tr>
	         <tr><td align="left">وزن اضافه :&nbsp;</td><td align="right"><input type="text" readonly class="textboxme2" name="vazn_ezafe_r_d" value="'.round($vazn_ezafe_r_d_edit,3).'"/></td></tr>
		    </table>
	       </fieldset>
          </td>';
	    }
	    $mablagh_riali=mablaghRiali_detail($row2['Re_GheymatDetailID'],$row2['vazn_khales_r_d']);
		echo'
		<td colspan="" width="" valign="top">
	     <fieldset>
	      <legend>مبالغ</legend>
	       <table width="100%">
		    <tr><td align="left">مبلغ جریمه کسری :&nbsp;</td><td align="right"><input type="text" readonly class="textboxme2" name="mablagh_jarimekasry_r_d" value="'.($mablagh_jarimekasry_r_d_edit).'"/></td></tr>
	        <tr><td align="left">مبلغ تخلیه :&nbsp;</td><td align="right"><input type="text" readonly class="textboxme2" name="mablagh_takhlie_r_d" value="'.($mablagh_takhlie_r_d_edit).'"/></td></tr>
	         <!--<td align="left">مبلغ باسکول :&nbsp;</td><td align="right"><input type="text" readonly class="textboxme2" name="mablagh_baskul_r_d" value="'.($mablagh_baskul_r_d).'"/></td>-->
	        <tr><td align="left"><span class="star">*</span> انتخاب نرخ :&nbsp;</td><td align="right"> 
	          <input type="hidden" name="GheymatDetailID" value="'.$row2['Re_GheymatDetailID'].'"/>
	          <input type="text" readonly class="textboxme" name="gd_fee" value="'.$row2['Gd_Fee'].'" style="width:50px" onfocus="return mablaghRiali(document.myform.mojody_khales_aval.value,this.value);"/>';
		      include("img_helpnerkh.php");
		      echo'
		     </td>
			</tr> 
			<tr><td align="left">مبلغ ریالی کالا : </td><td align="right"><input type="text" class="textboxme2" readonly name="mablagh_riali" value="'.virgul($mablagh_riali).'"/></td></tr>
			</table>
	       </fieldset>
          </td>';
	   echo'
		<tr>
         <td colspan="10" align="center" class="title">'; 
		 if(($noe_tahvil_bar_!=4)and($noe_tahvil_bar_!=5))echo'<input class="buttonme" type="submit" name="Edit_x_detail" id="sabt" value="ثبت تغييرات">';
		 echo'
          <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?id_resid_='.$id_resid_.'&shomare_resid_='.$shomare_resid_.'&noe_tahvil_bar_='.$noe_tahvil_bar_.'&code_bastebandy_='.$code_bastebandy_.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'">
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
/********************END********************/	
 echo'
'.$message .'
</form>
</body>
</html>';	
?>