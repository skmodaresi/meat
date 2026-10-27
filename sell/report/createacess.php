<?php

 $firstDate = !empty($_REQUEST['firstDate']) ? $_REQUEST['firstDate'] :'2010-01-01' ;
 $EndDate = !empty($_REQUEST['EndDate']) ? $_REQUEST['EndDate'] : '2018-03-01';
 $firstDatef = !empty($_REQUEST['firstDatef']) ? $_REQUEST['firstDatef'] :'2010-01-01' ;
 $EndDatef = !empty($_REQUEST['EndDatef']) ? $_REQUEST['EndDatef'] : '2018-03-01';
 $province_id = !empty($_REQUEST['province_id']) ? $_REQUEST['province_id'] : '';
 $year_id = !empty($_REQUEST['year_id']) ? $_REQUEST['year_id'] : '2';		 
 $p_code = !empty($_REQUEST['p_code']) ? $_REQUEST['p_code'] : '-2';
 $p_type = !empty($_REQUEST['p_type']) ? $_REQUEST['p_type'] : '';
 $p_category = !empty($_REQUEST['p_category']) ? $_REQUEST['p_category'] : '';
 $l_id = !empty($_REQUEST['l_id']) ? $_REQUEST['l_id'] : '';
 $code_customer = !empty($_REQUEST['code_customer']) ? $_REQUEST['code_customer'] : '-2';
 $p_price_code = !empty($_REQUEST['p_price_code']) ? $_REQUEST['p_price_code'] : '-2' ;
 $p_pakage_type = !empty($_REQUEST['p_pakage_type']) ? $_REQUEST['p_pakage_type'] : '';
 $p_subsidies = !empty($_REQUEST['p_Subsidies']) ? $_REQUEST['p_Subsidies'] : '-2';
 $city_id = !empty($_REQUEST['city_id']) ? $_REQUEST['city_id'] : '-2';
$file = 'TTMS.mdb';
$newfile = 'TTMS'.$firstDate.''.$EndDate.'.mdb';

//if (!copy($file, $newfile)) {
//    echo "failed to copy $file...\n";
//}
// Microsoft Access


$conn = odbc_connect("Driver={Microsoft Access Driver (*.mdb)};Dbq=darae", $user, $password);
if (!$conn)
  {exit("Connection Failed: " . $conn);}

?>