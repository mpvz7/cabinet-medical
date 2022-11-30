<?php
    //Requete de modification des informations d'un médecin dans la base de données
    
    require('../verifAuth.php');
    
    if(isset($_POST['valider'])){
     
        if(!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['civilite'])){
               
            require('../connexionBD.php');
            
            $modificationsInfosMedecin = $linkpdo->prepare('UPDATE Medecin 
                                                            SET civilite = :civilite,
                                                                nom = :nom,
                                                                prenom = :prenom
                                                            WHERE id_medecin = :id_medecin');
                                                            
            $modificationsInfosMedecin->execute(array('civilite'=>$_POST['civilite'],
                                                       'nom'=>$_POST['nom'],
                                                        'prenom'=>$_POST['prenom'],
                                                       'id_medecin'=>$_POST['idMedecin']));
            
            
            $_SESSION['msg'] = "Les informations du médecin ont été modifiées";
            header('Location: medecin.php');
            exit();
                                                            
        
        }else{
            $_SESSION['msg'] = "Veuillez renseigner tous les champs.";
            header('Location: rechercher.php');
            exit();
        }
        
    }
        


?>