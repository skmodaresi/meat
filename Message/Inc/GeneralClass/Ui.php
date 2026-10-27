<?php
//include $Path . "/Inc/GeneralClass/App.php";
include  "App.php";
class Ui{
	var $BoName;
	var $BoObj;
	var $Path;
	var $RefClass;
	function Ui( $_BoName, $_Path ){
		$this->BoName = $_BoName;	
		$this->Path = $_Path;
	}
	function CreateBo(){		
		include_once $this->Path . "/Inc/Bo/" . $this->BoName . "Bo.php";
		$this->RefClass = new ReflectionClass( $this->BoName );
		$this->BoObj = $this->RefClass->newInstance();        
	}
	function FillBo( $PostData ){
		foreach( $this->RefClass->getProperties() as $ClassProp ) {
			if( $ClassProp->class != 'BoMain' ) {
				$ClassProp->setAccessible( true );
				if( isset( $PostData[ $ClassProp->name ] ) ) {
					if(( stripos( "___" . $ClassProp->name, "pass" ) == false ) ) {
						$ClassProp->setValue( $this->BoObj, $PostData[ $ClassProp->name ] );						
					} else {
						$ClassProp->setValue( $this->BoObj, md5( $PostData[ $ClassProp->name ] ) );						
					}
				}			
			}
		}
		$this->BoObj->BoType = ( int )$PostData[ "BoType" ];	
		$this->BoObj->KeyValue = ( int )$PostData[ "BoKeyValue" ];		
	}
	function FillBoWithValue( $PropName, $PropValue ){
		foreach($this->RefClass->getProperties() as $ClassProp ){			
			if($ClassProp->name == $PropName){
				$ClassProp->setAccessible( true );
				if(( stripos( "___" . $PropName, "pass" ) == false)){
					$ClassProp->setValue( $this->BoObj, $PropValue);
				} else {
					$ClassProp->setValue( $this->BoObj, md5( $PropValue ));
				}
			}
		}		
	}
	function SetQuery( $QueryString ){
		$this->BoObj->Query = $QueryString;
		$this->BoObj->BoType = 3;
	}
	function SetQueryinsert( $QueryString ){
		$this->BoObj->Query = $QueryString;
		$this->BoObj->BoType = 0;
	}
	function Send(){
		$App = new App( $this->BoObj, $this->RefClass );
		$App->CheckBussinesRole();
		return $App->Send();
	}
}
?>