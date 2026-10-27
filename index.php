<?php
session_start();
error_reporting(0);
include "config.php";
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
$FileName="index.php";
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
if (SuperUser()) $mtuserNAME="Administrator";
else $mtuserNAME=$_SESSION['mt_userName'];
// $chkforush=$db->get_from_where("chkforush","list_sardkhane","code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar'");
 // if($chkforush==1) $_SESSION['mt_systemforush']=1;
 // else              $_SESSION['mt_systemforush']=0;
//echo $mtActiveYear;
//echo $_SESSION['mt_code_anbar'].'<br/>';
/*******تاريخ*******/
$today=AsLDate($yymmdd);
//if(SuperUser()) echo $_SESSION['mt_situation_type'];
//اگر سردخانه را از پایین صفحه عوض کرد
if($_POST['mtglobal_code_sardkhane'])
{
  $mt_gl_code_anbar=$_POST['mtglobal_code_sardkhane'];
  $_SESSION['mt_code_anbar']=$mt_gl_code_anbar;
  $res_anbar=mysql_query("SELECT id,name_anbar,status_peymankar,situation_type,chktozin,activate,chkhavaleshow FROM list_sardkhane WHERE code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar'");
  $_SESSION['mt_id_anbar']=mysql_result($res_anbar, 0, 'id');
  $_SESSION["mt_name_anbar"]=mysql_result($res_anbar, 0, 'name_anbar');
  $_SESSION['mt_status_peymankar']=mysql_result($res_anbar, 0, 'status_peymankar');
  $mt_gl_name_anbar=$_SESSION["mt_name_anbar"];
  $_SESSION['mt_situation_type']=mysql_result($res_anbar, 0, 'situation_type');
  $_SESSION['mt_anbar_activate']=mysql_result($res_anbar, 0, 'activate');
  //تغییر سشن اتصال به سیستم فروش یا سردخانه، سردخانه انتخاب شده 
  $query_f=mysql_query("SELECT chkforush FROM list_sardkhane WHERE code_ostan='".$_SESSION['mt_code_ostan']."' AND code_anbar='".$_SESSION['mt_code_anbar']."'");
  $chkforush=mysql_result($query_f, 0, 'chkforush');
  $chktozin=mysql_result($res_anbar, 0, 'chktozin');
  if($chkforush==1) $_SESSION['mt_systemforush']=1;
  else              $_SESSION['mt_systemforush']=0;
  //تغییر سشن اتصال به سیستم توزین 
  if($chktozin==1)  $_SESSION['mt_systemtozin']=1;
  else                $_SESSION['mt_systemtozin']=0;
  //تغییر سشن /مشاهده حواله ها 
  if($chkhavaleshow==1)  $_SESSION['mt_havaleshow']=1;
  else              $_SESSION['mt_havaleshow']=0;
  //تغییر سشن اتصال به وب سرویس ، سردخانه انتخاب شده
  $query_w=mysql_query("SELECT chkwebservice FROM list_sardkhane WHERE code_ostan='".$_SESSION['mt_code_ostan']."' AND code_anbar='".$_SESSION['mt_code_anbar']."'");
  $chkwebservice=mysql_result($query_w, 0, 'chkwebservice');
  if($chkwebservice==1) $_SESSION['mt_webservice']=1;
  else              $_SESSION['mt_webservice']=0;
  //تغییر سشن داشتن پیمانکار سردخانه انتخاب شده
  $query_status_peymankar=mysql_query("SELECT status_peymankar FROM list_sardkhane WHERE code_ostan='".$_SESSION['mt_code_ostan']."' AND code_anbar='".$_SESSION['mt_code_anbar']."'");
  $_SESSION['mt_status_peymankar']=mysql_result($query_status_peymankar, 0, 'status_peymankar');

  if($_SESSION['mt_systemforush']==1)
{  
  //پیدا کردن آی دی کد استان مربوط به سیتم فروش
  $res_ostan=mysql_query("SELECT province_id FROM sell.dm_province WHERE province_code=".$_SESSION["mt_code_ostan"]."");
  $_SESSION['sell_id_ostan']=mysql_result($res_ostan, 0, 'province_id');
  $sell_id_ostan=$_SESSION['sell_id_ostan'];
  //پیدا کردن آی دی کد انبار مربوط به سیستم فروش
  $res_anbar=mysql_query("SELECT l_id FROM sell.dm_location_goods WHERE l_id_province='$sell_id_ostan' AND l_code=".$_SESSION['mt_code_anbar']."");
  $_SESSION['sell_id_anbar']=mysql_result($res_anbar, 0, 'l_id');
  $sell_id_anbar=$_SESSION['sell_id_anbar'];
  //پیدا کردن آی دی سال مربوط به سیستم فروش
  IF($mtActiveYear<1400) $sellYearCode=substr($mtActiveYear,2);
  ELSE $sellYearCode=$mtActiveYear;
  $res_sal=mysql_query("SELECT year_id FROM sell.dm_year WHERE year_code='$sellYearCode'");
  $_SESSION['sellYearId']=mysql_result($res_sal, 0, 'year_id');
  $sellYearId=$_SESSION['sellYearId'];
}
}
//اگر استان را از پایین صفحه عوض کرد
if($_POST['mtglobal_code_ostan'])
{
 if($mtglobal_code_ostan!=$_SESSION['mt_code_ostan'])
 {
   $_SESSION['mt_code_anbar']='';
   $mt_gl_code_anbar='';
  }
 $mt_gl_code_ostan=$_POST['mtglobal_code_ostan'];  
 $_SESSION['mt_code_ostan']=$mt_gl_code_ostan;
 $res_ostan=mysql_query("SELECT name_ostan FROM ostan WHERE code_ostan='$mt_gl_code_ostan'");
 $_SESSION['mt_name_ostan']=mysql_result($res_ostan, 0, 'name_ostan');
 $mt_gl_name_ostan=$_SESSION['mt_name_ostan'];
}
//اگر سشن کد استان خالی باشد 
if (!$_SESSION['mt_code_ostan'])  {$_SESSION['mt_code_ostan']=-1; $mt_gl_code_ostan=$_SESSION["mt_code_ostan"];}
//اگر سشن کد انبار خالی باشد 
if (!$_SESSION['mt_code_anbar'])  {$_SESSION['mt_code_anbar']=-1; $mt_gl_code_anbar=$_SESSION['mt_code_anbar'];}
//اگر سال را از پایین صفحه عوض کرد
if ($_POST['mtact_yr']) 
{
   $_SESSION['mtActiveYear']=$_POST['mtact_yr'];//سال مورد نظر
   //وضعیت فعال بودن سال
   $_SESSION['mtStatusYear']=$db->get_from_where("status","mt_docs","year=".$_SESSION['mtActiveYear']."");
   $_SESSION['mtstart_date_sh']=$db->get_from_where("start_from","mt_docs","year=".$_SESSION['mtActiveYear']."");//تاریخ شروع سال
   $sql_tarikh_start=$_SESSION['mtstart_date_sh'];//تبدیل تاریخ شروع سال به میلادی
   $d_s=substr($sql_tarikh_start,8,2);
   $m_s=substr($sql_tarikh_start,5,2);
   $y_s=substr($sql_tarikh_start,0,4);
   $milady_s=jalali_to_gregorian($y_s,$m_s,$d_s);
   $sal_s=$milady_s[0];
   $mah_s=$milady_s[1];
   $rouz_s=$milady_s[2];
   $_SESSION['mtstart_date_mi']=$sal_s.'-'.$mah_s.'-'.$rouz_s;
   //تاریخ پایان سال
   $_SESSION['mtend_date_sh']=$db->get_from_where("end_to","mt_docs","year=".$_SESSION['mtActiveYear']."");
   $sql_tarikh_end=$_SESSION['mtend_date_sh'];//تبدیل تاریخ پایان سال به میلادی
   $d_e=substr($sql_tarikh_end,8,2);
   $m_e=substr($sql_tarikh_end,5,2);
   $y_e=substr($sql_tarikh_end,0,4);
   $milady_e=jalali_to_gregorian($y_e,$m_e,$d_e);
   $sal_e=$milady_e[0];
   $mah_e=$milady_e[1];
   $rouz_e=$milady_e[2];
   $_SESSION['mtend_date_mi']=$sal_e.'-'.$mah_e.'-'.$rouz_e;
}
if(!$_SESSION['mtActiveYear']) $_SESSION['mtActiveYear']=$db->get_from_where("year","mt_docs","start_from<='$todaydate' AND end_to>='$todaydate'");
//if(!$_SESSION['mtActiveYear']) $_SESSION['mtActiveYear']=$db->get_from_where("year","mt_docs","status=0 and start_from<='$todaydate' AND end_to>='$todaydate'");

//if (!$_SESSION['AccActiveYear']) $_SESSION['AccActiveYear']=$db->get_from_where("year","acc_docs","curr=1 and org='$acc_org_id'");
$mtStartDateSh=$_SESSION['mtstart_date_sh'];
$mtStartDateMi=$_SESSION['mtstart_date_mi'];
$mtEndDateSh=$_SESSION['mtend_date_sh'];
$mtEndDateMi=$_SESSION['mtend_date_mi'];
$mtActiveYear=$_SESSION['mtActiveYear'];
//وضعیت فعال بودن سال
$_SESSION['mtStatusYear']=$db->get_from_where("status","mt_docs","year=".$_SESSION['mtActiveYear']."");
/******************OWNER***********************/
if(!$_SESSION["mt_owner"])
{
  $q_docs=$db->query("SELECT * FROM docs");
  $res_docs=$db->fetch_assoc($q_docs);
  $_SESSION["mt_owner"]= $res_docs['owner']; $mt_gl_owner=$_SESSION["mt_owner"];
  $_SESSION["mt_sherkat_name"]= $res_docs['sherkat_name'];
  $_SESSION["mt_email"]= $res_docs['email'];
  $_SESSION["mt_tel"]= $res_docs['tel'];
  $_SESSION["mt_fax"]= $res_docs['fax'];
  $_SESSION["mt_url"]= $res_docs['url'];
}
echo'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" />
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>سيستم سردخانه</title>
<meta http-equiv="Content-Language" content="fa">
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<!-- <link rel="shortcut icon" href="images/favicon2.ico" title="Favicon" /> -->
<link href="styles.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="Fonts/Font-Awesome/css/font-awesome.css">
<link type="text/css" href="styles/jquery-ui-1.8.14.css" rel="stylesheet" />
<script type="text/javascript" src="scripts/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="scripts/jquery.ui.datepicker-cc.all.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
$("#home img[title]").tooltip();});
<!-- محاسبه ساعت-->
setInterval(function() {
    var currentTime = new Date ( );    
    var currentHours = currentTime.getHours ( );   
    var currentMinutes = currentTime.getMinutes ( );   
    var currentSeconds = currentTime.getSeconds ( );
    currentMinutes = ( currentMinutes < 10 ? "0" : "" ) + currentMinutes;   
    currentSeconds = ( currentSeconds < 10 ? "0" : "" ) + currentSeconds;    
    var timeOfDay = ( currentHours < 12 ) ? "قبل از ظهر" : "بعد ازظهر";    
    currentHours = ( currentHours > 12 ) ? currentHours - 12 : currentHours;    
    currentHours = ( currentHours == 0 ) ? 12 : currentHours;    
    var currentTimeString = currentHours + ":" + currentMinutes + ":" + currentSeconds + " " + timeOfDay;
    document.getElementById("timer").innerHTML = currentTimeString;
    }, 1000);
</script>
<!--بازشدن پنجره گزارش ها-->
<script type="text/javascript">
function showPopup(url,ChatWindow_Height,ChatWindow_Width) 
{
 newwindow=window.open(url, "name", "height=" + ChatWindow_Height + ", width = " + ChatWindow_Width +",top=50px,left=200,resizable,scrollbars=1");
 if (window.focus) {newwindow.focus()}
 self.frames["my_frame"].location.href="my_frame.php";
}
</script>
<script>
    $.ajax({
		url: "Message/ajaxComment.php", 
		success: function(data){
		if(data==0){				   
			$("#message a span").removeClass("bell");			 
		}else if(data > 0){
			$("#message a span").addClass("bell");
		}
		$("#messageCount").html(data);
		}
	});
	setInterval(function() {
		$.ajax({
			url: "Message/ajaxComment.php", 
			success: function(data){
				if(data==0){
					$("#message a span").removeClass("bell");
				}else if(data > 0){ 
					$("#message a span").addClass("bell");
					var audio = $("audio")[0];
					audio.play();
				}
				$("#messageCount").html(data);			 
			}
		});
	},600000);
</script>
</head>
<body scroll="no">
<audio>
	<source src="audio/microwave-oven-bell-1.mp3"></source>	
</audio>
<form method="post" name="IndexForm">
<div id="wrapper">
<!-- قالب اصلي-->
<div id="outerDiv2">
 <!--هدر صفحه-->
 <div id="headerDiv2">
   <!--<div class="logo-back"><img src="images/back2.png"/></div>-->
   <!--<div class="logo"><img src="images/Untitled-1.png"/></div>-->
   <!--<div class="logo"><img src="images/page3.jpg"/></div>-->
   <!--<div class="logo"><img src="images/lll.png"/></div>-->
   <!--<img class="topBannerImg" src="images/bg-banner.png"/>-->
  <div class="navi">
	<table border="0">
		<!--<tr>
			<td><div id="home" onClick="self.frames[\'my_frame\'].location.href=\'my_frame.php\'" title="خانه"><a href=""></a></div></td>
			<td><div id="calc" onClick="window.open(\'mashinhesab.php\',\'\',\'width=350px,height=300px,top=250px,left=20px\')" title="ماشین حساب"><a href=""></a></div></td>
			<td><div id="exit" onClick="window.location=\'logout.php\'" title="خروج از سیستم"><a href=""></a></div></td>
		</tr>-->
		<tr>
			<td><div id="home" onClick="self.frames[\'my_frame\'].location.href=\'my_frame.php\'" title="خانه"><a href=""></a></div></td>
			<!--<td><div id="calc" onClick="window.open(\'mashinhesab.php\',\'\',\'width=350px,height=300px,top=250px,left=20px\')" title="ماشین حساب"><a href="#"></a></div></td>-->
			<td align="center" title="ماشين حساب">
				<img border="0" src="images/calc.png" style="float:right;cursor:pointer;padding-right:5px;width:22px;height:22px;"
					onClick="window.open(\'mashinhesab.php\',\'\',\'width=350px,height=300px,top=250px,left=20px\')"
					onmouseOver="this.src=\'images/calc-hover.png\'"
					onmouseOut="this.src=\'images/calc.png\'"/>
			</td>
			<td><div id="profile" title="پروفایل کاربر"><a target="my_frame" href="profile.php"></a></div></td>';

			if(isset($_SESSION['mt_user_id'])){
			echo'
			<td><div id="message" title="پیام ها"><a  href="Message/CommentInbox_Frm.php"><span class="fa fa-bell-o fa-fw bell" ></span></a></div></td>
			<td><div id="messageCount" title="پیام خوانده نشده"></div></td>';
			}
			echo'
			<td><div id="help" title="راهنما"><a target="my_frame" href="user_guide.html"></a></div></td>
			<!--<td><a href="#" class="tooltip-right" data-tooltip="I’m the tooltip text"><img class="help" border="0" src="images/button-round-question-icon.png" style="cursor:pointer" onmouseOver="this.src=\'images/button-round-dark-question-icon.png\'" onmouseOut="this.src=\'images/button-round-question-icon.png\'"/></a></td>-->
			<td><div id="exit" onClick="window.location=\'logout.php\'" title="خروج از سیستم"><a href="#"></a></div></td>
		</tr>
	</table>
  </div>
  <div>
   <table align="center" border="0">
    <tr>
     <td>  
      <!-- بلاک منوها-->
      <div id="main-menu">
	   <ul>';
	    if (right(1))
		echo'<li><a href="#" ><span class="fa fa-files-o fa-fw" style="color:#FAFABB">&nbsp;</span> جداول پايه</a>';
	    echo' <ul class="sub-menu">';
		if (right(2)) 
		  echo'<li><a target="my_frame" href="ostan.php">استان ها</a></li>';
         if (right(10)) 		
		  echo' <li><a target="my_frame" href="list_sardkhane.php">سردخانه ها</a></li>';
		 if (right(23))
		  echo' <li><a target="my_frame" href="keshvar.php">کشورها</a></li>';
 		 if (right(27))
          echo' <li><a target="my_frame">اطلاعات کالا &raquo;</a>';
		   echo '<ul>';
 		   if (right(28)) 
		    echo' <li><a target="my_frame" href="vahed_kala.php">واحد کالا</a></li>';		  
           if (right(32)) 		
		    echo' <li><a target="my_frame" href="bastebandy.php">نوع بسته بندی</a></li>';
		   if (right(36))
		    echo' <li><a target="my_frame" href="group_kala.php">گروه کالا</a></li>';
		   if (right(36))		    
            echo' <li><a target="my_frame" href="group_kala_middle.php">گروه کالا میانی</a></li>';
		   if (right(40))
		    echo' <li><a target="my_frame" href="kala.php">کالا</a></li>';		   
		 echo'</ul></li>';
		 if (right(48)) 		
		    echo' <li><a target="my_frame" href="karton.php">نوع کارتن / قوطی</a></li>';
		 //if(SuperUser())
		    //echo' <li><a target="my_frame" href="karton2.php">نوع کارتن / قوطی دوم</a></li>';
		 if (right(52)) 		
		  echo' <li><a target="my_frame" href="tolidkonande.php">تولید کننده</a></li>';
         //if(SuperUser()) 		
		  //echo' <li><a target="my_frame" href="tolidkonande_ostani.php">تولید کننده دوم</a></li>';
		 if (right(56)) 		
		  echo' <li><a target="my_frame" href="gheymat_jarime.php">جدول قيمت جریمه</a></li>';
		 //if (right(64)) 		
		  //echo' <li><a target="my_frame" href="gheymat.php">جدول قيمت خرید</a></li>';
		 if (right(72))
		  echo' <li><a target="my_frame">جداول هزینه &raquo;</a>';
		  echo '<ul>';
		  if (right(73)) 
		   echo' <li><a target="my_frame" href="hazine_takhlie.php">جدول هزینه تخلیه</a></li>';
		  if (right(81)) 
		   echo' <li><a target="my_frame" href="hazine_bargiry.php">جدول هزینه بارگیری</a></li>';
		  if (right(89)) 
		   echo' <li><a target="my_frame" href="hazine_baskul.php">جدول هزینه باسکول</a></li>';
		  echo'</ul></li>';
		 if (right(97)) 
		  echo' <li><a target="my_frame" href="moshtary.php">مشتريان</a></li>';
		 if (right(101)) 
		  echo' <li><a target="my_frame" href="mabady_vorudy.php">مبادی ورودی کالا</a></li>';
		 if (right(105)) 
		  echo' <li><a target="my_frame">اطلاعات فروشنده / کشتی &raquo;</a>';
		 echo'<ul>';
		 if (right(106))
		  echo' <li><a target="my_frame" href="mt_skk.php">فروشنده / کشتی</a></li>';
		 if (right(110)) 
		  echo' <li><a target="my_frame" href="shomare_safar.php">شماره قرارداد/ سفر</a></li>';
         if (right(114)) 
		  echo' <li><a target="my_frame" href="coding_mali_keshty.php">کدینگ کد مالی فروشنده/کشتی</a></li>';		  
		  echo'</ul></li>';
		 if (right(118)) 
		  echo' <li><a target="my_frame" href="takhlie.php">نوع تخليه</a></li>';
		 if (right(122)) 
		  echo' <li><a target="my_frame" href="peymankar_haml.php">پيمانکار حمل</a></li>';
		 if (right(126)) 
		  echo' <li><a target="my_frame" href="amel_pardakht.php">عامل پرداخت پسکرایه</a></li>'; 
		 if (right(702)) 
		  echo' <li><a target="my_frame" href="tarikh_mandegari.php">تاریخ ماندگاری</a></li>'; 
		 echo'</ul>
	    </li>';
		//حواله هایی که رسیدشان را نزده اند
		$count_havale_in_this=$db->get_from_where("COUNT(*)","havale INNER JOIN mojavez_jabejae ON havale.shomare_jabejae = mojavez_jabejae.shomare_jabejae AND havale.code_ostan = mojavez_jabejae.code_ostan AND havale.code_anbar = mojavez_jabejae.code_anbar AND havale.year = mojavez_jabejae.year","havale.code_ostan=$mt_gl_code_ostan AND havale.code_anbar=$mt_gl_code_anbar AND havale.year=$mtActiveYear AND havale.status=0 AND havale.deleted=0 AND havale.sabt_nahayi=1 AND havale.tarikh_havale_anbar>='$Condition_JabejaeDate_sh' AND noe_tahvil_bar=4 AND(havale.id NOT IN(SELECT id_havale FROM resid WHERE code_ostan_mabda=havale.code_ostan AND code_anbar_mabda=havale.code_anbar AND code_ostan=mojavez_jabejae.code_ostan_maghsad_j AND code_anbar=mojavez_jabejae.code_anbar_maghsad_j AND shomare_havale_anbar=havale.shomare_havale_anbar AND deleted=0 AND status=0 AND (noe_tahvil_bar=4 or noe_tahvil_bar=5)))");
		//حواله هایی که رسیدشان را نزده ایم
		$count_havale_for_this=$db->get_from_where("COUNT(*)","havale INNER JOIN mojavez_jabejae ON havale.shomare_jabejae = mojavez_jabejae.shomare_jabejae AND havale.code_ostan = mojavez_jabejae.code_ostan AND havale.code_anbar = mojavez_jabejae.code_anbar AND havale.year = mojavez_jabejae.year","code_ostan_maghsad_j=$mt_gl_code_ostan AND code_anbar_maghsad_j=$mt_gl_code_anbar AND mojavez_jabejae.year=$mtActiveYear AND havale.status=0 AND havale.deleted=0 AND havale.sabt_nahayi=1 AND havale.tarikh_havale_anbar>='$Condition_JabejaeDate_sh' AND noe_tahvil_bar=4 AND(havale.shomare_havale_anbar NOT IN(SELECT shomare_havale_anbar FROM resid WHERE code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND year=$mtActiveYear AND code_ostan_mabda=havale.code_ostan AND code_anbar_mabda=havale.code_anbar AND shomare_havale_anbar=havale.shomare_havale_anbar AND year=havale.year AND deleted=0 AND status=0 AND (noe_tahvil_bar=4 or noe_tahvil_bar=5)))");
		//$count_havale_for_this=$db->get_from_where("COUNT(*)","havale INNER JOIN mojavez_jabejae ON havale.shomare_jabejae = mojavez_jabejae.shomare_jabejae AND havale.code_ostan = mojavez_jabejae.code_ostan AND havale.code_anbar = mojavez_jabejae.code_anbar AND havale.year = mojavez_jabejae.year","code_ostan_maghsad_j=$mt_gl_code_ostan AND code_anbar_maghsad_j=$mt_gl_code_anbar AND mojavez_jabejae.year=$mtActiveYear AND havale.status=0 AND havale.deleted=0 AND havale.sabt_nahayi=1 AND havale.tarikh_havale_anbar>='$Condition_JabejaeDate_sh' AND noe_tahvil_bar=4 AND(havale.id NOT IN(SELECT id_havale FROM resid WHERE code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND year=$mtActiveYear AND deleted=0 AND status=0 AND (noe_tahvil_bar=4 or noe_tahvil_bar=5)))");
		//$count_havale_for_this=$db->get_from_where("COUNT(*)","havale INNER JOIN mojavez_jabejae ON havale.shomare_jabejae = mojavez_jabejae.shomare_jabejae AND havale.code_ostan = mojavez_jabejae.code_ostan AND havale.code_anbar = mojavez_jabejae.code_anbar AND havale.year = mojavez_jabejae.year","code_ostan_maghsad_j=$mt_gl_code_ostan AND code_anbar_maghsad_j=$mt_gl_code_anbar AND mojavez_jabejae.year=$mtActiveYear AND havale.status=0 AND havale.deleted=0 AND havale.sabt_nahayi=1 AND havale.tarikh_havale_anbar>='$Condition_JabejaeDate_sh' AND noe_tahvil_bar=4 AND(havale.id NOT IN(SELECT id_havale FROM resid WHERE code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND deleted=0 AND status=0 AND (noe_tahvil_bar=4 or noe_tahvil_bar=5)))");         
         //echo $count_havale_for_this;
	    //طرح در کمیسیون تایید نشده
		$count_oftokasry=$db->get_from_where("COUNT(*)","mojavez_oftokasry","code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar AND year=$mtActiveYear AND deleted=0 AND status=0 AND chktaeed=0");    
		
		if (right(130)) 
		echo'<li><a href="#"><span class="fa fa-file-text-o fa-fw" style="color:#FAFABB">&nbsp;</span> اطلاعات ';if(($count_havale_in_this>0)or($count_havale_for_this>0)or((right(600))and($count_oftokasry>0)))echo'&nbsp;&nbsp;<span class="fa fa-bell-o fa-fw bell" style="color:yellow;"></span>';echo'</a>';
	     echo' <ul class="sub-menu">';
		  if (right(131)) 
		   echo'<li><a target="my_frame" href="mojody_kala.php">موجودی کالا در سردخانه</a></li>';
		  if (right(135)) 
		   echo'<li><a target="my_frame" href="havale_forush.php">حواله فروش</a></li>';
		  if (right(140)) 
		   echo'<li><a target="my_frame" href="ebtal.php">ابطال مقادير حواله فروش</a></li>';
		  if (right(145)) 
		   echo'<li><a target="my_frame" href="mojavez_jabejae.php">مجوز جابه جایی</a></li>';
		  if (right(150)) 
		   echo'<li><a target="my_frame" href="ebtal_jabejae.php">ابطال مقادير مجوز جابه جایی</a></li>';
		  if (right(155)) 
		   echo'<li><a target="my_frame" href="resid.php">وارده به سردخانه ';if($count_havale_for_this>0)echo'<img class="blinkelement" src="images/Info1.png" style="width:15px;height:15px;"/>';echo'</a></li>';
		  if (right(170)) 
		   echo'<li><a target="my_frame" href="havale.php">صادره از سردخانه ';if($count_havale_in_this>0)echo'<img class="blinkelement" src="images/Info1.png" style="width:15px;height:15px;"/>';echo'</a></a></li>';
		  if (right(180)) 
		   echo'<li><a target="my_frame" href="mojavez_oftokasry.php">طرح در کمیسیون افت و کسری ';if((right(600))and($count_oftokasry>0))echo'<img class="blinkelement" src="images/Info1.png" style="width:15px;height:15px;"/>';echo'</a></li>';		  
	      if (right(187)) 
		   echo'<li><a target="my_frame" href="mojavez_tadil_mojody.php">مجوز تعدیل موجودی</a></li>';
		  if (right(193)) 
		   echo'<li><a target="my_frame" href="tadil_mojody.php">تعديل موجودی</a></li>';
		  if (right(199)) 
		   echo'<li><a target="my_frame" href="anbargardani.php">شمارش انبارگردانی</a></li>';
		  if (right(206)) 
		   echo'<li><a target="my_frame" href="cardex.php">کنترل کاردکس</a></li>';
		  if (right(207)) 
		   echo'<li><a target="my_frame" href="cardex_forush.php">کاردکس حواله فروش</a></li>';
		  if (right(208)) 
		   echo'<li><a target="my_frame" href="cardex_jabejae.php">کاردکس مجوز جابه جایی</a></li>';
		  if (right(800)) 
		   echo'<li><a target="my_frame" href="mojody_kala_gomrok.php">موجودی کالا تحت کلید گمرک</a></li>';
		 echo'</ul>
	    </li>';
	    if (right(210)) 
		echo'<li><a href="#"><span class="fa fa-print fa-fw" style="color:#FAFABB">&nbsp;</span> گزارشات</a>';
	     echo'<ul class="sub-menu">';
		  if (right(211))
		   	echo'<li><a target="my_frame">گزارش حواله سردخانه &raquo; </a>
		          <ul>';
			if (right(212)) 	  
		     echo'<li><a href="report_havale.php" onClick="showPopup(this.href,600,1000);return(false);show();">حواله به طور کلی</a></li>';
		    if (right(213)) 
		     echo'<li><a href="report_havale_withdetail.php" onClick="showPopup(this.href,600,1000);return(false);show();">حواله با جزئیات کالا</a></li>';
		  	echo'</ul>
		    </li>';
		  if (right(214))
			echo'<li><a target="my_frame">گزارش رسید سردخانه &raquo; </a>
		          <ul>';
		    if (right(215))
		     echo'<li><a href="report_resid.php" onClick="showPopup(this.href,600,1000);return(false);show();">رسید به طور کلی</a></li>';
		    if (right(216)) 
		     echo'<li><a href="report_resid_withdetail.php" onClick="showPopup(this.href,600,1000);return(false);show();">رسید با جزئیات کالا</a></li>';
		    echo'</ul>
		    </li>';
		  if (right(217)) 
		   echo'<li><a href="report_tadil.php" onClick="showPopup(this.href,600,900);return(false);">گزارش تعدیل موجودی</a></li>';
		  if (right(218)) 
		   echo'<li><a href="report_ebtal_forush.php" onClick="showPopup(this.href,600,800);return(false);">گزارش ابطال حواله فروش</a></li>';
		  if (right(219)) 
		   echo'<li><a href="report_date_cardex.php" onClick="showPopup(this.href,600,900);return(false);">گزارش محدوده تاریخ کاردکس</a></li>';
		  if (right(220)) 
		   echo'<li><a href="report_mojody.php" onClick="showPopup(this.href,600,1000);return(false);">گزارش وضعیت موجودی سردخانه</a></li>';
		  if (right(221)) 
		   echo'<li><a href="report_forushande_mojody.php" onClick="showPopup(this.href,600,1000);return(false);">وضعیت موجودی براساس فروشندگان</a></li>';
	      //echo'<li><a target="my_frame" href="report_varede_sadere.php">گزارش کالای وارده و صادره در محدوده تاریخ</a></li>';		  
		  echo'<!--<li><a target="my_frame" href="report_sadere_kala.php" onClick="showPopup(this.href);return(false);">گزارش مقادير صادره از هر کالادرمحدوده تاريخ</a></li>-->
		           <!--<li><a target="my_frame" href="#" onClick="showPopup(this.href);return(false);">گزارش مقاديروارده از هر کالادر محدوده تاريخ</a></li>-->';
		  if (right(222)) 
		   echo'<li><a  href="report_mojody_hforush.php" onClick="showPopup(this.href,600,1000);return(false);">مانده موجودی و حواله فروش</a></li>';
		  if (right(223))
		   echo'<li><a target="my_frame">خلاصه وضعیت حواله فروش &raquo; </a>
		         <ul>';  
		   if (right(224))
		    echo'<li><a  href="report_forush_moshtary.php" onClick="showPopup(this.href,600,1000);return(false);">حواله فروش-مشتری</a></li>';
		   if (right(225)) 
		    echo'<li><a  href="report_forush_kala.php" onClick="showPopup(this.href,600,1000);return(false);">حواله فروش-کالا</a></li>';
		   if (right(226)) 
		    echo'<li><a  href="report_forush_kala2.php" onClick="showPopup(this.href,600,1000);return(false);">حواله فروش- کالا(نسخه دوم)</a></li>';
		   if (right(227)) 
		    echo'<li><a  href="report_forush_mandedar.php" onClick="showPopup(this.href,600,1000);return(false);">حواله فروش مانده دار</a></li>';
		   
			echo'</ul>
		  </li>';
		  if (right(228)) 
		   echo'<li><a  href="report_mojody_rozane.php" onClick="showPopup(this.href,600,800);return(false);">مانده موجودی روزانه کالا</a></li>';
          if (right(229)) 
		   echo'<li><a  href="report_serizamani_mojody.php" onClick="showPopup(this.href,600,800);return(false);">سری زمانی موجودی کالا</a></li>';
		  if (right(230)) 		  
		   echo'<li><a href="report_ranandegan.php" onClick="showPopup(this.href,600,800);return(false);">گزارش رانندگان</a></li>';
		  if (right(231))  
		   echo'<li><a href="report_pardakht_paskeraye.php" onClick="showPopup(this.href,600,800);return(false);">گزارش پرداخت پسکرایه</a></li>';
		  if (right(232))  
		   echo'<li><a href="report_forushande.php" onClick="showPopup(this.href,600,800);return(false);">گزارش فروشندگان کالا</a></li>';
		  if (right(233))  
		   echo'<li><a href="report_mojody_mojaz.php" onClick="showPopup(this.href,600,800);return(false);">گزارش موجودی مجاز</a></li>';
		  if (right(234))   
		   echo'<li><a href="report_moshtary_varedati.php" onClick="showPopup(this.href,600,1000);return(false);">مصرف کننده نهایی کالای وارداتی</a></li>'; 
		 
		  // if (right(224))
		   // echo'<li><a target="my_frame">گزارش مدیریتی &raquo; </a>';
	        // echo'<ul>';
			 // if (right(225))
			  // echo'<li><a href="report_mojody_faravardeha.php" onClick="showPopup(this.href,600,900);return(false);">وضعیت فرآورده ها به تفکیک محل</a></li>';
		 	// echo'</ul>';
		   // echo'</li>';
		 echo'</ul>
	    </li>';	
	    if (right(240)) 
		echo'<li><a href="#" style="width:130px"><span class="fa fa-table" style="color:#FAFABB">&nbsp;</span> گزارشات مدیریتی</a>';
	     echo'<ul class="sub-menu">';
		  if (right(241))
		   echo'<li><a href="report_manager_mojody_faravardeha.php" onClick="showPopup(this.href,600,900);return(false);">وضعیت فرآورده ها به تفکیک محل</a></li>';		  
		   //echo'<li><a href="report_mojody_faravardeha.php" onClick="showPopup(this.href,600,900);return(false);">وضعیت فرآورده ها به تفکیک محل</a></li>';		  
		  if (right(242))
		   echo'<li><a href="report_manager_mojody_hforush.php" onClick="showPopup(this.href,600,900);return(false);">مانده موجودی وحواله فروش استانها</a></li>';		  
		  
		  if (right(243))
		   	echo'<li><a target="my_frame">مانده موجودی &raquo; </a>';
		     echo'<ul>';
		     if (right(715))
	          echo'<li><a href="report_manager_mojody_grkala.php" onClick="showPopup(this.href,600,900);return(false);">مانده موجودی کلی کالاها</a></li>';		   
			 if (right(716)) 
	          echo'<li><a href="report_manager_mojody_grkala_malekiyat.php" onClick="showPopup(this.href,600,900);return(false);">مانده موجودی کلی براساس مالکیت و تحت کلید (مرغ و گاو و گوسفند)</a></li>';		  
	         if (right(717))  
			  echo'<li><a href="report_manager_mojody_grkala_malekiyat_kol.php" onClick="showPopup(this.href,600,900);return(false);">مانده موجودی کلی براساس مالکیت و تحت کلید (مرغ و گوشت)</a></li>';		  
			 if (right(718))  
			  echo'<li><a href="report_manager_mojody_engheza_gusht.php" onClick="showPopup(this.href,600,900);return(false);">موجودی گوشت بر حسب تاریخ انقضا</a></li>';		  
			 if (right(719))   
			  echo'<li><a href="report_manager_mojody_engheza_morgh.php" onClick="showPopup(this.href,600,900);return(false);">موجودی مرغ بر حسب تاریخ انقضا</a></li>';		  
		     if (right(730))   
			  echo'<li><a href="report_manager_mahane_mojody_gr_middle.php" onClick="showPopup(this.href,600,900);return(false);">موجودی ماهانه (گروه کالا میانی)</a></li>';		  
			 if (right(731))    
			  echo'<li><a href="report_manager_mahane_mojody_gr_middle_minmax.php" onClick="showPopup(this.href,600,900);return(false);">موجودی ماهانه با حداقل و حداکثر(گروه کالا میانی)</a></li>';		  
		    
			echo'</ul>';
		   echo'</li>';
		  
		  if (right(244))
		   	echo'<li><a target="my_frame">سری زمانی &raquo; </a>';
		     echo'<ul>';
		     if (right(245))
		      echo'<li><a href="report_manager_mojodyhforush_rozane.php" onClick="showPopup(this.href,600,900);return(false);">مانده موجودی و حواله فروش روزانه کالا</a></li>';		  
		  	 if (right(246)) 
			  echo'<li><a href="report_manager_serizamani_mojody.php" onClick="showPopup(this.href,700,900);return(false);">موجودی به تفکیک سردخانه</a></li>';		   
		     if (right(246)) 
			  echo'<li><a href="report_manager_mojody_rozane.php" onClick="showPopup(this.href,700,900);return(false);">موجودی گروه کالا</a></li>';		   
		    
			echo'</ul>';
		   echo'</li>';
		  if (right(247))
		   echo'<li><a target="my_frame">اطلاعات عملکرد فرآورده ها &raquo; </a>';
		    echo'<ul>';
		     if (right(248))
		      echo'<li><a href="report_manager_amalkard_faravardeha.php" onClick="showPopup(this.href,600,900);return(false);">کلی</a></li>';		   
		     if (right(249))
			  echo'<li><a href="report_manager_amalkard_faravardeha_ostanha.php" onClick="showPopup(this.href,600,900);return(false);">به تفکیک استان</a></li>';		  
			 if (right(250)) 
		      echo'<li><a href="report_manager_amalkard_faravardeha_sardkhaneha.php" onClick="showPopup(this.href,600,900);return(false);">به تفکیک استان و سردخانه</a></li>';		  
		    echo'</ul>';
		   echo'</li>';
		  if (right(251))
			echo'<li><a target="my_frame">موجودی به تفکیک تاریخ تولید کالا &raquo; </a>
		          <ul>';
			if (right(252))
				echo'<li><a href="report_manager_mojody_tarikhtolid_kala.php" onClick="showPopup(this.href,600,900);return(false);">به تفکیک استان (یک کالا)</a></li>';		  
		    if (right(700))
				echo'<li><a href="report_manager_mojody_tarikhtolid_azkala.php" onClick="showPopup(this.href,600,900);return(false);">به تفکیک استان (چندین کالا)</a></li>';		  
			if (right(700))
				echo'<li><a href="report_manager_mojody_tarikhtolid_gr_middlekala.php" onClick="showPopup(this.href,600,900);return(false);">به تفکیک استان (گروه کالا میانی)</a></li>';		  
			if (right(253))
				echo'<li><a href="report_manager_mojodysardkhane_tarikhtolid_kala.php" onClick="showPopup(this.href,600,900);return(false);">به تفکیک استان و سردخانه</a></li>';		  
		     echo'</ul>
			</li>';
		  if (right(254))
		  	echo'<li><a target="my_frame">موجودی به تفکیک تاریخ تولید گروه کالا &raquo; </a>
		          <ul>';
		     if (right(255))
		      echo'<li><a href="report_manager_mojody_tarikhtolid_grkala.php" onClick="showPopup(this.href,600,900);return(false);">به تفکیک استان</a></li>';		  
		     if (right(256))
		      echo'<li><a href="report_manager_mojodysardkhane_tarikhtolid_grkala.php" onClick="showPopup(this.href,600,900);return(false);">به تفکیک استان و سردخانه</a></li>';		  
		    echo'</ul>';
		   echo'</li>';
          if (right(257)) 
		   echo'<li><a target="my_frame">مقادیر ارسالی استان ها &raquo; </a>';
		    echo '<ul>';
                 if (right(258)) 
	              echo'<li><a  href="report_manager_ersali_ostanha_kala.php" onClick="showPopup(this.href,600,1000);return(false);">به تفکیک کالا</a></li>';					 
				 if (right(259)) 
	              echo'<li><a  href="report_manager_ersali_ostanha_grkala.php" onClick="showPopup(this.href,600,1000);return(false);">به تفکیک گروه کالا</a></li>';					 
				 if (right(260))  
				  echo'<li><a href="report_manager_jabejae.php" onClick="showPopup(this.href,600,900);return(false);">جزئیات مقادیر ارسالی</a></li>';		  
		  	 echo'</ul>';
		   echo'</li>';
		   if (right(261)) 
		   echo'<li><a target="my_frame">مقادیر دریافتی استان ها &raquo; </a>';
		    echo '<ul>';
				 if (right(262)) 
	              echo'<li><a  href="report_manager_daryafti_ostanha_kala.php" onClick="showPopup(this.href,600,1000);return(false);">به تفکیک کالا</a></li>';					 
				 if (right(263)) 
	              echo'<li><a  href="report_manager_daryafti_ostanha_grkala.php" onClick="showPopup(this.href,600,1000);return(false);">به تفکیک گروه کالا</a></li>';					 
				 if (right(264))  
				  echo'<li><a href="report_manager_daryafti.php" onClick="showPopup(this.href,600,900);return(false);">جزئیات مقادیر دریافتی</a></li>';		  
		  	 echo'</ul>';
		   echo'</li>';
		  if (right(265)) 	    
			echo'<li><a target="my_frame">وضعیت موجودی سردخانه ها &raquo; </a>';
		    echo  '<ul>';
		     if (right(266))	
		      echo'<li><a href="report_manager_mojody.php" onClick="showPopup(this.href,600,900);return(false);">موجودی و ورودی و خروجی سردخانه ها</a></li>';		  
		     if (right(291))	
		      echo'<li><a href="report_manager_mojody_gomrok.php" onClick="showPopup(this.href,600,900);return(false);">موجودی و ورودی و خروجی سردخانه ها (تحت کلید گمرک)</a></li>';
			 if (right(267))	 
			  echo'<li><a href="report_manager_mojody_detail.php" onClick="showPopup(this.href,600,900);return(false);">موجودی سردخانه ها با جزئیات</a></li>';		  
			 if (right(292))	 
			  echo'<li><a href="report_manager_mojody_detail_gomrok.php" onClick="showPopup(this.href,600,900);return(false);">موجودی سردخانه ها با جزئیات (تحت کلید گمرک)</a></li>';		  
			 if (right(268))	 
			  echo'<li><a href="report_manager_mojody_mojaz_ostan.php" onClick="showPopup(this.href,700,900);return(false);">موجودی مجاز استان ها</a></li>';		  
			 if (right(269))	 
			  echo'<li><a href="report_manager_mojody_mojaz.php" onClick="showPopup(this.href,700,900);return(false);">موجودی مجاز سردخانه ها با جزئیات</a></li>';		  
			 if (right(287))	 
			  echo'<li><a href="report_manager_max_mojody.php" onClick="showPopup(this.href,700,900);return(false);">تعیین وضعیت زمان و مقدار ورود و خروج</a></li>';		  
			 echo'</ul>';
		   echo'</li>';
		  if (right(270)) 	    
			echo'<li><a target="my_frame">مجوزهای جابه جایی &raquo; </a>';
		    echo  '<ul>';
		     if (right(271))	
		      echo'<li><a href="report_manager_ersali_movaghat.php" onClick="showPopup(this.href,600,900);return(false);">به سردخانه موقت</a></li>';		  
		     if (right(272))	 
			  echo'<li><a href="report_manager_ersali_khosusi.php" onClick="showPopup(this.href,600,900);return(false);">جایگزینی با بخش خصوصی</a></li>';		  
			 echo'</ul>';
		   echo'</li>';
		   if (right(273)) 	    
			echo'<li><a target="my_frame">گزارش نظارت و بازرسی &raquo; </a>';
		    echo  '<ul>';
		     if (right(288))	
		      echo'<li><a href="report_manager_nezarat.php" onClick="showPopup(this.href,600,900);return(false);">نظارت و بازرسی حواله ها</a></li>';		  
		     if (right(289))	 
			  echo'<li><a href="report_manager_tamin.php" onClick="showPopup(this.href,600,900);return(false);"> تأمین براساس خروجی مجوز فروش</a></li>';		  
			 if (right(290))	 
			  echo'<li><a href="report_manager_nezarat_jabejae.php" onClick="showPopup(this.href,600,900);return(false);">نظارت و بازرسی جابه جایی</a></li>';		  
			  //echo'<li><a href="report_manager_nezarat_jabejae.php" onClick="showPopup(this.href,600,900);return(false);">حواله های جایگزینی با بخش خصوصی</a></li>';		  
			 echo'</ul>';
		  echo'</li>';
		  if (right(274))
		   echo'<li><a href="report_manager_modat_tahvil_kala.php" onClick="showPopup(this.href,600,900);return(false);">مدت زمان تحویل کالا</a></li>';		  
		  //if (SuperUser())
		   //echo'<li><a href="report_manager_voroody_khorooji.php" onClick="showPopup(this.href,700,900);return(false);">گزارش ورودی و خروجی سردخانه ها</a></li>';		   
		  if (right(275))
		   echo'<li><a href="report_manager_anbargardani.php" onClick="showPopup(this.href,700,900);return(false);">گزارش انبارگردانی</a></li>';		   

		  if (right(276)) 	    
			echo'<li><a target="my_frame">اطلاعات فرآورده ها مخصوص بیمه &raquo; </a>';
		    echo  '<ul>';
		     if (right(713))	
		    echo'<li><a href="report_manager_bime.php" onClick="showPopup(this.href,700,900);return(false);">اطلاعات فرآورده ها مخصوص بیمه- سرجمع گوشت</a></li>';		   
		     if (right(714))	 
		    echo'<li><a href="report_manager_bime_det.php" onClick="showPopup(this.href,700,900);return(false);">اطلاعات فرآورده ها مخصوص بیمه-تفکیک گوشت</a></li>';		   
			 echo'</ul>';
		  echo'</li>';
		  
		  if (right(277)) 
		   echo'<li><a  href="report_manager_forush_mandedar.php" onClick="showPopup(this.href,600,1000);return(false);">حواله فروش مانده دار سردخانه ها</a></li>';
		  if (right(278)) 	    
			echo'<li><a target="my_frame">گزارش ظرفیت سردخانه ها &raquo; </a>';
		    echo  '<ul>';
		     if (right(288))	
		    echo'<li><a  href="report_manager_zarfiyat.php" onClick="showPopup(this.href,600,1000);return(false);">ظرفیت قراردادی و موجودی سردخانه ها</a></li>';
		     if (right(289))	 
		    echo'<li><a  href="report_manager_zarfiyat_baqimande.php" onClick="showPopup(this.href,600,1000);return(false);">ظرفیت ، درصد بهره وری و فضای باقیمانده</a></li>';
			 echo'</ul>';
		  echo'</li>';
		  if (right(721)) 	    
			echo'<li><a target="my_frame">خرید/فروش قطعی به تفکیک ماه &raquo; </a>';
		    echo  '<ul>';
		     if (right(722))	
		    echo'<li><a  href="report_manager_kharid_forush_grkala.php" onClick="showPopup(this.href,600,1000);return(false);">گروه کالای اصلی</a></li>';
		     if (right(723))	 
		    echo'<li><a  href="report_manager_kharid_forush_gr_middlekala.php" onClick="showPopup(this.href,600,1000);return(false);">گروه کالای میانی</a></li>';
			 echo'</ul>';
		  echo'</li>';
		  if (right(724)) 	    
			echo'<li><a target="my_frame">خرید/فروش ماهانه &raquo; </a>';
		    echo  '<ul>';
		     if (right(725))	
		      echo'<li><a  href="report_manager_mahane_gr_top.php" onClick="showPopup(this.href,600,1000);return(false);">گروه کالای اصلی</a></li>';
		     if (right(726))	 
		      echo'<li><a  href="report_manager_mahane_gr_middle.php" onClick="showPopup(this.href,600,1000);return(false);">گروه کالای میانی</a></li>';
			 if (right(727))	 
		      echo'<li><a  href="report_manager_mahane_kala.php" onClick="showPopup(this.href,600,1000);return(false);">کالا</a></li>';
			 
			 echo'</ul>';
		  echo'</li>';			  

          if (right(701)) 
	       echo'<li><a  href="report_manager_ersali_vs_tahvily.php" onClick="showPopup(this.href,600,1000);return(false);">مقایسه مقادیر ارسالی و تحویلی </a></li>';					 
		  if (right(710)) 
	       echo'<li><a  href="report_manager_amalkard_rozane_ostanha.php" onClick="showPopup(this.href,600,1000);return(false);">اطلاعات فروش قطعی،ارسالی به استانها و حواله فروش </a></li>';					 
		  if (right(720)) 
	       echo'<li><a  href="report_manager_tozie_faravarde.php" onClick="showPopup(this.href,600,1000);return(false);">گزارش آمار توزیع فرآورده ها </a></li>';					   
		  if (right(721)) 
		   echo'<li><a  href="report_manager_oftokasry.php" onClick="showPopup(this.href,600,1000);return(false);"> طرح در کمیسیون افت و کسری</a></li>';
		  
		  //if (right(710)) 		  	
		   //echo'<li><a  href="report_manager_mojavez_forush.php" onClick="showPopup(this.href,600,1000);return(false);">فرآورده بارگیری شده براساس شماره مجوز</a></li>';

		  echo'
		  </ul>
	    </li>';
	    if (right(900))
		echo'<li><a href="#"><span class="fa fa-solid fa-clipboard" style="color:#FAFABB">&nbsp;</span> گزارش فروش</a>';
	     echo'<ul class="sub-menu">';
	      if (right(901)) 
		   echo'<li><a  href="report_manager_forush.php" onClick="showPopup(this.href,600,1000);return(false);">گزارش فروش نهاده ها و فرآورده ها</a></li>';
		 echo'
		 </ul>
	    </li>';	
		if (right(280))
		echo'<li><a href="#"><span class="fa fa-bar-chart fa-fw" style="color:#FAFABB">&nbsp;</span> نمودار</a>';
	     echo'<ul class="sub-menu">';
	      if (right(281)) 
		   echo'<li><a  href="chart_manager_zarfiyat.php" onClick="showPopup(this.href,600,1000);return(false);">ظرفیت اسمی و موجودی سردخانه ها</a></li>';
	      if (right(281)) 
		   echo'<li><a  href="chart_manager_zarfiyat_gh.php" onClick="showPopup(this.href,600,1000);return(false);">ظرفیت قراردادی و موجودی سردخانه ها</a></li>';
		  if (right(282)) 
		    echo'<li><a  href="chart_manager_col_grkala.php" onClick="showPopup(this.href,600,1000);return(false);">موجودی گروه کالاهای هر استان</a></li>';
		  if (right(283)) 
		    echo'<li><a  href="chart_manager_pie_grkala.php" onClick="showPopup(this.href,600,1000);return(false);">درصد موجودی گروه کالا در استان</a></li>';
		  if (right(284)) 
		    echo'<li><a  href="map_manager_mojody_grkala.php" onClick="showPopup(this.href,600,1000);return(false);">نقشه مانده موجودی استان ها</a></li>';

		 echo'
		 </ul>
	    </li>';	
	    if (right(300)) 
		echo'<li><a href="#"><span class="fa fa-cog fa-fw" style="color:#FAFABB">&nbsp;</span> مديريت</a>';
	     echo'<ul class="sub-menu">';
		  if (right(301))
		   echo'<li><a target="my_frame" href="years.php">تعریف سال</a></li>';
		  if (right(305))
		   echo'<li><a target="my_frame">مديريت کاربران &raquo; </a>';
		    echo'<ul>';
		 	if (right(306))
			 echo'<li><a style="width:170px" target="my_frame" href="roles.php">تعیین نقش و حدود دسترسی </a></li>';
			if (right(312))
			 echo'<li><a style="width:170px" target="my_frame" href="users.php">کاربران</a></li>';
		    echo'</ul>';
		   echo'</li>';
		  if (right(319))
		  echo'<li><a target="my_frame">امضا کنندگان اسناد &raquo; </a>';
		   echo'<ul>';
		 	if (right(320))
			 echo'<li><a style="width:170px" target="my_frame" href="dpt.php">پست های سازمانی</a></li>';
		 	if (right(324))
			 echo'<li><a style="width:170px" target="my_frame" href="types.php">تعیین انواع فرم و امضا کنندگان</a></li>';
		   echo'</ul>';
		  echo'</li>';		  
		  if (right(333))
		   echo'<li><a target="my_frame" href="noe_amaliyat.php">جدول نوع عملیات</a></li>';
		  if (right(337))
		   echo'<li><a target="my_frame" href="bedehkar_bestankar.php">جدول کد بدهکار و بستانکار</a></li>';
		  if (SuperUser())
		   echo'<li><a target="my_frame" href="minimum_mojody.php">تعیین حداقل موجودی</a></li>';
		  if (right(341))
		   echo'<li><a target="my_frame" href="saghf_kharid.php">تعیین سقف خرید کالا</a></li>';
		  if (SuperUser())
		   echo'<li><a  href="report_log.php" onClick="showPopup(this.href,600,1000);return(false);">گزارش ثبت اطلاعات</a></li>';
		  if (right(345))	
		   echo'<li><a target="my_frame">سند حسابداری وارده به سردخانه &raquo; </a>';
			echo'<ul>';
		    if (right(346))
			 echo'<li><a style="width:150px" target="my_frame" href="sanad_varede_date.php">تاریخ رسید</a></li>';
		    if (right(347))
			 echo'<li><a style="width:150px" target="my_frame" href="sanad_varede_shomare.php">شماره رسید </a></li>';
 		    if (right(348))
			 echo'<li><a style="width:150px" target="my_frame" href="sanad_varede_kharid.php">خرید </a></li>'; 		 
			echo'</ul>';
		   echo'</li>';
		  if (right(349))	
		   echo'<li><a target="my_frame">سند حسابداری صادره از سردخانه &raquo; </a>';
			echo'<ul>';
			if (right(350))
			 echo'<li><a style="width:150px" target="my_frame" href="sanad_sadere_ghatee.php">حواله های قطعی </a></li>';
			if (right(351))
			 echo'<li><a style="width:150px" target="my_frame" href="sanad_sadere_mandedar.php">حواله های مانده دار </a></li>';
			if (right(352))
			 echo'<li><a style="width:150px" target="my_frame" href="sanad_sadere_jabejae.php">حواله های  جابه جایی</a></li>';
	        if (right(353))
			 echo'<li><a style="width:150px" target="my_frame" href="sanad_sadere_sh_forush.php">شماره حواله فروش</a></li>';
		    if (right(354))
			 echo'<li><a style="width:150px" target="my_frame" href="sanad_sadere_sh_jabejae.php">شماره مجوز جابه جایی</a></li>';		 
			echo'</ul>';
		   echo'</li>';
		   if (right(360)) 
		   echo'<li><a target="my_frame">وضعیت ارسال به سامانه جامع انبارها &raquo; </a>';
		    echo '<ul>';
			     if (right(361)) 
		          echo'<li><a href="report_manager_resid.php" onClick="showPopup(this.href,600,900);return(false);">وضعیت رسیدها</a></li>';		  
				 if (right(362)) 
		          echo'<li><a href="report_manager_havale.php" onClick="showPopup(this.href,600,1000);return(false);">وضعیت حواله ها</a></li>'; 
		  	 echo'</ul>';
		   echo'</li>';
		  //if (SuperUser())
            //echo'<li><a target="my_frame" href="manager.php">manager</a></li><li><a target="my_frame" href="emza_resid_ostan.php">emza_resid_ostan</a></li><li><a target="my_frame" href="emza_havale_ostan.php">emza_havale_ostan</a></li>';
		  // if (SuperUser())
		   // echo'<li><a target="my_frame" href="owner.php">تعریف عنوان دارنده اصلی سیستم</a></li>'; 		   
		  if (SuperUser())
		  {            
	        // echo'<li><a target="my_frame">انتقال به وب سرویس وزرات جهاد &raquo; </a>';
			 // echo'<ul>';
			  // echo'<li><a style="width:150px" target="my_frame" href="transfer_resid_webservice.php">رسید</a></li>';
              // echo'<li><a style="width:150px" target="my_frame" href="transfer_havale_webservice.php">حواله</a></li>';
              // echo'<li><a style="width:150px" target="my_frame" href="transfer_tadil_webservice.php">تعدیل</a></li>';
			 // echo'</ul>';
		    // echo'</li>';
			// echo'<li><a target="my_frame">انتقال به وب سرویس وزرات جهاد نسخه جدید &raquo; </a>';
			 // echo'<ul>';
			  // echo'<li><a style="width:150px" target="my_frame" href="transfer_resid_webservice111.php">رسید</a></li>';
              // echo'<li><a style="width:150px" target="my_frame" href="transfer_havale_webservice111.php">حواله</a></li>';
              // echo'<li><a style="width:150px" target="my_frame" href="transfer_tadil_webservice111.php">تعدیل</a></li>';
			 // echo'</ul>';
		    // echo'</li>';
			echo'<li><a target="my_frame">انتقال به وب سرویس خوشه های کشاورزی &raquo; </a>';
			 echo'<ul>';
			  echo'<li><a style="width:150px" target="my_frame" href="transfer_resid_new.php">رسید</a></li>';
			  echo'<li><a style="width:150px" target="my_frame" href="transfer_resid_new_anbar.php">رسید (انبار)</a></li>';
              echo'<li><a style="width:150px" target="my_frame" href="transfer_havale_new.php">حواله</a></li>';
              echo'<li><a style="width:150px" target="my_frame" href="transfer_havale_new_anbar.php">حواله (انبار)</a></li>';
			  echo'<li><a style="width:150px" target="my_frame" href="transfer_active_warehouse.php">فعال کردن واحد</a></li>';
              echo'<li><a style="width:150px" target="my_frame" href="transfer_deactive_warehouse.php">غیرفعال کردن واحد</a></li>';
			 echo'</ul>';
		    echo'</li>';
			// echo'<li><a target="my_frame">انتقال به وب سرویس وزرات صمت &raquo; </a>';
			 // echo'<ul>';
			  // echo'<li><a style="width:150px" target="my_frame" href="transfer_resid_webservice_v2.php">رسید</a></li>';
              // echo'<li><a style="width:150px" target="my_frame" href="transfer_havale_webservice_v2.php">حواله</a></li>';
              // echo'<li><a style="width:150px" target="my_frame" href="transfer_tadil_webservice_v2.php">تعدیل</a></li>';
			 // echo'</ul>';
		    // echo'</li>';
			echo'<li><a target="my_frame">انتقال به وب سرویس وزرات صمت (دوم)  &raquo; </a>';
			 echo'<ul>';
		      echo'<li><a target="my_frame" href="transfer_enteghal_webservice.php">سرویس اظهار انتقال مالکیت و مکان</a></li>';
              echo'<li><a target="my_frame" href="transfer_resid_webservice_v3.php">سرویس اظهار ورود کالا</a></li>';
			 echo'</ul>';
		    echo'</li>';
			
			echo'<li><a target="my_frame">انتقال موجودی به سال بعد &raquo; </a>';
			 echo'<ul>';
			  echo'<li><a style="width:150px" target="my_frame" href="transfer_mojody.php">کل سیستم</a></li>';
              echo'<li><a style="width:150px" target="my_frame" href="transfer_mojody_ostan.php">استان</a></li>';
              echo'<li><a style="width:150px" target="my_frame" href="transfer_mojody_anbar.php">سردخانه</a></li>';
			 echo'</ul>';
		    echo'</li>';
		    echo'<li><a target="my_frame">اصلاح موجودی &raquo; </a>';
			 echo'<ul>';
			  echo'<li><a style="width:150px" target="my_frame" href="transfer_mojody_edit.php">کل سیستم</a></li>';
              echo'<li><a style="width:150px" target="my_frame" href="transfer_mojody_ostan_edit.php">استان</a></li>';
              echo'<li><a style="width:150px" target="my_frame" href="transfer_mojody_anbar_edit.php">سردخانه</a></li>';
			 echo'</ul>';
		    echo'</li>';
		    echo'<li><a target="my_frame" href="status_webservice.php">فعال/غیرفعال کردن وب سرویس</a></li>';
		  } 
		   
		   // if (SuperUser())	
            // {echo'<li><a target="my_frame">اصلاح کد تولید کننده&raquo; </a>';
			// echo'<ul>';
			// echo'<li><a target="my_frame" href="change_code_tolidkonande_moj.php">mojody_kala</a></li>';
			// echo'<li><a target="my_frame" href="change_code_tolidkonande_resid_d.php">resid_detail</a></li>';
			// echo'<li><a target="my_frame" href="change_code_tolidkonande_resid_k_d.php">resid_kala_detail</a></li>';
			// echo'<li><a target="my_frame" href="change_code_tolidkonande_havale_d.php">havale_detail_detail</a></li>';
			// echo'<li><a target="my_frame" href="change_code_tolidkonande_tadil.php">tadil_mojody</a></li>';
			// echo'</ul>';
		   // echo'</li>';
		   // }
		   // if (SuperUser())
		   	// echo'<li><a target="my_frame" href="change_code_karton_moj.php">اصلاح کد کارتن</a></li>';           if (SuperUser())
		   
		   //if (SuperUser())
            //echo'<li><a target="my_frame" href="edit_code_customer.php">اصلاح کد مشتری در حواله</a></li>';  
			 //echo'<li><a target="my_frame" href="emza_resid_ostan.php">emza_resid_ostan</a></li>';
			 //echo'<li><a target="my_frame" href="emza_havale_ostan.php">emza_havale_ostan</a></li>';
		    //if (SuperUser())
            // echo'<li><a target="my_frame" href="transfer_mojody_ostan_edit.php">اصلاح موجودی (استان)</a></li>';
		   // if (SuperUser())
            // echo'<li><a target="my_frame" href="sabt_resid.php">sabt nahayi Resid</a></li>';
		   // if (SuperUser())
            // echo'<li><a target="my_frame" href="sabt_havale.php">sabt nahayi Havale</a></li>';

		  // if (SuperUser())
           // echo'<li><a target="my_frame" href="ebtal_mandejabejae.php">ابطال مانده مجوزجابه جایی</a></li>';
		  
		  //if (SuperUser())
           //echo'<li><a target="my_frame" href="edit_bastebandy.php">اصلاح کد بسته بندی</a></li>'; 
		   
		   //echo'<li><a target="my_frame" href="collate.php">تغییر collate </a></li>';
		 echo'
		 </ul>
	    </li>';	
		if (right(400)) 
		  echo'<li><a href="#"><span class="fa fa-shopping-cart fa-fw" style="color:#FAFABB">&nbsp;</span> خرید</a>';
	     echo'<ul class="sub-menu">';
		  if (right(401))
		   echo'<li><a target="my_frame" href="eblagh_kharid.php">ابلاغ وزیر/ستاد تنظیم بازار/هیأت مدیره</a></li>';		  
		  if (right(406))
		   echo'<li><a target="my_frame" href="sahmiebandy_kharid.php">سهمیه بندی خرید</a></li>';	
		  //if (right(411))
		   //echo'<li><a target="my_frame" href="forushande.php">فروشندگان</a></li>';		  
		  if (right(416))
		   echo'<li><a target="my_frame" href="gharardad_kharid.php">قرارداد خرید</a></li>';
		  if (right(446))
		   echo'<li><a target="my_frame" href="pardakhti_list.php">لیست درخواست پرداختی ها</a></li>';
		  
		  if (right(450))	
		   echo'<li><a target="my_frame">گزارش قراردادها &raquo; </a>';
			echo'<ul>';
		    if (right(522))
		     echo'<li><a  style="width:180px" href="report_gharardad.php" onClick="showPopup(this.href,600,900);return(false);">قراردادها براساس تاریخ رسید</a></li>';		   
		    if (right(523))
		     echo'<li><a  style="width:180px" href="report_gharardad_with_date.php" onClick="showPopup(this.href,600,900);return(false);">قراردادها براساس تاریخ قرارداد</a></li>';		   
			echo'</ul>';
		   echo'</li>';
		  
		  if (right(451))
		   echo'<li><a href="report_kharid_ostan.php" onClick="showPopup(this.href,600,900);return(false);">گزارش خرید</a></li>';		   
		  if (right(481))
		   echo'<li><a href="report_kharid_ostan_tajamoee.php" onClick="showPopup(this.href,600,900);return(false);">گزارش خرید تجمعی</a></li>';		   
		  if (right(482))
		   echo'<li><a href="report_kharid_ostan_tajamoee_dv.php" onClick="showPopup(this.href,600,900);return(false);">گزارش خرید تجمعی به تفکیک داخلی وارداتی</a></li>';		   
		  if (right(480))
		   echo'<li><a href="report_amalkard_kharid.php" onClick="showPopup(this.href,600,900);return(false);">گزارش عملکرد خرید</a></li>';		   
		  if (right(452))
		   echo'<li><a href="report_gharardad_detail.php" onClick="showPopup(this.href,600,900);return(false);">گزارش قراردادها با آنالیز </a></li>';		   
		  if (right(453))
		   echo'<li><a href="report_gharardad_detail_tajamoee.php" onClick="showPopup(this.href,600,900);return(false);">گزارش تجمعی قراردادها </a></li>';		   
		  if (right(454))
		   echo'<li><a href="report_total_tajamoee.php" onClick="showPopup(this.href,600,900);return(false);">گزارش تجمعی قراردادها یکپارچه </a></li>';		   
		  if (right(455))
		   echo'<li><a href="report_kharid_to_managing_director.php" onClick="showPopup(this.href,600,900);return(false);">گزارش خرید طی دوره با محاسبه مابه التفاوت</a></li>';		   
		  if (right(470))
		   echo'<li><a href="report_manager_kharid_rozane_morgh.php" onClick="showPopup(this.href,600,900);return(false);">گزارش خرید روزانه مرغ داخلی</a></li>';		   
		  //if (right(471))
		   //echo'<li><a href="report_kharid_mah.php" onClick="showPopup(this.href,600,900);return(false);">گزارش خرید ماه</a></li>';		   
		  
		  
		  //if (right(454))
		   //echo'<li><a href="report_kharid_to_managing_director.php" onClick="showPopup(this.href,600,900);return(false);">گزارش خرید طی دوره </a></li>';		   

		  //if (right(455))
		   //echo'<li><a href="report_edare_daraee.php" onClick="showPopup(this.href,600,900);return(false);">گزارش ماده 169 اداره دارایی</a></li>';		   

		 // if (right(426))
		  // echo'<li><a href="report_gharardad2.php" onClick="showPopup(this.href,600,900);return(false);">گزارش قراردادها 2</a></li>';		   
		  //if (right(426))
		   //echo'<li><a href="report_tajamoe_gharardad.php" onClick="showPopup(this.href,600,900);return(false);">گزارش تجمعی قراردادها</a></li>';		   
		  echo'
		 </ul>
	    </li>';
	    if (right(510))
		echo'<li><a href="#"><span class="fa fa-bar-chart fa-fw" style="color:#FAFABB">&nbsp;</span> کنترل کیفی</a>';
	     echo'<ul class="sub-menu">';
	      if (right(511))
		   echo' <li><a target="my_frame" href="keyfiyat_zakhayer.php">پایش کیفیت ذخایر فرآورده ها</a></li>';
	      if (right(521))
		   echo' <li><a href="report_manager_keyfiyat_zakhayer.php" onClick="showPopup(this.href,600,900);return(false);">گزارش پایش کیفیت ذخایر فرآورده ها </a></li>';		   
         echo'
		 </ul>
	    </li>';	
		if (right(500)) echo'<li><a target="my_frame" href="dashboard.php"><span class="fa fa-tachometer fa-fw" style="color:#FAFABB">&nbsp;</span> داشبورد</a></li>';		
	    echo'
	   </ul>     
      </div>
	  <!--پايان بلاک منوها-->	
     </td>
    </tr>	 
   </table>
  </div>
 </div> 
 <!-- پايان هدر صفحه--> 
 <!-- مرکز صفحه-->
 <div id="contentCenter2">
  <iframe align="center" width="100%" height="100%" name="my_frame" src="my_frame.php" frameborder="0"></iframe>   
 </div>
 <!--پايان مرکز صفحه -->
 <!-- فوتر-->
 <div id="footer2">
  <div class="user">
   <div style="position:absolute;top:1px;right:10px;"><img src="images/user_sticker.png" style="width:30px;height:30px;"/></div>
   <div style="position:absolute;top:6px;right:50px;">کاربر : '.$mtuserNAME.'</div>
  </div> 
   <div style="position:absolute;top:5px;right:20%;">
    <table>
	 <tr>';
	 /****اگر سوپریوزر باشد****/
	  if (SuperUser())
	  {echo'
           <td><span style="font-weight:bold;font-size:13px;"> استان : </span> '.listbox_ostan("mtglobal_code_ostan","$mt_gl_code_ostan","code_ostan","name_ostan","ostan","1=1 ORDER BY ostan.name_ostan ASC","onChange='IndexForm.submit()' class='text2'").'&nbsp;&nbsp;</td>';	  	  	    
		   //وضعیت نمایش انبار
		   if(($mtglobal_code_ostan)and($mt_gl_code_ostan!=-1))      echo'<td><span style="font-weight:bold;font-size:13px;"> سردخانه : </span>'.listbox_anbar("mtglobal_code_sardkhane",$mt_gl_code_anbar,"code_anbar","name_anbar","list_sardkhane","1=1 and code_ostan=$mtglobal_code_ostan ORDER BY list_sardkhane.name_anbar ASC","onChange='IndexForm.submit()' class='text2'").'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>';
		   else if(($mtglobal_code_ostan)and($mt_gl_code_ostan==-1)) echo'<td><span style="font-weight:bold;font-size:13px;"> سردخانه : </span><select class="text2"><option value=-1>همه انبارها</option></select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>';
	       else                                                 echo'<td><span style="font-weight:bold;font-size:13px;"> سردخانه : </span><select class="text2"><option value=-1>همه انبارها</option></select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>';	   	  
		   //<td><span style="font-weight:bold;"> استان : </span> '.listbox("mtglobal_code_ostan","$mt_gl_code_ostan","code_ostan","name_ostan","ostan","1=1 ORDER BY ostan.name_ostan ASC","onChange='IndexForm.submit()' class='text4' style='font-weight:bold;'").'&nbsp;&nbsp;</td>';	  	  	    
		   //if($mtglobal_code_ostan) echo'<td><span style="font-weight:bold;"> انبار : </span>'.listbox("mtglobal_code_sardkhane",$mt_gl_code_anbar,"code_anbar","name_anbar","list_sardkhane","1=1 and code_ostan=$mtglobal_code_ostan  ORDER BY list_sardkhane.name_anbar ASC","onChange='IndexForm.submit()' class='text4' style='font-weight:bold;'").'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>';
	       //else  echo'<td><span style="font-weight:bold;"> انبار : </span><select name="mtglobal_code_sardkhane" id="code_anbar" class="text4" ><option value="0">انتخاب کنيد</option></select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>';	  	    
	  }
	  else
	  {
	   //فقط سردخانه های فعال
	   IF($_SESSION['mt_show_anbar']==0) $showCondition=" AND activate=1";
	   /****اگر کاربر مدیرگزارش تجمعی باشد****/
	   if($_SESSION['mt_role']==1)
	   {echo'
	       <td><span style="font-weight:bold;font-size:13px;"> استان : </span> '.listbox_ostan("mtglobal_code_ostan","$mt_gl_code_ostan","code_ostan","name_ostan","ostan","1=1 ORDER BY ostan.name_ostan ASC","onChange='IndexForm.submit()' class='text2'").'&nbsp;&nbsp;</td>';	  	  	    
		   //وضعیت نمایش انبار
		   if(($mtglobal_code_ostan)and($mt_gl_code_ostan!=-1))      echo'<td><span style="font-weight:bold;font-size:13px;"> سردخانه : </span>'.listbox_anbar("mtglobal_code_sardkhane",$mt_gl_code_anbar,"code_anbar","name_anbar","list_sardkhane","1=1 and code_ostan=$mtglobal_code_ostan $showCondition ORDER BY list_sardkhane.name_anbar ASC","onChange='IndexForm.submit()' class='text2'").'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>';
		   else if(($mtglobal_code_ostan)and($mt_gl_code_ostan==-1)) echo'<td><span style="font-weight:bold;font-size:13px;"> سردخانه : </span><select class="text2"><option value=-1>همه انبارها</option></select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>';
	       else                                                 echo'<td><span style="font-weight:bold;font-size:13px;"> سردخانه : </span><select class="text2"><option value=-1>همه انبارها</option></select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>';
	   }
	   /**** اگر تیک همه استانها خورده باشد****/
	   else if($_SESSION['mt_all_ostan']==1)
	   {echo'
	   	   <td><span style="font-weight:bold;font-size:13px;"> استان : </span> '.listbox_ostan("mtglobal_code_ostan","$mt_gl_code_ostan","code_ostan","name_ostan","ostan","1=1 ORDER BY ostan.name_ostan ASC","onChange='IndexForm.submit()' class='text2'").'&nbsp;&nbsp;</td>';	  	  	    
		   //وضعیت نمایش انبار
		   if(($mtglobal_code_ostan)and($mt_gl_code_ostan!=-1))      echo'<td><span style="font-weight:bold;font-size:13px;"> سردخانه : </span>'.listbox_anbar("mtglobal_code_sardkhane",$mt_gl_code_anbar,"code_anbar","name_anbar","list_sardkhane","1=1 and code_ostan=$mtglobal_code_ostan $showCondition ORDER BY list_sardkhane.name_anbar ASC","onChange='IndexForm.submit()' class='text2'").'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>';
		   else if(($mtglobal_code_ostan)and($mt_gl_code_ostan==-1)) echo'<td><span style="font-weight:bold;font-size:13px;"> سردخانه : </span><select class="text4" style="font-size:14px;"><option value=-1>همه انبارها</option></select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>';
	       else                                                 echo'<td><span style="font-weight:bold;font-size:13px;"> سردخانه : </span>'.listboxMe("mtglobal_code_sardkhane",$mt_gl_code_anbar,"user_ostan_anbar.code_anbar","name_anbar","user_ostan_anbar INNER JOIN list_sardkhane ON user_ostan_anbar.code_ostan=list_sardkhane.code_ostan AND user_ostan_anbar.code_anbar=list_sardkhane.code_anbar INNER JOIN users ON users.user_id=user_ostan_anbar.user_id","1=1 and user_ostan_anbar.user_id='".$_SESSION['mt_user_id']."' and user_ostan_anbar.code_ostan='$mt_gl_code_ostan' $showCondition ORDER BY anbar_default DESC,name_anbar ASC","onChange='IndexForm.submit()' class='text2'").'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>';     
	       //else                                                 echo'<td><span style="font-weight:bold;font-size:13px;"> سردخانه : </span>'.listboxMe("mtglobal_code_sardkhane",$mt_gl_code_anbar,"code_anbar","(select name_anbar from list_sardkhane where code_anbar=user_ostan_anbar.code_anbar and code_ostan='$mt_gl_code_ostan ORDER BY list_sardkhane.name_anbar ASC')","user_ostan_anbar ","1=1 and user_id='".$_SESSION['mt_user_id']."' and code_ostan='$mt_gl_code_ostan'","onChange='IndexForm.submit()' class='text2'").'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>';     
	   }
	   /**** کاربر معمولی ****/
	   else
	   {
	    echo'<td><span style="font-weight:bold;font-size:13px;"> استان : </span><span style="font-weight:bold;color:#000;">'.$mt_gl_name_ostan.'</span>&nbsp;&nbsp;</td>
	         <td><span style="font-weight:bold;font-size:13px;"> سردخانه : </span>'.listboxMe("mtglobal_code_sardkhane",$mt_gl_code_anbar,"user_ostan_anbar.code_anbar","name_anbar","user_ostan_anbar INNER JOIN list_sardkhane ON user_ostan_anbar.code_ostan=list_sardkhane.code_ostan AND user_ostan_anbar.code_anbar=list_sardkhane.code_anbar","1=1 and user_id='".$_SESSION['mt_user_id']."' $showCondition and user_ostan_anbar.code_ostan='$mt_gl_code_ostan'  ORDER BY name_anbar ASC","onChange='IndexForm.submit()' class='text2'").'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
			 <!--<td><span style="font-weight:bold;font-size:13px;"> سردخانه : </span>'.listboxMe("mtglobal_code_sardkhane",$mt_gl_code_anbar,"code_anbar","(select name_anbar from list_sardkhane where code_anbar=user_ostan_anbar.code_anbar and code_ostan='$mt_gl_code_ostan $showCondition ORDER BY list_sardkhane.name_anbar ASC')","user_ostan_anbar","1=1 and user_id='".$_SESSION['mt_user_id']."' and code_ostan='$mt_gl_code_ostan'","onChange='IndexForm.submit()' class='text2'").'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>--> ';
	   }	   
	  }
	  echo'<td><span style="font-weight:bold;font-size:13px;"> سال : </span>'.listbox("mtact_yr",$mtActiveYear,"year","year","mt_docs","1=1 ORDER BY year","onChange='IndexForm.submit()' class='text2'","").'</td>';
	echo'</tr>
	</table>
   </div>	 
   <div  style="background-color:#888">
	<div style="position:absolute;top:1px;left:10px;"><img src="images/calendar.png" style="width:23px;height:23px;"/></div>
	<div style="position:absolute;top:6px;left:40px;color:black;">'.$fdow_[Date("w")].'&nbsp;'.$today.'</div>
   </div>
   <div style="">
	<div style="position:absolute;top:25px;left:10px;"><img src="images/clock.png" style="width:18px;height:18px;"/></div>
	<div style="position:absolute;top:25px;left:40px;color:black;"> ساعت : <span id="timer"></span></div>
   </div>    
 </div>
 <!-- پايان فوتر-->
</div>
<!--پايان قالب اصلي -->
 </div> 
</form>
</body>
</html>';
?>