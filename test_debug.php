<?php
require("debug.php");
error_reporting(E_ALL);

$debug = new debuggueur;
$jeu_de_donnee_un[0] = "alpha";
$jeu_de_donnee_un[] = "beta";
$jeu_de_donnee_deux = "gamma";

$vars = get_defined_vars();
$debug->debug($vars);
?>