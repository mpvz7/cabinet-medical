<?php

    require('../verifAuth.php');
    
    //Requete de modification du patient
    if(isset($_POST['valider'])){
     
        if(!empty($_POST['idPatient']) && !empty($_POST['nom']) && 
        !empty($_POST['prenom']) && !empty($_POST['civilite']) &&
        !empty($_POST['adresse']) && !empty($_POST['lieu_naissance'])&&
        !empty($_POST['cp'])&& !empty($_POST['date_naissance']) &&
        !empty($_POST['medecin_referent']) && !empty($_POST['numSecu'])){
               
            //Remplace la valeur du medecin referent par null si elle est à Aucun
            if($_POST['medecin_referent'] == "Aucun"){
                $idmedecin = null;
            }else{
                $idmedecin = $_POST['medecin_referent'];
            }
            
            require('../connexionBD.php');
            
            $modificationsInfosPatient = $linkpdo->prepare('UPDATE  Patient 
                                                            SET civilite = :civilite,
                                                                nom = :nom,
                                                                prenom = :prenom,
                                                                adresse = :adresse,
                                                                code_postal = :cp,
                                                                date_naissance = :dn,
                                                                lieu_naissance = :ln,
                                                                numero_securite = :numSecu,
                                                                id_medecin = :id_medecin
                                                            WHERE id_patient = :id_patient');
                                                            
            $modificationsInfosPatient->execute(array('civilite'=>$_POST['civilite'],
                                                       'nom'=>$_POST['nom'],
                                                        'prenom'=>$_POST['prenom'],
                                                        'adresse'=>$_POST['adresse'],
                                                        'cp'=>$_POST['cp'],
                                                        'dn'=>$_POST['date_naissance'],
                                                        'ln'=>$_POST['lieu_naissance'],
                                                        'numSecu'=>$_POST['numSecu'],
                                                       'id_medecin'=>$idmedecin,
                                                       'id_patient'=>$_POST['idPatient']));
            
            
            $_SESSION['msg'] = "Les informations du patient ont été modifiées";
            header('Location: patient.php');
            exit();
                                                            
        
        }else{
            echo "Veuillez renseigner tous les champs.";
        }
        
    }
        


?>