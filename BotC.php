<?php

class Divulga{

	public $str;
	public $id;

	public function __construct(){
		$this->str = new Strings();
	}

	protected function apiRequest($metodo, $parametro){

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, API_URL.$metodo."?");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			"Content-Type" => "multipart/form-data"
		));
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parametro));
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$resultado = curl_exec($ch);
		$info = curl_getinfo($ch);
		curl_close($ch);
	}

	public function sendMessage($opc, $msg){

		$parametro = array(
			"chat_id"=>$opc["chat_id"],
			"disable_web_page_preview"=>1,
			"parse_mode"=>"Markdown",
			"text"=>$msg
		);

		$this->apiRequest("sendMessage", $parametro);
	}

	public function editMessage($opc, $msg){
		$parametro = array(
			"chat_id"=>$opc["chat_id"],
			"text"=>$msg,
			"message_id"=>$_SESSION['message'],
		);

		$this->apiRequest("editMessageText", $parametro);

	}

}


class Strings{

	public $fala = array(
		"primeira"=>"opa fion",
	);
}