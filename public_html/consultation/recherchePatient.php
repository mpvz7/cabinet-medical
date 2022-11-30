<?php   
    //Recherche d'un patient par un mot clé dans la base de données
    
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
                                        
        $nbPatientTrouve = $requetePatient->rowCount();
        if($nbPatientTrouve != 0){
            

            while($donnee = $requetePatient->fetch()){
                $nomMedecinRef = "Aucun";
               if(!is_null($donnee['id_medecin'])){
                    $requeteMedecinRef=$linkpdo->prepare("SELECT Medecin.nom
                                                    FROM Medecin
                                                    WHERE Medecin.id_medecin = :id_medecin");
                                                    
                    $requeteMedecinRef->execute(array('id_medecin'=>$donnee['id_medecin']));
                    
                    while($resultatNomMedecinRef = $requeteMedecinRef->fetch()){
                        $nomMedecinRef = $resultatNomMedecinRef['nom'];
                    }
                         
                    
                } 
                echo '<tr>
                        <td>'.$donnee['nom'].'</td>
                        <td>'.$donnee['prenom'].'</td>
                        <td>'.$donnee['date_naissance'].'</td>
                            <td>
                                <form method="POST" action="ajouter.php">
                                    <input type="hidden" value='.$donnee['id_patient'].' name="idPatient">
                                    <input type="submit" class="btn btn-primary" value="Consultation" name="rdv"/>
                                </form>
                            </td>
                         </tr>';
            } 
        }else{
            echo "Aucun patient n'a été trouvé.";
        }
        
    }else{
        echo "Remplissez au moins un champs.";
    }
        
    

?>