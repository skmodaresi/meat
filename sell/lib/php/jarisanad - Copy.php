<?php
require_once __DIR__ . '/../../../mysql_compat.php';
header('Content-Type: text/html; charset=UTF-8');
include_once 'jdf.php';
$myconn = mysql_connect( "localhost" , "user" , "xlsdj@#@aHdF");
mysql_query("SET NAMES 'utf8'",$myconn);

mysql_select_db("sell",$myconn) or die("Can Not Select DataBase Because: ".
mysql_error());

    $doc_date = isset($_REQUEST['doc_date']) ? $_REQUEST['doc_date'] : '';
    $id_province = isset($_REQUEST['id_province']) ? $_REQUEST['id_province'] : '';
    $id_year = isset($_REQUEST['id_year']) ? $_REQUEST['id_year'] : '';

     $date = explode('/', $doc_date);
  
    $doc_date=$date[2].'/'.$date[1].'/'.$date[0] ;
     $yyy=$date[2];
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
            year_id=".$_SESSION['dm_user_profile']['u_year_id']."";	
		$lnk1 = mysql_query($query1);
	//	print $query1;
		$row1= mysql_fetch_assoc($lnk1);
		$year_code=$row1['year_code'];
		$year_number = substr($yyy, -2);
		//$year_number= $yyy;
	     $out='';	
	     $out1='';	
	     $out2='';
	     $out3='';
	     $out4='';	
	     $out8='';
	     $out6='';				
	    $queryh = "
				 SELECT *  FROM dm_havale 			 
					 WHERE 
							h_reg_date = '".$doc_date."' 
					   AND 
							h_id_province='".$id_province."'
						AND 
							h_malicode =0
					  ";		  	    					   
    	 $lnkh = mysql_query($queryh);  
    //	 echo $queryh;
    	 $queryprov = "
				 SELECT *  FROM dm_province			 
					 WHERE 
							province_code = '".$id_province."' 
					  
					  ";		  	    					   
    	 $lnkprov = mysql_query($queryprov);
    	 $rowprov = mysql_fetch_assoc($lnkprov); 
   	$province_sanad= str_pad($rowprov['province_sanad'], 6, "0", STR_PAD_LEFT);
    	 
    	 
    	 
    	$queryhis = "
						 SELECT *  FROM dm_his_havale 			 
						    WHERE 
								 his_date = '".$doc_date."' 
							AND 
								 his_id_province='".$id_province."'";
    	 	 $lnkhis = mysql_query($queryhis); 
    	 if(mysql_num_rows($lnkh)==0 AND mysql_num_rows($lnkhis)==0){
    	 	
    	 	    					  									
				    			
    	 	
    	 	?>
    	 	<script type="text/javascript">
         window.location.href = "khata.php";
        </script>
        <?php
    	 
    	 	
    	 }else{
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
				    		                    	$operation_code1='000000';   
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
				                                 $out1 .='100;'. $year_number .''.$month_number.';'. $year_number .''.$month_number.''.$day_number.';303001'.$type_prod_code .''.$h_price_code .''.$h_customer_code.''.$operation_code1.';'. 0 .';'.$h_price.';'. 2 .';'.$ac_topic_p_bes.''. $sh .''. $fh .'/'.$fph.''. $gh .''. $g_acc_name .''. $moj .';'. 12 .';'. $rowh['h_code'] .';'. $date[2].''.$date[1].''.$date[0] .';'. $rowh['h_pre_amount'] .';';
				                                   $out1 .= "\r\n"; 
				                                   if($rowh['h_p_add']!=0){
				                                    	 $ezaf=$rowh['h_p_add']* $rowh['h_pre_amount'];
				                                    	 $code1='602015';
					                                   	 $out1 .='100;'. $year_number .''.$month_number.';'. $year_number .''.$month_number.''.$day_number.';'.$code1.''.$a .''.$h_price_code.''. $a .''.$operation_code1.';'. 0 .';'.$ezaf.';'. 2 .';'.$ac_topic_p_bes.''. $sh .''. $fh .'/'.$fph.''. $gh .''. $g_acc_name .''. $moj .';'. 12 .';'. $rowh['h_code'] .';'. $date[2].''.$date[1].''.$date[0] .';'. $rowh['h_pre_amount'] .';';
					                                     $out1 .= "\r\n";
				                                   	
				                                   }

				                   
				                                   
				    		                   	}	
				//while baraye poli ke rikhtan 
						$queryh = "
								 SELECT 
								*
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
					    		                   //	echo $rowd['d_pardakht_t'];
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
					    		                   		         $ope1='000000';
					    		                   		        
					    		                   		        $dpf_num= intval($rowdpf['dpf_num']);
					    		                   		        if($rowh['h_amount']==0){
					    		                   		        	$h_amount=$rowh['h_amount'];
					    		                   		        }else{
					    		                   		        	$h_amount=$rowh['h_ebtalk_amount'];
					    		                   		        	
					    		                   		        }
					    		                   		        
				                                      //  $out1.='100;'. $year_number .''.$month_number.';'. $year_number .''.$month_number.''.$day_number.';'.$code.''.$h_customer_code.''.$a.''.$a.''.$ope1.';'. 0 .';'.$dpf_price.';'. 2 .';'.$d_ac_bes_dis.''.$sh.'/'.$fh.'/'.$fph.''.$gh.';'. 4 .';'. $dpf_num .';'. $year_code .''.$date[1].''.$date[0] .';'. $h_amount .'';	
				                                            								
							    		                 // $out1 .= "\r\n";  
							    		                  //jadid
					    		                   	   $out1 .='100;'. $year_number .''.$month_number.';'. $year_number .''.$month_number.''.$day_number.';'.$code.''.$h_customer_code.''.$a.''.$a.''.$ope1.';'.$dpf_price.';'. 0 .';'. 1 .';'.$d_ac_bed_dis.''. $sh .''. $gh .'/'.$fh.';'.$rowdpf['dpf_type'].';'. $dpf_num .';'. $dpf_sarresid .';'. $h_amount .'';    
							    		               $out1 .= "\r\n"; 
							    		             //  $out1 .='100;'. $year_number .''.$month_number.';'. $year_number .''.$month_number.''.$day_number.';303001'.$h_customer_code.''.$a.''.$a.''.$ope1.';'.$dpf_price.';'. 0 .';'. 1 .';'.$d_ac_bed_dis.''. $sh .''. $gh .';'.$rowdpf['dpf_type'].';'. $dpf_num .';'. $dpf_sarresid .';'. $h_amount .'';   
							    		              // $out1 .= "\r\n";       	    		                   		
					    		                   		
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
					    		                   		         $ope1='000000';
					    		                   		        $dpf_num= intval($rowdpf['dpf_num']);
					    		                   		        if($rowh['h_amount']==0){
					    		                   		        	$h_amount=$rowh['h_amount'];
					    		                   		        }else{
					    		                   		        	$h_amount=$rowh['h_ebtalk_amount'];
					    		                   		        	
					    		                   		        }
					    		                   		        
					    		                   		        
							    		                  //jadid
					    		                   	   $out1 .='100;'. $year_number .''.$month_number.';'. $year_number .''.$month_number.''.$day_number.';'.$code.''.$h_customer_code.''.$a.''.$a.''.$ope1.';'. 0 .';'.$dpf_price.';'. 2 .';'.$d_ac_bed_dis.''. $sh .''. $gh .'/'.$fh.';'. 4 .';'. $dpf_num .';'. $year_code .''.$date[1].''.$date[0] .';'. $h_amount .'';	
							    		               $out1 .= "\r\n"; 
							    		             //  $out1 .='100;'. $year_number .''.$month_number.';'. $year_number .''.$month_number.''.$day_number.';303001'.$h_customer_code.''.$a.''.$a.''.$ope1.';'.$dpf_price.';'. 0 .';'. 1 .';'.$d_ac_bed_dis.''. $sh .''. $gh .';'.$rowdpf['dpf_type'].';'. $dpf_num .';'. $dpf_sarresid .';'. $h_amount .'';   
							    		              // $out1 .= "\r\n";       	    		                   		
					    		                   		
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
					    		                            $org= str_pad($rowh['h_id_province'], 6, "0", STR_PAD_LEFT);
					    		                             $doc_b_code= str_pad($rowbanki['doc_b_code'], 6, "0", STR_PAD_LEFT);
					    		                             $type_prod_codek= str_pad($rowhp['type_prod_codek'], 6, "0", STR_PAD_LEFT);
					    		                              $province_sanad= str_pad($province_sanad, 6, "0", STR_PAD_LEFT);
					    		                            
					    		                            $ope1='000000';
					    		                            $naghdi='واريزي فيش';
					    		                            $naghdi .=$rowdpf['dpf_num'];
					    		                            $naghdi=str_replace("ي","ي",$naghdi); 
					    		                   	    if($rowh['h_amount']==0){
					    		                   		        	$h_amount=$rowh['h_amount'];
					    		                   		        }else{
					    		                   		        	$h_amount=$rowh['h_ebtalk_amount'];
					    		                   		        	
					    		                   		        }
					    		                   	   $out2 .='100;'. $year_number .''.$month_number.';'. $year_number .''.$month_number.''.$day_number.';'.$code.''.$doc_b_code.''.$type_prod_codek.''.$province_sanad.''.$ope1.';'.$dpf_price.';'. 0 .';'. 1 .';'.$naghdi.''. $sh .''. $gh .';'.$rowdpf['dpf_type'].';'. $dpf_num .';'. $dpf_sarresid .';'. $h_amount .'';    
					    		                        //    $out2 .='100;'. $year_number .''.$month_number.';'. $year_number .''.$month_number.''.$day_number.';'.$code.''.$a.''.$a.''.$ope1.';'.$dpf_price.';'. 0 .';'. 1 .';'.$d_ac_bed_dis.''. $sh .''. $gh .';'.$rowdpf['dpf_type'].';'. $rowdpf['dpf_num'] .';'. $dpf_sarresid .';'. $h_amount .'';    
					    		                               
					    		                       $out2 .= "\r\n"; 
					    		                      
					    		                       $out1.='100;'. $year_number .''.$month_number.';'. $year_number .''.$month_number.''.$day_number.';301001'.$h_customer_code.''.$a.''.$a.''.$ope1.';'. 0 .';'.$dpf_price.';'. 2 .';'.$d_ac_bes_dis.''.$sh.'/'.$fh.'/'.$fph.''.$gh.';'. 4 .';'. $dpf_num .';'. $year_code .''.$date[1].''.$date[0] .';'. $h_amount .'';	
					    		                      
					    		                       $out1 .= "\r\n";
					    		                   		         $out1 .='100;'. $year_number .''.$month_number.';'. $year_number .''.$month_number.''.$day_number.';301001'.$h_customer_code.''.$a.''.$a.''.$ope1.';'.$dpf_price.';'. 0 .';'. 1 .';'.$d_ac_bed_dis.''. $sh .''. $gh .';'.$rowdpf['dpf_type'].';'. $dpf_num .';'. $dpf_sarresid .';'. $h_amount .'';    
					    		                       $out1 .= "\r\n";
					    		                  //  $out1.='100;'. $year_number .''.$month_number.';'. $year_number .''.$month_number.''.$day_number.';901003'.$a.''.$a.''.$a.''.$ope1.';'. 0 .';'.$a.';'. 2 .';'.$d_ac_bes_dis.''.$a.';'. 0 .';'. $a .';'. $year_code .''.$date[1].''.$date[0] .';'. 0 .'';	
					    		                       
					    		                       $out1 .= "\r\n";
					    		                   //baraye bargasht    
					    		                       $out2 .='100;'. $year_number .''.$month_number.';'. $year_number .''.$month_number.''.$day_number.';901003'.$a.''.$a.''.$a.''.$ope1.';'.$dpf_price.';'. 0 .';'. 1 .';'.$naghdi.''. $sh .''. $gh.';'. 0 .';'. 0 .';'. 0 .';'. 0 .'';    
					    		                        $out2 .= "\r\n";
					    		                       					    		                      
					    		                       $out1.='100;'. $year_number .''.$month_number.';'. $year_number .''.$month_number.''.$day_number.';'.$code.''.$doc_b_code.''.$type_prod_codek.''.$province_sanad.''.$ope1.';'. 0 .';'.$dpf_price.';'. 2 .';'.$naghdi.''.$sh.'/'.$gh.';'. $rowdpf['dpf_type'].';'. $dpf_num .';'. $dpf_sarresid .';'. $h_amount .'';	 
					    		                       
					    		                       $out1 .= "\r\n";
					    		                       
					    		                       
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
					    		                            $ope1='000000';
					    		                            $dpf_num='0';
					    		                            $d_ac_bed_disf=''.$rowdpf['dpf_num'].'بابت دريافت چک به شماره ';
					    		                            $d_ac_bed_diss='بابت تحويل چک خريد مدت دار';
					    		                            $d_ac_bes_disl='بابت چک خريد مدت دار';
					    		                             $d_ac_bes_disl=str_replace("ي","ي",$d_ac_bes_disl);
                                                               $d_ac_bed_diss=str_replace("ي","ي",$d_ac_bed_diss); 
                                                               $d_ac_bed_disf=str_replace("ي","ي",$d_ac_bed_disf);     
					    		                             
					    		                         //  $out4 .='100;'. $year_number .''.$month_number.';'. $year_number .''.$month_number.''.$day_number.';'.$code.''.$dpf_sarresid.''.$h_customer_code.''.$a.''.$ope1.';'.$dpf_price.';'. 0 .';'. 1 .';'.$d_ac_bed_disf.''.$ph.''. $gh .''. $sh .';'.$rowdpf['dpf_type'].';'. $dpf_num .';'.  $dpf_sarresid .';'. $rowh['h_pre_amount'] .'';    
					    		                         // $out4 .= "\r\n"; 
					    		                      //jadid
					    		                        //   $out4 .='100;'. $year_number .''.$month_number.';'. $year_number .''.$month_number.''.$day_number.';301001'.$h_customer_code.''.$a.''.$a.''.$ope1.';'.$dpf_price.';'. 0 .';'. 1 .';'.$d_ac_bed_diss.''.$ph.''. $gh .''. $sh .';'.$rowdpf['dpf_type'].';'. $dpf_num .';'.  $dpf_sarresid .';'. $rowh['h_pre_amount'] .'';    
					    		                        //   $out4 .= "\r\n"; 
					    		                        //  $out4.='100;'. $year_number .''.$month_number.';'. $year_number .''.$month_number.''.$day_number.';303001'.$h_customer_code.''.$a.''.$a.''.$ope1.';'. 0 .';'.$dpf_price.';'. 2 .';'.$d_ac_bes_disl.''.$sh.'/'.$fh.'/'.$fph.''.$gh.';'. 4 .';'. $dpf_num .';'. $year_code .''.$date[1].''.$date[0] .';'. $h_amount .'';	
					    		                         //  $out4 .= "\r\n";
					    		                   		
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
					    		                            $ope1='000000';
					    		                            $dpf_num='0';
					    		                            $d_ac_bed_disf='بابت دريافت چک به شماره ';
					    		                            $d_ac_bed_disf .=$rowdpf['dpf_num'];
					    		                            $d_ac_bed_diss='بابت تحويل چک خريد مدت دار';
					    		                            $d_ac_bes_disl='بابت چک خريد مدت دار';
					    		                            $d_ac_bed_disf=str_replace("ي","ي",$d_ac_bed_disf); 					    		                            
					    		                            
					    		                            $out4 .='100;'. $year_number .''.$month_number.';'. $year_number .''.$month_number.''.$day_number.';'.$code.''.$dpf_sarresid.''.$h_customer_code.''.$a.''.$ope1.';'.$dpf_price.';'. 0 .';'. 1 .';'.$ph.''. $sh .'/'.$d_ac_bed_disf.';'.$rowdpf['dpf_type'].';'. $dpf_num .';'.  $dpf_sarresid .';'. $rowh['h_pre_amount'] .'';    
					    		                           $out4 .= "\r\n"; 
					    		                     // jadid
					    		                    
					    		                         $out4 .='100;'. $year_number .''.$month_number.';'. $year_number .''.$month_number.''.$day_number.';301001'.$h_customer_code.''.$a.''.$a.''.$ope1.';'.$dpf_price.';'. 0 .';'. 1 .';'.$ph.''. $gh .''. $sh .';'.$rowdpf['dpf_type'].';'. $dpf_num .';'.  $dpf_sarresid .';'. $rowh['h_pre_amount'] .'';    
					    		                          $out4 .= "\r\n"; 
					    		                        
					    		                           $out4 .='100;'. $year_number .''.$month_number.';'. $year_number .''.$month_number.''.$day_number.';301001'.$h_customer_code.''.$a.''.$a.''.$ope1.';'. 0 .';'.$dpf_price.';'. 2 .';'.$sh.'/'.$fh.'/'.$fph.''.$gh.';'. 4 .';'. $dpf_num .';'. $year_code .''.$date[1].''.$date[0] .';'. $h_amount .'';	
					    		                           $out4 .= "\r\n";
					    		                   		
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
															 	
							    		             // print $querydps;   	    		                  	    		                     
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
					    		                            $ope1='000000';
                                                            $sharh='بابت تحويل ';
                                                            $sharh .=$rowh['h_amount'];
                                                            $sharh .=' کيلوگرم';
                                                            $sharh=str_replace("ي","ي",$sharh);
                                                            //  echo $rowhp['type_prod_code'];
                                                            $type_prod_code= str_pad($rowhp['type_prod_code'], 6, "0", STR_PAD_LEFT);
                                                                                                               
					    		                           $out8 .='100;'. $year_number .''.$month_number.';'. $year_number .''.$month_number.''.$day_number.';'.$code.''.$rowdps['dps_code'].''.$type_prod_code.''.$h_price_code.''.$a.''.$ope1.';'.$dpf_price.';'. 0 .';'. 1 .';'.$sharh.''. $sh .';'.$rowdpf['dpf_type'].';'. $dpf_num .';'.  $dpf_sarresid .';'. $rowh['h_pre_amount'] .'';    
                                                              
					    		                           $out8 .= "\r\n"; 
					    		                           
					    		                           $out8 .='100;'. $year_number .''.$month_number.';'. $year_number .''.$month_number.''.$day_number.';301001'.$rowh['h_customer_code'].''.$a.''.$a.''.$ope1.';'.$dpf_price.';'. 0 .';'. 1 .';'.$d_ac_bed_dis.''.$ph.''. $gh .''. $sh .';'.$rowdpf['dpf_type'].';'. $dpf_num .';'.  $dpf_sarresid .';'. $rowh['h_pre_amount'] .'';    
					    		                           
					    		                           $out8 .= "\r\n"; 
					    		                           $out8.='100;'. $year_number .''.$month_number.';'. $year_number .''.$month_number.''.$day_number.';301001'.$rowh['h_customer_code'].''.$a.''.$a.''.$ope1.';'. 0 .';'.$dpf_price.';'. 2 .';'.$d_ac_bes_dis.''.$sh.'/'.$fh.'/'.$fph.''.$gh.';'. 4 .';'. $dpf_num .';'. $year_code .''.$date[1].''.$date[0] .';'. $h_amount .'';	
					    		                           $out8 .= "\r\n";
					    		                   		
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
					    		                            $sh=str_replace("ي","ي",$sh);
					    		                            $dpf_sarresid =str_replace("/","",$rowdpf['dpf_sarresid']);
					    		                             $ope1='000000';

					    		                             
					    		                           $type_prod_code= str_pad($rowhp['type_prod_code'], 6, "0", STR_PAD_LEFT);
					    		                           
					    		                           
					    		                            $out8 .='100;'. $year_number .''.$month_number.';'. $year_number .''.$month_number.''.$day_number.';'.$code.''.$type_prod_code.''.$h_price_code.''.$a.''.$ope1.';'.$dpf_price.';'. 0 .';'. 1 .';'.$sharh.''. $sh .';'.$rowdpf['dpf_type'].';'. $dpf_num .';'.  $dpf_sarresid .';'. $rowh['h_pre_amount'] .'';    
                                                              
					    		                           $out8 .= "\r\n"; 
					    		                           
					    		                           $out8 .='100;'. $year_number .''.$month_number.';'. $year_number .''.$month_number.''.$day_number.';301001'.$rowh['h_customer_code'].''.$a.''.$a.''.$ope1.';'.$dpf_price.';'. 0 .';'. 1 .';'.$d_ac_bed_dis.''.$ph.''. $gh .''. $sh .';'.$rowdpf['dpf_type'].';'. $dpf_num .';'.  $dpf_sarresid .';'. $rowh['h_pre_amount'] .'';    
					    		                           
					    		                           $out8 .= "\r\n"; 
					    		                           $out8.='100;'. $year_number .''.$month_number.';'. $year_number .''.$month_number.''.$day_number.';301001'.$rowh['h_customer_code'].''.$a.''.$a.''.$ope1.';'. 0 .';'.$dpf_price.';'. 2 .';'.$d_ac_bes_dis.''.$sh.'/'.$fh.'/'.$fph.''.$gh.';'. 4 .';'. $dpf_num .';'. $year_code .''.$date[1].''.$date[0] .';'. $h_amount .'';	
					    		                           $out8 .= "\r\n";
					    		                   		
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
					    		                    $gh=' به نام '.$customer_name.' ';  
					    		                      $g_acc_name='/  از نوع '.$rowacc['g_acc_name'].'';
					    		                   $out.='100;'. $year_number .''.$month_number.';'. $year_number .''.$month_number.''.$day_number.';'.$code.''.$h_price_code .''.$h_customer_code.''. $a .''.$operation_code1.';'.$rowh['h_price'].';'. 0 .';'. 1 .';'.$rowac['ac_topic_p_bed'].''.$sh.''.$g_acc_name.';'. 12 .';'. $rowh['h_code'] .';'. $date[2].''.$date[1].''.$date[0] .';'. $rowh['h_pre_amount'] .''; 
					    		                    $out .="\r\n";  
					    		                     $code=$rowac['ac_code_p_bes']; 
					    		                    $operation_code1='000000';
				                                   $out1 .='100;'. $year_number .''.$month_number.';'. $year_number .''.$month_number.''.$day_number.';'.$code.''.$h_customer_code  .''.$a.''. $a .''.$operation_code1.';'. 0 .';'.$rowh['h_price'].';'. 2 .';'.$rowac['ac_topic_p_bes'].''.$sh.';'. 12 .';'. $rowh['h_code'] .';'. $date[2].''.$date[1].''.$date[0] .';'. $rowh['h_pre_amount'] .'';
					    		                    
					    	    		            $out1.= "\r\n"; 
				                                   if($rowh['h_p_add']!=0)
				                                   {
				                                   $ezaf=$rowh['h_p_add']*$rowh['h_p_price'];
				                                   $code1='602015';
					    	    		             $out1 .='100;'. $year_number .''.$month_number.';'. $year_number .''.$month_number.''.$day_number.';'.$code1.''.$a  .''.$a.''. $a .''.$a.';'. 0 .';'.$ezaf.';'. 2 .';'.$rowac['ac_topic_p_bes'].''.$sh.';'. 12 .';'. $rowh['h_code'] .';'. $date[2].''.$date[1].''.$date[0] .';'. $rowh['h_pre_amount'] .'';
					    		                    
					    	    		            $out1.= "\r\n";
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
				                // print $queryhis;                  
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
										$customer_name=str_replace("ي","ي",$rowc['name_customer']); 
										$customer_name=str_replace("&#1740","", $customer_name);
						                 $customer_name=str_replace(";","", $customer_name);
						                 
						                 $h_deli_name=str_replace("ي","ي",$rowc['h_deli_name']); 
										$h_deli_name=str_replace("&#1740","", $h_deli_name);
						                 $h_deli_name=str_replace(";","", $h_deli_name);
					    		        $gh=' به نام '.$customer_name.' ';
					    		        $lh=' تحويل گيرنده '.$h_deli_name.' ';	
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
													   pf_type=". 0 ." ";  
													                       									 
									    			$lnkpf = mysql_query($querypf);
									    			$rowpf = mysql_fetch_assoc($lnkpf);
									    			$ph_code=$rowpf['pf_ph_code'];
									    		//	print $querypf;
									    			
									    	$queryph = "
												 SELECT *  FROM dm_pish_havale			 
												    WHERE 
														 ph_code = '".$ph_code."' 
					                                AND
					                                     ph_id_province='".$id_province."' ";
			             
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
					    		                   		$operation_code1= '000000';               
												    		                   	
					    		                   	$lnkp = mysql_query("select * from dm_product product
																	      left join dm_price price
																		   on product.p_id=price.price_p_id
																		 left join dm_prod_det_t prod_t on prod_t.type_prod_id=product.p_type
																			 WHERE p_code=".$rowhis['his_p_code']."  AND p_price_code=".$rowhis['his_p_pcode']."
																			 AND
																			  price_id_province=".$id_province."");
				                          
				                      
				                                    $rowp = mysql_fetch_assoc($lnkp);	
				                                    $sh=' ابطال شماره حواله '.$h_code.' ';  
				                                     $ac_topic_p_bed=str_replace("ي","ي",$rowac['ac_topic_p_bed']);
				                                     $ac_topic_p_bes=str_replace("ي","ي",$rowac['ac_topic_p_bes']);
				                                  	$type_prod_code= str_pad($rowp['type_prod_code'], 6, "0", STR_PAD_LEFT);
				                                     
				                                      $price_p = (($rowhis['his_eb_amount'])* ($rowp['p_sellprice']+$rowc['h_p_add']));
				                                   //  $price_p = (($rowhis['his_eb_amount'])* ($rowp['p_sellprice']));
				                                  //  $price_p =$rowp['p_sellprice'];
				                                   $price_p1 = (($rowhis['his_eb_amount'])* ($rowp['p_sellprice']));
				                                      
				                                     $tozih='ابطال حواله '.$h_code;
				                                   
				                                    $a='000000';  
				                                    $si = '000000'; 
				                                    $code='303001';
				                                    $out.='100;'. $year_number .''.$month_number.';'. $year_number .''.$month_number.''.$day_number.';'.$code.''.$type_prod_code.''. $h_price_code.''.$h_customer_code.''.$operation_code1.';'.$price_p1.';'. 0 .';'. 1 .';'.$ac_topic_p_bed .' '. $tozih .''. $gh .''.$lh.';'. 12 .';'. $h_code .';'. $date[2].''.$date[1].''.$date[0] .';'. $rowhis['his_eb_amount'] .'';  
				                                    $out.="\r\n"; 
				                                    if($rowc['h_p_add'] != 0){
				                                    	 $lh=' هزينه اضافي';
				                                    	 $code1='602015';
				                                    	 $ezaf=($rowc['h_p_add']* $rowhis['his_eb_amount']);
				                                    	 //bardashtam
				                                    //1 beshe
				                                    $out.='100;'. $year_number .''.$month_number.';'. $year_number .''.$month_number.''.$day_number.';'.$code1.''.$a .''.$h_price_code.''. $a .''.$operation_code1.';'.$ezaf.';'. 0 .';'. 1 .';'.$ac_topic_p_bed .' '. $tozih .''. $gh .';'. 12 .';'. $h_code .';'. $date[2].''.$date[1].''.$date[0] .';'. $rowhis['his_eb_amount'] .'';  
				                                    	 $out .="\r\n";
				                                    $out1 .='100;'. $year_number .''.$month_number.';'. $year_number .''.$month_number.''.$day_number.';'.$code1.''.$a .''.$rowc['h_price_code'].''. $a .''.$operation_code1.';'. 0 .';'.$ezaf.' ;'. 2 .';'.$ac_topic_p_bes.''. $sh .''.$lh.''. $tozih .''. $gh .''. $g_acc_name .';'. 12 .' ;'. $rowc['h_code'] .';'. $date[2].''.$date[1].''.$date[0] .';'. $rowc['h_pre_amount'] .';'; 
				                                    	 $out1 .="\r\n";  
				                                    }
				                                    $code='301001';
				                                    $price_p = (($rowhis['his_eb_amount'])* ($rowp['p_sellprice']));
				                                    $operation_code1='000000'; 
				                                  $out1 .='100;'. $year_number .''.$month_number.';'. $year_number .''.$month_number.''.$day_number.';'.$code.''.$h_customer_code.''. $a .''. $a .''. $operation_code1 .';'. 0 .';'.$price_p.';'. 2 .';'.$ac_topic_p_bes.''.$sh.''.$gh.';'. 12 .';'. $h_code .';'. $date[2].''.$date[1].''.$date[0] .';'. $rowhis['his_eb_amount'] .'';  
				                                    
				                                    $out1 .="\r\n"; 
				                                     $ezaf=($rowc['h_p_add']* $rowhis['his_eb_amount']);
				                                
					         
				                                   
								}	
						
//						    $out1= iconv("utf-8","windows-1256",$out1);
//					  	    $out = iconv("utf-8","windows-1256",$out);
//						  	$out2= iconv("utf-8","windows-1256",$out2);
//						    $out3= iconv("utf-8","windows-1256",$out3);
//						    	
//				    		$out4= iconv("utf-8","windows-1256",$out4);
//					    	
//					    	$out6= iconv("utf-8","windows-1256",$out6);	
//					    	$out8= iconv("utf-8","windows-1256",$out8);	
					    	$outkoli=$out1.$out.$out2.$out3.$out4.$out6.$out8;


							$myfile = fopen(__DIR__ . "/sanad/newSanad.csv","w") or die("Unable to open file!");
                            fwrite($myfile,$outkoli);
                            fclose($myfile);
	 mysql_close();
						 if (!file_exists(__DIR__ . "/sanad/alaki.csv")) copy(__DIR__ . "/sanad/newSanad.csv",__DIR__ . "/sanad/alaki.csv");
						 $h_malicode= add2acc(__DIR__ . "/sanad/newSanad.csv" , ';'  , ' 99' , $id_province , '96' , '99');		
                         

						
	$myconn = mysql_connect( "localhost" , "user" , "xlsdj@#@aHdF");

mysql_select_db("sell",$myconn) or die("Can Not Select DataBase Because: ".
mysql_error());					

		$queryupdate = "
						UPDATE dm_havale 
						SET 

							`h_malicode` = ".$h_malicode."
													 
						WHERE 
								h_reg_date = '".$doc_date."' 
						   AND 
								h_id_province='".$id_province."'
							AND 
							h_malicode =0	
								
								";
							
							$lnkupdate = mysql_query($queryupdate);
						//print $queryupdate;
						if(mysql_error()) print mysql_error();	
						
						
						$queryu = "
								UPDATE dm_his_havale 
								SET 
		
									`his_malicode` = ".$h_malicode."
															 
								WHERE 
										
											 his_date = '".$doc_date."' 
										AND 
											 his_id_province='".$id_province."'
										AND
										his_malicode =0	 
											 
											 ";	 
									
									$lnku = mysql_query($queryu);
								//print $queryupdate;
								if(mysql_error()) print mysql_error();	
							$h_malicode .='99/'.$h_malicode;
				echo 'سند مالی ساخته شد';	
				echo 'شماره سند'.$h_malicode;	
						
			 mysql_close();			
							
    	 }

function setstr( $data )
{

	$f=6-strlen( $data );
	 str_pad($input, $f, 0, STR_PAD_LEFT); 
return $data;
}
function add2acc($file, $sep, $user, $org, $year, $pre_code)
{
    
	$db = mysql_connect('localhost', 'user', 'xlsdj@#@aHdF');
    mysql_select_db('mali', $db) or die("Opps some thing went wrong");

    $result = mysql_query("select start_from,end_to from acc_docs where org=$org and year=$year;");


    $row = mysql_fetch_array($result);
    $start_from = $row[0];
    $end_to = $row[1];

    $art_no = 0;
    $fh = fopen($file, 'r');

    while (!feof($fh)) {
        $st = fgets($fh);

        if ($st > '') {
            $token = explode($sep, $st);
			//print_r($token);
            $tdoc_date = $token[2];
            if ($start_from <= $tdoc_date and $tdoc_date <= $end_to and $token[4] + $token[5] > 0) {
                if ($art_no == 0) {
                    $result = mysql_query("select max(tmpdoc_no) from acc_cover where org=$org and year=$year and cut_code=$pre_code;");
                    $row = mysql_fetch_array($result);
                    $wtmpdoc_no = $row[0] + 1;


                    $result = mysql_query("select max(cover_id) from acc_cover where org=$org and year=$year;");
                    $row = mysql_fetch_array($result);
                    $cover_id = $row[0] + 1;


                    $result = mysql_query("insert into acc_cover (org,year,cover_id,segment,cut_code,tmpdoc_no,doc_date,user_id)
                                             values ($org,$year,$cover_id,1,$pre_code,$wtmpdoc_no,$tdoc_date,$user);");
                //  echo  "insert into acc_cover (org,year,cover_id,segment,cut_code,tmpdoc_no,doc_date,user_id)
                                        //     values ($org,$year,$cover_id,1,$pre_code,$wtmpdoc_no,$tdoc_date,$user);";
                }
                $art_no++;
                $cut_code = $pre_code;
                $doc_no = $wtmpdoc_no;
                $doc_date = $token[2];
                $code = $token[3];
                $rls1 = round($token[4]);
                $rls2 = round($token[5]);
                $credit = $token[6];
                $description = $token[7]; // $description=iconv("windows-1256", "utf-8",$description); $description=str_replace('?','ي',$description);
                $ref_kind = $token[8];
                $ref_no = $token[9];
                $ref_date = $token[10];
                $ref_qty = $token[11];
                $totrls1 += $rls1;
                $totrls2 += $rls2;
                $sub3 = substr($code, 6, 6);
                $sub4 = substr($code, 12, 6);
                $sub5 = substr($code, 18, 6);
                $sub6 = substr($code, 24);
                $sub7 = 0;
                $sub8 = 0;

                $result = mysql_query("select max(id) from acc_mali where org=$org and year=$year;");
                $row = mysql_fetch_array($result);
                $id = $row[0] + 1;

                $result = mysql_query("insert into acc_mali (org,year,cover_id,id,art_no,code,sub3,sub4,sub5,sub6,sub7,sub8,description,credit,rls1,rls2,ref_kind,ref_date,ref_qty,ref_no)
                                             values ('$org','$year','$cover_id','$id','$art_no','$code','$sub3','$sub4','$sub5','$sub6','$sub7','$sub8','$description','$credit','$rls1','$rls2','$ref_kind','$ref_date','$ref_qty','$ref_no');");
			    echo mysql_error($db)."\r\n";
            }
        }
    }
    if ($art_no > 0) $result = mysql_query("update acc_cover set art_no=$art_no,rls1=$totrls1,rls2=$totrls2 where org=$org and year=$year and cover_id=$cover_id;");

    $db_close = mysql_close();
    unlink($file);
    return $wtmpdoc_no;
    
    
  
}
?>