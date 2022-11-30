<?php
    require('../verifAuth.php');
    
    //Page affichant un tableau de recherche d'un patient
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
                        <h1>Patients</h1>
                         <h2>Secrétaire <?php echo $_SESSION['nomSecretaire']; ?></h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="card p-5">
                        <h3 class="card-title">Recherche</h3>
                        <form method="POST" action="<?php $_SERVER['PHP_SELF'] ?>">
                            <p>
                                <label>Mot clé</label></br>
                                <input type="text" name="motCle"/>
                            </p>
                            <p>
                                <input class="btn btn-primary" type="submit" name="recherchePatient" value="Rechercher"/>
                            
                                <input class="btn btn-danger" type="submit" name="annulerRecherche" value="Annuler"/>
                            </p>
                            <?php
                            if(!empty($_SESSION['msg'])){
                                echo $_SESSION['msg'];
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
                        
                        ?>
                        <table class="table">
                            <thead  class="bg-dark text-white">
                                <tr>
                                    <td>Nom</td>
                                    <td>Prenom</td>
                                    <td>Adresse</td>
                                    <td>Code postal</td>
                                    <td>Date de naissance</td>
                                    <td>Lieu de naissance</td>
                                    <td>Médecin réferent</td>
                                    <td>Modifier</td>
                                    <td>Supprimer</td>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    //Fonction pour afficher les 10 derniers patients ajoutés dans la base de données
                                    include('../fonction.php');
                                    
                                    if(isset($_POST['recherchePatient'])){
                                        
                                        include("affichage.php");
                                    }else{
                                        affichage10Patients();
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


</body>
</html>