<?php

$abertura = fopen("arquivo.txt", "W+");
$conteudo = "Eu criei o arquivo com sucesso";
$escrever = fwrite($conteudo, $abertura);
fclose($abertura);

echo "Arquivo criado com sucesso";

<?
