<?php

include('../verifAuth.php');
//Ajout des informations du patient dans la base de données


if(isset($_POST['ajouter'])){

    if(!empty($_POST['nom']) && 
    !empty($_POST['prenom']) && !empty($_POST['civilite']) &&
    !empty($_POST['adresse']) && !empty($_POST['lieu_naissance'])&&
    !empty($_POST['cp'])&& !empty($_POST['date_naissance']) &&
    !empty($_POST['medecin_referent']) && !empty($_POST['numSecu'])){
        
        include('../connexionBD.php');
        
        //Remplace la valeur du medecin_referent si elle est à Aucun
        if($_POST['medecin_referent'] == "Aucun"){
            $idmedecin = null;
        }else{
            $idmedecin = $_POST['medecin_referent'];
        }
        
        $ajoutPatient = $linkpdo->prepare('INSERT INTO Patient (civilite, nom, prenom, adresse, code_postal, date_naissance, lieu_naissance, numero_securite, id_medecin) 
                                           VALUES (:civilite,
                                                :nom,
                                                :prenom,
                                                :adresse,
                                                :cp,
                                                :dn,
                                                :ln,
                                                :numSecu,
                                                :id_medecin)');
                                                        
        $ajoutPatient->execute(array('civilite'=>$_POST['civilite'],
                                                   'nom'=>$_POST['nom'],
                                                    'prenom'=>$_POST['prenom'],
                                                    'adresse'=>$_POST['adresse'],
                                                    'cp'=>$_POST['cp'],
                                                    'dn'=>$_POST['date_naissance'],
                                                    'ln'=>$_POST['lieu_naissance'],
                                                    'numSecu'=>$_POST['numSecu'],
                                                   'id_medecin'=>$idmedecin));
        
        $_SESSION['msg'] = "Le patient a été ajouté";
        header('Location: patient.php');
        exit();
    }else{
        $_SESSION['msg'] = "<p>Veuillez renseigner tout les champs.<p>";
        header('Location: ajouter.php');
        exit();
    }
}
?>