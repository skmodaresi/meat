<?php
class Db {
	var $BoObj;
	var $Result;
	var $ResultList;
	var $RecordCount;
	private $servername = "localhost";
	//private $username = "root";
	//private $password = "";
	private $username = "user";
	private $password = "xlsdj@#@aHdF";
	private $conn;
	private $Query;
	private $Search;
	private $RefClass;
	function Db( $_BoObj, $_RefClass ) {
		$this->BoObj = $_BoObj;
		$this->RefClass = $_RefClass;
		$this->CreateQuery();
		$this->ConnectDb();
		$this->ChangeDb( $this->BoObj->DbName );
		$this->Result = $this->ExecuteQuery();		 
		if ( ($this->BoObj->BoType == 3)) {			
			$this->CreateList();
		}
		$this->CloseConn();				
    }
	function CreateList() {		
		if ( $this->Result != "" && $this->Result->num_rows > 0 ) {
			$this->ResultList = array();
			$counter = 0;
			while ( $row = $this->Result->fetch_assoc() ) {
				$Ref = new ReflectionClass( $this->BoObj->BoName );
				$Obj = $Ref->newInstance();
                foreach ( $Ref->getProperties() as $ClassProp ) {
					if ( $ClassProp->class != 'BoMain' ) {
						$ClassProp->setAccessible( true );
						if( isset($row[$ClassProp->name])){
							$ClassProp->setValue( $Obj ,$row[ $ClassProp->name]);
						}
					}
				}
				$this->ResultList[ $counter ] = $Obj;
				$counter++;				
			}			
			$this->RecordCount=$this->Result->num_rows;
		} else {
			$this->ResultList = "هیچ موردی یافت نشد";
		}	
	}
	function CreateQuery() {
		switch ( $this->BoObj->BoType ) {
			case 0:
				$this->Query = $this->BoObj->Query; 
				break;
			case 1:
				$this->CreateUpdateQuery();
				break;
			case 2:
				$this->CreateDeleteQuery();
				break;
			case 3:
				$this->Query = $this->BoObj->Query;            
				break;
			case 4:
				$this->CreateDeleteLogQuery();
				break;
			case 5:
			    $this->CreateUpdateOneRowQuery();
				break;	
			case 6:
				$this->CreateDeleteLogRecieverQuery();
				break;
			case 7:
				$this->CreateDeleteLogSenderQuery();
				break;	
		}
	}
    function  CreateUpdateOneRowQuery(){
		$FieldsName = "";
        $this->Query = "update  " . $this->BoObj->TableName . " set comment_read=1 " . $this->WhereStr();		
	}
	 function CreateDeleteLogRecieverQuery() {
		 $FieldsName = "";
         $this->Query = "update  " . $this->BoObj->TableName . " set delete_reciever=1 " . $this->WhereStr();
    }
	 function CreateDeleteLogSenderQuery() {
		 $FieldsName = "";
         $this->Query = "update  " . $this->BoObj->TableName . " set delete_Sender=1 " . $this->WhereStr();
    }	
	function WhereStr() {
		return " where " . $this->BoObj->KeyName . " = " . $this->BoObj->KeyValue;
	}
	function ConnectDb() {
		$this->conn = new mysqli( $this->servername, $this->username, $this->password );
		if ( $this->conn->connect_error ) {
			die( "Connection failed: " . $this->conn->connect_error );
		} else {
            return true;
		}
	}
	function ExecuteQuery() {
		try {
            return $this->conn->query( $this->Query );	
        }catch ( Exception $ex ) {
          return $ex->message;
		}
    }
	function ChangeDb( $DbName ) {
		$this->conn->select_db( $DbName );
		$this->conn->query( "set character_set_results='utf8'" );
	}
	function CloseConn() {
		$this->conn->close();
    }
}
?>