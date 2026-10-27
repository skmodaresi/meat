<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="print_resid_one.php";
$TableName="resid";
$today=AsLDate($yymmdd);
$logtime=date('H:i');
$titr='چاپ رسید سردخانه';
echo'
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>'.$titr.'</title>
<link href="styles.css" rel="stylesheet" type="text/css"/>
<style>
       @media screen
       {
           .hideatprint
           {
           }
       }
       @media print
       {
           .hideatprint
           {
               display: none;
           }
       }
</style>
<script type="text/javascript" src="functions.js"></script>
</head>';
/***************************************** MAIN*****************************************/
$q1="SELECT T.*,mt_skk.name_skk,shomare_safar.shomare_safar,mabady_vorudy.name_mabda,ostan.name_ostan,list_sardkhane.name_anbar,takhlie.sharh_takhlie,peymankar_haml.name_peymankar_haml,bastebandy.sharh_bastebandy
      FROM $TableName T
	  LEFT OUTER JOIN bastebandy ON T.code_bastebandy=bastebandy.code_bastebandy  	  
	  LEFT OUTER JOIN mt_skk ON T.code_skk=mt_skk.code_skk  	  
	  LEFT OUTER JOIN shomare_safar ON T.id_safar=shomare_safar.id_safar
	  LEFT OUTER JOIN mabady_vorudy ON T.code_mabda=mabady_vorudy.code_mabda
	  LEFT OUTER JOIN ostan ON T.code_ostan_mabda=ostan.code_ostan
      LEFT OUTER JOIN list_sardkhane ON T.code_ostan_mabda=list_sardkhane.code_ostan AND T.code_anbar_mabda=list_sardkhane.code_anbar  
      LEFT OUTER JOIN takhlie ON T.code_takhlie=takhlie.code_takhlie
      LEFT OUTER JOIN peymankar_haml ON T.code_peymankar_haml=peymankar_haml.code_peymankar_haml
	  WHERE T.id='$id_'"; 
 $res1=$db->query($q1);
 $row1=$db->fetch_assoc($res1);
 //خرید
 if(($row1['noe_tahvil_bar']==1)or($row1['noe_tahvil_bar']==2)or($row1['noe_tahvil_bar']==3))
 {
	//*az gharardad kharid*//
	$q1_1="SELECT gharardad_kharid.* FROM gharardad_kharid 
           WHERE gharardad_kharid.shomare_gharardad=(SELECT shomare_safar FROM shomare_safar WHERE id_safar=".$row1['id_safar'].") AND gharardad_kharid.deleted=0";
	
	$res1_1=mysql_query($q1_1);
	if(mysql_num_rows($res1_1)>0)// اگر قرارداد وجود دارد
    {
      $row1_1=mysql_fetch_assoc($res1_1);
	  //چک کردن تاریخ اتمام قرارداد
	  $exist_elhaghie_date=$db->get_from_where("COUNT(*)","meat.elhaghie_kharid","id_gharardad='".$row1_1['id_gharardad']."' AND LENGTH(tarikh_etmam_elhaghie)='10' AND deleted=0 ");
      if($exist_elhaghie_date>0)//اگر الحاقیه دارد
      {
        $tarikh_etmam_elhaghie=$db->get_from_where("tarikh_etmam_elhaghie","meat.elhaghie_kharid","id_gharardad='".$row1_1['id_gharardad']."' AND LENGTH(tarikh_etmam_elhaghie)='10' AND deleted=0 ORDER BY tarikh_elhaghie,id_elhaghie DESC"); 
        $tarikh_etmam=$tarikh_etmam_elhaghie;
      }
      else//اگر الحاقیه ندارد
      {
       $tarikh_etmam=$row1_1['tarikh_etmam'];
      }
    }
  }
$bankRanande=$db->get_from_where("nb_noe_bank","payroll.pay_c_noe_bank","id=".$row1['bank_ranande'].""); 
echo'
<body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<br>
<table width="99%" border="1" height="100%" align="center" cellpadding="0" cellspacing="0">
 <!--هدر-->
 <tr>
  <td>
   <table width="100%" border="0" align="center">
    <tr><td class="print_title_2">'.$mt_gl_owner.'</td></tr>
    <tr><td class="print_title_2"> نسخه ی  : '.$mt_gl_name_anbar.' &nbsp;&nbsp; استان : '.$mt_gl_name_ostan.'</td></tr>
    <tr><td class="print_title_2">رسید سردخانه
	     <a href="javascript:window.print();"><span style="float:right" id="printerReport" class="hideatprint" title="چاپ"></span></a>
		</td>
	</tr>
   </table>
  </td>
 </tr> 	 
 <!--پايان هدر-->
 <!-- مرکز صفحه--> 
 <tr>
  <td height="100%">
   <div style="float:right;width:100%;margin:0px;height:100%;overflow:auto;overflow-x:hidden;">
   <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
	<tr class="print_tr1">
	 <td colspan="3">
      <table border="0" width="100%">
	   <tr>
        <td align="right" class="boldtext"> شماره رسید : '.$code_a.$row1['code_anbar'].$row1['shomare_resid'].'</td>
		<td align="right" class="boldtext"> تاريخ رسید : '.$row1['tarikh_resid'].'</td>	 	   		 
		<td align="right" class="boldtext"> شناسه یکتا وزارت صمت : '.$row1['wb_id'].'</td>	 
		<td align="right" class="boldtext"> وضعیت : ';if($row1['status']==0) echo 'جاری'; else echo 'ابطالی </td>';
	    echo'
	   </tr>
	   <tr><td>&nbsp;</td></tr>
	   <tr>
        <td colspan="4">
	     <fieldset class="print-fieldset">
	     <legend class="boldtext">اطلاعات</legend>
	      <table width="100%">
	   	   <tr>
		    <td align="right"> نوع بسته بندی : '.$row1['sharh_bastebandy'].'</td>
		    <td align="right"> نوع تحویل بار : '.$tahvilbarArr[$row1['noe_tahvil_bar']].'</td>';
		    if(($row1['noe_tahvil_bar']==1)or($row1['noe_tahvil_bar']==2)or($row1['noe_tahvil_bar']==3))
            echo'<td align="right" class="boldtext"> تاریخ اتمام قرارداد : '.$tarikh_etmam.' </td>';
		    echo'
		   </tr>';
	    	if(($row1['noe_tahvil_bar']==4)or($row1['noe_tahvil_bar']==5))//اگر نوع تحویل  بار جابجایی باشد
	    	{echo'
	    	 <tr id="info">
              <td align="right"> نام استان مبدأ : '.$row1['name_ostan'].'</td>
	    	  <td align="right"> نام سردخانه مبدأ : '.$row1['name_anbar'].'</td>
             </tr>';
	    	}
	    	else
	    	{echo'
	    	 <tr id="info">
	    	  <td align="right"> کد فروشنده / کشتی : '.$row1['code_skk'].'</td>
	    	  <td align="right"> نام فروشنده / کشتی : '.$row1['name_skk'].'</td>';
			  IF(($row1['noe_tahvil_bar']==1)OR($row1['noe_tahvil_bar']==2)OR($row1['noe_tahvil_bar']==3)OR($row1['noe_tahvil_bar']==8))echo'<td align="right"> شماره قرارداد / سفر : '.$row1['shomare_safar'].'</td>';
			  echo'
	    	  <td align="right"> مبدأ بارگيری : '.$row1['name_mabda'].'</td>
	    	 </tr>';
	    	}
	       echo'
	       <tr>';
		    //اگر نوع تحویل بار روباری یا جابه جایی روباری باشد
	       if(($row1['noe_tahvil_bar']==2)or($row1['noe_tahvil_bar']==5)) echo'';
		    else echo'<td align="right"> شماره باسکول : '.$row1['bsk_no'].'</td>';
	       echo'
		     <td align="right"> شماره بارنامه : '.$row1['barname_no'].'</td>
	         <td align="right"> تاريخ بارنامه :  '.$row1['barname_tarikh'].'</td>
	         <td align="right"> پلاک خودرو : <sup>ایران</sup> '.$row1['plak1'].'-'.$row1['plak2'].''.$row1['plak3'].''.$row1['plak4'].'';if($row1['kamion_no'])   echo' /'.$row1['kamion_no'].'';echo'</td>
	       </tr>
		   <tr>
		    <td align="right"> نام راننده : '.$row1['ranande_name'].'</td>
		    <td align="right"> کد ملی راننده : '.$row1['ranande_melicode'].'</td>
		    </td>
		    <td align="right">شماره حساب راننده :'.$row1['shomare_hesab_ranande'].'</td>
		    <td align="right">بانک راننده : '.$bankRanande.'</</td>
		   </tr>
	       <tr>
		    <td align="right"> شرکت حمل کننده : '.$row1['name_peymankar_haml'].'</td>
		    <td align="right"> شماره پلمپ : '.$row1['shomare_polomp'].'</td>
	        <td align="right"> وضعیت پلمپ : ';if($row1['vaziyat_polomp']!=0)echo''.$polompArr[$row1['vaziyat_polomp']].'';echo'</td>';
		    //اگر نوع تحویل بار روباری یا جابه جایی روباری باشد
	        if(($row1['noe_tahvil_bar']==2)or($row1['noe_tahvil_bar']==5)) echo'';
		    else echo'<td align="right"> نوع تخليه : '.$row1['sharh_takhlie'].'</td>';
		   echo'
		   </tr>
	       <tr>
		    <td align="right"> شماره گواهی بهداشتی : '.$row1['shomare_govahi_behdashti'].'</td>
		    <td align="right"> توضیحات : '.$row1['tozihat'].'</td>
		   </tr>
	   </table>
	  </fieldset>
     </td>
	</tr>
	<tr>
	 <td colspan="4">
	  <fieldset class="print-fieldset">
	  <legend class="boldtext">اطلاعات کالا</legend>
	  <table width="99%" style="border:1px solid #000;line-height:25px;">
	  <tr>
	   <td class="borderbottom " width="%">کد کالا</td>
	   <td class="borderbottom " width="%">نام کالا</td>
	   <td class="borderbottom " width="%">کشور</td>
	   <td class="borderbottom " width="%">تولیدکننده</td>
	   <!--<td class="borderbottom " width="%">فی</td>-->
	   <td class="borderbottom " width="%">تاریخ تولید</td>
	   <td class="borderbottom " width="%">تاریخ ماندگاری</td>
	   <td class="borderbottom " width="%">وزن کارتن</td>
	   <td class="borderbottom " width="%">زیرانبار</td>';
	   if($row1['code_bastebandy']==1)echo'<td class="borderbottom " width="%">وزن ناخالص</td>';
	   echo'<td class="borderbottom" width="%">تعداد</td>';
	   if($row1['code_bastebandy']==1)echo'<td class="borderbottom " width="%">مجموع وزن کارتن ها</td>';
	   echo'<td class="borderbottom " width="%">وزن خالص</td>';
	   if(($row1['noe_tahvil_bar']!=2)and($row1['noe_tahvil_bar']!=5))echo'<td class="borderbottom" width="%">وزن مبدأ</td>';
	   //اگر نوع تحویل بار روباری نباشد
	   if(($row1['noe_tahvil_bar']!=2)and($row1['noe_tahvil_bar']!=5))
	   {echo'
	    <td class="borderbottom " width="%">کل کسری</td>
	    <!--<td class="borderbottom " width="%">کسری مجاز</td>-->
	    <td class="borderbottom " width="%">کسری غیر مجاز</td>
	    <td class="borderbottom " width="%">وزن اضافه</td>';
	   if($row1['noe_pardakht']==2)
	   {echo'
		<td class="borderbottom " width="%">مبلغ جریمه کسری</td>
	    <td class="borderbottom " width="%">مبلغ تخلیه</td>';
	   }
		echo'
	     <!--<td class="borderbottom" width="%">مبلغ باسکول</td>-->
		';
		}
	  echo'
	  </tr>';
	  $q_d="SELECT *,
	    (SELECT code_bastebandy FROM kala WHERE code_kala=r_d.code_kala) code_bastebandy, 
		(SELECT name_kala FROM kala WHERE kala.code_kala=r_d.code_kala) nameKala,
	    (SELECT name_keshvar FROM keshvar WHERE keshvar.code_keshvar=r_d.code_keshvar) nameKeshvar,
        (SELECT name_tolidkonande FROM tolidkonande WHERE tolidkonande.code_tolidkonande=r_d.code_tolidkonande) nameTolidkonande,
        (SELECT name_ziranbar FROM list_sardkhane_detail WHERE list_sardkhane_detail.code_ziranbar=r_k_d.code_ziranbar AND list_sardkhane_detail.code_ostan=r_k_d.code_ostan AND list_sardkhane_detail.code_anbar=r_k_d.code_anbar) nameZiranbar,
        (SELECT sharh_mandegari FROM tarikh_mandegari WHERE tarikh_mandegari.code_mandegari=r_k_d.code_mandegari) sharhMandegari,
		(SELECT SUM(vazn_nakhales_r_d_sub) FROM resid_kala_detail r_k_d WHERE r_k_d.code_kala=r_d.code_kala AND r_k_d.code_keshvar=r_d.code_keshvar AND r_k_d.code_tolidkonande=r_d.code_tolidkonande AND r_k_d.shomare_resid=r_d.shomare_resid AND r_k_d.code_ostan=r_d.code_ostan AND r_k_d.code_anbar=r_d.code_anbar AND r_k_d.year=r_d.year) vazn_nakhales_r_d,				  
		(SELECT SUM(vazn_khales_r_d_sub) FROM resid_kala_detail r_k_d WHERE r_k_d.code_kala=r_d.code_kala AND r_k_d.code_keshvar=r_d.code_keshvar AND r_k_d.code_tolidkonande=r_d.code_tolidkonande AND r_k_d.shomare_resid=r_d.shomare_resid AND r_k_d.code_ostan=r_d.code_ostan AND r_k_d.code_anbar=r_d.code_anbar AND r_k_d.year=r_d.year) vazn_khales_r_d,				  
        (SELECT SUM(tedad_karton_r_d_sub) FROM resid_kala_detail r_k_d WHERE r_k_d.code_kala=r_d.code_kala AND r_k_d.code_keshvar=r_d.code_keshvar AND r_k_d.code_tolidkonande=r_d.code_tolidkonande AND r_k_d.shomare_resid=r_d.shomare_resid AND r_k_d.code_ostan=r_d.code_ostan AND r_k_d.code_anbar=r_d.code_anbar AND r_k_d.year=r_d.year) tedad_karton_r_d,		
        (SELECT SUM(sum_karton_r_d_sub) FROM resid_kala_detail r_k_d WHERE r_k_d.code_kala=r_d.code_kala AND r_k_d.code_keshvar=r_d.code_keshvar AND r_k_d.code_tolidkonande=r_d.code_tolidkonande AND r_k_d.shomare_resid=r_d.shomare_resid AND r_k_d.code_ostan=r_d.code_ostan AND r_k_d.code_anbar=r_d.code_anbar AND r_k_d.year=r_d.year) sum_karton_r_d		
         FROM resid_detail as r_d INNER JOIN resid_kala_detail as r_k_d ON r_k_d.shomare_resid=r_d.shomare_resid AND r_k_d.code_ostan=r_d.code_ostan AND r_k_d.code_anbar=r_d.code_anbar AND r_k_d.year=r_d.year AND r_k_d.code_kala=r_d.code_kala AND r_k_d.code_keshvar=r_d.code_keshvar AND r_k_d.code_tolidkonande=r_d.code_tolidkonande 
		 WHERE r_d.shomare_resid='".$row1['shomare_resid']."' AND r_d.code_ostan=$mt_gl_code_ostan AND r_d.code_anbar=$mt_gl_code_anbar AND r_d.year=$mtActiveYear";	
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
		  echo'
		  <tr>
	       <td>'.$row_d['code_kala'].'</td>
	       <td>'.$row_d['nameKala'].'</td>
	       <td>'.$row_d['nameKeshvar'].'</td>
	       <td>'.$row_d['nameTolidkonande'].'</td>
	       <!--<td>'.virgul($row_d['fee_this']).'</td>-->
		   <td>'.$row_d['sal_tolid_shamsi'].'-'.$mahshamsiArr[$row_d['mah_tolid_shamsi']].'-'.$row_d['rouz_tolid_shamsi'].'</td>
		   <td>'.$row_d['sharhMandegari'].'</td>
		   <td>'.$row_d['vazn_karton_this'].'</td>
		   <td>'.$row_d['nameZiranbar'].'</td>';
		   if($row_d['code_bastebandy']==1)echo'<td>'.round($row_d['vazn_nakhales_r_d_sub'],3).'</td>';
		   echo'<td >'.$row_d['tedad_karton_r_d_sub'].'</td>';
		   if($row_d['code_bastebandy']==1)echo'<td>'.round($row_d['sum_karton_r_d_sub'],3).'</td>';
		   echo'<td >'.round($row_d['vazn_khales_r_d_sub'],3).'</td>';
		   //if($row1['code_bastebandy']==1)echo'<td >'.round($row_d['vazn_nakhales_r_d'],3).'</td>';
	       //echo'<td >'.$row_d['tedad_karton_r_d'].'</td>';
	       //if($row1['code_bastebandy']==1)echo'<td>'.round($row_d['sum_karton_r_d'],3).'</td>';
	       //echo'<td >'.round($row_d['vazn_khales_r_d'],3).'</td>';
		   if(($row1['noe_tahvil_bar']!=2)and($row1['noe_tahvil_bar']!=5))echo'<td>'.$row_d['vazn_mabda_r_d'].'</td>';
		   //اگر نوع تحویل بار روباری نباشد
		   if(($row1['noe_tahvil_bar']!=2)and($row1['noe_tahvil_bar']!=5))
		   {
		    echo'
	        <td >'.round($kasry_kol_r_d,3).'</td>
	        <!--<td >'.$row_d['kasry_mojaz_r_d'].'</td>-->
	        <td >'.round($kasry_gheyremojaz_r_d,3).'</td>
	        <td >'.round($vazn_ezafe_r_d,3).'</td>';
		   if($row1['noe_pardakht']==2)
		   {echo'
	        <td >'.virgul($mablagh_jarimekasry_r_d).'</td>
	        <td >'.virgul($mablagh_takhlie_r_d).'</td>';
		   }
           echo'<!--<td >'.$mablagh_baskul_r_d.'</td>-->';
		   }
		  echo'
	      </tr>';
	      //$vazn_mabda_r+=$row_d['vazn_mabda_r_d'];//حالت مجموع
	      $vazn_nakhales_r+=$row_d['vazn_nakhales_r_d_sub'];
	      $tedad_karton_r+=$row_d['tedad_karton_r_d_sub'];
	      $sum_karton_r+=$row_d['sum_karton_r_d_sub'];
	      $vazn_khales_r+=$row_d['vazn_khales_r_d_sub'];
	      // $vazn_nakhales_r+=$row_d['vazn_nakhales_r_d'];//حالت مجموع
	      // $tedad_karton_r+=$row_d['tedad_karton_r_d'];
	      // $sum_karton_r+=$row_d['sum_karton_r_d'];
	      // $vazn_khales_r+=$row_d['vazn_khales_r_d'];
		  //اگر نوع تحویل بار روباری نباشد
		  // if(($row1['noe_tahvil_bar']!=2)and($row1['noe_tahvil_bar']!=5))//حالت مجموع
		  // {			
			// $kasry_kol_r+=$kasry_kol_r_d;
	        // $kasry_mojaz_r+=$row_d['kasry_mojaz_r_d'];
	        // $kasry_gheyremojaz_r+=$kasry_gheyremojaz_r_d;
	        // $vazn_ezafe_r+=$vazn_ezafe_r_d;
	        // $mablagh_jarimekasry_r+=$mablagh_jarimekasry_r_d;
	        // $mablagh_takhlie_r+=$mablagh_takhlie_r_d;
	               //مبلغ باسکول
			       //$mablagh_baskul_r=$db->get_from_where("nerkh_baskul","hazine_baskul","az_vazn<='$vazn_khales_r' AND ta_vazn>='$vazn_khales_r'");
			       //if($vazn_khales_r==0) $mablagh_baskul_r=0;
			       /**///$mablagh_baskul_r+=$mablagh_baskul_r_d;
		  //}
	               // $mablagh_pardakhty=$row1['mablagh_kerayemabda']-$mablagh_jarimekasry_r+$row1['mablagh_haghetavaghof']-$mablagh_baskul_r-$mablagh_takhlie_r;
	               // if($mablagh_pardakhty<0) $mablagh_pardakhty=0; 
		 }//END WHILE resid_detail
	     echo'
	      <tr>
	      <td class="bordertop boldtext"" colspan="8">مجموع مقادیر</td>';
	      if($row1['code_bastebandy']==1)echo'<td class="bordertop boldtext">'.round($vazn_nakhales_r,3).'</td>';
	      echo'<td class="bordertop boldtext">'.$tedad_karton_r.'</td>';
	      if($row1['code_bastebandy']==1)echo'<td class="bordertop boldtext">'.round($sum_karton_r,3).'</td>';
	      echo'<td class="bordertop boldtext">'.round($vazn_khales_r,3).'</td>';
		  //اگر نوع تحویل بار روباری نباشد
		  if(($row1['noe_tahvil_bar']!=2)and($row1['noe_tahvil_bar']!=5)) 
		  {
		    $q_d_mohasebat="SELECT *,
		      (SELECT code_bastebandy FROM kala WHERE code_kala=r_d.code_kala) code_bastebandy, 
			  (SELECT SUM(vazn_nakhales_r_d_sub) FROM resid_kala_detail r_k_d WHERE r_k_d.code_kala=r_d.code_kala AND r_k_d.code_keshvar=r_d.code_keshvar AND r_k_d.code_tolidkonande=r_d.code_tolidkonande AND r_k_d.shomare_resid=r_d.shomare_resid AND r_k_d.code_ostan=r_d.code_ostan AND r_k_d.code_anbar=r_d.code_anbar AND r_k_d.year=r_d.year) vazn_nakhales_r_d,				  
			  (SELECT SUM(vazn_khales_r_d_sub) FROM resid_kala_detail r_k_d WHERE r_k_d.code_kala=r_d.code_kala AND r_k_d.code_keshvar=r_d.code_keshvar AND r_k_d.code_tolidkonande=r_d.code_tolidkonande AND r_k_d.shomare_resid=r_d.shomare_resid AND r_k_d.code_ostan=r_d.code_ostan AND r_k_d.code_anbar=r_d.code_anbar AND r_k_d.year=r_d.year) vazn_khales_r_d				  
               FROM resid_detail as r_d WHERE r_d.shomare_resid='".$row1['shomare_resid']."' AND r_d.code_ostan=$mt_gl_code_ostan AND r_d.code_anbar=$mt_gl_code_anbar AND r_d.year=$mtActiveYear";	
	        $res_d_mohasebat=$db->query($q_d_mohasebat);
		    while($row_d_mohasebat=$db->fetch_assoc($res_d_mohasebat))
			{  
	             if($row_d_mohasebat['code_bastebandy']==2)$kasry_kol_r_d2 = $row_d_mohasebat['vazn_mabda_r_d'] - $row_d_mohasebat['vazn_khales_r_d'];//کل کسری این کالا
	             else $kasry_kol_r_d2=$row_d_mohasebat['vazn_mabda_r_d']-$row_d_mohasebat['vazn_nakhales_r_d'];//کل کسری این کالا
				 if($kasry_kol_r_d2<0) $kasry_kol_r_d2=0;//اگر جواب منفی شد
	             if($kasry_kol_r_d2==$row_d_mohasebat['vazn_mabda_r_d'])//اگر هنوز وزن ناخالص را ثبت نکرده ایم
	             { 
	      	      $kasry_kol_r_d2=0;
	              $kasry_gheyremojaz_r_d2=0;
 	             }
	            $kasry_gheyremojaz_r_d2=$kasry_kol_r_d2-$row_d_mohasebat['kasry_mojaz_r_d'];//کسری غیرمجاز این کالا
	             if($kasry_gheyremojaz_r_d2<0) $kasry_gheyremojaz_r_d2=0;//اگر جواب منفی شد
	             if($row_d_mohasebat['code_bastebandy']==2)$vazn_ezafe_r_d2=$row_d_mohasebat['vazn_khales_r_d']-$row_d_mohasebat['vazn_mabda_r_d'];//وزن اضافه
	             else $vazn_ezafe_r_d2=$row_d_mohasebat['vazn_nakhales_r_d']-$row_d_mohasebat['vazn_mabda_r_d'];//وزن اضافه
				 if($vazn_ezafe_r_d2<0) $vazn_ezafe_r_d2=0;//اگر جواب منفی شد
	            $mablagh_jarimekasry_r_d2=$kasry_gheyremojaz_r_d2*$row_d_mohasebat['fee_this'];//مبلغ جریمه کسری
			    $mablagh_takhlie_r_d2=$row_d_mohasebat['nerkh_takhlie_this'];//مبلغ تخلیه
			    $vazn_mabda_r+=$row_d_mohasebat['vazn_mabda_r_d'];
			    //$kasry_kol_r+=$kasry_kol_r_d2;
	            $kasry_kol_r=kasryKol($row1['shomare_resid'],$row1['code_ostan'],$row1['code_anbar'],$row1['year']);
				$kasry_mojaz_r+=$row_d_mohasebat['kasry_mojaz_r_d'];
	            $kasry_gheyremojaz_r+=$kasry_gheyremojaz_r_d2;
	            $vazn_ezafe_r+=$vazn_ezafe_r_d2;
	            $mablagh_jarimekasry_r+=$mablagh_jarimekasry_r_d2;
	            $mablagh_takhlie_r+=$mablagh_takhlie_r_d2;		
			}

		   echo'
		   <td class="bordertop boldtext">'.$vazn_mabda_r.'</td>
	       <td class="bordertop boldtext">'.$kasry_kol_r.'</td>
	       <!--<td class="bordertop boldtext">'.round($kasry_mojaz_r,3).'</td>-->
	       <td class="bordertop boldtext">'.round($kasry_gheyremojaz_r,3).'</td>
	       <td class="bordertop boldtext">'.round($vazn_ezafe_r,3).'</td>';
		   if($row1['noe_pardakht']==2)
	       {echo'
		    <td class="bordertop boldtext">'.virgul($mablagh_jarimekasry_r).'</td>
	        <td class="bordertop boldtext">'.virgul($mablagh_takhlie_r).'</td>';
		   }
 		   echo'<!--<td class="bordertop boldtext">'.virgul($mablagh_baskul_r).'</td>-->';
		  }
		  echo'
	     </tr>';
      }
      else if($row1['status']==1){echo'<tr style="background:#FFF;"><td colspan="15">رسید ابطال شد</td></tr>';}	  
	  else {echo'<tr style="background:#FFF;"><td colspan="15">جزئیات رسید تکمیل نشده است ! </td></tr>';}  	  
	  //محاسبه مبلغ پرداختی
	  //$mablagh_pardakhty=$row1['mablagh_kerayemabda']-$mablagh_jarimekasry_r+$row1['mablagh_haghetavaghof']-$mablagh_baskul_r-$mablagh_takhlie_r;
	  $mablagh_pardakhty=$row1['mablagh_kerayemabda']-$mablagh_jarimekasry_r+$row1['mablagh_haghetavaghof']-$mablagh_takhlie_r;
	  if($mablagh_pardakhty<0) $mablagh_pardakhty=0;
	   echo'
      </table>
	  </fieldset>	   	 
     </td> 	  
	</tr>
	<tr>
	 <td colspan="" valign="top" width="33%">
	  <fieldset class="print-fieldset">
	   <legend class="boldtext">وزن</legend>
	   <table width="100%" height="150px">';
	   	//اگر نوع تحویل بار روباری یا جابه جایی روباری باشد
	    if(($row1['noe_tahvil_bar']==2)or($row1['noe_tahvil_bar']==5))
        {
		 if($row1['code_bastebandy']==1)echo'<tr><td align="right" class="boldtext"> وزن ناخالص : '.round($row1['vazn_nakhales_r'],3).'</td></tr>';
	     echo'<tr><td align="right" class="boldtext"> تعداد : '.$row1['tedad_karton_r'].'</td></tr>';
	     if($row1['code_bastebandy']==1)echo'<tr><td align="right"> وزن کارتن ها : '.round($sum_karton_r,3).'</td></tr>';
	     echo'<tr><td align="right" class="boldtext"> وزن خالص : '.round($row1['vazn_khales_r'],3).'</td></tr>';
		}	
		else
        {
		 echo'
	     <tr><td align="right"> وزن مبدأ : '.round($vazn_mabda_r,3).'</td></tr>';
		 if($row1['noe_tahvil_bar']!=3)//حمل با راه آهن نیاشد
		 {echo'
	      <tr><td align="right"> وزن کاميون با بار : '.($row1['vazn_kamiyon_bar']).'</td></tr>
	      <tr><td align="right"> وزن کاميون :  '.($row1['vazn_kamiyon']).'</td></tr>';
		 }
		 if($row1['code_bastebandy']==1)echo'<tr><td align="right" class="boldtext"> وزن ناخالص : '.round($row1['vazn_nakhales_r'],3).'</td></tr>';
	     echo'<tr><td align="right" class="boldtext"> تعداد : '.$row1['tedad_karton_r'].'</td></tr>';
	     if($row1['code_bastebandy']==1)echo'<tr><td align="right"> وزن کارتن ها : '.round($sum_karton_r,3).'</td></tr>';
	     echo'<tr><td align="right" class="boldtext"> وزن خالص : '.round($row1['vazn_khales_r'],3).'</td></tr>';
	   	 if($row1['noe_tahvil_bar']!=3) echo'<tr><td align="right"> نوع خودرو : ';if($row1['noe_khodro']!=0)echo''.$khodroArr[$row1['noe_khodro']].'';echo'</td></tr>';
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
	  <td  valign="top" width="30%">
	   <fieldset class="print-fieldset">
	    <legend class="boldtext">کسری</legend>
	    <table width="100%" height="150px">
	     <tr><td align="right">کل کسری : '.($kasry_kol_r).'</td></tr>
	 	 <!--<tr><td align="right">کسری مجاز : '.round($kasry_mojaz_r,3).'</td></tr>-->
	     <tr><td align="right">کسری غیر مجاز : '.round($kasry_gheyremojaz_r,3).'</td></tr>
	     <tr><td align="right">وزن اضافه :  '.round($vazn_ezafe_r,3).'</td></tr>
	     <tr><td rowspan="10">&nbsp;</td></tr>
		</table>
	   </fieldset>
      </td>';
	 }
	 if($row1['noe_tahvil_bar']!=3)//حمل با راه آهن نباشد
	 {
	 echo'
	 <td width="37%" colspan="2" valign="top">
	  <fieldset class="print-fieldset">
	   <legend class="boldtext">مبالغ</legend>
	   <table width="100%" height="150px">
	     <tr><td align="right"> نوع پرداخت پسکرایه : '.$pardakhtArr[$row1['noe_pardakht']].'</td></tr>
		 <tr>
		 <td colspan="2">';
		 if($row1['noe_pardakht']==2)//اگر نوع پرداخت کرایه در مقصد ثبت شده بود
		 {
 		  $amel_pName=$db->get_from_where("amel_p_name","amel_pardakht","amel_p_accnting_code=".$row1['amel_p_accnting_code']." AND code_ostan=".$row1['code_ostan']." AND code_anbar=".$row1['code_anbar']."");
 		  $amel_pLastname=$db->get_from_where("amel_p_lastname","amel_pardakht","amel_p_accnting_code=".$row1['amel_p_accnting_code']." AND code_ostan=".$row1['code_ostan']." AND code_anbar=".$row1['code_anbar']."");
		  echo'
		  <span id="paskeraye">
		   <table width="100%" border="0">';
		   //اگر نوع تحویل بار روباری یا جابه جایی روباری باشد
	       if(($row1['noe_tahvil_bar']==2)or($row1['noe_tahvil_bar']==5))
	       {echo'
	         <tr><td align="right"> مبلغ کرايه مبدأ : '.($row1['mablagh_kerayemabda']).'</td></tr>
	         <tr><td align="right"> مبلغ حق توقف : '.($row1['mablagh_haghetavaghof']).'</td></tr>';
	       }
		   else 
	       {echo'
		     <tr><td align="right"> مبلغ کرايه مبدأ : '.virgul($row1['mablagh_kerayemabda']).'</td></tr>
		     <tr><td align="right"> مبلغ جريمه کسری : '.virgul($mablagh_jarimekasry_r).'</td></tr>
	         <tr><td align="right"> مبلغ حق توقف : '.($row1['mablagh_haghetavaghof']).'</td></tr>
			 <tr><td align="right"> مبلغ باسکول : '.virgul($row1['mablagh_baskul']).'</td></tr>
	         <tr><td align="right"> مبلغ تخليه : '.virgul($mablagh_takhlie_r).'</td></tr>
	         <!--<tr><td align="right"> مبلغ اضافه بار : </td><td align="right"><input type="text" readonly class="textboxme2" readonly name="mablagh_ezafebar" value="'.virgul($row1['mablagh_ezafebar']).'"/></td></tr>-->';
	        }
			echo'
		    <tr><td colspan="2"><hr/></td></tr>
		    <tr><td align="right"> مبلغ پرداختی : '.virgul($mablagh_pardakhty).'</td></tr>
	   	    <tr><td align="right"> عامل پرداخت پسکرایه : '.$amel_pName.' '.$amel_pLastname.'</td>
		  </table>
		  </span>';
		  }
		 echo'		 
		 </td>
		</tr>
	   </table>
      </fieldset>
	 </td>';
	 }
	 echo'
	</tr>
   </table>
   </div>
  </td>
 </tr>
 <!--پايان مرکز صفحه -->
 <tr class="print_footer">
  <td align="left">&nbsp;&nbsp;&nbsp; تاریخ چاپ : '.$today.' &nbsp;&nbsp;&nbsp; ساعت چاپ : '.$logtime.'</td>
 </tr>
 <!-- چاپ زیرنویس-->
 <tr>
  <td>
   <table width="100%" border="0" height="100%" align="center" cellpadding="0" cellspacing="0">
    <tr class="print_footer">
     <td>نام کاربر :&nbsp;'.$mtuserNAME.'</td>';
	 // $dc=$db->query("SELECT dpt_id FROM mt_typesign WHERE type_id='1' AND code_ostan='".$_SESSION['mt_code_ostan']."' and code_anbar='".$_SESSION['mt_code_anbar']."' order by turn");	
     // while ($dr=$db->fetch_array($dc))
     // {
	 // $vahed=$db->get_from_where("dpt_name,manager","mt_dpt","dpt_id=".$dr[0]." AND code_ostan='".$_SESSION['mt_code_ostan']."' AND code_anbar='".$_SESSION['mt_code_anbar']."'");
     // echo '<td>'.$vahed[0].' :&nbsp;'.$vahed[1].'</td>';
     // }
     if($row1['signiture_resid']!='')
	 {
       $signarray =explode(';',$row1['signiture_resid']);
	   foreach($signarray as $signID)
	   {
	    $sql_q ="select mt_typesign.manager,mt_dpt.dpt_name from mt_typesign INNER JOIN mt_dpt ON mt_typesign.dpt_id=mt_dpt.dpt_id AND mt_typesign.code_ostan=mt_dpt.code_ostan AND mt_typesign.code_anbar=mt_dpt.code_anbar where sign_id=$signID order by turn";
	    $sql_res=mysql_query($sql_q);
	    $row_n=mysql_fetch_assoc($sql_res);
	    echo '<td>'.$row_n['dpt_name'].' :&nbsp;&nbsp;'.$row_n['manager'].'</td>';
	   }
	 }
	echo'
    </tr>';
	//تعداد توضیحات	
     $tozihCount=$db->get_from_where("count(*)","mt_typetozih","type_id='1' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar'");     
	 if($tozihCount>0)
	 {
	   echo'
	   <tr class="print_footer">';
	   $tozihat_q=$db->query("SELECT form_tozihat FROM mt_typetozih WHERE type_id='1' AND code_ostan='".$_SESSION['mt_code_ostan']."' and code_anbar='".$_SESSION['mt_code_anbar']."'");	
       while ($tozih=$db->fetch_array($tozihat_q)) echo '<td>'.$tozih[0].'</td>';
       echo'</tr>';
	 } 
	echo'
   </table>
  </td>
 </tr>
 </table>
</body>
</html>';	
?>