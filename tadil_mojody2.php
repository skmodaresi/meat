<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="tadil_mojody2.php";
$TableName="tadil_mojody";
$right_ins=0;$right_edt=0;$right_del=0;$right_prt=0;$right_ebtal=0;
if (right(194)) $right_ins=1;
if (right(195)) $right_edt=1;
if (right(196)) $right_del=1; 
if (right(197)) $right_prt=1;
if (right(198)) $right_ebtal=1; 
$q2="SELECT shomare_barge_tadil FROM $TableName where code_ostan='$mt_gl_code_ostan' and code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' order by shomare_barge_tadil DESC LIMIT 0,1";
$res2=$db->query($q2);
$row2=$db->fetch_assoc($res2);
$w=$row2['shomare_barge_tadil'];
if($w) {$shomare_barge_tadil=$w; $shomare_barge_tadil++;}
else $shomare_barge_tadil=1;
$shomare_barge_tadil=make_pattern($shomare_barge_tadil,5);
echo'
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>تعديل موجودی</title>
<link href="styles.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="functions.js"></script>
<link type="text/css" href="styles/jquery-ui-1.8.14.css" rel="stylesheet"/>
<script type="text/javascript" src="scripts/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="scripts/jquery.ui.datepicker-cc.all.min.js"></script>

<script type="text/javascript">
  <!--tooltip  -->
  $(document).ready(function(){
   $(function(){
   $(document).tooltip();
   });
  });
</script>
<script type="text/javascript">		 
$(function(){	    
    $("#datepicker6").datepicker({
        showOn: "button",
        buttonImage: "styles/images/calendar5.png",
        buttonImageOnly: true,
		showButtonPanel: true
    });
	<!--تغییر براساس نوع فرم تعدیل-->
    // $("[name=noe_form_tadil]").bind("change", function (){
      // if($(this).val() == 1)
	  // {
	        // $("#loading").fadeIn("fast");
	        // $(".mojavezhide").show();
	        // $("#loading").fadeOut("fast");	
      // }
      // else 
	  // {
	        // $("#loading").fadeIn("fast");
	        // $(".mojavezhide").hide();
	        // $("#loading").fadeOut("fast");	   
      // }
    // });
 });
function enterIE()
{
   if(window.event.keyCode == 13 && window.event.srcElement.id !=\'sabt\')
   window.event.keyCode = 9;
}
function show()
{
  var x; 
  x=document.myform.code_kala.value;
  if(x==""){ document.getElementById(img_mojody).innerHTML="";return false;}
}
function getDetailMojavez(sh_mo_t)<!--اطلاعات مجوز تعدیل-->
{ 
    $("#loading").fadeIn("fast");
    //alert(sh_mo_t);
	$.post("ajax_tadil.php",{shomareMojavezTadil:sh_mo_t},function(data){			 
			  var splmojavez = data.split("^");
			  $("[name=noe_tadil]").val(splmojavez[0]);
			  $("[name=noe_tadil_desc]").val(splmojavez[1]);
			  $("[name=code_kala]").val(splmojavez[2]);
			  $("[name=name_kala]").val(splmojavez[3]);
			  $("[name=sal_tolid_shamsi]").val(splmojavez[4]);
			  $("[name=mah_tolid_desc]").val(splmojavez[5]);
			  $("[name=mah_tolid_shamsi]").val(splmojavez[6]);
			  $("[name=rouz_tolid_shamsi]").val(splmojavez[7]);
			  $("[name=code_keshvar]").val(splmojavez[8]);
			  $("[name=name_keshvar]").val(splmojavez[9]);
			  $("[name=code_tolidkonande]").val(splmojavez[10]);
			  $("[name=name_tolidkonande]").val(splmojavez[11]);
			  $("[name=code_ziranbar]").val(splmojavez[12]);
			  $("[name=name_ziranbar]").val(splmojavez[13]);
			  $("[name=code_karton]").val(splmojavez[14]);
			  $("[name=vazn_karton_this]").val(splmojavez[15]);
			  $("[name=tedad_karton]").val(splmojavez[16]);
			  $("[name=mojody_nakhales]").val(splmojavez[17]);
			  $("[name=mojody_khales]").val(splmojavez[18]);
			  $("[name=tedad_karton_tadil]").val(splmojavez[19]);
			  $("[name=sum_karton_tadil]").val(splmojavez[20]);
			  $("[name=meghdar_nakhales_tadil]").val(splmojavez[21]);
			  $("[name=meghdar_khales_tadil]").val(splmojavez[22]);
			  $("[name=code_bastebandy]").val(splmojavez[23]);
			  $("[name=id_mojody]").val(splmojavez[24]);
			  $("[name=noe_tadil]").val(splmojavez[25]);
			  $("[name=chkchangeCode]").val(splmojavez[26]);
			  $("[name=change_code_kala]").val(splmojavez[27]);
			  if(splmojavez[0] == 2)<!--نمایش نوع کسری--> 
	          {
	             $(".kasryshow").show();
              }
			  else $(".kasryshow").hide(); 
		 });
    $("#loading").fadeOut("fast");
}
function getDetailKala3(code_kala)<!--اطلاعات کالا-->
{ 
  $("#loading").fadeIn("fast");
  $.ajax({
  type: "POST",
  url: "ajax.php",
  data: {codeKALA3:code_kala},
  success: function(data) {
  			  var splKala = data.split("^");
			  $("#name_kala").val(splKala[0]);
			  $("#img_mojody").html(splKala[1]);
			  //$("[name=code_bastebandy]").val(splKala[2]);		  		  
  },
 });
  $("#loading").fadeOut("fast");
}

function basteband()<!--اطلاعات کالا-->
{
 	var code_baste = $("#code_bastebandy").val();
	if(code_baste == 1)
	{
		       alert(salam);
			   $(".karton_show").show();
			   $(".ghooti_show").hide();
	}

}
function getDetailMojody(code_kala)<!--اطلاعات موجودی-->
{ 
    $("#loading").fadeIn("fast");
    $.post("ajax.php",{codeKALA : code_kala},function(data){			 
			  var splMojody = data.split("^");
			  $("#name_kala").val(splMojody[0]);
			  $("#sharh_vahedkala").val(splMojody[1]);
			  $("#name_keshvar").val(splMojody[2]);
		 });
    $("#loading").fadeOut("fast");
}
function sumkarton()<!--محاسبه مجموع وزن کارتن ها-->
{
 var sum_k;
 sum_k=parseFloat((document.myform.vazn_karton_this.value)*(document.myform.tedad_karton_tadil.value)).toFixed(3);
 document.myform.sum_karton_tadil.value=sum_k;
}
function vazn_khales()<!--محاسبه وزن خالص-->
{
 var natije_vazn;
 natije_vazn=parseFloat((document.myform.meghdar_nakhales_tadil.value)-(document.myform.sum_karton_tadil.value)).toFixed(3);                                      
 if(natije_vazn<0) natije_vazn=0;
 document.myform.meghdar_khales_tadil.value=natije_vazn;
}
function sumghooti()<!--محاسبه وزن قوطی ها یا همان موجودی خالص-->
{
 var sum_k2;
 sum_k2=parseFloat((document.myform.vazn_karton_this.value)*(document.myform.tedad_karton_tadil.value)).toFixed(3);
 document.myform.meghdar_khales_tadil.value=sum_k2;
}
<!--چک کردن کدبسته بندی کالا و نوع بسته بندی انتخاب شده--> 
function validateCodeKala(code_kala,code_bastebandy)
{   
  $("#loading").fadeIn("fast"); 
       $.ajax({
        url: "ajax_validate.php",
        type: "post",
        data:{codekalaForValidate:code_kala,bastebandyForValidate:code_bastebandy},
        success: function(data){$("#codekalaError").html(data);}
    });
  $("#loading").fadeOut("fast");				
}
</script> 
</head>';
if(!(isset($Mode))) $Mode='';
/*************SEARCH BUTTON******/// جستجوی اطلاعات
if(isset($open_filter))
{ $open_filter="";
  $_SESSION['mt_search_tadil']="";
} 
if(isset($Search_x))
{
 $Mode='';
 $Search_x=""; 
 $temp="";
 if($shomare_barge_tadil_sch) $temp.=" and shomare_barge_tadil LIKE '%$shomare_barge_tadil_sch%'";
 if($tarikh_barge_tadil)      $temp.=" and tarikh_barge_tadil LIKE '%$tarikh_barge_tadil%'";
 if($noe_form_tadil)          $temp.=" and noe_form_tadil LIKE '$noe_form_tadil'";
 if($shomare_mojavez_tadil)   $temp.=" and shomare_mojavez_tadil LIKE '%$shomare_mojavez_tadil%'";
 if($code_kala)               $temp.=" and code_kala LIKE '%$code_kala%'";
 if($noe_tadil)               $temp.=" and noe_tadil LIKE '%$noe_tadil%'";
 if($tedad_karton_tadil)      $temp.=" and tedad_karton_tadil LIKE '%$tedad_karton_tadil%'";
 if($meghdar_nakhales_tadil)  $temp.=" and meghdar_nakhales_tadil LIKE '%$meghdar_nakhales_tadil%'";
 if($meghdar_khales_tadil)    $temp.=" and meghdar_khales_tadil LIKE '%$meghdar_khales_tadil%'";
 if($tozihat_tadil)           $temp.=" and tozihat_tadil LIKE '%$tozihat_tadil%'";
 if($temp) {$PageNo=1;$_SESSION['mt_search_tadil']=$temp;} else $_SESSION['mt_search_tadil']="";
}
/********************PAGING***********************/
if(isset($_POST['wRowPerPage'])) $RowPerPage=$_POST['wRowPerPage'];
if(!isset($RowPerPage)) $RowPerPage=8;
$res = $db->query("SELECT COUNT(*) FROM $TableName WHERE 1=1 ".$_SESSION['mt_search_tadil']." AND code_ostan='$mt_gl_code_ostan' and code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0");
$row = $db->fetch_array($res);
$cnt = $row[0];
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
$tedad_jary=$db->get_from_where("COUNT(*)","$TableName","1=1 ".$_SESSION['mt_search_tadil']." AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0 AND status=0");
$tedad_ebtaly=$db->get_from_where("COUNT(*)","$TableName","1=1 ".$_SESSION['mt_search_tadil']." AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0 AND status=1"); 
/************DELETE BUTTON********/// حذف اطلاعات
if (isset($Delete_x))
{
 $Mode='';
 mysql_query('SET AUTOCOMMIT=0');//TRANSACTIONشروع 
 mysql_query('START TRANSACTION'); 
 $del_q = "update $TableName set deleted=1 WHERE id=$id_";
 $del_res = mysql_query($del_q);
 /*لاگ تعدیل*/$log_d=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_','حذف',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')"); /*کوئری لاگ*/
  //خواندن موجودی با استفاده از تابع 
  $update_tedad_karton=mojodyKarton($mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear,$code_ziranbar_,$code_kala_,$code_keshvar_,$code_tolidkonande_,$sal_tolid_shamsi_,$mah_tolid_shamsi_,$rouz_tolid_shamsi_,$code_karton_);
  $update_mojody_nakhales=mojodyNakhales($mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear,$code_ziranbar_,$code_kala_,$code_keshvar_,$code_tolidkonande_,$sal_tolid_shamsi_,$mah_tolid_shamsi_,$rouz_tolid_shamsi_,$code_karton_);
  $update_mojody_khales=mojodyKhales($mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear,$code_ziranbar_,$code_kala_,$code_keshvar_,$code_tolidkonande_,$sal_tolid_shamsi_,$mah_tolid_shamsi_,$rouz_tolid_shamsi_,$code_karton_);
  IF($code_kala_==50)$update_tedad_shane=$update_tedad_karton*$_SESSION["mtShane"];
  // $mojody_nakhales_again=$db->get_from_where("mojody_nakhales","mojody_kala","id='$idMojody'");   
  // $mojody_khales_again=$db->get_from_where("mojody_khales","mojody_kala","id='$idMojody'");
  // $tedad_karton_again=$db->get_from_where("tedad_karton","mojody_kala","id='$idMojody'");
	// if($noe_tadil_==1)//نوع تعدیل اضافه بود موجودی کاهش یابد 
	// {
	  // $update_tedad_karton=$tedad_karton_again-$tedad_karton_tadil_;//آپدیت تعداد کارتن های موجود در انبار
	  // $update_mojody_nakhales=$mojody_nakhales_again-$meghdar_nakhales_tadil_;//آپدیت موجودی ناخالص کالا در جدول موجودی کالا
	  // $update_mojody_khales=$mojody_khales_again-$meghdar_khales_tadil_;//آپدیت موجودی خالص کالا در جدول موجودی کالا
	// }    	
	// if($noe_tadil_==2)//نوع تعدیل کسری بود موجودی افزایش یابد
	// {
	  // $update_tedad_karton=$tedad_karton_again+$tedad_karton_tadil_;//آپدیت تعداد کارتن های موجود در انبار
	  // $update_mojody_nakhales=$mojody_nakhales_again+$meghdar_nakhales_tadil_;//آپدیت موجودی ناخالص کالا در جدول موجودی کالا
	  // $update_mojody_khales=$mojody_khales_again+$meghdar_khales_tadil_;//آپدیت موجودی خالص کالا در جدول موجودی کالا
	// }
    //آپدیت موجودی کالا    
	$update_mojody_res=$db->query("UPDATE mojody_kala SET mojody_khales='$update_mojody_khales',mojody_nakhales='$update_mojody_nakhales',tedad_karton='$update_tedad_karton',tedad_shane='$update_tedad_shane' WHERE id='$idMojody'");  
    /*لاگ موجودی*/$log_m_e=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','mojody_kala','$idMojody','حذف برگه تعدیل و برگشت موجودی کالا',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')"); /*کوئری لاگ*/   
	if($del_res and $log_d and $update_mojody_res and $log_m_e)
	{
	  mysql_query("COMMIT");
	}
	else
    {
	  mysql_query('ROLLBACK');//nothing will be done, I assume it's for testing
	  $message ='<span style=" color:red;font: bold 12px tahoma;"> * مشکلی در حذف به وجود آمده است ! *</span>';
    }
  mysql_query('SET AUTOCOMMIT=1');   
}//END DELETE 
/************EBTAL BUTTON********/// ابطال 
if (isset($ebtal_x))
{ 
   mysql_query('SET AUTOCOMMIT=0');//TRANSACTIONشروع 
   mysql_query('START TRANSACTION');
   $ebtal_res=FALSE;$log_d=FALSE;$update_mojody_res=FALSE;$log_m_e=FALSE;
   $ebtal_res2=FALSE;$log_d2=FALSE;$update_mojody_res2=FALSE;$log_m_e2=FALSE;
   $ebtal_r_q ="UPDATE $TableName SET status=1 WHERE id=$id_";
   $ebtal_res=mysql_query($ebtal_r_q);
   /*log*/$log_d=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_','ابطال برگه تعدیل',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')");
   //خواندن موجودی با استفاده از تابع 
   $update_tedad_karton=mojodyKarton($mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear,$code_ziranbar_,$code_kala_,$code_keshvar_,$code_tolidkonande_,$sal_tolid_shamsi_,$mah_tolid_shamsi_,$rouz_tolid_shamsi_,$code_karton_);
   $update_mojody_nakhales=mojodyNakhales($mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear,$code_ziranbar_,$code_kala_,$code_keshvar_,$code_tolidkonande_,$sal_tolid_shamsi_,$mah_tolid_shamsi_,$rouz_tolid_shamsi_,$code_karton_);
   $update_mojody_khales=mojodyKhales($mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear,$code_ziranbar_,$code_kala_,$code_keshvar_,$code_tolidkonande_,$sal_tolid_shamsi_,$mah_tolid_shamsi_,$rouz_tolid_shamsi_,$code_karton_);
   IF($code_kala_==50)$update_tedad_shane=$update_tedad_karton*$_SESSION["mtShane"];
   //آپدیت موجودی کالا    
   $update_mojody_res=$db->query("UPDATE mojody_kala SET mojody_khales='$update_mojody_khales',mojody_nakhales='$update_mojody_nakhales',tedad_karton='$update_tedad_karton',tedad_shane='$update_tedad_shane' WHERE id='$idMojody'");  
   /*لاگ موجودی*/$log_m_e=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','mojody_kala','$idMojody','ابطال برگه تعدیل و برگشت موجودی',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')"); /*کوئری لاگ*/   
   
   IF($chkchangeCode_==1)//اگر تعدیل تعویض کد است
   {
	 $shomare_mojavez_tadil=$db->get_from_where("shomare_mojavez_tadil","$TableName","id=$id_");
	 $ebtal_r_q2="UPDATE $TableName SET status=1 WHERE id_tadil_related=$id_ AND shomare_mojavez_tadil='".$shomare_mojavez_tadil."' AND code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND year=$mtActiveYear";
     $ebtal_res2=mysql_query($ebtal_r_q2);
	 $id_tadil=$db->get_from_where("id","tadil_mojody","id_tadil_related=$id_ AND shomare_mojavez_tadil='".$shomare_mojavez_tadil."' AND code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND year=$mtActiveYear");
	 /*log*/$log_d2=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_tadil','ابطال برگه تعدیل تعویض کد',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')");
	 $change_code_kala=$db->get_from_where("change_code_kala","mojavez_tadil","shomare_mojavez_tadil='".$shomare_mojavez_tadil."' AND code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND year=$mtActiveYear");
	 $update_tedad_karton2=mojodyKarton($mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear,$code_ziranbar_,$change_code_kala,$code_keshvar_,$code_tolidkonande_,$sal_tolid_shamsi_,$mah_tolid_shamsi_,$rouz_tolid_shamsi_,$code_karton_);
     $update_mojody_nakhales2=mojodyNakhales($mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear,$code_ziranbar_,$change_code_kala,$code_keshvar_,$code_tolidkonande_,$sal_tolid_shamsi_,$mah_tolid_shamsi_,$rouz_tolid_shamsi_,$code_karton_);
     $update_mojody_khales2=mojodyKhales($mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear,$code_ziranbar_,$change_code_kala,$code_keshvar_,$code_tolidkonande_,$sal_tolid_shamsi_,$mah_tolid_shamsi_,$rouz_tolid_shamsi_,$code_karton_);
	 //آپدیت موجودی کالا    
	 $update_mojody_res2=$db->query("UPDATE mojody_kala SET mojody_khales='$update_mojody_khales2',mojody_nakhales='$update_mojody_nakhales2',tedad_karton='$update_tedad_karton2' WHERE code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND year=$mtActiveYear AND code_kala='$change_code_kala' AND code_ziranbar='$code_ziranbar_' AND code_keshvar='$code_keshvar_' AND code_tolidkonande='$code_tolidkonande_' AND sal_tolid_shamsi='$sal_tolid_shamsi_' AND mah_tolid_shamsi='$mah_tolid_shamsi_' AND rouz_tolid_shamsi='$rouz_tolid_shamsi_' AND code_karton='$code_karton_'");  
     $id_mojody2=$db->get_from_where("id","mojody_kala","code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND year=$mtActiveYear AND code_kala='$change_code_kala' AND code_ziranbar='$code_ziranbar_' AND code_keshvar='$code_keshvar_' AND code_tolidkonande='$code_tolidkonande_' AND sal_tolid_shamsi='$sal_tolid_shamsi_' AND mah_tolid_shamsi='$mah_tolid_shamsi_' AND rouz_tolid_shamsi='$rouz_tolid_shamsi_' AND code_karton='$code_karton_'");
	 /*لاگ موجودی*/$log_m_e2=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','mojody_kala','$id_mojody2','ابطال برگه تعدیل تعویض کد و برگشت موجودی',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')"); /*کوئری لاگ*/   
   
   }
   ELSE {$ebtal_res2=TRUE;$log_d2=TRUE;$update_mojody_res2=TRUE;$log_m_e2=TRUE;}
   
   IF($ebtal_res AND $log_d AND $update_mojody_res AND $log_m_e AND $ebtal_res2 AND $log_d2 AND $update_mojody_res2 AND $log_m_e2)
   {
     //اتصال به وب سرویس
	 $warehouse_id=$db->get_from_where("warehouse_id","list_sardkhane","code_ostan=".$mt_gl_code_ostan." AND code_anbar=".$mt_gl_code_anbar."");     
	 if(($_SESSION['mt_webservice']==1)and($warehouse_id!=''))
     {
	  if(strlen($mt_gl_code_ostan)==1) $code_a=make_pattern($mt_gl_code_ostan,2);
      else $code_a=$mt_gl_code_ostan;
      $shomareGhabz=$mtActiveYear.$code_a.$mt_gl_code_anbar.$shomare_barge_tadil_.'t';   
      //تعدیل اضافه مثل رسید
      IF($noe_tadil_==1) $type_tadil='in'; 
      //تعدیل کسری مثل حواله
      ELSE IF($noe_tadil_==2) $type_tadil='out';
	  $wsdl_url='http://10.7.234.33/anbar/warehouse.asmx?wsdl';
      header('Content-Type: text/html; charset=utf-8');
      try
	  {
	   $client=new SoapClient($wsdl_url);
	   $params=array(
          'username'=>'02',
          'password'=>'HJ78mnGD',
          'type'=>$type_tadil,
          'company_nationalID'=>'14002771736',
          'warehouse_id'=>$warehouse_id,
          'number'=>$shomareGhabz  
	    );
	    $result=$client->RevokeWarehouseDocument($params); 
	    $response=$result->RevokeWarehouseDocumentResult;
	    $webservice_error_code =$response->ErrorCode;
	    $webservice_error_message =$response->ErrorMessage;
	    $webservice_status =$response->status;
	    $webservice_number =$response->number;
	  }
	  catch(Exception $e)
	  {
	  	 echo "<script>alert('وب سرویس فعال نمی باشد')</script>";
	  	 echo  $e->getMessage();
	  }
	  $update_track=("UPDATE tadil_mojody SET webservice_error_code='$webservice_error_code',webservice_error_message='$webservice_error_message',webservice_status='$webservice_status',webservice_number='$webservice_number' WHERE code_ostan=".$mt_gl_code_ostan." AND code_anbar=".$mt_gl_code_anbar." AND shomare_barge_tadil='".$shomare_barge_tadil_."' AND year=$mtActiveYear");
	  $update_res=mysql_query($update_track);  
	 }	
	mysql_query("COMMIT"); 
	echo "<script>window.location='".$FileName."?PageNo=".$PageNo."&RowPerPage=".$RowPerPage."&order=".$order."';</script>";   
   }
   ELSE
   {
	   mysql_query('ROLLBACK');//nothing will be done, I assume it's for testing
	   echo "<script>alert(' مشکلی در ابطال برگه تعدیل به وجود آمده است ')</script>";  
   }
  mysql_query('SET AUTOCOMMIT=1');  		   
}//END EBTAL
/************اجازه براي ذخيره اطلاعات************//**********اجازه براي ويرايش اطلاعات********/
function isPermitSave($sh_barge,$date_barge,$noe_form,$sh_mojavez,$code_baste,$code_zir_a,$c_kala,$c_keshvar,$c_tolid,$sal_t_sh,$mah_t_sh,$rouz_t_sh,$c_karton,$n_tadil,$ted_k,$nakha,$kha,$ted_k_t,$m_nakha_t,$m_kha_t,$gl_c_o,$gl_c_s,$gl_year)
{
 $flag=false;
 if(!($gl_c_o and $gl_c_s and $gl_year) or $gl_c_o==-1 or $gl_c_s==-1)//اگر سشن استان و انبار وسال خالی بود
 {   
   $flag=false;
   echo"<script> alert('لطفاً استان و انبار و سال مورد نظر خود را انتخاب نمایید!')</script>";
   return $flag;
 }
 else $flag=true; 
 //if(!($sh_barge and $date_barge and $noe_form and $code_zir_a and $c_kala and $c_keshvar and $c_tolid and $sal_t_sh and $mah_t_sh and $rouz_t_sh and $n_tadil and $ted_k and $nakha and $kha and $ted_k_t and $m_nakha_t and $m_kha_t))//پر بودن فيلدها
 //if(!($sh_barge and $date_barge and $noe_form and $code_zir_a and $c_kala and $c_keshvar and $c_tolid and $sal_t_sh and $mah_t_sh and $rouz_t_sh and $n_tadil and $m_kha_t))//پر بودن فيلدها
 if(!($sh_barge and $date_barge and $noe_form and $code_zir_a and $c_kala and $c_keshvar and $c_tolid and $sal_t_sh and $mah_t_sh and $rouz_t_sh and $n_tadil))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
   return $flag;
 } 
 else $flag=true;
 if((($code_baste==1)or($code_baste==2)) and(!($c_karton)))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
   return $flag;
 } 
 else $flag=true;
 // if(($code_baste==1)and(!$m_nakha_t) and (!$ted_k_t))//پر بودن فيلدها
 // {
   // $flag=false;
   // echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
   // return $flag;
 // } 
 // else $flag=true;

 if(($code_baste==3)and(!$m_kha_t) and (!$ted_k_t))//پر بودن فيلدها
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
    if(mysql_num_rows($res_kala)==0){
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
     echo"<script>alert('بسته بندی این کالا با نوع بسته بندی انتخاب شده مغایرت دارد \\n امکان انتخاب این کالا وجود ندارد')</script>";
     $flag=false;
     return $flag;
  }
  else $flag=true;
 }
 else $flag=true;
    //if(($n_tadil==2)and(!($ted_k and $nakha and $kha)))//پر بودن فيلدها
 // if(($n_tadil==2)and($code_baste==1)and(!($nakha and $kha)))//پر بودن فيلدها
 // {
   // $flag=false;
   // echo"<script>window.alert('تعداد کارتن یا موجودی ناخالص یا موجودی خالص صفر است!امکان تعدیل کسری نیست');</script>";
   // return $flag;
 // } 
 // else $flag=true;
 if(($noe_form==1)and(!($sh_mojavez)))//اگر نوع فرم دائم بود
 {
   $flag=false;
   echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
   return $flag;
 } 
 else $flag=true;
 if(($n_tadil==2)and($ted_k<$ted_k_t))//اگر تعدیل کسری است وکارتن بیشتر از کارتن موجود
 {
   $flag=false;
   echo"<script>alert('تعداد تعدیلی از تعداد موجود در سردخانه بیشتر است!')</script>";
   return $flag;
 }
 else $flag=true;
 if(($n_tadil==2)and($code_baste==1)and($nakha<$m_nakha_t))//اگر تعدیل کسری است ومقدار ناخالص بیشتر از موجودی ناخالص
 {
   $flag=false;
   echo"<script>alert('مقدار ناخالص تعدیلی از موجودی ناخالص کالا بیشتر است !')</script>";
   return $flag;
 }
 else $flag=true;
 if(($n_tadil==2)and($kha<$m_kha_t))//اگر تعدیل کسری است ومقدار خالص بیشتر از موجودی خالص
 {
   $flag=false;
   echo"<script>alert('مقدار خالص تعدیلی از موجودی خالص کالا بیشتر است !')</script>";
   return $flag;
 }
 else $flag=true;
return $flag;
}
/**********اجازه براي ويرايش اطلاعات********/
function isPermitEdit($date_barge,$noe_form,$sh_mojavez,$date_mojavez,$gl_c_o,$gl_c_s,$gl_year)
{
 $flag=false;
 if(!($gl_c_o and $gl_c_s and $gl_year) or $gl_c_o==-1 or $gl_c_s==-1)//اگر سشن استان و انبار وسال خالی بود
 {   
   $flag=false;
   echo"<script> alert('لطفاً استان و انبار و سال مورد نظر خود را انتخاب نمایید!')</script>";
   return $flag;
 }
 else $flag=true; 
 if(!($date_barge))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
   return $flag;
 } 
 else $flag=true;
 if(($noe_form==1)and(!($sh_mojavez)))//اگر نوع فرم دائم بود
 {
   $flag=false;
   echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
   return $flag;
 } 
 else $flag=true;
 if(checkdatejalali($date_barge)==false)//صحت فرمت تاریخ
 {
	$flag=false;
	echo"<script>window.alert('لطفا تاریخ را صحیح وارد نمایید!');</script>";
    return $flag;
 }
 else $flag=true;
 if($date_barge<$date_mojavez)//صحت فرمت تاریخ
 {
	$flag=false;
	echo"<script>window.alert('تاریخ تعدیل از تاریخ مجوز تعدیل کمتر است ! لطفا تاریخ را صحیح وارد نمایید');</script>";
    return $flag;
 }
 else $flag=true;
return $flag;
}
/*************INSERT  BUTTON******/// ثبت اطلاعات    
if(isset($Insert_x))
{
  //خواندن موجودی با استفاده از تابع 
   $tedad_karton_again=mojodyKarton($mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear,$code_ziranbar,$code_kala,$code_keshvar,$code_tolidkonande,$sal_tolid_shamsi,$mah_tolid_shamsi,$rouz_tolid_shamsi,$code_karton);
   $mojody_nakhales_again=mojodyNakhales($mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear,$code_ziranbar,$code_kala,$code_keshvar,$code_tolidkonande,$sal_tolid_shamsi,$mah_tolid_shamsi,$rouz_tolid_shamsi,$code_karton);
   $mojody_khales_again=mojodyKhales($mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear,$code_ziranbar,$code_kala,$code_keshvar,$code_tolidkonande,$sal_tolid_shamsi,$mah_tolid_shamsi,$rouz_tolid_shamsi,$code_karton);
   //$noe_form_tadil=1;//همیشه دائم
  if(isPermitSave($shomare_barge_tadil,$tarikh_barge_tadil,$noe_form_tadil,$shomare_mojavez_tadil,$code_bastebandy,$code_ziranbar,$code_kala,$code_keshvar,$code_tolidkonande,$sal_tolid_shamsi,$mah_tolid_shamsi,$rouz_tolid_shamsi,$code_karton,$noe_tadil,$tedad_karton_again,$mojody_nakhales_again,$mojody_khales_again,$tedad_karton_tadil,$meghdar_nakhales_tadil,$meghdar_khales_tadil,$mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear))
  { 
   $Mode='';
   mysql_query('SET AUTOCOMMIT=0');//TRANSACTIONشروع 
   mysql_query('START TRANSACTION');
   //$update_mojody_res_change=true;$insert_mojody_res=true;
   // if(($code_bastebandy==1)and($tedad_karton_tadil!=0)and($meghdar_nakhales_tadil!=0))
   // {
    // $sum_karton_tadil=round(floatval($tedad_karton_tadil*$vazn_karton_this),3);
    // $meghdar_khales_tadil=round(floatval($meghdar_nakhales_tadil-$sum_karton_tadil),3);
   // }
   // if(($code_bastebandy==2)and($tedad_karton_tadil!=0))
   // {
    // $meghdar_khales_tadil=round(floatval($tedad_karton_tadil*$vazn_karton_this),3);
   // }
   $signiture ="SELECT sign_id FROM mt_typesign WHERE activate=1 AND type_id=6 AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' ORDER BY turn";
   $allsigniture = $db->query($signiture);
   $separatesigniture='';
   while($row_id=$db->fetch_assoc($allsigniture)) $separatesigniture = $separatesigniture . $row_id['sign_id'].';' ;
   $separatesigniture=rtrim($separatesigniture, ";");
   IF($code_kala==50)$tedad_shane_tadil=$tedad_karton_tadil*$_SESSION["mtShane"];
   $insert_q=("INSERT INTO $TableName
             (code_ostan,code_anbar,shomare_barge_tadil,year,tarikh_barge_tadil,noe_form_tadil,shomare_mojavez_tadil,code_ziranbar,
	 		  code_kala,code_keshvar,code_tolidkonande,sal_tolid_shamsi,mah_tolid_shamsi,rouz_tolid_shamsi,sal_tolid_milady,mah_tolid_milady,rouz_tolid_milady,
			  code_karton,vazn_karton_this,noe_tadil,noe_kasry,tedad_karton_tadil,sum_karton_tadil,meghdar_nakhales_tadil,meghdar_khales_tadil,tedad_shane_tadil,tozihat_tadil,signiture_tadil,deleted)
              VALUES
			 ('$mt_gl_code_ostan','$mt_gl_code_anbar','$shomare_barge_tadil','$mtActiveYear','$tarikh_barge_tadil','$noe_form_tadil','$shomare_mojavez_tadil','$code_ziranbar',
			  '$code_kala','$code_keshvar','$code_tolidkonande','$sal_tolid_shamsi','$mah_tolid_shamsi','$rouz_tolid_shamsi','$sal_tolid_milady','$mah_tolid_milady','$rouz_tolid_milady',
			  '$code_karton','$vazn_karton_this','$noe_tadil','$noe_kasry','$tedad_karton_tadil','$sum_karton_tadil','$meghdar_nakhales_tadil','$meghdar_khales_tadil','$tedad_shane_tadil','$tozihat_tadil','$separatesigniture',0)"); 		 
   //echo $insert_q;
   $insert_res=mysql_query($insert_q);
    /*لاگ تعدیل*/
    $max_id=$db->get_from_where("MAX(id)","$TableName","code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear'");   
	$log_i=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$max_id','ثبت',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')");
	//آپدیت موجودی کالا
    $update_tedad_karton=mojodyKarton($mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear,$code_ziranbar,$code_kala,$code_keshvar,$code_tolidkonande,$sal_tolid_shamsi,$mah_tolid_shamsi,$rouz_tolid_shamsi,$code_karton);
    $update_mojody_nakhales=mojodyNakhales($mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear,$code_ziranbar,$code_kala,$code_keshvar,$code_tolidkonande,$sal_tolid_shamsi,$mah_tolid_shamsi,$rouz_tolid_shamsi,$code_karton);
    $update_mojody_khales=mojodyKhales($mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear,$code_ziranbar,$code_kala,$code_keshvar,$code_tolidkonande,$sal_tolid_shamsi,$mah_tolid_shamsi,$rouz_tolid_shamsi,$code_karton);
    IF($code_kala==50)$update_tedad_shane=$update_tedad_karton*$_SESSION["mtShane"];
	// if($noe_tadil==1)//نوع تعدیل اضافه بود موجودی افزایش یابد 
	// {
	  // $update_tedad_karton=$tedad_karton_again+$tedad_karton_tadil;//آپدیت تعداد کارتن های موجود در انبار
	  // if($code_bastebandy==1) $update_mojody_nakhales=$mojody_nakhales_again+$meghdar_nakhales_tadil;//آپدیت موجودی ناخالص کالا در جدول موجودی کالا
	  // $update_mojody_khales=$mojody_khales_again+$meghdar_khales_tadil;//آپدیت موجودی خالص کالا در جدول موجودی کالا
	// } 
	// if($noe_tadil==2)//نوع تعدیل کسری بود موجودی کاهش یابد
	// {
	  // $update_tedad_karton=$tedad_karton_again-$tedad_karton_tadil;//آپدیت تعداد کارتن های موجود در انبار
	  // if($code_bastebandy==1)$update_mojody_nakhales=$mojody_nakhales_again-$meghdar_nakhales_tadil;//آپدیت موجودی ناخالص کالا در جدول موجودی کالا
	  // $update_mojody_khales=$mojody_khales_again-$meghdar_khales_tadil;//آپدیت موجودی خالص کالا در جدول موجودی کالا
	// }
	$update_mojody_res=$db->query("UPDATE mojody_kala SET mojody_khales='$update_mojody_khales',mojody_nakhales='$update_mojody_nakhales',tedad_karton='$update_tedad_karton',tedad_shane='$update_tedad_shane' WHERE code_kala='$code_kala' AND code_keshvar='$code_keshvar' AND code_tolidkonande='$code_tolidkonande' AND sal_tolid_shamsi='$sal_tolid_shamsi' AND mah_tolid_shamsi='$mah_tolid_shamsi' AND rouz_tolid_shamsi='$rouz_tolid_shamsi' AND code_karton='$code_karton' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND code_ziranbar='$code_ziranbar' AND year='$mtActiveYear' AND deleted=0");  	
	/*لاگ موجودی*/$log_m_e=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','mojody_kala',".$id_mojody.",'ایجاد برگه تعدیل وآپدیت موجودی کالا',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')");

	IF(($code_kala==50)AND($noe_tadil==2)AND($chkchangeCode==1))
	{
	  //مجموع وزن کارتن ها صفر و وزن خالص و ناخالص یکسان
	  $id_tadil_related=$db->get_from_where("id","tadil_mojody","shomare_mojavez_tadil='$shomare_mojavez_tadil' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND status=0 AND deleted=0");
	  $shomare_barge_tadil=$shomare_barge_tadil+1;
	  $shomare_barge_tadil=make_pattern($shomare_barge_tadil,5);
	  $insert_q2=("INSERT INTO $TableName
                 (code_ostan,code_anbar,shomare_barge_tadil,year,tarikh_barge_tadil,noe_form_tadil,shomare_mojavez_tadil,code_ziranbar,
	 		      code_kala,code_keshvar,code_tolidkonande,sal_tolid_shamsi,mah_tolid_shamsi,rouz_tolid_shamsi,sal_tolid_milady,mah_tolid_milady,rouz_tolid_milady,
			      code_karton,vazn_karton_this,noe_tadil,noe_kasry,tedad_karton_tadil,sum_karton_tadil,meghdar_nakhales_tadil,meghdar_khales_tadil,id_tadil_related,tozihat_tadil,signiture_tadil,deleted)
                  VALUES
			     ('$mt_gl_code_ostan','$mt_gl_code_anbar','$shomare_barge_tadil','$mtActiveYear','$tarikh_barge_tadil','$noe_form_tadil','$shomare_mojavez_tadil','$code_ziranbar',
			      '$change_code_kala','$code_keshvar','$code_tolidkonande','$sal_tolid_shamsi','$mah_tolid_shamsi','$rouz_tolid_shamsi','$sal_tolid_milady','$mah_tolid_milady','$rouz_tolid_milady',
			      '$code_karton','$vazn_karton_this',1,'$noe_kasry','$tedad_karton_tadil','0','$meghdar_nakhales_tadil','$meghdar_nakhales_tadil','$id_tadil_related','$tozihat_tadil','$separatesigniture',0)"); 		 
     $insert_res2=mysql_query($insert_q2);
     /*لاگ تعدیل*/
     $max_id=$db->get_from_where("MAX(id)","$TableName","code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear'");   
	 $log_i=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$max_id','ثبت',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')");
	 $exist_mojody=$db->get_from_where("count(*)","mojody_kala","code_kala='$change_code_kala' AND code_ziranbar='$code_ziranbar' AND code_keshvar='$code_keshvar' AND code_tolidkonande='$code_tolidkonande' AND sal_tolid_shamsi='$sal_tolid_shamsi' AND mah_tolid_shamsi='$mah_tolid_shamsi' AND rouz_tolid_shamsi='$rouz_tolid_shamsi' AND code_karton='$code_karton' AND code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND year=$mtActiveYear AND deleted=0");		
	 IF($exist_mojody>0)//اگر در جدول موجودی کالا وجود دارد
     {   
	  //آپدیت موجودی کالا
	   $update_tedad_karton_change=mojodyKarton($mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear,$code_ziranbar,$change_code_kala,$code_keshvar,$code_tolidkonande,$sal_tolid_shamsi,$mah_tolid_shamsi,$rouz_tolid_shamsi,$code_karton);
	   $update_mojody_nakhales_change=mojodyNakhales($mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear,$code_ziranbar,$change_code_kala,$code_keshvar,$code_tolidkonande,$sal_tolid_shamsi,$mah_tolid_shamsi,$rouz_tolid_shamsi,$code_karton);
	   $update_mojody_khales_change=mojodyKhales($mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear,$code_ziranbar,$change_code_kala,$code_keshvar,$code_tolidkonande,$sal_tolid_shamsi,$mah_tolid_shamsi,$rouz_tolid_shamsi,$code_karton);
	   //$update_tedad_shane_change=$update_tedad_karton_change*$_SESSION["mtShane"];
	   $mojody_change_res=$db->query("UPDATE mojody_kala SET mojody_khales='$update_mojody_nakhales_change',mojody_nakhales='$update_mojody_nakhales_change',tedad_karton='$update_tedad_karton_change' WHERE code_kala='$change_code_kala' AND code_ziranbar='$code_ziranbar' AND code_keshvar='$code_keshvar' AND code_tolidkonande='$code_tolidkonande' AND sal_tolid_shamsi='$sal_tolid_shamsi' AND mah_tolid_shamsi='$mah_tolid_shamsi' AND rouz_tolid_shamsi='$rouz_tolid_shamsi' AND code_karton='$code_karton' AND code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND year=$mtActiveYear AND deleted=0");  
     }
     ELSE  //اگر وجود ندارد
     {
		$insert_mojody_q=("INSERT INTO mojody_kala(code_ostan,code_anbar,year,code_ziranbar,code_kala,code_keshvar,code_tolidkonande,sal_tolid_shamsi,mah_tolid_shamsi,rouz_tolid_shamsi,sal_tolid_milady,mah_tolid_milady,rouz_tolid_milady,code_bastebandy,code_karton,vazn_karton_this,sum_karton_this,tedad_karton_aval,mojody_nakhales_aval,mojody_khales_aval,tedad_shane_aval,tedad_karton,mojody_nakhales,mojody_khales,deleted)
                           VALUES('$mt_gl_code_ostan','$mt_gl_code_anbar','$mtActiveYear','$code_ziranbar','$change_code_kala','$code_keshvar','$code_tolidkonande','$sal_tolid_shamsi','$mah_tolid_shamsi','$rouz_tolid_shamsi','$sal_tolid_milady','$mah_tolid_milady','$rouz_tolid_milady','$code_bastebandy','$code_karton','$vazn_karton_this',0,0,0,0,0,'$tedad_karton_tadil','$meghdar_nakhales_tadil','$meghdar_nakhales_tadil','0')");
		$mojody_change_res=$db->query($insert_mojody_q);
	 }	 
	}
    ELSE {$insert_res2=TRUE; $mojody_change_res=TRUE;} 	
	if($insert_res and $log_i and $update_mojody_res and $log_m_e AND $insert_res2 AND $mojody_change_res)
	{
	  //اتصال به وب سرویس
	  $warehouse_id=$db->get_from_where("warehouse_id","list_sardkhane","code_ostan=".$mt_gl_code_ostan." AND code_anbar=".$mt_gl_code_anbar."");     
	  if(($_SESSION['mt_webservice']==1)and($warehouse_id!=''))
      {
       if(strlen($mt_gl_code_ostan)==1) $code_a=make_pattern($mt_gl_code_ostan,2);
       else $code_a=$mt_gl_code_ostan;
       $shomareGhabz=$mtActiveYear.$code_a.$mt_gl_code_anbar.$shomare_barge_tadil.'t';
       //تعدیل اضافه مثل رسید
       IF($noe_tadil==1) $type_tadil='in'; 
       //تعدیل کسری مثل حواله
       ELSE IF($noe_tadil==2) $type_tadil='out';
	   $vahedKala=$db->get_from_where("sharh_vahedkala","kala INNER JOIN vahed_kala ON kala.code_vahedkala=vahed_kala.code_vahedkala","code_kala=".$code_kala."");     
	   $bastebandyKala=$db->get_from_where("sharh_bastebandy","kala INNER JOIN bastebandy ON kala.code_bastebandy=bastebandy.code_bastebandy","code_kala=".$code_kala."");     
       $nameKala=$db->get_from_where("name_kala","kala","code_kala=".$code_kala."");     
	   //تبدیل تاریخ شمسی به میلادی
	   $sql_tarikh=$tarikh_barge_tadil;
       $d=substr($sql_tarikh,8,2);$m=substr($sql_tarikh,5,2);$y=substr($sql_tarikh,0,4);
       $milady=jalali_to_gregorian($y,$m,$d);
       $sal=$milady[0];$mah=$milady[1];$rouz=$milady[2];
       $tarikh_tadil_MI=$sal.'-'.$mah.'-'.$rouz;
       $wsdl_url='http://10.7.234.33/anbar/warehouse.asmx?wsdl';
	   header('Content-Type: text/html; charset=utf-8');
       try
	   {
	    $client=new SoapClient($wsdl_url);
	    $itemsinfo=array(
	     'category_id'=>'',
	     'taxonomy_id'=>'',
	     'good_id'=>$code_kala,
	     'good_name'=>$nameKala,
	     'total_weight'=>$meghdar_khales_tadil,
	     'measurement_unit'=>$vahedKala,
	     'count'=>$meghdar_khales_tadil,
	     'package_type'=>$bastebandyKala,
	     'package_count'=>$tedad_karton_tadil,
	     'item_value'=>'',
	     'production_date'=>$tarikh_tadil_MI,
	     'expire_date'=>$tarikh_tadil_MI,
	     'description'=>'',
	     'location'=>''
	    );
	    $listitemsinfo=array(
          $itemsinfo
        );
	    $otherinfo=array(
		   'owner_phone'=>'82971',
		   'good_owneragent'=>'',
		   'bol_date'=>$tarikh_tadil_MI,
		   'bol_tid'=>'',
		   'bol_series'=>'',
		   'bol_serial'=>''
	    );
	    $docinfo=array(
	  	 'warehouse_id'=>$warehouse_id,
	  	 'contractor_co_national_id'=>'14002771736',
	  	 'number'=>$shomareGhabz,
	  	 'type'=>$type_tadil,
	  	 'issue_date'=>$tarikh_tadil_MI,
	  	 'owner'=>'14002771736',
	  	 'owner_name'=>'شرکت پشتیبانی امور دام کشور',
	  	 'vehicle_number'=>'',
	  	 'driver_national_id'=>'',
	  	 'driver'=>'',
	  	 'insurance_name'=>'',
	  	 'insurance_date'=>$tarikh_tadil_MI,
	  	 'insurance_number'=>'',
	  	 'Commodity'=>$listitemsinfo,
	  	 'details'=>$otherinfo
	     );
	     $params=array(
          'username'=>'02',
          'password'=>'HJ78mnGD',
          'type'=>$type_tadil,
          'doc'=>$docinfo
		 ); 
	    $result=$client->WarehouseInOut($params); 
	    $response=$result->WarehouseInOutResult;
	    $webservice_error_code =$response->ErrorCode;
	    $webservice_error_message =$response->ErrorMessage;
	    $webservice_status =$response->status;
	    $webservice_number =$response->number;	 
		echo "<script>alert('شماره سند وب سرویس\\n$webservice_number')</script>"; 
	   }
	   catch(SoapFault $client)
	   {
		 echo "<script>alert('وب سرویس فعال نمی باشد')</script>";
	   }
  	   $update_track=("UPDATE tadil_mojody SET webservice_error_code='$webservice_error_code',webservice_error_message='$webservice_error_message',webservice_status='$webservice_status',webservice_number='$webservice_number' WHERE code_ostan=".$mt_gl_code_ostan." AND code_anbar=".$mt_gl_code_anbar." AND shomare_barge_tadil='".$shomare_barge_tadil."' AND year=$mtActiveYear");
	   $update_res=mysql_query($update_track); 
      }//END WEBSERVICE
	  
	  mysql_query("COMMIT");
	  if(strlen($mt_gl_code_ostan)==1) $code_a=make_pattern($mt_gl_code_ostan,2); else $code_a=$mt_gl_code_ostan;
      echo "<script>window.location='".$FileName."?shomare_havale_anbar_=".$shomare_havale_anbar_."&code_kala_=".$code_kala_."&noe_tahvil_bar_=".$noe_tahvil_bar_."&h_code_=".$h_code_."&meghdar_havale_forush_=".$meghdar_havale_forush_."&mande_az_forush_=".$mande_az_forush_."&idForush_=".$idForush_."&shomare_jabejae_=".$shomare_jabejae_."&meghdar_jabejae_=".$meghdar_jabejae_."&mande_az_jabejae_=".$mande_az_jabejae_."&idJabejae_=".$idJabejae_."&PageNo=".$PageNo."&RowPerPage=".$RowPerPage."&order=".$order."';</script>";  
	}
	else  
    {
      mysql_query('ROLLBACK');
      echo "<script>alert('مشکلی در ثبت به وجود آمده است')</script>";
    }
	mysql_query('SET AUTOCOMMIT=1');
 }//END isPermitSave
}//END INSERT	
/************EDIT BUTTON********/// اصلاح اطلاعات
if (isset($Edit_x))
{
 $noe_form_tadil=1;//همیشه دائم
 $tarikh_mojavez=$db->get_from_where("tarikh_mojavez_tadil","mojavez_tadil","shomare_mojavez_tadil='$shomare_mojavez_tadil' AND code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND year=$mtActiveYear");
 if(isPermitEdit($tarikh_barge_tadil,$noe_form_tadil,$shomare_mojavez_tadil,$tarikh_mojavez,$mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear))
 {
  $Mode='';
  if($noe_form_tadil==2) $shomare_mojavez_tadil=Null;//اگر دائم را موقت کرد شماره مجوز را خالی کنم
  $signiture ="SELECT sign_id FROM mt_typesign WHERE activate=1 AND type_id=6 AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' ORDER BY turn";
  $allsigniture = $db->query($signiture);
  $separatesigniture='';
  while($row_id=$db->fetch_assoc($allsigniture)) $separatesigniture = $separatesigniture . $row_id['sign_id'].';' ;
  $separatesigniture=rtrim($separatesigniture, ";");
  $edit_q=("UPDATE $TableName SET tarikh_barge_tadil='$tarikh_barge_tadil',noe_form_tadil='$noe_form_tadil',shomare_mojavez_tadil='$shomare_mojavez_tadil',noe_kasry='$noe_kasry',tozihat_tadil='$tozihat_tadil',,signiture_tadil='$separatesigniture' WHERE id='$id_';");         
  $edit_res=mysql_query($edit_q);
  if(($edit_res) and (mysql_affected_rows()!=0))
  { $log_e=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_','ویرایش',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')");  /*کوئری لاگ*/ 
    echo '<script>window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\' </script>';
  }
  else $message ='<span style=" color:red;font: bold 12px tahoma;"> * مشکلی در ویرایش مشخصات به وجود آمده است ! *</span>';      
 }
}
/***************************************** MAIN*****************************************/
//قرار گرفتن فوکوس 
if ($Mode=="Insert") $load="document.myform.shomare_mojavez_tadil.focus();";
if ($Mode=="Search") $load="document.myform.shomare_barge_tadil_sch.focus();";
if ($Mode=="Edit")   $load="document.myform.tarikh_barge_tadil.focus();";
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="'.$load.'">
<form method="post" name="myform" onkeydown="enterIE()">
<div align="center">
<table width="99%" height="100%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr>
  <td class="title">
   <div style="position:absolute;top:5px;left:45%;">فرم تعديل موجودی</div>
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
if(!isset($order))      $order='id DESC';
if(!isset($sortshomare))$sortshomare='1';
if(!isset($sorttarikh)) $sorttarikh='1';
if(!isset($sortname))   $sortname='1';
if(!isset($sortnoeform))$sortnoeform='1';
if(!isset($sortnoetadil))   $sortnoetadil='1';
if(!isset($sortsal))   $sortsal='1';
if(!isset($sortmah))   $sortmah='1';
if(!isset($sortrouz))  $sortrouz='1';
if(!isset($show_img))   $show_img='';
	if($sortshomare=='1')
	{echo'<td width="7%" rowspan="2" title="مرتب سازی صعودی شماره برگه تعدیل" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=code_ostan ASC,code_anbar ASC,shomare_barge_tadil ASC&sortshomare=2&show_img=1\'"/> شماره برگه تعدیل ';
	  if($show_img=='1')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sortshomare=='2')
	{echo'<td width="7%" rowspan="2" title="مرتب سازی نزولی شماره برگه تعدیل" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=code_ostan DESC,code_anbar DESC,shomare_barge_tadil DESC&sortshomare=1&show_img=1\'"/> شماره برگه تعدیل ';
	  if($show_img=='1')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sorttarikh=='1')
	{echo'<td width="5%" rowspan="2" title="مرتب سازی صعودی تاریخ برگه تعدیل" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=tarikh_barge_tadil ASC&sorttarikh=2&show_img=2\'"/> تاریخ تعدیل '; 
	  if($show_img=='2')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sorttarikh=='2')
	{echo'<td width="5%" rowspan="2" title="مرتب سازی نزولی تاریخ برگه تعدیل" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=tarikh_barge_tadil DESC&sorttarikh=1&show_img=2\'"/> تاریخ تعدیل '; 
	  if($show_img=='2')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	echo'<td width="5%" rowspan="2">مجوز</td>';
	if($sortname=='1')
	{echo'<td width="15%" rowspan="2" title="مرتب سازی صعودی نام کالا" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=nameKala ASC&sortname=2&show_img=3\'"/> نام کالا '; 
	  if($show_img=='3')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	if($sortname=='2')
	{echo'<td width="15%" rowspan="2" title="مرتب سازی نزولی نام کالا" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=nameKala DESC&sortname=1&show_img=3\'"/> نام کالا '; 
	  if($show_img=='3')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	}
	echo'
	 <td width="4%" rowspan="2">زیرانبار</td>
	 <td width="5%" rowspan="2">تولیدکننده</td>
	 <td width="15%" colspan="3">تاریخ تولید</td>
	 <td width="5%" rowspan="2">وزن کارتن/قوطی</td>';
	 if($sortnoeform=='1')
	 {echo'<td width="6%" rowspan="2" title="مرتب سازی صعودی نوع فرم تعدیل" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=noe_form_tadil ASC&sortnoeform=2&show_img=4\'"/> نوع فرم '; 
	  if($show_img=='4')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	 }
	 if($sortnoeform=='2')
	 {echo'<td width="6%" rowspan="2" title="مرتب سازی نزولی نوع فرم تعدیل" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=noe_form_tadil DESC&sortnoeform=1&show_img=4\'"/> نوع فرم '; 
	  if($show_img=='4')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	 }
	 if($sortnoetadil=='1')
	 {echo'<td width="6%" rowspan="2" title="مرتب سازی صعودی نوع تعدیل" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=noe_tadil ASC&sortnoetadil=2&show_img=5\'"/> نوع تعدیل '; 
	  if($show_img=='5')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	 }
	 if($sortnoetadil=='2')
	 {echo'<td width="6%" rowspan="2" title="مرتب سازی نزولی نوع تعدیل" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=noe_tadil DESC&sortnoetadil=1&show_img=5\'"/> نوع تعدیل '; 
	  if($show_img=='5')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	 }
	 echo'
	 <td width="20%" colspan="3">مقادیر تعدیل</td>';
	 if($_SESSION['mt_webservice']==1)echo'<td width="4%" rowspan="2">ارسال</td>';
	 if($right_prt)echo'<td width="4%"  rowspan="2">چاپ</td>';
	 if(($right_del)and($_SESSION['mtStatusYear']==0)) echo'<td width="3%" rowspan="2">حذف</td>';
	 echo'
	  <tr class="table-title">';
	  if($sortsal=='1')
	  {echo'<td title="مرتب سازی صعودی سال" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=sal_tolid_shamsi ASC&sortsal=2&show_img=6\'"/> سال '; 
	    if($show_img=='6')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	  }
	  if($sortsal=='2')
	  {echo'<td title="مرتب سازی نزولی سال" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=sal_tolid_shamsi DESC&sortsal=1&show_img=6\'"/> سال '; 
	    if($show_img=='6')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	  }
	  if($sortmah=='1')
	  {echo'<td title="مرتب سازی صعودی ماه" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=mah_tolid_shamsi ASC&sortmah=2&show_img=7\'"/> ماه '; 
	    if($show_img=='7')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	  }
	  if($sortmah=='2')
	  {echo'<td title="مرتب سازی نزولی ماه" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=mah_tolid_shamsi DESC&sortmah=1&show_img=7\'"/> ماه '; 
	    if($show_img=='7')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	  }
	  if($sortrouz=='1')
	  {echo'<td title="مرتب سازی صعودی روز" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=rouz_tolid_shamsi ASC&sortrouz=2&show_img=8\'"/> روز '; 
	    if($show_img=='8')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	  }
	  if($sortrouz=='2')
	  {echo'<td title="مرتب سازی نزولی روز" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=rouz_tolid_shamsi DESC&sortrouz=1&show_img=8\'"/> روز '; 
	    if($show_img=='8')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	  }
	  echo'
	     <td width="%">تعداد</td>	 
	     <td width="%">ناخالص</td>
		 <td width="%">خالص</td>
	  </tr>
	</tr>';
	$i=0;
    $q1="SELECT *,(SELECT name_kala From kala k WHERE k.code_kala=T.code_kala) nameKala,
	    (SELECT name_tolidkonande From tolidkonande WHERE tolidkonande.code_tolidkonande=T.code_tolidkonande) nameTolidkonande,
	    (SELECT name_ziranbar From list_sardkhane_detail l_s_d WHERE l_s_d.code_ziranbar=T.code_ziranbar AND T.code_ostan=l_s_d.code_ostan AND T.code_anbar=l_s_d.code_anbar ) nameZiranbar
	    From $TableName T WHERE 1=1 ".$_SESSION['mt_search_tadil']." AND T.code_ostan='$mt_gl_code_ostan' and T.code_anbar='$mt_gl_code_anbar' AND T.year='$mtActiveYear' AND T.deleted=0 order by $order $Limit";
	$allTadil = $db->query($q1);
    while($row1=$db->fetch_assoc($allTadil))
	{
     if($right_edt){$edtClick='onClick="window.location=\''.$FileName.'?Mode=Edit&id_='.$row1['id'].'&shomare_barge_tadil_='.$row1['shomare_barge_tadil'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'"';}	 
     if($i++%2)
	 {echo'<tr '; if($row1['status']==0) echo' class="table-odd"'; else echo 'class="row-ebtal"';echo'>';}	 
     else
	 {echo'<tr '; if($row1['status']==0) echo' class="table-even"'; else echo 'class="row-ebtal"';echo'>';}
	 if(strlen($row1['code_ostan'])==1) $code_a=make_pattern($row1['code_ostan'],2);
     else $code_a=$row1['code_ostan'];
	 echo'
	  <td '.$edtClick.'>'.$code_a.$row1['code_anbar'].$row1['shomare_barge_tadil'].'</td>
	  <td '.$edtClick.'>'.$row1['tarikh_barge_tadil'].'</td>
	  <td '.$edtClick.'>'.$row1['shomare_mojavez_tadil'].'</td>
	  <td '.$edtClick.'>'.$row1['nameKala'].'</td>
	  <td '.$edtClick.'>'.$row1['nameZiranbar'].'</td>
	  <td '.$edtClick.'>'.$row1['nameTolidkonande'].'</td>
	  <td '.$edtClick.'>'.$row1['sal_tolid_shamsi'].'</td>
	  <td '.$edtClick.'>'.$mahshamsiArr[$row1['mah_tolid_shamsi']].'</td>
	  <td '.$edtClick.'>'.$row1['rouz_tolid_shamsi'].'</td>
	  <td '.$edtClick.'>'.$row1['vazn_karton_this'].'</td>
	  <td '.$edtClick.'>'.$tadilformArr[$row1['noe_form_tadil']].'</td>
	  <td '.$edtClick.'>'.$tadilArr[$row1['noe_tadil']].'</td>
	  <td '.$edtClick.'>'.($row1['tedad_karton_tadil']).'</td>
	  <td '.$edtClick.'>'.($row1['meghdar_nakhales_tadil']).'</td>
	  <td '.$edtClick.'>'.($row1['meghdar_khales_tadil']).'</td>';
	  if($_SESSION['mt_webservice']==1)//متصل به وب سرویس
	  {
		if($_SESSION['mt_anbar_activate']==1)//فعال
		{
		 if(($row1['webservice_status']=='')and($row1['status']==0))  
		  echo'<td><div class="webservise" id="webservise-add"  title="شماره سند وب سرویس : '.$row1['webservice_number'].'('.$row1['webservice_status'].')'.'"  onClick="window.location=\''.$FileName.'?id_='.$row1['id'].'&shomare_barge_tadil_='.$row1['shomare_barge_tadil'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&send_tadil=1\'" /></div></td>'; 
		 else if($row1['webservice_status']=='Fail')  
		  echo'<td><div class="webservise" id="webservise-delete-resend"  title="شماره سند وب سرویس : '.$row1['webservice_number'].'('.$row1['webservice_status'].')'.'"  onClick="window.location=\''.$FileName.'?id_='.$row1['id'].'&shomare_barge_tadil_='.$row1['shomare_barge_tadil'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&send_tadil=1\'" /></div></td>'; 
         
		 else if(($row1['webservice_status']=='Insert')or($row1['webservice_status']=='Update'))//درست ارسال شده
	     {
		 	IF($row1['status']==0)//جاری	
		   	 echo'<td><div class="webservise" id="webservise-accept-resend" title="شماره سند وب سرویس : '.$row1['webservice_number'].'('.$row1['webservice_status'].')'.'"  onClick="window.location=\''.$FileName.'?id_='.$row1['id'].'&shomare_barge_tadil_='.$row1['shomare_barge_tadil'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&send_tadil=1\'"></div></td>';
		    ELSE //ابطالی	
		   	 echo'<td><img src="images/accept_database.png" title="شماره سند وب سرویس : '.$row1['webservice_number'].'('.$row1['webservice_status'].')'.'" /></td>';
		 }
		 else if(($row1['webservice_status']=='Revoke')and($row1['status']==1))echo'<td><img src="images/delete_database.png" title="شماره سند وب سرویس : '.$row1['webservice_number'].'('.$row1['webservice_status'].')'.'" /></td>';
         else echo'<td style="cursor:text;">&nbsp;</td>';
		}
        else //غیرفعال
	    {
		 if(($row1['webservice_status']=='Insert')or($row1['webservice_status']=='Update'))//درست ارسال شده
	      echo'<td style="cursor:text;"><img src="images/accept_database.png" title="شماره سند وب سرویس : '.$row1['webservice_number'].'('.$row1['webservice_status'].')'.'" /></td>';
		 else if($row1['webservice_status']=='')//
	      echo'<td><div class="webservise" id="webservise-add"  title="شماره سند وب سرویس : '.$row1['webservice_number'].'('.$row1['webservice_status'].')'.' انبار غیرفعال" /></div></td>';
		 else echo'<td style="cursor:text;">&nbsp;</td>';
		}  	
	  }
	  echo'<td align="center">';
	  if($right_prt){echo'<div onClick="window.open(\'print_tadil_one.php?id_='.$row1['id'].'\',\'_blank\',\'scrollbars=yes\')" id="printer_T" title="چاپ تعدیل موجودی"><a href="#"></a></div>';}
      echo'</td>'; 
	  //اطلاعات موجودی برای حذف
	  //$q_mo="SELECT id From mojody_kala m_k WHERE m_k.code_kala=".$row1['code_kala']." AND m_k.code_keshvar=".$row1['code_keshvar']." AND m_k.sal_tolid_shamsi=".$row1['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row1['mah_tolid_shamsi']." AND m_k.code_ostan='$mt_gl_code_ostan' and m_k.code_anbar='$mt_gl_code_anbar' AND m_k.year='$mtActiveYear' AND m_k.deleted=0";
	  $q_mo="SELECT id From mojody_kala WHERE code_kala=".$row1['code_kala']." AND code_keshvar=".$row1['code_keshvar']." AND code_tolidkonande=".$row1['code_tolidkonande']." AND sal_tolid_shamsi=".$row1['sal_tolid_shamsi']." AND mah_tolid_shamsi=".$row1['mah_tolid_shamsi']." AND rouz_tolid_shamsi=".$row1['rouz_tolid_shamsi']." AND code_karton=".$row1['code_karton']." AND code_ostan='$mt_gl_code_ostan' and code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0";
	  $all_mo=$db->query($q_mo);
      $row_mo=$db->fetch_assoc($all_mo);  
	  if(($right_del)and($_SESSION['mtStatusYear']==0))
	  {echo'<td><img border="0" class="1" src="images/trash.png" width="20" height="20" title="حذف" 
	       onmouseOver="this.src=\'images/trash_hover.png\'" 
		   onmouseOut="this.src=\'images/trash.png\'" 
		   onClick="iconfirm(\''.$FileName.'?Delete_x=1&id_='.$row1['id'].'&noe_tadil_='.$row1['noe_tadil'].'&tedad_karton_tadil_='.$row1['tedad_karton_tadil'].'&meghdar_nakhales_tadil_='.$row1['meghdar_nakhales_tadil'].'&meghdar_khales_tadil_='.$row1['meghdar_khales_tadil'].'&idMojody='.$row_mo['id'].'&code_ziranbar_='.$row3['code_ziranbar'].'&code_kala_='.$row3['code_kala'].'&code_keshvar_='.$row3['code_keshvar'].'&code_tolidkonande_='.$row3['code_tolidkonande'].'&sal_tolid_shamsi_='.$row3['sal_tolid_shamsi'].'&mah_tolid_shamsi_='.$row3['mah_tolid_shamsi'].'&rouz_tolid_shamsi_='.$row3['rouz_tolid_shamsi'].'&code_karton_='.$row3['code_karton'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\',\'برای حذف برگه تعدیل '.$code_a.$row1['code_anbar'].$row1['shomare_barge_tadil'].' \')" /></td>';
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
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>';
	  if($_SESSION['mt_webservice']==1)echo'<td>&nbsp;</td>';
	  if($right_prt)echo'<td>&nbsp;</td>';
	  if(($right_del)and($_SESSION['mtStatusYear']==0))echo'<td>&nbsp;</td>';
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
	 <td width="10px">&nbsp;</td>';
	 if($right_prt){
	 echo'<td width="24"><div onClick="window.open(\'print_tadil_mojody.php\',\'_blank\',\'scrollbars=yes\')" id="printer" title="چاپ"><a href="#"></a></div></td>
	 <td width="10px">&nbsp;</td>';}
	 //if(($right_ins)and($_SESSION['mtStatusYear']==0)and($_SESSION['mt_anbar_activate']==1)and($mt_gl_code_anbar!=301))
	 if(($right_ins)and($_SESSION['mtStatusYear']==0)and($_SESSION['mt_anbar_activate']==1)and($mt_gl_code_anbar!=301))
	 { echo'<td width="70px"><div onClick="window.location=\''.$FileName.'?Mode=Insert&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-new" title="افزودن رکورد جديد" ><a href="#"></a></div></td>
 	        <td width="10px">&nbsp;</td>';}
	 echo'<td width="70px"><div onClick="window.location=\''.$FileName.'?Mode=Search&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-search" title="جستجو" ><a href="#"></a></div></td>
	 <td width="10px">&nbsp;</td>
	 <td width="70px"><div onClick="window.location=\'my_frame.php\'" id="btn-back"  title="بازگشت به منوی اصلی"  ><a href="#"></a></div></td> 
	 <td width="40px">&nbsp;</td>	   
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
     if ($_SESSION['mt_search_tadil']) 
	 echo '
	 <td width="70px"><input type="Button" class=buttonme  value="نمايش همه" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&open_filter=1\'"></td>';	 
	 echo'
     <td>
	  <span class="tedadcover" align="center" > تعداد کل ['.$cnt.'] <br/>
	  جاری ['.$tedad_jary.']&nbsp; / ابطالی ['.$tedad_ebtaly.']</span>  
	 </td> 	 
	</tr>';
    }
	if ($Mode=="Insert" )  //Insert Mode
    {echo '
    <tr> 
	 <td width="99%" class="borderall" style="position:absolute;bottom:10px;left:0.5%;">	 	 
	  <table class="footer-panel" width="100%" cellpadding="0" cellspacing="0">
       <img src="images/loading.gif" id="loading" class="loading_img"/>
	   <tr class="title"><td colspan="11" align="center">ايجاد فرم تعدیل جدید</td></tr>
       <tr>	   
	    <td align="left" colspan=8 style="color:red">توجه<img border="0" src="images/Info1.png" title="لطفاً در ثبت مقادیر دقت نمایید ، بعد از کلیک روی گزینه ثبت امکان ویرایش مقادیر وجود ندارد" style="cursor:pointer" onmouseOver="this.src=\'images/Info_h.png\'" onmouseOut="this.src=\'images/Info1.png\'"/></span></td>
	   </tr>	   
	   <tr>
		<td align="left" width="150px"><span class="star">*</span> شماره برگه تعدیل :&nbsp; </td>
		<td align="right" width="150px">
		<input type="text" readonly class="textboxme" value="'.$shomare_barge_tadil.'" name="shomare_barge_tadil" style="width:50px;"/>&nbsp;/&nbsp;';
		if(strlen($mt_gl_code_ostan)==1) $code_a=make_pattern($mt_gl_code_ostan,2);
		else $code_a=$mt_gl_code_ostan;
		echo'<input type="text" readonly class="textboxme" value="'.$code_a.$mt_gl_code_anbar.'" name="ostan_anbar" style="width:50px;"/></td>';
        if($_SESSION["mtActiveYear"]==$yy)echo'<td align="left" width="150px"><span class="star">*</span> تاریخ برگه تعدیل :&nbsp;</td><td align="right" width="150px"><input class="textboxme2" readonly type="text" maxlength="10" name="tarikh_barge_tadil" value="'.AsLDate($yymmdd).'"/></td>';
        else echo'<td align="left" width="150px"><span class="star">*</span> تاریخ برگه تعدیل :&nbsp;</td><td align="right" width="150px"><input class="textboxme2" readonly type="text" maxlength="10" name="tarikh_barge_tadil" value="'.$mtEndDateSh.'"/></td>';

		echo'<td align="left" width="150px"><span class="star">*</span> نوع فرم تعدیل :&nbsp; </td><td align="right" width="150px">'.static_listbox("noe_form_tadil",$noe_form_tadil,"tadilformArr",1,"class='text4' ").'</td>
	    </tr>
	    <tr>
		 <td align="left"><span class="star">*</span> شماره مجوز :&nbsp;</td><td align="right" class="mojavezhide"><input class="textboxme2" type="text" name="shomare_mojavez_tadil" value="'.$shomare_mojavez_tadil.'" onfocus="getDetailMojavez(this.value)" />';
		 include("img_helpmojavez_tadil.php");
		echo'
		 </td>
	     <td align="left"><span class="star">*</span> نوع تعديل :&nbsp;</td><td align="right"><input class="textboxme2" type="hidden" name="noe_tadil" value="'.$noe_tadil.'"/> <input class="textboxme2" readonly type="text" name="noe_tadil_desc" value="'.$noe_tadil_desc.'"/>
		 <td align="left" class="kasryshow" style="display:none;"><span class="star">*</span> نوع کسری : &nbsp; </td><td align="right" class="kasryshow" style="display:none;">'.static_listbox("noe_kasry",$noe_kasry,"tadilkasryArr",1,"class='text4'").'</td>';
		 IF($noe_tadil==2)echo'<td align="left" class="kasryshow"><span class="star">*</span> نوع کسری : &nbsp; </td><td align="right" class="kasryshow">'.static_listbox("noe_kasry",$noe_kasry,"tadilkasryArr",1,"class='text4'").'</td>';
		 echo'
		 <td><input type="hidden" name="chkchangeCode" value='.$chkchangeCode.'/>
		     <input type="hidden" name="change_code_kala" value='.$change_code_kala.'/>
		 </td>
		</tr>
		<tr>
	    <td colspan="8">
		 <table border="0" width="100%">
		  <tr>
		   <td width="70%">
		    <fieldset>
	        <legend>اطلاعات کالا</legend>
	         <table width="100%" border="0">
	          <tr>
		       <td align="left"> کد کالا :&nbsp;</td><td align="right"><input type="text" class="textboxme2  textbox50" readonly name="code_kala" value="'.$code_kala.'" /></td>
			   <td align="left">نام کالا :&nbsp;</td><td align="right" colspan="4" ><input type="text" class="textboxme" readonly name="name_kala" id="name_kala" value="'.$name_kala.'"/>
	           <input type="hidden" name="code_bastebandy" id="code_bastebandy" value="'.$code_bastebandy.'"/></td>
			  </tr>
			  <tr>
			   <td align="left"><span class="star">*</span> تاریخ تولید شمسی  :&nbsp;</td>
	     	   <td align="right" colspan="3">
	     	        سال : <input class="textboxme2" readonly type="text" name="sal_tolid_shamsi"  style="width:40px;"/>
                    <!-- شدن disabled برای --> 
					ماه : <input type="text" class="textboxme2" readonly name="mah_tolid_desc" />
					<!-- '.static_listbox("mah_tolid_desc","","mahshamsiArr",1,"class='text4' disabled").'-->
                     <input type="hidden" name="mah_tolid_shamsi" />
	     	   	    روز : <input class="textboxme2 textbox50" type="text" name="rouz_tolid_shamsi" readonly/>
			         <input type="hidden" name="sal_tolid_milady" />
	     	         <input type="hidden" name="mah_tolid_milady" />
	     	         <input type="hidden" name="rouz_tolid_milady" />
				     <input type="hidden" id="id_mojody" name="id_mojody" value="'.$id_mojody.'"/>

			   </td>
              </tr>
		      <tr>			
				<input type=hidden name="code_keshvar"/>
			   <td align="left"><span class="star">*</span> نام کشور :&nbsp;</td><td align="right" ><input class="textboxme2" type="text" readonly id="name_keshvar" name="name_keshvar"/></td>
	           	<input type=hidden name="code_tolidkonande"/>
			   <td align="left"><span class="star">*</span> نام تولیدکننده :&nbsp;</td><td align="right" ><input class="textboxme2" type="text" readonly id="name_tolidkonande" name="name_tolidkonande"/></td>   
			   	<input type=hidden name="code_ziranbar"/>
	           <td align="left"><span class="star">*</span> نام زیرانبار :&nbsp;</td><td align="right" ><input class="textboxme2" type="text" readonly id="name_ziranbar" name="name_ziranbar" /></td>
			  </tr>';
			  //if($code_bastebandy==1)//کارتن
			  //{
			   echo'
			   <tr>
			    <td align="left"><span class="star">*</span> کد کارتن :&nbsp;</td><td align="right"><input type="text" class="textboxme2" readonly name="code_karton" /></td>
			    <td align="left"><span class="star">*</span> وزن کارتن :&nbsp;</td><td align="right"><input type="text" class="textboxme2" readonly name="vazn_karton_this" /></td>
			   </tr>
			   <tr> 			  
			   <td align="left">تعداد :&nbsp; </td><td align="right"><input type="text" class="textboxme2" readonly name="tedad_karton" /></td>
			   <td align="left">موجودی ناخالص :&nbsp; </td><td align="right"><input type="text" class="textboxme2" readonly name="mojody_nakhales" /></td>
	           <td align="left">موجودی خالص :&nbsp; </td><td align="right"><input type="text" class="textboxme2" readonly name="mojody_khales" /></td>
			  </tr>'; 
			  //}
			  // if($code_bastebandy==2)//قوطی
			  // {
			   // echo'
			   // <tr>
			    // <td align="left"><span class="star">*</span> کد قوطی :&nbsp;</td><td align="right"><input type="text" class="textboxme2" readonly name="code_karton" /></td>
			    // <td align="left"><span class="star">*</span> وزن قوطی :&nbsp;</td><td align="right"><input type="text" class="textboxme2" readonly name="vazn_karton_this" /></td>
			   // </tr>
			   // <tr> 			  
			   // <td align="left">تعداد :&nbsp; </td><td align="right"><input type="text" class="textboxme2" readonly name="tedad_karton" /></td>
	            // <input type="hidden" name="mojody_nakhales" value="'.$mojody_nakhales.'"/>
			   // <td align="left">موجودی خالص :&nbsp; </td><td align="right"><input type="text" class="textboxme2" readonly name="mojody_khales" /></td>
			  // </tr>';
			  // }
			  // if($code_bastebandy==3)//لاشه
			  // {
			   // echo'
			   // <tr> 			  
			    // <td align="left">تعداد :&nbsp; </td><td align="right"><input type="text" class="textboxme2" readonly name="tedad_karton" /></td>
	             // <input type="hidden" name="code_karton"/>
	             // <input type="hidden" name="vazn_karton_this"/>
	             // <input type="hidden" name="mojody_nakhales"/>
			    // <td align="left">موجودی خالص :&nbsp; </td><td align="right"><input type="text" class="textboxme2" readonly name="mojody_khales" /></td>
			   // </tr>';
			  // }
			  echo'
			  <!--<tr id="loaddata" style="display:none"></tr>-->
		     </table> 
		    </fieldset>
	       </td>
		   <td width="30%" valign="top">
		    <fieldset>
	        <legend>مقادیر تعدیل</legend>
		     <table width="100%" border="0">';
			  //if($code_bastebandy==1)//کارتن
			  //{
			   echo'
	           <tr><td align="left"> تعداد کارتن :&nbsp;</td><td align="right"><input class="textboxme2" readonly type="text" name="tedad_karton_tadil" value="'.$tedad_karton_tadil.'" onblur="return sumkarton()" onfocus="return sumkarton()" onkeypress="return isNumber(event)"/></td></tr>
	           <tr><td align="left"> مجموع وزن کارتن ها :&nbsp;</td><td align="right"><input class="textboxme2" readonly type="text" name="sum_karton_tadil" value="'.$sum_karton_tadil.'" onfocus="return sumkarton()"/></td></tr>		
			   <tr><td align="left"> مقدار ناخالص :&nbsp;</td><td align="right"><input class="textboxme2" readonly type="text" name="meghdar_nakhales_tadil" value="'.$meghdar_nakhales_tadil.'" onblur="return vazn_khales()" onfocus="return vazn_khales()" onKeydown="return PressfloatOnly(event,this)"/></td></tr>
		       <tr><td align="left"> مقدار خالص :&nbsp;</td><td align="right"><input class="textboxme2" type="text" readonly name="meghdar_khales_tadil" value="'.$meghdar_khales_tadil.'" onfocus="return vazn_khales()" onKeydown="return PressfloatOnly(event,this)"/></td></tr>';
			  //}
			  // if($code_bastebandy==2)//قوطی
			  // {echo'
	           // <tr><td align="left"><span class="star">*</span> تعداد قوطی :&nbsp;</td><td align="right"><input class="textboxme2" type="text" name="tedad_karton_tadil" value="'.$tedad_karton_tadil.'" onblur="return sumghooti()" onfocus="return sumghooti()" onkeypress="return isNumber(event)"/></td></tr>
		       // <tr><td align="left"><span class="star">*</span> مقدار خالص :&nbsp;</td><td align="right"><input class="textboxme2" type="text" readonly name="meghdar_khales_tadil" value="'.$meghdar_khales_tadil.'"/></td></tr>';
			  // }
			  // if($code_bastebandy==3)//لاشه
			  // {echo'
	           // <tr><td align="left"> تعداد :&nbsp;</td><td align="right"><input class="textboxme2" type="text" name="tedad_karton_tadil" value="'.$tedad_karton_tadil.'" onkeypress="return isNumber(event)"/></td></tr>
		       // <tr><td align="left"> مقدار خالص :&nbsp;</td><td align="right"><input class="textboxme2" type="text" name="meghdar_khales_tadil" value="'.$meghdar_khales_tadil.'" onKeydown="return PressfloatOnly(event,this)"/></td></tr>';
			  // }
			  echo'
			  <tr><td align="left">توضيحات :&nbsp;</td><td align="right"><input class="textboxme" type="text" name="tozihat_tadil" value="'.$tozihat_tadil.'"/></td></tr>
			 </table>
		    </fieldset>
		   </td>
	      </tr>
	     </table>
		</td>
	   </tr>
	   <tr>
        <td colspan="8" align="center" class="title">
		<input class="buttonme" type="submit" name="Insert_x" id="sabt" value="ثبت">
        <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'">
        </td>
       </tr>
      </table>
	 </td>
    </tr>';
    }
	if($Mode=="Edit")  //Edit Mode
    {
	 $q3=("SELECT T.*,kala.name_kala,bastebandy.code_bastebandy,bastebandy.sharh_bastebandy,keshvar.name_keshvar,tolidkonande.name_tolidkonande,l_s_d.name_ziranbar,m_k.id AS id_Mojody
		  FROM $TableName T 
		  INNER JOIN kala ON T.code_kala=kala.code_kala
		  INNER JOIN bastebandy ON bastebandy.code_bastebandy=kala.code_bastebandy
		  INNER JOIN keshvar ON T.code_keshvar=keshvar.code_keshvar
		  INNER JOIN tolidkonande ON T.code_tolidkonande=tolidkonande.code_tolidkonande
		  INNER JOIN list_sardkhane_detail l_s_d ON T.code_ziranbar=l_s_d.code_ziranbar AND T.code_ostan=l_s_d.code_ostan AND T.code_anbar=l_s_d.code_anbar
		  INNER JOIN mojody_kala m_k ON T.code_kala=m_k.code_kala AND T.code_keshvar=m_k.code_keshvar AND T.code_tolidkonande=m_k.code_tolidkonande AND T.sal_tolid_shamsi=m_k.sal_tolid_shamsi AND T.mah_tolid_shamsi=m_k.mah_tolid_shamsi AND T.rouz_tolid_shamsi=m_k.rouz_tolid_shamsi AND T.code_karton=m_k.code_karton AND T.code_ostan=m_k.code_ostan AND T.code_anbar=m_k.code_anbar AND T.year=m_k.year
		  WHERE T.id='$id_' AND T.shomare_barge_tadil='$shomare_barge_tadil_' AND T.code_ostan='$mt_gl_code_ostan' AND T.code_anbar='$mt_gl_code_anbar' AND T.year='$mtActiveYear' AND T.deleted=0");
	 //if(SuperUser()) echo $q3;
	 $res3=$db->query($q3);
	 $row3=$db->fetch_assoc($res3);
	 //اگر کد استان یک رقمی بود
	 if(strlen($row3['code_ostan'])==1) $code_a=make_pattern($row3['code_ostan'],2);
     else $code_a=$row3['code_ostan'];
	 //با استفاده از تابع
     $tedad_karton=mojodyKarton($row3['code_ostan'],$row3['code_anbar'],$row3['year'],$row3['code_ziranbar'],$row3['code_kala'],$row3['code_keshvar'],$row3['code_tolidkonande'],$row3['sal_tolid_shamsi'],$row3['mah_tolid_shamsi'],$row3['rouz_tolid_shamsi'],$row3['code_karton']);
     $mojody_nakhales=mojodyNakhales($row3['code_ostan'],$row3['code_anbar'],$row3['year'],$row3['code_ziranbar'],$row3['code_kala'],$row3['code_keshvar'],$row3['code_tolidkonande'],$row3['sal_tolid_shamsi'],$row3['mah_tolid_shamsi'],$row3['rouz_tolid_shamsi'],$row3['code_karton']);
	 $mojody_khales=mojodyKhales($row3['code_ostan'],$row3['code_anbar'],$row3['year'],$row3['code_ziranbar'],$row3['code_kala'],$row3['code_keshvar'],$row3['code_tolidkonande'],$row3['sal_tolid_shamsi'],$row3['mah_tolid_shamsi'],$row3['rouz_tolid_shamsi'],$row3['code_karton']);  
     $chkchangeCode=$db->get_from_where("chkchangeCode","mojavez_tadil","shomare_mojavez_tadil='".$row3['shomare_mojavez_tadil']."' AND code_ostan=".$row3['code_ostan']." AND code_anbar=".$row3['code_anbar']." AND year=".$row3['year']."");
	echo'
	<tr> 
	 <td width="99%" class="borderall" style="position:absolute;bottom:0px;left:0.5%;">	 	 
	  <table class="footer-panel" width="100%" cellpadding="0" cellspacing="0">
       <img src="images/loading.gif" id="loading" class="loading_img"/>
	   <tr class="title"><td colspan="8" align="center"> ويرايش اطلاعات برگه تعدیل '.$code_a.$row3['code_anbar'].$row3['shomare_barge_tadil'].'</td></tr>
       <tr>
	    <td align="left" width="150px"><span class="star">*</span> شماره برگه تعدیل :&nbsp;</td>
		<td align="right" width="150px">
		 <input type="text" readonly class="textboxme" value="'.$row3['shomare_barge_tadil'].'" name="shomare_barge_tadil" style="width:50px;"/>&nbsp;/&nbsp;
		 <input type="text" readonly class="textboxme" value="'.$code_a.$mt_gl_code_anbar.'" name="ostan_anbar" style="width:50px;"/></td>
        <td align="left" width="150px"><span class="star">*</span> تاریخ برگه تعدیل :&nbsp;</td><td align="right" width="150px"><input class="textboxme2" type="text" maxlength="10" name="tarikh_barge_tadil" value="'.$row3['tarikh_barge_tadil'].'" id="datepicker6"/></td>
		<td width="200px" colspan="8" align="left">
		 <table>
		  <tr>';		
	      //اگر اجازه ابطال داشته و این فرم هنوز ابطال نشده و سال فعال است
		  if(($right_ebtal)and($row3['status']==0)and($_SESSION['mtStatusYear']==0))
		  {
			IF(($chkchangeCode==0)OR(($chkchangeCode==1)AND($row3['noe_tadil']==2)))
			{
			 echo'<td align="left"><input type="button" class="buttonme" name="ebtal_x" value="ابطال برگه تعدیل" onClick="iconfirm(\''.$FileName.'?ebtal_x=1&id_='.$row3['id'].'&shomare_barge_tadil_='.$row3['shomare_barge_tadil'].'&noe_tadil_='.$row3['noe_tadil'].'&idMojody='.$row3['id_Mojody'].'&code_ziranbar_='.$row3['code_ziranbar'].'&code_kala_='.$row3['code_kala'].'&code_keshvar_='.$row3['code_keshvar'].'&code_tolidkonande_='.$row3['code_tolidkonande'].'&sal_tolid_shamsi_='.$row3['sal_tolid_shamsi'].'&mah_tolid_shamsi_='.$row3['mah_tolid_shamsi'].'&rouz_tolid_shamsi_='.$row3['rouz_tolid_shamsi'].'&code_karton_='.$row3['code_karton'].'&noe_tadil_='.$row3['noe_tadil'].'&tedad_karton_tadil_='.$row3['tedad_karton_tadil'].'&meghdar_nakhales_tadil_='.$row3['meghdar_nakhales_tadil'].'&meghdar_khales_tadil_='.$row3['meghdar_khales_tadil'].'&chkchangeCode_='.$chkchangeCode.'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\',\'برای ابطال برگه تعدیل  '.$code_a.$row3['code_anbar'].$row3['shomare_barge_tadil'].' \')"/></td>      
		          <td width="20px"><img border="0" src="images/button-cross_basic.png" width="20" height="20" /></td>';	
			}
			ELSE IF($chkchangeCode==1)
			{
			  $shomare_tadil_related=$db->get_from_where("shomare_barge_tadil","tadil_mojody","id='".$row3['id_tadil_related']."' AND shomare_mojavez_tadil='".$row3['shomare_mojavez_tadil']."' AND code_ostan=".$row3['code_ostan']." AND code_anbar=".$row3['code_anbar']." AND year=".$row3['year']."");
			  echo'<td colspan="2">برای ابطال این برگه ، برگه تعدیل شماره '.$shomare_tadil_related.' را ابطال کنید </td>';	
			}
		  }
		  if($row3['status']==1) echo'<td style="font-weight:bold;color:red;">وضعیت این فرم : ابطالی</td>';	
	      echo'
	      
		  </tr>
		 </table>
		</td>
	   </tr>     
	   <tr>
	    <td align="left"><span class="star">*</span> طریقه ایجاد فرم  : &nbsp; </td><td align="right">'.static_listbox("create_form",$row3['create_form'],"createformArr",1,"class='text4' disabled").'</td>';
		// if(!isset($noe_form_tadil)){($noe_form_tadil=$row3['noe_form_tadil']);}
		// echo'
		 // <td align="left" width="150px"><span class="star">*</span> نوع فرم تعدیل :&nbsp;</td><td align="right" width="150px">'.static_listbox("noe_form_tadil",$noe_form_tadil,"tadilformArr",1,"class='text4' onchange='myform.submit()'").'</td>';
		// if($noe_form_tadil==2) echo'';
		// else echo'<td align="left" width="150px"><span class="star">*</span> شماره مجوز :&nbsp;</td><td align="right" class="mojavezhide" width="150px"><input class="textboxme2" type="text" name="shomare_mojavez_tadil" value="'.$row3['shomare_mojavez_tadil'].'" onkeypress="return isNumber(event)"/></td>';       
		
		echo'<td align="left" width="150px"><span class="star">*</span> نوع فرم تعدیل :&nbsp;</td><td align="right" width="150px">'.static_listbox("noe_form_tadil",$row3['noe_form_tadil'],"tadilformArr",1,"class='text4' disabled").'</td>';
	   echo'
	   </tr>
	   <tr>
	    <td align="left" width="150px"><span class="star">*</span> شماره مجوز :&nbsp;</td><td align="right" class="mojavezhide" width="150px"><input class="textboxme2" type="text" name="shomare_mojavez_tadil" value="'.$row3['shomare_mojavez_tadil'].'" readonly /></td>
		<td align="left"><span class="star">*</span> نوع تعديل :&nbsp;</td><td align="right">'.static_listbox("noe_tadil",$row3['noe_tadil'],"tadilArr",1,"class='text4' disabled").'</td>';
	    IF($row3['noe_tadil']==2)echo'<td align="left" class="kasryshow"><span class="star">*</span> نوع کسری : &nbsp; </td><td align="right" class="kasryshow">'.static_listbox("noe_kasry",$row3['noe_kasry'],"tadilkasryArr",1,"class='text4'").'</td>';
		echo' <td width="30px"><span id="img_mojody"></span></td>';
		echo' <input type="hidden" id="id_mojody" name="id_mojody" value="'.$id_mojody.'"/>
       </tr>
       <tr>
	    <td colspan="8">
	     <table border="0" width="100%">
	      <tr>
	       <td width="70%" valign="top">
		    <fieldset>
	        <legend>مقادیر لازم از جدول موجودی کالا</legend>
	         <table width="100%" border="0" height="115px">
	          <tr>
		       <td align="left"><span class="star">*</span> کد کالا :&nbsp;</td><td align="right"><input class="textboxme2" type="text" name="code_kala" value="'.$row3['code_kala'].'" readonly maxlength="3" onkeypress="return isNumber(event)" onKeyUp="F10desc(event)" style="width:50px"/></td>
			   <td align="left">نام کالا :&nbsp;</td><td align="right" colspan="3"><input type="text" class="textboxme" readonly name="name_kala" id="name_kala" value="'.$row3['name_kala'].'"/></td>
	          </tr>
              <tr>			  
			   <td align="left">تاریخ تولید شمسی :&nbsp;</td>
	     	   <td align="right" colspan="3">
	     	        سال : <input class="textboxme2" readonly type="text" name="sal_tolid_shamsi" value="'.$row3['sal_tolid_shamsi'].'" style="width:40px;"/>
                    <!-- شدن disabled برای --> 
					ماه : '.static_listbox("mah_tolid_sh",$row3['mah_tolid_shamsi'],"mahshamsiArr",1,"class='text4' disabled").'
                     <input type="hidden" name="mah_tolid_shamsi" value="'.$row3['mah_tolid_shamsi'].'"/>
	     	   	    روز : <input class="textboxme2 textbox50" type="text" name="rouz_tolid_shamsi" readonly value="'.$row3['rouz_tolid_shamsi'].'"/>
			         <input type="hidden" name="sal_tolid_milady" value="'.$row3['sal_tolid_milady'].'"/>
	     	         <input type="hidden" name="mah_tolid_milady" value="'.$row3['mah_tolid_milady'].'"/>
	     	         <input type="hidden" name="rouz_tolid_milady" value="'.$row3['rouz_tolid_milady'].'"/>
			   </td>	
              </tr>
		      <tr>
			   	<input type=hidden name="code_keshvar" value="'.$row3['code_keshvar'].'"/>
	           <td align="left">نام کشور :&nbsp;</td><td align="right" ><input class="textboxme2" type="text" readonly id="name_keshvar" name="name_keshvar" value="'.$row3['name_keshvar'].'"/></td>
	           	<input type=hidden name="code_tolidkonande" value="'.$row3['code_tolidkonande'].'"/>
			   <td align="left">نام تولیدکننده :&nbsp;</td><td align="right" ><input class="textboxme2" type="text" readonly id="name_tolidkonande" name="name_tolidkonande" value="'.$row3['name_tolidkonande'].'"/></td>   
				<input type=hidden name="code_ziranbar" value="'.$row3['code_ziranbar'].'"/>
	           <td align="left">نام زیرانبار :&nbsp;</td><td align="right" ><input class="textboxme2" type="text" readonly id="name_ziranbar" name="name_ziranbar" value="'.$row3['name_ziranbar'].'"/></td>
			  </tr>';
	          if($row3['code_bastebandy']==1)//کارتن
			  {echo'
			   <tr>
			    <td align="left">کد کارتن :&nbsp;</td><td align="right"><input type="text" class="textboxme2" readonly name="code_karton" value="'.$row3['code_karton'].'"/></td>
			    <td align="left">وزن کارتن :&nbsp;</td><td align="right"><input type="text" class="textboxme2" readonly name="vazn_karton_this" value="'.$row3['vazn_karton_this'].'"/></td>
			   </tr>
               <tr> 			  
			    <td align="left">تعداد :&nbsp; </td><td align="right"><input type="text" class="textboxme2" readonly name="tedad_karton" value="'.$tedad_karton.'"/></td>
			    <td align="left">موجودی ناخالص :&nbsp; </td><td align="right"><input type="text" class="textboxme2" readonly name="mojody_nakhales" value="'.round($mojody_nakhales,3).'"/></td>
	            <td align="left">موجودی خالص :&nbsp; </td><td align="right"><input type="text" class="textboxme2" readonly name="mojody_khales" value="'.round($mojody_khales,3).'"/></td>
			   </tr>
			   <tr><td>&nbsp;</td></tr>';
			  }
	          if($row3['code_bastebandy']==2)//قوطی
			  {echo'
			   <tr>
			    <td align="left">کد قوطی :&nbsp;</td><td align="right"><input type="text" class="textboxme2" readonly name="code_karton" value="'.$row3['code_karton'].'"/></td>
			    <td align="left">وزن قوطی :&nbsp;</td><td align="right"><input type="text" class="textboxme2" readonly name="vazn_karton_this" value="'.$row3['vazn_karton_this'].'"/></td>
			   </tr>
               <tr> 			  
			    <td align="left">تعداد :&nbsp; </td><td align="right"><input type="text" class="textboxme2" readonly name="tedad_karton" value="'.$tedad_karton.'"/></td>
	            <td align="left">موجودی خالص :&nbsp; </td><td align="right"><input type="text" class="textboxme2" readonly name="mojody_khales" value="'.round($mojody_khales,3).'"/></td>
			   </tr>';
			  }
	          if($row3['code_bastebandy']==3)//لاشه
			  {echo'
               <tr> 			  
			    <td align="left">تعداد :&nbsp; </td><td align="right"><input type="text" class="textboxme2" readonly name="tedad_karton" value="'.$tedad_karton.'"/></td>
	            <td align="left">موجودی خالص :&nbsp; </td><td align="right"><input type="text" class="textboxme2" readonly name="mojody_khales" value="'.round($mojody_khales,3).'"/></td>
			   </tr>';
			  }
			  echo'
		     </table> 
		    </fieldset>		   
	       </td>
	       <td width="30%" valign="top"> 
		    <fieldset>
	        <legend>مقادیر تعدیل</legend>
		     <table width="100%" border="0" height="115px">';
			  if($row3['code_bastebandy']==1)//کارتن
			  {echo'
	           <tr><td align="left"> تعداد کارتن :&nbsp;</td><td align="right"><input class="textboxme2" type="text" readonly name="tedad_karton_tadil" value="'.$row3['tedad_karton_tadil'].'" onkeypress="return isNumber(event)"/></td></tr>
	           <tr><td align="left">مجموع وزن کارتن ها :&nbsp;</td><td align="right"><input class="textboxme2" readonly type="text" name="sum_karton_tadil" value="'.$row3['sum_karton_tadil'].'" onfocus="return sumkarton()"/></td></tr>		
			   <tr><td align="left"> مقدار ناخالص :&nbsp;</td><td align="right"><input class="textboxme2" type="text" readonly name="meghdar_nakhales_tadil" value="'.$row3['meghdar_nakhales_tadil'].'" onKeydown="return PressfloatOnly(event,this)"/></td></tr>
		       <tr><td align="left"> مقدار خالص :&nbsp;</td><td align="right"><input class="textboxme2" type="text" readonly name="meghdar_khales_tadil" value="'.$row3['meghdar_khales_tadil'].'" onKeydown="return PressfloatOnly(event,this)"/></td></tr>';
			  }
			  if($row3['code_bastebandy']==2)//قوطی
			  {echo'
	           <tr><td align="left" height="30px;"><span class="star">*</span> تعداد قوطی :&nbsp;</td><td align="right"><input class="textboxme2" type="text" readonly name="tedad_karton_tadil" value="'.$row3['tedad_karton_tadil'].'" onkeypress="return isNumber(event)"/></td></tr>
		       <tr><td align="left" height="35px;"><span class="star">*</span> مقدار خالص :&nbsp;</td><td align="right"><input class="textboxme2" type="text" readonly name="meghdar_khales_tadil" value="'.$row3['meghdar_khales_tadil'].'" onKeydown="return PressfloatOnly(event,this)"/></td></tr>
			   ';
			  }
			  if($row3['code_bastebandy']==3)//لاشه
			  {echo'
	           <tr><td align="left" height="30px;"><span class="star">*</span> تعداد :&nbsp;</td><td align="right"><input class="textboxme2" type="text" readonly name="tedad_karton_tadil" value="'.$row3['tedad_karton_tadil'].'" onkeypress="return isNumber(event)"/></td></tr>
		       <tr><td align="left" height="35px;"><span class="star">*</span> مقدار خالص :&nbsp;</td><td align="right"><input class="textboxme2" type="text" readonly name="meghdar_khales_tadil" value="'.$row3['meghdar_khales_tadil'].'" onKeydown="return PressfloatOnly(event,this)"/></td></tr>
			   ';
			  }
			  echo'
		      <tr><td align="left">توضيحات :&nbsp;</td><td align="right"><input class="textboxme" type="text" name="tozihat_tadil" value="'.$row3['tozihat_tadil'].'"/></td></tr>
			 </table>
		    </fieldset>
		   </td>
	      </tr>
         </table>
        </td>
       </tr>		
	   <tr>'; 
		 if((($right_edt)and($row3['status']==0)and($_SESSION['mtStatusYear']==0))or((SuperUser())and($row3['status']==0)))
		 {echo'
		  <td colspan="8" align="center" class="title">
		   <input class="buttonme" type="submit" name="Edit_x" id="sabt" value="ثبت تغييرات">
           <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'">
		  </td>';
		 }
         else echo'<td  colspan="8" align="center" class="title"><div onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-back"  title="بازگشت" style="float:left;width:55%"><a href="#"></a></div></td> ';
         echo'
       </tr>
      </table>
	 </td>
    </tr>';
    }
	if ($Mode=="Search" )//Search Mode
    {echo '
    <tr> 
	 <td width="99%" class="borderall" style="position:absolute;bottom:10px;left:0.5%;">	 	 
	  <table class="footer-panel" width="100%" cellpadding="0" cellspacing="0">
       <tr class="title"><td colspan="10" align="center">جستجوی فرم تعدیل موجودی</td></tr>
       <tr><td>&nbsp;</td></tr>	   
       <tr>
	    <td align="left">شماره برگه تعدیل : &nbsp; </td>
		<td align="right"><input class="textboxme2" type="text" name="shomare_barge_tadil_sch" onkeypress="return isNumber(event)" style="width:50px;"/>&nbsp;/&nbsp;';
		if(strlen($mt_gl_code_ostan)==1) $code_a=make_pattern($mt_gl_code_ostan,2);
		else $code_a=$mt_gl_code_ostan;
		echo'<input type="text" class="textboxme" readonly value="'.$code_a.$mt_gl_code_anbar.'" name="ostan_anbar" style="width:50px;"/>		                                               
		</td>
		<td align="left">تاریخ برگه تعدیل  : &nbsp; </td><td align="right"><input class="textboxme2" type="text" maxlength="10" name="tarikh_barge_tadil" id="datepicker6"/></td>
	    <td align="left">نوع فرم تعدیل  : &nbsp; </td><td align="right">
   		        <select name="noe_form_tadil" class="text4">
		         <option value="0">انتخاب کنید</option>
		         <option value="1">دائم</option>
		         <option value="2">موقت</option>
		        </select>
		</td>
		<td align="left">شماره مجوز  : &nbsp; </td><td align="right"><input class="textboxme2" type="text" name="shomare_mojavez_tadil" onkeypress="return isNumber(event)"/></td>       
	   	<td align="left">کد کالا : &nbsp; </td><td align="right"><input class="textboxme2" type="text" name="code_kala" onkeypress="return isNumber(event)" style="width:50px;"/>&nbsp;';
		include ("img_helpkala.php");
		echo'
		</td>
	   </tr>
	   <tr>
	    <td align="left">نوع تعديل : &nbsp; </td>
		<td align="right">
			    <select name="noe_tadil" class="text4">
		         <option value="0">انتخاب کنید</option>
		         <option value="1">اضافه</option>
		         <option value="2">کسری</option>
		        </select>
		</td>
        <td align="left">تعداد : &nbsp;</td><td align="right"><input class="textboxme2" type="text" name="tedad_karton_tadil" value="'.$tedad_karton_tadil.'" onkeypress="return isNumber(event)"/></td>
	    <td align="left">مقدار ناخالص : &nbsp;</td><td align="right"><input class="textboxme2" type="text" name="meghdar_nakhales_tadil" value="'.$meghdar_nakhales_tadil.'" onKeydown="return PressfloatOnly(event,this)"/></td>
		<td align="left">مقدار خالص : &nbsp;</td><td align="right"><input class="textboxme2" type="text" name="meghdar_khales_tadil" value="'.$meghdar_khales_tadil.'" onKeydown="return PressfloatOnly(event,this)"/></td>
	    <td align="left">توضيحات : &nbsp; </td><td colspan="2" align="right"><input class="textboxme" type="text" name="tozihat_tadil"/></td>	    
	   </tr>
	   <tr><td>&nbsp;</td></tr>
	   <tr>
        <td colspan="10" align="center" class="title">
		 <input class="buttonme" type="submit" name="Search_x" id="sabt" value="جستجو">
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
</div>';
/********************WEB SERVICE NEW***********************/
if(isset($send_tadil))//مراحل ثبت در وب سرویس
{
  if($_SESSION['mt_webservice']==1)//اتصال به وب سرویس
  {
    if(strlen($mt_gl_code_ostan)==1) $code_a=make_pattern($mt_gl_code_ostan,2);
    else $code_a=$mt_gl_code_ostan;
    $shomareGhabz=$mtActiveYear.$code_a.$mt_gl_code_anbar.$shomare_barge_tadil_.'t';
	
	$q_tadil="SELECT * From tadil_mojody WHERE code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND year=$mtActiveYear AND shomare_barge_tadil='$shomare_barge_tadil_'";
	$res_tadil = mysql_query($q_tadil);
	$row_tadil=mysql_fetch_assoc($res_tadil);
    $warehouse_id=$db->get_from_where("warehouse_id","list_sardkhane","code_ostan=".$row_tadil['code_ostan']." AND code_anbar=".$row_tadil['code_anbar']."");     
    //تعدیل اضافه مثل رسید
    IF($row_tadil['noe_tadil']==1) $type_tadil='in'; 
    //تعدیل کسری مثل حواله
    ELSE IF($row_tadil['noe_tadil']==2) $type_tadil='out';
	$vahedKala=$db->get_from_where("sharh_vahedkala","kala INNER JOIN vahed_kala ON kala.code_vahedkala=vahed_kala.code_vahedkala","code_kala=".$row_tadil['code_kala']."");     
	$bastebandyKala=$db->get_from_where("sharh_bastebandy","kala INNER JOIN bastebandy ON kala.code_bastebandy=bastebandy.code_bastebandy","code_kala=".$row_tadil['code_kala']."");     
    $nameKala=$db->get_from_where("name_kala","kala","code_kala=".$row_tadil['code_kala']."");     
	//تبدیل تاریخ شمسی به میلادی
	$sql_tarikh=$row_tadil['tarikh_barge_tadil'];
    $d=substr($sql_tarikh,8,2);$m=substr($sql_tarikh,5,2);$y=substr($sql_tarikh,0,4);
    $milady=jalali_to_gregorian($y,$m,$d);
    $sal=$milady[0];$mah=$milady[1];$rouz=$milady[2];
    $tarikh_tadil_MI=$sal.'-'.$mah.'-'.$rouz;
    $wsdl_url='http://10.7.234.33/anbar/warehouse.asmx?wsdl';
	header('Content-Type: text/html; charset=utf-8');
    try
	{
	  $client=new SoapClient($wsdl_url);
	  $itemsinfo=array(
	  'category_id'=>'',
	  'taxonomy_id'=>'',
	  'good_id'=>$row_tadil['code_kala'],
	  'good_name'=>$nameKala,
	  'total_weight'=>$row_tadil['meghdar_khales_tadil'],
	  'measurement_unit'=>$vahedKala,
	  'count'=>$row_tadil['meghdar_khales_tadil'],
	  'package_type'=>$bastebandyKala,
	  'package_count'=>$row_tadil['tedad_karton_tadil'],
	  'item_value'=>'',
	  'production_date'=>$tarikh_tadil_MI,
	  'expire_date'=>$tarikh_tadil_MI,
	  'description'=>'',
	  'location'=>''
	  );
	  $listitemsinfo=array(
          $itemsinfo
      );
	  $otherinfo=array(
		 'owner_phone'=>'82971',
		 'good_owneragent'=>'',
		 'bol_date'=>$tarikh_tadil_MI,
		 'bol_tid'=>'',
		 'bol_series'=>'',
		 'bol_serial'=>''
	  );
	  $docinfo=array(
		 'warehouse_id'=>$warehouse_id,
		 'contractor_co_national_id'=>'14002771736',
		 'number'=>$shomareGhabz,
		 'type'=>$type_tadil,
		 'issue_date'=>$tarikh_tadil_MI,
		 'owner'=>'14002771736',
		 'owner_name'=>'شرکت پشتیبانی امور دام کشور',
		 'vehicle_number'=>'',
		 'driver_national_id'=>'',
		 'driver'=>'',
		 'insurance_name'=>'',
		 'insurance_date'=>$tarikh_tadil_MI,
		 'insurance_number'=>'',
		 'Commodity'=>$listitemsinfo,
		 'details'=>$otherinfo
	   );
	   $params=array(
          'username'=>'02',
          'password'=>'HJ78mnGD',
          'type'=>$type_tadil,
          'doc'=>$docinfo
		); 
	    $result=$client->WarehouseInOut($params); 
	    $response=$result->WarehouseInOutResult;
	    $webservice_error_code =$response->ErrorCode;
	    $webservice_error_message =$response->ErrorMessage;
	    $webservice_status =$response->status;
	    $webservice_number =$response->number;
			 
		echo "<script>alert('شماره سند وب سرویس\\n$webservice_number')</script>"; 
	   }
	   catch(SoapFault $client)
	   {
		 echo "<script>alert('وب سرویس فعال نمی باشد')</script>";
	   }
  	   $update_track=("UPDATE tadil_mojody SET webservice_error_code='$webservice_error_code',webservice_error_message='$webservice_error_message',webservice_status='$webservice_status',webservice_number='$webservice_number' WHERE code_ostan=".$row_tadil['code_ostan']." AND code_anbar=".$row_tadil['code_anbar']." AND shomare_barge_tadil='".$row_tadil['shomare_barge_tadil']."' AND year=$mtActiveYear");
	   $update_res=mysql_query($update_track); 
  }
  echo "<script>window.location='$FileName?PageNo=".$PageNo."&RowPerPage=".$RowPerPage."&order=".$order."';</script>";     
}
///////////////////////////////////////////////////////////////////   
echo'
'.$message.'
</form>
</body>
</html>';	
?>