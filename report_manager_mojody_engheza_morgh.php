<?php
require_once __DIR__ . '/mysql_compat.php';
//کد کالای 266 معادل مرغ منجمدکارتنی داخلی امانی در این گزارش حساب نشود
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="report_manager_mojody_engheza_gusht.php";
$ExcelFileName=str_replace('.php','',$FileName);
$titr='گزارش موجودی گوشت مرغ بر حسب تاریخ انقضا';
require_once('head.html');	
		  // $q2="SELECT * FROM mojody_kala T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan INNER JOIN tarikh_mandegari ON T.code_mandegari=tarikh_mandegari.code_mandegari  WHERE  situation_type=1 AND T.code_ostan=4 	AND (T.code_kala=38 OR T.code_kala=401 OR T.code_kala=402 OR T.code_kala=403 OR T.code_kala=404 OR T.code_kala=410 OR T.code_kala=411 OR T.code_kala=412 OR T.code_kala=197 OR T.code_kala=198 OR T.code_kala=413 OR T.code_kala=414 OR T.code_kala=415 OR T.code_kala=416) AND year='1401' AND deleted=0 ";
		    // echo $q2;
		   // $res2=$db->query($q2);
		   // while($row2=$db->fetch_assoc($res2))
		   // {
			 // $milady=jalali_to_gregorian($row2['sal_tolid_shamsi'],$row2['mah_tolid_shamsi'],$row2['rouz_tolid_shamsi']);
             // $sal1=$milady[0];$mah1=$milady[1];$rouz1=$milady[2];
             // $tolid_milady=$sal1.'-'.$mah1.'-'.$rouz1;
		     // IF($row2['meqyas_mandegari']==2)//ماه
			 // {
			  // $tarikh_engheza_m = strtotime ( '+'.$row2['meghdar_mandegari'].' month' , strtotime ( $tolid_milady ) ) ;// month later
			 // }
			 // ELSE IF($row['meqyas_mandegari']==3)//روز
			 // {
			  // $tarikh_engheza_m = strtotime ( '+'.$row2['meghdar_mandegari'].' day' , strtotime ( $tolid_milady ) ) ;// day later
			 // }
			 // $tarikh_engheza_m = date ( 'Y-m-j' , $tarikh_engheza_m );
			 // echo '<br>';
	         // echo $row2['code_kala'].':'.$row2['sal_tolid_shamsi'].'-'.$row2['mah_tolid_shamsi'].'-'.$row2['rouz_tolid_shamsi'];
	         // echo '<br>';
	         // echo $tolid_milady;
             // echo '<br>';
		     // echo $today_milady;
             // echo '<br>';			 
		     // echo $tarikh_engheza_m;
             // echo '<br>'; 
			 // $date_tolid=date_create($tolid_milady);
			 // $date_today=date_create($today_milady);
             // $date_engheza=date_create($tarikh_engheza_m);
             // $diff=date_diff($date_today,$date_engheza);
             // echo $diff->format("%R%a Days");
             // //echo $diff->format("%a");
             // echo '<br>'; 
			 // $date_dif=$diff->format("%a");
		     // if($tarikh_engheza_m<$today_milady)
			 // {  
   			     // $mojody_tarikh_gozashte+=$row2['mojody_khales'];
			  	 // echo $row2['mojody_khales'];
                 // echo '<br>';
				 // echo 'mojody_tarikh_gozashte:'.$mojody_tarikh_gozashte;
				 // echo '------------------------------------';
			 // }
		     // else
             // {				 
			    // if($date_dif<90)//زیر سه ماه
			    // {  
   			     // $mojody_zir3+=$row2['mojody_khales'];
			  	 // echo $row2['mojody_khales'];
			  	 // echo '<br>';
				 // echo 'mojody_zir3:'.$mojody_zir3;
				 // echo '------------------------------------';
			    // }
		        // else if (($date_dif>=90)and($date_dif<180))// بین سه تا شش ماه
			    // {  
   			       // $mojody_3ta6+=$row2['mojody_khales'];
			       // echo $row2['mojody_khales'];
                   // echo '<br>';
				   // echo 'mojody_3ta6:'.$mojody_3ta6;
				   // echo '------------------------------------';
			    // }
			    // else if($date_dif>=180)// بالای شش ماه
			    // {
			       // $mojody_bala6+=$row2['mojody_khales'];
			       // echo $row2['mojody_khales'];
                   // echo '<br>';
				   // echo 'mojody_bala6:'.$mojody_bala6;
				   // echo '------------------------------------';
			    // }
			 // }
		   // }
$columns='
 	<tr class="print_table-title2">
	 <td width="2%" rowspan="2">ردیف</td>
	 <td width="5%" rowspan="2">استان</td>
	 <td width="14%" colspan="4">مرغ داخلی</td>
	 <td width="14%" colspan="4">مرغ وارداتی</td>
	 <td width="12%" colspan="4">مرغ گرم وارداتی</td>
	 <!--<td width="15%" colspan="4">مرغ داخلی تحت کلید گمرک</td>-->
	 <td width="12%" colspan="4">مرغ وارداتی تحت کلید گمرک</td>
	 <td width="14%" colspan="4">کل موجودی مرغ داخلی و وارداتی (عادی)</td>
	 <td width="13%" colspan="4">کل موجودی مرغ داخلی و وارداتی (تحت کلید گمرک)</td>
	 <td width="14%" colspan="4">کل موجودی مرغ داخلی و وارداتی (عادی و تحت کلید گمرک)</td>
	</tr>
	<tr class="print_table-title2">';
	for($count=1;$count<=7;$count++)
	{
         $columns.='
		 <td>تاریخ گذشته</td>
		 <td>زیر 3 ماه</td>
		 <td>بین 3 و 6 ماه</td>
    	 <td>بالای 6 ماه</td>';
    }
    $columns.='</tr>';
/****************هدر******************/
Function print_header()
{global $titr,$count,$mt_gl_owner,$date1,$date2,$FileName,$page,$db;
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
	       از تاریخ : '.$date1.' تا تاریخ : '.$date2.'&nbsp&nbsp(صفحه : '.$page.')
	      <div style="float:left;"><button class="buttonme hideatprint" onClick="window.location=\''.$FileName.'\'">بازگشت</button></div>
	     </td>
	   </tr>
	  </table>
	 </td>
    </tr>';
}
/****************فیلترها روی گزارش******************/
if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
{  
  if(is_array($ostanchoice))//کد های استان
  {
    foreach($ostanchoice as $key => $val ) {
    $Condition_ostan.=" code_ostan='$val' OR";
    }
    if($val==-1)$Condition.="";
    else $Condition.=" and $Condition_ostan";
   $lastSpacePosition = strrpos($Condition," ");
   $Condition =substr($Condition,0,$lastSpacePosition);
  }
}
else $Condition=' AND code_ostan='.$_SESSION['mt_code_ostan'].'';
/******************نمایش یا عدم نمایش سردخانه های موقت******************/
if($chkmovaghat=='on') $Condition_movaghat="";
else $Condition_movaghat="situation_type=1 AND ";
/******************نمایش یا عدم نمایش انبارهای غیرفعال******************/
if($chkactivate=='on') {$Condition_anbar_activate=""; $Condition_anbar_activate_ostan="1=1";}
else {$Condition_anbar_activate="list_sardkhane.activate=1 AND";  $Condition_anbar_activate_ostan="activate=1";}
/***************************************** MAIN*****************************************/
echo'
<body class="openwin" onload="document.myform.date2.focus();">
<form method="post" name="myform" onkeydown="enterIE()">';
if(!$MaxLines)$MaxLines=15;
//اگر کاربر تاریخ اول را وارد نکرده بود
if(!$date1)
{
  $date1=$db->get_from_where("start_from","mt_docs","year='$mtActiveYear'");  
}
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
   <table width="600px" border="0" align="center" cellpadding="0" cellspacing="0" >
    <tr><td colspan="4" height="20px">&nbsp;</td></tr>
	<tr>
     <td colspan="4" class="title">'.$titr.'</td>	 
    </tr>
    <!--<tr class="tr1" style="height:45px;">	
     <td align="left"> از تاریخ : </td><td align="right">&nbsp;<input type="text" class="textboxme2" maxlength="10" name="date1" id="datepickerfrom" value="'.$date1.'" readonly/></td>
     <td align="left"> تا تاریخ : </td><td align="right">&nbsp;<input type="text" class="textboxme2" maxlength="10" name="date2" id="datepickerto" placeholder="'.$date2.'"/></td>
	</tr>-->
	<tr class="tr1" style="height:45px;">
	 <td align="left"> نمایش اطلاعات : </td><td align="right">&nbsp;'.static_listbox("noe_namayesh",$noe_namayesh,"namayeshArr",1,"class='easyui-combobox text4' style=width:100px data-options=panelHeight:100").'</td>	
	 <td align="left"> تعداد خط در صفحه : </td><td align="right">&nbsp;<input type="number" class="textboxme2" name="MaxLines" value="'.$MaxLines.'" onkeypress="return isNumber(event)"/></td>
	</tr>
    <tr class="tr1">
	 <td align="left"><input type="checkbox" name="chkmovaghat"/></td><td align="right">&nbsp; همراه با اطلاعات سردخانه موقت </td>
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
    <tr class="footer" align="center"><td colspan="4" height="40px"><input class="buttonme" type="submit" name="ok" value="شروع گزارش"></td></tr>     
   </table>
  </td>
 </tr>
</table> ';
}
else
{
	$dateCond="";
    $radif=1;
	/****************فیلترها روی گزارش******************/	
	/****************شروع نمایش گزارش*******************/	
	$page=1;
    $line=0;
    $i=0;
    $cntr=0;
	$q="SELECT * FROM ostan WHERE code_ostan IN(SELECT code_ostan FROM list_sardkhane WHERE $Condition_anbar_activate_ostan) $Condition ORDER BY name_ostan";
	//$q="SELECT * FROM ostan WHERE  $Condition ORDER BY name_ostan";
	$res=$db->query($q);
	$cntr =mysql_num_rows($res);
	if(mysql_num_rows($res)>0)
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
	 if($chkmovaghat==TRUE) $filter_string.=' با اطلاعات سردخانه موقت -';
     if($chkmovaghat==False) $filter_string.=' بدون اطلاعات سردخانه موقت -';
	 if($chkactivate==TRUE) $filter_string.=' با اطلاعات سردخانه غیرفعال -';
     if($chkactivate==False) $filter_string.=' بدون اطلاعات سردخانه غیرفعال -';
	 if($noe_namayesh) {$filter_string.=' نوع نمایش براساس : '.$namayeshArr[$noe_namayesh].'&nbsp;';}     
	 echo'<tr class="noExl"><td class="filter_text" colspan="50">فیلتر شده براساس : '.$filter_string.'</td></tr>';
	 echo'<tr class="noExl"><td class="filter_text" colspan="50">توجه : کد کالای 266 مرغ منجمدکارتنی داخلی امانی در این گزارش محاسبه نمی شود</td></tr>';
	 echo $columns;
	 while($row=$db->fetch_assoc($res))
	 {
	  //صفر کردن مقادیر
	  $mojody_tarikh_gozashte=0;
	  $mojody_zir3=0;
	  $mojody_3ta6=0;
	  $mojody_bala6=0;
	  
	  $line++;
	  if($i++%2)echo'<tr class="print_table-odd">';
      else echo'<tr class="print_table-even">';
	  echo'   
		 <td>'.$radif++.'</td>
	     <td>'.$row['name_ostan'].'</td>';
		 if(($_SESSION['mt_all_ostan']==1)or(SuperUser())){$Condition_anbar='1=1';}
		 else //بقیه کاربران براساس انبار قابل دسترسیشان
		 {
		  $q2="SELECT * FROM user_ostan_anbar INNER JOIN list_sardkhane ON list_sardkhane.code_ostan=user_ostan_anbar.code_ostan AND list_sardkhane.code_anbar=user_ostan_anbar.code_anbar WHERE $Condition_anbar_activate $Condition_movaghat list_sardkhane.code_ostan=".$row['code_ostan']." AND user_id=".$_SESSION['mt_user_id']."";
		  $res2=$db->query($q2);
		  while($row2=$db->fetch_assoc($res2))//انبارهای قابل دسترسی
		  {
		   $Condition_anbar_temp.=" T.code_anbar=".$row2['code_anbar']." OR";

		  }
		   $Condition_anbar.="  $Condition_anbar_temp";

           $lastSpacePosition = strrpos($Condition_anbar," ");

           $Condition_anbar =substr($Condition_anbar,0,$lastSpacePosition);

		 }
		 
		 // $kalaArray = array("11"=>"مرغ داخلی تاریخ گذشته","12"=>"مرغ داخلی زیر سه ماه","13"=>"مرغ داخلی بین سه و شش","14"=>"مرغ داخلی بالای شش",
		                    // "15"=>"مرغ وارداتی تاریخ گذشته","16"=>"مرغ وارداتی زیر سه ماه","17"=>"مرغ وارداتی بین سه و شش","18"=>"مرغ وارداتی بالای شش",
							// "19"=>"مرغ داخلی تحت کلید تاریخ گذشته","20"=>"مرغ داخلی تحت کلید زیر سه ماه","21"=>"مرغ داخلی تحت کلید بین سه و شش","22"=>"مرغ داخلی تحت کلید بالای شش",
							// "23"=>"مرغ وارداتی تحت کلید تاریخ گذشته","24"=>"مرغ وارداتی تحت کلید زیر سه ماه","25"=>"مرغ وارداتی تحت کلید بین سه و شش","26"=>"مرغ وارداتی تحت کلید بالای شش",
							// "27"=>"مرغ تاریخ گذشته","28"=>"مرغ زیر سه ماه","29"=>"مرغ بین سه و شش","30"=>"مرغ بالای شش",
							// "31"=>"مرغ تحت کلید تاریخ گذشته","32"=>"مرغ تحت کلید زیر سه ماه","33"=>"مرغ تحت کلید بین سه و شش","34"=>"مرغ تحت کلید بالای شش"
							// );
		 
         $kalaArray = array("11"=>"مرغ داخلی تاریخ گذشته","12"=>"مرغ داخلی زیر سه ماه","13"=>"مرغ داخلی بین سه و شش","14"=>"مرغ داخلی بالای شش",
		                    "15"=>"مرغ وارداتی تاریخ گذشته","16"=>"مرغ وارداتی زیر سه ماه","17"=>"مرغ وارداتی بین سه و شش","18"=>"مرغ وارداتی بالای شش",
							"19"=>"مرغ گرم وارداتی تاریخ گذشته","20"=>"مرغ گرم وارداتی زیر سه ماه","21"=>"مرغ گرم وارداتی بین سه وشش","22"=>"مرغ گرم وارداتی بالای شش",
							"23"=>"مرغ وارداتی تحت کلید تاریخ گذشته","24"=>"مرغ وارداتی تحت کلید زیر سه ماه","25"=>"مرغ وارداتی تحت کلید بین سه و شش","26"=>"مرغ وارداتی تحت کلید بالای شش",
							"27"=>"مرغ تاریخ گذشته","28"=>"مرغ زیر سه ماه","29"=>"مرغ بین سه و شش","30"=>"مرغ بالای شش",
							"31"=>"مرغ تحت کلید تاریخ گذشته","32"=>"مرغ تحت کلید زیر سه ماه","33"=>"مرغ تحت کلید بین سه و شش","34"=>"مرغ تحت کلید بالای شش",
							"35"=>"کل مرغ تاریخ گذشته","36"=>"کل مرغ زیر سه ماه","37"=>"کل مرغ بین سه و شش","38"=>"کل مرغ بالای شش"
							);
		 foreach($kalaArray as $x => $x_value)
		 {		  
		   $kalaCondition="";
		   //if(($x=="11")or($x=="12")or($x=="13")or($x=="14")or($x=="19")or($x=="20")or($x=="21")or($x=="22"))//مرغ داخلی
		   if(($x=="11")or($x=="12")or($x=="13")or($x=="14"))//مرغ داخلی
		   {
			 $kalaCondition=" AND (T.code_kala=38 OR T.code_kala=401 OR T.code_kala=402 OR T.code_kala=403 OR T.code_kala=404 OR T.code_kala=410 OR T.code_kala=411 OR T.code_kala=412 OR T.code_kala=197 OR T.code_kala=198 OR T.code_kala=413 OR T.code_kala=414 OR T.code_kala=415 OR T.code_kala=416)";

		   }
		   if(($x=="15")or($x=="16")or($x=="17")or($x=="18")or($x=="23")or($x=="24")or($x=="25")or($x=="26"))//مرغ وارداتی
		   {
			 $kalaCondition=" AND (T.code_kala=154 OR T.code_kala=155 OR T.code_kala=91)";
		   }
		   if(($x=="19")or($x=="20")or($x=="21")or($x=="22"))//مرغ گرم وارداتی
		   {
			 $kalaCondition=" AND (T.code_kala=35)";
		   }
		  
		   IF     ($noe_namayesh==1){$mojodyField='mojody_khales';   $avalField='mojody_khales_aval';$residField='vazn_khales_r_d_sub';$havaleField='vazn_khales_h_d';$tadilField='meghdar_khales_tadil';$vahed='کیلوگرم';}
	       ELSE IF($noe_namayesh==2){$mojodyField='mojody_nakhales'; $avalField='mojody_nakhales_aval';$residField='vazn_nakhales_r_d_sub';$havaleField='vazn_nakhales_h_d';$tadilField='meghdar_nakhales_tadil';$vahed='کیلوگرم';}
	       ELSE IF($noe_namayesh==3){$mojodyField='tedad_karton';    $avalField='tedad_karton_aval';$residField='tedad_karton_r_d_sub';$havaleField='tedad_karton_h_d';$tadilField='tedad_karton_tadil';$vahed='تعداد';}				 
	       ELSE IF($noe_namayesh==4){$mojodyField='tedad_shane';     $avalField='tedad_shane_aval';$residField='tedad_shane_r_d_sub';$havaleField='tedad_shane_h_d';$tadilField='tedad_shane_tadil';$vahed='شانه';}				 
	       //موجودی مرغ
		   if(($x=="11")or($x=="12")or($x=="13")or($x=="14")or($x=="15")or($x=="16")or($x=="17")or($x=="18")or($x=="19")or($x=="20")or($x=="21")or($x=="22"))
		   {
	        $q2="SELECT * FROM mojody_kala T 
		         INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan 
	             INNER JOIN tarikh_mandegari ON T.code_mandegari=tarikh_mandegari.code_mandegari   
		         WHERE $Condition_anbar_activate $Condition_movaghat T.code_ostan=".$row['code_ostan']." AND year='$mtActiveYear' AND deleted=0 $kalaCondition and($Condition_anbar) ";
		   
		   }
		   // موجودی مرغ تحت کلید
		   //if(($x=="19")or($x=="20")or($x=="21")or($x=="22")or($x=="23")or($x=="24")or($x=="25")or($x=="26"))
		   if(($x=="23")or($x=="24")or($x=="25")or($x=="26"))
		   {
	        $q2="SELECT * FROM mojody_kala_gomrok T 
		         INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan 
	             INNER JOIN tarikh_mandegari ON T.code_mandegari=tarikh_mandegari.code_mandegari   
		         WHERE $Condition_anbar_activate $Condition_movaghat T.code_ostan=".$row['code_ostan']." AND year='$mtActiveYear' AND deleted=0 $kalaCondition and($Condition_anbar) ";
		   
		   }
		   //echo $q2;
		   //echo '<br>';
		   $res2=$db->query($q2);
		   while($row2=$db->fetch_assoc($res2))
		   {
			 $milady=jalali_to_gregorian($row2['sal_tolid_shamsi'],$row2['mah_tolid_shamsi'],$row2['rouz_tolid_shamsi']);
             $sal1=$milady[0];$mah1=$milady[1];$rouz1=$milady[2];
             $tolid_milady=$sal1.'-'.$mah1.'-'.$rouz1;
		     IF($row2['meqyas_mandegari']==2)//ماه
			 {
			  $tarikh_engheza_m = strtotime ( '+'.$row2['meghdar_mandegari'].' month' , strtotime ( $tolid_milady ) ) ;// month later
			 }
			 ELSE IF($row2['meqyas_mandegari']==3)//روز
			 {
			  $tarikh_engheza_m = strtotime ( '+'.$row2['meghdar_mandegari'].' day' , strtotime ( $tolid_milady ) ) ;// day later
			 }
			 $tarikh_engheza_m = date ( 'Y-m-j' , $tarikh_engheza_m );

			 //$date_tolid=date_create($tolid_milady);
			
			 $sal_jari=substr($today,0,4);//سال فعلی 

			 IF($mtActiveYear==$sal_jari) $date_today=date_create($today_milady);
			 ELSE  
			 {
				 //$today_milady='2026-03-19';
				 $today_milady=$_SESSION['mtend_date_mi'];
			     $date_today=date_create($today_milady);
			 }
             $date_engheza=date_create($tarikh_engheza_m);
             $diff=date_diff($date_today,$date_engheza);
		     //echo $diff->format("%R%a Days");
			 $date_dif=$diff->format("%a");
			 if($tarikh_engheza_m<$today_milady)
			 {  
   			     $mojody_tarikh_gozashte+=$row2[$mojodyField];
			 }
		     else
             {				 
			    if($date_dif<90)//زیر سه ماه
			    {  
   			       $mojody_zir3+=$row2[$mojodyField];
			    }
		        else if (($date_dif>=90)and($date_dif<180))// بین سه تا شش ماه
			    {  
   			       $mojody_3ta6+=$row2[$mojodyField];
			    }
			    else if($date_dif>=180)// بالای شش ماه
			    {
			       $mojody_bala6+=$row2[$mojodyField];
			    }
			 }
            }
			//مجموع موجودی هر کالا در هر استان
			// $mojodyAval=$db->get_from_where("SUM($avalField)","mojody_kala T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_anbar_activate $Condition_movaghat T.code_ostan=".$row['code_ostan']." AND year='$mtActiveYear' AND deleted=0 $kalaCondition and($Condition_anbar)");        				   
		    // $jameVarede=$db->get_from_where("SUM($residField)","resid_kala_detail T INNER JOIN resid r ON T.shomare_resid=r.shomare_resid AND T.code_ostan=r.code_ostan AND T.code_anbar=r.code_anbar AND T.year=r.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_anbar_activate $Condition_movaghat T.code_ostan=".$row['code_ostan']." AND T.year='$mtActiveYear' AND T.resid_deleted=0 AND T.status=0 AND noe_tahvil_bar!=9 AND r.tarikh_resid>='$date1' AND r.tarikh_resid<='$date2' $kalaCondition  and($Condition_anbar)");
			// $jameSadere=$db->get_from_where("SUM($havaleField)","havale_detail T INNER JOIN havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_anbar_activate $Condition_movaghat T.code_ostan=".$row['code_ostan']." AND T.year='$mtActiveYear' AND T.havale_deleted=0 AND T.status=0 AND noe_tahvil_bar!=9 AND h.tarikh_havale_anbar>='$date1' AND h.tarikh_havale_anbar<='$date2' $kalaCondition and($Condition_anbar)");
		    // $Tadil_Ezafe=$db->get_from_where("SUM($tadilField)","tadil_mojody T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_anbar_activate $Condition_movaghat noe_tadil=1 AND T.code_ostan=".$row['code_ostan']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil>='$date1' AND tarikh_barge_tadil<='$date2' $kalaCondition  and($Condition_anbar)");
		    // $Tadil_Kasry=$db->get_from_where("SUM($tadilField)","tadil_mojody T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_anbar_activate $Condition_movaghat noe_tadil=2 AND T.code_ostan=".$row['code_ostan']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil>='$date1' AND tarikh_barge_tadil<='$date2' $kalaCondition  and($Condition_anbar)");
		    // $mojodyKalaOstan=$mojodyAval+$jameVarede-$jameSadere+$Tadil_Ezafe-$Tadil_Kasry;			   			   			  		   
			//if($x_value!="جمع")
			//{
			     if(($x=="11")or($x=="15")or($x=="19")or($x=="23"))
				 {
				     echo '<td>'.round($mojody_tarikh_gozashte,3).'</td>';
				     if(($x=="11")or($x=="15")or($x=="19"))      $jame_mojody_tarikh_gozashte_ostan+=$mojody_tarikh_gozashte;//
				     else if(($x=="23")) $jame_mojody_tarikh_gozashte_ostan_tahtkelid+=$mojody_tarikh_gozashte;//
				     //else if(($x=="19")or($x=="23")) $jame_mojody_tarikh_gozashte_ostan_tahtkelid+=$mojody_tarikh_gozashte;//
			         $jame_tarikh_gozashte_ostan=$jame_mojody_tarikh_gozashte_ostan+$jame_mojody_tarikh_gozashte_ostan_tahtkelid;
				 }
                 else if(($x=="12")or($x=="16")or($x=="20")or($x=="24"))
				 {
				     echo '<td>'.round($mojody_zir3,3).'</td>';
				     if(($x=="12")or($x=="16")or($x=="20"))      $jame_mojody_zir3_ostan+=$mojody_zir3;//
				     else if(($x=="24")) $jame_mojody_zir3_ostan_tahtkelid+=$mojody_zir3;//
				     //else if(($x=="20")or($x=="24")) $jame_mojody_zir3_ostan_tahtkelid+=$mojody_zir3;//
			         $jame_zir3_ostan=$jame_mojody_zir3_ostan+$jame_mojody_zir3_ostan_tahtkelid;
				 }
				 else if(($x=="13")or($x=="17")or($x=="21")or($x=="25"))
				 {
				     echo '<td>'.round($mojody_3ta6,3).'</td>';
				     if(($x=="13")or($x=="17")or($x=="21"))      $jame_mojody3ta6_ostan+=$mojody_3ta6;//
				     else if(($x=="25")) $jame_mojody3ta6_ostan_tahtkelid+=$mojody_3ta6;//
				     //else if(($x=="21")or($x=="25")) $jame_mojody3ta6_ostan_tahtkelid+=$mojody_3ta6;//
			         $jame_3ta6_ostan=$jame_mojody3ta6_ostan+$jame_mojody3ta6_ostan_tahtkelid;
				 }
				 else if(($x=="14")or($x=="18")or($x=="22")or($x=="26"))
				 {
				     echo '<td>'.round($mojody_bala6,3).'</td>';
				     if(($x=="14")or($x=="18")or($x=="22"))      $jame_mojody_bala6_ostan+=$mojody_bala6;//
				     else if(($x=="26")) $jame_mojody_bala6_ostan_tahtkelid+=$mojody_bala6;//
				     //else if(($x=="22")or($x=="26")) $jame_mojody_bala6_ostan_tahtkelid+=$mojody_bala6;//
			         $jame_bala6_ostan=$jame_mojody_bala6_ostan+$jame_mojody_bala6_ostan_tahtkelid;
				 }
				 else if($x=="27")
				 {
					 echo '<td>'.round($jame_mojody_tarikh_gozashte_ostan,3).'</td>';
			         $jame_mojody_tarikh_gozashte_ostan=0;
				 }
				 else if($x=="28")
				 { 
			         echo '<td>'.round($jame_mojody_zir3_ostan,3).'</td>';
				     $jame_mojody_zir3_ostan=0;
				 }
				 else if($x=="29")
				 {
					 echo '<td>'.round($jame_mojody3ta6_ostan,3).'</td>';
					 $jame_mojody3ta6_ostan=0;
				 }
				 else if($x=="30")
				 {
					 echo '<td>'.round($jame_mojody_bala6_ostan,3).'</td>';
					 $jame_mojody_bala6_ostan=0;
				 }
				 else if($x=="31")
				 {
					 echo '<td>'.round($jame_mojody_tarikh_gozashte_ostan_tahtkelid,3).'</td>';
			         $jame_mojody_tarikh_gozashte_ostan_tahtkelid=0;
				 }
				 else if($x=="32")
				 { 
			         echo '<td>'.round($jame_mojody_zir3_ostan_tahtkelid,3).'</td>';
				     $jame_mojody_zir3_ostan_tahtkelid=0;
				 }
				 else if($x=="33")
				 {
					 echo '<td>'.round($jame_mojody3ta6_ostan_tahtkelid,3).'</td>';
					 $jame_mojody3ta6_ostan_tahtkelid=0;
				 }
				 else if($x=="34")
				 {
					 echo '<td>'.round($jame_mojody_bala6_ostan_tahtkelid,3).'</td>';
					 $jame_mojody_bala6_ostan_tahtkelid=0;
				 }
				 else if($x=="35")
				 {
					 echo '<td>'.round($jame_tarikh_gozashte_ostan,3).'</td>';
			         $jame_tarikh_gozashte_ostan=0;
				 }
				 else if($x=="36")
				 { 
			         echo '<td>'.round($jame_zir3_ostan,3).'</td>';
				     $jame_zir3_ostan=0;
				 }
				 else if($x=="37")
				 {
					 echo '<td>'.round($jame_3ta6_ostan,3).'</td>';
					 $jame_3ta6_ostan=0;
				 }
				 else if($x=="38")
				 {
					 echo '<td>'.round($jame_bala6_ostan,3).'</td>';
					 $jame_bala6_ostan=0;
				 }
				 
				 //محاسبه مجموع مقادیر در سطر آخر
				 if($x=="11")$jame_mojody_morghdakeli_tarikh_gozashte+=$mojody_tarikh_gozashte;
			     if($x=="12")$jame_mojody_morghdakeli_zir3+=$mojody_zir3;
			     if($x=="13")$jame_mojody_morghdakeli_3ta6+=$mojody_3ta6;
			     if($x=="14")$jame_mojody_morghdakeli_bala6+=$mojody_bala6;
				 if($x=="15")$jame_mojody_morghvaredati_tarikh_gozashte+=$mojody_tarikh_gozashte;
				 if($x=="16")$jame_mojody_morghvaredati_zir3+=$mojody_zir3;
				 if($x=="17")$jame_mojody_morghvaredati_3ta6+=$mojody_3ta6;
				 if($x=="18")$jame_mojody_morghvaredati_bala6+=$mojody_bala6;
				 
				 
				 if($x=="19")$jame_mojody_morghvaredati_tarikh_gozashte_garm+=$mojody_tarikh_gozashte;
			     if($x=="20")$jame_mojody_morghvaredati_zir3_garm+=$mojody_zir3;
				 if($x=="21")$jame_mojody_morghvaredati_3ta6_garm+=$mojody_3ta6;
			     if($x=="22")$jame_mojody_morghvaredati_bala6_garm+=$mojody_bala6;
				 
				 // if($x=="19")$jame_mojody_morghdakeli_tarikh_gozashte_tahtkelid+=$mojody_tarikh_gozashte;
			     // if($x=="20")$jame_mojody_morghdakeli_zir3_tahtkelid+=$mojody_zir3;
				 // if($x=="21")$jame_mojody_morghdakeli_3ta6_tahtkelid+=$mojody_3ta6;
			     // if($x=="22")$jame_mojody_morghdakeli_bala6_tahtkelid+=$mojody_bala6;
				 if($x=="23")$jame_mojody_morghvaredati_tarikh_gozashte_tahtkelid+=$mojody_tarikh_gozashte;
			     if($x=="24")$jame_mojody_morghvaredati_zir3_tahtkelid+=$mojody_zir3;
				 if($x=="25")$jame_mojody_morghvaredati_3ta6_tahtkelid+=$mojody_3ta6;
			     if($x=="26")$jame_mojody_morghvaredati_bala6_tahtkelid+=$mojody_bala6;
				 
				 if(($x=="11")OR($x=="15")OR($x=="19"))$jame_mojody_tarikh_gozashte+=$mojody_tarikh_gozashte;
				 if(($x=="12")OR($x=="16")OR($x=="20"))$jame_mojody_zir3+=$mojody_zir3;
				 if(($x=="13")OR($x=="17")OR($x=="21"))$jame_mojody_3ta6+=$mojody_3ta6;
				 if(($x=="14")OR($x=="18")OR($x=="22"))$jame_mojody_bala6+=$mojody_bala6;
				 
				  
				 // if(($x=="19")OR($x=="23"))$jame_mojody_tarikh_gozashte_tahtkelid+=$mojody_tarikh_gozashte;
				 // if(($x=="20")OR($x=="24"))$jame_mojody_zir3_tahtkelid+=$mojody_zir3;
				 // if(($x=="21")OR($x=="25"))$jame_mojody_3ta6_tahtkelid+=$mojody_3ta6;
				 // if(($x=="22")OR($x=="26"))$jame_mojody_bala6_tahtkelid+=$mojody_bala6;

				 if($x=="23")$jame_mojody_tarikh_gozashte_tahtkelid+=$mojody_tarikh_gozashte;
				 if($x=="24")$jame_mojody_zir3_tahtkelid+=$mojody_zir3;
				 if($x=="25")$jame_mojody_3ta6_tahtkelid+=$mojody_3ta6;
				 if($x=="26")$jame_mojody_bala6_tahtkelid+=$mojody_bala6;
				 
				 if(($x=="11")OR($x=="15")OR($x=="19")OR($x=="23"))$jame_tarikh_gozashte+=$mojody_tarikh_gozashte;
				 if(($x=="12")OR($x=="16")OR($x=="20")OR($x=="24"))$jame_zir3+=$mojody_zir3;
				 if(($x=="13")OR($x=="17")OR($x=="21")OR($x=="25"))$jame_3ta6+=$mojody_3ta6;
				 if(($x=="14")OR($x=="18")OR($x=="22")OR($x=="26"))$jame_bala6+=$mojody_bala6;

			//}
			//if($x_value=="جمع")
			//{
				 //echo '<td>'.round($jame_mojody_ostan,3).'</td>';
				 //$jame_mojody_ostan=0;
            //}

		    //صفر کردن مقادیر
	        $mojody_tarikh_gozashte=0;
	        $mojody_zir3=0;
	        $mojody_3ta6=0;
	        $mojody_bala6=0;
		  }//END foreach		
		 echo'
	  </tr>';
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
	 }//END WHILE
	 /*****سطر جمع کل استان ها*****/
	 echo'
	 <tr class="print_table-even sum-row" style="background-color:#FFF;"" >
	  <td colspan="2">جمع کل</td>
	  <td>'.round($jame_mojody_morghdakeli_tarikh_gozashte,3).'</td>
	  <td>'.round($jame_mojody_morghdakeli_zir3,3).'</td>
	  <td>'.round($jame_mojody_morghdakeli_3ta6,3).'</td>
	  <td>'.round($jame_mojody_morghdakeli_bala6,3).'</td>
	  
	  <td>'.round($jame_mojody_morghvaredati_tarikh_gozashte,3).'</td>
	  <td>'.round($jame_mojody_morghvaredati_zir3,3).'</td>
	  <td>'.round($jame_mojody_morghvaredati_3ta6,3).'</td>
	  <td>'.round($jame_mojody_morghvaredati_bala6,3).'</td>
	  
	  <td>'.round($jame_mojody_morghvaredati_tarikh_gozashte_garm,3).'</td>
	  <td>'.round($jame_mojody_morghvaredati_zir3_garm,3).'</td>
	  <td>'.round($jame_mojody_morghvaredati_3ta6_garm,3).'</td>
	  <td>'.round($jame_mojody_morghvaredati_bala6_garm,3).'</td>
	  
	  <td>'.round($jame_mojody_morghvaredati_tarikh_gozashte_tahtkelid,3).'</td>
	  <td>'.round($jame_mojody_morghvaredati_zir3_tahtkelid,3).'</td>
	  <td>'.round($jame_mojody_morghvaredati_3ta6_tahtkelid,3).'</td>
	  <td>'.round($jame_mojody_morghvaredati_bala6_tahtkelid,3).'</td>
	  
	  <td>'.round($jame_mojody_tarikh_gozashte,3).'</td>
	  <td>'.round($jame_mojody_zir3,3).'</td>
	  <td>'.round($jame_mojody_3ta6,3).'</td>
	  <td>'.round($jame_mojody_bala6,3).'</td>
	  
	  <td>'.round($jame_mojody_tarikh_gozashte_tahtkelid,3).'</td>
	  <td>'.round($jame_mojody_zir3_tahtkelid,3).'</td>
	  <td>'.round($jame_mojody_3ta6_tahtkelid,3).'</td>
	  <td>'.round($jame_mojody_bala6_tahtkelid,3).'</td>
	  
	  
	  <td>'.round($jame_tarikh_gozashte,3).'</td>
	  <td>'.round($jame_zir3,3).'</td>
	  <td>'.round($jame_3ta6,3).'</td>
	  <td>'.round($jame_bala6,3).'</td>
	  
	 </tr>
  <!--پايان مرکز صفحه -->
  <!-- چاپ زیرنوس-->';
  require_once('prt-footer.php');
 echo' 
 </table>';
 }
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