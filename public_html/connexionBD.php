<?php
    //Configuration du serveur MYSQL
	$server= 'localhost';
	$db= 'id16341456_secretariat';
	$login = 'id16341456_admin';
	$mdp = '1#V2Q&#Wf$HYzr|H';
	
	
    //Connexion au serveur MySQL
	try{
		$linkpdo = new PDO("mysql:host=$server;dbname=$db", $login, $mdp);
		
		
	}catch (Exception $e){
		die('Erreur : '.$e->getMessage());
	}

?>