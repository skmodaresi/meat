<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
/***************************ajax شروع**********************************/
if(isset($_POST['shomareHAVALEFORUSH']))//آمدن اطلاعات حواله فروش در حواله سردخانه
{
 if($_SESSION['mt_systemforush']==0)//اطلاعات حواله فروش از سیستم سردخانه
 { 
	// $result5 =mysql_query("SELECT havale_forush.*,kala.name_kala,bastebandy.sharh_bastebandy,
	                       // moshtary.code_customer,moshtary.name_customer,ostan.name_ostan,shahrestan.city_name											     
	 					   // FROM havale_forush
                           // INNER JOIN kala ON havale_forush.code_kala=kala.code_kala              
                           // INNER JOIN bastebandy ON bastebandy.code_bastebandy=kala.code_bastebandy              
                           // INNER JOIN moshtary ON havale_forush.code_customer=moshtary.code_customer AND moshtary.code_ostan=havale_forush.code_ostan           
                           // INNER JOIN ostan ON moshtary.code_ostan=ostan.code_ostan           
                           // INNER JOIN shahrestan ON moshtary.city_code=shahrestan.city_code and ostan.code_ostan=shahrestan.code_ostan						  
                           // WHERE h_code='$shomareHAVALEFORUSH' AND havale_forush.h_reg_date>='$bzStartDateSh'  AND havale_forush.code_ostan='".$_SESSION['mt_code_ostan']."' AND havale_forush.code_anbar='".$_SESSION['mt_code_anbar']."' AND havale_forush.year=".$_SESSION["mtActiveYear"]." AND havale_forush.deleted=0");
   	$result5 =mysql_query("SELECT havale_forush.*,kala.name_kala,kala.code_bastebandy,bastebandy.sharh_bastebandy,moshtary.code_customer,moshtary.name_customer FROM havale_forush
                           INNER JOIN kala ON havale_forush.code_kala=kala.code_kala              
                           INNER JOIN bastebandy ON bastebandy.code_bastebandy=kala.code_bastebandy              
                           INNER JOIN moshtary ON havale_forush.code_customer=moshtary.code_customer          
                           WHERE h_code='$shomareHAVALEFORUSH' AND havale_forush.h_reg_date>='$bzStartDateSh'  AND havale_forush.code_ostan='".$_SESSION['mt_code_ostan']."' AND havale_forush.code_anbar='".$_SESSION['mt_code_anbar']."' AND havale_forush.year=".$_SESSION["mtActiveYear"]." AND havale_forush.deleted=0");
   $row5=mysql_fetch_assoc($result5);
   //بدست آوردن موجودی کالا
   // $res5_1=mysql_query("SELECT * FROM mojody_kala WHERE code_kala=".$row5['code_kala']." AND code_ostan='".$_SESSION['mt_code_ostan']."' AND code_anbar='".$_SESSION['mt_code_anbar']."' AND year=".$_SESSION["mtActiveYear"]." AND deleted=0");
   // $row5_1=mysql_fetch_array($res5_1);
   //محاسبه مقدار تحویلی
   $meghdar_tahvily=tahvily_az_forush($row5['h_code'],$row5['code_ostan'],$row5['code_anbar'],$row5['year'],$row5['code_bastebandy']);
   //محاسبه مقدار باطله
   $q21="SELECT SUM(meghdar_batele) FROM ebtal WHERE h_code='".$row5['h_code']."' AND code_ostan='".$_SESSION['mt_code_ostan']."' AND code_anbar='".$_SESSION['mt_code_anbar']."' AND year=".$_SESSION["mtActiveYear"]." AND deleted=0";
   $res21=mysql_query($q21);
   $meghdar_batele=mysql_fetch_array($res21);
   /**///$mande_az_forush=$row5['meghdar_havale_forush']-$meghdar_tahvily-$meghdar_batele[0];//محاسبه مقدار مانده از حواله فروش
   $mande_az_forush=$row5['mande_az_forush'];
   //بدست آوردن نرخ بارگیری کالا اگر انبار پیمانکار دارد
   if($_SESSION['mt_status_peymankar']==1)
   {
	 $res_sh_bargiry=$db->query("SELECT sh_jadval_bargiry FROM hazine_bargiry WHERE code_ostan='$mt_gl_code_ostan' AND deleted=0 order by sh_jadval_bargiry DESC LIMIT 0,1");//شماره آخرین جدول هزینه بارگیری
     $row_sh=$db->fetch_assoc($res_sh_bargiry);
	 if(mysql_num_rows($res_sh_bargiry)>0)
	 {
       $nerkhBargiry=$db->get_from_where("nerkh_bargiry","hazine_bargiry_detail","sh_jadval_bargiry=".$row_sh['sh_jadval_bargiry']." AND code_ostan='".$_SESSION['mt_code_ostan']."' AND code_kala='".$row5['code_kala']."'"); 
	 }
   } 
	$mojody_img='<img border="0" src="images/image(7).gif" onClick="window.open(\'help_mojodykala.php?code_kala_='.$row5['code_kala'].'\',\'_blank\',\'width=750px,left=400px,top=100px,scrollbars=yes\')" title="جدول موجودی کالا" style="width:22px;height:22px;cursor:pointer" onmouseOver="this.src=\'images/image(8).gif\'" onmouseOut="this.src=\'images/image(7).gif\'"/>';
    if($row5['code_bastebandy']==2) $vahed_andazegiry=' (تعداد قوطی)';
    else if($row5['code_bastebandy']==5) $vahed_andazegiry=' (تعداد دست)';
    else if($row5['code_bastebandy']==6) $vahed_andazegiry=' (تعداد)';
    else if(($row5['code_kala']==50)OR($row5['code_kala']==54)) $vahed_andazegiry=' (تعداد شانه)';
	else $vahed_andazegiry=' (کیلوگرم)';
   if(($row5['code_ostan']==$_SESSION['mt_code_ostan'])and($row5['code_anbar']==$_SESSION['mt_code_anbar'])and($row5['year']==$_SESSION['mtActiveYear'])) 
   {echo $row5['h_reg_date'].'^'.$row5['code_kala'].'^'.$row5['name_kala'].'^'.$row5['sharh_bastebandy'].'^'.$row5['code_customer'].'^'.$row5['name_customer'].'^'.$row5['name_ostan'].'^'.$row5['city_name'].'^'.$row5['h_deli_name'].'^'.$row5['meghdar_havale_forush'].'^'.$meghdar_tahvily.'^'.$meghdar_batele[0].'^'.$mande_az_forush.'^'.$nerkhBargiry.'^'.$row5['id'].'^'.$vahed_andazegiry.'^'.$mojody_img;}
   else
    echo '';
  }
  else//اطلاعات حواله فروش از سیستم فروش
  {
   mysql_select_db('sell') or die('no Select Db BECAUSE: ' . mysql_error());
   
   $TableName="dm_havale";
   // //پیدا کردن آی دی کد استان مربوط به سیتم فروش
    // $res_ostan=mysql_query("SELECT province_id FROM dm_province WHERE province_code='$mt_gl_code_ostan'");
    // $sell_id_ostan=mysql_result($res_ostan, 0, 'province_id');
   // //پیدا کردن آی دی کد انبار مربوط به سیستم فروش
	// $res_anbar=mysql_query("SELECT l_id FROM dm_location_goods WHERE l_id_province='$sell_id_ostan' AND l_code='$mt_gl_code_anbar'");
    // $sell_id_anbar=mysql_result($res_anbar, 0, 'l_id');
   // //پیدا کردن آی دی سال مربوط به سیستم فروش
    // $sellYearCode=substr($mtActiveYear,2);
    // $res_sal=mysql_query("SELECT year_id FROM dm_year WHERE year_code='$sellYearCode'");
    // $sellYearId=mysql_result($res_sal, 0, 'year_id');
	// $result5=mysql_query("SELECT $TableName.h_code,$TableName.h_reg_date,$TableName.h_p_code,dm_listprod.p_name,dm_prod_det_p.pack_prod_name,
	                     // dm_prod_det_u.unit_prod_name,$TableName.h_customer_code,$TableName.h_id_province,$TableName.h_l_code,$TableName.h_id_year,dm_customer_asli.code_customer,
						 // dm_customer_asli.name_customer,dm_province.province_name,$TableName.h_pre_amount 
                         // FROM $TableName
					     // LEFT OUTER JOIN dm_listprod ON $TableName.h_p_code=dm_listprod.p_code
				         // LEFT OUTER JOIN dm_prod_det_p ON dm_prod_det_p.pack_prod_id=dm_listprod.p_pakage_type              
				         // LEFT OUTER JOIN dm_prod_det_u ON dm_prod_det_u.unit_prod_id=dm_listprod.p_unit              
						 // LEFT OUTER JOIN dm_customer_asli ON $TableName.h_customer_code=dm_customer_asli.code_customer
						 // LEFT OUTER JOIN dm_province ON dm_customer_asli.customer_province_id=dm_province.province_id
						 // LEFT OUTER JOIN dm_city ON  dm_customer_asli.customer_city_id=dm_city.city_id AND dm_city.city_province=dm_province.province_id 
						 // WHERE $TableName.h_code='$shomareHAVALEFORUSH' AND $TableName.h_id_province='$sell_id_ostan' AND $TableName.h_l_code='$sell_id_anbar' AND $TableName.h_id_year='$sellYearId'");   	
	$result5=mysql_query("SELECT $TableName.h_id,$TableName.h_code,$TableName.h_reg_date,$TableName.h_p_code,$TableName.h_customer_code,$TableName.h_id_province,
                         $TableName.h_l_code,$TableName.h_id_year,$TableName.h_deli_name,$TableName.h_mande_havale,dm_customer_asli.code_customer,dm_customer_asli.name_customer,
                         dm_province.province_name,dm_city.city_name,$TableName.h_pre_amount 
                         FROM $TableName
						 LEFT OUTER JOIN dm_customer_asli ON $TableName.h_customer_code=dm_customer_asli.code_customer
						 LEFT OUTER JOIN dm_province ON dm_customer_asli.customer_province_id=dm_province.province_id
						 LEFT OUTER JOIN dm_city ON  dm_customer_asli.customer_city_id=dm_city.city_id AND dm_city.city_province=dm_province.province_id 
						 WHERE $TableName.h_code='$shomareHAVALEFORUSH' AND $TableName.h_reg_date>='$bzStartDateMi' AND $TableName.h_id_province='$sell_id_ostan' AND $TableName.h_l_code='$sell_id_anbar' AND $TableName.h_id_year='$sellYearId'");
    $row5=mysql_fetch_assoc($result5);
   //تبدیل تاریخ میلادی به شمسی
	$sql_tarikh=$row5['h_reg_date'];
    $d=substr($sql_tarikh,8,2);
    $m=substr($sql_tarikh,5,2);
    $y=substr($sql_tarikh,0,4);
    $shamsi=gregorian_to_jalali($y,$m,$d);
    $sal=$shamsi[0];
    $mah=$shamsi[1];
    $rouz=$shamsi[2];
    $tarikh_forush=$sal.'/'.$mah.'/'.$rouz;
	//مجموع مقدار ابطالی های این حواله فروش در سیستم فروش
	 $q6="SELECT SUM(his_eb_amount) FROM dm_his_havale WHERE his_h_code=".$row5['h_code']." AND his_id_province='$sell_id_ostan' AND his_l_code='$sell_id_anbar' And his_id_year='$sellYearId'";	   
	 $res6=mysql_query($q6);
	 $row6=mysql_fetch_array($res6);
	 $batele_forush=$row6[0];
	 $mande_az_forush=$row5['h_mande_havale'];//خواندن مانده از فیلد مانده 
	//اطلاعات لازم از سیستم سردخانه 
	mysql_select_db($mydatabase) or die('no Select Db BECAUSE: ' . mysql_error());
    //نام کالا و نوع بسته بندی از سیستم سردخانه
     $res_kala=mysql_query("SELECT kala.code_kala,kala.name_kala,kala.code_bastebandy,bastebandy.sharh_bastebandy FROM kala INNER JOIN bastebandy ON kala.code_bastebandy=bastebandy.code_bastebandy WHERE kala.code_kala=".$row5['h_p_code']."");
     $row_kala=mysql_fetch_assoc($res_kala);
	 $nameKALA=$row_kala['name_kala'];
	 $noeBASTE=$row_kala['sharh_bastebandy'];
	 //بدست آوردن موجودی کالا
      //$res5_1=mysql_query("SELECT * FROM mojody_kala WHERE code_kala=".$row5['h_p_code']." AND code_ostan='".$_SESSION['mt_code_ostan']."' AND code_anbar='".$_SESSION['mt_code_anbar']."' AND year=".$_SESSION["mtActiveYear"]." AND deleted=0");
       //$row5_1=mysql_fetch_array($res5_1);
    //محاسبه مقدار تحویلی
	$meghdar_tahvily=tahvily_az_forush($row5['h_code'],$_SESSION['mt_code_ostan'],$_SESSION['mt_code_anbar'],$_SESSION['mtActiveYear'],$row_kala['code_bastebandy']);
	/**///$mande_az_forush=$row5['h_pre_amount']-$meghdar_tahvily-$batele_forush;//محاسبه مقدار مانده از حواله فروش
   //بدست آوردن نرخ بارگیری کالا اگر انبار پیمانکار دارد
    if($_SESSION['mt_status_peymankar']==1)
    {
	  $res_sh_bargiry=$db->query("SELECT sh_jadval_bargiry FROM hazine_bargiry WHERE code_ostan='$mt_gl_code_ostan' AND deleted=0 order by sh_jadval_bargiry DESC LIMIT 0,1");//شماره آخرین جدول هزینه بارگیری
      $row_sh=$db->fetch_assoc($res_sh_bargiry);
	  if(mysql_num_rows($res_sh_bargiry)>0)
	  {
        $nerkhBargiry=$db->get_from_where("nerkh_bargiry","hazine_bargiry_detail","sh_jadval_bargiry=".$row_sh['sh_jadval_bargiry']." AND code_ostan='".$_SESSION['mt_code_ostan']."' AND code_kala='".$row5['code_kala']."'"); 
	  }
    } 
    $mojody_img='<img border="0" src="images/animated_help.gif" onClick="window.open(\'help_mojodykala.php?code_kala_='.$row5['h_p_code'].'\',\'_blank\',\'width=750px,left=400px,top=100px,scrollbars=yes\')" title="جدول موجودی کالا" style="width:20px;height:20px;cursor:pointer" onmouseOver="this.src=\'images/help_center.png\'" onmouseOut="this.src=\'images/animated_help.gif\'"/>';
    if($row_kala['code_bastebandy']==2) $vahed_andazegiry=' (تعداد قوطی)';
    else if($row_kala['code_bastebandy']==2) $vahed_andazegiry=' (تعداد دست)';
    else if(($row_kala['code_kala']==50)and($row_kala['code_kala']==54)) $vahed_andazegiry=' (تعداد شانه)';
    else $vahed_andazegiry=' (کیلوگرم)';
	if(($row5['h_id_province']==$sell_id_ostan)and($row5['h_l_code']==$sell_id_anbar)and($row5['h_id_year']==$sellYearId)) 
    {echo $tarikh_forush.'^'.$row5['h_p_code'].'^'.$nameKALA.'^'.$noeBASTE.'^'.$row5['h_customer_code'].'^'.$row5['name_customer'].'^'.$row5['province_name'].'^'.$row5['city_name'].'^'.$row5['h_deli_name'].'^'.$row5['h_pre_amount'].'^'.$meghdar_tahvily.'^'.$batele_forush.'^'.$mande_az_forush.'^'.$nerkhBargiry.'^'.$row5['h_id'].'^'.$vahed_andazegiry.'^'.$mojody_img;}
	//{echo $tarikh_forush.'^'.$row5['h_p_code'].'^'.$row5['p_name'].'^'.virgul($row5_1['mojody']).'^'.$row5['pack_prod_name'].'^'.$row5['h_customer_code'].'^'.$row5['name_customer'].'^'.$row5['province_name'].'^'.$row5['city_name'].'^'.virgul($row5['h_pre_amount']).'^'.virgul($meghdar_tahvily[0]).'^'.virgul($batele_forush).'^'.virgul($mande_az_forush).'^'.$nerkhBargiry;}
    else
	 echo ''; 
  }
} 
?>