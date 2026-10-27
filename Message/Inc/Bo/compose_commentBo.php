<?php
   //include_once $Path=$_SERVER['DOCUMENT_ROOT'].'/'.explode('/',$_SERVER['PHP_SELF'])[1].'/'.explode('/',$_SERVER['PHP_SELF'])[2]."/Inc/GeneralClass/BoMain.php";
	$Path="../Message";
	include_once $Path."/Inc/GeneralClass/BoMain.php";
	class compose_comment extends BoMain{
		var $comment_id;
		var $comment_text;
		var $comment_type;		
		var $user_id_sender;
		var $user_id_reciever;
		var $comment_date_send_shamsi;	
		var $comment_date_send_miladi;	
		var $comment_time_send;
		var $comment_read;
		var $delete_reciever;	
	    var $delete_sender;		
		function compose_comment(){
			$this->KeyName="comment_id";
			$this->BoName="compose_comment";
			$this->TableName="comments";
			$this->DbName="meat";			
		}
	}
?>