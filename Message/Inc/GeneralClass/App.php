<?php
   //include $Path."/Inc/GeneralClass/Db.php";
	include "Db.php";
	class App{
		var $BoObj;
		var $RefClass;
		function __construct($_BoObj,$_RefClass){
			$this->BoObj=$_BoObj;
			$this->RefClass=$_RefClass;		  
		}
		function CheckBussinesRole(){
		}
		function Send(){
			$Db= new Db($this->BoObj,$this->RefClass);		
			$this->BoObj->ResultList=$Db->ResultList;
			$this->BoObj->RecordCount=$Db->RecordCount;
			return $Db->Result;
		}
	}
?>