<?php

    //Affichage de la recherche par mot clé des patients sous forme de tableau
    
    if(!empty($_POST['motCle'])){
        
        require('../connexionBD.php');
        
        $requetePatient=$linkpdo->prepare("SELECT * 
                                    FROM Patient
                                    WHERE nom LIKE :nom
                                    OR prenom LIKE :prenom
                                    OR adresse LIKE :adresse
                                    OR numero_securite LIKE :numSecu
                                    OR Patient.id_medecin IN (SELECT Medecin.id_medecin 
                                                            FROM Medecin 
                                                            WHERE Medecin.nom = :nomMedecin)");
                                                            
        $requetePatient->execute(array('nom'=>"%".$_POST['motCle']."%",
                                        'adresse'=>"%".$_POST['motCle']."%",
                                        'numSecu'=>"%".$_POST['motCle']."%",
                                        'prenom'=>"%".$_POST['motCle']."%",
                                        'nomMedecin'=>"%".$_POST['motCle']."%")); 
        
        //Vérification qu'au moins 1 patient soit trouvé
        $nbPatientTrouve = $requetePatient->rowCount();
        if($nbPatientTrouve != 0){

            while($donnee = $requetePatient->fetch()){
                $nomMedecinRef = "Aucun";
                
                //Affichage du médecin référent
                if(!is_null($donnee['id_medecin'])){
                    $requeteMedecinRef=$linkpdo->prepare("SELECT Medecin.nom
                                                    FROM Medecin
                                                    WHERE Medecin.id_medecin = :id_medecin");
                                                    
                    $requeteMedecinRef->execute(array('id_medecin'=>$donnee['id_medecin']));
                    
                    while($resultatNomMedecinRef = $requeteMedecinRef->fetch()){
                        $nomMedecinRef = $resultatNomMedecinRef['nom'];
                    }
                }
                
                //Affichage sous forme de tableau ligne par ligne
                echo '<tr>
                        <td>'.$donnee['nom'].'</td>
                        <td>'.$donnee['prenom'].'</td>
                        <td>'.$donnee['adresse'].'</td>
                        <td>'.$donnee['code_postal'].'</td>
                        <td>'.$donnee['date_naissance'].'</td>
                        <td>'.$donnee['lieu_naissance'].'</td>
                        <td>'.$nomMedecinRef.'</td>
                        <td>
                                <form method="POST" action="modifier.php">
                                    <input type="hidden" value='.$donnee['id_patient'].' name="idPatient">
                                    <input class="btn btn-warning" type="submit" value="Modifier" name="modifier">
                                </form>
                            </td>
                            <td>
                                <form method="POST" action="supprimer.php">
                                    <input type="hidden" value='.$donnee['id_patient'].' name="idPatient">
                                    <input class="btn btn-danger" type="submit" value="Supprimer" name="supprimer"
                                    onclick="return confirm(\'Êtes-vous sûr de vouloir supprimer cet utilisateur ?\');">
                                </form>
                            </td>
                         </tr>';
            } 
        }else{
            echo "Aucun patient trouvé.";
        }
        
    }else{
        echo "Remplissez au moins un champs.";
    }
        
    

?>