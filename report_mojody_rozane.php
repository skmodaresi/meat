<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="report_mojody_rozane.php";
$ExcelFileName=str_replace('.php','',$FileName);
$titr='گزارش مانده موجودی روزانه کالا';
require_once('head.html');
IF($noe_namayesh==1)$str='(خالص)';
ELSE IF($noe_namayesh==2)$str='(ناخالص)';
ELSE IF($noe_namayesh==3)$str='(تعداد)';
ELSE IF($noe_namayesh==4)$str='(شانه)';
$columns='	
    <tr class="print_table-title2">
	 <td rowspan="2" width=8%>تاریخ</td>
	 <td rowspan="2" width=20%>ابتدای دوره '.$str.'</td>
	 <td rowspan="2" width=15%>وارده طی دوره '.$str.'</td>
	 <td rowspan="2" width=15%>صادره طی دوره '.$str.'</td>
	 <td colspan="2" width=11%>تعدیل '.$str.'</td>
	 <td rowspan="2" width=20%>مانده در پایان دوره '.$str.'</td>
	</tr>
	<tr class="print_table-title2">
	 <td>اضافه</td>
	 <td>کسری</td>
	</tr>';
Function print_header()
{global $titr,$columns,$mt_gl_owner,$mt_gl_name_anbar,$mt_gl_name_ostan,$code_kala,$code_anbar,$date1,$date2,$FileName,$nameKala,$page,$noe_namayesh,$namayesh_info;
  IF($namayesh_info==2) $info='نمایش : تحت کلید گمرک';
  ELSE $info='نمایش : سایر';
  echo'
  <br>
   <table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
    <tr class="noExl">
	 <td colspan="40">
      <table width="100%" align="center">
       <tr class="noExl"><td class="print_title_2">'.$mt_gl_owner.'</td></tr>
       <tr class="noExl"><td class="print_title_2"> سردخانه : '.$mt_gl_name_anbar.'&nbsp;&nbsp; استان : '.$mt_gl_name_ostan.'</td></tr>
   	   <tr class="noExl"><td class="print_title_2">'.$titr.' '.$nameKala.' </td></tr>
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
	   </tr>
      </table>
	 </td>
    </tr>';
}
/***************************************** MAIN*****************************************/
echo'
<body class="openwin" onload="document.myform.date1.focus();">
<form method="post" name="myform" onkeydown="enterIE()">';
if(!$MaxLines)$MaxLines=15;
if(!$date1)//اگر کاربر تاریخ اول را وارد نکرده بود
{
	  $date1=$db->get_from_where("start_from","meat.mt_docs","year='$mtActiveYear'");  
} 
//اگر کاربر تاریخ دوم را وارد نکرده بود
if(!$date2)
{
	 $today=AsLDate($yymmdd); 
 	 $end_date_session=$db->get_from_where("end_to","meat.mt_docs","year='$mtActiveYear'");
	 if($today<$end_date_session) $date2=$today;
     else  $date2=$end_date_session;	 
} 
if(!$ok)
{
 echo'
 <table width="95%" height="100%" align="center" cellpadding="0" cellspacing="0">
 <img src="images/loading.gif" id="loading" class="loading_img"/>
  <tr>
   <td height="100%">
    <table width="700px" border="0" align="center" cellpadding="0" cellspacing="0" >
     <tr><td colspan="4" height="20px">&nbsp;</td></tr>
 	 <tr><td colspan="4" class="title">'.$titr.'</td></tr>
     <tr class="tr1">	
 	  <td align="left" width="140px" height="40px"> از تاریخ :&nbsp;</td><td align="right" width="220px"><input type="text" class="textboxme2" name="date1" id="datepickerfrom" placeholder="'.$date1.'" maxlength="10"/></td>
      <td align="left" width="140px"> تا تاریخ :&nbsp;</td><td align="right" width="200px"><input type="text" class="textboxme2" name="date2" id="datepickerto" placeholder="'.$date2.'" maxlength="10"/></td>
 	 </tr>
	 <tr class="tr1">
      <td align="left"><span class="star">*</span> کد کالا :&nbsp;</td>
      <td align="right"><input type="text" class="textboxme2" value="'.$code_kala.'" name="code_kala" onkeypress="return isNumber(event)" onKeyUp="F10desc(event)" onblur="enterCodeKala(this.value)" style="width:50px;"/>&nbsp;';
	  include ("img_helpkala.php");
 	  echo'&nbsp;<span style="color:red" id="codeK_Error">&nbsp;</span></td>
 	  <td align="left" > کد کشور :&nbsp;</td>
	  <td align="right"><input class="textboxme2" type="text" name="code_keshvar" value="'.$code_keshvar.'" onkeypress="return isNumber(event)" onfocus="getDetailKeshvar(this.value);" onblur="getDetailKeshvar(this.value);" style="width:50px"/>&nbsp;';
      include ("img_helpkeshvar.php");
	  echo'
	  </td>
	 </tr>
	 <tr class="tr1">
	  <td align="left"> کد تولیدکننده :&nbsp;</td><td align="right"><input class="textboxme2 textbox50" type="text" name="code_tolidkonande" value="'.$code_tolidkonande.'" onkeypress="return isNumber(event)" onfocus="getDetailTolid(this.value);" onblur="getDetailTolid(this.value);"/>&nbsp;';
      include('img_helptolid.php');
      echo'
      </td>
	  <td align="left"> کد کارتن / قوطی :&nbsp;</td><td align="right"><input type="text" class="textboxme2 textbox50" name="code_karton" id="code_karton" value="'.$code_karton.'" onfocus="getVaznKarton(this.value)" onblur="getVaznKarton(this.value)" onkeypress="return isNumber(event)"/>&nbsp;';
	  include('img_helpkartonghooti.php');
	  echo'
	  </td>
	 </tr>
	 <tr class="tr1">	 
	  <td align="left"> زیرانبار :&nbsp;</td><td align="right">'.listbox_ziranbar("code_ziranbar",$code_ziranbar,"code_ziranbar","name_ziranbar","list_sardkhane_detail","1=1 AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' ORDER BY code_ziranbar,name_ziranbar ASC","class='easyui-combobox text4' style=width:100px","").'
 	  <td align="left"> سال تولید :&nbsp;</td><td align="right"><input class="textboxme2 textbox50" type="text" name="sal_tolid_shamsi" value="'.$sal_tolid_shamsi.'" maxlength="4" placeholder=" '.$mtActiveYear.'" onkeypress="return isNumber(event)"/>
	 </tr>
	 <tr class="tr1">
 	  <td align="left"> ماه تولید :&nbsp;</td><td align="right">'.static_listbox("mah_tolid_shamsi",$mah_tolid_shamsi,"mahshamsiArr",1,"class='easyui-combobox text4' style=width:100px").'
	  <td align="left"> روز تولید :&nbsp;</td><td align="right"><input class="textboxme2 textbox50" type="text" name="rouz_tolid_shamsi" value="'.$rouz_tolid_shamsi.'" maxlength="2" onkeypress="return isNumber(event)"/></td>	
	 </tr>
	 <tr class="tr1">
	  <td align="left" height="40px"> نمایش اطلاعات :&nbsp;</td><td align="right">'.static_listbox("noe_namayesh",$noe_namayesh,"namayeshArr",1,"class='easyui-combobox text4' style=width:100px data-options=panelHeight:125").'</td>
	  <td align="left"> تعداد خط در صفحه :&nbsp;</td><td align="right" colspan="3"><input type="text" class="textboxme2 textbox50" name="MaxLines" value="'.$MaxLines.'" onkeypress="return isNumber(event)"/></td>
	 </tr>
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
else
{
    IF($namayesh_info==2){$table_mojody='mojody_kala_gomrok'; $Condition_info=" AND noe_tahvil_bar=9";$Condition_info_mojavez=" AND noe_mojavez=5";}
    ELSE {$table_mojody='mojody_kala'; $Condition_info=" AND noe_tahvil_bar!=9";$Condition_info_mojavez=" ";}
	if(!$code_kala){echo"<script>alert('لطفاً کد کالا را وارد کنید !')</script>";
                    echo"<script>window.location='$FileName';</script>";}
    $nameKala=$db->get_from_where("name_kala","kala","code_kala='$code_kala'");
    $codeBastebandy=$db->get_from_where("code_bastebandy","kala","code_kala='$code_kala'");
	$dateCond="";
    $dateCond2="";
    $dateCond3="";
	/****************فیلترها روی گزارش******************/	
    if($code_keshvar)//کشور 
	{
	 $Condition.=" AND code_keshvar='$code_keshvar'";
	 $Condition2.=" AND r_k_d.code_keshvar='$code_keshvar'";
	 $Condition3.=" AND h_d.code_keshvar='$code_keshvar'";
	}
	if($code_tolidkonande)//تولیدکننده 
	{
	 $Condition.=" AND code_tolidkonande='$code_tolidkonande'";
	 $Condition2.=" AND r_k_d.code_tolidkonande='$code_tolidkonande'";
	 $Condition3.=" AND h_d.code_tolidkonande='$code_tolidkonande'";
	}
	if($code_karton)//کارتن 
	{
	 $Condition.=" AND code_karton='$code_karton'";
	 $Condition2.=" AND r_k_d.code_karton='$code_karton'";
	 $Condition3.=" AND h_d.code_karton='$code_karton'";
	}
	if($sal_tolid_shamsi)//سال تولید شمسی 
	{
	 $Condition.=" AND sal_tolid_shamsi='$sal_tolid_shamsi'";
	 $Condition2.=" AND r_k_d.sal_tolid_shamsi='$sal_tolid_shamsi'";
	 $Condition3.=" AND h_d.sal_tolid_shamsi='$sal_tolid_shamsi'";
	}
	if($mah_tolid_shamsi)//ماه تولید شمسی 
	{
	 $Condition.=" AND mah_tolid_shamsi='$mah_tolid_shamsi'";
	 $Condition2.=" AND r_k_d.mah_tolid_shamsi='$mah_tolid_shamsi'";
	 $Condition3.=" AND h_d.mah_tolid_shamsi='$mah_tolid_shamsi'";
	}
	if($rouz_tolid_shamsi)//روز تولید شمسی 
	{
	 $Condition.=" AND rouz_tolid_shamsi='$rouz_tolid_shamsi'";
	 $Condition2.=" AND r_k_d.rouz_tolid_shamsi='$rouz_tolid_shamsi'";
	 $Condition3.=" AND h_d.rouz_tolid_shamsi='$rouz_tolid_shamsi'";
	}
	if($code_ziranbar)//زیرانبار 
	{
	 $Condition.=" AND code_ziranbar='$code_ziranbar'";
	 $Condition2.=" AND r_k_d.code_ziranbar='$code_ziranbar'";
	 $Condition3.=" AND h_d.code_ziranbar='$code_ziranbar'";
	}
	if ($date1) $dateCond.=" and tarikh>='$date1'";
    if ($date2) $dateCond.=" and tarikh<='$date2'";
    $page=1;
    $line=0;
    $i=0;
    $cntr=0;
    $radif=1;
/****************شروع نمایش گزارش*******************/	
	IF($noe_namayesh==1){$avalField='mojody_khales_aval';$residField='vazn_khales_r_d_sub';$havaleField='vazn_khales_h_d';$tadilField='meghdar_khales_tadil';}
	ELSE IF($noe_namayesh==2){$avalField='mojody_nakhales_aval';$residField='vazn_nakhales_r_d_sub';$havaleField='vazn_nakhales_h_d';$tadilField='meghdar_nakhales_tadil';}
	ELSE IF($noe_namayesh==3){$avalField='tedad_karton_aval';$residField='tedad_karton_r_d_sub';$havaleField='tedad_karton_h_d';$tadilField='tedad_karton_tadil';}
	ELSE IF($noe_namayesh==4){$avalField='tedad_shane_aval';$residField='tedad_shane_r_d_sub';$havaleField='tedad_shane_h_d';$tadilField='tedad_shane_tadil';}
    /****************محاسبه مانده از قبل*******************/	  
	$mande=$db->get_from_where("SUM($avalField)","$table_mojody","code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' $Condition AND year='$mtActiveYear' AND code_kala='$code_kala' AND deleted=0");             
    $q2="SELECT AllRecords.* FROM
	      ((SELECT r_d.code_ostan as code_ostan,r_d.code_anbar as code_anbar,r_d.year as year,r_d.shomare_resid as shomare,r.tarikh_resid as tarikh,SUM(r_k_d.$residField) as vazn,1 as type FROM resid_detail as r_d
             INNER JOIN resid as r ON r.shomare_resid=r_d.shomare_resid AND r.code_ostan=r_d.code_ostan AND r.code_anbar=r_d.code_anbar AND r.year=r_d.year
             INNER JOIN resid_kala_detail as r_k_d ON r_k_d.shomare_resid=r_d.shomare_resid AND r_k_d.code_ostan=r_d.code_ostan AND r_k_d.code_anbar=r_d.code_anbar AND r_k_d.year=r_d.year AND r_k_d.code_kala=r_d.code_kala AND r_k_d.code_keshvar=r_d.code_keshvar AND r_k_d.code_tolidkonande=r_d.code_tolidkonande 
			 WHERE r_d.code_kala='$code_kala' AND r_d.code_ostan='$mt_gl_code_ostan' AND r_d.code_anbar='$mt_gl_code_anbar' AND r_d.year='$mtActiveYear' $Condition2 $Condition_info AND r_d.resid_deleted=0 AND r_d.status=0 AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.deleted=0 AND r.status=0  group by code_ostan,code_anbar,shomare,year)
	        UNION
	       (SELECT h_d.code_ostan as code_ostan,h_d.code_anbar as code_anbar,h_d.year as year,h_d.shomare_havale_anbar as shomare,h.tarikh_havale_anbar as tarikh,SUM(h_d.$havaleField) as vazn,2 as type FROM havale_detail h_d 
            INNER JOIN havale as h ON h.shomare_havale_anbar=h_d.shomare_havale_anbar AND h.code_ostan=h_d.code_ostan AND h.code_anbar=h_d.code_anbar AND h.year=h_d.year
			WHERE h_d.code_kala='$code_kala' AND h_d.code_ostan='$mt_gl_code_ostan' AND h_d.code_anbar='$mt_gl_code_anbar' AND h_d.year='$mtActiveYear' $Condition3 $Condition_info AND h_d.havale_deleted=0 AND h_d.status=0 AND h.deleted=0 AND h.status=0  group by code_ostan,code_anbar,shomare,year)
		    UNION
		   (SELECT code_ostan,code_anbar,year,shomare_barge_tadil,tarikh_barge_tadil,$tadilField,3 as type FROM tadil_mojody
            WHERE code_kala='$code_kala' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' $Condition $Condition_info AND status=0 AND deleted=0)) AS AllRecords
			WHERE tarikh<'$date1' ORDER BY tarikh,type,shomare";  
	$res2=$db->query($q2);
    while($row2=$db->fetch_assoc($res2))
    {
     if($row2['type']==1) $mande+=$row2['vazn'];
     if($row2['type']==2) $mande-=$row2['vazn'];
     if($row2['type']==3)
     {
      $q3="SELECT noe_tadil FROM tadil_mojody WHERE shomare_barge_tadil='".$row2['shomare']."' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar'  $Condition $Condition_info AND year='$mtActiveYear' AND code_kala='$code_kala' AND status=0 AND deleted=0"; 	  
      $res3=$db->query($q3);
      while($row3=$db->fetch_array($res3))
      {
    	   if($row3['noe_tadil']==1) $mande+=$row2['vazn'];		  
    	   else $mande-=$row2['vazn'];
      }
     }//END tadil
    }//END while aval
	/****************محاسبات بین دوره*******************/		  
    $q="SELECT AllRecords.* FROM
	       ((SELECT r_d.code_ostan as code_ostan,r_d.code_anbar as code_anbar,r_d.year as year,r_d.shomare_resid as shomare,r.tarikh_resid as tarikh,SUM(r_k_d.$residField) as vazn,1 as type FROM resid_detail as r_d
             INNER JOIN resid as r ON r.shomare_resid=r_d.shomare_resid AND r.code_ostan=r_d.code_ostan AND r.code_anbar=r_d.code_anbar AND r.year=r_d.year
             INNER JOIN resid_kala_detail as r_k_d ON r_k_d.shomare_resid=r_d.shomare_resid AND r_k_d.code_ostan=r_d.code_ostan AND r_k_d.code_anbar=r_d.code_anbar AND r_k_d.year=r_d.year AND r_k_d.code_kala=r_d.code_kala AND r_k_d.code_keshvar=r_d.code_keshvar AND r_k_d.code_tolidkonande=r_d.code_tolidkonande 
			 WHERE r_d.code_kala='$code_kala' AND r_d.code_ostan='$mt_gl_code_ostan' AND r_d.code_anbar='$mt_gl_code_anbar' AND r_d.year='$mtActiveYear' $Condition2 $Condition_info AND r_d.resid_deleted=0 AND r_d.status=0 AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.deleted=0 AND r.status=0  group by code_ostan,code_anbar,shomare,year)
	        UNION
	       (SELECT h_d.code_ostan as code_ostan,h_d.code_anbar as code_anbar,h_d.year as year,h_d.shomare_havale_anbar as shomare,h.tarikh_havale_anbar as tarikh,SUM(h_d.$havaleField) as vazn,2 as type FROM havale_detail h_d 
            INNER JOIN havale as h ON h.shomare_havale_anbar=h_d.shomare_havale_anbar AND h.code_ostan=h_d.code_ostan AND h.code_anbar=h_d.code_anbar AND h.year=h_d.year
			WHERE h_d.code_kala='$code_kala' AND h_d.code_ostan='$mt_gl_code_ostan' AND h_d.code_anbar='$mt_gl_code_anbar' AND h_d.year='$mtActiveYear' $Condition3 $Condition_info AND h_d.havale_deleted=0 AND h_d.status=0 AND h.deleted=0 AND h.status=0  group by code_ostan,code_anbar,shomare,year)
		    UNION
		   (SELECT code_ostan,code_anbar,year,shomare_barge_tadil,tarikh_barge_tadil,$tadilField,3 as type FROM tadil_mojody
            WHERE code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND code_kala='$code_kala' $Condition $Condition_info AND status=0 AND deleted=0)) AS AllRecords
		    WHERE 1=1 $dateCond group by tarikh ORDER BY tarikh,type,shomare"; 	
	$res=$db->query($q);
    $cntr =mysql_num_rows($res);
	if(mysql_num_rows($res)>0)
	{
	 echo'<div class="table2excel">';
	 print_header();
	 /*سطر نمایش فیلترها*/
	 if($code_keshvar) {$nameKeshvar=$db->get_from_where("name_keshvar","keshvar","code_keshvar='$code_keshvar'"); $filter_string.=' کشور : '.$nameKeshvar.'&nbsp;';}     
	 if($code_tolidkonande) {$nameTolidkonande=$db->get_from_where("name_tolidkonande","tolidkonande","code_tolidkonande='$code_tolidkonande'"); $filter_string.=' تولیدکننده : '.$nameTolidkonande.'&nbsp;';}     
	 if($code_karton) {$filter_string.=' کد کارتن /قوطی : '.$code_karton.'&nbsp;';}     
	 if($code_ziranbar) {$nameZirAnbar=$db->get_from_where("name_ziranbar","list_sardkhane_detail","code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND code_ziranbar='$code_ziranbar'");$filter_string.=' زیرانبار : '.$nameZirAnbar.'&nbsp;';}     
	 if($sal_tolid_shamsi) {$filter_string.=' سال : '.$sal_tolid_shamsi.'&nbsp;';}     
	 if($mah_tolid_shamsi) {$filter_string.=' ماه : '.$mahshamsiArr[$mah_tolid_shamsi].'&nbsp;';}     
	 if($rouz_tolid_shamsi) {$filter_string.=' روز : '.$rouz_tolid_shamsi.'&nbsp;';}     
     if(($code_keshvar)or($code_tolidkonande)or($code_karton)or($code_ziranbar)or($sal_tolid_shamsi)or($mah_tolid_shamsi)or($rouz_tolid_shamsi))
	 {echo'<tr class="noExl"><td class="filter_text" colspan="40">فیلتر شده براساس : '.$filter_string.'</td></tr>';}
	 if(($noe_namayesh==2)and($codeBastebandy==2))
	 {echo'<tr class="noExl"><td class="filter_text" colspan="40">دقت کنید بسته بندی این کالا قوطی است و وزن ناخالص ندارد</td></tr>';}
	 echo $columns;
	 while($row=$db->fetch_assoc($res))
     {
	  $line++;
	  if($i++%2)echo'<tr class="print_table-odd">';
      else echo'<tr class="print_table-even">'; 
	  echo'
	    <td>'.$row['tarikh'].'</td>';
		IF(($noe_namayesh==1)OR($noe_namayesh==2))//حالت خالص , ناخالص
		{
		 echo'<td>'.round($mande,3).'</td>';
		 $jameVarede=$db->get_from_where("SUM($residField)","resid_kala_detail r_k_d INNER JOIN resid r ON r.shomare_resid=r_k_d.shomare_resid AND r.code_ostan=r_k_d.code_ostan AND r.code_anbar=r_k_d.code_anbar AND r.year=r_k_d.year","r_k_d.code_ostan='$mt_gl_code_ostan' AND r_k_d.code_anbar='$mt_gl_code_anbar' $Condition2 $Condition_info AND r_k_d.year='$mtActiveYear' AND r_k_d.code_kala='$code_kala' AND r.tarikh_resid='".$row['tarikh']."' AND r_k_d.resid_deleted=0 AND r_k_d.status=0");     
	     $jameSadere=$db->get_from_where("SUM($havaleField)","havale_detail h_d INNER JOIN havale h ON h.shomare_havale_anbar=h_d.shomare_havale_anbar AND h.code_ostan=h_d.code_ostan AND h.code_anbar=h_d.code_anbar AND h.year=h_d.year","h_d.code_ostan='$mt_gl_code_ostan' AND h_d.code_anbar='$mt_gl_code_anbar' $Condition3 $Condition_info AND h_d.year='$mtActiveYear' AND h_d.code_kala='$code_kala' AND h.tarikh_havale_anbar='".$row['tarikh']."' AND h_d.havale_deleted=0 AND h_d.status=0");     
	     $meghdarTadil_Ezafe=$db->get_from_where("SUM($tadilField)","tadil_mojody","code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' $Condition $Condition_info AND year='$mtActiveYear' AND code_kala='$code_kala' AND tarikh_barge_tadil='".$row['tarikh']."' AND noe_tadil=1 AND status=0 AND deleted=0");     
		 $meghdarTadil_Kasry=$db->get_from_where("SUM($tadilField)","tadil_mojody","code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' $Condition $Condition_info  AND year='$mtActiveYear' AND code_kala='$code_kala' AND tarikh_barge_tadil='".$row['tarikh']."' AND noe_tadil=2 AND status=0 AND deleted=0");     
		 $mande=$mande+$jameVarede-$jameSadere+$meghdarTadil_Ezafe-$meghdarTadil_Kasry;
		 echo'<td>'.round($jameVarede,3).'</td>';
		 echo'<td>'.round($jameSadere,3).'</td>';
		 echo'<td>'.round($meghdarTadil_Ezafe,3).'</td>';
		 echo'<td>'.round($meghdarTadil_Kasry,3).'</td>';
		 echo'<td>'.round($mande,3).'</td>';
		}
		IF(($noe_namayesh==3)OR($noe_namayesh==4))//کارتن و شانه
		{
		 echo'<td>'.virgul($mande).'</td>';
		 $jameVarede=$db->get_from_where("SUM($residField)","resid_kala_detail r_k_d INNER JOIN resid r ON r.shomare_resid=r_k_d.shomare_resid AND r.code_ostan=r_k_d.code_ostan AND r.code_anbar=r_k_d.code_anbar AND r.year=r_k_d.year","r_k_d.code_ostan='$mt_gl_code_ostan' AND r_k_d.code_anbar='$mt_gl_code_anbar' $Condition2 $Condition_info AND r_k_d.year='$mtActiveYear' AND r_k_d.code_kala='$code_kala' AND r.tarikh_resid='".$row['tarikh']."' AND r_k_d.resid_deleted=0 AND r_k_d.status=0");     
	     $jameSadere=$db->get_from_where("SUM($havaleField)","havale_detail h_d INNER JOIN havale h ON h.shomare_havale_anbar=h_d.shomare_havale_anbar AND h.code_ostan=h_d.code_ostan AND h.code_anbar=h_d.code_anbar AND h.year=h_d.year","h_d.code_ostan='$mt_gl_code_ostan' AND h_d.code_anbar='$mt_gl_code_anbar' $Condition3 $Condition_info AND h_d.year='$mtActiveYear' AND h_d.code_kala='$code_kala' AND h.tarikh_havale_anbar='".$row['tarikh']."' AND h_d.havale_deleted=0 AND h_d.status=0");  
		 $meghdarTadil_Ezafe=$db->get_from_where("SUM($tadilField)","tadil_mojody","code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' $Condition $Condition_info AND year='$mtActiveYear' AND code_kala='$code_kala' AND tarikh_barge_tadil='".$row['tarikh']."' AND noe_tadil=1 AND status=0 AND deleted=0");     
		 $meghdarTadil_Kasry=$db->get_from_where("SUM($tadilField)","tadil_mojody","code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' $Condition $Condition_info AND year='$mtActiveYear' AND code_kala='$code_kala' AND tarikh_barge_tadil='".$row['tarikh']."' AND noe_tadil=2 AND status=0 AND deleted=0");     
		 $mande=$mande+$jameVarede-$jameSadere+$meghdarTadil_Ezafe-$meghdarTadil_Kasry;
		 echo'<td>'.virgul($jameVarede).'</td>';
		 echo'<td>'.virgul($jameSadere).'</td>';
		 echo'<td>'.virgul($meghdarTadil_Ezafe).'</td>';
		 echo'<td>'.virgul($meghdarTadil_Kasry).'</td>';
		 echo'<td>'.virgul($mande).'</td>';
		}
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
     }//END while
	 echo'
	 <!--پايان مرکز صفحه -->
     <!-- چاپ زیرنوس-->';
     require_once('prt-footer.php');
     echo' 
     </table>'; 
	}//END IF
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