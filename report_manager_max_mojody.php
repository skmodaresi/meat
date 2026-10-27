<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="report_manager_max_mojody.php";
$titr='گزارش تعیین وضعیت زمان و مقدار ورود و خروج و بالاترین و پایین ترین موجودی';
require_once('head.html');
IF($noe_namayesh==1){$str='(خالص)';$sum_str='کیلوگرم';}
ELSE IF($noe_namayesh==2){$str='(ناخالص)';$sum_str='کیلوگرم';}
ELSE IF($noe_namayesh==3){$str='(تعداد)';$sum_str='تعداد';}
ELSE IF($noe_namayesh==4){$str='(شانه)';$sum_str='شانه';}
$columns='
	<tr class="print_table-title2" style="height:70px;">
	   <td rowspan="2" width=5%>ردیف</td>
	   <td rowspan="2" width=10%>استان</td>
	   <td rowspan="2" width=15%>سردخانه</td>
	   <td rowspan="2" width=8%>نوع مالکیت</td>   
	   <td rowspan="2" width=8%>نوع زیرانبار</td>
	   <td rowspan="2" width=8%>ظرفیت</td>
	   <td rowspan="2" width=8% class="varedePr">مقدار فرآورده ورودی '.$str.'</td>
	   <td rowspan="2" width=8% class="saderePr">مقدار فرآورده خروجی '.$str.' </td>
	   <td colspan="2" width=15% class="maxmojodyPr">بالاترین مقدار موجودی '.$str.'</td>
	   <td colspan="2" width=15% class="minmojodyPr">پایین ترین مقدار موجودی '.$str.'</td>
	</tr>
	<tr class="print_table-title2">
	 <td class="maxmojodyPr">مقدار</td>
	 <td class="maxmojodyPr">تاریخ</td>
	 <td class="minmojodyPr">مقدار</td>
	 <td class="minmojodyPr">تاریخ</td>
	</tr>';
Function print_header()
{global $titr,$mt_gl_owner,$mt_gl_name_anbar,$mt_gl_name_ostan,$date1,$date2,$FileName,$page,$noe_namayesh;
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
/************************استان ها******************/
if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
{  
     if(is_array($ostanchoice))//کد های استان
     {
       foreach($ostanchoice as $key => $ostan_val ) 
      {
       $Condition_ostan_temp.=" T.code_ostan='$ostan_val' OR";
      }
      if($ostan_val==-1){$Condition_ostan.="1=1 OR";}
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
/***************************************** MAIN*****************************************/
echo'
<body class="openwin" onload="document.myform.code_kala.focus();">
<form method="post" name="myform" onkeydown="enterIE()">';
if(!$MaxLines)$MaxLines=15;
if(!$date1)//اگر کاربر تاریخ اول را وارد نکرده بود
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
   <table width="700px" border="0" align="center" cellpadding="0" cellspacing="0" >
    <tr><td colspan="4" height="20px">&nbsp;</td></tr>
	<tr>
     <td colspan="4" class="title">'.$titr.'</td>	 
    </tr>
    <tr class="tr1" style="height:45px;">	
     <td align="left"> از تاریخ :&nbsp;</td><td align="right"><input type="text" class="textboxme2" maxlength="10" name="date1" id="datepickerfrom" placeholder="'.$date1.'"/></td>
     <td align="left"> تا تاریخ :&nbsp;</td><td align="right"><input type="text" class="textboxme2" maxlength="10" name="date2" id="datepickerto" placeholder="'.$date2.'"/></td>
	</tr>
	<tr class="tr1">
	 <!--<td align="left"><input type="checkbox" name="chkmovaghat"/></td><td align="right">&nbsp; همراه با اطلاعات انبار موقت </td>-->
	 <td align="left"> وضعیت نمایش سردخانه های موقت : </td><td align="right">&nbsp;'.static_listbox("show_movaghat",$show_movaghat,"showMovaghatArr",1,"class='text4'").'</td>
	 <td align="left"><input type="checkbox" name="chkactivate" /></td><td align="right">&nbsp; نمایش اطلاعات سردخانه های غیرفعال</td>
	</tr>
    <tr class="tr1">
	 <td align="left"> نمایش اطلاعات :&nbsp;</td><td align="right" >'.static_listbox("noe_namayesh",$noe_namayesh,"namayeshArr",1,"class='easyui-combobox text4' style=width:100px data-options=panelHeight:125").'</td>		
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
	 </td>
	</tr>
    <tr class="tr1">	
	 <td align="left" style="height:40px"> تعداد خط در صفحه : </td><td align="right" colspan="3">&nbsp;<input type="number" class="textboxme2" name="MaxLines" value="'.$MaxLines.'" onkeypress="return isNumber(event)"/></td>
	</tr>
	<!--<tr class="tr1" style="height:40px">
     <td align="left">نام کالا : </td>
     <td align="right" colspan="3">
	  &nbsp;<select name="kalachoice[]" class="easyui-combobox" size="6" style="width:300px;" multiple>';
	  $result_kala = $db->query("SELECT * FROM kala ORDER BY name_kala");
      $kala_options = "<option value='-1' selected>همه کالاها</option>";
      while($row=$db->fetch_assoc($result_kala)) $kala_options .= "<option value=".$row['code_kala'].">".$row['name_kala']."</option>";
	  echo $kala_options;
	  echo'
	  </select>
	 </td>
	</tr>-->';
	if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
	{
	 echo'
	 <tr class="tr1">
	  <td align="left" style="height:50px"> نام استان : </td>
      <td align="right"  colspan="3">
	   &nbsp;<select name="ostanchoice[]" class="easyui-combobox" style="width:300px;" multiple>';
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
	$Condition="";
    $radif=1;
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
    //تعیین فیلدها براساس نوع نمایش
    IF($noe_namayesh==1){$avalField='mojody_khales_aval';$residField='vazn_khales_r_d_sub';$havaleField='vazn_khales_h_d';$tadilField='meghdar_khales_tadil';}
    ELSE IF($noe_namayesh==2){$avalField='mojody_nakhales_aval';$residField='vazn_nakhales_r_d_sub';$havaleField='vazn_nakhales_h_d';$tadilField='meghdar_nakhales_tadil';}
    ELSE IF($noe_namayesh==3){$avalField='tedad_karton_aval';$residField='tedad_karton_r_d_sub';$havaleField='tedad_karton_h_d';$tadilField='tedad_karton_tadil';}
    ELSE IF($noe_namayesh==4){$avalField='tedad_shane_aval';$residField='tedad_shane_r_d_sub';$havaleField='tedad_shane_h_d';$tadilField='tedad_shane_tadil';}
	   
	/****************فیلترها روی گزارش******************/
    /******************کد های کالا**********************/
    if(is_array($kalachoice))
    {
      foreach($kalachoice as $key_kala => $kala_val ) {
      $Condition_kala_temp.=" T.code_kala='$kala_val' OR";
      }
      if($kala_val==-1)$Condition_kala.="1=1 OR";
      else $Condition_kala.=" $Condition_kala_temp";
      $lastSpacePosition = strrpos($Condition_kala," ");
      $Condition_kala =substr($Condition_kala,0,$lastSpacePosition);
    }
    /******************مالکیت انبار**********************/
	if(is_array($malekiyatchoice))
    {
	  foreach($malekiyatchoice as $key_mal => $mal_val ) {
      $Condition_mal_temp.=" noe_malekiyat='$mal_val' OR";
      }
      if($mal_val==-1)$Condition_mal.="1=1 OR";
      else $Condition_mal.=" $Condition_mal_temp";
      $lastSpacePosition = strrpos($Condition_mal," ");
      $Condition_mal =substr($Condition_mal,0,$lastSpacePosition);
    }
	
	/******************وضعیت نمایش اطلاعات انبارهای موقت******************/
	if($show_movaghat==1){$Condition_movaghat="list_sardkhane.situation_type=1 AND "; $Condition_movaghat_mj="l_a.situation_type=1 AND";}
    else if($show_movaghat==2){$Condition_movaghat="";$Condition_movaghat_mj="";}
    else if($show_movaghat==3){$Condition_movaghat="list_sardkhane.situation_type=2 AND ";$Condition_movaghat_mj="";}
	/******************نمایش یا عدم نمایش انبارهای غیرفعال******************/
    if($chkactivate=='on') {$Condition.=""; }
    else {$Condition.=" AND list_sardkhane.activate=1";}
	/****************شروع نمایش گزارش*******************/	
	$page=1;
    $line=0;
    $i=0;
    $cntr=0;
	$q="SELECT T.*,name_ostan,name_anbar,noe_malekiyat,name_ziranbar,zarfiyat_detail FROM mojody_kala T
	    INNER JOIN meat.ostan ON ostan.code_ostan=T.code_ostan
        INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan
	    INNER JOIN meat.list_sardkhane_detail ON T.code_anbar=list_sardkhane_detail.code_anbar AND T.code_ostan=list_sardkhane_detail.code_ostan AND T.code_ziranbar=list_sardkhane_detail.code_ziranbar 
		WHERE 1=1 $Condition AND $Condition_movaghat year='$mtActiveYear' AND deleted=0 AND($Condition_ostan) AND($Condition_anbar) AND($Condition_mal) GROUP BY T.code_ostan,T.code_anbar,code_ziranbar order by name_ostan,name_anbar,code_ziranbar asc";	 
	
	//echo $q;
	$res=$db->query($q);
	$cntr =mysql_num_rows($res);
	if(mysql_num_rows($res)>0)
    {
	  echo'
	  <table class="hideatprint" width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">   
      	<tr class="print_table-title"><td colspan="6">وضعیت نمایش ستونها در گزارش</td></tr>
      	<tr class="print_table-title">
	     <td width="30%" >مقدار فرآورده ورودی</td>
	     <td width="30%" >مقدار فرآورده خروجی</td>
	     <td width="20%" >بالاترین مقدار موجودی</td>
	     <td width="20%" >پایین ترین مقدار موجودی</td>
	    </tr>   	
		<tr class="print_table-title2">
	     <td><input name="varedePr" type="checkbox" checked ></td>
	     <td><input name="saderePr" type="checkbox" checked ></td>
		 <td><input name="maxmojodyPr" type="checkbox" checked></td>
		 <td><input name="minmojodyPr" type="checkbox" checked></td>
	    </tr>	
     </table>
	 <div class="table2excel">';
	 print_header();
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
	 if($show_movaghat==1) $filter_string.=' بدون اطلاعات سردخانه موقت -';
     else if($show_movaghat==2) $filter_string.=' با اطلاعات سردخانه موقت -';
     else if($show_movaghat==3) $filter_string.=' فقط اطلاعات سردخانه موقت -';
     if($chkactivate==TRUE) $filter_string.=' با اطلاعات سردخانه غیرفعال -';
     if($chkactivate==False) $filter_string.=' بدون اطلاعات سردخانه غیرفعال -';
	 if(is_array($kalachoice))
     {
      if($kala_val==-1)$filter_string.='همه کالاها';
      else $filter_string.=' کالا : ';
      foreach($kalachoice as $key_kala => $kala_val) {
      $nameKala=$db->get_from_where("name_kala","kala","code_kala='$kala_val'");
      $filter_string.=''.$nameKala.'&nbsp;';
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
	 echo'<tr class="noExl"><td class="filter_text" colspan="50">فیلتر شده براساس : '.$filter_string.'</td></tr>';
	 echo $columns;
	 while($row=$db->fetch_assoc($res))
	 {
	  $line++;
	  /****************محاسبه مانده از قبل*******************/		  
       $mande_befor=0;
	   $mojodyAval=$db->get_from_where("SUM($avalField)","mojody_kala T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","T.code_ziranbar=".$row['code_ziranbar']." AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row['code_anbar']." AND year='$mtActiveYear' AND deleted=0");     		
	   $jameVaderebef=$db->get_from_where("SUM($residField)","resid_kala_detail T INNER JOIN resid as r ON r.shomare_resid=T.shomare_resid AND r.code_ostan=T.code_ostan AND r.code_anbar=T.code_anbar AND r.year=T.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","T.code_ziranbar=".$row['code_ziranbar']." AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row['code_anbar']." AND($Condition_mal) AND T.year='$mtActiveYear' AND (r.noe_tahvil_bar!=10) AND T.resid_deleted=0 AND T.status=0 AND r.tarikh_resid<'$date1'");     
	   $jameSaderebef=$db->get_from_where("SUM($havaleField)","havale_detail T INNER JOIN havale as h ON h.shomare_havale_anbar=T.shomare_havale_anbar AND h.code_ostan=T.code_ostan AND h.code_anbar=T.code_anbar AND h.year=T.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","T.code_ziranbar=".$row['code_ziranbar']." AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row['code_anbar']." AND($Condition_mal) AND T.year='$mtActiveYear' AND (h.noe_tahvil_bar!=10) AND T.havale_deleted=0 AND T.status=0 AND h.tarikh_havale_anbar<'$date1'");     
	   $TadilEzafebef=$db->get_from_where("SUM($tadilField)","tadil_mojody T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","noe_tadil=1 AND T.code_ziranbar=".$row['code_ziranbar']." AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row['code_anbar']." AND($Condition_mal) AND year='$mtActiveYear' AND status=0 AND deleted=0 AND tarikh_barge_tadil<'$date1'");     
	   $TadilKasrybef=$db->get_from_where("SUM($tadilField)","tadil_mojody T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","noe_tadil=2 AND T.code_ziranbar=".$row['code_ziranbar']." AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row['code_anbar']." AND($Condition_mal) AND year='$mtActiveYear' AND status=0 AND deleted=0 AND tarikh_barge_tadil<'$date1'");     
	   $mande_befor=$mojodyAval+$jameVaderebef-$jameSaderebef+$TadilEzafebef-$TadilKasrybef;
	  
	   
	   
	   $tarikh_milady=$date1_milady;
	   $max_mande_mojody=0;
	   $max_tarikh_mojody=$date2;
	   $min_mande_mojody=$mande_befor;
	   $min_tarikh_mojody=$date1;
	   while($tarikh_milady<=$date2_milady)//حلقه روی تاریخ ها
	   {
		
		//تبدیل تاریخ میلادی به شمسی
	    $sql_tarikh3=$tarikh_milady;
        $d3=substr($sql_tarikh3,8,2);
        $m3=substr($sql_tarikh3,5,2);
        $y3=substr($sql_tarikh3,0,4);
        $shamsi=gregorian_to_jalali($y3,$m3,$d3);
        $sal3=$shamsi[0];
        $mah3=$shamsi[1];
        $rouz3=$shamsi[2];
        $tarikh_shamsi=$sal3.'/'.$mah3.'/'.$rouz3;
	   	//وارده
	    $varede_date=$db->get_from_where("SUM($residField)","resid_kala_detail T INNER JOIN resid as r ON r.shomare_resid=T.shomare_resid AND r.code_ostan=T.code_ostan AND r.code_anbar=T.code_anbar AND r.year=T.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","T.code_ziranbar=".$row['code_ziranbar']." AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row['code_anbar']." AND($Condition_mal) AND T.year='$mtActiveYear' AND (r.noe_tahvil_bar!=10) AND T.resid_deleted=0 AND T.status=0 AND r.tarikh_resid BETWEEN '$date1' AND '$tarikh_shamsi'");     
		//صادره
	    $sadere_date=$db->get_from_where("SUM($havaleField)","havale_detail T INNER JOIN havale as h ON h.shomare_havale_anbar=T.shomare_havale_anbar AND h.code_ostan=T.code_ostan AND h.code_anbar=T.code_anbar AND h.year=T.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","T.code_ziranbar=".$row['code_ziranbar']." AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row['code_anbar']." AND($Condition_mal) AND T.year='$mtActiveYear' AND (h.noe_tahvil_bar!=10) AND T.havale_deleted=0 AND T.status=0 AND h.tarikh_havale_anbar BETWEEN '$date1' AND '$tarikh_shamsi'");     
		//تعدیل
	    $tadil_ezafe=$db->get_from_where("SUM($tadilField)","tadil_mojody T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","noe_tadil=1 AND code_kala=".$row['code_kala']." AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row['code_anbar']." AND($Condition_mal) AND year='$mtActiveYear' AND status=0 AND deleted=0 AND tarikh_barge_tadil BETWEEN '$date1' AND '$tarikh_shamsi'");     
		$tadil_kasry=$db->get_from_where("SUM($tadilField)","tadil_mojody T INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","noe_tadil=2 AND code_kala=".$row['code_kala']." AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row['code_anbar']." AND($Condition_mal) AND year='$mtActiveYear' AND status=0 AND deleted=0 AND tarikh_barge_tadil BETWEEN '$date1' AND '$tarikh_shamsi'");     
	    //مانده موجودی
	    $mande_nahayi=0;
	    $mande_nahayi=$mande_befor+$varede_date-$sadere_date+$tadil_ezafe-$tadil_kasry;
        IF($max_mande_mojody<$mande_nahayi){
			$max_mande_mojody=$mande_nahayi;
			$max_tarikh_mojody=$tarikh_shamsi;
		}
		IF($mande_nahayi<$min_mande_mojody){
			$min_mande_mojody=$mande_nahayi;
			$min_tarikh_mojody=$tarikh_shamsi;
		}
	    $tarikh_milady=date('Y-m-d',strtotime("+1 day", strtotime($tarikh_milady)));//یکی به روز اضافه شود
  		
	   }//END WHILE	   
	   	//وارده
	    $varede=$db->get_from_where("SUM($residField)","resid_kala_detail T INNER JOIN resid as r ON r.shomare_resid=T.shomare_resid AND r.code_ostan=T.code_ostan AND r.code_anbar=T.code_anbar AND r.year=T.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","T.code_ziranbar=".$row['code_ziranbar']." AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row['code_anbar']." AND($Condition_mal) AND T.year='$mtActiveYear' AND (r.noe_tahvil_bar!=10) AND T.resid_deleted=0 AND T.status=0 AND r.tarikh_resid>='$date1' AND r.tarikh_resid<='$date2'");     
		//صادره
	    $sadere=$db->get_from_where("SUM($havaleField)","havale_detail T INNER JOIN havale as h ON h.shomare_havale_anbar=T.shomare_havale_anbar AND h.code_ostan=T.code_ostan AND h.code_anbar=T.code_anbar AND h.year=T.year INNER JOIN meat.list_sardkhane ON list_sardkhane.code_anbar=T.code_anbar AND list_sardkhane.code_ostan=T.code_ostan","T.code_ziranbar=".$row['code_ziranbar']." AND T.code_ostan=".$row['code_ostan']." AND T.code_anbar=".$row['code_anbar']." AND($Condition_mal) AND T.year='$mtActiveYear' AND (h.noe_tahvil_bar!=10) AND T.havale_deleted=0 AND T.status=0 AND h.tarikh_havale_anbar>='$date1' AND h.tarikh_havale_anbar<='$date2'");     
	   if(strlen($row['code_ostan'])==1) $code_a=make_pattern($row['code_ostan'],2);
       else $code_a=$row['code_ostan'];

		if($i++%2)echo'<tr class="print_table-odd">';
        else echo'<tr class="print_table-even">'; 
	    echo'
	       <td>'.$radif++.'</td>
	       <td>'.$row['name_ostan'].'</td>
	       <td>'.$row['name_anbar'].'</td>
	       <td>'.$noe_malekiyatArr[$row['noe_malekiyat']].'</td>
		   <td>'.$row['name_ziranbar'].'</td>
		   <td>'.virgul($row['zarfiyat_detail']).'</td>
	       <td class="varedePr">'.virgul($varede).'</td>
	       <td class="saderePr">'.virgul($sadere).'</td>
	       <td class="maxmojodyPr">'.virgul($max_mande_mojody).'</td>
	       <td class="maxmojodyPr">'.$max_tarikh_mojody.'</td>
		   <td class="minmojodyPr">'.virgul($min_mande_mojody).'</td>
	       <td class="minmojodyPr">'.$min_tarikh_mojody.'</td>
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
	  /****************محاسبه مجموع مقادیر در سطر آخر*******************/   
	    $jame_zarfiyat+=$row['zarfiyat_detail'];
	    $jame_varede+=$varede;
	    $jame_sadere+=$sadere;
	    $jame_max_mande_mojody+=$max_mande_mojody;
	    $jame_min_mande_mojody+=$min_mande_mojody;
	  }//END while
	 echo'
	  <tr class="print_table-even sum-row-white-b">
	   <td colspan="5">جمع کل (کیلوگرم)</td>
	    <td >'.virgul($jame_zarfiyat).'</td>
	    <td class="varedePr">'.virgul($jame_varede).'</td>
	    <td class="saderePr">'.virgul($jame_sadere).'</td>
	    <td class="maxmojodyPr">'.virgul($jame_max_mande_mojody).'</td>
	    <td class="maxmojodyPr">-</td>
	    <td class="minmojodyPr">'.virgul($jame_min_mande_mojody).'</td>
	    <td class="minmojodyPr">-</td>
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