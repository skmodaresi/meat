<?php
require_once __DIR__ . '/mysql_compat.php';
session_start();
error_reporting(0);
include ("config.php");
foreach($_POST as $k=>$v) ${$k}=$v;
foreach($_GET as $k=>$v) ${$k}=$v;
if (!PassTru()) echo "<script>parent.location.href='mainpage.php'</script>";
$FileName="chart_manager_zarfiyat.php";
$ExcelFileName=str_replace('.php','',$FileName);
$titr='نمودار ظرفیت اسمی و موجودی سردخانه ها';
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
       $Condition_ostan_temp.=" code_ostan='$ostan_val' OR";
      }
      if($ostan_val==-1){$Condition_ostan.="1=1 OR";}
      else {$Condition_ostan.=" $Condition_ostan_temp";}
       $lastSpacePosition = strrpos($Condition_ostan," ");
       $Condition_ostan =substr($Condition_ostan,0,$lastSpacePosition);
     }
}
else 
{
 $Condition_ostan=' code_ostan='.$_SESSION['mt_code_ostan'].'';
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
	 <td align="left"><input type="checkbox" name="chkmovaghat"/></td><td align="right">&nbsp; نمایش اطلاعات سردخانه موقت</td>
	 <td align="left"><input type="checkbox" name="chkactivate"/></td><td align="right">&nbsp; نمایش اطلاعات سردخانه های غیرفعال</td>
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
	  </td>
	';
	if(($_SESSION['mt_all_ostan']==1)or(SuperUser()))
	{
	 echo'
	  <td align="left" style="height:45px">نام استان : </td>
      <td align="right">
	   &nbsp;<select name="ostanchoice[]" class="easyui-combobox" size="6" style="width:200px;" multiple >';
	   $result_ostan = $db->query("SELECT * FROM ostan ORDER BY name_ostan");
       $ostan_options = "<option value='-1' selected>همه استانها</option>";
       while($row_ostan=$db->fetch_assoc($result_ostan)) $ostan_options .= "<option value=".$row_ostan['code_ostan'].">".$row_ostan['name_ostan']."</option>";
	   echo $ostan_options;
	   echo'
	   </select>      
	  </td>
	 </tr>';
	}
	else echo'<td colspan="3"></td>';
	echo'
	<tr class="footer"><td colspan="4" align="center"><input class="buttonme" type="submit" name="ok" value="شروع گزارش"></td>	</tr> 
   </table>
  </td>
 </tr>
</table> ';
}
else 
{
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
	$sql_ostan="SELECT * FROM ostan WHERE code_ostan IN(SELECT code_ostan FROM list_sardkhane T WHERE $Condition_movaghat $Condition_anbar_activate_ostan AND ($Condition_malekiyat)) AND($Condition_ostan) ORDER BY name_ostan";
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
 <?php
  $result_ostan = mysql_query($sql_ostan);
  WHILE($row_ostan = mysql_fetch_assoc($result_ostan)) 
  {
	IF(($_SESSION['mt_all_ostan']==1)or(SuperUser())) $ostanName='(استان : '.$row_ostan['name_ostan'].')';
	ELSE  $ostanName='(استان : '.$mt_gl_name_ostan.')';
	$containerID='container'.$row_ostan['code_ostan'];
 	 $zarfiyatArray = array();
	 $mojodyArray=array();
	 $anbarnameArray=array();
	 IF(($_SESSION['mt_all_ostan']==1)or(SuperUser()))$sql_anbar = "SELECT  T.code_anbar,T.name_anbar,T.zarfiyat FROM list_sardkhane T WHERE $Condition_movaghat $Condition_anbar_activate ($Condition_malekiyat) AND code_ostan=".$row_ostan['code_ostan']." ORDER BY name_anbar";
	 ELSE $sql_anbar = "SELECT T.code_anbar,T.name_anbar,T.zarfiyat FROM user_ostan_anbar INNER JOIN list_sardkhane T ON T.code_ostan=user_ostan_anbar.code_ostan AND T.code_anbar=user_ostan_anbar.code_anbar WHERE $Condition_movaghat $Condition_anbar_activate ($Condition_malekiyat) AND T.code_ostan=".$row_ostan['code_ostan']." AND user_id=".$_SESSION['mt_user_id']." ORDER BY name_anbar";
	 $result_anbar = mysql_query($sql_anbar);
	 WHILE($row = mysql_fetch_assoc($result_anbar)) 
	 {
	  $mojodyAval=$db->get_from_where("SUM(mojody_khales_aval)","mojody_kala","code_ostan=".$row_ostan['code_ostan']." AND code_anbar=".$row['code_anbar']." AND year='$mtActiveYear' AND deleted=0");        	
      $jameVarede=$db->get_from_where("SUM(vazn_khales_r)","resid","code_ostan=".$row_ostan['code_ostan']." AND code_anbar=".$row['code_anbar']."  AND year='$mtActiveYear' AND deleted=0 AND status=0 AND tarikh_resid<='$date2'");
      $jameSadere=$db->get_from_where("SUM(vazn_khales_h)","havale","code_ostan=".$row_ostan['code_ostan']." AND code_anbar=".$row['code_anbar']." AND year='$mtActiveYear' AND deleted=0 AND status=0 AND tarikh_havale_anbar<='$date2'");
      $meghdarTadil_Ezafe=$db->get_from_where("SUM(meghdar_khales_tadil)","tadil_mojody","noe_tadil=1 AND code_ostan=".$row_ostan['code_ostan']." AND code_anbar=".$row['code_anbar']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil<='$date2'");
      $meghdarTadil_Kasry=$db->get_from_where("SUM(meghdar_khales_tadil)","tadil_mojody","noe_tadil=2 AND code_ostan=".$row_ostan['code_ostan']." AND code_anbar=".$row['code_anbar']." AND year='$mtActiveYear' AND deleted=0  AND status=0 AND tarikh_barge_tadil<='$date2'");
      $mojody=$mojodyAval+$jameVarede-$jameSadere+$meghdarTadil_Ezafe-$meghdarTadil_Kasry;			
      array_push($zarfiyatArray,(int)$row['zarfiyat']);
      array_push($mojodyArray,(float)$mojody);
      array_push($anbarnameArray,$row['name_anbar']); 
     }
     $zarfiyat = json_encode($zarfiyatArray);
     $mojody = json_encode($mojodyArray);
     $anbarname = json_encode($anbarnameArray);

 ?>	
	$('#<?php echo $containerID ?>').highcharts({
        chart: {
            type: 'column',
			style: {
					fontFamily: 'yekan',	
					direction: "ltr"
                    }
        },
		legend: {
            layout: 'vertical',
            backgroundColor: '#FFFFFF',
            floating: true,
            align: 'left',
			y:-10,
            verticalAlign: 'top',
			padding:2,
			symbolPadding: 0,
            symbolWidth: 30,
			width:145,
			// rtl:true,
			shadow :true,
            borderWidth:1	           			
        },
        title: {
            text: '<?php echo $titr.$ostanName ?>',
			style: {
                color: '#000',
                fontSize: '16px'  
             }
        },
        xAxis: {
            categories: <?php echo $anbarname; ?>,
            crosshair: true,
	        labels: {
              style: {
                color: '#000',
                fontSize: '12px'  
             }
			}
        },
        yAxis: {
            min: 0,
            tickInterval: 1000000,
			title: {
                text: 'ظرفیت اسمی و واقعی (کیلوگرم)',
		    style: {
                color: '#000',
                fontSize: '14px'    
             }
            },
		    labels: {
              style: {
                color: '#000',
                fontSize: '12px',
                fontWeight: 'bold'
             }
			}
        },
        tooltip: {
            headerFormat: '<span style="font-family: "Yekan"; font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.2f} </b>kg</td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
		},

		plotOptions: {
            column: {
				pointPadding: 0.2,
                borderWidth: 0,
				dataLabels:{
					enabled: true,
                    format: '{point.y:,.2f}',
					//formatter: function () {return Highcharts.numberFormat(this.y,2);}
					rotation:0,
                    color:"black",
                    style: {
                        fontSize: "6pt"
					}
				}
            },
			series: {
               pointPadding: 0			   
            }
        },
        series: [{
            name: 'ظرفیت اسمی سردخانه',
			color: '#1D4162',
            data: <?php echo $zarfiyat; ?>
        },
		{
            name: 'موجودی سردخانه',
            data: <?php echo $mojody; ?>
        }
		]
    });
 <?php } ?>
});
</script>