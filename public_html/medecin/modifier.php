<?php
    require('../verifAuth.php');
    
    if(isset($_POST['modifier'])){
        if(!empty($_POST['idMedecin']) ){
            require('../connexionBD.php');
            
            //Recuperation des informations du médecin que l'on souhaite modifier
            
            $recuperationMedecin = $linkpdo->prepare('SELECT * FROM Medecin WHERE id_medecin = :id_medecin');
            
            $recuperationMedecin->execute(array(':id_medecin'=>$_POST['idMedecin']));
            
            while($donnee = $recuperationMedecin->fetch()){
                $civiliteMedecin = $donnee['civilite'];
                $nomMedecin = $donnee['nom'];
                $prenomMedecin = $donnee['prenom'];
                $idMedecin = $donnee['id_medecin'];
            }
    
        }else{
         
            header('Location: rechercher.php');
            exit();
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Modification d'un médecin</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    </head>
    <body>
          <?php 
            include('menu.php');
        ?>
    <div class="container text-center">
            <div class="row">
                <div class="col">
                    <div class='jumbotron bg-info'>
                        <h1>Modification d'un médecin</h1>
                        <h2>Secrétaire <?php echo $_SESSION['nomSecretaire']; ?></h2>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col text-center">
                    <form method="POST" action="modificationMedecin.php">
                        <input type="hidden" name="idMedecin" value="<?php echo $idMedecin; ?>"/>
                        <p>
                            <label>Civilité</label>
                            <input type="radio" name="civilite" value="Madame" <?php if($civiliteMedecin == "Madame") echo "checked"; ?>/>
                            <label for="madame">Madame</label>
                            <input type="radio" name="civilite" value="Monsieur" <?php if($civiliteMedecin == "Monsieur") echo "checked"; ?>/>
                            <label for="monsieur">Monsieur</label>
                        </p>
                        <p>
                            <label>Nom</label>
                            <input type="textfield" name="nom" value="<?php echo $nomMedecin; ?>"/>
                        </p>
                        <p>
                            <label>Prénom</label>
                            <input type="textfield" name="prenom" value="<?php echo $prenomMedecin; ?>"/>
                        </p>
                        
                        <input type="hidden" name="idMedecin" value="<?php echo $idMedecin; ?>"/>

                        
                        <input type="submit" class="btn btn-success" name="valider" value="Valider"/>
                    </form>
                    <a style="margin-left: 45%; margin-right:45%;" class="btn btn-primary" href="medecin.php">Retour</a>
                   
            </div>
        </div>
    </body>
</html>