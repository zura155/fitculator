<?php
//კლასის აღწერა
class result
{
	public $status_code; //200 -500
	public $response_dictionary_key;
	public $response_text;
	public $redirect_url;
	
	function get_result($status_code,$response_dictionary_key,$response_text,$redirect_url)
	{
		$this->status_code=$status_code;
		$this->response_dictionary_key=$response_dictionary_key;
		$this->redirect_url=$redirect_url;
		$this->response_text=$response_text;
		//echo $this->response_text;
		//echo json_encode(get_object_vars($this));
		$t1=json_encode(get_object_vars($this),JSON_UNESCAPED_UNICODE );
		$data = json_decode($t1, true);
		echo $t1;
		//echo $t1.",";
		//echo json_decode(json_encode(get_object_vars($this)),true);
	}
}