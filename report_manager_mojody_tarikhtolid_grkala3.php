<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="report_manager_mojody_tarikhtolid_grkala.php";
$ExcelFileName=str_replace('.php','',$FileName);
$titr='گزارش موجودی استان ها به تفکیک تاریخ تولید گروه کالا';
require_once('head.html');
//پیدا کردن آی دی سال مربوط به سیستم فروش
$sellYearCode=substr($mtActiveYear,2);
$sellYearId=$db->get_from_where("year_id","sell.dm_year","year_code='$sellYearCode'");
/****************هدر******************/
Function print_header()
{global $count,$titr,$mahshamsiArr,$mt_gl_owner,$code_group_kala_top,$sal_tolid_shamsi_1,$sal_tolid_shamsi_2,$mah_tolid_shamsi_1,$mah_tolid_shamsi_2,$FileName,$page,$groupkalaName;
 echo'
  <br>   
   <table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
	<tr class="noExl">
     <td colspan="50">
	  <table width="100%"  align="center">
       <tr class="noExl"><td class="print_title_2">'.$mt_gl_owner.'</td></tr>
	   <tr class="noExl"> 
		<td class="print_title_2">'; 
		IF($page==1){
			 echo'<a href="javascript:window.print();"><span style="float:right" id="printerReport" class="hideatprint" title="چاپ"></span></a>
			      <span style="float:right" id="exportExcel" title="خروجی اکسل" ></span>';
		 }
		 echo'
         '.$titr.' : '.$groupkalaName.' &nbsp&nbsp(صفحه : '.$page.')
	     <div style="float:left;"><button class="buttonme hideatprint" onClick="window.location=\''.$FileName.'\'">بازگشت</button></div>
	    </td>
       </tr>
      </table>
	 </td>
	</tr>
	<tr class="print_table-title2">
	 <td width="5%">ردیف</td>
	 <td width="10%">استان</td>'; 
	 $sal=$sal_tolid_shamsi_1;
	 $mah=$mah_tolid_shamsi_1;
	 $counter=0;
	 $sal_diff=$sal_tolid_shamsi_2-$sal_tolid_shamsi_1;
	 if($sal_diff==0)$mah_diff=$mah_tolid_shamsi_2-$mah_tolid_shamsi_1;
	 else if($sal_diff==1)$mah_diff=12-$mah_tolid_shamsi_1+$mah_tolid_shamsi_2;
	 else if($sal_diff>=2)$mah_diff=($sal_diff*12)-$mah_tolid_shamsi_1+$mah_tolid_shamsi_2;
	 while($sal<=$sal_tolid_shamsi_2 and $counter<=$mah_diff)
	 {	  	   	  
	   echo'<td>'.$mahshamsiArr[$mah].$sal.'</td>';
	   if($mah==12)
	   {$mah=1;$sal++;}
	  else $mah++;
	  $counter++;
	 }
	 echo'
	 <td width="15%">جمع</td>
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
if(($_SESSION['mt_all_ostan']==1)or(SuperUser())){$Condition_anbar='1=1';$Condition_anbar_sell='1=1';$Condition_anbar_ebtal_sell='1=1';}
else //بقیه کاربران براساس انبار قابل دسترسیشان
{ 
 $q_user="SELECT * FROM user_ostan_anbar INNER JOIN list_sardkhane ON list_sardkhane.code_ostan=user_ostan_anbar.code_ostan AND list_sardkhane.code_anbar=user_ostan_anbar.code_anbar WHERE list_sardkhane.code_ostan=".$_SESSION["mt_code_ostan"]." AND user_id=".$_SESSION['mt_user_id']."";
 $res_user=$db->query($q_user);
 while($row_user=$db->fetch_assoc($res_user))//انبارهای قابل دسترسی
 {
   $Condition_anbar_temp.=" T.code_anbar=".$row_user['code_anbar']." OR";
   $sell_id_ostan=$db->get_from_where("province_id","sell.dm_province","province_code=".$_SESSION["mt_code_ostan"]."");//تبدیل کد به آی دی
   $sell_id_anbar=$db->get_from_where("l_id","sell.dm_location_goods","l_id_province=$sell_id_ostan AND l_code=".$row_user['code_anbar']."");//تبدیل کد به آی دی 
   if($sell_id_anbar)//اگر نظیرش در فروش بود
   {$Condition_anbar_temp_sell.=" dm_havale.h_l_code=".$sell_id_anbar." OR";
	$Condition_anbar_ebtal_temp_sell.=" dm_his_havale.his_l_code=".$sell_id_anbar." OR";}
 }
	 $Condition_anbar.="  $Condition_anbar_temp";
	 $Condition_anbar_sell.="  $Condition_anbar_temp_sell";
	 $Condition_anbar_ebtal_sell.="  $Condition_anbar_ebtal_temp_sell";
     $lastSpacePosition = strrpos($Condition_anbar," ");
     $lastSpacePosition_sell = strrpos($Condition_anbar_sell," ");
     $lastSpacePosition_ebtal_sell = strrpos($Condition_anbar_ebtal_sell," ");
     $Condition_anbar =substr($Condition_anbar,0,$lastSpacePosition);
     $Condition_anbar_sell =substr($Condition_anbar_sell,0,$lastSpacePosition_sell);
     $Condition_anbar_ebtal_sell =substr($Condition_anbar_ebtal_sell,0,$lastSpacePosition_ebtal_sell);
}
/******************نمایش یا عدم نمایش سردخانه های موقت******************/
if($chkmovaghat=='on') $Condition_movaghat="";
else $Condition_movaghat="situation_type=1 AND ";
/******************نمایش یا عدم نمایش انبارهای غیرفعال******************/
if($chkactivate=='on') {$Condition_anbar_activate=""; }
else {$Condition_anbar_activate="list_sardkhane.activate=1 AND";}
/***************************************** MAIN*****************************************/
echo'
<body class="openwin" onload="document.myform.code_group_kala_top.focus();">
<form method="post" name="myform">';
if(!$MaxLines)$MaxLines=10;
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
	<tr class="tr1" style="height:45px;">
     <td align="left" ><span class="star">*</span> گروه کالای سردخانه :</td><td align="right" colspan="3">&nbsp;'.listboxMe("code_group_kala_top",$code_group_kala_top,"code_group_kala_top","name_group_kala_top","bzacc.group_kala_top","group_type_top=2","class='easyui-combobox text4' style=width:100px data-options=panelHeight:170").'</td>
	</tr>
	<tr class="tr1" style="height:45px;">	
     <td align="left"> از تاریخ : </td><td align="right">&nbsp;<input type="text" class="textboxme2" maxlength="10" name="date1" id="datepickerfrom" value="'.$date1.'" readonly/></td>
     <td align="left"> تا تاریخ : </td><td align="right">&nbsp;<input type="text" class="textboxme2" maxlength="10" name="date2" id="datepickerto" placeholder="'.$date2.'"/></td>
	</tr>
    <tr class="tr1">
	 <td align="left"> نمایش اطلاعات : </td><td align="right" >&nbsp;'.static_listbox("noe_namayesh",$noe_namayesh,"namayeshArr",1,"class='easyui-combobox text4' style=width:100px data-options=panelHeight:100").'</td>	
	 <td align="left"> تعداد خط در صفحه : </td><td align="right" >&nbsp;<input type="number" class="textboxme2" name="MaxLines" value="'.$MaxLines.'" onkeypress="return isNumber(event)"/></td>
	</tr>
    <tr class="tr1" style="height:45px;">
	 <td align="left"><input type="checkbox" name="chkmovaghat"/></td><td align="right" >&nbsp; نمایش اطلاعات سردخانه موقت </td>
	 <td align="left"><input type="checkbox" name="chkactivate" checked/></td><td align="right">&nbsp; نمایش اطلاعات سردخانه های غیرفعال</td>
    </tr>
	<tr class="tr1" style="height:45px;">	   
     <td align="left"> از تاریخ تولید : </td>
	 <td align="right" colspan="3">&nbsp;
	  سال تولید :&nbsp;<input class="textboxme2 textbox50" type="text" name="sal_tolid_shamsi_1" value="'.$sal_tolid_shamsi_1.'" maxlength="4" placeholder=" '.$mtActiveYear.'" onkeypress="return isNumber(event)"/>
	  ماه تولید :&nbsp;'.static_listbox("mah_tolid_shamsi_1",$mah_tolid_shamsi_1,"mahshamsiArr",1,"class='easyui-combobox text4' style=width:100px").'
	</tr>
	<tr class="tr1">	   
     <td align="left"> تا تاریخ تولید : </td>
	 <td align="right" colspan="3">&nbsp;
	  سال تولید :&nbsp;<input class="textboxme2 textbox50" type="text" name="sal_tolid_shamsi_2" value="'.$sal_tolid_shamsi_2.'" maxlength="4" placeholder=" '.$mtActiveYear.'" onkeypress="return isNumber(event)"/>
	  ماه تولید :&nbsp;'.static_listbox("mah_tolid_shamsi_2",$mah_tolid_shamsi_2,"mahshamsiArr",1,"class='easyui-combobox text4' style=width:100px").'
	</tr>';
	if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
	{
	 echo'
	 <tr class="tr1">
	  <td align="left" height="40px"> نام استان : </td>
      <td align="right" colspan="3">
	   &nbsp;<select name="ostanchoice[]"  class="easyui-combobox" style="width:200px;" multiple>';
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
 if(!$code_group_kala_top){echo"<script>alert('لطفاً گروه کالا را انتخاب نمایید !')</script>";
                   echo"<script>window.location='$FileName';</script>";}
  //اگر کاربر تاریخ اول را وارد نکرده بود
 if(!$sal_tolid_shamsi_1)$sal_tolid_shamsi_1=$mtActiveYear-1;  
 if(!$mah_tolid_shamsi_1)$mah_tolid_shamsi_1='1';  
 //اگر کاربر تاریخ دوم را وارد نکرده بود
 if(!$sal_tolid_shamsi_2) $sal_tolid_shamsi_2=$mtActiveYear;	  
 if(!$mah_tolid_shamsi_2){IF($mtActiveYear==$yy) $mah_tolid_shamsi_2=intval($mm); ELSE $mah_tolid_shamsi_2=12;}  	  
/****************شروع نمایش گزارش*******************/	
$radif=1;
$page=1;
$line=0;
$i=0;
$cntr=0;
$groupkalaName=$db->get_from_where("name_group_kala_top","bzacc.group_kala_top","code_group_kala_top='$code_group_kala_top'");
$q="SELECT * FROM ostan T WHERE code_ostan IN(SELECT code_ostan FROM list_sardkhane) AND($Condition_ostan) ORDER BY name_ostan";
$res=$db->query($q);
$cntr =mysql_num_rows($res);
if(mysql_num_rows($res)>0)//وجود اطلاعات
{echo'
 <br>
  <div class="table2excel">
   <table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
	<tr class="noExl">
     <td colspan="50">
	  <table width="100%"  align="center">
       <tr class="noExl"><td class="print_title_2">'.$mt_gl_owner.'</td></tr>
	   <tr class="noExl"> 
		<td class="print_title_2">'; 
		IF($page==1){
			 echo'<a href="javascript:window.print();"><span style="float:right" id="printerReport" class="hideatprint" title="چاپ"></span></a>
			      <span style="float:right" id="exportExcel" title="خروجی اکسل" ></span>';
		 }
		 echo'
         '.$titr.' : '.$groupkalaName.' &nbsp&nbsp(صفحه : '.$page.')
	     <div style="float:left;"><button class="buttonme hideatprint" onClick="window.location=\''.$FileName.'\'">بازگشت</button></div>
	    </td>
       </tr>
      </table>
	 </td>
	</tr>';
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
 if($noe_namayesh==1) $filter_string.=" نمایش اطلاعات : خالص";
 if($noe_namayesh==2) $filter_string.=" نمایش اطلاعات : ناخالص";
 if($noe_namayesh==3) $filter_string.=" نمایش اطلاعات : تعداد";
 if($mah_tolid_shamsi_1)$filter_string.=" از : $mahshamsiArr[$mah_tolid_shamsi_1]";
 if($sal_tolid_shamsi_1)$filter_string.=" $sal_tolid_shamsi_1";
 if($mah_tolid_shamsi_2)$filter_string.=" نا : $mahshamsiArr[$mah_tolid_shamsi_2]";
 if($sal_tolid_shamsi_2)$filter_string.=" $sal_tolid_shamsi_2";
 echo'<tr class="noExl"><td class="filter_text" colspan="50">فیلتر شده براساس : '.$filter_string.'</td></tr>';
  echo'
   <tr class="print_table-title2">
	 <td width="5%">ردیف</td>
	 <td width="10%">استان</td>';
	 //ایجاد حلقه ماه تولید
	 $sal=$sal_tolid_shamsi_1;
	 $mah=$mah_tolid_shamsi_1;
	 $counter=0;
	 $sal_diff=$sal_tolid_shamsi_2-$sal_tolid_shamsi_1;
	 if($sal_diff==0)$mah_diff=$mah_tolid_shamsi_2-$mah_tolid_shamsi_1;
	 else if($sal_diff==1)$mah_diff=12-$mah_tolid_shamsi_1+$mah_tolid_shamsi_2;
	 else if($sal_diff>=2)$mah_diff=($sal_diff*12)-$mah_tolid_shamsi_1+$mah_tolid_shamsi_2;
	 while($sal<=$sal_tolid_shamsi_2 and $counter<=$mah_diff)
	 {	  	   	  
	   echo'<td>'.$mahshamsiArr[$mah].$sal.'</td>';
	   if($mah==12)
	   {$mah=1;$sal++;}
	  else $mah++;
	  $counter++;
	 }
	 echo'
	 <td width="15%">جمع</td>'; 
   while($row=$db->fetch_array($res))//ostan while
   {	
    $line++;
	if($i++%2)echo'<tr class="print_table-odd">';
    else echo'<tr class="print_table-even">';
    echo'   
    <td>'.$radif++.'</td>
    <td>'.$row['name_ostan'].'</td>';
	/**************************ایجاد حلقه ماه تولید**************************/
	   $sal=$sal_tolid_shamsi_1;
	   $mah=$mah_tolid_shamsi_1;
	   $counter=0;
	   $sal_diff=$sal_tolid_shamsi_2-$sal_tolid_shamsi_1;
	   if($sal_diff==0)$mah_diff=$mah_tolid_shamsi_2-$mah_tolid_shamsi_1;
	   else if($sal_diff==1)$mah_diff=12-$mah_tolid_shamsi_1+$mah_tolid_shamsi_2;
	   else if($sal_diff>=2)$mah_diff=($sal_diff*12)-$mah_tolid_shamsi_1+$mah_tolid_shamsi_2;
	   $jame_mojody_PerOstan=0;//جمع موجودی کل کالاها در هر استان
	   IF($noe_namayesh==1){$avalField='mojody_khales_aval';$residField='vazn_khales_r_d_sub';$havaleField='vazn_khales_h_d';$tadilField='meghdar_khales_tadil';$vahed='کیلوگرم';}
	   ELSE IF($noe_namayesh==2){$avalField='mojody_nakhales_aval';$residField='vazn_nakhales_r_d_sub';$havaleField='vazn_nakhales_h_d';$tadilField='meghdar_nakhales_tadil';$vahed='کیلوگرم';}
	   ELSE IF($noe_namayesh==3){$avalField='tedad_karton_aval';$residField='tedad_karton_r_d_sub';$havaleField='tedad_karton_h_d';$tadilField='tedad_karton_tadil';$vahed='تعداد';}				 
	   ELSE IF($noe_namayesh==4){$avalField='tedad_shane_aval';$residField='tedad_shane_r_d_sub';$havaleField='tedad_shane_h_d';$tadilField='tedad_shane_tadil';$vahed='شانه';}				 
	   while($sal<=$sal_tolid_shamsi_2 and $counter<=$mah_diff)
	   {	  	   	  
		 /****************محاسبه مانده موجودی*******************/		  
	      $mojodyKala=0;
	      $mojodyAval=$db->get_from_where("SUM($avalField)","mojody_kala T INNER JOIN kala ON T.code_kala=kala.code_kala INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_anbar_activate $Condition_movaghat year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND code_group_kala_top='$code_group_kala_top' AND sal_tolid_shamsi='$sal' AND mah_tolid_shamsi='$mah' AND deleted=0 and($Condition_anbar)");     	  
	      $jameVarede=$db->get_from_where("SUM($residField)","resid_kala_detail T INNER JOIN resid r ON T.shomare_resid=r.shomare_resid AND T.code_ostan=r.code_ostan AND T.code_anbar=r.code_anbar AND T.year=r.year INNER JOIN kala ON T.code_kala=kala.code_kala INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_anbar_activate $Condition_movaghat T.year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND code_group_kala_top='$code_group_kala_top' AND sal_tolid_shamsi='$sal' AND mah_tolid_shamsi='$mah' AND resid_deleted=0 AND T.status=0 AND r.tarikh_resid>='".$date1."' AND r.tarikh_resid<='".$date2."' and($Condition_anbar)");
          $jameSadere=$db->get_from_where("SUM($havaleField)","havale_detail T INNER JOIN havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year INNER JOIN kala ON T.code_kala=kala.code_kala INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_anbar_activate $Condition_movaghat T.year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND code_group_kala_top='$code_group_kala_top' AND sal_tolid_shamsi='$sal' AND mah_tolid_shamsi='$mah' AND havale_deleted=0 AND T.status=0 AND h.tarikh_havale_anbar>='".$date1."' AND h.tarikh_havale_anbar<='".$date2."' and($Condition_anbar)");
	      $Tadil_Ezafe=$db->get_from_where("SUM($tadilField)","tadil_mojody T INNER JOIN kala ON T.code_kala=kala.code_kala INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_anbar_activate $Condition_movaghat noe_tadil=1 AND year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND code_group_kala_top='$code_group_kala_top' AND sal_tolid_shamsi='$sal' AND mah_tolid_shamsi='$mah' AND deleted=0  AND status=0 AND tarikh_barge_tadil>='".$date1."' AND tarikh_barge_tadil<='".$date2."' and($Condition_anbar)");
	      $Tadil_Kasry=$db->get_from_where("SUM($tadilField)","tadil_mojody T INNER JOIN kala ON T.code_kala=kala.code_kala INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_anbar_activate $Condition_movaghat noe_tadil=2 AND year='$mtActiveYear' AND T.code_ostan=".$row['code_ostan']." AND code_group_kala_top='$code_group_kala_top' AND sal_tolid_shamsi='$sal' AND mah_tolid_shamsi='$mah' AND deleted=0  AND status=0 AND tarikh_barge_tadil>='".$date1."' AND tarikh_barge_tadil<='".$date2."' and($Condition_anbar)");
	      $mojodyKala=round($mojodyAval+$jameVarede-$jameSadere+$Tadil_Ezafe-$Tadil_Kasry,3);	      
		 //نمایش اطلاعات
		 echo'<td>'.round($mojodyKala,3).'</td>';
	     if($mah==12){$mah=1;$sal++;}
	     else $mah++;
	    $counter++;
	    $jame_mojody_PerOstan+=$mojodyKala;//جمع موجودی کل کالاها در هر استان  
	   }
	   echo'<td>'.round($jame_mojody_PerOstan,3).'</td>';

	  /*****تکرار سرصفحه و ستون ها*****/
	  if($line>=$MaxLines && $i <$cntr) 
	  {
	     $line=0;
         $page++;
	     echo'
		 </table>
		   <br class="pbreak">';
		    print_header();
	  }
	  
   }//END ostan while
   /*****سطر جمع کل استان ها*****/
   echo'
	 <tr class="print_table-even sum-row" style="background-color:#FFF;" >
	  <td colspan="2">جمع کل</td>';
	   $sal=$sal_tolid_shamsi_1;
	   $mah=$mah_tolid_shamsi_1;
	   $counter=0;
	   $sal_diff=$sal_tolid_shamsi_2-$sal_tolid_shamsi_1;
	   if($sal_diff==0)$mah_diff=$mah_tolid_shamsi_2-$mah_tolid_shamsi_1;
	   else if($sal_diff==1)$mah_diff=12-$mah_tolid_shamsi_1+$mah_tolid_shamsi_2;
	   else if($sal_diff>=2)$mah_diff=($sal_diff*12)-$mah_tolid_shamsi_1+$mah_tolid_shamsi_2;
	   $jame_mojody_Kal=0;//جمع موجودی کل کالاها در هر استان
       while($sal<=$sal_tolid_shamsi_2 and $counter<=$mah_diff)
	   {	  	   	  
		 /****************محاسبه مانده موجودی*******************/		  
	      $mojodyKalaKol=0;
	      $mojodyAval=$db->get_from_where("SUM($avalField)","mojody_kala T INNER JOIN kala ON T.code_kala=kala.code_kala INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_anbar_activate $Condition_movaghat year='$mtActiveYear' AND code_group_kala_top='$code_group_kala_top' AND sal_tolid_shamsi='$sal' AND mah_tolid_shamsi='$mah' AND deleted=0 AND($Condition_ostan) and($Condition_anbar)");     	  
	      $jameVarede=$db->get_from_where("SUM($residField)","resid_kala_detail T INNER JOIN meat.resid r ON T.shomare_resid=r.shomare_resid AND T.code_ostan=r.code_ostan AND T.code_anbar=r.code_anbar AND T.year=r.year INNER JOIN kala ON T.code_kala=kala.code_kala INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_anbar_activate $Condition_movaghat T.year='$mtActiveYear'  AND code_group_kala_top='$code_group_kala_top' AND sal_tolid_shamsi='$sal' AND mah_tolid_shamsi='$mah' AND resid_deleted=0 AND T.status=0 AND r.tarikh_resid>='".$date1."' AND r.tarikh_resid<='".$date2."' AND($Condition_ostan) and($Condition_anbar)");
          $jameSadere=$db->get_from_where("SUM($havaleField)","havale_detail T INNER JOIN havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year INNER JOIN kala ON T.code_kala=kala.code_kala INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_anbar_activate $Condition_movaghat T.year='$mtActiveYear'  AND code_group_kala_top='$code_group_kala_top' AND sal_tolid_shamsi='$sal' AND mah_tolid_shamsi='$mah' AND havale_deleted=0 AND T.status=0 AND h.tarikh_havale_anbar>='".$date1."' AND h.tarikh_havale_anbar<='".$date2."' AND($Condition_ostan) and($Condition_anbar)");
	      $Tadil_Ezafe=$db->get_from_where("SUM($tadilField)","tadil_mojody T INNER JOIN kala ON T.code_kala=kala.code_kala INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_anbar_activate $Condition_movaghat noe_tadil=1 AND year='$mtActiveYear'  AND code_group_kala_top='$code_group_kala_top' AND sal_tolid_shamsi='$sal' AND mah_tolid_shamsi='$mah' AND deleted=0  AND status=0 AND tarikh_barge_tadil>='".$date1."' AND tarikh_barge_tadil<='".$date2."' AND($Condition_ostan) and($Condition_anbar)");
	      $Tadil_Kasry=$db->get_from_where("SUM($tadilField)","tadil_mojody T INNER JOIN kala ON T.code_kala=kala.code_kala INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","$Condition_anbar_activate $Condition_movaghat noe_tadil=2 AND year='$mtActiveYear' AND code_group_kala_top='$code_group_kala_top' AND sal_tolid_shamsi='$sal' AND mah_tolid_shamsi='$mah' AND deleted=0  AND status=0 AND tarikh_barge_tadil>='".$date1."' AND tarikh_barge_tadil<='".$date2."' AND($Condition_ostan) and($Condition_anbar)");
	      $mojodyKalaKol=round($mojodyAval+$jameVarede-$jameSadere+$Tadil_Ezafe-$Tadil_Kasry,3);	      
		 //نمایش اطلاعات
		 echo'<td>'.round($mojodyKalaKol,3).'</td>';
	     if($mah==12){$mah=1;$sal++;}
	     else $mah++;
	    $counter++;
	    $jame_mojody_Kal+=$mojodyKalaKol;//جمع موجودی کل کالاها در هر استان  
	   }  
	   echo '<td>'.round($jame_mojody_Kal,3).'</td>
	 </tr>';
	 //END//
	 echo'
  <!--پايان مرکز صفحه -->
  <!-- چاپ زیرنوس-->';
  require_once('prt-footer.php');
 echo' 
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