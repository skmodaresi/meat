<?php
require_once __DIR__ . '/../../mysql_compat.php';

//--------------------------------------------------------------------------
// This is where you specify your Database connection stuff
//
// mysql_connect -- Open a connection to a MySQL Server /  die -- Alias of exit()
//
//--------------------------------------------------------------------------
$db_name = "sell"; //This is your database Name
$link = mysql_connect("localhost", "root", "") or die("Could not connect to server!");
//This is your table name. This is a one table config to do more table you will need to rework the code.
$table_name = 'dm_product';

$select_db = mysql_select_db($db_name, $link); // mysql_select_db -- Select a MySQL database
mysql_query("SET NAMES 'utf8'");
$query = "SELECT * FROM " . $table_name;
$result = mysql_query($query, $link) or die("Could not complete database query"); //mysql_query -- Send a MySQL query
$num = mysql_num_rows($result); //mysql_num_rows -- Get number of rows in result
$num2=mysql_num_fields($result);
$query="SHOW COLUMNS FROM ".$table_name;
$result1=mysql_query($query);
//$fields=mysql_fetch_array($result1);
$header="";
for ($i = 0; $i < $num2; $i++) { 
	$header .= mysql_field_name($result, $i) . "\t"; 
} 
if ($num != 0) {
//--------------------------------------------------------------------------
// XML Header Tag Goes Here
//--------------------------------------------------------------------------
  $_xml ="<?xml version='1.0' encoding='UTF-8' standalone='yes'?>\r\n";

  $_xml.="<dataroot xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance'>\r\n";
//--------------------------------------------------------------------------
// This while loop loops throught the data found from the above query and
// generates the XML Doc.
//--------------------------------------------------------------------------
  while ($row = mysql_fetch_array($result)) { //mysql_fetch_array --  Fetch a result row as an associative array, a numeric array, or both.
    while ($row=mysql_fetch_array($result)){
  		$_xml .="\t<Table1>\r\n";
  		mysql_data_seek($result1,0);
  		$i=0;
    	while($f=mysql_fetch_array($result1)){
  			if($row[$i]<>'')	$_xml.="\t\t<".$f[0].">".$row[$i]."</".$f[0].">\r\n";
  			$i++;
    	}
    	$_xml.="\t</Table1>\r";
    }
  }
  $_xml.="</dataroot>";
header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=filename.xls"); 
header("Pragma: no-cache"); 
header("Expires: 0"); 
header("Lacation: excel.htm?id=yes");
print "$_xml"; 
} else {
  echo "No Records found";
}

?>