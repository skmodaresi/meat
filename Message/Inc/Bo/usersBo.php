<?php 
	//include_once $Path=$_SERVER['DOCUMENT_ROOT'].'/'.explode('/',$_SERVER['PHP_SELF'])[1].'/'.explode('/',$_SERVER['PHP_SELF'])[2]."/Inc/GeneralClass/BoMain.php";
	$Path="../Message";
	include_once $Path."/Inc/GeneralClass/BoMain.php";
	class users extends BoMain{
		var $id;
		var $user_id;
		var $user_name;
		var $password_old;
		var $password;
		var $first_name;
		var $last_name;
		var $register_date;
		var $email;
		var $tel;
		var $mobile;
	    var $role_id;
		var $code_ostan;
		var $chkallostan;
		var $first_login;
		///////////////
		var $user_sender;
		var $user_reciever;
		function __construct(){
			$this->KeyName="user_id";
			$this->BoName="users";
			$this->TableName="users";
			$this->DbName="meat";			
		}
	}
?>