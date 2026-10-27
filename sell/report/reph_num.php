<?php
 header('Content-Type: text/html; charset=UTF-8');
include_once 'lib/php/jdf.php';
include_once 'lib/php/gen_def.php';

 $firstNumber = isset($_REQUEST['firstNumber']) ? $_REQUEST['firstNumber'] : '';
 $EndNumber = isset($_REQUEST['EndNumber']) ? $_REQUEST['EndNumber'] : '';
 $province_id = isset($_REQUEST['province_id']) ? $_REQUEST['province_id'] : '';
 $year_id = isset($_REQUEST['year_id']) ? $_REQUEST['year_id'] : '';
 $myconn = mysql_connect( "localhost" , "root" , "");
  mysql_select_db("sell",$myconn) or die("Can Not Select DataBase Because: ".
  mysql_error());
$query="SELECT * FROM dm_havale where h_code between  (".$firstNumber." AND  ".$EndNumber.")
                                                                              
            AND
             h_id_province=".$province_id."
            AND
               h_id_year=".$year_id." ";
            
        print $query;   
		$lnk=mysql_query($query);
		print mysql_error();
		if(mysql_affected_rows()>0){
			
			   $outHtml = '<table  border="1" class="list" cellSpacing="6px;" style="width:80%;">';
			   $outHtml .= '
						     <tr class="rw1">
						            <td colspan=15 align=center style="font-weight:bold;"> گزارش حواله</td>						  
						      </tr>
							  <tr class="rw0" style="font-weight:bold;">
									<td align="center" width=5% >رديف</td>
									<td align="center" width=15%>نام کالا</td>							
									<td align="center" width=10%>نوع كالا</td>			
								    <td align="center" width=10%>محل انبار</td>
									<td align="center" width=15%>نام مشتري</td>
									<td align="center" width=15%>دسته بندي مشتري</td>										 							           
								</tr>
							';									
			
		}else{
			
			$outHtml='هيچ اطلاعاتي موجود نيست';
		}
		echo $outHtml;
		echo $out;
		
 ?>