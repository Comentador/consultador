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
			"message_id"=>$_SESSION["message"],
		);

		$this->apiRequest("editMessageText", $parametro);

	}

	protected function answerCallbackQuery($callback_id, $alert, $time, $text){
		$parametro = array(
			"callback_query_id"=>$callback_id,
			"show_alert"=>$alert,
			"cache_time"=>$time,
			"text"=>$text,
		);

		$this->apiRequest("answerCallbackQuery", $parametro);
	}

	public function callback($opc ,$callback){
		$cb_chat_id = $callback["message"]["chat"]["id"];
		$cb_message_id = $callback["message"]["id"];
		$cb_id = $callback["id"];
		$cb_data = $callback["data"];


		if($cb_data == "avisei"){
			$text = null;
			$this->answerCallbackQuery($cb_id, false, 3, $text);
			$this->editMessage($opc, "Mudei o inline");
		}
		else if($cb_data == "pode"){
			$text = "Seja bem vindo";
			$this->answerCallbackQuery($cb_id, false, 3, $text);
		}
	}

	public function SendInline($opc, $msg, $button){
		$encode = json_encode($button, true);

		$parametro = array(
			"chat_id"=>$opc["chat_id"],
			"text"=>$msg,
			"reply_markup"=>$encode,
			"parse_mode"=>"Markdown",
		);

		$this->apiRequest("sendMessage", $parametro);
	}

}


class Strings{

	public $fala = array(
		"primeira"=>"opa fion",
		"botoes"=>array(
			"inline_keyboard"=>array(
				array(array("text"=>"testando", "callback_data"=>"avisei"), array("text"=>"ainda", "callback_data"=>"pode")),
			)
		),
	);
}
