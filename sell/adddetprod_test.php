 <script type="text/javascript" src="lib/js/general.js"></script>
 <script type="text/javascript" language="" src="lib/js/jquery-1.2.6.min.js"></script>
<?php
require_once __DIR__ . '/../mysql_compat.php';
 header('Content-Type: text/html; charset=UTF-8');

include_once 'lib/php/gen_def.php';
include_once 'lib/php/general_aj.php';
include_once 'lib/php/body.php';
//include_once 'lib/php/Pfactor_mgmt.php';
include_once 'lib/php/jdf.php';
?>
<html>
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <script type="text/javascript" src="jquery-1.2.3.pack.js"></script>
  
</head>
<?php 
	//connect
	
$myconn = mysql_connect( "localhost" , "user" , "xlsdj@#@aHdF");
			mysql_query("SET NAMES 'utf8'",$myconn);
			mysql_select_db("meat",$myconn) or die("Can Not Select DataBase Because: ".
			mysql_error());


 $phd_id = isset($_REQUEST['phd_id']) ? $_REQUEST['phd_id'] : 'phd_id';
    $pg1 = isset($_REQUEST['pg1']) ? $_REQUEST['pg1'] : 'prodMgmtPg';
    $cmd1 = isset($_REQUEST['cmd1']) ? $_REQUEST['cmd1'] : 'searchproductanbar';
    $province_id = isset($_REQUEST['province_id']) ? $_REQUEST['province_id'] : ''; 
  $_SESSION['province_id']= $province_id;
	$outHtml2 = '<br>
		<form method="get" action="searchCus.php">
			<input type="hidden" name="pg1" value="prodMgmtPg">   
			<input type="hidden" name="cmd1" value="searchproductanbar"> 
			 نام ويا کد کالا را وارد کنيد 
			<div> <input type="text" name="search"  style="width: 60px;"/> 
			<button type="submit" name="Search" value="Search" >جستجو</button></div>
		</form>
	';
	switch ($pg1){
		
		case 'prodMgmtPg':
			switch($cmd1){
				case 'searchproductanbar':
				  $_SESSION['srchStr'] = isset($_REQUEST['search']) ? $_REQUEST['search'] : $_SESSION['srchStr'];
					searchproductanbar($phd_id);
				//	$_SESSION['srchStr']='';
					break;
			}
			break;
	}
	

function searchproductanbar($phd_id){
	
$phd_id = isset($_REQUEST['phd_id']) ? $_REQUEST['phd_id'] : 'phd_id';
//echo $phd_id;

	$query1="SELECT * FROM sell.dm_pish_havale_det WHERE phd_id=".$phd_id."   ";
										        
			$lnk1 = mysql_query($query1);
			$row1 = mysql_fetch_assoc($lnk1);
				
	$query2="SELECT * FROM sell.dm_location_goods WHERE l_id=".$row1['phd_l_id']."
										           ";
										
									//	print $querych;
										$lnk2 = mysql_query($query2);
										$row2 = mysql_fetch_assoc($lnk2);	
										$phd_pid=$row1['phd_pid'];
										$phd_id_province=$row1['phd_id_province'] ; 
										$l_code= $row2['l_code'];
											
				?>
	
	<style>
	
	table.list{
       width:100%;
       margin-top:5px;
       padding-top:20px;
       border:0px solid #BBB;
       margin-top:20px;
      
     
}

.wrapper {
	background-color: #CCFFFF;
	width: 400px;
	height: 20px;
	overflow: auto;
}

.md_developer table.list{
       margin:2px 0 0 0;
       
}


table.list tr.frstRw{
       background-color:#EEF;
       
}

table.list tr.frstRw td{
       text-align:center;
       vertical-align:middle;
       
}

table.list tr td.tls{/*Tools*/
       text-align:center;
       vertical-align:middle;
      
}

table.list tr td.chk{/*CheckBox Column*/
       text-align:center;
       vertical-align:middle;
}

table.list tr.rw1, r1{
       background-color:#FFFFFF ;
       vertical-align:middle;
}
table.list textarea, select, input.chk{
 border:1px solid #DDD;
 width:50%;

}
table.list tr.rw0, r0{
       background-color:#BBF0F7 ;
       vertical-align:middle;
}
/*baraye hover table*/
table.list tr.rw1:hover,table.list tr.rw0:hover{
       background-color:#B1C9D5;
}

table.list tr.gry{
       background-color:#DDD;
}
table.list{
       width:100%;
       margin-top:5px;
       border:0px solid #BBB;
       -moz-border-radius: 20px; 
         
}
				                      
	}

	</style>
	
	<?php 
	
	if(isset($_REQUEST['cmd2'])){
		switch ($_REQUEST['cmd2']){
			case 'setPg':
				$_SESSION['crntPage'] = (int)($_REQUEST['pgNum']);
				break;
				
			case 'setRPP':
				$_SESSION['rPP'] = (int)($_REQUEST['rPP']);
				$_SESSION['crntPage'] = 1;
				break;				
		}
	}
		
	$outHtml= '	<form method="get" action=".php">
					<input type="hidden" name="pg1" value="prodMgmtPg">   
					<input type="hidden" name="cmd1" value="">
					<input type="hidden" name="province_id" value="'.$_SESSION['province_id'].'">
		<div align = "center">
		<div align = "center" style="height:400px; overflow:auto">
		<table width="1312" border="1" align="center" bgcolor="#99CCCC"  cellpadding="0" cellspacing="0"  class="list"  >
  <tr>
    <td height="24" colspan="4" bordercolor="#000000" bgcolor="#99CCCC"><div align="center" class="style1">مقادیر مورد نظر </div></td>
    <td height="24" colspan="3" bgcolor="#99CCCC"><div align="center" class="style1">مقادیر فروخته شده </div></td>
    <td colspan="3" bgcolor="#99CCCC"><div align="center" class="style1">مقادیر موجود در سردخانه </div></td>
    <td width="69" rowspan="2" bgcolor="#99CCCC"><span class="style1">وزن کارتن </span></td>
    <td colspan="3" bgcolor="#99CCCC"><div align="center" class="style1">تاریخ تولید </div></td>
    <td width="80" rowspan="2" bgcolor="#99CCCC"><div align="center" class="style1">تولید کننده </div></td>
    <td width="71" rowspan="2" bgcolor="#99CCCC"><div align="center" class="style1">کشور</div></td>
    <td width="67" rowspan="2" bgcolor="#99CCCC"><div align="center" class="style1">زیر انبار </div></td>
    <td width="48" rowspan="2" bgcolor="#99CCCC"><div align="center" class="style1">ردیف</div></td>
  </tr>
  <tr>
  <td width="106" bgcolor="#99CCCC">&nbsp;</td>
    <td width="106" bgcolor="#99CCCC"><div align="center" class="style1">وزن خالص </div></td>
    <td width="90" bgcolor="#99CCCC"><div align="center" class="style1">وزن ناخالص </div></td>
    <td width="71" bgcolor="#99CCCC"><div align="center">تعداد</div></td>
    <td width="90" bgcolor="#99CCCC"><div align="center" class="style1">خالص</div></td>
    <td width="86" bgcolor="#99CCCC"><div align="center" class="style1">ناخالص</div></td>
    <td width="65" bgcolor="#99CCCC"><div align="center" class="style1">تعداد</div></td>
    <td width="86" bgcolor="#99CCCC"><div align="center" class="style1">موجودی خالص </div></td>
    <td width="92" bgcolor="#99CCCC"><div align="center" class="style1">موجودی ناخالص </div></td>
    <td width="46" bgcolor="#99CCCC"><div align="center" class="style1">تعداد</div></td>
    <td width="44" bgcolor="#99CCCC"><div align="center" class="style1">روز</div></td>
    <td width="46" bgcolor="#99CCCC"><div align="center" class="style1">ماه</div></td>
    <td width="49" bgcolor="#99CCCC"><div align="center" class="style1">سال</div></td>
  </tr>
				</form>
	';
	   

//		print 	$queryp;
	
	if(!isset($_SESSION['srchStr'])) $_SESSION['srchStr'] = '';
	if(!isset($_SESSION['elmCount'])) $_SESSION['elmCount'] = 0;
	if(!isset($_SESSION['rPP'])) $_SESSION['rPP'] = 10;//results per page
	if(!isset($_SESSION['pageCount'])) $_SESSION['pageCount'] = 1;//results page conut
	if(!isset($_SESSION['crntPage'])) $_SESSION['crntPage'] = 1;//current page number
	if($_SESSION['srchStr']==''){
		$srchQ = "";
		
	}else{
		    $_SESSION['srchStr']=str_replace("ی","ي",$_SESSION['srchStr']);
		    $_SESSION['srchStr']=str_replace("ک","ك",$_SESSION['srchStr']);
		$srchQ = " 
			AND(   
					p_code = '".$_SESSION['srchStr']."' 
				OR 
					p_name LIKE '%".$_SESSION['srchStr']."%' 
				
			)
		";		
	}
	$typeQ = '';
	
	$genQuery = "
		
		 mojody_kala.*,kala.name_kala,keshvar.name_keshvar,tolidkonande.name_tolidkonande,l_s_d.noe_ziranbar,l_s_d.name_ziranbar,karton.vazn_karton From mojody_kala
          INNER JOIN kala ON mojody_kala.code_kala=kala.code_kala
          INNER JOIN keshvar ON mojody_kala.code_keshvar=keshvar.code_keshvar
          LEFT JOIN karton ON mojody_kala.code_karton=karton.code_karton 
          INNER JOIN tolidkonande ON mojody_kala.code_tolidkonande=tolidkonande.code_tolidkonande
          INNER JOIN list_sardkhane_detail l_s_d ON mojody_kala.code_ziranbar=l_s_d.code_ziranbar AND mojody_kala.code_ostan=l_s_d.code_ostan AND mojody_kala.code_anbar=l_s_d.code_anbar  	  
	      WHERE mojody_kala.code_kala='". $row1['phd_pid'] ."' AND mojody_kala.code_ostan='". $row1['phd_id_province'] ."'  AND  mojody_kala.code_anbar='". $row2['l_code'] ."'  AND mojody_kala.year='1396' AND mojody_kala.deleted=0 
	      
					
		".$srchQ." 
		".$typeQ."
		
		 order by sal_tolid_shamsi,mah_tolid_shamsi,rouz_tolid_shamsi asc ";	
	
	$countQuery = "
		SELECT 
			COUNT(*) elmCount  
	".$genQuery;
	echo $genQuery;
	$lnk = mysql_query($countQuery);
	$cntRow = mysql_fetch_assoc($lnk);
	$_SESSION['elmCount'] = $cntRow['elmCount'];
	
	$pageCount = ($_SESSION['elmCount']/$_SESSION['rPP']);
	if($pageCount != (int)($pageCount)) $pageCount++;
	$pageCount = (int) $pageCount;
	$_SESSION['pageCount'] = $pageCount; 
	
	$limitQ = " LIMIT ".((($_SESSION['crntPage']-1)*$_SESSION['rPP'])).', '.$_SESSION['rPP'];
	
	$resQuery = "
		SELECT 
			
	".$genQuery.$limitQ;
	//print($resQuery);
		//$_SESSION['srchStr'] = '';
	$lnk = mysql_query($resQuery);
	$inx = ((($_SESSION['crntPage']-1)*$_SESSION['rPP'])+1);
		
	if(mysql_affected_rows()>0){
	$inx--;
		while($row = mysql_fetch_assoc($lnk)){
			
			if(($inx)%2==1){
				$class="rw1";
				$edit='edit';
				$delete='delete';
			
			}
				else{
					$edit='edit1';
				    $class="rw0";
				    $delete='delete1';
				}

 /*****ماه شمسی*****/
  $mahshamsiArr = array (
  0 =>'انتخاب کنيد',
  1 =>'فروردین',  
  2 =>'اردیبهشت',
  3 =>'خرداد',
  4 =>'تیر',
  5 =>'مرداد',
  6 =>'شهریور',
  7 =>'مهر',
  8 =>'آبان',
  9 =>'آذر',
  10 =>'دی',
  11 =>'بهمن',
  12 =>'اسفند'
  );
				
	$tedad_karton=mojodyKarton($row['code_ostan'],$row['code_anbar'],$row['year'],$row['code_ziranbar'],$row['code_kala'],$row['code_keshvar'],$row['code_tolidkonande'],$row['sal_tolid_shamsi'],$row['mah_tolid_shamsi'],$row['rouz_tolid_shamsi'],$row['code_karton']);
	$mojody_nakhales=mojodyNakhales($row['code_ostan'],$row['code_anbar'],$row['year'],$row['code_ziranbar'],$row['code_kala'],$row['code_keshvar'],$row['code_tolidkonande'],$row['sal_tolid_shamsi'],$row['mah_tolid_shamsi'],$row['rouz_tolid_shamsi'],$row['code_karton']);
    $mojody_khales=mojodyKhales($row['code_ostan'],$row['code_anbar'],$row['year'],$row['code_ziranbar'],$row['code_kala'],$row['code_keshvar'],$row['code_tolidkonande'],$row['sal_tolid_shamsi'],$row['mah_tolid_shamsi'],$row['rouz_tolid_shamsi'],$row['code_karton']);				
	//fieldhaye feresttadani
	
		$dad_anbar_id=$row['id'];
		$dad_phd_id=$phd_id;
		$vaznkarton=$row['vazn_karton_this'];
	
		
			$queryanbar="SELECT * FROM sell.dm_anbar_det_new WHERE dad_anbar_id=".$dad_anbar_id."
			
			              and  dad_phd_id=".$dad_phd_id."";
			
			
		    	$lnkanbar = mysql_query($queryanbar);
		    	$rowanbar=mysql_fetch_assoc($lnkanbar);
		
 //print $queryanbar;
    	if(mysql_num_rows($lnkanbar)>0){ 
			
	    		$Display2='none';
	    		$Display1='block';	    		
	    	}else{
	    	
	    	    $Display2='block';
	    		$Display1='none';		
	    		
	    	}
		
		//if($tedad_karton !=0){
		
				
			$outHtml .= '
				<tr>
				    <td>
				    <span id="ezaf_'.$dad_anbar_id.'"   style="cursor:pointer;display:'.$Display2. ';"         onclick="AddAdetanbar(\'\', \''.$phd_id.'\', \''.$dad_anbar_id.'\', \''.$vaznkarton.'\', \''.$tedad_karton.'\') " this.style.display=\'none\'"><img src="images/ok.png" border="0" align="center" style="height:20px;width=20px;"></img></span>
				    <span id="kam_'.$dad_anbar_id.'"    style="cursor:pointer;display:'.$Display1. ';"         onclick="delAdetanbar(\'\', \''.$phd_id.'\', \''.$dad_anbar_id.'\') " this.style.display=\'none\'"><img src="images/del.png" border="0" align="center"  style="height:20px;width=20px;"></img></span>
				    </td>
				    <td><input name="dad_vazn_kh_'.$dad_anbar_id.'"   id="dad_vazn_kh_'.$dad_anbar_id.'"  value="'.$rowanbar['dad_vazn_kh'].'" type="text"  /></td>
				    <td><input name="dad_vazn_n_'.$dad_anbar_id.'"    id="dad_vazn_n_'.$dad_anbar_id.'"  value="'.$rowanbar['dad_vazn_n'].'"  type="text"  /></td>
				    <td><input name="dad_tedad_'.$dad_anbar_id.'"     id="dad_tedad_'.$dad_anbar_id.'"  value="'.$rowanbar['dad_tedad'].'"  type="text"  /></td>
				    <td>'.round($row['khales_sold'],3).'</td>   
				    <td>'.round($row['nakhales_sold'],3).'</td>
				    <td>'.$row['tedad_sold'].'</td>
				    <td>'.round($mojody_khales,3).'</td>
				    <td>'.round($mojody_nakhales,3).'</td>
				    <td>'.$tedad_karton.'</td>
				    <td>'.$row['vazn_karton_this'].'</td>
				    <td>'.$row['rouz_tolid_shamsi'].'</td>
				    <td>'.$mahshamsiArr[$row['mah_tolid_shamsi']].'</td>
				    <td>'.$row['sal_tolid_shamsi'].'</td>
				    <td>'.$row['name_tolidkonande'].'</td>
				    <td>'.$row['name_keshvar'].'</td>
				    <td>'.$row['name_ziranbar'].'</td>
				    <td>'.$inx.'</td>
				  
			  </tr>';
			$inx++;
		//}
		}
    }else{
    	$outHtml .= '<tr><td colspan="5">هيچ اطلاعاتي موجود نيست.</td></tr>';
    }
     $outHtml .= '</table></div><br><table align="center">'.getNavBar_prodanbar().' </div> '.getRPPCombo_prodanbar();
    echo $outHtml;
		
}
function getNavBar_prodanbar(){
	$out = '
		<table style="direction:ltr" >
			<tr>
			
	';
	//if($stNum>$_SESSION['pageCount']) $stNum=$_SESSION['pageCount']-5;
	
	$stNum = $_SESSION['crntPage']-5;
	if($stNum<1) $stNum=1;
	$out .= '
		<td><a href="?pg=prodMgmtPg&cmd=&search='.iconv("windows-1256", "UTF-8", $_SESSION['srchStr']).'&province_id='.$_SESSION['province_id'].'&cmd2=setPg&pgNum=1" ><img src="images/first.gif" title="ابتدا"></img></a></td>
		<td>&nbsp;&nbsp; </td>				      
		<td><a href="?pg=prodMgmtPg&cmd=&search='.iconv("windows-1256", "UTF-8", $_SESSION['srchStr']).'&province_id='.$_SESSION['province_id'].'&cmd2=setPg&pgNum='.((($_SESSION['crntPage']-1)<1) ? 1 : ($_SESSION['crntPage']-1)).'" ><img src="images/prev.gif" title="قبلي"></img></a></td>
		<td>&nbsp;&nbsp; </td>
	';
	$inx = 0;
	while(($inx<10) && (($stNum+$inx) <= $_SESSION['pageCount'])){
		$out .= '
			<td><a '.(($_SESSION['crntPage']==($stNum+$inx)) ? ' style="text-decoration:none; font-weight:bold;" ':'').' href="?pg=prodMgmtPg&cmd=&search='.iconv("windows-1256", "UTF-8", $_SESSION['srchStr']).'&province_id='.$_SESSION['province_id'].'&cmd2=setPg&pgNum='.($stNum+$inx).'" ><div style="background:#cccccc;">'.($stNum+$inx).'</div></a></td>
		';		
		$inx++;
	}
	$out .= '
		<td><a href="?pg=prodMgmtPg&cmd=&search='.iconv("windows-1256", "UTF-8", $_SESSION['srchStr']).'&province_id='.$_SESSION['province_id'].'&cmd2=setPg&pgNum='.((($_SESSION['crntPage']+1)<=$_SESSION['pageCount']) ? ($_SESSION['crntPage']+1) : $_SESSION['pageCount']).'" ><img src="images/next.gif" title="بعدي"></img></a></td>
		<td>&nbsp;&nbsp; </td>
		<td><a href="?pg=prodMgmtPg&cmd=&search='.iconv("windows-1256", "UTF-8", $_SESSION['srchStr']).'&province_id='.$_SESSION['province_id'].'&cmd2=setPg&pgNum='.$_SESSION['pageCount'].'" ><img src="images/last.gif" title="بعدي"></img></a></td>
	';	
	$out .= '
			</tr>
		</table>
	';	
	return $out;
}

function getRPPCombo_prodanbar(){
	$out = '<div align="center">
	<span style="align:center;">	
		<select onchange="window.open(\'?pg=prodMgmtPg&cmd=&search='.iconv("windows-1256", "UTF-8", $_SESSION['srchStr']).'&province_id='.$_SESSION['province_id'].'&cmd2=setRPP&rPP=\'+this.value, \'_self\') " style="width:50px; >
			<option value="1" '.(($_SESSION['rPP']==1)?' selected="selected" ':'').' > 1 </option>
			<option value="5" '.(($_SESSION['rPP']==5)?' selected="selected" ':'').' > 5 </option>
			<option value="10" '.(($_SESSION['rPP']==10)?' selected="selected" ':'').' > 10 </option>
			<option value="25" '.(($_SESSION['rPP']==25)?' selected="selected" ':'').' > 25 </option>
			<option value="50" '.(($_SESSION['rPP']==30)?' selected="selected" ':'').' > 50 </option>
			<option value="100" '.(($_SESSION['rPP']==100)?' selected="selected" ':'').' > 100 </option>
			<option value="1000000" '.(($_SESSION['rPP']==0)?' selected="selected" ':'').' > all </option>
		</select>
		<span style="color:blue;"><b>پاسخ در صفحه</b></span>
		</div>
	';
		return $out;
}
    //موجودی کارتن
function mojodyKarton($c_ostan,$c_anbar,$sal,$c_ziranbar,$c_kala,$c_keshvar,$c_tolidkonande,$sal_tolid,$mah_tolid,$rouz_tolid,$c_karton)
{     
  $detailkartonCondition='';
  if($c_ziranbar) $detailkartonCondition.=" AND code_ziranbar='$c_ziranbar'";
  if($c_keshvar) $detailkartonCondition.=" AND code_keshvar='$c_keshvar'";
  if($c_tolidkonande) $detailkartonCondition.=" AND code_tolidkonande='$c_tolidkonande'";
  if($sal_tolid) $detailkartonCondition.=" AND sal_tolid_shamsi='$sal_tolid'";
  if($mah_tolid) $detailkartonCondition.=" AND mah_tolid_shamsi='$mah_tolid'";
  if($rouz_tolid) $detailkartonCondition.=" AND rouz_tolid_shamsi='$rouz_tolid'";
  if($c_karton) $detailkartonCondition.=" AND code_karton='$c_karton'";
  $q="SELECT SUM(tedad_karton_aval) FROM mojody_kala WHERE code_ostan=$c_ostan AND code_anbar=$c_anbar AND year=$sal AND code_kala='$c_kala' $detailkartonCondition AND deleted=0";   
  $result=mysql_query($q);
  $row=mysql_fetch_array($result);
  $tedadKartonAval=$row[0];	
  $q_varede="SELECT SUM(tedad_karton_r_d_sub) FROM resid_kala_detail WHERE code_ostan=$c_ostan AND code_anbar=$c_anbar AND year=$sal AND code_kala='$c_kala' $detailkartonCondition AND resid_deleted=0 AND status=0";   
  $res_varede=mysql_query($q_varede);
  $row_varede=mysql_fetch_array($res_varede);
  $jameKartonVarede=$row_varede[0]; 
  $q_sadere="SELECT SUM(tedad_karton_h_d) FROM havale_detail WHERE code_ostan=$c_ostan AND code_anbar=$c_anbar AND year=$sal AND code_kala='$c_kala' $detailkartonCondition AND havale_deleted=0 AND status=0";
  $res_sadere=mysql_query($q_sadere);
  $row_sadere=mysql_fetch_array($res_sadere);
  $jameKartonSadere=$row_sadere[0];
  $q_tadil_ezafe="SELECT SUM(tedad_karton_tadil) FROM tadil_mojody WHERE noe_tadil=1 AND code_ostan=$c_ostan AND code_anbar=$c_anbar AND year=$sal AND code_kala='$c_kala' $detailkartonCondition AND status=0 AND deleted=0";   
  $res_tadil_ezafe=mysql_query($q_tadil_ezafe);
  $row_tadil_ezafe=mysql_fetch_array($res_tadil_ezafe);
  $kartonTadilEzafe=$row_tadil_ezafe[0];
  $q_tadil_kasry="SELECT SUM(tedad_karton_tadil) FROM tadil_mojody WHERE noe_tadil=2 AND code_ostan=$c_ostan AND code_anbar=$c_anbar  AND year=$sal AND code_kala='$c_kala'  $detailkartonCondition AND status=0 AND deleted=0";   
  $res_tadil_kasry=mysql_query($q_tadil_kasry);
  $row_tadil_kasry=mysql_fetch_array($res_tadil_kasry);
  $kartonTadilKasry=$row_tadil_kasry[0];
  $tedadKarton=$tedadKartonAval+$jameKartonVarede-$jameKartonSadere+$kartonTadilEzafe-$kartonTadilKasry;
  return $tedadKarton;
}
//موجودی ناخالص
function mojodyNakhales($c_ostan,$c_anbar,$sal,$c_ziranbar,$c_kala,$c_keshvar,$c_tolidkonande,$sal_tolid,$mah_tolid,$rouz_tolid,$c_karton)
{     
  $detailnakhalesCondition='';
  if($c_ziranbar) $detailnakhalesCondition.=" AND code_ziranbar='$c_ziranbar'";
  if($c_keshvar) $detailnakhalesCondition.=" AND code_keshvar='$c_keshvar'";
  if($c_tolidkonande) $detailnakhalesCondition.=" AND code_tolidkonande='$c_tolidkonande'";
  if($sal_tolid) $detailnakhalesCondition.=" AND sal_tolid_shamsi='$sal_tolid'";
  if($mah_tolid) $detailnakhalesCondition.=" AND mah_tolid_shamsi='$mah_tolid'";
  if($rouz_tolid) $detailnakhalesCondition.=" AND rouz_tolid_shamsi='$rouz_tolid'";
  if($c_karton) $detailnakhalesCondition.=" AND code_karton='$c_karton'";
  $q="SELECT SUM(mojody_nakhales_aval) FROM mojody_kala WHERE code_ostan=$c_ostan AND code_anbar=$c_anbar AND year=$sal AND code_kala='$c_kala' $detailnakhalesCondition AND deleted=0";   
  $result=mysql_query($q);
  $row=mysql_fetch_array($result);
  $mojodyNakhalesAval=$row[0];	
  $q_varede="SELECT SUM(vazn_nakhales_r_d_sub) FROM resid_kala_detail WHERE code_ostan=$c_ostan AND code_anbar=$c_anbar AND year=$sal AND code_kala='$c_kala' $detailnakhalesCondition AND resid_deleted=0 AND status=0";   
  $res_varede=mysql_query($q_varede);
  $row_varede=mysql_fetch_array($res_varede);
  $jameNaKhalesVarede=$row_varede[0]; 
  $q_sadere="SELECT SUM(vazn_nakhales_h_d) FROM havale_detail WHERE code_ostan=$c_ostan AND code_anbar=$c_anbar AND year=$sal AND code_kala='$c_kala' $detailnakhalesCondition AND havale_deleted=0 AND status=0";
  $res_sadere=mysql_query($q_sadere);
  $row_sadere=mysql_fetch_array($res_sadere);
  $jameNaKhalesSadere=$row_sadere[0];
  $q_tadil_ezafe="SELECT SUM(meghdar_nakhales_tadil) FROM tadil_mojody WHERE noe_tadil=1 AND code_ostan=$c_ostan AND code_anbar=$c_anbar AND year=$sal AND code_kala='$c_kala' $detailnakhalesCondition AND status=0 AND deleted=0";   
  $res_tadil_ezafe=mysql_query($q_tadil_ezafe);
  $row_tadil_ezafe=mysql_fetch_array($res_tadil_ezafe);
  $nakhalesTadilEzafe=$row_tadil_ezafe[0];
  $q_tadil_kasry="SELECT SUM(meghdar_nakhales_tadil) FROM tadil_mojody WHERE noe_tadil=2 AND code_ostan=$c_ostan AND code_anbar=$c_anbar AND year=$sal AND code_kala='$c_kala' $detailnakhalesCondition AND status=0 AND deleted=0";   
  $res_tadil_kasry=mysql_query($q_tadil_kasry);
  $row_tadil_kasry=mysql_fetch_array($res_tadil_kasry);
  $nakhalesTadilKasry=$row_tadil_kasry[0];
  $nakhales=$mojodyNakhalesAval+$jameNaKhalesVarede-$jameNaKhalesSadere+$nakhalesTadilEzafe-$nakhalesTadilKasry;
  $nakhales=round($nakhales,3);
  return $nakhales;
}
//موجودی خالص
function mojodyKhales($c_ostan,$c_anbar,$sal,$c_ziranbar,$c_kala,$c_keshvar,$c_tolidkonande,$sal_tolid,$mah_tolid,$rouz_tolid,$c_karton)
{     
  $detailkhalesCondition='';
  if($c_ziranbar) $detailkhalesCondition.=" AND code_ziranbar='$c_ziranbar'";
  if($c_keshvar) $detailkhalesCondition.=" AND code_keshvar='$c_keshvar'";
  if($c_tolidkonande) $detailkhalesCondition.=" AND code_tolidkonande='$c_tolidkonande'";
  if($sal_tolid) $detailkhalesCondition.=" AND sal_tolid_shamsi='$sal_tolid'";
  if($mah_tolid) $detailkhalesCondition.=" AND mah_tolid_shamsi='$mah_tolid'";
  if($rouz_tolid) $detailkhalesCondition.=" AND rouz_tolid_shamsi='$rouz_tolid'";
  if($c_karton) $detailkhalesCondition.=" AND code_karton='$c_karton'";
  $q="SELECT SUM(mojody_khales_aval) FROM mojody_kala WHERE code_ostan=$c_ostan AND code_anbar=$c_anbar AND year=$sal AND code_kala='$c_kala' $detailkhalesCondition AND deleted=0";   
  $result=mysql_query($q);
  $row=mysql_fetch_array($result);
  $mojodyKhalesAval=$row[0];	
  $q_varede="SELECT SUM(vazn_khales_r_d_sub) FROM resid_kala_detail WHERE code_ostan=$c_ostan AND code_anbar=$c_anbar AND year=$sal AND code_kala='$c_kala' $detailkhalesCondition AND resid_deleted=0 AND status=0";   
  $res_varede=mysql_query($q_varede);
  $row_varede=mysql_fetch_array($res_varede);
  $jameKhalesVadere=$row_varede[0]; 
  $q_sadere="SELECT SUM(vazn_khales_h_d) FROM havale_detail WHERE code_ostan=$c_ostan AND code_anbar=$c_anbar AND year=$sal AND code_kala='$c_kala' $detailkhalesCondition  AND havale_deleted=0 AND status=0";
  $res_sadere=mysql_query($q_sadere);
  $row_sadere=mysql_fetch_array($res_sadere);
  $jameKhalesSadere=$row_sadere[0];
  $q_tadil_ezafe="SELECT SUM(meghdar_khales_tadil) FROM tadil_mojody WHERE noe_tadil=1 AND code_ostan=$c_ostan AND code_anbar=$c_anbar AND year=$sal AND code_kala='$c_kala' $detailkhalesCondition AND status=0 AND deleted=0";   
  $res_tadil_ezafe=mysql_query($q_tadil_ezafe);
  $row_tadil_ezafe=mysql_fetch_array($res_tadil_ezafe);
  $khalesTadilEzafe=$row_tadil_ezafe[0];
  $q_tadil_kasry="SELECT SUM(meghdar_khales_tadil) FROM tadil_mojody WHERE noe_tadil=2 AND code_ostan=$c_ostan AND code_anbar=$c_anbar AND year=$sal AND code_kala='$c_kala' $detailkhalesCondition AND status=0 AND deleted=0";   
  $res_tadil_kasry=mysql_query($q_tadil_kasry);
  $row_tadil_kasry=mysql_fetch_array($res_tadil_kasry);
  $khalesTadilKasry=$row_tadil_kasry[0];
  $khales=$mojodyKhalesAval+$jameKhalesVadere-$jameKhalesSadere+$khalesTadilEzafe-$khalesTadilKasry;
  $khales=round($khales,3);
  return $khales;
}
?>