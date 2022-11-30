<?php
    require('../verifAuth.php');
    //Accueil de la section patient
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Patient</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    </head>
    <body style="background-image: url('../images/background.jpg');
                background-repeat: no-repeat;
                background-position: center center;">
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
                <?php
                    //message si l'ajout ou la modification à bien été pris en compte 
                    if(isset($_SESSION['msg'])){
                        echo '<p>'.$_SESSION['msg'].'</p>';
                        unset($_SESSION['msg']);
                    }
                ?>
            <div class="row">
                <div class="col">
                    <a href="ajouter.php">
                        <div class="card p-5">
                           <h3 class="card-title"><img src="../images/ajouter.png" height= "45em"/>Ajouter</h3>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="rechercher.php">
                        <div class="card p-5">
                           <h3 class="card-title"><img src="../images/rechercher.png" height= "45em"/>Rechercher</h3>
                        </div>
                    </a>
                </div>
        </div>
    </body>
</html>