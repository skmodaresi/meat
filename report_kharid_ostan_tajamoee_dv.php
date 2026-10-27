<?php
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="report_kharid_ostan_tajamoee_dv.php";
$today=AsLDate($yymmdd);
$logtime=date('H:i');
$titr='گزارش خرید تجمعی به تفکیک داخلی وارداتی';
require_once('head.html');	
if(!$date1)//اگر کاربر تاریخ اول را وارد نکرده بود
{
	 $date1=$db->get_from_where("MIN(tarikh_gharardad)","gharardad_kharid","");  
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
	    <td width="2%" rowspan="3">ردیف</td>
	    <td width="5%" rowspan="3" class="ostanPr">استان</td>
		<td width="5%" rowspan="3" class="grkalaPr">گروه کالا</td>
	    <td width="5%" colspan="2" class="meghdarPr">مقدار قرارداد</td>
	    <td width="5%" colspan="2" class="mazadPr">مقادیرالحاقیه</td>
	    <td width="5%" colspan="4" class="tahvilyPr">تحویلی (ثبت نهایی شده)</td>
	    <td width="5%" colspan="2" class="mandePr">مانده از قرارداد</td>
		<td width="5%" colspan="2" class="mablagh_tahvilPr">مبلغ کل تحویلی</td>
	   </tr>
	   <tr class="print_table-title2" style="line-height:25px;">
	    <td rowspan="2"> داخلی </td>
	    <td rowspan="2"> وارداتی </td>
        <td rowspan="2"> داخلی </td>
	    <td rowspan="2"> وارداتی </td>
		<td colspan="2"> داخلی </td>
	    <td colspan="2"> وارداتی </td>
		<td rowspan="2"> داخلی </td>
	    <td rowspan="2"> وارداتی </td>
		<td rowspan="2"> داخلی </td>
	    <td rowspan="2"> وارداتی </td>
	   </tr>
	   <tr class="print_table-title2" style="line-height:25px;">
	    <td> وزن ناخالص  </td>
	    <td> وزن خالص  </td>
		<td> وزن ناخالص  </td>
	    <td> وزن خالص  </td>
	   </tr>

	   ';
Function print_header()
{global $titr,$mt_gl_owner,$date1,$date2,$date_eblagh1,$date_eblagh2,$date_resid1,$date_resid2,$FileName,$page;
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
	     از تاریخ قرارداد : '.$date1.' تا تاریخ قرارداد : '.$date2.'&nbsp&nbsp(صفحه : '.$page.')';
		 // IF($date_eblagh1) echo' از تاریخ ابلاغ '.$date_eblagh1.'  ';
		 // IF($date_eblagh2) echo' تا تاریخ ابلاغ '.$date_eblagh2.' ';
		 // IF($date_resid1) echo' از تاریخ رسید '.$date_resid1.'  ';
		 // IF($date_resid2) echo' تا تاریخ رسید '.$date_resid2.' ';
	     echo'
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
<form method="post" name="myform">';
if(!$MaxLines) $MaxLines=32;
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
	 <tr class="tr1" >	
      <td align="left" height="40px"> از تاریخ (قرارداد) :&nbsp;</td><td align="right"><input type="text" class="textboxme2 datepickerfrom" maxlength="10" name="date1"  placeholder="'.$date1.'"/></td>
      <td align="left"> تا تاریخ (قرارداد):&nbsp;</td><td align="right"><input type="text" class="textboxme2 datepickerto" maxlength="10" name="date2"  placeholder="'.$date2.'"/></td>
 	 </tr>
	 <tr class="tr1" >	
      <td align="left" height="40px"> از تاریخ (ابلاغ) :&nbsp;</td><td align="right"><input type="text" class="textboxme2 datepickerfrom" maxlength="10" name="date_eblagh1" /></td>
      <td align="left"> تا تاریخ (ابلاغ):&nbsp;</td><td align="right"><input type="text" class="textboxme2 datepickerto" maxlength="10" name="date_eblagh2"  /></td>
 	 </tr>
     <tr class="tr1" >	
      <td align="left" height="40px"> از تاریخ (رسید سردخانه) :&nbsp;</td><td align="right"><input type="text" class="textboxme2 datepickerfrom" maxlength="10" name="date_resid1"  /></td>
      <td align="left"> تا تاریخ (رسید سردخانه):&nbsp;</td><td align="right"><input type="text" class="textboxme2 datepickerto" maxlength="10" name="date_resid2"  /></td>
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
	  <td align="left"> شماره قرارداد :&nbsp; </td>
	  <td align="right">
	   <input type="text" class="textboxme2" name="shomare_gharardad" value="'.$shomare_gharardad.'" />';
         //include('img_eblagh.php');
	     echo'
	  </td>
	 </tr>
	 <tr class="tr1">
	   <td align="left"> طرف قرارداد (فروشنده) :&nbsp;</td>
	   <td align="right"><input type="text" class="textboxme2" name="code_skk" value="'.$code_skk.'" onkeypress="return isNumber(event)" onfocus="getShomareSafar(this.value)" onchange="getShomareSafar(this.value)"/>
	    <input type="hidden" name="name_skk" value="name_skk"/>';
	    include("img_helpcoding_mali.php");
	    echo'
	   <td align="left" height="40px"> شماره دستورالعمل :&nbsp; </td>
	   <td align="right"><input type="text" class="textboxme2" name="shomare_dastorolamal" value="'.$shomare_dastorolamal.'" /></td>
	  </tr>
	  <tr class="tr1">
	   <td align="left" height="40px"> گروه کالا :&nbsp;</td><td align="right">'.listbox("code_group_kala_top",$code_group_kala_top,"code_group_kala_top","name_group_kala_top","bzacc.group_kala_top","group_type_top=2","onchange=getKalaFromGroup(this.value) class='easyui-combobox text4'").'</td>
	   <td align="left"> نوع خط :&nbsp;</td><td align="right">'.static_listbox("noe_khat",$noe_khat,"noeKhatArr",1,"class='easyui-combobox text4' data-options=panelHeight:125").'</td>	  
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
          while($row_ostan=$db->fetch_assoc($result_ostan)) $ostan_options .= "<option value=".$row_ostan['code_ostan'].">".$row_ostan['name_ostan']."</option>";
	      echo $ostan_options;
	      echo'
	      </select>
	     </td>';
	   }
	   echo'
	 </tr>
	 <tr class="tr1">
	  <td align="left" height="40px"> کالا :&nbsp;</td><td align="right" colspan="3">
	   <select name="kalachoice[]" class="easyui-combobox" size="6" style="width:250px;" multiple>';
	   $result_kala = $db->query("SELECT * FROM kala ORDER BY name_kala");
       $kala_options = "<option value='-1' selected>همه کالاها</option>";
       while($row_kala=$db->fetch_assoc($result_kala)) $kala_options .= "<option value=".$row_kala['code_kala'].">".$row_kala['name_kala']." (".$row_kala['code_kala'].")</option>";
	   echo $kala_options;
	   echo'
	   </select>
	   <!--'.listbox("code_kala",$code_kala,"code_kala","name_kala","kala","","class='easyui-combobox text4' style=width:250px").'-->
	  </td>
	 </tr> 
	 <tr class="tr1">
	  <td align="left" height="40px"> نوع محموله :&nbsp;</td><td align="right">'.static_listbox("mahmule_type",$mahmule_type,"mahmuletypeArr",1,"class='easyui-combobox text4' data-options=panelHeight:125").'</td>
	  <td align="left"> نوع گوشت : &nbsp;</td><td align="right">'.static_listbox("gosht_type",$gosht_type,"goshttypeArr",1,"class='text4'").'</td>
	 </tr>
	 <tr class="tr1">
	  <td align="left" > تعداد استان در صفحه :&nbsp;</td><td align="right" colspan="3"><input type="number" class="textboxme2" name="MaxLines" value="'.$MaxLines.'"  onkeypress="return isNumber(event)"/></td>	
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
    if($shomare_eblagh) $Condition.=" AND shomare_eblagh='$shomare_eblagh' ";
    if($shomare_gharardad) $Condition.=" AND T.shomare_gharardad='$shomare_gharardad' ";
    if($code_group_kala_top) $Condition.=" AND eblagh_kharid.code_group_kala_top LIKE '$code_group_kala_top'";
    if($shomare_dastorolamal) $Condition.=" AND d_kh.shomare_dastorolamal LIKE '%$shomare_dastorolamal%'";
    if($noe_khat) $Condition.=" AND T.noe_khat LIKE '$noe_khat'";
    if($mahmule_type) $Condition.=" AND eblagh_kharid.mahmule_type LIKE '$mahmule_type'";
    if($gosht_type) $Condition.=" AND eblagh_kharid.gosht_type LIKE '$gosht_type'";
	if($code_skk) $Condition.=" AND T.code_skk='$code_skk'";//کد فروشنده /کشتی
    if($date1) $Condition_date.=" AND T.tarikh_gharardad>='$date1'";
    if($date2) $Condition_date.=" AND T.tarikh_gharardad<='$date2'";
	if($date_eblagh1) $Condition_date.=" AND eblagh_kharid.tarikh_eblagh>='$date_eblagh1'";
    if($date_eblagh2) $Condition_date.=" AND eblagh_kharid.tarikh_eblagh<='$date_eblagh2'";
    if($date_resid1) $Condition_date_resid.=" AND r.tarikh_resid>='$date_resid1'";
    if($date_resid2) $Condition_date_resid.=" AND r.tarikh_resid<='$date_resid2'";
	
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
	$q_ostan="SELECT distinct(ostan.code_ostan),ostan.name_ostan 
	    From gharardad_kharid T 
		INNER JOIN sahmiebandy_kharid s_kh ON T.id_sahmiebandy=s_kh.id_sahmiebandy
		INNER JOIN eblagh_kharid ON s_kh.id_eblagh=eblagh_kharid.id_eblagh
		INNER JOIN dastorolamal_kharid d_kh ON d_kh.id_dastorolamal=T.id_dastorolamal
		INNER JOIN ostan ON ostan.code_ostan=s_kh.code_ostan
	    INNER JOIN bzacc.group_kala_top ON group_kala_top.code_group_kala_top=eblagh_kharid.code_group_kala_top
		WHERE T.deleted=0 AND($Condition_ostan) AND($Condition_kala) $Condition $Condition_date ORDER By name_ostan,tarikh_eblagh,T.tarikh_gharardad,T.shomare_gharardad";
	$res_ostan=$db->query($q_ostan);
    $cntr =mysql_num_rows($res_ostan);
	if(mysql_num_rows($res_ostan)>0)//وجود داشتن
	{
	 // echo'
	   // <table class="hideatprint" width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">   
      	// <tr class="print_table-title2 "><td colspan="30">وضعیت نمایش ستونها در گزارش</td></tr>
		// <tr class="print_table-title2 select_all">
		 // <td width="5%" >استان</td>
		 // <td width="5%" >گروه کالا</td>
		 // <td width="5%" >کالا</td>
		 // <td width="5%" >شماره ابلاغ</td>
		 // <td width="5%" >تاریخ ابلاغ</td>
		 // <td width="5%" >نوع محموله</td>
		 // <td width="5%" >شماره دستورالعمل</td>
		 // <td width="5%" >تاریخ دستورالعمل</td>
		 // <td width="5%" >میزان خرید</td>
		 // <!--<td width="5%" >نام کالا</td>
		     // <td width="5%" >قیمت خرید</td>-->
		 // <td width="5%" >میزان سهمیه</td>
		 // <td width="5%" >نام فروشنده</td>
		 // <td width="5%" >شماره قرارداد</td>
		 // <td width="5%" >تاریخ قرارداد</td>
		 // <td width="5%" >مقدار قرارداد</td>
		 // <td width="5%" >مازاد بر قرارداد</td>
		 // <!--<td width="5%" >تحویلی قبل از تاریخ</td>-->
		 // <td width="5%" >تحویلی</td>
		 // <td width="5%" >مانده از قرارداد</td>
		 // <!--<td width="10%" >مانده از قرارداد (بدون احتساب مازاد)</td>-->
         // <td width="5%" >وضعیت</td>
         // <td width="5%" >قیمت هر کیلو/عدد</td>
         // <td width="5%" >مبلغ کل قرارداد</td>
         // <td width="5%" >مبلغ کل تحویلی</td>
	    // </tr>   	
		// <tr class="print_table-title2">
	     // <td><input name="ostanPr" class="count_sum" type="checkbox" checked ></td>
	     // <td><input name="grkalaPr" class="count_sum" type="checkbox" checked ></td>
	     // <td><input name="kalaPr" class="count_sum" type="checkbox" checked ></td>
	     // <td><input name="shEblaghPr" class="count_sum" type="checkbox" checked ></td>
	     // <td><input name="dateEblaghPr" class="count_sum" type="checkbox" checked ></td>
	     // <td><input name="mahmule_typePr" class="count_sum" type="checkbox" checked ></td>
	     // <td><input name="shDastPr" class="count_sum" type="checkbox" checked ></td>
	     // <td><input name="dateDastPr" class="count_sum" type="checkbox" checked ></td>
	     // <td><input name="meghdarKhPr" class="count_sum" type="checkbox" checked ></td>
	     // <!--<td><input name="namekalaPr" class="count_sum" type="checkbox" checked ></td>
	         // <td><input name="gheymatPr" class="count_sum" type="checkbox" checked ></td>-->
	     // <td><input name="sahmiePr" class="count_sum" type="checkbox" checked ></td>
	     // <td><input name="skkPr" class="count_sum" type="checkbox" checked ></td>
		 // <td><input name="shghPr" class="count_sum" type="checkbox" checked ></td>
	     // <td><input name="dateghPr" class="count_sum" type="checkbox" checked ></td>
	     // <td><input name="meghdarPr" class="count_sum" type="checkbox" checked ></td>
		 // <td><input name="mazadPr"  type="checkbox" checked></td>
	     // <!--<td><input name="tahvilybefPr" type="checkbox"  checked></td>-->
	     // <td><input name="tahvilyPr" type="checkbox"  checked></td>
	     // <td><input name="mandePr" type="checkbox" checked ></td>
	     // <!--<td><input name="mande2Pr" type="checkbox" checked ></td>-->
		 // <td><input name="statusPr" type="checkbox" checked ></td>
		 // <td><input name="gheymat_har_kiloPr" type="checkbox" checked ></td>
		 // <td><input name="mablagh_kolPr" type="checkbox" checked ></td>
		 // <td><input name="mablagh_tahvilPr" type="checkbox" checked ></td>
	    // </tr>	
     // </table>
	 echo'
	 <div class="table2excel">';
	 print_header();
	 /*سطر نمایش فیلترها*/
	 if($date_eblagh1) $filter_string.=' از تاریخ ابلاغ : '.$date_eblagh1.'&nbsp;';
	 if($date_eblagh2) $filter_string.=' تا تاریخ ابلاغ : '.$date_eblagh2.'&nbsp;';
	 if(is_array($ostanchoice))
     {
	  if($ostan_val==-1)$filter_string.='همه استانها';
	  else $filter_string=' استان : ';
	  foreach($ostanchoice as $key => $ostan_val) {
	   $nameOstan=$db->get_from_where("name_ostan","ostan","code_ostan='$ostan_val'");
	   $filter_string.=''.$nameOstan.'&nbsp;-';
      }
     }
	 if(is_array($kalachoice))
     {
      if($kala_val==-1)$filter_string.='همه کالاها';
      else $filter_string.=' کالا : ';
      foreach($kalachoice as $key_kala => $kala_val) {
      $nameKala=$db->get_from_where("name_kala","kala","code_kala='$kala_val'");
      $filter_string.=''.$nameKala.'&nbsp;-';
         }
     }	 
	 if($shomare_eblagh) $filter_string.=' شماره ابلاغ : '.$shomare_eblagh.'&nbsp;';
	 if($shomare_gharardad) $filter_string.=' شماره قرارداد : '.$shomare_gharardad.'&nbsp;';
	 if($shomare_dastorolamal) $filter_string.=' شماره دستورالعمل : '.$shomare_dastorolamal.'&nbsp;';
	 if($code_skk) $filter_string.=' کد مشتری : '.$code_skk.'&nbsp;';
	 if($code_group_kala_top){
	   $nameGroupKala=$db->get_from_where("name_group_kala_top","bzacc.group_kala_top","code_group_kala_top='$code_group_kala_top'");
	   $filter_string.=' گروه کالا : '.$nameGroupKala.'&nbsp;'; 
	 }	 
	 if($noe_khat)   $filter_string.=' نوع خط : '.$noeKhatArr[$noe_khat].'&nbsp;';
	 if($mahmule_type)   $filter_string.=' نوع محموله : '.$mahmuletypeArr[$mahmule_type].'&nbsp;';
	 if($gosht_type)   $filter_string.=' نوع گوشت : '.$goshttypeArr[$gosht_type].'&nbsp;';
	 IF($date_eblagh1) $filter_string.=' از تاریخ ابلاغ '.$date_eblagh1.'  ';
	 IF($date_eblagh2) $filter_string.=' تا تاریخ ابلاغ '.$date_eblagh2.' ';
	 IF($date_resid1) $filter_string.=' از تاریخ رسید '.$date_resid1.'  ';
	 IF($date_resid2) $filter_string.=' تا تاریخ رسید '.$date_resid2.' ';
	 
	 echo'<tr class="noExl"><td class="filter_text" colspan="40">فیلتر شده براساس : '.$filter_string.'</td></tr>';
	 echo $columns;
	 while($row_ostan=$db->fetch_assoc($res_ostan))
     {
	  $line++;
	  $exist_morgh=0;
	  $exist_gosht=0;
	  //if($i++%2)
		  //echo'<tr class="print_table-odd">';
      //else echo'<tr class="print_table-even">';
	  $tedad=$db->get_from_where("COUNT(*)",
              "gharardad_kharid T 
		       INNER JOIN sahmiebandy_kharid s_kh ON T.id_sahmiebandy=s_kh.id_sahmiebandy
		       INNER JOIN eblagh_kharid ON s_kh.id_eblagh=eblagh_kharid.id_eblagh
		       INNER JOIN dastorolamal_kharid d_kh ON d_kh.id_dastorolamal=T.id_dastorolamal
		       INNER JOIN ostan ON ostan.code_ostan=s_kh.code_ostan
	           INNER JOIN bzacc.group_kala_top ON group_kala_top.code_group_kala_top=eblagh_kharid.code_group_kala_top",
			  "T.code_ostan=".$row_ostan['code_ostan']." AND T.deleted=0 AND($Condition_kala) $Condition $Condition_date");		
	  $rowanbar=$tedad;
	  $t=$rowanbar;
	  
	  // echo'   
		 // <td rowspan="'.$rowanbar.'">'.$radif++.'</td>
	     // <td class="ostanPr" rowspan="'.$rowanbar.'" >'.$row_ostan['name_ostan'].'</td>'; 
     	
		//اگر کالا وقیمت خرید را بخواهند
     	// $q="SELECT T.*,shomare_eblagh,tarikh_eblagh,meghdar_kharid_keshvar,gheymat_kharid,s_kh.max_kharid_ostan,kala.name_kala,kala.code_bastebandy,name_group_kala_top,d_kh.shomare_dastorolamal,tarikh_dastorolamal,mt_skk.name_skk,ostan.name_ostan
     	    // From gharardad_kharid T 
     		// INNER JOIN sahmiebandy_kharid s_kh ON T.id_sahmiebandy=s_kh.id_sahmiebandy
     		// INNER JOIN eblagh_kharid ON s_kh.id_eblagh=eblagh_kharid.id_eblagh
     		// INNER JOIN dastorolamal_kharid d_kh ON d_kh.id_dastorolamal=T.id_dastorolamal
     		// INNER JOIN gheymat_kharid gh_kh ON d_kh.id_dastorolamal=gh_kh.id_dastorolamal
     		// INNER JOIN mt_skk ON mt_skk.code_skk=T.code_skk
     		// INNER JOIN ostan ON ostan.code_ostan=s_kh.code_ostan
     		// LEFT JOIN kala ON kala.code_kala=gh_kh.code_kala
     	    // LEFT JOIN bzacc.group_kala_top ON group_kala_top.code_group_kala_top=eblagh_kharid.code_group_kala_top
     		// WHERE T.deleted=0 AND T.tarikh_gharardad BETWEEN '$date1' AND '$date2' AND($Condition_ostan) $Condition ORDER By name_ostan,T.shomare_gharardad,T.tarikh_gharardad";
     	
		//در قراردادهای وارداتی کد کالا نداریم
     	$q="SELECT T.*,shomare_eblagh,tarikh_eblagh,eblagh_kharid.mahmule_type,meghdar_kharid_keshvar,s_kh.max_kharid_ostan,eblagh_kharid.code_group_kala_top,name_group_kala_top,name_kala,d_kh.shomare_dastorolamal,tarikh_dastorolamal,mt_skk.name_skk,ostan.name_ostan
     	    From gharardad_kharid T 
     		INNER JOIN sahmiebandy_kharid s_kh ON T.id_sahmiebandy=s_kh.id_sahmiebandy
     		INNER JOIN eblagh_kharid ON s_kh.id_eblagh=eblagh_kharid.id_eblagh
     		INNER JOIN dastorolamal_kharid d_kh ON d_kh.id_dastorolamal=T.id_dastorolamal
     		INNER JOIN mt_skk ON mt_skk.code_skk=T.code_skk
     		INNER JOIN ostan ON ostan.code_ostan=s_kh.code_ostan
     	    INNER JOIN bzacc.group_kala_top ON group_kala_top.code_group_kala_top=eblagh_kharid.code_group_kala_top
     		LEFT JOIN  kala ON kala.code_kala=T.code_kala
     		WHERE T.code_ostan=".$row_ostan['code_ostan']." AND T.deleted=0 AND($Condition_kala) $Condition $Condition_date ORDER By name_ostan,tarikh_eblagh,T.tarikh_gharardad,T.shomare_gharardad";
        //echo $q;
	    $jame_ostan_meghdar_gharardad_morgh_dakheli=0;
	    $jame_ostan_mazad_gharardad_morgh_dakheli=0;
	    $jame_ostan_tahvily_gharardad_befor_morgh_dakheli=0;
	    $jame_ostan_tahvily_nakhales_morgh_dakheli=0;
		$jame_ostan_tahvily_gharardad_morgh_dakheli=0;
	    $jame_ostan_mande_gharardad_morgh_dakheli=0;
	    $jame_ostan_mande_gharardad_without_mazad_morgh_dakheli=0;
		$jame_ostan_mablagh_tahvil_morgh_dakheli=0;
	    $jame_ostan_meghdar_gharardad_gosht_dakheli=0;
	    $jame_ostan_mazad_gharardad_gosht_dakheli=0;
	    $jame_ostan_tahvily_gharardad_befor_gosht_dakheli=0;
	    $jame_ostan_tahvily_nakhales_gosht_dakheli=0;
		$jame_ostan_tahvily_gharardad_gosht_dakheli=0;
	    $jame_ostan_mande_gharardad_gosht_dakheli=0;
	    $jame_ostan_mande_gharardad_without_mazad_gosht_dakheli=0;
		$jame_ostan_mablagh_tahvil_gosht_dakheli=0;
		
	    $jame_ostan_meghdar_gharardad_morgh_varedati=0;
	    $jame_ostan_mazad_gharardad_morgh_varedati=0;
	    $jame_ostan_tahvily_gharardad_befor_morgh_varedati=0;
	    $jame_ostan_tahvily_nakhales_morgh_varedati=0;
		$jame_ostan_tahvily_gharardad_morgh_varedati=0;
	    $jame_ostan_mande_gharardad_morgh_varedati=0;
	    $jame_ostan_mande_gharardad_without_mazad_morgh_varedati=0;
		$jame_ostan_mablagh_tahvil_morgh_varedati=0;
	    $jame_ostan_meghdar_gharardad_gosht_varedati=0;
	    $jame_ostan_mazad_gharardad_gosht_varedati=0;
	    $jame_ostan_tahvily_gharardad_befor_gosht_varedati=0;
	    $jame_ostan_tahvily_nakhales_gosht_varedati=0;
		$jame_ostan_tahvily_gharardad_gosht_varedati=0;
	    $jame_ostan_mande_gharardad_gosht_varedati=0;
	    $jame_ostan_mande_gharardad_without_mazad_gosht_varedati=0;
		$jame_ostan_mablagh_tahvil_gosht_varedati=0;
		
     	$res=$db->query($q);
		while($row=$db->fetch_assoc($res))
		{
		 $j=$i+1;
		
	  
		 IF($date_resid1)$sum_tahvily_gharardad_befor=$db->get_from_where("SUM(vazn_khales_r_d_sub)","meat.resid_kala_detail r_k_d INNER JOIN meat.resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","r.id_safar=(SELECT id_safar FROM shomare_safar WHERE shomare_safar='".$row['shomare_gharardad']."') AND (r.noe_tahvil_bar=1 OR r.noe_tahvil_bar=2 OR r.noe_tahvil_bar=3) AND r_k_d.code_ostan=".$row['code_ostan']." AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.status=0 AND r.tarikh_resid<'$date_resid1'");
	     ELSE            $sum_tahvily_gharardad_befor=$db->get_from_where("SUM(vazn_khales_r_d_sub)","meat.resid_kala_detail r_k_d INNER JOIN meat.resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","r.id_safar=(SELECT id_safar FROM shomare_safar WHERE shomare_safar='".$row['shomare_gharardad']."') AND (r.noe_tahvil_bar=1 OR r.noe_tahvil_bar=2 OR r.noe_tahvil_bar=3) AND r_k_d.code_ostan=".$row['code_ostan']." AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.status=0 AND r.tarikh_resid<'$date1'");
	     
		 $sum_tahvily_gharardad=$db->get_from_where("SUM(vazn_khales_r_d_sub)","meat.resid_kala_detail r_k_d INNER JOIN meat.resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","r.id_safar=(SELECT id_safar FROM shomare_safar WHERE shomare_safar='".$row['shomare_gharardad']."') AND (r.noe_tahvil_bar=1 OR r.noe_tahvil_bar=2 OR r.noe_tahvil_bar=3) AND r_k_d.code_ostan=".$row['code_ostan']." AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.status=0 $Condition_date_resid");
	     $sum_tahvily_nakhales=$db->get_from_where("SUM(vazn_nakhales_r_d_sub)","meat.resid_kala_detail r_k_d INNER JOIN meat.resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year","r.id_safar=(SELECT id_safar FROM shomare_safar WHERE shomare_safar='".$row['shomare_gharardad']."') AND (r.noe_tahvil_bar=1 OR r.noe_tahvil_bar=2 OR r.noe_tahvil_bar=3) AND r_k_d.code_ostan=".$row['code_ostan']." AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.status=0 $Condition_date_resid");
	    //}
	    if($sum_tahvily_gharardad=='')$sum_tahvily_gharardad=0;
	    $sum_tahvily_gharardad=round($sum_tahvily_gharardad,3);
	    //مانده قرارداد
	    $mande_tahvily_gharardad=$row['meghdar_gharardad']+$row['mazad_gharardad']-$sum_tahvily_gharardad_befor-$sum_tahvily_gharardad;
	    $mande_tahvily_gharardad_without_mazad=$row['meghdar_gharardad']-$sum_tahvily_gharardad_befor-$sum_tahvily_gharardad;
	    //echo "select SUM(vazn_khales_r_d_sub) from meat.resid_kala_detail r_k_d INNER JOIN meat.resid r ON r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year where r.id_safar=(SELECT id_safar FROM shomare_safar WHERE shomare_safar='".$row['shomare_gharardad']."') AND r.noe_tahvil_bar!=4 AND r.noe_tahvil_bar!=5 AND r.noe_tahvil_bar!=6 AND r_k_d.year='$mtActiveYear' AND r_k_d.code_ostan=".$row['code_ostan']." AND r_k_d.resid_deleted=0 AND r_k_d.status=0 AND r.status=0 $Condition_date";
	   	$mablagh_kol=compute_gheymat_gharardad($row['id_gharardad'],$db);
	    
		//1401/03/23 add to report
		//نمیدونم درست هست یا نه
		$mablagh_tahvil=$sum_tahvily_gharardad*$row['gheymat_har_kilo'];
	   // echo'  
		// <td class="grkalaPr">'.$row['name_group_kala_top'].'</td>
		// <td class="kalaPr">'.$row['name_kala'].'</td>
		// <td class="shEblaghPr">'.$row['shomare_eblagh'].'</td>
		// <td class="dateEblaghPr">'.$row['tarikh_eblagh'].'</td>
		// <td class="mahmule_typePr">'.$mahmuletypeArr[$row['mahmule_type']].'</td>
		// <td class="shDastPr">'.$row['shomare_dastorolamal'].'</td>
		// <td class="dateDastPr">'.$row['tarikh_dastorolamal'].'</td>
		// <td class="meghdarKhPr">'.virgul($row['meghdar_kharid_keshvar']).'</td>
		// <!--<td class="namekalaPr">'.$row['name_kala'].'</td>
		    // <td class="gheymatPr">'.virgul($row['gheymat_kharid']).'</td>-->
		// <td class="sahmiePr">'.$row['max_kharid_ostan'].'</td>
		// <td class="skkPr">'.$row['name_skk'].'</td>
	    // <td class="shghPr">'.$row['shomare_gharardad'].'</td>
	    // <td class="dateghPr">'.$row['tarikh_gharardad'].'</td>
	    // <td class="meghdarPr">'.round($row['meghdar_gharardad'],3).'</td>
	    // <td class="mazadPr">'.round($row['mazad_gharardad'],3).'</td>
	    // <!--<td class="tahvilybefPr">'.round($sum_tahvily_gharardad_befor,3).'</td>-->
	    // <td class="tahvilyPr">'.round($sum_tahvily_nakhales,3).'</td>
		// <td class="tahvilyPr">'.round($sum_tahvily_gharardad,3).'</td>
		// <td class="mandePr">'.round($mande_tahvily_gharardad,3).'</td>
		// <!--<td class="mande2Pr">'.round($mande_tahvily_gharardad_without_mazad,3).'</td>--> 
		// <td class="statusPr">';IF($row['termination']==1)echo 'جاری';ELSE echo 'بسته شده';echo'</td>
		// <td class="gheymat_har_kiloPr">'.($row['gheymat_har_kilo']).'</td>
		// <td class="mablagh_kolPr">'.virgul($mablagh_kol).'</td>
		// <td class="mablagh_tahvilPr">'.virgul($mablagh_tahvil).'</td>
		// ';
	     
		 // $t--;
	     // if($t==0) echo'';
		 // else 
		 // {
			 // echo'</tr>';
			 // if($j++%2)echo'<tr class="print_table-odd">';
             // else echo'<tr class="print_table-even">';
		 // }
		 
		 //جمع استانی
		 IF($row['code_group_kala_top']==4)//مرغ
		 {
		  $exist_morgh=1;
		  IF(($row['mahmule_type']==1)OR($row['mahmule_type']==4))//داخلی
		  {
		   $jame_ostan_meghdar_gharardad_morgh_dakheli+=$row['meghdar_gharardad'];
	       $jame_ostan_mazad_gharardad_morgh_dakheli+=$row['mazad_gharardad'];
	       $jame_ostan_tahvily_gharardad_befor_morgh_dakheli+=$sum_tahvily_gharardad_befor;
	       $jame_ostan_tahvily_nakhales_morgh_dakheli+=$sum_tahvily_nakhales;
		   $jame_ostan_tahvily_gharardad_morgh_dakheli+=$sum_tahvily_gharardad;
	       $jame_ostan_mande_gharardad_morgh_dakheli+=$mande_tahvily_gharardad;
	       $jame_ostan_mande_gharardad_without_mazad_morgh_dakheli+=$mande_tahvily_gharardad_without_mazad; 
	       $jame_ostan_mablagh_tahvil_morgh_dakheli+=$mablagh_tahvil;
		  }
		  ELSE IF(($row['mahmule_type']==2)OR($row['mahmule_type']==3))//وارداتی
		  {
		   $jame_ostan_meghdar_gharardad_morgh_varedati+=$row['meghdar_gharardad'];
	       $jame_ostan_mazad_gharardad_morgh_varedati+=$row['mazad_gharardad'];
	       $jame_ostan_tahvily_gharardad_befor_morgh_varedati+=$sum_tahvily_gharardad_befor;
	       $jame_ostan_tahvily_nakhales_morgh_varedati+=$sum_tahvily_nakhales;
		   $jame_ostan_tahvily_gharardad_morgh_varedati+=$sum_tahvily_gharardad;
	       $jame_ostan_mande_gharardad_morgh_varedati+=$mande_tahvily_gharardad;
	       $jame_ostan_mande_gharardad_without_mazad_morgh_varedati+=$mande_tahvily_gharardad_without_mazad; 
	       $jame_ostan_mablagh_tahvil_morgh_varedati+=$mablagh_tahvil;
		  }		  
		 }
		 IF($row['code_group_kala_top']==5)//گوشت
		 {
		  $exist_gosht=1;
		  IF(($row['mahmule_type']==1)OR($row['mahmule_type']==4))//داخلی
		  {
		   $jame_ostan_meghdar_gharardad_gosht_dakheli+=$row['meghdar_gharardad'];
	       $jame_ostan_mazad_gharardad_gosht_dakheli+=$row['mazad_gharardad'];
	       $jame_ostan_tahvily_gharardad_befor_gosht_dakheli+=$sum_tahvily_gharardad_befor;
	       $jame_ostan_tahvily_nakhales_gosht_dakheli+=$sum_tahvily_nakhales;
		   $jame_ostan_tahvily_gharardad_gosht_dakheli+=$sum_tahvily_gharardad;
	       $jame_ostan_mande_gharardad_gosht_dakheli+=$mande_tahvily_gharardad;
	       $jame_ostan_mande_gharardad_without_mazad_gosht_dakheli+=$mande_tahvily_gharardad_without_mazad;
           $jame_ostan_mablagh_tahvil_gosht_dakheli+=$mablagh_tahvil;
		  }		   
		  ELSE IF(($row['mahmule_type']==2)OR($row['mahmule_type']==3))//وارداتی
		  {
		   $jame_ostan_meghdar_gharardad_gosht_varedati+=$row['meghdar_gharardad'];
	       $jame_ostan_mazad_gharardad_gosht_varedati+=$row['mazad_gharardad'];
	       $jame_ostan_tahvily_gharardad_befor_gosht_varedati+=$sum_tahvily_gharardad_befor;
	       $jame_ostan_tahvily_nakhales_gosht_varedati+=$sum_tahvily_nakhales;
		   $jame_ostan_tahvily_gharardad_gosht_varedati+=$sum_tahvily_gharardad;
	       $jame_ostan_mande_gharardad_gosht_varedati+=$mande_tahvily_gharardad;
	       $jame_ostan_mande_gharardad_without_mazad_gosht_varedati+=$mande_tahvily_gharardad_without_mazad;
           $jame_ostan_mablagh_tahvil_gosht_varedati+=$mablagh_tahvil;
		  }		   
		 }
	     if($row['code_bastebandy']==2) $vahed='(تعداد)';
	     else $vahed='(کیلوگرم)';
	     /****************محاسبه مجموع مقادیر در سطر آخر*******************/
	     IF(($row['mahmule_type']==1)OR($row['mahmule_type']==4))//داخلی
		 {
		  $jame_meghdar_gharardad_dakheli+=$row['meghdar_gharardad'];
	      $jame_mazad_gharardad_dakheli+=$row['mazad_gharardad'];
	      $jame_tahvily_gharardad_befor_dakheli+=$sum_tahvily_gharardad_befor;
	      $jame_tahvily_nakhales_dakheli+=$sum_tahvily_nakhales;
		  $jame_tahvily_gharardad_dakheli+=$sum_tahvily_gharardad;
	      $jame_mande_gharardad_dakheli+=$mande_tahvily_gharardad;
	      $jame_mande_gharardad_without_mazad_dakheli+=$mande_tahvily_gharardad_without_mazad;
		  $jame_ostan_mablagh_tahvil_dakheli+=$mablagh_tahvil;
		 }
		 ELSE IF(($row['mahmule_type']==2)OR($row['mahmule_type']==3))//وارداتی
		 {
		  $jame_meghdar_gharardad_varedati+=$row['meghdar_gharardad'];
	      $jame_mazad_gharardad_varedati+=$row['mazad_gharardad'];
	      $jame_tahvily_gharardad_befor_varedati+=$sum_tahvily_gharardad_befor;
	      $jame_tahvily_nakhales_varedati+=$sum_tahvily_nakhales;
		  $jame_tahvily_gharardad_varedati+=$sum_tahvily_gharardad;
	      $jame_mande_gharardad_varedati+=$mande_tahvily_gharardad;
	      $jame_mande_gharardad_without_mazad_varedati+=$mande_tahvily_gharardad_without_mazad;
		  $jame_ostan_mablagh_tahvil_varedati+=$mablagh_tahvil;
		 }
		 
		}//END gharardad while
		
		// echo'
	   // </tr>';
	  
	  IF($exist_morgh==1)//مرغ
	  {
	     if($i++%2)
		 echo'<tr class="print_table-odd">';
         else echo'<tr class="print_table-even">';
	     echo'
	      <td >'.$radif++.'</td>
	      <td >'.$row_ostan['name_ostan'].'</td>
		  <td class="sum_row" colspan="1">مرغ</td>
	      <td class="meghdarPr">'.round($jame_ostan_meghdar_gharardad_morgh_dakheli,3).'</td>
	      <td class="meghdarPr">'.round($jame_ostan_meghdar_gharardad_morgh_varedati,3).'</td>
		  <td class="mazadPr">'.round($jame_ostan_mazad_gharardad_morgh_dakheli,3).'</td>
	      <td class="mazadPr">'.round($jame_ostan_mazad_gharardad_morgh_varedati,3).'</td>
		  <td class="tahvilyPr">'.round($jame_ostan_tahvily_nakhales_morgh_dakheli,3).'</td>
		  <td class="tahvilyPr">'.round($jame_ostan_tahvily_gharardad_morgh_dakheli,3).'</td>
		  <td class="tahvilyPr">'.round($jame_ostan_tahvily_nakhales_morgh_varedati,3).'</td>
	      <td class="tahvilyPr">'.round($jame_ostan_tahvily_gharardad_morgh_varedati,3).'</td>
		  <td class="mandePr">'.round($jame_ostan_mande_gharardad_morgh_dakheli,3).'</td>	 
	      <td class="mandePr">'.round($jame_ostan_mande_gharardad_morgh_varedati,3).'</td>	 
		  <td class="mablagh_tahvilPr">'.$jame_ostan_mablagh_tahvil_morgh_dakheli.'</td>
	      <td class="mablagh_tahvilPr">'.$jame_ostan_mablagh_tahvil_morgh_varedati.'</td>
	     </tr>';
	   	   
	  }
	  IF($exist_gosht==1)//گوشت
	  {
	    if($i++%2)
		echo'<tr class="print_table-odd">';
        else echo'<tr class="print_table-even">';
	    echo'
	    <td >'.$radif++.'</td>
	    <td >'.$row_ostan['name_ostan'].'</td>
		<td class="sum_row" colspan="1">گوشت '.$row['name_group_kala_top'].' </td>
	    <td class="meghdarPr">'.round($jame_ostan_meghdar_gharardad_gosht_dakheli,3).'</td>
	    <td class="meghdarPr">'.round($jame_ostan_meghdar_gharardad_gosht_varedati,3).'</td>
		<td class="mazadPr">'.round($jame_ostan_mazad_gharardad_gosht_dakheli,3).'</td>
	    <td class="mazadPr">'.round($jame_ostan_mazad_gharardad_gosht_varedati,3).'</td>
		<td class="tahvilyPr">'.round($jame_ostan_tahvily_nakhales_gosht_dakheli,3).'</td>
		<td class="tahvilyPr">'.round($jame_ostan_tahvily_gharardad_gosht_dakheli,3).'</td>
	    <td class="tahvilyPr">'.round($jame_ostan_tahvily_nakhales_gosht_varedati,3).'</td>
	    <td class="tahvilyPr">'.round($jame_ostan_tahvily_gharardad_gosht_varedati,3).'</td>
		<td class="mandePr">'.round($jame_ostan_mande_gharardad_gosht_dakheli,3).'</td>	    
	    <td class="mandePr">'.round($jame_ostan_mande_gharardad_gosht_varedati,3).'</td>	    
		<td class="mablagh_tahvilPr">'.$jame_ostan_mablagh_tahvil_gosht_dakheli.'</td>
	    <td class="mablagh_tahvilPr">'.$jame_ostan_mablagh_tahvil_gosht_varedati.'</td>
	   </tr>';  
	  }
	
     }//END while ostan
	 echo'
	  <tr class="print_table-even sum-row-white-b">
	   <td class="sum_row" colspan="3">جمع مقادیر '.$vahed.'</td>
	   <td class="meghdarPr">'.round($jame_meghdar_gharardad_dakheli,3).'</td>
	   <td class="meghdarPr">'.round($jame_meghdar_gharardad_varedati,3).'</td>
	   <td class="mazadPr">'.round($jame_mazad_gharardad_dakheli,3).'</td>
	   <td class="mazadPr">'.round($jame_mazad_gharardad_varedati,3).'</td>
	   <td class="tahvilyPr">'.round($jame_tahvily_nakhales_dakheli,3).'</td>
	   <td class="tahvilyPr">'.round($jame_tahvily_gharardad_dakheli,3).'</td>
	   <td class="tahvilyPr">'.round($jame_tahvily_nakhales_varedati,3).'</td>
	   <td class="tahvilyPr">'.round($jame_tahvily_gharardad_varedati,3).'</td>
	   <td class="mandePr">'.round($jame_mande_gharardad_dakheli,3).'</td>	 
	   <td class="mandePr">'.round($jame_mande_gharardad_varedati,3).'</td>	 
	   <td class="mablagh_tahvilPr">'.$jame_ostan_mablagh_tahvil_dakheli.'</td>
	   <td class="mablagh_tahvilPr">'.$jame_ostan_mablagh_tahvil_varedati.'</td>
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
//انتخاب تاریخ		
    $(".datepickerfrom").datepicker({
	    defaultDate:"<?php $today ?>",
		showOn: "button",
        buttonImage: "styles/images/calendar5.png",
        buttonImageOnly: true,
		showButtonPanel: true,
		changeMonth: true,
	    changeYear: true,
	  onSelect: function(dateText, inst){
	  $(".datepickerto").datepicker("option", "minDate", new JalaliDate(inst["selectedYear"], inst["selectedMonth"], inst["selectedDay"]));
	   }
	  });
	  $(".datepickerto").datepicker(
	  { 
	    defaultDate:"<?php $today ?>",
		showOn: "button",
        buttonImage: "styles/images/calendar5.png",
        buttonImageOnly: true,
		showButtonPanel: true,
		changeMonth: true,
	    changeYear: true
		}
	  );		
});
</script> 