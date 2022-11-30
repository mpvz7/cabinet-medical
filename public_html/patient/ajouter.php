<?php

    require('../verifAuth.php');
   
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Ajout d'un patient</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
       
    </head>
    <body>
        <?php include('menu.php'); ?>
        
        <div class="container text-center">
            <div class="row">
                <div class="col">
                    <div class='jumbotron bg-info'>
                        <h1>Patients</h1>
                         <h2>Secrétaire <?php echo $_SESSION['nomSecretaire']; ?></h2>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col text-center">
                    <?php     
                            if(isset($_SESSION['msg'])){
                                echo $_SESSION['msg'];
                            }
                        ?>
                    <form method="POST" action="ajoutPatient.php">
                        <p>
                            <label>Civilité :</label>
                            <input type="radio" name="civilite" value="Madame"/>
                            <label for="madame">Madame</label>
                            <input type="radio" name="civilite" value="Monsieur"/>
                            <label for="monsieur">Monsieur</label>
                        </p>
                        <p>
                            <label>Nom</label>
                            <input type="textfield" name="nom" />
                        </p>
                        <p>
                            <label>Prénom</label>
                            <input type="textfield" name="prenom"/>
                        </p>
                        <p>
                            <label>Adresse</label>
                            <input type="textfield" name="adresse"/>
                        </p>
                        <p>
                            <label>Code postal</label>
                            <input type="textfield" name="cp" minlength="5" maxlength="5"/>
                        </p>
                        <p>
                            <label>Date de naissance</label>
                            <input type="date" name="date_naissance"/>
                        </p>
                        <p>
                            <label>Lieu de naissance</label>
                            <input type="textfield" name="lieu_naissance" />
                        </p>
                        <p>
                            <label>Numéro de sécurité sociale</label>
                            <input type="textfield" name="numSecu" minlength="13" maxlength="13"/>
                        </p>
                        <p>
                            <label>Médecin référent</label>
                            <select name="medecin_referent">  
                                <?php
                                    //Affichage des noms des médecins référents dans le menu déroulant
                                    include('../connexionBD.php');
                                    echo '<option value="null">Aucun</option>';
                                    
                                    $requeteRecupNomMedecin = $linkpdo->prepare('SELECT id_medecin, nom FROM Medecin');
                                    $requeteRecupNomMedecin->execute();
                                    
                                    while($data = $requeteRecupNomMedecin->fetch()){
                                        echo '<option value="'.$data['id_medecin'].'">'.$data['nom'].'</option>';
                                    }
                                ?>
                            </select>
                        </p>
                        <input type="submit" class="btn btn-success" name="ajouter" value="Ajouter"/>
                        <input type="reset" class="btn btn-danger" value="Annuler"/>
                    </form>
                    
                     <a style="margin-left: 45%; margin-right:45%;" class="btn btn-primary" href="patient.php">Retour</a>
                </div>                
            </div>
        </div>
    </body>
</html>