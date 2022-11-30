<?php
    session_start();
    
     if(isset($_POST['ajouter'])){
        if($_POST['dateRdv'] > date("Y-m-d")){
            if(!empty($_POST['idMedecin']) && !empty($_POST['dureeRdv']) && 
               !empty($_POST['heureRdv']) && !empty($_POST['idPatient']) && 
               !empty($_POST['dateRdv'])){
                
                require('../connexionBD.php');
                
                //Vérification dans la BD que le rendez-vous n'est pas déjà pris
                
                $requete1 = $linkpdo->prepare('SELECT * FROM Rendez_vous 
                                                WHERE id_medecin = :idmedecin
                                                AND date_rdv = :daterdv
                                                AND :heure BETWEEN heure AND heure + duree');
                                                
                $requete1->execute(array('idmedecin'=>$_POST['idMedecin'],
                                        'daterdv'=>$_POST['dateRdv'],
                                        'heure'=>$_POST['heureRdv']));
                
                $nbResultat = $requete1->rowCount();
                
                if($nbResultat != 0){
                    
                    $_SESSION['msg'] = "Rendez-vous impossible, médecin déjà en consultation !";
                    header('Location: saisir.php');
                    exit;
                    
                }else{
                    //Ajout dans la BD du rendez-vous
                    $requete2 = $linkpdo->prepare('INSERT INTO Rendez_vous (id_patient, id_medecin, date_rdv, duree, heure)
                                                    VALUES (:idpatient , :idmedecin, :daterdv, :duree, :heure)');
                                                    
                    $requete2->execute(array('idpatient'=>$_POST['idPatient'],
                                            'idmedecin'=>$_POST['idMedecin'],
                                            'daterdv'=>$_POST['dateRdv'],
                                            'duree'=>$_POST['dureeRdv'],
                                            'heure'=>$_POST['heureRdv']));
                
                    $_SESSION['msg'] = "Rendez-vous enregistré avec succès !";
                    header('Location: saisir.php');
                    exit;
                }
            }
            
        }else{
            
            $_SESSION['msg'] = "Date incorrecte !";
            header('Location: saisir.php');
            exit;
        }
    }else{
        header('Location: choixMedecins.php');
        exit;
        
    }
    



?>