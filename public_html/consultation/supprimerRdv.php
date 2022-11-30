<?php
    require('../verifAuth.php');
    //Requete de suppression d'un rendez-vous

    if(isset($_POST['supprimer'])){
        if(!empty($_POST['idRdv'])){
            
            require('../connexionBD.php');
            
            $requeteSupprRdv = $linkpdo->prepare('DELETE FROM Rendez_vous
                                        WHERE id_rdv = :idrdv');
                                        
            $requeteSupprRdv->execute(array('idrdv'=>$_POST['idRdv']));
            
            $_SESSION['msg'] = "Rendez-vous supprimé avec succès";
            header('Location: planningMedecins.php');
            exit;
        }
    }else{
        $_SESSION['msg'] = "Sélectionner un rendez-vous à supprimer";
        header('Location: planningMedecins.php');
        exit;
    }

?>