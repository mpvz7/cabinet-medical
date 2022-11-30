<?php
    require('../verifAuth.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Ajout d'un médecin</title>
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
                        <h1>Médecins</h1>
                        <h2>Secrétaire <?php echo $_SESSION['nomSecretaire']; ?></h2>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col text-center">
                    <form method="POST" action="ajoutMedecin.php">
                        <?php
                            //message si tous les champs n'ont pas été remplis
                            if(isset($_SESSION['msg'])){
                                echo $_SESSION['msg'];
                                unset($_SESSION['msg']);
                            }
                        ?>
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
                        <input type="submit" class="btn btn-success" name="ajouter" value="Ajouter"/>
                        <input type="reset" class="btn btn-danger" value="Annuler"/>
                        
                    </form>
                    <a style="margin-left: 45%; margin-right:45%;" class="btn btn-primary" href="medecin.php">Retour</a>

                </div>                
            </div>
        </div>
    </body>
</html>