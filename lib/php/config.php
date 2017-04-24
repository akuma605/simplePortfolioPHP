<?php
//fichier de configuration

//demande au php d'activer l'affichage des erreurs
ini_set('display_errors', 'On');
// demande d'affichage de tous les erreurs
ini_set('error_reporting', E_ALL);


//paramétres de création des cookies de 7 jours
$duree    = time()+7*24*3600; 
$chemin   = '/';
$domaine  = $_SERVER['SERVER_NAME'];
$https    = isset($_SERVER['HTTPS']);
$httponly = true;	

?>