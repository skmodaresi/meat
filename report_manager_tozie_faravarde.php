<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="report_manager_tozie_faravarde.php";
$ExcelFileName=str_replace('.php','',$FileName);
$titr='گزارش آمار توزیع فرآورده ها ';
require_once('head.html');
//سال قبل
$sal_ghabl=$mtActiveYear-1;
$columns='
    <tr class="print_table-title2 print_table-title">
     <td width="%" rowspan="2">ردیف</td>
     <td width="%" rowspan="2">استان</td>
     <td width="%" rowspan="2">کالا</td>
     <td width="%" class="tahvilparsalPr" colspan="2">تحویل قطعی سال '.$sal_ghabl.'</td>
     <td width="%" class="tahvilPr" colspan="2">تحویل قطعی سال '.$mtActiveYear.'</td>
	</tr>
    <tr class="print_table-title2 print_table-title">
	  <td class="tahvilparsalPr">داخلی</td><td class="tahvilparsalPr">وارداتی</td>
	  <td class="tahvilPr">داخلی</td><td class="tahvilPr">وارداتی</td>
	 </tr>';
/****************هدر******************/
Function print_header()
{global $titr,$mt_gl_owner,$date1,$date2,$FileName,$page;
 echo'
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
		 از تاریخ : '.$date1.' تا تاریخ : '.$date2.'&nbsp&nbsp(صفحه : '.$page.')
	     <div style="float:left;"><button class="buttonme hideatprint" onClick="window.location=\''.$FileName.'\'">بازگشت</button></div>
	    </td>
       </tr>';
	   IF($page==1){
       echo'
	    <tr class="noExl">
	     <td class="print_title">
          تحویل قطعی شامل : بارگیری از سردخانه، تحویل روباری و حمل باراه آهن <br>
		   واحد کالا های گوشت گاو ، گوسفند ، مرغ و تخم مرغ کیلوگرم و کنسرو مرغ عدد است
          </td>
	    </tr>';
	   }
	   echo'
      </table>
	 </td>
    </tr>';
}
/****************فیلترها روی گزارش******************/
/************************استان ها******************/
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
{$Condition_ostan=' T.code_ostan='.$_SESSION['mt_code_ostan'].'';}
/*****************************انبارها****************************/
if(($_SESSION['mt_all_ostan']==1)or(SuperUser())){$Condition_anbar='1=1';$Condition_anbar_resid_d='1=1';$Condition_anbar_sell='1=1';$Condition_anbar_ebtal_sell='1=1';}
else //بقیه کاربران براساس انبار قابل دسترسیشان
{ 
 $q_user="SELECT * FROM user_ostan_anbar INNER JOIN list_sardkhane ON list_sardkhane.code_ostan=user_ostan_anbar.code_ostan AND list_sardkhane.code_anbar=user_ostan_anbar.code_anbar WHERE $Condition_movaghat list_sardkhane.code_ostan=".$_SESSION["mt_code_ostan"]." AND user_id=".$_SESSION['mt_user_id']."";
 $res_user=$db->query($q_user);
 while($row_user=$db->fetch_assoc($res_user))//انبارهای قابل دسترسی
 {
   $Condition_anbar_temp.=" T.code_anbar=".$row_user['code_anbar']." OR";
   $Condition_anbar_resid_d_temp.=" r_d.code_anbar=".$row_user['code_anbar']." OR";
   $sell_id_ostan=$db->get_from_where("province_id","sell.dm_province","province_code=".$_SESSION["mt_code_ostan"]."");//تبدیل کد به آی دی
   $sell_id_anbar=$db->get_from_where("l_id","sell.dm_location_goods","l_id_province=$sell_id_ostan AND l_code=".$row_user['code_anbar']."");//تبدیل کد به آی دی 
   if($sell_id_anbar)//اگر نظیرش در فروش بود
   {$Condition_anbar_temp_sell.=" dm_havale.h_l_code=".$sell_id_anbar." OR";
	$Condition_anbar_ebtal_temp_sell.=" dm_his_havale.his_l_code=".$sell_id_anbar." OR";}
 }
	 $Condition_anbar.="  $Condition_anbar_temp";
	 $Condition_anbar_resid_d.="  $Condition_anbar_resid_d_temp";
	 $Condition_anbar_sell.="  $Condition_anbar_temp_sell";
	 $Condition_anbar_ebtal_sell.="  $Condition_anbar_ebtal_temp_sell";
     $lastSpacePosition = strrpos($Condition_anbar," ");
     $lastSpacePosition_resid_d = strrpos($Condition_anbar_resid_d," ");
     $lastSpacePosition_sell = strrpos($Condition_anbar_sell," ");
     $lastSpacePosition_ebtal_sell = strrpos($Condition_anbar_ebtal_sell," ");
     $Condition_anbar =substr($Condition_anbar,0,$lastSpacePosition);
	 $Condition_anbar_resid_d =substr($Condition_anbar_resid_d,0,$lastSpacePosition_resid_d);
     $Condition_anbar_sell =substr($Condition_anbar_sell,0,$lastSpacePosition_sell);
     $Condition_anbar_ebtal_sell =substr($Condition_anbar_ebtal_sell,0,$lastSpacePosition_ebtal_sell);
}
/**************انتخاب گروه کالا****************/
if(is_array($groupkalachoice))
{
 $grpkalaArrChoice=array();//کالاهای انتخاب شده داخل این آرایه قرار میگیرد
 foreach($groupkalachoice as $grp_val) 
 {
  if($grp_val=='همه'){$grpkalaArrChoice=array();$grpkalaArrChoice=$kalagroupArr;break;}
  else array_push($grpkalaArrChoice,$grp_val);
  //print_r($grpkalaArrChoice);
 }
}
/******************نمایش یا عدم نمایش سردخانه های موقت******************/
// if($chkmovaghat=='on') {$Condition_movaghat="";$Condition_movaghat_mj="";}
// else {$Condition_movaghat="list_sardkhane.situation_type=1 AND "; $Condition_movaghat_mj="l_s.situation_type=1 AND";}
/******************وضعیت نمایش اطلاعات انبارهای موقت******************/
if($show_movaghat==1){$Condition_movaghat="list_sardkhane.situation_type=1 AND "; $Condition_movaghat_mj="l_s.situation_type=1 AND ";}
else if($show_movaghat==2){$Condition_movaghat="";$Condition_movaghat_mj="";}
else if($show_movaghat==3){$Condition_movaghat="list_sardkhane.situation_type=2 AND ";$Condition_movaghat_mj="";}//خودش موقت ولی مقصد هر انباری
/******************نمایش یا عدم نمایش انبارهای غیرفعال******************/
if($chkactivate=='on') {$Condition_anbar_activate=""; $Condition_anbar_activate_mj=""; $Condition_anbar_activate_ostan="1=1";}
else {$Condition_anbar_activate="list_sardkhane.activate=1 AND"; $Condition_anbar_activate_mj="l_s.activate=1 AND"; $Condition_anbar_activate_ostan="activate=1";}
/***************************************** MAIN*****************************************/
echo'
<body class="openwin" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.date.focus();">
<form method="post" name="myform">';
if(!$MaxLines)$MaxLines=5;
 //اگر کاربر تاریخ اول را وارد نکرده بود
 if(!$date1)$date1=$db->get_from_where("start_from","mt_docs","year='$mtActiveYear'");  
 //اگر کاربر تاریخ دوم را وارد نکرده بود
 if(!$date2)
 {
   $today=AsLDate($yymmdd); 
   $end_date_session=$db->get_from_where("end_to","mt_docs","year='$mtActiveYear'");
   if($today<$end_date_session) $date2=$today;
   else  $date2=$end_date_session;	 
 }
 
if(!$ok)
{
echo'
<table width="95%" align="center" cellpadding="0" cellspacing="0">
 <tr>
  <td height="100%">
   <table width="750px" border="0" align="center" cellpadding="0" cellspacing="0" >
    <tr><td colspan="4" height="20px">&nbsp;</td></tr>
	<tr>
     <td colspan="4" class="title">'.$titr.'</td>	 
    </tr>
    <tr class="tr1" style="height:45px">
	  <td align="left"> از تاریخ : </td><td align="right">&nbsp;<input type="text" class="textboxme2" maxlength="10" name="date1" id="datepickerfrom" placeholder="'.$date1.'"/></td>	
      <td align="left"> تا تاریخ : </td><td align="right">&nbsp;<input type="text" class="textboxme2" maxlength="10" name="date2" id="datepickerto" placeholder="'.$date2.'"/></td>
	</tr>
    <tr class="tr1">
	 <td align="left"> نمایش اطلاعات : </td><td align="right">&nbsp;'.static_listbox("noe_namayesh",$noe_namayesh,"namayeshArr",1,"class='text4'").'</td>	
	 <td align="left"> تعداد استان در صفحه : </td><td align="right">&nbsp;<input type="number" class="textboxme2" name="MaxLines" value="'.$MaxLines.'" onkeypress="return isNumber(event)"/></td>
	</tr>
	<tr class="tr1">
	 <td align="left" height="40px"> وضعیت نمایش سردخانه های موقت : </td><td align="right">&nbsp;'.static_listbox("show_movaghat",$show_movaghat,"showMovaghatArr",1,"class='text4'").'</td>
	 <!--<td align="left"><input type="checkbox" name="chkmovaghat"/></td><td align="right" colspan="3">&nbsp; همراه با اطلاعات سردخانه موقت </td>-->
	 <td align="left"><input type="checkbox" name="chkactivate" checked/></td><td align="right">&nbsp; نمایش اطلاعات سردخانه های غیرفعال</td>
	</tr>
    <tr class="tr1">
     <td align="left" height="160px">گروه کالا : </td>
     <td align="right">
	  &nbsp;<select name="groupkalachoice[]" size="7"  style="font-family:bYekan;width:130px;" multiple>
	  <option value="همه" selected>همه کالاها</option>';
	  foreach($kalagroupArr as $grp_key=>$grp_val)
	  {echo '<option value="'.$grp_val.'" >'.$grp_val.'</option>';}
	  echo'
	  </select>
	  <img border="0" src="images/Info1.png" title="دکمه Ctrl کیبورد را نگه دارید و کالاهای مورد نظر خود را انتخاب نمایید" onmouseOver="this.src=\'images/Info_h.png\'" onmouseOut="this.src=\'images/Info1.png\'" style="width:16px;height:16px;cursor:pointer"/>
	  &nbsp;
	 </td>';
	if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
	{
	 echo'
	  <td align="left">نام استان : </td>
      <td align="right" colspan="3">
	   &nbsp;<select name="ostanchoice[]" size="7" style="font-family:bYekan;width:200px;" multiple>';
	   $result_ostan = $db->query("SELECT * FROM ostan ORDER BY name_ostan");
       $ostan_options = "<option value='-1' selected>همه استانها</option>";
       while($row_ostan=$db->fetch_assoc($result_ostan)) $ostan_options .= "<option value=".$row_ostan['code_ostan'].">".$row_ostan['name_ostan']."</option>";
	   echo $ostan_options;
	   echo'
	   </select>
	   <img border="0" src="images/Info1.png" title="دکمه Ctrl کیبورد را نگه دارید و استانهای موردنظر خود را انتخاب نمایید" onmouseOver="this.src=\'images/Info_h.png\'" onmouseOut="this.src=\'images/Info1.png\'" style="width:16px;height:16px;cursor:pointer"/>
	  &nbsp;
	  </td>';
	}
    else echo '<td colspan="2">&nbsp;</td>';	
	echo'
	</tr>
    <tr class="footer" align="center"><td colspan="4" height="40px"><input class="buttonme" type="submit" name="ok" value="شروع گزارش"></td></tr>    
   </table>
  </td>
 </tr>
</table> ';
}
else
{  
/****************شروع نمایش گزارش*******************/	
$radif=1;
$page=1;
$line=0;
$i=0;
$cntr=0;
$q="SELECT * FROM ostan T WHERE code_ostan IN(SELECT code_ostan FROM list_sardkhane WHERE $Condition_movaghat $Condition_anbar_activate_ostan) AND($Condition_ostan) ORDER BY name_ostan";
$res=$db->query($q);
$cntr =mysql_num_rows($res);
if(mysql_num_rows($res)>0)//وجود اطلاعات
{echo'
 <br>
 <div class="table2excel">';
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
 if($show_movaghat==1) $filter_string.=' بدون اطلاعات سردخانه موقت';
 else if($show_movaghat==2) $filter_string.=' با اطلاعات سردخانه موقت';
 else if($show_movaghat==3) $filter_string.=' فقط اطلاعات سردخانه موقت';
 if(is_array($groupkalachoice))
 {
 	$filter_string.=' گروه کالا : ';
 	foreach($groupkalachoice as $grp_val) 
 	{
 	  if($grp_val=="همه"){$filter_string.=' همه کالاها ';break;}
 	  else $filter_string.=''.$grp_val.'&nbsp;';
    }
 }
 if($noe_namayesh==1) $filter_string.="نمایش اطلاعات : خالص";
 if($noe_namayesh==2) $filter_string.="نمایش اطلاعات : ناخالص";
 if($noe_namayesh==3) $filter_string.="نمایش اطلاعات : تعداد";
  echo'<tr class="noExl"><td class="filter_text" colspan="50">فیلتر شده براساس : '.$filter_string.'</td></tr>';
  echo $columns;
  while($row=$db->fetch_array($res))//ostan while
  {	
    $line++;
	$rowkala=count($grpkalaArrChoice);
    $t=$rowkala;
	if($i++%2)echo'<tr class="print_table-odd_small">';
    else echo'<tr class="print_table-even_small">';
    echo'   
    <td rowspan="'.$rowkala.'">'.$radif++.'</td>
    <td rowspan="'.$rowkala.'">'.$row['name_ostan'].'</td>';
	foreach($grpkalaArrChoice as $x => $x_value ) 
    {
	 $j=$i+1;
	 echo'
	 <td>'.$x_value.'</td>';
	 if($x_value=="گوشت گاو")
	 {
	   //dakheli:81,82,83,84,85,86,89,105,106,107,108,109,40,29,30,31,32,33,34
	   $kalaCondition_dakheli=" AND (T.code_kala=81 OR T.code_kala=82 OR T.code_kala=83 OR T.code_kala=84 OR T.code_kala=85 OR T.code_kala=86 OR T.code_kala=89 OR T.code_kala=105 OR T.code_kala=106 OR T.code_kala=107 OR T.code_kala=108 OR T.code_kala=109 OR T.code_kala=40 OR T.code_kala=29 OR T.code_kala=30 OR T.code_kala=31 OR T.code_kala=32 OR T.code_kala=33 OR T.code_kala=34)";
	   $kalaCondition_resid_dakheli=" AND (r_k_d.code_kala=81 OR r_k_d.code_kala=82 OR r_k_d.code_kala=83 OR r_k_d.code_kala=84 OR r_k_d.code_kala=85 OR r_k_d.code_kala=86 OR r_k_d.code_kala=89 OR r_k_d.code_kala=105 OR r_k_d.code_kala=106 OR r_k_d.code_kala=107 OR r_k_d.code_kala=108 OR r_k_d.code_kala=109 OR r_k_d.code_kala=40 OR r_k_d.code_kala=29 OR r_k_d.code_kala=30 OR r_k_d.code_kala=31 OR r_k_d.code_kala=32 OR r_k_d.code_kala=33 OR r_k_d.code_kala=34)";
	   $kalaCondition_havale_dakheli=" AND (h_d.code_kala=81 OR h_d.code_kala=82 OR h_d.code_kala=83 OR h_d.code_kala=84 OR h_d.code_kala=85 OR h_d.code_kala=86 OR h_d.code_kala=89 OR h_d.code_kala=105 OR h_d.code_kala=106 OR h_d.code_kala=107 OR h_d.code_kala=108 OR h_d.code_kala=109 OR h_d.code_kala=40 OR h_d.code_kala=29 OR h_d.code_kala=30 OR h_d.code_kala=31 OR h_d.code_kala=32 OR h_d.code_kala=33 OR h_d.code_kala=34)";
	   $kalaCondition_dakheli_sell=" AND (h_p_code=81 OR h_p_code=82 OR h_p_code=83 OR h_p_code=84 OR h_p_code=85 OR h_p_code=86 OR h_p_code=89 OR h_p_code=105 OR h_p_code=106 OR h_p_code=107 OR h_p_code=108 OR h_p_code=109 OR h_p_code=40 OR h_p_code=29 OR h_p_code=30 OR h_p_code=31 OR h_p_code=32 OR h_p_code=33 OR h_p_code=34)";
	   //varedati:72,73,74,75,76,77,78,79,92,65,66,67,68,69
	   $kalaCondition_varedati=" AND (T.code_kala=72 OR T.code_kala=73 OR T.code_kala=74 OR T.code_kala=75 OR T.code_kala=76 OR T.code_kala=77 OR T.code_kala=78 OR T.code_kala=79 OR T.code_kala=92 OR T.code_kala=65 OR T.code_kala=66 OR T.code_kala=67 OR T.code_kala=68 OR T.code_kala=69)";
	   $kalaCondition_resid_varedati=" AND (r_k_d.code_kala=72 OR r_k_d.code_kala=73 OR r_k_d.code_kala=74 OR r_k_d.code_kala=75 OR r_k_d.code_kala=76 OR r_k_d.code_kala=77 OR r_k_d.code_kala=78 OR r_k_d.code_kala=79 OR r_k_d.code_kala=92 OR r_k_d.code_kala=65 OR r_k_d.code_kala=66 OR r_k_d.code_kala=67 OR r_k_d.code_kala=68 OR r_k_d.code_kala=69)";
	   $kalaCondition_havale_varedati=" AND (h_d.code_kala=72 OR h_d.code_kala=73 OR h_d.code_kala=74 OR h_d.code_kala=75 OR h_d.code_kala=76 OR h_d.code_kala=77 OR h_d.code_kala=78 OR h_d.code_kala=79 OR h_d.code_kala=92 OR h_d.code_kala=65 OR h_d.code_kala=66 OR h_d.code_kala=67 OR h_d.code_kala=68 OR h_d.code_kala=69)";
	   $kalaCondition_varedati_sell=" AND (h_p_code=72 OR h_p_code=73 OR h_p_code=74 OR h_p_code=75 OR h_p_code=76 OR h_p_code=77 OR h_p_code=78 OR h_p_code=79 OR h_p_code=92 OR h_p_code=65 OR h_p_code=66 OR h_p_code=67 OR h_p_code=68 OR h_p_code=69)";
	 }
	 if($x_value=="گوشت گوسفند")
	 {
	   //dakheli:144,148,149,150,151,88,90,205,206,207,208,209,210,41,42,43,44,45,46
	   $kalaCondition_dakheli=" AND (T.code_kala=144 OR T.code_kala=148 OR T.code_kala=149 OR T.code_kala=150 OR T.code_kala=151 OR T.code_kala=88 OR T.code_kala=90 OR T.code_kala=205 OR T.code_kala=206 OR T.code_kala=207 OR T.code_kala=208 OR T.code_kala=209 OR T.code_kala=210 OR T.code_kala=41 OR T.code_kala=42 OR T.code_kala=43 OR T.code_kala=44 OR T.code_kala=45 )";
	   $kalaCondition_resid_dakheli=" AND (r_k_d.code_kala=144 OR r_k_d.code_kala=148 OR r_k_d.code_kala=149 OR r_k_d.code_kala=150 OR r_k_d.code_kala=151 OR r_k_d.code_kala=88 OR r_k_d.code_kala=90 OR r_k_d.code_kala=205 OR r_k_d.code_kala=206 OR r_k_d.code_kala=207 OR r_k_d.code_kala=208 OR r_k_d.code_kala=209 OR r_k_d.code_kala=210 OR r_k_d.code_kala=41 OR r_k_d.code_kala=42 OR r_k_d.code_kala=43 OR r_k_d.code_kala=44 OR r_k_d.code_kala=45)";
	   $kalaCondition_havale_dakheli=" AND (h_d.code_kala=144 OR h_d.code_kala=148 OR h_d.code_kala=149 OR h_d.code_kala=150 OR h_d.code_kala=151 OR h_d.code_kala=88 OR h_d.code_kala=90 OR h_d.code_kala=205 OR h_d.code_kala=206 OR h_d.code_kala=207 OR h_d.code_kala=208 OR h_d.code_kala=209 OR h_d.code_kala=210 OR h_d.code_kala=41 OR h_d.code_kala=42 OR h_d.code_kala=43 OR h_d.code_kala=44 OR h_d.code_kala=45)";
	   $kalaCondition_dakheli_sell=" AND (h_p_code=144 OR h_p_code=148 OR h_p_code=149 OR h_p_code=150 OR h_p_code=151 OR h_p_code=88 OR h_p_code=90 OR h_p_code=205 OR h_p_code=206 OR h_p_code=207 OR h_p_code=208 OR h_p_code=209 OR h_p_code=210 OR h_p_code=41 OR h_p_code=42 OR h_p_code=43 OR h_p_code=44 OR h_p_code=45)";
	   //varedati:87,60,61,62,63,64,113,173,174
	   $kalaCondition_varedati=" AND (T.code_kala=87 OR T.code_kala=60 OR T.code_kala=61 OR T.code_kala=62 OR T.code_kala=63 OR T.code_kala=64 OR T.code_kala=113 OR T.code_kala=173 OR T.code_kala=174)";
	   $kalaCondition_resid_varedati=" AND (r_k_d.code_kala=87 OR r_k_d.code_kala=60 OR r_k_d.code_kala=61 OR r_k_d.code_kala=62 OR r_k_d.code_kala=63 OR r_k_d.code_kala=64 OR r_k_d.code_kala=113 OR r_k_d.code_kala=173 OR r_k_d.code_kala=174)";
	   $kalaCondition_havale_varedati=" AND (h_d.code_kala=87 OR h_d.code_kala=60 OR h_d.code_kala=61 OR h_d.code_kala=62 OR h_d.code_kala=63 OR h_d.code_kala=64 OR h_d.code_kala=113  OR h_d.code_kala=173  OR h_d.code_kala=174)";
	   $kalaCondition_varedati_sell=" AND (h_p_code=87 OR h_p_code=60 OR h_p_code=61 OR h_p_code=62 OR h_p_code=63 OR h_p_code=64 OR h_p_code=113 OR h_p_code=173 OR h_p_code=174)";	 
     }
	 if($x_value=="گوشت مرغ")
	 {
	   //dakheli:38,401,402,403,404,410,411,412,197,198,405,413,414,415,416,266
	   $kalaCondition_dakheli=" AND (T.code_kala=38 OR T.code_kala=401 OR T.code_kala=402 OR T.code_kala=403 OR T.code_kala=404 OR T.code_kala=410 OR T.code_kala=411 OR T.code_kala=412 OR T.code_kala=197 OR T.code_kala=198 OR T.code_kala=405 OR T.code_kala=413 OR T.code_kala=414 OR T.code_kala=415 OR T.code_kala=416 OR T.code_kala=266)";
	   $kalaCondition_resid_dakheli=" AND (r_k_d.code_kala=38 OR r_k_d.code_kala=401 OR r_k_d.code_kala=402 OR r_k_d.code_kala=403 OR r_k_d.code_kala=404 OR r_k_d.code_kala=410 OR r_k_d.code_kala=411 OR r_k_d.code_kala=412 OR r_k_d.code_kala=197 OR r_k_d.code_kala=198 OR r_k_d.code_kala=405 OR r_k_d.code_kala=413 OR r_k_d.code_kala=414 OR r_k_d.code_kala=415 OR r_k_d.code_kala=416 OR r_k_d.code_kala=266)";
	   $kalaCondition_havale_dakheli=" AND (h_d.code_kala=38 OR h_d.code_kala=401 OR h_d.code_kala=402 OR h_d.code_kala=403 OR h_d.code_kala=404 OR h_d.code_kala=410 OR h_d.code_kala=411 OR h_d.code_kala=412 OR h_d.code_kala=197 OR h_d.code_kala=198 OR h_d.code_kala=405 OR h_d.code_kala=413 OR h_d.code_kala=414 OR h_d.code_kala=415 OR h_d.code_kala=416 OR h_d.code_kala=266)";
	   $kalaCondition_dakheli_sell=" AND (h_p_code=38 OR h_p_code=401 OR h_p_code=402 OR h_p_code=403 OR h_p_code=404 OR h_p_code=410 OR h_p_code=411 OR h_p_code=412 OR h_p_code=197 OR h_p_code=198 OR h_p_code=405 OR h_p_code=413 OR h_p_code=414 OR h_p_code=415 OR h_p_code=416 OR h_p_code=266)";
	   //varedati:154,155,91,35
	   $kalaCondition_varedati=" AND (T.code_kala=154 OR T.code_kala=155 OR T.code_kala=91 OR T.code_kala=35)";
	   $kalaCondition_resid_varedati=" AND (r_k_d.code_kala=154 OR r_k_d.code_kala=155 OR r_k_d.code_kala=91 OR r_k_d.code_kala=35)";
	   $kalaCondition_havale_varedati=" AND (h_d.code_kala=154 OR h_d.code_kala=155 OR h_d.code_kala=91 OR h_d.code_kala=35)";
	   $kalaCondition_varedati_sell=" AND (h_p_code=154 OR h_p_code=155 OR h_p_code=91 OR h_p_code=35)";
	 }
     if($x_value=="کنسرو مرغ")  
	 {
	   //dakheli:406,407
	   $kalaCondition_dakheli=" AND (T.code_kala=406 OR T.code_kala=407)";
	   $kalaCondition_resid_dakheli=" AND (r_k_d.code_kala=406 OR r_k_d.code_kala=407)";
	   $kalaCondition_havale_dakheli=" AND (h_d.code_kala=406 OR h_d.code_kala=407)";
	   $kalaCondition_dakheli_sell=" AND (h_p_code=406 OR h_p_code=407)";
	   //varedati:dont exist
	   $kalaCondition_varedati=" AND 1!=1";
	   $kalaCondition_resid_varedati=" AND 1!=1";
	   $kalaCondition_havale_varedati=" AND 1!=1";
	   $kalaCondition_varedati_sell=" AND 1!=1";
	 }
	 if($x_value=="تخم مرغ خوراکی")
     {
 	   //dakheli:54
	   $kalaCondition_dakheli=" AND T.code_kala=54";
	   $kalaCondition_resid_dakheli=" AND r_k_d.code_kala=54";
	   $kalaCondition_havale_dakheli=" AND h_d.code_kala=54";
	   $kalaCondition_dakheli_sell=" AND h_p_code=54";
	   //varedati:50
	   $kalaCondition_varedati=" AND T.code_kala=50";
	   $kalaCondition_resid_varedati=" AND r_k_d.code_kala=50";
	   $kalaCondition_havale_varedati=" AND h_d.code_kala=50";
	   $kalaCondition_varedati_sell=" AND h_p_code=50";
	 }
	 if($x_value=="تخم مرغ صنعتی")
     {
	   //dakheli:52,53
	   $kalaCondition_dakheli=" AND (T.code_kala=52 OR T.code_kala=53)";
	   $kalaCondition_resid_dakheli=" AND (r_k_d.code_kala=52 OR r_k_d.code_kala=53)";
	   $kalaCondition_havale_dakheli=" AND (h_d.code_kala=52 OR h_d.code_kala=53)";
	   $kalaCondition_dakheli_sell=" AND (h_p_code=52 OR h_p_code=53)";
	   //varedati:51,55
	   $kalaCondition_varedati=" AND (T.code_kala=51 OR T.code_kala=55)";
	   $kalaCondition_resid_varedati=" AND (r_k_d.code_kala=51 OR r_k_d.code_kala=55)";
	   $kalaCondition_havale_varedati=" AND (h_d.code_kala=51 OR h_d.code_kala=55)";
	   $kalaCondition_varedati_sell=" AND (h_p_code=51 OR h_p_code=55)";
	 }
	 // if($x_value=="مرغ مادر")
     // {
 	  // //dakheli:405
	  // $kalaCondition_dakheli=" AND T.code_kala=405";
	  // $kalaCondition_dakheli_sell=" AND h_p_code=405";
	  // //varedati:dont exist
	  // $kalaCondition_varedati=" AND 1!=1";
	  // $kalaCondition_varedati_sell=" AND 1!=1";
	 // }
	 IF($noe_namayesh==1){$avalField='mojody_khales_aval';$residField='vazn_khales_r_d_sub';$havaleField='vazn_khales_h_d';$tadilField='meghdar_khales_tadil';$anbargardaniField='khales_anbargardani';$vahed='کیلوگرم';}
	 ELSE IF($noe_namayesh==2){$avalField='mojody_nakhales_aval';$residField='vazn_nakhales_r_d_sub';$havaleField='vazn_nakhales_h_d';$tadilField='meghdar_nakhales_tadil';$anbargardaniField='nakhales_anbargardani';$vahed='کیلوگرم';}
	 ELSE IF($noe_namayesh==3){$avalField='tedad_karton_aval';$residField='tedad_karton_r_d_sub';$havaleField='tedad_karton_h_d';$tadilField='tedad_karton_tadil';$anbargardaniField='tedad_anbargardani';$vahed='تعداد';}				 
	 ELSE IF($noe_namayesh==4){$avalField='tedad_shane_aval';$residField='tedad_shane_r_d_sub';$havaleField='tedad_shane_h_d';$tadilField='tedad_shane_tadil';$anbargardaniField='shane_anbargardani';$vahed='شانه';}				 

	 //تحویل قطعی سال قبل
	 $tahvilghatee_dakheli_parsal=$db->get_from_where("SUM($havaleField)","meat.havale_detail T INNER JOIN meat.havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_anbar_activate $Condition_movaghat (h.noe_tahvil_bar=1 OR h.noe_tahvil_bar=2 OR h.noe_tahvil_bar=3) AND T.year='$sal_ghabl' AND T.code_ostan=".$row['code_ostan']." AND T.havale_deleted=0 AND T.status=0  $kalaCondition_dakheli  AND($Condition_anbar)");
	 $tahvilghatee_varedati_parsal=$db->get_from_where("SUM($havaleField)","meat.havale_detail T INNER JOIN meat.havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_anbar_activate $Condition_movaghat (h.noe_tahvil_bar=1 OR h.noe_tahvil_bar=2 OR h.noe_tahvil_bar=3) AND T.year='$sal_ghabl' AND T.code_ostan=".$row['code_ostan']." AND T.havale_deleted=0 AND T.status=0  $kalaCondition_varedati  AND($Condition_anbar)");
	 //تحویل قطعی
	 $tahvilghatee_dakheli_emsal=$db->get_from_where("SUM($havaleField)","meat.havale_detail T INNER JOIN meat.havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_anbar_activate $Condition_movaghat (h.noe_tahvil_bar=1 OR h.noe_tahvil_bar=2 OR h.noe_tahvil_bar=3) AND T.year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.havale_deleted=0 AND T.status=0 AND h.tarikh_havale_anbar BETWEEN '".$date1."' AND  '".$date2."' $kalaCondition_dakheli  AND($Condition_anbar)");
	 $tahvilghatee_varedati_emsal=$db->get_from_where("SUM($havaleField)","meat.havale_detail T INNER JOIN meat.havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_anbar_activate $Condition_movaghat (h.noe_tahvil_bar=1 OR h.noe_tahvil_bar=2 OR h.noe_tahvil_bar=3) AND T.year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND T.havale_deleted=0 AND T.status=0 AND h.tarikh_havale_anbar BETWEEN '".$date1."' AND  '".$date2."'  $kalaCondition_varedati  AND($Condition_anbar)");

    
	//نمایش اطلاعات
	echo'
		  <td class="tahvilparsalPr">'.round($tahvilghatee_dakheli_parsal,3).'</td>
		  <td class="tahvilparsalPr">'.round($tahvilghatee_varedati_parsal,3).'</td>
		  <td class="tahvilPr">'.round($tahvilghatee_dakheli_emsal,3).'</td>
		  <td class="tahvilPr">'.round($tahvilghatee_varedati_emsal,3).'</td>';
		$t--;
		if($t==0) echo'';
		else 
		{
		 echo'</tr>';
		 if($j++%2)echo'<tr class="print_table-odd_small">';
         else echo'<tr class="print_table-even_small">';
	    }
		$jame_tahvilghatee_dakheli_parsal+=$tahvilghatee_dakheli_parsal;
	    $jame_tahvilghatee_varedati_parsal+=$tahvilghatee_varedati_parsal;
		$jame_tahvilghatee_dakheli_emsal+=$tahvilghatee_dakheli_emsal;
	    $jame_tahvilghatee_varedati_emsal+=$tahvilghatee_varedati_emsal;

		IF($x_value=="گوشت گاو")//برای جمع تکی 
		{
		 $show_gav=1;
		 $jame_tahvilghatee_dakheli_gav_parsal+=$tahvilghatee_dakheli_parsal;
	     $jame_tahvilghatee_varedati_gav_parsal+=$tahvilghatee_varedati_parsal;
		 $jame_tahvilghatee_dakheli_gav_emsal+=$tahvilghatee_dakheli_emsal;
	     $jame_tahvilghatee_varedati_gav_emsal+=$tahvilghatee_varedati_emsal;
		}
		IF($x_value=="گوشت گوسفند")
		{
		 $show_gosfand=1;
		 $jame_tahvilghatee_dakheli_gosfand_parsal+=$tahvilghatee_dakheli_parsal;
	     $jame_tahvilghatee_varedati_gosfand_parsal+=$tahvilghatee_varedati_parsal;
		 $jame_tahvilghatee_dakheli_gosfand_emsal+=$tahvilghatee_dakheli_emsal;
	     $jame_tahvilghatee_varedati_gosfand_emsal+=$tahvilghatee_varedati_emsal;	 
		}
		IF($x_value=="گوشت مرغ")
		{
		 $show_morgh=1; 
		 $jame_tahvilghatee_dakheli_morgh_parsal+=$tahvilghatee_dakheli_parsal;
	     $jame_tahvilghatee_varedati_morgh_parsal+=$tahvilghatee_varedati_parsal;
 		 $jame_tahvilghatee_dakheli_morgh_emsal+=$tahvilghatee_dakheli_emsal;
	     $jame_tahvilghatee_varedati_morgh_emsal+=$tahvilghatee_varedati_emsal; 
		}
		IF($x_value=="کنسرو مرغ")
		{
		 $show_konserv=1;
		 $jame_tahvilghatee_dakheli_konserv_parsal+=$tahvilghatee_dakheli_parsal;
	     $jame_tahvilghatee_varedati_konserv_parsal+=$tahvilghatee_varedati_parsal;
		 $jame_tahvilghatee_dakheli_konserv_emsal+=$tahvilghatee_dakheli_emsal;
	     $jame_tahvilghatee_varedati_konserv_emsal+=$tahvilghatee_varedati_emsal;		 
		}
		IF($x_value=="تخم مرغ خوراکی")
		{
		 $show_tokhme_m=1;
		 $jame_tahvilghatee_dakheli_tokhme_m_parsal+=$tahvilghatee_dakheli_parsal;
	     $jame_tahvilghatee_varedati_tokhme_m_parsal+=$tahvilghatee_varedati_parsal;
		 $jame_tahvilghatee_dakheli_tokhme_m_emsal+=$tahvilghatee_dakheli_emsal;
	     $jame_tahvilghatee_varedati_tokhme_m_emsal+=$tahvilghatee_varedati_emsal;	 
		}
	    IF($x_value=="تخم مرغ صنعتی")
		{
		 $show_tokhme_m_s=1;
		 $jame_tahvilghatee_dakheli_tokhme_m_s_parsal+=$tahvilghatee_dakheli_parsal;
	     $jame_tahvilghatee_varedati_tokhme_m_s_parsal+=$tahvilghatee_varedati_parsal;
		 $jame_tahvilghatee_dakheli_tokhme_m_s_emsal+=$tahvilghatee_dakheli_emsal;
	     $jame_tahvilghatee_varedati_tokhme_m_s_emsal+=$tahvilghatee_varedati_emsal;		 
		}
		
	  }//END foreach Groupkala
	  /*****تکرار سرصفحه و ستون ها*****/
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
   /*****سطر جمع تکی گروه کالا*****/
   IF($show_gav==1)
   {
	echo'
	 <tr class="print_table-even sum-row" style="background-color:#FFF;" >
	  <td colspan="3">جمع گوشت گاو</td>
	    <td class="tahvilparsalPr">'.round($jame_tahvilghatee_dakheli_gav_parsal,3).'</td>
	    <td class="tahvilparsalPr">'.round($jame_tahvilghatee_varedati_gav_parsal,3).'</td>
	    <td class="tahvilPr">'.round($jame_tahvilghatee_dakheli_gav_emsal,3).'</td>
	    <td class="tahvilPr">'.round($jame_tahvilghatee_varedati_gav_emsal,3).'</td>
	 </tr>'; 
   }
   IF($show_gosfand==1)
   {  
     echo'
	 <tr class="print_table-even sum-row" style="background-color:#FFF;" >
	  <td colspan="3">جمع گوشت گوسفند</td>
	    <td class="tahvilparsalPr">'.round($jame_tahvilghatee_dakheli_gosfand_parsal,3).'</td>
	    <td class="tahvilparsalPr">'.round($jame_tahvilghatee_varedati_gosfand_parsal,3).'</td>
	    <td class="tahvilPr">'.round($jame_tahvilghatee_dakheli_gosfand_emsal,3).'</td>
	    <td class="tahvilPr">'.round($jame_tahvilghatee_varedati_gosfand_emsal,3).'</td>
	 </tr>';   
    }
	IF($show_morgh==1)
    {
	 echo'
	 <tr class="print_table-even sum-row" style="background-color:#FFF;" >
	  <td colspan="3">جمع گوشت مرغ</td>
	    <td class="tahvilparsalPr">'.round($jame_tahvilghatee_dakheli_morgh_parsal,3).'</td>
	    <td class="tahvilparsalPr">'.round($jame_tahvilghatee_varedati_morgh_parsal,3).'</td>
	    <td class="tahvilPr">'.round($jame_tahvilghatee_dakheli_morgh_emsal,3).'</td>
	    <td class="tahvilPr">'.round($jame_tahvilghatee_varedati_morgh_emsal,3).'</td>
	 </tr>';	
	}
	IF($show_konserv==1)
    {
	echo'
	 <tr class="print_table-even sum-row" style="background-color:#FFF;" >
	  <td colspan="3" >جمع کنسرو مرغ</td>
	    <td class="tahvilparsalPr">'.round($jame_tahvilghatee_dakheli_konserv_parsal,3).'</td>
	    <td class="tahvilparsalPr">'.round($jame_tahvilghatee_varedati_konserv_parsal,3).'</td>
	    <td class="tahvilPr">'.round($jame_tahvilghatee_dakheli_konserv_emsal,3).'</td>
	    <td class="tahvilPr">'.round($jame_tahvilghatee_varedati_konserv_emsal,3).'</td>
	 </tr>';
	}
	IF($show_tokhme_m==1)
    {
	 echo'
	 <tr class="print_table-even_small sum-row" style="background-color:#FFF;" >
	  <td colspan="3">جمع تخم مرغ خوراکی</td>
	    <td class="tahvilparsalPr">'.round($jame_tahvilghatee_dakheli_tokhme_m_parsal,3).'</td>
	    <td class="tahvilparsalPr">'.round($jame_tahvilghatee_varedati_tokhme_m_parsal,3).'</td>
	    <td class="tahvilPr">'.round($jame_tahvilghatee_dakheli_tokhme_m_emsal,3).'</td>
	    <td class="tahvilPr">'.round($jame_tahvilghatee_varedati_tokhme_m_emsal,3).'</td>
	 </tr>';	
	}
	IF($show_tokhme_m_s==1)
    {
	 echo'
	 <tr class="print_table-even_small sum-row" style="background-color:#FFF;" >
	  <td colspan="3">جمع تخم مرغ صنعتی</td>
	    <td class="tahvilparsalPr">'.round($jame_tahvilghatee_dakheli_tokhme_m_s_parsal,3).'</td>
	    <td class="tahvilparsalPr">'.round($jame_tahvilghatee_varedati_tokhme_m_s_parsal,3).'</td>
	    <td class="tahvilPr">'.round($jame_tahvilghatee_dakheli_tokhme_m_s_emsal,3).'</td>
	    <td class="tahvilPr">'.round($jame_tahvilghatee_varedati_tokhme_m_s_emsal,3).'</td>
	 </tr>';
	}	
   /*****سطر جمع کل استان ها*****/
   echo'
	 <tr class="print_table-even sum-row" style="background-color:#FFF;" >
	  <td colspan="3">جمع کل</td>
	  	<td class="tahvilparsalPr">'.round($jame_tahvilghatee_dakheli_parsal,3).'</td>
	    <td class="tahvilparsalPr">'.round($jame_tahvilghatee_varedati_parsal,3).'</td>
	    <td class="tahvilPr">'.round($jame_tahvilghatee_dakheli_emsal,3).'</td>
	    <td class="tahvilPr">'.round($jame_tahvilghatee_varedati_emsal,3).'</td>
	 </tr>';
	 //END//
	 echo'
  <!--پايان مرکز صفحه -->
  <!-- چاپ زیرنویس-->
   <tr class="print_footer noExl">
    <td colspan="50">&nbsp;&nbsp;نام کاربر :&nbsp;&nbsp;'.$mtuserNAME.' &nbsp;&nbsp;&nbsp; تاریخ چاپ : '.$today.' &nbsp;&nbsp;&nbsp; ساعت چاپ : '.$logtime.'</td>
   </tr>
 </table>';
  }//END IF//وجود اطلاعات
  ELSE{echo'<div class="msg_error"><span >اطلاعاتی یافت نشد</span><br><button class="buttonme hideatprint" onClick="window.location=\''.$FileName.'\'">بازگشت</button></div>';}
}
echo'
</div>	
</form>
</body>
</html>
<a href="#" class="elevator-button"></a>';	
?>
<script type="text/javascript" src="scripts/elevator.min.js"></script>
<script type="text/javascript">
$(function(){	    
	  //نمایش ستونها
	  $("input:checkbox:not(:checked)").each(function() {
       var column = "table ." + $(this).attr("name");
       $(column).hide();
      });
      $("input:checkbox").click(function(){
       var column = "table ." + $(this).attr("name");
       $(column).toggle();
      });  
});
</script> 