<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="report_manager_zarfiyat.php";
$ExcelFileName=str_replace('.php','',$FileName);
$titr='گزارش ظرفیت قراردادی و موجودی سردخانه ها';
require_once('head.html');
/****************هدر******************/
$columns='	
	<tr class="print_table-title2">
	 <td width="5%">ردیف</td>
	 <td width="15%">استان</td>
	 <td width="5%">کد سردخانه</td>
	 <td width="15%">نام سردخانه</td>
	 <td width="5%">وضعیت</td>
	 <td width="5%">نوع مالکیت</td>
	 <td width="15%">ظرفیت قراردادی سردخانه</td>
	 <td width="15%">موجودی سردخانه</td>
	 <td width="15%">درصد بهره وری</td>
	</tr>';
Function print_header()
{global $titr,$mt_gl_owner,$code_kala,$code_kala2,$date1,$date2,$code_anbar,$FileName,$page,$kalaName,$db,$kalaName,$code_kala,$Condition;
  echo'   
   <br>
   <table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
    <tr class="noExl">
	 <td colspan="40">
      <table width="100%" align="center">
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
         <div style="float:left;"><button class="buttonme hideatprint" onClick="window.location=\''.$FileName.'\'">بازگشت</button></div>	    </td>
	   </tr>
      </table>
     </td>
    </tr>';
}
/****************فیلترها روی گزارش******************/
/******************استان ها******************/
if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
{  
     if(is_array($ostanchoice))//کد های استان
     {
       foreach($ostanchoice as $key => $ostan_val) 
      {
       $Condition_ostan_temp.=" code_ostan='$ostan_val' OR";
      }
      if($ostan_val==-1){$Condition_ostan.="1=1 OR";}
      else {$Condition_ostan.=" $Condition_ostan_temp";}
       $lastSpacePosition = strrpos($Condition_ostan," ");
       $Condition_ostan =substr($Condition_ostan,0,$lastSpacePosition);
     }
}
else 
{$Condition_ostan=' code_ostan='.$_SESSION['mt_code_ostan'].'';}
/**************انتخاب گروه کالا****************/
if(is_array($grkalachoice))
{
 foreach($grkalachoice as $grkala_key => $grkala_val) {
  $Condition_grkala_temp.=" code_group_kala_top='$grkala_val' OR";
 }
  if($grkala_val==-1)$Condition_grkala.="1=1 OR";
  else $Condition_grkala.=" $Condition_grkala_temp";
 $lastSpacePosition = strrpos($Condition_grkala," ");
 $Condition_grkala =substr($Condition_grkala,0,$lastSpacePosition);
}
/******************مالکیت انبارها******************/  
if(is_array($malekiyatchoice))
{
    foreach($malekiyatchoice as $key => $mal_val) 
    {
       $Condition_malekiyat_temp.=" noe_malekiyat='$mal_val' OR";
    }
    if($mal_val==-1){$Condition_malekiyat.="1=1 OR";}
    else {$Condition_malekiyat.=" $Condition_malekiyat_temp";}
    $lastSpacePosition = strrpos($Condition_malekiyat," ");
    $Condition_malekiyat =substr($Condition_malekiyat,0,$lastSpacePosition);
}
/******************نمایش یا عدم نمایش انبارهای موقت/حقیقی و مجازی******************/
if($chkmovaghat=='on') $Condition_movaghat="";
else $Condition_movaghat="situation_type=1 AND ";
/******************نمایش یا عدم نمایش انبارهای غیرفعال******************/
if($chkactivate=='on') {$Condition_anbar_activate=""; $Condition_anbar_activate_ostan="1=1";}
else {$Condition_anbar_activate="activate=1 AND"; $Condition_anbar_activate_ostan="activate=1";}
/***************************************** MAIN*****************************************/
echo'
<body class="openwin" onload="document.myform.date2.focus();">
<form method="post" name="myform" onkeydown="enterIE()">';
if(!$MaxLines)$MaxLines=3;
//اگر کاربر تاریخ اول را وارد نکرده بود
if(!$date1)
{
  $date1=$db->get_from_where("start_from","mt_docs","year='$mtActiveYear'");  
}
//اگر کاربر تاریخ دوم را وارد نکرده بود
if(!$date2)
{
     $ExcelFileName=str_replace('.php','',$FileName); 
     $end_date_session=$db->get_from_where("end_to","mt_docs","year='$mtActiveYear'");
     if($today<$end_date_session) $date2=$today;
     else  $date2=$end_date_session;	 
}  
if(!$ok)
{
echo'
<table width="95%" height="100%" align="center" cellpadding="0" cellspacing="0">
 <tr>
  <td height="100%">
   <table width="650px" border="0" align="center" cellpadding="0" cellspacing="0" >
    <tr><td colspan="4" height="20px">&nbsp;</td></tr>
	<tr>
     <td colspan="4" class="title">'.$titr.'</td>	 
    </tr>
    <tr class="tr1" style="height:45px">	
     <td align="left"> از تاریخ : </td><td align="right">&nbsp;<input type="text" class="textboxme2" maxlength="10" name="date1" id="datepickerfrom" value="'.$date1.'" readonly/></td>
     <td align="left"> تا تاریخ : </td><td align="right">&nbsp;<input type="text" class="textboxme2" maxlength="10" name="date2" id="datepickerto" placeholder="'.$date2.'"/></td>
	</tr>
	<tr class="tr1">
	 <td align="left"><input type="checkbox" name="chkmovaghat"/></td><td align="right">&nbsp; نمایش اطلاعات سردخانه موقت / مجازی</td>
	 <td align="left"><input type="checkbox" name="chkactivate"/></td><td align="right">&nbsp; نمایش اطلاعات سردخانه های غیرفعال</td>
    <tr  class="tr1">
     <td align="left">گروه کالا : </td>
     <td align="right">
	  &nbsp;<select name="grkalachoice[]" class="easyui-combobox" size="6" style="width:100px;" panelHeight="190px" multiple>';
	  $result_grkala = $db->query("SELECT * FROM bzacc.group_kala_top WHERE group_type_top=2");
      $grkala_options = "<option value='-1' selected>همه</option>";
      while($row_grkala=$db->fetch_assoc($result_grkala)) $grkala_options .= "<option value=".$row_grkala['code_group_kala_top'].">".$row_grkala['name_group_kala_top']."</option>";
	  echo $grkala_options;
	  echo'
	  </select>
	 </td>	
	 <td align="left"> تعداد استان در صفحه : </td><td align="right">&nbsp;<input type="number" class="textboxme2" name="MaxLines" value="'.$MaxLines.'" onkeypress="return isNumber(event)"/></td>
	</tr>
    <tr class="tr1" style="height:45px">
	 <td align="left" style="height:45px">نوع مالکیت : </td>
	 <td align="right">
	 &nbsp;<select name="malekiyatchoice[]" class="easyui-combobox" size="6" style="width:100px;" data-options=panelHeight:155 multiple>';
	 $malekiyat_options = "<option value='-1' selected>همه</option>";
	 foreach($noe_malekiyatArr AS $key=>$val)
	 {
	  IF($key==0)continue;
	  $malekiyat_options .= "<option value=".$key.">".$val."</option>";
	 }
	 echo $malekiyat_options;
	 echo'
	   </select>      
	 </td>';
	if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
	{
	 echo'
	  <td align="left">نام استان : </td>
      <td align="right" colspan="3">
	   &nbsp;<select name="ostanchoice[]" class="easyui-combobox" size="6" style="width:200px;" multiple>';
	   $result_ostan = $db->query("SELECT * FROM ostan ORDER BY name_ostan");
       $ostan_options = "<option value='-1' selected>همه استانها</option>";
       while($row_ostan=$db->fetch_assoc($result_ostan)) $ostan_options .= "<option value=".$row_ostan['code_ostan'].">".$row_ostan['name_ostan']."</option>";
	   echo $ostan_options;
	   echo'
	   </select>      
	  </td>';
	}
	else echo'<td colspan="2">&nbsp;</td>';
	echo'
	</tr>
	<tr class="footer"><td colspan="4" align="center"><input class="buttonme" type="submit" name="ok" value="شروع گزارش"></td>	</tr> 
   </table>
  </td>
 </tr>
</table> ';
}
else
{
    $malekiyatArr=array();//آرایه جدید برای ایجاد حلقه سطرهای مجموع استان
	IF((count($malekiyatchoice)==1)AND(in_array(-1,$malekiyatchoice)))//اگر فقط همه انتخاب شده باشد
	{
			foreach($noe_malekiyatArr AS $key=>$val)
			{
			 array_push($malekiyatArr,$key);
			}
			//array_shift($malekiyatArr);//عنصر - را از آرایه حذف کردم
			array_unshift($malekiyatArr,'-1');//عنصر (-1) را به اول آرایه اضافه کردم
	}
	ELSE $malekiyatArr=$malekiyatchoice;//در بقیه موارد همان آرایه ایی که از انتخاب کاربر شکل گرفته 
	/****************شروع نمایش گزارش*******************/	
	$radif=1;
	$page=1;
    $line=0;
    $i=0;
    $cntr=0;
	$q="SELECT * FROM ostan WHERE code_ostan IN(SELECT code_ostan FROM list_sardkhane WHERE $Condition_movaghat $Condition_anbar_activate_ostan AND($Condition_malekiyat)) AND($Condition_ostan) ORDER BY name_ostan";
	$res=$db->query($q);
	$cntr =mysql_num_rows($res);
	if(mysql_num_rows($res)>0)
    {
    echo'   
     <br>
     <div class="table2excel">
	 <table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
      <tr class="noExl">
	   <td colspan="40">
        <table width="100%" align="center">
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
           <div style="float:left;"><button class="buttonme hideatprint" onClick="window.location=\''.$FileName.'\'">بازگشت</button></div>	       </td>
	      </tr>
        </table>
       </td>
      </tr>';
	 /*سطر نمایش فیلترها*/
	 if(is_array($ostanchoice))
     {
	  if($ostan_val==-1)$filter_string='همه استانها';
	  else $filter_string=' استان : ';
	  foreach($ostanchoice as $key => $ostan_val) {
	   $nameOstan=$db->get_from_where("name_ostan","ostan","code_ostan='$ostan_val'");
	   $filter_string.=''.$nameOstan.'&nbsp;';
      }
     }
	 if(is_array($grkalachoice))
     {
	     if($grkala_val==-1)$filter_string.=' همه کالاها';
	     else $filter_string.=' گروه کالا : ';
	     foreach($grkalachoice as $grkala_key => $grkala_val) {
	     $nameGrKala=$db->get_from_where("name_group_kala_top","bzacc.group_kala_top","code_group_kala_top='$grkala_val'");
	     $filter_string.=''.$nameGrKala.'&nbsp;';
         }
     }
	 if(is_array($malekiyatchoice))
     {
  	   $filter_string.=' - نوع مالکیت  : ';
       if($mal_val==-1)$filter_string.=' همه ';
  	   else{
  	 	 foreach($malekiyatchoice as $mal_key => $mal_val) {
  	       $nameMalekiyat=$noe_malekiyatArr[$mal_val];
  	       $filter_string.=''.$nameMalekiyat.'&nbsp;';
            }	 
       } 
     }
	 if($chkmovaghat==TRUE) $filter_string.=' با اطلاعات انبار موقت /مجازی -';
     if($chkmovaghat==False) $filter_string.=' بدون اطلاعات انبار موقت / مجازی -';
	 if($chkactivate==TRUE) $filter_string.=' با اطلاعات انبار غیرفعال ';
     if($chkactivate==False) $filter_string.=' بدون اطلاعات انبار غیرفعال';
	 echo'<tr class="noExl"><td class="filter_text" colspan="40">فیلتر شده براساس : '.$filter_string.'</td></tr>';
     echo $columns;
	 while($row=$db->fetch_assoc($res))
	 {   
	  $jame_zarfiyat_melki=0;$jame_zarfiyat_estijari=0;$jame_zarfiyat_amani=0;$jame_zarfiyat_markazKh=0;$jame_zarfiyat_ostan=0;
	  $jame_mojody_melki=0;$jame_mojody_estijari=0;$jame_mojody_amani=0;$jame_mojody_markazKh=0;$jame_mojody_ostan=0;
	  $jame_bahrevary_melki=0;$jame_bahrevary_estijari=0;$jame_bahrevary_amani=0;$jame_bahrevary__markazKh=0;$jame_bahrevary_ostan=0;
	  $line++;
	  //تعداد انبار ها
	  if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))$tedadanbar=$db->get_from_where("count(*)","list_sardkhane","$Condition_movaghat $Condition_anbar_activate ($Condition_malekiyat) AND code_ostan=".$row['code_ostan']."");//تعداد انبارهای هر استان 
	  else $tedadanbar=$db->get_from_where("count(user_ostan_anbar.code_anbar)","user_ostan_anbar INNER JOIN list_sardkhane ON list_sardkhane.code_ostan=user_ostan_anbar.code_ostan AND list_sardkhane.code_anbar=user_ostan_anbar.code_anbar","$Condition_movaghat $Condition_anbar_activate ($Condition_malekiyat) AND list_sardkhane.code_ostan=".$row['code_ostan']." AND user_id=".$_SESSION['mt_user_id']."");//تعداد انبارهای هر استان     
	  $rowanbar=$tedadanbar;
	  $t=$rowanbar;
	  if($i++%2)echo'<tr class="print_table-odd">';
      else echo'<tr class="print_table-even">';
	  echo'   
		 <td rowspan="'.$rowanbar.'">'.$radif++.'</td>
	     <td rowspan="'.$rowanbar.'" style="font-weight:bold">'.$row['name_ostan'].'</td>';
		   /**///حلقه روی انبار ها
		   if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))$q2="SELECT * FROM list_sardkhane WHERE $Condition_movaghat $Condition_anbar_activate ($Condition_malekiyat) AND code_ostan=".$row['code_ostan']." ORDER BY name_anbar";
		   else $q2="SELECT * FROM user_ostan_anbar INNER JOIN list_sardkhane ON list_sardkhane.code_ostan=user_ostan_anbar.code_ostan AND list_sardkhane.code_anbar=user_ostan_anbar.code_anbar WHERE $Condition_movaghat $Condition_anbar_activate ($Condition_malekiyat) AND list_sardkhane.code_ostan=".$row['code_ostan']." AND user_id=".$_SESSION['mt_user_id']." ORDER BY name_anbar";
		   $res2=$db->query($q2);
		   while($row2=$db->fetch_assoc($res2))
		   {	   
			$j=$i+1;
			//موجودی کل کالاها در هر انبار
			$mojodyAval=$db->get_from_where("SUM(mojody_khales_aval)","mojody_kala INNER JOIN kala ON kala.code_kala=mojody_kala.code_kala","code_ostan=".$row['code_ostan']." AND code_anbar=".$row2['code_anbar']." AND year='$mtActiveYear' AND deleted=0 AND($Condition_grkala)");        	
            $jameVarede=$db->get_from_where("SUM(vazn_khales_r_d_sub)","resid_kala_detail T INNER JOIN resid as r ON r.shomare_resid=T.shomare_resid AND r.code_ostan=T.code_ostan AND r.code_anbar=T.code_anbar AND r.year=T.year INNER JOIN kala ON kala.code_kala=T.code_kala","T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']."  AND T.year='$mtActiveYear' AND r.deleted=0 AND T.status=0 AND tarikh_resid<='$date2' AND($Condition_grkala)");
            $jameSadere=$db->get_from_where("SUM(vazn_khales_h_d)","havale_detail T INNER JOIN havale as h ON h.shomare_havale_anbar=T.shomare_havale_anbar AND h.code_ostan=T.code_ostan AND h.code_anbar=T.code_anbar AND h.year=T.year INNER JOIN kala ON kala.code_kala=T.code_kala","T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row2['code_anbar']." AND T.year='$mtActiveYear' AND h.deleted=0 AND T.status=0 AND tarikh_havale_anbar<='$date2' AND($Condition_grkala)");
			$meghdarTadil_Ezafe=$db->get_from_where("SUM(meghdar_khales_tadil)","tadil_mojody INNER JOIN kala ON kala.code_kala=tadil_mojody.code_kala","noe_tadil=1 AND code_ostan=".$row['code_ostan']." AND code_anbar=".$row2['code_anbar']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil<='$date2' AND($Condition_grkala)");
            $meghdarTadil_Kasry=$db->get_from_where("SUM(meghdar_khales_tadil)","tadil_mojody INNER JOIN kala ON kala.code_kala=tadil_mojody.code_kala","noe_tadil=2 AND code_ostan=".$row['code_ostan']." AND code_anbar=".$row2['code_anbar']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil<='$date2' AND($Condition_grkala)");
            $mojody=$mojodyAval+$jameVarede-$jameSadere+$meghdarTadil_Ezafe-$meghdarTadil_Kasry;	
			 
			$bahrevary=round((($mojody/$row2['zarfiyat_gharardadi'])*100),1);
			echo'
		     <td>'.$row2['code_anbar'].'</td>
		     <td>'.$row2['name_anbar'].'</td>
		     <td>'.$activateArr[$row2['activate']].'</td>
			 <td>'.$noe_malekiyatArr[$row2['noe_malekiyat']].'</td>
			 <td>'.virgul($row2['zarfiyat_gharardadi']).'</td>
			 <td>'.round($mojody,3).'</td>
			 <td>'.$bahrevary.'</td>';
			  $t--;
			  if($t==0) echo'';
			  else 
			  {
			   echo'</tr>';
			   echo'<tr ';if($j++%2) echo 'class="print_table-odd"'; else echo 'class="print_table-even"'; echo' >';
			  }
			 //محاسبه مجموع مقادیر
			 IF($row2['noe_malekiyat']==1)//ملکی
			 {
				 $jame_zarfiyat_melki+=$row2['zarfiyat_gharardadi'];//استان
				 $jame_mojody_melki+=$mojody;
			     //$jame_bahrevary_melki+=$bahrevary;
				 $jame_bahrevary_melki=round((($jame_mojody_melki/$jame_zarfiyat_melki)*100),1);
				 $jame_zarfiyat_melki_kol+=$row2['zarfiyat_gharardadi'];//کل کشور
				 $jame_mojody_melki_kol+=$mojody;
			     //$jame_bahrevary_melki_kol+=$bahrevary;
				 $jame_bahrevary_melki_kol=round((($jame_mojody_melki_kol/$jame_zarfiyat_melki_kol)*100),1);
			 }
			 ELSE IF($row2['noe_malekiyat']==2)//استیجاری
			 {
				 $jame_zarfiyat_estijari+=$row2['zarfiyat_gharardadi'];//استان
				 $jame_mojody_estijari+=$mojody;
			     //$jame_bahrevary_estijari+=$bahrevary;
				 $jame_bahrevary_estijari=round((($jame_mojody_estijari/$jame_zarfiyat_estijari)*100),1);
				 $jame_zarfiyat_estijari_kol+=$row2['zarfiyat_gharardadi'];//کل کشور
				 $jame_mojody_estijari_kol+=$mojody;
			     //$jame_bahrevary_estijari_kol+=$bahrevary;
				 $jame_bahrevary_estijari_kol=round((($jame_mojody_estijari_kol/$jame_zarfiyat_estijari_kol)*100),1);
			 }
			 ELSE IF($row2['noe_malekiyat']==3)//امانی
			 {
				 $jame_zarfiyat_amani+=$row2['zarfiyat_gharardadi'];//استان
				 $jame_mojody_amani+=$mojody;
			     //$jame_bahrevary_amani+=$bahrevary;
				 $jame_bahrevary_amani=round((($jame_mojody_amani/$jame_zarfiyat_amani)*100),1);
				 $jame_zarfiyat_amani_kol+=$row2['zarfiyat_gharardadi'];//کل کشور
				 $jame_mojody_amani_kol+=$mojody;
			     //$jame_bahrevary_amani_kol+=$bahrevary;
				 $jame_bahrevary_amani_kol=round((($jame_mojody_amani_kol/$jame_zarfiyat_amani_kol)*100),1);
			 }
			 ELSE IF($row2['noe_malekiyat']==4)//مرکز خرید
			 {
				 $jame_zarfiyat_markazKh+=$row2['zarfiyat_gharardadi'];//استان
				 $jame_mojody_markazKh+=$mojody;
			     //$jame_bahrevary_markazKh+=$bahrevary;
				 $jame_bahrevary_markazKh=round((($jame_mojody_markazKh/$jame_zarfiyat_markazKh)*100),1);
				 $jame_zarfiyat_markazKh_kol+=$row2['zarfiyat_gharardadi'];//کل کشور
				 $jame_mojody_markazKh_kol+=$mojody;
			     //$jame_bahrevary_markazKh_kol+=$bahrevary;
				 $jame_bahrevary_markazKh_kol=round((($jame_mojody_markazKh_kol/$jame_zarfiyat_markazKh_kol)*100),1);
			 }
			 //استان
			 $jame_zarfiyat_ostan+=$row2['zarfiyat_gharardadi'];
			 $jame_mojody_ostan+=$mojody;
			 //$jame_bahrevary_ostan+=$bahrevary;
			 $jame_bahrevary_ostan=round((($jame_mojody_ostan/$jame_zarfiyat_ostan)*100),1);
             //کل کشور
			 $jame_zarfiyat_kol+=$row2['zarfiyat_gharardadi'];
			 $jame_mojody_kol+=$mojody;
             //$jame_bahrevary_kol+=$bahrevary;
			 $jame_bahrevary_kol=round((($jame_mojody_kol/$jame_zarfiyat_kol)*100),1);
		   }//END anbar while
		   /*****سطر جمع کل انبارهای هر استان*****/ 
		   /*****شروع حلقه سطر های جمع هر استان*****/
		   foreach(array_reverse($malekiyatArr) as $mal_key => $mal_val) 
		   {
			IF($mal_val=='-1') $MalekiyatCondition='';
			ELSE $MalekiyatCondition='noe_malekiyat='.$mal_val.' AND';
		    $count_anbar_with_malekiyat=$db->get_from_where("count(code_anbar)","list_sardkhane","$Condition_movaghat $Condition_anbar_activate $MalekiyatCondition code_ostan=".$row['code_ostan']."");
			IF($count_anbar_with_malekiyat>0)
			{
			 echo'
		     <tr class="print_table-even sum-row" style="background-color:#FFF;">';
			 if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))echo'<td colspan="6">جمع کل سردخانه های '.$noe_malekiyatArr[$mal_val].' استان '.$row['name_ostan'].'  </td>';
		   	 else echo'<td colspan="6">جمع کل</td>';
			 IF($mal_val==1)//ملکی
			 {echo'
			  <td>'.virgul($jame_zarfiyat_melki).'</td>
			  <td>'.round($jame_mojody_melki,3).'</td>	
			  <td>'.($jame_bahrevary_melki).'</td>';
			 }
			 ELSE IF($mal_val==2)//استیجاری
			 {echo'
			  <td>'.virgul($jame_zarfiyat_estijari).'</td>
			  <td>'.round($jame_mojody_estijari,3).'</td>	
			  <td>'.($jame_bahrevary_estijari).'</td>';
			 }
			 ELSE IF($mal_val==3)//امانی
			 {echo'
			  <td>'.virgul($jame_zarfiyat_amani).'</td>
			  <td>'.round($jame_mojody_amani,3).'</td>	
			  <td>'.($jame_bahrevary_amani).'</td>';
			 }
			 ELSE IF($mal_val==4)//مرکز خرید
			 {echo'
			  <td>'.virgul($jame_zarfiyat_markazKh).'</td>
			  <td>'.virgul($jame_mojody_markazKh).'</td>	
			  <td>'.($jame_bahrevary_markazKh).'</td>';
			 }
			 ELSE IF($mal_val==-1)//همه
			 {echo'
			  <td>'.virgul($jame_zarfiyat_ostan).'</td>
			  <td>'.round($jame_mojody_ostan,3).'</td>	
			  <td>'.($jame_bahrevary_ostan).'</td>';
			 }
             echo'			  
		     </tr>';
			}//END IF
		   }//END foreach
		   /*****سطر جمع کل استان*****/
		   // echo'
		   // <tr class="print_table-even sum-row" style="background-color:#FFF;">';
		    // if(($_SESSION['mt_all_ostan']==1)or(SuperUser())) echo'<td colspan="6">جمع کل استان '.$row['name_ostan'].'</td>';
			// else echo'<td colspan="6">جمع کل</td>';
			// echo'
			// <td>'.virgul($jame_zarfiyat_ostan).'</td>
			// <td>'.virgul($jame_mojody_ostan).'</td>	
			// <td>'.($jame_bahrevary).'</td>	
		   // </tr>';
		   
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
	 }//END FIRST while,ostan while
	/*****سطر جمع کل استان ها*****/
	//اگر همه استانها انتخاب شده است $ostan_val==-1
    //if((($_SESSION['mt_all_ostan']==1)or(SuperUser()))and($ostan_val==-1))
    IF((($_SESSION['mt_all_ostan']==1)or(SuperUser())))
	{    
     foreach(array_reverse($malekiyatArr) as $mal_key => $mal_val) 
	 {
	  echo'
		  <tr class="print_table-even sum-row" >
	       <td colspan="6">جمع موجودی سردخانه های '.$noe_malekiyatArr[$mal_val].' استان ها</td>';
			 IF($mal_val==1)//ملکی
			 {echo'
			  <td>'.virgul($jame_zarfiyat_melki_kol).'</td>
			  <td>'.round($jame_mojody_melki_kol,3).'</td>	
			  <td>'.($jame_bahrevary_melki_kol).'</td>';
			 }
			 ELSE IF($mal_val==2)//استیجاری
			 {echo'
			  <td>'.virgul($jame_zarfiyat_estijari_kol).'</td>
			  <td>'.round($jame_mojody_estijari_kol,3).'</td>	
			  <td>'.($jame_bahrevary_estijari_kol).'</td>';
			 }
			 ELSE IF($mal_val==3)//امانی
			 {echo'
			  <td>'.virgul($jame_zarfiyat_amani_kol).'</td>
			  <td>'.round($jame_mojody_amani_kol,3).'</td>	
			  <td>'.($jame_bahrevary_amani_kol).'</td>';
			 }
			 ELSE IF($mal_val==4)//مرکز خرید
			 {echo'
			  <td>'.virgul($jame_zarfiyat_markazKh_kol).'</td>
			  <td>'.round($jame_mojody_markazKh_kol,3).'</td>	
			  <td>'.($jame_bahrevary_markazKh_kol).'</td>';
			 }
			 ELSE IF($mal_val==-1)//همه
			 {echo'
			  <td>'.virgul($jame_zarfiyat_kol).'</td>
			  <td>'.round($jame_mojody_kol,3).'</td>	
			  <td>'.($jame_bahrevary_kol).'</td>';
			 }
             echo'			  
		     </tr>';
     }//END foreach
	}//END IF
	//END//
 echo'
  <!--پايان مرکز صفحه -->
  <!-- چاپ زیرنویس-->
    <tr class="print_footer noExl">
     <td colspan="40">&nbsp;&nbsp;نام کاربر :&nbsp;&nbsp;'.$mtuserNAME.' &nbsp;&nbsp;&nbsp; تاریخ چاپ : '.$today.' &nbsp;&nbsp;&nbsp; ساعت چاپ : '.$logtime.'</td>
    </tr>
 </table>';
 }
 ELSE{
	 echo'
	 <div class="msg_error">
	  <span >اطلاعاتی یافت نشد</span><br>
	  <button class="buttonme hideatprint" onClick="window.location=\''.$FileName.'\'">بازگشت</button>
	 </div>';
 }
}
echo'
</div>	
</form>
</body>
</html>
<a href="#" class="elevator-button"></a>';	
?>
<script type="text/javascript" src="scripts/elevator.min.js"></script>