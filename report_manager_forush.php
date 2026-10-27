<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="report_manager_forush.php";
$ExcelFileName=str_replace('.php','',$FileName);
$titr='گزارش فروش نهاده ها و فرآورده ها';
require_once('head.html');
$kalagroupArr = array(
    "1" => 'ذرت',
    "2" => 'جو',
    "3" => 'سویا',
    "4" => 'مرغ منجمد',
    "5" => 'گوشت منجمد'
	);
//سال قبل
$sal_ghabl=$mtActiveYear-1;
IF($sal_ghabl<1400) $sellYearCode=substr($sal_ghabl,2);
ELSE $sellYearCode=$sal_ghabl;
$sellYearId_ghabl=$db->get_from_where("year_id","sell.dm_year","year_code='$sellYearCode'");
/****************هدر******************/
$columns='
    <tr class="print_table-title2">
     <td width="%" >ردیف</td>
     <td width="%" >کالا</td>
     <td width="%" >تکالیف</td>
     <td width="%" >فروش سال '.$sal_ghabl.'</td>
     <td width="%" >فروش سال '.$mtActiveYear.'</td>
     <td width="%" >فروش در یک روز گذشته</td>

	</tr>';
Function print_header()
{global $titr,$columns,$count,$mt_gl_owner,$code_kala,$code_kala2,$date1,$date2,$code_anbar,$FileName,$page,$kalaName,$db,$kalaName,$code_kala,$Condition;
 echo'
   <table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" >
    <tr class="noExl"><td class="print_title_2" colspan="56">'.$mt_gl_owner.'</td></tr>
	<tr class="noExl"><td class="print_title_2" colspan="56">'.$titr.'
	  <span style="float:left;"><button  class="buttonme hideatprint" onClick="window.location=\''.$FileName.'\'">بازگشت</button></span>
	 </td>
	</tr>
	<tr '; IF($page!=1) echo 'class="noExl"'; echo'>
	 <td class="print_title_2" colspan="56">';
	   IF($page==1){
			 echo'<a href="javascript:window.print();"><span style="float:right" id="printerReport" class="hideatprint" title="چاپ"></span></a>
			      <span style="float:right" id="exportExcel" title="خروجی اکسل" ></span>';
	   }
	   echo'
	    <span >از تاریخ : '.$date1.' تا تاریخ : '.$date2.'&nbsp&nbsp(صفحه : '.$page.')</span>
	  </td>
	 </tr>';
}	
/****************فیلترها روی گزارش******************/
/*******استان ها*******/
if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
{  
 if(is_array($ostanchoice))//کد های استان
 {
   foreach($ostanchoice as $ostan_key => $ostan_val ) 
   {
     $Condition_ostan_temp.=" T.code_ostan='$ostan_val' OR";
     $Condition_ostan_ebtal_temp.=" ebtal.code_ostan='$ostan_val' OR";
     $sell_id_ostan=$db->get_from_where("province_id","sell.dm_province","province_code='$ostan_val'");//تبدیل کد به آی دی
     $Condition_ostan_temp_sell.=" dm_havale.h_id_province='$sell_id_ostan' OR";
	 $Condition_ostan_ebtal_temp_sell.=" dm_his_havale.his_id_province='$sell_id_ostan' OR";
   }
   if($ostan_val==-1){$Condition_ostan.="1=1 OR";$Condition_ostan_ebtal.="1=1 OR";$Condition_ostan_sell.="1=1 OR";}
   else {$Condition_ostan.=" $Condition_ostan_temp";$Condition_ostan_ebtal.=" $Condition_ostan_ebtal_temp";$Condition_ostan_sell.=" $Condition_ostan_temp_sell";}
     $lastSpacePosition = strrpos($Condition_ostan," ");
     $lastSpacePosition_ebtal = strrpos($Condition_ostan_ebtal," ");
     $lastSpacePosition_sell = strrpos($Condition_ostan_sell," ");
     $Condition_ostan =substr($Condition_ostan,0,$lastSpacePosition);
     $Condition_ostan_ebtal =substr($Condition_ostan_ebtal,0,$lastSpacePosition_ebtal);
     $Condition_ostan_sell =substr($Condition_ostan_sell,0,$lastSpacePosition_sell);
      
 }
}
else 
{
	  $Condition_ostan=' T.code_ostan='.$_SESSION['mt_code_ostan'].'';
	  $Condition_ostan_ebtal=' ebtal.code_ostan='.$_SESSION['mt_code_ostan'].'';
	  $sell_id_ostan=$db->get_from_where("province_id","sell.dm_province","province_code='".$_SESSION['mt_code_ostan']."'");//تبدیل کد به آی دی
	  $Condition_ostan_sell=' dm_havale.h_id_province='.$sell_id_ostan.'';
}
/******انبارها******/
if(($_SESSION['mt_all_ostan']==1)or(SuperUser())){$Condition_anbar='1=1';$Condition_anbar_robari_sell='1=1';$Condition_anbar_ebtal='1=1';$Condition_anbar_sell='1=1';}
else //بقیه کاربران براساس انبار قابل دسترسیشان
{ 
 $q_user="SELECT * FROM user_ostan_anbar INNER JOIN list_sardkhane ON list_sardkhane.code_ostan=user_ostan_anbar.code_ostan AND list_sardkhane.code_anbar=user_ostan_anbar.code_anbar WHERE $Condition_movaghat list_sardkhane.code_ostan=".$_SESSION["mt_code_ostan"]." AND user_id=".$_SESSION['mt_user_id']."";
 $res_user=$db->query($q_user);
 while($row_user=$db->fetch_assoc($res_user))//انبارهای قابل دسترسی
 {
   $Condition_anbar_temp.=" T.code_anbar=".$row_user['code_anbar']." OR";
   $Condition_anbar_temp_robari_sell.=" dm_havale.h_robari_code=".$row_user['code_anbar']." OR";
   $Condition_anbar_ebtal_temp.=" ebtal.code_anbar=".$row_user['code_anbar']." OR";
   $sell_id_ostan=$db->get_from_where("province_id","sell.dm_province","province_code=".$_SESSION["mt_code_ostan"]."");//تبدیل کد به آی دی
   $sell_id_anbar=$db->get_from_where("l_id","sell.dm_location_goods","l_id_province=$sell_id_ostan AND l_code=".$row_user['code_anbar']."");//تبدیل کد به آی دی 
   if($sell_id_anbar)//اگر نظیرش در فروش بود
   {$Condition_anbar_temp_sell.=" dm_havale.h_l_code=".$sell_id_anbar." OR";
	$Condition_anbar_ebtal_temp_sell.=" dm_his_havale.his_l_code=".$sell_id_anbar." OR";}
 }
	 $Condition_anbar.="  $Condition_anbar_temp";
	 $Condition_anbar_robari_sell.="  $Condition_anbar_temp_robari_sell";
	 $Condition_anbar_ebtal.="  $Condition_anbar_ebtal_temp";
	 $Condition_anbar_sell.="  $Condition_anbar_temp_sell";
     $lastSpacePosition = strrpos($Condition_anbar," ");
     $lastSpacePosition_robari_sell = strrpos($Condition_anbar_robari_sell," ");
	 $lastSpacePosition_ebtal = strrpos($Condition_anbar_ebtal," ");
     $lastSpacePosition_sell = strrpos($Condition_anbar_sell," ");
     $Condition_anbar =substr($Condition_anbar,0,$lastSpacePosition);
     $Condition_anbar_robari_sell =substr($Condition_anbar_robari_sell,0,$lastSpacePosition_robari_sell);
	 $Condition_anbar_ebtal =substr($Condition_anbar_ebtal,0,$lastSpacePosition_ebtal);
     $Condition_anbar_sell =substr($Condition_anbar_sell,0,$lastSpacePosition_sell);
}
/**************انتخاب گروه کالا****************/
if(is_array($groupkalachoice))
{
 $grpkalaArrChoice=array();//کالاهای انتخاب شده داخل این آرایه قرار میگیرد
 foreach($groupkalachoice as $grp_val) 
 {
  if($grp_val=='همه'){$grpkalaArrChoice=array();$grpkalaArrChoice=$kalagroupArr;break;}
  else array_push($grpkalaArrChoice,$grp_val);
 }
}
/******************وضعیت نمایش اطلاعات انبارهای موقت******************/
// if($show_movaghat==1){$Condition_movaghat="list_sardkhane.situation_type=1 AND "; $Condition_movaghat_mj="l_a.situation_type=1 AND";}
// else if($show_movaghat==2){$Condition_movaghat="";$Condition_movaghat_mj="";}
// else if($show_movaghat==3){$Condition_movaghat="list_sardkhane.situation_type=2 AND ";$Condition_movaghat_mj="";}//خودش موقت ولی مقصد هر انباری
// /******************نمایش یا عدم نمایش انبارهای غیرفعال******************/
// if($chkactivate=='on') {$Condition_anbar_activate=""; $Condition_anbar_activate_mj="";}
// else {$Condition_anbar_activate="list_sardkhane.activate=1 AND"; $Condition_anbar_activate_mj="l_a.activate=1 AND"; }

/***************************************** MAIN*****************************************/
echo'
<body class="openwin" onload="document.myform.date1.focus();">
<form method="post" name="myform">';
if(!$MaxLines)$MaxLines=15; 
//اگر کاربر تاریخ اول را وارد نکرده بود
if(!$date1)$date1=$db->get_from_where("start_from","meat.mt_docs","year='$mtActiveYear'");  
//اگر کاربر تاریخ دوم را وارد نکرده بود
if(!$date2)
{
    $ExcelFileName=str_replace('.php','',$FileName); 
    $end_date_session=$db->get_from_where("end_to","meat.mt_docs","year='$mtActiveYear'");
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
     <!--<td align="left"> از تاریخ : </td><td align="right">&nbsp;<input type="text" class="textboxme2" maxlength="10" name="date1" id="datepickerfrom" placeholder="'.$date1.'"  /></td>-->
     <td align="left"> تاریخ : </td><td align="right" colspan="3">&nbsp;<input type="text" class="textboxme2" maxlength="10" name="date2" id="datepickerto" placeholder="'.$date2.'"/></td>
	</tr>
  
	<tr class="tr1"> 
	 <td align="left" height="40px"> تعداد خط در صفحه : </td><td align="right">&nbsp;<input type="number" class="textboxme2" name="MaxLines" value="'.$MaxLines.'" onkeypress="return isNumber(event)"/></td>';
	 if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
	{
	 echo'
	  <td align="left">نام استان : </td>
      <td align="right" colspan="3">
	   &nbsp;<select name="ostanchoice[]" class="easyui-combobox text4" style="width:200px;" multiple>';
	   $result_ostan = $db->query("SELECT * FROM ostan ORDER BY name_ostan");
       $ostan_options = "<option value='-1' selected>همه استانها</option>";
       while($row_ostan=$db->fetch_assoc($result_ostan)) $ostan_options .= "<option value=".$row_ostan['code_ostan'].">".$row_ostan['name_ostan']."</option>";
	   echo $ostan_options;
	   echo'
	   </select>
	  </td>';
	}
	else echo'<td colspan="2"></td>';
	echo'
	</tr>
    <tr class="tr1"> 
	 <td align="left">گروه کالا : </td>
     <td align="right" colspan="3">
	  &nbsp;<select name="groupkalachoice[]" size="6" style="font-family:bYekan;width:130px;" multiple>
	  <option value="همه" selected>همه کالاها</option>';
	  foreach($kalagroupArr as $grp_key=>$grp_val)
	  {echo '<option value="'.$grp_val.'" >'.$grp_val.'</option>';}
	  echo'
	  </select>
	  <img border="0" src="images/Info1.png" title="دکمه Ctrl کیبورد را نگه دارید و کالاهای مورد نظر خود را انتخاب نمایید" onmouseOver="this.src=\'images/Info_h.png\'" onmouseOut="this.src=\'images/Info1.png\'" style="width:16px;height:16px;cursor:pointer"/>
	  &nbsp;
	 </td>
	</tr>
	<tr class="footer">	
	 <td colspan="4" align="center"><input class="buttonme" type="submit" name="ok" value="شروع گزارش"></td>	</tr> 
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
	 echo'
	 <div class="table2excel">';
	 print_header();
	 /*سطر نمایش فیلترها*/
	 if(($ostanchoice))
	 {
	      if($ostan_val==-1)$filter_string='همه استانها';
	      else $filter_string=' استان : ';
	      foreach($ostanchoice as $ostan_key => $ostan_val) {
	       $nameOstan=$db->get_from_where("name_ostan","ostan","code_ostan='$ostan_val'");
	       $filter_string.=''.$nameOstan.'&nbsp;';
          }
	 } 
	 echo'<tr class="noExl"><td class="filter_text" colspan="50">فیلتر شده براساس : '.$filter_string.'</td></tr>';
	 echo $columns;
     
	 foreach($grpkalaArrChoice as $x => $x_value ) //حلقه روی کالاها
	 { 
	   $sty_dakheli='';
	   $sty_varedati='';
	   $sty_jam='';
	   $line++;
       if($i++%2)echo'<tr class="print_table-odd">';
       else echo'<tr class="print_table-even">';
	   echo'   
		 <td>'.$radif++.'</td>';
		 if($x_value=="مرغ منجمد"){
		  echo '<td>
		         <table width="100%" height="100%" border=1 cellpadding="0" cellspacing="0">
			      <tr>
				   <td width="50%" rowspan="2">'.$x_value.'</td>				 
				   <td>داخلی</td>
				  </tr>
				  <tr>				 
				   <td>وارداتی</td>
				  </tr>
				 </table>
		        </td>';
		 }
		 else if($x_value=="گوشت منجمد"){
		  echo '<td >
		         <table width="100%" height="100%" border=1 cellpadding="0" cellspacing="0">
			      <tr>
				   <td width="50%" rowspan="4">'.$x_value.'</td>				 
				   <td>گوشت گاو داخلی</td>
				  </tr>
				  <tr>				 
				   <td>گوشت گاو وارداتی</td>
				  </tr>
				  <tr>				 
				   <td>گوشت گوسفند داخلی</td>
				  </tr>
				  <tr>				 
				   <td>گوشت گوسفند وارداتی</td>
				  </tr>
				 </table>
			    </td>';
		 }
		 else echo'<td>'.$x_value.'</td>';

		
		 if($x_value=="ذرت")
		 { 
			$kalaCondition_sell=" AND (h_p_code=21 OR h_p_code=1)";
		 }
		 if($x_value=="جو")
		 {
            $kalaCondition_sell=" AND (h_p_code=17 OR h_p_code=11)";
		 }
		 if($x_value=="سویا")
		 {
			$kalaCondition_sell=" AND (h_p_code=2 OR h_p_code=4 OR h_p_code=20 OR h_p_code=19)";
		 }
		 if($x_value=="مرغ منجمد")
		 {
		   //dakheli:38,401,402,403,404,410,411,412,197,198,405,413,414,415,416,266
		   $kalaCondition_morgh_dakheli_sell=" AND (h_p_code=38 OR h_p_code=401 OR h_p_code=402 OR h_p_code=403 OR h_p_code=404 OR h_p_code=410 OR h_p_code=411 OR h_p_code=412 OR h_p_code=197 OR h_p_code=198 OR h_p_code=405 OR h_p_code=413 OR h_p_code=414 OR h_p_code=415 OR h_p_code=416 OR h_p_code=266)";
	       //varedati:154,155,91,35
		   $kalaCondition_morgh_varedati_sell=" AND (h_p_code=154 OR h_p_code=155  OR h_p_code=91 OR h_p_code=35)";
		 }
		 if($x_value=="گوشت منجمد")
		 {
		   //gav_dakheli:81,82,83,84,85,86,89,105,106,107,108,109,40,29,30,31,32,33,34
		   $kalaCondition_gav_dakheli_sell=" AND (h_p_code=81 OR h_p_code=82 OR h_p_code=83 OR h_p_code=84 OR h_p_code=85 OR h_p_code=86 OR h_p_code=89 OR h_p_code=105 OR h_p_code=106 OR h_p_code=107 OR h_p_code=108 OR h_p_code=109 OR h_p_code=40 OR h_p_code=29 OR h_p_code=30 OR h_p_code=31 OR h_p_code=32 OR h_p_code=33 OR h_p_code=34)";
	       //gav_varedati:72,73,74,75,76,77,78,79,92,65,66,67,68,69
		   $kalaCondition_gav_varedati_sell=" AND (h_p_code=72 OR h_p_code=73 OR h_p_code=74 OR h_p_code=75 OR h_p_code=76 OR h_p_code=77 OR h_p_code=78 OR h_p_code=79 OR h_p_code=92 OR h_p_code=65 OR h_p_code=66 OR h_p_code=67 OR h_p_code=68 OR h_p_code=69)";
	       //goosfand_dakheli:144,148,149,150,151,88,90,205,206,207,208,209,210,41,42,43,44,45,46
		   $kalaCondition_goosfand_dakheli_sell=" AND (h_p_code=144 OR h_p_code=148 OR h_p_code=149 OR h_p_code=150 OR h_p_code=151 OR h_p_code=88 OR h_p_code=90 OR h_p_code=205 OR h_p_code=206 OR h_p_code=207 OR h_p_code=208 OR h_p_code=209 OR h_p_code=210 OR h_p_code=41 OR h_p_code=42 OR h_p_code=43 OR h_p_code=44 OR h_p_code=45)";
		   //goosfand_varedati:87,60,61,62,63,64,113,173,174
		   $kalaCondition_goosfand_varedati_sell=" AND (h_p_code=87 OR h_p_code=60 OR h_p_code=61 OR h_p_code=62 OR h_p_code=63 OR h_p_code=64 OR h_p_code=113 OR h_p_code=173 OR h_p_code=174)";	 
		 }
		 
        /****************/
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
     

		  //یک روز گذشته
		  $date2_milady_one_day = strtotime ( '-1 day' , strtotime ( $date2_milady ) ) ;//1 day ago
          $date2_milady_one_day = date ( 'Y-m-j' , $date2_milady_one_day );


		  if($x_value=="مرغ منجمد")
		  {
		   //////////////////////////////////////مرغ داخلی////////////////////////////////////////
		   //مقدار کل حواله فروش ها پارسال
		    $havale_forush_parsal_morgh_dakheli=$db->get_from_where("SUM(h_pre_amount)","sell.dm_havale"," h_id_year='$sellYearId_ghabl' $kalaCondition_morgh_dakheli_sell and($Condition_ostan_sell)");
		   //مقدار کل ابطالی ها 
		    $q_ebtal_parsal_dakheli="SELECT SUM(his_eb_amount) FROM sell.dm_his_havale 
	             INNER JOIN sell.dm_havale ON dm_his_havale.his_h_id=dm_havale.h_id
	             INNER JOIN sell.dm_ebtal_h ON dm_his_havale.his_id=dm_ebtal_h.ebh_h_id
			 	 WHERE h_id_year='$sellYearId_ghabl' $kalaCondition_morgh_dakheli_sell AND($Condition_ostan_sell)";
		    $res_ebtal_parsal_dakheli=$db->query($q_ebtal_parsal_dakheli);
	        $meghdar_ebtali_parsal_dakheli=$db->fetch_array($res_ebtal_parsal_dakheli);
		    $meghdar_ebtali_parsal_morgh_dakheli=$meghdar_ebtali_parsal_dakheli[0];
		    $meghdar_forush_parsal_morgh_dakheli=$havale_forush_parsal_morgh_dakheli-$meghdar_ebtali_parsal_morgh_dakheli;
		   //////////////////////////////////////////////////////////////////////////////
		   //مقدار کل حواله فروش ها امسال
		    $havale_forush_emsal_morgh_dakheli=$db->get_from_where("SUM(h_pre_amount)","sell.dm_havale"," h_id_year='$sellYearId' AND h_reg_date>='$mtStartDateMi' AND h_reg_date>='$date1_milady' AND h_reg_date<='$date2_milady' $kalaCondition_morgh_dakheli_sell and($Condition_ostan_sell)");
		   //مقدار کل ابطالی ها 
		    $q_ebtal_emsal_dakheli="SELECT SUM(his_eb_amount) FROM sell.dm_his_havale 
	             INNER JOIN sell.dm_havale ON dm_his_havale.his_h_id=dm_havale.h_id
	             INNER JOIN sell.dm_ebtal_h ON dm_his_havale.his_id=dm_ebtal_h.ebh_h_id
			 	 WHERE  dm_ebtal_h.ebh_reg_date>='$mtStartDateMi' AND dm_havale.h_reg_date>='$mtStartDateMi' AND h_id_year='$sellYearId' AND ebh_reg_date>='$date1_milady' AND ebh_reg_date<='$date2_milady' $kalaCondition_morgh_dakheli_sell AND($Condition_ostan_sell)";
		    $res_ebtal_emsal_dakheli=$db->query($q_ebtal_emsal_dakheli);
	        $meghdar_ebtali_emsal_dakheli=$db->fetch_array($res_ebtal_emsal_dakheli);
		    $meghdar_ebtali_emsal_morgh_dakheli=$meghdar_ebtali_emsal_dakheli[0];
		    $meghdar_forush_emsal_morgh_dakheli=$havale_forush_emsal_morgh_dakheli-$meghdar_ebtali_emsal_morgh_dakheli;
		    //////////////////////////////////////////////////////////////////////////////
		    //مقدار کل حواله فروش ها یک روز گذشته
		    $havale_forush_rouz_morgh_dakheli=$db->get_from_where("SUM(h_pre_amount)","sell.dm_havale"," h_id_year='$sellYearId' AND h_reg_date>='$date2_milady_one_day' AND h_reg_date<='$date2_milady' $kalaCondition_morgh_dakheli_sell and($Condition_ostan_sell)");
		    //مقدار کل ابطالی ها 
		    $q_ebtal_rouz_dakheli="SELECT SUM(his_eb_amount) FROM sell.dm_his_havale 
	             INNER JOIN sell.dm_havale ON dm_his_havale.his_h_id=dm_havale.h_id
	             INNER JOIN sell.dm_ebtal_h ON dm_his_havale.his_id=dm_ebtal_h.ebh_h_id
			 	 WHERE  dm_ebtal_h.ebh_reg_date>='$mtStartDateMi'  AND h_id_year='$sellYearId' AND ebh_reg_date>='$date2_milady_one_day' AND ebh_reg_date<='$date2_milady' $kalaCondition_morgh_dakheli_sell AND($Condition_ostan_sell)";
		    $res_ebtal_rouz_dakheli=$db->query($q_ebtal_rouz_dakheli);
	        $meghdar_ebtali_rouz_dakheli=$db->fetch_array($res_ebtal_rouz_dakheli);
		    $meghdar_ebtali_rouz_morgh_dakheli=$meghdar_ebtali_rouz_dakheli[0];
		    $meghdar_forush_rouz_morgh_dakheli=$havale_forush_rouz_morgh_dakheli-$meghdar_ebtali_rouz_morgh_dakheli;
		   
		   //////////////////////////////////////مرغ وارداتی////////////////////////////////////////
		   //مقدار کل حواله فروش ها پارسال
		    $havale_forush_parsal_morgh_varedati=$db->get_from_where("SUM(h_pre_amount)","sell.dm_havale"," h_id_year='$sellYearId_ghabl' $kalaCondition_morgh_varedati_sell and($Condition_ostan_sell)");
		   //مقدار کل ابطالی ها 
		    $q_ebtal_parsal_varedati="SELECT SUM(his_eb_amount) FROM sell.dm_his_havale 
	             INNER JOIN sell.dm_havale ON dm_his_havale.his_h_id=dm_havale.h_id
	             INNER JOIN sell.dm_ebtal_h ON dm_his_havale.his_id=dm_ebtal_h.ebh_h_id
			 	 WHERE h_id_year='$sellYearId_ghabl' $kalaCondition_morgh_varedati_sell AND($Condition_ostan_sell)";
		    $res_ebtal_parsal_varedati=$db->query($q_ebtal_parsal_varedati);
	        $meghdar_ebtali_parsal_varedati=$db->fetch_array($res_ebtal_parsal_varedati);
		    $meghdar_ebtali_parsal_morgh_varedati=$meghdar_ebtali_parsal_varedati[0];
		    $meghdar_forush_parsal_morgh_varedati=$havale_forush_parsal_morgh_varedati-$meghdar_ebtali_parsal_morgh_varedati;
		   //////////////////////////////////////////////////////////////////////////////
		   //مقدار کل حواله فروش ها امسال
		    $havale_forush_emsal_morgh_varedati=$db->get_from_where("SUM(h_pre_amount)","sell.dm_havale"," h_id_year='$sellYearId' AND h_reg_date>='$mtStartDateMi' AND h_reg_date>='$date1_milady' AND h_reg_date<='$date2_milady' $kalaCondition_morgh_varedati_sell and($Condition_ostan_sell)");
		   //مقدار کل ابطالی ها 
		    $q_ebtal_emsal_varedati="SELECT SUM(his_eb_amount) FROM sell.dm_his_havale 
	             INNER JOIN sell.dm_havale ON dm_his_havale.his_h_id=dm_havale.h_id
	             INNER JOIN sell.dm_ebtal_h ON dm_his_havale.his_id=dm_ebtal_h.ebh_h_id
			 	 WHERE  dm_ebtal_h.ebh_reg_date>='$mtStartDateMi' AND dm_havale.h_reg_date>='$mtStartDateMi' AND h_id_year='$sellYearId' AND ebh_reg_date>='$date1_milady' AND ebh_reg_date<='$date2_milady' $kalaCondition_morgh_varedati_sell AND($Condition_ostan_sell)";
		    $res_ebtal_emsal_varedati=$db->query($q_ebtal_emsal_varedati);
	        $meghdar_ebtali_emsal_varedati=$db->fetch_array($res_ebtal_emsal_varedati);
		    $meghdar_ebtali_emsal_morgh_varedati=$meghdar_ebtali_emsal_varedati[0];
		    $meghdar_forush_emsal_morgh_varedati=$havale_forush_emsal_morgh_varedati-$meghdar_ebtali_emsal_morgh_varedati;
		    //////////////////////////////////////////////////////////////////////////////
		    //مقدار کل حواله فروش ها یک روز گذشته
		    $havale_forush_rouz_morgh_varedati=$db->get_from_where("SUM(h_pre_amount)","sell.dm_havale"," h_id_year='$sellYearId' AND h_reg_date>='$date2_milady_one_day' AND h_reg_date<='$date2_milady' $kalaCondition_morgh_varedati_sell and($Condition_ostan_sell)");
		    //مقدار کل ابطالی ها 
		    $q_ebtal_rouz_varedati="SELECT SUM(his_eb_amount) FROM sell.dm_his_havale 
	             INNER JOIN sell.dm_havale ON dm_his_havale.his_h_id=dm_havale.h_id
	             INNER JOIN sell.dm_ebtal_h ON dm_his_havale.his_id=dm_ebtal_h.ebh_h_id
			 	 WHERE  dm_ebtal_h.ebh_reg_date>='$mtStartDateMi'  AND h_id_year='$sellYearId' AND ebh_reg_date>='$date2_milady_one_day' AND ebh_reg_date<='$date2_milady' $kalaCondition_morgh_varedati_sell AND($Condition_ostan_sell)";
		    $res_ebtal_rouz_varedati=$db->query($q_ebtal_rouz_varedati);
	        $meghdar_ebtali_rouz_varedati=$db->fetch_array($res_ebtal_rouz_varedati);
		    $meghdar_ebtali_rouz_morgh_varedati=$meghdar_ebtali_rouz_varedati[0];
		    $meghdar_forush_rouz_morgh_varedati=$havale_forush_rouz_morgh_varedati-$meghdar_ebtali_rouz_morgh_varedati;
		  
		  }
		  if($x_value=="گوشت منجمد")
		  {
		   //////////////////////////////////////گاو داخلی////////////////////////////////////////
		   //مقدار کل حواله فروش ها پارسال
		    $havale_forush_parsal_gav_dakheli=$db->get_from_where("SUM(h_pre_amount)","sell.dm_havale"," h_id_year='$sellYearId_ghabl' $kalaCondition_gav_dakheli_sell and($Condition_ostan_sell)");
		   //مقدار کل ابطالی ها 
		    $q_ebtal_parsal_dakheli="SELECT SUM(his_eb_amount) FROM sell.dm_his_havale 
	             INNER JOIN sell.dm_havale ON dm_his_havale.his_h_id=dm_havale.h_id
	             INNER JOIN sell.dm_ebtal_h ON dm_his_havale.his_id=dm_ebtal_h.ebh_h_id
			 	 WHERE h_id_year='$sellYearId_ghabl' $kalaCondition_gav_dakheli_sell AND($Condition_ostan_sell)";
		    $res_ebtal_parsal_dakheli=$db->query($q_ebtal_parsal_dakheli);
	        $meghdar_ebtali_parsal_dakheli=$db->fetch_array($res_ebtal_parsal_dakheli);
		    $meghdar_ebtali_parsal_gav_dakheli=$meghdar_ebtali_parsal_dakheli[0];
		    $meghdar_forush_parsal_gav_dakheli=$havale_forush_parsal_gav_dakheli-$meghdar_ebtali_parsal_gav_dakheli;
		   //////////////////////////////////////////////////////////////////////////////
		   //مقدار کل حواله فروش ها امسال
		    $havale_forush_emsal_gav_dakheli=$db->get_from_where("SUM(h_pre_amount)","sell.dm_havale"," h_id_year='$sellYearId' AND h_reg_date>='$mtStartDateMi' AND h_reg_date>='$date1_milady' AND h_reg_date<='$date2_milady' $kalaCondition_gav_dakheli_sell and($Condition_ostan_sell)");
		   //مقدار کل ابطالی ها 
		    $q_ebtal_emsal_dakheli="SELECT SUM(his_eb_amount) FROM sell.dm_his_havale 
	             INNER JOIN sell.dm_havale ON dm_his_havale.his_h_id=dm_havale.h_id
	             INNER JOIN sell.dm_ebtal_h ON dm_his_havale.his_id=dm_ebtal_h.ebh_h_id
			 	 WHERE  dm_ebtal_h.ebh_reg_date>='$mtStartDateMi' AND dm_havale.h_reg_date>='$mtStartDateMi' AND h_id_year='$sellYearId' AND ebh_reg_date>='$date1_milady' AND ebh_reg_date<='$date2_milady' $kalaCondition_gav_dakheli_sell AND($Condition_ostan_sell)";
		    $res_ebtal_emsal_dakheli=$db->query($q_ebtal_emsal_dakheli);
	        $meghdar_ebtali_emsal_dakheli=$db->fetch_array($res_ebtal_emsal_dakheli);
		    $meghdar_ebtali_emsal_gav_dakheli=$meghdar_ebtali_emsal_dakheli[0];
		    $meghdar_forush_emsal_gav_dakheli=$havale_forush_emsal_gav_dakheli-$meghdar_ebtali_emsal_gav_dakheli;
		    //////////////////////////////////////////////////////////////////////////////
		    //مقدار کل حواله فروش ها یک روز گذشته
		    $havale_forush_rouz_gav_dakheli=$db->get_from_where("SUM(h_pre_amount)","sell.dm_havale"," h_id_year='$sellYearId' AND h_reg_date>='$date2_milady_one_day' AND h_reg_date<='$date2_milady' $kalaCondition_gav_dakheli_sell and($Condition_ostan_sell)");
		    //مقدار کل ابطالی ها 
		    $q_ebtal_rouz_dakheli="SELECT SUM(his_eb_amount) FROM sell.dm_his_havale 
	             INNER JOIN sell.dm_havale ON dm_his_havale.his_h_id=dm_havale.h_id
	             INNER JOIN sell.dm_ebtal_h ON dm_his_havale.his_id=dm_ebtal_h.ebh_h_id
			 	 WHERE  dm_ebtal_h.ebh_reg_date>='$mtStartDateMi'  AND h_id_year='$sellYearId' AND ebh_reg_date>='$date2_milady_one_day' AND ebh_reg_date<='$date2_milady' $kalaCondition_gav_dakheli_sell AND($Condition_ostan_sell)";
		    $res_ebtal_rouz_dakheli=$db->query($q_ebtal_rouz_dakheli);
	        $meghdar_ebtali_rouz_dakheli=$db->fetch_array($res_ebtal_rouz_dakheli);
		    $meghdar_ebtali_rouz_gav_dakheli=$meghdar_ebtali_rouz_dakheli[0];
		    $meghdar_forush_rouz_gav_dakheli=$havale_forush_rouz_gav_dakheli-$meghdar_ebtali_rouz_gav_dakheli;
		   
		   //////////////////////////////////////گاو وارداتی////////////////////////////////////////
		   //مقدار کل حواله فروش ها پارسال
		    $havale_forush_parsal_gav_varedati=$db->get_from_where("SUM(h_pre_amount)","sell.dm_havale"," h_id_year='$sellYearId_ghabl' $kalaCondition_gav_varedati_sell and($Condition_ostan_sell)");
		   //مقدار کل ابطالی ها 
		    $q_ebtal_parsal_varedati="SELECT SUM(his_eb_amount) FROM sell.dm_his_havale 
	             INNER JOIN sell.dm_havale ON dm_his_havale.his_h_id=dm_havale.h_id
	             INNER JOIN sell.dm_ebtal_h ON dm_his_havale.his_id=dm_ebtal_h.ebh_h_id
			 	 WHERE h_id_year='$sellYearId_ghabl' $kalaCondition_gav_varedati_sell AND($Condition_ostan_sell)";
		    $res_ebtal_parsal_varedati=$db->query($q_ebtal_parsal_varedati);
	        $meghdar_ebtali_parsal_varedati=$db->fetch_array($res_ebtal_parsal_varedati);
		    $meghdar_ebtali_parsal_gav_varedati=$meghdar_ebtali_parsal_varedati[0];
		    $meghdar_forush_parsal_gav_varedati=$havale_forush_parsal_gav_varedati-$meghdar_ebtali_parsal_gav_varedati;
		   //////////////////////////////////////////////////////////////////////////////
		   //مقدار کل حواله فروش ها امسال
		    $havale_forush_emsal_gav_varedati=$db->get_from_where("SUM(h_pre_amount)","sell.dm_havale"," h_id_year='$sellYearId' AND h_reg_date>='$mtStartDateMi' AND h_reg_date>='$date1_milady' AND h_reg_date<='$date2_milady' $kalaCondition_gav_varedati_sell and($Condition_ostan_sell)");
		   //مقدار کل ابطالی ها 
		    $q_ebtal_emsal_varedati="SELECT SUM(his_eb_amount) FROM sell.dm_his_havale 
	             INNER JOIN sell.dm_havale ON dm_his_havale.his_h_id=dm_havale.h_id
	             INNER JOIN sell.dm_ebtal_h ON dm_his_havale.his_id=dm_ebtal_h.ebh_h_id
			 	 WHERE  dm_ebtal_h.ebh_reg_date>='$mtStartDateMi' AND dm_havale.h_reg_date>='$mtStartDateMi' AND h_id_year='$sellYearId' AND ebh_reg_date>='$date1_milady' AND ebh_reg_date<='$date2_milady' $kalaCondition_gav_varedati_sell AND($Condition_ostan_sell)";
		    $res_ebtal_emsal_varedati=$db->query($q_ebtal_emsal_varedati);
	        $meghdar_ebtali_emsal_varedati=$db->fetch_array($res_ebtal_emsal_varedati);
		    $meghdar_ebtali_emsal_gav_varedati=$meghdar_ebtali_emsal_varedati[0];
		    $meghdar_forush_emsal_gav_varedati=$havale_forush_emsal_gav_varedati-$meghdar_ebtali_emsal_gav_varedati;
		    //////////////////////////////////////////////////////////////////////////////
		    //مقدار کل حواله فروش ها یک روز گذشته
		    $havale_forush_rouz_gav_varedati=$db->get_from_where("SUM(h_pre_amount)","sell.dm_havale"," h_id_year='$sellYearId' AND h_reg_date>='$date2_milady_one_day' AND h_reg_date<='$date2_milady' $kalaCondition_gav_varedati_sell and($Condition_ostan_sell)");
		    //مقدار کل ابطالی ها 
		    $q_ebtal_rouz_varedati="SELECT SUM(his_eb_amount) FROM sell.dm_his_havale 
	             INNER JOIN sell.dm_havale ON dm_his_havale.his_h_id=dm_havale.h_id
	             INNER JOIN sell.dm_ebtal_h ON dm_his_havale.his_id=dm_ebtal_h.ebh_h_id
			 	 WHERE  dm_ebtal_h.ebh_reg_date>='$mtStartDateMi'  AND h_id_year='$sellYearId' AND ebh_reg_date>='$date2_milady_one_day' AND ebh_reg_date<='$date2_milady' $kalaCondition_gav_varedati_sell AND($Condition_ostan_sell)";
		    $res_ebtal_rouz_varedati=$db->query($q_ebtal_rouz_varedati);
	        $meghdar_ebtali_rouz_varedati=$db->fetch_array($res_ebtal_rouz_varedati);
		    $meghdar_ebtali_rouz_gav_varedati=$meghdar_ebtali_rouz_varedati[0];
		    $meghdar_forush_rouz_gav_varedati=$havale_forush_rouz_gav_varedati-$meghdar_ebtali_rouz_gav_varedati;
		    
		   //////////////////////////////////////گوسفند داخلی////////////////////////////////////////
		   //مقدار کل حواله فروش ها پارسال
		    $havale_forush_parsal_goosfand_dakheli=$db->get_from_where("SUM(h_pre_amount)","sell.dm_havale"," h_id_year='$sellYearId_ghabl' $kalaCondition_goosfand_dakheli_sell and($Condition_ostan_sell)");
		   //مقدار کل ابطالی ها 
		    $q_ebtal_parsal_dakheli="SELECT SUM(his_eb_amount) FROM sell.dm_his_havale 
	             INNER JOIN sell.dm_havale ON dm_his_havale.his_h_id=dm_havale.h_id
	             INNER JOIN sell.dm_ebtal_h ON dm_his_havale.his_id=dm_ebtal_h.ebh_h_id
			 	 WHERE h_id_year='$sellYearId_ghabl' $kalaCondition_goosfand_dakheli_sell AND($Condition_ostan_sell)";
		    $res_ebtal_parsal_dakheli=$db->query($q_ebtal_parsal_dakheli);
	        $meghdar_ebtali_parsal_dakheli=$db->fetch_array($res_ebtal_parsal_dakheli);
		    $meghdar_ebtali_parsal_goosfand_dakheli=$meghdar_ebtali_parsal_dakheli[0];
		    $meghdar_forush_parsal_goosfand_dakheli=$havale_forush_parsal_goosfand_dakheli-$meghdar_ebtali_parsal_goosfand_dakheli;
		   //////////////////////////////////////////////////////////////////////////////
		   //مقدار کل حواله فروش ها امسال
		    $havale_forush_emsal_goosfand_dakheli=$db->get_from_where("SUM(h_pre_amount)","sell.dm_havale"," h_id_year='$sellYearId' AND h_reg_date>='$mtStartDateMi' AND h_reg_date>='$date1_milady' AND h_reg_date<='$date2_milady' $kalaCondition_goosfand_dakheli_sell and($Condition_ostan_sell)");
		   //مقدار کل ابطالی ها 
		    $q_ebtal_emsal_dakheli="SELECT SUM(his_eb_amount) FROM sell.dm_his_havale 
	             INNER JOIN sell.dm_havale ON dm_his_havale.his_h_id=dm_havale.h_id
	             INNER JOIN sell.dm_ebtal_h ON dm_his_havale.his_id=dm_ebtal_h.ebh_h_id
			 	 WHERE  dm_ebtal_h.ebh_reg_date>='$mtStartDateMi' AND dm_havale.h_reg_date>='$mtStartDateMi' AND h_id_year='$sellYearId' AND ebh_reg_date>='$date1_milady' AND ebh_reg_date<='$date2_milady' $kalaCondition_goosfand_dakheli_sell AND($Condition_ostan_sell)";
		    $res_ebtal_emsal_dakheli=$db->query($q_ebtal_emsal_dakheli);
	        $meghdar_ebtali_emsal_dakheli=$db->fetch_array($res_ebtal_emsal_dakheli);
		    $meghdar_ebtali_emsal_goosfand_dakheli=$meghdar_ebtali_emsal_dakheli[0];
		    $meghdar_forush_emsal_goosfand_dakheli=$havale_forush_emsal_goosfand_dakheli-$meghdar_ebtali_emsal_goosfand_dakheli;
		    //////////////////////////////////////////////////////////////////////////////
		    //مقدار کل حواله فروش ها یک روز گذشته
		    $havale_forush_rouz_goosfand_dakheli=$db->get_from_where("SUM(h_pre_amount)","sell.dm_havale"," h_id_year='$sellYearId' AND h_reg_date>='$date2_milady_one_day' AND h_reg_date<='$date2_milady' $kalaCondition_goosfand_dakheli_sell and($Condition_ostan_sell)");
		    //مقدار کل ابطالی ها 
		    $q_ebtal_rouz_dakheli="SELECT SUM(his_eb_amount) FROM sell.dm_his_havale 
	             INNER JOIN sell.dm_havale ON dm_his_havale.his_h_id=dm_havale.h_id
	             INNER JOIN sell.dm_ebtal_h ON dm_his_havale.his_id=dm_ebtal_h.ebh_h_id
			 	 WHERE  dm_ebtal_h.ebh_reg_date>='$mtStartDateMi'  AND h_id_year='$sellYearId' AND ebh_reg_date>='$date2_milady_one_day' AND ebh_reg_date<='$date2_milady' $kalaCondition_goosfand_dakheli_sell AND($Condition_ostan_sell)";
		    $res_ebtal_rouz_dakheli=$db->query($q_ebtal_rouz_dakheli);
	        $meghdar_ebtali_rouz_dakheli=$db->fetch_array($res_ebtal_rouz_dakheli);
		    $meghdar_ebtali_rouz_goosfand_dakheli=$meghdar_ebtali_rouz_dakheli[0];
		    $meghdar_forush_rouz_goosfand_dakheli=$havale_forush_rouz_goosfand_dakheli-$meghdar_ebtali_rouz_goosfand_dakheli;
		   
		   //////////////////////////////////////گوسفند وارداتی////////////////////////////////////////
		   //مقدار کل حواله فروش ها پارسال
		    $havale_forush_parsal_goosfand_varedati=$db->get_from_where("SUM(h_pre_amount)","sell.dm_havale"," h_id_year='$sellYearId_ghabl' $kalaCondition_goosfand_varedati_sell and($Condition_ostan_sell)");
		   //مقدار کل ابطالی ها 
		    $q_ebtal_parsal_varedati="SELECT SUM(his_eb_amount) FROM sell.dm_his_havale 
	             INNER JOIN sell.dm_havale ON dm_his_havale.his_h_id=dm_havale.h_id
	             INNER JOIN sell.dm_ebtal_h ON dm_his_havale.his_id=dm_ebtal_h.ebh_h_id
			 	 WHERE h_id_year='$sellYearId_ghabl' $kalaCondition_goosfand_varedati_sell AND($Condition_ostan_sell)";
		    $res_ebtal_parsal_varedati=$db->query($q_ebtal_parsal_varedati);
	        $meghdar_ebtali_parsal_varedati=$db->fetch_array($res_ebtal_parsal_varedati);
		    $meghdar_ebtali_parsal_goosfand_varedati=$meghdar_ebtali_parsal_varedati[0];
		    $meghdar_forush_parsal_goosfand_varedati=$havale_forush_parsal_goosfand_varedati-$meghdar_ebtali_parsal_goosfand_varedati;
		   //////////////////////////////////////////////////////////////////////////////
		   //مقدار کل حواله فروش ها امسال
		    $havale_forush_emsal_goosfand_varedati=$db->get_from_where("SUM(h_pre_amount)","sell.dm_havale"," h_id_year='$sellYearId' AND h_reg_date>='$mtStartDateMi' AND h_reg_date>='$date1_milady' AND h_reg_date<='$date2_milady' $kalaCondition_goosfand_varedati_sell and($Condition_ostan_sell)");
		   //مقدار کل ابطالی ها 
		    $q_ebtal_emsal_varedati="SELECT SUM(his_eb_amount) FROM sell.dm_his_havale 
	             INNER JOIN sell.dm_havale ON dm_his_havale.his_h_id=dm_havale.h_id
	             INNER JOIN sell.dm_ebtal_h ON dm_his_havale.his_id=dm_ebtal_h.ebh_h_id
			 	 WHERE  dm_ebtal_h.ebh_reg_date>='$mtStartDateMi' AND dm_havale.h_reg_date>='$mtStartDateMi' AND h_id_year='$sellYearId' AND ebh_reg_date>='$date1_milady' AND ebh_reg_date<='$date2_milady' $kalaCondition_goosfand_varedati_sell AND($Condition_ostan_sell)";
		    $res_ebtal_emsal_varedati=$db->query($q_ebtal_emsal_varedati);
	        $meghdar_ebtali_emsal_varedati=$db->fetch_array($res_ebtal_emsal_varedati);
		    $meghdar_ebtali_emsal_goosfand_varedati=$meghdar_ebtali_emsal_varedati[0];
		    $meghdar_forush_emsal_goosfand_varedati=$havale_forush_emsal_goosfand_varedati-$meghdar_ebtali_emsal_goosfand_varedati;
		    //////////////////////////////////////////////////////////////////////////////
		    //مقدار کل حواله فروش ها یک روز گذشته
		    $havale_forush_rouz_goosfand_varedati=$db->get_from_where("SUM(h_pre_amount)","sell.dm_havale"," h_id_year='$sellYearId' AND h_reg_date>='$date2_milady_one_day' AND h_reg_date<='$date2_milady' $kalaCondition_goosfand_varedati_sell and($Condition_ostan_sell)");
		    //مقدار کل ابطالی ها 
		    $q_ebtal_rouz_varedati="SELECT SUM(his_eb_amount) FROM sell.dm_his_havale 
	             INNER JOIN sell.dm_havale ON dm_his_havale.his_h_id=dm_havale.h_id
	             INNER JOIN sell.dm_ebtal_h ON dm_his_havale.his_id=dm_ebtal_h.ebh_h_id
			 	 WHERE  dm_ebtal_h.ebh_reg_date>='$mtStartDateMi'  AND h_id_year='$sellYearId' AND ebh_reg_date>='$date2_milady_one_day' AND ebh_reg_date<='$date2_milady' $kalaCondition_goosfand_varedati_sell AND($Condition_ostan_sell)";
		    $res_ebtal_rouz_varedati=$db->query($q_ebtal_rouz_varedati);
	        $meghdar_ebtali_rouz_varedati=$db->fetch_array($res_ebtal_rouz_varedati);
		    $meghdar_ebtali_rouz_goosfand_varedati=$meghdar_ebtali_rouz_varedati[0];
		    $meghdar_forush_rouz_goosfand_varedati=$havale_forush_rouz_goosfand_varedati-$meghdar_ebtali_rouz_goosfand_varedati;
		      
			  
		   
		  }
		  else //ذرت - جو - سویا
		  {
		  //مقدار کل حواله فروش ها پارسال
		   $havale_forush_parsal=$db->get_from_where("SUM(h_pre_amount)","sell.dm_havale"," h_id_year='$sellYearId_ghabl' $kalaCondition_sell and($Condition_ostan_sell)");
		  //مقدار کل ابطالی ها 
		   $q_ebtal_parsal="SELECT SUM(his_eb_amount) FROM sell.dm_his_havale 
	            INNER JOIN sell.dm_havale ON dm_his_havale.his_h_id=dm_havale.h_id
	            INNER JOIN sell.dm_ebtal_h ON dm_his_havale.his_id=dm_ebtal_h.ebh_h_id
				WHERE h_id_year='$sellYearId_ghabl' $kalaCondition_sell AND($Condition_ostan_sell)";
		   $res_ebtal_parsal=$db->query($q_ebtal_parsal);
	       $meghdar_ebtali_parsal=$db->fetch_array($res_ebtal_parsal);
		   $meghdar_ebtali_parsal=$meghdar_ebtali_parsal[0];
		   $meghdar_forush_parsal=$havale_forush_parsal-$meghdar_ebtali_parsal;
		  //////////////////////////////////////////////////////////////////////////////
		  //مقدار کل حواله فروش ها امسال
		   $havale_forush_emsal=$db->get_from_where("SUM(h_pre_amount)","sell.dm_havale"," h_id_year='$sellYearId' AND h_reg_date>='$mtStartDateMi' AND h_reg_date>='$date1_milady' AND h_reg_date<='$date2_milady' $kalaCondition_sell and($Condition_ostan_sell)");
		  //مقدار کل ابطالی ها 
		   $q_ebtal_emsal="SELECT SUM(his_eb_amount) FROM sell.dm_his_havale 
	            INNER JOIN sell.dm_havale ON dm_his_havale.his_h_id=dm_havale.h_id
	            INNER JOIN sell.dm_ebtal_h ON dm_his_havale.his_id=dm_ebtal_h.ebh_h_id
				WHERE  dm_ebtal_h.ebh_reg_date>='$mtStartDateMi' AND dm_havale.h_reg_date>='$mtStartDateMi' AND h_id_year='$sellYearId' AND ebh_reg_date>='$date1_milady' AND ebh_reg_date<='$date2_milady' $kalaCondition_sell AND($Condition_ostan_sell)";
		   $res_ebtal_emsal=$db->query($q_ebtal_emsal);
	       $meghdar_ebtali_emsal=$db->fetch_array($res_ebtal_emsal);
		   $meghdar_ebtali_emsal=$meghdar_ebtali_emsal[0];
		   $meghdar_forush_emsal=$havale_forush_emsal-$meghdar_ebtali_emsal;
		   //////////////////////////////////////////////////////////////////////////////
		   //مقدار کل حواله فروش ها یک روز گذشته
		   $havale_forush_rouz=$db->get_from_where("SUM(h_pre_amount)","sell.dm_havale"," h_id_year='$sellYearId' AND h_reg_date>='$date2_milady_one_day' AND h_reg_date<='$date2_milady' $kalaCondition_sell and($Condition_ostan_sell)");
		   //مقدار کل ابطالی ها 
		   $q_ebtal_rouz="SELECT SUM(his_eb_amount) FROM sell.dm_his_havale 
	            INNER JOIN sell.dm_havale ON dm_his_havale.his_h_id=dm_havale.h_id
	            INNER JOIN sell.dm_ebtal_h ON dm_his_havale.his_id=dm_ebtal_h.ebh_h_id
				WHERE  dm_ebtal_h.ebh_reg_date>='$mtStartDateMi'  AND h_id_year='$sellYearId' AND ebh_reg_date>='$date2_milady_one_day' AND ebh_reg_date<='$date2_milady' $kalaCondition_sell AND($Condition_ostan_sell)";
		   $res_ebtal_rouz=$db->query($q_ebtal_rouz);
	       $meghdar_ebtali_rouz=$db->fetch_array($res_ebtal_rouz);
		   $meghdar_ebtali_rouz=$meghdar_ebtali_rouz[0];
		   $meghdar_forush_rouz=$havale_forush_rouz-$meghdar_ebtali_rouz;
          }
		 //نمایش اطلاعات
		 if($x_value=="مرغ منجمد"){
		  echo '
		  		<td>'.virgul($takalif).'</td>
		        <td>
		         <table  width="100%" height="100%" cellpadding="0" cellspacing="0">
			      <tr><td style="border-bottom: 1px solid black;">'.virgul($meghdar_forush_parsal_morgh_dakheli).'</td></tr>
			      <tr><td>'.virgul($meghdar_forush_parsal_morgh_varedati).'</td></tr>
				 </table>
		        </td>
				<td>
		         <table  width="100%" height="100%" cellpadding="0" cellspacing="0">
			      <tr><td style="border-bottom: 1px solid black;">'.virgul($meghdar_forush_emsal_morgh_dakheli).'</td></tr>
			      <tr><td>'.virgul($meghdar_forush_emsal_morgh_varedati).'</td></tr>
				 </table>
		        </td>
				<td>
		         <table  width="100%" height="100%"  cellpadding="0" cellspacing="0">
			      <tr><td style="border-bottom: 1px solid black;">'.virgul($meghdar_forush_rouz_morgh_dakheli).'</td></tr>
			      <tr><td>'.virgul($meghdar_forush_rouz_morgh_varedati).'</td></tr>
				 </table>
		        </td>';
		 }
		 else if($x_value=="گوشت منجمد"){
		  echo '
		        <td>'.virgul($takalif).'</td>
		        <td>
		         <table  width="100%" height="100%" cellpadding="0" cellspacing="0">
			      <tr><td style="border-bottom: 1px solid black;">'.virgul($meghdar_forush_parsal_gav_dakheli).'</td></tr>
			      <tr><td style="border-bottom: 1px solid black;">'.virgul($meghdar_forush_parsal_gav_varedati).'</td></tr>
			      <tr><td style="border-bottom: 1px solid black;">'.virgul($meghdar_forush_parsal_goosfand_dakheli).'</td></tr>
			      <tr><td>'.virgul($meghdar_forush_parsal_goosfand_varedati).'</td></tr>
				 </table>
			    </td>
			    <td>
		         <table width="100%" height="100%" cellpadding="0" cellspacing="0">
			      <tr><td style="border-bottom: 1px solid black;">'.virgul($meghdar_forush_emsal_gav_dakheli).'</td></tr>
			      <tr><td style="border-bottom: 1px solid black;">'.virgul($meghdar_forush_emsal_gav_varedati).'</td></tr>
			      <tr><td style="border-bottom: 1px solid black;">'.virgul($meghdar_forush_emsal_goosfand_dakheli).'</td></tr>
			      <tr><td>'.virgul($meghdar_forush_emsal_goosfand_varedati).'</td></tr>
				 </table>
			    </td>
				<td>
		         <table  width="100%" height="100%" cellpadding="0" cellspacing="0">
			      <tr><td style="border-bottom: 1px solid black;">'.virgul($meghdar_forush_rouz_gav_dakheli).'</td></tr>
			      <tr><td style="border-bottom: 1px solid black;">'.virgul($meghdar_forush_rouz_gav_varedati).'</td></tr>
			      <tr><td style="border-bottom: 1px solid black;">'.virgul($meghdar_forush_rouz_goosfand_dakheli).'</td></tr>
			      <tr><td>'.virgul($meghdar_forush_rouz_goosfand_varedati).'</td></tr>
				 </table>
			    </td>
				';
		 }
		 else //ذرت - جو - سویا
		 {
		   echo' 
		   <td >'.virgul($takalif).'</td>
		   <td >'.virgul($meghdar_forush_parsal).'</td>
		   <td >'.virgul($meghdar_forush_emsal).'</td>
		   <td >'.virgul($meghdar_forush_rouz).'</td>';
		 
		  $jame_takalif_e+=$takalif;
	      $jame_meghdar_forush_parsal_e+=$meghdar_forush_parsal;
	      $jame_meghdar_forush_emsal_e+=$meghdar_forush_emsal;
	      $jame_meghdar_forush_rouz_e+=$meghdar_forush_rouz;
		 
		 }
		 echo'
	    </tr>';
	      
		  $jame_takalif=$jame_takalif_e;
	      $jame_meghdar_forush_parsal=$jame_meghdar_forush_parsal_e+$meghdar_forush_parsal_morgh_dakheli+$meghdar_forush_parsal_morgh_varedati+$meghdar_forush_parsal_gav_dakheli+$meghdar_forush_parsal_gav_varedati+$meghdar_forush_parsal_goosfand_dakheli+$meghdar_forush_parsal_goosfand_varedati;
	      $jame_meghdar_forush_emsal=$jame_meghdar_forush_emsal_e+$meghdar_forush_emsal_morgh_dakheli+$meghdar_forush_emsal_morgh_varedati+$meghdar_forush_emsal_gav_dakheli+$meghdar_forush_emsal_gav_varedati+$meghdar_forush_emsal_goosfand_dakheli+$meghdar_forush_emsal_goosfand_varedati;
	      $jame_meghdar_forush_rouz=$jame_meghdar_forush_rouz_e+$meghdar_forush_rouz_morgh_dakheli+$meghdar_forush_rouz_morgh_varedati+$meghdar_forush_rouz_gav_dakheli+$meghdar_forush_rouz_gav_varedati+$meghdar_forush_rouz_goosfand_dakheli+$meghdar_forush_rouz_goosfand_varedati;
	      
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
	 }//END foreach
	 /*****سطر جمع کل استان ها*****/
	 echo'
	 <tr class="print_table-even sum-row" style="background-color:#FFF;" >
	  <td colspan="2">جمع کل (کیلوگرم)</td>
	    <td >'.virgul($jame_takalif).'</td>
	    <td >'.virgul($jame_meghdar_forush_parsal).'</td>
	    <td >'.virgul($jame_meghdar_forush_emsal).'</td>
	    <td >'.virgul($jame_meghdar_forush_rouz).'</td>
	 </tr>';
	 //END//
	 echo'
  <!--پايان مرکز صفحه -->
  <!-- چاپ زیرنویس-->
   <tr class="print_footer noExl">
    <td colspan="50">&nbsp;&nbsp;نام کاربر :&nbsp;&nbsp;'.$mtuserNAME.' &nbsp;&nbsp;&nbsp; تاریخ چاپ : '.$today.' &nbsp;&nbsp;&nbsp; ساعت چاپ : '.$logtime.'</td>
   </tr>
 </table>';
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
   function doNow(ch)
   { if(ch=="on") ck=1; else ck=0;
   void(d=document);
   void(el=d.getElementsByTagName("INPUT"));
   for(i=0;i<el.length;i++)
   void(el[i].checked=ck)
   if(ch=="on") ch="off"; else if(ch=="off")ch="on";
   return ch;
   }
</script> 