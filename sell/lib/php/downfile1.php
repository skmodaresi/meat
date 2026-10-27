<?php
include_once 'jdf.php';
include_once 'db_connect.php';
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
	     $out='';	
	     $out1='';	
	     $out2='';
	     $out4='';	
	      $out6='';				
	    $queryh = "
				 SELECT *  FROM dm_havale 			 
					 WHERE 
							h_reg_date = '".$doc_date."' 
					   AND 
							h_id_province='".$id_province."'
					   
						
					  ";		  	    					   
    	 $lnkh = mysql_query($queryh);  
    	// echo mysql_num_rows($lnkh); 
    	 if(mysql_num_rows($lnkh)==0){
    	 	?>
    	 	<script type="text/javascript">
            window.location.href = "khata.html"
        </script>
        <?php
    	 	
    	 }else{
				    //	print $queryh;
				//while asli
					while($rowh = mysql_fetch_assoc($lnkh))
					
					{       																		               
				        $pf_code=$rowh['h_pf_code'];						                				                 
					    $customer_code=$rowh['h_customer_code'];					                
				        $p_code = $rowh['h_p_code'];
				        $queryc = "SELECT *  FROM dm_customer 
					           WHERE `code_customer`='".$customer_code."'
					           AND
						             customer_code_org=".$id_province."";
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
				    		                    	$operation_code1= str_pad($operation_code, 6, "0", STR_PAD_LEFT);     
				    		                    	$code=$rowac['ac_code_p_bed'];   		                
				    		                    //	$code = str_replace( "c", $h_customer_code, $code ); 
					    		                   // $code = str_replace( "g", $h_price_code, $code );
					    		                   // $code = str_replace( "a", $operation_code, $code );
					    		             //   echo $operation_code;
					    		              $sh=' شماره حواله '.$rowh['h_code'].' ';
					    		              $fh='پيش فاكتور  '.$rowpf['pf_code'].' ';
					    		              $fph='پيش حواله  '.$rowpf['pf_ph_code'].' ';
					    		              $customer_name=str_replace("ی","ي",$rowc['name_customer']); 
					    		              $customer_name=str_replace("&#1740","", $customer_name);
						                     $customer_name=str_replace(";","", $customer_name);
					    		            $gh='مشتري به نام '.$customer_name.' ';
					    		            $mojavez= iconv("utf-8","windows-1256",$mojavez);	
					    		              $moj='/شماره مجوز'.$mojavez;
					    		              $pish='پيش فروش';
					    		              $a='000000';
					    		             $h_price =$rowh['h_pre_amount'] * $rowh['h_p_price'];
				           		                   
					    		              $ac_topic_p_bes=str_replace("ی","ي",$rowac['ac_topic_p_bes']);
					    		                  // $out1 .='100;'. $year_number .''.$month_number.';'. $year_number .''.$month_number.''.$day_number.';'. $code .''. $h_customer_code  .''. $h_price_code .''. $a .''. $operation_code1 .';'. 0 .';'. $rowh['h_price'] .';'. 2 .'; '.$ac_topic_p_bes.''. $sh .''. $fh .'/'.$fph.''. $gh .' '. 14 .''. 15 .';'. 12 .';'. 17 .';'. $date[2].''.$date[1].''.$date[0] .';'. 18 .';';
				                                 $out1 .='100;'. $year_number .''.$month_number.';'. $year_number .''.$month_number.''.$day_number.';'.$code.''.$h_customer_code .''.$h_price_code.''. $a .''.$operation_code1.';'. 0 .';'.$h_price.';'. 2 .';'.$ac_topic_p_bes.''. $sh .''. $fh .'/'.$fph.''. $gh .''. $g_acc_name .''. $moj .';'. 12 .';'. $rowh['h_code'] .';'. $date[2].''.$date[1].''.$date[0] .';'. $rowh['h_pre_amount'] .';';
				                                   $out1 .= "\n"; 
				                                   if($rowh['h_p_add']!=0){
				                                    	 $ezaf=$rowh['h_p_add']* $rowh['h_pre_amount'];
				                                    	 $code1='602015';
					                                   	 $out1 .='100;'. $year_number .''.$month_number.';'. $year_number .''.$month_number.''.$day_number.';'.$code1.''.$h_customer_code .''.$h_price_code.''. $a .''.$operation_code1.';'. 0 .';'.$ezaf.';'. 2 .';'.$ac_topic_p_bes.''. $sh .''. $fh .'/'.$fph.''. $gh .''. $g_acc_name .''. $moj .';'. 12 .';'. $rowh['h_code'] .';'. $date[2].''.$date[1].''.$date[0] .';'. $rowh['h_pre_amount'] .';';
					                                     $out1 .= "\n";
				                                   	
				                                   }
				           	                    	 		                   
				    		                   	}	
				//while baraye poli ke rikhtan 
						$queryh = "
								 SELECT 
								 h_pf_code,
								 h_customer_code,
								 h_price_code
								   FROM dm_havale 			 
							WHERE 
										h_reg_date = '".$doc_date."' 
									AND 
										h_id_province= '".$id_province."'
														
											group by  h_pf_code";	
						
								// print 	$queryh;											     	 										   
				    			     $lnkh = mysql_query($queryh);                    	
				                     while($rowh = mysql_fetch_assoc($lnkh)){	
				                     					 
				                               $queryc = "SELECT *  FROM dm_customer 
											           WHERE `code_customer`='".$rowh['h_customer_code']."'
											           AND
												             customer_code_org=".$id_province."";
				                              
											    $lnkc = mysql_query($queryc);
											    $rowc= mysql_fetch_assoc($lnkc);
											 //   $customer_name=str_replace("ي","ی",$rowc['name_customer']);
											  $customer_name=str_replace("ی","ي",$rowc['name_customer']); 
											  $customer_name=str_replace("&#1740","", $customer_name);
						                     $customer_name=str_replace(";","", $customer_name);
											  $customer_name= str_pad($customer_name, 10);
					    		            $gh='مشتري به نام '.$customer_name.' ';
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
															 SELECT *  FROM dm_document 			 
															 WHERE 
															 		d_id = '".$d_id."' ";
																				 		
					    		                    	//print $queryd;    		                    	    		                  	    		                     
					    		                   	$lnkd= mysql_query($queryd);
					    		                   	$rowd = mysql_fetch_assoc($lnkd); 
					    		                   	$querydt = "
															 SELECT *  FROM dm_doc_det_t			 
															 WHERE 
															 	doc_t_id = '".$rowd['d_documenttype']."'"; 
							    		                    	    		                  	    		                     
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
					    		                   		    $d_ac_bes_dis=str_replace("ی","ي",$rowd['d_ac_bes_dis']); 
					    		                   		    
					    		                   		      $sh=' اضاف پرداخت  '.$rowh['h_code'].' ';
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
					    		                   		        
				                                        $out1.='100;'. $year_number .''.$month_number.';'. $year_number .''.$month_number.''.$day_number.';'.$code.''.$h_customer_code.''.$a.''.$a.''.$ope1.';'. 0 .';'.$dpf_price.';'. 2 .';'.$d_ac_bes_dis.''.$sh.'/'.$fh.'/'.$fph.''.$gh.';'. 4 .';'. $dpf_num .';'. $year_code .''.$date[1].''.$date[0] .';'. $h_amount .'';	
				                                            								
							    		                  $out1 .= "\n";     	    		                   		
					    		                   		
					    		                   	}else if($rowd['d_pardakht_t']==1) {
					    		                  //pardakhti
					    		                        $ope=$operation_code;
					    		                   		  $h_customer_code= str_pad($rowh['h_customer_code'], 6, "0", STR_PAD_LEFT);
					    		                   		  $h_price_code= str_pad($rowh['h_price_code'], 6, "0", STR_PAD_LEFT);
					    		                   		  $ope1= str_pad($ope, 6, "0", STR_PAD_LEFT);
							    		                    $code =$rowd['d_ac_bed']; 
							    		                    $a='000000';  
							    		                    
							    		                        $doc_t_name=str_replace("ی","ي",$rowdt['doc_t_name']);
							    		                        $sh='/ سند از نوع  '.$doc_t_name.'/پيش فاكتور  '.$pf_code.'/شماره فيش '.$rowdpf['dpf_num'].'/پيش حواله  '.$rowph['ph_code'].'';  
							    		                   // $code = str_replace( "c", $h_customer_code, $code ); 
							    		                    $code = str_replace( "g", $h_price_code, $code );
							    		                    $code = str_replace( "a", $operation_code, $code ); 
					    		                            $d_ac_bed_dis=str_replace("ی","ي",$rowd['d_ac_bed_dis']); 
					    		                            $dpf_sarresid =str_replace("/","",$rowdpf['dpf_sarresid']);
					    		                            $ope1='000301';
					    		                   	    if($rowh['h_amount']==0){
					    		                   		        	$h_amount=$rowh['h_amount'];
					    		                   		        }else{
					    		                   		        	$h_amount=$rowh['h_ebtalk_amount'];
					    		                   		        	
					    		                   		        }
					    		                            $out2 .='100;'. $year_number .''.$month_number.';'. $year_number .''.$month_number.''.$day_number.';'.$code.''.$a.''.$a.''.$ope1.';'.$dpf_price.';'. 0 .';'. 1 .';'.$d_ac_bed_dis.''. $sh .''. $gh .';'.$rowdpf['dpf_type'].';'. $rowdpf['dpf_num'] .';'. $dpf_sarresid .';'. $h_amount .'';    
					    		                               
					    		                      $out2 .= "\n"; 
					    		                   	}else if($rowd['d_pardakht_t']==3){
					    		                   	
					    		                   		$ope=$operation_code;
					    		                   		  $h_customer_code= str_pad($rowh['h_customer_code'], 6, "0", STR_PAD_LEFT);
					    		                   		  $h_price_code= str_pad($rowh['h_price_code'], 6, "0", STR_PAD_LEFT);
					    		                   		  $ope1= str_pad($ope, 6, "0", STR_PAD_LEFT);
							    		                    $code =$rowd['d_ac_bed']; 
							    		                    $bank = substr($code,6, 6);
							    		                    $tafzili = substr($code,0, 6);
							    		  
							    		                    $a='000000';  
							    		                    
							    		                        $doc_t_name=str_replace("ی","ي",$rowdt['doc_t_name']);
							    		                        $sh='/ سند از نوع  '.$doc_t_name.'/پيش فاكتور شماره '.$pf_code.'/شماره فيش '.$rowdpf['dpf_num'].'/پيش حواله  '.$rowph['ph_code'].'';  
							    		                   // $code = str_replace( "c", $h_customer_code, $code ); 
							    		                    $code = str_replace( "g", $h_price_code, $code );
							    		                    $code = str_replace( "a", $operation_code, $code ); 
					    		                            $d_ac_bed_dis=str_replace("ی","ي",$rowd['d_ac_bed_dis']); 
					    		                            $dpf_sarresid =str_replace("/","",$rowdpf['dpf_sarresid']);
					    		                             $ope1='000301';
					    		                            $out2.='100;'. $year_number .''.$month_number.';'. $year_number .''.$month_number.''.$day_number.';'.$tafzili.''.$h_customer_code.''.$bank.''.$a.''.$ope1.';'.$dpf_price.';'. 0 .';'. 1 .';'.$d_ac_bed_dis.''. $sh .''. $gh .';'.$rowdpf['dpf_type'].';'. $rowdpf['dpf_num'] .';'.  $dpf_sarresid .';'. $rowh['h_pre_amount'] .'';    
					    		                            $out2 .= "\n"; 
					    		                   		
					    		                   	}else if($rowd['d_pardakht_t']==4){
					    		                   		
					    		                   		$ope=$operation_code ;
					    		                   		
					    		                   		  $h_customer_code= str_pad($rowh['h_customer_code'], 6, "0", STR_PAD_LEFT);
					    		                   		  $h_price_code= str_pad($rowh['h_price_code'], 6, "0", STR_PAD_LEFT);
					    		                   		  $ope1= str_pad($ope, 6, "0", STR_PAD_LEFT);
							    		                  $code =$rowd['d_ac_bed']; 
							    		                  $a='000000';  
							    		                   
							    		                  $doc_t_name=str_replace("ی","ي",$rowdt['doc_t_name']);
							    		                  $sh='/ سند از نوع  '.$doc_t_name.'/پيش فاكتور شماره '.$pf_code.'/شماره فيش '.$rowdpf['dpf_num'].'';  
							    		                  $ph='/پيش حواله  '.$rowpf['pf_ph_code'].'';
							    		                   // $code = str_replace( "c", $h_customer_code, $code ); 
							    		                    $code = str_replace( "g", $h_price_code, $code );
							    		                    $code = str_replace( "a", $operation_code, $code ); 
					    		                            $d_ac_bed_dis=str_replace("ی","ي",$rowd['d_ac_bed_dis']); 
					    		                            $dpf_sarresid =str_replace("/","",$rowdpf['dpf_sarresid']);
					    		                             $ope1='000301';
					    		                             $dpf_num='0';
					    		                            $out4 .='100;'. $year_number .''.$month_number.';'. $year_number .''.$month_number.''.$day_number.';'.$code.''.$h_customer_code.''.$a.''.$a.''.$ope1.';'.$dpf_price.';'. 0 .';'. 1 .';'.$d_ac_bed_dis.''. $sh .''.$ph.''. $gh .';'.$rowdpf['dpf_type'].';'. $dpf_num .';'.  $dpf_sarresid .';'. $rowh['h_pre_amount'] .'';    
					    		                      $out4 .= "\n"; 
					    		                   		
					    		                   	}
				    		                   	else if($rowd['d_pardakht_t']==5){
					    		                   		 //  sayer';
					    		                   		$ope=$operation_code ;
					    		                   		
					    		                   		  $h_customer_code= str_pad($rowh['h_customer_code'], 6, "0", STR_PAD_LEFT);
					    		                   		  $h_price_code= str_pad($rowh['h_price_code'], 6, "0", STR_PAD_LEFT);
					    		                   		  $ope1= str_pad($ope, 6, "0", STR_PAD_LEFT);
							    		                  $code =$rowd['d_ac_bed']; 
							    		                  $a='000000';  
							    		                   
							    		                  $doc_t_name=str_replace("ی","ي",$rowdt['doc_t_name']);
							    		                  $sh='/ سند از نوع  '.$doc_t_name.'/پيش فاكتور شماره '.$pf_code.'/شماره فيش '.$rowdpf['dpf_num'].'/پيش حواله  '.$rowph['ph_code'].'';  
							    		                   // $code = str_replace( "c", $h_customer_code, $code ); 
							    		                    $code = str_replace( "g", $h_price_code, $code );
							    		                    $code = str_replace( "a", $operation_code, $code ); 
					    		                            $d_ac_bed_dis=str_replace("ی","ي",$rowd['d_ac_bed_dis']); 
					    		                            $dpf_sarresid =str_replace("/","",$rowdpf['dpf_sarresid']);
					    		                             $ope1='000301';
					    		                            $out.='100;'. $year_number .''.$month_number.';'. $year_number .''.$month_number.''.$day_number.';'.$code.''.$a.''.$a.''.$a.''.$ope1.';'.$dpf_price.';'. 0 .';'. 1 .';'.$d_ac_bed_dis.''. $sh .''. $gh .';'.$rowdpf['dpf_type'].';'. $rowdpf['dpf_num'] .';'. $dpf_sarresid .';'. $rowh['h_pre_amount'] .'';    
					    		                      $out .= "\n"; 
					    		                   		
					    		                   	}
				    		                   	else if($rowd['d_pardakht_t']==6){
					    		                   		
					    		                   		$ope=$operation_code ;
					    		                   		
					    		                   		  $h_customer_code= str_pad($rowh['h_customer_code'], 6, "0", STR_PAD_LEFT);
					    		                   		  $h_price_code= str_pad($rowh['h_price_code'], 6, "0", STR_PAD_LEFT);
					    		                   		  $ope1= str_pad($ope, 6, "0", STR_PAD_LEFT);
							    		                  $code =$rowd['d_ac_bed']; 
							    		                  $a='000000';  
							    		                   
							    		                  $doc_t_name=str_replace("ی","ي",$rowdt['doc_t_name']);
							    		                  $sh='/ سند از نوع  '.$doc_t_name.'/پيش فاكتور شماره '.$pf_code.'/شماره فيش '.$rowdpf['dpf_num'].'';  
							    		                  $ph='/پيش حواله  '.$rowpf['pf_ph_code'].'';
							    		                   // $code = str_replace( "c", $h_customer_code, $code ); 
							    		                    $code = str_replace( "g", $h_price_code, $code );
							    		                    $code = str_replace( "a", $operation_code, $code ); 
					    		                            $d_ac_bed_dis=str_replace("ی","ي",$rowd['d_ac_bed_dis']); 
					    		                            $dpf_sarresid =str_replace("/","",$rowdpf['dpf_sarresid']);
					    		                             $ope1='000301';
					    		                            $out6 .='100;'. $year_number .''.$month_number.';'. $year_number .''.$month_number.''.$day_number.';'.$code.''.$h_customer_code.''.$a.''.$a.''.$ope1.';'.$dpf_price.';'. 0 .';'. 1 .';'.$d_ac_bed_dis.''. $sh .''.$ph.''. $gh .';'.$rowdpf['dpf_type'].';'. $rowdpf['dpf_num'] .';'.  $dpf_sarresid .';'. $rowh['h_pre_amount'] .'';    
					    		                      $out6 .= "\n"; 
					    		                   		
					    		                   	}
										
				//mishe bedehkar baraye bank  		                   	
					    		                 						
				//end of while avali  baraye havale
						      	               }
				                         }
					//			}
				//begin while for ebtal koli
				  $queryh = "
							 SELECT *  FROM dm_ebtal_h ebt
							 left join dm_havale h
							 on  ebt.ebh_h_id=h.h_id
				
							 WHERE 
								 		ebh_reg_date = '".$doc_date."' 
								 AND 
									    ebh_id_province='".$id_province."'
								 AND
								       h_status ='". 1 ."'
					 
								 AND
								       ebh_type=". 1 ."
				                 AND
				                       h_id_province ='".$id_province."' ";   
								  			  									
				    			$lnkh = mysql_query($queryh);
				    			
				//sqlErr('for bank doc');
				//while asli
								while($rowh = mysql_fetch_assoc($lnkh))
								{    $queryc = "SELECT *  FROM dm_customer 
											           WHERE `code_customer` = '".$rowh['h_customer_code']."'
											           AND
												             customer_code_org = ".$id_province."";
											    $lnkc = mysql_query($queryc);
											    $rowc= mysql_fetch_assoc($lnkc);
											                  																		               
									                $pf_code=$rowh['h_pf_code'];						                				                 
										    		$customer_code=$rowh['h_customer_code'];					                
									                $p_code = $rowh['h_p_code'];
									                $querypf = "
																 SELECT *  FROM dm_pish_factor 			 
																 WHERE 
																 		pf_code = '".$pf_code."' 
																 AND 
																	    pf_id_province='".$id_province."'
																	   
				                                                       AND
																	  pf_type=". 0 ."";
										
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
				//					                print $queryph;	
				                                    $queryacc="SELECT * FROM  dm_operation_acc WHERE      g_id=".$rowph['ph_operation_id']."";
				 								    $lnkacc = mysql_query($queryacc);
				    		                        $rowacc = mysql_fetch_assoc($lnkacc);   		                  
				    		                    	$operation_code=$rowacc['g_code'];
				//mishe bedehkar baraye kala  
				                                    $queryac = "
																 SELECT *  FROM dm_acc_doc 			 
																 WHERE 
																 		ac_status = '". 1 ."' ";													
																	
				    		                    	$lnkac = mysql_query($queryac);    		                    
				    		                    	$rowac = mysql_fetch_assoc($lnkac);
				    		                    	$code=$rowac['ac_code_p_bed']; 
				    		                    	$h_customer_code= str_pad($rowh['h_customer_code'], 6, "0", STR_PAD_LEFT);
				    		                    	
					    		                   	$h_price_code= str_pad($rowh['h_price_code'], 6, "0", STR_PAD_LEFT);
					    		                   	$operation_code1= str_pad($operation_code, 6, "0", STR_PAD_LEFT);
													 $a='000000';	  		                
				    		                    	//$code = str_replace( "c", $rowh['h_customer_code'], $code ); 
					    		                    //$code = str_replace( "g", $rowh['h_p_code'], $code );
					    		                    //$code = str_replace( "a", $operation_code, $code );   
					    		                      $sh=' ابطال كل حواله شماره  '.$rowh['h_code'].' ';
					    		                      $fh=' شماره حواله  '.$rowh['h_code'].' ';
					    		                    $gh='مشتري به نام '.$customer_name.' ';  
					    		                      $g_acc_name='/  از نوع '.$rowacc['g_acc_name'].'';
					    		                   $out.='100;'. $year_number .''.$month_number.';'. $year_number .''.$month_number.''.$day_number.';'.$code.''.$h_customer_code .''.$h_price_code.''. $a .''.$operation_code1.';'.$rowh['h_price'].';'. 0 .';'. 1 .';'.$rowac['ac_topic_p_bed'].''.$sh.''.$g_acc_name.';'. 12 .';'. $rowh['h_code'] .';'. $date[2].''.$date[1].''.$date[0] .';'. $rowh['h_pre_amount'] .''; 
					    		                    $out .="\n";  
					    		                     $code=$rowac['ac_code_p_bes']; 
					    		                    $operation_code1='000301';
				                                   $out1 .='100;'. $year_number .''.$month_number.';'. $year_number .''.$month_number.''.$day_number.';'.$code.''.$h_customer_code  .''.$a.''. $a .''.$operation_code1.';'. 0 .';'.$rowh['h_price'].';'. 2 .';'.$rowac['ac_topic_p_bes'].''.$sh.';'. 12 .';'. $rowh['h_code'] .';'. $date[2].''.$date[1].''.$date[0] .';'. $rowh['h_pre_amount'] .'';
					    		                    
					    	    		            $out1.= "\n"; 
				                                   if($rowh['h_p_add']!=0)
				                                   {
				                                   $ezaf=$rowh['h_p_add']*$rowh['h_p_price'];
				                                   $code1='602015';
					    	    		             $out1 .='100;'. $year_number .''.$month_number.';'. $year_number .''.$month_number.''.$day_number.';'.$code1.''.$h_customer_code  .''.$a.''. $a .''.$a.';'. 0 .';'.$ezaf.';'. 2 .';'.$rowac['ac_topic_p_bes'].''.$sh.';'. 12 .';'. $rowh['h_code'] .';'. $date[2].''.$date[1].''.$date[0] .';'. $rowh['h_pre_amount'] .'';
					    		                    
					    	    		            $out1.= "\n";
				                                   }
				  		            
					    		                      
								}
				//baraye ebtal joze	
									$queryhis = "
											 SELECT *  FROM dm_his_havale 			 
											    WHERE 
													 his_date = '".$doc_date."' 
												AND 
													 his_id_province='".$id_province."'";	    					  									
									    			$lnkhis = mysql_query($queryhis);
				                     //  print $queryhis;                  
					while($rowhis = mysql_fetch_assoc($lnkhis))
					{
									$ebh_h_id=$rowhis['his_id'];
									$h_code=$rowhis['his_h_code'];
									$queryc="SELECT * FROM dm_havale h left join
									                dm_customer cus 
									                on h.h_customer_code=cus.code_customer 
									             WHERE 
									                customer_code_org=".$id_province."
				                                 AND
				                                    h_id_province='".$id_province."'
				                                    AND h_code='".$h_code."'
				                                order by h_code  ";  
				                                
				                                   
						 		       
										$lnkc=mysql_query($queryc);
										print mysql_error();			
										$rowc=mysql_fetch_assoc($lnkc);
										$customer_name=str_replace("ی","ي",$rowc['name_customer']); 
										$customer_name=str_replace("&#1740","", $customer_name);
						                 $customer_name=str_replace(";","", $customer_name);
					    		        $gh='مشتري به نام '.$customer_name.' ';	
									//mohasebe gheymat
									//retrive product
									$lnkp = mysql_query("SELECT * FROM dm_product product
												left join dm_price price
												on product.p_id=price.price_p_id
												 WHERE p_code=".$rowhis['his_p_code']." AND p_price_code=".$rowhis['his_p_pcode']."
												 AND
												  price_id_province=".$id_province."");		
									$rowp = mysql_fetch_assoc($lnkp);
								
									$queryunit="SELECT * FROM dm_prod_det_u 
									             WHERE 
									                unit_prod_id=".$rowhis['his_id_unit']." ";
									        		           
										$lnkunit=mysql_query($queryunit);
										print mysql_error();			
										$rowunit=mysql_fetch_assoc($lnkunit);					  
										$ratio=$rowunit['unit_prod_ratio'];	
									    $pf_code = $rowc['h_pf_code'];
									    		//	print $queryh;
									    			
									     $querypf = "
												 SELECT *  FROM dm_pish_factor 			 
												    WHERE 
														 pf_code = '".$pf_code."' 
					                                ANd
					                                     pf_id_province='".$id_province."'
					                                     AND
													   pf_type=". 0 ."
					                                     ";
													                       									 
									    			$lnkpf = mysql_query($querypf);
									    			$rowpf = mysql_fetch_assoc($lnkpf);
									    			$ph_code=$rowpf['pf_ph_code'];
									    		//	print $querypf;
									    			
									    	$queryph = "
												 SELECT *  FROM dm_pish_havale			 
												    WHERE 
														 ph_code = '".$ph_code."' 
					                                AND
					                                     ph_id_province='".$id_province."'
					                                 
					                                     
					                                     ";
									    //	print $queryph;
													                       									 
									    			$lnkph = mysql_query($queryph);
									    			$rowph = mysql_fetch_assoc($lnkph);
									    			$ph_code=$rowph['ph_code'];
													              
				    		                    	$queryacc="SELECT * FROM  dm_operation_acc WHERE   g_id=".$rowph['ph_operation_id']."";
				 								    $lnkacc = mysql_query($queryacc);
				    		                        $rowacc = mysql_fetch_assoc($lnkacc);   		                  
				    		                    	$operation_code=$rowacc['g_code'];
				//mishe bedehkar baraye kala  
				                                    $queryac = "
																 SELECT *  FROM dm_acc_doc 			 
																 WHERE 
																 		ac_status = '". 1 ."' ";													
																			
				    		                    	$lnkac = mysql_query($queryac); 		                    
				    		                    	$rowac = mysql_fetch_assoc($lnkac);		            
				    		                    	$code=$rowac['ac_code_p_bed'];  
				    		                    	$code1=$rowac['ac_code_p_bes'];   	
				    		                    	$h_customer_code= str_pad($rowc['h_customer_code'], 6, "0", STR_PAD_LEFT);
					    		                   	$h_price_code= str_pad($rowhis['his_p_pcode'], 6, "0", STR_PAD_LEFT);
					    		                   	$operation_code1= str_pad($operation_code, 6, "0", STR_PAD_LEFT);	                
				//    		                    	$code = str_replace("c", $rowh['h_customer_code'], $code ); 
				//	    		                    $code = str_replace("g", $rowh['his_p_code'], $code );
				//	    		                    $code = str_replace("a", $operation_code, $code ); 
				                             $lnkp = mysql_query("SELECT * FROM dm_product product
																	left join dm_price price
																	on product.p_id=price.price_p_id
																	 WHERE p_code=".$rowhis['his_p_code']." AND p_price_code=".$rowhis['his_p_pcode']."
																	 AND
																	  price_id_province=".$id_province."");
				                      
				                             $rowp = mysql_fetch_assoc($lnkp);	
				                                    $sh=' ابطال جزئي شماره حواله '.$h_code.' ';  
				                                     $ac_topic_p_bed=str_replace("ی","ي",$rowac['ac_topic_p_bed']);
				                                     $ac_topic_p_bes=str_replace("ی","ي",$rowac['ac_topic_p_bes']);
				                                     $price_p = (($rowhis['his_eb_amount'])* ($rowp['p_sellprice']));
				                                  //  $price_p =$rowp['p_sellprice'];
				                                   
				                                     $tozih='ابطال حواله '.$h_code;
				                                   
				                                    $a='000000';  
				                                    $si = '000301'; 
				                                    
				                                    $out.='100;'. $year_number .''.$month_number.';'. $year_number .''.$month_number.''.$day_number.';'.$code.''.$h_customer_code .''.$h_price_code.''. $a .''.$operation_code1.';'.$price_p.';'. 0 .';'. 1 .';'.$ac_topic_p_bed .' '. $tozih .''. $gh .';'. 12 .';'. $h_code .';'. $date[2].''.$date[1].''.$date[0] .';'. $rowhis['his_eb_amount'] .'';  
				                                    $out.="\n"; 
				                                    $operation_code1='000301'; 
				                                    $out1 .='100;'. $year_number .''.$month_number.';'. $year_number .''.$month_number.''.$day_number.';'.$code1.''.$h_customer_code.''. $a .''. $a .''. $operation_code1 .';'. 0 .';'.$price_p.';'. 2 .';'.$ac_topic_p_bes.''.$sh.''.$gh.';'. 12 .';'. $h_code .';'. $date[2].''.$date[1].''.$date[0] .';'. $rowhis['his_eb_amount'] .'';  
				                                    $out1 .="\n";  
					                             
				                                   
								}	
												
						    	$out1= iconv("utf-8","windows-1256",$out1);
						    	$out= iconv("utf-8","windows-1256",$out);
						    	$out2= iconv("utf-8","windows-1256",$out2);
						    	
					    		$out4= iconv("utf-8","windows-1256",$out4);
					    	
						    //	$out6= iconv("utf-8","windows-1256",$out6);		
							header("Content-type: application/octet-stream");
							header("Content-Disposition: attachment; filename=\"acc.csv\"");
							echo $out;
							echo  "\n";
							echo $out2;
							echo  "\n";
							echo $out1;
							echo  "\n";
							echo $out4;
							echo  "\n";
							echo $out6;
    	 }

function setstr( $data )
{

	$f=6-strlen( $data );
	 str_pad($input, $f, 0, STR_PAD_LEFT); 
return $data;
}
?>