<?php
require_once __DIR__ . '/mysql_compat.php';
/*حالت لوکال هاست را کامنت کردم*/
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="report_manager_forush_mandedar2.php";
$ExcelFileName=str_replace('.php','',$FileName);
$titr='حواله فروش های مانده دار به تفکیک استان و سردخانه';
require_once('head.html');
IF($different==null)$different='10';
$columns='
	<tr class="print_table-title2">
	  <td width=4%>ردیف</td>
	  <td class="ostanPr" width=5%>استان</td>
	  <td class="anbarPr" width=13%>سردخانه</td>
	  <td class="forushPr" width=8%>شماره حواله فروش</td>
	  <td class="dateforushPr"  width=8%>تاریخ حواله فروش</td>
	  <td class="date_diffforushPr"  width=9%>تاریخ با گذشت '.$different.' روز</td>
	  <!--<td width=%>نام کالا</td>-->
	  <td class="customerPr" width=20%>نام مشتری</td>
	  <td class="avalPr" width=10%>مقدار اولیه حواله فروش</td>
	  <td class="tahvilPr" width=9%>مقدار تحویلی</td>
	  <td class="ebtalPr" width=5%>مقدار ابطالی</td>
	  <td class="mandePr" width=9%>مقدار مانده از حواله فروش</td>
	</tr>';
Function print_header()
{global $titr,$mt_gl_owner,$mt_gl_name_anbar,$mt_gl_name_ostan,$code_kala,$code_anbar,$date1,$date2,$FileName,$code_kala,$nameKala,$page;
  echo'   
   <br>
   <table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
    <tr class="noExl">
	 <td colspan="40">
      <table width="100%" align="center">
       <tr class="noExl"><td class="print_title_2">'.$mt_gl_owner.'</td></tr>
       <tr class="noExl"><td class="print_title_2"> '.$titr.' کالای '.$nameKala.' (کد کالا : '.$code_kala.')</td></tr> 
	   <tr class="noExl">
	    <td class="print_title_2">';
	     IF($page==1){
			 echo'<a href="javascript:window.print();"><span style="float:right" id="printerReport" class="hideatprint" title="چاپ"></span></a>
			      <span style="float:right" id="exportExcel" title="خروجی اکسل" ></span>';
		 }
	     echo'
	      از تاریخ حواله فروش : '.$date1.' تا تاریخ حواله فروش : '.$date2.'&nbsp&nbsp(صفحه : '.$page.')
         <div style="float:left;"><button class="buttonme hideatprint" onClick="window.location=\''.$FileName.'\'">بازگشت</button></div>
	    </td>
	   </tr>
      </table>
     </td>
    </tr>';
}
/***************************************** MAIN*****************************************/
echo'
<body class="openwin" onload="document.myform.code_kala.focus();">
<form method="post" name="myform" onkeydown="enterIE()">';
if(!$MaxLines)$MaxLines=20;
//تاریخ
$date1=$db->get_from_where("start_from","$mydatabase.mt_docs","year='$mtActiveYear'");  
$date2=$today;

if(!$ok)
{
 echo'
 <table width="95%" align="center" cellpadding="0" cellspacing="0">
  <img src="images/loading.gif" id="loading" class="loading_img"/>
  <tr>
  <td height="100%">
   <table width="700px" border="0" align="center" cellpadding="0" cellspacing="0" >
     <tr><td colspan="2" height="20px">&nbsp;</td></tr>
	 <tr>
      <td colspan="2" class="title">'.$titr.'</td>	 
     </tr>
     <tr class="tr1">
         <td width="300px" align="left" height="40px"><span class="star">*</span> کد کالا :&nbsp;</td>
         <td width="400px" align="right"><input type="text" class="textboxme2" name="code_kala" value="'.$code_kala.'" onkeypress="return isNumber(event)" onKeyUp="F10desc(event)" onblur="enterCodeKala(this.value)" style="width:50px;"/>';
	     include ("img_helpkala.php");
		 echo'		   
		  <span style="color:red" id="codeK_Error">&nbsp;</span></td>
	 </tr>
	 <tr class="tr1">
	  <td align="left" > تعداد  : &nbsp;</td><td align="right" ><input type="text" class="textboxme2" name="different" placeholder="10" onkeypress="return isNumber(event)" style="width:50px;"/> روز گذشته از تاریخ حواله فروش</td>
	 </tr>';
	 if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
	 {
	  echo'
	  <tr class="tr1">
	   <td align="left" height="40px">نام استان : </td>
       <td align="right">
	    &nbsp;<select name="ostanchoice[]" class="easyui-combobox text4" style="width:200px;" multiple>';
	    $result_ostan = $db->query("SELECT * FROM $mydatabase.ostan ORDER BY name_ostan");
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
	  <td align="left" height="40px"> تعداد خط در صفحه : &nbsp;</td><td align="right"><input type="text" class="textboxme2" name="MaxLines" value="'.$MaxLines.'" onkeypress="return isNumber(event)" style="width:50px;"/></td>
	 </tr>
     <tr class="footer">	
	  <td colspan="4" align="center"><input class="buttonme" type="submit" name="ok" value="شروع گزارش"></td>	 </tr> 
    </table>
   </td>
  </tr>
 </table>';
}
else
{
 if(!$code_kala){ echo"<script>alert('لطفاً کد کالا را وارد کنید !')</script>";
                  echo"<script>window.location='$FileName';</script>";}
 $Condition="";
 $page=1;
 $line=0;
 $i=0;
 $cntr=0;
 $radif=1;
 $nameKala=$db->get_from_where("name_kala","$mydatabase.kala","code_kala='$code_kala'"); 
 ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
 /*نمایش اطلاعات در حالت سیستم فروش*/
 if(($_SESSION['mt_systemforush']==1)OR($_SESSION['mt_systemforush']==''))
 {
   $Condition='';
   $Condition_ostan_sell='';
   /****************فیلترها روی گزارش*******************/	
   //استان ها
	if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
    {  	   
	   if(is_array($ostanchoice))//کد های استان
       {
         foreach($ostanchoice as $ostan_key => $ostan_val ) 
		 {          		  
		  $sell_id_ostan=$db->get_from_where("province_id","sell.dm_province","province_code='$ostan_val'");//تبدیل کد به آی دی
		  $Condition_ostan_temp_sell.=" dm_havale.h_id_province='$sell_id_ostan' OR";
         }
		 if($ostan_val==-1){$Condition_ostan_sell.="1=1 OR";}
         else {$Condition_ostan_sell.=" $Condition_ostan_temp_sell";}

        $lastSpacePosition_sell = strrpos($Condition_ostan_sell," ");
        $Condition_ostan_sell =substr($Condition_ostan_sell,0,$lastSpacePosition_sell);  
       }
    }
    else 
	{
	  $sell_id_ostan=$db->get_from_where("province_id","sell.dm_province","province_code='".$_SESSION['mt_code_ostan']."'");//تبدیل کد به آی دی
	  $Condition_ostan_sell=' dm_havale.h_id_province='.$sell_id_ostan.'';
	  //$Condition_ostan_ebtal_sell=' dm_his_havale.his_id_province='.$sell_id_ostan.'';
	}
	
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
	 $Condition.=" and dm_havale.h_reg_date>='$date1_sell'";
	}
    if($date2)//تا تاریخ 
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
	  $Condition.=" and dm_havale.h_reg_date<='$date2_sell'";
	}
   /****************شروع نمایش گزارش*******************/	
	$q="SELECT dm_havale.*,kala.name_kala,kala.code_bastebandy,dm_customer_asli.name_customer,ostan.code_ostan,name_ostan,list_sardkhane.code_anbar,name_anbar,
		(SELECT SUM(dm_his_havale.his_eb_amount) FROM sell.dm_his_havale where his_h_id=dm_havale.h_id) as meghdar_batele_kol
		FROM sell.dm_havale
		INNER JOIN $mydatabase.kala ON kala.code_kala=dm_havale.h_p_code 
		INNER JOIN sell.dm_customer_asli ON dm_customer_asli.code_customer=dm_havale.h_customer_code  
		INNER JOIN sell.dm_province ON dm_province.province_code=dm_havale.h_id_province  
		INNER JOIN $mydatabase.ostan ON ostan.code_ostan=dm_province.province_code  
		INNER JOIN sell.dm_location_goods ON dm_location_goods.l_id=dm_havale.h_l_code AND dm_location_goods.l_id_province=dm_havale.h_id_province   
		INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_anbar=dm_location_goods.l_code AND list_sardkhane.code_ostan=dm_province.province_code   
		WHERE dm_havale.h_p_code='$code_kala' $Condition AND dm_havale.h_mande_havale<>0 AND dm_havale.h_reg_date>='$mtStartDateMi' AND dm_havale.h_id_year='$sellYearId' AND ($Condition_ostan_sell) ORDER BY name_ostan,name_anbar,h_reg_date";
    //echo $q;
	$res=mysql_query($q);
    $cntr =mysql_num_rows($res);
    
	if(mysql_num_rows($res)>0)
    {
	 echo'
	 <table class="hideatprint" width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">   
      <tr class="print_table-title2 "><td colspan="30">وضعیت نمایش ستونها در گزارش</td></tr>
	  <tr class="print_table-title2  select_all">	 
		 <td width="10%" >استان</td>
		 <td width="10%" >سردخانه</td>
		 <td width="10%" >شماره حواله فروش</td>
		 <td width="10%" >تاریخ حواله فروش</td>
		 <td width="10%" >تاریخ با گذشت '.$different.' روز</td>
		 <td width="10%" >نام مشتری</td>
		 <td width="10%" >مقدار اولیه حواله فروش</td>
		 <td width="10%" >مقدار تحویلی</td>
		 <td width="10%" >مقدار ابطالی</td>
		 <td width="10%" >مقدار مانده از حواله فروش</td>
	    </tr>   	
		<tr class="print_table-title2 print_table-title_small">
	     <td><input name="ostanPr" class="count_sum" type="checkbox" checked ></td>
	     <td><input name="anbarPr" class="count_sum" type="checkbox" checked ></td>
	     <td><input name="forushPr" class="count_sum" type="checkbox" checked ></td>
	     <td><input name="dateforushPr" class="count_sum" type="checkbox" checked ></td>
	     <td><input name="date_diffforushPr" class="count_sum" type="checkbox" checked ></td>
	     <td><input name="customerPr" class="count_sum" type="checkbox" checked ></td>
	     <td><input name="avalPr" type="checkbox" checked ></td>
	     <td><input name="tahvilPr"  type="checkbox" checked ></td>
	     <td><input name="ebtalPr"  type="checkbox" checked ></td>
	     <td><input name="mandePr"  type="checkbox" checked></td>
	    </tr>	
     </table>
	 <div class="table2excel">';
	 print_header();
     /*سطر نمایش فیلترها*/  
	 if(is_array($ostanchoice))
     {
	     if($ostan_val==-1)$filter_string='همه استانها';
	     else $filter_string=' استان : ';
	     foreach($ostanchoice as $ostan_key => $ostan_val) {
	      $nameOstan=$db->get_from_where("name_ostan","ostan","code_ostan='$ostan_val'");
	      $filter_string.=''.$nameOstan.'&nbsp;';
         }
     }
	 $filter_string.='تعداد روز های گذشته از تاریخ حواله فروش : '.$different.' روز به بالا';
	 echo'<tr class="noExl"><td class="filter_text" colspan="40">فیلتر شده براساس : '.$filter_string.'</td></tr>';
     echo $columns;
     while($row=mysql_fetch_assoc($res))
     {
	   
       //$source_date_m='';$source_date_sh='';$DateF3='';$yy3='';$mm3='';$dd3='';
       $source_date_m = strtotime ( '+'.$different.' day' , strtotime ( $row['h_reg_date'] ) ) ;//10 days later
       $source_date_m = date ( 'Y-m-j' , $source_date_m );
       $d3=substr($source_date_m,8,2);$m3=substr($source_date_m,5,2);$y3=substr($source_date_m,0,4);
       $DateF3=gregorian_to_jalali($y3,$m3,$d3);
       $yy3=$DateF3[0];
       $mm3=$DateF3[1];
       $dd3=$DateF3[2];
       $source_date_sh=$yy3.'/'.$mm3.'/'.$dd3;
       //echo $source_date_m.'<br>';
       //echo $source_date_sh.'<br>';
	   IF($today<$source_date_sh)$cntr--;
	   IF($today>=$source_date_sh)//اگر تاریخ امروز بیشتر از تاریخ تعیین شده باشد
	   {
	    $line++;
		//تبدیل تاریخ میلادی به شمسی
	    $sql_tarikh=$row['h_reg_date'];
        $d=substr($sql_tarikh,8,2);
        $m=substr($sql_tarikh,5,2);
        $y=substr($sql_tarikh,0,4);
        $shamsi=gregorian_to_jalali($y,$m,$d);
        $sal=$shamsi[0];
        $mah=$shamsi[1];
        $rouz=$shamsi[2];
        $tarikh_havale=$sal.'/'.$mah.'/'.$rouz;
	    IF($row['code_bastebandy']==2){$havaleField='tedad_karton_h_d';$vahedAndezegiry='(تعداد قوطی)';}
		ELSE IF($code_kala==50){$havaleField='tedad_shane_h_d';$vahedAndezegiry='(تعداد شانه)';}
		ELSE {$havaleField='vazn_khales_h_d';$vahedAndezegiry='(کیلوگرم)';}
		//مقدار اولیه فروش
	    $meghdar_tahvily_kol=$db->get_from_where("SUM($havaleField)","$mydatabase.havale_detail","h_code='".$row['h_code']."' AND code_ostan='".$row['code_ostan']."' AND code_anbar='".$row['code_anbar']."' AND year='$mtActiveYear' AND havale_deleted=0 AND status=0");
	    $avaliye_forush=$row['h_mande_havale']+$meghdar_tahvily_kol+$row['meghdar_batele_kol'];
	    //$avaliye_forush=$row['h_pre_amount'];
	    //محاسبه مقدار تحویلی قبل از تاریخ
	    $meghdar_tahvily_befor=$db->get_from_where("SUM($havaleField)","$mydatabase.havale_detail as h_d INNER JOIN $mydatabase.havale as h ON h.shomare_havale_anbar=h_d.shomare_havale_anbar AND h.code_ostan=h_d.code_ostan AND h.code_anbar=h_d.code_anbar AND h.year=h_d.year","h.h_code='".$row['h_code']."' AND h.code_ostan='".$row['code_ostan']."' AND h.code_anbar='".$row['code_anbar']."' AND h.year='$mtActiveYear' AND havale_deleted=0 AND h.status=0 AND h.tarikh_havale_anbar<'$date1'");
	    //محاسبه مقدار باطله قبل از تاریخ
	    $meghdar_batele_befor=$db->get_from_where("SUM(his_eb_amount)","sell.dm_his_havale INNER JOIN sell.dm_ebtal_h ON dm_his_havale.his_id=dm_ebtal_h.ebh_h_id","his_h_id='".$row['h_id']."' AND ebh_reg_date<'$date1_sell'");	
        //محاسبه مقدار مانده حواله فروش قبل از تاریخ
	    $mande_az_forush_befor=$avaliye_forush-$meghdar_tahvily_befor-$meghdar_batele_befor;
	    //محاسبه مقدار تحویلی مابین تاریخ
        $meghdar_tahvily_between=$db->get_from_where("SUM($havaleField)","$mydatabase.havale_detail as h_d INNER JOIN $mydatabase.havale as h ON h.shomare_havale_anbar=h_d.shomare_havale_anbar AND h.code_ostan=h_d.code_ostan AND h.code_anbar=h_d.code_anbar AND h.year=h_d.year","h.h_code='".$row['h_code']."' AND h.code_ostan='".$row['code_ostan']."' AND h.code_anbar='".$row['code_anbar']."' AND h.year='$mtActiveYear' AND havale_deleted=0 AND h.status=0");
	    //محاسبه مقدار باطله مابین تاریخ
        $meghdar_batele_between=$db->get_from_where("SUM(his_eb_amount)","sell.dm_his_havale INNER JOIN sell.dm_ebtal_h ON dm_his_havale.his_id=dm_ebtal_h.ebh_h_id","his_h_id='".$row['h_id']."'");	
	    //محاسبه مقدار مانده حواله فروش مابین تاریخ
	    $mande_az_forush_between=round($mande_az_forush_befor-$meghdar_tahvily_between-$meghdar_batele_between,3);
	    /**********************/ 
	    $gl_print_row='
	                <td>'.$radif++.'</td>
		 		    <td class="ostanPr">'.$row['name_ostan'].'</td>
		 		    <td class="anbarPr">'.$row['name_anbar'].'</td>
		 		    <td class="forushPr">'.$row['h_code'].'</td>
	                <td class="dateforushPr">'.$tarikh_havale.'</td>
	                <td class="date_diffforushPr">'.$source_date_sh.'</td>
	                <!--<td class="Pr">'.$row['name_kala'].'</td>-->
	                <td class="customerPr">'.$row['name_customer'].'</td>
	                <td class="avalPr">'.round($row['h_pre_amount'],3).'</td>
		 		    <!--<td>'.round($mande_az_forush_befor,3).'</td>-->
	                <td class="tahvilPr">'.round($meghdar_tahvily_between,3).'</td>
	    	        <td class="ebtalPr">'.round($meghdar_batele_between,3).'</td>
				    <td class="mandePr">'.round($mande_az_forush_between,3).'</td>';
		if($i++%2)echo'<tr class="print_table-odd">';
        else echo'<tr class="print_table-even">';
	    echo $gl_print_row;		  
        echo'</tr>';
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
        $sum_meghdar_havale_forush+=$avaliye_forush;
        $sum_mande_az_forush_bef+=$mande_az_forush_befor;
	    $sum_meghdar_tahvily+=$meghdar_tahvily_between;
		$sum_meghdar_batele_forush+=$meghdar_batele_between;
	    $sum_mande_az_forush+=$mande_az_forush_between;	
	   }//END CHECK DATE
	  }//END while
	  echo'
	   <tr class="print_table-even sum-row-white-b">
	    <td id="sum_row" colspan="7">جمع مقادیر .'.$vahedAndezegiry.'</td>
	    <td class="avalPr">'.round($sum_meghdar_havale_forush,3).'</td>
	    <!--<td>'.round($sum_mande_az_forush_bef,3).'</td>-->
	    <td class="tahvilPr">'.round($sum_meghdar_tahvily,3).'</td>
	    <td class="ebtalPr">'.round($sum_meghdar_batele_forush,3).'</td>
	    <td class="mandePr">'.round($sum_mande_az_forush,3).'</td>
	   </tr>
	   <!--پايان مرکز صفحه -->
	   <!-- چاپ زیرنویس-->
	   <!-- چاپ زیرنویس-->
         <tr class="print_footer noExl">
          <td colspan="40">&nbsp;&nbsp;نام کاربر :&nbsp;&nbsp;'.$mtuserNAME.' &nbsp;&nbsp;&nbsp; تاریخ چاپ : '.$today.' &nbsp;&nbsp;&nbsp; ساعت چاپ : '.$logtime.'</td>
         </tr>
	    </table>';  
	}
     ELSE{echo'<div class="msg_error"><span >اطلاعاتی یافت نشد</span><br><button class="buttonme hideatprint" onClick="window.location=\''.$FileName.'\'">بازگشت</button></div>';}
 }
 /********************************************************************************/
 // /*نمایش اطلاعات در حالت سیستم انبار*/
 // if($_SESSION['mt_systemforush']==0)
 // {
   // /****************فیلترها روی گزارش*******************/	
   // /************************استان ها******************/
   // if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
   // {  
        // if(is_array($ostanchoice))//کد های استان
        // {
          // foreach($ostanchoice as $ostan_key => $ostan_val ) 
         // {
          // $Condition_ostan_temp.=" h_f.code_ostan='$ostan_val' OR";
         // }
         // if($ostan_val==-1){$Condition_ostan.="1=1 OR";}
         // else {$Condition_ostan.=" $Condition_ostan_temp";}
          // $lastSpacePosition = strrpos($Condition_ostan," ");
          // $Condition_ostan =substr($Condition_ostan,0,$lastSpacePosition);
        // }
   // }
   // else 
   // {$Condition_ostan=' h_f.code_ostan='.$_SESSION['mt_code_ostan'].'';}
   // if ($date1) $Condition.=" AND h_reg_date>='$date1'";
   // if ($date2) $Condition.=" AND h_reg_date<='$date2'"; 
   // /****************شروع نمایش گزارش*******************/	
   // $q="SELECT h_f.*,kala.name_kala,kala.code_bastebandy,moshtary.name_customer,name_ostan,name_anbar,
	    // (SELECT SUM(ebtal.meghdar_batele) FROM $mydatabase.ebtal where code_ostan=h_f.code_ostan AND code_anbar=h_f.code_anbar AND year='$mtActiveYear' AND h_code=h_f.h_code) AS meghdar_batele_kol
		 // FROM $mydatabase.havale_forush as h_f
		 // INNER JOIN $mydatabase.kala ON kala.code_kala=h_f.code_kala 
		 // INNER JOIN $mydatabase.moshtary ON moshtary.code_customer=h_f.code_customer 
		 // INNER JOIN $mydatabase.ostan ON ostan.code_ostan=h_f.code_ostan 
		 // INNER JOIN $mydatabase.list_sardkhane ON list_sardkhane.code_ostan=h_f.code_ostan AND list_sardkhane.code_anbar=h_f.code_anbar
		 // WHERE h_f.code_kala='$code_kala' $Condition  AND mande_az_forush<>0 AND h_f.h_reg_date>='$mtStartDateSh' AND h_f.year='$mtActiveYear' AND h_f.deleted=0 AND ($Condition_ostan) ORDER BY name_ostan,name_anbar,h_reg_date";	  	 	      	   
   // //echo $q;
   // $res=$db->query($q);
   // $cntr =mysql_num_rows($res);
   // if(mysql_num_rows($res)>0)
   // {
     // echo'<div class="table2excel">';
	 // print_header();
    // /*سطر نمایش فیلترها*/
	 // if(is_array($ostanchoice))
     // {
	     // if($ostan_val==-1)$filter_string='همه استانها';
	     // else $filter_string=' استان : ';
	     // foreach($ostanchoice as $ostan_key => $ostan_val) {
	      // $nameOstan=$db->get_from_where("name_ostan","ostan","code_ostan='$ostan_val'");
	      // $filter_string.=''.$nameOstan.'&nbsp;';
         // }
     // }	
	// $filter_string.='تعداد روز های گذشته از تاریخ حواله فروش : '.$different.' روز به بالا';
	// echo'<tr class="noExl"><td class="filter_text" colspan="40">فیلتر شده براساس : '.$filter_string.'</td></tr>';
    // echo $columns;
	// while($row=$db->fetch_assoc($res))
    // { 
	  // $line++;  
	  // //تبدیل تاریخ شمسی به میلادی
	  // $sql_tarikh_reg=$row['h_reg_date'];
      // $d_sh=substr($sql_tarikh_reg,8,2);
      // $m_sh=substr($sql_tarikh_reg,5,2);
      // $y_sh=substr($sql_tarikh_reg,0,4);
      // $milady=jalali_to_gregorian($y_sh,$m_sh,$d_sh);
      // $sal_sh=$milady[0];
      // $mah_sh=$milady[1];
      // $rouz_sh=$milady[2];
      // $h_reg_date_m=$sal_sh.'-'.$mah_sh.'-'.$rouz_sh;
      // $source_date_m = strtotime ( '+'.$different.' day' , strtotime ( $h_reg_date_m ) ) ;//10 days later
      // $source_date_m = date ( 'Y-m-j' , $source_date_m );
      // $d3=substr($source_date_m,8,2);$m3=substr($source_date_m,5,2);$y3=substr($source_date_m,0,4);
      // $DateF3=gregorian_to_jalali($y3,$m3,$d3);
      // $yy3=$DateF3[0];
      // $mm3=$DateF3[1];
      // $dd3=$DateF3[2];
      // $source_date_sh=$yy3.'/'.$mm3.'/'.$dd3;
	  // IF($today>=$source_date_sh)//اگر تاریخ امروز بیشتر از تاریخ تعیین شده باشد
	  // {
       // //مقدار اولیه فروش
	   // if($row['code_bastebandy']==1)$meghdar_tahvily_kol=$db->get_from_where("SUM(vazn_khales_h_d)","$mydatabase.havale_detail","h_code='".$row['h_code']."' AND code_ostan='".$row['code_ostan']."' AND code_anbar='".$row['code_anbar']."' AND year='$mtActiveYear' AND havale_deleted=0 AND status=0");
	   // if($row['code_bastebandy']==2)$meghdar_tahvily_kol=$db->get_from_where("SUM(tedad_karton_h_d)","$mydatabase.havale_detail","h_code='".$row['h_code']."' AND code_ostan='".$row['code_ostan']."' AND code_anbar='".$row['code_anbar']."' AND year='$mtActiveYear' AND havale_deleted=0 AND status=0");
	   // $avaliye_forush=$row['mande_az_forush']+$meghdar_tahvily_kol+$row['meghdar_batele_kol'];
	   // //محاسبه مقدار تحویلی قبل از تاریخ
	   // if($row['code_bastebandy']==1)$meghdar_tahvily_befor=$db->get_from_where("SUM(vazn_khales_h_d)","$mydatabase.havale_detail as h_d INNER JOIN havale as h ON h.shomare_havale_anbar=h_d.shomare_havale_anbar AND h.code_ostan=h_d.code_ostan AND h.code_anbar=h_d.code_anbar AND h.year=h_d.year","h.h_code='".$row['h_code']."' AND h.code_ostan='".$row['code_ostan']."' AND h.code_anbar='".$row['code_anbar']."' AND h.year='$mtActiveYear' AND havale_deleted=0 AND h.status=0 AND h.tarikh_havale_anbar<'$date1'");
	   // if($row['code_bastebandy']==2)$meghdar_tahvily_befor=$db->get_from_where("SUM(tedad_karton_h_d)","$mydatabase.havale_detail as h_d INNER JOIN havale as h ON h.shomare_havale_anbar=h_d.shomare_havale_anbar AND h.code_ostan=h_d.code_ostan AND h.code_anbar=h_d.code_anbar AND h.year=h_d.year","h.h_code='".$row['h_code']."' AND h.code_ostan='".$row['code_ostan']."' AND h.code_anbar='".$row['code_anbar']."' AND h.year='$mtActiveYear' AND havale_deleted=0 AND h.status=0 AND h.tarikh_havale_anbar<'$date1'");
	   // //محاسبه مقدار باطله قبل از تاریخ
	   // $meghdar_batele_befor=$db->get_from_where("SUM(meghdar_batele)","$mydatabase.ebtal","h_code='".$row['h_code']."' AND code_ostan='".$row['code_ostan']."' AND code_anbar='".$row['code_anbar']."' AND year='$mtActiveYear' AND deleted=0 AND tarikh_barge_ebtal<'$date1'");	
       // //محاسبه مقدار مانده حواله فروش قبل از تاریخ
	   // $mande_az_forush_befor=$avaliye_forush-$meghdar_tahvily_befor-$meghdar_batele_befor;
	   // //محاسبه مقدار تحویلی مابین تاریخ
       // if($row['code_bastebandy']==1)$meghdar_tahvily_between=$db->get_from_where("SUM(vazn_khales_h_d)","$mydatabase.havale_detail as h_d INNER JOIN havale as h ON h.shomare_havale_anbar=h_d.shomare_havale_anbar AND h.code_ostan=h_d.code_ostan AND h.code_anbar=h_d.code_anbar AND h.year=h_d.year","h.h_code='".$row['h_code']."' AND h.code_ostan='".$row['code_ostan']."' AND h.code_anbar='".$row['code_anbar']."' AND h.year='$mtActiveYear' AND havale_deleted=0 AND h.status=0 AND h.tarikh_havale_anbar");
       // if($row['code_bastebandy']==2)$meghdar_tahvily_between=$db->get_from_where("SUM(tedad_karton_h_d)","$mydatabase.havale_detail as h_d INNER JOIN havale as h ON h.shomare_havale_anbar=h_d.shomare_havale_anbar AND h.code_ostan=h_d.code_ostan AND h.code_anbar=h_d.code_anbar AND h.year=h_d.year","h.h_code='".$row['h_code']."' AND h.code_ostan='".$row['code_ostan']."' AND h.code_anbar='".$row['code_anbar']."' AND h.year='$mtActiveYear' AND havale_deleted=0 AND h.status=0 AND h.tarikh_havale_anbar");
	   // //محاسبه مقدار باطله مابین تاریخ
       // $meghdar_batele_between=$db->get_from_where("SUM(meghdar_batele)","$mydatabase.ebtal","h_code='".$row['h_code']."' AND code_ostan='".$row['code_ostan']."' AND code_anbar='".$row['code_anbar']."' AND year='$mtActiveYear' AND deleted=0 AND tarikh_barge_ebtal");	
	   // //محاسبه مقدار مانده حواله فروش مابین تاریخ
	   // $mande_az_forush_between=round($mande_az_forush_befor-$meghdar_tahvily_between-$meghdar_batele_between,3);
	   
		// $gl_print_row='<td>'.$radif++.'</td>
	                   // <td>'.$row['name_ostan'].'</td>
	                   // <td>'.$row['name_anbar'].'</td>
	                   // <td>'.$row['h_code'].'</td>
	                   // <td>'.$row['h_reg_date'].'</td>
	                   // <td>'.$source_date_sh.'</td>
					   // <td>'.$row['name_kala'].'</td>
	                   // <td>'.$row['name_customer'].'</td>
	                   // <td>'.round($row['meghdar_havale_forush'],3).'</td>
	                   // <!--<td>'.round($mande_az_forush_befor,3).'</td>-->
				       // <td>'.round($meghdar_tahvily_between,3).'</td>
	                   // <td>'.round($meghdar_batele_between,3).'</td>
	   	               // <td>'.round($mande_az_forush_between,3).'</td>';
	     // if($i++%2)echo'<tr class="print_table-odd">';
         // else echo'<tr class="print_table-even">';
         // echo $gl_print_row;	
        // echo'</tr>';
        // if($line>=$MaxLines && $i <$cntr) 
	    // {
	     // $line=0;
         // $page++;
	     // echo'
		 // </table>
		   // <br class="pbreak">';
		    // print_header();
			// echo $columns;
	    // }
	    // /****************محاسبه مجموع مقادیر در سطر آخر*******************/   
        // $sum_meghdar_havale_forush+=$avaliye_forush;
        // $sum_mande_az_forush_bef+=$mande_az_forush_befor;
	    // $sum_meghdar_tahvily+=$meghdar_tahvily_between;
		// $sum_meghdar_batele_forush+=$meghdar_batele_between;
	    // $sum_mande_az_forush+=$mande_az_forush_between;	 
	  // }//END CHECK DATE
	// }//END while
	 // echo'
	  // <tr class="print_table-even sum-row-white-b">
	   // <td id="sum_row" colspan="8">جمع مقادیر (کیلوگرم)</td>
	   // <td>'.round($sum_meghdar_havale_forush,3).'</td>
	   // <!--<td>'.round($sum_mande_az_forush_bef,3).'</td>-->
	   // <td>'.round($sum_meghdar_tahvily,3).'</td>
	   // <td>'.round($sum_meghdar_batele_forush,3).'</td>
	   // <td>'.round($sum_mande_az_forush,3).'</td>
	  // </tr>	 
	 // <!--پايان مرکز صفحه -->
	 // <!-- چاپ زیرنویس-->
      // <tr class="print_footer noExl">
       // <td colspan="40">&nbsp;&nbsp;نام کاربر :&nbsp;&nbsp;'.$mtuserNAME.' &nbsp;&nbsp;&nbsp; تاریخ چاپ : '.$today.' &nbsp;&nbsp;&nbsp; ساعت چاپ : '.$logtime.'</td>
      // </tr>
	 // </table>';
	// }
	//  ELSE{echo'<div class="msg_error"><span >اطلاعاتی یافت نشد</span><br><button class="buttonme hideatprint" onClick="window.location=\''.$FileName.'\'">بازگشت</button></div>';}
 // } 
}//END ELSE	
echo'
<div>	
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
         
         var count_for_sum=7;//default
		 var numberNotChecked  = $(".count_sum:not(:checked)").length; //only the class count_sum 
		 var count_for_sum=count_for_sum-numberNotChecked;
		 $("#sum_row").attr("colspan",count_for_sum);
        });
});
function enterCodeKala(code_kala)
{
  $("#loading").fadeIn("fast");
  $.post("ajax.php",{codeKALA_Error:code_kala},function(data){$("#codeK_Error").html(data);});
  $("#loading").fadeOut("fast");				
}
</script> 