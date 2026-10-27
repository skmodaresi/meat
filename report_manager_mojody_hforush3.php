<?php
//date change 1395/08/19
//این گزارش برای سایر کاربران در لوکال به خاطر وجود کوئری های فروش اررور دارد در هاست درست است
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="report_manager_mojody_hforush.php";
$ExcelFileName=str_replace('.php','',$FileName);
$titr='گزارش براساس مانده موجودی و حواله فروش و جابه جایی استان ها';
require_once('head.html');
IF($namayesh_info==2) {$str_j='(تحت کلید گمرک)'; $info='نمایش : تحت کلید گمرک';}
ELSE {$info='نمایش : سایر';}
$columns='
	   <tr class="print_table-title2">
	    <td rowspan="4" width="5%">ردیف</td>
	    <td rowspan="4" width="5%">استان</td>
	    <td rowspan="4" width="5%">نام کالا</td>
	    <td rowspan="4" width="5%">واحد کالا</td>
	    <td rowspan="4" width="5%">بسته بندی</td>
	    <td colspan="4" width="10%">مانده از دوره قبل</td>
	    <td colspan="7" width="15%">میزان وارده طی دوره</td>
	    <td colspan="4" width="10%">جمع</td>
	    <td colspan="7" width="15%">مقدار تحویلی طی دوره</td>
	    <td colspan="6" width="15%">مانده نهایی</td>
	   </tr>
	   <tr class="print_table-title2">
	    <td rowspan="3" width=>موجودی جنسی</td>
	    <td rowspan="3" width=>حواله فروش</td>
	    <td colspan="2" width=>مجوز جابه جایی '.$str_j.'</td>
	    <td colspan="3" width=>رسید جنسی</td>
	    <td rowspan="3" width=>تعدیل جنسی</td>
	    <td rowspan="3" width=>حواله فروش</td>
	    <td colspan="2" width=>مجوز جابه جایی '.$str_j.'</td>
	    <td rowspan="3" width=>جنسی</td>
	    <td rowspan="3" width=>حواله فروش</td>
	    <td colspan="2" width=>مجوز جابه جایی '.$str_j.'</td>
	    <td colspan="3" width=>حواله جنسی</td>
	    <td rowspan="3" width=>تعدیل جنسی</td>
	    <td colspan="3" width=>ابطالی</td>
	    <!--<td rowspan="2" width=>جنسی با انبار موقت</td>-->
	    <td rowspan="3" width=>جنسی</td>
	    <td rowspan="3" width=>حواله فروش</td>
	    <td colspan="2" width=>مجوز جابه جایی '.$str_j.'</td>
	    <td rowspan="3" width=>مانده پس از کسر حواله فروش</td>
	    <td rowspan="3" width=>مانده پس از کسر حواله و مجوز</td>
	   </tr>
	   <tr class="print_table-title2 print_table-title_small">
	    <td rowspan="2">به موقت</td>
	    <td rowspan="2">به سایر</td>
	    <td rowspan="2">خرید</td>
	    <td rowspan="2">جابه جایی</td>
	    <td rowspan="2">برگشت از فروش</td>
		<td rowspan="2">به موقت</td>
	    <td rowspan="2">به سایر</td>
		<td rowspan="2">به موقت</td>
	    <td rowspan="2">به سایر</td>
		<td rowspan="2">حواله فروش</td>
	    <td colspan="2">جابه جایی</td>
	    <td rowspan="2">حواله فروش</td>
	    <td colspan="2">جابه جایی</td>
	    <td rowspan="2">به موقت</td>
	    <td rowspan="2">به سایر</td>
	   </tr>
	   <tr  class="print_table-title2 print_table-title_small">
	   	<td>به موقت</td>
	    <td>به سایر</td>
	   	<td>به موقت</td>
	    <td>به سایر</td>
	   </tr>

	    <!--<td colspan="4" width=16%>مانده از دوره قبل (خالص)</td>
	    <td colspan="7" width=20%>میزان وارده طی دوره (خالص)</td>
	    <td colspan="4" width=17%>جمع (خالص)</td>
	    <td colspan="7" width=20%>مقدار تحویلی طی دوره (خالص)</td>
	    <td colspan="5" width=16%>مانده نهایی (خالص)</td>-->
';
Function print_header()
{global $titr,$columns,$mt_gl_owner,$mt_gl_name_anbar,$mt_gl_name_ostan,$date1,$date2,$FileName,$page,$namayesh_info;
  IF($namayesh_info==2) $info='نمایش : تحت کلید گمرک';
  ELSE $info='نمایش : سایر';
  echo'
   <br>   
   <table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
	<tr class="noExl">
     <td colspan="50">
	  <table width="100%"  align="center">
       <tr class="noExl"><td class="print_title_2">'.$mt_gl_owner.'</td></tr>
       <tr class="noExl"><td class="print_title_2">'.$titr.'</td></tr>
	   <tr class="noExl">
	    <td class="print_title_2">';
		IF($page==1){
			 echo'<a href="javascript:window.print();"><span style="float:right" id="printerReport" class="hideatprint" title="چاپ"></span></a>
			      <span style="float:right" id="exportExcel" title="خروجی اکسل" ></span>';
		 }
         echo'
	      از تاریخ : '.$date1.' تا تاریخ : '.$date2.'&nbsp&nbsp(صفحه : '.$page.')-'.$info.'
          <div style="float:left;"><button class="buttonme hideatprint" onClick="window.location=\''.$FileName.'\'">بازگشت</button></div>
	    </td>
	   </tr>';
	   IF($page==1) {
		   echo'<tr class="noExl"><td class="print_title">
           دقت کنید : در صورتیکه بسته بندی کالا از نوع کارتنی است مقادیر نشان دهنده وزن خالص است و 
		   در صورتیکه کالا تخم مرغ (کد کالا 50یا 54) باشد مقادیر نشان دهنده شانه تخم مرغ و
		   در صورتیکه بسته بندی از نوع قوطی است مقادیر نشان دهنده تعداد کالا است .
		   </td></tr>';}
	   echo'
      </table>
    </td>
   </tr>';
 }
/***************************************** MAIN*****************************************/
echo'
<body class="openwin" onload="document.myform.date1.focus();">
<form method="post" name="myform" onkeydown="enterIE()">';
if(!$MaxLines)$MaxLines=5;
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
if(!$ok)//هنوز روی دکمه گزارش کلیک نکرده
{
 echo'
 <table width="98%" align="center" cellpadding="0" cellspacing="0">
  <tr>
   <td height="100%">
    <table width="650px" border="0" align="center" cellpadding="0" cellspacing="0">
     <tr><td colspan="4" height="20px">&nbsp;</td></tr>
 	<tr>
      <td colspan="4" class="title">'.$titr.'</td>	 
     </tr>
 	<tr class="tr1" style="height:45px;">	
      <td align="left"> از تاریخ :&nbsp;</td><td align="right"><input type="text" class="textboxme2" maxlength="10" name="date1" id="datepickerfrom" placeholder="'.$date1.'"/></td>
      <td align="left"> تا تاریخ :&nbsp;</td><td align="right"><input type="text" class="textboxme2" maxlength="10" name="date2" id="datepickerto" placeholder="'.$date2.'"/></td>
 	</tr>
 	<tr class="tr1">
 	 <td align="left"> کد کالا :&nbsp;</td><td align="right" width="35%"><input type="text" class="textboxme2" name="code_kala" value="'.$code_kala.'" onkeypress="return isNumber(event)" onKeyUp="F10desc(event)" onblur="enterCodeKala(this.value)" style="width:50px;"/>&nbsp;';
	 include ("img_helpkala.php");
     echo'
	 <td align="left"> تعداد خط در صفحه :&nbsp;</td><td align="right"><input type="number" class="textboxme2" name="MaxLines" value="'.$MaxLines.'" onkeypress="return isNumber(event)"/></td>
	</tr>
    <tr class="tr1">
	 <td align="left" height="40px"><input type="checkbox" name="chkmovaghat"/></td><td align="right">&nbsp; نمایش اطلاعات سردخانه موقت </td>
	 <td align="left"><input type="checkbox" name="chkactivate" checked/></td><td align="right">&nbsp; نمایش اطلاعات سردخانه های غیرفعال</td>
	</tr>';
	if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
	{
	 echo'
	 <tr class="tr1">
	  <td align="left" height="40px">نام استان : </td>
      <td align="right" colspan="3">
	   &nbsp;<select name="ostanchoice[]" class="easyui-combobox" style="width:200px;" multiple>';
	   $result_ostan = $db->query("SELECT * FROM ostan ORDER BY name_ostan");
       $ostan_options = "<option value='-1' selected>همه استانها</option>";
       while($row_ostan=$db->fetch_assoc($result_ostan)) $ostan_options .= "<option value=".$row_ostan['code_ostan'].">".$row_ostan['name_ostan']."</option>";
	   echo $ostan_options;
	   echo'
	   </select>      
	  </td>
	 </tr>';
	}
 	echo'
	 <tr class="tr1">
	    <td align="left" height="40px"> نمایش :</td><td align="right" colspan="3">&nbsp;
		'.static_listbox("namayesh_info",$namayesh_info,"namayesh_infoArr",1,"class='easyui-combobox text4' style=width:100px").'
		</td>	
     </tr> 
     <tr class="footer" align="center"><td colspan="4" height="40px"><input class="buttonme" type="submit" name="ok" value="شروع گزارش"></td></tr>      
    </table>
   </td>
  </tr>
 </table>';
}
else//روی دکمه گزارش کلیک کرده
{
    IF($namayesh_info==2){$table_mojody='mojody_kala_gomrok'; $Condition_info=" AND noe_tahvil_bar=9";$Condition_info_mojavez=" AND noe_mojavez=5";}
    ELSE {$table_mojody='mojody_kala'; $Condition_info=" AND noe_tahvil_bar!=9";$Condition_info_mojavez=" ";}
	$kalaCondition="";
	//تبدیل تاریخ شمسی به میلادی
     $sql_tarikh1=$date1;//تاریخ اول
       $d1=substr($sql_tarikh1,8,2);
       $m1=substr($sql_tarikh1,5,2);
       $y1=substr($sql_tarikh1,0,4);
       $milady1=jalali_to_gregorian($y1,$m1,$d1);
       $sal1=$milady1[0];
       $mah1=$milady1[1];
       $rouz1=$milady1[2];
       $date1_milady=$sal1.'-'.$mah1.'-'.$rouz1;
     $sql_tarikh2=$date2;//تاریخ دوم
       $d2=substr($sql_tarikh2,8,2);  
       $m2=substr($sql_tarikh2,5,2);
       $y2=substr($sql_tarikh2,0,4);
       $milady2=jalali_to_gregorian($y2,$m2,$d2);
       $sal2=$milady2[0];
       $mah2=$milady2[1];
       $rouz2=$milady2[2];
       $date2_milady=$sal2.'-'.$mah2.'-'.$rouz2;	
	/****************فیلترها روی گزارش******************/
    $kalaCondition='';
	//شرط کد کالا
	if($code_kala) {$kalaCondition.=" AND code_kala='$code_kala'";}
    /*******استان ها*******/
    if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
    {  
     if(is_array($ostanchoice))//کد های استان
     {
       foreach($ostanchoice as $key => $val ) 
      {
       $Condition_ostan_temp.=" T.code_ostan='$val' OR";
      }
      if($val==-1){$Condition_ostan.="1=1 OR";}
      else {$Condition_ostan.=" $Condition_ostan_temp";}
       $lastSpacePosition = strrpos($Condition_ostan," ");
       $Condition_ostan =substr($Condition_ostan,0,$lastSpacePosition);
     }
    }
    else 
    {
	  $Condition_ostan=' T.code_ostan='.$_SESSION['mt_code_ostan'].'';
    }
    /******انبارها******/
    if(($_SESSION['mt_all_ostan']==1)or(SuperUser())){$Condition_anbar='1=1';$Condition_anbar_ebtal_j='1=1';$Condition_anbar='1=1';$Condition_anbar='1=1';$Condition_anbar_sell='1=1';$Condition_anbar_ebtal_sell='1=1';}
    else //بقیه کاربران براساس انبار قابل دسترسیشان
    { 
     $q_user="SELECT * FROM user_ostan_anbar INNER JOIN list_sardkhane ON list_sardkhane.code_ostan=user_ostan_anbar.code_ostan AND list_sardkhane.code_anbar=user_ostan_anbar.code_anbar WHERE list_sardkhane.code_ostan=".$_SESSION["mt_code_ostan"]." AND user_id=".$_SESSION['mt_user_id']."";
	 $res_user=$db->query($q_user);
     while($row_user=$db->fetch_assoc($res_user))//انبارهای قابل دسترسی
     {
       $Condition_anbar_temp.=" T.code_anbar=".$row_user['code_anbar']." OR";
       $Condition_anbar_ebtal_j_temp.=" e_j.code_anbar=".$row_user['code_anbar']." OR";
       //$Condition_anbar_resid_temp.=" T.code_anbar=".$row_user['code_anbar']." OR";
	   //$Condition_anbar_havale_temp.=" T.code_anbar=".$row_user['code_anbar']." OR";
	   $sell_id_ostan=$db->get_from_where("province_id","sell.dm_province","province_code=".$_SESSION["mt_code_ostan"]."");//تبدیل کد به آی دی
       $sell_id_anbar=$db->get_from_where("l_id","sell.dm_location_goods","l_id_province=$sell_id_ostan AND l_code=".$row_user['code_anbar']."");//تبدیل کد به آی دی 
       if($sell_id_anbar)//اگر نظیرش در فروش بود
       {$Condition_anbar_temp_sell.=" dm_havale.h_l_code=".$sell_id_anbar." OR";
     	//$Condition_anbar_ebtal_temp_sell.=" dm_his_havale.his_l_code=".$sell_id_anbar." OR";
		}
     }
	 $Condition_anbar.="  $Condition_anbar_temp";
	 $Condition_anbar_ebtal_j.="  $Condition_anbar_ebtal_j_temp";
	 // $Condition_anbar.="  $Condition_anbar_resid_temp";
     // $Condition_anbar.="  $Condition_anbar_havale_temp";
	 $Condition_anbar_sell.="  $Condition_anbar_temp_sell";
	 //$Condition_anbar_ebtal_sell.="  $Condition_anbar_ebtal_temp_sell";
     $lastSpacePosition = strrpos($Condition_anbar," ");
     $lastSpacePosition_ebtal_j = strrpos($Condition_anbar_ebtal_j," ");
	 // $lastSpacePosition_resid = strrpos($Condition_anbar," ");
     // $lastSpacePosition_havale = strrpos($Condition_anbar," ");
     $lastSpacePosition_sell = strrpos($Condition_anbar_sell," ");
     //$lastSpacePosition_ebtal_sell = strrpos($Condition_anbar_ebtal_sell," ");
     $Condition_anbar =substr($Condition_anbar,0,$lastSpacePosition);
     $Condition_anbar_ebtal_j =substr($Condition_anbar_ebtal_j,0,$lastSpacePosition_ebtal_j);
	 // $Condition_anbar =substr($Condition_anbar,0,$lastSpacePosition_resid);
     // $Condition_anbar =substr($Condition_anbar,0,$lastSpacePosition_havale);
     $Condition_anbar_sell =substr($Condition_anbar_sell,0,$lastSpacePosition_sell);
     //$Condition_anbar_ebtal_sell =substr($Condition_anbar_ebtal_sell,0,$lastSpacePosition_ebtal_sell);
	}
    /******************نمایش یا عدم نمایش سردخانه های موقت******************/
    if($chkmovaghat=='on') {$Condition_movaghat="";$Condition_movaghat_mj="";}
    else {$Condition_movaghat="list_sardkhane.situation_type=1 AND "; $Condition_movaghat_mj="l_s.situation_type=1 AND";}
	/******************نمایش یا عدم نمایش انبارهای غیرفعال******************/
    if($chkactivate=='on') {$Condition_anbar_activate=""; $Condition_anbar_activate_mj="";  $Condition_anbar_activate_ostan="1=1"; $Condition_anbar_activate_sell=""; }
    else {$Condition_anbar_activate="list_sardkhane.activate=1 AND"; $Condition_anbar_activate_mj="l_s.activate=1 AND"; $Condition_anbar_activate_ostan="activate=1"; $Condition_anbar_activate_sell="activate=1 AND"; }
	/****************شروع نمایش گزارش*******************/				
	$sum_mande_befor=0;
	$sum_havale_forush_befor=0;
    $sum_varede_between=0;
    $sum_havale_forush_between=0;
	$sum_meghdarTadil_Ezafe=0;
    $sum_jame_jensi=0;
    $sum_jame_jensi=0;
    $sum_meghdarTadil_Kasry=0;
	$sum_ebtaly_forush=0;
    $sum_nahayi_jensi=0;
    $sum_nahayi_forush=0;
	$page=1;
    $line=0;
    $i=0;
    $cntr=0;
	$radif=1;
    //$q="SELECT * FROM ostan T WHERE code_ostan IN(SELECT code_ostan FROM list_sardkhane) AND code_ostan IN(SELECT code_ostan FROM mojody_kala WHERE 1=1 $kalaCondition AND year=$mtActiveYear) AND($Condition_ostan) ORDER BY name_ostan";
    $q="SELECT * FROM ostan T WHERE code_ostan IN(SELECT code_ostan FROM list_sardkhane WHERE $Condition_movaghat $Condition_anbar_activate_ostan) AND code_ostan IN(SELECT mojody_kala.code_ostan FROM mojody_kala INNER JOIN list_sardkhane ON list_sardkhane.code_ostan=mojody_kala.code_ostan AND list_sardkhane.code_anbar=mojody_kala.code_anbar WHERE $Condition_anbar_activate_ostan $kalaCondition AND year=$mtActiveYear) AND($Condition_ostan) ORDER BY name_ostan";
	//echo $q;
	$res=$db->query($q);
	$cntr =mysql_num_rows($res);
	if(mysql_num_rows($res)>0)//وجود اطلاعات
	{
	 echo'<div class="table2excel">';
	 print_header();
	 /*سطر نمایش فیلترها*/
 	 if(($ostanchoice))
	 {
	  if($val==-1)$filter_string='همه استانها';
	  else $filter_string=' استان : ';
	  foreach($ostanchoice as $key => $val) {
	   $nameOstan=$db->get_from_where("name_ostan","ostan","code_ostan='$val'");
	   $filter_string.=''.$nameOstan.'&nbsp;';
      }
	 }
	 if($chkmovaghat==TRUE) $filter_string.=' با اطلاعات سردخانه موقت';
     if($chkmovaghat==False) $filter_string.=' بدون اطلاعات سردخانه موقت';
	 if($code_kala) {$nameKala=$db->get_from_where("name_kala","kala","code_kala='$code_kala'"); $filter_string.=' کالا : '.$nameKala.'&nbsp;';}     	 
	 if($code_kala or $ostanchoice)
	 {echo'<tr class="noExl"><td class="filter_text" colspan="40">فیلتر شده براساس : '.$filter_string.'</td></tr>';}
	  echo $columns;
	 while($row=$db->fetch_array($res))//ostan while
	 {
	  $line++;
	  $tedadkala=$db->get_from_where("COUNT(distinct code_kala)","$table_mojody INNER JOIN list_sardkhane ON list_sardkhane.code_ostan=$table_mojody.code_ostan AND list_sardkhane.code_anbar=$table_mojody.code_anbar","$Condition_anbar_activate $table_mojody.code_ostan=".$row['code_ostan']." $kalaCondition AND year='$mtActiveYear'");
	  $rowkala=$tedadkala;
	  $t=$rowkala;
	  /*****شروع نمایش اطلاعات*****/
	  if($i++%2)echo'<tr class="print_table-odd_small">';
      else echo'<tr class="print_table-even_small">';
	  echo'   
	   <td rowspan="'.$rowkala.'">'.$radif++.'</td>
	   <td rowspan="'.$rowkala.'">'.$row['name_ostan'].'</td>';
	   $q2="SELECT code_kala,(SELECT name_kala FROM kala WHERE code_kala=$table_mojody.code_kala) nameKala FROM $table_mojody INNER JOIN list_sardkhane ON list_sardkhane.code_ostan=$table_mojody.code_ostan AND list_sardkhane.code_anbar=$table_mojody.code_anbar WHERE $Condition_anbar_activate $table_mojody.code_ostan=".$row['code_ostan']." AND year='$mtActiveYear' $kalaCondition GROUP BY code_kala";
	   $res2=$db->query($q2);
	   while($row2=$db->fetch_assoc($res2))
	   {
		 $codeBastebandy=$db->get_from_where("code_bastebandy","kala","code_kala=".$row2['code_kala']."");
	     $sharhBastebandy=$db->get_from_where("sharh_bastebandy","bastebandy","code_bastebandy=".$codeBastebandy."");
	     $codeVahed=$db->get_from_where("code_vahedkala","kala","code_kala=".$row2['code_kala']."");
	     IF(($row2['code_kala']==50)OR($row2['code_kala']==54))$vahedKala='شانه';
		 ELSE $vahedKala=$db->get_from_where("sharh_vahedkala","vahed_kala","code_vahedkala=".$codeVahed."");
		 
		 $j=$i+1;
		 echo'
		 <td>'.$row2['nameKala'].'</td>
		 <td>'.$vahedKala.'</td>
		 <td>'.$sharhBastebandy.'</td>';
		 IF(($codeBastebandy==2)OR($codeBastebandy==6)){$avalField='tedad_karton_aval';$residField='tedad_karton_r_d_sub';$havaleField='tedad_karton_h_d';$tadilField='tedad_karton_tadil';}
	     ELSE IF(($row2['code_kala']==50)OR($row2['code_kala']==54)){$avalField='tedad_shane_aval';$residField='tedad_shane_r_d_sub';$havaleField='tedad_shane_h_d';$tadilField='tedad_shane_tadil';}
	     ELSE {$avalField='mojody_khales_aval';$residField='vazn_khales_r_d_sub';$havaleField='vazn_khales_h_d';$tadilField='meghdar_khales_tadil';}
		 //فیلد اول
	      /****************محاسبه مانده موجودی قبل از تاریخ*******************/		  
		  $mande_befor=0;
		  $mande=$db->get_from_where("SUM($avalField)","meat.$table_mojody T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_anbar_activate $Condition_movaghat year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_kala=".$row2['code_kala']." AND deleted=0 AND($Condition_anbar)");     
	      $jameVarede_befor=$db->get_from_where("SUM($residField)","meat.resid_kala_detail T INNER JOIN meat.resid r ON T.shomare_resid=r.shomare_resid AND T.code_ostan=r.code_ostan AND T.code_anbar=r.code_anbar AND T.year=r.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_anbar_activate $Condition_movaghat T.year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_kala=".$row2['code_kala']." AND T.resid_deleted=0 AND T.status=0 AND r.status=0 AND r.tarikh_resid<'".$date1."' AND($Condition_anbar) $Condition_info ");
	      $jameSadere_befor=$db->get_from_where("SUM($havaleField)","meat.havale_detail T INNER JOIN meat.havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_anbar_activate $Condition_movaghat T.year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_kala=".$row2['code_kala']." AND T.havale_deleted=0 AND T.status=0 AND h.status=0 AND h.tarikh_havale_anbar<'".$date1."' AND($Condition_anbar) $Condition_info");	
	      $Tadil_Ezafe_befor=$db->get_from_where("SUM($tadilField)","meat.tadil_mojody T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_anbar_activate $Condition_movaghat noe_tadil=1 AND year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_kala=".$row2['code_kala']." AND deleted=0  AND status=0 AND tarikh_barge_tadil<'".$date1."' AND($Condition_anbar) $Condition_info ");
	      $Tadil_Kasry_befor=$db->get_from_where("SUM($tadilField)","meat.tadil_mojody T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_anbar_activate $Condition_movaghat noe_tadil=2 AND year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.code_kala=".$row2['code_kala']." AND deleted=0  AND status=0 AND tarikh_barge_tadil<'".$date1."' AND($Condition_anbar) $Condition_info ");
	      $mande_befor=$mande+$jameVarede_befor-$jameSadere_befor+$Tadil_Ezafe_befor-$Tadil_Kasry_befor;
		  /****************پایان محاسبه مانده از قبل*******************/	
		  //فیلد دوم
		  //مانده از حواله فروش قبل از تاریخ
          //تبدیل کد استان به آی دی
		 IF($namayesh_info!=2)
	     { 		 
		  $sell_id_ostan=$db->get_from_where("province_id","sell.dm_province","province_code=".$row['code_ostan']."");
		  $havale_forush_befor=0;
          $havale_forush_bef=0;
		  $q_forush_befor=("SELECT h_code,h_mande_havale,h_id_province,h_l_code,h_p_code FROM sell.dm_havale INNER JOIN sell.dm_location_goods ON h_l_code=l_id WHERE $Condition_anbar_activate_sell h_id_year='$sellYearId' AND h_id_province='$sell_id_ostan' AND h_p_code=".$row2['code_kala']." AND h_reg_date>='$mtStartDateMi' AND h_reg_date<'$date1_milady' and($Condition_anbar_sell)");
		  $res_forush_befor=$db->query($q_forush_befor);
		  while($row_forush_befor=$db->fetch_array($res_forush_befor))//به ازای هر حواله میخواهیم مقدار اولیه حواله فروش را درآوریم
		  {
		   //پیدا کردن کد استان از روی آی دی
            $code_ostan_forhavale=$db->get_from_where("province_code","sell.dm_province","province_id=".$row_forush_befor['h_id_province']."");
           //پیدا کردن کد انباراز روی آی دی
            $code_anbar_forhavale=$db->get_from_where("l_code","sell.dm_location_goods","l_id_province=".$row_forush_befor['h_id_province']." AND l_id=".$row_forush_befor['h_l_code']."");  
			/**///محاسبه کل تحویلی برای این حواله
			$meghdar_tahvily_per1=$db->get_from_where("SUM($havaleField)","meat.havale_detail","h_code=".$row_forush_befor['h_code']." AND code_ostan=$code_ostan_forhavale AND code_anbar=$code_anbar_forhavale AND year=$mtActiveYear AND havale_deleted=0 AND status=0");
			/**///محاسبه کل باطله برای این حواله
			$meghdar_batele_per1=$db->get_from_where("SUM(his_eb_amount)","sell.dm_his_havale INNER JOIN sell.dm_havale ON dm_his_havale.his_h_id=dm_havale.h_id","his_h_code=".$row_forush_befor['h_code']." AND h_id_province=".$row_forush_befor['h_id_province']." AND h_l_code=".$row_forush_befor['h_l_code']." AND h_id_year='$sellYearId'");
	        $havale_forush_bef=$row_forush_befor['h_mande_havale']+$meghdar_tahvily_per1+$meghdar_batele_per1;//مقدار اولیه هر حواله فروش
			 /**///محاسبه مقدار مانده از حواله فروش
 	        //مقدار کل ابطالی ها قبل از تاریخ
	        $q_ebtal_befor_dakheli="SELECT SUM(his_eb_amount) FROM sell.dm_his_havale 
	                INNER JOIN sell.dm_havale ON sell.dm_his_havale.his_h_id=dm_havale.h_id
	                INNER JOIN sell.dm_ebtal_h ON sell.dm_his_havale.his_id=dm_ebtal_h.ebh_h_id
	                INNER JOIN sell.dm_location_goods ON h_l_code=l_id 
					WHERE $Condition_anbar_activate_sell his_p_code=".$row_forush_befor['h_p_code']." AND his_h_code=".$row_forush_befor['h_code']." AND h_id_province=".$row_forush_befor['h_id_province']." AND h_l_code=".$row_forush_befor['h_l_code']." AND h_id_year='$sellYearId' AND h_reg_date>='$mtStartDateMi' AND ebh_reg_date<'$date1_milady'"; 
	        $res_ebtal_befor_dakheli=$db->query($q_ebtal_befor_dakheli);
	        $meghdar_ebtali_befor=$db->fetch_array($res_ebtal_befor_dakheli);	        
	        //حواله جنسی قبل از تاریخ		
	        $sadere_befor=$db->get_from_where("SUM($havaleField)","meat.havale_detail as T INNER JOIN meat.havale as h ON h.shomare_havale_anbar=T.shomare_havale_anbar AND h.code_ostan=T.code_ostan AND h.code_anbar=T.code_anbar AND h.year=T.year","h.h_code=".$row_forush_befor['h_code']." AND T.code_ostan='$code_ostan_forhavale' AND T.code_anbar='$code_anbar_forhavale' AND T.year='$mtActiveYear' AND T.havale_deleted=0 AND T.status=0 AND h.tarikh_havale_anbar<'$date1'");
			//محاسبه مقدار حواله فروش قبل از تاریخ
		    $havale_forush_befor_per=$havale_forush_bef-$sadere_befor-$meghdar_ebtali_befor[0];
			$havale_forush_befor+=$havale_forush_befor_per;
		  }
		 }
		  //فیلد سوم
		  //مانده از مجوز جابه جایی قبل از تاریخ		 
		   // $jabejae_befor=0;
		   // $jabejae_befor_per=0;
		   // // $q_jabejae1=("SELECT shomare_jabejae,meghdar_jabejae,code_kala,T.code_ostan,T.code_anbar FROM meat.mojavez_jabejae T 
		                 // // INNER JOIN meat.list_sardkhane ON list_sardkhane.code_ostan=T.code_ostan AND list_sardkhane.code_anbar=T.code_anbar
						 // // INNER JOIN meat.list_sardkhane l_s ON l_s.code_anbar=T.code_anbar_maghsad_j AND l_s.code_ostan=T.code_ostan_maghsad_j
						 // // WHERE $Condition_movaghat $Condition_movaghat_mj T.code_kala=".$row2['code_kala']." AND T.code_ostan=".$row['code_ostan']." AND year='$mtActiveYear' AND T.deleted=0 AND tarikh_jabejae<'$date1' AND($Condition_anbar)");
		   // $q_jabejae1=("SELECT shomare_jabejae,meghdar_jabejae,code_kala,T.code_ostan,T.code_anbar FROM meat.mojavez_jabejae T 
		                 // INNER JOIN meat.list_sardkhane ON list_sardkhane.code_ostan=T.code_ostan AND list_sardkhane.code_anbar=T.code_anbar
						 // WHERE $Condition_movaghat T.code_kala=".$row2['code_kala']." AND T.code_ostan=".$row['code_ostan']." AND year='$mtActiveYear' AND T.deleted=0 AND tarikh_jabejae<'$date1' AND($Condition_anbar)");
		   // $res_jabejae1=$db->query($q_jabejae1);
		   // while($row_jabejae1=$db->fetch_array($res_jabejae1))//به ازای هر حواله میخواهیم مقدار اولیه محوز را در می آوریم
		   // {
			 // //مقدار کل ابطالی هل قبل از تاریخ
		     // $q_ebtal_j_befor="SELECT SUM(meghdar_batele_j) FROM meat.ebtal_jabejae INNER JOIN meat.mojavez_jabejae ON ebtal_jabejae.shomare_jabejae=mojavez_jabejae.shomare_jabejae AND ebtal_jabejae.code_ostan=mojavez_jabejae.code_ostan AND ebtal_jabejae.code_anbar=mojavez_jabejae.code_anbar AND ebtal_jabejae.year=mojavez_jabejae.year
	                           // WHERE ebtal_jabejae.shomare_jabejae='".$row_jabejae1['shomare_jabejae']."' AND ebtal_jabejae.code_ostan=".$row_jabejae1['code_ostan']." AND ebtal_jabejae.code_anbar='".$row_jabejae1['code_anbar']."' AND ebtal_jabejae.year='$mtActiveYear' AND mojavez_jabejae.deleted=0 AND ebtal_jabejae.deleted=0 AND ebtal_jabejae.tarikh_barge_ebtal_j<'$date1'";    
		     // $res_ebtal_j_befor=$db->query($q_ebtal_j_befor);
	         // $meghdar_ebtali_j_befor=$db->fetch_array($res_ebtal_j_befor);
			// //حواله جنسی قبل از تاریخ
			  // if($codeBastebandy==2)$sadere_befor_j=$db->get_from_where("SUM(tedad_karton_h_d)","meat.havale_detail as T INNER JOIN meat.havale as h ON h.shomare_havale_anbar=T.shomare_havale_anbar AND h.code_ostan=T.code_ostan AND h.code_anbar=T.code_anbar AND h.year=T.year","T.shomare_jabejae='".$row_jabejae1['shomare_jabejae']."' AND T.code_ostan=".$row_jabejae1['code_ostan']." AND T.code_anbar=".$row_jabejae1['code_anbar']." AND T.year='$mtActiveYear' AND T.havale_deleted=0 AND T.status=0 AND h.tarikh_havale_anbar<'$date1'");
			  // else $sadere_befor_j=$db->get_from_where("SUM(vazn_khales_h_d)","meat.havale_detail as T INNER JOIN meat.havale as h ON h.shomare_havale_anbar=T.shomare_havale_anbar AND h.code_ostan=T.code_ostan AND h.code_anbar=T.code_anbar AND h.year=T.year","T.shomare_jabejae='".$row_jabejae1['shomare_jabejae']."' AND T.code_ostan=".$row_jabejae1['code_ostan']." AND T.code_anbar=".$row_jabejae1['code_anbar']." AND T.year='$mtActiveYear' AND T.havale_deleted=0 AND T.status=0 AND h.tarikh_havale_anbar<'$date1'");
			// //محاسبه مقدار محوز قبل از تاریخ
		     // $jabejae_befor_per=$row_jabejae1['meghdar_jabejae']-$sadere_befor_j-$meghdar_ebtali_j_befor[0];
			 // $jabejae_befor+=$jabejae_befor_per;
		   // }
		   
		   $jabejae_befor_maghsad_movaghat=0;
		   $jabejae_befor_per1=0;
		   $q_jabejae1=("SELECT shomare_jabejae,meghdar_jabejae,code_kala,T.code_ostan,T.code_anbar FROM meat.mojavez_jabejae T 
		                 INNER JOIN meat.list_sardkhane ON list_sardkhane.code_ostan=T.code_ostan AND list_sardkhane.code_anbar=T.code_anbar
                         INNER JOIN meat.list_sardkhane l_s ON l_s.code_anbar=T.code_anbar_maghsad_j AND l_s.code_ostan=T.code_ostan_maghsad_j
						 WHERE $Condition_anbar_activate $Condition_anbar_activate_mj $Condition_movaghat l_s.situation_type=2 AND T.code_kala=".$row2['code_kala']." AND T.code_ostan=".$row['code_ostan']." AND year='$mtActiveYear' AND T.deleted=0 AND tarikh_jabejae<'$date1' AND($Condition_anbar) $Condition_info_mojavez");
		   $res_jabejae1=$db->query($q_jabejae1);
		   while($row_jabejae1=$db->fetch_array($res_jabejae1))//به ازای هر حواله میخواهیم مقدار اولیه محوز را در می آوریم
		   {
			 //مقدار کل ابطالی هل قبل از تاریخ
		     $q_ebtal_j_befor="SELECT SUM(meghdar_batele_j) FROM meat.ebtal_jabejae INNER JOIN meat.mojavez_jabejae ON ebtal_jabejae.shomare_jabejae=mojavez_jabejae.shomare_jabejae AND ebtal_jabejae.code_ostan=mojavez_jabejae.code_ostan AND ebtal_jabejae.code_anbar=mojavez_jabejae.code_anbar AND ebtal_jabejae.year=mojavez_jabejae.year
	                           WHERE ebtal_jabejae.shomare_jabejae='".$row_jabejae1['shomare_jabejae']."' AND ebtal_jabejae.code_ostan=".$row_jabejae1['code_ostan']." AND ebtal_jabejae.code_anbar='".$row_jabejae1['code_anbar']."' AND ebtal_jabejae.year='$mtActiveYear' AND mojavez_jabejae.deleted=0 AND ebtal_jabejae.deleted=0 AND ebtal_jabejae.tarikh_barge_ebtal_j<'$date1' $Condition_info_mojavez ";    
		     $res_ebtal_j_befor=$db->query($q_ebtal_j_befor);
	         $meghdar_ebtali_j_befor=$db->fetch_array($res_ebtal_j_befor);
			//حواله جنسی قبل از تاریخ
			 $sadere_befor_j=$db->get_from_where("SUM($havaleField)","meat.havale_detail as T INNER JOIN meat.havale as h ON h.shomare_havale_anbar=T.shomare_havale_anbar AND h.code_ostan=T.code_ostan AND h.code_anbar=T.code_anbar AND h.year=T.year","T.shomare_jabejae='".$row_jabejae1['shomare_jabejae']."' AND T.code_ostan=".$row_jabejae1['code_ostan']." AND T.code_anbar=".$row_jabejae1['code_anbar']." AND T.year='$mtActiveYear' AND T.havale_deleted=0 AND T.status=0 AND h.tarikh_havale_anbar<'$date1' $Condition_info ");
			//محاسبه مقدار محوز قبل از تاریخ
		     $jabejae_befor_per1=$row_jabejae1['meghdar_jabejae']-$sadere_befor_j-$meghdar_ebtali_j_befor[0];
			 $jabejae_befor_maghsad_movaghat+=$jabejae_befor_per1;
		   }
		   //فیلد چهارم 
		   $jabejae_befor_maghsad_sayer=0;
		   $jabejae_befor_per2=0;
		   $q_jabejae1=("SELECT shomare_jabejae,meghdar_jabejae,code_kala,T.code_ostan,T.code_anbar FROM meat.mojavez_jabejae T 
		                 INNER JOIN meat.list_sardkhane ON list_sardkhane.code_ostan=T.code_ostan AND list_sardkhane.code_anbar=T.code_anbar
						 INNER JOIN meat.list_sardkhane l_s ON l_s.code_anbar=T.code_anbar_maghsad_j AND l_s.code_ostan=T.code_ostan_maghsad_j		
						 WHERE $Condition_anbar_activate $Condition_anbar_activate_mj $Condition_movaghat l_s.situation_type=1 AND T.code_kala=".$row2['code_kala']." AND T.code_ostan=".$row['code_ostan']." AND year='$mtActiveYear' AND T.deleted=0 AND tarikh_jabejae<'$date1' AND($Condition_anbar)  $Condition_info_mojavez");
		   $res_jabejae1=$db->query($q_jabejae1);
		   while($row_jabejae1=$db->fetch_array($res_jabejae1))//به ازای هر حواله میخواهیم مقدار اولیه محوز را در می آوریم
		   {
			 //مقدار کل ابطالی هل قبل از تاریخ
		     $q_ebtal_j_befor="SELECT SUM(meghdar_batele_j) FROM meat.ebtal_jabejae INNER JOIN meat.mojavez_jabejae ON ebtal_jabejae.shomare_jabejae=mojavez_jabejae.shomare_jabejae AND ebtal_jabejae.code_ostan=mojavez_jabejae.code_ostan AND ebtal_jabejae.code_anbar=mojavez_jabejae.code_anbar AND ebtal_jabejae.year=mojavez_jabejae.year
	                           WHERE ebtal_jabejae.shomare_jabejae='".$row_jabejae1['shomare_jabejae']."' AND ebtal_jabejae.code_ostan=".$row_jabejae1['code_ostan']." AND ebtal_jabejae.code_anbar='".$row_jabejae1['code_anbar']."' AND ebtal_jabejae.year='$mtActiveYear' AND mojavez_jabejae.deleted=0 AND ebtal_jabejae.deleted=0 AND ebtal_jabejae.tarikh_barge_ebtal_j<'$date1'  $Condition_info_mojavez";    
		     $res_ebtal_j_befor=$db->query($q_ebtal_j_befor);
	         $meghdar_ebtali_j_befor=$db->fetch_array($res_ebtal_j_befor);
			//حواله جنسی قبل از تاریخ
			 $sadere_befor_j=$db->get_from_where("SUM($havaleField)","meat.havale_detail as T INNER JOIN meat.havale as h ON h.shomare_havale_anbar=T.shomare_havale_anbar AND h.code_ostan=T.code_ostan AND h.code_anbar=T.code_anbar AND h.year=T.year","T.shomare_jabejae='".$row_jabejae1['shomare_jabejae']."' AND T.code_ostan=".$row_jabejae1['code_ostan']." AND T.code_anbar=".$row_jabejae1['code_anbar']." AND T.year='$mtActiveYear' AND T.havale_deleted=0 AND T.status=0 AND h.tarikh_havale_anbar<'$date1' $Condition_info ");
			//محاسبه مقدار محوز قبل از تاریخ
		     $jabejae_befor_per2=$row_jabejae1['meghdar_jabejae']-$sadere_befor_j-$meghdar_ebtali_j_befor[0];
			 $jabejae_befor_maghsad_sayer+=$jabejae_befor_per2;
		   }
		   
		 //رسید جنسی مابین تاریخ ها   		 
		   $varede_between=$db->get_from_where("SUM($residField)","meat.resid_kala_detail T INNER JOIN resid as r ON r.shomare_resid=T.shomare_resid AND r.code_ostan=T.code_ostan AND r.code_anbar=T.code_anbar AND r.year=T.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_anbar_activate $Condition_movaghat T.code_kala=".$row2['code_kala']." AND T.code_ostan=".$row['code_ostan']." AND T.year='$mtActiveYear' AND T.resid_deleted=0 AND T.status=0 AND r.tarikh_resid>='$date1' AND r.tarikh_resid<='$date2' AND($Condition_anbar) $Condition_info"); 
		   
		  //فیلد پنجم
	       IF($namayesh_info!=2) $varede_between_kharid=$db->get_from_where("SUM($residField)","meat.resid_kala_detail T INNER JOIN resid as r ON r.shomare_resid=T.shomare_resid AND r.code_ostan=T.code_ostan AND r.code_anbar=T.code_anbar AND r.year=T.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_anbar_activate $Condition_movaghat T.code_kala=".$row2['code_kala']." AND T.code_ostan=".$row['code_ostan']." AND T.year='$mtActiveYear' AND T.resid_deleted=0 AND T.status=0 AND r.tarikh_resid>='$date1' AND r.tarikh_resid<='$date2' AND (noe_tahvil_bar=1 or noe_tahvil_bar=2 or noe_tahvil_bar=3) AND($Condition_anbar)");		 		  
		  //فیلد ششم 
	       IF($namayesh_info!=2) $varede_between_jabejae=$db->get_from_where("SUM($residField)","meat.resid_kala_detail T INNER JOIN resid as r ON r.shomare_resid=T.shomare_resid AND r.code_ostan=T.code_ostan AND r.code_anbar=T.code_anbar AND r.year=T.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_anbar_activate $Condition_movaghat T.code_kala=".$row2['code_kala']." AND T.code_ostan=".$row['code_ostan']." AND T.year='$mtActiveYear' AND T.resid_deleted=0 AND T.status=0 AND r.tarikh_resid>='$date1' AND r.tarikh_resid<='$date2' AND (noe_tahvil_bar=4 or noe_tahvil_bar=5) AND($Condition_anbar)");
		  //فیلد هفتم 
	       IF($namayesh_info!=2)  $varede_between_bargasht=$db->get_from_where("SUM($residField)","meat.resid_kala_detail T INNER JOIN resid as r ON r.shomare_resid=T.shomare_resid AND r.code_ostan=T.code_ostan AND r.code_anbar=T.code_anbar AND r.year=T.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_anbar_activate $Condition_movaghat T.code_kala=".$row2['code_kala']." AND T.code_ostan=".$row['code_ostan']." AND T.year='$mtActiveYear' AND T.resid_deleted=0 AND T.status=0 AND r.tarikh_resid>='$date1' AND r.tarikh_resid<='$date2' AND (noe_tahvil_bar=6) AND($Condition_anbar)");	  
		  //فیلد هشتم
		  //مقدار تعدیل اضافه مابین تاریخ	      
		   $meghdarTadil_Ezafe=$db->get_from_where("SUM($tadilField)","meat.tadil_mojody T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_anbar_activate $Condition_movaghat code_kala=".$row2['code_kala']." AND noe_tadil=1 AND T.code_ostan=".$row['code_ostan']." AND year='$mtActiveYear' AND status=0 AND deleted=0 AND tarikh_barge_tadil>='$date1' AND tarikh_barge_tadil<='$date2' AND($Condition_anbar)");
		  //فیلد نهم
		  //مقدار کل حواله فروش ها مابین تاریخ
		  IF($namayesh_info!=2)
		  {
		   $havale_forush_bet_per=0;
           $havale_forush_between=0;
		   $q_forush=("SELECT h_code,h_mande_havale,h_id_province,h_l_code,h_p_code FROM sell.dm_havale INNER JOIN sell.dm_location_goods ON h_l_code=l_id WHERE $Condition_anbar_activate_sell h_id_year='$sellYearId' AND h_id_province='$sell_id_ostan' AND h_p_code=".$row2['code_kala']." AND h_reg_date>='$mtStartDateMi' AND h_reg_date>='$date1_milady' AND h_reg_date<='$date2_milady' and($Condition_anbar_sell)");
		   $res_forush=$db->query($q_forush);
		   while($row_forush=$db->fetch_array($res_forush))//به ازای هر حواله میخواهیم مقدار اولیه حواله فروش را درآوریم
		   {
		    //پیدا کردن کد استان از روی آی دی
             $code_ostan_forhavale=$db->get_from_where("province_code","sell.dm_province","province_id=".$row_forush['h_id_province']."");
            //پیدا کردن کد انباراز روی آی دی
             $code_anbar_forhavale=$db->get_from_where("l_code","sell.dm_location_goods","l_id_province=".$row_forush['h_id_province']." AND l_id=".$row_forush['h_l_code']."");  
		    /**///محاسبه کل تحویلی برای این حواله
             $meghdar_tahvily_per2=$db->get_from_where("SUM($havaleField)","meat.havale_detail","h_code=".$row_forush['h_code']." AND code_ostan='$code_ostan_forhavale' AND code_anbar='$code_anbar_forhavale' AND year='$mtActiveYear' AND havale_deleted=0 AND status=0");
		  	/**///محاسبه کل باطله برای این حواله
		  	$meghdar_batele_per2=$db->get_from_where("SUM(his_eb_amount)","sell.dm_his_havale INNER JOIN sell.dm_havale ON dm_his_havale.his_h_id=dm_havale.h_id","his_h_code=".$row_forush['h_code']." AND h_id_province=".$row_forush['h_id_province']." AND h_l_code=".$row_forush['h_l_code']." AND h_id_year='$sellYearId'");
	         $havale_forush_bet_per=$row_forush['h_mande_havale']+$meghdar_tahvily_per2+$meghdar_batele_per2;//مقدار اولیه هر حواله فروش
		  	$havale_forush_between+=$havale_forush_bet_per;
		   }
		  }
          //checkk it
		   //$jabejae_between=$db->get_from_where("SUM(meghdar_jabejae)","meat.mojavez_jabejae T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan INNER JOIN meat.list_sardkhane l_s ON l_s.code_anbar=T.code_anbar_maghsad_j AND l_s.code_ostan=T.code_ostan_maghsad_j","$Condition_anbar_activate $Condition_anbar_activate_mj $Condition_movaghat T.code_kala=".$row2['code_kala']." AND T.code_ostan=".$row['code_ostan']." AND year='$mtActiveYear' AND deleted=0 AND tarikh_jabejae>='$date1' AND tarikh_jabejae<='$date2' AND($Condition_anbar)"); 
		  //فیلد دهم
		  /****مجوز جابه جایی به مقصد موقت****/
		   IF($namayesh_info!=2) $jabejae_between_maghsad_movaghat=$db->get_from_where("SUM(meghdar_jabejae)","meat.mojavez_jabejae T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan INNER JOIN meat.list_sardkhane l_s ON l_s.code_anbar=T.code_anbar_maghsad_j AND l_s.code_ostan=T.code_ostan_maghsad_j","$Condition_anbar_activate $Condition_anbar_activate_mj $Condition_movaghat l_s.situation_type=2 AND T.code_kala=".$row2['code_kala']." AND T.code_ostan=".$row['code_ostan']." AND year='$mtActiveYear' AND deleted=0 AND tarikh_jabejae>='$date1' AND tarikh_jabejae<='$date2' AND($Condition_anbar)"); 
		  //فیلد یازدهم
		  /****مجوز جابه جایی به مقصد بقیه به غیر از موقت****/ 
		   $jabejae_between_maghsad_sayer=$db->get_from_where("SUM(meghdar_jabejae)","meat.mojavez_jabejae T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan INNER JOIN meat.list_sardkhane l_s ON l_s.code_anbar=T.code_anbar_maghsad_j AND l_s.code_ostan=T.code_ostan_maghsad_j","$Condition_anbar_activate $Condition_anbar_activate_mj $Condition_movaghat l_s.situation_type=1 AND T.code_kala=".$row2['code_kala']." AND T.code_ostan=".$row['code_ostan']." AND year='$mtActiveYear' AND deleted=0 AND tarikh_jabejae>='$date1' AND tarikh_jabejae<='$date2' AND($Condition_anbar) $Condition_info_mojavez "); 
           
		  //فیلد دوازدهم
		  //جمع جنسی
		   $jame_jensi=$mande_befor+$varede_between+$meghdarTadil_Ezafe;
		  //فیلد سیزدهم
		  //جمع فروش
	       $jame_forush=$havale_forush_befor+$havale_forush_between;
		  //جمع جابه جایی	
	       //$jame_jabejae=$jabejae_befor+$jabejae_between;
	      //فیلد چهاردهم  
		   $jame_jabejae_maghsad_movaghat=$jabejae_befor_maghsad_movaghat+$jabejae_between_maghsad_movaghat;
	      //فیلد پانزدهم 
		   $jame_jabejae_maghsad_sayer=$jabejae_befor_maghsad_sayer+$jabejae_between_maghsad_sayer;
		  //فیلد شانزدهم 
		  //حواله جنسی مابین تاریخ به غیر از جابه جایی ها
		   IF($namayesh_info!=2) $sadere_between_forush=$db->get_from_where("SUM($havaleField)","meat.havale_detail as T INNER JOIN meat.havale as h ON h.shomare_havale_anbar=T.shomare_havale_anbar AND h.code_ostan=T.code_ostan AND h.code_anbar=T.code_anbar AND h.year=T.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_anbar_activate $Condition_movaghat T.code_kala=".$row2['code_kala']." AND (h.noe_tahvil_bar=1 OR h.noe_tahvil_bar=2 OR h.noe_tahvil_bar=3) AND T.code_ostan=".$row['code_ostan']." AND T.year='$mtActiveYear' AND T.havale_deleted=0 AND T.status=0 AND h.tarikh_havale_anbar>='$date1' AND h.tarikh_havale_anbar<='$date2' AND($Condition_anbar)");

	     //حواله جنسی مابین تاریخ جابه جایی ها 
		   //حواله ها خودشون موقت  نباشند و همچنین مقصد موقت نباشد
		   // if($codeBastebandy==2)
		   // { 
		    // $sadere_between_jabejae=$db->get_from_where("SUM(tedad_karton_h_d)","meat.havale_detail as T INNER JOIN meat.havale as h ON h.shomare_havale_anbar=T.shomare_havale_anbar AND h.code_ostan=T.code_ostan AND h.code_anbar=T.code_anbar AND h.year=T.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan INNER JOIN mojavez_jabejae m_j ON m_j.code_ostan=T.code_ostan AND m_j.code_anbar=T.code_anbar AND m_j.year=T.year AND m_j.shomare_jabejae=T.shomare_jabejae INNER JOIN meat.list_sardkhane l_s ON l_s.code_anbar=m_j.code_anbar_maghsad_j AND l_s.code_ostan=m_j.code_ostan_maghsad_j","$Condition_movaghat $Condition_movaghat_mj T.code_kala=".$row2['code_kala']." AND (h.noe_tahvil_bar=4 OR h.noe_tahvil_bar=5) AND T.code_ostan=".$row['code_ostan']." AND T.year='$mtActiveYear' AND T.havale_deleted=0 AND T.status=0 AND h.tarikh_havale_anbar>='$date1' AND h.tarikh_havale_anbar<='$date2' AND($Condition_anbar)");		 
		    // $sadere_between_jabejae_movaghat=$db->get_from_where("SUM(tedad_karton_h_d)","meat.havale_detail as T INNER JOIN meat.havale as h ON h.shomare_havale_anbar=T.shomare_havale_anbar AND h.code_ostan=T.code_ostan AND h.code_anbar=T.code_anbar AND h.year=T.year INNER JOIN mojavez_jabejae m_j ON m_j.code_ostan=T.code_ostan AND m_j.code_anbar=T.code_anbar AND m_j.year=T.year AND m_j.shomare_jabejae=T.shomare_jabejae INNER JOIN meat.list_sardkhane l_s ON l_s.code_anbar=m_j.code_anbar_maghsad_j AND l_s.code_ostan=m_j.code_ostan_maghsad_j","l_s.situation_type=2 AND T.code_kala=".$row2['code_kala']." AND (h.noe_tahvil_bar=4 OR h.noe_tahvil_bar=5) AND T.code_ostan=".$row['code_ostan']." AND T.year='$mtActiveYear' AND T.havale_deleted=0 AND T.status=0 AND h.tarikh_havale_anbar>='$date1' AND h.tarikh_havale_anbar<='$date2' AND($Condition_anbar)");		 
		   // }
		   // else 
		   // {
		    // $sadere_between_jabejae=$db->get_from_where("SUM(vazn_khales_h_d)","meat.havale_detail as T INNER JOIN meat.havale as h ON h.shomare_havale_anbar=T.shomare_havale_anbar AND h.code_ostan=T.code_ostan AND h.code_anbar=T.code_anbar AND h.year=T.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan  INNER JOIN mojavez_jabejae m_j ON m_j.code_ostan=T.code_ostan AND m_j.code_anbar=T.code_anbar AND m_j.year=T.year AND m_j.shomare_jabejae=T.shomare_jabejae INNER JOIN meat.list_sardkhane l_s ON l_s.code_anbar=m_j.code_anbar_maghsad_j AND l_s.code_ostan=m_j.code_ostan_maghsad_j","$Condition_movaghat $Condition_movaghat_mj T.code_kala=".$row2['code_kala']." AND (h.noe_tahvil_bar=4 OR h.noe_tahvil_bar=5) AND T.code_ostan=".$row['code_ostan']." AND T.year='$mtActiveYear' AND T.havale_deleted=0 AND T.status=0 AND h.tarikh_havale_anbar>='$date1' AND h.tarikh_havale_anbar<='$date2' AND($Condition_anbar)");		 
		    // $sadere_between_jabejae_movaghat=$db->get_from_where("SUM(vazn_khales_h_d)","meat.havale_detail as T INNER JOIN meat.havale as h ON h.shomare_havale_anbar=T.shomare_havale_anbar AND h.code_ostan=T.code_ostan AND h.code_anbar=T.code_anbar AND h.year=T.year INNER JOIN mojavez_jabejae m_j ON m_j.code_ostan=T.code_ostan AND m_j.code_anbar=T.code_anbar AND m_j.year=T.year AND m_j.shomare_jabejae=T.shomare_jabejae INNER JOIN meat.list_sardkhane l_s ON l_s.code_anbar=m_j.code_anbar_maghsad_j AND l_s.code_ostan=m_j.code_ostan_maghsad_j","l_s.situation_type=2 AND T.code_kala=".$row2['code_kala']." AND (h.noe_tahvil_bar=4 OR h.noe_tahvil_bar=5) AND T.code_ostan=".$row['code_ostan']." AND T.year='$mtActiveYear' AND T.havale_deleted=0 AND T.status=0 AND h.tarikh_havale_anbar>='$date1' AND h.tarikh_havale_anbar<='$date2' AND($Condition_anbar)");
           // }
		  $sadere_between_jabejae=$db->get_from_where("SUM($havaleField)","meat.havale_detail as T INNER JOIN meat.havale as h ON h.shomare_havale_anbar=T.shomare_havale_anbar AND h.code_ostan=T.code_ostan AND h.code_anbar=T.code_anbar AND h.year=T.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan INNER JOIN mojavez_jabejae m_j ON m_j.code_ostan=h.code_ostan AND m_j.code_anbar=h.code_anbar AND m_j.year=h.year AND m_j.shomare_jabejae=h.shomare_jabejae INNER JOIN meat.list_sardkhane l_s ON l_s.code_anbar=m_j.code_anbar_maghsad_j AND l_s.code_ostan=m_j.code_ostan_maghsad_j","$Condition_anbar_activate $Condition_anbar_activate_mj $Condition_movaghat T.code_kala=".$row2['code_kala']." AND (h.noe_tahvil_bar=4 OR h.noe_tahvil_bar=5) AND T.code_ostan=".$row['code_ostan']." AND T.year='$mtActiveYear' AND T.havale_deleted=0 AND T.status=0 AND h.tarikh_havale_anbar>='$date1' AND h.tarikh_havale_anbar<='$date2' AND($Condition_anbar) $Condition_info");
		 //فیلد هفدهم
		  IF($namayesh_info!=2) $sadere_between_jabejae_maghsad_movaghat=$db->get_from_where("SUM($havaleField)","meat.havale_detail as T INNER JOIN meat.havale as h ON h.shomare_havale_anbar=T.shomare_havale_anbar AND h.code_ostan=T.code_ostan AND h.code_anbar=T.code_anbar AND h.year=T.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan INNER JOIN mojavez_jabejae m_j ON m_j.code_ostan=h.code_ostan AND m_j.code_anbar=h.code_anbar AND m_j.year=h.year AND m_j.shomare_jabejae=h.shomare_jabejae INNER JOIN meat.list_sardkhane l_s ON l_s.code_anbar=m_j.code_anbar_maghsad_j AND l_s.code_ostan=m_j.code_ostan_maghsad_j","$Condition_anbar_activate $Condition_anbar_activate_mj $Condition_movaghat l_s.situation_type=2 AND T.code_kala=".$row2['code_kala']." AND (h.noe_tahvil_bar=4 OR h.noe_tahvil_bar=5) AND T.code_ostan=".$row['code_ostan']." AND T.year='$mtActiveYear' AND T.havale_deleted=0 AND T.status=0 AND h.tarikh_havale_anbar>='$date1' AND h.tarikh_havale_anbar<='$date2' AND($Condition_anbar)");
		 //فیلد هجدهم 
		  $sadere_between_jabejae_maghsad_sayer=$db->get_from_where("SUM($havaleField)","meat.havale_detail as T INNER JOIN meat.havale as h ON h.shomare_havale_anbar=T.shomare_havale_anbar AND h.code_ostan=T.code_ostan AND h.code_anbar=T.code_anbar AND h.year=T.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan INNER JOIN mojavez_jabejae m_j ON m_j.code_ostan=h.code_ostan AND m_j.code_anbar=h.code_anbar AND m_j.year=h.year AND m_j.shomare_jabejae=h.shomare_jabejae INNER JOIN meat.list_sardkhane l_s ON l_s.code_anbar=m_j.code_anbar_maghsad_j AND l_s.code_ostan=m_j.code_ostan_maghsad_j","$Condition_anbar_activate $Condition_anbar_activate_mj $Condition_movaghat l_s.situation_type=1 AND T.code_kala=".$row2['code_kala']." AND (h.noe_tahvil_bar=4 OR h.noe_tahvil_bar=5) AND T.code_ostan=".$row['code_ostan']." AND T.year='$mtActiveYear' AND T.havale_deleted=0 AND T.status=0 AND h.tarikh_havale_anbar>='$date1' AND h.tarikh_havale_anbar<='$date2' AND($Condition_anbar) $Condition_info");  
		 //فیلد نوزدهم 
		 //مقدار تعدیل کسری مابین تاریخ	      
           $meghdarTadil_Kasry=$db->get_from_where("SUM($tadilField)","meat.tadil_mojody T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_anbar_activate  $Condition_movaghat code_kala=".$row2['code_kala']." AND noe_tadil=2 AND T.code_ostan=".$row['code_ostan']." AND year='$mtActiveYear' AND status=0 AND deleted=0 AND tarikh_barge_tadil>='$date1' AND tarikh_barge_tadil<='$date2' AND($Condition_anbar) $Condition_info ");	 
		 //فیلد بیستم 
		  //مقدار کل ابطالی های حواله فروش مابین تاریخ
		   IF($namayesh_info!=2)
		   {
		    $q_ebtal="SELECT SUM(his_eb_amount) FROM sell.dm_his_havale 
	            INNER JOIN sell.dm_havale ON dm_his_havale.his_h_id=dm_havale.h_id
	            INNER JOIN sell.dm_ebtal_h ON dm_his_havale.his_id=dm_ebtal_h.ebh_h_id
	            INNER JOIN sell.dm_location_goods ON h_l_code=l_id 
				WHERE $Condition_anbar_activate_sell his_p_code=".$row2['code_kala']." AND h_id_province='$sell_id_ostan' AND dm_ebtal_h.ebh_reg_date>='$mtStartDateMi' AND dm_havale.h_reg_date>='$mtStartDateMi' AND h_id_year='$sellYearId' AND ebh_reg_date>='$date1_milady' AND ebh_reg_date<='$date2_milady' AND($Condition_anbar_sell)";
		    $res_ebtal=$db->query($q_ebtal);
	        $meghdar_ebtali=$db->fetch_array($res_ebtal);	
		   } 
		  //مقدار ابطالی مجوز جابه جایی
		   // $q_ebtal_j="SELECT SUM(meghdar_batele_j) FROM meat.ebtal_jabejae e_j 
		               // INNER JOIN meat.mojavez_jabejae m_j ON e_j.shomare_jabejae=m_j.shomare_jabejae AND e_j.code_ostan=m_j.code_ostan AND e_j.code_anbar=m_j.code_anbar AND e_j.year=m_j.year
	                   // INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=e_j.code_anbar AND list_sardkhane.code_ostan=e_j.code_ostan
					   // WHERE $Condition_movaghat code_kala=".$row2['code_kala']." AND e_j.code_ostan=".$row['code_ostan']." AND e_j.year='$mtActiveYear' AND e_j.deleted=0 AND m_j.deleted=0 AND e_j.tarikh_barge_ebtal_j>='$date1' AND e_j.tarikh_barge_ebtal_j<='$date2' AND($Condition_anbar_ebtal_j)";    
		   //$meghdar_ebtali_j=$db->get_from_where("SUM(meghdar_batele_j)","meat.ebtal_jabejae e_j INNER JOIN meat.mojavez_jabejae m_j ON e_j.shomare_jabejae=m_j.shomare_jabejae AND e_j.code_ostan=m_j.code_ostan AND e_j.code_anbar=m_j.code_anbar AND e_j.year=m_j.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=e_j.code_anbar AND list_sardkhane.code_ostan=e_j.code_ostan INNER JOIN meat.list_sardkhane l_s ON l_s.code_anbar=m_j.code_anbar_maghsad_j AND l_s.code_ostan=m_j.code_ostan_maghsad_j","$Condition_anbar_activate $Condition_anbar_activate_mj $Condition_movaghat code_kala=".$row2['code_kala']." AND e_j.code_ostan=".$row['code_ostan']." AND e_j.year='$mtActiveYear' AND e_j.deleted=0 AND m_j.deleted=0 AND e_j.tarikh_barge_ebtal_j>='$date1' AND e_j.tarikh_barge_ebtal_j<='$date2' AND($Condition_anbar_ebtal_j)");
		   //فیلد بیست و یک 
		   IF($namayesh_info!=2)$meghdar_ebtali_j_maghsad_movaghat=$db->get_from_where("SUM(meghdar_batele_j)","meat.ebtal_jabejae e_j INNER JOIN meat.mojavez_jabejae m_j ON e_j.shomare_jabejae=m_j.shomare_jabejae AND e_j.code_ostan=m_j.code_ostan AND e_j.code_anbar=m_j.code_anbar AND e_j.year=m_j.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=e_j.code_anbar AND list_sardkhane.code_ostan=e_j.code_ostan INNER JOIN meat.list_sardkhane l_s ON l_s.code_anbar=m_j.code_anbar_maghsad_j AND l_s.code_ostan=m_j.code_ostan_maghsad_j","$Condition_anbar_activate $Condition_anbar_activate_mj $Condition_movaghat l_s.situation_type=2 AND code_kala=".$row2['code_kala']." AND e_j.code_ostan=".$row['code_ostan']." AND e_j.year='$mtActiveYear' AND e_j.deleted=0 AND m_j.deleted=0 AND e_j.tarikh_barge_ebtal_j>='$date1' AND e_j.tarikh_barge_ebtal_j<='$date2' AND($Condition_anbar_ebtal_j)");
		   //فیلد بیست و دو 
		   $meghdar_ebtali_j_maghsad_sayer=$db->get_from_where("SUM(meghdar_batele_j)","meat.ebtal_jabejae e_j INNER JOIN meat.mojavez_jabejae m_j ON e_j.shomare_jabejae=m_j.shomare_jabejae AND e_j.code_ostan=m_j.code_ostan AND e_j.code_anbar=m_j.code_anbar AND e_j.year=m_j.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=e_j.code_anbar AND list_sardkhane.code_ostan=e_j.code_ostan INNER JOIN meat.list_sardkhane l_s ON l_s.code_anbar=m_j.code_anbar_maghsad_j AND l_s.code_ostan=m_j.code_ostan_maghsad_j","$Condition_anbar_activate $Condition_anbar_activate_mj $Condition_movaghat l_s.situation_type=1 AND code_kala=".$row2['code_kala']." AND e_j.code_ostan=".$row['code_ostan']." AND e_j.year='$mtActiveYear' AND e_j.deleted=0 AND m_j.deleted=0 AND e_j.tarikh_barge_ebtal_j>='$date1' AND e_j.tarikh_barge_ebtal_j<='$date2' AND($Condition_anbar_ebtal_j) $Condition_info_mojavez");

	      //فیلد بیست و سه
		  //نهایی جنسی 
		   $nahayi_jensi=$jame_jensi-$sadere_between_forush-$sadere_between_jabejae-$meghdarTadil_Kasry;
	       //$nahayi_jensi_ba_movaghat=$jame_jensi-$sadere_between_forush-$sadere_between_jabejae-$meghdarTadil_Kasry;
		  ///فیلد نوزدهم 
		   //$nahayi_jensi_bedone_movaghat=$jame_jensi-$sadere_between_forush-$sadere_between_jabejae-$meghdarTadil_Kasry-$sadere_between_jabejae_movaghat;
	      
		  //فیلد بیست وچهار
		  //نهایی فروش
	       $nahayi_forush=$jame_forush-$sadere_between_forush-$meghdar_ebtali[0];
		  //$nahayi_jabejae=$jame_jabejae-$sadere_between_jabejae-$meghdar_ebtali_j;
		  //فیلد بیست وپنج
		   $nahayi_jabejae_maghsad_movaghat=$jame_jabejae_maghsad_movaghat-$sadere_between_jabejae_maghsad_movaghat-$meghdar_ebtali_j_maghsad_movaghat;
		  //فیلد بیست وشش 
		   $nahayi_jabejae_maghsad_sayer=$jame_jabejae_maghsad_sayer-$sadere_between_jabejae_maghsad_sayer-$meghdar_ebtali_j_maghsad_sayer;
		   $nahayi_jabejae=$nahayi_jabejae_maghsad_movaghat+$nahayi_jabejae_maghsad_sayer;
		  //فیلد بیست و هفت  
		   //$mande_pasazkasr=$nahayi_jensi-abs($nahayi_forush)-abs($nahayi_jabejae);
		   //if($mande_pasazkasr<0)$mande_pasazkasr=0;
           $mande_pasazkasr_forush=$nahayi_jensi-$nahayi_forush;  
		  //فیلد بیست و هشت
		   $mande_pasazkasr=$nahayi_jensi-$nahayi_forush-$nahayi_jabejae;
            echo'
	        <td>'.round($mande_befor,3).'</td>
	        <td>'.round($havale_forush_befor,3).'</td>
	        <td>'.round($jabejae_befor_maghsad_movaghat,3).'</td>
	        <td>'.round($jabejae_befor_maghsad_sayer,3).'</td>
	        <td>'.round($varede_between_kharid,3).'</td>
	        <td>'.round($varede_between_jabejae,3).'</td>
	        <td>'.round($varede_between_bargasht,3).'</td>
	        <td>'.round($meghdarTadil_Ezafe,3).'</td>
	        <td>'.round($havale_forush_between,3).'</td>
	        <td>'.round($jabejae_between_maghsad_movaghat,3).'</td>
	        <td>'.round($jabejae_between_maghsad_sayer,3).'</td>
	        <td>'.round($jame_jensi,3).'</td>
	        <td>'.round($jame_forush,3).'</td>
	        <td>'.round($jame_jabejae_maghsad_movaghat,3).'</td>
	        <td>'.round($jame_jabejae_maghsad_sayer,3).'</td>
	        <td>'.round($sadere_between_forush,3).'</td>
	        <td>'.round($sadere_between_jabejae_maghsad_movaghat,3).'</td>
	        <td>'.round($sadere_between_jabejae_maghsad_sayer,3).'</td>
	        <td>'.round($meghdarTadil_Kasry,3).'</td>
	        <td>'.round($meghdar_ebtali[0],3).'</td>
	        <td>'.round($meghdar_ebtali_j_maghsad_movaghat,3).'</td>
	        <td>'.round($meghdar_ebtali_j_maghsad_sayer,3).'</td>
	        <td>'.round($nahayi_jensi,3).'</td>
		    <!--<td>'.round($nahayi_jensi_ba_movaghat,3).'</td><td>'.round($nahayi_jensi_bedone_movaghat,3).'</td>-->
	        <td>'.round($nahayi_forush,3).'</td>
	        <td>'.round($nahayi_jabejae_maghsad_movaghat,3).'</td>
	        <td>'.round($nahayi_jabejae_maghsad_sayer,3).'</td>
	        <td>'.round($mande_pasazkasr_forush,3).'</td>   
	        <td>'.round($mande_pasazkasr,3).'</td>';   
	   		  $t--;
			  if($t==0) echo'';
			  else 
			  {
			   echo'</tr>';
			   if($j++%2)echo'<tr class="print_table-odd_small">';
               else echo'<tr class="print_table-even_small">';
			  }
	      /****************محاسبه مجموع مقادیر در سطر آخر قوطی*******************/
	      IF(($codeBastebandy==2)OR($codeBastebandy==6))//قوطی یا عدد
          {	  
	       $sum_mande_befor_ghoti+=$mande_befor;
	       $sum_havale_forush_befor_ghoti+=$havale_forush_befor;
	       //$sum_jabejae_befor_ghoti+=$jabejae_befor;
	       $sum_jabejae_befor_ghoti_maghsad_movaghat+=$jabejae_befor_maghsad_movaghat;
	       $sum_jabejae_befor_ghoti_maghsad_sayer+=$jabejae_befor_maghsad_sayer;
		   $sum_varede_between_kharid_ghoti+=$varede_between_kharid;
	       $sum_varede_between_jabejae_ghoti+=$varede_between_jabejae;
	       $sum_varede_between_bargasht_ghoti+=$varede_between_bargasht;
		   //$sum_varede_between_ghoti+=$varede_between;
		   $sum_havale_forush_between_ghoti+=$havale_forush_between;
	       //$sum_jabejae_between_ghoti+=$jabejae_between;
	       $sum_jabejae_between_ghoti_maghsad_movaghat+=$jabejae_between_maghsad_movaghat;
	       $sum_jabejae_between_ghoti_maghsad_sayer+=$jabejae_between_maghsad_sayer;
	       $sum_meghdarTadil_Ezafe_ghoti+=$meghdarTadil_Ezafe;
	       $sum_jame_jensi_ghoti+=$jame_jensi;
	       $sum_jame_forush_ghoti+=$jame_forush;
	       //$sum_jame_jabejae_ghoti+=$jame_jabejae;
	       $sum_jame_jabejae_ghoti_maghsad_movaghat+=$jame_jabejae_maghsad_movaghat;
	       $sum_jame_jabejae_ghoti_maghsad_sayer+=$jame_jabejae_maghsad_sayer;
	       $sum_sadere_between_forush_ghoti+=$sadere_between_forush;
	       //$sum_sadere_between_jabejae_ghoti+=$sadere_between_jabejae;
	       $sum_sadere_between_jabejae_ghoti_maghsad_movaghat+=$sadere_between_jabejae_maghsad_movaghat;
	       $sum_sadere_between_jabejae_ghoti_maghsad_sayer+=$sadere_between_jabejae_maghsad_sayer;
	       $sum_meghdarTadil_Kasry_ghoti+=$meghdarTadil_Kasry;
	       $sum_ebtaly_forush_ghoti+=$meghdar_ebtali[0];
	       //$sum_ebtaly_jabejae_ghoti+=$meghdar_ebtali_j;
	       $sum_ebtaly_jabejae_ghoti_maghsad_movaghat+=$meghdar_ebtali_j_maghsad_movaghat;
	       $sum_ebtaly_jabejae_ghoti_maghsad_sayer+=$meghdar_ebtali_j_maghsad_sayer;
	       $sum_nahayi_jensi_ghoti+=$nahayi_jensi;
	       $sum_nahayi_forushi_ghoti+=$nahayi_forush;
	       //$sum_nahayi_jabejaei_ghoti+=$nahayi_jabejae;
	       $sum_nahayi_jabejaei_ghoti_maghsad_movaghat+=$nahayi_jabejae_maghsad_movaghat;
	       $sum_nahayi_jabejaei_ghoti_maghsad_sayer+=$nahayi_jabejae_maghsad_sayer;
	       $sum_mande_pasazkasri_forush_ghoti+=$mande_pasazkasr_forush;
	       $sum_mande_pasazkasri_ghoti+=$mande_pasazkasr;
	      }
		  /****************محاسبه مجموع مقادیر در سطر آخر شانه تخم مرغ*******************/
	      if(($row2['code_kala']==50)OR($row2['code_kala']==54))//شانه تخم مرغ
          {	  
	       $sum_mande_befor_shane+=$mande_befor;
	       $sum_havale_forush_befor_shane+=$havale_forush_befor;
	       $sum_jabejae_befor_shane_maghsad_movaghat+=$jabejae_befor_maghsad_movaghat;
	       $sum_jabejae_befor_shane_maghsad_sayer+=$jabejae_befor_maghsad_sayer;
		   $sum_varede_between_kharid_shane+=$varede_between_kharid;
	       $sum_varede_between_jabejae_shane+=$varede_between_jabejae;
	       $sum_varede_between_bargasht_shane+=$varede_between_bargasht;
		   $sum_havale_forush_between_shane+=$havale_forush_between;
	       $sum_jabejae_between_shane_maghsad_movaghat+=$jabejae_between_maghsad_movaghat;
	       $sum_jabejae_between_shane_maghsad_sayer+=$jabejae_between_maghsad_sayer;
	       $sum_meghdarTadil_Ezafe_shane+=$meghdarTadil_Ezafe;
	       $sum_jame_jensi_shane+=$jame_jensi;
	       $sum_jame_forush_shane+=$jame_forush;
	       $sum_jame_jabejae_shane_maghsad_movaghat+=$jame_jabejae_maghsad_movaghat;
	       $sum_jame_jabejae_shane_maghsad_sayer+=$jame_jabejae_maghsad_sayer;
	       $sum_sadere_between_forush_shane+=$sadere_between_forush;
	       $sum_sadere_between_jabejae_shane_maghsad_movaghat+=$sadere_between_jabejae_maghsad_movaghat;
	       $sum_sadere_between_jabejae_shane_maghsad_sayer+=$sadere_between_jabejae_maghsad_sayer;
	       $sum_meghdarTadil_Kasry_shane+=$meghdarTadil_Kasry;
	       $sum_ebtaly_forush_shane+=$meghdar_ebtali[0];
	       $sum_ebtaly_jabejae_shane_maghsad_movaghat+=$meghdar_ebtali_j_maghsad_movaghat;
	       $sum_ebtaly_jabejae_shane_maghsad_sayer+=$meghdar_ebtali_j_maghsad_sayer;
	       $sum_nahayi_jensi_shane+=$nahayi_jensi;
	       $sum_nahayi_forushi_shane+=$nahayi_forush;
	       $sum_nahayi_jabejaei_shane_maghsad_movaghat+=$nahayi_jabejae_maghsad_movaghat;
	       $sum_nahayi_jabejaei_shane_maghsad_sayer+=$nahayi_jabejae_maghsad_sayer;
	       $sum_mande_pasazkasri_forush_shane+=$mande_pasazkasr_forush;
	       $sum_mande_pasazkasri_shane+=$mande_pasazkasr;
	      }
		  /****************محاسبه مجموع مقادیر در سطر آخر کارتنی یا لاشه*******************/
	      if((($codeBastebandy==1)or($codeBastebandy==3))AND($row2['code_kala']!=50)AND($row2['code_kala']!=54))//کارتن
	      { 
	       $sum_mande_befor_kartoni+=$mande_befor;
	       $sum_havale_forush_befor_kartoni+=$havale_forush_befor;
	       //$sum_jabejae_befor_kartoni+=$jabejae_befor;
	       $sum_jabejae_befor_kartoni_maghsad_movaghat+=$jabejae_befor_maghsad_movaghat;
	       $sum_jabejae_befor_kartoni_maghsad_sayer+=$jabejae_befor_maghsad_sayer;
	       $sum_varede_between_kharid_kartoni+=$varede_between_kharid;
	       $sum_varede_between_jabejae_kartoni+=$varede_between_jabejae;
	       $sum_varede_between_bargasht_kartoni+=$varede_between_bargasht;
		   //$sum_varede_between_kartoni+=$varede_between;
		   $sum_havale_forush_between_kartoni+=$havale_forush_between;
	       //$sum_jabejae_between_kartoni+=$jabejae_between;
	       $sum_jabejae_between_kartoni_maghsad_movaghat+=$jabejae_between_maghsad_movaghat;
	       $sum_jabejae_between_kartoni_maghsad_sayer+=$jabejae_between_maghsad_sayer;
	       $sum_meghdarTadil_Ezafe_kartoni+=$meghdarTadil_Ezafe;
	       $sum_jame_jensi_kartoni+=$jame_jensi;
	       $sum_jame_forush_kartoni+=$jame_forush;
	       //$sum_jame_jabejae_kartoni+=$jame_jabejae;
	       $sum_jame_jabejae_kartoni_maghsad_movaghat+=$jame_jabejae_maghsad_movaghat;
	       $sum_jame_jabejae_kartoni_maghsad_sayer+=$jame_jabejae_maghsad_sayer;
	       $sum_sadere_between_forush_kartoni+=$sadere_between_forush;
	       //$sum_sadere_between_jabejae_kartoni+=$sadere_between_jabejae;
	       $sum_sadere_between_jabejae_kartoni_maghsad_movaghat+=$sadere_between_jabejae_maghsad_movaghat;
	       $sum_sadere_between_jabejae_kartoni_maghsad_sayer+=$sadere_between_jabejae_maghsad_sayer;
	       $sum_meghdarTadil_Kasry_kartoni+=$meghdarTadil_Kasry;
	       $sum_ebtaly_forush_kartoni+=$meghdar_ebtali[0];
	       //$sum_ebtaly_jabejae_kartoni+=$meghdar_ebtali_j;
	       $sum_ebtaly_jabejae_kartoni_maghsad_movaghat+=$meghdar_ebtali_j_maghsad_movaghat;
	       $sum_ebtaly_jabejae_kartoni_maghsad_sayer+=$meghdar_ebtali_j_maghsad_sayer;
	       $sum_nahayi_jensi_kartoni+=$nahayi_jensi;
	       $sum_nahayi_forushi_kartoni+=$nahayi_forush;
	       //$sum_nahayi_jabejaei_kartoni+=$nahayi_jabejae;
	       $sum_nahayi_jabejaei_kartoni_maghsad_movaghat+=$nahayi_jabejae_maghsad_movaghat;
	       $sum_nahayi_jabejaei_kartoni_maghsad_sayer+=$nahayi_jabejae_maghsad_sayer;
	       $sum_mande_pasazkasri_forush_kartoni+=$mande_pasazkasr_forush;
	       $sum_mande_pasazkasri_kartoni+=$mande_pasazkasr;
	      }
			  	  
	   }//END while kala
	  echo'
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
	}//END ostan while
    echo'
	  <tr class="print_table-even sum-row-white-b">
	   <td colspan="5">جمع خالص (کارتنی ها یا لاشه)</td>
	   <td>'.round($sum_mande_befor_kartoni,3).'</td>
	   <td>'.round($sum_havale_forush_befor_kartoni,3).'</td>
	   <td>'.round($sum_jabejae_befor_kartoni_maghsad_movaghat,3).'</td>
	   <td>'.round($sum_jabejae_befor_kartoni_maghsad_sayer,3).'</td>
	   <td>'.round($sum_varede_between_kharid_kartoni,3).'</td>
	   <td>'.round($sum_varede_between_jabejae_kartoni,3).'</td>
	   <td>'.round($sum_varede_between_bargasht_kartoni,3).'</td>
	   <td>'.round($sum_meghdarTadil_Ezafe_kartoni,3).'</td>
	   <td>'.round($sum_havale_forush_between_kartoni,3).'</td>
	   <td>'.round($sum_jabejae_between_kartoni_maghsad_movaghat,3).'</td>
	   <td>'.round($sum_jabejae_between_kartoni_maghsad_sayer,3).'</td>
	   <td>'.round($sum_jame_jensi_kartoni,3).'</td>
	   <td>'.round($sum_jame_forush_kartoni,3).'</td>
	   <td>'.round($sum_jame_jabejae_kartoni_maghsad_movaghat,3).'</td>
	   <td>'.round($sum_jame_jabejae_kartoni_maghsad_sayer,3).'</td>
	   <td>'.round($sum_sadere_between_forush_kartoni,3).'</td>
	   <td>'.round($sum_sadere_between_jabejae_kartoni_maghsad_movaghat,3).'</td>
	   <td>'.round($sum_sadere_between_jabejae_kartoni_maghsad_sayer,3).'</td>
	   <td>'.round($sum_meghdarTadil_Kasry_kartoni,3).'</td>
	   <td>'.round($sum_ebtaly_forush_kartoni,3).'</td>
	   <td>'.round($sum_ebtaly_jabejae_kartoni_maghsad_movaghat,3).'</td>
	   <td>'.round($sum_ebtaly_jabejae_kartoni_maghsad_sayer,3).'</td>
	   <td>'.round($sum_nahayi_jensi_kartoni,3).'</td>
	   <td>'.round($sum_nahayi_forushi_kartoni,3).'</td>
	   <td>'.round($sum_nahayi_jabejaei_kartoni_maghsad_movaghat,3).'</td>
	   <td>'.round($sum_nahayi_jabejaei_kartoni_maghsad_sayer,3).'</td>
	   <td>'.round($sum_mande_pasazkasri_forush_kartoni,3).'</td>
	   <td>'.round($sum_mande_pasazkasri_kartoni,3).'</td>
	  </tr>
	  <tr class="print_table-even sum-row-white-b">
	   <td colspan="5">جمع تعداد (قوطی ها)</td>
	   <td>'.$sum_mande_befor_ghoti.'</td>
	   <td>'.round($sum_havale_forush_befor_ghoti,3).'</td>
	   <td>'.round($sum_jabejae_befor_ghoti_maghsad_movaghat,3).'</td>
	   <td>'.round($sum_jabejae_befor_ghoti_maghsad_sayer,3).'</td>
	   <td>'.round($sum_varede_between_kharid_ghoti,3).'</td>
	   <td>'.round($sum_varede_between_jabejae_ghoti,3).'</td>
	   <td>'.round($sum_varede_between_bargasht_ghoti,3).'</td>
	   <td>'.round($sum_meghdarTadil_Ezafe_ghoti,3).'</td>
	   <td>'.round($sum_havale_forush_between_ghoti,3).'</td>
	   <td>'.round($sum_jabejae_between_ghoti_maghsad_movaghat,3).'</td>
	   <td>'.round($sum_jabejae_between_ghoti_maghsad_sayer,3).'</td>
	   <td>'.round($sum_jame_jensi_ghoti,3).'</td>
	   <td>'.round($sum_jame_forush_ghoti,3).'</td>
	   <td>'.round($sum_jame_jabejae_ghoti_maghsad_movaghat,3).'</td>
	   <td>'.round($sum_jame_jabejae_ghoti_maghsad_sayer,3).'</td>
	   <td>'.round($sum_sadere_between_forush_ghoti,3).'</td>
	   <td>'.round($sum_sadere_between_jabejae_ghoti_maghsad_movaghat,3).'</td>
	   <td>'.round($sum_sadere_between_jabejae_ghoti_maghsad_sayer,3).'</td>
	   <td>'.round($sum_meghdarTadil_Kasry_ghoti,3).'</td>
	   <td>'.round($sum_ebtaly_forush_ghoti,3).'</td>
	   <td>'.round($sum_ebtaly_jabejae_ghoti_maghsad_movaghat,3).'</td>
	   <td>'.round($sum_ebtaly_jabejae_ghoti_maghsad_sayer,3).'</td>
	   <td>'.round($sum_nahayi_jensi_ghoti,3).'</td>
	   <td>'.round($sum_nahayi_forushi_ghoti,3).'</td>
	   <td>'.round($sum_nahayi_jabejaei_ghoti_maghsad_movaghat,3).'</td>
	   <td>'.round($sum_nahayi_jabejaei_ghoti_maghsad_sayer,3).'</td>
	   <td>'.round($sum_mande_pasazkasri_forush_ghoti,3).'</td>
	   <td>'.round($sum_mande_pasazkasri_ghoti,3).'</td>
	  </tr>
	  <tr class="print_table-even sum-row-white-b">
	   <td colspan="5">جمع تعداد شانه</td>
	   <td>'.$sum_mande_befor_shane.'</td>
	   <td>'.round($sum_havale_forush_befor_shane,3).'</td>
	   <td>'.round($sum_jabejae_befor_shane_maghsad_movaghat,3).'</td>
	   <td>'.round($sum_jabejae_befor_shane_maghsad_sayer,3).'</td>
	   <td>'.round($sum_varede_between_kharid_shane,3).'</td>
	   <td>'.round($sum_varede_between_jabejae_shane,3).'</td>
	   <td>'.round($sum_varede_between_bargasht_shane,3).'</td>
	   <td>'.round($sum_meghdarTadil_Ezafe_shane,3).'</td>
	   <td>'.round($sum_havale_forush_between_shane,3).'</td>
	   <td>'.round($sum_jabejae_between_shane_maghsad_movaghat,3).'</td>
	   <td>'.round($sum_jabejae_between_shane_maghsad_sayer,3).'</td>
	   <td>'.round($sum_jame_jensi_shane,3).'</td>
	   <td>'.round($sum_jame_forush_shane,3).'</td>
	   <td>'.round($sum_jame_jabejae_shane_maghsad_movaghat,3).'</td>
	   <td>'.round($sum_jame_jabejae_shane_maghsad_sayer,3).'</td>
	   <td>'.round($sum_sadere_between_forush_shane,3).'</td>
	   <td>'.round($sum_sadere_between_jabejae_shane_maghsad_movaghat,3).'</td>
	   <td>'.round($sum_sadere_between_jabejae_shane_maghsad_sayer,3).'</td>
	   <td>'.round($sum_meghdarTadil_Kasry_shane,3).'</td>
	   <td>'.round($sum_ebtaly_forush_shane,3).'</td>
	   <td>'.round($sum_ebtaly_jabejae_shane_maghsad_movaghat,3).'</td>
	   <td>'.round($sum_ebtaly_jabejae_shane_maghsad_sayer,3).'</td>
	   <td>'.round($sum_nahayi_jensi_shane,3).'</td>
	   <td>'.round($sum_nahayi_forushi_shane,3).'</td>
	   <td>'.round($sum_nahayi_jabejaei_shane_maghsad_movaghat,3).'</td>
	   <td>'.round($sum_nahayi_jabejaei_shane_maghsad_sayer,3).'</td>
	   <td>'.round($sum_mande_pasazkasri_forush_shane,3).'</td>
	   <td>'.round($sum_mande_pasazkasri_shane,3).'</td>
	  </tr>
	  <!--پايان مرکز صفحه -->
      <!-- چاپ زیرنوس-->';
      require_once('prt-footer.php');
      echo' 
      </table>';
	 }//END IF//وجود اطلاعات
	  ELSE{echo'<div class="msg_error"><span >اطلاعاتی یافت نشد</span><br><button class="buttonme hideatprint" onClick="window.location=\''.$FileName.'\'">بازگشت</button></div>';}
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo'
</div>	
</form>
</body>
</html>
<a href="#" class="elevator-button"></a>';	
?>
<script type="text/javascript" src="scripts/elevator.min.js"></script>