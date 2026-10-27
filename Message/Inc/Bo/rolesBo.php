<?php 
	//include_once $Path=$_SERVER['DOCUMENT_ROOT'].'/'.explode('/',$_SERVER['PHP_SELF'])[1].'/'.explode('/',$_SERVER['PHP_SELF'])[2]."/Inc/GeneralClass/BoMain.php";
	$Path="../Message";
	include_once $Path."/Inc/GeneralClass/BoMain.php";
	class roles extends BoMain{
		var $id;
		var $role_id;
		var $role_description;
		var $chk_adminsee;
		function __construct(){
			$this->KeyName="role_id";
			$this->BoName="roles";
			$this->TableName="roles";
			$this->DbName="meat";			
		}
	}
?>