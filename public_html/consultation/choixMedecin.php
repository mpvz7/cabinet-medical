<?php
    require('../verifAuth.php');
    
    //Choix d'un médecin pour accéder à son planning
    
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Consultations</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link rel="stylesheet" href="styleTableau.css" />

    </head>
    <body>
         <?php
	        include('menu.php');
	   ?>
        <div class="container text-center">
            <div class="row">
                <div class="col">
                    <div class='jumbotron bg-info'>
                        <h1>Consultations</h1>
                        <h2>Secrétaire <?php echo $_SESSION['nomSecretaire']; ?></h2>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col">
                    <div class ="card">
                        <div class="card-title">
                            <h3>Choisir un médecin pour accéder à ses consultations</h3>
                            <?php
                                if(isset($_SESSION['msg'])){
                                    echo "<p>".$_SESSION['msg']."</p>";
                                    unset($_SESSION['msg']);
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <?php 
                    require('../connexionBD.php');
                    
                    //Recupération des medecins et affichage sous forme de bouton
                    $requete1 = $linkpdo->prepare('SELECT id_medecin, nom FROM Medecin');
                    $requete1->execute();
                    
                    while($medecin = $requete1->fetch()){
                        echo '
                        <div class="col">
                            <form method="POST" action="planningHebdo.php">
                                <input type="hidden" value='.$medecin['id_medecin'].' name="id"/>
                                <input type="hidden" value='.$medecin['nom'].' name="nom"/><br/>
                                <input class="btn btn-primary" type="submit" value="'.$medecin['nom'].'" name="access"/>
                            </form>
                        </div>';
                    }
                ?>
            </div>
        </div>
    </body>
</html>