<?php
require_once __DIR__ . '/../../mysql_compat.php';
include_once 'includer.php';
$i=3;

for ( ; $i <4; ++$i )
{
	
	      $query = "SELECT * FROM  dm_pf_document
               
		        where  
					dpf_id_province=".$i." ";
					 	                 	
					$lnk = mysql_query($query);
				//	print $query;
					while($row= mysql_fetch_assoc($lnk))
					{  
						
					    $querydd = "SELECT * FROM  dm_document
               
							        where  
									d_id=".$row['dpf_d_id']."
									and
									d_id_province=".$i."
										 "; 	                 	
										$lnkdd = mysql_query($querydd);
						
						$rowdd= mysql_fetch_assoc($lnkdd);
						
						if($rowdd['d_pardakht_t']==1){
							
							    $query2 = "
										UPDATE dm_pf_document
										SET 
													`dpf_d_id` = '". 2 ."',
													`dpf_bank` = '". $rowdd['d_bank'] ."'
													
																		 
												WHERE 
													  dpf_id_province=$i 
                                                AND  

                                                      dpf_id=".$row['dpf_id']."";
		
													
											$lnk2 = mysql_query($query2);
																		
										if(mysql_error()) print mysql_error();	
										print $query2;
							
							
							
						}else if($rowdd['d_pardakht_t']==2){
							
						 $query2 = "
										UPDATE dm_pf_document
										SET 
													`dpf_d_id` = '". 3 ."',
													`dpf_bank` = '". $rowdd['d_bank'] ."'
													
																		 
												WHERE 
													  dpf_id_province=$i 
                                                AND  

                                                      dpf_id=".$row['dpf_id']."";
		
													
											$lnk2 = mysql_query($query2);
																		
										if(mysql_error()) print mysql_error();	
										print $query2;	
							
						}else if($rowdd['d_pardakht_t']==3){
							
							 $query2 = "
										UPDATE dm_pf_document
										SET 
													`dpf_d_id` = '". 7 ."',
													`dpf_bank` = '". $rowdd['d_bank'] ."'
													
																		 
												WHERE 
													  dpf_id_province=$i 
                                                AND  

                                                      dpf_id=".$row['dpf_id']."";
		
													
											$lnk2 = mysql_query($query2);
																		
										if(mysql_error()) print mysql_error();	
										print $query2;	
							
							
						}
				    	else if($rowdd['d_pardakht_t']==4){
							
							 $query2 = "
										UPDATE dm_pf_document
										SET 
													`dpf_d_id` = '". 4 ."',
													`dpf_bank` = '". $rowdd['d_bank'] ."'
													
																		 
												WHERE 
													  dpf_id_province=$i 
                                                AND  

                                                      dpf_id=".$row['dpf_id']."";
		
													
											$lnk2 = mysql_query($query2);
																		
										if(mysql_error()) print mysql_error();
										print $query2;
							
							
						}
						
						
						else if($rowdd['d_pardakht_t']==5){
							
							 $query2 = "
										UPDATE dm_pf_document
										SET 
													`dpf_d_id` = '". 5 ."',
													`dpf_bank` = '". $rowdd['d_bank'] ."'
													
																		 
												WHERE 
													  dpf_id_province=$i 
                                                AND  

                                                      dpf_id=".$row['dpf_id']."";
		
													
											$lnk2 = mysql_query($query2);
																		
										if(mysql_error()) print mysql_error();
										print $query2;
							
							
						}
						
						
						
							
						
						
						
						
						
					}
	
	
	
}




