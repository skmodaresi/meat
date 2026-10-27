 <script type="text/javascript" src="lib/js/general.js"></script>
 <script type="text/javascript" language="" src="lib/js/jquery-1.2.6.min.js"></script>

<?php
require_once __DIR__ . '/../mysql_compat.php';
 
	
$_SESSION['codeprice']='';
 header('Content-Type: text/html; charset=UTF-8');
include_once 'lib/php/gen_def.php';
include_once 'lib/php/general_aj.php';
include_once 'lib/php/body.php';
//include_once 'lib/php/Pfactor_mgmt.php';
include_once 'lib/php/jdf.php';
$myconn = mysql_connect( "localhost" , "user" , "xlsdj@#@aHdF");
mysql_query("SET NAMES 'utf8'",$myconn);
mysql_select_db("sell",$myconn) or die("Can Not Select DataBase Because: ".
mysql_error());
	
    $pg1 = isset($_REQUEST['pg1']) ? $_REQUEST['pg1'] : 'prodMgmtPg';
    $cmd1 = isset($_REQUEST['cmd1']) ? $_REQUEST['cmd1'] : 'searchprice_code';
    $province_id = isset($_REQUEST['province_id']) ? $_REQUEST['province_id'] : '';
    $search = isset($_REQUEST['search']) ? $_REQUEST['search'] : ''; 
  $_SESSION['province_id']= $province_id;
	$outHtml2 = '<br>
		<form method="get" action="searchprice_code.php">
			<input type="hidden" name="pg1" value="prodMgmtPg">   
			<input type="hidden" name="cmd1" value="searchCodecustomer"> 
			 نام ويا کد قيمت را وارد کنيد 
			<div> <input type="text" name="search"  style="width: 60px;"/> 
			<button type="submit" name="Search" value="Search" >جستجو</button></div>
		</form>
	';
	switch ($pg1){
		
		case 'prodMgmtPg':
			switch($cmd1){
				case 'searchprice_code':
				  $_SESSION['srchStr'] = isset($_REQUEST['search']) ? $_REQUEST['search'] : $_SESSION['srchStr'];
					getprice_codeist();
					//$_SESSION['srchStr']='';
					break;
			}
			break;
	}
	

function getprice_codeist(){
		//echo $_SESSION['srchStr'];
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
		
$queryy = "SELECT * FROM  dm_year where
            year_status=1 ";	
		$lnky = mysql_query($queryy);
	//	print $query1;
		$rowy= mysql_fetch_assoc($lnky);
		$year_code=$rowy['year_code'];
	$outHtml= '	<a href="javascript:self.close()">بستن پنجره </a>
	<form method="get" action="searchprice_code.php">
					<input type="hidden" name="pg1" value="prodMgmtPg">   
					<input type="hidden" name="cmd1" value="searchprice_code">
					<input type="hidden" name="province_id" value="'.$_SESSION['province_id'].'">
		<div align = "center">
		<div align = "center" style="height:400px; overflow:auto">
			<table  border="2" align="right" cellpadding="0" cellspacing="0"  class="list" style="width:100%;" dir="rtl">
      			<tr class="rw1">
        			<th colspan="22" align="center" scope="row" style="height: 50px;vertical-align:middle;font-size:20px;" >ليست كالا </th>
        		</tr>
      			<tr bgcolor="orange" class="rw0" style="font-weight:bold;height: 30px;">
      			    <td align="center">رديف</td>
			        <td align="center">نام كالا</td>
			        <td align="center">كد قيمت </td>			        				             
				</tr>
				<tr>				    
				    <td align="center">کد قيمت و یا نام كالا را جستجو کنید</td>
			        <td align="center"><div> <input type="text" name="search" value="'.$_SESSION['srchStr'].'" style="width: 60px;" );"/> </td>
			        <td><button type="submit" name="Search" value="Search" >جستجو</button></td>	
				</tr>
				</form>
	';
	   
	$queryp="SELECT * FROM 
	                  dm_province  
		            WHERE
		               province_id=". $_SESSION['province_id']."
		             ";
		            	
			$lnkp=mysql_query($queryp);
		//	print $queryp;
			print mysql_error();
			$rowp=mysql_fetch_assoc($lnkp);
			$province_code=$rowp['province_code'];
		
	//if(!isset($_SESSION['srchStr'])) $_SESSION['srchStr'] = '';
	if(!isset($_SESSION['elmCount'])) $_SESSION['elmCount'] = 0;
	if(!isset($_SESSION['rPP'])) $_SESSION['rPP'] = 10;//results per page
	if(!isset($_SESSION['pageCount'])) $_SESSION['pageCount'] = 1;//results page conut
	if(!isset($_SESSION['crntPage'])) $_SESSION['crntPage'] = 1;//current page number
	if($_SESSION['srchStr']==''){
		$srchQ = "";
		
	}else{
		//$_SESSION['srchStr']=iconv("UTF-8", "windows-1256", $_SESSION['srchStr']);
		$srchQ = " 
			AND(   
					name LIKE '%".$_SESSION['srchStr']."%' 
				OR 
					code LIKE '".$_SESSION['srchStr']."' 
				
			)
		";		
	}
	$typeQ = '';
	
	$genQuery = "
		
				FROM 
					mali.acc_mofaser_detail
				WHERE
					(mk=25
				or
				mk=18)
									
				".$srchQ." 
				".$typeQ."  
				AND
				year=1395
				ORDER BY id desc ";	
	
	$countQuery = "
		SELECT 
			COUNT(*) elmCount  
	".$genQuery;
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
			*  
	".$genQuery.$limitQ;
	//print($resQuery);
	//	$_SESSION['srchStr'] = '';
	$lnk = mysql_query($resQuery);
	$inx = ((($_SESSION['crntPage']-1)*$_SESSION['rPP'])+1);

	if(mysql_num_rows($lnk)>0){
				
	$inx--;
		while($row = mysql_fetch_assoc($lnk)){
		
			$inx++;
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
					//$name=convert_charset($row['name']);					
			$outHtml .= '
			
				<tr class='.$class.' style="cursor:pointer" onclick="passparent(\'\', \''. $row['code'] .'\')">
					<td align="center" style="vertical-align:middle;">'.$inx.'</td>
					<td align="center" style="vertical-align:middle;">'.$row['name'].'</td>
					<td align="center" style="vertical-align:middle;">'.$row['code'].'</td>
					';				  
				$outHtml .= '</tr>';
			
		}
    }else{
    	$outHtml .= '<tr><td colspan="5">هيچ اطلاعاتي موجود نيست.</td>
    					<td  style="vertical-align:middle;" align="center"> </td>
    	
    	
    	</tr>';
    }
     $outHtml .= '</table></div><br><table align="center">'.getNavBar_price().' </div> '.getRPPCombo_price();
    echo $outHtml;
		
}
function getNavBar_price(){
	$province_id=$_SESSION['province_id'];
	
	$out = '
		<table style="direction:ltr" >
			<tr>
			
	';
	//if($stNum>$_SESSION['pageCount']) $stNum=$_SESSION['pageCount']-5;
	
	$stNum = $_SESSION['crntPage']-5;
	if($stNum<1) $stNum=1;
	$out .= '
		<td><a href="?pg=prodMgmtPg&cmd=searchCodecustomer&search='. $_SESSION['srchStr'].'&province_id='.$province_id.'&cmd2=setPg&pgNum=1" ><img src="images/first.gif" title="ابتدا"></img></a></td>
		<td>&nbsp;&nbsp; </td>				      
		<td><a href="?pg=prodMgmtPg&cmd=searchCodecustomer&search='. $_SESSION['srchStr'].'&province_id='.$province_id.'&cmd2=setPg&pgNum='.((($_SESSION['crntPage']-1)<1) ? 1 : ($_SESSION['crntPage']-1)).'" ><img src="images/prev.gif" title="قبلي"></img></a></td>
		<td>&nbsp;&nbsp; </td>
	';
	$inx = 0;
	while(($inx<10) && (($stNum+$inx) <= $_SESSION['pageCount'])){
		$out .= '
			<td><a '.(($_SESSION['crntPage']==($stNum+$inx)) ? ' style="text-decoration:none; font-weight:bold;" ':'').' href="?pg=prodMgmtPg&cmd=searchCodecustomer&search='. $_SESSION['srchStr'].'&province_id='.$province_id.'&cmd2=setPg&pgNum='.($stNum+$inx).'" ><div style="background:#cccccc;">'.($stNum+$inx).'</div></a></td>
		';		
		$inx++;
	}
	$out .= '
		<td><a href="?pg=prodMgmtPg&cmd=searchCodecustomer&search='. $_SESSION['srchStr'].'&province_id='.$province_id.'&cmd2=setPg&pgNum='.((($_SESSION['crntPage']+1)<=$_SESSION['pageCount']) ? ($_SESSION['crntPage']+1) : $_SESSION['pageCount']).'" ><img src="images/next.gif" title="بعدي"></img></a></td>
		<td>&nbsp;&nbsp; </td>
		<td><a href="?pg=prodMgmtPg&cmd=searchCodecustomer&search='. $_SESSION['srchStr'].'&province_id='.$province_id.'&cmd2=setPg&pgNum='.$_SESSION['pageCount'].'" ><img src="images/last.gif" title="بعدي"></img></a></td>
	';	
	$out .= '
			</tr>
		</table>
	';	
	return $out;
}

function getRPPCombo_price(){
	$province_id=$_SESSION['province_id'];
	$out = '<div align="center">
	<span style="align:center;">	
		<select onchange="window.open(\'?pg=prodMgmtPg&cmd=searchCodecustomer&search='.$_SESSION['srchStr'].'&province_id='.$province_id.'&cmd2=setRPP&rPP=\'+this.value, \'_self\') " style="width:50px; >
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
  
    
 ?>