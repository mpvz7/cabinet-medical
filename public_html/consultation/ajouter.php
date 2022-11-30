<?php
    
    require('../verifAuth.php');
    
    //Formulaire d'ajout d'un rendez-vous suite à une recherche 
?>

<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Consultation</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    </head>

	
	<body>
         <?php
            include('menu.php');
        ?>
        <div class="container text-center">
            <div class="row ">
                <div class="col">
                    <div class="jumbotron bg-info">
                        <h1>Consultation</h1><br/>
                        <h2>Secrétaire <?php echo $_SESSION['nomSecretaire']; ?></h2>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col">
                    <div class="card p-5">
                        
                        
                        <h3 class="card-title">Saisir un rendez-vous</h3>
                       
                        <?php
                                //Recuperation des informations du patients sélectionnés pour effectuer un rendez-vous
                                if(isset($_POST['rdv'])){
                                    if(!empty($_POST['idPatient'])){
                                        
                                        require('../connexionBD.php');
                                        
                                        $requetePatient=$linkpdo->prepare("SELECT id_patient, nom, prenom, id_medecin
                                                                            FROM Patient WHERE id_patient = :id");
                                                                    
                                        $requetePatient->execute(array('id'=>$_POST['idPatient'])); 
                                        
                                        while($donnee = $requetePatient->fetch()){
                                            $nomPatient = $donnee['nom']." | ".$donnee['prenom'];
                                            $idPatient = $donnee['id_patient'];
                                            $nomMedecin = "Aucun";
                                            $idMedecin = 0;
                                            if(!is_null($donnee['id_medecin'])){
                                                $requeteMedecinRef=$linkpdo->prepare("SELECT id_medecin, nom
                                                                                FROM Medecin
                                                                                WHERE id_medecin = :id_medecin");
                                                                                    
                                                $requeteMedecinRef->execute(array('id_medecin'=>$donnee['id_medecin']));
                                                    
                                                while($resultatMedecin = $requeteMedecinRef->fetch()){
                                                    $nomMedecin = $resultatMedecin['nom'];
                                                    $idMedecin = $resultatMedecin['id_medecin'];
                                                }
                                                         
                                                    
                                            }else{
                                                $requeteMedecinDisponible=$linkpdo->prepare("SELECT id_medecin, nom
                                                                                FROM Medecin");
                                                $requeteMedecinDisponible->execute();
                                                $donneRequete = $requeteMedecinDisponible->fetch();
                                                $nomMedecin = $donneRequete['nom'];
                                                $idMedecin = $donneRequete['id_medecin'];
                                            }
                                        }
                                        
                                        echo "<h4>Patient : ".$nomPatient."</h4>";
                                        
                                        
                                        ?>
                                        <form method="post" action="ajoutRDV.php">
                                            
                                            <label>Date du rendez-vous</label>
                                            <input type="date" name="dateRdv" required/>
                                            
                                            <br/>
                                            <label>Heure du rendez-vous</label>
                                            <input type="time" name="heureRdv" min="08:00" max="20:00" required/>
                                            
                                            <br/>
                                            <label>Durée du rendez-vous</label>
                                            <input type="time" name="dureeRdv" min="00:30" value="00:30" required/>
                                            
                                            <br/>
                                            <label>Choix d'un médecin</label>
                                            <select name="idMedecin">
                                                <option value="<?php echo $idMedecin; ?>"><?php echo $nomMedecin; ?></option>
                                                <?php 
                                                    $requeteMedecin=$linkpdo->prepare("SELECT id_medecin, nom
                                                                                FROM Medecin
                                                                                WHERE id_medecin != :id_medecin");
                                                                                
                                                    $requeteMedecin->execute(array('id_medecin'=>$idMedecin));
                                                    
                                                    while($donnee = $requeteMedecin->fetch()){
                                                        
                                                        echo '<option value='.$donnee['id_medecin'].'>'.$donnee['nom'].'</option>';
                                                    }

                                                ?>
                                                
                                            </select>
                                            <input type="hidden" name="idPatient" value="<?php echo $idPatient; ?>"/>
                                            <br/>
                                            
                                            <input class="btn btn-success" type="submit" name="ajouter" value="Ajouter"/>
                                            <input class="btn btn-danger" type="reset" value="Annuler"/>

                                        </form>
                                        
                                        <?php
                                    }
                                }
                            ?>
                             <a style="margin-left: 45%; margin-right:45%;" class="btn btn-primary" href="saisir.php">Retour</a>
                            
                    </div>
                </div>
            </div>
        </div>
    
    
    
    </body>
</html>

	   
	    
	    
	</body>
</html>