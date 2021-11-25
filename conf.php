<?php
$servernimi = "localhost";
$kasutajanimi = "root";
$parool = "";
$andmebaas = "todolist";
$yhendus = new mysqli($servernimi, $kasutajanimi, $parool, $andmebaas);
$yhendus->set_charset('UTF8');
?>