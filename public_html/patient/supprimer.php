<?php

    //Suppression d'un patient de la base de données dans la table patient et rendez-vous
    
    require('../verifAuth.php');
   
    
    if(isset($_POST['supprimer']) && !empty($_POST['idPatient'])){
         
        require('../connexionBD.php');
        $reqSuppressionRdvPatient = $linkpdo->prepare('DELETE FROM Rendez_vous WHERE id_patient = :idPatient');
        $reqSuppressionRdvPatient->execute(array('idPatient'=>$_POST['idPatient']));
        
        $reqSuppressionPatient = $linkpdo->prepare('DELETE FROM Patient WHERE id_patient = :idPatient');
        
        $reqSuppressionPatient->execute(array('idPatient'=>$_POST['idPatient']));
        
        $_SESSION['msg'] = "Les informations du patient ont bien été supprimées.";
        header('Location: patient.php');
        exit();
    }
    
   
    
?>