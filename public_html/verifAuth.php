<?php
    session_start();
    if(!isset($_SESSION['identifiant']) || empty($_SESSION['identifiant'])){
        header('Location: index.php');
        exit();
    }
?>
