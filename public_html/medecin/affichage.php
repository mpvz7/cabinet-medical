<?php

    
    if(!empty($_POST['motCle'])){
        
        require('../connexionBD.php');
        
        $rechercheMedecin=$linkpdo->prepare("SELECT * 
                                    FROM Medecin
                                    WHERE nom LIKE :nom
                                    OR prenom LIKE :prenom");
                                                            
        $rechercheMedecin->execute(array('nom'=>"%".$_POST['motCle']."%",
                                        'prenom'=>"%".$_POST['motCle']."%")); 
                                        
        $nbMedecinTrouve = $rechercheMedecin->rowCount();
        if($nbMedecinTrouve != 0){

            while($donnee = $rechercheMedecin->fetch()){
                echo '<tr>
                        <td>'.$donnee['civilite'].'</td>
                        <td>'.$donnee['nom'].'</td>
                        <td>'.$donnee['prenom'].'</td>
                        <td>
                                <form method="POST" action="modifier.php">
                                    <input type="hidden" value='.$donnee['id_medecin'].' name="idMedecin">
                                    <input class="btn btn-warning" type="submit" value="Modifier" name="modifier">
                                </form>
                            </td>
                            <td>
                                <form method="POST" action="supprimer.php">
                                    <input type="hidden" value='.$donnee['id_medecin'].' name="idMedecin">
                                    <input class="btn btn-danger" type="submit" value="Supprimer" name="supprimer" onclick="return confirm(\'Êtes-vous sûr de vouloir supprimer ce médecin ?\');"/>
                                </form>
                            </td>
                         </tr>';
            }
        }else{
            echo "<p>Aucun médecin n'a été trouvé.<p>";
        }
        
    }else{
        echo "<p>Remplissez au moins un champs.</p>";
    }
?>