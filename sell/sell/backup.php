<?php
require_once __DIR__ . '/../../mysql_compat.php';
backup_tables( '192.168.254.16', 'root', 'xlsdj110','sell');
error_reporting(0);

/* backup the db OR just a table */
function backup_tables($host,$user,$pass,$name,$tables = '*')
{
  $link = mysql_connect($host,$user,$pass);
  mysql_select_db($name,$link);
 
  //get all of the tables
  if($tables == '*')
  {
    $tables = array();
    $result = mysql_query('SHOW TABLES');
    while($row = mysql_fetch_row($result))
    {
      $tables[] = $row[0];
    }
  }
  else
  {
    $tables = is_array($tables) ? $tables : explode(',',$tables);
  }
  
  $return = '';
 
  //cycle through
  foreach($tables as $table)
  {
    $result = mysql_query('SELECT * FROM '.$table);
    $num_fields = mysql_num_fields($result);
   
  //  $return.= 'DROP TABLE '.$table.';';
    
    $row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
    $return.= "\n\n".$row2[1].";\n\n";
   
    for ($i = 0; $i < $num_fields; $i++)
    {
      while($row = mysql_fetch_row($result))
      {
        $return.= 'INSERT INTO '.$table.' VALUES(';
        for($j=0; $j<$num_fields; $j++)
        {
          $row[$j] = addslashes($row[$j]);
          $row[$j] = str_replace("\n","\\n",$row[$j]);
          if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
          if ($j<($num_fields-1)) { $return.= ','; }
        }
        $return.= ");\n";
      }
    }
    $return.="\n\n\n";
  }
  //save file
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=backup.sql');
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
   
   
    print( $return);
 
}
?>
