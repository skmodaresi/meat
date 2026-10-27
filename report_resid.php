<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="report_resid.php";
$ExcelFileName=str_replace('.php','',$FileName);
$titr='گزارش براساس رسید سردخانه';
require_once('head.html');
$columns='	
      <tr class="print_table-title2">
	   <td width="2%" rowspan="2">ردیف</td>
	   <td width="5%" rowspan="2">شماره رسید</td>
	   <td width="5%" rowspan="2">تاریخ رسید</td>
	   <td width="5%" rowspan="2" class="noe_tahvilPr">نوع تحویل بار</td>
	   <td width="4%" rowspan="2" class="skkPr">فروشنده/کشتی</td>
	   <td width="5%" rowspan="2" class="ostan_mabdaPr">استان مبدأ</td>
	   <td width="5%" rowspan="2" class="mabdaPr">سردخانه مبدأ/مبدأ بارگیری</td>
	   <td width="3%" rowspan="2" class="takhliePr">نوع تخلیه</td>
	   <td width="5%" rowspan="2" class="peymankarPr">شرکت حمل کننده</td>
	   <td width="4%" rowspan="2" class="sh_barnamePr">شماره بارنامه</td>
	   <td width="4%" rowspan="2" class="date_barnamePr">تاریخ بارنامه</td>
	   <td width="4%" rowspan="2" class="pelakPr">پلاک خودرو</td>
	   <td width="3%" rowspan="2" class="sh_baskulPr">شماره باسکول</td> 
	   <td width="3%" rowspan="2" class="sh_sanadPr">شماره سند</td> 
	   <td width="3%" rowspan="2" class="sh_contPr">شماره کانتینر</td> 
	   <td width="3%" rowspan="2" class="statusPr">وضعیت</td>
	   <td width="5%" rowspan="2" class="vazn_mabdaPr">وزن مبدأ</td>
	   <td width="5%" colspan="3" class="vazn_maghsadPr">وزن مقصد</td>
	   <td width="5%" rowspan="2" class="kasry_kolPr">کل کسری</td>
	   <td width="5%" rowspan="2" class="kasry_gheyrPr">کسری غیرمجاز</td>
	   <td width="5%" rowspan="2" class="vazn_ezafePr">وزن اضافه</td>
	   <td width="5%" rowspan="2" class="mablagh_kerayePr">مبلغ کرایه مبدأ</td>
	   <td width="5%" rowspan="2" class="mablagh_jarimePr">مبلغ جریمه</td>
	   <td width="5%" rowspan="2" class="mablagh_pardakhtyPr">مبلغ پرداختی</td>
	   <td width="4%" rowspan="2" class="mojavezPr">شماره مجوز جابه جایی</td>
	  </tr>
	  <tr class="print_table-title2">
	   <td class="vazn_maghsadPr">تعداد</td>
	   <td class="vazn_maghsadPr">وزن ناخالص</td>
	   <td class="vazn_maghsadPr">وزن خالص</td>
	  </tr>';
Function print_header()
{global $titr,$columns,$mt_gl_owner,$mt_gl_name_anbar,$mt_gl_name_ostan,$date1,$date2,$FileName,$page;
 echo'
   <table width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">
    <tr class="noExl">
	 <td colspan="40">
      <table width="100%" align="center">
       <tr class="noExl"><td class="print_title_2">'.$mt_gl_owner.'</td></tr>
       <tr class="noExl"><td class="print_title_2"> سردخانه : '.$mt_gl_name_anbar.'&nbsp;&nbsp; استان : '.$mt_gl_name_ostan.'</td></tr> 
	   <tr class="noExl">
	    <td class="print_title_2">';
		IF($page==1){
			 echo'<a href="javascript:window.print();"><span style="float:right" id="printerReport" class="hideatprint" title="چاپ"></span></a>
			      <span style="float:right" id="exportExcel" title="خروجی اکسل" ></span>';
		 }
	     echo'
	     '.$titr.' از تاریخ : '.$date1.' تا تاریخ : '.$date2.'&nbsp&nbsp(صفحه : '.$page.')
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
<form method="post" name="myform" onkeydown="enterIE()">
    <img src="images/loading.gif" id="loading" class="loading_img"/>';
if(!$MaxLines)$MaxLines=10;
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
<table width="100%" align="center" cellpadding="0" cellspacing="0">
 <tr>
  <td height="100%">
   <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
     <td colspan="4" class="title">'.$titr.'</td>	 
    </tr>
	<tr class="tr1">	
     <td align="left" width="140px" height="40px"> از تاریخ :&nbsp;</td><td align="right"><input type="text" class="textboxme2" maxlength="10" name="date1" id="datepickerfrom"  placeholder="'.$date1.'"/></td>
     <td align="left" width="110px"> تا تاریخ :&nbsp;</td><td align="right"><input type="text" class="textboxme2" maxlength="10" name="date2" id="datepickerto"  placeholder="'.$date2.'"/></td>
	</tr>
    <tr class="tr1">';
	 //اضافه کردن صفر پشت کد استان		
	 if(strlen($mt_gl_code_ostan)==1) {$code_a=make_pattern($mt_gl_code_ostan,2);}
     else{$code_a=$mt_gl_code_ostan;}	
    echo'
	 <td align="left"> از شماره رسید :&nbsp;</td><td align="right"><input type="text" class="textboxme2" name="shomare1" value="'.$shomare1.'" onkeypress="return isNumber(event)" style="width:50px;"/>&nbsp;/&nbsp;<input type="text" class="textboxme" readonly value="'.$code_a.$mt_gl_code_anbar.'" name="ostan_anbar" style="width:50px;"/></td>
     <td align="left"> تا شماره رسید :&nbsp;</td><td align="right"><input type="text" class="textboxme2" name="shomare2" value="'.$shomare2.'" onkeypress="return isNumber(event)" style="width:50px;"/>&nbsp;/&nbsp;<input type="text" class="textboxme" readonly value="'.$code_a.$mt_gl_code_anbar.'" name="ostan_anbar" style="width:50px;"/></td>
	</tr>
	<tr class="tr1">
     <td align="left"> کد کالا :&nbsp;</td>
     <td align="right"><input type="text" class="textboxme2" name="code_kala" value="'.$code_kala.'" onkeypress="return isNumber(event)" onKeyUp="F10desc(event)" onblur="enterCodeKala(this.value)" style="width:50px;"/>&nbsp;';
	  include ("img_helpkala.php");
	 echo'</td>
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
     <td align="left"> سال تولید :&nbsp;</td><td align="right"><input class="textboxme2 textbox50" type="text" name="sal_tolid_shamsi" value="'.$sal_tolid_shamsi.'" maxlength="4" placeholder=" '.$mtActiveYear.'" onkeypress="return isNumber(event)"/>
	 <td align="left"> ماه تولید :&nbsp;</td><td align="right">'.static_listbox("mah_tolid_shamsi",$mah_tolid_shamsi,"mahshamsiArr",1,"class='easyui-combobox text4' style=width:100px").'
	</tr>
	<tr class="tr1">
	 <td align="left"> روز تولید :&nbsp;</td><td align="right"><input class="textboxme2 textbox50" type="text" name="rouz_tolid_shamsi" value="'.$rouz_tolid_shamsi.'" maxlength="2" onkeypress="return isNumber(event)"/></td>	
     <td align="left"> نام زیرانبار :&nbsp;</td><td align="right">'.listbox("code_ziranbar",$code_ziranbar,"code_ziranbar","name_ziranbar","list_sardkhane_detail","code_ostan=$mt_gl_code_ostan AND code_anbar=$mt_gl_code_anbar","class='easyui-combobox text4' style=width:100px","").'</td>
	</tr>
	<tr class="tr1">	
	 <td align="left"> کد فروشنده/کشتی :&nbsp;</td>
	 <td align="right"><input type="text" class="textboxme2" name="code_skk" value="'.$code_skk.'" onkeypress="return isNumber(event)" onfocus="getShomareSafar(this.value)" onchange="getShomareSafar(this.value)" style="width:50px;"/>
	 <input type="hidden" name="name_skk" value="name_skk"/>';
	 include("img_helpskk.php");
	echo'
	 <td align="left"> شماره قرارداد/سفر :&nbsp;</td><td align="right"><select class="text4" name="id_safar"><option value="0">انتخاب کنيد</option></select></td>
	</tr>
	<tr class="tr1">
	 <td align="left"> نوع بسته بندی :&nbsp;</td><td align="right">'.listbox("code_bastebandy",$code_bastebandy,"code_bastebandy","sharh_bastebandy","bastebandy","","class='easyui-combobox text4' style=width:100px ").'</td>
     <td align="left"> نوع تخلیه :&nbsp;</td><td align="right">'.listbox("code_takhlie",$code_takhlie,"code_takhlie","sharh_takhlie","takhlie","","class='easyui-combobox text4' style=width:100px  data-options=panelHeight:100","").'</td>
	</tr>		   
	<tr class="tr1">	
     <td align="left"> شرکت حمل کننده :&nbsp;</td><td align="right">'.listbox("code_peymankar_haml",$code_peymankar_haml,"code_peymankar_haml","name_peymankar_haml","peymankar_haml","","class='easyui-combobox text4'","").'</td>
     <td align="left"> وضعیت رسید :&nbsp;</td>
	 <td align="right">'.static_listbox("status","-1","statusFormArr",1,"class='easyui-combobox text4' style=width:100px  data-options=panelHeight:100").'</td>						 
    </tr>
	<tr class="tr1">	
	 <td align="left"> مبدأ بارگيری :&nbsp;</td><td align="right" >'.listbox("code_mabda",$code_mabda,"code_mabda","name_mabda","mabady_vorudy","1=1 ORDER BY name_mabda ASC","class='easyui-combobox text4'","").'</td>
	 <td align="left"> نوع تحویل بار :&nbsp;</td><td align="right" >'.static_listbox("noe_tahvil_bar",$noe_tahvil_bar,"tahvilbarArr",1,"class='text4'").'</td>
    </tr>
    <tr class="tr1">	
     <td align="left"> شماره بارنامه :&nbsp;</td><td align="right"><input type="text" class="textboxme2" name="barname_no" value="'.$barname_no.'"/></td>
     <td align="left"> تاریخ بارنامه :&nbsp;</td><td align="right"><input type="text" class="textboxme2" id="barname_tarikh" name="barname_tarikh" value="'.$barname_tarikh.'"/></td>
	</tr>
	<tr class="tr1">
	 <td align="left"> شماره کانتینر : </td><td align="right"><input type="text" class="textboxme2" name="shomare_container" value="'.$shomare_container.'"/></td>
	 <td align="left"> پلاک خودرو : </td>
	 <td align="right">&nbsp;
	 		   <sup>ایران</sup>
			   <input type="text" class="textboxme2" name="plak1" value="'.$plak1.'" onkeypress="return isNumber(event);" maxlength="2" placeholder="11" style="width:20px;"/> |
			   <input type="text" class="textboxme2" name="plak2" value="'.$plak2.'" onkeypress="return isNumber(event);" maxlength="3" placeholder="111" style="width:30px;"/>
			   <input type="text" class="textboxme2" name="plak3" value="'.$plak3.'" maxlength="1" placeholder="ع" style="width:20px;"/>
			   <input type="text" class="textboxme2" name="plak4" value="'.$plak4.'" onkeypress="return isNumber(event);" maxlength="2" placeholder="11" style="width:20px;"/>
	 </td>
	</tr>
	<tr class="tr1">
     <td align="left"> شماره باسکول :&nbsp;</td><td align="right"><input type="text" class="textboxme2"  name="bsk_no" value="'.$bsk_no.'"/></td>
     <td align="left"> شماره سند :&nbsp;</td><td align="right"><input type="text" class="textboxme2"  name="set_sanad" value="'.$set_sanad.'"/><input  type="text" class="textboxme2" readonly value="/97"  style="width:25px;" /></td>
	</tr>
    <tr class="tr1">	
	 <td align="left"> وزن مبدأ :&nbsp;</td><td align="right"><input type="text" class="textboxme2" name="vazn_mabda" onKeydown="return PressfloatOnly(event,this)" /></td>
	 <td align="left"> وزن مقصد :&nbsp;</td><td align="right">
	  <input type="text" class="textboxme2" name="tedad_k" onkeypress="return isNumber(event)" placeholder="تعداد" />
	  <input type="text" class="textboxme2" name="vazn_nkh" onKeydown="return PressfloatOnly(event,this)" placeholder="وزن ناخالص"/>
	  <input type="text" class="textboxme2" name="vazn_kh" onKeydown="return PressfloatOnly(event,this)" placeholder="وزن خالص"/></td>
	</tr>
    <tr class="tr1">	
	 <td align="left" height="40px"> تعداد خط در صفحه :&nbsp;</td><td align="right" colspan="3"><input type="text" class="textboxme2" name="MaxLines" value="'.$MaxLines.'" onkeypress="return isNumber(event)" /></td>
	</tr>
    <tr class="tr1 ostananbar" style="display:none;">
      <td align="left"> نام استان مبدأ :&nbsp;</td><td align="right">'.listbox("code_ostan_mabda",$code_ostan_mabda,"code_ostan","name_ostan","ostan","1=1 ORDER BY name_ostan ASC","onchange=getAnbareOstan(this.value) class='text4'","").'</td>
      <td align="left"> نام سردخانه مبدأ :&nbsp;</td><td align="right"><select name="code_anbar_mabda" id="anbar_mabda" class="text4"><option value="0">انتخاب کنيد</option></select></td>
    </tr>
	<tr class="tr1 ostananbar" style="display:none;">
      <td align="left" height="40px"> شماره مجوز جابه جایی : </td><td align="right" colspan="3">&nbsp;<input type="text" name="shomare_jabejae" value="'.$shomare_jabejae.'" /></td>
    </tr>	
    <tr class="footer" align="center"><td colspan="4" height="40px"><input class="buttonme" type="submit" name="ok" value="شروع گزارش"></td></tr>   
    
   </table>
  </td>
 </tr>
</table>';
}
else
{
    $Condition_resid="";

    /****************فیلترها روی گزارش******************/
    if ($date1) {$Condition_resid.=" and r.tarikh_resid>='$date1'";//از تاریخ
	            }
    if ($date2) {$Condition_resid.=" and r.tarikh_resid<='$date2'";//تا تاریخ 
                }				 
    if ($shomare1)//از شماره رسید
    {
  	 if(strlen($shomare1)!=5) $shomare1=make_pattern($shomare1,5);
     $Condition_resid.=" and r.shomare_resid>='$shomare1'";      
    }
    if ($shomare2)//تا شماره رسید
    {
     if(strlen($shomare2)!=5) $shomare2=make_pattern($shomare2,5);
	 $Condition_resid.=" and r.shomare_resid<='$shomare2'";
    }
    if ($code_kala)//کد کالا  
	{$Condition_r_k_d.=" and r_k_d.code_kala='$code_kala'";   
     $Condition_r_d.=" and r_d.code_kala='$code_kala'";
    }    
    if ($code_keshvar)	//کد کشور 
	{$Condition_r_k_d.=" and r_k_d.code_keshvar='$code_keshvar'";
	 $Condition_r_d.=" and r_d.code_keshvar='$code_keshvar'";
	}
    if ($code_tolidkonande)//کد تولیدکننده  
	{$Condition_r_k_d.=" and r_k_d.code_tolidkonande='$code_tolidkonande'";    
	 $Condition_r_d.=" and r_d.code_tolidkonande='$code_tolidkonande'";
	} 
    if ($code_karton) $Condition_r_k_d.=" and r_k_d.code_karton='$code_karton'";//کد کارتن     
    if ($sal_tolid_shamsi) $Condition_r_k_d.=" and r_k_d.sal_tolid_shamsi='$sal_tolid_shamsi'";//سال تولید شمسی 
    if ($mah_tolid_shamsi) $Condition_r_k_d.=" and r_k_d.mah_tolid_shamsi='$mah_tolid_shamsi'";//ماه تولید شمسی 
    if ($rouz_tolid_shamsi) $Condition_r_k_d.=" and r_k_d.rouz_tolid_shamsi='$rouz_tolid_shamsi'";//روز تولید شمسی 
    if ($code_ziranbar) $Condition_r_k_d.=" and r_k_d.code_ziranbar='$code_ziranbar'";//زیرانبار 
    if ($code_skk) $Condition_resid.=" and r.code_skk='$code_skk'";//کد کشتی 
	if ($id_safar) $Condition_resid.=" and r.id_safar='$id_safar'";//شماره سفر 
	if ($code_bastebandy) $Condition_resid.=" and bastebandy.code_bastebandy='$code_bastebandy'";//نوع بسته بندی    
    if ($code_peymankar_haml) $Condition_resid.=" and r.code_peymankar_haml='$code_peymankar_haml'";//کد پیمانکار 
	if (isset($status)and($status=='0')) $Condition_resid.=" and r.status=0";//وضعیت رسید 	 
    if (isset($status)and($status=='1')) $Condition_resid.=" and r.status=1";//وضعیت رسید 	 
    if (isset($status) and ($status=='2')) $Condition_resid.="";//وضعیت رسید
    if ($barname_no) $Condition_resid.=" and r.barname_no='$barname_no'";//شماره بارنامه
	if ($barname_tarikh) $Condition_resid.=" and r.barname_tarikh='$barname_tarikh'";//تاریخ بارنامه
	if ($noe_tahvil_bar) $Condition_resid.=" and r.noe_tahvil_bar='$noe_tahvil_bar'";//نوع تحویل بار
	if ($code_mabda) $Condition_resid.=" and r.code_mabda='$code_mabda'";//مبدأ بارگیری
    if ($code_ostan_mabda) $Condition_resid.=" and r.code_ostan_mabda='$code_ostan_mabda'";//استان مبدأ
    if ($code_anbar_mabda) $Condition_resid.=" and r.code_anbar_mabda='$code_anbar_mabda'";//انبار مبدأ
	if ($code_takhlie) $Condition_resid.=" and r.code_takhlie='$code_takhlie'";//نوع تخلیه
	if ($shomare_container) $Condition_resid.=" and r.shomare_container='$shomare_container'";//شماره کانتینر 
	if ($kamion_no) $Condition_resid.=" and r.kamion_no='$kamion_no'";//شماره کامیون 
	if ($plak1) $Condition_resid.=" and r.plak1='$plak1'";//پلاک خودرو 
    if ($plak2) $Condition_resid.=" and r.plak2='$plak2'";//پلاک خودرو 
    if ($plak3) $Condition_resid.=" and r.plak3='$plak3'";//پلاک خودرو 
    if ($plak4) $Condition_resid.=" and r.plak4='$plak4'";//پلاک خودرو 
	if ($bsk_no) $Condition_resid.=" and r.bsk_no='$bsk_no'";//شماره باسکول 
    if ($set_sanad) $Condition_resid.=" and r.set_sanad='$set_sanad'";//شماره سند 
    if ($vazn_mabda) $having_Condition.=" AND vaznMabda LIKE '$vazn_mabda%'";//وزن مبدأ
    if ($tedad_k) $having_Condition.=" AND tedadKarton LIKE '$tedad_k%'";//تعداد
    if ($vazn_nkh) $having_Condition.=" AND vaznNaKhales LIKE '$vazn_nkh%'";//وزن ناخالص
    if ($vazn_kh) $having_Condition.=" AND vaznKhales LIKE '$vazn_kh%'";//وزن خالص
    if ($shomare_jabejae)$Condition_resid.=" and r.shomare_jabejae='$shomare_jabejae'";//شماره مجوز جابه جایی 
	/****************شروع نمایش گزارش*******************/				
	$page=1;
    $line=0;
    $i=0;
    $cntr=0;
	$radif=1;
	$q="SELECT r.*,kala.name_kala,kala.code_bastebandy,bastebandy.sharh_bastebandy,mt_skk.name_skk,takhlie.sharh_takhlie,mabady_vorudy.name_mabda,peymankar_haml.name_peymankar_haml,ostan.name_ostan,list_sardkhane.name_anbar,list_sardkhane_detail.name_ziranbar,
	   (SELECT SUM(tedad_karton_r_d_sub) FROM resid_kala_detail r_k_d WHERE r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year $Condition_r_k_d)AS tedadKarton,
	   (SELECT SUM(vazn_nakhales_r_d_sub) FROM resid_kala_detail r_k_d WHERE r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year $Condition_r_k_d)AS vaznNaKhales,
	   (SELECT SUM(vazn_khales_r_d_sub) FROM resid_kala_detail r_k_d WHERE r_k_d.shomare_resid=r.shomare_resid AND r_k_d.code_ostan=r.code_ostan AND r_k_d.code_anbar=r.code_anbar AND r_k_d.year=r.year $Condition_r_k_d)AS vaznKhales,
	   (SELECT SUM(vazn_mabda_r_d) FROM resid_detail r_d WHERE r_d.shomare_resid=r.shomare_resid AND r_d.code_ostan=r.code_ostan AND r_d.code_anbar=r.code_anbar AND r_d.year=r.year $Condition_r_d)AS vaznMabda
		FROM resid AS r 
	    LEFT OUTER JOIN resid_detail AS r_d ON r_d.shomare_resid=r.shomare_resid AND r_d.code_ostan=r.code_ostan AND r_d.code_anbar=r.code_anbar AND r_d.year=r.year
        LEFT OUTER JOIN resid_kala_detail AS r_k_d ON r_d.shomare_resid=r_k_d.shomare_resid AND r_d.code_ostan=r_k_d.code_ostan AND r_d.code_anbar=r_k_d.code_anbar AND r_d.year=r_k_d.year AND r_d.code_kala=r_k_d.code_kala AND r_d.code_keshvar=r_k_d.code_keshvar AND r_d.code_tolidkonande=r_k_d.code_tolidkonande 
		LEFT JOIN kala ON r_d.code_kala=kala.code_kala    
        LEFT JOIN bastebandy ON bastebandy.code_bastebandy=kala.code_bastebandy    
        LEFT JOIN mt_skk ON mt_skk.code_skk=r.code_skk    
        LEFT JOIN takhlie ON takhlie.code_takhlie=r.code_takhlie    
        LEFT JOIN mabady_vorudy ON mabady_vorudy.code_mabda=r.code_mabda    
        LEFT JOIN peymankar_haml ON peymankar_haml.code_peymankar_haml=r.code_peymankar_haml    
        LEFT JOIN ostan ON ostan.code_ostan=r.code_ostan_mabda    
        LEFT JOIN list_sardkhane ON list_sardkhane.code_anbar=r.code_anbar_mabda AND list_sardkhane.code_ostan=r.code_ostan_mabda    
        LEFT JOIN list_sardkhane_detail ON list_sardkhane_detail.code_ziranbar=r_k_d.code_ziranbar AND list_sardkhane_detail.code_ostan=r_k_d.code_ostan AND list_sardkhane_detail.code_anbar=r_k_d.code_anbar    
		WHERE 1=1 $Condition_resid $Condition_r_k_d AND r.code_ostan='$mt_gl_code_ostan' AND r.code_anbar='$mt_gl_code_anbar' AND r.year='$mtActiveYear' AND r.deleted=0 GROUP BY r.shomare_resid,r.code_ostan,r.code_anbar,r.year HAVING 1=1 $having_Condition ORDER BY r.tarikh_resid,r.shomare_resid";			
	//echo $q;
	$res=$db->query($q);
    $cntr =mysql_num_rows($res);
	$myAnbarName=$db->get_from_where("name_anbar","list_sardkhane","code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar'");//نام انبار خودمان
	if(mysql_num_rows($res)>0)
	{		
	 echo'
     <br/>
       <table class="hideatprint" width="99%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">   
      	<tr class="print_table-title2 "><td colspan="30">وضعیت نمایش ستونها در گزارش</td></tr>
		<tr class="print_table-title2  select_all">
		 <td width="5%" >نوع تحویل بار</td>
	     <td width="5%" >فروشنده/کشتی</td>
	     <td width="5%" >استان مبدأ</td>
	     <td width="5%" >سردخانه مبدأ/مبدأ بارگیری</td>
	     <td width="5%" >نوع تخلیه</td>
	     <td width="5%" >شرکت حمل کننده</td>
	     <td width="5%" >شماره بارنامه</td>
	     <td width="5%" >تاریخ بارنامه</td>
	     <td width="5%" >پلاک خودرو</td>
	     <td width="5%" >شماره باسکول</td> 
	     <td width="5%" >شماره سند</td> 
	     <td width="5%" >شماره کانتینر</td> 
	     <td width="5%" >وضعیت</td>
	     <td width="5%" >وزن مبدأ</td>
	     <td width="5%" >وزن مقصد</td>
	     <td width="5%" >کل کسری</td>
	     <td width="5%" >کسری غیرمجاز</td>
	     <td width="5%" >وزن اضافه</td>
	     <td width="5%" >مبلغ کرایه مبدأ</td>
	     <td width="5%" >مبلغ جریمه</td>
	     <td width="5%" >مبلغ پرداختی</td>
		 <td width="5%">شماره مجوز جابه جایی</td>
	    </tr>   	
		<tr class="print_table-title2 print_table-title_small">
	     <td><input name="noe_tahvilPr" class="count_sum" type="checkbox" checked ></td>
	     <td><input name="skkPr" class="count_sum" type="checkbox" checked></td>
	     <td><input name="ostan_mabdaPr" class="count_sum" type="checkbox" checked ></td>
	     <td><input name="mabdaPr" class="count_sum" type="checkbox" checked ></td>
	     <td><input name="takhliePr" class="count_sum" type="checkbox"  checked></td>
	     <td><input name="peymankarPr" class="count_sum" type="checkbox"  checked></td>
	     <td><input name="sh_barnamePr" class="count_sum" type="checkbox"  checked></td>
	     <td><input name="date_barnamePr" class="count_sum" type="checkbox" checked ></td>
	     <td><input name="pelakPr" class="count_sum" type="checkbox" checked ></td>
	     <td><input name="sh_baskulPr" class="count_sum" type="checkbox" checked></td>
	     <td><input name="sh_sanadPr" class="count_sum" type="checkbox" checked ></td>
	     <td><input name="sh_contPr" class="count_sum" type="checkbox" checked ></td>
	     <td><input name="statusPr" class="count_sum" type="checkbox" checked></td>
	     <td><input name="vazn_mabdaPr" type="checkbox"  checked></td>
	     <td><input name="vazn_maghsadPr" type="checkbox"  checked></td>
	     <td><input name="kasry_kolPr" type="checkbox" checked ></td>
	     <td><input name="kasry_gheyrPr" type="checkbox" checked ></td>
	     <td><input name="vazn_ezafePr" type="checkbox" checked ></td>
	     <td><input name="mablagh_kerayePr" type="checkbox"  ></td>
	     <td><input name="mablagh_jarimePr" type="checkbox"  ></td>
	     <td><input name="mablagh_pardakhtyPr" type="checkbox"  ></td>
		 <td><input name="mojavezPr" type="checkbox" checked ></td>
	    </tr>	
     </table>
	 <div class="table2excel">';
	 print_header();
	 /*سطر نمایش فیلترها*/
	 if(strlen($mt_gl_code_ostan)==1) $code_a=make_pattern($mt_gl_code_ostan,2);
     else $code_a=$mt_gl_code_ostan;
	 if($shomare1) $filter_string.=' از شماره رسید : '.$code_a.$mt_gl_code_anbar.$shomare1.'&nbsp;';    
	 if($shomare2) $filter_string.=' تا شماره رسید : '.$code_a.$mt_gl_code_anbar.$shomare2.'&nbsp;';    
	 if($code_kala) {$nameKala=$db->get_from_where("name_kala","kala","code_kala='$code_kala'"); $filter_string.=' کالا : '.$nameKala.'&nbsp;';}     
	 if($code_keshvar) {$nameKeshvar=$db->get_from_where("name_keshvar","keshvar","code_keshvar='$code_keshvar'"); $filter_string.=' کشور : '.$nameKeshvar.'&nbsp;';}     
	 if($code_tolidkonande) {$nameTolidkonande=$db->get_from_where("name_tolidkonande","tolidkonande","code_tolidkonande='$code_tolidkonande'"); $filter_string.=' تولیدکننده : '.$nameTolidkonande.'&nbsp;';}     
	 if($code_karton) $filter_string.=' کد کارتن /قوطی : '.$code_karton.'&nbsp;';    
	 if($code_ziranbar) {$nameZirAnbar=$db->get_from_where("name_ziranbar","list_sardkhane_detail","code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND code_ziranbar='$code_ziranbar'");$filter_string.=' زیرانبار : '.$nameZirAnbar.'&nbsp;';}     
	 if($sal_tolid_shamsi) {$filter_string.=' سال : '.$sal_tolid_shamsi.'&nbsp;';}     
	 if($mah_tolid_shamsi) {$filter_string.=' ماه : '.$mahshamsiArr[$mah_tolid_shamsi].'&nbsp;';}     
	 if($rouz_tolid_shamsi) {$filter_string.=' روز : '.$rouz_tolid_shamsi.'&nbsp;';}     
	 if($code_skk) {$nameKeshty=$db->get_from_where("name_skk","mt_skk","code_skk='$code_skk'");$filter_string.=' نام کشتی/شرکت : '.$nameKeshty.'&nbsp;';}     
	 if($id_safar) {$shomareSafar=$db->get_from_where("shomare_safar","shomare_safar","code_skk='$code_skk' AND id_safar='$id_safar'"); $filter_string.=' شماره سفر : '.$shomareSafar.'&nbsp;';}     
	 if($code_bastebandy) {$sharhBastebandy=$db->get_from_where("sharh_bastebandy","bastebandy","code_bastebandy='$code_bastebandy'"); $filter_string.=' بسته بندی : '.$sharhBastebandy.'&nbsp;';}     
	 if($code_peymankar_haml) {$sharhPeymankar=$db->get_from_where("name_peymankar_haml","peymankar_haml","code_peymankar_haml='$code_peymankar_haml'"); $filter_string.=' بسته بندی : '.$sharhPeymankar.'&nbsp;';}     
	 if($status!='-1')
	 { 
	   if($status=='0') $filter_string.=' وضعیت رسید : '.$statusFormArr[$status].'&nbsp;';    
	   if($status=='1') $filter_string.=' وضعیت رسید : '.$statusFormArr[$status].'&nbsp;';    
     }
	 if($barname_no) $filter_string.=' شماره بارنامه : '.$barname_no.'&nbsp;';
	 if($barname_tarikh) $filter_string.=' تاریخ بارنامه : '.$barname_tarikh.'&nbsp;';
	 if($kamion_no) $filter_string.=' شماره کامیون : '.$kamion_no.'&nbsp;';
	 if(($plak1)or($plak2)or($plak3)or($plak4)) 
	 {
	  $filter_string.=' پلاک خودرو :&nbsp;';
	  $filter_string.='  '.$plak1.'&nbsp;';
	  $filter_string.='  '.$plak2.'&nbsp;';
	  $filter_string.='  '.$plak3.'&nbsp;';
	  $filter_string.='  '.$plak4.'&nbsp;';}
	 if($bsk_no!='') $filter_string.=' شماره باسکول : '.$bsk_no.'&nbsp;';
	 if($code_takhlie) {$sharhTakhlie=$db->get_from_where("sharh_takhlie","takhlie","code_takhlie='$code_takhlie'"); $filter_string.=' نوع تخلیه : '.$sharhTakhlie.'&nbsp;';}     
	 if($noe_tahvil_bar) $filter_string.=' نوع تحویل بار : '.$tahvilbarArr[$noe_tahvil_bar].'&nbsp;';    
	 if($code_mabda) {$nameMabda=$db->get_from_where("name_mabda","mabady_vorudy","code_mabda='$code_mabda'");$filter_string.=' مبدأ بارگیری : '.$nameMabda.'&nbsp;';}     
	 if($code_ostan_mabda) {$nameOstanMabda=$db->get_from_where("name_ostan","ostan","code_ostan='$code_ostan_mabda'"); $filter_string.=' استان مبدأ : '.$nameOstanMabda.'&nbsp;';}     
     if($code_anbar_mabda) {$nameAnbarMabda=$db->get_from_where("name_anbar","list_sardkhane","code_ostan='$code_ostan_mabda' AND code_anbar='$code_anbar_mabda'"); $filter_string.=' انبارمبدأ : '.$nameAnbarMabda.'&nbsp;';}     
	 if($shomare_jabejae) $filter_string.=' شماره مجوز جابه جایی : '.$shomare_jabejae.'&nbsp;';
	 if ($set_sanad) $filter_string.=' شماره سند : '.$set_sanad.'&nbsp;'; 	 
	 if ($vazn_mabda) $filter_string.=' وزن مبدأ : '.$vazn_mabda.'&nbsp;'; 	 
	 if ($tedad_k) $filter_string.=' تعداد : '.$tedad_k.'&nbsp;'; 	 
	 if ($vazn_nkh) $filter_string.=' وزن ناخالص : '.$vazn_nkh.'&nbsp;'; 	 
	 if ($vazn_kh) $filter_string.=' وزن خالص : '.$vazn_kh.'&nbsp;'; 	 
	 
	 if(($shomare1)or($shomare2)or($code_kala)or($code_keshvar)or($code_tolidkonande)or($code_karton)or($code_ziranbar)or($sal_tolid_shamsi)or($mah_tolid_shamsi)or($rouz_tolid_shamsi)or($code_skk)or($id_safar)or($code_bastebandy)or($code_peymankar_haml)or($status!='-1')or($barname_no)or($barname_tarikh)or($kamion_no)or($plak1)or($plak2)or($plak3)or($plak4)or($bsk_no!='')or($code_takhlie)or($noe_tahvil_bar)or($code_mabda)or($code_ostan_mabda)or($code_anbar_mabda)or($set_sanad)or($vazn_mabda)or($tedad_k)or($vazn_nkh)or($vazn_kh))
	 {echo'<tr class="noExl"><td class="filter_text" colspan="40">فیلتر شده براساس : '.$filter_string.'</td></tr>';}
	 
	 echo $columns;   
	 while($row=$db->fetch_assoc($res))
	 {
	  $line++;
	  if($i++%2)echo'<tr class="print_table-odd_small">';
      else echo'<tr class="print_table-even_small">';
	  //اضافه کردن صفر پشت کد استان
	  if(strlen($row['code_ostan'])==1) $code_a=make_pattern($row['code_ostan'],2);
      else $code_a=$row['code_ostan'];
      echo'
	    <td>'.$radif++.'</td>
	    <td>'.$code_a.$row['code_anbar'].$row['shomare_resid'].'</td>
	    <td>'.$row['tarikh_resid'].'</td>
	    <td class="noe_tahvilPr">'.$tahvilbarArr[$row['noe_tahvil_bar']].'</td>
        <td class="skkPr">'.$row['name_skk'].'</td>
	    <td class="ostan_mabdaPr">'.$row['name_ostan'].'</td>
	    <td class="mabdaPr">';if(($row['noe_tahvil_bar']==4)or($row['noe_tahvil_bar']==5)) echo''.$row['name_anbar'].''; else echo''.$row['name_mabda'].'';echo'</td>
	    <td class="takhliePr">'.$row['sharh_takhlie'].'</td>
	    <td class="peymankarPr">'.$row['name_peymankar_haml'].'</td>
	    <td class="sh_barnamePr">'.$row['barname_no'].'</td>
	    <td class="date_barnamePr">'.$row['barname_tarikh'].'</td>';
	    IF($row['kamion_no'])echo'<td class="pelakPr">'.$row['kamion_no'].'</td>';
		ELSE echo'<td dir="rtl" class="pelakPr">'.$row['plak2'].'-'.$row['plak1'].''.$row['plak3'].''.$row['plak4'].'</td>';
	    echo'
		<td class="sh_baskulPr">'.$row['bsk_no'].'</td>';
		if($row['set_sanad']!=0)echo'<td class="sh_sanadPr"> 97/'.$row['set_sanad'].'</td>';
		else echo'<td class="sh_sanadPr">-</td>';
		echo'<td class="sh_contPr">'.$row['shomare_container'].'</td>';
		echo'<td class="statusPr">'.$statusFormArr[$row['status']].'</td>';
	    //$vazn_mabda_r=$db->get_from_where("SUM(vazn_mabda_r_d)","resid_detail r_d","shomare_resid='".$row['shomare_resid']."' AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND year='$mtActiveYear' AND resid_deleted=0 AND status=0");
		
		//اگر روباری بود وزن مبدأ همان وزن ناخالص است
		//if($row['noe_tahvil_bar']==2)echo'<td>'.virgul($row['vazn_nakhales_r']).'</td>';
		if($row['noe_tahvil_bar']==2)echo'<td class="vazn_mabdaPr">'.round($row['vaznNaKhales'],3).'</td>';
		else echo'<td class="vazn_mabdaPr">'.($row['vaznMabda']).'</td>';
		echo'
		<td class="vazn_maghsadPr">'.virgul($row['tedadKarton']).'</td>
		<td class="vazn_maghsadPr">'.round($row['vaznNaKhales'],3).'</td>
		<td class="vazn_maghsadPr">'.round($row['vaznKhales'],3).'</td>';
        
		//اطلاعات از جزئیات
	    $q_d="SELECT *,
             (SELECT SUM(vazn_nakhales_r_d_sub) FROM resid_kala_detail r_k_d WHERE r_k_d.code_kala=r_d.code_kala AND r_k_d.code_keshvar=r_d.code_keshvar AND r_k_d.code_tolidkonande=r_d.code_tolidkonande AND r_k_d.shomare_resid=r_d.shomare_resid AND r_k_d.code_ostan=r_d.code_ostan AND r_k_d.code_anbar=r_d.code_anbar AND r_k_d.year=r_d.year) vazn_nakhales_r_d,				  
             (SELECT SUM(tedad_karton_r_d_sub) FROM resid_kala_detail r_k_d WHERE r_k_d.code_kala=r_d.code_kala AND r_k_d.code_keshvar=r_d.code_keshvar AND r_k_d.code_tolidkonande=r_d.code_tolidkonande AND r_k_d.shomare_resid=r_d.shomare_resid AND r_k_d.code_ostan=r_d.code_ostan AND r_k_d.code_anbar=r_d.code_anbar AND r_k_d.year=r_d.year) tedad_karton_r_d,		
             (SELECT SUM(sum_karton_r_d_sub) FROM resid_kala_detail r_k_d WHERE r_k_d.code_kala=r_d.code_kala AND r_k_d.code_keshvar=r_d.code_keshvar AND r_k_d.code_tolidkonande=r_d.code_tolidkonande AND r_k_d.shomare_resid=r_d.shomare_resid AND r_k_d.code_ostan=r_d.code_ostan AND r_k_d.code_anbar=r_d.code_anbar AND r_k_d.year=r_d.year) sum_karton_r_d		
		     From resid_detail r_d WHERE 1=1 $Condition_r_d AND r_d.shomare_resid='".$row['shomare_resid']."' AND r_d.code_ostan='".$row['code_ostan']."' AND r_d.code_anbar='".$row['code_anbar']."' AND r_d.year='".$row['year']."'";	
		$res_d =$db->query($q_d);
		if(mysql_num_rows($res_d)>0)//اگر جزئیات کالا را پر کرده است
	    {
		 	$kasry_kol_r=0;
	        $kasry_mojaz_r=0;
	        $kasry_gheyremojaz_r=0;
	        $vazn_ezafe_r=0;
	        $mablagh_jarimekasry_r=0;
	        $mablagh_takhlie_r=0;
			$mablagh_pardakhty=0;
	     while($row_d=$db->fetch_assoc($res_d))
	     {
		   $kasry_kol_r_d=$row_d['vazn_mabda_r_d']-$row_d['vazn_nakhales_r_d'];//کل کسری این کالا
	       if($kasry_kol_r_d<0) $kasry_kol_r_d=0;//اگر جواب منفی شد
	       if($kasry_kol_r_d==$row_d['vazn_mabda_r_d'])//اگر هنوز وزن ناخالص را ثبت نکرده ایم
	       { 
	    	 $kasry_kol_r_d=0;
	         $kasry_gheyremojaz_r_d=0;
 	       }
	      $kasry_gheyremojaz_r_d=$kasry_kol_r_d-$row_d['kasry_mojaz_r_d'];//کسری غیرمجاز این کالا
	       if($kasry_gheyremojaz_r_d<0) $kasry_gheyremojaz_r_d=0;//اگر جواب منفی شد
	      $vazn_ezafe_r_d=$row_d['vazn_nakhales_r_d']-$row_d['vazn_mabda_r_d'];//وزن اضافه
	       if($vazn_ezafe_r_d<0) $vazn_ezafe_r_d=0;//اگر جواب منفی شد
	      $mablagh_jarimekasry_r_d=$kasry_gheyremojaz_r_d*$row_d['fee_this'];//مبلغ جریمه کسری
	      $mablagh_takhlie_r_d=$row_d['nerkh_takhlie_this'];//مبلغ تخلیه
	      //$vazn_mabda_r+=$row_d['vazn_mabda_r_d'];
		  //اگر نوع تحویل بار روباری نباشد
		  if(($row['noe_tahvil_bar']!=2)and($row['noe_tahvil_bar']!=5))
		  {
	        $kasry_kol_r+=$kasry_kol_r_d;
	        $kasry_mojaz_r+=$row_d['kasry_mojaz_r_d'];
	        $kasry_gheyremojaz_r+=$kasry_gheyremojaz_r_d;
	        $vazn_ezafe_r+=$vazn_ezafe_r_d;
	        if($row['noe_pardakht']==2)//اگر نوع پرداخت کرایه در مقصد بود
            {
			 $mablagh_jarimekasry_r+=$mablagh_jarimekasry_r_d;
	         $mablagh_takhlie_r+=$mablagh_takhlie_r_d;
			}
		  }
		 }
		}
		 $mablagh_pardakhty=$row['mablagh_kerayemabda']-$mablagh_jarimekasry_r+$row['mablagh_haghetavaghof']-$mablagh_takhlie_r;
	     if($mablagh_pardakhty<0) $mablagh_pardakhty=0;
		
		//$mablagh_pardakhty=paskeraye($row['shomare_resid'],$row['code_ostan'],$row['code_anbar'],$row['year']);
		echo'
		<!--<td>'.virgul($row['tedad_karton_r']).'</td>
		    <td>'.($row['vazn_nakhales_r']).'</td>
		    <td>'.($row['vazn_khales_r']).'</td>-->
	    <td class="kasry_kolPr">'.round($kasry_kol_r,3).'</td>
	    <td class="kasry_gheyrPr">'.round($kasry_gheyremojaz_r,3).'</td>
	    <td class="vazn_ezafePr">'.round($vazn_ezafe_r,3).'</td>
	    <td class="mablagh_kerayePr">'.virgul($row['mablagh_kerayemabda']).'</td>
	    <td class="mablagh_jarimePr">'.virgul($mablagh_jarimekasry_r).'</td>
	    <td class="mablagh_pardakhtyPr">'.virgul($mablagh_pardakhty).'</td>
		<td class="mojavezPr"">'.$row['shomare_jabejae'].'</td>
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
	 //اگر روباری بود وزن مبدأ همان وزن ناخالص است
	  if($row['noe_tahvil_bar']==2) $sum_vazn_mabda+=$row['vaznNaKhales'];
      else $sum_vazn_mabda+=$row['vaznMabda'];  
	  if($row['status']==0)
	  {
	   $sum_tedad_karton+=$row['tedadKarton'];
	   $sum_vazn_nakhales+=$row['vaznNaKhales'];
	   $sum_vazn_khales+=$row['vaznKhales'];
	  }
	  $sum_kasry_kol+=$kasry_kol_r;
	  $sum_kasry_gheyremojaz+=$kasry_gheyremojaz_r;
	  $sum_vazn_ezafe+=$vazn_ezafe_r;
	  $sum_mablagh_kerayemabda+=$row['mablagh_kerayemabda'];
	  $sum_mablagh_jarimekasry+=$mablagh_jarimekasry_r;
	  $sum_mablagh_pardakhty+=$mablagh_pardakhty;
	 }//END while
	 echo'
	  <tr class="print_table-even sum-row-white-b">
	   <td id="sum_row" colspan="16">جمع مقادیر</td>
	   <td class="vazn_mabdaPr">'.($sum_vazn_mabda).'</td>
	   <td class="vazn_maghsadPr">'.virgul($sum_tedad_karton).'</td>
	   <td class="vazn_maghsadPr">'.($sum_vazn_nakhales).'</td>
	   <td class="vazn_maghsadPr">'.($sum_vazn_khales).'</td>
	   <td class="kasry_kolPr">'.($sum_kasry_kol).'</td>
	   <td class="kasry_gheyrPr">'.($sum_kasry_gheyremojaz).'</td>
	   <td class="vazn_ezafePr">'.($sum_vazn_ezafe).'</td>
	   <td class="mablagh_kerayePr">'.virgul($sum_mablagh_kerayemabda).'</td>
	   <td class="mablagh_jarimePr">'.virgul($sum_mablagh_jarimekasry).'</td>
	   <td class="mablagh_pardakhtyPr">'.virgul($sum_mablagh_pardakhty).'</td>
	   <td class="mojavezPr">-</td>
	  </tr>';
	 /******نمایش موجودی کالا******/
     // echo'
     // <table width="99%" height="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#747474">  
	  // <tr class="print_title"><td colspan="13">موجودی کالا</td></tr>';
	  // //موجودی کالاهایی که رسید دارند نمایش داده شودودر بالا نمایش داده شده
	  // //if($code_ziranbar) $ziranbar_Condition_resid=" AND code_ziranbar='$code_ziranbar'";
	  
	  // $q4="SELECT * FROM mojody_kala WHERE code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' $ziranbar_Condition_resid AND year='$mtActiveYear' AND deleted=0 AND 
	             // (code_kala IN (SELECT r.code_kala 
	              // FROM resid_detail AS r 
                  // LEFT JOIN kala ON r.code_kala=kala.code_kala    
                  // LEFT JOIN bastebandy ON bastebandy.code_bastebandy=kala.code_bastebandy    
                  // LEFT JOIN mt_skk ON mt_skk.code_skk=r.code_skk    
                  // LEFT JOIN takhlie ON takhlie.code_takhlie=r.code_takhlie    
                  // LEFT JOIN peymankar_haml ON peymankar_haml.code_peymankar_haml=r.code_peymankar_haml    
                  // WHERE 1=1 $Condition_resid AND r.code_ostan='$mt_gl_code_ostan' AND r.code_anbar='$mt_gl_code_anbar' AND r.year='$mtActiveYear' AND r.deleted=0 ORDER BY tarikh_resid))";	
      // //echo $q4;
	  // $res4=$db->query($q4);
	  // echo'
       // <tr class="print_table-title2">		 
	    // <td width="5%" rowspan="2">ردیف</td>
	    // <td width="5%" rowspan="2">کد کالا</td>
	    // <td width="15%" rowspan="2">نام کالا</td>
	    // <td width="10%" rowspan="2">نام زیرانبار</td>
	    // <td width="10%" rowspan="2">نام کشور</td>
	    // <td width="10%" rowspan="2">نام تولیدکننده</td>
	    // <td width="15%" colspan="3">تاریخ تولید شمسی</td>
	    // <td width="5%" rowspan="2">کد کارتن</td>
	    // <td width="30%" colspan="3">موجودی فعلی کالا</td>
	   // </tr>
       // <tr class="print_table-title2">		 
	    // <td>سال</td>
	    // <td>ماه</td>
	    // <td>روز</td>
	    // <td>تعداد کارتن</td>
	    // <td>موجودی ناخالص</td>
	    // <td>موجودی خالص</td>
	   // </tr>';
	  // $j=0;
	  // while($row4=$db->fetch_assoc($res4))
	  // {
	   // if($j++%2)
       // echo'<tr class="print_table-odd_small"/>';
       // else echo '<tr class="print_table-even_small"/>';
	   // $nameKala2=$db->get_from_where("name_kala","kala","code_kala=".$row4['code_kala']."");//نام کالای مورد نظر
	   // $ziranbarName=$db->get_from_where("name_ziranbar","list_sardkhane_detail","code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' AND code_ziranbar=".$row4['code_ziranbar']."");//نام کالای مورد نظر
	   // echo'<td>'.$row4['code_kala'].'</td>
	        // <td>'.$nameKala2.'</td>
	        // <td>'.$ziranbarName.'</td>
	        // <td>'.virgul($row4['mojody']).'</td>';
	  // }
      // echo'
	  // </tr>';
	   
  // echo'
 // </table>';
 echo'
 <!--پايان مرکز صفحه -->
 <!-- چاپ زیرنویس-->
   <tr class="print_footer noExl">
    <td colspan="40">&nbsp;&nbsp;نام کاربر :&nbsp;&nbsp;'.$mtuserNAME.' &nbsp;&nbsp;&nbsp; تاریخ چاپ : '.$today.' &nbsp;&nbsp;&nbsp; ساعت چاپ : '.$logtime.'</td>
   </tr>
 </table>';	 	 
}	
 ELSE{echo'<div class="msg_error"><span >اطلاعاتی یافت نشد</span><br><button class="buttonme hideatprint" onClick="window.location=\''.$FileName.'\'">بازگشت</button></div>';}
}//END else
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
         var count_for_sum=16;//default
		 var numberNotChecked  = $(".count_sum:not(:checked)").length; //only the class count_sum 
		 var count_for_sum=count_for_sum-numberNotChecked;
		 $("#sum_row").attr("colspan",count_for_sum);
        }); 
 <!-- نوع تحویل بار-->
 $("[name=noe_tahvil_bar]").bind("change", function () {
    if(($(this).val() == 4)||($(this).val() == 5)) $(".ostananbar").slideDown("fast");
	else {$(".ostananbar").slideUp("fast");}
  });
}); 
<!-- تعویض انبار با انتخاب استان-->
function getAnbareOstan(code_ostan)
{
  $("#loading").fadeIn("fast");  
  $.post("ajax_re_resid.php",{codeOSTAN1:code_ostan},function(data){$("#anbar_mabda").html(data);});
  $("#loading").fadeOut("fast");		
}
<!-- تعویض اطلاعات شماره سفر با انتخاب کشتی-->
function getShomareSafar(code_skk)
{
  $("#loading").fadeIn("fast");  
  $.post("ajax_re_resid.php",{codeKESHTY:code_skk},function(data){$("[name=id_safar]").html(data);});
  $("#loading").fadeOut("fast");		
}
</script> 