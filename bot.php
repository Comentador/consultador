<?php
    if(session_id() == ""){
        session_start();
    }

    require "BotC.php";

    define("BOT_TOKEN", "876737706:AAEaTouyw83yoHNP7s0gfmcRvx2b-vI9YbA");
    define("API_URL", "https://api.telegram.org/bot".BOT_TOKEN."/");
    define("WEBHOOK_URL", "https://consultador.herokuapp.com/bot.php");

    $conteudo = file_get_contents("php://input");
    $update = json_decode($conteudo, true);
    $mensagem = $update["message"];
    $opc;

    $opc["chat_id"]=$mensagem["chat"]["id"];
    $opc["texto"]=$mensagem["text"];
    $opc["message_id"]=$mensagem["message_id"]+1;
    $_SESSION['message'] = $opc["message_id"];

    $motor = new Divulga();

    if($opc['texto'] === "/start"){
        $motor->sendMessage($opc, "Ola esta 'e a minha primeira mensagem");
        sleep(2);
        $motor->editMessage($opc, "Se voce ainda estiver ai consegue ver a minha outra mensagem");
    }

?>
    
