<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="mojody_kala.php";
$TableName="mojody_kala";
$logtime=date('H:i:s');
$ins_message='';
$right_ins=0;$right_edt=0;$right_del=0;
if (right(132)) $right_ins=1;
if (right(133)) $right_edt=1;
if (right(134)) $right_del=1;
echo'
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>موجودی کالا</title>
<link href="styles.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="functions.js"></script>
        <!--<link rel="stylesheet" href="js-persian-cal.css">
            <script type="text/javascript" src="js-persian-cal.min.js"></script>-->

<link type="text/css" href="styles/jquery-ui-1.8.14.css" rel="stylesheet"/>
<script type="text/javascript" src="scripts/jquery-1.6.2.min.js"></script>
<script type="text/javascript">
<!-- نوع پرداخت--><!--dont use-->
 $( document ).ready(function() {
 $("[name=noe_mahmule]").bind("change", function () {
    if($(this).val() == 1) {
	   $("#milady").hide("slow");
       $("#shamsi").show("slow");
    } 
	if($(this).val() == 2){
	   $("#shamsi").hide("slow");
       $("#milady").show("slow");
    }
	if($(this).val() == 0){
	   $("#milady").hide("slow");
	   $("#shamsi").hide("slow");
	}
  });
 });
function getZiranbar(noe_zir_anbar) <!-- تعویض زیرانبار با انتخاب نوع زیر انبار-->
{
   $("#loading").fadeIn("fast");  
   $.post("ajax.php",{noeZIRANBAR:noe_zir_anbar},function(data){$("[name=code_ziranbar]").html(data);});
   $("#loading").fadeOut("fast");		
}  
function getDetailKala(code_kala)<!--اطلاعات کالا-->
{ 
    $("#loading").fadeIn("fast");
    $.post("ajax.php",{codeKALA : code_kala},function(data){			 
			  var splKala = data.split("^");
			  $("#name_kala").val(splKala[0]);
			  $("[name=Mo_GheymatDetailID]").val(splKala[4]);
			  $("[name=fee_gheymat]").val(splKala[5]);
			  //خالی شود
			  $("[name=GheymatDetailID]").val(splKala[105]);
			  $("[name=gd_fee]").val(splKala[105]);
			  //var mo=document.myform.mojody_khales_aval.value;
			  //var fe=document.myform.fee_gheymat.value;
			  //mablaghAval(mo,fe);
		 });
    $("#loading").fadeOut("fast");
}
 <!--محاسبه مبلغ-->
function mablaghRiali(m_a,gd_fee)
{
 var natije;
 natije=((m_a)*(gd_fee));                                       
 document.myform.mablagh_mojodyaval.value=natije;
}
function getDetailKeshvar(code_keshvar)<!--اطلاعات کشور-->
{ 
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
function getVaznGHooti(c_ghooti)<!-- اطلاعات قوطی-->
{
   $("#loading").fadeIn("fast");  
   $.post("ajax.php",{codeGHOOTI: c_ghooti},function(data){
		   var splGhooti = data.split("^");
		   $("#vazn_karton_this").val(splGhooti[1]);
		 });
   $("#loading").fadeOut("fast");	
}
function sumkarton()<!--محاسبه مجموع وزن کارتن ها در موجودی-->
{
 var sum_k;
 sum_k=parseFloat((document.myform.vazn_karton_this.value)*(document.myform.tedad_karton_aval.value)).toFixed(3);
 document.myform.sum_karton_this.value=sum_k;
}
function sumghooti()<!--محاسبه وزن قوطی ها یا همان موجودی خالص-->
{
 var sum_k2;
 sum_k2=parseFloat((document.myform.vazn_karton_this.value)*(document.myform.tedad_karton_aval.value)).toFixed(3);
 document.myform.mojody_khales_aval.value=sum_k2;
}
function vazn_khales_aval()<!--محاسبه وزن خالص در موجودی-->
{
 var natije_vazn;
 natije_vazn=parseFloat((document.myform.mojody_nakhales_aval.value)-(document.myform.sum_karton_this.value)).toFixed(3);                                      
 if(natije_vazn<0) natije_vazn=0;
 document.myform.mojody_khales_aval.value=natije_vazn;
} 
<!--با انتخاب نوع محموله اطلاعات عوض شود--><!--در حالت ویرایش-->
function getInfo(noe_mahmule)
{
  $("#loading").fadeIn("fast");  
  $.post("ajax.php",{noeMAHMULE:noe_mahmule},function(data){$("#info").html(data);});
  $("#loading").fadeOut("fast");		
}
function enterIE()
{
   if(window.event.keyCode == 13 && window.event.srcElement.id != \'sabt\')
   window.event.keyCode = 9;
} 
function set_mojody()<!--قرار گرفتن موجودی اول در فیلد های موجودی-->
{
 var result1,result2,result3;
 result1=document.myform.mojody_khales_aval.value;
 result2=document.myform.mojody_nakhales_aval.value;
 result3=document.myform.tedad_karton_aval.value;
 document.myform.mojody_khales.value=result1;
 document.myform.mojody_nakhales.value=result2;
 document.myform.tedad_karton.value=result3;
 return result1,result2,result3;
}
function setmojody_ghooti()
{
 var result1,result3;
 result1=document.myform.mojody_khales_aval.value;
 result3=document.myform.tedad_karton_aval.value;
 document.myform.mojody_khales.value=result1;
 document.myform.tedad_karton.value=result3;
 return result1,result3;
}
</script>
</head>';
if(!(isset($Mode))) $Mode='';
/*************SEARCH BUTTON******/// جستجوي اطلاعات
if(isset($open_filter))
{ $open_filter="";
  $_SESSION['mt_search_mojody_k']="";
} 
if(isset($Search_x))
{
 $Mode='';
 $Search_x="";
 $temp="";$temp2=""; 
 if($code_kala)            $temp.=" and $TableName.code_kala LIKE '$code_kala'";
 if($id)                   $temp.=" and $TableName.id LIKE '$id'";
 //if($noe_ziranbar)         $temp.=" and l_s_d.noe_ziranbar LIKE '$noe_ziranbar'";
 if($code_group_kala_top)  $temp.=" AND code_group_kala_top LIKE '$code_group_kala_top'";
 if($code_group_kala_middle)     $temp.=" AND code_group_kala_middle LIKE '$code_group_kala_middle'";
 if($code_ziranbar)        $temp.=" and $TableName.code_ziranbar LIKE '$code_ziranbar'";
 if($chkdetailforush)      $temp2.=" INNER JOIN sell.dm_anbar_det ON dad_anbar_id=$TableName.id";
 if($code_keshvar)         $temp.=" and $TableName.code_keshvar LIKE '$code_keshvar'";
 if($code_tolidkonande)    $temp.=" and $TableName.code_tolidkonande LIKE '$code_tolidkonande'";
 if($sal_tolid_shamsi)     $temp.=" and sal_tolid_shamsi LIKE '%$sal_tolid_shamsi%'";
 if($mah_tolid_shamsi)     $temp.=" and mah_tolid_shamsi LIKE '$mah_tolid_shamsi'";
 if($rouz_tolid_shamsi)    $temp.=" and rouz_tolid_shamsi LIKE '$rouz_tolid_shamsi'";
 if($code_mandegari)       $temp.=" and $TableName.code_mandegari LIKE '$code_mandegari'";
 if($code_karton)          $temp.=" and code_karton LIKE '$code_karton'";
 if($tedad_karton_aval)    $temp.=" and tedad_karton_aval LIKE '%$tedad_karton_aval%'";
 if($mojody_nakhales_aval) $temp.=" and mojody_nakhales_aval LIKE '%$mojody_nakhales_aval%'";
 if($mojody_khales_aval)   $temp.=" and mojody_khales_aval LIKE '%$mojody_khales_aval%'";
 if($tedad_karton)         $temp.=" and tedad_karton LIKE '%$tedad_karton%'";
 if($mojody_nakhales)      $temp.=" and mojody_nakhales LIKE '%$mojody_nakhales%'";
 if($mojody_khales)        $temp.=" and mojody_khales LIKE '%$mojody_khales%'";
 if($mahmule_type)        $temp.=" AND mahmule_type LIKE '$mahmule_type'";
 if($general_goods_id)    $temp.=" AND general_goods_id LIKE '%$general_goods_id%'";
 if($temp) {$PageNo=1;$_SESSION['mt_search_mojody_k']=$temp;} else $_SESSION['mt_search_mojody_k']="";
}
/********************PAGING***********************/
if(isset($_POST['wRowPerPage'])) $RowPerPage=$_POST['wRowPerPage'];
if(!isset($RowPerPage)) $RowPerPage=8;
$res = mysql_query("SELECT COUNT(*) FROM $mydatabase.$TableName $temp2 INNER JOIN $mydatabase.kala ON $TableName.code_kala=kala.code_kala INNER JOIN $mydatabase.list_sardkhane_detail l_s_d ON $TableName.code_ziranbar=l_s_d.code_ziranbar AND $TableName.code_ostan=l_s_d.code_ostan AND $TableName.code_anbar=l_s_d.code_anbar where 1=1 ".$_SESSION['mt_search_mojody_k']." AND $TableName.code_ostan='$mt_gl_code_ostan' AND $TableName.code_anbar='$mt_gl_code_anbar' AND $TableName.year='$mtActiveYear' AND $TableName.deleted=0");
$row = mysql_fetch_array($res);
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
$myMessage='';
$radif=$FirstRow+1;  
/******************** Insert- Edit- Delete ************/
/************اجازه براي ذخيره اطلاعات************/
function isPermitSave($c_kala,$n_zir_a,$code_zir_a,$c_keshvar,$c_tolid,$sal_t_sh,$mah_t_sh,$rouz_t_sh,$code_baste,$c_karton,$c_mandegari,$ted_k_a,$nakha_a,$kha_a,$ted_k,$nakha,$kha,$ted_gh_a,$ted_gh,$gl_c_o,$gl_c_s,$gl_year,$yy,$mm,$dd,$nerkh,$gheymatID)
{
 //برای بررسی تاریخ
 $emrouz=$yy.$mm.$dd;
 $mah_t=make_pattern($mah_t_sh,2);
 $rouz_t=make_pattern($rouz_t_sh,2);
 $tolid=$sal_t_sh.$mah_t.$rouz_t;
 $ins_message='';
 $flag=false;
 if(!($gl_c_o and $gl_c_s and $gl_year) or $gl_c_o==-1 or $gl_c_s==-1)//اگر سشن استان و سردخانه و سال خالی بود
 {   
   $flag=false;
   echo"<script>window.alert('لطفاً استان و انبار و سال مورد نظر خود را انتخاب نمایید!');</script>";
   return $flag;
 }
 else $flag=true;
 if((!$c_kala) or ($n_zir_a==0) or ($code_zir_a==0) or (!$c_keshvar) or (!$c_tolid) or (!$sal_t_sh) or(!$mah_t_sh) or (!$rouz_t_sh) or (!$c_mandegari) )//پر بودن فيلدها
 {
   $flag=false;
   echo"<script>window.alert('لطفاً فیلدهای ستاره دار را تکمیل نمایید');</script>";
   return $flag;
 } 
 else $flag=true; 
 if((($code_baste==1)OR($code_baste==2)) and (!$c_karton))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script>window.alert('لطفاً فیلدهای ستاره دار را تکمیل نمایید');</script>";
   return $flag;
 } 
 else $flag=true;
 // if(($kha_a==NULL)and($nakha_a==NULL)and($ted_k_a==NULL)and($kha==NULL)and($nakha==NULL)and($ted_k==NULL))//پر بودن فيلدها صفر را بتواند بزند
 // {
   // $flag=false;
   // echo"<script>window.alert('لطفاً فیلدهای ستاره دار را تکمیل نمایید');</script>";
   // return $flag;
 // } 
 // else $flag=true;
 if ((!justNumber($sal_t_sh)) or (strlen($sal_t_sh)<4) or (strlen($sal_t_sh)>4) or($sal_t_sh<1392) or($sal_t_sh>$gl_year))//بررسی سال شمسی
  {
    $flag=false;
    echo"<script>alert('فيلد سال تولید تامعتبر است!')</script>";
    return $flag;
  }
 else $flag=true;
 if((!justNumber($rouz_t_sh)) or (strlen($rouz_t_sh)<1) or (strlen($rouz_t_sh)>2) or($rouz_t_sh>31))//بررسی روز
  {
   $flag=false;
   echo"<script>alert('فيلد روز تولید نامعتبر است!')</script>";
   return $flag;
  }
 else $flag=true;
 if($tolid>$emrouz)//تاریخ تولید را از تاریخ امروز بیشتر نزند
 {
   $flag=false;
   echo"<script>alert('تاریخ تولید کالا نامعتبر است!')</script>";
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
 if(($code_baste!=3)and(!empty($c_karton)))//موجود نبودن کد کارتن یا قوطی در جدول کارتن/قوطی
 {
   $q_karton="SELECT code_karton FROM karton WHERE code_karton='$c_karton' AND code_bastebandy='$code_baste'";
   $res_karton=mysql_query($q_karton);
   if(mysql_num_rows($res_karton)==0){
     if($code_baste==1)echo"<script>alert('این کدکارتن در جدول کارتن ها ثبت نشده است!')</script>";
     if($code_baste==2)echo"<script>alert('این کدقوطی در جدول قوطی ها ثبت نشده است!')</script>";
     $flag=false;
     return $flag;
   }
   else $flag=true;
 }
 else $flag=true;
 if((!empty($c_kala)))//تکراری نبودن یک کالا در زیرانبار با کشور و تولید کننده و تاریخ تولید و کارتن یکسان
 {
  if((!empty($sal_t_sh)) and (!empty($mah_t_sh)) and (!empty($rouz_t_sh)))//اگر سال و ماه شمسی زده 
   {$q9="SELECT * FROM mojody_kala WHERE code_kala='$c_kala' AND code_ziranbar='$code_zir_a' AND code_keshvar='$c_keshvar' AND code_tolidkonande='$c_tolid' AND sal_tolid_shamsi='$sal_t_sh' AND mah_tolid_shamsi='$mah_t_sh' AND rouz_tolid_shamsi='$rouz_t_sh' AND code_karton='$c_karton'  AND code_mandegari='$c_mandegari' AND code_ostan='$gl_c_o' AND code_anbar='$gl_c_s' AND year='$gl_year' AND deleted=0";}
  //if((!empty($sal_t_m)) and (!empty($mah_t_m)))//اگر سال و ماه میلادی زده
   //{$q9="SELECT * FROM mojody_kala WHERE code_kala='$c_kala' AND code_keshvar='$c_keshvar' AND sal_tolid_milady='$sal_t_m' AND mah_tolid_milady='$mah_t_m' AND code_ostan='$gl_c_o' AND code_anbar='$gl_c_s' AND year='$gl_year' AND deleted=0";}
   $res9=mysql_query($q9);
   if(mysql_num_rows($res9)>0){
     echo"<script>alert('این کالا با این کشور و تولید کننده و تاریخ تولید وکارتن قبلاً ثبت شده است')</script>";
     $flag=false;
     return $flag;
  }
 else $flag=true;
 }
else $flag=true;
if(!empty($gheymatID))
 {
   $q14="SELECT Gd_CodeKala FROM mt_gheymat_detail WHERE Gd_ID=$gheymatID";
   $res14=mysql_query($q14);
   $row14=mysql_fetch_assoc($res14);
   if(($row14['Gd_CodeKala'])!=$c_kala){
     echo"<script>alert('لطفاً نرخ کالا را دوباره انتخاب نمایید!')</script>";
     $flag=false;
     return $flag;
  }
  else $flag=true;
 }  
 else $flag=true;
return $flag;
}
/**********اجازه براي ويرايش اطلاعات********/
function isPermitEdit($c_kala,$n_zir_a,$code_zir_a,$c_keshvar,$c_tolid,$sal_t_sh,$mah_t_sh,$rouz_t_sh,$code_baste,$c_karton,$c_mandegari,$ted_k_a,$nakha_a,$kha_a,$ted_k,$nakha,$kha,$gl_c_o,$gl_c_s,$gl_year,$this_id,$nerkh,$gheymatID)
{
  $flag=false;
  if(!($gl_c_o and $gl_c_s and $gl_year) or $gl_c_o==-1 or $gl_c_s==-1)//اگر سشن استان و سردخانه و سال خالی بود
  {   
   $flag=false;
   echo"<script> alert('لطفاً استان و انبار و سال مورد نظر خود را انتخاب نمایید!')</script>";
   return $flag;
  }
  else $flag=true;
  if((!$c_kala) or ($n_zir_a==0) or ($code_zir_a==0) or (!$c_keshvar) or (!$c_tolid) or (!$sal_t_sh) or(!$mah_t_sh) or (!$rouz_t_sh) or (!$c_mandegari))//پر بودن فيلدها
  {
   $flag=false;
   echo"<script> alert('لطفا تمام فيلد ها را تکميل نماييد')</script>";
   return $flag;
  } 
  else $flag=true;
  if((($code_baste==1)OR($code_baste==2)) and (!$c_karton))//پر بودن فيلدها
  {
   $flag=false;
   echo"<script>window.alert('لطفاً فیلدهای ستاره دار را تکمیل نمایید');</script>";
   return $flag;
  } 
  else $flag=true;
  // if(($kha_a==NULL)and($nakha_a==NULL)and($ted_k_a==NULL)and($kha==NULL)and($nakha==NULL)and($ted_k==NULL))//پر بودن فيلدها صفر را بتواند بزند
  // {
   // $flag=false;
   // echo"<script>window.alert('لطفاً فیلدهای ستاره دار را تکمیل نمایید');</script>";
   // return $flag;
  // } 
  // else $flag=true;
  if ((!justNumber($sal_t_sh)) or (strlen($sal_t_sh)<4) or (strlen($sal_t_sh)>4) or($sal_t_sh<1392)or($sal_t_sh>$gl_year))//بررسی سال شمسی
  {
    $flag=false;
    echo"<script>alert('فيلد سال تولید تامعتبر است!')</script>";
    return $flag;
  }
  else $flag=true;
  if((!justNumber($rouz_t_sh)) or (strlen($rouz_t_sh)<1) or (strlen($rouz_t_sh)>2) or($rouz_t_sh>31))//بررسی روز
  {
   $flag=false;
   echo"<script>alert('فيلد روز تولید نامعتبر است!')</script>";
   return $flag;
  }
  else $flag=true;
  if(!empty($c_kala))//موجود نبودن کد کالا در جدول کد کالا
 {
   $q_kala="SELECT id,code_kala FROM kala WHERE code_kala='$c_kala'";
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
 if((($code_baste==1)OR($code_baste==2))and(!empty($c_karton)))//موجود نبودن کد کارتن یا قوطی در جدول کارتن/قوطی
 {
   $q_karton="SELECT code_karton FROM karton WHERE code_karton='$c_karton' AND code_bastebandy='$code_baste'";
   $res_karton=mysql_query($q_karton);
   if(mysql_num_rows($res_karton)==0){
     if($code_baste==1)echo"<script>alert('این کدکارتن در جدول کارتن ها ثبت نشده است!')</script>";
     if($code_baste==2)echo"<script>alert('این کدقوطی در جدول قوطی ها ثبت نشده است!')</script>";
     $flag=false;
     return $flag;
   }
   else $flag=true;
 }
 else $flag=true;
 if((!empty($c_kala)))//تکراری نبودن یک کالا در زیرانبار با کشور و تولید کننده و تاریخ تولید و کارتن یکسان
 {
  if((!empty($sal_t_sh)) and (!empty($mah_t_sh)) and (!empty($rouz_t_sh)))//اگر سال و ماه شمسی زده 
   {$q9="SELECT * FROM mojody_kala WHERE code_kala='$c_kala' AND code_ziranbar='$code_zir_a' AND code_keshvar='$c_keshvar' AND code_tolidkonande='$c_tolid' AND sal_tolid_shamsi='$sal_t_sh' AND mah_tolid_shamsi='$mah_t_sh' AND rouz_tolid_shamsi='$rouz_t_sh' AND code_karton='$c_karton' AND code_mandegari='$c_mandegari' AND code_ostan='$gl_c_o' AND code_anbar='$gl_c_s' AND year='$gl_year' AND deleted=0 AND id!=$this_id";}
  //if((!empty($sal_t_m)) and (!empty($mah_t_m)))//اگر سال و ماه میلادی زده
   //{$q9="SELECT * FROM mojody_kala WHERE code_kala='$c_kala' AND code_keshvar='$c_keshvar' AND sal_tolid_milady='$sal_t_m' AND mah_tolid_milady='$mah_t_m' AND code_ostan='$gl_c_o' AND code_anbar='$gl_c_s' AND year='$gl_year' AND deleted=0";}
   $res9=mysql_query($q9);
   if(mysql_num_rows($res9)>0){
     echo"<script>alert('این کالا با این کشور و تولید کننده و تاریخ تولید وکارتن قبلاً ثبت شده است')</script>";
     $flag=false;
     return $flag;
  }
  else $flag=true;
 }
 else $flag=true;
 if(!empty($gheymatID))
 {
   $q14="SELECT Gd_CodeKala FROM mt_gheymat_detail WHERE Gd_ID=$gheymatID";
   $res14=mysql_query($q14);
   $row14=mysql_fetch_assoc($res14);
   if(($row14['Gd_CodeKala'])!=$c_kala){
     echo"<script>alert('لطفاً نرخ کالا را دوباره انتخاب نمایید!')</script>";
     $flag=false;
     return $flag;
  }
  else $flag=true;
 }  
 else $flag=true;
 return $flag;
}	
/*************INSERT BUTTON******/// ثبت اطلاعات    
if(isset($Insert_x))
{ 
     // $sum_karton_this=round(floatval($vazn_karton_this*$tedad_karton_aval),3);  
	// $mojody_khales_aval=round(floatval($mojody_nakhales_aval-$sum_karton_this),3);
	// echo "<script>alert($sum_karton_this)</script>";
	// echo "<script>alert($mojody_khales_aval)</script>";
 if(isPermitSave($code_kala,$noe_ziranbar,$code_ziranbar,$code_keshvar,$code_tolidkonande,$sal_tolid_shamsi,$mah_tolid_shamsi,$rouz_tolid_shamsi,$code_bastebandy,$code_karton,$code_mandegari,$tedad_karton_aval,$mojody_nakhales_aval,$mojody_khales_aval,$tedad_karton,$mojody_nakhales,$mojody_khales,$tedad_ghooti_aval,$tedad_ghooti,$mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear,$yy,$mm,$dd,$gd_fee,$GheymatDetailID)) 
 {
  $Mode='';
  $vazn_karton_this=$db->get_from_where("vazn_karton","$mydatabase.karton","code_karton='$code_karton' AND code_bastebandy='$code_bastebandy'");     	
   //محاسبات برای اطمینان
    if($code_bastebandy==1)//کارتنی
	{
	  $sum_karton_this=round(floatval($vazn_karton_this*$tedad_karton_aval),3);  
	  $mojody_khales_aval=round(floatval($mojody_nakhales_aval-$sum_karton_this),3);
	  $tedad_karton=$tedad_karton_aval;
	  $mojody_nakhales=$mojody_nakhales_aval;
	  $mojody_khales=$mojody_khales_aval;
	} 
	if($code_bastebandy==2)//قوطی
	{
     $mojody_khales_aval=round(floatval($vazn_karton_this*$tedad_karton_aval),3);
	 $mojody_khales=$mojody_khales_aval;
	}
   //محاسبه مبلغ  
   $mablagh_mojodyaval=$mojody_khales_aval*$gd_fee; 
   //تبدیل تاریخ شمسی به میلادی برای نگهداری در دیتابیس
   $milady=jalali_to_gregorian($sal_tolid_shamsi,$mah_tolid_shamsi,$rouz_tolid_shamsi);
   $sal_tolid_milady=$milady[0];$mah_tolid_milady=$milady[1];$rouz_tolid_milady=$milady[2];  
   $insert_q=("INSERT INTO $mydatabase.$TableName(code_ostan,code_anbar,year,code_ziranbar,code_kala,code_keshvar,code_tolidkonande,sal_tolid_shamsi,mah_tolid_shamsi,rouz_tolid_shamsi,
              sal_tolid_milady,mah_tolid_milady,rouz_tolid_milady,code_bastebandy,code_karton,vazn_karton_this,code_mandegari,sum_karton_this,tedad_karton_aval,mojody_nakhales_aval,mojody_khales_aval,tedad_karton,mojody_nakhales,mojody_khales,Mo_GheymatDetailID,mablagh_mojodyaval,deleted)
             VALUES('$mt_gl_code_ostan','$mt_gl_code_anbar','$mtActiveYear','$code_ziranbar','$code_kala','$code_keshvar','$code_tolidkonande','$sal_tolid_shamsi','$mah_tolid_shamsi','$rouz_tolid_shamsi',
			 '$sal_tolid_milady','$mah_tolid_milady','$rouz_tolid_milady','$code_bastebandy','$code_karton','$vazn_karton_this','$code_mandegari','$sum_karton_this','$tedad_karton_aval','$mojody_nakhales_aval','$mojody_khales_aval','$tedad_karton','$mojody_nakhales','$mojody_khales','$GheymatDetailID','$mablagh_mojodyaval','0')");
   $insert_res=mysql_query($insert_q);
   if($insert_res){
    $max_id=$db->get_from_where("Max(id)","$mydatabase.$TableName",""); 
    $log_i=$db->query("INSERT INTO $mydatabase.log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$max_id','ثبت',".($yymmdd).",'$logtime')");
  }
  else  $message ='<span style="color:red;font: bold 12px tahoma;"> * مشکلی در ثبت به وجود آمده است ! *</span>';
 }
}
/************EDIT BUTTON********/// اصلاح اطلاعات
if (isset($Edit_x))
{
 if(isPermitEdit($code_kala,$noe_ziranbar,$code_ziranbar,$code_keshvar,$code_tolidkonande,$sal_tolid_shamsi,$mah_tolid_shamsi,$rouz_tolid_shamsi,$code_bastebandy,$code_karton,$code_mandegari,$tedad_karton_aval,$mojody_nakhales_aval,$mojody_khales_aval,$tedad_karton,$mojody_nakhales,$mojody_khales,$mt_gl_code_ostan,$mt_gl_code_anbar,$mtActiveYear,$id_,$gd_fee,$GheymatDetailID)) 
 {
  $Mode='';
  $vazn_karton_this=$db->get_from_where("vazn_karton","$mydatabase.karton","code_karton='$code_karton' AND code_bastebandy='$code_bastebandy'");     	
  //محاسبات برای اطمینان
   if($code_bastebandy==1)//کارتنی
	{
	  $sum_karton_this=round(floatval($vazn_karton_this*$tedad_karton_aval),3);  
	  $mojody_khales_aval=round(floatval($mojody_nakhales_aval-$sum_karton_this),3);
	  //$tedad_karton=$tedad_karton_aval;
	  //$mojody_nakhales=$mojody_nakhales_aval;
	  //$mojody_khales=$mojody_khales_aval;
	  IF($code_kala==50){$tedad_shane_aval=$tedad_karton_aval*$_SESSION["mtShane"];$tedad_shane=$tedad_karton*$_SESSION["mtShane"];}
	  ELSE IF($code_kala==54){$tedad_shane_aval=$tedad_karton_aval*$_SESSION["mtShane_dakheli"];$tedad_shane=$tedad_karton*$_SESSION["mtShane_dakheli"];}
	}
    if($code_bastebandy==2)//قوطی
	{
	  $mojody_khales_aval=round(floatval($vazn_karton_this*$tedad_karton_aval),3);
	}
    //محاسبه مبلغ  
    $mablagh_mojodyaval=$mojody_khales_aval*$gd_fee;  	
    //تبدیل تاریخ شمسی به میلادی برای نگهداری در دیتابیس
	$milady=jalali_to_gregorian($sal_tolid_shamsi,$mah_tolid_shamsi,$rouz_tolid_shamsi);
    $sal_tolid_milady=$milady[0];$mah_tolid_milady=$milady[1];$rouz_tolid_milady=$milady[2]; 
    $edit_q=("UPDATE $mydatabase.$TableName SET code_ostan='$mt_gl_code_ostan',code_anbar='$mt_gl_code_anbar',year='$mtActiveYear',
            code_ziranbar='$code_ziranbar',code_kala='$code_kala',code_keshvar='$code_keshvar',code_tolidkonande='$code_tolidkonande',sal_tolid_shamsi='$sal_tolid_shamsi',mah_tolid_shamsi='$mah_tolid_shamsi',rouz_tolid_shamsi='$rouz_tolid_shamsi',
			sal_tolid_milady='$sal_tolid_milady',mah_tolid_milady='$mah_tolid_milady',rouz_tolid_milady='$rouz_tolid_milady',code_bastebandy='$code_bastebandy',code_karton='$code_karton',vazn_karton_this='$vazn_karton_this',code_mandegari='$code_mandegari',sum_karton_this='$sum_karton_this',tedad_karton_aval='$tedad_karton_aval',
			mojody_nakhales_aval='$mojody_nakhales_aval',mojody_khales_aval='$mojody_khales_aval',tedad_shane_aval='$tedad_shane_aval',tedad_karton='$tedad_karton',mojody_nakhales='$mojody_nakhales',mojody_khales='$mojody_khales',tedad_shane='$tedad_shane',tedad_joje='$tedad_joje',Mo_GheymatDetailID='$GheymatDetailID',mablagh_mojodyaval='$mablagh_mojodyaval',khales_sold='$khales_sold' WHERE id='$id_';");
  $edit_res=mysql_query($edit_q);
  if(($edit_res) and (mysql_affected_rows()!=0)) $log_e=$db->query("INSERT INTO $mydatabase.log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_','ویرایش',".($yymmdd).",'$logtime')");//کوئری لاگ 
  else $message ='<span style=" color:red;font: bold 12px tahoma;"> * مشکلی در ویرایش مشخصات به وجود آمده است ! *</span>';  
 } 
}
/************DELETE BUTTON********/// حذف اطلاعات
if (isset($Delete_x))
{
 $Mode='';
 $del_q ="DELETE FROM $mydatabase.$TableName WHERE id=$id_ AND 
         ($code_kala_ NOT IN (SELECT code_kala FROM resid_detail WHERE code_kala=$code_kala_ AND code_keshvar=$code_keshvar_ AND code_tolidkonande=$code_tolidkonande_ AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND resid_deleted=0))AND
         ($code_kala_ NOT IN (SELECT code_kala FROM resid_kala_detail WHERE code_kala=$code_kala_ AND code_keshvar=$code_keshvar_ AND code_tolidkonande=$code_tolidkonande_ AND sal_tolid_shamsi='$sal_tolid_shamsi_' AND mah_tolid_shamsi='$mah_tolid_shamsi_' AND rouz_tolid_shamsi='$rouz_tolid_shamsi_' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND code_ziranbar='$code_ziranbar_' AND year='$mtActiveYear' AND code_karton='$code_karton_' AND code_mandegari='$code_mandegari_' AND resid_deleted=0))AND
         ($code_kala_ NOT IN (SELECT code_kala FROM havale WHERE code_kala=$code_kala_ AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0))AND
         ($code_kala_ NOT IN (SELECT code_kala FROM havale_detail WHERE code_kala=$code_kala_ AND code_keshvar=$code_keshvar_ AND code_tolidkonande=$code_tolidkonande_  AND sal_tolid_shamsi='$sal_tolid_shamsi_' AND mah_tolid_shamsi='$mah_tolid_shamsi_' AND rouz_tolid_shamsi='$rouz_tolid_shamsi_' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND code_ziranbar='$code_ziranbar_' AND year='$mtActiveYear' AND code_karton='$code_karton_' AND havale_deleted=0))AND
         ($code_kala_ NOT IN (SELECT code_kala FROM tadil_mojody WHERE code_kala=$code_kala_ AND code_keshvar=$code_keshvar_ AND code_tolidkonande=$code_tolidkonande_  AND sal_tolid_shamsi='$sal_tolid_shamsi_' AND mah_tolid_shamsi='$mah_tolid_shamsi_' AND rouz_tolid_shamsi='$rouz_tolid_shamsi_' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND code_ziranbar='$code_ziranbar_' AND year='$mtActiveYear' AND code_karton='$code_karton_' AND deleted=0))";
 $del_res =mysql_query($del_q);
 if(mysql_affected_rows()==0) echo"<script>alert('این عنوان در سایر فرم ها استفاده شده است،شما مجاز به حذف آن نیستید!')</script>";
 else if($del_res) $log_d=$db->query("INSERT INTO $mydatabase.log (user_id,tbl_name,record_id,amaliyat,log_date,log_time)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_','حذف',".($yymmdd).",'$logtime')");//کوئری لاگ
 else $message ='<span style=" color:red;font: bold 12px tahoma;"> * مشکلی درحذف به وجود آمده است ! *</span>'; 
}
/***************************************** MAIN*****************************************/
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.code_kala.focus();">
<form method="post" name="myform" onkeydown="enterIE()">
<table width="99%" height="90%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr>
  <td class="title">
   <div style="position:absolute;top:5px;left:45%;">موجودی کالا در سردخانه</div>
   <div class="pagecover">[صفحه:&nbsp'.$PageNo.' از '.$MaxPage.']</div>
  </td>	 
 </tr>
 <!--پايان هدر-->
 <!-- مرکز صفحه-->	
 <tr>
  <td height="100%">
   <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
	<img src="images/loading.gif" id="loading" class="loading_img"/>
	<tr class="table-title">';
/********************sort field***********************/
if(!isset($order))    $order='id DESC';
if(!isset($sortziranbar)) $sortziranbar='1';
if(!isset($sortcode)) $sortcode='1';
if(!isset($sortname)) $sortname='1';
if(!isset($sortnamekeshvar)) $sortnamekeshvar='1';
if(!isset($sortnametolid)) $sortnametolid='1';
if(!isset($sortcodekarton)) $sortcodekarton='1';
if(!isset($sortsal)) $sortsal='1';
if(!isset($sortmah)) $sortmah='1';
if(!isset($sortrouz)) $sortrouz='1';
if(!isset($show_img)) $show_img='';
	 echo'<td width="3%" rowspan="2">ردیف</td>';
	 if($sortziranbar=='1')
	 {echo'<td width="5%" rowspan="2" title="مرتب سازی صعودی نام زیرانبار" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=code_ziranbar ASC&sortziranbar=2&show_img=1\'"/> زیرانبار ';
	   if($show_img=='1')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	 }
	 if($sortziranbar=='2')
	 {echo'<td width="5%" rowspan="2" title="مرتب سازی نزولی نام زیرانبار" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=code_ziranbar DESC&sortziranbar=1&show_img=1\'"/> زیرانبار ';
	   if($show_img=='16ق')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	 }
	 if($sortcode=='1')
	 {echo'<td width="5%" rowspan="2" title="مرتب سازی صعودی کد کالا" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=code_kala ASC&sortcode=2&show_img=2\'"/> کد کالا ';
	   if($show_img=='2')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	 }
	 if($sortcode=='2')
	 {echo'<td width="5%" rowspan="2" title="مرتب سازی نزولی کد کالا" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=code_kala DESC&sortcode=1&show_img=2\'"/> کد کالا ';
	   if($show_img=='2')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	 }
	 if($sortname=='1')
	 {echo'<td width="15%" rowspan="2" title="مرتب سازی صعودی نام کالا" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=name_kala ASC&sortname=2&show_img=3\'"/> نام کالا '; 
	   if($show_img=='3')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	 }
	 if($sortname=='2')
	 {echo'<td width="15%" rowspan="2" title="مرتب سازی نزولی نام کالا" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=name_kala DESC&sortname=1&show_img=3\'"/> نام کالا '; 
	   if($show_img=='3')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	 }
	 if($sortnamekeshvar=='1')
	 {echo'<td width="6%" rowspan="2" title="مرتب سازی صعودی نام کشور" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=name_keshvar ASC&sortnamekeshvar=2&show_img=4\'"/> کشور '; 
	   if($show_img=='4')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	 }
	 if($sortnamekeshvar=='2')
	 {echo'<td width="6%" rowspan="2" title="مرتب سازی نزولی نام کشور" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=name_keshvar DESC&sortnamekeshvar=1&show_img=4\'"/> کشور '; 
	   if($show_img=='4')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	 }
	 if($sortnametolid=='1')
	 {echo'<td width="10%" rowspan="2" title="مرتب سازی صعودی نام تولیدکننده" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=name_tolidkonande ASC&sortnametolid=2&show_img=5\'"/> تولیدکننده '; 
	   if($show_img=='5')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	 }
	 if($sortnametolid=='2')
	 {echo'<td width="10%" rowspan="2" title="مرتب سازی نزولی نام تولیدکننده" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=name_tolidkonande DESC&sortnametolid=1&show_img=5\'"/> تولیدکننده '; 
	   if($show_img=='5')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	 }	 
	 echo'<td width="15%" colspan="3">تاریخ تولید شمسی</td>';
	 // if($sortcodekarton=='1')
	 // {echo'<td width="3%" rowspan="2" title="مرتب سازی صعودی کد کارتن/قوطی" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=code_karton ASC&sortcodekarton=2&show_img=6\'"/> کد کارتن/قوطی '; 
	   // if($show_img=='6')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	 // }
	 // if($sortcodekarton=='2')
	 // {echo'<td width="3%" rowspan="2" title="مرتب سازی نزولی کد کارتن/قوطی" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=code_karton DESC&sortcodekarton=1&show_img=6\'"/> کد کارتن/قوطی '; 
	   // if($show_img=='6')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	 // }
	 echo'
	 <td width="6%" rowspan="2">تاریخ ماندگاری</td>
	 <td width="3%" rowspan="2">وزن کارتن/قوطی</td>
	 <td width="10%" rowspan="2">خالص اول دوره</td>
	 <td width="24%" colspan="3">مقادیر فعلی</td>';
	 if(($right_del)and($_SESSION['mtStatusYear']==0)) echo'<td width="3%" rowspan="2">حذف</td>';
	 echo'
	  <tr class="table-title">';
	  if($sortsal=='1')
	  {echo'<td  title="مرتب سازی صعودی سال" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=sal_tolid_shamsi ASC&sortsal=2&show_img=7\'"/> سال '; 
	    if($show_img=='7')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	  }
	  if($sortsal=='2')
	  {echo'<td  title="مرتب سازی نزولی سال" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=sal_tolid_shamsi DESC&sortsal=1&show_img=7\'"/> سال '; 
	    if($show_img=='7')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	  }
	  if($sortmah=='1')
	  {echo'<td  title="مرتب سازی صعودی ماه" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=mah_tolid_shamsi ASC&sortmah=2&show_img=8\'"/> ماه '; 
	    if($show_img=='8')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	  }
	  if($sortmah=='2')
	  {echo'<td  title="مرتب سازی نزولی ماه" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=mah_tolid_shamsi DESC&sortmah=1&show_img=8\'"/> ماه '; 
	    if($show_img=='8')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	  }
	  if($sortrouz=='1')
	  {echo'<td  title="مرتب سازی صعودی روز" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=rouz_tolid_shamsi ASC&sortrouz=2&show_img=9\'"/> روز '; 
	    if($show_img=='9')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	  }
	  if($sortrouz=='2')
	  {echo'<td  title="مرتب سازی نزولی روز" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=rouz_tolid_shamsi DESC&sortrouz=1&show_img=9\'"/> روز '; 
	    if($show_img=='9')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	  }
	  echo'
	   <td width="%">تعداد</td>
	   <td width="%">مقدار ناخالص </td>
	   <td width="%">مقدار خالص </td>
	  </tr>
	</tr>';
	$i=0;
    //$q1="SELECT * FROM view_mojodykala WHERE 1=1 ".$_SESSION['mt_search_mojody_k']." AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0 order by $order $Limit";
	$q1="SELECT $TableName.*,kala.name_kala,kala.general_goods_id,kala.code_group_kala_top,keshvar.name_keshvar,tolidkonande.name_tolidkonande,l_s_d.noe_ziranbar,l_s_d.name_ziranbar,sharh_mandegari From $mydatabase.$TableName
         INNER JOIN $mydatabase.kala ON $TableName.code_kala=kala.code_kala
         INNER JOIN $mydatabase.keshvar ON $TableName.code_keshvar=keshvar.code_keshvar
         INNER JOIN $mydatabase.tolidkonande ON $TableName.code_tolidkonande=tolidkonande.code_tolidkonande
         INNER JOIN $mydatabase.list_sardkhane_detail l_s_d ON $TableName.code_ziranbar=l_s_d.code_ziranbar AND $TableName.code_ostan=l_s_d.code_ostan AND $TableName.code_anbar=l_s_d.code_anbar  	  
	     INNER JOIN $mydatabase.tarikh_mandegari ON $TableName.code_mandegari=tarikh_mandegari.code_mandegari
		 $temp2 WHERE 1=1 ".$_SESSION['mt_search_mojody_k']." AND $TableName.code_ostan='$mt_gl_code_ostan' AND $TableName.code_anbar='$mt_gl_code_anbar' AND $TableName.year='$mtActiveYear' AND $TableName.deleted=0 order by $order $Limit";
	
	$allMojody = $db->query($q1);
    while($row1=$db->fetch_assoc($allMojody))
	{
	 if($right_edt){$edtClick='onClick="window.location=\''.$FileName.'?Mode=Edit&id_='.$row1['id'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'"';}	 
     if($i++%2)
     echo'
     <tr class="table-odd"/>';
     else echo '
     <tr class="table-even"/>';
	 //$a=mojodyGroupKhales('','',$row1['year'],$row1['code_group_kala_top']);
	 //$b=mojodyMojazKhales($row1['year'],$row1['code_kala']);
	 //با استفاده از تابع
	 $tedad_karton=mojodyKarton($row1['code_ostan'],$row1['code_anbar'],$row1['year'],$row1['code_ziranbar'],$row1['code_kala'],$row1['code_keshvar'],$row1['code_tolidkonande'],$row1['sal_tolid_shamsi'],$row1['mah_tolid_shamsi'],$row1['rouz_tolid_shamsi'],$row1['code_karton'],$row1['code_mandegari']);
	 $mojody_nakhales=mojodyNakhales($row1['code_ostan'],$row1['code_anbar'],$row1['year'],$row1['code_ziranbar'],$row1['code_kala'],$row1['code_keshvar'],$row1['code_tolidkonande'],$row1['sal_tolid_shamsi'],$row1['mah_tolid_shamsi'],$row1['rouz_tolid_shamsi'],$row1['code_karton'],$row1['code_mandegari']);
	 $mojody_khales=mojodyKhales($row1['code_ostan'],$row1['code_anbar'],$row1['year'],$row1['code_ziranbar'],$row1['code_kala'],$row1['code_keshvar'],$row1['code_tolidkonande'],$row1['sal_tolid_shamsi'],$row1['mah_tolid_shamsi'],$row1['rouz_tolid_shamsi'],$row1['code_karton'],$row1['code_mandegari']);
	 echo'
	  <td '.$edtClick.'>'.$radif++.'</td>
	  <td '.$edtClick.'>'.$row1['name_ziranbar'].'</td>
	  <td '.$edtClick.' title= "'.$row1['general_goods_id'].'" >'.$row1['code_kala'].'</td>
	  <td '.$edtClick.'>'.$row1['name_kala'].'</td>
	  <td '.$edtClick.'>'.$row1['name_keshvar'].'</td>
	  <td '.$edtClick.'>'.$row1['name_tolidkonande'].'</td>
	  <td '.$edtClick.'>'.$row1['sal_tolid_shamsi'].'</td>
	  <td '.$edtClick.'>'.$mahshamsiArr[$row1['mah_tolid_shamsi']].'</td>
	  <td '.$edtClick.'>'.$row1['rouz_tolid_shamsi'].'</td>
	  <td '.$edtClick.'>'.$row1['sharh_mandegari'].'</td>
	  <!--<td '.$edtClick.'>'.$row1['code_karton'].'</td>-->
	  <td '.$edtClick.'>'.$row1['vazn_karton_this'].'</td>
	  <td '.$edtClick.'>'.round($row1['mojody_khales_aval'],3).'</td>
	  <td '.$edtClick.'>'.$tedad_karton.'</td>
	  <td '.$edtClick.'>'.round($mojody_nakhales,3).'</td>
	  <td '.$edtClick.'>'.round($mojody_khales,3).'</td>';
	  if(($right_del)and($_SESSION['mtStatusYear']==0))
	  {echo'<td><img border="0" src="images/trash.png" width="20" height="20" title="حذف" 
	   	  onmouseOver="this.src=\'images/trash_hover.png\'" 
		  onmouseOut="this.src=\'images/trash.png\'" 
	      onClick="iconfirm(\''.$FileName.'?Delete_x=1&id_='.$row1['id'].'&code_kala_='.$row1['code_kala'].'&code_keshvar_='.$row1['code_keshvar'].'&code_tolidkonande_='.$row1['code_tolidkonande'].'&sal_tolid_shamsi_='.$row1['sal_tolid_shamsi'].'&mah_tolid_shamsi_='.$row1['mah_tolid_shamsi'].'&rouz_tolid_shamsi_='.$row1['rouz_tolid_shamsi'].'&code_ziranbar_='.$row1['code_ziranbar'].'&code_karton_='.$row1['code_karton'].'&code_mandegari_='.$row1['code_mandegari'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'\',\'برای حذف موجودی کالای '.$row1['name_kala'].' محصول کشور '.$row1['name_keshvar'].'-'.$row1['name_tolidkonande'].' با تاریخ تولید '.$row1['rouz_tolid_shamsi'].'-'.$mahshamsiArr[$row1['mah_tolid_shamsi']].'-'.$row1['sal_tolid_shamsi'].'وکد کارتن '.$row1['code_karton'].' در '.$row1['name_ziranbar'].' وسال  '.$mtActiveYear.'\')" /></td>';
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
	  if(($right_del)and($_SESSION['mtStatusYear']==0))echo'<td>&nbsp;</td>
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
   <table width="100%" border="0" cellspacing="0" cellpadding="0" height=100%  style="margin-bottom:20px;">';
   if (!$Mode)
   {echo '	  			
	<tr>
	 <td width="10">&nbsp;</td>
	 <td width="24"><div onClick="window.open(\'print_mojody_kala.php\',\'_blank\',\'scrollbars=1\')" id="printer" title="چاپ"><a href="#"></a></div></td>
     <td width="10">&nbsp;</td>';
	 if((($right_ins)and($_SESSION['mtStatusYear']==0)and($_SESSION['mt_anbar_activate']==1))OR(SuperUser()and($_SESSION['mt_anbar_activate']==1)))
	 {
	 echo'<td width="70"><div onClick="window.location=\''.$FileName.'?Mode=Insert&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-new" title="افزودن رکورد جديد"><a href="#"></a></div></td>
 	 <td width="10">&nbsp;</td>';}
	 echo'
	 <td width="70"><div onClick="window.location=\''.$FileName.'?Mode=Search&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-search" title="جستجو" ><a href="#"></a></div></td>
	 <td width="10">&nbsp;</td>
	 <td width="70"><div onClick="window.location=\'my_frame.php\'" id="btn-back"  title="بازگشت به منوی اصلی"  ><a href="#"></a></div></td> 
	 <td width="20">&nbsp;</td>	   
	 <td width="22"><div '.$En_Prev.' onClick="window.location=\''.$FileName.'?PageNo=1&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-pageone" title="رويت اولين صفحه"><a href="#"></a></div></td>
	 <td width="2">&nbsp;</td>
	 <td width="22"><div '.$En_Prev.' onClick="window.location=\''.$FileName.'?PageNo='.$PrevPage.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-perevius" title="رفتن به صفحه قبلي"><a href="#"></a></div></td>
     <td width="2">&nbsp;</td>
	 <td width="40" align="center"><input type="text" name="PageNo" value="'.$PageNo.'" size="2" onChange="myform.submit()" onkeypress="return isNumber(event)" style="direction:ltr;text-align:center;"></td>		   
	 <td width="2">&nbsp;</td> 
	 <td width="22"><div '.$En_Next.' onClick="window.location=\''.$FileName.'?PageNo='.$NextPage.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-forward" title="رفتن به صفحه بعدي"><a href="#"></a></div></td>
     <td width="2">&nbsp;</td>	   
	 <td width="22"><div '.$En_Next.' onClick="window.location=\''.$FileName.'?PageNo='.$MaxPage.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-pageend" title="رويت آخرين صفحه"><a href="#" ></a></div></td>
	 <td width="2">&nbsp;</td> 
	 <td width="65" align="left"><span class="text1">تعداد خط :</span></td>
	 <td align="right"><input type="text" name="wRowPerPage" value="'.$RowPerPage.'" size="2" onChange="myform.submit()"  onkeypress="return isNumber(event)" style="direction:ltr;text-align:center;"></td>
	 <td width="10">&nbsp;</td>';
     if (($_SESSION['mt_search_mojody_k'])OR($temp2)) 
	 echo '<td width="70"><input type="Button" class=buttonme  value="نمايش همه" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&open_filter=1\'"></td>';	 
	 echo'
     <td><span class="tedadcover" align="center" > تعداد ['.$cnt.']</span></td>	 
	</tr>';
    }
    if ($Mode=="Insert") //Insert Mode
    {echo '
    <tr> 
	 <td class="borderall" width="99%" style="position:absolute;bottom:10px;left:0.5%;"> 	 
	  <table  bgcolor="#E9F7FD" width="100%" cellpadding="0" cellspacing="0">
       <tr class="title"><td colspan="10" align="center">ايجاد موجودی کالای جدید</td></tr>
	   <tr><td >&nbsp;</td></tr>
	   <tr><td align="left"><span class="star">*</span> نوع بسته بندی :&nbsp;</td><td align="right">'.listbox("code_bastebandy",$code_bastebandy,"code_bastebandy","sharh_bastebandy","bastebandy","1=1 ORDER BY sharh_bastebandy ASC","class='text4' onchange=myform.submit()","").'</td></tr>';
	    if(!$code_bastebandy)
		echo '<tr><td colspan="10">برای مشاهده سایراطلاعات نوع بسته بندی راانتخاب نمایید</td></tr>';
	   if($code_bastebandy)
	   {
	   echo'
	   <tr>
	    <td align="left" width="150px"><span class="star">*</span> کد کالا :&nbsp;</td><td align="right"><input class="textboxme2 textbox50" type="text" name="code_kala" value="'.$code_kala.'" maxlength="3" onkeypress="return isNumber(event)" onKeyUp="F10desc(event)" onfocus="getDetailKala(this.value),mablaghAval(document.myform.mojody_khales_aval.value,document.myform.fee_gheymat.value);" onblur="getDetailKala(this.value)"/>';
 	     $code_bastebandy_=$code_bastebandy;
		 include('img_helpkalabastebandy.php');
		echo'
		</td>
		<td align="left" width="150px"> نام کالا :&nbsp;</td><td align="right" ><input class="textboxme" type="text" readonly id="name_kala" name="name_kala" value="'.$name_kala.'"/></td>
	    <td align="left"><span class="star">*</span>  نوع زیرانبار :&nbsp;</td><td align="right" >'.static_listbox("noe_ziranbar",$noe_ziranbar,"ziranbarArr",1,"class='text4' onchange=getZiranbar(this.value)").'</td>';
		if($noe_ziranbar)//اگر نوع زیرانبار قبلا انتخاب شده ولی اجازه ثبت داده نشده
	    {
		  echo'
	      <td align="left"><span class="star">*</span>  نام زیرانبار :&nbsp;</td><td align="right" >'.listbox("code_ziranbar",$code_ziranbar,"code_ziranbar","name_ziranbar","list_sardkhane_detail","1=1 AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND noe_ziranbar='$noe_ziranbar'","class='text4'").'</td>';
        } 
		 //اولین بار وارد صفحه می شویم
		else {echo'<td align="left"><span class="star">*</span>  نام زیرانبار :&nbsp;</td><td align="right" ><select name="code_ziranbar" id="name_zir_a" class="text4"><option value="0">انتخاب کنيد</option></select></td>';}
        echo'
	   </tr>
	   <tr>
	     <td align="left"><span class="star">*</span> کد کشور  :&nbsp;</td><td align="right"><input class="textboxme2 textbox50" type="text" name="code_keshvar" value="'.$code_keshvar.'" onkeypress="return isNumber(event)" onfocus="getDetailKeshvar(this.value);" onblur="getDetailKeshvar(this.value);"/>';
		 include('img_helpkeshvar.php');
	 	 echo'
		 </td>
		 <td align="left"> نام کشور :&nbsp;</td><td align="right" ><input class="textboxme" type="text" readonly id="name_keshvar" name="name_keshvar" value="'.$name_keshvar.'"/></td>
	     <td align="left"><span class="star">*</span> کد تولیدکننده  :&nbsp;</td><td align="right"><input class="textboxme2 textbox50" type="text" name="code_tolidkonande" value="'.$code_tolidkonande.'" onkeypress="return isNumber(event)" onfocus="getDetailTolid(this.value);" onblur="getDetailTolid(this.value);"/>';
		 include('img_helptolid.php');
		 echo'
		 </td>
         <td align="left"> نام تولیدکننده :&nbsp;</td><td align="right" ><input class="textboxme2" type="text" readonly id="name_tolidkonande" name="name_tolidkonande" value="'.$name_tolidkonande.'" /></td>
       </tr>
       <tr>	   
		<td align="left"><span class="star">*</span> تاریخ تولید شمسی  :&nbsp;</td>
		<td align="right" colspan="3">
		       <span class="star">*</span> سال : <input class="textboxme2 textbox50" type="text" name="sal_tolid_shamsi" value="'.$sal_tolid_shamsi.'" maxlength="4" placeholder=" '.$mtActiveYear.'" onkeypress="return isNumber(event)"/>
		       	<img border="0" src="images/Info1.png" title="لطفاً سال موردنظر خود را در 4 رقم وارد نمایید" onmouseOver="this.src=\'images/Info_h.png\'" onmouseOut="this.src=\'images/Info1.png\'" style="width:16px;height:16px;cursor:pointer"/>
			   <span class="star">*</span> ماه : '.static_listbox("mah_tolid_shamsi",$mah_tolid_shamsi,"mahshamsiArr",1,"class='text4'").'
			   <span class="star">*</span> روز : <input class="textboxme2 textbox50" type="text" name="rouz_tolid_shamsi" value="'.$rouz_tolid_shamsi.'" maxlength="2" onkeypress="return isNumber(event)"/>
		</td>
	    <td align="left"><span class="star">*</span> تاریخ ماندگاری :&nbsp;</td><td align="right" >'.listboxMe("code_mandegari",$code_mandegari,"code_mandegari","sharh_mandegari","tarikh_mandegari","","class='text4'").'</td>
         <!--<td align="left"> انتخاب نرخ :&nbsp;</td><td align="right"> 
	      <input type="hidden" name="GheymatDetailID" value="'.$GheymatDetailID.'"/>
	      <input type="text" readonly class="textboxme" name="gd_fee" value="'.$gd_fee.'" style="width:50px" onfocus="return mablaghRiali(document.myform.mojody_khales_aval.value,this.value);"/>';
		  include("img_helpnerkh.php");
		  echo'
		  </td>
          <td align="left"> مبلغ :&nbsp;</td><td align="right"><input type="text" class="textboxme2" readonly name="mablagh_mojodyaval" value="'.$mablagh_mojodyaval.'""/></td>
		  -->';
	   	if($code_bastebandy==1)//کارتنی
		{echo'
	     <td align="left"><span class="star">*</span> کد کارتن :&nbsp;</td><td align="right"><input type="text" class="textboxme2 textbox50" name="code_karton" id="code_karton" onfocus="getVaznKarton(this.value)" onblur="getVaznKarton(this.value)" onkeypress="return isNumber(event)"/>';
		 include('img_helpkarton.php');
		  echo'
          وزن کارتن :&nbsp;<input class="textboxme2 textbox50" type="text" readonly name="vazn_karton_this" id="vazn_karton_this" /></td> 
	    </tr>
		<tr>
          <td colspan="10">
	       <fieldset>
	       <legend>مقادیر موجودی</legend>
	        <table width="100%">
	         <tr>
	  	      <td align="right" style="font-weight:bold;">مقادیر موجودی اول دوره </td>		   
              <td align="left"><span class="star">*</span> تعداد کارتن :&nbsp;</td><td align="right"><input class="textboxme2" type="text" name="tedad_karton_aval"  onblur="return sumkarton()"  onkeypress="return isNumber(event)"/></td>
	  	      <td align="left"> مجموع وزن کارتن ها :&nbsp;</td><td align="right"><input class="textboxme2" readonly type="text" name="sum_karton_this" /></td>			
	          <td align="left"><span class="star">*</span> مقدار ناخالص :&nbsp;</td><td align="right"><input class="textboxme2" type="text" name="mojody_nakhales_aval" onblur="return vazn_khales_aval(),set_mojody(),mablaghAval(document.myform.mojody_khales_aval.value,document.myform.fee_gheymat.value);" onKeydown="return PressfloatOnly(event,this)"/></td>
	  		  <td align="left"> مقدار خالص :&nbsp;</td><td align="right"><input class="textboxme2" readonly type="text" name="mojody_khales_aval" onfocus="return vazn_khales_aval(),mablaghRiali(this.value,document.myform.gd_fee.value);" onblur="return set_mojody(),mablaghRiali(this.value,document.myform.gd_fee.value);"/></td>
	         </tr>
	         <tr>
	  	      <td align="right" style="font-weight:bold;">مقادیر موجودی فعلی </td>
	          <td align="left"> تعداد کارتن :&nbsp;</td><td align="right"><input class="textboxme2" type="text" readonly name="tedad_karton"  onkeypress="return isNumber(event)"/></td>
	          <td colspan="2"></td>
	  		  <td align="left"> مقدار ناخالص :&nbsp;</td><td align="right"><input class="textboxme2" type="text" readonly name="mojody_nakhales" onKeydown="return PressfloatOnly(event,this)"/></td>
	          <td align="left"> مقدار خالص :&nbsp;</td><td align="right"><input class="textboxme2" type="text" readonly name="mojody_khales" onKeydown="return PressfloatOnly(event,this)"/></td>
	  	     </tr>
            </table>	
           </fieldset>
          </td>
         </tr>';
        }
		else if($code_bastebandy==2)//قوطی
		{echo'
	     <td align="left"><span class="star">*</span> کد قوطی :&nbsp;</td><td align="right"><input type="text" class="textboxme2 textbox50" name="code_karton" id="code_karton"  onfocus="getVaznGHooti(this.value)" onblur="getVaznGHooti(this.value)" onkeypress="return isNumber(event)"/>';
		 include('img_helpghooti.php');
		  echo'
          وزن قوطی :&nbsp;<input class="textboxme2 textbox50" type="text" readonly name="vazn_karton_this" id="vazn_karton_this" /></td>
		 </tr>
         <tr>
          <td colspan="10">
	       <fieldset>
	       <legend>مقادیر موجودی</legend>
	        <table width="50%" border="0">
	         <tr>
	  	      <td align="right" style="font-weight:bold;">مقادیر موجودی اول دوره </td>		   
              <td align="left"><span class="star">*</span> تعداد قوطی :&nbsp;</td><td align="right"><input class="textboxme2" type="text" name="tedad_karton_aval" onblur="return sumghooti(),setmojody_ghooti(),mablaghAval(document.myform.mojody_khales_aval.value,document.myform.fee_gheymat.value);" onkeypress="return isNumber(event)"/></td>
	          <td align="left"> مقدار خالص :&nbsp;</td><td align="right"><input class="textboxme2" readonly type="text" name="mojody_khales_aval"/></td>
			 </tr>
	         <tr>
	  	      <td align="right" style="font-weight:bold;">مقادیر موجودی فعلی </td>
	          <td align="left"> تعداد قوطی :&nbsp;</td><td align="right"><input class="textboxme2" type="text" readonly name="tedad_karton" onkeypress="return isNumber(event)"/></td>
	  	      <td align="left"> مقدار خالص :&nbsp;</td><td align="right"><input class="textboxme2" type="text" readonly name="mojody_khales" /></td>
			 </tr>
            </table>	
           </fieldset>
          </td>
         </tr>';
        }
		else //لاشه و سایر
		{echo'
		 <tr>
          <td colspan="10">
	       <fieldset>
	       <legend>مقادیر موجودی</legend>
	        <table width="50%" border="0">
	         <tr>
	  	      <td align="right" style="font-weight:bold;">مقادیر موجودی اول دوره </td>		   
              <td align="left"><span class="star">*</span> تعداد :&nbsp;</td><td align="right"><input class="textboxme2" type="text" name="tedad_karton_aval"  onkeypress="return isNumber(event)"/></td>';
	          if(($code_bastebandy!=5)AND($code_bastebandy!=6)) echo'<td align="left"><span class="star">*</span> مقدار خالص :&nbsp;</td><td align="right"><input class="textboxme2" type="text" name="mojody_khales_aval" onKeydown="return PressfloatOnly(event,this)" onblur="return setmojody_ghooti();"/></td>';
			  echo'
			 </tr>
	         <tr>
	  	      <td align="right" style="font-weight:bold;">مقادیر موجودی فعلی </td>
	          <td align="left"> تعداد :&nbsp;</td><td align="right"><input class="textboxme2" type="text" readonly name="tedad_karton"/></td>';
	  	      if(($code_bastebandy!=5)AND($code_bastebandy!=6))echo'<td align="left"> مقدار خالص :&nbsp;</td><td align="right"><input class="textboxme2" type="text" readonly name="mojody_khales" /></td>';
			  echo'
			 </tr>
            </table>	
           </fieldset>
          </td>
         </tr>';		    
	    }
	   }
       echo'	   
	   <tr class="footer">
        <td colspan="10" align="center">
		 <input class="buttonme" type="submit" name="Insert_x" id="sabt" value="ثبت">
         <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'">
        </td>
	   </tr>
      </table>
	 </td>
    </tr>';
    }
    if ($Mode=="Edit")//Edit Mode
    {
     $q2="SELECT $TableName.*,kala.name_kala,keshvar.name_keshvar,tolidkonande.name_tolidkonande,l_s_d.noe_ziranbar,l_s_d.name_ziranbar,mt_gheymat_detail.Gd_Fee From $TableName
         INNER JOIN kala ON $TableName.code_kala=kala.code_kala
         INNER JOIN keshvar ON $TableName.code_keshvar=keshvar.code_keshvar
		 INNER JOIN tolidkonande ON $TableName.code_tolidkonande=tolidkonande.code_tolidkonande
         INNER JOIN list_sardkhane_detail l_s_d ON $TableName.code_ziranbar=l_s_d.code_ziranbar AND $TableName.code_ostan=l_s_d.code_ostan AND $TableName.code_anbar=l_s_d.code_anbar  	  
         LEFT JOIN mt_gheymat_detail ON $TableName.Mo_GheymatDetailID=mt_gheymat_detail.Gd_ID
		 WHERE $TableName.id='$id_'";		  
	 $res2=$db->query($q2);
	 $row2=$db->fetch_assoc($res2);
	 //با استفاده از تابع
     $tedad_karton=mojodyKarton($row2['code_ostan'],$row2['code_anbar'],$row2['year'],$row2['code_ziranbar'],$row2['code_kala'],$row2['code_keshvar'],$row2['code_tolidkonande'],$row2['sal_tolid_shamsi'],$row2['mah_tolid_shamsi'],$row2['rouz_tolid_shamsi'],$row2['code_karton'],$row2['code_mandegari']);
     $mojody_nakhales=mojodyNakhales($row2['code_ostan'],$row2['code_anbar'],$row2['year'],$row2['code_ziranbar'],$row2['code_kala'],$row2['code_keshvar'],$row2['code_tolidkonande'],$row2['sal_tolid_shamsi'],$row2['mah_tolid_shamsi'],$row2['rouz_tolid_shamsi'],$row2['code_karton'],$row2['code_mandegari']);
	 $mojody_khales=mojodyKhales($row2['code_ostan'],$row2['code_anbar'],$row2['year'],$row2['code_ziranbar'],$row2['code_kala'],$row2['code_keshvar'],$row2['code_tolidkonande'],$row2['sal_tolid_shamsi'],$row2['mah_tolid_shamsi'],$row2['rouz_tolid_shamsi'],$row2['code_karton'],$row2['code_mandegari']);  
	 $tedad_joje=mojodyJoje($row2['code_ostan'],$row2['code_anbar'],$row2['year'],$row2['code_ziranbar'],$row2['code_kala'],$row2['code_keshvar'],$row2['code_tolidkonande'],$row2['sal_tolid_shamsi'],$row2['mah_tolid_shamsi'],$row2['rouz_tolid_shamsi'],$row2['code_karton'],$row2['code_mandegari']);
	 IF($row2['code_kala']==50)$tedad_shane=$tedad_karton*$_SESSION["mtShane"];
	 ELSE IF($row2['code_kala']==54)$tedad_shane=$tedad_karton*$_SESSION["mtShane_dakheli"];
	 
	 echo'
     <tr> 
	  <td width="99%" class="borderall" style="position:absolute;bottom:10px;left:0.5%;">	 
	   <table width="100%" bgcolor="#E9F7FD" align="center" cellpadding="0" cellspacing="0" >
        <tr class="title"><td colspan="10" align="center">ويرايش موجودی '.$row2['name_kala'].' با شناسه'.$row2['id'].'</td></tr>';
		//بررسی وجود در سایر جدول ها
	    $exist_resid_detail=$db->get_from_where("count(code_kala)","resid_detail","code_kala='".$row2['code_kala']."' AND code_keshvar='".$row2['code_keshvar']."' AND code_tolidkonande='".$row2['code_tolidkonande']."' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND resid_deleted=0");
	    $exist_resid_kala_detail=$db->get_from_where("count(code_kala)","resid_kala_detail","code_kala='".$row2['code_kala']."' AND code_keshvar='".$row2['code_keshvar']."' AND code_tolidkonande='".$row2['code_tolidkonande']."' AND sal_tolid_shamsi='".$row2['sal_tolid_shamsi']."' AND mah_tolid_shamsi='".$row2['mah_tolid_shamsi']."' AND rouz_tolid_shamsi='".$row2['rouz_tolid_shamsi']."' AND code_karton='".$row2['code_karton']."' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND code_ziranbar='".$row2['code_ziranbar']."' AND year='$mtActiveYear' AND resid_deleted=0");
		$exist_havale=$db->get_from_where("count(code_kala)","havale","code_kala='".$row2['code_kala']."' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0");
		$exist_havale_detail=$db->get_from_where("count(code_kala)","havale_detail","code_kala='".$row2['code_kala']."' AND code_keshvar='".$row2['code_keshvar']."' AND code_tolidkonande='".$row2['code_tolidkonande']."' AND sal_tolid_shamsi='".$row2['sal_tolid_shamsi']."' AND mah_tolid_shamsi='".$row2['mah_tolid_shamsi']."' AND rouz_tolid_shamsi='".$row2['rouz_tolid_shamsi']."' AND code_karton='".$row2['code_karton']."' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND code_ziranbar='".$row2['code_ziranbar']."' AND year='$mtActiveYear' AND havale_deleted=0");
	    $exist_tadil=$db->get_from_where("count(code_kala)","tadil_mojody","code_kala='".$row2['code_kala']."' AND code_keshvar='".$row2['code_keshvar']."' AND code_tolidkonande='".$row2['code_tolidkonande']."' AND sal_tolid_shamsi='".$row2['sal_tolid_shamsi']."' AND mah_tolid_shamsi='".$row2['mah_tolid_shamsi']."' AND rouz_tolid_shamsi='".$row2['rouz_tolid_shamsi']."' AND code_karton='".$row2['code_karton']."' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND code_ziranbar='".$row2['code_ziranbar']."' AND year='$mtActiveYear' AND deleted=0");
	    $befor_year=$row2['year']-1;
	    //echo $befor_year;
		$exist_mojody_befor=$db->get_from_where("count(code_kala)","mojody_kala","code_kala=".$row2['code_kala']." AND code_keshvar='".$row2['code_keshvar']."' AND code_tolidkonande='".$row2['code_tolidkonande']."' AND sal_tolid_shamsi='".$row2['sal_tolid_shamsi']."' AND mah_tolid_shamsi='".$row2['mah_tolid_shamsi']."' AND rouz_tolid_shamsi='".$row2['rouz_tolid_shamsi']."' AND code_karton='".$row2['code_karton']."' AND code_ostan=".$row2['code_ostan']." AND code_anbar=".$row2['code_anbar']." AND code_ziranbar=".$row2['code_ziranbar']." AND year=".$befor_year." AND deleted=0");
		if(($exist_resid_detail)or($exist_resid_kala_detail)or($exist_havale)or($exist_havale_detail)or($exist_tadil)or($exist_mojody_befor))
	 	{
		 echo'
		 <tr>
		  <td align="left"> شناسه موجودی :&nbsp;</td><td align="right"><input class="textboxme2" type="text" name="id" readonly value="'.$row2['id'].'" /></td>
		  <td align="left"><span class="star">*</span> نوع بسته بندی :&nbsp;</td><td align="right">'.listbox("code_bastebandy",$row2['code_bastebandy'],"code_bastebandy","sharh_bastebandy","bastebandy","1=1 ORDER BY sharh_bastebandy ASC","class='text4' disabled","").'</td></tr>
          <input type="hidden" value='.$row2['code_bastebandy'].' name="code_bastebandy"/>
		 <tr>
	      <td align="left" width="150px"><span class="star">*</span> کد کالا  :&nbsp;</td><td align="right"><input class="textboxme2 textbox50" type="text" title="غیر قابل تغییر" name="code_kala" readonly value="'.$row2['code_kala'].'" maxlength="3" style="width:50px;cursor:pointer;"/> <img border="0" src="images/readonly.png" title="غیر قابل تغییر" class="dontchange"/></td>
		  <td align="left" width="150px"> نام کالا :&nbsp;</td><td align="right" ><input class="textboxme" type="text" readonly id="name_kala" name="name_kala" value="'.$row2['name_kala'].'"/></td>
	      <td align="left"><span class="star">*</span> نوع زیرانبار :&nbsp;</td><td align="right">'.static_listbox("noe_ziranbar",$row2['noe_ziranbar'],"ziranbarArr",1,"class='text4' onchange=getZiranbar(this.value) disabled").'</td>
	      	<input type="hidden" name="noe_ziranbar" value='.$row2['noe_ziranbar'].'/>
		  <td align="left"><span class="star">*</span>  نام زیرانبار :&nbsp;</td><td align="right">'.listbox("code_ziranbar",$row2['code_ziranbar'],"code_ziranbar","name_ziranbar","list_sardkhane_detail","noe_ziranbar=".$row2['noe_ziranbar']." AND code_ostan=".$row2['code_ostan']." AND code_anbar=".$row2['code_anbar']."","class='text4' disabled").'
		   <input type="hidden" name="code_ziranbar" value='.$row2['code_ziranbar'].'/>
		  </td> 
		 </tr>
		 <tr>
	       <td align="left"><span class="star">*</span> کد کشور  :&nbsp;</td><td align="right"><input class="textboxme2 textbox50" type="text" readonly name="code_keshvar" value="'.$row2['code_keshvar'].'" />  <img border="0" src="images/readonly.png" title="غیر قابل تغییر" class="dontchange"/></td>
	  	   <td align="left"> نام کشور :&nbsp;</td><td align="right" ><input class="textboxme" type="text" readonly id="name_keshvar" name="name_keshvar" value="'.$row2['name_keshvar'].'"/></td>
	       <td align="left"><span class="star">*</span> کد تولیدکننده  :&nbsp;</td><td align="right"><input class="textboxme2" type="text" name="code_tolidkonande" value="'.$row2['code_tolidkonande'].'" readonly/>  <img border="0" src="images/readonly.png" title="غیر قابل تغییر" class="dontchange"/>
	      </td>
          <td align="left"> نام تولیدکننده :&nbsp;</td><td align="right" ><input class="textboxme2" type="text" readonly id="name_tolidkonande" name="name_tolidkonande" value="'.$row2['name_tolidkonande'].'" /></td>
         </tr>
 		 <tr>
		  <td  align="left"><span class="star">*</span> تاریخ تولید شمسی  :&nbsp;</td>
		  <td align="right" colspan="3">
		        <span class="star">*</span> سال : <input class="textboxme2" type="text" name="sal_tolid_shamsi" value="'.$row2['sal_tolid_shamsi'].'" maxlength="4" readonly style="width:40px;"/>
		 	    <span class="star">*</span> ماه : '.static_listbox("mah_tolid_shamsi",$row2['mah_tolid_shamsi'],"mahshamsiArr",1,"class='text4' disabled").'
				  <input type="hidden" name="mah_tolid_shamsi" value='.$row2['mah_tolid_shamsi'].'/>
				<span class="star">*</span> روز : <input class="textboxme2" type="text" name="rouz_tolid_shamsi" value="'.$row2['rouz_tolid_shamsi'].'" maxlength="2" readonly style="width:40px;"/>
		        <img border="0" src="images/readonly.png" title="غیر قابل تغییر" class="dontchange"/>
		  </td>
		  <td align="left"><span class="star">*</span> تاریخ ماندگاری :&nbsp;</td><td align="right" >'.listboxMe("code_mandegari_show",$row2['code_mandegari'],"code_mandegari","sharh_mandegari","tarikh_mandegari","","class='text4' disabled").'
		  	<input type="hidden" name="code_mandegari" value="'.$row2['code_mandegari'].'" >
		  </td>
		  <!--<td align="left"> انتخاب نرخ :&nbsp;</td><td align="right"> 
	       <input type="hidden" name="GheymatDetailID" value="'.$row2['Mo_GheymatDetailID'].'"/>
	       <input type="text" readonly class="textboxme" name="gd_fee" value="'.$row2['Gd_Fee'].'" style="width:50px" onfocus="return mablaghRiali(document.myform.mojody_khales_aval.value,this.value);"/>';
		   include("img_helpnerkh.php");
		   echo'
		  </td>
          <td align="left"> مبلغ :&nbsp;</td><td align="right"><input type="text" class="textboxme2" readonly name="mablagh_mojodyaval" value="'.$row2['mablagh_mojodyaval'].'""/></td>-->';
		  
		  if($row2['code_bastebandy']==1)//کارتنی
		  echo'<td align="left"><span class="star">*</span> کد کارتن :&nbsp;</td><td align="right"><input type="text" class="textboxme2" name="code_karton" id="code_karton" value="'.$row2['code_karton'].'" readonly/> <img border="0" src="images/readonly.png" title="غیر قابل تغییر" class="dontchange"/>
	           <td align="left"> وزن کارتن :&nbsp;</td><td align="right"><input class="textboxme2" type="text" readonly name="vazn_karton_this" id="vazn_karton_this" value="'.$row2['vazn_karton_this'].'"/></td>';
          if($row2['code_bastebandy']==2)//قوطی
		  echo'<td align="left"><span class="star">*</span> کد قوطی :&nbsp;</td><td align="right"><input type="text" class="textboxme2" name="code_karton" id="code_karton" value="'.$row2['code_karton'].'" readonly/> <img border="0" src="images/readonly.png" title="غیر قابل تغییر" class="dontchange"/>
	           <td align="left"> وزن قوطی :&nbsp;</td><td align="right"><input class="textboxme2" type="text" readonly name="vazn_karton_this" id="vazn_karton_this" value="'.$row2['vazn_karton_this'].'"/></td>';
  
		  echo'			   
		 </tr>
		 <tr>';
		  //IF(($row2['code_bastebandy']==2)OR($row2['code_kala']==50))$foruchField='dad_tedad_khanbar';
		  //ELSE $foruchField='dad_vazn_khanbar';
		  //$sold_this_id_without_ebtal=$db->get_from_where("SUM($foruchField)","sell.dm_anbar_det","dad_anbar_id=$id_");
		  
		  $sold_this_id_without_ebtal=sold_this_id($id_,$row2['code_bastebandy'],$row2['code_kala']);
		  $ebtal_this_id=$db->get_from_where("SUM(deh_amount)","sell.dm_ebtal_hdet","deh_anbar_id=$id_");
		  $sold_this_id=$sold_this_id_without_ebtal-$ebtal_this_id;
		  // IF($row2['code_bastebandy']==2)$havaleField='tedad_karton_h_d';
		  // ELSE IF($row2['code_kala']==50)$havaleField='tedad_shane_h_d';	  
	      // ELSE $havaleField='vazn_khales_h_d';
		  // $tahvily_detail=$db->get_from_where("SUM($havaleField)","meat.havale_detail","id_mojody=$id_ AND status=0 AND dad_id!=''");
		  $tahvily_detail=tahvily_az_forush_detail($id_,$row2['code_bastebandy'],$row2['code_kala']);
		  
		  $mande_az_detail_forush=$sold_this_id-$tahvily_detail;
		  IF($row2['code_bastebandy']==2) {$meghdar_mojaz=$tedad_karton-$mande_az_detail_forush;}
		  ELSE IF(($row2['code_kala']==50)OR($row2['code_kala']==54)) {$meghdar_mojaz=$tedad_shane-$mande_az_detail_forush;}
	      ELSE {$meghdar_mojaz=$mojody_khales-$mande_az_detail_forush;}
		  echo'
		   <td align="left"> مقدار فروخته شده :&nbsp;</td><td align="right"><input class="textboxme2" type="text" readonly name="sold_this_id"  value="'.$sold_this_id.'"/></td>
           <td align="left"> مقدار فروخته شده در فیلد :&nbsp;</td><td align="right"><input class="textboxme2" type="text" name="khales_sold"  value="'.$row2['khales_sold'].'"/></td>
           <td align="left"> مقدار تحویلی :&nbsp;</td><td align="right"><input class="textboxme2" type="text" readonly name="tahvily_detail" value="'.round($tahvily_detail,3).'"/></td>
           <td align="left"> مقدار مانده از فروش :&nbsp;</td><td align="right"><input class="textboxme2" type="text" readonly name="mande_az_detail_forush" value="'.round($mande_az_detail_forush,3).'"/></td>
		 </tr>
		 <tr><td align="left"> مقدار مجاز موجودی :&nbsp;</td><td align="right"><input class="textboxme2" type="text" readonly name="meghdar_mojaz" value="'.round($meghdar_mojaz,3).'"/></td></tr>
		 <tr>
         <td colspan="10">
	      <fieldset>
	      <legend>مقادیر موجودی</legend>
	       <table width="100%">';
			if(SuperUser())
            {
			 if($row2['code_bastebandy']==1)//کارتنی
			 {echo'
		       <tr>
		        <td align="left" colspan="2" style="font-weight:bold;">مقادیر موجودی اول دوره </td>
	            <td align="left"><span class="star">*</span> تعداد کارتن :&nbsp;</td><td align="right"><input class="textboxme2" type="text" name="tedad_karton_aval" value="'.$row2['tedad_karton_aval'].'" onfocus="return sumkarton()" onblur="return sumkarton()" onkeypress="return isNumber(event)"/> <img border="0" src="images/Info1.png" title="لطفا در تغییر دقت کنید این کالا در سایر فرم ها استفاده شده است" onmouseOver="this.src=\'images/Info_h.png\'" onmouseOut="this.src=\'images/Info1.png\'" style="width:16px;height:16px;cursor:pointer"/></td>';
		        IF(($row2['code_kala']==50)OR($row2['code_kala']==54))echo'<td align="left"> تعداد شانه :&nbsp;</td><td align="right"><input class="textboxme2" readonly type="text" name="tedad_shane_aval" value="'.$row2['tedad_shane_aval'].'"/></td>';
		        echo'
				<td align="left"> مجموع وزن کارتن ها :&nbsp;</td><td align="right"><input class="textboxme2" readonly type="text" name="sum_karton_this" value="'.round($row2['sum_karton_this'],3).'" onfocus="return sumkarton()"/></td>	
	            <td align="left"><span class="star">*</span> مقدار ناخالص :&nbsp;</td><td align="right"><input class="textboxme2" type="text" name="mojody_nakhales_aval" value="'.round($row2['mojody_nakhales_aval'],3).'" onblur="return vazn_khales_aval(),set_mojody();" onfocus="return vazn_khales_aval(),set_mojody();" onKeydown="return PressfloatOnly(event,this)"/> <img border="0" src="images/Info1.png" title="لطفا در تغییر دقت کنید این کالا در سایر فرم ها استفاده شده است" onmouseOver="this.src=\'images/Info_h.png\'" onmouseOut="this.src=\'images/Info1.png\'" style="width:16px;height:16px;cursor:pointer"/></td>
		    	 <td align="left"> مقدار خالص :&nbsp;</td><td align="right"><input class="textboxme2" readonly type="text" name="mojody_khales_aval" value="'.round($row2['mojody_khales_aval'],3).'" onfocus="return vazn_khales_aval()" onblur="return set_mojody();"/></td>
	           </tr>
		       <tr>
		        <td align="left" colspan="2" style="font-weight:bold;">مقادیر موجودی فعلی</td>
	            <td align="left"> تعداد کارتن :&nbsp;</td><td align="right"><input class="textboxme2" type="text" name="tedad_karton" value="'.$tedad_karton.'" readonly/></td>';
	            IF(($row2['code_kala']==50)OR($row2['code_kala']==54))echo'<td align="left"> تعداد شانه :&nbsp;</td><td align="right"><input class="textboxme2" readonly type="text" name="tedad_shane" value="'.$tedad_shane.'"/></td>';
				ELSE echo'<td colspan="2"></td>';
		    	echo'
				<td align="left"> مقدار ناخالص :&nbsp;</td><td align="right"><input class="textboxme2" type="text"  name="mojody_nakhales" value="'.round($mojody_nakhales,3).'" readonly/></td>
		    	<td align="left"> مقدار خالص :&nbsp;</td><td align="right"><input class="textboxme2" type="text"  name="mojody_khales" value="'.round($mojody_khales,3).'" readonly/></td>
	           </tr>
			   <tr>
		        <td align="left" colspan="2" style="font-weight:bold;">مقادیر موجودی فعلی در فیلد</td>
	            <td align="left"> تعداد کارتن :&nbsp;</td><td align="right"><input class="textboxme2" type="text" name="tedad_karton" value="'.$row2['tedad_karton'].'" /> <img border="0" src="images/Info1.png" title="لطفا در تغییر دقت کنید این کالا در سایر فرم ها استفاده شده است" onmouseOver="this.src=\'images/Info_h.png\'" onmouseOut="this.src=\'images/Info1.png\'" style="width:16px;height:16px;cursor:pointer"/></td>';
	            IF(($row2['code_kala']==50)OR($row2['code_kala']==54))echo'<td align="left"> تعداد شانه :&nbsp;</td><td align="right"><input class="textboxme2" readonly type="text" name="tedad_shane" value="'.$row2['tedad_shane'].'"/></td>';
				ELSE echo'<td colspan="2"></td>';
		    	echo'
		    	<td align="left"> مقدار ناخالص :&nbsp;</td><td align="right"><input class="textboxme2" type="text"  name="mojody_nakhales" value="'.round($row2['mojody_nakhales'],3).'" /></td>
		    	<td align="left"> مقدار خالص :&nbsp;</td><td align="right"><input class="textboxme2" type="text"  name="mojody_khales" value="'.round($row2['mojody_khales'],3).'" /></td>
	           </tr>';    

			 }
			 else if($row2['code_bastebandy']==2)//قوطی
			 {echo'
		       <tr>
		        <td align="left" colspan="2" style="font-weight:bold;">مقادیر موجودی اول دوره </td>
	            <td align="left"><span class="star">*</span> تعداد قوطی :&nbsp;</td><td align="right"><input class="textboxme2 textbox50" type="text" name="tedad_karton_aval" value="'.$row2['tedad_karton_aval'].'" onfocus="return sumghooti()" onblur="return sumghooti()" onkeypress="return isNumber(event)"/> <img border="0" src="images/Info1.png" title="لطفا در تغییر دقت کنید این کالا در سایر فرم ها استفاده شده است" onmouseOver="this.src=\'images/Info_h.png\'" onmouseOut="this.src=\'images/Info1.png\'" style="width:16px;height:16px;cursor:pointer"/></td>
		    	 <td align="left"> مقدار خالص :&nbsp;</td><td align="right"><input class="textboxme2" readonly type="text" name="mojody_khales_aval" value="'.round($row2['mojody_khales_aval'],3).'" onfocus="return vazn_khales_aval()" onblur="return set_mojody();"/></td>
	           </tr>
	           <tr>
		        <td align="left" colspan="2" style="font-weight:bold;">مقادیر موجودی فعلی </td>
	            <td align="left"> تعداد قوطی :&nbsp;</td><td align="right"><input class="textboxme2" type="text" name="tedad_karton" value="'.$tedad_karton.'" readonly/></td> 
		    	<td align="left"> مقدار خالص :&nbsp;</td><td align="right"><input class="textboxme2" type="text"  name="mojody_khales" value="'.round($mojody_khales,3).'" readonly/></td>
	           </tr>
			   <tr>
		        <td align="left" colspan="2" style="font-weight:bold;">مقادیر موجودی فعلی در فیلد </td>
	            <td align="left"> تعداد قوطی :&nbsp;</td><td align="right"><input class="textboxme2" type="text" name="tedad_karton" value="'.$row2['tedad_karton'].'" onkeypress="return isNumber(event)"/> <img border="0" src="images/Info1.png" title="لطفا در تغییر دقت کنید این کالا در سایر فرم ها استفاده شده است" onmouseOver="this.src=\'images/Info_h.png\'" onmouseOut="this.src=\'images/Info1.png\'" style="width:16px;height:16px;cursor:pointer"/></td>
		    	<td align="left"> مقدار خالص :&nbsp;</td><td align="right"><input class="textboxme2" type="text"  name="mojody_khales" value="'.round($row2['mojody_khales'],3).'" onKeydown="return PressfloatOnly(event,this)"/></td>
	           </tr>';
			 }
			 else //لاشه و سایر
			 {echo'
		       <tr>
		        <td align="left" colspan="2" style="font-weight:bold;">مقادیر موجودی اول دوره </td>
	            <td align="left"><span class="star">*</span> تعداد :&nbsp;</td><td align="right"><input class="textboxme2 textbox50" type="text" name="tedad_karton_aval" value="'.$row2['tedad_karton_aval'].'" onkeypress="return isNumber(event)"/> <img border="0" src="images/Info1.png" title="لطفا در تغییر دقت کنید این کالا در سایر فرم ها استفاده شده است" onmouseOver="this.src=\'images/Info_h.png\'" onmouseOut="this.src=\'images/Info1.png\'" style="width:16px;height:16px;cursor:pointer"/></td>';
		    	if(($row2['code_bastebandy']!=5)AND($row2['code_bastebandy']!=6)) echo'<td align="left"> مقدار خالص :&nbsp;</td><td align="right"><input class="textboxme2" type="text" name="mojody_khales_aval" value="'.round($row2['mojody_khales_aval'],3).'"  onKeydown="return PressfloatOnly(event,this)"/></td>';
	            echo'
			   </tr>
	           <tr>
		        <td align="left" colspan="2" style="font-weight:bold;">مقادیر موجودی فعلی </td>
	            <td align="left"> تعداد :&nbsp;</td><td align="right"><input class="textboxme2" type="text" name="tedad_karton" value="'.$tedad_karton.'" readonly/></td>'; 
		    	if(($row2['code_bastebandy']!=5)AND($row2['code_bastebandy']!=6)) echo'<td align="left"> مقدار خالص :&nbsp;</td><td align="right"><input class="textboxme2" type="text"  name="mojody_khales" value="'.round($mojody_khales,3).'" readonly/></td>';
	            IF($row2['code_kala']==55)
                {
				 echo'
				 <td align="left" colspan="2" style="font-weight:bold;">تعداد جوجه</td>
				 <td align="right"><input class="textboxme2" type="text"  name="tedad_joje" value="'.virgul($tedad_joje).'" readonly/></td>';	
				}					
				echo'
			   </tr>
			   <tr>
		        <td align="left" colspan="2" style="font-weight:bold;">مقادیر موجودی فعلی در فیلد </td>
	            <td align="left"> تعداد :&nbsp;</td><td align="right"><input class="textboxme2" type="text" name="tedad_karton" value="'.$row2['tedad_karton'].'" onkeypress="return isNumber(event)"/> <img border="0" src="images/Info1.png" title="لطفا در تغییر دقت کنید این کالا در سایر فرم ها استفاده شده است" onmouseOver="this.src=\'images/Info_h.png\'" onmouseOut="this.src=\'images/Info1.png\'" style="width:16px;height:16px;cursor:pointer"/></td>';
		    	if(($row2['code_bastebandy']!=5)AND($row2['code_bastebandy']!=6)) echo'<td align="left"> مقدار خالص :&nbsp;</td><td align="right"><input class="textboxme2" type="text"  name="mojody_khales" value="'.round($row2['mojody_khales'],3).'" onKeydown="return PressfloatOnly(event,this)"/></td>';
	            IF($row2['code_kala']==55)
                {
				 echo'
				 <td align="left" colspan="2" style="font-weight:bold;">تعداد جوجه</td>
				 <td align="right"><input class="textboxme2" type="text"  name="tedad_joje" value="'.virgul($row2['tedad_joje']).'" /></td>';	
				}
				echo'
			   </tr>';
			 }
			}			
			else//سایر کاربران
			{
			 if($row2['code_bastebandy']==1)//کارتن
			 {
			  echo'
			  <tr>
		       <td align="left" colspan="2" style="font-weight:bold;">مقادیر موجودی اول دوره </td>
	           <td align="left"><span class="star">*</span> تعداد کارتن :&nbsp;</td><td align="right"><input class="textboxme2 textbox50" readonly type="text" name="tedad_karton_aval" value="'.$row2['tedad_karton_aval'].'" onblur="return sumkarton()" onkeypress="return isNumber(event)"/></td>
		       <td align="left"> مجموع وزن کارتن ها :&nbsp;</td><td align="right"><input class="textboxme2" readonly type="text" name="sum_karton_this" value="'.round($row2['sum_karton_this'],3).'"/></td>	
	           <td align="left"><span class="star">*</span> مقدار ناخالص :&nbsp;</td><td align="right"><input class="textboxme2" readonly type="text" name="mojody_nakhales_aval" value="'.round($row2['mojody_nakhales_aval'],3).'" onKeydown="return PressfloatOnly(event,this)"/></td>
			   <td align="left"> مقدار خالص :&nbsp;</td><td align="right"><input class="textboxme2" readonly type="text" name="mojody_khales_aval" value="'.round($row2['mojody_khales_aval'],3).'" onKeydown="return PressfloatOnly(event,this)" onblur="return set_mojody();"/></td>
	          </tr>
	          <tr>
		       <td align="left" colspan="2" style="font-weight:bold;">مقادیر موجودی فعلی </td>
	           <td align="left"> تعداد کارتن :&nbsp;</td><td align="right"><input class="textboxme2" type="text" readonly name="tedad_karton" value="'.$tedad_karton.'"/></td>
	           <td colspan="2"></td>
			   <td align="left"> مقدار ناخالص :&nbsp;</td><td align="right"><input class="textboxme2" type="text" readonly name="mojody_nakhales" value="'.round($mojody_nakhales,3).'"/></td>
			   <td align="left"> مقدار خالص :&nbsp;</td><td align="right"><input class="textboxme2" type="text" readonly name="mojody_khales" value="'.round($mojody_khales,3).'"/></td>
	          </tr>';
			 }
			 else if($row2['code_bastebandy']==2)//قوطی
			 {
			  echo'
			  <tr>
		       <td align="left" colspan="2" style="font-weight:bold;">مقادیر موجودی اول دوره </td>
	           <td align="left"><span class="star">*</span> تعداد قوطی :&nbsp;</td><td align="right"><input class="textboxme2 textbox50" readonly type="text" name="tedad_karton_aval" value="'.$row2['tedad_karton_aval'].'" onblur="return sumghooti()" onkeypress="return isNumber(event)"/></td>
			   <td align="left"> مقدار خالص :&nbsp;</td><td align="right"><input class="textboxme2" readonly type="text" name="mojody_khales_aval" value="'.round($row2['mojody_khales_aval'],3).'" onKeydown="return PressfloatOnly(event,this)" onblur="return set_mojody();"/></td>
	          </tr>
	          <tr>
		       <td align="left" colspan="2" style="font-weight:bold;">مقادیر موجودی فعلی </td>
	           <td align="left"> تعداد قوطی :&nbsp;</td><td align="right"><input class="textboxme2" type="text" readonly name="tedad_karton" value="'.$tedad_karton.'"/></td>
			   <td align="left"> مقدار خالص :&nbsp;</td><td align="right"><input class="textboxme2" type="text" readonly name="mojody_khales" value="'.round($mojody_khales,3).'"/></td>
	          </tr>';
			 }
			 else //لاشه و سایر
			 {echo'
		       <tr>
		        <td align="left" colspan="2" style="font-weight:bold;">مقادیر موجودی اول دوره </td>
	            <td align="left"><span class="star">*</span> تعداد :&nbsp;</td><td align="right"><input class="textboxme2 textbox50" type="text" readonly name="tedad_karton_aval" value="'.$row2['tedad_karton_aval'].'"/></td>'; 
		    	if(($row2['code_bastebandy']!=5)AND($row2['code_bastebandy']!=6)) echo' <td align="left"> مقدار خالص :&nbsp;</td><td align="right"><input class="textboxme2" readonly type="text" name="mojody_khales_aval" value="'.round($row2['mojody_khales_aval'],3).'"/></td>';
	            echo'
			   </tr>
	           <tr>
		        <td align="left" colspan="2" style="font-weight:bold;">مقادیر موجودی فعلی </td>
	            <td align="left"> تعداد :&nbsp;</td><td align="right"><input class="textboxme2" type="text" name="tedad_karton" value="'.$tedad_karton.'" readonly/></td>';
		    	if(($row2['code_bastebandy']!=5)AND($row2['code_bastebandy']!=6)) echo'<td align="left"> مقدار خالص :&nbsp;</td><td align="right"><input class="textboxme2" type="text"  name="mojody_khales" value="'.round($mojody_khales,3).'" /></td>';
	            IF($row2['code_kala']==55)
                {
				 echo'
				 <td align="left" colspan="2" style="font-weight:bold;">تعداد جوجه</td>
				 <td align="right"><input class="textboxme2" type="text"  name="tedad_joje" value="'.virgul($tedad_joje).'" readonly/></td>';	
				}
				echo'
			   </tr>';
			 }
			}
			echo'
           </table>	
          </fieldset>
         </td>
        </tr>';
		}
		///////////////////////////////////////////////
		else//می توان ویرایش کرد
        { 		
		 //$default_baste=$row2['code_bastebandy'];
		 echo'
		 <tr><td align="left"><span class="star">*</span> نوع بسته بندی :&nbsp;</td><td align="right">'.listbox("code_bastebandy",$row2['code_bastebandy'],"code_bastebandy","sharh_bastebandy","bastebandy","1=1 ORDER BY sharh_bastebandy ASC","class='text4' disabled","").'</td></tr>
		 <input type="hidden" value='.$row2['code_bastebandy'].' name="code_bastebandy"/>
		 <tr>
	      <td align="left" width="150px"><span class="star">*</span> کد کالا :&nbsp;</td><td align="right"><input class="textboxme2 textbox50" type="text" name="code_kala" value="'.$row2['code_kala'].'" maxlength="3" onkeypress="return isNumber(event)" onKeyUp="F10desc(event)" onfocus="getDetailKala(this.value)" onblur="getDetailKala(this.value)"/>';
 	       include('img_helpkala.php');
		   echo'
		   </td>
		   <td align="left" width="150px"> نام کالا :&nbsp;</td><td align="right" ><input class="textboxme2" type="text" readonly id="name_kala" name="name_kala" value="'.$row2['name_kala'].'"/></td>
	       <td align="left"><span class="star">*</span>  نوع زیرانبار :&nbsp;</td><td align="right">'.static_listbox("noe_ziranbar",$row2['noe_ziranbar'],"ziranbarArr",1,"class='text4' onchange=getZiranbar(this.value)").'</td>
	       <td align="left"><span class="star">*</span>  نام زیرانبار :&nbsp;</td><td align="right">'.listbox("code_ziranbar",$row2['code_ziranbar'],"code_ziranbar","name_ziranbar","list_sardkhane_detail","noe_ziranbar=".$row2['noe_ziranbar']." AND code_ostan=".$row2['code_ostan']." AND code_anbar=".$row2['code_anbar']."","class='text4'").'</td> 
		  </tr>
		  <tr>
	       <td align="left"><span class="star">*</span> کد کشور  :&nbsp;</td><td align="right"><input class="textboxme2 textbox50" type="text" name="code_keshvar" value="'.$row2['code_keshvar'].'" onkeypress="return isNumber(event)" onfocus="getDetailKeshvar(this.value);" onblur="getDetailKeshvar(this.value);"/>';
	  	    include('img_helpkeshvar.php');
	  	   echo'
	       </td>
	  	   <td align="left"> نام کشور :&nbsp;</td><td align="right" ><input class="textboxme2" type="text" readonly id="name_keshvar" name="name_keshvar" value="'.$row2['name_keshvar'].'"/></td>
	       <td align="left"><span class="star">*</span> کد تولیدکننده  :&nbsp;</td><td align="right"><input class="textboxme2 textbox50" type="text" name="code_tolidkonande" value="'.$row2['code_tolidkonande'].'" onkeypress="return isNumber(event)" onfocus="getDetailTolid(this.value);" onblur="getDetailTolid(this.value);"/>';
	  	    include('img_helptolid.php');
	  	   echo'
	      </td>
          <td align="left"> نام تولیدکننده :&nbsp;</td><td align="right" ><input class="textboxme2" type="text" readonly id="name_tolidkonande" name="name_tolidkonande" value="'.$row2['name_tolidkonande'].'" /></td>
         </tr>
         <tr>
		  <td align="left"><span class="star">*</span> تاریخ تولید شمسی  :&nbsp;</td>
		  <td align="right" colspan="3">
		       <span class="star">*</span> سال : <input class="textboxme2" type="text" name="sal_tolid_shamsi" value="'.$row2['sal_tolid_shamsi'].'" maxlength="4" onkeypress="return isNumber(event)" style="width:40px;"/>
				<img border="0" src="images/Info1.png" title="لطفاً سال موردنظر خود را در 4 رقم وارد نمایید" onmouseOver="this.src=\'images/Info_h.png\'" onmouseOut="this.src=\'images/Info1.png\'" style="width:16px;height:16px;cursor:pointer"/>
			   <span class="star">*</span> ماه : '.static_listbox("mah_tolid_shamsi",$row2['mah_tolid_shamsi'],"mahshamsiArr",1,"class='text4'").'
			   <span class="star">*</span> روز : <input class="textboxme2 textbox50" type="text" name="rouz_tolid_shamsi" value="'.$row2['rouz_tolid_shamsi'].'" maxlength="2" onkeypress="return isNumber(event)"/>
		  </td>
		  <td align="left"><span class="star">*</span> تاریخ ماندگاری :&nbsp;</td><td align="right" >'.listboxMe("code_mandegari",$row2['code_mandegari'],"code_mandegari","sharh_mandegari","tarikh_mandegari","","class='text4'").'</td>';
		 
          if($row2['code_bastebandy']==1)//کارتنی
		  {
		  echo'		  
	        <td align="left"><span class="star">*</span> کد کارتن :&nbsp;</td><td align="right"><input type="text" class="textboxme2 textbox50" name="code_karton" id="code_karton" value="'.$row2['code_karton'].'" onfocus="return getVaznKarton(this.value),sumkarton(),vazn_khales_aval(),set_mojody();" onblur="return getVaznKarton(this.value),sumkarton(),vazn_khales_aval(),set_mojody();" onkeypress="return isNumber(event)"/>';
	         include('img_helpkarton.php');
	        echo'
	        </td>
	        <td align="left"> وزن کارتن :&nbsp;</td><td align="right"><input class="textboxme2 textbox50" type="text" readonly name="vazn_karton_this" id="vazn_karton_this" value="'.$row2['vazn_karton_this'].'"/></td>      		
	       </tr>
	       <tr>
             <td colspan="10">
	          <fieldset>
	          <legend>مقادیر موجودی</legend>
	           <table width="100%">
	      	    <tr>
	             <td align="left" colspan="2" style="font-weight:bold;">مقادیر موجودی اول دوره </td>
	             <td align="left"><span class="star">*</span> تعداد کارتن :&nbsp;</td><td align="right"><input class="textboxme2 textbox50" type="text" name="tedad_karton_aval" value="'.$row2['tedad_karton_aval'].'" onfocus="return sumkarton()" onblur="return sumkarton()" onkeypress="return isNumber(event)"/></td>
	             <td align="left"> مجموع وزن کارتن ها :&nbsp;</td><td align="right"><input class="textboxme2" readonly type="text" name="sum_karton_this" value="'.round($row2['sum_karton_this'],3).'" onfocus="return sumkarton()"/></td>	
	             <td align="left"><span class="star">*</span> مقدار ناخالص :&nbsp;</td><td align="right"><input class="textboxme2" type="text" name="mojody_nakhales_aval" value="'.round($row2['mojody_nakhales_aval'],3).'" onblur="return vazn_khales_aval(),set_mojody();" onfocus="return vazn_khales_aval(),set_mojody();" onKeydown="return PressfloatOnly(event,this)"/></td>
	      	     <td align="left"> مقدار خالص :&nbsp;</td><td align="right"><input class="textboxme2" readonly type="text" name="mojody_khales_aval" value="'.round($row2['mojody_khales_aval'],3).'" onfocus="return vazn_khales_aval()" onblur="return set_mojody();"/></td>
	            </tr>
	            <tr>
	             <td align="left" colspan="2" style="font-weight:bold;">مقادیر موجودی فعلی fsf</td>
	             <td align="left"> تعداد کارتن :&nbsp;</td><td align="right"><input class="textboxme2" type="text" readonly name="tedad_karton" value="'.$tedad_karton.'"/></td>
	             <td colspan="2"></td>
	      	     <td align="left"> مقدار ناخالص :&nbsp;</td><td align="right"><input class="textboxme2" type="text" readonly name="mojody_nakhales" value="'.round($mojody_nakhales,3).'"/></td>
	      	     <td align="left"> مقدار خالص :&nbsp;</td><td align="right"><input class="textboxme2" type="text" readonly name="mojody_khales" value="'.round($mojody_khales,3).'"/></td>
	            </tr>
               </table>	
              </fieldset>
             </td>
            </tr>';
		    }
			else if($row2['code_bastebandy']==2)//قوطی
	        {echo'
	           <td align="left"><span class="star">*</span> کد قوطی :&nbsp;</td><td align="right"><input type="text" class="textboxme2 textbox50" name="code_karton" id="code_karton" value="'.$row2['code_karton'].'"  onfocus="getVaznGHooti(this.value)" onblur="getVaznGHooti(this.value)" onkeypress="return isNumber(event)"/>';
	         include('img_helpghooti.php');
	          echo'
	            </td>
	            <td align="left"> وزن قوطی :&nbsp;</td><td align="right"><input class="textboxme2 textbox50" type="text" readonly name="vazn_karton_this" value="'.$row2['vazn_karton_this'].'" id="vazn_karton_this" /></td>
			  </tr>
               <tr>
                <td colspan="10">
	             <fieldset>
	             <legend>مقادیر موجودی</legend>
	              <table width="50%" border="0">
	               <tr>
	        	    <td align="right" style="font-weight:bold;">مقادیر موجودی اول دوره </td>		   
                    <td align="left"><span class="star">*</span> تعداد قوطی :&nbsp;</td><td align="right"><input class="textboxme2" type="text" name="tedad_karton_aval" value="'.$row2['tedad_karton_aval'].'" onblur="return sumghooti(),setmojody_ghooti()" onkeypress="return isNumber(event)"/></td>
	                <td align="left"> مقدار خالص :&nbsp;</td><td align="right"><input class="textboxme2" readonly type="text" name="mojody_khales_aval" value="'.$row2['mojody_khales_aval'].'"/></td>
	        	   </tr>
	               <tr>
	        	    <td align="right" style="font-weight:bold;">مقادیر موجودی فعلی </td>
	                <td align="left"> تعداد قوطی :&nbsp;</td><td align="right"><input class="textboxme2" type="text" readonly name="tedad_karton" value="'.$tedad_karton.'"/></td>
	        	    <td align="left"> مقدار خالص :&nbsp;</td><td align="right"><input class="textboxme2" type="text" readonly name="mojody_khales" value="'.round($mojody_khales,3).'"/></td>
	        	   </tr>
                  </table>	
                 </fieldset>
                </td>
               </tr>';
             }
			 else //لاشه و سایر
			 {echo'
			  <tr>
               <td colspan="10">
	            <fieldset>
	            <legend>مقادیر موجودی</legend>
	             <table width="50%" border="0">
		          <tr>
		           <td align="left" colspan="2" style="font-weight:bold;">مقادیر موجودی اول دوره </td>
	               <td align="left"><span class="star">*</span> تعداد :&nbsp;</td><td align="right"><input class="textboxme2 textbox50" type="text" name="tedad_karton_aval" value="'.$row2['tedad_karton_aval'].'" onkeypress="return isNumber(event)"/></td>';
		    	   if(($row2['code_bastebandy']!=5)AND($row2['code_bastebandy']!=6)) echo' <td align="left"><span class="star">*</span> مقدار خالص :&nbsp;</td><td align="right"><input class="textboxme2" type="text" name="mojody_khales_aval" value="'.round($row2['mojody_khales_aval'],3).'" onblur="return setmojody_ghooti()" onKeydown="return PressfloatOnly(event,this)"/></td>';
	               echo'
				  </tr>
	              <tr>
		           <td align="left" colspan="2" style="font-weight:bold;">مقادیر موجودی فعلی </td>
	               <td align="left"> تعداد :&nbsp;</td><td align="right"><input class="textboxme2" type="text" name="tedad_karton" value="'.$tedad_karton.'" readonly/></td>'; 
		    	   if(($row2['code_bastebandy']!=5)AND($row2['code_bastebandy']!=6)) echo'<td align="left"> مقدار خالص :&nbsp;</td><td align="right"><input class="textboxme2" type="text"  name="mojody_khales" value="'.round($mojody_khales,3).'" readonly/></td>';
	               echo'
				  </tr>
				 </table>	
                </fieldset>
               </td>
              </tr>';
			 }
			echo'
	        <tr>
		     <!--<td align="left"> فی :&nbsp;</td><td align="right"> -->
		      <input type="hidden" name="Mo_GheymatDetailID" value="'.$Mo_GheymatDetailID.'"/>
	          <input type="hidden" class="textboxme2" name="fee_gheymat" value="'.$fee_gheymat.'" readonly/>
		     
             <td align="left"> مبلغ :&nbsp;</td><td align="right"><input type="text" class="textboxme2" readonly name="mablagh_mojodyaval" value="'.virgul($row2['mablagh_mojodyaval']).'""/></td>
		    </tr>';
		}//END else
		echo'	
	    <tr class="title">
         <td colspan="10" align="center">';
		 if(($exist_resid_detail)or($exist_resid_kala_detail)or($exist_havale)or($exist_havale_detail)or($exist_tadil)or($exist_mojody_befor))
		 {if(SuperUser())echo' <input class="buttonme" type="submit" name="Edit_x" id="sabt" value="ثبت تغييرات">';
		  else echo'';
		 }
		 else echo' <input class="buttonme" type="submit" name="Edit_x" id="sabt" value="ثبت تغييرات">';
		 echo'
          <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'">
         </td>
        </tr>
       </table>
	  </td>
     </tr>';
    }
	if ($Mode=="Search") //Search Mode
    {
	echo '
    <tr> 
	 <td width="99%" class="borderall" style="position:absolute;bottom:10px;left:0.5%;">	 
	  <table width="100%" bgcolor="#E9F7FD" align="center" cellpadding="0" cellspacing="0" >
	   <tr class="title"><td colspan="10" align="center">جستجوی موجودی کالا</td></tr>
	   <tr><td >&nbsp;</td></tr>
	   <tr>
	    <td align="left" width="150px"> کد کالا :&nbsp;</td><td align="right"><input class="textboxme2 textbox50" type="text" name="code_kala" value="'.$code_kala.'" maxlength="3" onkeypress="return isNumber(event)" onKeyUp="F10desc(event)" onfocus="getDetailKala(this.value)" onblur="getDetailKala(this.value)"/>';
 	     include('img_helpkala.php');
		echo'
		</td>
		<td align="left" width="150px"> شناسه موجودی :&nbsp;</td><td align="right" ><input class="textboxme2" type="text" id="id" name="id" value="'.$id.'"/></td>
        <td align="left"> گروه کالای اصلی :&nbsp;</td><td align="right">'.listbox("code_group_kala_top",$code_group_kala_top,"code_group_kala_top","name_group_kala_top","bzacc.group_kala_top","group_type_top=2","class='text4'").'</td>
	    <td align="left"> گروه کالا میانی :&nbsp;</td><td align="right">'.listbox("code_group_kala_middle",$code_group_kala_middle,"code_group_kala_middle","name_group_kala_middle","group_kala_middle order by name_group_kala_middle","","class='text4'").'</td>	   
	   </tr>
	   <tr>
	     <td align="left"> کد کشور  :&nbsp;</td><td align="right"><input class="textboxme2 textbox50" type="text" name="code_keshvar" value="'.$code_keshvar.'" onkeypress="return isNumber(event)" onfocus="getDetailKeshvar(this.value);" onblur="getDetailKeshvar(this.value);"/>';
		 include('img_helpkeshvar.php');
		echo'
		</td>
		<td align="left"> نام کشور :&nbsp;</td><td align="right" ><input class="textboxme2" type="text" readonly id="name_keshvar" name="name_keshvar" value="'.$name_keshvar.'"/></td>
	    <td align="left"> کد تولیدکننده  :&nbsp;</td><td align="right"><input class="textboxme2 textbox50" type="text" name="code_tolidkonande" value="'.$code_tolidkonande.'" onkeypress="return isNumber(event)" onfocus="getDetailTolid(this.value);" onblur="getDetailTolid(this.value);"/>';
		 include('img_helptolid.php');
		echo'
		</td>
        <td align="left"> نام تولیدکننده :&nbsp;</td><td align="right" ><input class="textboxme2" type="text" readonly id="name_tolidkonande" name="name_tolidkonande" value="'.$name_tolidkonande.'" /></td>
       </tr>
       <tr>	   
		<td align="left"> تاریخ تولید شمسی  :&nbsp;</td>
		<td align="right" colspan="3">
		        سال : <input class="textboxme2 textbox50" type="text" name="sal_tolid_shamsi" value="'.$sal_tolid_shamsi.'" maxlength="4" onkeypress="return isNumber(event)"/>
		       	<img border="0" src="images/Info1.png" title="لطفاً سال موردنظر خود را در 4 رقم وارد نمایید" onmouseOver="this.src=\'images/Info_h.png\'" onmouseOut="this.src=\'images/Info1.png\'" style="width:16px;height:16px;cursor:pointer"/>
			    ماه : '.static_listbox("mah_tolid_shamsi",$mah_tolid_shamsi,"mahshamsiArr",1,"class='text4'").'
			    روز : <input class="textboxme2 textbox50" type="text" name="rouz_tolid_shamsi" value="'.$rouz_tolid_shamsi.'" maxlength="2" onkeypress="return isNumber(event)"/>
		</td>
	    <td align="left"> تاریخ ماندگاری :&nbsp;</td><td align="right" >'.listbox("code_mandegari",$code_mandegari,"code_mandegari","sharh_mandegari","tarikh_mandegari","","class='text4'").'</td>
	    <td align="left"> کد کارتن :&nbsp;</td><td align="right"><input type="text" class="textboxme2 textbox50" name="code_karton" id="code_karton" value="'.$code_karton.'" onfocus="getVaznKarton(this.value)" onblur="getVaznKarton(this.value)" onkeypress="return isNumber(event)"/>';
		 include('img_helpkarton.php');
		echo'
		 وزن کارتن :&nbsp;<input class="textboxme2" type="text" readonly name="vazn_karton_this" id="vazn_karton_this" value="'.$vazn_karton_this.'"/></td>      		
	   </tr>
	   <tr>	
		<td align="left"> نام زیرانبار :&nbsp;</td><td align="right" >'.listbox_ziranbar("code_ziranbar",$code_ziranbar,"code_ziranbar","name_ziranbar","list_sardkhane_detail","1=1 AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' ORDER BY name_ziranbar ASC","class='text4'").'</td>
		<td align="left">دارای جزئیات فروش : &nbsp;</td><td align="right"><input type="checkbox" name="chkdetailforush" /></td>
       	<td align="left">نوع محموله :&nbsp;</td><td align="right">'.static_listbox("mahmule_type",$mahmule_type,"mahmuletypeArr",1,"class='text4'").'</td>
		<td align="left">شناسه عمومی کالا :&nbsp;</td><td align="right"><input class="textboxme" type="text" name="general_goods_id" value="'.$general_goods_id.'"/></td>	    
	   </tr>
	   <tr>
        <td colspan="10">
	     <fieldset>
	     <legend>مقادیر موجودی</legend>
	      <table width="100%">
	      <tr>
		    <td align="left" style="font-weight:bold;">مقادیر موجودی اول دوره </td>
            <td align="left"> تعداد :&nbsp;</td><td align="right"><input class="textboxme2" type="text" name="tedad_karton_aval" onkeypress="return isNumber(event)"/></td>
	        <td align="left">مقدار ناخالص :&nbsp;</td><td align="right"><input class="textboxme2" type="text" name="mojody_nakhales_aval" onKeydown="return PressfloatOnly(event,this)"/></td>
			<td align="left"> مقدار خالص :&nbsp;</td><td align="right"><input class="textboxme2" type="text" name="mojody_khales_aval" onKeydown="return PressfloatOnly(event,this)"/></td>
	       </tr>
           <tr>
		   	<td align="left" style="font-weight:bold;">مقادیر موجودی فعلی </td>
	        <td align="left"> تعداد :&nbsp;</td><td align="right"><input class="textboxme2" type="text" name="tedad_karton" "onkeypress="return isNumber(event)"/></td>
	        <td align="left"> مقدار ناخالص :&nbsp;</td><td align="right"><input class="textboxme2" type="text" name="mojody_nakhales"  onKeydown="return PressfloatOnly(event,this)"/></td>
	        <td align="left"> مقدار خالص :&nbsp;</td><td align="right"><input class="textboxme2" type="text" name="mojody_khales" onKeydown="return PressfloatOnly(event,this)"/></td>
		   </tr>
          </table>	
         </fieldset>
        </td>
       </tr>	   
	   <tr class="title">
        <td colspan="10" align="center">
		 <input type="submit" class="buttonme" name="Search_x" id="sabt" value="جستجو">
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
'.$message.'
</form>
	<!--<script type="text/javascript">
				var objCal1 = new AMIB.persianCalendar( "pcal1" );
	</script>-->

</body>
</html>';	
?>