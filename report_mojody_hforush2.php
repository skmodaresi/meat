<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="report_mojody_hforush.php";
$ExcelFileName=str_replace('.php','',$FileName);
$titr='گزارش براساس مانده موجودی و حواله فروش';
require_once('head.html');
$columns='	
    <tr class="print_table-title2">
	 <td rowspan="3" width=2%>ردیف</td>
	 <td rowspan="3" width=5%>نام کالا</td>
	 <td rowspan="3" width=4%>بسته بندی</td>
	 <td colspan="3" width=16%>مانده از دوره قبل </td>
	 <td colspan="4" width=20%>میزان وارده طی دوره</td>
	 <td colspan="3" width=17%>جمع</td>
	 <td colspan="5" width=20%>مقدار تحویلی طی دوره</td>
	 <td colspan="5" width=16%>مانده نهایی </td>
	</tr>
	<tr class="print_table-title2">
	 <td rowspan="2" width="">موجودی جنسی</td>
	 <td rowspan="2" width="">حواله فروش</td>
	 <td rowspan="2" width="">مجوز جابه جایی</td>
	 <td rowspan="2" width="">رسید جنسی</td>
	 <td rowspan="2" width="">تعدیل جنسی</td>
	 <td rowspan="2" width="">حواله فروش</td>
	 <td rowspan="2" width="">مجوز جابه جایی</td>
	 <td rowspan="2" width="">جنسی</td>
	 <td rowspan="2" width="">حواله فروش</td>
	 <td rowspan="2" width="">مجوز جابه جایی</td>
	 <td colspan="2" width="">حواله جنسی</td>
	 <td rowspan="2" width="">تعدیل جنسی</td>
	 <td colspan="2" width="">ابطالی</td>
	 <td rowspan="2" width="">جنسی</td>
	 <td rowspan="2" width="">حواله فروش</td>
	 <td rowspan="2" width="">مجوز جابه جایی</td>
	 <td rowspan="2" width=>مانده پس از کسر حواله فروش</td>
	 <td rowspan="2" width=>مانده پس از کسر حواله و مجوز</td>
	</tr>
	<tr class="print_table-title2 print_table-title_small">
	    <td>حواله فروش</td>
	    <td>جابه جایی</td>
	    <td>حواله فروش</td>
	    <td>جابه جایی</td>
	</tr>';
Function print_header()
{global $titr,$columns,$mt_gl_owner,$mt_gl_name_anbar,$mt_gl_name_ostan,$date1,$date2,$FileName,$page;
 echo'
   <br>
   <table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
    <tr class="noExl">
	 <td colspan="40">
      <table width="100%" align="center">
       <tr class="noExl"><td class="print_title_2">'.$mt_gl_owner.'</td></tr>
       <tr class="noExl"><td class="print_title_2"> سردخانه : '.$mt_gl_name_anbar.'&nbsp;&nbsp; استان : '.$mt_gl_name_ostan.'</td></tr> 
       <tr class="noExl"><td class="print_title_2">'.$titr.'</td></tr>
	   <tr class="noExl">
        <td class="print_title_2">';
		IF($page==1){
			 echo'<a href="javascript:window.print();"><span style="float:right" id="printerReport" class="hideatprint" title="چاپ"></span></a>
			      <span style="float:right" id="exportExcel" title="خروجی اکسل" ></span>';
		 }
		echo'
	    از تاریخ : '.$date1.' تا تاریخ : '.$date2.'&nbsp&nbsp(صفحه : '.$page.')
        <div style="float:left;"><button class="buttonme hideatprint" onClick="window.location=\''.$FileName.'\'">بازگشت</button></div>
	   </td>
	  </tr>';
	  IF($page==1){
	  echo'
	       <tr class="noExl"><td class="print_title" style="font-size:12px;">دقت کنید : در صورتیکه بسته بندی کالا از نوع کارتنی است مقادیر نشان دهنده وزن خالص است و 
		   در صورتیکه کالا تخم مرغ (کد کالا 50) باشد مقادیر نشان دهنده شانه تخم مرغ و
		   در صورتیکه بسته بندی از نوع قوطی است مقادیر نشان دهنده تعداد کالا است .
		   </td></tr>
           <tr class="noExl"><td class="print_title" style="font-size:12px;">
		   بسته بندی کارتن : واحد کالا کیلوگرم 
		   وتخم مرغ (کد کالا :50) واحد کالا شانه 
		   و بسته بندی قوطی : واحد کالا عدد
		   </td></tr>';
	  }
	  echo'
	 </table>
    </td>
   </tr>';
}
/***************************************** MAIN*****************************************/
echo'
<body class="openwin"  onload="document.myform.date1.focus();">
<form method="post" name="myform" onkeydown="enterIE()">';
/********************نمایش اطلاعات در حالت سیستم انبار****************************/
if(!$MaxLines)$MaxLines=10;
if(!$ok)//هنوز روی دکمه گزارش کلیک نکرده
{
 echo'
 <table width="98%" align="center" cellpadding="0" cellspacing="0">
  <tr>
   <td height="100%">
    <table width="600px" border="0" align="center" cellpadding="0" cellspacing="0">
     <tr><td colspan="4" height="20px">&nbsp;</td></tr>
 	 <tr><td colspan="4" class="title">'.$titr.'</td></tr>
 	 <tr class="tr1" style="height:45px;">	
      <td align="left"> از تاریخ :&nbsp;</td><td align="right"><input type="text" class="textboxme2" maxlength="10" name="date1" id="datepickerfrom" value="'.$date1.'"/></td>
      <td align="left"> تا تاریخ :&nbsp;</td><td align="right"><input type="text" class="textboxme2" maxlength="10" name="date2" id="datepickerto" value="'.$date2.'"/></td>
 	 </tr>
 	 <tr class="tr1">
 	  <td align="left"> کد کالا :&nbsp;</td><td align="right" width="35%"><input type="text" class="textboxme2" name="code_kala" value="'.$code_kala.'" onkeypress="return isNumber(event)" onKeyUp="F10desc(event)" onblur="enterCodeKala(this.value)" style="width:50px;"/>&nbsp;';
	  include ("img_helpkala.php");
	  echo'
	  </td>
	  <td align="left"> زیرانبار :&nbsp;</td><td align="right">'.listbox_ziranbar("code_ziranbar",$code_ziranbar,"code_ziranbar","name_ziranbar","list_sardkhane_detail","1=1 AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' ORDER BY code_ziranbar,name_ziranbar ASC","class='text4'","").'
	 </tr>
 	 <tr class="tr1">
	  <td align="left" height="40px"> تعداد خط در صفحه :&nbsp;</td><td align="right"><input type="number" class="textboxme2" name="MaxLines" value="'.$MaxLines.'" onkeypress="return isNumber(event)"/></td>
	  <td>&nbsp;</td><td>&nbsp;</td>
 	 </tr>
    <tr class="footer" align="center"><td colspan="4" height="40px"><input class="buttonme" type="submit" name="ok" value="شروع گزارش"></td></tr>      
    </table>
   </td>
  </tr>
 </table>';
}
ELSE//روی دکمه گزارش کلیک کرده
{
 $Condition="";
 $ziranbar_Condition="";
 //اگر کاربر تاریخ اول را وارد نکرده بود
 if(!$date1) $date1=$db->get_from_where("start_from","mt_docs","year='$mtActiveYear'");
 //اگر کاربر تاریخ دوم را وارد نکرده بود
 if(!$date2)
 {
	 $today=AsLDate($yymmdd); 
 	 $end_date_session=$db->get_from_where("end_to","mt_docs","year='$mtActiveYear'");
	 if($today<$end_date_session) $date2=$today;
     else  $date2=$end_date_session;	 
 }
 /****************فیلترها روی گزارش******************/
 if($code_kala)//شرط کد کالا 
 {
	  $Condition.=" AND code_kala='$code_kala'";
	  $Condition2.=" AND r_k_d.code_kala='$code_kala'";
	  $Condition3.=" AND h_d.code_kala='$code_kala'";
 }
 if($code_ziranbar)//شرط زیرانبار 	
 {	
	  $Condition.=" AND code_ziranbar='$code_ziranbar'";
	  $Condition2.=" AND r_k_d.code_ziranbar='$code_ziranbar'";
	  $Condition3.=" AND h_d.code_ziranbar='$code_ziranbar'";	
 }
 $sum_mande_befor_kartoni=0;
 $sum_havale_forush_befor_kartoni=0;
 $sum_varede_between_kartoni=0;
 $sum_havale_forush_between_kartoni=0;
 $sum_meghdarTadil_Ezafe_kartoni=0;
 $sum_jame_jensi_kartoni=0;
 $sum_jame_jensi_kartoni=0;
 $sum_sadere_between_jabejae_kartoni=0;
 $sum_ebtaly=0;
 $sum_nahayi_jensi_kartoni=0;
 $sum_nahayi_forushi_kartoni=0;
 $page=1;
 $line=0;
 $i=0;
 $cntr=0;
 $radif=1;
 /****************شروع نمایش گزارش*******************/
 /*****گزارش برای یک استان و یک انبار*****/ 
 $q="SELECT SUM(mojody_khales_aval) AS mojodyKhalesAval,SUM(tedad_karton_aval) AS tedadKartonAval,SUM(tedad_shane_aval) AS tedadShaneAval,code_kala FROM $mydatabase.mojody_kala WHERE code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' $Condition AND year='$mtActiveYear' AND deleted=0 GROUP BY code_kala";
 $res=$db->query($q);		
 $cntr =mysql_num_rows($res);
 IF(mysql_num_rows($res)>0)//وجود اطلاعات
 {
  echo'<div class="table2excel">';
  print_header();
  /*سطر نمایش فیلترها*/   
  if($code_kala) {$nameKala=$db->get_from_where("name_kala","$mydatabase.kala","code_kala='$code_kala'"); $filter_string.=' کالا : '.$nameKala.'&nbsp;';}     
  if($code_ziranbar) {$nameZirAnbar=$db->get_from_where("name_ziranbar","$mydatabase.list_sardkhane_detail","code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND code_ziranbar='$code_ziranbar'");$filter_string.=' زیرانبار : '.$nameZirAnbar.'&nbsp;';}     
  if(($code_kala)or($code_ziranbar))
  {echo'<tr class="noExl"><td class="filter_text" colspan="40">فیلتر شده براساس : '.$filter_string.'</td></tr>';}
  echo $columns;
  while($row=$db->fetch_array($res))
  {
	$nameKala=$db->get_from_where("name_kala","$mydatabase.kala","code_kala=".$row['code_kala']."");//نام کالای مورد نظر
	$codeBastebandy=$db->get_from_where("code_bastebandy","$mydatabase.kala","code_kala=".$row['code_kala']."");
	$sharhBastebandy=$db->get_from_where("sharh_bastebandy","$mydatabase.bastebandy","code_bastebandy=".$codeBastebandy."");
	$line++;
    IF($codeBastebandy==2){$residField='tedad_karton_r_d_sub';$havaleField='tedad_karton_h_d';$tadilField='tedad_karton_tadil';}
	ELSE IF($row['code_kala']==50){$residField='tedad_shane_r_d_sub';$havaleField='tedad_shane_h_d';$tadilField='tedad_shane_tadil';}
	ELSE {$residField='vazn_khales_r_d_sub';$havaleField='vazn_khales_h_d';$tadilField='meghdar_khales_tadil';}
	/****************محاسبه مانده از قبل*******************/	  
    //فیلد اول
	$mande_beforKartoni=$row['mojodyKhalesAval'];//مجموع موجودی خالص اولیه 
	$mande_beforGhoti=$row['tedadKartonAval'];//مجموع موجودی تعداد اولیه 
	$mande_beforShane=$row['tedadShaneAval'];//مجموع موجودی شانه اولیه 
   	$q2="SELECT AllRecords.* FROM
	       ((SELECT r_d.code_ostan as code_ostan,r_d.code_anbar as code_anbar,r_d.year as year,r_d.shomare_resid as shomare,r.tarikh_resid as tarikh,SUM(r_k_d.vazn_khales_r_d_sub) as vazn,SUM(r_k_d.tedad_karton_r_d_sub) as tedad,SUM(r_k_d.tedad_shane_r_d_sub) as shane,1 as type FROM $mydatabase.resid_detail as r_d
             INNER JOIN $mydatabase.resid as r ON r.shomare_resid=r_d.shomare_resid AND r.code_ostan=r_d.code_ostan AND r.code_anbar=r_d.code_anbar AND r.year=r_d.year
             INNER JOIN $mydatabase.resid_kala_detail as r_k_d ON r_k_d.shomare_resid=r_d.shomare_resid AND r_k_d.code_ostan=r_d.code_ostan AND r_k_d.code_anbar=r_d.code_anbar AND r_k_d.year=r_d.year AND r_k_d.code_kala=r_d.code_kala AND r_k_d.code_keshvar=r_d.code_keshvar AND r_k_d.code_tolidkonande=r_d.code_tolidkonande 
			 WHERE r_d.code_kala=".$row['code_kala']." AND r_d.code_ostan='$mt_gl_code_ostan' AND r_d.code_anbar='$mt_gl_code_anbar' AND r_d.year='$mtActiveYear' $Condition2 AND r_d.resid_deleted=0 AND r_d.status=0 AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.deleted=0 AND r.status=0  group by code_ostan,code_anbar,shomare,year)
	        UNION
	       (SELECT h_d.code_ostan as code_ostan,h_d.code_anbar as code_anbar,h_d.year as year,h_d.shomare_havale_anbar as shomare,h.tarikh_havale_anbar as tarikh,SUM(h_d.vazn_khales_h_d) as vazn,SUM(h_d.tedad_karton_h_d) as tedad,SUM(h_d.tedad_shane_h_d) as shane,2 as type FROM $mydatabase.havale_detail h_d 
            INNER JOIN $mydatabase.havale as h ON h.shomare_havale_anbar=h_d.shomare_havale_anbar AND h.code_ostan=h_d.code_ostan AND h.code_anbar=h_d.code_anbar AND h.year=h_d.year
			WHERE h_d.code_kala=".$row['code_kala']." AND h_d.code_ostan='$mt_gl_code_ostan' AND h_d.code_anbar='$mt_gl_code_anbar' AND h_d.year='$mtActiveYear' $Condition3 AND h_d.havale_deleted=0 AND h_d.status=0 AND h.deleted=0 AND h.status=0  group by code_ostan,code_anbar,shomare,year)
		    UNION
		   (SELECT code_ostan,code_anbar,year,shomare_barge_tadil,tarikh_barge_tadil,meghdar_khales_tadil,tedad_karton_tadil,tedad_shane_tadil,3 as type FROM $mydatabase.tadil_mojody
            WHERE code_kala=".$row['code_kala']." AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' $Condition AND status=0 AND deleted=0)) AS AllRecords
		    WHERE tarikh<'$date1' ORDER BY tarikh,type,shomare"; 
    $res2=$db->query($q2);
	while($row2=$db->fetch_assoc($res2))
	{
	   if($row2['type']==1) {$mande_beforKartoni+=$row2['vazn'];$mande_beforGhoti+=$row2['tedad'];$mande_beforShane+=$row2['shane'];}
	   if($row2['type']==2) {$mande_beforKartoni-=$row2['vazn'];$mande_beforGhoti-=$row2['tedad'];$mande_beforShane-=$row2['shane'];}
	   if($row2['type']==3)
	   {    
	     $q3="SELECT noe_tadil FROM $mydatabase.tadil_mojody WHERE code_kala=".$row['code_kala']." AND shomare_barge_tadil='".$row2['shomare']."' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' $Condition AND year='$mtActiveYear' AND status=0 AND deleted=0";
		 $res3=$db->query($q3);
	     while($row3=$db->fetch_array($res3))
	     {
	      if($row3['noe_tadil']==1) {$mande_beforKartoni+=$row2['vazn'];$mande_beforGhoti+=$row2['tedad'];$mande_beforShane+=$row2['shane'];}//اولین فیلدرا پر میکند		  
	      else {$mande_beforKartoni-=$row2['vazn'];$mande_beforGhoti-=$row2['tedad'];$mande_beforShane-=$row2['shane'];}
	     }//END while
       }//END type=3
	}//END while
    //فیلد سوم
	//مانده از مجوز جابه جایی قبل از تاریخ	
	$jabejae_befor=0;
	$jabejae_befor_per=0;
	$q_jabejae1=("SELECT shomare_jabejae,meghdar_jabejae FROM $mydatabase.mojavez_jabejae WHERE code_kala=".$row['code_kala']." AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0 AND tarikh_jabejae<'$date1'");
	$res_jabejae1=$db->query($q_jabejae1);
	while($row_jabejae1=$db->fetch_array($res_jabejae1))
	{
	   //مقدار کل ابطالی هل قبل از تاریخ
	    $q_ebtal_j_befor="SELECT SUM(meghdar_batele_j) FROM $mydatabase.ebtal_jabejae INNER JOIN $mydatabase.mojavez_jabejae ON ebtal_jabejae.shomare_jabejae=mojavez_jabejae.shomare_jabejae AND ebtal_jabejae.code_ostan=mojavez_jabejae.code_ostan AND ebtal_jabejae.code_anbar=mojavez_jabejae.code_anbar AND ebtal_jabejae.year=mojavez_jabejae.year
	                            WHERE code_kala=".$row['code_kala']." AND ebtal_jabejae.shomare_jabejae='".$row_jabejae1['shomare_jabejae']."' AND ebtal_jabejae.code_ostan='$mt_gl_code_ostan' AND ebtal_jabejae.code_anbar='$mt_gl_code_anbar' AND ebtal_jabejae.year='$mtActiveYear' AND mojavez_jabejae.deleted=0 AND ebtal_jabejae.deleted=0 AND ebtal_jabejae.tarikh_barge_ebtal_j<'$date1'";    
	    $res_ebtal_j_befor=$db->query($q_ebtal_j_befor);
	    $meghdar_ebtali_j_befor=$db->fetch_array($res_ebtal_j_befor);
	   //حواله جنسی قبل از تاریخ
		$sadere_befor_j=$db->get_from_where("SUM($havaleField)","$mydatabase.havale_detail as h_d INNER JOIN havale as h ON h.shomare_havale_anbar=h_d.shomare_havale_anbar AND h.code_ostan=h_d.code_ostan AND h.code_anbar=h_d.code_anbar AND h.year=h_d.year","h_d.code_kala=".$row['code_kala']." AND h_d.shomare_jabejae='".$row_jabejae1['shomare_jabejae']."' AND h_d.code_ostan='$mt_gl_code_ostan' AND h_d.code_anbar='$mt_gl_code_anbar' AND h_d.year='$mtActiveYear' AND h_d.havale_deleted=0 AND h_d.status=0 AND h.tarikh_havale_anbar<'$date1'");
	    //محاسبه مقدار محوز قبل از تاریخ
	    $jabejae_befor_per=$row_jabejae1['meghdar_jabejae']-$sadere_befor_j-$meghdar_ebtali_j_befor[0];
	    $jabejae_befor+=$jabejae_befor_per;
	}
	//فیلد چهارم
	//رسید جنسی مابین تاریخ ها   
	$varede_between=$db->get_from_where("SUM($residField)","$mydatabase.resid_kala_detail r_k_d INNER JOIN $mydatabase.resid as r ON r.shomare_resid=r_k_d.shomare_resid AND r.code_ostan=r_k_d.code_ostan AND r.code_anbar=r_k_d.code_anbar AND r.year=r_k_d.year","r_k_d.code_kala=".$row['code_kala']." AND r_k_d.code_ostan='$mt_gl_code_ostan' AND r_k_d.code_anbar='$mt_gl_code_anbar' $Condition2 AND r_k_d.year='$mtActiveYear' AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.tarikh_resid>='$date1' AND r.tarikh_resid<='$date2'");
	//فیلد پنجم
	//مقدار تعدیل اضافه مابین تاریخ	      
	$meghdarTadil_Ezafe=$db->get_from_where("SUM($tadilField)","$mydatabase.tadil_mojody","code_kala=".$row['code_kala']." AND noe_tadil=1 AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' $Condition AND year='$mtActiveYear' AND status=0 AND deleted=0 AND tarikh_barge_tadil>='$date1' AND tarikh_barge_tadil<='$date2'");
	//فیلد هفتم
	$jabejae_between=$db->get_from_where("SUM(meghdar_jabejae)","$mydatabase.mojavez_jabejae","code_kala=".$row['code_kala']." AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0 AND tarikh_jabejae>='$date1' AND tarikh_jabejae<='$date2'");  
	echo "select SUM(meghdar_jabejae) from $mydatabase.mojavez_jabejae where code_kala=".$row['code_kala']." AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0 AND tarikh_jabejae>='$date1' AND tarikh_jabejae<='$date2'";  
 	
	//فیلد هشتم//جمع جنسی
    IF($codeBastebandy==2)$jame_jensi=$mande_beforGhoti+$varede_between+$meghdarTadil_Ezafe;    
	ELSE IF($row['code_kala']==50)$jame_jensi=$mande_beforShane+$varede_between+$meghdarTadil_Ezafe;
	ELSE $jame_jensi=$mande_beforKartoni+$varede_between+$meghdarTadil_Ezafe;
	//فیلد دهم//جمع جابه جایی
	$jame_jabejae=$jabejae_befor+$jabejae_between;
	//فیلد یازدهم
	//حواله جنسی مابین تاریخ به غیر از جابه جایی ها
	$sadere_between_forush=$db->get_from_where("SUM($havaleField)","$mydatabase.havale_detail as h_d INNER JOIN $mydatabase.havale as h ON h.shomare_havale_anbar=h_d.shomare_havale_anbar AND h.code_ostan=h_d.code_ostan AND h.code_anbar=h_d.code_anbar AND h.year=h_d.year","h_d.code_kala=".$row['code_kala']." AND (h.noe_tahvil_bar=1 OR h.noe_tahvil_bar=2 OR h.noe_tahvil_bar=3) AND h_d.code_ostan='$mt_gl_code_ostan' AND h_d.code_anbar='$mt_gl_code_anbar' $Condition3 AND h_d.year='$mtActiveYear' AND h_d.havale_deleted=0 AND h_d.status=0 AND h.tarikh_havale_anbar>='$date1' AND h.tarikh_havale_anbar<='$date2'");
	//فیلد دوازدهم
	//حواله جنسی مابین تاریخ جابه جایی ها
	$sadere_between_jabejae=$db->get_from_where("SUM($havaleField)","$mydatabase.havale_detail as h_d INNER JOIN $mydatabase.havale as h ON h.shomare_havale_anbar=h_d.shomare_havale_anbar AND h.code_ostan=h_d.code_ostan AND h.code_anbar=h_d.code_anbar AND h.year=h_d.year","h_d.code_kala=".$row['code_kala']." AND (h.noe_tahvil_bar=4 OR h.noe_tahvil_bar=5) AND h_d.code_ostan='$mt_gl_code_ostan' AND h_d.code_anbar='$mt_gl_code_anbar' $Condition3 AND h_d.year='$mtActiveYear' AND h_d.havale_deleted=0 AND h_d.status=0 AND h.tarikh_havale_anbar>='$date1' AND h.tarikh_havale_anbar<='$date2'");		 
	//فیلد سیزدهم
	//مقدار تعدیل کسری مابین تاریخ	      
	$meghdarTadil_Kasry=$db->get_from_where("SUM($tadilField)","$mydatabase.tadil_mojody","code_kala=".$row['code_kala']." AND noe_tadil=2 AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' $Condition AND year='$mtActiveYear' AND status=0 AND deleted=0 AND tarikh_barge_tadil>='$date1' AND tarikh_barge_tadil<='$date2'");	       
	/****************پایان محاسبه مانده از قبل*******************/	
	//فیلد دوم
	IF(($_SESSION['mt_systemforush']==0))//سردخانه
    {	
	  $havale_forush_befor=0;
      $havale_forush_bef=0;
	  $q_forush1=("SELECT h_code,mande_az_forush FROM $mydatabase.havale_forush WHERE code_kala=".$row['code_kala']." AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0 AND h_reg_date>='$mtStartDateSh' AND  h_reg_date<'$date1'");
	  $res_forush1=$db->query($q_forush1);
	  while($row_forush1=$db->fetch_array($res_forush1))//به ازای هر حواله میخواهیم مقدار اولیه حواله فروش را درآوریم
	  {
		    /**///محاسبه کل تحویلی برای این حواله
			 $meghdar_tahvily_per1=$db->get_from_where("SUM($havaleField)","$mydatabase.havale_detail","h_code=".$row_forush1['h_code']." AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND havale_deleted=0 AND status=0");
	        /**///محاسبه کل باطله برای این حواله
             $meghdar_batele_per1=$db->get_from_where("SUM(meghdar_batele)","$mydatabase.ebtal","h_code=".$row_forush1['h_code']." AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0");
	         $havale_forush_bef=$row_forush1['mande_az_forush']+$meghdar_tahvily_per1+$meghdar_batele_per1;//مقدار اولیه هر حواله فروش
			 /**///محاسبه مقدار مانده از حواله فروش
			 // //مقدار کل ابطالی هل قبل از تاریخ
		     $q_ebtal_befor="SELECT SUM(meghdar_batele) FROM $mydatabase.ebtal INNER JOIN $mydatabase.havale_forush ON ebtal.h_code=havale_forush.h_code AND ebtal.code_ostan=havale_forush.code_ostan AND ebtal.code_anbar=havale_forush.code_anbar AND ebtal.year=havale_forush.year
	                            WHERE code_kala=".$row['code_kala']." AND ebtal.h_code=".$row_forush1['h_code']." AND havale_forush.code_ostan='$mt_gl_code_ostan' AND havale_forush.code_anbar='$mt_gl_code_anbar' AND havale_forush.year='$mtActiveYear' AND havale_forush.deleted=0 AND ebtal.deleted=0 AND h_reg_date>='$mtStartDateSh' AND ebtal.tarikh_barge_ebtal<'$date1'";    
		     $res_ebtal_befor=$db->query($q_ebtal_befor);
	         $meghdar_ebtali_befor=$db->fetch_array($res_ebtal_befor);
		     //حواله جنسی قبل از تاریخ
		     $sadere_befor=$db->get_from_where("SUM($havaleField)","$mydatabase.havale_detail as h_d INNER JOIN $mydatabase.havale as h ON h.shomare_havale_anbar=h_d.shomare_havale_anbar AND h.code_ostan=h_d.code_ostan AND h.code_anbar=h_d.code_anbar AND h.year=h_d.year","h_d.code_kala=".$row['code_kala']." AND h_d.h_code=".$row_forush1['h_code']." AND h_d.code_ostan='$mt_gl_code_ostan' AND h_d.code_anbar='$mt_gl_code_anbar' AND h_d.year='$mtActiveYear' AND h_d.havale_deleted=0 AND h_d.status=0 AND h.tarikh_havale_anbar<'$date1'");
		     //محاسبه مقدار حواله فروش قبل از تاریخ
		     $havale_forush_befor_per=$havale_forush_bef-$sadere_befor-$meghdar_ebtali_befor[0];
			 $havale_forush_befor+=$havale_forush_befor_per;//دومین فیلد را پر می کند
      }
	  //فیلد ششم
	  //مقدار کل حواله فروش ها مابین تاریخ
	  $havale_forush_bet_per=0;
      $havale_forush_between=0;
	  $q_forush2=("SELECT h_code,mande_az_forush FROM $mydatabase.havale_forush WHERE code_kala=".$row['code_kala']." AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0 AND h_reg_date>='$mtStartDateSh' AND h_reg_date>='$date1' AND h_reg_date<='$date2'");
	  $res_forush2=$db->query($q_forush2);
	  while($row_forush2=$db->fetch_array($res_forush2))//به ازای هر حواله میخواهیم مقدار اولیه حواله فروش را درآوریم
	  {
	     /**///محاسبه کل تحویلی برای این حواله
         $meghdar_tahvily_per2=$db->get_from_where("SUM($havaleField)","$mydatabase.havale_detail","h_code=".$row_forush2['h_code']." AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND havale_deleted=0 AND status=0");
	     /**///محاسبه کل باطله برای این حواله
         $meghdar_batele_per2=$db->get_from_where("SUM(meghdar_batele)","$mydatabase.ebtal","h_code=".$row_forush2['h_code']." AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND deleted=0");
	     $havale_forush_bet_per=$row_forush2['mande_az_forush']+$meghdar_tahvily_per2+$meghdar_batele_per2;//مقدار اولیه هر حواله فروش
	     $havale_forush_between+=$havale_forush_bet_per;//پنجمین فیلد را پر میکند
	  }
	  //فیلد نهم//جمع فروش
	  $jame_forush=$havale_forush_befor+$havale_forush_between;
	  //فیلد چهاردهم
	  //مقدار ابطالی حواله فروش
	   $q_ebtal="SELECT SUM(meghdar_batele) FROM $mydatabase.ebtal e INNER JOIN $mydatabase.havale_forush h_f ON e.h_code=h_f.h_code AND e.code_ostan=h_f.code_ostan AND e.code_anbar=h_f.code_anbar AND e.year=h_f.year
                 WHERE code_kala=".$row['code_kala']." AND h_f.code_ostan='$mt_gl_code_ostan' AND h_f.code_anbar='$mt_gl_code_anbar' AND h_f.year='$mtActiveYear' AND h_f.deleted=0 AND e.deleted=0 AND e.tarikh_barge_ebtal>='$mtStartDateSh' AND h_f.h_reg_date>='$mtStartDateSh' AND e.tarikh_barge_ebtal>='$date1' AND e.tarikh_barge_ebtal<='$date2'";    
	   $res_ebtal=$db->query($q_ebtal);
       $meghdar_ebtali=$db->fetch_array($res_ebtal); 
  
   }//END system sardkhane
   else /*سیستم فروش*/
   { 
    /***************درکوئری مربوط به فروش فیلترها روی گزارش*******************/	
	if($date1)//از تاریخ
	{     
	      //تبدیل تاریخ شمسی به میلادی
	       $sql_tarikh=$date1;
           $d=substr($sql_tarikh,8,2);
           $m=substr($sql_tarikh,5,2);
           $y=substr($sql_tarikh,0,4);
           $milady=jalali_to_gregorian($y,$m,$d);
           $sal=$milady[0];
           $mah=$milady[1];
           $rouz=$milady[2];
           $date1_sell=$sal.'-'.$mah.'-'.$rouz;
	       //$Condition.=" and h_reg_date>='$date1'";
	}
    if ($date2)//تا تاریخ 
	{
	      //تبدیل تاریخ شمسی به میلادی
	       $sql_tarikh=$date2;
           $d=substr($sql_tarikh,8,2);
           $m=substr($sql_tarikh,5,2);
           $y=substr($sql_tarikh,0,4);
           $milady=jalali_to_gregorian($y,$m,$d);
           $sal=$milady[0];
           $mah=$milady[1];
           $rouz=$milady[2];
           $date2_sell=$sal.'-'.$mah.'-'.$rouz;
	       //$Condition.=" and h_reg_date<='$date2'";
	} 
     //پیدا کردن آی دی کد استان مربوط به سیتم فروش
     $res_ostan=mysql_query("SELECT province_id FROM sell.dm_province WHERE province_code='$mt_gl_code_ostan'");
     $sell_id_ostan=mysql_result($res_ostan, 0, 'province_id');
     //پیدا کردن آی دی کد انبار مربوط به سیستم فروش
	 $res_anbar=mysql_query("SELECT l_id FROM sell.dm_location_goods WHERE l_id_province='$sell_id_ostan' AND l_code='$mt_gl_code_anbar'");
     $sell_id_anbar=mysql_result($res_anbar, 0, 'l_id');
	 //مانده از حواله فروش قبل از تاریخ		 
	 //فیلد دوم
	 $havale_forush_befor=0;
     $havale_forush_bef=0;
     $q_forush1=("SELECT h_code,h_mande_havale FROM sell.dm_havale WHERE h_p_code=".$row['code_kala']." AND h_id_province='$sell_id_ostan' AND h_l_code='$sell_id_anbar' AND h_id_year='$sellYearId' AND h_reg_date>='$mtStartDateMi' AND h_reg_date<'$date1_sell'");
	 $res_forush1=$db->query($q_forush1);
	 while($row_forush1=$db->fetch_array($res_forush1))//به ازای هر حواله میخواهیم مقدار اولیه حواله فروش را درآوریم
	 {
		/**///محاسبه کل تحویلی برای این حواله
		$meghdar_tahvily_per1=$db->get_from_where("SUM($havaleField)","$mydatabase.havale_detail","h_code=".$row_forush1['h_code']." AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND havale_deleted=0 AND status=0");
	    /**///محاسبه کل باطله برای این حواله
	    //مجموع مقدار ابطالی های این حواله فروش در سیستم فروش
	    $q_ebtalha="SELECT SUM(his_eb_amount) FROM sell.dm_his_havale INNER JOIN sell.dm_havale ON dm_his_havale.his_h_id=dm_havale.h_id WHERE his_h_code=".$row_forush1['h_code']." AND h_id_province='$sell_id_ostan' AND h_l_code='$sell_id_anbar' And h_id_year='$sellYearId'";	   
	    $res_ebtalha=mysql_query($q_ebtalha);
	    $row_ebtalha=mysql_fetch_array($res_ebtalha);
	    $meghdar_batele_per1=$row_ebtalha[0];	         
	    $havale_forush_bef=$row_forush1['h_mande_havale']+$meghdar_tahvily_per1+$meghdar_batele_per1;//مقدار اولیه هر حواله فروش
		/**///محاسبه مقدار مانده از حواله فروش
		// //مقدار کل ابطالی هل قبل از تاریخ
	    $q_ebtal_befor="SELECT SUM(his_eb_amount) FROM sell.dm_his_havale 
	                INNER JOIN sell.dm_havale ON dm_his_havale.his_h_id=dm_havale.h_id
	                INNER JOIN sell.dm_ebtal_h ON dm_his_havale.his_id=dm_ebtal_h.ebh_h_id
	                WHERE h_p_code=".$row['code_kala']." AND his_h_code=".$row_forush1['h_code']." AND h_id_province='$sell_id_ostan' AND h_l_code='$sell_id_anbar' AND h_id_year='$sellYearId' AND h_reg_date>='$mtStartDateMi' AND ebh_reg_date<'$date1_sell'"; 
	    $res_ebtal_befor=$db->query($q_ebtal_befor);
	    $meghdar_ebtali_befor=$db->fetch_array($res_ebtal_befor);	 
		//حواله جنسی قبل از تاریخ
		$sadere_befor=$db->get_from_where("SUM($havaleField)","$mydatabase.havale_detail as h_d INNER JOIN $mydatabase.havale as h ON h.shomare_havale_anbar=h_d.shomare_havale_anbar AND h.code_ostan=h_d.code_ostan AND h.code_anbar=h_d.code_anbar AND h.year=h_d.year","h_d.code_kala=".$row['code_kala']." AND h_d.h_code=".$row_forush1['h_code']." AND h_d.code_ostan='$mt_gl_code_ostan' AND h_d.code_anbar='$mt_gl_code_anbar' AND h_d.year='$mtActiveYear' AND h_d.havale_deleted=0 AND h_d.status=0 AND h.tarikh_havale_anbar<'$date1'");
		//محاسبه مقدار حواله فروش قبل از تاریخ
		$havale_forush_befor_per=$havale_forush_bef-$sadere_befor-$meghdar_ebtali_befor[0];
	    $havale_forush_befor+=$havale_forush_befor_per;
	 }
	 //فیلد ششم
	 //مقدار کل حواله فروش ها مابین تاریخ
	 $havale_forush_bet_per=0;
     $havale_forush_between=0;
	 $q_forush2=("SELECT h_code,h_mande_havale FROM sell.dm_havale WHERE h_p_code=".$row['code_kala']." AND h_id_province='$sell_id_ostan' AND h_l_code='$sell_id_anbar' AND h_id_year='$sellYearId' AND h_reg_date>='$mtStartDateMi' AND h_reg_date>='$date1_sell' AND h_reg_date<='$date2_sell'");
	 $res_forush2=$db->query($q_forush2);
	 while($row_forush2=$db->fetch_array($res_forush2))//به ازای هر حواله میخواهیم مقدار اولیه حواله فروش را درآوریم
	 {
		/**///محاسبه کل تحویلی برای این حواله
	    $meghdar_tahvily_per2=$db->get_from_where("SUM($havaleField)","$mydatabase.havale_detail","h_code=".$row_forush2['h_code']." AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND havale_deleted=0 AND status=0");
	    /**///محاسبه کل باطله برای این حواله
		//مجموع مقدار ابطالی های این حواله فروش در سیستم فروش
		$q_ebtalha="SELECT SUM(his_eb_amount) FROM sell.dm_his_havale INNER JOIN sell.dm_havale ON dm_his_havale.his_h_id=dm_havale.h_id WHERE his_h_code=".$row_forush2['h_code']." AND h_id_province='$sell_id_ostan' AND h_l_code='$sell_id_anbar' And h_id_year='$sellYearId'";	   
	    $res_ebtalha=mysql_query($q_ebtalha);
	    $row_ebtalha=mysql_fetch_array($res_ebtalha);
	    $meghdar_batele_per2=$row_ebtalha[0];	
	    $havale_forush_bet_per=$row_forush2['h_mande_havale']+$meghdar_tahvily_per2+$meghdar_batele_per2;//مقدار اولیه هر حواله فروش
	    $havale_forush_between+=$havale_forush_bet_per;
	   }
	  //////////////////////////////////////////////////
      //فیلد نهم//جمع فروش
	  $jame_forush=$havale_forush_befor+$havale_forush_between;
	  //فیلد چهاردهم
	  //مقدار ابطالی
      $q_ebtal="SELECT SUM(his_eb_amount) FROM sell.dm_his_havale 
	            INNER JOIN sell.dm_havale ON dm_his_havale.his_h_id=dm_havale.h_id
	            INNER JOIN sell.dm_ebtal_h  ON dm_his_havale.his_id=dm_ebtal_h.ebh_h_id
	            WHERE h_p_code=".$row['code_kala']." AND dm_ebtal_h.ebh_reg_date>='$mtStartDateMi' AND dm_havale.h_reg_date>='$mtStartDateMi' AND h_id_province='$sell_id_ostan' AND h_l_code='$sell_id_anbar' AND h_id_year='$sellYearId' AND ebh_reg_date>='$date1_sell' AND ebh_reg_date<='$date2_sell'";
	  $res_ebtal=$db->query($q_ebtal);
	  $meghdar_ebtali=$db->fetch_array($res_ebtal);	 
     }//END ELSE system forush
	 
	 //فیلد پانزدهم
	 //مقدار ابطالی مجوز جابه جایی
	  $q_ebtal_j="SELECT SUM(meghdar_batele_j) FROM $mydatabase.ebtal_jabejae e_j INNER JOIN $mydatabase.mojavez_jabejae m_j ON e_j.shomare_jabejae=m_j.shomare_jabejae AND e_j.code_ostan=m_j.code_ostan AND e_j.code_anbar=m_j.code_anbar AND e_j.year=m_j.year
                   WHERE code_kala=".$row['code_kala']." AND e_j.code_ostan='$mt_gl_code_ostan' AND e_j.code_anbar='$mt_gl_code_anbar' AND e_j.year='$mtActiveYear' AND e_j.deleted=0 AND m_j.deleted=0 AND e_j.tarikh_barge_ebtal_j>='$date1' AND e_j.tarikh_barge_ebtal_j<='$date2'";    
	  $res_ebtal_j=$db->query($q_ebtal_j);
      $meghdar_ebtali_j=$db->fetch_array($res_ebtal_j); 
	  //فیلد شانزدهم 
	  //نهایی جنسی
	  $nahayi_jensi=$jame_jensi-$sadere_between_forush-$sadere_between_jabejae-$meghdarTadil_Kasry;
	  //فیلد هفدهم  
	  //change//نهایی فروش
	  //$nahayi_forush=$db->get_from_where("SUM(mande_az_forush)","havale_forush","code_kala=".$row['code_kala']." AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND h_reg_date>='$mtStartDateSh' AND deleted=0 AND h_reg_date>='$date1' AND h_reg_date<='$date2'");
	  $nahayi_forush=$jame_forush-$sadere_between_forush-$meghdar_ebtali[0];
	  //فیلد هجدهم 
	  $nahayi_jabejae=$jame_jabejae-$sadere_between_jabejae-$meghdar_ebtali_j[0];
	  //فیلد نوزدهم  
	   $mande_pasazkasr_forush=$nahayi_jensi-$nahayi_forush;
	  //فیلد بیستم 
	   $mande_pasazkasr=$nahayi_jensi-$nahayi_forush-$nahayi_jabejae;
	   //$mande_pasazkasr=$nahayi_jensi-abs($nahayi_forush)-abs($nahayi_jabejae);
	   //if($mande_pasazkasr<0)$mande_pasazkasr=0;
	 /****************محاسبه مجموع مقادیر در سطر آخر قوطی*******************/
	 if($codeBastebandy==2)//قوطی
     {	  
	    $sum_mande_befor_ghoti+=$mande_beforGhoti;
	    $sum_havale_forush_befor_ghoti+=$havale_forush_befor;
	    $sum_jabejae_befor_ghoti+=$jabejae_befor;
	    $sum_varede_between_ghoti+=$varede_between;
	    $sum_havale_forush_between_ghoti+=$havale_forush_between;
	    $sum_jabejae_between_ghoti+=$jabejae_between;
	    $sum_meghdarTadil_Ezafe_ghoti+=$meghdarTadil_Ezafe;
	    $sum_jame_jensi_ghoti+=$jame_jensi;
	    $sum_jame_forush_ghoti+=$jame_forush;
	    $sum_jame_jabejae_ghoti+=$jame_jabejae;
	    $sum_sadere_between_forush_ghoti+=$sadere_between_forush;
	    $sum_sadere_between_jabejae_ghoti+=$sadere_between_jabejae;
	    $sum_meghdarTadil_Kasry_ghoti+=$meghdarTadil_Kasry;
	    $sum_ebtaly_forush_ghoti+=$meghdar_ebtali[0];
	    $sum_ebtaly_jabejae_ghoti+=$meghdar_ebtali_j[0];
	    $sum_nahayi_jensi_ghoti+=$nahayi_jensi;
	    $sum_nahayi_forushi_ghoti+=$nahayi_forush;
	    $sum_nahayi_jabejaei_ghoti+=$nahayi_jabejae;
	    $sum_mande_pasazkasri_forush_ghoti+=$mande_pasazkasr_forush;
	    $sum_mande_pasazkasri_ghoti+=$mande_pasazkasr;
	 }
	 /****************محاسبه مجموع مقادیر در سطر آخر شانه تخم مرغ*******************/
	 if($row['code_kala']==50)//شانه تخم مرغ
     {	  
	    $sum_mande_befor_shane+=$mande_beforShane;
	    $sum_havale_forush_befor_shane+=$havale_forush_befor;
	    $sum_jabejae_befor_shane+=$jabejae_befor;
	    $sum_varede_between_shane+=$varede_between;
	    $sum_havale_forush_between_shane+=$havale_forush_between;
	    $sum_jabejae_between_shane+=$jabejae_between;
	    $sum_meghdarTadil_Ezafe_shane+=$meghdarTadil_Ezafe;
	    $sum_jame_jensi_shane+=$jame_jensi;
	    $sum_jame_forush_shane+=$jame_forush;
	    $sum_jame_jabejae_shane+=$jame_jabejae;
	    $sum_sadere_between_forush_shane+=$sadere_between_forush;
	    $sum_sadere_between_jabejae_shane+=$sadere_between_jabejae;
	    $sum_meghdarTadil_Kasry_shane+=$meghdarTadil_Kasry;
	    $sum_ebtaly_forush_shane+=$meghdar_ebtali[0];
	    $sum_ebtaly_jabejae_shane+=$meghdar_ebtali_j[0];
	    $sum_nahayi_jensi_shane+=$nahayi_jensi;
	    $sum_nahayi_forushi_shane+=$nahayi_forush;
	    $sum_nahayi_jabejaei_shane+=$nahayi_jabejae;
	    $sum_mande_pasazkasri_forush_shane+=$mande_pasazkasr_forush;
	    $sum_mande_pasazkasri_shane+=$mande_pasazkasr;
	 }
	 /****************محاسبه مجموع مقادیر در سطر آخر کارتنی*******************/
	 if((($codeBastebandy==1)or($codeBastebandy==3))AND($row['code_kala']!=50))//کارتن
	 {
		$sum_mande_befor_kartoni+=$mande_beforKartoni;
	    $sum_havale_forush_befor_kartoni+=$havale_forush_befor;
	    $sum_jabejae_befor_kartoni+=$jabejae_befor;
	    $sum_varede_between_kartoni+=$varede_between;
	    $sum_havale_forush_between_kartoni+=$havale_forush_between;
	    $sum_jabejae_between_kartoni+=$jabejae_between;
	    $sum_meghdarTadil_Ezafe_kartoni+=$meghdarTadil_Ezafe;
	    $sum_jame_jensi_kartoni+=$jame_jensi;
	    $sum_jame_forush_kartoni+=$jame_forush;
	    $sum_jame_jabejae_kartoni+=$jame_jabejae;
	    $sum_sadere_between_forush_kartoni+=$sadere_between_forush;
	    $sum_sadere_between_jabejae_kartoni+=$sadere_between_jabejae;
	    $sum_meghdarTadil_Kasry_kartoni+=$meghdarTadil_Kasry;
	    $sum_ebtaly_forush_kartoni+=$meghdar_ebtali[0];
	    $sum_ebtaly_jabejae_kartoni+=$meghdar_ebtali_j[0];
	    $sum_nahayi_jensi_kartoni+=$nahayi_jensi;
	    $sum_nahayi_forushi_kartoni+=$nahayi_forush;
	    $sum_nahayi_jabejaei_kartoni+=$nahayi_jabejae;
	    $sum_mande_pasazkasri_forush_kartoni+=$mande_pasazkasr_forush;
	    $sum_mande_pasazkasri_kartoni+=$mande_pasazkasr;
	 }
   	 /*****شروع نمایش اطلاعات*****/
	   if($i++%2)echo'<tr class="print_table-odd_small">';
       else echo'<tr class="print_table-even_small">';
       echo'
	   <td>'.$radif++.'</td>
	   <td>'.$nameKala.'</td>
	   <td>'.$sharhBastebandy.'</td>';
	   if($codeBastebandy==2)//قوطی
	   {echo'<td>'.round($mande_beforGhoti,3).'</td>';}
	   else if($row['code_kala']==50)//تخم مرغ
	   {echo'<td>'.round($mande_beforShane,3).'</td>';}
	   else //کارتن یا لاشه
	   {echo'<td>'.round($mande_beforKartoni,3).'</td>';}

		echo' 
		<td>'.round($havale_forush_befor,3).'</td>
	    <td>'.round($jabejae_befor,3).'</td>
	    <td>'.round($varede_between,3).'</td>
	    <td>'.round($meghdarTadil_Ezafe,3).'</td>
	    <td>'.round($havale_forush_between,3).'</td>
	    <td>'.round($jabejae_between,3).'</td>
	    <td>'.round($jame_jensi,3).'</td>
	    <td>'.round($jame_forush,3).'</td>
	    <td>'.round($jame_jabejae,3).'</td>
	    <td>'.round($sadere_between_forush,3).'</td>
	    <td>'.round($sadere_between_jabejae,3).'</td>
	    <td>'.round($meghdarTadil_Kasry,3).'</td>
	    <td>'.round($meghdar_ebtali[0],3).'</td>
	    <td>'.round($meghdar_ebtali_j[0],3).'</td>
	    <td>'.round($nahayi_jensi,3).'</td>
	    <td>'.round($nahayi_forush,3).'</td>
	    <td>'.round($nahayi_jabejae,3).'</td>
	    <td>'.round($mande_pasazkasr_forush,3).'</td>
	    <td>'.round($mande_pasazkasr,3).'</td>
	 </tr>';
	if($line>=$MaxLines && $i <$cntr) 
	{
	     $line=0;
         $page++;
	     echo'
		 </table>
		   <br class="pbreak">';
		    print_header();
		    echo $columns;
	}
   }//END WHILE ASLI
   echo'
	 <tr class="print_table-even_small sum-row-white-b">
	  <td colspan="3">جمع خالص (کارتنی ها)</td>
	  <td>'.round($sum_mande_befor_kartoni,3).'</td>
	  <td>'.round($sum_havale_forush_befor_kartoni,3).'</td>
	  <td>'.round($sum_jabejae_befor_kartoni,3).'</td>
	  <td>'.round($sum_varede_between_kartoni,3).'</td>
	  <td>'.round($sum_meghdarTadil_Ezafe_kartoni,3).'</td>
	  <td>'.round($sum_havale_forush_between_kartoni,3).'</td>
	  <td>'.round($sum_jabejae_between_kartoni,3).'</td>
	  <td>'.round($sum_jame_jensi_kartoni,3).'</td>
	  <td>'.round($sum_jame_forush_kartoni,3).'</td>
	  <td>'.round($sum_jame_jabejae_kartoni,3).'</td>
	  <td>'.round($sum_sadere_between_forush_kartoni,3).'</td>
	  <td>'.round($sum_sadere_between_jabejae_kartoni,3).'</td>
	  <td>'.round($sum_meghdarTadil_Kasry_kartoni,3).'</td>
	  <td>'.round($sum_ebtaly_forush_kartoni,3).'</td>
	  <td>'.round($sum_ebtaly_jabejae_kartoni,3).'</td>
	  <td>'.round($sum_nahayi_jensi_kartoni,3).'</td>
	  <td>'.round($sum_nahayi_forushi_kartoni,3).'</td>
	  <td>'.round($sum_nahayi_jabejaei_kartoni,3).'</td>
	  <td>'.round($sum_mande_pasazkasri_forush_kartoni,3).'</td>
	  <td>'.round($sum_mande_pasazkasri_kartoni,3).'</td>
	 </tr>
	 <tr class="print_table-even_small sum-row-white-b">
	  <td colspan="3">جمع تعداد (قوطی ها)</td>
	  <td>'.$sum_mande_befor_ghoti.'</td>
	  <td>'.round($sum_havale_forush_befor_ghoti,3).'</td>
	  <td>'.round($sum_jabejae_befor_ghoti,3).'</td>
	  <td>'.round($sum_varede_between_ghoti,3).'</td>
	  <td>'.round($sum_meghdarTadil_Ezafe_ghoti,3).'</td>
	  <td>'.round($sum_havale_forush_between_ghoti,3).'</td>
	  <td>'.round($sum_jabejae_between_ghoti,3).'</td>
	  <td>'.round($sum_jame_jensi_ghoti,3).'</td>
	  <td>'.round($sum_jame_forush_ghoti,3).'</td>
	  <td>'.round($sum_jame_jabejae_ghoti,3).'</td>
	  <td>'.round($sum_sadere_between_forush_ghoti,3).'</td>
	  <td>'.round($sum_sadere_between_jabejae_ghoti,3).'</td>
	  <td>'.round($sum_meghdarTadil_Kasry_ghoti,3).'</td>
	  <td>'.round($sum_ebtaly_forush_ghoti,3).'</td>
	  <td>'.round($sum_ebtaly_jabejae_ghoti,3).'</td>
	  <td>'.round($sum_nahayi_jensi_ghoti,3).'</td>
	  <td>'.round($sum_nahayi_forushi_ghoti,3).'</td>
	  <td>'.round($sum_nahayi_jabejaei_ghoti,3).'</td>
	  <td>'.round($sum_mande_pasazkasri_forush_ghoti,3).'</td>
	  <td>'.round($sum_mande_pasazkasri_ghoti,3).'</td>
	 </tr>
	 <tr class="print_table-even_small sum-row-white-b">
	  <td colspan="3">جمع تعداد شانه</td>
	  <td>'.$sum_mande_befor_shane.'</td>
	  <td>'.virgul($sum_havale_forush_befor_shane).'</td>
	  <td>'.virgul($sum_jabejae_befor_shane).'</td>
	  <td>'.virgul($sum_varede_between_shane).'</td>
	  <td>'.virgul($sum_meghdarTadil_Ezafe_shane).'</td>
	  <td>'.virgul($sum_havale_forush_between_shane).'</td>
	  <td>'.virgul($sum_jabejae_between_shane).'</td>
	  <td>'.virgul($sum_jame_jensi_shane).'</td>
	  <td>'.virgul($sum_jame_forush_shane).'</td>
	  <td>'.virgul($sum_jame_jabejae_shane).'</td>
	  <td>'.virgul($sum_sadere_between_forush_shane).'</td>
	  <td>'.virgul($sum_sadere_between_jabejae_shane).'</td>
	  <td>'.virgul($sum_meghdarTadil_Kasry_shane).'</td>
	  <td>'.virgul($sum_ebtaly_forush_shane).'</td>
	  <td>'.virgul($sum_ebtaly_jabejae_shane).'</td>
	  <td>'.virgul($sum_nahayi_jensi_shane).'</td>
	  <td>'.virgul($sum_nahayi_forushi_shane).'</td>
	  <td>'.virgul($sum_nahayi_jabejaei_shane).'</td>
	  <td>'.virgul($sum_mande_pasazkasri_forush_shane).'</td>
	  <td>'.virgul($sum_mande_pasazkasri_shane).'</td>
	 </tr>
	 <!--پايان مرکز صفحه -->
	 <!-- چاپ زیرنویس-->
     <tr class="print_footer noExl">
      <td colspan="40">&nbsp;&nbsp;نام کاربر :&nbsp;&nbsp;'.$mtuserNAME.' &nbsp;&nbsp;&nbsp; تاریخ چاپ : '.$today.' &nbsp;&nbsp;&nbsp; ساعت چاپ : '.$logtime.'</td>
     </tr>
	</table>';	 	
 }//END IF//وجود اطلاعات
 ELSE{echo'<div class="msg_error"><span >اطلاعاتی یافت نشد</span><br><button class="buttonme hideatprint" onClick="window.location=\''.$FileName.'\'">بازگشت</button></div>';}	
}//END ELSE show report   
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo'
</div>	
</form>
</body>
</html>
<a href="#" class="elevator-button"></a>';	
?>
<script type="text/javascript" src="scripts/elevator.min.js"></script>