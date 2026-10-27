<?php
//مانده در ابتدای دوره را از نمایش حذف کردم
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="report_manager_serizamani_mojody.php";
$ExcelFileName=str_replace('.php','',$FileName);
//مانده در ابتدای دوره را کامنت کردیم 
//1395/12/21
$titr='گزارش سری زمانی موجودی به تفکیک استان و سردخانه';
require_once('head.html');
if($noe_namayesh==1)$str='(خالص)';
if($noe_namayesh==2)$str='(ناخالص)';
if($noe_namayesh==3)$str='(کارتن)';
Function print_header()
{global $titr,$mt_gl_owner,$mt_gl_name_anbar,$mt_gl_name_ostan,$date1,$date2,$FileName,$db,$page,$noe_namayesh,$str,$Condition_kala;
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
    </tr>
	<tr class="print_table-title2">
	 <td !--rowspan="2"-- >تاریخ</td>
	 <td !--rowspan="2"-- >استان</td>
	 <td !--rowspan="2"-- >سردخانه</td>';
	   $q_column="SELECT name_kala FROM kala T WHERE $Condition_kala ORDER BY name_kala";
	   $res_column=$db->query($q_column);
	   while($column=$db->fetch_assoc($res_column))
	   {echo'<td !--colspan="2"-- >'.$column['name_kala'].'</td>';}
	   echo'
	  </tr>'; 
      // echo'
	  // <tr class="print_table-title2">';
       // $res_column=$db->query($q_column);//The query above to run again
	   // while($column=$db->fetch_assoc($res_column))
	   // {echo'
        // <td>ابتدای دوره '.$str.'</td>
	    // <td>مانده در پایان دوره '.$str.'</td>';
	   // }
	  // echo' 
 	  // </tr>';
}
/***************************************** MAIN*****************************************/
echo'
<body class="openwin" onload="document.myform.date1.focus();">
<form method="post" name="myform" onkeydown="enterIE()">';
if(!$MaxLines)$MaxLines=5;
if(!$date1)//اگر کاربر تاریخ اول را وارد نکرده بود
{
	  $date1=$db->get_from_where("start_from","meat.mt_docs","year='$mtActiveYear'");
      //$date1='1396/02/22';	  
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
 <table width="95%" align="center" cellpadding="0" cellspacing="0">
 <img src="images/loading.gif" id="loading" class="loading_img"/>
  <tr>
   <td height="100%">
    <table width="700px" border="0" align="center" cellpadding="0" cellspacing="0" >
     <tr><td colspan="4" height="20px">&nbsp;</td></tr>
 	 <tr><td colspan="4" class="title">'.$titr.'</td></tr>
     <tr class="tr1" style="height:45px;">	
 	  <td align="left" width="110px"> از تاریخ :&nbsp;</td><td align="right" width="220px"><input type="text" class="textboxme2" name="date1" id="datepickerfrom" placeholder="'.$date1.'" maxlength="10"/></td>
      <td align="left" width="110px"> تا تاریخ :&nbsp;</td><td align="right" width="200px"><input type="text" class="textboxme2" name="date2" id="datepickerto" placeholder="'.$date2.'" maxlength="10"/></td>
 	 </tr>
	 <tr class="tr1">
	  <td align="left"> نمایش اطلاعات :&nbsp;</td><td align="right">'.static_listbox("noe_namayesh",$noe_namayesh,"namayeshArr",1,"class='easyui-combobox text4' style=width:100px data-options=panelHeight:100").'</td>	
	  <td align="left"> تعداد تاریخ در صفحه :&nbsp;</td><td align="right" colspan="3"><input type="text" class="textboxme2 textbox50" name="MaxLines" value="'.$MaxLines.'" onkeypress="return isNumber(event)"/></td>
	 </tr>
	 <tr class="tr1">
	  <td align="left"><input type="checkbox" name="chkmovaghat"/></td><td align="right">&nbsp; نمایش اطلاعات سردخانه موقت</td>
      <td align="left"><input type="checkbox" name="chkactivate" checked/></td><td align="right">&nbsp; نمایش اطلاعات سردخانه های غیرفعال</td>
	 </tr>';
	 if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
     {
	  echo'
	  <tr class="tr1">
	   <td align="left">نام استان :&nbsp;</td>
       <td align="right" colspan="3">
	    <select name="ostanchoice[]" class="easyui-combobox" style="width:330px;" multiple>';
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
	 <tr class="tr1">
      <td align="left" height="40px"> نام کالا :&nbsp;</td>
      <td align="right" colspan="3">
	   <select name="kalachoice[]" class="easyui-combobox" multiple="true" style="width:330px;">';
	   $result_kala = $db->query("SELECT * FROM kala ORDER BY name_kala");
       $kala_options = "<option value='-1' selected>همه کالاها</option>";
       while($row_kala=$db->fetch_assoc($result_kala)) $kala_options .= "<option value=".$row_kala['code_kala'].">".$row_kala['name_kala']."</option>";
	   echo $kala_options;
	   echo'
	   </select>
	  </td>
	 </tr>
	 <!--<tr class="tr1">
	  <td align="left" > کد کشور :&nbsp;</td>
	  <td align="right" colspan="3"><input class="textboxme2" type="text" name="code_keshvar" value="'.$code_keshvar.'" onkeypress="return isNumber(event)" onfocus="getDetailKeshvar(this.value);" onblur="getDetailKeshvar(this.value);" style="width:50px"/>&nbsp;';
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
	  <td align="left"> زیرانبار :&nbsp;</td><td align="right">'.listbox_ziranbar("code_ziranbar",$code_ziranbar,"code_ziranbar","name_ziranbar","list_sardkhane_detail","1=1 AND code_ostan='$mt_gl_code_ostan' AND code_anbar='$mt_gl_code_anbar' ORDER BY code_ziranbar,name_ziranbar ASC","class='text4'","").'
 	  <td align="left"> سال تولید :&nbsp;</td><td align="right"><input class="textboxme2 textbox50" type="text" name="sal_tolid_shamsi" value="'.$sal_tolid_shamsi.'" maxlength="4" placeholder=" '.$mtActiveYear.'" onkeypress="return isNumber(event)"/>
	 </tr>
	 <tr class="tr1">
 	  <td align="left"> ماه تولید :&nbsp;</td><td align="right">'.static_listbox("mah_tolid_shamsi",$mah_tolid_shamsi,"mahshamsiArr",1,"class='text4'").'
	  <td align="left"> روز تولید :&nbsp;</td><td align="right"><input class="textboxme2 textbox50" type="text" name="rouz_tolid_shamsi" value="'.$rouz_tolid_shamsi.'" maxlength="2" onkeypress="return isNumber(event)"/></td>	
	 </tr>-->
     <tr class="footer" align="center"><td colspan="4" height="40px"><input class="buttonme" type="submit" name="ok" value="شروع گزارش"></td></tr>   
     
    </table>
   </td>
  </tr>
 </table>';
}
else
{
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
	/****************فیلترها روی گزارش******************/	
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
	/******کد های کالا******/
    if(is_array($kalachoice))
    {
	  $Condition_kala="";//شرط را خالی میکنم
	  foreach($kalachoice as $kala_key => $kala_val) {$Condition_kala_temp.=" T.code_kala='$kala_val' OR";}
      if($kala_val==-1) $Condition_kala.="1=1 OR";
      else $Condition_kala.=" $Condition_kala_temp";
      $lastSpacePosition = strrpos($Condition_kala," ");
      $Condition_kala =substr($Condition_kala,0,$lastSpacePosition);
    }
	/******************نمایش یا عدم نمایش سردخانه های موقت******************/
    if($chkmovaghat=='on') $Condition_movaghat="";
    else $Condition_movaghat="situation_type=1 AND ";
    /******************نمایش یا عدم نمایش انبارهای غیرفعال******************/
    if($chkactivate=='on') {$Condition_anbar_activate=""; $Condition_anbar_activate_ostan="1=1";  }
    else {$Condition_anbar_activate="activate=1 AND"; $Condition_anbar_activate_ostan="activate=1"; }

	if($code_keshvar)//کشور 
	{
	 $Condition.=" AND T.code_keshvar='$code_keshvar'";
	}
	if($code_tolidkonande)//تولیدکننده 
	{
	 $Condition.=" AND T.code_tolidkonande='$code_tolidkonande'";
	}
	if($code_karton)//کارتن 
	{
	 $Condition.=" AND T.code_karton='$code_karton'";
	}
	if($sal_tolid_shamsi)//سال تولید شمسی 
	{
	 $Condition.=" AND T.sal_tolid_shamsi='$sal_tolid_shamsi'";
	}
	if($mah_tolid_shamsi)//ماه تولید شمسی 
	{
	 $Condition.=" AND T.mah_tolid_shamsi='$mah_tolid_shamsi'";
	}
	if($rouz_tolid_shamsi)//روز تولید شمسی 
	{
	 $Condition.=" AND T.rouz_tolid_shamsi='$rouz_tolid_shamsi'";
	}
	if($code_ziranbar)//زیرانبار 
	{
	 $Condition.=" AND T.code_ziranbar='$code_ziranbar'";
	}
    $page=1;
    $line=0;
    $i=0;
    $radif=1;
/****************شروع نمایش گزارش*******************/        
    //اگر انباری پیدا نکرد تاریخ ها رو خالی نیاورد
	if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
	{
		$tedadkolanbarha=$db->get_from_where("count(*)","list_sardkhane T","1=1 AND $Condition_anbar_activate $Condition_movaghat($Condition_ostan)");//تعداد انبارها 
	}
	else
	{
		$tedadkolanbarha=$db->get_from_where("count(user_ostan_anbar.code_anbar)","user_ostan_anbar INNER JOIN list_sardkhane ON list_sardkhane.code_ostan=user_ostan_anbar.code_ostan AND list_sardkhane.code_anbar=user_ostan_anbar.code_anbar","$Condition_anbar_activate $Condition_movaghat list_sardkhane.code_ostan=$mt_gl_code_ostan AND user_id=".$_SESSION['mt_user_id']."");//تعداد انبارهای یوزر     
	}
	if(($Condition_kala!='')and($tedadkolanbarha>0))
	{		 
	 echo'
     <br>   
     <div class="table2excel">	 
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
	 if(is_array($kalachoice))
	 {
	  if($kala_val==-1)$filter_string.=' همه کالاها';
	  else $filter_string.=' کالا : ';
	  foreach($kalachoice as $key_kala => $kala_val) {
	  $nameKala=$db->get_from_where("name_kala","kala","code_kala='$kala_val'");
	  $filter_string.=''.$nameKala.'&nbsp;';
      }
	 }
	 if($chkmovaghat==TRUE) $filter_string.=' با اطلاعات انبار موقت-';
     if($chkmovaghat==False) $filter_string.=' بدون اطلاعات انبار موقت-';
	 if($chkactivate==TRUE) $filter_string.=' با اطلاعات سردخانه غیرفعال -';
     if($chkactivate==False) $filter_string.=' بدون اطلاعات سردخانه غیرفعال -';
	 if($noe_namayesh) {$filter_string.=' نوع نمایش براساس : '.$namayeshArr[$noe_namayesh].'&nbsp;';}     
	 echo'<tr class="noExl"><td class="filter_text" colspan="50">فیلتر شده براساس : '.$filter_string.'</td></tr>';
	echo'
      <tr class="print_table-title2">
	   <td !--rowspan="2"-- >تاریخ</td>
	   <td !--rowspan="2"-- >استان</td>
	   <td !--rowspan="2"-- >سردخانه</td>';
	   $q_column="SELECT name_kala FROM kala T WHERE $Condition_kala ORDER BY name_kala";
	   $res_column=$db->query($q_column);
	   while($column=$db->fetch_assoc($res_column))
	   {echo'<td !--colspan="2"-->'.$column['name_kala'].'</td>';}
	   echo'
	  </tr>';
      // echo'	  
      // <tr class="print_table-title2">';
       // $res_column=$db->query($q_column);//The query above to run again
	   // while($column=$db->fetch_assoc($res_column))
	   // {echo'
        // <td>ابتدای دوره '.$str.'</td>
	    // <td>مانده در پایان دوره '.$str.'</td>';
	   // }
	  // echo' 
 	  // </tr>';
	  //حلقه روی تاریخ ها
	  $tarikh_milady=$date1_milady;
	  while($tarikh_milady<=$date2_milady)
	  {
	   $line++;
	   if($i++%2)echo'<tr class="print_table-odd">';
       else echo'<tr class="print_table-even">'; 
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
	    if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
		{
		  $tedadkolanbarha=$db->get_from_where("count(*)","list_sardkhane T","1=1 AND $Condition_anbar_activate $Condition_movaghat($Condition_ostan)");//تعداد انبارها 
		  $t=$db->get_from_where("count(*)","ostan T","1=1 AND($Condition_ostan)");//تعداد استان برای حلقه 
		}
	    else
		{
		  $tedadkolanbarha=$db->get_from_where("count(user_ostan_anbar.code_anbar)","user_ostan_anbar INNER JOIN list_sardkhane ON list_sardkhane.code_ostan=user_ostan_anbar.code_ostan AND list_sardkhane.code_anbar=user_ostan_anbar.code_anbar","$Condition_anbar_activate $Condition_movaghat list_sardkhane.code_ostan=$mt_gl_code_ostan AND user_id=".$_SESSION['mt_user_id']."");//تعداد انبارهای یوزر     
		  $t=1;//تعداد استان برای حلقه 
		}
	    echo'
	    <td rowspan="'.$tedadkolanbarha.'" >'.$tarikh_shamsi.'</td>';//نمایش تاریخ
		
		//if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))$q_ostan="SELECT * FROM ostan WHERE 1=1 AND($Condition_ostan) ORDER BY name_ostan";
	    if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))$q_ostan="SELECT * FROM ostan T WHERE T.code_ostan IN(SELECT code_ostan FROM list_sardkhane WHERE $Condition_movaghat $Condition_anbar_activate_ostan) AND($Condition_ostan) ORDER BY name_ostan";
		else $q_ostan="SELECT * FROM user_ostan_anbar INNER JOIN ostan ON user_ostan_anbar.code_ostan=ostan.code_ostan WHERE user_ostan_anbar.code_ostan=$mt_gl_code_ostan AND user_id=".$_SESSION['mt_user_id']."";
		$res_ostan=$db->query($q_ostan);
		while($row_ostan=$db->fetch_assoc($res_ostan))//حلقه استان
		{
		  $j=$i+1;
		  if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))$tedadanbar=$db->get_from_where("count(*)","list_sardkhane","$Condition_anbar_activate $Condition_movaghat code_ostan=".$row_ostan['code_ostan']."");//تعداد انبارهای هر استان 
		  else $tedadanbar=$tedadkolanbarha;
		  $t2=$tedadanbar;
		  echo'<td rowspan="'.$tedadanbar.'">'.$row_ostan['name_ostan'].'</td>';
		  		  
          if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))$q_anbar="SELECT * FROM list_sardkhane WHERE $Condition_anbar_activate $Condition_movaghat code_ostan=".$row_ostan['code_ostan']."  ORDER BY name_anbar";
		  else $q_anbar="SELECT * FROM user_ostan_anbar INNER JOIN list_sardkhane ON list_sardkhane.code_ostan=user_ostan_anbar.code_ostan AND list_sardkhane.code_anbar=user_ostan_anbar.code_anbar WHERE $Condition_anbar_activate $Condition_movaghat list_sardkhane.code_ostan=$mt_gl_code_ostan AND user_id=".$_SESSION['mt_user_id']."";
		  $res_anbar=$db->query($q_anbar);
		  while($row_anbar=$db->fetch_assoc($res_anbar))//حلقه انبارها
		  {
			$k=$i+1;
			echo'<td>'.$row_anbar['name_anbar'].'</td>';
		    $q_kala="SELECT code_kala FROM kala T WHERE $Condition_kala ORDER BY name_kala";
		    $res_kala=$db->query($q_kala);
	        while($row_kala=$db->fetch_assoc($res_kala))//kala while
		    {
		     if($noe_namayesh==1)//حالت خالص
		     {
	           $mojody_aval=$db->get_from_where("SUM(mojody_khales_aval)","meat.mojody_kala T","year='$mtActiveYear' AND code_ostan=".$row_ostan['code_ostan']." AND code_anbar=".$row_anbar['code_anbar']." AND T.code_kala=".$row_kala['code_kala']." AND deleted=0 $Condition");     
	           $jameKhalesVarede_befor=$db->get_from_where("SUM(vazn_khales_r_d_sub)","meat.resid_kala_detail T INNER JOIN meat.resid r ON T.shomare_resid=r.shomare_resid AND T.code_ostan=r.code_ostan AND T.code_anbar=r.code_anbar AND T.year=r.year","T.year='$mtActiveYear' AND T.code_ostan=".$row_ostan['code_ostan']." AND T.code_anbar=".$row_anbar['code_anbar']." AND T.code_kala=".$row_kala['code_kala']." AND T.resid_deleted=0 AND T.status=0 AND r.status=0 AND r.tarikh_resid<'".$tarikh_shamsi."' $Condition");
               $jameKhalesSadere_befor=$db->get_from_where("SUM(vazn_khales_h_d)","meat.havale_detail T INNER JOIN meat.havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year","T.year='$mtActiveYear' AND T.code_ostan=".$row_ostan['code_ostan']." AND T.code_anbar=".$row_anbar['code_anbar']." AND T.code_kala=".$row_kala['code_kala']." AND T.havale_deleted=0 AND T.status=0 AND h.status=0 AND h.tarikh_havale_anbar<'".$tarikh_shamsi."' $Condition");	
	           $KhalesTadil_Ezafe_befor=$db->get_from_where("SUM(meghdar_khales_tadil)","meat.tadil_mojody T","year='$mtActiveYear' AND code_ostan=".$row_ostan['code_ostan']." AND T.code_anbar=".$row_anbar['code_anbar']." AND T.code_kala=".$row_kala['code_kala']." AND tarikh_barge_tadil<'".$tarikh_shamsi."' AND noe_tadil=1 AND deleted=0 AND status=0 $Condition");     
	           $KhalesTadil_Kasry_befor=$db->get_from_where("SUM(meghdar_khales_tadil)","meat.tadil_mojody T","year='$mtActiveYear' AND code_ostan=".$row_ostan['code_ostan']." AND T.code_anbar=".$row_anbar['code_anbar']." AND T.code_kala=".$row_kala['code_kala']." AND tarikh_barge_tadil<'".$tarikh_shamsi."' AND noe_tadil=2 AND deleted=0 AND status=0 $Condition");     
	           $mande_befor=$mojody_aval+$jameKhalesVarede_befor-$jameKhalesSadere_befor+$KhalesTadil_Ezafe_befor-$KhalesTadil_Kasry_befor;	      
		       //echo'<td>'.round($mande_befor,3).'</td>';
		       
			   $jameVarede=$db->get_from_where("SUM(vazn_khales_r_d_sub)","resid_kala_detail T INNER JOIN resid r ON r.shomare_resid=T.shomare_resid AND r.code_ostan=T.code_ostan AND r.code_anbar=T.code_anbar AND r.year=T.year","T.code_ostan=".$row_ostan['code_ostan']." AND T.code_anbar=".$row_anbar['code_anbar']." AND T.year='$mtActiveYear' AND T.code_kala=".$row_kala['code_kala']." AND r.tarikh_resid='".$tarikh_shamsi."' AND T.resid_deleted=0 AND T.status=0 $Condition");     
	           $jameSadere=$db->get_from_where("SUM(vazn_khales_h_d)","havale_detail T INNER JOIN havale h ON h.shomare_havale_anbar=T.shomare_havale_anbar AND h.code_ostan=T.code_ostan AND h.code_anbar=T.code_anbar AND h.year=T.year","T.code_ostan=".$row_ostan['code_ostan']." AND T.code_anbar=".$row_anbar['code_anbar']." AND T.year='$mtActiveYear' AND T.code_kala=".$row_kala['code_kala']." AND h.tarikh_havale_anbar='".$tarikh_shamsi."' AND T.havale_deleted=0 AND T.status=0 $Condition");     
	           $meghdarTadil_Ezafe=$db->get_from_where("SUM(meghdar_khales_tadil)","tadil_mojody T","code_ostan=".$row_ostan['code_ostan']." AND code_anbar=".$row_anbar['code_anbar']." AND year='$mtActiveYear' AND code_kala=".$row_kala['code_kala']." AND tarikh_barge_tadil='".$tarikh_shamsi."' AND noe_tadil=1 AND status=0 AND deleted=0 $Condition");     
		       $meghdarTadil_Kasry=$db->get_from_where("SUM(meghdar_khales_tadil)","tadil_mojody T","code_ostan=".$row_ostan['code_ostan']." AND code_anbar=".$row_anbar['code_anbar']." AND year='$mtActiveYear' AND code_kala=".$row_kala['code_kala']." AND tarikh_barge_tadil='".$tarikh_shamsi."' AND noe_tadil=2 AND status=0 AND deleted=0 $Condition");     
		       $mande=$mande_befor+$jameVarede-$jameSadere+$meghdarTadil_Ezafe-$meghdarTadil_Kasry;
		       echo'<td>'.round($mande,3).'</td>';
		     }
		     if($noe_namayesh==2)//حالت ناخالص
		     {
		       $mojody_aval=$db->get_from_where("SUM(mojody_nakhales_aval)","meat.mojody_kala T","year='$mtActiveYear' AND code_ostan=".$row_ostan['code_ostan']." AND code_anbar=".$row_anbar['code_anbar']." AND T.code_kala=".$row_kala['code_kala']." AND deleted=0 $Condition");     
	           $jameKhalesVarede_befor=$db->get_from_where("SUM(vazn_nakhales_r_d_sub)","meat.resid_kala_detail T INNER JOIN meat.resid r ON T.shomare_resid=r.shomare_resid AND T.code_ostan=r.code_ostan AND T.code_anbar=r.code_anbar AND T.year=r.year","T.year='$mtActiveYear' AND T.code_ostan=".$row_ostan['code_ostan']." AND T.code_anbar=".$row_anbar['code_anbar']." AND T.code_kala=".$row_kala['code_kala']." AND T.resid_deleted=0 AND T.status=0 AND r.status=0 AND r.tarikh_resid<'".$tarikh_shamsi."' $Condition");
               $jameKhalesSadere_befor=$db->get_from_where("SUM(vazn_nakhales_h_d)","meat.havale_detail T INNER JOIN meat.havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year","T.year='$mtActiveYear' AND T.code_ostan=".$row_ostan['code_ostan']." AND T.code_anbar=".$row_anbar['code_anbar']." AND T.code_kala=".$row_kala['code_kala']." AND T.havale_deleted=0 AND T.status=0 AND h.status=0 AND h.tarikh_havale_anbar<'".$tarikh_shamsi."' $Condition");	
	           $KhalesTadil_Ezafe_befor=$db->get_from_where("SUM(meghdar_nakhales_tadil)","meat.tadil_mojody T","year='$mtActiveYear' AND code_ostan=".$row_ostan['code_ostan']." AND T.code_anbar=".$row_anbar['code_anbar']." AND T.code_kala=".$row_kala['code_kala']." AND tarikh_barge_tadil<'".$tarikh_shamsi."' AND noe_tadil=1 AND deleted=0 AND status=0 $Condition");     
	           $KhalesTadil_Kasry_befor=$db->get_from_where("SUM(meghdar_nakhales_tadil)","meat.tadil_mojody T","year='$mtActiveYear' AND code_ostan=".$row_ostan['code_ostan']." AND T.code_anbar=".$row_anbar['code_anbar']." AND T.code_kala=".$row_kala['code_kala']." AND tarikh_barge_tadil<'".$tarikh_shamsi."' AND noe_tadil=2 AND deleted=0 AND status=0 $Condition");     
	           $mande_befor=$mojody_aval+$jameKhalesVarede_befor-$jameKhalesSadere_befor+$KhalesTadil_Ezafe_befor-$KhalesTadil_Kasry_befor;	      
		       //echo'<td>'.round($mande_befor,3).'</td>';
		       $jameVarede=$db->get_from_where("SUM(vazn_nakhales_r_d_sub)","resid_kala_detail T INNER JOIN resid r ON r.shomare_resid=T.shomare_resid AND r.code_ostan=T.code_ostan AND r.code_anbar=T.code_anbar AND r.year=T.year","T.code_ostan=".$row_ostan['code_ostan']." AND T.code_anbar=".$row_anbar['code_anbar']." AND T.year='$mtActiveYear' AND T.code_kala=".$row_kala['code_kala']." AND r.tarikh_resid='".$tarikh_shamsi."' AND T.resid_deleted=0 AND T.status=0 $Condition");     
	           $jameSadere=$db->get_from_where("SUM(vazn_nakhales_h_d)","havale_detail T INNER JOIN havale h ON h.shomare_havale_anbar=T.shomare_havale_anbar AND h.code_ostan=T.code_ostan AND h.code_anbar=T.code_anbar AND h.year=T.year","T.code_ostan=".$row_ostan['code_ostan']." AND T.code_anbar=".$row_anbar['code_anbar']." AND T.year='$mtActiveYear' AND T.code_kala=".$row_kala['code_kala']." AND h.tarikh_havale_anbar='".$tarikh_shamsi."' AND T.havale_deleted=0 AND T.status=0 $Condition");  
		       $meghdarTadil_Ezafe=$db->get_from_where("SUM(meghdar_nakhales_tadil)","tadil_mojody T","code_ostan=".$row_ostan['code_ostan']." AND code_anbar=".$row_anbar['code_anbar']." $Condition AND year='$mtActiveYear' AND code_kala=".$row_kala['code_kala']." AND tarikh_barge_tadil='".$tarikh_shamsi."' AND noe_tadil=1 AND status=0 AND deleted=0 $Condition");     
		       $meghdarTadil_Kasry=$db->get_from_where("SUM(meghdar_nakhales_tadil)","tadil_mojody T","code_ostan=".$row_ostan['code_ostan']." AND code_anbar=".$row_anbar['code_anbar']." $Condition  AND year='$mtActiveYear' AND code_kala=".$row_kala['code_kala']." AND tarikh_barge_tadil='".$tarikh_shamsi."' AND noe_tadil=2 AND status=0 AND deleted=0 $Condition");     
		       $mande=$mande_befor+$jameVarede-$jameSadere+$meghdarTadil_Ezafe-$meghdarTadil_Kasry;
		       echo'<td>'.round($mande,3).'</td>';
		     }
		     if($noe_namayesh==3)//کارتن
		     {
		       $mojody_aval=$db->get_from_where("SUM(tedad_karton_aval)","meat.mojody_kala T","year='$mtActiveYear' AND code_ostan=".$row_ostan['code_ostan']." AND code_anbar=".$row_anbar['code_anbar']." AND T.code_kala=".$row_kala['code_kala']." AND deleted=0 $Condition");     
	           $jameKhalesVarede_befor=$db->get_from_where("SUM(tedad_karton_r_d_sub)","meat.resid_kala_detail T INNER JOIN meat.resid r ON T.shomare_resid=r.shomare_resid AND T.code_ostan=r.code_ostan AND T.code_anbar=r.code_anbar AND T.year=r.year","T.year='$mtActiveYear' AND T.code_ostan=".$row_ostan['code_ostan']." AND T.code_anbar=".$row_anbar['code_anbar']." AND T.code_kala=".$row_kala['code_kala']." AND T.resid_deleted=0 AND T.status=0 AND r.status=0 AND r.tarikh_resid<'".$tarikh_shamsi."' $Condition");
               $jameKhalesSadere_befor=$db->get_from_where("SUM(tedad_karton_h_d)","meat.havale_detail T INNER JOIN meat.havale h ON T.shomare_havale_anbar=h.shomare_havale_anbar AND T.code_ostan=h.code_ostan AND T.code_anbar=h.code_anbar AND T.year=h.year","T.year='$mtActiveYear' AND T.code_ostan=".$row_ostan['code_ostan']." AND T.code_anbar=".$row_anbar['code_anbar']." AND T.code_kala=".$row_kala['code_kala']." AND T.havale_deleted=0 AND T.status=0 AND h.status=0 AND h.tarikh_havale_anbar<'".$tarikh_shamsi."' $Condition");	
	           $KhalesTadil_Ezafe_befor=$db->get_from_where("SUM(tedad_karton_tadil)","meat.tadil_mojody T","year='$mtActiveYear' AND code_ostan=".$row_ostan['code_ostan']." AND T.code_anbar=".$row_anbar['code_anbar']." AND T.code_kala=".$row_kala['code_kala']." AND tarikh_barge_tadil<'".$tarikh_shamsi."' AND noe_tadil=1 AND deleted=0 AND status=0 $Condition");     
	           $KhalesTadil_Kasry_befor=$db->get_from_where("SUM(tedad_karton_tadil)","meat.tadil_mojody T","year='$mtActiveYear' AND code_ostan=".$row_ostan['code_ostan']." AND T.code_anbar=".$row_anbar['code_anbar']." AND T.code_kala=".$row_kala['code_kala']." AND tarikh_barge_tadil<'".$tarikh_shamsi."' AND noe_tadil=2 AND deleted=0 AND status=0 $Condition");     
	           $mande_befor=$mojody_aval+$jameKhalesVarede_befor-$jameKhalesSadere_befor+$KhalesTadil_Ezafe_befor-$KhalesTadil_Kasry_befor;	      
		       //echo'<td>'.virgul($mande_befor).'</td>';
		       $jameVarede=$db->get_from_where("SUM(tedad_karton_r_d_sub)","resid_kala_detail T INNER JOIN resid r ON r.shomare_resid=T.shomare_resid AND r.code_ostan=T.code_ostan AND r.code_anbar=T.code_anbar AND r.year=T.year","T.code_ostan=".$row_ostan['code_ostan']." AND T.code_anbar=".$row_anbar['code_anbar']." AND T.year='$mtActiveYear' AND T.code_kala=".$row_kala['code_kala']." AND r.tarikh_resid='".$tarikh_shamsi."' AND T.resid_deleted=0 AND T.status=0 $Condition");     
	           $jameSadere=$db->get_from_where("SUM(tedad_karton_h_d)","havale_detail T INNER JOIN havale h ON h.shomare_havale_anbar=T.shomare_havale_anbar AND h.code_ostan=T.code_ostan AND h.code_anbar=T.code_anbar AND h.year=T.year","T.code_ostan=".$row_ostan['code_ostan']." AND T.code_anbar=".$row_anbar['code_anbar']." AND T.year='$mtActiveYear' AND T.code_kala=".$row_kala['code_kala']." AND h.tarikh_havale_anbar='".$tarikh_shamsi."' AND T.havale_deleted=0 AND T.status=0 $Condition");  
		       $meghdarTadil_Ezafe=$db->get_from_where("SUM(tedad_karton_tadil)","tadil_mojody T","code_ostan=".$row_ostan['code_ostan']." AND code_anbar=".$row_anbar['code_anbar']." AND year='$mtActiveYear' AND code_kala=".$row_kala['code_kala']." AND tarikh_barge_tadil='".$tarikh_shamsi."' AND noe_tadil=1 AND status=0 AND deleted=0 $Condition");     
		       $meghdarTadil_Kasry=$db->get_from_where("SUM(tedad_karton_tadil)","tadil_mojody T","code_ostan=".$row_ostan['code_ostan']." AND code_anbar=".$row_anbar['code_anbar']." AND year='$mtActiveYear' AND code_kala=".$row_kala['code_kala']." AND tarikh_barge_tadil='".$tarikh_shamsi."' AND noe_tadil=2 AND status=0 AND deleted=0 $Condition");     
		       $mande=$mande_befor+$jameVarede-$jameSadere+$meghdarTadil_Ezafe-$meghdarTadil_Kasry;
		       echo'<td>'.virgul($mande).'</td>';
		     }
		
		}//END WHILE kala
	 	  	   $t2--;
			   if($t2==0) echo'';
			   else 
			   {
			    echo'</tr>';
			    if($k++%2)echo'<tr class="print_table-odd">';
                else echo'<tr class="print_table-even">';
			   }
		  
		  }//END WHILE anbar
		 	$t--;
			if($t==0) {echo''; break;}
			else 
			{
			   echo'</tr>';
			   if($j++%2)echo'<tr class="print_table-odd">';
               else echo'<tr class="print_table-even">';
			}	
		}//END WHILE ostan
		// echo'
		 // </tr>';
		$tarikh_milady=date('Y-m-d',strtotime("+1 day", strtotime($tarikh_milady)));//یکی به روز اضافه شود
	    if($line>=$MaxLines) 
		{
	     $line=0;
         $page++;
	     echo'
		 </table>
		   <br class="pbreak">';
		    print_header();
	    }	
     }//END while tarikh
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