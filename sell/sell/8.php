<?php
require_once __DIR__ . '/../../mysql_compat.php';
include_once 'includer.php';
$i=1;
$disc='transfer from 92';
for ( ; $i <37; ++$i )
{
	
	      $query = "SELECT * FROM  dm_havale
               
		        where  
					 h_id_province=$i
				AND
					 h_reg_date between '2014-02-20' AND '2014-03-20'
					 
				AND 

				     h_id_year=3
					 
					 "; 	                 	
					$lnk = mysql_query($query);
					print $query;
					while($row= mysql_fetch_assoc($lnk))
					{  
						
							$query2 = "
										UPDATE dm_pish_factor 
										SET 
													`pf_id_year` = '". 3 ."'
													
																		 
												WHERE 
													  pf_id_province=$i 
                                                AND  

                                                      pf_code=".$row['h_pf_code']."";
		
													
											$lnk2 = mysql_query($query2);
											echo $row['pf_id']; 
												echo '/';
									//print $query2;
										if(mysql_error()) print mysql_error();	
						
						
						
						
						
					}
	
	
	
}




