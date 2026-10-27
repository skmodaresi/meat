<?php
require_once __DIR__ . '/mysql_compat.php';
  class phpdbform_db
  {
      private $dbHost;
      private $dbUsername;
      private $dbPassword;
      private $dbName;
	  private $conn;
         
      //public function __construct($host, $mtuserNAME, $pass, $database_name)
      public function __construct($host, $mtuserNAME, $pass)
      {
        $this->dbHost = $host;
        $this->dbUsername = $mtuserNAME;
        $this->dbPassword = $pass;
        //$this->dbName = $database_name;
        $this->connectToDb();
		//$this->selectDb();
      }
	  
	  function show_error($msg)
      {
        global $show_errors;
        print $msg;
        //if($show_errors) print mysql_error();
        print mysql_error();
      }
	  
      public function connectToDb()
      {
	     global $error_msg;
         $this->conn=mysql_connect($this->dbHost, $this->dbUsername, $this->dbPassword);
		 mysql_query("SET NAMES utf8");
		 if(!$this->conn )
		 {
            $error_msg="Could not connect to ".$this->$dbHost;
            $this->show_error('Error in Connect to Database');
            return false;
		 }
      }      
      // public function selectDb()
      // {
		  // mysql_select_db($this->dbName);
      // }
      public function selectDb($database_name)
      {
          $this->dbName = $database_name;
		  mysql_select_db($this->dbName);
      }
	 // Do a query  	  	  
	 public function query($stmt,$msg='')
     {
      global $error_msg;
      $ret = mysql_query($stmt,$this->conn );
      if(!$ret) $this->show_error($error_msg[$msg]);
      return $ret;
     }
     // Close the connection
     function close()
     {
        mysql_close($this->conn);
     }	 
	  public function num_rows($arg1)
      {
        return mysql_num_rows($arg1);             
      }	  
	  public function fetch_array($res)
      {
        return mysql_fetch_array($res);
      }
	  public function fetch_assoc($res)
      {
        return mysql_fetch_assoc($res);
      }
      public function fetch_row( $res )
      {
        return mysql_fetch_row($res);
      }
      function get_from_where($Fields,$TableName,$Where='',$RowCount=0,$Showq=false)
      {
        $q = "select $Fields from $TableName ";
        if (trim($Where)!='')
          $q .= ' where '.$Where;
        $ret = $this->query($q,'');
        if($Showq)
        echo "<div style=\"color:blue\" dir=ltr>$q</div>";
        if($RowCount > 0)
        {
          while($row = $this->fetch_array($ret))
          {
            if(stristr($Fields,',')==False)
             { $ResArr[] = $row[0];
              if($Showq) echo "Yes STRiSTR";}
            else
              {$ResArr[] = $row;
              if($Showq) echo "No STRiSTR";}
          }
        return $ResArr;
        }
        else
        {
          $row = $this->fetch_array($ret);
          if(stristr($Fields,',')==False)
            return $row[0];
          else
            return $row;
        }
      }	  
  }   
?>