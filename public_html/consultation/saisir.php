<?php
    require('../verifAuth.php');
    //Page de recherche d'un patient par un mot clé
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Recherche d'un patient</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    </head>
    <body>
        <?php include('menu.php'); ?>
        <div class="container text-center">
            <div class="row">
                <div class="col">
                    <div class='jumbotron bg-info'>
                        <h1>Consultations</h1>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="card p-5">
                        <h3 class="card-title">Rechercher un patient</h3>
                        <form method="POST" action="<?php $_SERVER['PHP_SELF'] ?>">
                            <p>
                                <label>Mot clé</label></br>
                                <input type="text" name="motCle"/>
                            </p>
                            <p>
                                <input class="btn btn-success" type="submit" name="recherchePatient" value="Rechercher"/>
                            
                                <input class="btn btn-danger" type="submit" name="annulerRecherche" value="Annuler"/>
                            </p>
                            <a class="btn btn-primary" href="consultation.php">Retour</a>
                            <?php
                            if(!empty($_SESSION['msg'])){
                                echo '<p>'.$_SESSION['msg'].'</p>';
                                unset($_SESSION['msg']);
                            }
                            ?>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class ="card p-5">
                        <?php
                          
                            if(!empty($_POST['motCle'])){
                                echo '<p>La recherche correspondant à : '.$_POST['motCle'].'</p>';
                            }
                                  
                                if(isset($_POST['recherchePatient'])){
                                    ?>
                                    
                                    <table class="table">
                                        <thead  class="bg-dark text-white">
                                            
                                            <tr>
                                                <td>Nom</td>
                                                <td>Prenom</td>
                                                <td>Date de naissance</td>
                                                <td>Rendez-vous</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                    <?php
                                    include("recherchePatient.php");
                                    
                                    echo'
                                        </tbody>
                                    </table>';
                                    
                                }
                            ?>
                    </div>
                </div>
            </div>
        </div>


</body>
</html>