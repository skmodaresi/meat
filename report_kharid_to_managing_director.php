<?php
session_start();
//error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="report_kharid_to_managing_director.php";
$today=AsLDate($yymmdd);
$logtime=date('H:i');
$titr='گزارش خرید طی دوره با احتساب مابه التفاوت';
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
echo'
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>'.$titr.'</title>
<link href="styles.css" rel="stylesheet" type="text/css"/>
<link type="text/css" href="styles/jquery-ui-1.8.14.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="styles/easyui.css">
<link rel="stylesheet" type="text/css" href="styles/easyui-rtl.css"> 
<script type="text/javascript" src="functions.js"></script>
<script type="text/javascript" src="scripts/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="scripts/jquery.easyui.min.js"></script>
<script type="text/javascript" src="scripts/easyui-rtl.js"></script> 	
<script type="text/javascript" src="scripts/jquery.ui.datepicker-cc.all.min.js"></script>
<script src="scripts/jquery.table2excel.js"></script>
<style>
       @media screen
       {
           .hideatprint
           {
           }
       }
       @media print
       {
           .hideatprint
           {
               display: none;
           }
       }
</style>
<script type="text/javascript">
$(function(){	    
    $("#datepickerfrom").datepicker({
	    showOn: "button",
        buttonImage: "styles/images/calendar5.png",
        buttonImageOnly: true,
		showButtonPanel: true,
		changeMonth: true,
	    changeYear: true,
	  onSelect: function(dateText, inst){
	  $("#datepickerto").datepicker("option", "minDate", new JalaliDate(inst["selectedYear"], inst["selectedMonth"], inst["selectedDay"]));
	   }
	  });
	  $("#datepickerto").datepicker(
	  { showOn: "button",
        buttonImage: "styles/images/calendar5.png",
        buttonImageOnly: true,
		showButtonPanel: true,
		changeMonth: true,
	    changeYear: true}
	  );
	  //نمایش ستونها
	    $("input:checkbox:not(:checked)").each(function() {
         var column = "table ." + $(this).attr("name");
         $(column).hide();
		 
		 
        });
        $("input:checkbox").click(function(){
         var column = "table ." + $(this).attr("name");
         $(column).toggle();
		 if( $(column).is(":visible")) 
		 {
		 
		         $(column).each(function(){
                     $(this).removeClass("noExl");
                });
				
				}
		 else
		       {
			    $(column).each(function(){
                     $(this).addClass("noExl");
		        });
				
				}

         var count_for_sum=6;//default
		 var numberNotChecked  = $(".count_sum:not(:checked)").length; //only the class count_sum 
		 var count_for_sum=count_for_sum-numberNotChecked;
		 $("#sum_row").attr("colspan",count_for_sum);
        }); 
	  //خروجی اکسل
      $("#exportExcel").click(function(){
		  		$(".table2excel").table2excel({
		  			exclude: ".noExl",
		  			name: "Excel Document Name",
		  			filename: "report_gharardad",
		  			fileext: ".xls",
		  			exclude_img: true,
		  			exclude_links: true,
		  			exclude_inputs: true
		  		});
	    });	
});
function enterField(shomare_eblagh)
{
  $("#loading").fadeIn("fast");
  $.post("ajax.php",{shomare_Error:shomare_eblagh},function(data){$("#Fill").html(data);});
  $("#loading").fadeOut("fast");				
}
</script> 
</head>';
/****************هدر******************/
$columns='
	   <tr class="print_table-title2" style="line-height:25px;">
	    <td width=3%>ردیف</td>
		<td width=7% class="ostan">استان</td>
	    <td width=7% class="shgharardad">شماره قرارداد</td>
	    <td width=6% class="tarikhgharardad">تاریخ قرارداد</td>
	    <td width=10% class="skk">نام فروشنده</td>

	    <td width=10% class="namekala">نام کالا</td>
	    
	    <td width="7%" class="meghdargharardad">مقدار قرارداد</td>
	    <td width="5%" class="mazad">جمع وزنی الحاقیه ها</td>
		
		<td width="5%" class="vazngharardadbaelhaghie">مقدار کل قرارداد با احتساب الحاقیه ها</td>
		<td width="5%" class="lastprice">آخرین قیمت هر کیلوگرم  از قرارداد</td>
		
		<td width="5%" class="mablaghkolgharardad">مبلغ کل قرارداد</td>
		<td width="5%" class="mizanetebar">مبلغ کل درخواست تامین اعتبار</td>
		
	    <td width="5%" class="koltahvily">وزن کل تحویلی ثبت نهایی</td>
		<td width="5%" class="vaznpardakhtshode">جمع وزن درخواست پرداخت</td>
		<td width="5%" class="jampardakhtshode">جمع مبلغ درخواست پرداخت</td>
	    <td width="7%" class="tahviltteydore">تحویلی طی دوره واحد : کیلوگرم</td>
		<td width="7%" class="malblagdore"> مبلغ قابل پرداخت طی دوره</td>
		<td width="7%" class="maboltafavot">مبلغ مابه التفاوت </td>
	    <td width="7%" class="jammaboltafavotvapardakhty">مبلغ قابل پرداخت به انضمام محاسبات مابه التفاوت</td>
		
	    
	   </tr>';
Function print_header()
{global $titr,$mt_gl_owner,$mt_gl_name_anbar,$mt_gl_name_ostan,$date1,$date2,$FileName,$page;
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
	    از تاریخ رسید : '.$date1.' تا تاریخ رسید : '.$date2.'&nbsp&nbsp(صفحه : '.$page.')
	    <div style="float:left;"><button class="buttonme" onClick="window.location=\''.$FileName.'\'">بازگشت</button></div>
	    </td>  
	   </tr>
      </table>
	 </td>
    </tr>';
}
/***************************************** MAIN*****************************************/
echo'
<body class="openwin" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="document.myform.date1.focus();">
<form method="post" name="myform" onkeydown="enterIE()">';
if(!$MaxLines) $MaxLines=15;
if(!$ok)
{
 echo'
 <table width="90%" height="100%" align="center" cellpadding="0" cellspacing="0">
  <img src="images/loading.gif" id="loading" class="loading_img"/>
  <tr>
   <td height="100%">
    <div style="float:right;width:100%;margin:0px;height:100%;overflow:auto;overflow-x:hidden;">
    <table width="650px" border="0" align="center" cellpadding="0" cellspacing="0" >
     <tr><td colspan="4" height="20px">&nbsp;</td></tr>
 	 <tr><td colspan="4" class="title">'.$titr.'</td></tr>
	 <tr class="tr1">	
      <td align="left"> تاریخ قرارداد از :&nbsp;</td><td align="right"><input type="text" class="textboxme2" maxlength="10" name="date1" id="datepickerfrom" placeholder="'.$date1.'"/></td>
      <td align="left"> تا تاریخ :&nbsp;</td><td align="right"><input type="text" class="textboxme2" maxlength="10" name="date2" id="datepickerto" placeholder="'.$date2.'"/></td>
 	 </tr>
	 <tr class="tr1">
	  <td align="left" width="150px"><span class="star">*</span> شماره ابلاغ :&nbsp; </td>
	  <td align="right" colspan="3">
	  <input type="hidden" name="id_eblagh" value="'.$id_eblagh.'"/>
	  <input type="hidden" name="meghdar_kharid_keshvar" value="'.$meghdar_kharid_keshvar.'"/>
	  <input type="text" class="textboxme2" name="shomare_eblagh" value="'.$shomare_eblagh.'" onblur="enterField(this.value)"/>';
       include('img_eblagh.php');
	     echo'
	   &nbsp;<span style="color:red" id="Fill">&nbsp;</span></td>
	   </td>
	  </tr>
	  <tr class="tr1">
	   <td align="left"> طرف قرارداد (فروشنده) :&nbsp;</td>
	   <td align="right"><input type="text" class="textboxme2" name="code_skk" value="'.$code_skk.'" onkeypress="return isNumber(event)" onfocus="getShomareSafar(this.value)" onchange="getShomareSafar(this.value)"/>
	    <input type="hidden" name="name_skk" value="name_skk"/>';
	    include("img_helpcoding_mali.php");
		echo '
	   <td align="left"> نوع خط :&nbsp;</td><td align="right">'.static_listbox("noe_khat",$noe_khat,"noeKhatArr",1,"class='easyui-combobox text4' data-options=panelHeight:125").'</td>	  
	  </tr>';
	  
	  echo '<tr class="tr1">';
		echo '<td align="left" width="150px" > وضعیت مقدار تحویلی طی دوره :&nbsp;</td>';
		echo '<td  align="right" colspan=4">
		  <select  name="report_type">
		      <option value=1>کلیه قراردادها 
			  <option value=2>قراردادهایی با مقدار تحویلی طی دوره </option>
			  <option value=3>قراردادهایی با مبلغ قابل پرداخت </option>
		</select>'.'</td>';
        echo'<td></td><td></td>';
		
	    echo'
		</tr>
	  
	  
	  <tr class="tr1">
	   <td align="left" > تعداد خط در صفحه :&nbsp;</td><td align="right"><input type="number" class="textboxme2" name="MaxLines" value="'.$MaxLines.'" onkeypress="return isNumber(event)"/></td>	';
    if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
	{
	 echo'
	  <td align="left">نام استان :&nbsp;</td>
      <td align="right" colspan="3">
	   <select name="ostanchoice[]"  class="easyui-combobox text4" style=width:200px  multiple>';
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
    <tr class="footer" align="center"><td colspan="4" height="40px"><input class="buttonme" type="submit" name="ok" value="شروع گزارش"></td></tr>   
    </table>
    </div>
   </td>
  </tr>
 </table>';
}
else
{
    if(!$shomare_eblagh){echo"<script>alert('لطفاً شماره ابلاغ را وارد نمایید !')</script>";
                   echo"<script>window.location='$FileName';</script>";}
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
    if($noe_khat) $Condition.=" AND noe_khat LIKE '$noe_khat'";
	if($code_skk) $Condition.=" AND code_skk='$code_skk'";//کد فروشنده /کشتی
	// if($date1) $Condition_date.=" AND T.tarikh_gharardad>='$date1'";
    // if($date2) $Condition_date.=" AND T.tarikh_gharardad<='$date2'";
	if($date1) $Condition_date.=" AND tarikh_gharardad>='$date1'";
    if($date2) $Condition_date.=" AND tarikh_gharardad<='$date2'";
	if($report_type==2)
	   $condition_report_type =" AND abs(ifnull(total_vazn_resid_shode,0)-ifnull(total_meghdar_vazn_pardakht_shode,0)) >0.001 ";
	ELSE
        " AND 1=1 ";	
	   
/****************شروع نمایش گزارش*******************/	
    $page=1;
    $line=0;
    $i=0;
    $cntr=0;
    $radif=1;
	$sum=0;//مجموع 
	$sum_tedad=0;//مجموع 
$q="select * from 
	
	
	(select id_gharardad,name_ostan, termination,name_skk,gosht_type,gharardad_kharid.shomare_gharardad , gharardad_kharid.year , gharardad_kharid.code_ostan ,gharardad_kharid.code_skk , gharardad_kharid.tarikh_gharardad , tarikh_etmam ,
meghdar_gharardad_avaliye ,mazad_gharardad , gheymat_har_kilo  ,id_dastorolamal,id_eblagh,shomare_eblagh
,(
 select sum(vazn_khales_r_d_sub) as total_vazn_resid_shode
		 from shomare_safar
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
			  and resid.sabt_nahayi=1 and resid.noe_tahvil_bar<>8 
			  where shomare_safar=gharardad_kharid.shomare_gharardad and shomare_safar.code_skk=gharardad_kharid.code_skk
) as total_vazn_resid_shode,
(select sum(mablagh_pardakht) as total_pardakht_shode 
		   from pardakht_gharardad
       where pardakht_gharardad.id_gharardad=gharardad_kharid.id_gharardad and deleted=0) as total_pardakht_shode 
,
(select sum(meghdar) as total_meghdar_vazn_pardakht_shode 
		   from pardakht_gharardad
       where pardakht_type=1 and pardakht_gharardad.id_gharardad=gharardad_kharid.id_gharardad and deleted=0)
       as total_meghdar_vazn_pardakht_shode 

from eblagh_kharid
inner join dastorolamal_kharid 
using(id_eblagh)
inner join gharardad_kharid
using(id_dastorolamal)
INNER JOIN ostan ON ostan.code_ostan=gharardad_kharid.code_ostan
INNER JOIN mt_skk ON mt_skk.code_skk=gharardad_kharid.code_skk
where eblagh_kharid.deleted=0 and dastorolamal_kharid.deleted=0 and gharardad_kharid.deleted=0 
and shomare_eblagh='".$shomare_eblagh."'
order by code_ostan , tarikh_gharardad) as main
where  1=1 and $Condition_ostan $Condition  $Condition_date $condition_report_type 


order by code_ostan , tarikh_gharardad
";

	
	$res=$db->query($q);
    $cntr =mysql_num_rows($res);
	if(mysql_num_rows($res)>0)//وجود داشتن
	{
	echo'
	 <table class="hideatprint" width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">   
      	<tr class="print_table-title2 "><td colspan="30">وضعیت نمایش ستونها در گزارش</td></tr>
		<tr class="print_table-title2 select_all">
		
	    <td width=7% >استان</td>
	    <td width=7% >شماره قرارداد</td>
	    <td width=6% >تاریخ قرارداد</td>
	    <td width=10% >نام فروشنده</td>
	    <td width=10% >نام کالا</td>
		
	    <td width="7%" >مقدار قرارداد</td>
	    <td width="5%" >جمع وزنی الحاقیه ها</td>
		<td width="5%" >مقدار کل قرارداد با احتساب الحاقیه ها</td>
		<td width="5%" >آخرین قیمت هر کیلوگرم  از قرارداد</td>
		<td width="5%" >مبلغ کل قرارداد</td>
		<td width="5%" >مبلغ کل تامین اعتبار</td>
		
	    <td width="5%" >وزن کل تحویلی</td>
		<td width="5%" >جمع وزن پرداخت شده</td>
		<td width="5%" >جمع پرداخت شده </td>
	    <td width="7%" >تحویلی طی دوره واحد : کیلوگرم</td>
		<td width="7%" > مبلغ قابل پرداخت طی دوره</td>
		<td width="7%" >مبلغ مابه التفاوت </td>
	    <td width="7%" >مبلغ قابل پرداخت به انضمام محاسبات مابه التفاوت</td>
		

	    </tr>   	
		<tr class="print_table-title2">
	     <td><input name="ostan" class="count_sum" type="checkbox" checked ></td>
	     <td><input name="shgharardad" class="count_sum" type="checkbox" checked ></td>
	     <td><input name="tarikhgharardad" class="count_sum" type="checkbox" checked ></td>
	     <td><input name="skk" class="count_sum" type="checkbox" checked ></td>
		 <td><input name="namekala" class="count_sum" type="checkbox" checked ></td>
		 
	     <td><input name="meghdargharardad"  type="checkbox" checked ></td>
		 <td><input name="mazad"  type="checkbox" checked ></td>
		 <td><input name="vazngharardadbaelhaghie"  type="checkbox" checked ></td>
		 <td><input name="lastprice"  type="checkbox" checked ></td>
		 <td><input name="mablaghkolgharardad"  type="checkbox" checked ></td>
	     <td><input name="mizanetebar"  type="checkbox" checked></td>
		 
	     <td><input name="koltahvily"  type="checkbox" checked ></td>
	     <td><input name="vaznpardakhtshode" type="checkbox" checked ></td>
		 <td><input name="jampardakhtshode" type="checkbox" checked ></td>
		 <td><input name="tahviltteydore" type="checkbox"  checked></td>
		 <td><input name="malblagdore"  type="checkbox" checked></td>
	     <td><input name="maboltafavot" type="checkbox"  checked></td>
	     <td><input name="jammaboltafavotvapardakhty" type="checkbox" checked ></td>
	 
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
	 if($shomare_eblagh) $filter_string.=' شماره ابلاغ : '.$shomare_eblagh.'&nbsp;';
	 if($code_skk) $filter_string.=' کد مشتری : '.$code_skk.'&nbsp;';
	 if($noe_khat)   $filter_string.=' نوع خط : '.$noeKhatArr[$noe_khat].'&nbsp;';
	 {echo'<tr class="noExl"><td class="filter_text" colspan="40">فیلتر شده براساس : '.$filter_string.'</td></tr>';}
	 echo $columns;
	 
	 while($row=$db->fetch_assoc($res))
     {
	  $id_gharardad=$row['id_gharardad'];
	  
	  $gheymat_kol_gharadad_ba_elhaghieha= compute_gheymat_gharardad($id_gharardad,$db);
	  
	 
	  
	  $results = compute_ghardad_payment($id_gharardad,$db); 
	  if($report_type==3)
	  {
	   if (abs($results[1]-$row['total_pardakht_shode']) <0.001)
	     continue; 
		}
	 
	  $line++;
	  if($i++%2)echo'<tr class="print_table-odd">';
      else echo'<tr class="print_table-even">'; 
	  //کل تحویلی قرارداد
	  //قوطی
	 
		 $noe_gosht="";
		 if ($row['gosht_type']==2)
		       $noe_gosht="گوشت گوساله منجمد کارتنی داخلی";
		 else
         	if ($row['gosht_type']==1)	 
			   $noe_gosht="گوشت گوسفند منجمد کارتنی داخلی";
		$last_price = $row['gheymat_har_kilo'];   
		$exist_elhaghie=$db->get_from_where("COUNT(*)","elhaghie_kharid","id_gharardad='".$id_gharardad."' AND deleted=0 ");
        if($exist_elhaghie>0)//اگر الحاقیه دارد
        {
			
           $gheymat_elhaghie=$db->get_from_where("gheymat_elhaghie","elhaghie_kharid","id_gharardad='$id_gharardad' AND gheymat_elhaghie>0 AND deleted=0 ORDER BY tarikh_elhaghie desc,id_elhaghie desc "); 
           
		   if (!is_null($gheymat_elhaghie))
		   {
              $last_price=$gheymat_elhaghie;
			 
		   }
		   $last_tamdid_date =$db->get_from_where("tarikh_etmam_elhaghie","elhaghie_kharid","id_gharardad='$id_gharardad' and modat_type>0 and deleted=0 order by  tarikh_elhaghie desc , id_elhaghie desc  "); 
		
		   
         }
       else//اگر الحاقیه ندارد
       {
           $last_price=$row['gheymat_har_kilo'];
           IF($row['gheymat_har_kilo']=='0')
			   {
				   $last_price=$db->get_from_where("gheymat_kharid","gheymat_kharid","id_dastorolamal='".$row['id_dastorolamal']."' AND deleted=0 ");
				}
			$last_tamdid_date="";	
        }   
		      
		// محاسبه تامین اعتبار
		$sum_tamin_etebar =$db->get_from_where("sum(mablagh_tamin)","tamin_etebar","id_gharardad='$id_gharardad' and deleted=0  "); 
		
	 $mablagh_kol_array=compute_ghardad_payment($id_gharardad,$db); 
     $mablagh_kol=($mablagh_kol_array[1] +($row['meghdar_gharardad_avaliye']+$row['mazad_gharardad']-$mablagh_kol_array[0])*$last_price);
	 $shomre_ghrardad=$row['shomare_gharardad'];
	 
	 $sql_pardakht_tey_dore="select tarikh_resid , shomare_resid , shomare_safar ,round(vazn_khales_r,3) as vazn_resid from shomare_safar
	    inner join resid 
        on 	resid.id_safar = shomare_safar.id_safar 
        where shomare_safar='$shomre_ghrardad'
        and deleted=0 and status=0 
		and resid.sabt_nahayi=1 and resid.noe_tahvil_bar<>8 
        order by tarikh_resid desc ";
	 
	$res_tey_dore=$db->query($sql_pardakht_tey_dore);
	$sum_vazn_tey_dore=round($row['total_vazn_resid_shode'],3)-round($row['total_meghdar_vazn_pardakht_shode'],3);
    
	$sum_vazn=0;
	$mablagh_tey_dore=0;
	$res_tey_dore=$db->query($sql_pardakht_tey_dore);
	while($row_resid=$db->fetch_assoc($res_tey_dore))
	{
	    if (round($sum_vazn,3) < round($sum_vazn_tey_dore,3))
		{
		    
		    $mablagh_tey_dore  += round($row_resid['vazn_resid'],3)*compute_resid_price($row_resid['tarikh_resid'] ,$id_gharardad, $db);
	        $sum_vazn+= $row_resid['vazn_resid'] ;
			
		}
		else
		  break ;	 
    }
	
		
	  echo'  
	    <td>'.$radif++.'</td>
	    <td class="ostan">'.$row['name_ostan'].'</td>
	    <td class="shgharardad">'.$row['shomare_gharardad'].'</td>
	    <td class="tarikhgharardad">'.$row['tarikh_gharardad'].'</td>
	    
	    <td class="skk">'.$row['name_skk'].'</td>';
		 
		   
		echo '	   
	    <td class="namekala">'.$noe_gosht.'</td>';
	    
		
		echo'
		<td class="meghdargharardad">'.round($row['meghdar_gharardad_avaliye'],3).'</td>
	    <td class="mazad">'.number_format($row['mazad_gharardad'],3).'</td>
		
		<td class="vazngharardadbaelhaghie">'.number_format($row['meghdar_gharardad_avaliye']+$row['mazad_gharardad'],3).'</td>
		<td class="lastprice">'.virgul($last_price).'</td>
		
		<td class="mablaghkolgharardad">'.virgul($mablagh_kol).'</td>
		
		<td class="mizanetebar">'.virgul($sum_tamin_etebar).'</td>
		
		
	    <td class="koltahvily">'.number_format($row['total_vazn_resid_shode'],3).'</td>
	    <td class="vaznpardakhtshode">'.number_format($row['total_meghdar_vazn_pardakht_shode'],3).'</td>
		<td class="jampardakhtshode">'.number_format($row['total_pardakht_shode']).'</td>
		<td class="tahviltteydore">'.number_format($row['total_vazn_resid_shode']-$row['total_meghdar_vazn_pardakht_shode'],3).'</td>
		
		<td class="malblagdore">'.virgul($mablagh_tey_dore).'</td>
		<td class="maboltafavot">'.virgul($results[1]-$row['total_pardakht_shode']-$mablagh_tey_dore).'</td>
		<td class="jammaboltafavotvapardakhty">'.virgul(round($results[1],3)-round($row['total_pardakht_shode'],3)).'</td>
		
	   </tr>';
		if($line>=$MaxLines && $i<$cntr)//تکرار هدر در صفحات بعد
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
	 
	 $jame_meghdar_gharardad_avaliye+=$row['meghdar_gharardad_avaliye'];
	 $jame_mazad_gharardad +=$row['mazad_gharardad'];
	 $jam_meghdar_gharardad_va_mazad+=($row['meghdar_gharardad_avaliye']+$row['mazad_gharardad']);
	 //$jam_kol_gharardadha+=($row['meghdar_gharardad_avaliye']+$row['mazad_gharardad'])*$last_price;
	 //$jam_kol_gharardadha+=$gheymat_kol_gharadad_ba_elhaghieha;
	 $jam_kol_gharardadha+=$mablagh_kol;
	 $jam_kol_tamin_etebar+=$sum_tamin_etebar;
	 $jam_resid+=$row['total_vazn_resid_shode'];
	 $jam_vazn_pardakht_shode+=$row['total_meghdar_vazn_pardakht_shode'];
	 $jam_pardakht_shode+=$row['total_pardakht_shode'];
	 
	 
	 
	 
	 
	 
	  $jame_meghdar_tahvily_tey_dore+=$row['total_vazn_resid_shode']-$row['total_meghdar_vazn_pardakht_shode'];
	  //$jam_mablagh_ghabel_pardakht+=(round($row['total_vazn_resid_shode'],3)-round($row['total_meghdar_vazn_pardakht_shode'],3))*$last_price;
	  $jam_mablagh_ghabel_pardakht+=$mablagh_tey_dore ;
	  //$jam_maboltafavot+=$results[1]-$row['total_pardakht_shode']-(round($row['total_vazn_resid_shode'],3)-round($row['total_meghdar_vazn_pardakht_shode'],3))*$last_price;
	  $jam_maboltafavot+=($results[1]-$row['total_pardakht_shode']-$mablagh_tey_dore);
	  $jam_maboltafavot_va_dore+=$results[1]-$row['total_pardakht_shode'];

	  //if($row['code_bastebandy']==2) $vahed='(تعداد)';
	  //else $vahed='(کیلوگرم)';
     }//END while
	 echo'
	  <tr class="print_table-even sum-row-white-b">
	   <td id="sum_row" colspan="6">جمع مقادیر '.$vahed.'</td>
	   <td class="meghdargharardad">'.number_format(round($jame_meghdar_gharardad_avaliye,3),3).'</td>
	   <td class="mazad">'.number_format(round($jame_mazad_gharardad,3),3).'</td>
	   <td class="vazngharardadbaelhaghie">'.number_format(round($jam_meghdar_gharardad_va_mazad,3),2).'</td>
	   <td class="lastprice"></td>
	   <td class="mablaghkolgharardad">'.number_format(round($jam_kol_gharardadha,3)).'</td>
	   <td class="mizanetebar">'.number_format(round($jam_kol_tamin_etebar,3)).'</td>
	   <td class="koltahvily">'.number_format(round($jam_resid,3),3).'</td>
	   <td class="vaznpardakhtshode">'.number_format(round($jam_vazn_pardakht_shode,3),3).'</td>
	   <td class="jampardakhtshode">'.number_format(round($jam_pardakht_shode,3)).'</td>
	   
	   
	   
	   <td class="tahviltteydore">'.number_format(round($jame_meghdar_tahvily_tey_dore,3),3).'</td>
	   <td class="malblagdore">'.number_format(round($jam_mablagh_ghabel_pardakht,3)).'</td>
	   <td class="maboltafavot">'.number_format(round($jam_maboltafavot,3)).'</td>
	   <td class="jammaboltafavotvapardakhty">'.number_format(round($jam_maboltafavot_va_dore,3)).'</td>
	  
	  </tr>
	 <!--پايان مرکز صفحه -->
     <!-- چاپ زیرنوس-->';
     require_once('prt-footer.php');
     echo' 
     </table>';
	}//END IF //وجود داشتن
	 ELSE{echo'<div class="msg_error"><span >اطلاعاتی یافت نشد</span><br><button class="buttonme hideatprint" onClick="window.location=\''.$FileName.'\'">بازگشت</button></div>';}
}
echo'
</div>	
</form>
</body>
</html>';	
?>