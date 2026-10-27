 <script type="text/javascript" src="lib/js/general.js"></script>
 <script type="text/javascript" language="" src="lib/js/jquery-1.2.6.min.js"></script>
<?php
require_once __DIR__ . '/../../mysql_compat.php';
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
					if (isset($_SESSION['srchStr'])){
				  $_SESSION['srchStr'] = isset($_REQUEST['search']) ? $_REQUEST['search'] : $_SESSION['srchStr'];
					}
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
$myconn = mysql_connect( "localhost" , "user" , "xlsdj@#@aHdF");
			mysql_query("SET NAMES 'utf8'",$myconn);
			mysql_select_db("sell",$myconn) or die("Can Not Select DataBase Because: ".
			mysql_error());
										

		$querya = "select * from dm_product product
			left join dm_price price
			on product.p_id=price.price_p_id
		           WHERE `p_code`='".$row1['phd_pid']."'  AND `p_price_code` =  '".$row1['phd_price_code']."'
		           AND
		            price_id_province=".$phd_id_province."
		    ";
           

			 // print $querya;         				       						       
				$lnka = mysql_query($querya);
				$rowa= mysql_fetch_assoc($lnka);
			$myconn = mysql_connect( "localhost" , "user" , "xlsdj@#@aHdF");
			mysql_query("SET NAMES 'utf8'",$myconn);
			mysql_select_db("meat",$myconn) or die("Can Not Select DataBase Because: ".
			mysql_error());
									
			if ($rowa['p_pakage_type']==8)
			{
			//ghoti	
			$no=1;	
			
			}else{
				
				$no=2;	
				
			}							
										
										
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
		<div align = "center" style="height:600px; overflow:auto">
		<table width="1312" border="1" align="center" bgcolor="#99CCCC"  cellpadding="0" cellspacing="0"  class="list"  >
  <tr>
    <td height="24" colspan="2" bordercolor="#000000" bgcolor="#99CCCC"><div align="center" class="style1">مقادیر مورد نظر </div></td>
    <td width="158" height="24" bgcolor="#99CCCC"><div align="center" class="style1">مقادیر فروخته شده </div></td>
    <td width="161" bgcolor="#99CCCC"><div align="center" class="style1">مقادیر موجود در سردخانه </div></td>
    <td width="77" rowspan="2" bgcolor="#99CCCC"><span class="style1">وزن کارتن </span></td>
    <td colspan="3" bgcolor="#99CCCC"><div align="center" class="style1">تاریخ تولید </div></td>
    <td width="118" rowspan="2" bgcolor="#99CCCC"><div align="center" class="style1">تولید کننده </div></td>
    <td width="105" rowspan="2" bgcolor="#99CCCC"><div align="center" class="style1">کشور</div></td>
    <td width="108" rowspan="2" bgcolor="#99CCCC"><div align="center" class="style1">زیر انبار </div></td>
    <td width="48" rowspan="2" bgcolor="#99CCCC"><div align="center" class="style1">ردیف</div></td>
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

if(($row1['phd_pid']=='410') OR ($row1['phd_pid']=='411'))
{
	
if (in_array($row1['phd_id_province'],array(7,4,5,1,2))) {}
else $condition="and mojody_kala.sal_tolid_shamsi<1398  AND  mojody_kala.mah_tolid_shamsi<10 ";  
} 

if(($row1['phd_pid']=='75') OR ($row1['phd_pid']=='76') or ($row1['phd_pid']=='77') or ($row1['phd_pid']=='78'))
{
	
if (in_array($row1['phd_id_province'],array(5,4))) {}	
else $condition="and mojody_kala.sal_tolid_shamsi<1398  AND  mojody_kala.mah_tolid_shamsi<5 ";
}
	$genQuery = "
		
	 mojody_kala.*,kala.name_kala,keshvar.name_keshvar,tolidkonande.name_tolidkonande,l_s_d.noe_ziranbar,l_s_d.name_ziranbar,karton.vazn_karton From mojody_kala
          INNER JOIN kala ON mojody_kala.code_kala=kala.code_kala
          INNER JOIN keshvar ON mojody_kala.code_keshvar=keshvar.code_keshvar
          LEFT JOIN karton ON mojody_kala.code_karton=karton.code_karton 
          INNER JOIN tolidkonande ON mojody_kala.code_tolidkonande=tolidkonande.code_tolidkonande
          INNER JOIN list_sardkhane_detail l_s_d ON mojody_kala.code_ziranbar=l_s_d.code_ziranbar AND mojody_kala.code_ostan=l_s_d.code_ostan AND mojody_kala.code_anbar=l_s_d.code_anbar        
          WHERE mojody_kala.code_kala='". $row1['phd_pid'] ."'  AND  mojody_kala.code_ostan='". $row1['phd_id_province'] ."'  AND mojody_kala.code_anbar='". $row2['l_code'] ."'  AND  mojody_kala.year='1398'  AND mojody_kala.deleted=0
          
          
           
          
          
 		".$condition."		
		".$srchQ." 
		".$typeQ."
		
		  order by sal_tolid_shamsi,mah_tolid_shamsi,rouz_tolid_shamsi asc ";	
	
	
	$countQuery = "
		SELECT 
			COUNT(*) elmCount  
	".$genQuery;
	$lnk = mysql_query($countQuery);
	if(mysql_num_rows($lnk)>0){
	$cntRow = mysql_fetch_assoc($lnk);
	}
	$_SESSION['elmCount'] = $cntRow['elmCount'];
	
	$pageCount = ($_SESSION['elmCount']/$_SESSION['rPP']);
	if($pageCount != (int)($pageCount)) $pageCount++;
	$pageCount = (int) $pageCount;
	$_SESSION['pageCount'] = $pageCount; 
	
	$limitQ = " LIMIT ".((($_SESSION['crntPage']-1)*$_SESSION['rPP'])).', '.$_SESSION['rPP'];
	
	$resQuery = "
		SELECT 
			
	".$genQuery;
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
				
	$tedad_karton=mojodyMojazTedad1($row['id'],$row['code_ostan'],$row['code_anbar'],$row['year'],$row['code_ziranbar'],$row['code_kala'],$row['code_keshvar'],$row['code_tolidkonande'],$row['sal_tolid_shamsi'],$row['mah_tolid_shamsi'],$row['rouz_tolid_shamsi'],$row['code_karton']);
    $mojody_khales=mojodyMojazKhales1($row['id'],$row['code_ostan'],$row['code_anbar'],$row['year'],$row['code_ziranbar'],$row['code_kala'],$row['code_keshvar'],$row['code_tolidkonande'],$row['sal_tolid_shamsi'],$row['mah_tolid_shamsi'],$row['rouz_tolid_shamsi'],$row['code_karton']);	
    $mojody_shane=mojodyMojazShane1($row['id'],$row['code_ostan'],$row['code_anbar'],$row['year'],$row['code_ziranbar'],$row['code_kala'],$row['code_keshvar'],$row['code_tolidkonande'],$row['sal_tolid_shamsi'],$row['mah_tolid_shamsi'],$row['rouz_tolid_shamsi'],$row['code_karton']);	
	//fieldhaye feresttadani
	
		$dad_anbar_id=$row['id'];
		$dad_phd_id=$phd_id;
		$vaznkarton=$row['vazn_karton_this'];
	
		
			$queryanbar="SELECT * FROM sell.dm_anbar_det WHERE dad_anbar_id=".$dad_anbar_id."
			
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
	    	
		if($no==1){    
				//ghoti
				$tedad=$tedad_karton;
				$forokhte=round($row['khales_sold']);
				
				
			}else{
				
				if($row['code_kala']==50){
					
				
					$tedad=$mojody_shane;
					$forokhte=$row['khales_sold'];
				}else{
				
				$tedad=$mojody_khales;
				$forokhte=$row['khales_sold'];
				}
				
			    }
		
		
			    if($tedad !=0){
			if($rowa['p_pakage_type']==8){
				$dad_vazn_kh=$rowanbar['dad_tedad'];
			}else{
				
				if($row['code_kala']==50){
					
					$dad_vazn_kh=$rowanbar['dad_tedad'];	
				}else{
				
			$dad_vazn_kh=$rowanbar['dad_vazn_kh'];	
			
				}
				
			}
			
			 $outHtml .= ' <tr>
  <td width="197" height="23" bgcolor="#99CCCC">&nbsp;</td>
    <td width="87" bgcolor="#99CCCC"><div align="center" class="style1">وزن خالص یا مقدار </div></td>
    <td bgcolor="#99CCCC"><div align="center" class="style1">مقدار</div>      </td>
    <td bgcolor="#99CCCC"><div align="center" class="style1">موجودی</div>      </td>
    <td width="121" bgcolor="#99CCCC"><div align="center" class="style1">روز</div></td>
    <td width="74" bgcolor="#99CCCC"><div align="center" class="style1">ماه</div></td>
    <td width="32" bgcolor="#99CCCC"><div align="center" class="style1">سال</div></td>
  </tr>
  <tr>   <td>
  			    <span id="ezaf_'.$dad_anbar_id.'"   style="cursor:pointer;display:'.$Display2. ';"         onclick="AddAdetanbar(\'\', \''.$phd_id.'\', \''.$dad_anbar_id.'\', \''.$vaznkarton.'\', \''.$tedad_karton.'\', \''.$row2['l_code'].'\', \''.$row['sal_tolid_shamsi'].'\', \''.$row['mah_tolid_shamsi'].'\', \''.$row['rouz_tolid_shamsi'].'\') " this.style.display=\'none\'"><img src="images/ok.png" border="0" align="center" style="height:20px;width=20px;"></img></span>
				    <span id="kam_'.$dad_anbar_id.'"    style="cursor:pointer;display:'.$Display1. ';"         onclick="delAdetanbar(\'\', \''.$phd_id.'\', \''.$dad_anbar_id.'\', \''.$rowa['p_pakage_type'].'\') " this.style.display=\'none\'"><img src="images/del.png" border="0" align="center"  style="height:20px;width=20px;"></img></span>
				    </td>
				    <td><input name="dad_vazn_kh_'.$dad_anbar_id.'"   id="dad_vazn_kh_'.$dad_anbar_id.'"  value="'.$dad_vazn_kh.'" type="text"  /></td>
				    <td>'.$forokhte.'</td>   
				    <td>'.$tedad.'</td>
				   
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
			    }
		}
    }else{
    	$outHtml .= '<tr><td colspan="5">هيچ اطلاعاتي موجود نيست.</td></tr>';
    }
     $outHtml .= '</table></div><br>';
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
    	
//موجودی تعداد مجاز
function mojodyMojazTedad1($id,$c_ostan,$c_anbar,$sal,$c_ziranbar,$c_kala,$c_keshvar,$c_tolidkonande,$sal_tolid,$mah_tolid,$rouz_tolid,$c_karton)
{     
  $detailkartonCondition='';
  if($c_ziranbar) $detailkartonCondition.=" AND code_ziranbar='$c_ziranbar'";
  if($c_keshvar) $detailkartonCondition.=" AND code_keshvar='$c_keshvar'";
  if($c_tolidkonande) $detailkartonCondition.=" AND code_tolidkonande='$c_tolidkonande'";
  if($sal_tolid) $detailkartonCondition.=" AND sal_tolid_shamsi='$sal_tolid'";
  if($mah_tolid) $detailkartonCondition.=" AND mah_tolid_shamsi='$mah_tolid'";
  if($rouz_tolid) $detailkartonCondition.=" AND rouz_tolid_shamsi='$rouz_tolid'";
  if($c_karton) $detailkartonCondition.=" AND code_karton='$c_karton'";
  $q="SELECT SUM(tedad_karton_aval) FROM meat.mojody_kala WHERE code_ostan=$c_ostan AND code_anbar=$c_anbar AND year=$sal AND code_kala='$c_kala' $detailkartonCondition AND deleted=0";   
  $result=mysql_query($q);
  $row=mysql_fetch_array($result);
  $tedadKartonAval=$row[0];	
  $q_varede="SELECT SUM(tedad_karton_r_d_sub) FROM meat.resid_kala_detail WHERE code_ostan=$c_ostan AND code_anbar=$c_anbar AND year=$sal AND code_kala='$c_kala' $detailkartonCondition AND resid_deleted=0 AND status=0";   
  $res_varede=mysql_query($q_varede);
  $row_varede=mysql_fetch_array($res_varede);
  $jameKartonVarede=$row_varede[0]; 
  $q_sadere="SELECT SUM(tedad_karton_h_d) FROM meat.havale_detail WHERE code_ostan=$c_ostan AND code_anbar=$c_anbar AND year=$sal AND code_kala='$c_kala' $detailkartonCondition AND havale_deleted=0 AND status=0";
  $res_sadere=mysql_query($q_sadere);
  $row_sadere=mysql_fetch_array($res_sadere);
  $jameKartonSadere=$row_sadere[0];
  $q_tadil_ezafe="SELECT SUM(tedad_karton_tadil) FROM meat.tadil_mojody WHERE noe_tadil=1 AND code_ostan=$c_ostan AND code_anbar=$c_anbar AND year=$sal AND code_kala='$c_kala' $detailkartonCondition AND status=0 AND deleted=0";   
  $res_tadil_ezafe=mysql_query($q_tadil_ezafe);
  $row_tadil_ezafe=mysql_fetch_array($res_tadil_ezafe);
  $kartonTadilEzafe=$row_tadil_ezafe[0];
  $q_tadil_kasry="SELECT SUM(tedad_karton_tadil) FROM meat.tadil_mojody WHERE noe_tadil=2 AND code_ostan=$c_ostan AND code_anbar=$c_anbar  AND year=$sal AND code_kala='$c_kala'  $detailkartonCondition AND status=0 AND deleted=0";   
  $res_tadil_kasry=mysql_query($q_tadil_kasry);
  $row_tadil_kasry=mysql_fetch_array($res_tadil_kasry);
  $kartonTadilKasry=$row_tadil_kasry[0];
  $tedadKarton=$tedadKartonAval+$jameKartonVarede-$jameKartonSadere+$kartonTadilEzafe-$kartonTadilKasry;
  $q_forush_detail="SELECT SUM(dad_tedad_khanbar) FROM sell.dm_anbar_det WHERE dad_anbar_id='$id'";
  $res_forush_detail=mysql_query($q_forush_detail);
  $row_forush_detail=mysql_fetch_array($res_forush_detail);
  $jameForukhte=$row_forush_detail[0];
  $q_ebtal_detail="SELECT SUM(deh_amount) FROM sell.dm_ebtal_hdet WHERE deh_anbar_id='$id'";
  $res_ebtal_detail=mysql_query($q_ebtal_detail);
  $row_ebtal_detail=mysql_fetch_array($res_ebtal_detail);
  $jameEbtali=$row_ebtal_detail[0];
  $q_tahvily_detail="SELECT SUM(tedad_karton_h_d) FROM meat.havale_detail WHERE id_mojody='$id' AND status=0 AND dad_id!=''";
  $res_tahvily_detail=mysql_query($q_tahvily_detail);
  $row_tahvily_detail=mysql_fetch_array($res_tahvily_detail);
  $jameTahvily=$row_tahvily_detail[0];
  $mandeForush_detail=$jameForukhte-$jameEbtali-$jameTahvily;
  $tedadMojaz=$tedadKarton-$mandeForush_detail;
  return $tedadMojaz;
}

//موجودی خالص مجاز
function mojodyMojazKhales1($id,$c_ostan,$c_anbar,$sal,$c_ziranbar,$c_kala,$c_keshvar,$c_tolidkonande,$sal_tolid,$mah_tolid,$rouz_tolid,$c_karton)
{     
 $detailkhalesCondition='';
  if($c_ziranbar) $detailkhalesCondition.=" AND code_ziranbar='$c_ziranbar'";
  if($c_keshvar) $detailkhalesCondition.=" AND code_keshvar='$c_keshvar'";
  if($c_tolidkonande) $detailkhalesCondition.=" AND code_tolidkonande='$c_tolidkonande'";
  if($sal_tolid) $detailkhalesCondition.=" AND sal_tolid_shamsi='$sal_tolid'";
  if($mah_tolid) $detailkhalesCondition.=" AND mah_tolid_shamsi='$mah_tolid'";
  if($rouz_tolid) $detailkhalesCondition.=" AND rouz_tolid_shamsi='$rouz_tolid'";
  if($c_karton) $detailkhalesCondition.=" AND code_karton='$c_karton'";
  $q="SELECT SUM(mojody_khales_aval) FROM meat.mojody_kala WHERE code_ostan=$c_ostan AND code_anbar=$c_anbar AND year=$sal AND code_kala='$c_kala' $detailkhalesCondition AND deleted=0";   
  $result=mysql_query($q);
  $row=mysql_fetch_array($result);
  $mojodyKhalesAval=$row[0];	
  $q_varede="SELECT SUM(vazn_khales_r_d_sub) FROM meat.resid_kala_detail WHERE code_ostan=$c_ostan AND code_anbar=$c_anbar AND year=$sal AND code_kala='$c_kala' $detailkhalesCondition AND resid_deleted=0 AND status=0";   
  $res_varede=mysql_query($q_varede);
  $row_varede=mysql_fetch_array($res_varede);
  $jameKhalesVadere=$row_varede[0]; 
  $q_sadere="SELECT SUM(vazn_khales_h_d) FROM meat.havale_detail WHERE code_ostan=$c_ostan AND code_anbar=$c_anbar AND year=$sal AND code_kala='$c_kala' $detailkhalesCondition  AND havale_deleted=0 AND status=0";
  $res_sadere=mysql_query($q_sadere);
  $row_sadere=mysql_fetch_array($res_sadere);
  $jameKhalesSadere=$row_sadere[0];
  $q_tadil_ezafe="SELECT SUM(meghdar_khales_tadil) FROM meat.tadil_mojody WHERE noe_tadil=1 AND code_ostan=$c_ostan AND code_anbar=$c_anbar AND year=$sal AND code_kala='$c_kala' $detailkhalesCondition AND status=0 AND deleted=0";   
  $res_tadil_ezafe=mysql_query($q_tadil_ezafe);
  $row_tadil_ezafe=mysql_fetch_array($res_tadil_ezafe);
  $khalesTadilEzafe=$row_tadil_ezafe[0];
  $q_tadil_kasry="SELECT SUM(meghdar_khales_tadil) FROM meat.tadil_mojody WHERE noe_tadil=2 AND code_ostan=$c_ostan AND code_anbar=$c_anbar AND year=$sal AND code_kala='$c_kala' $detailkhalesCondition AND status=0 AND deleted=0";   
  $res_tadil_kasry=mysql_query($q_tadil_kasry);
  $row_tadil_kasry=mysql_fetch_array($res_tadil_kasry);
  $khalesTadilKasry=$row_tadil_kasry[0];
  $khales=$mojodyKhalesAval+$jameKhalesVadere-$jameKhalesSadere+$khalesTadilEzafe-$khalesTadilKasry;
  $khales=round($khales,3);
  $q_forush_detail="SELECT SUM(dad_vazn_khanbar) FROM sell.dm_anbar_det WHERE dad_anbar_id='$id'";
  $res_forush_detail=mysql_query($q_forush_detail);
  $row_forush_detail=mysql_fetch_array($res_forush_detail);
  $jameForukhte=$row_forush_detail[0];
  $q_ebtal_detail="SELECT SUM(deh_amount) FROM sell.dm_ebtal_hdet WHERE deh_anbar_id='$id'";
  $res_ebtal_detail=mysql_query($q_ebtal_detail);
  $row_ebtal_detail=mysql_fetch_array($res_ebtal_detail);
  $jameEbtali=$row_ebtal_detail[0];
  $q_tahvily_detail="SELECT SUM(vazn_khales_h_d) FROM meat.havale_detail WHERE id_mojody='$id' AND status=0 AND dad_id!=''";
  $res_tahvily_detail=mysql_query($q_tahvily_detail);
  $row_tahvily_detail=mysql_fetch_array($res_tahvily_detail);
  $jameTahvily=$row_tahvily_detail[0];
  $mandeForush_detail=$jameForukhte-$jameEbtali-$jameTahvily;
  $khalesMojaz=$khales-$mandeForush_detail;
  $khalesMojaz=round($khalesMojaz,3);
  return $khalesMojaz;
}
function mojodyMojazShane1($id,$c_ostan,$c_anbar,$sal,$c_ziranbar,$c_kala,$c_keshvar,$c_tolidkonande,$sal_tolid,$mah_tolid,$rouz_tolid,$c_karton)
{     
  $detailShaneCondition='';
  if($c_ziranbar)     $detailShaneCondition.=" AND code_ziranbar='$c_ziranbar'";
  if($c_keshvar)      $detailShaneCondition.=" AND code_keshvar='$c_keshvar'";
  if($c_tolidkonande) $detailShaneCondition.=" AND code_tolidkonande='$c_tolidkonande'";
  if($sal_tolid)      $detailShaneCondition.=" AND sal_tolid_shamsi='$sal_tolid'";
  if($mah_tolid)      $detailShaneCondition.=" AND mah_tolid_shamsi='$mah_tolid'";
  if($rouz_tolid)     $detailShaneCondition.=" AND rouz_tolid_shamsi='$rouz_tolid'";
  if($c_karton)       $detailShaneCondition.=" AND code_karton='$c_karton'";
  $q="SELECT SUM(tedad_shane_aval) FROM meat.mojody_kala WHERE code_ostan=$c_ostan AND code_anbar=$c_anbar AND year=$sal AND code_kala='$c_kala' $detailShaneCondition AND deleted=0";   
  $result=mysql_query($q);
  $row=mysql_fetch_array($result);
  $tedadShaneAval=$row[0];    
  $q_varede="SELECT SUM(tedad_shane_r_d_sub) FROM meat.resid_kala_detail WHERE code_ostan=$c_ostan AND code_anbar=$c_anbar AND year=$sal AND code_kala='$c_kala' $detailShaneCondition AND resid_deleted=0 AND status=0";   
  $res_varede=mysql_query($q_varede);
  $row_varede=mysql_fetch_array($res_varede);
  $jameShaneVarede=$row_varede[0]; 
  $q_sadere="SELECT SUM(tedad_shane_h_d) FROM meat.havale_detail WHERE code_ostan=$c_ostan AND code_anbar=$c_anbar AND year=$sal AND code_kala='$c_kala' $detailShaneCondition AND havale_deleted=0 AND status=0";
  $res_sadere=mysql_query($q_sadere);
  $row_sadere=mysql_fetch_array($res_sadere);
  $jameShaneSadere=$row_sadere[0];
  $q_tadil_ezafe="SELECT SUM(tedad_shane_tadil) FROM meat.tadil_mojody WHERE noe_tadil=1 AND code_ostan=$c_ostan AND code_anbar=$c_anbar AND year=$sal AND code_kala='$c_kala' $detailShaneCondition AND status=0 AND deleted=0";   
  $res_tadil_ezafe=mysql_query($q_tadil_ezafe);
  $row_tadil_ezafe=mysql_fetch_array($res_tadil_ezafe);
  $ShaneTadilEzafe=$row_tadil_ezafe[0];
  $q_tadil_kasry="SELECT SUM(tedad_shane_tadil) FROM meat.tadil_mojody WHERE noe_tadil=2 AND code_ostan=$c_ostan AND code_anbar=$c_anbar  AND year=$sal AND code_kala='$c_kala'  $detailShaneCondition AND status=0 AND deleted=0";   
  $res_tadil_kasry=mysql_query($q_tadil_kasry);
  $row_tadil_kasry=mysql_fetch_array($res_tadil_kasry);
  $ShaneTadilKasry=$row_tadil_kasry[0];
  $tedadShane=$tedadShaneAval+$jameShaneVarede-$jameShaneSadere+$ShaneTadilEzafe-$ShaneTadilKasry;
  $q_forush_detail="SELECT SUM(dad_tedad_khanbar) FROM sell.dm_anbar_det WHERE dad_anbar_id='$id'";
  $res_forush_detail=mysql_query($q_forush_detail);
  $row_forush_detail=mysql_fetch_array($res_forush_detail);
  $jameForukhte=$row_forush_detail[0];
  $q_ebtal_detail="SELECT SUM(deh_amount) FROM sell.dm_ebtal_hdet WHERE deh_anbar_id='$id'";
  $res_ebtal_detail=mysql_query($q_ebtal_detail);
  $row_ebtal_detail=mysql_fetch_array($res_ebtal_detail);
  $jameEbtali=$row_ebtal_detail[0];
  $q_tahvily_detail="SELECT SUM(tedad_shane_h_d) FROM meat.havale_detail WHERE id_mojody='$id' AND status=0 AND dad_id!=''";
  $res_tahvily_detail=mysql_query($q_tahvily_detail);
  $row_tahvily_detail=mysql_fetch_array($res_tahvily_detail);
  $jameTahvily=$row_tahvily_detail[0];
  $mandeForush_detail=$jameForukhte-$jameEbtali-$jameTahvily;
  $shaneMojaz=$tedadShane-$mandeForush_detail;
  return $shaneMojaz;
}
?>