<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="chart_manager_pie_grkala.php";
$ExcelFileName=str_replace('.php','',$FileName);
$titr='درصد موجودی گروه کالا در استان ';
require_once('head.html');
/****************هدر******************/
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
       $Condition_ostan_temp.=" ostan.code_ostan='$ostan_val' OR";
      }
      if($ostan_val==-1){$Condition_ostan.="1=1 OR";}
      else {$Condition_ostan.=" $Condition_ostan_temp";}
       $lastSpacePosition = strrpos($Condition_ostan," ");
       $Condition_ostan =substr($Condition_ostan,0,$lastSpacePosition);
     }
}
else 
{
 $Condition_ostan=' ostan.code_ostan='.$_SESSION['mt_code_ostan'].'';
}
/******************مالکیت انبارها******************/  
if(is_array($malekiyatchoice))
{
    foreach($malekiyatchoice as $key => $mal_val) 
    {
       $Condition_malekiyat_temp.=" T.noe_malekiyat='$mal_val' OR";
    }
    if($mal_val==-1){$Condition_malekiyat.="1=1 OR";}
    else {$Condition_malekiyat.=" $Condition_malekiyat_temp";}
    $lastSpacePosition = strrpos($Condition_malekiyat," ");
    $Condition_malekiyat =substr($Condition_malekiyat,0,$lastSpacePosition);
}
/******************گروه کالا******************/
$Condition_GrKala='AND code_group_kala_top='.$code_group_kala_top.'';
/******************نمایش یا عدم نمایش انبارهای موقت******************/
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
	 <td align="left"><input type="checkbox" name="chkmovaghat"/></td><td align="right">&nbsp; نمایش اطلاعات انبار موقت</td>
	 <td align="left"><input type="checkbox" name="chkactivate"/></td><td align="right">&nbsp; نمایش اطلاعات انبارهای غیرفعال</td>
	</tr>
	<tr class="tr1" style="height:45px">
	 <td align="left"><span class="star">*</span> گروه کالا : </td>
     <td align="right" >&nbsp;
      '.listbox("code_group_kala_top",$code_group_kala_top,"code_group_kala_top","name_group_kala_top","bzacc.group_kala_top","group_type_top=2 ORDER BY code_group_kala_top ASC","class='easyui-combobox text4' style=width:120px data-options=panelHeight:190","").'  
	 </td>
	 <td align="left"> نمایش اطلاعات : </td><td align="right">&nbsp;'.static_listbox("noe_namayesh",$noe_namayesh,"namayeshArr",1,"class='easyui-combobox text4' style=width:100px data-options=panelHeight:94").'</td>	
	</tr>
	<tr class="tr1">	
	 <td align="left" style="height:45px">نوع مالکیت : </td>
	 <td align="right">
	 &nbsp;<select name="malekiyatchoice[]" class="easyui-combobox" style="width:150px;" data-options=panelHeight:155 multiple>';
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
	  <td align="left" style="height:45px">نام استان : </td>
      <td align="right" colspan="3">
	   &nbsp;<select name="ostanchoice[]" class="easyui-combobox" size="6" style="width:200px;" multiple >';
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
ELSE 
{	
 IF(!$code_group_kala_top){
	echo"<script>alert('لطفاً گروه کالا را انتخاب کنید !')</script>";
    echo"<script>window.location='$FileName';</script>";
 }
 
 $grKalaName='گروه کالا :';
 $grKalaName.=$db->get_from_where("name_group_kala_top","bzacc.group_kala_top","code_group_kala_top='$code_group_kala_top'");	
 /*سطر نمایش فیلترها*/ 
  if(($ostanchoice))
  {
	if($ostan_val==-1)$filter_string='همه استانها';
	else $filter_string=' استان : ';
    foreach($ostanchoice as $ostan_key => $ostan_val) {
	       $nameOstan=$db->get_from_where("name_ostan","ostan","code_ostan='$ostan_val'");
	       $filter_string.=''.$nameOstan.'&nbsp;-';
    }
  }
  if($chkmovaghat==TRUE) $filter_string.=' با اطلاعات سردخانه موقت -';
  if($chkmovaghat==False) $filter_string.=' بدون اطلاعات سردخانه موقت -';
  if($chkactivate==TRUE) $filter_string.=' با اطلاعات سردخانه غیرفعال ';
  if($chkactivate==False) $filter_string.=' بدون اطلاعات سردخانه غیرفعال ';
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
  if($noe_namayesh==1)  $filter_string.="- نمایش اطلاعات : خالص";
  if($noe_namayesh==2)  $filter_string.="- نمایش اطلاعات : ناخالص";
  if($noe_namayesh==3)  $filter_string.="- نمایش اطلاعات : تعداد";
	$sql_ostan="SELECT distinct(ostan.code_ostan),name_ostan FROM ostan 
	            INNER JOIN list_sardkhane T ON ostan.code_ostan=T.code_ostan
	            INNER JOIN mojody_kala m_k ON m_k.code_ostan=T.code_ostan AND m_k.code_anbar=T.code_anbar  
	            WHERE  $Condition_movaghat $Condition_anbar_activate_ostan AND ($Condition_malekiyat) AND($Condition_ostan) AND year=$mtActiveYear ORDER BY name_ostan";
	$result_ostan = mysql_query($sql_ostan);
	IF(mysql_num_rows($result_ostan)>0)//وجود داشتن
	{
	 WHILE($row_ostan = mysql_fetch_assoc($result_ostan)) 
	 {
	  $containerID='container'.$row_ostan['code_ostan'];
	  echo'
      <img src="images/loading.gif" id="loading" class="loading_img"/>
	  <div style="width: 99%; margin: 0 auto; background-color: white;">
	   <button class="buttonme hideatprint" onClick="window.location=\''.$FileName.'\'">بازگشت</button>
	   <span>فیلتر شده براساس : '.$filter_string.'</span>
	  </div>
      <div id="'.$containerID.'" style="width: 99%; height: 600px; margin: 0 auto"></div>
	  <br class="pbreak">';
	 }
	}//END IF //وجود داشتن
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
<script type="text/javascript" src="scripts/highcharts/highcharts.js"></script>
<script type="text/javascript" src="scripts/highcharts/modules/exporting.js"></script>
<script type="text/javascript">
$(function () {
 $(document).ready(function () {	
    // Radialize the colors
        Highcharts.getOptions().colors = Highcharts.map(Highcharts.getOptions().colors, function (color) {
            return {
                radialGradient: {
                    cx: 0.5,
                    cy: 0.3,
                    r: 0.7
                },
                stops: [
                    [0, color],
                    [1, Highcharts.Color(color).brighten(-0.3).get('rgb')] // darken
                ]
            };
        });
		<?php
		  $result_ostan = mysql_query($sql_ostan);
          WHILE($row_ostan = mysql_fetch_assoc($result_ostan)) 
          {
	       IF(($_SESSION['mt_all_ostan']==1)or(SuperUser())) $ostanName='(استان : '.$row_ostan['name_ostan'].')';
	       ELSE  $ostanName='(استان : '.$mt_gl_name_ostan.')';
	       $containerID='container'.$row_ostan['code_ostan'];
		?>
	    $('#<?php echo $containerID ?>').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie',
				style: {
						font: '12px yekan',
						direction: "ltr"
                    }
            },
            title: {
                text: '<?php echo $titr.'<br>'.$ostanName.' -('.$grKalaName.')' ?>',
            },
            tooltip: {
                pointFormat: ' <b>%{point.percentage:.0f}</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                     enabled: true,
                     format: '<b>{point.name}</b> درصد: % {point.percentage:.0f}',
                     style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                     }
                    },
                    showInLegend: true
                }
            },
            series: [{
		    	 colorByPoint: true,
				 <?php
	             IF(($_SESSION['mt_all_ostan']==1)or(SuperUser()))$sql_anbar = "SELECT  T.code_anbar,T.name_anbar,T.zarfiyat FROM list_sardkhane T WHERE $Condition_movaghat $Condition_anbar_activate ($Condition_malekiyat) AND code_ostan=".$row_ostan['code_ostan']." ORDER BY name_anbar";
	             ELSE $sql_anbar = "SELECT T.code_anbar,T.name_anbar,T.zarfiyat FROM user_ostan_anbar INNER JOIN list_sardkhane T ON T.code_ostan=user_ostan_anbar.code_ostan AND T.code_anbar=user_ostan_anbar.code_anbar WHERE $Condition_movaghat $Condition_anbar_activate ($Condition_malekiyat) AND T.code_ostan=".$row_ostan['code_ostan']." AND user_id=".$_SESSION['mt_user_id']." ORDER BY name_anbar";
	             $result_anbar = mysql_query($sql_anbar);
	             WHILE($row = mysql_fetch_assoc($result_anbar)) {
				?>
				name:'<?php echo $row['name_anbar']?>',
				<?php }?>//END WHILE
                
                data: [
				<?php
	             $result_anbar = mysql_query($sql_anbar);
	             WHILE($row = mysql_fetch_assoc($result_anbar)) {
				  IF($noe_namayesh==1){$avalField='mojody_khales_aval';$residField='vazn_khales_r_d_sub';$havaleField='vazn_khales_h';$tadilField='meghdar_khales_tadil';}
	              ELSE IF($noe_namayesh==2){$avalField='mojody_nakhales_aval';$residField='vazn_nakhales_r_d_sub';$havaleField='vazn_nakhales_h';$tadilField='meghdar_nakhales_tadil';}
	              ELSE IF($noe_namayesh==3){$avalField='tedad_karton_aval';$residField='tedad_karton_r_d_sub';$havaleField='tedad_karton_h';$tadilField='tedad_karton_tadil';}
				  
				  $mojodyAval=$db->get_from_where("SUM($avalField)","mojody_kala T INNER JOIN kala ON T.code_kala=kala.code_kala","code_ostan=".$row_ostan['code_ostan']." AND code_anbar=".$row['code_anbar']." $Condition_GrKala  AND year='$mtActiveYear' AND deleted=0");        		 
	              $jameVarede=$db->get_from_where("SUM($residField)","meat.resid_kala_detail T INNER JOIN meat.resid r ON T.shomare_resid=r.shomare_resid AND T.code_ostan=r.code_ostan AND T.code_anbar=r.code_anbar AND T.year=r.year INNER JOIN meat.kala ON T.code_kala=kala.code_kala","T.code_ostan=".$row_ostan['code_ostan']." AND T.code_anbar=".$row['code_anbar']." $Condition_GrKala AND T.year='$mtActiveYear' AND r.deleted=0 AND r.status=0 AND tarikh_resid<='$date2'");
	              $jameSadere=$db->get_from_where("SUM($havaleField)","havale T INNER JOIN kala ON T.code_kala=kala.code_kala","code_ostan=".$row_ostan['code_ostan']." AND code_anbar=".$row['code_anbar']." $Condition_GrKala AND year='$mtActiveYear' AND deleted=0 AND status=0 AND tarikh_havale_anbar<='$date2'");
	              $meghdarTadil_Ezafe=$db->get_from_where("SUM($tadilField)","tadil_mojody T INNER JOIN kala ON T.code_kala=kala.code_kala","noe_tadil=1 AND code_ostan=".$row_ostan['code_ostan']." AND code_anbar=".$row['code_anbar']." $Condition_GrKala AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil<='$date2'");
	              $meghdarTadil_Kasry=$db->get_from_where("SUM($tadilField)","tadil_mojody T INNER JOIN kala ON T.code_kala=kala.code_kala","noe_tadil=2 AND code_ostan=".$row_ostan['code_ostan']." AND code_anbar=".$row['code_anbar']." $Condition_GrKala AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil<='$date2'");
	              $mojody=$mojodyAval+$jameVarede-$jameSadere+$meghdarTadil_Ezafe-$meghdarTadil_Kasry;
				  $mojody=round($mojody,3);
				?>
				{
				  name:'<?php echo $row['name_anbar'].' : ('.($mojody).')' ?>',
				  y:<?php echo $mojody ?> ,
				},

				<?php }?>//END WHILE
				]			
			}]

        });
		<?php } ?>
 });
});
</script>