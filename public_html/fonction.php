<?php
    
    function affichage10Patients(){
        require('connexionBD.php');
        $requete10Patients=$linkpdo->prepare("SELECT * FROM Patient ORDER BY id_patient DESC");
                                                            
        $requete10Patients->execute(); 
        
        while($data = $requete10Patients->fetch()){
             $nomMedecinRef = "Aucun";
                   if(!is_null($data['id_medecin'])){
                        $requeteMedecinRef=$linkpdo->prepare("SELECT Medecin.nom
                                                        FROM Medecin
                                                        WHERE Medecin.id_medecin = :id_medecin");
                                                        
                        $requeteMedecinRef->execute(array('id_medecin'=>$data['id_medecin']));
                        
                        while($resultatNomMedecinRef = $requeteMedecinRef->fetch()){
                            $nomMedecinRef = $resultatNomMedecinRef['nom'];
                        }
                    }
                    $_SESSION['idPatient'] = $data['id_patient'];
                    echo '<tr>
                            <td>'.$data['nom'].'</td>
                            <td>'.$data['prenom'].'</td>
                            <td>'.$data['adresse'].'</td>
                            <td>'.$data['code_postal'].'</td>
                            <td>'.$data['date_naissance'].'</td>
                            <td>'.$data['lieu_naissance'].'</td>
                            
                            <td>'.$nomMedecinRef.'</td>
                            <td>
                                <form method="POST" action="modifier.php">
                                    <input type="hidden" value='.$data['id_patient'].' name="idPatient">
                                    <input class="btn btn-warning" type="submit" value="Modifier" name="modifier">
                                </form>
                            </td>
                            <td>
                                <form method="POST" action="supprimer.php">
                                    <input type="hidden" value='.$data['id_patient'].' name="idPatient">
                                    <input class="btn btn-danger" type="submit" value="Supprimer" name="supprimer"
                                    onclick="return confirm(\'Êtes-vous sûr de vouloir supprimer cet utilisateur ?\');">
                                </form>
                            </td>
                         </tr>';
        }
    }
    
    
    //Fonction convertir des secondes en heures
    function ConvertisseurTime($Time){
        if($Time < 3600){ 
            $heures = 0; 
            
            if($Time < 60)
                $minutes = 0;
            else
                $minutes = round($Time / 60);

            $secondes = floor($Time % 60); 
        }else{ 
            $heures = round($Time / 3600); 
            $secondes = round($Time % 3600); 
            $minutes = floor($secondes / 60); 
        } 
        
        $TimeFinal = "$heures h $minutes min"; 
        return $TimeFinal;
    }
    
    function inscription(){
        //Inscription requete 
        echo '<div class="row">
                <div class="col">
                    <div class="card">
                        <h3 class="card-title">Inscription</h3>
                        <form method="POST" action='.$_SERVER['PHP_SELF'].'>
                            <p>
                                <label>Identifiant</label><br/>
                                <input type="text" name="identifiantI"/>
                            </p>
                            <p>
                                <label>Mot de passe</label><br/>
                                <input type="password" name="motDePasseI" />
                            </p>
                            <p>
                                <label>Nom</label><br/>
                                <input type="text" name="nomI" maxlength="50"/>
                            </p>
                            <input type="submit" name="inscription" value="Inscription"/>';
                            
                            //Requete inscription
                                
                                if(isset($_POST['inscription']) && !empty($_POST['identifiantI']) && !empty($_POST['motDePasseI']) && !empty($_POST['nomI'])){
                                    
                                    require('connexionBD.php');
                                      
                                    $req = $linkpdo->prepare('INSERT INTO Users (identifiant, motdepasse, nom)
                                                                VALUES(:id, :mdp, :nom)');
                                    
                                    $mdp = password_hash($_POST['motDePasseI'], PASSWORD_DEFAULT);
                                    
                                    $req->execute(array('id'=>$_POST['identifiantI'],
                                                        'mdp'=>$mdp,
                                                        'nom'=>$_POST['nomI']));
                                    
                                    
                                }  
                        echo '  
                        </form>
                    </div>
                </div>
            </div>';
        
    }
        
?>

