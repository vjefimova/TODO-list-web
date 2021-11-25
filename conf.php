<?php
$servernimi = "localhost";
$kasutajanimi = "root";
$parool = "";
$andmebaas = "tasks";
$yhendus = new mysqli($servernimi, $kasutajanimi, $parool, $andmebaas);
$yhendus->set_charset('UTF8');
?>