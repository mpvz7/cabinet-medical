<?php
    
    //Requete de suppression d'un médecin dans la table Patient, Medecin et Rendez_Vous
    
    require('../verifAuth.php');

    if(isset($_POST['supprimer']) && !empty($_POST['idMedecin'])){

        require('../connexionBD.php');
        
        $reqSuppressionMedecinReferent = $linkpdo->prepare('UPDATE Patient 
                                                            SET id_medecin = null 
                                                            WHERE id_medecin = :idMedecin');
        $reqSuppressionMedecinReferent->execute(array('idMedecin'=>$_POST['idMedecin']));
        
        $reqSuppressionMedecinRendezVous = $linkpdo->prepare('DELETE FROM Rendez_vous WHERE id_medecin = :idMedecin');
        $reqSuppressionMedecinRendezVous->execute(array('idMedecin'=>$_POST['idMedecin']));
        
        $reqSuppressionMedecin = $linkpdo->prepare('DELETE FROM Medecin WHERE id_medecin = :idMedecin');
        $reqSuppressionMedecin->execute(array('idMedecin'=>$_POST['idMedecin']));
    }
    
    $_SESSION['msg'] = "Les informations du médecin ont bien été supprimées.";
    header('Location: medecin.php');
    exit();
    
?>