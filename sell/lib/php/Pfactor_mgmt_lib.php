<?php
function dsppHavaleFrm(){
	
	$query = " SELECT *  FROM dm_pish_havale_det 			 
			 WHERE 
					phd_p_price = 0 
			 AND 
				phd_id_province='".$_SESSION['dm_user_profile']['u_province_id']."'  ";	
						   								 	    					   
    			$lnk = mysql_query($query);
				if(mysql_num_rows($lnk)>0){
				
			while($row = mysql_fetch_assoc($lnk))
			{
				 $queryp="SELECT * FROM dm_product product
							left join dm_price price
						on product.p_id=price.price_p_id
						WHERE p_code=".$row['phd_pid']."
						 AND 
							    p_price_code=".$row['phd_price_code']."
						 AND
								  price_id_province=".$_SESSION['dm_user_profile']['u_province_id'] ." ";
							
					$lnkp = mysql_query($queryp);
					$rowp = mysql_fetch_assoc($lnkp);
					$phd_price=$rowp['p_sellprice'] * $row['phd_amount'];
					$phd_priceh=$rowp['p_sellpriceh'] * $row['phd_amount'];
					$query = "
							UPDATE dm_pish_havale_det 
							SET 
								`phd_price` = '".$phd_price."',
								`phd_p_price` = ".$rowp['p_sellprice'].", 
								`phd_priceh` = '".$phd_priceh."',
								`phd_p_priceh` = ".$rowp['p_sellpriceh']."  			 
								 			 
								
													 
							WHERE 
								phd_id_province = ".$_SESSION['dm_user_profile']['u_province_id']." 
                             AND
							 
							     phd_id=".$row['phd_id']."";
	
						$lnk = mysql_query($query);
					
								
				}
				                          }
	
                  $day_number = jdate('j');
                   $month_number = jdate('n');
                   $year_number = jdate('y');
                   $day_name = jdate('l');
	               $selectedItem=1;
	               ?>
	    <body onLoad="document.f1.userid.focus()"> 
	 <table  align="center"  class="nasi" onload="FocusOnInput()">
	       <tr  style="background-color:<?php echo $_SESSION['htablecolor'] ?>;">
			  	       	
				</tr>
				<tr style="background-color:<?php echo $_SESSION['htablecolor'] ?>;">
				       <td colspan="5"  align="center" ><b> صدور معرفي نامه </b> </td>
				</tr>
				<tr style="background-color:<?php echo $_SESSION['htablecolor'] ?>;">
				    <td colspan="5">&nbsp;</td>
				</tr>
	 
				<tr>
					
						<td>تاريخ:<?php echo $year_number?>/<?php echo $month_number ?>/<?php echo $day_number ?>&nbsp;</td>
						
				</tr>
				<tr>
				<tr>
				        <td colspan="5"><hr></hr></td>
				
				</tr>
				
					
				<tr >
				
					<form method="post" action="" >
		              	<input type="hidden" name="pg"  value="PfactorMgmtPg" >   
		                <input type="hidden" name="cmd" value="dspmoarefi" >		                
		              	<td>&nbsp; <b> شماره پيش حواله :</b> </td>		              	
						<td><input name="ph_code" type="text"/></td>
					    <td colspan="3" align="center"><input type="submit" value="تاييد"  class="button blue skew" style="font-size:15px;width=20px; color:#FFFFFF" ></td>
				    </form>
				</tr>	
							 
  </table>
  </body>
  <?php 
	
	
}	
function dspPreFactorFrm()
{
	
              $day_number = jdate('j');
              $month_number = jdate('n');
              $year_number = jdate('y');
              $day_name = jdate('l');
              $selectedItem=1;
	               ?>
	     <body onLoad="document.f1.ph_code.focus()">
	 <table  align="center"  class="nasi">
	       
				<tr style="background-color:<?php echo $_SESSION['htablecolor'] ?>;">
				       <td colspan="3" align="center" style="vertical-align:middle;height:50px;"><b> صدور وتغيير پیش فاکتور </b> </td>
				</tr>				 
				<tr>
						<td style="vertical-align:middle;"><b> صدور تغيير بر اساس </b><center><?php echo getpfcreateTypeRadioHtml($selectedItem)?></center></td>	
						<td>تاريخ:<?php echo $year_number?>/<?php echo $month_number ?>/<?php echo $day_number ?>&nbsp;</td>
						
				</tr>
					
				<tr id="pfcreateph" style="display: block;">
					<form method="post" name="f1" action="" >
		              	<input type="hidden" name="pg"  value="PfactorMgmtPg" >   
		                <input type="hidden" name="cmd" value="dspPishFactor" >		                
		              	<td>&nbsp; <b> شماره پيش حواله :</b> </td>		              	
						<td><input name="ph_code" type="text"/></td>
					    <td colspan="3" align="center"><input type="submit" value="تاييد"  class="button blue skew" style="font-size:15px;width=20px; color:#FFFFFF" ></td>
				    </form>
				</tr>	
				<tr id="pfcreatepf" style="display:none;">
					<form method="post" action="" >
		              	<input type="hidden" name="pg" value="havaleMgmtPg">   
		              	<input type="hidden" name="cmd" value="dspPishHavale1">		            
		              	<td><b> شماره پيش فاكتور :</b> </td>
					    <td><input name="pf_code" type="text"/></td>
					    <td colspan="3" align="center" ><input type="submit" value="تاييد"  class="button blue skew" style="font-size:15px; color:#FFFFFF" ></td>					    
				    </form>
				</tr>			 
  </table>
  </body>
  <?php 
	
}

function dspPishHavale(){
	
	$_SESSION['code&p']='';
 	$_SESSION['price&code']='';
	$ph_code = isset($_REQUEST['ph_code']) ? $_REQUEST['ph_code'] : '';
    $cus_name = isset($_REQUEST['cus_name']) ? $_REQUEST['cus_name'] : '';
     $day_number = jdate('j');
    $month_number = jdate('n');
    $year_number = jdate('y');
    $day_name = jdate('l');    
	
	if($month_number<9){
	$month_number ='0'.$month_number;	
	}
	if($day_number<9){
	$day_number ='0'.$day_number;	
	}
		
	?>
	<script type="text/javascript" >
	function addDocument2PfCheck(ph_code){
		
		if(fObj('DocCombo').value==''){
			
			alert('لطفا کد سند را انتخاب کنيد');
			return;
		}
		
		if(fObj('DocCombo').value==5){

				
			 if(fObj('dpf_prov_sanad').value==-2){
					
					alert('لطفا شهرستان را وارد کنید');
					return;
				}

				
		}
	if(fObj('DocCombo').value==2){

			
			if(fObj('dpf_bank').value==-2){
				
				alert('لطفا نام بانک را انتخاب کنید');
				return;
			}
			
			if(fObj('dpf_num').value==''){
							
							alert('لطفا شماره فیش را وارد کنید');
							return;
						}
			if(fObj('dpf_branch').value==''){
				
				alert('لطفا نام شعبه را وارد کنید');
				return;
			}
				
		}

		
		
       if(fObj('dpf_price').value==''){
			
			alert('لطفا مبلغ را وارد کنيد');
			return;
		}
       addDocument2Pf();
    	}
	function formatCurrency(num) {
	    num = num.toString().replace(/\$|\,/g,'');
	    if(isNaN(num)) {
	        num = "0";
	    }
	    sign = (num == (num = Math.abs(num)));
	    num = Math.floor(num*100+0.50000000001);
	    cents = num % 100;
	    num = Math.floor(num/100).toString();
	    if(cents < 10) {
	        cents = "0" + cents;
	    }
	    for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++) {
	        num = num.substring(0,num.length-(4*i+3))+','+num.substring(num.length-(4*i+3));
	    }
	    if(cents>0){
	    return (((sign)?'':'-')  + num + '.' + cents);
	    }else{
	    	 return (((sign)?'':'-')  + num );

	    }
	}
	function fill(thisValue) {
		$('#inputString').val(thisValue);
		setTimeout("$('#suggestions').hide();", 200);	
	}
	function formReset()
	{
	document.getElementById("formpardakht").reset();
	}
	</script>
	<?php 
	
		$ph_code = isset($_REQUEST['ph_code']) ? $_REQUEST['ph_code'] : '';
		$display = isset($_REQUEST['display']) ? $_REQUEST['display'] : '8';
		
		$_SESSION['ph_code_d']=$ph_code;
		  		
		$queryp="SELECT * FROM dm_province 
            WHERE province_id=".$_SESSION['dm_user_profile']['u_province_id']."";
		$lnkp=mysql_query($queryp);
		print mysql_error();
		$rowp=mysql_fetch_assoc($lnkp);
		$provinceName=$rowp['province_name'];
		
	   $query = "SELECT * FROM dm_pish_havale WHERE ph_code=".$ph_code." 
				   AND
				      ph_id_province=".$_SESSION['dm_user_profile']['u_province_id']." 
				   AND 
				     ph_id_year=".$_SESSION['dm_user_profile']['u_year_id']."";	

	   $lnk = mysql_query($query);
//	   print $query;
       if(mysql_affected_rows()>0){
       
	
					$query="SELECT MAX(pf_code) maxId FROM dm_pish_factor 
					            WHERE
					            pf_id_province=".$_SESSION['dm_user_profile']['u_province_id']."";
					           
					         	    
					$lnk1=mysql_query($query);
				   //print $query;
					print mysql_error();
					$row1=mysql_fetch_assoc($lnk1);
					$pf_code=$row1['maxId'];
					$pf_code=$pf_code+1;
					
					$totalprice=0;
					if($display==1){
						$outHtml ='';
	//					echo $pf_code;
					}else{
						
						$outHtml = dspPreFactorFrm();
					}
					$outHtml .= '<input type="hidden" name="ph_code" id="ph_code" value="'. $ph_code .'">
					<div align="center"> <table  border="1" class="list" cellSpacing="6px;" style="width:80%;">';

				    //retrieve mainInfo pishhavale	
					$query = "
					 	SELECT *  FROM dm_pish_havale 
				 
						WHERE 
							ph_code = '".$ph_code."' 
						AND
							ph_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
						AND
							ph_id_year=".$_SESSION['dm_user_profile']['u_year_id']."
					";
					$_SESSION['shPhforPf']=$ph_code;
					$lnk = mysql_query($query);
				//	print $query;
					sqlErr('wererewr');
					
					if(mysql_affected_rows()>0){
						
						$havaleMainInfo = mysql_fetch_assoc($lnk);
						
						$_SESSION['shPhforPf']=$havaleMainInfo['$ph_code'];
						$query5 = "
							 	    SELECT *  FROM dm_customer 						 
								WHERE 
									customer_id = '".$havaleMainInfo['ph_customer_code']."' "; 
									
							//	print $query5;			   					
						$lnk5 = mysql_query($query5);
						$row5= mysql_fetch_assoc($lnk5);

						$outHtml .= '<br>
							
						  	<tr  class="rw1">
						         <td colspan="15"  style="height: 50px;vertical-align:middle;"  ><center><font size="5">پيش فاكتور </center></font></td>  
					        </tr>
					       
							<tr class="rw0">
							     <td colspan="3"> <b> &nbsp;پيش حواله به شماره :</b><b> '.$ph_code.'</b></td><td align="center"><b> به نام :</b> </td><td colspan="10" align="right"> <b>&nbsp;&nbsp;'.$cus_name.'</b></td>
							</tr> ';
							
						//retrieve detail of pishHavale
						$query1 = "
						 	SELECT *  FROM dm_pish_havale_det 
					 
							WHERE 
								phd_ph_code = ".$ph_code."
							AND 
	                         phd_id_year=".$_SESSION['dm_user_profile']['u_year_id']." 
	                        AND
	                         phd_id_province=".$_SESSION['dm_user_profile']['u_province_id']."";
						
						$lnk1 = mysql_query($query1);
					//	print $query1;
						sqlErr('for Display pfactor');
						
						if(mysql_num_rows($lnk1)>0){
							$outHtml .= '
										<tr class="rw1">
									<td colspan=15 align=center style="font-weight:bold;">
									   ريز پيش فاكتور
									</td>
								</tr>
										<tr class="rw0" style="font-weight:bold;">
											<td align="center" width=5% >رديف</td>
											<td align="center" width=15%>نام کالا</td>							
											<td align="center" width=10%>كد كالا</td>			
										    <td align="center" width=10%>كد قيمت</td>
											<td align="center" width=15%>مقدار خريد</td>
											<td align="center" width=15%>واحد خريد</td>
										    <td align="center" width=15%>قيمت واحد </td>
										    <td align="center" width=15%>هزينه اضافی هر واحد </td>
											<td  width=20%>قيمت تمام شده</td>
								            <td colspan="2" width=20%>&nbsp;</td>
										</tr>';
							
							
							$inx = 0;
							while($row1= mysql_fetch_assoc($lnk1)){
								
								$inx++;
					$query = "
						 	SELECT *  FROM dm_product product
							left join dm_price price
							on product.p_id=price.price_p_id 
					 
							WHERE 
								p_code = ".$row1['phd_pid']." AND p_price_code=".$row1['phd_price_code']."
								and
			             price_id_province=".$_SESSION['dm_user_profile']['u_province_id']."";
						
								$ln = mysql_query($query);
								$prod= mysql_fetch_assoc($ln);
							
								$price=$row1['phd_amount']*$prod['p_unit'];	
///
					$querych = "SELECT *  FROM dm_product product
						left join dm_price price
						on product.p_id=price.price_p_id 
					    left join  dm_charge_factors charge on price.price_id=charge.ch_price_id
							WHERE 
								p_code = ".$row1['phd_pid']." 
							AND
								p_price_code=".$row1['phd_price_code']."
							AND
								price_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
							AND
							   ch_id_province=".$_SESSION['dm_user_profile']['u_province_id']."";
						//print $querych;		
			$lnkch = mysql_query($querych);
		   sqlErr('for Display charge');
		   
	
					   $hazine=$row1['phd_p_add'];
					
	
								if(($inx)%2==1)
										$class="rw1";
										else
										 $class="rw0";
										 	$queryloc = "
						 	SELECT *  FROM dm_location_goods 
					 
							WHERE 
								l_id = ".$row1['phd_l_id']." 
							AND 
								l_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
						";
//								print $query;
								$lnkloc = mysql_query($queryloc);
								$loc= mysql_fetch_assoc($lnkloc);
					//			print $queryloc;
			         		$phd_amount1=formatMoney($row1['phd_amount']);
								
								$outHtml .= '
										<tr class='.$class.'>
											<td align="center">'.$inx.'</td>
											<td align="center">'.$prod['p_name'].'</td>
											<td align="center">'.$row1['phd_pid'].'</td>
											<td align="center">'.$row1['phd_price_code'].'</td>
											<td align="center">'.$phd_amount1.'</td>';
						$query = "
						 	SELECT *  FROM dm_product product
							left join dm_price price
							on product.p_id=price.price_p_id 
					 
							WHERE 
								p_code = ".$row1['phd_pid']." 
							AND
							  p_price_code=".$row1['phd_price_code']."
						    and
			               price_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
						";
						//		print $query;
								$ln = mysql_query($query);
								$prod= mysql_fetch_assoc($ln);
//for unit
							$queryunit="SELECT * FROM dm_prod_det_u 
								        WHERE unit_prod_id=".$row1['phd_id_unit']." ";
					//	print 	$queryunit;	     		           
									$lnkunit=mysql_query($queryunit);
									print mysql_error();
									$rowunit=mysql_fetch_assoc($lnkunit);						
									
								    $unitName=$rowunit['unit_prod_name'];
								    $ratio=$rowunit['unit_prod_ratio'];
								
								    $phd_price=$ratio*$row1['phd_amount']*$prod['p_sellpriceh'];
								       
		                            $phd_price1=formatMoney($row1['phd_priceh']);
		
		                              $unit_prod_name=formatMoney($rowunit['unit_prod_name']);
									  $p_sellprice=formatMoney($prod['p_sellprice']);
									
											$outHtml .= '
											             <td align="center">'.$unit_prod_name.'</td>				
											             <td align="center">'.$p_sellprice.'</td>
											             <td align="center">'.$hazine.'</td>
														 <td align="center">'.$phd_price1.'</td>';
//											if($row1['phd_status']==1){
//												$outHtml .= ' <td align="center"> حواله ثبت شده</td>';
//								
//							            	}else{
//														$outHtml .= ' <td align="center"><button type="button" value="ثبت و ايجاد حواله " onclick="addNewHavale(\'\', \''.$ph_code.'\', \''.$pf_code.'\', \''.$row1['phd_price'].'\', \''.$row1['phd_id'].'\', \''.$havaleMainInfo['ph_customer_code'].'\')"  class="button blue skew" style="font-size:10px; color:#FFFFFF" style="width:20px;">ثبت و ايجاد حواله</button></td>';
//								
//								              }
					
								$totalprice =$row1['phd_priceh']+$totalprice;
								?>
									<input id="total_price" type="hidden" name="totalprice" value="<?php echo $totalprice ?>"> 
								<?php   
							}
						$totalprice1=formatMoney($totalprice);
							$outHtml .= '</table>
									
									<div>
										 <span> جمع کل:'.$totalprice1.'ريال</span>
										 <span ><button type="button" value="ثبت پيش فاكتور" onclick="addPfactor(\'\', \''.$ph_code.'\',\''.$totalprice.'\', \''.$pf_code.'\'); this.style.display=\'none\'" class="button blue skew" style="font-size:10px; color:#FFFFFF">
										ثبت پيش فاكتور</button></span></div>
								         <span> <button type="button" value="ثبت و ايجاد حواله "  onclick="addednewhavalekoli(\'\', \''.$ph_code.'\', \''.$pf_code.'\', \''.$rowphd['phd_price'].'\', \''.$rowphd['phd_id'].'\', \''.urlencode($havaleMainInfo['ph_customer_code']).'\')"  class="button blue skew" style="font-size:10px; color:#FFFFFF" style="width:20px;">ثبت و ايجاد حواله</button></span>
										
								<br>
							';
						
							global $d_documentTypes;	
							
							
	//						$cus_name = url_encode($cus_name);															
				         $outHtml .= '
				 			
							<form method="post" action=""  id="formpardakht>
				   	
							<input type="hidden" name="pg" value="havaleMgmtPg">   
							<input type="hidden" name="cmd" value="addNewHavale()"> 
							<table    align="center" class="nasi">
							<tr style="background-color:'. $_SESSION['htablecolor']  .';" border="1">
						        <td colspan="10"  style="height: 50px;vertical-align:middle;"  ><font size="5">اطلاعات پرداخت پيش فاكتور</font></td>
	                       </tr>
	                        <tr>
	                             <td colspan="8"><hr style="color:'. $_SESSION['htablecolor']  .';height:40%;"></hr></td>
	                       </tr> 
					       <div id="pardakht" >';
						     $outHtml .= '<td ><center><b> کد سند: </b></center> </td>
							  	<td>'. getDocCombo().'</td>
								
								<td><b> &nbsp; </b></td>
						        <td>&nbsp; </td>				
					        </tr>
					      	<tr>
						        <td ><center> شماره فیش: </center> </td>
						        <td><input name="dpf_num" id="dpf_num" type="text"/></td>
						        <td ><center>نام بانک :</center> </td>
				              <td>

						  		'.getbankTypesComboBox1('dpf_bank').'
							</td> 
				                       
					        </tr>
					        <tr>
<!--					        <td ><center>نوع :</center> </td>
					        <td>'.getTypesatf('dpf_type').'</td>  -->
						       
						         <td ><center>نام شعبه :</center> </td>
						        <td><input name="dpf_branch" id="dpf_branch" type="text"/></td>	
						       
					        </tr>
					      	<tr>
					      	 <td align="center">
			                         تاريخ سررسيد <font color="red">  (مانند:92/01/01)</font></td>
						        <td><input name="dpf_sarresid" value="' .  $year_number.'/'.$month_number.'/'.$day_number.'" id="dpf_sarresid" type="text"  /></td>  
						        <td ><center>مبلغ: </center> </td>
						         <td><input name="dpf_price" id="dpf_price" type="text"  onBlur="this.value=formatCurrency(this.value);" /></td> 
						        
						    </tr> 
						    <tr>
						    <td>استان فی ما بین</td>
						     <td>'.getProvincesanad('dpf_prov_sanad').'</td>
						    
						    
						    </tr>
						   
						    <tr>
	                             <td colspan="8"><hr style="color:'. $_SESSION['htablecolor']  .';height:40%;"></hr></td>
	                       </tr>
	                       </table>
						   <div>
						     	<span><button type="button" value="اضافه كردن سند" onclick="addDocument2PfCheck('.$ph_code.')"  class="button blue skew"   style="font-size:10px; color:#FFFFFF">اضافه كردن سند</button></span>
					            <span> <button type="button" onclick=window.open("PrintPf.php?pf_code='.$pf_code.'&ph_code='.$ph_code.'&h_code='.$h_code.'&f_code='.$f_code.'&province_name='.urlencode($provinceName).'&name_customer='.urlencode($cus_name).'&province_id='.$_SESSION['dm_user_profile']['u_province_id'] .'&year_id='.$_SESSION['dm_user_profile']['u_year_id'] .'") value=" چاپ پيش فاكتور"  value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF"> چاپ پيش فاكتور</button></span>
					            <span> <input type="button" onclick="formReset()" class="button blue skew" style="font-size:10px; color:#FFFFFF;width:20%;" value="پاك كردن صفحه" /></span> 
					            
					            
					      </div>   			   
					</form>
					<br>
				 </div>
				 <div id="addedDocCntnr" style="direction: rtl;"></div>';
							
						}
		
	}else{
	$outHtml .= '<br><br><b><font color="red"><center> شماره پيش حواله نادرست است</center></font></b>';
		
	}
	$outHtml .= '</div>';
	$outHtml .='</table><br>';
		}
		else{
				?>
				<br><br></br>
				<div style="background:yellow" align="right"><center>شما پيش حواله اي  ايجاد نكرديد !!! </center></div>
				<?php 
		
			
		}
	//retrieve detail of payments
//	$query = "
//	 	SELECT *  
//	 	FROM 
//	 		dm_document 
//		WHERE 
//			d_u_id = ".$havaleMainInfo['ph_customer_code']." 
//		AND 
//			d_u_type = '".$havaleMainInfo['ph_customer_type']."'
//		ORDER BY d_reg_date DESC 
//		LIMIT 0, 30 
//	";
//	$lnk = mysql_query($query);
//	if(mysql_error()) print mysql_error();
//	if(mysql_affected_rows()>0){
//		$outHtml .='<table>
//		<tr>
//		  <td>رديف</td>
//		  <td>مبلغ</td>
//		  <td>کد سند</td>
//		  <td>توضيحات</td>
//		  <td></td>
//		  
//		</tr>
//		';
//		
//		while($row= mysql_fetch_assoc($lnk)){
//			
//			$outHtml .='
//			<tr>
//			  <td>رديف</td>
//			  <td>'.$row['d_payment'].'</td>
//			  <td>کد سند</td>
//			  <td>توضيحات</td>
//			  <td></td>
//			 
//			</tr>
//			
//			';
//			
//		}
//	$outHtml .='</table>';	 
//	}
	
	return $outHtml;	
		
}
function moarefi(){
	
	$ph_code = isset($_REQUEST['ph_code']) ? $_REQUEST['ph_code'] : '';
	
	?>
	<script type="text/javascript" >

	function formatCurrency(num) {
		num = num.toString().replace(/\$|\,/g,'');
		if(isNaN(num))
		num = "0";
		sign = (num == (num = Math.abs(num)));
		num = Math.floor(num*100+0.50000000001);
		cents = num%100;
		num = Math.floor(num/100).toString();
		if(cents<10)
		cents = "0" + cents;
		for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
		num = num.substring(0,num.length-(4*i+3))+','+
		num.substring(num.length-(4*i+3));
		return (((sign)?'':'-') + 'ریا ل' + num );
		}
	</script>
	<?php 
	
		$ph_code = isset($_REQUEST['ph_code']) ? $_REQUEST['ph_code'] : '';
		$display = isset($_REQUEST['display']) ? $_REQUEST['display'] : '8';
		$_SESSION['ph_code_d']=$ph_code;
				  		
		$queryp="SELECT * FROM dm_province 
            WHERE province_id=".$_SESSION['dm_user_profile']['u_province_id']."";
		$lnkp=mysql_query($queryp);
		print mysql_error();
		$rowp=mysql_fetch_assoc($lnkp);
		$provinceName=$rowp['province_name'];
		
	   $query = "SELECT * FROM dm_pish_havale WHERE ph_code=".$ph_code." 
			   AND
			      ph_id_province=".$_SESSION['dm_user_profile']['u_province_id']." 
			   AND 
			     ph_id_year=".$_SESSION['dm_user_profile']['u_year_id']."";	
	   $lnk = mysql_query($query);
//	   print $query;
	    if(mysql_affected_rows()>0){
	    $rowph=mysql_fetch_assoc($lnk);
	      $query = "SELECT * FROM dm_pish_havale WHERE ph_code=".$ph_code." 
			   AND
			      ph_id_province=".$_SESSION['dm_user_profile']['u_province_id']." 
			   AND 
			     ph_id_year=".$_SESSION['dm_user_profile']['u_year_id']."";	
	   $lnk = mysql_query($query);
	    $rowph=mysql_fetch_assoc($lnk);
	    
	    if($rowph['ph_customer_type']=='n'){
	    	$type='معمولی';
	    	    $querycus = "SELECT * FROM dm_customer WHERE code_customer=".$rowph['ph_customer_code']." 
			  ";	
			   $lnkcus = mysql_query($querycus);
			    $rowcus=mysql_fetch_assoc($lnkcus);
			    $name_cus=$rowcus['name_customer'];
			    $code_economic_customer=$rowcus['name_customer'];
	    }else{
	    	$type='متفرقه';
	    	    $querycus = "SELECT * FROM  dm_customer_mot WHERE cm_customer_id=".$rowph['ph_customer_code']." 
			  ";	
			    $lnkcus = mysql_query($querycus);
			    $rowcus=mysql_fetch_assoc($lnkcus);
			    $name_cus=$rowcus['	cm_name_customer'];
			    $code_economic_customer=$rowcus['cm_code_economic_customer'];
	    }
//	   print $query;
      	  
					$query="SELECT MAX(pf_code) maxId FROM dm_pish_factor 
					            WHERE
					            pf_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
					             ";
					         	    
					$lnk1=mysql_query($query);
				   //print $query;
					print mysql_error();
					$row1=mysql_fetch_assoc($lnk1);
					$pf_code=$row1['maxId'];
					$pf_code=$pf_code+1;
					
					$totalprice=0;
					if($display==1){
						$outHtml ='';
	//					echo $pf_code;
					}else{
						
						$outHtml = dspPreFactorFrm();
					}
					$outHtml .= '<input type="hidden" name="ph_code" id="ph_code" value="'. $ph_code .'">
					<div align="center"> <table  border="1" class="list" cellSpacing="6px;" width=100%>';

				    //retrieve mainInfo pishhavale	
					$query = "
					 	SELECT *  FROM dm_pish_havale 
				 
						WHERE 
							ph_code = '".$ph_code."' 
						AND
							ph_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
						AND
							ph_id_year=".$_SESSION['dm_user_profile']['u_year_id']."
					";
					$_SESSION['shPhforPf']=$ph_code;
					$lnk = mysql_query($query);
					sqlErr('wererewr');
					if(mysql_affected_rows()>0){
						
						$havaleMainInfo = mysql_fetch_assoc($lnk);
						
						$_SESSION['shPhforPf']=$havaleMainInfo['$ph_code'];
						$queryprov = "SELECT *  FROM dm_province
								           WHERE `province_id`='".$_SESSION['dm_user_profile']['u_province_id']."' ";
								  $lnkprov = mysql_query($queryprov);
								  $rowprov= mysql_fetch_assoc($lnkprov);
								    $province_code=$rowprov['province_code'];
						$query5 = "
							 	    SELECT *  FROM dm_customer 						 
											WHERE 
												code_customer = '".$havaleMainInfo['ph_customer_code']."' 
												 AND
						             customer_code_org=".$province_code.""; 
												
							//	print $query5;			   					
						$lnk5 = mysql_query($query5);
						$row5= mysql_fetch_assoc($lnk5);

						$outHtml .= '<br>
							
						  	<tr  class="rw1">
						         <td colspan="15"  style="height: 50px;vertical-align:middle;"  ><center><font size="5">معرفي نامه</center></font></td>  
					        </tr>
					       
							<tr class="rw0">
							     <td colspan="3"><center> <b>پيش حواله به شماره :</b></center></td><td align="center"><b> '.$ph_code.'</b></td><td align="center"><b> به نام :</b> </td><td colspan="10" align="right"> <b>&nbsp;&nbsp;'.$row5['name_customer'].'</b></td>
							</tr> ';
							
						//retrieve detail of pishHavale
						$query1 = "
						 	SELECT *  FROM dm_pish_havale_det 
					 
							WHERE 
								phd_ph_code = ".$ph_code."
							AND 
	                         phd_id_year=".$_SESSION['dm_user_profile']['u_year_id']." 
	                        AND
	                         phd_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
						";
						$lnk1 = mysql_query($query1);
				//		print $query1;
						sqlErr('for Display pfactor');
						
						if(mysql_affected_rows()>0){
							$outHtml .= '
										<tr class="rw1">
									<td colspan=15 align=center>
									   ريز پيش حواله
									</td>
								</tr>
										<tr class="rw0" style="font-weight:bold;">
											<td align="center">رديف</td>
											<td align="center">نام کالا</td>							
											<td align="center">كد كالا</td>			
											<td align="center">مقدار باقيمانده</td>
											<td align="center">كد محل تحويل</td>
											<td align="center">نام محل تحويل</td>
											<td align="center">نام تحويل گيرنده</td>
											<td align="center">كد قيمت</td>
											<td align="center">مقدار خريد</td>
										    <td align="center">قيمت واحد </td>
											<td colspan="2">قيمت کل</td>
								       
										</tr>
							';
							$inx = 0;
							while($row1= mysql_fetch_assoc($lnk1)){
								$inx++;
									$query = "
						 	SELECT *  FROM dm_product product
							left join dm_price price
							on product.p_id=price.price_p_id 
					 
							WHERE 
								p_code = ".$row1['phd_pid']." 
							AND 
								p_price_code=".$row1['phd_price_code']."
							AND
			 price_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
						";
							//print $query;
								$ln = mysql_query($query);
								$prod= mysql_fetch_assoc($ln);
							
								$price=$row1['phd_amount']*$prod['p_unit'];																				
								if(($inx)%2==1)
										$class="rw1";
										else
										 $class="rw0";
										 	$queryloc = "
						 	SELECT *  FROM dm_location_goods 
					 
							WHERE 
								l_id = ".$row1['phd_l_id']." 
							AND 
							   l_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
						";
//								print $query;
								$lnkloc = mysql_query($queryloc);
								$loc= mysql_fetch_assoc($lnkloc);
					//			print $queryloc;
								$outHtml .= '
										<tr class='.$class.'>
											<td align="center">'.$inx.'</td>
											<td align="center">'.$prod['p_name'].'</td>
											<td align="center">'.$row1['phd_pid'].'</td>
											<td align="center">'.$row1['phd_amount_remined'].'</td>
											<td align="center">'.$loc['l_code'].'</td>
											<td align="center">'.$loc['l_name'].'</td>
											<td align="center">'.$row1['phd_deli_name'].'</td>
											<td align="center">'.$row1['phd_price_code'].'</td>
											<td align="center">'.$row1['phd_amount'].'</td>';
								$query = "
						 	SELECT *  FROM dm_product product
							left join dm_price price
							on product.p_id=price.price_p_id 
					 
							WHERE 
								p_code = ".$row1['phd_pid']." AND p_price_code=".$row1['phd_price_code']."
								and
			 price_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
						";
						//		print $query;
								$ln = mysql_query($query);
								$prod= mysql_fetch_assoc($ln);
							
								$price=$row1['phd_amount']*$prod['p_unit'];
											
											$outHtml .= '<td>'.$prod['p_sellprice'].'</td>
														 <td>'.$row1['phd_price'].'</td>
								';
					
								$totalprice =$row1['phd_price']+$totalprice;
							}
						
							$outHtml .= '
									</table>
									<div>
										 <span> جمع کل:'.$totalprice.'</span>
										 <span ><button type="button" value="ثبت معرفی نامه" onclick="addMoarefinameh(\'\', \''.$ph_code.'\',\''.$totalprice.'\', \''.$pf_code.'\'); this.style.display=\'none\'" class="button blue skew" style="font-size:10px; color:#FFFFFF">
					                       ثبت معرفی نامه</button>					                       
									    	  <span> <button type="button" onclick=window.open("PrintMoarefi.php?PhNo='.$ph_code.'&reqNo='.urlencode($havaleMainInfo['cm_req_num']).'&cus_name='.urlencode($name_cus).'&cus_economic='.urlencode( $code_economic_customer ).'&cus_postal='.  $cInfo[$fieldPrefix.'code_postal_costumer'] .'&cus_address_office='. urlencode($cInfo[$fieldPrefix.'customer_address_office']) .'&cus_tel='. $cInfo[$fieldPrefix.'customer_tel'] .'&cus_type='. $Type .'&cm_req_date='. urlencode($havaleMainInfo['cm_req_date']) .'&cus_category='. $cInfo[$fieldPrefix.'customer_category'] .'&status='. 1 .'&province_name='. urlencode($provinceName ).'&province_id='.  $_SESSION['dm_user_profile']['u_province_id'] .'&year_id='.  $_SESSION['dm_user_profile']['u_year_id'] .'","_blank") value=" چاپ معرفي نامه"  value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF"> چاپ معرفي نامه</button></span> 					                          																													
										</div>
								
								<br>
							';			       				
						}
		
	}else{
	$outHtml .= '<br><br><b><font color="red"><center> شماره پيش حواله نادرست است</center></font></b>';
		
	}
	$outHtml .= '</div>';
	$outHtml .='</table><br>';
		}
		else{
				?>
				<br><br></br>
				<div style="background:yellow" align="right"><center>شما پيش حواله اي  ايجاد نكرديد !!! </center></div>
				<?php 
					
		}
	
	return $outHtml;	
		
}
function moarefinameh(){
	
	$ph_code = isset($_REQUEST['ph_code']) ? $_REQUEST['ph_code'] : '';
	$display = isset($_REQUEST['display']) ? $_REQUEST['display'] : '8';
	
	   $query = "SELECT * FROM dm_pish_havale WHERE ph_code=".$ph_code." 
	AND 
	     ph_id_year=".$_SESSION['dm_user_profile']['u_year_id']."
    AND  ph_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
	     ";
		$lnk = mysql_query($query);
		if(mysql_affected_rows()>0){
	
	$query="SELECT MAX(pf_code) maxId FROM dm_pish_factor 
	          WHERE
	            pf_id_province=".$_SESSION['dm_user_profile']['u_province_id']."";

	$lnk1=mysql_query($query);
//	print $query;
	print mysql_error();
	$row1=mysql_fetch_assoc($lnk1);
	$pf_code=$row1['maxId'];
	$pf_code=$pf_code+1;
	
	$totalprice=0;
	if($display==1){
		$outHtml ='';
	}else{
		
		$outHtml = dspPreFactorFrm();
	}
	$outHtml .= '<div align="center"> <table  border="1" align="center" class="list">';
	
	
    //retrieve mainInfo pishhavale	
	$query = "
	 	SELECT *  FROM dm_pish_havale 
 
		WHERE 
			ph_code = '".$ph_code."' 
		AND
			ph_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
		AND 
	     ph_id_year=".$_SESSION['dm_user_profile']['u_year_id']."
	";
	$_SESSION['shPhforPf']=$ph_code;
	$lnk = mysql_query($query);
	sqlErr('wererewr');
	if(mysql_affected_rows()>0){
		
		$havaleMainInfo = mysql_fetch_assoc($lnk);
		
		$_SESSION['shPhforPf']=$havaleMainInfo['$ph_code'];
		
		$outHtml .= '<br>
			<tr>
				<td colspan="12"  style="height: 60px;vertical-align:middle;"><center><b> معرفي نامه</b></center></td>
		
			</tr>
			<tr>';
		$queryprov = "SELECT *  FROM dm_province
		           WHERE `province_id`='".$_SESSION['dm_user_profile']['u_province_id']."' ";
		  $lnkprov = mysql_query($queryprov);
		  $rowprov= mysql_fetch_assoc($lnkprov);
		    $province_code=$rowprov['province_code'];
		$query5 = "
			 	SELECT *  FROM dm_customer 
		 
				WHERE 
					customer_id = '".$havaleMainInfo['ph_customer_code']."' 
		
	                AND
			             customer_code_org=".$province_code."";
						 
	
		$lnk5 = mysql_query($query5);
		$row5= mysql_fetch_assoc($lnk5);
		
	 $outHtml .= '   <td colspan="3"><center> پيش حواله به شماره</center></td><td align="center"> '.$ph_code.'</td><td align="center"> به نام</td><td colspan="10" > '.$row5['name_customer'].'</td>
			</tr> 
			
		';
		
		//retrieve detail of pishHavale
		$query = "
		 	SELECT *  FROM dm_pish_havale_det 
	 
			WHERE 
				phd_ph_code = ".$ph_code." 
		  AND 
	       phd_id_year=".$_SESSION['dm_user_profile']['u_year_id']."
	      AND
	        phd_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
		";
		$lnk = mysql_query($query);
		sqlErr('for Display pfactor');
		if(mysql_affected_rows()>0){
			$outHtml .= '
						<tr>
					<td colspan=12 align=center>
					   ريز معرفي نامه
					</td>
				</tr>
						<tr>
							<td>رديف</td>
							<td>نام کالا</td>
							<td>كد كالا</td>
							<td>مقدار باقيمانده</td>
							<td>كد محل تحويل</td>
							<td>نام محل تحويل</td>
							<td>نام تحويل گيرنده</td>
							<td>تحويل با</td>
							<td>كد قيمت</td>
							<td>مقدار خريد</td>
						    <td>قيمت واحد </td>
							<td >قيمت كالا </td>
							<td>هزينه افزودني</td>
							<td colspan="2">قيمت کل</td>
				       </td>
						</tr>
			';
			$inx = 0;
			while($row= mysql_fetch_assoc($lnk)){
				$inx++;
				
				$outHtml .= '
						<tr>
							<td>'.$inx.'</td>
							<td>'.$row['phd_name'].'</td>
							<td>'.$row['phd_code'].'</td>
							<td>'.$row['phd_amount_remined'].'</td>
							<td>'.$row['phd_l_code'].'</td>
							<td>'.$row['phd_l_name'].'</td>
							<td>'.$row['phd_deli_name'].'</td>
							<td>'.$row['phd_deli_with'].'</td>
							<td>'.$row['phd_price_code'].'</td>
							<td>'.$row['phd_amount'].'</td>';
				$query = "
		 	      SELECT *  FROM dm_product product
							left join dm_price price
							on product.p_id=price.price_p_id 
				 
						WHERE 
							p_id = ".$row['phd_code']." 
					";
				
				$ln = mysql_query($query);
				$prod= mysql_fetch_assoc($ln);
			
				$price=$row['phd_amount']*$prod['p_unit'];
							
							$outHtml .= '<td>'.$prod['p_sellprice'].'</td>
										 <td>'.$price.'</td>
				';
	if($prod['p_redundancy']=='1'){
							
							$query = "
		 	SELECT *  FROM dm_charge_factors 
	 
			WHERE 
				ch_code_good = ".$row['phd_code']." 
		";
				$lnk = mysql_query($query);
				$row2= mysql_fetch_assoc($lnk);
//				print $query;
				$hazineAfzodani=$row2['ch_ratio']*$row2['ch_charge'];
				$eachPrice=$price+$hazineAfzodani;
				$outHtml .='<td>'.$hazineAfzodani.'</td>
				            <td>'.$eachPrice.'</td>  
				</tr>';
			}
			else{
				$hazineAfzodani=0;
				$eachPrice=$price+$hazineAfzodani;
				$outHtml .='<td>ندارد</td>
				            <td>'.$eachPrice.'</td>
				</tr>';
			}
				$totalprice =$eachPrice+$totalprice;
			}
		
			$outHtml .= '
					
					<tr><td> جمع کل:
					'.$totalprice.'</td>
					<td colspan="11" align="center"><button type="button" value="ثبت پيش فاكتور" onclick="addMoarefinameh(\'\', \''.$ph_code.'\',\''.$totalprice.'\', \''.$pf_code.'\'); this.style.display=\'none\'" class="button blue skew" style="font-size:10px; color:#FFFFFF">
					ثبت معرفي نامه</button></td>
				    <td> <button type="button" onclick=window.open("PrintMoarefi.php?pf_code='.$pf_code.'&ph_code='.$ph_code.'&h_code='.$h_code.'&f_code='.$f_code.'&province_id='.$_SESSION['dm_user_profile']['u_province_id'].'&year_id="'.$_SESSION['dm_user_profile']['u_year_id'].'","_blank") value=" چاپ پيش فاكتور" this.style.display=\'none\'"  value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF"> چاپ معرفي نامه</button></td>
					</tr>
				</table>
			';
			global $d_documentTypes;
								
		}
		
	}else{
	$outHtml .= '<br><br><b><font color="red"><center> شماره پيش حواله نادرست است</center></font></b>';
		
	}
	$outHtml .= '</div>';
	$outHtml .='</table>';
		}
		else{
				
				 ?>
				 <br><br></br>
				 <div style="background:yellow" align="center">شما پيش حواله صادر نکرديد!!!!!!!</div>
				 <?php 
			
		}

	
	return $outHtml;	
		
}
function dspmoarefi(){
	
	
	
	$ph_code = isset($_REQUEST['ph_code']) ? $_REQUEST['ph_code'] : '';
	$display = isset($_REQUEST['display']) ? $_REQUEST['display'] : '8';
	
	$day_number = jdate('j');
    $month_number = jdate('n');
    $year_number = jdate('y');
    $day_name = jdate('l');    
	
	if($month_number<9){
	$month_number ='0'.$month_number;	
	}
	if($day_number<9){
	$day_number ='0'.$day_number;	
	}

	?>
	<input type="hidden" name="ph_code" value="<?php echo  $ph_code ?>">
	<?php 
	$querypro="SELECT * FROM dm_province WHERE 
	            	  province_id=".$_SESSION['dm_user_profile']['u_province_id']; 
	$lnkpro = mysql_query($querypro); 
	$rowpro = mysql_fetch_assoc($lnkpro);
	$province_code=$rowpro['province_code'];
	   $query = "SELECT * FROM dm_pish_havale WHERE ph_code=".$ph_code."
	   
	        AND
	            ph_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
	        AND 
	          ph_id_year=".$_SESSION['dm_user_profile']['u_year_id']."
	        ";
	//print $query;  
		$lnk = mysql_query($query);
//agar aslan en ph sader shode bod
	if(mysql_affected_rows()>0){
			
		//agar baraye on pf sabt nashode bood

		$queryppf="SELECT * FROM dm_pish_factor 
					          WHERE
					             	pf_ph_code=".$ph_code."
					           AND		            
					                pf_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
					           AND 
			                      pf_id_year=".$_SESSION['dm_user_profile']['u_year_id']."
			                   AND
				                   pf_type=". 0 ."
				                 ";
			                      	                    		         
		     // print   $queryppf;
					$lnkppf=mysql_query($queryppf);
					print mysql_error();	
			if(mysql_affected_rows()>0){
				$out=dsppHavaleFrm().'<br><br><div align="center" style="background: yellow"><b>  براي اين پيش نويس پيش فاكتور صادر شده است   !!!!!!!!</b></font></div>';
			echo $out;
				
			}else{
			
					//ager en pf ghablan sader shode bood			
							   $query="SELECT * FROM dm_pish_factor 
								          WHERE
								             	pf_ph_code=".$ph_code."
								           AND		            
								                pf_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
								           AND 
						                      pf_id_year=".$_SESSION['dm_user_profile']['u_year_id']."
						                   AND
							                   pf_type=". 1 ."
							               AND
							                  pf_status_ebtal= ". 0 ."  ";
						                      	                    		         
					    //  print   $query;
								$lnk=mysql_query($query);
								print mysql_error();
								$rowPF=mysql_fetch_assoc($lnk);
								if(mysql_affected_rows()>0){				
					                 $status='1';
					                 $pf_code=$rowPF['pf_code'];
					//	ager ghablan sabt nashode bood			
								}else{
					  
									$query="SELECT MAX(pf_code) maxId FROM dm_pish_factor 
									          WHERE
									                pf_id_province=".$_SESSION['dm_user_profile']['u_province_id']."								
						                       AND
						                            pf_type=". 1 .""; 
						 	         	    
									$lnk1=mysql_query($query);
								//	print $query;
									print mysql_error();
									$row1=mysql_fetch_assoc($lnk1);
									$pf_code=$row1['maxId'];
									$pf_code=$pf_code+1;
									$Display='block';
								       $status='2';
											}	
									$totalprice=0;
									if($display==1){
										$outHtml ='';
									}else{
										
										$outHtml = dsppHavaleFrm();
									}
									$outHtml .= '<div align="center"> <table  border="1" class="list" style="width:80%;">
									     <input type="hidden" name="ph_code" id="ph_code" value="'. $ph_code .'">';
						
						
					    //retrieve mainInfo pishhavale	
						$query = "
						 	SELECT *  FROM dm_pish_havale 
					 
							WHERE 
								ph_code = '".$ph_code."' 
							AND
								ph_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
						   AND 
						       ph_id_year=".$_SESSION['dm_user_profile']['u_year_id']."
						";
					//	print $query;
						$_SESSION['shPhforPf']=$ph_code;
						$lnk = mysql_query($query);
						sqlErr('wererewr');
						if(mysql_affected_rows()>0){		
							$havaleMainInfo = mysql_fetch_assoc($lnk);		
							$_SESSION['shPhforPf']=$havaleMainInfo['$ph_code'];	
							
							$queryprov = "SELECT *  FROM dm_province
							           WHERE `province_id`='".$_SESSION['dm_user_profile']['u_province_id']."' ";
							  $lnkprov = mysql_query($queryprov);
							  $rowprov= mysql_fetch_assoc($lnkprov);
							    $province_code=$rowprov['province_code'];
					
								$query = "
								 	SELECT *  FROM dm_customer 
							 
									WHERE 
										code_customer = '".$havaleMainInfo['ph_customer_code']."' 		
								    AND
									    customer_code_org=".$province_code."";	
								$lnk = mysql_query($query);
								sqlErr('for customer');
								$cusMainInfo = mysql_fetch_assoc($lnk);	
										$cusName=$cusMainInfo['name_customer'];
										$Type='معمولی';
					
							$outHtml .= '<br>	            	
									          <tr class="rw1" style="height:30px;vertical-align:middle;font-weight:bold;"> 			
							                  <td>&nbsp;</td>
									          <td colspan="2"> معرفي نامه به شماره : '.$pf_code.'</td><td colspan="2">پيش حواله به شماره : '.$ph_code.'</td>
									          <td colspan="3"> به نام: '.$cusName.'</td>';			
							
							//retrieve detail of pishHavale
							$queryy = "
							 	SELECT *  FROM dm_pish_havale_det 
						 
								WHERE 
									phd_ph_code = ".$ph_code."
								AND 
						           phd_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
						        ";
							$lnky= mysql_query($queryy);
							//print $queryy;
							sqlErr('for Display pfactor');
							
							if(mysql_affected_rows()>0){
								
								$outHtml .= '
											<tr class="rw0">
										<td colspan=12 align=center style="height:30px;vertical-align:middle;font-weight:bold;">
										   ريز معرفي نامه
										</td>
									</tr>
											<tr class="rw1" style="height:30px;vertical-align:middle;font-weight:bold;">
												<td align="center" style="font-weight:bold;" width=5%>رديف</td>
												<td align="center" width=20%>نام کالا</td>
												<td align="center" width=15%>كد كالا</td>													
												<td align="center" width=15%>كد قيمت</td>
												<td align="center" width=20%>مقدار خريد</td>
											    <td align="center" width=15%>قيمت واحد </td>
											     <td align="center" width=15%>هزينه هر واحد </td>
												<td width=15%>قيمت كالا </td>	
												<td >&nbsp; </td>				       
											</tr>';				
								$inx = 0;
								while($row= mysql_fetch_assoc($lnky)){
									
							       $p_code=$row['phd_pid'];
							       $p_price_code=$row['phd_price_code'];
										$query1 = "
									 	SELECT *  FROM dm_product product
												left join dm_price price
												on product.p_id=price.price_p_id 
								 
										WHERE 
											p_code = ".$p_code."
										AND p_price_code=".$p_price_code." 
										
										AND price_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
										";			
							$lnk1 = mysql_query($query1);
							sqlErr('for Display pfactor');
							$row1= mysql_fetch_assoc($lnk1);
							$p_id=$row['phd_pid'];
					
							$querych = "SELECT *  FROM dm_product product
											left join dm_price price
											on product.p_id=price.price_p_id 
										    left join  dm_charge_factors charge on price.price_id=charge.ch_price_id
												WHERE 
													p_code = ".$p_code." 
												AND
													p_price_code=".$p_price_code."
												AND
													price_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
												AND
												   ch_id_province=".$_SESSION['dm_user_profile']['u_province_id']."";
										//	print $querych;		
								$lnkch = mysql_query($querych);
							   sqlErr('for Display charge');		   
									   $hazine=$row['phd_p_add'];
									$inx++;
									if(($inx)%2==1)
									$class="rw0";
									else
									 $class="rw1";
									$phd_priceh=formatMoney($row['phd_priceh']);
									$amount=formatMoney($row['phd_amount']);
									$outHtml .= '
											<tr class="'.$class.'">
												<td align="center">'.$inx.'</td>
												<td align="center">'.$row1['p_name'].'</td>
												<td align="center">'.$row1['p_code'].'</td>								
												<td align="center">'.$row['phd_price_code'].'</td>
												<td align="center">'.$amount.'</td>';
																
												$outHtml .= '<td align="center">'.$row1['p_sellprice'].'</td>
											             	<td align="center">'.$hazine.'</td>
															 <td align="center">'.$phd_priceh.'</td>';	
									$totalprice =$totalprice+$row['phd_priceh'];
								}
								$totalprice=formatMoney($totalprice);
							if($status==2){
								$outHtml .= '
										</table>
									<div><span> جمع کل:
										'.$totalprice.'</span>
										<span><button type="button" value="ثبت معرفي نامه" onclick="addMoarefinameh(\'\', \''.$ph_code.'\',\''.$totalprice.'\', \''.$pf_code.'\'); this.style.display=\'none\'" class="button blue skew" style="font-size:10px; color:#FFFFFF">
										ثبت معرفي نامه</button>
										</span>
									</div>
									';
								     ?>
									   <input type="hidden" name="total_price"  id="total_price" value="<?php echo $totalprice ?>">
									<?php 
								}
								else {
									$outHtml .= '
										</table>
									<div><span> جمع کل:
										'.$totalprice.'</span>
										<span>
									<button type="button" onclick=window.open("PrintMoarefi.php?PhNo='.$ph_code.'&reqNo='.$havaleMainInfo['cm_req_num'].'&cus_name='.urlencode($cusName).'&cus_economic='.urlencode( $code_economic_customer ).'&cus_postal='.  $cusMainInfo['code_postal_costumer'] .'&year_id='.  $_SESSION['dm_user_profile']['u_year_id'] .'&cus_address_office='. urlencode($cusMainInfo['customer_address_office']) .'&cus_tel='. $cusMainInfo['customer_tel'] .'&province_id='.  $_SESSION['dm_user_profile']['u_province_id'] .'","_blank") value=" چاپ معرفي نامه"  value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF"> چاپ معرفي نامه</button></span>
										
										</div>';
									?>
									<!--    &cus_tel='. $cInfo[$fieldPrefix.'customer_tel'] .'&cus_type='. $Type .'&cm_req_date='. $havaleMainInfo['cm_req_date'] .'&cus_category='. $cInfo[$fieldPrefix.'customer_category'] .'&status='. 1 .'&province_name='.urlencode($provinceName).'&province_id='.  $_SESSION['dm_user_profile']['u_province_id'] .'&year_id='.  $_SESSION['dm_user_profile']['u_year_id'] .'","_blank") value=" چاپ معرفي نامه"  value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF"> چاپ معرفي نامه</button></span>-->
									
									   <input type="hidden" name="total_price"  id="total_price" value="<?php echo $totalprice ?>">
									<?php 
												
							$queryp="SELECT * FROM dm_province 
					        WHERE province_id=".$_SESSION['dm_user_profile']['u_province_id']."";
							$lnkp=mysql_query($queryp);
							print mysql_error();
							$rowp=mysql_fetch_assoc($lnkp);
							$provinceName=$rowp['province_name'];	
							
						
								$query = "
							 	SELECT *  FROM dm_pf_document 
						 
								WHERE 
									dpf_pf_code = ".$pf_code."  
									AND 
									dpf_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
									 AND 
						       dpf_id_year=".$_SESSION['dm_user_profile']['u_year_id']."
							";
								$lnk = mysql_query($query);
					//	print $query;	
							if(mysql_error()) print mysql_error();
							
							            }
							}
							
						}
						$outHtml .= '</div>';
						$outHtml .='</table>';
	//bara chek kardan queryppf
									}
	}
		else{
			
			$out=dsppHavaleFrm().'<br><br><div align="center" style="background: yellow"><b>  شماره پیش حواله نادرست است   !!!!!!!!</b></font></div>';
			echo $out;	
		}	
	return $outHtml;	
	
	
}
function dspPishFactor(){
	
	?>
	
	<script type="text/javascript" >
function addDocument2PfCheck(ph_code){
		
		if(fObj('DocCombo').value==''){
			
			alert('لطفا کد سند را انتخاب کنيد');
			return;
		}
		
		if(fObj('DocCombo').value==5){

				
			 if(fObj('dpf_prov_sanad').value==-2){
					
					alert('لطفا شهرستان را وارد کنید');
					return;
				}

				
		}
	if(fObj('DocCombo').value==2){

			
			if(fObj('dpf_bank').value==-2){
				
				alert('لطفا نام بانک را انتخاب کنید');
				return;
			}
			
			if(fObj('dpf_num').value==''){
							
							alert('لطفا شماره فیش را وارد کنید');
							return;
						}
			if(fObj('dpf_branch').value==''){
				
				alert('لطفا نام شعبه را وارد کنید');
				return;
			}
				
		}

		
		
       if(fObj('dpf_price').value==''){
			
			alert('لطفا مبلغ را وارد کنيد');
			return;
		}
       addDocument2Pf();
    	}
	function formatCurrency(num) {
	    num = num.toString().replace(/\$|\,/g,'');
	    if(isNaN(num)) {
	        num = "0";
	    }
	    sign = (num == (num = Math.abs(num)));
	    num = Math.floor(num*100+0.50000000001);
	    cents = num % 100;
	    num = Math.floor(num/100).toString();
	    if(cents < 10) {
	        cents = "0" + cents;
	    }
	    for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++) {
	        num = num.substring(0,num.length-(4*i+3))+','+num.substring(num.length-(4*i+3));
	    }
	    if(cents>0){
	    return (((sign)?'':'-')  + num + '.' + cents);
	    }else{
	    	 return (((sign)?'':'-')  + num );

	    }
	}
	function fill(thisValue) {
		$('#inputString').val(thisValue);
		setTimeout("$('#suggestions').hide();", 200);	
	}
	function formReset()
	{
	document.getElementById("formpardakht").reset();
	}
	
	</script>
	
	<?php 
	
	$ph_code = isset($_REQUEST['ph_code']) ? $_REQUEST['ph_code'] : '';
	$display = isset($_REQUEST['display']) ? $_REQUEST['display'] : '8';
	
	$day_number = jdate('j');
    $month_number = jdate('n');
    $year_number = jdate('y');
    $day_name = jdate('l');    
	
	if($month_number<9){
	$month_number ='0'.$month_number;	
	}
	if($day_number<9){
	$day_number ='0'.$day_number;	
	}

	?>
	<input type="hidden" name="ph_code" value="<?php echo  $ph_code ?>">
	<?php 
	$querypro="SELECT * FROM dm_province WHERE 
	            	  province_id=".$_SESSION['dm_user_profile']['u_province_id']; 
	$lnkpro = mysql_query($querypro); 
	$rowpro = mysql_fetch_assoc($lnkpro);
	$province_code=$rowpro['province_code'];
	   $query = "SELECT * FROM dm_pish_havale WHERE ph_code=".$ph_code."
	   
	        AND
	            ph_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
	        AND 
	          ph_id_year=".$_SESSION['dm_user_profile']['u_year_id']."
	        ";
	//print $query;  
		$lnk = mysql_query($query);
//agar aslan en ph sader shode bod
		if(mysql_affected_rows()>0){
			
//ager en pf ghablan sader shode bood			
		   $query="SELECT * FROM dm_pish_factor 
			          WHERE
			             	pf_ph_code=".$ph_code."
			           AND		            
			                pf_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
			           AND 
	                      pf_id_year=".$_SESSION['dm_user_profile']['u_year_id']."
	                     AND
		                   pf_type=". 0 ."
		                   ";
	                      	                    		         
 //      print   $query;
			$lnk=mysql_query($query);
			print mysql_error();
			$rowPF=mysql_fetch_assoc($lnk);
			if(mysql_affected_rows()>0){				
                 $status='1';
                 $pf_code=$rowPF['pf_code'];
//	ager ghablan sabt nashode bood			
			}else{
   
				$query="SELECT MAX(pf_code) maxId FROM dm_pish_factor 
				          WHERE
				                pf_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
	                       AND
	                            pf_type=". 0 .""; 
	 	         	    
				$lnk1=mysql_query($query);
			//	print $query;
				print mysql_error();
				$row1=mysql_fetch_assoc($lnk1);
				$pf_code=$row1['maxId'];
				$pf_code=$pf_code+1;
				$Display='block';
			       $status='2';
						}	
				$totalprice=0;
				if($display==1){
					$outHtml ='';
				}else{
					
					$outHtml = dspPreFactorFrm();
				}
				$outHtml .= '<div align="center"> <table  border="1" class="list" style="width:90%;">
				     <input type="hidden" name="ph_code" id="ph_code" value="'. $ph_code .'">';
	
    //retrieve mainInfo pishhavale	
	$query = "
	 	SELECT *  FROM dm_pish_havale  ph
	 	  left join dm_operation_acc opr
	 	   on ph.ph_operation_id=opr.g_id
			WHERE 
				ph_code = '".$ph_code."' 
			AND
				ph_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
		   AND 
		       ph_id_year=".$_SESSION['dm_user_profile']['u_year_id']."";
		
	//print $query;
	$_SESSION['shPhforPf']=$ph_code;
	$lnk = mysql_query($query);
	sqlErr('wererewr');
	if(mysql_affected_rows()>0){		
		$havaleMainInfo = mysql_fetch_assoc($lnk);		
		$_SESSION['shPhforPf']=$havaleMainInfo['$ph_code'];	
		
		$queryprov = "SELECT *  FROM dm_province
		           WHERE `province_id`='".$_SESSION['dm_user_profile']['u_province_id']."' ";
		  $lnkprov = mysql_query($queryprov);
		  $rowprov= mysql_fetch_assoc($lnkprov);
		    $province_code=$rowprov['province_code'];
		    	
		if($havaleMainInfo['ph_customer_type']=='n'){
			$query = "
			 	SELECT *  FROM dm_customer 
		 
				WHERE 
					code_customer = '".$havaleMainInfo['ph_customer_code']."' 		
			    AND
				    customer_code_org=".$province_code."";	
	$lnk = mysql_query($query);
	//print $query;
	sqlErr('for customer');
	$cusMainInfo = mysql_fetch_assoc($lnk);	
			$cusName=$cusMainInfo['name_customer'];
			$Type='معمولی';
			
		}else{
				$query = "
	 	SELECT *  FROM dm_customer_mot 
 
		WHERE 
			cm_customer_id = '".$havaleMainInfo['ph_customer_code']."' 		
	";
	$lnk = mysql_query($query);
	sqlErr('for customer1');
	$cusMainInfo = mysql_fetch_assoc($lnk);	
			$cusName=$cusMainInfo['cm_name_customer'];
			$Type='متفرقه';				
		}
		
		$outHtml .= '<br>	            	
				          <tr class="rw1" style="height:30px;vertical-align:middle;font-weight:bold;"> 			
		                 
				          <td colspan="2"> پيش فاکتور به شماره : '.$pf_code.'</td><td colspan="2">پيش حواله به شماره : '.$ph_code.'</td>
				          <td colspan="5"> به نام: '.$cusName.'</td>
				          </tr>
				          <tr class="rw1" style="height:30px;vertical-align:middle;font-weight:bold;"> 			
		                 
				          <td colspan="2"> نوع عميات :</td><td colspan="2"> '.$havaleMainInfo['g_acc_name'].'</td><td colspan="2">&nbsp;</td>
				          <td colspan="4"> &nbsp;</td>
				          </tr>
				          
				          ';			
		                     
		//retrieve detail of pishHavale
		$queryy = "
		 	SELECT *  FROM dm_pish_havale_det 
	 
			WHERE 
				phd_ph_code = ".$ph_code."
			AND 
	           phd_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
	        ";
			
	
		$lnky= mysql_query($queryy);
		//print $queryy;
		sqlErr('for Display pfactor');
		
		if(mysql_affected_rows()>0){
			
			$outHtml .= '
						<tr class="rw0">
					<td colspan=12 align=center style="height:30px;vertical-align:middle;font-weight:bold;">
					   ريز پيش فاكتور
					</td>
				</tr>
						<tr class="rw1" style="height:30px;vertical-align:middle;font-weight:bold;">
							<td align="center" style="font-weight:bold;" width=5%>رديف</td>
							<td align="center" width=20%>نام کالا</td>
							<td align="center" width=15%>كد كالا</td>													
							<td align="center" width=15%>كد قيمت</td>
							<td align="center" width=20%>مقدار خريد</td>
						    <td align="center" width=15%>قيمت واحد </td>
						    <td align="center" width=15%>محل تحويل </td>
						     <td align="center" width=15%>هزينه هر واحد </td>
							<td width=15%>قيمت كالا </td>	
							<td >&nbsp; </td>				       
						</tr>';				
			$inx = 0;
			while($row= mysql_fetch_assoc($lnky)){
				
		       $p_code=$row['phd_pid'];
		       $p_price_code=$row['phd_price_code'];
					$query1 = "
				 	SELECT *  FROM dm_product product
							left join dm_price price
							on product.p_id=price.price_p_id 
			 
					WHERE 
						p_code = ".$p_code."
					AND p_price_code=".$p_price_code." 
					
					AND price_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
					";
		
//	print $query1;			
		$lnk1 = mysql_query($query1);
		sqlErr('for Display pfactor');
		$row1= mysql_fetch_assoc($lnk1);
		$p_id=$row['phd_pid'];
	///	
		
		$querych = "SELECT *  FROM dm_product product
						left join dm_price price
						on product.p_id=price.price_p_id 
					    left join  dm_charge_factors charge on price.price_id=charge.ch_price_id
							WHERE 
								p_code = ".$p_code." 
							AND
								p_price_code=".$p_price_code."
							AND
								price_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
							AND
							   ch_id_province=".$_SESSION['dm_user_profile']['u_province_id']."";
					//	print $querych;		
			$lnkch = mysql_query($querych);
		   sqlErr('for Display charge');
		   
				   $hazine=$row['phd_p_add'];
$queryl = "SELECT *  FROM dm_location_goods
						
							WHERE 
								l_id = ".$row['phd_l_id']." 
							
							AND
							   l_id_province=".$_SESSION['dm_user_profile']['u_province_id']."";
					//	print $querych;		
			$lnkl = mysql_query($queryl);
			$rowl= mysql_fetch_assoc($lnkl);
		   sqlErr('for Display charge');
				$inx++;
				if(($inx)%2==1)
				$class="rw0";
				else
				 $class="rw1";
				//$phd_pricehh= int($row['phd_priceh']);
				$phd_priceh=formatMoney($row['phd_priceh']);
				$amount=formatMoney($row['phd_amount']);
				$outHtml .= '
						<tr class="'.$class.'">
							<td align="center">'.$inx.'</td>
							<td align="center">'.$row1['p_name'].'</td>
							<td align="center">'.$row1['p_code'].'</td>								
							<td align="center">'.$row['phd_price_code'].'</td>
							<td align="center">'.$amount.'</td>
							
							';
											
							$outHtml .= '<td align="center">'.$row1['p_sellprice'].'</td>
							           <td align="center">'.$rowl['l_name'].'</td>
						             	<td align="center">'.$hazine.'</td>
										 <td align="center">'.$phd_priceh.'</td>';
							
						//	echo $row['phd_status'];
							
							if($row['phd_status']==1){
								 $sanad=1;
							}
////mikhad check kone aya mitone etelaate asnado pak kone ya na								
//								           $outHtml .= '<td align="center"> ثبت شده</td>';
//							}else{
//										 $outHtml .= '<td align="center"><button type="button" value="ثبت و ايجاد حواله " onclick="addNewHavale(\'\', \''.$ph_code.'\', \''.$pf_code.'\', \''.$row['phd_price'].'\', \''.$row['phd_id'].'\', \''.$havaleMainInfo['ph_customer_code'].'\')"  class="button blue skew" style="font-size:10px; color:#FFFFFF" style="width:20px;">ثبت و ايجاد حواله</button></td>';}				
				$totalprice =$totalprice+$row['phd_priceh'];
			}
			$totalprice=formatMoney($totalprice);
		if($status==2){
			$outHtml .= '
					</table>
				<div><span> جمع کل:
					'.$totalprice.'</span>
					<span><button type="button" value="ثبت پيش فاكتور" onclick="addPfactor(\'\', \''.$ph_code.'\',\''.$totalprice.'\', \''.$pf_code.'\'); this.style.display=\'none\'" class="button blue skew" style="font-size:10px; color:#FFFFFF">
					ثبت پيش فاكتور</button>
					</span>
				</div>
				';
			     ?>
				   <input type="hidden" name="total_price"  id="total_price" value="<?php echo $totalprice ?>">
				<?php 
			}
			else {
				$outHtml .= '
					</table>
				<div><span> جمع کل:
					'.$totalprice.'</span>
					<span><button type="button" value="ثبت پيش فاكتور" onclick="addPfactor(\'\', \''.$ph_code.'\',\''.$totalprice.'\', \''.$pf_code.'\');  class="button blue skew" style="font-size:10px;display:none; color:#FFFFFF">
					ثبت پيش فاكتور</button>
					</div>';
				?>
				   <input type="hidden" name="total_price"  id="total_price" value="<?php echo $totalprice ?>">
				<?php 
							
		$queryp="SELECT * FROM dm_province 
        WHERE province_id=".$_SESSION['dm_user_profile']['u_province_id']."";
		$lnkp=mysql_query($queryp);
		print mysql_error();
		$rowp=mysql_fetch_assoc($lnkp);
		$provinceName=$rowp['province_name'];	
		
	 $outHtml .= '
	     <table  border="1"  align="center" class="list" style="width:80%;" >
	         <tr class="rw0"  >
	             <td colspan="15" align="center" style="font-weight:bold;height:30px;vertical-align:middle;"> اطلاعات اسنادی که قبلا وارد شده </td>
	         </tr>';
					
			$query = "
		 	SELECT *  FROM dm_pf_document 
	 
			WHERE 
				dpf_pf_code = ".$pf_code."  
				AND 
				dpf_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
				 AND 
	       dpf_id_year=".$_SESSION['dm_user_profile']['u_year_id']."
		";
			$lnk = mysql_query($query);
	//print $query;	
		if(mysql_error()) print mysql_error();
		if($doc=mysql_affected_rows()>0){
			
			$outHtml .= ' <tr class="rw1" style="font-weight:bold;height:30px;vertical-align:middle;">
			                 <td align="center">رديف</td>
			                 <td align="center">كد سند</td>
			                 <td align="center">نام سند</td>
			                 <td align="center">نام بانك</td>
			                 <td align="center">تاریخ سررسيد</td>
			                 <td align="center">مقدار</td>
			                 <td align="center">حذف</td>
			             </tr>
			             ';
			$inx=0;
			$jdpf_price=0;
			while($doc= mysql_fetch_assoc($lnk)){
				global $d_documentTypes;
	            global $d_bankTypes;
				
				$query1 = "
						 	SELECT *  FROM dm_documentk 
					 
							WHERE 
								d_id = ".$doc['dpf_d_id']." 
						";
				$lnk1 = mysql_query($query1);
			    $doc1 = mysql_fetch_assoc($lnk1);
            // print $query1;
				
		$query11 = "
				 	SELECT *  FROM dm_doc_p
			 
					WHERE 
						docp_id = ".$doc1['d_pardakht_t']." 
				";
		$lnk11 = mysql_query($query11);
	    $doc11 = mysql_fetch_assoc($lnk11);
	    
	   $querybank = "
				 	SELECT *  FROM dm_doc_det_b
			 
					WHERE 
						doc_b_id = ".$doc['dpf_bank']." 
				";
		$lnkbank = mysql_query($querybank);
	    $bank = mysql_fetch_assoc($lnkbank);
	// print $querybank;
	    
                $dpf_price=formatMoney($doc['dpf_price']);
                $jdpf_price=$jdpf_price+$doc['dpf_price'];
                
			$inx++;
			   if(($inx)%2==1)
				$class="rw0";
				else
				 $class="rw1";
				 
			$outHtml .='<tr class="'.$class.'" id="Dcntr_'.$doc['dpf_id'].'">
							  <td>'.$inx.'</td>
							  <td>'.$doc1['d_code'].'</td>
							  <td  >'.$doc11['docp_name'].'</td>
							  <td  >'.$bank['doc_b_name'].'</td>
							  <td>'.$doc['dpf_sarresid'].'</td>
							  <td>'.$dpf_price.'</td>';
			if($sanad==1){ $outHtml .='<td>نداریم</td></tr>';}
			 else{
				
							  $outHtml .='<td><span style="cursor:pointer;color:red;size=20%;" onclick="delADocFromBill(\'\', \''.$doc['dpf_id'].'\')" ><img src="images/delete.PNG" width="20" height="20" title="حذف"  ></img></span></td>
						</tr>';}
							  
					$outHtml .='<tr class="'.$class.'" style="align:left;"><td colspan="5">&nbsp;</td><td > جمع کل :'.$jdpf_price.'<td></tr>';		  
												
		}	}
		$outHtml .='</table>
		            ';}
			global $d_documentTypes;
						
			
 
		   $outHtml .= '
				 			
							<form method="post" action=""  id="formpardakht>
				   	
							<input type="hidden" name="pg" value="havaleMgmtPg">   
							<input type="hidden" name="cmd" value="addNewHavale()"> 
							<table    align="center" class="nasi">
							<tr style="background-color:'. $_SESSION['htablecolor']  .';" border="1">
						        <td colspan="10"  style="height: 50px;vertical-align:middle;"  ><font size="5">اطلاعات پرداخت پيش فاكتور</font></td>
	                       </tr>
	                        <tr>
	                             <td colspan="8"><hr style="color:'. $_SESSION['htablecolor']  .';height:40%;"></hr></td>
	                       </tr> 
					       <div id="pardakht" >';
						     $outHtml .= '<td ><center><b> کد سند: </b></center> </td>
							  	<td>'. getDocCombo().'</td>
								
								<td><b> &nbsp; </b></td>
						        <td>&nbsp; </td>				
					        </tr>
					      	<tr>
						        <td ><center> شماره فیش: </center> </td>
						        <td><input name="dpf_num" id="dpf_num" type="text"/></td>
						        <td ><center>نام بانک :</center> </td>
				              <td>

						  		'.getbankTypesComboBox1('dpf_bank').'
							</td> 
				                       
					        </tr>
					        <tr>
<!--					        <td ><center>نوع :</center> </td>
					        <td>'.getTypesatf('dpf_type').'</td>  -->
						       
						         <td ><center>نام شعبه :</center> </td>
						        <td><input name="dpf_branch" id="dpf_branch" type="text"/></td>	
						       
					        </tr>
					      	<tr>
					      	 <td align="center">
			                         تاريخ سررسيد <font color="red">  (مانند:92/01/01)</font></td>
						        <td><input name="dpf_sarresid" value="' .  $year_number.'/'.$month_number.'/'.$day_number.'" id="dpf_sarresid" type="text"  /></td>  
						        <td ><center>مبلغ: </center> </td>
						         <td><input name="dpf_price" id="dpf_price" type="text"  onBlur="this.value=formatCurrency(this.value);" /></td> 
						        
						    </tr> 
						     <tr>
						    <td>استان فی ما بین</td>
						     <td>'.getProvincesanad('dpf_prov_sanad').'</td>
						    
						    
						    </tr>
						    <tr>
	                             <td colspan="8"><hr style="color:'. $_SESSION['htablecolor']  .';height:40%;"></hr></td>
	                       </tr>
	                       </table>		    <div>
						        
							   	<span><button type="button" value="اضافه كردن سند" onclick="addDocument2PfCheck('.$ph_code.')" class="button blue skew" style="font-size:10px; color:#FFFFFF">اضافه كردن سند</button></span>
					            <span> <button type="button" onclick=window.open("PrintPf.php?pf_code='.$pf_code.'&ph_code='.$ph_code.'&h_code='.$h_code.'&f_code='.$f_code.'&province_name='.urlencode($provinceName).'&name_customer='.urlencode($row5['name_customer']).'&province_id='.$_SESSION['dm_user_profile']['u_province_id'] .'&year_id='.$_SESSION['dm_user_profile']['u_year_id'] .'","_blank") value=" چاپ پيش فاكتور"  value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF"> چاپ پيش فاكتور</button></span> 
					           	<span> <button type="button" value="ثبت و ايجاد حواله "  onclick="addednewhavalekoli(\'\',\''.$ph_code.'\',\''.$pf_code.'\',\''.$rowphd['phd_price'].'\',\''.$rowphd['phd_id'].'\',\''.urlencode($havaleMainInfo['ph_customer_code']).'\')"  class="button blue skew" style="font-size:10px; color:#FFFFFF" style="width:20px;">ثبت و ايجاد حواله</button></span>
					           	<span> <input type="button" onclick="formReset()" class="button blue skew" style="font-size:10px; color:#FFFFFF;width:20%;" value="پاك كردن صفحه" /></span> 
					           	 
					         </div>   			   
					</form>
					<br>
				 </div>
				 <div id="addedDocCntnr" style="direction: rtl;"></div>';
		 
			
		}
		
	}else{
	$outHtml .= '<br><br><b><font color="red"><center> شماره پيش حواله نادرست است</center></font></b>';
		
	}
	$outHtml .= '</div>';
	$outHtml .='</table>';
		}
		else{
			
			$out=dspPreFactorFrm().'<br><br><div align="center" style="background: yellow"><b>  شماره پیش حواله نادرست است   !!!!!!!!</b></font></div>';
			echo $out;	
		}	
	return $outHtml;	
}

function getDocCombo($id='DocCombo', $sCust=false){
	$out = '<select id="'.$id.'" name="'.$id.'" onchange="hndlDocComboChng(\'\', this.value)" ><option value="" style="width:80px;" >........</option>';
	$lnk = mysql_query("SELECT * FROM  dm_documentk    ");
		
	if(mysql_affected_rows()>0){
		while($row=mysql_fetch_assoc($lnk)){
			$lnk1 = mysql_query("SELECT * FROM  dm_doc_p   where   docp_id=".$row['d_pardakht_t']."    ");
			$row1=mysql_fetch_assoc($lnk1);
			$out .= '<option value="'.$row['d_id'].'"  >'.$row['d_code'].'/'.$row1['docp_name'].'</option>';
		}
	}
	$out .= '</select>';
	return $out;
}

function getChargeCombo($id='ChargeCombo', $sCust=false){
	$out = '<select id="'.$id.'" name="'.$id.'" onchange="hndlChargeComboChng(\'\', this.value)" >';
	$lnk = mysql_query("SELECT * FROM dm_charge_factors GROUP BY ch_code ");
	if(mysql_affected_rows()>0){
		while($row=mysql_fetch_assoc($lnk)){
			$out .= '<option value="'.$row['ch_id'].'"  >'.$row['ch_code'].'</option>';
		}
	}
	$out .= '</select>';
	return $out;
}

function dspFactorFrm()
{
               $day_number = jdate('j');
               $month_number = jdate('n');
               $year_number = jdate('y');
               $day_name = jdate('l');
               $selectedItem=1;
?>	
	
	
	 <table  align="center"  class="nasi">
	       <tr  style="background-color:<?php echo $_SESSION['htablecolor'] ?>;">
			  	       	
				</tr>
				<tr style="background-color:<?php echo $_SESSION['htablecolor'] ?>;">
				       <td colspan="3" align="center"><b> صدور فاكتور </b> </td>
				</tr>
				<tr style="background-color:<?php echo $_SESSION['htablecolor'] ?>;">
				    <td colspan="3">&nbsp;</td>
				</tr>
	 
				<tr>
					
						<td><b> صدور و يا تغيير بر اساس </b><center><?php echo getpfcreateTypeRadioHtml($selectedItem)?></center></td>	
						<td>تاريخ:<?php echo $year_number?>/<?php echo $month_number ?>/<?php echo $day_number ?>&nbsp;</td>
						
				</tr>
					
				<tr id="pfcreateph" style="display: block;">
					<form method="post" action="" >
		              	<input type="hidden" name="pg" value="PfactorMgmtPg">   
		                <input type="hidden" name="cmd" value="dspFactor1">	   		                
		              	<td>&nbsp; <b> شماره پيش حواله :</b> </td>		              	
						<td><input name="ph_code" type="text"/></td>
					    <td colspan="3" align="center"><input type="submit" value="تاييد"  class="button blue skew" style="font-size:15px;width=20px; color:#FFFFFF" ></td>
				    </form>
				</tr>	
				<tr id="pfcreatepf" style="display:none;">
					<form method="post" action="" >
		              	<input type="hidden" name="pg" value="PfactorMgmtPg">   
		                <input type="hidden" name="cmd" value="dspFactor">	            
		              	<td>: شماره پيش فاكتور </td>
					    <td><input name="pf_code" type="text"/></td>
					    <td colspan="3" align="center" ><input type="submit" value="تاييد"  class="button blue skew" style="font-size:15px; color:#FFFFFF" ></td>					    
				    </form>
				</tr>			 
  </table>
	
	
	
	
	
	
	
	
	<?php 

}

function dspFactor(){
	
	  $day_number = jdate('j');
      $month_number = jdate('n');
      $year_number = jdate('y');
      $day_name = jdate('l');
	
    $outHtml = dspFactorFrm();	
	$pf_code = isset($_REQUEST['pf_code']) ? $_REQUEST['pf_code'] : '';
		
	$query1 = "
			 	SELECT *  FROM dm_pish_factor 
		 
				WHERE 
					pf_code = '".$pf_code."' 
				
				
			    AND
		           pf_type=". 0 ."   
			       ";
//	print $query1;
	
	$lnk1 = mysql_query($query1);
	if(mysql_error()) print mysql_error();
			 
	sqlErr('dspFactor query1');
	if(mysql_num_rows($lnk1)>0){
		
		$row1= mysql_fetch_assoc($lnk1);
		$ph_code=$row1['pf_ph_code'];		
		$query3 = "
			 	SELECT *  FROM dm_havale
		 
				WHERE 
					h_pf_code = '".$pf_code."' 
				AND
				    h_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
				
			    
			        ";
	
	$lnk3 = mysql_query($query3);
	//print $query3;	
	if(mysql_error()) print mysql_error();				 
	sqlErr('dspFactor query3');	
	if(mysql_num_rows($lnk3)>0){
//bekhatere enke ghabol nemikard majbor shodam 2ta query benevisam		  
						$query4 = "
							 	SELECT *  FROM dm_havale
						 
								WHERE 
									h_pf_code = '".$pf_code."' 
								AND
								    h_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
								 ";
														
							$lnk4 = mysql_query($query4);		
							$row4= mysql_fetch_assoc($lnk4);
//							print $query4;
							$outHtml .= '<table class="list"  style="width:80%;" align="center">
											<tr class="rw0" style="height:30px;vertical-align:middle;">						
									 		    <td  colspan="3" style="vertical-align:middle;"><b> پیش فاكتور به شماره : </b>'.$pf_code.'</td><td colspan="10" style="vertical-align:middle;"><b> كد مشتري :</b>'.$row4['h_customer_code'].'</td>      
											</tr> ';
										 
			                      	$inx = 0;																						
													$outHtml.= '
													   
																<tr class="rw1">
																	<td colspan=17 align="center" style="font-weight:bold;font-size:20px;height: 50px;vertical-align:middle;">
																		<div>ريز فاكتور</div>
																	</td>
																 </tr>
																 <tr class="rw0" style="font-weight:bold;vertical-align:middle;height:30px;">
																		<td align="center" style="vertical-align:middle;">رديف</td>
																		<td align="center" style="vertical-align:middle;">نام کالا</td>
																		<td align="center" style="vertical-align:middle;">كد كالا</td>										
																		<td align="center" style="vertical-align:middle;">كد محل تحويل</td>
																		<td align="center" style="vertical-align:middle;">نام محل تحويل</td>
																		<td align="center" style="vertical-align:middle;">نام تحويل گيرنده</td>
																		<td align="center" style="vertical-align:middle;">كد قيمت</td>
																		<td  style="vertical-align:middle;">مقدار خريد</td>
																		<td colspan="9" style="vertical-align:middle;">وضعيت</td>
																	</tr>';
															while($row3= mysql_fetch_assoc($lnk3)){	
															//	print $row3['h_code'];			      
										$querydet = "SELECT *  FROM dm_pish_havale_det
						 
														WHERE 
															phd_id = '".$row3['h_phd_id']."' ";
																																
													   $lnkdet = mysql_query($querydet);		                    
								                       $rowdet= mysql_fetch_assoc($lnkdet);	
								                       
								                    //   print $querydet;						
										if($rowdet['phd_status']=='1'){	
													if(($inx)%2==1)
													
														$class="rw0";
														else
														 $class="rw1";
														 
														 $inx++;
														 $query4 = "
																 	SELECT *  FROM dm_havale
															 
																	WHERE 
																		h_pf_code = '".$pf_code."' 
																	AND
																	    h_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
																	";
																							
																$lnk4 = mysql_query($query4);		
														//	print $query4;	
																
										$queryp = "
															SELECT *  FROM dm_product product
																left join dm_price price
																on product.p_id=price.price_p_id 
													 
															WHERE 
																p_code = '".$row3['h_p_code']."' 
															AND
																p_price_code=".$row3['h_price_code']."
																
															and
			                                    price_id_province=".$_SESSION['dm_user_profile']['u_province_id']."	
																";
																										
																			$lnkp = mysql_query($queryp);
																			 $rowp=mysql_fetch_assoc($lnkp);
																			if(mysql_error()) print mysql_error();				 
																			sqlErr('dspFactor queryp');	
																			
																						$queryl = "
																									SELECT *  FROM dm_location_goods
																							 
																									WHERE 
																										l_id = '".$row3['h_l_code']."'
																									AND
																									    l_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
																										
																										";
																																									
																									$lnkl = mysql_query($queryl);
															//								print $queryp;		
																									 $rowl=mysql_fetch_assoc($lnkl);
																									if(mysql_error()) print mysql_error();				 
																									sqlErr('dspFactor queryp');	
																							//	print	$queryp	;					    
														$outHtml .= '
																<tr class="'. $class.'" style="vertical-align:middle;">
																	<td align="center" width=5% style="vertical-align:middle;">'.$inx.'</td>
																	<td align="center" width=15% style="vertical-align:middle;">'.$rowp['p_name'].'</td>
																	<td align="center" width=10% style="vertical-align:middle;">'.$row3['h_p_code'].'</td>										
																	<td align="center" width=10% style="vertical-align:middle;"> '.$rowl['l_code'].'</td>
																	<td align="center" width=15% style="vertical-align:middle;">'.$rowl['l_name'].'</td>
																	<td align="center" width=15% style="vertical-align:middle;">'.$row3['h_deli_name'].'</td>										
																	<td  align="center" width=10% style="vertical-align:middle;">'.$row3['h_price_code'].'</td>
																	<td colspan="5" width=10% style="vertical-align:middle;">'.$row3['h_amount'].'</td>';
																			if($row4['h_status']==1	){	
																									$outHtml .= '<td colspan="5" width=10% style="vertical-align:middle;">اين فاكتور مربوط به حواله ابطال شده است</td>';
																				
																				
																			}else{								
																			if($row4['h_f_status']==1){
																			$outHtml .= '<td colspan="5" width=10% style="vertical-align:middle;">فاكتور زده شده</td>';
																				
																			}	else{
																				$outHtml .= '<td colspan="5" width=10% style="vertical-align:middle;">فاكتور زده نشده</td>';
															
																			}
																			}
																															
																	$outHtml .=' 																																
																			   </tr>     
															';
														$totalprice =$row3['h_priceh']+$totalprice;
														
													}
															
								}	
								$outHtml .= '</table> قيمت كل:'.$totalprice.'</table>
																<div >
																     <button type="button"  onclick="addNewFactor(\'\', \''.$ph_code.'\')" class="button blue skew" style="font-size:10px; color:#FFFFFF"> ايجاد فاكتور</button>
																</div>';
																			  
							 }else{
			         	$outHtml .= '<br><br><b><font color="red">  حواله اي براي اين پيش فاكتور ثبت نشده</font></b>';
			         }

	}else{
	$outHtml .= '<br><br><b><font color="red"> شماره پیش فاكتور نادرست است</font></b>';
		
	}
	$outHtml .= '</div>';
	$outHtml .='<br>';
	echo $outHtml;
	
}
function dspFactor1(){
	
	  $day_number = jdate('j');
      $month_number = jdate('n');
      $year_number = jdate('y');
      $day_name = jdate('l');
	
    $outHtml = dspFactorFrm();	
	$ph_code = isset($_REQUEST['ph_code']) ? $_REQUEST['ph_code'] : '';
	$querypf = "
			 	SELECT *  FROM dm_pish_factor
		 
				WHERE 
					pf_ph_code = '".$ph_code."' 
				AND
				    pf_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
				
			    AND
			    pf_type =". 0 ."";   
	$lnkpf = mysql_query($querypf);	
	$rowpf= mysql_fetch_assoc($lnkpf);
	$pf_code=$rowpf['pf_code'];
	$query1 = "
			 	SELECT *  FROM dm_pish_havale
		 
				WHERE 
					ph_code = '".$ph_code."' 
				AND
				    ph_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
				AND 
			       ph_id_year=".$_SESSION['dm_user_profile']['u_year_id']." ";
	      			      
	//print $query1;
	
	$lnk1 = mysql_query($query1);
	if(mysql_error()) print mysql_error();
			 
	sqlErr('dspFactor query1');
	if(mysql_num_rows($lnk1)>0){
		
	
		$row1= mysql_fetch_assoc($lnk1);
		$ph_code=$row1['ph_code'];		
		$query3 = "
			 	SELECT *  FROM dm_havale
		 
				WHERE 
					h_pf_code = '".$pf_code."' 
				AND
				    h_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
				AND 
			        h_id_year=".$_SESSION['dm_user_profile']['u_year_id']."
			    
			        ";
	
	$lnk3 = mysql_query($query3);
		
	if(mysql_error()) print mysql_error();				 
	sqlErr('dspFactor query3');	
	if(mysql_num_rows($lnk3)>0){
//bekhatere enke ghabol nemikard majbor shodam 2ta query benevisam		  
						$query4 = "
							 	SELECT *  FROM dm_havale
						 
								WHERE 
									h_pf_code = '".$pf_code."' 
								AND
								    h_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
								 AND 
							       h_id_year=".$_SESSION['dm_user_profile']['u_year_id']."";
														
							$lnk4 = mysql_query($query4);		
							$row4= mysql_fetch_assoc($lnk4);
//							print $query4;
							$outHtml .= '<table class="list"  style="width:80%;" align="center">
											<tr class="rw0" style="height:30px;vertical-align:middle;">						
									 		    <td  colspan="3" style="vertical-align:middle;"><b> پیش فاكتور به شماره : </b>'.$pf_code.'</td><td colspan="10" style="vertical-align:middle;"><b> كد مشتري :</b>'.$row4['h_customer_code'].'</td>      
											</tr>
										 '; 
				$inx = 0;																						
													$outHtml.= '
													   
																<tr class="rw1">
																	<td colspan=17 align="center" style="font-weight:bold;font-size:20px;height: 50px;vertical-align:middle;">
																		<div>ريز فاكتور</div>
																	</td>
																 </tr>
																 <tr class="rw0" style="font-weight:bold;vertical-align:middle;height:30px;">
																		<td align="center" style="vertical-align:middle;">رديف</td>
																		<td align="center" style="vertical-align:middle;">نام کالا</td>
																		<td align="center" style="vertical-align:middle;">كد كالا</td>										
																		<td align="center" style="vertical-align:middle;">كد محل تحويل</td>
																		<td align="center" style="vertical-align:middle;">نام محل تحويل</td>
																		<td align="center" style="vertical-align:middle;">نام تحويل گيرنده</td>
																		<td align="center" style="vertical-align:middle;">كد قيمت</td>
																		<td  style="vertical-align:middle;">مقدار خريد</td>
																		<td colspan="9" style="vertical-align:middle;">وضعيت</td>
																	</tr>';
															while($row3= mysql_fetch_assoc($lnk3)){	
															//	print $row3['h_code'];			      
										$querydet = "SELECT *  FROM dm_pish_havale_det
						 
														WHERE 
															phd_id = '".$row3['h_phd_id']."' ";
																																
													   $lnkdet = mysql_query($querydet);		                    
								                       $rowdet= mysql_fetch_assoc($lnkdet);	
								                       
								                    //   print $querydet;						
										if($rowdet['phd_status']=='1'){	
													if(($inx)%2==1)
													
														$class="rw0";
														else
														 $class="rw1";
														 
														 $inx++;
														 $query4 = "
																 	SELECT *  FROM dm_havale
															 
																	WHERE 
																		h_pf_code = '".$pf_code."' 
																	AND
																	    h_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
																	 AND 
																       h_id_year=".$_SESSION['dm_user_profile']['u_year_id']."";
																							
																$lnk4 = mysql_query($query4);		
														//	print $query4;	
																
										$queryp = "
															SELECT *  FROM dm_product product
																left join dm_price price
																on product.p_id=price.price_p_id 
													 
															WHERE 
																p_code = '".$row3['h_p_code']."' 
															AND
																p_price_code=".$row3['h_price_code']."
																
															AND
			                                               price_id_province=".$_SESSION['dm_user_profile']['u_province_id']."	
																";
																										
																			$lnkp = mysql_query($queryp);
																			 $rowp=mysql_fetch_assoc($lnkp);
																			if(mysql_error()) print mysql_error();				 
																			sqlErr('dspFactor queryp');	
																			
												$queryl = "
															SELECT *  FROM dm_location_goods
													 
															WHERE 
																l_id = '".$row3['h_l_code']."'
															AND
															    l_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
																
																";
																																									
													$lnkl = mysql_query($queryl);
			//								print $queryp;		
													 $rowl=mysql_fetch_assoc($lnkl);
													if(mysql_error()) print mysql_error();				 
													sqlErr('dspFactor queryp');	
																							//	print	$queryp	;					    
														$outHtml .= '
																<tr class="'. $class.'" style="vertical-align:middle;">
																	<td align="center" width=5% style="vertical-align:middle;">'.$inx.'</td>
																	<td align="center" width=15% style="vertical-align:middle;">'.$rowp['p_name'].'</td>
																	<td align="center" width=10% style="vertical-align:middle;">'.$row3['h_p_code'].'</td>										
																	<td align="center" width=10% style="vertical-align:middle;"> '.$rowl['l_code'].'</td>
																	<td align="center" width=15% style="vertical-align:middle;">'.$rowl['l_name'].'</td>
																	<td align="center" width=15% style="vertical-align:middle;">'.$row3['h_deli_name'].'</td>										
																	<td  align="center" width=10% style="vertical-align:middle;">'.$row3['h_price_code'].'</td>
																	<td colspan="5" width=10% style="vertical-align:middle;">'.$row3['h_amount'].'</td>';
																			if($row4['h_status']==1	){	
																									$outHtml .= '<td colspan="5" width=10% style="vertical-align:middle;">اين فاكتور مربوط به حواله ابطال شده است</td>';
																				
																				
																			}else{								
																			if($row4['h_f_status']==1){
																			$outHtml .= '<td colspan="5" width=10% style="vertical-align:middle;">فاكتور زده شده</td>';
																				
																			}	else{
																				$outHtml .= '<td colspan="5" width=10% style="vertical-align:middle;">فاكتور زده نشده</td>';
															
																			}
																			}
																															
																	$outHtml .=' 																																
																			   </tr>     
															';
														$totalprice =$row3['h_priceh']+$totalprice;
														
													}
															
								}	
								$outHtml .= '</table> قيمت كل:'.$totalprice.'</table>
																<div >
																     <button type="button"  onclick="addNewFactor(\'\', \''.$ph_code.'\')" class="button blue skew" style="font-size:10px; color:#FFFFFF"> ايجاد فاكتور</button>
																</div>';
																			  
							 }else{
			         	$outHtml .= '<br><br><b><font color="red">  حواله اي براي اين پيش فاكتور ثبت نشده</font></b>';
			         }

	}else{
	$outHtml .= '<br><br><b><font color="red"> شماره پیش حواله نادرست است</font></b>';
		
	}
	$outHtml .= '</div>';
	$outHtml .='<br>';
	echo $outHtml;
	
}
function dspPreFactorList(){
		
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
	$srchStr;    
	$outHtml = '<br><table>
	     	  <tr><td>	
		<form method="get" action="">
			<input type="hidden" name="pg" value="PfactorMgmtPg">   
			<input type="hidden" name="cmd" value="searchCodePfactor"> 
			 <b>كد پيش فاكتور مورد نظر را جستجو كنيد </b>
			<div> <input type="text" name="search" value="'.$_SESSION['srchStr'].'" style="width:100px;"/> 
			  <button value="draft" name="commit" type="submit" >جستجو</button> </div>
		</form></td>';

	$outHtml .= '<td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td>	
		<form method="get" action="">
			<input type="hidden" name="pg" value="havaleMgmtPg">   
			<input type="hidden" name="cmd" value="searchCodehavale"> 
			<b> كد پيش حواله مورد نظر را جستجو كنيد </b>
			<div>  <input type="text" name="search1"  value="'.$_SESSION['srchStr1'].'" style="width:60px;" />
			
			
			<button type="submit" name="Search1" value="Search1" >جستجو</button></div>
		</form>
		</td>
		</tr>
		</table>
		<br>
	';
	
	$outHtml .= '	
		<div align = "center" style="width:100%;height:400px; overflow:auto">
			<table border="5" align="center" cellpadding="0" cellspacing="0" class="list" >
      			<tr class="rw1">
        			<td colspan="19" align="center" scope="row" style="height: 60px;vertical-align:middle;font-size:20px;">ليست پيش فاكتور ها</td>
        		</tr>
      			<tr class="rw0" style="font-weight:bold;">
			        <td align="center">رديف</td>
			        <td align="center">شماره پيش فاكتور </td>
			        <td align="center">تاريخ پيش فاكتور </td>
			        <td align="center">شماره پيش حواله </td>
			        <td align="center">نوع مشتري&nbsp; </td>
			        <td colspan="4">&nbsp;&nbsp;&nbsp;&nbsp;  نام مشتري</td>
			       
			        
				</tr>
	';
	if(!isset($_SESSION['srchStr'])) $_SESSION['srchStr'] = '';
	if(!isset($_SESSION['elmCount'])) $_SESSION['elmCount'] = 0;
	if(!isset($_SESSION['rPP'])) $_SESSION['rPP'] = 10;//results per page
	if(!isset($_SESSION['pageCount'])) $_SESSION['pageCount'] = 1;//results page conut
	if(!isset($_SESSION['crntPage'])) $_SESSION['crntPage'] = 1;//current page number
	if($_SESSION['srchStr']=='' AND $_SESSION['srchStr1']==''){
		$srchQ = "";
		
	}else if($_SESSION['srchStr1']!=''  ) {
		$srchQ = " 
			AND(
					ph_code LIKE '%".$_SESSION['srchStr1']."%' 
				 
			)
		";
		
	}else{
		
		$srchQ = " 
			AND(
					pf_code LIKE '%".$_SESSION['srchStr']."%' 
				 
			)
		";
	}
	
	$typeQ = '';
	
	$genQuery = "
		
		FROM 
			dm_pish_factor 
		WHERE 
			1 
		".$srchQ." 
		".$typeQ." 
		AND
	     	pf_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
	    AND 
	       pf_id_year=".$_SESSION['dm_user_profile']['u_year_id']."
	     AND 
	       pf_type=". 0 ."
	       
	       ORDER BY pf_code ASC
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
	
	$resQueryj = "
		SELECT 
			*  
	".$genQuery.$limitQ;
//	print($resQuery);
	$_SESSION['srchStr'] = '';
	$_SESSION['srchStr1'] = '';
	$lnkj = mysql_query($resQueryj);
	$inx = ((($_SESSION['crntPage']-1)*$_SESSION['rPP'])+1);
	if(mysql_affected_rows()>0){
	$queryd='select *	
 	           from dm_um_rel t
			     inner join dm_listmenu l on l.menu_id = t.um_menu_id
			where t.um_u_id = "'.$_SESSION['dm_user_profile']['u_id'].'"  and
			      l.menu_code = \'211\' and t.um_can_delete =1';
                   // print $queryd;
			                    	
	   $lnkd = mysql_query($queryd);

	   if ((mysql_num_rows($lnkd)>0) || ($_SESSION['dm_user_profile']['u_user_name'] =='modir' && $_SESSION['dm_user_profile']['u_pass_word'] =='modir')){
	   	
	   	$statusd=1;
	   }
		while($rowj = mysql_fetch_assoc($lnkj)){
			
			$gdate=$rowj['pf_reg_date'];
			list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
			list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
			$jdate = $jyear."/".$jmonth."/".$jday;
			
			if(($inx)%2==1)
				$class="rw1";
				else
				 $class="rw0";
				 
				 $query1 = "
						 	SELECT *  FROM dm_pish_havale 
					 
							WHERE 
								ph_code = ".$rowj['pf_ph_code']."
							AND 
							    ph_id_province=".$_SESSION['dm_user_profile']['u_province_id']." 
						  AND 
	                           ph_id_year=".$_SESSION['dm_user_profile']['u_year_id']."
						";			
						$lnk1 = mysql_query($query1);
						sqlErr('for Display pfactor');
						$row1= mysql_fetch_assoc($lnk1);
						
	$querypro="SELECT * FROM dm_province WHERE 
	            	  province_id=".$_SESSION['dm_user_profile']['u_province_id']; 
	$lnkpro = mysql_query($querypro); 
	$rowpro = mysql_fetch_assoc($lnkpro);
	$province_code=$rowpro['province_code'];
		
		if($row1['ph_customer_type']=='n'){
						$querycu = "
						 	SELECT *  FROM dm_customer 
					 
							WHERE 
								code_customer = '".$row1['ph_customer_code']."' 
							  AND
			                    customer_code_org=".$province_code."";		
				
    			$lnkcu = mysql_query($querycu);
    		//	print $query;
				sqlErr('for customer');
				$cusMainInfo = mysql_fetch_assoc($lnkcu);	
						$cusName=$cusMainInfo['name_customer'];
						$Type='معمولی';
			
		}else{
				$query = "
					 	SELECT *  FROM dm_customer_mot 
				 
						WHERE 
							cm_customer_id = '".$row1['ph_customer_code']."' ";		
								
				$lnk = mysql_query($query);
				sqlErr('for customer1');
				$cusMainInfo = mysql_fetch_assoc($lnk);	
						$cusName=$cusMainInfo['cm_name_customer'];
						$Type='متفرقه';				
	            	}
			$outHtml .= '
			<div id="Pfactor_'.$rowj['pf_id'].'" >
				<tr class='.$class.'>
					<td align="center" width=5% style="vertical-align:middle;"> '.$inx.'</td>
					<td align="center" width=15%>'.$rowj['pf_code'].'</td>
					<td align="center" width=15%>'.$jdate.'</td>
					<td align="center" width=15%>'.$rowj['pf_ph_code'].'</td>
					<td align="center" width=10%>'.$Type.'</td>
					<td align="center" width=20%>'.$cusName.'</td>';
			if($statusd==1){
					$outHtml .= '<td align="center"> <span style="cursor:pointer" onclick="DeletePfactor(\'\', \''.$rowj['pf_id'].'\')" ><font color=red><img src="images/delete.PNG" width="20" height="20" title="حذف" ></img>
					</font></span></td>';
					}
					$outHtml .= '<td align="center"><a href="?pg=PfactorMgmtPg&cmd=ShowAPfactor&pf_id='.$rowj['pf_id'].'"><img src="images/display.png" width="20" height="20" title="مشاهده كل اطلاعات" ></img></a></td>
					
				</tr></div>
			';
			$inx++;
		}
    }else{
    	$outHtml .= '<tr><td colspan="5">هيچ پيش فاكتوري  موجود نيست</td></tr>';
    }
    $outHtml .= '</table></div>'.getNavBar_pf().' '.getRPPCombo_pf();
    echo $outHtml;
		
}

function getNavBar_pf(){
	$out = '
	<div align="center">
		<table style="direction:ltr" >
			<tr>
			
	';
	//if($stNum>$_SESSION['pageCount']) $stNum=$_SESSION['pageCount']-5;
	
	$stNum = $_SESSION['crntPage']-5;
	if($stNum<1) $stNum=1;
	$out .= '
		<td><a href="?pg=PfactorMgmtPg&cmd=dspPreFactorList&cmd2=setPg&pgNum=1" ><img src="images/first.gif" title="ابتدا"></img></a></td>
		<td>&nbsp;&nbsp;</td>
		<td><a href="?pg=PfactorMgmtPg&cmd=dspPreFactorList&cmd2=setPg&pgNum='.((($_SESSION['crntPage']-1)<1) ? 1 : ($_SESSION['crntPage']-1)).'" ><img src="images/prev.gif" title="قبلي"></img></a></td>
	';
	$inx = 0;
	while(($inx<10) && (($stNum+$inx) <= $_SESSION['pageCount'])){
		$out .= '
			<td><a '.(($_SESSION['crntPage']==($stNum+$inx)) ? ' style="text-decoration:none; font-weight:bold;" ':'').' href="?pg=PfactorMgmtPg&cmd=dspPreFactorList&cmd2=setPg&pgNum='.($stNum+$inx).'" ><div style="background:#cccccc;">'.($stNum+$inx).'</div></a></td>
			<td>&nbsp;</td>
		';
		
		$inx++;
	}
	$out .= '
		<td><a href="?pg=PfactorMgmtPg&cmd=dspPreFactorList&cmd2=setPg&pgNum='.((($_SESSION['crntPage']+1)<=$_SESSION['pageCount']) ? ($_SESSION['crntPage']+1) : $_SESSION['pageCount']).'" ><img src="images/next.gif" title="بعدي"></img></a></td>
		<td>&nbsp;&nbsp;</td>
		<td><a href="?pg=PfactorMgmtPg&cmd=dspPreFactorList&cmd2=setPg&pgNum='.$_SESSION['pageCount'].'" ><img src="images/last.gif" title="انتها"></img></a></td>
	';
	
	$out .= '
			</tr>
		</table>
	</div>
	';	
	return $out;
}

function getRPPCombo_pf(){
	$out = '<div align="center">
	
		<select onchange="window.open(\'?pg=PfactorMgmtPg&cmd=dspPreFactorList&cmd2=setRPP&rPP=\'+this.value, \'_self\')" style="width:50px;" >
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

function ShowAPfactor(){
		
	$pf_id = isset($_REQUEST['pf_id']) ? $_REQUEST['pf_id'] : '';
	$queryprov = "SELECT *  FROM dm_province
		           WHERE `province_id`='".$_SESSION['dm_user_profile']['u_province_id']."'
		            AND
			             customer_code_org=".$province_code."";
		  $lnkprov = mysql_query($queryprov);
		  $rowprov= mysql_fetch_assoc($lnkprov);
		    $province_code=$rowprov['province_code'];
	$query5 = "
				 SELECT *  FROM dm_customer 						 
								WHERE 
									customer_id = '".$havaleMainInfo['ph_customer_code']."' 
								 AND
			             customer_code_org=".$province_code.""; 
									
							//	print $query5;			   					
						$lnk5 = mysql_query($query5);
						$row5= mysql_fetch_assoc($lnk5);
	
	$query = "
	 	SELECT *  FROM dm_pish_factor 
 
		WHERE 
			pf_id = '".$pf_id."' ";
		  
	
//print 	$query;
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
	$row= mysql_fetch_assoc($lnk);
	
	$ph_code=$row['pf_ph_code'];
	$pf_code=$row['pf_code'];
	
	$day_number = jdate('j');
    $month_number = jdate('n');
    $year_number = jdate('y');
    $day_name = jdate('l');
       
	$outHtml  = '<div dir="rtl">
	                   <br>
						<table  style=" align="center"  width="100%" class="list" margin-top:20px" >
					  	<tr align="middle" class="rw1">
					      <td colspan="14"  style="height: 50px;vertical-align:middle;"  ><font size="5"> پيش فاکتور</font-size></td>
				        </tr>
		';
    //retrieve mainInfo pishhavale	
	$query = "
	 	SELECT *  FROM dm_pish_havale 
 
		WHERE 
			ph_code = '".$ph_code."' 
		AND
		   ph_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
		
	";
//print 	$query;
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
	if(mysql_affected_rows()>0){
		
		$havaleMainInfo = mysql_fetch_assoc($lnk);
		$_SESSION['shPhforPf']=$havaleMainInfo['ph_code'];
		
		$queryprov = "SELECT *  FROM dm_province
		           WHERE `province_id`='".$_SESSION['dm_user_profile']['u_province_id']."' ";
		  $lnkprov = mysql_query($queryprov);
		  $rowprov= mysql_fetch_assoc($lnkprov);
		    $province_code=$rowprov['province_code'];
		    
	if($havaleMainInfo['ph_customer_type']=='n'){
						$query = "
						 	SELECT *  FROM dm_customer 
					 
							WHERE 
								code_customer = '".$havaleMainInfo['ph_customer_code']."' 
								AND
			             customer_code_org=".$province_code."";		
				
				$lnk = mysql_query($query);
				sqlErr('for customer');
				$cusMainInfo = mysql_fetch_assoc($lnk);	
						$cusName=$cusMainInfo['name_customer'];
						$Type='معمولی';
			
		}else{
				$query = "
					 	SELECT *  FROM dm_customer_mot 
				 
						WHERE 
							cm_customer_id = '".$havaleMainInfo['ph_customer_code']."' ";		
								
				$lnk = mysql_query($query);
				sqlErr('for customer1');
				$cusMainInfo = mysql_fetch_assoc($lnk);	
						$cusName=$cusMainInfo['cm_name_customer'];
						$Type='متفرقه';				
	            	}
	   	$gdate=$row['pf_reg_date'];
			list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
			list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
			$jdate = $jyear."/".$jmonth."/".$jday;
		$outHtml .= '
			<tr class="rw0" style="font-weight:bold;">
			<td colspan="4"> تاريخ پيش فاكتور:'. $jdate.'</td>
			<td colspan="4">شماره پيش فاكتور :'.$pf_code.'</td>
			</tr>  	
		';
		$outHtml .= '
			<tr class="rw0" style="font-weight:bold;">
			<td colspan="4"> پيش حواله به شماره : '.$havaleMainInfo['ph_code'].'</td><td > به نام :'.$cusName.'</td>
			<td colspan="4">&nbsp; </td>
			</tr> 	
		';
		
		//retrieve detail of pishHavale
		$query = "
		 	SELECT *  FROM dm_pish_havale_det 
	 
			WHERE 
				phd_ph_code = ".$ph_code." 
		 AND 
	            phd_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
	      AND 
	            phd_id_year=".$_SESSION['dm_user_profile']['u_year_id']."
		";
		$lnk = mysql_query($query);
	//print $query;
		if(mysql_error()) print mysql_error();
		if(mysql_affected_rows()>0){
			$outHtml .= '
		          <tr  class="rw1"><td colspan="13"><hr></td></tr>
				<tr class="rw1">
					<td colspan="12" align=center>
					 
					   <b> ريز پيش فاكتور</b>
					</td>
				</tr>
						<tr class="rw0" style="font-weight:bold;height:20px;">
							<td >رديف</td>
							<td >نام کالا</td>
							<td>كد كالا</td>
							<td>كد قيمت</td>
							<td>مقدار خريد</td>
						    <td>قيمت واحد </td>
						    <td>هزينه اضافی هر واحد </td>
							<td colspan="2">قيمت كالا </td>
						</tr>
		</div>
			';
			$inx = 0;
			
			while($row= mysql_fetch_assoc($lnk)){
				$query2 = "
							  select * from dm_product product
							left join dm_price price
							on product.p_id=price.price_p_id
					           WHERE p_code=".$row['phd_pid']." 
					        AND 
					        p_price_code=".$row['phd_price_code']."
					        AND
					         price_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
				
							";
			//print $query2;
							$lnk2 = mysql_query($query2);
							$row2= mysql_fetch_assoc($lnk2);
				$inx++;
				if(($inx)%2==1)
				$class="rw1";
				else
				 $class="rw0";
				
				$outHtml .= '
						<tr class="'.$class.'">
							<td  style="vertical-align:middle;">'.$inx.'</td>
							<td  style="vertical-align:middle;">'.$row2['p_name'].'</td>
							<td  style="vertical-align:middle;">'.$row2['p_code'].'</td>
							<td  style="vertical-align:middle;">'.$row['phd_price_code'].'</td>
							<td  style="vertical-align:middle;">'.$row['phd_amount'].'</td>';
				$query = "
		 	          SELECT *  FROM dm_product product
							left join dm_price price
							on product.p_id=price.price_p_id 
	 
			WHERE 
				p_code = ".$row['phd_pid']." 
			AND 
			p_price_code=".$row['phd_price_code']."
			AND
		price_id_province=".$_SESSION['dm_user_profile']['u_province_id']."";
		
	//			print  $query;
				$ln = mysql_query($query);
				
				if(mysql_error()) print mysql_error();
				$prod= mysql_fetch_assoc($ln);
				$price=$row['phd_amount']*$prod['p_unit'];
				
				
				$querych = "SELECT *  FROM dm_product product
						left join dm_price price
						on product.p_id=price.price_p_id 
					    left join  dm_charge_factors charge on price.price_id=charge.ch_price_id
							WHERE 
								p_code = ".$row['phd_pid']." 
							AND
								p_price_code=".$row['phd_price_code']."
							AND
								price_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
							AND
							   ch_id_province=".$_SESSION['dm_user_profile']['u_province_id']."";
				//	print $querych;		
			$lnkch = mysql_query($querych);
		   sqlErr('for Display charge');

			 
      $hazine=$row['phd_p_add'];
	  	
							
							$outHtml .= '<td >'.$prod['p_sellprice'].'</td>
							              <td >'.$hazine.'</td>
											<td >'.$row['phd_priceh'].'</td>
								        
								         </tr>  
								          
					';
				
				$totalprice =$row['phd_priceh']+$totalprice;
			}
			
			$outHtml .= '
					
					<tr>
					
				     <td> جمع کل:'.$totalprice.'</td>
				     <td colspan="11">&nbsp;&nbsp;&nbsp;</td>
					</tr>				
			
 <tr >
	 <td colspan="12">
	     <table   style=" align="center"  width="100%"  margin-top:20px" class="list">
	         <tr class="rw1">
	             <td colspan="14" align="center" style="height: 50px;vertical-align:middle;font-weight:bold;"> اطلاعات اسناد </td>
	         </tr>';
			
	$query = "
		 	SELECT *  FROM dm_pf_document 
	 
			WHERE 
				dpf_pf_code = ".$pf_code." 
			AND
				 dpf_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
			
				
		";
//	print $query;
	$lnk = mysql_query($query);
		
		if(mysql_error()) print mysql_error();
		if($doc=mysql_affected_rows()>0){
			
			$outHtml .= ' <tr class="rw0">
			                 <td align="center">رديف</td>
			                 <td align="center">كد سند</td>
			                 <td align="center">نام سند</td>
			                 <td align="center">نام بانك</td>
			                 <td align="center">تاریخ سررسيد</td>
			                 <td align="center">شماره فيش</td>
			                 <td align="center">مقدار</td>
			             </tr>
			             ';
			$inx=0;
			while($doc= mysql_fetch_assoc($lnk)){
				
				
		$query1 = "SELECT * FROM dm_documentk document
								left join dm_doc_det_b  doc_det_b
								on document.d_bank=doc_det_b.doc_b_id
								left join dm_doc_det_t   doc_det_t 
								 on document.d_documenttype=doc_det_t.doc_t_id
								 WHERE 
								d_id = ".$doc['dpf_d_id']." ";
		$lnk1 = mysql_query($query1);
		//print $query1;
			    $doc1 = mysql_fetch_assoc($lnk1);
			$inx++;
			if(($inx)%2==1)
				$class="rw1";
				else
				 $class="rw0";
			$outHtml .='<tr class="'.$class.'">
						  <td align="center">'.$inx.'</td>
						  <td align="center">'.$doc1['d_code'].'</td>
						  <td >'.$doc1['doc_t_name'].'</td>
						   <td >'.$doc['dpf_branch'].'</td>
						  <td align="center">'.$doc['dpf_sarresid'].'</td>
						  <td align="center">'.$doc['dpf_num'].'</td>
						   <td align="center">'.$doc['dpf_price'].'</td>
						</tr>
						
						';
		}		
			
		}
		else{
	   $outHtml .= '<tr class="rw0"><td><font color="red"><b><center> اطلاعات اسناد وارد نشده است.</center></b></font></td></tr> ';
		
		}
	 
	 $outHtml .=' <tr>
	      	         
		               
		              <td colspan="8" align="left"> <button type="button" onclick=window.open("PrintPf.php?pf_code='.$pf_code.'&ph_code='.$ph_code.'&province_name='.$provinceName.'&name_customer='.urlencode($row5['name_customer']).'&province_id='.$_SESSION['dm_user_profile']['u_province_id'] .'&year_id='.$_SESSION['dm_user_profile']['u_year_id'] .'")  value=" رويت پيش حواله" class="button blue skew" style="font-size:10px; color:#FFFFFF">
							رويت پيش فاكتور</button></td>
								
				     				           
	      	</tr>
	      	</table>
	 </td>
	</tr>
	</table>
			</div>
			<br>';
						
		}

	}else{
	$outHtml .= '<br><br><b><font color="red"> شماره حواله نادرست است</font></b>';
		
	}
	$outHtml .= '</div>';
	$outHtml .='</td>
	</tr>
	
			</table>
			';
	echo $outHtml;
	
}
	
function dspFactorList(){
		
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
	
	$srchStr; 
	$querypro="SELECT * FROM dm_province WHERE 
	            	  province_id=".$_SESSION['dm_user_profile']['u_province_id']; 
	$lnkpro = mysql_query($querypro); 
	$rowpro = mysql_fetch_assoc($lnkpro);
	$province_code=$rowpro['province_code'];   
	$outHtml = '<br><table>
	     	  <tr><td>		
		<form method="get" action="">
			<input type="hidden" name="pg" value="PfactorMgmtPg">   
			<input type="hidden" name="cmd" value="searchCodefactor"> 
			  <b> كد  فاكتور مورد نظر را جستجو كنيد </b>
			<div>  <input type="text" name="search" value="'.$_SESSION['srchStr'].'" / style="width:50px;"> 
			<button type="submit" name="Search" value="Search" >جستجو</button></div>
		</form></td>';
		
	$outHtml .= '<td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td>	
		<form method="get" action="">
			<input type="hidden" name="pg" value="PfactorMgmtPg">   
			<input type="hidden" name="cmd" value="searchCodefactor"> 
			<b> كد پيش حواله مورد نظر را جستجو كنيد </b>
			<div>  <input type="text" name="search1"  value="'.$_SESSION['srchStr1'].'" style="width:60px;" />
			<button type="submit" name="Search1" value="Search1" >جستجو</button></div>
		</form>
		</td>
		</tr>
		</table>
		<br>';	
	$outHtml .= '	
		
		<div align = "center" style="width:100%;height:400px; overflow:auto">
			<table  align="center" cellpadding="0" cellspacing="0" bgcolor=#82a9c" class="list" style="width:70%;">
      			<tr class="rw1">
        			<th colspan="19" align="center" scope="row"  style="height: 60px;vertical-align:middle;font-size:20px;">لیست فاکتور ها</th>
        		</tr>
      			<tr class="rw0" style="font-weight:bold;">
			        <td >رديف</td>
			        <td >شماره  فاكتور </td>
			         <td >شماره  پيش فاكتور </td>
			          <td >شماره  پيش حواله </td>
			        <td >تاريخ فاكتور </td>	
			         <td >كد مشتري </td>		       
			        <td colspan="3">نام مشتري </td>			       
				</tr>';
	
	if(!isset($_SESSION['srchStr'])) $_SESSION['srchStr'] = '';
	if(!isset($_SESSION['elmCount'])) $_SESSION['elmCount'] = 0;
	if(!isset($_SESSION['rPP'])) $_SESSION['rPP'] = 10;//results per page
	if(!isset($_SESSION['pageCount'])) $_SESSION['pageCount'] = 1;//results page conut
	if(!isset($_SESSION['crntPage'])) $_SESSION['crntPage'] = 1;//current page number
if($_SESSION['srchStr']=='' AND $_SESSION['srchStr1']==''){
		$srchQ = "";
		
	}else if($_SESSION['srchStr1']!=''  ) {
		$srchQ = " 
			AND(
					ph_code = '".$_SESSION['srchStr1']."' 
				 
			)
		";
		
	}else{
		
		$srchQ = " 
			AND(
					f_code = '".$_SESSION['srchStr']."' 
				 
			)
		";
	}
	$typeQ = '';	
	$genQuery = "		
		FROM 
			dm_factor f
			left join dm_pish_factor pf
			on f.f_pf_code=pf.pf_code
			left join dm_pish_havale ph
			on ph.ph_code=pf.pf_ph_code
		WHERE 
			1 
		".$srchQ." 
		".$typeQ." 
		AND
		     f_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
	    AND
		     f_id_year=".$_SESSION['dm_user_profile']['u_year_id']."
		AND
		     f_status_ebtal='". 0 ."'
	    AND
		    pf_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
		AND
		    ph_id_province=".$_SESSION['dm_user_profile']['u_province_id']."  ";   

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
	$_SESSION['srchStr1'] = '';	
	$lnk = mysql_query($resQuery);
	$inx = ((($_SESSION['crntPage']-1)*$_SESSION['rPP'])+1);
	
	if(mysql_affected_rows()>0){
	
		while($row = mysql_fetch_assoc($lnk)){
			$querypf = "
				 	SELECT *  FROM dm_pish_factor
			 
					WHERE 
						pf_code = '".$row['f_pf_code']."'
					AND
					   pf_id_province=".$_SESSION['dm_user_profile']['u_province_id']."";	

				$lnkpf = mysql_query($querypf);
				$rowpf= mysql_fetch_assoc($lnkpf);
			$querydet = "
				 	SELECT *  FROM dm_factor_det
			 
					WHERE 
						fd_f_id = '".$row['f_id']."'
					AND
					fd_province_id=".$_SESSION['dm_user_profile']['u_province_id']."";	
			//	print 	$querydet;		                   				
				$lnkdet = mysql_query($querydet);
				$rowdet= mysql_fetch_assoc($lnkdet);			
			    $h_id=$rowdet['fd_h_id'];
			$gdate=$row['f_reg_date'];
			list( $gyear, $gmonth, $gday ) = preg_split ( '/-/', $gdate ); 
			list( $jyear, $jmonth, $jday ) = gregorian_to_jalali($gyear, $gmonth, $gday);
			$jdate = $jyear."/".$jmonth."/".$jday;				
			$queryh = "
				 	SELECT *  FROM dm_havale
			 
					WHERE 
						h_id = '".$h_id."'";	
                     										
				$lnkh = mysql_query($queryh);
				$rowh= mysql_fetch_assoc($lnkh);
																					   													
						$querycus = "
								 	SELECT *  FROM dm_customer 
							 
									WHERE 
										code_customer = '".$rowh['h_customer_code']."'
				                            AND
				                        customer_code_org=".$province_code."";		
//							print $querycus;	
								$lnkcus = mysql_query($querycus);
								sqlErr('for customer');
								$cusMainInfo = mysql_fetch_assoc($lnkcus);	
										$cusName=$cusMainInfo['name_customer'];
																			
			if(($inx)%2==1)
				$class="rw1";
				else
				 $class="rw0";
			$outHtml .= '
			<div id="factor_'.$row['f_id'].'" >
				<tr class='.$class.'>
					<td>'.$inx.'
					<td>'.$row['f_code'].'</td>
					<td>'.$row['f_pf_code'].'</td>
					<td>'.$rowpf['pf_ph_code'].'</td>
					<td>'.$jdate.'</td>	
					<td>'.$rowh['h_customer_code'].'</td>				
					<td>'.$cusName.'</td>';
					
					
			//		$outHtml .= '<td > <span style="cursor:pointer" onclick="Deletefactor(\'\', \''.$row['f_id'].'\')" ><font color=red><img src="images/delete.PNG" width="20" height="20" title="حذف" ></img></font></span></td>';
					$outHtml .= '<td><a href="?pg=PfactorMgmtPg&cmd=ShowAfactor&f_id='.$row['f_id'].'"><img src="images/display.png" width="20" height="20" title="مشاهده كل اطلاعات" ></img></a></td>
					
				</tr></div>
			';
			$inx++;
		}
    }else{
    	$outHtml .= '<tr><td colspan="5">هيچ  فاكتوري موجود نيست</td></tr>';
    }
    $outHtml .= '</table>'.getNavBar_f().' '.getRPPCombo_f();
    echo $outHtml;
		
}

function getNavBar_f(){
	$out = '<br>
		<table style="direction:ltr" >
			<tr>
			
	';
	//if($stNum>$_SESSION['pageCount']) $stNum=$_SESSION['pageCount']-5;
	
	$stNum = $_SESSION['crntPage']-5;
	if($stNum<1) $stNum=1;
	$out .= '
		<td><a href="?pg=PfactorMgmtPg&cmd=dspFactorList&cmd2=setPg&pgNum=1" ><img src="images/first.gif" title="ابتدا"></img></a></td>
		<td><a href="?pg=PfactorMgmtPg&cmd=dspFactorList&cmd2=setPg&pgNum='.((($_SESSION['crntPage']-1)<1) ? 1 : ($_SESSION['crntPage']-1)).'" ><img src="images/prev.gif" title="قبلي"></img></a></td>
	';
	$inx = 0;
	while(($inx<10) && (($stNum+$inx) <= $_SESSION['pageCount'])){
		$out .= '
			<td><a '.(($_SESSION['crntPage']==($stNum+$inx)) ? ' style="text-decoration:none; font-weight:bold;" ':'').' href="?pg=PfactorMgmtPg&cmd=dspFactorList&cmd2=setPg&pgNum='.($stNum+$inx).'" ><div style="background:#cccccc;">'.($stNum+$inx).'</div></a></td>
		';
		
		$inx++;
	}
	$out .= '
		<td><a href="?pg=PfactorMgmtPg&cmd=dspFactorList&cmd2=setPg&pgNum='.((($_SESSION['crntPage']+1)<=$_SESSION['pageCount']) ? ($_SESSION['crntPage']+1) : $_SESSION['pageCount']).'" ><img src="images/next.gif" title="بعدي"></img></a></td>
		<td><a href="?pg=PfactorMgmtPg&cmd=dspFactorList&cmd2=setPg&pgNum='.$_SESSION['pageCount'].'" ><img src="images/last.gif" title="انتها"></img></a></td>
	';
	
	$out .= '
			</tr>
		</table>
	';	
	return $out;
}

function getRPPCombo_f(){
	$out = '
	
		<select onchange="window.open(\'?pg=PfactorMgmtPg&cmd=dspFactorList&cmd2=setRPP&rPP=\'+this.value, \'_self\')" style="width:50px;" >
			<option value="1" '.(($_SESSION['rPP']==1)?' selected="selected" ':'').' > 1 </option>
			<option value="5" '.(($_SESSION['rPP']==5)?' selected="selected" ':'').' > 5 </option>
			<option value="10" '.(($_SESSION['rPP']==10)?' selected="selected" ':'').' > 10 </option>
			<option value="25" '.(($_SESSION['rPP']==25)?' selected="selected" ':'').' > 25 </option>
			<option value="50" '.(($_SESSION['rPP']==30)?' selected="selected" ':'').' > 50 </option>
			<option value="100" '.(($_SESSION['rPP']==100)?' selected="selected" ':'').' > 100 </option>
			<option value="1000000" '.(($_SESSION['rPP']==0)?' selected="selected" ':'').' > all </option>
		</select>
		 <span style="color:blue;"><b>پاسخ در صفحه</b></span>
	<br></br>';
	
	return $out;
}

function sucessRegH()
{
	$h_id = isset($_REQUEST['h_id']) ? $_REQUEST['h_id'] : '';
	$ph_code = isset($_REQUEST['h_ph_code']) ? $_REQUEST['h_ph_code'] : '8';
	$h_code = isset($_REQUEST['h_code']) ? $_REQUEST['h_code'] : '';	
	
	$day_number = jdate('j');
    $month_number = jdate('n');
    $year_number = jdate('y');
    $day_name = jdate('l');
      $queryp="SELECT * FROM dm_province 
        WHERE province_id=".$_SESSION['dm_user_profile']['u_province_id']."";
		$lnkp=mysql_query($queryp);
		print mysql_error();
		$rowp=mysql_fetch_assoc($lnkp);
		$provinceName=$rowp['province_name'];
		 
	$outHtml = '<div><br> <table  align="center" class="list" style="width:80%;" border="1">
		  	<tr class="rw1">
		       <td colspan="15"  style="height: 50px;vertical-align:middle;"  ><font size="5"><center>مشخصات حواله</center></font></td>
	       </tr>
	       ';
	
    //retrieve mainInfo pishhavale	
	$query = "
	 	SELECT *  FROM dm_pish_havale
 
		WHERE 
			ph_code = '".$ph_code."' 
		AND
		   ph_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
		AND
		   ph_id_year=".$_SESSION['dm_user_profile']['u_year_id']."
	";
	
	$lnk = mysql_query($query);
	sqlErr('wererewr');
	if(mysql_affected_rows()>0){
		
	$querypro="SELECT * FROM dm_province WHERE  province_id=".$_SESSION['dm_user_profile']['u_province_id'];    
	$lnkpro = mysql_query($querypro); 
	$rowpro = mysql_fetch_assoc($lnkpro);
	$province_code=$rowpro['province_code'];
		
		$havaleMainInfo = mysql_fetch_assoc($lnk);
		$_SESSION['shPhforPf']=$havaleMainInfo['ph_id'];
		$query5 = "
			 	SELECT *  FROM dm_customer 
		 
				WHERE 
					code_customer = '".$havaleMainInfo['ph_customer_code']."' 
				AND
				   customer_code_org='".$province_code."'
		
	   ";
	//	print $query5;
	
		$lnk5 = mysql_query($query5);
		$row5= mysql_fetch_assoc($lnk5);
		
		$outHtml .= '
			
			<tr class="rw0"  style="vertical-align:middle;height:30px;">
				<td colspan="15" style="vertical-align:middle;">  &nbsp;<b> شماره حواله :</b>'.$h_code.'<b><span style="width:20%;"> &nbsp;&nbsp;&nbsp;</span> تاريخ :</b>'. "$year_number/$month_number/$day_number".'&nbsp;&nbsp;&nbsp;
				
	 		    <b>پيش حواله به شماره :</b> '.$havaleMainInfo['ph_code'].'
	 		  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b> به نام :</b> '.$row5['name_customer'].'</td>
			</tr>'; 
		
		//retrieve detail of pishHavale
		$query = "
		 	SELECT *  FROM dm_havale
	 
			WHERE 
				h_id = ".$h_id." 
		";
		
		$lnk = mysql_query($query);
		sqlErr('for Display havale');
		if(mysql_affected_rows()>0){
			
			$outHtml .= '
		          <tr class="rw1"><td colspan="15"><hr></td>
				<tr class="rw0">
					<td colspan="15" align="center" style="vertical-align:middle;height:30px;">
					 
					   <b> ريز پيش فاكتور</b>
					</td>
				</tr>
				<tr class="rw1"><td colspan="15"><hr></td>
				<tr style="font-weight:bold;">
						<tr class="rw0" style="font-weight:bold;height:30px;">
							<td >رديف</td>
							<td width=20% align="center" style="vertical-align:middle;">نام کالا</td>
							<td width=10% align="center" style="vertical-align:middle;">كد كالا</td>
							<td width=10% align="center" style="vertical-align:middle;">كد قيمت</td>
							<td width=10% align="center" style="vertical-align:middle;">كد محل تحويل</td>
							<td width=20% align="center" style="vertical-align:middle;">نام محل تحويل</td>
							<td width=15% align="center" style="vertical-align:middle;">نام تحويل گيرنده</td>
							<td width=30% align="right" colspan="2" style="vertical-align:middle;">مقدار خريد</td>						    
						</tr>
		</div>
			';
			$inx = 0;
			while($row= mysql_fetch_assoc($lnk)){
				$amount=formatMoney($row['h_amount']);
				$query2 = "
						SELECT *  FROM dm_product product
							left join dm_price price
							on product.p_id=price.price_p_id 
						 
								WHERE 
									p_code = ".$row['h_p_code']." 
								 AND 
								 p_price_code=".$row['h_price_code']."	

								 and
			                         price_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
								 ";
								  
								 																							
//			print $query2;
						  $lnk2 = mysql_query($query2);
					      $row2= mysql_fetch_assoc($lnk2);
		$queryL = "
		 	SELECT *  FROM dm_location_goods 
	 
			WHERE 
				l_id = ".$row['h_l_code']." 
			AND 
			   l_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
		";

		$lnkL = mysql_query($queryL);
		$rowL= mysql_fetch_assoc($lnkL);
				$inx++;
				if(($inx)%2==1)
				$class="rw1";
				else
				 $class="rw0";
				$outHtml .= '
						<tr class="'.$class.'">
							<td width=3% align="center" style="vertical-align:middle;">'.$inx.'</td>
							<td align="center" style="vertical-align:middle;">'.$row2['p_name'].'</td>
							<td align="center" style="vertical-align:middle;">'.$row['h_p_code'].'</td>
							<td align="center" style="vertical-align:middle;">'.$row['h_price_code'].'</td>
							<td align="center" style="vertical-align:middle;">'.$row['h_l_code'].'</td>
							<td align="center" style="vertical-align:middle;">'.$rowL['l_name'].'</td>
							<td align="center" style="vertical-align:middle;">'.$row['h_deli_name'].'</td>
							<td align="center" style="vertical-align:middle;">'.$amount.'</td>';
				$query = "
		 	      SELECT *  FROM dm_product product
							left join dm_price price
							on product.p_id=price.price_p_id 
	 
			WHERE 
				p_id = ".$row['phd_pid']." 
		";
				
				$ln = mysql_query($query);
				$prod= mysql_fetch_assoc($ln);
				$price=$row['phd_amount']*$prod['p_unit'];
							$name_customer=$row5['name_customer'];
							   
							$outHtml .= '
								         <td>
								          <button type="button" onclick=window.open("printHavale.php?phd_id='.$phd_id.'&ph_code='.$ph_code.'&h_code='.$h_code.'&province_id='.$_SESSION['dm_user_profile']['u_province_id'].'&province_name='.urlencode($provinceName).'&name_customer='. urlencode($name_customer).'&price_code='.$row['h_price_code'].'&p_code='.$row['h_p_code'].'&l_id='.$rowL['l_id'].'&year_id='.$_SESSION['dm_user_profile']['u_year_id'].'&h_id='.$h_id.'") value=" رويت حواله" class="button blue skew" style="font-size:10px; color:#FFFFFF">
											              رويت حواله</button>';
//								         	<button type="button" onclick="addNewHavaleDetail(\'\', \''.$ph_code.'\', \''.$pf_code.'\', \''.$row['phd_id'].'\')"  value=" ثبت حواله"  value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF"> ثبت حابابه</button>';								         
			//					            <button type="button" onclick=window.open("printHavale.php?phd_id='.$row['phd_id'].'&ph_code='.$havaleMainInfo['ph_code'].'&h_code='.$h_code.'&province_name='.$provinceName.'&province_id='.$_SESSION['dm_user_profile']['u_province_id'] .'&name_customer='.$row5['name_customer'].'&price_code='.$row['phd_price_code'].'&p_code='.$row2['p_code'].'&l_id='.$row['phd_l_id'].'","_blank")  value=" رويت حواله"  value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF"> رويت حواله</button>
								        $outHtml .= ' </td>
								         </tr>';  							          
					
				$totalprice =$price+$totalprice;
				
			}
			$outHtml .= '</table>
					
					<div style="#6AAA99;"align="left">
				     <button type="button"  onclick="addNewFactor(\'\', \''.$ph_code.'\')" class="button blue skew" style="font-size:10px; color:#FFFFFF"> ايجاد فاكتور</button>
				     <div align="center"><a href="?pg=PfactorMgmtPg&cmd=dspPishHavale&ph_code='.$ph_code.'"> <img src="images/back1.png"  title="بازگشت" ></img></a> </div>									     
					</tr>				
				<br>';
			
		}

	}else{
	$outHtml .= '<br><br><b><font color="red"> شماره پيش حواله نادرست است</font></b>';
		
	}
	$outHtml .= '</div>';
	$outHtml .='</table>
	';
	echo $outHtml;
}
function formatMoney($number, $fractional=false) {
    if ($fractional) {
        $number = sprintf('%.2f', $number);
    }
    while (true) {
        $replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2', $number);
        if ($replaced != $number) {
            $number = $replaced;
        } else {
            break;
        }
    }
    return $number;
} 
function sucessRegF()
{
		$day_number = jdate('j');
        $month_number = jdate('n');
        $year_number = jdate('y');
         $day_name = jdate('l');
         
	$f_id = isset($_REQUEST['f_id']) ? $_REQUEST['f_id'] : '';
	$pf_code = isset($_REQUEST['pf_code']) ? $_REQUEST['pf_code'] : '';
	$ph_code = isset($_REQUEST['ph_code']) ? $_REQUEST['ph_code'] : '';
	$queryf="SELECT * FROM dm_factor 
	              WHERE f_id=".$f_id."
	              AND
	              f_status_ebtal=". 0 ." ";
	              
	             
				    $lnkf=mysql_query($queryf);
				    print mysql_error();
				    $rowf=mysql_fetch_assoc($lnkf);
				    $f_code=$rowf['f_code'];
	//		print $queryf;	 
	
	    $queryph="SELECT * FROM dm_pish_havale 
              WHERE ph_code=".$ph_code."
              AND
              ph_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
              AND
              ph_id_year=".$_SESSION['dm_user_profile']['u_year_id']."   ";
              
           
	    $lnkph=mysql_query($queryph);
	    print mysql_error();
	    $rowph=mysql_fetch_assoc($lnkph);
	  
	$queryp="SELECT * FROM dm_province 
	              WHERE province_id=".$_SESSION['dm_user_profile']['u_province_id']."";
				    $lnkp=mysql_query($queryp);
				    print mysql_error();
				    $rowp=mysql_fetch_assoc($lnkp);
				    $provinceName=$rowp['province_name'];
	
	$query = "
	 	SELECT *  FROM dm_factor_det 
 
		WHERE 
			fd_f_id = '".$f_id."' 
	    AND
		  fd_status=". 0 ."	
			
			"; 
				  	
	$lnk = mysql_query($query);
//	print $query;
	if(mysql_error()) print mysql_error();
	$outHtml = '<div> <br><table  align="center" style="width:80%;" border="1" class="list">
						  	<tr class="rw1">
						        <td colspan="13"  style="height: 50px;vertical-align:middle;"  align="center" ><b><font size="5">مشخصات فاکتور</font></b></td>
					        </tr>';
			$outHtml .= '			
			<tr class="rw0">
			<td style="height:30px;vertical-align:middle;"><b>&nbsp شماره فاكتور :</b>&nbsp;'.$f_code.'</td><td><b>&nbspتاريخ:</b>&nbsp'. "$year_number/$month_number/$day_number".'</td>					
 		    <td ><b> &nbspپيش حواله به شماره  :</b>&nbsp '.$ph_code.'</td><td colspan="4"><b>&nbsp كد مشتري :</b>&nbsp'.$rowph['ph_customer_code'].'</td>
			</tr>';	
			$outHtml .= '
		        <tr class="rw1">
					<td colspan="16" align=center style="font-weight:bold;height:30px;vertical-align:middle;">
					 
					   <b> ريز پيش فاكتور</b>
					</td>
				</tr>
						<tr class="rw0" style="font-weight:bold;">
							<td align="center" >رديف</td>
							<td align="center">نام کالا</td>
							<td align="center">كد كالا</td>						
							<td align="center">كد قيمت</td>
							<td align="center">مقدار خريد</td>
						    <td align="center">قيمت واحد </td>
						    <td align="center">هزينه اضافی هر واحد </td>
							<td colspan="2" align="center">قيمت كالا </td>
						</tr>'; 
						
			$inx=0;
	while($row= mysql_fetch_assoc($lnk)){
		 
		$inx++;		
			if(($inx)%2==1)
				$class="rw1";				
			else					
				$class="rw0";
						
		    $h_id=$row['fd_h_id'];		
			$queryha = "
				 	SELECT *  FROM dm_havale 
			 
					WHERE 
						h_id = '".$h_id."' "; 						  	
			$lnkha = mysql_query($queryha);
			$rowha= mysql_fetch_assoc($lnkha);
			if(mysql_error()) print mysql_error();
//product
                         $queryp = "
								 	SELECT *  FROM dm_product product
							left join dm_price price
							on product.p_id=price.price_p_id 
							 
									WHERE 
										p_code = '".$rowha['h_p_code']."'
                                    AND p_price_code='".$rowha['h_price_code']."'
                                    
                                    and
			                 price_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
                                    "; 	
															  	
							$lnkp = mysql_query($queryp);
							$rowp= mysql_fetch_assoc($lnkp);
							
							
							$querych = "SELECT *  FROM dm_product product
						left join dm_price price
						on product.p_id=price.price_p_id 
					    left join  dm_charge_factors charge on price.price_id=charge.ch_price_id
							WHERE 
								p_code = ".$rowha['h_p_code']." 
							AND
								p_price_code=".$rowha['h_p_code']."
							AND
								price_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
							AND
							   ch_id_province=".$_SESSION['dm_user_profile']['u_province_id']."";
						//print $querych;		
			$lnkch = mysql_query($querych);
		   sqlErr('for Display charge');
		   $hazine=0;
		if(mysql_affected_rows()>0)
		{
			$ch = mysql_fetch_assoc($lnkch);
			if($ch['ch_dependancy']==1)
			{ 
				if($ch['ch_type_redundancy']==1)
				{
					$hazine=($ch['p_sellprice']*$ch['ch_ratio']);
				}else
				{
					$hazine=-($ch['p_sellprice']*$ch['ch_ratio']);
					
				}

				
					
			}else
			{//mostaghel
				
				$hazine=$ch['ch_charge'];
			}
		}	
							$queryprov = "SELECT *  FROM dm_province
								           WHERE `province_id`='".$_SESSION['dm_user_profile']['u_province_id']."' ";
								  $lnkprov = mysql_query($queryprov);
								  $rowprov= mysql_fetch_assoc($lnkprov);
								    $province_code=$rowprov['province_code'];
							$query5 = "
								 	SELECT *  FROM dm_customer 
							 
									WHERE 
										code_customer = '".$rowha['h_customer_code 	']."'
                                   AND
			                             customer_code_org=".$province_code."";
						 	
															  	
							$lnk5 = mysql_query($query5);
							$row5= mysql_fetch_assoc($lnk5);			
					
			       $outHtml.= '
						<tr class="'.$class.'">
							<td align="center">'.$inx.'</td>
							<td align="center">'.$rowp['p_name'].'</td>
							<td align="center">'.$rowha['h_p_code'].'</td>
													
							<td align="center">'.$rowha['h_price_code'].'</td>
							<td align="center">'.$rowha['h_amount'].'</td>';
			
				$h_price=formatMoney($rowha['h_priceh']);
							
							$outHtml.= '<td align="center">'.$rowp['p_sellprice'].'</td>
							            <td align="center">'.$hazine.'</td>
											<td align="center">'.$h_price.'ريال</td>
								        
								         </tr>';  
							
								     					
				$totalprice =$rowha['h_priceh']+$totalprice;
												
				         	
		}	
		$totalprice=formatMoney($totalprice);
		$outHtml.= '  </table>					
								<div style="bgcolor:#6AAA99;" align="left">
									     <b> جمع کل:</b>'.$totalprice.' ريال
				                 <button type="button" onclick=window.open("PrintFactor.php?f_id='.$f_id.'&ph_code='.$ph_code.'&f_code='.$f_code.'&province_id='.$_SESSION['dm_user_profile']['u_province_id'].'&province_name='.urlencode($provinceName).'&name_customer='.urlencode($row5['name_customer']).'&year_id='.$_SESSION['dm_user_profile']['u_year_id'].'","_blank") value=" چاپ فاكتور"  value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF"> چاپ فاكتور</button>				    
								</div>';
				
	echo $outHtml;

}
function ShowAfactor(){
	
	$day_number = jdate('j');
    $month_number = jdate('n');
    $year_number = jdate('y');
    $day_name = jdate('l');
	
	$f_id = isset($_REQUEST['f_id']) ? $_REQUEST['f_id'] : '';
			
			$queryp="SELECT * FROM dm_province 
			              WHERE
			         province_id=".$_SESSION['dm_user_profile']['u_province_id']."";
						    $lnkp=mysql_query($queryp);
						    print mysql_error();
						    $rowp=mysql_fetch_assoc($lnkp);
						    $provinceName=$rowp['province_name'];	    						
						    if(mysql_error()) print mysql_error();
	
	$outHtml  = '<div dir="rtl">
              		<table  width=90% style=" align="center"  width="100%" class="list" margin-top:20px" >
						  	   <tr align="middle" class="rw1">					  	
						          <td colspan="14"  style="height: 50px;vertical-align:middle;"  ><font size="5"> فاكتور</font-size></td>					   
					           </tr>
					           <tr  class="rw0">
		                          <td colspan="15"><hr style="color:'. $_SESSION['htablecolor']  .';height:40%;"></hr></td>

		                       </tr>';
		$queryf = "
				 SELECT *  FROM dm_factor 
			 
					WHERE 
						f_id = '".$f_id."'
						AND
                  f_status_ebtal='". 0 ."'
						
						";
				
				$lnkf = mysql_query($queryf);			
				if(mysql_error()) print mysql_error();
				$rowf= mysql_fetch_assoc($lnkf);	
				$f_code=$rowf['f_code'];	
					
	if(mysql_num_rows($lnkf)>0){
		$querypf = "
				 SELECT *  FROM dm_pish_factor 
			 
					WHERE 
						pf_code = '".$rowf['f_pf_code']."'
                      AND
                         pf_id_province='". $_SESSION['dm_user_profile']['u_province_id'] ."'
                     
                         ";
			//	print $querypf;												
				$lnkpf = mysql_query($querypf);			
				if(mysql_error()) print mysql_error();
				$rowpf= mysql_fetch_assoc($lnkpf);
				$ph_code=$rowpf['pf_ph_code'];
			$queryph = "
			 SELECT *  FROM dm_pish_havale
		 
				WHERE 
					ph_code = '".$ph_code."'
                      AND
                         ph_id_province='". $_SESSION['dm_user_profile']['u_province_id'] ."'
                     AND
			       ph_id_year=".$_SESSION['dm_user_profile']['u_year_id']."
                         ";
															
			$lnkph = mysql_query($queryph);			
			if(mysql_error()) print mysql_error();
				$rowph= mysql_fetch_assoc($lnkph);
		$queryha="SELECT * FROM dm_havale 
			          WHERE
			             h_pf_code=".$rowf['f_pf_code']."
			           AND 
	                      h_id_year=".$_SESSION['dm_user_profile']['u_year_id']."
	                   AND 
	                     h_id_province=".$_SESSION['dm_user_profile']['u_province_id']."";
			      $lnkha = mysql_query($queryha);   
			      $rowha= mysql_fetch_assoc($lnkha);

			      $querycus = "SELECT *  FROM dm_customer 
		           WHERE `code_customer`='".$rowha['h_customer_code']."'
		           AND
			             customer_code_org=".$rowp['province_code']."";
				   $lnkcus = mysql_query($querycus);
			    //	print $query;
				   $rowcus= mysql_fetch_assoc($lnkcus);
			      
		            $outHtml .= '
							<tr  class="rw1" style="font-weight:bold;">
							<td colspan="2">&nbsp; شماره فاكتور:'.$rowf['f_code'].'</td>
							<td >تاريخ:'. "$year_number/$month_number/$day_number".'</td>
							<td>&nbsp;</td>
							
				 		    <td colspan="1">&nbsp; پيش فاكتور به شماره  : '.$rowf['f_pf_code'].'</td><td >&nbsp; كد مشتري :'.$rowha['h_customer_code'].'</td>
				 		    <td colspan="5">&nbsp; نام مشتري :'.$rowcus['name_customer'].'</td>
							</tr>'; 	
					$outHtml .= '
						          <tr  class="rw1"><td colspan="13"><hr></td></tr>
								<tr class="rw1">
									<td colspan="12" align=center>
									 
									   <b> ريز پيش فاكتور</b>
									</td>
								</tr>
										<tr  class="rw0" style="font-weight:bold;" class="hcss">
											<td align="center" width=5%>رديف</td>
											<td align="center" width=25%>نام کالا</td>
											<td align="center" width=10%>كد كالا</td>
											
											<td align="center" width=10%>كد قيمت</td>
											<td align="center" width=15%>مقدار خريد</td>
										    <td align="center" width=15%>قيمت واحد </td>
										    <td align="center" width=15%>هزينه اضافی هر واحد </td>
											<td align="center" width=25%>قيمت كالا </td>
										</tr>
						</div>';
							
				
		 $querydet = "
				 SELECT *  FROM dm_factor_det 
			 
					WHERE 
						fd_f_id = '".$f_id."'
                     AND
					  fd_status=". 0 ."	
						
						";
				
				$lnkdet = mysql_query($querydet);
				//print $querydet;
				if(mysql_error()) print mysql_error();
		  while($rowdet = mysql_fetch_assoc($lnkdet)){	
		  		
						$queryh = "
							 SELECT *  FROM dm_havale 
								WHERE 
								h_id = '".$rowdet['fd_h_id']."' 
								AND
								 h_id_year=".$_SESSION['dm_user_profile']['u_year_id']."
								 group by h_pf_code
								";
					//	print $queryh;
						
									$lnkh = mysql_query($queryh);
																		
									if(mysql_error()) print mysql_error();
		$queryprov = "SELECT *  FROM dm_province
		           WHERE `province_id`='".$_SESSION['dm_user_profile']['u_province_id']."' ";
		  $lnkprov = mysql_query($queryprov);
		  $rowprov= mysql_fetch_assoc($lnkprov);
		   $province_code=$rowprov['province_code'];			
				$query4 = "
				 	SELECT *  FROM dm_customer 
			 
					WHERE 
						code_customer = '".$rowha['h_customer_code']."' 
					AND
			             customer_code_org=".$province_code."";		
		
		$lnk4 = mysql_query($query4);
		sqlErr('for customer');
		$cusMainInfo = mysql_fetch_assoc($lnk4);	
				$cusName=$cusMainInfo['name_customer'];
				while($rowh = mysql_fetch_assoc($lnkh)){				
				$query2 = "
						 	SELECT *  FROM dm_product product
							left join dm_price price
							on product.p_id=price.price_p_id  
					 
							WHERE 
								p_code = ".$rowh['h_p_code']." 
							AND
							   p_price_code=".$rowh['h_price_code']." 
							  
						    AND
				   price_id_province=".$_SESSION['dm_user_profile']['u_province_id'] ." ";
				
				
		//	print $query2;
							$lnk2 = mysql_query($query2);
							$prod= mysql_fetch_assoc($lnk2);
							
					$querych = "SELECT *  FROM dm_product product
						left join dm_price price
						on product.p_id=price.price_p_id 
					    left join  dm_charge_factors charge on price.price_id=charge.ch_price_id
							WHERE 
								p_code = ".$rowh['h_p_code']." 
							AND
								p_price_code=".$rowh['h_price_code']."
							AND
								price_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
							AND
							   ch_id_province=".$_SESSION['dm_user_profile']['u_province_id']."";
					//	print $querych;		
			$lnkch = mysql_query($querych);
		   sqlErr('for Display charge');
		   
		  
		   		   		   
				   $hazine=$rowh['h_p_add'];
							
							
				$inx++;
				if(($inx)%2==1)
				$class="rw1";
				else
				 $class="rw0";
				$amount =formatMoney($rowha['h_amount'] );
				$p_sellprice =formatMoney($prod['p_sellprice'] );
				$outHtml .= '
						<tr  class="'.$class.'">
							<td align="center">'.$inx.'</td>
							<td align="center">'.$prod['p_name'].'</td>
							<td align="center">'.$prod['p_code'].'</td>							
							<td align="center">'.$rowh['h_price_code'].'</td>
							<td align="center">'.$rowh['h_amount'].'</td>';
			
				$phd_price =formatMoney($rowh['h_price'] );
							$outHtml .= '<td align="center">'.$p_sellprice.'</td>
							              <td align="center">'.$hazine.'</td>
											<td align="center">'.$rowh['h_priceh'].'</td>
								        
								         </tr>  								          
					';
				$totalprice =$rowh['h_priceh']+$totalprice;
				
			}
		  }
			$totalprice =formatMoney($totalprice );
			$outHtml .= '
					
					<tr>
					
				     <td  colspan="4"><b> جمع کل:</b>'.$totalprice.'   ریا ل </td>
				     <td colspan="11">&nbsp;&nbsp;&nbsp;</td>
					</tr>
				</table>';					
		
		}
	//	$outHtml .= '</table><table>';
	 $queryp="SELECT * FROM dm_province 
	              WHERE province_id=".$_SESSION['dm_user_profile']['u_province_id']."";
				    $lnkp=mysql_query($queryp);
				    print mysql_error();
				    $rowp=mysql_fetch_assoc($lnkp);
				    $provinceName=$rowp['province_name'];
				  //  echo $ph_code;
	 $outHtml .=' <div>	      	      
	      	       <button type="button" onclick=window.open("PrintFactor.php?f_id='.$f_id.'&ph_code='.$ph_code.'&f_code='.$f_code.'&province_id='.$_SESSION['dm_user_profile']['u_province_id'].'&province_name='.urlencode($provinceName).'&name_customer='.urlencode($cusName).'&year_id='.$_SESSION['dm_user_profile']['u_year_id'].'","_blank") value=" چاپ فاكتور"  value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF"> چاپ فاكتور</button>				    
	      	       <button type="button" onclick=window.open("PrintFactor1.php?f_id='.$f_id.'&ph_code='.$ph_code.'&f_code='.$f_code.'&province_id='.$_SESSION['dm_user_profile']['u_province_id'].'&province_name='.urlencode($provinceName).'&name_customer='.urlencode($cusName).'&year_id='.$_SESSION['dm_user_profile']['u_year_id'].'","_blank") value=" چاپ فاكتور"  value="CSS" class="button blue skew" style="font-size:10px; color:#FFFFFF">  چاپ فاکتور به همراه پرداختي ها</button>				    
	      	       
	              </div>	';
	    
	
	//		</div>
		//	<br>
				
		
//	$outHtml .= '</div>';
	//$outHtml .='</td>
	//</tr>
	
		//	</table>';
	
			
			
	echo $outHtml;
	
}
