<?php 

function addAProd2Bill(){
//	print_r($_REQUEST);

	$status = isset($_REQUEST['status']) ? $_REQUEST['status'] : 0;
	$p_code = isset($_REQUEST['p_code']) ? $_REQUEST['p_code'] : 0;
	$ph_customer_code=$_REQUEST['ph_customer_code'];
	$ph_customer_type=$_REQUEST['ph_customer_type'];
	$phd_name = $_REQUEST['phd_name'];
	$phd_amount_remined = $_REQUEST['phd_amount_remined'];  
    //code kala zakhire mishavad
	$phd_pid = isset($_REQUEST['phd_code']) ? $_REQUEST['phd_code'] :'';
	$phd_price_code=$_REQUEST['phd_price_code'];
	$phd_amount=$_REQUEST['phd_amount'];
	$phd_amount_pre=$_REQUEST['phd_amount_pre'];
	$phd_l_id=$_REQUEST['phd_l_id'];
	$phd_l_name=$_REQUEST['phd_l_name'];
	$phd_deli_name=$_REQUEST['phd_deli_name'];
	$phd_deli_with=$_REQUEST['phd_deli_with'];
	$cm_req_num=$_REQUEST['cm_req_num'];
	$cm_req_date=$_REQUEST['cm_req_date'];
	$phd_id_unit=$_REQUEST['phd_id_unit'];
	$ph_operation_id=$_REQUEST['ph_operation_id'];
	$ph_mojavez=$_REQUEST['ph_mojavez'];
	$phm_id=$_REQUEST['phm_id'];
	$ph_types=$_REQUEST['ph_types'];
	$ph_modat=$_REQUEST['ph_modat'];
	$ph_zemanat=$_REQUEST['selltype'];
	$phd_tahator=$_REQUEST['phd_tahator'];
	$phd_robari=$_REQUEST['phd_robari'];
	$statusrobari = isset($_REQUEST['statusrobari']) ? $_REQUEST['statusrobari'] :'0';
	

	$h_id = isset($_REQUEST['h_id']) ? $_REQUEST['h_id'] :'0';
	//###

$status='';
	$queryk="SELECT * FROM dm_product product
				left join dm_price price
			    on product.p_id=price.price_p_id
			WHERE p_code=".$phd_pid." AND p_price_code=".$phd_price_code."
			AND
				   price_id_province=".$_SESSION['dm_user_profile']['u_province_id'] ."
				    and
			   p_status=0
				 ";
echo $queryk;
	$lnk1 = mysql_query("SELECT * FROM dm_product product
			left join dm_price price
			on product.p_id=price.price_p_id
			 WHERE p_code=".$phd_pid." AND p_price_code=".$phd_price_code."
			 AND
			  price_id_province=".$_SESSION['dm_user_profile']['u_province_id']."  and
			   p_status=0");
//	echo "SELECT * FROM dm_product product
//			left join dm_price price
//			on product.p_id=price.price_p_id
//			 WHERE p_code=".$phd_pid." AND p_price_code=".$phd_price_code."
//			 AND
//			  price_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
//			  
//			  and
//			   p_status=0
//			  ";
			 
	if(mysql_num_rows($lnk1)>0){
		$row1 = mysql_fetch_assoc($lnk1);
		$p_code=$row1['p_code'];
		
	
		
		if(($row1['p_category']=='9') AND ($phd_tahator=='-2')){
			
			$status=12;
			
		}else{//chek for tahator
		
		//yani en kala vojod darad	
				//$status=0;
		$queryy="SELECT * FROM dm_year WHERE year_status=1  ";
								         
								
							//	print $querych;
								$lnky = mysql_query($queryy);
								$rowy = mysql_fetch_assoc($lnky);
$id_sal=$rowy['year_id'];	
if($row1['p_category']==9){
echo 'yani olofeee';	
	$statusanbar=0;
	
	$queryl="SELECT * FROM dm_location_goods WHERE l_id=".$phd_l_id."
										           ";
										
									//	print $querych;
										$lnkl = mysql_query($queryl);
										$rowl = mysql_fetch_assoc($lnkl);	
										$id_anbar=$rowl['l_id'];
										$id_ostan=$rowl['l_id_province'];
										
										
			//anbar
			$myconn = mysql_connect( "localhost" , "user" , "xlsdj@#@aHdF");
			//mysql_query("SET NAMES 'utf8'",$myconn);
			mysql_select_db("bzacc",$myconn) or die("Can Not Select DataBase Because: ".
			mysql_error());
			
			$c_kala=$phd_pid;
			$c_ostan=$_SESSION['dm_user_profile']['u_province_id'];
			$c_anbar=$rowl['l_code'];
			$sal=1398;
		
$mojodyMojaz=mandePasAzKasrKala($c_ostan,$c_anbar,$sal,$c_kala,$id_ostan,$id_anbar,$id_sal);



	echo 'mojodi';
  echo $mojodyMojaz;
	 if ($phd_amount > $mojodyMojaz)
	 {
	if(($rowl['l_type'] ==0) ){
		
		
	 $status=1;	
	}else if($row1['p_code']==2){
	echo '/';

	  $status=0;
		
	}else if($row1['p_code']==1){
	echo '/';

	  $status=0;
		
	}else if($row1['p_code']==21){
	echo '/';

	  $status=0;
		
	}else if($row1['p_code']==11){
	echo '/';

	  $status=0;
		
	}
	
	else{
		 $status=5;	
		
	}	
	 	
	
	 	
	 }


	//mojodi kol		
mysql_close() ;
	
}else{
	
	$statusanbar=1;
	
	if(($row1['p_unit']==13) or ($row1['p_unit']==14)){
		
	echo 'yani ghoti';
	
	$queryl="SELECT * FROM dm_location_goods WHERE l_id=".$phd_l_id."
										           ";
										
									//	print $querych;
										$lnkl = mysql_query($queryl);
										$rowl = mysql_fetch_assoc($lnkl);	
										
										$id_anbar=$rowl['l_id'];
										$id_ostan=$rowl['l_id_province'];
			//anbar
			$myconn = mysql_connect( "localhost" , "user" , "xlsdj@#@aHdF");
			mysql_query("SET NAMES 'utf8'",$myconn);
			mysql_select_db("meat",$myconn) or die("Can Not Select DataBase Because: ".
			mysql_error());
			
			$c_kala=$phd_pid;
			$c_ostan=$_SESSION['dm_user_profile']['u_province_id'];
			$c_anbar=$rowl['l_code'];
			$sal=1398;
			

$mojodyMojaz=mandePasAzKasrTedad($c_ostan,$c_anbar,$sal,$c_kala,$id_ostan,$id_anbar,$id_sal);
	
	if ($phd_amount > $mojodyMojaz)
	 {
	 if($rowl['l_type'] ==0) {
		
	 $status=1;	
	}else{
	 $status=5;	
		
	}
	 
	 	
	 }else{
	 	//	echo 'kolllllllll';
	 }
	
echo $mojodyMojaz;	
	
	//mojodikol
			
mysql_close() ;
	}
	else if(($row1['p_unit']==15)){
		
echo 'yani shane';
		

$queryl="SELECT * FROM dm_location_goods WHERE l_id=".$phd_l_id."
										           ";
										
									//	print $querych;
										$lnkl = mysql_query($queryl);
										$rowl = mysql_fetch_assoc($lnkl);	
										
										$id_anbar=$rowl['l_id'];
										$id_ostan=$rowl['l_id_province'];
			//anbar
			$myconn = mysql_connect( "localhost" , "user" , "xlsdj@#@aHdF");
			mysql_query("SET NAMES 'utf8'",$myconn);
			mysql_select_db("meat",$myconn) or die("Can Not Select DataBase Because: ".
			mysql_error());
			
			$c_kala=$phd_pid;
			$c_ostan=$_SESSION['dm_user_profile']['u_province_id'];
			$c_anbar=$rowl['l_code'];
			$sal=1398;

		$mojodyMojaz=mandePasAzKasrShane($c_ostan,$c_anbar,$sal,$c_kala,$id_ostan,$id_anbar,$id_sal);
		$A=fmod($phd_amount,12);
		if ($phd_amount > $mojodyMojaz)
	 {
	 if($rowl['l_type'] ==0) {
		
	 $status=1;	
	}else{
	 $status=5;	
		
	}
	 
	 	
	 }else{
	 	//	echo 'kolllllllll';
	 }
	
echo $mojodyMojaz;
		
		
		
	}else{
		$status=1;	
		echo 'gheir ghoti va shane';
		
		$queryl="SELECT * FROM dm_location_goods WHERE l_id=".$phd_l_id."
										           ";
										
									//	print $querych;
										$lnkl = mysql_query($queryl);
										$rowl = mysql_fetch_assoc($lnkl);
										$id_anbar=$rowl['l_id'];
										$id_ostan=$rowl['l_id_province'];	
			//anbar
			$myconn = mysql_connect( "localhost" , "user" , "xlsdj@#@aHdF");
			mysql_query("SET NAMES 'utf8'",$myconn);
			mysql_select_db("meat",$myconn) or die("Can Not Select DataBase Because: ".
			mysql_error());
			
			$c_kala=$phd_pid;
			$c_ostan=$_SESSION['dm_user_profile']['u_province_id'];
			$c_anbar=$rowl['l_code'];
			$sal=1398;
	$mojodyMojaz=mandePasAzKasrKhales($c_ostan,$c_anbar,$sal,$c_kala,$id_ostan,$id_anbar,$id_sal);
	echo '/mojodyMojaz/';
	echo $mojodyMojaz;
	$A=fmod($phd_amount,12);
	if ($phd_amount > $mojodyMojaz)
	 {
	 if($rowl['l_type'] ==0) {
				if($A==0){
			 $status=1;	
				}else{
			 	
			 	 $status=10;
			 }
	}else{
	 $status=5;	
		
	}
	 	
	 }else if($A !=0){
	 	
	 $status=10;	
	 	
	 }


 


//
			
mysql_close() ;
		
		
		
		
	}	
	
}
		
	//yani en kala vojod darad	
			//	$status=1;
				
				$lnk11 = mysql_query("SELECT * FROM dm_product product
							left join dm_price price
							on product.p_id=price.price_p_id
							left join dm_prod_det_t prod_t on prod_t.type_prod_id=product.p_type
							 WHERE
							  price_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
							  
							and 
							  p_type !=33
							and 
							  p_type !=34
							and  
							  p_type !=35
							and  
							  p_type !=36
							and  
							  p_type !=37
						    and 
							  p_type !=38
							and  
							  p_type !=39
							and  
							  p_type !=40
							  and  
							  p_type !=41");
							
							
			
			
			  if(mysql_num_rows($lnk11)>0){
				//$status=4;
			}
		//	echo '/////';
			//	echo $status;
				
				//if($row1['p_charge']==1)
				
					if(1==8){
						
										$querych="SELECT * FROM dm_charge_factors WHERE ch_code_good=".$phd_pid."
										            AND
										           ch_pricecode_good=".$phd_price_code."";
										
									//	print $querych;
										$lnkch = mysql_query($querych);
										$rowch = mysql_fetch_assoc($lnkch);			
										if(mysql_num_rows($lnkch)>0){
									//yani hazine afzodanie an ejad shode	
										  
										}else{
											$status1=3;
										}
						
					}else{
						
					}
//chek for mojavez

					$myconn = mysql_connect( "localhost" , "user" , "xlsdj@#@aHdF");
			mysql_query("SET NAMES 'utf8'",$myconn);
			mysql_select_db("sell",$myconn) or die("Can Not Select DataBase Because: ".
			mysql_error());
						$querymm="SELECT * FROM dm_op_mojavez WHERE phm_id=".$phm_id."
					            ";
										
									//	print $querych;
										$lnkmm = mysql_query($querymm);
										$rowmm = mysql_fetch_assoc($lnkmm);
										echo $querymm;

					//echo $rowmm['phm_ptype'];
					$status=1;
					echo $phd_amount;
					echo '/';
					echo  $rowmm['phm_amount'];
					
					if($phm_id=='')
					{//moghe ebtal
					$status=1;	
					}else{
						
			if($rowmm['phm_ptype']==$row1['p_type'])
					{
						$status=1;
					if($phd_amount > $rowmm['phm_amount']){
echo 'nnnnnnn';
					$status=8;	
						
					}	
						
					} 
					else{
						
						$status=7;
						
					}		

					}
					

//	chek for tahator

	}
			
	}else {
				//kala vojod nadarad
				
			
				$status=2;

		
			}
			
		//echo $status;	
				
			
	$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$status.';'.$status1.';'.$mojodyMojaz.';'.$rowl['l_type'].';'.$p_code.';'.$phd_robari.';'.$statusrobari.';'.$h_id.';';
	//return $billRowId;	
}
function EditAndEbtalCheckk(){
	
	$phd_id = isset($_REQUEST['phd_id']) ? $_REQUEST['phd_id'] : 0;
	$h_id = isset($_REQUEST['h_id']) ? $_REQUEST['h_id'] : 0;
	$phd_amount=$_REQUEST['phd_amount'];
	$phd_jari=$_REQUEST['phd_jari'];
	$his_id=$_REQUEST['his_id'];
	
	$query="SELECT * FROM dm_havale WHERE h_id=".$h_id."";
				$lnk = mysql_query($query);
				$row = mysql_fetch_assoc($lnk);	
				$phd_jari_price=$row['h_p_priceh']*$phd_jari;
				$phd_price=$row['h_p_priceh']*$phd_amount;
				$phd_priceh=($row['h_p_priceh']+$row['h_p_add'])*$phd_amount;
				
			$queryupdate = "
								UPDATE dm_havale 
								SET 

									`h_amount` = ".$phd_jari.",
									`h_price` = ".$phd_price.",
									`h_priceh` = ".$phd_priceh."
									
														 
								WHERE 
									h_id = ".$h_id."";
									
							$lnkupdate = mysql_query($queryupdate);
						//print $queryupdate;
						if(mysql_error()) print mysql_error();	
						
				$queryupdat = "
								UPDATE dm_pish_havale_det 
								SET 

									`phd_amount` = ".$phd_jari.",
									`phd_price` = ".$phd_price.",
									`phd_priceh` = ".$phd_priceh."
									
														 
								WHERE 
									phd_id = ".$phd_id."";
									
							$lnkupdat = mysql_query($queryupdat);
					//	print $queryupdat;
						if(mysql_error()) print mysql_error();	
				$queryu = "
								UPDATE dm_his_havale 
								SET 

									`his_eb_amount` = ".$phd_amount."
									
					 
								WHERE 
									his_id = ".$his_id."";
									
							$lnku = mysql_query($queryu);
						//print $queryu;
						if(mysql_error()) print mysql_error();
	
	
	$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'. $phd_id .';'.$h_id.';'.$phd_amount.';'.$phd_jari.';'.$his_id.';';
	
}
function EditAndEbtal(){
	
	
	$p_code = isset($_REQUEST['phd_code']) ? $_REQUEST['phd_code'] :0;
	$ph_customer_code=$_REQUEST['ph_customer_code'];
	$ph_customer_type=$_REQUEST['ph_customer_type'];
	$phd_name = $_REQUEST['phd_name'];
	$phd_pid = isset($_REQUEST['phd_code']) ? $_REQUEST['phd_code'] :'';
	$phd_id = isset($_REQUEST['phd_id']) ? $_REQUEST['phd_id'] :'';
	$phd_price_code=$_REQUEST['phd_price_code'];
	$phd_amount=$_REQUEST['phd_amount'];
	$phd_l_id=$_REQUEST['phd_l_id'];
	$phd_l_name=$_REQUEST['phd_l_name'];
	$phd_deli_name=$_REQUEST['phd_deli_name'];
	$phd_deli_with=$_REQUEST['phd_deli_with'];
	$cm_req_num=$_REQUEST['cm_req_num'];
	$ph_mojavez=$_REQUEST['ph_mojavez'];
	$cm_req_date=$_REQUEST['cm_req_date'];
	$phd_id_unit=$_REQUEST['phd_id_unit'];
	
	$h_id=$_REQUEST['h_id'];
    $h_code=$_REQUEST['h_code'];
	$phd_price_pre=$_REQUEST['phd_price_pre'];
	$p_code_pre=$_REQUEST['p_code_pre'];
	$p_price_code_pre=$_REQUEST['p_price_code_pre'];
	$l_code_pre=$_REQUEST['l_code_pre'];
	$phd_amount_pre=$_REQUEST['phd_amount_pre'];
	$phd_id_unit_pre=$_REQUEST['phd_id_unit_pre'];
	$his_eb_amount=$phd_amount;
	$his_newamount=$phd_amount_pre - $his_eb_amount;
	$his_pre_date=$_REQUEST['his_pre_date'];
	$ebh_reb_id=$_REQUEST['ebh_reb_id'];
	
	
		$queryh="SELECT * FROM dm_havale 
						             WHERE 
						                h_id=".$h_id." ";
						        		           
							$lnkh=mysql_query($queryh);
						//	print $queryh;
								
							$rowh = mysql_fetch_assoc($lnkh);
	$queryphd="SELECT * FROM dm_pish_havale_det 
						             WHERE 
						                phd_id=".$rowh['h_phd_id']." ";
						        		           
							$lnkphd=mysql_query($queryphd);								
							$rowphd = mysql_fetch_assoc($lnkphd);
							$ph_code=$rowphd['phd_ph_code'];
							
							$queryph="SELECT * FROM dm_pish_havale 
						             WHERE 
						                ph_code=".$ph_code."
						                and
						                ph_id_province=".$rowphd['phd_id_province']."";

						                				        		           
							$lnkph=mysql_query($queryph);								
							$rowph = mysql_fetch_assoc($lnkph);
							$ph_phm_id=$rowph['ph_phm_id'];
				$querymabadi="select * from mabadi.mbd_havale 
  					where
  					     h_id=".$rowh['h_id']."";					     
										        
			$lnkmabadi = mysql_query($querymabadi);
			$rowmabadi = mysql_fetch_assoc($lnkmabadi);	
			//$mabadi=abs($rowmabadi['meghdar_xtra']);
			$mabadi=$rowh['h_amount']-$rowmabadi['meghdar_send'];
					
			
			
		if($rowh['h_statuseb']==1){
			$status='4';
		}else{
							
								$his_newamount1=$rowh['h_mande_havale'] - $his_eb_amount;
								
								
								
								if($his_eb_amount==$phd_amount_pre  )
									{ 
										$statusebtal='2';
										$ebtalkamount=$his_eb_amount;
							
									}else{
										
										$statusebtal='0';
										$ebtalkamount=$phd_amount_pre;
										
									}
							//else
							 if($his_eb_amount>$phd_amount_pre or $his_eb_amount==0)
								{
										
										$status=2;
										
										
										
								$queryh="SELECT * FROM dm_havale 
													             WHERE 
													                h_id=".$h_id." ";
													        		           
														$lnkh=mysql_query($queryh);
														print $queryh;
											
							//		
											
														
														$rowh = mysql_fetch_assoc($lnkh);
									 if($his_eb_amount>$rowh['h_mande_havale'] )
								{
										
										$status=3;
										
									}
									
									
									
									
										
									}
							//		
									else if($rowh['h_robari']!=0 AND $mabadi>0 AND $his_eb_amount > $mabadi)
									{
										
										$status=6;
										
									}else if($rowh['h_robari']!=0 AND $mabadi==0 ){
									$status=6;	
									}
									
	
									
									else{	
										
										
										
										$status=0;	 
										//for new phd_price
													$queryh="SELECT * FROM dm_havale 
													             WHERE 
													                h_id=".$h_id." ";
													        		           
														$lnkh=mysql_query($queryh);
													//	print $queryh;
															
														$rowh = mysql_fetch_assoc($lnkh);
									 if($his_eb_amount>$rowh['h_mande_havale'] )
								{
										
										$status=3;
										
									}
								echo $rowh['h_mande_havale'] ;	
								//	$his_newamount1=$rowh['h_mande_havale'] - $his_eb_amount;
									
									
													    $ph_customer_code=$rowh['h_customer_code'];
														$lnk1 = mysql_query("select * from dm_product product
																			left join dm_price price
																				on product.p_id=price.price_p_id
																					 WHERE p_code=".$phd_pid." AND p_price_code=".$phd_price_code."
																					 AND
																					  price_id_province=".$_SESSION['dm_user_profile']['u_province_id']."");
														$row1 = mysql_fetch_assoc($lnk1);
																		
														$queryunit="SELECT * FROM dm_prod_det_u 
													             WHERE 
													                unit_prod_id=".$phd_id_unit." ";
													        		           
														$lnkunit=mysql_query($queryunit);
														print mysql_error();
														$rowunit=mysql_fetch_assoc($lnkunit);
													    $unitName=$rowunit['unit_prod_name'];
														$ratio=$rowunit['unit_prod_ratio'];
														
														$phd_price=$ratio*$his_newamount*($row1['p_sellprice']+$rowh['h_p_add']);
														$phd_priceh=$ratio*$his_newamount*($row1['p_sellprice']+$rowh['h_p_add']);
												        $phd_p_price=$row1['p_sellprice'];
								
							                                  if ($rowh['h_id_year']==8	){
							                                  	
							                                  //	$norozdate=gmdate('Y-m-d');
							                                  	//	$ebh_reg_time=gmdate("Y-m-d H:i",time()+12600);
							                                  	
							                                  	$norozdate='2019-03-20';
							                                  	$ebh_reg_time='2019-03-20 04:00:00';
							                                  	
							                                  }	else{
							                                  	
							                                  		$norozdate=gmdate('Y-m-d');
							                                  		$ebh_reg_time=gmdate("Y-m-d H:i",time()+12600);
							                                  	
							                                  }				
															$query = "
																	UPDATE dm_havale 
																	SET 
																		  			 
																		`h_amount` = '".$his_newamount."',
																		`h_mande_havale` = '".$his_newamount1."',    			
																		`h_price` = '".$phd_price."',
																		`h_priceh` = '".$phd_priceh."',
																		
																		`h_ebtalk_amount` = '".$ebtalkamount."',
																		`h_status` = '".$statusebtal."',
																		`h_statuseb` = '1'
																		
																							 
																	WHERE 
																		h_id = ".$h_id." 	";
																		
																$lnk = mysql_query($query);
												//			print ($query);
															if(mysql_error()) print mysql_error();
													
														//}
												if($_SESSION['dm_user_profile']['u_year_id']==100)
																{
																	$year_id=$_SESSION['dm_user_profile']['year_id'];
																	
																}else{
																	
																	$year_id=$_SESSION['dm_user_profile']['u_year_id'];
																}
																
																	
																
						$query = array(
										'his_h_id' => $h_id,
										'his_pre_amount' => $phd_amount_pre,
										'his_eb_amount' => $his_eb_amount,
						                'his_date' => $norozdate,
										'his_pre_date' =>$his_pre_date,
										'his_u_id' => $_SESSION['dm_user_profile']['u_id'],
								     	'his_h_code' => $h_code,
									    'his_p_code' => $p_code_pre,
										'his_p_pcode' => $p_price_code_pre,
								     	'his_deli_name' => $phd_deli_name,
					                    'his_l_code' => $rowh['h_l_code'],
									    'his_id_unit' => $phd_id_unit_pre,
									    'his_price_pre' => $phd_price_pre,
									    'his_id_province' => $_SESSION['dm_user_profile']['u_province_id'],
						                'his_reg_time' =>  $ebh_reg_time,
									    'his_id_year' => $year_id
											   
								     	);
				//	print $query;
						$query = inserterQMaker('dm_his_havale', $query);
						
						$lnk = mysql_query($query);
						$his_id = mysql_insert_id();
	                   if(mysql_error()) print mysql_error();

	                   //update phm
	                   
           $querymm="SELECT * FROM dm_op_mojavez WHERE phm_id=".$ph_phm_id."  ";
          
	
					print $querych;
					$lnkmm = mysql_query($querymm);
					$rowmm = mysql_fetch_assoc($lnkmm);
					print $querymm;
	$phm_amount=($rowmm['phm_amount']+$his_eb_amount);
	$phm_amountes=($rowmm['phm_amountes']-$his_eb_amount);
	$queryphm = "
		UPDATE dm_op_mojavez 
		SET 
			  			 
			`phm_amount` = '".$phm_amount."',
			`phm_amountes` = '".$phm_amountes."'   			
								 
		WHERE 
			phm_id = ".$ph_phm_id." 	";
			
	$lnkphm = mysql_query($queryphm);
print ($queryphm);
if(mysql_error()) print mysql_error();	
                   
								                   
												if($lnk){		
														mysql_query("COMMIT");
														//echo 'Done';
														}else{
															
														mysql_query("ROLLBACK");
												      echo "ارتباط شما قطع شده لطفا دوباره وارد شويد";
												         $_SESSION['isLogged']=false;	
															
														}
													$queryeb="SELECT MAX(ebh_code) maxId FROM dm_ebtal_h
																		         WHERE
																		           ebh_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
																		          ";
																		$lnkeb=mysql_query($queryeb);
																		print mysql_error();
																		$roweb=mysql_fetch_assoc($lnkeb);
																		$ebh_code=$roweb['maxId']+1;
												if($_SESSION['dm_user_profile']['u_year_id']==100)
																{
																	$year_id=$_SESSION['dm_user_profile']['year_id'];
																	
																}else{
																	
																	$year_id=$_SESSION['dm_user_profile']['u_year_id'];
																}
													$query = array(
														
														'ebh_reg_date' => $norozdate,
													    'ebh_reg_time'=>   $ebh_reg_time,
														'ebh_h_id' => $his_id,
												      	'ebh_code' => $ebh_code,
													    'ebh_reb_id' => $ebh_reb_id,
													    'ebh_customer_code' => $ph_customer_code,
													    'ebh_type' => 0,
														'ebh_id_province' => $_SESSION['dm_user_profile']['u_province_id'],
												     	'ebh_id_year' =>     $year_id,
													    'ebh_u_id' =>        $_SESSION['dm_user_profile']['u_id']
													   	   
												     	);
											//	print $query;
													$query = inserterQMaker('dm_ebtal_h', $query);
													print  $query;
													$lnk = mysql_query($query);
													$ebh_id = mysql_insert_id();
													if(mysql_error()) print mysql_error();
													
								$queryupdate = "
												UPDATE dm_havale 
												SET 

													`h_statuseb` = '0'
													
																		 
												WHERE 
													h_id = ".$h_id."";
													
											$lnkupdate = mysql_query($queryupdate);
										
										if(mysql_error()) print mysql_error();
											
										
										
								}
		}
	
	$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'. $ebh_id .';'.$status.';';
	
}
function checkCodeP(){
	
	$status = isset($_REQUEST['status']) ? $_REQUEST['status'] : 0;
	$p_code = isset($_REQUEST['p_code']) ? $_REQUEST['p_code'] : 0;
	$ph_customer_code=$_REQUEST['ph_customer_code'];
	$ph_customer_type=$_REQUEST['ph_customer_type'];
	$phd_name = $_REQUEST['phd_name'];
	$phd_amount_remined = $_REQUEST['phd_amount_remined'];  
    //code kala zakhire mishavad
    $cm_req_date=$_REQUEST['cm_req_date'];
	$phd_pid = isset($_REQUEST['phd_code']) ? $_REQUEST['phd_code'] :'';
	$phd_price_code=$_REQUEST['phd_price_code'];
	$phd_amount=$_REQUEST['phd_amount'];
	$phd_l_id=$_REQUEST['phd_l_id'];
	$phd_l_name=$_REQUEST['phd_l_name'];
	$phd_deli_name=$_REQUEST['phd_deli_name'];
	$phd_deli_with=$_REQUEST['phd_deli_with'];
	$cm_req_num=$_REQUEST['cm_req_num'];	
	$phd_id_unit=$_REQUEST['phd_id_unit'];
	$ph_operation_id=$_REQUEST['ph_operation_id'];
	$ph_mojavez=$_REQUEST['ph_mojavez'];
	$phm_id=$_REQUEST['phm_id'];
	$ph_types = !empty($_REQUEST['ph_types']) ? $_REQUEST['ph_types'] : '';

	$ph_modat=$_REQUEST['ph_modat'];
	$ph_zemanat=$_REQUEST['ph_zemanat'];
	$phd_tahator=$_REQUEST['phd_tahator'];
	$phd_robari=$_REQUEST['phd_robari'];
	
	
	
//change format date	
	
    $date = explode('/', $cm_req_date);
    $cm_req_date=$date[2].'/'.$date[1].'/'.$date[0] ;
    
	$jdate=$cm_req_date;
	$jdate .= '/\/';
	list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
	list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
	$cm_req_date = $gyear."-".$gmonth."-".$gday;
    
	$queryp="SELECT * FROM  dm_product product
				left join dm_price price
				on product.p_id=price.price_p_id
		           WHERE p_code=".$p_code." 
		        AND 
		        p_price_code=".$phd_price_code."
		        AND
		         price_id_province=".$_SESSION['dm_user_profile']['u_province_id']."";      
	$lnkp=mysql_query($queryp);
//	print $queryp;
	$rowp = mysql_fetch_assoc($lnkp);
	
	$TheTime = time();
	$TimeZone = 3.5;
	$TheTime += $TimeZone * 3600;
	$StrTime = gmdate( "Y-M-d");
	
	$query="SELECT MAX(ph_code) maxId FROM dm_pish_havale 
	        WHERE
	         ph_id_province=".$_SESSION['dm_user_profile']['u_province_id']."";
	         	            
	$lnk=mysql_query($query);
//	print $query;
	print mysql_error();
	$row=mysql_fetch_assoc($lnk);
	$ph_code=$row['maxId']+1;	
	if($status==0){
		
									
								$queryk="SELECT * FROM dm_product product
										  left join dm_price price
										  on product.p_id=price.price_p_id
									   WHERE p_code=".$phd_pid." AND p_price_code=".$phd_price_code."
										     AND
										      price_id_province=".$_SESSION['dm_user_profile']['u_province_id']."";
									   
									$lnk1 = mysql_query($queryk);
									$row1 = mysql_fetch_assoc($lnk1);
									$p_name=$row1['p_name'];
								//yani en kala vojod darad	
													
									$queryunit="SELECT * FROM dm_prod_det_u 
								        WHERE unit_prod_id=".$phd_id_unit." ";
								        		           
									$lnkunit=mysql_query($queryunit);
									print mysql_error();
									$rowunit=mysql_fetch_assoc($lnkunit);
								    $unitName=$rowunit['unit_prod_name'];
									$ratio=$rowunit['unit_prod_ratio'];
							//hazineh afzodani agar dara		
								$queryaf = "SELECT * FROM dm_product product
											left join dm_price price
										    on product.p_id=price.price_p_id
											left join dm_charge_factors chf
											on product.p_code = chf.ch_code_good and price.p_price_code=chf.ch_pricecode_good
											left join dm_opr_ch opr_ch 
											on opr_ch.oph_ch_id=chf.ch_id
											left join dm_operation_acc opr_acc
											on opr_acc.g_id=opr_ch.oph_op_id
											left join dm_loc_ch lch  
											on  lch.chl_ch_id=chf.ch_id
											left join dm_location_goods l on l.l_id=lch.chl_l_id
									
							
										WHERE
							          			        oph_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
												AND
													    price_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
											    AND
													   l_id=".$phd_l_id."
												AND
													    ch_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
											    AND
													   l_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
											    AND
												        p_code=".$phd_pid." 
												AND    
												        p_price_code=".$phd_price_code."
											    AND
									                    g_id=".$ph_operation_id."  
									            AND
									                    chl_id_province=".$_SESSION['dm_user_profile']['u_province_id']."    
									             AND          
									                    '".gmdate('Y-m-d')."'   between  `ch_fdate`   AND  `ch_ldate` ";   
									                     				 	
									$lnkaf = mysql_query($queryaf);
								print 	$queryaf;
								  if(mysql_num_rows($lnkaf)>0){
								  	
								  	$rowaf= mysql_fetch_assoc($lnkaf);
								  	$ch_dependancy=$rowaf['ch_dependancy'];
									 
									$p_sellpriceh= $row1['p_sellprice'] +$rowaf['ch_p_add'];		  	
							
									$phd_priceh=(($ratio )* (($phd_amount )* ($p_sellpriceh)) );
									$phd_p_priceh=$p_sellpriceh;
							        $phd_p_price = $row1['p_sellprice'];
							        $phd_price=(($ratio )* (($phd_amount )* ($row1['p_sellprice'])));  
							        
							
							        
							        $phd_afzodani=1;	  	
								  }else{
								  		  	
								  	$phd_price=(($ratio )* (($phd_amount )* ($row1['p_sellprice'])));
									$phd_priceh=(($ratio )* (($phd_amount )* ($row1['p_sellprice'])));
							        $phd_p_price=$row1['p_sellprice'];
							        $phd_p_priceh=$row1['p_sellprice'];	  
							        $phd_afzodani=0;	
								  }
								//  echo $phd_price;
								   
							if($phd_price==''){
								$html='<div align="center" style="background: yellow"><b>  کالای شما ثبت نشد لطفا دوباره تلاش کنید   !!!!!!!!</b></font></div>';
							$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$html;
								
							}else if($phd_price!=''){
								if($phd_price!=''){
								
										if($_SESSION['shomarePishHavale']==''){
											
											$querys = "
												 	SELECT *  FROM dm_signature_g 
											 
													WHERE 
														sig_status = ". 1 ." 
													AND
													   sig_id_province=".$_SESSION['dm_user_profile']['u_province_id']  ."
													
												";
												$lnks = mysql_query($querys);
												$rows= mysql_fetch_assoc($lnks);
												
											$inx=0;	
											if($_SESSION['dm_user_profile']['u_year_id']==100)
											{
												$year_id=$_SESSION['dm_user_profile']['year_id'];
												
											}else{
												
												$year_id=$_SESSION['dm_user_profile']['u_year_id'];
											}
											$query = array(
											
											        'ph_code' => $ph_code,
													'ph_customer_code' => $ph_customer_code,
										       	 	'ph_customer_type' => $ph_customer_type, 
												    'ph_reg_date'=> gmdate('Y-m-d'),
												    'cm_req_date' => $cm_req_date,
										       	 	'cm_req_num' => $cm_req_num, 
											        'ph_operation_id' => $ph_operation_id,
											        'ph_id_province' => $_SESSION['dm_user_profile']['u_province_id'], 
											        'ph_id_year' => $year_id, 
											        'ph_u_id' => $_SESSION['dm_user_profile']['u_id'],
											        'ph_mojavez' => $ph_mojavez,
											        'ph_sig_id' => $rows['sig_id'],
											        'ph_phm_id' => $phm_id,
													'ph_types' => $ph_types,
													'ph_zemanat' => $ph_zemanat,
													'ph_modat' => $ph_modat,
											        'ph_tahator' => $ph_tahator
											       
								
							
											);
											// 'phd_modat' => $phd_modat
											// 'phd_types' => $phd_types,
											    //    'phd_dtt_id' => $phd_dtt_id
								print $query;	
									
											$_SESSION['shomarePishHavale']=$ph_code=$row['maxId']+1;
											$query = inserterQMaker('dm_pish_havale', $query);
											$lnk = mysql_query($query);
											if(mysql_error()) print mysql_error();
											print $query;
											$ph_id = mysql_insert_id();
										}else{
											
										}
										
										}	
							
							//en testi gozashtam			
							$queryaf = "SELECT * FROM dm_product product
											left join dm_price price
										    on product.p_id=price.price_p_id
											left join dm_charge_factors chf
											on product.p_code = chf.ch_code_good and price.p_price_code=chf.ch_pricecode_good
											left join dm_opr_ch opr_ch 
											on opr_ch.oph_ch_id=chf.ch_id
											left join dm_operation_acc opr_acc
											on opr_acc.g_id=opr_ch.oph_op_id
											left join dm_loc_ch lch  
											on  lch.chl_ch_id=chf.ch_id
											left join dm_location_goods l on l.l_id=lch.chl_l_id
									
							
										WHERE
							          			        oph_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
												AND
													    price_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
											    AND
													   l_id=".$phd_l_id."
												AND
													    ch_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
											    AND
													   l_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
											    AND
												        p_code=".$phd_pid." 
												AND    
												        p_price_code=".$phd_price_code."
											    AND
									                    g_id=".$ph_operation_id."  
									            AND
									                    chl_id_province=".$_SESSION['dm_user_profile']['u_province_id']."    
									            AND          
									                    '".gmdate('Y-m-d')."'   between  `ch_fdate`   AND  `ch_ldate` ";   
									                     				 	
									$lnkaf = mysql_query($queryaf);
								print 	$queryaf;
								  if(mysql_num_rows($lnkaf)>0){
								  	
								  	$rowaf= mysql_fetch_assoc($lnkaf);
								  	$ch_dependancy=$rowaf['ch_dependancy'];
									 
									$p_sellpriceh= $row1['p_sellprice'] +$rowaf['ch_p_add'];		  	
							
									$phd_priceh=(($ratio )* (($phd_amount )* ($p_sellpriceh)) );
									$phd_p_priceh=$p_sellpriceh;
							        $phd_p_price = $row1['p_sellprice'];
							        $phd_price=(($ratio )* (($phd_amount )* ($row1['p_sellprice'])));  
							        
							
							        
							        $phd_afzodani=1;	  	
								  }else{
								  		  	
								  	$phd_price=(($ratio )* (($phd_amount )* ($row1['p_sellprice'])));
									$phd_priceh=(($ratio )* (($phd_amount )* ($row1['p_sellprice'])));
							        $phd_p_price=$row1['p_sellprice'];
							        $phd_p_priceh=$row1['p_sellprice'];	  
							        $phd_afzodani=0;	
								  }		
										
							if($_SESSION['dm_user_profile']['u_year_id']==100)
											{
												$year_id=$_SESSION['dm_user_profile']['year_id'];
												
											}else{
												
												$year_id=$_SESSION['dm_user_profile']['u_year_id'];
											}	
										
										
										$query = array(
											'phd_ph_code' => $_SESSION['shomarePishHavale'],
											'phd_amount_remined' => $phd_amount_remined,
									        'phd_pid' => $phd_pid,
									        'phd_price_code' => $phd_price_code,
									        'phd_l_id' => $phd_l_id,
									        'phd_l_name' => $phd_l_name,
										    'phd_deli_name' => $phd_deli_name, 
									        'phd_amount' => $phd_amount,
										    'phd_price' => $phd_price,
										    'phd_priceh' => $phd_priceh,
									    	'phd_reg_date'=> gmdate('Y-m-d'),
										    'phd_tahator' => $phd_tahator,
										    'phd_robari' => $phd_robari,
										    'phd_p_price' => $row1['p_sellprice'],
										    'phd_p_priceh' => $phd_p_priceh,
											'phd_id_province' =>$_SESSION['dm_user_profile']['u_province_id'],
										    'phd_id_year' =>$year_id,
										    'phd_u_id' =>$_SESSION['dm_user_profile']['u_id'],
										    'phd_id_unit' =>$row1['p_unit'],
										    'phd_operation_id' =>$ph_operation_id,
										    'phd_p_add' =>$rowaf['ch_p_add'],
										    'phd_afzodani' =>$phd_afzodani
										    
											
										);
									//	'phd_modat' => $phd_modat
										//'phd_types' => $phd_types,
										//	'phd_dtt_id' => $phd_dtt_id
									print $query;
										$query = inserterQMaker('dm_pish_havale_det', $query);
										$inx++;
									//	print $query;
										$lnk = mysql_query($query);
										if(mysql_error()) print mysql_error();
										$billRowId = mysql_insert_id();	
										
										
										$querymm="SELECT * FROM dm_op_mojavez WHERE phm_id=".$phm_id." ";
												           
																	
																//	print $querych;
																	$lnkmm = mysql_query($querymm);
																	$rowmm = mysql_fetch_assoc($lnkmm);
										$phm_amounti=($rowmm['phm_amount']-$phd_amount);
										$phm_amountes=($rowmm['phm_amountes']+$phd_amount);
										$queryphm = "
											UPDATE dm_op_mojavez 
											SET 
												  			 
												`phm_amount` = '".$phm_amounti."',
												`phm_amountes` = '".$phm_amountes."'   			
																	 
											WHERE 
												phm_id = ".$phm_id." 	";
												
										$lnkphm = mysql_query($queryphm);
									//print ($query);
									if(mysql_error()) print mysql_error();	
								
										$out='<table  align="center" width=70% bgcolor=#BBF0F7><tr ><td style="color:red;size:20%;vertical-align:middle;"><b>-</b></font></td><td align="center" style="vertical-align:middle;"><b> كالايي با نام :</b></td><td align="center" style="vertical-align:middle;">'.$p_name.'</td><td align="center" style="vertical-align:middle;"><b> با كد قيمت:</b></td><td align="center" style="vertical-align:middle;">'.$phd_price_code.'</td>
										<td align="center" style="vertical-align:middle;"><b>به مقدار:</b> </td><td align="center" style="vertical-align:middle;">
										 '.$phd_amount.''.$unitName.'</td><td align="center" style="vertical-align:middle;"><b> اضافه شد </b>
										';
										$html = '<div id="bPrdC_'.$billRowId.'" ><span onclick=""> '.$out.' <span style="cursor:pointer;color:red;size:20%;style="vertical-align:middle;" onclick="delAProdFromBill(\'\', \''.$billRowId.'\', \''.$_SESSION['shomarePishHavale'].'\')" ><img src="images/delete.PNG" width="20" height="20" title="حذف" onmouseOver="this.src=\'images/delete.PNG\'" onmouseOut="this.src=\'images/delete.PNG\'"></img></span></></div></tr>
										<tr><td colspan="8"><hr></td></tr></table>';
										
										if($row1['p_category']==7){
										$html .= '<div id="bPrdC1_'.$billRowId.'" ><span onclick="">  <span style="cursor:pointer" onclick="addPdetFromBill(\'\', \''.$billRowId.'\', \''.$_SESSION['shomarePishHavale'].'\')" >اضافه کردن جزییات</span></></div></tr>
								<tr><td colspan="8"><hr></td></tr></table>';}
										$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$html;}
	}			

	
	
	
}
function checkCodeP1(){
	
	$status = isset($_REQUEST['status']) ? $_REQUEST['status'] : 0;
	$p_code = isset($_REQUEST['p_code']) ? $_REQUEST['p_code'] : 0;
	$ph_customer_code=$_REQUEST['ph_customer_code'];
	$ph_customer_type=$_REQUEST['ph_customer_type'];
	$phd_name = $_REQUEST['phd_name'];
	$phd_amount_remined = $_REQUEST['phd_amount_remined'];  
    //code kala zakhire mishavad
    $cm_req_date=$_REQUEST['cm_req_date'];
	$phd_pid = isset($_REQUEST['phd_code']) ? $_REQUEST['phd_code'] :'';
	$phd_price_code=$_REQUEST['phd_price_code'];
	$phd_amount=$_REQUEST['phd_amount'];
	$phd_l_id=$_REQUEST['phd_l_id'];
	$phd_l_name=$_REQUEST['phd_l_name'];
	$phd_deli_name=$_REQUEST['phd_deli_name'];
	$phd_deli_with=$_REQUEST['phd_deli_with'];
	$cm_req_num=$_REQUEST['cm_req_num'];	
	$phd_id_unit=$_REQUEST['phd_id_unit'];
	$ph_operation_id=$_REQUEST['ph_operation_id'];
	$ph_mojavez=$_REQUEST['ph_mojavez'];
	$phm_id=$_REQUEST['phm_id'];
	$ph_types = !empty($_REQUEST['ph_types']) ? $_REQUEST['ph_types'] : '';

	$ph_modat=$_REQUEST['ph_modat'];
	$ph_zemanat=$_REQUEST['ph_zemanat'];
	$phd_tahator=$_REQUEST['phd_tahator'];
	$phd_robari=$_REQUEST['phd_robari'];
	$h_id=$_REQUEST['h_id'];


	
	$queryh="SELECT * FROM  dm_havale
				where
		        h_id=".$h_id."";      
	$lnkh=mysql_query($queryh);
	print $queryh;
	$rowh = mysql_fetch_assoc($lnkh);
	$queryphd="SELECT * FROM  dm_pish_havale_det
				where
		       phd_id=".$rowh['h_phd_id']."";      
	$lnkphd=mysql_query($queryphd);
print $queryphd;
	$rowphd = mysql_fetch_assoc($lnkphd);
	$queryph="SELECT * FROM  dm_pish_havale
				where
		       ph_code=".$rowphd['phd_ph_code']."
		       and
		       ph_id_province=".$_SESSION['dm_user_profile']['u_province_id'].";
		       
		       ";      
	$lnkph=mysql_query($queryph);
	print $queryph;
	$rowph = mysql_fetch_assoc($lnkph);

	
	if($rowh['h_phidrobari']==0){
		
		$query="SELECT MAX(ph_code) maxId FROM dm_pish_havale 
	        WHERE
	         ph_id_province=".$_SESSION['dm_user_profile']['u_province_id']."";
	         	            
	$lnk=mysql_query($query);
//	print $query;
	print mysql_error();
	$row=mysql_fetch_assoc($lnk);
	$ph_code=$row['maxId']+1;
	
	
$query1 = array(
					
					        'ph_code' => $ph_code,
							'ph_customer_code' => $rowph['ph_customer_code'],
				       	 	'ph_customer_type' => $rowph['ph_customer_type'], 
						    'ph_reg_date'=> gmdate('Y-m-d'),
						    'cm_req_date' => $rowph['cm_req_date'],
				       	 	'cm_req_num' => $rowph['cm_req_num'], 
					        'ph_operation_id' => $rowph['ph_operation_id'],
					        'ph_id_province' => $_SESSION['dm_user_profile']['u_province_id'], 
					        'ph_id_year' => $rowph['ph_id_year'], 
					        'ph_u_id' => $_SESSION['dm_user_profile']['u_id'],
					        'ph_mojavez' => $rowph['ph_mojavez'],
					        'ph_sig_id' => $rowph['ph_sig_id'],
					        'ph_phm_id' => $rowph['ph_phm_id'],
							'ph_types' => $rowph['ph_types'],
							'ph_zemanat' =>$rowph['ph_zemanat'],
							'ph_modat' => $rowph['ph_modat'],
					        'ph_tahator' => $rowph['ph_tahator'],
                            'ph_robari_s' => '1'
					);
				
											$query1 = inserterQMaker('dm_pish_havale', $query1);
											$lnk1 = mysql_query($query1);
											if(mysql_error()) print mysql_error();
											$ph_id = mysql_insert_id();	
											print $query1;
											
											
											$query = "
														UPDATE dm_havale 
														SET 			
															`h_phidrobari` = '". $ph_id ."'			
														WHERE 
															h_id = '".$h_id."'
															";       						
													$lnk = mysql_query($query);
													if(mysql_error()) print mysql_error();
													
											
					if($_SESSION['dm_user_profile']['u_year_id']==100)
											{
												$year_id=$_SESSION['dm_user_profile']['year_id'];
												
											}else{
												
												$year_id=$_SESSION['dm_user_profile']['u_year_id'];
											}	
										
											
					$queryp="SELECT * FROM  dm_product product
								left join dm_price price
								on product.p_id=price.price_p_id
						           WHERE p_code=".$rowphd['phd_pid']." 
						        AND 
						        p_price_code=".$phd_price_code."
						        AND
						         price_id_province=".$_SESSION['dm_user_profile']['u_province_id']."";      
					$lnkp=mysql_query($queryp);
				//	print $queryp;
					$rowp = mysql_fetch_assoc($lnkp);						
									$phd_price=((($phd_amount )* ($rowp['p_sellprice'])));
									$phd_priceh=((($phd_amount )* ($rowp['p_sellprice'])));
							        $phd_p_price=$rowp['p_sellprice'];
							        $phd_p_priceh=$rowp['p_sellprice'];	  
							        $phd_afzodani=0;	
										
										$query2 = array(
											'phd_ph_code' => $ph_code,
											'phd_amount_remined' => 0,
									        'phd_pid' => $rowphd['phd_pid'],
									        'phd_price_code' => $phd_price_code,
									        'phd_l_id' => $rowphd['phd_l_id'],
									        'phd_l_name' => $rowphd['phd_l_name'],
										    'phd_deli_name' => $rowphd['phd_deli_name'], 
									        'phd_amount' => $phd_amount,
										    'phd_price' => $phd_price,
										    'phd_priceh' => $phd_priceh,
									    	'phd_reg_date'=> gmdate('Y-m-d'),
										    'phd_tahator' => $rowphd['phd_tahator'],
										    'phd_robari' => $rowphd['phd_robari'],
									    	'phd_p_price' => $row1['p_sellprice'],
										    'phd_p_priceh' => $phd_p_priceh,
											'phd_id_province' =>$_SESSION['dm_user_profile']['u_province_id'],
										    'phd_id_year' =>$rowphd['phd_id_year'],
										    'phd_u_id' =>$_SESSION['dm_user_profile']['u_id'],
										    'phd_id_unit' =>$rowphd['phd_id_unit'],
										    'phd_operation_id' =>$rowphd['ph_operation_id'],
										    'phd_p_add' =>$rowphd['phd_p_add'],
										    'phd_afzodani' =>$rowphd['phd_afzodani'],
										    'phd_hidrobari' =>$h_id,
									     	'phd_robari_s' =>'1'
										    									
										);
										$query2 = inserterQMaker('dm_pish_havale_det', $query2);
																		
										$lnk2 = mysql_query($query2);
										if(mysql_error()) print mysql_error();
										$billRowId = mysql_insert_id();	
										
										
																
	}else{
		
		$queryph1="SELECT * FROM  dm_pish_havale
				where
		        ph_id=".$rowh['h_phidrobari']."";      
	$lnkph1=mysql_query($queryph1);
//	print $queryp;
	$rowph1 = mysql_fetch_assoc($lnkph1);
		
	
	
	if($_SESSION['dm_user_profile']['u_year_id']==100)
											{
												$year_id=$_SESSION['dm_user_profile']['year_id'];
												
											}else{
												
												$year_id=$_SESSION['dm_user_profile']['u_year_id'];
											}	
										
											
					$queryp="SELECT * FROM  dm_product product
								left join dm_price price
								on product.p_id=price.price_p_id
						           WHERE p_code=".$rowphd['phd_pid']." 
						        AND 
						        p_price_code=".$phd_price_code."
						        AND
						         price_id_province=".$_SESSION['dm_user_profile']['u_province_id']."";      
					$lnkp=mysql_query($queryp);
				
					print $queryp;
					$rowp = mysql_fetch_assoc($lnkp);						
									$phd_price=((($phd_amount )* ($rowp['p_sellprice'])));
									$phd_priceh=((($phd_amount )* ($rowp['p_sellprice'])));
							        $phd_p_price=$rowp['p_sellprice'];
							        $phd_p_priceh=$rowp['p_sellprice'];	  
							        $phd_afzodani=0;	
										
										$query3 = array(
											'phd_ph_code' => $rowph1['ph_code'],
											'phd_amount_remined' => 0,
									        'phd_pid' => $rowphd['phd_pid'],
									        'phd_price_code' => $phd_price_code,
									        'phd_l_id' => $rowphd['phd_l_id'],
									        'phd_l_name' => $rowphd['phd_l_name'],
										    'phd_deli_name' => $rowphd['phd_deli_name'], 
									        'phd_amount' => $phd_amount,
										    'phd_price' => $phd_price,
										    'phd_priceh' => $phd_priceh,
									    	'phd_reg_date'=> gmdate('Y-m-d'),
										    'phd_tahator' => $rowphd['phd_tahator'],
										    'phd_robari' => $rowphd['phd_robari'],
									    	'phd_p_price' => $row1['p_sellprice'],
										    'phd_p_priceh' => $phd_p_priceh,
											'phd_id_province' =>$_SESSION['dm_user_profile']['u_province_id'],
										    'phd_id_year' =>$rowphd['phd_id_year'],
										    'phd_u_id' =>$_SESSION['dm_user_profile']['u_id'],
										    'phd_id_unit' =>$rowphd['phd_id_unit'],
										    'phd_operation_id' =>$rowphd['ph_operation_id'],
										    'phd_p_add' =>$rowphd['phd_p_add'],
										    'phd_afzodani' =>$rowphd['phd_afzodani']
										    									
										);
										$query3 = inserterQMaker('dm_pish_havale_det', $query3);
																		
										$lnk3 = mysql_query($query3);
										if(mysql_error()) print mysql_error();
										$billRowId = mysql_insert_id();	
	print $query3;
	

	
	}
	
										$out='<table  align="center" width=70% bgcolor=#BBF0F7><tr ><td style="color:red;size:20%;vertical-align:middle;"><b>-</b></font></td><td align="center" style="vertical-align:middle;"><b> كالايي با نام :</b></td><td align="center" style="vertical-align:middle;">'.$p_name.'</td><td align="center" style="vertical-align:middle;"><b> با كد قيمت:</b></td><td align="center" style="vertical-align:middle;">'.$phd_price_code.'</td>
										<td align="center" style="vertical-align:middle;"><b>به مقدار:</b> </td><td align="center" style="vertical-align:middle;">
										 '.$phd_amount.''.$unitName.'</td><td align="center" style="vertical-align:middle;"><b> اضافه شد </b>
										';
										$html = '<div id="bPrdC_'.$billRowId.'" ><span onclick=""> '.$out.' <span style="cursor:pointer;color:red;size:20%;style="vertical-align:middle;" onclick="delAProdFromBill(\'\', \''.$billRowId.'\', \''.$_SESSION['shomarePishHavale'].'\')" ><img src="images/delete.PNG" width="20" height="20" title="حذف" onmouseOver="this.src=\'images/delete.PNG\'" onmouseOut="this.src=\'images/delete.PNG\'"></img></span></></div></tr>
										<tr><td colspan="8"><hr></td></tr></table>';
										
										
										$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$html;
			

	
	
	
}
function addAProd2Bill_H(){
//	print_r($_REQUEST);

	$status = isset($_REQUEST['status']) ? $_REQUEST['status'] : 0;
	$p_code = isset($_REQUEST['p_code']) ? $_REQUEST['p_code'] : 0;
	
	$phd_name = $_REQUEST['phd_name'];
	$phd_amount_remined = $_REQUEST['phd_amount_remined'];
	  
//code kala zakhire mishavad
	$phd_pid = isset($_REQUEST['phd_code']) ? $_REQUEST['phd_code'] :'';
	$phd_price_code=$_REQUEST['phd_price_code'];
	$phd_amount=$_REQUEST['phd_amount'];
	$phd_l_id=$_REQUEST['phd_l_id'];
	$phd_l_name=$_REQUEST['phd_l_name'];
	$phd_deli_name=$_REQUEST['phd_deli_name'];
	$phd_deli_with=$_REQUEST['phd_deli_with'];
	
	$jdate=$cm_req_date;
	$jdate .= '/\/';
	list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
	list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
	$cm_req_date = $gyear."-".$gmonth."-".$gday;
    $phd_amount=str_replace(",","",$phd_amount);
    $phd_amount_remined=str_replace(",","",$phd_amount_remined);
	$queryp="select * from dm_product product
				left join dm_price price
				on product.p_id=price.price_p_id
		          WHERE p_code=".$p_code."

		          
		          
		          ";
	         
	$lnkp=mysql_query($queryp);
	$rowp = mysql_fetch_assoc($lnkp);
	
	$TheTime = time();
	$TimeZone = 3.5;
	$TheTime += $TimeZone * 3600;
	$StrTime = gmdate( "Y-M-d");
	
	
	$queryk="select * from dm_product product
				left join dm_price price
				on product.p_id=price.price_p_id
			 WHERE p_code=".$phd_pid." AND p_price_code=".$phd_price_code."
			 AND
			price_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
			 
			 ";
//	print $queryk;
		$lnk1 = mysql_query("dm_product product
				left join dm_price price
				on product.p_id=price.price_p_id
			 WHERE p_code=".$phd_pid." AND p_price_code=".$phd_price_code."
			 AND  price_id_province=".$_SESSION['dm_user_profile']['u_province_id']."");
		$row1 = mysql_fetch_assoc($lnk1);
		$phd_price=$row1['p_unit']*$phd_amount;

		$querych="SELECT * FROM dm_charge_factors WHERE ch_code_good=".$phd_pid;
	//	print $querych;
		$lnkch = mysql_query($querych);
		$rowch = mysql_fetch_assoc($lnkch);
		
	
		if(mysql_num_rows($lnkch)>0){
			
			$queryL="SELECT * FROM dm_location_goods WHERE l_id=".$phd_l_id." AND l_id_province=".$_SESSION['dm_user_profile']['u_province_id']." ";
			print $queryL;
			$lnkL = mysql_query($queryL);
		    $rowL = mysql_fetch_assoc($lnkL);
		    $phd_price  =($rowL['l_distance']*$rowch['ch_ratio'])+$phd_price;
			
		}
		 
if($_SESSION['dm_user_profile']['u_year_id']==100)
				{
					$year_id=$_SESSION['dm_user_profile']['year_id'];
					
				}else{
					
					$year_id=$_SESSION['dm_user_profile']['u_year_id'];
				}
	$query = array(
		'phd_ph_code' => $_SESSION['shomarePishHavale'],
		'phd_amount_remined' => $phd_amount_remined,
        'phd_pid' => $phd_pid,
        'phd_price_code' => $phd_price_code,
        'phd_l_id' => $phd_l_id,
        'phd_l_name' => $phd_l_name,
        'phd_deli_with' => $phd_deli_with ,
	    'phd_deli_name' => $phd_deli_name, 
        'phd_amount' => $phd_amount,
	    'phd_reg_date'=> gmdate('Y-m-d'),
	    'phd_price' => $phd_price,
		'phd_id_province' =>$_SESSION['dm_user_profile']['u_province_id'],
		'phd_id_year' =>$year_id,
	     'phd_u_id' =>$_SESSION['dm_user_profile']['u_id'],	
	);
	$query = inserterQMaker('dm_pish_havale_det', $query);
	$inx++;
	
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
	$billRowId = mysql_insert_id();
	
	$out='<table  align="center" width=70% bgcolor=#66CCCC ><tr ><td style="color:red;size:20%;"><b>-</b></font></td><td align="center"><b> كالايي با نام :</b></td><td align="center">'.$phd_name.'</td><td align="center"><b> با كد قيمت:</b></td><td align="center">'.$phd_price_code.'</td>
	<td align="center"><b>به مقدار:</b> </td><td align="center">
	 '.$phd_amount.'</td><td align="center"><b> اضافه شد </b>
	';
	$html = '<div id="bPrdC_'.$billRowId.'" ><span onclick=""> '.$out.' <span style="cursor:pointer;color:red;size:20%;" onclick="delAProdFromBill(\'\', \''.$billRowId.'\', \''.$_SESSION['shomarePishHavale'].'\')" ><b>X</b></span></></div></tr>
	<tr><td colspan="8"><hr></td></tr></table>';
	$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$html.';';
	if(($row1['p_category']==7) and  ($row1['p_code']!=50) and  ($row1['p_code']!=51) and  ($row1['p_code']!=54)){
	$html .= '<div id="bPrdC1_'.$billRowId.'" ><span onclick="">  <span style="cursor:pointer" onclick="addPdetFromBill(\'\', \''.$billRowId.'\', \''.$_SESSION['shomarePishHavale'].'\')" >اضافه کردن جزییات</span></></div></tr>
	<tr><td colspan="8"><hr></td></tr></table>';}
	return $billRowId;	
}
function addAProd2Bill1(){
//	print_r($_REQUEST);

	$status = isset($_REQUEST['status']) ? $_REQUEST['status'] : 0;
	$ph_customer_code=$_REQUEST['ph_customer_code'];
	$ph_customer_type=$_REQUEST['ph_customer_type'];
	$phd_name = $_REQUEST['phd_name'];
	$phd_amount_remined = $_REQUEST['phd_amount_remined'];  
	$phd_pid = $_REQUEST['phd_pid']; 
	$phd_price_code=$_REQUEST['phd_price_code'];
	$phd_amount=$_REQUEST['phd_amount'];
	$phd_l_code=$_REQUEST['phd_l_code'];
	$phd_l_name=$_REQUEST['phd_l_name'];
	$phd_deli_name=$_REQUEST['phd_deli_name'];
	$phd_deli_with=$_REQUEST['phd_deli_with'];
	$cm_req_num=$_REQUEST['cm_req_num'];
	$cm_req_date=$_REQUEST['cm_req_date'];
    $ph_code=$_SESSION['ph_code'];
    $ph_mojavez=$_SESSION['ph_mojavez'];
 
 //   echo $phd_pid;
	
	$TheTime = time();
	$TimeZone = 3.5;
	$TheTime += $TimeZone * 3600;
	$StrTime = gmdate( "Y-M-d");

	if($status==0){
	
		$lnk1 = mysql_query("select * from dm_product product
				left join dm_price price
				on product.p_id=price.price_p_id
					 WHERE p_id=".$phd_pid."
				  AND phd_price_code=".$phd_price_code."
				  AND
				   price_id_province=".$_SESSION['dm_user_profile']['u_province_id'].
				  "");
		$row1 = mysql_fetch_assoc($lnk1);
		$phd_price=$row1['p_sellprice']*$phd_amount;
		$phd_priceh=$row1['p_sellpriceh']*$phd_amount;
	}
		
if($_SESSION['dm_user_profile']['u_year_id']==100)
				{
					$year_id=$_SESSION['dm_user_profile']['year_id'];
					
				}else{
					
					$year_id=$_SESSION['dm_user_profile']['u_year_id'];
				}
	$query = array(
		'phd_ph_code' => $ph_code,
		'phd_amount_remined' => $phd_amount_remined,
        'phd_pid' => $phd_pid,
        'phd_price_code' => $phd_price_code,
        'phd_l_code' => $phd_l_code,
        'phd_l_name' => $phd_l_name,
        'phd_deli_with' => $phd_deli_with ,
	    'phd_deli_name' => $phd_deli_name, 
        'phd_amount' => $phd_amount,
     	'phd_reg_date'=> gmdate('Y-m-d'),
	    'phd_price' => $phd_price,
	    'phd_p_price' => $row1['p_sellprice'],
	    'phd_p_priceh' => $row1['p_sellpriceh'],
	    'phd_priceh' => $phd_priceh,
	    'phd_id_province' =>$_SESSION['dm_user_profile']['u_province_id'],
	    'phd_id_year' =>$year_id,
	    'phd_u_id' =>$_SESSION['dm_user_profile']['u_id'],
	);

	$query = inserterQMaker('dm_pish_havale_det', $query);
	$inx++;
	
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
	$billRowId = mysql_insert_id();
	
	$out='<table  align="center" width=70% bgcolor=#000000 ><tr ><td style="height:40px;vertica-align:middle;"><img src="images/pic.bmp" width="20" height="20"></img></td><td>  كالايي به نام   :</td><td><b>'.$phd_name.'</td><td>با كد قيمت</td><td>'.$phd_price_id.'</td>
	<td>  به مقدار </td><td>
	 '.$phd_amount.'</td><td></b>'.$phd_price.' به كالاهاي شما اضافه شد
	</td>';
	$html = '<div id="bPrdC_'.$billRowId.'" ><span onclick=""> '.$out.' <span style="cursor:pointer" onclick="delAProdFromBill(\'\', \''.$billRowId.'\', \''.$_SESSION['shomarePishHavale'].'\')" ><img src="images/delete.PNG" width="20" height="20"></img></span></></div></tr>
	<tr><td colspan="8"><hr></td></tr></table>';
	if($row1['p_category']==7){
	$html .= '<div id="bPrdC1_'.$billRowId.'" ><span onclick="">  <span style="cursor:pointer" onclick="addPdetFromBill(\'\', \''.$billRowId.'\', \''.$_SESSION['shomarePishHavale'].'\')" >اضافه کردن جزییات</span></></div></tr>
	<tr><td colspan="8"><hr></td></tr></table>';}
	$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$html;
	return $billRowId;	
}
function EbtalM(){
	
  $pf_id = isset($_REQUEST['pf_id']) ? $_REQUEST['pf_id'] : '';
  $query = "
		UPDATE dm_pish_factor 
		SET 			
			`pf_type_m` = '". 1 ."'			
		WHERE 
			pf_id = '".$pf_id."'
			";       						
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
	$row=mysql_fetch_assoc($lnk);
	
	//update mojavez
	
$queryph="SELECT * FROM dm_pish_havale 
						             WHERE 
						                ph_code=".$row['pf_ph_code']."
						                and
						                ph_id_province=".$rowphd['phd_id_province']."";

						                				        		           
							$lnkph=mysql_query($queryph);								
							$rowph = mysql_fetch_assoc($lnkph);
							$ph_phm_id=$rowph['ph_phm_id'];

							
							$queryphd="SELECT sum(phd_amount)as phd_amount FROM dm_pish_havale_det 
						             WHERE 
						                phd_ph_code=".$row['pf_ph_code']."
						                and
						                phd_id_province=".$rowphd['phd_id_province']."";

						                				        		           
							$lnkphd=mysql_query($queryphd);								
							$rowphd = mysql_fetch_assoc($lnkphd);
							

   $querymm="SELECT * FROM dm_op_mojavez WHERE phm_id=".$ph_phm_id."  ";
	 
				//	print $querych;
					$lnkmm = mysql_query($querymm);
					$rowmm = mysql_fetch_assoc($lnkmm);
					//print $querymm;
	$phm_amount=($rowmm['phm_amount']+$rowphd['phd_amount']);
	$phm_amountes=($rowmm['phm_amountes']-$rowphd['phd_amount']);
	$queryphm = "
		UPDATE dm_op_mojavez 
		SET 
			  			 
			`phm_amount` = '".$phm_amount."',
			`phm_amountes` = '".$phm_amountes."'   			
								 
		WHERE 
			phm_id = ".$ph_phm_id." 	";
			
	$lnkphm = mysql_query($queryphm);
print ($queryphm);
if(mysql_error()) print mysql_error();	
	
	
//ta enja update mojavez	
	
	
	
	
	
	$query1="SELECT MAX(ebm_code) maxId FROM dm_ebtal_m 
						          WHERE
						            ebm_id_province=".$_SESSION['dm_user_profile']['u_province_id']."";	         			
								  								 
						$lnk1=mysql_query($query1);
///			print $query;
						print mysql_error();
						$row1=mysql_fetch_assoc($lnk1);
						$ebm_code=$row1['maxId'];
						$ebm_code=$ebm_code+1;
	
	 $query = array(
					'ebm_code' => $ebm_code,
					'ebm_reg_date' => gmdate('Y-m-d'), 
					'ebm_pf_id' => $pf_id,						       
		            'ebm_id_province' => $_SESSION['dm_user_profile']['u_province_id'],
		            'ebm_id_year' => $_SESSION['dm_user_profile']['u_year_id'],
		            'ebm_u_id' => $_SESSION['dm_user_profile']['u_id'],
						);
					
						$query = inserterQMaker('dm_ebtal_m', $query);
						print $query;
						$lnk = mysql_query($query);
						if(mysql_error()) print mysql_error();
						$ebm_id = mysql_insert_id();
	
  $GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$pf_id.';'.$ebm_id.';';	
}

function addDocument2Pf(){
	
    $ph_code = isset($_REQUEST['ph_code']) ? $_REQUEST['ph_code'] : '';
//	$ph_code= $_SESSION['ph_code_d'];
	$dpf_num=$_REQUEST['dpf_num'];
	$dpf_account  = $_REQUEST['dpf_account'];
	$dpf_type  = $_REQUEST['dpf_type'];
	$dpf_sarresid  = $_REQUEST['dpf_sarresid'];  
	$dpf_price  = $_REQUEST['dpf_price']; 
	$dpf_d_id  = $_REQUEST['dpf_d_id']; 
	$d_code  = $_REQUEST['d_code']; 
	$DocType  = $_REQUEST['DocType'];
	$dpf_bank  = $_REQUEST['dpf_bank'];	
	$dpf_branch  = $_REQUEST['dpf_branch'];	
	$total_price = isset($_REQUEST['total_price']) ? $_REQUEST['total_price'] : '';
	
	$dpf_price=str_replace(",","",$dpf_price);
		
//	echo $dpf_price;
	$queryp = "SELECT * FROM dm_pish_factor WHERE pf_ph_code=".$ph_code." 
			       AND 
			           pf_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
		          
			           AND
					   pf_type=". 0 ." ";			                   
		$lnkp = mysql_query($queryp);		
print $queryp;	
		if(mysql_num_rows($lnkp)>0){
			$rowp=mysql_fetch_assoc($lnkp);
			$status=1;
				}else{
			$status=2;
			$message='ابتدا پيش فاكتور را ثبت كنيد';
		}
				
	$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$status;
}
function addDocument2PfSave(){
	
	
//debugging	
$query = "
			 SELECT *  FROM dm_pish_havale_det 			 
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
								`phd_p_price` = ".$rowp['p_sellprice']." ,
								`phd_price` = '".$phd_priceh."',
								`phd_p_price` = ".$rowp['p_sellpriceh']." 			 
								
													 
							WHERE 
								phd_id_province = ".$_SESSION['dm_user_profile']['u_province_id']." 
                             AND
							 
							     phd_id=".$row['phd_id']."";
	
						$lnk = mysql_query($query);
					
								
				}
				                          }
	
		
//	
	
	$ph_code = isset($_REQUEST['ph_code']) ? $_REQUEST['ph_code'] : '';
//	$ph_code= $_SESSION['ph_code_d'];
	$dpf_num=$_REQUEST['dpf_num'];
	$dpf_account  = $_REQUEST['dpf_account'];
	$dpf_sarresid  = $_REQUEST['dpf_sarresid'];  
	$dpf_price  = $_REQUEST['dpf_price']; 
	$dpf_d_id  = $_REQUEST['dpf_d_id'];
	$dpf_type  = $_REQUEST['dpf_type'];  
	$d_code  = $_REQUEST['d_code']; 
	$DocType  = $_REQUEST['DocType'];	
	$total_price = isset($_REQUEST['total_price']) ? $_REQUEST['total_price'] : '';
	$dpf_bank  = $_REQUEST['dpf_bank']; 
	$dpf_branch  = $_REQUEST['dpf_branch']; 
	$dpf_prov_sanad  = $_REQUEST['dpf_prov_sanad']; 
	
	
	$dpf_price=str_replace(",","",$dpf_price);
		

	 $querydpf = "SELECT * FROM dm_pf_document WHERE dpf_num=".$dpf_num."" ;	
    	 $lnkdpf = mysql_query($querydpf);
    	echo $querydpf;
    	
    	 if(mysql_num_rows($lnkdpf)>0){
    	 	echo 'sabti';
    	 	
    	 	$status=0;
    	 	
    	                 	$out='
						       <table  align="center" width=70% bgcolor=#BBF0F7 >
								<tr ><td >این شماره فیش قبلا ثبت شده است.</td>
								     ';
    	 	
    	 	$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$out;	
    	 	
    	 }else{
	
	    	 	echo 'not sabti';
    	 
	
	
				
	   $query1 = "SELECT * FROM dm_pish_factor WHERE pf_ph_code=".$ph_code." 
				   AND
				        pf_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
				    AND
				        pf_id_year=".$_SESSION['dm_user_profile']['u_year_id']."
				     AND
				        pf_type=". 0 ." " ;   

    	
    	 $lnk1 = mysql_query($query1);
    	 $row1=mysql_fetch_assoc($lnk1);

if($_SESSION['dm_user_profile']['u_year_id']==100)
				{
					$year_id=$_SESSION['dm_user_profile']['year_id'];
					
				}else{
					
					$year_id=$_SESSION['dm_user_profile']['u_year_id'];
				}
					      $pf_code =$row1['pf_code'];
						     $query = array(
									'dpf_pf_code' => $pf_code,
									'dpf_d_id' => $dpf_d_id,
									'dpf_num' => $dpf_num,
							        'dpf_account' => $dpf_account,
							        'dpf_sarresid' => $dpf_sarresid,
							        'dpf_price' => $dpf_price,
						            'dpf_type' => $dpf_type,
						            'dpf_id_province' => $_SESSION['dm_user_profile']['u_province_id'],
						            'dpf_id_year' => $year_id,
						            'dpf_bank' => $dpf_bank,
						            'dpf_branch' => $dpf_branch,
						            'dpf_prov_sanad' => $dpf_prov_sanad,
						            'dpf_u_id' => $_SESSION['dm_user_profile']['u_id'],
						                  );
					
						$query = inserterQMaker('dm_pf_document', $query);
						print $query;
						$lnk = mysql_query($query);
						if(mysql_error()) print mysql_error();
						$DocId = mysql_insert_id();
//add price check
			    $querypish = "
				 	SELECT *  FROM dm_pish_factor 
			 
					WHERE 
						pf_code = '".$pf_code."'
                    AND
                       pf_id_province='".$_SESSION['dm_user_profile']['u_province_id']."'
                    AND
                       pf_id_year='".$_SESSION['dm_user_profile']['u_year_id']."'
                       AND
						    pf_type=". 0 ."
						";		

    			$lnkpish = mysql_query($querypish);
				sqlErr('for price check');
				$rowpish = mysql_fetch_assoc($lnkpish);												
				$pf_price_check	=$rowpish['pf_price_check']+$dpf_price;
//update pf_price_check
$query2 = "
		UPDATE dm_pish_factor 
		SET 
			
			`pf_price_check` = '".$pf_price_check."'			
		WHERE 
			pf_code = '".$pf_code."'
        AND
            pf_id_province='".$_SESSION['dm_user_profile']['u_province_id']."'
        AND
            pf_id_year='".$_SESSION['dm_user_profile']['u_year_id']."'
            
          AND
			  pf_type=". 0 ."  
            ";
						
	$lnk2 = mysql_query($query2);
	if(mysql_error()) print mysql_error();
						
//ta enja						
						$lnk = mysql_query("SELECT * FROM dm_documentk WHERE d_id=".$dpf_d_id);
						$row = mysql_fetch_assoc($lnk);					
						$out='
						       <table  align="center" width=70% bgcolor=#BBF0F7 >
								<tr ><td >&nbsp;</td>
								     <td> سندي با كد:<b>'.$row['d_code'].'</td>
								     <td>با مقدار:</td><td><b>'.$dpf_price.'</b></td>
								     <td> به سند هااضافه شد</td><td>';
						$html = '<div id="Dcntr_'.$DocId.'" ><span onclick=""> '.$out.' <span style="cursor:pointer;color:red;size=20%;" onclick="delADocFromBill(\'\', \''.$DocId.'\')" ><img src="images/delete.PNG" width="20" height="20" title="حذف"  ></img></span></></div></td></tr>
						         <tr><td colspan="8"><hr></td></tr>
					           </table> ';
	
$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$html;	

    	 }
}
function ReportProd(){
	 
	//print_r($_REQUEST);
	$firstDate=$_REQUEST['firstDate'];
	$EndDate=$_REQUEST['EndDate'];
	$firstNumber = $_REQUEST['firstNumber'];
	$EndNumber = $_REQUEST['EndNumber']; 
	$outHtml='<div><table>
	<tr>
		<td>&nbsp</td>
		<td>&nbsp</td>
		<td colspan=2>حواله صادر شده</td>
	</tr>
	<tr>
	   <td> نام كالا</td>
	   <td>واحد</td>
	   <td>مقدار</td>
	   <td>مبلغ</td>
	</tr>';

	$query="SELECT * FROM dm_pish_havale_det WHERE in
	             (SELECT h_pf_code FROM dm_havale WHERE
	             pf_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
	             AND
	                pf_id_year=".$_SESSION['dm_user_profile']['u_year_id']."
	             AND
	                h_id between '.$firstNumber.'AND '.$EndNumber.')
	              
	              AND 
	                h_id_year=".$_SESSION['dm_user_profile']['u_year_id']."
	              "; 
	$lnk = mysql_query($query); 
	  while($report = mysql_fetch_assoc($lnk)){
	  	
	  	$outHtml .='<tr>
	  	</td>'.$report['phd_name'].'</td>
	  	';
	  }                                                            
	 
	$query="SELECT * FROM dm_pish_factor WHERE  pf_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
	AND
		  pf_id_year=".$_SESSION['dm_user_profile']['u_year_id']."  
	       AND pf_pf_id in
	           (SELECT pf_ph_code from dm_pish_factor WHERE pf_id in
	                 (SELECT h_pf_code FROM dm_havale WHERE 
		                      pf_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
		                 AND
		                      pf_id_year=".$_SESSION['dm_user_profile']['u_year_id']."
		                 AND
		                      h_id BETWEEN '.$firstNumber.' AND '.$EndNumber.'))
		                  AND
		                       h_id_year=".$_SESSION['dm_user_profile']['u_year_id']."
		                      ";
	                                                             
	
	$lnk = mysql_query($query);
	while($row = mysql_fetch_assoc($lnk)){
	$outHtml .='<td>'.$row['pf_unit_price'].'</td>
	             </td>'.$report['phd_amount'].'</td>
	             <td>'.$row['pf_price'].'</td>';
	}
	$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$outHtml;		
}
function editopr(){
	
	$ph_code=$_REQUEST['ph_code'];
	$ph_operation_id=$_REQUEST['ph_operation_id'];
	$phm_id=$_REQUEST['phm_id'];
	
	 $querymojavez="SELECT * FROM dm_op_mojavez  opm   
	               left join  dm_operation_acc  op_acc 
	                   on opm.phm_op_id=op_acc.g_id
	               
	               WHERE 
	            	  phm_id=".$phm_id."
	            	  and
	            	   phm_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
	            	  
	            	  "; 
	$lnkmojavez = mysql_query($querymojavez); 
	$rowmojavez = mysql_fetch_assoc($lnkmojavez);
	//print $querymojavez;
	$ph_operation_id=$rowmojavez['g_id'];

	$query = "SELECT * FROM dm_havale h
	          left join dm_pish_factor pf on h.h_pf_code=pf.pf_code
	          left join dm_pish_havale ph on ph.ph_code=pf.pf_ph_code
	          where 
	                   pf_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
		           AND 
			           pf_id_year=".$_SESSION['dm_user_profile']['u_year_id']."   
			       AND
					   pf_type=". 0 ."
				   AND
				       ph_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
		           AND 
			           ph_id_year=".$_SESSION['dm_user_profile']['u_year_id']."   
			       AND 
			           h_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
		           AND 
			           h_id_year=".$_SESSION['dm_user_profile']['u_year_id']." 
			       AND
			           ph_code=".$ph_code."";	
				    
	 		                   
	$lnk = mysql_query($query);	
//	print $query;
		

		if(mysql_num_rows($lnkp)>0){
			?>
		<script>
                 alert('براي اين پيش نويس حواله صادر شده است!!');
		</script>
		<?php 
			
		}
		else{
		
				$query = "
							UPDATE  dm_pish_havale
							SET 
								`ph_operation_id` = '". $ph_operation_id ."',
								`ph_phm_id` = '". $phm_id ."'
								
							
					    WHERE 
							   ph_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
						    AND
						       ph_code=".$ph_code."";	   
		
					$lnk = mysql_query($query);
					if(mysql_error()) print mysql_error();
			//print $query;
			
			$queryphd = "SELECT * FROM dm_pish_havale_det 
	             where 
	                   phd_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
		         AND
			           phd_ph_code=".$ph_code."";	
				// echo $queryphd;                     
	        $lnkphd = mysql_query($queryphd);		
					
			
	        while ($row1 = mysql_fetch_assoc($lnkphd))
	        {
	        	           
					  $queryaf = "SELECT * FROM dm_product product
								left join dm_price price
							    on product.p_id=price.price_p_id
								left join dm_charge_factors chf
								on product.p_code = chf.ch_code_good and price.p_price_code=chf.ch_pricecode_good
								left join dm_opr_ch opr_ch 
								on opr_ch.oph_ch_id=chf.ch_id
								left join dm_operation_acc opr_acc
								on opr_acc.g_id=opr_ch.oph_op_id
								left join dm_loc_ch lch  
								on  lch.chl_ch_id=chf.ch_id
								left join dm_location_goods l on l.l_id=lch.chl_l_id
							WHERE
				          			        oph_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
									AND
										    price_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
								    AND
										   l_id=".$row1['phd_l_id']."
									AND
										    ch_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
								    AND
										   l_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
								    AND
									        p_code=".$row1['phd_pid']." 
									AND    
									        p_price_code=".$row1['phd_price_code']."
								    AND
						                    g_id=".$ph_operation_id."  
						            AND
						                    chl_id_province=".$_SESSION['dm_user_profile']['u_province_id']."    
						            AND          
						                    '".gmdate('Y-m-d')."'   between  `ch_fdate`   AND  `ch_ldate` ";                    				 	
						$lnkaf = mysql_query($queryaf);
				//	print $queryaf;
				$ratio=1;
				
					  if(mysql_num_rows($lnkaf)>0){
					  	
					  	$rowaf= mysql_fetch_assoc($lnkaf);
					  	$ch_dependancy=$rowaf['ch_dependancy'];
						 
						$p_sellpriceh= $rowaf['p_sellprice'] +$rowaf['ch_p_add'];		  	
				
						$phd_priceh=(($ratio )* (($row1['phd_amount'] )* ($p_sellpriceh)) );
						$phd_p_priceh=$p_sellpriceh;
				        $phd_p_price = $rowaf['p_sellprice'];
				        $phd_price=(($ratio )* (($row1['phd_amount'] )* ($rowaf['p_sellprice'])));  
				        $phd_afzodani=1;
				        $phd_p_add = $rowaf['ch_p_add'];	  	
					  }else{

						  	 $queryk="SELECT * FROM dm_product product
									  left join dm_price price
									  on product.p_id=price.price_p_id
								   WHERE p_code=".$row1['phd_pid']." 
								         AND
								            p_price_code=".$row1['phd_price_code']."
									     AND
									      price_id_province=".$_SESSION['dm_user_profile']['u_province_id']."";
								   
								$lnk2 = mysql_query($queryk);
								$row2 = mysql_fetch_assoc($lnk2);
								
					  	$phd_price=(($ratio )* (($row1['phd_amount'] )* ($row2['p_sellprice'])));
						$phd_priceh=(($ratio )* (($row1['phd_amount'] )* ($row2['p_sellprice'])));
				        $phd_p_price=$row2['p_sellprice'];
				        $phd_p_priceh=$row2['p_sellprice'];	  
				        $phd_afzodani=0;	
				        $phd_p_add = 0;
					  }									
	        	     $query = "
							UPDATE  dm_pish_havale_det
							SET 
								`phd_p_price` = '". $phd_p_price ."',
								`phd_p_priceh` = '". $phd_p_priceh ."',
								`phd_price` = '". $phd_price ."',
								`phd_priceh` = '". $phd_priceh ."',
								`phd_p_add` = '". $phd_p_add ."'
					    WHERE 
							   phd_id=".$row1['phd_id']." ";	   
		
					$lnk = mysql_query($query);
					if(mysql_error()) print mysql_error();   
				//	print	 $query;
	        	 $rahnama= '<span style="color:blue;"><span style="color:red;">  *  </span> تغييرات با موفقيت انجام شد  </span>  ';
    echo $rahnama;
	        }
			
			
		}
	

	
}
function addedprod(){
	
	$out='<table align=right>
	<tr>
	      <td><font color="red"><b>
	      اطلاعات شما با موفقيت ثبت شد
	      </b></font></td>
	      </td>
	</table>
	';
	echo $out;
		
 }
 function addPdetFromBill(){
	
//	print_r($_REQUEST);
	$phd_id = $_REQUEST['phd_id'];
	$ph_code = $_REQUEST['ph_code'];
	
	

	$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$phd_id.';'.$ph_code.';';
	
}
	
function delAProdFromBill(){
	
//	print_r($_REQUEST);
	$phd_id = $_REQUEST['phd_id'];
	$ph_code = $_REQUEST['ph_code'];
	
	//delete detail
	$queryphd = "
		select * FROM dm_pish_havale_det
	 
			WHERE 
				phd_id = ".$phd_id."		    
		";
		$lnkphd = mysql_query($queryphd);
	   $rowphd = mysql_fetch_assoc($lnkphd);
	   $phd_amount=$rowphd['phd_amount'];
	   
	   
	$queryph = "
		select * FROM dm_pish_havale
	 
			WHERE 
				ph_code = ".$ph_code." 
				
			AND
			   ph_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
		    
		";
		$lnkph = mysql_query($queryph);
	   $rowph = mysql_fetch_assoc($lnkph);
	
			$querymm="SELECT * FROM dm_op_mojavez WHERE phm_id=".$rowph['ph_phm_id']." ";
					           
										
									//	print $querych;
										$lnkmm = mysql_query($querymm);
										$rowmm = mysql_fetch_assoc($lnkmm);
			$phm_amounti=($rowmm['phm_amount']+$phd_amount);
			$phm_amountes=($rowmm['phm_amountes']-$phd_amount);
			$queryphm = "
				UPDATE dm_op_mojavez 
				SET 
					  			 
					`phm_amount` = '".$phm_amounti."',
					`phm_amountes` = '".$phm_amountes."'   			
										 
				WHERE 
					phm_id = ".$rowph['ph_phm_id']." 	";
					
			$lnkphm = mysql_query($queryphm);
	
	echo $queryphm;
	echo '1923';
	
$query = "
	DELETE FROM   dm_pish_havale_det
 
		WHERE 
			phd_id = ".$phd_id.""; 
	
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
	
	$querydet = "
	DELETE FROM   dm_anbar_det
 
		WHERE 
			dad_phd_id = ".$phd_id.""; 
	
	$lnkdet = mysql_query($querydet);
	if(mysql_error()) print mysql_error();
	
	$lnk1 = mysql_query("SELECT * FROM dm_anbar_det where dad_phd_id=".$phd_id."");
          
		while($row1=mysql_fetch_assoc($lnk1)){
			
			$lnk2 = mysql_query("SELECT * FROM mojody_kala where id=".$row1['dad_anbar_id']."");
			$row2=mysql_fetch_assoc($lnk2);
			
			if($row1['dad_no']==8){
				
				$meghdar=$row1['dad_tedad']+$row2['tedad_sold'];
				
				 $queryanbari = "
									UPDATE mojody_kala 
										SET 			
										
											
											`tedad_sold`  = '".$meghdar."'			
										WHERE 
											  id=".$row1['dad_anbar_id']."
									    
										";       						
								$lnkanbari = mysql_query($queryanbari);
				
				
				
			}else{
				
				if(($rowphd['phd_pid']==50) or ($rowphd['phd_pid']==54)){
					
					$meghdar=$row1['dad_tedad']+$row2['tedad_sold'];
			     	$queryanbari = "
									UPDATE mojody_kala 
										SET 			
										
											
											`tedad_sold`  = '".$meghdar."'			
										WHERE 
											  id=".$row1['dad_anbar_id']."
									    
										";       						
								$lnkanbari = mysql_query($queryanbari);
					
				}else{
				
				$meghdar=$row1['dad_vazn_kh']+$row2['khales_sold'];
				
				
				 $queryanbari = "
								UPDATE mojody_kala 
									SET 			
									
										`khales_sold` = '". $meghdar ."'			
									WHERE 
										  id=".$row1['dad_anbar_id']."
								    
									";       						
							$lnkanbari = mysql_query($queryanbari);
				
				}	
				
			}
			
			
			$querydd = "DELETE FROM dm_anbar_det
	 
			WHERE 
				dad_phd_id = ".$phd_id." 
				
		";
		$lnkdd = mysql_query($querydd);
		if(mysql_error()) print mysql_error();		
			
			
			
			
			
			
		}
	
	
	
	
	
	
	
	
	$query = "
		DELETE FROM dm_pish_havale_det
	 
			WHERE 
				phd_id = ".$phd_id." 
				
			AND
			   phd_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
		    AND
			   phd_id_year=".$_SESSION['dm_user_profile']['u_year_id']."
		";
		$lnk = mysql_query($query);
		if(mysql_error()) print mysql_error();	
		
		$querydet = "
				DELETE FROM   dm_anbar_det
			 
					WHERE 
						dad_phd_id = ".$phd_id.""; 
				
				$lnkdet = mysql_query($querydet);
				if(mysql_error()) print mysql_error();
		
		$query = "
		SELECT * FROM dm_pish_havale_det
	 
			WHERE 
				phd_ph_code = ".$ph_code." 
			AND
			   phd_tdactive=". 0 ."
			AND
			   phd_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
		    AND
			   phd_id_year=".$_SESSION['dm_user_profile']['u_year_id']."
		";
		$lnk = mysql_query($query);
		if(mysql_num_rows($lnk)>0){
			
		$status='hast';
		}
		else{
				$query = "
		DELETE FROM dm_pish_havale
	 
			WHERE 
				ph_code = ".$ph_code." 
			AND
			   ph_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
		    AND
			  ph_id_year=".$_SESSION['dm_user_profile']['u_year_id']."
		";
		$lnk = mysql_query($query);
		if(mysql_error()) print mysql_error();	
		
			$_SESSION['shomarePishHavale'] ='';
		
			$status='nist';
		}
	$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$phd_id.';'.$status.';';
	
}

function delADocFromBill(){
	
	print_r($_REQUEST);
	$dpf_id = $_REQUEST['dpf_id'];
	
	$query = "
		DELETE FROM dm_pf_document
	 
			WHERE 
				dpf_id = ".$dpf_id." 
		";
		$lnk = mysql_query($query);
		if(mysql_error()) print mysql_error();
	
	$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$dpf_id;
}

function DeletePHavale(){

	//print_r($_REQUEST);	
	$ph_id = $_REQUEST['ph_id'];
	$query="SELECT * FROM dm_pish_havale
	 
			WHERE 
			 ph_id = ".$ph_id." ";
	
	$lnk = mysql_query($query);
	$row = mysql_fetch_assoc($lnk);
    $ph_code=$row['ph_code'];
    $ph_phm_id=$row['ph_phm_id'];
    
	$queryd="SELECT * FROM dm_havale h
	           left join dm_pish_factor pf
	            on h.h_pf_code=pf.pf_code
	            left join dm_pish_havale ph
	            on pf.pf_ph_code=ph.ph_code
	 
			WHERE 
				ph_code = ".$ph_code." 
			AND	 
			    ph_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
			AND
			    ph_id_year=".$_SESSION['dm_user_profile']['u_year_id']."
		    AND 
			    pf_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
			AND
			    pf_id_year=".$_SESSION['dm_user_profile']['u_year_id']."
		    AND 
			    h_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
			AND
			    h_id_year=".$_SESSION['dm_user_profile']['u_year_id']."	";		
			$lnkd = mysql_query($queryd);
			print $queryd;
	if(mysql_num_rows($lnkd)>0){
	$status=1;
	$message='شما نميتوانيد حذف كنيد چون حواله اي براي اين پيش نويس زدم شده';
	//yani havale zade shode
	
	}else
	{
		$status=0;
	$message='پيش نويس و پيش فاكتور اين پيش نويس حذف شد!';	
				$query = "
					DELETE FROM dm_pish_havale
				 
						WHERE 
							ph_id = ".$ph_id." 
					AND
					        ph_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
					 AND
					        ph_id_year=".$_SESSION['dm_user_profile']['u_year_id']."";
					
					$lnk = mysql_query($query);
					if(mysql_error()) print mysql_error();
				$query = "
					DELETE FROM dm_pish_factor
				 
						WHERE 
							pf_ph_code = ".$ph_code." 
					AND
					        pf_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
					 AND
					        pf_id_year=".$_SESSION['dm_user_profile']['u_year_id']."";
					
					$lnk = mysql_query($query);
					print $query;
					if(mysql_error()) print mysql_error();
						
					$queryd="SELECT * FROM dm_pish_havale_det
				 
							WHERE 
								phd_ph_code = ".$ph_code." 	
							AND 
							  phd_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
							AND
							  phd_id_year=".$_SESSION['dm_user_profile']['u_year_id']."	";
	
				//	print $query;
					$lnkd = mysql_query($queryd);
					while($rowd = mysql_fetch_assoc($lnkd)){
						$phd_id=$rowd['phd_id'];
						 
					$querymm="SELECT * FROM dm_op_mojavez WHERE phm_id=".$ph_phm_id."  ";
          
					print $querych;
					$lnkmm = mysql_query($querymm);
					$rowmm = mysql_fetch_assoc($lnkmm);
				echo 	$rowmm['phm_amount'];
				echo '/';
				echo $rowd['phd_amount'];
				echo '/';
				echo $rowmm['phm_amountes'];
					
	$phm_amount=($rowmm['phm_amount']+$rowd['phd_amount']);
	$phm_amountes=($rowmm['phm_amountes']-$rowd['phd_amount']);	
						
					$queryphm = "
							UPDATE dm_op_mojavez 
							SET 
								  			 
								`phm_amount` = '".$phm_amount."',
								`phm_amountes` = '".$phm_amountes."'   			
													 
							WHERE 
								phm_id = ".$ph_phm_id." 	";
								
						$lnkphm = mysql_query($queryphm);
					print ($queryphm);
					//echo '2220';
					if(mysql_error()) print mysql_error();		
			//hazf detail anabr	
					
					
					
				$lnk1 = mysql_query("SELECT * FROM dm_anbar_det where dad_phd_id=".$phd_id."");	
					
						while($row1=mysql_fetch_assoc($lnk1)){
			
			$lnk2 = mysql_query("SELECT * FROM mojody_kala where id=".$row1['dad_anbar_id']."");
			$row2=mysql_fetch_assoc($lnk2);
			
			if($row1['dad_no']==8){
				
				$meghdar=$row1['dad_tedad']+$row2['tedad_sold'];
				
				 $queryanbari = "
									UPDATE mojody_kala 
										SET 			
										
											
											`tedad_sold`  = '".$meghdar."'			
										WHERE 
											  id=".$row1['dad_anbar_id']."
									    
										";       						
								$lnkanbari = mysql_query($queryanbari);
				
				
				
			}else{
				if(($rowd['phd_pid']==50) or ($rowd['phd_pid']==54)){
					
					$meghdar=$row1['dad_tedad']+$row2['tedad_sold'];
				
				 $queryanbari = "
									UPDATE meat.mojody_kala 
										SET 			
										
											
											`tedad_sold`  = '".$meghdar."'			
										WHERE 
											  id=".$row1['dad_anbar_id']."
									    
										";       						
								$lnkanbari = mysql_query($queryanbari);
					
				}else{
				$meghdar=$row1['dad_vazn_kh']+$row2['khales_sold'];
				
				
				 $queryanbari = "
								UPDATE meat.mojody_kala 
									SET 			
									
										`khales_sold` = '". $meghdar ."'			
									WHERE 
										  id=".$row1['dad_anbar_id']."								    
									";       						
							$lnkanbari = mysql_query($queryanbari);
				
				}
				
			}
			
			
			
			
			
			
		}
					
		$querypo = "
			select *  FROM dm_pish_havale_det
		 
				WHERE 
					phd_ph_code = ".$ph_code." 
					
				AND
				  phd_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
			 AND
				  phd_id_year=".$_SESSION['dm_user_profile']['u_year_id']."";
			
			$lnkpo = mysql_query($querypo);
					
			$rowpo=mysql_fetch_assoc($lnkpo);	

			$querydet = "
			DELETE FROM   dm_anbar_det
		 
				WHERE 
					dad_phd_id = ".$rowpo['phd_id'].""; 
	
			$lnkdet = mysql_query($querydet);
			if(mysql_error()) print mysql_error();
					
	$query = "
			DELETE FROM dm_pish_havale_det
		 
				WHERE 
					phd_ph_code = ".$ph_code." 
					
				AND
				  phd_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
			 AND
				  phd_id_year=".$_SESSION['dm_user_profile']['u_year_id']."
			";
			$lnk = mysql_query($query);
			sqlErr('deletephavale');				
					
	
			
					
					
					
					}
	}
	$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$ph_id.';'.$status.';'.$message.';';
	
}
function  passparent(){
 	$code = $_REQUEST['code'];
 
 	
 	$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'. $code ;
 }
 function  passparentcus(){
 	
 	$codecus = $_REQUEST['codecus'];
 	
 	
 	$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'. $codecus ;
 	
 }function passparentprod(){
 	
 	$codeprod = $_REQUEST['codeprod'];
 	$pricecode = $_REQUEST['pricecode'];
 	
 	
 	$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'. $codeprod.';'.$pricecode.' ;';
 	
 }
function DeleteHavale(){
	
	print_r($_REQUEST);	
	$h_id = $_REQUEST['h_id'];
	
	$query = "
		DELETE FROM dm_havale
	 
			WHERE 
				h_id = ".$h_id." 
			AND
			   h_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
		    AND
			  h_id_year=".$_SESSION['dm_user_profile']['u_year_id']."
		";
		$lnk = mysql_query($query);
		if(mysql_error()) print mysql_error();
		
	$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$h_id;
	
}
function Deletefactor(){
	
	print_r($_REQUEST);	
	$f_id = $_REQUEST['f_id'];
	
	$query = "
		DELETE FROM dm_factor
	 
			WHERE 
				f_id = ".$f_id." 
			AND
			    f_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
			AND
			  f_id_year=".$_SESSION['dm_user_profile']['u_year_id']."
		";
		$lnk = mysql_query($query);
		if(mysql_error()) print mysql_error();
		
	$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$f_id;
	
}
function addMoarefinameh(){
	
	$ph_code=$_REQUEST['ph_code'];
	$totalprice=$_REQUEST['totalprice'];
//	$pf_code=$_REQUEST['pf_code'];
//debugging

$query = "
			 SELECT *  FROM dm_pish_havale_det 			 
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
						
						
						
						//l-id
		$queryl="SELECT * FROM dm_location_goods
	          WHERE
	            l_id_province=".$_SESSION['dm_user_profile']['u_province_id']."	         			
		 		
		AND
			l_id=".$row['phd_l_id']."";
		
	         
    
	$lnkl=mysql_query($queryl);
	print mysql_error();
	$rowl=mysql_fetch_assoc($lnkl);
						
										
					
								
				}
				                          }
	
//debugging	
		
	$query="SELECT * FROM dm_pish_factor 
	          WHERE
	            pf_id_province=".$_SESSION['dm_user_profile']['u_province_id']."	         			
		 AND
				pf_id_year=".$_SESSION['dm_user_profile']['u_year_id']."				
		AND
			pf_ph_code=".$ph_code."
		AND
			pf_type=". 1 ."
	         ";
    
	$lnk=mysql_query($query);
	print $query;
	print mysql_error();
	$row=mysql_fetch_assoc($lnk);
				if(mysql_num_rows($lnk)>0){	
					$status=2;
					$alert='براي اين پيش نويس حواله قبلا معرفي نامه ثبت شده است';
				}else if($rowl['l_type']!=0){
					
					$status=3;
					$alert='محل تحویل باید از نوع معرفی نامه باشد';
					
				}else{
							$status=1;	
							
					 $querym="SELECT * FROM dm_pish_factor 
						WHERE
						pf_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
						 AND 
						 pf_id_year=".$_SESSION['dm_user_profile']['u_year_id']."
						 and 
						 pf_type= 1
					  ";
				//	print $querym;
				  
					$lnkm=mysql_query($querym);	
					print mysql_error();
					if(mysql_num_rows($lnkm)==0){
						
						 $query1 = "SELECT * FROM  dm_year where
					            year_status=1 ";	
							$lnk1 = mysql_query($query1);
						//	print $query1;
							$row1= mysql_fetch_assoc($lnk1);
							$year_code=$row1['year_code'];
						$pf_code=$year_code.'000000';
					}else{
									
							
						$query="SELECT MAX(pf_code) maxId FROM dm_pish_factor 
						          WHERE
						            pf_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
								AND
								   pf_type=". 1 ." ";
						        
						$lnk1=mysql_query($query);
					print $query;
						print mysql_error();
						$row1=mysql_fetch_assoc($lnk1);
						$pf_code=$row1['maxId'];
						}
						$pf_code=$pf_code+1;
         $querys = "
			 	SELECT *  FROM dm_signature_g 
		 
				WHERE 
					sig_status = ". 1 ." 
				AND
				   sig_id_province=".$_SESSION['dm_user_profile']['u_province_id']  ."
				
			";
			$lnks = mysql_query($querys);
			$rows= mysql_fetch_assoc($lnks);
				if($_SESSION['dm_user_profile']['u_year_id']==100)
				{
					$year_id=$_SESSION['dm_user_profile']['year_id'];
					
				}else{
					
					$year_id=$_SESSION['dm_user_profile']['u_year_id'];
				}
						
							 $query = "
							INSERT INTO dm_pish_factor 
								(
								
								    `pf_code`,
									`pf_ph_code`, 
									`pf_reg_date`, 
									
									`pf_id_province`,
									`pf_id_year`,
									`pf_u_id`,
									
					                `pf_type`
								)
								
							VALUES
								(
								    '".$pf_code."', 
									'".$ph_code."', 
									'".gmdate('Y-m-d')."', 
									 
								" .$_SESSION['dm_user_profile']['u_province_id']." , 
								" .$year_id." , 
								".$_SESSION['dm_user_profile']['u_id']." , 
								 
							    	" . 1 ."  	
								)
						";
					    $_SESSION['addDoc']='1';
						$lnk = mysql_query($query);
						if(mysql_error()) print mysql_error();
						$_SESSION['shomarePf']=$pf_id = mysql_insert_id();
						$alert='  معرفي نامه  شماره '.$pf_code. 'ثبت شد   ';
							print $query;
							
				}
					
				
	$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$alert;
	
		
	}
	function addPfactor(){
		
//debugging

	$query = "
			 SELECT *  FROM dm_pish_havale_det 			 
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
								`phd_p_price` = ".$rowp['p_sellprice']." , 			 
								`phd_priceh` = '".$phd_priceh."',
								`phd_p_price` = ".$rowp['p_sellpriceh']." 
													 
							WHERE 
								phd_id_province = ".$_SESSION['dm_user_profile']['u_province_id']." 
                             AND
							 
							     phd_id=".$row['phd_id']."";
	
						$lnk = mysql_query($query);
					
								
				}
				                          }
		
		
				   	
	$ph_code=$_REQUEST['ph_code'];
	$totalprice=$_REQUEST['totalprice'];
//	$pf_code=$_REQUEST['pf_code'];
	
    $query = "SELECT * FROM dm_pish_factor WHERE pf_ph_code=".$ph_code." 
            AND
            pf_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
             AND
            pf_id_year=".$_SESSION['dm_user_profile']['u_year_id']."";
            
	
 //   print  $query;
		$lnk = mysql_query($query);
		if(mysql_num_rows($lnk)>0){
		$alert=" براي  پيش حواله شماره $ph_code ،پيش فاكتور قبلا صادر شده است";
		
		}else{
			
					
			
			
			
			
			
						$query="SELECT MAX(pf_code) maxId FROM dm_pish_factor 
						         WHERE
						            pf_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
					            AND
					            pf_type=". 0 ."
						         ";
					    
						$lnk1=mysql_query($query);
					//	print $query;
						print mysql_error();
						$row1=mysql_fetch_assoc($lnk1);
						$pf_code=$row1['maxId'];
						$pf_code=$pf_code+1;
						$querys = "
								 	SELECT *  FROM dm_signature_g 
							 
									WHERE 
										sig_status = ". 1 ." 
									AND
									   sig_id_province=".$_SESSION['dm_user_profile']['u_province_id']  ."
									
								";
								$lnks = mysql_query($querys);
								$rows= mysql_fetch_assoc($lnks);
							if($_SESSION['dm_user_profile']['u_year_id']==100)
									{
										$year_id=$_SESSION['dm_user_profile']['year_id'];
										
									}else{
										
										$year_id=$_SESSION['dm_user_profile']['u_year_id'];
									}
						
						
							 $query = "
							INSERT INTO dm_pish_factor 
								(
								
								    `pf_code`,
									`pf_ph_code`, 
									`pf_reg_date`, 
									`pf_totalprice`,
									`pf_id_year`,
									`pf_u_id`,
									`pf_sig_id`,				
									`pf_id_province`
					
								)
								
							VALUES
								(
								    '".$pf_code."', 
									'".$ph_code."', 
									'".gmdate('Y-m-d')."', 
									'".$totalprice."', 
									'" .$year_id."'  ,
									'" .$_SESSION['dm_user_profile']['u_id']."',
									'" .$rows['sig_id']."',
								    '" .$_SESSION['dm_user_profile']['u_province_id']."'  	
								)
						";
					    $_SESSION['addDoc']='1';
						$lnk = mysql_query($query);
						if(mysql_error()) print mysql_error();
						$_SESSION['shomarePf']=$pf_id = mysql_insert_id();
					//update ph_status	
						$query = "
								UPDATE dm_pish_havale 
								SET 			
									`ph_status` = '". 1 ."' 
												 
							    WHERE 
										ph_code = ".$ph_code." 
							    AND 
									   ph_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
								AND 
									  ph_id_year=".$_SESSION['dm_user_profile']['u_year_id']."";
							
						$lnk = mysql_query($query);
						if(mysql_error()) print mysql_error();
						
						
						
						
						$alert='  پیش فاکتور شماره '.$pf_code. 'ثبت شد   ';
						
						
						
						
						
						
		}
   
	$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$alert;
	
		
	}
function addhavale1(){
	
	 $year_number = jdate('y');
	
	$ph_code=$_REQUEST['ph_code'];
	
	$query = "
		SELECT * FROM dm_pish_factor
			WHERE 
				pf_ph_code = ".$ph_code." 
			AND 
			  pf_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
			AND
		       pf_type=". 0 ."";
		
		$lnk = mysql_query($query);
		print $query;
		if(mysql_num_rows($lnk)<0){
			$out="برای چنین پیش حواله ای پیش فاکتور صادر نشده است";
		}
		else if(mysql_num_rows($lnk)>0){
			$row= mysql_fetch_assoc($lnk);
			$pf_code=$row['pf_code'];
			
			$query = "
		SELECT * FROM dm_havale
	 
			WHERE 
				h_pf_code = ".$pf_code." 
			AND h_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
			AND h_id_year=".$_SESSION['dm_user_profile']['u_year_id']."
			
		";
			print $query;
		$lnk = mysql_query($query);
		$row= mysql_fetch_assoc($lnk);
		$h_code=$row['h_code'];
		if(mysql_num_rows($lnk)>0){
			$out="برای چنین پیش حواله ای قبلا حواله به شماره $h_code صادر شده است";
		}
		else {
			
			
		

				 $queryh="SELECT * FROM dm_havale 
						WHERE
						h_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
						 AND 
						 h_id_year=".$_SESSION['dm_user_profile']['u_year_id']."
					  ";
					
				  
					$lnkh=mysql_query($queryh);	
					print mysql_error();
					if(mysql_num_rows($lnkh)==0){
						$query1 = "SELECT * FROM  dm_year where
						            year_status=1 ";	
								$lnk1 = mysql_query($query1);
							//	print $query1;
								$row1= mysql_fetch_assoc($lnk1);
								$year_code=$row1['year_code'];
						  
					$h_code=$year_code.'000000';
					
					}else{

					$query="SELECT MAX(h_code) maxId FROM dm_havale 
						WHERE
						h_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
						 AND 
						 h_id_year=".$_SESSION['dm_user_profile']['u_year_id']."
					  ";
					
			//	  print $query;  
					$lnk=mysql_query($query);	
					print mysql_error();
					
					$row=mysql_fetch_assoc($lnk);
					$h_code=$row['maxId'];
					}
					$h_code=$h_code+1;
			$querys = "
			 	SELECT *  FROM dm_signature_g 
		 
				WHERE 
					sig_status = ". 1 ." 
				AND
				   sig_id_province=".$_SESSION['dm_user_profile']['u_province_id']  ."
				
			";
			$lnks = mysql_query($querys);
			$rows= mysql_fetch_assoc($lnks);
					
		$IP_address = VisitorIP();
		if($_SESSION['dm_user_profile']['u_year_id']==100)
				{
					$year_id=$_SESSION['dm_user_profile']['year_id'];
					
				}else{
					
					$year_id=$_SESSION['dm_user_profile']['u_year_id'];
				}
			 $query = "
		INSERT INTO dm_havale 
			(
			    `h_code`, 
				`h_pf_code`, 
				`h_reg_date`,
				`h_id_year` ,
				`h_sig_id` ,
				`h_ip_user` ,
				`h_op_code` ,
				`h_id_province`  

			)
			
		VALUES
			(   '".$h_code."',
				'".$pf_code."', 
				'".gmdate('Y-m-d')."',  
				'". $year_id."',
				'". $rows['sig_id']."',
				'". $IP_address ."',
				'". $rowop['g_code']."',
				'". $_SESSION['dm_user_profile']['u_province_id']."' 	
			)
	";
		//	 print $query;
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
	$h_id = mysql_insert_id();
	$out='ثبت شد حواله '.$rowH['maxId'].'';
	
	$query = "
			UPDATE dm_pish_havale_det 
			SET 
				
				`phd_status` = '". 1 ."'			
			 WHERE 
				phd_ph_code = ". $ph_code."
				
				AND
			phd_id_province=". $_SESSION['dm_user_profile']['u_province_id']."
				";				
				$lnk = mysql_query($query);
				if(mysql_error()) print mysql_error();
// print  $query  ;
			
		}
		}
			 
	$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$out;
	
		
	}

function DeletePfactor(){
	
	
	print_r($_REQUEST);	
	$pf_id = $_REQUEST['pf_id'];
	
	$querypf = "
			 	SELECT *  FROM dm_havale h
			 	      left join dm_pish_factor pf
			 	       on h.h_pf_code=pf.pf_code 
				WHERE 
				    pf_id=".$pf_id."
				        AND
				   	pf_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
				        AND
					pf_id_year=".$_SESSION['dm_user_profile']['u_year_id']."
					    AND
			        pf_type=". 0 ."
			            AND
			        h_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
				        AND
					h_id_year=".$_SESSION['dm_user_profile']['u_year_id']."	";
print $querypf;
			$lnkpf = mysql_query($querypf);
			if (mysql_num_rows($lnkpf)>0)
			{
	$status=1;
						$message='براي اين پيش فاكتور حواله زده شده است!';
					
			}else{
				$query = "
						DELETE FROM dm_pish_factor
					 
							WHERE 
								pf_id = ".$pf_id." 
							AND
								pf_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
							AND
								pf_id_year=".$_SESSION['dm_user_profile']['u_year_id']."
								AND
						    pf_type=". 0 ."
						";
						$lnk = mysql_query($query);
						if(mysql_error()) print mysql_error();
						
						sqlErr('deletePfactor');
						$status=0;
						$message='پيش فاكتور حذف شد';
				
			}
	
	$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$pf_id.';'.$status.';'.$message.';';
	
}

function addAPrice2Bill(){
	$_SESSION['ph']=1;
	print_r($_REQUEST);	

//		if($_SESSION['ph']=''){
		$query = array(
			'pf_reg_date' => gmdate('Y-m-d'),
       	 	'pf_ph_code' => $_SESSION['shPhforPf'], 
		
		    
		);
	
		$query = inserterQMaker('dm_pish_factor', $query);
		$lnk = mysql_query($query);
		sqlErr('addAPrice2Bill');
		$pf_id=$_SESSION['shomarePishFactor'] = mysql_insert_id();
//	}
	
	$pf_unit_price = $_REQUEST['pf_unit_price'];
	$phd_amount = $_REQUEST['phd_amount'];
	$phd_id = $_REQUEST['phd_id'];
	$pf_price =$pf_unit_price * $phd_amount;
	
	$query = array(
		'pf_pf_id' => $pf_id,
		'pf_unit_price' => $pf_unit_price,
		'pf_price'=>$pf_price,
	);
	
	$query = inserterQMaker('dm_pish_factor_det', $query);
	$lnk = mysql_query($query);
	sqlErr('addaprice2bill');
	$pf_id_det = mysql_insert_id();
	
	$query="SELECT sum(pf_price) as totalprice from dm_pish_factor_det where pf_pf_id='".$pf_id."'";
	$lnk = mysql_query($query);
	$row= mysql_fetch_assoc($lnk);	
	sqlErr('addaprice2bill');
	$query1 = "
		UPDATE dm_pish_factor 
		SET 
			`pf_totalprice` = '".$row['totalprice']."',
		
		WHERE 
			pf_id = ".$pf_id." 
		AND
		    pf_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
		    AND
			   pf_id_year=".$_SESSION['dm_user_profile']['u_year_id']."  
	";
	//die($query);
	$lnk = mysql_query($query1);
	sqlErr('addAPrice2Bill+akharesh');

    $GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$pf_unit_price.';'.$phd_amount.';'.$phd_id.';'.$pf_price.';'.$row['totalprice'].';';
		
}


function addInfPardakht(){
	//print_r($_REQUEST);
	
	$d_code=$_REQUEST['d_code'];
	$pf_num_doc=$_REQUEST['pf_num_doc'];
	$pf_account_cus = $_REQUEST['pf_account_cus'];
	$pf_sarresid_num = $_REQUEST['pf_sarresid_num'];  
	
		$query = "
		UPDATE dm_pish_factor 
		SET 
			`pf_d_code` = '".$d_code."',
			`pf_num_doc` = '".$pf_num_doc."',
			`pf_account_cus` = '".$pf_account_cus."',
			`pf_sarresid_num` = '".$pf_sarresid_num."',	
		
		WHERE 
			  pf_id = ".$_SESSION['shomarePishFactor']." 
		AND   pf_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
		AND   pf_id_year=".$_SESSION['dm_user_profile']['u_year_id']."
	
	";
	//die($query);
	$lnk = mysql_query($query);
	sqlErr('addInfPardakht');
	
	$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]';
	

}
function insertHavale(){
	
	$h_pf_code=$_REQUEST['pf_id'];
	$h_ph_id=$_REQUEST['ph_id'];
	
	$querys = "
			 	SELECT *  FROM dm_signature_g 
		 
				WHERE 
					sig_status = ". 1 ." 
				AND
				   sig_id_province=".$_SESSION['dm_user_profile']['u_province_id']  ."
				
			";
			$lnks = mysql_query($querys);
			$rows= mysql_fetch_assoc($lnks);
	       $IP_address = VisitorIP();
if($_SESSION['dm_user_profile']['u_year_id']==100)
				{
					$year_id=$_SESSION['dm_user_profile']['year_id'];
					
				}else{
					
					$year_id=$_SESSION['dm_user_profile']['u_year_id'];
				}
		$query = array(
			'h_pf_code' => $h_pf_code,
       	 	'h_ph_id' => $h_ph_id, 
		    'h_reg_date'=> gmdate('Y-m-d'),
		    'h_id_province' => $_SESSION['dm_user_profile']['u_province_id'], 
		    'h_ip_user' => $IP_address, 
		    'h_id_year' => $year_id,
		    'h_sig_id' => $rows['sig_id'],
		
		);

		$query = inserterQMaker('dm_havale', $query);
		$lnk = mysql_query($query);
		if(mysql_error()) print mysql_error();
		$h_id = mysql_insert_id();
		
		
		$outHtml='حواله ثبت شد ';
	$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$outHtml;
}

function insertFactor(){
	
	$h_pf_code=$_REQUEST['pf_id'];
	$h_ph_id=$_REQUEST['ph_id'];
	
	$query="SELECT h_id as h_f_id From dm_havale WHERE
	    h_id_year=".$_SESSION['dm_user_profile']['u_year_id']."
	 AND
	       h_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
	  AND
	   
	       h_pf_code='.$h_pf_code.' 
	       ";
	
		$query = array(
			'f_h_id' => 'h_f_id',
       	 	'f_ph_id' => $h_ph_id, 
		    'f_reg_date'=> gmdate('Y-m-d'),
	        'f_id_province' => $_SESSION['dm_user_profile']['u_province_id'], 
		    'f_status_ebtal' => 0 ,
		    'f_id_year' => $_SESSION['dm_user_profile']['u_year_id'], 
		);
		
		$query = inserterQMaker('dm_factor', $query);
		$lnk = mysql_query($query);
		if(mysql_error()) print mysql_error();
		$h_id = mysql_insert_id();
		$outHtml='فاكتور ثبت شد ';
	$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$outHtml;
}
function insertFactor1(){
	
	$pf_code=$_REQUEST['pf_code'];
	$h_code=$_REQUEST['h_code'];
	$f_code=$_REQUEST['f_code'];
	$ph_code=$_REQUEST['ph_code'];
	$cusName=$_REQUEST['cusName'];
	$queryf = "
					 	SELECT *  FROM dm_factor 
				 
						WHERE 
							f_h_code = '".$h_code."'
					    AND
					        f_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
					    AND
					        f_id_year=".$_SESSION['dm_user_profile']['u_year_id']."
					      AND
					      f_status_ebtal=". 0 ." 
					     
					     ";
							 	
				$lnkf = mysql_query($queryf);
				if(mysql_error()) print mysql_error();
				
				$rowf= mysql_fetch_assoc($lnkf);
//				print $queryf;
			
				
		if(mysql_num_rows($lnkf)==0){
	
	$queryp="SELECT * FROM dm_province 
        WHERE province_id=".$_SESSION['dm_user_profile']['u_province_id']."";
		$lnkp=mysql_query($queryp);
		print mysql_error();
		$rowp=mysql_fetch_assoc($lnkp);
		$provinceName=$rowp['province_name'];
	
	$query="SELECT MAX(f_code) maxId FROM dm_factor 
	    WHERE
	    f_id_province=".$_SESSION['dm_user_profile']['u_province_id']."  ";
	    
	$lnk=mysql_query($query);
	
	print mysql_error();
	$row=mysql_fetch_assoc($lnk);
	$f_code=$row['maxId']+1;
	
		$query = array(
		
			'f_code' => $f_code, 
       	 	'f_h_code' => $h_code, 
		    'f_reg_date'=> gmdate('Y-m-d'),
		    'f_id_province' => $_SESSION['dm_user_profile']['u_province_id'],
		    'f_status_ebtal' => 0 ,
		    'f_id_year' => $_SESSION['dm_user_profile']['u_year_id'], 
		);
		
		$query = inserterQMaker('dm_factor', $query);
		$lnk = mysql_query($query);
		if(mysql_error()) print mysql_error();
		$f_id = mysql_insert_id();
		$message=' فاكتور '. $f_code.' ثبت شد ';
		$_SESSION['f_id']=$f_id;
		}else{
			$message=' براي اين حواله قبلا فاكتور صادر شده ';
		}
	 $GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$message.';'.$f_id.';'.$h_code.';'.$f_code.';'.$ph_code.';'.$_SESSION['dm_user_profile']['u_province_id'].';'.$cusName.';'.$provinceName.';';
}
function addbestankari(){
 $pf_code=$_REQUEST['pf_code'];	
 $bestankari=$_REQUEST['bestankari'];

if($_SESSION['dm_user_profile']['u_year_id']==100)
				{
					$year_id=$_SESSION['dm_user_profile']['year_id'];
					
				}else{
					
					$year_id=$_SESSION['dm_user_profile']['u_year_id'];
				}
	 $query = array(
				'dpf_pf_code' => $pf_code,
				'dpf_d_id' => 7,
				
		        'dpf_price' => $bestankari,
	            'dpf_type_sanad' => 10,
	            'dpf_id_province' => $_SESSION['dm_user_profile']['u_province_id'],
	            'dpf_id_year' => $year_id,
	            'dpf_u_id' => $_SESSION['dm_user_profile']['u_id'],
	);

	$query = inserterQMaker('dm_pf_document', $query);
	print $query;
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
	 $GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$message.';'.$f_id.';'.$h_code.';'.$f_code.';'.$ph_code.';'.$_SESSION['dm_user_profile']['u_province_id'].';'.$cusName.';'.$provinceName.';';
	
}
function addednewhavalekoli(){
	
      $h_ph_code=$_REQUEST['h_ph_code'];
      $pf_code=$_REQUEST['pf_code'];
      $phd_price=$_REQUEST['phd_price'];     
      $phd_id=$_REQUEST['phd_id'];
      $customer_code=$_REQUEST['customer_code'];
      
      $query1 = "SELECT * FROM  dm_year where
            year_status=1 ";	
		$lnk1 = mysql_query($query1);
	//	print $query1;
		$row1= mysql_fetch_assoc($lnk1);
		$year_id=$row1['year_id'];
		$queryh = "SELECT * FROM dm_havale WHERE h_pf_code=".$pf_code." 
				   AND 
					   h_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
				   ";   
		//print $queryh; 
		        
				$lnkh = mysql_query($queryh);
				$rowh=mysql_fetch_assoc($lnkh);
				
				$querymabadi = " 	SELECT *  FROM mabadi.mbd_havale					 
									WHERE 
									meghdar_xtra >0	
									and h_id= ".$rowh['h_id']."								
										";											
								$lnkmabadi = mysql_query($querymabadi);
								$rowmabadi = mysql_fetch_assoc($lnkmabadi);		
								
				if($rowmabadi['ph_idxtra']> 0 AND $rowmabadi['h_idxtra']==0){
					$mm=1;
					
				}else{
					
				$mm=0;	
				}
		
	if($_SESSION['dm_user_profile']['u_year_id']==$year_id   )
		{	
 
		      $queryphh = "SELECT * FROM dm_pish_havale WHERE ph_code=".$h_ph_code." 
					       AND 
					           ph_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
					       AND 
					           ph_id_year=".$_SESSION['dm_user_profile']['u_year_id']." ";
		           
				$lnkphh = mysql_query($queryphh);
				$rowphh=mysql_fetch_assoc($lnkphh);
			//echo $queryphh;	
		$queryh = "SELECT * FROM dm_havale WHERE h_pf_code=".$pf_code." 
				   AND 
					   h_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
				   ";   
		//print $queryh; 
		        
				$lnkh = mysql_query($queryh);
				$rowh=mysql_fetch_assoc($lnkh);
		if(mysql_num_rows($lnkh)>0){
			$status=5;
			$message='برای اين پيش فاكتور حواله زده شده  ';
			
			
			
		}else{
					$queryp1 = " select * from dm_pish_factor where pf_ph_code=".$h_ph_code." 
							   AND 
								   pf_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
							   AND 
								   pf_id_year=".$_SESSION['dm_user_profile']['u_year_id']." ";           
							$lnkp1 = mysql_query($queryp1);
							
						//print  $queryp1;
					if(mysql_num_rows($lnkp1)>0)
						    {   $rowp=mysql_fetch_assoc($lnkp1); 
								$pf_code =$rowp['pf_code'];
							    $queryphd = "SELECT * FROM dm_pish_havale_det  WHERE phd_ph_code=".$h_ph_code." 
											   AND 
												   phd_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
											   AND 
												   phd_id_year=".$_SESSION['dm_user_profile']['u_year_id']." ";
									
									$lnkphd = mysql_query($queryphd);
									print $queryphd;
									$phd_price=0;
									while($rowphd = mysql_fetch_assoc($lnkphd))
										{
										
										   $phd_price=$phd_price+$rowphd['phd_priceh'];
										
										}
									
									$query2 = "SELECT * FROM dm_pf_document WHERE dpf_pf_code=".$pf_code." 
											AND 
												  dpf_id_province=".$_SESSION['dm_user_profile']['u_province_id']."";	
									$lnk2 = mysql_query($query2);
													
		if(mysql_num_rows($lnk2)>0){
				$dpf_price=0;
				while($row= mysql_fetch_assoc($lnk2)){
				 if($row['dpf_type_sanad']==10){
				 	echo 'kam shode';
				 $dpf_price=$dpf_price-$row['dpf_price'];	
				 }else{
				$dpf_price=$dpf_price+$row['dpf_price'];}
						
				}
				echo 'dpf_price='.$dpf_price;
				if($dpf_price<$phd_price)
				{
				$message='هزينه وارد شده كمتر از هزينه خريداري شده است  ';
		$status=2;
		        }else if($dpf_price > $phd_price){
		        	echo $dpf_price;
		        	echo '>';
		        	echo $phd_price;
		        $message='هزينه وارد شده بيشتر از هزينه خريداری شده است لذا مبلغی بابت بستانكاري مشتری ميشود  ';
		$status=4;
		$bestankari=($dpf_price)-($phd_price);
		
		        
		    }else if($dpf_price = $phd_price)
		     {
		     	
		     	
		     	$statusanbar=0;
		     	//chek for kol hvale ha jozeeyat bokhore
		     	
		     	$queryj1="SELECT * FROM dm_pish_factor pf 
						left join dm_pish_havale ph  on pf.pf_ph_code=ph.ph_code
						left join dm_pish_havale_det phd on phd.phd_ph_code=ph.ph_code
							WHERE
								 pf_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
							AND
								 ph_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
							AND
								 pf_code=".$pf_code."
							AND
								 ph_code=".$h_ph_code."
						    AND
							     phd_id_province=".$_SESSION['dm_user_profile']['u_province_id']."";					
		
				$lnkj1= mysql_query($queryj1);
				//	print $queryj; 
				
					
					 while($rowj1 = mysql_fetch_assoc($lnkj1))
					{//begin while
						
	//chek olofe or goshti 7
	
		     	
				$queryjo= "select * from dm_product product
										left join dm_price price
												on product.p_id=price.price_p_id
												 WHERE p_code=". $rowj1['phd_pid']." 
												 And
												 p_price_code=".$rowj1['phd_price_code']."
												 AND
												  price_id_province=".$_SESSION['dm_user_profile']['u_province_id']."";				
		
				$lnkjo= mysql_query($queryjo);
				$rowjo = mysql_fetch_assoc($lnkjo);		
	
						
						$queryanbar="SELECT * FROM dm_anbar_det
						
							WHERE
								 dad_phd_id=".$rowj1['phd_id']."
							";					
		
				    $lnkanbar= mysql_query($queryanbar);
				    print $queryanbar;
				    $dad_tedad=0;
				     while($rowanbar = mysql_fetch_assoc($lnkanbar))
					{	
				    
						//mohasebe tedad
	     $querya="select * from meat.mojody_kala 
  					where
  					     id=".$rowanbar['dad_anbar_id']."";					     
										        
			$lnka = mysql_query($querya);
			$rowa = mysql_fetch_assoc($lnka);
						
						if($rowanbar['dad_no']==5){
							
							
							
							if(($rowjo['p_code']==50) or ($rowjo['p_code']==54)){
								
							
							
								$dad_tedadoo=$rowanbar['dad_tedad'];
								
								
							}else{
							
							//$kartons=$rowanbar['dad_vazn_n']-$rowanbar['dad_vazn_kh'];
							$dad_tedadoo=$rowanbar['dad_vazn_kh'];
							
							}	
							
						}else if($rowanbar['dad_no']==8){
							
							
							$dad_tedadoo=$rowanbar['dad_tedad'];
							
						}else if($rowanbar['dad_no']==7){
							
							
							
							$dad_tedadoo=$rowanbar['dad_vazn_kh'];
							
						
							
						}
						
						$dad_tedad=$dad_tedad+$dad_tedadoo;
						
					}
				$phd_amount=urlencode($rowj1['phd_amount']);
				$dad_tedad=urlencode($dad_tedad);
				
					if(($rowjo['p_category']==7) and ($rowjo['p_code']!=50) and ($rowjo['p_code']!=51) and ($rowjo['p_code']!=54) ){
					
					$statusjoz=1;
					
				}
					if((($dad_tedad==0) and ($statusjoz==1)) or (($dad_tedad<$phd_amount) and ($statusjoz==1))){
						$status=1;
						//nasim
				 	$message='جزییات را وارد کنید  ';
				 	$statusanbar=1;
						
					}
					if(($rowjo['p_category']==7) and ($rowjo['p_code'] !=50) and ($rowjo['p_code'] !=51) and ($rowjo['p_code'] !=54) ){
					
					$statusjoz=1;
					
				}
				 else if(($dad_tedad>$rowj1['phd_amount']) and ($statusjoz==1)){
				 	
				 	//echo $dad_tedad;
					echo '/';
					echo $rowj1['phd_amount'];
				 	
				 	$status=8;
				 	$message='مقدار وارده برای جزییات بیشتر از حد مجاز است  ';
				 	$statusanbar=1;
				 	
				 }
					}
		     	

		     	
		     	
		     	
		     	
		     	//ss	
	     	
				$queryj="SELECT * FROM dm_pish_factor pf 
						left join dm_pish_havale ph  on pf.pf_ph_code=ph.ph_code
						left join dm_pish_havale_det phd on phd.phd_ph_code=ph.ph_code
							WHERE
								 pf_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
							AND
								 ph_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
							AND
								 pf_code=".$pf_code."
							AND
								 ph_code=".$h_ph_code."
						    AND
							     phd_id_province=".$_SESSION['dm_user_profile']['u_province_id']."";					
		
				$lnkj= mysql_query($queryj);
				//	print $queryj; 
				
					
					 while($rowj = mysql_fetch_assoc($lnkj))
					{//begin while
						
	//chek olofe or goshti 7
	
		     	
				$queryjo= "select * from dm_product product
										left join dm_price price
												on product.p_id=price.price_p_id
												 WHERE p_code=". $rowj['phd_pid']." 
												 And
												 p_price_code=".$rowj['phd_price_code']."
												 AND
												  price_id_province=".$_SESSION['dm_user_profile']['u_province_id']."";				
		
				$lnkjo= mysql_query($queryjo);
				$rowjo = mysql_fetch_assoc($lnkjo);		
	
					//	echo $queryjo;
						$queryanbar="SELECT * FROM dm_anbar_det
						
							WHERE
								 dad_phd_id=".$rowj['phd_id']."
							";					
		
				    $lnkanbar= mysql_query($queryanbar);
				  //  print $queryanbar;
				    $dad_tedad=0;
				     while($rowanbar = mysql_fetch_assoc($lnkanbar))
					{	
				    
						//mohasebe tedad
	     $querya="select * from meat.mojody_kala 
  					where
  					     id=".$rowanbar['dad_anbar_id']."";					     
										        
			$lnka = mysql_query($querya);
			$rowa = mysql_fetch_assoc($lnka);
					
						if($rowanbar['dad_no']==5){
							
								if(($rowjo['p_code']==50) or ($rowjo['p_code']==54)){
								
							
							
								$dad_tedadoo=$rowanbar['dad_tedad'];
								
								
							}else{
							$dad_tedadoo=$rowanbar['dad_vazn_kh'];	
								
							}
							
							//$kartons=$rowanbar['dad_vazn_n']-$rowanbar['dad_vazn_kh'];
							
							
							
							
						}else if($rowanbar['dad_no']==8){
							
							
							$dad_tedadoo=$rowanbar['dad_tedad'];
							
						}else if($rowanbar['dad_no']==7){
				if(($rowjo['p_code']==50) or ($rowjo['p_code']==54)){
							
								
							
							
								$dad_tedadoo=$rowanbar['dad_tedad'];
								
								
							}else{
							
							
							$dad_tedadoo=$rowanbar['dad_vazn_kh'];
							
							}
						}
						
						$dad_tedad=$dad_tedad+$dad_tedadoo;
						
					}
					
$dad_tedad=urlencode($dad_tedad);
$phd_amount=urlencode($rowj['phd_amount']);

$queryhh="SELECT * FROM dm_havale
						
							WHERE
								 h_phd_id=".$rowj['phd_id']."
							";					
		
				   $lnkhh= mysql_query($queryhh);
                   $rowhh = mysql_fetch_assoc($lnkhh);
 $querymabadi="select * from mabadi.mbd_havale 
  					where
  					     h_id=".$rowhh['h_id']."";					     
										        
			$lnkmabadi = mysql_query($querymabadi);
			$rowmabadi = mysql_fetch_assoc($lnkmabadi);





					if(($rowjo['p_category']==7) and ($rowjo['p_code']!=50) and ($rowjo['p_code']!=51) and ($rowjo['p_code']!=54) ){
						
					
					$statusjoz=1;
					
				}else{
					
					$statusjoz=2;
					
				}
				echo $statusjoz;
					if((($dad_tedad==0) and ($statusjoz==1)) or (($dad_tedad<$rowj['phd_amount']) and ($statusjoz==1))){
						$status=1;
						
						//nasim35
				 	$message='جزییات را وارد کنید ';
						
					}
					
				 else 
				 if(($dad_tedad>$phd_amount) and ($statusjoz==1)){
				 	echo $dad_tedad;
				 	echo '/';
				 	echo $rowj['phd_amount'];
				 	
				 	$status=8;
				 	$message='مقدار وارده برای جزییات بیشتر از حد مجاز است  ';
				 	
				 	
				 }else if($statusanbar==1){
				 	
				 	$message='مقادیر جزییات انبار ها چک شود';
				 	
				 	
				 }else 
				{
				 	
				 	
				 	
				 	
				 	 $querymoj = "SELECT * FROM dm_pish_havale_det phd
				                        	 left join dm_pish_havale ph
								 	       on 
								 	     phd.phd_ph_code=ph.ph_code

				 	                     WHERE 
				 	                   
				 	                      phd_ph_code=".$h_ph_code." 
								 	 
											 AND 
									   phd_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
									   AND 
									   ph_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
											    ";
									
									$lnkmoj = mysql_query($querymoj);
									$rowmoj=mysql_fetch_assoc($lnkmoj);
							//jadid		
								$lnkmojavez = mysql_query("SELECT * FROM dm_op_mojavez phm left join dm_operation_acc acc 
														     on  phm.phm_op_id=acc.g_id  where

														     phm_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
														    and
															  phm_mojavez='".$rowmoj['ph_mojavez']."'
															and
							                                '".gmdate('Y-m-d')."'  <=  phm_date_l
														    and 
														       phm_op_id = '".$rowmoj['ph_operation_id']."' ");
								
								
														       
													echo ("SELECT * FROM dm_op_mojavez phm left join dm_operation_acc acc 
														     on  phm.phm_op_id=acc.g_id  where

														     phm_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
														    and
															  phm_mojavez='".$rowmoj['ph_mojavez']."'
															and
							                                '".gmdate('Y-m-d')."'  <=  phm_date_l
														    and 
														       phm_op_id = '".$rowmoj['ph_operation_id']."' ");
																
									
									if((mysql_num_rows($lnkmojavez)==0) AND $rowmoj['phd_robari_s']==0){
										echo '00000000';
										$status=13;
										$message='مجور برای انجام چنین کاری ندارید';
										
									}else{			        
						        
				 	//*
				 	
				 	
				 	
					//enja mizane 
		
						$status=1;
			$queryh1="SELECT * FROM dm_havale 
				WHERE
				h_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
				 AND 
				 h_id_year=".$_SESSION['dm_user_profile']['u_year_id']." ";
			$lnkh1=mysql_query($queryh1);	
			print mysql_error();
			if(mysql_num_rows($lnkh1)==0){
				     $query1 = "SELECT * FROM  dm_year where
					            year_status=1 ";	
							$lnk1 = mysql_query($query1);
						//	print $query1;
							$row1= mysql_fetch_assoc($lnk1);
							$year_code=$row1['year_code'];
			            $h_code=$year_code.'000000';
			            echo  $h_code;
			            
			
			}else{
		
				$query="SELECT MAX(h_code) maxId FROM dm_havale 
					WHERE
					h_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
					 AND 
					 h_id_year=".$_SESSION['dm_user_profile']['u_year_id']."";
				  
				$lnk=mysql_query($query);	
				print mysql_error();
				
				$row=mysql_fetch_assoc($lnk);
				$h_code=$row['maxId'];
			}
			$h_code=$h_code+1;
											
				$querys = "
						SELECT *  FROM dm_signature_g 
				 
						WHERE 
							sig_status = ". 1 ." 
						AND
						   sig_id_province=".$_SESSION['dm_user_profile']['u_province_id']  ."
						
					";
					$lnks = mysql_query($querys);
					$rows= mysql_fetch_assoc($lnks);
				$IP_address = VisitorIP();
					if($_SESSION['dm_user_profile']['u_year_id']==100)
						{
							$year_id=$_SESSION['dm_user_profile']['year_id'];
							
						}else{
							
							$year_id=$_SESSION['dm_user_profile']['u_year_id'];
						}
						
						$queryprodi = "select * from dm_product product
										left join dm_price price
												on product.p_id=price.price_p_id
												 WHERE p_code=". $rowj['phd_pid']." 
												 And
												 p_price_code=".$rowj['phd_price_code']."
												 AND
												  price_id_province=".$_SESSION['dm_user_profile']['u_province_id']."";
					
			    	$lnkprodi = mysql_query($queryprodi);	
					$rowprodi= mysql_fetch_assoc($lnkprodi);	
					
				 $queryph1 = "SELECT * FROM dm_pish_havale WHERE ph_code=".$h_ph_code." 
					       AND 
					           ph_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
					      ";
		           
				$lnkph1 = mysql_query($queryph1);
				$rowph1=mysql_fetch_assoc($lnkph1);
				if($rowj['phd_hidrobari']==0){
					$h_hidrobari=0;
					
				}else{
					
					$h_hidrobari=$rowj['phd_hidrobari'];		
				}
				
				
				$queryop1="SELECT * FROM dm_operation_acc 
					    WHERE
					      g_id=".$rowph1['ph_operation_id']."";
				  
					$lnkop1=mysql_query($queryop1);	
					//print mysql_error();
					$rowop1=mysql_fetch_assoc($lnkop1);	
					
					
				$queryl="SELECT * FROM dm_location_goods 
					    WHERE
					      l_id=". $rowj['phd_robari']."";
				  
					$lnkl=mysql_query($queryl);	
					//print mysql_error();
					$rowl=mysql_fetch_assoc($lnkl);	
						
		mysql_query("BEGIN");	
		$query = array(
					
					'h_reg_date'=>      gmdate('Y-m-d'),
		            'h_reg_time'=>      gmdate("Y-m-d H:i",time()+12600),
					'h_pf_code'=>       $pf_code,
					'h_code'=>          $h_code,
					'h_u_id'=>          $_SESSION['dm_user_profile']['u_id'],
					'h_status'=>        0, 
					'h_phd_id'=>        $rowj['phd_id'], 
					'h_amount'=>        $rowj['phd_amount'],
		            'h_mande_havale'=>  $rowj['phd_amount'],
		            'h_pre_amount'=>    $rowj['phd_amount'],
					'h_p_code'=>        $rowj['phd_pid'],
					'h_p_id'=>          $rowprodi['p_id'],
					'h_l_code'=>        $rowj['phd_l_id'],
					'h_deli_name'=>     $rowj['phd_deli_name'],
					'h_price_code'=>    $rowj['phd_price_code'],
					'h_id_unit'=>       $rowprodi['p_unit'],
					'h_p_price'=>       $rowj['phd_p_price'],
		            'h_p_priceh'=>      $rowj['phd_p_priceh'],
		            'h_p_add'=>         $rowj['phd_p_add'],
					'h_price'=>         $rowj['phd_price'],
		            'h_priceh'=>        $rowj['phd_priceh'],
		            'h_robari'=>        $rowj['phd_robari'],
		            'h_robari_code'=>   $rowl['l_code'],
					'h_price_pre'=>     $rowj['phd_priceh'],
					'h_customer_code'=> $rowphh['ph_customer_code'],
					'h_id_province' =>  $_SESSION['dm_user_profile']['u_province_id'], 
					'h_id_year' =>      $year_id,
					'h_ip_user' =>      $IP_address,
					'h_sig_id' =>       $rows['sig_id'],
		            'h_p_type' =>       $rowprodi['p_type'],
	            	'h_op_code' =>      $rowop1['g_code'],
	                'h_phidrobari' =>   $h_hidrobari,
		            'h_cms' =>          $rowj['phd_robari_s'],
		 
		           
				);
			
				$query = inserterQMaker('dm_havale', $query);
				$lnk = mysql_query($query);	
				echo $query;
				if($lnk){		
				mysql_query("COMMIT");
				echo 'Done';
	
				
				}else{
					
				mysql_query("ROLLBACK");
		      echo "ارتباط شما قطع شده لطفا دوباره وارد شويد";
		         $_SESSION['isLogged']=false;	
					
				}
				//print $query;
				if(mysql_error()) print mysql_error();
				$h_id = mysql_insert_id();
				$message='حواله شماره'.$h_code.'ثبت شد  ';
				
				
				 $query = "
					UPDATE dm_pish_havale_det 
					SET 
						
						`phd_status` = '". 1 ."'			
					 WHERE 
						phd_id = ". $rowj['phd_id']."";				
						$lnk = mysql_query($query);
						if(mysql_error()) print mysql_error();
				
		//1 update check price in dm_pish_factor
			  $pf_price_check =$rowp['pf_price_check']-$rowj['phd_price'];
					  
			  $query = "
				UPDATE dm_pish_factor 
				SET 
					`pf_price_check` = '".$pf_price_check."'
					
				WHERE 
					  pf_code=".$pf_code."
				AND
					  pf_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
				AND   
				      pf_id_year=".$_SESSION['dm_user_profile']['u_year_id']."";		
			
			$lnk = mysql_query($query);
			sqlErr('update price check');
			            
		//1 ta enja	
		//2 update phd_status=1
		  $query = "
					UPDATE dm_pish_havale_det 
					SET 
						
						`phd_status` = '". 1 ."'			
					 WHERE 
						phd_id = ".  $rowj['phd_id']."";				
						$lnk = mysql_query($query);
					$status=1;
			
		 }			
	//end while				
				 }//*			
		}
		
		   //ss  
		     }
		
		}
		else{
		$message='لطفا اطلاعات اسناد را وارد كنيد';
		$status=0;
		}
						           }
						           
						    else{
								$status=3;
								$message="ابتدا پيش فاكتور را ثبت كنيد!";
						        }
						        
						        
						       
						        
					
						 
				}	
		
		              ?>
						<input type="hidden" id="pf_code"     name="pf_code"     value="<?php echo $pf_code ?>"> 
						<input type="hidden" id="bestankari"  name="bestankari"  value="<?php echo $bestankari ?>">  
					<?php 
					
					
		}else{
			$message=' شما در اين سال نميتوانيد عمليات ثبت انجام دهيد لطفا سال جديد را انتخاب كنيد ';
			$status=6; 
		}
	    $GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$message.';'.$h_ph_code.';'.$h_code.';'.$h_id.';'.$status.';'.$phd_id.';'.$bestankari.';'.$pf_code.';'.$statusanbar.';';
			
}
function addNewHavale(){
	
      $h_ph_code=$_REQUEST['h_ph_code'];
      $pf_code=$_REQUEST['pf_code'];
      $phd_price=$_REQUEST['phd_price'];     
      $phd_id=$_REQUEST['phd_id'];
      $customer_code=$_REQUEST['customer_code'];
     
       $queryp = "SELECT * FROM dm_pish_factor WHERE pf_ph_code=".$h_ph_code." 
			       AND 
			           pf_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
			       AND 
			           pf_id_year=".$_SESSION['dm_user_profile']['u_year_id']." ";
           
		$lnkp = mysql_query($queryp);
		$rowp=mysql_fetch_assoc($lnkp);
		$queryphh = "SELECT * FROM dm_pish_havale WHERE ph_code=".$h_ph_code." 
			       AND 
			           ph_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
			       AND 
			           ph_id_year=".$_SESSION['dm_user_profile']['u_year_id']." ";
           
		$lnkphh = mysql_query($queryphh);
		$rowphh=mysql_fetch_assoc($lnkphh);
		
		
	$queryop="SELECT * FROM dm_operation_acc 
	    WHERE
	      g_id=".$rowphh['ph_operation_id']."";
  
	$lnkop=mysql_query($queryop);	
	//print mysql_error();
	$rowop=mysql_fetch_assoc($lnkop);
		
		if(mysql_num_rows($lnkp)>0){
     
      $pf_code =$rowp['pf_code'];

      $query = "SELECT * FROM dm_havale WHERE h_pf_code=".$pf_code."
		       AND
		         h_id_province=".$_SESSION['dm_user_profile']['u_province_id']." 
		       AND
		           h_id_year=".$_SESSION['dm_user_profile']['u_year_id']."
		         ";
		$lnk = mysql_query($query);
//		if(mysql_affected_rows()>0){
//			$status=2;
//			$message=' برای این پیش فاکتور قبلا حواله صادر شده است ';
//			
//		}else{
//felan en ghesmat estefade nemishe							
     $query = "SELECT * FROM dm_pf_document WHERE dpf_pf_code=".$pf_code." 
				AND 
		              dpf_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
				AND 
		             dpf_id_year=".$_SESSION['dm_user_profile']['u_year_id']."";
     	
		$lnk = mysql_query($query);
		print  $query;
		if(mysql_num_rows($lnk)>0){
		$dpf_price=0;
		while($row= mysql_fetch_assoc($lnk)){
		
		$dpf_price=$dpf_price+$row['dpf_price'];
				
		}
//ta enja

		if($rowp['pf_price_check']<$phd_price){
		$message='هزينه وارد شده كمتر از هزينه خريداري شده است  ';
}else{		
			
	$status=1;
		
	$queryh="SELECT * FROM dm_havale 
	    WHERE
	    h_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
	     AND 
		 h_id_year=".$_SESSION['dm_user_profile']['u_year_id']."";
	 	  
	$lnkh=mysql_query($queryh);	
	print mysql_error();
	if(mysql_num_rows($lnkh)==0){
			$query1 = "SELECT * FROM  dm_year where
	            year_status=1 ";	
			$lnk1 = mysql_query($query1);
		//	print $query1;
			$row1= mysql_fetch_assoc($lnk1);
			$year_code=$row1['year_code'];
		
	$h_code=$year_code.'000000';
	
	}else{

	$query="SELECT MAX(h_code) maxId FROM dm_havale 
	    WHERE
	    h_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
	     AND 
		 h_id_year=".$_SESSION['dm_user_profile']['u_year_id']."";
	   
	$lnk=mysql_query($query);	
	print mysql_error();
	
	$row=mysql_fetch_assoc($lnk);
	$h_code=$row['maxId'];
	}
	$h_code=$h_code+1;
			
//retrive from dm_pish_havale_det	
	$queryr="SELECT * FROM dm_pish_havale_det 
		    WHERE
		    phd_id=".$phd_id." ";		     		 	    
		$lnkr=mysql_query($queryr);		
		print mysql_error();
		$rowr=mysql_fetch_assoc($lnkr);
		$querys = "
			 	SELECT *  FROM dm_signature_g 
		 
				WHERE 
					sig_status = ". 1 ." 
				AND
				   sig_id_province=".$_SESSION['dm_user_profile']['u_province_id']  ."
				
			";
			$lnks = mysql_query($querys);
			$rows= mysql_fetch_assoc($lnks);
		$IP_address = VisitorIP();
	$phd_amount	=round($rowr['phd_amount'],3);
	
$query = array(
			
		    'h_reg_date'=>      gmdate('Y-m-d'),
            'h_pf_code'=>       $pf_code,
            'h_code'=>          $h_code,
            'h_u_id'=>          $_SESSION['dm_user_profile']['u_id'],
            'h_status'=>        0, 
            'h_phd_id'=>        $phd_id, 
			'h_amount'=>        $phd_amount,
            'h_mande_havale'=>  $rowr['phd_amount'],
            'h_pre_amount'=>    $phd_amount,
			'h_p_code'=>        $rowr['phd_pid'],
            'h_p_add'=>         $rowr['phd_p_add'],
			'h_l_code'=>        $rowr['phd_l_id'],
			'h_deli_name'=>     $rowr['phd_deli_name'],
			'h_price_code'=>    $rowr['phd_price_code'],
			'h_id_unit'=>       $rowr['phd_id_unit'],
			'h_p_price'=>       $rowr['phd_p_price'],
			'h_price'=>         $rowr['phd_price'],
			'h_priceh'=>        $rowr['phd_priceh'],
			'h_price_pre'=>     $rowr['phd_priceh'],
            'h_customer_code'=> $rowphh['ph_customer_code'],
            'h_id_province' =>  $_SESSION['dm_user_profile']['u_province_id'], 
            'h_id_year' =>      $_SESSION['dm_user_profile']['u_year_id'],
            'h_ip_user' =>      $IP_address,
            'h_sig_id' =>       $rows['sig_id'],
            'h_op_code' =>      $rowop['g_code'], 
            'h_hidrobari' =>   $rowr['phd_hidrobari'], 
            'h_cms' =>        $rowr['phd_robari_s'],
 

		);
	
		$query = inserterQMaker('dm_havale', $query);
		print $query;
		$lnk = mysql_query($query);
		if(mysql_error()) print mysql_error();
		$h_id = mysql_insert_id();
		$message='حواله شماره'.$h_code.'ثبت شد  ';
		
		
		
		
					//sanad mali
	
	

$doc_date = isset($_REQUEST['doc_date']) ? $_REQUEST['doc_date'] : '';
    $id_province = isset($_REQUEST['id_province']) ? $_REQUEST['id_province'] : '';
    $id_year = isset($_REQUEST['id_year']) ? $_REQUEST['id_year'] : '';

     $date = explode('/', $doc_date);
  
    $doc_date=$date[2].'/'.$date[1].'/'.$date[0] ;
     
	$jdate=$doc_date;
	$jdate .= '/\/';
	list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
	list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
		
       if($gmonth<=9){
       $gmonth='0'.$gmonth;  
     }
     if($gday<=9){
       $gday='0'.$gday;  
     }
    $doc_date = $gyear."-".$gmonth."-".$gday;
	
	 if($month_number<=9){
       $month_number='0'.$month_number;  
     }
	// echo $month_number;
     if($day_number <=9){
       $day_number ='0'.$day_number ;  
     }
	 $day_number = $date[0];
	 $month_number = $date[1];
	$query1 = "SELECT * FROM  dm_year where
            year_status=1 ";	
		$lnk1 = mysql_query($query1);
	//	print $query1;
		$row1= mysql_fetch_assoc($lnk1);
		$year_code=$row1['year_code'];
		$year_number = substr($jyear, -2);
		$year_number='97';
	     $out='';	
	   				
	    $queryh = "
				 SELECT *  FROM dm_havale 			 
					 WHERE 
							h_id = '".$h_id."' 
					   AND 
							h_id_province='".$id_province."'
					  ";		  	    					   
    	 $lnkh = mysql_query($queryh);  
    	// echo mysql_num_rows($lnkh); 
    	
				    //	print $queryh;
				//while asli
					while($rowh = mysql_fetch_assoc($lnkh))
					
					{       

						$lnkhp = mysql_query("select * from dm_product product
									      left join dm_price price
										   on product.p_id=price.price_p_id
										 left join dm_prod_det_t prod_t on prod_t.type_prod_id=product.p_type
											 WHERE p_code=".$rowh['h_p_code']." AND p_price_code=".$rowh['h_price_code']."
											 AND
											  price_id_province=".$id_province."");
						
				        $rowhp = mysql_fetch_assoc($lnkhp);
												
						
				        $pf_code=$rowh['h_pf_code'];						                				                 
					    $customer_code=$rowh['h_customer_code'];					                
				        $p_code = $rowh['h_p_code'];
				        $queryc = "SELECT *  FROM dm_customer 
					           WHERE `code_customer`='".$customer_code."'
					           AND
						            1";
					    $lnkc = mysql_query($queryc);
					    $rowc= mysql_fetch_assoc($lnkc);
					   
				        $querypf = "
						       SELECT *  FROM dm_pish_factor 			 
								 WHERE 
									 		pf_code = '".$pf_code."' 
								   AND 
										    pf_id_province='".$id_province."'
								   
								   AND
									        pf_type=". 0 ." ";	   	
									
				          $lnkpf = mysql_query($querypf);
				          $rowpf = mysql_fetch_assoc($lnkpf);
				          $ph_code=$rowpf['pf_ph_code'];
				          $queryph = "
							 SELECT *  FROM dm_pish_havale 			 
								     WHERE 
									 		ph_code = '".$ph_code."' 
									 AND 
										    ph_id_province='".$id_province."'
								     ";  
																	    														
				    		                    	$lnkph = mysql_query($queryph);
				    		                    	$rowph = mysql_fetch_assoc($lnkph);
				    		                    	$mojavez=$rowph['ph_mojavez'];
				    		                    	$mojavez= iconv("utf-8","windows-1256",$mojavez);
				    		                    //	echo $mojavez;
									              //  print $queryph;	
				                                    $queryacc="SELECT * FROM  dm_operation_acc WHERE    g_id=".$rowph['ph_operation_id']."";
				 								    $lnkacc = mysql_query($queryacc);
				    		                        $rowacc = mysql_fetch_assoc($lnkacc);
				    		                    	$operation_code=$rowacc['g_code'];    
				    		                    	//$g_acc_name='/  از نوع '.$rowacc['g_acc_name'].'';		                    
				    		                    //	$operation_code= str_pad($operation_code, 6, "0", STR_PAD_LEFT); 
				    		                    	   		                    
				//mishe bestankar baraye kala  
				                                    $queryac = "
																 SELECT *  FROM dm_acc_doc 			 
																 WHERE 
																 		ac_status = '". 1 ."' ";													
																	
				    		                    	$lnkac = mysql_query($queryac);    		                    
				    		                    	$rowac = mysql_fetch_assoc($lnkac);
				    		                    	$h_customer_code= str_pad($rowh['h_customer_code'], 6, "0", STR_PAD_LEFT); 
				    		                    	$h_price_code= str_pad($rowh['h_price_code'], 6, "0", STR_PAD_LEFT); 
				    		                    	$type_prod_code= str_pad($rowhp['type_prod_code'], 6, "0", STR_PAD_LEFT); 
				    		                    	
				    		                    	$operation_code1= str_pad($operation_code, 6, "0", STR_PAD_LEFT);     
				    		                    	$code=$rowac['ac_code_p_bed'];   		                
				    		                    //	$code = str_replace( "c", $h_customer_code, $code ); 
					    		                   // $code = str_replace( "g", $h_price_code, $code );
					    		                   // $code = str_replace( "a", $operation_code, $code );
					    		             //   echo $operation_code;
					    		              $sh=' شماره حواله '.$rowh['h_code'].' ';
					    		              $fh='پيش فاكتور  '.$rowpf['pf_code'].' ';
					    		              $fph='پيش حواله  '.$rowpf['pf_ph_code'].' ';
					    		              $customer_name=str_replace("ي","ي",$rowc['name_customer']); 
					    		              $customer_name=str_replace("&#1740","", $customer_name);
						                      $customer_name=str_replace(";","", $customer_name);
					    		              $gh=' به نام '.$customer_name.' ';
					    		              $mojavez= iconv("utf-8","windows-1256",$mojavez);	
					    		              $moj='/شماره مجوز'.$mojavez;
					    		              $pish='پيش فروش';
					    		              $a='000000';
					    		              $h_price =$rowh['h_pre_amount'] * $rowh['h_p_price'];
				           		                   
					    		              $ac_topic_p_bes=str_replace("ي","ي",$rowac['ac_topic_p_bes']);
					    		                  // $out1 .='100;'. $year_number .''.$month_number.';'. $year_number .''.$month_number.''.$day_number.';'. $code .''. $h_customer_code  .''. $h_price_code .''. $a .''. $operation_code1 .';'. 0 .';'. $rowh['h_price'] .';'. 2 .'; '.$ac_topic_p_bes.''. $sh .''. $fh .'/'.$fph.''. $gh .' '. 14 .''. 15 .';'. 12 .';'. 17 .';'. $date[2].''.$date[1].''.$date[0] .';'. 18 .';';
				                                 $out .='100;'. $year_number .''.$month_number.';'. $year_number .''.$month_number.''.$day_number.';303001'.$type_prod_code .''.$h_price_code .''.$h_customer_code.''.$operation_code1.';'. 0 .';'.$h_price.';'. 2 .';'.$ac_topic_p_bes.''. $sh .''. $fh .'/'.$fph.''. $gh .''. $g_acc_name .''. $moj .';'. 12 .';'. $rowh['h_code'] .';'. $date[2].''.$date[1].''.$date[0] .';'. $rowh['h_pre_amount'] .';';
				                                   $out .= "\n"; 
				                                   if($rowh['h_p_add']!=0){
				                                    	 $ezaf=$rowh['h_p_add']* $rowh['h_pre_amount'];
				                                    	 $code1='602015';
					                                   	 $out .='100;'. $year_number .''.$month_number.';'. $year_number .''.$month_number.''.$day_number.';'.$code1.''.$a .''.$h_price_code.''. $a .''.$operation_code1.';'. 0 .';'.$ezaf.';'. 2 .';'.$ac_topic_p_bes.''. $sh .''. $fh .'/'.$fph.''. $gh .''. $g_acc_name .''. $moj .';'. 12 .';'. $rowh['h_code'] .';'. $date[2].''.$date[1].''.$date[0] .';'. $rowh['h_pre_amount'] .';';
					                                     $out .= "\n";
				                                   	
				                                   }
				           	                    	 		                   
				    		                   	}	
						//while baraye poli ke rikhtan 
								$queryh = "
										 SELECT 
										*
										   FROM dm_havale 			 
									WHERE 
												h_id = '".$h_id."' 
											AND 
												h_id_province= '".$id_province."'
																
													group by  h_pf_code";	
								
										// print 	$queryh;											     	 										   
						    			     $lnkh = mysql_query($queryh);                    	
						                     while($rowh = mysql_fetch_assoc($lnkh)){	
						                     					 
						                               $queryc = "SELECT *  FROM dm_customer 
													           WHERE `code_customer`='".$rowh['h_customer_code']."'
													           AND
														             1 ";
						                              
													    $lnkc = mysql_query($queryc);
													    $rowc= mysql_fetch_assoc($lnkc);
													 //   $customer_name=str_replace("ي","ي",$rowc['name_customer']);
													  $customer_name=str_replace("ي","ي",$rowc['name_customer']); 
													  $customer_name=str_replace("&#1740","", $customer_name);
								                     $customer_name=str_replace(";","", $customer_name);
													  $customer_name= str_pad($customer_name, 10);
							    		            $gh=' به نام '.$customer_name.' ';
						                         $pf_code=$rowh['h_pf_code'];	
						
						                          $querypf = "
														 SELECT *  FROM dm_pish_factor  
																	 
														 WHERE 
														 		pf_code = '".$pf_code."' 
														 AND 
															    pf_id_province='".$id_province."'
															    								  
												     	AND
											                 pf_type=". 0 ."  "; 
						
																			
						                        	$lnkpf = mysql_query($querypf);
						                        	//print $querypf;
						                        	$rowpf = mysql_fetch_assoc($lnkpf);
						                        	$ph_code=$rowpf['pf_ph_code'];
									                $queryph = "
																 SELECT *  FROM dm_pish_havale 			 
																 WHERE 
																 		ph_code = '".$ph_code."' 
																 AND 
																	    ph_id_province='".$id_province."'
																";
													
						                        	$lnkph = mysql_query($queryph);
						                        	$rowph = mysql_fetch_assoc($lnkph);
						                                   $queryacc="SELECT * FROM  dm_operation_acc WHERE    g_id=".$rowph['ph_operation_id']."";
						 								    $lnkacc = mysql_query($queryacc);
						    		                        $rowacc = mysql_fetch_assoc($lnkacc);   		                  
						    		                    	$operation_code=$rowacc['g_code'];
						    		                    	
										  		 $querydpf = "
															 SELECT *  FROM dm_pf_document 			 
															 WHERE 
																	dpf_pf_code = '".$pf_code."' 
															 AND 
																	dpf_id_province='".$id_province."'";	
																		
						    		                    $lnkdpf = mysql_query($querydpf);
						    		                   
						                   															
						    		                   	while($rowdpf = mysql_fetch_assoc($lnkdpf))
														
						    		                   	{ 
							    		                    $d_id =	$rowdpf['dpf_d_id'];																	
							    		                    $dpf_price   = $rowdpf['dpf_price'];
							    		                     $queryd = "
																	 SELECT *  FROM dm_documentk 			 
																	 WHERE 
																	 		d_id = '".$d_id."' ";
																						 		
							    		                    	//print $queryd;    		                    	    		                  	    		                     
							    		                   	$lnkd= mysql_query($queryd);
							    		                   	$rowd = mysql_fetch_assoc($lnkd); 
							    		                   	$querydt = "
																	 SELECT *  FROM dm_doc_p			 
																	 WHERE 
																	 	docp_id = '".$rowd['d_pardakht_t']."'"; 
									    		                    	    		                  	    		                     
							    		                   	$lnkdt= mysql_query($querydt);
							    		                   	$rowdt = mysql_fetch_assoc($lnkdt);  
							    		            // echo $rowd['d_pardakht_t'];
							    		                   	if($rowd['d_pardakht_t']== 2 ){
							    		                   		//ezafi
							    		                   		$ope=$operation_code;
							    		                   		$h_customer_code= str_pad($rowh['h_customer_code'], 6, "0", STR_PAD_LEFT);
							    		                   		$h_price_code1= str_pad($rowh['h_price_code'], 6, "0", STR_PAD_LEFT);
							    		                   		$ope1= str_pad($ope, 6, "0", STR_PAD_LEFT);
									    		                    $code =$rowd['d_ac_bes']; 
									    		                    $code='301001';
									    		                    $a='000000';   
									    		                   // $code = str_replace( "c", $h_customer_code, $code ); 
									    		                  //  $code = str_replace( "g", $h_price_code, $code );
									    		                   // $code = str_replace( "a", $operation_code, $code );
							    		                   		    $d_ac_bes_dis=str_replace("ي","ي",$rowd['d_ac_bes_dis']); 
							    		                   		    
							    		                   		      $sh=' از محل بستانکاري  '.$rowh['h_code'].' ';
							    		                   		       $sh=str_replace("ي","ي",$sh);
							    		                   		      $fh=' پيش فاكتور  '.$rowpf['pf_code'].' ';
							    		                   		      $fph='پيش حواله  '.$rowpf['pf_ph_code'].' ';
							    		                   		         $dpf_sarresid = str_replace("/","",$rowdpf['dpf_sarresid']);
							    		                   		         $ope1='000301';
							    		                   		        $dpf_num= intval($rowdpf['dpf_num']);
							    		                   		        if($rowh['h_amount']==0){
							    		                   		        	$h_amount=$rowh['h_amount'];
							    		                   		        }else{
							    		                   		        	$h_amount=$rowh['h_ebtalk_amount'];
							    		                   		        	
							    		                   		        }
							    		                   		        
						                                      //  $out1.='100;'. $year_number .''.$month_number.';'. $year_number .''.$month_number.''.$day_number.';'.$code.''.$h_customer_code.''.$a.''.$a.''.$ope1.';'. 0 .';'.$dpf_price.';'. 2 .';'.$d_ac_bes_dis.''.$sh.'/'.$fh.'/'.$fph.''.$gh.';'. 4 .';'. $dpf_num .';'. $year_code .''.$date[1].''.$date[0] .';'. $h_amount .'';	
						                                            								
									    		                 // $out1 .= "\n";  
									    		                  //jadid
							    		                   	   $out .='100;'. $year_number .''.$month_number.';'. $year_number .''.$month_number.''.$day_number.';'.$code.''.$h_customer_code.''.$a.''.$a.''.$ope1.';'.$dpf_price.';'. 0 .';'. 1 .';'.$d_ac_bed_dis.''. $sh .''. $gh .'/'.$fh.';'.$rowdpf['dpf_type'].';'. $dpf_num .';'. $dpf_sarresid .';'. $h_amount .'';    
									    		               $out .= "\n"; 
									    		             //  $out1 .='100;'. $year_number .''.$month_number.';'. $year_number .''.$month_number.''.$day_number.';303001'.$h_customer_code.''.$a.''.$a.''.$ope1.';'.$dpf_price.';'. 0 .';'. 1 .';'.$d_ac_bed_dis.''. $sh .''. $gh .';'.$rowdpf['dpf_type'].';'. $dpf_num .';'. $dpf_sarresid .';'. $h_amount .'';   
									    		              // $out1 .= "\n";       	    		                   		
							    		                   		
							    		                   	}
							    		                   	
						    		                   else	if($rowd['d_pardakht_t']== 7 ){
							    		                   		//ezafi
							    		                   		$ope=$operation_code;
							    		                   		$h_customer_code= str_pad($rowh['h_customer_code'], 6, "0", STR_PAD_LEFT);
							    		                   		$h_price_code1= str_pad($rowh['h_price_code'], 6, "0", STR_PAD_LEFT);
							    		                   		$ope1= str_pad($ope, 6, "0", STR_PAD_LEFT);
									    		                    $code =$rowd['d_ac_bes']; 
									    		                    $code='301001';
									    		                    $a='000000';   
									    		                   // $code = str_replace( "c", $h_customer_code, $code ); 
									    		                  //  $code = str_replace( "g", $h_price_code, $code );
									    		                   // $code = str_replace( "a", $operation_code, $code );
							    		                   		    $d_ac_bes_dis=str_replace("ي","ي",$rowd['d_ac_bes_dis']); 
							    		                   		    
							    		                   		      $sh=' از محل بستانکاري  '.$rowh['h_code'].' ';
							    		                   		       $sh=str_replace("ي","ي",$sh);
							    		                   		      $fh=' پيش فاكتور  '.$rowpf['pf_code'].' ';
							    		                   		      $fph='پيش حواله  '.$rowpf['pf_ph_code'].' ';
							    		                   		         $dpf_sarresid = str_replace("/","",$rowdpf['dpf_sarresid']);
							    		                   		         $ope1='000301';
							    		                   		        $dpf_num= intval($rowdpf['dpf_num']);
							    		                   		        if($rowh['h_amount']==0){
							    		                   		        	$h_amount=$rowh['h_amount'];
							    		                   		        }else{
							    		                   		        	$h_amount=$rowh['h_ebtalk_amount'];
							    		                   		        	
							    		                   		        }
							    		                   		        
							    		                   		        
									    		                  //jadid
							    		                   	   $out .='100;'. $year_number .''.$month_number.';'. $year_number .''.$month_number.''.$day_number.';'.$code.''.$h_customer_code.''.$a.''.$a.''.$ope1.';'. 0 .';'.$dpf_price.';'. 2 .';'.$d_ac_bed_dis.''. $sh .''. $gh .'/'.$fh.';'. 4 .';'. $dpf_num .';'. $year_code .''.$date[1].''.$date[0] .';'. $h_amount .'';	
									    		               $out .= "\n"; 
									    		             //  $out1 .='100;'. $year_number .''.$month_number.';'. $year_number .''.$month_number.''.$day_number.';303001'.$h_customer_code.''.$a.''.$a.''.$ope1.';'.$dpf_price.';'. 0 .';'. 1 .';'.$d_ac_bed_dis.''. $sh .''. $gh .';'.$rowdpf['dpf_type'].';'. $dpf_num .';'. $dpf_sarresid .';'. $h_amount .'';   
									    		              // $out1 .= "\n";       	    		                   		
							    		                   		
							    		                   	}
							    		                   	
							    		                   	else if($rowd['d_pardakht_t']==1) {
							    		                  //pardakhti
							    		                        $ope=$operation_code;
							    		                   		  $h_customer_code= str_pad($rowh['h_customer_code'], 6, "0", STR_PAD_LEFT);
							    		                   		  $h_price_code= str_pad($rowh['h_price_code'], 6, "0", STR_PAD_LEFT);
							    		                   		  $ope1= str_pad($ope, 6, "0", STR_PAD_LEFT);
							    		                   		  
							    		                   		  $banki = "
																	 SELECT *  FROM dm_doc_det_b 			 
																	 WHERE 
																	 	doc_b_id = '".$rowdpf['dpf_bank']."'
																	"; 	
																	 	
									    		                    	    		                  	    		                     
							    		                   	$lnkbanki= mysql_query($banki);
							    		                   	$rowbanki = mysql_fetch_assoc($lnkbanki);
							    		                   		  
							    		                   		  
							    		                   		  
									    		                    $code =$rowd['d_ac_bed']; 
									    		                    $a='000000';  
									    		                     $dpf_num= intval($rowdpf['dpf_num']);
									    		                        $doc_t_name=str_replace("ي","ي",$rowdt['docp_name']);
									    		                        $sh='/ سند از نوع  '.$doc_t_name.'/پيش فاكتور  '.$pf_code.'/شماره فيش '.$dpf_num.'/پيش حواله  '.$rowph['ph_code'].''; 
									    		                        
									    		                   // $code = str_replace( "c", $h_customer_code, $code ); 
									    		                    $code = str_replace( "g", $h_price_code, $code );
									    		                    $code = str_replace( "a", $operation_code, $code ); 
							    		                            $d_ac_bed_dis=str_replace("ي","ي",$rowd['d_ac_bed_dis']); 
							    		                            $dpf_sarresid =str_replace("/","",$rowdpf['dpf_sarresid']);
							    		                            $ope1='000301';
							    		                            $naghdi='واريزي فيش';
							    		                            $naghdi .=$rowdpf['dpf_num'];
							    		                            $naghdi=str_replace("ي","ي",$naghdi); 
							    		                   	    if($rowh['h_amount']==0){
							    		                   		        	$h_amount=$rowh['h_amount'];
							    		                   		        }else{
							    		                   		        	$h_amount=$rowh['h_ebtalk_amount'];
							    		                   		        	
							    		                   		        }
							    		                   	   $out .='100;'. $year_number .''.$month_number.';'. $year_number .''.$month_number.''.$day_number.';'.$code.''.$rowbanki['doc_b_code'].''.$a.''.$a.''.$ope1.';'.$dpf_price.';'. 0 .';'. 1 .';'.$naghdi.''. $sh .''. $gh .';'.$rowdpf['dpf_type'].';'. $dpf_num .';'. $dpf_sarresid .';'. $h_amount .'';    
							    		                        //    $out2 .='100;'. $year_number .''.$month_number.';'. $year_number .''.$month_number.''.$day_number.';'.$code.''.$a.''.$a.''.$ope1.';'.$dpf_price.';'. 0 .';'. 1 .';'.$d_ac_bed_dis.''. $sh .''. $gh .';'.$rowdpf['dpf_type'].';'. $rowdpf['dpf_num'] .';'. $dpf_sarresid .';'. $h_amount .'';    
							    		                               
							    		                       $out .= "\n"; 
							    		                      
							    		                       $out .='100;'. $year_number .''.$month_number.';'. $year_number .''.$month_number.''.$day_number.';301001'.$h_customer_code.''.$a.''.$a.''.$ope1.';'. 0 .';'.$dpf_price.';'. 2 .';'.$d_ac_bes_dis.''.$sh.'/'.$fh.'/'.$fph.''.$gh.';'. 4 .';'. $dpf_num .';'. $year_code .''.$date[1].''.$date[0] .';'. $h_amount .'';	
							    		                      
							    		                       $out .= "\n";
							    		                   		         $out1 .='100;'. $year_number .''.$month_number.';'. $year_number .''.$month_number.''.$day_number.';301001'.$h_customer_code.''.$a.''.$a.''.$ope1.';'.$dpf_price.';'. 0 .';'. 1 .';'.$d_ac_bed_dis.''. $sh .''. $gh .';'.$rowdpf['dpf_type'].';'. $dpf_num .';'. $dpf_sarresid .';'. $h_amount .'';    
							    		                       $out .= "\n";
							    		                      
							    		                      
							    		                   	}else if($rowd['d_pardakht_t']==3){
							    		                   	
							    		                   		$ope=$operation_code ;
							    		                   		
							    		                   		  $h_customer_code= str_pad($rowh['h_customer_code'], 6, "0", STR_PAD_LEFT);
							    		                   		  $h_price_code= str_pad($rowh['h_price_code'], 6, "0", STR_PAD_LEFT);
							    		                   		  $ope1= str_pad($ope, 6, "0", STR_PAD_LEFT);
									    		                  $code =$rowd['d_ac_bed']; 
									    		                  $a='000000';  
									    		                   
									    		                  $doc_t_name=str_replace("ي","ي",$rowdt['docp_name']);
									    		                  $sh='/ سند از نوع  '.$doc_t_name.'';  
									    		                  $ph='/پيش حواله  '.$rowpf['pf_ph_code'].'';
									    		                   // $code = str_replace( "c", $h_customer_code, $code ); 
									    		                    $code = str_replace( "g", $h_price_code, $code );
									    		                    $code = str_replace( "a", $operation_code, $code ); 
							    		                            $d_ac_bed_dis=str_replace("ي","ي",$rowd['d_ac_bed_dis']); 
							    		                            $dpf_sarresid =str_replace("/","",$rowdpf['dpf_sarresid']);
							    		                            $ope1='000301';
							    		                            $dpf_num='0';
							    		                            $d_ac_bed_disf=''.$rowdpf['dpf_num'].'بابت دريافت چک به شماره ';
							    		                            $d_ac_bed_diss='بابت تحويل چک خريد مدت دار';
							    		                            $d_ac_bes_disl='بابت چک خريد مدت دار';
							    		                             $d_ac_bes_disl=str_replace("ي","ي",$d_ac_bes_disl);
		                                                               $d_ac_bed_diss=str_replace("ي","ي",$d_ac_bed_diss); 
		                                                               $d_ac_bed_disf=str_replace("ي","ي",$d_ac_bed_disf);     
							    		                             
							    		                         //  $out4 .='100;'. $year_number .''.$month_number.';'. $year_number .''.$month_number.''.$day_number.';'.$code.''.$dpf_sarresid.''.$h_customer_code.''.$a.''.$ope1.';'.$dpf_price.';'. 0 .';'. 1 .';'.$d_ac_bed_disf.''.$ph.''. $gh .''. $sh .';'.$rowdpf['dpf_type'].';'. $dpf_num .';'.  $dpf_sarresid .';'. $rowh['h_pre_amount'] .'';    
							    		                         // $out4 .= "\n"; 
							    		                      //jadid
							    		                        //   $out4 .='100;'. $year_number .''.$month_number.';'. $year_number .''.$month_number.''.$day_number.';301001'.$h_customer_code.''.$a.''.$a.''.$ope1.';'.$dpf_price.';'. 0 .';'. 1 .';'.$d_ac_bed_diss.''.$ph.''. $gh .''. $sh .';'.$rowdpf['dpf_type'].';'. $dpf_num .';'.  $dpf_sarresid .';'. $rowh['h_pre_amount'] .'';    
							    		                        //   $out4 .= "\n"; 
							    		                        //  $out4.='100;'. $year_number .''.$month_number.';'. $year_number .''.$month_number.''.$day_number.';303001'.$h_customer_code.''.$a.''.$a.''.$ope1.';'. 0 .';'.$dpf_price.';'. 2 .';'.$d_ac_bes_disl.''.$sh.'/'.$fh.'/'.$fph.''.$gh.';'. 4 .';'. $dpf_num .';'. $year_code .''.$date[1].''.$date[0] .';'. $h_amount .'';	
							    		                         //  $out4 .= "\n";
							    		                   		
							    		                   	}else if($rowd['d_pardakht_t']==4){
							    		                  //modatdar 		 
							    		                   		
							    		                   		$ope=$operation_code ;
							    		                   		
							    		                   		  $h_customer_code= str_pad($rowh['h_customer_code'], 6, "0", STR_PAD_LEFT);
							    		                   		  $h_price_code= str_pad($rowh['h_price_code'], 6, "0", STR_PAD_LEFT);
							    		                   		  $ope1= str_pad($ope, 6, "0", STR_PAD_LEFT);
									    		                  $code =$rowd['d_ac_bed']; 
									    		                  $a='000000';  
									    		                   
									    		                  $doc_t_name=str_replace("ي","ي",$rowdt['docp_name']);
									    		                  $sh='/ سند از نوع  '.$doc_t_name.'/پيش فاكتور شماره '.$pf_code.'/';  
									    		                  $ph='/پيش حواله  '.$rowpf['pf_ph_code'].'';
									    		                   // $code = str_replace( "c", $h_customer_code, $code ); 
									    		                    $code = str_replace( "g", $h_price_code, $code );
									    		                    $code = str_replace( "a", $operation_code, $code ); 
							    		                            $d_ac_bed_dis=str_replace("ي","ي",$rowd['d_ac_bed_dis']); 
							    		                            $dpf_sarresid =str_replace("/","",$rowdpf['dpf_sarresid']);
							    		                            $ope1='000301';
							    		                            $dpf_num='0';
							    		                            $d_ac_bed_disf='بابت دريافت چک به شماره ';
							    		                            $d_ac_bed_disf .=$rowdpf['dpf_num'];
							    		                            $d_ac_bed_diss='بابت تحويل چک خريد مدت دار';
							    		                            $d_ac_bes_disl='بابت چک خريد مدت دار';
							    		                            $d_ac_bed_disf=str_replace("ي","ي",$d_ac_bed_disf); 					    		                            
							    		                            
							    		                            $out .='100;'. $year_number .''.$month_number.';'. $year_number .''.$month_number.''.$day_number.';'.$code.''.$dpf_sarresid.''.$h_customer_code.''.$a.''.$ope1.';'.$dpf_price.';'. 0 .';'. 1 .';'.$ph.''. $sh .'/'.$d_ac_bed_disf.';'.$rowdpf['dpf_type'].';'. $dpf_num .';'.  $dpf_sarresid .';'. $rowh['h_pre_amount'] .'';    
							    		                           $out .= "\n"; 
							    		                     // jadid
							    		                    
							    		                         $out .='100;'. $year_number .''.$month_number.';'. $year_number .''.$month_number.''.$day_number.';301001'.$h_customer_code.''.$a.''.$a.''.$ope1.';'.$dpf_price.';'. 0 .';'. 1 .';'.$ph.''. $gh .''. $sh .';'.$rowdpf['dpf_type'].';'. $dpf_num .';'.  $dpf_sarresid .';'. $rowh['h_pre_amount'] .'';    
							    		                          $out .= "\n"; 
							    		                        
							    		                           $out .='100;'. $year_number .''.$month_number.';'. $year_number .''.$month_number.''.$day_number.';301001'.$h_customer_code.''.$a.''.$a.''.$ope1.';'. 0 .';'.$dpf_price.';'. 2 .';'.$sh.'/'.$fh.'/'.$fph.''.$gh.';'. 4 .';'. $dpf_num .';'. $year_code .''.$date[1].''.$date[0] .';'. $h_amount .'';	
							    		                           $out .= "\n";
							    		                   		
							    		                   	}
						    		                   	else if($rowd['d_pardakht_t']==5){
						    		                   		//fimabein shahrestan
						    		                   		//echo $pf_code;
						    		                   		//echo '/';
						    		                   		
						    		                   			$queryhf = "
																	 SELECT *  FROM dm_pf_document 			 
																	 WHERE 
																	 	dpf_pf_code = '".$pf_code."'
																	 and
																	dpf_id_province=".$id_province.""; 	
																	 	
									    		                    	    		                  	    		                     
							    		                   	$lnkhf= mysql_query($queryhf);
							    		                   	$rowhf = mysql_fetch_assoc($lnkhf);
							    		                  // 	print $queryhf;
							    		                   	$querydps = "
																	 SELECT *  FROM dm_prov_sanad			 
																	 WHERE 
																	 	dps_id = '".$rowhf['dpf_prov_sanad']."'
																	 "; 	
																	 	
									    		             //  print $querydps;   	    		                  	    		                     
							    		                   	$lnkhdps= mysql_query($querydps);
							    		                   	$rowdps = mysql_fetch_assoc($lnkhdps);
		
						    		                   		$lnkhp = mysql_query("select * from dm_product product
																	      left join dm_price price
																		   on product.p_id=price.price_p_id
																		 left join dm_prod_det_t prod_t on prod_t.type_prod_id=product.p_type
																			 WHERE p_code=".$rowh['h_p_code']." AND p_price_code=".$rowh['h_price_code']."
																			 AND
																			  price_id_province=".$id_province."");
												                             $rowhp = mysql_fetch_assoc($lnkhp);
		//										                        echo "select * from dm_product product
		//															      left join dm_price price
		//																   on product.p_id=price.price_p_id
		//																 left join dm_prod_det_t prod_t on prod_t.type_prod_id=product.p_type
		//																	 WHERE p_code=".$rowh['h_p_code']." AND p_price_code=".$rowh['h_price_code']."
		//																	 AND
		//																	  price_id_province=".$id_province."";
							    		                   		 //  sayer';
							    		                   		$ope=$operation_code ;
							    		                   		
							    		                   		  $h_customer_code= str_pad($rowh['h_customer_code'], 6, "0", STR_PAD_LEFT);
							    		                   		  $h_price_code= str_pad($rowh['h_price_code'], 6, "0", STR_PAD_LEFT);
							    		                   		  $ope1= str_pad($ope, 6, "0", STR_PAD_LEFT);
									    		                  $code =$rowd['d_ac_bed']; 
									    		                  $a='000000';  
									    		                   
									    		                  $doc_t_name=str_replace("ي","ي",$rowdt['docp_name']);
									    		                  $sh='/پيش فاكتور شماره '.$pf_code.'/پيش حواله  '.$rowph['ph_code'].'';  
									    		                   // $code = str_replace( "c", $h_customer_code, $code ); 
									    		                    $code = str_replace( "g", $h_price_code, $code );
									    		                    $code = str_replace( "a", $operation_code, $code ); 
							    		                            $d_ac_bed_dis=str_replace("ي","ي",$rowd['d_ac_bed_dis']); 
							    		                            $dpf_sarresid =str_replace("/","",$rowdpf['dpf_sarresid']);
							    		                            $ope1='000301';
		                                                            $sharh='بابت تحويل ';
		                                                            $sharh .=$rowh['h_amount'];
		                                                            $sharh .=' کيلوگرم';
		                                                            $sharh=str_replace("ي","ي",$sharh);
		                                                            //  echo $rowhp['type_prod_code'];
		                                                            $type_prod_code= str_pad($rowhp['type_prod_code'], 6, "0", STR_PAD_LEFT);
		                                                                                                               
							    		                           $out .='100;'. $year_number .''.$month_number.';'. $year_number .''.$month_number.''.$day_number.';'.$code.''.$rowdps['dps_code'].''.$type_prod_code.''.$h_price_code.''.$a.''.$ope1.';'.$dpf_price.';'. 0 .';'. 1 .';'.$sharh.''. $sh .';'.$rowdpf['dpf_type'].';'. $dpf_num .';'.  $dpf_sarresid .';'. $rowh['h_pre_amount'] .'';    
		                                                              
							    		                           $out .= "\n"; 
							    		                           
							    		                           $out .='100;'. $year_number .''.$month_number.';'. $year_number .''.$month_number.''.$day_number.';301001'.$rowh['h_customer_code'].''.$a.''.$a.''.$ope1.';'.$dpf_price.';'. 0 .';'. 1 .';'.$d_ac_bed_dis.''.$ph.''. $gh .''. $sh .';'.$rowdpf['dpf_type'].';'. $dpf_num .';'.  $dpf_sarresid .';'. $rowh['h_pre_amount'] .'';    
							    		                           
							    		                           $out .= "\n"; 
							    		                           $out .='100;'. $year_number .''.$month_number.';'. $year_number .''.$month_number.''.$day_number.';301001'.$rowh['h_customer_code'].''.$a.''.$a.''.$ope1.';'. 0 .';'.$dpf_price.';'. 2 .';'.$d_ac_bes_dis.''.$sh.'/'.$fh.'/'.$fph.''.$gh.';'. 4 .';'. $dpf_num .';'. $year_code .''.$date[1].''.$date[0] .';'. $h_amount .'';	
							    		                           $out .= "\n";
							    		                   		
							    		                   	}
						    		                   	else if($rowd['d_pardakht_t']==6){
						    		                   		//fimabein markaz
							    		                   		
							    		                   			    		
						    		                   			$queryhf = "
																	 SELECT *  FROM dm_pf_document 			 
																	 WHERE 
																	 	dpf_pf_code = '".$pf_code."'
																	 and
																	dpf_id_province=".$_SESSION['dm_user_profile']['u_province_id'].""; 	
																	 	
									    		                    	    		                  	    		                     
							    		                   	$lnkhf= mysql_query($queryhf);
							    		                   	$rowhf = mysql_fetch_assoc($lnkhf);
							    		                   	$querydps = "
																	 SELECT *  FROM dm_prov_sanad			 
																	 WHERE 
																	 	dps_id = '".$rowhf['dpf_prov_sanad']."'
																	 "; 	
																	 	
									    		           //  print $querydps;       	    		                  	    		                     
							    		                   	$lnkhdps= mysql_query($querydps);
							    		                   	$rowdps = mysql_fetch_assoc($lnkdps);
		
						    		                   		$lnkhp = mysql_query("select * from dm_product product
																	      left join dm_price price
																		   on product.p_id=price.price_p_id
																		 left join dm_prod_det_t prod_t on prod_t.type_prod_id=product.p_type
																			 WHERE p_code=".$rowh['h_p_code']." AND p_price_code=".$rowh['h_price_code']."
																			 AND
																			  price_id_province=".$_SESSION['dm_user_profile']['u_province_id']."");
												                             $rowhp = mysql_fetch_assoc($lnkhp);
							    		                   		 //  sayer';
							    		                   		$ope=$operation_code ;
							    		                   		
							    		                   		  $h_customer_code= str_pad($rowh['h_customer_code'], 6, "0", STR_PAD_LEFT);
							    		                   		  $h_price_code= str_pad($rowh['h_price_code'], 6, "0", STR_PAD_LEFT);
							    		                   		  $ope1= str_pad($ope, 6, "0", STR_PAD_LEFT);
									    		                  $code =$rowd['d_ac_bed']; 
									    		                  $a='000000';  
									    		                   
									    		                  $doc_t_name=str_replace("ي","ي",$rowdt['docp_name']);
									    		                  $sh='/ سند از نوع  '.$doc_t_name.'/پيش فاكتور شماره '.$pf_code.'/شماره فيش '.$rowdpf['dpf_num'].'/پيش حواله  '.$rowph['ph_code'].'';  
									    		                   // $code = str_replace( "c", $h_customer_code, $code ); 
									    		                    $code = str_replace( "g", $h_price_code, $code );
									    		                    $code = str_replace( "a", $operation_code, $code ); 
							    		                            $d_ac_bed_dis=str_replace("ي","ي",$rowd['d_ac_bed_dis']); 
							    		                            $dpf_sarresid =str_replace("/","",$rowdpf['dpf_sarresid']);
							    		                             $ope1='000301';
		
							    		                             
							    		                           $type_prod_code= str_pad($rowhp['type_prod_code'], 6, "0", STR_PAD_LEFT);
							    		                           
							    		                           
							    		                            $out .='100;'. $year_number .''.$month_number.';'. $year_number .''.$month_number.''.$day_number.';'.$code.''.$type_prod_code.''.$h_price_code.''.$a.''.$ope1.';'.$dpf_price.';'. 0 .';'. 1 .';'.$sharh.''. $sh .';'.$rowdpf['dpf_type'].';'. $dpf_num .';'.  $dpf_sarresid .';'. $rowh['h_pre_amount'] .'';    
		                                                              
							    		                           $out .= "\n"; 
							    		                           
							    		                           $out .='100;'. $year_number .''.$month_number.';'. $year_number .''.$month_number.''.$day_number.';301001'.$rowh['h_customer_code'].''.$a.''.$a.''.$ope1.';'.$dpf_price.';'. 0 .';'. 1 .';'.$d_ac_bed_dis.''.$ph.''. $gh .''. $sh .';'.$rowdpf['dpf_type'].';'. $dpf_num .';'.  $dpf_sarresid .';'. $rowh['h_pre_amount'] .'';    
							    		                           
							    		                           $out .= "\n"; 
							    		                           $out .='100;'. $year_number .''.$month_number.';'. $year_number .''.$month_number.''.$day_number.';301001'.$rowh['h_customer_code'].''.$a.''.$a.''.$ope1.';'. 0 .';'.$dpf_price.';'. 2 .';'.$d_ac_bes_dis.''.$sh.'/'.$fh.'/'.$fph.''.$gh.';'. 4 .';'. $dpf_num .';'. $year_code .''.$date[1].''.$date[0] .';'. $h_amount .'';	
							    		                           $out  .= "\n";
							    		                   		
							    		                   	}
					    		                   	
										
				//mishe bedehkar baraye bank  		                   	
					    		                 						
				//end of while avali  baraye havale
						      	               }
				                         }
	
	$h_malicode= add2acc($out , ';'  , ' 99'  , $_SESSION['dm_user_profile']['u_province_id'], '94' , '70');
	
	
	 $query = "
					UPDATE dm_havale 
					SET 
						
						`h_malicode` = '". $h_malicode ."'			
					 WHERE 
						h_id = ". $h_id ."";				
						$lnk = mysql_query($query);
						if(mysql_error()) print mysql_error();
	
	
	
	//sanad mali
		
		
		
		
		
		
		
		
		
		
		
		
		
		
//1 update check price in dm_pish_factor
      $pf_price_check =$rowp['pf_price_check']-$phd_price;
      echo $pf_price_check ;
      
      $query = "
		UPDATE dm_pish_factor 
		SET 
			`pf_price_check` = '".$pf_price_check."'
			
		WHERE 
			  pf_code=".$pf_code."
	    AND
		     pf_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
		AND   pf_id_year=".$_SESSION['dm_user_profile']['u_year_id']."";
	
	
	$lnk = mysql_query($query);
	sqlErr('update price check');
    print  $query  ;               
//1 ta enja	
//2 update phd_status=1
  $query = "
			UPDATE dm_pish_havale_det 
			SET 
				
				`phd_status` = '". 1 ."'			
			 WHERE 
				phd_id = ". $phd_id."";				
				$lnk = mysql_query($query);
				if(mysql_error()) print mysql_error();
// print  $query  ;
//2 ta enja
		}
		}
		else{
			$message='لطفا اطلاعات اسناد را وارد كنيد';
			$status=0;
		}
		}
	
		else{
			$status=3;
			$message="ابتدا پيش فاكتور را ثبت كنيد!";
		}
		
	    $GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$message.';'.$h_ph_code.';'.$h_code.';'.$h_id.';'.$status.';'.$phd_id.';';
}

function addNewFactor(){
	
   $ph_code=$_REQUEST['ph_code'];  
   $query2 = "SELECT * FROM dm_pish_factor 
                WHERE
                     pf_ph_code=".$ph_code." 
	            
	            AND 
	                 pf_id_year=".$_SESSION['dm_user_profile']['u_year_id']."
	            AND 
	                 pf_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
	                AND
		    pf_type=". 0 ." 
	                 
	                 
	                 ";
                             
     $lnk2 = mysql_query($query2);
     $row2= mysql_fetch_assoc($lnk2);
     sqlErr('newfactor1');
     print $query2;
     $pf_code=$row2['pf_code'];
 //check mikone aslan kalae hast ke bekhad factor  bezane ya na
     $queryh = "SELECT * FROM dm_havale 
                WHERE
                    h_pf_code=".$pf_code." 	         
	            AND 
	                h_id_year=".$_SESSION['dm_user_profile']['u_year_id']."
	            AND 
	                h_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
	            AND 
	                h_f_status=". 0 ." ";
			              
print $queryh ;                           
		     $lnkh = mysql_query($queryh);		    
		     if(mysql_num_rows($lnkh)>0){		     	
		     $rowh=mysql_fetch_assoc($lnkh1);    
     		    
 // print  $query;  
      $query6 = "SELECT * FROM dm_factor 
                WHERE
                   f_pf_code=".$pf_code." 
	            
	            AND 
	              f_id_year=".$_SESSION['dm_user_profile']['u_year_id']."
	            AND 
	              f_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
	              AND
	              f_status_ebtal=". 0 ."
	              ";
                             
      $lnk6 = mysql_query($query6 );
      print $query6;
 //check mikone aya ghablan master factori zade hsode ya na    
     if(mysql_num_rows($lnk6)==0){
				     	 $row6= mysql_fetch_assoc($lnk6);
				       
						    $queryf="SELECT MAX(f_code) maxId FROM dm_factor 
						            WHERE
						               f_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
								     ";
						            
				//	print	$queryf ;   
							$lnkf=mysql_query($queryf);
							print mysql_error();
							$rowf=mysql_fetch_assoc($lnkf);
							$f_code=$rowf['maxId']+1;
					     
					       $query1 = array(
								
							    'f_reg_date'=> gmdate('Y-m-d'),
					            'f_code'=>     $f_code,
					            'f_pf_code'=>     $pf_code,
					            
					            'f_id_province' => $_SESSION['dm_user_profile']['u_province_id'],
					            'f_id_year' => $_SESSION['dm_user_profile']['u_year_id'], 
							);
							
						   $query1 = inserterQMaker('dm_factor', $query1);
					print $query1;
					       $lnk1 = mysql_query($query1);
					        if(mysql_error()) print mysql_error();
					       $f_id = mysql_insert_id();
		     }else{
		     	 
				     	$row6= mysql_fetch_assoc($lnk6);
				     	$f_id=$row6['f_id'];
		     }
		              	
     		$queryh = "SELECT * FROM dm_havale 
		                WHERE
		                    h_pf_code=".$pf_code." 	         
			            AND 
			                h_id_year=".$_SESSION['dm_user_profile']['u_year_id']."
			            AND 
			                h_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
			            AND 
			                h_f_status=". 0 ." 
			              ";
//print $queryh ;                           
		     $lnkh = mysql_query($queryh);		    
		     while($rowh=mysql_fetch_assoc($lnkh)){
		     	
				     $query1 = array(
				     						
					    'fd_reg_date'=>   gmdate('Y-m-d'),
			            'fd_f_id'=>       $f_id,
			            'fd_h_id'=>       $rowh['h_id'],
			            'fd_province_id' => $_SESSION['dm_user_profile']['u_province_id'],
			            'fd_year_id' => $_SESSION['dm_user_profile']['u_year_id'],
				        'fd_status' => 0 , 
				        'fd_u_id' => $_SESSION['dm_user_profile']['u_id'],
					);
						
					   $query1 = inserterQMaker('dm_factor_det', $query1);
//print	$query1;				   
				       $lnk1 = mysql_query($query1);
				        if(mysql_error()) print mysql_error();
				         $fd_id = mysql_insert_id();
				         
	         $query = "
						UPDATE dm_havale
						SET 
							`h_f_status` = '". 1 ."'
																						
						WHERE 
							h_id = ".$rowh['h_id']." ";
					
			$lnk = mysql_query($query);
			print $query ;
			if(mysql_error()) print mysql_error();
		     			     			     
		            }
		     }else{
		     	$status=3;
		     }
	    $GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$f_id.';'.$pf_code.';'.$ph_code.';'.$status.';';
		            	    
}

function Ebtal_createNewh(){
	
$h_code=$_REQUEST['h_code'];
$pf_code=$_REQUEST['pf_code'];

$querypf="SELECT * FROM dm_pish_factor 
	    WHERE
	       pf_code=".$pf_code."
	     AND 
		  pf_id_year=".$_SESSION['dm_user_profile']['u_province_id']." 
		  AND
		    pf_type=". 0 ."
		  
		  ";
	    
	$lnkpf=mysql_query($querypf);	
	print mysql_error();	
	$rowpf=mysql_fetch_assoc($lnkpf);




$queryh="SELECT * FROM dm_havale 
	    WHERE
	    h_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
	     AND 
		 h_id_year=".$_SESSION['dm_user_profile']['u_year_id']."
	  ";
	
  
	$lnkh=mysql_query($queryh);	
	print mysql_error();
	if(mysql_num_rows($lnkh)==0){
		$query1 = "SELECT * FROM  dm_year where
            year_status=1 ";	
		$lnk1 = mysql_query($query1);
	//	print $query1;
		$row1= mysql_fetch_assoc($lnk1);
		$year_code=$row1['year_code'];
	    $h_code=$year_code.'000000';
	
	}else{

	$query="SELECT MAX(h_code) maxId FROM dm_havale 
	    WHERE
	    h_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
	     AND 
		 h_id_year=".$_SESSION['dm_user_profile']['u_year_id']."
	  ";
	
  print $query;  
	$lnk=mysql_query($query);	
	print mysql_error();
	
	$row=mysql_fetch_assoc($lnk);
	$h_code=$row['maxId'];
	}
	$h_code=$h_code+1;
	$querys = "
			 	SELECT *  FROM dm_signature_g 
		 
				WHERE 
					sig_status = ". 1 ." 
				AND
				   sig_id_province=".$_SESSION['dm_user_profile']['u_province_id']  ."
				
			";
			$lnks = mysql_query($querys);
			$rows= mysql_fetch_assoc($lnks);
if($_SESSION['dm_user_profile']['u_year_id']==100)
				{
					$year_id=$_SESSION['dm_user_profile']['year_id'];
					
				}else{
					
					$year_id=$_SESSION['dm_user_profile']['u_year_id'];
				}
$query = array(
			
		    'h_reg_date'=> gmdate('Y-m-d'),
            'h_pf_code'=>  $pf_code,
            'h_code'=>  $h_code, 
            'h_status'=>  '0',
            'h_id_province' => $_SESSION['dm_user_profile']['u_province_id'], 
            'h_id_year' => $year_id, 
           'h_sig_id' => $rows['sig_id'],
		);		
		$query = inserterQMaker('dm_havale', $query);
		$lnk = mysql_query($query);
		if(mysql_error()) print mysql_error();
		$h_id = mysql_insert_id();
		
		$query = "
			UPDATE dm_pish_havale_det 
			SET 
				
				`phd_status` = '". 1 ."'			
			 WHERE 
				phd_ph_code = ". $rowpf['pf_ph_code']."
				
				AND
			phd_id_province=". $_SESSION['dm_user_profile']['u_province_id']."
				";				
				$lnk = mysql_query($query);
				if(mysql_error()) print mysql_error();
		
		
		$message=' حواله شماره'.$h_code.'ابطال شد';
		$message .='وحواله جدید ایجاد شد';
				
	$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$h_id.';'.$pf_code.';'.$message.';'.$h_code.';';
		
}
function EbtalHavaleNotNew(){
	
$h_id=$_REQUEST['h_id'];
$pf_code=$_REQUEST['pf_code'];
$ph_code=$_REQUEST['ph_code'];
$ebh_reb_id=$_REQUEST['ebh_reb_id'];

$query = "
		SELECT * FROM dm_havale 
		
		WHERE 
			h_id = ".$h_id." 

	";
	$lnk1 = mysql_query($query);
	$row1= mysql_fetch_assoc($lnk1);
$h_customer_code=	$row1['h_customer_code'];
$query = "
		UPDATE dm_havale 
		SET 
			`h_status` = '1',
			`h_ebtal_date`= '".gmdate("Y-m-d")."'	
		WHERE 
			h_id = ".$h_id." 
	";
   
	$lnk = mysql_query($query);
	print $query;	
	if(mysql_error()) print mysql_error();
	$h_id=$row1['h_id'];
	$querypf = "
		UPDATE dm_pish_factor
		SET 
			`pf_status_ebtal` = '1'
				
		WHERE 
			pf_code = ".$row1['h_pf_code']." 
		AND
		   pf_id_province='".$_SESSION['dm_user_profile']['u_province_id']."'
	";
   
	$lnkpf = mysql_query($querypf);	
	if(mysql_error()) print mysql_error();
	print $querypf;
	$queryph = "
		UPDATE dm_pish_havale
		SET 
			`ph_status_ebtal` = '1'
				
		WHERE 
			ph_code = ".$ph_code." 
		AND
		   ph_id_province='".$_SESSION['dm_user_profile']['u_province_id']."'
	";
   
	$lnkph = mysql_query($queryph);	
	if(mysql_error()) print mysql_error();
	
		 	
    	$queryeb="SELECT MAX(ebh_code) maxId FROM dm_ebtal_h
						         WHERE
						           ebh_id_province=".$_SESSION['dm_user_profile']['u_province_id']." ";       
						$lnkeb=mysql_query($queryeb);
						print mysql_error();
						print $queryeb;
						$roweb=mysql_fetch_assoc($lnkeb);
						$ebh_code=$roweb['maxId']+1;
						
						  if ($row1['h_id_year']==4	){
                                  	
                                 // 	$norozdate='2015-03-20';
                                  	$norozdate=gmdate('Y-m-d');
                                  }	else{
                                  	
                                  		$norozdate=gmdate('Y-m-d');
                                  	
                                  }	
if($_SESSION['dm_user_profile']['u_year_id']==100)
				{
					$year_id=$_SESSION['dm_user_profile']['year_id'];
					
				}else{
					
					$year_id=$_SESSION['dm_user_profile']['u_year_id'];
				}

	$query = array(
		
		'ebh_reg_date' => $norozdate,
		'ebh_h_id' => $h_id,
     	'ebh_code' => $ebh_code,
	    'ebh_type' => 1,
	    'ebh_customer_code' => $h_customer_code,
		'ebh_id_province' => $_SESSION['dm_user_profile']['u_province_id'],
     	'ebh_id_year' =>     $year_id,
		'ebh_reb_id' =>     $ebh_reb_id,
	    'ebh_reg_time' =>   gmdate("Y-m-d H:i",time()+12600),
	    'ebh_u_id' =>        $_SESSION['dm_user_profile']['u_id']
	   	   
     	);

	$query = inserterQMaker('dm_ebtal_h', $query);
	$lnk = mysql_query($query);
	$ebh_id = mysql_insert_id();
//	print $query;
$message=' ابطال شماره'. $ebh_code .' ';
	if(mysql_error()) print mysql_error();
	$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$row1['h_id'].';'.$pf_id.';'.$ph_code.';'. $message.';'.$h_id.';'.$ebh_id .';';
	
}
function check(){
	$p_iran_code=$_REQUEST['p_iran_code'];
	$query = "dm_product product
			left join dm_price price
					on product.p_id=price.price_p_id
					 WHERE p_iran_code=".$p_iran_code." 
					 AND
					  price_id_province=".$_SESSION['dm_user_profile']['u_province_id']."";
			
		$lnk = mysql_query($query);
		if(mysql_num_rows($lnk)>0){
		$message="ایران کد تکراری است";
		$status=1;
		}else{

			$status=0;
		}
	
	$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$message.';'.$status.';';
	
}
function AddAMenuToList(){
	
    $rel_menu_id=$_REQUEST['rel_menu_id'];
    $rel_ug_id=$_REQUEST['rel_ug_id'];

    $query = "SELECT * FROM dm_list_group_rel WHERE rel_menu_id=".$rel_menu_id." 
              AND rel_ug_id=".$_SESSION['ug_id']."";
  
		$lnk = mysql_query($query);
		if(mysql_num_rows($lnk)>0){
			
		$status= 2;
	   	$message='قبلا به لیست منو ها اضافه شده است';
	}
		else{
				$status= 1;
	$query = array(
			
		    'rel_menu_id'=> $rel_menu_id,
	        'rel_ug_id'=> $rel_ug_id,           
		);
		
		$query = inserterQMaker('dm_list_group_rel ', $query);
		print $query;
		$lnk = mysql_query($query);
		if(mysql_error()) print mysql_error();
		$rel_id = mysql_insert_id();
		}
		$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$message.';'.$status .';'.$rel_menu_id .';'.$rel_ug_id .';';
}

function AddAllMenuToList(){
	
    $rel_ug_id=$_REQUEST['rel_ug_id'];
    $u_id=$_REQUEST['u_id'];   
    $query = "SELECT *  FROM dm_listmenu ";		 							
		$lnk1 = mysql_query($query);
		sqlErr('AddAllMenuToList');
		while($row1= mysql_fetch_assoc($lnk1)){

			    $query = "SELECT * FROM dm_list_group_rel WHERE rel_menu_id=".$row1['menu_id']." 
			                AND
			               rel_ug_id=". $rel_ug_id."";
			  
					$lnk = mysql_query($query);
					if(mysql_num_rows($lnk)>0){						
					
				}
					else{
							$status= 1;
				$query = array(
						
					    'rel_menu_id'=> $row1['menu_id'],
				        'rel_ug_id'=> $rel_ug_id,           
					);
					
					$query = inserterQMaker('dm_list_group_rel ', $query);
					print $query;
					$lnk = mysql_query($query);
					if(mysql_error()) print mysql_error();
					$rel_id = mysql_insert_id();
//baraye dadn dasteresi edit					
					$query = "
							UPDATE  dm_um_rel
							SET 
								`um_can_edit` = '". 1 ."'
										
							WHERE 
								  um_u_id=".$u_id."
							 AND
								um_menu_id = ".$row1['menu_id'].""; 				    
						$lnk = mysql_query($query);
						if(mysql_error()) print mysql_error();
//baraye dadane dastresi delete
					$query = "
							UPDATE  dm_um_rel
							SET 
								`um_can_delete` = '". 1 ."'
										
							WHERE 
								  um_u_id=".$u_id."
							 AND
								um_menu_id = ".$row1['menu_id']." 
						";
						$lnk = mysql_query($query);
						if(mysql_error()) print mysql_error();
					}
		}
		$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$rel_ug_id.';'.$u_id.';';
	
}
function addloc(){
	
    $chl_ch_id=$_REQUEST['chl_ch_id'];
    $chl_l_id=$_REQUEST['chl_l_id'];
	
	$query = array(
			
		    'chl_ch_id'=> $chl_ch_id,
	        'chl_l_id'=> $chl_l_id,
	        'chl_reg_date'=> gmdate('Y-m-d'),
	        'chl_id_province'=> $_SESSION['dm_user_profile']['u_province_id']           
		);
		print $query;
		$query = inserterQMaker('dm_loc_ch ', $query);
		print $query;
		$lnk = mysql_query($query);
		if(mysql_error()) print mysql_error();
		$h_id = mysql_insert_id();

		$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'. $chl_ch_id.';'.$chl_l_id .';';
	
}
function addoper(){
	 $oph_ch_id=$_REQUEST['oph_ch_id'];
    $oph_op_id=$_REQUEST['oph_op_id'];
	
	$query = array(
			
		    'oph_ch_id'=> $oph_ch_id,
	        'oph_op_id'=> $oph_op_id,
	        'oph_reg_date'=> gmdate('Y-m-d'),
	        'oph_id_province'=> $_SESSION['dm_user_profile']['u_province_id']           
		);
		print $query;
		$query = inserterQMaker('dm_opr_ch ', $query);
		print $query;
		$lnk = mysql_query($query);
		if(mysql_error()) print mysql_error();
		$h_id = mysql_insert_id();

		$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'. $oph_ch_id.';'.$oph_op_id .';';
	
}
function Addprodv(){
	$p_id=$_REQUEST['p_id'];
	$query = "
							UPDATE  dm_listprod
							SET 
								`p_status` = '". 1 ."'
										
							WHERE 
								 p_id=".$p_id."
							 
						";
						$lnk = mysql_query($query);
						if(mysql_error()) print mysql_error();
	
	$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$p_id.';';
	
}
function delprodv(){
	
	$p_id=$_REQUEST['p_id'];
	echo $p_id;
	
	$query = "
							UPDATE  dm_listprod
							SET 
								`p_status` = '". 0 ."'
										
							WHERE 
								 p_id=".$p_id."
							 
						";
	print $query;
						$lnk = mysql_query($query);
						if(mysql_error()) print mysql_error();
	
	$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$p_id.';';
	
}

function delAdetanbar(){
	
     $dad_anbar_id=$_REQUEST['dad_anbar_id'];
     $dad_phd_id=$_REQUEST['dad_phd_id'];
     $dad_tedad=$_REQUEST['dad_tedad'];
     $dad_vazn_n=$_REQUEST['dad_vazn_n'];
     $dad_vazn_kh=$_REQUEST['dad_vazn_kh'];
     $p_pakage_type=$_REQUEST['p_pakage_type'];
     
     
   
			
			
			$queryphd="SELECT * FROM dm_pish_havale_det  WHERE phd_id=".$dad_phd_id."   ";
										        
			$lnkphd = mysql_query($queryphd);
			$rowphd = mysql_fetch_assoc($lnkphd);
			
			 $query1="SELECT * FROM dm_havale WHERE h_phd_id=".$dad_phd_id."   ";
										        
			$lnk1 = mysql_query($query1);
			$row1 = mysql_fetch_assoc($lnk1);
			
		//	(mysql_affected_rows()>0) AND ($_SESSION['dm_user_profile']['u_province_id'] ==3)
			if((mysql_affected_rows()>0) AND ($_SESSION['dm_user_profile']['u_province_id'] ==3)){
				
				$status=1;
     	
     	
     $message='برای این کالا حواله زده شده و نمیتوانید تغییر دهید';
				
			}else{
          	
   
    
 //update anbar

     
   $queryg="select * FROM dm_anbar_det WHERE  dad_anbar_id = ".$dad_anbar_id."  and
		   dad_phd_id=".$dad_phd_id."";					     
										        
			$lnkg = mysql_query($queryg);
			$rowg = mysql_fetch_assoc($lnkg);
  //echo $queryg;
  
  
       
     $querya="select * from meat.mojody_kala 
  					where
  					     id=".$dad_anbar_id."";					     
										        
			$lnka = mysql_query($querya);
			$rowa = mysql_fetch_assoc($lnka);
			
			$tedad_soldi=$rowa['tedad_sold'];
			$nakhales_soldi=$rowa['nakhales_sold'];
			$khales_soldi=$rowa['khales_sold'];
			
			echo $tedad_soldi;
			echo '/';
			echo $rowg['dad_tedad'];
			
			
			$tedad_sold=(($tedad_soldi)-($rowg['dad_tedad']));
				     	$nakhales_sold=(($nakhales_soldi)-($rowg['dad_vazn_n']));
				     	$khales_sold=(($khales_soldi)-($rowg['dad_vazn_kh']));
				     	
				     	
				     	$myconn = mysql_connect( "localhost" , "user" , "xlsdj@#@aHdF");
						mysql_query("SET NAMES 'utf8'",$myconn);
						mysql_select_db("meat",$myconn) or die("Can Not Select DataBase Because: ".
						mysql_error());
						
						if($p_pakage_type==8){
			
							  $queryanbari = "
														UPDATE mojody_kala 
															SET 			
															
																
																`tedad_sold`  = '".$tedad_sold."'			
															WHERE 
																  id=".$dad_anbar_id."
														    
															";       						
													$lnkanbari = mysql_query($queryanbari);
												//	print $queryanbari;
													
													
							
							
						}else{
							if(($rowphd['phd_pid']==50) or ($rowphd['phd_pid']==54)){
								
								
                                         $queryanbari = " 
														UPDATE mojody_kala 
															SET 			
															
																
																`tedad_sold`  = '".$tedad_sold."'			
															WHERE 
																  id=".$dad_anbar_id."
														    
															";       						
													$lnkanbari = mysql_query($queryanbari);
													print $queryanbari;
													echo 'sdf';
								
								
								
								
							}else{
							
							
							  $queryanbari = "
														UPDATE mojody_kala 
															SET 			
															
																`khales_sold` = '". $khales_sold ."'			
															WHERE 
																  id=".$dad_anbar_id."
														    
															";       						
													$lnkanbari = mysql_query($queryanbari);
													print $queryanbari;
													echo 'fgd';
													
													
							}
						}
				     	                        
     
     mysql_close();
  $myconn = mysql_connect( "localhost" , "user" , "xlsdj@#@aHdF");
						mysql_query("SET NAMES 'utf8'",$myconn);
						mysql_select_db("sell",$myconn) or die("Can Not Select DataBase Because: ".
						mysql_error());   
     
      $query = "
	  DELETE  FROM   dm_anbar_det
 
		WHERE 
		   dad_anbar_id = ".$dad_anbar_id." 
		   and
		   dad_phd_id=".$dad_phd_id."
	";
	print $query;
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();	
	
	
		$status=0;
     	
     	
     $message='حذف شد';
      mysql_close();
     
     	
     }
     
     
     
			

		$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$message.';'.$status .';'.$dad_anbar_id .'';
}
function AddAdetanbar(){
	
    $dad_anbar_id=$_REQUEST['dad_anbar_id'];
    $dad_phd_id=$_REQUEST['dad_phd_id'];
     $dad_tedad=$_REQUEST['dad_tedad'];
     $dad_vazn_n=$_REQUEST['dad_vazn_n'];
     $dad_vazn_kh=$_REQUEST['dad_vazn_kh'];
     $dad_vazn_karton=$_REQUEST['dad_vazn_karton'];
     $tedad_karton=$_REQUEST['tedad_karton'];
     $l_code=$_REQUEST['l_code'];
     
     
     $sal=$_REQUEST['sal'];
     $mah=$_REQUEST['mah'];
     $rooz=$_REQUEST['rooz'];
     
     
 $query1="SELECT * FROM dm_pish_havale_det WHERE phd_id=".$dad_phd_id."   ";
										        
			$lnk1 = mysql_query($query1);
			$row1 = mysql_fetch_assoc($lnk1);
	//
	$queryprod = "select * from dm_product product
			left join dm_price price
			on product.p_id=price.price_p_id
		           WHERE `p_code`='".$row1['phd_pid']."'  AND `p_price_code` =  '".$row1['phd_price_code']."'
		           AND
		            price_id_province=".$phd_id_province."
		    ";
                   				       						       
				$lnkprod = mysql_query($queryprod);
				$rowprod= mysql_fetch_assoc($lnkprod);		
			
			
     //chek tarikh tolid

       $query="select  meat.mojody_kala.*,kala.name_kala,keshvar.name_keshvar,tolidkonande.name_tolidkonande,l_s_d.noe_ziranbar,l_s_d.name_ziranbar,karton.vazn_karton From meat.mojody_kala
		          INNER JOIN  meat.kala ON mojody_kala.code_kala=kala.code_kala
		          INNER JOIN  meat.keshvar ON mojody_kala.code_keshvar=keshvar.code_keshvar
		          LEFT  JOIN  meat.karton ON mojody_kala.code_karton=karton.code_karton 
		          INNER JOIN  meat.tolidkonande ON mojody_kala.code_tolidkonande=tolidkonande.code_tolidkonande
		          INNER JOIN  meat.list_sardkhane_detail l_s_d ON mojody_kala.code_ziranbar=l_s_d.code_ziranbar AND mojody_kala.code_ostan=l_s_d.code_ostan AND mojody_kala.code_anbar=l_s_d.code_anbar        
		          WHERE mojody_kala.code_kala='". $row1['phd_pid'] ."'  AND  mojody_kala.code_ostan='". $row1['phd_id_province'] ."'  AND mojody_kala.code_anbar='". $l_code ."'  AND  mojody_kala.year='1398'  AND mojody_kala.deleted=0 
		         
		 			
				  order by sal_tolid_shamsi,mah_tolid_shamsi,rouz_tolid_shamsi asc ";
     
	     $lnk = mysql_query($query);
	        
	     while($row = mysql_fetch_assoc($lnk)){
		 
    
    if ($rowprod['p_pakage_type']==8)
			{
			 $tedad=mojodyMojazTedad2($row['id'],$row['code_ostan'],$row['code_anbar'],$row['year'],$row['code_ziranbar'],$row['code_kala'],$row['code_keshvar'],$row['code_tolidkonande'],$row['sal_tolid_shamsi'],$row['mah_tolid_shamsi'],$row['rouz_tolid_shamsi'],$row['code_karton']);
				
		//	$no=1;	
			//$tedad_karton;
			
			}else{
				if(($rowprod['p_code']==50) or ($rowprod['p_code']==54)){
					
				$tedad=mojodyMojazShane($row['id'],$row['code_ostan'],$row['code_anbar'],$row['year'],$row['code_ziranbar'],$row['code_kala'],$row['code_keshvar'],$row['code_tolidkonande'],$row['sal_tolid_shamsi'],$row['mah_tolid_shamsi'],$row['rouz_tolid_shamsi'],$row['code_karton']);	
					
				}else{
			//	$no=2;	
				//$tedad=$mojody_khales;
		 $tedad=mojodyMojazKhales2($row['id'],$row['code_ostan'],$row['code_anbar'],$row['year'],$row['code_ziranbar'],$row['code_kala'],$row['code_keshvar'],$row['code_tolidkonande'],$row['sal_tolid_shamsi'],$row['mah_tolid_shamsi'],$row['rouz_tolid_shamsi'],$row['code_karton']);	
				
	     }	
	     
	     }	

//		echo 'tarikh';
//		echo '/';
//		echo $row['sal_tolid_shamsi'];
//		echo '/';		
//		echo $sal;
//		echo '/';
//		echo  $row['mah_tolid_shamsi'];
//		echo '/';
//		echo  $mah;
//		echo '/';
//		echo $row['rouz_tolid_shamsi'];
//		echo '/';
//		echo $rooz;
//		echo '/';
		if( ($row['sal_tolid_shamsi'])<($sal) AND  ($tedad !=0)){
			echo 'kharrr';
				$status=11;
               $message='ابتدا کالای تاریخ قبل را اضافه نمایید';
			
		}else  if((($row['sal_tolid_shamsi'])==($sal)) AND (($row['mah_tolid_shamsi'])<($mah)) AND  ($tedad !=0)){
			
			$status=11;  	
           $message='ابتدا کالای تاریخ قبل را اضافه نمایید';
			
		}else if((($row['sal_tolid_shamsi'])==($sal)) AND (($row['mah_tolid_shamsi'])==($mah)) AND(($row['rouz_tolid_shamsi'])<($rooz)) AND  ($tedad !=0)){
			
			$status=11;
	
            $message='ابتدا کالای تاریخ قبل را اضافه نمایید';
			
		}	
    
			
    
	     }
     
 
     
     $querya="select * from meat.mojody_kala 
  					where
  					     id=".$dad_anbar_id."";					     
										        
			$lnka = mysql_query($querya);
			$rowa = mysql_fetch_assoc($lnka);
			
			$tedad_soldi=$rowa['tedad_sold'];
			$nakhales_soldi=$rowa['nakhales_sold'];
			$khales_soldi=$rowa['khales_sold'];
   //  echo $tedad_soldi;
     
      $myconn = mysql_connect( "localhost" , "user" , "xlsdj@#@aHdF");
						mysql_query("SET NAMES 'utf8'",$myconn);
						mysql_select_db("sell",$myconn) or die("Can Not Select DataBase Because: ".
						mysql_error());   
     $query1="SELECT * FROM dm_pish_havale_det WHERE phd_id=".$dad_phd_id."   ";
										        
			$lnk1 = mysql_query($query1);
			$row1 = mysql_fetch_assoc($lnk1);
     
     $meghdarkol=$row1['phd_amount'];
     
//pakage-type
 $querypak="select * from dm_product product
					left join dm_price price
							on product.p_id=price.price_p_id
							 WHERE 
							     p_code=".$row1['phd_pid']." 
							    AND 
							     p_price_code=".$row1['phd_price_code']."
							    AND
							     price_id_province=".$row1['phd_id_province']."";
										        
			$lnkpak = mysql_query($querypak);
			$rowpak = mysql_fetch_assoc($lnkpak);
		
     
   
     //meghadari ke dar dm_anbar_det chek shavad
      $query2="SELECT * FROM dm_anbar_det WHERE dad_phd_id=".$dad_phd_id."   ";
										        
			$lnk2 = mysql_query($query2);
			$dad_tedadi=0;
			print $query2;
			while($row2 = mysql_fetch_assoc($lnk2))
			{
				
			
						//mohasebe tedad
	  $querya="select * from meat.mojody_kala 
  					where
  					     id=".$dad_anbar_id."";					     
										        
			$lnka = mysql_query($querya);
			$rowa = mysql_fetch_assoc($lnka);
	print $querya;	

			if($row2['dad_no']==8){
				
				$dad_tedadoo=$row2['dad_tedad'];
			}else{
				
				$dad_tedadoo=$row2['dad_vazn_kh'];
				
			}
			
			
			
			$dad_tedadi = $dad_tedadi+$dad_tedadoo;
            
			}
           $tedadforosh=$dad_tedadi+ $dad_vazn_kh;
         

//chek no

			if ($rowpak['p_pakage_type']==8)
			{
			//ghoti	
			$tedad=mojodyMojazTedad($dad_anbar_id,$rowa['code_ostan'],$rowa['code_anbar'],$rowa['year'],$rowa['code_ziranbar'],$rowa['code_kala'],$rowa['code_keshvar'],$rowa['code_tolidkonande'],$rowa['sal_tolid_shamsi'],$rowa['mah_tolid_shamsi'],$rowa['rouz_tolid_shamsi'],$rowa['code_karton']);
				
			
			
			}else{
			 $tedad=mojodyMojazKhales($dad_anbar_id,$rowa['code_ostan'],$rowa['code_anbar'],$rowa['year'],$rowa['code_ziranbar'],$rowa['code_kala'],$rowa['code_keshvar'],$rowa['code_tolidkonande'],$rowa['sal_tolid_shamsi'],$rowa['mah_tolid_shamsi'],$rowa['rouz_tolid_shamsi'],$rowa['code_karton']);		
								
			}  
			
		echo $tedadforosh;
		echo '/';
		echo $meghdarkol;
		echo '/';
		echo $dad_vazn_kh;
		echo '/';
		echo $tedad;
		$meghdarkol=urlencode($meghdarkol);
		$tedadforosh=urlencode($tedadforosh);
		 if($tedadforosh > $meghdarkol){
		 	
		 	
		 	echo 'hasttt';
		 }
         
     if(($tedadforosh>$meghdarkol) or ($dad_vazn_kh>$tedad) ){

     	$status=1;
     	
     	
     $message='شما نمیتوانید از حد مجاز بیشتر اضافه کنید';
     	
     	
     }else{
     	
     	
    echo $rowpak['p_pakage_type'];
     	
     
        if($rowpak['p_pakage_type']==5){
        	
        	
        	if(($rowpak['p_code']==50) or ($rowpak['p_code']==54)){
        		
        		echo $dad_tedad;
			 if(($dad_vazn_kh=='')or ($dad_vazn_kh==0)){
					
					$status=1;
					$message='وزن خالص وارد شود';	
			     	}else if($status==11){
			     		 $message='ابتدا کالای تاریخ قبل را اضافه نمایید';
			     	}else{
			     	$status=0;
			     	$myconn = mysql_connect( "localhost" , "user" , "xlsdj@#@aHdF");
						mysql_query("SET NAMES 'utf8'",$myconn);
						mysql_select_db("meat",$myconn) or die("Can Not Select DataBase Because: ".
						mysql_error());
 $queryaa="select * from meat.mojody_kala 
  					where
  					     id=".$dad_anbar_id."";					     
										        
			$lnkaa = mysql_query($queryaa);
			$rowaa = mysql_fetch_assoc($lnkaa);	
			$code_ziranbar=$rowaa['code_ziranbar'];   
			$code_keshvar=$rowaa['code_keshvar']; 
			$code_tolidkonande=$rowaa['code_tolidkonande']; 
			$sal_tolid_shamsi=$rowaa['sal_tolid_shamsi'];
			$mah_tolid_shamsi=$rowaa['mah_tolid_shamsi'];
			$rouz_tolid_shamsi=$rowaa['rouz_tolid_shamsi'];
			$vazn_karton_this=$rowaa['vazn_karton_this'];
//		$tedad=mojodyMojazTedad($dad_anbar_id,$rowa['code_ostan'],$rowa['code_anbar'],$rowa['year'],$rowa['code_ziranbar'],$rowa['code_kala'],$rowa['code_keshvar'],$rowa['code_tolidkonande'],$rowa['sal_tolid_shamsi'],$rowa['mah_tolid_shamsi'],$rowa['rouz_tolid_shamsi'],$rowa['code_karton']);
			
			 mysql_close() ;    	
			     	$dad_vazn_kh1=($dad_vazn_karton)*($tedad);
			     	
			     	
			     	$myconn = mysql_connect( "localhost" , "user" , "xlsdj@#@aHdF");
						mysql_query("SET NAMES 'utf8'",$myconn);
						mysql_select_db("sell",$myconn) or die("Can Not Select DataBase Because: ".
						mysql_error());
			     	
					     		$querydet = array(
								
							    'dad_anbar_id'=> $dad_anbar_id,
						        'dad_phd_id'=> $dad_phd_id,
					     		'dad_tedad'=> $dad_vazn_kh,
						        'dad_vazn_n'=> $dad_vazn_n,
					     		'dad_vazn_kh'=> $dad_vazn_kh1,
					     		'dad_vazn_karton'=> $dad_vazn_karton,
					     		'dad_no'=> $rowpak['p_pakage_type'],
					     		'dad_ziranbar'=> $code_ziranbar,
					        'dad_keshvar'=> $code_keshvar,
				     		'dad_tolidkonande'=> $code_tolidkonande,
					        'dad_sal'=> $sal_tolid_shamsi,
				     		'dad_mah'=> $mah_tolid_shamsi,
				     		'dad_rouz'=> $rouz_tolid_shamsi,
				     		'dad_vaznkarton'=> $vazn_karton_this,
					     	'dad_vazn_khanbar'=> $dad_vazn_kh1,
					     	'dad_tedad_khanbar'=> $dad_vazn_kh,
					     	
						                  
							);
							print $querydet;
							$querydet = inserterQMaker('dm_anbar_det ', $querydet);
						//	print $querydet;
							$lnkdet = mysql_query($querydet);
							if(mysql_error()) print mysql_error();
							$dad_id = mysql_insert_id();
					     	$message='اضافه شد';
					     	
					     		//update anbar
				     	mysql_close() ;
				     	
				     	$tedad_sold=(($tedad_sold)+($dad_tedad));
				     	$nakhales_sold=(($nakhales_soldi)+($dad_vazn_n));
				     	$khales_sold=(($khales_soldi)+($dad_vazn_kh));
				     	$myconn = mysql_connect( "localhost" , "user" , "xlsdj@#@aHdF");
								mysql_query("SET NAMES 'utf8'",$myconn);
								mysql_select_db("meat",$myconn) or die("Can Not Select DataBase Because: ".
								mysql_error());
				     	                          $queryanbari = "
														UPDATE mojody_kala 
															SET 			
																
																`khales_sold` = '". $khales_sold ."'			
															WHERE 
																  id=".$dad_anbar_id."
														    
															";       						
													$lnkanbari = mysql_query($queryanbari);
												print $queryanbari;
													if(mysql_error()) print mysql_error();
					     	
					     	mysql_close() ;
					     	
					     	
					     	
					     	
			     	}
        		
        		
        		
        		
        		
        		
        	}else{
        	
       
			     	//karton
			     	//if(($dad_tedad=='')or ($dad_vazn_n=='')or($dad_tedad==0)or ($dad_vazn_n==0)){
        	if(($dad_vazn_kh=='') or ($dad_vazn_kh==0)){
//					echo $dad_tedad;
//					echo '/';
//					echo $dad_vazn_n;
					
					$status=1;	
					$message='وزن خالص وارد شود';
					//$message='تعداد و وزن ناخالص وارد شود';
			     	}else if($status==11){
			     		 $message='ابتدا کالای تاریخ قبل را اضافه نمایید';
			     	}else{
			     	$status=0;
//mohasebe
//			     	       $vaznkartonha=(($dad_vazn_karton) * ($dad_tedad));
//			     	       $dad_vazn_kh=(($dad_vazn_n)-($vaznkartonha));
			
			$myconn = mysql_connect( "localhost" , "user" , "xlsdj@#@aHdF");
						mysql_query("SET NAMES 'utf8'",$myconn);
						mysql_select_db("meat",$myconn) or die("Can Not Select DataBase Because: ".
						mysql_error());	    	        
		  $queryaa="select * from meat.mojody_kala 
  					where
  					     id=".$dad_anbar_id."";					     
										        
			$lnkaa = mysql_query($queryaa);
			$rowaa = mysql_fetch_assoc($lnkaa);
			
			$code_ziranbar=$rowaa['code_ziranbar'];   
			$code_keshvar=$rowaa['code_keshvar']; 
			$code_tolidkonande=$rowaa['code_tolidkonande']; 
			$sal_tolid_shamsi=$rowaa['sal_tolid_shamsi'];
			$mah_tolid_shamsi=$rowaa['mah_tolid_shamsi'];
			$rouz_tolid_shamsi=$rowaa['rouz_tolid_shamsi'];
			$vazn_karton_this=$rowaa['vazn_karton_this'];
			
							     	mysql_close();
			
				$myconn = mysql_connect( "localhost" , "user" , "xlsdj@#@aHdF");
						mysql_query("SET NAMES 'utf8'",$myconn);
						mysql_select_db("sell",$myconn) or die("Can Not Select DataBase Because: ".
						mysql_error());	    	 
			     	 	//$dad_vazn_kh=($dad_vazn_karton)*($dad_tedad);
				     		$querydet = array(
							
						    'dad_anbar_id'=> $dad_anbar_id,
					        'dad_phd_id'=> $dad_phd_id,
				     		'dad_tedad'=> $dad_tedad,
					        'dad_vazn_n'=> $dad_vazn_n,
				     		'dad_vazn_kh'=> $dad_vazn_kh,
				     		'dad_vazn_karton'=> $dad_vazn_karton,
				     		'dad_no'=> $rowpak['p_pakage_type'],
				     		'dad_ziranbar'=> $code_ziranbar,
					        'dad_keshvar'=> $code_keshvar,
				     		'dad_tolidkonande'=> $code_tolidkonande,
					        'dad_sal'=> $sal_tolid_shamsi,
				     		'dad_mah'=> $mah_tolid_shamsi,
				     		'dad_rouz'=> $rouz_tolid_shamsi,
				     		'dad_vaznkarton'=> $vazn_karton_this,
				     		'dad_vazn_khanbar'=> $dad_vazn_kh,
				     		'dad_tedad_khanbar'=> $dad_tedad,
					                  
						);
						print $querydet;
						$querydet = inserterQMaker('dm_anbar_det ', $querydet);
					//	print $querydet;
						$lnkdet = mysql_query($querydet);
						if(mysql_error()) print mysql_error();
						$dad_id = mysql_insert_id();
				     	$message='اضافه شد';
				     	//update anbar
				     	
				     	
				     	$tedad_sold=(($tedad_soldi)+($dad_tedad));
				     	$nakhales_sold=(($nakhales_soldi)+($dad_vazn_n));
				     	$khales_sold=(($khales_soldi)+($dad_vazn_kh));
				     	mysql_close();
				     	
				     	
				     	$myconn = mysql_connect( "localhost" , "user" , "xlsdj@#@aHdF");
						mysql_query("SET NAMES 'utf8'",$myconn);
						mysql_select_db("meat",$myconn) or die("Can Not Select DataBase Because: ".
						mysql_error());
                         $queryanbari = "
							UPDATE mojody_kala 
								SET 			
									
									`khales_sold` = '". $khales_sold ."'			
								WHERE 
									  id=".$dad_anbar_id."
							    
								";       						
						$lnkanbari = mysql_query($queryanbari);
	print $queryanbari;
													if(mysql_error()) print mysql_error();
				     	
				     	mysql_close();
				     	
			     	}
        }
        
			     }else if($rowpak['p_pakage_type']==7){
			//lashe	
			     if( ($dad_vazn_kh=='')or ($dad_vazn_kh==0)){
					
					$status=1;	
					$message='وزن خالص وارد شود';
			     	}else if($status==11){
			     		 $message='ابتدا کالای تاریخ قبل را اضافه نمایید';
			     	}else{
			     	
			     	$status=0;	

			     	$myconn = mysql_connect( "localhost" , "user" , "xlsdj@#@aHdF");
						mysql_query("SET NAMES 'utf8'",$myconn);
						mysql_select_db("meat",$myconn) or die("Can Not Select DataBase Because: ".
						mysql_error());
			     	 $queryaa="select * from meat.mojody_kala 
  					where
  					     id=".$dad_anbar_id."";					     
										        
			$lnkaa = mysql_query($queryaa);
			$rowaa = mysql_fetch_assoc($lnkaa);	

			$code_ziranbar=$rowaa['code_ziranbar'];   
			$code_keshvar=$rowaa['code_keshvar']; 
			$code_tolidkonande=$rowaa['code_tolidkonande']; 
			$sal_tolid_shamsi=$rowaa['sal_tolid_shamsi'];
			$mah_tolid_shamsi=$rowaa['mah_tolid_shamsi'];
			$rouz_tolid_shamsi=$rowaa['rouz_tolid_shamsi'];
			$vazn_karton_this=$rowaa['vazn_karton_this'];
			
			  mysql_close() ;   	
			    // 	$dad_vazn_kh=($dad_vazn_karton)*($dad_tedad);
			 $myconn = mysql_connect( "localhost" , "user" , "xlsdj@#@aHdF");
						mysql_query("SET NAMES 'utf8'",$myconn);
						mysql_select_db("sell",$myconn) or die("Can Not Select DataBase Because: ".
						mysql_error());    	
			     	
					     		$querydet = array(
								
							    'dad_anbar_id'=> $dad_anbar_id,
						        'dad_phd_id'=> $dad_phd_id,
					     		'dad_tedad'=> $dad_tedad,
						        'dad_vazn_n'=> $dad_vazn_n,
					     		'dad_vazn_kh'=> $dad_vazn_kh,
					     		'dad_vazn_karton'=> $dad_vazn_karton,
					     		'dad_no'=> $rowpak['p_pakage_type'],
					     		  'dad_ziranbar'=> $code_ziranbar,
					        'dad_keshvar'=> $code_keshvar,
				     		'dad_tolidkonande'=> $code_tolidkonande,
					        'dad_sal'=> $sal_tolid_shamsi,
				     		'dad_mah'=> $mah_tolid_shamsi,
				     		'dad_rouz'=> $rouz_tolid_shamsi,
				     		'dad_vaznkarton'=> $vazn_karton_this,
					     	'dad_vazn_khanbar'=> $dad_vazn_kh,
					     	'dad_tedad_khanbar'=> $dad_tedad,
						                  
							);
							print $querydet;
							$querydet = inserterQMaker('dm_anbar_det ', $querydet);
						//	print $querydet;
							$lnkdet = mysql_query($querydet);
							if(mysql_error()) print mysql_error();
							$dad_id = mysql_insert_id();
					     	$message='اضافه شد';
			     	mysql_close() ;
			     	
					     	
					     	
					     	  	//update anbar
						     	
						     	
						     	$tedad_sold=(($tedad_sold)+($dad_tedad));
						     	$nakhales_sold=(($nakhales_soldi)+($dad_vazn_n));
						     	$khales_sold=(($khales_soldi)+($dad_vazn_kh));
						     	$myconn = mysql_connect( "localhost" , "user" , "xlsdj@#@aHdF");
								mysql_query("SET NAMES 'utf8'",$myconn);
								mysql_select_db("meat",$myconn) or die("Can Not Select DataBase Because: ".
								mysql_error());
						     	                          $queryanbari = "
																UPDATE  mojody_kala 
																	SET 			
																		
																		`khales_sold` = '". $khales_sold ."'			
																	WHERE 
																		  id=".$dad_anbar_id."
																    
																	";       						
															$lnkanbari = mysql_query($queryanbari);
														print $queryanbari;
															if(mysql_error()) print mysql_error();
															mysql_close();
			     	
			     	}
			     	
			     	
			     	
			     	
			}else if($rowpak['p_pakage_type']==8){
			//ghoti	
			echo $dad_tedad;
			 if(($dad_vazn_kh=='')or ($dad_vazn_kh==0)){
					
					$status=1;
					$message='وزن خالص وارد شود';	
			     	}else if($status==11){
			     		 $message='ابتدا کالای تاریخ قبل را اضافه نمایید';
			     	}else{
			     	$status=0;
			     	$myconn = mysql_connect( "localhost" , "user" , "xlsdj@#@aHdF");
						mysql_query("SET NAMES 'utf8'",$myconn);
						mysql_select_db("meat",$myconn) or die("Can Not Select DataBase Because: ".
						mysql_error());
 $queryaa="select * from meat.mojody_kala 
  					where
  					     id=".$dad_anbar_id."";					     
										        
			$lnkaa = mysql_query($queryaa);
			$rowaa = mysql_fetch_assoc($lnkaa);	
			$code_ziranbar=$rowaa['code_ziranbar'];   
			$code_keshvar=$rowaa['code_keshvar']; 
			$code_tolidkonande=$rowaa['code_tolidkonande']; 
			$sal_tolid_shamsi=$rowaa['sal_tolid_shamsi'];
			$mah_tolid_shamsi=$rowaa['mah_tolid_shamsi'];
			$rouz_tolid_shamsi=$rowaa['rouz_tolid_shamsi'];
			$vazn_karton_this=$rowaa['vazn_karton_this'];
//		$tedad=mojodyMojazTedad($dad_anbar_id,$rowa['code_ostan'],$rowa['code_anbar'],$rowa['year'],$rowa['code_ziranbar'],$rowa['code_kala'],$rowa['code_keshvar'],$rowa['code_tolidkonande'],$rowa['sal_tolid_shamsi'],$rowa['mah_tolid_shamsi'],$rowa['rouz_tolid_shamsi'],$rowa['code_karton']);
			
			 mysql_close() ;    	
			     	$dad_vazn_kh1=($dad_vazn_karton)*($tedad);
			     	
			     	
			     	$myconn = mysql_connect( "localhost" , "user" , "xlsdj@#@aHdF");
						mysql_query("SET NAMES 'utf8'",$myconn);
						mysql_select_db("sell",$myconn) or die("Can Not Select DataBase Because: ".
						mysql_error());
			     	
					     		$querydet = array(
								
							    'dad_anbar_id'=> $dad_anbar_id,
						        'dad_phd_id'=> $dad_phd_id,
					     		'dad_tedad'=> $dad_vazn_kh,
						        'dad_vazn_n'=> $dad_vazn_n,
					     		'dad_vazn_kh'=> $dad_vazn_kh1,
					     		'dad_vazn_karton'=> $dad_vazn_karton,
					     		'dad_no'=> $rowpak['p_pakage_type'],
					     		'dad_ziranbar'=> $code_ziranbar,
					        'dad_keshvar'=> $code_keshvar,
				     		'dad_tolidkonande'=> $code_tolidkonande,
					        'dad_sal'=> $sal_tolid_shamsi,
				     		'dad_mah'=> $mah_tolid_shamsi,
				     		'dad_rouz'=> $rouz_tolid_shamsi,
				     		'dad_vaznkarton'=> $vazn_karton_this,
					     	'dad_vazn_khanbar'=> $dad_vazn_kh1,
					     	'dad_tedad_khanbar'=> $dad_vazn_kh,
					     	
						                  
							);
							print $querydet;
							$querydet = inserterQMaker('dm_anbar_det ', $querydet);
						//	print $querydet;
							$lnkdet = mysql_query($querydet);
							if(mysql_error()) print mysql_error();
							$dad_id = mysql_insert_id();
					     	$message='اضافه شد';
					     	
					     		//update anbar
				     	mysql_close() ;
				     	
				     	$tedad_sold=(($tedad_sold)+($dad_tedad));
				     	$nakhales_sold=(($nakhales_soldi)+($dad_vazn_n));
				     	$khales_sold=(($khales_soldi)+($dad_vazn_kh));
				     	$myconn = mysql_connect( "localhost" , "user" , "xlsdj@#@aHdF");
								mysql_query("SET NAMES 'utf8'",$myconn);
								mysql_select_db("meat",$myconn) or die("Can Not Select DataBase Because: ".
								mysql_error());
				     	                          $queryanbari = "
														UPDATE mojody_kala 
															SET 			
																
																`khales_sold` = '". $khales_sold ."'			
															WHERE 
																  id=".$dad_anbar_id."
														    
															";       						
													$lnkanbari = mysql_query($queryanbari);
												print $queryanbari;
													if(mysql_error()) print mysql_error();
					     	
					     	mysql_close() ;
					     	
					     	
					     	
					     	
			     	}
			}
     	
     	
     	
     	
     	
     	
     }
     
     
  echo 'status/';
  echo $status; 
			

		$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$message.';'.$status .';'.$dad_anbar_id .';'.$statusp .'';
}










function AddAMenuToList1(){
	
    $rel_menu_id=$_REQUEST['rel_menu_id'];
    $rel_ug_id=$_REQUEST['rel_ug_id'];
     $u_id=$_REQUEST['u_id'];
//    $ug_id=$_REQUEST['ug_id'];
//    $ug_category=$_REQUEST['ug_category'];
//    $query = "SELECT * FROM dm_list_group_rel WHERE rel_menu_id=".$rel_menu_id." 
//              AND rel_ug_id=".$_SESSION['ug_id']."";
//print 	$query;   
//		$lnk = mysql_query($query);
//		if(mysql_affected_rows()>0){
//			
//		$status= 2;
//	   	$message='قبلا به لیست منو ها اضافه شده است';
//	}
//		else{
//				$status= 1;
	$query = array(
			
		    'um_u_id'=> $u_id,
	        'um_menu_id'=> $rel_menu_id,           
		);
		print $query;
		$query = inserterQMaker('dm_um_rel ', $query);
		print $query;
		$lnk = mysql_query($query);
		if(mysql_error()) print mysql_error();
		$h_id = mysql_insert_id();
//		}
		$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$message.';'.$status .';'.$rel_menu_id .';'.$rel_ug_id .';'.$u_id.';';
}

function DelAMenuToList(){
	
    $rel_ug_id = isset($_REQUEST['rel_ug_id']) ? $_REQUEST['rel_ug_id'] : '';
    $rel_menu_id=$_REQUEST['rel_menu_id'];
//    $ug_id=$_REQUEST['ug_id'];
//    $ug_category=$_REQUEST['ug_category'];
    $query = "SELECT * FROM dm_list_group_rel WHERE rel_menu_id=".$rel_menu_id." 
              AND rel_ug_id=".$rel_ug_id."";
    print $query;
//echo $_SESSION['ug_id'];
echo $rel_ug_id;
		$lnk = mysql_query($query);
		$row= mysql_fetch_assoc($lnk);
		if(mysql_num_rows($lnk)==0){
			
		$status= 2;
	   	$message='اصلا قبلا هم وجود نداشته';
	}
		else{
				$status= 1;
	$query = "
	  DELETE  FROM   dm_list_group_rel
 
		WHERE 
		   rel_ug_id=".$rel_ug_id."
		 AND
			rel_menu_id = ".$rel_menu_id." 
	";
	print $query;
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
	$message='دسترسي حذف شد';
		
		}
		$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$message.';'.$status .';'.$rel_menu_id .';'.$rel_ug_id .';';
}
function delloc(){
	
$chl_id = isset($_REQUEST['chl_id']) ? $_REQUEST['chl_id'] : '';
$l_id = isset($_REQUEST['l_id']) ? $_REQUEST['l_id'] : '';

				
	$query = "
	  DELETE  FROM  dm_loc_ch
 
		WHERE 
		   chl_id=".$chl_id."";
		  
	
	print $query;
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
	$message='دسترسي حذف شد';
		
//		}
		$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$chl_id.';'.$l_id .';';
}
function delopr(){
	
$oph_id = isset($_REQUEST['oph_id']) ? $_REQUEST['oph_id'] : '';
$g_id = isset($_REQUEST['g_id']) ? $_REQUEST['g_id'] : '';

				
	$query = "
	  DELETE  FROM  dm_opr_ch
 
		WHERE 
		   oph_id=".$oph_id."";
		  
	
	print $query;
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
	$message='دسترسي حذف شد';
		
//		}
		$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$oph_id.';'.$g_id .';';
}
	
function DelAMenuToList1(){
	
    $rel_ug_id = isset($_REQUEST['rel_ug_id']) ? $_REQUEST['rel_ug_id'] : '';
    $rel_menu_id=$_REQUEST['rel_menu_id'];
    $u_id=$_REQUEST['u_id'];

//    $query = "SELECT * FROM dm_list_group_rel WHERE rel_menu_id=".$rel_menu_id." 
//              AND rel_ug_id=".$rel_ug_id."";
//    print $query;

//echo $rel_ug_id;
//		$lnk = mysql_query($query);
//		$row= mysql_fetch_assoc($lnk);
//		if(mysql_affected_rows()==0){
//			
//		$status= 2;
//	   	$message='اصلا قبلا هم وجود نداشته';
//	}
//		else{
				$status= 1;
	$query = "
	  DELETE  FROM  dm_um_rel
 
		WHERE 
		   um_u_id=".$u_id."
		 AND
			um_menu_id = ".$rel_menu_id." 
	";
	print $query;
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
	$message='دسترسي حذف شد';
		
//		}
		$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$message.';'.$status .';'.$rel_menu_id .';'.$rel_ug_id .';';
}

function AddAccessEdit(){
	
    $rel_menu_id=$_REQUEST['rel_menu_id'];
    $rel_ug_id=$_REQUEST['rel_ug_id'];
    $u_id=$_REQUEST['u_id'];
    $query = "
		UPDATE  dm_um_rel
		SET 
			`um_can_edit` = '". 1 ."'
					
		WHERE 
			  um_u_id=".$u_id."
		 AND
			um_menu_id = ".$rel_menu_id." 
	";
    print  $query;
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();

		$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$rel_menu_id .';'.$u_id.';';
}
function NoAccessEdit(){
	
    $rel_menu_id=$_REQUEST['rel_menu_id'];
    $rel_ug_id=$_REQUEST['rel_ug_id'];
    $u_id=$_REQUEST['u_id'];
    $query = "
		UPDATE  dm_um_rel
		SET 
			`um_can_edit` = '". 0 ."'
					
		WHERE 
			  um_u_id=".$u_id."
		 AND
			um_menu_id = ".$rel_menu_id." 
	";
    print  $query;
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();

		$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$rel_menu_id .';';
}

function ebtalAdetanbar(){
	
    $deh_anbar_id=$_REQUEST['dad_anbar_id'];
    $deh_phd_id=$_REQUEST['dad_phd_id'];
     $deh_amount=$_REQUEST['dad_tedad'];
     $deh_ebh_id=$_REQUEST['ebh_id'];
     $deh_his_id=$_REQUEST['his_id'];
     $p_pakage_type=$_REQUEST['p_pakage_type'];
     //chek for amount
     $myconn = mysql_connect( "localhost" , "user" , "xlsdj@#@aHdF");
mysql_query("SET NAMES 'utf8'",$myconn);
mysql_select_db("sell",$myconn) or die("Can Not Select DataBase Because: ".
mysql_error());


							
	  $query43="SELECT * FROM dm_his_havale WHERE his_id=".$deh_his_id."   ";
							        
			$lnk43 = mysql_query($query43);
			
			$row43 = mysql_fetch_assoc($lnk43);	
			$his_eb_amount=$row43['his_eb_amount'];
			
		 $queryh="SELECT * FROM dm_havale WHERE h_code=".$row43['his_h_code']."  
            and h_id_province=".$row43['his_id_province']." ";
			        
			$lnkh = mysql_query($queryh);
			
			$rowh = mysql_fetch_assoc($lnkh);	

			
			
			 $queryye="SELECT * FROM dm_year WHERE year_id=".$row43['his_id_year']."";  
						        
			 $lnkye = mysql_query($queryye);
			
		    	$rowye = mysql_fetch_assoc($lnkye);	
			
			
			
      $query2="SELECT * FROM dm_anbar_det WHERE dad_phd_id=".$deh_phd_id." 
       and dad_anbar_id=".$deh_anbar_id."  
       ";									        
			$lnk2 = mysql_query($query2);
			
			$row2 = mysql_fetch_assoc($lnk2);
			
			echo $query2;
			
			$queryl = "SELECT *  FROM dm_location_goods 
		        WHERE `l_code`='".$rowh['h_l_code']."'
		        AND 
		           l_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
		    ";
	    
		$lnkl = mysql_query($queryl);
//	print $query;
	   $rowl= mysql_fetch_assoc($lnkl);
			
	   
	   $queryphd = "SELECT *  FROM dm_pish_havale_det
		        WHERE `phd_id`='".$row2['dad_phd_id']."'
		        
		    ";
	    
		$lnkphd = mysql_query($queryphd);
//	print $query;
	   $rowphd= mysql_fetch_assoc($lnkphd);
	   
	   
	
			if($row2['dad_no']==8){
				$no=1;
if(($rowphd['phd_pid']==50) or ($rowphd['phd_pid']==54)){
	
	
	
	
	
	
}else{
				
				$tedad1=$row2['dad_tedad'];

				$querym=" SELECT SUM(vazn_khales_h_d) as tedadm
								FROM meat.havale_detail where h_code=".$row43['his_h_code']."
								AND code_ostan=".$_SESSION['dm_user_profile']['u_province_id']."
								AND code_anbar=".$rowl['l_code']." AND year=".$rowye['year_code']."  
								AND havale_deleted=0 AND status=0 AND id_mojody=".$row2['dad_anbar_id']." "; 
				 
				$lnkm = mysql_query($querym);
//	print $query;
	   $rowm= mysql_fetch_assoc($lnkm);
	   
	   $tedad1=$row2['dad_tedad']-$rowm['tedadm'];
				

}
			
			}else{
				
				if(($rowphd['phd_pid']==50) or ($rowphd['phd_pid']==54)) {
	
	                 $querym=" SELECT SUM(tedad_shane_h_d) FROM meat.havale_detail where 
	                  h_code=".$row43['his_h_code']." AND code_ostan=".$row43['his_id_province']." 
	                  AND code_anbar=".$rowl['l_code']." AND year=".$rowye['year_code']." AND havale_deleted=0 
	                  AND status=0 AND id_mojody=".$row2['dad_anbar_id']." "; 
					$lnkm = mysql_query($querym);
	//print $querym;
	   $rowm= mysql_fetch_assoc($lnkm);
	  
	   $tedad1=$row2['dad_tedad']-$rowm['tedadm'];
				$no=2;
	
	
}else{

				$querym="SELECT SUM(tedad_karton_h_d) as tedadm FROM meat.havale_detail 
							where h_code=".$row43['his_h_code']."
							 AND code_ostan=".$row43['his_id_province']." 
							 AND code_anbar=".$rowl['l_code']."
							 AND year=".$rowye['year_code']."  
							 AND 
							 havale_deleted=0 
							 AND 
							 status=0 
							 AND 
							 id_mojody=".$row2['dad_anbar_id']." ";
				$lnkm = mysql_query($querym);
	//print $querym;
	   $rowm= mysql_fetch_assoc($lnkm);
				
				$tedad1=$row2['dad_vazn_kh']-$rowm['tedadm'];
				$no=2;
				
				echo  $row2['dad_vazn_kh'];
				echo '/';
				echo $rowm['tedadm'];
				echo '/';
				
}
			}
 //

 
	 $query3="SELECT * FROM dm_ebtal_hdet WHERE deh_phd_id=".$deh_phd_id." 
	 and deh_ebh_id=".$deh_ebh_id."
	 
	 "; 
     
      print $query3;
							        
			$lnk3 = mysql_query($query3);
			$tedi=0;
			while($row3 = mysql_fetch_assoc($lnk3))
			{
			
				$tedi=$tedi+$row3['deh_amount'];
		
				
			}
			$kolebtali=$tedi+$deh_amount;
			
			echo $tedad1;
			echo '/';
			echo $deh_amount;
			echo '/';
			echo $his_eb_amount;
			echo '/';
			echo $kolebtali;
			$tedad1=urlencode($tedad1);
			$deh_amount=urlencode($deh_amount);
			$his_eb_amount=urlencode($his_eb_amount);
			$kolebtali=urlencode($kolebtali);
			
			
			$querymabadi="select * from mabadi.mbd_havale 
  					where
  					     h_id=".$rowh['h_id']."";					     
										        
			$lnkmabadi = mysql_query($querymabadi);
			$rowmabadi = mysql_fetch_assoc($lnkmabadi);
			$mabadi=($rowh['h_amount'] - $rowmabadi['meghdar_h']);
			
			//nasim ($tedad1<$deh_amount)
			
			echo $deh_amount;
			echo '/';
			echo $mabadi;
			 if(($tedad1<$deh_amount) or ($deh_amount==0) or ($his_eb_amount<$kolebtali)){
     
     	$status=7;
     	$message='مقدار ابطالی نادرست است';
     
     $GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$message.';'.$status .';'.$deh_phd_id .';'.$deh_anbar_id .';';
     
     }
      else{
     
     
     $querydet = array(
							
						    'deh_his_id'=> $deh_his_id,
					        'deh_ebh_id'=> $deh_ebh_id,
				     		'deh_anbar_id'=> $deh_anbar_id,
					        'deh_amount'=> $deh_amount,
				     		'deh_phd_id'=> $deh_phd_id,
				     		
					                  
						);
						print $querydet;
						$querydet = inserterQMaker('dm_ebtal_hdet ', $querydet);
						print $querydet;
						$lnkdet = mysql_query($querydet);
						if(mysql_error()) print mysql_error();
						$deh_id = mysql_insert_id();
				print $querydet;     
     
       $query2="SELECT * FROM dm_anbar_det WHERE dad_phd_id=".$deh_phd_id."  
       and dad_anbar_id=".$deh_anbar_id." ";
									        
			$lnk2 = mysql_query($query2);
			
			$row2 = mysql_fetch_assoc($lnk2);
     //print $query2;
      $myconn1 = mysql_connect( "localhost" , "user" , "xlsdj@#@aHdF");
						mysql_query("SET NAMES 'utf8'",$myconn1);
						mysql_select_db("meat",$myconn1) or die("Can Not Select DataBase Because: ".
						mysql_error()); 
     
     $querya="select * from mojody_kala 
  					where
  					     id=".$deh_anbar_id."";					     
										        
			$lnka = mysql_query($querya);
			$rowa = mysql_fetch_assoc($lnka);
		echo $querya;	
     if($p_pakage_type==8){
				
					$khales_sold=$rowa['tedad_sold']+$deh_amount;
				
				
			}else{
					$khales_sold=$rowa['$khales_sold']+$deh_amount;
				
				
			}
		
			echo $rowa['$khales_sold'];
     //update anbar
   
				     	                          $queryanbari = "
														UPDATE mojody_kala 
															SET 			
																
																`khales_sold` = '". $khales_sold ."'			
															WHERE 
																  id=".$deh_anbar_id."
														    
															";       						
													$lnkanbari = mysql_query($queryanbari);
											print $queryanbari;
													if(mysql_error()) print mysql_error();
				     	
				     	mysql_close();
			$myconn = mysql_connect( "localhost" , "user" , "xlsdj@#@aHdF");
						mysql_query("SET NAMES 'utf8'",$myconn);
						mysql_select_db("sell",$myconn) or die("Can Not Select DataBase Because: ".
						mysql_error());
			
	//update detail anba dar forosh
     if($p_pakage_type==8){
				//ghoti
				 $dad_vazn_kh=$row2['dad_tedad']-$deh_amount;
				
				
			}else{
				//karton
				 $dad_vazn_kh=$row2['dad_vazn_kh']-$deh_amount;
				
				
			}
				  
//			$dad_vazn_n=$deh_amount*$row2['dad_vazn_n'];
//			$nakhales_sold=$row2['dad_vazn_n']+$dad_vazn_n;
//			$dad_vazn_kh=$row2['dad_vazn_kh']*$deh_amount;
//			$khales_sold=$rowa['$khales_sold']+$dad_vazn_kh;  	
//			
if($dad_vazn_kh==0){
				   
	
	$queryanba = "
					UPDATE dm_anbar_det 
						SET 			
							`dad_vazn_kh` = '". $dad_vazn_kh ."',
							`dad_status_eb` = '1'			
						WHERE 
							  dad_anbar_id=".$deh_anbar_id."
					     and
							  dad_phd_id=".$deh_phd_id." 
					    
						";       						
				$lnkanba = mysql_query($queryanba);
		//print $queryanba;
				if(mysql_error()) print mysql_error();  

	
	
//				   $queryd = "
//					  DELETE  FROM   dm_anbar_det
//				 
//						WHERE 
//							  dad_anbar_id=".$deh_anbar_id."
//					     and
//							  dad_phd_id=".$deh_phd_id." 
//					";
//					//print $queryd;
//					$lnkd = mysql_query($queryd);
//					if(mysql_error()) print mysql_error();
					
				}else{
					
					if($no==1){
					
				$queryanba = "
									UPDATE dm_anbar_det 
										SET 			
											`dad_tedad` = '". $dad_vazn_kh ."'			
										WHERE 
											  dad_anbar_id=".$deh_anbar_id."
									     and
											  dad_phd_id=".$deh_phd_id." 
									    
										";       						
								$lnkanba = mysql_query($queryanba);
						print $queryanba;
								if(mysql_error()) print mysql_error(); 
					
					
					}else{
									
									
									$queryanba = "
									UPDATE dm_anbar_det 
										SET 			
											`dad_vazn_kh` = '". $dad_vazn_kh ."'			
										WHERE 
											  dad_anbar_id=".$deh_anbar_id."
									     and
											  dad_phd_id=".$deh_phd_id." 
									    
										";       						
								$lnkanba = mysql_query($queryanba);	
									
									
									
									
								}

								
								
				     	
				}
	//status baraye print 

								
	  $query3="SELECT * FROM dm_his_havale WHERE his_id=".$deh_his_id."  
	  
	  
       "; 
   
										        
			$lnk3 = mysql_query($query3);
			
			$row3 = mysql_fetch_assoc($lnk3);								
			print $query3;					
								
			 $query4="SELECT * FROM dm_ebtal_hdet WHERE deh_phd_id=".$deh_phd_id." 
			 
			 
			 ";
				echo $query4;						        
			$lnk4 = mysql_query($query4);
			$tedadebtaldet=0;
			while($row4 = mysql_fetch_assoc($lnk4))
			{
			$tedadebtaldet = $tedadebtaldet+$row4['deh_amount'];
			
            
			}
			
			echo  $tedadebtaldet;
			echo '/';
			echo  $row3['his_eb_amount'];
			
			if(($tedadebtaldet)==($row3['his_eb_amount'])){
				echo 'hasttttt';
				
				 $queryyy = "
								UPDATE dm_ebtal_h 
									SET 			
										`ebh_status_anbar` = '1'
									WHERE 
										 ebh_id=".$deh_ebh_id."
								    
									";       						
							$lnkyy = mysql_query($queryyy);
					print $queryyy;
							if(mysql_error()) print mysql_error();
				
				
				
		$status=1;		
				
				$message='ابطال کامل انجام شد';
				
			}else{
				
				$status=0;
				
				
				$message='انجام شد ادامه دهید';	
				
			}
          					
								
			
			
     
     
     
			

		$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$message.';'.$status .';'.$deh_phd_id .';'.$deh_anbar_id .';';
		
     }	
		
		
}





function NoAccessDelete(){
	
    $rel_menu_id=$_REQUEST['rel_menu_id'];
    $rel_ug_id=$_REQUEST['rel_ug_id'];
    $u_id=$_REQUEST['u_id'];
    $query = "
		UPDATE  dm_um_rel
		SET 
			`um_can_delete` = '". 0 ."'
					
		WHERE 
			  um_u_id=".$_SESSION['dm_user_profile']['u_id']."
		 AND
			um_menu_id = ".$rel_menu_id." 
	";
    print  $query;
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();

		$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$rel_menu_id .';';
}
function AddAccessDelete(){
	
    $rel_menu_id=$_REQUEST['rel_menu_id'];
    $rel_ug_id=$_REQUEST['rel_ug_id'];
     $u_id=$_REQUEST['u_id'];
    $query = "
		UPDATE  dm_um_rel
		SET 
			`um_can_delete` = '". 1 ."'
					
		WHERE 
			  um_u_id=".$u_id."
		 AND
			um_menu_id = ".$rel_menu_id." 
	";
    print  $query;
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();

		$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$rel_menu_id .';';
}
function checkAndValidProdName(){
	$_SESSION['codeprice']='';
		
$p_code = isset($_REQUEST['p_code']) ? $_REQUEST['p_code'] : '';
$p_name = isset($_REQUEST['p_name']) ? $_REQUEST['p_name'] : '';
$p_id = isset($_REQUEST['p_id']) ? $_REQUEST['p_id'] : '';
$p_price_code = isset($_REQUEST['p_price_code']) ? $_REQUEST['p_price_code'] : '';
echo $p_code;
$queryp = "SELECT * FROM  dm_province
							WHERE
								province_id=".$_SESSION['dm_user_profile']['u_province_id']."  ";	
											       						       
$lnkp = mysql_query($queryp);												
$rowp= mysql_fetch_assoc($lnk);
$province_code = $row['province_code'];

$query1 = "SELECT * FROM dm_product product
			left join dm_price price
			on product.p_id=price.price_p_id 
		          WHERE 
		             `p_id`='".$p_id."' 
		          
		           AND 
		              `price_id_province`='".$_SESSION['dm_user_profile']['u_province_id']."'
		            AND
		                  `p_price_code`='".$p_price_code."'
		             ";
//print $query1;		       		    
			$lnk1 = mysql_query($query1);			
		  		   
		   $status=0;
    	if(mysql_num_rows($lnk1)>0){  	
    		
    		 $row1= mysql_fetch_assoc($lnk1);	
				        $message=' كالا تكراري است!';
				        $_SESSION['checkProd']=1;
						    $status=1;
						    $_SESSION['checkProd']=1;
		    }
		    else {
		    	
							
					$queryc = "SELECT * FROM  mali.acc_mofaser_detail
							WHERE
								( mk=18 or mk=25)
							
							
                           
                           AND
                               code=".$p_price_code."";	
					//print  $queryc;
							    					       						       
								$lnkc = mysql_query($queryc);
								if(mysql_affected_rows()==0){
									  $rowc= mysql_fetch_assoc($lnkc);
									$status=3;
									$message='چنين كالايي با اين كد قيمت وجود ندارد';
									  
								}
					    	
	//    	$query = "SELECT * FROM dm_product product
	//					left join dm_price price
//						on product.p_id=price.price_p_id 
	//				           WHERE 
	//		             `p_code`='".$p_code."'  AND `p_name` !=  '".$p_name."' 
	//		             AND 
   //                                            `price_id_province`='".$_SESSION['dm_user_profile']['u_province_id']."'
           

			   //         ";						       						       
			//	$lnk = mysql_query($query);
			//	print $query;
			  
		//    	if(mysql_num_rows($lnk)>0){
		    	//	 $row= mysql_fetch_assoc($lnk);
		    	//	$status=2;
		    	//	echo $status=2;
		    	//	 $message=' چنين كالايي با این کد تعریف نشده است!!';
							//    	}else{
					   	
			    	       //   $_SESSION['checkProd']=0;}
		    }
    	 
$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$message.';'.$status .';';
	
}	
function checkAndValidProdNameEdit(){
		
$p_code = isset($_REQUEST['p_code']) ? $_REQUEST['p_code'] : '';
$p_name = isset($_REQUEST['p_name']) ? $_REQUEST['p_name'] : '';
$p_price_code = isset($_REQUEST['p_price_code']) ? $_REQUEST['p_price_code'] : '';
$p_id = isset($_REQUEST['p_id']) ? $_REQUEST['p_id'] : '';
$price_id = isset($_REQUEST['price_id']) ? $_REQUEST['price_id'] : '';


$query55 = " select * from   dm_listprod 
					where 
					    p_id=".$p_id."";
					 			  
					  		   
		$lnk55 = mysql_query($query55);
		print $query;
	    $row55= mysql_fetch_assoc($lnk55);

$query = " select * from   dm_product product                    
				left join dm_price price
				 on product.p_id=price.price_p_id 
					where 
					    p_code=".$row55['p_code']."
					  and
					  price_id=".$price_id." 
					  and
					  price_id_province=".$_SESSION['dm_user_profile']['u_province_id']."";
					  
					  		   
		$lnk = mysql_query($query);
	//	print $query;
	    $row= mysql_fetch_assoc($lnk);
	    $p_code =$row['p_code'];
	    $p_price_code = $row['p_price_code'];
	    $query1 = "select * from   dm_pish_havale_det 	                                  				
					where 
					    phd_pid=".$p_code."
					  and
					  phd_price_code=".$p_price_code."
					  and
                     phd_id_province=".$_SESSION['dm_user_profile']['u_province_id']."";	
	    $lnk1 = mysql_query($query1);
			 if(mysql_num_rows($lnk1)>0){
				  	$status1=1;
				  	 
				  	
				  }
	    $row1= mysql_fetch_assoc($lnk1);
	    $ph_code =$row1['phd_ph_code'];
	  print $query1;
    	if(mysql_num_rows($lnk1)>0){
         $query2 = "select * from   dm_pish_factor 	                                  				
					where 
					    pf_ph_code=".$ph_code."
					  and				
                     pf_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
                     AND
		       pf_type=". 0 ."
                     
                     ";	
	     $lnk2 = mysql_query($query2);
	   
	    print $query2;
	//if($_SESSION['dm_user_profile']['u_id']!=3){
		
	//	$status1=1;
	//}
	  if(mysql_num_rows($lnk2)>0){
	  	$status1=1;
	  	  $row2= mysql_fetch_assoc($lnk2);
	  	
	  }
    		
			    //   $status=5;
			     // $message='شما از این کالا استفاده کردید و حق تغییر ندارید';
	  
    		
	                           //     }
		    }
		    
		    else {
    	          $_SESSION['checkProd']=0;
		    }
    	 
$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$message.';'.$status .';'.$p_id .';'.$status1 .';';
	
}

function checkprod_morgh(){
		
$pm_pcode = isset($_REQUEST['pm_pcode']) ? $_REQUEST['pm_pcode'] : '';
$pm_price = isset($_REQUEST['pm_price']) ? $_REQUEST['pm_price'] : '';
$pm_price_code = isset($_REQUEST['pm_price_code']) ? $_REQUEST['pm_price_code'] : '';
$pm_id = isset($_REQUEST['pm_id']) ? $_REQUEST['pm_id'] : '';
$status=0;

    	 
$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$pm_id.';'.$status.';';
	
}
function checkAndValidProdNameEdit_m(){
		
$p_code = isset($_REQUEST['p_code']) ? $_REQUEST['p_code'] : '';
$p_name = isset($_REQUEST['p_name']) ? $_REQUEST['p_name'] : '';
$p_price_code = isset($_REQUEST['p_price_code']) ? $_REQUEST['p_price_code'] : '';
$p_id = isset($_REQUEST['p_id']) ? $_REQUEST['p_id'] : '';
$price_id = isset($_REQUEST['price_id']) ? $_REQUEST['price_id'] : '';
$query = "
		UPDATE  dm_listprod
		SET 

			`p_name`= '".$p_name."'
				 
		WHERE 
			p_id = ".$p_id.""; 
	$lnk = mysql_query($query);
	//print $query;
	if(mysql_error()) print mysql_error();

$status=0;
    	 
$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$status.';';
	
}
function checkAndValiPriceCode(){
		
$p_code = isset($_REQUEST['p_code']) ? $_REQUEST['p_code'] : '';
$p_price_code = isset($_REQUEST['p_price_code']) ? $_REQUEST['p_price_code'] : '';
$status=0;
$query = "select * from dm_product product
			left join dm_price price
			on product.p_id=price.price_p_id
		           WHERE `p_code`='".$p_code."'  AND `p_price_code` =  '".$p_price_code."'
		           AND
		            price_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
		    ";
	    
		$lnk = mysql_query($query);
	print $query;
	   $row= mysql_fetch_assoc($lnk);
	   $status=0;
    	if(mysql_num_rows($lnk)>0){  		
        $message=' اين كد قيمت قبلا استفاده شده و مجاز به استفاده نيستيد!';
		    $status=1;		
		   			 		
    	}
    
$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$message .';'.$status.';';
	
}	
function CheckCodeL(){
	global $checkloc;
	 $_SESSION['checkLoc']='';
	$l_code = isset($_REQUEST['l_code']) ? $_REQUEST['l_code'] : '';
	$query = "SELECT *  FROM dm_location_goods 
		        WHERE `l_code`='".$l_code."'
		        AND 
		           l_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
		    ";
	    
		$lnk = mysql_query($query);
//	print $query;
	   $row= mysql_fetch_assoc($lnk);
	   $status=0;
    	if(mysql_num_rows($lnk)>0){ 
    		 		
        $message=' اين كد محل قبلا استفاده شده و مجاز به استفاده نيستيد!';
       
		    $status=1;
		     $checkloc=1;	
    	}else{
    		
    	 if (($l_code<100) AND ($l_code>300)){
        	$message=' کد محل باید در رنج 100تا300قرار داشته باشد';
        	 $status=1;
		     $checkloc=1;	
        	
        }else{
    		$status=0;
    		$checkloc=0;
        }
    		 
    	}
	$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$message .';'.$status.';'.$p_id.';';
    	
}

function CheckCodeLEdit(){
	
    $_SESSION['checkLoc']='';
	$l_code = isset($_REQUEST['l_code']) ? $_REQUEST['l_code'] : '';
	$l_id = isset($_REQUEST['l_id']) ? $_REQUEST['l_id'] : '';
	$query = "SELECT *  FROM dm_location_goods 
		           WHERE `l_code`='".$l_code."' 
		       AND 
		           `l_id`!='".$l_id."'
		        AND 
		           l_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
		               
		    ";
	    
		$lnk = mysql_query($query);
	print $query;
	
	   $row= mysql_fetch_assoc($lnk);
	  
    	if(mysql_num_rows($lnk)>0){ 
    		 		
        $message=' اين كد محل قبلا استفاده شده و مجاز به استفاده نيستيد!';
		    $status=1;
		     $checkloc=1;	
    	}else{
    		 if (($l_code>100) and ($l_code<300)){
    		$status=0;
    		$checkloc=0;
    		
    		 }else{
    		 $status=1;
		     $checkloc=1;	
		      $message=' کد محل باید در زنج 100 تا 300 قرار داشته باشد';
    		 	
    		 } 
    	}
	$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$message .';'.$status.';'.$l_id.';';
    	
}
function checkGroupName(){
    	$_SESSION['checkNgroup']='';
		$ug_category = isset($_REQUEST['ug_category']) ? $_REQUEST['ug_category'] : '';
	    $query = "SELECT *  FROM dm_usergroup 
		           WHERE `ug_category`='".$ug_category."'
		    ";
	    
		$lnk = mysql_query($query);
	print $query;
	   $row= mysql_fetch_assoc($lnk);
	   $status=0;
    	if(mysql_num_rows($lnk)>0){ 
    		 		
        $message=' اين نام قبلا استفاده شده و مجاز به استفاده نيستيد!';
		    $status=1;
		    $_SESSION['checkNgroup']=1;	
    	}else{
    		 $_SESSION['checkNgroup']=0;
    	}
	$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$message .';'.$status.';';
	
}
function DisableRelCombo(){
 $value = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';
 
		$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$value .';';
 
}
function DisablePerCombo(){
 $value = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';
 
		$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$value .';';
 
}
function DisableezafidCombo(){
	
	$value = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';
	if($value==2){
	//field pardakhti	
		$_SESSION['pardakhti']=2;
	}else if($value==1){
	//field ezaf pardakhti	
		$_SESSION['pardakhti']=1;
	}
 
		$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$value .';';
}

function validCodechedit(){
	
	    $ch_id = isset($_REQUEST['ch_code']) ? $_REQUEST['ch_code'] : '';
	    $ch_code = isset($_REQUEST['ch_code']) ? $_REQUEST['ch_code'] : '';
		$p_code = isset($_REQUEST['p_code']) ? $_REQUEST['p_code'] : '';
		$p_price_combo = isset($_REQUEST['p_price_combo']) ? $_REQUEST['p_price_combo'] : '';
		$ch_type_redundancy = isset($_REQUEST['ch_type_redundancy']) ? $_REQUEST['ch_type_redundancy'] : '';
		$statusedit = isset($_REQUEST['statusedit']) ? $_REQUEST['statusedit'] : '';
		$ch_ldate = isset($_REQUEST['ch_ldate']) ? $_REQUEST['ch_ldate'] : '';
	echo $statusedit;
  $query = "SELECT *  FROM dm_charge_factors 
		           WHERE `ch_code_good`='".$p_code."'
		           AND
		            `ch_pricecode_good`='".$p_price_combo."'
                  AND
                   ch_id_province=".$_SESSION['dm_user_profile']['u_province_id']." ";		          
		$lnk = mysql_query($query);
    	print $query;
	   $rowch= mysql_fetch_assoc($lnk);
	   $status=0;
    	if(mysql_num_rows($lnk)==100000){ 
    		 		
        $message='! برای اين كالا قبلا هزينه تعريف شده است';
		    $status=1;
		    $_SESSION['checkCodeCh']=1;	
    	}else{
    		 $_SESSION['checkCodeCh']=0;
    	}
     $query = "select * from dm_product product
					left join dm_price price
					on product.p_id=price.price_p_id
		           WHERE `p_code`='".$p_code."'
	                   AND 
	                   `p_price_code`='".$p_price_combo."'
	                   AND
	                    price_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
		           ";
	   	    
			$lnk = mysql_query($query);
	    	 print $query;
		     $row= mysql_fetch_assoc($lnk);
		     $status=0;
	    	 if($row['p_charge']==1){
	    		$status=3;
	    		$message='!  برای چنين كالايی‌ هزينه در نظر گرفته نشده ';
	    	}else{
	    		
				
	    	}
	    	 $queryh = "select * from dm_havale
					
		           WHERE `h_p_code`='".$p_code."'
	                   AND 
	                   `h_price_code`='".$p_price_combo."'
	                   AND
	                    h_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
		           ";
	   	    
			$lnkh = mysql_query($queryh);
	    	 print $query;
		     $rowh= mysql_fetch_assoc($lnkh);
     
	    	if($ch_ldate < $rowch['ch_ldate']){
	    		$status=4;
	    		
	    		  $message='! فقط مجازيد تاريخی دير تر از تاريخ قبل ايجاد كنيد';
	    		
	    	}
     	
		$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$message .';'.$status.';'.$statusedit.';';
	    	
		
}
function updChargeFactorsInf1(){
	
	$ch_id = isset($_REQUEST['ch_id']) ? (int)($_REQUEST['ch_id']) : 0;
		if($ch_id<1) die('Inv Id');
   $ch_ldate= isset($_REQUEST['ch_ldate']) ? ($_REQUEST['ch_ldate']) : '';
	$date = explode('/', $ch_ldate);
     $ch_fdate=$date[2].'/'.$date[1].'/'.$date[0] ;      
     $jdate=$ch_fdate;
     $jdate .= '/\/';
     list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
     list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
if($gmonth<=9){
       $gmonth='0'.$gmonth;  
     }
if($gday<=9){
       $gday='0'.$gday;  
     }
	$ch_ldate = $gyear."-".$gmonth."-".$gday;//enjoori mishe 2010-4-25
	
	$query = "
		UPDATE  dm_charge_factors 
		SET 

			`ch_ldate`= '".$ch_ldate."'
				 
		WHERE 
			ch_id = ".$ch_id.""; 
	$lnk = mysql_query($query);
	//print $query;
	if(mysql_error()) print mysql_error();
}
function updChargeFactorsInf(){
	
	$ch_id = isset($_REQUEST['ch_id']) ? (int)($_REQUEST['ch_id']) : 0;
		if($ch_id<1) die('Inv Id');
		
	$ch_code = isset($_REQUEST['ch_code']) ? $_REQUEST['ch_code'] : '';
	$ch_topic = isset($_REQUEST['ch_topic']) ? ($_REQUEST['ch_topic']) : '';
	$ch_date = isset($_REQUEST['ch_date']) ? ($_REQUEST['ch_date']) : '';
	$ch_accountNum = isset($_REQUEST['ch_accountNum']) ? ($_REQUEST['ch_accountNum']) : '';
	$ch_type = isset($_REQUEST['ch_type']) ? ($_REQUEST['ch_type']) : '';
	$ch_emerge_factors = isset($_REQUEST['ch_emerge_factors']) ? ($_REQUEST['ch_emerge_factors']) : '';
	$ch_dependancy = isset($_REQUEST['ch_dependancy']) ? ($_REQUEST['ch_dependancy']) : '';	
	$ch_dependancy_to = isset($_REQUEST['ch_dependancy_to']) ? ($_REQUEST['ch_dependancy_to']) : '';
	$ch_ratio = isset($_REQUEST['ch_ratio']) ? ($_REQUEST['ch_ratio']) : '';
	$ch_code_location = isset($_REQUEST['ch_code_location']) ? ($_REQUEST['ch_code_location']) : '';
	$ch_name_location = isset($_REQUEST['ch_name_location']) ? ($_REQUEST['ch_name_location']) : '';
	$ch_code_good = isset($_REQUEST['p_code']) ? ($_REQUEST['p_code']) : '';
	$p_price_code = isset($_REQUEST['p_price_code']) ? ($_REQUEST['p_price_code']) : '';
	$ch_charge = isset($_REQUEST['ch_charge']) ? ($_REQUEST['ch_charge']) : '';
	$ch_licenseNo= isset($_REQUEST['ch_licenseNo']) ? ($_REQUEST['ch_licenseNo']) : '';
	$ch_considerations= isset($_REQUEST['ch_considerations']) ? ($_REQUEST['ch_considerations']) : '';
	$ch_fdate= isset($_REQUEST['ch_fdate']) ? ($_REQUEST['ch_fdate']) : '';
	$ch_ldate= isset($_REQUEST['ch_ldate']) ? ($_REQUEST['ch_ldate']) : '';
	
	
	 $date = explode('/', $ch_fdate);
     $ch_fdate=$date[2].'/'.$date[1].'/'.$date[0] ;      
     $jdate=$ch_fdate;
     $jdate .= '/\/';
     list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
     list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
if($gmonth<=9){
       $gmonth='0'.$gmonth;  
     }
if($gday<=9){
       $gday='0'.$gday;  
     }
	$ch_fdate = $gyear."-".$gmonth."-".$gday;//enjoori mishe 2010-4-25
	
//change ldate 
	 $date = explode('/', $ch_ldate);
     $ch_ldate=$date[2].'/'.$date[1].'/'.$date[0] ;      
     $jdate=$ch_ldate;
     $jdate .= '/\/';
     list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
     list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
if($gmonth<=9){
       $gmonth='0'.$gmonth;  
     }
if($gday<=9){
       $gday='0'.$gday;  
     }
	$ch_ldate = $gyear."-".$gmonth."-".$gday;//enjoori mishe 2010-4-25
	
	$query = "
		UPDATE  dm_charge_factors 
		SET 

			`ch_ldate`= '".$ch_ldate."'
				 
		WHERE 
			ch_id = ".$ch_id.""; 
	

	
	
}
function validCodech(){
		
		$ch_code = isset($_REQUEST['ch_code']) ? $_REQUEST['ch_code'] : '';
		$p_code = isset($_REQUEST['p_code']) ? $_REQUEST['p_code'] : '';
		$p_price_combo = isset($_REQUEST['p_price_combo']) ? $_REQUEST['p_price_combo'] : '';
		$ch_type_redundancy = isset($_REQUEST['ch_type_redundancy']) ? $_REQUEST['ch_type_redundancy'] : '';
		$ch_fdate = isset($_REQUEST['fdate']) ? $_REQUEST['fdate'] : '';
		$ch_ldate = isset($_REQUEST['ldate']) ? $_REQUEST['ldate'] : '';

			     $date = explode('/', $ch_fdate);
			     $ch_fdate=$date[2].'/'.$date[1].'/'.$date[0] ;      
			     $jdate=$ch_fdate;
			     $jdate .= '/\/';
			     list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
			     list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
			if($gmonth<=9){
			       $gmonth='0'.$gmonth;  
			     }
			if($gday<=9){
			       $gday='0'.$gday;  
			     }
				$ch_fdate = $gyear."-".$gmonth."-".$gday;//enjoori mishe 2010-4-25
				
			//change ldate 
				 $date = explode('/', $ch_ldate);
			     $ch_ldate=$date[2].'/'.$date[1].'/'.$date[0] ;      
			     $jdate=$ch_ldate;
			     $jdate .= '/\/';
			     list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
			     list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
			if($gmonth<=9){
			       $gmonth='0'.$gmonth;  
			     }
			if($gday<=9){
			       $gday='0'.$gday;  
			     }
				$ch_ldate = $gyear."-".$gmonth."-".$gday;//enjoori mishe 2010-4-25
					
				    $query = "SELECT *  FROM dm_charge_factors 
					           WHERE 
						             `ch_code_good`='".$p_code."'
						          AND
						             `ch_pricecode_good`='".$p_price_combo."'
				                  AND
				                      ch_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
				                  AND
				                      ch_fdate >".$ch_fdate."
				                  AND
				                      ch_ldate <".$ch_ldate."";               		          
				$lnk = mysql_query($query);
		  	print $query;	   
			   $status=0;
		    	if(mysql_num_rows($lnk)>100000){ 
		    		 	$row= mysql_fetch_assoc($lnk);	
		        $message='! برای اين كالا قبلا هزينه تعريف شده است';
				    $status=1;
				    $_SESSION['checkCodeCh']=1;	
		    	}else{
		    		 $_SESSION['checkCodeCh']=0;
		    	}
     $query = "select * from dm_product product
					left join dm_price price
					on product.p_id=price.price_p_id
		           WHERE `p_code`='".$p_code."'
	                   AND 
	                   `p_price_code`='".$p_price_combo."'
	                   AND
	                    price_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
		           ";
	   	    
			$lnk = mysql_query($query);
	    	 print $query;
		     $row= mysql_fetch_assoc($lnk);
		     $status=0;
		  
	    	if(mysql_num_rows($lnk)==0){
	    		$status=2;
	    		  $message='! چنين كالايي با اين كد كالا و كد قيمت وجود ندارد';
	    	} else if($row['p_charge']==1){
	    		$status=3;
	    		$message='!  برای چنين كالايی‌ هزينه در نظر گرفته نشده ';
	    	}else{
	    		
	    		
					$query = "
							UPDATE  dm_price 
							SET 
								
							    `p_sellpriceh` = '".$ch_code."'
									 
							WHERE 
								price_id = ".$price_id." 
						";
						$lnk = mysql_query($query);
						if(mysql_error()) print mysql_error();

	    	 $query = "SELECT *  FROM dm_charge_factors 
		           WHERE `ch_code_good`='".$p_code."'
		           AND
		            `ch_pricecode_good`='".$p_price_combo."'
                  AND
                   ch_id_province=".$_SESSION['dm_user_profile']['u_province_id']." ";		          
		$lnk = mysql_query($query);
    	print $query;
	   
	   $status=0;
    	if(mysql_num_rows($lnk)>100000){ 
    		 	$row= mysql_fetch_assoc($lnk);	
        $message='! برای اين كالا قبلا هزينه تعريف شده است';
		    $status=1;
		    $_SESSION['checkCodeCh']=1;	
    	}else{
    		 $_SESSION['checkCodeCh']=0;
    	}
						
						
	    		
	    	}
    	
	$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$message .';'.$status.';';
	
}
function validCustomercode(){
		
		$code_customer = isset($_REQUEST['code_customer']) ? $_REQUEST['code_customer'] : '';
		
		 $query = "SELECT *  FROM dm_province
		           WHERE `province_id`='".$_SESSION['dm_user_profile']['u_province_id']."' ";
		  $lnk = mysql_query($query);
		  $row= mysql_fetch_assoc($lnk);
		    $province_code=$row['province_code'];
		  
	    $query = "SELECT *  FROM dm_customer 
		           WHERE `code_customer`='".$code_customer."'
		           AND
			             customer_code_org=".$province_code."";
		           
		   	    
	   $lnk = mysql_query($query);
    	print $query;
	   $row= mysql_fetch_assoc($lnk);
	   $status=0;
    	if(mysql_num_rows($lnk)>0){ 
    		 		
        $message='! كد تكراري است';
        $_SESSION['checkCodeCus']=1;
		    $status=1;
		    
    	}else{
    		 $status=0;
    		 $_SESSION['checkCodeCus']=0;
    	}
	$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$message .';'.$status.';';
	
}
function validCustomercodeEdit(){
		
		$code_customer = isset($_REQUEST['code_customer']) ? $_REQUEST['code_customer'] : '';
		$customer_id = isset($_REQUEST['customer_id']) ? $_REQUEST['customer_id'] : '';
		$status=0;
//    $query = "SELECT *  FROM dm_customer_asli 
//		           WHERE
	//	           `customer_id` !='".$customer_id."' ";
		   	    
	 //  $lnk = mysql_query($query);
//    	print $query;
//	   $row= mysql_fetch_assoc($lnk);
//	   $status=0;
//    	if(mysql_affected_rows()>0){ 
//    		 		
//        $message='! كد تكراري است';
//        $_SESSION['checkCodeCus']=1;
//		    $status=1;
//		    
//    	}else{
//    		 $status=0;
//    		 $_SESSION['checkCodeCus']=0;
//    	}
	$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$message .';'.$status.';'.$customer_id.';';
	
}
function insertop_mojavez(){
	
		$phm_mojavez = isset($_REQUEST['phm_mojavez']) ? $_REQUEST['phm_mojavez'] : '';
		$phm_op_id = isset($_REQUEST['phm_op_id']) ? $_REQUEST['phm_op_id'] : '';
		$phm_date_f = isset($_REQUEST['phm_date_f']) ? $_REQUEST['phm_date_f'] : '';
		$phm_date_l = isset($_REQUEST['phm_date_l']) ? $_REQUEST['phm_date_l'] : '';
		$phm_type_id = isset($_REQUEST['phm_type_id']) ? $_REQUEST['phm_type_id'] : '';
		$phm_ptype = isset($_REQUEST['phm_ptype']) ? $_REQUEST['phm_ptype'] : '';
		$phm_amount = isset($_REQUEST['phm_amount']) ? $_REQUEST['phm_amount'] : '';
		
		
//	echo $phm_ptype;
//	echo 'ffffffffffffff';
		$date = explode('/', $phm_date_f);
     $phm_date_f=$date[2].'/'.$date[1].'/'.$date[0] ;      
     $jdate=$phm_date_f;
     $jdate .= '/\/';
     list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
     list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
if($gmonth<=9){
       $gmonth='0'.$gmonth;  
     }
if($gday<=9){
       $gday='0'.$gday;  
     }
	$phm_date_f = $gyear."-".$gmonth."-".$gday;//enjoori mishe 2010-4-25
	//
	
	$date = explode('/', $phm_date_l);
     $phm_date_l=$date[2].'/'.$date[1].'/'.$date[0] ;      
     $jdate=$phm_date_l;
     $jdate .= '/\/';
     list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
     list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
if($gmonth<=9){
       $gmonth='0'.$gmonth;  
     }
if($gday<=9){
       $gday='0'.$gday;  
     }
	$phm_date_l = $gyear."-".$gmonth."-".$gday;//enjoori mishe 2010-4-25
	
	$i=1;
	$os .='';
	while($i<38)
	
	{
		
								$query = "SELECT *  FROM dm_op_mojavez 
								           WHERE 
								                `phm_op_id`='".$phm_op_id."'
								              AND
								               `phm_mojavez`='".$phm_mojavez."'
						                      AND  
								                `phm_id_province`='".$i."'
								           ";
								 $lnk = mysql_query($query);
								// print $query;
								 if(mysql_num_rows($lnk)>0){ 
								 	
								 	$status=1;
								 	$os .='/'.$i;
								 	
								 }else{
								 	
									 	 $query = array(
										
									    'phm_reg_date'=> gmdate('Y-m-d'),
							            'phm_op_id'=>  $phm_op_id,
							            'phm_mojavez'=>   $phm_mojavez,
							            'phm_id_province'=>  $i,
									 	'phm_date_f'=>  $phm_date_f,
									 	'phm_date_l'=>  $phm_date_l,
									 	'phm_type_id'=>  $phm_type_id,
									 	'phm_ptype'=>  $phm_ptype,
							            'phm_status'=>   0, 
									 	'phm_amount'=>   $phm_amount,
									 	 'phm_u_id'=>   $_SESSION['dm_user_profile']['u_id'], 
									 	'phm_amountpre'=>   $phm_amount,
									 	'phm_origamount'=>   $phm_amount,
							             
									);
								
									$query = inserterQMaker('dm_op_mojavez', $query);
									print $query;
									
									$lnk = mysql_query($query);
									if(mysql_error()) print mysql_error();
							print $query;
								 }
		$i++;						 
	}	    
	
	$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$status .''.$os.';';
}
function insertop_mojavez_yeki(){
	
		$phm_mojavez = isset($_REQUEST['phm_mojavez']) ? $_REQUEST['phm_mojavez'] : '';
		$phm_op_id = isset($_REQUEST['phm_op_id']) ? $_REQUEST['phm_op_id'] : '';
		$phm_date_f = isset($_REQUEST['phm_date_f']) ? $_REQUEST['phm_date_f'] : '';
		$phm_date_l = isset($_REQUEST['phm_date_l']) ? $_REQUEST['phm_date_l'] : '';
		$phm_type_id = isset($_REQUEST['phm_type_id']) ? $_REQUEST['phm_type_id'] : '';
		$phm_ptype = isset($_REQUEST['phm_ptype']) ? $_REQUEST['phm_ptype'] : '';
	    $phm_amount = isset($_REQUEST['phm_amount']) ? $_REQUEST['phm_amount'] : '';
	
		$date = explode('/', $phm_date_f);
     $phm_date_f=$date[2].'/'.$date[1].'/'.$date[0] ;      
     $jdate=$phm_date_f;
     $jdate .= '/\/';
     list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
     list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
if($gmonth<=9){
       $gmonth='0'.$gmonth;  
     }
if($gday<=9){
       $gday='0'.$gday;  
     }
	$phm_date_f = $gyear."-".$gmonth."-".$gday;//enjoori mishe 2010-4-25
	//
	
	$date = explode('/', $phm_date_l);
     $phm_date_l=$date[2].'/'.$date[1].'/'.$date[0] ;      
     $jdate=$phm_date_l;
     $jdate .= '/\/';
     list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
     list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
if($gmonth<=9){
       $gmonth='0'.$gmonth;  
     }
if($gday<=9){
       $gday='0'.$gday;  
     }
	$phm_date_l = $gyear."-".$gmonth."-".$gday;//enjoori mishe 2010-4-25
	

								$query = "SELECT *  FROM dm_op_mojavez 
								           WHERE 
								                `phm_op_id`='".$phm_op_id."'
								              AND
								               `phm_mojavez`='".$phm_mojavez."'
						                      AND  
								                `phm_id_province`='".$_SESSION['dm_user_profile']['u_province_id']."'
								           ";
								 $lnk = mysql_query($query);
								// print $query;
								 if(mysql_num_rows($lnk)>0){ 
								 	
								 	$status=1;
								 	
								 	
								 }else{
								 	
									 	 $query = array(
										
									    'phm_reg_date'=> gmdate('Y-m-d'),
							            'phm_op_id'=>  $phm_op_id,
							            'phm_mojavez'=>   $phm_mojavez,
							            'phm_id_province'=>  $_SESSION['dm_user_profile']['u_province_id'],
									 	'phm_date_f'=>  $phm_date_f,
									 	'phm_date_l'=>  $phm_date_l,
									 	'phm_type_id'=>  $phm_type_id,
									 	'phm_ptype'=>  $phm_ptype,
							            'phm_status'=>   0, 
									 	'phm_amount'=>   $phm_amount,
									 	 'phm_amountpre'=>   $phm_amount,
							             
									);
								
									$query = inserterQMaker('dm_op_mojavez', $query);
									print $query;
									
									$lnk = mysql_query($query);
									if(mysql_error()) print mysql_error();
							print $query;
								 }
		    
	
	$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$status .';';
}


function validDocCode(){
	$d_code = isset($_REQUEST['d_code']) ? $_REQUEST['d_code'] : '';
	    $query = "SELECT *  FROM dm_documentk 
		        WHERE
		             `d_code`='".$d_code."' 
		        ";
		           
		   	    
	   $lnk = mysql_query($query);
    	print $query;
	   $row= mysql_fetch_assoc($lnk);
	   $status=0;
    	if(mysql_num_rows($lnk)>0){ 
    		 		
        $message='! كد تكراري است';
        $_SESSION['checkCodeDoc']=1;
		    $status=1;
		    
    	}else{
    		 $status=0;
    		 $_SESSION['checkCodeDoc']=0;
    	}
	$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$message .';'.$status.';';
	
}
function validDocCodek(){
	$d_code = isset($_REQUEST['d_code']) ? $_REQUEST['d_code'] : '';
	    $query = "SELECT *  FROM dm_documentk 
		        WHERE
		             `d_code`='".$d_code."' 
		       ";
		           
		   	    
	   $lnk = mysql_query($query);
    	print $query;
	   $row= mysql_fetch_assoc($lnk);
	   $status=0;
    	if(mysql_num_rows($lnk)>0){ 
    		 		
        $message='! كد تكراري است';
        $_SESSION['checkCodeDoc']=1;
		    $status=1;
		    
    	}else{
    		 $status=0;
    		 $_SESSION['checkCodeDoc']=0;
    	}
	$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$message .';'.$status.';';
	
}
function validCitycode(){
	$city_code = isset($_REQUEST['city_code']) ? $_REQUEST['city_code'] : '';
	    $query = "SELECT *  FROM dm_city 
		           WHERE 
		                `city_code`='".$city_code."'
                    AND  
		                `city_province`='".$_SESSION['dm_user_profile']['u_province_id']."'
		           ";
		   	    
	   $lnk = mysql_query($query);
    	print $query;
	   $row= mysql_fetch_assoc($lnk);
	   $status=0;
    	if(mysql_num_rows($lnk)>0){ 
    		 		
        $message='! كد تكراري است';
        $_SESSION['checkCodeDoc']=1;
		    $status=1;
		    
    	}else{
    		 $status=0;
    		 $_SESSION['checkCodeDoc']=0;
    	}
	$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$message .';'.$status.';';
	
}

function validProvincecode(){
	$province_code = isset($_REQUEST['province_code']) ? $_REQUEST['province_code'] : '';
	    $query = "SELECT *  FROM dm_province
		           WHERE `province_code`='".$province_code."' ";
		   	    
	   $lnk = mysql_query($query);
    	print $query;
	   $row= mysql_fetch_assoc($lnk);
	   $status=0;
    	if(mysql_num_rows($lnk)>0){ 
    		 		
        $message='! كد تكراري است';
        $_SESSION['checkCodeDoc']=1;
		    $status=1;
		    
    	}else{
    		 $status=0;
    		 $_SESSION['checkCodeDoc']=0;
    	}
	$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$message .';'.$status.';';
	
}
function validProvincecodeEdit(){
	
	$province_code = isset($_REQUEST['province_code']) ? $_REQUEST['province_code'] : '';
	$province_id = isset($_REQUEST['province_id']) ? $_REQUEST['province_id'] : '';
	    $query = "SELECT *  FROM dm_province
		           WHERE `province_code`='".$province_code."'
		           AND  `province_id` != '".$province_id."' ";
		   	    
	   $lnk = mysql_query($query);
    	print $query;
	   $row= mysql_fetch_assoc($lnk);
	   $status=0;
    	if(mysql_num_rows($lnk)>0){ 
    		 		
        $message='! كد تكراري است';
        $_SESSION['checkCodeDoc']=1;
		    $status=1;
		    
    	}else{
    		 $status=0;
    		 $_SESSION['checkCodeDoc']=0;
    	}
	$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$message .';'.$status.';';
	
}
function validDocCodeEdit(){
	$d_code = isset($_REQUEST['d_code']) ? $_REQUEST['d_code'] : '';
	$d_id = isset($_REQUEST['d_id']) ? $_REQUEST['d_id'] : '';
	    $query = "SELECT *  FROM dm_documentk 
		           WHERE  `d_code`='".$d_code."'
		           AND    `d_id` !='".$d_id."'
                   
		           
		           ";
		   	    
	   $lnk = mysql_query($query);
    	print $query;
	   $row= mysql_fetch_assoc($lnk);
	   $status=0;
    	if(mysql_num_rows($lnk)>0){ 
    		 		
        $message='! كد تكراري است';
        $_SESSION['checkCodeDoc']=1;
		    $status=1;
		    
    	}else{
    		 $status=0;
    		 $_SESSION['checkCodeDoc']=0;
    	}
    	if($_SESSION['dm_user_profile']['u_province_id']==3){
    		$status=0;
    		 $_SESSION['checkCodeDoc']=0;
    	}else{
	    	$query = "select * from   dm_pf_document 	                                  				
				where 
						   
						 dpf_d_id=".$d_id."
				 and
	                     dpf_id_province=".$_SESSION['dm_user_profile']['u_province_id']."";	
		    $lnk = mysql_query($query);
		    $row= mysql_fetch_assoc($lnk);
		   if(mysql_num_rows($lnk1)>0){
		           $message='! شما از اين كد سند استفاده كرده ايد و اجازه تغيير نداريد';
	       
			    $status=2;
		   }
    	}
	$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$message .';'.$status.';';
	
}
function validDocCodeEditk(){
	$d_code = isset($_REQUEST['d_code']) ? $_REQUEST['d_code'] : '';
	$d_id = isset($_REQUEST['d_id']) ? $_REQUEST['d_id'] : '';
	    $query = "SELECT *  FROM dm_documentk 
		           WHERE  `d_code`='".$d_code."'
		           AND    `d_id` !='".$d_id."'
                   AND    `d_id_province`=".$_SESSION['dm_user_profile']['u_province_id']."
		           
		           ";
		   	    
	   $lnk = mysql_query($query);
    	print $query;
	   $row= mysql_fetch_assoc($lnk);
	   $status=0;
    	if(mysql_num_rows($lnk)>0){ 
    		 		
        $message='! كد تكراري است';
        $_SESSION['checkCodeDoc']=1;
		    $status=1;
		    
    	}else{
    		 $status=0;
    		 $_SESSION['checkCodeDoc']=0;
    	}
    	if($_SESSION['dm_user_profile']['u_province_id']==3){
    		$status=0;
    		 $_SESSION['checkCodeDoc']=0;
    	}else{
	    	$query = "select * from   dm_pf_document 	                                  				
				where 
						   
						 dpf_d_id=".$d_id."
				 and
	                     dpf_id_province=".$_SESSION['dm_user_profile']['u_province_id']."";	
		    $lnk = mysql_query($query);
		    $row= mysql_fetch_assoc($lnk);
		   if(mysql_num_rows($lnk1)>0){
		           $message='! شما از اين كد سند استفاده كرده ايد و اجازه تغيير نداريد';
	       
			    $status=2;
		   }
    	}
	$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$message .';'.$status.';';
	
}
function edit_mojavezk(){
	
		$phm_mojavezj = isset($_REQUEST['phm_mojavezj']) ? $_REQUEST['phm_mojavezj'] : '';
		$phm_op_idj = isset($_REQUEST['phm_op_idj']) ? $_REQUEST['phm_op_idj'] : '';
		$phm_id = isset($_REQUEST['phm_id']) ? $_REQUEST['phm_id'] : '';
		$phm_type_id = isset($_REQUEST['phm_type_id']) ? $_REQUEST['phm_type_id'] : '';
		$phm_date_f = isset($_REQUEST['phm_date_f']) ? $_REQUEST['phm_date_f'] : '';
		$phm_date_l = isset($_REQUEST['phm_date_l']) ? $_REQUEST['phm_date_l'] : '';
		$phm_amount = isset($_REQUEST['phm_amount']) ? $_REQUEST['phm_amount'] : '';
		
		$query = "SELECT *  FROM dm_op_mojavez 
		           WHERE 
		                `phm_op_id`='".$phm_op_idj."'
		              AND
		               `phm_mojavez`='".$phm_mojavezj."'
                      
		              AND

		              `phm_date_f` ='".$phm_date_f."'
		              AND
		               `phm_date_l` ='".$phm_date_l."'
		           ";
		 $lnk = mysql_query($query);
		 $row= mysql_fetch_assoc($lnk);
		// print $query;
		 if(mysql_num_rows($lnk)>1){ 
		 	
		 	$status=1;
		 	
		 }else{
		 	$status=0;
			
		 }	    
	
	$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$status .';'.$row['phm_id_province'].';';
}
function edit_mojavez(){
	
		$phm_mojavez = isset($_REQUEST['phm_mojavez']) ? $_REQUEST['phm_mojavez'] : '';
		$phm_op_id = isset($_REQUEST['phm_op_id']) ? $_REQUEST['phm_op_id'] : '';
		$phm_id = isset($_REQUEST['phm_id']) ? $_REQUEST['phm_id'] : '';
		$phm_type_id = isset($_REQUEST['phm_type_id']) ? $_REQUEST['phm_type_id'] : '';
		
		$query = "SELECT *  FROM dm_op_mojavez 
		           WHERE 
		                `phm_op_id`='".$phm_op_id."'
		              AND
		               `phm_mojavez`='".$phm_mojavez."'
                      AND  
		                `phm_id_province`='".$_SESSION['dm_user_profile']['u_province_id']."'
		              AND

		              `phm_id` !='".$phm_id."'
		           ";
		 $lnk = mysql_query($query);
		 print $query;
		 if(mysql_num_rows($lnk)>1){ 
		 	
		 	$status=1;
		 	
		 }else{
		 	$status=0;
			
		 }	    
	
	$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$status .';';
}
function validCitycodeEdit(){
	$city_code = isset($_REQUEST['city_code']) ? $_REQUEST['city_code'] : '';
	$city_id = isset($_REQUEST['city_id']) ? $_REQUEST['city_id'] : '';
	    $query = "SELECT *  FROM dm_city 
		           WHERE `city_code`='".$city_code."'
		           AND   `city_id` !='".$city_id."' ";
		   	    
	   $lnk = mysql_query($query);
    	print $query;
	   $row= mysql_fetch_assoc($lnk);
	   $status=0;
    	if(mysql_num_rows($lnk)>0){ 
    		 		
        $message='! كد تكراري است';
      
		    $status=1;
		    
    	}else{
    		 $status=0;
    		 
    	}
	$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$message .';'.$status.';';
	
}
function checkExistCode(){
	 $p_code = isset($_REQUEST['p_code']) ? $_REQUEST['p_code'] : '';
	 $_SESSION['CheckCodep']=0;
	 $query = "dm_product product
				left join dm_price price
				on product.p_id=price.price_p_id
			   WHERE `p_code`='".$p_code."'
			   and
			   price_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
			   
			   ";
		           
		  	   $lnk = mysql_query($query);
             	  print $query;
			      $row= mysql_fetch_assoc($lnk);
			      if(mysql_num_rows($lnk)<0){ 
			      $_SESSION['CheckCodep']=1;
	      }
	
	$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$p_code.';';
	
}

function Datef(){
function virgul($number__,$decimal,$seperator__)
{//ÇÚÏÇÏ ÑÇ Óå ÑÞã Óå ÑÞã ÈÇ æíÑæá ÌÏÇ ãí˜äÏ
 if (!$seperator__) {$seperator__=","; return number_format($number__,$decimal);}
 $i__=strlen($number__);
 while ($i__>3)
 {$i__=$i__-3;$number__=substr_replace($number__,$seperator__,$i__,0);}
 return $number__;
}
	
	$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]';
	
}
function checkvalidData(){
	
 $code_customer = isset($_REQUEST['code_customer']) ? $_REQUEST['code_customer'] : '';
 $cm_req_date = isset($_REQUEST['cm_req_date']) ? $_REQUEST['cm_req_date'] : '';
 $cus_req_num = isset($_REQUEST['cus_req_num']) ? $_REQUEST['cus_req_num'] : ''; 
 $phm_id = isset($_REQUEST['phm_id']) ? $_REQUEST['phm_id'] : '';
 $query1 = "SELECT * FROM  dm_year where
            year_status=1 ";	
		$lnk1 = mysql_query($query1);
	//	print $query1;
		$row1= mysql_fetch_assoc($lnk1);
		$year_id=$row1['year_id'];
		
		if($_SESSION['dm_user_profile']['u_year_id']==$year_id)
		{	
			
			$querybed="SELECT * FROM temp_bed WHERE 
	
				            	  code % 100000 = ".$code_customer."
				            	  "; 
				            	  
				
				$lnkbed = mysql_query($querybed); 
				 if(mysql_num_rows($lnkbed)>0){
				 	
				 	
				 	$status3=1;
				 	
				 }
			 print $querybed;
			 $querypro="SELECT * FROM dm_province WHERE 
				            	  province_id=".$_SESSION['dm_user_profile']['u_province_id']; 
				$lnkpro = mysql_query($querypro); 
				$rowpro = mysql_fetch_assoc($lnkpro);
				$province_code=$rowpro['province_code'];
				
				$query11 = "SELECT *  FROM dm_customer_asli 
						           WHERE 
						              `code_customer`='".$code_customer."'";         
						       			         
						  	   $lnk11 = mysql_query($query11); 
				$row11= mysql_fetch_assoc($lnk11);
				print $query11;
				  $query = "SELECT *  FROM dm_customer 
						           WHERE 
						              `code_customer`='".$code_customer."'
						              and
						              `customer_code_org`=".$_SESSION['dm_user_profile']['u_province_id']; 
						         
						print  $query;        			         
						  	   $lnk = mysql_query($query);            	 
							    
				                  $status=0;		       
							      if(mysql_num_rows($lnk)==0){ 
							      	$row= mysql_fetch_assoc($lnk);
							      	$status=1;
							      	$message='   لطفا اطلاعات مشتری را کامل نمایید';
							      	
							      }else if($row11['customer_gl_economic']=='' and  $row11['customer_gl_code']==''){
							      	
							      	$status=1;
							      	$message='   اطلاعات اولیه این مشتری را درسیستم مالی کامل کنید';
							      	
							      }else{
							      	$row= mysql_fetch_assoc($lnk);
							      	 $customer_cusid_city=$row['customer_cusid_city'];
							      	 echo $row['customer_tel'];
							      //	 if($customer_cusid_city==''){
							      	  if($row['customer_tel']==''){
							      	 	$status=2;
							      	 	$message='ابتدا اطلاعات اين مشتري را در بخش اطلاعات پايه تكميل كنيد';
							      	  }
							      	// }else if($row['condition_activity_customer']==5){
							      	// 	$status=2;
							      	// 	$message='این مشتری وضعیت غیرفعال دارد';
							      	 	
							      	// }
					
							      }
		}else{
			
			$status=6;
			$message='شما در اين سال نميتوانيد عمليات ثبت انجام دهيد لطفا سال جديد را انتخاب كنيد';
		}				     				      
$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$status.';'.$message.';'.$status3.';'; 

}
function createmodat(){

	$out='<input name="phd_modat" id="phd_modat" type="text"  />';
		$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$out; 
	
}
function createselltype($dts_id){
	
 $dts_id = isset($_REQUEST['dts_id']) ? $_REQUEST['dts_id'] : '';

// if($dts_id==2){
// 
//			
//			
//		 $out = '<select id="selltype"  name="selltype"  >';
//						$lnk = mysql_query("SELECT * FROM dm_type_tazmin where 1");
//						if(mysql_num_rows($lnk)>0){
//							while($row=mysql_fetch_assoc($lnk)){
//								$out .= '<option  id="selltype" value="'.$row['dtz_id'].'" >'.$row['dtz_name'].'</option>';
//								
//							}
//						}
// 	//$out .='به مدت';
// 	//$out .=' :<input name="selltype" id="selltype" type="text" value="به مدت" />';
//	
// }else if($dts_id==3){
// 	
// 	
// 	
// $out = 'نوع:<select id="selltype"  name="selltype" >';
//				$lnk = mysql_query("SELECT * FROM dm_type_tahator  where  1");
//				if(mysql_num_rows($lnk)>0){
//					while($row=mysql_fetch_assoc($lnk)){
//						$out .= '<option value="'.$row['dtt_id'].'" >'.$row['dtt_name'].'</option>';
//						
//					}
//				}
// 	
// 	
// 	
// }else{
// 	
// 	$out='&nbsp;';
// 	
// }
	
 $GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$dts_id; 
//	$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$out; 
}
function createCityCombo(){
	
 $province_id = isset($_REQUEST['province_id']) ? $_REQUEST['province_id'] : '';
 $customer_id = isset($_REQUEST['customer_id']) ? $_REQUEST['customer_id'] : '';
  $lnkh = mysql_query("SELECT * FROM dm_customer_asli WHERE customer_id={$customer_id} ");
	    $rowh=mysql_fetch_assoc($lnkh);
	    
  $lnkhh = mysql_query("SELECT * FROM dm_customer_det WHERE code_customer=".$rowh['code_customer']."  AND  customer_code_org=".$province_id." ");
	    $rowhh=mysql_fetch_assoc($lnkhh);
 if($rowhh['customer_cusid_province']==0){
// $out = '<select id="cityCntnr"  name="cityCntnr"   onchange="alert(File selected)"  >';
	$lnk = mysql_query("SELECT * FROM dm_city where city_province=".$province_id."");
	$out = '<select id="cityCntnr"  name="cityCntnr"  onchange="hndlProvince_cityCombooo(\'\', this.value)"  ><option value="-2">همه شهر ها</option>';
	if(mysql_num_rows($lnk)>0){
		while($row=mysql_fetch_assoc($lnk)){
			$out .= '<option  id="cityCntnr" name="cityCntnr"  value="'.$row['city_id'].'" >'.$row['city_name'].'</option>';
			
		}
	}
 	
 }else{
 	$lnkp = mysql_query("SELECT * FROM dm_city WHERE city_id=".$rowhh['customer_cusid_city']."   ");
	    $rowp=mysql_fetch_assoc($lnkp);
 	
 $out = '<select id="cityCntnr"  name="cityCntnr" ><option value="'.$rowhh['customer_cusid_city'].'">"'.$rowp['city_name'].'"</option>';
	$lnk = mysql_query("SELECT * FROM dm_city where city_province=".$province_id."");
	if(mysql_num_rows($lnk)>0){
		$lnkcity = mysql_query("SELECT * FROM dm_city where city_id=".$province_id."");
            $rowcity=mysql_fetch_assoc($lnkcity);
		while($row=mysql_fetch_assoc($lnk)){
			
			
			
			$out .= '<option  id="cityCntnr"  name="cityCntnr" value="'.$row['city_id'].'" >'.$row['city_name'].'</option>';
			
		}
	}
 	

 }
	$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$out; 
}

function createCityCombooo(){
	
 $city_id = isset($_REQUEST['cityCntnr']) ? $_REQUEST['cityCntnr'] : '';
 
  $_SESSION['cityCntnr']=$city_id;
 // echo  $_SESSION['cityCntnr'];
 
	$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$city_id; 
}

function createCityCombo1(){
	
 $province_id = isset($_REQUEST['province_id']) ? $_REQUEST['province_id'] : '';
 
$out = '<select id="city_id"  name="city_id" ><option value="-2">همه شهر ها</option>';
	$lnk = mysql_query("SELECT * FROM dm_city where city_province='".$province_id."'");
//	print "SELECT * FROM dm_city where city_province=".$province_id."";
	if(mysql_num_rows($lnk)>0){
		while($row=mysql_fetch_assoc($lnk)){
			$out .= '<option value="'.$row['city_id'].'" >'.$row['city_name'].'</option>';
			
		}
	}
	$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$out; 
}
function validusername(){
	
	 $u_user_name = isset($_REQUEST['u_user_name']) ? $_REQUEST['u_user_name'] : '';	 
     $query = "SELECT *  FROM dm_user_profile 
			           WHERE 
			              `u_user_name`='".$u_user_name."'";
			        			         			         
			  	   $lnk = mysql_query($query);            	 
				    
	                  $status=0;		       
				      if(mysql_num_rows($lnk)>0){ 
				      	$row= mysql_fetch_assoc($lnk);
				      	$status=1;
				      	$message='چنين نام کاربری ایجاد شده است';
				      	
				      }
	
$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$status.';'.$message.';'; 	
}

function checkvalidcus(){
	
 $code_customer = isset($_REQUEST['code_customer']) ? $_REQUEST['code_customer'] : '';
 $cm_req_num = isset($_REQUEST['cm_req_num']) ? $_REQUEST['cm_req_num'] : '';
 $ph_code = isset($_REQUEST['ph_code']) ? $_REQUEST['ph_code'] : '';
 $ph_mojavez = isset($_REQUEST['ph_mojavez']) ? $_REQUEST['ph_mojavez'] : '';
 $cm_req_date = !empty($_REQUEST['cm_req_date1']) ? $_REQUEST['cm_req_date1'] : '';		

$date = explode('/', $cm_req_date);
     
    $cm_req_date=$date[2].'/'.$date[1].'/'.$date[0] ;
     
	$jdate=$cm_req_date;

	$jdate .= '/\/';
	list( $jyear, $jmonth, $jday ) = preg_split ( '/\//', $jdate );
	list( $gyear, $gmonth, $gday ) = jalali_to_gregorian($jyear, $jmonth, $jday);
	$cm_req_date = $gyear."-".$gmonth."-".$gday;
    print $cm_req_date;
 $querypro="SELECT * FROM dm_province WHERE 
	            	  province_id=".$_SESSION['dm_user_profile']['u_province_id']; 
	$lnkpro = mysql_query($querypro); 
	$rowpro = mysql_fetch_assoc($lnkpro);
	$province_code=$rowpro['province_code'];
  $query = "SELECT *  FROM dm_customer 
		           WHERE `code_customer`='".$code_customer."'
		           AND
			             customer_code_org=".$province_code."";
		         
		  	   $lnk = mysql_query($query);            	 
			    
                  $status=0;		       
			      if(mysql_num_rows($lnk)==0){ 
			      	$row= mysql_fetch_assoc($lnk);
			      	$status=1;
			      	$message='چنين كد مشتري وجود ندارد';
			      	
			      }else{
			      	//`ph_mojavez`= '".$ph_mojavez."' 
			      	$query = "
		UPDATE dm_pish_havale
		SET 
			`ph_customer_code` = '".$code_customer."',
			`cm_req_date`= '".$cm_req_date."' ,
			`cm_req_num`= '".$cm_req_num."'
			
									 
		WHERE 
			ph_code = ".$ph_code." 
		AND
		   ph_id_province  = ".$_SESSION['dm_user_profile']['u_province_id'] ." 
		AND
		  ph_id_year  = ".$_SESSION['dm_user_profile']['u_year_id'] .""; 
	
	print $query;
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
			      	
			      	
			      }
$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$status.';'.$message.';'.$ph_code.';'; 

}
function changeProvince(){
	
	$province_id = isset($_REQUEST['province_id']) ? $_REQUEST['province_id'] : '';
	$_SESSION['dm_user_profile']['u_province_id'] =  $province_id;
	$query = "SELECT *  FROM dm_province 
		           WHERE `province_id`='".$province_id."'
		           
		           
		           ";
		           
		  	   $lnk = mysql_query($query);
//             	  print $query;
			      $row= mysql_fetch_assoc($lnk);
	
	$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$_SESSION['pg'].';'.$_SESSION['cmd'].';'; 
}
function changeYear(){
	
	$year_id = isset($_REQUEST['year_id']) ? $_REQUEST['year_id'] : '';
	$_SESSION['dm_user_profile']['u_year_id'] =  $year_id;
		
	$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$_SESSION['pg'].';'.$_SESSION['cmd'].';'; 
}
function addNewHavaleDetail(){

		$ph_code = isset($_REQUEST['ph_code']) ? $_REQUEST['ph_code'] : '';
		$pf_code = isset($_REQUEST['pf_code']) ? $_REQUEST['pf_code'] : '';
		$phd_id = isset($_REQUEST['phd_id']) ? $_REQUEST['phd_id'] : '';
		
		$query = "
				UPDATE dm_pish_havale_det
				SET 
					
					`phd_status` = '". 1 ."'
								
				WHERE 
					phd_id = ".$phd_id." 
			";
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
	print $query;
	
//etelaat baraye print havale	
	$query1="SELECT * From dm_province  
	    WHERE
	     province_id=".$_SESSION['dm_user_profile']['u_province_id']."
	    ";	 
	$lnk1=mysql_query($query1);
	
	print mysql_error();
	$row1=mysql_fetch_assoc($lnk1);
	$province_name=$row1['province_name'];
	$province_id=$row1['province_id'];
	
	$queryph="SELECT * FROM dm_pish_havale 
	    WHERE
	      ph_code=".$ph_code."
	    AND
	       province_id=".$_SESSION['dm_user_profile']['u_province_id']."
	     AND
	       year_id=".$_SESSION['dm_user_profile']['u_year_id']."";
	     
	     
	$lnkph=mysql_query($queryph);	
	print mysql_error();
	$rowph=mysql_fetch_assoc($lnkph);
	
	$queryop="SELECT * FROM dm_operation_acc 
	    WHERE
	      g_id=".$rowph['ph_operation_id']."";
  
	$lnkop=mysql_query($queryop);	
	//print mysql_error();
	$rowop=mysql_fetch_assoc($lnkop);
	
	
	$code_customer=$rowph['ph_customer_code']; 	
	
	
	$querypro="SELECT * FROM dm_province WHERE 
	            	  province_id=".$_SESSION['dm_user_profile']['u_province_id']; 
	$lnkpro = mysql_query($querypro); 
	$rowpro = mysql_fetch_assoc($lnkpro);
	$province_code=$rowpro['province_code'];
	
	$queryc="SELECT * FROM dm_customer 
	    WHERE
	      code_customer=".$code_customer."
	    AND
	     customer_code_org=".$province_code."";
	     	     
	$lnkc=mysql_query($queryc);	
	print mysql_error();
	$rowc=mysql_fetch_assoc($lnkc);
	
	$name_customer=$rowc['name_customer'];
	
	
	$queryh="SELECT * FROM dm_havale 
	    WHERE
	    h_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
	     AND 
		 h_id_year=".$_SESSION['dm_user_profile']['u_year_id']."
	  ";
	
  
	$lnkh=mysql_query($queryh);	
	print mysql_error();
	if(mysql_num_rows($lnkh)==0){
		   $queryy = "SELECT * FROM  dm_year where
		            year_status=1 ";	
				$lnky = mysql_query($queryy);			
				$rowy= mysql_fetch_assoc($lnky);
				$year_code=$rowy['year_code'];
	     $h_code=$year_code.'000000';
	
	}else{

	$query="SELECT MAX(h_code) maxId FROM dm_havale 
	    WHERE
	    h_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
	     AND 
		 h_id_year=".$_SESSION['dm_user_profile']['u_year_id']."
	  ";
	
  print $query;  
	$lnk=mysql_query($query);	
	print mysql_error();
	
	$row=mysql_fetch_assoc($lnk);
	$h_code=$row['maxId'];
	}
	$h_code=$h_code+1;
//print $h_code;
$querys = "
			 	SELECT *  FROM dm_signature_g 
		 
				WHERE 
					sig_status = ". 1 ." 
				AND
				   sig_id_province=".$_SESSION['dm_user_profile']['u_province_id']  ."
				
			";
			$lnks = mysql_query($querys);
			$rows= mysql_fetch_assoc($lnks);
$query = array(
			
		    'h_reg_date'=> gmdate('Y-m-d'),
            'h_pf_code'=>  $pf_code,
            'h_code'=>   $h_code,
            'h_u_id'=>  $_SESSION['dm_user_profile']['u_id'],
            'h_status'=>   0, 
            'h_id_province' => $_SESSION['dm_user_profile']['u_province_id'], 
            'h_phd_id' => $phd_id,
            'h_sig_id' => $rows['sig_id'],
            'h_op_code' => $rowop['g_code'],   
		);
	
		$query = inserterQMaker('dm_havale', $query);
		$lnk = mysql_query($query);
		if(mysql_error()) print mysql_error();
		$h_id = mysql_insert_id();
		
//etelaat baraye print
$querydet = "
		UPDATE dm_pish_havale_det 
		SET 
			
			`phd_status` = '". 1 ."'			
		 WHERE 
			phd_id=".$phd_id ."";			
			$lnkdet = mysql_query($querydet);
			if(mysql_error()) print mysql_error();
		
	$query="SELECT * From dm_pish_havale_det  
		    WHERE
		     phd_id=".$phd_id ."";
	    	 
	$lnk=mysql_query($query);	
	print mysql_error();
	$row=mysql_fetch_assoc($lnk);
	$price_code=$row['phd_price_code']; 	 	
	$p_code=$row['phd_pid'];
	$l_id=$row['phd_l_id'];
		
	$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$phd_id.';'.$ph_code.';'.$h_code.';'.$province_name.';'.$province_id.';'.$name_customer.';'.$price_code.';'.$p_code.';'.$l_id.';'; 
}
function getDocInfo(){
	
	$dId = isset($_REQUEST['dId']) ? $_REQUEST['dId'] : 0;
	$lnk = mysql_query("SELECT * FROM dm_documentk WHERE d_id=".$dId);
	
	//if(mysql_num_rows($lnk)>0){
		$row = mysql_fetch_assoc($lnk); 

	//} 	
	$lnk1 = mysql_query("SELECT * FROM dm_doc_p WHERE docp_id=".$row['d_pardakht_t']);

	//if(mysql_num_rows($lnk1)>0){
		$row1 = mysql_fetch_assoc($lnk1);
	//} 
	$lnk2 = mysql_query("SELECT * FROM dm_doc_det_b WHERE doc_b_id=".$row['d_bank']);
	
	//if(mysql_num_rows($lnk2)>0){
		$row2 = mysql_fetch_assoc($lnk2);
	//} 
	
	
	$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$row1['docp_name'].';'.$row['d_accountnum'].';'.$row2['doc_b_name'].';'.$row['d_branch'].';'.$row['d_fluentaccount'].';';
	
	
}
function Deleteph_det(){
	
	$phd_id = isset($_REQUEST['phd_id']) ? $_REQUEST['phd_id'] : '';
	
	
		$queryphd = "
	select * FROM   dm_pish_havale_det
 
		WHERE 
			phd_id = ".$phd_id.""; 		
	
	$lnkphd = mysql_query($queryphd);
	$rowphd=mysql_fetch_assoc($lnkphd);
	

	$queryph = "
	select *  FROM   dm_pish_havale

		WHERE 
			 ph_code=".$rowphd['phd_ph_code']."
			 and
			 ph_id_province=".$_SESSION['dm_user_profile']['u_province_id']." "; 
						
	$lnkph = mysql_query($queryph);
	$rowph=mysql_fetch_assoc($lnkph);
	if(mysql_error()) print mysql_error();
	
	
		$ph_phm_id=$rowph['ph_phm_id'];
	
	
	//update mojavez
	
	$querymm="SELECT * FROM dm_op_mojavez WHERE phm_id=".$ph_phm_id."  ";
          
					print $querych;
					$lnkmm = mysql_query($querymm);
					$rowmm = mysql_fetch_assoc($lnkmm);
				echo 	$rowmm['phm_amount'];
				echo '/';
				echo $rowd['phd_amount'];
				echo '/';
				echo $rowmm['phm_amountes'];
					
	$phm_amount=($rowmm['phm_amount']+$rowphd['phd_amount']);
	$phm_amountes=($rowmm['phm_amountes']-$rowphd['phd_amount']);	
						
					$queryphm = "
							UPDATE dm_op_mojavez 
							SET 
								  			 
								`phm_amount` = '".$phm_amount."',
								`phm_amountes` = '".$phm_amountes."'   			
													 
							WHERE 
								phm_id = ".$ph_phm_id." 	";
								
						$lnkphm = mysql_query($queryphm);
					print ($queryphm);
					//echo '2220';
					if(mysql_error()) print mysql_error();		

	//
	
	
	$query = "
	DELETE FROM   dm_pish_havale_det
 
		WHERE 
			phd_id = ".$phd_id.""; 
	
	$lnk = mysql_query($query);
	if(mysql_error()) print mysql_error();
	
	
	
	
	$lnk1 = mysql_query("SELECT * FROM dm_anbar_det where dad_phd_id=".$phd_id."");
          
		while($row1=mysql_fetch_assoc($lnk1)){
			
			$lnk2 = mysql_query("SELECT * FROM mojody_kala where id=".$row1['dad_anbar_id']."");
			$row2=mysql_fetch_assoc($lnk2);
			
			if($row1['dad_no']==8){
				
				$meghdar=$row1['dad_tedad']+$row2['tedad_sold'];
				
				 $queryanbari = "
									UPDATE mojody_kala 
										SET 			
										
											
											`tedad_sold`  = '".$meghdar."'			
										WHERE 
											  id=".$row1['dad_anbar_id']."
									    
										";       						
								$lnkanbari = mysql_query($queryanbari);
				
				
				
			}else{
				
				$meghdar=$row1['dad_vazn_kh']+$row2['khales_sold'];
				
				
				 $queryanbari = "
								UPDATE mojody_kala 
									SET 			
									
										`khales_sold` = '". $meghdar ."'			
									WHERE 
										  id=".$row1['dad_anbar_id']."
								    
									";       						
							$lnkanbari = mysql_query($queryanbari);
				
				
				
			}	
			
		}
	
	
	$querydd = "DELETE FROM dm_anbar_det
	 
			WHERE 
				dad_phd_id = ".$phd_id." 
				
		";
		$lnkdd = mysql_query($querydd);
		if(mysql_error()) print mysql_error();	
	
	
	
	
		$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$phd_id; 
	
}
function checkAndValidProdNameEditM(){
	$p_price_code = isset($_REQUEST['p_price_code']) ? $_REQUEST['p_price_code'] : '';
    $p_name = isset($_REQUEST['p_name']) ? $_REQUEST['p_name'] : '';
    $status=0;
    $querypro="SELECT * FROM dm_province WHERE 
	            	  province_id=".$_SESSION['dm_user_profile']['u_province_id']; 
	$lnkpro = mysql_query($querypro); 
	$rowpro = mysql_fetch_assoc($lnkpro);
	$province_code=$rowpro['province_code'];
	
$queryc = "SELECT * FROM  mali.acc_mofaser_detail
			WHERE
				mk=8
			AND
				org=".$province_code."
            AND 
                name=".$p_name."
            AND
                code=".$p_price_code."";	
							    					       						       
								$lnkc = mysql_query($queryc);
								if(mysql_num_rows($lnkc)<0){
									  $rowc= mysql_fetch_assoc($lnkc);
									$status=1;
									$message='چنين كالايي با اين كد قيمت وجود ندارد';
									  
								}
	
	$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$status.';'.$message.';'; 
									
}
function EditphprodCheck(){
	
	$phd_id = !empty($_REQUEST['phd_id']) ? $_REQUEST['phd_id'] : '';
	$p_code =  !empty($_REQUEST['p_code']) ? $_REQUEST['p_code'] : '';
	$p_price_code =  !empty($_REQUEST['p_price_code']) ? $_REQUEST['p_price_code'] : '';
	$phd_amount =  !empty($_REQUEST['phd_amount']) ? $_REQUEST['phd_amount'] : '';
	$phd_id_unit =  !empty($_REQUEST['phd_id_unit']) ? $_REQUEST['phd_id_unit'] : '';
	$phd_l_id =  !empty($_REQUEST['phd_l_id']) ? $_REQUEST['phd_l_id'] : '';
	$phd_deli_name =  !empty($_REQUEST['phd_deli_name']) ? $_REQUEST['phd_deli_name'] : '';
	$phd_operation_id=  !empty($_REQUEST['phd_operation_id']) ? $_REQUEST['phd_operation_id'] : '';
	$phd_tahator=  !empty($_REQUEST['phd_tahator']) ? $_REQUEST['phd_tahator'] : '';
	$phd_tahator=  !empty($_REQUEST['phd_tahator']) ? $_REQUEST['phd_tahator'] : '';
	$phd_robari=  !empty($_REQUEST['phd_robari']) ? $_REQUEST['phd_robari'] : '';
	
	$queryl="SELECT * FROM dm_location_goods
	              where
				        l_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
				     AND  
				       l_id=".$phd_l_id."";  
			//	print  $queryphd;        	 
			$lnkl=mysql_query($queryl);	
			print mysql_error();
			$rowl= mysql_fetch_assoc($lnkl);
	
	
	
	
	$queryphd="SELECT * FROM dm_pish_havale ph
					left join dm_pish_havale_det phd
					
					on ph.ph_code=phd.phd_ph_code
				    WHERE
				        ph_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
				     AND
				        phd_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
				     AND  
				       phd_id=".$phd_id."";  
			//	print  $queryphd;        	 
			$lnkphd=mysql_query($queryphd);	
			print mysql_error();
			$rowphd= mysql_fetch_assoc($lnkphd);

	$phd_amount=str_replace(",","",$phd_amount);
			$query="SELECT * FROM dm_product product
					left join dm_price price
					on product.p_id=price.price_p_id 
				    WHERE
				        p_code=".$p_code ."
				    AND
				        p_price_code=".$p_price_code ."
				     AND
				        price_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
				     ";
			    	 
			$lnk=mysql_query($query);	
			print mysql_error();
		//	print $query;
             if(mysql_num_rows($lnk)==0){ 
			      	$row= mysql_fetch_assoc($lnk);
			      	$status=1;
			      	$message='چنين کالایی وجود ندارد';
			      	
			      }else{
		 	
			      	$row= mysql_fetch_assoc($lnk);
			      	
				if(($row1['p_category']=='9') AND ($phd_tahator=='-2')){        	
			      $status=2;
			      
			      	$message='نوع فروش وارد شود';

				}else if(($rowl['l_type']==3) AND ($phd_robari=='')){ 
					
				$status=2;
			      
			      	$message='محل روباری انتخاب شود';	
				}
				else{
			      	
	 	$queryunit="SELECT * FROM dm_prod_det_u 
	        WHERE unit_prod_id=".$phd_id_unit." ";
	        		           
		$lnkunit=mysql_query($queryunit);
		print mysql_error();
		$rowunit=mysql_fetch_assoc($lnkunit);
	    $unitName=$rowunit['unit_prod_name'];
		$ratio=$rowunit['unit_prod_ratio'];
      $queryaf = "SELECT * FROM dm_product product
				left join dm_price price
			    on product.p_id=price.price_p_id
				left join dm_charge_factors chf
				on product.p_code = chf.ch_code_good and price.p_price_code=chf.ch_pricecode_good
				left join dm_opr_ch opr_ch 
				on opr_ch.oph_ch_id=chf.ch_id
				left join dm_operation_acc opr_acc
				on opr_acc.g_id=opr_ch.oph_op_id
				left join dm_loc_ch lch  
				on  lch.chl_ch_id=chf.ch_id
				left join dm_location_goods l on l.l_id=lch.chl_l_id
		
			WHERE
          			        oph_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
					AND
						    price_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
				    AND
						    l_id=".$phd_l_id."
					AND
						    ch_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
				    AND
						    l_id_province=".$_SESSION['dm_user_profile']['u_province_id']."
				    AND
					        p_code=".$p_code." 
					AND    
					        p_price_code=".$p_price_code."
				    AND
		                    g_id=".$rowphd['ph_operation_id']."  
		            AND
		                    chl_id_province=".$_SESSION['dm_user_profile']['u_province_id']."    
		             AND          
		                    '".gmdate('Y-m-d')."'   between  `ch_fdate`   AND  `ch_ldate` ";   
		                     				 	
		$lnkaf = mysql_query($queryaf);
	//print 	$queryaf;
	  if(mysql_num_rows($lnkaf)>0){
	  	
	  	$rowaf= mysql_fetch_assoc($lnkaf);
	  	$ch_dependancy=$rowaf['ch_dependancy'];
		 
		$p_sellpriceh= $rowaf['p_sellprice'] +$rowaf['ch_p_add'];		  	

		$phd_priceh=(($ratio )* (($phd_amount )* ($p_sellpriceh)) );
		$phd_p_priceh=$p_sellpriceh;
        $phd_p_price = $row['p_sellprice'];
        $phd_price=(($ratio )* (($phd_amount )* ($rowaf['p_sellprice'])));  
        
        $phd_afzodani=1;	  	
	  }else{
	  		  	
	  	$phd_price=(($ratio )* (($phd_amount )* ($row['p_sellprice'])));
		$phd_priceh=(($ratio )* (($phd_amount )* ($row['p_sellprice'])));
        $phd_p_price=$row['p_sellprice'];
        $phd_p_priceh=$row['p_sellprice'];	  
        $phd_afzodani=0;	
	  }	
			      	
					      				      			 		      				      				      	
			      	$query = "
							UPDATE  dm_pish_havale_det
							SET 
								
								`phd_amount` = '".$phd_amount."',
								`phd_pid` = '".$p_code."',
								`phd_l_id` = '".$phd_l_id."',
								`phd_deli_name` = '".$phd_deli_name."',
								`phd_price` = '".$phd_price."',								
								`phd_p_price` = '".$phd_p_price."',
								`phd_priceh` = '".$phd_priceh."',								
								`phd_p_priceh` = '".$phd_p_priceh."',	
								`phd_price_code` = '".$p_price_code."',								
								`phd_id_unit` = '".$phd_id_unit."',
								`phd_p_add` ='".$rowaf['ch_p_add']."',
								`phd_afzodani` ='".$phd_afzodani."',
								`phd_tahator` ='".$phd_tahator."',
								`phd_robari` ='".$phd_robari."',							   
							    `phd_u_id` ='".$_SESSION['dm_user_profile']['u_id']."',	
							    `phd_id_year` ='".$_SESSION['dm_user_profile']['u_year_id']."'																								
							WHERE 							
								`phd_id` = ".$phd_id.""; 
												
						$lnk = mysql_query($query);
					//	print $query;
						if(mysql_error()) print mysql_error();
			      }
						//*
								      }
						
	$GLOBALS['ajaxRes'] = '[*]ok[*]no[*]'.$status.';'.$message.';'; 
	
}

function mojodyMojazTedad($id,$c_ostan,$c_anbar,$sal,$c_ziranbar,$c_kala,$c_keshvar,$c_tolidkonande,$sal_tolid,$mah_tolid,$rouz_tolid,$c_karton)
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
function mojodyMojazKhales($id,$c_ostan,$c_anbar,$sal,$c_ziranbar,$c_kala,$c_keshvar,$c_tolidkonande,$sal_tolid,$mah_tolid,$rouz_tolid,$c_karton)
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
//////////////////////////////////////////
//////////////////////////////////////////
//اگر کالا علوفه ایی 
//تابع محاسبه موجودی فعلی کالا
function mandePasAzKasrKala($c_ostan,$c_anbar,$sal,$c_kala,$id_ostan,$id_anbar,$id_sal)
{     
  $q="SELECT SUM(mojody_aval) FROM bzacc.mojody_kala WHERE code_ostan=$c_ostan AND code_anbar=$c_anbar AND year=$sal AND code_kala='$c_kala' AND deleted=0";   
  $result=mysql_query($q);
  $row=mysql_fetch_array($result);
  $mojodyAval=$row[0];	
  $q_varede="SELECT SUM(vazn_khales) FROM bzacc.resid WHERE code_ostan=$c_ostan AND code_anbar=$c_anbar AND year=$sal AND code_kala='$c_kala' AND deleted=0 AND status=0";   
  $res_varede=mysql_query($q_varede);
  $row_varede=mysql_fetch_array($res_varede);
  $jameVarede=$row_varede[0];   
  $q_sadere="SELECT SUM(vazn_khales_h) FROM bzacc.havale WHERE code_ostan=$c_ostan AND code_anbar=$c_anbar AND year=$sal AND code_kala='$c_kala' AND deleted=0 AND status=0";
  $res_sadere=mysql_query($q_sadere);
  $row_sadere=mysql_fetch_array($res_sadere);
  $jameSadere=$row_sadere[0];
  $q_tadil_ezafe="SELECT SUM(meghdar_tadil) FROM bzacc.tadil_mojody WHERE noe_tadil=1 AND code_ostan=$c_ostan AND code_anbar=$c_anbar AND year=$sal AND code_kala='$c_kala' AND deleted=0 AND status=0";   
  $res_tadil_ezafe=mysql_query($q_tadil_ezafe);
  $row_tadil_ezafe=mysql_fetch_array($res_tadil_ezafe);
  $meghdarTadil_Ezafe=$row_tadil_ezafe[0];
  $q_tadil_kasry="SELECT SUM(meghdar_tadil) FROM bzacc.tadil_mojody WHERE noe_tadil=2 AND code_ostan=$c_ostan AND code_anbar=$c_anbar AND year=$sal AND code_kala='$c_kala' AND deleted=0 AND status=0";   
  $res_tadil_kasry=mysql_query($q_tadil_kasry);
  $row_tadil_kasry=mysql_fetch_array($res_tadil_kasry);
  $meghdarTadil_Kasry=$row_tadil_kasry[0];
  $mojody=$mojodyAval+$jameVarede-$jameSadere+$meghdarTadil_Ezafe-$meghdarTadil_Kasry;
  $q_forush="SELECT SUM(h_mande_havale) FROM sell.dm_havale WHERE h_p_code='$c_kala' AND h_id_province='$id_ostan' AND h_l_code='$id_anbar' AND h_id_year='$id_sal'";
  $res_forush=mysql_query($q_forush);
  $row_forush=mysql_fetch_array($res_forush);
  $jameMandeForush=$row_forush[0];  
  $mande_pasazkasr=$mojody-$jameMandeForush;
  if($mande_pasazkasr<0) $mande_pasazkasr=0;
  return $mande_pasazkasr;
}


/////////////////////////////////////////////////////   

//اگر کالا گوشتی وبسته بندی قوطی
function mandePasAzKasrTedad($c_ostan,$c_anbar,$sal,$c_kala,$id_ostan,$id_anbar,$id_sal)
{     
  $q="SELECT SUM(tedad_karton_aval) FROM meat.mojody_kala WHERE code_ostan=$c_ostan AND code_anbar=$c_anbar AND year=$sal AND code_kala='$c_kala'  AND deleted=0";   
  $result=mysql_query($q);
  $row=mysql_fetch_array($result);
  $tedadKartonAval=$row[0];	
  $q_varede="SELECT SUM(tedad_karton_r_d_sub) FROM meat.resid_kala_detail WHERE code_ostan=$c_ostan AND code_anbar=$c_anbar AND year=$sal AND code_kala='$c_kala'  AND resid_deleted=0 AND status=0";   
  $res_varede=mysql_query($q_varede);
  $row_varede=mysql_fetch_array($res_varede);
  $jameKartonVarede=$row_varede[0]; 
  $q_sadere="SELECT SUM(tedad_karton_h_d) FROM meat.havale_detail WHERE code_ostan=$c_ostan AND code_anbar=$c_anbar AND year=$sal AND code_kala='$c_kala'  AND havale_deleted=0 AND status=0";
  $res_sadere=mysql_query($q_sadere);
  $row_sadere=mysql_fetch_array($res_sadere);
  $jameKartonSadere=$row_sadere[0];
  $q_tadil_ezafe="SELECT SUM(tedad_karton_tadil) FROM meat.tadil_mojody WHERE noe_tadil=1 AND code_ostan=$c_ostan AND code_anbar=$c_anbar AND year=$sal AND code_kala='$c_kala'  AND status=0 AND deleted=0";   
  $res_tadil_ezafe=mysql_query($q_tadil_ezafe);
  $row_tadil_ezafe=mysql_fetch_array($res_tadil_ezafe);
  $kartonTadilEzafe=$row_tadil_ezafe[0];
  $q_tadil_kasry="SELECT SUM(tedad_karton_tadil) FROM meat.tadil_mojody WHERE noe_tadil=2 AND code_ostan=$c_ostan AND code_anbar=$c_anbar  AND year=$sal AND code_kala='$c_kala'   AND status=0 AND deleted=0";   
  $res_tadil_kasry=mysql_query($q_tadil_kasry);
  $row_tadil_kasry=mysql_fetch_array($res_tadil_kasry);
  $kartonTadilKasry=$row_tadil_kasry[0];
  $tedadKarton=$tedadKartonAval+$jameKartonVarede-$jameKartonSadere+$kartonTadilEzafe-$kartonTadilKasry;
  $q_forush="SELECT SUM(h_mande_havale) FROM sell.dm_havale WHERE h_p_code='$c_kala' AND h_id_province='$id_ostan' AND h_l_code='$id_anbar' AND h_id_year='$id_sal'";
  $res_forush=mysql_query($q_forush);
  $row_forush=mysql_fetch_array($res_forush);
  $jameMandeForush=$row_forush[0];  
  $mande_pasazkasr_tedad=$tedadKarton-$jameMandeForush;
  if($mande_pasazkasr_tedad<0) $mande_pasazkasr_tedad=0;
  return $mande_pasazkasr_tedad;

}

////////////////////////////////////////////////////////////////////////////////
//اگر کالاگوشتی و بسته بندی کارتنی یا لاشه باشد
function mandePasAzKasrKhales($c_ostan,$c_anbar,$sal,$c_kala,$id_ostan,$id_anbar,$id_sal)

{  

	

  $q="SELECT SUM(mojody_khales_aval) FROM meat.mojody_kala WHERE code_ostan=$c_ostan AND code_anbar=$c_anbar AND year=$sal AND code_kala='$c_kala'  AND deleted=0";   
  $result=mysql_query($q);
  $row=mysql_fetch_array($result);
  $mojodyKhalesAval=$row[0];	
  $q_varede="SELECT SUM(vazn_khales_r_d_sub) FROM meat.resid_kala_detail WHERE code_ostan=$c_ostan AND code_anbar=$c_anbar AND year=$sal AND code_kala='$c_kala'  AND resid_deleted=0 AND status=0";   
  $res_varede=mysql_query($q_varede);
  $row_varede=mysql_fetch_array($res_varede);
  $jameKhalesVadere=$row_varede[0]; 
  $q_sadere="SELECT SUM(vazn_khales_h_d) FROM meat.havale_detail WHERE code_ostan=$c_ostan AND code_anbar=$c_anbar AND year=$sal AND code_kala='$c_kala'   AND havale_deleted=0 AND status=0";
  $res_sadere=mysql_query($q_sadere);
  $row_sadere=mysql_fetch_array($res_sadere);
  $jameKhalesSadere=$row_sadere[0];
  $q_tadil_ezafe="SELECT SUM(meghdar_khales_tadil) FROM meat.tadil_mojody WHERE noe_tadil=1 AND code_ostan=$c_ostan AND code_anbar=$c_anbar AND year=$sal AND code_kala='$c_kala'  AND status=0 AND deleted=0";   
  $res_tadil_ezafe=mysql_query($q_tadil_ezafe);
  $row_tadil_ezafe=mysql_fetch_array($res_tadil_ezafe);
  $khalesTadilEzafe=$row_tadil_ezafe[0];
  $q_tadil_kasry="SELECT SUM(meghdar_khales_tadil) FROM meat.tadil_mojody WHERE noe_tadil=2 AND code_ostan=$c_ostan AND code_anbar=$c_anbar AND year=$sal AND code_kala='$c_kala'  AND status=0 AND deleted=0";   
  $res_tadil_kasry=mysql_query($q_tadil_kasry);
  $row_tadil_kasry=mysql_fetch_array($res_tadil_kasry);
  $khalesTadilKasry=$row_tadil_kasry[0];
  $khales=$mojodyKhalesAval+$jameKhalesVadere-$jameKhalesSadere+$khalesTadilEzafe-$khalesTadilKasry;
  $q_forush="SELECT SUM(h_mande_havale) FROM sell.dm_havale WHERE h_p_code='$c_kala' AND h_id_province='$id_ostan' AND h_l_code='$id_anbar' AND h_id_year='$id_sal'";
  $res_forush=mysql_query($q_forush);
  $row_forush=mysql_fetch_array($res_forush);
  $jameMandeForush=$row_forush[0];  
  $mande_pasazkasr_khales=$khales-$jameMandeForush;
  if($mande_pasazkasr_khales<0) $mande_pasazkasr_khales=0;
  echo  round($mande_pasazkasr_khales,3);
  return round($mande_pasazkasr_khales,3);
}
//اگر کالا گوشتی و بسته بندی شانه بود
function mandePasAzKasrShane($c_ostan,$c_anbar,$sal,$c_kala,$id_ostan,$id_anbar,$id_sal)
{ 

  $q="SELECT SUM(tedad_shane_aval) FROM meat.mojody_kala WHERE code_ostan=$c_ostan AND code_anbar=$c_anbar AND year=$sal AND code_kala='$c_kala'  AND deleted=0";   
  $result=mysql_query($q);
  $row=mysql_fetch_array($result);
  $mojodyAval=$row[0];    
  $q_varede="SELECT SUM(tedad_shane_r_d_sub) FROM meat.resid_kala_detail WHERE code_ostan=$c_ostan AND code_anbar=$c_anbar AND year=$sal AND code_kala='$c_kala'  AND resid_deleted=0 AND status=0";   
  $res_varede=mysql_query($q_varede);
  $row_varede=mysql_fetch_array($res_varede);
  $jameVadere=$row_varede[0]; 
  $q_sadere="SELECT SUM(tedad_shane_h_d) FROM meat.havale_detail WHERE code_ostan=$c_ostan AND code_anbar=$c_anbar AND year=$sal AND code_kala='$c_kala'   AND havale_deleted=0 AND status=0";
  $res_sadere=mysql_query($q_sadere);
  $row_sadere=mysql_fetch_array($res_sadere);
  $jameSadere=$row_sadere[0];
  $q_tadil_ezafe="SELECT SUM(tedad_shane_tadil) FROM meat.tadil_mojody WHERE noe_tadil=1 AND code_ostan=$c_ostan AND code_anbar=$c_anbar AND year=$sal AND code_kala='$c_kala'  AND status=0 AND deleted=0";   
  $res_tadil_ezafe=mysql_query($q_tadil_ezafe);
  $row_tadil_ezafe=mysql_fetch_array($res_tadil_ezafe);
  $TadilEzafe=$row_tadil_ezafe[0];
  $q_tadil_kasry="SELECT SUM(tedad_shane_tadil) FROM meat.tadil_mojody WHERE noe_tadil=2 AND code_ostan=$c_ostan AND code_anbar=$c_anbar AND year=$sal AND code_kala='$c_kala'  AND status=0 AND deleted=0";   
  $res_tadil_kasry=mysql_query($q_tadil_kasry);
  $row_tadil_kasry=mysql_fetch_array($res_tadil_kasry);
  $TadilKasry=$row_tadil_kasry[0];
  $Shane=$mojodyAval+$jameVadere-$jameSadere+$TadilEzafe-$TadilKasry;
  $q_forush="SELECT SUM(h_mande_havale) FROM sell.dm_havale WHERE h_p_code='$c_kala' AND h_id_province='$id_ostan' AND h_l_code='$id_anbar' AND h_id_year='$id_sal'";
  $res_forush=mysql_query($q_forush);
  $row_forush=mysql_fetch_array($res_forush);
  $jameMandeForush=$row_forush[0];  
  $mande_pasazkasr_Shane=$Shane-$jameMandeForush;
  if($mande_pasazkasr_Shane<0) $mande_pasazkasr_Shane=0;
  return $mande_pasazkasr_Shane;
}

//موجودی تعداد مجاز
function mojodyMojazTedad2($id,$c_ostan,$c_anbar,$sal,$c_ziranbar,$c_kala,$c_keshvar,$c_tolidkonande,$sal_tolid,$mah_tolid,$rouz_tolid,$c_karton)
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
function mojodyMojazKhales2($id,$c_ostan,$c_anbar,$sal,$c_ziranbar,$c_kala,$c_keshvar,$c_tolidkonande,$sal_tolid,$mah_tolid,$rouz_tolid,$c_karton)
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
//موجودی شانه مجاز
function mojodyMojazShane($id,$c_ostan,$c_anbar,$sal,$c_ziranbar,$c_kala,$c_keshvar,$c_tolidkonande,$sal_tolid,$mah_tolid,$rouz_tolid,$c_karton)
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
