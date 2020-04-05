<?php
//header('Content-type: text/html; charset=utf-8');
require_once( __DIR__ . "/../Models/Loging.php");
class myexception
{
	private $error_msg;
	private $Loging;
	function __construct($database)
	{
		$this->Loging=new Loging($database);
		//error_reporting(0);
		register_shutdown_function(function () {
			$err = error_get_last();
			if (! is_null($err)) {
				var_dump($err);
				$this->log_exception(json_encode($err));
			}
		});
	}
	public function log_exception($error)
	{
		$this->Loging->process_log(__FUNCTION__,json_encode(get_defined_vars()),"",$error);
	}	
}
?>