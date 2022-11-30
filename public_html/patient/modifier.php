<?php
    
    require('../verifAuth.php');
    
    
    if(isset($_POST['modifier']) && isset($_POST['idPatient'])){
        require('../connexionBD.php');
        
        
        //Recuperation des informations du patient que l'on souhaite modifier
        
        $recuperationPatient = $linkpdo->prepare('SELECT * FROM Patient WHERE id_patient = :id_patient');
        
        $recuperationPatient->execute(array(':id_patient'=>$_POST['idPatient']));
        
        while($donnee = $recuperationPatient->fetch()){
            $civilitePatient = $donnee['civilite'];
            $nomPatient = $donnee['nom'];
            $prenomPatient = $donnee['prenom'];
            $adressePatient = $donnee['adresse'];
            $codePostal = $donnee['code_postal'];
            $dateNaissance = $donnee['date_naissance'];
            $lieuNaissance = $donnee['lieu_naissance'];
            $numSecuPatient = $donnee['numero_securite'];
            $idMedecin = $donnee['id_medecin'];
        }
        $idPatient = $_POST['idPatient'];
        
        //Recuperation du nom du medecin référent du patient
        
        if(!is_null($idMedecin)){
            $recuperationNomMedecin = $linkpdo->prepare('SELECT nom FROM Medecin WHERE id_medecin = :id_medecin');
            
            $recuperationNomMedecin->execute(array('id_medecin'=>$idMedecin));
            
            $nom = $recuperationNomMedecin->fetch();
            $nomMedecin = $nom['nom'];
           
        }else{
            $nomMedecin = "Aucun";
        }
    }else{
        header('Location: patient.php');
        exit();
    }
?>

    <!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Modification d'un patient</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    </head>
    <body>
    <?php include('menu.php'); ?>
    <div class="container text-center">
            <div class="row">
                <div class="col">
                    <div class='jumbotron'>
                        <h1>Modification d'un patient</h1>
                         <h2>Secrétaire <?php echo $_SESSION['nomSecretaire']; ?></h2>
                    </div>
                </div>
            </div>
                    
            <div class="row">
                <div class="col text-center">
                    <form method="POST" action="modificationPatient.php">
                        <input type="hidden" name="idPatient" value="<?php echo $idPatient; ?>"/>
                        <p>
                            <label>Civilité</label>
                            <input type="radio" name="civilite" value="Madame" <?php if($civilitePatient == "Madame") echo "checked"; ?>/>
                            <label for="madame">Madame</label>
                            <input type="radio" name="civilite" value="Monsieur" <?php if($civilitePatient == "Monsieur") echo "checked"; ?>/>
                            <label for="monsieur">Monsieur</label>
                        </p>
                        <p>
                            <label>Nom</label>
                            <input type="textfield" name="nom" value="<?php echo $nomPatient; ?>"/>
                        </p>
                        <p>
                            <label>Prénom</label>
                            <input type="textfield" name="prenom" value="<?php echo $prenomPatient; ?>"/>
                        </p>
                        <p>
                            <label>Adresse</label>
                            <input type="textfield" name="adresse" value="<?php echo $adressePatient; ?>"/>
                        </p>
                        <p>
                            <label>Code postal</label>
                            <input type="textfield" name="cp" value="<?php echo $codePostal; ?>" minlength="5" maxlength="5"/>
                        </p>
                        <p>
                            <label>Date de naissance</label>
                            <input type="date" name="date_naissance" value="<?php echo $dateNaissance; ?>"/>
                        </p>
                        <p>
                            <label>Lieu de naissance</label>
                            <input type="textfield" name="lieu_naissance" value="<?php echo $lieuNaissance; ?>"/>
                        </p>
                        <p>
                            <label>Numéro de sécurité sociale</label>
                            <input type="textfield" name="numSecu" value="<?php echo $numSecuPatient; ?>" minlength="13" maxlength="13"/>
                        </p>
                        <p>
                            <label>Médecin référent</label>
                            <select name="medecin_referent">
                                
                                
                                <?php
                                    //Affichage des noms des médecins référents dans le menu déroulant
                                    
                                    echo '<option value="'.$nomMedecin.'" >'.$nomMedecin.'</option>';
                                    
                                    $requeteRecupNomMedecin = $linkpdo->prepare('SELECT id_medecin, nom FROM Medecin WHERE nom != :nomMedecin');
                                    $requeteRecupNomMedecin->execute(array('nomMedecin'=>$nomMedecin));
                                    
                                    while($data = $requeteRecupNomMedecin->fetch()){
                                        echo '<option value="'.$data['id_medecin'].'">'.$data['nom'].'</option>';
                                    }
                                    
                                    if($nomMedecin != "Aucun"){
                                          echo '<option value="Aucun">Aucun</option>';
                                    }
                                    
                                    
                                ?>
                            </select>
                        </p>
                        
                        <input type="submit" class="btn btn-success" name="valider" value="Valider"/>
                        <a style="margin-left: 45%; margin-right:45%;" class="btn btn-primary" href="rechercher.php">Retour</a>
                    </form>
                   
            </div>
        </div>
    </body>
</html>