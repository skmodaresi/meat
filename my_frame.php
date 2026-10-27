<?php
session_start();
error_reporting(0);
include("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
//IF($_SESSION['mt_first_login']==1)include('profile.php');
IF($_SESSION['mt_first_login']==1){echo "<script>window.location.href='profile.php'</script>";}
ELSE 
{
  IF(($mt_gl_code_ostan!=-1)AND($mt_gl_code_anbar!=-1))
  {
   $post_error_code=$db->get_from_where("post_error_code","list_sardkhane","code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar'");
   IF($post_error_code!=0)
   {
	$postal_code=$db->get_from_where("postal_code","list_sardkhane","code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar'");
    $wsdl_postal_url='http://10.7.1.40/GetPostinfo/postServices.asmx?wsdl';
    header('Content-Type: text/html; charset=utf-8');
    $client=new SoapClient($wsdl_postal_url);
    $params=array('username'=>'agriDam','password'=>'3rt67HM','postalcode'=>$postal_code);
    $result=$client->GetAddressByPostalCode($params);
    $response=$result->GetAddressByPostalCodeResult;
    $ErrorCode=$response->ErrorCode;
    $ErrorMessage=$response->ErrorMessage;     
   }
  }	  
 echo'
 <!DOCTYPE html>
 <html>
 <head>
 <meta charset="UTF-8">
 <title>سيستم سردخانه</title>
 <meta http-equiv="Content-Language" content="fa">
 <link href="styles.css" type="text/css" rel="stylesheet">
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 <body>
 <div class="" style="margin-top:10px" align="center">
  <table border="0" cellpadding="0" cellspacing="0" width="100%" align="center">
   <!--<tr><td align="center">لطفا برای آپدیت فونت صفحات یکبار کلید ctrl و F5 کیبورد را بزنید</td></tr>-->';
   IF(($mt_gl_code_ostan!=-1)and ($mt_gl_code_anbar!=-1))//
   {
	$count_resid_wberror=$db->get_from_where("COUNT(*)","resid","code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND tarikh_resid>'1402/11/09' AND noe_tahvil_bar!=9 and status=0 and sabt_nahayi=1 and (wb_id IS NULL OR wb_id=0) ");
	$count_havale_wberror=$db->get_from_where("COUNT(*)","havale","code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND tarikh_havale_anbar>'1402/11/09' AND noe_tahvil_bar!=9 and status=0 and sabt_nahayi=1 and (wb_id IS NULL OR wb_id=0) ");
	IF(($count_resid_wberror>0)OR($count_havale_wberror>0))
	{
	  echo'
	  <script> 
		Swal.fire({
          title: "رسیدو حواله های ثبت نشده در سامانه جامع انبارها",
          text:"تعداد ' .$count_resid_wberror.' رسید در سامانه جامع ثبت نشده است .تعداد ' .$count_havale_wberror.' حواله در سامانه جامع ثبت نشده است",
          icon: "info",
          confirmButtonText: "متوجه شدم",
		  Width : "1000px",
		  showCloseButton :"true"
        })
			  
	  </script>';
	}
	$owner=$db->get_from_where("COUNT(*)","list_sardkhane_owner","code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar");
	IF($owner==0)
	{
	 echo'
	 <tr>
	   <td align="center" style="font-size:14px">
	   کاربر گرامی اطلاعات صاحب سردخانه شما تکمیل نشده است ،
	   برای ثبت نام سردخانه شما در سامانه جامع انبارها این اطلاعات ضروری است.
	   <br>
	   برای تکمیل اطلاعات از قسمت جداول پایه گزینه سردخانه ها را انتخاب کنید و اطلاعات صاحب سردخانه را تکمیل کنید
	   شایان ذکر است در صورت عدم اصلاح تا تاریخ 12 مرداد
	   سردخانه شما غیرفعال می گردد.
	   </td>
	 </tr>';
		 
	}
   }
   IF($ErrorCode!=0)//ErrorCode:40 or 51
   {
	 echo'
	 <tr>
	   <td align="center" style="font-size:14px">
	   کاربر گرامی کدپستی انبار شما نادرست می باشد ،
	   لطفا نسبت به اصلاح کد پستی اقدام نمایید.
	   <br>
	   برای دریافت کد پستی می توانید به سایت پست به آدرس
       <a href="https://epostcode.post.ir/postcode">https://epostcode.post.ir/postcode</a>
	   مراجعه فرمایید.
	   </td>
	 </tr>';
   }
   echo'
   <tr>
    <td align="center" height="100%">
     <img src="images/warehouse4.jpg"/>
    </td>
   </tr>
  </table>
 </div> 
 </body>
 </html>';
}
?>