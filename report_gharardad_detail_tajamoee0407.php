<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="report_gharardad_detail_tajamoee.php";
$today=AsLDate($yymmdd);
$logtime=date('H:i');
$titr='گزارش تجمعی قراردادها ';
require_once('head.html');	
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

/****************هدر******************/
$columns='
	   <tr class="print_table-title2" style="line-height:25px;">
	    <td width="5%" rowspan="2">ردیف</td>
	    <td width="20%" colspan="4">مصوبات و ابلاغیه ها و دستورالعمل</td>
	    <td width="45%" colspan="12">اطلاعات قرارداد</td>
		<td width="45%" colspan="3">اطلاعات درخواست تامین اعتبار</td>
		<td width="5%" rowspan=2 class="mazadPr">تحویلی به سردخانه ثبت نهایی </td>
		<td width="45%" colspan="6">اطلاعات درخواست پرداخت وجه</td>
		<td width="45%" colspan="2">مانده از قرارداد</td>
		<td width="45%" rowspan=2>تضامین قرارداد</td>
		
	    
	   </tr>
       <tr class="print_table-title2">	   
	    <td width="5%" class="shEblaghPr">شماره ابلاغ</td>
		<td width="5%" class="dateEblaghPr">تاریخ ابلاغ</td>
		<td width="5%" class="shDastPr">شماره دستورالعمل</td>
		<td width="5%" class="dateDastPr">تاریخ دستورالعمل</td>	   
		<td width="5%" class="ostanPr">استان</td>
		<td width="5%" class="skkPr">نام فروشنده</td>
		<td width="5%" class="skkPr">نوع قرارداد</td>
	    <td width="5%" class="shghPr">شماره قرارداد/الحاقیه</td>
	    <td width="5%" class="dateghPr">تاریخ قرارداد/الحاقیه</td>
		<td width="5%" class="dateghPr">تاریخ شروع قرارداد/الحاقیه</td>
		<td width="5%" class="dateghPr">تاریخ خاتمه قرارداد / الحاقیه</td>
		<td width="5%" class="meghdarPr">مقدار قرارداد</td>
		<td width="5%" class="gheymatPr">قیمت هر کیلوگرم(ریال)</td>
		<td width="5%" class="meghdarPr">مقدار کل قرارداد)کیلوگرم)</td>
		<td width="5%" class="meghdarPr">ارزش کل قرارداد (ریال)</td>
		<td width="5%" class="grkalaPr">گروه کالا</td>
		
		<td width="5%" class="meghdarPr">شماره نامه درخواست تامین اعتبار</td>
		<td width="5%" class="meghdarPr">تاریخ نامه ددخواست تامین اعتبار</td>
		<td width="5%" class="meghdarPr">مبلغ درخواست تامین اعتبار</td>
		
	    
		
		<td width="5%" class="tahvilyPr">شماره نامه  </td>
		<td width="5%" class="tahvilyPr">تاریخ نامه </td>
		<td width="5%" class="tahvilyPr">مقدار )کیلوگرم)</td>
		<td width="5%" class="tahvilyPr">نوع درخواست پرداخت وجه</td>
	    <td width="5%" class="tahvilyPr">مبلغ درخواست پرداخت وجه</td>
		<td width="5%" class="tahvilyPr">کل مبلغ درخواست پرداخت وجه</td>
		
	    <td width="5%" class="tahvilyPr">مانده از قرارداد(کیلوگرم)</td>
	    <td width="5%" class="tahvilyPr">مانده از قرارداد (ریال)</td>
		
		
	   </tr>';
Function print_header()
{global $titr,$mt_gl_owner,$mt_gl_name_anbar,$mt_gl_name_ostan,$date1,$date2,$FileName,$page;
 echo'
   <br>
   <table class="table2excel" data-tableName="Test Table 1" width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
   ';
    IF($page==1)
	{
	echo '
    <tr class="noExl">
	 <td colspan="40">
      <table width="100%" align="center">
       <tr class="noExl"><td class="print_title_2">'.$mt_gl_owner.'</td></tr>
   	   <tr class="noExl"><td class="print_title_2">'.$titr.'</td></tr>
       <tr class="noExl">
	    <td class="print_title_2">';
		IF($page==1){
			 echo'<a href="javascript:window.print();"><span style="float:right" id="printerReport" class="hideatprint" title="چاپ"></span></a>';
			      
		 }
		 echo'
	    از تاریخ قرارداد : '.$date1.' تا تاریخ قرارداد : '.$date2.'&nbsp&nbsp(صفحه : '.$page.')
	     <div style="float:left;"><button class="buttonme" onClick="window.location=\''.$FileName.'\'">بازگشت</button></div>
	    </td>  
	   </tr>
      </table>
	 </td>
    </tr>';
	}
}
/***************************************** MAIN*****************************************/
echo'
<body class="openwin" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.date1.focus();">
<form method="post" name="myform" onkeydown="enterIE()">';
if(!$MaxLines) $MaxLines=1;
if(!$ok)
{
 echo'
 <table width="90%" height="100%" align="center" cellpadding="0" cellspacing="0">
  <img src="images/loading.gif" id="loading" class="loading_img"/>
  <tr>
   <td height="100%">
    <div style="float:right;width:100%;margin:0px;height:100%;overflow:auto;overflow-x:hidden;">
    <table width="700px" border="0" align="center" cellpadding="0" cellspacing="0" >
     <tr><td colspan="4" height="20px">&nbsp;</td></tr>
 	 <tr><td colspan="4" class="title">'.$titr.'</td></tr>
	 <!--<tr class="tr1" >	
      <td align="left" height="40px"> از تاریخ (رسید سردخانه) :&nbsp;</td><td align="right"><input type="text" class="textboxme2" maxlength="10" name="date1" id="datepickerfrom" placeholder="'.$date1.'"/></td>
      <td align="left"> تا تاریخ (رسید سردخانه):&nbsp;</td><td align="right"><input type="text" class="textboxme2" maxlength="10" name="date2" id="datepickerto" placeholder="'.$date2.'"/></td>
 	 </tr>-->
	 <tr class="tr1" >	
      <td align="left" height="40px"> از تاریخ (قرارداد) :&nbsp;</td><td align="right"><input type="text" class="textboxme2" maxlength="10" name="date1" id="datepickerfrom" placeholder="'.$date1.'"/></td>
      <td align="left"> تا تاریخ (قرارداد):&nbsp;</td><td align="right"><input type="text" class="textboxme2" maxlength="10" name="date2" id="datepickerto" placeholder="'.$date2.'"/></td>
 	 </tr>
	 <tr class="tr1">
	  <td align="left" height="40px" > شماره ابلاغ :&nbsp; </td>
	  <td align="right">
	   <input type="hidden" name="id_eblagh" value="'.$id_eblagh.'"/>
	   <input type="hidden" name="meghdar_kharid_keshvar" value="'.$meghdar_kharid_keshvar.'"/>
	   <input type="text" class="textboxme2" name="shomare_eblagh" value="'.$shomare_eblagh.'" />';
       include('img_eblagh.php');
	     echo'
	  </td>
	  <td align="left" height="40px"> شماره دستورالعمل :&nbsp; </td>
	  <td align="right"><input type="text" class="textboxme2" name="shomare_dastorolamal" value="'.$shomare_dastorolamal.'" /></td>
	 </tr>
	 <tr class="tr1">
	  <td align="left"> شماره قرارداد :&nbsp; </td>
	  <td align="right">
	   <input type="text" class="textboxme2" name="shomare_gharardad" value="'.$shomare_gharardad.'" />';
         //include('img_eblagh.php');
	     echo'
	  </td>
	   <td align="left"> طرف قرارداد (فروشنده) :&nbsp;</td>
	   <td align="right"><input type="text" class="textboxme2" name="code_skk" value="'.$code_skk.'" onkeypress="return isNumber(event)" onfocus="getShomareSafar(this.value)" onchange="getShomareSafar(this.value)"/>
	    <input type="hidden" name="name_skk" value="name_skk"/>';
	    include("img_helpcoding_mali.php");
	    echo'
      </tr>
	  <tr class="tr1">';
       if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
	   {
	    echo'
	     <td align="left">نام استان :&nbsp;</td>
         <td align="right" colspan="3">
	      <select name="ostanchoice[]"  class="easyui-combobox text4" style=width:250px  multiple>';
	      $result_ostan = $db->query("SELECT * FROM ostan ORDER BY name_ostan");
          $ostan_options = "<option value='-1' selected>همه استانها</option>";
          while($row_eblagh=$db->fetch_assoc($result_ostan)) $ostan_options .= "<option value=".$row_eblagh['code_ostan'].">".$row_eblagh['name_ostan']."</option>";
	      echo $ostan_options;
	      echo'
	      </select>
	     </td>';
	   }
	   echo'
	 </tr>
	 <tr class="tr1">
	  <td align="left" height="40px"> نوع محموله :&nbsp;</td><td align="right" colspan="3">'.static_listbox("mahmule_type",$mahmule_type,"mahmuletypeArr",1,"class='easyui-combobox text4' data-options=panelHeight:125").'</td>
	 </tr>
     <tr class="footer" align="center"><td colspan="4" height="40px"><input class="buttonme" type="submit" name="ok" value="شروع گزارش"></td></tr>   
    </table>
    </div>
   </td>
  </tr>
 </table>';
}
else
{
    // if(!$shomare_eblagh){echo"<script>alert('لطفاً شماره ابلاغ را وارد نمایید !')</script>";
                   // echo"<script>window.location='$FileName';</script>";}
	$Condition_date="";
    /****************فیلترها روی گزارش*******************/		
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
    if($shomare_eblagh) $Condition.=" AND shomare_eblagh='$shomare_eblagh' ";
    if($shomare_gharardad) $Condition.=" AND gharardad_kharid.shomare_gharardad='$shomare_gharardad' ";
    if($shomare_dastorolamal) $Condition.=" AND shomare_dastorolamal='$shomare_dastorolamal'";
    //if($noe_khat) $Condition.=" AND noe_khat LIKE '$noe_khat'";
    if($mahmule_type) $Condition.=" AND mahmule_type='$mahmule_type'";
	if($code_skk) $Condition.=" AND gharardad_kharid.code_skk='$code_skk'";//کد فروشنده /کشتی
	if($date1) $Condition_date.=" AND gharardad_kharid.tarikh_gharardad>='$date1'";
    if($date2) $Condition_date.=" AND gharardad_kharid.tarikh_gharardad<='$date2'";
	//if($date1) $Condition_date.=" AND r.tarikh_resid>='$date1'";
    //if($date2) $Condition_date.=" AND r.tarikh_resid<='$date2'";
/****************شروع نمایش گزارش*******************/	
    $page=1;
    $line=0;
    $i=0;
    $cntr=0;
    $radif=1;
	$sum=0;//مجموع 
	$sum_tedad=0;//مجموع 
    //در قراردادهای وارداتی کد کالا نداریم
	
	
	$q_eblagh="
	select id_eblagh ,shomare_eblagh , tarikh_eblagh ,mahmule_type, id_dastorolamal,shomare_dastorolamal , tarikh_dastorolamal ,
    id_gharardad, gharardad_kharid.shomare_gharardad , gharardad_kharid.tarikh_gharardad ,gharardad_kharid.code_ostan ,tarikh_etmam
    ,meghdar_gharardad_avaliye,gharardad_kharid.code_skk
   
    from 
    (select * from eblagh_kharid where deleted=0   ) as eblagh_kharid
    inner join 
     (select * from dastorolamal_kharid where deleted=0) as dastorolamal_kharid 
    using(id_eblagh)
    inner join
    (select * from  gharardad_kharid  where deleted=0) as gharardad_kharid
    using(id_dastorolamal)
   
    where 1=1 $Condition $Condition_date AND $Condition_ostan ;
	";
	
	
	$res_eblagh=$db->query($q_eblagh);
    $cntr =mysql_num_rows($res_eblagh);
	if(mysql_num_rows($res_eblagh)>0)//وجود داشتن
	{
     
	 
	 
	 $sql_main="
	 select id_eblagh,shomare_eblagh ,mahmule_type,code_group_kala_top,gosht_type, tarikh_eblagh , id_dastorolamal,shomare_dastorolamal ,
	 tarikh_dastorolamal,code_ostan,id_gharardad ,shomare_gharardad,code_skk,tarikh_gharardad  from 
(
select id_eblagh ,shomare_eblagh ,mahmule_type, code_group_kala_top,gosht_type,tarikh_eblagh , id_dastorolamal,shomare_dastorolamal , tarikh_dastorolamal ,
id_gharardad, gharardad_kharid.shomare_gharardad , gharardad_kharid.tarikh_gharardad ,gharardad_kharid.code_ostan ,tarikh_etmam
,meghdar_gharardad_avaliye,gharardad_kharid.code_skk

from 
(select * from eblagh_kharid where deleted=0   ) as eblagh_kharid
inner join 
(select * from dastorolamal_kharid where deleted=0) as dastorolamal_kharid 
using(id_eblagh)
inner join
(select * from  gharardad_kharid  where deleted=0) as gharardad_kharid
using(id_dastorolamal)

where 1=1 $Condition $Condition_date AND ($Condition_ostan)  

) as main_temp

 group by shomare_eblagh,shomare_dastorolamal,code_ostan,id_gharardad
 order by shomare_eblagh,code_ostan,shomare_dastorolamal,tarikh_gharardad
	 
	 
	 ";
	//and id_gharardad='1004' 
	 $res_main=$db->query($sql_main);
	 $i=1;
	 while($row_main=$db->fetch_assoc($res_main))
     {
		
	 
	 print_header();
	 
	 
	 if ($page==1)
	 {
	 /*سطر نمایش فیلترها*/
     if(is_array($ostanchoice))
     {
	  if($ostan_val==-1)$filter_string='همه استانها';
	  else $filter_string=' استان : ';
	  foreach($ostanchoice as $key => $ostan_val) {
	   $nameOstan=$db->get_from_where("name_ostan","ostan","code_ostan='$ostan_val'");
	   $filter_string.=''.$nameOstan.'&nbsp;-';
      }
     }	 
	 if($shomare_eblagh) $filter_string.=' شماره ابلاغ : '.$shomare_eblagh.'&nbsp;';
	 if($shomare_gharardad) $filter_string.=' شماره قرارداد : '.$shomare_gharardad.'&nbsp;';
	 if($shomare_dastorolamal) $filter_string.=' شماره دستورالعمل : '.$shomare_dastorolamal.'&nbsp;';
	 $nameSkk=$db->get_from_where("name_skk","mt_skk","code_skk='$code_skk'");
	 if($code_skk) $filter_string.=' طرف قرارداد(فروشنده) : '.$nameSkk.'&nbsp;';
	 if($code_group_kala_top){
	  // $nameGroupKala=$db->get_from_where("name_group_kala_top","bzacc.group_kala_top","code_group_kala_top='$code_group_kala_top'");
	   $filter_string.=' گروه کالا : '.$nameGroupKala.'&nbsp;'; 
	 }	 
	 if($noe_khat)   $filter_string.=' نوع خط : '.$noeKhatArr[$noe_khat].'&nbsp;';
	 if($mahmule_type)   $filter_string.=' نوع محموله : '.$mahmuletypeArr[$mahmule_type].'&nbsp;';
	 echo'<tr class="noExl"><td class="filter_text" colspan="40">فیلتر شده براساس : '.$filter_string.'</td></tr>';
	 }
	 $page++;
	 echo $columns;
		 
		 //اصل گزارش 
		 $base_shomare_eblagh=$row_main['shomare_eblagh'];
		 $base_id_eblagh=$row_main['id_eblagh'];
         $base_shomare_dastorolamal=$row_main['shomare_dastorolamal'];
		 $base_id_dastor=$row_main['id_dastorolamal'];
		 $base_id_gharardad=$row_main['id_gharardad'];
		 $base_shomare_gharardad=$row_main['shomare_gharardad'];
		 $base_code_ostan=$row_main['code_ostan'];
		 $base_code_skk=$row_main['code_skk'];
		  $noe_gosht="";
		 if ($row_main['gosht_type']==2)
		       $noe_gosht="گوشت گوساله <br>منجمد کارتنی داخلی";
		 else
         	if ($row_main['gosht_type']==1)	 
			   $noe_gosht="گوشت گوسفند <br>منجمد کارتنی داخلی";
		 //یافتن قرارداد و الحاقیه های قرارداد
		 
		 $tedad_elhaghie= $db->get_from_where('count(*)','elhaghie_kharid',"id_gharardad='$base_id_gharardad' and deleted=0");
		 $tedad_tamin_etebar =$db->get_from_where('count(*)','tamin_etebar',"id_gharardad='$base_id_gharardad' and deleted=0");
        $tedad_pardakht =$db->get_from_where('count(*)','pardakht_gharardad',"id_gharardad='$base_id_gharardad' and deleted=0");         	 
	   
	     $row_span=max($tedad_elhaghie+1, $tedad_pardakht);
		  
		  
    	  if($i%2)echo'<tr class="print_table-odd">';
          else echo'<tr class="print_table-even">';
	 
	     echo'   
		 <td rowspan="'.$row_span.'">'.$radif++.'</td>
	     <td class="shEblaghPr" rowspan="'.$row_span.'" >'.$row_main['shomare_eblagh'].'</td> 
	     <td class="dateEblaghPr" rowspan="'.$row_span.'" >'.$row_main['tarikh_eblagh'].'</td>';
         
         
		$code_ostan = $row_main['code_ostan'];
		echo ' <td rowspan="'.$row_span.'" class="shDastPr">'.$row_main['shomare_dastorolamal'].'</td>
		  <td rowspan="'.$row_span.'" class="dateDastPr">'.$row_main['tarikh_dastorolamal'].'</td>
		  
		  <td rowspan="'.$row_span.'" class="dateDastPr">'.$db->get_from_where("name_ostan","ostan","code_ostan='$code_ostan'").'</td>';
		  
		
		
        $sql_gharardad="select * from gharardad_kharid 
            where id_gharardad='$base_id_gharardad' and deleted=0
			

        ";
        
        
	    $res_gharardad=$db->query($sql_gharardad);
	    $row_gharardad=$db->fetch_assoc($res_gharardad);
		$code_skk=$row_gharardad['code_skk'];
		$name_foroshande=$db->get_from_where("name_skk","mt_skk","code_skk='$code_skk'");
		
		

	  
	  
		$tedad_elhaghie_gharardad=$db->get_from_where("count(*)","elhaghie_kharid","id_gharardad='$base_id_gharardad' and deleted=0");
        
       
		
		
		   
		echo '<td class="shEblaghPr" rowspan="'.$row_span.'" >'.$name_foroshande.'</td> '; 	
        echo '<td class="shEblaghPr"  >قرارداد</td> ';
	    echo '<td class="shEblaghPr"  >'.$row_gharardad['shomare_gharardad'].'</td> ';
		echo '<td class="shEblaghPr"  >'.$row_gharardad['tarikh_gharardad'].'</td> ';
		echo '<td class="shEblaghPr"  >'.$row_gharardad['tarikh_shoro'].'</td> ';
		echo '<td class="shEblaghPr"  >'.$row_gharardad['tarikh_etmam'].'</td> ';
		echo '<td class="shEblaghPr"  >'.number_format($row_gharardad['meghdar_gharardad_avaliye']).'</td> ';
		echo '<td class="shEblaghPr"  >'.number_format($row_gharardad['gheymat_har_kilo']).'</td> ';
		
		
					 
		
		

		$base_id_gharardad=$row_gharardad['id_gharardad'];
		echo '<td class="shEblaghPr" id=vazn_kol_gharardad_'.$base_id_gharardad .' rowspan="'.$row_span.'" ></td> '; 	
		echo '<td class="shEblaghPr" id=arzesh_kol_gharardad_'.$base_id_gharardad.' rowspan="'.$row_span.'" ></td> '; 	
		
        if ($row_span<3)
		  echo '<td class="shEblaghPr"  style="text-align: center;
  white-space: nowrap;
  vertical-align: middle;
  "  rowspan="'.$row_span.'">'.$noe_gosht.'</td> '; 
		
		else
		
        echo '<td class="shEblaghPr"  style="text-align: center;
  white-space: nowrap;
  vertical-align: middle;
  "  rowspan="'.$row_span.'" ><div style="-moz-transform: rotate(-90.0deg);  
      
  
         ">'.$noe_gosht.'</div></td> '; 
		
		$sql_tamin_etebar="select * from tamin_etebar where 
		             id_gharardad='$base_id_gharardad' and deleted=0 and whatform=1";
		$res_tamin_etebar=$db->query($sql_tamin_etebar);
	    $row_tamin_etebar=$db->fetch_assoc($res_tamin_etebar);
		echo '<td class="shEblaghPr"  >'.$row_tamin_etebar['shomare_tamin'].'</td> ';
		echo '<td class="shEblaghPr"  >'.$row_tamin_etebar['tarikh_tamin'].'</td> ';
		echo '<td class="shEblaghPr"  >'.number_format($row_tamin_etebar['mablagh_tamin']).'</td> ';
		

	    $total_tahvily=$db->get_from_where('sum(vazn_khales_r_d_sub) as total_vazn ',
		 ' shomare_safar
            inner join
            resid  using (id_safar)
            inner join 
            resid_kala_detail
            on 
              resid_kala_detail.shomare_resid =resid.shomare_resid  
              and  resid_kala_detail.code_ostan=resid.code_ostan
              and  resid_kala_detail.code_anbar=resid.code_anbar
              and  resid_kala_detail.year=resid.year
              and  resid_kala_detail.status=0
              and resid.status=0
			  and resid.sabt_nahayi=1 and resid.noe_tahvil_bar<>8 ',
			  "shomare_safar='$base_shomare_gharardad' and shomare_safar.code_skk='$base_code_skk'");
       
	    echo '<td class="shEblaghPr" rowspan="'.$row_span.'" >'.number_format($total_tahvily,2).'</td> '; 	
		
		
		
		
		

	
		$last_gheymat =$row_gharardad['gheymat_har_kilo'];
		$last_etmam=$row_gharardad['tarikh_etmam'];
		$last_meghdar=$row_gharardad['meghdar_gharardad_avaliye'];
		
			
		
		$sql_elhagh ="select * from elhaghie_kharid where  id_gharardad='$base_id_gharardad'
		and deleted=0
		order by tarikh_elhaghie";
		
		
		
		$res_elhagh=$db->query($sql_elhagh);
		$elhag_counter=0;
		$tedad_satr_khali =$row_span-($tedad_elhaghie+1) ;
		//محاسبات پرداختها 
		$sql_pardakht="select * from  pardakht_gharardad
                         where  id_gharardad='$base_id_gharardad' 
                         and deleted = 0";
		
     	$res_pardakht=$db->query($sql_pardakht);
	    $pardakht_array=array();   
	    while($row_pardakht=$db->fetch_assoc($res_pardakht))
        {
		   $array_row = array();
		   $array_row['shomare_nameh'] = $row_pardakht['shomare_nameh'];
           $array_row['tarikh_nameh'] = $row_pardakht['tarikh_nameh'];
		   $array_row['mablagh_pardakht'] = $row_pardakht['mablagh_pardakht'];
		   $array_row['meghdar'] = $row_pardakht['meghdar'];
		   $array_row['pardakht_type'] = $row_pardakht['pardakht_type'];
		   $pardakht_array[] = $array_row;
        }		
		// خاتمه محاسبات
	    $index_array_pardakht=0;
		
		echo '<td class="shEblaghPr" >'.$pardakht_array[$index_array_pardakht]['shomare_nameh'].'</td> '; 
		echo '<td class="shEblaghPr" >'.$pardakht_array[$index_array_pardakht]['tarikh_nameh'].'</td> '; 
		
		
		echo '<td class="shEblaghPr" >'.number_format($pardakht_array[$index_array_pardakht]['meghdar'],2).'</td> '; 
        if ($pardakht_array[$index_array_pardakht]['pardakht_type']==1)
		    echo '<td class="shEblaghPr" >بابت رسید کالا</td> ';   
		else	
		    if ($pardakht_array[$index_array_pardakht]['pardakht_type']==2)
		      echo '<td class="shEblaghPr" >بابت مابه التفاوت</td> '; 			
			else
			   	echo '<td class="shEblaghPr" ></td> '; 			
		echo '<td class="shEblaghPr" >'.$pardakht_array[$index_array_pardakht]['mablagh_pardakht'].'</td> '; 
		
								
		
		$total_pardakhty=$db->get_from_where('sum(mablagh_pardakht) as total_pardakhat',
		   'pardakht_gharardad',"id_gharardad='$base_id_gharardad' and deleted=0");   
		echo '<td class="shEblaghPr"  rowspan="'.$row_span.'" >'.number_format($total_pardakhty).'</td> '; 	
		
		echo '<td class="shEblaghPr" rowspan="'.$row_span.'" >'.number_format($row_gharardad['meghdar_gharardad_avaliye']+$row_gharardad['mazad_gharardad']-$total_tahvily,2).'</td> '; 	
		
		echo '<td class="shEblaghPr" id=mande_kol_gharardad_'.$base_id_gharardad .' rowspan="'.$row_span.'" ></td> '; 	
        
		echo '<td class="shEblaghPr" rowspan="'.$row_span.'" >'.$tazamin_gharardad.'</td> '; 	 
		echo '</tr>';
		
	    while($row_elhagh=$db->fetch_assoc($res_elhagh)   or $tedad_satr_khali !=0) 
		{
		 
		 
	     $base_id_elhaghie =$row_elhagh['id_elhaghie'];
		 $index_array_pardakht++;	
		 if ($elhag_counter < $tedad_elhaghie)
		 {	 
		 	 
		 $elhag_counter++;
		 $temp="";
		 
		 
		 
		 
		 
		 if ($row_elhagh['meghdar_type']==1)
		 {
		     
		     $temp=" افزایش مقدار ".$row_elhagh['meghdar_elhaghie'].")<br>";
			
			 $last_meghdar=$row_elhagh['meghdar_elhaghie']+$last_meghdar;;
			 }
         else
		   if ($row_elhagh['meghdar_type']==2)
		   {
             $temp =" کاهش مقدار (".$row_elhagh['meghdar_elhaghie'].")<br>";	
			 $last_meghdar=$last_meghdar-$row_elhagh['meghdar_elhaghie'];
			 }
			 
		if ($row_elhagh['modat_type']<>0)
        {		
		if ($row_elhagh['modat_type']==1)
             $temp.=" افزایش مدت <br>";
        else
		   if ($row_elhagh['modat_type']==2)
		    $temp.=" کاهش مدت <br>";
			
		  $last_etmam=$row_elhagh['tarikh_etmam_elhaghie'];	
		  }
		
		
		
		if ($row_elhagh['gheymat_type']==1)
		{
		     $diff=$row_elhagh['gheymat_elhaghie']-$last_gheymat;
		     $temp.=" افزایش قیمت (".$diff.")<br>";
			 $last_gheymat=$row_elhagh['gheymat_elhaghie'];
			 }
        else
		    if ($row_elhagh['gheymat_type']==2)
			{
			  $diff=$last_gheymat-$row_elhagh['gheymat_elhaghie'];
		      $temp.=" کاهش قیمت  (".$diff.")<br>";
			  $last_gheymat=$row_elhagh['gheymat_elhaghie'];
			  }
		
		
       if($i%2)echo'<tr class="print_table-odd">';
          else echo'<tr class="print_table-even">';		
		//echo '<tr>';
        echo '<td class="shEblaghPr" nowrap >الحاقیه'.$elhag_counter.'('.$temp.')</td> ';		
		echo '<td class="shEblaghPr"  >'.$row_elhagh['shomare_elhaghie'].'</td> ';
		echo '<td class="shEblaghPr"  >'.$row_elhagh['tarikh_elhaghie'].'</td> ';
		echo '<td class="shEblaghPr"  >'.$row_elhagh['tarikh_shoro_elhaghie'].'</td> ';
		
		echo '<td class="shEblaghPr"  >'.$last_etmam.'</td> ';
		echo '<td class="shEblaghPr"  >'.number_format(floatval($last_meghdar),2).'</td> ';
		echo '<td class="shEblaghPr"  >'.$last_gheymat.'</td> ';
		
		if ($row_elhagh['gheymat_type']==1 or $row_elhagh['meghdar_type']==1 )
		{
		$sql_tamin_etebar="select * from tamin_etebar where 
		             id_gharardad='$base_id_gharardad' and id_elhaghie='$base_id_elhaghie' and deleted=0 ";
		

        		
		$res_tamin_etebar=$db->query($sql_tamin_etebar);
	    $row_tamin_etebar=$db->fetch_assoc($res_tamin_etebar);
		echo '<td class="shEblaghPr"  >'.$row_tamin_etebar['shomare_tamin'].'</td> ';
		echo '<td class="shEblaghPr"  >'.$row_tamin_etebar['tarikh_tamin'].'</td> ';
		echo '<td class="shEblaghPr"  >'.$row_tamin_etebar['mablagh_tamin'].'</td> ';
		}
		else
		{
		echo '<td class="shEblaghPr"  ></td> ';
		echo '<td class="shEblaghPr"  ></td> ';
		echo '<td class="shEblaghPr"  ></td> ';
		
				
		}
		 }
		else
		{
			 if($i%2)echo'<tr class="print_table-odd">';
          else echo'<tr class="print_table-even">';		
			echo '<td class="shEblaghPr"  ></td> ';
		    echo '<td class="shEblaghPr"  ></td> ';
	    	echo '<td class="shEblaghPr"  ></td> ';
			echo '<td class="shEblaghPr"  ></td> ';
		    echo '<td class="shEblaghPr"  ></td> ';
	    	echo '<td class="shEblaghPr"  ></td> ';
			echo '<td class="shEblaghPr"  ></td> ';
			
			 echo '<td class="shEblaghPr"  ></td> ';
	    	echo '<td class="shEblaghPr"  ></td> ';
			echo '<td class="shEblaghPr"  ></td> ';
			
		    
			
			
			
		
		$tedad_satr_khali--;
		}
		 
		
		
		
		
		if ($index_array_pardakht <=count($pardakht_array))
		{
		   echo '<td class="shEblaghPr" >'.$pardakht_array[$index_array_pardakht]['shomare_nameh'].'</td> '; 
		   echo '<td class="shEblaghPr" >'.$pardakht_array[$index_array_pardakht]['tarikh_nameh'].'</td> '; 
		   echo '<td class="shEblaghPr" >'.number_format($pardakht_array[$index_array_pardakht]['meghdar'],2).'</td> ';
		   if ($pardakht_array[$index_array_pardakht]['pardakht_type']==1)
		     echo '<td class="shEblaghPr" >بابت رسید کالا</td> ';   
		   else	
		    if ($pardakht_array[$index_array_pardakht]['pardakht_type']==2)
		       echo '<td class="shEblaghPr" >بابت مابه التفاوت</td> '; 
			else
			  echo '<td class="shEblaghPr" ></td> '; 
			
		   echo '<td class="shEblaghPr" >'.$pardakht_array[$index_array_pardakht]['mablagh_pardakht'].'</td> '; 
	       
        
		}
		else{
		echo '<td class="shEblaghPr" ></td> '; 
		    echo '<td class="shEblaghPr" ></td> '; 
		    echo '<td class="shEblaghPr" ></td> ';	
			echo '<td class="shEblaghPr" ></td> '; 
		   echo '<td class="shEblaghPr" ></td> '; 
		    
		}
	
		
		
		 
		
	    
	    echo '</tr>';
	
	 
     	
	 }  
	 $kol_mablagh_gharardad =compute_gheymat_gharardad($base_id_gharardad,$db) ;
	  ?>
		   <script type="text/javascript">
        		   var php_var1 = "<?php echo 'vazn_kol_gharardad_'.$base_id_gharardad ?>";
		 			  
		    		  $("#"+php_var1).html("<?php echo number_format(floatval($last_meghdar),2) ?>");
		   
		            var php_var2 = "<?php echo 'arzesh_kol_gharardad_'.$base_id_gharardad ?>";
		 			  
		    		/*  $("#"+php_var2).html("<?php echo number_format($last_meghdar*$last_gheymat); ?>");*/
					$("#"+php_var2).html("<?php echo number_format($kol_mablagh_gharardad); ?>");
				
		 			 var php_var2 = "<?php echo 'mande_kol_gharardad_'.$base_id_gharardad ?>";
		 			  
		    		  $("#"+php_var2).html("<?php echo number_format($kol_mablagh_gharardad-$total_pardakhty); ?>");  
		    		  
		   </script>
		<?php
	  echo '</tr>'; 
	 
	  
     
	
	 // جمعهای آخر هر قرارداد
	 // جمعهای آخر هر قرارداد
	  echo'<tr class="print_table-even sum-row-white-b">';
	 
	    
	    echo ' <td class="shEblaghPr" colspan=12  >جمع قرارداد </td> ';
		echo ' <td class="shEblaghPr"  >'.number_format($last_meghdar,2).' </td> ';
		echo ' <td class="shEblaghPr"  >'.number_format($last_gheymat).' </td> ';
		echo ' <td class="shEblaghPr"  >'.number_format($last_meghdar,2).' </td> ';
		//echo ' <td class="shEblaghPr"  >'.number_format($last_meghdar*$last_gheymat).' </td> ';
		echo ' <td class="shEblaghPr"  >'.number_format($kol_mablagh_gharardad).' </td> ';
		echo ' <td class="shEblaghPr"  colspan=1> </td> '; 
		echo ' <td class="shEblaghPr"  colspan=1> </td> '; 
		echo ' <td class="shEblaghPr"  colspan=1> </td> '; 
		$total_tamin_etebar =$db->get_from_where('sum(mablagh_tamin)','tamin_etebar',"id_gharardad='$base_id_gharardad' and deleted=0");
		echo ' <td class="shEblaghPr"  colspan=1>'.number_format($total_tamin_etebar).' </td> ';
		echo ' <td class="shEblaghPr"  colspan=1>'.number_format($total_tahvily,2).' </td> ';
		echo ' <td class="shEblaghPr"  colspan=1></td> ';
		echo ' <td class="shEblaghPr"  colspan=1></td> ';
		
		
		 $sum = 0;
		 foreach ($pardakht_array as $item)
		 {
		      if ($item['pardakht_type']==1)
              $sum += $item['meghdar'];
          }
		  
		 echo ' <td class="shEblaghPr" dir="ltr">'.number_format($sum,2).' </td> '; 
		 echo ' <td class="shEblaghPr"  colspan=1></td> ';
		 
		 $sum = 0;
		 foreach ($pardakht_array as $item)
		 {
              $sum += $item['mablagh_pardakht'];
          }
		  
		 echo ' <td class="shEblaghPr" dir="ltr">'.number_format($sum).' </td> '; 
		 echo ' <td class="shEblaghPr" dir="ltr">'.number_format($sum).' </td> '; 
		 
		 
		 echo ' <td class="shEblaghPr" dir="ltr">'.number_format($last_meghdar-$total_tahvily,2).' </td> '; 
		 
		 echo ' <td class="shEblaghPr" dir="ltr" nowrap >'.number_format($kol_mablagh_gharardad-$total_pardakhty,0,"'","/").'</td>';
		 
		 echo ' <td class="shEblaghPr"  colspan=1></td> ';
		
	 echo '</tr>';
	 
	 
	
	 $i++;
	 
	 
	   
	   echo '</table>';
	   echo '<span class="exportToExcel" style="float:right" id="exportExcel"" title="خروجی اکسل" ></span>';
	   echo '<br class="pbreak">';
	 }
	 echo'
	   <tr class="print_footer noExl">
       <td colspan="40">&nbsp;&nbsp;نام کاربر :&nbsp;&nbsp;'.$mtuserNAME.' &nbsp;&nbsp;&nbsp; تاریخ چاپ : '.$today.' &nbsp;&nbsp;&nbsp; ساعت چاپ : '.$logtime.'</td>
       </tr>';
	 
	}//END IF //وجود داشتن
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
	
				
				
			
$( document ).ready(function() {	    	
//نمایش ستونها



	    $("input:checkbox:not(:checked)").each(function() {
         var column = "table ." + $(this).attr("name");
         $(column).hide();
        });
		
        $("input:checkbox").click(function(){
         var column = "table ." + $(this).attr("name");
         $(column).toggle();
         var count_for_sum=14;//default
		 var numberNotChecked  = $(".count_sum:not(:checked)").length; //only the class count_sum 
		 var count_for_sum=count_for_sum-numberNotChecked;
		 $(".sum_row").attr("colspan",count_for_sum);
        }); 
		
		$(".exportToExcel").click(function(e){
			        	    
					var table = $(this).prev('.table2excel');
					
					if(table && table.length){
						
						$(table).table2excel({
							exclude: ".noExl",
							name: "Excel Document Name",
							filename: "myFileName" + new Date().toISOString().replace(/[\-\:\.]/g, "") + ".xls",
							fileext: ".xls",
							exclude_img: true,
							exclude_links: true,
							exclude_inputs: true
							
						});
					}
				});
});
</script> 