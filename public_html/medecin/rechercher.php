<?php
    require('../verifAuth.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Recherche d'un médecin</title>
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
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="card p-5">
                        <h3 class="card-title">Recherche</h3>
                        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <p>
                                <label>Mot clé</label></br>
                                <input type="text" name="motCle"/>
                            </p>
                            <p>
                                <input class="btn btn-primary" type="submit" name="rechercheMedecin" value="Rechercher"/>
                            
                                <input class="btn btn-danger" type="submit" name="annulerRecherche" value="Annuler"/>
                            </p>
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
                        ?>
                        <table class="table">
                            <thead  class="bg-dark text-white">
                                <tr>
                                    <td>Civilité</td>
                                    <td>Nom</td>
                                    <td>Prenom</td>
                                    <td>Modifier</td>
                                    <td>Supprimer</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    //Affichage de la recherche sous forme de tableau
                                    
                                    if(isset($_POST['rechercheMedecin'])){
                                        include('affichage.php');
                                    }else{
                                        require('../connexionBD.php');
                                        $afficherMedecins=$linkpdo->prepare("SELECT * FROM Medecin");
                                                                                            
                                        $afficherMedecins->execute(); 
                                        while($data = $afficherMedecins->fetch()){
                                            echo '<tr>
                                                    <td>'.$data['civilite'].'</td>
                                                    <td>'.$data['nom'].'</td>
                                                    <td>'.$data['prenom'].'</td>
                                                    <td>
                                                        <form method="POST" action="modifier.php">
                                                            <input type="hidden" value='.$data['id_medecin'].' name="idMedecin">
                                                            <input class="btn btn-warning" type="submit" value="Modifier" name="modifier">
                                                        </form>
                                                    </td>
                                                    <td>
                                                        <form method="POST" action="supprimer.php">
                                                            <input type="hidden" value='.$data['id_medecin'].' name="idMedecin">
                                                            <input class="btn btn-danger" type="submit" value="Supprimer" name="supprimer"
                                                            onclick="return confirm(\'Êtes-vous sûr de vouloir supprimer ce médecin ?\');"/>
                                                        </form>
                                                    </td>
                                                </tr>';                            
                                        }
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