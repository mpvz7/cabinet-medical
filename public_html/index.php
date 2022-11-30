<?php
session_start();

    //Verification de l'identifiant et du mot de passe
    if(isset($_POST['connexion'])){
        if(!empty($_POST['identifiant']) && !empty($_POST['motDePasse'])){
            
            require('connexionBD.php');
            
            $requeteConnexion = $linkpdo->prepare('SELECT identifiant, motdepasse, nom
                                                    FROM Users
                                                    WHERE identifiant = :id');
                                                    
            $requeteConnexion->execute(array('id'=>$_POST['identifiant']));
            
            $resultat = $requeteConnexion->fetchAll();
            if(count($resultat)==1){
                foreach($resultat as $data){
                    
                    //Cryptage du mot de passe saisie et comparaison dans la base de données
                    if(password_verify($_POST['motDePasse'], $data['motdepasse'])){
                        $_SESSION['identifiant'] = $data['identifiant'];
                        $_SESSION['nomSecretaire'] = $data['nom'];
                        header('Location: accueil.php');
                        exit;
                    }else{
                        $msg = "<p>Mot de passe incorrect.</p>";
                    }
                   
                }
            }else{
                $msg = "<p>Identifiant incorrect.</p>";    
            }
        }else{
            $msg = "<p>Tout les champs ne sont pas remplis.</p>";
        }
    }

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Cabinet PHP</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    </head>

    <body style="background-image: url('../images/background.jpg');
                background-repeat: no-repeat;
                background-position: center center;">
        <div class="container text-center">
            <div class="row">
                <div class="col">
                    <div class="jumbotron bg-info text-light ">
                        <h1>Accueil Cabinet PHP</h1>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col">
                    <div class="card">
                        <h3 class="card-title">Authenfication</h3>
                        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <p>
                                <label>Identifiant</label><br/>
                                <input type="text" name="identifiant"/>
                            </p>
                            <p>
                                <label>Mot de passe</label><br/>
                                <input type="password" name="motDePasse"/>
                            </p>
                            <input class="btn btn-primary" type="submit" name="connexion" value="Connexion"/>
                            <?php
                                if(isset($msg) && !empty($msg)){
                                    echo $msg;
                                }
                             ?>

                           
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
