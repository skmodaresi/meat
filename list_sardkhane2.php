<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="list_sardkhane.php";
$TableName="list_sardkhane";
$titr='سردخانه ها';
$right_ins=0;$right_edt=0;$right_edt_activate=0;$right_del=0;$right_detail=0;$right_owner=0;$right_edt_zarfiyat_tb=0;$right_edt_chkhavaleshow=0;
if (right(11)) $right_ins=1;
if (right(12)) $right_edt=1;
if (right(13)) $right_edt_activate=1;
if (right(21)) $right_edt_shenase=1;
if (right(22)) $right_edt_zarfiyat_tb=1;
//if (right(22)) $right_edt_chkhavaleshow=1;
//if (right(13)) $right_del=1;
if (right(14)) $right_detail=1;
if (right(18)) $right_owner=1;
IF(($_SESSION['mt_all_ostan']==1)or(SuperUser())) $Condition="";
ELSE  $Condition="AND code_ostan='$mt_gl_code_ostan'";
echo'
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>'.$titr.'</title>
<link href="styles.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="styles/jquery-ui-1.8.14.css" />
<link rel="stylesheet" type="text/css" href="styles/easyui.css">
<link rel="stylesheet" type="text/css" href="styles/easyui-rtl.css"> 
<script type="text/javascript" src="functions.js"></script>
<script type="text/javascript" src="scripts/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="scripts/jquery.ui.datepicker-cc.all.min.js"></script>
<script type="text/javascript" src="scripts/jquery.easyui.min.js"></script>
<script type="text/javascript" src="scripts/easyui-rtl.js"></script> 
<script type="text/javascript">
 function enterIE()
 {
   if(window.event.keyCode == 13 && window.event.srcElement.id != \'sabt\')
   window.event.keyCode = 9;
 }
 $(document).ready(function() {		
		<!--تغییر براساس وضعیت پیمانکار-->
        $("[name=status_peymankar]").bind("change", function (){
        if($(this).val() == 1)<!--پیمانکار دارد --> 
	    {
	        $("#loading").fadeIn("fast");
	        $(".vazayefshow").show();
	        $("#loading").fadeOut("fast");	
        }
        else
		{
		 	$("#loading").fadeIn("fast");
	        $(".vazayefshow").hide();
	        $("#loading").fadeOut("fast");	
		}
      });
	  <!--تغییر براساس اتصال به سیستم توزین-->
	    $("[name=chktozin]").bind("change", function (){
        if($(this).val() == 0)
	    {
	        $("#loading").fadeIn("fast");
	        $(".chapShow").hide();
	        $("#loading").fadeOut("fast");	
        }
        else
		{
		 	$("#loading").fadeIn("fast");
	        $(".chapShow").show();
	        $("#loading").fadeOut("fast");	
		}
      });
	  <!-- در ویرایش اگر تیک خورده نمایش بده-->
	   if($("[name=chktozin]").val()==0) $(".chapShow").hide();
	   else $(".chapShow").show();
	   
	   $(".datepicker6").datepicker({
        defaultDate:"'.$today.'",
		showOn: "button",
        buttonImage: "styles/images/calendar5.png",
        buttonImageOnly: true,
		showButtonPanel: true,
	    changeMonth: true,
	    changeYear: true,
    });
});
</script>
</head>';
if(!(isset($Mode))) $Mode='';
/*************SEARCH BUTTON******/// جستجوي اطلاعات
if(isset($open_filter))
{ $open_filter="";
  $_SESSION['mt_search_li_anbar']="";
  $_SESSION['mt_CondOwner']="";
} 
if(isset($Search_x))
{
 $Mode='';
 $Search_x="";
 $_SESSION['mt_CondOwner']="";
 $temp=""; 
 if($id)         $temp.=" and T.id='$id'";
 if($code_anbar)         $temp.=" and code_anbar LIKE '%$code_anbar%'";
 if($shenase_meli_anbar) $temp.=" and shenase_meli_anbar LIKE '%$shenase_meli_anbar%'";
 if($shenase_yekta)      $temp.=" and shenase_yekta LIKE '%$shenase_yekta%'";
 if($name_anbar)         $temp.=" and name_anbar LIKE '%$name_anbar%'";
 if($code_ostan)         $temp.=" and code_ostan LIKE '$code_ostan'";
 if($noe_malekiyat)      $temp.=" and noe_malekiyat LIKE '$noe_malekiyat'";
 if($status_peymankar)   $temp.=" and status_peymankar LIKE '$status_peymankar'";
 if($vazayef_peymankar)  $temp.=" and vazayef_peymankar LIKE '$vazayef_peymankar'";
 if($shenase_peymankar)  $temp.=" and shenase_peymankar LIKE '%$shenase_peymankar%'";
 if($name_peymankar)     $temp.=" and name_peymankar LIKE '%$name_peymankar%'";
 if($activate)           $temp.=" and activate LIKE '$activate'";
 if($situation_type!=-1) $temp.=" and situation_type LIKE '$situation_type'";
 //if($chkwebservice)      $temp.=" and chkwebservice=1";
 if($chkwebservice!=-1)      $temp.=" and chkwebservice LIKE '$chkwebservice'";
 if($chkforush)          $temp.=" and chkforush=1";
 if($chktozin)           $temp.=" and chktozin=1";
 if($postal_code)        $temp.=" and postal_code LIKE '%$postal_code%'";
 if($warehouse_id)        $temp.=" and warehouse_id LIKE '%$warehouse_id%'";
 if($address_anbar)      $temp.=" and address_anbar LIKE '%$address_anbar%'";
 if($exist_owner==1)     $_SESSION['mt_CondOwner']="HAVING detailowner>0";
 if($exist_owner==0)     $_SESSION['mt_CondOwner']="HAVING detailowner=0";
 if ($temp){$PageNo=1;$_SESSION['mt_search_li_anbar']=$temp;} else $_SESSION['mt_search_li_anbar']="";
 }
/********************PAGING***********************/
if(isset($_POST['wRowPerPage'])) $RowPerPage=$_POST['wRowPerPage'];
if(!isset($RowPerPage)) $RowPerPage=8;
$res = mysql_query("SELECT *,
	     (SELECT COUNT(*) FROM list_sardkhane_detail l_a_d WHERE l_a_d.code_ostan=T.code_ostan AND l_a_d.code_anbar=T.code_anbar) detailcount,
         (SELECT COUNT(*) FROM list_sardkhane_owner l_a_w WHERE l_a_w.code_ostan=T.code_ostan AND l_a_w.code_anbar=T.code_anbar) detailowner,
	     (SELECT name_ostan FROM ostan WHERE ostan.code_ostan=T.code_ostan) nameOstan
	     From $TableName T WHERE 1=1 ".$_SESSION['mt_search_li_anbar']." $Condition AND location_type=2 ".$_SESSION['mt_CondOwner']."");
	
$cnt =mysql_num_rows($res);
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
/******************** Insert- Edit- Delete ************/
/************اجازه براي ذخيره اطلاعات************/
function isPermitSave($c_anbar,$sh_m_a,$sh_yekta,$n_anbar,$c_acc,$c_ostan,$noe_malekiyat,$l_type,$zar,$zar_gh,$status_p,$vazayef,$si_type,$post_c)
{
 $flag=false;
 if(($noe_malekiyat!=5)AND(!($c_anbar and $n_anbar and $c_ostan and $l_type and $zar and $zar_gh and $status_p and $post_c)))//پر بودن فيلدها
 {
   $flag=false;
   echo"<script> alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!')</script>";
   return $flag;
 } 
 else $flag=true;
 if(($noe_malekiyat!=5)AND($si_type==1)and(!$sh_m_a)and(!$sh_yekta)and(!$c_acc))
 {
   $flag=false;
   echo"<script> alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!')</script>";
   return $flag;
 } 
 if(($noe_malekiyat!=5)AND($status_p==1)and(!($vazayef)))//انتخاب وظایف پیمانکار در حالت پیمانکار دارد
 {
   $flag=false;
   echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
   return $flag;
 } 
 else $flag=true;
 if(($noe_malekiyat!=5)AND((!justNumber($c_anbar)) or ($c_anbar<100) or ($c_anbar>300)))//صحت کد انبار
 {
   $flag=false;
   echo"<script>alert('فیلد کد انبار نامعتبر است')</script>";
   return $flag;
 }
 else $flag=true;
 if (($noe_malekiyat!=5)AND(($zar<100000) or ($zar>200000000)))//ظرفیت اسمی
 {
   $flag=false;
   echo"<script>alert('محدوده مجاز ظرفیت اسمی مابین 100000 تا 200000000 میباشد')</script>";
   return $flag;
 }
 else $flag=true;
 if (($noe_malekiyat!=5)AND($zar<$zar_gh))//ظرفیت قراردادی
 {
   $flag=false;
   echo"<script>alert('ظرفیت قراردادی بیشتر از ظرفیت اسمی وارد شده است')</script>";
   return $flag;
 }
 else $flag=true;
 if (($noe_malekiyat!=5)AND((!justNumber($post_c)) or (strlen($post_c)>10) or (strlen($post_c)<10) ))//صحت کدپستی
 {
   $flag=false;
   echo"<script>alert('کدپستی نامعتبر است')</script>";
   return $flag;
  }
 else $flag=true;
 IF(($noe_malekiyat!=5)AND($sh_yekta))//چک کردن شناسه یکتا دامپزشکی
 {
   //تکراری نبودن 
   $q11="SELECT * FROM list_sardkhane WHERE shenase_yekta='$sh_yekta'";
   $res11=mysql_query($q11);
   IF(mysql_num_rows($res11)>0){
      echo"<script>alert('این شناسه یکتا قبلا در سیستم سردخانه ثبت شده است!')</script>";
      $flag=false;
      return $flag;
   }
   ELSE
   { 
    $wsdl_shenase_url='http://10.7.234.53/agriwindows/unitservicesVer3.asmx?wsdl';
    header('Content-Type: text/html; charset=utf-8');
    $client=new SoapClient($wsdl_shenase_url);
    $params=array('userName'=>'poshtibani','Password'=>'93mimgE16','PartIDcode_'=>$sh_yekta,'UpdateDate'=>null);
    $result=$client->WS_G_1_4($params);
    $response=$result->WS_G_1_4Result;	

    $ErrorCode_yekta=$response->ErrorCode;
    $Message=$response->Message;
    IF($ErrorCode_yekta!=0)//ErrorCode:
    {
	  echo"<script>alert('".$Message."')</script>";
	  $flag=false;
	  return $flag;
    }
    else//شناسه یکتا درست است 
    {
	 $flag=true;
	 return $flag;
    }
  }
 }
 IF(($noe_malekiyat!=5)AND($post_c))//چک کردن کدپستی در وبسرویس
 {
  //تکراری نبودن کدپستی
  $q11="SELECT * FROM list_sardkhane WHERE postal_code=$post_c";
  $res11=mysql_query($q11);
  IF(mysql_num_rows($res11)>0){
      echo"<script>alert('این کدپستی تکراری است!')</script>";
      $flag=false;
      return $flag;
  }
  ELSE
  {
   $wsdl_postal_url='http://10.7.1.40/GetPostinfo/postServices.asmx?wsdl';
   header('Content-Type: text/html; charset=utf-8');
   $client=new SoapClient($wsdl_postal_url);
   $params=array('username'=>'agriDam','password'=>'3rt67HM','postalcode'=>$post_c);
   $result=$client->GetAddressByPostalCode($params);
   $response=$result->GetAddressByPostalCodeResult;
   $ErrorCode=$response->ErrorCode;
   $ErrorMessage=$response->ErrorMessage;
   IF($ErrorCode!=0)//ErrorCode:40 or 51
   {
	 //40:کدپستی یافت نشد
	 //51:فرمت کدپستی اشتباه است
	 echo"<script>alert('".$ErrorMessage."')</script>";
	 $flag=false;
	 return $flag;
   }
   else//کدپستی درست است  
   {
	 $flag=true;
	 return $flag;
   }
  }
 }
 if(($noe_malekiyat!=5)AND(!empty($c_anbar)))//تکراری نبودن کد انبار برای هر استان
 { 
    $code_a=make_pattern($c_anbar,3); 
    $q8="SELECT code_anbar FROM list_sardkhane WHERE code_anbar='$code_a' AND code_ostan='$c_ostan'";
    $res8=mysql_query($q8);
    if(mysql_num_rows($res8)>0){
    echo"<script>alert('اين کد انبار قبلاً برای این استان ثبت شده است!')</script>";
    $flag=false;
    return $flag;
   }
  else $flag=true;
 }
 else $flag=true; 
 if(($noe_malekiyat!=5)AND(($si_type==1)and(!justNumber($sh_m_a))))//عدد بودن شناسه ملی انبار
 {
   $flag=false;
   echo"<script>alert('فیلد شناسه یکتا سردخانه نامعتبر است')</script>";
   return $flag;
 }
 else $flag=true; 
 if(($noe_malekiyat!=5)AND(!empty($n_anbar)))//تکراري نبودن نام انبار
 {
   $q9="SELECT * FROM list_sardkhane WHERE name_anbar='$n_anbar' AND code_ostan='$c_ostan'";
   $res9=mysql_query($q9);
   if(mysql_num_rows($res9)>0){
     echo"<script>alert('این نام انبار قبلاً برای این استان ثبت شده است !')</script>";
     $flag=false;
     return $flag;
  }
 else $flag=true;
 }
 else $flag=true;
 if(($noe_malekiyat!=5)AND(($si_type==1)and((!justNumber($c_acc))or(strlen($c_acc)>6)or(strlen($c_acc)<6))))//صحت کد حسابداری
 {
   $flag=false;
   echo"<script>alert('فيلد کد حسابداری نامعتبر است')</script>";
   return $flag;
 }
 else $flag=true;
 if(($noe_malekiyat!=5)AND(!empty($c_acc)))//تکراری نبودن کد حسابداری
 { 
    $q10="SELECT code_acc FROM list_sardkhane WHERE code_acc='$c_acc'";
    $res10=mysql_query($q10);
    if(mysql_num_rows($res10)>0){
    echo"<script>alert('اين کد حسابداری قبلاً ثبت شده است!')</script>";
    $flag=false;
    return $flag;
   }
  else $flag=true;
 }
 else $flag=true;  
return $flag;
}
/**********اجازه براي ويرايش اطلاعات********/
function isPermitEdit($c_anbar,$sh_m_a,$sh_yekta,$n_anbar,$c_acc,$c_ostan,$noe_malekiyat,$l_type,$zar,$zar_gh,$status_p,$vazayef,$si_type,$post_c,$post_error_code,$partid_error_code,$this_id)
{
  $flag=false;
  if(($noe_malekiyat!=5)AND(!($c_anbar and $n_anbar and $c_ostan and $l_type and $zar and $zar_gh and $status_p and $post_c)))//پر بودن فيلدها
  {
   $flag=false;
   echo"<script> alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!')</script>";
   return $flag;
  } 
  else $flag=true;
  if(($noe_malekiyat!=5)AND(($si_type==1)and(!$sh_m_a)and(!$sh_yekta)and(!$c_acc)))
  {
   $flag=false;
   echo"<script> alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!')</script>";
   return $flag;
  } 
  if(($noe_malekiyat!=5)AND(($status_p==1)and(!($vazayef))))//انتخاب وظایف پیمانکار در حالت پیمانکار دارد
  {
   $flag=false;
   echo"<script>window.alert('لطفا فیلدهای ستاره دار را تکمیل نمایید!');</script>";
   return $flag;
  } 
  else $flag=true;
  if (($noe_malekiyat!=5)AND((!justNumber($c_anbar)) or ($c_anbar<100) or ($c_anbar>300)))//صحت کد انبار
  {
   $flag=false;
   echo"<script>alert('فیلد کد انبار نامعتبر است')</script>";
   return $flag;
  }
  else $flag=true;
  if (($noe_malekiyat!=5)AND(($zar<100000) or ($zar>200000000)))//ظرفیت اسمی
  {
   $flag=false;
   echo"<script>alert('محدوده مجاز ظرفیت اسمی مابین 100000 تا 200000000 میباشد')</script>";
   return $flag;
  }
  else $flag=true;
  if (($noe_malekiyat!=5)AND($zar<$zar_gh))//ظرفیت قراردادی
  {
   $flag=false;
   echo"<script>alert('ظرفیت قراردادی بیشتر از ظرفیت اسمی وارد شده است')</script>";
   return $flag;
  }
  else $flag=true;
  if (($noe_malekiyat!=5)AND((!justNumber($post_c)) or (strlen($post_c)>10) or (strlen($post_c)<10) ))//صحت کدپستی
  {
   $flag=false;
   echo"<script>alert('کدپستی نامعتبر است')</script>";
   return $flag;
  }
  else $flag=true;
  IF(($noe_malekiyat!=5)AND($sh_yekta))//چک کردن شناسه یکتا دامپزشکی
  {
   //تکراری نبودن 
   $q11="SELECT * FROM list_sardkhane WHERE shenase_yekta='$sh_yekta' AND id!=$this_id";
   $res11=mysql_query($q11);
   IF(mysql_num_rows($res11)>0){
	  echo"<script>alert('این شناسه یکتا قبلا در سیستم سردخانه ثبت شده است!')</script>";
      $flag=false;
      return $flag;
   }
   ELSE IF($partid_error_code!=0)
   { 
	$wsdl_shenase_url='http://10.7.234.53/agriwindows/unitservicesVer3.asmx?wsdl';    
	header('Content-Type: text/html; charset=utf-8');
    $client=new SoapClient($wsdl_shenase_url);
    $params=array('userName'=>'poshtibani','Password'=>'93mimgE16','PartIDcode_'=>$sh_yekta,'UpdateDate'=>null);
    $result=$client->WS_G_1_4($params);
    $response=$result->WS_G_1_4Result;	

    $ErrorCode_yekta=$response->ErrorCode;
    $Message=$response->Message;
    IF($ErrorCode_yekta!=0)//ErrorCode:
    {
	  echo"<script>alert('".$Message."')</script>";
	  $flag=false;
	  return $flag;
    }
    else//شناسه یکتا درست است 
    {
	 $flag=true;
	 return $flag;
    }
   }
  }
  IF(($noe_malekiyat!=5)AND($post_c))//چک کردن کدپستی در وبسرویس
  {
   	//تکراری نبودن کدپستی
	$q11="SELECT * FROM list_sardkhane WHERE postal_code=$post_c AND id!=$this_id";
	$res11=mysql_query($q11);
    IF(mysql_num_rows($res11)>0){
      echo"<script>alert('این کدپستی تکراری است!')</script>";
      $flag=false;
      return $flag;
   }
   ELSE IF($post_error_code!=0)
   { 
    header('Content-Type: text/html; charset=utf-8');
    $Postcodes=array(0=>array('ClientRowID'=>1,'PostCode'=>$post_c));
    $params=array('ClientBatchID'=>1,'Postcodes'=>$Postcodes,'Signature'=>'');
    $encodedData = json_encode($params);
    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://sr-ajix.maj.ir/Services/NewGSBPostApiMethods/AddressByPostcode',
    CURLOPT_USERPWD => 'ajix_agridam:3rt67HM',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_SSL_VERIFYPEER=>false,
    CURLOPT_POSTFIELDS =>$encodedData,
    CURLOPT_HTTPHEADER => array('Content-Type: application/json','Authorization: Basic YWppeF9hZ3JpZGFtOjNydDY3SE0='),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    $response = json_decode($response,true); # آرایه
	$ResCode=$response['result']['data']['ResCode'];
    $ResMsg=$response['result']['data']['ResMsg'];
	$ErrorCode1=$response['result']['data']['Data'][0]['Errors'][0]['ErrorCode'];
	$ErrorMessage=$response['result']['data']['Data'][0]['Errors'][0]['ErrorMessage']; 
	 IF($ResCode!=0)//ResCode:-6 or 12
     {	   
	    echo"<script>alert('".$ResMsg."'.'-'.'".$ErrorMessage."')</script>";
	    $flag=false;
	    return $flag;
     }
     else//کدپستی درست است  
     {
	    $flag=true;
	    return $flag;
     }   
   }	   
  }
  else $flag=true;
  if(($noe_malekiyat!=5)AND(!empty($c_anbar)))//تکراری نبودن کد انبار برای هر استان
  { 
   $code_a=make_pattern($c_anbar,3); 
   $q10="SELECT * FROM list_sardkhane WHERE code_anbar='$code_a' AND code_ostan='$c_ostan'";
   $res10=mysql_query($q10);
   $row10=mysql_fetch_assoc($res10);
   if((mysql_num_rows($res10)>0) and ($row10['id']!=$this_id)){
   echo"<script>alert('اين کد انبار قبلاً برای این استان ثبت شده است!')</script>";
   $flag=false;
   return $flag;
  }
  else $flag=true;
  }
  else $flag=true;
  if(($noe_malekiyat!=5)AND(($si_type==1)and(!justNumber($sh_m_a))))//عدد بودن شناسه ملی انبار
  {
   $flag=false;
   echo"<script>alert('فیلد شناسه یکتا سردخانه نامعتبر است')</script>";
   return $flag;
  }
  else $flag=true;  
  if(($noe_malekiyat!=5)AND(!empty($n_anbar)))//تکراري نبودن نام انبار
  {
    $q11="SELECT * FROM list_sardkhane WHERE name_anbar='$n_anbar' AND code_ostan='$c_ostan'";
    $res11=mysql_query($q11);
	$row11=mysql_fetch_assoc($res11);
    if((mysql_num_rows($res11)>0) and ($row11['id']!=$this_id)){
      echo"<script>alert('این نام انبار قبلاً برای این استان ثبت شده است !')</script>";
      $flag=false;
      return $flag;
    }
    else $flag=true;
  }
 else $flag=true;
 if(($noe_malekiyat!=5)AND(($si_type==1)and((!justNumber($c_acc))or(strlen($c_acc)>6)or(strlen($c_acc)<6))))//صحت کد حسابداری
 {
   $flag=false;
   echo"<script>alert('فيلد کد حسابداری نامعتبر است')</script>";
   return $flag;
 }
 else $flag=true;
 if(($noe_malekiyat!=5)AND(!empty($c_acc)))//تکراري نبودن کد حسابداری
 {
    $q13="SELECT * FROM list_sardkhane WHERE code_acc='$c_acc'";
    $res13=mysql_query($q13);
	$row13=mysql_fetch_assoc($res13);
    if((mysql_num_rows($res13)>0) and ($row13['id']!=$this_id)){
     echo"<script>alert('اين کد حسابداری قبلاً ثبت شده است!')</script>";
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
 $zarfiyat=intval($zarfiyat);
 if(isPermitSave($code_anbar,$shenase_meli_anbar,$shenase_yekta,trim($name_anbar),$code_acc,$code_ostan,$noe_malekiyat,$location_type,trim($zarfiyat),trim($zarfiyat_gharardadi),$status_peymankar,$vazayef_peymankar,$situation_type,$postal_code))
 {
   $Mode='';
   if ($chkforush=='on') $chkforush=1; else $chkforush=0;
   if ($chkmabadi=='on') $chkmabadi=1; else $chkmabadi=0;
   if ($chkwebservice=='on') $chkwebservice=1; else $chkwebservice=0;
   if ($chkhavaleshow=='on') $chkhavaleshow=1; else $chkhavaleshow=0;
   if($status_peymankar==2) $vazayef_peymankar=0;
   $name_anbar=str_replace("ي","ی",$name_anbar);
   $name_anbar=str_replace("ك","ک",$name_anbar);
   IF($noe_malekiyat!=5)
   {
	//وب سرویس شناسه یکتا
     $wsdl_shenase_url='http://10.7.234.53/agriwindows/unitservicesVer3.asmx?wsdl';
     header('Content-Type: text/html; charset=utf-8');
     $client=new SoapClient($wsdl_shenase_url);
     $params=array('userName'=>'poshtibani','Password'=>'93mimgE16','PartIDcode_'=>$shenase_yekta,'UpdateDate'=>null);
     $result=$client->WS_G_1_4($params);
     $response=$result->WS_G_1_4Result;
     $partid_error_code=$response->ErrorCode;
     $partid_message=$response->Message; 
     //وب سرویس کد پستی
	 //کدپستی قبلی-soap
     // $wsdl_postal_url='http://10.7.1.40/GetPostinfo/postServices.asmx?wsdl';
     // header('Content-Type: text/html; charset=utf-8');
     // $client=new SoapClient($wsdl_postal_url);
     // $params=array('username'=>'agriDam','password'=>'3rt67HM','postalcode'=>$postal_code);
     // $result=$client->GetAddressByPostalCode($params);
     // $response=$result->GetAddressByPostalCodeResult;
     // $ErrorCode=$response->ErrorCode;
     // $ErrorMessage=$response->ErrorMessage;
     //کدپستی جدید -curl
	    header('Content-Type: text/html; charset=utf-8');
   $Postcodes=array(0=>array('ClientRowID'=>1,'PostCode'=>$postal_code));
   $params=array('ClientBatchID'=>1,'Postcodes'=>$Postcodes,'Signature'=>'');
   $encodedData = json_encode($params);
   /////////////////////////CURL شروع کد ///////////////////////////////////
   $curl = curl_init();
   curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://sr-ajix.maj.ir/Services/NewGSBPostApiMethods/AddressByPostcode',
      CURLOPT_USERPWD => 'ajix_agridam:3rt67HM',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_SSL_VERIFYPEER=>false,
      CURLOPT_POSTFIELDS =>$encodedData,
      CURLOPT_HTTPHEADER => array('Content-Type: application/json','Authorization: Basic YWppeF9hZ3JpZGFtOjNydDY3SE0='),
      ));
    $response = curl_exec($curl);
    curl_close($curl);
    $response = json_decode($response,true); # آرایه

    $ResCode=$response['result']['data']['ResCode'];
    $ResMsg=$response['result']['data']['ResMsg'];
    $ErrorCode1=$response['result']['data']['Data'][0]['Errors'][0]['ErrorCode'];
    $ErrorMessage=$response['result']['data']['Data'][0]['Errors'][0]['ErrorMessage']; 
    $data = $response['result']['data']['Data'][0]['Result'];
    $ErrorCode2=$data['ErrorCode'];
    IF($ResCode==0)//کدپستی درست است  
    {
	  $province=$data['Province'];
      $township=$data['TownShip'];
      $zone=$data['Zone'];
      $village=$data['Village'];
      $localitytype=$data['LocalityType'];
      $localityname=$data['LocalityName'];
      $localitycode=$data['LocalityCode'];
      $sublocality=$data['SubLocality'];
      $mainavenue =$data['MainAvenue'];
	  $street=$data['Street'];
      $street2=$data['Street2'];
      $housenumber=$data['HouseNumber'];
      $floor=$data['Floor'];
      $sidefloor=$data['SideFloor'];
      $buildingname=$data['BuildingName'];
      $description=$data['Description'];
      
	  $province=str_replace("ي","ی",$province);$province=str_replace("ك","ک",$province);
      $township=str_replace("ي","ی",$township);$township=str_replace("ك","ک",$township);
      $zone=str_replace("ي","ی",$zone);$zone=str_replace("ك","ک",$zone);
      $village=str_replace("ي","ی",$village);$village=str_replace("ك","ک",$village);
      $localitytype=str_replace("ي","ی",$localitytype);$localitytype=str_replace("ك","ک",$localitytype);
      $localityname=str_replace("ي","ی",$localityname);$localityname=str_replace("ك","ک",$localityname);
      $sublocality=str_replace("ي","ی",$sublocality);$sublocality=str_replace("ك","ک",$sublocality);
      $mainavenue=str_replace("ي","ی",$mainavenue);$mainavenue=str_replace("ك","ک",$mainavenue);
      $street=str_replace("ي","ی",$street);$street=str_replace("ك","ک",$street);
      $street2=str_replace("ي","ی",$street2);$street2=str_replace("ك","ک",$street2);
      $floor=str_replace("ي","ی",$floor);$floor=str_replace("ك","ک",$floor);
      $sidefloor=str_replace("ي","ی",$sidefloor);$sidefloor=str_replace("ك","ک",$sidefloor);
      $buildingname=str_replace("ي","ی",$buildingname);$buildingname=str_replace("ك","ک",$buildingname);
      $description=str_replace("ي","ی",$description);$description=str_replace("ك","ک",$description);
      $full_address=' استان '.$province.'-'.' شهرستان '.$township.'-'.' منطقه '.$zone.'-'.$localitytype.'-'.$localityname.'-'.$village.'-'.$sublocality.'-'.$street.'-'.$street2.'-'.' طبقه '.$floor.'-'.' پلاک '.$housenumber.'-'.$sidefloor.'-'.$buildingname.'-'.$description;
    }
   }
   $insert_q=("INSERT INTO $TableName(code_anbar,shenase_meli_anbar,shenase_yekta,name_anbar,code_acc,code_ostan,noe_malekiyat,location_type,zarfiyat,hajm_esmi,vazn_esmi,zarfiyat_gharardadi,hajm_gharadadi,vazn_gharadadi,zarfiyat_takhlie_bargiri,status_peymankar,shenase_peymankar,name_peymankar,vazayef_peymankar,situation_type,activate,chkforush,chkmabadi,chktozin,chkwebservice,chkhavaleshow,date_havaleshow,anbar_tel,address_anbar,postal_code,province,township,zone,village,localitytype,localityname,localitycode,sublocality,street,street2,housenumber,floor,sidefloor,buildingname,description,full_address,post_error_code,bsk_chap_r,partid_error_code,partid_message)
              VALUES('$code_anbar',TRIM('$shenase_meli_anbar'),TRIM('$shenase_yekta'),TRIM('$name_anbar'),'$code_acc','$code_ostan','$noe_malekiyat','$location_type',TRIM('$zarfiyat'),TRIM('$hajm_esmi'),TRIM('$vazn_esmi'),TRIM('$zarfiyat_gharardadi'),TRIM('$hajm_gharadadi'),TRIM('$vazn_gharadadi'),TRIM('$zarfiyat_takhlie_bargiri'),'$status_peymankar',TRIM('$shenase_peymankar'),TRIM('$name_peymankar'),'$vazayef_peymankar','$situation_type','$activate','$chkforush','$chkmabadi','$chktozin','$chkwebservice','$chkhavaleshow','$date_havaleshow',TRIM('$anbar_tel'),TRIM('$address_anbar'),'$postal_code','$province','$township','$zone','$village','$localitytype','$localityname','$localitycode','$sublocality','$street','$street2','$housenumber','$floor','$sidefloor','$buildingname','$description','$full_address','$ResCode','$bsk_chap_r','$partid_error_code','$partid_message')");
   $insert_res=mysql_query($insert_q);
   if($insert_res){
    $max_id=$db->get_from_where("Max(id)","$TableName",""); 
    $log_i=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$max_id','ثبت',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')");
   }
   else  $message ='<span style="color:red;font: bold 12px tahoma;"> * مشکلی در ثبت به وجود آمده است ! *</span>'; 
 }
}    
/************EDIT BUTTON********/// اصلاح اطلاعات
if (isset($Edit_x))
{
 $zarfiyat=intval($zarfiyat);
 if(isPermitEdit($code_anbar,$shenase_meli_anbar,$shenase_yekta,trim($name_anbar),$code_acc,$code_ostan,$noe_malekiyat,$location_type,trim($zarfiyat),trim($zarfiyat_gharardadi),$status_peymankar,$vazayef_peymankar,$situation_type,$postal_code,$post_error_code,$partid_error_code,$id_))
 {

  $Mode='';
  if ($chkforush=='on') {$chkforush=1;$_SESSION['mt_systemforush']=1;}
  else {$chkforush=0;$_SESSION['mt_systemforush']=0;}  
  if ($chkmabadi=='on') {$chkmabadi=1;$_SESSION['mt_systemmabadi']=1;} 
  else {$chkmabadi=0;$_SESSION['mt_systemmabadi']=0;}
  if($chktozin){$_SESSION['mt_systemtozin']=$chktozin;}
  if ($chkwebservice=='on') {$chkwebservice=1;$_SESSION['mt_webservice']=1;} 
  else {$chkwebservice=0;$_SESSION['mt_webservice']=0;}
  if ($chkhavaleshow=='on') {$chkhavaleshow=1;$_SESSION['mt_havaleshow']=1;} 
  else {$chkhavaleshow=0;$_SESSION['mt_havaleshow']=0;}
  if($activate)$_SESSION['mt_anbar_activate']=$activate;
  if($status_peymankar){$_SESSION['mt_status_peymankar']=$status_peymankar;}
  if($status_peymankar==2) $vazayef_peymankar=0;
  $name_anbar=str_replace("ي","ی",$name_anbar);
  $name_anbar=str_replace("ك","ک",$name_anbar);
  IF($noe_malekiyat!=5)
  {
     //وب سرویس شناسه یکتا
      $wsdl_shenase_url='http://10.7.234.53/agriwindows/unitservicesVer3.asmx?wsdl';
      header('Content-Type: text/html; charset=utf-8');
      $client=new SoapClient($wsdl_shenase_url);
      $params=array('userName'=>'poshtibani','Password'=>'93mimgE16','PartIDcode_'=>$shenase_yekta,'UpdateDate'=>null);
      $result=$client->WS_G_1_4($params);
      $response=$result->WS_G_1_4Result;
      $partid_error_code=$response->ErrorCode;
      $partid_message=$response->Message; 
    //وب سرویس کد پستی
    IF($post_error_code!=0)
    {
     //کدپستی قبلی-soap
	 // $wsdl_postal_url='http://10.7.1.40/GetPostinfo/postServices.asmx?wsdl';
     // header('Content-Type: text/html; charset=utf-8');
     // $client=new SoapClient($wsdl_postal_url);
     // $params=array('username'=>'agriDam','password'=>'3rt67HM','postalcode'=>$postal_code);
     // $result=$client->GetAddressByPostalCode($params);
     // $response=$result->GetAddressByPostalCodeResult;
     // $ErrorCode=$response->ErrorCode;
     // $ErrorMessage=$response->ErrorMessage;
	 //کدپستی جدید -curl
     header('Content-Type: text/html; charset=utf-8');
     $Postcodes=array(0=>array('ClientRowID'=>1,'PostCode'=>$postal_code));
     $params=array('ClientBatchID'=>1,'Postcodes'=>$Postcodes,'Signature'=>'');
     $encodedData = json_encode($params);
     /////////////////////////CURL شروع کد ///////////////////////////////////
     $curl = curl_init();
     curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://sr-ajix.maj.ir/Services/NewGSBPostApiMethods/AddressByPostcode',
      CURLOPT_USERPWD => 'ajix_agridam:3rt67HM',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_SSL_VERIFYPEER=>false,
      CURLOPT_POSTFIELDS =>$encodedData,
      CURLOPT_HTTPHEADER => array('Content-Type: application/json','Authorization: Basic YWppeF9hZ3JpZGFtOjNydDY3SE0='),
      ));
      $response = curl_exec($curl);
      curl_close($curl);
      $response = json_decode($response,true); # آرایه

      $ResCode=$response['result']['data']['ResCode'];
      $ResMsg=$response['result']['data']['ResMsg'];
      $ErrorCode1=$response['result']['data']['Data'][0]['Errors'][0]['ErrorCode'];
      $ErrorMessage=$response['result']['data']['Data'][0]['Errors'][0]['ErrorMessage']; 
      $data = $response['result']['data']['Data'][0]['Result'];
      $ErrorCode2=$data['ErrorCode'];
	  IF($ResCode==0)//کدپستی درست است  
     {
	  $province=$data['Province'];
      $township=$data['TownShip'];
      $zone=$data['Zone'];
      $village=$data['Village'];
      $localitytype=$data['LocalityType'];
      $localityname=$data['LocalityName'];
      $localitycode=$data['LocalityCode'];
      $sublocality=$data['SubLocality'];
      $mainavenue =$data['MainAvenue'];
	  $street=$data['Street'];
      $street2=$data['Street2'];
      $housenumber=$data['HouseNumber'];
      $floor=$data['Floor'];
      $sidefloor=$data['SideFloor'];
      $buildingname=$data['BuildingName'];
      $description=$data['Description'];
      $province=str_replace("ي","ی",$province);$province=str_replace("ك","ک",$province);
      $township=str_replace("ي","ی",$township);$township=str_replace("ك","ک",$township);
      $zone=str_replace("ي","ی",$zone);$zone=str_replace("ك","ک",$zone);
      $village=str_replace("ي","ی",$village);$village=str_replace("ك","ک",$village);
      $localitytype=str_replace("ي","ی",$localitytype);$localitytype=str_replace("ك","ک",$localitytype);
      $localityname=str_replace("ي","ی",$localityname);$localityname=str_replace("ك","ک",$localityname);
      $sublocality=str_replace("ي","ی",$sublocality);$sublocality=str_replace("ك","ک",$sublocality);
      $mainavenue=str_replace("ي","ی",$mainavenue);$mainavenue=str_replace("ك","ک",$mainavenue);
	  $street=str_replace("ي","ی",$street);$street=str_replace("ك","ک",$street);
      $street2=str_replace("ي","ی",$street2);$street2=str_replace("ك","ک",$street2);
      $floor=str_replace("ي","ی",$floor);$floor=str_replace("ك","ک",$floor);
      $sidefloor=str_replace("ي","ی",$sidefloor);$sidefloor=str_replace("ك","ک",$sidefloor);
      $buildingname=str_replace("ي","ی",$buildingname);$buildingname=str_replace("ك","ک",$buildingname);
      $description=str_replace("ي","ی",$description);$description=str_replace("ك","ک",$description);
      $full_address=' استان '.$province.'-'.' شهرستان '.$township.'-'.' منطقه '.$zone.'-'.$localitytype.'-'.$localityname.'-'.$village.'-'.$sublocality.'-'.$street.'-'.$street2.'-'.' طبقه '.$floor.'-'.' پلاک '.$housenumber.'-'.$sidefloor.'-'.$buildingname.'-'.$description;
     }      
    }
   }
  $edit_q=("UPDATE $TableName SET code_anbar='$code_anbar',shenase_meli_anbar=TRIM('$shenase_meli_anbar'),shenase_yekta=TRIM('$shenase_yekta'),name_anbar=TRIM('$name_anbar'),code_acc='$code_acc',
            code_ostan='$code_ostan',noe_malekiyat='$noe_malekiyat',location_type='$location_type',zarfiyat=TRIM('$zarfiyat'),hajm_esmi=TRIM('$hajm_esmi'),vazn_esmi=TRIM('$vazn_esmi'),zarfiyat_gharardadi=TRIM('$zarfiyat_gharardadi'),hajm_gharadadi=TRIM('$hajm_gharadadi'),vazn_gharadadi=TRIM('$vazn_gharadadi'),
			zarfiyat_takhlie_bargiri='$zarfiyat_takhlie_bargiri',status_peymankar='$status_peymankar',shenase_peymankar=TRIM('$shenase_peymankar'),name_peymankar=TRIM('$name_peymankar'),
			situation_type='$situation_type',activate=$activate,vazayef_peymankar='$vazayef_peymankar',chkforush='$chkforush',chkmabadi='$chkmabadi',chktozin='$chktozin',chkwebservice='$chkwebservice',chkhavaleshow='$chkhavaleshow',date_havaleshow='$date_havaleshow',anbar_tel=TRIM('$anbar_tel'),address_anbar=TRIM('$address_anbar'),postal_code='$postal_code',
			province='$province',township='$township',zone='$zone',village='$village',localitytype='$localitytype',
			localityname='$localityname',localitycode='$localitycode',sublocality='$sublocality',
			street='$street',street2='$street2',housenumber='$housenumber',floor='$floor',sidefloor='$sidefloor',
			buildingname='$buildingname',description='$description',full_address='$full_address',
			post_error_code='$ResCode',bsk_chap_r='$bsk_chap_r',partid_error_code='$partid_error_code',partid_message='$partid_message'
			WHERE id='$id_';");
//echo $edit_q;
  $edit_res=mysql_query($edit_q);
  if(($edit_res) and (mysql_affected_rows()!=0)) $log_e=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_','ویرایش',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')"); /*کوئری لاگ*/
  else if(mysql_affected_rows==0) $message='';
  else $message ='<span style=" color:red;font: bold 12px tahoma;"> * مشکلی در ویرایش مشخصات به وجود آمده است ! *</span>'; 
 } 
}
/************DELETE BUTTON********/// حذف اطلاعات
if (isset($Delete_x))
{
 $Mode=''; 
 $del_q="DELETE FROM $TableName WHERE id=$id_ AND
         ($code_anbar_ NOT IN(SELECT code_anbar FROM list_sardkhane_detail WHERE code_anbar=$code_anbar_ AND code_ostan=$code_ostan_))AND
         ($code_anbar_ NOT IN(SELECT code_anbar FROM mojody_kala WHERE code_anbar=$code_anbar_ AND code_ostan=$code_ostan_ AND deleted=0))AND
         ($code_anbar_ NOT IN(SELECT code_anbar FROM resid WHERE code_anbar=$code_anbar_ AND code_ostan=$code_ostan_ AND deleted=0))AND
         ($code_anbar_ NOT IN(SELECT code_anbar FROM havale WHERE code_anbar=$code_anbar_ AND code_ostan=$code_ostan_ AND deleted=0))AND
         ($code_anbar_ NOT IN(SELECT code_anbar FROM havale_forush WHERE code_anbar=$code_anbar_ AND code_ostan=$code_ostan_ AND deleted=0))AND
         ($code_anbar_ NOT IN(SELECT code_anbar FROM ebtal WHERE code_anbar=$code_anbar_ AND code_ostan=$code_ostan_ AND deleted=0))AND
         ($code_anbar_ NOT IN(SELECT code_anbar FROM tadil_mojody WHERE code_anbar=$code_anbar_ AND code_ostan=$code_ostan_ AND deleted=0))AND
         ($code_anbar_ NOT IN(SELECT code_anbar FROM user_ostan_anbar WHERE code_anbar=$code_anbar_ AND code_ostan=$code_ostan_ ))";
 $del_res=$db->query($del_q,'مشکلي در حذف به وجود آمده است');
 if(mysql_affected_rows()==0)
  echo"<script>alert('این عنوان در سایر فرم ها استفاده شده است،شما مجاز به حذف آن نیستید!')</script>";
 else if($del_res) $log_d=$db->query("INSERT INTO log (user_id,tbl_name,record_id,amaliyat,log_date,log_time,user_ip)VALUES ('".$_SESSION['mt_user_id']."','$TableName','$id_','حذف',".($yymmdd).",'$logtime','".$_SESSION['mt_user_ip']."')"); /*کوئری لاگ*/
}
/********************WEB SERVICE NEW Version***********************/
if(isset($send_anbar))//مراحل ثبت در وب سرویس
{
 $params=array();
 header('Content-Type: text/html; charset=utf-8');        
  $q="SELECT * FROM list_sardkhane_owner WHERE id_anbar=$id_";
  $res= mysql_query($q);
  $row=$db->fetch_assoc($res);
  $birth_date=AsLDate($row['birthDate']);
  $q2="SELECT * FROM list_sardkhane WHERE id=$id_";
  $res2= mysql_query($q2);
  $row2=$db->fetch_assoc($res2);
  if(strlen($row2['code_ostan'])==1) $code_a=make_pattern($row2['code_ostan'],2);
  else $code_a=$row2['code_ostan'];
  $shenaseAnbar=$code_a.$row2['code_anbar'];
  $area=($row2['zarfiyat_gharardadi']/1000);//تبدیل تن
  IF($row2['noe_malekiyat']==1) $warehouse_usage_type=0;
  ELSE $warehouse_usage_type=1;
  $self_address=$row2['province'].' '.$row2['township'].' '.$row2['zone'].' '.$row2['village'].' '.$row2['localitytype'].' '.$row2['localitycode'].' '.$row2['sublocality'].' '.$row2['street'].' '.$row2['street2'].' '.$row2['housenumber'].' '.$row2['floor'].' '.$row2['sidefloor'].' '.$row2['buildingname'].' '.$row2['description'];
  //ملکی
  IF($row2['noe_malekiyat']==1)$warehouse_owner_type=1;
  ELSE $warehouse_owner_type=2;
     
	 $co_national_id='14002771736';
     //محسن سلامی
	 $national_id='0056974701';
     $birth_date='1351/01/01';
	 $mobile='09121837587';
	 //حسین شیرزاد
	 // $national_id='2141974097';
     // $birth_date='1350/12/07';
     // $mobile='09912464675';
     
	 $contractor_expire_date='1407/12/29';
  
  $params=array(
	      'national_id'=>$national_id,
	      'co_national_id'=>$co_national_id,
	      'birth_date'=>$birth_date,
	      'contractor_expire_date'=>$contractor_expire_date,
	      'mobile'=>$mobile,
	      'postal_code'=>$row2['postal_code'],
	      'self_address'=>$self_address,
	      'name'=>$row2['name_anbar'],
		  'warehouse_owner_type'=>$warehouse_owner_type,
	      'electric_bill_number'=>null,
	      'gas_bill_number'=>null,
	      'type'=>'4',
	      'activity_sector'=>'0150',
	      'supervisor_org'=>'87',
	      'zone_types'=>'1',
	      'zone_economic_types'=>'1',
		  'gov_warehouse_no'=>$shenaseAnbar,
	      'area'=>$area,
	      'area_type'=>'ton',
	      'warehouse_usage_type'=>$warehouse_usage_type,
	      'building_type'=>'0',
	      'goods_type'=>'6',
	      'unit_type'=>'3',
	      'unit_group'=>'3'
		  // ,
	      // 'on_error_data_send_sms_to_user'=>'False',
	   );
    //چاپ آرایه
	//if(SuperUser())echo '<pre>'; print_r($params); echo '</pre>';	   
    $result=preg_replace("/\\\\u([a-f0-9]{4})/e", "iconv('UCS-4LE','UTF-8',pack('V', hexdec('U$1')))", json_encode($params));
	$encodedData = json_encode($params);
	//چاپ جیسون
	//if(SuperUser())echo $result;
	$curl = curl_init();
	curl_setopt_array($curl, array(
          CURLOPT_URL => 'http://10.7.234.33/warehouse/api/warehouse/RegisterWarehouse',
          CURLOPT_USERPWD => 'ajix-agridam:3rt67HM',
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

		 	  
    $array =json_decode($response,true); # آرایه
	$object=json_decode($response);      # آبجکت
    //اطلاعات دریافتی
    $warehouse_id=$object->warehouse_id;  
    $user_first_name=$object->user_first_name;  
    $user_last_name=$object->user_last_name;  
    $company_name=$object->company_name;
    $province=$object->province;  
    $township=$object->township;  
    $city=$object->city;  
    $register_full_address=$object->full_address;  
    $error_code=$object->error_code;  
    $error_message=$object->error_message; 
  
  echo "<script>alert('error_message : $error_message')</script>"; 
  echo "<script>alert('شماره یکتا سردخانه $warehouse_id')</script>"; 
  $update_anbar=("UPDATE list_sardkhane SET warehouse_id='$warehouse_id',user_first_name='$user_first_name',user_last_name='$user_last_name',company_name='$company_name',register_province='$province',register_township='$township',city='$city',register_full_address='$register_full_address',register_error_code='$error_code',register_error_message='$error_message' WHERE id=$id_");
  //$update_anbar=("UPDATE list_sardkhane SET warehouse_id='$warehouse_id',register_error_code='$error_code',register_error_message='$error_message' WHERE id=$id_");
  $update_res=mysql_query($update_anbar); 
 }
// /********************WEB SERVICE Seconde time***********************/
// if(isset($send_anbar))//مراحل ثبت در وب سرویس
// {
 // $wsdl_url='http://10.7.234.33/anbar/warehouse.asmx?wsdl';
 // header('Content-Type: text/html; charset=utf-8');
 // try
 // {
  // $client=new SoapClient($wsdl_url);        
  // $q="SELECT * FROM list_sardkhane_owner WHERE id_anbar=$id_";
  // $res= mysql_query($q);
  // $row=$db->fetch_assoc($res);
  // $birth_date=AsLDate($row['birthDate']);
  // $q2="SELECT * FROM list_sardkhane WHERE id=$id_";
  // $res2= mysql_query($q2);
  // $row2=$db->fetch_assoc($res2);
  // if(strlen($row2['code_ostan'])==1) $code_a=make_pattern($row2['code_ostan'],2);
  // else $code_a=$row2['code_ostan'];
  // $shenaseAnbar=$code_a.$row2['code_anbar'];
  // $area=($row2['zarfiyat_gharardadi']/1000);//تبدیل تن
  // IF($row2['noe_malekiyat']==1) $warehouse_usage_type=0;
  // ELSE $warehouse_usage_type=1;
  // $self_address=$row2['province'].' '.$row2['township'].' '.$row2['zone'].' '.$row2['village'].' '.$row2['localitytype'].' '.$row2['localitycode'].' '.$row2['sublocality'].' '.$row2['street'].' '.$row2['street2'].' '.$row2['housenumber'].' '.$row2['floor'].' '.$row2['sidefloor'].' '.$row2['buildingname'].' '.$row2['description'];
  // $WarehouseInfo=array(
	      // 'national_id'=>$row['nationalId'],
	      // 'co_national_id'=>'14002771736',
	      // 'birth_date'=>$birth_date,
	      // 'contractor_expire_date'=>$row['contractor_expire_date'],
	      // 'mobile'=>$row['mobile'],
	      // 'postal_code'=>$row2['postal_code'],
	      // 'self_address'=>$self_address,
	      // 'name'=>$row2['name_anbar'],
	      // 'gov_warehouse_no'=>$shenaseAnbar,
	      // 'area'=>$area,
	      // 'area_type'=>'ton',
	      // 'warehouse_usage_type'=>$warehouse_usage_type,
	      // 'building_type'=>'0',
	      // 'goods_type'=>'3',
	      // 'on_error_data_send_sms_to_user'=>0,
	   // );
  // $params=array(
         // 'username'=>'02',
         // 'password'=>'HJ78mnGD',
		 // 'co_national_id'=>'14002771736',
		 // 'data'=>$WarehouseInfo
         // );
  // $result=$client->RegisterWarehouse($params);
  // $response=$result->RegisterWarehouseResult;
  // //اطلاعات دریافتی
  // $warehouse_id=$response->warehouse_id;  
  // $user_first_name=$response->user_first_name;  
  // $user_last_name=$response->user_last_name;  
  // $company_name=$response->company_name;
  // $province=$response->province;  
  // $township=$response->township;  
  // $city=$response->city;  
  // $full_address=$response->full_address;  
  // $error_code=$response->error_code;  
  // $error_message=$response->error_message;  
  // echo "<script>alert('error_code : $error_code')</script>"; 
  // echo "<script>alert('error_message : $error_message')</script>"; 
  // echo "<script>alert('شماره یکتا سردخانه $warehouse_id')</script>"; 
  // $update_anbar=("UPDATE list_sardkhane SET warehouse_id='$warehouse_id',user_first_name='$user_first_name',user_last_name='$user_last_name',company_name='$company_name',register_province='$province',register_township='$township',city='$city',full_address='$full_address',register_error_code='$error_code',register_error_message='$error_message' WHERE id=$id_");
  // //$update_anbar=("UPDATE list_sardkhane SET warehouse_id='$warehouse_id',register_error_code='$error_code',register_error_message='$error_message' WHERE id=$id_");
  // $update_res=mysql_query($update_anbar); 
 // }
 // catch(SoapFault $client)
 // {
    // echo "<script>alert('وب سرویس فعال نمی باشد')</script>";
 // }
// }
/********************WEB SERVICE***********************/
// if(isset($send_anbar))//مراحل ثبت در وب سرویس
// {
 // $wsdl_url='http://10.7.234.33/anbar/warehouse.asmx?wsdl';
 // header('Content-Type: text/html; charset=utf-8');
 // try
 // {
  // $client=new SoapClient($wsdl_url);
  // $national_id=$db->get_from_where("nationalId","list_sardkhane_owner","id_anbar=$id_");     
  // $mobile=$db->get_from_where("mobile","list_sardkhane_owner","id_anbar=$id_");     
  // $name_anbar=$db->get_from_where("name_anbar","list_sardkhane","id=$id_");     
  // $postal_code=$db->get_from_where("postal_code","list_sardkhane","id=$id_");     
  // $params=array(
         // 'username'=>'02',
         // 'password'=>'HJ78mnGD',
		 // 'national_id'=>$national_id,
		 // 'mobile'=>$mobile,
		 // 'warehouseName'=>$name_anbar,
		 // 'warehouse_postalCode'=>$postal_code,
		 // 'company_nationalID'=>'14002771736'
         // );
  // $result=$client->RegisterWareHouse($params);
  // $response=$result->RegisterWareHouseResult;
  // //اطلاعات دریافتی
  // $warehouse_id=$response->warehouse_id;  
  // $user_first_name=$response->user_first_name;  
  // $user_last_name=$response->user_last_name;  
  // $company_name=$response->company_name;
  // $city=$response->city;  
  // $full_address=$response->full_address;  
  // $ErrorCode=$response->ErrorCode;  
  // $ErrorMessage=$response->ErrorMessage;  
  // echo "<script>alert('ErrorCode : $ErrorCode')</script>"; 
  // echo "<script>alert('ErrorMessage : $ErrorMessage')</script>"; 
  // echo "<script>alert('شماره یکتا سردخانه $warehouse_id')</script>"; 
  // $update_anbar=("UPDATE list_sardkhane SET warehouse_id='$warehouse_id',user_first_name='$user_first_name',user_last_name='$user_last_name',company_name='$company_name',city='$city',full_address='$full_address',register_error_code='$ErrorCode' WHERE id=$id_");
  // $update_res=mysql_query($update_anbar); 
 // }
 // catch(SoapFault $client)
 // {
    // echo "<script>alert('وب سرویس فعال نمی باشد')</script>";
 // }
// }

/***************************************** MAIN*****************************************/
echo'
<body onload="document.myform.code_anbar.focus();">
<form method="post" name="myform" onkeydown="enterIE();">
<div align="center">
<table width="99%" height="100%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr>
  <td class="title">
   <div style="position:absolute;top:5px;left:47%;">سردخانه ها</div>
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
if(!isset($order)) $order='id DESC';
if(!isset($sortcode)) $sortcode='1';
if(!isset($sortname)) $sortname='1';
if(!isset($sortostan)) $sortostan='1';
if(!isset($show_img)) $show_img='';
	 echo'<td width="3%">شناسه</td>';
	 if($sortcode=='1')
	 {echo'<td width="5%" title="مرتب سازی صعودی کد سردخانه" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=code_anbar ASC&sortcode=2&show_img=1\'"/> کد سردخانه ';
	   if($show_img=='1')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	 }
	 if($sortcode=='2')
	 {echo'<td width="5%" title="مرتب سازی نزولی کد سردخانه" style="cursor:pointer;" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=code_anbar DESC&sortcode=1&show_img=1\'"/> کد سردخانه ';
	   if($show_img=='1')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	 }
	 echo'<td width="8%">شناسه یکتا (دامپزشکی)</td>';
	 if($sortname=='1')
	 {echo'<td width="18%" title="مرتب سازی صعودی نام سردخانه" style="cursor:pointer;"  onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=name_anbar ASC&sortname=2&show_img=2\'"/> نام سردخانه '; 
	   if($show_img=='2')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	 }
	 if($sortname=='2')
	 {echo'<td width="18%" title="مرتب سازی نزولی نام سردخانه" style="cursor:pointer;"  onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=name_anbar DESC&sortname=1&show_img=2\'"/> نام سردخانه '; 
	   if($show_img=='2')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	 }
	 if($sortostan=='1')
	 {echo'<td width="8%" title="مرتب سازی صعودی استان سردخانه" style="cursor:pointer;"  onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=nameOstan ASC&sortostan=2&show_img=3\'"/> استان سردخانه'; 
	   if($show_img=='3')echo'<img src="images/sort_down.png" onmouseOver="this.src=\'images/sort_up6.png\'" onmouseOut="this.src=\'images/sort_down.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	 }
	 if($sortostan=='2')
	 {echo'<td width="8%" title="مرتب سازی نزولی استان سردخانه" style="cursor:pointer;"  onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order=nameOstan DESC&sortostan=1&show_img=3\'"/> استان سردخانه '; 
	   if($show_img=='3')echo'<img src="images/sort_up.png" onmouseOver="this.src=\'images/sort_down6.png\'" onmouseOut="this.src=\'images/sort_up.png\'" style="width:10px;height:10px;cursor:pointer;"/></td>';
	 }
	echo'
	 <td width="7%">نوع مالکیت</td>
	 <td width="7%">وضعیت پیمانکار</td>
	 <td width="7%">نام پیمانکار</td>
	 <td width="7%">کدپستی</td>
	 <td width="5%">وضعیت</td>
	 <td width="6%">اتصال به سیستم فروش</td>
	 <td width="6%">اتصال به توزین</td>';
	 if($right_owner)echo'<td width="7%">اطلاعات صاحب سردخانه</td>';
	 if($right_detail) echo'<td width="5%">جزئیات</td>';
	 // if($right_del) echo'<td width="4%">حذف</td>';
	 echo'
	 <td width="4%">ثبت در صمت</td>
	</tr>';
	$i=0;
	$cntr=0;
    $q1="SELECT *,
	     (SELECT COUNT(*) FROM list_sardkhane_detail l_a_d WHERE l_a_d.code_ostan=T.code_ostan AND l_a_d.code_anbar=T.code_anbar) detailcount,
         (SELECT COUNT(*) FROM list_sardkhane_owner l_a_w WHERE l_a_w.code_ostan=T.code_ostan AND l_a_w.code_anbar=T.code_anbar) detailowner,
	     (SELECT name_ostan FROM ostan WHERE ostan.code_ostan=T.code_ostan) nameOstan
	     From $TableName T WHERE 1=1 ".$_SESSION['mt_search_li_anbar']." $Condition AND location_type=2 ".$_SESSION['mt_CondOwner']." order by $order $Limit ";
	//echo $q1;
	$allAnbar = $db->query($q1);
	while($row1=$db->fetch_assoc($allAnbar))
	{
     if(($right_edt)OR($right_edt_activate)){$edtClick='onClick="window.location=\''.$FileName.'?Mode=Edit&id_='.$row1['id'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'"';}	 
	 if($i++%2)
     echo'
     <tr class="table-odd"/>';
     else echo '
     <tr class="table-even"/>';   
	 echo'
	  <td '.$edtClick.'>'.$row1['id'].'</td>
	  <td '.$edtClick.'>'.$row1['code_anbar'].'</td>
	  <td '.$edtClick.'>';IF($row1['partid_error_code']==0) echo'<span class="fa fa-check-circle" style="color:green"></span>'; echo''.$row1['shenase_yekta'].'</td>
	  <td '.$edtClick.'>'.$row1['name_anbar'].'</td>
	  <td '.$edtClick.' title='.$row1['code_ostan'].'>'.$row1['nameOstan'].'</td>
	  <td '.$edtClick.'>'.$noe_malekiyatArr[$row1['noe_malekiyat']].'</td>
	  <td '.$edtClick.'>'.$status_peymankarArr[$row1['status_peymankar']].'</td>
	  <td '.$edtClick.'>'.$row1['name_peymankar'].'</td>
	  <td '.$edtClick.'>'; IF($row1['post_error_code']==0) echo'<span class="fa fa-check-circle" style="color:green"></span>'; echo' '.$row1['postal_code'].'</td>
	  <td '.$edtClick.' '; IF($row1['activate']==1) echo 'class="active"'; IF($row1['activate']==2) echo 'class="deactive"';  echo'>'.$activateArr[$row1['activate']].'</td>
	  <td '.$edtClick.'>';if($row1['chkforush'] == 1)echo '<span class="fa fa-check-circle fa-2x" style="color:green"></span>';else echo '<span class="fa fa-times-circle fa-2x" style="color:red"></span>'; echo'</td>
	  <td '.$edtClick.'>';if($row1['chktozin'] == 1)echo '<span class="fa fa-check-circle fa-2x" style="color:green"></span>';else if($row1['chktozin'] == 0) echo '<span class="fa fa-times-circle fa-2x" style="color:red"></span>'; else if($row1['chktozin'] == 2) echo '<span class="fa fa-check-circle fa-2x" style="color:red"></span>'; echo'</td>
	  ';
	  if($right_owner) {echo'<td><input type="button" ';  IF($row1['detailowner']==0) echo' class="button-inline buttonme-empty"'; else echo' class="button-inline"'; echo' style="min-width:50px;" value="['.$row1['detailowner'].']" onClick="window.location=\'list_sardkhane_owner.php?PageNo='.$PageNo.'&id_='.$row1['id'].'\'"></td>';}
	  if($right_detail) {echo'<td><input type="button" class="button-inline"  value="['.$row1['detailcount'].']" style="min-width:50px;" onClick="window.location=\'list_sardkhane_detail.php?PageNo='.$PageNo.'&code_anbar_='.$row1['code_anbar'].'&code_ostan_='.$row1['code_ostan'].'&zarfiyat_='.$row1['zarfiyat'].'\'"></td>';}
	  //ثبت در سامانه صمت
	  IF($row1['warehouse_id'])//ثبت شده
	   echo'<td><div class="webservise" id="webservise-accept" title="شناسه ملی سردخانه : '.$row1['warehouse_id'].'"></div></td>';
	  //ELSE IF(($row1['postal_code'])and($row1['detailowner']!=0))
	  ELSE IF($row1['postal_code'])
	  {
		IF(($row1['register_error_code']!=0)and($row1['register_error_code']!=-1))echo'<td><div class="webservise" id="webservise-delete-resend"  title="کد خطا : '.$row1['register_error_code'].'"  onClick="window.location=\''.$FileName.'?id_='.$row1['id'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&send_anbar=1\'" /></div></td>';
      	ELSE echo'<td><div class="webservise" id="webservise-add"  title="شناسه ملی  سردخانه : '.$row1['warehouse_id'].'"  onClick="window.location=\''.$FileName.'?id_='.$row1['id'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&send_anbar=1\'" /></div></td>';
	  } 
	  ELSE echo '<td>&nbsp;</td>'; 
	  if($right_del)
	  {echo'<td><img border="0" src="images/trash.png" width="20" height="20" title="حذف"
	       onmouseOver="this.src=\'images/trash_hover.png\'" 
		   onmouseOut="this.src=\'images/trash.png\'" 	  
	       onClick="iconfirm(\''.$FileName.'?Delete_x=1&id_='.$row1['id'].'&code_anbar_='.$row1['code_anbar'].'&code_ostan_='.$row1['code_ostan'].'&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\',\'براي حذف '.$row1['name_anbar'].' \')" /></td>';
	  } 
	echo'
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
	  <td>&nbsp;</td>';
	  if($right_owner)echo'<td>&nbsp;</td>';
	  if($right_detail)echo'<td>&nbsp;</td>';
	  if($right_del)echo'<td>&nbsp;</td>';
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
	 <td width="10">&nbsp;</td>
	 <td width="24"><div onClick="window.open(\'print_list_sardkhane.php\',\'\',\'scrollbars=1\')" id="printer" title="چاپ"><a href="#"></a></div></td>
     <td width="10">&nbsp;</td>';
	 if($right_ins){
	 echo'<td width="70"><div onClick="window.location=\''.$FileName.'?Mode=Insert&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-new" title="افزودن رکورد جديد" ><a href="#"></a></div></td>
 	 <td width="10">&nbsp;</td>';}
	 echo'
	 <td width="70"><div onClick="window.location=\''.$FileName.'?Mode=Search&PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'" id="btn-search" title="جستجو" ><a href="#"></a></div></td>
	 <td width="10">&nbsp;</td>
	 <td width="70"><div onClick="window.location=\'my_frame.php\'" id="btn-back"  title="بازگشت به منوي اصلي"  ><a href="#"></a></div></td> 
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
	 <td align="right"><input type="text" name="wRowPerPage" value="'.$RowPerPage.'" size="2" onChange="myform.submit()" onkeypress="return isNumber(event)" style="direction:ltr;text-align:center;"></td>	 
	 <td width="10">&nbsp;</td>';
     if (($_SESSION['mt_search_li_anbar'])OR($_SESSION['mt_CondOwner'])) 
	 echo '
	 <td width="70"><input type="Button" class=buttonme  value="نمايش همه" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'&open_filter=1\'"></td>';	 
	 echo'
     <td width="100px" style="color:#fff;" align="left"> تعداد ['.$cnt.']</td>
     <td width="10">&nbsp;</td>		 
	</tr>';
    }
	if ($Mode=="Insert")  //Insert Mode
    {
	$location_type_default=2;//سردخانه
	echo '
    <tr> 
	 <td width="99%" class="borderall" style="position:absolute;bottom:10px;left:0.5%;"> 	 
	  <table class="footer-panel" width="100%" cellpadding="0" cellspacing="0">
       <tr class="title"><td colspan="10" align="center">ايجاد سردخانه جدید</td></tr>   
	   <tr>
	    <td align="left" width="170px"><span class="star">*</span> کد سردخانه : &nbsp;</td><td align="right"><input type="text" class="textboxme2" name="code_anbar" value="'.$code_anbar.'"  maxlength="3" title="برای کد انبار سه رقم وارد نمایید" onkeypress="return isNumber(event)" style="width:50px"/>
	     <img border="0" src="images/Info1.png" title="برای کد انبار عددی بین 100 تا 300 قابل قبول است" onmouseOver="this.src=\'images/Info_h.png\'" onmouseOut="this.src=\'images/Info1.png\'" style="width:16px;height:16px;cursor:pointer"/>
		</td>
	    <td align="left" width="150px"><span class="star">*</span> شناسه یکتا سردخانه : &nbsp;</td><td align="right"><input type="text" class="textboxme2" name="shenase_yekta" value="'.$shenase_yekta.'" onkeypress="return isNumber(event)"/></td>
	    <td align="left" width="200px"><span class="star">*</span> نام سردخانه : &nbsp;</td><td align="right"><input type="text" class="textboxme" name="name_anbar" value="'.$name_anbar.'" ></td>
       </tr>
       <tr>	   
		<td align="left"><span class="star">*</span> کد حسابداری انبار : &nbsp;</td><td align="right"><input type="text" class="textboxme2" maxlength="6" name="code_acc" value="'.$code_acc.'" onkeypress="return isNumber(event)" style="width:50px"> <img border="0" src="images/Info1.png" title="کد حسابداری رادر 6 رقم وارد نمایید" onmouseOver="this.src=\'images/Info_h.png\'" onmouseOut="this.src=\'images/Info1.png\'" style="width:16px;height:16px;cursor:pointer"/></td>
		<td align="left"><span class="star">*</span> نام استان : &nbsp;</td><td align="right">'.listbox("code_ostan",$code_ostan,"code_ostan","name_ostan","ostan","1=1 ORDER BY ostan.name_ostan ASC","class='text4'").'</td>
        <td align="left"><span class="star">*</span> نوع انبار : &nbsp;</td><td align="right">'.static_listbox("location_type",$location_type_default,"locationtypeArr",1,"class='text4'").'</td>  
	   </tr>
	   <tr>
	   	<td align="left">نوع مالکیت : &nbsp;</td><td align="right">'.static_listbox("noe_malekiyat",$noe_malekiyat,"noe_malekiyatArr",1,"class='text4'").'</td>  
	    <td align="left"><span class="star">*</span> وضعیت پیمانکار : &nbsp;</td><td align="right">'.static_listbox("status_peymankar",$status_peymankar,"status_peymankarArr",1,"class='text4'").'</td>
		<td align="left" class="vazayefshow" style="display:none;"><span class="star">*</span> وظایف پیمانکار : &nbsp;</td><td align="right" class="vazayefshow" style="display:none;">'.static_listbox("vazayef_peymankar",$vazayef_peymankar,"vazayef_peymankarArr",1,"class='text4'").'</td>';	   
	   //اگر ارروری در صفحه ظاهر شد
	    if($status_peymankar==1)//اگر پیمانکار دارد
		echo'<td align="left" class="vazayefshow"><span class="star">*</span> وظایف پیمانکار : &nbsp;</td><td align="right" class="vazayefshow">'.static_listbox("vazayef_peymankar",$vazayef_peymankar,"vazayef_peymankarArr",1,"class='text4'").'</td>';
	   
	   echo'	
	   </tr>
       <tr>
	    <td align="left">شناسه پیمانکار : &nbsp;</td><td align="right"><input type="text" class="textboxme2" name="shenase_peymankar" value="'.$shenase_peymankar.'"/></td>
	    <td align="left">نام پیمانکار : &nbsp;</td><td align="right"><input type="text" class="textboxme2" name="name_peymankar" value="'.$name_peymankar.'"/></td>
        <td align="left"><span class="star">*</span> ظرفیت اسمی سردخانه : &nbsp;</td>
		<td align="right">
		 <input type="text" class="textboxme2" name="zarfiyat" value="'.$zarfiyat.'" onkeypress="return isNumber(event)">
		 حجم : <input type="text" class="textboxme2" name="hajm_esmi" value="'.$hajm_esmi.'" onkeypress="return isNumber(event)"  >
		 وزن : <input type="text" class="textboxme2" name="vazn_esmi" value="'.$vazn_esmi.'" onkeypress="return isNumber(event)"  >
		</td>  
	   </tr>
	   <tr>	   
	    <td align="left"><span class="star">*</span> ماهیت سردخانه : &nbsp;</td><td align="right">'.static_listbox("situation_type",$situation_type,"situationtypeArr",1,"class='text4'").'</td>
		<td align="left"><span class="star">*</span> کد پستی : &nbsp;</td><td align="right"><input type="text" class="textboxme2" name="postal_code" value="'.$postal_code.'" maxlength="10" onkeypress="return isNumber(event)"  /></td>		    
		<td align="left"><span class="star">*</span>ظرفیت قراردادی سردخانه : &nbsp;</td>
		<td align="right">
		 <input type="text" class="textboxme2" name="zarfiyat_gharardadi" value="'.$zarfiyat_gharardadi.'" onkeypress="return isNumber(event)"  >
		 حجم : <input type="text" class="textboxme2" name="hajm_gharadadi" value="'.$hajm_gharadadi.'" onkeypress="return isNumber(event)"  >
		 وزن : <input type="text" class="textboxme2" name="vazn_gharadadi" value="'.$vazn_gharadadi.'" onkeypress="return isNumber(event)"  >
		</td>
	   </tr>
	   <tr>
		<td align="left"><span class="star">*</span> وضعیت سردخانه : &nbsp;</td><td align="right">'.static_listbox("activate",$activate,"activateArr",1,"class='text4'").'</td>
	    <td align="left">اتصال به سیستم فروش : &nbsp;</td><td align="right"><input type="checkbox" name="chkforush" checked/></td>
	    <td align="left"> ظرفیت تخلیه و بارگیری روزانه : &nbsp;</td>
		<td align="right">
		  <input type="text" class="textboxme2" name="zarfiyat_takhlie_bargiri" value="'.$row2['zarfiyat_takhlie_bargiri'].'" onkeypress="return isNumber(event)" '; if(!$right_edt) echo 'readonly'; echo' >
		</td>
		<!--<td align="left">اتصال به سیستم مبادی : &nbsp;</td><td align="right"><input type="checkbox" name="chkmabadi"/></td>-->
	   </tr>
	   <tr>
	    <td align="left">ارسال اطلاعات به وب سرویس : &nbsp;</td><td align="right"><input type="checkbox" name="chkwebservice" checked/></td>
	   	<td colspan="2"></td>
		<td align="left"><span class="star">*</span> وضعیت اتصال به سیستم توزین : &nbsp;</td><td align="right" >'.static_listbox("chktozin",$chktozin,"connect_tozinArr",1,"class='text4'").'&nbsp;<span class="chapShow" style="display:none;">تعداد چاپ قبض باسکول : <input type="text" class="textboxme2" name="bsk_chap_r" onkeypress="return isNumber(event)" style="width:50px" /></span></td>
	   </tr>
	   <tr>
        <td align="left">آدرس سردخانه : &nbsp;</td><td align="right"><input type="text" class="textboxme" name="address_anbar" value="'.$address_anbar.'" /></td>		    
	    <td align="left"><span class="star">*</span> شناسه ملی سردخانه : &nbsp;</td><td align="right"><input type="text" class="textboxme2" name="shenase_meli_anbar" value="'.$shenase_meli_anbar.'" onkeypress="return isNumber(event)"/></td>
	    <td align="left">تلفن سردخانه : &nbsp;</td><td align="right"><input type="text" class="textboxme2" name="anbar_tel" value="'.$anbar_tel.'" placeholder="0217654321" onkeypress="return isNumber(event)" /></td>		    
		<!--
		 <td align="left">مشاهده همه حواله فروشها : &nbsp;</td><td align="right"><input type="checkbox" name="chkhavaleshow" />
		 <td align="left"> مشاهده حواله فروش ها از تاریخ : &nbsp;</td><td align="right" colspan="2"><input type="text" class="textboxme2 datepicker6" maxlength="10" name="date_havaleshow" value="'.$date_havaleshow.'"  ></td>
	    -->
	   </tr>
	   <tr class="title">
        <td colspan="8" align="center">
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
	 $q2="SELECT *,
	     (SELECT count(code_anbar) FROM list_sardkhane_detail l_a_d WHERE l_a_d.code_anbar=T.code_anbar AND l_a_d.code_ostan=T.code_ostan) exist_anbar_detail,
	     (SELECT count(code_anbar) FROM mojody_kala m_k WHERE m_k.code_anbar=T.code_anbar AND m_k.code_ostan=T.code_ostan AND m_k.deleted=0) exist_mojody,
	     (SELECT count(code_anbar) FROM resid r WHERE r.code_anbar=T.code_anbar AND r.code_ostan=T.code_ostan AND r.deleted=0) exist_resid,
	     (SELECT count(code_anbar) FROM havale_forush h_f WHERE h_f.code_anbar=T.code_anbar AND h_f.code_ostan=T.code_ostan AND h_f.deleted=0) exist_havale_forush,
	     (SELECT count(code_anbar) FROM havale h WHERE h.code_anbar=T.code_anbar AND h.code_ostan=T.code_ostan AND h.deleted=0) exist_havale,
	     (SELECT count(code_anbar) FROM ebtal e WHERE e.code_anbar=T.code_anbar AND e.code_ostan=T.code_ostan AND e.deleted=0) exist_ebtal,
	     (SELECT count(code_anbar) FROM tadil_mojody t_m WHERE t_m.code_anbar=T.code_anbar AND t_m.code_ostan=T.code_ostan AND t_m.deleted=0) exist_tadil,
	     (SELECT count(code_anbar) FROM user_ostan_anbar u_o_a WHERE u_o_a.code_anbar=T.code_anbar AND u_o_a.code_ostan=T.code_ostan) exist_user_o_a
	      FROM $TableName T WHERE id='$id_'";
	 $res2=$db->query($q2);
	 $row2=$db->fetch_assoc($res2);
	 if($row2['chkforush'] == 1) $forush_checked = 'checked = "checked"';
     else $forush_checked = '';
	 if($row2['chkmabadi'] == 1) $mabadi_checked = 'checked = "checked"';
     else $mabadi_checked = '';
	 if($row2['chkwebservice'] == 1) $webservice_checked = 'checked = "checked"';
     else $webservice_checked = '';
	 if($row2['chkhavaleshow'] == 1) $havaleshow_checked = 'checked';
     else $havaleshow_checked = '';
	 //پیدا کردن آی دی کد استان مربوط به سیتم فروش
     $res_ostan=mysql_query("SELECT province_id FROM sell.dm_province WHERE province_code=".$row2['code_ostan']."");
     $sell_id_ostan=mysql_result($res_ostan, 0, 'province_id');
    //پیدا کردن آی دی کد انبار مربوط به سیستم فروش
     $res_anbar=mysql_query("SELECT l_id FROM sell.dm_location_goods WHERE l_id_province='$sell_id_ostan' AND l_code=".$row2['code_anbar']."");
     $sell_id_anbar=mysql_result($res_anbar, 0, 'l_id');
	 echo'
     <tr> 
	  <td width="99%" class="borderall" style="position:absolute;bottom:10px;left:0.5%;"> 	 
	   <table class="footer-panel" width="100%" cellpadding="0" cellspacing="0">
        <tr class="title"><td colspan="10" align="center">ويرايش '.$row2['name_anbar'].'( '.$row2['warehouse_id'].' )</td></tr>	   
	    <tr>';
	    if(($row2['exist_anbar_detail'])or($row2['exist_mojody'])or($row2['exist_resid'])or($row2['exist_havale_forush'])or($row2['exist_havale'])or($row2['exist_ebtal'])or($row2['exist_tadil'])or($row2['exist_user_o_a']))
		{echo'<td align="left" width="170px"><span class="star">*</span> کد سردخانه  :&nbsp;</td><td align="right"><input type="text" class="textboxme2" name="code_anbar" readonly value="'.$row2['code_anbar'].'" title="غیر قابل تغییر" style="width:50px;cursor:pointer;"/> <img border="0" src="images/readonly.png" title="غیر قابل تغییر" class="dontchange"/></td>';}
	    else echo'<td align="left" width="150px"><span class="star">*</span> کد سردخانه  :&nbsp;</td><td align="right"><input type="text" class="textboxme2" name="code_anbar" value="'.$row2['code_anbar'].'" maxlength="3" title="برای کد انبار سه رقم وارد نمایید" onkeypress="return isNumber(event)" style="width:50px"/>	     <img border="0" src="images/Info1.png" title="برای کد انبار عددی بین 100 تا 300 قابل قبول است" onmouseOver="this.src=\'images/Info_h.png\'" onmouseOut="this.src=\'images/Info1.png\'" style="width:16px;height:16px;cursor:pointer"/></td>';
		echo'
		 <td align="left" width="150px"><span class="star">*</span> شناسه یکتا (دامپزشکی): &nbsp;</td><td align="right" width="150px"><input type="text" class="textboxme2" name="shenase_yekta" value="'.$row2['shenase_yekta'].'" onkeypress="return isNumber(event)" '; if(!$right_edt) echo 'readonly'; echo'/> <input type="hidden" name="partid_error_code" value="'.$row2['partid_error_code'].'" /> <input type="hidden" name="partid_message" value="'.$row2['partid_message'].'" /> ';IF($row2['partid_error_code']==0) echo'<span class="fa fa-check-circle" style="color:green"></span>'; echo'</td>
	     <td align="left" width="200px"><span class="star">*</span> نام سردخانه : &nbsp;</td><td align="right"><input type="text" class="textboxme" name="name_anbar" value="'.$row2['name_anbar'].'" '; if(!$right_edt) echo 'readonly'; echo' /></td>
	    </tr>
        <tr>
	     <td align="left"><span class="star">*</span> کد حسابداری سردخانه : &nbsp;</td><td align="right"><input type="text" class="textboxme2" maxlength="6" name="code_acc" value="'.$row2['code_acc'].'" onkeypress="return isNumber(event)" style="width:50px" '; if(!$right_edt) echo 'readonly'; echo' > <img border="0" src="images/Info1.png" title="کد حسابداری رادر 6 رقم وارد نمایید" onmouseOver="this.src=\'images/Info_h.png\'" onmouseOut="this.src=\'images/Info1.png\'" style="width:16px;height:16px;cursor:pointer" /></td>';
		 if($right_edt)
		 {
		  echo'
		  <td align="left"><span class="star">*</span> نام استان : &nbsp;</td><td align="right">'.listboxMe("code_ostan",$row2['code_ostan'],"code_ostan","name_ostan","ostan","1=1 ORDER BY ostan.name_ostan ASC","class='text4'").'</td>
		  <td align="left"><span class="star">*</span> نوع انبار : &nbsp;</td><td align="right">'.static_listbox("location_type",$row2['location_type'],"locationtypeArr",1,"class='text4'").'</td>  
		 </tr>
		 <tr>
	      <td align="left">نوع مالکیت : &nbsp;</td><td align="right">'.static_listbox("noe_malekiyat",$row2['noe_malekiyat'],"noe_malekiyatArr",1,"class='text4'").'</td>
		  <td align="left"><span class="star">*</span> وضعیت پیمانکار : &nbsp;</td><td align="right">'.static_listbox("status_peymankar",$row2['status_peymankar'],"status_peymankarArr",1,"class='text4'").'</td>';
	      if($row2['status_peymankar']==1)//اگر پیمانکار دارد 
		   echo'<td align="left" class="vazayefshow"><span class="star">*</span> وظایف پیمانکار : &nbsp;</td><td align="right" class="vazayefshow">'.static_listbox("vazayef_peymankar",$row2['vazayef_peymankar'],"vazayef_peymankarArr",1,"class='text4'").'</td>';
		  else
		   echo'<td align="left" class="vazayefshow" style="display:none;"><span class="star">*</span> وظایف پیمانکار : &nbsp;</td><td align="right" class="vazayefshow" style="display:none;">'.static_listbox("vazayef_peymankar",$row2['vazayef_peymankar'],"vazayef_peymankarArr",1,"class='text4'").'</td>';
		  echo'
		 </tr>';	 
		 }
		 else
		 {
		  echo'
		  <td align="left"><span class="star">*</span> نام استان : &nbsp;</td><td align="right">'.listboxMe("code_ostan",$row2['code_ostan'],"code_ostan","name_ostan","ostan","1=1 ORDER BY ostan.name_ostan ASC","class='text4' disabled").'<input type="hidden" name="code_ostan" value="'.$row2['code_ostan'].'"/></td>
	      <td align="left"><span class="star">*</span> نوع انبار : &nbsp;</td><td align="right">'.static_listbox("location_type",$row2['location_type'],"locationtypeArr",1,"class='text4' disabled ").'<input type="hidden" name="location_type" value="'.$row2['location_type'].'"/></td>  
		 </tr>
         <tr>		
		  <td align="left"> نوع مالکیت : &nbsp;</td><td align="right">'.static_listbox("noe_malekiyat",$row2['noe_malekiyat'],"noe_malekiyatArr",1,"class='text4' disabled").'<input type="hidden" name="noe_malekiyat" value="'.$row2['noe_malekiyat'].'"/></td>
	      <td align="left"><span class="star">*</span> وضعیت پیمانکار : &nbsp;</td><td align="right">'.static_listbox("status_peymankar",$row2['status_peymankar'],"status_peymankarArr",1,"class='text4' disabled").'<input type="hidden" name="status_peymankar" value="'.$row2['status_peymankar'].'"/></td>';
          if($row2['status_peymankar']==1)//اگر پیمانکار دارد 
		   echo'<td align="left" class="vazayefshow"><span class="star">*</span> وظایف پیمانکار : &nbsp;</td><td align="right" class="vazayefshow">'.static_listbox("vazayef_peymankar",$row2['vazayef_peymankar'],"vazayef_peymankarArr",1,"class='text4' disabled").' <input type="hidden" name="vazayef_peymankar" value="'.$row2['vazayef_peymankar'].'"/></td>';
		  else
		   echo'<td align="left" class="vazayefshow" style="display:none;"><span class="star">*</span> وظایف پیمانکار : &nbsp;</td><td align="right" class="vazayefshow" style="display:none;">'.static_listbox("vazayef_peymankar",$row2['vazayef_peymankar'],"vazayef_peymankarArr",1,"class='text4'").'</td>';
		 echo' 
		 </tr>';
		 }
        echo'
        <tr>
	     <td align="left">شناسه پیمانکار : &nbsp;</td><td align="right"><input type="text" class="textboxme2" name="shenase_peymankar" value="'.$row2['shenase_peymankar'].'" '; if(!$right_edt) echo 'readonly'; echo' /></td>
	     <td align="left">نام پیمانکار : &nbsp;</td><td align="right"><input type="text" class="textboxme2" name="name_peymankar" value="'.$row2['name_peymankar'].'" '; if(!$right_edt) echo 'readonly'; echo' /></td>
		 <td align="left"><span class="star">*</span> ظرفیت اسمی سردخانه : &nbsp;</td>
		 <td align="right">
		  <input type="text" class="textboxme2" name="zarfiyat" value="'.$row2['zarfiyat'].'" onkeypress="return isNumber(event)" '; if(!$right_edt) echo 'readonly'; echo' >
		  حجم : <input type="text" class="textboxme2" name="hajm_esmi" value="'.$row2['hajm_esmi'].'" onkeypress="return isNumber(event)" >
		  وزن : <input type="text" class="textboxme2" name="vazn_esmi" value="'.$row2['vazn_esmi'].'" onkeypress="return isNumber(event)" >
		 </td>
	    </tr>
		<tr>
		 <td align="left"><span class="star">*</span> ماهیت سردخانه : &nbsp;</td><td align="right">';
		 if($right_edt)echo' '.static_listbox("situation_type",$row2['situation_type'],"situationtypeArr",1,"class='text4'").'';
		 else          echo' '.static_listbox("situation_type",$row2['situation_type'],"situationtypeArr",1,"class='text4' disabled").'<input type="hidden" name="situation_type" value="'.$row2['situation_type'].'"/>';
		 echo'
		 </td>
		 <td align="left"><span class="star">*</span> کد پستی : &nbsp;</td>
		 <td align="right"><input type="text"'; IF($row2['post_error_code']==0)  {echo 'readonly';}  echo'  class="textboxme2" name="postal_code" value="'.$row2['postal_code'].'" maxlength="10" onkeypress="return isNumber(event)"/>
		 <input type="hidden" name="post_error_code" value="'.$row2['post_error_code'].'" />';
		 IF($row2['post_error_code']==0) echo'<span class="fa fa-check-circle" style="color:green"></span>';echo'
		 </td>
		 
		 <td align="left"><span class="star">*</span> ظرفیت قراردادی انبار : &nbsp;</td>
		 <td align="right">
		  <input type="text" class="textboxme2" name="zarfiyat_gharardadi" value="'.$row2['zarfiyat_gharardadi'].'" onkeypress="return isNumber(event)" '; if(!$right_edt) echo 'readonly'; echo' >
		  حجم : <input type="text" class="textboxme2" name="hajm_gharadadi" value="'.$row2['hajm_gharadadi'].'" onkeypress="return isNumber(event)" >
		  وزن : <input type="text" class="textboxme2" name="vazn_gharadadi" value="'.$row2['vazn_gharadadi'].'" onkeypress="return isNumber(event)" >
		 </td>
		</tr>
	    <tr>
		 <td align="left"><span class="star">*</span> وضعیت سردخانه : &nbsp;</td><td align="right">';
		 IF($right_edt_activate)echo ''.static_listbox("activate",$row2['activate'],"activateArr",1,"class='text4'").'';
		 ELSE echo ''.static_listbox("activate",$row2['activate'],"activateArr",1,"class='text4' disabled").'<input type="hidden" name="activate" value="'.$row2['activate'].'" />';
		 echo'
		 </td>
		 <td align="left">اتصال به سیستم فروش : &nbsp;</td><td align="right"><input type="checkbox" name="chkforush" '.$forush_checked.' '; if(!$right_edt) echo 'disabled'; echo' /></td>
		 <td align="left"> ظرفیت تخلیه و بارگیری روزانه : &nbsp;</td>
		 <td align="right">
		  <input type="text" class="textboxme2" name="zarfiyat_takhlie_bargiri" value="'.$row2['zarfiyat_takhlie_bargiri'].'" onkeypress="return isNumber(event)" '; if(!$right_edt_zarfiyat_tb) echo 'readonly'; echo' >
		 </td>
		 <!--<td align="left">اتصال به سیستم مبادی : &nbsp;</td><td align="right"><input type="checkbox" name="chkmabadi" '.$mabadi_checked.'/></td>-->
		</tr>
		<tr>
	     <td align="left">ارسال اطلاعات به وب سرویس : &nbsp;</td><td align="right"><input type="checkbox" name="chkwebservice" '.$webservice_checked.' '; if(!$right_edt) echo 'disabled'; echo' /></td>';			    
	     if (SuperUser()) echo'<td align="left">sell_id_ostan : &nbsp;'.$sell_id_ostan.'</td><td align="left">sell_id_anbar : &nbsp;'.$sell_id_anbar.'</td>';
		 echo'		 
		 <td align="left"><span class="star">*</span> وضعیت اتصال به سیستم توزین : &nbsp;</td><td align="right" >';
		 if($right_edt) echo''.static_listbox("chktozin",$row2['chktozin'],"connect_tozinArr",1,"class='text4'").'';
		 else           echo''.static_listbox("chktozin",$row2['chktozin'],"connect_tozinArr",1,"class='text4' disabled").'<input type="hidden" name="chktozin" value="'.$row2['chktozin'].'"/>';
		 echo'
		 <span class="chapShow" style="display:none;">&nbsp;تعداد چاپ قبض باسکول : <input type="text" class="textboxme2" name="bsk_chap_r" value="'.$row2['bsk_chap_r'].'" onkeypress="return isNumber(event)" style="width:50px" '; if(!$right_edt) echo 'readonly'; echo' /></span></td>';
		echo'
		</tr>
		<tr>
	     <td align="left">آیدی واحد :&nbsp;</td><td align="right"><input type="text" class="textboxme2" name="warehouse_id" value="'.$row2['warehouse_id'].'"  /></td>
		 <td align="left" ><span class="star">*</span> شناسه ملی انبار: &nbsp;</td><td align="right"><input type="text" required   class="textboxme2" name="shenase_meli_anbar" value="'.$row2['shenase_meli_anbar'].'" onkeypress="return isNumber(event)" '; if(!$right_edt_shenase) echo 'readonly'; echo'/></td>
	     <td align="left">تلفن انبار : &nbsp;</td><td align="right"><input type="text" class="textboxme2" name="anbar_tel" value="'.$row2['anbar_tel'].'" onkeypress="return isNumber(event)" '; if(!$right_edt) echo 'readonly'; echo' ></td>		 

		 <!--<td align="left"> مشاهده همه حواله فروشها : &nbsp;</td><td align="right" ><input type="checkbox" name="chkhavaleshow" '.$havaleshow_checked.' '; if(!$right_edt_chkhavaleshow) echo 'readonly'; echo'/></td>
		     <td align="left"> مشاهده حواله فروش ها از تاریخ : &nbsp;</td><td align="right" ><input type="text" class="textboxme2 datepicker6" maxlength="10" name="date_havaleshow" value="'.$row2['date_havaleshow'].'"  ></td>
		 -->	 
		</tr>
		<tr>
	     <td align="left">آدرس سردخانه : &nbsp;</td><td align="right" colspan="5"><input type="text" class="textboxme" name="address_anbar" value="'.$row2['full_address'].'" readonly ></td>
        </tr>
		 <input type="hidden" readonly class="textboxme" name="province" value="'.$row2['province'].'"  />
	     <input type="hidden" readonly class="textboxme" name="township" value="'.$row2['township'].'"  />
	     <input type="hidden" readonly class="textboxme" name="zone" value="'.$row2['zone'].'"  />
	     <input type="hidden" readonly class="textboxme" name="village" value="'.$row2['village'].'"  />
	     <input type="hidden" readonly class="textboxme" name="localitytype" value="'.$row2['localitytype'].'"  />
	     <input type="hidden" readonly class="textboxme" name="localityname" value="'.$row2['localityname'].'"  />
	     <input type="hidden" readonly class="textboxme" name="localitycode" value="'.$row2['localitycode'].'"  />
	     <input type="hidden" readonly class="textboxme" name="sublocality" value="'.$row2['sublocality'].'"  />
	     <input type="hidden" readonly class="textboxme" name="street" value="'.$row2['street'].'"  />
	     <input type="hidden" readonly class="textboxme" name="street2" value="'.$row2['street2'].'"  />
	     <input type="hidden" readonly class="textboxme" name="housenumber" value="'.$row2['housenumber'].'"  />
	     <input type="hidden" readonly class="textboxme" name="floor" value="'.$row2['floor'].'"  />
	     <input type="hidden" readonly class="textboxme" name="sidefloor" value="'.$row2['sidefloor'].'"  />
	     <input type="hidden" readonly class="textboxme" name="buildingname" value="'.$row2['buildingname'].'"  />
	     <input type="hidden" readonly class="textboxme" name="description" value="'.$row2['description'].'"  />
	    
	    <tr class="title">
         <td colspan="8" align="center">
		  <input class="buttonme" type="submit" name="Edit_x" id="sabt" value="ثبت تغييرات">
          <input class="buttonme" type="button" name="Forget" value="انصراف" onClick="window.location=\''.$FileName.'?PageNo='.$PageNo.'&RowPerPage='.$RowPerPage.'&order='.$order.'\'">
         </td>
        </tr>
       </table>
	  </td>
     </tr>';
    }
    if ($Mode=="Search") //Search Mode
    {echo '
    <tr> 
	 <td width="99%" class="borderall" style="position:absolute;bottom:10px;left:0.5%;"> 	 
	  <table class="footer-panel" width="100%" cellpadding="0" cellspacing="0">
       <tr class="title"><td colspan="10" align="center">جستجوی سردخانه</td></tr>  
	   <tr>
	    <td align="left" width="150px"> شناسه : &nbsp;</td><td align="right"><input type="text" class="textboxme2" name="id" value="'.$id.'"  onkeypress="return isNumber(event)" style="width:50px"/>	     </td>
	    <td align="left" width="150px"> کد سردخانه : &nbsp;</td><td align="right"><input type="text" class="textboxme2" name="code_anbar" value="'.$code_anbar.'"  maxlength="3" title="برای کد انبار سه رقم وارد نمایید" onkeypress="return isNumber(event)" style="width:50px"/>	     <img border="0" src="images/Info1.png" title="برای کد انبار عددی بین 100 تا 300 قابل قبول است" onmouseOver="this.src=\'images/Info_h.png\'" onmouseOut="this.src=\'images/Info1.png\'" style="width:16px;height:16px;cursor:pointer"/></td>
	    <td align="left" width="150px"> شناسه یکتا سردخانه : &nbsp;</td><td align="right"><input type="text" class="textboxme2" name="shenase_yekta" value="'.$shenase_yekta.'" onkeypress="return isNumber(event)"/></td>
	    <td align="left" width="150px"> نام سردخانه : &nbsp;</td><td align="right"><input type="text" class="textboxme" name="name_anbar" value="'.$name_anbar.'" ></td>
       </tr>
       <tr>
	    <td align="left" width="150px"> نام استان : &nbsp;</td><td align="right">'.listbox("code_ostan",$code_ostan,"code_ostan","name_ostan","ostan","1=1 ORDER BY ostan.name_ostan ASC","class='text4'").'</td>
        <td align="left">وضعیت پیمانکار : &nbsp;</td><td align="right">'.static_listbox("status_peymankar",$status_peymankar,"status_peymankarArr",1,"class='text4'").'</td>
	    <td align="left">شناسه پیمانکار : &nbsp;</td><td align="right"><input type="text" class="textboxme2" name="shenase_peymankar" value="'.$shenase_peymankar.'"/></td>
	    <td align="left">نام پیمانکار : &nbsp;</td><td align="right"><input type="text" class="textboxme2" name="name_peymankar" value="'.$name_peymankar.'"/></td>
        <td align="left" class="vazayefshow" style="display:none;"> وظایف پیمانکار : &nbsp;</td><td align="right" style="display:none;" class="vazayefshow">'.static_listbox("vazayef_peymankar",$vazayef_peymankar,"vazayef_peymankarArr",1,"class='text4'").'</td>
	   </tr>
	   <tr>
	    <td align="left">نوع مالکیت : &nbsp;</td><td align="right">
		                             <select name="noe_malekiyat" class="text4">
	                                  <option value="0">انتخاب کنید</option>
	                                  <option value="1">ملکی</option>
	                                  <option value="2">استیجاری</option>
	                                  <option value="3">امانی</option>
	                                  <option value="4">مرکز خرید</option>
	                                  <option value="5">تحت کلید گمرک</option>
									 </select></td>  
		<td align="left"> وضعیت سردخانه : &nbsp;</td><td align="right">
		 <select name="activate" class="text4">
	                                  <option value="0">انتخاب کنید</option>
	                                  <option value="1">فعال</option>
	                                  <option value="2">غیر فعال</option>
									 </select>
		</td> 
		<td align="left">ارسال به وب سرویس :&nbsp;</td>
		 <td align="right">
		  		 <select name="chkwebservice" class="text4">
	                                  <option value="-1">انتخاب کنید</option>
	                                  <option value="1">بله</option>
	                                  <option value="0">خیر</option>
									 </select>
		  <!--<input type="checkbox" name="chkwebservice" '.$webservice_checked.'/>-->
		 </td>
	    <td align="left"> ماهیت سردخانه : &nbsp;</td><td align="right">
						 <select name="situation_type" class="text4">
	                                  <option value="-1">انتخاب کنید</option>
	                                  <option value="1">حقیقی</option>
	                                  <option value="2">مجازی</option>
									 </select>
		</td> 
	   </tr>
	   <tr>
	    <td align="left">کدپستی :&nbsp;</td><td align="right" ><input type="text" class="textboxme2" name="postal_code" value="'.$postal_code.'" /></td>
	    <td align="left">آیدی واحد(صمت) :&nbsp;</td><td align="right" ><input type="text" class="textboxme2" name="warehouse_id" value="'.$warehouse_id.'"  /></td>
	   </tr>
	   <tr>
	    <td align="left">اتصال به سیستم فروش : &nbsp;</td><td align="right"><input type="checkbox" name="chkforush" '.$forush_checked.'/></td>
	    <td align="left">اطلاعات صاحب سردخانه :&nbsp;</td>
		<td align="right">
		  		 <select name="exist_owner" class="text4">
	                                  <option value="-1">انتخاب کنید</option>
	                                  <option value="1">دارد</option>
	                                  <option value="0">ندارد</option>
				 </select>
		 </td>
		 <td align="left">اتصال به سیستم توزین : &nbsp;</td><td align="right"><input type="checkbox" name="chktozin" '.$tozin_checked.'/></td>
	   
	   </tr>
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
 <!-- پايان فوتر-->';
echo'	
</table>
</div>';
echo'
'.$message.'
</form>
</body>
</html>';	
?>