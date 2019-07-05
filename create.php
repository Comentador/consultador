<?php
$file = "id.txt";
$buscar = file_get_contents($file);
$adicionar = "583723\n";
file_put_contents($file, $adicionar);

echo file_get_contents("id.txt");

<?
