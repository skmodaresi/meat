<?php 
include_once 'db_connect.php';

$GLOBALS['isDevelopeMode'] = true;
if($GLOBALS['isDevelopeMode']){
	error_reporting(E_ALL);
}else{
	
} 
error_reporting(0);
function preProcess(){
	global $pg, $cmd;
	$_SESSION['pg']=$pg;
	$_SESSION['cmd']=$cmd;
	switch ($pg){		
		case 'login_pg':
			switch($cmd){
					
		case 'logMeIn':
					logMeIn();
					break;	
			}
			break;
			
		case 'logout_pg':
			logout();
			$_SESSION['isLogged']=false;
			break;
			
		case'dspcalender':
					dspcalender();
					break;					
	}	
}

function inserterQMaker($tableName, $query){
	$out = false;
	if(is_array($query)){
		$fieldsStr = $valueStr = '';
		foreach($query as $key=>$value){
			$fieldsStr .= $key.", ";
			$valueStr .= "'".$value."', ";
		}
		$fieldsStr = substr($fieldsStr, 0, -2);
		$valueStr = substr($valueStr, 0, -2);
		
		$out = "INSERT INTO ".$tableName." (".$fieldsStr.") VALUES (".$valueStr.") ";
	}
	return $out;
}
function getProvinceCombox($id='customer_cusid_province', $customer_cusid_province,$customer_id){

//	if($customer_cusid_province==0){
	$out = '<select id="'.$id.'" name="'.$id.'" onchange="hndlProvince_cityCombo(\'\', this.value,'.$customer_id.')"><option value=""> استان را انتخاب كنيد</option>';
	$lnk = mysql_query("SELECT * FROM dm_province ORDER BY province_name");
	if(mysql_num_rows($lnk)>0){
		while($row=mysql_fetch_assoc($lnk)){
			$out .= '<option value="'.$row['province_id'].'" >'.  $row['province_name'].'</option>';
			
		}
		}
	
	$out .= '</select>';
	return $out;
}
function getProvinceCombox1($id='customer_cusid_province', $province_id){

//	if($customer_cusid_province==0){
	$out = '<select id="'.$id.'" name="'.$id.'" onchange="hndlProvince_cityCombo1(\'\', this.value)"><option value=""> استان را انتخاب كنيد</option>';
	$lnk = mysql_query("SELECT * FROM dm_province ORDER BY province_name");
	if(mysql_num_rows($lnk)>0){
		while($row=mysql_fetch_assoc($lnk)){
			$out .= '<option value="'.$row['province_id'].'" >'.  $row['province_name'].'</option>';
			
		}
		}
	
	$out .= '</select>';
	return $out;
}
function getCustomerTypeRadioHtml($selectedItem){
	$out = '<div>';
	foreach($GLOBALS['costumerTypes'] as $key=>$value){
		$isChkd = ($key==$selectedItem) ? ' checked="checked" ' : '';
		$out .= '<div><input type="radio"  onclick="mngCType('.$key.')" name="h_type" value="'.$value.'" '.$isChkd.' > '.$value.'</div>';
		
	}
	$out .= '</div>';
	return $out;
}

function getReportTypeRadioHtml($selectedItem){
	$out = '<div>';
	foreach($GLOBALS['reportTypes'] as $key=>$value){
		$isChkd = ($key==$selectedItem) ? ' checked="checked" ' : '';
		$out .= '<div><input type="radio"  onclick="mngrType('.$key.')" name="ReportType" value="'.$value.'" '.$isChkd.' > '.$value.'</div>';
		
	}
	$out .= '</div>';
	return $out;
}
function getReportTypeRadioHtmlnew($selectedItem){
	$out = '<div>';
	foreach($GLOBALS['reportTypesnew'] as $key=>$value){
		$isChkd = ($key==$selectedItem) ? ' checked="checked" ' : '';
		$out .= '<div><input type="radio"  onclick="mngrType('.$key.')" name="reportTypesnew" value="'.$value.'" '.$isChkd.' > '.$value.'</div>';
		
	}
	$out .= '</div>';
	return $out;
}
function getReportMTypeRadioHtml($selectedItem){
	$out = '<span >';
	foreach($GLOBALS['reportMTypes'] as $key=>$value){
		$isChkd = ($key==$selectedItem) ? ' checked="checked" ' : '';
		$out .= '<div><input type="radio"  onclick="mngrMType('.$key.')" name="ReportType" value="'.$value.'" '.$isChkd.' > '.$value.'</div>';
		
	}
	$out .= '</span>';
	return $out;
}
function getHorMTypeRadioHtml($selectedItem){
	$out = '<div>';
	foreach($GLOBALS['HorMTypes'] as $key=>$value){
		$isChkd = ($key==$selectedItem) ? ' checked="checked" ' : '';
		$out .= '<div><input type="radio"  onclick="HorMType('.$key.')" name="ReportHorMType" value="'.$value.'" '.$isChkd.' > '.$value.'</div>';
		
	}
	$out .= '</div>';
	return $out;
}

function gethcreateTypeRadioHtml($selectedItem){
	$out = '<div>';
	foreach($GLOBALS['hcreateType'] as $key=>$value){
		$isChkd = ($key==$selectedItem) ? ' checked="checked" ' : '';
		$out .= '<div><input type="radio"  onclick="hcreateType('.$key.')" name="hcreateType" value="'.$value.'" '.$isChkd.' > '.$value.'</div>';
		
	}
	$out .= '</div>';
	return $out;
}
function getfcreateTypeRadioHtml($selectedItem){
	$out = '<div>';
	foreach($GLOBALS['fcreateType'] as $key=>$value){
		$isChkd = ($key==$selectedItem) ? ' checked="checked" ' : '';
		$out .= '<div><input type="radio"  onclick="fcreateType('.$key.')" name="fcreateType" value="'.$value.'" '.$isChkd.' > '.$value.'</div>';
		
	}
	$out .= '</div>';
	return $out;
}
function getpfcreateTypeRadioHtml($selectedItem){
	$out = '<div>';
	foreach($GLOBALS['pfcreateType'] as $key=>$value){
		$isChkd = ($key==$selectedItem) ? ' checked="checked" ' : '';
		$out .= '<div><input type="radio"  onclick="pfcreateType('.$key.')" name="pfcreateType" value="'.$value.'" '.$isChkd.' > '.$value.'</div>';
		
	}
	$out .= '</div>';
	return $out;
}

function getEbtalhRadioHtml($selectedItem){
	$out = '<div>';
	foreach($GLOBALS['EbtalHType'] as $key=>$value){
		$isChkd = ($key==$selectedItem) ? ' checked="checked" ' : '';
		$out .= '<div><input type="radio"  onclick="EbtalHType('.$key.')" name="EbtalHType" value="'.$value.'" '.$isChkd.' > '.$value.'</div>';
		
	}
	$out .= '</div>';
	return $out;
}
function createfRadioHtml($selectedItem){
	$out = '<div>';
	foreach($GLOBALS['createf'] as $key=>$value){
		$isChkd = ($key==$selectedItem) ? ' checked="checked" ' : '';
		$out .= '<div><input type="radio"  onclick="createf('.$key.')" name="createf" value="'.$value.'" '.$isChkd.' > '.$value.'</div>';
		
	}
	$out .= '</div>';
	return $out;
}

function getSellTypeRadioHtml($selectedItem){

	
$out = '<div>';
	foreach($GLOBALS['SellType'] as $key=>$value){
		$isChkd = ($key==$selectedItem) ? ' checked="checked" ' : '';
		$out .= '<div><input type="radio"  onclick=" mngSellType('.$key.')" name="sellType" value="'.$value.'" '.$isChkd.' > '.$value.'</div>';
		
	}
	$out .= '</div>';
	return $out;

}

function getProductTypeRadioHtml($selectedItem){
	
$out = '<div>';
	foreach($GLOBALS['SellTypes'] as $key=>$value){
		$isChkd = ($key==$selectedItem) ? ' checked="checked" ' : '';
		$out .= '<div><input type="radio"  onclick=" mngProductType('.$key.')" name="ProdTypes" value="'.$value.'" '.$isChkd.' > '.$value.'</div>';
		
	}
	$out .= '</div>';
	return $out;

}

function getFooter(){
	
//	echo $_SESSION['dm_user_profile']['u_year_id'];
	
    $day_number = jdate('j');
    $month_number = jdate('n');
    $year_number = jdate('y');
    $day_name = jdate('l');    
	$day_number=farsinum($day_number);
    $month_number=farsinum($month_number);
	$year_number=farsinum( $year_number);
	
	?>
	<SCRIPT LANGUAGE=JAVASCRIPT>
		function newWindow() {
		mapWindow = window.open('calender.php','mapWin','width =730,height=400')
		}
		
   </SCRIPT>
 
	<?php 
	$out ='<table  align="righ">';

       $lnk = mysql_query("SELECT * FROM dm_province WHERE province_id={$_SESSION['dm_user_profile']['u_province_id']} ");
	    $row=mysql_fetch_assoc($lnk);
	   
 echo   '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp'; 
	$out .='</td></tr>';	
	if($_SESSION['isLogged']) {
		

	$out .='<tr ><td>
	';
	                  echo 'j امروز:' .$day_name.'' .  $day_number.'-'.$month_number.'-'.$year_number.'';
	                  echo  '&nbsp;&nbsp;&nbsp;&nbsp'; 
			          echo  'سال:'.  hndlNameYearCombo('NameYearCombo1');
			          echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			          echo  'استان:'.   hndlProvinceCombo('NameProvinceCombo');
			          echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			          echo  '<span style="color:rgb(128,128,128); font-size:10px;" align="right">شرکت پشتيباني امور دام کشورwww.iranslal.com</span> </td></tr>';
			        
		          
			         
	
	$out .='</table></div>';}else{
	
	$out .='<table align="center"><tr><td style="color:rgb(128,128,128);font-size:12px;" align="left">شرکت پشتيباني امور دام کشورwww.iranslal.com</td>
	       <td>&nbsp;</td></tr>
	</table>';}
    echo $out;
}

function getTopMenu(){
	
	              
                   ?>
                    <table  style="background:#dddddd;" width=100%>
	                    <tr>
		                    <td width=20%>&nbsp;</td><?php if($_SESSION['isLogged']) { ?>   
		                    <td align="left">نام کاربر: <?php echo $_SESSION['dm_user_profile']['u_name']?></td><?php } ?>
		                    <td>&nbsp;</td>                
	                    </tr>
                    </table>
<?php 
  
	$out = '<ul id="nav" class="dropdown dropdown-horizontal" style="width:90%;">';
		
			if($_SESSION['isLogged']){
			
			$out .= '<li class="dir">اطلاعات پايه
				<ul>';
			$query='select *
					from dm_um_rel t
					     inner join dm_listmenu l on l.menu_id = t.um_menu_id
					where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
					      l.menu_code = \'110\'';//  and t.can_delete =1';

			$lnk = mysql_query($query);
			if ((mysql_num_rows($lnk) > 0) || ($_SESSION['dm_user_profile']['u_user_name'] =='modir' && $_SESSION['dm_user_profile']['u_pass_word'] =='modir')){
						
					$out .= '<li class="dir"> اطلاعات كالاها
						<ul>';
							$query='select *
									from dm_um_rel t
									     inner join dm_listmenu l on l.menu_id = t.um_menu_id
									where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
									      l.menu_code = \'111\'';//  and t.can_delete =1';

				               $lnk = mysql_query($query);
				               if ((mysql_num_rows($lnk)>0 ) || ($_SESSION['dm_user_profile']['u_user_name'] =='modir' && $_SESSION['dm_user_profile']['u_pass_word'] =='modir')){
					$out .= '<li><a href="home.php?pg=prodMgmtPg&cmd=dspProdRegFrm1">ايجاد كالاي جديد</a></li>';}
									$query='select *
												from dm_um_rel t
												     inner join dm_listmenu l on l.menu_id = t.um_menu_id
												where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
												      l.menu_code = \'112\'';//  and t.can_delete =1';
									$lnk = mysql_query($query);
								if ((mysql_num_rows($lnk)>0) || ($_SESSION['dm_user_profile']['u_user_name'] =='modir' && $_SESSION['dm_user_profile']['u_pass_word'] =='modir')){
					
					$out .= '<li><a href="home.php?pg=prodMgmtPg&cmd=showprodList">ليست كالا ها</a></li>';}
			$query='select *	
					 	from dm_um_rel t
								     inner join dm_listmenu l on l.menu_id = t.um_menu_id
								where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
								      l.menu_code = \'610\'';//  and t.can_delete =1';
						   $lnk = mysql_query($query);
						   if ((mysql_num_rows($lnk)>0) || ($_SESSION['dm_user_profile']['u_user_name'] =='modir' && $_SESSION['dm_user_profile']['u_pass_word'] =='modir')){
					$out .= '<li><a href="home.php?pg=prodMgmtPg_det&cmd=category_prod">دسته بندي کالاها</a></li>';}
			$query='select *	
			 	from dm_um_rel t
						     inner join dm_listmenu l on l.menu_id = t.um_menu_id
						where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
						      l.menu_code = \'611\'';//  and t.can_delete =1';
				   $lnk = mysql_query($query);
				   if ((mysql_num_rows($lnk)>0) || ($_SESSION['dm_user_profile']['u_user_name'] =='modir' && $_SESSION['dm_user_profile']['u_pass_word'] =='modir')){
					$out .= '<li><a href="home.php?pg=prodMgmtPg_det&cmd=pack_prod">بسته بندي کالاها</a></li>';}
			$query='select *	
		 	           from dm_um_rel t
					     inner join dm_listmenu l on l.menu_id = t.um_menu_id
					where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
					      l.menu_code = \'612\'';//  and t.can_delete =1';
			   $lnk = mysql_query($query);
			   if ((mysql_num_rows($lnk)>0) || ($_SESSION['dm_user_profile']['u_user_name'] =='modir' && $_SESSION['dm_user_profile']['u_pass_word'] =='modir')){
					$out .= '<li><a href="home.php?pg=prodMgmtPg_det&cmd=type_prod">نوع کالاها</a></li>';}
			$query='select *	
 	           from dm_um_rel t
			     inner join dm_listmenu l on l.menu_id = t.um_menu_id
			where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
			      l.menu_code = \'613\'';//  and t.can_delete =1';
	   $lnk = mysql_query($query);
			   if ((mysql_num_rows($lnk)>0) || ($_SESSION['dm_user_profile']['u_user_name'] =='modir' && $_SESSION['dm_user_profile']['u_pass_word'] =='modir')){
					$out .= '<li><a href="home.php?pg=prodMgmtPg_det&cmd=unit_prod">واحد کالاها</a></li>';}
				$query='select *	
 	           from dm_um_rel t
			     inner join dm_listmenu l on l.menu_id = t.um_menu_id
			where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
			      l.menu_code = \'616\'';//  and t.can_delete =1';
	   $lnk = mysql_query($query);
			   if ((mysql_num_rows($lnk)>0) || ($_SESSION['dm_user_profile']['u_user_name'] =='modir' && $_SESSION['dm_user_profile']['u_pass_word'] =='modir')){					
					
					$out .= '<li><a href="home.php?pg=prodMgmtPg_det&cmd=charge_type">نوع هزينه</a></li>';	}				
						$out .= '</ul>
					</li>';
			}
			                          $query='select *
												from dm_um_rel t
												     inner join dm_listmenu l on l.menu_id = t.um_menu_id
												where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
												      l.menu_code = \'120\'';//  and t.can_delete =1';
									$lnk = mysql_query($query);
									if ((mysql_num_rows($lnk)>0) || ($_SESSION['dm_user_profile']['u_user_name'] =='modir' && $_SESSION['dm_user_profile']['u_pass_word'] =='modir')){
									
						$out .= '<li class="dir">اطلاعات اسناد
										<ul>';
									              $query='select *
															from dm_um_rel t
															     inner join dm_listmenu l on l.menu_id = t.um_menu_id
															where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
															      l.menu_code = \'121\'';//  and t.can_delete =1';
												$lnk = mysql_query($query);
												if ((mysql_num_rows($lnk)>0) || ($_SESSION['dm_user_profile']['u_user_name'] =='modir' && $_SESSION['dm_user_profile']['u_pass_word'] =='modir')){
						$out .= '<li><a href="home.php?pg=prodMgmtPg&cmd=dspRegDocumentFrm">ايجاد سند جديد</a></li>';}
						                          $query='select *
															from dm_um_rel t
															     inner join dm_listmenu l on l.menu_id = t.um_menu_id
															where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
															      l.menu_code = \'122\'';//  and t.can_delete =1';
													$lnk = mysql_query($query);
													if ((mysql_num_rows($lnk)>0) || ($_SESSION['dm_user_profile']['u_user_name'] =='modir' && $_SESSION['dm_user_profile']['u_pass_word'] =='modir')){
						$out .= '<li><a href="home.php?pg=prodMgmtPg&cmd=showdocumentList">ليست اسناد</a></li>';}
							$query='select *	
 	           from dm_um_rel t
			     inner join dm_listmenu l on l.menu_id = t.um_menu_id
			where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
			      l.menu_code = \'614\'';//  and t.can_delete =1';
	   $lnk = mysql_query($query);
			   if ((mysql_num_rows($lnk)>0) || ($_SESSION['dm_user_profile']['u_user_name'] =='modir' && $_SESSION['dm_user_profile']['u_pass_word'] =='modir')){
					$out .= '<li><a href="home.php?pg=prodMgmtPg_det&cmd=doc_type">نوع سند</a></li>';	}
		$query='select *	
 	           from dm_um_rel t
			     inner join dm_listmenu l on l.menu_id = t.um_menu_id
			where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
			      l.menu_code = \'615\'';//  and t.can_delete =1';
	   $lnk = mysql_query($query);
			   if ((mysql_num_rows($lnk)>0) || ($_SESSION['dm_user_profile']['u_user_name'] =='modir' && $_SESSION['dm_user_profile']['u_pass_word'] =='modir')){			
					$out .= '<li><a href="home.php?pg=prodMgmtPg_det&cmd=doc_typeb">نام بانک</a></li>';	}	
								
						$out .= '</ul>
						</li>';                                }
					
								 $query='select *	
								 	from dm_um_rel t
											     inner join dm_listmenu l on l.menu_id = t.um_menu_id
											where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
											      l.menu_code = \'130\'';//  and t.can_delete =1';
									$lnk = mysql_query($query);
									if ((mysql_num_rows($lnk)>0) || ($_SESSION['dm_user_profile']['u_user_name'] =='modir' && $_SESSION['dm_user_profile']['u_pass_word'] =='modir')){
					   $out .= '<li class="dir"> محل هاي تحويل کالا
						        <ul>';
					                $query='select *	
								 	from dm_um_rel t
											     inner join dm_listmenu l on l.menu_id = t.um_menu_id
											where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
											      l.menu_code = \'131\'';//  and t.can_delete =1';
									$lnk = mysql_query($query);
									if ((mysql_num_rows($lnk)>0) || ($_SESSION['dm_user_profile']['u_user_name'] =='modir' && $_SESSION['dm_user_profile']['u_pass_word'] =='modir')){
					   $out .= '<li><a href="home.php?pg=prodMgmtPg&cmd=dspRegLocationGoodsFrm">ايجاد محل هاي جديد</a></li>';}
								    $query='select *	
											 	from dm_um_rel t
														     inner join dm_listmenu l on l.menu_id = t.um_menu_id
														where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
														      l.menu_code = \'132\'';//  and t.can_delete =1';
												$lnk = mysql_query($query);
												if ((mysql_num_rows($lnk)>0) || ($_SESSION['dm_user_profile']['u_user_name'] =='modir' && $_SESSION['dm_user_profile']['u_pass_word'] =='modir')){
					   $out .= '<li><a href="home.php?pg=prodMgmtPg&cmd=showlocationList">رويت اطلاعات محل ها</a></li>';}
								
					  $out .= '</ul>
						             </li>';                      }
							    $query='select *	
											 	from dm_um_rel t
														     inner join dm_listmenu l on l.menu_id = t.um_menu_id
														where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
														      l.menu_code = \'140\'';//  and t.can_delete =1';
												$lnk = mysql_query($query);
												if ((mysql_num_rows($lnk)>0) || ($_SESSION['dm_user_profile']['u_user_name'] =='modir' && $_SESSION['dm_user_profile']['u_pass_word'] =='modir')){
					  $out .= '<li class="dir">اطلاعات هزينه ها
						<ul>';
					             $query='select *	
											 	from dm_um_rel t
														     inner join dm_listmenu l on l.menu_id = t.um_menu_id
														where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
														      l.menu_code = \'141\'';//  and t.can_delete =1';
												$lnk = mysql_query($query);
												if ((mysql_num_rows($lnk)>0) || ($_SESSION['dm_user_profile']['u_user_name'] =='modir' && $_SESSION['dm_user_profile']['u_pass_word'] =='modir')){
					 $out .= '<li><a href="home.php?pg=prodMgmtPg&cmd=dspRegChargeFactorsFrm">ايجاد هزينه جديد</a></li>';}
					          
					             $query='select *	
											 	from dm_um_rel t
														     inner join dm_listmenu l on l.menu_id = t.um_menu_id
														where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
														      l.menu_code = \'142\'';//  and t.can_delete =1';
												$lnk = mysql_query($query);
												if ((mysql_num_rows($lnk)>0) || ($_SESSION['dm_user_profile']['u_user_name'] =='modir' && $_SESSION['dm_user_profile']['u_pass_word'] =='modir')){
					  $out .= '<li><a href="home.php?pg=prodMgmtPg&cmd=showChargeFactorsList">رويت هزينه هاي قبلي</a></li>';}
					  $out .= '</ul>
					</li>';}
					  
					             $query='select *	
											 	from dm_um_rel t
														     inner join dm_listmenu l on l.menu_id = t.um_menu_id
														where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
														      l.menu_code = \'150\'';//  and t.can_delete =1';
												   $lnk = mysql_query($query);
												   if ((mysql_num_rows($lnk)>0) || ($_SESSION['dm_user_profile']['u_user_name'] =='modir' && $_SESSION['dm_user_profile']['u_pass_word'] =='modir')){
					  $out .= '<li class="dir">اطلاعات شهر و استان
						<ul>';
					                 $query='select *	
											 	from dm_um_rel t
														     inner join dm_listmenu l on l.menu_id = t.um_menu_id
														where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
														      l.menu_code = \'151\'';//  and t.can_delete =1';
												   $lnk = mysql_query($query);
												   if ((mysql_num_rows($lnk)>0) || ($_SESSION['dm_user_profile']['u_user_name'] =='modir' && $_SESSION['dm_user_profile']['u_pass_word'] =='modir')){
					 $out .= '<li><a href="home.php?pg=prodMgmtPg&cmd=dspregInformationProvince">ورود اطلاعات استان ها</a></li>';}
					                     $query='select *	
											 	from dm_um_rel t
														     inner join dm_listmenu l on l.menu_id = t.um_menu_id
														where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
														      l.menu_code = \'152\'';//  and t.can_delete =1';
												   $lnk = mysql_query($query);
												   if ((mysql_num_rows($lnk)>0) || ($_SESSION['dm_user_profile']['u_user_name'] =='modir' && $_SESSION['dm_user_profile']['u_pass_word'] =='modir')){
					 $out .= '<li><a href="home.php?pg=prodMgmtPg&cmd=getProvinceNameList">ليست استان ها</a></li>';}
					                     $query='select *	
											 	from dm_um_rel t
														     inner join dm_listmenu l on l.menu_id = t.um_menu_id
														where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
														      l.menu_code = \'153\'';//  and t.can_delete =1';
												   $lnk = mysql_query($query);
												   if ((mysql_num_rows($lnk)>0) || ($_SESSION['dm_user_profile']['u_user_name'] =='modir' && $_SESSION['dm_user_profile']['u_pass_word'] =='modir')){
					 $out .= '<li><a href="home.php?pg=prodMgmtPg&cmd=dspregInformationCity">ورود اطلاعات شهرها</a></li>';}
					                    $query='select *	
											 	from dm_um_rel t
														     inner join dm_listmenu l on l.menu_id = t.um_menu_id
														where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
														      l.menu_code = \'154\'';//  and t.can_delete =1';
												   $lnk = mysql_query($query);
												   if ((mysql_num_rows($lnk) > 0) || ($_SESSION['dm_user_profile']['u_user_name'] =='modir' && $_SESSION['dm_user_profile']['u_pass_word'] =='modir')){
					$out .= '<li><a href="home.php?pg=prodMgmtPg&cmd=getCityNameList">ليست شهر ها</a></li>';}
					$out .= '</ul>
					</li>';}
					                    $query='select *	
											 	from dm_um_rel t
														     inner join dm_listmenu l on l.menu_id = t.um_menu_id
														where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
														      l.menu_code = \'160\'';//  and t.can_delete =1';
												   $lnk = mysql_query($query);
												   if ((mysql_num_rows($lnk)>0) || ($_SESSION['dm_user_profile']['u_user_name'] =='modir' && $_SESSION['dm_user_profile']['u_pass_word'] =='modir')){
					$out .= '<li class="dir">مديريت مشتري
						<ul>';
					             $query='select *	
											 	from dm_um_rel t
														     inner join dm_listmenu l on l.menu_id = t.um_menu_id
														where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
														      l.menu_code = \'161\'';//  and t.can_delete =1';
												   $lnk = mysql_query($query);
												   if ((mysql_num_rows($lnk)>0) || ($_SESSION['dm_user_profile']['u_user_name'] =='modir' && $_SESSION['dm_user_profile']['u_pass_word'] =='modir')){
                    $out .= '<li><a href="newcustomer.php" target="_blank">مشتري جديد</a></li>';	}	
                               $query='select *	
											 	from dm_um_rel t
														     inner join dm_listmenu l on l.menu_id = t.um_menu_id
														where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
														      l.menu_code = \'162\'';//  and t.can_delete =1';
												   $lnk = mysql_query($query);
												   if ((mysql_num_rows($lnk)>0) || ($_SESSION['dm_user_profile']['u_user_name'] =='modir' && $_SESSION['dm_user_profile']['u_pass_word'] =='modir')){				  
					$out .= '<li><a href="home.php?pg=prodMgmtPg&cmd=getListInformationCustomer">ليست مشتري ها</a></li>';}
					                 $query='select *	
											 	from dm_um_rel t
														     inner join dm_listmenu l on l.menu_id = t.um_menu_id
														where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
														      l.menu_code = \'163\'';//  and t.can_delete =1';
												   $lnk = mysql_query($query);
												   if ((mysql_num_rows($lnk)>0) || ($_SESSION['dm_user_profile']['u_user_name'] =='modir' && $_SESSION['dm_user_profile']['u_pass_word'] =='modir')){	
					$out .= '<li><a href="home.php?pg=prodMgmtPg&cmd=dspRegcategoryCustomer">دسته بندي مشتريان</a></li>';}
					                     $query='select *	
											 	from dm_um_rel t
														     inner join dm_listmenu l on l.menu_id = t.um_menu_id
														where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
														      l.menu_code = \'164\'';//  and t.can_delete =1';
												   $lnk = mysql_query($query);
												   if ((mysql_num_rows($lnk)>0) || ($_SESSION['dm_user_profile']['u_user_name'] =='modir' && $_SESSION['dm_user_profile']['u_pass_word'] =='modir')){	
												   						 
					$out .= '<li><a href="home.php?pg=prodMgmtPg&cmd=getcategoryNameList">انواع دسته بندي</a></li>';}
					
					  	$query='select *	
					 	from dm_um_rel t
								     inner join dm_listmenu l on l.menu_id = t.um_menu_id
								where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
								      l.menu_code = \'165\'';//  and t.can_delete =1';
						   $lnk = mysql_query($query);
						   if ((mysql_num_rows($lnk)>0) || ($_SESSION['dm_user_profile']['u_user_name'] =='modir' && $_SESSION['dm_user_profile']['u_pass_word'] =='modir')){	
					$out .= '<li><a href="home.php?pg=prodMgmtPg_det&cmd=cus_act">نوع فعاليت</a></li>';}
					$query='select *	
					 	from dm_um_rel t
								     inner join dm_listmenu l on l.menu_id = t.um_menu_id
								where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
								      l.menu_code = \'166\'';//  and t.can_delete =1';
						   $lnk = mysql_query($query);
						   if ((mysql_num_rows($lnk)>0) || ($_SESSION['dm_user_profile']['u_user_name'] =='modir' && $_SESSION['dm_user_profile']['u_pass_word'] =='modir')){	
					$out .= '<li><a href="home.php?pg=prodMgmtPg_det&cmd=cus_pay">نوع پرداخت</a></li>';}
					$query='select *	
					 	from dm_um_rel t
								     inner join dm_listmenu l on l.menu_id = t.um_menu_id
								where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
								      l.menu_code = \'167\'';//  and t.can_delete =1';
						   $lnk = mysql_query($query);
						   if ((mysql_num_rows($lnk)>0) || ($_SESSION['dm_user_profile']['u_user_name'] =='modir' && $_SESSION['dm_user_profile']['u_pass_word'] =='modir')){	
					$out .= '<li><a href="home.php?pg=prodMgmtPg_det&cmd=cus_person">نوع شخصيت</a></li>';}
					$query='select *	
					 	from dm_um_rel t
								     inner join dm_listmenu l on l.menu_id = t.um_menu_id
								where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
								      l.menu_code = \'168\'';//  and t.can_delete =1';
						   $lnk = mysql_query($query);
						   if ((mysql_num_rows($lnk)>0) || ($_SESSION['dm_user_profile']['u_user_name'] =='modir' && $_SESSION['dm_user_profile']['u_pass_word'] =='modir')){	
					$out .= '<li><a href="home.php?pg=prodMgmtPg_det&cmd=cus_type"> نوع مشتري</a></li>';}
					$query='select *	
					 	from dm_um_rel t
								     inner join dm_listmenu l on l.menu_id = t.um_menu_id
								where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
								      l.menu_code = \'169\'';//  and t.can_delete =1';
						   $lnk = mysql_query($query);
						   if ((mysql_num_rows($lnk)>0) || ($_SESSION['dm_user_profile']['u_user_name'] =='modir' && $_SESSION['dm_user_profile']['u_pass_word'] =='modir')){	
					$out .= '<li><a href="home.php?pg=prodMgmtPg_det&cmd=cus_status">وضعيت مشتري</a></li>';}
					$query='select *	
					 	from dm_um_rel t
								     inner join dm_listmenu l on l.menu_id = t.um_menu_id
								where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
								      l.menu_code = \'1691\'';//  and t.can_delete =1';
						   $lnk = mysql_query($query);
						   if ((mysql_num_rows($lnk)>0) || ($_SESSION['dm_user_profile']['u_user_name'] =='modir' && $_SESSION['dm_user_profile']['u_pass_word'] =='modir')){	
					$out .= '<li><a href="home.php?pg=prodMgmtPg_det&cmd=cus_status_s">سهميه بندي</a></li>';	}	   
												   
												   		
						$out .= '</ul>';}
					$out .= '</li>';
					if($_SESSION['dm_user_profile']['u_id']==3){
					$out .= '<li ><a href="home.php?pg=prodMgmtPg&cmd=createMenu‍">ايجاد منو</a></li>';}

		$query='select *	
 	           from dm_um_rel t
			     inner join dm_listmenu l on l.menu_id = t.um_menu_id
			where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
			      l.menu_code = \'17000\'';//  and t.can_delete =1';
	   $lnk = mysql_query($query);
			   if ((mysql_num_rows($lnk)>0) || ($_SESSION['dm_user_profile']['u_user_name'] =='modir' && $_SESSION['dm_user_profile']['u_pass_word'] =='modir')){
				//<li ><a href="home.php?pg=prodMgmtPg_det&cmd=Create_docFrm">اطلاعات سند فروش</a></li>	
				
	//		$out .= '<li ><a href="home.php?pg=prodMgmtPg&cmd=createMenu‍">ايجاد منو</a></li>';		
			   	if($_SESSION['dm_user_profile']['u_id']==3){
			$out .= ' <li ><a href="home.php?pg=prodMgmtPg_det&cmd=Create_docFrm">اطلاعات سند فروش</a></li>	
			   </li>';}
					
				$out .= '<li class="dir">تصحيح امضا ها
						<ul>
				<li ><a href="home.php?pg=changingSignatures&cmd=showchangingSignatures_o">امضاى كالاهاى علوفه اى</a></li>
				<li ><a href="home.php?pg=changingSignatures&cmd=showchangingSignatures">امضاى كالاهاى گوشتى</a></li>
			     
					 </ul>';
			   }	
			$query='select *	
 	           from dm_um_rel t
			     inner join dm_listmenu l on l.menu_id = t.um_menu_id
			where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
			      l.menu_code = \'19000\'';//  and t.can_delete =1';
	   $lnk = mysql_query($query);
			   if ((mysql_num_rows($lnk)>0) || ($_SESSION['dm_user_profile']['u_user_name'] =='modir' && $_SESSION['dm_user_profile']['u_pass_word'] =='modir')){
				   	$out .='<li><a href="home.php?pg=prodMgmtPg_det&cmd=ebtalreasonlist">علل ابطال حواله</a></li>';
			   }
			//$query='select *	
 	        //   from dm_um_rel t
			//     inner join dm_listmenu l on l.menu_id = t.um_menu_id
			//where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
			//      l.menu_code = \'20000\'';//  and t.can_delete =1';
	 //  $lnk = mysql_query($query);
			  // if ((mysql_num_rows($lnk)>0) || ($_SESSION['dm_user_profile']['u_user_name'] =='modir' && $_SESSION['dm_user_profile']['u_pass_word'] =='modir')){
				   	$out .='<li><a href="home.php?pg=prodMgmtPg_det&cmd=createmojavezFrm">ايجاد مجوز جديد</a></li>';
				    $out .='<li><a href="home.php?pg=prodMgmtPg&cmd=mojavezList">ليست مجوز ها</a></li>';
				   	
			//   }
				$out .= '</ul>
			</li>';
		
	  $query='select *	
 	           from dm_um_rel t
			     inner join dm_listmenu l on l.menu_id = t.um_menu_id
			where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
			      l.menu_code = \'3000\'';//  and t.can_delete =1';
	   $lnk = mysql_query($query);
			   if ((mysql_num_rows($lnk)>0) || ($_SESSION['dm_user_profile']['u_user_name'] =='modir' && $_SESSION['dm_user_profile']['u_pass_word'] =='modir')){	
			$out .= '<li class="dir">اطلاعات حواله
				<ul>';
			$out .= '<li class="dir">پيش نويس حواله
						<ul>';
		$query='select *	
 	           from dm_um_rel t
			     inner join dm_listmenu l on l.menu_id = t.um_menu_id
			where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
			      l.menu_code = \'310\'';//  and t.can_delete =1';
	   $lnk = mysql_query($query);
			   if ((mysql_num_rows($lnk)>0) || ($_SESSION['dm_user_profile']['u_user_name'] =='modir' && $_SESSION['dm_user_profile']['u_pass_word'] =='modir')){	
					$out .= '<li><a href="home.php?pg=havaleMgmtPg&cmd=dspPreHavaleFrm" > معرفي نامه/صدور پيش  حواله</a></li>';	
					$out .= '<li><a href="home.php?pg=havaleMgmtPg&cmd=dsppHavaleFrm" > صدور معرفي نامه</a></li>';	
			   
			   }
		$query='select *	
 	           from dm_um_rel t
			     inner join dm_listmenu l on l.menu_id = t.um_menu_id
			where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
			      l.menu_code = \'311\'';//  and t.can_delete =1';
	   $lnk = mysql_query($query);
			   if ((mysql_num_rows($lnk)>0) || ($_SESSION['dm_user_profile']['u_user_name'] =='modir' && $_SESSION['dm_user_profile']['u_pass_word'] =='modir')){											
					$out .= '<li><a href="home.php?pg=havaleMgmtPg&cmd=dspPreHavaleList" >ليست پيش حواله</a></li>';}
//nadare	
//$query='select *	
// 	           from dm_um_rel t
//			     inner join dm_listmenu l on l.menu_id = t.um_menu_id
//			where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
//			      l.menu_code = \'315\'';//  and t.can_delete =1';
//$lnk = mysql_query($query);
//			   if(mysql_affected_rows()>0){					
			   $out .= '<li><a href="home.php?pg=havaleMgmtPg&cmd=EditPishHavaleFrm" >ويرايش پيش نويس حواله</a></li>';
//			   	}
$out .= '<li><a href="home.php?pg=havaleMgmtPg&cmd=EditHavaleFrm" >ويرايش حواله</a></li>';
                $out .= '<li><a href="home.php?pg=havaleMgmtPg&cmd=ListMoarefi" >ليست معرفي نامه ها</a></li>';
                $out .= '<li><a href="home.php?pg=havaleMgmtPg&cmd=ListMoarefieb" >ليست معرفي نامه های ابطالی</a></li>';
                 $out .= '<li><a href="home.php?pg=havaleMgmtPg&cmd=ebtalMoarefi" >ابطال معرفي نامه</a></li>';
				$out .= '</ul>';
		$query='select *	
 	           from dm_um_rel t
			     inner join dm_listmenu l on l.menu_id = t.um_menu_id
			where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
			      l.menu_code = \'312\'';//  and t.can_delete =1';
	   $lnk = mysql_query($query);
			   if ((mysql_num_rows($lnk)>0) || ($_SESSION['dm_user_profile']['u_user_name'] =='modir' && $_SESSION['dm_user_profile']['u_pass_word'] =='modir')){						
					$out .= '<li><a href="home.php?pg=havaleMgmtPg&cmd=dspHavaleFrm">صدور حواله</a></li>';}
	 $query='select *	
 	           from dm_um_rel t
			     inner join dm_listmenu l on l.menu_id = t.um_menu_id
			where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
			      l.menu_code = \'313\'';//  and t.can_delete =1';
	   $lnk = mysql_query($query);
			   if ((mysql_num_rows($lnk)>0) || ($_SESSION['dm_user_profile']['u_user_name'] =='modir' && $_SESSION['dm_user_profile']['u_pass_word'] =='modir')){		
					$out .= '<li><a href="home.php?pg=havaleMgmtPg&cmd=dspHavaleList">ليست حواله</a></li>';}
	 $query='select *	
 	           from dm_um_rel t
			     inner join dm_listmenu l on l.menu_id = t.um_menu_id
			where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
			      l.menu_code = \'314\'';//  and t.can_delete =1';
	   $lnk = mysql_query($query);
			   if ((mysql_num_rows($lnk)>0) || ($_SESSION['dm_user_profile']['u_user_name'] =='modir' && $_SESSION['dm_user_profile']['u_pass_word'] =='modir')){	
			   $out .= '<li><a href="home.php?pg=havaleMgmtPg&cmd=ebtalHavaleFrm">ابطال حواله</a></li>';} 
			   $query='select *	
 	           from dm_um_rel t
			     inner join dm_listmenu l on l.menu_id = t.um_menu_id
			where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
			      l.menu_code = \'100200\'';
	   $lnk = mysql_query($query);
			   if ((mysql_num_rows($lnk)>0) || ($_SESSION['dm_user_profile']['u_user_name'] =='modir' && $_SESSION['dm_user_profile']['u_pass_word'] =='modir')){	
			   $out .= '<li><a href="home.php?pg=havaleMgmtPg&cmd=ebtalList">ليست ابطالى ها</a></li>';}
					
				$out .= '</ul>';}
			$out .= '</li>';
			$query='select *	
 	           from dm_um_rel t
			     inner join dm_listmenu l on l.menu_id = t.um_menu_id
			where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
			      l.menu_code = \'2000\'';//  and t.can_delete =1';
	   $lnk = mysql_query($query);
	   
			   if ((mysql_num_rows($lnk)>0) || ($_SESSION['dm_user_profile']['u_user_name'] =='modir' && $_SESSION['dm_user_profile']['u_pass_word'] =='modir')){	
			$out .= '<li class="dir">اطلاعات فاکتور
				<ul>';
		$query='select *	
 	           from dm_um_rel t
			     inner join dm_listmenu l on l.menu_id = t.um_menu_id
			where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
			      l.menu_code = \'210\'';//  and t.can_delete =1';
	   $lnk = mysql_query($query);
			   if ((mysql_num_rows($lnk)>0) || ($_SESSION['dm_user_profile']['u_user_name'] =='modir' && $_SESSION['dm_user_profile']['u_pass_word'] =='modir')){	
					$out .= '<li><a href="home.php?pg=PfactorMgmtPg&cmd=dspPreFactorFrm">صدوروتغيير پيش فاكتور</a></li>';}
		$query='select *	
 	           from dm_um_rel t
			     inner join dm_listmenu l on l.menu_id = t.um_menu_id
			where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
			      l.menu_code = \'211\'';//  and t.can_delete =1';
	   $lnk = mysql_query($query);
			   if ((mysql_num_rows($lnk)>0) || ($_SESSION['dm_user_profile']['u_user_name'] =='modir' && $_SESSION['dm_user_profile']['u_pass_word'] =='modir')){	
					$out .= '<li><a href="home.php?pg=PfactorMgmtPg&cmd=dspPreFactorList">ليست پيش فاکتورها</a></li>';}
		$query='select *	
 	           from dm_um_rel t
			     inner join dm_listmenu l on l.menu_id = t.um_menu_id
			where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
			      l.menu_code = \'212\'';//  and t.can_delete =1';
	   $lnk = mysql_query($query);
			   if ((mysql_num_rows($lnk)>0) || ($_SESSION['dm_user_profile']['u_user_name'] =='modir' && $_SESSION['dm_user_profile']['u_pass_word'] =='modir')){	
					$out .= '<li><a href="home.php?pg=PfactorMgmtPg&cmd=dspFactorFrm">صدور فاكتور</a></li>';}
	  $query='select *	
 	           from dm_um_rel t
			     inner join dm_listmenu l on l.menu_id = t.um_menu_id
			where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
			      l.menu_code = \'213\'';//  and t.can_delete =1';
	   $lnk = mysql_query($query);
			   if ((mysql_num_rows($lnk)>0) || ($_SESSION['dm_user_profile']['u_user_name'] =='modir' && $_SESSION['dm_user_profile']['u_pass_word'] =='modir')){	
					$out .= '<li><a href="home.php?pg=PfactorMgmtPg&cmd=dspFactorList">ليست فاكتور</a></li>';}
				$out .= '</ul>';}
			$out .= '</li>';
	  $query='select *	
 	           from dm_um_rel t
			     inner join dm_listmenu l on l.menu_id = t.um_menu_id
			where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
			      l.menu_code = \'4000\'';//  and t.can_delete =1';
	   $lnk = mysql_query($query);
			   if ((mysql_num_rows($lnk)>0) || ($_SESSION['dm_user_profile']['u_user_name'] =='modir' && $_SESSION['dm_user_profile']['u_pass_word'] =='modir')){	
		
			$out .= '<li><a href="./" class="dir">امكانات</a>
			   <ul>';
			$query='select *	
 	           from dm_um_rel t
			     inner join dm_listmenu l on l.menu_id = t.um_menu_id
			where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
			      l.menu_code = \'410\'';//  and t.can_delete =1';
	   $lnk = mysql_query($query);
			   if ((mysql_num_rows($lnk)>0) || ($_SESSION['dm_user_profile']['u_user_name'] =='modir' && $_SESSION['dm_user_profile']['u_pass_word'] =='modir')){	
				 $out .= '<li><a href="home.php?pg=yearManagement&cmd=CreateNewYearFrm">ايجاد سال جديد</a></li>';}
	 $query='select *	
 	           from dm_um_rel t
			     inner join dm_listmenu l on l.menu_id = t.um_menu_id
			where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
			      l.menu_code = \'411\'';//  and t.can_delete =1';
	   $lnk = mysql_query($query);
			   if ((mysql_num_rows($lnk)>0) || ($_SESSION['dm_user_profile']['u_user_name'] =='modir' && $_SESSION['dm_user_profile']['u_pass_word'] =='modir')){	
				  $out .='<li><a href="home.php?pg=yearManagement&cmd=ListAllYears">ليست سال هاي ايجاد شده</a></li>';}
				  if($_SESSION['dm_user_profile']['u_id']==3){
			   				  $out .='<li><a href="7.php" target="_blank">تنظيم سال جديد</a></li>';}
				  }
				  $query='select *	
 	           from dm_um_rel t
			     inner join dm_listmenu l on l.menu_id = t.um_menu_id
			where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
			      l.menu_code = \'413\'';//  and t.can_delete =1';
				   $lnk = mysql_query($query);
				    if ((mysql_num_rows($lnk)>0) || ($_SESSION['dm_user_profile']['u_user_name'] =='modir' && $_SESSION['dm_user_profile']['u_pass_word'] =='modir')){	
				  $out .='<li><a href="home.php?pg=prodMgmtPg_det&cmd=createFileFrm">ايجاد فايل سند فروش</a></li>';}
				   $out .='<li><a href="home.php?pg=prodMgmtPg_det&cmd=createFileFrmstore">ايجاد فايل انبار</a></li>';
				   $out .='<li><a href="./" class="dir">ايجاد فايل سردخانه</a>
				   <ul>
				   
				   <li><a href="home.php?pg=prodMgmtPg_det&cmd=createFileFrmfrig">حواله ها</a></li>
				   <li><a href="home.php?pg=prodMgmtPg_det&cmd=createFileFrmfrigeb">ابطالي ها</a></li>
				   
				   </ul>
				   </li>
				   
				   ';
		 		          	
				  
			   $out .='</ul>';
	 $query='select *	
 	           from dm_um_rel t
			     inner join dm_listmenu l on l.menu_id = t.um_menu_id
			where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
			      l.menu_code = \'15000\'';//  and t.can_delete =1';
	   $lnk = mysql_query($query);
			   if ((mysql_num_rows($lnk)>0) || ($_SESSION['dm_user_profile']['u_user_name'] =='modir' && $_SESSION['dm_user_profile']['u_pass_word'] =='modir')){	
			    $out .='<li class="dir">مديريت کاربران
						<ul>';
		 $query='select *	
 	           from dm_um_rel t
			     inner join dm_listmenu l on l.menu_id = t.um_menu_id
			where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
			      l.menu_code = \'510\'';//  and t.can_delete =1';
	   $lnk = mysql_query($query);
			   if ((mysql_num_rows($lnk)>0) || ($_SESSION['dm_user_profile']['u_user_name'] =='modir' && $_SESSION['dm_user_profile']['u_pass_word'] =='modir')){	
						    $out .='<li><a href="home.php?pg=prodMgmtPg&cmd=dspInseNewGroupFrm">ايجاد گروه کاربران</a></li>';}
		 $query='select *	
 	           from dm_um_rel t
			     inner join dm_listmenu l on l.menu_id = t.um_menu_id
			where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
			      l.menu_code = \'511\'';//  and t.can_delete =1';
	   $lnk = mysql_query($query);
			   if ((mysql_num_rows($lnk)>0) || ($_SESSION['dm_user_profile']['u_user_name'] =='modir' && $_SESSION['dm_user_profile']['u_pass_word'] =='modir')){	
						    $out .='<li><a href="home.php?pg=prodMgmtPg&cmd=ListAccessMenu">ليست گروه کاربران</a></li>';}
			$query='select *	
 	           from dm_um_rel t
			     inner join dm_listmenu l on l.menu_id = t.um_menu_id
			where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
			      l.menu_code = \'512\'';//  and t.can_delete =1';
	   $lnk = mysql_query($query);
			  if ((mysql_num_rows($lnk)>0) || ($_SESSION['dm_user_profile']['u_user_name'] =='modir' && $_SESSION['dm_user_profile']['u_pass_word'] =='modir')){	
							 $out .='<li><a href="home.php?pg=prodMgmtPg&cmd=dspInseNewUserFrm">ايجاد كاربر جديد</a></li>';}
		 $query='select *	
 	           from dm_um_rel t
			     inner join dm_listmenu l on l.menu_id = t.um_menu_id
			where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
			      l.menu_code = \'513\'';//  and t.can_delete =1';
	   $lnk = mysql_query($query);
			   if ((mysql_num_rows($lnk)>0) || ($_SESSION['dm_user_profile']['u_user_name'] =='modir' && $_SESSION['dm_user_profile']['u_pass_word'] =='modir')){	
							 $out .='<li><a href="home.php?pg=prodMgmtPg&cmd=getUserList">ليست کاربران</a></li>';}
							
						 $out .='</ul>';}
					 $out .='</li>';
					 
					 
					 
			 $query='select *	
 	           from dm_um_rel t
			     inner join dm_listmenu l on l.menu_id = t.um_menu_id
			where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
			      l.menu_code = \'12300\'';//  and t.can_delete =1';
	   $lnk = mysql_query($query);
			   if ((mysql_num_rows($lnk)>0) || ($_SESSION['dm_user_profile']['u_user_name'] =='modir' && $_SESSION['dm_user_profile']['u_pass_word'] =='modir')){	
			    $out .='<li class="dir">پنل مديريت
						<ul>';
		
						    $out .='<li><a href="home.php?pg=prodMgmtPg&cmd=listprod_m">ليست کالاها</a></li>';
			   
			    $out .='</ul>';
					 $out .='</li>';
			   
			   
			   
			   
			   
			   }
					 
					 
					 
					 
					 
					 
					 
					 
					 
					 
					 
					 $query='select *	
 	           from dm_um_rel t
			     inner join dm_listmenu l on l.menu_id = t.um_menu_id
			where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
			      l.menu_code = \'18000\'';//  and t.can_delete =1';
					 $lnk = mysql_query($query);
					    if ((mysql_num_rows($lnk)>0) || ($_SESSION['dm_user_profile']['u_user_name'] =='modir' && $_SESSION['dm_user_profile']['u_pass_word'] =='modir')){	
			 $out .='			
			 </li>  
			<li class="dir">گزارشات
				<ul>
					<li><a href="home.php?pg=reportMgmtPg&cmd=dspReportProdFrm">گزارش آمار فروش كالا</a></li>
				   <li><a href="home.php?pg=reportMgmtPg&cmd=dspReportProdFrmnew">گزارش آمار فروش كالا(جديد)</a></li>
					
					<li><a href="home.php?pg=reportMgmtPg&cmd=dspRepinspectFrm">گزارش حواله براي اداره كل بازرسي</a></li>
					<li><a href="home.php?pg=reportMgmtPg&cmd=dspReportProddayFrm">گزارش اداره دارائى</a></li>
					<li><a href="home.php?pg=reportMgmtPg&cmd=dspReptajamoFrm">گزارش تجمعى </a></li>
			        <li><a href="home.php?pg=reportMgmtPg&cmd=dspReptajamoFrm1"> <font-size="3px;">گزارش تجمعي بر اساس کالا</font> </a></li>';
			 $out .='<li><a href="home.php?pg=reportMgmtPg&cmd=dspReptajamocusFrm">گزارش تجمعی مشتريان </a></li>';
			 
		     $out .='<li><a href="home.php?pg=reportMgmtPg&cmd=dspRepdayfrm">گزارش فروش روزانه </a></li>
					<li><a href="home.php?pg=reportMgmtPg&cmd=dspRepebtalfrm">گزارش حواله ابطالی </a></li>';

			       $out .=' <li><a href="home.php?pg=reportMgmtPg&cmd=dsppffrm">گزارش پيش فاكتور ها </a></li>';
//			 	 $query='select *	
// 	           from dm_um_rel t
//			     inner join dm_listmenu l on l.menu_id = t.um_menu_id
//			where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
//			      l.menu_code = \'18111\'';//  and t.can_delete =1';
//					 $lnk = mysql_query($query);
//					    if ((mysql_num_rows($lnk)>0) || ($_SESSION['dm_user_profile']['u_user_name'] =='modir' && $_SESSION['dm_user_profile']['u_pass_word'] =='modir')){
$out .='<li><a href="home.php?pg=reportMgmtPg&cmd=dspReptajamokFrm"> <font-size="3px;">گزارش تجمعي کلي </font>  </a></li>';	
					$out .='<li><a href="home.php?pg=reportMgmtPg&cmd=dspReptajamokFrm1"> <font-size="3px;">گزارش تجمعي کلي بر اساس کالا </font>  </a></li>';
		//	 }
				$out .='</ul>
			</li>';}
			
			//	print $query;
				 $out .='<span><a href="?pg=prodMgmtPg&cmd=PrivatePanel" ><img src="images/key.png" title="پنل شخصي" width="22" height="22" align="left" "></img></a></span>
				       <span><a href="?pg=home&cmd=wellcome_home.php" ><img src="images/home.PNG" title="صفحه اول" width="22" height="22" align="left" "></img></a></span>
				       <span><a href="?pg=logout_pg&cmd=logMeOut" ><img src="images/exit.PNG" title="خروج" width="20" height="20" align="left" "></img></a></span>';
			
				       $out .=' <span><a href="?pg=prodMgmtPg&cmd=Privatemessage" ><img src="images/mail.PNG" title="پيغام" width="25" height="25" align="left" "></img></a></span>';
				        $out .=' <span><a href="?pg=prodMgmtPg&cmd=setting" ><img src="images/setting.png" title="پيغام" width="25" height="25" align="left" "></img></a></span>';
				       
				      $out .=' <span >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>	
			
				';} else{ $out .='<li><a href="home.php?pg=prodMgmtPg&cmd=ContactUs">تماس با ما</a></li>
				
				';}$out .=(($_SESSION['isLogged']) ? '' : '<li><a href="?pg=login_pg&cmd=dspFrm" >ورود</a>').'</li>
			</ul>';
	
	
	return $out;
}

function dspLoginForm(){
		

?> 

	<br></br>
	<table border="0" align="center" width="100%">
	   <tr>
	     <td width="40%">
		<form method="post" id="commentForm" action="" >
			<input type="hidden" name="pg" value="login_pg">
			<input type="hidden" name="cmd" value="logMeIn">
			 <div align="right">
			
   <table  border="0" style="background-color:#cccccc;" align="right">
          <tr>
          <td colspan="2" style="height:30px;background-color:#aaaaaa;">&nbsp;</td>
          </tr>
            <tr>
          <td colspan="2" style="height:30px;"><hr></hr></td>
          </tr>
		   <tr >
		      <td  width="30%" valign="middle"  align="left"> <span id="Label3" style="display:inline-block;color:black;width:92px;"> نام کاربري :</span></td>
		      <td  align="right" width="70%" align="middle"  ><input type="text" name="u_userName"  style="width:100px;" class="required" ></td>
		   </tr>
		   <tr >
		      <td  width="30%" valign="middle"  align="left"> <span id="Label3" style="display:inline-block;color:black;width:92px;" class="required ">  کلمه عبور :</span></td>
		      <td  align="right" width="70%" align="middle"  ><input type="password" name="u_passWord" style="width:100px;" ></td>     
		   </tr>
		   <tr>
		     <td>&nbsp; &nbsp; &nbsp;</td>                             
		     <td colspan="2" valign="top" style="height: 47px" align="right"><button type="submit" name="Button"  value="ورود"  id="Button1" style="font-size:Medium;font-weight:bold;width:76px;background-color:cccccc;" >ورود </button>   
		    </tr>
		 	   
    </table>

    </div>
	 </td>
	 <td width="100%" align="center">
		 <table border="0" width="25%" >            
             
<!-- 
		   <tr>
		   <td colspan="2"><img src="images/noroz.png" width="200%" "/> 
		   </td>
		     
		   </tr> -->
		   </table>
	
	 </td>
	   
 </tr>
 </table>
	<?php
}
function sqlErr($dummy){
	if($GLOBALS['isDevelopeMode']){
		if(mysql_error()) echo $dummy.': '.mysql_error();
	} 
}
 function isAllowedMenu($menuId)   {
 	if(stristr($_SESSION['dm_user_profile']['u_allowed_menu'], ','.$menuId.','))return true;
 	return false;
 }
 	
function logMeIn(){
	
	$u_user_name = (isset($_REQUEST['u_userName'])) ? trim($_REQUEST['u_userName']) : '';
	$u_pass_word = (isset($_REQUEST['u_passWord'])) ? $_REQUEST['u_passWord'] : '';
	$query1 = "SELECT * FROM  dm_year where
            year_status=1 ";	
		$lnk1 = mysql_query($query1);
	//	print $query1;
		$row1= mysql_fetch_assoc($lnk1);
		$year_id=$row1['year_id'];
	$u_pass_word=md5($u_pass_word);
	$sql = "SELECT * FROM `dm_user_profile` WHERE `u_user_name` = '".$u_user_name."' AND `u_pass_word`='".$u_pass_word."' ";
//	print $sql;
	$lnk = mysql_query($sql);
	sqlErr('#1-01');
	if($u_user_name=='modir' && $u_pass_word=='modir'){
		$_SESSION['isLogged'] = true;
		$_SESSION['dm_user_profile']['u_user_name'] = $u_user_name;
        $_SESSION['dm_user_profile']['u_pass_word'] = $u_pass_word;
        $_SESSION['dm_user_profile']['u_id'] = 1000;
        $_SESSION['dm_user_profile']['u_name'] = 'مديريت';
        $_SESSION['dm_user_profile']['u_province_id'] = 4;	
        $_SESSION['dm_user_profile']['u_year_id'] = 3;
	}
	
	else if(mysql_num_rows($lnk)>0){
		$row = mysql_fetch_assoc($lnk);
		//Logined Ok!
     	$_SESSION['isLogged'] = true;
		$_SESSION['dm_user_profile']['u_user_name'] = $row['u_user_name'];
        $_SESSION['dm_user_profile']['u_name'] = $row['u_name'];
        $_SESSION['dm_user_profile']['u_group_menu_id'] = $row['u_group_menu_id'];		
		$_SESSION['dm_user_profile']['u_province_id'] = $row['u_province_id'];		
		$_SESSION['dm_user_profile']['u_city_id'] = $row['u_city_id'];
		$_SESSION['dm_user_profile']['u_id'] = $row['u_id'];
		$_SESSION['dm_user_profile']['u_year_id'] = $row['u_year_id'];
		$_SESSION['dm_user_profile']['year_id'] = $year_id;
		
		$IP_address = VisitorIP();
		 $query = "
					INSERT INTO dm_user_log 
						(
						
						    `logu_ip`,
							`logu_u_id`, 
							`logu_time`,
							`logu_status`

						)
						
					VALUES
						(
						    '". $IP_address ."', 
							'".$row['u_id']."', 
							 '".gmdate('Y-m-d')."', 
							'" . 1 ."'
								
						)
				";
				$lnk = mysql_query($query);
				if(mysql_error()) print mysql_error();
	
		?>
		<script>
				 window.open('?pg=home&cmd=wellcome_home.php', '_self');
				
		</script>
		<?php 
	}else {
		$_SESSION['isLogged'] = false;		
		?>
		<script>
				 window.open('?pg=login_pg&cmd=dspFrm', '_self');
				 alert('نام كاربري و يا رمز عبور نا معتبر است!');
		</script>
		<?php 
		
		
	}
}
function logout(){
	$IP_address = VisitorIP();
		
	 $query = "
					INSERT INTO dm_user_log 
						(
						
						    `logu_ip`,
							`logu_u_id`, 
							`logu_time`,
							`logu_status`

						)
						
					VALUES
						(
						    '". $IP_address ."', 
							'".$_SESSION['dm_user_profile']['u_id']."', 
							 '".gmdate('Y-m-d')."', 
							'" . 2 ."'
								
						)
				";
				$lnk = mysql_query($query);
				if(mysql_error()) print mysql_error();
	
}

function getPkgTypesComboBox($id='p_pakage_type', $p_pakage_type){
	
	//if($p_pakage_type==0){
		$out = '<select id="'.$id.'" name="'.$id.'"  >';
		$lnk = mysql_query("SELECT * FROM dm_prod_det_p ORDER BY pack_prod_name ");
		if(mysql_num_rows($lnk)>0){
			while($row=mysql_fetch_assoc($lnk)){
				$out .= '<option value="'.$row['pack_prod_id'].'" >'.$row['pack_prod_name'].'</option>';			
			}
//	}
//	}else{
//		
//		$lnk1 = mysql_query("SELECT * FROM dm_prod_det_p where pack_prod_id=". $p_pakage_type."");
//		$row1=mysql_fetch_assoc($lnk1);
//		$out = '<select id="'.$id.'" name="'.$id.'"  ><option value="'.$row1['pack_prod_id'].'">'.$row1['pack_prod_name'].'</option>';
//		$lnk = mysql_query("SELECT  pack_prod_id,pack_prod_name  FROM dm_prod_det_p where  pack_prod_id !=".$row1['pack_prod_id']."");
//		
//		if(mysql_num_rows($lnk)>0){
//			while($row=mysql_fetch_assoc($lnk)){
//				$out .= '<option value="'.$row['pack_prod_id'].'" >'.$row['pack_prod_name'].'</option>';			
//			}
//	}
		
	}
	
	$out .= '</select>';
	return $out;
}

function getProduct($l,$id='p_id', $sCust=false){
	

	$out = '<select id="'.$id.'" name="'.$id.'" onchange="hndlproductComboChng(\'\', this.value)"  ><option value="-2" style="width:80px;" >----</option>';
	$lnk = mysql_query("SELECT * FROM dm_listprod where   p_status=1 ");

	if(mysql_affected_rows()>0){
		while($row=mysql_fetch_assoc($lnk)){
			$out .= '<option value="'.$row['p_id'].'" >'. $row['p_code'].'/'.$row['p_name'].'</option>';
			
		}
	}
	$out .= '</select>';
	return $out;
}
function getProduct1($p_id,$id='p_id', $sCust=false){
	
	$query1="SELECT * FROM dm_product  where p_id= ".$p_id ."  ";
	//print $query1;
	$lnk1 = mysql_query($query1);
	$row1=mysql_fetch_assoc($lnk1);
	
  $lnk2 = mysql_query("SELECT * FROM dm_listprod 
                               where  p_code=".$row1['p_code']."  and  p_status=1 ");
    
  $row2=mysql_fetch_assoc($lnk2);
	
	$out = '<select id="'.$id.'" name="'.$id.'" onchange="hndlproductComboChng(\'\', this.value)"  ><option value="'.$row2['p_id'].'" style="width:80px;" >'.$row2['p_code'].'/'.$row2['p_name'].'</option>';
	$lnk = mysql_query("SELECT * FROM dm_listprod where   p_status=1 ");

	if(mysql_affected_rows()>0){
		while($row=mysql_fetch_assoc($lnk)){
			$out .= '<option value="'.$row['p_id'].'" >'. $row['p_code'].'/'.$row['p_name'].'</option>';
			
		}
	}
	$out .= '</select>';
	return $out;
}



function getPkgTypesComboBoxr($id='p_pakage_type', $sCust=false){
	$out = '<select id="'.$id.'" name="'.$id.'"  ><option value=-2>همه</option>';
	$lnk = mysql_query("SELECT * FROM dm_prod_det_p ORDER BY pack_prod_name");
	if(mysql_num_rows($lnk)>0){
		while($row=mysql_fetch_assoc($lnk)){
			$out .= '<option value="'.$row['pack_prod_id'].'" >'.$row['pack_prod_name'].'</option>';			
		}
	}
	$out .= '</select>';
	return $out;
}
function getdocTypesComboBox($id='d_documentType', $d_documentType){
	
	$lnk1 = mysql_query("SELECT * FROM dm_doc_det_t where doc_t_id_province=".$_SESSION['dm_user_profile']['u_province_id']." AND doc_t_id=".$d_documentType."");
	$row1=mysql_fetch_assoc($lnk1);
	$out = '<select id="'.$id.'" name="'.$id.'"  ><option value="'.$d_documentType.'">'.$row1['doc_t_name'].'</option>';
	$lnk = mysql_query("SELECT doc_t_name,doc_t_id FROM dm_doc_det_t where doc_t_id_province=".$_SESSION['dm_user_profile']['u_province_id']." ORDER BY doc_t_name 	");
	if(mysql_num_rows($lnk)>0){
		while($row=mysql_fetch_assoc($lnk)){
			$out .= '<option value="'.$row['doc_t_id'].'" >'.$row['doc_t_name'].'</option>';			
		}
	}
	$out .= '</select>';
	return $out;
}
function getebtalTypesComboBox($id='reb_id', $sCust=false){
	$out = '<select id="'.$id.'" name="'.$id.'"  >';
	$lnk = mysql_query("SELECT * FROM dm_reason_eb  ORDER BY reb_code 	");
	if(mysql_num_rows($lnk)>0){
		while($row=mysql_fetch_assoc($lnk)){
			$out .= '<option value="'.$row['reb_id'].'" >'. $row['reb_reason'].'</option>';			
		}
	}
	$out .= '</select>';
	return $out;
}
function  getbankTypesComboBox($id='phm_op_id', $sCust=false){
	$out = '<select id="'.$id.'" name="'.$id.'"  ><option value=-2>-----</option>';
	$lnk = mysql_query("SELECT * FROM dm_operation_acc  where 1 ");
	if(mysql_num_rows($lnk)>0){
		while($row=mysql_fetch_assoc($lnk)){
			$out .= '<option value="'.$row['g_id'].'" >'.$row['g_acc_name'].'</option>';			
		}
	}
	$out .= '</select>';
	return $out;
}
function  getopTypesComboBox($id='phm_op_id', $g_id){
	
	$lnk1 = mysql_query("SELECT * FROM dm_operation_acc where g_id=".$g_id." ");
	//print "SELECT * FROM dm_operation_acc where g_id=".$g_id."";
	$row1=mysql_fetch_assoc($lnk1);
	
	$out = '<select id="'.$id.'" name="'.$id.'"  ><option value="'.$g_id.'">'.$row1['g_acc_name'].'</option>';
	$lnk = mysql_query("SELECT * FROM dm_operation_acc  where 1 ");
	if(mysql_num_rows($lnk)>0){
		while($row=mysql_fetch_assoc($lnk)){
			$out .= '<option value="'.$row['g_id'].'" >'.$row['g_acc_name'].'</option>';			
		}
	}
	$out .= '</select>';
	return $out;
}
function getUnitTypesComboBox($id='p_unit', $p_unit){
	
//	if($p_unit==0){
		$out = '<select id="'.$id.'" name="'.$id.'"  >';
		$lnk = mysql_query("SELECT * FROM dm_prod_det_u ORDER BY unit_prod_name ");
		if(mysql_num_rows($lnk)>0){
			while($row=mysql_fetch_assoc($lnk)){
				$out .= '<option value="'.$row['unit_prod_id'].'" >'.$row['unit_prod_name'].'</option>';			
			}
	//}
////	}else{
//		
//		$lnk1 = mysql_query("SELECT * FROM dm_prod_det_u where unit_prod_id=".$p_unit."");
//		$row1=mysql_fetch_assoc($lnk1);
//		$out = '<select id="'.$id.'" name="'.$id.'"  ><option value="'.$row1['unit_prod_id'].'">'.$row1['unit_prod_name'].'</option>';
//		$lnk = mysql_query("SELECT  unit_prod_id,unit_prod_name  FROM dm_prod_det_u where  unit_prod_id !=".$row1['unit_prod_id']."");
//		
//		if(mysql_num_rows($lnk)>0){
//			while($row=mysql_fetch_assoc($lnk)){
//				$out .= '<option value="'.$row['unit_prod_id'].'" >'.$row['unit_prod_name'].'</option>';			
//			}
//	}
		
	}
	
	$out .= '</select>';
	return $out;
}



function getTypesComboBox($id='p_type', $p_type){
	
//	if($p_type==0){
		$out = '<select id="'.$id.'" name="'.$id.'"  >';
		$lnk = mysql_query("SELECT * FROM dm_prod_det_t ORDER BY type_prod_name ");
		if(mysql_num_rows($lnk)>0){
			while($row=mysql_fetch_assoc($lnk)){
				$out .= '<option value="'.$row['type_prod_id'].'" >'.$row['type_prod_name'].'</option>';			
			}
//	}
//	}else{
		
//		$lnk1 = mysql_query("SELECT * FROM dm_prod_det_t where type_prod_id=".$p_type."");
//		$row1=mysql_fetch_assoc($lnk1);
//		$out = '<select id="'.$id.'" name="'.$id.'"  ><option value="'.$row1['type_prod_id'].'">'.$row1['type_prod_name'].'</option>';
//		$lnk = mysql_query("SELECT  type_prod_id,type_prod_name  FROM dm_customer_person where  type_prod_id !=".$p_type."");
//		
//		if(mysql_num_rows($lnk)>0){
//			while($row=mysql_fetch_assoc($lnk)){
//				$out .= '<option value="'.$row['type_prod_id'].'" >'.$row['type_prod_name'].'</option>';			
//			}
//	}
		
	}
	
	$out .= '</select>';
	return $out;
}
function getTypesComboBoxr($id='p_type', $sCust=false){
	$out = '<select id="'.$id.'" name="'.$id.'"  ><option value=-2>همه نوع</option>';
	$lnk = mysql_query("SELECT * FROM dm_prod_det_t ORDER BY type_prod_name");
	if(mysql_num_rows($lnk)>0){
		while($row=mysql_fetch_assoc($lnk)){
			$out .= '<option value="'.$row['type_prod_id'].'" >'.$row['type_prod_name'].'</option>';			
		}
	}
	$out .= '</select>';
	return $out;
}


function getCategoryTypesComboBox($id='p_category', $p_category){
	
//	if($p_category==0){
		$out = '<select id="'.$id.'" name="'.$id.'"  >';
		$lnk = mysql_query("SELECT * FROM dm_prod_det_c ORDER BY cat_prod_name ");
		if(mysql_num_rows($lnk)>0){
			while($row=mysql_fetch_assoc($lnk)){
				$out .= '<option value="'.$row['cat_prod_id'].'" >'.$row['cat_prod_name'].'</option>';			
			}
//	}
//	}else{
//		
//		$lnk1 = mysql_query("SELECT * FROM dm_prod_det_c where cat_prod_id=".$p_category."");
//		$row1=mysql_fetch_assoc($lnk1);
//		$out = '<select id="'.$id.'" name="'.$id.'"  ><option value="'.$row1['cat_prod_id'].'">'.$row1['cat_prod_name'].'</option>';
//		$lnk = mysql_query("SELECT  cat_prod_id,cat_prod_name  FROM dm_prod_det_c where  cat_prod_id !=".$row1['cat_prod_name']."");
//		
//		if(mysql_num_rows($lnk)>0){
//			while($row=mysql_fetch_assoc($lnk)){
//				$out .= '<option value="'.$row['cat_prod_id'].'" >'.$row['cat_prod_name'].'</option>';			
//			}
//	}
		
	}
	
	$out .= '</select>';
	return $out;
}
function getCategoryTypesComboBoxr($id='p_category', $sCust=false){
	$out = '<select id="'.$id.'" name="'.$id.'"  ><option value=-2>همه</option>';
	$lnk = mysql_query("SELECT * FROM dm_prod_det_c ORDER BY cat_prod_name");
	if(mysql_num_rows($lnk)>0){
		while($row=mysql_fetch_assoc($lnk)){
			$out .= '<option value="'.$row['cat_prod_id'].'" >'.$row['cat_prod_name'].'</option>';			
		}
	}
	$out .= '</select>';
	return $out;
}
function getmojopComboBox($id='phm_id', $sCust=false){
	
	$out = '<select id="'.$id.'" name="'.$id.'"   style="width:200px;" ><option value=-2>..........</option>';
	//$S="SELECT * FROM dm_operation_acc WHERE g_acc_org=".$_SESSION['dm_user_profile']['u_province_id']."";
	//print $S;
	$lnk = mysql_query("SELECT * FROM dm_op_mojavez phm left join dm_operation_acc acc 
	     on  phm.phm_op_id=acc.g_id  where  phm_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
	    and
	     
	       '".gmdate('Y-m-d')."'  between  phm_date_f and  phm_date_l    ");

	     

	     
	  
		 

	if(mysql_num_rows($lnk)>0){
		while($row=mysql_fetch_assoc($lnk)){
		
			$out .= '<option value="'.$row['phm_id'].'" >'.$row['g_acc_name'].'/'.$row['phm_mojavez'].'</option>';			
		}
		
	}
	$out .= '</select>';
	
	return $out;
}
function getOperationComboBox($id='ph_operation_id', $sCust=false){
	
	$out = '<select id="'.$id.'" name="'.$id.'"   style="width:280px;" ><option value=-2>..........</option>';
	//$S="SELECT * FROM dm_operation_acc WHERE g_acc_org=".$_SESSION['dm_user_profile']['u_province_id']."";
	//print $S;
	$lnk = mysql_query("SELECT * FROM dm_operation_acc ");
		
	if(mysql_num_rows($lnk)>0){
		while($row=mysql_fetch_assoc($lnk)){
		
			$out .= '<option value="'.$row['g_id'].'" >'.$row['g_acc_name'].'</option>';			
		}
		
	}
	$out .= '</select>';
	
	return $out;
}
function getOperationComboBoxx($id='ph_operation_id', $sCust=false){
	
	$out = '<select id="'.$id.'" name="'.$id.'"  ><option value=-2>همه نوع</option>';
	//$S="SELECT * FROM dm_operation_acc WHERE g_acc_org=".$_SESSION['dm_user_profile']['u_province_id']."";
	//print $S;
	$lnk = mysql_query("SELECT * FROM dm_operation_acc ");
		
	if(mysql_num_rows($lnk)>0){
		while($row=mysql_fetch_assoc($lnk)){
		
			$out .= '<option value="'.$row['g_id'].'" >'.$row['g_acc_name'].'</option>';			
		}
		
	}
	$out .= '</select>';
	
	return $out;
}
function getTypesgroupComboBox($id='p_group_id', $sCust=false){
	
	$out = '<select id="'.$id.'" name="'.$id.'"  >';
	$lnk = mysql_query("SELECT * FROM dm_operation_acc ");
		if(mysql_num_rows($lnk)>0){
		while($row=mysql_fetch_assoc($lnk)){		
		
			$out .= '<option value="'.$row['g_id'].'" >'.$row['g_acc_name'].'</option>';			
		}
		
	}
	$out .= '</select>';
	
	return $out;
}

function convert_charset($item)
    {
        if ($unserialize = unserialize($item))
        {
            foreach ($unserialize as $key => $value)
            {
                $unserialize[$key] = @iconv('windows-1256', 'UTF-8', $value);
            }
            $serialize = serialize($unserialize);
            return $serialize;
        }
        else
        {
            return @iconv('windows-1256', 'UTF-8', $item);
        }
    } 
 
function getPositionUserComboBox($elmName='', $selectedItem=0){
	global $positionTypes;
	$outBx = '<select name="'.$elmName.'" > <option value="0" > --- </option>';
	foreach($positionTypes as $key=>$value){
		$isSel = ($key==$selectedItem) ? ' selected="selected" ' : '';
		$outBx .= '<option value="'.$key.'" '.$isSel.' >'.$value['title'].'</option>';
	}
	$outBx .= '</select>';
	return $outBx;
}
function getActCusComboBox($id='type_activity_customer', $sCust=false){
	$out = '<select id="'.$id.'" name="'.$id.'"  >';
	$lnk = mysql_query("SELECT * FROM  dm_customer_act_t  ORDER BY 	cus_act_name");
	if(mysql_num_rows($lnk)>0){
		while($row=mysql_fetch_assoc($lnk)){
			$out .= '<option value="'.$row['cus_act_id'].'" >'.$row['cus_act_name'].'</option>';			
		}
	}
	$out .= '</select>';
	return $out;
}

function getPositionTypesComboBox($elmName='', $selectedItem=0){

global $PositionTypes;
	$outBx = '<select name="'.$elmName.'" ><option value="0" > --- </option>';
	foreach($PositionTypes as $key=>$value){
		$isSel = ($key==$selectedItem) ? ' selected="selected" ' : '';
		$outBx .= '<option value="'.$key.'" '.$isSel.' >'.$value['title'].'</option>';
	}
	$outBx .= '</select>';
	return $outBx;
}

$GLOBALS['allMenus']=array(
	'100' => 'منوي پايه',
	'110' => 'مشخصات اسناد',
	'120' => 'ايجاد سند جديد',
	'130' => 'ليست اسناد',


);
	
$user1 = ',1,10,';
function getMenuscheckBox($selectedCheckBox=''){
	$out='<div>';
	foreach($GLOBALS['allMenus'] as $key=>$value ){

		$out .='<span style="margin-right:5px;"><input type="checkbox" id="menuChkBx_'.$key.'" name="menuChkBx_'.$key.'"> '.$value.'</span>';
		
	}
	$out .='</div>';
	return $out;
}

function getRedundancyTypesComboBox($elmName='', $selectedItem=0){
	global $p_Redundancy;
	$outBx = '<select name="'.$elmName.'" >';
	foreach($p_Redundancy as $key=>$value){
		$isSel = ($key==$selectedItem) ? ' selected="selected" ' : '';
		$outBx .= '<option value="'.$key.'" '.$isSel.' id="p_redundancy" >'.$value['title'].'</option>';
	}
	$outBx .= '</select>';
	return $outBx;
}


function getSubsidiesTypesComboBox($id='p_subsidies', $p_subsidies){
	
	if($personality_customer==0){
		$out = '<select id="'.$id.'" name="'.$id.'"  >';
		$lnk = mysql_query("SELECT * FROM dm_subsidies ORDER BY sub_name ");
		if(mysql_num_rows($lnk)>0){
			while($row=mysql_fetch_assoc($lnk)){
				$out .= '<option value="'.$row['sub_id'].'" >'.$row['sub_name'].'</option>';			
			}
	}
	}else{
		
		$lnk1 = mysql_query("SELECT * FROM dm_subsidies where sub_id=".$p_subsidies."");
		$row1=mysql_fetch_assoc($lnk1);
		$out = '<select id="'.$id.'" name="'.$id.'"  ><option value="'.$row1['sub_id'].'">'.$row1['sub_name'].'</option>';
		$lnk = mysql_query("SELECT  sub_id,sub_name  FROM dm_subsidies where  sub_id !=".$row1['sub_id']."");
		
		if(mysql_num_rows($lnk)>0){
			while($row=mysql_fetch_assoc($lnk)){
				$out .= '<option value="'.$row['sub_id'].'" >'.$row['sub_name'].'</option>';			
			}
	}
		
	}
	
	$out .= '</select>';
	return $out;
}
function getTypeschargeComboBox($id='p_charge', $sCust=false){
	$out = '<select id="'.$id.'" name="'.$id.'" >';
	$lnk = mysql_query("SELECT * FROM dm_charge ORDER BY ch_name_p");
	if(mysql_num_rows($lnk)>0){
		while($row=mysql_fetch_assoc($lnk)){
			$out .= '<option value="'.$row['ch_id'].'" >'.$row['ch_name_p'].'</option>';			
		}
	}
	$out .= '</select>';
	return $out;
}

function getvalueaddComboBox($id='p_valueadd', $sCust=false){
	$out = '<select id="'.$id.'" name="'.$id.'" >';
	$lnk = mysql_query("SELECT * FROM dm_valueadd ORDER BY val_name");
	
	if(mysql_num_rows($lnk)>0){
		while($row=mysql_fetch_assoc($lnk)){
			$out .= '<option value="'.$row['val_id'].'" >'.$row['val_name'].'</option>';			
		}
	}
	$out .= '</select>';
	return $out;
}
function getUnitpTypesComboBox($elmName='', $selectedItem=0){
	global $p_unit;
	$outBx = '<select name="'.$elmName.'" style="width:100%;">';
	foreach($p_unit as $key=>$value){
		$isSel = ($key==$selectedItem) ? ' selected="selected" ' : '';
		$outBx .= '<option value="'.$key.'" '.$isSel.' id="p_unit" >'.$value['title'].'</option>';
	}
	$outBx .= '</select>';
	return $outBx;
}
function getMasterUnitTypesComboBox($id='unit_prod_master', $sCust=false){
	$out = '<select id="'.$id.'" name="'.$id.'"  style="width:100%;">';
	$lnk = mysql_query("SELECT * FROM dm_prod_det_u 
	                         WHERE unit_prod_type=0  ORDER BY unit_prod_name");
	if(mysql_num_rows($lnk)>0){
		while($row=mysql_fetch_assoc($lnk)){
			$out .= '<option value="'.$row['unit_prod_id'].'" >'.$row['unit_prod_name'].'</option>';			
		}
	}
	$out .= '</select>';
	return $out;
}		
function getUnit_phTypesComboBox($id='phd_id_unit', $sCust=false){
	$out = '<select id="'.$id.'" name="'.$id.'"  style="width:50%;">';
	$lnk = mysql_query("SELECT * FROM dm_prod_det_u 
	                         WHERE unit_prod_type=0  ORDER BY unit_prod_name");
	if(mysql_num_rows($lnk)>0){
		while($row=mysql_fetch_assoc($lnk)){
			$out .= '<option value="'.$row['unit_prod_id'].'" >'.$row['unit_prod_name'].'</option>';			
		}
	}
	$out .= '</select>';
	return $out;
}	
function getSubsidiesTypesComboBoxZ($elmName='p_Subsidies', $selectedItem=0){
	global $p_Subsidies;
	$outBx = '<select name="'.$elmName.'" ><option value="-2" > همه </option>';
	foreach($p_Subsidies as $key=>$value){
		$isSel = ($key==$selectedItem) ? ' selected="selected" ' : '';
		$outBx .= '<option value="'.$key.'" '.$isSel.' >'.$value['title'].'</option>';
	}
	$outBx .= '</select>';
	return $outBx;
}
function getTypesComboBoxZ($elmName='', $selectedItem=0){
	global $p_types;
	$outBx = '<select name="'.$elmName.'" ><option value="-2" > همه  </option>';
	foreach($p_types as $key=>$value){
		$isSel = ($key==$selectedItem) ? ' selected="selected" ' : '';
		$outBx .= '<option value="'.$key.'" '.$isSel.' >'.$value['title'].'</option>';
	}
	$outBx .= '</select>';
	return $outBx;
}


//براي محل هاي تحويل كالا
function  getGoodsTypesComboBox($elmName='', $selectedItem=0){
	global $l_Types;
	$outBx = '<select name="'.$elmName.'" >';
	foreach($l_Types as $key=>$value){
		$isSel = ($key==$selectedItem) ? ' selected="selected" ' : '';
		$outBx .= '<option value="'.$key.'" '.$isSel.' >'.$value['title'].'</option>';
	}
	$outBx .= '</select>';
	return $outBx;
}
function  getDeliveryTypesComboBox($elmName='', $selectedItem=0){
	global $l_delivery;
	$outBx = '<select name="'.$elmName.'" >';
	foreach($l_delivery as $key=>$value){
		$isSel = ($key==$selectedItem) ? ' selected="selected" ' : '';
		$outBx .= '<option value="'.$key.'" '.$isSel.' >'.$value['title'].'</option>';
	}
	$outBx .= '</select>';
	return $outBx;
}
//براي افزودني و كاستني ها


function getChargeTypesComboBox($id='ch_type', $sCust=false){
	$out = '<select id="'.$id.'" name="'.$id.'"  >';
	$lnk = mysql_query("SELECT * FROM  dm_type_charge    ORDER BY 	charge_t_name");
	if(mysql_num_rows($lnk)>0){
		while($row=mysql_fetch_assoc($lnk)){
			$out .= '<option value="'.$row['charge_t_id'].'" >'.$row['charge_t_name'].'</option>';			
		}
	}
	$out .= '</select>';
	return $out;
}
function  getEmergeFactorsTypesComboBox($elmName='', $selectedItem=0){
	global $ch_emerge_factor;
	$outBx = '<select name="'.$elmName.'" ><option value="0" > --- </option>';
	foreach($ch_emerge_factor as $key=>$value){
		$isSel = ($key==$selectedItem) ? ' selected="selected" ' : '';
		$outBx .= '<option value="'.$key.'" '.$isSel.' >'.$value['title'].'</option>';
	}
	$outBx .= '</select>';
	return $outBx;
}
function  getDependancyTypesComboBox($elmName='ch_dependancy', $selectedItem=0){
	global $ch_dependancy;
	$outBx = '<select name="'.$elmName.'" id="'.$elmName.'"  onchange="DisableRelCombo(\'\', this.value)" >';
	foreach($ch_dependancy as $key=>$value){
		$isSel = ($key==$selectedItem) ? ' selected="selected" ' : '';
		$outBx .= '<option value="'.$key.'" '.$isSel.' " id="depend">'.$value['title'].'</option>';
	}
	$outBx .= '</select>';
	return $outBx;
}
function  getpardakhtiTypesComboBox($elmName='d_pardakht_t', $selectedItem=0 ){
	global $d_pardakht_t;
	$outBx = '<select name="'.$elmName.'" id="'.$elmName.'"   onchange="DisableezafidCombo(\'\', this.value)" >';
	foreach($d_pardakht_t as $key=>$value){
		$isSel = ($key==$selectedItem) ? ' selected="selected" ' : '';
		$outBx .= '<option value="'.$key.'" '.$isSel.' "  id="d_pardakht_t">'.$value['title'].'</option>';
	}
	$outBx .= '</select>';
	return $outBx;
}

function  getDependancy_toTypesComboBox($elmName='', $selectedItem=0){
	global $ch_dependancy_to;
	$outBx = '<select name="'.$elmName.'" id="'.$elmName.'" >';
	foreach($ch_dependancy_to as $key=>$value){
		$isSel = ($key==$selectedItem) ? ' selected="selected" ' : '';
		$outBx .= '<option value="'.$key.'" '.$isSel.' >'.$value['title'].'</option>';
	}
	$outBx .= '</select>';
	return $outBx;
}

function  getFactorTypesComboBox($elmName='', $selectedItem=0){
	global $ch_type_redundancy;
	$outBx = '<select name="'.$elmName.'" id="ch_type_redundancy">';
	foreach($ch_type_redundancy as $key=>$value){
		$isSel = ($key==$selectedItem) ? ' selected="selected" ' : '';
		$outBx .= '<option value="'.$key.'" '.$isSel.' >'.$value['title'].'</option>';
	}
	$outBx .= '</select>';
	return $outBx;
}

//اطلاعات مشتريان

function getShareTypesComboBox($id='condition_share_customer', $condition_share_customer){
	
	//if($condition_share_customer==0){
		
		$out = '<select id="'.$id.'" name="'.$id.'"  >';
		$lnk = mysql_query("SELECT * FROM  dm_customer_status_s   ORDER BY 	cus_status_s_name");
		if(mysql_num_rows($lnk)>0){
			while($row=mysql_fetch_assoc($lnk)){
				$out .= '<option value="'.$row['cus_status_s_id'].'" >'.$row['cus_status_s_name'].'</option>';			
			}
	//}
	//}else{
		
	//	$lnk1 = mysql_query("SELECT * FROM  dm_customer_status_s where cus_status_s_id=".$condition_share_customer."");
	//	$row1=mysql_fetch_assoc($lnk1);
	//	$out = '<select id="'.$id.'" name="'.$id.'"  ><option value="">'.$row1['cus_status_s_name'].'</option>';
	//	$lnk = mysql_query("SELECT cus_status_s_id,cus_status_s_name FROM  dm_customer_status_s   cus_status_s_id !=".$condition_share_customer."");
	//	if(mysql_num_rows($lnk)>0){
		//	while($row=mysql_fetch_assoc($lnk)){
		//		$out .= '<option value="'.$row['cus_status_s_id'].'" >'.$row['cus_status_s_name'].'</option>';			
		//	}
	}
	//}
	
	
	$out .= '</select>';
	return $out;
}
function getPayTypesComboBox($id='condition_pay_customer', $condition_pay_customer){
	if($condition_pay_customer==0){
		$out = '<select id="'.$id.'" name="'.$id.'"  >';
		$lnk = mysql_query("SELECT * FROM  dm_customer_pay_t   ORDER BY 	cus_pay_name");
		if(mysql_num_rows($lnk)>0){
			while($row=mysql_fetch_assoc($lnk)){
				$out .= '<option value="'.$row['cus_pay_id'].'" >'.$row['cus_pay_name'].'</option>';			
			}
		}
		
	}else{
		$lnk1 = mysql_query("SELECT * FROM  dm_customer_pay_t  where  cus_pay_id=".$condition_pay_customer."");
		$row1=mysql_fetch_assoc($lnk1);
		$out = '<select id="'.$id.'" name="'.$id.'"  ><option value="'.$condition_pay_customer.'">'.$row1['cus_pay_name'].'</option>';
		$lnk = mysql_query("SELECT cus_pay_id,cus_pay_name FROM  dm_customer_pay_t  where  cus_pay_id !=".$condition_pay_customer."");
		if(mysql_num_rows($lnk)>0){
			while($row=mysql_fetch_assoc($lnk)){
				$out .= '<option value="'.$row['cus_pay_id'].'" >'.$row['cus_pay_name'].'</option>';			
			}
		}
	}
	
	$out .= '</select>';
	return $out;
}

function getActivityTypesComboBox($id='condition_activity_customer', $condition_activity_customer){

	if($condition_activity_customer==0){
		
			$out = '<select id="'.$id.'" name="'.$id.'"  >';
			$lnk = mysql_query("SELECT * FROM dm_customer_status ORDER BY cus_status_name");
			if(mysql_num_rows($lnk)>0){
				while($row=mysql_fetch_assoc($lnk)){
					$out .= '<option value="'.$row['cus_status_id'].'" >'.$row['cus_status_name'].'</option>';			
				}
			}
		
	}else{
		    $lnk1 = mysql_query("SELECT * FROM dm_customer_status where cus_status_id=".$condition_activity_customer."");
		    $row1=mysql_fetch_assoc($lnk1);
			$out = '<select id="'.$id.'" name="'.$id.'"  ><option value="'.$row1['cus_status_id'].'">'.$row1['cus_status_name'].'</option>';
			$lnk = mysql_query("SELECT cus_status_id,cus_status_name FROM dm_customer_status where cus_status_id != ".$condition_activity_customer."");
			if(mysql_num_rows($lnk)>0){
				while($row=mysql_fetch_assoc($lnk)){
					$out .= '<option value="'.$row['cus_status_id'].'" >'.$row['cus_status_name'].'</option>';			
				}
			}
		
	}
	
	$out .= '</select>';
	return $out;
}
function getPersonalityTypesComboBox($id='personality_customer', $personality_customer){
	
	if($personality_customer==0){
		$out = '<select id="'.$id.'" name="'.$id.'"  >';
		$lnk = mysql_query("SELECT cus_person_id,cus_person_name  FROM dm_customer_person ");
		if(mysql_num_rows($lnk)>0){
			while($row=mysql_fetch_assoc($lnk)){
				$out .= '<option value="'.$row['cus_person_id'].'" >'.$row['cus_person_name'].'</option>';			
			}
	}
	}else{
		
		$lnk1 = mysql_query("SELECT * FROM dm_customer_person where cus_person_id=".$personality_customer." ");
		$row1=mysql_fetch_assoc($lnk1);
		$out = '<select id="'.$id.'" name="'.$id.'" " ><option value="'.$row1['cus_person_id'].'">'.$row1['cus_person_name'].'</option>';
		$lnk = mysql_query("SELECT  cus_person_id,cus_person_name  FROM dm_customer_person where  cus_person_id !=".$row1['cus_person_id']."");
		
		if(mysql_num_rows($lnk)>0){
			while($row=mysql_fetch_assoc($lnk)){
				$out .= '<option value="'.$row['cus_person_id'].'" >'.$row['cus_person_name'].'</option>';			
			}
	}
		
	}
	
	$out .= '</select>';
	return $out;
}
function gettypeCustomerNameCombo($id='personality_customer', $sCust=false){
	$out = '<select id="'.$id.'" name="'.$id.'" ><option value="-2" > همه نوع</option>';
	$lnk = mysql_query("SELECT * FROM dm_customer_person ORDER BY cus_person_id");
	if(mysql_num_rows($lnk)>0){
		while($row=mysql_fetch_assoc($lnk)){
			$out .= '<option value="'.$row['cus_person_id'].'" >'.$row['cus_person_name'].'</option>';			
		}
	}
	$out .= '</select>';
	return $out;
}
function getCustomerTypesComboBox($id='type_customer', $category_id){
	if($category_id==0){
		
		$out = '<select id="'.$id.'" name="'.$id.'"  >';
		$lnk = mysql_query("SELECT * FROM dm_customer_category ORDER BY category_name");
		if(mysql_num_rows($lnk)>0){
			while($row=mysql_fetch_assoc($lnk)){
				$out .= '<option value="'.$row['category_id'].'" >'.$row['category_name'].'</option>';			
			}
	}
	}else{
	    $lnk1 = mysql_query("SELECT * FROM dm_customer_category where category_id=".$category_id." ");
	    $row1=mysql_fetch_assoc($lnk1);
		$out = '<select id="'.$id.'" name="'.$id.'"  ><option value="'.$category_id.'">'.$row1['category_name'].'</option>';
		$lnk = mysql_query("SELECT * FROM dm_customer_category where category_id !=".$category_id."");
		if(mysql_num_rows($lnk)>0){
			while($row=mysql_fetch_assoc($lnk)){
				$out .= '<option value="'.$row['category_id'].'" >'.$row['category_name'].'</option>';			
			}
	}
	}
	
	$out .= '</select>';
	return $out;
}
function getActivityDifTypesComboBox($id='type_activity_customer', $type_activity_customer){
	
	if($type_activity_customer==0){
		$out = '<select id="'.$id.'" name="'.$id.'"  >';
		$lnk = mysql_query("SELECT * FROM dm_customer_act_t ORDER BY cus_act_name");
		if(mysql_num_rows($lnk)>0){
			while($row=mysql_fetch_assoc($lnk)){
				$out .= '<option value="'.$row['cus_act_id'].'" >'.$row['cus_act_name'].'</option>';			
			}
		}
		
	}else{
		
		$lnk1 = mysql_query("SELECT * FROM dm_customer_act_t where cus_act_id=".$type_activity_customer."");
		$row1=mysql_fetch_assoc($lnk1);
		$out = '<select id="'.$id.'" name="'.$id.'"  ><option value="'.$type_activity_customer.'">'.$row1['cus_act_name'].'</option>';
		$lnk = mysql_query("SELECT cus_act_id,cus_act_name FROM dm_customer_act_t  where cus_act_id !=".$type_activity_customer."");
		if(mysql_num_rows($lnk)>0){
			while($row=mysql_fetch_assoc($lnk)){
				$out .= '<option value="'.$row['cus_act_id'].'" >'.$row['cus_act_name'].'</option>';			
			}
		}			
	}
	
	$out .= '</select>';
	return $out;
}

function getTitle(){
	global $pg;
	switch ($pg){
		
		case 'dsgfdsa':
			$title= '';
			break;
			
		case 'prodMgmtPg':
			$title= 'ورود اطلاعات جديد';
			break;
			
		default:
			$title = 'سيستم فروش';
	}
	return $title;
}
	//براي امضا

	function showchangingSignatures(){
		
			
	$lnk = mysql_query("SELECT * FROM  dm_signature_g WHERE sig_status=". 1 ." AND  sig_id_province=".$_SESSION['dm_user_profile']['u_province_id'] );
	$w="SELECT * FROM  dm_signature_g WHERE sig_status=". 1 ." AND  sig_id_province=".$_SESSION['dm_user_profile']['u_province_id']."";	
	//print $w;
	$row = mysql_fetch_assoc($lnk);
	?>	
		<form method="post" action="" >	   	
		<input type="hidden" name="pg" value="changingSignatures">   
		<input type="hidden" name="cmd" value="sigEdit">   
		<table  align="center" class="nasi" >
		  	<tr style="background-color:DFF294;">
			     <td colspan="8"  style="height: 50px;vertical-align:middle;"  ><font size="5">امضاهاي مورد استفاده</font></td>
	        </tr>
	        <tr>
	            <td colspan="8"><hr style="color:<?php echo $_SESSION['htablecolor'] ?>;height:40%;"></hr></td>
	        </tr>
	      	<tr>
		       	<td ><center>امضا اول پيش حواله :</center> </td>
		        <td style="color:blue;" ><center><?php echo $row['sig1_ph'] ?></center></td>
				<td ><center>امضا دوم پيش حواله :</center></td>
                <td style="color:blue;" ><center><?php echo  $row['sig2_ph'] ?></center></td>	
	            <td ><center>امضا سوم پيش حواله:</center> </td>
                <td style="color:blue;" ><center><?php echo $row['sig3_ph'] ?></center></td>
                
   	        </tr>
   	        <tr>
		       	<td ><center>عنوان امضا اول پيش حواله:</center> </td>
		        <td style="color:blue;" ><center><?php echo $row['sigs1_ph'] ?></center></td>
				<td ><center>عنوان امضا دوم پيش حواله:</center></td>
                <td style="color:blue;" ><center><?php echo  $row['sigs2_ph'] ?></center></td>	
	            <td ><center>عنوان امضا سوم پيش حواله:</center> </td>
                <td style="color:blue;" ><center><?php echo $row['sigs3_ph'] ?></center></td>
                
   	        </tr>
   	        
   	        
	        <tr>
	            <td ><center>امضا اول پيش فاکتور: </center> </td>
                <td style="color:blue;"><?php echo $row['sig1_pf'] ?></td>			
             	<td >امضا دوم پيش فاکتور :</td>
                <td style="color:blue;"><?php echo  $row['sig2_pf'] ?></td>
		        <td >امضا سوم پيش فاکتور :</td>
                <td style="color:blue;"><?php echo $row['sig3_pf'] ?></td>
               
   	        </tr>
   	        <tr>
	            <td ><center>عنوان امضا اول پيش فاكتور: </center> </td>
                <td style="color:blue;"><?php echo $row['sigs1_pf'] ?></td>			
             	<td >عنوان امضا دوم پيش فاكتور :</td>
                <td style="color:blue;"><?php echo  $row['sigs2_pf'] ?></td>
		        <td >عنوان امضا سوم پيش فاكتور :</td>
                <td style="color:blue;"><?php echo $row['sigs3_pf'] ?></td>
               
   	        </tr>		       
	      	<tr>
		        <td ><center>امضا اول فاکتور:</center> </td>
                <td style="color:blue;"><?php echo $row['sig1_f'] ?></td>	
				<td >امضا دوم  فاکتور :</td>
                <td style="color:blue;"><?php echo $row['sig2_f'] ?></td>
 		        <td >امضا سوم  فاکتور: </td>
                <td style="color:blue;"><?php echo $row['sig3_f'] ?></td>
                
   	        </tr>
   	        <tr>
		        <td ><center>عنوان امضا اول فاكتور:</center> </td>
                <td style="color:blue;"><?php echo $row['sigs1_f'] ?></td>	
				<td >عنوان امضا دوم فاكتور :</td>
                <td style="color:blue;"><?php echo $row['sigs2_f'] ?></td>
 		        <td >عنوان امضا سوم فاكتور: </td>
                <td style="color:blue;"><?php echo $row['sigs3_f'] ?></td>
                
   	        </tr>	
	      	<tr>
		        <td ><center>امضا اول حواله :</center> </td>
		        <td style="color:blue;"><?php echo $row['sig1_h'] ?></td>
				<td >امضا دوم  حواله :</td>
                <td style="color:blue;"><?php echo $row['sig2_h'] ?></td>
		        <td >امضا سوم  حواله :</td>
		        <td style="color:blue;"><?php echo $row['sig3_h'] ?></td>
		       
   	        </tr>
   	        <tr>
		        <td ><center>عنوان امضا اول حواله :</center> </td>
		        <td style="color:blue;"><?php echo $row['sigs1_h'] ?></td>
				<td >عنوان امضا دوم حواله :</td>
                <td style="color:blue;"><?php echo $row['sigs2_h'] ?></td>
		        <td >عنوان امضا سوم حواله :</td>
		        <td style="color:blue;"><?php echo $row['sigs3_h'] ?></td>
		       
   	        </tr>
   	         <tr>
		       	<td ><center>امضا اول معرفي نامه :</center> </td>
		        <td style="color:blue;" ><center><?php echo $row['sig1_m'] ?></center></td>
				<td ><center>امضا دوم معرفي نامه :</center></td>
                <td style="color:blue;" ><center><?php echo  $row['sig2_m'] ?></center></td>	
	            <td ><center>امضا سوم معرفي نامه:</center> </td>
                <td style="color:blue;" ><center><?php echo $row['sig3_m'] ?></center></td>
                
   	        </tr>
   	        <tr>
		       	<td ><center>عنوان امضا اول معرفي نامه :</center> </td>
		        <td style="color:blue;" ><center><?php echo $row['sigs1_m'] ?></center></td>
				<td ><center>عنوان امضا دوم معرفي نامه :</center></td>
                <td style="color:blue;" ><center><?php echo  $row['sigs2_m'] ?></center></td>	
	            <td ><center>عنوان امضا سوم معرفي نامه:</center> </td>
                <td style="color:blue;" ><center><?php echo $row['sigs3_m'] ?></center></td>
                
   	        </tr>
   	        <tr>
		        <td ><center>امضا اول ابطال حواله :</center> </td>
		        <td style="color:blue;"><?php echo $row['sig1_eb'] ?></td>
				<td >امضا دوم ابطال حواله :</td>
                <td style="color:blue;"><?php echo $row['sig2_eb'] ?></td>
		        <td >امضا سوم ابطال حواله :</td>
		        <td style="color:blue;"><?php echo $row['sig3_eb'] ?></td>
		       
   	        </tr>
   	        <tr>
		        <td ><center>عنوان امضا اول ابطال  حواله :</center> </td>
		        <td style="color:blue;"><?php echo $row['sigs1_eb'] ?></td>
				<td >عنوان امضا دوم ابطال حواله :</td>
                <td style="color:blue;"><?php echo $row['sigs2_eb'] ?></td>
		        <td >عنوان امضا سوم ابطال حواله :</td>
		        <td style="color:blue;"><?php echo $row['sigs3_eb'] ?></td>
		       
   	        </tr>
   	        <tr>
   	            <td colspan="6"><hr></hr></td>
   	        </tr>
   	        <tr>
   	             <td ><center>توضيح پيش حواله:</center> </td>
                 <td style="color:blue;" colspan="2"><center><?php echo $row['text_ph'] ?></center></td>
                 <td ><center>توضيح پيش فاكتور:</center> </td>
                 <td style="color:blue;" colspan="2"><center><?php echo $row['text_pf'] ?></center></td>               
		     </tr>
		    
		     <tr>
		         <td ><center>توضيح فاكتور:</center> </td>
                 <td style="color:blue;" colspan="2"><center><?php echo $row['text_f'] ?></center></td>
                 <td ><center>توضيح  حواله:</center> </td>
                 <td style="color:blue;" colspan="2"><center><?php echo $row['text_h'] ?></center></td>
		     </tr>
			  <tr>	
				  <td ><center>توضيح معرفي نامه:</center> </td>
                  <td style="color:blue;" colspan="2"><center><?php echo $row['text_m'] ?></center></td>
                  <td ><center>توضيح ابطال حواله:</center> </td>
                  <td style="color:blue;" colspan="2"><center><?php echo $row['text_eb'] ?></center></td>				      
			      				         
	      	</tr>
	      	<tr>	
			      <td colspan="3"> <button name="subject" type="submit"   value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF" > ويرايش</button></td>                       
				  <td colspan="1">&nbsp;&nbsp;&nbsp;</td>				         
	      	</tr>
	    </table>
	</form>
	
	<?php
	}
	function showchangingSignatures_o(){
			
	$lnk = mysql_query("SELECT * FROM  dm_signature_o WHERE sig_ostatus=". 1 ." AND  sig_oid_province=".$_SESSION['dm_user_profile']['u_province_id'] );	
	$row = mysql_fetch_assoc($lnk);
	?>	
		<form method="post" action="" >	   	
		<input type="hidden" name="pg" value="changingSignatures">   
		<input type="hidden" name="cmd" value="sigEdit_o">   
		<table  align="center" class="nasi" >
		  	<tr style="background-color:<?php echo $_SESSION['htablecolor'] ?>;">
			     <td colspan="8"  style="height: 50px;vertical-align:middle;"  ><font size="5">امضاهاي مورد استفاده</font></td>
	        </tr>
	        <tr>
	            <td colspan="8"><hr style="color:<?php echo $_SESSION['htablecolor'] ?>;height:40%;"></hr></td>
	        </tr>
	      	
	      	<tr>
		        <td ><center>امضا اول حواله :</center> </td>
		        <td style="color:blue;"><?php echo $row['sig1_oh'] ?></td>
				<td >امضا دوم  حواله :</td>
                <td style="color:blue;"><?php echo $row['sig2_oh'] ?></td>
		        <td >امضا سوم  حواله :</td>
		        <td style="color:blue;"><?php echo $row['sig3_oh'] ?></td>
		       
   	        </tr>
   	        <tr>
		        <td ><center>عنوان امضا اول حواله :</center> </td>
		        <td style="color:blue;"><?php echo $row['sigs1_oh'] ?></td>
				<td >عنوان امضا دوم حواله :</td>
                <td style="color:blue;"><?php echo $row['sigs2_oh'] ?></td>
		        <td >عنوان امضا سوم حواله :</td>
		        <td style="color:blue;"><?php echo $row['sigs3_oh'] ?></td>
   	        </tr>
			<tr>	
			    <td >توضيح حواله :</td>
		        <td style="color:blue;"><?php echo $row['text_oh'] ?></td>				
				  <td colspan="1">&nbsp;&nbsp;&nbsp;</td>				         
	      	</tr>
	      	<tr>
		        <td ><center>امضا اول ابطالي حواله :</center> </td>
		        <td style="color:blue;"><?php echo $row['sig1_oeb'] ?></td>
				<td >امضا دوم ابطالي حواله :</td>
                <td style="color:blue;"><?php echo $row['sig2_oeb'] ?></td>
		        <td >امضا سوم ابطالي حواله :</td>
		        <td style="color:blue;"><?php echo $row['sig3_oeb'] ?></td>
		       
   	        </tr>
   	        <tr>
		        <td ><center>عنوان امضا اول ابطالي حواله :</center> </td>
		        <td style="color:blue;"><?php echo $row['sigs1_oeb'] ?></td>
				<td >عنوان امضا دوم ابطالي حواله :</td>
                <td style="color:blue;"><?php echo $row['sigs2_oeb'] ?></td>
		        <td >عنوان امضا سوم ابطالي حواله :</td>
		        <td style="color:blue;"><?php echo $row['sigs3_oeb'] ?></td>
   	        </tr>
			<tr>	
			    <td >توضيح ابطالي حواله :</td>
		        <td style="color:blue;"><?php echo $row['text_oeb'] ?></td>				
			      <td colspan="3"> <button name="subject" type="submit"   value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF" > ويرايش</button></td>                       
				  <td colspan="1">&nbsp;&nbsp;&nbsp;</td>				         
	      	</tr>
	    </table>
	</form>
	
	<?php
	}
function  sigEdit(){
	
	$lnk = mysql_query("SELECT * FROM  dm_signature_g WHERE sig_status=". 1 ." AND sig_id_province=".$_SESSION['dm_user_profile']['u_province_id']."");
	
		$row = mysql_fetch_assoc($lnk);
	?>	
		<form method="post" action="" >
	   	
		<input type="hidden" name="pg" value="changingSignatures">   
		<input type="hidden" name="cmd" value="UpEdit">   
		<table  align="center" class="nasi" >
		  	<tr style="background-color:<?php echo $_SESSION['htablecolor'] ?>;">
			     <td colspan="11"  style="height: 50px;vertical-align:middle;"  ><font size="5">امضاهاي مورد استفاده</font></td>
	        </tr>
	         <tr>
	            <td colspan="8"><hr style="color:<?php echo $_SESSION['htablecolor'] ?>;height:40%;"></hr></td>
	        </tr>
	      	<tr>
		       	<td ><center>امضا اول پيش حواله :</center> </td>
		       	 <td><input name="sig1_ph" id="sig1_ph" type="text" value="<?php echo $row['sig1_ph']; ?>" /></td>
		     
				<td ><center>امضا دوم پيش حواله :</center></td>
		       	 <td><input name="sig2_ph" id="sig2_ph" type="text" value="<?php echo $row['sig2_ph']; ?>" /></td>
	            <td ><center>امضا سوم پيش حواله:</center> </td>
		       	<td><input name="sig3_ph" id="sig3_ph" type="text" value="<?php echo $row['sig3_ph']; ?>" /></td>
		       	
   	        </tr>
   	        <tr>
		       	<td ><center>عنوان امضا اول پيش حواله :</center> </td>
		       	 <td><input name="sigs1_ph" id="sigs1_ph" type="text" value="<?php echo $row['sigs1_ph']; ?>" /></td>
		     
				<td ><center>عنوان امضا دوم پيش حواله :</center></td>
		       	 <td><input name="sigs2_ph" id="sig2s_ph" type="text" value="<?php echo $row['sigs2_ph']; ?>" /></td>
	            <td ><center>عنوان امضا سوم پيش حواله:</center> </td>
		       	<td><input name="sigs3_ph" id="sigs3_ph" type="text" value="<?php echo $row['sigs3_ph']; ?>" /></td>
		       	
   	        </tr>
	        <tr>
	             <td ><center>امضا اول پيش فاکتور: </center> </td>
		       	 <td><input name="sig1_pf" id="sig1_pf" type="text" value="<?php echo $row['sig1_pf']; ?>" /></td>
             	 <td >امضا دوم پيش فاکتور :</td>
		       	 <td><input name="sig2_pf" id="sig2_pf" type="text" value="<?php echo $row['sig2_pf']; ?>" /></td>
		         <td >امضا سوم پيش فاکتور :</td>
		       	 <td><input name="sig3_pf" id="sig3_pf" type="text" value="<?php echo $row['sig3_pf']; ?>" /></td>
		       	
 	        </tr>
 	        <tr>
	             <td ><center>عنوان امضا اول پيش فاكتور: </center> </td>
		       	 <td><input name="sigs1_pf" id="sigs1_pf" type="text" value="<?php echo $row['sigs1_pf']; ?>" /></td>
             	 <td >عنوان امضا دوم پيش فاكتور :</td>
		       	 <td><input name="sigs2_pf" id="sigs2_pf" type="text" value="<?php echo $row['sigs2_pf']; ?>" /></td>
		         <td >عنوان امضا سوم پيش فاكتور :</td>
		       	 <td><input name="sigs3_pf" id="sigs3_pf" type="text" value="<?php echo $row['sigs3_pf']; ?>" /></td>
		       	
 	        </tr>
	      	<tr>
		        <td ><center>امضا اول فاکتور:</center> </td>
		       	<td><input name="sig1_f" id="sig1_f" type="text" value="<?php echo $row['sig1_f']; ?>" /></td>
				<td >امضا دوم  فاکتور :</td>
		       	<td><input name="sig2_f" id="sig2_f" type="text" value="<?php echo $row['sig2_f']; ?>" /></td>
 		        <td >امضا سوم  فاکتور: </td>
		       	<td><input name="sig3_f" id="sig3_f" type="text" value="<?php echo $row['sig3_f']; ?>" /></td>
		       
	        </tr>
	        <tr>
		        <td ><center>عنوان امضا اول فاكتور:</center> </td>
		       	<td><input name="sigs1_f" id="sigs1_f" type="text" value="<?php echo $row['sigs1_f']; ?>" /></td>
				<td >عنوان امضا دوم فاكتور :</td>
		       	<td><input name="sigs2_f" id="sigs2_f" type="text" value="<?php echo $row['sigs2_f']; ?>" /></td>
 		        <td >عنوان امضا سوم فاكتور: </td>
		       	<td><input name="sigs3_f" id="sigs3_f" type="text" value="<?php echo $row['sigs3_f']; ?>" /></td>
		       
	        </tr>
	      	<tr>
		        <td ><center>امضا اول حواله :</center> </td>
		       <td><input name="sig1_h" id="sig1_h" type="text" value="<?php echo $row['sig1_h']; ?>" /></td>
				<td >امضا دوم  حواله :</td>
		        <td><input name="sig2_h" id="sig2_h" type="text" value="<?php echo $row['sig2_h']; ?>" /></td>
		        <td >امضا سوم  حواله :</td>
		       	<td><input name="sig3_h" id="sig3_h" type="text" value="<?php echo $row['sig3_h']; ?>" /></td>		       	
		     </tr>
		     <tr>
		        <td ><center>عنوان امضا اول حواله :</center> </td>
		       <td><input name="sigs1_h" id="sig1_h" type="text" value="<?php echo $row['sigs1_h']; ?>" /></td>
				<td >عنوان امضا دوم حواله :</td>
		        <td><input name="sigs2_h" id="sig2_h" type="text" value="<?php echo $row['sigs2_h']; ?>" /></td>
		        <td >عنوان امضا سوم حواله:</td>
		       	<td><input name="sigs3_h" id="sig3_h" type="text" value="<?php echo $row['sigs3_h']; ?>" /></td>		       	
		     </tr>
		     <tr>
		        <td ><center>امضا اول ابطال حواله :</center> </td>
		       <td><input name="sig1_eb" id="sig1_eb" type="text" value="<?php echo $row['sig1_eb']; ?>" /></td>
				<td >امضا دوم ابطال حواله :</td>
		        <td><input name="sig2_eb" id="sig2_eb" type="text" value="<?php echo $row['sig2_eb']; ?>" /></td>
		        <td >امضا سوم ابطال حواله :</td>
		       	<td><input name="sig3_eb" id="sig3_eb" type="text" value="<?php echo $row['sig3_eb']; ?>" /></td>		       	
		     </tr>
		     <tr>
		        <td ><center>عنوان امضا اول ابطال حواله :</center> </td>
		       <td><input name="sigs1_h" id="sigs1_eb" type="text" value="<?php echo $row['sigs1_eb']; ?>" /></td>
				<td >عنوان امضا اول ابطال حواله :</td>
		        <td><input name="sigs2_eb" id="sig2_eb" type="text" value="<?php echo $row['sigs2_eb']; ?>" /></td>
		        <td >عنوان امضا اول ابطال حواله:</td>
		       	<td><input name="sigs3_eb" id="sig3_eb" type="text" value="<?php echo $row['sigs3_eb']; ?>" /></td>		       	
		     </tr>
		     <tr>
		        <td ><center>امضا اول معرفي نامه :</center> </td>
		       <td><input name="sig1_m" id="sig1_m" type="text" value="<?php echo $row['sig1_m']; ?>" /></td>
				<td >امضا دوم  معرفي نامه :</td>
		        <td><input name="sig2_m" id="sig2_m" type="text" value="<?php echo $row['sig2_m']; ?>" /></td>
		        <td >امضا سوم  معرفي نامه :</td>
		       	<td><input name="sig3_m" id="sig3_m" type="text" value="<?php echo $row['sig3_m']; ?>" /></td>	       	
		     </tr>
		     <tr>
		        <td ><center>عنوان امضا اول معرفي نامه :</center> </td>
		       <td><input name="sigs1_m" id="sigs1_m" type="text" value="<?php echo $row['sigs1_m']; ?>" /></td>
				<td >عنوان امضا دوم معرفي نامه :</td>
		        <td><input name="sigs2_m" id="sigs2_m" type="text" value="<?php echo $row['sigs2_m']; ?>" /></td>
		        <td >عنوان امضا سوم معرفي نامه :</td>
		       	<td><input name="sigs3_m" id="sigs3_m" type="text" value="<?php echo $row['sigs3_m']; ?>" /></td>	       	
		     </tr>
		     <tr>
		         <td colspan="6"> <hr></hr><hr></hr></td>
		     </tr>
		     <tr>
		         <td ><center>توضيح پيش حواله:</center> </td>
		         <td colspan="2" ><input name="text_ph" id="text_ph"  value="<?php echo $row['text_ph']; ?>" /></input ></td>
		       	 <td ><center>توضيح پيش فاكتور:</center> </td>
		         <td colspan="2" ><input name="text_pf" id="text_pf"  value="<?php echo $row['text_pf']; ?>" /></input ></td>
		     </tr>
		     
		     <tr>
		         <td ><center>توضيح فاكتور:</center> </td>
		         <td colspan="2"><input name="text_f" id="text_f"  value="<?php echo $row['text_f']; ?>" /></input ></td>
		         <td ><center>توضيح حواله:</center> </td>
		         <td colspan="2"><input name="text_h" id="text_h"  value="<?php echo $row['text_h']; ?>" /></input ></td>
		     </tr>
			 <tr>	      
				 <td ><center>توضيح معرفي نامه:</center> </td>
		         <td colspan="2"><input name="text_m" id="text_m"  value="<?php echo $row['text_m']; ?>" /></input ></td>	
		         <td ><center>توضيح ابطال حواله:</center> </td>
		         <td colspan="2"><input name="text_eb" id="text_h"  value="<?php echo $row['text_eb']; ?>" /></input ></td>			      
			     <td colspan="3"> <button name="subject" type="submit"   value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF" > ذخيره</button></td>     								        
	      	</tr>
	      	 <tr>	      
				 
			     <td colspan="3"> <button name="subject" type="submit"   value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF" > ذخيره</button></td>     								        
	      	</tr>
	    </table>
	</form>
	
	<?php 
}
function  sigEdit_o(){
	
	$lnk = mysql_query("SELECT * FROM  dm_signature_o WHERE sig_ostatus=". 1 ." AND sig_oid_province=".$_SESSION['dm_user_profile']['u_province_id']."");
	
		$row = mysql_fetch_assoc($lnk);
	?>	
		<form method="post" action="" >
	   	
		<input type="hidden" name="pg" value="changingSignatures">   
		<input type="hidden" name="cmd" value="UpEdit_o">   
		<table  align="center" class="nasi" >
		  	<tr style="background-color:<?php echo $_SESSION['htablecolor'] ?>;">
			     <td colspan="11"  style="height: 50px;vertical-align:middle;"  ><font size="5">امضاهاي مورد استفاده كالاي علوفه اى</font></td>
	        </tr>
	         <tr>
	            <td colspan="8"><hr style="color:<?php echo $_SESSION['htablecolor'] ?>;height:40%;"></hr></td>
	        </tr>	      	
	      	<tr>
		        <td ><center>امضا اول حواله :</center> </td>
		       <td><input name="sig1_oh"  id="sig1_oh" type="text" value="<?php echo $row['sig1_oh']; ?>" /></td>
				<td >امضا دوم  حواله :</td>
		        <td><input name="sig2_oh"  id="sig2_oh" type="text" value="<?php echo $row['sig2_oh']; ?>" /></td>
		        <td >امضا سوم  حواله :</td>
		       	<td><input name="sig3_oh"  id="sig3_oh" type="text" value="<?php echo $row['sig3_oh']; ?>" /></td>		       	
		     </tr>
		     <tr>
		        <td ><center>عنوان امضا اول حواله :</center> </td>
		       <td><input name="sigs1_oh"  id="sig1_oh" type="text" value="<?php echo $row['sigs1_oh']; ?>" /></td>
				<td >عنوان امضا دوم حواله :</td>
		        <td><input name="sigs2_oh"  id="sig2_oh" type="text" value="<?php echo $row['sigs2_oh']; ?>" /></td>
		        <td >عنوان امضا سوم حواله:</td>
		       	<td><input name="sigs3_oh"  id="sig3_oh" type="text" value="<?php echo $row['sigs3_oh']; ?>" /></td>		       	
		     </tr>

			 <tr>	      
				  <td >توضيح حواله:</td>
		       	<td><input name="text_oh"  id="text_oh" type="text" value="<?php echo $row['text_oh']; ?>" /></td>		       	
	      	</tr>
	      	<tr>
		        <td ><center>امضا اول ابطال حواله :</center> </td>
		       <td><input name="sig1_oeb"  id="sig1_oeb" type="text" value="<?php echo $row['sig1_oeb']; ?>" /></td>
				<td >امضا دوم ابطال حواله :</td>
		        <td><input name="sig2_oeb"  id="sig2_oeb" type="text" value="<?php echo $row['sig2_oeb']; ?>" /></td>
		        <td >امضا سوم ابطال حواله :</td>
		       	<td><input name="sig3_oeb"  id="sig3_oeb" type="text" value="<?php echo $row['sig3_oeb']; ?>" /></td>		       	
		     </tr>
		     <tr>
		        <td ><center>عنوان امضا اول ابطال حواله :</center> </td>
		       <td><input name="sigs1_oeb"  id="sig1_oeb" type="text" value="<?php echo $row['sigs1_oeb']; ?>" /></td>
				<td >عنوان امضا اول ابطال حواله :</td>
		        <td><input name="sigs2_oeb"  id="sig2_oeb" type="text" value="<?php echo $row['sigs2_oeb']; ?>" /></td>
		        <td >عنوان امضا اول ابطال حواله:</td>
		       	<td><input name="sigs3_oeb"  id="sig3_oeb" type="text" value="<?php echo $row['sigs3_oeb']; ?>" /></td>		       	
		     </tr>

			 <tr>	      
				  <td >توضيح حواله:</td>
		       	<td><input name="text_oeb"  id="text_oeb" type="text" value="<?php echo $row['text_oeb']; ?>" /></td>		       	
			     <td colspan="3"> <button name="subject" type="submit"   value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF" > ذخيره</button></td>     								        
	      	</tr>
	    </table>
	</form>
	
	<?php 
}
	 function editSignaturesOrder(){
	 	$signature_id = isset($_REQUEST['signature_id']) ? (int)($_REQUEST['signature_id']) : 0;
	
	
	$lnk = mysql_query("SELECT * FROM dm_signature_g WHERE signature_id=".$signature_id);
	if(mysql_num_rows($lnk)>0){
		$row = mysql_fetch_assoc($lnk);
		
	}else{
		die('Invalid product id2!');
	}
//baraye menu
	
		?>
	

<form method="post" action="" >
   	
	<input type="hidden" name="pg" value="changingSignatures">   
	<input type="hidden" name="cmd" value="upSignaturesOrder">   
	<input type="hidden" name="signature_id" value="<?php echo $signature_id; ?>">   
	<table  bgcolor="#99B3E9" align="center" border="2">
	  	<tr align="center">
	        <td colspan="6" align="center" >افرادي كه زير فرم پيش حواله را بايد امضا كنند</td>
        </tr>
      	<tr>
	       	<td ><center>امور انبارها </center> </td>
	        <td><input name="storage_preorder" type="text" value="<?php echo $row['storage_preorder']; ?>" /></td>
			
        </tr>
      	<tr>
      		   <td colspan="3"><input type="submit" value="تاييد" ></td>
      	</tr>
    </table>
    <hr>
</form>

<?php
}
function UpEdit(){
//		$signature_id = isset($_REQUEST['signature_id']) ? (int)($_REQUEST['signature_id']) : 0;
//	if($signature_id<1) die('Inv Id');

	$sig1_ph = isset($_REQUEST['sig1_ph']) ? $_REQUEST['sig1_ph'] : '';
	$sig2_ph= isset($_REQUEST['sig2_ph']) ? ($_REQUEST['sig2_ph']) : '';
	$sig3_ph= isset($_REQUEST['sig3_ph']) ? ($_REQUEST['sig3_ph']) : '';
	$sigs1_ph = isset($_REQUEST['sigs1_ph']) ? $_REQUEST['sigs1_ph'] : '';
	$sigs2_ph= isset($_REQUEST['sigs2_ph']) ? ($_REQUEST['sigs2_ph']) : '';
	$sigs3_ph= isset($_REQUEST['sigs3_ph']) ? ($_REQUEST['sigs3_ph']) : '';
	$text_ph= isset($_REQUEST['text_ph']) ? ($_REQUEST['text_ph']) : '';
	$sig1_pf = isset($_REQUEST['sig1_pf']) ? $_REQUEST['sig1_pf'] : '';
	$sig2_pf= isset($_REQUEST['sig2_pf']) ? ($_REQUEST['sig2_pf']) : '';
	$sig3_pf= isset($_REQUEST['sig3_pf']) ? ($_REQUEST['sig3_pf']) : '';
	$sigs1_pf = isset($_REQUEST['sigs1_pf']) ? $_REQUEST['sigs1_pf'] : '';
	$sigs2_pf= isset($_REQUEST['sigs2_pf']) ? ($_REQUEST['sigs2_pf']) : '';
	$sigs3_pf= isset($_REQUEST['sigs3_pf']) ? ($_REQUEST['sigs3_pf']) : '';
	$text_pf= isset($_REQUEST['text_pf']) ? ($_REQUEST['text_pf']) : '';
	$sig1_h = isset($_REQUEST['sig1_h']) ? $_REQUEST['sig1_h'] : '';
	$sig2_h= isset($_REQUEST['sig2_h']) ? ($_REQUEST['sig2_h']) : '';
	$sig3_h= isset($_REQUEST['sig3_h']) ? ($_REQUEST['sig3_h']) : '';
	$sigs1_h = isset($_REQUEST['sigs1_h']) ? $_REQUEST['sigs1_h'] : '';
	$sigs2_h= isset($_REQUEST['sigs2_h']) ? ($_REQUEST['sigs2_h']) : '';
	$sigs3_h= isset($_REQUEST['sigs3_h']) ? ($_REQUEST['sigs3_h']) : '';
	$text_h= isset($_REQUEST['text_h']) ? ($_REQUEST['text_h']) : '';
	$sig1_f = isset($_REQUEST['sig1_f']) ? $_REQUEST['sig1_f'] : '';
	$sig2_f= isset($_REQUEST['sig2_f']) ? ($_REQUEST['sig2_f']) : '';
	$sig3_f= isset($_REQUEST['sig3_f']) ? ($_REQUEST['sig3_f']) : '';
	$sigs1_f = isset($_REQUEST['sigs1_f']) ? $_REQUEST['sigs1_f'] : '';
	$sigs2_f= isset($_REQUEST['sigs2_f']) ? ($_REQUEST['sigs2_f']) : '';
	$sigs3_f= isset($_REQUEST['sigs3_f']) ? ($_REQUEST['sigs3_f']) : '';
	$text_f= isset($_REQUEST['text_f']) ? ($_REQUEST['text_f']) : '';
	$sig1_m = isset($_REQUEST['sig1_m']) ? $_REQUEST['sig1_m'] : '';
	$sig2_m= isset($_REQUEST['sig2_m']) ? ($_REQUEST['sig2_m']) : '';
	$sig3_m= isset($_REQUEST['sig3_m']) ? ($_REQUEST['sig3_m']) : '';
	$sigs1_m = isset($_REQUEST['sigs1_m']) ? $_REQUEST['sigs1_m'] : '';
	$sigs2_m= isset($_REQUEST['sigs2_m']) ? ($_REQUEST['sigs2_m']) : '';
	$sigs3_m= isset($_REQUEST['sigs3_m']) ? ($_REQUEST['sigs3_m']) : '';
	$text_m= isset($_REQUEST['text_m']) ? ($_REQUEST['text_m']) : '';
	
	$sig1_eb = isset($_REQUEST['sig1_eb']) ? $_REQUEST['sig1_eb'] : '';
	$sig2_eb= isset($_REQUEST['sig2_eb']) ? ($_REQUEST['sig2_eb']) : '';
	$sig3_eb= isset($_REQUEST['sig3_eb']) ? ($_REQUEST['sig3_eb']) : '';
	$sigs1_eb = isset($_REQUEST['sigs1_eb']) ? $_REQUEST['sigs1_eb'] : '';
	$sigs2_eb= isset($_REQUEST['sigs2_eb']) ? ($_REQUEST['sigs2_eb']) : '';
	$sigs3_eb= isset($_REQUEST['sigs3_eb']) ? ($_REQUEST['sigs3_eb']) : '';
	$text_eb= isset($_REQUEST['text_eb']) ? ($_REQUEST['text_eb']) : '';
	
	$query = "
		UPDATE  dm_signature_g 
		SET 
			`sig_status` = '". 0 ."'
		
WHERE 
		  `sig_status`  = '". 1 ."'	AND sig_id_province=".$_SESSION['dm_user_profile']['u_province_id'].""		
		
	;
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
//	print $query;
	$query = array(
		'sig1_ph' => $sig1_ph,
		'sig2_ph' => $sig2_ph,
		'sig3_ph' => $sig3_ph,
	    'sigs1_ph' => $sigs1_ph,
		'sigs2_ph' => $sigs2_ph,
		'sigs3_ph' => $sigs3_ph,
	    'text_ph' => $text_ph,
		'sig1_pf' => $sig1_pf,
		'sig2_pf' => $sig2_pf,
		'sig3_pf' => $sig3_pf,
	    'sigs1_pf' => $sigs1_pf,
		'sigs2_pf' => $sigs2_pf,
		'sigs3_pf' => $sigs3_pf,
	    'text_pf' => $text_pf,
		'sig1_f' => $sig1_f,
		'sig2_f' => $sig2_f,
		'sig3_f' => $sig3_f,
	    'sigs1_f' => $sigs1_f,
		'sigs2_f' => $sigs2_f,
		'sigs3_f' => $sigs3_f,
     	'text_f' => $text_f,
		'sig1_h' => $sig1_h,
		'sig2_h' => $sig2_h,
		'sig3_h' => $sig3_h,
	    'sigs1_h' => $sigs1_h,
		'sigs2_h' => $sigs2_h,
		'sigs3_h' => $sigs3_h,
	    'text_h' => $text_h,
	    'sig1_eb' => $sig1_eb,
		'sig2_eb' => $sig2_eb,
		'sig3_eb' => $sig3_eb,
	    'sigs1_eb' => $sigs1_eb,
		'sigs2_eb' => $sigs2_eb,
		'sigs3_eb' => $sigs3_eb,
	    'text_eb' => $text_eb,
	    'sig1_m' => $sig1_m,
		'sig2_m' => $sig2_m,
		'sig3_m' => $sig3_m,
	    'sigs1_m' => $sigs1_m,
		'sigs2_m' => $sigs2_m,
		'sigs3_m' => $sigs3_m,
	    'text_m' => $text_m,
		'sig_status' => 1,
	    'sig_id_province'=> $_SESSION['dm_user_profile']['u_province_id'],	
		'sig_reg_date' => gmdate('Y-m-d'),
		
	);

	$query = inserterQMaker('dm_signature_g', $query);	
//	print $query;
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
	
	 	
 }
 function UpEdit_o(){
//		$signature_id = isset($_REQUEST['signature_id']) ? (int)($_REQUEST['signature_id']) : 0;
//	if($signature_id<1) die('Inv Id');

	$sig1_oh = isset($_REQUEST['sig1_oh']) ? $_REQUEST['sig1_oh'] : '';
	$sig2_oh= isset($_REQUEST['sig2_oh']) ? ($_REQUEST['sig2_oh']) : '';
	$sig3_oh= isset($_REQUEST['sig3_oh']) ? ($_REQUEST['sig3_oh']) : '';
	$sigs1_oh = isset($_REQUEST['sigs1_oh']) ? $_REQUEST['sigs1_oh'] : '';
	$sigs2_oh= isset($_REQUEST['sigs2_oh']) ? ($_REQUEST['sigs2_oh']) : '';
	$sigs3_oh= isset($_REQUEST['sigs3_oh']) ? ($_REQUEST['sigs3_oh']) : '';
	$text_oh= isset($_REQUEST['text_oh']) ? ($_REQUEST['text_oh']) : '';
	$sig1_oeb = isset($_REQUEST['sig1_oeb']) ? $_REQUEST['sig1_oeb'] : '';
	$sig2_oeb= isset($_REQUEST['sig2_oeb']) ? ($_REQUEST['sig2_oeb']) : '';
	$sig3_oeb= isset($_REQUEST['sig3_oeb']) ? ($_REQUEST['sig3_oeb']) : '';
	$sigs1_oeb = isset($_REQUEST['sigs1_oeb']) ? $_REQUEST['sigs1_oeb'] : '';
	$sigs2_oeb= isset($_REQUEST['sigs2_oeb']) ? ($_REQUEST['sigs2_oeb']) : '';
	$sigs3_oeb= isset($_REQUEST['sigs3_oeb']) ? ($_REQUEST['sigs3_oeb']) : '';
	$text_oeb= isset($_REQUEST['text_oeb']) ? ($_REQUEST['text_oeb']) : '';
	$sig_ostatus= isset($_REQUEST['sig_ostatus']) ? ($_REQUEST['sig_ostatus']) : '';
	
	
	$query = "
		UPDATE  dm_signature_o 
		SET 
			`sig_ostatus` = '". 0 ."'
		
WHERE 
		  `sig_ostatus`  = '". 1 ."'	AND sig_oid_province=".$_SESSION['dm_user_profile']['u_province_id'].""		
		
	;
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
//	print $query;
	$query = array(
	
		'sig1_oh' => $sig1_oh,
		'sig2_oh' => $sig2_oh,
		'sig3_oh' => $sig3_oh,
	    'sigs1_oh' => $sigs1_oh,
		'sigs2_oh' => $sigs2_oh,
		'sigs3_oh' => $sigs3_oh,
	    'text_oh' => $text_oh, 
	    'sig1_oeb' => $sig1_oeb,
		'sig2_oeb' => $sig2_oeb,
		'sig3_oeb' => $sig3_oeb,
	    'sigs1_oeb' => $sigs1_oeb,
		'sigs2_oeb' => $sigs2_oeb,
		'sigs3_oeb' => $sigs3_oeb,
	    'text_oeb' => $text_oeb,  
		'sig_ostatus' => 1,
	    'sig_oid_province'=> $_SESSION['dm_user_profile']['u_province_id'],	
		'sig_oreg_date' => gmdate('Y-m-d'),
		
	);

	$query = inserterQMaker('dm_signature_o', $query);	
//	print $query;
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
	
	 	
 }
function getCustInfo($cId){
	 $querypro="SELECT * FROM dm_province WHERE 
	            	  province_id=".$_SESSION['dm_user_profile']['u_province_id']; 
	$lnkpro = mysql_query($querypro); 
	$rowpro = mysql_fetch_assoc($lnkpro);
	$province_code=$rowpro['province_code'];
	$lnk = mysql_query("SELECT * FROM dm_customer WHERE customer_id=".$cId."
	                    AND
	                    customer_code_org=".$province_code."	");

	if(mysql_num_rows($lnk)>0){
		$row = mysql_fetch_assoc($lnk);
		return $row;
	} 	
}

function getProdInfo($cId){
	$lnk = mysql_query("dm_product product
				left join dm_price price
				on product.p_id=price.price_p_id
			 WHERE p_code=".$cId."
			 and
			 price_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
			 ");
	
	if(mysql_num_rows($lnk)>0){
		$row = mysql_fetch_assoc($lnk);
	 
		return $row;
	} 	
}
function getListMenuInfo($menu_id){
	$lnk = mysql_query("SELECT * FROM dm_usergroup WHERE ug_id=".$menu_id);
	
	if(mysql_num_rows($lnk)>0){
		$row = mysql_fetch_assoc($lnk);
	 
		return $row;
	} 	
}

function getChargeInfo($chId){
	$lnk = mysql_query("SELECT * FROM dm_charge_factors WHERE ch_id=".$chId);
	
	if(mysql_num_rows($lnk)>0){
		$row = mysql_fetch_assoc($lnk);
		return $row;
	} 	
	
}

function gethavaleInfo($id){
	
	$query="SELECT * FROM dm_pish_factor WHERE pf_id=".$_SESSION['shomarePishFactor']."
	       AND
	       pf_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
	       AND
		  pf_id_year=".$_SESSION['dm_user_profile']['u_year_id']." 
		  AND
		    pf_type=". 0 ." 
	       ";
	$lnk = mysql_query($query);
	
	if(mysql_num_rows($lnk)>0){
		$row = mysql_fetch_assoc($lnk);
	 
		return $row;
	} 		
}
function getLocationInfo($locId){
	$qStr = "SELECT * FROM dm_location_goods WHERE l_id=".$locId." AND l_id_province=".$_SESSION['dm_user_profile']['u_province_id']."";
	$lnk = mysql_query($qStr);
	print mysql_error();
	if(mysql_num_rows($lnk)>0){
		$row = mysql_fetch_assoc($lnk);
		return $row;
	} 
	return false;	
}

function getproductInfo($p_id){
	$qStr = "SELECT * FROM dm_listprod WHERE p_id=".$p_id." ";
	$lnk = mysql_query($qStr);
	print mysql_error();
	print $qStr;
	if(mysql_num_rows($lnk)>0){
		$row = mysql_fetch_assoc($lnk);
		return $row;
	} 
	return false;	
}
//براي شهرها

function  getNameCityComboBox($elmName='', $selectedItem=0){
	global $province_name;
	$outBx = '<select name="'.$elmName.'" ><option value="0" > --- </option>';
	foreach($province_name as $key=>$value){
		$isSel = ($key==$selectedItem) ? ' selected="selected" ' : '';
		$outBx .= '<option value="'.$key.'" '.$isSel.' >'.$value['title'].'</option>';
	}
	$outBx .= '</select>';
	return $outBx;
}

function getPriceCombo($pId, $comboId='priceCombo'){
	$query1 = "
		dm_product product
			left join dm_price price
			on product.p_id=price.price_p_id
			
				 WHERE p_code = ".$pId."  
			and
			 price_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
		ORDER BY p_price_code
	";
	print $query1;
	$lnk1 = mysql_query($query1);
	$out = '<select name="'.$comboId.'" id="'.$comboId.'" style="width:100px">';
	if(mysql_num_rows($lnk1)>0){
		while ($row1 = mysql_fetch_assoc($lnk1)){
			$out .= '<option value="'.$row1['p_price_code'].'" >'. $row1['p_price_code'].'</option>';
		}
	}
	$out .= '</select>';
	return $out;
}


function getCityCombo($cId, $comboId='u_city_id'){
	$query1 = "
		SELECT * FROM dm_city 
			
				 WHERE city_province = ".$cId."  
			
		ORDER BY city_name
	";
	print $query1;
	$lnk1 = mysql_query($query1);
	$out = '<select name="'.$comboId.'" id="'.$comboId.'" style="width:90px">';
	if(mysql_num_rows($lnk1)>0){
		while ($row1 = mysql_fetch_assoc($lnk1)){
			$out .= '<option value="'.$row1['city_id'].'" >'. $row1['city_name'].'</option>';
		}
	}
	$out .= '</select>';
	return $out;
}
function getlocationNameCombo($id='NamelocationCombo', $sCust=false){
	$out = '<select id="'.$id.'" name="'.$id.'"  ><option value="-2" > همه ي محل ها</option>';
	$lnk = mysql_query("SELECT * FROM dm_location_goods where l_id_province=".$_SESSION['dm_user_profile']['u_province_id']."");
	if(mysql_num_rows($lnk)>0){
		while($row=mysql_fetch_assoc($lnk)){
			$out .= '<option value="'.$row['l_id'].'" >'.$row['l_name'].'</option>';			
		}
	}
	$out .= '</select>';
	return $out;
}
function getNameProvinceCombol($id='province_id', $sCust=false){ 
	
		$query='select *
						from dm_um_rel t
							 inner join dm_listmenu l on l.menu_id = t.um_menu_id
						where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
							  l.menu_code = \'12304\' and t.um_can_edit=1';
			$lnk = mysql_query($query);
			if(mysql_num_rows($lnk)>0){
				
		       $out = '<select id="'.$id.'" name="'.$id.'" ><option value="'. 100 .'" style="width:80px;" >استان را انتخاب كنيد </option>';
			   $lnk = mysql_query("SELECT * FROM dm_province ORDER BY province_name");
				 if(mysql_affected_rows()>0){
					while($row=mysql_fetch_assoc($lnk)){
						$out .= '<option value="'.$row['province_id'].'" >'.$row['province_name'].'</option>';
												
											}
										}
		                           	}
		   else{
		                           	$out = '<select id="'.$id.'" name="'.$id.'" >';
			$lnk = mysql_query("SELECT * FROM dm_province where province_id=".$_SESSION['dm_user_profile']['u_province_id']."");
			if(mysql_affected_rows()>0){
				while($row=mysql_fetch_assoc($lnk)){
			       $out .= '<option value="'.$row['province_id'].'" >'.$row['province_name'].'</option>';
			
		}
	}
		                           		
		                           	}
	$out .= '</select>';
	return $out;
}
function getcityNameCombo($id='city_id', $sCust=false){
	$out = '<select id="'.$id.'" name="'.$id.'"  ><option value="-2" > همه ي شهرها</option>';
	$lnk = mysql_query("SELECT * FROM dm_city where city_province=".$_SESSION['dm_user_profile']['u_province_id']."");
	if(mysql_num_rows($lnk)>0){
		while($row=mysql_fetch_assoc($lnk)){
			$out .= '<option value="'.$row['city_id'].'" >'.$row['city_name'].'</option>';			
		}
	}
	$out .= '</select>';
	return $out;
}
function getcityNameCombol($id='city_id', $sCust=false){
	$out = '<select id="'.$id.'" name="'.$id.'"  ><option value="-2" > همه ي شهرها</option>';
	$lnk = mysql_query("SELECT * FROM dm_city ");
	if(mysql_num_rows($lnk)>0){
		while($row=mysql_fetch_assoc($lnk)){
			$out .= '<option value="'.$row['city_id'].'" >'.$row['city_name'].'</option>';			
		}
	}
	$out .= '</select>';
	return $out;
}
function getCustomerNameCombo($id='CustomerNameCombo', $sCust=false){
	$out = '<select id="'.$id.'" name="'.$id.'" ><option value="-2" > همه مشتري ها</option>';
	$lnk = mysql_query("SELECT * FROM dm_customer ORDER BY customer_id");
	if(mysql_num_rows($lnk)>0){
		while($row=mysql_fetch_assoc($lnk)){
			$out .= '<option value="'.$row['customer_id'].'" >'.$row['name_customer'].'</option>';			
		}
	}
	$out .= '</select>';
	return $out;
}
function getCatCustomerNameCombo($id='category_id', $sCust=false){
	$out = '<select id="'.$id.'" name="'.$id.'" ><option value="-2" > همه دسته بندي</option>';
	$lnk = mysql_query("SELECT * FROM dm_customer_category ORDER BY category_id");
	if(mysql_num_rows($lnk)>0){
		while($row=mysql_fetch_assoc($lnk)){
			$out .= '<option value="'.$row['category_id'].'" >'.$row['category_name'].'</option>';			
		}
	}
	$out .= '</select>';
	return $out;
}

function getProductNameCombo($id='ProductNameCombo', $sCust=false){
	$out = '<select id="'.$id.'" name="'.$id.'" ><option value="-2" > همه کالاها</option>';
	$lnk = mysql_query("dm_product product
			left join dm_price price
			on product.p_id=price.price_p_id ORDER BY p_id");
	if(mysql_num_rows($lnk)>0){
		while($row=mysql_fetch_assoc($lnk)){
			$out .= '<option value="'.$row['p_code'].'" >'.$row['p_name'].'</option>';			
		}
	}
	$out .= '</select>';
	return $out;
}
function getuserGroupMenuCombo($id='userGroupMenuCombo', $sCust=false){
	$out = '<select id="'.$id.'" name="'.$id.'"  >';
	$lnk = mysql_query("SELECT * FROM dm_usergroup ORDER BY ug_category");
	if(mysql_num_rows($lnk)>0){
		while($row=mysql_fetch_assoc($lnk)){
			$out .= '<option value="'.$row['ug_id'].'" >'.$row['ug_category'].'</option>';			
		}
	}
	$out .= '</select>';
	return $out;
}
function CreateNewYearFrm(){
?>
    <script type="text/javascript">
		$(document).ready(function() {
			$("#commentForm").validate();
		});
   </script>
	<?php 
	$out='<table  align="center" class="nasi" style="font-weight:bold;">
			    	<form method="post" action="" >
					<input type="hidden" name="pg" value="yearManagement">   
					<input type="hidden" name="cmd" value="RegNewYear"> 
					  	<tr align="middle"  style="background-color:'. $_SESSION['htablecolor'] .';">
					        <td colspan="6"  style="height: 50px;vertical-align:middle;"  ><font size="5">ايجاد سال جديد</font-size></td>
				        </tr>
				        <tr>
				            <td colspan="9"><hr></hr></td>
				        </tr>
				        <tr>
				           <td >&nbsp; نام سال جديد :</td><td><input name="year_name" type="text" /></td>
				        </tr>
				        
				        <tr>
					          <td>از تاريخ:</td><td><input name="year_first_date"  type="text" /></td>
					          <td>تا تاريخ:</td><td><input name="year_last_date"   type="text" /></td>
				        </tr>
				        <tr>
						     <td>&nbsp;&nbsp;</td>
						     <td colspan="3"> <button name="subject" type="submit"   value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF"  > ذخيره</button></td>
						                             
						     <td colspan="2">&nbsp;&nbsp;</td>
						 </tr>
		        
	       </table>
	              </form>
	';
	echo $out;
	
}
function RegNewYear(){
	$year_name = isset($_REQUEST['year_name']) ? $_REQUEST['year_name'] : '';
	$year_first_date = isset($_REQUEST['year_first_date']) ? ($_REQUEST['year_first_date']) : '';
	$year_last_date = isset($_REQUEST['year_last_date']) ? ($_REQUEST['year_last_date']) : '';
	
	$query = array(
	    'year_name' => $year_name,
		'year_first_date' => $year_first_date,
		'year_last_date' => $year_last_date,		
	);
	
	$query = inserterQMaker('dm_year', $query);
	//print $query;
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
}
function ListAllYears(){
	
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
			<input type="hidden" name="pg" value="prodMgmtPg">   
			<input type="hidden" name="cmd" value="searchYear"> 
		       	 سال مورد نظر را وارد كنيد 
			<div> جستجو : <input type="text" name="search" value="'.$_SESSION['srchStr'].'" style="width: 60px;"/> 
			<button type="submit" name="Search" value="Search" />جستجو</button></div>
		</form>
	';
	
	$outHtml .= '	
		<div align = "center" style="width:80%;height:200px; overflow:auto">
			<table  align="center" class="list" style="width:80%;">
		  	<tr align="middle" class="rw1">
		     <td colspan="7"  style="height: 50px;vertical-align:middle;"  ><font size="5">ليست سال هاي ايجاد شده</font-size></td>
	        </tr>
      		<tr class="rw0">
      		    	<td>رديف</td>
			        <td >نام سال</td>
			        <td >تاريخ شروع</td>
			        <td colspan="5">تاريخ پايان</td>
			       
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
					year_name LIKE '%".$_SESSION['srchStr']."%' 
				OR 
					year_first_date LIKE '%".$_SESSION['srchStr']."%' 
				OR 
					year_last_date LIKE '%".$_SESSION['srchStr']."%' 
				 
			)
		";
		
	}
	$typeQ = '';
	
	$genQuery = "
		
		FROM 
			 dm_year 
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
	$inx--;
	if(mysql_num_rows($lnk)>0){
		while($row = mysql_fetch_assoc($lnk)){
			
			 if(($inx)%2==1){
				$class="rw1";}
				else{
				 $class="rw0";}
			
			$inx++;
			$outHtml .= '
				 <tr class='.$class.'>
					<td>'.$inx.'</td>
					<td>'.$row['year_name'].'</td>
					<td>'.$row['year_first_date'].'</td>
					<td>'.$row['year_last_date'].'</td>
					<td><a href="?pg=yearManagement&cmd=EditYearFrm&year_id='.$row['year_id'].'">
                      <img src="images/edit.png" width="20" height="20" title="ويرايش" ></img></a></td>
					<td>&nbsp;&nbsp;</td>  
					<td><a href="?pg=prodMgmtPg&cmd=DeleteYear&year_id='.$row['year_id'].'">
                         <img src="images/delete.PNG" width="20" height="20" title="حذف" ></img></a></td>
				</tr>
				
			';
		}
    }else{
    	$outHtml .= '<tr><td colspan="5">هيچ اطلاعاتي موجود نيست</td></tr>';
 	}
    $outHtml .= ' 
	      	</table>'.getNavBar_year().' '.getRPPCombo_year();
    return $outHtml;
		
}
function getNavBar_year(){
	$out = '
		<table style="direction:ltr" >
			<tr>
			
	';
	//if($stNum>$_SESSION['pageCount']) $stNum=$_SESSION['pageCount']-5;
	
	$stNum = $_SESSION['crntPage']-5;
	if($stNum<1) $stNum=1;
	$out .= '
		<td><a href="?pg=yearManagement&cmd=ListAllYears&cmd2=setPg&pgNum=1" ><img src="images/first.gif" title="ابتدا"></img></a></td>
        <td>&nbsp;&nbsp;</td>
		<td><a href="?pg=yearManagement&cmd=ListAllYears&cmd2=setPg&pgNum='.((($_SESSION['crntPage']-1)<1) ? 1 : ($_SESSION['crntPage']-1)).'" ><img src="images/prev.gif" title="قبلي"></img></a></td>
       <td>&nbsp;&nbsp;</td>
	';
	$inx = 0;
	while(($inx<10) && (($stNum+$inx) <= $_SESSION['pageCount'])){
		$out .= '
			<td><a '.(($_SESSION['crntPage']==($stNum+$inx)) ? ' style="text-decoration:none; font-weight:bold;" ':'').' href="?pg=yearManagement&cmd=ListAllYears&cmd2=setPg&pgNum='.($stNum+$inx).'" ><div style="background:#cccccc;">'.($stNum+$inx).'</a></td>
            <td>&nbsp;&nbsp;</td>
		';
		
		$inx++;
	}
	$out .= '
		<td><a href="?pg=yearManagement&cmd=ListAllYears&cmd2=setPg&pgNum='.((($_SESSION['crntPage']+1)<=$_SESSION['pageCount']) ? ($_SESSION['crntPage']+1) : $_SESSION['pageCount']).'" ><img src="images/next.gif" title="بعدي"></img></a></td>
        <td>&nbsp;</td>
		<td><a href="?pg=yearManagement&cmd=ListAllYears&cmd2=setPg&pgNum='.$_SESSION['pageCount'].'" ><img src="images/last.gif" title="انتها"></img></a></td>	
        <td>&nbsp;&nbsp;</td>
	';
	
	$out .= '
			</tr>
		</table>
	';	
	return $out;
}

function getRPPCombo_year(){
	$out = '
		<select onchange="window.open(\'?pg=yearManagement&cmd=ListAllYears&cmd2=setRPP&rPP=\'+this.value, \'_self\')" style="width:50px;" >
			<option value="1" '.(($_SESSION['rPP']==1)?' selected="selected" ':'').' > 1 </option>
			<option value="5" '.(($_SESSION['rPP']==5)?' selected="selected" ':'').' > 5 </option>
			<option value="10" '.(($_SESSION['rPP']==10)?' selected="selected" ':'').' > 10 </option>
			<option value="25" '.(($_SESSION['rPP']==25)?' selected="selected" ':'').' > 25 </option>
			<option value="50" '.(($_SESSION['rPP']==30)?' selected="selected" ':'').' > 50 </option>
			<option value="100" '.(($_SESSION['rPP']==100)?' selected="selected" ':'').' > 100 </option>
			<option value="1000000" '.(($_SESSION['rPP']==0)?' selected="selected" ':'').' > all </option>
		</select>
		<span style="color:blue;"><b>پاسخ در صفحه</b></span>
<br><br>	';
	return $out;
}
function EditYearFrm(){
	
	$year_id = isset($_REQUEST['year_id']) ? (int)($_REQUEST['year_id']) : 0;
	if($year_id<1) die('Invalid id!');
	$lnk = mysql_query("SELECT * FROM dm_year WHERE year_id=".$year_id);
	if(mysql_num_rows($lnk)>0){
		$row = mysql_fetch_assoc($lnk);
		
	}else{
		die('Invalid id2!');
	}
		?>

	<form method="post" action="" >
	   	
		<input type="hidden" name="pg" value="yearManagement">   
		<input type="hidden" name="cmd" value="updYearInf">   
		<input type="hidden" name="year_id" value="<?php echo $year_id; ?>">   
		<table align="center"  class="nasi">
		  	<tr style="background-color:<?php echo $_SESSION['htablecolor'] ?>;" >
		       <td colspan="6"  style="height: 50px;vertical-align:middle;"  ><font size="5">مشخصات سال</font-size></td>
		
	        </tr>	      
	      	<tr>
			        <td ><center>نام سال </center> </td>
			        <td><input name="year_name" type="text" value="<?php echo $row['year_name']; ?>" /></td>
		    </tr>
		   <tr>
			       <td ><center>تاريخ شروع </center> </td>
			       <td><input name="year_first_date" type="text" value="<?php echo $row['year_first_date']; ?>" /></td>
			       <td align="center"><center>تاريخ پايان </center> </td>
		           <td><input name="year_last_date" type="text"  value="<?php echo $row['year_last_date']; ?>" /></td><!--name kala-->
	        </tr>
	      	<tr>
	      	         
				       <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				       </td>
			      	
				     <td colspan="3"> <button name="subject" type="submit" value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF" > ذخيره</button></td>
				     <td colspan="2">&nbsp;&nbsp;&nbsp;</td>
				        
	      	</tr>
	    </table>
	</form> 
	    
	<?php
}
function updYearInf(){
	
	$year_id = isset($_REQUEST['year_id']) ? (int)($_REQUEST['year_id']) : 0;
	$year_name = isset($_REQUEST['year_name']) ? ($_REQUEST['year_name']) :'';
	$year_first_date = isset($_REQUEST['year_first_date']) ? (int)($_REQUEST['year_first_date']) : 0;
	$year_last_date = isset($_REQUEST['year_last_date']) ? (int)($_REQUEST['year_last_date']) : 0;
	if($year_id<1) die('Inv Id');
		
	
	$query = "
		UPDATE  dm_year
		SET 
			`year_name` = '".$year_name."',
		    `year_first_date` = '".$year_first_date."',
			`year_last_date` = '".$year_last_date."'
			
			
		WHERE 
			`year_id` = ".$year_id." 
	";
	
	//print $query;
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
}
function DeleteYear(){
	$year_id = isset($_REQUEST['year_id']) ? ($_REQUEST['year_id']) : 0;
	if($year_id<1) die('Inv Id');
	
	$query = "
	DELETE FROM  dm_year
 
		WHERE 
			year_id = ".$year_id." ";
	
	$lnk = mysql_query($query);
	sqlErr('delete year');
}

function hndlProvinceCombo($id='NameProvinceCombo', $sCust=false){ 

	if($_SESSION['dm_user_profile']['u_province_id']== "100"){
	
	
					 $lnk1 = mysql_query("SELECT * FROM dm_province WHERE province_id=".$_SESSION['dm_user_profile']['u_province_id']." ");
					        $row11=mysql_fetch_assoc($lnk1);
					               $query2="SELECT * FROM dm_user_profile WHERE u_id=".$_SESSION['dm_user_profile']['u_id']."
								            AND
								           u_province_id=". 100 ."";
					 
												$lnk2 = mysql_query($query2);
												$row2 = mysql_fetch_assoc($lnk2);
						if(mysql_num_rows($lnk2)>0){
							
							
							$out = '<select id="'.$id.'" name="'.$id.'" onChange="hndlProvinceCombo(\'\', this.value)" style="width:15%;"><option value=" -1 "  >استان را انتخاب كنيد </option>';
												
							$lnk = mysql_query(" SELECT * FROM dm_province WHERE 1 order by province_code ASC");
					//	echo " SELECT * FROM dm_province WHERE 1 order by province_code ASC";
						}
							else{
								
								$out = '<select id="'.$id.'" name="'.$id.'"  style="width:20%;"><option value="'.$row11['province_id'].'"  >'.$row11['province_name'].' </option>';				
								$lnk = mysql_query("SELECT * FROM dm_province where province_id=".$_SESSION['dm_user_profile']['u_province_id']."");
							
							}
					if(mysql_num_rows($lnk)>0){
						
						//$row=mysql_fetch_assoc($lnk);
						while($row=mysql_fetch_assoc($lnk)){
							$out .= '<option value="'.$row['province_id'].'" >'.$row['province_name'].'</option>';
							
						}
					}
					$out .= '</select>';
					
				
	}
	
	
	else{
		
		             $lnk1 = mysql_query("SELECT * FROM dm_province WHERE province_id={$_SESSION['dm_user_profile']['u_province_id']} ");
					        $row1=mysql_fetch_assoc($lnk1);
					        $province_name= $row1['province_name'];
					               $query2="SELECT * FROM dm_user_profile WHERE u_id=".$_SESSION['dm_user_profile']['u_id']."
								            AND
								           u_province_id=". 100 ."";
					 
												$lnk2 = mysql_query($query2);
												if(mysql_num_rows($lnk2)>0){
												$row2 = mysql_fetch_assoc($lnk2);
							$out = '<select id="'.$id.'" name="'.$id.'" onChange="hndlProvinceCombo(\'\', this.value)" style="width:15%;"><option value="'.$row1['province_id'].'"  >'.$province_name.' </option>';
												
							$lnk = mysql_query("SELECT * FROM dm_province WHERE     province_id != ".$row1['province_id']." order by province_code ASC");}
							else{
								$out = '<select id="'.$id.'" name="'.$id.'"  style="width:20%;" ><option value="'.$row1['province_id'].'"  >'.$row1['province_name'].' </option>';				
								$lnk = mysql_query("SELECT * FROM dm_province where province_id=".$_SESSION['dm_user_profile']['u_province_id']."");
							
							}
					if(mysql_num_rows($lnk)>0){
					//	$row=mysql_fetch_assoc($lnk);
						while($row=mysql_fetch_assoc($lnk)){
							$out .= '<option value="'.$row['province_id'].'" >'.$row['province_name'].'</option>';
							
						}
					}
					$out .= '</select>';
		
	}
	return $out;
}

function hndlNameYearCombo($id='NameYearCombo1', $sCust=false){ 
	//echo $_SESSION['dm_user_profile']['u_year_id'];

	if( $_SESSION['dm_user_profile']['u_year_id']== "100"){
		$_SESSION['dm_user_profile']['u_year_id']= "6";
			 $lnk1 = mysql_query("SELECT * FROM dm_year WHERE province_id={$_SESSION['dm_user_profile']['u_year_id']} ");
						        $row1=mysql_fetch_assoc($lnk1);
			
						           $query2="SELECT * FROM dm_user_profile WHERE u_id=".$_SESSION['dm_user_profile']['u_id']."
									            AND
									           u_year_id=". 100 ."";
						 
													$lnk2 = mysql_query($query2);
													if(mysql_num_rows($lnk2)>0){
																							
																$row2 = mysql_fetch_assoc($lnk2);
																		$out = '<select id="'.$id.'" name="'.$id.'" onChange="hndlNameYearCombo(\'\', this.value)" style="width:15%;"><option value=" -1 "> سال را انتخاب کنيد</option>';
																							
																		$lnk = mysql_query("SELECT * FROM dm_year  where 1 order by year_id desc");
																	//	echo 'test';
																while($row=mysql_fetch_assoc($lnk)){
											                       $out .= '<option value="'.$row['year_id'].'" >'.$row['year_name'].'</option>';}			
										
												}
								else{
									
									
												$out = '<select id="'.$id.'" name="'.$id.'"  style="width:20%;">';				
												$lnk = mysql_query("SELECT * FROM dm_year where year_id=".$_SESSION['dm_user_profile']['u_year_id']."");
											while($row=mysql_fetch_assoc($lnk)){
											
											$out .= '<option value="'.$row['year_id'].'" >'.$row['year_name'].'</option>';}				   
								
								}
						
						$out .= '</select>';
	}else{
		
		  		 $lnk1 = mysql_query("SELECT * FROM dm_year WHERE year_id={$_SESSION['dm_user_profile']['u_year_id']} ");
						        $row1=mysql_fetch_assoc($lnk1);				
		        $query2="SELECT * FROM dm_user_profile WHERE u_id=".$_SESSION['dm_user_profile']['u_id']."
								            AND
								           u_year_id=". 100 ."";
					 
												$lnk2 = mysql_query($query2);
				//						print $query2;
												if(mysql_num_rows($lnk2)>0){
													
															$row2 = mysql_fetch_assoc($lnk2);
																	$out = '<select id="'.$id.'" name="'.$id.'" onChange="hndlNameYearCombo(\'\', this.value)" style="width:15%;">';
																						
																	$lnk = mysql_query("SELECT * FROM dm_year  where year_id !=".$_SESSION['dm_user_profile']['u_year_id']." ");
																	$lnkad = mysql_query("SELECT * FROM dm_year  where year_id=".$_SESSION['dm_user_profile']['u_year_id']."");
																	$rowad=mysql_fetch_assoc($lnkad);
                                                                         $out .= '<option value="'.$rowad['year_id'].'" >'.$rowad['year_name'].'</option>';
																	while($row=mysql_fetch_assoc($lnk)){
										                       
										                       $out .= '<option value="'.$row['year_id'].'" >'.$row['year_name'].'</option>';}	                		
									
											}
							else{
								
								
											$out = '<select id="'.$id.'" name="'.$id.'"  style="width:20%;">';				
											$lnk = mysql_query("SELECT * FROM dm_year where year_id=".$_SESSION['dm_user_profile']['u_year_id']."");
											//print "SELECT * FROM dm_year where year_id=".$_SESSION['dm_user_profile']['u_year_id']."";
										while($row=mysql_fetch_assoc($lnk)){
										
										$out .= '<option value="'.$row['year_id'].'" >'.$row['year_name'].'</option>';}				   
							
							}
					
					$out .= '</select>';
		
	}
	
	return $out;
}
function getTypesatf($elmName='', $selectedItem=0){
	global $dpf_type;
	$outBx = '<select name="'.$elmName.'" id="dpf_type" >';
	foreach($dpf_type as $key=>$value){
		$isSel = ($key==$selectedItem) ? ' selected="selected" ' : '';
		$outBx .= '<option value="'.$key.'" '.$isSel.' >'.$value['title'].'</option>';
	}
	$outBx .= '</select>';
	return $outBx;
}
function getTypepay($elmName='', $selectedItem=0){
	global $pay_type;
	$outBx = '<select name="'.$elmName.'" id="pay_type" >';
	foreach($dpf_type as $key=>$value){
		$isSel = ($key==$selectedItem) ? ' selected="selected" ' : '';
		$outBx .= '<option value="'.$key.'" '.$isSel.' >'.$value['title'].'</option>';
	}
	$outBx .= '</select>';
	return $outBx;
}
function farsinum( $data )
{
$newstr = "";
$i = 0;
for ( ; $i <= strlen( $data ); ++$i )
{
$str = $data[$i];
$nstr = $str;
if ( $str == "0" )
{
$nstr = str_replace( "0", "۰", $str );
}
if ( $str == "1" )
{
$nstr = str_replace( "1", "۱", $str );
}
if ( $str == "2" )
{
$nstr = str_replace( "2", "۲", $str );
}
if ( $str == "3" )
{
$nstr = str_replace( "3", "۳", $str );
}
if ( $str == "4" )
{
$nstr = str_replace( "4", "۴", $str );
}
if ( $str == "5" )
{
$nstr = str_replace( "5", "۵", $str );
}
if ( $str == "6" )
{
$nstr = str_replace( "6", "۶", $str );
}
if ( $str == "7" )
{
$nstr = str_replace( "7", "۷", $str );
}
if ( $str == "8" )
{
$nstr = str_replace( "8", "۸", $str );
}
if ( $str == "9" )
{
$nstr = str_replace( "9", "۹", $str );
}
$newstr .= $nstr;
}
return $newstr;
}
function farsichar( $data )
{
$newstr = "";
$i = 0;
for ( ; $i <= strlen( $data ); ++$i )
{
$str = $data[$i];
$nstr = $str;
if ( $str == "ي" )
{
$nstr = str_replace( "ي", "ي", $str );
}
if ( $str == "ا" )
{
$nstr = str_replace( "ا", "ا", $str );
}
if ( $str == "ک" )
{
$nstr = str_replace( "ك", "ک", $str );
}

$newstr .= $nstr;
}
return $newstr;
}
function datesys(){
	
 return gmdate('Y-m-d');
//return	gmdate('Y-m-d H:i:s', strtotime('+6 days'));

}

function VisitorIP()
    { 
    if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $TheIp=$_SERVER['HTTP_X_FORWARDED_FOR'];
    else $TheIp=$_SERVER['REMOTE_ADDR'];
 
    return trim($TheIp);
    }
  
