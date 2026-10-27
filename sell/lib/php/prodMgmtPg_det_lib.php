<?php
require_once __DIR__ . '/../../../mysql_compat.php';


function category_prod(){

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
	
			$outHtml = '<br>
				<form method="get" action="">
					<input type="hidden" name="pg" value="prodMgmtPg_det">   
					<input type="hidden" name="cmd" value="searchCat_prod"> 
					 کلمه مورد نظر را وارد كنيد 
					<div> جستجو : <input type="text" name="search" value="'.$_SESSION['srchStr'].'" style="width:100px;"/> 
					  <button value="draft" name="commit" type="submit" >جستجو</button> </div>
				</form>
			';	
	$outHtml .= '<br>	
		<div align = "center">
		 <div align = "center" style="width:70%;height:200px; overflow:auto">
			<table border="5" align="center" cellpadding="0" cellspacing="0" bgcolor=#99CCCC; class="list" >
      			<tr class="rw1">
        			<th colspan="20" align="center" scope="row" style="height: 50px;vertical-align:middle;"><center>دسته بندی کالاها </center></th>
        		</tr>
        		
      			<tr class="rw0" style="font-weight:bold;">
      			    <td align="center">رديف</td>
			        <td align="center">نام دسته بندی</td>
			        <td align="center">تاریخ دسته بندی </td>
			        <td align="center" colspan="2">&nbsp </td>		       
				</tr>
	';
	
	if(!isset($_SESSION['srchStr'])) $_SESSION['srchStr'] = '';
	if(!isset($_SESSION['elmCount'])) $_SESSION['elmCount'] = 0;
	if(!isset($_SESSION['rPP'])) $_SESSION['rPP'] = 10;//results per page
	if(!isset($_SESSION['pageCount'])) $_SESSION['pageCount'] = 1;//results page conut
	if(!isset($_SESSION['crntPage'])) $_SESSION['crntPage'] = 1;//current page number
	if($_SESSION['srchStr']==''){
		$srchQ = "";
		
	}else{
		$srchQ = " 
			AND(
					cat_prod_name LIKE '%".$_SESSION['srchStr']."%' 
				
			)
		";
		
	}
	$typeQ = '';
	
	$genQuery = "
		
		FROM 
			dm_prod_det_c 
		WHERE 
			1 
		".$srchQ." 
		".$typeQ." 
	";
	
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
		$_SESSION['srchStr'] = '';
	$lnk = mysql_query($resQuery);
	$inx = ((($_SESSION['crntPage']-1)*$_SESSION['rPP'])+1);
		
	if(mysql_affected_rows()>0){	
	$inx--;
		while($row = mysql_fetch_assoc($lnk)){
			
			$gdate=$row['cat_prod_date'];
			list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
			list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
			$jdate = $jyear."/".$jmonth."/".$jday;
					
			if(($inx)%2==1)
				$class="rw0";
				else
				$class="rw1";
			$inx++;
			
			$outHtml .= '
				<tr class='.$class.'>
					<td align="center">'.$inx.'</td>
					<td align="center">'.$row['cat_prod_name'].'</td>
					<td align="center">'.$jdate.'</td>					
					<td align="center"><a href="?pg=prodMgmtPg_det&cmd=cat_prodEditFrm&cat_prod_id='.$row['cat_prod_id'].'"><img src="images/edit.png"  border="0" title="ويرايش" width="10%" height="10%"></img></a></td>				      
					<td align="center"><a href="?pg=prodMgmtPg_det&cmd=cat_prodDelete&cat_prod_id='.$row['cat_prod_id'].'"><img src="images/delete.PNG"  border="0" title="حذف" width="10%" height="10%"></img></a></td>
				</tr>
			';
		
		}
		$outHtml .= '<div> <button type="button" onclick=window.open("?pg=prodMgmtPg_det&cmd=regProd_catFrm&cat_prod_name='.$row['cat_prod_name'].'&ph_code='.$ph_code.'&province_name='.$provinceName.'&name_customer='.$row5['name_customer'].'&province_id='.$_SESSION['dm_user_profile']['u_province_id'] .'","_self") value=" چاپ فاكتور"  value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF"> ایجاد دسته بندی جدید</button></div>
		';
    }else{
    		$outHtml .= '<div> <button type="button" onclick=window.open("?pg=prodMgmtPg_det&cmd=regProd_catFrm&cat_prod_name='.$row['cat_prod_name'].'&ph_code='.$ph_code.'&province_name='.$provinceName.'&name_customer='.$row5['name_customer'].'&province_id='.$_SESSION['dm_user_profile']['u_province_id'] .'","_self") value=" چاپ فاكتور"  value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF"> ایجاد دسته بندی جدید</button></div>
		';
    	$outHtml .= '<tr class="rw1"><td colspan="10">هیچ اطلاعاتی موجود نیست</td></tr>';
    }
     $outHtml .= '</table>
</div><br>'.getNavBar_pdc().' '.getRPPCombo_pdc();
   
    return $outHtml;
		
}

function getNavBar_pdc(){
	$out = '
		<table style="direction:ltr" >
			<tr>
			
	';
	//if($stNum>$_SESSION['pageCount']) $stNum=$_SESSION['pageCount']-5;
	
	$stNum = $_SESSION['crntPage']-5;
	if($stNum<1) $stNum=1;
	$out .= '
		<td><a href="?pg=prodMgmtPg_det&cmd=category_prod&cmd2=setPg&pgNum=1" ><img src="images/first.gif" title="ابتدا"></img></a></td>
		<td>&nbsp;&nbsp;</td>
		<td><a href="?pg=prodMgmtPg_det&cmd=category_prod&cmd2=setPg&pgNum='.((($_SESSION['crntPage']-1)<1) ? 1 : ($_SESSION['crntPage']-1)).'" ><img src="images/prev.gif" title="قبلي"></img></a></td>
		<td>&nbsp;&nbsp;</td>
	';
	$inx = 0;
	while(($inx<10) && (($stNum+$inx) <= $_SESSION['pageCount'])){
		$out .= '
			<td><a '.(($_SESSION['crntPage']==($stNum+$inx)) ? ' style="text-decoration:none; font-weight:bold;" ':'').' href="?pg=prodMgmtPg_det&cmd=category_prod&cmd2=setPg&pgNum='.($stNum+$inx).'" ><div style="background:#cccccc;">'.($stNum+$inx).'</div></a></td><td>&nbsp;</td>
		';
		
		$inx++;
	}
	$out .= '
		<td><a href="?pg=prodMgmtPg_det&cmd=category_prod&cmd2=setPg&pgNum='.((($_SESSION['crntPage']+1)<=$_SESSION['pageCount']) ? ($_SESSION['crntPage']+1) : $_SESSION['pageCount']).'" ><img src="images/next.gif" title="بعدي"></img></a></td>
		<td>&nbsp;&nbsp;</td>
		<td><a href="?pg=prodMgmtPg_det&cmd=category_prod&cmd2=setPg&pgNum='.$_SESSION['pageCount'].'" ><img src="images/last.gif" title="انتها"></img></a></td>
	';
	
	$out .= '
			</tr>
		</table>
	';	
	return $out;
}

function getRPPCombo_pdc(){
	$out = '<span style="align:center;">
	
		<select onchange="window.open(\'?pg=prodMgmtPg_det&cmd=category_prod&cmd2=setRPP&rPP=\'+this.value, \'_self\')" style="width:50px;" >
			<option value="1" '.(($_SESSION['rPP']==1)?' selected="selected" ':'').' > 1 </option>
			<option value="5" '.(($_SESSION['rPP']==5)?' selected="selected" ':'').' > 5 </option>
			<option value="10" '.(($_SESSION['rPP']==10)?' selected="selected" ':'').' > 10 </option>
			<option value="25" '.(($_SESSION['rPP']==25)?' selected="selected" ':'').' > 25 </option>
			<option value="50" '.(($_SESSION['rPP']==30)?' selected="selected" ':'').' > 50 </option>
			<option value="100" '.(($_SESSION['rPP']==100)?' selected="selected" ':'').' > 100 </option>
			<option value="1000000" '.(($_SESSION['rPP']==0)?' selected="selected" ':'').' > all </option>
		</select>
		
	<span style="color:blue;"><b>پاسخ در صفحه</b></span>
	</div>';
	return $out;
}
function regProd_catFrm(){
	$_SESSION['cat_prode_save']=1;
	
	?>
	
<form method="post" action="" id="commentForm">
			<input type="hidden" name="pg" value="prodMgmtPg_det">   
			<input type="hidden" name="cmd" value="regProd_cat">	
		<table  align="center" class="nasi" style="font-weight:bold;" >
		  	<tr style="background-color:<?php echo $_SESSION['htablecolor'] ?>;font-weight:bold;">
			       <td colspan="8"  style="height: 50px;vertical-align:middle;"  ><font size="5">دسته بندی کالا</font></td>
	       </tr>
	       <tr>
	            <td colspan="8"><hr style="color:<?php echo $_SESSION['htablecolor'] ?>;height:40%;"></hr></td>
	       </tr>
	      	<tr>
		      	 <td>&nbsp;</td>
		         <td colspan="2"><center>نام دسته بندی </center></td>
			     <td><input name="cat_prod_name" id="cat_prod_name" type="text" /></td>		       
	             <td colspan="2"><button  type="submit"  value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF">ذخیره</button></td>
			     <td colspan="2">&nbsp;</td>	  
	        </tr>
	          <tr>   
	               
			   <td colspan="5">&nbsp;</td>
			         
	      	</tr>
	      	
	    </table>
	
	</form>

	<?php
	
}
function regProd_cat(){
	
	if($_SESSION['cat_prode_save']==1){
		
	$cat_prod_name = isset($_REQUEST['cat_prod_name']) ? $_REQUEST['cat_prod_name'] : '';
	
	$query = "
				INSERT INTO dm_prod_det_c  
					(    			
					    `cat_prod_name`, 
					    `cat_u_id`, 
						`cat_prod_date`				
					)
					
				VALUES
					(   '".$cat_prod_name."',
					    '".$_SESSION['dm_user_profile']['u_id'] ."',			
						'".gmdate('Y-m-d')."'			
					)";
		
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
	$_SESSION['cat_prode_save']=0;
	$cat_prod_id = mysql_insert_id();
	return $cat_prod_id;	
	
	}
	$_SESSION['cat_prode_save']=0;
}
function cat_prodEditFrm(){
	
$cat_prod_id  = isset($_REQUEST['cat_prod_id']) ? (int)($_REQUEST['cat_prod_id']) : 0;
	if($cat_prod_id<1) die('Invalid product id!');
	
	$lnk = mysql_query("SELECT * FROM dm_prod_det_c  WHERE  cat_prod_id=".$cat_prod_id);
	
		$row = mysql_fetch_assoc($lnk);
		
	
		?>

	<form method="post" action="" >
	   	
		<input type="hidden" name="pg" value="prodMgmtPg_det">   
		<input type="hidden" name="cmd" value="cat_prod_update">  
		<input type="hidden" name="cat_prod_id" id="cat_prod_id" value="<?php echo $cat_prod_id; ?>">   
		<table  align="center"  class="nasi"   >
		  	<tr style="background-color:<?php echo $_SESSION['htablecolor'] ?>;" >
		       <td colspan="8"  style="height: 50px;vertical-align:middle;"  ><b><font size="5">دسته بندی کالا</font></b></td>
	        </tr>
	        <tr>
	           <td colspan="8"><hr style="color:<?php echo $_SESSION['htablecolor'] ?>;height:40%;"></hr></td>
	       </tr>
	      	<tr>
		       	<td ><center>نام دسته بندی </center> </td>
		        <td><input name="cat_prod_name" id="cat_prod_name" type="text" value="<?php echo $row['cat_prod_name']; ?>" /></td>
                 <td colspan="2"><button  type="submit"  value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF">ذخیره</button></td>
			     <td colspan="2">&nbsp;</td>	  
	        </tr>
	          <tr>   
	                
			   <td colspan="5">&nbsp;</td>
			      
	      	</tr>
	      		  
	    </table>
	</form>
	
	<?php	
}
function cat_prodDelete(){
	$cat_prod_id = isset($_REQUEST['cat_prod_id']) ? (int)($_REQUEST['cat_prod_id']) : 0;
		if($cat_prod_id<1) die('Inv Id');
		
		$query = "
		DELETE FROM dm_prod_det_c
	 
			WHERE 
				cat_prod_id = ".$cat_prod_id." 
		";
		$lnk = mysql_query($query);
		if(mysql_error()) print mysql_error();
	
}
function pack_prodDelete(){
	$pack_prod_id = isset($_REQUEST['pack_prod_id']) ? (int)($_REQUEST['pack_prod_id']) : 0;
		if($pack_prod_id<1) die('Inv Id');
		
		$query = "
		DELETE FROM dm_prod_det_p
	 
			WHERE 
				pack_prod_id = ".$pack_prod_id." 
		";
		$lnk = mysql_query($query);
		if(mysql_error()) print mysql_error();
	
}
function type_prodDelete(){
		$type_prod_id = isset($_REQUEST['type_prod_id']) ? (int)($_REQUEST['type_prod_id']) : 0;
		if($type_prod_id<1) die('Inv Id');
		
		$query = "
		DELETE FROM dm_prod_det_t
	 
			WHERE 
				type_prod_id = ".$type_prod_id." 
		";
		$lnk = mysql_query($query);
		if(mysql_error()) print mysql_error();
	
	
}
function unit_prodDelete(){

$unit_prod_id = isset($_REQUEST['unit_prod_id']) ? (int)($_REQUEST['unit_prod_id']) : 0;
		if($unit_prod_id<1) die('Inv Id');
		
		$query = "
		DELETE FROM dm_prod_det_u
	 
			WHERE 
				unit_prod_id = ".$unit_prod_id." 
		";
		$lnk = mysql_query($query);
		if(mysql_error()) print mysql_error();
	
}
function doc_typeDelete(){
	$doc_t_id = isset($_REQUEST['doc_t_id']) ? (int)($_REQUEST['doc_t_id']) : 0;
		if($doc_t_id<1) die('Inv Id');
		
		$query = "
		DELETE FROM dm_doc_det_t 
	 
			WHERE 
				doc_t_id = ".$doc_t_id." 
		";
		$lnk = mysql_query($query);
		if(mysql_error()) print mysql_error();
	
	
}
function doc_typebDelete(){
	$doc_b_id = isset($_REQUEST['doc_b_id']) ? (int)($_REQUEST['doc_b_id']) : 0;
		if($doc_b_id<1) die('Inv Id');
		
		$query = "
		DELETE FROM dm_doc_det_b 
	 
			WHERE 
				doc_b_id = ".$doc_b_id." 
		";
		$lnk = mysql_query($query);
		if(mysql_error()) print mysql_error();
	
}
function cat_prod_update(){
	
$cat_prod_id = isset($_REQUEST['cat_prod_id']) ? (int)($_REQUEST['cat_prod_id']) : 0;
	if($cat_prod_id<1) die('Inv Id');
	
	$cat_prod_name = isset($_REQUEST['cat_prod_name']) ? $_REQUEST['cat_prod_name'] : '';
	
	
	$query = "
		UPDATE dm_prod_det_c
		SET 
			`cat_prod_name` = '".$cat_prod_name."',
			`cat_u_id` = '".$_SESSION['dm_user_profile']['u_id'] ."',
			`cat_prod_date` = '".gmdate('Y-m-d')."'	 
			
		WHERE 
			cat_prod_id = ".$cat_prod_id." 
	";
	//print $query;
	//die($query);
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
}
//package
	function pack_prod(){

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
	
	$outHtml = '	<br>
		<form method="get" action="">
			<input type="hidden" name="pg" value="prodMgmtPg_det">   
			<input type="hidden" name="cmd" value="searchPack_prod"> 
			 کلمه مورد نظر را وارد كنيد 
			<div> جستجو : <input type="text" name="search" value="'.$_SESSION['srchStr'].'" style="width:100px;"/> 
			  <button value="draft" name="commit" type="submit">جستجو</button> </div>
		</form>
	';
	
	$outHtml .= '<br>	
		<div align = "center">
		 <div align = "center" style="width:70%;height:200px; overflow:auto">
			<table border="5" align="center" cellpadding="0" cellspacing="0"  class="list" >
      			<tr class="rw1">
        			<th colspan="20" align="center" scope="row" style="height: 50px;vertical-align:middle;"><center>بسته بندی کالاها </center></th>
        		</tr>
        		
      			<tr class="rw0" style="font-weight:bold;">
      			    <td align="center">رديف</td>
			        <td align="center">نام توع کالا</td>
			        <td align="center">تاریخ تعریف </td>
			         <td align="center" colspan="2">&nbsp </td>
			       
				</tr>
	';
	 
			
	if(!isset($_SESSION['srchStr'])) $_SESSION['srchStr'] = '';
	if(!isset($_SESSION['elmCount'])) $_SESSION['elmCount'] = 0;
	if(!isset($_SESSION['rPP'])) $_SESSION['rPP'] = 10;//results per page
	if(!isset($_SESSION['pageCount'])) $_SESSION['pageCount'] = 1;//results page conut
	if(!isset($_SESSION['crntPage'])) $_SESSION['crntPage'] = 1;//current page number
	if($_SESSION['srchStr']==''){
		$srchQ = "";
		
	}else{
		$srchQ = " 
			AND(
					pack_prod_name LIKE '%".$_SESSION['srchStr']."%' 
				
			)
		";
		
	}
	$typeQ = '';
	
	$genQuery = "
		
		FROM 
			dm_prod_det_p 
		WHERE 
			1 
		".$srchQ." 
		".$typeQ." 
		
	";
	
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
	$_SESSION['srchStr'] = '';	
	$lnk = mysql_query($resQuery);
	$inx = ((($_SESSION['crntPage']-1)*$_SESSION['rPP'])+1);		
	if(mysql_affected_rows()>0){	
	$inx--;
		while($row = mysql_fetch_assoc($lnk)){
			
			$gdate=$row['pack_prod_date'];
			list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
			list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
			$jdate = $jyear."/".$jmonth."/".$jday;
			
			if(($inx)%2==1)
				$class="rw0";
				else
				$class="rw1";
			$inx++;
			
			$outHtml .= '
				<tr class='.$class.'>
					<td align="center">'.$inx.'</td>
					<td align="center">'.$row['pack_prod_name'].'</td>
					<td align="center">'.$jdate.'</td>					
					<td align="center"><a href="?pg=prodMgmtPg_det&cmd=pack_prodEditFrm&pack_prod_id='.$row['pack_prod_id'].'"><img src="images/edit.png"  width="10%" height="10%"   border="0" title="ويرايش"></img></a></td>
					<td align="center"><a href="?pg=prodMgmtPg_det&cmd=pack_prodDelete&pack_prod_id='.$row['pack_prod_id'].'"><img src="images/delete.PNG"  width="10%" height="10%"   border="0" title="حذف"></img></a></td>
				</tr>
			';
		}
		$outHtml .= '<div> <button type="button" onclick=window.open("?pg=prodMgmtPg_det&cmd=regProd_packFrm&cat_pack_name='.$row['cat_pack_name'].'","_self") value=" چاپ فاكتور"  value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF"> ایجاد بسته جدید</button></td>
		';
		
    }else{
    	$outHtml .= '<div> <button type="button" onclick=window.open("?pg=prodMgmtPg_det&cmd=regProd_packFrm&cat_pack_name='.$row['cat_pack_name'].'","_self") value=" چاپ فاكتور"  value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF"> ایجاد بسته جدید</button></div>
    	<tr class="rw1"><td colspan="10">هیچ اطلاعاتی موجود نیست</td></tr>';
    }
     $outHtml .= '</table>
</div><br>'.getNavBar_pack().' '.getRPPCombo_pack();
   
    return $outHtml;
		
}

function getNavBar_pack(){
	$out = '
		<table style="direction:ltr" >
			<tr>
			
	';
	//if($stNum>$_SESSION['pageCount']) $stNum=$_SESSION['pageCount']-5;
	
	$stNum = $_SESSION['crntPage']-5;
	if($stNum<1) $stNum=1;
	$out .= '
		<td><a href="?pg=prodMgmtPg_det&cmd=pack_prod&cmd2=setPg&pgNum=1" ><img src="images/first.gif" title="ابتدا"></img></a></td>
		<td>&nbsp;&nbsp;</td>
		<td><a href="?pg=prodMgmtPg_det&cmd=pack_prod&cmd2=setPg&pgNum='.((($_SESSION['crntPage']-1)<1) ? 1 : ($_SESSION['crntPage']-1)).'" ><img src="images/prev.gif" title="قبلي"></img></a></td>
		<td>&nbsp;&nbsp;</td>
	';
	$inx = 0;
	while(($inx<10) && (($stNum+$inx) <= $_SESSION['pageCount'])){
		$out .= '
			<td><a '.(($_SESSION['crntPage']==($stNum+$inx)) ? ' style="text-decoration:none; font-weight:bold;" ':'').' href="?pg=prodMgmtPg_det&cmd=pack_prod&cmd2=setPg&pgNum='.($stNum+$inx).'" ><div style="background:#cccccc;">'.($stNum+$inx).'</div></a></td><td>&nbsp;</td>
		';
		
		$inx++;
	}
	$out .= '
		<td><a href="?pg=prodMgmtPg_det&cmd=pack_prod&cmd2=setPg&pgNum='.((($_SESSION['crntPage']+1)<=$_SESSION['pageCount']) ? ($_SESSION['crntPage']+1) : $_SESSION['pageCount']).'" ><img src="images/next.gif" title="بعدي"></img></a></td>
		<td>&nbsp;&nbsp;</td>
		<td><a href="?pg=prodMgmtPg_det&cmd=pack_prod&cmd2=setPg&pgNum='.$_SESSION['pageCount'].'" ><img src="images/last.gif" title="انتها"></img></a></td>
	';
	
	$out .= '
			</tr>
		</table>
	';	
	return $out;
}

function getRPPCombo_pack(){
	$out = '<span style="align:center;">
	
		<select onchange="window.open(\'?pg=prodMgmtPg_det&cmd=pack_prod&cmd2=setRPP&rPP=\'+this.value, \'_self\')" style="width:50px;" >
			<option value="1" '.(($_SESSION['rPP']==1)?' selected="selected" ':'').' > 1 </option>
			<option value="5" '.(($_SESSION['rPP']==5)?' selected="selected" ':'').' > 5 </option>
			<option value="10" '.(($_SESSION['rPP']==10)?' selected="selected" ':'').' > 10 </option>
			<option value="25" '.(($_SESSION['rPP']==25)?' selected="selected" ':'').' > 25 </option>
			<option value="50" '.(($_SESSION['rPP']==30)?' selected="selected" ':'').' > 50 </option>
			<option value="100" '.(($_SESSION['rPP']==100)?' selected="selected" ':'').' > 100 </option>
			<option value="1000000" '.(($_SESSION['rPP']==0)?' selected="selected" ':'').' > all </option>
		</select>
		
	<span style="color:blue;"><b>پاسخ در صفحه</b></span>
	</div>';
	return $out;
}
function regProd_packFrm(){
	
	$_SESSION['pack_prode_save']=1;
	
	?>
	
<form method="post" action="" id="commentForm">
			<input type="hidden" name="pg" value="prodMgmtPg_det">   
			<input type="hidden" name="cmd" value="regpack_prod">	
		<table  align="center" class="nasi" style="font-weight:bold;" >
		  	<tr style="background-color:<?php echo $_SESSION['htablecolor'] ?>;font-weight:bold;">
			       <td colspan="8"  style="height: 50px;vertical-align:middle;"  ><font size="5">بسته بندی کالا</font></td>
	       </tr>
	       <tr>
	            <td colspan="8"><hr style="color:<?php echo $_SESSION['htablecolor'] ?>;height:40%;"></hr></td>
	       </tr>
	      	<tr>
		      	 <td>&nbsp;</td>
		         <td colspan="2"><center>نام دسته بندی </center></td>
			     <td><input name="pack_prod_name" id="pack_prod_name" type="text" /></td>		       
	             <td colspan="2"><button  type="submit"  value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF">ذخیره</button></td>
			     <td colspan="2">&nbsp;</td>	  
	        </tr>
	          <tr>   
	                  
			   <td colspan="5">&nbsp;</td>
			     
	      	</tr>
	      	
	    </table>
	
	</form>

	<?php
	
}
function regpack_prod(){
	
	if($_SESSION['pack_prode_save']==1){
		
	$pack_prod_name = isset($_REQUEST['pack_prod_name']) ? $_REQUEST['pack_prod_name'] : '';
	
	$query = "
		INSERT INTO dm_prod_det_p 
			(    
			
			    `pack_prod_name`, 
			    `pack_u_id`,
				`pack_prod_date`
				
			)
			
		VALUES
			(  '".$pack_prod_name."',
			   '".$_SESSION['dm_user_profile']['u_id'] ."',			
			   '".gmdate('Y-m-d')."'	 
			
			)
	";
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
	$_SESSION['cat_prode_save']=0;
	$pack_prod_id = mysql_insert_id();
	return $pack_prod_id;	
	
	}
	$_SESSION['pack_prode_save']=0;
}
function pack_prodEditFrm(){
	
$pack_prod_id  = isset($_REQUEST['pack_prod_id']) ? (int)($_REQUEST['pack_prod_id']) : 0;

	if($pack_prod_id<1) die('Invalid id!');
	
	$lnk = mysql_query("SELECT * FROM dm_prod_det_p WHERE  pack_prod_id=".$pack_prod_id);
	
		$row = mysql_fetch_assoc($lnk);
	
		?>

	<form method="post" action="" >
	   	
		<input type="hidden" name="pg" value="prodMgmtPg_det">   
		<input type="hidden" name="cmd" value="pack_prod_update">  
		<input type="hidden" name="pack_prod_id" id="pack_prod_id" value="<?php echo $pack_prod_id; ?>">   
		<table  align="center"  class="nasi"   >
		  	<tr style="background-color:<?php echo $_SESSION['htablecolor'] ?>;" >
		       <td colspan="8"  style="height: 50px;vertical-align:middle;"  ><b><font size="5">بسته بندی کالا</font></b></td>
	        </tr>
	        <tr>
	           <td colspan="8"><hr style="color:<?php echo $_SESSION['htablecolor'] ?>;height:40%;"></hr></td>
	       </tr>
	      	<tr>
		       	<td ><center>نام بسته کالا </center> </td>
		        <td><input name="pack_prod_name" id="pack_prod_name" type="text" value="<?php echo $row['pack_prod_name']; ?>" /></td>
                  <td colspan="2"><button  type="submit"  value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF">ذخیره</button></td>
			     <td colspan="2">&nbsp;</td>	  
	        </tr>
	          <tr>   
	                
			   <td colspan="5">&nbsp;</td>
			       
	      	</tr>
	      		  
	    </table>
	</form>
	
	<?php	
}
function pack_prod_update(){
	
$pack_prod_id = isset($_REQUEST['pack_prod_id']) ? (int)($_REQUEST['pack_prod_id']) : 0;
	if($pack_prod_id<1) die('Inv Id');
	
	$pack_prod_name = isset($_REQUEST['pack_prod_name']) ? $_REQUEST['pack_prod_name'] : '';
//	echo $pack_prod_name ;
	
	$query = "
		UPDATE dm_prod_det_p 
		SET 
			`pack_prod_name` = '".$pack_prod_name."',
			 `pack_u_id` = '".$_SESSION['dm_user_profile']['u_id'] ."',
			`pack_prod_date` = '".gmdate('Y-m-d')."' 
			
		WHERE 
			pack_prod_id = ".$pack_prod_id." 
	";
//	print $query;
	//die($query);
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
}	
//type
	function type_prod(){

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
	
	$outHtml = '	<br>
					<form method="get" action="">
						<input type="hidden" name="pg" value="prodMgmtPg_det">   
						<input type="hidden" name="cmd" value="searchPack_type"> 
						 کلمه مورد نظر را وارد كنيد 
						<div> جستجو : <input type="text" name="search" value="'.$_SESSION['srchStr'].'" style="width:100px;"/> 
						  <button value="draft" name="commit" type="submit">جستجو</button> </div>
					</form>
				';
	
	$outHtml .= '<br>	
		<div align = "center">
		 <div align = "center" style="width:50%;height:200px; overflow:auto">
			<table border="5" align="center" cellpadding="0" cellspacing="0" bgcolor=#99CCCC; class="list" >
      			<tr class="rw1">
        			<th colspan="20" align="center" scope="row" style="height: 50px;vertical-align:middle;"><center>انواع کالاها </center></th>
        		</tr>
        		
      			<tr class="rw0" style="font-weight:bold;">
      			    <td align="center">رديف</td>
			        <td align="center">نام توع کالا</td>
			        <td align="center">تاریخ تعریف </td>
			         <td align="center" colspan="2">&nbsp </td>
			       
				</tr>
	';
	
	if(!isset($_SESSION['srchStr'])) $_SESSION['srchStr'] = '';
	if(!isset($_SESSION['elmCount'])) $_SESSION['elmCount'] = 0;
	if(!isset($_SESSION['rPP'])) $_SESSION['rPP'] = 10;//results per page
	if(!isset($_SESSION['pageCount'])) $_SESSION['pageCount'] = 1;//results page conut
	if(!isset($_SESSION['crntPage'])) $_SESSION['crntPage'] = 1;//current page number
	if($_SESSION['srchStr']==''){
		$srchQ = "";
		
	}else{
		$srchQ = " 
			AND(
					type_prod_name LIKE '%".$_SESSION['srchStr']."%' 
				
			)
		";
		
	}
	$typeQ = '';
	
	$genQuery = "
		
		FROM 
			dm_prod_det_t 
		WHERE 
			1 
		".$srchQ." 
		".$typeQ." 
	";
	
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
	$_SESSION['srchStr'] = '';	
	$lnk = mysql_query($resQuery);
	$inx = ((($_SESSION['crntPage']-1)*$_SESSION['rPP'])+1);		
	if(mysql_affected_rows()>0){	
	$inx--;
		while($row = mysql_fetch_assoc($lnk)){
			
			$gdate=$row['type_prod_date'];
			list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
			list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
			$jdate = $jyear."/".$jmonth."/".$jday;
			
			if(($inx)%2==1)
				$class="rw0";
				else
				$class="rw1";
			$inx++;
			
			$outHtml .= '
				<tr class='.$class.'>
					<td align="center">'.$inx.'</td>
					<td align="center">'.$row['type_prod_name'].'</td>
					<td align="center">'.$jdate.'</td>					
					<td align="center"><a href="?pg=prodMgmtPg_det&cmd=type_prodEditFrm&type_prod_id='.$row['type_prod_id'].'"><img src="images/edit.png"  width="15%" height="15%"   border="0" title="ويرايش"></img></a></td>
					<td align="center"><a href="?pg=prodMgmtPg_det&cmd=type_prodDelete&type_prod_id='.$row['type_prod_id'].'"><img src="images/delete.PNG"  width="15%" height="15%"   border="0" title="حذف"></img></a></td>
				</tr>
			';
		}
		$outHtml .= '<div> <button type="button" onclick=window.open("?pg=prodMgmtPg_det&cmd=regProd_typeFrm&type_prod_name='.$row['type_prod_name'].'","_self") value=" چاپ فاكتور"  value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF"> ایجاد نوع جدید</button></div>
		';
		
    }else{
    	  
    	$outHtml .= '<div> <button type="button" onclick=window.open("?pg=prodMgmtPg_det&cmd=regProd_typeFrm&type_prod_name='.$row['type_prod_name'].'","_self") value=" چاپ فاكتور"  value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF"> ایجاد نوع جدید</button></div>
    	<tr class="rw1"><td colspan="10">هیچ اطلاعاتی موجود نیست</td></tr>';
    }
     $outHtml .= '</table>
</div><br>'.getNavBar_typep().' '.getRPPCombo_typep();
   
    return $outHtml;
		
}

function getNavBar_typep(){
	$out = '
		<table style="direction:ltr" >
			<tr>
			
	';
	//if($stNum>$_SESSION['pageCount']) $stNum=$_SESSION['pageCount']-5;
	
	$stNum = $_SESSION['crntPage']-5;
	if($stNum<1) $stNum=1;
	$out .= '
		<td><a href="?pg=prodMgmtPg_det&cmd=type_prod&cmd2=setPg&pgNum=1" ><img src="images/first.gif" title="ابتدا"></img></a></td>
		<td>&nbsp;&nbsp;</td>
		<td><a href="?pg=prodMgmtPg_det&cmd=type_prod&cmd2=setPg&pgNum='.((($_SESSION['crntPage']-1)<1) ? 1 : ($_SESSION['crntPage']-1)).'" ><img src="images/prev.gif" title="قبلي"></img></a></td>
		<td>&nbsp;&nbsp;</td>
	';
	$inx = 0;
	while(($inx<10) && (($stNum+$inx) <= $_SESSION['pageCount'])){
		$out .= '
			<td><a '.(($_SESSION['crntPage']==($stNum+$inx)) ? ' style="text-decoration:none; font-weight:bold;" ':'').' href="?pg=prodMgmtPg_det&cmd=type_prod&cmd2=setPg&pgNum='.($stNum+$inx).'" ><div style="background:#cccccc;">'.($stNum+$inx).'</div></a></td><td>&nbsp;</td>
		';
		
		$inx++;
	}
	$out .= '
		<td><a href="?pg=prodMgmtPg_det&cmd=type_prod&cmd2=setPg&pgNum='.((($_SESSION['crntPage']+1)<=$_SESSION['pageCount']) ? ($_SESSION['crntPage']+1) : $_SESSION['pageCount']).'" ><img src="images/next.gif" title="بعدي"></img></a></td>
		<td>&nbsp;&nbsp;</td>
		<td><a href="?pg=prodMgmtPg_det&cmd=type_prod&cmd2=setPg&pgNum='.$_SESSION['pageCount'].'" ><img src="images/last.gif" title="انتها"></img></a></td>
	';
	
	$out .= '
			</tr>
		</table>
	';	
	return $out;
}

function getRPPCombo_typep(){
	$out = '<span style="align:center;">
	
		<select onchange="window.open(\'?pg=prodMgmtPg_det&cmd=type_prod&cmd2=setRPP&rPP=\'+this.value, \'_self\')" style="width:50px;" >
			<option value="1" '.(($_SESSION['rPP']==1)?' selected="selected" ':'').' > 1 </option>
			<option value="5" '.(($_SESSION['rPP']==5)?' selected="selected" ':'').' > 5 </option>
			<option value="10" '.(($_SESSION['rPP']==10)?' selected="selected" ':'').' > 10 </option>
			<option value="25" '.(($_SESSION['rPP']==25)?' selected="selected" ':'').' > 25 </option>
			<option value="50" '.(($_SESSION['rPP']==30)?' selected="selected" ':'').' > 50 </option>
			<option value="100" '.(($_SESSION['rPP']==100)?' selected="selected" ':'').' > 100 </option>
			<option value="1000000" '.(($_SESSION['rPP']==0)?' selected="selected" ':'').' > all </option>
		</select>
		
	<span style="color:blue;"><b>پاسخ در صفحه</b></span>
	</div>';
	return $out;
}
function regProd_typeFrm(){
	
	$_SESSION['type_prode_save']=1;
	
	?>
	
<form method="post" action="" id="commentForm">
			<input type="hidden" name="pg" value="prodMgmtPg_det">   
			<input type="hidden" name="cmd" value="regtype_prod">	
		<table  align="center" class="nasi" style="font-weight:bold;" >
			  	<tr style="background-color:<?php echo $_SESSION['htablecolor'] ?>;font-weight:bold;">
				     <td colspan="8"  style="height: 50px;vertical-align:middle;"  ><font size="5">انواع کالا</font></td>
		        </tr>
		        <tr>
		             <td colspan="8"><hr style="color:<?php echo $_SESSION['htablecolor'] ?>;height:40%;"></hr></td>
		        </tr>
		      	<tr>
			      	 <td>&nbsp;</td>
			         <td colspan="2"><center>نام نوع کالا </center></td>
				     <td><input name="type_prod_name" id="type_prod_name" type="text" /></td>		       
		             <td colspan="2"><button  type="submit"  value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF">ذخیره</button></td>
				     <td colspan="2">&nbsp;</td>	  
		         </tr>
		         <tr>   		               
				     <td colspan="5">&nbsp;</td>				        
		      	 </tr>	      	
	    </table>
	
	</form>

	<?php
	
}
function regtype_prod(){
	
	if($_SESSION['type_prode_save']==1){
		
	$type_prod_name = isset($_REQUEST['type_prod_name']) ? $_REQUEST['type_prod_name'] : '';
	
	$query = "
		INSERT INTO dm_prod_det_t 
			(    
			
			    `type_prod_name`, 
			    `type_u_id`, 
				`type_prod_date`
				
			)
			
		VALUES
			(  '".$type_prod_name."',	
			   '".$_SESSION['dm_user_profile']['u_id'] ."',			
				'".gmdate('Y-m-d')."'
			
			)
	";
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
	$_SESSION['type_prode_save']=0;
	$type_prod_id = mysql_insert_id();
	return $type_prod_id;	
	
	}
	$_SESSION['type_prode_save']=0;
}
function type_prodEditFrm(){
	
$type_prod_id  = isset($_REQUEST['type_prod_id']) ? (int)($_REQUEST['type_prod_id']) : 0;

	if($type_prod_id<1) die('Invalid id!');
	
	$lnk = mysql_query("SELECT * FROM dm_prod_det_t WHERE  type_prod_id=".$type_prod_id);
	
		$row = mysql_fetch_assoc($lnk);
	
		?>

	<form method="post" action="" >
	   	
		<input type="hidden" name="pg" value="prodMgmtPg_det">   
		<input type="hidden" name="cmd" value="type_prod_update">  
		<input type="hidden" name="type_prod_id" id="type_prod_id" value="<?php echo $type_prod_id; ?>">   
		<table  align="center"  class="nasi"   >
		  	<tr style="background-color:<?php echo $_SESSION['htablecolor'] ?>;" >
		       <td colspan="8"  style="height: 50px;vertical-align:middle;"  ><b><font size="5">نوع کالا</font></b></td>
	        </tr>
	        <tr>
	           <td colspan="8"><hr style="color:<?php echo $_SESSION['htablecolor'] ?>;height:40%;"></hr></td>
	       </tr>
	      	<tr>
		       	<td ><center>نام توع کالا </center> </td>
		        <td><input name="type_prod_name" id="type_prod_name" type="text" value="<?php echo $row['type_prod_name']; ?>" /></td>
                  <td colspan="2"><button  type="submit"  value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF">ذخیره</button></td>
			     <td colspan="2">&nbsp;</td>	  
	        </tr>
	          <tr>   
	               
			   <td colspan="5">&nbsp;</td>
			        
	      	</tr>
	      		  
	    </table>
	</form>
	
	<?php	
}
function type_prod_update(){
	
$type_prod_id = isset($_REQUEST['type_prod_id']) ? (int)($_REQUEST['type_prod_id']) : 0;
	if($type_prod_id<1) die('Inv Id');
	
	$type_prod_name = isset($_REQUEST['type_prod_name']) ? $_REQUEST['type_prod_name'] : '';
	
	
	$query = "
		UPDATE dm_prod_det_t 
		SET 
			`type_prod_name` = '".$type_prod_name."',
			`type_u_id` = '".$_SESSION['dm_user_profile']['u_id'] ."',
			`type_prod_date` = ".gmdate('Y-m-d')." 
			
		WHERE 
			type_prod_id = ".$type_prod_id." 
	";
	//print $query;
	//die($query);
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
}	
//unit
	function unit_prod(){

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
	
	$outHtml = '	<br>
		<form method="get" action="">
			<input type="hidden" name="pg" value="prodMgmtPg_det">   
			<input type="hidden" name="cmd" value="searchProd_unit"> 
			 کلمه مورد نظر را وارد كنيد 
			<div> جستجو : <input type="text" name="search" value="'.$_SESSION['srchStr'].'" style="width:100px;"/> 
			  <button value="draft" name="commit" type="submit">جستجو</button> </div>
		</form>
	';
	
	$outHtml .= '<br>	
		<div align = "center">
		 <div align = "center" style="width:50%;height:200px; overflow:auto">
			<table border="5" align="center" cellpadding="0" cellspacing="0" bgcolor=#99CCCC; class="list" >
      			<tr class="rw1">
        			<th colspan="20" align="center" scope="row" style="height: 50px;vertical-align:middle;"><center>انواع واحدها </center></th>
        		</tr>
        		
      			<tr class="rw0" style="font-weight:bold;">
      			    <td align="center">رديف</td>
			        <td align="center">نام واحد کالا</td>
			        <td align="center">تاریخ تعریف </td>
			        <td align="center">نوع واحد </td>
			        <td align="center">واحد اصلی </td>
			        <td align="center">  ضریب تبدیل</td>
			        
			         <td align="center" colspan="2">&nbsp </td>
			       
				</tr>
	';
	global $p_unit;
	if(!isset($_SESSION['srchStr'])) $_SESSION['srchStr'] = '';
	if(!isset($_SESSION['elmCount'])) $_SESSION['elmCount'] = 0;
	if(!isset($_SESSION['rPP'])) $_SESSION['rPP'] = 10;//results per page
	if(!isset($_SESSION['pageCount'])) $_SESSION['pageCount'] = 1;//results page conut
	if(!isset($_SESSION['crntPage'])) $_SESSION['crntPage'] = 1;//current page number
	if($_SESSION['srchStr']==''){
		$srchQ = "";
		
	}else{
		$srchQ = " 
			AND(
					unit_prod_name LIKE '%".$_SESSION['srchStr']."%' 
				
			)
		";
		
	}
	$typeQ = '';
	
	$genQuery = "
		
		FROM 
			dm_prod_det_u 
		WHERE 
			1 
		".$srchQ." 
		".$typeQ." 
	";
	
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
	$_SESSION['srchStr'] = '';	
	$lnk = mysql_query($resQuery);
	$inx = ((($_SESSION['crntPage']-1)*$_SESSION['rPP'])+1);		
	if(mysql_affected_rows()>0){	
	$inx--;
		while($row = mysql_fetch_assoc($lnk)){
			
			$gdate=$row['unit_prod_date'];
			list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
			list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
			$jdate = $jyear."/".$jmonth."/".$jday;
			$p_unit1 = $p_unit[$row['unit_prod_type']]['title'];
            $p_unit2 = $p_unit[$row['unit_prod_type']]['cmnt'];
   $query1="SELECT * FROM  dm_prod_det_u WHERE unit_prod_id=".$row['unit_prod_master']."";
///	print $query;
	$lnk1 = mysql_query($query1);
	$row1 = mysql_fetch_assoc($lnk1);
			if(($inx)%2==1)
				$class="rw0";
				else
				$class="rw1";
			$inx++;
			
			$outHtml .= '
				<tr class='.$class.'>
					<td align="center">'.$inx.'</td>
					<td align="center">'.$row['unit_prod_name'].'</td>
					<td align="center">'.$jdate.'</td>	
					<td title="'.$p_unit2.'" align="center">'.$p_unit1.'</td>
					<td align="center">'.$row1['unit_prod_name'].'</td>	
					<td align="center">'.$row1['unit_prod_ratio'].'</td>					
					<td align="center"><a href="?pg=prodMgmtPg_det&cmd=unit_prodEditFrm&unit_prod_id='.$row['unit_prod_id'].'"><img src="images/edit.png"  width="15%" height="15%"   border="0" title="ويرايش"></img></a></td>
					<td align="center"><a href="?pg=prodMgmtPg_det&cmd=unit_prodDelete&unit_prod_id='.$row['unit_prod_id'].'"><img src="images/delete.PNG"  width="15%" height="15%"   border="0" title="حذف"></img></a></td>
				</tr>
			';
		}
		$outHtml .= '<div> <button type="button" onclick=window.open("?pg=prodMgmtPg_det&cmd=regProd_unitFrm&unit_prod_name='.$row['unit_prod_name'].'","_self") value=" چاپ فاكتور"  value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF"> ایجاد واحد جدید</button></div>
		';
		
    }else{
    	$outHtml .= '<div> <button type="button" onclick=window.open("?pg=prodMgmtPg_det&cmd=regProd_unitFrm&unit_prod_name='.$row['unit_prod_name'].'","_self") value=" چاپ فاكتور"  value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF"> ایجاد واحد جدید</button></div>
    	<tr class="rw1"><td colspan="10">هیچ اطلاعاتی موجود نیست</td></tr>';
    }
     $outHtml .= '</table>
</div><br>'.getNavBar_unit().' '.getRPPCombo_unit();
   
    return $outHtml;
		
}

function getNavBar_unit(){
	$out = '
		<table style="direction:ltr" >
			<tr>
			
	';
	//if($stNum>$_SESSION['pageCount']) $stNum=$_SESSION['pageCount']-5;
	
	$stNum = $_SESSION['crntPage']-5;
	if($stNum<1) $stNum=1;
	$out .= '
		<td><a href="?pg=prodMgmtPg_det&cmd=unit_prod&cmd2=setPg&pgNum=1" ><img src="images/first.gif" title="ابتدا"></img></a></td>
		<td>&nbsp;&nbsp;</td>
		<td><a href="?pg=prodMgmtPg_det&cmd=unit_prod&cmd2=setPg&pgNum='.((($_SESSION['crntPage']-1)<1) ? 1 : ($_SESSION['crntPage']-1)).'" ><img src="images/prev.gif" title="قبلي"></img></a></td>
		<td>&nbsp;&nbsp;</td>
	';
	$inx = 0;
	while(($inx<10) && (($stNum+$inx) <= $_SESSION['pageCount'])){
		$out .= '
			<td><a '.(($_SESSION['crntPage']==($stNum+$inx)) ? ' style="text-decoration:none; font-weight:bold;" ':'').' href="?pg=prodMgmtPg_det&cmd=type_prod&cmd2=setPg&pgNum='.($stNum+$inx).'" ><div style="background:#cccccc;">'.($stNum+$inx).'</div></a></td><td>&nbsp;</td>
		';
		
		$inx++;
	}
	$out .= '
		<td><a href="?pg=prodMgmtPg_det&cmd=unit_prod&cmd2=setPg&pgNum='.((($_SESSION['crntPage']+1)<=$_SESSION['pageCount']) ? ($_SESSION['crntPage']+1) : $_SESSION['pageCount']).'" ><img src="images/next.gif" title="بعدي"></img></a></td>
		<td>&nbsp;&nbsp;</td>
		<td><a href="?pg=prodMgmtPg_det&cmd=unit_prod&cmd2=setPg&pgNum='.$_SESSION['pageCount'].'" ><img src="images/last.gif" title="انتها"></img></a></td>
	';
	
	$out .= '
			</tr>
		</table>
	';	
	return $out;
}

function getRPPCombo_unit(){
	$out = '<span style="align:center;">
	
		<select onchange="window.open(\'?pg=prodMgmtPg_det&cmd=unit_prod&cmd2=setRPP&rPP=\'+this.value, \'_self\')" style="width:50px;" >
			<option value="1" '.(($_SESSION['rPP']==1)?' selected="selected" ':'').' > 1 </option>
			<option value="5" '.(($_SESSION['rPP']==5)?' selected="selected" ':'').' > 5 </option>
			<option value="10" '.(($_SESSION['rPP']==10)?' selected="selected" ':'').' > 10 </option>
			<option value="25" '.(($_SESSION['rPP']==25)?' selected="selected" ':'').' > 25 </option>
			<option value="50" '.(($_SESSION['rPP']==30)?' selected="selected" ':'').' > 50 </option>
			<option value="100" '.(($_SESSION['rPP']==100)?' selected="selected" ':'').' > 100 </option>
			<option value="1000000" '.(($_SESSION['rPP']==0)?' selected="selected" ':'').' > all </option>
		</select>
		
	<span style="color:blue;"><b>پاسخ در صفحه</b></span>
	</div>';
	return $out;
}

function regProd_unitFrm(){
	
	$_SESSION['unit_prode_save']=1;
	
	?>
	
<form method="post" action="" id="commentForm">
			<input type="hidden" name="pg" value="prodMgmtPg_det">   
			<input type="hidden" name="cmd" value="regunit_prod">	
		<table  align="center" class="nasi" style="font-weight:bold;" >
		  	<tr style="background-color:<?php echo $_SESSION['htablecolor'] ?>;font-weight:bold;">
			       <td colspan="8"  style="height: 50px;vertical-align:middle;"  ><font size="5">واحد کالا</font></td>
	       </tr>
	       <tr>
	            <td colspan="8"><hr style="color:<?php echo $_SESSION['htablecolor'] ?>;height:40%;"></hr></td>
	       </tr>
	      	<tr>
		      	
		         <td colspan="2"><center>نام واحد کالا </center></td>
			     <td><input name="unit_prod_name" id="unit_prod_name" type="text" /></td>
			     <td colspan="2"><center>نوع واحد </center></td>
                 <td>
			  				
			  		<?php echo getUnitpTypesComboBox('unit_prod_type') ?>
				</td>			
				</tr>
			<tr>	
			     <td colspan="2"><center>ضریب تبدیل </center></td>
			      <td><input name="unit_prod_ratio" id="unit_prod_ratio" type="text" /></td>
	
			    <td colspan="2"><center>واحد اصلی </center></td>
			    <td>
			     	<?php echo getMasterUnitTypesComboBox('unit_prod_master') ?>
			    </td>
		    </tr>
			 <tr>	       
	             <td colspan="2"><button  type="submit"  value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF">ذخیره</button></td>
			     <td colspan="2">&nbsp;</td>	  
	        </tr>
	          <tr>   
	                 
			   <td colspan="5">&nbsp;</td>
			      
	      	</tr>
	      	
	    </table>
	
	</form>

	<?php
	
}
function regunit_prod(){
	
	if($_SESSION['unit_prode_save']==1){
		
	$unit_prod_name = isset($_REQUEST['unit_prod_name']) ? $_REQUEST['unit_prod_name'] : '';
	$unit_prod_type = isset($_REQUEST['unit_prod_type']) ? $_REQUEST['unit_prod_type'] : '';
	$unit_prod_ratio = isset($_REQUEST['unit_prod_ratio']) ? $_REQUEST['unit_prod_ratio'] : '';
   $unit_prod_master = isset($_REQUEST['unit_prod_master']) ? $_REQUEST['unit_prod_master'] : '';
	
	$query = "
		INSERT INTO dm_prod_det_u 
			(    			
			    `unit_prod_name`, 
				`unit_prod_date`,
			    `unit_prod_type`, 
			     `unit_prod_master`, 
				`unit_prod_ratio`				
			)
			
		VALUES
			(  '".$unit_prod_name."',			
				'".gmdate('Y-m-d')."',
				'".$unit_prod_type."',
				'".$unit_prod_master."',
				'".$unit_prod_ratio."'
			
			)
	";
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
	$_SESSION['unit_prode_save']=0;
	$unit_prod_id = mysql_insert_id();
	return $unit_prod_id;	
	
	}
	$_SESSION['unit_prode_save']=0;
}
function unit_prodEditFrm(){
	
$unit_prod_id  = isset($_REQUEST['unit_prod_id']) ? (int)($_REQUEST['unit_prod_id']) : 0;

	if($unit_prod_id<1) die('Invalid id!');
	
	$lnk = mysql_query("SELECT * FROM dm_prod_det_u WHERE  unit_prod_id=".$unit_prod_id);
	
		$row = mysql_fetch_assoc($lnk);
	
		?>

	<form method="post" action="" >
	   	
		<input type="hidden" name="pg" value="prodMgmtPg_det">   
		<input type="hidden" name="cmd" value="unit_prod_update">  
		<input type="hidden" name="unit_prod_id" id="type_prod_id" value="<?php echo $unit_prod_id; ?>">   
		<table  align="center"  class="nasi"   >
		  	<tr style="background-color:<?php echo $_SESSION['htablecolor'] ?>;" >
		       <td colspan="8"  style="height: 50px;vertical-align:middle;"  ><b><font size="5">واحد کالا</font></b></td>
	        </tr>
	        <tr>
	           <td colspan="8"><hr style="color:<?php echo $_SESSION['htablecolor'] ?>;height:40%;"></hr></td>
	       </tr>
	       <tr>
	      	<td colspan="2" ><center>نوع واحد </center></td>
                 <td >
			  				
			  		<?php echo getUnitpTypesComboBox('unit_prod_type') ?>
				</td>			
				</tr>
			<tr>	
			     <td colspan="2"><center>ضریب واحد</center></td>
			      <td><input name="unit_prod_ratio" id="unit_prod_ratio" value="<?php echo $row['unit_prod_ratio']; ?>"  /></td>
	
			    <td colspan="2"><center>واحد اصلی </center></td>
			    <td>
			     	<?php echo getMasterUnitTypesComboBox('unit_prod_master') ?>
			    </td>
		    </tr>
	          <tr>   
	                  
			  	             <td colspan="5"><button  type="submit"  value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF">ذخیره</button></td>

			     
	      	</tr>
	      		  
	    </table>
	</form>
	
	<?php	
}
function unit_prod_update(){
	
$unit_prod_id = isset($_REQUEST['unit_prod_id']) ? (int)($_REQUEST['unit_prod_id']) : 0;
	if($unit_prod_id<1) die('Inv Id');
	
	$unit_prod_name = isset($_REQUEST['unit_prod_name']) ? $_REQUEST['unit_prod_name'] : '';
		$unit_prod_ratio = isset($_REQUEST['unit_prod_ratio']) ? $_REQUEST['unit_prod_ratio'] : '';
		$unit_prod_type = isset($_REQUEST['unit_prod_type']) ? $_REQUEST['unit_prod_type'] : '';
		$unit_prod_master = isset($_REQUEST['unit_prod_master']) ? $_REQUEST['unit_prod_master'] : '';
		
	
	$query = "
		UPDATE dm_prod_det_u 
		SET 
			`unit_prod_type` = '".$unit_prod_type."',
			`unit_prod_ratio` = '".$unit_prod_ratio."',
			`unit_prod_master` = '".$unit_prod_master."',
			`unit_prod_date` = ".gmdate('Y-m-d')." 
			
		WHERE 
			unit_prod_id = ".$unit_prod_id." 
	";
	//print $query;
	//die($query);
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
}
//doc type
function doc_type(){

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
	
	$outHtml = '	<br>
		<form method="get" action="">
			<input type="hidden" name="pg" value="prodMgmtPg_det">   
			<input type="hidden" name="cmd" value="searchdoc_type"> 
			 کلمه مورد نظر را وارد كنيد 
			<div> جستجو : <input type="text" name="search" value="'.$_SESSION['srchStr'].'" style="width:100px;"/> 
			  <button value="draft" name="commit" type="submit">جستجو</button> </div>
		</form>
	';
	
	$outHtml .= '<br>	
		<div align = "center">
		 <div align = "center" style="width:50%;height:200px; overflow:auto">
			<table border="5" align="center" cellpadding="0" cellspacing="0" bgcolor=#99CCCC; class="list" >
      			<tr class="rw1">
        			<th colspan="20" align="center" scope="row" style="height: 50px;vertical-align:middle;"><center>انواع سند </center></th>
        		</tr>
        		
      			<tr class="rw0" style="font-weight:bold;">
      			    <td align="center">رديف</td>
			        <td align="center">نوع سند</td>
			        <td align="center">تاریخ تعریف </td>
			         <td align="center" colspan="2">&nbsp </td>
			       
				</tr>
	';
	
	if(!isset($_SESSION['srchStr'])) $_SESSION['srchStr'] = '';
	if(!isset($_SESSION['elmCount'])) $_SESSION['elmCount'] = 0;
	if(!isset($_SESSION['rPP'])) $_SESSION['rPP'] = 10;//results per page
	if(!isset($_SESSION['pageCount'])) $_SESSION['pageCount'] = 1;//results page conut
	if(!isset($_SESSION['crntPage'])) $_SESSION['crntPage'] = 1;//current page number
	if($_SESSION['srchStr']==''){
		$srchQ = "";
		
	}else{
		$srchQ = " 
			AND(
					doc_t_name LIKE '%".$_SESSION['srchStr']."%' 
				
			)
		";
		
	}
	$typeQ = '';
	
	$genQuery = "
		
		FROM 
			dm_doc_det_t 
		WHERE 
			1 
		".$srchQ." 
		".$typeQ." 
		AND 
		doc_t_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
	";
	
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
		$_SESSION['srchStr'] = '';
	$lnk = mysql_query($resQuery);
	$inx = ((($_SESSION['crntPage']-1)*$_SESSION['rPP'])+1);		
	if(mysql_affected_rows()>0){	
	$inx--;
		while($row = mysql_fetch_assoc($lnk)){
			
			$gdate=$row['doc_t_date'];
			list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
			list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
			$jdate = $jyear."/".$jmonth."/".$jday;
			
			if(($inx)%2==1)
				$class="rw0";
				else
				$class="rw1";
			$inx++;
			
			$outHtml .= '
				<tr class='.$class.'>
					<td align="center">'.$inx.'</td>
					<td align="center">'.$row['doc_t_name'].'</td>
					<td align="center">'.$jdate.'</td>					
					<td align="center"><a href="?pg=prodMgmtPg_det&cmd=doc_typeEditFrm&doc_t_id='.$row['doc_t_id'].'"><img src="images/edit.png"  width="30%" height="30%"   border="0" title="ويرايش"></img></a></td>
					<td align="center"><a href="?pg=prodMgmtPg_det&cmd=doc_typeDelete&doc_t_id='.$row['doc_t_id'].'"><img src="images/delete.PNG"  width="30%" height="30%"   border="0" title="حذف"></img></a></td>
				</tr>
			';
		}
		$outHtml .= '
		<div> <button type="button" onclick=window.open("?pg=prodMgmtPg_det&cmd=regdoc_typeFrm&doc_t_name='.$row['doc_t_name'].'","_self")   value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF"> ایجاد سند جدید</button></div>
		';
		
    }else{
    	$outHtml .= '<div> <button type="button" onclick=window.open("?pg=prodMgmtPg_det&cmd=regdoc_typeFrm&doc_t_name='.$row['doc_t_name'].'","_self")   value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF"> ایجاد سند جدید</button></div>
    	            <tr class="rw1"><td colspan="10">هیچ اطلاعاتی موجود نیست</td></tr>';
    }
     $outHtml .= '</table>
</div><br>'.getNavBar_doc_type().' '.getRPPCombo_doc_type();
   
    return $outHtml;
		
}

function getNavBar_doc_type(){
	$out = '
		<table style="direction:ltr" >
			<tr>
			
	';
	//if($stNum>$_SESSION['pageCount']) $stNum=$_SESSION['pageCount']-5;
	
	$stNum = $_SESSION['crntPage']-5;
	if($stNum<1) $stNum=1;
	$out .= '
		<td><a href="?pg=prodMgmtPg_det&cmd=doc_type&cmd2=setPg&pgNum=1" ><img src="images/first.gif" title="ابتدا"></img></a></td>
		<td>&nbsp;&nbsp;</td>
		<td><a href="?pg=prodMgmtPg_det&cmd=doc_type&cmd2=setPg&pgNum='.((($_SESSION['crntPage']-1)<1) ? 1 : ($_SESSION['crntPage']-1)).'" ><img src="images/prev.gif" title="قبلي"></img></a></td>
		<td>&nbsp;&nbsp;</td>
	';
	$inx = 0;
	while(($inx<10) && (($stNum+$inx) <= $_SESSION['pageCount'])){
		$out .= '
			<td><a '.(($_SESSION['crntPage']==($stNum+$inx)) ? ' style="text-decoration:none; font-weight:bold;" ':'').' href="?pg=prodMgmtPg_det&cmd=doc_type&cmd2=setPg&pgNum='.($stNum+$inx).'" ><div style="background:#cccccc;">'.($stNum+$inx).'</div></a></td><td>&nbsp;</td>
		';
		
		$inx++;
	}
	$out .= '
		<td><a href="?pg=prodMgmtPg_det&cmd=doc_type&cmd2=setPg&pgNum='.((($_SESSION['crntPage']+1)<=$_SESSION['pageCount']) ? ($_SESSION['crntPage']+1) : $_SESSION['pageCount']).'" ><img src="images/next.gif" title="بعدي"></img></a></td>
		<td>&nbsp;&nbsp;</td>
		<td><a href="?pg=prodMgmtPg_det&cmd=doc_type&cmd2=setPg&pgNum='.$_SESSION['pageCount'].'" ><img src="images/last.gif" title="انتها"></img></a></td>
	';
	
	$out .= '
			</tr>
		</table>
	';	
	return $out;
}

function getRPPCombo_doc_type(){
	$out = '<span style="align:center;">
	
		<select onchange="window.open(\'?pg=prodMgmtPg_det&cmd=doc_type&cmd2=setRPP&rPP=\'+this.value, \'_self\')" style="width:50px;" >
			<option value="1" '.(($_SESSION['rPP']==1)?' selected="selected" ':'').' > 1 </option>
			<option value="5" '.(($_SESSION['rPP']==5)?' selected="selected" ':'').' > 5 </option>
			<option value="10" '.(($_SESSION['rPP']==10)?' selected="selected" ':'').' > 10 </option>
			<option value="25" '.(($_SESSION['rPP']==25)?' selected="selected" ':'').' > 25 </option>
			<option value="50" '.(($_SESSION['rPP']==30)?' selected="selected" ':'').' > 50 </option>
			<option value="100" '.(($_SESSION['rPP']==100)?' selected="selected" ':'').' > 100 </option>
			<option value="1000000" '.(($_SESSION['rPP']==0)?' selected="selected" ':'').' > all </option>
		</select>
		
	<span style="color:blue;"><b>پاسخ در صفحه</b></span>
	</div>';
	return $out;
}
function regdoc_typeFrm(){
	
	$_SESSION['doc_type_save']=1;
	
	?>
	
<form method="post" action="" id="commentForm">
			<input type="hidden" name="pg" value="prodMgmtPg_det">   
			<input type="hidden" name="cmd" value="regdoc_type">	
		<table  align="center" class="nasi" style="font-weight:bold;" >
		  	<tr style="background-color:<?php echo $_SESSION['htablecolor'] ?>;font-weight:bold;">
			       <td colspan="8"  style="height: 50px;vertical-align:middle;"  ><font size="5">انواع سند</font></td>
	       </tr>
	       <tr>
	            <td colspan="8"><hr style="color:<?php echo $_SESSION['htablecolor'] ?>;height:40%;"></hr></td>
	       </tr>
	      	<tr>
		      	 <td>&nbsp;</td>
		         <td colspan="2"><center>نام سند </center></td>
			     <td><input name="doc_t_name" id="doc_t_name" type="text" /></td>		       
	             <td colspan="2"><button  type="submit"  value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF">ذخیره</button></td>
			     <td colspan="2">&nbsp;</td>	  
	        </tr>
	          <tr>   
	                  
			   <td colspan="5">&nbsp;</td>
			  
	      	
	    </table>
	
	</form>

	<?php
	
}
function regdoc_type(){
	
	if($_SESSION['doc_type_save']==1){
		
	$doc_t_name = isset($_REQUEST['doc_t_name']) ? $_REQUEST['doc_t_name'] : '';
	
	$query = "
		INSERT INTO dm_doc_det_t 
			(    
			
			    `doc_t_name`, 
			    `doc_t_id_province`,
				`doc_t_date`
				
			)
			
		VALUES
			(  '".$doc_t_name."',	
			   '".$_SESSION['dm_user_profile']['u_province_id']."',		
				'".gmdate('Y-m-d')."'
			
			)
	";
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
	$_SESSION['unit_prode_save']=0;
	$doc_t_id = mysql_insert_id();
	return $doc_t_id;	
	
	}
	$_SESSION['doc_type_save']=0;
}
function doc_typeEditFrm(){
	
$doc_t_id  = isset($_REQUEST['doc_t_id']) ? (int)($_REQUEST['doc_t_id']) : 0;

	if($doc_t_id<1) die('Invalid id!');
	
	$lnk = mysql_query("SELECT * FROM dm_doc_det_t WHERE  doc_t_id=".$doc_t_id);
	
		$row = mysql_fetch_assoc($lnk);
	
		?>

	<form method="post" action="" >
	   	
		<input type="hidden" name="pg" value="prodMgmtPg_det">   
		<input type="hidden" name="cmd" value="doc_type_update">  
		<input type="hidden" name="unit_prod_id" id="doc_t_id" value="<?php echo $doc_t_id; ?>">   
		<table  align="center"  class="nasi"   >
		  	<tr style="background-color:<?php echo $_SESSION['htablecolor'] ?>;" >
		       <td colspan="8"  style="height: 50px;vertical-align:middle;"  ><b><font size="5">نوع سند</font></b></td>
	        </tr>
	        <tr>
	           <td colspan="8"><hr style="color:<?php echo $_SESSION['htablecolor'] ?>;height:40%;"></hr></td>
	       </tr>
	      	<tr>
		       	<td ><center>نام سند </center> </td>
		        <td><input name="doc_t_name" id="unit_prod_name" type="text" value="<?php echo $row['doc_t_name']; ?>" /></td>
                  <td colspan="2"><button  type="submit"  value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF">ذخیره</button></td>
			     <td colspan="2">&nbsp;</td>	  
	        </tr>
	          <tr>   
	                  
			   <td colspan="5">&nbsp;</td>
			       
	      	</tr>
	      		  
	    </table>
	</form>
	
	<?php	
}
function doc_type_update(){
	
$doc_t_id = isset($_REQUEST['doc_t_id']) ? (int)($_REQUEST['doc_t_id']) : 0;
	if($doc_t_id<1) die('Inv Id');
	
	$doc_t_name = isset($_REQUEST['doc_t_name']) ? $_REQUEST['doc_t_name'] : '';
	
	
	$query = "
		UPDATE dm_doc_det_t 
		SET 
			`doc_t_name` = '".$doc_t_name."',
			`doc_t_u_id` = '".$_SESSION['dm_user_profile']['u_id']."',
			`doc_t_date` = '".gmdate('Y-m-d')."' 
			
		WHERE 
			doc_t_id = ".$doc_t_id." 
	";
	//print $query;
	//die($query);
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
}
//bank
function doc_typeb(){

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
	
	$outHtml = '	<br>
		<form method="get" action="">
			<input type="hidden" name="pg" value="prodMgmtPg_det">   
			<input type="hidden" name="cmd" value="searchdoc_type"> 
			 کلمه مورد نظر را وارد كنيد 
			<div> جستجو : <input type="text" name="search" value="'.$_SESSION['srchStr'].'" style="width:100px;"/> 
			  <button value="draft" name="commit" type="submit">جستجو</button> </div>
		</form>
	';
	
	$outHtml .= '<br>	
		<div align = "center">
		 <div align = "center" style="width:50%;height:200px; overflow:auto">
			<table border="5" align="center" cellpadding="0" cellspacing="0" bgcolor=#99CCCC; class="list" >
      			<tr class="rw1">
        			<th colspan="20" align="center" scope="row" style="height: 50px;vertical-align:middle;"><center>انواع بانک </center></th>
        		</tr>
        		
      			<tr class="rw0" style="font-weight:bold;">
      			    <td align="center">رديف</td>
      			     <td align="center">کدبانک</td>
			        <td align="center">نام بانک</td>
			       
			         <td align="center" colspan="2">&nbsp </td>
			       
				</tr>
	';
	
	if(!isset($_SESSION['srchStr'])) $_SESSION['srchStr'] = '';
	if(!isset($_SESSION['elmCount'])) $_SESSION['elmCount'] = 0;
	if(!isset($_SESSION['rPP'])) $_SESSION['rPP'] = 10;//results per page
	if(!isset($_SESSION['pageCount'])) $_SESSION['pageCount'] = 1;//results page conut
	if(!isset($_SESSION['crntPage'])) $_SESSION['crntPage'] = 1;//current page number
	if($_SESSION['srchStr']==''){
		$srchQ = "";
		
	}else{
		$srchQ = " 
			AND(
					doc_b_name LIKE '%".$_SESSION['srchStr']."%' 
				
			)
		";
		
	}
	$typeQ = '';
	
	$genQuery = "
		
		FROM 
			dm_doc_det_b 
		WHERE 
			 doc_b_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
		 
		".$srchQ." 
		".$typeQ." 
	";
	
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
		$_SESSION['srchStr'] = '';
	$lnk = mysql_query($resQuery);
	$inx = ((($_SESSION['crntPage']-1)*$_SESSION['rPP'])+1);		
	if(mysql_affected_rows()>0){	
	$inx--;
		while($row = mysql_fetch_assoc($lnk)){
			
			$gdate=$row['doc_b_date'];
			list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
			list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
			$jdate = $jyear."/".$jmonth."/".$jday;
			
			if(($inx)%2==1)
				$class="rw0";
				else
				$class="rw1";
			$inx++;
			
			$outHtml .= '
				<tr class='.$class.'>
					<td align="center">'.$inx.'</td>
					<td align="center">'.$row['doc_b_code'].'</td>
					<td align="center">'.$row['doc_b_name'].'</td>
					
									
					<td align="center"><a href="?pg=prodMgmtPg_det&cmd=doc_typebEditFrm&doc_b_id='.$row['doc_b_id'].'"><img src="images/edit.png"  width="30%" height="30%"   border="0" title="ويرايش"></img></a></td>
					<td align="center"><a href="?pg=prodMgmtPg_det&cmd=doc_typebDelete&doc_b_id='.$row['doc_b_id'].'"><img src="images/delete.PNG"  width="30%" height="30%"   border="0" title="حذف"></img></a></td>
				</tr>
			';
		}
		$outHtml .= '<div> <button type="button" onclick=window.open("?pg=prodMgmtPg_det&cmd=regdoc_typebFrm&doc_b_name='.$row['doc_b_name'].'","_self")   value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF"> ایجاد بانک جدید</button></div>
		';
		
    }else{
    	$outHtml .= '<div> <button type="button" onclick=window.open("?pg=prodMgmtPg_det&cmd=regdoc_typebFrm&doc_b_name='.$row['doc_b_name'].'","_self")   value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF"> ایجاد بانک جدید</button></div>
    	<tr class="rw1"><td colspan="10">هیچ اطلاعاتی موجود نیست</td></tr>';
    }
     $outHtml .= '</table>
</div><br>'.getNavBar_doc_typeb().' '.getRPPCombo_doc_typeb();
   
    return $outHtml;
		
}

function getNavBar_doc_typeb(){
	$out = '
		<table style="direction:ltr" >
			<tr>
			
	';
	//if($stNum>$_SESSION['pageCount']) $stNum=$_SESSION['pageCount']-5;
	
	$stNum = $_SESSION['crntPage']-5;
	if($stNum<1) $stNum=1;
	$out .= '
		<td><a href="?pg=prodMgmtPg_det&cmd=doc_typeb&cmd2=setPg&pgNum=1" ><img src="images/first.gif" title="ابتدا"></img></a></td>
		<td>&nbsp;&nbsp;</td>
		<td><a href="?pg=prodMgmtPg_det&cmd=doc_typeb&cmd2=setPg&pgNum='.((($_SESSION['crntPage']-1)<1) ? 1 : ($_SESSION['crntPage']-1)).'" ><img src="images/prev.gif" title="قبلي"></img></a></td>
		<td>&nbsp;&nbsp;</td>
	';
	$inx = 0;
	while(($inx<10) && (($stNum+$inx) <= $_SESSION['pageCount'])){
		$out .= '
			<td><a '.(($_SESSION['crntPage']==($stNum+$inx)) ? ' style="text-decoration:none; font-weight:bold;" ':'').' href="?pg=prodMgmtPg_det&cmd=doc_typeb&cmd2=setPg&pgNum='.($stNum+$inx).'" ><div style="background:#cccccc;">'.($stNum+$inx).'</div></a></td><td>&nbsp;</td>
		';
		
		$inx++;
	}
	$out .= '
		<td><a href="?pg=prodMgmtPg_det&cmd=doc_typeb&cmd2=setPg&pgNum='.((($_SESSION['crntPage']+1)<=$_SESSION['pageCount']) ? ($_SESSION['crntPage']+1) : $_SESSION['pageCount']).'" ><img src="images/next.gif" title="بعدي"></img></a></td>
		<td>&nbsp;&nbsp;</td>
		<td><a href="?pg=prodMgmtPg_det&cmd=doc_typeb&cmd2=setPg&pgNum='.$_SESSION['pageCount'].'" ><img src="images/last.gif" title="انتها"></img></a></td>
	';
	
	$out .= '
			</tr>
		</table>
	';	
	return $out;
}

function getRPPCombo_doc_typeb(){
	$out = '<span style="align:center;">
	
		<select onchange="window.open(\'?pg=prodMgmtPg_det&cmd=doc_typeb&cmd2=setRPP&rPP=\'+this.value, \'_self\')" style="width:50px;" >
			<option value="1" '.(($_SESSION['rPP']==1)?' selected="selected" ':'').' > 1 </option>
			<option value="5" '.(($_SESSION['rPP']==5)?' selected="selected" ':'').' > 5 </option>
			<option value="10" '.(($_SESSION['rPP']==10)?' selected="selected" ':'').' > 10 </option>
			<option value="25" '.(($_SESSION['rPP']==25)?' selected="selected" ':'').' > 25 </option>
			<option value="50" '.(($_SESSION['rPP']==30)?' selected="selected" ':'').' > 50 </option>
			<option value="100" '.(($_SESSION['rPP']==100)?' selected="selected" ':'').' > 100 </option>
			<option value="1000000" '.(($_SESSION['rPP']==0)?' selected="selected" ':'').' > all </option>
		</select>
		
	<span style="color:blue;"><b>پاسخ در صفحه</b></span>
	</div>';
	return $out;
}
function regdoc_typebFrm(){
	
	$_SESSION['doc_typeb_save']=1;
	
	?>
	
<form method="post" action="" id="commentForm">
			<input type="hidden" name="pg" value="prodMgmtPg_det">   
			<input type="hidden" name="cmd" value="regdoc_typeb">	
		<table  align="center" class="nasi" style="font-weight:bold;" >
		  	<tr style="background-color:<?php echo $_SESSION['htablecolor'] ?>;font-weight:bold;">
			       <td colspan="8"  style="height: 50px;vertical-align:middle;"  ><font size="5">انواع بانک</font></td>
	       </tr>
	       <tr>
	            <td colspan="8"><hr style="color:<?php echo $_SESSION['htablecolor'] ?>;height:40%;"></hr></td>
	       </tr>
	      	<tr>
		      	 <td>&nbsp;</td>
		         <td colspan="2"><center>نام بانک </center></td>
			     <td><input name="doc_b_name" id="doc_b_name" type="text" /></td>		       
	             <td colspan="2"><button  type="submit"  value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF">ذخیره</button></td>
			     <td colspan="2">&nbsp;</td>	  
	        </tr>
	          <tr>   
	                 
			   <td colspan="5">&nbsp;</td>
			         
	      	</tr>
	      	
	    </table>
	
	</form>

	<?php
	
}
function regdoc_typeb(){
	
	if($_SESSION['doc_typeb_save']==1){
		
	$doc_b_name = isset($_REQUEST['doc_b_name']) ? $_REQUEST['doc_b_name'] : '';
	
	$query = "
		INSERT INTO dm_doc_det_b 
			(    
			
			    `doc_b_name`, 
			    `doc_b_id_province`, 
				`doc_b_date`
				
			)
			
		VALUES
			(  
			    '".$doc_b_name."',	
			    '".$_SESSION['dm_user_profile']['u_province_id']."',		
				'".gmdate('Y-m-d')."'
			
			)
	";
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
	$_SESSION['doc_typeb_save']=0;
	$doc_b_id = mysql_insert_id();
	return $doc_b_id;	
	
	}
	$_SESSION['doc_typeb_save']=0;
}
function doc_typebEditFrm(){
	
$doc_b_id  = isset($_REQUEST['doc_b_id']) ? (int)($_REQUEST['doc_b_id']) : 0;

	if($doc_b_id<1) die('Invalid id!');
	
	$lnk = mysql_query("SELECT * FROM dm_doc_det_b WHERE  doc_b_id=".$doc_b_id." ");
	
		$row = mysql_fetch_assoc($lnk);
	
		?>

	<form method="post" action="" >
	   	
		<input type="hidden" name="pg" value="prodMgmtPg_det">   
		<input type="hidden" name="cmd" value="doc_typeb_update">  
		<input type="hidden" name="unit_prod_id" id="doc_b_id" value="<?php echo $doc_b_id; ?>">   
		<table  align="center"  class="nasi"   >
		  	<tr style="background-color:<?php echo $_SESSION['htablecolor'] ?>;" >
		       <td colspan="8"  style="height: 50px;vertical-align:middle;"  ><b><font size="5">بانک</font></b></td>
	        </tr>
	        <tr>
	           <td colspan="8"><hr style="color:<?php echo $_SESSION['htablecolor'] ?>;height:40%;"></hr></td>
	       </tr>
	      	<tr>
	      		<td ><center>کد بانک </center> </td>
		        <td><input name="doc_b_code" id="doc_b_code" type="text" value="<?php echo $row['doc_b_code']; ?>" /></td>
		       	<td ><center>نام بانک </center> </td>
		        <td><input name="doc_b_name" id="doc_b_name" type="text" value="<?php echo $row['doc_b_name']; ?>" /></td>
		           
                  <td colspan="2"><button  type="submit"  value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF">ذخیره</button></td>
			     <td colspan="2">&nbsp;</td>	  
	        </tr>
	          <tr>   
	                 
			   <td colspan="5">&nbsp;</td>
			       
	      	</tr>
	      		  
	    </table>
	</form>
	
	<?php	
}
function doc_typeb_update(){
	
$doc_b_id = isset($_REQUEST['doc_b_id']) ? (int)($_REQUEST['doc_b_id']) : 0;
	if($doc_b_id<1) die('Inv Id');
	
	$doc_b_name = isset($_REQUEST['doc_b_name']) ? $_REQUEST['doc_b_name'] : '';
	$doc_b_code = isset($_REQUEST['doc_b_code']) ? $_REQUEST['doc_b_code'] : '';
//	echo $doc_b_code;
	
	$query = "
		UPDATE dm_doc_det_b 
		SET 
			`doc_b_name` = '".$doc_b_name."',
			`doc_b_code` = '".$doc_b_code."',
			`doc_b_date` = ".gmdate('Y-m-d')." 
			
		WHERE 
			doc_b_id = ".$doc_b_id." 
	";
//print $query;
	//die($query);
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
}
//ative cus
	function cus_act(){
		?>
	<script>

	  function Access(){
		  alert('شما حق دسترسي نداريد');

	  }
	
	</script>
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
	
	$outHtml = '	<br>
		<form method="get" action="">
			<input type="hidden" name="pg" value="prodMgmtPg_det">   
			<input type="hidden" name="cmd" value="searchActCus"> 
			 کلمه مورد نظر را وارد كنيد 
			<div> جستجو : <input type="text" name="search" value="'.$_SESSION['srchStr'].'" style="width:100px;"/> 
			  <button value="draft" name="commit" type="submit" >جستجو</button> </div>
		</form>
	';
	
	$outHtml .= '<br>	
		<div align = "center">
		 <div align = "center" style="width:50%;height:200px; overflow:auto">
			<table border="5" align="center" cellpadding="0" cellspacing="0" bgcolor=#99CCCC; class="list" >
      			<tr class="rw1">
        			<th colspan="20" align="center" scope="row" style="height: 50px;vertical-align:middle;"><center>انواع فعاليت ها </center></th>
        		</tr>
        		
      			<tr class="rw0" style="font-weight:bold;">
      			    <td align="center">رديف</td>
			        <td align="center">نوع فعاليت</td>
			        <td align="center">تاریخ تعریف </td>
			         <td align="center" colspan="2">&nbsp </td>
			       
				</tr>
	';
	
	if(!isset($_SESSION['srchStr'])) $_SESSION['srchStr'] = '';
	if(!isset($_SESSION['elmCount'])) $_SESSION['elmCount'] = 0;
	if(!isset($_SESSION['rPP'])) $_SESSION['rPP'] = 10;//results per page
	if(!isset($_SESSION['pageCount'])) $_SESSION['pageCount'] = 1;//results page conut
	if(!isset($_SESSION['crntPage'])) $_SESSION['crntPage'] = 1;//current page number
	if($_SESSION['srchStr']==''){
		$srchQ = "";
		
	}else{
		$srchQ = " 
			AND(
					cus_act_name LIKE '%".$_SESSION['srchStr']."%' 
				
			)
		";
		
	}
	$typeQ = '';
	
	$genQuery = "
		
		FROM 
			dm_customer_act_t  
		WHERE 
			1 
		".$srchQ." 
		".$typeQ." 
	";
	
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
	$_SESSION['srchStr'] = '';	
	$lnk = mysql_query($resQuery);
	$inx = ((($_SESSION['crntPage']-1)*$_SESSION['rPP'])+1);		
	if(mysql_affected_rows()>0){	
	$inx--;
		while($row = mysql_fetch_assoc($lnk)){
			
			$gdate=$row['cus_act_date'];
			list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
			list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
			$jdate = $jyear."/".$jmonth."/".$jday;
			
			if(($inx)%2==1)
				$class="rw0";
				else
				$class="rw1";
			$inx++;
			
			$outHtml .= '
				<tr class='.$class.'>
					<td align="center">'.$inx.'</td>
					<td align="center">'.$row['cus_act_name'].'</td>
					<td align="center">'.$jdate.'</td>';
			  $query2='select *
							from dm_um_rel t
							     inner join dm_listmenu l on l.menu_id = t.um_menu_id
							where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
							      l.menu_code = \'165\' and t.um_can_edit=1';
			                    $lnk2 = mysql_query($query2);
			                    $row2 = mysql_fetch_assoc($lnk2);
//			                    print $query;
			                    if(mysql_affected_rows()>0){					
					$outHtml .= '<td align="center"><a href="?pg=prodMgmtPg_det&cmd=cus_activeEditFrm&cus_act_id='.$row['cus_act_id'].'"><img src="images/edit.png"  width="15%" height="15%"   border="0" title="ويرايش"></img></a></td>';}
		else{
						$outHtml .= '<td align="center"><a href="" onclick="Access();"><img src="images/edit.png"  width="15%" height="15%"   border="0" title="ويرايش"></img></a></td>';
						
					}
					 $query2='select *
							from dm_um_rel t
							     inner join dm_listmenu l on l.menu_id = t.um_menu_id
							where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
							      l.menu_code = \'165\' and t.um_can_delete=1';
			                    $lnk2 = mysql_query($query2);
			                    $row2 = mysql_fetch_assoc($lnk2);
//			                    print $query;
			                    if(mysql_affected_rows()>0){	
					$outHtml .= '<td align="center"><a href="?pg=prodMgmtPg_det&cmd=cus_activeDelete&cus_act_id='.$row['cus_act_id'].'"><img src="images/delete.PNG"  width="15%" height="15%"   border="0" title="حذف"></img></a></td>';}
		else{
						$outHtml .= '<td align="center"><a href="" onclick="Access();"><img src="images/delete.PNG"  width="15%" height="15%"   border="0" title="حذف"></img></a></td>';
						
					}
				$outHtml .= '</tr>
			';
		}
		$outHtml .= '<div> <button type="button" onclick=window.open("?pg=prodMgmtPg_det&cmd=regcus_actFrm","_self") value=" چاپ فاكتور"  value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF"> ایجاد فعاليت</button></div>
		';
		
    }else{
    	$outHtml .= '<div> <button type="button" onclick=window.open("?pg=prodMgmtPg_det&cmd=regcus_actFrm","_self") value=" چاپ فاكتور"  value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF"> ایجادفعاليت جدید</button></div>
    	<tr class="rw1"><td colspan="10">هیچ اطلاعاتی موجود نیست</td></tr>';
    }
     $outHtml .= '</table>
</div><br>'.getNavBar_cus_act().' '.getRPPCombo_cus_act();
   
    return $outHtml;
		
}

function getNavBar_cus_act(){
	$out = '
		<table style="direction:ltr" >
			<tr>
			
	';
	//if($stNum>$_SESSION['pageCount']) $stNum=$_SESSION['pageCount']-5;
	
	$stNum = $_SESSION['crntPage']-5;
	if($stNum<1) $stNum=1;
	$out .= '
		<td><a href="?pg=prodMgmtPg_det&cmd=cus_act&cmd2=setPg&pgNum=1" ><img src="images/first.gif" title="ابتدا"></img></a></td>
		<td>&nbsp;&nbsp;</td>
		<td><a href="?pg=prodMgmtPg_det&cmd=cus_act&cmd2=setPg&pgNum='.((($_SESSION['crntPage']-1)<1) ? 1 : ($_SESSION['crntPage']-1)).'" ><img src="images/prev.gif" title="قبلي"></img></a></td>
		<td>&nbsp;&nbsp;</td>
	';
	$inx = 0;
	while(($inx<10) && (($stNum+$inx) <= $_SESSION['pageCount'])){
		$out .= '
			<td><a '.(($_SESSION['crntPage']==($stNum+$inx)) ? ' style="text-decoration:none; font-weight:bold;" ':'').' href="?pg=prodMgmtPg_det&cmd=cus_act&cmd2=setPg&pgNum='.($stNum+$inx).'" ><div style="background:#cccccc;">'.($stNum+$inx).'</div></a></td><td>&nbsp;</td>
		';
		
		$inx++;
	}
	$out .= '
		<td><a href="?pg=prodMgmtPg_det&cmd=cus_act&cmd2=setPg&pgNum='.((($_SESSION['crntPage']+1)<=$_SESSION['pageCount']) ? ($_SESSION['crntPage']+1) : $_SESSION['pageCount']).'" ><img src="images/next.gif" title="بعدي"></img></a></td>
		<td>&nbsp;&nbsp;</td>
		<td><a href="?pg=prodMgmtPg_det&cmd=cus_act&cmd2=setPg&pgNum='.$_SESSION['pageCount'].'" ><img src="images/last.gif" title="انتها"></img></a></td>
	';
	
	$out .= '
			</tr>
		</table>
	';	
	return $out;
}

function getRPPCombo_cus_act(){
	$out = '<span style="align:center;">
	
		<select onchange="window.open(\'?pg=prodMgmtPg_det&cmd=cus_act&cmd2=setRPP&rPP=\'+this.value, \'_self\')" style="width:50px;" >
			<option value="1" '.(($_SESSION['rPP']==1)?' selected="selected" ':'').' > 1 </option>
			<option value="5" '.(($_SESSION['rPP']==5)?' selected="selected" ':'').' > 5 </option>
			<option value="10" '.(($_SESSION['rPP']==10)?' selected="selected" ':'').' > 10 </option>
			<option value="25" '.(($_SESSION['rPP']==25)?' selected="selected" ':'').' > 25 </option>
			<option value="50" '.(($_SESSION['rPP']==30)?' selected="selected" ':'').' > 50 </option>
			<option value="100" '.(($_SESSION['rPP']==100)?' selected="selected" ':'').' > 100 </option>
			<option value="1000000" '.(($_SESSION['rPP']==0)?' selected="selected" ':'').' > all </option>
		</select>
		
	<span style="color:blue;"><b>پاسخ در صفحه</b></span>
	</div>';
	return $out;
}
function regcus_actFrm(){
	
	$_SESSION['cus_act_save']=1;
	
	?>
	
<form method="post" action="" id="commentForm">
			<input type="hidden" name="pg" value="prodMgmtPg_det">   
			<input type="hidden" name="cmd" value="regcus_act">	
		<table  align="center" class="nasi" style="font-weight:bold;" >
		  	<tr style="background-color:<?php echo $_SESSION['htablecolor'] ?>;font-weight:bold;">
			       <td colspan="8"  style="height: 50px;vertical-align:middle;"  ><font size="5">نوع فعاليت</font></td>
	       </tr>
	       <tr>
	            <td colspan="8"><hr style="color:<?php echo $_SESSION['htablecolor'] ?>;height:40%;"></hr></td>
	       </tr>
	      	<tr>
		      	 <td>&nbsp;</td>
		         <td colspan="2"><center>نام فعاليت </center></td>
			     <td><input name="cus_act_name" id="cus_act_name" type="text" /></td>		       
	             <td colspan="2"><button  type="submit"  value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF">ذخیره</button></td>
			     <td colspan="2">&nbsp;</td>	  
	        </tr>
	          <tr>   
	                 
			   <td colspan="5">&nbsp;</td>
			      
	      	</tr>
	      	
	    </table>
	
	</form>

	<?php
	
}

function regcus_act(){
	
	if($_SESSION['cus_act_save']==1){
		
	$cus_act_name = isset($_REQUEST['cus_act_name']) ? $_REQUEST['cus_act_name'] : '';
	
	$query = "
		INSERT INTO dm_customer_act_t  
			(    
			
			    `cus_act_name`, 
				`cus_act_date`
				
			)
			
		VALUES
			(  '".$cus_act_name."',			
				'".gmdate('Y-m-d')."'
			
			)
	";
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
	$_SESSION['doc_typeb_save']=0;
	$cus_act_id = mysql_insert_id();
		
	
	}
	$_SESSION['cus_act_save']=0;
}
function cus_act_update(){
	
$cus_act_id= isset($_REQUEST['cus_act_id']) ? (int)($_REQUEST['cus_act_id']) : 0;
	if($cus_act_id<1) die('Inv Id');
	
	$cus_act_name = isset($_REQUEST['cus_act_name']) ? $_REQUEST['cus_act_name'] : '';
	
	
	$query = "
		UPDATE dm_customer_act_t  
		SET 
			`cus_act_name` = '".$cus_act_name."',
			`cus_act_date` = ".gmdate('Y-m-d')." 
			
		WHERE 
			cus_act_id = ".$cus_act_id." 
	";
	//print $query;
	//die($query);
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
}
function cus_activeEditFrm(){
	
$cus_act_id  = isset($_REQUEST['cus_act_id']) ? (int)($_REQUEST['cus_act_id']) : 0;

	if($cus_act_id<1) die('Invalid id!');
	
	$lnk = mysql_query("SELECT * FROM dm_customer_act_t WHERE  cus_act_id=".$cus_act_id);
	
		$row = mysql_fetch_assoc($lnk);
	
		?>

	<form method="post" action="" >
	   	
		<input type="hidden" name="pg" value="prodMgmtPg_det">   
		<input type="hidden" name="cmd" value="cus_act_update">  
		<input type="hidden" name="cus_act_id" id="cus_act_id" value="<?php echo $cus_act_id; ?>">   
		<table  align="center"  class="nasi"   >
		  	<tr style="background-color:<?php echo $_SESSION['htablecolor'] ?>;" >
		       <td colspan="8"  style="height: 50px;vertical-align:middle;"  ><b><font size="5">نوع فعاليت</font></b></td>
	        </tr>
	        <tr>
	           <td colspan="8"><hr style="color:<?php echo $_SESSION['htablecolor'] ?>;height:40%;"></hr></td>
	       </tr>
	      	<tr>
		       	<td ><center>نام فعاليت </center> </td>
		        <td><input name="cus_act_name" id="cus_act_name" type="text" value="<?php echo $row['cus_act_name']; ?>" /></td>
                  <td colspan="2"><button  type="submit"  value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF">ذخیره</button></td>
			     <td colspan="2">&nbsp;</td>	  
	        </tr>
	          <tr>   
	              
			   <td colspan="5">&nbsp;</td>
			     
	      	</tr>
	      		  
	    </table>
	</form>
	
	<?php	
}
//cus pay
function cus_pay(){
				?>
	<script>

	  function Access(){
		  alert('شما حق دسترسي نداريد');

	  }
	
	</script>
	
	
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
	
	$outHtml = '	<br>
		<form method="get" action="">
			<input type="hidden" name="pg" value="prodMgmtPg_det">   
			<input type="hidden" name="cmd" value="searchpayCus"> 
			 کلمه مورد نظر را وارد كنيد 
			<div> جستجو : <input type="text" name="search" value="'.$_SESSION['srchStr'].'" style="width:100px;"/> 
			  <button value="draft" name="commit" type="submit">جستجو</button> </div>
		</form>
	';
	
	$outHtml .= '<br>	
		<div align = "center">
		 <div align = "center" style="width:50%;height:200px; overflow:auto">
			<table border="5" align="center" cellpadding="0" cellspacing="0" bgcolor=#99CCCC; class="list" >
      			<tr class="rw1">
        			<th colspan="20" align="center" scope="row" style="height: 50px;vertical-align:middle;"><center>انواع پرداخت ها </center></th>
        		</tr>
        		
      			<tr class="rw0" style="font-weight:bold;">
      			    <td align="center">رديف</td>
			        <td align="center">نوع پرداخت</td>
			        <td align="center">تاريخ تعريف </td>
			         <td align="center" colspan="2">&nbsp </td>
			       
				</tr>
	';
	
	if(!isset($_SESSION['srchStr'])) $_SESSION['srchStr'] = '';
	if(!isset($_SESSION['elmCount'])) $_SESSION['elmCount'] = 0;
	if(!isset($_SESSION['rPP'])) $_SESSION['rPP'] = 10;//results per page
	if(!isset($_SESSION['pageCount'])) $_SESSION['pageCount'] = 1;//results page conut
	if(!isset($_SESSION['crntPage'])) $_SESSION['crntPage'] = 1;//current page number
	if($_SESSION['srchStr']==''){
		$srchQ = "";
		
	}else{
		$srchQ = " 
			AND(
					cus_pay_name LIKE '%".$_SESSION['srchStr']."%' 
				
			)
		";
		
	}
	$typeQ = '';
	
	$genQuery = "
		
		FROM 
			dm_customer_pay_t  
		WHERE 
			1 
		".$srchQ." 
		".$typeQ." 
	";
	
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
		$_SESSION['srchStr'] = '';
	$lnk = mysql_query($resQuery);
	$inx = ((($_SESSION['crntPage']-1)*$_SESSION['rPP'])+1);		
	if(mysql_affected_rows()>0){	
	$inx--;
		while($row = mysql_fetch_assoc($lnk)){
			
			$gdate=$row['cus_pay_date'];
			list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
			list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
			$jdate = $jyear."/".$jmonth."/".$jday;
			
			if(($inx)%2==1)
				$class="rw0";
				else
				$class="rw1";
			$inx++;
			
			$outHtml .= '
				<tr class='.$class.'>
					<td align="center">'.$inx.'</td>
					<td align="center">'.$row['cus_pay_name'].'</td>
					<td align="center">'.$jdate.'</td>';
			 $query2='select *
							from dm_um_rel t
							     inner join dm_listmenu l on l.menu_id = t.um_menu_id
							where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
							      l.menu_code = \'166\' and t.um_can_edit=1';
			                    $lnk2 = mysql_query($query2);
			                    $row2 = mysql_fetch_assoc($lnk2);
//			                    print $query;
			                    if(mysql_affected_rows()>0){					
					$outHtml .= '<td align="center"><a href="?pg=prodMgmtPg_det&cmd=cus_payEditFrm&cus_pay_id='.$row['cus_pay_id'].'"><img src="images/edit.png"  width="20%" height="20%"   border="0" title="ويرايش"></img></a></td>';}
		else{
						$outHtml .= '<td align="center"><a href="" onclick="Access();"><img src="images/edit.png"  width="20%" height="20%"   border="0" title="ويرايش"></img></a></td>';
						
					}
					$query2='select *
							from dm_um_rel t
							     inner join dm_listmenu l on l.menu_id = t.um_menu_id
							where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
							      l.menu_code = \'166\' and t.um_can_delete=1';
			                    $lnk2 = mysql_query($query2);
			                    $row2 = mysql_fetch_assoc($lnk2);
//			                    print $query;
			                    if(mysql_affected_rows()>0){	
					$outHtml .= '<td align="center"><a href="?pg=prodMgmtPg_det&cmd=cus_payDelete&cus_pay_id='.$row['cus_pay_id'].'"><img src="images/delete.PNG"  width="15%" height="15%"   border="0" title="حذف"></img></a></td>';}
		else{
						$outHtml .= '<td align="center"><a href="" onclick="Access();"><img src="images/delete.PNG"  width="15%" height="15%"   border="0" title="حذف"></img></a></td>';
						
					}
				$outHtml .= '</tr>
			';
		}
		$outHtml .= '<div> <button type="button" onclick=window.open("?pg=prodMgmtPg_det&cmd=regcus_payFrm","_self") value=" چاپ فاكتور"  value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF"> ايجاد پرداخت جديد</button></div>
		';
		
    }else{
    	$outHtml .= '<div> <button type="button" onclick=window.open("?pg=prodMgmtPg_det&cmd=regcus_payFrm","_self") value=" چاپ فاكتور"  value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF"> ايجاد پرداخت جديد</button></div>
    	<tr class="rw1"><td colspan="10">هيچ اطلاعاتي موجود نيست</td></tr>';
    }
     $outHtml .= '</table>
</div><br>'.getNavBar_cus_pay().' '.getRPPCombo_cus_pay();
   
    return $outHtml;
		
}

function getNavBar_cus_pay(){
	$out = '
		<table style="direction:ltr" >
			<tr>
			
	';
	//if($stNum>$_SESSION['pageCount']) $stNum=$_SESSION['pageCount']-5;
	
	$stNum = $_SESSION['crntPage']-5;
	if($stNum<1) $stNum=1;
	$out .= '
		<td><a href="?pg=prodMgmtPg_det&cmd=cus_pay&cmd2=setPg&pgNum=1" ><img src="images/first.gif" title="ابتدا"></img></a></td>
		<td>&nbsp;&nbsp;</td>
		<td><a href="?pg=prodMgmtPg_det&cmd=cus_pay&cmd2=setPg&pgNum='.((($_SESSION['crntPage']-1)<1) ? 1 : ($_SESSION['crntPage']-1)).'" ><img src="images/prev.gif" title="قبلي"></img></a></td>
		<td>&nbsp;&nbsp;</td>
	';
	$inx = 0;
	while(($inx<10) && (($stNum+$inx) <= $_SESSION['pageCount'])){
		$out .= '
			<td><a '.(($_SESSION['crntPage']==($stNum+$inx)) ? ' style="text-decoration:none; font-weight:bold;" ':'').' href="?pg=prodMgmtPg_det&cmd=cus_act&cmd2=setPg&pgNum='.($stNum+$inx).'" ><div style="background:#cccccc;">'.($stNum+$inx).'</div></a></td><td>&nbsp;</td>
		';
		
		$inx++;
	}
	$out .= '
		<td><a href="?pg=prodMgmtPg_det&cmd=cus_paycmd2=setPg&pgNum='.((($_SESSION['crntPage']+1)<=$_SESSION['pageCount']) ? ($_SESSION['crntPage']+1) : $_SESSION['pageCount']).'" ><img src="images/next.gif" title="بعدي"></img></a></td>
		<td>&nbsp;&nbsp;</td>
		<td><a href="?pg=prodMgmtPg_det&cmd=cus_pay&cmd2=setPg&pgNum='.$_SESSION['pageCount'].'" ><img src="images/last.gif" title="انتها"></img></a></td>
	';
	
	$out .= '
			</tr>
		</table>
	';	
	return $out;
}

function getRPPCombo_cus_pay(){
	$out = '<span style="align:center;">
	
		<select onchange="window.open(\'?pg=prodMgmtPg_det&cmd=cus_pay&cmd2=setRPP&rPP=\'+this.value, \'_self\')" style="width:50px;" >
			<option value="1" '.(($_SESSION['rPP']==1)?' selected="selected" ':'').' > 1 </option>
			<option value="5" '.(($_SESSION['rPP']==5)?' selected="selected" ':'').' > 5 </option>
			<option value="10" '.(($_SESSION['rPP']==10)?' selected="selected" ':'').' > 10 </option>
			<option value="25" '.(($_SESSION['rPP']==25)?' selected="selected" ':'').' > 25 </option>
			<option value="50" '.(($_SESSION['rPP']==30)?' selected="selected" ':'').' > 50 </option>
			<option value="100" '.(($_SESSION['rPP']==100)?' selected="selected" ':'').' > 100 </option>
			<option value="1000000" '.(($_SESSION['rPP']==0)?' selected="selected" ':'').' > all </option>
		</select>
		
	<span style="color:blue;"><b>پاسخ در صفحه</b></span>
	</div>';
	return $out;
}
function regcus_payFrm(){
	
	$_SESSION['cus_pay_save']=1;
	
	?>
	
<form method="post" action="" id="commentForm">
			<input type="hidden" name="pg" value="prodMgmtPg_det">   
			<input type="hidden" name="cmd" value="regcus_pay">	
		<table  align="center" class="nasi" style="font-weight:bold;" >
		  	<tr style="background-color:<?php echo $_SESSION['htablecolor'] ?>;font-weight:bold;">
			       <td colspan="8"  style="height: 50px;vertical-align:middle;"  ><font size="5">نوع پرداخت</font></td>
	       </tr>
	       <tr>
	            <td colspan="8"><hr style="color:<?php echo $_SESSION['htablecolor'] ?>;height:40%;"></hr></td>
	       </tr>
	      	<tr>
		      	 <td>&nbsp;</td>
		         <td colspan="2"><center>نام نوع پرداخت</center></td>
			     <td><input name="cus_pay_name" id="cus_pay_name" type="text" /></td>		       
	             <td colspan="2"><button  type="submit"  value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF">ذخیره</button></td>
			     <td colspan="2">&nbsp;</td>	  
	        </tr>
	          <tr>   
	                
			   <td colspan="5">&nbsp;</td>
			      
	      	</tr>
	      	
	    </table>
	
	</form>

	<?php
	
}
function regcus_pay(){
	
	if($_SESSION['cus_pay_save']==1){
		
	$cus_pay_name = isset($_REQUEST['cus_pay_name']) ? $_REQUEST['cus_pay_name'] : '';
	
	$query = "
		INSERT INTO dm_customer_pay_t
			(    
			
			    `cus_pay_name`, 
			    `cus_pay_u_id`, 
				`cus_pay_date`
				
			)
			
		VALUES
			(  '".$cus_pay_name."',		
			   '".$_SESSION['dm_user_profile']['u_id']."',			
				'".gmdate('Y-m-d')."'
			
			)
	";
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
	$_SESSION['cus_pay_save']=0;
	$cus_act_id = mysql_insert_id();
	return $cus_pay_id;	
	
	}
	$_SESSION['cus_pay_save']=0;
}
function cus_payEditFrm(){
	
$cus_pay_id  = isset($_REQUEST['cus_pay_id']) ? (int)($_REQUEST['cus_pay_id']) : 0;

	if($cus_pay_id<1) die('Invalid id!');
	$lnk = mysql_query("SELECT * FROM dm_customer_pay_t  WHERE  cus_pay_id=".$cus_pay_id);	
		$row = mysql_fetch_assoc($lnk);	
		?>

	<form method="post" action="" >
	   	
		<input type="hidden" name="pg" value="prodMgmtPg_det">   
		<input type="hidden" name="cmd" value="cus_pay_update">  
		<input type="hidden" name="cus_pay_id" id="cus_pay_id"  value="<?php echo $cus_pay_id; ?>">   
		<table  align="center"  class="nasi"   >
		  <tr style="background-color:<?php echo $_SESSION['htablecolor'] ?>;" >
		  	 
		       <td colspan="8"  style="height: 50px;vertical-align:middle;"  ><b><font size="5">نوع پرداخت</font></b></td>
		       
	      </tr>
	      <tr>
	           <td colspan="8"><hr style="color:<?php echo $_SESSION['htablecolor'] ?>;height:40%;"></hr></td>
	      </tr>
	      <tr>
		       	<td ><center>نام نوع پرداخت</center> </td>
		        <td><input name="cus_pay_name" id="cus_pay_name" type="text" value="<?php echo $row['cus_pay_name']; ?>" /></td>
                  <td colspan="2"><button  type="submit"  value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF">ذخیره</button></td>
			     <td colspan="2">&nbsp;</td>	  
	      </tr>
	      <tr>               
			   <td colspan="5">&nbsp;</td>			  
	     </tr>
	      		  
	    </table>
	</form>
	
	<?php	
}
function cus_pay_update(){
	
$cus_pay_id= isset($_REQUEST['cus_pay_id']) ? (int)($_REQUEST['cus_pay_id']) : 0;

	if($cus_pay_id<1) die('Inv Id1');
	
	$cus_pay_name = isset($_REQUEST['cus_pay_name']) ? $_REQUEST['cus_pay_name'] : '';
	
	
	$query = "
		UPDATE dm_customer_pay_t   
		SET 
			`cus_pay_name` = '".$cus_pay_name."',
			`cus_pay_u_id` = '".$_SESSION['dm_user_profile']['u_id']."',
			`cus_pay_date` = '".gmdate('Y-m-d')."' 
			
		WHERE 
			cus_pay_id = ".$cus_pay_id." 
	";
	//print $query;
	//die($query);
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
}
//cus person
function cus_person(){
				
					?>
	<script>

	  function Access(){
		  alert('شما حق دسترسي نداريد');

	  }
	
	</script>
		
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
	
	$outHtml = '<br>
		<form method="get" action="">
			<input type="hidden" name="pg" value="prodMgmtPg_det">   
			<input type="hidden" name="cmd" value="searchpersonCus"> 
			 کلمه مورد نظر را وارد كنيد 
			<div> جستجو : <input type="text" name="search" value="'.$_SESSION['srchStr'].'" style="width:100px;"/> 
			  <button value="draft" name="commit" type="submit">جستجو</button> </div>
		</form>
	';
	
	$outHtml .= '<br>	
		<div align = "center">
		 <div align = "center" style="width:50%;height:200px; overflow:auto">
			<table border="5" align="center" cellpadding="0" cellspacing="0" bgcolor=#99CCCC; class="list" >
      			<tr class="rw1">
        			<th colspan="20" align="center" scope="row" style="height: 50px;vertical-align:middle;"><center>نوع شخصیت </center></th>
        		</tr>
        		
      			<tr class="rw0" style="font-weight:bold;">
      			    <td align="center">رديف</td>
			        <td align="center">نوع شخصیت</td>
			        <td align="center">تاريخ تعريف </td>
			         <td align="center" colspan="2">&nbsp </td>
			       
				</tr>
	';
	
	if(!isset($_SESSION['srchStr'])) $_SESSION['srchStr'] = '';
	if(!isset($_SESSION['elmCount'])) $_SESSION['elmCount'] = 0;
	if(!isset($_SESSION['rPP'])) $_SESSION['rPP'] = 10;//results per page
	if(!isset($_SESSION['pageCount'])) $_SESSION['pageCount'] = 1;//results page conut
	if(!isset($_SESSION['crntPage'])) $_SESSION['crntPage'] = 1;//current page number
	if($_SESSION['srchStr']==''){
		$srchQ = "";
		
	}else{
		$srchQ = " 
			AND(
					cus_person_name LIKE '%".$_SESSION['srchStr']."%' 
				
			)
		";
		
	}
	$typeQ = '';
	
	$genQuery = "
		
		FROM 
			dm_customer_person   
		WHERE 
			1 
		".$srchQ." 
		".$typeQ." 
	";
	
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
		$_SESSION['srchStr'] = '';
	$lnk = mysql_query($resQuery);
	$inx = ((($_SESSION['crntPage']-1)*$_SESSION['rPP'])+1);		
	if(mysql_affected_rows()>0){	
	$inx--;
		while($row = mysql_fetch_assoc($lnk)){
			
			$gdate=$row['cus_pay_date'];
			list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
			list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
			$jdate = $jyear."/".$jmonth."/".$jday;
			
			if(($inx)%2==1)
				$class="rw0";
				else
				$class="rw1";
			$inx++;
			
			$outHtml .= '
				<tr class='.$class.'>
					<td align="center">'.$inx.'</td>
					<td align="center">'.$row['cus_person_name'].'</td>
					<td align="center">'.$jdate.'</td>';	
			$query2='select *
								from dm_um_rel t
								     inner join dm_listmenu l on l.menu_id = t.um_menu_id
								where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
								      l.menu_code = \'167\' and t.um_can_edit=1';
			                    $lnk2 = mysql_query($query2);
			                    $row2 = mysql_fetch_assoc($lnk2);
//			                    print $query;
			                    if(mysql_affected_rows()>0){				
					$outHtml .= '<td align="center"><a href="?pg=prodMgmtPg_det&cmd=cus_personEditFrm&cus_person_id='.$row['cus_person_id'].'"><img src="images/edit.png"  width="15%" height="15%"   border="0" title="ويرايش"></img></a></td>';}
		else{
						$outHtml .= '<td align="center"><a href="" onclick="Access();"><img src="images/edit.png"  width="15%" height="115%"   border="0" title="ويرايش"></img></a></td>';
						
					}
					$query2='select *
						from dm_um_rel t
						     inner join dm_listmenu l on l.menu_id = t.um_menu_id
						where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
						      l.menu_code = \'167\' and t.um_can_delete=1';
	                    $lnk2 = mysql_query($query2);
			                    $row2 = mysql_fetch_assoc($lnk2);
//			                    print $query;
			                    if(mysql_affected_rows()>0){
					$outHtml .= '<td align="center"><a href="?pg=prodMgmtPg_det&cmd=cus_personDelete&cus_person_id='.$row['cus_person_id'].'"><img src="images/delete.PNG"  width="15%" height="15%"   border="0" title="حذف"></img></a></td>';}
		else{
						$outHtml .= '<td align="center"><a href="" onclick="Access();"><img src="images/delete.PNG"  width="15%" height="15%"   border="0" title="حذف"></img></a></td>';
						
					}
				$outHtml .= '</tr>
			';
		}
		$outHtml .= '<div> <button type="button" onclick=window.open("?pg=prodMgmtPg_det&cmd=regcus_personFrm","_self") value=" چاپ فاكتور"  value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF"> ايجاد شخصيت جديد</button></div>
		';
		
    }else{
    	$outHtml .= '<div> <button type="button" onclick=window.open("?pg=prodMgmtPg_det&cmd=regcus_personFrm","_self") value=" چاپ فاكتور"  value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF"> ايجاد شخصيت جديد</button></div>
    	<tr class="rw1"><td colspan="10">هيچ اطلاعاتي موجود نيست</td></tr>';
    }
     $outHtml .= '</table>
</div><br>'.getNavBar_cus_person().' '.getRPPCombo_cus_person();
   
    return $outHtml;
		
}

function getNavBar_cus_person(){
	$out = '
		<table style="direction:ltr" >
			<tr>
			
	';
	//if($stNum>$_SESSION['pageCount']) $stNum=$_SESSION['pageCount']-5;
	
	$stNum = $_SESSION['crntPage']-5;
	if($stNum<1) $stNum=1;
	$out .= '
		<td><a href="?pg=prodMgmtPg_det&cmd=cus_person&cmd2=setPg&pgNum=1" ><img src="images/first.gif" title="ابتدا"></img></a></td>
		<td>&nbsp;&nbsp;</td>
		<td><a href="?pg=prodMgmtPg_det&cmd=cus_person&cmd2=setPg&pgNum='.((($_SESSION['crntPage']-1)<1) ? 1 : ($_SESSION['crntPage']-1)).'" ><img src="images/prev.gif" title="قبلي"></img></a></td>
		<td>&nbsp;&nbsp;</td>
	';
	$inx = 0;
	while(($inx<10) && (($stNum+$inx) <= $_SESSION['pageCount'])){
		$out .= '
			<td><a '.(($_SESSION['crntPage']==($stNum+$inx)) ? ' style="text-decoration:none; font-weight:bold;" ':'').' href="?pg=prodMgmtPg_det&cmd=cus_act&cmd2=setPg&pgNum='.($stNum+$inx).'" ><div style="background:#cccccc;">'.($stNum+$inx).'</div></a></td><td>&nbsp;</td>
		';
		
		$inx++;
	}
	$out .= '
		<td><a href="?pg=prodMgmtPg_det&cmd=cus_personcmd2=setPg&pgNum='.((($_SESSION['crntPage']+1)<=$_SESSION['pageCount']) ? ($_SESSION['crntPage']+1) : $_SESSION['pageCount']).'" ><img src="images/next.gif" title="بعدي"></img></a></td>
		<td>&nbsp;&nbsp;</td>
		<td><a href="?pg=prodMgmtPg_det&cmd=cus_person&cmd2=setPg&pgNum='.$_SESSION['pageCount'].'" ><img src="images/last.gif" title="انتها"></img></a></td>
	';
	
	$out .= '
			</tr>
		</table>
	';	
	return $out;
}

function getRPPCombo_cus_person(){
	$out = '<span style="align:center;">
	
		<select onchange="window.open(\'?pg=prodMgmtPg_det&cmd=cus_person&cmd2=setRPP&rPP=\'+this.value, \'_self\')" style="width:50px;" >
			<option value="1" '.(($_SESSION['rPP']==1)?' selected="selected" ':'').' > 1 </option>
			<option value="5" '.(($_SESSION['rPP']==5)?' selected="selected" ':'').' > 5 </option>
			<option value="10" '.(($_SESSION['rPP']==10)?' selected="selected" ':'').' > 10 </option>
			<option value="25" '.(($_SESSION['rPP']==25)?' selected="selected" ':'').' > 25 </option>
			<option value="50" '.(($_SESSION['rPP']==30)?' selected="selected" ':'').' > 50 </option>
			<option value="100" '.(($_SESSION['rPP']==100)?' selected="selected" ':'').' > 100 </option>
			<option value="1000000" '.(($_SESSION['rPP']==0)?' selected="selected" ':'').' > all </option>
		</select>
		
	<span style="color:blue;"><b>پاسخ در صفحه</b></span>
	</div>';
	return $out;
}
function cus_personEditFrm(){
	
$cus_person_id  = isset($_REQUEST['cus_person_id']) ? (int)($_REQUEST['cus_person_id']) : 0;

	if($cus_person_id<1) die('Invalid id!');
	
	$lnk = mysql_query("SELECT * FROM dm_customer_person  WHERE  cus_person_id=".$cus_person_id);
	
		$row = mysql_fetch_assoc($lnk);
	
		?>

	<form method="post" action="" >
	   	
		<input type="hidden" name="pg" value="prodMgmtPg_det">   
		<input type="hidden" name="cmd" value="cus_person_update">  
		<input type="hidden" name="cus_person_id" id="cus_person_id"  value="<?php echo $cus_person_id; ?>">   
		<table  align="center"  class="nasi"   >
		  	<tr style="background-color:<?php echo $_SESSION['htablecolor'] ?>;" >
		       <td colspan="8"  style="height: 50px;vertical-align:middle;"  ><b><font size="5">نوع شخصيت</font></b></td>
	        </tr>
	        <tr>
	           <td colspan="8"><hr style="color:<?php echo $_SESSION['htablecolor'] ?>;height:40%;"></hr></td>
	       </tr>
	      	<tr>
		       	<td ><center>نام نوع شخصيت</center> </td>
		        <td><input name="cus_person_name" id="cus_person_name" type="text" value="<?php echo $row['cus_person_name']; ?>" /></td>
                  <td colspan="2"><button  type="submit"  value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF">ذخیره</button></td>
			     <td colspan="2">&nbsp;</td>	  
	        </tr>
	          <tr>   
	                
			   <td colspan="5">&nbsp;</td>
			      
	      	</tr>
	      		  
	    </table>
	</form>
	
	<?php	
}
function cus_person_update(){
	
$cus_person_id= isset($_REQUEST['cus_person_id']) ? (int)($_REQUEST['cus_person_id']) : 0;

	if($cus_person_id<1) die('Inv Id');
	
	$cus_person_name = isset($_REQUEST['cus_person_name']) ? $_REQUEST['cus_person_name'] : '';
	
	
	$query = "
		UPDATE dm_customer_person    
		SET 
			`cus_person_name` = '".$cus_person_name."',
			`cus_person_date` = ".gmdate('Y-m-d')." 
			
		WHERE 
			cus_person_id = ".$cus_person_id." 
	";
	//print $query;
	//die($query);
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
}
function regcus_personFrm(){
	
	$_SESSION['cus_person_save']=1;
	
	?>
	
<form method="post" action="" id="commentForm">
			<input type="hidden" name="pg" value="prodMgmtPg_det">   
			<input type="hidden" name="cmd" value="regcus_person">	
		<table  align="center" class="nasi" style="font-weight:bold;" >
		  	<tr style="background-color:<?php echo $_SESSION['htablecolor'] ?>;font-weight:bold;">
			       <td colspan="8"  style="height: 50px;vertical-align:middle;"  ><font size="5">نوع شخصيت</font></td>
	       </tr>
	       <tr>
	            <td colspan="8"><hr style="color:<?php echo $_SESSION['htablecolor'] ?>;height:40%;"></hr></td>
	       </tr>
	      	<tr>
		      	 <td>&nbsp;</td>
		         <td colspan="2"><center>نام نوع شخصيت </center></td>
			     <td><input name="cus_person_name" id="cus_person_name" type="text" /></td>		       
	             <td colspan="2"><button  type="submit"  value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF">ذخیره</button></td>
			     <td colspan="2">&nbsp;</td>	  
	        </tr>
	          <tr>   
	                  
			   <td colspan="5">&nbsp;</td>
			      
	      	</tr>
	      	
	    </table>
	
	</form>

	<?php
	
}
function regcus_person(){
	
	if($_SESSION['cus_person_save']==1){
		
	$cus_person_name = isset($_REQUEST['cus_person_name']) ? $_REQUEST['cus_person_name'] : '';
	
	$query = "
		INSERT INTO dm_customer_person 
			(    
			
			    `cus_person_name`, 
				`cus_person_date`
				
			)
			
		VALUES
			(  '".$cus_person_name."',			
				'".gmdate('Y-m-d')."'
			
			)
	";
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
	$_SESSION['cus_person_save']=0;
	$cus_person_id = mysql_insert_id();
	return $cus_person_id;	
	
	}
	$_SESSION['cus_person_save']=0;
}
//cus type
function cus_type(){
	
	?>
	<script>

	  function Access(){
		  alert('شما حق دسترسي نداريد');

	  }
	
	</script>
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
	
	$outHtml = '	<br>
		<form method="get" action="">
			<input type="hidden" name="pg" value="prodMgmtPg_det">   
			<input type="hidden" name="cmd" value="searchtypeCus"> 
			 کلمه مورد نظر را وارد كنيد 
			<div> جستجو : <input type="text" name="search" value="'.$_SESSION['srchStr'].'" style="width:100px;"/> 
			  <button value="draft" name="commit" type="submit">جستجو</button> </div>
		</form>
	';
	
	$outHtml .= '<br>	
		<div align = "center">
		 <div align = "center" style="width:50%;height:200px; overflow:auto">
			<table border="5" align="center" cellpadding="0" cellspacing="0" bgcolor=#99CCCC; class="list" >
      			<tr class="rw1">
        			<th colspan="20" align="center" scope="row" style="height: 50px;vertical-align:middle;"><center>نوع مشتري </center></th>
        		</tr>
        		
      			<tr class="rw0" style="font-weight:bold;">
      			    <td align="center">رديف</td>
			        <td align="center">نوع مشتري</td>
			        <td align="center">تاريخ تعريف </td>
			         <td align="center" colspan="2">&nbsp </td>
			       
				</tr>
	';
	
	if(!isset($_SESSION['srchStr'])) $_SESSION['srchStr'] = '';
	if(!isset($_SESSION['elmCount'])) $_SESSION['elmCount'] = 0;
	if(!isset($_SESSION['rPP'])) $_SESSION['rPP'] = 10;//results per page
	if(!isset($_SESSION['pageCount'])) $_SESSION['pageCount'] = 1;//results page conut
	if(!isset($_SESSION['crntPage'])) $_SESSION['crntPage'] = 1;//current page number
	if($_SESSION['srchStr']==''){
		$srchQ = "";
		
	}else{
		$srchQ = " 
			AND(
					cus_type_name LIKE '%".$_SESSION['srchStr']."%' 
				
			)
		";
		
	}
	$typeQ = '';
	
	$genQuery = "
		
		FROM 
			dm_customer_type   
		WHERE 
			1 
		".$srchQ." 
		".$typeQ." 
	";
	
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
	$_SESSION['srchStr'] = '';	
	$lnk = mysql_query($resQuery);
	$inx = ((($_SESSION['crntPage']-1)*$_SESSION['rPP'])+1);		
	if(mysql_affected_rows()>0){	
	$inx--;
		while($row = mysql_fetch_assoc($lnk)){
			
			$gdate=$row['cus_type_date'];
			list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
			list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
			$jdate = $jyear."/".$jmonth."/".$jday;
			
			if(($inx)%2==1)
				$class="rw0";
				else
				$class="rw1";
			$inx++;
			
			$outHtml .= '
				<tr class='.$class.'>
					<td align="center">'.$inx.'</td>
					<td align="center">'.$row['cus_type_name'].'</td>
					<td align="center">'.$jdate.'</td>';
			  $query2='select *
							from dm_um_rel t
							     inner join dm_listmenu l on l.menu_id = t.um_menu_id
							where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
							      l.menu_code = \'168\' and t.um_can_edit=1';
			                    $lnk2 = mysql_query($query2);
			                    $row2 = mysql_fetch_assoc($lnk2);
//			                    print $query;
			                    if(mysql_affected_rows()>0){				
					$outHtml .= '<td align="center"><a href="?pg=prodMgmtPg_det&cmd=cus_typeEditFrm&cus_type_id='.$row['cus_type_id'].'"><img src="images/edit.png"  width="10%" height="10%"   border="0" title="ويرايش"></img></a></td>';}
		else{
						$outHtml .= '<td align="center"><a href="" onclick="Access();"><img src="images/edit.png"  width="10%" height="10%"   border="0" title="ويرايش"></img></a></td>';
						
					}
			 $query2='select *
					from dm_um_rel t
					     inner join dm_listmenu l on l.menu_id = t.um_menu_id
					where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
					      l.menu_code = \'168\' and t.um_can_delete=1';
			                    $lnk2 = mysql_query($query2);
			                    $row2 = mysql_fetch_assoc($lnk2);
//			                    print $query;
			                    if(mysql_affected_rows()>0){
					$outHtml .= '<td align="center"><a href="?pg=prodMgmtPg_det&cmd=cus_typeDelete&cus_type_id='.$row['cus_type_id'].'"><img src="images/delete.PNG"  width="15%" height="15%"   border="0" title="حذف"></img></a></td>';}
		else{
						$outHtml .= '<td align="center"><a href="" onclick="Access();"><img src="images/delete.PNG"  width="15%" height="15%"   border="0" title="حذف"></img></a></td>';
						
					}
				$outHtml .= '</tr>
			';
		}
		$outHtml .= '<div> <button type="button" onclick=window.open("?pg=prodMgmtPg_det&cmd=regcus_typeFrm","_self") value=" چاپ فاكتور"  value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF"> ايجاد نوع جديد</button></div>
		';
		
    }else{
    	$outHtml .= '<div> <button type="button" onclick=window.open("?pg=prodMgmtPg_det&cmd=regcus_typeFrm","_self") value=" چاپ فاكتور"  value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF"> ايجاد نوع جديد</button></div>
    	<tr class="rw1"><td colspan="10">هيچ اطلاعاتي موجود نيست</td></tr>';
    }
     $outHtml .= '</table>
</div><br>'.getNavBar_cus_type().' '.getRPPCombo_cus_type();
   
    return $outHtml;
		
}

function getNavBar_cus_type(){
	$out = '
		<table style="direction:ltr" >
			<tr>
			
	';
	//if($stNum>$_SESSION['pageCount']) $stNum=$_SESSION['pageCount']-5;
	
	$stNum = $_SESSION['crntPage']-5;
	if($stNum<1) $stNum=1;
	$out .= '
		<td><a href="?pg=prodMgmtPg_det&cmd=cus_type&cmd2=setPg&pgNum=1" ><img src="images/first.gif" title="ابتدا"></img></a></td>
		<td>&nbsp;&nbsp;</td>
		<td><a href="?pg=prodMgmtPg_det&cmd=cus_type&cmd2=setPg&pgNum='.((($_SESSION['crntPage']-1)<1) ? 1 : ($_SESSION['crntPage']-1)).'" ><img src="images/prev.gif" title="قبلي"></img></a></td>
		<td>&nbsp;&nbsp;</td>
	';
	$inx = 0;
	while(($inx<10) && (($stNum+$inx) <= $_SESSION['pageCount'])){
		$out .= '
			<td><a '.(($_SESSION['crntPage']==($stNum+$inx)) ? ' style="text-decoration:none; font-weight:bold;" ':'').' href="?pg=prodMgmtPg_det&cmd=cus_type&cmd2=setPg&pgNum='.($stNum+$inx).'" ><div style="background:#cccccc;">'.($stNum+$inx).'</div></a></td><td>&nbsp;</td>
		';
		
		$inx++;
	}
	$out .= '
		<td><a href="?pg=prodMgmtPg_det&cmd=cus_typecmd2=setPg&pgNum='.((($_SESSION['crntPage']+1)<=$_SESSION['pageCount']) ? ($_SESSION['crntPage']+1) : $_SESSION['pageCount']).'" ><img src="images/next.gif" title="بعدي"></img></a></td>
		<td>&nbsp;&nbsp;</td>
		<td><a href="?pg=prodMgmtPg_det&cmd=cus_type&cmd2=setPg&pgNum='.$_SESSION['pageCount'].'" ><img src="images/last.gif" title="انتها"></img></a></td>
	';
	
	$out .= '
			</tr>
		</table>
	';	
	return $out;
}

function getRPPCombo_cus_type(){
	$out = '<span style="align:center;">
	
		<select onchange="window.open(\'?pg=prodMgmtPg_det&cmd=cus_type&cmd2=setRPP&rPP=\'+this.value, \'_self\')" style="width:50px;" >
			<option value="1" '.(($_SESSION['rPP']==1)?' selected="selected" ':'').' > 1 </option>
			<option value="5" '.(($_SESSION['rPP']==5)?' selected="selected" ':'').' > 5 </option>
			<option value="10" '.(($_SESSION['rPP']==10)?' selected="selected" ':'').' > 10 </option>
			<option value="25" '.(($_SESSION['rPP']==25)?' selected="selected" ':'').' > 25 </option>
			<option value="50" '.(($_SESSION['rPP']==30)?' selected="selected" ':'').' > 50 </option>
			<option value="100" '.(($_SESSION['rPP']==100)?' selected="selected" ':'').' > 100 </option>
			<option value="1000000" '.(($_SESSION['rPP']==0)?' selected="selected" ':'').' > all </option>
		</select>
		
	<span style="color:blue;"><b>پاسخ در صفحه</b></span>
	</div>';
	return $out;
}
function cus_typeEditFrm(){
	
$cus_type_id  = isset($_REQUEST['cus_type_id']) ? (int)($_REQUEST['cus_type_id']) : 0;

	if($cus_type_id<1) die('Invalid id!');
	
	$lnk = mysql_query("SELECT * FROM dm_customer_type  WHERE  cus_type_id=".$cus_type_id);
	
		$row = mysql_fetch_assoc($lnk);
	
		?>

	<form method="post" action="" >
	   	
		<input type="hidden" name="pg" value="prodMgmtPg_det">   
		<input type="hidden" name="cmd" value="cus_type_update">  
		<input type="hidden" name="cus_person_id" id="cus_person_id"  value="<?php echo $cus_person_id; ?>">   
		<table  align="center"  class="nasi"   >
		  	<tr style="background-color:<?php echo $_SESSION['htablecolor'] ?>;" >
		       <td colspan="8"  style="height: 50px;vertical-align:middle;"  ><b><font size="5">  نام نوع مشتري</font></b></td>
	        </tr>
	        <tr>
	           <td colspan="8"><hr style="color:<?php echo $_SESSION['htablecolor'] ?>;height:40%;"></hr></td>
	       </tr>
	      	<tr>
		       	<td ><center>نام نوع مشتري</center> </td>
		        <td><input name="cus_type_name" id="cus_type_name" type="text" value="<?php echo $row['cus_type_name']; ?>" /></td>
                  <td colspan="2"><button  type="submit"  value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF">ذخیره</button></td>
			     <td colspan="2">&nbsp;</td>	  
	        </tr>
	          <tr>   
	                
			   <td colspan="5">&nbsp;</td>
			       
	      	</tr>
	      		  
	    </table>
	</form>
	
	<?php	
}
function cus_type_update(){
	
$cus_type_id= isset($_REQUEST['cus_type_id']) ? (int)($_REQUEST['cus_type_id']) : 0;

	if($cus_type_id<1) die('Inv Id');
	
	$cus_type_name = isset($_REQUEST['cus_type_name']) ? $_REQUEST['cus_type_name'] : '';
	
	
	$query = "
		UPDATE dm_customer_type    
		SET 
			`cus_type_name` = '".$cus_type_name."',
			`cus_type_date` = ".gmdate('Y-m-d')." 
			
		WHERE 
			cus_type_id = ".$cus_type_id." 
	";
	//print $query;
	//die($query);
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
}
function charge_tDelete(){
	
	$charge_t_id = isset($_REQUEST['charge_t_id']) ? $_REQUEST['charge_t_id'] : '';
	
	if($charge_t_id <1) die('Inv Id');
		
		$query = "
		DELETE FROM dm_type_charge 
	 
			WHERE 
				charge_t_id  = ".$charge_t_id ." 
		";
		$lnk = mysql_query($query);
		if(mysql_error()) print mysql_error();
}
function cus_activeDelete(){
	$cus_act_id = isset($_REQUEST['cus_act_id']) ? $_REQUEST['cus_act_id'] : '';
	
	if($cus_act_id<1) die('Inv Id');
		
		$query = "
		DELETE FROM dm_customer_act_t 
	 
			WHERE 
				cus_act_id  = ".$cus_act_id ." 
		";
		$lnk = mysql_query($query);
		if(mysql_error()) print mysql_error();
	
}
function cus_payDelete(){
	$cus_pay_id = isset($_REQUEST['cus_pay_id']) ? $_REQUEST['cus_pay_id'] : '';
	
	if($cus_pay_id<1) die('Inv Id');
		
		$query = "
		DELETE FROM dm_customer_pay_t 
	 
			WHERE 
				cus_pay_id  = ".$cus_pay_id ." 
		";
		$lnk = mysql_query($query);
		if(mysql_error()) print mysql_error();
}
function cus_personDelete(){
	
	$cus_person_id = isset($_REQUEST['cus_person_id']) ? $_REQUEST['cus_person_id'] : '';
	
	if($cus_person_id<1) die('Inv Id');
		
		$query = "
		DELETE FROM dm_customer_person 
	 
			WHERE 
				cus_person_id   = ".$cus_person_id  ." 
		";
		$lnk = mysql_query($query);
		if(mysql_error()) print mysql_error();
	
}
function cus_typeDelete(){
	
$cus_type_id = isset($_REQUEST['cus_type_id']) ? $_REQUEST['cus_type_id'] : '';
	
	if($cus_type_id<1) die('Inv Id');
		
		$query = "
		DELETE FROM dm_customer_type 
	 
			WHERE 
				cus_type_id   = ".$cus_type_id  ." 
		";
		$lnk = mysql_query($query);
		if(mysql_error()) print mysql_error();
	
}
function status_typeDelete(){
	
	$status_type_id = isset($_REQUEST['status_type_id']) ? $_REQUEST['status_type_id'] : '';
	
	if($cus_type_id<1) die('Inv Id');
		
		$query = "
		DELETE FROM dm_customer_status 
	 
			WHERE 
				status_type_id   = ".$status_type_id  ." 
		";
		$lnk = mysql_query($query);
		if(mysql_error()) print mysql_error();
	
}
function status_s_typeDelete(){
	
	$cus_status_s_id = isset($_REQUEST['cus_status_s_id']) ? $_REQUEST['cus_status_s_id'] : '';
	
	if($cus_status_s_id<1) die('Inv Id');
		
		$query = "
		DELETE FROM dm_customer_status_s 
	 
			WHERE 
				cus_status_s_id   = ".$cus_status_s_id  ." 
		";
		$lnk = mysql_query($query);
		if(mysql_error()) print mysql_error();
	
}
function regcus_typeFrm(){
	
	$_SESSION['cus_type_save']=1;
	
	?>
	
<form method="post" action="" id="commentForm">
			<input type="hidden" name="pg" value="prodMgmtPg_det">   
			<input type="hidden" name="cmd" value="regcus_type">	
		<table  align="center" class="nasi" style="font-weight:bold;" >
		  	<tr style="background-color:<?php echo $_SESSION['htablecolor'] ?>;font-weight:bold;">
			       <td colspan="8"  style="height: 50px;vertical-align:middle;"  ><font size="5">نوع مشتري</font></td>
	       </tr>
	       <tr>
	            <td colspan="8"><hr style="color:<?php echo $_SESSION['htablecolor'] ?>;height:40%;"></hr></td>
	       </tr>
	      	<tr>
		      	 <td>&nbsp;</td>
		         <td colspan="2"><center>نام نوع مشتري </center></td>
			     <td><input name="cus_type_name" id="cus_type_name" type="text" /></td>		       
	             <td colspan="2"><button  type="submit"  value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF">ذخیره</button></td>
			     <td colspan="2">&nbsp;</td>	  
	        </tr>
	          <tr>   
	                
			   <td colspan="5">&nbsp;</td>
			     
	      	</tr>
	      	
	    </table>
	
	</form>

	<?php
	
}
function regcus_type(){
	
	if($_SESSION['cus_type_save']==1){
		
	$cus_type_name = isset($_REQUEST['cus_type_name']) ? $_REQUEST['cus_type_name'] : '';
	
	$query = "
		INSERT INTO dm_customer_type 
			(    
			
			    `cus_type_name`, 
				`cus_type_date`
				
			)
			
		VALUES
			(  '".$cus_type_name."',			
				'".gmdate('Y-m-d')."'
			
			)
	";
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
	$_SESSION['cus_type_save']=0;
	$cus_person_id = mysql_insert_id();
	return $cus_person_id;	
	
	}
	$_SESSION['cus_type_save']=0;
}
//cus status
function cus_status(){
	
					?>
	<script>

	  function Access(){
		  alert('شما حق دسترسي نداريد');

	  }
	
	</script>
	
	
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
	
	$outHtml = '	<br>
		<form method="get" action="">
			<input type="hidden" name="pg" value="prodMgmtPg_det">   
			<input type="hidden" name="cmd" value="searchstatusCus"> 
			 کلمه مورد نظر را وارد كنيد 
			<div> جستجو : <input type="text" name="search" value="'.$_SESSION['srchStr'].'" style="width:100px;"/> 
			  <button value="draft" name="commit" type="submit">جستجو</button> </div>
		</form>
	';
	
	$outHtml .= '<br>	
		<div align = "center">
		 <div align = "center" style="width:50%;height:200px; overflow:auto">
			<table border="5" align="center" cellpadding="0" cellspacing="0" bgcolor=#99CCCC; class="list" >
      			<tr class="rw1">
        			<th colspan="20" align="center" scope="row" style="height: 50px;vertical-align:middle;"><center>نوع وضعيت </center></th>
        		</tr>
        		
      			<tr class="rw0" style="font-weight:bold;">
      			    <td align="center">رديف</td>
			        <td align="center">نوع وضعيت</td>
			        <td align="center">تاريخ تعريف </td>
			         <td align="center" colspan="2">&nbsp </td>
			       
				</tr>
	';
	
	if(!isset($_SESSION['srchStr'])) $_SESSION['srchStr'] = '';
	if(!isset($_SESSION['elmCount'])) $_SESSION['elmCount'] = 0;
	if(!isset($_SESSION['rPP'])) $_SESSION['rPP'] = 10;//results per page
	if(!isset($_SESSION['pageCount'])) $_SESSION['pageCount'] = 1;//results page conut
	if(!isset($_SESSION['crntPage'])) $_SESSION['crntPage'] = 1;//current page number
	if($_SESSION['srchStr']==''){
		$srchQ = "";
		
	}else{
		$srchQ = " 
			AND(
					cus_status_name LIKE '%".$_SESSION['srchStr']."%' 
				
			)
		";
		
	}
	$typeQ = '';
	
	$genQuery = "
		
		FROM 
			dm_customer_status   
		WHERE 
			1 
		".$srchQ." 
		".$typeQ." 
	";
	
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
		$_SESSION['srchStr'] = '';
	$lnk = mysql_query($resQuery);
	$inx = ((($_SESSION['crntPage']-1)*$_SESSION['rPP'])+1);		
	if(mysql_affected_rows()>0){	
	$inx--;
		while($row = mysql_fetch_assoc($lnk)){
			
			$gdate=$row['cus_status_date'];
			list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
			list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
			$jdate = $jyear."/".$jmonth."/".$jday;
			
			if(($inx)%2==1)
				$class="rw0";
				else
				$class="rw1";
			$inx++;
			
			$outHtml .= '
				<tr class='.$class.'>
					<td align="center">'.$inx.'</td>
					<td align="center">'.$row['cus_status_name'].'</td>
					<td align="center">'.$jdate.'</td>';
			  $query2='select *
								from dm_um_rel t
								     inner join dm_listmenu l on l.menu_id = t.um_menu_id
								where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
								      l.menu_code = \'169\' and t.um_can_edit=1';
			                    $lnk2 = mysql_query($query2);
			                    $row2 = mysql_fetch_assoc($lnk2);
//			                    print $query;
			                    if(mysql_affected_rows()>0){					
					$outHtml .= '<td align="center"><a href="?pg=prodMgmtPg_det&cmd=status_typeEditFrm&status_type_id='.$row['status_type_id'].'"><img src="images/edit.png"  width="15%" height="15%"   border="0" title="ويرايش"></img></a></td>';}
		else{
						$outHtml .= '<td align="center"><a href="" onclick="Access();"><img src="images/edit.png"  width="15%" height="15%"   border="0" title="ويرايش"></img></a></td>';
						
					}
			  $query2='select *
						from dm_um_rel t
						     inner join dm_listmenu l on l.menu_id = t.um_menu_id
						where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
						      l.menu_code = \'169\' and t.um_can_delete=1';
	                    $lnk2 = mysql_query($query2);
	                    $row2 = mysql_fetch_assoc($lnk2);
//			                    print $query;
			                    if(mysql_affected_rows()>0){
					   $outHtml .= '<td align="center"><a href="?pg=prodMgmtPg_det&cmd=status_typeDelete&status_type_id='.$row['status_type_id'].'"><img src="images/delete.PNG"  width="20%" height="20%"   border="0" title="حذف"></img></a></td>';}
		else{
						$outHtml .= '<td align="center"><a href="" onclick="Access();"><img src="images/delete.PNG"  width="20%" height="20%"   border="0" title="حذف"></img></a></td>';
						
					}
				$outHtml .= '</tr>
			';
		}
		$outHtml .= '<div> <button type="button" onclick=window.open("?pg=prodMgmtPg_det&cmd=regcus_statusFrm","_self") value=" چاپ فاكتور"  value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF"> ايجاد وضعيت جديد</button></div>
		';
		
    }else{
    	$outHtml .= '<div> <button type="button" onclick=window.open("?pg=prodMgmtPg_det&cmd=regcus_statusFrm","_self") value=" چاپ فاكتور"  value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF"> ايجاد وضعيت جديد</button></div>
    	<tr class="rw1"><td colspan="10">هيچ اطلاعاتي موجود نيست</td></tr>';
    }
     $outHtml .= '</table>
</div><br>'.getNavBar_cus_status().' '.getRPPCombo_cus_status();
   
    return $outHtml;
		
}

function getNavBar_cus_status(){
	$out = '
		<table style="direction:ltr" >
			<tr>
			
	';
	//if($stNum>$_SESSION['pageCount']) $stNum=$_SESSION['pageCount']-5;
	
	$stNum = $_SESSION['crntPage']-5;
	if($stNum<1) $stNum=1;
	$out .= '
		<td><a href="?pg=prodMgmtPg_det&cmd=cus_status&cmd2=setPg&pgNum=1" ><img src="images/first.gif" title="ابتدا"></img></a></td>
		<td>&nbsp;&nbsp;</td>
		<td><a href="?pg=prodMgmtPg_det&cmd=cus_status&cmd2=setPg&pgNum='.((($_SESSION['crntPage']-1)<1) ? 1 : ($_SESSION['crntPage']-1)).'" ><img src="images/prev.gif" title="قبلي"></img></a></td>
		<td>&nbsp;&nbsp;</td>
	';
	$inx = 0;
	while(($inx<10) && (($stNum+$inx) <= $_SESSION['pageCount'])){
		$out .= '
			<td><a '.(($_SESSION['crntPage']==($stNum+$inx)) ? ' style="text-decoration:none; font-weight:bold;" ':'').' href="?pg=prodMgmtPg_det&cmd=cus_type&cmd2=setPg&pgNum='.($stNum+$inx).'" ><div style="background:#cccccc;">'.($stNum+$inx).'</div></a></td><td>&nbsp;</td>
		';
		
		$inx++;
	}
	$out .= '
		<td><a href="?pg=prodMgmtPg_det&cmd=cus_statuscmd2=setPg&pgNum='.((($_SESSION['crntPage']+1)<=$_SESSION['pageCount']) ? ($_SESSION['crntPage']+1) : $_SESSION['pageCount']).'" ><img src="images/next.gif" title="بعدي"></img></a></td>
		<td>&nbsp;&nbsp;</td>
		<td><a href="?pg=prodMgmtPg_det&cmd=cus_status&cmd2=setPg&pgNum='.$_SESSION['pageCount'].'" ><img src="images/last.gif" title="انتها"></img></a></td>
	';
	
	$out .= '
			</tr>
		</table>
	';	
	return $out;
}

function getRPPCombo_cus_status(){
	$out = '<span style="align:center;">
	
		<select onchange="window.open(\'?pg=prodMgmtPg_det&cmd=cus_status&cmd2=setRPP&rPP=\'+this.value, \'_self\')" style="width:50px;" >
			<option value="1" '.(($_SESSION['rPP']==1)?' selected="selected" ':'').' > 1 </option>
			<option value="5" '.(($_SESSION['rPP']==5)?' selected="selected" ':'').' > 5 </option>
			<option value="10" '.(($_SESSION['rPP']==10)?' selected="selected" ':'').' > 10 </option>
			<option value="25" '.(($_SESSION['rPP']==25)?' selected="selected" ':'').' > 25 </option>
			<option value="50" '.(($_SESSION['rPP']==30)?' selected="selected" ':'').' > 50 </option>
			<option value="100" '.(($_SESSION['rPP']==100)?' selected="selected" ':'').' > 100 </option>
			<option value="1000000" '.(($_SESSION['rPP']==0)?' selected="selected" ':'').' > all </option>
		</select>
		
	<span style="color:blue;"><b>پاسخ در صفحه</b></span>
	</div>';
	return $out;
}
function cus_statusEditFrm(){
	
$cus_status_id  = isset($_REQUEST['cus_status_id']) ? (int)($_REQUEST['cus_status_id']) : 0;

	if($cus_status_id<1) die('Invalid id!');
	
	$lnk = mysql_query("SELECT * FROM dm_customer_status  WHERE  cus_status_id=".$cus_status_id);
	
		$row = mysql_fetch_assoc($lnk);
	
		?>

	<form method="post" action="" >
	   	
		<input type="hidden" name="pg" value="prodMgmtPg_det">   
		<input type="hidden" name="cmd" value="cus_status_update">  
		<input type="hidden" name="cus_person_id" id="cus_status_id"  value="<?php echo $cus_status_id; ?>">   
		<table  align="center"  class="nasi"   >
		  	<tr style="background-color:<?php echo $_SESSION['htablecolor'] ?>;" >
		       <td colspan="8"  style="height: 50px;vertical-align:middle;"  ><b><font size="5">  نام وضعيت مشتري</font></b></td>
	        </tr>
	        <tr>
	           <td colspan="8"><hr style="color:<?php echo $_SESSION['htablecolor'] ?>;height:40%;"></hr></td>
	       </tr>
	      	<tr>
		       	<td ><center>نام وضعيت مشتري</center> </td>
		        <td><input name="cus_status_name" id="cus_status_name" type="text" value="<?php echo $row['cus_status_name']; ?>" /></td>
                  <td colspan="2"><button  type="submit"  value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF">ذخیره</button></td>
			     <td colspan="2">&nbsp;</td>	  
	        </tr>
	          <tr>   
	                   
			   <td colspan="5">&nbsp;</td>
			       
	      	</tr>
	      		  
	    </table>
	</form>
	
	<?php	
}
function cus_status_update(){
	
$cus_status_id= isset($_REQUEST['cus_status_id']) ? (int)($_REQUEST['cus_status_id']) : 0;

	if($cus_type_id<1) die('Inv Id');
	
	$cus_status_name = isset($_REQUEST['cus_status_name']) ? $_REQUEST['cus_status_name'] : '';
	
	
	$query = "
		UPDATE dm_customer_status    
		SET 
			`cus_status_name` = '".$cus_status_name."',
			`cus_status_date` = ".gmdate('Y-m-d')." 
			
		WHERE 
			cus_status_id = ".$cus_status_id." 
	";
	//print $query;
	//die($query);
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
}
function regcus_statusFrm(){
	
	$_SESSION['cus_status_save']=1;
	
	?>
	
<form method="post" action="" id="commentForm">
			<input type="hidden" name="pg" value="prodMgmtPg_det">   
			<input type="hidden" name="cmd" value="regcus_status">	
		<table  align="center" class="nasi" style="font-weight:bold;" >
		  	<tr style="background-color:<?php echo $_SESSION['htablecolor'] ?>;font-weight:bold;">
			       <td colspan="8"  style="height: 50px;vertical-align:middle;"  ><font size="5">نوع وضعيت</font></td>
	       </tr>
	       <tr>
	            <td colspan="8"><hr style="color:<?php echo $_SESSION['htablecolor'] ?>;height:40%;"></hr></td>
	       </tr>
	      	<tr>
		      	 <td>&nbsp;</td>
		         <td colspan="2"><center>نام وضعيت مشتري </center></td>
			     <td><input name="cus_status_name" id="cus_status_name" type="text" /></td>		       
	             <td colspan="2"><button  type="submit"  value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF">ذخیره</button></td>
			     <td colspan="2">&nbsp;</td>	  
	        </tr>
	          <tr>   
	                  
			   <td colspan="5">&nbsp;</td>
			      
	      	</tr>
	      	
	    </table>
	
	</form>

	<?php
	
}
function regcus_status_s(){
	
	if($_SESSION['cus_status_s_save']==1){
		
	$cus_status_s_name = isset($_REQUEST['cus_status_s_name']) ? $_REQUEST['cus_status_s_name'] : '';
	
	$query = "
		INSERT INTO dm_customer_status_s 
			(    
			
			    `cus_status_s_name`, 
			    `cus_status_s_u_id`, 
				`cus_status_s_date`
				
			)
			
		VALUES
			(  '".$cus_status_s_name."',	
			   '".$_SESSION['dm_user_profile']['u_id']."',		
				'".gmdate('Y-m-d')."'
			
			)
	";
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
	$_SESSION['cus_status_save']=0;
	$cus_status_s_id = mysql_insert_id();
	return $cus_status_s_id;	
	
	}
	$_SESSION['cus_status_s_save']=0;
	
}
function regcus_status(){
	
	if($_SESSION['cus_status_save']==1){
		
	$cus_status_name = isset($_REQUEST['cus_status_name']) ? $_REQUEST['cus_status_name'] : '';
	
	$query = "
		INSERT INTO dm_customer_status 
			(    
			
			    `cus_status_name`, 
			    `cus_status_u_id`, 
				`cus_status_date`
				
			)
			
		VALUES
			(  '".$cus_status_name."',
			   '".$_SESSION['dm_user_profile']['u_id']."',			
				'".gmdate('Y-m-d')."'
			
			)
	";
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
	$_SESSION['cus_status_save']=0;
	$cus_status_id = mysql_insert_id();
	return $cus_status_id;	
	
	}
	$_SESSION['cus_status_save']=0;
}
//cus status_s

function cus_status_s(){
	
					?>
	<script>

	  function Access(){
		  alert('شما حق دسترسي نداريد');

	  }
	
	</script>
	
	
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
	
	$outHtml = '	<br>
		<form method="get" action="">
			<input type="hidden" name="pg" value="prodMgmtPg_det">   
			<input type="hidden" name="cmd" value="searchstatus_sCus"> 
			 کلمه مورد نظر را وارد كنيد 
			<div> جستجو : <input type="text" name="search" value="'.$_SESSION['srchStr'].'" style="width:100px;"/> 
			  <button value="draft" name="commit" type="submit">جستجو</button> </div>
		</form>';
		
	$outHtml .= '<br>	
		<div align = "center">
		 <div align = "center" style="width:50%;height:200px; overflow:auto">
			<table border="5" align="center" cellpadding="0" cellspacing="0" bgcolor=#99CCCC; class="list" >
      			<tr class="rw1">
        			<th colspan="20" align="center" scope="row" style="height: 50px;vertical-align:middle;"><center>نوع سهميه </center></th>
        		</tr>
        		
      			<tr class="rw0" style="font-weight:bold;">
      			    <td align="center">رديف</td>
			        <td align="center">نوع سهميه</td>
			        <td align="center">تاريخ تعريف </td>
			         <td align="center" colspan="2">&nbsp </td>
			       
				</tr>';
	
	
	if(!isset($_SESSION['srchStr'])) $_SESSION['srchStr'] = '';
	if(!isset($_SESSION['elmCount'])) $_SESSION['elmCount'] = 0;
	if(!isset($_SESSION['rPP'])) $_SESSION['rPP'] = 10;//results per page
	if(!isset($_SESSION['pageCount'])) $_SESSION['pageCount'] = 1;//results page conut
	if(!isset($_SESSION['crntPage'])) $_SESSION['crntPage'] = 1;//current page number
	if($_SESSION['srchStr']==''){
		$srchQ = "";
		
	}else{
		$srchQ = " 
			AND(
					cus_status_s_name LIKE '%".$_SESSION['srchStr']."%' 
				
			)
		";
		
	}
	$typeQ = '';
	
	$genQuery = "
		
		FROM 
			dm_customer_status_s   
		WHERE 
			1 
		".$srchQ." 
		".$typeQ." 
	";
	
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
	$_SESSION['srchStr'] = '';	
	$lnk = mysql_query($resQuery);
	$inx = ((($_SESSION['crntPage']-1)*$_SESSION['rPP'])+1);		
	if(mysql_affected_rows()>0){	
	$inx--;
		while($row = mysql_fetch_assoc($lnk)){
			
			$gdate=$row['cus_status_s_date'];
			list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
			list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
			$jdate = $jyear."/".$jmonth."/".$jday;
			
			if(($inx)%2==1)
				$class="rw0";
				else
				$class="rw1";
			$inx++;
			
			$outHtml .= '
				<tr class='.$class.'>
					<td align="center">'.$inx.'</td>
					<td align="center">'.$row['cus_status_s_name'].'</td>
					<td align="center">'.$jdate.'</td>';	
			  $query2='select *
							from dm_um_rel t
							     inner join dm_listmenu l on l.menu_id = t.um_menu_id
							where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
							      l.menu_code = \'1691\' and t.um_can_edit=1';
			                    $lnk2 = mysql_query($query2);
			                    $row2 = mysql_fetch_assoc($lnk2);
			                    if(mysql_affected_rows()>0){				
					$outHtml .= '<td align="center"><a href="?pg=prodMgmtPg_det&cmd=status_s_typeEditFrm&cus_status_s_id='.$row['cus_status_s_id'].'"><img src="images/edit.png"  width="15%" height="15%"   border="0" title="ويرايش"></img></a></td>';}
		else{
			$outHtml .= '<td align="center"><a href="" onclick="Access();"><img src="images/edit.png"  width="15%" height="15%"   border="0" title="ويرايش"></img></a></td>';
						
					}
		 $query2='select *
				from dm_um_rel t
				     inner join dm_listmenu l on l.menu_id = t.um_menu_id
				where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
				      l.menu_code = \'1691\' and t.um_can_edit=1';
                    $lnk2 = mysql_query($query2);
                    $row2 = mysql_fetch_assoc($lnk2);
			                    if(mysql_affected_rows()>0){	
					$outHtml .= '<td align="center"><a href="?pg=prodMgmtPg_det&cmd=status_s_typeDelete&cus_status_s_id='.$row['cus_status_s_id'].'"><img src="images/delete.PNG"  width="15%" height="15%"   border="0" title="حذف"></img></a></td>';}
		else{
						$outHtml .= '<td align="center"><a href="" onclick="Access();"><img src="images/delete.PNG"  width="15%" height="15%"   border="0" title="حذف"></img></a></td>';
						
					}
				$outHtml .= '</tr>
			';
		}
		$outHtml .= '<div> <button type="button" onclick=window.open("?pg=prodMgmtPg_det&cmd=regcus_status_sFrm","_self")   value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF"> ايجاد سهميه جديد</button></div>
		';
		
    }else{
    	$outHtml .= '<div> <button type="button" onclick=window.open("?pg=prodMgmtPg_det&cmd=regcus_status_sFrm","_self")   value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF"> ايجاد سهميه جديد</button></div>
    	            <tr class="rw1"><td colspan="10">هيچ اطلاعاتي موجود نيست</td></tr>';
    }
     $outHtml .= '</table>
</div><br>'.getNavBar_cus_status_s().' '.getRPPCombo_cus_status_s();
   
    return $outHtml;
		
}

function getNavBar_cus_status_s(){
	$out = '
		<table style="direction:ltr" >
			<tr>
			
	';
	//if($stNum>$_SESSION['pageCount']) $stNum=$_SESSION['pageCount']-5;
	
	$stNum = $_SESSION['crntPage']-5;
	if($stNum<1) $stNum=1;
	$out .= '
		<td><a href="?pg=prodMgmtPg_det&cmd=cus_status_s&cmd2=setPg&pgNum=1" ><img src="images/first.gif" title="ابتدا"></img></a></td>
		<td>&nbsp;&nbsp;</td>
		<td><a href="?pg=prodMgmtPg_det&cmd=cus_status_s&cmd2=setPg&pgNum='.((($_SESSION['crntPage']-1)<1) ? 1 : ($_SESSION['crntPage']-1)).'" ><img src="images/prev.gif" title="قبلي"></img></a></td>
		<td>&nbsp;&nbsp;</td>
	';
	$inx = 0;
	while(($inx<10) && (($stNum+$inx) <= $_SESSION['pageCount'])){
		$out .= '
			<td><a '.(($_SESSION['crntPage']==($stNum+$inx)) ? ' style="text-decoration:none; font-weight:bold;" ':'').' href="?pg=prodMgmtPg_det&cmd=cus_type&cmd2=setPg&pgNum='.($stNum+$inx).'" ><div style="background:#cccccc;">'.($stNum+$inx).'</div></a></td><td>&nbsp;</td>
		';
		
		$inx++;
	}
	$out .= '
		<td><a href="?pg=prodMgmtPg_det&cmd=cus_status_scmd2=setPg&pgNum='.((($_SESSION['crntPage']+1)<=$_SESSION['pageCount']) ? ($_SESSION['crntPage']+1) : $_SESSION['pageCount']).'" ><img src="images/next.gif" title="بعدي"></img></a></td>
		<td>&nbsp;&nbsp;</td>
		<td><a href="?pg=prodMgmtPg_det&cmd=cus_status_s&cmd2=setPg&pgNum='.$_SESSION['pageCount'].'" ><img src="images/last.gif" title="انتها"></img></a></td>
	';
	
	$out .= '
			</tr>
		</table>
	';	
	return $out;
}

function getRPPCombo_cus_status_s(){
	$out = '<span style="align:center;">
	
		<select onchange="window.open(\'?pg=prodMgmtPg_det&cmd=cus_status_s&cmd2=setRPP&rPP=\'+this.value, \'_self\')" style="width:50px;" >
			<option value="1" '.(($_SESSION['rPP']==1)?' selected="selected" ':'').' > 1 </option>
			<option value="5" '.(($_SESSION['rPP']==5)?' selected="selected" ':'').' > 5 </option>
			<option value="10" '.(($_SESSION['rPP']==10)?' selected="selected" ':'').' > 10 </option>
			<option value="25" '.(($_SESSION['rPP']==25)?' selected="selected" ':'').' > 25 </option>
			<option value="50" '.(($_SESSION['rPP']==30)?' selected="selected" ':'').' > 50 </option>
			<option value="100" '.(($_SESSION['rPP']==100)?' selected="selected" ':'').' > 100 </option>
			<option value="1000000" '.(($_SESSION['rPP']==0)?' selected="selected" ':'').' > all </option>
		</select>
		
	<span style="color:blue;"><b>پاسخ در صفحه</b></span>
	</div>';
	return $out;
}
function status_s_typeEditFrm(){
	
$cus_status_s_id  = isset($_REQUEST['cus_status_s_id']) ? (int)($_REQUEST['cus_status_s_id']) : 0;

	if($cus_status_s_id<1) die('Invalid id!');
	
	$lnk = mysql_query("SELECT * FROM dm_customer_status_s  WHERE  cus_status_s_id=".$cus_status_s_id);
	
		$row = mysql_fetch_assoc($lnk);
	
		?>

	<form method="post" action="" >
	   	
		<input type="hidden" name="pg" value="prodMgmtPg_det">   
		<input type="hidden" name="cmd" value="cus_status_s_update">  
		<input type="hidden" name="cus_person_id" id="cus_status_s_id"  value="<?php echo $cus_status_s_id; ?>">   
		<table  align="center"  class="nasi"   >
		  	<tr style="background-color:<?php echo $_SESSION['htablecolor'] ?>;" >
		       <td colspan="8"  style="height: 50px;vertical-align:middle;"  ><b><font size="5">  نام سهميه</font></b></td>
	        </tr>
	        <tr>
	           <td colspan="8"><hr style="color:<?php echo $_SESSION['htablecolor'] ?>;height:40%;"></hr></td>
	       </tr>
	      	<tr>
		       	<td ><center>نام سهميه </center> </td>
		        <td><input name="cus_status_s_name" id="cus_status_s_name" type="text" value="<?php echo $row['cus_status_s_name']; ?>" /></td>
                  <td colspan="2"><button  type="submit"  value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF">ذخیره</button></td>
			     <td colspan="2">&nbsp;</td>	  
	        </tr>
	          <tr>   
	                 
			   <td colspan="5">&nbsp;</td>
			       
	      	</tr>
	      		  
	    </table>
	</form>
	
	<?php	
}
function cus_status_s_update(){
	
$cus_status_s_id= isset($_REQUEST['cus_status_s_id']) ? (int)($_REQUEST['cus_status_s_id']) : 0;

	if($cus_status_s_id<1) die('Inv Id');
	
	$cus_status_s_name = isset($_REQUEST['cus_status_s_name']) ? $_REQUEST['cus_status_s_name'] : '';
	
	
	$query = "
		UPDATE dm_customer_status_s    
		SET 
			`cus_status_s_name` = '".$cus_status_s_name."',
			`cus_status_s_date` = '".gmdate('Y-m-d')."' 
			
		WHERE 
			cus_status_s_id = ".$cus_status_s_id." 
	";
	//print $query;
	//die($query);
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
}
function regcharge_tFrm(){
	
	$_SESSION['charge_t']=1;
	
	?>
	
<form method="post" action="" id="commentForm">
			<input type="hidden" name="pg" value="prodMgmtPg_det">   
			<input type="hidden" name="cmd" value="regcharge_t">	
		<table  align="center" class="nasi" style="font-weight:bold;" >
		  	<tr style="background-color:<?php echo $_SESSION['htablecolor'] ?>;font-weight:bold;">
			       <td colspan="8"  style="height: 50px;vertical-align:middle;"  ><font size="5">نوع هزینه</font></td>
	       </tr>
	       <tr>
	            <td colspan="8"><hr style="color:<?php echo $_SESSION['htablecolor'] ?>;height:40%;"></hr></td>
	       </tr>
	      	<tr>
		      	 <td>&nbsp;</td>
		         <td colspan="2"><center>نوع هزينه </center></td>
			     <td><input name="charge_t_name" id="charge_t_name" type="text" /></td>		       
	             <td colspan="2"><button  type="submit"  value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF">ذخیره</button></td>
			     <td colspan="2">&nbsp;</td>	  
	        </tr>
	          <tr>   
	                  
			   <td colspan="5">&nbsp;</td>
			        
	      	</tr>
	      	
	    </table>
	
	</form>

	<?php
	
}
function regcharge_t(){
	
	if($_SESSION['charge_t']==1){
		
	$charge_t_name = isset($_REQUEST['charge_t_name']) ? $_REQUEST['charge_t_name'] : '';
	
	$query = "
		INSERT INTO dm_type_charge
			(    
			
			    `charge_t_name`, 
				`charge_t_date`
				
			)
			
		VALUES
			(  '".$charge_t_name."',			
				'".gmdate('Y-m-d')."'
			
			)
	";
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
	$_SESSION['charge_t']=0;
	$charge_t_id = mysql_insert_id();
	return $charge_t_id;	
	
	}
	$_SESSION['charge_t']=0;
}
//charge type

function charge_type(){
	
					?>
	<script>

	  function Access(){
		  alert('شما حق دسترسي نداريد');

	  }
	
	</script>
	
	
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
	
	$outHtml = '	<br>
		<form method="get" action="">
			<input type="hidden" name="pg" value="prodMgmtPg_det">   
			<input type="hidden" name="cmd" value="searchtype_charge"> 
			 کلمه مورد نظر را وارد كنيد 
			<div> جستجو : <input type="text" name="search" value="'.$_SESSION['srchStr'].'" style="width:100px;"/> 
			  <button value="draft" name="commit" type="submit">جستجو</button> </div>
		</form>
	';
	
	$outHtml .= '<br>	
		<div align = "center">
		 <div align = "center" style="width:50%;height:200px; overflow:auto">
			<table border="5" align="center" cellpadding="0" cellspacing="0" bgcolor=#99CCCC; class="list" >
      			<tr class="rw1">
        			<th colspan="20" align="center" scope="row" style="height: 50px;vertical-align:middle;"><center>نوع هزینه </center></th>
        		</tr>
        		
      			<tr class="rw0" style="font-weight:bold;">
      			    <td align="center">رديف</td>
			        <td align="center">نوع هزینه</td>
			        <td align="center">تاريخ تعريف </td>
			        <td align="center" colspan="2">&nbsp </td>
			       
				</tr>
	';
	
	if(!isset($_SESSION['srchStr'])) $_SESSION['srchStr'] = '';
	if(!isset($_SESSION['elmCount'])) $_SESSION['elmCount'] = 0;
	if(!isset($_SESSION['rPP'])) $_SESSION['rPP'] = 10;//results per page
	if(!isset($_SESSION['pageCount'])) $_SESSION['pageCount'] = 1;//results page conut
	if(!isset($_SESSION['crntPage'])) $_SESSION['crntPage'] = 1;//current page number
	if($_SESSION['srchStr']==''){
		$srchQ = "";
		
	}else{
		$srchQ = " 
			AND(
					charge_t_name LIKE '%".$_SESSION['srchStr']."%' 
				
			)
		";
		
	}
	$typeQ = '';
	
	$genQuery = "
		
		FROM 
			dm_type_charge    
		WHERE 
			1 
		".$srchQ." 
		".$typeQ." 
	";
	
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
		$_SESSION['srchStr'] = '';
	$lnk = mysql_query($resQuery);
	$inx = ((($_SESSION['crntPage']-1)*$_SESSION['rPP'])+1);		
	if(mysql_affected_rows()>0){	
	$inx--;
		while($row = mysql_fetch_assoc($lnk)){
			
			$gdate=$row['charge_t_date'];
			list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
			list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
			$jdate = $jyear."/".$jmonth."/".$jday;
			
			if(($inx)%2==1)
				$class="rw0";
				else
				$class="rw1";
			$inx++;
			
			$outHtml .= '
				<tr class='.$class.'>
					<td align="center">'.$inx.'</td>
					<td align="center">'.$row['charge_t_name'].'</td>
					<td align="center">'.$jdate.'</td>';	
			  $query2='select *
							from dm_um_rel t
							     inner join dm_listmenu l on l.menu_id = t.um_menu_id
							where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
							      l.menu_code = \'1692\' and t.um_can_edit=1';
			                    $lnk2 = mysql_query($query2);
			                    $row2 = mysql_fetch_assoc($lnk2);
			                    if(mysql_affected_rows()>0){				
					$outHtml .= '<td align="center"><a href="?pg=prodMgmtPg_det&cmd=charge_tEditFrm&charge_t_id='.$row['charge_t_id'].'"><img src="images/edit.png"  width="10%" height="10%"   border="0" title="ويرايش"></img></a></td>';}
		else{
			$outHtml .= '<td align="center"><a href="" onclick="Access();"><img src="images/edit.png"  width="10%" height="10%"   border="0" title="ويرايش"></img></a></td>';
						
					}
		 $query2='select *
				from dm_um_rel t
				     inner join dm_listmenu l on l.menu_id = t.um_menu_id
				where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
				      l.menu_code = \'1692\' and t.um_can_edit=1';
                    $lnk2 = mysql_query($query2);
                    $row2 = mysql_fetch_assoc($lnk2);
			                    if(mysql_affected_rows()>0){	
					$outHtml .= '<td align="center"><a href="?pg=prodMgmtPg_det&cmd=charge_tDelete&charge_t_id='.$row['charge_t_id'].'"><img src="images/delete.PNG"  width="15%" height="15%"   border="0" title="حذف"></img></a></td>';}
		else{
						$outHtml .= '<td align="center"><a href="" onclick="Access();"><img src="images/delete.PNG"  width="15%" height="15%"   border="0" title="حذف"></img></a></td>';
						
					}
				$outHtml .= '</tr>
			';
		}
		$outHtml .= '<div> <button type="button" onclick=window.open("?pg=prodMgmtPg_det&cmd=regcharge_tFrm","_self")   value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF"> ايجاد نوع هزینه</button></div>
		';
		
    }else{
    	$outHtml .= '<button type="button" onclick=window.open("?pg=prodMgmtPg_det&cmd=regcharge_tFrm","_self")   value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF"> ايجاد نوع هزینه</button></div>
    	<tr class="rw1"><td colspan="10">هيچ اطلاعاتي موجود نيست</td></tr>';
    }
     $outHtml .= '</table>
</div><br>'.getNavBar_t_charge().' '.getRPPCombo_t_charge();
   
    return $outHtml;
		
}

function getNavBar_t_charge(){
	$out = '
		<table style="direction:ltr" >
			<tr>
			
	';
	//if($stNum>$_SESSION['pageCount']) $stNum=$_SESSION['pageCount']-5;
	
	$stNum = $_SESSION['crntPage']-5;
	if($stNum<1) $stNum=1;
	$out .= '
		<td><a href="?pg=prodMgmtPg_det&cmd=charge_type&cmd2=setPg&pgNum=1" ><img src="images/first.gif" title="ابتدا"></img></a></td>
		<td>&nbsp;&nbsp;</td>
		<td><a href="?pg=prodMgmtPg_det&cmd=charge_type&cmd2=setPg&pgNum='.((($_SESSION['crntPage']-1)<1) ? 1 : ($_SESSION['crntPage']-1)).'" ><img src="images/prev.gif" title="قبلي"></img></a></td>
		<td>&nbsp;&nbsp;</td>
	';
	$inx = 0;
	while(($inx<10) && (($stNum+$inx) <= $_SESSION['pageCount'])){
		$out .= '
			<td><a '.(($_SESSION['crntPage']==($stNum+$inx)) ? ' style="text-decoration:none; font-weight:bold;" ':'').' href="?pg=prodMgmtPg_det&cmd=charge_type&cmd2=setPg&pgNum='.($stNum+$inx).'" ><div style="background:#cccccc;">'.($stNum+$inx).'</div></a></td><td>&nbsp;</td>
		';
		
		$inx++;
	}
	$out .= '
		<td><a href="?pg=prodMgmtPg_det&cmd=charge_typecmd2=setPg&pgNum='.((($_SESSION['crntPage']+1)<=$_SESSION['pageCount']) ? ($_SESSION['crntPage']+1) : $_SESSION['pageCount']).'" ><img src="images/next.gif" title="بعدي"></img></a></td>
		<td>&nbsp;&nbsp;</td>
		<td><a href="?pg=prodMgmtPg_det&cmd=charge_type&cmd2=setPg&pgNum='.$_SESSION['pageCount'].'" ><img src="images/last.gif" title="انتها"></img></a></td>
	';
	
	$out .= '
			</tr>
		</table>
	';	
	return $out;
}

function getRPPCombo_t_charge(){
	$out = '<span style="align:center;">
	
		<select onchange="window.open(\'?pg=prodMgmtPg_det&cmd=charge_type&cmd2=setRPP&rPP=\'+this.value, \'_self\')" style="width:50px;" >
			<option value="1" '.(($_SESSION['rPP']==1)?' selected="selected" ':'').' > 1 </option>
			<option value="5" '.(($_SESSION['rPP']==5)?' selected="selected" ':'').' > 5 </option>
			<option value="10" '.(($_SESSION['rPP']==10)?' selected="selected" ':'').' > 10 </option>
			<option value="25" '.(($_SESSION['rPP']==25)?' selected="selected" ':'').' > 25 </option>
			<option value="50" '.(($_SESSION['rPP']==30)?' selected="selected" ':'').' > 50 </option>
			<option value="100" '.(($_SESSION['rPP']==100)?' selected="selected" ':'').' > 100 </option>
			<option value="1000000" '.(($_SESSION['rPP']==0)?' selected="selected" ':'').' > all </option>
		</select>
		
	<span style="color:blue;"><b>پاسخ در صفحه</b></span>
	</div>';
	return $out;
}
function regcus_status_sFrm(){
	
	$_SESSION['cus_status_s_save']=1;
	
	?>
	
<form method="post" action="" id="commentForm">
			<input type="hidden" name="pg" value="prodMgmtPg_det">   
			<input type="hidden" name="cmd" value="regcus_status_s">	
		<table  align="center" class="nasi" style="font-weight:bold;" >
		  	<tr style="background-color:<?php echo $_SESSION['htablecolor'] ?>;font-weight:bold;">
			       <td colspan="8"  style="height: 50px;vertical-align:middle;"  ><font size="5">نوع سهميه</font></td>
	       </tr>
	       <tr>
	            <td colspan="8"><hr style="color:<?php echo $_SESSION['htablecolor'] ?>;height:40%;"></hr></td>
	       </tr>
	      	<tr>
		      	 <td>&nbsp;</td>
		         <td colspan="2"><center>نام سهميه  </center></td>
			     <td><input name="cus_status_s_name" id="cus_status_s_name" type="text" /></td>		       
	             <td colspan="2"><button  type="submit"  value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF">ذخیره</button></td>
			     <td colspan="2">&nbsp;</td>	  
	        </tr>
	          <tr>   
	                  
			   <td colspan="5">&nbsp;</td>
			      
	      	</tr>
	      	
	    </table>
	
	</form>

	<?php
	
}

function charge_tEditFrm(){
	
$charge_t_id  = isset($_REQUEST['charge_t_id']) ? (int)($_REQUEST['charge_t_id']) : 0;

	if($charge_t_id<1) die('Invalid id!');
	
	$lnk = mysql_query("SELECT * FROM   dm_type_charge   WHERE  charge_t_id=".$charge_t_id);
	
		$row = mysql_fetch_assoc($lnk);
	
		?>

	<form method="post" action="" >
	   	
		<input type="hidden" name="pg" value="prodMgmtPg_det">   
		<input type="hidden" name="cmd" value="charge_t_update">  
		<input type="hidden" name="charge_t_id" id="charge_t_id"  value="<?php echo $charge_t_id; ?>">   
		<table  align="center"  class="nasi"   >
		  	<tr style="background-color:<?php echo $_SESSION['htablecolor'] ?>;" >
		       <td colspan="8"  style="height: 50px;vertical-align:middle;"  ><b><font size="5">  نوع هزینه</font></b></td>
	        </tr>
	        <tr>
	           <td colspan="8"><hr style="color:<?php echo $_SESSION['htablecolor'] ?>;height:40%;"></hr></td>
	       </tr>
	      	<tr>
		       	<td ><center>نوع هزینه </center> </td>
		        <td><input name="charge_t_name" id="charge_t_name" type="text" value="<?php echo $row['charge_t_name']; ?>" /></td>
                  <td colspan="2"><button  type="submit"  value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF">ذخیره</button></td>
			     <td colspan="2">&nbsp;</td>	  
	        </tr>
	          <tr>   
	                  
			   <td colspan="5">&nbsp;</td>
			       
	      	</tr>
	      		  
	    </table>
	</form>
	
	<?php	
}
	function Create_docFrm(){
			
	$lnk = mysql_query("SELECT * FROM  dm_acc_doc  WHERE ac_status=". 1 ." " );
	
		$row = mysql_fetch_assoc($lnk);
	?>
	
		<form method="post" action="" >	   	
		<input type="hidden" name="pg" value="prodMgmtPg_det">   
		<input type="hidden" name="cmd" value="docFrmEdit">   
		<table  align="center" class="nasi" width=50%>
		  	<tr style="background-color:<?php echo $_SESSION['htablecolor'] ?>;">
			     <td colspan="6"  style="height: 50px;vertical-align:middle;"  ><font size="5">جدول تنظيمات سند</font></td>
	        </tr>
	         <tr>
	            <td colspan="8"><hr style="color:<?php echo $_SESSION['htablecolor'] ?>;height:40%;"></hr></td>
	        </tr>	       
	      	<tr>
		       	<td ><center>كد حساب بدهكار  :</center> </td>
		        <td style="color:blue;" ><center><?php echo $row['ac_code_p_bed'] ?></center></td>
		     </tr>
		     <tr>
				<td ><center>عنوان حساب بدهكار :</center></td>
                <td style="color:blue;" ><center><?php echo  $row['ac_topic_p_bed'] ?></center></td>
             </tr>
             <tr>	
	            <td ><center>كد حساب بستانكار:</center> </td>
                <td style="color:blue;" ><center><?php echo $row['ac_code_p_bes'] ?></center></td>
             </tr>
             <tr>
                <td ><center>عنوان حساب بستانكار:</center> </td>
                <td style="color:blue;" ><center><?php echo $row['ac_topic_p_bes'] ?></center></td>
   	        </tr>	       	   	      		      	      	
			 <tr>				      
				  <td>&nbsp;&nbsp; </td> 
			      <td colspan="3"> <button name="subject" type="submit"   value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF" > ویرایش</button></td>                       
				  <td colspan="2">&nbsp;&nbsp;&nbsp;</td>        
	      	</tr>
	    </table>
	</form>
	
	<?php
	}
	function  docFrmEdit(){
	$lnk = mysql_query("SELECT * FROM  dm_acc_doc  WHERE ac_status=". 1);
	
		$row = mysql_fetch_assoc($lnk);
	?>
	
		<form method="post" action="" >
	   	
		<input type="hidden" name="pg" value="prodMgmtPg_det">   
		<input type="hidden" name="cmd" value="UpDoc">   
		<table  align="center" class="nasi" >
		  	<tr style="background-color:<?php echo $_SESSION['htablecolor'] ?>;">
			     <td colspan="6"  style="height: 50px;vertical-align:middle;"  ><font size="5">جدول تنظيمات سند</font></td>
	        </tr>
	         <tr>
	            <td colspan="8"><hr style="color:<?php echo $_SESSION['htablecolor'] ?>;height:40%;"></hr></td>
	        </tr>
	        
	      	<tr>
		       	 <td ><center>كد حساب بدهكار :</center> </td>
		       	 <td><input name="ac_code_p_bed" id="ac_code_p_bed" type="text" value="<?php echo $row['ac_code_p_bed']; ?>" /></td>
		   </tr>
		   <tr>
		     
				 <td ><center>عنوان حساب بدهكار :</center></td>
		       	 <td><input name="ac_topic_p_bed" id="ac_topic_p_bed" type="text" value="<?php echo $row['ac_topic_p_bed']; ?>" /></td>		       	 
		    </tr>
		    <tr>
	              <td ><center>كد حساب بستانكار:</center> </td>
		          <td><input name="ac_code_p_bes" id="ac_code_p_bes" type="text" value="<?php echo $row['ac_code_p_bes']; ?>" /></td>
		    </tr>
		    <tr>
		       	  <td ><center>عنوان حساب بستانكار:</center> </td>
		       	  <td><input name="ac_topic_p_bes" id="ac_topic_p_bes" type="text" value="<?php echo $row['ac_topic_p_bes']; ?>" /></td>
   	        </tr>	       
	      	<tr>		   			 		 				      
		      	 <td colspan="3"> <button name="subject" type="submit"   value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF" > ویرایش</button></td>                       
			     <td colspan="2">&nbsp;&nbsp;&nbsp;</td>				        
	      	</tr>
	    </table>
	</form>
	
	<?php  
}
function UpDoc(){
//		$signature_id = isset($_REQUEST['signature_id']) ? (int)($_REQUEST['signature_id']) : 0;
//	if($signature_id<1) die('Inv Id');

	$ac_code_p_bed = isset($_REQUEST['ac_code_p_bed']) ? $_REQUEST['ac_code_p_bed'] : '';
	$ac_topic_p_bed= isset($_REQUEST['ac_topic_p_bed']) ? ($_REQUEST['ac_topic_p_bed']) : '';
	$ac_code_p_bes = isset($_REQUEST['ac_code_p_bes']) ? $_REQUEST['ac_code_p_bes'] : '';
	$ac_topic_p_bes= isset($_REQUEST['ac_topic_p_bes']) ? ($_REQUEST['ac_topic_p_bes']) : '';
		
	$query = "
		UPDATE  dm_acc_doc 
		SET 
			`ac_status` = '". 0 ."'
		
WHERE 
		  `ac_status`  = '". 1 ."'	"		
		
	;
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
//	print $query;
	$query = array(
		'ac_code_p_bed' => $ac_code_p_bed ,
		'ac_topic_p_bed' => $ac_topic_p_bed,
		'ac_code_p_bes' => $ac_code_p_bes,
		'ac_topic_p_bes' => $ac_topic_p_bes,		
		'ac_status' => 1,	   
		'ac_reg_date' => gmdate('Y-m-d'),
		
	);

	$query = inserterQMaker('dm_acc_doc', $query);	
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
	 	
 }
 function createFileFrm(){
 	?>	
 
    <style type="text/css">
        *
        {
          
        }
        body
        {
            direction: rtl;
          
        }
        p
        {
            padding: 25px;
            margin: 25px auto;
            width: 450px;
        }
        .ui-widget-header
        {
            text-align: center;
            font-weight: normal;
        }
        .ui-state-active
        {
            display: block;
            padding: 3px;
            text-align: center;
        }
    </style>
	<link type="text/css" href="lib/styles/ui.core.css" rel="stylesheet" />
    <link type="text/css" href="lib/styles/ui.theme.css" rel="stylesheet" />
    <link type="text/css" href="lib/styles/ui.datepicker.css" rel="stylesheet" />
	 <script type="text/javascript">
	    $(function() {
	    
	        //-----------------------------------
	        // انتخاب با کليک بر روي عکس
	        $("#doc_date").datepicker({
	            showOn: 'button',
	            buttonImage: 'lib/styles/images/calendar.png',
	            buttonImageOnly: true
	        });
	    })
	    </script>
	    <?php 
 	
 $out='	<form method="get" action="lib/php/downfile.php" >
			<input type="hidden" name="pg" value="prodMgmtPg_det">   
			<input type="hidden" name="cmd" value="createFile">
			<input type="hidden" name="id_province" value="'. $_SESSION['dm_user_profile']['u_province_id'].'">
			<input type="hidden" name="id_year" value="'. $_SESSION['dm_user_profile']['u_year_id'].'">
			<table  align="center" cellpadding="0" cellspacing="0" class="nasi" >
					 <tr style="background-color:'.  $_SESSION['htablecolor'] .';">
							 <td colspan="6"  style="height: 50px;vertical-align:middle;"  align="center"><b><font size="5">ايجاد فايل سند</font></b></td>
					 </tr>
					 <tr>
						    <td>&nbsp;</td>
					     	<td style="height: 50px;vertical-align:middle;font-weight:bold;" >تاريخ روز مورد نظر را وارد كنيد:</td>
					        <td style="height: 50px;vertical-align:middle;" align="center" ><input name="doc_date" id="doc_date" type="text"   ></td>		        
					 </tr>
					 <tr>
						     <td colspan="2"> <button name="subject" type="submit" value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF" > ذخيره</button></td>
						     <td colspan="2">&nbsp;</td>			          
					</tr>
		</form>
		    </table>';
 	
return $out;	
	}
	function createFileFrmjari(){
 	?>	
 
    <style type="text/css">
        *
        {
          
        }
        body
        {
            direction: rtl;
          
        }
        p
        {
            padding: 25px;
            margin: 25px auto;
            width: 450px;
        }
        .ui-widget-header
        {
            text-align: center;
            font-weight: normal;
        }
        .ui-state-active
        {
            display: block;
            padding: 3px;
            text-align: center;
        }
    </style>
	<link type="text/css" href="lib/styles/ui.core.css" rel="stylesheet" />
    <link type="text/css" href="lib/styles/ui.theme.css" rel="stylesheet" />
    <link type="text/css" href="lib/styles/ui.datepicker.css" rel="stylesheet" />
	 <script type="text/javascript">
	    $(function() {
	    
	        //-----------------------------------
	        // انتخاب با کليک بر روي عکس
	        $("#doc_date").datepicker({
	            showOn: 'button',
	            buttonImage: 'lib/styles/images/calendar.png',
	            buttonImageOnly: true
	        });
	    })
	    </script>
	    <?php 
 	
 $out='	<form method="get" action="lib/php/jarisanad.php" >
			<input type="hidden" name="pg" value="prodMgmtPg_det">   
			<input type="hidden" name="cmd" value="createFile">
			<input type="hidden" name="id_province" value="'. $_SESSION['dm_user_profile']['u_province_id'].'">
			<input type="hidden" name="id_year" value="'. $_SESSION['dm_user_profile']['u_year_id'].'">
			<table  align="center" cellpadding="0" cellspacing="0" class="nasi" >
					 <tr style="background-color:'.  $_SESSION['htablecolor'] .';">
							 <td colspan="6"  style="height: 50px;vertical-align:middle;"  align="center"><b><font size="5">ايجاد فايل سند</font></b></td>
					 </tr>
					 <tr>
						    <td>&nbsp;</td>
					     	<td style="height: 50px;vertical-align:middle;font-weight:bold;" >تاريخ روز مورد نظر را وارد كنيد:</td>
					        <td style="height: 50px;vertical-align:middle;" align="center" ><input name="doc_date" id="doc_date" type="text"   ></td>		        
					 </tr>
					 <tr>
						     <td colspan="2"> <button name="subject" type="submit" value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF" > ذخيره</button></td>
						     <td colspan="2">&nbsp;</td>			          
					</tr>
		</form>
		    </table>';
 	
return $out;	
	}
	function createFileFrm1(){
 	?>	
 
    <style type="text/css">
        *
        {
          
        }
        body
        {
            direction: rtl;
          
        }
        p
        {
            padding: 25px;
            margin: 25px auto;
            width: 450px;
        }
        .ui-widget-header
        {
            text-align: center;
            font-weight: normal;
        }
        .ui-state-active
        {
            display: block;
            padding: 3px;
            text-align: center;
        }
    </style>
	<link type="text/css" href="lib/styles/ui.core.css" rel="stylesheet" />
    <link type="text/css" href="lib/styles/ui.theme.css" rel="stylesheet" />
    <link type="text/css" href="lib/styles/ui.datepicker.css" rel="stylesheet" />
	 <script type="text/javascript">
	    $(function() {
	    
	        //-----------------------------------
	        // انتخاب با کليک بر روي عکس
	        $("#doc_date").datepicker({
	            showOn: 'button',
	            buttonImage: 'lib/styles/images/calendar.png',
	            buttonImageOnly: true
	        });
	    })
	    </script>
	    <?php 
 	
 $out='	<form method="get" action="lib/php/downfilebebtal.php" >
			<input type="hidden" name="pg" value="prodMgmtPg_det">   
			<input type="hidden" name="cmd" value="createFile">
			<input type="hidden" name="id_province" value="'. $_SESSION['dm_user_profile']['u_province_id'].'">
			<input type="hidden" name="id_year" value="'. $_SESSION['dm_user_profile']['u_year_id'].'">
			<table  align="center" cellpadding="0" cellspacing="0" class="nasi" >
					 <tr style="background-color:'.  $_SESSION['htablecolor'] .';">
							 <td colspan="6"  style="height: 50px;vertical-align:middle;"  align="center"><b><font size="5">ايجاد فايل سند(بدون ابطالی)</font></b></td>
					 </tr>
					 <tr>
						    <td>&nbsp;</td>
					     	<td style="height: 50px;vertical-align:middle;font-weight:bold;" >تاريخ روز مورد نظر را وارد كنيد:</td>
					        <td style="height: 50px;vertical-align:middle;" align="center" ><input name="doc_date" id="doc_date" type="text"   ></td>		        
					 </tr>
					 <tr>
						     <td colspan="2"> <button name="subject" type="submit" value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF" > ذخيره</button></td>
						     <td colspan="2">&nbsp;</td>			          
					</tr>
		</form>
		    </table>';
 	
return $out;	
	}
	function createFileFrm2(){
 	?>	
 
    <style type="text/css">
        *
        {
          
        }
        body
        {
            direction: rtl;
          
        }
        p
        {
            padding: 25px;
            margin: 25px auto;
            width: 450px;
        }
        .ui-widget-header
        {
            text-align: center;
            font-weight: normal;
        }
        .ui-state-active
        {
            display: block;
            padding: 3px;
            text-align: center;
        }
    </style>
	<link type="text/css" href="lib/styles/ui.core.css" rel="stylesheet" />
    <link type="text/css" href="lib/styles/ui.theme.css" rel="stylesheet" />
    <link type="text/css" href="lib/styles/ui.datepicker.css" rel="stylesheet" />
	 <script type="text/javascript">
	    $(function() {
	    
	        //-----------------------------------
	        // انتخاب با کليک بر روي عکس
	        $("#doc_date").datepicker({
	            showOn: 'button',
	            buttonImage: 'lib/styles/images/calendar.png',
	            buttonImageOnly: true
	        });
	    })
	    </script>
	    <?php 
 	
 $out='	<form method="get" action="lib/php/downfileebtal.php" >
			<input type="hidden" name="pg" value="prodMgmtPg_det">   
			<input type="hidden" name="cmd" value="createFile">
			<input type="hidden" name="id_province" value="'. $_SESSION['dm_user_profile']['u_province_id'].'">
			<input type="hidden" name="id_year" value="'. $_SESSION['dm_user_profile']['u_year_id'].'">
			<table  align="center" cellpadding="0" cellspacing="0" class="nasi" >
					 <tr style="background-color:'.  $_SESSION['htablecolor'] .';">
							 <td colspan="6"  style="height: 50px;vertical-align:middle;"  align="center"><b><font size="5">ايجاد فايل سند(فقط ابطالی)</font></b></td>
					 </tr>
					 <tr>
						    <td>&nbsp;</td>
					     	<td style="height: 50px;vertical-align:middle;font-weight:bold;" >تاريخ روز مورد نظر را وارد كنيد:</td>
					        <td style="height: 50px;vertical-align:middle;" align="center" ><input name="doc_date" id="doc_date" type="text"   ></td>		        
					 </tr>
					 <tr>
						     <td colspan="2"> <button name="subject" type="submit" value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF" > ذخيره</button></td>
						     <td colspan="2">&nbsp;</td>			          
					</tr>
		</form>
		    </table>';
 	
return $out;	
	}
	function createFileFrmstore(){
		?>	
 
    <style type="text/css">
        *
        {
          
        }
        body
        {
            direction: rtl;
          
        }
        p
        {
            padding: 25px;
            margin: 25px auto;
            width: 450px;
        }
        .ui-widget-header
        {
            text-align: center;
            font-weight: normal;
        }
        .ui-state-active
        {
            display: block;
            padding: 3px;
            text-align: center;
        }
    </style>
	<link type="text/css" href="lib/styles/ui.core.css" rel="stylesheet" />
    <link type="text/css" href="lib/styles/ui.theme.css" rel="stylesheet" />
    <link type="text/css" href="lib/styles/ui.datepicker.css" rel="stylesheet" />
	 <script type="text/javascript">
	    $(function() {
	    
	        //-----------------------------------
	        // انتخاب با کليک بر روي عکس
	        $("#doc_date").datepicker({
	            showOn: 'button',
	            buttonImage: 'lib/styles/images/calendar.png',
	            buttonImageOnly: true
	        });
	    })
	    $(function() {
	    
	        //-----------------------------------
	        // انتخاب با کليک بر روي عکس
	        $("#doc_date_l").datepicker({
	            showOn: 'button',
	            buttonImage: 'lib/styles/images/calendar.png',
	            buttonImageOnly: true
	        });
	    })
	    </script>
	    <?php 
 	
 $out='	<form method="get" action="lib/php/downfilestore.php" >
			<input type="hidden" name="pg" value="prodMgmtPg_det">   
			<input type="hidden" name="cmd" value="createFile">
			<input type="hidden" name="id_province" value="'. $_SESSION['dm_user_profile']['u_province_id'].'">
			<table  align="center" cellpadding="0" cellspacing="0" class="nasi" >
					 <tr style="background-color:'.  $_SESSION['htablecolor'] .';">
							 <td colspan="6"  style="height: 50px;vertical-align:middle;"  align="center"><b><font size="5">ايجاد فايل برای انبار</font></b></td>
					 </tr>
					 <tr>
						    <td>&nbsp;</td>
					     	<td style="height: 50px;vertical-align:middle;font-weight:bold;" >ازتاريخ:</td>
					        <td style="height: 50px;vertical-align:middle;" align="center" ><input name="doc_date" id="doc_date" type="text"   ></td>
					        <td style="height: 50px;vertical-align:middle;font-weight:bold;" >تا تاريخ:</td>
					        <td style="height: 50px;vertical-align:middle;" align="center" ><input name="doc_date_l"   id="doc_date_l" type="text"   ></td>		        
					 </tr>
					 <tr>
						     <td colspan="5" align="center"> <button name="subject" type="submit" value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF" > ذخيره</button></td>
						     <td colspan="2">&nbsp;</td>			          
					</tr>
		 </form>
		    </table>';
 	
return $out;	
		
	}
	function createFileFrmfrig(){
 	?>	
 
    <style type="text/css">
        *
        {
          
        }
        body
        {
            direction: rtl;
          
        }
        p
        {
            padding: 25px;
            margin: 25px auto;
            width: 450px;
        }
        .ui-widget-header
        {
            text-align: center;
            font-weight: normal;
        }
        .ui-state-active
        {
            display: block;
            padding: 3px;
            text-align: center;
        }
    </style>
	<link type="text/css" href="lib/styles/ui.core.css" rel="stylesheet" />
    <link type="text/css" href="lib/styles/ui.theme.css" rel="stylesheet" />
    <link type="text/css" href="lib/styles/ui.datepicker.css" rel="stylesheet" />
	 <script type="text/javascript">
	    $(function() {
	    
	        //-----------------------------------
	        // انتخاب با کليک بر روي عکس
	        $("#doc_date").datepicker({
	            showOn: 'button',
	            buttonImage: 'lib/styles/images/calendar.png',
	            buttonImageOnly: true
	        });
	    })
	    $(function() {
	    
	        //-----------------------------------
	        // انتخاب با کليک بر روي عکس
	        $("#doc_date_l").datepicker({
	            showOn: 'button',
	            buttonImage: 'lib/styles/images/calendar.png',
	            buttonImageOnly: true
	        });
	    })
	    </script>
	    <?php 
 	
 $out='	<form method="get" action="lib/php/downfilefrig.php" >
			<input type="hidden" name="pg" value="prodMgmtPg_det">   
			<input type="hidden" name="cmd" value="createFile">
			<input type="hidden" name="id_province" value="'. $_SESSION['dm_user_profile']['u_province_id'].'">
			<table  align="center" cellpadding="0" cellspacing="0" class="nasi" >
					 <tr style="background-color:'.  $_SESSION['htablecolor'] .';">
							 <td colspan="6"  style="height: 50px;vertical-align:middle;"  align="center"><b><font size="5">ايجاد فايل برای سردخانه</font></b></td>
					 </tr>
					 <tr>
						    <td>&nbsp;</td>
					     	<td style="height: 50px;vertical-align:middle;font-weight:bold;" >ازتاريخ:</td>
					        <td style="height: 50px;vertical-align:middle;" align="center" ><input name="doc_date" id="doc_date" type="text"   ></td>
					        <td style="height: 50px;vertical-align:middle;font-weight:bold;" >تا تاريخ:</td>
					        <td style="height: 50px;vertical-align:middle;" align="center" ><input name="doc_date_l"   id="doc_date_l" type="text"   ></td>		        
					 </tr>
					 <tr>
						     <td colspan="5" align="center"> <button name="subject" type="submit" value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF" > ذخيره</button></td>
						     <td colspan="2">&nbsp;</td>			          
					</tr>
		 </form>
		    </table>';
 	
return $out;	
	}
	function createFileFrmfrigeb(){
		
 	?>	
 
    <style type="text/css">
        *
        {
          
        }
        body
        {
            direction: rtl;
          
        }
        p
        {
            padding: 25px;
            margin: 25px auto;
            width: 450px;
        }
        .ui-widget-header
        {
            text-align: center;
            font-weight: normal;
        }
        .ui-state-active
        {
            display: block;
            padding: 3px;
            text-align: center;
        }
    </style>
	<link type="text/css" href="lib/styles/ui.core.css" rel="stylesheet" />
    <link type="text/css" href="lib/styles/ui.theme.css" rel="stylesheet" />
    <link type="text/css" href="lib/styles/ui.datepicker.css" rel="stylesheet" />
	 <script type="text/javascript">
	    $(function() {
	    
	        //-----------------------------------
	        // انتخاب با کليک بر روي عکس
	        $("#doc_date").datepicker({
	            showOn: 'button',
	            buttonImage: 'lib/styles/images/calendar.png',
	            buttonImageOnly: true
	        });
	    })
	    $(function() {
	    
	        //-----------------------------------
	        // انتخاب با کليک بر روي عکس
	        $("#doc_date_l").datepicker({
	            showOn: 'button',
	            buttonImage: 'lib/styles/images/calendar.png',
	            buttonImageOnly: true
	        });
	    })
	    </script>
	    <?php 
 	
 $out='	<form method="get" action="lib/php/downfilefrig-eb.php" >
			<input type="hidden" name="pg" value="prodMgmtPg_det">   
			<input type="hidden" name="cmd" value="createFile">
			<input type="hidden" name="id_province" value="'. $_SESSION['dm_user_profile']['u_province_id'].'">
			<table  align="center" cellpadding="0" cellspacing="0" class="nasi" >
					 <tr style="background-color:'.  $_SESSION['htablecolor'] .';">
							 <td colspan="6"  style="height: 50px;vertical-align:middle;"  align="center"><b><font size="5">ايجاد فايل برای سردخانه - حواله های ابطال شده</font></b></td>
					 </tr>
					 <tr>
						    <td>&nbsp;</td>
					     	<td style="height: 50px;vertical-align:middle;font-weight:bold;" >ازتاريخ:</td>
					        <td style="height: 50px;vertical-align:middle;" align="center" ><input name="doc_date" id="doc_date" type="text"   ></td>
					        <td style="height: 50px;vertical-align:middle;font-weight:bold;" >تا تاريخ:</td>
					        <td style="height: 50px;vertical-align:middle;" align="center" ><input name="doc_date_l"   id="doc_date_l" type="text"   ></td>		        
					 </tr>
					 <tr>
						     <td colspan="5" align="center"> <button name="subject" type="submit" value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF" > ذخيره</button></td>
						     <td colspan="2">&nbsp;</td>			          
					</tr>
		 </form>
		    </table>';
 	
return $out;	
	}
function createFilefrig(){
		
 $doc_date = isset($_REQUEST['doc_date']) ? $_REQUEST['doc_date'] : '';
 //$doc_date=str_replace("/","",$doc_date);
		$jdate=$doc_date;
		$jdate .= '/\/';
		list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
		list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
		$doc_date = $gyear."-".$gmonth."-".$gday;
	
		$day_number = jdate('j');
	    $month_number = jdate('n');
	    $year_number = jdate('y');
	    $day_name = jdate('l');
	    $out='';						
	    $queryh = "
				 SELECT *  FROM dm_havale 			 
				 WHERE 
				 		h_reg_date = '".$doc_date."' 
				 AND 
					    h_id_province='".$_SESSION['dm_user_profile']['u_province_id']."'
			    	AND
				       h_status=". 0 ."
                  AND
                     h_id_year=".$_SESSION['dm_user_profile']['u_year_id']."
				       
				       ";	    
					    					  									
    			$lnkh = mysql_query($queryh);
				sqlErr('for bank doc');
				
//while asli
				while($rowh = mysql_fetch_assoc($lnkh))
				{                																		               
					                $pf_code=$rowh['h_pf_code'];						                				                 
						    		$customer_code=$rowh['h_customer_code'];					                
					                $p_code = $rowh['h_p_code'];
					                $queryph = "
												 SELECT *  FROM dm_pish_havale 			 
												 WHERE 
												 		ph_code = '".$pf_code."' 
												 AND 
													    ph_id_province='".$_SESSION['dm_user_profile']['u_province_id']."'
													    
												 AND
			                                    	ph_id_year=".$_SESSION['dm_user_profile']['u_year_id']."  
													    ";	
															
    		                    	$lnkph = mysql_query($queryph);
    		                    	$rowph = mysql_fetch_assoc($lnkph);
					                $querydpf = "
												 SELECT *  FROM dm_pf_document 			 
												 WHERE 
												 		dpf_pf_code = '".$pf_code."' 
												 AND 
													    dpf_id_province='".$_SESSION['dm_user_profile']['u_province_id']."'";	
															
    		                    	$lnkdpf = mysql_query($querydpf);  
  //mishe bedstankar baraye kala  
                                    $queryac = "
												 SELECT *  FROM dm_acc_doc 			 
												 WHERE 
												 		ac_status = '". 1 ."' ";													
															
    		                    	$lnkac = mysql_query($queryac); 
    		                    	$rowac = mysql_fetch_assoc($lnkac);
    		                    	$rowac = mysql_fetch_assoc($lnkac);
    		                    	$code = str_replace( "c", $rowac['ac_code_p_bes'], $code ); 
	    		                    $code = str_replace( "g", $rowh['h_p_code'], $code );
	    		                    $code = str_replace( "a", $rowph['ph_operation_id'], $code );     
                                    $out.='0000;'. $year_number .''.$month_number.';'. $year_number .''.$month_number.''.$day_number.';'.$code.';'.$dpf_price.';'. 0 .';'. 1 .';'.$rowac['ac_code_p_bes_dis'].';'.$rowph['ph_operation_id'].';'. 0 .';'. $rowh['h_price_code'] .';'. $rowh['h_customer_code'] .'';    		                   	
	    		                    $out.='<br>';    		                    	
//while baraye poli ke rikhtan   		                   	
    		                   	while($rowdpf = mysql_fetch_assoc($lnkdpf))
    		                   	{
	    		                    $d_id =	$rowdpf['dfp_d_id'];
	    		                    $dpf_price   = $rowdpf['dfp_d_id'];
	    		                    	    		                    	    		                    
	    		                     $queryd = "
											 SELECT *  FROM dm_document 			 
											 WHERE 
											 		d_id = '".$d_id."' ";															
	    		                   	$lnkd= mysql_query($queryd);
	    		                   	$rowd = mysql_fetch_assoc($lnkd);  
	    		                    $code =$rowd['d_ac_bed'];    
	    		                    $code = str_replace( "c", $rowh['h_customer_code'], $code ); 
	    		                    $code = str_replace( "g", $rowh['h_p_code'], $code );
	    		                    $code = str_replace( "a", $rowph['ph_operation_id'], $code );     
  //mishe bedehkar baraye bank  		                   	
	    		                	
	               			       $out.='0000;'. $year_number .''.$month_number.';'. $year_number .''.$month_number.''.$day_number.';'.$code.';'.$dpf_price.';'. 0 .';'. 2 .';'.$rowd['d_ac_bed_dis'].';'.$rowph['ph_operation_id'].';'. 0 .';'. $rowh['h_price_code'] .';'. $rowh['h_customer_code'] .'';    		                   	
	    		                   $out.='<br>';
 		                   
    		                   	}	
 //end of while avali  baraye havale
		    	}
 //begin while for ebtal koli
  $queryh = "
				 SELECT *  FROM dm_havale 			 
				 WHERE 
				 		h_reg_date = '".$doc_date."' 
				 AND 
					    h_id_province='".$_SESSION['dm_user_profile']['u_province_id']."'
				  AND
				       h_status=". 1 ."	 

				  AND 
				       h_id_year=".$_SESSION['dm_user_profile']['u_year_id']."
				       ";	    
					    					  									
    			$lnkh = mysql_query($queryh);
				sqlErr('for bank doc');
//while asli
				while($rowh = mysql_fetch_assoc($lnkh))
				{                																		               
					                $pf_code=$rowh['h_pf_code'];						                				                 
						    		$customer_code=$rowh['h_customer_code'];					                
					                $p_code = $rowh['h_p_code'];
					                $queryph = "
												 SELECT *  FROM dm_pish_havale 			 
												 WHERE 
												 		ph_code = '".$pf_code."' 
												 AND 
													    ph_id_province='".$_SESSION['dm_user_profile']['u_province_id']."'";	
															
    		                    	$lnkph = mysql_query($queryph);
    		                    	$rowph = mysql_fetch_assoc($lnkph);
					                $querydpf = "
												 SELECT *  FROM dm_pf_document 			 
												 WHERE 
												 		dpf_pf_code = '".$pf_code."' 
												 AND 
													    dpf_id_province='".$_SESSION['dm_user_profile']['u_province_id']."'";	
															
    		                    	$lnkdpf = mysql_query($querydpf);  
  //mishe bedehkar baraye kala  
                                    $queryac = "
												 SELECT *  FROM dm_acc_doc 			 
												 WHERE 
												 		ac_status = '". 1 ."' ";													
															
    		                    	$lnkac = mysql_query($queryac); 
    		                    	$rowac = mysql_fetch_assoc($lnkac);
    		                    	$rowac = mysql_fetch_assoc($lnkac);
    		                    	$code = str_replace( "c", $rowac['ac_code_p_bes'], $code ); 
	    		                    $code = str_replace( "g", $rowh['h_p_code'], $code );
	    		                    $code = str_replace( "a", $rowph['ph_operation_id'], $code );     
                                    $out.='0000;'. $year_number .''.$month_number.';'. $year_number .''.$month_number.''.$day_number.';'.$code.';'.$dpf_price.';'. 0 .';'. 1 .';'.$rowac['ac_code_p_bes_dis'].';'.$rowph['ph_operation_id'].';'. 0 .';'. $rowh['h_price_code'] .';'. $rowh['h_customer_code'] .'';    		                   	
	    		                    $out.='<br>';  
				}
//baraye ebtal joze	
					$queryh = "
							 SELECT *  FROM dm_havale 			 
							    WHERE 
									 h_reg_date = '".$doc_date."' 
								AND 
									 h_id_province='".$_SESSION['dm_user_profile']['u_province_id']."'
								AND
									 h_status=". 0 ."

							    AND
									  h_id_year=".$_SESSION['dm_user_profile']['u_year_id']."
									 ";	    
										    					  									
					    			$lnkh = mysql_query($queryh);
									sqlErr('for bank doc');
	while($rowh = mysql_fetch_assoc($lnkh))
				{   $h_id =$rowh['h_id'];
                         $queryeb = "
							 SELECT *  FROM dm_his_havale 			 
							    WHERE 
									 his_h_id = '".$h_id."'   ";
															 		    										    					  									
					    			$lnkeb = mysql_query($queryh);
									sqlErr('for bank doc');
					                $pf_code=$rowh['h_pf_code'];						                				                 
						    		$customer_code=$rowh['h_customer_code'];					                
					                $p_code = $rowh['h_p_code'];
					                $queryph = "
												 SELECT *  FROM dm_pish_havale 			 
												 WHERE 
												 		ph_code = '".$pf_code."' 
												 AND 
													    ph_id_province='".$_SESSION['dm_user_profile']['u_province_id']."'";	
															
    		                    	$lnkph = mysql_query($queryph);
    		                    	$rowph = mysql_fetch_assoc($lnkph);
					                $querydpf = "
												 SELECT *  FROM dm_pf_document 			 
												 WHERE 
												 		dpf_pf_code = '".$pf_code."' 
												 AND 
													    dpf_id_province='".$_SESSION['dm_user_profile']['u_province_id']."'";	
															
    		                    	$lnkdpf = mysql_query($querydpf);  
  //mishe bedehkar baraye kala  
                                    $queryac = "
												 SELECT *  FROM dm_acc_doc 			 
												 WHERE 
												 		ac_status = '". 1 ."' ";													
															
    		                    	$lnkac = mysql_query($queryac); 
    		                    	$rowac = mysql_fetch_assoc($lnkac);
    		                    	$rowac = mysql_fetch_assoc($lnkac);
    		                    	$code = str_replace( "c", $rowac['ac_code_p_bed'], $code ); 
	    		                    $code = str_replace( "g", $rowh['h_p_code'], $code );
	    		                    $code = str_replace( "a", $rowph['ph_operation_id'], $code );     
                                    $out.='0000;'. $year_number .''.$month_number.';'. $year_number .''.$month_number.''.$day_number.';'.$code.';'.$roweb['his_price_pre'].';'. 0 .';'. 1 .';'.$rowac['ac_code_p_bed_dis'].';'.$rowph['ph_operation_id'].';'. 0 .';'. $rowh['h_price_code'] .';'. $rowh['h_customer_code'] .'';    		                   	
	    		                    $out.='<br>';  
				}	
			
				
//
//								 $FileName = '\sl'. $year_number.'-'.$month_number .'-'.$day_number.'.CSV';
//
//								 						            $FileHandle = fopen($FileName, 'a+') or die("can't open file");
//
//
//								 						            
//								 						            fwrite($FileHandle, $out);	
//                $html='<a href="lib/php/downfile.php?doc_date='.  $doc_date .'" target="_blank">براي دانلود فايل فروش اينجا كليك كنيد</a>';	
                echo $html;		
	
	}
function changeProvinceFrm(){
	
	$query="SELECT * FROM  dm_province WHERE province_id=".$_SESSION['dm_user_profile']['u_province_id']."";
		$lnk = mysql_query($query );
		$row = mysql_fetch_assoc($lnk);
//		print $query;
	?>
		
	<form method="post" action="" >
			<input type="hidden" name="pg" value="prodMgmtPg_det">   
			<input type="hidden" name="cmd" value="changeProvince">   
		<table  align="center"  class="nasi"  width=50% >
		  	<tr style="background-color:<?php echo $_SESSION['htablecolor'] ?>;">
		       <td colspan="6"  style="height: 50px;vertical-align:middle;"  ><b><font size="5">تغيير استان پيش فرض</font></b></td>
	        </tr>
	        <tr>
	            <td colspan="8"><hr style="color:<?php echo $_SESSION['htablecolor'] ?>;height:40%;"></hr></td>
	       </tr>	
	        <tr>
		       	<td ><b>&nbsp; استان فعال: </b>  
			  <span style="color:blue;"><?php echo $row['province_name']?></span></td>
	
	        </tr>
	         <tr>
	            <td colspan="8"><hr style="color:<?php echo $_SESSION['htablecolor'] ?>;height:40%;"></hr></td>
	       </tr>
	        <tr>
		       	<td ><b>&nbsp;   نام استان انتخابي: </b>  
			   <?php echo getProvinceCombo('city_province'); ?></td>
				
	        </tr>
	      	<tr>
			     <td colspan="3"> <button name="subject" type="submit"   value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF"   > ذخيره</button></td>                       
			     <td colspan="2">&nbsp;&nbsp;&nbsp;</td>
				          
	      	</tr>
	    </table>
	</form> 
	    
	<?php
		
	}
	function createmojavezFrm()
	{
	  	$_SESSION['saveDoc']=1;
	$_SESSION['pardakhti']='';
	
	?>
	<link type="text/css" href="lib/styles/ui.core.css" rel="stylesheet" />
    <link type="text/css" href="lib/styles/ui.theme.css" rel="stylesheet" />
    <link type="text/css" href="lib/styles/ui.datepicker.css" rel="stylesheet" />
	<script type="text/javascript">
	
			$(function() {
			    
		        //-----------------------------------
		        // انتخاب با کليک بر روي عکس
		        $("#phm_date_f").datepicker({
		            showOn: 'button',
		            buttonImage: 'lib/styles/images/calendar.png',
		            buttonImageOnly: true
		        });
		    })
		$(function() {
		    
		        //-----------------------------------
		        // انتخاب با کليک بر روي عکس
		        $("#phm_date_l").datepicker({
		            showOn: 'button',
		            buttonImage: 'lib/styles/images/calendar.png',
		            buttonImageOnly: true
		        });
		    })
		    
		    
	function validateAndSaveDoc(){
		
	  if(fObj('phm_mojavez').value==''){
			
			alert('لطفا شماره مجوز را وارد کنيد');
			return;
		}
		if(fObj('phm_op_id').value==-2){
		
			      if(fObj('phm_op_id').value==-2){
				
				alert('لطفا نوع عمليات را وارد کنيد');
				return;
			}
		      if(fObj('phm_date_f').value==''){
					
					alert('لطفا تاريخ شروع را وارد نماييد');
					return;
				}
		      if(fObj('phm_date_l').value==''){
					
					alert('لطفا تاريخ پايان را وارد نماييد');
					return;
				} 
		      if(fObj('phm_type_id').value==''){
					
					alert('لطفا نوع را انتخاب کنید');
					return;
				}  
		      if(fObj('phm_amount').value==''){
					
					alert('مقدارمجاز را وارد کنید');
					return;
				}  
		}

		insertop_mojavez();
	   
//	   if($_SESSION['checkCodeDoc']==0){
//		   window.open('?pg=havaleMgmtPg&cmd=regDocument&d_code='+fObj('d_code').value+'&d_accountNum='+fObj('d_accountNum').value+'&d_branch='
//		   +fObj('d_branch').value+'&d_fluentAccount='+fObj('d_fluentAccount').value , '_self');
//	   }

	}
  </script>


		<table  align="center"  class="nasi"  width="50%" style="font-weight:bold;" >
		  	<tr style="background-color:<?php echo $_SESSION['htablecolor'] ?>;">
		        <td colspan="6"  style="height: 50px;vertical-align:middle;"  ><b><font size="5">ایجاد مجوز جدید برای کل استانها</font></b></td>
	        </tr>
	     
	      	<tr >
		        <td  align="center"><center>شماره مجوز </center> </td>
		        <td><input name="phm_mojavez" id="phm_mojavez"  type="text" class="chk" /></td>
		        <td ><center> نوع عمليات</center> </td>
		        <td>
			  		<?php echo getbankTypesComboBox('phm_op_id')?>
				</td> 
	        </tr>
	        <tr>
		       <td>تاريخ شروع</td>
		       <td><input name="phm_date_f"  id="phm_date_f" type="text" /></td>
		       <td>تاريخ پايان:</td>
		       <td><input name="phm_date_l"  id="phm_date_l" type="text" /></td>
			</tr>
            <tr>
		       <td>دسته</td>
		       <td><?php echo getCategoryTypesComboBoxrr('phm_type_id')?></td>
		       <td>نوع</td>
		       <td>
			  		<?php echo getTypesComboBox('p_type')?>
				</td>
			</tr>
	      	<tr>
			     <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>      	
			     <td colspan="3"><button name="button" type="button" value="CSS" onclick="validateAndSaveDoc();" class="button blue skew" style="font-size:10px; color:#FFFFFF" > ذخيره</button></td>
			     <td colspan="2">&nbsp;&nbsp;&nbsp;</td>
	      	</tr>
	      	<tr >
		        <td  align="center"><center>مقدارمجاز </center> </td>
		        <td><input name="phm_amount" id="phm_amount"  type="text" class="chk" /></td>
		         
	        </tr>
	    </table>

	    
	<?php
		
		
	}
function editmojavejk(){
		
	//$phm_id = isset($_REQUEST['phm_id']) ? (int)($_REQUEST['phm_id']) : 0;
	//if($phm_id<1) die('Invalid  id!');	
	
	$query="select * FROM dm_op_mojavez  opm   
	               left join  dm_operation_acc  op_acc 
	                   on opm.phm_op_id=op_acc.g_id
		WHERE 
			phm_id_province= ".$_SESSION['dm_user_profile']['u_province_id']."
			
	    AND
	       phm_id=".$phm_id."";
			

	 $lnk = mysql_query($query);
	  $row= mysql_fetch_assoc($lnk);
	
	?>
	  <link type="text/css" href="lib/styles/ui.core.css" rel="stylesheet" />
    <link type="text/css" href="lib/styles/ui.theme.css" rel="stylesheet" />
    <link type="text/css" href="lib/styles/ui.datepicker.css" rel="stylesheet" />
	<script type="text/javascript">
	$(function() {
			    
		        //-----------------------------------
		        // انتخاب با کليک بر روي عکس
		        $("#phm_date_f").datepicker({
		            showOn: 'button',
		            buttonImage: 'lib/styles/images/calendar.png',
		            buttonImageOnly: true
		        });
		    })
		$(function() {
		    
		        //-----------------------------------
		        // انتخاب با کليک بر روي عکس
		        $("#phm_date_l").datepicker({
		            showOn: 'button',
		            buttonImage: 'lib/styles/images/calendar.png',
		            buttonImageOnly: true
		        });
		    })
		    
		    
	function validateAndSaveDoc(){
		
	  if(fObj('phm_mojavez').value==''){
			
			alert('لطفا شماره مجوز را وارد کنيد');
			return;
		}
		if(fObj('phm_op_id').value==-2){
		
			      if(fObj('phm_op_id').value==-2){
				
				alert('لطفا نوع عمليات را وارد کنيد');
				return;
			}
	      if(fObj('phm_date_f').value==''){
				
				alert('لطفا تاريخ شروع را وارد نماييد');
				return;
			}
	      if(fObj('phm_date_l').value==''){
				
				alert('لطفا تاريخ پايان را وارد نماييد');
				return;
			}   
	      if(fObj('phm_type_id').value==''){
				
				alert('لطفا نوع را وارد نمایید');
				return;
			}
	      if(fObj('phm_amount').value==''){
				
				alert('لطفا مقدار مجاز را وارد کنید');
				return;
			} 
		}
	   
		edit_mojavezk();
	   
//	   if($_SESSION['checkCodeDoc']==0){
//		   window.open('?pg=havaleMgmtPg&cmd=regDocument&d_code='+fObj('d_code').value+'&d_accountNum='+fObj('d_accountNum').value+'&d_branch='
//		   +fObj('d_branch').value+'&d_fluentAccount='+fObj('d_fluentAccount').value , '_self');
//	   }

	}
	<?php 
	    $gdate=$row['phm_date_f'];
		list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
		list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
		if($jmonth<=9){
		       $jmonth='0'.$jmonth;  
		     }
		if($jday<=9){
		       $jday='0'.$jday;  
		     }
		     $phm_date_f = $jday."/".$jmonth."/".$jyear;
			
		//
		 $gdate=$row['phm_date_l'];
		list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
		list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
		if($jmonth<=9){
				       $jmonth='0'.$jmonth;  
				     }
				if($jday<=9){
				       $jday='0'.$jday;  
				     }
		$phm_date_l = $jday."/".$jmonth."/".$jyear;
		//echo $row['phm_op_id'];
	?>
  </script>
          
		<table  align="center"    class="nasi"  width="90%" style="font-weight:bold;" >
			
		  	<tr style="background-color:<?php echo $_SESSION['htablecolor'] ?>;">
		        <td colspan="6"   style="height: 50px;vertical-align:middle;"  ><b><font size="5">ویرایش مجوز کل استانها</font></b></td>
	        </tr>
	     <tr >
		        <td colspan="6"   style="height: 50px;vertical-align:middle;"  >&nbsp;</td>
	        </tr>
	      	<tr >
		        <td  align="center"><center> شماره مجوز قبلی </center> </td>
		        <td><input name="phm_mojavez" id="phm_mojavez"  value="<?php echo $row['phm_mojavez'] ?>" type="text" class="chk" /></td>
		        <td ><center>نوع عملیات قبلی</center> </td>
		        <td>
			  		<?php echo  getopTypesComboBoxx('phm_op_id')?>
				</td> 
	        </tr>
	        	<tr >
		        <td  align="center"><center> شماره مجوز جدید </center> </td>
		        <td><input  name="phm_mojavezj"  id="phm_mojavezj"   type="text" class="chk" /></td>
		        <td ><center>نوع عملیات جدید</center> </td>
		        <td>
			  		<?php echo  getopTypesComboBoxj('phm_op_idj')?>
				</td> 
	        </tr>
	        <tr>
		       <td>تاريخ شروع</td>
		       <td><input  name="phm_date_f"   id="phm_date_f"   type="text" /></td>
		       <td>تاريخ پايان:</td>
		       <td><input  name="phm_date_l"   id="phm_date_l"    type="text" /></td>
			</tr>
			 <tr>
		       <td>دسته</td>
		       <td><?php echo getCategoryTypesComboBoxrr('phm_type_id')?></td>
		        <td ><center>نوع </center> </td>
			  	<td>
			  		<?php echo getTypesComboBox('p_type')?>
				</td>
		
 </tr>
	      	<tr>
			     <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>      	
			     <td colspan="3"><button name="button" type="button" value="CSS" onclick="validateAndSaveDoc();" class="button blue skew" style="font-size:10px; color:#FFFFFF" > ذخيره</button></td>
			     <td colspan="2">&nbsp;&nbsp;&nbsp;</td>
	      	</tr>
	      	
	    </table>
<!--	</form> -->
	    
	<?php
	
		
		
	}
	function createmojavezFrm_yeki()
	{
	  	$_SESSION['saveDoc']=1;
	$_SESSION['pardakhti']='';
	
	?>
	<link type="text/css" href="lib/styles/ui.core.css" rel="stylesheet" />
    <link type="text/css" href="lib/styles/ui.theme.css" rel="stylesheet" />
    <link type="text/css" href="lib/styles/ui.datepicker.css" rel="stylesheet" />
	<script type="text/javascript">
	
			$(function() {
			    
		        //-----------------------------------
		        // انتخاب با کليک بر روي عکس
		        $("#phm_date_f").datepicker({
		            showOn: 'button',
		            buttonImage: 'lib/styles/images/calendar.png',
		            buttonImageOnly: true
		        });
		    })
		$(function() {
		    
		        //-----------------------------------
		        // انتخاب با کليک بر روي عکس
		        $("#phm_date_l").datepicker({
		            showOn: 'button',
		            buttonImage: 'lib/styles/images/calendar.png',
		            buttonImageOnly: true
		        });
		    })
		    
		    
	function validateAndSaveDoc(){
		
	  if(fObj('phm_mojavez').value==''){
			
			alert('لطفا شماره مجوز را وارد کنيد');
			return;
		}
		if(fObj('phm_op_id').value==-2){
		
			      if(fObj('phm_op_id').value==-2){
				
				alert('لطفا نوع عمليات را وارد کنيد');
				return;
			}
		      if(fObj('phm_date_f').value==''){
					
					alert('لطفا تاريخ شروع را وارد نماييد');
					return;
				}
		      if(fObj('phm_date_l').value==''){
					
					alert('لطفا تاريخ پايان را وارد نماييد');
					return;
				} 
		      if(fObj('phm_type_id').value==''){
					
					alert('لطفا نوع را انتخاب کنید');
					return;
				} 
		      if(fObj('phm_amount').value==''){
					
					alert('مقدارمجاز را وارد کنید');
					return;
				}  
	  
		}

		insertop_mojavez_yeki();
	   
//	   if($_SESSION['checkCodeDoc']==0){
//		   window.open('?pg=havaleMgmtPg&cmd=regDocument&d_code='+fObj('d_code').value+'&d_accountNum='+fObj('d_accountNum').value+'&d_branch='
//		   +fObj('d_branch').value+'&d_fluentAccount='+fObj('d_fluentAccount').value , '_self');
//	   }

	}
  </script>


		<table  align="center"  class="nasi"  width="50%" style="font-weight:bold;" >
		  	<tr style="background-color:<?php echo $_SESSION['htablecolor'] ?>;">
		        <td colspan="6"  style="height: 50px;vertical-align:middle;"  ><b><font size="5">ایجاد مجوز جدید </font></b></td>
	        </tr>
	     
	      	<tr >
		        <td  align="center"><center>شماره مجوز </center> </td>
		        <td><input name="phm_mojavez" id="phm_mojavez"  type="text" class="chk" /></td>
		        <td ><center> نوع عمليات</center> </td>
		        <td>
			  		<?php echo getbankTypesComboBox('phm_op_id')?>
				</td> 
	        </tr>
	        <tr>
		       <td>تاريخ شروع</td>
		       <td><input name="phm_date_f"  id="phm_date_f" type="text" /></td>
		       <td>تاريخ پايان:</td>
		       <td><input name="phm_date_l"  id="phm_date_l" type="text" /></td>
			</tr>
            <tr>
		       <td>دسته</td>
		       <td><?php echo getCategoryTypesComboBoxrr('phm_type_id')?></td>
		        <td ><center>نوع </center> </td>
			  	<td>
			  		<?php echo getTypesComboBox('p_type')?>
				</td>
			</tr>
			<tr >
		        <td  align="center"><center>مقدار مجاز </center> </td>
		        <td><input name="phm_amount" id="phm_amount"  type="text" class="chk" /></td>
		       
	        </tr>
	      	<tr>
			     <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>      	
			     <td colspan="3"><button name="button" type="button" value="CSS" onclick="validateAndSaveDoc();" class="button blue skew" style="font-size:10px; color:#FFFFFF" > ذخيره</button></td>
			     <td colspan="2">&nbsp;&nbsp;&nbsp;</td>
	      	</tr>
	    </table>
<!--	</form> -->
	    
	<?php
		
		
	}
	
	
	
	
	
	
	
	
function ebtalreasonlist(){

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
	
	$outHtml = '	<br>
		<form method="get" action="">
			<input type="hidden" name="pg" value="prodMgmtPg_det">   
			<input type="hidden" name="cmd" value="searchebreason"> 
			 کلمه مورد نظر را وارد كنيد 
			<div> جستجو : <input type="text" name="search" value="'.$_SESSION['srchStr'].'" style="width:100px;"/> 
			  <button value="draft" name="commit" type="submit">جستجو</button> </div>
		</form>
	';
	
	$outHtml .= '<br>	
		<div align = "center">
		 <div align = "center" style="width:50%;height:200px; overflow:auto">
			<table border="5" align="center" cellpadding="0" cellspacing="0" bgcolor=#99CCCC; class="list" >
      			<tr class="rw1">
        			<th colspan="20" align="center" scope="row" style="height: 50px;vertical-align:middle;"><center>علل ابطال </center></th>
        		</tr>
        		
      			<tr class="rw0" style="font-weight:bold;">
      			    <td align="center">رديف</td>
			        <td align="center">کد ابطال</td>
			        <td align="center">علت ابطال </td>
			         <td align="center">تاريخ تعريف </td>
			         <td align="center" colspan="2">&nbsp </td>
			       
				</tr>
	';
	
	if(!isset($_SESSION['srchStr'])) $_SESSION['srchStr'] = '';
	if(!isset($_SESSION['elmCount'])) $_SESSION['elmCount'] = 0;
	if(!isset($_SESSION['rPP'])) $_SESSION['rPP'] = 10;//results per page
	if(!isset($_SESSION['pageCount'])) $_SESSION['pageCount'] = 1;//results page conut
	if(!isset($_SESSION['crntPage'])) $_SESSION['crntPage'] = 1;//current page number
	if($_SESSION['srchStr']==''){
		$srchQ = "";
		
	}else{
		$srchQ = " 
			AND(
					reb_code LIKE '%".$_SESSION['srchStr']."%' 
				
			)
		";
		
	}
	$typeQ = '';
	
	$genQuery = "
		
		FROM 
			dm_reason_eb
		WHERE 
			1 
		".$srchQ." 
		".$typeQ." 
	";
	
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
		
	$lnk = mysql_query($resQuery);
	$inx = ((($_SESSION['crntPage']-1)*$_SESSION['rPP'])+1);		
	if(mysql_affected_rows()>0){	
	$inx--;
		while($row = mysql_fetch_assoc($lnk)){
			
			$gdate=$row['reb_reg_date'];
			list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
			list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
			$jdate = $jyear."/".$jmonth."/".$jday;
			
			if(($inx)%2==1)
				$class="rw0";
				else
				$class="rw1";
			$inx++;
			
			$outHtml .= '
				<tr class='.$class.'>
					<td align="center">'.$inx.'</td>
					<td align="center">'.$row['reb_code'].'</td>
					<td align="center">'.$row['reb_reason'].'</td>
					<td align="center">'.$jdate.'</td>					
					<td align="center"><a href="?pg=prodMgmtPg_det&cmd=ebreasonEditFrm&reb_id='.$row['reb_id'].'"><img src="images/edit.png"  width="30%" height="30%"   border="0" title="ويرايش"></img></a></td>
					<td align="center"><a href="?pg=prodMgmtPg_det&cmd=ebreasonDelete&reb_id='.$row['reb_id'].'"><img src="images/delete.PNG"  width="30%" height="30%"   border="0" title="حذف"></img></a></td>
				</tr>
			';
		}
		$outHtml .= '
		<div> <button type="button" onclick=window.open("?pg=prodMgmtPg_det&cmd=regebreasonFrm","_self")   value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF"> ايجاد علل جديد</button></div>
		';
		
    }else{
    	$outHtml .= '<div> <button type="button" onclick=window.open("?pg=prodMgmtPg_det&cmd=regebreasonFrm","_self")   value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF"> ايجاد علل جديد</button></div>
    	            <tr class="rw1"><td colspan="10">هيچ اطلاعاتي موجود نيست</td></tr>';
    }
     $outHtml .= '</table>
</div><br>'.getNavBar_ebreason().' '.getRPPCombo_ebreason();
   
    return $outHtml;
		
}

function getNavBar_ebreason(){
	$out = '
		<table style="direction:ltr" >
			<tr>
			
	';
	//if($stNum>$_SESSION['pageCount']) $stNum=$_SESSION['pageCount']-5;
	
	$stNum = $_SESSION['crntPage']-5;
	if($stNum<1) $stNum=1;
	$out .= '
		<td><a href="?pg=prodMgmtPg_det&cmd=doc_type&cmd2=setPg&pgNum=1" ><img src="images/first.gif" title="ابتدا"></img></a></td>
		<td>&nbsp;&nbsp;</td>
		<td><a href="?pg=prodMgmtPg_det&cmd=doc_type&cmd2=setPg&pgNum='.((($_SESSION['crntPage']-1)<1) ? 1 : ($_SESSION['crntPage']-1)).'" ><img src="images/prev.gif" title="قبلي"></img></a></td>
		<td>&nbsp;&nbsp;</td>
	';
	$inx = 0;
	while(($inx<10) && (($stNum+$inx) <= $_SESSION['pageCount'])){
		$out .= '
			<td><a '.(($_SESSION['crntPage']==($stNum+$inx)) ? ' style="text-decoration:none; font-weight:bold;" ':'').' href="?pg=prodMgmtPg_det&cmd=doc_type&cmd2=setPg&pgNum='.($stNum+$inx).'" ><div style="background:#cccccc;">'.($stNum+$inx).'</div></a></td><td>&nbsp;</td>
		';
		
		$inx++;
	}
	$out .= '
		<td><a href="?pg=prodMgmtPg_det&cmd=doc_type&cmd2=setPg&pgNum='.((($_SESSION['crntPage']+1)<=$_SESSION['pageCount']) ? ($_SESSION['crntPage']+1) : $_SESSION['pageCount']).'" ><img src="images/next.gif" title="بعدي"></img></a></td>
		<td>&nbsp;&nbsp;</td>
		<td><a href="?pg=prodMgmtPg_det&cmd=doc_type&cmd2=setPg&pgNum='.$_SESSION['pageCount'].'" ><img src="images/last.gif" title="انتها"></img></a></td>
	';
	
	$out .= '
			</tr>
		</table>
	';	
	return $out;
}

function getRPPCombo_ebreason(){
	$out = '<span style="align:center;">
	
		<select onchange="window.open(\'?pg=prodMgmtPg_det&cmd=doc_type&cmd2=setRPP&rPP=\'+this.value, \'_self\')" style="width:50px;" >
			<option value="1" '.(($_SESSION['rPP']==1)?' selected="selected" ':'').' > 1 </option>
			<option value="5" '.(($_SESSION['rPP']==5)?' selected="selected" ':'').' > 5 </option>
			<option value="10" '.(($_SESSION['rPP']==10)?' selected="selected" ':'').' > 10 </option>
			<option value="25" '.(($_SESSION['rPP']==25)?' selected="selected" ':'').' > 25 </option>
			<option value="50" '.(($_SESSION['rPP']==30)?' selected="selected" ':'').' > 50 </option>
			<option value="100" '.(($_SESSION['rPP']==100)?' selected="selected" ':'').' > 100 </option>
			<option value="1000000" '.(($_SESSION['rPP']==0)?' selected="selected" ':'').' > all </option>
		</select>
		
	<span style="color:blue;"><b>پاسخ در صفحه</b></span>
	</div>';
	return $out;
}
function  regebreasonFrm(){
	
		$_SESSION['regebreason']=1;
	
	?>
	
<form method="post" action="" id="commentForm">
			<input type="hidden" name="pg" value="prodMgmtPg_det">   
			<input type="hidden" name="cmd" value="regebreason">	
		<table  align="center" class="nasi" style="font-weight:bold;" >
		  	<tr style="background-color:<?php echo $_SESSION['htablecolor'] ?>;font-weight:bold;">
			       <td colspan="11"  style="height: 50px;vertical-align:middle;"  ><font size="5">علل ابطال حواله</font></td>
	       </tr>
	       <tr>
	            <td colspan="10"><hr style="color:<?php echo $_SESSION['htablecolor'] ?>;height:40%;"></hr></td>
	       </tr>
	      	<tr>
		      	 <td>&nbsp;</td>
		         <td colspan="2"><center>کد ابطال </center></td>
			     <td><input name="reb_code" id="reb_code" type="text" /></td>	
			      <td colspan="2"><center>علت ابطال </center></td>
			     <td><textarea name="reb_reason" id="reb_reason"  /></textarea></td>		       	       
	             <td colspan="2"><button  type="submit"  value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF">ذخيره</button></td>
			     <td colspan="2">&nbsp;</td>	  
	        </tr>
	          <tr>   	                  
			   <td colspan="5">&nbsp;</td>	     	
	    </table>
	
	</form>

	<?php
	
}
function regebreason(){
	if($_SESSION['regebreason']==1){
		
	$reb_reason = isset($_REQUEST['reb_reason']) ? $_REQUEST['reb_reason'] : '';
	$reb_code = isset($_REQUEST['reb_code']) ? $_REQUEST['reb_code'] : '';
	
	$query = "
		INSERT INTO dm_reason_eb 
			(    
			
			    `reb_code`, 
			    `reb_u_id`,
			    `reb_reg_date`,
				`reb_reason`
				
			)
			
		VALUES
			(  '".$reb_code."',
			   '".$_SESSION['dm_user_profile']['u_id']."',			
				'".gmdate('Y-m-d')."',
				'".$reb_reason."'
			
			)
	";
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
	$_SESSION['regebreason']=0;
	$reb_id = mysql_insert_id();
	return $reb_id;	
	
	}
	$_SESSION['regebreason']=0;
}
function ebreasonEditFrm(){
	
	$reb_id  = isset($_REQUEST['reb_id']) ? (int)($_REQUEST['reb_id']) : 0;

	if($reb_id<1) die('Invalid id!');
	
	$lnk = mysql_query("SELECT * FROM dm_reason_eb WHERE  reb_id=".$reb_id);
	
		$row = mysql_fetch_assoc($lnk);
	
		?>

	<form method="post" action="" >
	   	
		<input type="hidden" name="pg" value="prodMgmtPg_det">   
		<input type="hidden" name="cmd" value="ebreason_update">  
		<input type="hidden" name="reb_id" id="reb_id" value="<?php echo $reb_id; ?>">   
		<table  align="center"  class="nasi"   >
		  	<tr style="background-color:<?php echo $_SESSION['htablecolor'] ?>;" >
		       <td colspan="8"  style="height: 50px;vertical-align:middle;"  ><b><font size="5">علل ابطال</font></b></td>
	        </tr>
	        <tr>
	           <td colspan="8"><hr style="color:<?php echo $_SESSION['htablecolor'] ?>;height:40%;"></hr></td>
	       </tr>
	      	<tr>
		       	<td ><center>کد ابطال </center> </td>
		        <td><input name="reb_code" id="reb_code" type="text" value="<?php echo $row['reb_code']; ?>" /></td>
		        <td ><center>علت ابطال </center> </td>
		        <td><input name="reb_reason" id="reb_reason"  type="text" value="<?php echo $row['reb_reason']; ?>" /></textarea></td>
                <td colspan="2"><button  type="submit"  value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF">ذخيره</button></td>
			    <td colspan="2">&nbsp;</td>	  
	        </tr>
	          <tr>   
	                  
			   <td colspan="5">&nbsp;</td>
			       
	      	</tr>
	      		  
	    </table>
	</form>
	
	<?php
}
function ebreason_update(){
	
	$reb_id = isset($_REQUEST['reb_id']) ? (int)($_REQUEST['reb_id']) : 0;
	if($reb_id<1) die('Inv Id');
	
	$reb_code = isset($_REQUEST['reb_code']) ? $_REQUEST['reb_code'] : '';
	$reb_reason = isset($_REQUEST['reb_reason']) ? $_REQUEST['reb_reason'] : '';
	
	$query = "
		UPDATE dm_reason_eb 
		SET 
			`reb_code` = '".$reb_code."',
			`reb_reason` = '".$reb_reason."',
			`reb_u_id` = '".$_SESSION['dm_user_profile']['u_id']."' 
			
		WHERE 
			reb_id = ".$reb_id." 
	";
	//print $query;
	//die($query);
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
	
	
}
function ebreasonDelete(){
	
	$reb_id = isset($_REQUEST['reb_id']) ? (int)($_REQUEST['reb_id']) : 0;
	
	$query = "
		DELETE FROM dm_reason_eb 
	 
			WHERE 
				reb_id   = ".$reb_id  ." 
		";
		$lnk = mysql_query($query);
		if(mysql_error()) print mysql_error();
}
//function changeProvince(){
//	
//	   $city_province = isset($_REQUEST['city_province']) ? (int)($_REQUEST['city_province']) : 0;
//	   $_SESSION['dm_user_profile']['u_province_id'] = $city_province;
//			
//	}
//	function getProvinceCombo($id='ProvinceCombo', $sCust=false){
//	$out = '<select id="'.$id.'" name="'.$id.'" >';
//	$lnk = mysql_query("SELECT * FROM dm_province ORDER BY province_name");
//	if(mysql_affected_rows()>0){
//		while($row=mysql_fetch_assoc($lnk)){
//			$out .= '<option value="'.$row['province_id'].'" >'.  $row['province_name'].'</option>';
//			
//		}
//	}
//	$out .= '</select>';
//	return $out;
//}
?>