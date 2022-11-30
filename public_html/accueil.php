<?php
    
    require('verifAuth.php');

    if(!empty($_POST['deconnexion'])){
        unset($_SESSION['identifiant']);
        unset($_SESSION['nom']);
        header('Location: index.php');
        exit();
    }
    
?>

<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Accueil</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    </head>

	
    <body style="background-image: url('../images/background.jpg');
                background-repeat: no-repeat;
                background-position: center center;">
	   <?php
	        include('menu.php');
	   ?>
        
        <div class="container text-center">
            <div class="row ">
                <div class="col">
                    <div class="jumbotron bg-info">
                        <h1>Accueil</h1>
                        <h2>Secrétaire <?php echo $_SESSION['nomSecretaire']; ?></h2>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-title">
                             <a href="patient/patient.php"><h3 class="card-title">Patients</h3></a>
                        </div>
                        <div class="card-body">
                            <a href="patient/ajouter.php"><img src="images/modifier.png" height= "45em"/></a>
                            <a style="padding-left: 15%;" href="patient/rechercher.php"><img src="images/rechercher.png" height="45em"/></a>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-title">
                             <a href="medecin/medecin.php"><h3 class="card-title">Médecins</h3></a>
                        </div>
                        <div class="card-body">
                            <a href="medecin/ajouter.php"><img src="images/modifier.png" height= "45em"/></a>
                            <a style="padding-left: 15%;" href="medecin/rechercher.php"><img src="images/rechercher.png" height="45em"/></a>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-title">
                             <a href="consultation/consultation.php"><h3 class="card-title">Consultations</h3></a>
                        </div>
                        <div class="card-body">
                            <a href="consultation/saisir.php"><img src="images/modifier.png" height= "45em"/></a>
                            <a style="padding-left: 15%;" href="consultation/planningMedecins.php"><img src="images/planning.png" height="45em"/></a>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <a href="./statistiques/statistiques.php">
                        <div class="card">
                            <div class="card-title">
                                <h3 class="card-title">Statistiques</h3>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </body>
</html>

	   
	    
	    
	</body>
</html>